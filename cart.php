<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

// Handle cart updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_cart'])) {
        $cart_id = intval($_POST['cart_id']);
        $quantity = intval($_POST['quantity']);
        
        if ($quantity > 0) {
            $update_query = "UPDATE cart SET quantity=$quantity WHERE id=$cart_id AND user_id=$user_id";
            mysqli_query($conn, $update_query);
            $message = 'Cart updated successfully.';
        }
    } elseif (isset($_POST['remove_item'])) {
        $cart_id = intval($_POST['cart_id']);
        $delete_query = "DELETE FROM cart WHERE id=$cart_id AND user_id=$user_id";
        mysqli_query($conn, $delete_query);
        $message = 'Item removed from cart.';
    }
}

// Fetch cart items
$query = "SELECT c.id as cart_id, c.quantity, p.* FROM cart c 
          JOIN products p ON c.product_id = p.id 
          WHERE c.user_id=$user_id";
$result = mysqli_query($conn, $query);

$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart - Glamour Cosmetics</title>
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
                    <li><a href="orders.php">My Orders</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h1 class="page-title">Shopping Cart</h1>
        
        <?php if($message): ?>
            <div class="message message-success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if(mysqli_num_rows($result) > 0): ?>
            <div class="cart-container">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($item = mysqli_fetch_assoc($result)): 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td>
                                    <img src="uploads/<?php echo htmlspecialchars($item['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                         class="table-image">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </td>
                                <td>$<?php echo number_format($item['price'], 2); ?></td>
                                <td>
                                    <form method="POST" action="" style="display: inline;">
                                        <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" 
                                               min="1" style="width: 60px; padding: 0.3rem;">
                                        <button type="submit" name="update_cart" class="btn btn-small">Update</button>
                                    </form>
                                </td>
                                <td>$<?php echo number_format($subtotal, 2); ?></td>
                                <td>
                                    <form method="POST" action="" style="display: inline;">
                                        <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                        <button type="submit" name="remove_item" class="btn btn-small btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                
                <div class="cart-total">
                    <strong>Total: <span>$<?php echo number_format($total, 2); ?></span></strong>
                </div>
                
                <div style="text-align: right; margin-top: 1rem;">
                    <form method="POST" action="checkout.php">
                        <button type="submit" class="btn">Proceed to Checkout</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>Your cart is empty. <a href="index.php">Continue Shopping</a></p>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 Glamour Cosmetics. All rights reserved.</p>
    </footer>
</body>
</html>