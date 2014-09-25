<?php
session_start();
header("Content-Type: text/html; charset=utf-8");

define('ROOT', realpath(__DIR__));


/** Autoload de dependencias de composer */
include(ROOT . '/librerias/vendor/autoload.php');

if (file_exists('fuentestra/config/config.php')) {

    $tra = include 'fuentestra/config/config.php';

    if (is_file('fuentestra/operaciones.php') == true) {
        include 'fuentestra/operaciones.php';
    } else {
        echo "No se encuentra el archivo  <b>fuentestra/peraciones.php</b>";
    }
} else {
    echo "Debe crear y declarar el archivo <b>/fuentestra/config/config.php</b>";
}