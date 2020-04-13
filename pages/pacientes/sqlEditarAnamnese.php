<?php 
    include '../opendb.php';
    include_once('../func.php');

    $id = $_POST['id4'];
    $qp = $_POST['qp2'];
    $hda = $_POST['hda2'];
    $ap = $_POST['ap2'];
    $af = $_POST['af2'];

    $query = "UPDATE anamnese SET qp = '$qp', hda = '$hda', ap='$ap', af ='$af' WHERE idanamnese = $id ";
    //var_dump($query);  
    //var_dump($_POST)  
    mysqli_query($mysql_conn, $query);

    $idpaciente = $_POST['idpaciente'];
    //$idpaciente = $_POST['id4'];
    //var_dump($idpaciente);
    
    header ("location: cadastroPacientes.php?id=$idpaciente");
?>