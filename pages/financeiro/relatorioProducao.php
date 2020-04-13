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


$query =  "SELECT a.statusPagamento, a.descricao,a.idconsultas,a.idprofissional, a.dataVecto, a.valor, a.valorRecebido, b.empresa, c.profissional, c.tipoRepasse, c.valorRepasse 
FROM financeiro AS a 
INNER JOIN empresa AS b ON a.idempresa = b.idempresa INNER JOIN profissionais AS c on a.idprofissional = c.idprofissional
 where dataVecto BETWEEN '".$start_date."' AND '".$end_date. "' order by profissional, dataVecto"; 
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
	$pdf->Cell(50,10,utf8_decode('Relatório Produção'),0,0,'C');

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

$pdf->SetWidths(array(30,50,22,32,32,32));
$result1 = mysqli_query($mysql_conn, $query);


//global $row;

$profissional = null;
$nome_anterior = "";
$indice = 1;
$total = mysqli_num_rows($result1);

$total_procedimento = 0;

$valor_repasse = 0;

$total_recebido = 0;


while($row = mysqli_fetch_assoc($result1)){
	
	if(isset($row['idconsultas']) && !empty($row['idconsultas'])){

			if($nome_anterior != $row['profissional']){
				
				if($indice > 1){
					
					
					$pdf->Cell(65,10,'Total Procedimento: '. number_format($total_procedimento,2,",",".").'',"LB",0,"LB");
					$pdf->Cell(64,10,'Total Repasse: '. number_format($valor_repasse,2,",",".").'',"B",0,"LB");

					$pdf->Cell(69,10,'Total Recebido: '. number_format($total_recebido,2,",",".").'',"BR",1,"LB");
				  }

				$pdf->Ln(5);
				$pdf->SetFont('arial','B',9);
				$pdf->Cell(198,10,''.utf8_decode($row['profissional']).'',1,1,"L"); // Colocar um título
				
			  
				//cabeçalho da tabela 
				$pdf->SetFont('arial','',9);
				$pdf->Cell(30,10,''.utf8_decode("Filial"),1,0,"L");
				//$pdf->Cell(60,10,''.utf8_decode("Profissional"),1,0,"L");
				
				$pdf->Cell(50,10,''.utf8_decode("Procedimento"),1,0,"L");
				
				$pdf->Cell(22,10,''.utf8_decode("Data"),1,0,"L");
				
				$pdf->Cell(32,10,''.utf8_decode("Valor Procedimento"),1,0,"L");
		  
				$pdf->Cell(32,10,''.utf8_decode("Valor Repasse"),1,0,"L");
				
				$pdf->Cell(32,10,''.utf8_decode("Valor Recebido"),1,0,"L");
						
				$pdf->Ln(10);

				//$pdf->Cell(65,10,'Total Procedimento:',"LB",0,"LB");
				//$pdf->Cell(64,10,'Total Repasse:',"B",0,"LB");

				//$pdf->Cell(69,10,'Total Recebido: ',"BR",1,"LB");
				$total_procedimento = 0;
				$valor_repasse = 0;
				$total_recebido = 0;
				
			  }   
			  if($row['tipoRepasse'] == "percentual"){

				$percentual = $row["valorRepasse"];
				$valorProcedimento = $row['valor'];
				$conta = $percentual*$valorProcedimento/100 ;
				
				$pdf->Row(array(
					utf8_decode($row["empresa"]), 
					
					utf8_decode($row["descricao"]), 
					
					date('d/m/Y', strtotime($row["dataVecto"])), 
					
					number_format($row['valor'],2,",","."),
	
					number_format($conta,2,",","."),
			   
					number_format($row['valorRecebido'],2,",","."),
	
					 //number_format(0.00,2,",","."),
					 //number_format(1.00,2,",","."),
					 //number_format(2.00,2,",","."),
				   )); 
				
			}else{
				$pdf->Row(array(
					utf8_decode($row["empresa"]), 
					
					utf8_decode($row["descricao"]), 
					
					date('d/m/Y', strtotime($row["dataVecto"])), 
					
					number_format($row['valor'],2,",","."),
	
					number_format($row['valorRepasse'],2,",","."),
			   
					number_format($row['valorRecebido'],2,",","."),
	
					 //number_format(0.00,2,",","."),
					 //number_format(1.00,2,",","."),
					 //number_format(2.00,2,",","."),
				   )); 
			}
			 	  
			   
			   $nome_anterior = $row['profissional'];

			   /*if ($profissional == $row['profissional'] ){
				   
				$percentual = $row["valorRepasse"];
				$valorProcedimento = $valorProcedimento + $row['valor'];

				$pdf->Cell(65,10,'Total Procedimento: '. number_format($valorProcedimento,2,",",".").'',"LB",0,"LB");
				$pdf->Cell(64,10,'Total Repasse: '. number_format(0.00,2,",",".").'',"B",0,"LB");

				$pdf->Cell(69,10,'Total Recebido: '. number_format(0.00,2,",",".").'',"BR",1,"LB");
				
			}*/
			
			//$valorProcedimento = 0;

			//$profissional = $row["profissional"];

			$total_procedimento += $row['valor'];

			if($row['tipoRepasse'] == "percentual"){
				$percentual = $row["valorRepasse"];
				$valorProcedimento = $row['valor'];
				$conta = $percentual*$valorProcedimento/100 ;

				$valor_repasse += $conta;
			}else{
				$valor_repasse += $row['valorRepasse'];
			}
			


			$total_recebido += $row['valorRecebido'];
			
			if($indice == $total){
				
				
				$pdf->Cell(65,10,'Total Procedimento: '. number_format($total_procedimento,2,",",".").'',"LB",0,"LB");
				$pdf->Cell(64,10,'Total Repasse: '. number_format($valor_repasse,2,",",".").'',"B",0,"LB");

				$pdf->Cell(69,10,'Total Recebido: '. number_format($total_recebido,2,",",".").'',"BR",1,"LB");
			  }
			
		
			

			  
				
		/*		
			if($row['tipoRepasse'] == "percentual"){

				$percentual = $row["valorRepasse"];
				$valorProcedimento = $row['valor'];
				$conta = $percentual*$valorProcedimento/100 ;

				$saldo = $valorProcedimento - $conta;

				

				
			}else{

				$valorFixo = $row["valorRepasse"];
				$valorProcedimento = $row['valor'];
				$saldo = $valorProcedimento - $valorFixo;
				
				$pdf->Cell(65,10,'Total Procedimento: '. number_format($row['valor'],2,",",".").'',"LB",0,"LB");
				$pdf->Cell(64,10,'Total Repasse: '. number_format($valorFixo,2,",",".").'',"B",0,"LB");
				$pdf->Cell(69,10,'Total Recebido: '. number_format($row['valorRecebido'],2,",",".").'',"BR",1,"LB");
				
			}
			*/
			
			
			
			
		}	
		
		
		$indice++;
		
			}	

			 
			
			
	
					
	$pdf->Output();

 


  
    
    

?>		
