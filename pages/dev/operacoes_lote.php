<?php
include '../opendb.php';
include_once('../func.php');

$form = $_POST;

if(!empty($form["id"])) {
				if ($form["statusOperacao"] == "Pago") {
					$query	= "UPDATE producao SET dataPagamento=STR_TO_DATE('$form[dataOperacao]', '%d/%m/%Y %H:%i:%s'),  valorRecebido=valorProcedimento,
					notaFiscal='$form[notaFiscal]', formaPagamento='$form[formaPagamento]', statusPagamento='$form[statusOperacao]' where idproducao='$form[id]'";	
				
				
				mysqli_query($mysql_conn,$query);
				}
				else 
				{
					if ($form["statusOperacao"] == "Repasse") {
						$query	= "UPDATE producao SET dataRepasse=STR_TO_DATE('$form[dataOperacao]', '%d/%m/%Y %H:%i:%s') where idproducao='$form[id]'";	
						mysqli_query($mysql_conn,$query);
					}
				}
			}


//$id = $_GET["id"];

//$dados = array();

//$query = mysqli_query($mysql_conn, "SELECT * FROM producao WHERE idproducao ='$id'");
//$form = mysqli_fetch_assoc($query);
				
//$dados[] = $dado;

		
$json_data = array(
	"draw" => intval(1),//para cada requisição é enviado um número como parâmetro
	"recordsTotal" => intval(count($dados)),  //Quantidade de registros que há no banco de dados
	"recordsFiltered" => intval(count($dados)), //Total de registros quando houver pesquisa
	"data" => $dados   //Array de dados completo dos dados retornados da tabela 
);

echo json_encode($dados); 

?>	

