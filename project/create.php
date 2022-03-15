<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<style type="text/css">
			.Error {color:red;}
		</style>
		<title>PDO: Record contacts</title>
	</head>
	<body>
		<!-- Container Start -->
		<div class="container">
			<div class="page-header">
				<h3>Contacts List</h3>
			</div>
			<?php

				#include database connection
				include"config/database.php";

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

				if ($_SERVER['REQUEST_METHOD']=="POST"){
					#Validate empty or less than 6 characters
					if (empty($_POST[''])){
						$fnameErr="Name is required";
						$isNameValid = false;
					}
					else
					{
						#Check if name only contains letters and whitespace.
						$Fname=sanitize_input($_POST['name']);
						if (!preg_match("/^[a-zA-Z-' ]*$/", $Name)) {
							$fnameErr="Only letters and whitespace allowed";
							$isFnameValid = false;
						}
						else
						{
							$isFnameValid = true;
						}
					}
					
					
					#Validate email
					if (empty($_POST['email'])) {
						$emailErr="Email is required";
						$isEmailValid = false;
					}
					else
					{
						$Email=sanitize_input($_POST['email']);
						if (!preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/", $Email)){
							$emailErr="Must enter a valid email. Example: firstname.lastname@domain.com";
							$isEmailValid = false;
						}
						else {
							$isEmailValid = true;
						}
					}

					#Validate phone number
					if (empty($_POST['phone'])) {
						$phoneErr="Phone number is required";
						$isPhoneValid = false;
					}
					else
					{
						$Phone=sanitize_input($_POST['phone']);
						if (!preg_match("/^[+]?[1-9][0-9]{9,14}$/", $Phone)) {
							$phoneErr="Must enter a valid phone number.";
							$isPhoneValid = false;
						}
						else
						{
							$isPhoneValid = true;
						}
					}

					#Validate Title
					if (empty($_POST['title'])) {
						$lnameErr="Title is required";
						$isLnameValid = false;
					}
					else
					{
						#Check if name only contains letters and whitespace.
						$Title=sanitize_input($_POST['title']);
						if (!preg_match("/^[a-zA-Z-' ]*$/", $Title)) {
							$titleErr="Only letters and whitespace allowed";
							$isTitleValid = false;
						}
						else
						{
							$isTitleValid = true;
						}
					}

				if ($isNameValid && $isEmailValid && $isPhoneValid && $isTitleValid);
				{
					try
					{
						#Insert Query
						$query= "INSERT INTO contacts SET Name=:name, Email=:email, Phone=:phone, Title=:title";

						#Prepare query for execution
						$stmt = $con -> prepare($query);

						$name = htmlspecialchars(strip_tags($_POST['name']));
						$email = htmlspecialchars(strip_tags($_POST['email']));
						$phone = htmlspecialchars(strip_tags($_POST['phone']));
						$title  = htmlspecialchars(strip_tags($_POST['title']));
						

						#Bind parameters
						$stmt -> bindParam(':name',$Name);
						$stmt -> bindParam(':email',$Email);
						$stmt -> bindParam(':phone',$Phone);
						$stmt -> bindParam(':title',$Title);

						#Execute query

						if ($stmt -> execute())
						{
							Echo '<div class="alert alert-success" role="alert"> Entry Successful </div>';
						}
						else
						{
							echo '<div class="alert alert-warning" role="alert">Entry failed. Please verify data is correct and resubmit.</div>';
						}
					}
					catch(PDOException $e)
					{
						echo "ERROR: ".$e -> getMessage();
					}
				}
				}

				
				


				function sanitize_input ($data)
				{
					$data = trim($data);
					$data = stripslashes($data);
					$data = htmlspecialchars($data);
					return $data;
				}


			?>
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
				<table class="table table-hover table-responsive table-bordered">
					<tr>
						<td>Name</td>
						<td>
							<input type="text" name="name" class="form-control" value="<?php echo $Name ;?>">
							<span class="Error"><?php echo $nameErr ;?> </span>
						</td>
					<tr>
						<td>Email</td>
						<td>
							<input type="text" name="email" class="form-control" value="<?php echo $Email ;?>">
							<span class="Error"><?php echo $emailErr ;?> </span>
						</td>
					</tr>
					<tr>
						<td>Phone</td>
						<td>
							<input type="text" name="phone" class="form-control" value="<?php echo $Phone ;?>">
							<span class="Error"><?php echo $phoneErr ;?> </span>
						</td>
					</tr>
					<tr>
						<td>Title</td>
						<td>
							<input type="text" name="title" class="form-control" value="<?php echo $Title ;?>">
							<span class="Error"><?php echo $titleErr;?> </span>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" value="Save" name="Submit" class="btn btn-primary"> <a href="index.php" class="btn btn-danger">Home</a></td>
					</tr>
				</table>
			</form>
		</div>
		<!-- Container End -->
	</body>
</html>