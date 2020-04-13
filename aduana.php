<?
include('sesion/sesion.php');
include("conection/conectar.php");	
include_once("permite.php");
include_once("scripts/recover_nombre.php");
include('./scripts/scripts.php');


$tabla = "aduana";
$llave = "idaduana";
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
			form.porcentaje_venta.value = parseFloat(form.porcentaje.value) + parseFloat(form.margen_porcentaje.value);
			form.minimo_venta.value = parseFloat(form.minimo.value) + parseFloat(form.margen_minimo.value);
			
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
		var x =1;
		function addRow(tableID) {
			
			var selec = document.createElement("select") ;
			selec.setAttribute("name","moneda[]");
			<?
			$sqlMon = mysql_query("select * from monedas",$link);
			while($moneda = mysql_fetch_array($sqlMon) ){ ?>
				var opc = document.createElement("option");
				opc.text = "<? echo $moneda["codigo"]?>";	
				opc.value = "<? echo $moneda["idmoneda"]?>";
				selec.appendChild(opc);
			<?
			}
			?>	
			
				
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);
			
			
			var td1 = document.createElement("TD")
			row.appendChild(td1).innerHTML="<textarea name='descripcion[]' ></textarea>"; 
/*
			var td2 = document.createElement("TD")
			td2.appendChild(selec);
			row.appendChild(td2);
*/
			var td3 = document.createElement("TD")
			row.appendChild(td3).innerHTML="<input type='text' name='valor_neto[]'>"; 

			var td4 = document.createElement("TD")
			row.appendChild(td4).innerHTML="<input type='text' name='valor_margen[]'>"; 
		
		  }
	</script>
</head>

<?
if($_POST['datosok']=='si'){
	
	
	if($_POST['modRegistro']=="no"){
		$queryins="INSERT INTO $tabla (
						idproveedor, 
						porcentaje, 
						porcentaje_venta, 
						margen_porcentaje, 
						minimo, 
						minimo_venta, 
						margen_minimo, 
						fecha_creacion, 
						fecha_validez,
						observaciones,
						moneda
					) VALUES (
						'$_POST[idproveedor]', 
						'$_POST[porcentaje]', 
						'$_POST[porcentaje_venta]', 
						'$_POST[margen_porcentaje]', 
						'$_POST[minimo]', 
						'$_POST[minimo_venta]', 
						'$_POST[margen_minimo]',
						NOW(), 
						UCASE('$_POST[fecha_validez]'),
						'$_POST[observaciones]',
						'$_POST[moneda]'
					)";
	}else{
		$queryins = "UPDATE $tabla SET 
						idproveedor='$_POST[idproveedor]', 
						porcentaje='$_POST[porcentaje]', 
						porcentaje_venta='$_POST[porcentaje_venta]', 
						margen_porcentaje='$_POST[margen_porcentaje]', 
						minimo='$_POST[minimo]', 
						minimo_venta='$_POST[minimo_venta]', 
						margen_minimo='$_POST[margen_minimo]', 
						moneda='$_POST[moneda]',
						fecha_validez=UCASE('$_POST[fecha_validez]'), 
						observaciones='$_POST[observaciones]'
							WHERE $llave='$_POST[idaduana]'";
	}
	
	if(!mysqli_query($link,$queryins))
		print mysqli_error ();
	else{ //Si almacena, guarda tambien las descripciones 
		//Elimina las descripciones para ingresarlas nuevamente, asi si se edita o crean, corre la misma rutin para actualizarla en la base de datos
	if($_POST['modRegistro']=='si')
	
	
		if(!mysqli_query("delete from aduana_descrip where idaduana = ".$_POST["idaduana"])){
		print mysqli_error();
			die();
		}
		
		for($x=0; $x<= sizeof($_POST['descripcion'])-1; $x++ ){
			$SqlAduanaD ="insert into aduana_descrip (
							idaduana,
							descripcion,
							valor_neto,
							valor_margen
						)values(
							".$_POST["idaduana"].",
							'".$_POST["descripcion"][$x]."',
							".$_POST["valor_neto"][$x].",
							".$_POST["valor_margen"][$x]."
						) ";
			if(!mysqli_query($SqlAduanaD)){
				echo "No se Creó la descripcion '".$_POST["descripcion"][$x]."', contácte al administrador <p> Error ".mysql_error()."</p><p>$SqlAduanaD</p>";
				die();
			}
		}
		?><script>alert ('el registro ha sido ingresado satisfactoriamente')</script><?	
	}

	
	


}

if($_POST['varelimi']=='si')
{
	$queryelim="update $tabla set estado='0' WHERE $llave IN (".str_replace('\\', '', $_POST['listaEliminar']).")";
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
		<? if($_POST['modRegistro'] == "si"){?>
			<input type="hidden" name="modRegistro" value="si" />
		<?
		}else{?>
			<input type="hidden" name="modRegistro" value="no" />
		<?
		}
		
		?> 
		<table width="100%" align="center">
			<tr>
				<td align="center" class="subtitseccion" colspan="2">Tarifario aduana</a></td>
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
		<input name="idaduana" type="hidden" value="<? print $datosmod['idaduana'] ?>" />
		<table width="100%" align="center">
			<tr>
				<td class="contenidotab">Proveedor*</td>
				<td> 
					<select id="idproveedor" name="idproveedor" class="tex2" >
						<option value="N"> Seleccione </option>
						<?
						$comparador = $datosmod['idproveedor'];					
						$es="select * from proveedores_agentes where tipo='aduana' order by nombre";
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
				<input id="fecha_validez" name="fecha_validez" class="tex2" value="<? print $datosmod['fecha_validez']; ?>" maxlength="50" readonly>
				<input class="botonesadmin" style="color:#FFFFFF;" onClick="return showCalendar('fecha_validez');" type='reset' value='Calendario' name='reset' />
				</td>
			</tr>
			<tr>
				<td class="contenidotab">Valor(%)</td>    
				<td>
					<input id="porcentaje" name="porcentaje" class="tex2" value="<? print $datosmod['porcentaje']; ?>" maxlength="50" >
					<input name="porcentaje_venta" type="hidden" value="" />
				</td>
				<td class="contenidotab">Margen Valor(%)</td>
				<td>
					<input id="margen_porcentaje" name="margen_porcentaje" class="tex2" value="<? print $datosmod['margen_porcentaje']; ?>" maxlength="50" >
				</td>
			</tr>
			<tr>
				<td class="contenidotab">Minimo($)</td>    
				<td>
					<input id="minimo" name="minimo" class="tex2" value="<? print $datosmod['minimo']; ?>" maxlength="50" >
					<input name="minimo_venta" type="hidden" value="" />
				</td>
				<td class="contenidotab">Margen Minimo($)</td>    
				<td>
					<input id="margen_minimo" name="margen_minimo" class="tex2" value="<? print $datosmod['margen_minimo']; ?>" maxlength="50" >
				</td>
			</tr>
			<tr>
				<td class="contenidotab">Moneda</td> 
				<td>
					<select id="moneda" name="moneda" class="tex2" >
						<option value="N"> Seleccione </option>
						<?
						$es="select * from monedas order by nombre";
						$exe=mysqli_query($link,$es);
						while($row=mysqli_fetch_array($exe))	
						{
							$sel = '';
							if($datosmod['moneda']==$row['idmoneda'])
								$sel = 'selected';
							print "<option value='$row[idmoneda]' $sel>$row[codigo]-$row[nombre]</option>";
						}
						?>
					</select>
				</td> 
			</tr>
			<td class="contenidotab">Observaciones</td> 
            <td><textarea name="observaciones" id="observaciones" class="tex1"  cols="40" rows="3"><? if($_POST['observaciones']!='') print $_POST['observaciones']; else print $datosmod['observaciones']; ?></textarea>
            </td> 
		</table>
		<p>
<!--		<table width="90%" cellpadding="8" class="contenidotab" style="border-collapse:collapse" border="1" align="center" id="AduanaDesc">
			<tr class="tittabla">
				<td>Descripcion</td>
				<td>Moneda</td>
				<td>Valor Neto</td>
				<td>Valor Margen</td>
			</tr>
			<?
			$sqlAduDesc = "select * from aduana_descrip where idaduana = ".$_POST["registroSel"];
			$qryAduDesc = mysqli_query($link,$sqlAduDesc);

			while($AduanaD = mysqli_fetch_array($qryAduDesc)){?>
				<tr>
					<td><textarea name="descripcion[]"><? echo $AduanaD["descripcion"]?></textarea></td>
                        <td>
						<select name="moneda[]">
							<?
							$sqlMon = mysqli_query($link,"select * from monedas");
							while($moneda = mysqli_fetch_array($sqlMon) ){
							?>
								<option <? echo ($AduanaD["idmoneda"] == $moneda["idmoneda"]) ? "selected='selected'" : ""?> value="<? echo $moneda["idmoneda"] ?>">
									<? echo $moneda["codigo"]?></option>
							<?
							
							}
							?>
						</select>
						
					</td>
					<td><input type="text" value="<? echo $AduanaD["valor_neto"]?>" name="valor_neto[]"> </td>
					<td><input type="text" value="<? echo $AduanaD["valor_margen"]?>"  name="valor_margen[]"> </td>
				</tr>
			<?
			
			}
			
			?>
			
			
		</table>-->

		</p>
		
		
		<table width="100%" align="center">
			<tr>
				<td>
					<table>
						<tr>
							<?

							if(puedo("c","TARIFARIO")==1 || puedo("m","TARIFARIO")==1) { ?> 
								<td width="60">
									<input type="button" class="botonesadmin" onClick="validaEnvia(formulario);" value="Guardar">
								</td>
					    <!--   	<td><input type="button" class="botonesadmin" value="Añadir Fila" onClick="addRow('AduanaDesc')">	</td>-->
							<? 
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
				<td class="tittabla">Proveedor</td>
				<td class="tittabla">Porcentaje</td>
				<td class="tittabla">Margen Porcentaje</td>
				<td class="tittabla">Minimo</td>
				<td class="tittabla">Margen Minimo</td>
				<td class="tittabla">Fecha creación</td>
				<td class="tittabla">Fecha validez</td>
				<td class="tittabla">Moneda</td>
			</tr>    
				<?
				$sqlad="select * from aduana where estado='1'";
				
				if($_GET['vencidas']=='1')
					//$sqlad .= " and fecha_validez < NOW()";
					$sqlad .= " and (fecha_validez between NOW() and DATE_ADD(NOW(), INTERVAL 5 DAY) or fecha_validez < NOW())";
				elseif($_GET['vencidas']=='0')
					//$sqlad .= " and fecha_validez > NOW()";
					$sqlad .= " and fecha_validez not between NOW() and DATE_ADD(NOW(), INTERVAL 5 DAY) and fecha_validez > NOW()";
					
				$sqlad .= " order by fecha_creacion DESC";			
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
						<td class="contenidotab"><input name="registroSel" type="radio" value="<? print $datosad['idaduana']; ?>" onClick="modificarRegistro(<?php print $i;?>)" ></td>
						<td class="contenidotab"><input name="eliSel" type="checkbox" onClick="" value="<? print $datosad['idaduana']; ?>" /></td>
						<td class="contenidotab"><? print scai_get_name("$datosad[idproveedor]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
						<td class="contenidotab"><? print $datosad['porcentaje'];?></td>
						<td class="contenidotab"><? print $datosad['margen_porcentaje'];?></td>
						<td class="contenidotab"><? print $datosad['minimo'];?></td>
						<td class="contenidotab"><? print $datosad['margen_minimo'];?></td>
						<td class="contenidotab"><? print $datosad['fecha_creacion'];?></td>
						<td class="contenidotab"><? print $datosad['fecha_validez'];?></td>
						<td class="contenidotab"><? print scai_get_name("$datosad[moneda]", "monedas", "idmoneda", "codigo");?></td>
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