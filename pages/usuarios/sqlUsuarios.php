<?php

include '../opendb.php';
include_once('../func.php');
	
	$form = $_POST;	 
if (empty ($form["id"])){	
	$query	= "INSERT INTO usuarios (nome, login, senha, idfuncao, idempresa) VALUES ('$form[nome]', '$form[login]', '$form[senha]', '$form[idfuncao]', '$form[idempresa]')";
	mysqli_query($mysql_conn,$query);
    header ('location: usuarios.php');
}

else {
	if(!empty($form["id"])) {
		print_r($form);
	$query	= "UPDATE usuarios SET nome='$form[nome]', login='$form[login]', idfuncao='$form[idfuncao]', idempresa='$form[idempresa]' WHERE idusuario='$form[id]'";	
	mysqli_query($mysql_conn,$query);
//	header('location: usuarios.php' );
	}
}	
	
?>