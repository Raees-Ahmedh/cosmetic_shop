<?php
require_once '../config.php';

if (!isset($_SESSION['admin_id']) || !isset($_GET['id'])) {
    header('Location: view_orders.php');
    exit();
}

$order_id = intval($_GET['id']);

// Fetch order with user details
$order_query = "SELECT o.*, u.username, u.email, u.full_name, u.phone, u.address 
                FROM orders o 
                JOIN users u ON o.user_id = u.id 
                WHERE o.id=$order_id";
$order_result = mysqli_query($conn, $order_query);

if (mysqli_num_rows($order_result) == 0) {
    header('Location: view_orders.php');
    exit();
}

$order = mysqli_fetch_assoc($order_result);

// Fetch order items
$items_query = "SELECT oi.*, p.name, p.image FROM order_items oi 
                JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id=$order_id";
$items_result = mysqli_query($conn, $items_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Admin</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <a href="dashboard.php" class="logo">✨ Admin Panel</a>
            <nav>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="view_orders.php">Orders</a></li>
                    <li><a href="admin_logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h1 class="page-title">Order Details - #<?php echo $order_id; ?></h1>
        
        <div class="cart-container">
            <h3>Order Information</h3>
            <div style="margin-bottom: 2rem;">
                <p><strong>Order Date:</strong> <?php echo date('M d, Y H:i', strtotime($order['order_date'])); ?></p>
                <p><strong>Status:</strong> <?php echo ucfirst($order['status']); ?></p>
                <p><strong>Total Amount:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>
            </div>
            
            <h3>Customer Information</h3>
            <div style="margin-bottom: 2rem;">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($order['full_name']); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($order['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                <?php if($order['phone']): ?>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                <?php endif; ?>
                <?php if($order['address']): ?>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                <?php endif; ?>
            </div>
            
            <h3>Order Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($item = mysqli_fetch_assoc($items_result)): 
                        $subtotal = $item['price'] * $item['quantity'];
                    ?>
                        <tr>
                            <td>
                                <img src="../uploads/<?php echo htmlspecialchars($item['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                     class="table-image">
                                <?php echo htmlspecialchars($item['name']); ?>
                            </td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($subtotal, 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
            <div style="margin-top: 2rem;">
                <a href="view_orders.php" class="btn btn-secondary">Back to Orders</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Glamour Cosmetics. All rights reserved.</p>
    </footer>
</body>
</html>