<?php include 'config.php' ?>

<?php
    session_start();

    if(isset($_POST["add"])){
        if(isset($_SESSION["shopping_cart"])){
            $item_array_id = array_column($_SESSION["shopping_cart"],"product_id");
            if(!in_array($_GET["id"],$item_array_id)){
                $count = count($_SESSION["shopping_cart"]);
                $item_array = array(
                    'product_id' => $_GET["id"],
                    'product_name' => $_POST["hidden_name"],
                    'product_price' => $_POST["hidden_price"],
                    'product_quantity' => $_POST["quantity"],
                );
                $_SESSION["shopping_cart"][$count] = $item_array;
                echo '<script>window.location="index.php"</script>';
            }else{
                echo '<script>alert("Product is already in the cart")</script>';
                echo '<script>window.location="index.php"</script>';
            }
        }else{
            $item_array = array(
                'product_id' => $_GET["id"],
                'product_name' => $_POST["hidden_name"],
                'product_price' => $_POST["hidden_price"],
                'product_quantity' => $_POST["quantity"],
            );
            $_SESSION["shopping_cart"][0] = $item_array;
        }
    }

    if(isset($_GET["action"])){
        if($_GET["action"] == "delete"){
            foreach($_SESSION["shopping_cart"] as $keys => $value){
                if($value["product_id"] == $_GET["id"]){
                    unset($_SESSION["shopping_cart"][$keys]);
                    echo '<script>alert("Product has been removed")</script>';
                    echo '<script>window.location="index.php"</script>';
                }
            }
        }
    }
        
    
?>

<?php include 'header.php' ?>

    <section class="items">
        <div class="item-row">
            <?php 
            $query = "SELECT * FROM products ORDER BY product_id ASC";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_array($result)){
            ?>
                <form method="POST" action="index.php?action=add&id=<?php echo $row["product_id"]; ?>">
                    <div class="item-card">
                        <div class="img-container">
                            <img src="<?php echo $row["images"]; ?>" alt="#">
                        </div>
                        <p><?php echo $row["description"]; ?></p>
                        <p class="price">Rs.<?php echo $row["price"]; ?>.00</p>
                        <div class="quantity">
                            <input type="text" name="quantity" class="quantity" value="1">
                        </div>
                        <div class="button-container">
                            <input type="submit" name="submit" class="addcartbtn" value="Add to Cart">
                        </div>
                        <input type="hidden" name="hidden_name" value="<?php echo $row["description"]; ?>">
                        <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>">
                    </div>
                </form>
            <?php 
                }
            }
            ?>    
        </div>
    </section>

    <?php include 'footer.php' ?>
    