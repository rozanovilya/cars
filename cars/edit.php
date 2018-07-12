<?php
session_start();
require_once "pdo.php";
if (!isset($_SESSION['userid'])){
	die("ACCESS DENIED");
}	
$id = $_GET['id'];
$header = "Location: edit.php?id=".htmlentities($id);
$query = $pdo->prepare("SELECT * FROM autos WHERE autos_id=:id");
$query->bindParam(':id',$id);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
if ($row === false)
{
	die("Row not found");
}

if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']))
{

    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1  || strlen($_POST['mileage']) < 1) 
	{
        $_SESSION['message'] = 'All field are required';
        $_SESSION['post'] = $_POST;
        header($header);
        return;
    }
    if (!is_numeric($_POST['year']) )
    {
        $_SESSION['message'] = 'Year must be integer';
        $_SESSION['post'] = $_POST;
        header($header);
        return;
    }
    if (!is_numeric($_POST['mileage']) )
    {
        $_SESSION['message'] = 'Mileage must be integer';
        $_SESSION['post'] = $_POST;        
        header($header);
        return;
    }  
   	$query = $pdo->prepare("UPDATE autos SET 
   		make=:make,model=:model,year=:year, mileage=:mileage
   		WHERE autos_id=:autos_id");
   	$query->bindParam(':autos_id',$id);
	$query->bindParam(':make',$_POST['make']);
	$query->bindParam(':model',$_POST['model']);
	$query->bindParam(':year',$_POST['year']);
	$query->bindParam(':mileage',$_POST['mileage']);
	$query->execute();
	$_SESSION['message']="Record edited";
	header("Location: index.php");
	return;

}    

?>
<html>
<head>
</head>
<body>
<?php	
if (isset($_SESSION['post']) )
{
	$_POST = $_SESSION['post'];
}
else 
{
	$_POST = $row;
}
//var_dump($_POST);
?>		
<form method="post">
Make <input type="text" name="make" value="<?= htmlentities($_POST['make']) ?>"><br>
Model <input type="text" name="model" value="<?= htmlentities($_POST['model']) ?>"><br>
Year <input type="text" name="year" value="<?= htmlentities($_POST['year']) ?>" ><br>
Mileage <input type="text" name="mileage" value="<?= htmlentities($_POST['mileage']) ?>" ><br>
<input type="submit" value="Edit">
</form>	
<?php
 if ( isset($_SESSION['message']))
 {
 	echo "<p>".$_SESSION['message']."</p>";
 }
unset ($_SESSION['message']); 
?>
</body>
</html>