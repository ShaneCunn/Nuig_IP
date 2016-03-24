<?php

session_start();
session_destroy();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Location:index.php?success=" . urlencode("Logged out successfully"));
exit();