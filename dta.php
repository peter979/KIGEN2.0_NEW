<?
	include('sesion/sesion.php');
	include("conection/conectar.php");	
	include_once("permite.php");
	include_once("scripts/recover_nombre.php");

	$tabla = "dta";
	$llave = "iddta";
	error_reporting(5);	
?>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		
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
			function validaEnvia(form){
				form.valor_venta.value = parseFloat(form.valorUn.value) + parseFloat(form.margen.value);
				<?
				if($_GET['cl']=='fcl')
				{
					?>
					form.valor_dev_venta.value = parseFloat(form.valor_dev.value) + parseFloat(form.margen_dev.value);
					<?
				}
				?>
				form.valor_esc_v_venta.value = parseFloat(form.valor_esc_v.value) + parseFloat(form.margen_esc_v.value);
				form.valor_esc_c_venta.value = parseFloat(form.valor_esc_c.value) + parseFloat(form.margen_esc_c.value);
				
				form.datosok.value="si";
				form.submit()
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
		
			function validaPais(form)
			{
				form.nueRegistro.value = 'si';
				form.submit()
			}
		</script>
		<script language="javascript">
		
			function cobra(){
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
			function cambios(){
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
			function show_div(idcapa){//Muestra o oculta capas del filtro de puerto de origen
				capa= document.getElementById("div_"+idcapa);
				
				if(capa.style.display == "none")
					capa.style.display="block";
				else
					capa.style.display="none";
			}
		</script>
		
		<?
		if($_POST['datosok']=='si')
		{
			if($_POST['modRegistro']=="no")
			{
				$queryins="INSERT INTO $tabla (
								idproveedor, 
								idtipoterrestre, 
								puerto_origen, 
								idciudad, 
								nombre, 
								clasificacion, 
								valor, 
								valor_venta, 
								moneda, 
								minimo, 
								fecha_validez, 
								margen, 
								valor_dev, 
								valor_dev_venta, 
								margen_dev, 
								fecha_validez_dev, 
								tiempo_transito_dev, 
								valor_esc_v, 
								valor_esc_v_venta, 
								margen_esc_v, 
								valor_esc_c, 
								valor_esc_c_venta, 
								margen_esc_c, 
								observaciones
							) VALUES (
								'$_POST[idproveedor]', 
								'$_POST[idtipoterrestre]', 
								'$_POST[puerto_origen]', 
								'$_POST[idciudad]', 
								UCASE('$_POST[nombre]'), 
								'$_GET[cl]', 
								UCASE('$_POST[valorUn]'), 
								UCASE('$_POST[valor_venta]'), 
								UCASE('$_POST[moneda]'), 
								UCASE('$_POST[minimo]'), 
								UCASE('$_POST[fecha_validez]'), 
								UCASE('$_POST[margen]'), 
								UCASE('$_POST[valor_dev]'), 
								UCASE('$_POST[valor_dev_venta]'), 
								UCASE('$_POST[margen_dev]'), 
								UCASE('$_POST[fecha_validez_dev]'), 
								UCASE('$_POST[tiempo_transito_dev]'), 
								UCASE('$_POST[valor_esc_v]'), 
								UCASE('$_POST[valor_esc_v_venta]'), 
								UCASE('$_POST[margen_esc_v]'), 
								UCASE('$_POST[valor_esc_c]'), 
								UCASE('$_POST[valor_esc_c_venta]'), 
								UCASE('$_POST[margen_esc_c]'), 
								UCASE('$_POST[observaciones]')
							)";
				//print $queryins.'<br>';
				$buscarins=mysqli_query($link,$queryins);
				
				if(!$buscarins)
					print ("<script>alert('Error al ingresar la tarifa')</script>");
				else
					?><script>alert ('el registro ha sido ingresado satisfactoriamente')</script><?	
			}
			else
			{
				$queryins = "UPDATE $tabla SET 
								idproveedor='$_POST[idproveedor]', 
								puerto_origen='$_POST[puerto_origen]', 
								idciudad='$_POST[idciudad]', 
								nombre=UCASE('$_POST[nombre]'), 
								idtipoterrestre='$_POST[idtipoterrestre]', 
								valor=UCASE('$_POST[valorUn]'), 
								valor_venta=UCASE('$_POST[valor_venta]'), 
								moneda=UCASE('$_POST[moneda]'), 
								minimo=UCASE('$_POST[minimo]'), 
								fecha_validez=UCASE('$_POST[fecha_validez]'), 
								margen=UCASE('$_POST[margen]'), 
								valor_dev=UCASE('$_POST[valor_dev]'), 
								valor_dev_venta=UCASE('$_POST[valor_dev_venta]'), 
								margen_dev=UCASE('$_POST[margen_dev]'), 
								fecha_validez_dev=UCASE('$_POST[fecha_validez_dev]'), 
								tiempo_transito_dev=UCASE('$_POST[tiempo_transito_dev]'), 
								valor_esc_v=UCASE('$_POST[valor_esc_v]'), 
								valor_esc_v_venta=UCASE('$_POST[valor_esc_v_venta]'),
								margen_esc_v=UCASE('$_POST[margen_esc_v]'), 
								valor_esc_c=UCASE('$_POST[valor_esc_c]'), 
								valor_esc_c_venta=UCASE('$_POST[valor_esc_c_venta]'), 
								margen_esc_c=UCASE('$_POST[margen_esc_c]'), 
								observaciones=UCASE('$_POST[observaciones]') 
							WHERE $llave='$_POST[iddtaUn]'";
				
				$buscarins=mysqli_query($link,$queryins);
				
				if(!$buscarins){
					echo $queryins;die();
					print mysqli_error();die();
				}else{
					?><script>alert ('el registro ha sido modificado satisfactoriamente')</script><?
				 }
			}
		}
		
		if($_POST['varelimi']=='si'){
			$queryelim="update $tabla set estado='0' WHERE $llave IN (".str_replace('\\', '', $_POST['listaEliminar']).")";
			$buscarelim=mysqli_query($link,$queryelim);
			if(!$buscarelim)
				print mysqli_error();
			?><script>//document.location.href='<? print $_SERVER['PHP_SELF'];?>'</script><?
		}
		
		if (isset($_POST['idtarifario']))
			$_GET['idtarifario'] == $_POST['idtarifario'];
			
			
		//Almacena los tarifarios modificados desde la tabla
		if($_GET['opc']=="save"){
			for($x=0;$x<= sizeof($_REQUEST['iddta']) - 1;$x++){
				//Total Neta TON/CBM
				$sql = "UPDATE `dta` SET 
						`valor` = '".$_REQUEST['valor'][$x]."', 
						`fecha_validez` = '".$_REQUEST['vigencia'][$x]."' 
					WHERE `iddta` = ".$_REQUEST['iddta'][$x]."; ";
					   
				if(!mysqli_query($link,$sql))
					echo "no almaceno<br>";

					
		
		
			}
			echo "<script>alert('Almaceno');window.location='?cl=".$_GET['cl']."';</script>";
		}

		?>
		
	</head>


<body style="background-color: transparent;">
	<form name="formulario" method="post">
		<input name="datosok" type="hidden" value="no" />
		<input name="varelimi" type="hidden" value="no" />
		<input type="hidden" name="listaEliminar" value="" />
		<input name="xyz" type="hidden" value="" />
		<input name="seleccionados" type="hidden" value="" />
		<input type="hidden" name="nueRegistro" value="no" />
		<? if($_POST['modRegistro'] == "si"){ ?>
			<input type="hidden" name="modRegistro" value="si" /><?
		}else{?>
			<input type="hidden" name="modRegistro" value="no" /><?
		}
		?> 
		<table width="100%" align="center">
			<tr>
				<td align="center" class="subtitseccion" colspan="2">DTA <? print strtoupper($_GET['cl']); ?></td>
			</tr>
		</table>            
		<? if($_POST['nueRegistro'] == "si") 
		{
			if($_POST['modRegistro']=="si")
			{
				$sqlmod = "SELECT * FROM $tabla WHERE $llave='$_POST[registroSel]'";
				//print $sqlmod.'<br>';
				$exemod = mysqli_query($link,$sqlmod);
				$datosmod = mysqli_fetch_array($exemod);
			}
			?>
			<input name="iddtaUn" type="hidden" value="<? echo $datosmod['iddta']; ?>" />
			<table width="100%" align="center">
				<tr>
					<td class="contenidotab">Proveedor terrestre*</td> 
					<td><select id="idproveedor" name="idproveedor" class="tex2" >
					  <option value="N"> Seleccione </option>
						<?
						if($_POST['idproveedor']!='N' && $_POST['idproveedor']!='')
							$comparador = $_POST['idproveedor'];		
						else
							$comparador = $datosmod['idproveedor'];					
						$es="select * from proveedores_agentes where tipo='otm' order by nombre";
						$exe=mysqli_query($link,$es);
						while($row=mysqli_fetch_array($exe))	
						{
							$sel = '';
							if($comparador==$row['idproveedor_agente'])
								$sel = 'selected';
							print "<option value='$row[idproveedor_agente]' $sel>$row[nombre]</option>";
						}
						?>
					</select></td> 
		
					<td class="contenidotab">Nombre*</td> 
					<td>
						<input id="nombre" name="nombre" class="tex2" value="<? if($_POST['nombre']!='') print $_POST['nombre']; else print $datosmod['nombre']; ?>" maxlength="50" >
					</td>
					<?
					if($_GET['cl']=='fcl' ||$_GET['cl']=='lcl' )
					{
						?>
						<td class="contenidotab"><? if($_GET['cl']=='fcl') print 'Tipo'; elseif($_GET['cl']=='lcl') print 'Rango'; ?></td> 
						<td>
							<select id="idtipoterrestre" name="idtipoterrestre" class="tex2" >
								<option value="N"> Seleccione </option>
								<?
								if($_POST['idtipoterrestre']!='N' && $_POST['idtipoterrestre']!='')
									$comparador = $_POST['idtipoterrestre'];		
								else
									$comparador = $datosmod['idtipoterrestre'];					
								$es="select * from tipoterrestre where clasificacion='$_GET[cl]' order by nombre";
								$exe=mysqli_query($link,$es);
								while($row=mysqli_fetch_array($exe))	
								{
									$sel = '';
									if($comparador==$row['idtipoterrestre'])
										$sel = 'selected';
									print "<option value='$row[idtipoterrestre]' $sel>$row[nombre]</option>";
								}
								?>
							</select>
						</td>
						<?
					}
					?>
					<td class="contenidotab">Fecha validez</td>    
					<td>
					<input id="fecha_validez" name="fecha_validez" class="tex2" value="<? if($_POST['fecha_validez']!='') print $_POST['fecha_validez']; else print $datosmod['fecha_validez']; ?>" maxlength="50" readonly>
					<input class="botonesadmin" style="color:#FFFFFF;" onClick="return showCalendar('fecha_validez');" type='reset' value='Calendario' name='reset' />
					</td>
				</tr>
				<tr>
					<td class="contenidotab"><? if($_GET['cl']=='aereo') print 'Aeropuerto Origen'; else print 'Puerto Origen'; ?>*</td>   
					<td>
						<?
							$tipo_puerto = 'puerto';
							if($_GET['cl']=='aereo')
								$tipo_puerto = 'aeropuerto';
								
							if($_POST['puerto_origen']!='N' && $_POST['puerto_origen']!='')
								$comparador = $_POST['puerto_origen'];		
							else
								$comparador = $datosmod['puerto_origen'];
							$es="select * from aeropuertos_puertos where tipo='$tipo_puerto' and idaeropuerto_puerto in (select idaeropuerto_puerto from ciudades_has_aeropuertos_puertos where idciudad in (select idciudad from ciudades where idpais in (select idpais from paises where nombre='colombia'))) order by nombre";
		
							$exe=mysqli_query($link,$es);
						?>
						<select id="puerto_origen" name="puerto_origen" class="tex2" >
							<option value="N"> Seleccione </option>
							<?
		
							while($row=mysqli_fetch_array($exe))
							{
								$sel = "";
								if($comparador==$row['idaeropuerto_puerto'])
									$sel = "selected";
								print "<option value='$row[idaeropuerto_puerto]' $sel>$row[nombre]</option>";
							}
							?>
						</select>
						</td>      
						<? if($_POST['idpais']=='')
						{
							$sqlp = "select idpais from ciudades where idciudad='$datosmod[idciudad]'";
							$exep = mysqli_query($link,$sqlp);
							$datosp = mysqli_fetch_array($exep);
							$_POST['idpais'] = $datosp['idpais'];
						}	
						?>
						<td class="contenidotab">Ciudad</td>   
						<td>
							<select id="idciudad" name="idciudad" class="tex2" >
								<option value="N"> Seleccione </option>
								<?
								$es = "select * from ciudades where idpais in (select idpais from paises where nombre='colombia') order by nombre"; 
								$exe=mysqli_query($link,$es);
								if($_POST['idciudad']!='N' && $_POST['idciudad']!='')
									$comparador = $_POST['idciudad'];
								else
									$comparador = $datosmod['idciudad']; 
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
						 <td class="contenidotab">Moneda</td> 
					<td>
						<select id="moneda" name="moneda" class="tex2" >
							<option value="N"> Seleccione </option>
							<?
							if($_POST['moneda']!='N' && $_POST['moneda']!='')
								$comparador = $_POST['moneda'];		
							else
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
					<td class="contenidotab">Valor <? if($_GET['cl']=='lcl') print 'W/M'; ?>($)</td> 
					<td>
						<input id="valorUn" name="valorUn" class="tex2" value="<? print $datosmod['valor']; ?>" maxlength="50" >
						<input name="valor_venta" type="hidden" value="" />
					</td>
				</tr>
				<tr>
					<td class="contenidotab">Margen($)</td> 
					<td>
						<input id="margen" name="margen" class="tex2" value="<? if($_POST['margen']!='') print $_POST['margen']; else print $datosmod['margen']; ?>" maxlength="50" >
					</td>                      
					<?
					if($_GET['cl']=='lcl'){	 ?>
						<td class="contenidotab">M&iacute;nimo($)</td> 
						<td>
							<input id="minimo" name="minimo" class="tex2" value="<? if($_POST['minimo']!='') print $_POST['minimo']; else print $datosmod['minimo']; ?>" maxlength="50" >
						</td>            
						<?
					}
					elseif($_GET['cl']=='fcl'){
						?>
						<input type="hidden" id="minimo" name="minimo" value="">
						<?
					}
					?>
				</tr>
				<tr>
					<td  class="contenidotab" style="text-align:center" colspan="8">Observaciones</td>
				</tr>
				<tr>
					<td align="center" colspan="8"><textarea name="observaciones" id="observaciones" class="tex1"  cols="40" rows="3"><? if($_POST['observaciones']!='') print $_POST['observaciones']; else print $datosmod['observaciones']; ?></textarea>            </td>
				</tr>
		
				<?
				if($_GET['cl']=='fcl')
				{	
					?>
					<tr>
						<td class="subtitseccion" style="text-align:left" colspan="6">Devoluci&oacute;n contenedor</td>
					</tr>
					<tr>
						<td class="contenidotab">Valor($)</td>
						<td>
							<input id="valor_dev" name="valor_dev" class="tex2" value="<? if($_POST['valor_dev']!='') print $_POST['valor_dev']; else print $datosmod['valor_dev']; ?>" maxlength="50" >
							<input name="valor_dev_venta" type="hidden" value="" />
						</td>
						<td class="contenidotab">Margen($)</td>
						<td>
							<input id="margen_dev" name="margen_dev" class="tex2" value="<? if($_POST['margen_dev']!='') print $_POST['margen_dev']; else print $datosmod['margen_dev']; ?>" maxlength="50" >
						</td>
						<td class="contenidotab">Tiempo de transito</td>
						<td>
							<input id="tiempo_transito_dev" name="tiempo_transito_dev" class="tex2" value="<? if($_POST['tiempo_transito_dev']!='') print $_POST['tiempo_transito_dev']; else print $datosmod['tiempo_transito_dev']; ?>" maxlength="50" >
						</td>
						<input type="hidden" id="fecha_validez_dev" name="fecha_validez_dev" class="tex2" value="">
					</tr>
					<?
				}elseif($_GET['cl']=='lcl'){
					?>
					<input type="hidden" id="valor_dev" name="valor_dev" class="tex2" value="">
					<input type="hidden" id="margen_dev" name="margen_dev" class="tex2" value="">
					<input type="hidden" id="fecha_validez_dev" name="fecha_validez_dev" class="tex2" value="">
					<input type="hidden" id="tiempo_transito_dev" name="tiempo_transito_dev" class="tex2" value="">
					<?
				}
				?>
				<tr>
				<tr>
					<td class="subtitseccion" style="text-align:left" colspan="6">Servicio de escoltas por ciudades</td>
				</tr>
				<tr>
					<td class="contenidotab">Vehicular</td>  
					<td class="contenidotab">Valor($)</td>
					<td>
						<input id="valor_esc_v" name="valor_esc_v" class="tex2" value="<? if($_POST['valor_esc_v']!='') print $_POST['valor_esc_v']; else print $datosmod['valor_esc_v']; ?>" maxlength="50" >
						<input name="valor_esc_v_venta" type="hidden" value="" />
					</td>
					<td class="contenidotab">Margen($)</td>
					<td>
						<input id="margen_esc_v" name="margen_esc_v" class="tex2" value="<? if($_POST['margen_esc_v']!='') print $_POST['margen_esc_v']; else print $datosmod['margen_esc_v']; ?>" maxlength="50" >
					</td>
				</tr>
				<tr>
					<td class="contenidotab">Cabina</td>
					<td class="contenidotab">Valor($)</td>
					<td>
						<input id="valor_esc_c" name="valor_esc_c" class="tex2" value="<? if($_POST['valor_esc_c']!='') print $_POST['valor_esc_c']; else print $datosmod['valor_esc_c']; ?>" maxlength="50" >
						<input name="valor_esc_c_venta" type="hidden" value="" />
					</td>
					<td class="contenidotab">Margen($)</td>
					<td>
						<input id="margen_esc_c" name="margen_esc_c" class="tex2" value="<? if($_POST['margen_esc_c']!='') print $_POST['margen_esc_c']; else print $datosmod['margen_esc_c']; ?>" maxlength="50" >
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
		<!--Inicia Filtros-->
		<table align="center" class="contenidotab" width="70%">     	
			<tr align="center">
				<td class="tit_vueltas" align="center">
					
					Vencidas
					<select name="vencidas" class="Ancho_120px" id="vencidas">
						<option value="N">Seleccione</option>
						<option value="1" <? if($_POST['vencidas']=='1') print 'selected'; ?> >SI</option>
						<option value="0" <? if($_POST['vencidas']=='0') print 'selected'; ?> >NO</option>
					</select>&nbsp;&nbsp;&nbsp;
				</td>
				<td> 
					Proveedor<input name="fproveedor" id="fproveedor" class="tex3" type="text" value="<? print $_GET['fproveedor']?>"> &nbsp;&nbsp;&nbsp;
				</td>
				<td> 
					Origen            	
					<input type="text" name="origen" value="<? echo $_POST['origen']?>">
				<td>
				<td>
					<input type='hidden' value='hidden' name='buscar2' />	
					&nbsp;&nbsp;&nbsp;Destino
					<select name="fdestino" class="tex3" id="fdestino" >
					
						<option value="N"> Seleccione </option>
							<?
							$sqlfciud="select idciudad, idpais, nombre from ciudades order by nombre";
							$exefciud=mysqli_query($link,$sqlfciud);
							while($row=mysqli_fetch_array($exefciud))
							{
								$sel = "";
								if($_GET['fdestino']==$row['idciudad'])
									$sel = "selected";
								$nombre = scai_get_name("$row[idciudad]","ciudades", "idciudad", "nombre");
								$nombrepais=scai_get_name("$row[idpais]","paises", "idpais", "nombre");
								print "<option value='$row[idciudad]' $sel>$nombre - $nombrepais</option>";
							}
							?>
					</select>
				</td>
				</tr>
				<tr>
					<td colspan="5" align="center">
						
						<input type="submit" class="botonesadmin" value="Buscar">
			
						<input class="botonesadmin" style="color:#FFFFFF;" onClick="document.location = '<? print $_SERVER['PHP_SELF']; ?>?cl=<? print $_GET['cl']; ?>';" type='button' value='Limpiar filtros' name='limp_fil'/>	 
				</td>
			</tr> 
		</table>
		<!--Termina los filtros-->
		<br> 
				 
		<table width="100%"> 
			<tr>
				<td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Mod</td>
				<td class="tittabla"><img src="images/ico_eliminar.gif" width="8" height="9">Elim</td>
				<td class="tittabla">Proveedor terrestre</td> 
				<td class="tittabla">Nombre</td>
				
				<? if($_GET['cl']=='fcl' || $_GET['cl']=='lcl') { ?>
				<td class="tittabla"><? if($_GET['cl']=='fcl') print 'Tipo'; elseif($_GET['cl']=='lcl') print 'Rango'; ?></td> 
				<? } ?>
							   
				<td class="tittabla"><? if($_GET['cl']=='aereo') print 'Aeropuerto Origen'; else print 'Puerto Origen'; ?></td>
				<td class="tittabla">Ciudad Destino</td>
				<td class="tittabla">Valor</td>
				<td class="tittabla">Fecha validez</td>
				<td class="tittabla">Margen</td>
				<td class="tittabla">Observaciones</td>
			</tr>    
			<?
			$sqlad="select * from dta where clasificacion='$_GET[cl]' and estado='1'";
			

			if($_POST['vencidas']=='1')
				$sqlad .= " and (fecha_validez between NOW() and DATE_ADD(NOW(), INTERVAL 5 DAY) or fecha_validez < NOW())";
			elseif($_POST['vencidas']=='0')
				$sqlad .= " and fecha_validez not between NOW() and DATE_ADD(NOW(), INTERVAL 5 DAY) and fecha_validez > NOW()";
			if($_POST['fproveedor'])
				$sqlad.="and idproveedor in (select idproveedor_agente from proveedores_agentes where nombre like '%$_POST[fproveedor]%')";
			
			if($_POST['origen']){
				$sqlad.=" and puerto_origen in(select idaeropuerto_puerto from aeropuertos_puertos where nombre like '%".$_POST["origen"]."%')";
			}
				
			
			if($_POST['fdestino'] && $_POST['fdestino']!='N')
				$sqlad.=" and idciudad ='$_POST[fdestino]'";

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
			$sqlpag = $sqlad;
			
			$buscarpag=mysqli_query($link,$sqlpag);
			$cantpag=mysqli_num_rows($buscarpag);
			for($i=0;$i<$cantpag;$i++)
			{
				$datosad=mysqli_fetch_array($buscarpag);
				?>  
				 <tr>                   
					<td class="contenidotab"><input name="registroSel" type="radio" value="<? print $datosad['iddta']; ?>" onClick="modificarRegistro(<?php print $i;?>)" ></td>
					<td class="contenidotab"><input name="eliSel" type="checkbox" onClick="" value="<? print $datosad['iddta']; ?>" /></td>
					<td class="contenidotab"><? print scai_get_name("$datosad[idproveedor]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
					<td class="contenidotab"><? print $datosad['nombre'];?></td>
					
					<? if($_GET['cl']=='fcl' || $_GET['cl']=='lcl') { ?>
					<td class="contenidotab"><? print scai_get_name("$datosad[idtipoterrestre]", "tipoterrestre", "idtipoterrestre", "nombre");?></td>
					<? } ?>
					
					<td class="contenidotab"><? print scai_get_name("$datosad[puerto_origen]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");?></td>
					<td class="contenidotab"><? print scai_get_name("$datosad[idciudad]", "ciudades", "idciudad", "nombre");?></td>
					<td class="contenidotab">
						<input type="hidden" name="iddta[]" value="<? echo $datosad['iddta'] ?>" />
						<input type="text" name="valor[]" value="<? print ($datosad['valor']);?>" class="contenidotab" style="width:50px" />
					</td>
					<td class="contenidotab">
						<input type="text" id="vigencia[<? echo $x?>]" name="vigencia[]" value="<? print substr($datosad['fecha_validez'],0,10); ?>" class="contenidotab" onClick="return showCalendar('vigencia[<? echo $x?>]');" readonly="true" >

					</td>
					<td class="contenidotab"><? print $datosad['margen'];?></td>
					<td class="contenidotab"><? print $datosad['observaciones'];?></td>
				</tr>          
			<?
			$x++;
			}
			?> 
			<tr>
				<td colspan="5" align="center">
					<table>
						<tr>
							<? if(puedo("c","TARIFARIO")==1) { ?>                        
							<td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="nuevoRegistro();">Agregar</a></td>
							<td width="60" class="botonesadmin"><a href="#" onClick="javascript:formulario.action='?opc=save&cl=<? echo $_GET['cl']?>';formulario.submit()">Guardar</a></td>
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