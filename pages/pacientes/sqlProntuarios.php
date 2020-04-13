<?php

include '../opendb.php';
include_once('../func.php');
	
$uploaddir = '../prontuarios/';

$uploadfile = $uploaddir . $_FILES['userfile']['name'];

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)){
	
	echo "Arquivo Enviado";
	}
	
else {
	echo "Arquivo não enviado";
}		
	
	$form = $_POST;	  
	
	$query	= "INSERT INTO prontuarios (idprontuario, arquivo, idpaciente, data, atendimento) VALUES (null,'$uploadfile','$form[id]', '$form[data]', '$form[atendimento]')";
	mysqli_query($mysql_conn,$query);

	$query2	= "INSERT INTO evolucao (tipoNome, idpaciente, data, atendimento) VALUES ('prontuario','$form[id]', '$form[data]', '$form[atendimento]')";
	mysqli_query($mysql_conn,$query2);

	$id = $form[id];
    header ('location: cadastroPacientes.php?id='.$id);
	
?>