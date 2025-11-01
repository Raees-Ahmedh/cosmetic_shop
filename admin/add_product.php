<?php
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    
    if (empty($name) || empty($price)) {
        $error = 'Product name and price are required.';
    } elseif ($price <= 0) {
        $error = 'Price must be greater than zero.';
    } elseif (!isset($_FILES['image']) || $_FILES['image']['error'] == 4) {
        $error = 'Product image is required.';
    } else {
        // Handle file upload
        $image = $_FILES['image'];
        $allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
        
        if (!in_array($image['type'], $allowed_types)) {
            $error = 'Only JPG, PNG and GIF images are allowed.';
        } elseif ($image['size'] > 5000000) {
            $error = 'Image size must be less than 5MB.';
        } else {
            // Create uploads directory if not exists
            $upload_dir = '../uploads/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $image_extension = pathinfo($image['name'], PATHINFO_EXTENSION);
            $image_name = time() . '_' . uniqid() . '.' . $image_extension;
            $image_path = $upload_dir . $image_name;
            
            if (move_uploaded_file($image['tmp_name'], $image_path)) {
                $query = "INSERT INTO products (name, description, price, image, stock, category) 
                          VALUES ('$name', '$description', $price, '$image_name', $stock, '$category')";
                
                if (mysqli_query($conn, $query)) {
                    $success = 'Product added successfully!';
                } else {
                    $error = 'Error adding product to database.';
                    unlink($image_path);
                }
            } else {
                $error = 'Error uploading image.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Admin</title>
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

    <div class="form-container">
        <h2 class="page-title">Add New Product</h2>
        
        <?php if($error): ?>
            <div class="message message-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div class="message message-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Product Name *</label>
                <input type="text" name="name" required>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4"></textarea>
            </div>
            
            <div class="form-group">
                <label>Price ($) *</label>
                <input type="number" name="price" step="0.01" min="0" required>
            </div>
            
            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="stock" value="0" min="0">
            </div>
            
            <div class="form-group">
                <label>Category</label>
                <select name="category">
                    <option value="">Select Category</option>
                    <option value="Lipstick">Lipstick</option>
                    <option value="Foundation">Foundation</option>
                    <option value="Mascara">Mascara</option>
                    <option value="Eyeshadow">Eyeshadow</option>
                    <option value="Blush">Blush</option>
                    <option value="Skincare">Skincare</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Product Image *</label>
                <input type="file" name="image" accept="image/*" required>
            </div>
            
            <button type="submit" class="btn">Add Product</button>
            <a href="products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Glamour Cosmetics. All rights reserved.</p>
    </footer>
</body>
</html>