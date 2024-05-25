<?php

// Include constants.php file here
include('../config/constants.php');

// 1. Get the ID of admin to be deleted
$id = $_GET['id'];

// 2. Create SQL Query to delete admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

// Execute the query
$res = mysqli_query($conn, $sql);

// Check whether the query executed successfully or not
if ($res == true) {
    // Query executed successfully and admin deleted
    $_SESSION['delete'] = "<div class='success'>Admin deleted successfully.</div>";
    // Redirect to manage admin page with success message
    header("location:" . SITEURL . 'admin/manage-admin.php');
} else {
    // Failed to delete admin
    $_SESSION['delete'] = "<div class='error'>Failed to delete admin. Try again later.</div>";
    // Redirect to manage admin page with error message
    header("location:" . SITEURL . 'admin/manage-admin.php');
}
