<?php
// cart.php
session_start();
include 'header.php';
?>
<h2>Shopping Cart</h2>
<table border="1" cellpadding="10" cellspacing="0">
<tr>
<th width="40%">Product Name</th>
<th width="10%">Quantity</th>
<th width="20%">Price</th>
<th width="15%">Total</th>
<th width="5%">Action</th>
</tr>
<?php
if (!empty($_SESSION["shopping_cart"])) {
$total = 0;
foreach ($_SESSION["shopping_cart"] as $key => $value) {
?>
<tr>
<td><?php echo $value["product_name"]; ?></td>
<td><?php echo $value["product_quantity"]; ?></td>
<td>Rs. <?php echo $value["product_price"]; ?></td>
<td>Rs. <?php echo number_format($value["product_quantity"] * $value["product_price"], 2); ?></td>
<td><a href="cart.php?action=delete&id=<?php echo $value["product_id"]; ?>">Remove</a></td>
</tr>
<?php
$total += ($value["product_quantity"] * $value["product_price"]);
}
?>
<tr>
<td colspan="3" align="right"><strong>Total</strong></td>
<td>Rs. <?php echo number_format($total, 2); ?></td>
<td></td>
</tr>
<?php } ?>
</table>
<?php
if (isset($_GET["action"])) {
if ($_GET["action"] == "delete") {
foreach ($_SESSION["shopping_cart"] as $keys => $value) {
if ($value["product_id"] == $_GET["id"]) {
unset($_SESSION["shopping_cart"][\$keys]);
echo '<script>alert("Product removed")</script>';
echo '<script>window.location="cart.php"</script>';
}
}
}
}
include 'footer.php';
?>