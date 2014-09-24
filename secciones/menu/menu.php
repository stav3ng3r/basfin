<?php
$sql="select count(*) from items where cab_id_item is null";
$db->set_query($sql);
$db->execute_query();
$row=$db->get_array();
$cantPrimerNivel=$row['count'];

$sql="
	with recursive mapa_items as (
		(
		select
			i1.id_item,
			i1.cab_id_item,
			i1.item,
			case when length(i1.orden::text)=1 then '0'||i1.orden else i1.orden::text end || '@' || i1.id_item || '@' || i1.item as ruta,
			i1.item as ruta2,
			0 as nivel
		from
			items i1
		where
			i1.cab_id_item is null and
			mostrar_item_menu(i1.id_item) = true
		)
		union all
		(
		select
			i2.id_item,
			i2.cab_id_item,
			i2.item,
			mi.ruta||'/'|| case when length(i2.orden::text)=1 then '0'||i2.orden else i2.orden::text end ||'@'||i2.id_item||'@'||i2.item as ruta,
			mi.ruta2||'>'|| i2.item as ruta2,
			mi.nivel + 1 as nivel
		from
			items i2,
			mapa_items mi
		where
			i2.cab_id_item = mi.id_item and
			mostrar_item_menu(i2.id_item) = true
		)
	)
	select
		mi.*,
		i.tipo,
		i.seccion,
		i.aplicacion,
		i.parametros,
		i.mostrar_en,
		exists(select i2.id_item from items i2 where i2.id_item!=mi.id_item and i2.cab_id_item=i.id_item) as posee_hijos
	from
		mapa_items mi
		join items i on (mi.id_item=i.id_item)
	order by
		mi.ruta
";
$db->set_query($sql);
$db->execute_query();
$c=0;
$b=0;
$htmlMenu='
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="#">FINBAS '. $_SESSION['periodo'] .'</a>
	</div>	
	
	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li>
				<p class="navbar-text">'. date('d/m/Y') .' <span id="hora">'. date('H:i') .'</span></p>
			</li>
		</ul>		
		<ul class="nav navbar-nav navbar-right">
';

$gNivel=0;
while($row=$db->get_array()){
	
	if ($htmlMenu == '') {
		$htmlMenu = '<ul>' . chr(13);
	}

	if($b==1){
		$row['nivel']=$row['nivel'] + 1;
	}

	if($row['nivel'] > $gNivel){
		$gNivel = $row['nivel'];
	}elseif($row['nivel'] < $gNivel){
		for($i = $gNivel; $i > $row['nivel']; $i--){
			$htmlMenu .= '</ul>'.chr(13);
			$htmlMenu .= '</li>'.chr(13);
		}
		$gNivel = $row['nivel'];
	}

	if($row['nivel'] == 0){
		$c++;
	}
	
	/*if($c==6 && $cantPrimerNivel>6 && $b==0){
		$b=1;
		$htmlMenu .= '<li class="dropdown"><a href="#" data-toggle="dropdown">Más <b class="caret"></b></a>'.chr(13);
		$htmlMenu .= '<ul class="dropdown-menu">'.chr(13);

		$row['nivel'] = $row['nivel'] + 1;
		$gNivel=$row['nivel'];
	}*/

	$aux1='<a {href}>' . $row['item'] . (($row['posee_hijos'] == 't') ? '<b class="caret"></b>' : '') . ' </a>';
	$aux2=' href="javascript:void();"';
	if($row['tipo'] == 'aplicacion') {
		$aux3="'" . $row['seccion'] . "','" . $row['aplicacion'] . "','" . $row['parametros'] . "'";
		if($row['mostrar_en'] != '') {
			$aux3.= ",'" . $row['mostrar_en'] . "'";
		}
		$aux2=' href="javascript:cargarSeccion(' . $aux3 . ');"';
	}
	if($row['tipo'] == 'documento') {
		$aux3="'documentos','','documento=" . $row['parametros'] . "'";
		if($row['mostrar_en'] != '') {
			$aux3 .= ",'" . $row['mostrar_en'] . "'";
		}
		$aux2='href="javascript:cargarSeccion(' . $aux3 . ');"';
	}
	if($row['tipo'] == 'href') {
		$aux2=' href="' . $row['parametros'] .'"';
		if(substr($row['parametros'], 0, 4) == 'http'){
			$aux2 .= " target='_blank'";
		}
	}
	
	$aux1=str_replace('<a {href}>', "<a $aux2 ".  (($row['posee_hijos'] == 't') ? " data-toggle=\"dropdown\"" : '') ." >", $aux1);

	if($row['posee_hijos']=='t') {
		/*if(($c==6 || $gNivel>0)){
			$htmlMenu .= '<li class="dropdown-submenu">'.$aux1.chr(13);
			$htmlMenu .= '<ul class="dropdown-menu">'.chr(13);
		}else{*/
			$htmlMenu .= '<li class="dropdown">'.$aux1.chr(13);
			$htmlMenu .= '<ul class="dropdown-menu">'.chr(13);
		//}
	}else{
		$htmlMenu .= '<li>'.$aux1.'</li>'.chr(13);
	}
}

if(!empty($tra['id_usuario'])) {
	$sql="
		select
			*
		from
			usuarios
		where
			id_usuario={$tra['id_usuario']}
	";
	$db->set_query($sql);
	$db->execute_query();
	$row = $db->get_array();
	
	$usuario = $row['usuario'];
	$periodo = $_SESSION['periodo'];

	/*$barraUsuario = '
		<ul class="nav navbar-nav">
			<li><i class="glyphicon glyphicon-calendar"></i></li>
			<li><a style="padding-left: 0px !important" href="#"><p id="hora" class="navbar-text">29/04/2014 15:53</p> </a></li>
			<li><div class="img-perfil"></div></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left: 5px!important">'.$usuario.' <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="javascript:cargarSeccion(\'usuarios\',\'editar_perfil\',\'origen=datosUsuario&idUsuarioEditar='.$tra['id_usuario'].'\');">Mi Perfil</a></li>
					<li><a href="javascript:cargarSeccion(\'configuraciones\',\'cambiar_periodo\',\'\',\'ventana\');">Cambiar proyecto</a></li>
					<li class="divider"></li>
					<li><a href="javascript:desloguear();">Cerrar Sesión</a></li>
				</ul>
			</li>
		</ul>
	';*/

	$sql="
		select
			logo[1] as logo
		from
			sistema.proyectos
		where
			id_proyecto={$_SESSION['id_proyecto']}	
	";
	$db->set_query($sql);
	$db->execute_query();
	$row = $db->get_array();
	
	$barraUsuario = '
		<!--li class="img-perfil"><div class="img-perfil"></div></li-->
		<li class="img-perfil">
			<img src="index.php?o=ima&archivo=archivos/sistema/logos/'. $row['logo'] .'&tipo=3&ancho=30&alto=30&alinear=o" width="30" height="30" />
		</li>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left: 5px!important">'.$usuario.' <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="javascript:cargarSeccion(\'usuarios\',\'usuario_ae\',\'idUsuario='.$tra['id_usuario'].'\',\'ventana\');">Mi Perfil</a></li>
				<li><a href="javascript:cargarSeccion(\'sistema\',\'proyecto\',\'\',\'ventana\');">Cambiar proyecto</a></li>
				<li class="divider"></li>
				<li><a href="javascript:desloguear();">Cerrar Sesión</a></li>
			</ul>
		</li>
		';
}else{
	$barraUsuario = '';
}

for($i=$gNivel; $i>1; $i--){
	$htmlMenu.='</ul>'.chr(13);
	$htmlMenu.='</li>'.chr(13);
}

$htmlMenu .= $barraUsuario;

if($htmlMenu!=''){
	$htmlMenu .= '</ul>' . chr(13);
}

$htmlMenu.='
	</ul>
</div><!-- /.navbar-collapse -->
';

$resp['html'] = $htmlMenu;
?>