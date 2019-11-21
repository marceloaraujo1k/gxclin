<?php
header("Content-type: text/html; charset=utf-8");
require('../../dist/fpdf/fpdf.php');

include '../opendb.php';
include_once('../func.php');

$id = $_GET["id"];
$nome = $_GET["nome"];
$sexo = $_GET["sexo"];
$idade = $_GET["idade"];

$query = mysqli_query($mysql_conn, "SELECT * FROM avaliacao WHERE idavaliacao='$id'");
$row = mysqli_fetch_assoc($query);

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('../../pics/LOGO_BURNFIT_REDUCE.PNG',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
	$this->Cell(50,10,utf8_decode('Avaliação Física'),0,0,'C');

    // Line break
    $this->Ln(15);
	
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

function BasicTable($header, $data)
{
    // Header
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->Cell(90,5,'Nome: '.$nome);
$pdf->Cell(50,5,'Sexo: '.$sexo);
$pdf->Cell(50,5,'Idade: '.$idade);
$pdf->Ln(5);

$pdf->Cell(0,5,"","B",1,'C');

$pdf->SetFont('arial','B',12);

$pdf->Ln(5);
$pdf->Cell(0,5,utf8_decode("Parâmetros Corporais"),0,1,'C');

$pdf->Ln(5);

 
//cabeçalho da tabela 
$pdf->SetFont('arial','B',11);
$pdf->Cell(90,10,'Indicador',1,0,"L");
$pdf->Cell(50,10,'Valor',1,0,"L");
$pdf->Cell(50,10,'Faixa Normal',1,0,"L");
$pdf->Ln(10);
 
 
$pdf->SetFont('arial','',11);

$pdf->Cell(90,10,"Peso",1,0,"L");
$pdf->Cell(50,10,''.$row["peso"].'',1,0,"L");
$pdf->Cell(50,10,'',1,0,"L");
$pdf->Ln(10);

$pdf->Cell(90,10,"Altura",1,0,"L");
$pdf->Cell(50,10,''.$row["altura"].'',1,0,"L");
$pdf->Cell(50,10,'',1,0,"L");
$pdf->Ln(10);

$pdf->Cell(90,10,"IMC",1,0,"L");
$pdf->Cell(50,10,''.$row["imc"].'',1,0,"L");
$pdf->Cell(50,10,'',1,0,"L");
$pdf->Ln(10);

$pdf->Cell(90,10,"Metabolismo Basal",1,0,"L");
$pdf->Cell(50,10,''.$row["metabolismo_basal"].'',1,0,"L");
$pdf->Cell(50,10,'',1,0,"L");
$pdf->Ln(10);

$pdf->Cell(90,10,"Idade Corporal",1,0,"L");
$pdf->Cell(50,10,''.$row["idade_corporal"].'',1,0,"L");
$pdf->Cell(50,10,'',1,0,"L");
$pdf->Ln(10);

$pdf->Cell(90,10,"% de Gordura Corporal",1,0,"L");
$pdf->Cell(50,10,''.$row["gordura_corporal"].'',1,0,"L");
$pdf->Cell(50,10,'',1,0,"L");
$pdf->Ln(10);

$pdf->Cell(90,10,"Nivel de Gordura Visceral",1,0,"L");
$pdf->Cell(50,10,''.$row["gordura_visceral"].'',1,0,"L");
$pdf->Cell(50,10,'',1,0,"L");
$pdf->Ln(10);

$pdf->Cell(90,10,utf8_decode("% Músculos Esqueléticos"),1,0,"L");
$pdf->Cell(50,10,''.$row["musculos_esqueleticos"].'',1,0,"L");
$pdf->Cell(50,10,'',1,0,"L");
$pdf->Ln(10);

$pdf->Cell(90,10,utf8_decode("Relação Cintura/Quadril"),1,0,"L");
$pdf->Cell(50,10,''.number_format(($row["cintura"]/$row["quadril"]),2,",",".").'',1,0,"L");
$pdf->Cell(50,10,'',1,0,"L");
$pdf->Ln(10);

if ($sexo=='F') {
$pdf->Cell(90,10,"Quadril",1,0,"L");
$pdf->Cell(50,10,''.$row["quadril"].'',1,0,"L");
$pdf->Cell(50,10,'',1,0,"L");
$pdf->Ln(10);
}
$pdf->Cell(90,10,"PAD (mmHg)",1,0,"L");
$pdf->Cell(50,10,''.$row["PAD"].'',1,0,"L");
$pdf->Cell(50,10,'',1,0,"L");
$pdf->Ln(10);


$pdf->Cell(90,10,"PAS (mmHg)",1,0,"L");
$pdf->Cell(50,10,''.$row["PAS"].'',1,0,"L");
$pdf->Cell(50,10,'',1,0,"L");
$pdf->Ln(10);

$pdf->Cell(90,10,"Pul/min (bpm)",1,0,"L");
$pdf->Cell(50,10,''.$row["frequencia_cardiaca"].'',1,0,"L");
$pdf->Cell(50,10,'',1,0,"L");
$pdf->Ln(10);


$pdf->Ln(5);
$pdf->SetFont('arial','B',11);
$pdf->Cell(0,5,''.utf8_decode("Parâmetros Funcionais"),0,0,'C');
//$pdf->Cell(100,5,''.utf8_decode("Planejamento de Metas"),0,0,'C');
//$pdf->Cell(90,5,"","B",1,'C');
$pdf->Ln(10);

$pdf->SetFont('arial','',11);
$pdf->Cell(90,7,'Agachamento Profundo? '.utf8_decode($row["teste_funcional1"]));
$pdf->Ln();
$pdf->Cell(100,7,utf8_decode("Teste de palma da mão no solo?").utf8_decode($row["teste_funcional2"]));
$pdf->Ln();
$pdf->Cell(100,7,utf8_decode("Mobilidade de ombro? ").utf8_decode($row["teste_funcional3"]));
$pdf->Ln();
$pdf->Cell(100,7,utf8_decode("Resultado ").($row["teste_funcional1"]+$row["teste_funcional2"]+$row["teste_funcional3"]));
$pdf->Ln(10);

$pdf->SetFont('arial','B',11);
$pdf->Cell(0,5,''.utf8_decode("Planejamento de Metas"),0,0,'C');
//$pdf->Cell(100,5,''.utf8_decode("Planejamento de Metas"),0,0,'C');
$pdf->Ln(10);

$pdf->SetFont('arial','',11);
$pdf->Cell(90,5,'Quanto tempo pretende atingir seu objetivo? '.utf8_decode($row["meta_objetivo"]));
$pdf->Ln();
$pdf->Cell(100,7,utf8_decode("Quantas vezes por semana você tem disponibilidade de fazer academia? ").$row["frequencia_semanal"]);
$pdf->Ln();
$pdf->Cell(100,7,utf8_decode("Quais modalidades que você tem maior interesse? ").$row["modalidades"]);
$pdf->Ln();
$pdf->Cell(100,7,utf8_decode("Observações (rotina diária/uso de medicamentos/doenças ou dores)? ").$row["observacoes"]);
$pdf->Ln(5);

$pdf->Output();
?>