<?php

header('Content-Type: text/html; charset=utf-8');
$hostname = 'localhost';
$username = 'u594454074_cam';
$password = 'mfa300447';

// conection with controle_producao database
$mysql_conn	= mysqli_connect($hostname, $username, $password, 'u594454074_cam');

if($mysql_conn == FALSE)
{
	echo("Unable to establish connection with the mysql server");
	exit;
}

?>