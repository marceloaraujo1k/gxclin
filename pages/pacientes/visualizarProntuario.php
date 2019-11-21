<?php
include '../opendb.php';
include_once('../func.php');

if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
	
	$query = mysqli_query($mysql_conn, "SELECT arquivo FROM prontuarios WHERE idprontuario='$id'");
	$row = mysqli_fetch_assoc($query);
	$arquivo = $row['arquivo'];

		
	header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="'.$arquivo.'"');
    header('Content-Transfer-Encoding; binary');
    header('Accept-Ranges; bytes');
    readfile( $arquivo);
}	

?>
