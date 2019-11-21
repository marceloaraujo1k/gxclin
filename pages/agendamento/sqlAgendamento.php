<?php

include '../opendb.php';
include_once('../func.php');


if(isset($_REQUEST['submit'])) {
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
		if(!empty($_POST["nome"])) {
		$form = $_POST;
		
		switch($form["statusAtendimento"]){
			case 'AGENDADO':
			$cor='#4103ff';
			break;
			case 'REALIZADO':
			$cor='#a9a9a9';
			break;
			case 'NÃO REALIZADO':
			$cor='#ffa722';
			break;
		}	
		$query	= "INSERT INTO agendamentos (idpaciente, tipoAtendimento, idconvenio, idprocedimentos, idmedico,  idempresa, dataInicio, dataFim, cor, statusAtendimento) VALUES ('$form[idpaciente]', '$form[tipoAtendimento]', '$form[idconvenio]', '$form[idprocedimentos]', 
		'$form[idmedico]', '$form[idempresa]',  STR_TO_DATE('$form[dataInicio]', '%d/%m/%Y %H:%i:%s'), ADDTIME((STR_TO_DATE('$form[dataInicio]', '%d/%m/%Y %H:%i:%s')),3000), '$cor', '$form[statusAtendimento]')";
		mysqli_query($mysql_conn,$query) ;
			header('location: agendamento.php' );
	}
}		


function alterar() 
{
	global $mysql_conn;
	if(!empty($_POST["nome"])) {
		$form = $_POST;

		switch($form["statusAtendimento"]){
			case 'AGENDADO':
			$cor='#4103ff';
			break;
			case 'REALIZADO':
			$cor='#a9a9a9';
			break;
			case 'NÃO REALIZADO':
			$cor='#ffa722';
			break;
		}	
		$query	= "UPDATE agendamentos SET idprocedimentos='$form[idprocedimentos]',  idmedico='$form[idmedico]',  idempresa='$form[idempresa]', statusAtendimento='$form[statusAtendimento]', cor='$cor', idconvenio='$form[idconvenio]'  where idconsultas='$form[idconsultas]'";	
		mysqli_query($mysql_conn,$query);
	    header('location: agendamento.php' );
	
	}
}		

	
	
?>