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
    $status = "PAGO";
			break;
	
	case '3':
		$dataOpcao = "dataRepasse";
		break;	
} 

$query=null;

if (!empty($id)){

  $query = "SELECT producao.idconvenio, producao.idmedico, producao.medico,  sum(producao.valorProcedimento) , producao.hospital, producao.dataPagamento,
  sum(producao.valorRecebido) as total, convenio.pis, convenio.cofins, convenio.csll, convenio.irpj, convenio.iss, convenio.outros_encargos, convenio.classificacao, convenio.idconvenio 
  FROM producao inner join convenio on producao.idconvenio = convenio.idconvenio  where  producao.idconvenio = 21 AND producao.hospital = '".$_GET["hospital"]."' 
  AND producao.idmedico='".$_GET["id"]."' AND producao.".$dataOpcao."  BETWEEN '.$start_date.' AND '.$end_date.' group by producao.idmedico;";
}
else {
  $query =  "SELECT producao.idconvenio, producao.idmedico, producao.medico,  sum(producao.valorProcedimento) , producao.hospital, 
  sum(producao.valorRecebido) as total, convenio.pis, convenio.cofins, convenio.csll, convenio.irpj, convenio.iss, convenio.outros_encargos, convenio.classificacao, convenio.idconvenio FROM producao inner join convenio 
  on producao.idconvenio = convenio.idconvenio  where  producao.idconvenio = 21 AND  producao.hospital = '".$_GET["hospital"]."' 
  AND producao.".$dataOpcao."  BETWEEN '.$start_date.' AND '.$end_date.' group by producao.idmedico;";
}

$result = mysqli_query($mysql_conn, $query);


$mesFatura = $start_date;


$pdf=new PDF_MC_Table();

$pdf->AliasNbPages();
$pdf->AddPage("p");

{
// Page header{
    // Arial bold 15
    $pdf->SetFont('Arial','B',8);
	// Move to the right   
	$pdf->SetX(2);
	$pdf->SetFillColor(166,166,166);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(140,5,utf8_decode('FATURA SUS'),1,0,'C',true);
	$pdf->Cell(30,5,utf8_decode("PERÍODO:"),1,0,'C',true);
	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');
	$pdf->SetFillColor(255,255,0);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(35,5,strftime('%B %Y', strtotime($mesFatura)),1,1,'C',true);
	
	$pdf->SetFillColor(166,166,166);
	$pdf->SetTextColor(255,255,255);
	$pdf->ln();

	$pdf->SetX(2);
	$pdf->Cell(25,5,'PRESTADOR DE','LRT',0,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(60,5,utf8_decode('Clínica de Anestesiologista de Mossoró'),'LRT',0,'C',true);

	$pdf->SetFillColor(166,166,166);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(25,5,utf8_decode('HOSPITAL/'),'LRTB',0,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(50,5,utf8_decode($_GET["hospital"]),'LRT',0,'C',true);


	$pdf->SetFillColor(166,166,166);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(45,5,utf8_decode('INFORMAÇÕES PARA'),'LRTB',1,'C',true);
	

	$pdf->SetX(2);	
	$pdf->Cell(25,5,utf8_decode('SERVIÇO'),'LRB',0,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(60,5,'CAM','LR',0,'C',true);
	$pdf->SetFillColor(166,166,166);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(25,5,utf8_decode('CONVÊNIO'),'LRB',0,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(50,5,'','LR',0,'C',true);
	$pdf->SetFillColor(166,166,166);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(45,5,utf8_decode('PAGAMENTO'),'LRB',1,'C',true);
	

	$pdf->SetX(2);	
	$pdf->SetFillColor(242,242,242);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(25,5,utf8_decode('ENDEREÇO'),'LRB',0,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(60,5,utf8_decode('Rua 6 de janeiro, Santo Antônio'),'LRT',0,'C',true);
	
	$pdf->SetFillColor(242,242,242);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(25,5,utf8_decode('ENDEREÇO'),'LRB',0,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(50,5,utf8_decode(''),'LRT',0,'C',true);

	$pdf->SetFillColor(242,242,242);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(45,5,utf8_decode('BANCO'),'LRB',1,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);

	
	$pdf->SetX(2);	
	$pdf->SetFillColor(242,242,242);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(25,5,utf8_decode('CEP/CIDADE'),'LRB',0,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(60,5, utf8_decode('59.611-070 / Mossoró RN'),'LRT',0,'C',true);
	
	$pdf->SetFillColor(242,242,242);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(25,5,utf8_decode('CEP/CIDADE'),'LRB',0,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(50,5,'','LRT',0,'C',true);

	$pdf->SetFillColor(242,242,242);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(45,5,utf8_decode('AGÊNCIA'),'LRB',1,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);

	$pdf->SetFillColor(242,242,242);
	$pdf->SetFillColor(255,255,0);
  


	
	$pdf->SetX(2);	
	$pdf->SetFillColor(242,242,242);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(25,5,utf8_decode('CNPJ'),'LRB',0,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(60,5,'CNPJ: 07.275.740/0001-80','LRT',0,'C',true);
	
	$pdf->SetFillColor(242,242,242);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(25,5,utf8_decode('CNPJ'),'LRB',0,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(50,5,'','LRT',0,'C',true);

	$pdf->SetFillColor(242,242,242);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(45,5,utf8_decode('CONTA CORRENTE'),'LRB',1,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);



	
	$pdf->SetX(2);	
	$pdf->SetFillColor(242,242,242);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(25,5,utf8_decode('TELEFONE'),'LRB',0,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(60,5,'Tel. 84 3314-1552','LRTB',0,'C',true);
	
	$pdf->SetFillColor(242,242,242);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(25,5,utf8_decode('TELEFONE'),'LRB',0,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(50,5,' ','LRTB',0,'C',true);

	$pdf->SetFillColor(242,242,242);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(45,5,utf8_decode('R$ FATURA	'),'LRB',1,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);


	// Line break
  	$pdf->Ln(10);
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0,0,0);


	// simple example query
$r=$result;
$contador = 0;
    for($i=0; $i<mysqli_num_rows($r); $i=$i+3){
    mysqli_data_seek($r,$i);
	$users[$i]=mysqli_fetch_row($r);
	//$pdf->SetX(2);
	$pdf->SetFillColor(242,242,242);
	$pdf->Cell(40,5,utf8_decode($users[$i][2]),1,0,'C',true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(25,5,'R$ '.number_format($users[$i][3],2,",","."),1,0,'C',true);

    mysqli_data_seek($r,$i+1);
		$users[$i]=mysqli_fetch_row($r);
		$pdf->SetFillColor(242,242,242);
		$pdf->Cell(40,5,utf8_decode($users[$i][2]),1,0,'C',true);
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(25,5,'R$ '.number_format($users[$i][3],2,",","."),1,0,'C',true);

	mysqli_data_seek($r,$i+2);
		$users[$i]=mysqli_fetch_row($r);
		$pdf->SetFillColor(242,242,242);
		$pdf->Cell(40,5,utf8_decode($users[$i][2]),1,0,'C',true);
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(25,5,'R$ '.number_format($users[$i][3],2,",","."),1,1,'C',true);
    }

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

$pdf->ln();

$query1=null;

  if(!empty($id)){
    $query1 =  "SELECT producao.dataRealizacao, producao.paciente, producao.idmedico, producao.medico, producao.codigoProcedimento, producao.descricaoProcedimento, 
    producao.dataPagamento, producao.valorProcedimento, producao.valorRecebido, producao.hospital, convenio.pis, convenio.cofins, convenio.csll, convenio.irpj, convenio.iss, convenio.outros_encargos, 
    convenio.classificacao, convenio.idconvenio FROM producao inner join convenio on producao.idconvenio = convenio.idconvenio  where  producao.idconvenio = 21 AND producao.idmedico='".$_GET["id"]."'
    AND producao.hospital = '".$_GET["hospital"]."' AND producao.".$dataOpcao."  BETWEEN '.$start_date.' AND '.$end_date.' ;"; 
      }
  else {
    $query1 =  "SELECT producao.dataRealizacao, producao.paciente, producao.idmedico, producao.medico, producao.codigoProcedimento, producao.descricaoProcedimento, 
     producao.valorProcedimento, producao.valorRecebido,  producao.hospital, convenio.pis, convenio.cofins, convenio.csll, convenio.irpj, convenio.iss, convenio.outros_encargos, convenio.classificacao, convenio.idconvenio FROM producao inner join convenio 
    on producao.idconvenio = convenio.idconvenio  where  producao.idconvenio = 21 AND producao.hospital = '".$_GET["hospital"]."'  AND 
    producao.".$dataOpcao."  BETWEEN '.$start_date.' AND '.$end_date. ' order by producao.idmedico;";    
   }

$result1 = mysqli_query($mysql_conn, $query1);

$pdf->SetFillColor(166,166,166);
$pdf->SetTextColor(0,0,0);

$pdf->Cell(20,5,''.utf8_decode("DATA DE"),1,0,"C",true);
$pdf->Cell(50,5,''.utf8_decode("NOME DO PACIENTE"),1,0,"C",true);
$pdf->Cell(100,5,''.utf8_decode("PROCEDIMENTO"),1,0,"C",true);
$pdf->Cell(24,5,''.utf8_decode("R$"),1,1,"C",true);

 
$pdf->Cell(20,5,''.utf8_decode("REALIZAÇÃO"),"LRB",0,"C",true);
$pdf->Cell(50,5,''.utf8_decode(""),1,0,"L",true);
$pdf->Cell(30,5,''.utf8_decode("CÓD"),1,0,"L",true);
$pdf->Cell(30,5,''.utf8_decode("DESCRIÇÃO"),1,0,"L",true);
$pdf->Cell(40,5,''.utf8_decode("ANESTESIOL."),1,0,"L",true);
$pdf->Cell(24,5,''.utf8_decode(""),1,1,"L",true);

$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
/*
$pdf->Cell(20,5,''.utf8_decode("CÓD."),1,0,"L");
$pdf->Cell(60,5,''.utf8_decode("DESCRIÇÃO"),1,0,"L");
$pdf->Cell(20,5,''.utf8_decode("ANESTESIOL."),1,0,"L");*/


$pdf->SetWidths(array(20,50,30,30,40,24));

if(mysqli_num_rows($result1) > 0){
    while($row1= mysqli_fetch_assoc($result1)){
		$pdf->Row(array(date('d/m/Y', strtotime($row1["dataRealizacao"])), utf8_decode($row1["paciente"]), utf8_decode($row1["codigoProcedimento"]), utf8_decode($row1["descricaoProcedimento"]),  utf8_decode($row1["medico"]), number_format($row1["valorRecebido"],2,",",".")));
		}
	 }

	}

	 $pdf->Output();
?>