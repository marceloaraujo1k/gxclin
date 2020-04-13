<?php 
    include '../opendb.php';
    include_once('../func.php');

    $id = $_POST['id6'];
    $avaliacao = $_POST['area3'];
    

    $query = "UPDATE avaliacao SET avaliacao = '$avaliacao' WHERE idavaliacao = $id ";
    //var_dump($query);  
    //var_dump($_POST)  
    mysqli_query($mysql_conn, $query);

    
    $idpaciente = $_POST['idpaciente'];
    //$idpaciente = $_POST['id4'];
    //var_dump($idpaciente);
    header ("location: cadastroPacientes.php?id=$idpaciente");
?>