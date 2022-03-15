<?php
$host = "localhost";
$dbName = "percicmd_anthonydb";
$userName = "percicmd_user1234";
$password = "!QAZxsw2#EDCvfr4";
try
{
$con = new PDO("mysql:host={$host};dbname={$dbName}",$userName, $password);
//ssecho "Connection Successful";
}



catch (PDOxception $e)
{
#echo "Connection Error:". $e -> getMessage();
}




?>