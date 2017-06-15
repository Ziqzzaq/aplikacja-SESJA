<?php

session_start();

if(isset($_SESSION['logged-in']))
{
	header('Location:/index');
	exit();
}

if(isset($_POST['email']))
{
	//udana walidacja
	$ok=true;



	//sprawdzenie loginu
	$login = $_POST['login'];
	//sprawdzenie dlugosci loginu
	if(strlen($login)<3 || strlen($login)>20)
	{
		$ok=false;
		$_SESSION['e_login']="Login musi posiadać od 3 do 20 znaków !";
	}
	//sprawdzanie znaków loginu
	if(ctype_alnum($login)==false)
	{
		$ok=false;
		$_SESSION['e_login']="Login może składać się tylko z liter i liczb(bez polskich znaków)";

	}

	//sprawdzenie imienia
	$imie = $_POST['imie'];
	//sprawdzenie dlugosci imienia
	if(strlen($imie)<3 || strlen($imie)>20)
	{
		$ok=false;
		$_SESSION['e_imie']="Imie musi posiadać od 3 do 20 znaków !";
	}

	//sprawdzenie nazwiska
	$nazwisko = $_POST['nazwisko'];
	//sprawdzenie dlugosci nazwiska
	if(strlen($nazwisko)<3 || strlen($nazwisko)>20)
	{
		$ok=false;
		$_SESSION['e_nazwisko']="Nazwisko musi posiadać od 3 do 20 znaków !";
	}

	//sprawdzenie mail
	$email = $_POST['email'];
	$emailb = filter_var($email,FILTER_SANITIZE_EMAIL);
	if((filter_var($emailb,FILTER_VALIDATE_EMAIL)==false) || ($emailb!=$email))
	{
		$ok=false;
		$_SESSION['e_email']="Podaj poprawny adres e-mail";
	}


	//sprawdzenie hasla
	$haslo1 = $_POST['haslo1'];
	$haslo2 = $_POST['haslo2'];
	//sprawdzenie dlugosci hasla
	if(strlen($haslo1)<8 || strlen($haslo1)>20)
	{
		$ok=false;
		$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków !";
	}
	if($haslo1!=$haslo2)
	{
		$ok=false;
		$_SESSION['e_haslo']="Podane hasła nie są identyczne !";
	}


	$haslo_hash=password_hash($haslo1,PASSWORD_DEFAULT);
	//regulamin

	if(!isset($_POST['regulamin']))
	{
		$ok=false;
		$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
	}




	define('__ROOT__', dirname(dirname(__FILE__)));
	require_once(__ROOT__.'/public_html/.private/connect.php');

	mysqli_report(MYSQLI_REPORT_STRICT); //rzucamy wyjatki zamiast ostrzezen
	try
	{
		if ($conn->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());

		}
		else
		{
			//czy email juz istnieje
			$rezultat = $conn->query("SELECT id FROM users WHERE email='$email'");

			if(!$rezultat) throw new Exception($polacznie->error);

			$ile_takich_maili = $rezultat->num_rows;
			if($ile_takich_maili>0){

				$wszystko_OK=false;
				$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
			}

			//czy login juz istnieje
			$rezultat = $conn->query("SELECT id FROM users WHERE user='$login'");

			if(!$rezultat) throw new Exception($polacznie->error);

			$ile_takich_loginow = $rezultat->num_rows;
			if($ile_takich_loginow>0){

				$wszystko_OK=false;
				$_SESSION['e_login']="Istnieje już uzytkownik o takim loginie!";
			}


			if($ok==true)
			{

				//Brawo,wszystko dobrze
				if($conn->query("INSERT INTO users VALUES (NULL,'$imie','$nazwisko','$login','$haslo_hash','$email')"))
				{

					$_SESSION['udana_rejestracja']=true;
					header('Location:witamy');

				}
				else
				{

					throw new Exception($polacznie->error);

				}

			}

			$conn->close();
		}
	}
	catch(Exception $e)
	{
		echo'Błąd serwera! Przepraszam za niedogodności i proszę o rejestrację w innym terminie!';
	}
}



?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Załóż konto</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<link href="css/rej_css.css" rel="stylesheet" type="text/css" />
	<link href='http://fonts.googleapis.com/css?family=Advent+Pro&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
</head>

<body>

	<form method="POST">

		Imię: <br /> <input type="text" name="imie" /><br />

		<?php
		if(isset($_SESSION['e_imie']))
		{
			echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
			unset($_SESSION['e_imie']);
		}
		?> <br />

		Nazwisko: <br /> <input type="text" name="nazwisko" /><br /> <br />

		<?php
		if(isset($_SESSION['e_nazwisko']))
		{
			echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
			unset($_SESSION['e_nazwisko']);
		}
		?>
		Login: <br /> <input type="text" name="login" /><br />
		<?php
		if(isset($_SESSION['e_login']))
		{
			echo '<div class="error">'.$_SESSION['e_login'].'</div>';
			unset($_SESSION['e_login']);
		}
		?><br />
		Hasło: <br /> <input type="password" name="haslo1" /><br />
		<?php
		if(isset($_SESSION['e_haslo']))
		{
			echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
			unset($_SESSION['e_haslo']);
		}
		?><br />
		Powtórz hasło: <br /> <input type="password" name="haslo2" /><br /> <br />
		E-mail: <br /> <input type="text" name="email" /><br />
		<?php
		if(isset($_SESSION['e_email']))
		{
			echo '<div class="error">'.$_SESSION['e_email'].'</div>';
			unset($_SESSION['e_email']);
		}
		?><br />
		<label>
			<input type="checkbox" name="regulamin" /> Akceptuję regulamin
		</label>
		<?php
		if(isset($_SESSION['e_regulamin']))
		{
			echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
			unset($_SESSION['e_regulamin']);
		}
		?><br />

		<input type="submit" value="Zarejestruj się" />
	</form>
	<br />
	<footer>

		<a href="/panel">Masz już konto ? Zaloguj się !</a>

	</footer>


</body>
</html>
