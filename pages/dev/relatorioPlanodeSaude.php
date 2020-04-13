<?php
header("Content-type: text/html; charset=utf-8");
require('../../dist/fpdf/mc_table.php');

include '../opendb.php';
include_once('../func.php');

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

//Periodo 
$id = $_GET["id"];
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
// Essa variavel define o tipo de filtro de data  "0"=Data de Realização  | "1=Data de Cobrança  | "2"=Data de Pagamento | "3"=Data de Repasse
$filtroDataTipo = $_GET["filtroDataTipo"];

$dataOpcao = null;

switch ($filtroDataTipo) {
	case '0':
    $dataOpcao = "dataRealizacao";
    $status = "PENDENTE";
    break;
	
	case '1':
		$dataOpcao = "dataCobranca";
		break;

	case '2':
	$dataOpcao = "dataPagamento";
	$dataFormato = "DATA DE PAGAMENTO";
    $status = "PAGO";
			break;
	
	case '3':
		$dataOpcao = "dataRepasse";
		$status = "PAGO";
		$dataFormato = "DATA DE REPASSE";
		break;	
} 

$query=null;

if (!empty($id)){

  $query = "SELECT producao.idconvenio, producao.idmedico, producao.medico,  sum(producao.valorProcedimento) as totalCobrado , 
 			 sum(producao.valorRecebido) as totalRecebido, convenio.pis, convenio.cofins, convenio.csll, convenio.irpj, convenio.iss, convenio.outros_encargos, convenio.classificacao, convenio.idconvenio, convenio.descricao FROM producao inner join convenio 
		  on producao.idconvenio = convenio.idconvenio where convenio.classificacao='PLANO DE SAÚDE' AND   producao.".$dataOpcao."  BETWEEN '".$start_date."' AND '".$end_date. "' group by convenio.idconvenio, producao.medico;";
}
else {
	$query =  "SELECT producao.idconvenio,  producao.idmedico, producao.medico,  sum(producao.valorProcedimento) as totalCobrado, 
	sum(producao.valorRecebido) as totalRecebido, convenio.pis, convenio.cofins, convenio.csll, convenio.irpj, convenio.iss, convenio.outros_encargos, convenio.classificacao, convenio.idconvenio, convenio.descricao FROM producao inner join convenio 
	on producao.idconvenio = convenio.idconvenio where convenio.classificacao='PLANO DE SAÚDE' AND  producao.".$dataOpcao."   BETWEEN '".$start_date."' AND '".$end_date. "' group by convenio.idconvenio, producao.medico;";
}

$result = mysqli_query($mysql_conn, $query);
$mesFatura = $start_date;

$query1 = "SELECT * from convenio where convenio.classificacao='PLANO DE SAÚDE';";
$result1 = mysqli_query($mysql_conn, $query1);

//$pdf=new P('L','mm',);
$pdf=new PDF_MC_Table();

$pdf->AliasNbPages();
$pdf->AddPage("P");

{
// Page header{
    // Arial bold 15
    $pdf->SetFont('Arial','B',8);
	// Move to the right   
	$pdf->SetFillColor(166,166,166);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(180,10,utf8_decode('RELATÓRIO GERENCIAL DE REALIZAÇÃO DE PROCEDIMENTOS PLANO DE SAÚDE'),1,1,'C',true);
	$pdf->Cell(90,5,utf8_decode($dataFormato." PERÍODO: "),1,0,'C',true);
	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');
	$pdf->SetFillColor(255,255,0);
	$pdf->SetTextColor(0,0,0);

	$pdf->Cell(90,5,strftime('%B %Y', strtotime($mesFatura)),1,1,'C',true);
	
	$pdf->SetFillColor(0,176,240);
	$pdf->SetTextColor(255,255,255);
	$pdf->ln();

	while ($row1=mysqli_fetch_assoc($result1)) { 
	}
	

	$pdf->ln();
	$pdf->SetTextColor(0,0,0);

	$pdf->SetFillColor(242,242,242);
	$pdf->SetFillColor(255,255,0);
    // Line break
    $pdf->Ln(10);
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0,0,0);


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

$current_convenio=null;
$totalCobradoConvenio = null;
$totalPagoConvenio = null;


$pdf->SetWidths(array(70,50,30,30));

			
$pdf->Cell(70,10,''.utf8_decode("PLANO DE SAÚDE"),1,0,"L");
$pdf->Cell(50,10,''.utf8_decode("MÉDICO"),1,0,"L");
$pdf->Cell(30,10,''.utf8_decode("TOTAL COBRADO"),1,0,"L");
$pdf->Cell(30,10,''.utf8_decode("TOTAL PAGO"),1,1,"L");

if(mysqli_num_rows($result) > 0){
    while($row= mysqli_fetch_assoc($result)){
		if ($row["descricao"] != $current_convenio) {
			if ($current_convenio != null) { 
				$pdf->Cell(180,10,utf8_decode('TOTAL COBRADO CONVÊNIO R$ ') . number_format($totalCobradoConvenio,2,",","."),"LTR",1,"L");
				$pdf->Cell(180,10,utf8_decode('TOTAL PAGO CONVÊNIO R$ ') . number_format($totalPagoConvenio,2,",","."),"LRB",1,"L");
				
				$pdf->Cell(70,10,''.utf8_decode("PLANO DE SAÚDE"),1,0,"L");
				$pdf->Cell(50,10,''.utf8_decode("MÉDICO"),1,0,"L");
				$pdf->Cell(30,10,''.utf8_decode("TOTAL COBRADO"),1,0,"L");
				$pdf->Cell(30,10,''.utf8_decode("TOTAL PAGO"),1,1,"L");
				
				  
			}
			$current_convenio = $row["descricao"];	
			$totalCobradoConvenio = 0;
			$totalPagoConvenio = 0;
			$pdf->Row(array(utf8_decode($row["descricao"]), utf8_decode($row["medico"]), number_format($row["totalCobrado"],2,",","."), number_format($row["totalRecebido"],2,",",".")));
			$totalCobradoConvenio=$totalCobradoConvenio+$row["totalCobrado"];
			$totalPagoConvenio=$totalPagoConvenio+$row["totalRecebido"];
		}
		else {
			$pdf->Row(array(utf8_decode($row["descricao"]), utf8_decode($row["medico"]), number_format($row["totalCobrado"],2,",","."), number_format($row["totalRecebido"],2,",",".")));
			$totalCobradoConvenio=$totalCobradoConvenio+$row["totalCobrado"];
			$totalPagoConvenio=$totalPagoConvenio+$row["totalRecebido"];
			}
		}
		if ($current_convenio != null){
			$pdf->Cell(180,10,utf8_decode('TOTAL COBRADO CONVÊNIO R$ ') . number_format($totalCobradoConvenio,2,",","."),"LTR",1,"L");
			$pdf->Cell(180,10,utf8_decode('TOTAL PAGO CONVÊNIO R$ ') . number_format($totalPagoConvenio,2,",","."),"LRB",0,"L");
			
		}
	 
	}
	

}


	 $pdf->Output();
?>