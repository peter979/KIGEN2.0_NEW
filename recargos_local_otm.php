<?
	include('sesion/sesion.php');
	include("conection/conectar.php");	
	include_once("permite.php");
	include_once("scripts/recover_nombre.php");

	$tabla = "recargos_local_otm";
	$llave = "idrecargo_local";
/*
function ruta_ima($x, $id_ima)
{
	$sql = "SELECT cp.urlCarpeta, md.nombreMedio FROM medios md, carpetas cp WHERE md.idcarpeta=cp.idcarpeta AND md.idmedio='$id_ima'";
	
	$query = mysqli_query ($sql);
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
<link href="./css/admin_internas.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/funciones.js"></script>
<script type="text/javascript" src="./js/funcionesValida.js"></script>
<?php include('./scripts/scripts.php'); ?>

<script language="javascript">
function validaEnvia(form)
{
	if(form.valor.value == '')
		form.valor.value = 0;
	if(form.margen.value == '')
		form.margen.value = 0;
	if(form.minimo.value == '')
		form.minimo.value = 0;
	if(form.margen_minimo.value == '')
		form.margen_minimo.value = 0;
		
	form.valor_venta.value = parseInt(form.valor.value) + parseInt(form.margen.value);
	form.minimo_venta.value = parseInt(form.minimo.value) + parseInt(form.margen_minimo.value);
	form.datosok.value="si";
	form.submit()
}

/*
function validaBuscar(form)
{
	if (form.num_contrato.value == "")
	{
		alert('Digite el num_contrato');
		form.num_contrato.focus();
		return false;
	}

	form.xyz.value = form.num_contrato.value;
	form.submit();
}*/

function eliminaActual(form)
{
	form.varelimi.value="si";
	form.submit()
}

function validaTarifario(form)
{
	var seleccionados = 'cero';//valor en la posición cero para las validaciones array_search
	for(i=0; i < 10; i++)
	{
		if(formulario.sel[i].checked)
		{
			if(seleccionados!=='')
				seleccionados=seleccionados + ',';
			seleccionados=seleccionados + formulario.sel[i].value;
		}			
	}
	form.seleccionados.value = seleccionados;
	form.submit()
}

</script>
<script language="javascript">

function cobra()
{
		if (window.XMLHttpRequest)
		{
		  // code for IE7+, Firefox, Chrome, Opera, Safari
		  return new XMLHttpRequest();
		}
		if (window.ActiveXObject)
		{
		  // code for IE6, IE5
		  return new ActiveXObject("Microsoft.XMLHTTP");
		 }
}

/*
function haber(filtre, filtre2, filtre3)
{
	var capa_eyes = window.document.getElementById("eyes2");
	//solicita = new XMLHttpRequest();
	solicita = cobra();
	solicita.open("POST", "search_vuelta.php", true);
	solicita.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	solicita.send("nav="+filtre+"&origen="+filtre2+"&destination="+filtre3);
	solicita.onreadystatechange = cambios;
}*/
function cambios()
{
	var capa_eyes = window.document.getElementById("eyes2");
	if(solicita.readyState == 4)
	{
		capa_eyes.innerHTML = solicita.responseText;
	}
	else
	{
		capa_eyes.innerHTML = '<img src="images/loading.gif" align="middle" /> Buscando...';
	}

}
</script>
</head>

<?
if($_POST['datosok']=='si')
{
	if($_POST['modRegistro']=="no")
	{
		$queryins="INSERT INTO $tabla (idproveedor, nombre, clasificacion, idciudad, valor, valor_venta, moneda, minimo, minimo_venta, fecha_validez, margen, margen_minimo, observaciones) VALUES ('$_POST[idproveedor]', UCASE('$_POST[nombre]'), '$_GET[cl]', '$_POST[idciudad]', '$_POST[valor]', '$_POST[valor_venta]', UCASE('$_POST[moneda]'), '$_POST[minimo]', '$_POST[minimo_venta]', UCASE('$_POST[fecha_validez]'), '$_POST[margen]', '$_POST[margen_minimo]', UCASE('$_POST[observaciones]'))";
		//print $queryins.'<br>';
		$buscarins=mysqli_query($link,$queryins);
		
		if(!$buscarins)
			print ("<script>alert('Error al ingresar la tarifa')</script>");
		else
			?><script>alert ('el registro ha sido ingresado satisfactoriamente')</script><?	
	}
	else
	{
		$queryins = "UPDATE $tabla SET idproveedor='$_POST[idproveedor]', nombre=UCASE('$_POST[nombre]'), idciudad='$_POST[idciudad]', valor='$_POST[valor]', valor_venta='$_POST[valor_venta]', moneda=UCASE('$_POST[moneda]'), minimo='$_POST[minimo]', minimo_venta='$_POST[minimo_venta]', fecha_validez=UCASE('$_POST[fecha_validez]'), margen='$_POST[margen]', margen_minimo='$_POST[margen_minimo]', observaciones=UCASE('$_POST[observaciones]') WHERE $llave='$_POST[idrecargo_local]'";
		//print $queryins.'<br>';
		$buscarins=mysqli_query($link,$queryins);
		
		if(!$buscarins)
			print mysqli_error();
		else
			?><script>alert ('el registro ha sido modificado satisfactoriamente')</script><?
	}
}

if($_POST['varelimi']=='si')
{
	//$queryelim="DELETE FROM $tabla WHERE $llave IN (".str_replace('\\', '', $_POST['listaEliminar']).")";
	$queryelim="update $tabla set estado='0' WHERE $llave IN (".str_replace('\\', '', $_POST['listaEliminar']).")";
	//print $queryelim."<br>";
	$buscarelim=mysqli_query($link,$queryelim);
	if(!$buscarelim)
		print mysqli_error();
	?><script>//document.location.href='<? print $_SERVER['PHP_SELF'];?>'</script><?
}

if (isset($_POST['idtarifario']))
	$_GET['idtarifario'] == $_POST['idtarifario'];
?>
<body style="background-color: transparent;">
<form name="formulario" method="post">
<input name="datosok" type="hidden" value="no" />
<input name="varelimi" type="hidden" value="no" />
<input type="hidden" name="listaEliminar" value="" />
<input name="xyz" type="hidden" value="" />
<input name="seleccionados" type="hidden" value="" />
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
	/*
	if(isset($_GET['xyz']) and $_GET['xyz']!="")
		$_POST['xyz'] = $_GET['xyz'];
	if(isset($_POST['xyz']) and $_POST['xyz']!="")
	{
		$sql = "SELECT * FROM $tabla WHERE nombre LIKE '%$_POST[xyz]%'";
		$query = mysqli_query($link,$sql);
		$filas = mysqli_num_rows($query);
		if ($filas == 0)
			print ("<script>alert('Este recargo no existe vuelva a intentarlo')</script>");
		else
		{
			if ($filas == 1)
			{
				$row = mysqli_fetch_array($query);
				print ("<script>document.location.href='".$_SERVER['PHP_SELF']."?idrecargo_local=$row[idrecargo_local]'</script>");
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
							print "<a href=".$_SERVER['PHP_SELF']."?idrecargo_local=$row[idrecargo_local]>$row[num_contrato]</a><br>";
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
	}*/
	?> 
<table width="100%" align="center">
    <tr>
    	<td align="center" class="subtitseccion" colspan="2">REGARGOS LOCALES OTM <? print $_GET['cl']; ?></td>
    </tr>
</table>            
<? if($_POST['nueRegistro'] == "si") 
{
	if($_POST['modRegistro']=="si")
	{
		$sqlmod = "SELECT * FROM $tabla WHERE $llave='$_POST[registroSel]'";
		$exemod = mysqli_query($link,$sqlmod);
		$datosmod = mysqli_fetch_array($exemod);
	}
	?>
    
    <input name="idrecargo_local" type="hidden" value="<? print $datosmod['idrecargo_local'] ?>" />
	<table width="100%" align="center">
    	<tr>
        	<td class="contenidotab">Proveedor></td> 
            <td>
            	<?
				if($_GET['cl']=='fcl')
					$proveedor = 'otm';
				elseif($_GET['cl']=='lcl')
					$proveedor = 'otm';
				?>
            	<select id="idproveedor" name="idproveedor" class="tex2" >
                    <option value="N"> Seleccione </option>
                    <?
					$comparador = $datosmod['idproveedor'];					
                    $es="select * from proveedores_agentes where tipo='$proveedor' order by nombre";
                    $exe=mysqli_query($link,$es);
                    while($row=mysqli_fetch_array($exe))	
                    {
						$sel = '';
						if($comparador==$row['idproveedor_agente'])
                            $sel = 'selected';
                    	print "<option value='$row[idproveedor_agente]' $sel>$row[nombre]</option>";
                    }
                    ?>
                </select>
            </td> 

        	<td class="contenidotab">Nombre*</td> 
            <td>
            	<input id="nombre" name="nombre" class="tex2" value="<? print $datosmod['nombre']; ?>" maxlength="50" >
            </td> 
    
            <td class="contenidotab">Ciudad</td>   
                <td>
                    <select id="idciudad" name="idciudad" class="tex2" >
                        <option value="N"> Seleccione </option>
                        <?
                        $es = "select * from ciudades where idpais=(select idpais from paises where nombre='colombia') order by nombre"; 
                        $exe=mysqli_query($link,$es);
                        while($row=mysqli_fetch_array($exe))
                        {
                            $sel = "";
                            if($datosmod['idciudad'] == $row['idciudad'])
                                $sel = "selected";
                            print "<option value='$row[idciudad]' $sel>$row[nombre]</option>";
                        }	
                        ?>
                    </select>
                 </td> 
    
            <td class="contenidotab">Valor</td> 
            <td>
            	<input id="valor" name="valor" class="tex2" value="<? print $datosmod['valor']; ?>" maxlength="50" >
                <input type="hidden" id="valor_venta" name="valor_venta" >
            </td>
   
            <td class="contenidotab">Moneda</td> 
            <td>
            	<select id="moneda" name="moneda" class="tex2" >
                    <option value="N"> Seleccione </option>
                    <?
					if($datosmod['moneda']!='') $comparador = $datosmod['moneda']; else $comparador = $_POST['moneda'];
					
                    $es="select * from monedas order by nombre";
                    $exe=mysqli_query($link,$es);
                    while($row=mysqli_fetch_array($exe))	
                    {
						$sel = '';
						if($comparador==$row['idmoneda'])
                            $sel = 'selected';
                    	print "<option value='$row[idmoneda]' $sel>$row[codigo]-$row[nombre]</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>   
            <td class="contenidotab">M&iacute;nimo</td> 
            <td>
            	<input id="minimo" name="minimo" class="tex2" value="<? print $datosmod['minimo']; ?>" maxlength="50" >
                <input type="hidden" id="minimo_venta" name="minimo_venta" >
            </td>
     
            <td class="contenidotab">Fecha validez</td>    
            <td>
            <input id="fecha_validez" name="fecha_validez" class="tex2" value="<? print $datosmod['fecha_validez']; ?>" maxlength="50" readonly>
            <input class="botonesadmin" style="color:#FFFFFF;" onClick="return showCalendar('fecha_validez');" type='reset' value='Calendario' name='reset' />
            </td>   
            <td class="contenidotab">Margen</td> 
            <td>
            	<input id="margen" name="margen" class="tex2" value="<? print $datosmod['margen']; ?>" maxlength="50" >
            </td>
            <td class="contenidotab">Margen Minimo</td> 
            <td>
            	<input id="margen_minimo" name="margen_minimo" class="tex2" value="<? print $datosmod['margen_minimo']; ?>" maxlength="50" >
            </td>
    
            <td class="contenidotab">Observaciones</td> 
            <td><textarea name="observaciones" id="observaciones" class="tex1"  cols="40" rows="3"><? if($_POST['observaciones']!='') print $_POST['observaciones']; else print $datosmod['observaciones']; ?></textarea>
            </td>                        
        <tr>
        	<td>
            	<table>
                	<tr>
                    	<?
                        if ($_POST['modRegistro']=='si')
                        {
                            if(puedo("m","TARIFARIO")==1) { ?>
                            <td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
                            <? 
                            } 
                        }
                        elseif ($_POST['modRegistro']=='no')
                        {
                            if(puedo("c","TARIFARIO")==1) { ?> 
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

<table width="80%" align="center" class="contenidotab">     	
    <tr align="center">
    	<td class="tit_vueltas" align="center">
            Vencidas<!--<input name="vencidas" id="vencidas" class="tex3" type="checkbox" value="1"> &nbsp;&nbsp;&nbsp;-->
            <select name="vencidas" class="Ancho_120px" id="vencidas">
                <option value="N">Seleccione</option>
                <option value="1" <? if($_GET['vencidas']=='1') print 'selected'; ?> >SI</option>
                <option value="0" <? if($_GET['vencidas']=='0') print 'selected'; ?> >NO</option>
            </select>&nbsp;&nbsp;&nbsp;
            
            <input class="botonesadmin" style="color:#FFFFFF;" onClick="document.location = '<? print $_SERVER['PHP_SELF']; ?>?cl=<? print $_GET['cl']; ?>' + '&vencidas=' + document.forms[0].vencidas.value;" type='button' value='Buscar' name='buscar' />				
            <input class="botonesadmin" style="color:#FFFFFF;" onClick="document.location = '<? print $_SERVER['PHP_SELF']; ?>?cl=<? print $_GET['cl']; ?>';" type='button' value='Limpiar filtros' name='limp_fil'/>	
		</td>
    </tr>     
</table>
<br> 
    
<table width="100%"> 
    <tr>
        <td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Mod</td>
        <td class="tittabla"><img src="images/ico_eliminar.gif" width="8" height="9">Elim</td>
        <td class="tittabla">Coloader</td> 
        <td class="tittabla">Nombre</td>
        <td class="tittabla">Moneda</td>
        <td class="tittabla">M&iacute;nimo</td>
        <td class="tittabla">Valor</td>
        <td class="tittabla">Ciudad</td>
        <td class="tittabla">Fecha validez</td>
        <td class="tittabla">Margen</td>  
        <td class="tittabla">Observaciones</td>              
    </tr>    
        <?
		$sqlad="select * from recargos_local_otm where clasificacion='$_GET[cl]' and estado='1'";
		
		if($_GET['vencidas']=='1')
			//$sqlad .= " and fecha_validez < NOW()";
			$sqlad .= " and (fecha_validez between NOW() and DATE_ADD(NOW(), INTERVAL 5 DAY) or fecha_validez < NOW())";
		elseif($_GET['vencidas']=='0')
			//$sqlad .= " and fecha_validez > NOW()";
			$sqlad .= " and fecha_validez not between NOW() and DATE_ADD(NOW(), INTERVAL 5 DAY) and fecha_validez > NOW()";
		//print $sqlad;
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
                <td class="contenidotab"><input name="registroSel" type="radio" value="<? print $datosad['idrecargo_local']; ?>" onClick="modificarRegistro(<?php print $i;?>)" ></td>
                <td class="contenidotab"><input name="eliSel" type="checkbox" onClick="" value="<? print $datosad['idrecargo_local']; ?>" /></td>
                <td class="contenidotab"><? print scai_get_name("$datosad[idproveedor]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
                <td class="contenidotab"><? print $datosad['nombre'];?></td>
                <td class="contenidotab"><? print scai_get_name("$datosad[moneda]","monedas", "idmoneda", "codigo");?></td>
                <td class="contenidotab"><? print $datosad['minimo'];?></td>
                <td class="contenidotab"><? print $datosad['valor'];?></td>
                <td class="contenidotab"><? print scai_get_name("$datosad[idciudad]", "ciudades", "idciudad", "nombre");?></td>
                <td class="contenidotab"><? print $datosad['fecha_validez'];?></td>
                <td class="contenidotab"><? print $datosad['margen'];?></td>
                <td class="contenidotab"><? print $datosad['observaciones'];?></td>
            </tr>          
        <?
        }
        ?> 
    <tr>
        <td colspan="5" align="center">
            <table>
                <tr>
					<? if(puedo("c","TARIFARIO")==1) { ?>                        
                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="nuevoRegistro();">Agregar</a></td>
                    <? } ?>
                    <? if(puedo("e","TARIFARIO")==1) { ?>
                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="eliminaRegistros()">Eliminar</a></td>
                    <? } ?>
                </tr>
            </table>    
        </td>        	
    </tr>         
</table>			  
</form>
</body>   