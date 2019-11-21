<?php

include 'opendb.php';
include_once('func.php');

$id = $_GET["id"];
   mysqli_query($mysql_conn, "DELETE FROM documentos WHERE iddocumentos='$id'");
   header ('location: documentos.php');
?>