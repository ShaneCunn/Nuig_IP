<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$document_title_tag = 'Administrator Panel';

$link1 =  '';
$link2 =  'class="active"';

include('includes/config.php');
include('includes/db.php');


// The Login function , redirect them out if they haven't signed
include('includes/loginError.php');
//template sections
//The Head section
include('includes/template/head.php');
//The navigation area
include('includes/template/navigation.php');
// The Contact Table
include('includes/template/contactTable.php');
// The Footer area
include('includes/template/footer.php');

   