
<?php
session_start();
require_once "pdo.php";
//unset($_POST);

?>
<html>
<head>

</head>

<body>
<h1>Welcome to the cars database</h1>
<?php
//var_dump($_SESSION);
 if (!isset($_SESSION['userid'])) { 
 echo '<a href="login.php">Please log in</a><br>';
}
else {
	echo '<a href="logout.php">Log out</a>';
}
?>
</body>

</html>	