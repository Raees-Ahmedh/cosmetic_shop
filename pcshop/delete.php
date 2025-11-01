<?php
include 'db.php';
$id = $_GET['id'];
$sql = "DELETE FROM devices WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    echo "Deleted successfully. <a href='show_stock.php'>Go back</a>";
} else {
    echo "Error deleting record: " . $conn->error;
}
$conn->close();
?>
