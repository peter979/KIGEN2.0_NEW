<?
	include('sesion/sesion.php');
	include("conection/conectar.php");	
	include_once("permite.php");
	include_once("scripts/recover_nombre.php");
	include('./scripts/scripts.php');


	$tabla = "recargos_origen";
	$llave = "idrecargo_origen";
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
		
		form.valor_venta.value = parseFloat(form.valor.value) + parseFloat(form.margen.value);
		form.minimo_venta.value = parseFloat(form.minimo.value) + parseFloat(form.margen_minimo.value);
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
	}
	
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
	function haber(filtre, filtre2, filtre3)
	{
		var capa_eyes = window.document.getElementById("eyes2");
		//solicita = new XMLHttpRequest();
		solicita = cobra();
		solicita.open("POST", "search_vuelta.php", true);
		solicita.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		solicita.send("nav="+filtre+"&origen="+filtre2+"&destination="+filtre3);
		solicita.onreadystatechange = cambios;
	}
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
	
	}*/
	</script>
</head>

<?
if($_POST['datosok']=='si')
{
	if($_POST['modRegistro']=="no")  
	{
		$queryins="INSERT INTO $tabla (
					idagente, 
					nombre, 
					clasificacion, 
					tipo, 
					valor, 
					minimo, 
					moneda, 
					fecha_validez, 
					observaciones, 
					margen, 
					margen_minimo, 
					valor_venta, 
					minimo_venta
				)VALUES (
					'$_POST[idagente]', 
					UCASE('$_POST[nombre]'), 
					'lcl', 
					'$_POST[tipo]', 
					UCASE('$_POST[valor]'), 
					'$_POST[minimo]', 
					UCASE('$_POST[moneda]'), 
					UCASE('$_POST[fecha_validez]'), 
					UCASE('$_POST[observaciones]'), 
					'$_POST[margen]', 
					'$_POST[margen_minimo]', 
					'$_POST[valor_venta]', 
					'$_POST[minimo_venta]'
				)";

		
		if(!mysqli_query($link,$queryins))
			print ("<script>alert('Error al ingresar la tarifa')</script>");
		else
			?><script>alert ('el registro ha sido ingresado satisfactoriamente')</script><?	
	}
	else
	{
		$queryins = "UPDATE $tabla SET 
						idagente='$_POST[idagente]', 
						nombre=UCASE('$_POST[nombre]'), 
						tipo='$_POST[tipo]', 
						valor=UCASE('$_POST[valor]'), 
						minimo='$_POST[minimo]', 
						moneda=UCASE('$_POST[moneda]'), 
						fecha_validez=UCASE('$_POST[fecha_validez]'), 
						observaciones=UCASE('$_POST[observaciones]'), 
						margen='$_POST[margen]', 
						margen_minimo='$_POST[margen_minimo]', 
						valor_venta='$_POST[valor_venta]', 
						minimo_venta='$_POST[minimo_venta]' 
					WHERE $llave='$_POST[idrecargo_origen]'";

		if(!mysqli_query($link,$queryins))
			print mysqli_error();
		else
			?><script>alert ('el registro ha sido modificado satisfactoriamente')</script><?
	}
}

if($_POST['varelimi']=='si'){
	$queryelim="update $tabla set estado='0' WHERE $llave IN (".str_replace('\\', '', $_POST['listaEliminar']).")";
	$buscarelim=mysqli_query($link,$queryelim);
	if(!$buscarelim)
		print mysqli_error();
	?><script>//document.location.href='<? print $_SERVER['PHP_SELF'];?>'</script><?
}
/*
if (isset($_POST['idtarifario']))
	$_GET['idtarifario'] == $_POST['idtarifario'];*/
?>
<body style="background-color: transparent;">
	<form name="formulario" method="post">
		<input name="datosok" type="hidden" value="no" />
		<input name="varelimi" type="hidden" value="no" />
		<input type="hidden" name="listaEliminar" value="" />
		<!--<input name="xyz" type="hidden" value="" />-->
		<input name="seleccionados" type="hidden" value="" />
		<input type="hidden" name="nueRegistro" value="no" />
		<? if($_POST['modRegistro'] == "si"){?>
			<input type="hidden" name="modRegistro" value="si" />
		<?
		}else{
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
					print ("<script>document.location.href='".$_SERVER['PHP_SELF']."?idrecargo_origen=$row[idrecargo_origen]'</script>");
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
								print "<a href=".$_SERVER['PHP_SELF']."?idrecargo_origen=$row[idrecargo_origen]>$row[num_contrato]</a><br>";
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
				<td align="center" class="subtitseccion" colspan="2"><? print "REGARGOS DE ORIGEN LCL"; ?></td>
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
			<!--Formulario de Edicion y CReacion-->
			<input name="idrecargo_origen" type="hidden" value="<? print $datosmod['idrecargo_origen'] ?>" />
			<table width="100%" align="center">        
				<tr>
					<td class="contenidotab">Nombre*</td> 
					<td>
						<input id="nombre" name="nombre" class="tex2" value="<? print $datosmod['nombre']; ?>" maxlength="50" >
					</td> 
				</tr>
				<tr>
					<td class="contenidotab">Agente</td>    
					<td>
						<select id="idagente" name="idagente" class="tex2" >
							<option value="N"> Seleccione </option>
							<?
							$es="select * from proveedores_agentes where tipo='agente' order by nombre";
							$exe=mysqli_query($link,$es);
							while($row=mysqli_fetch_array($exe))	
							{
								$sel = '';
								if($datosmod['idagente']==$row['idproveedor_agente'])
									$sel = 'selected';
								print "<option value='$row[idproveedor_agente]' $sel>$row[nombre]</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr>    
					<td class="contenidotab">Tipo*</td>    
					<td>
						<select id="tipo" name="tipo" class="tex2" >
							<option value="N"> Seleccione </option>
							<option value='hbl' <? if($datosmod['tipo']=='hbl') print 'selected'?> >HBL</option>
							<option value='wm' <? if($datosmod['tipo']=='wm') print 'selected'?> >WM</option>
							<option value='kilo' <? if($datosmod['tipo']=='kilo') print 'selected'?> >KILO</option>
						</select>
					</td> 
				</tr>
				<tr>    
					<td class="contenidotab">Valor</td> 
					<td>
						<input id="valor" name="valor" class="tex2" value="<? print ($datosmod['valor']) ? $datosmod['valor'] : 0; ?>" maxlength="50" >
						<input type="hidden" id="valor_venta" name="valor_venta" >
					</td>
				</tr>
				<tr>    
					<td class="contenidotab">Margen</td> 
					<td>
						<input id="margen" name="margen" class="tex2" value="<? print ($datosmod['margen']) ? $datosmod['margen'] : 0; ?>" maxlength="50" >
					</td>
				</tr>
				<tr>    
					<td class="contenidotab">Minimo</td> 
					<td>
						<input id="minimo" name="minimo" class="tex2" value="<? print ($datosmod['minimo']) ? $datosmod['minimo'] : 0 ; ?>" maxlength="50" >
						<input type="hidden" id="minimo_venta" name="minimo_venta" >
					</td>
				</tr>
				<tr>    
					<td class="contenidotab">Margen Minimo</td> 
					<td>
						<input id="margen_minimo" name="margen_minimo" class="tex2" value="<? print ($datosmod['margen_minimo']) ? $datosmod['margen_minimo'] :0; ?>" maxlength="50" >
					</td>
				</tr>
				<tr>   
					<td class="contenidotab">Moneda</td> 
					<td>
						<select id="moneda" name="moneda" class="tex2" >
							<option value="N"> Seleccione </option>
							<?
							$comparador = $datosmod['moneda'];					
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
					<td class="contenidotab">Fecha validez</td>    
					<td>
					<input id="fecha_validez" name="fecha_validez" class="tex2" value="<? print $datosmod['fecha_validez']; ?>" maxlength="50" onClick="return showCalendar('fecha_validez');"  readonly>
		
					</td>
				</tr>
				<tr>    
					<td class="contenidotab">Observaciones</td> 
					<td><textarea name="observaciones" id="observaciones" class="tex1"  cols="40" rows="6"><? print $datosmod['observaciones']; ?></textarea>
					</td>            
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
			<br>
		<?
		}	
		?>
		<!--Filtros-->
		<table width="90%" align="center">
			<tr>
				<td class="contenidotab">Agente</td>    
				<td>
					<select id="filtro1" name="filtro1" class="tex2" >
						<option value="N"> Seleccione </option>
						<?
						$es="select * from proveedores_agentes where tipo='agente' order by nombre";
						$exe=mysqli_query($link,$es);
						while($row=mysqli_fetch_array($exe))	
						{
							$sel = '';
							if($_GET['filtro1']==$row['idproveedor_agente'])
								$sel = 'selected';
							print "<option value='$row[idproveedor_agente]' $sel>$row[nombre]</option>";
						}
						?>
					</select>
				</td>
				<td class="contenidotab">Nombre</td> 
				<td>
					<? $_GET['filtro2'] = str_replace("\\", "", $_GET['filtro2']); ?>
					<input id="filtro2" name="filtro2" class="tex2" value="<? print $_GET['filtro2']; ?>" maxlength="50" >
				</td> 
				<td class="contenidotab">Tipo</td>    
				<td>
					<select id="filtro3" name="filtro3" class="tex2" >
						<option value="N"> Seleccione </option>
						<option value='hbl' <? if($_GET['filtro3']=='hbl') print 'selected'?> >HBL</option>
						<option value='wm' <? if($_GET['filtro3']=='wm') print 'selected'?> >WM</option>
						<option value='kilo' <? if($_GET['filtro3']=='kilo') print 'selected'?> >KILO</option>
					</select>
				</td>
			</tr>
			<tr> 
				<td class="contenidotab">Moneda</td> 
				<td>
					<select id="filtro4" name="filtro4" class="tex2" >
						<option value="N"> Seleccione </option>
						<?
						$es="select * from monedas order by nombre";
						$exe=mysqli_query($link,$es);
						while($row=mysqli_fetch_array($exe))	
						{
							$sel = '';
							if($_GET['filtro4']==$row['idmoneda'])
								$sel = 'selected';
							print "<option value='$row[idmoneda]' $sel>$row[codigo]-$row[nombre]</option>";
						}
						?>
					</select>
				</td>
				<td class="contenidotab">Fecha validez incio</td>    
				<td>
				<input id="filtro5" name="filtro5" class="tex2" value="<? print $_GET['filtro5']; ?>" maxlength="50" onClick="return showCalendar('filtro5');" readonly>
		
				</td>
				<td class="contenidotab">Fecha validez fin</td>    
				<td>
				<input id="filtro6" name="filtro6" class="tex2" value="<? print $_GET['filtro6']; ?>" maxlength="50" onClick="return showCalendar('filtro6');" readonly>
		
				</td>   
			</tr>
			<tr>	
				<td class="tit_vueltas" align="center" colspan="6">
					<input name="boton" class="botonesadmin" style="color:#FFFFFF;" value="Buscar" type="button" onClick="document.location = '<? print $_SERVER['PHP_SELF']; ?>?filtro1=' + document.forms[0].filtro1.value + '&filtro2=' + document.forms[0].filtro2.value + '&filtro3=' + document.forms[0].filtro3.value + '&filtro4=' + document.forms[0].filtro4.value + '&filtro5=' + document.forms[0].filtro5.value + '&filtro6=' + document.forms[0].filtro6.value + '&cl=<? print $_GET['cl']?>';">
				&nbsp;<input name="boton2" class="botonesadmin" style="color:#FFFFFF;" value="Restablecer filtros" type="button" onClick="document.location = '<? print $_SERVER['PHP_SELF']; ?>?cl=<? print $_GET['cl']?>';">
				</td>
			</tr>
		</table>  
		<br>  
		<!--Termina Filtros-->
		
		
		<!--Tabla Principal-->
		<table width="100%"> 
			<tr>
				<td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Mod</td>
				<td class="tittabla"><img src="images/ico_eliminar.gif" width="8" height="9">Elim</td> 
				<td class="tittabla">Nombre</td>
				<td class="tittabla">Agente</td>
				<td class="tittabla">Moneda</td>
				<td class="tittabla">Valor</td>
				<td class="tittabla">Minimo</td>
				<td class="tittabla">Tipo</td>
				<td class="tittabla">Fecha validez</td>
				<td class="tittabla">Observaciones</td>               
			</tr>    
				<?
				$sqlad="select * from recargos_origen where clasificacion='lcl'";
				$sqlad .= " and estado='1'";
				
				if ($_GET['filtro1']!='' && $_GET['filtro1']!='N')
				$sqlad .= " AND  idagente='$_GET[filtro1]'";
				if ($_GET['filtro2']!='')
				$sqlad .= " AND nombre like '%$_GET[filtro2]%'";
				if ($_GET['filtro3']!='' && $_GET['filtro3']!='N')
				$sqlad .= " AND  tipo='$_GET[filtro3]'";
				if ($_GET['filtro4']!='' && $_GET['filtro4']!='N')
				$sqlad .= " AND  moneda='$_GET[filtro4]'";		
				if ($_GET['filtro5']!='' && $_GET['filtro6']!='' && $_GET['filtro5']!='0000-00-00' && $_GET['filtro6']!='0000-00-00')
				$sqlad .= " AND fecha_validez BETWEEN '$_GET[filtro5]' AND '$_GET[filtro6]'";
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
						<td class="contenidotab"><input name="registroSel" type="radio" value="<? print $datosad['idrecargo_origen']; ?>" onClick="modificarRegistro(<?php print $i;?>)" ></td>
						<td class="contenidotab"><input name="eliSel" type="checkbox" onClick="" value="<? print $datosad['idrecargo_origen']; ?>" /></td>                <td class="contenidotab"><? print $datosad['nombre'];?></td>
						<td class="contenidotab"><? print scai_get_name("$datosad[idagente]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
						<td class="contenidotab"><? print scai_get_name("$datosad[moneda]","monedas", "idmoneda", "codigo");?></td>
						<td class="contenidotab"><? print $datosad['valor'];?></td>
						<td class="contenidotab"><? print $datosad['minimo'];?></td>
						<td class="contenidotab"><? print $datosad['tipo'];?></td>
						<td class="contenidotab"><? print $datosad['fecha_validez'];?></td>
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
		<br>
		
		
		<!--Paginacion!-->
		<table width="40%" cellspacing="10" align="center" style="text-align:center">
			<tr class="tittabla">
				<td colspan="5"><img src="images/ico_paginas.gif" alt="Paginacion" width="15" height="12" align="absmiddle"> Paginaci&oacute;n</td>
			</tr>
			<tr>
				<td class="tittabla"><a href="#" onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=1';">&lt;&lt;</a></td>
				<td class="tittabla">
					<a href="#" <?php if ($pag != 1) { ?> onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=<?php print ($pag - 1); ?>'" style="cursor:pointer;"<?php } ?>>&lt;</a>
				</td>
				<td>
					<select name="pag" class="combofecha" onChange="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=' + document.forms[0].pag.value;">
					  <?php
						for ($i=1; $i<=$totpag; $i++)
						{
							if ($i == $pag)
								print "<option value=$i selected>$i</option>";
							else
								print "<option value=$i>$i</option>";
						}?>
					</select>
				</td>
				<td class="tittabla">
					<a href="#" <?php if ($pag != $totpag) { ?> onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=<?php print ($pag + 1); ?>';" style="cursor:pointer;"<?php } ?> >&gt;</a>
				</td>
				<td class="tittabla"> 
					<a href="#" onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=<?php print $totpag; ?>';">&gt;&gt;</a>
				</td>
			</tr>
		</table>
		
				  
	</form>
</body>   