<?php
$c=-1;
//-- informacion de cabecera de lista
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='rubrRubrosCategorias';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='rubrRubrosCategorias';
$c++;	$matriz[0][$c]['html']='Categoría*';	$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Descripción*';	$matriz[0][$c]['width']='*';	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']=infoAuditoria('sistema.rubros_categorias',null,'delete');;		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';

$whereFiltro=generarWhereFiltroCadenaBuscar("
	text(id_proyecto)='{text}' or
	sp_ascii(rubro_categoria) ilike sp_ascii('%{text}%') or
	sp_ascii(descripcion) ilike sp_ascii('%{text}%')
");

$sql="
	select
		rc.rowid,
		rc.id_rubro_categoria,
		p.proyecto,
		rc.rubro_categoria,
		rc.descripcion
	from
		sistema.rubros_categorias rc
		left join sistema.proyectos p using (id_proyecto)
	where
		1=1
		$whereFiltro
	order by
		id_rubro_categoria desc
";
$sql=filtrarQueryLista($sql);
$db->set_query($sql);
$db->execute_query();
$c=0;
while($row=$db->get_array()){
	
	//-- informacion de registros de lista
	$c++;
	$matriz[$c][]['html']=seleccionarDeLista($row['id_rubro_categoria'],$row['rubro_categoria']);
	$matriz[$c][]['html']='<a href="javascript:cargarSeccion(\'rubros\',\'rubro_categoria_ae\',\'idRubroCategoria='.$row['id_rubro_categoria'].'\',\'ventana\');" title="editar"><i class="glyphicon glyphicon-edit"></i></a>';
	$matriz[$c][]['html']='<a href="javascript:dialogo(\'Confirma que desea eliminar este registro\',\'si:eliminarRubroCategoria('.$row['id_rubro_categoria'].');|no\',\'eliminar\');" title="eliminar"><i class="glyphicon glyphicon-remove"></i></a>';
	$matriz[$c][]['html']=$row['rubro_categoria'];
	$matriz[$c][]['html']=$row['descripcion'];
	$matriz[$c][]['html']=infoAuditoria('sistema.rubros_categorias',$row['rowid']);
	$matriz[$c]['estado']=$row['estado'];
}
$resp['html']=armarLista($matriz);
?>