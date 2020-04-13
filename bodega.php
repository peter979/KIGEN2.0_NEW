<?
	include('sesion/sesion.php');
	include("conection/conectar.php");	
	include_once("permite.php");
	include_once("scripts/recover_nombre.php");

	$tabla = "bodega";
	$llave = "idbodega";
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
<link href="./css/admin_internas.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/funciones.js"></script>
<script type="text/javascript" src="./js/funcionesValida.js"></script>
<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "exact",
	elements : "condiciones,doc_req",
	theme : "simple",
	plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,media,searchreplace,print,contextmenu,paste,directionality,fullscreen",
	theme_advanced_buttons1_add : "fontselect,fontsizeselect",
	theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
	theme_advanced_buttons2_add_before: "cut,copy,paste,pasteword,separator,separator",
	theme_advanced_buttons3_add_before : "tablecontrols,separator",
	theme_advanced_buttons3_add : "emotions,iespell,media,separator,ltr,rtl,separator",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	plugi2n_insertdate_dateFormat : "%Y-%m-%d",
	plugi2n_insertdate_timeFormat : "%H:%M:%S",
	file_browser_callback : "fileBrowserCallBack",
	content_css : "../css/sitio.css",
	paste_use_dialog : false,
	theme_advanced_resizing : true,
	theme_advanced_resize_horizontal : false,
	theme_advanced_link_targets : "",
	paste_auto_cleanup_on_paste : true,
	paste_convert_headers_to_strong : false,
	paste_strip_class_attributes : "all",
	paste_remove_spans : false,
	paste_remove_styles : false
});
</script>

<?php include('./scripts/scripts.php'); ?>

<script language="javascript">
function validaEnvia(form)
{
	form.advaloren_venta.value = parseFloat(form.advaloren.value) + parseFloat(form.margen.value);	
	<? if($_GET['cl']=='lcl' || $_GET['cl']=='aereo') { ?>
	form.min_advaloren_venta.value = parseFloat(form.min_advaloren.value) + parseFloat(form.margen_min_advaloren.value);
	form.min_mes_fraccion_venta.value = parseFloat(form.min_mes_fraccion.value) + parseFloat(form.margen_min_mes_fraccion.value);
	<? } ?>
	form.mes_fraccion_venta.value = parseFloat(form.mes_fraccion.value) + parseFloat(form.margen_mes_fraccion.value);	
	<? if($_GET['cl']=='fcl') { ?>
	form.mes_fraccion_40_venta.value = parseFloat(form.mes_fraccion_40.value) + parseFloat(form.margen_mes_fraccion_40.value);
	<? } ?>
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

function validaPais(form)
{
	form.nueRegistro.value = 'si';
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

/*function haber(filtre, filtre2, filtre3)
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
		$queryins="INSERT INTO $tabla (idproveedor, moneda, clasificacion, advaloren, advaloren_venta, min_advaloren, min_advaloren_venta, margen_min_advaloren, mes_fraccion, mes_fraccion_venta, min_mes_fraccion, min_mes_fraccion_venta, margen_min_mes_fraccion, mes_fraccion_40, mes_fraccion_40_venta, manejo, min_manejo, fecha_validez, margen, margen_mes_fraccion, margen_mes_fraccion_40, observaciones) VALUES ('$_POST[idproveedor]', '$_POST[moneda]', '$_GET[cl]', '$_POST[advaloren]', '$_POST[advaloren_venta]', '$_POST[min_advaloren]', '$_POST[min_advaloren_venta]', '$_POST[margen_min_advaloren]', '$_POST[mes_fraccion]', '$_POST[mes_fraccion_venta]', '$_POST[min_mes_fraccion]', '$_POST[min_mes_fraccion_venta]', '$_POST[margen_min_mes_fraccion]', '$_POST[mes_fraccion_40]', '$_POST[mes_fraccion_40_venta]', '$_POST[manejo]', '$_POST[min_manejo]', '$_POST[fecha_validez]', '$_POST[margen]', '$_POST[margen_mes_fraccion]', '$_POST[margen_mes_fraccion_40]', UCASE('$_POST[observaciones]'))";
		//print $queryins.'<br>';
		$buscarins=mysqli_query($link,$queryins);
		
		if(!$buscarins)
			print ("<script>alert('Error al ingresar la tarifa')</script>");
		else
			?><script>alert ('el registro ha sido ingresado satisfactoriamente')</script><?	
	}
	else
	{
		$queryins = "UPDATE $tabla SET idproveedor='$_POST[idproveedor]', moneda='$_POST[moneda]', advaloren='$_POST[advaloren]', advaloren_venta='$_POST[advaloren_venta]', min_advaloren='$_POST[min_advaloren]', min_advaloren_venta='$_POST[min_advaloren_venta]', margen_min_advaloren='$_POST[margen_min_advaloren]', mes_fraccion='$_POST[mes_fraccion]', mes_fraccion_venta='$_POST[mes_fraccion_venta]', min_mes_fraccion='$_POST[min_mes_fraccion]', min_mes_fraccion_venta='$_POST[min_mes_fraccion_venta]', margen_min_mes_fraccion='$_POST[margen_min_mes_fraccion]', mes_fraccion_40='$_POST[mes_fraccion_40]', mes_fraccion_40_venta='$_POST[mes_fraccion_40_venta]', min_mes_fraccion_40='$_POST[min_mes_fraccion_40]', manejo='$_POST[manejo]', min_manejo='$_POST[min_manejo]', fecha_validez='$_POST[fecha_validez]', margen='$_POST[margen]', margen_mes_fraccion='$_POST[margen_mes_fraccion]', margen_mes_fraccion_40='$_POST[margen_mes_fraccion_40]', observaciones=UCASE('$_POST[observaciones]') WHERE $llave='$_POST[idbodega]'";
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
		$query = mysqli_query($sql, $link);
		$filas = mysqli_num_rows($query);
		if ($filas == 0)
			print ("<script>alert('Este recargo no existe vuelva a intentarlo')</script>");
		else
		{
			if ($filas == 1)
			{
				$row = mysqli_fetch_array($query);
				print ("<script>document.location.href='".$_SERVER['PHP_SELF']."?idbodega=$row[idbodega]'</script>");
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
						$buscarpag = mysqli_query($sqlpag, $link);
						while($row=mysqli_fetch_array($buscarpag))
						{
							print "<a href=".$_SERVER['PHP_SELF']."?idbodega=$row[idbodega]>$row[num_contrato]</a><br>";
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
    	<td align="center" class="subtitseccion" colspan="2">Tarifario BODEGA <? print strtoupper($_GET['cl']); ?></td>
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
<input name="idbodega" type="hidden" value="<? if($_POST['idbodega']!='') print $_POST['idbodega']; else print $datosmod['idbodega']; ?>" />
	<table width="100%" align="center">
    	<tr>
        	<td class="contenidotab">Proveedor*</td> 
            <td>
                <select id="idproveedor" name="idproveedor" class="tex2" >
                  <option value="N"> Seleccione </option>
                    <?
                    if($_POST['idproveedor']!='N' && $_POST['idproveedor']!='')
                        $comparador = $_POST['idproveedor'];		
                    else
                        $comparador = $datosmod['idproveedor'];					
                    $es="select * from proveedores_agentes where tipo='bodega' order by nombre";
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
			<td class="contenidotab">Fecha validez</td>    
            <td>
            <input id="fecha_validez" name="fecha_validez" class="tex2" value="<? if($_POST['fecha_validez']!='') print $_POST['fecha_validez']; else print $datosmod['fecha_validez']; ?>" maxlength="50" readonly>
            <input class="botonesadmin" style="color:#FFFFFF;" onClick="return showCalendar('fecha_validez');" type='reset' value='Calendario' name='reset' />
            </td>
        </tr>
        <tr>
        	<td class="contenidotab">Tarifa ad-valoren/CIF(%)</td> 
            <td>
            	<input id="advaloren" name="advaloren" class="tex2" value="<? if($_POST['advaloren']!='') print $_POST['advaloren']; else print $datosmod['advaloren']; ?>" maxlength="50" >
                <input name="advaloren_venta" type="hidden" value="" />
            </td>
            <td class="contenidotab">Margen ad-valoren/CIF(%)</td> 
            <td>
            	<input id="margen" name="margen" class="tex2" value="<? if($_POST['margen']!='') print $_POST['margen']; else print $datosmod['margen']; ?>" maxlength="50" >
            </td>
            <?
			if($_GET['cl']=='lcl' || $_GET['cl']=='aereo')
			{
				?>     
                <td class="contenidotab">M&iacute;nimo ad-valoren/CIF($)</td> 
                <td>
                    <input id="min_advaloren" name="min_advaloren" class="tex2" value="<? if($_POST['min_advaloren']!='') print $_POST['min_advaloren']; else print $datosmod['min_advaloren']; ?>" maxlength="50" >
                    <input name="min_advaloren_venta" type="hidden" value="" />
                </td>
                <td class="contenidotab">Margen M&iacute;nimo ad-valoren/CIF($)</td> 
                <td>
                    <input id="margen_min_advaloren" name="margen_min_advaloren" class="tex2" value="<? if($_POST['margen_min_advaloren']!='') print $_POST['margen_min_advaloren']; else print $datosmod['margen_min_advaloren']; ?>" maxlength="50" >
                </td>
                <?
			}
			?>
        </tr>
        <tr>
        	<td class="contenidotab">Tarifa<? if($_GET['cl']=='lcl' || $_GET['cl']=='aereo') print ' por mes o fracci&oacute;n'; elseif($_GET['cl']=='fcl') print ' integral para contenedor de 20 por mes o fracci&oacute;n'; ?>($)</td> 
            <td>
            	<input id="mes_fraccion" name="mes_fraccion" class="tex2" value="<? if($_POST['mes_fraccion']!='') print $_POST['mes_fraccion']; else print $datosmod['mes_fraccion']; ?>" maxlength="50" >
                <input name="mes_fraccion_venta" type="hidden" value="" />
            </td>
            <td class="contenidotab">Margen<? if($_GET['cl']=='lcl' || $_GET['cl']=='aereo') print ' por mes o fracci&oacute;n'; elseif($_GET['cl']=='fcl') print ' integral para contenedor de 20 por mes o fracci&oacute;n'; ?>($)</td> 
            <td>
            	<input id="margen_mes_fraccion" name="margen_mes_fraccion" class="tex2" value="<? if($_POST['margen_mes_fraccion']!='') print $_POST['margen_mes_fraccion']; else print $datosmod['margen_mes_fraccion']; ?>" maxlength="50" >
            </td>
            <?
			if($_GET['cl']=='lcl' || $_GET['cl']=='aereo')
			{
				?>
                <td class="contenidotab">M&iacute;nimo por mes o fracci&oacute;n($)</td> 
                <td>
                    <input id="min_mes_fraccion" name="min_mes_fraccion" class="tex2" value="<? if($_POST['min_mes_fraccion']!='') print $_POST['min_mes_fraccion']; else print $datosmod['min_mes_fraccion']; ?>" maxlength="50" >
                    <input name="min_mes_fraccion_venta" type="hidden" value="" />
                </td>
                <td class="contenidotab">Margen M&iacute;nimo mes o fracci&oacute;n($)</td> 
                <td>
                    <input id="margen_min_mes_fraccion" name="margen_min_mes_fraccion" class="tex2" value="<? if($_POST['margen_min_mes_fraccion']!='') print $_POST['margen_min_mes_fraccion']; else print $datosmod['margen_min_mes_fraccion']; ?>" maxlength="50" >
                </td>
                <input name="mes_fraccion_40" type="hidden" value="" />
                <input name="margen_mes_fraccion_40" type="hidden" value="" />
                <?
			}
			?>
        </tr>
        <?
		if($_GET['cl']=='fcl')
		{
			?>
            <tr>
                <td class="contenidotab">Tarifa integral para contenedor de 40 por mes o fracci&oacute;n($)</td> 
                <td>
                	<input id="mes_fraccion_40" name="mes_fraccion_40" class="tex2" value="<? if($_POST['mes_fraccion_40']!='') print $_POST['mes_fraccion_40']; else print $datosmod['mes_fraccion_40']; ?>" maxlength="50" >
                	<input name="mes_fraccion_40_venta" type="hidden" value="" />
                </td>
                <td class="contenidotab">Margen integral para contenedor de 40 por mes o fracci&oacute;n($)</td> 
                <td>
                	<input id="margen_mes_fraccion_40" name="margen_mes_fraccion_40" class="tex2" value="<? if($_POST['margen_mes_fraccion_40']!='') print $_POST['margen_mes_fraccion_40']; else print $datosmod['margen_mes_fraccion_40']; ?>" maxlength="50" > 
            	</td>                
            </tr>
            <input name="min_advaloren" type="hidden" value="" />
            <input name="min_advaloren_venta" type="hidden" value="" />
            <input name="margen_min_advaloren" type="hidden" value="" />
            <input name="min_mes_fraccion" type="hidden" value="" />
            <input name="min_mes_fraccion_venta" type="hidden" value="" />
            <input name="margen_min_mes_fraccion" type="hidden" value="" />
        	<?
		}
		?>
        <tr>
        	<td class="contenidotab">Manejo($)</td> 
            <td>
            	<input id="manejo" name="manejo" class="tex2" value="<? if($_POST['manejo']!='') print $_POST['manejo']; else print $datosmod['manejo']; ?>" maxlength="50" >
            </td>
            <td class="contenidotab">Margen Manejo($)</td> 
            <td>
            	<input id="min_manejo" name="min_manejo" class="tex2" value="<? if($_POST['min_manejo']!='') print $_POST['min_manejo']; else print $datosmod['min_manejo']; ?>" maxlength="50" >
            </td>
        </tr> 
        <tr>
        	<td class="contenidotab">Moneda</td>    
            <td>
                <select id="moneda" name="moneda" class="tex2" >
                    <option value="N"> Seleccione </option>
                    <?
                    if($_POST['moneda']!='') $comparador = $_POST['moneda']; else $comparador = $datosmod['moneda'];                        
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
        	<td  class="contenidotab" style="text-align:center" colspan="8">Observaciones</td>
        </tr>        
        <tr>
            <td align="center" colspan="8">
                <textarea name="observaciones" id="observaciones" class="tex1"  cols="40" rows="3"><? if($_POST['observaciones']!='') print $_POST['observaciones']; else print $datosmod['observaciones']; ?></textarea>
            </td>
        </tr>
	</table>
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
        <td class="tittabla">Proveedor bodega</td> 
        <td class="tittabla">Tarifa ad-valoren/CIF</td>
        <? if($_GET['cl']=='lcl' || $_GET['cl']=='aereo') { ?>
            <td class="tittabla">Minimo Tarifa ad-valoren/CIF</td>
        <? } ?>
        <td class="tittabla">Tarifa<? if($_GET['cl']=='lcl' || $_GET['cl']=='aereo') print ' por mes o fracci&oacute;n'; elseif($_GET['cl']=='fcl') print ' integral para contenedor de 20 por mes o fracci&oacute;n'; ?></td>
        
		<? if($_GET['cl']=='lcl' || $_GET['cl']=='aereo') { ?>
        <td class="tittabla">Minimo Tarifa por mes o fracci&oacute;n</td>
        <? } ?>
        
		<? if($_GET['cl']=='fcl') { ?>
        <td class="tittabla">Tarifa integral para contenedor de 40 por mes o fracci&oacute;n</td> 
        <? } ?>
        
        <td class="tittabla">Manejo de carga x Kg.</td>
        <td class="tittabla">Minimo Manejo de carga x Kg.</td>
        <td class="tittabla">Fecha validez</td> 
        <td class="tittabla">Moneda</td>        
        <td class="tittabla">Observaciones</td>        
    </tr>    
        <?
		$sqlad="select * from bodega where clasificacion='$_GET[cl]' and estado='1'";
		
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
        
		$sqlbg = "select idbodega from cot_bodegas where idcot_temp='$_GET[idcot_temp]'";
		//print $sqlbg.'<br>';
		$exebg = mysqli_query($link,$sqlbg);
		$idbodegas[] = '0';
		while ($datosbg = mysqli_fetch_array($exebg))
		{
			$idbodegas[] = $datosbg['idbodega'];
		}				
     
		for($i=0;$i<$cantpag;$i++)
        {
            $datosad=mysqli_fetch_array($buscarpag);
            ?>  
             <tr>
             	<td class="contenidotab"><input name="registroSel" type="radio" value="<? print $datosad['idbodega']; ?>" onClick="modificarRegistro(<?php print $i;?>)" ></td>
                <td class="contenidotab"><input name="eliSel" type="checkbox" onClick="" value="<? print $datosad['idbodega']; ?>" /></td>
                <td class="contenidotab"><? print scai_get_name("$datosad[idproveedor]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
                <td class="contenidotab"><? print $datosad['advaloren'];?></td>
                <? if($_GET['cl']=='lcl' || $_GET['cl']=='aereo') { ?>
                <td class="contenidotab"><? print $datosad['min_advaloren'];?></td>
                <? } ?>
                <td class="contenidotab"><? print $datosad['mes_fraccion'];?></td>
                <? if($_GET['cl']=='lcl' || $_GET['cl']=='aereo') { ?>
                <td class="contenidotab"><? print $datosad['min_mes_fraccion'];?></td>
                <? } ?>				
                <? if($_GET['cl']=='fcl') { ?>
                <td class="contenidotab"><? print $datosad['mes_fraccion_40'];?></td>
                <? } ?>
                <td class="contenidotab"><? print $datosad['manejo'];?></td>
                <td class="contenidotab"><? print $datosad['min_manejo'];?></td>
                <td class="contenidotab"><? print substr($datosad['fecha_validez'],0 ,10);?></td>
                <td class="contenidotab"><? print scai_get_name("$datosad[moneda]","monedas", "idmoneda", "codigo"); ?></td>
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
            </table>        </td>        	
    </tr>         
</table>			  
</form>
</body>   