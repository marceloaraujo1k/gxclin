<?php

include '../opendb.php';
include_once('../func.php');
	
$uploaddir = '../documentos/';

$uploadfile = $uploaddir . $_FILES['userfile']['name'];

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)){
	
	echo "Arquivo Enviado";
	}
else {
	echo "Arquivo não enviado";
}		
	
	$form = $_POST;	  
	
	$query	= "INSERT INTO documentos (iddocumentos, descricao, arquivo, data, validade) VALUES (null, '$form[descricao]','$uploadfile', '$form[data]', '$form[validade]')";
	mysqli_query($mysql_conn,$query);
	$id = $form["id"];
    header ('location: documentos.php');
	
?>