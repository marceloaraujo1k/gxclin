<?php

session_start();
include '../opendb.php';
include_once('../func.php');


$conn = $mysql_conn;

//Receber a requisão da pesquisa 
$requestData= $_REQUEST;
//idconsultas, descricao, dataRecebimento, valor, valorRecebido, desconto, saldoDevedor, formaPagamento,statusPagamento

	

//Obtendo registros de número total sem qualquer pesquisa
$result_user = "SELECT * FROM profissionais;";

$resultado_user =mysqli_query($conn, $result_user);
$qnt_linhas = mysqli_num_rows($resultado_user);

//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
$columns = array( 
	0 =>'idprofissional', 
	1 => 'nome',
	2 => 'rg',
	3 => 'cpf',
	4 => 'conselho',
	5 => 'especialidade'
);

//Obtendo registros de número total sem qualquer pesquisa
$result_user = "SELECT * FROM profissionais";
$resultado_user =mysqli_query($conn, $result_user);
$qnt_linhas = mysqli_num_rows($resultado_user);

//Obter os dados a serem apresentados
$result_usuarios = "SELECT * FROM profissionais WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // se houver um parâmetro de pesquisa, $requestData['search']['value'] contém o parâmetro de pesquisa
	$result_usuarios.=" AND ( idprofissional LIKE '".$requestData['search']['value']."%' ";  
	$result_usuarios.=" OR nome LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR rg LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR cpf LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR conselho LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR especialidade LIKE '".$requestData['search']['value']."%' ";
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
	
	$dado[] =  $row["idprofissional"];
	$dado[] =  $row["nome"];
	$dado[] =  $row["rg"];
	$dado[] =  $row["cpf"];
	$dado[] =  $row["conselho"];
	$dado[] =  $row["especialidade"];
	$dado [] = '<button type="button" id="btnEditar" class="btn btn btn-primary" data-id="'.$row["idprofissional"].'"><i class="glyphicon glyphicon-pencil">&nbsp;</i>Editar</button>';
	$dado [] = '<button type="button" id="btnExcluir" class="btn btn btn-primary" data-id="'.$row["idprofissional"].'"><i class="glyphicon glyphicon-trash  ">&nbsp;</i>Excluir</button>';
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








           