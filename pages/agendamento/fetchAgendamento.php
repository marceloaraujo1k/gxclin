<?php

include '../opendb.php';
include_once('../func.php');

$conn = $mysql_conn;

$query = "SELECT a.idpaciente, a.idconsultas, a.idprofissional, a.idempresa, a.dataInicio, a.dataFim, a.cor, b.nome FROM agendamentos AS a INNER JOIN pacientes AS b ON a.idpaciente = b.idpaciente WHERE";

$idprofissional = $_POST['idprofissional2'];
$filial = $_POST['idempresa2'];

if(isset($idprofissional)){
    $query.= "idprofissional = '$idprofissional'";
}

else if(isset($filial)){
    $query.="idempresa = '$filial'";
}

else{
    $query.= "idprofissional = '$idprofissional' AND idempresa = '$filial'";
}

$number_filter_row = mysqli_num_rows($conn, $query);

$result = mysqli_query($conn, $query);

$data = array();

while($row = mysqli_fetch_array($result)){
    $sub_array[] = $row['idpaciente'];
    $sub_array[] = $row['idconsultas'];
    $sub_array[] = $row['idprofissional'];
    $sub_array[] = $row['idempresa'];
    $sub_array[] = $row['dataInicio'];
    $sub_array[] = $row['dataFim'];
    $sub_array[] = $row['cor'];
    $sub_array[] = $row['nome'];

    $data[] = $sub_array;
}

function get_all_data($conn){
    $query = "SELECT a.idpaciente, a.idconsultas, a.idprofissional, a.idempresa, a.dataInicio, a.dataFim, a.cor, b.nome FROM agendamentos AS a INNER JOIN pacientes AS b ON a.idpaciente = b.idpaciente";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
}

$output = array(
    "recordsTotal" => get_all_data($conn),
    "recordsFiltered" => $number_filter_row,
    "data" => $data
);

echo json_encode($output)

?>