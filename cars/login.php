<?php
session_start(); 
require_once "pdo.php";
//unset($_SESSION['userid']);

$email = htmlentities($_POST['email']);
$pass = htmlentities($_POST['pass']);
$options = [
    'cost' => 11,
    'salt' => "Соленый текст для соли",
//я знаю, что сейчас метод со своем солью устарел, но пара функций password_hash и password_verify не заработала из-за проблем с кавычками    
];
$hash = password_hash($pass, PASSWORD_BCRYPT, $options);
if (isset($email) &&  isset($pass))
{
	$query = $pdo->prepare("SELECT user_id, name, email, password FROM users WHERE email=:email" );
	$query->bindParam(':email',$email);
	$query->execute();
	$row = $query->fetch(PDO::FETCH_ASSOC);

	if (!isset($row['email'])) {
		//echo "E-mail not found";
		$errormessage = "Email not found";
	}
	else
		if ($hash == $row['password'])
		 {
			$_SESSION['userid']= $row['user_id'];
			unset($errormessage);
			header('Location: index.php');
		}
		else
		{
			//echo "Password is incorrect";
			$errormessage = "Password is incorrect";
		}
}
 ?>



<body>
<h1> Enter e-mail and password</h1>
<?php
if (isset($errormessage)) echo "<p>".$errormessage."</p>";
	?>
<form method="post">
E-mail <input type="text" name="email"><br/>
Password <input type="text" name="pass"><br/>
<input type="submit" value="Log in">	

</form>	
</body>	