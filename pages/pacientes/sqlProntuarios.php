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
	
	$query	= "INSERT INTO prontuarios (idprontuario, arquivo, idpaciente, data) VALUES (null,'$uploadfile','$form[id]', '$form[data]')";
	mysqli_query($mysql_conn,$query);
	$id = $form[id];
    header ('location: prontuarios.php?id='.$id);
	
?>