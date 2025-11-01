<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM devices WHERE id=$id");
    $row = $result->fetch_assoc();
?>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="text" name="serial_id" value="<?php echo $row['serial_id']; ?>"><br>
    <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
    <input type="text" name="model" value="<?php echo $row['model']; ?>"><br>
    <input type="text" name="color" value="<?php echo $row['color']; ?>"><br>
    <input type="text" name="branch" value="<?php echo $row['branch']; ?>"><br>
    <button type="submit">Update</button>
</form>
<?php
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $serial_id = $_POST['serial_id'];
    $name = $_POST['name'];
    $model = $_POST['model'];
    $color = $_POST['color'];
    $branch = $_POST['branch'];

    $sql = "UPDATE devices SET serial_id='$serial_id', name='$name', model='$model',
            color='$color', branch='$branch' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Updated successfully. <a href='show_stock.php'>Go back</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>
