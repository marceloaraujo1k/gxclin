<?php
session_start();
include '../opendb.php';
include_once('../func.php');
include '../../dist/fpdf/fpdf.php';
//H = Margint Top and Bottom
// W = Margin Left e Right

$sql = $mysql_conn;

class myPDF extends FPDF{
    
    function header(){
        include '../opendb.php';
        $sql = $mysql_conn;
        $id = $_GET['id'];
        $query = mysqli_query($sql,"SELECT * FROM pacientes WHERE idpaciente = $id ");
        $row = mysqli_fetch_assoc($query);

        $this->Image('../../pics/logo.png');
        $this->SetFont('Arial','B',14);
        $this->Cell(276,5,iconv('UTF-8', 'windows-1252', 'Ficha de Exportação'),0,0,'C');
        $this->Ln(); // /BR Espaço de uma linha para outra 
        
        $this->SetFont('Times','',12);
        $this->Cell(276,10,'Dados Cadastrais do Paciente:',0,0,'C');
        $this->Ln(); // /BR Espaço de uma linha para outra 
        $this->SetFont('Arial','I',18);
        $this->Cell(276,5,iconv('UTF-8', 'windows-1252', $row['nome']),0,0,'C');
        
        $this->Ln(15);

    }

    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','',8);
        $this->Cell(0,10,iconv('UTF-8', 'windows-1252', 'Página').$this->PageNo().'/{nb}',0,0,'C');

    }

    function headerTable(){
        $this->SetFont('Times','B',12);
        $this->Cell(65,10,iconv('UTF-8', 'windows-1252', 'Nome'),1,0,'C');
        $this->Cell(30,10,iconv('UTF-8', 'windows-1252', 'Sexo'),1,0,'C');
        $this->Cell(45,10,iconv('UTF-8', 'windows-1252', 'Data Nascimento'),1,0,'C');
        $this->Cell(35,10,iconv('UTF-8', 'windows-1252', 'Estado Civil'),1,0,'C');
        $this->Cell(45,10,iconv('UTF-8', 'windows-1252', 'Identidade'),1,0,'C');
        $this->Cell(30,10,iconv('UTF-8', 'windows-1252', 'CPF'),1,0,'C');
        $this->Cell(25,10,iconv('UTF-8', 'windows-1252', 'Código'),1,0,'C');
        $this->Ln();
    }

    function viewTable($sql){
        $id = $_GET['id'];
        $query = mysqli_query($sql,"SELECT * FROM pacientes WHERE idpaciente = $id ");
        $row = mysqli_fetch_assoc($query);

        $this->SetFont('Times', '',10);
        $this->Cell(65,10,iconv('UTF-8', 'windows-1252', $row["nome"]),1,0,'L');
        $this->Cell(30,10,iconv('UTF-8', 'windows-1252', $row["sexo"]),1,0,'L');
        $this->Cell(45,10,iconv('UTF-8', 'windows-1252', date('d/m/Y', strtotime($row["nascimento"])) ),1,0,'L');
        $this->Cell(35,10,iconv('UTF-8', 'windows-1252', $row["estado_civil"]),1,0,'L');
        $this->Cell(45,10,iconv('UTF-8', 'windows-1252', $row["rg"]),1,0,'L');
        $this->Cell(30,10,iconv('UTF-8', 'windows-1252', $row["cpf"]),1,0,'L');
        $this->Cell(25,10,iconv('UTF-8', 'windows-1252', $row["codigo"]),1,0,'L');
        $this->Ln();
    }

    function headerTable2(){
        $this->Ln();
        $this->SetFont('Times','B',12);
        $this->Cell(10,10,iconv('UTF-8', 'windows-1252', 'CID'),1,0,'C');
        $this->Cell(60,10,iconv('UTF-8', 'windows-1252', 'Pai'),1,0,'C');
        $this->Cell(60,10,iconv('UTF-8', 'windows-1252', 'Mãe'),1,0,'C');
        $this->Cell(45,10,iconv('UTF-8', 'windows-1252', 'Endereço'),1,0,'C');
        $this->Cell(45,10,iconv('UTF-8', 'windows-1252', 'Bairro'),1,0,'C');
        $this->Cell(30,10,iconv('UTF-8', 'windows-1252', 'Município'),1,0,'C');
        $this->Cell(25,10,iconv('UTF-8', 'windows-1252', 'CEP'),1,0,'C');
        $this->Ln();
    }

    function viewTable2($sql){
        $id = $_GET['id'];
        $query = mysqli_query($sql,"SELECT * FROM pacientes WHERE idpaciente = $id ");
        $row = mysqli_fetch_assoc($query);

        $this->SetFont('Times','',10);
        $this->Cell(10,10,iconv('UTF-8', 'windows-1252', $row['cid']),1,0,'L');
        $this->Cell(60,10,iconv('UTF-8', 'windows-1252', $row['pai']),1,0,'L');
        $this->Cell(60,10,iconv('UTF-8', 'windows-1252', $row['mae']),1,0,'L');
        $this->Cell(45,10,iconv('UTF-8', 'windows-1252', $row['endereco']),1,0,'L');
        $this->Cell(45,10,iconv('UTF-8', 'windows-1252', $row['bairro']),1,0,'L');
        $this->Cell(30,10,iconv('UTF-8', 'windows-1252', $row['municipio']),1,0,'L');
        $this->Cell(25,10,iconv('UTF-8', 'windows-1252', $row['cep']),1,0,'L');
        $this->Ln();
    }

    function headerTable3(){
        $this->Ln();
        $this->SetFont('Times','B',12);

        $this->Cell(50,10,iconv('UTF-8', 'windows-1252', 'Estado'),1,0,'C');
        $this->Cell(35,10,iconv('UTF-8', 'windows-1252', 'Tel.Resid'),1,0,'C');
        $this->Cell(35,10,iconv('UTF-8', 'windows-1252', 'Celular'),1,0,'C');
        $this->Cell(35,10,iconv('UTF-8', 'windows-1252', 'Tel.Trabalho'),1,0,'C');
        $this->Cell(45,10,iconv('UTF-8', 'windows-1252', 'Convênio'),1,0,'C');
        $this->Cell(40,10,iconv('UTF-8', 'windows-1252', 'Número Carteira'),1,0,'C');
        $this->Cell(35,10,iconv('UTF-8', 'windows-1252', 'Validade Carteira'),1,0,'C');
        $this->Ln();
    }

    function viewTable3($sql){
        $id = $_GET['id'];
        $query = mysqli_query($sql,"SELECT a.estado, a.telefone, a.celular, a.tel_trabalho, a.cod_carteira, a.validade_carteira, b.descricao FROM pacientes AS a 
        INNER JOIN convenio AS b ON a.idconvenio = b.idconvenio WHERE idpaciente = $id ");
        $row = mysqli_fetch_assoc($query);

        $this->SetFont('Times', '',10);
        $this->Cell(50,10,iconv('UTF-8', 'windows-1252', $row['estado']),1,0,'L');
        $this->Cell(35,10,iconv('UTF-8', 'windows-1252', $row['telefone']),1,0,'L');
        $this->Cell(35,10,iconv('UTF-8', 'windows-1252', $row['celular']),1,0,'L');
        $this->Cell(35,10,iconv('UTF-8', 'windows-1252', $row['tel_trabalho']),1,0,'L');
        $this->Cell(45,10,iconv('UTF-8', 'windows-1252', $row['descricao']),1,0,'L');
        $this->Cell(40,10,iconv('UTF-8', 'windows-1252', $row['cod_carteira']),1,0,'L');
        $this->Cell(35,10,iconv('UTF-8', 'windows-1252', date('d/m/Y', strtotime($row['validade_carteira'])) ),1,0,'L');
        $this->Ln();
    }

    function headerTable4(){
        $this->Ln();
        $this->SetFont('Times','B',12);
        $this->Cell(50,10,iconv('UTF-8', 'windows-1252', 'Filial'),1,0,'C');
        $this->Cell(60,10,iconv('UTF-8', 'windows-1252', 'Responsável'),1,0,'C');
        $this->Cell(50,10,iconv('UTF-8', 'windows-1252', 'Email'),1,0,'C');
        $this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Data Cadastro'),1,0,'C');
        $this->Cell(83,10,iconv('UTF-8', 'windows-1252', 'Observações'),1,0,'C');
        $this->Ln();
    }

    function viewTable4($sql){
        $id = $_GET['id'];
        $query = mysqli_query($sql,"SELECT a.responsavel, a.email, a.data_cadastro, a.observacao, b.empresa FROM pacientes AS a 
        INNER JOIN empresa AS b ON a.idempresa = b.idempresa WHERE idpaciente = $id ");
        $row = mysqli_fetch_assoc($query);
        
        $this->SetFont('Times', '',10);
        $this->Cell(50,10,iconv('UTF-8', 'windows-1252', $row['empresa']),1,0,'L');
        $this->Cell(60,10,iconv('UTF-8', 'windows-1252', $row['responsavel']),1,0,'L');
        $this->Cell(50,10,iconv('UTF-8', 'windows-1252', $row['email']),1,0,'L');
        $this->Cell(32,10,iconv('UTF-8', 'windows-1252', date('d/m/Y', strtotime($row['data_cadastro'])) ),1,0,'L');
        $this->Cell(83,10,iconv('UTF-8', 'windows-1252', $row['observacao']),1,0,'L');
        $this->Ln();
    }
}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$pdf->headerTable();
$pdf->viewTable($sql);

$pdf->headerTable2();
$pdf->viewTable2($sql);

$pdf->headerTable3();
$pdf->viewTable3($sql);

$pdf->headerTable4();
$pdf->viewTable4($sql);

$pdf->Output();
?>