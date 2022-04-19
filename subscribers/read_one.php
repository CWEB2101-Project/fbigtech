<?php
// include configuration file
include 'config/core.php';

// include database connection
include 'config/database.php';

// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

// page header
$page_title="Read One Record";
include_once "layout_head.php";

// prepare 'select' query
$query = "SELECT p.id, p.name, p.description, p.price, p.image, p.category_id, c.name as category_name
            FROM products p LEFT JOIN categories c ON p.category_id=c.id
            WHERE p.id=?
            LIMIT 0,1";

$stmt = $con->prepare( $query );

// this is the first question mark
$stmt->bindParam(1, $id);

// execute our query
$stmt->execute();

// store retrieved row to a variable
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// values to fill up our form
$name = htmlspecialchars($row['name'], ENT_QUOTES);
$description = htmlspecialchars($row['description'], ENT_QUOTES);
$price = htmlspecialchars($row['price'], ENT_QUOTES);
$image = htmlspecialchars($row['image'], ENT_QUOTES);
$category_id = htmlspecialchars($row['category_id'], ENT_QUOTES);
$category_name = htmlspecialchars($row['category_name'], ENT_QUOTES);
?>
<!-- to go back to records list -->
<a href='index.php' class='btn btn-primary pull-right margin-bottom-1em'>
	<span class='glyphicon glyphicon-list'></span> Read Records
</a>

<!--we have our html form here where new user information will be entered-->
<table class='table table-bordered table-hover'>
    <tr>
        <td>Name</td>
        <td><?php echo $name;  ?></td>
    </tr>
    <tr>
        <td>Description</td>
        <td><?php echo $description;  ?></td>
    </tr>
    <tr>
        <td>Price</td>
        <td>&#36;<?php echo $price;  ?></td>
    </tr>
    <tr>
        <td>Image</td>
        <td>
            <?php echo $image ? "<img src='uploads/{$image}' style='width:300px;' />" : "No image found.";  ?>
        </td>
    </tr>
    <tr>
        <td>Category</td>
        <td><?php echo $category_name; ?></td>
	</tr>
</table>

<?php
// page footer
include_once "layout_foot.php";
?>
