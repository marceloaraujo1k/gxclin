<?php
include '../opendb.php';
include_once('../func.php');

$id = $_GET["id"];

$dados = array();

$query = mysqli_query($mysql_conn, "SELECT * FROM producao WHERE idproducao ='$id'");
$form = mysqli_fetch_assoc($query);

	$dado[]=$form["idproducao"];
	$dado[]=$form["dataRealizacao"];
	$dado[]=$form["idpaciente"];
	$dado[]=$form["idmedico"];
	$dado[]=$form["idprocedimentos"];
	$dado[]=$form["paciente"];
	$dado[]=$form["carteiraPaciente"];
	$dado[]=$form["medico"];
	$dado[]=$form["convenio"];
	$dado[]=$form["hospital"];
	$dado[]=$form["codigoProcedimento"];
	$dado[]=$form["descricaoProcedimento"];
	//12
	$dado[]=$form["valorProcedimento"];
	$dado[]=$form["quantidade"];
	$dado[]=$form["adicional"];
	$dado[]=$form["redutor"];
	$dado[]=$form["valorRecebido"];
	$dado[]=$form["glosa"];
	$dado[]=$form["saldo"];
	//19
	$dado[]=$form["dataPagamento"];
	$dado[]=$form["dataCobranca"];
	$dado[]=$form["dataRepasse"];
	$dado[]=$form["dataPrevisaoPagamento"];
	$dado[]=$form["notaFiscal"];
	$dado[]=$form["protocolo"];
	$dado[]=$form["formaPagamento"];
	$dado[]=$form["statusPagamento"];
	$dado[]=$form["observacao"];
	$dado[]=$form["medicoCirurgiao"];
			
$dados[] = $dado;

		
$json_data = array(
	"draw" => intval(1),//para cada requisição é enviado um número como parâmetro
	"recordsTotal" => intval(count($dados)),  //Quantidade de registros que há no banco de dados
	"recordsFiltered" => intval(count($dados)), //Total de registros quando houver pesquisa
	"data" => $dados   //Array de dados completo dos dados retornados da tabela 
);

echo json_encode($dados); 

?>	

