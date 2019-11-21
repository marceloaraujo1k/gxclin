<?php

//session_start();
include '../opendb.php';
include_once('../func.php');

$conn = $mysql_conn;

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
$query = "SELECT * FROM financeiro WHERE ";

if($_POST["is_date_search"] == "yes")
{
 $query .= 'dataRecebimento BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND ';
}

if(isset($_POST["search"]["value"]))
{
 $query .= '
  (idfinanceiro LIKE "%'.$_POST["search"]["value"].'%" 
  OR idconsultas LIKE "%'.$_POST["search"]["value"].'%" 
  OR tipo LIKE "%'.$_POST["search"]["value"].'%" 
  OR valor LIKE "%'.$_POST["search"]["value"].'%" 
  OR desconto LIKE "%'.$_POST["search"]["value"].'%" 
  OR saldoDevedor LIKE "%'.$_POST["search"]["value"].'%" 
  OR statusPagamento LIKE "%'.$_POST["search"]["value"].'%")';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY idfinanceiro DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));

$result = mysqli_query($conn, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = $row["idfinanceiro"];
	 $sub_array[] = utf8_encode($row["idconsultas"]);
	$sub_array[] = utf8_encode($row["idempresa"]);
	$sub_array[] = utf8_encode($row["tipo"]);
	$sub_array[] = utf8_encode($row["descricao"]); // USAR A FUNÇÃO UTF8_ENCODE PARA RESOLVER O PROBLEMA DE ACENTUAÇÃO QUE ESTAVA PREJUDICANDO O JSON

	$sub_array[] = date('d/m/Y', strtotime($row["dataVecto"]));
	
	$sub_array[] = date('d/m/Y', strtotime($row["dataRecebimento"]));

	$sub_array[] = number_format($row["valor"],2,",",".");
	$sub_array[] =  number_format($row["valorRecebido"],2,",",".");
	$sub_array[] = number_format($row["desconto"],2,",",".");
	$sub_array[] = number_format($row["saldoDevedor"],2,",",".");
		
	$sub_array[] = $row["statusPagamento"];		
	
	
	$sub_array [] = '<button type="button" id="btnEditar" class="btn btn btn-primary" data-id="'.$row["idfinanceiro"].'"><i class="glyphicon glyphicon-pencil">&nbsp;</i>Editar</button>';
	$sub_array [] = '<button type="button" id="btnExcluir" class="btn btn btn-primary" data-id="'.$row["idfinanceiro"].'"><i class="glyphicon glyphicon-trash  ">&nbsp;</i>Excluir</button>';
	$sub_array [] = '<button type="button" id="btnDetalhes" class="btn btn btn-primary" data-id="'.$row["idconsultas"].'"><i class="glyphicon glyphicon-calendar  ">&nbsp;</i>Detalhar</button>';								

 $data[] = $sub_array;
}

function get_all_data($conn)
{
 $query = "SELECT * FROM financeiro";
 $result = mysqli_query($conn, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($conn),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>
