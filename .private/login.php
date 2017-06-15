<?php

	session_start();

	if ((!isset($_POST['login'])) || (!isset($_POST['password'])))
	{
		header('Location: index');
		exit();
	}

	require_once "connect.php";


	if ($conn->connect_errno!=0)
	{
		echo "Error: ".$conn->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$haslo = $_POST['password'];

		$login = htmlentities($login, ENT_QUOTES, "UTF-8");

		if ($rezultat = @$conn->query(
		sprintf("SELECT * FROM users WHERE user='%s'",
		mysqli_real_escape_string($conn,$login))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();

				if (password_verify($haslo, $wiersz['pass']))
				{
					$_SESSION['logged-in'] = true;
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['user'] = $wiersz['user'];
					$_SESSION['pass'] = $wiersz['pass'];
					$_SESSION['imie'] = $wiersz['imie'];
					$_SESSION['nazwisko'] = $wiersz['nazwisko'];
					unset($_SESSION['blad']);
					$rezultat->free_result();
					header('Location:/main');

				}
				else
				{
					$_SESSION['blad'] = '<div class="error"><span class="text-center" style="color:red;">Nieprawidłowy login lub hasło!</span></div>';
					header('Location: index');
				}

			} else {
					$_SESSION['blad'] = '<div class="error"><span class="text-center" style="color:red;">Nieprawidłowy login lub hasło!</span></div>';
					header('Location: index');
			}

		}

		$conn->close();
	}

?>
