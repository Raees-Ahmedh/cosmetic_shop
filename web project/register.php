<?php include 'config.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <div class="form-container">
        <form action="" method="POST">
            <h3>Register Now</h3>
            <input type="text" name="name" class="box" placeholder="Enter Username">
            <input type="email" name="email" class="box" placeholder="Enter Email">
            <input type="password" name="password" class="box" placeholder="Enter Password">
            <input type="password" name="cpassword" class="box" placeholder="Confirm Password">
            <input type="submit" name="submit" class="btn" value="Register now">
            <p>Already have an account?<a href="login.html">login</a></p>
        </form>
    </div>
</body>
</html>