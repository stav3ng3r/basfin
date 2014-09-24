function siEnter(obj,funcion){
	var k=null;
	(obj.keyCode) ? k=obj.keyCode : k=obj.which;
	if(k==13){
		window.setTimeout(funcion, 0);
		return false
	}
}

function aleatorio(inferior,superior){
    numPosibilidades = superior - inferior
    aleat = Math.random() * numPosibilidades
    aleat = Math.round(aleat)
    return parseInt(inferior) + aleat
} 

function obtener_valor_objeto(id){
	var obj = document.getElementById(id);
	if( obj == null ) return '';
	if( obj.tagName=='SPAN' )
		return obj.innerHTML;
	if( obj.tagName=='INPUT' )
		return obj.value;
}

function utf8_decodea(utf8) {
	// control characters are left for alignment reasons, they will not be used anyway!
	var i, iso885915 = '', 
	utf8ToIso885915 = {
	'NBSP': '\xA0', '¡': '\xA1', '¢': '\xA2', '£': '\xA3', '€': '\xA4', '¥': '\xA5', 'Š': '\xA6', '§': '\xA7', 
	'š': '\xA8', '©': '\xA9', 'ª': '\xAA', '«': '\xAB', '¬': '\xAC', 'SHY': '\xAD', '®': '\xAE', '¯': '\xAF',
	'°': '\xB0', '±': '\xB1', '²': '\xB2', '³': '\xB3', 'Ž': '\xB4', 'µ': '\xB5', '¶': '\xB6', '·': '\xB7', 
	'ž': '\xB8', '¹': '\xB9', 'º': '\xBA', '»': '\xBB', 'Œ': '\xBC', 'œ': '\xBD', 'Ÿ': '\xBE', '¿': '\xBF', 
	'À': '\xC0', 'Á': '\xC1', 'Â': '\xC2', 'Ã': '\xC3', 'Ä': '\xC4', 'Å': '\xC5', 'Æ': '\xC6', 'Ç': '\xC7', 
	'È': '\xC8', 'É': '\xC9', 'Ê': '\xCA', 'Ë': '\xCB', 'Ì': '\xCC', 'Í': '\xCD', 'Î': '\xCE', 'Ï': '\xCF', 
	'Ð': '\xD0', 'Ñ': '\xD1', 'Ò': '\xD2', 'Ó': '\xD3', 'Ô': '\xD4', 'Õ': '\xD5', 'Ö': '\xD6', '×': '\xD7', 
	'Ø': '\xD8', 'Ù': '\xD9', 'Ú': '\xDA', 'Û': '\xDB', 'Ü': '\xDC', 'Ý': '\xDD', 'Þ': '\xDE', 'ß': '\xDF', 
	'à': '\xE0', 'á': '\xE1', 'â': '\xE2', 'ã': '\xE3', 'ä': '\xE4', 'å': '\xE5', 'æ': '\xE6', 'ç': '\xE7', 
	'è': '\xE8', 'é': '\xE9', 'ê': '\xEA', 'ë': '\xEB', 'ì': '\xEC', 'í': '\xED', 'î': '\xEE', 'ï': '\xEF', 
	'ð': '\xF0', 'ñ': '\xF1', 'ò': '\xF2', 'ó': '\xF3', 'ô': '\xF4', 'õ': '\xF5', 'ö': '\xF6', '÷': '\xF7', 
	'ø': '\xF8', 'ù': '\xF9', 'ú': '\xFA', 'û': '\xFB', 'ü': '\xFC', 'ý': '\xFD', 'þ': '\xFE', 'ÿ': '\xFF'
	}
	
	for (i = 0; i < utf8.length; i++){
		iso885915 += utf8ToIso885915[utf8[i]]? utf8ToIso885915[utf8[i]] : utf8[i];
	}
	return iso885915;
}

function cambiarImagen(id,imagen){
	document.getElementById(id).src = imagen;
}

function cambiarClase(id, nombreClase){
	document.getElementById(id).className = nombreClase;
}

function marcarDesmarcarCheckbox(nombre,estado){
	var elementos = document.getElementsByName(nombre);
	for (x=0;x<elementos.length;x++){
		elementos[x].checked = estado;
	}	
}

function desmarcarCheckbox(nombre){
	var elementos = document.getElementsByName(nombre);
	for (x=0;x<elementos.length;x++){
		elementos[x].checked = false;
	}	
}

function valoresSeleccionadosRadio(nombre){
	var elementos = document.getElementsByName(nombre);
	seleccionado = '';
	for (x=0;x<elementos.length;x++){
		if(elementos[x].checked == true){
			seleccionado = elementos[x].value;
		}
	}
	return seleccionado;
}

function valoresSeleccionadosCheckbox(nombre){
	var elementos = document.getElementsByName(nombre);
	seleccionados = '';
	c = 0;
	for (x=0;x<elementos.length;x++){
		if(elementos[x].checked == true){
			c++;
			if(c>1){
				seleccionados += ',';
			}
			seleccionados += elementos[x].value;
		}
	}
	return seleccionados;
}

function puntitos(donde,caracter,dec){
	var decimales = false
	if(dec==undefined){dec=0}
	if(dec!=0){decimales = true;}
	
	pat = /[\*,\+,\(,\),\?,\\,\$,\[,\],\^]/
	valor = donde.value
	largo = valor.length
	crtr = true
	if(isNaN(caracter) || pat.test(caracter) == true){
		if (pat.test(caracter)==true){
			caracter = "\\" + caracter
		}
		carcter = new RegExp(caracter,"g")
		valor = valor.replace(carcter,"")
		donde.value = valor
		crtr = false
	}else{
		var nums = new Array()
		cont = 0
		for(m=0;m<largo;m++){
			if(valor.charAt(m) == "." || valor.charAt(m) == " " || valor.charAt(m) == ","){
				continue;
			}else{
				nums[cont] = valor.charAt(m)
				cont++
			}			
		}
	}
	if(decimales == true){
		ctdd = eval(1 + dec);
		nmrs = 1
	}else{
		ctdd = 1; nmrs = 3
	}
	var cad1="",cad2="",cad3="",tres=0
	if(largo > nmrs && crtr == true){
		for (k=nums.length-ctdd;k>=0;k--){
			cad1 = nums[k]
			cad2 = cad1 + cad2
			tres++
			if((tres%3) == 0){
				if(k!=0){
					cad2 = "." + cad2
				}
			}
		}
		for (dd = dec; dd > 0; dd--){
			cad3 += nums[nums.length-dd]
		}
		if(decimales == true){
			cad2 += "," + cad3
		}
		
		cad2=replaceAll(cad2,'undefined','0');
		var cad9 = '';
		var bDec = false;
		var bCero = true;
		for(m=0;m<cad2.length;m++){
			if(cad2.charAt(m) == ","){
				bDec = true;
			}
			if(bDec==true){
				cad9 += cad2.charAt(m);
			}else{
				if(cad2.charAt(m) != "0" || bCero==false){
					bCero=false;
					cad9 += cad2.charAt(m);
				}
			}
			if(cad9.charAt(0) == ","){
				cad9 = '0' + cad9;
			}
		}
		
		donde.value = cad9;
	}
	
	donde.focus();
}	

// puntitos old sin decimales -------
/*
function puntitos(donde,caracter)
{
pat = /[\*,\+,\(,\),\?,\\,\$,\[,\],\^]/
valor = donde.value
largo = valor.length
crtr = true
if(isNaN(caracter) || pat.test(caracter) == true)
	{
	if (pat.test(caracter)==true) 
		{caracter = "\\" + caracter}
	carcter = new RegExp(caracter,"g")
	valor = valor.replace(carcter,"")
	donde.value = valor
	crtr = false
	}
else
	{
	var nums = new Array()
	cont = 0
	for(m=0;m<largo;m++)
		{
		if(valor.charAt(m) == "." || valor.charAt(m) == " ")
			{continue;}
		else{
			nums[cont] = valor.charAt(m)
			cont++
			}
		
		}
	}


  var cad1="",cad2="",tres=0
  if(largo > 3 && crtr == true)
	{
	for (k=nums.length-1;k>=0;k--)
		{
		cad1 = nums[k]
		cad2 = cad1 + cad2
		tres++
		if((tres%3) == 0)
			{
			if(k!=0){
				cad2 = "." + cad2
				}
			}
		}
	 donde.value = cad2
	}
	
	if(donde.value.toString().indexOf('0')==0){
	  donde.value=0;
	}
	
}
*/

function confirmarEnvio(mensaje,urlConfirmado){
	confirmado = confirm(mensaje);
	if(confirmado){
		location.href=urlConfirmado;
	}
}

function mostrarOcultar(id){
	if((document.getElementById(id).style.display=="")||(document.getElementById(id).style.display=="block")){
		ocultar(id);
	}else{
		mostrar(id);
	}
}

function mostrar(id){
	document.getElementById(id).style.display="";
}

function ocultar(id){
	document.getElementById(id).style.display="none";
}

function soloNumeros(evt){
	var keyPressed = (evt.which) ? evt.which : event.keyCode
	return !(keyPressed > 31 && (keyPressed < 48 || keyPressed > 57));
}

function convertirRGB(str) {
   str = str.replace(/rgb\(|\)/g, "").split(",");
   str[0] = parseInt(str[0], 10).toString(16).toLowerCase();
   str[1] = parseInt(str[1], 10).toString(16).toLowerCase();
   str[2] = parseInt(str[2], 10).toString(16).toLowerCase();
   str[0] = (str[0].length == 1) ? '0' + str[0] : str[0];
   str[1] = (str[1].length == 1) ? '0' + str[1] : str[1];
   str[2] = (str[2].length == 1) ? '0' + str[2] : str[2];
   return ('#' + str.join(""));
}

// valor - decimales - separador decimal - separador miles
function formatCurrency(num,dec) {
	var parteEntera = '';
	var parteDecimal = '';
	
	if(dec==undefined){dec=0;}
	
	var auxNum = num + '';
	var bDec = false;
	for(m=0;m<auxNum.length;m++){
		if(auxNum.charAt(m) == "."){
			bDec = true;
		}else{
			if(bDec == true){
				parteDecimal += auxNum.charAt(m);
			}else{
				parteEntera += auxNum.charAt(m);
			}	
		}
	}
	
    parteEntera = parteEntera.toString().replace(/\$|\,/g,'');
    if(isNaN(parteEntera))
    parteEntera = "0";
    sign = (parteEntera == (parteEntera = Math.abs(parteEntera)));
    parteEntera = Math.floor(parteEntera*100+0.50000000001);
    parteEntera = Math.floor(parteEntera/100).toString();
    for (var i = 0; i < Math.floor((parteEntera.length-(1+i))/3); i++)
    parteEntera = parteEntera.substring(0,parteEntera.length-(4*i+3))+'.'+
    parteEntera.substring(parteEntera.length-(4*i+3));
    parteEntera = (((sign)?'':'-') + parteEntera);
	
	var resultado = parteEntera;
	if(dec>0){
		resultado+= ',' + parteDecimal;
		for(m=parteDecimal.length;m<dec;m++){
			resultado+= '0';
		}
	}
	
	return resultado;
}

function explode(inputstring, separators, includeEmpties) {
	inputstring = new String(inputstring);
	separators = new String(separators);
	
	if(separators == "undefined") {
	separators = " :;";
	}
	
	fixedExplode = new Array(1);
	currentElement = "";
	count = 0;
	
	for(x=0; x < inputstring.length; x++) {
	char = inputstring.charAt(x);
	if(separators.indexOf(char) != -1) {
	if ( ( (includeEmpties <= 0) || (includeEmpties == false)) && (currentElement == "")) { } 
	else {
	fixedExplode[count] = currentElement;
	count++;
	currentElement = ""; } }
	else { currentElement += char; }
	}
	
	if (( ! (includeEmpties <= 0) && (includeEmpties != false)) || (currentElement != "")) {
	fixedExplode[count] = currentElement; } 
	return fixedExplode;
}

function isNumeric(sText){
	var ValidChars = "0123456789.";
	var IsNumber=true;
	var Char;

	for (i = 0; i < sText.length && IsNumber == true; i++) 
	  { 
	  Char = sText.charAt(i); 
	  if (ValidChars.indexOf(Char) == -1) 
		 {
		 IsNumber = false;
		 }
	  }
	return IsNumber;
}

function validarEmail(valor) {
	
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(valor)){
		return (true);
	}else{
		return (false);
	}
}