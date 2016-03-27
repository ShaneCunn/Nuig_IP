<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// forcing php to display errors and notices so i can debug the page

/*
 * @author     Shane Cunningham <s.cunningham18@nuigalway.ie>
 * @Course     H.Dip SDD industry stream
 * @Student    ID 15104623
 */

include('includes/config.php');
include('includes/db.php');
global $db;

if (isset($_POST["submit"])) {
    //variables taken in from the contact form
    /* $name = $_POST['name'];
     $email = $_POST['email'];
     $message = $_POST['message'];
     $subject = $_POST['subject'];*/

    $name = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $message = mysqli_real_escape_string($db, $_POST['message']);
    $subject = mysqli_real_escape_string($db, $_POST['subject']);
    $human = intval($_POST['human']);






    // uncomment the code line below to change the from email
    //$from = 's.cunningham18@nuigalway.ie';
    $from = $email;
    $to = 'mayhem2277@yahoo.com'; //email address to sent the contact form message to

    // searching for the @ symbol
    $at = strpos($email, "@");
    // searching for the . symbol
    $dot = strpos($email, ".");
    //$subject = strpos($subject, "Default");
    //declaring variable so that we don't get a Notice: Undefined variable
    $errName = null;
    $errEmail = null;
    $errSubject = null;
    $errMessage = null;
    $errHuman = null;
    $answerMessage = null;


    $body = "From: $name\n E-Mail: $email\n Message:\n $message";

    // Check if name is greater than 10 letters long
    if (strlen($name) < 10) {
        $errName = 'Please enter your name and is longer than 10 characters';
    } // Check if name has been entered
    elseif (strlen($email) < 10) {
        $errEmail = 'Your message needs to be 10 letters or more';
    } // Check if email the @ symbol has been entered
    elseif ($at === false) {
        $errEmail = 'E-mail address require @ symbol';
    } // Check if email the . symbol has been entered
    elseif ($dot === false) {
        $errEmail = 'E-mail address require a dot in it';
    } // Check if the default subject has been entered
    elseif ($subject === 'Default') {
        $errSubject = 'Please select a subject';
    } else {
        $errSubject = '';
    }   // Check if message is greater than 25 letters long
    if (strlen($message) < 25) {
        $errMessage = 'Your message needs to be 25 letters or more';
    } //Check if simple anti-bot test is correct
    elseif ($human !== 5) {
        $errHuman = 'Your anti-spam is incorrect';
    }

    // If there are no errors, it then sends the email
    if (!$errName && !$errEmail && !$errSubject && !$errMessage && !$errHuman) {


        if (mail($to, $subject, $body, $from)) {

            echo "hello";

            $name = mysqli_real_escape_string($db, $_POST['name']);
            $email = mysqli_real_escape_string($db, $_POST['email']);
            $message = mysqli_real_escape_string($db, $_POST['message']);
            $subject = mysqli_real_escape_string($db, $_POST['subject']);

            $query = "INSERT INTO messages(name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";


            $db->query($query);


            $answerMessage = '<div class="alert alert-success">Thank You! we will be in touch within 2 days</div>';
            header("Location:contact.php?success=" . urldecode("Thank You! we will be in touch within 2 days"));

        } else {

            header("Location:contact.php?err=" . urldecode("Sorry there was an error sending your message. Please try again later"));
            $answerMessage = '<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later.</div>';
            exit();
        }
    }


    /*if (isset($_GET['token'])) {

        $token = $_GET['token'];
        $query = "update users set status='1' where token='$token'";
        if ($db->query($query)) {

            header("Location:login.php?success= Account Activated!");
            exit();
        }*/
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="description" name="Internet programming lab1 built using the Bootstrap framework">
    <meta content="Author" name="Shane Cunningham">
    <meta content="Course" name="h.Dip SDD industry stream">
    <meta content="Student ID" name="15104623">

    <title>NUIG Shop</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">


</head>


<!--<body onload="document.contact.username.focus();">-->
<body>
<!-- Navigation -->

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->

        <div class="navbar-header">
            <button class="navbar-toggle" data-target=
            "#bs-example-navbar-collapse-1" data-toggle="collapse" type=
                    "button"><span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span> <span class="icon-bar"></span>
                <span class="icon-bar"></span></button>
            <a class="navbar-brand"
               href="index.html">National University of Ireland Galway</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->

        <div class="collapse navbar-collapse" id=
        "bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>
                    <a href="about.html">About</a>
                </li>

                <li class="active">
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
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php } ?>

                <?php if (isset($_SESSION['user_email'])) { ?>
                    <li><a href="editStock.php">Stock</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php } ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
</nav><!-- Page Content -->


<div class="container-fluid">
    <div class="row-fluid">
        <div class="span2">
            <!--Sidebar content-->
            <p class="lead">NUIG Shop</p>
            <div class="list-group">
                <a class="list-group-item" href="index.html">Home</a>
                <a class="list-group-item" href="about.html">About</a>
                <a class="list-group-item" href="contact.php">Contact</a>
                <a class="list-group-item" href=
                "special_offers.html">Special Offers</a> <a class=
                                                            "list-group-item" href="links.html">Useful links</a>
                <a class="list-group-item" href="clock.html">Clock</a>
            </div>
        </div>
        <div class="span10">
            <!--Body content-->
            <!-- Team Members Row -->
            <h2 class="page-header">Our Team</h2>
            <div class="col-lg-4 col-sm-6 text-center">
                <img class="img-circle img-responsive img-center" src="./images/contact1.jpg" alt="">

                <h3>John Smith
                    <small>Fulfilment Executive</small>
                </h3>
                <ul class="pull-left">
                    <li>Phone: 091 500001</li>
                    <li>Email: test@nuigalway.ie</li>
                </ul>


            </div>
            <div class="col-lg-4 col-sm-6 text-center">
                <img class="img-circle img-responsive img-center" src="./images/contact2.jpg" alt="">

                <h3>John Smith
                    <small>Marketing Officer</small>
                </h3>
                <ul class="pull-left">
                    <li>Phone: 091 500001</li>
                    <li>Email: test@nuigalway.ie</li>
                </ul>


            </div>
            <div class="col-lg-4 col-sm-6 text-center">
                <img class="img-circle img-responsive img-center" src="./images/contact3.jpg" alt="">

                <h3>John Smith
                    <small>Secretary</small>
                </h3>
                <ul class="pull-left">
                    <li>Phone: 091 500001</li>
                    <li>Email: test@nuigalway.ie</li>
                </ul>


            </div>
            <!-- End of Team Members Row -->
        </div>

        <!-- Form Content -->
        <div class="span10 offset2">

            <h2 class="page-header">Contact us</h2>

            <div class="col-lg-6">
                <!-- /.container -->


                <div class="container-fluid">

                    <!-- <form name='contact' onSubmit="return formValidation();">-->
                    <form class="form-horizontal" role="form" method="post" action="contact.php">
                        <div class="form-group">
                            <label for="name">Name:</label>

                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="First & Last Name"
                                   value="<?php if (!empty($name)) { ?> <?php echo htmlspecialchars($_POST['name']); ?><?php } ?>">
                            <?php if (!empty($errName)) { ?><?php echo "<p class='text-danger'>$errName</p>"; ?><?php } ?>

                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>

                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="example@domain.com"
                                   value="<?php if (!empty($email)) { ?><?php echo htmlspecialchars($_POST['email']); ?><?php } ?>">
                            <?php if (!empty($errEmail)) { ?><?php echo "<p class='text-danger'>$errEmail</p>"; ?><?php } ?>

                        </div>
                        <div class="form-group">
                            <label for="subject">Subject:</label>

                            <select class="form-control" id="subject" name="subject">

                                <option value="Sales">Sales</option>
                                <option value="Returns">Returns</option>
                                <option value="Shipping">Shipping</option>
                                <option value="Support">Support</option>
                            </select>
                            <?php if (!empty($errSubject)) { ?><?php echo "<p class='text-danger'>$errSubject</p>"; ?><?php } ?>


                        </div>

                        <div class="form-group">
                            <label for="message">Message:</label>

                            <textarea class="form-control" rows="4" name="message"
                                      placeholder="Enter your message for us here. We will get back to you within 2 business days."></textarea>
                            <?php if (!empty($message)) { ?><?php echo htmlspecialchars($_POST['message']); ?><?php } ?>
                            <?php if (!empty($errMessage)) { ?><?php echo "<p class='text-danger'>$errMessage</p>"; ?><?php } ?>

                        </div>
                        <div class="form-group">
                            <label for="human" class="control-label">2 + 3 = ?</label>

                            <input type="text" class="form-control" id="human" name="human" placeholder="Your Answer">
                            <?php if (!empty($errHuman)) { ?><?php echo "<p class='text-danger'>$errHuman</p>"; ?><?php } ?>

                        </div>
                        <div class="form-group">

                            <input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">

                        </div>

                        <?php if (isset($_GET['success'])) { ?>
                            <div class="alert alert-success fade-in"><a href="#" class="close" data-dismiss="alert"
                                                                        aria-label="close">&times;</a><?php echo $_GET['success'] ?>
                            </div>
                        <?php } ?>

                        <?php if (isset($_GET['err'])) { ?>
                            <div class="alert alert-warning fade-in"><a href="#" class="close" data-dismiss="alert"
                                                                        aria-label="close">&times;</a><?php echo $_GET['err'] ?>
                            </div>
                        <?php } ?>

                        </div>


            </div>


            </div>
            <!-- end of Form Content -->

        </div>
    </div>


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


<!--<link rel="stylesheet" href="css/bootstrap-select.min.css">
 Latest compiled and minified JavaScript -->
<script src="js/bootstrap-select.min.js"></script>


</body>

</html>