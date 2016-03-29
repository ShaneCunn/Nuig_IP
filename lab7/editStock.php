<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('includes/config.php');
include('includes/db.php');
global $db;

// Database functions
// The Delete function
include('includes/delete.php');
// The update function
include('includes/update.php');
//  The add stock function
include('includes/submit.php');

// The Login function , redirect them out if they haven't signed
include('includes/loginError.php');

//template sections
//The Head section
include('includes/template/head.php');
//The navigation area
include('includes/template/navigation.php');
// The Table Area
include('includes/template/table.php');
//The add stock form
include('includes/template/addStock.php');
// The Footer area
include('includes/template/footer.php');
