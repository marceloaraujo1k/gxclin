<?php
include '../opendb.php';
include_once('../func.php');

$form = $_POST;

/*id: 21187
dataRealizacao: 03/01/2020
valorRecebido: 500
glosa: -231.81
dataPagamento: 03/01/2020
dataRepasse: 03/01/2020
dataCobranca: 03/01/2020
statusPagamento: Pago
notaFiscal: NF0001 */


if(!empty($form["id"])) {
print_r($form);
$query	= "UPDATE producao SET dataCobranca=STR_TO_DATE('$form[dataCobranca]', '%d/%m/%Y'), 
			dataRepasse=STR_TO_DATE('$form[dataRepasse]', '%d/%m/%Y'),
 			dataPagamento=STR_TO_DATE('$form[dataPagamento]', '%d/%m/%Y'),
		   	notaFiscal='$form[notaFiscal]',
			valorRecebido = '$form[valorRecebido]',
			glosa = '$form[glosa]', 
			statusPagamento = '$form[statusPagamento]' WHERE idproducao='$form[id]'";	
	mysqli_query($mysql_conn,$query);
	header('location: producao.php' ); 
}

?>	

