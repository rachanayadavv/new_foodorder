<?php
//Authorization-Access Control

//checl whether the user is loggef in or not
if (!isset($_SESSION['user'])) //if user session is not set
{
    //user is not logged in
    //redirect to login page with message
    $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to Access Admin Panel.</div>";
    //redirect to login page
    header('location:' . SITEURL . 'admin/login.php');
}
