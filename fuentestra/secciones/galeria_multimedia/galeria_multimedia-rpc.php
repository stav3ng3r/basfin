<?
	if($accionRPC=='listar'){
		for($i=1;$i<=10;$i++){
			$resp['html'].=leerHtmlEnSeccion('lista').chr(13);
			$resp['html']=str_replace('{nombre}','rober '.$i,$resp['html']);
		}
	}
?>