<?php
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    header('Location: index.php');
    exit();
}

$order_id = intval($_GET['order_id']);
$user_id = $_SESSION['user_id'];

// Verify order belongs to user
$query = "SELECT * FROM orders WHERE id=$order_id AND user_id=$user_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit();
}

$order = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - Glamour Cosmetics</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <a href="index.php" class="logo">✨ Glamour Cosmetics</a>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="orders.php">My Orders</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="cart-container" style="text-align: center;">
            <h1 class="page-title">✓ Order Confirmed!</h1>
            
            <div class="message message-success">
                <h3>Thank you for your order!</h3>
                <p>Your order has been placed successfully.</p>
            </div>
            
            <div style="margin: 2rem 0;">
                <p><strong>Order ID:</strong> #<?php echo $order_id; ?></p>
                <p><strong>Total Amount:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>
                <p><strong>Status:</strong> <?php echo ucfirst($order['status']); ?></p>
            </div>
            
            <div style="margin-top: 2rem;">
                <a href="orders.php" class="btn">View My Orders</a>
                <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Glamour Cosmetics. All rights reserved.</p>
    </footer>
</body>
</html>