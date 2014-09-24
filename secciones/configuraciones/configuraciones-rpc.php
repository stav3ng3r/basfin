<?
if($accionRPC=='mostrarValores'){

	$c=0;	$matrizEst[0][$c]['html']='Propiedad';		$matrizEst[0][$c]['width']=350;		$matrizEst[0][$c]['style']='text-align:right;';
	$c++;	$matrizEst[0][$c]['html']='&nbsp;';			$matrizEst[0][$c]['width']=16;		$matrizEst[0][$c]['style']='text-align:center;';
	$c++;	$matrizEst[0][$c]['html']='Valor';			$matrizEst[0][$c]['width']=0;		$matrizEst[0][$c]['style']='';
	$c++;	$matrizEst[0][$c]['html']='&nbsp;';			$matrizEst[0][$c]['width']=16;		$matrizEst[0][$c]['style']='';

	$c=0;

	$c++;
	$defPropiedad[$c]['campo']='alias';
	$defPropiedad[$c]['tipo']='tex';
	$defPropiedad[$c]['detalle']='Alias';
	
	$c++;
	$defPropiedad[$c]['campo']='nroNivel';
	$defPropiedad[$c]['tipo']='tex';
	$defPropiedad[$c]['detalle']='Nro. Nivel';	
	
	$c++;
	$defPropiedad[$c]['campo']='descNivel';
	$defPropiedad[$c]['tipo']='tex';
	$defPropiedad[$c]['detalle']='Descripción Nivel';
	
	$c++;
	$defPropiedad[$c]['campo']='nroEntidad';
	$defPropiedad[$c]['tipo']='tex';
	$defPropiedad[$c]['detalle']='Nro. Entidad';
	
	$c++;
	$defPropiedad[$c]['campo']='entidad';
	$defPropiedad[$c]['tipo']='text';
	$defPropiedad[$c]['detalle']='Entidad';
	$defPropiedad[$c]['default']='';

	$c++;
	$defPropiedad[$c]['campo']='direccionEntidad';
	$defPropiedad[$c]['tipo']='text';
	$defPropiedad[$c]['detalle']='Dirección';

	$c++;
	$defPropiedad[$c]['campo']='prestamoNro';
	$defPropiedad[$c]['tipo']='text';
	$defPropiedad[$c]['detalle']='Prestamo Nro.';
	
	$c++;
	$defPropiedad[$c]['campo']='directorProyecto';
	$defPropiedad[$c]['tipo']='text';
	$defPropiedad[$c]['detalle']='Director del Proyecto';

	$c++;
	$defPropiedad[$c]['campo']='direccionUOC';
	$defPropiedad[$c]['tipo']='text';
	$defPropiedad[$c]['detalle']='Dirección UOC';

	$c++;
	$defPropiedad[$c]['campo']='resUOC';
	$defPropiedad[$c]['tipo']='tex';
	$defPropiedad[$c]['detalle']='Res. UOC';
	
	$c++;
	$defPropiedad[$c]['campo']='resPresupuesto';
	$defPropiedad[$c]['tipo']='tex';
	$defPropiedad[$c]['detalle']='Res. Dpto. Presupuesto';
	
	$c++;
	$defPropiedad[$c]['campo']='resPlanificacion';
	$defPropiedad[$c]['tipo']='tex';
	$defPropiedad[$c]['detalle']='Res. Dpto. Planificacion';
	
	$c++;
	$defPropiedad[$c]['campo']='nroDecreto';
	$defPropiedad[$c]['tipo']='tex';
	$defPropiedad[$c]['detalle']='Nro. Decreto';

	$c++;
	$defPropiedad[$c]['campo']='telefono';
	$defPropiedad[$c]['tipo']='text';
	$defPropiedad[$c]['detalle']='Teléfono';

	$c++;
	$defPropiedad[$c]['campo']='email';
	$defPropiedad[$c]['tipo']='text';
	$defPropiedad[$c]['detalle']='Email';

	$c++;
	$defPropiedad[$c]['campo']='codSICP';
	$defPropiedad[$c]['tipo']='tex';
	$defPropiedad[$c]['detalle']='Código SICP';

	$c++;
	$defPropiedad[$c]['campo']='textoPedidoCDP';
	$defPropiedad[$c]['tipo']='textarea';
	$defPropiedad[$c]['detalle']='Nota Pedido CDP';

	$c++;
	$defPropiedad[$c]['campo']='mostrarCheque';
	$defPropiedad[$c]['tipo']='seleccion->SI,NO';
	$defPropiedad[$c]['detalle']='Mostrar cheque en vista imp. cheque';
	$defPropiedad[$c]['default']='NO';
	
	$c++;
	$defPropiedad[$c]['campo']='firmasCP';
	$defPropiedad[$c]['tipo']='textarea';
	$defPropiedad[$c]['detalle']='Firmas Comprobante de Pago';
	
	$c++;
	$defPropiedad[$c]['campo']='emailConfig';
	$defPropiedad[$c]['tipo']='textarea';
	$defPropiedad[$c]['detalle']='Configuración del e-mail';
	$defPropiedad[$c]['default']='Mailer=pop3
Host=localhost
Port=25
Username=web1_sgp
Password=admin324
From=sgp@tera.com.py
FromName=SGP - Sistema de Gestión Presupuestaria';
	
	$c++;
	$defPropiedad[$c]['campo']='notificarObligacion';
	$defPropiedad[$c]['tipo']='text';
	$defPropiedad[$c]['detalle']='Notificar solicitud de obligacion al e-mail';
	
	$c++;
	$defPropiedad[$c]['campo']='notificarPasarCobrar';
	$defPropiedad[$c]['tipo']='seleccion->SI,NO';
	$defPropiedad[$c]['detalle']='Notificar al beneficiario que puede pasar a cobrar';
	$defPropiedad[$c]['default']='SI';
	
	$c++;
	$defPropiedad[$c]['campo']='strPara30-1';
	$defPropiedad[$c]['tipo']='seleccion->SI,NO';
	$defPropiedad[$c]['detalle']='Egresos 30-1 requieren STR';
	$defPropiedad[$c]['default']='NO';
	
	$c++;
	$defPropiedad[$c]['campo']='tituloPAC';
	$defPropiedad[$c]['tipo']='tex';
	$defPropiedad[$c]['detalle']='Titulo PAC';
	
	$c++;
	$defPropiedad[$c]['campo']='descTituloPAC';
	$defPropiedad[$c]['tipo']='tex';
	$defPropiedad[$c]['detalle']='Descripción del Titulo PAC';
	
	$c++;
	$defPropiedad[$c]['campo']='tituloCDP';
	$defPropiedad[$c]['tipo']='tex';
	$defPropiedad[$c]['detalle']='Titulo CDP';
	
	$c++;
	$defPropiedad[$c]['campo']='descTituloCDP';
	$defPropiedad[$c]['tipo']='tex';
	$defPropiedad[$c]['detalle']='Descripción del Titulo CDP';
	
	for($i=1;$i<=$c;$i++){
		$sql="select * from sgp.configuraciones where campo='".$defPropiedad[$i]['campo']."'";
		$db->set_query($sql);
		$db->execute_query();
		if($row=$db->get_array()){
			$valor=$row['valor'];
		}else{
			$sql="
				insert into sgp.configuraciones (
					campo,
					valor
				) values (
					'".$defPropiedad[$i]['campo']."',
					'".$defPropiedad[$i]['default']."'
				) 
			";
			$db->set_query($sql);
			$db->execute_query();
			$valor=$defPropiedad[$i]['default'];
		}
		
		$matrizEst[$i][0]['html']=$defPropiedad[$i]['detalle'];
		$matrizEst[$i][0]['style']='background-color:#bde1ec;';
		$matrizEst[$i][1]['html']='<a href="javascript:cargarSeccion(\'configuraciones\',\'editar_propiedad\',\'campo='.$defPropiedad[$i]['campo'].'&tipo='.$defPropiedad[$i]['tipo'].'&detalle='.$defPropiedad[$i]['detalle'].'\',\'ventana\');"><img src="fuentestra/imagenes/bot/16x16/edit.png" /></a>';
		$matrizEst[$i][1]['style']='background-color:#bde1ec;';
		$matrizEst[$i][2]['html']=str_replace(chr(10),'<br>',$valor);
		$matrizEst[$i][3]['html']=infoAuditoria('',$row);
	}
	
	$resp['html']=armarLista($matrizEst);
}

if($accionRPC=='editarPropiedad'){
	$campo=recibir_dato('campo');
	$valor=recibir_dato('valor');
	
	$sql="
		update
			sgp.configuraciones
		set
			valor='$valor'
		where
			campo='$campo'
	";
	$db->set_query($sql);
	$db->execute_query();
}
if($accionRPC=='cambiarPeriodoTrabajo'){
	$periodo=recibir_dato('periodo');
	$_SESSION['periodo']=$periodo;
}
?>