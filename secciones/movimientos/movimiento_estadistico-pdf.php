<?php
$ingreso = array();
$egreso = array();

for ($i=(date('d')-6); $i<=date('d'); $i++) {
	$tiempo = mktime(0,0,0,date('n'),$i,date('Y'));
	$fecha = date('Y-m-d', $tiempo);
	
	$sql="
		select
			coalesce(sum(md.ingreso),0) as ingreso,
			coalesce(sum(md.egreso),0) as egreso
		from
			sistema.movimientos m
			join sistema.movimiento_detalles md using (id_movimiento)
		where
			m.fecha::date='$fecha' and
			m.id_proyecto={$_SESSION['id_proyecto']}
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	
	$ingreso[] = $row['ingreso'];
	$egreso[] = $row['egreso'];
	$fechas[] = date('d/m', $tiempo);
}

$graph = new Graph(500,300);
$graph->SetScale("textlin");

$theme = new UniversalTheme;

$graph->SetTheme($theme);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('Movimientos');
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels($fechas);
$graph->xgrid->SetColor('#E3E3E3');

$p1 = new LinePlot($ingreso);
$graph->Add($p1);
$p1->SetColor("#6495ED");
$p1->SetLegend('Ingresos');
$p1->value->SetFormat('%d');
$p1->value->Show();
$p1->value->SetColor('#6495ED');

$p2 = new LinePlot($egreso);
$graph->Add($p2);
$p2->SetColor("#B22222");
$p2->SetLegend('Egresos');
$p2->value->SetFormat('%d');
$p2->value->Show();
$p2->value->SetColor('#B22222');

$graph->legend->SetFrameWeight(1);

$archivo = uniqid();
$graph->Stroke("$archivo.png");

$pdf=new PDF();
$pdf->PropiedadesGenerales($titulo.'|'.$subTitulo);
$pdf->AgregarPagina('P');

$pdf->Image("$archivo.png",20,40);
unlink("$archivo.png");
?>