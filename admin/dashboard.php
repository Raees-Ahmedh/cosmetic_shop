<?php
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch statistics
$products_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products"))['count'];
$users_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
$orders_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders"))['count'];
$total_sales = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) as total FROM orders"))['total'] ?? 0;

// Fetch recent orders
$recent_orders = mysqli_query($conn, "SELECT o.*, u.username FROM orders o 
                                      JOIN users u ON o.user_id = u.id 
                                      ORDER BY o.order_date DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Glamour Cosmetics</title>
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
        <h1 class="page-title">Admin Dashboard</h1>
        
        <div class="products-grid" style="grid-template-columns: repeat(4, 1fr);">
            <div class="product-card">
                <div class="product-info" style="text-align: center;">
                    <h3 style="color: #ff6b9d; font-size: 2.5rem;"><?php echo $products_count; ?></h3>
                    <p>Total Products</p>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-info" style="text-align: center;">
                    <h3 style="color: #667eea; font-size: 2.5rem;"><?php echo $users_count; ?></h3>
                    <p>Total Users</p>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-info" style="text-align: center;">
                    <h3 style="color: #f85032; font-size: 2.5rem;"><?php echo $orders_count; ?></h3>
                    <p>Total Orders</p>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-info" style="text-align: center;">
                    <h3 style="color: #2ecc71; font-size: 2.5rem;">$<?php echo number_format($total_sales, 2); ?></h3>
                    <p>Total Sales</p>
                </div>
            </div>
        </div>
        
        <h2 style="margin-top: 3rem;">Recent Orders</h2>
        <?php if(mysqli_num_rows($recent_orders) > 0): ?>
            <div class="cart-container">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($order = mysqli_fetch_assoc($recent_orders)): ?>
                            <tr>
                                <td>#<?php echo $order['id']; ?></td>
                                <td><?php echo htmlspecialchars($order['username']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                                <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                <td><?php echo ucfirst($order['status']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>No orders yet.</p>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 Glamour Cosmetics. All rights reserved.</p>
    </footer>
</body>
</html>