<?php
// include configuration file
include 'config/core.php';

// include database connection
include 'config/database.php';

// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

// page header
$page_title="Update a Record";
include_once "layout_head.php";

// check if form was submitted
if($_POST){

	try{

		//write query
		//in this case, it seemed like we have so many fields to pass and
		//its kinda better if we'll label them and not use question marks
		//like what we used here
		$query = "UPDATE products
					SET name=:name, description=:description, price=:price, image=:image, category_id=:category_id
					WHERE id=:id";

		//prepare query for excecution
		$stmt = $con->prepare($query);

		// get final value of 'image'
		$image=!empty($_FILES["image"]["name"])
				? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
				: "";
		$image=htmlspecialchars(strip_tags($image));

		// use old 'image' value of not file was browsed
		$image=empty($image) ? htmlspecialchars(strip_tags($_POST['image_hidden'])) : $image;

		// sanitize
        $name=htmlspecialchars(strip_tags($_POST['name']));
        $description=htmlspecialchars(strip_tags($_POST['description']));
        $price=htmlspecialchars(strip_tags($_POST['price']));
		$category_id=htmlspecialchars(strip_tags($_POST['category_id']));
        $id=htmlspecialchars(strip_tags($id));

		// bind the parameters
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':description', $description);
		$stmt->bindParam(':price', $price);
		$stmt->bindParam(':image', $image);
		$stmt->bindParam(':category_id', $category_id);
		$stmt->bindParam(':id', $id);

		// Execute the query
		if($stmt->execute()){
			echo "<div class='alert alert-success'>";
				echo "Record was updated.";
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
			echo "<div class='alert alert-danger'>";
				echo 'Unable to update record. Please try again.';
			echo "</div>";
		}

	}

	// show errors, if any
	catch(PDOException $exception){
		die('ERROR: ' . $exception->getMessage());
	}
}

// read current record's data
try {

	// prepare 'select' query
	$query = "SELECT id, name, description, price, image, category_id FROM products WHERE id=? limit 0,1";
	$stmt = $con->prepare( $query );

	// this is the first question mark
	$stmt->bindParam(1, $id);

	// execute our query
	$stmt->execute();

	// store retrieved row to a variable
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	// values to fill up our form
	$name = $row['name'];
	$description = $row['description'];
	$price = $row['price'];
	$image = $row['image'];
	$category_id = $row['category_id'];
}

// show error
catch(PDOException $exception){
	die('ERROR: ' . $exception->getMessage());
}


?>
<!-- to go back to records list -->
<a href='index.php' class='btn btn-primary pull-right margin-bottom-1em'>
	<span class='glyphicon glyphicon-list'></span> Read Records
</a>

<!--we have our html form here where new user information will be entered-->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post" enctype="multipart/form-data">
    <table class='table table-bordered table-hover'>
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' value='<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>' class='form-control' required /></td>
        </tr>
        <tr>
            <td>Description</td>
            <td>
			<textarea type='text' name='description' class='form-control' required ><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea>
			</td>
        </tr>
        <tr>
            <td>Price (&#36;)</td>
            <td>
				<!-- step="0.01" was used so that it can accept number with two decimal places -->
				<input type='number' step="0.01" name='price' value='<?php echo htmlspecialchars($price, ENT_QUOTES);  ?>' class='form-control' required />
			</td>
        </tr>
		<tr>
			<td>Photo</td>
			<td>
				<!-- value is used if user did not browse a file, this prevents empty 'image' field -->
				<input type="hidden" name="image_hidden" value="<?php echo htmlspecialchars($image, ENT_QUOTES);  ?>" />

				<!-- allow user to browser file -->
				<input type="file" name="image" />
			</td>
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

					// auto select category of this record
					echo $id==$category_id ? "<option value='{$id}' selected>" : "<option value='{$id}'>";
						echo "{$name}";
					echo "</option>";
				}

			echo "</select>";
			?>
			</td>
		</tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save Changes' class='btn btn-primary' />
            </td>
        </tr>
    </table>
</form>

<?php
// page footer
include_once "layout_foot.php";
?>
