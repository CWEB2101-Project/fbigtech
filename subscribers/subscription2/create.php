<?php
// include configuration file
include 'config/core.php';

// include database connection
include 'config/database.php';

// page header
$page_title="Create a Record";
include_once "layout_head.php";

// if the form was submitted
if($_POST){

	try{

		// insert query
		$query = "INSERT INTO products
					SET name=:name, description=:description, price=:price,
						category_id=:category_id, image=:image, created=:created";

		// prepare query for execution
		$stmt = $con->prepare($query);

		// sanitize
		$name=htmlspecialchars(strip_tags($_POST['name']));
		$description=htmlspecialchars(strip_tags($_POST['description']));
		$price=htmlspecialchars(strip_tags($_POST['price']));
		$image=!empty($_FILES["image"]["name"])
		        ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
		        : "";
		$image=htmlspecialchars(strip_tags($image));
		$category_id=htmlspecialchars(strip_tags($_POST['category_id']));

		// bind the parameters
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':description', $description);
		$stmt->bindParam(':price', $price);
		$stmt->bindParam(':image', $image);
		$stmt->bindParam(':category_id', $category_id);

		// we need the created variable to know when the record was created
		// also, to comply with strict standards: only variables should be passed by reference
		$created=date('Y-m-d H:i:s');
		$stmt->bindParam(':created', $created);

		// Execute the query
		if($stmt->execute()){
			echo "<div class='alert alert-success'>";
				echo "Record was saved.";
			echo "</div>";

			// now, if image is not empty, try to upload the image
			if(!empty($_FILES["image"]["tmp_name"])){

			    // sha1_file() function is used to make a unique file name
			    $target_directory = "uploads/";
			    $target_file = $target_directory . $image;
			    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

			    // error message is empty
			    $file_upload_error_messages="";

				// make sure that file is a real image
				$check = getimagesize($_FILES["image"]["tmp_name"]);
				if($check!==false){
				    // submitted file is an image
				}else{
				    $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
				}

				// make sure certain file types are allowed
				$allowed_file_types=array("jpg", "jpeg", "png", "gif");
				if(!in_array($file_type, $allowed_file_types)){
				    $file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
				}

				// make sure file does not exist
				if(file_exists($target_file)){
				    $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
				}

				// make sure submitted file is not too large, can't be larger than 1 MB
				if($_FILES['image']['size'] > (1024000)){
				    $file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
				}

				// make sure the 'uploads' folder exists
				// if not, create it
				if(!is_dir($target_directory)){
				    mkdir($target_directory, 0777, true);
				}

				// if $file_upload_error_messages is still empty
				if(empty($file_upload_error_messages)){
				    // it means there are no errors, so try to upload the file
				    if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
				        // it means photo was uploaded
				    }else{
				        echo "<div class='alert alert-danger'>";
				            echo "<div>Unable to upload photo.</div>";
				            echo "<div>Update the record to upload photo.</div>";
				        echo "</div>";
				    }
				}

				// if $file_upload_error_messages is NOT empty
				else{
				    // it means there are some errors, so show them to user
				    echo "<div class='alert alert-danger'>";
				        echo "{$file_upload_error_messages}";
				        echo "<div>Update the record to upload photo.</div>";
				    echo "</div>";
				}
			}


		}else{
			echo "<div class='alert alert-success'>";
				echo "Unable to save record. Please try again.";
			echo "</div>";
		}

	}

	// show error if any
	catch(PDOException $exception){
		die('ERROR: ' . $exception->getMessage());
	}
}

?>

<a href='index.php' class='btn btn-primary pull-right margin-bottom-1em'>
	<span class='glyphicon glyphicon-list'></span> Read Records
</a>

<!--we have our html form here where user information will be entered-->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
    <table class='table table-bordered table-hover'>
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' required /></td>
        </tr>
        <tr>
            <td>Description</td>
            <td><textarea type='text' name='description' class='form-control' required></textarea></td>
        </tr>
        <tr>
            <td>Price (&#36;)</td>
            <td>
				<!-- step="0.01" was used so that it can accept number with two decimal places -->
				<input type='number' step="0.01" name='price' class='form-control' required />
			</td>
        </tr>
		<tr>
		    <td>Photo</td>
		    <td><input type="file" name="image" /></td>
		</tr>
        <tr>
            <td>Category</td>
            <td>
			<?php
			// read the categories from the database

			// select all categories
			$query = "SELECT id, name FROM categories ORDER BY name";

			// prepare query statement and execute
			$stmt = $con->prepare( $query );
			$stmt->execute();

			// put them in a select drop-down
			echo "<select class='form-control' name='category_id'>";
				echo "<option>Select category...</option>";

				// loop through the caregories
				while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row_category);
					echo "<option value='{$id}'>{$name}</option>";
				}

			echo "</select>";
			?>
			</td>
		</tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save' class='btn btn-primary' />
            </td>
        </tr>
    </table>
</form>

<?php
// page footer
include_once "layout_foot.php";
?>
