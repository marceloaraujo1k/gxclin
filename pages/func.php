<?php

/*
 * Get the rows of a table
 */

  
 function getItensTable($mysql_conn,$tableName)
{
	$table=null;
	$result	= mysqli_query($mysql_conn,"select * from $tableName");

	for($i=0; $i<mysqli_num_rows($result); $i++)
	{
		$table[$i] = mysqli_fetch_array($result);
	}
	return $table;
}

function getItemFromTable($tableName, $itenId)
{
	$result = mysqli_query("select * from ".$tableName." where id=".$itenId);
	$item	= mysqli_fetch_array($result);
	
	return $item;
}

// specific function for this system: controle-de-backup
function getProjectId($projectName, $db_switchboard)
{
	$result = mysqli_query("select id from projects where name='$projectName'", $db_switchboard);
	$itens	= mysql_fetch_array($result);
	
	return $itens['id'];
}

// specific function for this system: controle-de-backup
function getLinesFromProject($projectId, $db_switchboard)
{
	$result = mysqli_query("select * from flamoil_switchboard.lines where project=".$projectId, $db_switchboard);
	
	for($i=0; $i<mysql_num_rows($result); $i++)
	{
		$itens[$i] = mysql_fetch_array($result);
	}

	return $itens;
}
