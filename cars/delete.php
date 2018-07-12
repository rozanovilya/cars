<?php
session_start();
require_once "pdo.php";
if (!isset($_SESSION['userid'])){
	die("ACCESS DENIED");
}
$id = $_GET['id'];
//$header = "Location: edit.php?id=".htmlentities($id);
$query = $pdo->prepare("SELECT * FROM autos WHERE autos_id=:id");
$query->bindParam(':id',$id);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
if ($row === false)
{
	die("Row not found");
}

if (isset($_POST['delete']))
{
	$query = $pdo->prepare("DELETE FROM autos WHERE autos_id = :id");
	$query->bindParam(':id',$id);
	$query->execute();
	$_SESSION['message']="Row deleted";
	header( 'Location: index.php' ) ;
    return;
}

?>
<body>
<p>Are you sure to delete the record?<p>	
<table border="1">
	<thead>
		<td>Make</td>
		<td>Model</td>
		<td>Year</td>
		<td>Mileage</td>
	</thead>
	<tr>
		<td><?= htmlentities($row['make']) ?></td>
		<td><?= htmlentities($row['model']) ?></td>
		<td><?= htmlentities($row['year']) ?></td>
		<td><?= htmlentities($row['mileage']) ?></td>
	</tr>	
</table>
<form method="post">
<input type="submit" value="Delete" name="delete">
<br> <a href="index.php">Cancel</a>	

</body>	