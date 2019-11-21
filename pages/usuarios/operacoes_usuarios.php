<?php
include '../opendb.php';
include_once('../func.php');

$id = $_GET["id"];



$dados = array();

$query = mysqli_query($mysql_conn, "SELECT * FROM usuarios WHERE idusuario ='$id'");
$form = mysqli_fetch_assoc($query);

	$dado[]=$form["idusuario"];
	$dado[]=$form["nome"];
	$dado[]=$form["login"];
	$dado[]=$form["senha"];
	$dado[]=$form["idfuncao"];
	$dado[]=$form["idempresa"];
//	$idconsultas = $form["idconsultas"];

/*					
$query1 = mysqli_query($mysql_conn, "SELECT agendamentos.idconsultas, agendamentos.idpaciente, agendamentos.idempresa, agendamentos.idmedico, agendamentos.dataInicio, agendamentos.idprocedimentos, agendamentos.statusAtendimento,
									pacientes.idpaciente, pacientes.nome, pacientes.sexo, pacientes.idconvenio,
									pacientes.observacao FROM agendamentos INNER JOIN pacientes ON agendamentos.idpaciente = pacientes.idpaciente WHERE agendamentos.idconsultas='$idconsultas'");
$row = mysqli_fetch_assoc($query1);
	$dado[]= $row["nome"];
	$dado [] = $row["idempresa"];
	$dado [] = $row["idconvenio"];
	$idconvenio = $row["idconvenio"];
	
$query2 = mysqli_query($mysql_conn, "SELECT * FROM convenio WHERE idconvenio ='$idconvenio'");
$line = mysqli_fetch_assoc($query2);
$dado[] = $line["descricao"]; */

$dados[] = $dado;

		
$json_data = array(
	"draw" => intval(1),//para cada requisição é enviado um número como parâmetro
	"recordsTotal" => intval(count($dados)),  //Quantidade de registros que há no banco de dados
	"recordsFiltered" => intval(count($dados)), //Total de registros quando houver pesquisa
	"data" => $dados   //Array de dados completo dos dados retornados da tabela 
);

echo json_encode($dados); 

?>	

