<?php
global $resulGrilla;

//-- Información de cabecera del PDF -----------------------------
$titulo = 'Movimientos';
$subTitulo = 'Emitido el '.date('d/m/Y');

//-- Información tipo Cabecera  ----------------------------------


//-- Información tipo Detalle  -----------------------------------
$grilla['cantFilasCab']=1;
$grilla['estilo']='size=7';

$cFila=0;
$cCol=-1;
$cCol++;$grilla[$cFila][$cCol]['info']='Fecha';		$grilla[$cFila][$cCol]['ancho']='*';		$grilla[$cFila][$cCol]['estiloInfo']='align=L';

$grilla[$cFila]['estilo']='style=B,align=C,bgColor=#dedede';

$sql="
	select
		*
	from
		sistema.movimientos
";
$db->set_query($sql);
$db->execute_query();
while($row=$db->get_array()){
	$cFila++;
	$cCol=-1;
	$cCol++;$grilla[$cFila][$cCol]['info']=$row['fecha'];
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
$pdf->Cell(267,7,'Movimientos',0,1,'L');
$grilla['espacioInicial']=$pdf->GetY()-35;
$grilla['espacioFinal']=55;
$pdf->GrillaPrincipal($grilla);
$pdf->Firmas($resulGrilla['ultPosY']+25,'Firma y Sello|Firma y Sello',15);
$nombreArchivoPdf='informes_snd/balance-comprob-'.str_replace(' ','',strtolower(str_replace('.','',$nombreFederacion))).'-'.$mes.'.pdf';
?>