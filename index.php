<?php
session_start();

if ((isset($_SESSION['logged-in'])) && ($_SESSION['logged-in']==true))
{
  header('Location:/main');
}

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/public_html/.private/connect.php');
?>


<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SESJA-razem zdamy !</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/index.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

<div class="login-container">
  <section class="login" id="login">
    <header>
      <h2>Sesja v1.0</h2>
      <h4>Login</h4>
    </header>
    <form class="login-form" action="login" method="post">
      <input type="text" class="login-input" name="login" placeholder="Login" required autofocus/>
      <input type="password" class="login-input" name="password" placeholder="Hasło" required/>
      <div class="submit-container">
        <button type="submit" class="login-button">Zaloguj</button>
      </div>
    </form>
  </section>
</div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/index.js"></script>
  </body>
</html>
