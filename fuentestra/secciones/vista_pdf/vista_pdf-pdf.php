<?


$pdf=new PdfCheque();
$pdf->SetFont('Arial','B',8);
$pdf->AddPage();
$pdf->SetFont('Arial','B',20);
$pdf->Cell(100,10,'Debes indicar la seccion y archivo pdf');
$pdf->Output();
?>