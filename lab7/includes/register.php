<?php

if (isset($_POST['register'])) {
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['confirm_password'] = $_POST['confirm_password'];
    if (strlen($_POST['name']) < 3) {
        header("Location:register.php?err=" . urlencode("The name must be 3 characters long"));
        exit();

    } else if ($_POST['password'] != $_POST['confirm_password']) {
        header("Location:register.php?err=" . urlencode("The password and confirm password must match"));
        exit();
    } else if (strlen($_POST['confirm_password']) < 5) {
        header("Location:register.php?err=" . urlencode("The password must be greater than 5 characters long"));
        exit();
    } elseif (strlen($_POST['confirm_password']) < 5) {
        header("Location:register.php?err=" . urlencode("The confirm password must be greater than 5 characters long"));
        exit();
    } elseif (!isUnique($_POST['email'])) {
        header("Location:register.php?err=" . urlencode("The email is already in use. Please enter a different email"));
        exit();

    } else {
        global $db;

        $name = mysqli_real_escape_string($db, $_POST['name']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $token = bin2hex(openssl_random_pseudo_bytes(32));

        $query = "insert into users(name,email,password,token) values('$name','$email','$password','$token')";

        $db->query($query);
        $messsage = "Hi $name! account created, here is the activation link: http://nuig.brtd.net/registration/activate.php?token=$token";

        mail($email, 'Activate account', $messsage, 'From: mayhem2277@gmail.com');
        header("Location:login.php?success=" . urldecode("Activation email sent!"));
        // Closing the connection as a best practice

        mysqli_close($db);


    }

}