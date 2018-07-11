<?php
session_start(); 
require_once "pdo.php";
//unset($_SESSION['userid']);
unset($_SESSION['errormessage']);
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
	if (strlen($email) >1)
	{
	$query = $pdo->prepare("SELECT user_id, name, email, password FROM users WHERE email=:email" );
	$query->bindParam(':email',$email);
	$query->execute();
	$row = $query->fetch(PDO::FETCH_ASSOC);

	if (!isset($row['email'])) {
		//echo "E-mail not found";
		$_SESSION['errormessage'] = "Email not found";
//		header("Location : login.php"); //если раскоментировать эти строчки, сервер отдает 500 ошибку, непонятно почему, в файле add.php аналогичный код работает
//		return;
	}
	else
		if ($hash == $row['password'])
		 {
			$_SESSION['userid']= $row['user_id'];
			unset($_SESSION['errormessage']);
			header("Location: index.php");
			return;
		}
		else
		{
			//echo "Password is incorrect";
			$_SESSION['errormessage'] = "Password is incorrect";
	//		header("Location : login.php");
	//		return;
		}
	}	

}
 ?>



<body>
<h1> Enter e-mail and password</h1>
<?php
if (isset($_SESSION['errormessage'])) echo "<p>".$_SESSION['errormessage']."</p>";
unset($_SESSION['errormessage']);
	?>
<form method="post">
E-mail <input type="text" name="email"><br/>
Password <input type="text" name="pass"><br/>
<input type="submit" value="Log in">	

</form>	
</body>	