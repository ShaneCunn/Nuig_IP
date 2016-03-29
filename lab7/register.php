<?php
/**
 * Created by PhpStorm.
 * User: shane
 * Date: 23/03/2016
 * Time: 12:32
 */

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$link1 =  null;
$link2 =  null;
$link3 =  null;
$link4 =  'class="active"';
include('includes/config.php');
include('includes/db.php');
include('includes/functions.php');
include('includes/register.php');

//template sections
//The Head section
include('includes/template/head.php');
//The navigation area
include('includes/template/navigation.php');
include('includes/template/registerForm.php');

// The Footer area
include('includes/template/footer.php');
?>






