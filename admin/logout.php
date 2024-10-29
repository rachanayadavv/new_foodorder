<?php

///inclued constants.php for siteurl
include('../config/constants.php');

//1.destory the session
session_destroy();//unsets $_Session['user]

//2redirect to login page
header('location:' . SITEURL . 'admin/login.php');
