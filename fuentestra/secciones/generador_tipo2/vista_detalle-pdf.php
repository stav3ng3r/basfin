<?php
global $resulGrilla;

//-- Información de cabecera del PDF -----------------------------
$idT2 = recibir_dato('idT2');
$titulo = 'Comprobante de Generador Tipo 2';
$subTitulo = 'Emitido el '.date('d/m/Y');

//-- Información tipo Cabecera  ----------------------------------

$sql="
	select
		* --x-
		--e->comprobanteCabeceraCampos
		u.usuario,
		u.nombre,
		a.fecha_confirmo
	from
		otros.generador_abm a
		join usuarios u on (u.id_usuario=id_usuario_confirmo)
	where
		a.id_generador_abm=$idT2
";
$db->set_query($sql);
$db->execute_query();
$row=$db->get_array();

$cCab=0;
//--e->comprobanteCabecera
$cCab++;$vCab[$cCab]['tit']='text';		$vCab[$cCab]['dat']='abcde';		//--x-
$cCab++;$vCab[$cCab]['tit']='integer';	$vCab[$cCab]['dat']=12345;			//--x-
$cCab++;$vCab[$cCab]['tit']='decimal';	$vCab[$cCab]['dat']=12345.12;		//--x-
$cCab++;$vCab[$cCab]['tit']='date';		$vCab[$cCab]['dat']='01/01/2014';	//--x-
$confirmacionUsuario=$row['nombre'].' ('.$row['usuario'].')';
$confirmacionFecha=substr($row['fecha_confirmo'],0,16);

//-- Información tipo Detalle  -----------------------------------
$grilla['cantFilasCab']=1;
$grilla['estilo']='size=7';

$cFila=0;
$cCol=-1;
//--e->comprobanteDetalleCabecera:2
$cCol++;$grilla[$cFila][$cCol]['info']='text';			$grilla[$cFila][$cCol]['ancho']='*';		$grilla[$cFila][$cCol]['estiloInfo']='align=L'; //--x-
$cCol++;$grilla[$cFila][$cCol]['info']='integer';		$grilla[$cFila][$cCol]['ancho']='30';		$grilla[$cFila][$cCol]['estiloInfo']='align=L'; //--x-
$cCol++;$grilla[$cFila][$cCol]['info']='decimal';		$grilla[$cFila][$cCol]['ancho']='40';		$grilla[$cFila][$cCol]['estiloInfo']='align=R'; //--x-
$cCol++;$grilla[$cFila][$cCol]['info']='date';			$grilla[$cFila][$cCol]['ancho']='40';		$grilla[$cFila][$cCol]['estiloInfo']='align=R'; //--x-
$cCol++;$grilla[$cFila][$cCol]['info']='select';		$grilla[$cFila][$cCol]['ancho']='40';		$grilla[$cFila][$cCol]['estiloInfo']='align=R'; //--x-
$cCol++;$grilla[$cFila][$cCol]['info']='textarea';		$grilla[$cFila][$cCol]['ancho']='40';		$grilla[$cFila][$cCol]['estiloInfo']='align=R'; //--x-
$cCol++;$grilla[$cFila][$cCol]['info']='radio';			$grilla[$cFila][$cCol]['ancho']='35';		$grilla[$cFila][$cCol]['estiloInfo']='align=R';	//--x-

$grilla[$cFila]['estilo']='style=B,align=C,bgColor=#dedede';

$sql="
	select
		*	//--x-
		//--e->comprobanteDetalleCampos:2
	from
		otros.generador_detalles
	where
		id_generador_abm=$idT2
	order by
		id_generador_detalle
";
$db->set_query($sql);
$db->execute_query();
while($row=$db->get_array()){
	$cFila++;
	$cCol=-1;
	//--e->comprobanteDetalleResultados:2
	$cCol++;$grilla[$cFila][$cCol]['info']=$row['text'];		//--x-
	$cCol++;$grilla[$cFila][$cCol]['info']=$row['numero'];		//--x-
	$cCol++;$grilla[$cFila][$cCol]['info']=$row['decimales'];	//--x-
	$cCol++;$grilla[$cFila][$cCol]['info']=$row['date'];		//--x-
	$cCol++;$grilla[$cFila][$cCol]['info']=$row['select_html'];	//--x-
	$cCol++;$grilla[$cFila][$cCol]['info']=$row['textarea'];	//--x-
	$cCol++;$grilla[$cFila][$cCol]['info']=$row['radio'];		//--x-
}
if($cFila==0){
	$cFila++;
	$grilla[$cFila][0]['info']='No se registran datos en el sistema';
	$grilla[$cFila][0]['colspan']=$cCol+1;
	$grilla[$cFila][0]['estilo']='align=C';
}

//-- Construcción del PDF  -----------------------------------
$pdf=new PDF('P');
$pdf->PropiedadesGenerales($titulo.'|'.$subTitulo);
$pdf->AgregarPagina('P');
$pdf->SetFillColor(230);
for($i=1;$i<=$cCab;$i++){
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(60,7,$vCab[$i]['tit'],1,0,'C',1);
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(120,7,$vCab[$i]['dat'],1,1);
}
$pdf->SetFont('Arial','B',10);
$pdf->Ln();
$pdf->Cell(267,7,'Detalle de Vista Generador Tipo 2',0,1,'L');
$grilla['espacioInicial']=$pdf->GetY()-35;
$grilla['espacioFinal']=55;
$pdf->GrillaPrincipal($grilla);
$pdf->Firmas($resulGrilla['ultPosY']+25,$confirmacionUsuario.'\nResponsable de carga de datos al sistema\nFecha/Hora: '.$confirmacionFecha.'|Firma, Sello y Aclaración del\nResponsable Administrativo|Firma,Sello y Aclaración de la\nMáxima Autoridad Institucional',15);
$nombreArchivoPdf='informes_snd/balance-comprob-'.str_replace(' ','',strtolower(str_replace('.','',$nombreFederacion))).'-'.$mes.'.pdf';
?>