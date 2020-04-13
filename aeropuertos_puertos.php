<?
	include('sesion/sesion.php');
	include("conection/conectar.php");
	include_once("permite.php");
	include_once("scripts/recover_nombre.php");

	$tabla = "aeropuertos_puertos";
	$llave = "idaeropuerto_puerto";
	$tipo = $_GET['tipo'];
/*
function ruta_ima($x, $id_ima, $link)
{
	$sql = "SELECT cp.urlCarpeta, md.nombreMedio FROM medios md, carpetas cp WHERE md.idcarpeta=cp.idcarpeta AND md.idmedio='$id_ima'";
	
	$query = mysql_query ($sql, $link);
	$row = mysql_fetch_array($query);
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
<!--FUNCION DE MOSTRAR RESULTADOS MIENTRAS SE ESCRIBE, PARA TEXT RAZON SOCIAL-->
<? include("scripts/prepare_port_aero_list.php");?>
<script type="text/javascript" src="js/port_aero_list.js"></script>
<?php include('scripts/scripts.php'); ?>

<script language="javascript">
function validaEnvia(form)
{
	if (validarSelec('idciudad', 'Por favor ingrese la ciudad') == false) return false;
	form.datosok.value="si";
	form.submit()
}

function validaBuscar(form)
{
	if (form.nombre.value == "")
	{
		alert('Digite el nombre');
		form.nombre.focus();
		return false;
	}

	form.xyz.value = form.nombre.value;
	form.submit();
}

function eliminaActual(form)
{
	form.varelimi.value="si";
	form.submit()
}

function validaPais(form)
{
	form.submit()
}

function borrar(form)
{
	document.location.href = 'aeropuertos_puertos.php?tipo=<? echo $_GET['tipo']?>';
}
</script>
</head>

<?

if($_POST['datosok']=='si')
{
	if(!isset($_POST['idaeropuerto_puerto']) || $_POST['idaeropuerto_puerto'] == '')
	{
		$queryins="INSERT INTO $tabla (tipo, nombre, codigo, observaciones) VALUES('$tipo', UCASE('$_POST[nombre]'), UCASE('$_POST[codigo]'), UCASE('$_POST[observaciones]'))";
		$buscarins=mysqli_query($queryins,$link);
		
		$sqlast = "SELECT LAST_INSERT_ID() ultimo FROM aeropuertos_puertos";	
		$querylast = mysqli_query($link,$sqlast);		
		$row = mysqli_fetch_array($querylast);
		$idaeropuerto_puerto = $row['ultimo'];
		
		if($buscarins)
		{
			$queryins2="INSERT INTO ciudades_has_aeropuertos_puertos (idciudad, idaeropuerto_puerto) VALUES('$_POST[idciudad]', '$idaeropuerto_puerto')";
			$buscarins2=mysqli_query($queryins2,$link);
		}
		
		if(!$buscarins)
			print ("<script>alert('No se pudo ingresar el registro')</script>");
		else
		{
			?><script>alert ('El registro ha sido ingresado satisfactoriamente')</script><?	
		}
	}
	elseif(isset($_POST['idaeropuerto_puerto']) && $_POST['idaeropuerto_puerto'] != '')
	{
		$queryins="UPDATE $tabla SET nombre=UCASE('$_POST[nombre]'), codigo=UCASE('$_POST[codigo]'), observaciones=UCASE('$_POST[observaciones]') WHERE $llave='$_POST[idaeropuerto_puerto]'";
				
		$queryins2="UPDATE ciudades_has_aeropuertos_puertos SET idciudad='$_POST[idciudad]' WHERE idaeropuerto_puerto='$_POST[idaeropuerto_puerto]'";
 
		$buscarins=mysqli_query($link,$queryins);
		$buscarins2=mysqli_query($link,$queryins2);
		
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
	$queryelim="DELETE FROM $tabla WHERE $llave='$_POST[idaeropuerto_puerto]'";
	$buscarelim=mysqli_query($link,$queryelim);
	if(!$buscarelim)
		print mysqli_error();
	?><script>document.location.href='<? print $_SERVER['PHP_SELF']."?tipo=$tipo";?>'</script><?		
}

if (isset($_POST['idaeropuerto_puerto']))
	$_GET['idaeropuerto_puerto'] == $_POST['idaeropuerto_puerto'];

?>


<body style="background-color: transparent;">
<form name="formulario" method="post">
<input name="datosok" type="hidden" value="no" />
<input type="hidden" name="varelimi" value="no" />
<input type="hidden" name="listaEliminar" value="" />
<input name="idaeropuerto_puerto" type="hidden" value="<? print $_GET['idaeropuerto_puerto'] ?>" />
<input name="xyz" type="hidden" value="" />

<?
	if($_GET['idaeropuerto_puerto'] != '')
	{
		$sqlad = "select * from $tabla where tipo='$tipo' and $llave=$_GET[idaeropuerto_puerto]";
		$exead = mysqli_query($link,$sqlad);
		$datosad = mysqli_fetch_array($exead);
	}

if(isset($_GET['xyz']) and $_GET['xyz']!="")
	$_POST['xyz'] = $_GET['xyz'];
if(isset($_POST['xyz']) and $_POST['xyz']!="")
{
	$sql = "SELECT * FROM $tabla WHERE tipo='$tipo' and nombre LIKE '%$_POST[xyz]%'";
	//print $sql;
	$query = mysqli_query($link,$sql);
	$filas = mysqli_num_rows($query);
	if ($filas == 0)
		print ("<script>alert('Este aeropuerto o puerto no existe vuelva a intentarlo')</script>");
	else
	{
		if ($filas == 1)
		{
			$row = mysqli_fetch_array($query);
			print ("<script>document.location.href='".$_SERVER['PHP_SELF']."?idaeropuerto_puerto=$row[idaeropuerto_puerto]&tipo=$tipo'</script>");
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
					$buscarpag = mysqli_query($link,$sqlpag);
					while($row=mysqli_fetch_array($buscarpag))
					{
						print "<a href=".$_SERVER['PHP_SELF']."?idaeropuerto_puerto=$row[idaeropuerto_puerto]&tipo=$tipo>$row[nombre]</a><br>";
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
								<select name="pag" onChange="document.location='<? print $_SERVER['PHP_SELF']; ?>?xyz=<? print $_POST['xyz']; ?>&tipo=<? print $tipo; ?>&pag=' + document.forms[0].pag.value;">
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
	<tr>
    	<td align="center" class="subtitseccion" colspan="2"><? print strtoupper($tipo); ?><br><br></td>
    </tr>
    <tr>
    	<td class="contenidotab">NOMBRE*</td>    
    	<td>
        	<table>
                <tr>
               		<td><input id="nombre" name="nombre" class="tex1" value="<? if($_POST['nombre']!='') print $_POST['nombre']; else print $datosad['nombre']; ?>" maxlength="50" onKeyUp="Completec(this, event)"></td>
                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="validaBuscar(formulario);">Buscar</a></td>
                </tr>
            </table>
        </td>       
    </tr>
	<tr>
    	<td class="contenidotab">CODIGO*</td>   
    	<td><input id="codigo" name="codigo" class="tex1" value="<? if($_POST['codigo']!='') print $_POST['codigo']; else print $datosad['codigo']; ?>" maxlength="50"></td>
    </tr> 
     <tr>
    	<td class="contenidotab">PAIS*</td>   
    	<td>
        	<select id="idpais" name="idpais" class="tex1" onChange="validaPais(formulario);" >
                <option value="N"> Seleccione </option>
                <?
                $es="select * from paises order by nombre";
                $exe=mysqli_query($link,$es);
				if($_POST['idpais']!='')
					$comparador = $_POST['idpais'];
				else
				{
					$ciudad = scai_get_name("$datosad[idaeropuerto_puerto]","ciudades_has_aeropuertos_puertos", "idaeropuerto_puerto", "idciudad");
					$sqlp = "select idpais from ciudades where idciudad='$ciudad'";
					$exep = mysqli_query($link,$sqlp);
					$datosp = mysqli_fetch_array($exep);
					$comparador = $datosp['idpais']; 	
                }
				while($row=mysqli_fetch_array($exe))
                {
					$sel = "";
					if($comparador == $row['idpais'])
						$sel = "selected";
					print "<option value='$row[idpais]' $sel>$row[nombre]</option>";
                }
                ?>
			</select>
    	</td>    
    </tr>
    <tr>
    <? if($_POST['idpais']=='')
	{
		$ciudad = scai_get_name("$datosad[idaeropuerto_puerto]","ciudades_has_aeropuertos_puertos", "idaeropuerto_puerto", "idciudad");
		$sqlp = "select idpais from ciudades where idciudad='$ciudad'";
		$exep = mysqli_query($link,$sqlp);
		$datosp = mysqli_fetch_array($exep);
		$_POST['idpais'] = $datosp['idpais'];
	}	
	?>
    	<td class="contenidotab">CIUDAD</td>   
    	<td>
        	<select id="idciudad" name="idciudad" class="tex1" >
                <option value="N"> Seleccione </option>
                <?
				$es = "select * from ciudades where idpais='$_POST[idpais]' order by nombre"; 
				$exe=mysqli_query($link,$es);
				if($_POST['idciudad']!='N' && $_POST['idciudad']!='')
					$comparador = $_POST['idciudad'];
				else
					$comparador = scai_get_name("$datosad[idaeropuerto_puerto]","ciudades_has_aeropuertos_puertos", "idaeropuerto_puerto", "idciudad"); 
				while($row=mysqli_fetch_array($exe))
				{
					$sel = "";
					if($comparador == $row['idciudad'])
						$sel = "selected";
					print "<option value='$row[idciudad]' $sel>$row[nombre]</option>";
				}	
                ?>
			</select>
    	</td>    
    </tr> 
    <tr>
        <td class="contenidotab">OBSERVACIONES</td> 
        <td><textarea name="observaciones" id="observaciones" class="tex1"  cols="40" rows="7"><? if($_POST['observaciones']!='') print $_POST['observaciones']; else print $datosad['observaciones']; ?></textarea></td>
    </tr>
	<tr>
    	<td>
            <table>
                <tr>
                	<?
					if ($_GET['idaeropuerto_puerto'] != '')
					{
						if(($tipo='aeropuerto' && puedo("m","AEROPUERTOS_PUERTOS")==1) || ($tipo='puerto' && puedo("m","AEROPUERTOS_PUERTOS")==1)) { ?>
                        <td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
                        <? 
						} 
                    }
					elseif ($_GET['idaeropuerto_puerto'] == '')
					{
						if(($tipo='aeropuerto' && puedo("c","AEROPUERTOS_PUERTOS")==1) || ($tipo='puerto' && puedo("c","AEROPUERTOS_PUERTOS")==1)) { ?> 
                        <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
                     	<? 
						} 
                    } 
					?> 
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>        
					<? if ($_GET['idaeropuerto_puerto'] != '')
					{ 
                    	if(puedo("e","AEROPUERTOS_PUERTOS")==1) { ?>
                        <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="eliminaActual(formulario)">Eliminar</a></td>
                		<? 
						} 
                    } 
					if(puedo("c","AEROPUERTOS_PUERTOS")==1) { ?>                    
                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="borrar(formulario)" >Nuevo</a></td>
                    <? } ?>
            	</tr>
			</table>
    	</td>        
    </tr>     
</table>
</form>
</body>   