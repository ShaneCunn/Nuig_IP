<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
if (isset($_POST["submit"])) {
    //variables taken in from the contact form
    $name = $_POST['name'];


    $email = $_POST['email'];
    $message = $_POST['message'];
    $human = intval($_POST['human']);
    $from = 'Demo Contact Form';
    $to = 'mayhem2277@gmail.com'; //email address to sent the contact form message to
    $subject = $_POST['subject'];

    $at = strpos($email, "@");
    $dot = strpos($email, ".");
    $subject = strpos($subject, "Default");

//declaring variable so that we don't get a Notice: Undefined variable
    $errName = null;
    $errEmail =null;
    $errHuman =null;
    $errMessage =null;
    $errSubject =null;


    $body = "From: $name\n E-Mail: $email\n Message:\n $message";

    // Check if name is greater than 10 letters long
    if (strlen($name) < 10) {
        $errName = 'Please enter your name and is longer than 10 characters';
    }
// Check if name has been entered
    if (strlen($email) < 10) {
        $errEmail = 'Your Email address needs to be 10 letters or more';
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
    if ($subject ==='Default') {
        $errSubject = 'Please select a subject';
    }
    else{
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

// If there are no errors, send the email
    if (!$errName && !$errEmail && !$errSubject && !$errMessage && !$errHuman) {
        if (mail($to, $subject, $body, $from)) {
            $result = '<div class="alert alert-success">Thank You! I will be in touch</div>';
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bootstrap contact form with PHP example by BootstrapBay.com.">
    <meta name="author" content="BootstrapBay.com">
    <title>Bootstrap Contact Form With PHP Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="page-header text-center">Contact Form Example</h1>
            <form class="form-horizontal" role="form" method="post" action="contact3.php">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="First & Last Name"
                               value=" <?php if(!empty($name)) { ?><?php echo htmlspecialchars($_POST['name']); ?><?php } ?>">

                        <?php if(!empty($errName)) { ?> <?php echo "<p class='text-danger'>$errName</p>"; ?><?php } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="example@domain.com"
                               value=" <?php if(!empty($email)) { ?> <?php echo htmlspecialchars($_POST['email']); ?><?php } ?>">
                        <?php if(!empty($errEmail)) { ?><?php echo "<p class='text-danger'>$errEmail</p>"; ?><?php } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="message" class="col-sm-2 control-label">Subject</label>
                    <div class="col-sm-10">
                    <select class="selectpicker" name="subject">
                        <option disabled>Please select a topic</option>
                        <option value="Sales">Sales</option>
                        <option value="Returns">Returns</option>
                        <option value="Shipping">Shipping</option>
                        <option value="Support">Support</option>
                    </select>
                        <?php if(!empty($errorSubject)) { ?><?php echo "<p class='text-danger'>$errSubject</p>"; ?><?php } ?>
                </div>
        </div>

        <div class="form-group">
            <label for="message" class="col-sm-2 control-label">Message</label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="4"
                          name="message"><?php if(!empty($message)) { ?><?php echo htmlspecialchars($_POST['message']); ?><?php } ?></textarea>
                <?php if(!empty($errMessage)) { ?> <?php echo "<p class='text-danger'>$errMessage</p>"; ?><?php } ?>
            </div>
        </div>
        <div class="form-group">
            <label for="human" class="col-sm-2 control-label">2 + 3 = ?</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="human" name="human" placeholder="Your Answer">
                <?php if(!empty($errHuman)) { ?> <?php echo "<p class='text-danger'>$errHuman</p>"; ?><?php } ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <?php if(!empty($result)) { ?>  <?php echo $result; ?><?php } ?>
            </div>
        </div>
        </form>
    </div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/i18n/defaults-*.min.js"></script>


</body>
</html>