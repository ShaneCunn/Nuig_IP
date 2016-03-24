<?php
$action=$_REQUEST['action'];
if ($action=="")    /* display the contact form */
{
    ?>
    <form  action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="submit">
        Your name:<br>
        <label>
            <input name="name" type="text" value="" size="30"/>
        </label><br>
        Your email:<br>
        <label>
            <input name="email" type="text" value="" size="30"/>
        </label><br>
        <label for="subject">Subject:</label><br>
       <!-- <select name="subject">
            <option selected="" value="0">Please select a topic</option>
            <option value="1">Sales</option>
            <option value="2">Returns</option>
            <option value="3">Shipping</option>
            <option value="4">Support</option>
        </select><br>-->
        <label>
            <select name="subject">
                <option selected="" value="0">Please select a topic</option>
                <option value="Sales">Sales</option>
                <option value="Returns">Returns</option>
                <option value="Shipping">Shipping</option>
                <option value="Support">Support</option>

            </select>
        </label><br>
        Your message:<br>
        <label>
            <textarea name="message" rows="7" cols="30"></textarea>
        </label><br>
        <input type="submit" value="Send email"/>
    </form>
    <?php
}


else                /* send the submitted data */
{
    $name=$_REQUEST['name'];
    $email=$_REQUEST['email'];
    $message=$_REQUEST['message'];
    $subject = $_REQUEST['subject'];

  /*  $subject = array();
    $subject[1] = "Sales";
    $subject[2] = "Returns";
    $subject[3] = "Shipping";
    $subject[4] = "Support";
    $subjectindex = $_REQUEST['subject'];*/




    if (($name=="")||($email=="")||($subject =='0')||($message==""))
    {
        echo "All fields are required, please fill <a href=\"\">the form</a> again.";
    }
    else{
        $from="From: $name<$email>\r\nReturn-path: $email";
        $subject;
        //$subject = $subject[$subjectindex];
        mail("mayhem2277@gmail.com", $subject, $message, $from);
        echo "Email sent!";
    }
}
?> 