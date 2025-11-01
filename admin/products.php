<?php
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$message = '';

// Handle product deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Get image filename
    $img_query = "SELECT image FROM products WHERE id=$id";
    $img_result = mysqli_query($conn, $img_query);
    if ($img_row = mysqli_fetch_assoc($img_result)) {
        $image_path = "../uploads/" . $img_row['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    
    $delete_query = "DELETE FROM products WHERE id=$id";
    if (mysqli_query($conn, $delete_query)) {
        $message = 'Product deleted successfully.';
    } else {
        $message = 'Error deleting product.';
    }
}

// Fetch all products
$query = "SELECT * FROM products ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Admin</title>
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
        <h1 class="page-title">Manage Products</h1>
        
        <?php if($message): ?>
            <div class="message message-success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div style="margin-bottom: 2rem;">
            <a href="add_product.php" class="btn">+ Add New Product</a>
        </div>
        
        <?php if(mysqli_num_rows($result) > 0): ?>
            <div class="cart-container">
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($product = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                         class="table-image">
                                </td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                <td><?php echo $product['stock']; ?></td>
                                <td><?php echo htmlspecialchars($product['category']); ?></td>
                                <td>
                                    <div class="action-links">
                                        <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-small btn-secondary">Edit</a>
                                        <a href="products.php?delete=<?php echo $product['id']; ?>" 
                                           class="btn btn-small btn-danger"
                                           onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>No products available. Add your first product!</p>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 Glamour Cosmetics. All rights reserved.</p>
    </footer>
</body>
</html>