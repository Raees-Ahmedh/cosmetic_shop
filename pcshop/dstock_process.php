<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serial_id = $_POST['serial_id'];
    $name = $_POST['name'];
    $model = $_POST['model'];
    $color = $_POST['color'];

    // Convert branch checkboxes array to comma-separated string
    $branch = isset($_POST['branch']) ? implode(", ", $_POST['branch']) : '';

    // Convert city multiple select array to comma-separated string
    $city = isset($_POST['city']) ? implode(", ", $_POST['city']) : '';

    // Prepare SQL statement (6 columns, 6 placeholders)
    $stmt = $conn->prepare("INSERT INTO devices (serial_id, name, model, color, branch, city) VALUES (?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        // Bind parameters types: s = string, 6 strings total
        $stmt->bind_param("ssssss", $serial_id, $name, $model, $color, $branch, $city);

        if ($stmt->execute()) {
            echo "✅ Device added successfully. <a href='dstock.php'>Go back</a>";
        } else {
            echo "❌ Error executing statement: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "❌ Error preparing statement: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
