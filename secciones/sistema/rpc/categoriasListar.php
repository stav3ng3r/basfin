<?php
$c=-1;
//-- informacion de cabecera de lista
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='sistCategorias';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='sistCategorias';
$c++;	$matriz[0][$c]['html']='Categoría*';	$matriz[0][$c]['width']='*';	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']=infoAuditoria('sistema.categorias',null,'delete');;		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';

$whereFiltro=generarWhereFiltroCadenaBuscar("
	sp_ascii(categoria) ilike sp_ascii('%{text}%')
");

$sql="
	select
		rowid,
		id_categoria,
		categoria
	from
		sistema.categorias
	where
		1=1
		$whereFiltro
	order by
		id_categoria desc
";
$sql=filtrarQueryLista($sql);
$db->set_query($sql);
$db->execute_query();
$c=0;
while($row=$db->get_array()){
	
	//-- informacion de registros de lista
	$c++;
	$matriz[$c][]['html']=seleccionarDeLista($row['id_categoria'],$row['categoria']);
	$matriz[$c][]['html']='<a href="javascript:cargarSeccion(\'sistema\',\'categoria_ae\',\'idCategoria='.$row['id_categoria'].'\',\'ventana\');" title="editar"><i class="glyphicon glyphicon-edit"></i></a>';
	$matriz[$c][]['html']='<a href="javascript:dialogo(\'Confirma que desea eliminar este registro\',\'si:eliminarCategoria('.$row['id_categoria'].');|no\',\'eliminar\');" title="eliminar"><i class="glyphicon glyphicon-remove"></i></a>';
	$matriz[$c][]['html']=$row['categoria'];
	$matriz[$c][]['html']=infoAuditoria('sistema.categorias',$row['rowid']);
	$matriz[$c]['estado']=$row['estado'];
}
$resp['html']=armarLista($matriz);
?>