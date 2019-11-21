<?php

include '../opendb.php';
include_once('../func.php');

if(isset($_REQUEST['submit'])){

	switch($_REQUEST['submit']){
			case 'inserir':
			inserir();
			break;
		case 'alterar':
			alterar();
			break;
		case 'deletar':
			deletar();
			break;
	}
}	



function inserir() {
		global $mysql_conn;
		if(!empty($_POST["nome"])) {
		$form = $_POST;
		print_r($form);
		$query	= "INSERT INTO pacientes (idpaciente, idconvenio, idempresa, nome, sexo, nascimento, cpf, rg, estado_civil, pai, mae, endereco, bairro, municipio,
				  cep, estado, email, telefone, celular, tel_trabalho, senhaweb, login, codigo, observacao, data_cadastro, cid, cod_carteira, validade_carteira, responsavel) VALUES 
			     (null, '$form[idconvenio]', '$form[idempresa]','$form[nome]','$form[sexo]','$form[nascimento]','$form[cpf]','$form[rg]','$form[estado_civil]','$form[pai]',
				 '$form[mae]','$form[endereco]','$form[bairro]', '$form[municipio]','$form[cep]','$form[estado]','$form[email]','$form[telefone]',
				  '$form[celular]','$form[tel_trabalho]','$form[senhaweb]','$form[login]','$form[codigo]','$form[observacao]', STR_TO_DATE('$form[data_cadastro]', '%d/%m/%Y %H:%i:%s'), '$form[cid]',
				'$form[cod_carteira]',STR_TO_DATE('$form[validade_carteira]', '%d/%m/%Y %H:%i:%s'),'$form[responsavel]')";
		mysqli_query($mysql_conn,$query);
	 	header('location: pacientes.php' );
	}
}				
		
function alterar() 
{
	global $mysql_conn;
	if(!empty($_POST["nome"])) {
		$form = $_POST;
		print_r($form);
		$query	= "UPDATE pacientes SET idconvenio='$form[idconvenio]', idempresa='$form[idempresa]',  nome='$form[nome]', sexo='$form[sexo]', nascimento='$form[nascimento]', cpf='$form[cpf]', rg='$form[rg]', 
				estado_civil='$form[estado_civil]', pai='$form[pai]', mae='$form[mae]', endereco='$form[endereco]', bairro='$form[bairro]', municipio='$form[municipio]', cep='$form[cep]', estado='$form[estado]',
				email='$form[email]', telefone='$form[telefone]', celular='$form[celular]', tel_trabalho='$form[tel_trabalho]', senhaweb='$form[senhaweb]', login='$form[login]',
				codigo='$form[codigo]', observacao='$form[observacao]', data_cadastro= STR_TO_DATE('$form[data_cadastro]','%d/%m/%Y %H:%i:%s'), cid='$form[cid]',
				cod_carteira='$form[cod_carteira]', validade_carteira=STR_TO_DATE('$form[validade_carteira]','%d/%m/%Y %H:%i:%s'), responsavel='$form[responsavel]' WHERE idpaciente='$form[idpaciente]'";	
		mysqli_query($mysql_conn,$query);
	 	header('location: pacientes.php' );
	
	}
}

function deletar() 
{					
}
	
?>