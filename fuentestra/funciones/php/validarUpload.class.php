<?php
/**
*   PHP Validar Upload Class 1.1 - 29/07/2012
*   Copyright (C) 2012  Silvio Valentín Báez
*
*   Este programa es software libre: usted puede redistribuirlo y/o modificarlo 
*   bajo los términos de la Licencia Pública General GNU publicada 
*   por la Fundación para el Software Libre, ya sea la versión 3 
*   de la Licencia, o (a su elección) cualquier versión posterior.
*
*   Este programa se distribuye con la esperanza de que sea útil, pero 
*   SIN GARANTÍA ALGUNA; ni siquiera la garantía implícita 
*   MERCANTIL o de APTITUD PARA UN PROPÓSITO DETERMINADO. 
*   Consulte los detalles de la Licencia Pública General GNU para obtener 
*   una información más detallada. 
*
*   Debería haber recibido una copia de la Licencia Pública General GNU 
*   junto a este programa. 
*   En caso contrario, consulte <http://www.gnu.org/licenses/>.
*
*	Contactos:	silvioqql@hotmail.com	
*	Descargar:	http://www.webbae.net/proyectos/php-validar-upload.rar
*	
*	PHP Validar Upload Class 1.0 - 23/07/2012
*/
class validarUpload{
		
	public $extensiones = 'gif|jpg|png';

	protected function imagen($archivo,$extension){
		$imagenes = array('gif','jpg','jpeg','png');
		$i=0;

		foreach($imagenes as $ext){
			if($extension==$ext){
				$getimagesize = @getimagesize($archivo);
				if($getimagesize===false){
					$i += 1; 
				}else{
					$i += 0;
				}
			}else{
				$i += 0;
			}
		}
		if($i > 0){
			return false;
		}else{
			return true;
		}
	}
	
	public function formato($tipo){
		$tipos = array(
			'image/jpeg' => 'jpg',
			'image/jpg' => 'jpg',
			'image/pjpeg' => 'jpg',
			'image/gif' => 'gif',
			'image/png'	=> 'png',
			'application/vnd.openxmlformats-officedocument.word' => 'docx',
			'application/msword' => 'doc',
			'application/vnd.openxmlformats-officedocument.pres' => 'pptx',
			'application/vnd.ms-powerpoint' => 'ppt',
			'application/pdf' => 'pdf',
			'text/plain' => 'txt',
			'video/mpeg' => 'mpeg'
		);
		foreach($tipos as $mime=>$formato){
			if($mime==$tipo){
				return $formato;
			}
		}
	}
	
	public function validar($archivo){
		$tipo = $_FILES[$archivo]['type'];
		$extension = explode('|',$this->extensiones);
		$generarNombre = time().md5(uniqid(rand()));
		$archivoFormato = $this->formato($tipo);
		$imagen = $this->imagen($_FILES[$archivo]['tmp_name'],$archivoFormato);
		
		if($imagen==true){
			foreach($extension as $ext){
				if($archivoFormato==$ext){
					$resultado = true;
				}
			}
			
			if($resultado==true){
				return $generarNombre.'.'.$archivoFormato;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
}
?>