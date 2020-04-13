<?php 

include '../opendb.php';
include_once('../func.php');
$conn = $mysql_conn;


if(isset($_POST['searchNoCarteira'])){
    $search = $_POST['searchNoCarteira'];

    $query = "SELECT * FROM pacientes WHERE cod_carteira like'%".$search."%'";
    $result = mysqli_query($conn,$query);
    
    while($row = mysqli_fetch_array($result) ){
        $response[] = array("label"=>$row['nome'],"value"=>$row['cod_carteira'], "idpaciente"=>$row['idpaciente']);
    }

    echo json_encode($response);
}



if(isset($_POST['searchpaciente'])){
    $search = $_POST['searchpaciente'];

    $query = "SELECT * FROM pacientes WHERE nome like'%".$search."%'";
    $result = mysqli_query($conn,$query);
    
    while($row = mysqli_fetch_array($result) ){
        $response[] = array("label"=>$row['nome'],"idpaciente"=>$row['idpaciente'], "codcarteira"=>$row['cod_carteira']);
    }

    echo json_encode($response);
}

if(isset($_POST['searchmedico'])){
    $search = $_POST['searchmedico'];

    $query = "SELECT * FROM medicos WHERE nome like'%".$search."%'";
    $result = mysqli_query($conn,$query);
    
    while($row = mysqli_fetch_array($result) ){
        $response[] = array("label"=>$row['nome'],"value"=>$row['idmedico']);
    }

    echo json_encode($response);
}

$response=null;
if(isset($_POST['searchprocedimento'])){
	$search = $_POST['searchprocedimento'];
	$idconvenio = $_POST['idconvenio'];
	$query = "select a.idprocedimentos as idprocedimentos, a.idconvenio,  a.descricao as descricao, a.codigo as codigo, a.idporte, b.idporte, b.valor as valor from procedimentos a, porte b where (a.descricao like'%".$search."%' OR a.codigo like'%".$search."%') and a.idconvenio=".$idconvenio."  and a.idporte = b.idporte";
   
	  // $query = "SELECT * FROM procedimentos WHERE (descricao like'%".$search."%' OR codigo like'%".$search."%') AND idconvenio=".$idconvenio." ";
    $result = mysqli_query($conn,$query);
    
    while($row = mysqli_fetch_array($result) ){
       $response[] = array("label"=>$row['descricao'], "value"=>$row['idprocedimentos'], "value1"=>$row['valor'], "codigoProcedimento"=>$row['codigo'], "idconvenio"=>$idconvenio);
    }

    echo json_encode($response);
}




$response=null;
if(isset($_POST['searchprocedimento1'])){
	$search = $_POST['searchprocedimento1'];
	$idconvenio = $_POST['idconvenio'];
	$query = "select a.idprocedimentos as idprocedimentos, a.idconvenio,  a.descricao as descricao, a.codigo as codigo, a.idporte, b.idporte, b.valor as valor from procedimentos a, porte b where (a.descricao like'%".$search."%' OR a.codigo like'%".$search."%') and a.idconvenio=".$idconvenio."  and a.idporte = b.idporte";
   
	  // $query = "SELECT * FROM procedimentos WHERE (descricao like'%".$search."%' OR codigo like'%".$search."%') AND idconvenio=".$idconvenio." ";
    $result = mysqli_query($conn,$query);
    
    while($row = mysqli_fetch_array($result) ){
       $response[] = array("label"=>$row['descricao'], "value"=>$row['idprocedimentos'], "value1"=>$row['valor'], "codigoProcedimento"=>$row['codigo'], "idconvenio"=>$idconvenio);
    }

    echo json_encode($response);
}

exit;


