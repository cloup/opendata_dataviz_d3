<?php

$dbHost = 'filemails.com';
$dbUser = 'hirsch_od';
$dbPass = 'razaflehaut';
$dbName = 'hirsch_opendata';

define("LOG_ENABLED", false);

// database functions
$dbConn = mysql_connect ($dbHost, $dbUser, $dbPass) or die ('MySQL connect failed. ' . mysql_error());
mysql_select_db($dbName) or die('Cannot select database. ' . mysql_error());
function dbQuery($sql){
	$result = mysql_query($sql) or die(mysql_error());
	
	return $result;
}
function dbAffectedRows()
{
	global $dbConn;
	
	return mysql_affected_rows($dbConn);
}

function dbFetchArray($result, $resultType = MYSQL_NUM) {
	return mysql_fetch_array($result, $resultType);
}

function dbFetchAssoc($result)
{
	return mysql_fetch_assoc($result);
}

function dbFetchRow($result) 
{
	return mysql_fetch_row($result);
}

function dbNumRows($result)
{
	return mysql_num_rows($result);
}

function dbSelect($dbName)
{
	return mysql_select_db($dbName);
}

function dbInsertId()
{
	return mysql_insert_id();
}
mysql_query("SET NAMES 'utf8'");
?>
