<?php
//start session
session_start();

// Create constants to store non-repeating values
define('SITEURL', 'http://localhost/food-order/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root'); // Fixed a typo here, replaced '.' with ','
define('DB_PASSWORD', '');
define('DB_NAME', 'food-order'); // Added a missing semicolon here

$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME, 3307) or die("Connection failed: " . mysqli_connect_error());
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error()); // Used constants without quotes