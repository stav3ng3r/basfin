<?php
$pgsql_content = array();
$pgsql_content["hostname"]        = $tra['bdIp'];		// PGSQL hostname
$pgsql_content["user"]            = $tra['bdUsuario'];	// PGSQL username
$pgsql_content["password"]        = $tra['bdClave'];	// PGSQL password
$pgsql_content["db"]              = $tra['bd'];			// Nombre de la BD
$pgsql_content["table"]           = "";					// Nombre de la tabla inicial

/*
$pgsql_content["hostname"]        = "localhost";		// PGSQL hostname
$pgsql_content["user"]            = "root";	// PGSQL username
$pgsql_content["password"]        = "";	// PGSQL password
$pgsql_content["db"]              = $tra['bd'];			// Nombre de la BD
$pgsql_content["table"]           = "";					// Nombre de la tabla inicial
*/

require_once("postgres.inc.php");

$db = new db();
$db->connect();
$db->set_query("Set DateStyle TO 'SQL,European'");
$db->execute_query();
/*$db->set_query("SET CLIENT_ENCODING TO 'UTF-8'");
$db->execute_query();*/
/*
// GUARDAR PHP ID SESSION EN BASE DE DATOS
// START

// END

$db2 = new db();
$db2->connect();
$db2->set_query("Set DateStyle TO 'SQL,European'");
$db2->execute_query();
$db2->set_query("SET CLIENT_ENCODING TO 'UTF-8'");
$db2->execute_query();

$db3 = new db();
$db3->connect();
$db3->set_query("Set DateStyle TO 'SQL,European'");
$db3->execute_query();
$db3->set_query("SET CLIENT_ENCODING TO 'UTF-8'");
$db3->execute_query();

$db4 = new db();
$db4->connect();
$db4->set_query("Set DateStyle TO 'SQL,European'");
$db4->execute_query();
$db4->set_query("SET CLIENT_ENCODING TO 'UTF-8'");
$db4->execute_query();

$db5 = new db();
$db5->connect();
$db5->set_query("Set DateStyle TO 'SQL,European'");
$db5->execute_query();
$db5->set_query("SET CLIENT_ENCODING TO 'UTF-8'");
$db5->execute_query();*/