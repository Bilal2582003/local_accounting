<?php
// Database credentials
include "../Model/connection.php";

// Retrieve the worker data from the form
$name = $_POST['name'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$city = $_POST['city'];
$status = $_POST['status'];

// Insert the worker data into the database
if($status == 0){
  $sql = "INSERT INTO workers (name, contact, address, city) VALUES ('$name', '$contact', '$address', '$city')";
}
elseif($status == 1){
  $sql = "INSERT INTO party (name, contact, address, city) VALUES ('$name', '$contact', '$address', '$city')";

}

if ($con->query($sql) === TRUE) {
  echo "Added successfully";
} else {
  echo "Error: " . $sql . "<br>" . $con->error;
}

// Close the database connection
$con->close();
?>
