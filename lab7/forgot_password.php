<?php
/**
 * Created by PhpStorm.
 * User: shane
 * Date: 23/03/2016
 * Time: 12:32
 */

include('includes/config.php');
include('includes/db.php');

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
    <link rel="icon" href="./favicon.ico">

    <title>Forgot Password</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/shop-homepage.css" rel="stylesheet">


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
            <a class="navbar-brand" href="login.php">Administrator page for Nuig Shop</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="index.html">Home</a>
                </li>

                <li>
                    <a href="about.html">About</a>
                </li>

                <li>
                    <a href="contact.php">Contact</a>
                </li>

                <li>
                    <a href="special_offers.html">Special Offers</a>
                </li>

                <li>
                    <a href="links.html">Useful links</a>
                </li>
                <li>
                    <a href="clock.html">Clock</a>
                </li>
                <li>
                    <a href="editStock.php">Stock</a>
                </li>

                <li>
                    <a href="showContactUs.php">Administrator panel</a>
                </li>

                <?php if (!isset($_SESSION['user_email'])) { ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php } ?>

                <?php if (isset($_SESSION['user_email'])) { ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php } ?>
                
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

    <div class="row">
        <div class="col-md-3">
            <p class="lead">NUIG Shop</p>

            <div class="list-group">
                <a class="list-group-item" href="index.html">Home</a>
                <a class="list-group-item" href="about.html">About</a>
                <a class="list-group-item" href="contact.php">Contact</a>
                <a class="list-group-item" href="special_offers.html">Special Offers</a>
                <a class="list-group-item" href="links.html">Useful links</a>
                <a class="list-group-item" href="clock.html">Clock</a>

            </div>
        </div>

    <form  class="form-signin" method="post">
        <h2 class="form-signin-heading">Password reminder page</h2>
        <div class="form-group">
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
        </div>
        <div class="form-group">
        <button type="submit"  class="btn btn-lg btn-primary btn-block" name="send_my_password">Sent my Password</button>
        </div>
        <a class="btn btn-lg btn-danger btn-block" name="send_my_password"  href="login.php">   Cancel</a>
    </form>

</div><!-- /.container -->
    <div class="container">
        <hr>
        <!-- Footer -->

        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Shane Cunningham 2015</p>
                </div>
            </div>
        </footer>
    </div>
    <!-- /.container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="./js/bootstrap.js"></script>

</body>
</html>
