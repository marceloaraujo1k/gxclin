

<head>

    <meta charset="utf-8">
</head>
<?php

include '../opendb.php';
include_once('../func.php');
	
$form = $_POST;
if (empty ($form["id"])){	
	$query	= "INSERT INTO profissionais (nome, rg, cpf, conselho, especialidade, tipoRepasse, valorRepasse) VALUES ('$form[nome]', '$form[rg]', '$form[cpf]', '$form[conselho]', '$form[especialidade]',  '$form[tipoRepasse]',  '$form[valorRepasse]')";
	mysqli_query($mysql_conn,$query);
    header ('location: profissionais.php');
}
else {
	if(!empty($form["id"])) {
		print_r($form);
	$query	= "UPDATE profissionais SET profissional='$form[nome]', rg='$form[rg]', cpf='$form[cpf]', conselho='$form[conselho]', especialidade='$form[especialidade]', tipoRepasse='$form[tipoRepasse]', valorRepasse='$form[valorRepasse]' WHERE idprofissional='$form[id]'";	
	mysqli_query($mysql_conn,$query);
	header('location: profissionais.php' );
	}
}	
	
?>