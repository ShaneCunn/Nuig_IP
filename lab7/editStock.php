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
global $db;

if (isset($_POST['delete'])) {
    $_SESSION['sale_price'] = $_POST['sale_price'];
    $_SESSION['product_name'] = $_POST['product_name'];
    $_SESSION['image_filename'] = $_POST['image_filename'];
    $_SESSION['text_desc'] = $_POST['text_desc'];


    $sale_price = mysqli_real_escape_string($db, $_POST['sale_price']);
    $product_name = mysqli_real_escape_string($db, $_POST['product_name']);
    $image_filename = mysqli_real_escape_string($db, $_POST['image_filename']);
    $text_desc = mysqli_real_escape_string($db, $_POST['text_desc']);

    $query = "DELETE FROM products WHERE id='$_POST[id]'";
    $result = $db->query($query);
    //  mysql_query($sql_query);
    header("Location:editStock.php?success=" . urldecode("stock deleted!"));
}


if (isset($_POST['submit'])) {
    $_SESSION['sale_price'] = $_POST['sale_price'];
    $_SESSION['product_name'] = $_POST['product_name'];
    $_SESSION['image_filename'] = $_POST['image_filename'];
    $_SESSION['text_desc'] = $_POST['text_desc'];

    $sale_price = mysqli_real_escape_string($db, $_POST['sale_price']);
    $product_name = mysqli_real_escape_string($db, $_POST['product_name']);
    $image_filename = mysqli_real_escape_string($db, $_POST['image_filename']);
    $text_desc = mysqli_real_escape_string($db, $_POST['text_desc']);

    $query = "INSERT INTO products(sale_price,product_name,image_filename,text_desc) VALUES('$sale_price','$product_name','$image_filename','$text_desc')";

    $db->query($query);
    header("Location:editStock.php?success=" . urldecode("stock added!"));

}

if (isset($_POST['update'])) {
    $_SESSION['sale_price'] = $_POST['sale_price'];
    $_SESSION['product_name'] = $_POST['product_name'];
    $_SESSION['image_filename'] = $_POST['image_filename'];
    $_SESSION['text_desc'] = $_POST['text_desc'];

    $sale_price = mysqli_real_escape_string($db, $_POST['sale_price']);
    $product_name = mysqli_real_escape_string($db, $_POST['product_name']);
    $image_filename = mysqli_real_escape_string($db, $_POST['image_filename']);
    $text_desc = mysqli_real_escape_string($db, $_POST['text_desc']);

    // $query = "insert into products(sale_price,product_name,image_filename,text_desc) values('$sale_price','$product_name','$image_filename','$text_desc')";

    // $query = "UPDATE products SET (sale_price,product_name,image_filename,text_desc) values('$sale_price','$product_name','$image_filename','$text_desc') WHERE id='$_POST[id]'";
    $query = "UPDATE products SET sale_price='$sale_price', product_name='$product_name', image_filename='$image_filename', text_desc='$text_desc' WHERE id='$_POST[id]'";

    $db->query($query);
    header("Location:editStock.php?success=" . urldecode("Table row updated!"));

}


if (!isset($_SESSION['user_email'])) {
    header("Location:login.php?err=" . urldecode("You need to login to view the stock page."));
    exit();
}
?>


<?php function auto_copyright($year = 'auto')
{ ?>
    <?php if (intval($year) == 'auto') {
    $year = date('Y');
} ?>
    <?php if (intval($year) == date('Y')) {
    echo intval($year);
} ?>
    <?php if (intval($year) < date('Y')) {
    echo intval($year) . ' - ' . date('Y');
} ?>
    <?php if (intval($year) > date('Y')) {
    echo date('Y');
} ?>
<?php } ?>
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
            <a class="navbar-brand" href="login.php">Administrator page for NUIG Shop</a>
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
                    <a href="editStock.php">stock</a>
                </li>

                <li>
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
        <div class="col-xs-6 col-lg-2">
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

        <h2>
            Welcome <?php echo $_SESSION['user_email'] ?>

        </h2>


        <div class="col-xs-12 col-sm-6 col-lg-10">
            <h3>Result Table</h3>
            <p>This show message from the contact page</p>
            <div class="table-responsive">
                <table class="table table-bordered table-striped " id="mytable">
                    <thead>
                    <tr>

                        <th>ID</th>
                        <th>Sale Price</th>
                        <th>Product Name</th>
                        <th>Product Description</th>
                        <th>Image File name</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php


                    $query = "SELECT * FROM products";
                    $result = $db->query($query);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<form action=editStock.php method=post>";
                            echo "<tr>";
                            echo "<td class=\"col-sm-1\">" . "<input type=text  class=\"form-control\" readonly name=id value=" . $row['id'] . " </td>";
                            echo "<td class=\"col-sm-2\">" . "<input type=number class=\"form-control\" name=sale_price value=" . $row['sale_price'] . " </td>";
                            echo "<td class=\"col-sm-2\">" . "<input type=text class=\"form-control\" name=product_name value=" . $row['product_name'] . " </td>";
                            echo "<td class=\"col-sm-4\">" . "<input type=text class=\"form-control\" name=text_desc value=" . $row['text_desc'] . " </td>";
                            echo "<td class=\"col-sm-3\">" . "<input type=text class=\"form-control\" name=image_filename value=" . $row['image_filename'] . " </td>";

                            echo "<td><p data-placement=\"top\" data-toggle=\"tooltip\" title=\"Edit\"><button class=\"btn btn-primary btn-xs\" data-title=\"Edit\" type=submit name=update data-toggle=\"modal\" data-target=\"#edit\" ><span class=\"glyphicon glyphicon-pencil\"></span></button></p></td>";
                            echo "<td><p data-placement=\"top\" data-toggle=\"tooltip\" title=\"Delete\"><button class=\"btn btn-danger btn-xs\" type=submit name=delete data-title=\"Delete\" data-toggle=\"modal\" data-target=\"#delete\" ><span class=\"glyphicon glyphicon-trash\"></span></button></p></td>";

                            echo "</form>";
                            echo "</tr>";


                        }
                    } else {
                        echo "Zero record found";
                    } ?>

                    <?php if (isset($_GET['success'])) { ?>
                    <div class="alert alert-success fade-in"><a href="#" class="close" data-dismiss="alert"
                                                                aria-label="close">&times;</a><?php echo $_GET['success'] ?>
                    </div>
            </div>
            </tbody> </table>
            </table>
            <?php } ?>


            <!-- Button to trigger modal -->
            <a href="#myModal" role="button" data-toggle="modal" aria-hidden="true" class="btn btn-info btn-lg"><span
                    class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add Stock</a>
            <!-- Modal -->
            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"> &times;</button>
                            <h4 class="modal-title">Add Stock Form</h4>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="alert alert-info"><a href="#" class="close" data-dismiss="alert"
                                                                         aria-label="close">&times;</a>
                                            File uploads on the nuig server is currently disabled
                                        </div>
                                        <form class="form-horizontal" action="" method="POST">

                                            <fieldset>

                                                <div class="control-group">
                                                    <label class="control-label" for="username">Price</label>
                                                    <div class="controls">
                                                        <input type="number" min="0" id="sale_price" name="sale_price"
                                                               placeholder=""
                                                               class="form-control input-lg">
                                                        <p class="help-block">Please enter a Sale Price for the
                                                            product</p>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" for="email">Product name</label>
                                                    <div class="controls">
                                                        <input type="text" id="product_name" name="product_name"
                                                               placeholder=""
                                                               class="form-control input-lg">
                                                        <p class="help-block">Please enter a Product name</p>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="product">Product
                                                        Description</label>
                                                    <div class="controls">
                                                        <input type="text" id="text_desc" name="text_desc"
                                                               placeholder=""
                                                               class="form-control input-lg">
                                                        <p class="help-block">Please enter a product description</p>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" for="image file">Image File
                                                        name</label>
                                                    <div class="controls">
                                <span class="btn btn-info btn-file">
                                 Browse <input type="file" name="image_filename">
                                                        </span>

                                                        <p class="help-block">Allowed extensions (<code>jpeg</code>,
                                                            <code>jpg</code>,
                                                            <code>gif</code>, and <code>png</code>)</p>
                                                    </div>
                                                </div>


                                                <div class="control-group">
                                                    <!-- Button -->
                                                    <div class="controls">
                                                        <button class="btn btn-success" name="submit">Submit</button>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>

                                </div>
                            </div><!-- End of Modal body -->
                        </div><!-- End of Modal content -->
                    </div><!-- End of Modal dialog -->
                </div><!-- End of Modal -->
            </div> <!-- /.container -->
        </div>

    </div>
    <!-- Footer -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="./js/bootstrap.js"></script>
    <script src="./js/table.js"></script>

</body>
</html>