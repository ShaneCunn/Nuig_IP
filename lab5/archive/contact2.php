<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Created by PhpStorm.
 * User: 15104623
 * Date: 07/01/2016
 * Time: 15:09
 */


/* Set e-mail recipient */
$sentEmail = "shanecunningham@live.ie";

/* Check all form inputs using check_input function */
$name = check_input($_POST['name'], "Enter your name");
$subject = check_input($_POST['subject'], "Enter a subject");
$email = check_input($_POST['email']);
$message = check_input($_POST['message'], "Write your message");
$at = strpos($email, "@");
$dot = strpos($email,  ".");
/* If e-mail is not valid show error message */
//if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email))

if (strlen($name) <= 10)
    //if (!preg_match('/^[A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $email))
{
    show_error("your name needs to be 10 letters or more");
}



if ($at === false)

//if (!preg_match('/^([a-z0-9_\.-]+\@[\da-z\.-]+\.[a-z\.]{2,6})$/', $email))

{
    show_error("E-mail address require at symbol");
}

if ($dot === false)


{
    show_error("E-mail address require a dot in it");
}
if (strlen($message) < 25)
    //if (!preg_match('/^[A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $email))
{
    show_error("Your message needs to be 25 letters or more");
}

/* Let's prepare the message for the e-mail */
$message = "

Name: $name
E-mail: $email
Subject: $subject

Message:
$message

";

/* Send the message using mail() function */
$from="From: $name<$email>\r\nReturn-path: $email";
mail($sentEmail, $subject, $message, $from);

/* Redirect visitor to the thank you page */
header('Location: thanks.html');
exit();

/* Functions we used */
function check_input($data, $problem='')
{
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
if ($problem && strlen($data) == 0)
{
show_error($problem);
}
return $data;
}

function show_error($myError)
{
?>
<html>
<body>

<p>Please correct the following error:</p>
<strong><?php echo $myError; ?></strong>
<p>Hit the back button and try again</p>

</body>
</html>
<?php
    exit();
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
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
   <!-- <script src="js/html5shiv.js"></script>-->


    <link rel="stylesheet" href="css/form.css" type="text/css"/>


   <!-- <script>
        function formValidation() {
            var uname = document.contact.username;
            var uemail = document.contact.email;
            var usubject = document.contact.subject;
            var umessage = document.contact.message;
            if (allLetter(uname)) {
                if (ValidateEmail(uemail)) {
                    if (subjectSelect(usubject)) {
                        if (validmessage(umessage)) {
                        }
                    }
                }
            }
            return false;
        }

        function allLetter(uname) {
            var letters = /^[A-Za-z]{10,}$/;
            if (uname.value.match(letters)) {
                return true;
            }
            else {
                alert('Your name must have alphabet characters only and be at least 10 letters long');
                uname.focus();
                return false;
            }
        }

        function ValidateEmail(uemail) {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (uemail.value.match(mailformat)) {
                return true;
            }
            else {
                alert("You have entered an invalid email address!");
                uemail.focus();
                return false;
            }
        }

        function subjectSelect(usubject) {
            if (usubject.value == "Default") {
                alert('Select your subject from the list');
                usubject.focus();
                return false;
            }
            else {
                return true;
            }
        }

        function validmessage(umessage) {
            var letters = /^[0-9a-zA-Z]{25,}$/;
            if (umessage.value.match(letters)) {
                alert('Your Question Will Be Answered Soon!');
                window.location.reload();
                return true;
            }
            else {
                alert('Message must be alphanumeric characters only and at least 25 letters');
                umessage.focus();
                return false;
            }
        }


    </script>-->

    <![endif]-->
</head>


<body onload="document.contact.username.focus();">
<!-- Navigation -->

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->

        <div class="navbar-header">
            <button class="navbar-toggle" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse"
                    type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">National University of Ireland Galway</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="index.html">Home</a>
                </li>

                <li>
                    <a href="about.html">About</a>
                </li>

                <li>
                    <a href="contact.html">Contact</a>
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

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<!-- Page Content -->

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <p class="lead">NUIG Shop</p>

            <div class="list-group">
                <a class="list-group-item" href="index.html">Home</a>
                <a class="list-group-item" href="about.html">About</a>
                <a class="list-group-item" href="contact.html">Contact</a>
                <a class="list-group-item" href="special_offers.html">Special Offers</a> <a class="list-group-item"
                                                                                            href="links.html">Useful
                links</a>
                <a class="list-group-item" href="clock.html">Clock</a>
            </div>
        </div>

        <div class="col-md-9">

            <!-- Team Members Row -->
            <div class="row">
                <div class="col-lg-9">
                    <h2 class="page-header">Our Team</h2>
                </div>
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
                <!-- /.container -->
                <!-- Form Content -->
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <br>

                            <p></p>

                            <div class="col-lg-9">
                                <h2 class="page-header">Contact us</h2>
                            </div>
                        </div>
                        <div class="col-lg-6">

                            <!--<form name='contact' onSubmit="return formValidation();">-->
                            <form name='contact' action="mailer.php" method="post">
                                <ul>

                                    <li><label for="username">Name:</label></li>
                                    <li><input type="text" name="username" size="50" placeholder="Enter Name"/></li>
                                    <li><?php echo "<p class='text-danger'>$errName</p>";?></li>
                                    <li><label for="email">Email:</label></li>
                                    <li><input type="text" name="email" size="50" placeholder="Enter Email"/></li>

                                    <li><label for="subject">Subject:</label></li>
                                    <li><label>
                                        <select name="subject">
                                            <option selected="" value="Default">Please select a topic</option>
                                            <option value="Sales">Sales</option>
                                            <option value="Returns">Returns</option>
                                            <option value="Shipping">Shipping</option>
                                            <option value="Support">Support</option>
                                        </select>
                                    </label></li>

                                    <li><label for="message">Message:</label></li>
                                    <li><textarea name="message" id="desc"
                                                  placeholder="Please enter your message"></textarea></li>


                                    <li><input type="submit" name="submit" value="Submit"/></li>
                                </ul>
                            </form>
                        </div>
                        <!-- Address content -->
                        <hr class="featurette-divider hidden-lg">
                        <div class="col-lg-5 col-md-push-1">
                            <address>
                                <h3>Office Location</h3>

                                <p class="lead"><a href="https://goo.gl/maps/rCFeodD6YvK2">National University of
                                    Ireland Galway<br>
                                    University Rd, Galway</a>
                                    <br> Phone: 091-524-411<br>
                                    Email: <a href="mailto:info@nuigalway.ie">info@nuigalway.ie</a></p>
                            </address>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- /.container -->

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
<!-- jQuery -->
<script src="js/jquery.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<!-- Form validation   -->
<!--<script src="js/valid.js"></script>-->
</body>

</html>


