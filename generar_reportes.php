<? if($_GET['opc']=="excel"){
			Header("Content-Disposition: inline; filename=".$_POST['name']);
			Header("Content-Description: PHP3 Generated Data"); 
			Header("Content-type: application/vnd.ms-excel; name='Sideris'");//comenta esta linea para ver la salida en web
}
	include('sesion/sesion.php');
	include("conection/conectar.php");	
	include_once("permite.php");
	include_once("scripts/recover_nombre.php");
	include("scripts/prepare_clients_list.php");
	include('scripts/scripts.php'); 
	$sesi=session_id();
?>

<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/main.js"></script>
<script type="text/javascript" src="./js/shadowbox-base.js"></script>
<script type="text/javascript" src="./js/shadowbox.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.1.pack.js" ></script>
<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="./js/funciones.js"></script>
<script type="text/javascript" src="./js/funcionesValida.js"></script>



<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="css/admin_internas.css" rel="stylesheet" type="text/css">
		<!--FUNCION DE MOSTRAR RESULTADOS MIENTRAS SE ESCRIBE, PARA TEXT RAZON SOCIAL-->
		<script type="text/javascript" src="js/clients_list.js"></script>

	</head>

<body style="background-color: transparent;">
<form name="formulario" method="post" action="">
	<?
		$sqlad = "select * from cot_temp where 1 ";
		$sqlad .= ($_POST['tipo']) ? "AND  clasificacion='".$_POST['tipo']."' " : "";	
		$sqlad .= ($_POST['cliente']) ? "AND idcliente in (select idcliente from clientes where nombre like '%".$_POST['cliente']."%') " : "";
		$sqlad .= ($_POST['comercial']) ? "AND idusuario='".$_POST['comercial']."' " : "";
		/*$sqlad .= ($_POST['v_ini']) ? "AND vigencia > '".$_POST['v_ini']."' " : "";
		$sqlad .= ($_POST['v_fin']) ? "AND vigencia < '".$_POST['v_fin']."' " : "";*/
		$sqlad .= ($_POST['otm']=='1') ? "AND idcot_temp in (select idcot_temp from cot_otm) " : "";
		$sqlad .= ($_POST['seguro']=='1') ? "AND idcot_temp in (select idcot_temp from cot_seg) " : "";
		$sqlad .= ($_POST['aduana']=='1') ? "AND idcot_temp in (select idcot_temp from cot_adu) " : "";
		$sqlad .= ($_POST['otm']=='0') ? " AND idcot_temp not in (select idcot_temp from cot_otm)" : "";
		$sqlad .= ($_POST['seguro']=='0') ? " AND idcot_temp not in (select idcot_temp from cot_seg)" : "";
		$sqlad .= ($_POST['aduana']=='0') ? "AND idcot_temp not in (select idcot_temp from cot_adu) " : "";
		$sqlad .= ($_POST['n_coti']!='') ? "AND numero like '%".$_POST['n_coti']."%' " : "";
		$sqlad .= ($_POST['estado']) ? " AND  estado='".$_POST['estado']."'" : "";
		$sqlad .= ($_POST['resultado']) ? "AND  resultado='".$_POST['resultado']."' " : "";
		$sqlad .= ($_POST['origen']) ? "AND idcot_temp in (select idcot_temp from cot_fletes where idtarifario in (select idtarifario from tarifario where puerto_origen='".$_POST['origen']."')) " : "";
		
		$sqlad .= ($_POST['destino']) ? "AND idcot_temp in (select idcot_temp from cot_fletes where idtarifario in (select idtarifario from tarifario where puerto_destino='".$_POST['destino']."')) " : "";

		$noDiasMesAnt = intval(date("t",date("m", strtotime("- 1 month"))));
		$sqlad .= ($_POST["f_ini"]) ?  " AND fecha_hora BETWEEN '".$_POST["f_ini"]."' AND '".$_POST["f_fin"]."'" :  " AND fecha_hora BETWEEN '".date("Y-m-1",strtotime("- 1 month"))."' AND '".date("Y-m-$noDiasMesAnt",strtotime("- 1 month"))."'";
		$sqlad .= " order by fecha_hora desc";
			
			
		$exead=mysqli_query($link,$sqlad);
		$cant=mysqli_num_rows($exead);
		?>
		
	<?

	if($_GET['opc'] != "excel"){ ?>
		<!--Incia Filtros-->
		<table width="100%" align="center" class="contenidotab" cellpadding="10">     
			<tr>
				<td class="subtitseccion" style="text-align:center" colspan="4">GENERAR REPORTES<br><br></td>
			</tr>
			<tr>
			  <td align="center">            
					Fecha&nbsp;
					Inicio&nbsp;
					<input name="f_ini" id="f_ini" type="text" value="<? print ($_POST['f_ini']) ? $_POST['f_ini'] : date("Y-m-1",strtotime("- 1 month")) ;?>" maxlength="70" size="9" readonly onClick="return showCalendar('f_ini');">
		
				Fin&nbsp;<input name="f_fin" id="f_fin"  type="text" value="<? print ($_POST['f_fin']) ? $_POST['f_fin'] : date("Y-m-$noDiasMesAnt",strtotime("- 1 month")) ?>" maxlength="70" size="9" readonly onClick="return showCalendar('f_fin');"></td>
			</tr>	
			<tr align="center">
				<td class="tit_vueltas" align="center">
					N&uacute;mero de cotizaci&oacute;n&nbsp;
					<input name="n_coti" id="n_coti"  class="tex3" type="text" value="<? print $_POST['n_coti']?>" maxlength="70" size="15">       
					Cliente&nbsp;
			  <input name="cliente" id="cliente" type="text" value="<? print $_POST['cliente']?>" maxlength="70" onKeyUp="Complete(this, event)" size="20">
		  
					Comercial&nbsp;
					<select name="comercial" style="width:75px" id="comercial">
						<option></option>
						<?
						$es="select idusuario, nombre from usuarios order by nombre";
						$exe=mysqli_query($link,$es);
						while($row=mysqli_fetch_array($exe))
						{
							$sel = "";
							if($_POST['comercial']==$row['idusuario'])
								$sel = "selected";
							$nombre = scai_get_name("$row[idusuario]","vendedores_customer", "idusuario", "nombre");
							print "<option value='$row[idusuario]' $sel>$nombre</option>";
						}
						?>
					</select>			
					Tipo&nbsp;
					<select name="tipo" class="Ancho_120px" id="tipo">
						<option></option>
						<option value="fcl" <? if($_POST['tipo']=='fcl') print 'selected'; ?> >FCL</option>
						<option value="lcl" <? if($_POST['tipo']=='lcl') print 'selected'; ?> >LCL</option>
						<option value="aereo" <? if($_POST['tipo']=='aereo') print 'selected'; ?> >AEREO</option>
					</select>            
				</td>
			</tr>
			<tr align="center" nowrap>
				<td>
					OTM&nbsp;
					<select name="otm" class="Ancho_120px" id="otm">
						<option></option>
						<option value="1" <? if($_POST['otm']=='1') print 'selected'; ?> >SI</option>
						<option value="0" <? if($_POST['otm']=='0') print 'selected'; ?> >NO</option>
					</select>
					Seguro&nbsp;
					<select name="seguro" class="Ancho_120px" id="seguro">
						<option></option>
						<option value="1" <? if($_POST['seguro']=='1') print 'selected'; ?> >SI</option>
						<option value="0" <? if($_POST['seguro']=='0') print 'selected'; ?> >NO</option>
					</select>
					Aduana&nbsp;
					<select name="aduana" class="Ancho_120px" id="aduana">
						<option></option>
						<option value="1" <? if($_POST['aduana']=='1') print 'selected'; ?> >SI</option>
						<option value="0" <? if($_POST['aduana']=='0') print 'selected'; ?> >NO</option>
					</select>           
					 
					Estado&nbsp;
					<select name="estado" class="Ancho_120px" id="estado">
						<option></option>
						<option value="en_proceso" <? if($_POST['estado']=='en_proceso') print 'selected'; ?> >en_proceso</option>
						<option value="terminada" <? if($_POST['estado']=='terminada') print 'selected'; ?> >Seguimiento</option>
					</select>
					Resultado&nbsp;
					<select name="resultado" class="Ancho_120px" id="resultado">
						<option></option>
						<option value="exitosa" <? if($_POST['resultado']=='exitosa') print 'selected'; ?> >Exitosa</option>
						<option value="no_exitosa" <? if($_POST['resultado']=='no_exitosa') print 'selected'; ?> >No Exitosa</option>
					</select>        
					Origen&nbsp;
					<select id="origen" name="origen" class="tex2" >
						<option></option>
						<?
						$es="select * from aeropuertos_puertos where tipo='puerto' order by nombre";
						$exe=mysqli_query($link,$es);
						while($row=mysqli_fetch_array($exe))
						{
							$sel = "";
							if($_POST['origen']==$row['idaeropuerto_puerto'])
								$sel = "selected";
							print "<option value='$row[idaeropuerto_puerto]' $sel>$row[nombre]</option>";
						}
						?>
					</select>
					Destino&nbsp;
					<select id="destino" name="destino" class="tex2" >
						<option></option>
						<?
						$es="select * from aeropuertos_puertos where tipo='puerto' order by nombre";
						$exe=mysqli_query($link,$es);
						while($row=mysqli_fetch_array($exe))
						{
							$sel = "";
							if($_POST['destino']==$row['idaeropuerto_puerto'])
								$sel = "selected";
							print "<option value='$row[idaeropuerto_puerto]' $sel>$row[nombre]</option>";
						}
						?>
					</select>
				</td>
			</tr>    
			<tr>	
				<td class="tit_vueltas" align="center">
					<input type="submit" class="botonesadmin" style="color:#FFFFFF;" value="Buscar" onClick="form.action=''">
					&nbsp;<input name="boton2" class="botonesadmin" style="color:#FFFFFF;" value="Restablecer filtros" type="button" onClick="document.location = '<? print $_SERVER['PHP_SELF']; ?>';">
				</td>
			</tr>     
		</table>
		<!--Termina Filtros-->
	
		<!--Inicia Graficos-->
		<table width="75%" align="center"><?
			$exe_sqlex=mysqli_query($link,$sqlad);
			$exitosas=0;
			$no_exitosas=0;
			$en_proceso = 0;
			while($roe=mysqli_fetch_array($exe_sqlex)){
				if($roe['resultado']=="exitosa")
					$exitosas++;
				if($roe['resultado']=="no_exitosa")
					$no_exitosas++;
				if($roe['estado']=="en_proceso")
					$en_proceso++;
			}
			$lin=$exitosas.",".$no_exitosas.",".$en_proceso;
			$suma=$no_exitosas+$exitosas + $en_proceso;
			$prov="99";
			if($suma==0)
			{
				$suma=1;
				$prov=0;
			}?>
			<tr>
				<td height="20" class="tittabla" colspan="2" align="center">RESULTADO DE COTIZACIONES</td>	
			</tr>
			<tr>
				<td width="50%" height="20" class="tittabla">GR&Aacute;FICA</td>
				<td width="50%" height="20" class="tittabla">CONVENCIONES</td>
			</tr>
		</table>
		<table width="75%" align="center">
			<tr>
				<td width="50%" height="20" align="center" class="contenidotab">
					<? print 'lin: '.$lin.'<br>'; ?>
						<img src="graph/graphpastel.php?dat=<? print $lin;?>&bkg=FFFFFF&wdt=190&hgt=140" /></td>
					<td width="50%" height="20" class="contenidotab">
					<img src="graph/graphref.php?ref=8&typ=1&dim=5&bkg=FFFFFF" />&nbsp;Exitosas <? print $exitosas." (".round((($exitosas/$suma)*100),2)."%)";?>
					<br />
					<img src="graph/graphref.php?ref=5&typ=1&dim=5&bkg=FFFFFF" />&nbsp;No exitosas <? print $no_exitosas." (".round((($no_exitosas/$suma)*100),2)."%)";?>
					<br />
					<img src="graph/graphref.php?ref=11&typ=1&dim=5&bkg=FFFFFF" />&nbsp;En proceso <? print $en_proceso." (".round((($en_proceso/$suma)*100),2)."%)";?>
					<br />
					<br />Total <? if($prov=="99") print ($suma); else print $prov;?>
				</td>
			</tr>
		</table>
		<!--Termina Graficos-->
	<? } ?>	
	
	<!--Inicia tabla de datos-->
	
	<table>
		<tr>
			<td class="contenidotab" colspan="11" style="text-align:right">
				<strong>Resultados: <? print $cant; ?></strong>
			</td>
		</tr>
		<tr>
			<td class="tittabla" width="1%">#</td>
			<td class="tittabla">N&uacute;mero</td>
			<td class="tittabla">Tipo</td>
			<td class="tittabla" width="25%">Cliente</td>        
			<td class="tittabla">Fecha</td>
			<td class="tittabla">Estado</td>
			<td class="tittabla">Resultado</td>
		</tr><?
		$regxpag = ($_GET['opc'] != "excel") ? 20 : $cant;//cantidad de items por pagina
		$totpag = ceil($cant / $regxpag);
		$pag = $_GET['pag'];
		if (!$pag)
			$pag = 1;
		else{
			if (is_numeric($pag) == false)
				$pag = 1;
		}
		$regini = ($pag - 1) * $regxpag;
		$sqlpag = $sqlad." LIMIT $regini, $regxpag";
		$buscarpag=mysqli_query($link,$sqlpag);
		$cantpag=mysqli_num_rows($buscarpag);
		$y=1;

		for($i=0;$i<$cantpag;$i++){
			$datosad=mysqli_fetch_array($buscarpag);
			
			
			if($datosad['estado']=="en_proceso"){
				$url="paso5_final.php?idcot_temp=$datosad[idcot_temp]&cl=$datosad[clasificacion]";
			}
			if($datosad['estado']=="terminada"){
				$url="paso5_final.php?idcot_temp=$datosad[idcot_temp]&cl=$datosad[clasificacion]&accion=nada";
			}?>  
			<tr>
				<td class="contenidotab"><? print $y;?></td>
				<td class="contenidotab"><a href="<? print $url;?>" title="Click para abrir"><? print $datosad['numero'];?></a></td>
				<td class="contenidotab"><? print strtoupper($datosad['clasificacion']);?></td>
				<td class="contenidotab"><? if(scai_get_name("$datosad[idcliente]","clientes", "idcliente", "nombre")!="") print scai_get_name("$datosad[idcliente]","clientes", "idcliente", "nombre"); else print $datosad['razon_social'];?></td>                
				<td class="contenidotab"><? print $datosad['fecha_hora'];?></td>
				<? if($datosad['estado']=="en_proceso") $roj="#FF0000"; else $roj="";?>
				<td class="contenidotab" style="color:<? print $roj;?>;"><? if($datosad['estado']=='terminada') print 'seguimiento'; else print $datosad['estado'];?></td>
				<td class="contenidotab" style="color:<? print $roj;?>;"><? if($datosad['estado']=="terminada") print $datosad['resultado']; else print 'N/A';?></td>
			</tr><?
			$y++;
		}?>
	</table>

	<!--Termina tabla de datos-->
	
	<? if($_GET['opc'] != "excel"){ ?>
		<!--Opcion de exportar a excel-->
		<table width="100%">
			<tr>
				<td align="center">
					<strong class="contenidotab">Nombre</strong> 
					<input type="text" name="name" id="name" value="<? $name = "cotizaciones".date('Y-m-d').".xls"; print $name; ?>" class="letra" size="30" maxlength="30" />
					<input type="submit" onClick="form.action='?opc=excel'" class="botonesadmin" style="color:#FFFFFF" value="Exportar a Excel"/>
					<br>                
				</td>
			</tr>
		</table>
		
		
		<!--Paginacion-->
		<table width="40%" border="0" cellpadding="0" cellspacing="0" class="tabla" align="center">
			<tr height="25">
				<td width="16%" height="20" colspan="5" class="tittabla">
					<img src="images/ico_paginas.gif" width="15" height="12" align="absmiddle"> Paginaci&oacute;n
				</td>
			</tr>
			<tr height="30" align="center">
				<td height="15">
					<input type="button" class="botonesadmin" style="cursor:pointer;color:#FFFFFF" value="&lt;&lt;" onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=1';" />
				</td>
				<td width="20%" align="center">
					<input type="button" class="botonesadmin" style="cursor:pointer;color:#FFFFFF" value="&lt;" onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=<?php print ($pag - 1); ?>'" />									
				</td>
				<td width="20%" align="center">
					<label>
					<select name="pag" class="combofecha" onChange="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=' + document.forms[0].pag.value;">
					<?php
						for ($i=1; $i<=$totpag; $i++)
						{
							if ($i == $pag)
								print "<option value=$i selected>$i</option>";
							else
	
								print "<option value=$i>$i</option>";
						}
					?>
					</select>
					</label>
				</td>
				<td width="20%" align="center">
					<input type="button" class="botonesadmin" style="cursor:pointer;color:#FFFFFF" value="&gt;" <?php if ($pag != $totpag) { ?> onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=<?php print ($pag + 1); ?>';" style="cursor:pointer;"<?php } ?>/>
				</td>
				<td width="20%" align="center">
					<input type="button" class="botonesadmin" style="cursor:pointer;color:#FFFFFF" value="&gt;&gt;" onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=<?php print $totpag; ?>';"/>									
				</td>
			</tr>
		</table>
	<? }?>


			  


</form>