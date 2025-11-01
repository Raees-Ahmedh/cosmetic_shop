<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = intval($_POST['product_id']);
    $user_id = $_SESSION['user_id'];
    
    // Check if product exists
    $check_product = "SELECT * FROM products WHERE id=$product_id";
    $product_result = mysqli_query($conn, $check_product);
    
    if (mysqli_num_rows($product_result) == 0) {
        header('Location: index.php');
        exit();
    }
    
    // Check if product already in cart
    $check_cart = "SELECT * FROM cart WHERE user_id=$user_id AND product_id=$product_id";
    $cart_result = mysqli_query($conn, $check_cart);
    
    if (mysqli_num_rows($cart_result) > 0) {
        // Update quantity
        $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id=$user_id AND product_id=$product_id";
        mysqli_query($conn, $update_query);
    } else {
        // Add new item to cart
        $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)";
        mysqli_query($conn, $insert_query);
    }
    
    header('Location: cart.php');
    exit();
}

header('Location: index.php');
exit();
?>