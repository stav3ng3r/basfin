<?php
session_start();
header("Content-Type: text/html; charset=utf-8");

if (file_exists('kint/Kint.php') == true) {
    include 'kint/Kint.php';
}


define('ROOT', realpath(__DIR__));

$cadenaTraIni = '';

if (file_exists('tra.ini') == true) {
    $DescriptorFichero = fopen('tra.ini', 'r');

    while (!(feof($DescriptorFichero))) {
        $buffer = fgets($DescriptorFichero, 4096);
        $cadenaTraIni .= $buffer;
    }

    $tra = array();
    $tra['alias'] = '';
    $tra['bd'] = '';
    $tra['bdUsuario'] = '';
    $tra['bdClave'] = '';
    $tra['bdIp'] = '';

    list($tra['alias'], $tra['bd'], $tra['bdUsuario'], $tra['bdClave'], $tra['bdIp']) = explode(',', $cadenaTraIni);

    if (is_file('fuentestra/operaciones.php') == true) {
        include 'fuentestra/operaciones.php';
    } else {
        echo("Debes insertar la carpeta <b>fuentestra</b><br>windows: MKLINK /J destino origen (ejemplo.: MKLINK /J fuentestra origen/fuentestra)<br>linux: ln -s origen destino (ejemplo.: ln -s /var/www/web1/web/fuentestra /var/www/www.dominio.com.py/web/fuentestra)");
    }
} else {
    echo("Debe crear y declarar el archivo <b>tra.ini</b> y especificar en el el alias del sistema<br>alias,bd,bdUsuario,bdClave,bdIp");
}