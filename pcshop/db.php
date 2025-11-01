<?php
$conn = new mysqli("localhost", "root", "", "device_stock");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>