<?php
header("Content-type: text/html; charset=utf-8");
require('../../dist/fpdf/mc_table.php');

include '../opendb.php';
include_once('../func.php');




ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);


$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];


$query =  "SELECT * FROM financeiro where dataVecto BETWEEN '".$start_date."' AND '".$end_date. "' order by tipo, dataVecto"; 
//$query =  "SELECT * FROM financeiro where statusPagamento='".$_GET["statusPagamento"]."' OR dataVecto BETWEEN '".$start_date."' AND '".$end_date. "' order by tipo, dataVecto"; 

//$query =  "SELECT * FROM financeiro order by tipo, dataVecto"; 

$result = mysqli_query($mysql_conn, $query);

$row = mysqli_fetch_assoc($result);
//mysqli_fetch_assoc($result);
//class PDF extends FPDF
$pdf=new PDF_MC_Table();

$pdf->AliasNbPages();
$pdf->AddPage();

{
// Page header{
    // Logo
    $pdf->Image('../../pics/logo.png',10,6,30);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(195,-5,'Data: '.date('d/m/y'),0,0,'R');
	$pdf->Ln(1);
    // Arial bold 15
    $pdf->SetFont('Arial','B',15);
    // Move to the right
   $pdf->Cell(70);
    // Title
	$pdf->Cell(50,10,utf8_decode('Relatório Financeiro'),0,0,'C');

    // Line break
    $pdf->Ln(10);
	
		

$pdf->SetFont('arial','',10);
$pdf->Cell(185,10,utf8_decode("Período:").' '.date_format(date_create($start_date), 'd/m/Y').utf8_decode(' à ').date_format(date_create($end_date), 'd/m/Y') ,0,1,'C');
$pdf->Ln(5);

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
}

}

// Instanciation of inherited class
$pdf->SetFont('arial','',9);

// Extrai cada linha da tabela dados
// configura a quantidade de colunas a serem impressas esse número deve ser igual a quantidade de celulas

$pdf->SetWidths(array(10,60,30,30,20,20,28));
$result1 = mysqli_query($mysql_conn, $query);

$current_tipo = null;
global $row;

while ($row = mysqli_fetch_assoc($result1)) 
		{
			if ($row["tipo"] != $current_tipo) {
			if ($current_tipo != null ){
				$pdf->Cell(48,10,'Total : R$ '. number_format($total,2,",",".").'',"LB",0,"LB");
				$pdf->Cell(47,10,'Total Pago: R$ '. number_format($totalPago,2,",",".").'',"B",0,"LB");
				$pdf->Cell(52,10,'Total Sld.Devedor: R$ '. number_format($totalSaldoDevedor,2,",",".").'',"B",0,"LB");
				$pdf->Cell(51,10,'Total Desconto: R$ '. number_format($totalDesconto,2,",",".").'',"BR",1,"L");
			
					
				}
			$current_tipo = $row["tipo"];
			
			$total=0;
			$totalPago=0;
			$totalSaldoDevedor=0;
			$totalDesconto=0;
			
			$pdf->Ln(5);
			$pdf->SetFont('arial','B',9);
			$pdf->Cell(198,10,''.utf8_decode($row["tipo"]).'',1,1,"L");
			
		
			//cabeçalho da tabela 
			$pdf->SetFont('arial','',9);
			$pdf->Cell(10,10,''.utf8_decode("Filial"),1,0,"L");
			$pdf->Cell(60,10,''.utf8_decode("Descricao"),1,0,"L");
			
			$pdf->Cell(30,10,''.utf8_decode("Data Vencimento"),1,0,"L");
			$pdf->Cell(30,10,''.utf8_decode("Data Recebimento"),1,0,"L");
			
			$pdf->Cell(20,10,''.utf8_decode("Valor"),1,0,"L");
			$pdf->Cell(20,10,''.utf8_decode("Valor Pago"),1,0,"L");
			$pdf->Cell(28,10,''.utf8_decode("Status"),1,0,"L");
			
			$total=$total+$row["valor"];
			$totalPago=$totalPago+$row["valorRecebido"];
			$totalSaldoDevedor=$totalSaldoDevedor+$row["saldoDevedor"];
			$totalDesconto=$totalDesconto+$row["desconto"];
			
			$pdf->Ln(10);
			
			 $pdf->Row(array(utf8_decode($row["idempresa"]), utf8_decode($row["descricao"]), date('d/m/Y', strtotime($row["dataVecto"])), date('d/m/Y', strtotime($row["dataRecebimento"])),
			 number_format($row["valor"],2,",","."), number_format($row["valorRecebido"],2,",","."), utf8_decode($row["statusPagamento"]) ));	
			
		
			}
			else
			{	
				$pdf->SetFont('arial','',9);
		 $pdf->Row(array(utf8_decode($row["idempresa"]), utf8_decode($row["descricao"]), date('d/m/Y', strtotime($row["dataVecto"])), date('d/m/Y', strtotime($row["dataRecebimento"])),
			 number_format($row["valor"],2,",","."), number_format($row["valorRecebido"],2,",","."), utf8_decode($row["statusPagamento"]) ));	
				$total=$total+$row["valor"];
			$totalPago=$totalPago+$row["valorRecebido"];
			$totalSaldoDevedor=$totalSaldoDevedor+$row["saldoDevedor"];
			$totalDesconto=$totalDesconto+$row["desconto"];
				}
			}
			if ($current_tipo != null){
					$pdf->Cell(48,10,'Total : R$ '. number_format($total,2,",",".").'',"LB",0,"LB");
				$pdf->Cell(47,10,'Total Pago: R$ '. number_format($totalPago,2,",",".").'',"B",0,"LB");
				$pdf->Cell(52,10,'Total Sld.Devedor: R$ '. number_format($totalSaldoDevedor,2,",",".").'',"B",0,"LB");
				$pdf->Cell(51,10,'Total Desconto: R$ '. number_format($totalDesconto,2,",",".").'',"BR",1,"L");
		
					
			}
			
	$pdf->Output();
?>		
