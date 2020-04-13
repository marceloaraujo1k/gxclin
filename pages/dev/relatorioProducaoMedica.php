<?php
header("Content-type: text/html; charset=utf-8");
require('../../dist/fpdf/mc_table.php');

include '../opendb.php';
include_once('../func.php');




ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

//Periodo 
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
// Essa variavel define o tipo de filtro de data  "0"=Data de Realização  | "1=Data de Cobrança  | "2"=Data de Pagamento | "3"=Data de Repasse
$filtroDataTipo = $_GET["filtroDataTipo"];

$dataOpcao = null;

switch ($filtroDataTipo) {
	case '0':
		$dataOpcao = "dataRealizacao";
		break;
	
	case '1':
		$dataOpcao = "dataCobranca";
		break;

	case '2':
		$dataOpcao = "dataPagamento";
			break;
	
	case '3':
		$dataOpcao = "dataRepasse";
		break;	
}


$query =  "SELECT * FROM producao inner join convenio on producao.idconvenio = convenio.idconvenio where idmedico='".$_GET["id"]."' AND ".$dataOpcao."   BETWEEN '".$start_date."' AND '".$end_date. "' order by classificacao, convenio, ".$dataOpcao.", paciente"; 


$result = mysqli_query($mysql_conn, $query);

$row = mysqli_fetch_assoc($result);
//mysqli_fetch_assoc($result);
//class PDF extends FPDF
$pdf=new PDF_MC_Table();

$pdf->AliasNbPages();
$pdf->AddPage("L");

{
// Page header{
    // Logo
    $pdf->Image('../../pics/logo.png',10,6,30);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(280,-5,'Data: '.date('d/m/y'),0,0,'R');
	$pdf->Ln(1);
    // Arial bold 15
    $pdf->SetFont('Arial','B',15);
    // Move to the right
   $pdf->Cell(70);
    // Title
	$pdf->Cell(120,10,utf8_decode('Detalhamento Produção Médica'),0,0,'C');

    // Line break
    $pdf->Ln(10);
	
		

$pdf->SetFont('arial','',10);
$pdf->Cell(0,5,''.utf8_decode("Médico: ").' '.utf8_decode($row["medico"]).'',0,1,'L');
$pdf->Cell(0,5,utf8_decode("Período:").' '.date_format(date_create($start_date), 'd/m/y').utf8_decode(' à ').date_format(date_create($end_date), 'd/m/y') ,0,1,'L');
$pdf->ln();
$pdf->SetFillColor(8,172,192);
			// Tabela Resumo dos plantões
			global $row1, $row6;
		//Consulta a tabela de plantões medicos de acordo com o PERIODO DO REPASSE REALIZADO
			$query1 = "SELECT c.idhospital, (SELECT hospital FROM hospital subh where subh.idhospital = c.idhospital) as hospital, p.dataRepassePlantao, DATE_FORMAT(p.dataRepassePlantao,'%b') as mes, DATE_FORMAT(p.dataRepassePlantao,'%Y-%m'), (sum(p.horasPlantao)/12) as totalHorasPlantao, sum(p.valorPlantaoBruto) as totalPlantaoBruto, sum(p.valorPlantaoLiquido) as totalPlantaoLiquido, 
			p.idplantao, p.dataInicio, p.dataFim, p.idmedico, p.idConfiguracaoPlantao, 
			p.idsubstituto, p.horasSubstituicaoPlantao, p.statusPagamento, c.idConfiguracaoPlantao,  p.valorSubstituicaoPlantaoBruto, p.valorSubstituicaoPlantaoLiquido,  m.idmedico, m.nome, (SELECT nome FROM medicos subm where subm.idmedico = p.idsubstituto) as substituto FROM  plantoes AS p, 
			configuracaoplantoes AS c, medicos AS m WHERE p.idmedico = m.idmedico and p.idConfiguracaoPlantao = c.idConfiguracaoPlantao and p.idmedico = '".$_GET["id"]."' and p.dataRepassePlantao BETWEEN '".$start_date."' AND '".$end_date. "' group by idhospital, DATE_FORMAT(p.dataRepassePlantao,'%Y-%m')";
			
			$result1 = mysqli_query($mysql_conn, $query1);
		
			//Consulta a tabela de plantões medicos feitos SUBSTITUICAO de acordo com o PERIODO DO REPASSE REALIZADO
			$query6 = "SELECT c.idhospital, (SELECT hospital FROM hospital subh where subh.idhospital = c.idhospital) as hospital, p.dataRepassePlantao, DATE_FORMAT(p.dataRepassePlantao,'%b') as mes, DATE_FORMAT(p.dataRepassePlantao,'%Y-%m'),
			(sum(p.horasSubstituicaoPlantao)/12) as totalHorasSubstituicaoPlantao, sum(p.valorSubstituicaoPlantaoBruto) as totalSubstituicaoPlantaoBruto, sum(p.valorSubstituicaoPlantaoLiquido) as totalSubstituicaoPlantaoLiquido, 
			p.idplantao, p.dataInicio, p.dataFim, p.idmedico, p.idConfiguracaoPlantao, 
			p.idsubstituto, p.horasSubstituicaoPlantao, p.statusPagamento, c.idConfiguracaoPlantao,  p.valorSubstituicaoPlantaoBruto, p.valorSubstituicaoPlantaoLiquido,  m.idmedico, m.nome, (SELECT nome FROM medicos subm where subm.idmedico = p.idsubstituto) as substituto FROM  plantoes AS p, 
			configuracaoplantoes AS c, medicos AS m WHERE p.idmedico = m.idmedico and p.idConfiguracaoPlantao = c.idConfiguracaoPlantao and p.idsubstituto = '".$_GET["id"]."' and p.dataRepassePlantao BETWEEN '".$start_date."' AND '".$end_date. "' group by idhospital, DATE_FORMAT(p.dataRepassePlantao,'%Y-%m')";
			
			$result6 = mysqli_query($mysql_conn, $query6);
		
				
			//TOTAL PLANTÕES
			$totalPlantoes = 0;

			$pdf->Cell(100,5,''.utf8_decode("RESUMO DOS PLANTÕES"),1,0,"C",true);
			$pdf->Cell(30,5,''.utf8_decode("MÊS"),1,0,"C",true); 
			$pdf->Cell(30,5,''.utf8_decode("QTD."),1,0,"C",true);
			$pdf->Cell(30,5,''.utf8_decode("R$ BRUTO"),1,0,"C",true);
			$pdf->Cell(30,5,''.utf8_decode("% IMP."),1,0,"C",true);
			$pdf->Cell(30,5,''.utf8_decode("R$ IMPOSTOS"),1,0,"C",true);
			$pdf->Cell(30,5,''.utf8_decode("R$ LÍQUIDO"),1,1,"C",true);
		
			setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
			date_default_timezone_set('America/Sao_Paulo');

		while ($row1 = mysqli_fetch_assoc($result1)) {
			$pdf->Cell(100,5,''.($row1["hospital"]).'    ',1,0,"C");
			$pdf->Cell(30,5,strftime('%B', strtotime($row1["mes"])),1,0,"C");
			$pdf->Cell(30,5, number_format($row1["totalHorasPlantao"],1,",","."),1,0,"C");
			$pdf->Cell(30,5, number_format($row1["totalPlantaoBruto"],2,",","."),1,0,"C");
			$pdf->Cell(30,5,''.utf8_decode(""),1,0,"L");
			
		
			$pdf->Cell(30,5,''.utf8_decode(""),1,0,"L");
			$pdf->Cell(30,5, number_format($row1["totalPlantaoLiquido"],2,",","."),1,1,"C");
			$totalPlantoes = $totalPlantoes + $row1["totalPlantaoBruto"];
		}
			
		
		while ($row6 = mysqli_fetch_assoc($result6)) {
			$pdf->Cell(100,5,''.($row6["hospital"]).' (*)',1,0,"C");
			$pdf->Cell(30,5,strftime('%B', strtotime($row6["mes"])),1,0,"C");
			$pdf->Cell(30,5, number_format($row6["totalHorasSubstituicaoPlantao"],1,",","."),1,0,"C");
			$pdf->Cell(30,5, number_format($row6["totalSubstituicaoPlantaoBruto"],2,",","."),1,0,"C");
			$pdf->Cell(30,5,''.utf8_decode(""),1,0,"L");
			$pdf->Cell(30,5,''.utf8_decode(""),1,0,"L");
			$pdf->Cell(30,5, number_format($row6["totalSubstituicaoPlantaoLiquido"],2,",","."),1,1,"C");

		}

			$pdf->Cell(160,10,''.utf8_decode("R$ TOTAL DOS PLANTÕES"),1,0,"L");
			$pdf->Cell(30,10,''.utf8_decode("R$  ").number_format($totalPlantoes,2,",","."),1,0,"C");
			$pdf->Cell(30,10,''.utf8_decode(" "),1,0,"L");
			$pdf->Cell(30,10,''.utf8_decode("R$  "),1,0,"L");
			$pdf->Cell(30,10,''.utf8_decode("R$  "),1,1,"L");

			
			
$query2 =  "SELECT producao.idconvenio, producao.medico,  sum(producao.valorProcedimento) , 
	sum(producao.valorRecebido) as total, convenio.pis, convenio.cofins, convenio.csll, convenio.irpj, convenio.iss, convenio.outros_encargos, convenio.classificacao, convenio.idconvenio FROM producao inner join convenio 
	on producao.idconvenio = convenio.idconvenio  where  producao.idmedico='".$_GET["id"]."' AND
	producao.".$dataOpcao."  BETWEEN '".$start_date."' AND '".$end_date. "' group by convenio.classificacao;"; 
			
$result2 = mysqli_query($mysql_conn, $query2);
$totalPlanoSaude = 0;
$totalSUS = 0;
$totalEletivas = 0;
$totalParticular = 0;
$totalImpostosPlanoSaude = 0;
$totalImpostosSUS = 0;
$totalImpostosEletivas = 0;
$totalImpostosParticular = 0;


 while ($row2 = mysqli_fetch_assoc($result2)) 
	{
		
		switch($row2["classificacao"]){
			case 'PLANO DE SAÚDE':
			$totalPlanoSaude =$row2["total"];
			$totalImpostosPlanoSaude = ($row2["pis"]+$row2["cofins"]+$row2["csll"]+$row2["irpj"]+$row2["iss"]+$row2["outros_encargos"]);
			break;
			
			case 'SUS':
			$totalSUS =$row2["total"];
			$totalImpostosSUS = ($row2["pis"]+$row2["cofins"]+$row2["csll"]+$row2["irpj"]+$row2["iss"]+$row2["outros_encargos"]);
			break;
		
			case 'ELETIVAS':
			$totalEletivas =$row2["total"];
			$totalImpostosEletivas = ($row2["pis"]+$row2["cofins"]+$row2["csll"]+$row2["irpj"]+$row2["iss"]+$row2["outros_encargos"]);
			break;
			
			case 'PARTICULAR':
			$totalParticular =$row2["total"];
			$totalImpostosParticular = ($row2["pis"]+$row2["cofins"]+$row2["csll"]+$row2["irpj"]+$row2["iss"]+$row2["outros_encargos"]);
			break;
		}	
}
	
	
 // RESUMO PLANOS 	
$pdf->cell(40,5,"",1,0,'C',false);
$pdf->SetFillColor(51,122,183);
$pdf->cell(60,5,utf8_decode("PLANO DE SAÚDE"),1,0,'C',true);

$pdf->SetFillColor(92,184,92);
$pdf->cell(60,5,"SUS",1,0,'C',true);

$pdf->SetFillColor(240,173,78);
$pdf->cell(60,5,"ELETIVAS",1,0,'C',true);

$pdf->SetFillColor(217,83,79);
$pdf->cell(60,5,"PARTICULAR",1,1,'C',true);

$pdf->cell(40,10,utf8_decode("BRUTO/ RECEBIDO NF"),"LTR",0,'C',false);
$pdf->cell(60,10,'R$ '.number_format($totalPlanoSaude,2,",",".").'',1,0,'C');
$pdf->cell(60,10,'R$ '.number_format($totalSUS,2,",",".").'',1,0,'C');
$pdf->cell(60,10,'R$ '.number_format($totalEletivas,2,",",".").'',1,0,'C');
$pdf->cell(60,10,'R$ '.number_format($totalParticular,2,",",".").'',1,1,'C');

$pdf->cell(40,5,utf8_decode("IMPOSTOS"),1,0,'C',false);	

$pdf->cell(30,5,number_format($totalImpostosPlanoSaude,2,",",".")."%".'',1,0,'C');		
$pdf->cell(30,5,'R$ '.number_format(($totalPlanoSaude*($totalImpostosPlanoSaude/100)),2,",",".").'',1,0,'C');		

$pdf->cell(30,5,number_format($totalImpostosSUS,2,",",".")."%".'',1,0,'C');	
$pdf->cell(30,5,'R$ '.number_format(($totalSUS*($totalImpostosSUS/100)),2,",",".").'',1,0,'C');	

$pdf->cell(30,5,number_format($totalImpostosEletivas,2,",",".")."%".'',1,0,'C');	
$pdf->cell(30,5,'R$ '.number_format(($totalEletivas*($totalImpostosEletivas/100)),2,",",".").'',1,0,'C');	

$pdf->cell(30,5,number_format($totalImpostosParticular,2,",",".")."%".'',1,0,'C');	
$pdf->cell(30,5,'R$ '.number_format(($totalParticular*($totalImpostosParticular/100)),2,",",".").'',1,1,'C');	

$pdf->cell(40,5,utf8_decode("LÍQUIDO"),1,0,'C',false);	
$pdf->cell(60,5,'R$ '.number_format($totalPlanoSaude-($totalPlanoSaude*($totalImpostosPlanoSaude/100)),2,",",".").'',1,0,'C');
$pdf->cell(60,5,'R$ '.number_format($totalSUS-($totalSUS*($totalImpostosSUS/100)),2,",",".").'',1,0,'C');		
$pdf->cell(60,5,'R$ '.number_format($totalEletivas-($totalEletivas*($totalImpostosEletivas/100)),2,",",".").'',1,0,'C');		
$pdf->cell(60,5,'R$ '.number_format($totalParticular-($totalParticular*($totalImpostosParticular/100)),2,",",".").'',1,1,'C');	

//RESUMO FINANCEIRO - TOTAL (PLANO SAUDE + SUS + ELETIVAS + PARTICULAR) 
$totalProducao = $totalPlanoSaude+$totalSUS+$totalEletivas+$totalPlantoes;

$pdf->SetFillColor(8,172,192);
$pdf->Cell(280,5,'RESUMO FINANCEIRO',1,1,'C',true);
		$pdf->Cell(25,10,'Taxa Adm.'.'',"LRB",0,"C");
		$pdf->Cell(25,5,'5 % '.'',"",0,"C" );
		$pdf->Cell(20,10,'ISS'.'',"LRB",0,"C");
		$pdf->Cell(25,5,'5 % '.'',"",0,"C");
		$pdf->Cell(20,10,'COFINS'.'',"LRB",0,"C");
		$pdf->Cell(25,5,' 3 % '.'',"",0,"C");
		$pdf->Cell(20,10,'PIS'.'',"LRB",0,"C");
		$pdf->Cell(25,5,' 0,65 % '.'',"",0,"C");
		$pdf->Cell(20,10,'CSLL'.'',"LRB",0,"C");
		$pdf->Cell(25,5,' 2,88 % '.'',"",0,"C");
		$pdf->Cell(20,10,'IRPJ'.'',"LRB",0,"C");
		$pdf->Cell(30,5,' 7,96 % '. '',"LRB",1,"C");
		
		$pdf->Cell(25,5,''.'',"LR",0,"L");
		$pdf->Cell(25,5,'R$ '.number_Format(($totalProducao*0.05),2,",",".").'',"TB",0,"C");
		$pdf->Cell(20,5,''.'',"LR",0,"L");
		$pdf->Cell(25,5,'R$ '.number_Format(($totalProducao*0.05),2,",",".").'',"TB",0,"C");
		$pdf->Cell(20,5,''.'',"LR",0,"L");
		$pdf->Cell(25,5,'R$ '.number_Format(($totalProducao*0.03),2,",",".").'',"TB",0,"C");
		$pdf->Cell(20,5,''.'',"LR",0,"L");
		$pdf->Cell(25,5,'R$ '.number_Format(($totalProducao*0.0065),2,",",".").'',"TB",0,"C");
		$pdf->Cell(20,5,''.'',"LR",0,"L");
		$pdf->Cell(25,5,'R$ '.number_Format(($totalProducao*0.0288),2,",",".").'',"TB",0,"C");	
		$pdf->Cell(20,5,''.'',"LR",0,"L");
		$pdf->Cell(30,5,'R$ '.number_Format(($totalProducao*0.0796),2,",",".").'',"BR",1,"C");
		
		$pdf->cell(50,10,'TOTAL BRUTO',1,0,'C');
		$pdf->cell(45,10,'R$ '.number_format($totalPlanoSaude+$totalSUS+$totalEletivas+$totalParticular,2,",",".").'',1,0,'C');
		$pdf->cell(49,10,utf8_decode('TOTAL IMPOSTOS').'',1,0,'C');
		$pdf->cell(42,10,'R$ '.number_format( ($totalPlanoSaude-($totalPlanoSaude*($totalImpostosPlanoSaude/100)))+($totalSUS-($totalSUS*($totalImpostosSUS/100)))+($totalEletivas-($totalEletivas*($totalImpostosEletivas/100))) + ($totalParticular-($totalParticular*($totalImpostosParticular/100))), 2,",",".").'',1,0,'C');
		$pdf->cell(50,10,utf8_decode('TOTAL LÍQUIDO').'',1,0,'C');
		$pdf->cell(44,10,'R$ '.number_format( ($totalPlanoSaude-($totalPlanoSaude*($totalImpostosPlanoSaude/100)))+($totalSUS-($totalSUS*($totalImpostosSUS/100)))+($totalEletivas-($totalEletivas*($totalImpostosEletivas/100))) + ($totalParticular-($totalParticular*($totalImpostosParticular/100))), 2,",",".").'',1,1,'C');







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

$pdf->SetWidths(array(18,18,80,20,80,20,24,20));
$result3 = mysqli_query($mysql_conn, $query);

$current_convenio = null;
global $row;

while ($row = mysqli_fetch_assoc($result3)) 
		{
			if ($row["idconvenio"] != $current_convenio) {
			if ($current_convenio != null ){
				$pdf->Cell(70,10,'Valor Total: R$ '. number_format($totalProcedimento,2,",",".").'',"L",0,"L");
				$pdf->Cell(70,10,'Valor Glosa: R$ '. number_format($totalGlosa,2,",",".").'',"",0,"L");
				$pdf->Cell(70,10,'Valor Bruto: R$ '. number_format($total,2,",",".").'',"",0,"L");
				$pdf->Cell(70,10,utf8_decode('Valor Líquido: R$ '). number_format($totalBruto-($totalBruto*$totalImpostos),2,",",".").'',"R",1,"L");
				
				$pdf->Cell(46,10,'PIS R$: '. number_format($totalBruto*$pis,2,",",".").'',"LB",0,"L");
				$pdf->Cell(46,10,'COFINS R$: '. number_format($totalBruto*$cofins,2,",",".").'',"B",0,"L");
				$pdf->Cell(46,10,'CSLL R$: '. number_format($totalBruto*$csll,2,",",".").'',"B",0,"L");
				$pdf->Cell(50,10,'IRPJ R$: '. number_format($totalBruto*$irpj,2,",",".").'',"B",0,"L");
				$pdf->Cell(46,10,'ISS R$: '. number_format($totalBruto*$iss,2,",",".").'',"B",0,"L");
				$pdf->Cell(46,10,'Tx./Encargos R$: '. number_format($totalBruto*$outros_encargos,2,",",".").'',"BR",1,"L");
			}
			$current_convenio = $row["idconvenio"];
			
			$total=0;
			$totalProcedimento = 0;
			$totalGlosa = 0;
			$totalBruto = 0;
			$totalValorLiquido = 0;
		
			
			$pdf->Ln(5);
			$pdf->SetFont('arial','B',9);
			$pdf->Cell(280,5,''.utf8_decode($row["convenio"]).'',1,1,"L");
			
			
			// Declaração dos percentuais dos impostos
			$pis = $row["pis"]/100;
			$cofins = $row["cofins"]/100;
			$csll = $row["csll"]/100;
			$irpj = $row["irpj"]/100;
			$iss = $row["iss"]/100;
			$outros_encargos = $row["outros_encargos"]/100;
			$totalImpostos = $pis+$cofins+$csll+$irpj+$iss+$outros_encargos;
			
		
			//cabeçalho da tabela 
			$pdf->SetFont('arial','',9);

			$pdf->Cell(18,10,''.utf8_decode("Data"),1,0,"L");
			$pdf->Cell(18,10,''.utf8_decode("No. NF"),1,0,"L");
			
			$pdf->Cell(80,10,''.utf8_decode("Paciente"),1,0,"L");
			$pdf->Cell(20,10,''.utf8_decode("Cód."),1,0,"L");

			$pdf->Cell(80,10,''.utf8_decode("Procedimento"),1,0,"L");
			$pdf->Cell(20,10,''.utf8_decode("Status"),1,0,"L");
			$pdf->Cell(24,10,''.utf8_decode("Data Repasse"),1,0,"L");
			$pdf->Cell(20,10,''.utf8_decode("Valor"),1,0,"L");
	
			//$pdf->Cell(15,10,'Valor',1,0,"L");
			
			$pdf->Ln(10);
			
			 $pdf->Row(array(date('d/m/Y', strtotime($row["dataRealizacao"])), utf8_decode($row["notaFiscal"]), utf8_decode($row["paciente"]), utf8_decode($row["codigoProcedimento"]), utf8_decode($row["descricaoProcedimento"]),  utf8_decode($row["statusPagamento"]), date('d/m/Y', strtotime($row["dataRepasse"])), number_format($row["valorRecebido"],2,",",".")));	
			 $totalProcedimento=$totalProcedimento+$row["valorProcedimento"];
			 $totalGlosa=$totalGlosa+$row["glosa"];
			 $totalBruto = $totalProcedimento-$totalGlosa;
			 $total=$total+$row["valorRecebido"];
		
			}
			else
			{	
				$pdf->SetFont('arial','',9);
				$pdf->Row(array(date('d/m/Y', strtotime($row["dataRealizacao"])),  utf8_decode($row["notaFiscal"]), utf8_decode($row["paciente"]), utf8_decode($row["codigoProcedimento"]), utf8_decode($row["descricaoProcedimento"]),   utf8_decode($row["statusPagamento"]), date('d/m/Y', strtotime($row["dataRepasse"])), number_format($row["valorRecebido"],2,",",".")));	
				$totalProcedimento=$totalProcedimento+$row["valorProcedimento"];
				$totalGlosa=$totalGlosa+$row["glosa"];
				$totalBruto = $totalProcedimento-$totalGlosa;
				$total=$total+$row["valorRecebido"];
				
				
				}
			}
			if ($current_convenio != null){
				$pdf->Cell(70,10,'Valor Total: R$ '. number_format($totalProcedimento,2,",",".").'',"L",0,"L");
				$pdf->Cell(70,10,'Valor Glosa: R$ '. number_format($totalGlosa,2,",",".").'',"",0,"L");
				$pdf->Cell(70,10,'Valor Bruto: R$ '. number_format($total,2,",",".").'',"",0,"L");
				$pdf->Cell(70,10,utf8_decode('Valor Líquido: R$ '). number_format($totalBruto-($totalBruto*$totalImpostos),2,",",".").'',"R",1,"L");
					
				$pdf->Cell(46,10,'PIS R$: '. number_format($totalBruto*$pis,2,",",".").'',"LB",0,"L");
				$pdf->Cell(46,10,'COFINS R$: '. number_format($totalBruto*$cofins,2,",",".").'',"B",0,"L");
				$pdf->Cell(46,10,'CSLL R$: '. number_format($totalBruto*$csll,2,",",".").'',"B",0,"L");
				$pdf->Cell(50,10,'IRPJ R$: '. number_format($totalBruto*$irpj,2,",",".").'',"B",0,"L");
				$pdf->Cell(46,10,'ISS R$: '. number_format($totalBruto*$iss,2,",",".").'',"B",0,"L");
				$pdf->Cell(46,10,'Tx./Encargos R$: '. number_format($totalBruto*$outros_encargos,2,",",".").'',"BR",1,"L");
			}
			
	$pdf->Output();
?>		
