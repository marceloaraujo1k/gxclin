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
			case 'receberPagamento':
			receberPagamento();
			break;
			case 'inserirConta':
			inserirConta();
			break;
			case 'atualizaConta':
			atualizaConta();
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
		$query	= "INSERT INTO financeiro (idpaciente, tipoAtendimento, idconvenio, idprocedimentos, idmedico,  idempresa, dataInicio, dataFim, cor, statusAtendimento) VALUES ('$form[idpaciente]', '$form[tipoAtendimento]', '$form[idconvenio]', '$form[idprocedimentos]', 
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

function receberPagamento() 
{
		global $mysql_conn;
		if(!empty($_POST)) {
		$form = $_POST;
			$query	= "INSERT INTO financeiro (idconsultas, idempresa, descricao, dataRecebimento, dataVecto, valor, valorRecebido, desconto, saldoDevedor, formaPagamento, 
			statusPagamento, tipo) VALUES ('$form[idconsultas]', '$form[idempresa]', '$form[procedimento]', STR_TO_DATE('$form[dataRecebimento]', '%d/%m/%Y %H:%i:%s'), STR_TO_DATE('$form[dataVencimento]', '%d/%m/%Y %H:%i:%s'),
			'$form[valor]','$form[valorRecebido]', '$form[desconto]', '$form[saldoDevedor]','$form[formaPagamento]','$form[statusPagamento]','$form[tipo]')";
			mysqli_query($mysql_conn, $query);
		  header('location: ../agendamento/agendamento.php' );
		}	
			
}		

function inserirConta() 
{
		global $mysql_conn;
		if(!empty($_POST)) {
		$form = $_POST;
		print_r("aqui");
		
			$query	= "INSERT INTO financeiro (idempresa, descricao, dataRecebimento, dataVecto, valor, valorRecebido, desconto, saldoDevedor, formaPagamento, 
			statusPagamento, tipo) VALUES ( '$form[idempresa]', '$form[descricao]', STR_TO_DATE('$form[dataRecebimento]', '%d/%m/%Y %H:%i:%s'), STR_TO_DATE('$form[dataVencimento]', '%d/%m/%Y %H:%i:%s'),
			 number_format('$form[valor]',2,'.',''),'$form[valorRecebido]', '$form[desconto]', '$form[saldoDevedor]','$form[formaPagamento]','$form[statusPagamento]','$form[tipo]')";
			mysqli_query($mysql_conn, $query);
		//	header('location: ../financeiro/financeiro.php' );
		}	
			
}	
	
	
function atualizaConta() 
{	global $mysql_conn;
	print_r($_POST);
	
	if(!empty($_POST)) {
	$form = $_POST;
		$query	= "UPDATE financeiro SET valorRecebido='$form[valorRecebido]'+'$form[valorRecebidoAnt]', desconto='$form[desconto]'+'$form[descontoAnt]', saldoDevedor='$form[saldoDevedor]', formaPagamento='$form[formaPagamento]', statusPagamento='$form[statusPagamento]'  where idfinanceiro='$form[idfinanceiro]'";	
		mysqli_query($mysql_conn,$query);
	 //   header('location: ../financeiro/financeiro.php' );
	}
}

	
?>