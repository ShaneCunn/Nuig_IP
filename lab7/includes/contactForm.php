<?php
if (isset($_POST["submit"])) {
    //variables taken in from the contact form
    global $db;
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

}