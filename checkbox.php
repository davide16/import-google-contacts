<?php

include '../user/database.php';
$checkbox1= $_POST['chk1'];
if ($_POST["Submit"]=="Submit")
{
    for($i=0; $i<sizeof($checkbox1); $i++){
     $query= "INSERT INTO contatti ('id', 'nome', 'cognome', 'email', 'data') VALUES(".$checkbox1[$i].")  "
    mysql_query($query) or die(mysql_error())
     }
     echo 'Record is inserted';
 }
 ?>