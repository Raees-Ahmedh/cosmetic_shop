<?php
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit();
}

$product_id = intval($_GET['id']);
$error = '';
$success = '';

// Fetch product
$query = "SELECT * FROM products WHERE id=$product_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header('Location: products.php');
    exit();
}

$product = mysqli_fetch_assoc($result);

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
    } else {
        $image_name = $product['image'];
        
        // Handle new image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] != 4) {
            $image = $_FILES['image'];
            $allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
            
            if (!in_array($image['type'], $allowed_types)) {
                $error = 'Only JPG, PNG and GIF images are allowed.';
            } elseif ($image['size'] > 5000000) {
                $error = 'Image size must be less than 5MB.';
            } else {
                $upload_dir = '../uploads/';
                $image_extension = pathinfo($image['name'], PATHINFO_EXTENSION);
                $new_image_name = time() . '_' . uniqid() . '.' . $image_extension;
                $image_path = $upload_dir . $new_image_name;
                
                if (move_uploaded_file($image['tmp_name'], $image_path)) {
                    // Delete old image
                    $old_image_path = $upload_dir . $product['image'];
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                    $image_name = $new_image_name;
                } else {
                    $error = 'Error uploading new image.';
                }
            }
        }
        
        if (empty($error)) {
            $update_query = "UPDATE products SET 
                            name='$name', 
                            description='$description', 
                            price=$price, 
                            stock=$stock, 
                            category='$category', 
                            image='$image_name' 
                            WHERE id=$product_id";
            
            if (mysqli_query($conn, $update_query)) {
                $success = 'Product updated successfully!';
                // Refresh product data
                $result = mysqli_query($conn, $query);
                $product = mysqli_fetch_assoc($result);
            } else {
                $error = 'Error updating product.';
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
    <title>Edit Product - Admin</title>
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
        <h2 class="page-title">Edit Product</h2>
        
        <?php if($error): ?>
            <div class="message message-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div class="message message-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-bottom: 1rem;">
            <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                 alt="Current Product Image" 
                 style="max-width: 200px; border-radius: 10px;">
        </div>
        
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Product Name *</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Price ($) *</label>
                <input type="number" name="price" step="0.01" min="0" value="<?php echo $product['price']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="stock" value="<?php echo $product['stock']; ?>" min="0">
            </div>
            
            <div class="form-group">
                <label>Category</label>
                <select name="category">
                    <option value="">Select Category</option>
                    <option value="Lipstick" <?php if($product['category'] == 'Lipstick') echo 'selected'; ?>>Lipstick</option>
                    <option value="Foundation" <?php if($product['category'] == 'Foundation') echo 'selected'; ?>>Foundation</option>
                    <option value="Mascara" <?php if($product['category'] == 'Mascara') echo 'selected'; ?>>Mascara</option>
                    <option value="Eyeshadow" <?php if($product['category'] == 'Eyeshadow') echo 'selected'; ?>>Eyeshadow</option>
                    <option value="Blush" <?php if($product['category'] == 'Blush') echo 'selected'; ?>>Blush</option>
                    <option value="Skincare" <?php if($product['category'] == 'Skincare') echo 'selected'; ?>>Skincare</option>
                    <option value="Other" <?php if($product['category'] == 'Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>New Product Image (leave empty to keep current)</label>
                <input type="file" name="image" accept="image/*">
            </div>
            
            <button type="submit" class="btn">Update Product</button>
            <a href="products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Glamour Cosmetics. All rights reserved.</p>
    </footer>
</body>
</html>