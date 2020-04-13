<?php

include '../opendb.php';
include_once('../func.php');

$id = $_POST['id3'];
$qp = $_POST['qp'];
$hda = $_POST['hda'];
$ap = $_POST['ap'];
$af = $_POST['af'];
$date = date('Y-m-d');

$query = "INSERT INTO anamnese (idpaciente, qp, hda, ap, af, data) VALUES ($id,'$qp', '$hda', '$ap', '$af','$date' )";
//var_dump($query);
mysqli_query($mysql_conn, $query);

$query2 = "INSERT INTO evolucao (idpaciente,tipoNome, qp, hda, ap, af, data) VALUES ($id,'anamnese', '$qp', '$hda', '$ap', '$af','$date' )";
mysqli_query($mysql_conn, $query2);
//var_dump($query2);
header ('location: cadastroPacientes.php?id='.$id);

?>