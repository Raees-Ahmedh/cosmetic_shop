<!DOCTYPE html>
<html>
<head>
    <title>Add Device</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
     <?php include 'head.php'; ?>
<div class="container">
    <h2>Device Stock Form</h2>
    <form action="dstock_process.php" method="POST">
        <input type="text" name="serial_id" placeholder="Serial ID" required><br>
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="text" name="model" placeholder="Model" required><br>

        <label>Color:</label><br>
        <input type="radio" name="color" value="White" required> White
        <input type="radio" name="color" value="Black" required> Black<br><br>

        <label>Branches:</label><br>
        <input type="checkbox" name="branch[]" value="Kandy"> Kandy<br>
        <input type="checkbox" name="branch[]" value="Colombo"> Colombo<br>
        <input type="checkbox" name="branch[]" value="Kurunegala"> Kurunegala<br>
        <input type="checkbox" name="branch[]" value="Polonnaruwa"> Polonnaruwa<br><br>

        <!-- Changed dropdown label to City -->
        <label>City (Select up to two):</label><br>
        <select name="city[]" multiple size="4" required>
            <option value="Kandy">Kandy</option>
            <option value="Colombo">Colombo</option>
            <option value="Kurunegala">Kurunegala</option>
            <option value="Polonnaruwa">Polonnaruwa</option>
        </select><br><br>


        <button type="submit">Add</button>
    </form>
    <a href="show_stock.php"><button type="button">Show Stock</button></a>
</div>
</body>
</html>
