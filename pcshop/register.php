<?php
include 'db.php';

$name = $_POST['name'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$address = $_POST['address'];

$sql = "INSERT INTO users (name, username, password, address) VALUES ('$name', '$username', '$password', '$address')";

if ($conn->query($sql) === TRUE) {
    echo "Registered successfully. <a href='login.php'>Login here</a>";
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>
