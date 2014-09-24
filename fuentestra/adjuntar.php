<?php
define('DS', DIRECTORY_SEPARATOR);
$raiz = realpath(dirname(__FIlE__) . DS . '../archivos') . DS;
$directorio = trim($adjuntar['directorio'], '/') . '/';
$dirSeccion = explode('/', $directorio);
$dirTmp = 'tmp/';
$dirDel = 'del/';

if (isset($_FILES)) {
	$tmp = $directorio . $dirTmp;
	$del = $directorio . $dirDel;
	
	if(!is_dir($raiz . $dirSeccion[0])) { mkdir($raiz . $dirSeccion[0], 0777); }
	if(!is_dir($raiz . $directorio)) { mkdir($raiz . $directorio, 0777); }
	if(!is_dir($raiz . $tmp)) { mkdir($raiz . $tmp, 0777); }
	if(!is_dir($raiz . $del)) { mkdir($raiz . $del, 0777); }

	for ($i=0; $i<count($_FILES['archivo']['name']); $i++) {
		$archivo = time() . '_' . $_FILES['archivo']['name'][$i];
		$extension = substr(strrchr($archivo, '.'), 1);
		
		$archivo = str_replace('.','_',substr($archivo,0,strripos($archivo,'.'))). '.' .$extension;
		$archivo = str_replace(' ','-',$archivo);
		$ubicacion = $tmp . $archivo;

		$imagen = false;
		
		if(preg_match('/(jpg|png|gif)/', $extension)){
			$imagen = true;
		}
		
		copy($_FILES['archivo']['tmp_name'][$i], $raiz . $ubicacion);
		
		$resultado[] = array(
			'nombre_temp' 	=> $archivo,
			'extension'		=> $extension,
			'imagen'		=> $imagen,
			'ubicacion'		=> $ubicacion,
			'ancho'			=> $adjuntar['previa']['ancho'],
			'alto'			=> $adjuntar['previa']['alto'],
			'estado'		=> false,
			'nombre_original' 	=> $_FILES['archivo']['name'][$i],
			'peso' =>	$_FILES['archivo']['size'][$i],
			'proporcion'	=> @getimagesize($raiz . $ubicacion)
		);
	}
		
	echo json_encode($resultado, true);	
}

/*
define('DS', DIRECTORY_SEPARATOR);

$base = realpath(dirname(__FIlE__) . DS . '../secciones') . DS;
$directorio = trim($directorio, '/') . '/';
$dirTmp = 'tmp/';
$dirDel = 'del/';

$verIcono = "data:image/jpeg;base64,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";

if(isset($_FILES)) {
	
	$tmp = $directorio . $dirTmp;
	$del = $directorio . $dirDel;
	
	if(!is_dir($directorio)) {
		mkdir($directorio, 0777);
	}
	
	if(!is_dir($base . $tmp)) {
		mkdir($base . $tmp, 0777);
	}
	
	if(!is_dir($base . $del)) {
		mkdir($base . $del, 0777);
	}
	
	// Valores multiples
	if($multiple == true){
		
		for($i=0; $i<count($_FILES['archivo']['name']); $i++) {
		
			$archivo = time() . '_' . $_FILES['archivo']['name'][$i];
			$getPath = $tmp . $archivo;
	
			$extension = substr(strrchr($archivo, '.'), 1);
			$imagen = false;
			
			if(preg_match('/(jpg|png|gif)/', $extension)){
				$imagen = true;
			}
			
			copy($_FILES['archivo']['tmp_name'][$i], $base . $getPath);			
			
			echo '
				<li class="traUploadImg" id="' . str_replace(' ', '-', str_replace('.', '_', $archivo)) . '">
			';
			
			if($imagen){
				echo '
					<div class="traUploadOpciones">
						<div class="traUploadEditar" style="width:16px;height:16px;"><a href="javascript:cargarSeccion(\'adjuntar\',\'vista_previa\',\'archivo='.$getPath.'\',\'ventana\');"><img src="./fuentestra/imagenes/bot/16x16/search.png" /></a></div>
					</div>
				';
			}else{
				echo '
					<div class="traUploadOpciones">
						<div class="traUploadEditar" style="width:16px;height:16px;"><a target="_blank" href="secciones/'.$getPath.'"><img src="./fuentestra/imagenes/bot/16x16/search.png" /></a></div>
					</div>
				';	
			}
			
			
			echo '
					<div class="traUploadContenido"><img src="./index.php?o=ima&archivo='. $getPath .'&tipo=3&ancho=100&alto=100&alinear=o" /></div>
					<input type="hidden" class="'. $_POST['name'] .'" name="'. $_POST['name'] .'[]" value="tmp/'. $archivo .'" />
				</li>	
			';			
			
		}
	
	} else {
		// Procesar solo un archivo adjunto
		
		$archivo = time() . '_' . $_FILES['archivo']['name'];
		$getPath = $tmp . $archivo;

		$extension = substr(strrchr($archivo, '.'), 1);
		$imagen = false;
		
		if(preg_match('/(jpg|png|gif)/', $extension)){
			$imagen = true;
		}
		
		copy($_FILES['archivo']['tmp_name'], $base . $getPath);
		
		echo '
			<li class="traUploadImg" id="' . str_replace(' ', '-', str_replace('.', '_', $archivo)) . '">
		';
		
		if($imagen){
			echo '
				<div class="traUploadOpciones">
					<div class="traUploadEditar" style="width:16px;height:16px;"><a href="javascript:cargarSeccion(\'adjuntar\',\'vista_previa\',\'archivo='.$getPath.'\',\'ventana\');"><img src="'. $searchIcon .'" width="16" height="16" /></a></div>
				</div>
			';
		}else{
			echo '
				<div class="traUploadOpciones">
					<div class="traUploadEditar" style="width:16px;height:16px;"><a target="_blank" href="secciones/'.$getPath.'"><img src="'. $searchIcon .'" width="16" height="16" /></a></div>
				</div>
			';
		}
		
		
		echo '
				<div class="traUploadContenido"><img class="img-thumbnail" src="./index.php?o=ima&archivo='. $getPath .'&tipo=3&ancho=100&alto=100&alinear=o" /></div>
				<input type="hidden" class="'. $_POST['name'] .'" name="'. $_POST['name'] .'[]" value="tmp/'. $archivo .'" />
			</li>	
		';
		
	}
		
}
*/
?>