<?php
/**
 * Created by PhpStorm.
 * User: shane
 * Date: 23/03/2016
 * Time: 12:32
 */

include('includes/config.php');
include('includes/db.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if(isset($_GET['token'])){

    $token = $_GET['token'];
    $query = "update users set status='1' where token='$token'";
    if($db->query($query)){

        header("Location:login.php?success= Account Activated!");
        exit();
    }


}
