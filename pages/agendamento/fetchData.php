<?php

include '../opendb.php';
include_once('../func.php');
$conn = $mysql_conn;

if(isset($_POST['searchcpf'])){
    $search = $_POST['searchcpf'];

    $query = "SELECT a.nome, a.cpf, a.telefone,a.idpaciente,a.idconvenio, b.descricao FROM pacientes AS a INNER JOIN convenio AS b ON a.idconvenio = b.idconvenio WHERE cpf LIKE'%".$search."%'";
    //var_dump($query);
    $result = mysqli_query($conn, $query);

    while($row = mysqli_fetch_assoc($result)){
        $response[] = array("cpf"=>$row['cpf'],"idpaciente"=>$row['idpaciente'],"nome"=>$row['nome'],"telefone"=>$row['telefone'], "convenio"=>$row['idconvenio']);
    }

    echo json_encode($response);

}

exit;
?>