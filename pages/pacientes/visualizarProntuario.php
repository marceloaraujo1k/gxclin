<?php
include '../opendb.php';
include_once('../func.php');

if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
	
	$query = mysqli_query($mysql_conn, "SELECT arquivo FROM prontuarios WHERE idprontuario='$id'");
	$row = mysqli_fetch_assoc($query);
	$arquivo = $row['arquivo'];


	$extensao = strtolower(substr(strrchr($arquivo,"."),1));

	if($extensao  == "jpg"){
		header('Content-type: image/jpeg');
		header('Content-Disposition: inline; filename="'.$arquivo.'"');
		header('Content-Transfer-Encoding; binary');
		header('Accept-Ranges; bytes');
		readfile($arquivo);
	} else if($extensao  == "png"){
		header('Content-type: image/png');
		header('Content-Disposition: inline; filename="'.$arquivo.'"');
		header('Content-Transfer-Encoding; binary');
		header('Accept-Ranges; bytes');
		readfile($arquivo);
	}else{
		header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="'.$arquivo.'"');
    header('Content-Transfer-Encoding; binary');
    header('Accept-Ranges; bytes');
    readfile($arquivo);
	}

	
	
}	

?>
