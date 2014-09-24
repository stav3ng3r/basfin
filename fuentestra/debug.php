<?
$debugUsuario=recibir_dato('debug_usuario');
$debugProceso=recibir_dato('debug_Proceso');
$debugCantRegistros=recibir_dato('debug_cantRegistros');
$debugRefrescar=recibir_dato('debug_refrescar');

if(recibir_dato('eliminarDebug')=='ok'){
	$sql="delete from debug";
	$db->set_query($sql);
	$db->execute_query();
}

if($debugUsuario==''){
	$debugUsuario='todos';
}
if($debugProceso==''){
	$debugProceso='todos';
}
if($debugCantRegistros==''){
	$debugCantRegistros=10;
}

$sql="select id_usuario, usuario from usuarios order by usuario";
$db->set_query($sql);
$db->execute_query();
$optionsUsuarios='';

$optionsUsuarios.='<option value="todos">Todos</option>'.chr(13);

if('indefinido'==$debugUsuario){$selected='selected';}else{$selected='';}
$optionsUsuarios.='<option value="indefinido" '.$selected.' >Indefinido</option>'.chr(13);

while($row=$db->get_array()){
	if($row['id_usuario']==$debugUsuario){$selected='selected';}else{$selected='';}
	$optionsUsuarios.='<option value="'.$row['id_usuario'].'" '.$selected.' >'.$row['usuario'].'</option>'.chr(13);
}

$sql="select proceso from debug group by Proceso order by Proceso";
$db->set_query($sql);
$db->execute_query();
$optionsProcesos='';
while($row=$db->get_array()){
	if($row['proceso']==$debugProceso){$selected='selected';}else{$selected='';}
	$optionsProcesos.='<option value="'.$row['proceso'].'" '.$selected.' >'.$row['proceso'].'</option>'.chr(13);
}

if($debugRefrescar=='1'){
	$checked='checked';
}
?>
<html>
	<head>
    	<title>Debug TRA</title>
        <script language="javascript">
			function refrescar(){
				if(document.getElementById('ckrefrescar').checked==true){
					document.formDebug.submit();
				}
				setTimeout('refrescar();', 5000);	
			}
		</script>
    </head>
    <body style="margin:0px;" onLoad="setTimeout('refrescar();', 5000);">
    	<div style="background-color:#CCC;">
			<form name="formDebug" style="margin:0px;" action="index.php?o=debug" method="post">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td>
                            <table border="0" cellpadding="2" cellspacing="2" style="color:#333; font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                                <tr>
                                    <td title="debug($proceso,$bandera,$resultado='',$capa='php');">FN();</td>
                                    <td>&nbsp;&nbsp;&nbsp;</td>                                
                                    <td>Usuario</td>
                                    <td><select style="width:100px;" name="debug_usuario"><?=$optionsUsuarios?></select></td>
                                    <td>Proceso</td>
                                    <td>
                                    	<select style="width:100px;" name="debug_Proceso">
                                        	<option value="todos">Todos</option>
											<?=$optionsProcesos?>
                                        </select>
									</td>
                                    <td>Cant Registros</td>
                                    <td><input type="text" style="width:50px;" name="debug_cantRegistros" value="<?=$debugCantRegistros?>" maxlength="3" /></td>
                                    <td><input type="submit" /></td>
                                </tr>
                            </table>
                        </td>
                        <td align="right">
                            <table border="0" cellpadding="2" cellspacing="2" style="color:#333; font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                                <tr>
                                    <td><a href="index.php?o=debug&eliminarDebug=ok">Eliminar registros</a> | Refrescar automaticamente</td>
                                    <td><input type="checkbox" <?=$checked?> name="debug_refrescar" id="ckrefrescar" value="1" style="cursor:pointer;" title="Refrescar automaticamente" /></td>
                                    <td><a href="javascript:document.formDebug.submit();" title="refrescar"><img src="fuentestra/imagenes/bot/16x16/refresh.png" /></a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
			</form>
        </div>
        <div style="padding:5px;">
        	<table border="0" cellpadding="1" cellspacing="1" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" width="100%">
            	<tr style="background-color:#333; color:#CCC; font-weight:bold; text-align:center;">
                	<td width="30">&nbsp;</td>
                    <td width="200">Fecha</td>
                    <td width="70">Difer.</td>
                    <td width="70">Usuarios</td>
                    <td width="70">Proceso</td>
                    <td width="70">Bandera</td>
                    <td width="*">Resultado</td>
                    <td width="50">Capa</td>
                </tr>
				<?
				
					$where='';
					
					if($debugUsuario!='todos'){
						if($debugUsuario=='indefinido'){
							$where.=' and d.id_usuario is null ';
						}else{
							$where.=' and d.id_usuario='.$debugUsuario.' ';
						}
					}

					if($debugProceso!='todos'){
						$where.=' and d.proceso=\''.$debugProceso.'\' ';
					}
				
                    $sql="
						select
							d.id_debug,
							d.id_usuario,
							d.fecha,
							d.proceso,
							d.bandera,
							d.resultado,
							d.capa,
							u.usuario
						from
							debug d
							left join usuarios u using (id_usuario)
						where
							1=1
							$where
						order by d.fecha desc, d.id_debug desc
						limit $debugCantRegistros
					";
                    $db->set_query($sql);
                    $db->execute_query();
					$c=0;
                    while($row=$db->get_array()){
						$c++;
						
						$auxResultado='';
						if(substr_count($row['resultado'],chr(13))>0 || substr_count($row['resultado'],chr(10))>0){
							$auxResultado='<textarea style="width:100%; font-size:11px;">'.$row['resultado'].'</textarea>';
						}else{
							$auxResultado=$row['resultado'];	
						}
						if($auxResultado==''){$auxResultado='--------------';}
						if($gFecha!=''){
							$diferencia=$gFecha-str_replace('x','',substr($row['fecha'],17));
							$diferencia=number_format($diferencia,7,',','.');
							$diferencia='<div style="position:relative;"><div style="position:absolute; top:-15px; width:70px; text-align:right; background-color:#FFC;">'.$diferencia.'&nbsp;</div></div>';
						}else{
							$diferencia='&nbsp;';
						}
						?>
                        <tr>
                            <td style="background-color:#EBEBEB;"><?=$c?></td>
                            <td style="background-color:#EBEBEB;"><?=$row['fecha']?></td>
                            <td style="background-color:#EBEBEB; text-align:right;"><?=$diferencia?></td>
                            <td style="background-color:#EBEBEB;"><?=$row['usuario']?></td>
                            <td style="background-color:#EBEBEB;"><?=$row['proceso']?></td>
                            <td style="background-color:#EBEBEB;"><?=$row['bandera']?></td>
                            <td style="background-color:#EBEBEB;"><?=$auxResultado?></td>
                            <td style="background-color:#EBEBEB;"><?=$row['capa']?></td>
                        </tr>
						<?
						
						$gFecha=str_replace('x','',substr($row['fecha'],17));
                    }
                ?>
            </table>
        </div>
    </body>
</html>