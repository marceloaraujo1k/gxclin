<?php

include '../opendb.php';
include_once('../func.php');


$id = $_GET["id"];
print_r($id);
   mysqli_query($mysql_conn, "DELETE FROM procedimentos WHERE idprocedimentos='$id'");
   header('location: convenios.php');

	
?>