<?php
session_start();
include '../opendb.php';
include_once('../func.php');

$cpf = $_POST['searchCpf'];
$idpaciente = $_POST['idpaciente'];
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$start_date_report = $_POST['start_date_report'];
$idempresa = $_POST['idempresa'];
$idprofissional = $_POST['idprofissional'];
$idconvenio = $_POST['idconvenio'];
$idprocedimento = $_POST['idprocedimento'];

/*
echo "CPF:", $cpf;
echo "IDPACIENTE:", $idpaciente;
echo "NOME:", $nome;
echo "TELEFONE:", $telefone;
echo "DATA:", $start_date_report;
echo "IDEMPRESA:", $idempresa;
echo "IDPROFISSIONAL:", $idprofissional;
echo "IDCONVENIO:",$idconvenio;
echo "PROCEDIMENTO:",$idprocedimento;
*/

/* 
INFORMAÇÕES PARA IR PARA A TABELA PACIENTES: 
idpaciente está autoincrement
- idconvenio
- idempresa
- nome
- cpf
- telefone
*/

/* 
INFORMAÇÕES PARA IR PARA A TABELA AGENDAMENTOS
- idpaciente
- idconvenio
- idprocedimentos => (SELECT idprocedimentos from procedimentos where descricao = '$variavel')
- idprofissional
- idempresa
- data

*/

$query2 = "(SELECT  cpf from pacientes where cpf = '$cpf')";
$check = mysqli_query($mysql_conn,$query2); 
echo mysqli_error($mysql_conn);	
if(mysqli_num_rows($check) == 0){

    $query3 = "INSERT IGNORE INTO pacientes(idconvenio, idempresa, nome, cpf, telefone) VALUES($idconvenio, $idempresa, '$nome', '$cpf', '$telefone')";
    //var_dump($query3);
    mysqli_query($mysql_conn, $query3);
    echo mysqli_error($mysql_conn);

    $query4 = "INSERT INTO agendamentos(idpaciente, idconvenio, idprocedimentos, idprofissional,  idempresa, dataInicio, dataFim, cor, statusAtendimento)
    VALUES ((SELECT  idpaciente from pacientes where cpf = '$cpf'), $idconvenio, $idprocedimento, $idprofissional, $idempresa, STR_TO_DATE('$start_date_report', '%d/%m/%Y %H:%i:%s'), 
    ADDTIME((STR_TO_DATE('$start_date_report', '%d/%m/%Y %H:%i:%s')),'01:00:00'), '#4103ff', 'AGENDADO') ";
    //var_dump($query4);
    mysqli_query($mysql_conn, $query4);

    header('location: agendamento.php');
    
}  
 else{
    $query	= "INSERT INTO agendamentos(idpaciente, idconvenio, idprocedimentos, idprofissional,  idempresa, dataInicio, dataFim, cor, statusAtendimento)
VALUES ($idpaciente, $idconvenio, $idprocedimento, $idprofissional, $idempresa, STR_TO_DATE('$start_date_report', '%d/%m/%Y %H:%i:%s'), 
ADDTIME((STR_TO_DATE('$start_date_report', '%d/%m/%Y %H:%i:%s')),'01:00:00'), '#4103ff', 'AGENDADO') ";

//var_dump($query);
mysqli_query($mysql_conn,$query);
echo mysqli_error($mysql_conn);
header('location: agendamento.php');
 } 

 






?>