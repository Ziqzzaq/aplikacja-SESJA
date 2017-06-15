<?php

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/public_html/.private/connect.php');


if ($conn->connect_errno!=0)
{
  echo "Error: ".$conn->connect_errno;
}
else
{
  $date=date('Y-m-d');
  $result2=$conn->query(sprintf("SELECT * FROM users"));
  while ($data = $result2->fetch_assoc()){
    $result=$conn->query(sprintf("SELECT * FROM ".$data['user']));
  while ($mail = $result->fetch_assoc()){
  if($date==$mail['day']){
    $adres = $data['email'];
    $tytul = $mail['name'];
    $wiadomosc = $mail['content'];

    // użycie funkcji mail
    mail($adres, $tytul, $wiadomosc);
    echo "Wysłano !!!";
  }else{
    echo "No niestety nie :P";
  }
}
}
}
?>
