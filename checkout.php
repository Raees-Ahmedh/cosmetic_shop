<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if cart is not empty
$check_cart = "SELECT * FROM cart WHERE user_id=$user_id";
$cart_check = mysqli_query($conn, $check_cart);

if (mysqli_num_rows($cart_check) == 0) {
    header('Location: cart.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Calculate total
    $query = "SELECT c.quantity, p.price FROM cart c 
              JOIN products p ON c.product_id = p.id 
              WHERE c.user_id=$user_id";
    $result = mysqli_query($conn, $query);
    
    $total = 0;
    while($item = mysqli_fetch_assoc($result)) {
        $total += $item['price'] * $item['quantity'];
    }
    
    // Create order
    $order_query = "INSERT INTO orders (user_id, total_amount, status) 
                    VALUES ($user_id, $total, 'pending')";
    
    if (mysqli_query($conn, $order_query)) {
        $order_id = mysqli_insert_id($conn);
        
        // Add order items
        $cart_query = "SELECT product_id, quantity FROM cart WHERE user_id=$user_id";
        $cart_result = mysqli_query($conn, $cart_query);
        
        while($cart_item = mysqli_fetch_assoc($cart_result)) {
            $product_id = $cart_item['product_id'];
            $quantity = $cart_item['quantity'];
            
            // Get product price
            $price_query = "SELECT price FROM products WHERE id=$product_id";
            $price_result = mysqli_query($conn, $price_query);
            $price_row = mysqli_fetch_assoc($price_result);
            $price = $price_row['price'];
            
            $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                          VALUES ($order_id, $product_id, $quantity, $price)";
            mysqli_query($conn, $item_query);
        }
        
        // Clear cart
        $clear_cart = "DELETE FROM cart WHERE user_id=$user_id";
        mysqli_query($conn, $clear_cart);
        
        header('Location: order_success.php?order_id=' . $order_id);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Glamour Cosmetics</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <a href="index.php" class="logo">✨ Glamour Cosmetics</a>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="cart.php">My Cart</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h1 class="page-title">Checkout</h1>
        
        <div class="cart-container">
            <h3>Order Summary</h3>
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
                    <?php
                    $query = "SELECT c.quantity, p.* FROM cart c 
                              JOIN products p ON c.product_id = p.id 
                              WHERE c.user_id=$user_id";
                    $result = mysqli_query($conn, $query);
                    $total = 0;
                    
                    while($item = mysqli_fetch_assoc($result)):
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($subtotal, 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
            <div class="cart-total">
                <strong>Total Amount: <span>$<?php echo number_format($total, 2); ?></span></strong>
            </div>
            
            <div style="text-align: center; margin-top: 2rem;">
                <form method="POST" action="">
                    <button type="submit" class="btn">Place Order</button>
                    <a href="cart.php" class="btn btn-secondary">Back to Cart</a>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Glamour Cosmetics. All rights reserved.</p>
    </footer>
</body>
</html>