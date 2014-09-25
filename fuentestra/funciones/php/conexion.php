<?php
require_once("postgres.inc.php");

global $tra;

$pgsql_content = array();
$pgsql_content["hostname"]        = $tra['bdIp'];		// PGSQL hostname
$pgsql_content["user"]            = $tra['bdUsuario'];	// PGSQL username
$pgsql_content["password"]        = $tra['bdClave'];	// PGSQL password
$pgsql_content["db"]              = $tra['bd'];			// Nombre de la BD
$pgsql_content["table"]           = "";					// Nombre de la tabla inicial


$db = new db();
$db->connect();

$db2 = new db();
$db2->connect();

$db3 = new db();
$db3->connect();

$db4 = new db();
$db4->connect();

$db5 = new db();
$db5->connect();