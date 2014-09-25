<?php

/** Autoload de dependencias de composer */
include(ROOT . '/librerias/vendor/autoload.php');

$whoops = new \Whoops\Run;
$whoopsHandler = new \Whoops\Handler\PrettyPageHandler;


$whoops->pushHandler($whoopsHandler);
$whoops->register();

include 'conexion.php';
include 'seguridad.php';
include 'cadena.php';
include 'fecha.php';
include 'numericas.php';
include 'fpdf.php';
include 'PHPMailer_v5.1/class.phpmailer.php';
include 'tra.php';
include 'notificaciones.php';

include 'jpgraph/jpgraph.php';
include 'jpgraph/jpgraph_line.php';
include 'jpgraph/jpgraph_pie.php';
include 'jpgraph/jpgraph_pie3d.php';
include 'jpgraph/jpgraph_bar.php';



d('ok');