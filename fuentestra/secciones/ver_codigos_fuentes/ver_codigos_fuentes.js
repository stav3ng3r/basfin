function mostrarFuente(){
	var nombreElemento = $('#elementoMostrarFuente').val();
	var codigo = '';
	if((nombreElemento=='body')||(nombreElemento=='')){
		codigo = document.getElementsByTagName('body')[0].innerHTML;
	}else if(nombreElemento=='head'){
		codigo = document.getElementsByTagName('head')[0].innerHTML;
	}else{
		codigo = document.getElementById(nombreElemento).innerHTML;
	}
	codigo=replaceAll(codigo,'<','&lt;');
	codigo=replaceAll(codigo,'>','&gt;');
	codigo=replaceAll(codigo,String.fromCharCode(10),'<br>');
	$('#code').html(codigo);
}