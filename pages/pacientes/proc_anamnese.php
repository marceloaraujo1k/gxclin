<?php 

session_start();
include '../opendb.php';
include_once('../func.php');


$conn = $mysql_conn;

//Receber a requisão da pesquisa 
$requestData= $_REQUEST;
//idconsultas, descricao, dataRecebimento, valor, valorRecebido, desconto, saldoDevedor, formaPagamento,statusPagamento

	

//Obtendo registros de número total sem qualquer pesquisa
$result_user = "SELECT * FROM anamnese;";

$resultado_user =mysqli_query($conn, $result_user);
$qnt_linhas = mysqli_num_rows($resultado_user);

//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
$columns = array( 
	0 =>'idanamnese', 
	1 => 'idpaciente',
	2 => 'qp',
	3 => 'hda',
	4 => 'ap',
    5 => 'af',
    6 => 'data'
);

//Obtendo registros de número total sem qualquer pesquisa
$result_user = "SELECT * FROM anamnese";
$resultado_user =mysqli_query($conn, $result_user);
$qnt_linhas = mysqli_num_rows($resultado_user);

//Obter os dados a serem apresentados
$result_usuarios = "SELECT * FROM anamnese WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // se houver um parâmetro de pesquisa, $requestData['search']['value'] contém o parâmetro de pesquisa
	$result_usuarios.=" AND ( idanamnese LIKE '".$requestData['search']['value']."%' ";  
	$result_usuarios.=" OR idpaciente LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR qp LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR hda LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR ap LIKE '".$requestData['search']['value']."%' ";
    $result_usuarios.=" OR af LIKE '".$requestData['search']['value']."%' ";
    $result_usuarios.=" OR data LIKE '".$requestData['search']['value']."%' )";
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
	
	$dado[] =  $row["idanamnese"];
	$dado[] =  $row["idpaciente"];
	$dado[] =  $row["qp"];
	$dado[] =  $row["hda"];
	$dado[] =  $row["ap"];
    $dado[] =  $row["af"];
    $dado[] =  date('d/m/Y', strtotime($row["data"]));
    $dado [] = '<button type="button" id="btnVisualizar" class="btn btn btn-primary" data-id="'.$row["idanamnese"].'"><i class="glyphicon glyphicon-eye-open">&nbsp;</i>Visualizar</button>';
	$dado [] = '<button type="button" id="btnEditar" class="btn btn btn-primary" data-id="'.$row["idanamnese"].'"><i class="glyphicon glyphicon-pencil">&nbsp;</i>Editar</button>';
	$dado [] = '<button type="button" id="btnExcluir3" class="btn btn-danger" data-id="'.$row["idanamnese"].'"><i class="glyphicon glyphicon-trash  ">&nbsp;</i>Excluir</button>';
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