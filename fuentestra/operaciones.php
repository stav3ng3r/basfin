<?php
$guardarEnDebugOperaciones = 0;

include('funciones/php/generales.php');

$nuevoSistema = recibir_dato('nuevoSistema');

$sql = "SELECT titulo, palabras_claves, descripcion, dominio, exigir_login FROM sistemas WHERE alias = '{$tra['sistema']['alias']}'";

$db->set_query($sql);
$db->execute_query();

if ($row = $db->get_array()) {
    $tra['sistema']['id_sistema'] = '';
    $tra['sistema']['titulo'] = $row['titulo'];
    $tra['sistema']['palabras clave'] = $row['palabras_claves'];
    $tra['sistema']['descripcion'] = $row['descripcion'];
    $tra['sistema']['dominio'] = $row['dominio'];
    $tra['sistema']['exigir_login'] = $row['exigir_login'];
    $tra['sistema']['id_usuario'] = $_SESSION['idUsuario_' . $tra['sistema']['alias']];
} else {
    switch ($nuevoSistema) {
        case 'procesoInsert':
            $datosNuevoSistema = array();
            $datosNuevoUsuario = array();

            $datosNuevoSistema['titulo'] = recibir_dato('titulo', 'post');
            $datosNuevoSistema['descripcion'] = recibir_dato('descripcion', 'post');
            $datosNuevoSistema['palabras_clave'] = recibir_dato('palabrasClave', 'post');

            $datosNuevoUsuario['usuario'] = recibir_dato('usuario', 'post');
            $datosNuevoUsuario['nombre'] = recibir_dato('nombre', 'post');
            $datosNuevoUsuario['clave'] = recibir_dato('clave', 'post');
            $datosNuevoUsuario['correo'] = recibir_dato('correo', 'post');

            registrarSistema($datosNuevoSistema);
            registrarUsuario($datosNuevoUsuario);
            break;

        default:
            include 'nuevosistema.php';
            break;
    }
}


$tra['operacion']=recibir_dato('o');
if(isset($_REQUEST['folder'])==true){$tra['operacion']='secciones';}

$resp['esq']='ok';
$resp['mensaje']='';

d($tra);

/*
if($tra['operacion']!=''){
    if($tra['operacion']=='ima'){
        include('imagen.php');
    }else if(substr($tra['operacion'],0,10)=='imaarchivo'){
        $cadenaImagen=substr($tra['operacion'],3);
        include('imagen.php');
    }else if(substr($tra['operacion'],0,13)=='enlacedirecto'){
        list($operacion,$seccion,$id)=explode(',',$tra['operacion']);
        $accionRPC='compartir';
        $resp['html']=leer_codigo_de_archivo('fuentestra/esquema-enlace-directo.html');
        if(is_file('fuentestra/secciones/'.$seccion.'/enlace_directo.php')==true){
            include 'fuentestra/secciones/'.$seccion.'/enlace_directo.php';
        }
        $resp['html']=str_replace('{title}',$resp['title'],$resp['html']);
        $resp['html']=str_replace('{palabras clave}',$resp['palabras clave'],$resp['html']);
        $resp['html']=str_replace('{descripcion}',$resp['descripcion'],$resp['html']);
        $resp['html']=str_replace('{imagen}',$resp['imagen'],$resp['html']);
        $resp['html']=str_replace('{info}',$resp['info'],$resp['html']);
        $resp['html']=str_replace('{accionJavaScript}',$resp['accionJavaScript'],$resp['html']);
        $resp['html']=str_replace('{parametrosEnlaceDirecto}',$resp['parametrosEnlaceDirecto'],$resp['html']);
        echo($resp['html']);
    }else if($tra['operacion']=='pdf'){
        include('pdf.php');
    }else if($tra['operacion']=='debug'){
        include('debug.php');
    }else{
        include($tra['operacion'].'/'.$tra['operacion'].'.php');
    }
}else{
    tra();
}*/