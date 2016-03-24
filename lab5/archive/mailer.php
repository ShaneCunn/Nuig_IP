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


/* Set e-mail recipient */c
$sentEmail = "S.CUNNINGHAM18@nuigalway.ie";

/* Check all form inputs using check_input function */
$username = check_input($_POST['username'], "Enter your name");
$subject = check_input($_POST['subject'], "Enter a subject");
$email = check_input($_POST['email']);
$message = check_input($_POST['message'], "Write your message");
$at = strpos($email, "@");
$dot = strpos($email,  ".");
/* If e-mail is not valid show error message */
//if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email))

if (strlen($username) <= 10)
    //if (!preg_match('/^[A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $email))
{
    show_error("your name needs to be 10 letters or more");
   // echo '<script type="text/javascript">alert("your name needs to be 10 letters or more ");</script>';
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

Name: $username
E-mail: $email
Subject: $subject

Message:
$message

";

/* Send the message using mail() function */
$from="From: $username<$email>\r\nReturn-path: $email";
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



    echo "<script type='text/javascript'>alert(' hello{$myError}');</script>
   <!-- <html>
    <body>

    <p>Please correct the following error:</p>
    <strong><?php /*echo $myError; */?></strong>
    <p>Hit the back button and try again</p>

    </body>
    </html>-->
    }c

    <?php
    exit();
}
?>
