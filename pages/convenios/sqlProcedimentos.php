<?php

include '../opendb.php';
include_once('../func.php');
$form = $_POST;
print_r($form);

if (empty($form["idprocedimentos"])){	
		global $mysql_conn;
		$form = $_POST;
		if(!empty($_POST["descricao"])) {
		$query	= "INSERT INTO procedimentos (idprocedimentos, idconvenio, descricao, valor) VALUES (null, '$form[id]','$form[descricao]', '$form[valor]')";
		mysqli_query($mysql_conn,$query);
		header('location: procedimentos.php?id='.$form['id']);
	}
}
else {
	if(!empty($form["idprocedimentos"])) {
		$query	= "UPDATE procedimentos SET descricao='$form[descricao]', valor='$form[valor]' WHERE idprocedimentos='$form[idprocedimentos]'";	
		mysqli_query($mysql_conn,$query);
		header('location: procedimentos.php?id='.$form['id']);
	}
}


?>