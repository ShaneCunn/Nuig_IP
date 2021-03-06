<?php
//session_start();

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



if (!isset($_SESSION['user_email'])) {
    header("Location:login.php?err=" . urldecode("You need to login to view the account page."));
    exit();

}
/*$query = "select * from messages";
$result = $db->query($query);*/

/*if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"] . " - Name: " . $row["name"] . " " . $row["subject"] . " " . $row["message"] . "<br>";
    }
} else {
    echo "0 results";
}*/

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
            <a class="navbar-brand" href="login.php">Administrator page for Nuig Shop</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

    <div class="jumbostron">

        <h2>
            Welcome <?php echo $_SESSION['user_email'] ?>
        </h2>
    </div>

    <h2>Result Table</h2>
    <p>This show message from the contact page</p>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>

            </tr>
            </thead>
            <tbody >
            <?php
            $query = "select * from messages";
            $result = $db->query($query);

            if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {?>
           <!-- // echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["subject"].  " " . $row["message"]."<br>";
            // }-->



            <tr >
                <td ><?php echo $row["id"] ?></td>
            <td><?php echo $row["name"] ?></td>
                    <td><?php echo $row["email"] ?></td>
            <td><?php echo $row["subject"] ?></td>
            <td><?php echo $row["message"] ?></td>

            </tr>
            <?php }} ?>

            </tbody>
        </table>
    </div>


</div><!-- /.container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="./js/bootstrap.js"></script>

</body>
</html>