<html>
<head>
    <style>
        .error {
            color: #FF0000;
        }
    </style>
</head>
<body>

<?php
// define variables and set to empty values
$nameErr = $emailErr = $subjectErr = "";
$name = $email = $message = $subject = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
        }
    }

    $subject = array();
    $subject[1] = "Sales";
    $subject[2] = "Returns";
    $subject[3] = "Shipping";
    $subject[4] = "Support";
    $subjectindex = $_REQUEST['subject'];
    $emailaddress = "shanecunningham@live.ie";

    if (($subjectindex == 0)) {
        $subjectErr = "Subject is required";

    } else $subject = $subject[$subjectindex];

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }


    if (empty($_POST["message"])) {
        $message = "";
    } else {
        $message = test_input($_POST["message"]);
    }

    /*    if (empty($_POST["gender"])) {
            $genderErr = "Gender is required";
        } else {
            $gender = test_input($_POST["gender"]);
        }*/
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<h2>PHP Form Validation Example</h2>

<p><span class="error">* required field.</span></p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Name: <input type="text" name="name">
    <span class="error">* <?php echo $nameErr; ?></span>
    <br><br>
    E-mail: <input type="text" name="email">
    <span class="error">* <?php echo $emailErr; ?></span>
    <br><br>
    <!--    Website: <input type="text" name="website">-->
    <!--    <span class="error">--><?php //echo $websiteErr;?><!--</span>-->
    <!-- <br><br>-->
    <label for="subject">Subject:</label>

    <select name="subject">
        <option selected="" value="0">Please select a topic</option>
        <option value="1">Sales</option>
        <option value="2">Returns</option>
        <option value="3">Shipping</option>
        <option value="4">Support</option>
    </select>
    <span class="error">* <?php echo $subjectErr; ?></span>

    <!-- <span class="error">* <?php /*echo $nameErr; */ ?></span>
    <span class="error"><?php /*echo $websiteErr; */ ?></span>-->
    <br><br>
    Message: <textarea name="message" rows="5" cols="40"></textarea>
    <br><br>
    <!-- Gender:
    <input type="radio" name="gender" value="female">Female
    <input type="radio" name="gender" value="male">Male
    <span class="error">* <?php /*echo $genderErr;*/ ?></span>
    <br><br>-->
    <input type="submit" name="submit" value="Submit">
</form>

<?php
echo "<h2>Your Input:</h2>";
echo $name;
echo "<br>";
echo $email;
echo "<br>";
//echo $website;
//echo "<br>";
echo $message;
echo "<br>";
echo $subject;
echo "<br>";
echo $gender;
?>

<?php
if (isset($_POST['submit'])) {
    $to = "shanecunningham@live.ie"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $first_name = $_POST['name'];
    // $last_name = $_POST['last_name'];
//    $subject = "Form submission";
    $subject;
    $subject2 = "Copy of your form submission";
    $message = $first_name . " " . $last_name . " wrote the following:" . "\n\n" . $_POST['message'];
    $message2 = "Here is a copy of your message " . $first_name . "\n\n" . $_POST['message'];

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    mail($to, $subject, $message, $headers);
    mail($from, $subject2, $message2, $headers2); // sends a copy of the message to the sender
    echo "Mail Sent. Thank you " . $name . ", we will contact you shortly.";
    // You can also use header('Location: thank_you.php'); to redirect to another page.
}
?><?php

</body>
</html>

