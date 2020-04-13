<?
	include('sesion/sesion.php');
	include("conection/conectar.php");
	include_once("permite.php");

	$tabla = "contactos_todos";
	$llave = "idcontacto_todos";
	$idcliente = $_GET['idcliente'];
/* 
function ruta_ima($x, $id_ima, $link)
{
	$sql = "SELECT cp.urlCarpeta, md.nombreMedio FROM medios md, carpetas cp WHERE md.idcarpeta=cp.idcarpeta AND md.idmedio='$id_ima'";
	
	$query = mysqli_query ($sql, $link);
	$row = mysqli_fetch_array($query);
	if ($x == '0')
		return "..".$row['urlCarpeta'].$row['nombreMedio'];
	else
		return "..".$row['urlCarpeta']."mini_".$row['nombreMedio'];
}*/
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/admin_internas.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/funciones.js"></script>
<script type="text/javascript" src="./js/funcionesValida.js"></script>
<script type="text/javascript" src="./js/jquery-1.8.3.js" ></script>
<?php include('scripts/scripts.php'); ?>

<script language="javascript">
var x;
x=$(document);
x.ready(inicializarEventos);

function inicializarEventos(){
	$(".numerico").keydown(numerico);//Valida campos numericos
}

function numerico(e) {
	//Permite unicamente campos numericos

  if ((e.keyCode < 48 || e.keyCode > 57  ) && e.keyCode != 8){
	  e.preventDefault();
  }
}

function validaEnvia(form)
{
/*	var celular = $("#celular").val();
	
	if(celular != "" && celular.length != 10 ){ //si digita un numero de celular, pero no contiene 10 digitos
		alert("El campo celular, debe contener 10 digitos");
		return false;
	}


	if($("#comunicadoSms:checked").val() == 1 && celular == ""){ //Si seleccionó mensajes de texto, pero no hay numero de celular
		alert("Digite el numero de celular");
		return false;
	}*/
				if (validarTexto('nombre', 'Por favor ingrese el NOMBRE') == false) return false;

	
	form.datosok.value="si";
	form.submit();
}

function validaBuscar(form)
{
	if (form.cliente.value == "")
	{
		alert('Por favor digite el nombre del cliente');
		form.cliente.focus();
		return false;
	}

	form.xyz.value = form.cliente.value;
	form.submit();
}
function eliminarCont(idCont,nombreCont){
	var conf = confirm('¿Realmente desea eliminar a '+ nombreCont +' de la base de datos?');
	if(conf == true){
		document.getElementById('varelimi').value=idCont;
		formulario.action='contactos_clientes.php?idcliente=<? echo $_GET['idcliente']?>';
		formulario.submit();
		
	}else
		return false;
	
}
</script>
</head>

<?
if($_POST['datosok']=='si')
{
	if($_POST['modRegistro']=="no")
	{
		$queryins="INSERT INTO $tabla (
		                    idcliente, nombre,
		                    correo,
		                    cargo,
		                    division,
		                    celular,
		                    telefono,
		                    cumpleanos,
		                    observaciones
		                    ) VALUES(
		                    '$idcliente',
		                    UCASE('$_POST[nombre]'),
		                    UCASE('$_POST[correo]'),
		                    UCASE('$_POST[cargo]'),
		                    UCASE('$_POST[division]'),
		                    UCASE('$_POST[celular]'),
		                    UCASE('$_POST[telefono]'),
		                    UCASE('$_POST[cumpleanos]'),
		                    UCASE('$_POST[observaciones]')
		                    )";
		//print $queryins;
		$buscarins=mysqli_query($link,$queryins);
					
		if(!$buscarins)
			print ("<script>alert('No se pudo ingresar el registro')</script>");
		else
		{
			?><script>alert ('El registro ha sido ingresado satisfactoriamente')</script><?	
		}	
	}
	else
	{
		$queryins = "UPDATE $tabla SET 
					       nombre=UCASE('$_POST[nombre]'), 
					       correo=UCASE('$_POST[correo]'), 
					       cargo=UCASE('$_POST[cargo]'), 
					       division=UCASE('$_POST[division]'), 
					       celular=UCASE('$_POST[celular]'),
					       telefono=UCASE('$_POST[telefono]'), 
					       cumpleanos=UCASE('$_POST[cumpleanos]'), 
					       observaciones=UCASE('$_POST[observaciones]') 
				     WHERE $llave='$_POST[idcontacto_todos]'";
		//print $queryins;
		$buscarins=mysqli_query($link,$queryins);
		
		if(!$buscarins){
			echo $queryins."<br>".mysqli_error();die();
			print ("<script>alert('No se pudo modificar el registro')</script>");
			
		}else
		{
			?><script>alert ('El registro ha sido modificado satisfactoriamente');</script><?
		}
	}
}

if($_POST['varelimi']!='no' and $_POST['varelimi'])
{

	$queryelim="DELETE FROM $tabla WHERE $llave = ".$_POST['varelimi'];
	//print $queryelim."<br>";
	$buscarelim=mysqli_query($link,$queryelim);
	if(!$buscarelim)
		print mysqli_error();
	?><script>//document.location.href='<? print $_SERVER['PHP_SELF'];?>'</script><?
}

if (isset($_POST['idcontacto_todos']))
	$_GET['idcontacto_todos'] == $_POST['idcontacto_todos'];

?>

<body style="background-color: transparent;">
<form name="formulario" method="post">
	<input name="datosok" type="hidden" value="no" />
	<input name="varelimi" id="varelimi" type="hidden" value="no" />
	<input type="hidden" name="listaEliminar" value="" />
	<input name="xyz" type="hidden" value="" />
	<input type="hidden" name="nueRegistro" id="nueRegistro" value="no" />
	<input type="hidden" name="registroSel" id="registroSel" value="<? echo $_POST['registroSel']?>">
	<? if($_POST['modRegistro'] == "si")
	{
	?>
		<input type="hidden" name="modRegistro" id="modRegistro" value="si" />
	<?
	}else
	{
	?>
		<input type="hidden" name="modRegistro" id="modRegistro" value="no" />
	<?
	}

if(isset($_GET['xyz']) and $_GET['xyz']!="")
	$_POST['xyz'] = $_GET['xyz'];
	if(isset($_POST['xyz']) and $_POST['xyz']!="")
	{
		$sql = "SELECT * FROM clientes WHERE nombre LIKE '%$_POST[xyz]%'";
		$query = mysqli_query($link,$sql, $link);
		$filas = mysqli_num_rows($query);
		if ($filas == 0)
			print ("<script>alert('Este cliente no existe vuelva a intentarlo')</script>");
		else
		{
			if ($filas == 1)
			{
				$row = mysqli_fetch_array($query);
				print ("<script>document.location.href='".$_SERVER['PHP_SELF']."?idcliente=$row[idcliente]'</script>");
			}
			?>
			<table width="50%"align="center">
				<tr align="center">
					<td valign="top">
						<?
						$regxpag = 5;
						$totpag = ceil($filas / $regxpag);
						$pag = $_GET['pag'];
						if (!$pag)
							$pag = 1;
						else
						{
							if (is_numeric($pag) == false)
								$pag = 1;
						}
						$regini = ($pag - 1) * $regxpag;
						$sqlpag = $sql." LIMIT $regini, $regxpag";
						$buscarpag = mysqli_query($link,$sqlpag, $link);
						while($row=mysqli_fetch_array($buscarpag))
						{
							print "<a href=".$_SERVER['PHP_SELF']."?idcliente=$row[idcliente]>$row[nombre]</a><br>";
						}
						?>
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="200" height="20" align="center" valign="middle">&nbsp;</td>
								<td height="20" align="center" valign="middle">
								<a href="javascript:void(0)" onClick="document.location='<? print $_SERVER['PHP_SELF']; ?>?pag=1&xyz=<? print $_POST['xyz']; ?>'">&lt;&lt;</a>
								</td>
								<td height="20" align="center" valign="middle">
									<? if ($pag != 1) { ?><a href="javascript:void(0)" onClick="document.location='<? print $_SERVER['PHP_SELF']; ?>?pag=<? print ($pag - 1); ?>&xyz=<? print $_POST['xyz']; ?>'"><? } ?>&lt;<? if ($pag != 1) { ?></a><? } ?>
								</td>
								<td height="20" align="center" valign="middle">
									<!--<a href="#">1-2-3-4</a>-->
									<select name="pag" onChange="document.location='<? print $_SERVER['PHP_SELF']; ?>?xyz=<? print $_POST['xyz']; ?>&pag=' + document.forms[0].pag.value;">
										<?
										for ($i=1; $i<=$totpag; $i++)
										{
											if ($i == $pag)
												print "<option value=$i selected>$i</option>";
											else
												print "<option value=$i>$i</option>";
										}
										?>
									</select>
								</td>
								<td height="20" align="center" valign="middle">
									<? if ($pag != $totpag) { ?><a href="javascript: void(0)" onClick="document.location='<? print $_SERVER['PHP_SELF']; ?>?pag=<? print ($pag + 1); ?>&xyz=<? print $_POST['xyz']; ?>'"><? } ?>&gt;<? if ($pag != $totpag) { ?></a><? } ?>
								</td>
								<td height="20" align="center" valign="middle">
									<a href="javascript: void(0)" onClick="document.location='<? print $_SERVER['PHP_SELF']; ?>?pag=<? print $totpag; ?>&xyz=<? print $_POST['xyz']; ?>'">&gt;&gt;</a>
								</td>
								<td width="200" height="20" align="center" valign="middle">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		<?
		}
	}
	?> 
             
<table width="100%" align="center">
	<!--<tr>
    	<td align="center" class="subtitseccion" colspan="2"><?/* print 'CONTACTOS CLIENTE';*/ ?><br><br></td>
    </tr>-->
    <!--<tr>
    	<td class="contenidotab">Raz&oacute;n social cliente*</td>
        <td>
        	<table>
                <tr>
                	<td><input id="cliente" name="cliente" class="tex1" value="<? include_once("scripts/recover_nombre.php"); print scai_get_name("$idcliente", "clientes", "idcliente", "nombre"); ?>" maxlength="50"></td> 
                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="validaBuscar(formulario);">Buscar</a></td>
                </tr>
            </table>
      </td>       
    </tr>-->
</table>    

<table width="100%">        
    <tr>
        <td class="tittabla">Nombre</td>
        <td class="tittabla">Correo</td>
        <td class="tittabla">Cargo</td>
        <td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Editar</td>
        <td class="tittabla"><img src="images/ico_eliminar.gif" width="8" height="9">Eliminar</td>
    </tr> 
	<? if($_GET['idcliente'] != '')
    {
    ?>   
        <?
        $sqlad = "select * from $tabla where idcliente=$_GET[idcliente]";
        $exead=mysqli_query($link,$sqlad);
        
        $cant=mysqli_num_rows($exead);
        $regxpag = 10;
        $totpag = ceil($cant / $regxpag);
        $pag = $_GET['pag'];
        if (!$pag)
            $pag = 1;
        else
        {
            if (is_numeric($pag) == false)
                $pag = 1;
        }
        $regini = ($pag - 1) * $regxpag;
        $sqlpag = $sqlad." LIMIT $regini, $regxpag";

        $buscarpag=mysqli_query($link,$sqlpag);
        $cantpag=mysqli_num_rows($buscarpag);
        for($i=0;$i<$cantpag;$i++)
        {
            $datosad=mysqli_fetch_array($buscarpag);
            ?>  
             <tr>            
                <td class="contenidotab"><? print $datosad['nombre'];?></td>
                <td class="contenidotab"><? print $datosad['correo'];?></td>
                <td class="contenidotab"><? print $datosad['cargo'];?></td>
                <td class="contenidotab">
					<a href="#" onClick="document.getElementById('modRegistro').value='si';document.getElementById('registroSel').value='<? echo $datosad['idcontacto_todos']?>';document.getElementById('nueRegistro').value='si';formulario.submit();">Editar</a>
					
				</td>
                <td class="contenidotab">
					<a href="#" onClick="eliminarCont('<? print $datosad['idcontacto_todos']; ?>','<? print $datosad['nombre'];?>')">Eliminar</a>
					</td>
            </tr>          
        <?
        }
        ?> 
    <tr>
        <td colspan="5" align="center">
            <table>
                <tr>
                    <? if(puedo("c","CLIENTES")==1) { ?>                        
                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="nuevoRegistro();">Agregar</a></td>
                    <? } ?>
                    <? if(puedo("e","CLIENTES")==1) { ?>
<!--                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="eliminaRegistros()">Eliminar</a></td>-->
                    <? } ?>
                </tr>
            </table>    
        </td>        	
    </tr> 
    <?
    }
	?>
</table>

<? if($_POST['nueRegistro'] == "si") 
{
	if($_POST['modRegistro']=="si")
	{
		$sqlmod = "SELECT * FROM $tabla WHERE $llave='$_POST[registroSel]'";
		$exemod = mysqli_query($link,$sqlmod, $link);
		$datosmod = mysqli_fetch_array($exemod);
	}
?>	
	<input name="idcontacto_todos" type="hidden" value="<? print $datosmod['idcontacto_todos'] ?>" />
    <table width="100%" class="tabla">
		<tr>
		<?
			if ($_POST['modRegistro']=='si')
			{
				if(puedo("m","CLIENTES")==1) { ?>
				<td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
				<? 
				} 
			}
			elseif ($_POST['modRegistro']=='no')
			{
				if(puedo("c","CLIENTES")==1) { ?> 
				<td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
				<? 
				} 
			} 
			?>
		</tr>
        <tr>
            <td class="contenidotab">NOMBRE*</td>   
            <td><input id="nombre" name="nombre" class="tex1" value="<? print $datosmod['nombre']; ?>" maxlength="50"></td>
        </tr>    
        <tr>
            <td class="contenidotab">EMAIL EMPRESARIAL</td>    
            <td><input id="correo" name="correo" class="tex1" value="<? print $datosmod['correo']; ?>" maxlength="50"></td>
        </tr>
            <tr>
            <td class="contenidotab">CARGO</td>    
            <td><input id="cargo" name="cargo" class="tex1" value="<? print $datosmod['cargo']; ?>" maxlength="50"></td>
        </tr>
        <tr>
            <td class="contenidotab">DIVISION</td>    
            <td><input id="division" name="division" class="tex1" value="<? print $datosmod['division']; ?>" maxlength="50"></td>
        </tr>
        <tr>
            <td class="contenidotab">CELULAR</td>    
            <td><input id="celular" name="celular" class="tex2 numerico" value="<? print $datosmod['celular']; ?>" maxlength="10">
<!--				<input type="checkbox" id="comunicadoSms" name="comunicadoSms" <? echo ($datosmod['comunicadoSms']) ? "checked='checked'" : "" ?> value="1"> Mensaje de texto-->
			</td>
        </tr>
        <tr>
            <td class="contenidotab">TELEFONO</td>    
            <td><input id="telefono" name="telefono" class="tex1" value="<? print $datosmod['telefono']; ?>" maxlength="50"></td>
        </tr>
        <tr>
            <td class="contenidotab">CUMPLEA&Ntilde;OS</td>    
            <td><input id="cumpleanos" name="cumpleanos" class="tex1" value="<? print $datosmod['cumpleanos']; ?>" maxlength="50" readonly>
                <input class='letra' onClick="return showCalendar('cumpleanos');" type='reset' value='...' name='reset'></td>
        </tr>        
        <tr>
            <td class="contenidotab">OBSERVACIONES</td> 
        	<td><textarea name="observaciones" id="observaciones" class="tex1" cols="40" rows="7"><? print $datosmod['observaciones']; ?></textarea></td>
        </tr>
        <tr>
        	<td>
            	<table>
                	<tr>
						<?
                        if ($_POST['modRegistro']=='si')
                        {
                            if(puedo("m","CLIENTES")==1) { ?>
                            <td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
                            <? 
                            } 
                        }
                        elseif ($_POST['modRegistro']=='no')
                        {
                            if(puedo("c","CLIENTES")==1) { ?> 
                            <td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
                            <? 
                            } 
                        } 
                        ?>
                    </tr>
                </table>
            </td>
            
   		</tr>
    </table>
<?
}
?>
</form>
</body>   