<?
	include('sesion/sesion.php');
	include("conection/conectar.php");
	include_once("permite.php");

	$tabla = "contactos_todos";
	$llave = "idcontacto_todos";
	$idproveedor_agente = $_GET['idproveedor_agente'];
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
<?php include('scripts/scripts.php'); ?>

<script language="javascript">
function validaEnvia(form)
{
	//if (validarTexto('nit', 'Por favor ingrese el NIT') == false) return false;
	//if (validarTexto('nombre', 'Por favor ingrese el nombre') == false) return false;	
	
	form.datosok.value="si";
	form.submit()
}

function validaBuscar(form)
{
	if (form.proveedor.value == "")
	{
		alert('Por favor digite el nombre del proveedor');
		form.proveedor.focus();
		return false;
	}

	form.xyz.value = form.proveedor.value;
	form.submit();
}

</script>
</head>

<?
if($_POST['datosok']=='si')
{
	if($_POST['modRegistro']=="no")
	{
		$queryins="INSERT INTO $tabla (idproveedor_agente, nombre, correo, cargo, division, celular, telefono, cumpleanos, observaciones) VALUES('$idproveedor_agente', UCASE('$_POST[nombre]'), UCASE('$_POST[correo]'), UCASE('$_POST[cargo]'), UCASE('$_POST[division]'), UCASE('$_POST[celular]'), UCASE('$_POST[telefono]'), UCASE('$_POST[cumpleanos]'), UCASE('$_POST[observaciones]'))";
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
		$queryins="UPDATE $tabla SET nombre=UCASE('$_POST[nombre]'), correo=UCASE('$_POST[correo]'), cargo=UCASE('$_POST[cargo]'), division=UCASE('$_POST[division]'), celular=UCASE('$_POST[celular]'), telefono=UCASE('$_POST[telefono]'), cumpleanos=UCASE('$_POST[cumpleanos]'), observaciones=UCASE('$_POST[observaciones]') WHERE $llave='$_POST[idcontacto_todos]'";
		//print $queryins;
		$buscarins=mysqli_query($link,$queryins);
		
		if(!$buscarins)
			print ("<script>alert('No se pudo modificar el registro')</script>");
		else
		{
			?><script>alert ('El registro ha sido modificado satisfactoriamente')</script><?
		}
	}
}

if($_POST['varelimi']=='si')
{
	$queryelim="DELETE FROM $tabla WHERE $llave IN (".str_replace('\\', '', $_POST['listaEliminar']).")";
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
<input name="varelimi" type="hidden" value="no" />
<input type="hidden" name="listaEliminar" value="" />
<input name="xyz" type="hidden" value="" />
<input type="hidden" name="nueRegistro" value="no" />

<? if($_POST['modRegistro'] == "si")
{
?>
	<input type="hidden" name="modRegistro" value="si" />
<?
}else
{
?>
	<input type="hidden" name="modRegistro" value="no" />
<?
}

if(isset($_GET['xyz']) and $_GET['xyz']!="")
	$_POST['xyz'] = $_GET['xyz'];
	if(isset($_POST['xyz']) and $_POST['xyz']!="")
	{
		$sql = "SELECT * FROM proveedores_agentes WHERE tipo='proveedor' and nombre LIKE '%$_POST[xyz]%'";
		$query = mysqli_query($link,$sql, $link);
		$filas = mysqli_num_rows($query);
		if ($filas == 0)
			print ("<script>alert('Este proveedor no existe vuelva a intentarlo')</script>");
		else
		{
			if ($filas == 1)
			{
				$row = mysqli_fetch_array($query);
				print ("<script>document.location.href='".$_SERVER['PHP_SELF']."?idproveedor_agente=$row[idproveedor_agente]'</script>");
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
							print "<a href=".$_SERVER['PHP_SELF']."?idproveedor_agente=$row[idproveedor_agente]>$row[nombre]</a><br>";
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
    	<td align="center" class="subtitseccion" colspan="2"><?/* print 'CONTACTOS PROVEEDOR';*/ ?><br><br></td>
    </tr>-->
    <!--<tr>
    	<td class="contenidotab">Raz&oacute;n social proveedor*</td>
        <td>
        	<table>
                <tr>
                	<td><input id="proveedor" name="proveedor" class="tex1" value="<? include_once("scripts/recover_nombre.php"); print scai_get_name("$idproveedor_agente", "proveedores_agentes", "idproveedor_agente", "nombre"); ?>" maxlength="50"></td> 
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
    <? if($_GET['idproveedor_agente'] != '')
    {
    ?>    
		<?
        $sqlad = "select * from $tabla where idproveedor_agente=$_GET[idproveedor_agente]";
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
                <td class="contenidotab"><input name="registroSel" type="radio" value="<? print $datosad['idcontacto_todos']; ?>" onClick="modificarRegistro(<?php print $i;?>)" ></td>
                <td class="contenidotab"><input name="eliSel" type="checkbox" onClick="" value="<? print $datosad['idcontacto_todos']; ?>" /></td>
            </tr>          
        <?
        }
        ?> 
    <tr>
        <td colspan="5" align="center">
            <table>
                <tr>
                    <? if(puedo("c","PROVEEDORES")==1) { ?>                        
                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="nuevoRegistro();">Agregar</a></td>
                    <? } ?>
                    <? if(puedo("e","PROVEEDORES")==1) { ?>
                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="eliminaRegistros()">Eliminar</a></td>
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
    <table width="100%">
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
            <td class="contenidotab">DIVSION</td>    
            <td><input id="division" name="division" class="tex1" value="<? print $datosmod['division']; ?>" maxlength="50"></td>
        </tr>
        <tr>
            <td class="contenidotab">CELULAR</td>    
            <td><input id="celular" name="celular" class="tex1" value="<? print $datosmod['celular']; ?>" maxlength="50"></td>
        </tr>
        <tr>
            <td class="contenidotab">TELEFONO</td>    
            <td><input id="telefono" name="telefono" class="tex1" value="<? print $datosmod['telefono']; ?>" maxlength="50"></td>
        </tr>
        <tr>
            <td class="contenidotab">CIUMPLEA&Ntilde;OS</td>    
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
                            if(puedo("m","PROVEEDORES")==1) { ?>
                            <td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
                            <? 
                            } 
                        }
                        elseif ($_POST['modRegistro']=='no')
                        {
                            if(puedo("c","PROVEEDORES")==1) { ?> 
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