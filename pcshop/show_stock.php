<?php
include 'db.php';

echo "<!DOCTYPE html>
<html>
<head>
    <title>Device Stock</title>
    <link rel='stylesheet' href='style.css'>
</head>
<body>";

$result = $conn->query("SELECT * FROM devices");
echo "<h2>Device Stock</h2>
<table border='1'><tr><th>Serial ID</th><th>Name</th><th>Model</th><th>Color</th><th>Branch</th><th>city</th><th>Actions</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['serial_id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['model']}</td>
        <td>{$row['color']}</td>
        <td>{$row['branch']}</td>
        <td>{$row['city']}</td>
        <td>
            <a href='update.php?id={$row['id']}'>Update</a> |
            <a href='delete.php?id={$row['id']}'>Delete</a>
        </td>
    </tr>";
}
echo "</table><br><a href='dstock.php'>Back</a>";
?>
