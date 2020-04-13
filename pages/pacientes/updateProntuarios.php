<?php
    include '../opendb.php';


    //$form = $_POST;
    //$id = $_GET["id"];
    //var_dump($id);
    $uploaddir = '../prontuarios/';

    $idprontuario = $_POST["idprontuarioo"];
    $atendimento2 = $_POST["atendimento2"];
    $data2 = $_POST["data2"];
    $userfile2 = $uploaddir. $_FILES["userfile2"]['name'];

    if (move_uploaded_file($_FILES['userfile2']['tmp_name'], $userfile2)){
	
        echo "Arquivo Enviado";
        }
        
    else {
        echo "Arquivo não enviado";
    }	

    //var_dump($idprontuario);
    //var_dump($atendimento2);

    $query = "UPDATE prontuarios SET atendimento = '$atendimento2', data = '$data2', arquivo = '$userfile2' WHERE idprontuario = $idprontuario ";
    //var_dump($query);

    mysqli_query($mysql_conn,$query);
    
    header ('location: pacientes.php');

    //header ('location: prontuarios.php?id='.$id);

?>