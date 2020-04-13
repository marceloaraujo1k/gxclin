<?php

session_start();
include '../opendb.php';
include_once('../func.php');

$empresa = $_SESSION['idempresa'];
$funcao = $_SESSION['idfuncao'];

$conn = $mysql_conn;

//Receber a requisão da pesquisa 
$requestData= $_REQUEST;


//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
$columns = array( 
	0 =>'codigo', 
	1 => 'nome',
	2 => 'nascimento',
	3 => 'telefone',
	4 => 'filial'
);

//Obtendo registros de número total sem qualquer pesquisa
$result_user = "SELECT *,  (SELECT empresa FROM empresa WHERE idempresa=pacientes.idempresa) as filial  FROM pacientes";
$resultado_user =mysqli_query($conn, $result_user);
$qnt_linhas = mysqli_num_rows($resultado_user);

//Obter os dados a serem apresentados
$result_usuarios = "SELECT *,  (SELECT empresa FROM empresa WHERE idempresa=pacientes.idempresa) as filial  FROM pacientes WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // se houver um parâmetro de pesquisa, $requestData['search']['value'] contém o parâmetro de pesquisa
	$result_usuarios.=" AND ( codigo LIKE '".$requestData['search']['value']."%' ";    
	$result_usuarios.=" OR nome LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR nascimento LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR telefone LIKE '".$requestData['search']['value']."%' ";
	$result_usuarios.=" OR filial LIKE '".$requestData['search']['value']."%' )";
}

$resultado_usuarios=mysqli_query($conn, $result_usuarios);
$totalFiltered = mysqli_num_rows($resultado_usuarios);

//Ordenar o resultado
$result_usuarios.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
$resultado_usuarios=mysqli_query($conn, $result_usuarios);

// Ler e criar o array de dados
$dados = array();
while( $row_usuarios =mysqli_fetch_array($resultado_usuarios) ) {  
	if($funcao == 0){
		$dado = array(); 
		$dado[] = $row_usuarios["codigo"];
	//	$dado[] = $row_usuarios["nome"]; // USAR A FUNÇÃO UTF8_ENCODE PARA RESOLVER O PROBLEMA DE ACENTUAÇÃO QUE ESTAVA PREJUDICANDO O JSON
		$dado[] = utf8_encode($row_usuarios["nome"]); // USAR A FUNÇÃO UTF8_ENCODE PARA RESOLVER O PROBLEMA DE ACENTUAÇÃO QUE ESTAVA PREJUDICANDO O JSON
		$dado[] = date('d/m/Y', strtotime($row_usuarios["nascimento"]));
		
		$dado[] = $row_usuarios["telefone"];	
		$dado[] = $row_usuarios["filial"];	
		
		$dado[] = '<button  type="button" id="btnVisualizar" class="btn btn-primary" data-id="'.$row_usuarios["idpaciente"].'"><i class="glyphicon glyphicon-eye-open">&nbsp;</i>Visualizar</button>';
		$dado [] = '<button type="button" id="btnEditar" class="btn btn btn-primary" data-id="'.$row_usuarios["idpaciente"].'"><i class="glyphicon glyphicon-pencil">&nbsp;</i>Editar</button>';
		$dado [] = '<button type="button" id="btnExcluir" class="btn btn btn-primary" data-id="'.$row_usuarios["idpaciente"].'"><i class="glyphicon glyphicon-trash  ">&nbsp;</i>Excluir</button>';
		$dado [] = '<button type="button" id="btnAgendar" class="btn btn btn-primary" data-id="'.$row_usuarios["idpaciente"].'"><i class="glyphicon glyphicon-calendar  ">&nbsp;</i>Agendar</button>';								
		$dados[] = $dado;

	}else if($empresa == $row_usuarios['idempresa']){
		$dado = array(); 
		$dado[] = $row_usuarios["codigo"];
	//	$dado[] = $row_usuarios["nome"]; // USAR A FUNÇÃO UTF8_ENCODE PARA RESOLVER O PROBLEMA DE ACENTUAÇÃO QUE ESTAVA PREJUDICANDO O JSON
		$dado[] = utf8_encode($row_usuarios["nome"]); // USAR A FUNÇÃO UTF8_ENCODE PARA RESOLVER O PROBLEMA DE ACENTUAÇÃO QUE ESTAVA PREJUDICANDO O JSON
		$dado[] = date('d/m/Y', strtotime($row_usuarios["nascimento"]));
		
		$dado[] = $row_usuarios["telefone"];	
		$dado[] = $row_usuarios["filial"];	
		
		$dado[] = '<button  type="button" id="btnVisualizar" class="btn btn-primary" data-id="'.$row_usuarios["idpaciente"].'"><i class="glyphicon glyphicon-eye-open">&nbsp;</i>Visualizar</button>';
		$dado [] = '<button type="button" id="btnEditar" class="btn btn btn-primary" data-id="'.$row_usuarios["idpaciente"].'"><i class="glyphicon glyphicon-pencil">&nbsp;</i>Editar</button>';
		$dado [] = '<button type="button" id="btnExcluir" class="btn btn btn-primary" data-id="'.$row_usuarios["idpaciente"].'"><i class="glyphicon glyphicon-trash  ">&nbsp;</i>Excluir</button>';
		$dado [] = '<button type="button" id="btnAgendar" class="btn btn btn-primary" data-id="'.$row_usuarios["idpaciente"].'"><i class="glyphicon glyphicon-calendar  ">&nbsp;</i>Agendar</button>';								
		$dados[] = $dado;
}
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








           