<?php

include '../opendb.php';
include_once('../func.php');

$id = $_POST['id5'];
$area1 = $_POST['area1'];
$date = date('Y-m-d');
$query = "INSERT INTO AVALIACAO (avaliacao, idpaciente, data) VALUES ('$area1', $id, '$date')";
//var_dump($query);
mysqli_query($mysql_conn, $query);

$query2 = "INSERT INTO evolucao (tipoNome, avaliacao, idpaciente, data) VALUES ('avaliacao','$area1', $id, '$date')";
mysqli_query($mysql_conn, $query2);
//var_dump($query2);

header ('location: cadastroPacientes.php?id='.$id);
?>