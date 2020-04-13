<? include('sesion/sesion.php');
include("conection/conectar.php");
include_once("scripts/recover_nombre.php");?>

<style>
.botonesadmin	{
	background-color:#a01313;
	text-align:center;
	font-weight:bold;
	font-size:11px;
}
body {background-color: #ffffff;}
</style>
<?php
function msge($parametro){
	include("conection/conectar.php");
	$sql2="select valor from parametros where nombre like '$parametro'";
	$exe_sql2=mysqli_query($link,$sql2);
	$alpha=mysqli_fetch_array($exe_sql2);
	return $alpha['valor'];
}?>



<?
if($_GET['tipo']!="final"){?>
	<title>Vista preliminar cotizacion</title><?
}else{?>
	<title><? print str_replace("{file_name}", $_GET['id'], msge("nombre_archivo_imprimir"));  ?></title><?
}


$msg .= "
<link href='css/global.css' rel='stylesheet' media='screen' type='text/css' />
<style type='text/css'>
body{
	font-family:Tahoma;
	font-size:12px;
}
.tabla{
	font-family:Tahoma;
	font-size:10px;
	color:#333333;
}
</style>
";
?>
<center>
<?

$sqlr20 = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and idtipo in (select idtipo from tipo where tipo='20')";
$exer20 = mysqli_query($link,$sqlr20);
$filasr20 = mysqli_num_rows($exer20);

$sqlr40 = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and idtipo in (select idtipo from tipo where tipo='40')";
$exer40 = mysqli_query($link,$sqlr40);
$filasr40 = mysqli_num_rows($exer40);

$sqlr40hq = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and idtipo in (select idtipo from tipo where tipo='40hq')";
$exer40hq = mysqli_query($link,$sqlr40hq);
$filasr40hq = mysqli_num_rows($exer40hq);

$sqlr_minimo = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtipo_aereo in (select idtipo_aereo from tipo_aereo where tipo='minimo')";

$exer_minimo = mysqli_query($link,$sqlr_minimo);
$filasr_minimo = mysqli_num_rows($exer_minimo);

$sqlr_normal = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtipo_aereo in (select idtipo_aereo from tipo_aereo where tipo='normal')";



$exer_normal = mysqli_query($link,$sqlr_normal);
$filasr_normal = mysqli_num_rows($exer_normal);

$sqlr45 = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtipo_aereo in (select idtipo_aereo from tipo_aereo where tipo='45')";
$exer45 = mysqli_query($link,$sqlr45);
$filasr45 = mysqli_num_rows($exer45);




$sqlr100 = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtipo_aereo in (select idtipo_aereo from tipo_aereo where tipo='100')";
$exer100 = mysqli_query($link,$sqlr100);
$filasr100 = mysqli_num_rows($exer100);




$sqlr300 = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtipo_aereo in (select idtipo_aereo from tipo_aereo where tipo='300')";
$exer300 = mysqli_query($link,$sqlr300);
$filasr300 = mysqli_num_rows($exer300);

$sqlr500 = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtipo_aereo in (select idtipo_aereo from tipo_aereo where tipo='500')";
$exer500 = mysqli_query($link,$sqlr500);
$filasr500 = mysqli_num_rows($exer500);

$sqlr1000 = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtipo_aereo in (select idtipo_aereo from tipo_aereo where tipo='1000')";
$exer1000 = mysqli_query($link,$sqlr1000);
$filasr1000 = mysqli_num_rows($exer1000);

?>
<body>


				<!--MARGENES-------------------------------------------------------------------------------------->
				<?
				$sql = "select * from cot_temp where idcot_temp ='".$_GET["id"]."'";
				$exe_sql=mysqli_query($link,$sql);
				$row=mysqli_fetch_array($exe_sql);?>
				<?

				if($_GET['tipo']!="final"){
					$msg .= "
					<table align='left' width='98%' border='0' class='tabla' cellpadding='0' cellspacing='0'>
						<tr><td align='center' font-size:14px;'><strong>VISTA PRELIMINAR</strong></td></tr>
							<tr><td align='center'><hr /></td></tr>
					</table>";
				}

				//Encabezado!
				$msg .= "<br>
				    	<p style='color:#FF0000;text-align:center'><strong>
			***FAVOR NO RESPONDER A ESTE CORREO, PARA CUALQUIER INQUIETUD Y/O SOLICITUD, COMUNICARSE CON EL CONTACTO INFORMADO EN EL CUERPO DEL MENSAJE***</strong>
		</p>
				<table align='left' width='100%' border='0' class='tabla' cellpadding='0' cellspacing='0'>
					<tr>
						<td align='left'>
							<img src='http://appkigen.co/demo/images/logo.png' border='0' width='198' height='60' /></td>
					</tr>
					<tr>
						<td height='41' align='left'>
							Bogot&aacute;, ";
							if(substr($row['fecha_hora'], 0, 10)!='' && substr($row['fecha_hora'], 0, 10)!='0000-00-00')
								$msg .= substr($row['fecha_hora'], 0, 10); else date("Y-m-d");
						$msg .="</td>
					</tr>

					<tr>
						<td align='left'>Se&ntilde;ores</td>
					</tr>

					<tr>
						<td align='left'>".scai_get_name($row["idcliente"],'clientes','idcliente','nombre')."</td>
					</tr>
					<tr>
						<td align='left'>Atn: ";
							if(isset($row['nombre']) && $row['nombre']!='')
								$msg .= $row['nombre'];
							else
								$msg .=  scai_get_name("$row[idcontacto_todos]","contactos_todos","idcontacto_todos","nombre");
						$msg .=  "
						</td>
					</tr>
					<tr>
						<td align='left'>";
						if(isset($row['cargo']) && $row['cargo']!='')
							$msg .=$row['cargo'];
						else
							$msg .= scai_get_name("$row[idcontacto_todos]","contactos_todos","idcontacto_todos","cargo");
						$msg .="
						</td>
					</tr>
					<tr><td align='left'>".strtoupper($row['ciudad'])."</td></tr>
					<tr><td align='right'>Cotizaci&oacute;n No. ".$row['numero']."</td></tr>
					<tr><td align='right' height='5'></td></tr>
					<tr><td align='justify' style='text-align:justify'>".$row['presentacion']."</td></tr>

					<tr><td align='right' height='10'></td></tr>
					<tr><td align='justify'>".$row['contenido']."</td></tr>
				</table>
				<br>";
				//Termina encabezado


				$sqlf = "select * from cot_fletes where idcot_temp='".$_GET["id"]."'";
				$exef = mysqli_query($link,$sqlf);
				$filasf = mysqli_num_rows($exef);
				$item=1;

				//Muestra Fletes
				if($filasf > 0 && $_GET['cl'] == 'fcl'){
					$msg .= "
					<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<tr>
							<td align='center' style='font-size:12px'><strong>".$item++.".FLETE MARITIMO INTERNACIONAL - ".$row["icoterm"]."</strong></td>
						</tr>
					</table>
					<br>
					<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<tr>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>REF</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>ORIGEN</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>DEST</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>VIA</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>MND</strong></td>";

							if($filasr20 > 0){
								$msg .= "<td bgcolor='#cd1818'style='color:white' align='center'><strong>20</strong></td>";
							}
							if($filasr40 > 0){
								$msg .="<td bgcolor='#cd1818'style='color:white' align='center'><strong>40</strong></td>";
							}
							if($filasr40hq > 0){
								$msg .= "<td bgcolor='#cd1818'style='color:white' align='center'><strong>40 H.Q</strong></td>";
							}
							$sqlrc = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and (baf='1' or gri='1' or pss='1')";
							$exerc = mysqli_query($link,$sqlrc);
							$filasrc = mysqli_num_rows($exerc);
							if($filasrc > 0){
								$sqlrc2 = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and idtipo in (select idtipo from tipo where tipo='20')";
								$exerc2 = mysqli_query($link,$sqlrc2);
								$filasrc2 = mysqli_num_rows($exerc2);
								if($filasrc2 > 0){
									$msg .= "<td bgcolor='#cd1818'style='color:white' align='center'>Recargo 20</td>";
								}
								$sqlrc2 = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and idtipo in (select idtipo from tipo where tipo='40')";

								$exerc2 = mysqli_query($link,$sqlrc2);
								$filasrc2 = mysqli_num_rows($exerc2);
								if($filasrc2 > 0){
									$msg .= "<td bgcolor='#cd1818'style='color:white' align='center'>Recargo 40</td>";
								}
								$sqlrc2 = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and idtipo in (select idtipo from tipo where tipo='40hq')";
								$exerc2 = mysqli_query($link,$sqlrc2);
								$filasrc2 = mysqli_num_rows($exerc2);
								if($filasrc2 > 0){
									$msg .= "<td bgcolor='#cd1818'style='color:white' align='center'>Recargo 40HQ</td>";
								}
							}

							$msg .="
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>FREC</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>T.T APROX</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>VIGEN</strong></td>
						</tr>";


						$sqlc = "select distinct idtarifario from cot_fletes where idcot_temp='".$_GET["id"]."'";
						$exec = mysqli_query($link,$sqlc);

						while($datosc= mysqli_fetch_array($exec)){
							$sqlt = "select * from tarifario where idtarifario='".$datosc["idtarifario"]."'";
							$exet = mysqli_query($link,$sqlt);

							while($datost = mysqli_fetch_array($exet)){
								$sqlv = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and idtarifario='".$datosc["idtarifario"]."'";
								$exev = mysqli_query($link,$sqlv);
								$datosv =  mysqli_fetch_array($exev);

								$sqln = "select NOW() as ahora";
								$exen = mysqli_query($link,$sqln);
								$datosn3 = mysqli_fetch_array($exen);
								$color = '#000000';
								if($datost['fecha_vigencia'] < $datosn3['ahora'])
									$color = '#FF0000';

								$msg .= "
								<tr>
									<td style='color: ".$color."'>
										".$datost['idnaviera'].'-'.scai_get_name("$datost[idnaviera]","proveedores_agentes","idproveedor_agente","idproveedor_agente")."
									</td>
									<td style='color:".$color."'>".scai_get_name("$datost[puerto_origen]","aeropuertos_puertos","idaeropuerto_puerto","nombre")."</td>
									<td style='color:".$color."'>".scai_get_name("$datost[puerto_destino]","aeropuertos_puertos","idaeropuerto_puerto","nombre") ."</td>
									<td style='color:".$color."'>".$datost['servicio_via']."</td>
									<td>".scai_get_name("$datost[moneda]","monedas", "idmoneda", "codigo")."</td>";
									if($filasr20 > 0){
										$msg .= "
									<td style='color:".$color."'>";
											$sql20 = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and idtarifario='".$datosc["idtarifario"]."' and idtipo in (select idtipo from tipo where tipo='20')";
											$exe20 = mysqli_query($link,$sql20);
											$datos20 = mysqli_fetch_array($exe20);
											if($datos20['fleteventa']!='')
												$msg .= number_format($datos20['fleteventa'], 2, '.', ',');

										$msg .= "&nbsp;
									</td>";

									}
									if($filasr40 > 0){
										$msg .= "
										<td style='color:".$color."'>";
											$sql40 = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and idtarifario='".$datosc["idtarifario"]."' and idtipo in (select idtipo from tipo where tipo='40')";
											$exe40 = mysqli_query($link,$sql40);
											$datos40 = mysqli_fetch_array($exe40);
											if($datos40['fleteventa']!='')
												$msg .= number_format($datos40['fleteventa'], 2, '.', ',');
											$msg .= "&nbsp;
										</td>";
									}
									if($filasr40hq > 0){
										$msg .= "<td style='color:".$color."'>";
											$sql40hq = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and idtarifario='".$datosc["idtarifario"]."' and idtipo in (select idtipo from tipo where tipo='40hq')";
											$exe40hq = mysqli_query($link,$sql40hq);
											$datos40hq = mysqli_fetch_array($exe40hq);
											if($datos40hq['fleteventa']!='')
												$msg .= number_format($datos40hq['fleteventa'], 2, '.', ',');
											$msg .="
					&nbsp;               </td>";

									}
									$sqlrc = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and (baf='1' or gri='1' or pss='1')";
									$exerc = mysqli_query($link,$sqlrc);
									$filasrc = mysqli_num_rows($exerc);

									if($filasrc > 0){
										if($filasr20 > 0){
											$sql201 = "select * from tipo where idtarifario='".$datosc["idtarifario"]."' and tipo='20'";
											$exe201 = mysqli_query($link,$sql201);
											$datos201 = mysqli_fetch_array($exe201);
											$msg .="
											<td style='color:".$color."'>";
												if($datos20['fleteventa']!=''){
													if($datosv['baf']=='1')
														$msg .= 'BAF '.$datos201['baf'].'<br>';
													if($datosv['gri']=='1')
														$msg .= 'GRI '.$datos201['gri_1'].'<br>';
													if($datosv['pss']=='1')
														$msg .= 'PSS '.$datos201['peak_season'].'<br>';
												}
												$msg .=" &nbsp;
											</td>";
										}
										if($filasr40 > 0){
											$sql401 = "select * from tipo where idtarifario='".$datosc["idtarifario"]."' and tipo='40'";
											$exe401 = mysqli_query($link,$sql401);
											$datos401 = mysqli_fetch_array($exe401);
											$msg .="
											<td style='color:".$color."'>";
												if($datos40['fleteventa']!='')
												{
													if($datosv['baf']=='1')
													$msg .= 'BAF '.$datos401['baf'].'<br>';
													if($datosv['gri']=='1')
													$msg .= 'GRI '.$datos401['gri_1'].'<br>';
													if($datosv['pss']=='1')
													$msg .= 'PSS '.$datos401['peak_season'].'<br>';
												}
												$msg .= "
					&nbsp;						</td>";
										}
										if($filasr40hq > 0)
										{
											$sql401hq = "select * from tipo where idtarifario='".$datosc["idtarifario"]."' and tipo='40hq'";
											$exe401hq = mysqli_query($link,$sql401hq);
											$datos401hq = mysqli_fetch_array($exe401hq);
											$msg .= "
											<td style='color:".$color."'>";
												if($datos40hq['fleteventa']!=''){
													if($datosv['baf']=='1')
													$msg .= 'BAF '.$datos401hq['baf'].'<br>';
													if($datosv['gri']=='1')
													$msg .= 'GRI '.$datos401hq['gri_1'].'<br>';
													if($datosv['pss']=='1')
													$msg .= 'PSS '.$datos401hq['peak_season'].'<br>';
												}
												$msg .="
					&nbsp;					</td>";
										}
									}
									$msg .= "<td style='color:".$color."'>".substr(scai_get_name($datost["frecuencia"],'frecuencias', 'idfrecuencia', 'codigo'), 0, 3)."&nbsp;</td>
									<td style='color:".$color."'>".$datost['tiempo_trans']."&nbsp;</td>
									<td style='color:".$color.">'>
										".date('d/m/y', strtotime(substr($datost['fecha_vigencia'], 0, 10)))."&nbsp;
									</td>
								</tr>";
								if($datosv['baf']=='1' || $datosv['gri']=='1' || $datosv['pss']=='1'){
									$msg .= "
									<tr>
										<td colspan='5' style='color:".$color."'>TOTAL ALL IN</td>";

										if($filasr20 > 0){
											$msg .= "
											<td style='color:".$color."'>";
											if($datos20['fleteventa']!='')
												$msg .=  number_format($datos20['all_in_20'], 2, '.', ',');

											$msg .= "&nbsp;</td>";

										}
										if($filasr40 > 0){
											$msg .= "
											<td style='color:".$color."'>";

											if($datos40['fleteventa']!='')
												$msg .=  number_format($datos40['all_in_40'], 2, '.', ',');

											$msg .= "&nbsp;</td>";
										}
										if($filasr40hq > 0){
										$msg .= "
										<td style='color:".$color."'>";


										if($datos40hq['fleteventa']!='')
											$msg .= number_format($datos40hq['all_in_40hq'], 2, '.', ',');

										$msg .= "&nbsp;</td>";
									}$msg .= "
									</tr>";
								}
							}
						}
						$msg .= "
					</table>
					<br>";
					$sqlrc = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and (baf='1' or gri='1' or pss='1')";
					$exerc = mysqli_query($link,$sqlrc);
					$filasrc = mysqli_num_rows($exerc);
					if($filasrc == 0){
						$msg .= "
						<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
							<tr>
								<td>*Fletes TOTAL ALL IN(Incluido BAF, GRI y PSS)</td>
							</tr>
						</table>
						<br>";
					}
				}



				if($filasf > 0 && $_GET['cl'] == 'lcl'){
					$msg .= "
					<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<td align='center' style='font-size:12px'><strong>".$item++.".FLETE MARITIMO INTERNACIONAL</strong></td>
					</table>
					<br>
					<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<tr>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>REF</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>ORIGEN</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>DEST</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>VIA</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>MND</strong></td>";

							$sqlbaf = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and baf='1'";


							$exebaf= mysqli_query($link,$sqlbaf);
							$filasbaf = mysqli_num_rows($exebaf);
							if($filasbaf > 0){
								$msg .= "
								<td bgcolor='#cd1818' align='center'><strong>TON/M3</strong></td>
								<td bgcolor='#cd1818' align='center'><strong>INCREMENTO BAF</strong></td>";
							}
							$msg .= "
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>TOTAL A.I. W/M</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>MIN</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>FREC</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>T.T APROX</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>VIGEN</strong></td>
						</tr>";

						$sqlc = "select distinct idtarifario from cot_fletes where idcot_temp='".$_GET["id"]."'";


						$exec = mysqli_query($link,$sqlc);
						while($datosc= mysqli_fetch_array($exec)){
							$sqlt = "select * from tarifario where idtarifario='".$datosc["idtarifario"]."'";
							$exet = mysqli_query($link,$sqlt);

							while($datost = mysqli_fetch_array($exet)){

								$sqlv = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and idtarifario='".$datosc["idtarifario"]."'";
								$exev = mysqli_query($link,$sqlv);
								$datosv =  mysqli_fetch_array($exev);

								$sqln = "select NOW() as ahora";
								$exen = mysqli_query($link,$sqln);
								$datosn3 = mysqli_fetch_array($exen);
								$color = '#000000';
								if($datost['fecha_vigencia'] < $datosn3['ahora'])
									$color = '#FF0000';

								$msg .= "
								<tr>
									<td style='color:".$color."'>";
										$msg .=  $datost['idnaviera'].'-'.scai_get_name("$datost[idnaviera]","proveedores_agentes","idproveedor_agente","idproveedor_agente"); $msg .= "
									</td>
									<td style='color:".$color."'>";
										$msg .=  scai_get_name("$datost[puerto_origen]","aeropuertos_puertos","idaeropuerto_puerto","nombre");
										$msg .= "
										</td>
									<td style='color:".$color."'>";
										$msg .=  scai_get_name("$datost[puerto_destino]","aeropuertos_puertos","idaeropuerto_puerto","nombre"); $msg .= "
										</td>";

										$sqltp = "select * from tipo_lcl where idtarifario='".$datosc["idtarifario"]."'";
										$exetp = mysqli_query($link,$sqltp);
										$datostp = mysqli_fetch_array($exetp);

									$msg .= "
									<td style='color:".$color."'>";
										$msg .=  $datost['servicio_via']; $msg .= "&nbsp;
									</td>
									<td style='color:".$color."'>";
										$msg .=  scai_get_name("$datost[moneda]","monedas", "idmoneda", "codigo"); $msg .= "
									</td>";
									
									$sqlbaf = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and baf='1'";
									$exebaf= mysqli_query($link,$sqlbaf);
									$filasbaf = mysqli_num_rows($exebaf);
									if($filasbaf > 0){ $msg .= "
										<td nowrap style='color:".$color."'>";

										if($datosv['fleteventa']!='' && $datosv['baf']=='1')
											$msg .=  $datosv['fleteventa'];
										$msg .= "
										&nbsp;
										</td>
										<td nowrap style='color:".$color."'>".$datostp['incremento_baf']."</td>";
									}
									$msg .= "
									<td nowrap style='color:".$color."'>";
										$msg .=  $datosv['total_neta'];

										$msg .= "
									</td>
									<td style='color:".$color."'>".$datosv['minimo_venta']."</td>
									<td style='color:".$color."'>".
										substr(scai_get_name($datost["frecuencia"],'frecuencias', 'idfrecuencia', 'codigo'), 0, 3)."&nbsp;
									</td>
									<td style='color:".$color."'>".$datost['tiempo_trans']."&nbsp;</td>
									<td style='color:".$color."'>".date('d/m/y', strtotime(substr($datost['fecha_vigencia'], 0, 10)))."&nbsp;</td>
								</tr>";
							}
						}
							$msg .= "
					</table>
					<br>";
				}
                
                //MUESTRA FLETE DE AEREO
                
                $sqlf = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."'";
				$exef = mysqli_query($link,$sqlf);
				$filasf = mysqli_num_rows($exef);
				$item=1;
                
                
				if ( $filasf > 0 && $_GET['cl'] == 'aereo')
				
				{ $msg .= "
						<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
							<td align='center' style='font-size:12px'><strong>".$item++.".FLETE AEREO INTERNACIONAL</strong></td>
						</table>
						<br>
						<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
							<tr>
								<td bgcolor='#cd1818' style='color:white'align='center'><strong>REF</strong></td>
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>ORIGEN</strong></td>
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>DEST</strong></td>
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>VIA</strong></td>
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>VIGENCIA</strong></td>
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>MND</strong></td>";

								if($filasr_minimo > 0){
									$msg .= "<td bgcolor='#cd1818'style='color:white' align='center'><strong>MIN</strong></td>";
								}
								if($filasr_normal > 0){
									$msg .= "<td bgcolor='#cd1818'style='color:white' align='center'><strong>NOR</strong></td>";
								}
							   if($filasr45 > 0){
									$msg .= "<td bgcolor='#cd1818'style='color:white' align='center'><strong>+45kg</strong></td>";
								}
								if($filasr100 > 0){
									$msg .= "<td bgcolor='#cd1818'style='color:white' align='center'><strong>+100kg</strong></td>";
								}
								if($filasr300 > 0){
									$msg .= "<td bgcolor='#cd1818'style='color:white' align='center'><strong>+300kg</strong></td>";
								}
								if($filasr500 > 0){
									$msg .= "<td bgcolor='#cd1818'style='color:white' align='center'><strong>+500kg</strong></td>";
								}
								if($filasr1000 > 0){
									$msg .= "<td bgcolor='#cd1818'style='color:white' align='center'><strong>+1000kg</strong></td>";
								}
								//recargos aereos----------------------------------------------------
								$sqlrc = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and (security='1' or mz='1' or fuel='1')";
								$exerc = mysqli_query($link,$sqlrc);
								$filasrc = mysqli_num_rows($exerc);
								if($filasrc > 0){
									$msg .= "
									<td bgcolor='#cd1818' align='center'>Recargos</td>";
								}
								//---------------------------------------------------------------------------------
								$msg .= "
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>FREC</strong></td>
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>T. TRANS</strong></td>
							</tr>";
							$sqlc = "select distinct idtarifario_aereo from cot_fletes_aereo where idcot_temp='".$_GET["id"]."'";
							$exec = mysqli_query($link,$sqlc);

							$x=0;


							while($datosc= mysqli_fetch_array($exec)){
								$sqlt = "select * from tarifario_aereo where idtarifario_aereo='".$datosc["idtarifario_aereo"]."'";
								$exet = mysqli_query($link,$sqlt);
								while($datost = mysqli_fetch_array($exet)){
								$sqlv = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtarifario_aereo='".$datosc["idtarifario_aereo"]."'";
								$exev = mysqli_query($link,$sqlv);
								$datosv =  mysqli_fetch_array($exev);

								$sqln = "select NOW() as ahora";
								$exen = mysqli_query($link,$sqln);
								$datosn3 = mysqli_fetch_array($exen);
								$color = '#000000';
								if($datost['fecha_vigencia'] < $datosn3['ahora'])
									$color = '#FF0000';
									$msg .= "
								<tr>
									<td style='color:".$color."'>".$datost['idaerolinea']."</td>
									<td style='color:".$color."'>".scai_get_name($datost["aeropuerto_origen"],'aeropuertos_puertos','idaeropuerto_puerto','nombre')."</td>
									<td style='color:".$color."'>".scai_get_name($datost["aeropuerto_destino"],'aeropuertos_puertos','idaeropuerto_puerto','nombre')."</td>
									<td style='color:".$color."'>".$datost['servicio_via']."</td>
									<td style='color:".$color."'>".substr($datost['fecha_vigencia'], 0, 10)."</td>
									<td style='color:".$color."'>
										".scai_get_name($datost["moneda"],'monedas', 'idmoneda', 'codigo')."</td>";
									if($filasr_minimo > 0){
										$msg .= "
										<td>";
											$sql_minimo = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtarifario_aereo='".$datosc["idtarifario_aereo"]."' and idtipo_aereo in (select idtipo_aereo from tipo_aereo where tipo='minimo')";

											$exe_minimo = mysqli_query($link,$sql_minimo);
											$datos_minimo = mysqli_fetch_array($exe_minimo);
											if($datos_minimo['venta']!=''){
												$aer_minimo[$x] = number_format($datos_minimo['venta'], 2, '.', ',');
												$msg .= $aer_minimo[$x];
											}
											$msg .= "
						&nbsp;           </td>";

									}
									if($filasr_normal > 0)
									{
										$msg .= "
										<td>";
											$sql_normal = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtarifario_aereo='".$datosc["idtarifario_aereo"]."' and idtipo_aereo in (select idtipo_aereo from tipo_aereo where tipo='normal')";
											$exe_normal = mysqli_query($link,$sql_normal);
											$datos_normal = mysqli_fetch_array($exe_normal);
											if($datos_normal['venta']!=''){
												$aer_normal[$x]=number_format($datos_normal['venta'], 2, '.', ',');
												$msg .= $aer_normal[$x];
											}
											$msg .= "
						&nbsp;                </td>";
									}
									if($filasr45 > 0){
										$msg .= "
										<td>";
											$sql45 = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtarifario_aereo='".$datosc["idtarifario_aereo"]."' and idtipo_aereo in (select idtipo_aereo from tipo_aereo where tipo='45')";

											$exe45 = mysqli_query($link,$sql45);
											$datos45 = mysqli_fetch_array($exe45);
											if($datos45['venta']!=''){
												$aer_45[$x] = number_format($datos45['venta'], 2, '.', ',');
												$msg .= $aer_45[$x];
											}
											$msg .= "
						&nbsp;                </td>";
									}
									if($filasr100 > 0)
									{
										$msg .= "
										<td>";
											$sql100 = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtarifario_aereo='".$datosc["idtarifario_aereo"]."' and idtipo_aereo in (select idtipo_aereo from tipo_aereo where tipo='100')";

											$exe100 = mysqli_query($link,$sql100);
											$datos100 = mysqli_fetch_array($exe100);
											if($datos100['venta']!=''){
												$aer_100[$x] = number_format($datos100['venta'], 2, '.', ',');
												$msg .= $aer_100[$x];

											}
											$msg .= "
						&nbsp;                </td>";
									}
									if($filasr300 > 0)
									{
										$msg .= "
										<td>";
											$sql300 = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtarifario_aereo='".$datosc["idtarifario_aereo"]."' and idtipo_aereo in (select idtipo_aereo from tipo_aereo where tipo='300')";
											$exe300 = mysqli_query($link,$sql300);
											$datos300 = mysqli_fetch_array($exe300);
											if($datos300['venta']!=''){
												$aer_300[$x]= number_format($datos300['venta'], 2, '.', ',');
												$msg .= $aer_300[$x];
											}
											$msg .= "
						&nbsp;                </td>";
									}
									if($filasr500 > 0)
									{
										$msg .= "
										<td>";
											$sql500 = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtarifario_aereo='".$datosc["idtarifario_aereo"]."' and idtipo_aereo in (select idtipo_aereo from tipo_aereo where tipo='500')";

											$exe500 = mysqli_query($link,$sql500);
											$datos500 = mysqli_fetch_array($exe500);
											if($datos500['venta']!=''){
												$aer_500[$x] = number_format($datos500['venta'], 2, '.', ',');
												$msg .= $aer_500[$x];
											}
											$msg .= "
						&nbsp;                </td>";
									}
									if($filasr1000 > 0)
									{
										$msg .= "
										<td>";
											$sql1000 = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtarifario_aereo='".$datosc["idtarifario_aereo"]."' and idtipo_aereo in (select idtipo_aereo from tipo_aereo where tipo='1000')";
											$exe1000 = mysqli_query($link,$sql1000);
											$datos1000 = mysqli_fetch_array($exe1000);
											if($datos1000['venta']!=''){
												$aer_1000[$x] = number_format($datos1000['venta'], 2, '.', ',');
												$msg .= $aer_1000[$x];
											}
											$msg .="
						&nbsp;                </td>";
									}
									//----------------------------------------------------------------------------------------------
									$sqlrc = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and (security='1' or mz='1' or fuel='1')";
									$exerc = mysqli_query($link,$sqlrc);
									$filasrc = mysqli_num_rows($exerc);
									if($filasrc > 0)
									{
										$msg .= "
										<td style='color:".$color."'>";
											if($datosv['security']=='1')
											$msg .= 'SS '.$datost['security'].'<br>';
											if($datosv['mz']=='1')
											$msg .= 'MZ '.$datost['MZ'].'<br>';
											if($datosv['fuel']=='1')
											$msg .= 'FS '.$datost['fuel'].'<br>';
											$msg .= "
											&nbsp;
										</td>";
									}
									//---------------------------------------------------------------------------------------------
									$msg .= "
								  <td>".substr(scai_get_name("$datost[frecuencia]","frecuencias", "idfrecuencia", "nombre"), 0, 6)."&nbsp;</td>
									<td>".$datost['tiempo_trans']."&nbsp;</td>
									</tr>";
								}
							$x++;
							}$msg .= "
						</table>
						<br>
					";
				}


	/*			if($row['condiciones_fletes']!=''){
					$msg .= "
					<table border='0' cellpadding='0' cellspacing='0' class='tabla' align='center' width='100%'>
						<tr>
							<td>".$row['condiciones_fletes']."</td>
						</tr>
					</table>
					<br>";
				}

				//Termina impresion de fletes
				$sqlv = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."'";
				$exev = mysqli_query($link,$sqlv);
				$datosv =  mysqli_fetch_array($exev);


				if($datosv['condiciones']!=''){ $msg .= "
					<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<tr>
							<td>".$datosv['condiciones']."</td>
						</tr>
					</table>
					<br>";
				}


				$sqlv = "select * from cot_fletes where idcot_temp='".$_GET["id"]."'";
				$exev = mysqli_query($link,$sqlv);
				$datosv =  mysqli_fetch_array($exev);

				if($row['notas_fletes']!=''){ $msg .= "
					<table align='left' width='100%' border='0' class='tabla' cellpadding='0' cellspacing='0'>
						<tr><td align='justify' style='color:#0000FF'>".$row['notas_fletes']."</td></tr>
					</table>";
				}
				
                if($datosv['condiciones']!=''){ $msg .= "
					<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<tr>
							<td>".$datosv['condiciones']."</td>
						</tr>
					</table>
					<br>";
				}
*/
				//-----------RECARGOS ORIGEN------------------
				$sqlc = "select * from cotizacion_origen where clasificacion='".$_GET["cl"]."' and idcot_temp='".$_GET["id"]."'";
				$exec = mysqli_query($link,$sqlc);
				$filasc = mysqli_num_rows($exec);
				while($datosc= mysqli_fetch_array($exec)){
					$sqlc2 = "select * from origen_por_cotizacion where idcotizacion_origen='".$datosc["idcotizacion_origen"]."'";
					$exec2 = mysqli_query($link,$sqlc2);
					$filasc2 = mysqli_num_rows($exec2);

					if($filasc2 > 0){




							//Si elige mostrar recargos en el paso 3, muestra resumen
							if($datosc['mostrar_var']=='1'){
								$sqlRecOr = "
								select
									proveedores_agentes.nombre as agente,
									proveedores_agentes.alias as alias,
									recargos_origen.nombre as regcargo,
									recargos_origen.tipo as tipo,
									monedas.codigo as moneda,
									origen_por_cotizacion.valor_venta as valor,
									origen_por_cotizacion.minimo_venta as minimo
								from origen_por_cotizacion
								inner join recargos_origen on recargos_origen.idrecargo_origen = origen_por_cotizacion.idrecargo_origen
								inner join cotizacion_origen on origen_por_cotizacion.idcotizacion_origen = cotizacion_origen.idcotizacion_origen
								left join proveedores_agentes on proveedores_agentes.idproveedor_agente = recargos_origen.idagente
								inner join monedas on monedas.idmoneda = recargos_origen.moneda
								where cotizacion_origen.idcot_temp='".$_GET['id']."'
								order by proveedores_agentes.nombre desc";


								$qryRecOr = mysqli_query($link,$sqlRecOr);
								$msg .= "
								<br>
								<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='60%'>
									<tr><td colspan='5' bgcolor='#cd1818' style='color:white' align='center'><strong>".$item++.".RECARGOS ORIGEN</strong></td></tr>
									<tr bgcolor='#cd1818'style='color:white' align='center'>
										<td>Agente</td>
										<td>Recargo</td>
										<td>Tipo</td>
										<td>Valor</td>
										<td>Minimo</td>
									</tr>";
									while( $recOr = mysqli_fetch_array($qryRecOr) ){

										$msg .= "
										<tr>
											<td>".$recOr["alias"]."</td>
											<td>".$recOr["regcargo"]."</td>
											<td>".$recOr["tipo"]."</td>
											<td>".$recOr["moneda"]." ".$recOr["valor"]."</td>
											<td>";

												$msg .= ($recOr["minimo"] != 0) ? $recOr["moneda"]." ".$recOr["minimo"] : "";
											$msg .= "
											</td>
										</tr>";
									}
								$msg .= "
								</table>";
							}else{ //si elige NO mostrar los recargos
								$msg .= "
								<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='60%'>
									<tr>
										<td colspan='2' bgcolor='#cd1818'style='color:white' align='center'><strong>".$item++.".RECARGOS ORIGEN</strong></td>
									</tr>";
								if($_GET['cl']=='fcl'){
									$sqln = "select * from recargos_origen where idrecargo_origen in (select idrecargo_origen from origen_por_cotizacion where idcotizacion_origen='".$datosc["idcotizacion_origen"]."') and fecha_validez < NOW() and tipo='cont'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';
									$msg .="
									<tr>
										<td style='color:".$color."'>".ucfirst(strtolower($datosc['nombre_gastos_cont']))."</td>
										<td style='color:".$color."'>
											".number_format($datosc['valor_gastos_cont'], 2, '.', ',').' / CONT'."
										</td>
									</tr>";
								}
								if($_GET['cl']=='lcl'){
									$sqln = "select * from recargos_origen where idrecargo_origen in (select idrecargo_origen from origen_por_cotizacion where idcotizacion_origen='".$datosc["idcotizacion_origen"]."') and fecha_validez < NOW() and tipo='wm'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';
									$msg .= "
									<tr>
										<td style='color:".$color."'>".ucfirst(strtolower($datosc['nombre_gastos_wm']))."</td>
										<td style='color:".$color."'>
											".number_format($datosc['valor_gastos_wm'], 2, '.', ',').' / WM'."
										</td>
									</tr>";
								}
								if($_GET['cl']=='fcl' || $_GET['cl']=='lcl'){
									$sqln = "select * from recargos_origen where idrecargo_origen in (select idrecargo_origen from origen_por_cotizacion where idcotizacion_origen='".$datosc["idcotizacion_origen"]."') and fecha_validez < NOW() and tipo='hbl'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';

									$msg .= "
									<tr>
										<td style='color:".$color."'>".ucfirst(strtolower($datosc['nombre_gastos_hbl']))."</td>
										<td style='color:".$color."'>
											".number_format($datosc['valor_gastos_hbl'], 2, '.', ',').' / HBL'."
										</td>
									</tr>";
								}
								if($_GET['cl']=='aereo'){
									$sqln = "select * from recargos_origen where idrecargo_origen in (select idrecargo_origen from origen_por_cotizacion where idcotizacion_origen='".$datosc["idcotizacion_origen"]."') and fecha_validez < NOW() and tipo='hawb'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';

									$msg .= "
									<tr>
										<td style='color:".$color."'>".ucfirst(strtolower($datosc['nombre_gastos_hawb']))."</td>
										<td style='color:".$color."'>
											".number_format($datosc['valor_gastos_hawb'], 2, '.', ',').' / HAWB'."
										</td>
									</tr>";

									$sqln = "select * from recargos_origen where idrecargo_origen in (select idrecargo_origen from origen_por_cotizacion where idcotizacion_origen='".$datosc["idcotizacion_origen"]."') and fecha_validez < NOW() and tipo='embarque'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';
									$msg .= "
									<tr>
										<td style='color:".$color."'>
											".ucfirst(strtolower($datosc['nombre_gastos_embarque']))."
										</td>
										<td style='color:".$color."'>
											".number_format($datosc['valor_gastos_embarque'], 2, '.', ',').' / EMBARQUE'."
										</td>
									</tr>";
								}
								if($_GET['cl']=='aereo' || $_GET['cl']=='lcl'){
									$sqln = "select * from recargos_origen where idrecargo_origen in (select idrecargo_origen from origen_por_cotizacion where idcotizacion_origen='".$datosc["idcotizacion_origen"]."') and fecha_validez < NOW() and tipo='kilo'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';
									$msg .= "
									<tr>
										<td style='color:".$color."'>".ucfirst(strtolower($datosc['nombre_gastos_kilo']))."</td>
										<td style='color:".$color."'>
											".number_format($datosc['valor_gastos_kilo'], 2, '.', ',').' / KILO'."
										</td>
									</tr>";
								}




							}$msg .= "
						</table>
						<br>";
					}
				}
				

				$idcliente = scai_get_name("$_GET[id]","cot_temp", "idcot_temp", "idcliente");
				$sqlc = "select idcliente_local from cliente_local where idcliente='$idcliente' and clasificacion='".$_GET["cl"]."'";
				$exec = mysqli_query ($sqlc);
				$datosc = mysqli_fetch_array($exec);
				$idcliente_local = $datosc['idcliente_local'];

				$sqlc = "select * from totales_cliente_local where idcliente_local='$idcliente_local' and idcot_temp='".$_GET["id"]."'";
				$exec = mysqli_query($link,$sqlc);


				while($datosc = mysqli_fetch_array($exec)){
					$sqlc2 = "select * from local_por_cliente where idcliente='$idcliente' and idcot_temp='".$_GET["id"]."'";
					$exec2 = mysqli_query($link,$sqlc2);
					$filasc2 = mysqli_num_rows($exec2);

					if($filasc2 > 0){

						$msg .= "
						<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='70%'>
							<tr>
								<td colspan='2' bgcolor='#cd1818'style='color:white' align='center'><strong>".$item++.".RECARGOS LOCALES CLIENTE</strong></td>
							</tr>";
							$sqlc3 = "select MIN(fecha_validez) as min_fecha_validez from recargos_local_cliente where idrecargo_local_cliente in (select idrecargo_local from local_por_cliente where idcliente='$idcliente' and idcot_temp='".$_GET["id"]."')";
							$exec3 = mysqli_query($link,$sqlc3);
							$datosc3 = mysqli_fetch_array($exec3);
							if($datosc['mostrar_var']=='1'){
								$sqlcl = "select idcotizacion_local from cotizacion_local where idcot_temp='".$_GET["id"]."'";
								$execl = mysqli_query($link,$sqlcl);
								$datoscl = mysqli_fetch_array($execl);

								$sqlrg = "select * from recargos_local_cliente where idrecargo_local_cliente in (select idrecargo_local from local_por_cliente where idcliente='$idcliente' and idcot_temp='".$_GET["id"]."')";
								$exerg = mysqli_query($link,$sqlrg);
								while($datosrg = mysqli_fetch_array($exerg))	{
									$sqlv = "select * from local_por_cliente where idcliente='$idcliente' and idcot_temp='".$_GET["id"]."' and idrecargo_local='".$datosrg["idrecargo_local_cliente"]."'";
									$exev = mysqli_query($link,$sqlv);
									$datosv = mysqli_fetch_array($exev);

									$sqln = "select NOW() as ahora";
									$exen = mysqli_query($link,$sqln);
									$datosn3 = mysqli_fetch_array($exen);
									$color = '#000000';
									if($datosrg['fecha_validez'] < $datosn3['ahora'])
										$color = '#FF0000';

									$msg .= "
									<tr>
										<td style='color:".$color."'>".$datosrg['nombre']."&nbsp;</td>
										<td nowrap style='color:".$color."'>";
											if($datosv['valor_venta']=='')
												$msg .=  number_format($datosrg['valor_venta'], 2, '.', ',');
											else
												$msg .=  number_format($datosv['valor_venta'], 2, '.', ',');

											$msg .=  ' / '.strtoupper($datosrg['tipo']);
											$msg .=  ' '.scai_get_name("$datosrg[moneda]","monedas", "idmoneda", "codigo");

										if($datosv['minimo_venta'] > 0){
											if($datosv['minimo_venta']!='' || $datosrg['minimo_venta']!='')
												$msg .= ' MIN ';

											if($datosv['minimo_venta']=='')
												$msg .= number_format($datosrg['minimo_venta'], 2, '.', ',');
											else
												$msg .=  number_format($datosv['minimo_venta'], 2, '.', ',');
											$msg .= ' '.scai_get_name("$datosrg[moneda]","monedas", "idmoneda", "codigo");
										}
										$msg .= "
									  </td>
									</tr>";
								}
							}else{
								if($_GET['cl']=='fcl' && $datosc['valor_gastos_cont'] > 0){
									$sqln = "select * from recargos_local_cliente where idrecargo_local_cliente in (select idrecargo_local from local_por_cliente where idcliente='$idcliente' and idcot_temp='".$_GET["id"]."') and fecha_validez < NOW() and tipo='cont'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';

									$msg .= "
									<tr>
										<td style='color:".$color."'>
											".ucfirst(strtolower($datosc['nombre_gastos_cont']))."&nbsp;
										</td>
										<td style='color:".$color."'>
											".number_format($datosc['valor_gastos_cont'], 2, '.', ',').' / CONT'."&nbsp;
										</td>
									</tr>";
								}
								if($_GET['cl']=='lcl' && $datosc['valor_gastos_wm'] > 0){
									$sqln = "select * from recargos_local_cliente where idrecargo_local_cliente in (select idrecargo_local from local_por_cliente where idcliente='$idcliente' and idcot_temp='".$_GET["id"]."') and fecha_validez < NOW() and tipo='wm'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';

									$msg .= "
									<tr>
										<td style='color:".$color."'>
											".ucfirst(strtolower($datosc['nombre_gastos_wm']))."&nbsp;
										</td>
										<td style='color:".$color."'>
											".number_format($datosc['valor_gastos_wm'], 2, '.', ',').' / WM'."&nbsp;
										</td>
									</tr>";
								}
								if(($_GET['cl']=='fcl' || $_GET['cl']=='lcl') && $datosc['valor_gastos_hbl'] > 0){
									$sqln = "select * from recargos_local_cliente where idrecargo_local_cliente in (select idrecargo_local from local_por_cliente where idcliente='$idcliente' and idcot_temp='".$_GET["id"]."') and fecha_validez < NOW() and tipo='hbl'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';

									$msg .= "
									<tr>
										<td style='color:".$color."'>
											".ucfirst(strtolower($datosc['nombre_gastos_hbl']))."&nbsp;
										</td>
										<td style='color:".$color."'>
											".number_format($datosc['valor_gastos_hbl'], 2, '.', ',').' / HBL'."&nbsp;
										</td>
									</tr>";
								}
								if($_GET['cl']=='aereo'){
									$sqln = "select * from recargos_local_cliente where idrecargo_local_cliente in (select idrecargo_local from local_por_cliente where idcliente='$idcliente' and idcot_temp='".$_GET["id"]."') and fecha_validez < NOW() and tipo='hawb'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';

									if($datosc['valor_gastos_hawb'] > 0) { $msg .= "
										<tr>
											<td style='color:".$color."'>
												".ucfirst(strtolower($datosc['nombre_gastos_hawb']))."&nbsp;
											</td>
											<td style='color:".$color."'>
												".number_format($datosc['valor_gastos_hawb'], 2, '.', ',').' / HAWB'."&nbsp;
											</td>
										</tr>";
									}
									$sqln = "select * from recargos_local_cliente where idrecargo_local_cliente in (select idrecargo_local from local_por_cliente where idcliente='$idcliente' and idcot_temp='".$_GET["id"]."') and fecha_validez < NOW() and tipo='embarque'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';

									if($datosc['valor_gastos_embarque'] > 0) { $msg .= "
										<tr>
											<td style='color:".$color."'>
												".ucfirst(strtolower($datosc['nombre_gastos_embarque']))."&nbsp;</td>
											<td style='color:".$color."'>
												".number_format($datosc['valor_gastos_embarque'], 2, '.', ',').' / EMBARQUE'."&nbsp;
											</td>
										</tr>";
									 }
								}
								if($_GET['cl']=='aereo' || $_GET['cl']=='lcl'){
									$sqln = "select * from recargos_local_cliente where idrecargo_local_cliente in (select idrecargo_local from local_por_cliente where idcliente='$idcliente' and idcot_temp='".$_GET["id"]."') and fecha_validez < NOW() and tipo='kilo'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';
									if($datosc['valor_gastos_kilo'] > 0) { $msg .= "
									<tr>
										<td style='color:".$color."'>
											".ucfirst(strtolower($datosc['nombre_gastos_kilo']))."&nbsp;
										</td>
										<td style='color:".$color."'>
											".number_format($datosc['valor_gastos_kilo'], 2, '.', ',').' / KILO'."&nbsp;
										</td>
									</tr>";
									 }
								}

								if($_GET['cl']=='lcl' && $datosc['mostrar_rangos']=='1') { $msg .= "
									<tr>
										<td>Para Minimas</td>
									</tr>";
									 if($datosc['valor_gastos_wm_min'] > 0) { $msg .= "
										<tr>
											<td>".ucfirst(strtolower($datosc['nombre_gastos_wm']))."&nbsp;</td>
											<td>".number_format($datosc['valor_gastos_wm_min'], 2, '.', ',').' / WM'."&nbsp;</td>
										</tr>";
									}
									if($datosc['valor_gastos_hbl_min'] > 0) { $msg .= "
										<tr>
											<td>".ucfirst(strtolower($datosc['nombre_gastos_hbl']))."&nbsp;</td>
											<td>".number_format($datosc['valor_gastos_hbl_min'], 2, '.', ',').' / HBL'."&nbsp;</td>
										</tr>";
									}
									if($datosc['valor_gastos_kilo_min'] > 0) { $msg .= "
										<tr>
											<td>".ucfirst(strtolower($datosc['nombre_gastos_kilo']))."&nbsp;</td>
											<td>".number_format($datosc['valor_gastos_kilo_min'], 2, '.', ',').' / KILO'."&nbsp;</td>
										</tr>";
									} $msg .= "
										<tr>
											<td>Para 5 WM</td>
										</tr>";
									if($datosc['valor_gastos_wm_min5'] > 0) { $msg .= "
										<tr>
											<td>".ucfirst(strtolower($datosc['nombre_gastos_wm']))."&nbsp;</td>
											<td>".number_format($datosc['valor_gastos_wm_min5'], 2, '.', ',').' / WM'."&nbsp;</td>
										</tr>";
									}
									if($datosc['valor_gastos_hbl_min5'] > 0) { $msg .= "
										<tr>
											<td>".ucfirst(strtolower($datosc['nombre_gastos_hbl']))."&nbsp;</td>
											<td>".number_format($datosc['valor_gastos_hbl_min5'], 2, '.', ',').' / HBL'."&nbsp;</td>
										</tr>";
									}
									if($datosc['valor_gastos_kilo_min5'] > 0) { $msg .= "
										<tr>
											<td>".ucfirst(strtolower($datosc['nombre_gastos_kilo']))."&nbsp;</td>
											<td>".number_format($datosc['valor_gastos_kilo_min5'], 2, '.', ',').' / KILO'.">&nbsp;</td>
										</tr>";
									} $msg .= "
										<tr>
											<td>Para 10 WM</td>
										</tr>";
									if($datosc['valor_gastos_wm_min10'] > 0) { $msg .= "
										<tr>
											<td>".ucfirst(strtolower($datosc['nombre_gastos_wm']))."&nbsp;</td>
											<td>".number_format($datosc['valor_gastos_wm_min10'], 2, '.', ',').' / WM'."&nbsp;</td>
										</tr>";
									}
									if($datosc['valor_gastos_hbl_min10'] > 0) { $msg .= "
										<tr>
											<td>".ucfirst(strtolower($datosc['nombre_gastos_hbl']))."&nbsp;</td>
											<td>".number_format($datosc['valor_gastos_hbl_min10'], 2, '.', ',').' / HBL'."&nbsp;</td>
										</tr>";
									}
									if($datosc['valor_gastos_kilo_min10'] > 0) { $msg .= "
										<tr>
											<td>".ucfirst(strtolower($datosc['nombre_gastos_kilo']))."&nbsp;</td>
											<td>".number_format($datosc['valor_gastos_kilo_min10'], 2, '.', ',').' / KILO'."&nbsp;</td>
										</tr>";
									}
									$msg .= "
										<tr>
											<td>Para 15 WM</td>
										</tr>";
									if($datosc['valor_gastos_wm_min15'] > 0) { $msg .= "
										<tr>
											<td>".ucfirst(strtolower($datosc['nombre_gastos_wm']))."&nbsp;</td>
											<td>".number_format($datosc['valor_gastos_wm_min15'], 2, '.', ',').' / WM'."&nbsp;</td>
										</tr>";
									}
									if($datosc['valor_gastos_hbl_min15'] > 0) { $msg .= "
										<tr>
											<td>".ucfirst(strtolower($datosc['nombre_gastos_hbl']))."&nbsp;</td>
											<td>".number_format($datosc['valor_gastos_hbl_min15'], 2, '.', ',').' / HBL'."&nbsp;</td>
										</tr>";
									}

									if($datosc['valor_gastos_kilo_min15'] > 0) {
									$msg .= "
										<tr>
											<td>".ucfirst(strtolower($datosc['nombre_gastos_kilo']))."&nbsp;</td>
											<td>".number_format($datosc['valor_gastos_kilo_min15'], 2, '.', ',').' / KILO'."&nbsp;</td>
										</tr>";
									}
								}
							}



							if($datosc['mostrar_collection_fee']=='1'){ $msg .= "
								<tr>
									<td>Collection Fee&nbsp;</td>
									<td>".$datosc['collection_fee']."% valor del flete + gastos en origen, minimo USD ".$datosc['min_collection_fee']."&nbsp;</td>
								</tr>";
							}
							if($datosc['mostrar_caf']=='1'){ $msg .= "
								<tr>
									<td>CAF&nbsp;</td>
									<td>".$datosc['caf']."% de la suma de la factura minimo USD ".$datosc['min_caf']."&nbsp;</td>
								</tr>";
							}
							$msg .= "
						</table>
						<br>";
					}

				}

				$sqlc = "select * from totales_cotizacion_local where idcotizacion_local= (select idcotizacion_local from cotizacion_local where idcot_temp='".$_GET["id"]."')";



				$exec = mysqli_query($link,$sqlc);

				while($datosc = mysqli_fetch_array($exec)){
					$sqlc2 = "select * from local_por_cotizacion where idcotizacion_local='".$datosc["idcotizacion_local"]."' and idrecargo_local in (select idrecargo_local from recargos_local where idnaviera='".$datosc["idnaviera"]."')";



					$exec2 = mysqli_query($link,$sqlc2);
					$filasc2 = mysqli_num_rows($exec2);

					if($filasc2 > 0){
						$msg .= "
						<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='70%'>
							<tr>
								<td colspan='2' bgcolor='#cd1818'style='color:white' align='center'><strong>".$item++.".RECARGOS LOCALES</strong></td>
							</tr>";
							if($datosc['mostrar_referencia']=='1')
							{
								$msg .= "
								<tr>
									<td colspan='2'><strong>REF: ".$datosc['idnaviera'].'-'.scai_get_name($datosc["idnaviera"],'proveedores_agentes','idproveedor_agente','idproveedor_agente')."</strong></td>
								</tr>";
							}
							/*$sqlc3 = "select MIN(fecha_validez) as min_fecha_validez from recargos_local where idrecargo_local in (select idrecargo_local from local_por_cotizacion where idcotizacion_local='".$datosc[idcotizacion_local]."')";
							echo $sqlc3;
							$exec3 = mysqli_query($link,$sqlc3);
							$datosc3 = mysqli_fetch_array($exec3);
							$msg .= "
							<tr>
								<td><strong> ->>>> Fecha validez</strong></td>
								<td> ->>> ".substr($datosc3['min_fecha_validez'], 0, 10)."</td>
							</tr>";*/
							if($datosc['mostrar_var']=='1'){
								$sqlcl = "select idcotizacion_local from cotizacion_local where idcot_temp='".$_GET["id"]."'";
								$execl = mysqli_query($link,$sqlcl);
								$datoscl = mysqli_fetch_array($execl);

								$sqlrg = "select * from recargos_local where idrecargo_local in (select idrecargo_local from local_por_cotizacion where idcotizacion_local='".$datoscl["idcotizacion_local"]."') and idnaviera='".$datosc["idnaviera"]."'";
								$exerg = mysqli_query($link,$sqlrg);
								while($datosrg = mysqli_fetch_array($exerg))	{
									$sqlv = "select * from local_por_cotizacion where idcotizacion_local='".$datoscl["idcotizacion_local"]."' and idrecargo_local='".$datosrg["idrecargo_local"]."'";
									$exev = mysqli_query($link,$sqlv);
									$datosv = mysqli_fetch_array($exev);

									$sqln = "select NOW() as ahora";
									$exen = mysqli_query($link,$sqln);
									$datosn3 = mysqli_fetch_array($exen);
									$color = '#000000';
									if($datosrg['fecha_validez'] < $datosn3['ahora'])
										$color = '#FF0000';
									$msg .= "
									<tr>
										<td style='color:".$color."'>".$datosrg['nombre']."&nbsp;</td>
										<td nowrap style='color:".$color."'>";

										if($datosv['valor_venta']=='')
											$msg .= number_format($datosrg['valor_venta'], 2, '.', ',');
										else
											$msg .= number_format($datosv['valor_venta'], 2, '.', ',');

										$msg .= ' / '.strtoupper($datosrg['tipo']);
										$msg .=  ' '.scai_get_name($datosrg["moneda"],'monedas', 'idmoneda', 'codigo');

										if($datosv['minimo_venta'] > 0){
											if($datosv['minimo_venta']!='' || $datosrg['minimo_venta']!='')
												$msg .= ' MIN ';
												if($datosv['minimo_venta']=='')
													$msg .= number_format($datosrg['minimo_venta'], 2, '.', ',');
												else
													$msg .=  number_format($datosv['minimo_venta'], 2, '.', ',');

												$msg .= ' '.scai_get_name("$datosrg[moneda]","monedas", "idmoneda", "codigo");
										}
										$msg .= "
									  </td>
									</tr>";
								}
							}else{
								if($_GET['cl']=='fcl'){
									$sqln = "select * from recargos_local where idrecargo_local in (select idrecargo_local from local_por_cotizacion where idcotizacion_local='".$datosc["idcotizacion_local"]."') and idnaviera='".$datosc["idnaviera"]."' and fecha_validez < NOW() and tipo='cont'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';
									$msg .= "
									<tr>
										<td style='color:".$color."'>
											".ucfirst(strtolower($datosc['nombre_gastos_cont']))."&nbsp;
										</td>
										<td style='color:".$color."'>".number_format($datosc['valor_gastos_cont'], 2, '.', ',').' / CONT'."&nbsp;</td>
									</tr>";
								}
								if($_GET['cl']=='lcl'){
									$sqln = "select * from recargos_local where idrecargo_local in (select idrecargo_local from local_por_cotizacion where idcotizacion_local='".$datosc["idcotizacion_local"]."') and idnaviera='".$datosc["idnaviera"]."' and fecha_validez < NOW() and tipo='wm'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';
									$msg .= "
									<tr>
										<td style='color:".$color."'>
											".ucfirst(strtolower($datosc['nombre_gastos_wm']))."&nbsp;</td>
										<td style='color:".$color."'>
											".number_format($datosc['valor_gastos_wm'], 2, '.', ',').' / WM'."&nbsp;
										</td>
									</tr>";
								}
								if($_GET['cl']=='fcl' || $_GET['cl']=='lcl'){
									$sqln = "select * from recargos_local where idrecargo_local in (select idrecargo_local from local_por_cotizacion where idcotizacion_local='".$datosc["idcotizacion_local"]."') and idnaviera='".$datosc["idnaviera"]."' and fecha_validez < NOW() and tipo='hbl'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';
									$msg .= "
									<tr>
										<td style='color:".$color."'>".ucfirst(strtolower($datosc['nombre_gastos_hbl']))."&nbsp;</td>
										<td style='color:".$color."'>".number_format($datosc['valor_gastos_hbl'], 2, '.', ',').' / HBL'."&nbsp;</td>
									</tr>";
								}
								if($_GET['cl']=='aereo')
								{
									$sqln = "select * from recargos_local where idrecargo_local in (select idrecargo_local from local_por_cotizacion where idcotizacion_local='".$datosc["idcotizacion_local"]."') and idnaviera='".$datosc["idnaviera"]."' and fecha_validez < NOW() and tipo='hawb'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';

									if($datosc['valor_gastos_hawb'] > 0) { $msg .= "
									<tr>
										<td style='color:".$color."'>
											".ucfirst(strtolower($datosc['nombre_gastos_hawb']))."&nbsp;</td>
										<td style='color:".$color."'>
											".number_format($datosc['valor_gastos_hawb'], 2, '.', ',').' / HAWB'."&nbsp;</td>
									</tr>";
									}
									$sqln = "select * from recargos_local where idrecargo_local in (select idrecargo_local from local_por_cotizacion where idcotizacion_local='".$datosc["idcotizacion_local"]."') and idnaviera='".$datosc["idnaviera"]."' and fecha_validez < NOW() and tipo='hawb'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';

									if($datosc['valor_gastos_embarque'] > 0) { $msg .= "
									<tr>
										<td style='color:".$color."'>
											".ucfirst(strtolower($datosc['nombre_gastos_embarque']))."&nbsp;</td>
										<td style='color:".$color."'>
											".number_format($datosc['valor_gastos_embarque'], 2, '.', ',').' / EMBARQUE'."&nbsp;</td>
									</tr>";
									}
								}
								if($_GET['cl']=='aereo' || $_GET['cl']=='lcl'){
									$sqln = "select * from recargos_local where idrecargo_local in (select idrecargo_local from local_por_cotizacion where idcotizacion_local='".$datosc["idcotizacion_local"]."') and idnaviera='".$datosc["idnaviera"]."' and fecha_validez < NOW() and tipo='hawb'";
									$exen = mysqli_query($link,$sqln);
									$filasn = mysqli_fetch_array($exen);
									$color = '#000000';
									if($filasn > 0)
										$color = '#FF0000';

									if($datosc['valor_gastos_kilo'] > 0) { $msg .= "
									<tr>
										<td style='color:".$color."'>".ucfirst(strtolower($datosc['nombre_gastos_kilo']))."&nbsp;</td>
										<td style='color:".$color."'>".number_format($datosc['valor_gastos_kilo'], 2, '.', ',').' / KILO'."&nbsp;</td>
									</tr>";
									}
								}

								if($_GET['cl']=='lcl' && $datosc['mostrar_rangos']=='1') { $msg .= "
									<tr>
										<td>Para Minimas</td>
									</tr>";
									if($datosc['valor_gastos_wm_min'] > 0) { $msg .= "
									<tr>
										<td>".ucfirst(strtolower($datosc['nombre_gastos_wm']))."&nbsp;</td>
										<td>".number_format($datosc['valor_gastos_wm_min'], 2, '.', ',').' / WM'."&nbsp;</td>
									</tr>";
									}
									if($datosc['valor_gastos_hbl_min'] > 0) { $msg .= "
									<tr>
										<td>".ucfirst(strtolower($datosc['nombre_gastos_hbl']))."&nbsp;</td>
										<td>".number_format($datosc['valor_gastos_hbl_min'], 2, '.', ',').' / HBL'."&nbsp;</td>
									</tr>";
									}
									if($datosc['valor_gastos_kilo_min'] > 0) { $msg .= "
									<tr>
										<td>".ucfirst(strtolower($datosc['nombre_gastos_kilo']))."&nbsp;</td>
										<td>".number_format($datosc['valor_gastos_kilo_min'], 2, '.', ',').' / KILO'."&nbsp;</td>
									</tr>";
									}
									$msg .= "
									<tr>
										<td>Para 5 WM</td>
									</tr>";
									if($datosc['valor_gastos_wm_min5'] > 0) { $msg .= "
									<tr>
										<td>".ucfirst(strtolower($datosc['nombre_gastos_wm']))."&nbsp;</td>
										<td>".number_format($datosc['valor_gastos_wm_min5'], 2, '.', ',').' / WM'."&nbsp;</td>
									</tr>";
									}
									if($datosc['valor_gastos_hbl_min5'] > 0) { $msg .= "
									<tr>
										<td>".ucfirst(strtolower($datosc['nombre_gastos_hbl']))."&nbsp;</td>
										<td>".number_format($datosc['valor_gastos_hbl_min5'], 2, '.', ',').' / HBL'."&nbsp;</td>
									</tr>";
									}
									if($datosc['valor_gastos_kilo_min5'] > 0) { $msg .= "
									<tr>
										<td>".ucfirst(strtolower($datosc['nombre_gastos_kilo']))."&nbsp;</td>
										<td>".number_format($datosc['valor_gastos_kilo_min5'], 2, '.', ',').' / KILO'."&nbsp;</td>
									</tr>";
									}
									$msg .= "
									<tr>
										<td>Para 10 WM</td>
									</tr>";
									if($datosc['valor_gastos_wm_min10'] > 0) { $msg .= "
									<tr>
										<td>".ucfirst(strtolower($datosc['nombre_gastos_wm']))."&nbsp;</td>
										<td>".number_format($datosc['valor_gastos_wm_min10'], 2, '.', ',').' / WM'."&nbsp;</td>
									</tr>";
									}
									if($datosc['valor_gastos_hbl_min10'] > 0) { $msg .= "
									<tr>
										<td>".ucfirst(strtolower($datosc['nombre_gastos_hbl']))."&nbsp;</td>
										<td>".number_format($datosc['valor_gastos_hbl_min10'], 2, '.', ',').' / HBL'."&nbsp;</td>
									</tr>";
									}
									if($datosc['valor_gastos_kilo_min10'] > 0) { $msg .= "
									<tr>
										<td>".ucfirst(strtolower($datosc['nombre_gastos_kilo']))."&nbsp;</td>
										<td>".number_format($datosc['valor_gastos_kilo_min10'], 2, '.', ',').' / KILO'."&nbsp;</td>
									</tr>";
									}
									$msg .= "
									<tr>
										<td>Para 15 WM</td>
									</tr>";
									if($datosc['valor_gastos_wm_min15'] > 0) { $msg .= "
									<tr>
										<td>".ucfirst(strtolower($datosc['nombre_gastos_wm']))."&nbsp;</td>
										<td>".number_format($datosc['valor_gastos_wm_min15'], 2, '.', ',').' / WM'."&nbsp;</td>
									</tr>";
									}
									if($datosc['valor_gastos_hbl_min15'] > 0) { $msg .= "
									<tr>
										<td>".ucfirst(strtolower($datosc['nombre_gastos_hbl']))."&nbsp;</td>
										<td>".number_format($datosc['valor_gastos_hbl_min15'], 2, '.', ',')."' / HBL'; ?>&nbsp;</td>
									</tr>";
									}
									if($datosc['valor_gastos_kilo_min15'] > 0) { $msg .= "
									<tr>
										<td>".ucfirst(strtolower($datosc['nombre_gastos_kilo']))."&nbsp;</td>
										<td>".number_format($datosc['valor_gastos_kilo_min15'], 2, '.', ',').' / KILO'."&nbsp;</td>
									</tr>";
									}
								}
							}

							if($datosc['mostrar_collection_fee']=='1'){
								$msg .= "
								<tr>
									<td>Collection Fee</td>
									<td>".$datosc['collection_fee']."% valor del flete + gastos en origen, minimo USD ".$datosc['min_collection_fee']."</td>
								</tr>";
							}
							if($datosc['mostrar_caf']=='1'){
								$msg .= "
								<tr>
									<td>CAF</td>
									<td>".$datosc['caf']."% de la suma de la factura minimo USD ".$datosc['min_caf']."</td>
								</tr>";
							}
							$msg .= "
						</table>
						<br>";
					}
				}
				
				//PRUEBA
/*				$sqlf = "select * from cot_fletes where idcot_temp='".$_GET["id"]."'";
				$exef = mysqli_query($link,$sqlf);
				$filasf = mysqli_num_rows($exef);
				$item=1;

                //OBSERVACIONES DESDE TARIFARIO PARA FCL Y AEREO
				if($filasf > 0 && $_GET['cl'] == 'fcl'|| $_GET['cl']=='lcl'){
					$msg .= "
					";
						$sqlc = "select distinct idtarifario from cot_fletes where idcot_temp='".$_GET["id"]."'";
						$exec = mysqli_query($link,$sqlc);

						while($datosc= mysqli_fetch_array($exec)){
							$sqlt = "select * from tarifario where idtarifario='".$datosc["idtarifario"]."'";
							$exet = mysqli_query($link,$sqlt);

							if($datost = mysqli_fetch_array($exet)){
								$sqlv = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and idtarifario='".$datosc["idtarifario"]."'";
								$exev = mysqli_query($link,$sqlv);
								$datosv =  mysqli_fetch_array($exev);

								$sqln = "select NOW() as ahora";
								$exen = mysqli_query($link,$sqln);
								$datosn3 = mysqli_fetch_array($exen);
								$color = '#000000';
								if($datost['fecha_vigencia'] < $datosn3['ahora'])
									$color = '#FF0000';

								$msg .= "
						<table align='left' width='100%' border='0' class='tabla' cellpadding='0' cellspacing='0'>
								<tr>
									<td align='justify' >".$datost['observaciones']."</td></tr></table>&nbsp
									";}}}
									
									
									if($_GET['cl'] == 'aereo'){ $msg .= " ";
							$sqlc = "select distinct idtarifario_aereo from cot_fletes_aereo where idcot_temp='".$_GET["id"]."'";
							$exec = mysqli_query($link,$sqlc);

							$x=0;

                //OBSERVACIONES DESDE TARIFARIO PARA AEREO
							while($datosc= mysqli_fetch_array($exec)){
								$sqlt = "select * from tarifario_aereo where idtarifario_aereo='".$datosc["idtarifario_aereo"]."'";
								$exet = mysqli_query($link,$sqlt);
								while($datost = mysqli_fetch_array($exet)){
								$sqlv = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."' and idtarifario_aereo='".$datosc["idtarifario_aereo"]."'";
								$exev = mysqli_query($link,$sqlv);
								$datosv =  mysqli_fetch_array($exev);

								$sqln = "select NOW() as ahora";
								$exen = mysqli_query($link,$sqln);
								$datosn3 = mysqli_fetch_array($exen);
								$color = '#000000';
								if($datost['fecha_vigencia'] < $datosn3['ahora'])
									$color = '#FF0000';
									$msg .= "<table align='left' width='100%' border='0' class='tabla' cellpadding='0' cellspacing='0'>
								<tr>
									<td align='justify' >".$datost['restricciones']."</td></tr></table>&nbsp
";}}}*/
                //OBSERVACIONES DESDE PASO 5

    			if($row['observaciones']!=''){ $msg .= "
					<table align='left' width='100%' border='0' class='tabla' cellpadding='0' cellspacing='0'>
						<tr><td align='justify' ><strong>OBSERVACIONES DEL FLETE DESDE PASO 5:<br></strong>".$row['observaciones']."</td></tr>
					</table>
					<br>";
				}
				//IMPRESION DE CONDICIONES DE FLETES
					if($row['condiciones_fletes']!=''){
					$msg .= "
					<table border='0' cellpadding='0' cellspacing='0' class='tabla' align='center' width='100%'>
						<tr>
							<td>".$row['condiciones_fletes']."</td>
						</tr>
					</table>
					<br>";
				}
				
							$sqlv = "select * from cot_fletes_aereo where idcot_temp='".$_GET["id"]."'";
				$exev = mysqli_query($link,$sqlv);
				$datosv =  mysqli_fetch_array($exev);


				if($datosv['condiciones']!=''){ $msg .= "
					<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<tr>
							<td>".$datosv['condiciones']."</td>
						</tr>
					</table>
					<br>";
				}
				
					$sqlv = "select * from cot_fletes where idcot_temp='".$_GET["id"]."'";
				$exev = mysqli_query($link,$sqlv);
				$datosv =  mysqli_fetch_array($exev);

                //OBSERVACIONES DE FLETE DESDE PASO 5
				if($row['notas_fletes']!=''){ $msg .= "
					<table align='left' width='100%' border='0' class='tabla' cellpadding='0' cellspacing='0'>
						<tr><td align='justify' ><strong>OBSERVACIONES:<br></strong>".$row['notas_fletes']."</td></tr>
					</table>
					<br>";
				}
				//CONDICIONES GENERALES DE LOS FLETES
                if($datosv['condiciones']!=''){ $msg .= "
					<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<tr>
							<td><strong>CONDICIONES:</strong><br>".$datosv['condiciones']."</td>
						</tr>
					</table>
					<br>";
				}
				//fin pruebas

                //SERVICIO DE OTM
				$sqlco = "select * from cot_otm where idcot_temp='".$_GET["id"]."'";
				$execo = mysqli_query($link,$sqlco);
				$filasco = mysqli_num_rows($execo);

				if($filasco > 0){
					$msg .= "
					<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<td align='center' style='font-size:12px'><strong>".$item++.".SERVICIO DE OTM</strong></td>
					</table>
					<br>
					<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<tr>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>REF</strong></td>";
							if($_GET['cl']=='fcl') {
								$msg .= "<td bgcolor='#cd1818'style='color:white' align='center'><strong>ESCALA DE PESO</strong></td>";
							}
							$msg .= "
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>TIPO</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>ORIGEN</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>DESTINO</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>MND</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>VALOR ";

							if($_GET['cl']=='lcl') $msg .= 'W/M';

							$msg .= "</strong></td>
						</tr>";?>
						<?

						while($datosco = mysqli_fetch_array($execo)){
							$sqlo = "select * from otm where idotm='".$datosco["idotm"]."' order by idtipotm";
							$exeo = mysqli_query($link,$sqlo);
							$datoso = mysqli_fetch_array($exeo);

							$sqln = "select NOW() as ahora";
							$exen = mysqli_query($link,$sqln);
							$datosn3 = mysqli_fetch_array($exen);
							$color = '#000000';
							if($datoso['fecha_validez'] < $datosn3['ahora'])
								$color = '#FF0000';

							$msg .= "
							<tr>
								<td style='color:".$color."'>
									". $datoso['idproveedor'].'-'.scai_get_name($datoso["idproveedor"],'proveedores_agentes','idproveedor_agente','idproveedor_agente')."
								</td>";

								if($_GET['cl']=='fcl') { $msg .= "
									<td style='color:".$color."'>".$datoso['nombre']."</td>";
								}

								$msg .= "
								<td style='color:".$color."'>";
									if($_GET['cl']=='fcl')
										$msg .= 'CONT ';
									$msg .=  scai_get_name($datoso["idtipotm"],'tipotm','idtipotm','nombre');

								$msg .= "
								</td>
								<td style='color:".$color."'>".scai_get_name($datoso["puerto_origen"],'aeropuertos_puertos','idaeropuerto_puerto','nombre')."</td>
								<td style='color:".$color."'>
									".scai_get_name($datoso["idciudad"],'ciudades','idciudad','nombre')."</td>
								<td style='color:".$color."'>".scai_get_name($datoso["moneda"],'monedas', 'idmoneda', 'codigo')."</td>
								<td style='color:".$color."'>".number_format($datoso["valor_venta"], 2, '.', ',')."</td>
							</tr>";
						}
						$msg .= "
					</table>
					<br>";
					$sqlo3 = "select * from local_otm_por_cotizacion where idcot_temp='".$_GET["id"]."'";
					$exeo3 = mysqli_query($link,$sqlo3);
					$filaso3 = mysqli_num_rows($exeo3);


					if($filaso3 > 0 && $_GET['cl']=='lcl'){

						$msg .= "
						<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='60%'>
							<tr>
								<td bgcolor='#cd1818' colspan='3'><strong>".$item++.".RECARGOS LOCALES OTM LCL</strong></td>
							</tr>";
							$sqlo4 = "select MIN(fecha_validez) as min_fecha_validez from recargos_local_otm where idrecargo_local in (select idrecargo_local from local_otm_por_cotizacion where idcot_temp='".$_GET["id"]."')";
							$exeo4 = mysqli_query($link,$sqlo4);
							$datoso4 = mysqli_fetch_array($exeo4);

							while($datoso3 = mysqli_fetch_array($exeo3)){
								$sqln = "select NOW() as ahora";
								$exen = mysqli_query($link,$sqln);
								$datosn3 = mysqli_fetch_array($exen);
								$color = '#000000';
								if(scai_get_name("$datoso3[idrecargo_local]", "recargos_local_otm", "idrecargo_local", "fecha_validez") < $datosn3['ahora'])
									$color = '#FF0000';
								$msg .= "
								<tr>";
									$protm = scai_get_name("$datoso3[idrecargo_local]", "recargos_local_otm", "idrecargo_local", "idproveedor");

									$msg .= "
									<td style='color:".$color."'>
										".'REF: '.$protm.'-'.scai_get_name('$protm','proveedores_agentes','idproveedor_agente','idproveedor_agente')."
									</td>
									<td style='color:".$color."'>
										".scai_get_name($datoso3["idrecargo_local"], 'recargos_local_otm', 'idrecargo_local', 'nombre')."
									</td>
									<td style='color:".$color."'>";
										$idmoneda = scai_get_name("$datoso3[idrecargo_local]", 'recargos_local_otm', 'idrecargo_local', 'moneda');
										$msg .=  number_format($datoso3['valor_venta'], 2, '.', ',').' '.scai_get_name('$idmoneda','monedas', 'idmoneda', 'codigo'); $msg .= "
									</td>
								</tr>";
							}
							$msg .= "
						</table>
						<br>";
					}



					$sqlco2 = "select * from cot_otm where idcot_temp='".$_GET["id"]."' and devolucion='1'";
					$execo2 = mysqli_query($link,$sqlco2);
					$filasco2 = mysqli_num_rows($execo2);

					if($filasco2 > 0 && $_GET['cl']=='fcl'){
						$msg .= "
						<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>";
								$sqlco2 = "select * from cot_otm where idcot_temp='".$_GET["id"]."' and idotm in (select idotm from otm where idtipotm='1' or idtipotm='2') and devolucion='1'";
								$execo2 = mysqli_query($link,$sqlco2);
								$filasco2 = mysqli_num_rows($execo2);
								if($filasco2 > 0){
									$msg .= "
									<tr>
										<td colspan='5' align='center'><strong>".$item++.".Devoluci&oacute;n de contenedores</strong></td>
									</tr>
									<tr>
										<td align='center'><strong>REF</strong></td>
										<td align='center'><strong>Origen</strong></td>
										<td align='center'><strong>Destino</strong></td>
										<td align='center'><strong>Valor</strong></td>
										<td align='center'><strong>Tiempo de transito</strong></td>
									</tr>";
										while($datosco2 = mysqli_fetch_array($execo2)){
											$sqlo2 = "select * from otm where idotm='".$datosco2["idotm"]."' order by idtipotm";
											$exeo2 = mysqli_query($link,$sqlo2);
											$datoso2 = mysqli_fetch_array($exeo2);

											$sqln = "select NOW() as ahora";
											$exen = mysqli_query($link,$sqln);
											$datosn3 = mysqli_fetch_array($exen);
											$color = '#000000';
											if($datoso2['fecha_validez'] < $datosn3['ahora'])
												$color = '#FF0000';
											$msg .= "
											<tr>
												<td style='color:".$color."'>
												". $datoso2['idproveedor'].'-'.scai_get_name($datoso2["idproveedor"],'proveedores_agentes','idproveedor_agente','idproveedor_agente')."
												</td>
												<td>".scai_get_name($datoso2["idciudad"],'ciudades','idciudad','nombre')."</td>
												<td style='color:".$color."'>
													".scai_get_name($datoso2["puerto_origen"],'aeropuertos_puertos','idaeropuerto_puerto','nombre')."</td>
												<td style='color:".$color."'>".
													number_format($datoso2['valor_dev_venta'], 2, '.', ',').' '.scai_get_name($datoso2['moneda'],'monedas', 'idmoneda', 'codigo').'/'.scai_get_name($datoso2['idtipotm'],'tipotm','idtipotm','nombre')							."
												</td>
												<td style='color:$color'><strong>'".$datoso2['tiempo_transito_dev']."'</strong></td>
											</tr>";
										}
								}
								$sqlco2 = "select * from cot_otm where idcot_temp='".$_GET["id"]."' and idotm in (select idotm from otm where idtipotm='3') and devolucion='1'";
								$execo2 = mysqli_query($link,$sqlco2);
								$filasco2 = mysqli_num_rows($execo2);

								if($filasco2 > 0){
									$msg .= "
									<tr>
										<td colspan='5' align='center'><strong>".$item++.".Devoluci&oacute;n de contenedores en expreso</strong></td>
									</tr>
									<tr>
										<td align='center'><strong>REF</strong></td>
										<td align='center'><strong>Origen</strong></td>
										<td align='center'><strong>Destino</strong></td>
										<td align='center'><strong>Valor</strong></td>
										<td align='center'><strong>Tiempo de transito</strong></td>
									</tr>";
										while($datosco2 = mysqli_fetch_array($execo2)){
											$sqlo2 = "select * from otm where idotm='".$datosco2["idotm"]."' order by idtipotm";
											$exeo2 = mysqli_query($link,$sqlo2);
											$datoso2 = mysqli_fetch_array($exeo2);

											$sqln = "select NOW() as ahora";
											$exen = mysqli_query($link,$sqln);
											$datosn3 = mysqli_fetch_array($exen);
											$color = '#000000';
											if($datoso2['fecha_validez'] < $datosn3['ahora'])
												$color = '#FF0000';
											$msg .= "
											<tr>
												<td style='color:".$color."'>
												".$datoso2['idproveedor'].'-'.scai_get_name($datoso2["idproveedor"],'proveedores_agentes','idproveedor_agente','idproveedor_agente')."
												</td>
												<td style='color:".$color."'>
												".scai_get_name($datoso2["idciudad"],'ciudades','idciudad','nombre')."
												</td>
												<td style='color:".$color."'>
												".scai_get_name($datoso2["puerto_origen"],'aeropuertos_puertos','idaeropuerto_puerto','nombre')."
												</td>
												<td style='color:".$color."'>
													".number_format($datoso2['valor_dev_venta'], 2, '.', ',').' '.scai_get_name($datoso2["moneda"],'monedas', 'idmoneda', 'codigo').'/'.scai_get_name($datoso2["idtipotm"],'tipotm','idtipotm','nombre')."
												</td>
												<td style='color:".$color."'>
													<strong>".$datoso2['tiempo_transito_dev']."</strong>
												</td>
											</tr>";

										}
								}
								$msg .= "
						</table>
						<br>";
					}
					$sqlco2 = "select * from cot_otm where idcot_temp='".$_GET["id"]."'";
					$execo2 = mysqli_query($link,$sqlco2);
					$filasco2 = mysqli_num_rows($execo2);

					if($filasco2 > 0){
						$msg .= "
							<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<td align='center' style='font-size:12px'><strong>Costo de escoltas por ciudades</strong></td>
					</table>
						<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>";
								$sqlco2 = "select * from cot_otm where idcot_temp='".$_GET["id"]."' and escolta='1'";
								$execo2 = mysqli_query($link,$sqlco2);
								$filasco2 = mysqli_num_rows($execo2);

								if($filasco2 > 0){
									$msg .= "
									<tr>
								<!--		<td colspan='5' align='center'><strong>".$item++.".Costo de escoltas por ciudades</strong></td>-->
									</tr>
									<tr>
										<td bgcolor='#cd1818'style='color:white' align='center'><strong>REF</strong></td>
										<td bgcolor='#cd1818'style='color:white' align='center'><strong>Origen</strong></td>
										<td bgcolor='#cd1818'style='color:white' align='center'><strong>Destino</strong></td>
										<td bgcolor='#cd1818'style='color:white' align='center'><strong>Vehicular</strong></td>
										<td bgcolor='#cd1818'style='color:white' align='center'><strong>Cabina</strong></td>
									</tr>";
										while($datosco2 = mysqli_fetch_array($execo2)){
											$sqlo2 = "select * from otm where idotm='".$datosco2["idotm"]."' order by idtipotm";
											$exeo2 = mysqli_query($link,$sqlo2);
											$datoso2 = mysqli_fetch_array($exeo2);

											$sqln = "select NOW() as ahora";
											$exen = mysqli_query($link,$sqln);
											$datosn3 = mysqli_fetch_array($exen);
											$color = '#000000';
											if($datoso2['fecha_validez'] < $datosn3['ahora'])
												$color = '#FF0000';
											$msg .= "
											<tr>
												<td style='color:".$color."'>
													".$datoso2['idproveedor'].'-'.scai_get_name($datoso2["idproveedor"],'proveedores_agentes','idproveedor_agente','idproveedor_agente')."
												</td>
												<td style='color:".$color."'>
													".scai_get_name($datoso2["puerto_origen"],'aeropuertos_puertos','idaeropuerto_puerto','nombre')."
												</td>
												<td style='color:".$color."'>".
													scai_get_name($datoso2["idciudad"],'ciudades','idciudad','nombre')."
												</td>
												<td style='color:".$color."'>
													".number_format($datoso2['valor_esc_v_venta'], 2, '.', ',').' '.scai_get_name($datoso2["moneda"],'monedas', 'idmoneda', 'codigo')."
												</td>
												<td style='color:".$color."'>".
													number_format($datoso2['valor_esc_c_venta'], 2, '.', ',').' '.scai_get_name($datoso2["moneda"],'monedas', 'idmoneda', 'codigo')
												."</td>
											</tr>";
										}
								}
								$msg .= "
						</table>
						<br>";
					}
				}
 //PRUEBAS OBSERVACIONES DE OTM 
 				$sqlco = "select * from cot_otm where idcot_temp='".$_GET["id"]."'";
				$execo = mysqli_query($link,$sqlco);
				$filasco = mysqli_num_rows($execo);

				if($filasco > 0){
					$msg .= " ";
						while($datosco = mysqli_fetch_array($execo)){
							$sqlo = "select * from otm where idotm='".$datosco["idotm"]."' order by idtipotm";
							$exeo = mysqli_query($link,$sqlo);
							$datoso = mysqli_fetch_array($exeo);

							$sqln = "select NOW() as ahora";
							$exen = mysqli_query($link,$sqln);
							$datosn3 = mysqli_fetch_array($exen);
							$color = '#000000';
							if($datoso['fecha_validez'] < $datosn3['ahora'])
								$color = '#FF0000';

							$msg .= " ";
								if($_GET['cl']=='fcl'||$_GET['cl']=='lcl') { $msg .= "
					<table align='left' width='100%' border='0' class='tabla' cellpadding='0' cellspacing='0'><tr>
									<td style='color:".$color."'>".$datoso['observaciones']."</td></tr></table>&nbsp";
								}}}
 
 //FIN DE PRUEBAS
				if($row['notas_otm']!=''){ $msg .= "
					<table align='left' width='100%' border='0' class='tabla' cellpadding='0' cellspacing='0'>
						<tr><td align='justify'><strong>OBSERVACIONES:<br>".$row['notas_otm']."</strong></td></tr>
					</table>&nbsp";
				}

				$msg .= "
				<br>
				<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
					<tr>
						<td>";
						  $execo = mysqli_query($link,$sqlco); $datosco = mysqli_fetch_array($execo); $msg .= $datosco['condiciones'];
						$msg .= "</td>
					</tr>
				<!--	<tr>
						<td>".$datosco['documentacion']."</td>
					</tr>-->
				</table>";


				//Carga Nacionalizada
				$sqlco = "select * from cot_terrestre where idcot_temp='".$_GET["id"]."'";
				$execo = mysqli_query($link,$sqlco);
				$filasco = mysqli_num_rows($execo);

				if($filasco > 0){
					$msg .= "
					<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<td align='center' style='font-size:12px'><strong>SERVICIO DE CARGA NACIONALIZADA</strong></td>
					</table>
					<br>
					<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<tr>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>REF</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>NOMBRE DE LA RUTA</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>VALOR";
							if($_GET['cl']=='lcl')
								$msg .= 'W/M';

							$msg .= "</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>ORIGEN</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>DESTINO</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>VALIDEZ</strong></td>
						</tr>";
						while($datosco = mysqli_fetch_array($execo)){
							$sqlo = "select * from terrestre where idterrestre='".$datosco["idterrestre"]."' order by idtipoterrestre";
							$exeo = mysqli_query($link,$sqlo);
							$datoso = mysqli_fetch_array($exeo);

							$sqln = "select NOW() as ahora";
							$exen = mysqli_query($link,$sqln);
							$datosn3 = mysqli_fetch_array($exen);
							$color = '#000000';
							if($datoso['fecha_validez'] < $datosn3['ahora'])
								$color = '#FF0000';

							$msg .= "
							<tr>
								<td style='color:".$color."'>
									".$datoso['idproveedor'].'-'.scai_get_name($datoso["idproveedor"],'proveedores_agentes','idproveedor_agente','idproveedor_agente')."
								</td>
								<td style='color:".$color."'>".$datoso['nombre'].'  '.scai_get_name($datoso["idtipoterrestre"],'tipoterrestre','idtipoterrestre','nombre')."</td>
								<td style='color:".$color."'>
									".number_format($datosco['valor_venta'], 2, '.', ',')."
								</td>
								<td style='color:".$color."'>
									".scai_get_name($datoso["puerto_origen"],'aeropuertos_puertos','idaeropuerto_puerto','nombre')."
								</td>
								<td style='color:".$color."'>
									".scai_get_name($datoso["idciudad"],'ciudades','idciudad','nombre')."
								</td>
								<td style='color:".$color."'>".substr($datoso['fecha_validez'], 0, 10)."</td>
							</tr>";
						}
						$msg .= "
					</table>
					<br>";

					$sqlco2 = "select * from cot_terrestre where idcot_temp='".$_GET["id"]."' and devolucion='1'";
					$execo2 = mysqli_query($link,$sqlco2);
					$filasco2 = mysqli_num_rows($execo2);

					if($filasco2 > 0 && $_GET['cl']=='fcl'){ $msg .= "
						<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>";
								$sqlco2 = "select * from cot_terrestre where idcot_temp='".$_GET["id"]."' and devolucion='1'";
								$execo2 = mysqli_query($link,$sqlco2);
								$filasco2 = mysqli_num_rows($execo2);
								if($filasco2 > 0){ $msg .= "
									<tr>
										<td colspan='5' align='center'><strong>Devoluci&oacute;n de contenedores</strong></td>
									</tr>
									<tr>
										<td align='center'><strong>REF</strong></td>
										<td align='center'><strong>Origen</strong></td>
										<td align='center'><strong>Destino</strong></td>
										<td align='center'><strong>Valor</strong></td>
										<td align='center'><strong>Tiempo de transito</strong></td>
									</tr>";
										while($datosco2 = mysqli_fetch_array($execo2)){
											$sqlo2 = "select * from terrestre where idterrestre='".$datosco2["idterrestre"]."' order by idtipoterrestre";
											$exeo2 = mysqli_query($link,$sqlo2);
											$datoso2 = mysqli_fetch_array($exeo2);

											$sqln = "select NOW() as ahora";
											$exen = mysqli_query($link,$sqln);
											$datosn3 = mysqli_fetch_array($exen);
											$color = '#000000';
											if($datoso2['fecha_validez'] < $datosn3['ahora'])
												$color = '#FF0000';
											$msg .= "
											<tr>
												<td style='color:".$color."'>
												".$datoso2['idproveedor'].'-'.scai_get_name('$datoso2[idproveedor]','proveedores_agentes','idproveedor_agente','idproveedor_agente')."
												</td>
												<td style='color:".$color."'>".
													scai_get_name($datoso2["idciudad"],'ciudades','idciudad','nombre')
												."</td>
												<td style='color:".$color."'>".
													scai_get_name($datoso2["puerto_origen"],'aeropuertos_puertos','idaeropuerto_puerto','nombre')
												."</td>
												<td style='color:".$color."'>".
													number_format($datoso2['valor_dev_venta'], 2, '.', ',').'/'.scai_get_name($datoso2["idtipoterrestre"],'tipoterrestre','idtipoterrestre','nombre').
												"</td>
												<td style='color:".$color."'>
													<strong>".$datoso2['tiempo_transito_dev']."</strong></td>
											</tr>";

										}
								}
								$msg .= "
						</table>
						<br>";
					}
					$sqlco2 = "select * from cot_terrestre where idcot_temp='".$_GET["id"]."'";
					$execo2 = mysqli_query($link,$sqlco2);
					$filasco2 = mysqli_num_rows($execo2);

					if($filasco2 > 0){
						$sqlco2 = "select * from cot_terrestre where idcot_temp='".$_GET["id"]."' and escolta='1'";
						$execo2 = mysqli_query($link,$sqlco2);
						$filasco2 = mysqli_num_rows($execo2);

						if($filasco2 > 0){ $msg .= "
											<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<td align='center' style='font-size:12px'><strong>Costo de escoltas por ciudades</strong></td>
					</table>
					<br>
							<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='115%'>
								<tr>
								<!--	<td bgcolor='#cd1818'style='color:white' colspan='5' align='center'><strong>Costo de escoltas por ciudades</strong></td>-->
								</tr>
								<tr>
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>REF</strong></td>
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>Origen</strong></td>
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>Destino</strong></td>
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>Vehicular</strong></td>
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>Cabina</strong></td>
								</tr>";
								while($datosco2 = mysqli_fetch_array($execo2)){
									$sqlo2 = "select * from terrestre where idterrestre='".$datosco2["idterrestre"]."' order by idtipoterrestre";
									$exeo2 = mysqli_query($link,$sqlo2);
									$datoso2 = mysqli_fetch_array($exeo2);
									$msg .= "
									<tr>
										<td>".$datoso2['idproveedor']."</td>
										<td>".scai_get_name($datoso2["puerto_origen"],'aeropuertos_puertos','idaeropuerto_puerto','nombre')."</td>
										<td>".scai_get_name($datoso2["idciudad"],'ciudades','idciudad','nombre')."</td>
										<td>".number_format($datoso2['valor_esc_v_venta'], 2, '.', ',').' '.scai_get_name($datoso2["moneda"],'monedas', 'idmoneda', 'codigo')."</td>
										<td>".number_format($datoso2['valor_esc_c_venta'], 2, '.', ',').' '.scai_get_name($datoso2["moneda"],'monedas', 'idmoneda', 'codigo')."</td>
									</tr>";
								}
								$msg .= "
							</table>
							<br>";
						}
					}
					$msg .= "
					<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<tr>
							<td>";
							  $execo = mysqli_query($link,$sqlco); $datosco = mysqli_fetch_array($execo); $msg .= $datosco['condiciones'];
					$msg .= "
							</td>
						</tr>
					</table>";
				}

				//DTA
				$sqlco = "select * from cot_dta where idcot_temp='".$_GET["id"]."'";
				$execo = mysqli_query($link,$sqlco);
				$filasco = mysqli_num_rows($execo);

				if($filasco > 0){
					$msg .= "
					<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<td align='center' style='font-size:12px'><strong>".$item++.".DTA</strong></td>
					</table>
					<br>
					<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<tr>

							<td bgcolor='#cd1818'style='color:white' align='center'><strong>NOMBRE</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>VALOR";
							if($_GET['cl']=='lcl')
								$msg .= 'W/M';

							$msg .= "</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>ORIGEN</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>DESTINO</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>VALIDEZ</strong></td>
						</tr>";
						while($datosco = mysqli_fetch_array($execo)){
							$sqlo = "select * from dta where iddta='".$datosco["iddta"]."'";
							$exeo = mysqli_query($link,$sqlo);
							$datoso = mysqli_fetch_array($exeo);

							$sqln = "select NOW() as ahora";
							$exen = mysqli_query($link,$sqln);
							$datosn3 = mysqli_fetch_array($exen);
							$color = '#000000';
							if($datoso['fecha_validez'] < $datosn3['ahora'])
								$color = '#FF0000';

							$msg .= "
							<tr>

								<td style='color:".$color."'>".$datoso['nombre'].'  '.scai_get_name($datoso["idtipodta"],'tipodta','idtipodta','nombre')."</td>
								<td style='color:".$color."'>
									".number_format($datosco['valor_venta'], 2, '.', ',')."
								</td>
								<td style='color:".$color."'>
									".scai_get_name($datoso["puerto_origen"],'aeropuertos_puertos','idaeropuerto_puerto','nombre')."
								</td>
								<td style='color:".$color."'>
									".scai_get_name($datoso["idciudad"],'ciudades','idciudad','nombre')."
								</td>
								<td style='color:".$color."'>".substr($datoso['fecha_validez'], 0, 10)."</td>
							</tr>";
						}
						$msg .= "
					</table>
					<br>";

				}

//SERVICIO DE ADUANA

				$sqladu = "select * from cot_adu where idcot_temp='".$_GET["id"]."'";
				$exeadu = mysqli_query($link,$sqladu);
				$filasadu = mysqli_num_rows($exeadu);
				if($filasadu > 0){  $msg .= "
					<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<td align='center' style='font-size:12px'><strong>".$item++.".ASESORIA ADUANERA</strong></td>
					</table>
					<br>
					<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='70%'>
						<tr>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>REF</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>Comisi&oacute;n ad valorem sobre el valor CIF (%)</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>Moneda</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>M&iacute;nima</strong></td>
							<!--<td bgcolor='#cd1818'style='color:white' align='center'><strong>Validez</strong></td>-->
						</tr>";
						while($datosadu = mysqli_fetch_array($exeadu)){
							
	$sqladu2 = "SELECT aduana.idaduana ,aduana.fecha_validez,
                        aduana.idproveedor,aduana.porcentaje,
                        aduana.moneda,aduana.minimo,aduana_descrip.descripcion,
                        aduana_descrip.valor_neto , aduana_descrip.valor_margen
                        FROM aduana_descrip INNER JOIN aduana
                        ON aduana_descrip.idaduana = aduana.idaduana
                        WHERE aduana.idaduana ='".$datosadu["idaduana"]."'"; 				
						
						/*	$sqladu2 = "select * from aduana where idaduana='".$datosadu["idaduana"]."' order by fecha_creacion DESC limit 0,1";*/
							$exeadu2 = mysqli_query($link,$sqladu2);
							$datosadu2 = mysqli_fetch_array($exeadu2);
						/*lo coloque */	
							
					    		$sqln = "select NOW() as ahora";
							$exen = mysqli_query($link,$sqln);
							$datosn3 = mysqli_fetch_array($exen);
							$color = '#000000';
							if($datosadu2['fecha_validez'] < $datosn3['ahora'])
								$color = '#FF0000';
							$msg .= "
							<tr>
								<td style='color:".$color."'>".$datosadu2['fecha_validez'].' ' .$datosadu2['idproveedor'].'-'.scai_get_name($datosadu2["idproveedor"],'proveedores_agentes','idproveedor_agente','idproveedor_agente')."
								</td>
								<td style='color:".$color."'>
									".number_format($datosadu['porcentaje'], 2, '.', ',')."
								</td>
								<td style='color:".$color."'>
									".scai_get_name($datosadu2["moneda"], 'monedas', 'idmoneda' , 'codigo')."
								</td>
								<td style='color:".$color."'>
									".number_format($datosadu['minimo'], 2, '.', ',')."
								</td>
							</tr></table>
							<br>";
							
							while($datosadu3 =mysqli_fetch_array($datosadu))
							$datosa= "select descripcion, valor_neto from aduana_descrip where idaduana='".$datosadu["idaduana"]."";
							$exe3 = mysqli_query($link,$datosa);
							$datosadu3 = mysqli_fetch_array($exe3);
							$test='descripcion';
							$msg .="
							<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='70%'>
						<tr>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>DESCRIPCION</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>VALOR NETO</strong></td>
                        </tr>
                		<tr>
<!--INGRESO VISTA  DE DESCRIPCIONES-->

							<td>". $test."</td>
							<td >". $datosa=['valor_neto']."</td>
						</tr>
					</table>
					<br>";
						}

/*parece repetido
						$exeadu = mysqli_query($link,$sqladu);
						$datosadu = mysqli_fetch_array($exeadu);*/

/*CONDICIONES GENERALES DE ADUANA*/
						if($_GET['cl']=='fcl')
							$idp = '15';
						elseif($_GET['cl']=='lcl')
							$idp = '16';
						elseif($_GET['cl']=='aereo')
							$idp = '26';
						$sql = "select * from parametros where idparametro='$idp'";
						$exe = mysqli_query($link,$sql);
						$cond = mysqli_fetch_array($exe);
						$msg .= "
					</table><br>
					<table border='0' class='tabla' width='100%'>
						<tr>
							<td colspan='4'>".$cond['valor']."</td>
						</tr>
					</table>
					<br>";
}				

				$sqlseg = "select * from cot_seg where idcot_temp='".$_GET["id"]."'";
				$exeseg = mysqli_query($link,$sqlseg);
				$filasseg = mysqli_num_rows($exeseg);

				if($filasseg > 0){ $msg .= "
					<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<td align='center' style='font-size:12px'><strong>".$item++.".SEGURO DE MERCANCIA</strong></td>
					</table>
					<br>
					<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='70%'>
						<tr>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>REF</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>Valor del Seguro (%)</strong></td>
							 <td bgcolor='#cd1818'style='color:white' align='center'><strong>Moneda</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>M&iacute;nima</strong></td>";

							$sqlmt = "select * from cot_seg where idcot_temp='".$_GET["id"]."' and monto_aseg!='' and monto_aseg!='0'";
							$exemt = mysqli_query($link,$sqlmt);
							$filasmt = mysqli_num_rows($exemt);
							if($filasmt > 0){ $msg .= "
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>Monto asegurado</strong></td>
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>Total del seguro</strong></td>";
							}
							$msg .= "
						</tr>";
						while($datosseg = mysqli_fetch_array($exeseg)){
							$sqlseg2 = "select * from seguro where idseguro='".$datosseg["idseguro"]."' order by fecha_creacion DESC";
							$exeseg2 = mysqli_query($link,$sqlseg2);
							$datosseg2 = mysqli_fetch_array($exeseg2);

							$sqln = "select NOW() as ahora";
							$exen = mysqli_query($link,$sqln);
							$datosn3 = mysqli_fetch_array($exen);
							$color = '#000000';
							if($datosseg2['fecha_validez'] < $datosn3['ahora'])
								$color = '#FF0000';
							$msg .= "
							<tr>
								<td style='color:".$color."'>
									".$datosseg2['idproveedor'].'-'.scai_get_name($datosseg2["idproveedor"],'proveedores_agentes','idproveedor_agente','idproveedor_agente')."
								</td>
								<td style='color:".$color."'>
									".number_format($datosseg['porcentaje'], 2, '.', ',')."
								</td>
								<td style='color:".$color."'>
									".scai_get_name($datosseg2["moneda"], 'monedas', 'idmoneda', 'codigo')."
								</td>
								<td style='color:".$color."'>".
									number_format($datosseg['minimo'], 2, '.', ',')
								."</td>";
								if(isset($datosseg['monto_aseg']) && $datosseg['monto_aseg']!='' && $datosseg['monto_aseg']!='0'){
									$msg .= "
									<td>".number_format($datosseg['monto_aseg'], 2, '.', ',')."</td>
									<td>".number_format($datosseg['valor'], 2, '.', ',')."</td>";
								}
								$msg .= "
							</tr>";
						}
						$exeseg = mysqli_query($link,$sqlseg);
						$datosseg = mysqli_fetch_array($exeseg);

						if($_GET['cl']=='fcl')
							$idp = '13';
						elseif($_GET['cl']=='lcl')
							$idp = '14';
						elseif($_GET['cl']=='aereo')
							$idp = '25';
						$sql = "select * from parametros where idparametro='$idp'";
						$exe = mysqli_query($link,$sql);
						$cond = mysqli_fetch_array($exe);
						$msg .= "
					</table>
					<table class='tabla' border='0' width='100%'>
						<tr>
							<td colspan='5'>".$cond['valor']."</td>
						</tr>
					</table>";
				}

				$sqlbg = "select * from cot_bodegas where idcot_temp='".$_GET["id"]."'";
				$exebg = mysqli_query($link,$sqlbg);
				$filasbg = mysqli_num_rows($exebg);

				if($filasbg > 0){
					$msg .= "
					<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<td align='center' style='font-size:12px'><strong>".$item++.".SERVICIO DE BODEGA</strong></td>
					</table>
					<br>
					<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<tr>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>REF</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>MND</strong></td>
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>Tarifa ad-valoren/CIF (%)</strong></td>";
							if($_GET['cl']=='lcl') {
								$msg .= "<td bgcolor='#cd1818'style='color:white' align='center'><strong>Minimo Tarifa ad-valoren/CIF</strong></td>";
							}
							$msg .= "
							<td bgcolor='#cd1818'style='color:white' align='center'><strong>";
								if($_GET['cl']=='lcl')
									$msg .=  'Tarifa por mes o fracci&oacute;n';
								elseif($_GET['cl']=='fcl')
									$msg .=  'Tarifa integral para contenedor de 20 por mes o fracci&oacute;n';
								elseif($_GET['cl']=='aereo')
									$msg .=  'Tarifa';

								$msg .= "</strong></td>";

							if($_GET['cl']=='lcl') {
								$msg .= "<td bgcolor='#cd1818'style='color:white' align='center'><strong>Minimo Tarifa por mes o fracci&oacute;n</strong></td>";
							}

							if($_GET['cl']=='fcl') { $msg .= "
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>Tarifa integral para contenedor de 40 por mes o fracci&oacute;n</strong></td> ";
							}
							$sqlm = "select idbodega from bodega where idbodega in (select idbodega from cot_bodegas where idcot_temp='".$_GET["id"]."') and manejo not in ('','0') and min_manejo not in ('','0')";
							$exem = mysqli_query($link,$sqlm);
							$filasm = mysqli_num_rows($exem);
							if($filasm > 0){ $msg .= "
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>Manejo de carga x Kg.</strong></td>
								<td bgcolor='#cd1818'style='color:white' align='center'><strong>Minimo Manejo de carga x Kg.</strong></td>";
							}
							$msg .= "
						</tr>";
						while($datosbg = mysqli_fetch_array($exebg)){
							$sqlbg2="select * from bodega where idbodega='".$datosbg["idbodega"]."'";
							$exebg2=mysqli_query($link,$sqlbg2);
							$datosbg2 = mysqli_fetch_array($exebg2);

							$sqln = "select NOW() as ahora";
							$exen = mysqli_query($link,$sqln);
							$datosn3 = mysqli_fetch_array($exen);
							$color = '#000000';
							if($datosbg2['fecha_validez'] < $datosn3['ahora'])
								$color = '#FF0000';


							$msg .= "
							<tr>
								<td class='contenidotab' style='color:".$color."'>
									".$datosbg2['idproveedor'].'-'.scai_get_name($datosbg2["idproveedor"],'proveedores_agentes','idproveedor_agente','idproveedor_agente')."
								</td>
								<td class='contenidotab' style='color:".$color."'>
									".scai_get_name($datosbg2["moneda"],'monedas', 'idmoneda', 'codigo')."&nbsp;
								</td>
								<td class='contenidotab' style='color:".$color."'>
									".$datosbg['advaloren_venta']."&nbsp;
								</td>";
								if($_GET['cl']=='lcl') { $msg .= "
									<td class='contenidotab' style='color:".$color."'>".number_format($datosbg['min_advaloren'], 2, '.', ',')."&nbsp;</td>";
								}
								$msg .= "
								<td class='contenidotab' style='color:".$color."'>".number_format($datosbg['mes_fraccion_venta'], 2, '.', ',')."&nbsp;</td>";
								if($_GET['cl']=='lcl') { $msg .= "
									<td class='contenidotab' style='color:".$color."'>
										".number_format($datosbg['min_mes_fraccion'], 2, '.', ',')."&nbsp;
									</td>";
								}
								if($_GET['cl']=='fcl'){ $msg .= "
									<td class='contenidotab' style='color:".$color."'>
										".number_format($datosbg['mes_fraccion_40_venta'], 2, '.', ',')."&nbsp;
									</td>";
								}
								$sqlm = "select idbodega from bodega where idbodega in (select idbodega from cot_bodegas where idcot_temp='".$_GET["id"]."') and manejo not in ('','0') and min_manejo not in ('','0')";
								$exem = mysqli_query($link,$sqlm);
								$filasm = mysqli_num_rows($exem);
								if($filasm > 0){
									$msg .= "
									<td class='contenidotab' style='color:".$color."'>".number_format($datosbg2['manejo'], 2, '.', ',')."&nbsp;</td>
									<td class='contenidotab' style='color:".$color."'>
										".$color."&nbsp;
									</td>";
								}
								$msg .= "
							</tr>";
						}
					$msg .= "
					</table>

					<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
						<tr>
							<td>";
								$exebg = mysqli_query($link,$sqlbg);
								$datosbg = mysqli_fetch_array($exebg);
								$msg .=  $datosbg['condiciones'];
								$msg .= "
							</td>
						</tr>
					</table>";
				}

				$msg .= "
				<br>

				<table align='left' width='100%' border='0' class='tabla' cellpadding='0' cellspacing='0'>
					<tr><td align='right' height='10'></td></tr>
					<tr><td align='right' height='10'></td></tr>
					<tr><td align='justify'><strong>CONDICIONES</strong></td></tr>
					<tr><td align='justify'>".msge('texto_condiciones')."</td></tr>

					</tr><tr><td align='right' height='15'></td></tr>



					</tr><tr><td align='right' height='12'></td></tr>
					<tr><td align='justify'>Cordialmente</td></tr>
					<tr><td align='justify'>";

					$sql_sign="select * from usuarios where idusuario='".$row["idusuario"]."'";
					$exe_sql_sign=mysqli_query($link,$sql_sign);
					$row_exe_sql_sign=mysqli_fetch_array($exe_sql_sign);

					$sql_sign2 = "select * from vendedores_customer where idusuario='".$row_exe_sql_sign["idusuario"]."'";
					$exe_sql_sign2=mysqli_query($link,$sql_sign2);
					$row_exe_sql_sign2=mysqli_fetch_array($exe_sql_sign2);


					/*?><div style="float:right"><?*/
					$msg .= "

							<table width='100%' class ='tabla'>
							<tr>
							<td>
								";


									$msg .=  '<br><br>'.$row_exe_sql_sign2['nombre'];
									$msg .=  '<strong><br>'.scai_get_name("$row_exe_sql_sign2[idcargo]","cargos","idcargo","nombre").'</strong>';
									$msg .=  '<br>Address: '.$row_exe_sql_sign2['direccion'];
									$msg .=  '<br>Phone: '.$row_exe_sql_sign2['telefono'];
									$msg .=  '<br>Movil: '.$row_exe_sql_sign2['celular'];
									$msg .=  '<br>E-mail: '.$row_exe_sql_sign2['email'];
									$msg .=  '<br>Web site: http://www.appkigen.co'; 


								/*	$msg .=  '<br>Skype: '.$row_exe_sql_sign2['skype'];*/
									$msg .=  "<br>Bogot&aacute;";

									$idCustomer = scai_get_name($row["idcliente"],'clientes','idcliente','idcustomer');

									$sqlCus = "select * from vendedores_customer where idvendedor_customer = $idCustomer";

									$qryCus = mysqli_query($link,$sqlCus);

									$customer = mysqli_fetch_array($qryCus);

									$msg .= "


							</td>
					<!---	<td>
								";
									$msg .=  '<br><br>'.$customer['nombre'];
									$msg .=  '<strong><br>'.scai_get_name($customer["idcargo"],"cargos","idcargo","nombre").'</strong>';
									$msg .=  '<br>Address: '.$customer['direccion'];
									$msg .=  '<br>Phone: '.$customer['telefono'];
									$msg .=  '<br>Movil: '.$customer['celular'];
									$msg .=  '<br>E-mail: '.$customer['email'];
					  /*		$msg .=  '<br>Web site: http://www.gatewayairfreight.com.co';
									$msg .=  '<br>Skype: '.$customer['skype'];*/
									$msg .=  "<br>Bogot&aacute;";
									$msg .= "

							</td>-->
							</tr>
							</table>



					<div>";
						$msg .= "<div style='background-color:#000099;float:left'><div>";


						$msg .= "<div style='background-color:#000099;float:right'><div>";
					$msg .= "

					</div>";




					$msg .= "
					</td></tr>
					</tr><tr><td align='right' height='12'></td></tr>
					<tr><td align='center' style='color:#999999;'>".msge('texto_pie_de_pagina')."</td></tr>
				</table>
				<br>";
	?>


<script>
	function mostrar_div(id){
		var capa = document.getElementById(id);


		if(capa.style.display=="none")
			capa.style.display = "block";
		else
			capa.style.display = "none";


	}

</script>

<div id="liquidador" style="display:none">
	<input type="button" value="Cotizaci��n" onClick="mostrar_div('email');mostrar_div('liquidador')">
	<? include("liquidador.php");?>
</div>


<div id="email" style="display:block">
	<input type="button" value="Liquidador" onClick="mostrar_div('email');mostrar_div('liquidador')">
	<form method="post" target="_blank" name="form">
		<? echo $msg;?>

		<input type="hidden" value="<? echo $_GET['id']?>" name="id_cot">

		<textarea name="txt_msg" style="visibility:hidden"><? echo $msg;?></textarea>
		<textarea name="txt_liq" style="visibility:hidden"><? echo $liquidador;?></textarea>

		<input type="submit" class="botonesadmin" style="font-size:11px; color:#FFFFFF;" value="Exportar a Word" name="exportar" onClick="form.action='export.php?id=<? print $_GET['idcot_temp'];?>&cl=<? print $_GET['cl'] ?>&opc=word'">

		<input type="submit" class="botonesadmin" style="font-size:11px; color:#FFFFFF;" value="Enviar a email" name="exportar" onClick="form.action='export.php?id=<? print $_GET['idcot_temp'];?>&cl=<? print $_GET['cl'] ?>&opc=email'">
	</form>
</div>





</p>



</body>