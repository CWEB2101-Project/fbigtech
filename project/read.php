<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Read</title>
	</head>
	<body>
		<?php
			#include database connection
			include"config/database.php";

			$id = isset($_GET['id']) ?$_GET['id'] : die("ERROR: ID not found.");

			#echo $id;

			#Read current record's data.
			try
			{
				#Prepare select query
				$query = "SELECT id, Name, Name, Email, Phone, Title, Title, Created_date, Modified_date, From students WHERE id=? LIMIT 0,1";

				$stmt = $con -> prepare($query);
			}
			#Show error
			catch(PDOException $e)
			{
				die("Error : ".$e -> getMessage());
			}
		?>
	</body>
</html>