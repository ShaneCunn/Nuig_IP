<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Created by PhpStorm.
 * User: shane
 * Date: 23/03/2016
 * Time: 12:32
 */

include('includes/config.php');
include('includes/db.php');
if (isset($_SESSION['user_email'])) {
    header("Location:showContactUs.php");
    exit();

}

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $query = "select * from users where email ='$email' and  password='$password'";

    $result = $db->query($query);


    if ($row = $result->fetch_assoc()) {

        if ($row['status'] == 1) {
            $_SESSION['user_email'] = $email;
            header("Location:showContactUs.php?");
            exit();
        } else {
            header("Location:login.php?err=" . urldecode("the user account is not activated"));
            exit();

        }

    } else {
        header("Location:login.php?err=" . urldecode("Wrong email or password"));
        exit();

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
    <link rel="icon" href="./favicon.ico">

    <title>Login</title>

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
            <button class="navbar-toggle" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" type=
            "button"><span class="sr-only">Toggle navigation</span>

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

                <?php if (!isset($_SESSION['user_email'])) { ?>
                    <li class="active"><a href="login.php">Login</a></li>

                    <li><a href="register.php">Register</a></li>


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

        <form class="form-signin" action="login.php" method="post">
            <h2 class="form-signin-heading fade-in">Please sign in to see Administrator page</h2>
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success fade-in"><a href="#" class="close" data-dismiss="alert"
                                                            aria-label="close">&times;</a><?php echo $_GET['success'] ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['err'])) { ?>
                <div class="alert alert-danger fade-in"><a href="#" class="close" data-dismiss="alert"
                                                           aria-label="close">&times;</a><?php echo $_GET['err'] ?>
                </div>
            <?php } ?>
            <div class="alert alert-info fade-in"><a href="#" class="close" data-dismiss="alert"
                                                     aria-label="close">&times;</a>
                <strong>Test Login: test@test.com <br>Password: 12345
                </strong>
            </div>

            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required
                   autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password"
                   required>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Sign in</button>
            <p>forgot your password? <a href="forgot_password.php">click here</a></p>
            <p>new user? <a href="register.php">create new account</a></p>


        </form>


    </div>
</div> <!-- /container -->

<!-- /.container -->

<div class="container">
    <hr>
    <!-- Footer -->

    <footer>

        <div class="col-lg-12">
            <p>Copyright &copy; Shane Cunningham 2015</p>
        </div>

    </footer>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>

</body>

</html>