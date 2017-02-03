<?php
include('config/db_con.php');
$_SESSION['user'] = '';
$_SESSION['userId'] = '';
$_SESSION['userFullName'] = '';

unset($_SESSION['user']);
unset($_SESSION['userId']);
unset($_SESSION['userFullName']);

header('Location: login.php');
?>