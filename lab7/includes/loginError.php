<?php
/**
 * Created by PhpStorm.
 * User: 15104623
 * Date: 29/03/2016
 * Time: 10:40
 */

if (!isset($_SESSION['user_email'])) {
    header("Location:login.php?err=" . urldecode("You need to login to view the stock page."));
    exit();
}