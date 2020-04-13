<?php

include '../opendb.php';
include_once('../func.php');


$id = $_GET["id"];
    mysqli_query($mysql_conn, "DELETE FROM producao WHERE idproducao='$id'");
	header('location: producao.php' );

	
?>