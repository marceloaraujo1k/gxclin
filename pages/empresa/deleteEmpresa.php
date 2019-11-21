<?php

include '../opendb.php';
include_once('../func.php');

$id = $_GET["id"];
    mysqli_query($mysql_conn, "DELETE FROM empresa WHERE idempresa='$id'");
   header ('location: empresa.php');
?>