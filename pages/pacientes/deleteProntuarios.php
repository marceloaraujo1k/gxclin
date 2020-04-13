<?php 
include '../opendb.php';
include_once('../func.php');

$id = $_GET['id'];

$query = "DELETE FROM prontuarios WHERE idprontuario = $id";
//var_dump($query);

mysqli_query($mysql_conn,$query);

$idpaciente = $_GET['idpaciente'];
//var_dump($idpaciente);

header("location:cadastroPacientes.php?id=".$idpaciente);


?>