<?php

include '../opendb.php';
include_once('../func.php');


$id = $_GET["id"];
    mysqli_query($mysql_conn, "DELETE FROM financeiro WHERE idfinanceiro='$id'");
	header('location: financeiro.php' );

	
?>