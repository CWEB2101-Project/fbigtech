<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<title>Contacts</title>
	</head>
	<body>
		<div class="container">
			<h3>
				<h2>Contacts</h2>
				<hr>
				<div style='float: left;'>
					<a href="create.php" class="btn-sm btn-primary">Create New</a>
				</div>
			</h3>
				<h5>
				<div>
					<?php
						$action=isset($_GET['action']) ? $_GET['action'] :"";
						if ($action == "deleted")
						{
							echo"<div class='alert-med alert-success'; style='text-align: center';>Record deleted successfully.</div>";
						}
					?>
				</div>
				</h5>
				<br>

			<table class="table">
				<head>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Title</th>
						<th>Created Date</th>
						<th>Modified Date</th>
						<th>Action</th>
					</tr>
				</head>
				<tbody>
					<?php
						#include database connection
						include"config/database.php";

						#select all data
						$query = "SELECT id, Name, Email, Phone, Title, Created_Date, Modified_Date From contacts ORDER by id ASC";
						
						#preparing the statement
						$stmt = $con -> prepare($query);
						$stmt -> execute();

						#$num = $stmt -> rowcount();
						#echo $num;

						while ($row = $stmt -> fetch(PDO :: FETCH_ASSOC))
						{
							extract($row);

							echo"<tr>";
								echo"<td>{$id}</td>";
								echo"<td>{$Name}</td>";
								echo"<td>{$Email}</td>";
								echo"<td>{$Phone}</td>";
								echo"<td>{$Title}</td>";
								echo"<td>{$Created_Date}</td>";
								echo"<td>{$Modified_Date}</td>";
								echo"<td>";

									echo"<a href='read.php?id={$id}' class='btn btn-primary btn-sm m-r-1em'>Read</a>";

			                    	echo"<a href='update.php?id={$id}' class='btn btn-warning btn-sm'>Edit</a>";

			                    	echo"<a href = '#' onclick ='delete_contact({$id});' class='btn btn-danger btn-sm'>Delete</a>";

		                    	echo"</td>";
							echo"</tr>";
						}
					?>
				</tbody>
			</table>
		</div>
		<script>
			function delete_contact(id)
			{
				var answer = confirm("Are you sure you want to delete this record?")
				if (answer)
				{
					window.location="delete.php?id="+id;
				}
			}
		</script>
	</body>
</html>
