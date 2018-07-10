<?php
session_start();
unset($_SESSION['userid']);
//session_destroy();
//var_dump($_SESSION);
header('Location: index.php');