<?
include('sesion/sesion.php');

if($_GET['opc'] == "export"){ //Opcion de exportar a excel
	Header("Content-Disposition: inline; filename=".$_POST['name']);
	Header("Content-Description: PHP3 Generated Data"); 
//	Header("Content-type: application/vnd.ms-excel; name='Sideris'");//comenta esta linea para ver la salida en web
}


include("conection/conectar.php");	
include_once("permite.php");
include_once("scripts/recover_nombre.php");
include('scripts/scripts.php');
?>



<html>
	<head>
		<link href="css/admin_internas.css" rel="stylesheet" type="text/css">
		<title></title>
	</head>
	
	<body>
		<form method="post" action="?opc=export">
			<? if($_GET['opc'] != "export"){ //No muestra los filtros si va a exportar?>
			<table class="contenidotab" border="0" cellpadding="10" align="center">
				<tr>
					<td rowspan="2">
						Seleccione un cliente:
						<? $sqlCli = mysqli_query($link,"select * from clientes order by nombre asc") ;  	
						?>
						<select name="cliente" class="tex2" required>
							<option></option>
							<?
							while($cliente = mysqli_fetch_array($sqlCli)){?>
								<option <? echo ($_POST['cliente'] == $cliente["nombre"]) ? "selected='selected'" : ""; ?>>
									<? echo $cliente["nombre"]; ?></option>
							
							<?
								
							}
							?>
						</select>
					</td>
					<td colspan="2" align="center">Seleccione un Rango de Fechas(ETA)</td>
					<td>Seleccione un tipo de Indicador</td>
				</tr>
				<tr>
					<td>Desde:<br />
						<input type="text" name="desde" id="desde" readonly="" value="<? echo date("Y-m-d",strtotime("-1 month")); ?>" onClick="return showCalendar('desde');" />
					
					</td>
					<td>Hasta:
						<input type="text" name="hasta" id="hasta" readonly="" value="<? echo date("Y-m-d"); ?>" onClick="return showCalendar('hasta');"  />
					</td>
					<td>
					<ul>Tiempo Transito
						<li><input type="radio" name="tipoInd" value="fcl" required />Fcl</li>
						<li><input type="radio" name="tipoInd" value="lcl" required />Lcl</li>
						<li><input type="radio" name="tipoInd" value="aereo" required />Aereo</li>
					</ul>
					<ul>Tiempo Liberacion:
						<li><input type="radio" name="tipoInd" value="lib_fcl" required />FCL</li>
					</ul>
					</td>	
				</tr>
				<tr>
					<td colspan="4" align="center"><input type="submit" value="Generar Excel" class="botonesadmin" /></td>
				</tr>
			</table>
			<p>
			  <? }else{ // Cuando exporta ?>
</p>
			<table  width="85%" cellpadding="15" style="color:#333333;font-size:12px">

              <tr height="22">
                <td height="22" colspan="2"><div align="center"><strong><? echo  $_POST['cliente']; ?></strong></strong></div></td>
              </tr>

              <tr height="22">
                <td height="22" width="180"><strong>NOMBRE    DEL PROVEEDOR</strong></td>
                <td width="93">GATEWAY SOLUTIONS</td>
              </tr>
              <tr height="22">
                <td height="22" width="180"><strong>TIPO DE    PROVEEDOR</strong></td>
                <td width="93">AGENCIA DE CARGA INTERNACIONAL</td>
              </tr>
              <tr height="22">
                <td height="22" width="180"><strong>TIPO DE    OPERACI&Oacute;N</strong></td>
                <td width="93">IMPORTACI&Oacute;N</td>
              </tr>
              <tr height="22">
                <td height="22" width="180"><strong>NOMBRE    DEL INDICADOR</strong></td>
                <td width="93">
					<?
						switch($_POST['tipoInd']){
							case "fcl":
								echo "TIEMPO DE TRANSITO FCL";
								break;
							case "lcl":
								echo "TIEMPO DE TRANSITO LCL";
								break;
							case "aereo":
								echo "TIEMPO DE TRANSITO AEREO";
								break;
						}
					?>
				</td>
              </tr>
              <tr height="22">
                <td height="22" width="180"><strong>DEFINICI&Oacute;N    DEL INDICADOR</strong></td>
                <td width="93">Medir el cumplimiento de los    tiempos de transito internacional seg&uacute;n los tiempos acordados</td>
              </tr>
              <tr height="22">
                <td height="22" width="180"><strong>FRECUENCIA    DE MEDICI&Oacute;N Y ANALISIS</strong></td>
                <td width="93">Mensual</td>
              </tr>
              <tr height="51">
                <td height="51" width="180"><strong>DIA    MAXIMO PARA GENERACI&Oacute;N Y ANALISIS DEL INDICADOR</strong></td>
                <td width="93">5&deg; D&iacute;a h&aacute;bil de cada mes.</td>
              </tr>
            </table>
			<p>&nbsp;</p>
			<?
				//Genera el tipo de la carga de acuerdo al valor que tenga $_POST['tipoInd'] //CONSULTA SI CONTIENE FCL , LCL ,AEREO

				if(strpos($_POST['tipoInd'] ,"fcl") !== false){ //Si el tipo de carga es fcl
					$tipoCarga = "fcl";
				}elseif(strpos($_POST['tipoInd'] ,"lcl") !== false){ //Si el tipo de carga es lcl
					$tipoCarga = "lcl";
				}elseif(strpos($_POST['tipoInd'] ,"AEREO") !== false) { //Si el tipo de carga es aereo
					$tipoCarga = "aereo";
				}

				
				
				
				$sqlRep = "select * from reporte_estado_cli where idcliente = (select idcliente from clientes where nombre = '".$_POST['cliente']."')";
				$sqlRep .= " and eta >='".$_POST['desde']."' and eta <='".$_POST['hasta']."'";

				$sqlRep .= " and clasificacion = '$tipoCarga'" ;

				
				$qryRep= mysqli_query($link,$sqlRep);
			
			function restar_fechas($fech2,$fech1){
				$segundos=strtotime($fech1) - strtotime($fech2);
				$diferencia_dias=intval($segundos/60/60/24);
				return (int)$diferencia_dias;
				
			}
			?>

			<div style="width:50%">
				<table cellpadding="15" style="color:#333333;font-size:12px;border:medium">
					<tr height="22" style="background-color:#E46D0A;color:#FFFFFF;font-weight:700;text-align:center">
						<td>SHIPPER</td>
						<td>ORIGEN</td>
						<td>PEDIDO</td>
						<?
						if(strpos($_POST['tipoInd'] ,"lib") === 0){ //Para liberacion ?>
							<td>TIEMPO REAL LIBERACION</td>
							<td>TIEMPO OFRECIDO LIBERACION</td>
							<td>CUMPLIMIENTO</td>
						<? }else{?>
							<td>TIEMPO TRANSITO REAL</td>
							<td>TIEMPO DE TRANSITO OFRECIDO</td>
							<td>CUMPLIMIENTO</td>
						
						<? }?>
					</tr>
					<? while($reporte = mysqli_fetch_array($qryRep) ){?>
					   <tr bgcolor="<? echo ($color == "#FFFFFF") ? $color = "#999999" : $color = "#FFFFFF"; ?>" >
						<td><? echo $reporte["shipper"];?></td>
						<td><? echo scai_get_name($reporte["puerto_origen"],"aeropuertos_puertos","idaeropuerto_puerto","nombre" ); ?></td>
						<td><? echo $reporte["number"];?></td>
						<? 
						if(strpos($_POST['tipoInd'] ,"lib") === 0){ //Para liberacion ?>
							<td><? $transitoReal = scai_get_name($reporte["liberacion"],"estados_cli","idestado","fecha" );
							
									echo $transitoReal;
	
							?></td>
							<td>
								<?
								//ETA +1 
								$Ofrecido = date("Y-m-d",strtotime("+1 day",strtotime($reporte["eta"])));
								echo $Ofrecido;
								?>
							</td>
							
						<? }else{?>
							<td><? $transitoReal = restar_fechas($reporte["etd"],$reporte["eta"]);
									echo $transitoReal;
	
							?></td>
							<td>
								<?
								
								//consulta el tiempo de tr�nsito ofrecido
								if($_POST['tipoInd'] == "aereo"){ //Flete aereo
									$sqlT = "
										select tiempo_trans from tarifario_aereo 
										inner join cot_fletes_aereo on cot_fletes_aereo.idtarifario_aereo = tarifario_aereo.idtarifario_aereo 
										inner join rn_fletes_aereo on rn_fletes_aereo.idcot_fletes_aereo = cot_fletes_aereo.idcot_fletes_aereo 
										and rn_fletes_aereo.order_number = '".$reporte["number"]."'";
								}elseif($_POST['tipoInd'] == "fcl" || ($_POST['tipoInd'] == "lcl")){ //Flete fcl o lcl
									$sqlT ="
										select tiempo_trans from tarifario 
										inner join cot_fletes on cot_fletes.idtarifario = tarifario.idtarifario
										inner join rn_fletes on rn_fletes.idcot_fletes = cot_fletes.idcot_fletes
										and rn_fletes.order_number = '".$reporte["number"]."'";
								}
									
									
								//echo "<p>$sqlT</p>";
								$qryT = mysqli_query($link,$sqlT);
								$TTofr = mysqli_fetch_array($qryT);
								$Ofrecido = $TTofr;
								echo $Ofrecido;
								?>
							</td>
							
						<? }
						}
						?>
						<td>
							<?
								//EL CUMPLIMIENTO ES EL PORCENTAJE ENTRE LA DIVISION DE TIEMPO REAL Y TIEMPO DE TRANSITO OFRECIDO * 100%
								if( !is_numeric($TTofr[0]) )
									echo "NA";
								else{
									$cumplimiento = ($TTofr[0] !="0" && $transitoReal !="0" ) ? number_format(($TTofr[0] / $transitoReal) * 100,0) : "NA";
									
									echo ($cumplimiento > 100 ) ? "100%" : $cumplimiento."%";
								}

							?>
						</td>
					   </tr>
						
				</table>
			</div>
			<p></p>
			<p>&nbsp;</p>

				<table  width="85%" cellpadding="15" style="color:#333333;font-size:12px">
					  <tr height="22">
						<td width="180" rowspan="2" style="background-color:#E46D0A;color:#FFFFFF;font-weight:700;text-align:center">FECHA DE    AN&Aacute;LISIS</td>


						<td width="93" height="22"><p>MES</p>
					    <? echo date("F")?></td>
						<td width="93"><p>DIA</p>
					    <? echo date("d");?></td>
						<td width="93"><p>A&Ntilde;O</p>
					    <? echo date("Y");?></td>
					
						<td width="93" rowspan="2" style="background-color:#E46D0A;color:#FFFFFF;font-weight:700;text-align:center">ESTADO ACTUAL DEL INDICADOR</td>
						<td width="67">ESTABLE</td>
						<td width="65">AUMENT&Oacute;</td>
						<td width="80">DISMINUYO</td>
					  </tr>
				</table>
			
			<p>&nbsp;</p>
			<p>			  
			  <?
			   }
			
			?>
			  
          </p>
			<p>&nbsp;</p>
		    <p>&nbsp;</p>
		</form>
	</body>
</html>