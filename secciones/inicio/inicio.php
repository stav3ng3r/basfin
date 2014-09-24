<?
if($tra['id_usuario']!=''){
	$resp['html']=str_replace('{periodo}',$_SESSION['periodo'],$resp['html']);
	
	$c=0;
	
	$c++;
	$acceso[$c]['img']='folder_full.png';
	$acceso[$c]['titulo']='Seguimiento de documentos';
	$acceso[$c]['link']="javascript:cargarSeccion('segui_docum','panel');";
	$acceso[$c]['permiso']='SDPanel';
	
	$c++;
	$acceso[$c]['img']='note.png';
	$acceso[$c]['titulo']='Plan Financiero';
	$acceso[$c]['link']="javascript:cargarSeccion('plan_financiero');";
	$acceso[$c]['permiso']='planFinan';
	
	$c++;
	$acceso[$c]['img']='package.png';
	$acceso[$c]['titulo']='PACs';
	$acceso[$c]['link']="javascript:cargarSeccion('pac');";
	$acceso[$c]['permiso']='pacs';
	
	$c++;
	$acceso[$c]['img']='process_accept.png';
	$acceso[$c]['titulo']='Obligaciones';
	$acceso[$c]['link']="javascript:cargarSeccion('obligaciones');";
	$acceso[$c]['permiso']='generarObligacion';
	
	$c++;
	$acceso[$c]['img']='add_to_database.png';
	$acceso[$c]['titulo']='Cuentas';
	$acceso[$c]['link']="cargarSeccion('contabilidad','cuentas');";
	$acceso[$c]['permiso']='cuentasContables';
	
	$c++;
	$acceso[$c]['img']='add_page.png';
	$acceso[$c]['titulo']='Categorías de Inversión';
	$acceso[$c]['link']="cargarSeccion('contabilidad','categ_inversion');";
	$acceso[$c]['permiso']='categDeInversion';
	
	$c++;
	$acceso[$c]['img']='add_to_folder.png';
	$acceso[$c]['titulo']='Movimientos';
	$acceso[$c]['link']="cargarSeccion('contabilidad','movimientos');";
	$acceso[$c]['permiso']='movimientosContables';
	
	$c++;
	$acceso[$c]['img']='chart_pie.png';
	$acceso[$c]['titulo']='Informes';
	$acceso[$c]['link']="cargarSeccion('contabilidad','listado_informes');";
	$acceso[$c]['permiso']='reportesContables';
	
	$c++;
	$acceso[$c]['img']='folder.png';
	$acceso[$c]['titulo']='Proyectos';
	$acceso[$c]['link']="cargarSeccion('bid','proyectos_lista');";

	$html='';
	$c2=0;
	$html.='<tr>';
	for($i=1;$i<=$c;$i++){
		if(poseePermiso($acceso[$i]['permiso'])==true){
			$c2++;
			if($c2==1 && $i>0){
				$html.='<tr>';
			}
			if($c2>1){
				$html.='<td width="30px">&nbsp;</td>';
			}
			$html.='
				<td class="botAccesoDirecto" title="'.$acceso[$i]['titulo'].'" onclick="'.$acceso[$i]['link'].'" style="cursor:pointer;">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr><td style="width:128px; height:128px;" align="center"><img src="fuentestra/imagenes/bot/128x128/'.$acceso[$i]['img'].'" /></td></tr>
						<tr><td align="center" valign="top" style="height:50px;color:#4288a3;font-weight:bold;">'.$acceso[$i]['titulo'].'</td></tr>
					</table>
				</td>
			';/* ?><td style="color:#4288a3; font-weight:bold;" onclick="" */
			if($c2==4 && $i<$c){
				$c2=0;
				$html.='</tr>';
			}
		}
	}
	$html.='</tr>';
}

//crearNotificacion('Mensaje Prueba');

$resp['html']=str_replace('{accesos}',$html,$resp['html']);
?>