<?php
$c=-1;
//-- informacion de cabecera de lista
$c++;	$matriz[0][$c]['html']='&nbsp;';			$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='&nbsp;';			$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='rubrRubros';
$c++;	$matriz[0][$c]['html']='&nbsp;';			$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='rubrRubros';
$c++;	$matriz[0][$c]['html']='Rubro*';	 		$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Categoría*';	 	$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Descripción*';	 	$matriz[0][$c]['width']='*';	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']=infoAuditoria('sistema.rubros',null,'delete');;		$matriz[0][$c]['width']=16;							$matriz[0][$c]['style']='text-align:center;';

$whereFiltro=generarWhereFiltroCadenaBuscar("
	text(rc.rubro_categoria)='{text}' or
	text(p.proyecto)='{text}' or
	sp_ascii(r.rubro) ilike sp_ascii('%{text}%') or
	sp_ascii(r.descripcion) ilike sp_ascii('%{text}%')
");

$sql="
	select
		r.rowid,
		r.id_rubro,
		rc.rubro_categoria,
		p.proyecto,
		r.rubro,
		r.descripcion
	from
		sistema.rubros r
		left join sistema.rubros_categorias rc using (id_rubro_categoria)
		left join sistema.proyectos p on (r.id_proyecto=p.id_proyecto)
	where
		1=1
		$whereFiltro
	order by
		r.id_rubro desc
";
$sql=filtrarQueryLista($sql);
$db->set_query($sql);
$db->execute_query();
$c=0;
while($row=$db->get_array()){
	
	//-- informacion de registros de lista
	$c++;
	$matriz[$c][]['html']=seleccionarDeLista($row['id_rubro'],$row['rubro']);
	$matriz[$c][]['html']='<a href="javascript:cargarSeccion(\'rubros\',\'rubro_ae\',\'idRubro='.$row['id_rubro'].'\',\'ventana\');" title="editar"><i class="glyphicon glyphicon-edit"></i></a>';
	$matriz[$c][]['html']='<a href="javascript:dialogo(\'Confirma que desea eliminar este registro\',\'si:eliminarRubro('.$row['id_rubro'].');|no\',\'eliminar\');" title="eliminar"><i class="glyphicon glyphicon-remove"></i></a>';
	$matriz[$c][]['html']=$row['rubro'];
	$matriz[$c][]['html']=empty($row['rubro_categoria']) ? '' : $row['rubro_categoria'];
	$matriz[$c][]['html']=$row['descripcion'];
	$matriz[$c][]['html']=infoAuditoria('sistema.rubros',$row['rowid']);
	$matriz[$c]['estado']=$row['estado'];
}
$resp['html']=armarLista($matriz);
?>