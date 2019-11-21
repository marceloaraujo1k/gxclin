<?php

session_start();
include '../opendb.php';
include_once('../func.php');


$conn = $mysql_conn;

//Receber a requisão da pesquisa 
$requestData= $_REQUEST;

//Obtendo registros de número total sem qualquer pesquisa
$result_user = "SELECT COUNT(statusAtendimento) AS totalAgendado, MONTH(dataInicio) AS mes, dataInicio FROM agendamentos WHERE statusAtendimento='AGENDADO' GROUP BY MONTH(dataInicio) ORDER BY mes DESC LIMIT 3";

$resultado_user =mysqli_query($conn, $result_user);
$qnt_linhas = mysqli_num_rows($resultado_user);


// Ler e criar o array de dados
$dados = array();
while( $row_usuarios =mysqli_fetch_array($resultado_user) ) {  
	$dado = array(); 
	$dado[] = $row_usuarios["totalAgendado"];
	$dados[] = $dado;
}

//Cria o array de informações a serem retornadas para o Javascript
/*$json_data = array(
	"draw" => intval( $requestData['draw'] ),//para cada requisição é enviado um número como parâmetro
	"recordsTotal" => intval( $qnt_linhas ),  //Quantidade de registros que há no banco de dados
	"recordsFiltered" => intval( $qnt_linhas ), //Total de registros quando houver pesquisa
	"data" => $dados   //Array de dados completo dos dados retornados da tabela 
);*/

echo json_encode($dados);  //enviar dados como formato json



?>








           