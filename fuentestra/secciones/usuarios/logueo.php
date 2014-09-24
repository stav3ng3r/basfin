<?
$resp['html']=str_replace('{ventana}',recibir_dato('ventana','request','si'),$resp['html']);
$resp['html']=str_replace('{accionLogin}',str_replace(chr(92)."'","'",recibir_dato('accionLogin')),$resp['html']);
?>