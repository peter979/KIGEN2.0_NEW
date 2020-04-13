<?
	include('sesion/sesion.php');
	include("conection/conectar.php");
	include_once("permite.php");

	$tabla = "areas";
	$llave = "idarea";
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

function borrar(form)
{
	document.location.href = 'areas.php';
}

</script>
</head>

<?
if($_POST['datosok']=='si')
{
	if(!isset($_POST['idarea']) || $_POST['idarea'] == '')
	{
		$queryins="INSERT INTO $tabla (nombre, observaciones) VALUES(UCASE('$_POST[nombre]'), UCASE('$_POST[observaciones]'))";
		//print $queryins; 
		$buscarins=mysqli_query($link,$queryins);
			
		if(!$buscarins)
			print ("<script>alert('No se pudo insertar el area, es posible que el area ya exista')</script>");
		else
			?><!--<script>alert ('el registro ha sido ingresado satisfactoriamente')</script>--><?	
	}
	elseif(isset($_POST['idarea']) && $_POST['idarea'] != '')
	{
		$queryins="UPDATE $tabla SET nombre=UCASE('$_POST[nombre]'), observaciones=UCASE('$_POST[observaciones]') WHERE $llave='$_POST[idarea]'";
		//print $queryins; 
		$buscarins=mysqli_query($link,$queryins);
		
		if(!$buscarins)
			print ("<script>alert('No se pudo modificar el registro, es posible que el area ya exista')</script>");
		else
		{
			?><script>alert ('El registro ha sido modificado satisfactoriamente')</script><?
		}	
	}
}

if($_POST['varelimi']=='si')
{
	$queryelim="DELETE FROM $tabla WHERE $llave='$_POST[idarea]'";
	$buscarelim=mysqli_query($link,$queryelim);
	if(!$buscarelim)
		print mysqli_error();	
	?><script>document.location.href='<? print $_SERVER['PHP_SELF']."?tipo=$tipo";?>'</script><?	
}

if (isset($_POST['idarea']))
	$_GET['idarea'] == $_POST['idarea'];

?>


<body style="background-color: transparent;">
<form name="formulario" method="post">
<input name="datosok" type="hidden" value="no" />
<input type="hidden" name="varelimi" value="no" />
<input type="hidden" name="listaEliminar" value="" />
<input name="idarea" type="hidden" value="<? print $_GET['idarea'] ?>" />
<input name="xyz" type="hidden" value="" />

<?
	if($_GET['idarea'] != '')
	{
		$sqlad = "select * from $tabla where $llave=$_GET[idarea]";
		$exead = mysqli_query($link,$sqlad);
		$datosad = mysqli_fetch_array($exead);
	}
?>
<?
if(isset($_GET['xyz']) and $_GET['xyz']!="")
	$_POST['xyz'] = $_GET['xyz'];
if(isset($_POST['xyz']) and $_POST['xyz']!="")
{
	$sql = "SELECT * FROM $tabla WHERE nombre LIKE '%$_POST[xyz]%'";
	//print $sql;
	$query = mysqli_query($link,$sql);
	$filas = mysqli_num_rows($query);
	if ($filas == 0)
		print ("<script>alert('Este pais no existe vuelva a intentarlo')</script>");
	else
	{
		if ($filas == 1)
		{
			$row = mysqli_fetch_array($query);
			print ("<script>document.location.href='".$_SERVER['PHP_SELF']."?idarea=$row[idarea]'</script>");
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
						print "<a href=".$_SERVER['PHP_SELF']."?idarea=$row[idarea]>$row[nombre]</a><br>";
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
	<tr>
        <td align="center" class="subtitseccion" colspan="2"><? print strtoupper(str_replace('_', ' ', $tabla)); ?><br><br></td>
    </tr>
    <tr>
    	<td class="contenidotab">NOMBRE*</td>    
    	<td>       
            <table>
                <tr>
                	<td><input id="nombre" name="nombre" class="tex1" value="<? print $datosad['nombre']; ?>" maxlength="50"></td>
                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="validaBuscar(formulario);">Buscar</a></td>
                </tr>
            </table>
        </td>       
    </tr>	  
    <tr>
        <td class="contenidotab">OBSERVACIONES</td> 
        <td><textarea name="observaciones" id="observaciones" class="tex1"  cols="40" rows="7"><? print $datosad['observaciones']; ?></textarea></td>
    </tr>
    <tr>
    	<td>
            <table>
                <tr>
                	<?
					if ($_GET['idarea'] != '')
					{
						if(puedo("m","EQUIPO_DE_TRABAJO")==1) { ?>
                        <td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
                        <? 
						} 
                    }
					elseif ($_GET['idarea'] == '')
					{
						if(puedo("c","EQUIPO_DE_TRABAJO")==1) { ?> 
                        <td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
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
					<? if ($_GET['idarea'] != '')
					{ 
                    	if(puedo("e","EQUIPO_DE_TRABAJO")==1) { ?>
                        <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="eliminaActual(formulario)">Eliminar</a></td>
                		<? 
						} 
                    } 
					if(puedo("c","EQUIPO_DE_TRABAJO")==1) { ?>                    
                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="borrar(formulario)" >Nuevo</a></td>
                    <? } ?>
            	</tr>
			</table>
    	</td>        
    </tr>     
</table> 
</form>
</body>   