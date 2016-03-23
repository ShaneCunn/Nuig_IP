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

if (isset($_POST["submit"])) {
    //variables taken in from the contact form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $human = intval($_POST['human']);

    // uncomment the code line below to change the from email
    //$from = 's.cunningham18@nuigalway.ie';
    $from = $email;
    $to = 'mayhem2277@yahoo.com'; //email address to sent the contact form message to
    $subject = $_POST['subject'];
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
    $result = null;


    $body = "From: $name\n E-Mail: $email\n Message:\n $message";

    // Check if name is greater than 10 letters long
    if (strlen($name) < 10) {
        $errName = 'Please enter your name and is longer than 10 characters';
    }
    // Check if name has been entered
    if (strlen($email) < 10) {
        $errEmail = 'Your message needs to be 10 letters or more';
    }

    // Check if email the @ symbol has been entered
    if ($at === false) {
        $errEmail = 'E-mail address require @ symbol';
    }

    // Check if email the . symbol has been entered
    if ($dot === false) {
        $errEmail = 'E-mail address require a dot in it';
    }

    // Check if the default subject has been entered
    if ($subject === 'Default') {
        $errSubject = 'Please select a subject';
    } else {
        $errSubject = '';
    }

    // Check if message is greater than 25 letters long
    if (strlen($message) < 25) {
        $errMessage = 'Your message needs to be 25 letters or more';
    }
    //Check if simple anti-bot test is correct
    if ($human !== 5) {
        $errHuman = 'Your anti-spam is incorrect';
    }

    // If there are no errors, it then sends the email
    if (!$errName && !$errEmail && !$errSubject && !$errMessage && !$errHuman) {
        if (mail($to, $subject, $body, $from)) {
            $result = '<div class="alert alert-success">Thank You! we will be in touch within 2 days.</div>';
        } else {
            $result = '<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later.</div>';
        }
    }
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
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
   <!-- <script src="js/html5shiv.js"></script>-->


    <!--<link rel="stylesheet" href="css/form.css" type="text/css"/>-->


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
                    <a href="#">spare 1</a>
                </li>
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
                <a class="list-group-item" href="#">Category 3</a>
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

                <textarea class="form-control" rows="4"
                          name="message"
                          placeholder="Enter your message for us here. We will get back to you within 2 business days.">
                    <?php if (!empty($message)) { ?><?php echo htmlspecialchars($_POST['message']); ?><?php } ?></textarea>
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
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <?php if (!empty($result)) { ?><?php echo $result; ?><?php } ?>
                            </div>
                        </div>
                    </form>

                </div>


            </div>
            <!-- end of Form Content -->

        </div>
    </div>


    <!-- Address content -->

    <!--        <div class="col-sm-3 col-md-6 col-lg-4">
                <address>
                    <h3>Office Location</h3>

                    <p class="lead"><a href="https://goo.gl/maps/rCFeodD6YvK2">National University of
                            Ireland Galway<br>
                            University Rd, Galway</a>
                        <br> Phone: 091-524-411<br>
                        Email: <a href="mailto:info@nuigalway.ie">info@nuigalway.ie</a></p>
                </address>
            </div>-->


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

<!-- /.container -->
<!-- jQuery -->
<!--<script src="js/jquery.js"></script>
<!-- Bootstrap Core JavaScript -->
<!--<script src="js/bootstrap.min.js"></script>-->-->
<!-- Form validation   -->



<!-- Latest compiled and minified CSS -->
<!--<link rel="stylesheet" href="css/bootstrap-select.min.css">
 Latest compiled and minified JavaScript -->
<script src="js/bootstrap-select.min.js"></script>


</body>

</html>