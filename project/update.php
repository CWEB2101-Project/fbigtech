<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<title>Edit Record</title>
	</head>
	<body>

		<!-- Container Start -->
		<div class="container">
			<div class="page-header">
				<h3>Edit Record</h3>
			</div>

			<?php

			#include database connection
			include"config/database.php";

			$id = isset($_GET['id']) ? $_GET['id'] : die("ERROR ID not found");

			#Defining the variables
			$Name = "";
			$nameErr = "";
			$isNameValid = false;

			$Email = "";
			$emailErr = "";
			$isEmailValid = false;

			$Phone = "";
			$phoneErr = "";
			$isPhoneValid = false;

			$Title = "";
			$titleErr = "";
			$isTitleValid = false;

			if($_POST)
			{
				try
				{
					#Create query to update the record
					$query= "UPDATE contacts SET Name=?, Email=?, Phone=?, Title=? WHERE id=?";

					#Prepare query for execution
					$stmt = $con -> prepare($query);

					$name=sanitize_input($_POST['name']);
					$email=sanitize_input($_POST['email']);
					$phone=sanitize_input($_POST['phone']);
					$title=sanitize_input($_POST['title']);
					$id=sanitize_input($id);

					#Bind the parameters
					$stmt -> bindParam(1,$name);
					$stmt -> bindParam(3,$email);
					$stmt -> bindParam(4,$phone);
					$stmt -> bindParam(2,$title);
					$stmt -> bindParam(5,$id);

					#Execute the query
					if($stmt -> execute())
					{
						echo "<div class='alert alert-success'>Record updated successfully</div>";
						header("Location: index.php?action=updated");
					}
					else
					{
						echo "<div class='alert alert-danger'>Unable to update the record. Please verify all information is correct then try again.</div>";
					}
				}
				catch (PDOException $ER)
				{
					echo "ERROR: ".$ER -> getMessage(); 
				}
			}

			try	{
				#Prepare Select Query
				$query = "SELECT id, Name, Email, Phone, Title From contacts WHERE id=? LIMIT 0,1";
				$stmt = $con -> prepare($query);

				$stmt -> bindParam(1,$id);

				$stmt -> execute();

				$row = $stmt -> fetch(PDO :: FETCH_ASSOC);

				/*This was used to verify the code thus far works.
				echo "<pre>";
				print_r($row);
				echo "</pre>";*/

				#Values to fill up
				$Name = $row['Name'];
				$Email = $row['Email'];
				$Phone = $row['Phone'];
				$Title = $row["Title"];

			}
			catch(PDOException $ER)
			{
				echo "ERROR: ".$ER -> getMessage(); 
			}

			function sanitize_input ($data)
				{
					$data = trim($data);
					$data = stripslashes($data);
					$data = htmlspecialchars($data);
					return $data;
				}
			?>

				<form action="update.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
				<table class="table table-hover table-responsive table-bordered">
					<tr>
					<td>Name</td>
						<td>
							<input type="text" name="name" class="form-control" value="<?php echo $Name ;?>">
						</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>
							<input type="text" name="email" class="form-control" value="<?php echo $Email;?>">
						</td>
					</tr>
					<tr>
						<td>Phone</td>
						<td>
							<input type="text" name="phone" class="form-control" value="<?php echo $Phone;?>">
						</td>
					</tr>
					<tr>
						<td>Title</td>
						<td>
							<input type="text" name="title" class="form-control" value="<?php echo $Title ;?>">
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" class="btn btn-primary">
						<a href="index.php" class="btn btn-danger">Home</a></td>
					</tr>

				</table>
			</form>
		</div>
		<!-- Container End -->
	</body>
</html>