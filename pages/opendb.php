<?php
$hostname = 'localhost';
$username = 'root';
$password = '';

// conection with controle_producao database
$mysql_conn	= mysqli_connect($hostname, $username, $password, 'gxfisio');

if($mysql_conn == FALSE)
{
	echo("Unable to establish connection with the mysql server");
	exit;
}
	
?>