<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>DELETE STUDENT RECORD</title>
	</head>
	<body>
		<?php

			$id=isset($_GET['id']) ? $_GET['id'] : die("ERROR: ID not found.");

			#Include database connection
			include"config/database.php";

			#Delete Query
			$query = "DELETE FROM contacts WHERE ID=?";
			$stmt = $con -> prepare($query);
			$stmt -> bindParam(1,$id);
			$stmt -> execute();

			if ($stmt -> execute()) {
				header("Location: index.php?action=deleted");
			}
			else
			{
				die("ERROR: Unable to delete the record.");
			}

		?>
	</body>
</html>
