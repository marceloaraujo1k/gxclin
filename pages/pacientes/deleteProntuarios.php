<?php

include '../opendb.php';
include_once('../func.php');;

$id = $_GET["id"];
    mysqli_query($mysql_conn, "DELETE FROM prontuarios WHERE idProntuario='$id'");
    header ('location: prontuarios.php?id='.$id)
?>