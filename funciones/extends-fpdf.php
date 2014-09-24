<?
class PDF extends FPDF {

	function Header(){
		global $datosExtrasPdf;
		
		if($datosExtrasPdf['horientacion']=='P'){
			if($datosExtrasPdf['hoja']=='A4'){
				//$this->Rect(20, 10, 180, 277);	//recuadro general
				$this->Line(20, 35, 200, 35);	//linea horiz. encabezado
				//$this->Line(60, 10, 60, 35);	//linea vert. 1 encabezado
				//$this->Line(160, 10, 160, 35);	//linea vert. 2 encabezado
				//$this->Image('secciones/entorno/imagenes/'.valorCampoConfig('alias').'/logo-informe.jpg',20.3,10.4);		// Logo Entidad (Imagene de 111x68 px.)
				//$this->Image('secciones/entorno/imagenes/'.valorCampoConfig('alias').'/logo2.jpg',160.5,10.4);	// Logo Paraguay Todos/as (Imagene de 111x68 px.)
				$this->SetXY(60,12);
				$this->SetFont('Arial','B',12);
				$this->Cell(100,8,'',0,0,'C');
				$this->SetXY(60,19.5);
				$this->SetFont('Arial','B',12);
				$this->Cell(100,6,$datosExtrasPdf['titulo'],0,0,'C');
				$this->SetXY(60,26);
				$this->SetFont('Arial','I',9);
				$this->Cell(100,4,$datosExtrasPdf['descripcion1'],0,0,'C');
				$this->SetXY(60,30);
				$this->SetFont('Arial','I',9);
				$this->Cell(100,4,$datosExtrasPdf['descripcion2'],0,0,'C');
				$this->SetXY(20,35);
			}
			if($datosExtrasPdf['hoja']=='Legal'){
				//$this->Rect(20, 10, 180, 277);	//recuadro general
				$this->Line(20, 32.5, 205, 32.5);	//linea horiz. encabezado
				//$this->Line(60, 10, 60, 35);	//linea vert. 1 encabezado
				//$this->Line(160, 10, 160, 35);	//linea vert. 2 encabezado
				//$this->Image('secciones/entorno/imagenes/'.valorCampoConfig('alias').'/logo-informe.jpg',20.3,7.9);		// Logo Entidad (Imagene de 111x68 px.)
				//$this->Image('secciones/entorno/imagenes/'.valorCampoConfig('alias').'/logo2.jpg',165.5,7.9);	// Logo Paraguay Todos/as (Imagene de 111x68 px.)
				$this->SetXY(60,9.5);
				$this->SetFont('Arial','B',12);
				$this->Cell(105,8,'',0,0,'C');
				$this->SetXY(60,17);
				$this->SetFont('Arial','B',12);
				$this->Cell(105,6,$datosExtrasPdf['titulo'],0,0,'C');
				$this->SetXY(60,23.5);
				$this->SetFont('Arial','I',9);
				$this->Cell(105,4,$datosExtrasPdf['descripcion1'],0,0,'C');
				$this->SetXY(60,27.5);
				$this->SetFont('Arial','I',9);
				$this->Cell(105,4,$datosExtrasPdf['descripcion2'],0,0,'C');
				$this->SetXY(20,32.5);
			}
		}else{
			//$this->Rect(20, 10, 180, 277);	//recuadro general
			$this->Line(20, 35, 287, 35);	//linea horiz. encabezado
			//$this->Line(60, 10, 60, 35);	//linea vert. 1 encabezado
			//$this->Line(160, 10, 160, 35);	//linea vert. 2 encabezado
			//$this->Image('secciones/entorno/imagenes/'.valorCampoConfig('alias').'/logo-informe.jpg',20.3,10.4);		// Logo Entidad (Imagene de 111x68 px.)
			//$this->Image('secciones/entorno/imagenes/'.valorCampoConfig('alias').'/logo2.jpg',247.5,10.4);	// Logo Paraguay Todos/as (Imagene de 111x68 px.)
			$this->SetXY(60,12);
			$this->SetFont('Arial','B',12);
			$this->Cell(187,8,'',0,0,'C');
			$this->SetXY(60,19.5);
			$this->SetFont('Arial','B',12);
			$this->Cell(187,6,$datosExtrasPdf['titulo'],0,0,'C');
			$this->SetXY(60,26);
			$this->SetFont('Arial','I',9);
			$this->Cell(187,4,$datosExtrasPdf['descripcion1'],0,0,'C');
			$this->SetXY(60,30);
			$this->SetFont('Arial','I',9);
			$this->Cell(187,4,$datosExtrasPdf['descripcion2'],0,0,'C');
			$this->SetXY(20,35);
		}
	}
	function Footer(){
		global $tra, $db5, $datosExtrasPdf;
		
		
		$sql5="
			select
				nombre
			from
				usuarios
			where
				id_usuario=".$tra['id_usuario']."
		";
		
		$db5->set_query($sql5);
		$db5->execute_query();
		$row5=$db5->get_array();
		$usuario=$row5['nombre'];
		
		if($datosExtrasPdf['horientacion']=='P'){
			if($datosExtrasPdf['hoja']=='A4'){
				$this->SetFont('Arial','',9);
				$this->Line(20, 279, 200, 279);	//linea horiz. pie
				$this->SetXY(160,279);
				$this->Cell(40,8,'Página '.$this->PageNo().' de {nb}',0,0,'R');
				$this->SetXY(20,279);
				$this->Cell(40,8,'Emitido por '.$usuario.' el '.date('d/m/Y H:i'),0,0,'L');
			}
			if($datosExtrasPdf['hoja']=='Legal'){
				$this->SetFont('Arial','',9);
				$this->Line(20, 310, 205, 310);	//linea horiz. pie
				$this->SetXY(165,310);
				$this->Cell(40,8,'Página '.$this->PageNo().' de {nb}',0,0,'R');
				$this->SetXY(20,310);
				$this->Cell(40,8,'Emitido por '.$usuario.' el '.date('d/m/Y H:i'),0,0,'L');
			}
		}else{
			if($datosExtrasPdf['hoja']=='A4'){
				$this->SetFont('Arial','',9);
				$this->Line(20, 191.5, 287, 191.5);	//linea horiz. pie
				$this->SetXY(250,191.5);
				$this->Cell(40,8,'Página '.$this->PageNo().' de {nb}',0,0,'R');
				$this->SetXY(20,191.5);
				$this->Cell(40,8,'Emitido por '.$usuario.' el '.date('d/m/Y H:i'),0,0,'L');
			}
			if($datosExtrasPdf['hoja']=='Legal'){
				$this->SetFont('Arial','',9);
				$this->Line(20, 191.5, 287, 191.5);	//linea horiz. pie
				$this->SetXY(250,191.5);
				$this->Cell(40,8,'Página '.$this->PageNo().' de {nb}',0,0,'R');
				$this->SetXY(20,191.5);
				$this->Cell(40,8,'Emitido por '.$usuario.' el '.date('d/m/Y H:i'),0,0,'L');
			}
		}
	}
	function PropiedadesGenerales($titulo){
		global $datosExtrasPdf;
		
		$vTitulo=explode('|',$titulo);
		$datosExtrasPdf['titulo']=$vTitulo[0];
		$datosExtrasPdf['descripcion1']=$vTitulo[1];
		$datosExtrasPdf['descripcion2']=$vTitulo[2];
		
		$this->AliasNbPages();
		$this->SetFont('Arial','',10);

		$this->SetMargins(20,1,10);
		$this->SetAutoPageBreak(1, 18);
	}
	
	function AgregarPagina($horientacion='P',$hoja='A4'){
		global $datosExtrasPdf;
		$datosExtrasPdf['horientacion']=$horientacion;
		$datosExtrasPdf['hoja']=$hoja;
		if($hoja=='Legal'){
			$vHoja[0]=216;
			$vHoja[1]=330;
			$this->AddPage($horientacion,$vHoja);
		}else{
			$this->AddPage($horientacion,$hoja);
		}
	}
	
	//-- ini codigo de silvio --------------------
	// Funcion MultiCell	
	function SetWidths($w) 
	{ 
		//Set the array of column widths 
		$this->widths=$w; 
	} 
	
	function SetAligns($a) 
	{ 
		//Set the array of column alignments 
		$this->aligns=$a; 
	} 
	
	function fill($f)
	{
		//juego de arreglos de relleno
		$this->fill=$f;
	}
	
	function Row($data,$borde=0) 
	{ 
		//Calculate the height of the row 
		$nb=0; 
		for($i=0;$i<count($data);$i++) 
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
		$h=5*$nb; 
		//Issue a page break first if needed 
		$this->CheckPageBreak($h); 
		//Draw the cells of the row 
		for($i=0;$i<count($data);$i++) 
		{ 
			$w=$this->widths[$i]; 
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
			//Save the current position 
			$x=$this->GetX(); 
			$y=$this->GetY(); 
			//Draw the border 
			//$this->Rect($x,$y,$w,$h,$style); 
			//Print the text 
			$this->MultiCell($w,5,$data[$i],$borde,$a,$fill); 
			//Put the position to the right of the cell 
			$this->SetXY($x+$w,$y); 
		} 
		//Go to the next line 
		$this->Ln($h); 
	} 
	
	function CheckPageBreak($h) 
	{ 
		//If the height h would cause an overflow, add a new page immediately 
		if($this->GetY()+$h>$this->PageBreakTrigger) 
			$this->AddPage($this->CurOrientation); 
	} 
	
	function NbLines($w,$txt) 
	{ 
		//Computes the number of lines a MultiCell of width w will take 
		$cw=&$this->CurrentFont['cw']; 
		if($w==0) 
			$w=$this->w-$this->rMargin-$this->x; 
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize; 
		$s=str_replace("\r",'',$txt); 
		$nb=strlen($s); 
		if($nb>0 and $s[$nb-1]=="\n") 
			$nb--; 
		$sep=-1; 
		$i=0; 
		$j=0; 
		$l=0; 
		$nl=1; 
		while($i<$nb) 
		{ 
			$c=$s[$i]; 
			if($c=="\n") 
			{ 
				$i++; 
				$sep=-1; 
				$j=$i; 
				$l=0; 
				$nl++; 
				continue; 
			} 
			if($c==' ') 
				$sep=$i; 
			$l+=$cw[$c]; 
			if($l>$wmax) 
			{ 
				if($sep==-1) 
				{ 
					if($i==$j) 
						$i++; 
				} 
				else 
					$i=$sep+1; 
				$sep=-1; 
				$j=$i; 
				$l=0; 
				$nl++; 
			} 
			else 
				$i++; 
		} 
		return $nl; 
	}
		//-- fin codigo de silvio --------------------
}

class PdfCheque extends FPDF {
	function texto($x,$y,$cadena){
		global $refx, $refy;
		//echo('->'.($refx+$y).'<->'.($refy+$x).'<-');
		$this->RotatedText($refx+$y, $refy+$x, $cadena, -90);
	}
	function linea($x1,$y1,$x2,$y2){
		global $refx, $refy;
		//echo('->'.($refx+$y).'<->'.($refy+$x).'<-');
		$this->Line($refx+$y1, $refy+$x1, $refx+$y2, $refy+$x2);
	}	
}
?>