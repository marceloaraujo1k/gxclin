<?php

include '../opendb.php';
include_once('../func.php');

	switch($_POST['submit']){
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
	
function inserirConta() 
	{
		global $mysql_conn;
		if(!empty($_POST)) {
		$form = $_POST;
			$query	= "INSERT INTO financeiro (idempresa, descricao, dataRecebimento, dataVecto, valor, valorRecebido, desconto, saldoDevedor, formaPagamento, 
			statusPagamento, tipo) VALUES ( '$form[idempresa]', '$form[descricao]', STR_TO_DATE('$form[dataRecebimento]', '%d/%m/%Y %H:%i:%s'), STR_TO_DATE('$form[dataVencimento]', '%d/%m/%Y %H:%i:%s'),
			 '$form[valor]','$form[valorRecebido]', '$form[desconto]', '$form[saldoDevedor]','$form[formaPagamento]','$form[statusPagamento]','$form[tipo]')";
			mysqli_query($mysql_conn, $query);
		//	header('location: ../financeiro/financeiro.php' );
		}	
	}		
	
function atualizaConta() 
{	
	global $mysql_conn;
	if(!empty($_POST)) {
	$form = $_POST;
	$query	= "UPDATE financeiro SET valorRecebido='$form[valorRecebido]'+'$form[valorRecebidoAnt]', desconto='$form[desconto]'+'$form[descontoAnt]', saldoDevedor='$form[saldoDevedor]', dataRecebimento=STR_TO_DATE('$form[dataRecebimento]', '%d/%m/%Y %H:%i:%s'), formaPagamento='$form[formaPagamento]', statusPagamento='$form[statusPagamento]'  where idfinanceiro='$form[idfinanceiro]'";	
	mysqli_query($mysql_conn,$query);
	}
}
	
?>