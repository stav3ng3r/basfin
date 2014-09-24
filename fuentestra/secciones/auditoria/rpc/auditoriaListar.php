<?php
$tabla = recibir_dato('tabla');
$rowid = recibir_dato('rowid');
$accion = recibir_dato('accion');

list($esquema, $tabla) = explode('.',$tabla);

$c=-1;
//-- informacion de cabecera de lista
$c++;	$matriz[0][$c]['html']='Acción*';	 		$matriz[0][$c]['width']=200;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Detalles*';	 		$matriz[0][$c]['width']='*';	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='Usuario*';			$matriz[0][$c]['width']=100;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='IP*';	 			$matriz[0][$c]['width']=100;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Acción*';	 			$matriz[0][$c]['width']=100;	$matriz[0][$c]['style']='text-align:center;';

$whereFiltro=generarWhereFiltroCadenaBuscar("
	sp_ascii(accion) ilike sp_ascii('%{text}%') or
	sp_ascii(esquema) ilike sp_ascii('%{text}%') or
	sp_ascii(tabla) ilike sp_ascii('%{text}%') or
	text(id_usuario)='{text}' or
	sp_ascii(ip) ilike sp_ascii('%{text}%') or
	text(id_sesion_pgsql)='{text}' or
	sp_ascii(array_to_string(array(select split_part(unnest, '=>', 1)||': '||split_part(unnest, '=>', 2) from (select unnest(campos_old)) t1),'<br />')) ilike sp_ascii('%{text}%') or
	sp_ascii(array_to_string(array(select split_part(unnest, '=>', 1)||': '||split_part(unnest, '=>', 2) from (select unnest(campos_new)) t1),'<br />')) ilike sp_ascii('%{text}%')
");


if(!empty($rowid)){
	$whereFiltro.=" and rowid=$rowid ";
}

if(!empty($accion)){
	$whereFiltro.=" and lower(accion)='$accion' ";
}

$sql="
	select
		date(tiempo_finalizacion) as fecha,
		esquema,
		tabla,
		ip,
		rowid,
		u.usuario,
		case substring(a.accion,1,1) when 'I' then 'Agregado' when 'U' then 'Modificado' when 'D' then 'Eliminado' end as accion,
		array_to_string(array(select split_part(unnest, '=>', 1)||': '||split_part(unnest, '=>', 2) from (select unnest(campos_old)) t1),'<br />') campos_old,
		array_to_string(array(select split_part(unnest, '=>', 1)||': '||split_part(unnest, '=>', 2) from (select unnest(campos_new)) t2),'<br />') campos_new
	from
		auditoria a
		left join usuarios u using (id_usuario)
	where
		esquema='$esquema' and
		tabla='$tabla'
		$whereFiltro
	order by
		tiempo_finalizacion desc
";
$sql=filtrarQueryLista($sql);
$db->set_query($sql);
$db->execute_query();
$c=0;
while($row=$db->get_array()){
	
	//-- informacion de registros de lista
	$campos = $accion=='delete'?$row['campos_old']:$row['campos_new'];
	
	$c++;
	$matriz[$c][]['html']=$row['accion'] .' ('.$row['fecha'].')';
	$matriz[$c][]['html']=$campos;
	$matriz[$c][]['html']=$row['usuario'];
	$matriz[$c][]['html']=$row['ip'];
	$matriz[$c][]['html']='<a href="javascript:cargarSeccion(\'sistema\',\'categorias_lista\',\'\',\'ventana\');">Abrir</a>';
}
$resp['html']=armarLista($matriz);
?>