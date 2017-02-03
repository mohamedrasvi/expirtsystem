<?php
include '../config/db_con.php';

$_SESSION['admin'] = '';
$_SESSION['adminId'] = '';
$_SESSION['adminFullName'] = '';

unset($_SESSION['admin']);
unset($_SESSION['adminId']);
unset($_SESSION['adminFullName']);

header('Location: index.php');
?>