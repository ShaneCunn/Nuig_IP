<?php
/**
 * Created by PhpStorm.
 * User: shane
 * Date: 23/03/2016
 * Time: 12:32
 */

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('includes/config.php');
include('includes/db.php');

function isUnique($email)
{

    $query = "select * from users where email = '$email' ";

    global $db;

    $result = $db->query($query);

    if ($result->num_rows > 0) {

        return false;

    } else return true;
}

if (isset($_POST['register'])) {
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['confirm_password'] = $_POST['confirm_password'];
    if (strlen($_POST['name']) < 3) {
        header("Location:register.php?err=" . urlencode("The name must be 3 characters long"));
        exit();

    } else if ($_POST['password'] != $_POST['confirm_password']) {
        header("Location:register.php?err=" . urlencode("The password and confirm password must match"));
        exit();
    } else if (strlen($_POST['confirm_password']) < 5) {
        header("Location:register.php?err=" . urlencode("The password must be greater than 5 characters long"));
        exit();
    } elseif (strlen($_POST['confirm_password']) < 5) {
        header("Location:register.php?err=" . urlencode("The confirm password must be greater than 5 characters long"));
        exit();
    } elseif (!isUnique($_POST['email'])) {
        header("Location:register.php?err=" . urlencode("The email is already in use. Please enter a different email"));
        exit();

    } else {

        $name = mysqli_real_escape_string($db, $_POST['name']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $token = bin2hex(openssl_random_pseudo_bytes(32));

        $query = "insert into users(name,email,password,token) values('$name','$email','$password','$token')";


        $db->query($query);
        $messsage = "Hi $name! account created, here is the activation link: http://nuig.brtd.net/registration/activate.php?token=$token";

        mail($email, 'Activate account', $messsage, 'From: mayhem2277@gmail.com');
        header("Location:index.php?success=" . urldecode("Activation email sented!"));

    }


}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>register</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/starter-template.css" rel="stylesheet">


</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Administrator page for Nuig Shop</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Login</a></li>
                <li class="active"><a href="register.php">Register</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>


<div class="container">

    <form action="register.php" method="post" style="margin-top:35px">
        <h2>Register Here</h2>
        <hr>
        <?php if (isset($_GET['err'])) { ?>
            <div class="alert alert-danger"><?php echo $_GET['err'] ?></div>
        <?php } ?>

        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="name" name="name" class="form-control" placeholder="Name" required
                   value="<?php echo @$_SESSION['name']; ?>">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="email" class="form-control" placeholder="Email" required
                   value="<?php echo @$_SESSION['email']; ?>">
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required
                   value="<?php echo @$_SESSION['password']; ?>">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control"
                   placeholder="Confirm Password" required value="<?php echo @$_SESSION['confirm_password']; ?>">
        </div>


        <button type="submit" class="btn btn-default" name="register">Register</button>
    </form>

</div><!-- /.container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="./js/bootstrap.js"></script>

</body>
</html>
