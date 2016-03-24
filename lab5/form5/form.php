<?php
$action=$_REQUEST['action'];
if ($action=="")    /* display the contact form */
{
    ?>
    <form  action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="submit">
        Your name:<br>
        <input name="name" type="text" value="" size="30"/><br>
        Your email:<br>
        <input name="email" type="text" value="" size="30"/><br>
        <label for="subject">Subject:</label><br>
       <!-- <select name="subject">
            <option selected="" value="0">Please select a topic</option>
            <option value="1">Sales</option>
            <option value="2">Returns</option>
            <option value="3">Shipping</option>
            <option value="4">Support</option>
        </select><br>-->
        <select name="subject">
            <option selected="" value="Not">Please select a topic</option>
            <option value="Sales">Sales</option>
            <option value="R">Returns</option>
            <option value="Sh">Shipping</option>
            <option value="Su">Support</option>
        </select><br>
        Your message:<br>
        <textarea name="message" rows="7" cols="30"></textarea><br>
        <input type="submit" value="Send email"/>
    </form>
    <?php
}


else                /* send the submitted data */
{
    $name=$_REQUEST['name'];
    $email=$_REQUEST['email'];
    $message=$_REQUEST['message'];

  /*  $subject = array();
    $subject[1] = "Sales";
    $subject[2] = "Returns";
    $subject[3] = "Shipping";
    $subject[4] = "Support";
    $subjectindex = $_REQUEST['subject'];*/

   /* if (($subjectindex == 0)) {
        $subjectErr = "Subject is required";

    } else $subject = $subject[$subjectindex];*/
    if (($name=="")||($email=="")||($subject =="Not")||($message==""))
    {
        echo "All fields are required, please fill <a href=\"\">the form</a> again.";
    }
    else{
        $from="From: $name<$email>\r\nReturn-path: $email";
        $subject = $_REQUEST['subject'];
        //$subject = $subject[$subjectindex];
        mail("shanecunningham@live.ie", $subject, $message, $from);
        echo "Email sent!";
    }
}
?> 