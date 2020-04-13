<?php

session_start();
include '../opendb.php';
include_once('../func.php');


$conn = $mysql_conn;

//Receber a requisão da pesquisa 
$requestData= $_REQUEST;
//idconsultas, descricao, dataRecebimento, valor, valorRecebido, desconto, saldoDevedor, formaPagamento,statusPagamento

//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
$columns = array( 
	0 =>'idfinanceiro', 
	1 => 'idconsultas',
	2 => 'tipo',
	3 => 'descricao',
	4 => 'dataRecebimento',
	5 => 'valor',
	6 => 'valorRecebido',
	7 => 'desconto',
	8 => 'saldoDevedor',
	9 => 'statusPagamento'
	
);

//Obtendo registros de número total sem qualquer pesquisa
$result_user = "SELECT * FROM financeiro";
$resultado_user =mysqli_query($conn, $result_user);
$qnt_linhas = mysqli_num_rows($resultado_user);

//Obter os dados a serem apresentados
$result_usuarios = "SELECT * FROM financeiro WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // se houver um parâmetro de pesquisa, $requestData['search']['value'] contém o parâmetro de pesquisa
	$result_usuarios.=" AND ( idfinanceiro LIKE '".$requestData['search']['value']."%' ";  
	$result_usuarios.=" OR idconsultas LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR descricao LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR dataRecebimento LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR saldoDevedor LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR desconto LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR statusPagamento LIKE '".$requestData['search']['value']."%' )";
}

$resultado_usuarios=mysqli_query($conn, $result_usuarios);
$totalFiltered = mysqli_num_rows($resultado_usuarios);

//Ordenar o resultado
$result_usuarios.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
$resultado_usuarios=mysqli_query($conn, $result_usuarios);

// Ler e criar o array de dados
$dados = array();
while( $row_usuarios =mysqli_fetch_array($resultado_usuarios) ) {  
	$dado = array(); 
	$dado[] = $row_usuarios["idfinanceiro"];
	$dado[] = utf8_encode($row_usuarios["idconsultas"]);
	$dado[] = utf8_encode($row_usuarios["idempresa"]);
	$dado[] = utf8_encode($row_usuarios["tipo"]);
	$dado[] = utf8_encode($row_usuarios["descricao"]); // USAR A FUNÇÃO UTF8_ENCODE PARA RESOLVER O PROBLEMA DE ACENTUAÇÃO QUE ESTAVA PREJUDICANDO O JSON

	$dado[] = date('d/m/Y', strtotime($row_usuarios["dataVecto"]));
	
	$dado[] = date('d/m/Y', strtotime($row_usuarios["dataRecebimento"]));

	$dado[] = $row_usuarios["valor"];

	$dado[] = $row_usuarios["valorRecebido"];		
	$dado[] = $row_usuarios["desconto"];		

	$dado[] = $row_usuarios["saldoDevedor"];		
	$dado[] = $row_usuarios["statusPagamento"];		
	
	
	$dado [] = '<button type="button" id="btnEditar" class="btn btn btn-primary" data-id="'.$row_usuarios["idfinanceiro"].'"><i class="glyphicon glyphicon-pencil">&nbsp;</i>Editar</button>';
	$dado [] = '<button type="button" id="btnExcluir" class="btn btn btn-primary" data-id="'.$row_usuarios["idfinanceiro"].'"><i class="glyphicon glyphicon-trash  ">&nbsp;</i>Excluir</button>';
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








           