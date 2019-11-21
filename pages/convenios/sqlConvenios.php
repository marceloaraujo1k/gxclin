<?php

include '../opendb.php';
include_once('../func.php');

if(isset($_REQUEST['submit'])){

	switch($_REQUEST['submit']){
			case 'inserir':
			inserir();
			break;
		case 'alterar':
			alterar();
			break;
		case 'deletar':
			deletar();
			break;
	}
}	



function inserir() {
		global $mysql_conn;
		if(!empty($_POST["descricao"])) {
		$form = $_POST;
		$query	= "INSERT INTO convenio (idconvenio, cnpj, descricao) VALUES (null, '$form[cnpj]','$form[descricao]')";
		mysqli_query($mysql_conn,$query);
		header('location: convenios.php' );
	}
}				
		
function alterar() 
{
	global $mysql_conn;
	if(!empty($_POST["descricao"])) {
		$form = $_POST;
	
		$query	= "UPDATE convenio SET idconvenio='$form[idconvenio]', cnpj='$form[cnpj]', descricao='$form[descricao]' WHERE idconvenio='$form[idconvenio]'";	

		mysqli_query($mysql_conn,$query);
		header('location: convenios.php' );
	
	}
}

function deletar() 
{					
}
	
?>