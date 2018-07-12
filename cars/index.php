<?php
session_start();
require_once "pdo.php";
//unset($_POST);
$query = $pdo->prepare("SELECT * FROM autos");
$query->execute();
$cars = $query->fetchAll(PDO::FETCH_ASSOC);
//var_dump($cars);	
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
	if (count($cars)==0)
	{
		echo "<h2>No rows found</h2>";
	}
	else
	{
		echo '<table  border="1">';
			echo "<thead>";
				echo "<td>Make</td>";
				echo "<td>Model</td>";
				echo "<td>Year</td>";
				echo "<td>Mileage</td>";
				echo "<td>Action</td>";
			echo "</thead>";
			foreach ($cars as $car)
			{
				echo "<tr>";
					echo "<td>".$car['make']."</td>";
					echo "<td>".$car['model']."</td>";
					echo "<td>".$car['year']."</td>";
					echo "<td>".$car['mileage']."</td>";
					echo "<td>"."<a href="."edit.php?id=".$car['autos_id'].">Edit</a>"." / "."<a href="."delete.php?id=".$car['autos_id'].">Delete</a>"."</td>";
				echo "<tr>";
			}


		echo "</table>";
	}
	if (isset($_SESSION['message']))
	{
		echo "<p>".$_SESSION['message']."<p>";
	}
	echo '<a href="add.php">Add new entry</a><br>';
	echo '<a href="logout.php">Log out</a>';
}
unset($_SESSION['message']);
unset($_SESSION['post']);
?>
</body>

</html>	