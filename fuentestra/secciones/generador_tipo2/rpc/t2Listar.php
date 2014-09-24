<?php
$c=-1;
//-- informacion de cabecera de lista
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='text*';			$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:left;';		//--x-
$c++;	$matriz[0][$c]['html']='integer';		$matriz[0][$c]['width']=80;		$matriz[0][$c]['style']='text-align:right;';	//--x-
$c++;	$matriz[0][$c]['html']='decimal';		$matriz[0][$c]['width']=80;		$matriz[0][$c]['style']='text-align:right;';	//--x-
$c++;	$matriz[0][$c]['html']='date';			$matriz[0][$c]['width']=80;		$matriz[0][$c]['style']='text-align:center;';	//--x-
$c++;	$matriz[0][$c]['html']='select_html';	$matriz[0][$c]['width']=80;		$matriz[0][$c]['style']='text-align:center;';	//--x-
$c++;	$matriz[0][$c]['html']='textarea';		$matriz[0][$c]['width']=0;		$matriz[0][$c]['style']='text-align:left;';		//--x-
$c++;	$matriz[0][$c]['html']='radio';			$matriz[0][$c]['width']=80;		$matriz[0][$c]['style']='text-align:center;';	//--x-
//--e->cabecerasLista
$c++;	$matriz[0][$c]['html']=infoAuditoria('otros.generador_abm',null,'delete');			$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';

$whereFiltro=generarWhereFiltroCadenaBuscar("
	sp_ascii(text) ilike sp_ascii('%{text}%')	--x-
	--e->filtrosCadenaBuscar
");

$sql="
	select
		* --x-
		--e->camposListaTablaT1
	from
		otros.generador_abm
	where
		1=1
		$whereFiltro
	order by
		id_generador_abm desc
";
$sql=filtrarQueryLista($sql);
$db->set_query($sql);
$db->execute_query();
$c=0;
while($row=$db->get_array()){
	
	//-- informacion de registros de lista
	$c++;
	$matriz[$c][]['html']=seleccionarDeLista($row['id_generador_abm'],$row['text']);
	$matriz[$c][]['html']='<div style="width:16px;height:16px;"><a href="javascript:cargarSeccion(\'generador_tipo2\',\'vista\',\'idT2='.$row['id_generador_abm'].'\');" title="ver todos los datos detallados"><img src="fuentestra/imagenes/bot/16x16/search.png" /></a></div>';
	$matriz[$c][]['html']=$row['text'];	//--x-
	$matriz[$c][]['html']=number_format($row['numero'],0,',','.');	//--x-
	$matriz[$c][]['html']=number_format($row['decimales'],2,',','.');	//--x-
	$matriz[$c][]['html']=substr($row['date'],0,10); //--x-
	$matriz[$c][]['html']=$row['select_html']; //--x-
	$matriz[$c][]['html']=$row['textarea'];	//--x-
	$matriz[$c][]['html']=$row['radio'];	//--x-
	//--e->filasLista
	$matriz[$c][]['html']=infoAuditoria('otros.generador_abm',$row['rowid']);
	$matriz[$c]['estado']=$row['estado'];
	
	if($row['confirmado']=='f'){$matriz[$c]['style']='background-color:#FDFFD2;';}
}
$resp['html']=armarLista($matriz);
?>