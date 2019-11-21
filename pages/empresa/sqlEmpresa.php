<?php

include '../opendb.php';
include_once('../func.php');
	
$form = $_POST;
if (empty ($form["id"])){	
	$query	= "INSERT INTO empresa (empresa, cnpj, endereco) VALUES ('$form[empresa]', '$form[cnpj]', '$form[endereco]')";
	mysqli_query($mysql_conn,$query);
    header ('location: empresa.php');
}
else {
	if(!empty($form["id"])) {
		print_r($form);
	$query	= "UPDATE empresa SET empresa='$form[empresa]', cnpj='$form[cnpj]', endereco='$form[endereco]' WHERE idempresa='$form[id]'";	
	mysqli_query($mysql_conn,$query);
	//header('location: empresa.php' );
	}
}	
	
?>