<?php 

$database = require("dbEnv.php");
$database = $database["database"];

// connect to database
$conn = mysqli_connect($database["host"], $database["username"], $database["password"], $database["dbName"]);

// check connection
if (!$conn) {
  echo "Connection error: " . mysqli_connect_error();
}

?>