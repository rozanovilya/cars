<?php
session_start();
require_once "pdo.php";
if (!isset($_SESSION['userid'])){
	die("ACCESS DENIED");
}		
if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']))
{

    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1  || strlen($_POST['mileage']) < 1) 
	{
        $_SESSION['message'] = 'All field are required';
        $_SESSION['post'] = $_POST;
        header("Location: add.php");
        return;
    }
    if (!is_numeric($_POST['year']) )
    {
        $_SESSION['message'] = 'Year must be integer';
        $_SESSION['post'] = $_POST;
        header("Location: add.php");
        return;
    }
    if (!is_numeric($_POST['mileage']) )
    {
        $_SESSION['message'] = 'Mileage must be integer';
        $_SESSION['post'] = $_POST;        
        header("Location: add.php");
        return;
    }    

	$query = $pdo->prepare("INSERT INTO autos (make,model,year,mileage)
			VALUES (:make,:model,:year,:mileage)");
	$query->bindParam(':make',$_POST['make']);
	$query->bindParam(':model',$_POST['model']);
	$query->bindParam(':year',$_POST['year']);
	$query->bindParam(':mileage',$_POST['mileage']);
	$query->execute();
	$_SESSION['message']="Record added";
	header("Location: index.php");
	return;


}	

?>
<html>
<head>
</head>
<body>
<?php
$_POST = $_SESSION['post'];
//var_dump($_POST);
?>	
<form method="post">
Make <input type="text" name="make" value="<?= htmlentities($_POST['make']) ?>"><br>
Model <input type="text" name="model" value="<?= htmlentities($_POST['model']) ?>"><br>
Year <input type="text" name="year" value="<?= htmlentities($_POST['year']) ?>" ><br>
Mileage <input type="text" name="mileage" value="<?= htmlentities($_POST['mileage']) ?>" ><br>
<input type="submit" value="Add new entry">
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