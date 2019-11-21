<?php

session_start();
include '../opendb.php';
include_once('../func.php');


$conn = $mysql_conn;

//Receber a requisão da pesquisa 
$requestData= $_REQUEST;
//idconsultas, descricao, dataRecebimento, valor, valorRecebido, desconto, saldoDevedor, formaPagamento,statusPagamento

	

//Obtendo registros de número total sem qualquer pesquisa
$result_user = "SELECT * FROM cid;";

$resultado_user =mysqli_query($conn, $result_user);
$qnt_linhas = mysqli_num_rows($resultado_user);

//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
$columns = array( 
	0 =>'idcid', 
	1 => 'cat',
	2 => 'classificacao',
	3 => 'descricao',
	4 => 'descrabrev',
	5 => 'ref',
	6 => 'excluidos'	
);

//Obtendo registros de número total sem qualquer pesquisa
$result_user = "SELECT * FROM cid";
$resultado_user =mysqli_query($conn, $result_user);
$qnt_linhas = mysqli_num_rows($resultado_user);

//Obter os dados a serem apresentados
$result_usuarios = "SELECT * FROM cid WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // se houver um parâmetro de pesquisa, $requestData['search']['value'] contém o parâmetro de pesquisa
	$result_usuarios.=" AND ( idcid LIKE '".$requestData['search']['value']."%' ";  
	$result_usuarios.=" OR cat LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR classificacao LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR descricao LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR descrabrev LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR ref LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR excluidos LIKE '".$requestData['search']['value']."%' )";

	}

$resultado_usuarios=mysqli_query($conn, $result_usuarios);
$totalFiltered = mysqli_num_rows($resultado_usuarios);

//Ordenar o resultado
$result_usuarios.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
$resultado_usuarios=mysqli_query($conn, $result_usuarios);

// Ler e criar o array de dados
$dados = array();
while( $row =mysqli_fetch_array($resultado_usuarios) ) {  
	$dado = array(); 
	
	$dado[] =  utf8_encode($row["idcid"]);
	$dado[] =  utf8_encode($row["cat"]);
	$dado[] =  utf8_encode($row["classificacao"]);
	$dado[] =  utf8_encode($row["descricao"]);
	$dado[] =  utf8_encode($row["descrabrev"]);
	$dado[] =  utf8_encode($row["ref"]);
	$dado[] =  utf8_encode($row["excluidos"]);
	$dados[] = $dado;
}


//Cria o array de informações a serem retornadas para o Javascript
$json_data = array(
	"draw" => intval( $requestData['draw'] ),//para cada requisição é enviado um número como parâmetro
	"recordsTotal" => intval( $qnt_linhas ),  //Quantidade de registros que há no banco de dados
	"recordsFiltered" => intval( $totalFiltered ), //Total de registros quando houver pesquisa
	"data" => $dados   //Array de dados completo dos dados retornados da tabela 
);

echo json_encode($json_data);  //enviar dados como formato json



?>








           