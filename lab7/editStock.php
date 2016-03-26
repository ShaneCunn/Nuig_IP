<?php
/**
 * Created by PhpStorm.
 * User: 15104623
 * Date: 26/03/2016
 * Time: 17:44
 */



session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('includes/config.php');
include('includes/db.php');

if (!isset($_SESSION['user_email'])) {
    header("Location:login.php?err=" . urldecode("You need to login to view the stock page."));
    exit();
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

    <title>Account Details</title>


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


                <li class="active">
                    <a href="showContactUs.php">Administrator panel</a>
                </li>

                <?php if (!isset($_SESSION['user_email'])) { ?>
                    <li class="active"><a href="login.php">Login</a></li>
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

        <div class="jumbostron">

            <h2>
                Welcome <?php echo $_SESSION['user_email'] ?>

            </h2>
        </div>

        <h3>Result Table</h3>
        <p>This show message from the contact page</p>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Sale Price</th>
                    <th>Product Name</th>
                    <th>Image File name</th>
                    <th>Product Description</th>

                </tr>
                </thead>
                <tbody>
                <?php
                $query = "select * from products";
                $result = $db->query($query);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td data-checkbox="true"><?php echo $row["id"] ?></td>
                            <td><?php echo $row["sale_price"] ?></td>
                            <td><?php echo $row["product_name"] ?></td>
                            <td><?php echo $row["image_filename"] ?></td>
                            <td><?php echo $row["text_desc"] ?></td>

                        </tr>
                    <?php }
                } ?>

                </tbody>
            </table>

            <?php
            $query = "select * from products";
            $result = $db->query($query);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row["id"] ?></td>
                        <td><?php echo $row["sale_price"] ?></td>
                        <td><?php echo $row["product_name"] ?></td>
                        <td><?php echo $row["image_filename"] ?></td>
                        <td><?php echo $row["text_desc"] ?></td>

                    </tr>
                <?php }
            } ?>

            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Dropdown Example
                    <span class="caret"></span></button>

                <?php
                $query = "SELECT id FROM products";
                $result = $db->query($query);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) { ?>
                <ul class="dropdown-menu">
                    <li><?php echo $row["id"] ?></li>

                </ul>
                <?php }
                } ?>

            </div>
        </div>


    </div><!-- /.container -->

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
    <script src="./js/bootstrap.js"></script>

</body>
</html>