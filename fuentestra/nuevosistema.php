<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Sistema sobre plataforma tra</title>
		<style>
            input{width:150px;}
        </style>
        <script language="javascript">
            function validar(){
                var titulo=document.getElementById('titulo').value;
                var descripcion=document.getElementById('descripcion').value;
                var palabrasClave=document.getElementById('palabrasClave').value;
                
                var usuario=document.getElementById('usuario').value;
                var nombre=document.getElementById('nombre').value;
                var clave=document.getElementById('clave').value;
                var clave2=document.getElementById('clave2').value;
                var correo=document.getElementById('correo').value;
                
                if((titulo=='')||(descripcion=='')||(usuario=='')||(nombre=='')||(clave=='')||(clave2=='')||(correo=='')){
                    alert('Debes completar todos los campos');
                }else{
                    if(clave!=clave2){
                        alert('La confirmación de la clave no coincide con la clave');
                    }else{
                        document.form.submit();
                    }
                }
            }
        </script>
	</head>
   	<body>
        <br /><br />
        <form name="form" method="post">
            <table border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                <tr>
                    <td colspan="2" align="center" style="font-size:14px;">ALIAS DEL SISTEMA A REGISTRAR EN BD - <b><?=$tra['alias']?></b></td>
                </tr>
                        <tr><td height="30"></td></tr>
                <tr>
                    <td colspan="2" align="center" style="background-color:#666; color:#CCC;">INGRESE LOS DATOS DEL SISTEMA</td>
                </tr>
                <tr>
                    <td>TITULO</td>
                    <td><input name="titulo" id="titulo" type="text" /></td>
                </tr>
                <tr>
                    <td>DESCRIPCION</td>
                    <td><input name="descripcion" id="descripcion" type="text" /></td>
                </tr>
                <tr>
                    <td>PALABRAS CLAVE</td>
                    <td><input name="palabrasClave" id="palabrasClave" type="text" /></td>
                </tr>
                <tr><td height="30"></td></tr>
                <tr>
                    <td colspan="2" align="center" style="background-color:#666; color:#CCC;">INGRESE LOS DATOS DEL USUARIO ADMINISTRADOR</td>
                </tr>
                <tr>
                    <td width="*">USUARIO</td>
                    <td width="150"><input name="usuario" id="usuario" type="text" /></td>
                </tr>
                <tr>
                    <td>NOMBRE</td>
                    <td><input name="nombre" id="nombre" type="text" /></td>
                </tr>
                <tr>
                    <td>CLAVE</td>
                    <td><input name="clave" id="clave" type="password" /></td>
                </tr>
                <tr>
                    <td>CONFIRMAR CLAVE</td>
                    <td><input name="clave2" id="clave2" type="password" /></td>
                </tr>
                <tr>
                    <td>CORREO</td>
                    <td><input name="correo" id="correo" type="text" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><input type="submit" name="accion" value="aceptar" onclick="validar(); return false;" /></td>
                </tr>
            </table>
            <input type="hidden" name="nuevoSistema" value="procesoInsert" />
        </form>
    </body>
</html>