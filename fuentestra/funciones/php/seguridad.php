<?php

function recibir_dato($variable, $metodo = 'request', $por_defecto = '')
{
    d($variable, $metodo, $por_defecto, $_REQUEST);

    $valor = $por_defecto;

    if (($metodo == "post") || ($metodo == "_post")) {
        if (isset($_POST[$variable]) == true) {
            $valor = $_POST[$variable];
        }
    }
    if (($metodo == "get") || ($metodo == "_get")) {
        if (isset($_GET[$variable]) == true) {
            $valor = $_GET[$variable];
        }
    }
    if (($metodo == "request") || ($metodo == "_request")) {
        if (isset($_REQUEST[$variable]) == true) {
            $valor = $_REQUEST[$variable];
        }
    }

    $valor = utf8_decode($valor);
    $valor = str_replace('746t985otroParametro746t985', '&', $valor);
    $valor = str_replace('|signomas|', '+', $valor);

    $valor = trim($valor);

    if ($variable != 'onLoad' && $variable != 'accionLogin' && $variable != 'query' && $variable != 'subtitulo' && $variable != 'condicion') {
        $valor = pg_escape_string($valor);
    }

    return $valor;
}

function recibir_numero($variable, $metodo = "request", $por_defecto = "")
{
    $valor = recibir_dato($variable, $metodo, $por_defecto);
    $valor = str_replace('.', '', $valor);
    return $valor;
}

function verifSqlInjection($cadena)
{

    // header('Location: index.php?s=login&cerrar=si');
}

function obtener_direccion_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function poseePermiso($sentencia, $tipo = 'and')
{
    global $tra, $db5;

    if ($sentencia == '') {
        return true;
    }

    $vPermisos = explode(',', $sentencia);
    $cTrue = 0;
    $cPermisos = 0;
    for ($i = 0; isset($vPermisos[$i]) == true; $i++) {
        $sql = "SELECT * FROM usuario_permisos WHERE id_usuario=" . $tra['id_usuario'] . " AND permiso='" . $vPermisos[$i] . "'";
        $db5->set_query($sql);
        $db5->execute_query();
        if ($row = $db5->get_array()) {
            $cTrue++;
        }
        $cPermisos++;
    }
    if ($tipo == 'and') {
        if ($cTrue == $cPermisos) {
            return true;
        } else {
            return false;
        }
    } else if ($tipo == 'or') {
        if ($cTrue >= 1) {
            return true;
        } else {
            return false;
        }
    }
    return false;
}

function registrarSistema($datos)
{
    global $db, $tra;

    d($datos);
    if (!empty($datos)) {

        $tra['sistema']['titulo'] = $datos['titulo'];
        $tra['sistema']['descripcion'] = $datos['descripcion'];
        $tra['sistema']['palabras_clave'] = $datos['palabras_clave'];

        $sql = "SELECT id_sistema id FROM sistemas ORDER BY id_sistema DESC LIMIT 1";
        $db->set_query($sql);
        $db->execute_query();

        if ($row = $db->get_array()) {
            $tra['sistema']['id'] = $row['id'] + 1;
        } else {
            $tra['sistema']['id'] = 1;
        }

        $sql = "
                INSERT INTO sistemas (
                    id_sistema, alias, titulo, palabras_claves, descripcion
                ) VALUES (
                    {$tra['sistema']['id']},
                    '{$tra['sistema']['alias']}',
                    '" . utf8_encode($tra['sistema']['titulo']) . "',
                    '" . utf8_encode($tra['sistema']['palabras_clave']) . "',
                    '" . utf8_encode($tra['sistema']['descripcion']) . "'
                )
            ";
        $db->set_query($sql);
        $db->execute_query();

    }
}

function registrarUsuario($datos)
{
    global $db, $tra;
    if (!empty($datos)) {

        $tra['usuario']['usuario'] = $datos['usuario'];
        $tra['usuario']['nombre'] = $datos['nombre'];
        $tra['usuario']['clave'] = $datos['clave'];
        $tra['usuario']['correo'] = $datos['correo'];

        $sql = "
                insert into usuarios (
                    id_sistema,
                    id_usuario,
                    usuario,
                    nombre,
                    clave,
                    correo,
                    id_usuario_creo,
                    fecha_usuario_creo,
                    id_usuario_modif,
                    fecha_usuario_modif
                ) values (
                    {$tra['sistema']['id']},
                    1,
                    '{$tra['usuario']['usuario']}',
                    '" . utf8_encode($tra['usuario']['nombre']) . "',
                    '" . md5('&%.$#@' . $tra['usuario']['clave'] . '.:@%@-') . "',
                    '{$tra['usuario']['correo']}',
                    1,
                    now(),
                    1,
                    now()
                )
            ";
        $db->set_query($sql);
        $db->execute_query();
    }
}