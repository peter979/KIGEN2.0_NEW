<body>
<form method="post" action="">
	<p>
	<?
	$sql_otm = "SELECT 
					otm.nombre as nombre_otm, 
					cot_otm.valor_venta, 
					cot_otm.idcot_otm, 
					tipotm.nombre
				FROM 
					otm, 
					cot_otm, 
					tipotm
				WHERE 
					cot_otm.idotm = otm.idotm
					AND otm.idtipotm = tipotm.idtipotm
					AND cot_otm.idcot_temp =". $_GET['id']."";
	
	$qry_otm20 = mysqli_query($link,$sql_otm ." and tipotm.nombre = '20'");
	$qry_otm40 = mysqli_query($link,$sql_otm ." and tipotm.nombre = '40'");
	$qry_otm40hq = mysqli_query($link,$sql_otm ." and tipotm.nombre = '40hq'");
	$qry_otmlcl = mysqli_query($link,$sql_otm);
	?>
	<table class="tabla" cellpadding="6">
		<tr>
			<td>Valor Euro en dolares</td>
			<td><input type="text" name="euro_en_dolar" size="3" value="<? echo $_POST['euro_en_dolar']?>"></td>
			<td>Valor Dolar en Pesos (TRM)</td>
			<td><input type="text" name="dolar_en_pesos"  size="3"  value="<? echo $_POST['dolar_en_pesos']?>"></td>
		</tr>
	</table>
	</p>
	<p>	
	<? if($_GET['cl']=="fcl"){?>
	<table cellpadding="5"  class="tabla" >
		<tr>
			<td>&nbsp;</td>
			<td>20</td>
			<td>40</td>
			<td>40HQ</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="text" name="no_20" id="no_20" size="3" value="<? echo $_POST['no_20']?>"></td>
			<td><input type="text" name="no_40" id="no_40" size="3" value="<? echo $_POST['no_40']?>"></td>
			<td><input type="text" name="no_40hq" id="no_40hq" size="3" value="<? echo $_POST['no_40hq']?>"></td>
		</tr>
		
	<!--Muestra listado de Otm's seleccionadas desde la cotizacion, para que el usuario pueda seleccionar una de ellas y generar una preliquidacion-->
		<tr><td>OTM: </td>
			<td>
				<? if( mysqli_num_rows($qry_otm20) > 0 ){?>
					<select name="otm20" style="width:50px">
						<option></option>
						<? while($otm20 = mysqli_fetch_array($qry_otm20)){?>
							<option value="<? echo $otm20["idcot_otm"]?>" <? echo ($otm20["idcot_otm"] == $_POST['otm20']) ? "selected='selected'" : ""?>><? echo $otm20["nombre_otm"]?></option>
						<? }?>
					</select>
				<? }?>
			</td>
			<td>
				<? if( mysqli_num_rows($qry_otm40) > 0 ){?>
					<select name="otm40" style="width:50px">
						<option></option>
						<? while($otm40 = mysqli_fetch_array($qry_otm40)){?>
							<option value="<? echo $otm40["idcot_otm"]?>" <? echo ($otm40["idcot_otm"] == $_POST['otm40']) ? "selected='selected'" : ""?>><? echo $otm40["nombre_otm"]?></option>
						<? }?>
					</select>
				<? }?>

			</td>
			<td>
				<? if( mysqli_num_rows($qry_otm40hq) > 0 ){?>
					<select name="otm40hq" style="width:50px">
						<option></option>
						<? while($otm40hq = mysqli_fetch_array($qry_otm40hq)){?>
							<option value="<? echo $otm40hq["idcot_otm"]?>" <? echo ($otm40hq["idcot_otm"] == $_POST['otm40hq']) ? "selected='selected'" : ""?>><? echo $otm40hq["nombre_otm"]?></option>
						<? }?>
					</select>
				<? }?>

			</td>
		</tr>
	</table>
	
	

	
	
	<? }elseif($_GET['cl']=="lcl"){?>
		<table cellpadding="5"  class="tabla" >
			<tr>
				<td>Tonelada</td>
				<td>M3</td>
			</tr>
			<tr>
				<td><input type="text" name="tonelada" id="tonelada" size="3" value="<? echo $_POST['tonelada'] ?>"></td>
				<td><input type="text" name="m3" id="m3" size="3" value="<? echo $_POST['m3'] ?>"></td>
			</tr>
			<tr>
				<td>OTM</td>
				<td>
				<? if( mysqli_num_rows($qry_otmlcl) > 0 ){?>
					<select name="otmlcl" style="width:50px">
						<option></option>
						<? while($otmlcl = mysqli_fetch_array($qry_otmlcl)){?>
							<option value="<? echo $otmlcl["idcot_otm"]?>" <? echo ($otmlcl["idcot_otm"] == $_POST['otmlcl']) ? "selected='selected'" : ""?>><? echo $otmlcl["nombre_otm"]?></option>
						<? }?>
					</select>
				<? }?>
				</td>
			</tr>
		</table>
		
	<? }elseif($_GET['cl']=="aereo"){?>
		<table cellpadding="5"  class="tabla" >
			<tr>
				<td>Kilo Cargable</td>
			</tr>
			<tr>
				<td><input type="text" name="kilo_c" id="kilo_c" size="3" value="<? echo $_POST['kilo_c']?>"></td>
			</tr>
		</table>
	<? }?>
	</p>
	

	<p>
		<center><input type="submit" value="calcular" ></center>
	</p>
	<!--MARGENES-------------------------------------------------------------------------------------->
	<?
	$sql="select * from cot_temp where idcot_temp ='".$_GET["id"]."'";
	$exe_sql=mysqli_query($link,$sql);
	$row=mysqli_fetch_array($exe_sql);
	
	
	$sqlf = "select * from cot_fletes where idcot_temp='".$_GET["id"]."'";
	$exef = mysqli_query($link,$sqlf);
	$filasf = mysqli_num_rows($exef);


	//Halla el numero por el cual se van a multiplicar todos los conceptos de la cotizacion
	if( $_GET['cl'] == "lcl" ){ //lcl
		//el mayor entre el peso y la medida sera por el que se multiplica, si son iguales o no hay nada pondr� 1
		if((float)$_POST['tonelada'] > (float)$_POST['m3']) 
			$multiplicador = $_POST['tonelada'];
		elseif((float)$_POST['tonelada'] < (float)$_POST['m3'])
			$multiplicador = $_POST['m3'];
		else
			$multiplicador = 1;
	}elseif($_GET['cl'] == "aereo"){//aereo
		if(is_numeric( $_POST['kilo_c']))
			$multiplicador = $_POST['kilo_c'];
		else
			$multiplicador = 1;
	}else
		$multiplicador = 1;


	
	$liquidador .= "
	<p>
	<table border='1'  class='tabla' align='center' width='50%' style='text-align:center;border-collapse:collapse'>
		<tr>
			<td align='center'  bgcolor='#a01313' colspan='2'  style='color:#FFFFFF'>
				<H4>PRE-LIQUIDADOR ".strtoupper($_GET['cl'])."</H4>
			</td>
		</tr>";
		
		if($_POST['euro_en_dolar']){
			$liquidador .= "
			<tr>
				<td bgcolor='#a01313' width='50%' style='color:#FFFFFF'>
					<H5>Valor Euro en dolares:</H5>
				</td>
				<td>
					".$_POST['euro_en_dolar']."
				</td>
			</tr>";
		
		}
		if($_POST['dolar_en_pesos']){
			$liquidador .="
			<tr>
				<td bgcolor='#a01313' width='50%' style='color:#FFFFFF'>
					<H5>Valor Dolar en Pesos:</H5>
				</td>
				<td>
					".$_POST['dolar_en_pesos']."
				</td>
			</tr>";
		}
		
		if($_GET['cl'] == 'fcl'){
			if($_POST['no_20']){
				$liquidador .= "
				<tr>
					<td bgcolor='#a01313' width='50%' style='color:#FFFFFF'>
						<H5>Contenedores de 20:</H5>
					</td>
					<td>
						".$_POST['no_20']."
					</td>
				</tr>";
			}
			if($_POST['no_40']){
				$liquidador .="
				<tr>
					<td bgcolor='#a01313' width='50%' style='color:#FFFFFF'>
						<H5>Contenedores de 40:</H5>
					</td>
					<td>
						".$_POST['no_40'] ."
					</td>
				</tr>";
			}
			if($_POST['no_40hq']){
				$liquidador .= "
				<tr>
					<td bgcolor='#a01313' width='50%' style='color:#FFFFFF'>
						<H5>Contenedores de 40 Hq:</H5>
					</td>
					<td>
						".$_POST['no_40hq'] ."
					</td>
				</tr>";
			}
			if($_POST['otm20']){
				$sql_otm=mysqli_query($link,"select nombre from otm where idotm = (select idotm from cot_otm where idcot_otm = ".$_POST['otm20'].") ");
				$exe_otm=mysqli_fetch_array($sql_otm);
				$liquidador .= "
				<tr>
					<td bgcolor='#a01313' width='50%' style='color:#FFFFFF'>
						<H5>Otm de 20:</H5>
					</td>
					<td>
						".$exe_otm["nombre"]."
					</td>
				</tr>";
				
				
			}
			if($_POST['otm40']){
				$sql_otm=mysqli_query($link,"select nombre from otm where idotm = (select idotm from cot_otm where idcot_otm = ".$_POST['otm40'].") ");
				$exe_otm=mysqli_fetch_array($sql_otm);
				$liquidador .= "
				<tr>
					<td bgcolor='#a01313' width='50%' style='color:#FFFFFF'>
						<H5>Otm de 40:</H5>
					</td>
					<td>
						".$exe_otm["nombre"]."
					</td>
				</tr>";
			}
		}elseif($_GET['cl'] == 'lcl'){
			if($_POST['tonelada']){
				$liquidador .= "
				<tr>
					<td bgcolor='#a01313' width='50%' style='color:#FFFFFF'>
						<H5>Tonelada</H5>
					</td>
					<td>
						".$_POST['tonelada'] ."
					</td>
				</tr>";
			}
			if($_POST['m3']){
				$liquidador .= "
				<tr>
					<td bgcolor='#a01313' width='50%' style='color:#FFFFFF'>
						<H5>M 3:</H5>
					</td>
					<td>
						".$_POST['m3'] ."
					</td>
				</tr>";
			}
			if($_POST['otmlcl']){
				$sql_otm=mysqli_query($link,"select nombre from otm where idotm = (select idotm from cot_otm where idcot_otm = ".$_POST['otmlcl'].") ");
				$exe_otm=mysqli_fetch_array($sql_otm);
				$liquidador .= "
				<tr>
					<td bgcolor='#a01313' width='50%' style='color:#FFFFFF'>
						<H5>Otm Lcl:</H5>
					</td>
					<td>
						".$exe_otm["nombre"]."
					</td>
				</tr>";
			}
		}elseif($_GET['cl'] == 'aereo'){
			if($_POST['kilo_c']){
				$liquidador .= "
				<tr>
					<td bgcolor='#a01313' width='50%' style='color:#FFFFFF'>
						<H5>Kilo Cargable:</H5>
					</td>
					<td>
						".$_POST['kilo_c']."
					</td>
				</tr>";
			}
		
		}
		$liquidador .= "
		
	</table>
	</p>";



	//Encabezado!
	//FLETE FCL
	if($filasf > 0 && $_GET['cl'] == 'fcl'){
		$no_20= (is_numeric($_POST['no_20'])) ? $_POST['no_20'] : 1;
		$no_40= (is_numeric($_POST['no_40'])) ? $_POST['no_40'] : 1;
		$no_40hq= (is_numeric($_POST['no_40hq'])) ? $_POST['no_40hq'] : 1;
		
		$liquidador .= "
		<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
			<td align='center' style='font-size:12px'><strong>FLETE MARITIMO INTERNACIONAL</strong></td>
		</table>
		<br>
		<table border='1' cellpadding='6' cellspacing='0' class='tabla' align='center' width='70%'>
			<tr>
				<td bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>FLETE</strong></td>";
				$liquidador .= ($filasr20 > 0) ? "<td bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>20</strong></td>" : "";

				$liquidador .= ($filasr40 > 0) ? "<td bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>40</strong></td>" : "";

				$liquidador .= ($filasr40hq > 0) ? "<td bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>40 H.Q</strong></td>": "";
				
				$liquidador .= "<td bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>Valor en Dolares</strong></td>";
				

				$sqlt = "select * from tarifario where idtarifario in(select distinct idtarifario from cot_fletes where idcot_temp='".$_GET["id"]."') ";

				$exet = mysqli_query($link,$sqlt);							
				
				
				while($datost = mysqli_fetch_array($exet)){
					$moneda = scai_get_name("$datost[moneda]","monedas", "idmoneda", "codigo");	
					$liquidador .= "
					<tr>
						<td style='color:".$color."'>".
							scai_get_name("$datost[puerto_origen]","aeropuertos_puertos","idaeropuerto_puerto","nombre")."-".scai_get_name("$datost[puerto_destino]","aeropuertos_puertos","idaeropuerto_puerto","nombre")."
						</td>";

						$sql_flete = "select * from cot_fletes where idcot_temp='".$_GET["id"]."' and idtarifario='".$datost["idtarifario"]."' ";
						
						$qry_flete = mysqli_query($link,$sql_flete);
						$flete = mysqli_fetch_array($qry_flete);
						
						
						if($filasr20 > 0){ 
							$liquidador .= "
							<td style='color:".$color."'>";
								$liquidador .= ($datos20['fleteventa']!='') ? ($flete["all_in_20"] * $no_20) : "";
								
								$valor_flete += ($flete["all_in_20"] * $no_20); 
								$liquidador .= " $moneda &nbsp;
							</td>";

						}
						if($filasr40 > 0){
							$liquidador .= "
							<td style='color:".$color."'>";
								$liquidador .= ($datos40['fleteventa']!='') ? ($flete["all_in_40"]* $no_40) :"";
								
								$valor_flete += ($flete["all_in_40"] * $no_40); 
								$liquidador .= " $moneda &nbsp;
							</td>";
						}
						if($filasr40hq > 0){
							$liquidador .= "
							<td style='color:".$color."'>";
								$liquidador .= ($datos40hq['fleteventa']!='') ? ($flete["all_in_40hq"] * $no_40hq) :"";
								
								$valor_flete += ($flete["all_in_40hq"] * $no_40hq); 
								$liquidador .="
								 $moneda &nbsp;
							</td>";
						}
						
						if($moneda =="EURO"){
							if(!$_POST['euro_en_dolar'])
								$liquidador .= "<td>Digite el valor del Euro en Dolares</td>";
							else{
								$liquidador .= "<td>".$valor_flete * $_POST['euro_en_dolar']."</td>";
								$total_concepto += $valor_flete * $_POST['euro_en_dolar'];
							}
						}elseif($moneda =="COP"){
							if(!$_POST['dolar_en_pesos'])
								$liquidador .= "<td>Digite el valor del Dolar en Pesos</td>";
							else{
								$liquidador .= "<td>". number_format($valor_flete / $_POST['dolar_en_pesos'],2) ."</td>";
								$total_concepto += number_format($valor_flete / $_POST['dolar_en_pesos'],2,".","") ;
							}
						}else{
							$liquidador .= "<td>".$valor_flete."</td>";
							$total_concepto += $valor_flete;
						}
						
							

					$liquidador .="</tr>";
					$valor_flete =0;
				}
				$total_cot += $total_concepto;
			$liquidador .= "
			<tr><td colspan='5' bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong> Total Flete: $total_concepto USD</strong></td></tr>
		</table>
		<br>";
	}
	


	//FLETE LCL
	if($filasf > 0 && $_GET['cl'] == 'lcl'){
		$liquidador .= "
		<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='70%'>
			<td align='center' style='font-size:12px'><strong>FLETE MARITIMO INTERNACIONAL</strong></td>
		</table>
		<br>
		<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='65%'>
			<tr>
				<td bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>FLETE</strong></td>
				<td bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>Total</strong></td>
				<td bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>Total en Dolares</strong></td>
			</tr>";
			

				$sqlt = "select * from cot_fletes where idcot_temp='".$_GET['id']."' group by (idtarifario)";

				$exet = mysqli_query($link,$sqlt);
				
				$total_concepto = 0;
				while($datost = mysqli_fetch_array($exet)){
					$liquidador .= "
					<tr> 
						<td>";
							$id_origen = scai_get_name($datost["idtarifario"],"tarifario","idtarifario","puerto_origen");
							$liquidador .="".scai_get_name($id_origen,"aeropuertos_puertos","idaeropuerto_puerto","nombre")." - "; 
							
							$id_destino = scai_get_name($datost["idtarifario"],"tarifario","idtarifario","puerto_destino");
							$liquidador .="".scai_get_name($id_destino,"aeropuertos_puertos","idaeropuerto_puerto","nombre");
							$liquidador .= "
						</td>
						<td>";
						
						
							$idmoneda =scai_get_name($datost["idtarifario"],"tarifario", "idtarifario", "moneda");
							$moneda = scai_get_name($idmoneda,"monedas", "idmoneda", "codigo");	
							
							$valor_flete = ($datost["fleteventa"] * $multiplicador < $datost["minimo_venta"]) ? $datost["minimo_venta"]  : $datost["fleteventa"] * $multiplicador;
							
							$liquidador .= " ".$valor_flete . " " . $moneda." " ;
							
							
							
						$liquidador .="
						</td>
						<td>";
							//$valor_flete *= $multiplicador ;
							if($moneda =="EURO"){
								if(!$_POST['euro_en_dolar'])
									$liquidador .= "Digite el valor del Euro en Dolares";
								else{
									$liquidador .= $valor_flete * $_POST['euro_en_dolar'];
									$total_concepto += $valor_flete * $_POST['euro_en_dolar'];
								}
							}elseif($moneda =="COP"){
								if(!$_POST['dolar_en_pesos'])
									$liquidador .= "<td>Digite el valor del Dolar en Pesos</td>";
								else{
									$liquidador .= "<td>". number_format($valor_flete / $_POST['dolar_en_pesos'],2) ."</td>";
									$total_concepto += number_format($valor_flete / $_POST['dolar_en_pesos'],2,".","");
								}
							}else{
								$liquidador .= $valor_flete;
								$total_concepto += $valor_flete;
							}				
							$liquidador .= "
						
						</td>
					</tr>";
					
				}
				$total_cot += $total_concepto;
				$liquidador .= "
				<tr>
					<td colspan ='3'  bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>Total Flete : $total_concepto USD</strong></td>
				</tr>

		</table>
		<br>";
	}

	//FLETE AEREO
	if($_GET['cl'] == 'aereo'){ $liquidador .= "
		<table border='0' cellpadding='2' cellspacing='0' class='tabla' align='center' width='100%'>
			<td align='center' style='font-size:12px'><strong>FLETE AEREO INTERNACIONAL</strong></td>
		</table>
		<br>
		<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='70%'>
			<tr>
				<td bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>ORIGEN</strong></td>
				<td bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>DEST</strong></td>";
				$liquidador .= "<td bgcolor='#a01313' ><strong>Total(";
					$liquidador .= ($filasr_normal > 0) ? "Normal": "";
					$liquidador .= ($filasr45 > 0) ? "+45kg" : "";
					$liquidador .= ($filasr100 > 0) ? "+100kg" : "";
					$liquidador .= ($filasr300 > 0) ? "+300kg" : "";
					$liquidador .= ($filasr500 > 0) ? "+500kg" : "";
					$liquidador .= ($filasr1000 > 0) ? "+1000kg" : "";
				$liquidador .= ")</strong></td>
				<td bgcolor='#a01313'><strong>Valor en Dolares</strong></td>
				
				";



				$liquidador .= "
			</tr>";
			$sqlc = "select distinct idtarifario_aereo from cot_fletes_aereo where idcot_temp='".$_GET["id"]."'";
			$exec = mysqli_query($link,$sqlc);
			
			$x=0;
			$total_concepto =0;
			while($datosc= mysqli_fetch_array($exec)){
				$sqlt = "select * from tarifario_aereo where idtarifario_aereo='".$datosc["idtarifario_aereo"]."'";
				$exet = mysqli_query($link,$sqlt);
				while($datost = mysqli_fetch_array($exet)){

					$liquidador .= "
					<tr>
						<td>".scai_get_name($datost["aeropuerto_origen"],'aeropuertos_puertos','idaeropuerto_puerto','nombre')."</td>
						<td>".scai_get_name($datost["aeropuerto_destino"],'aeropuertos_puertos','idaeropuerto_puerto','nombre')."</td>";
						if($_POST['kilo_c']){
							if($filasr_normal > 0)
								$valor_flete = $aer_normal[$x];
							elseif($filasr45 > 0 && $_POST['kilo_c'] >= 45 && $_POST['kilo_c'] < 100)
								$valor_flete = $aer_45[$x] * $multiplicador;
							elseif($filasr100 > 0 && $_POST['kilo_c'] >= 100 && $_POST['kilo_c'] < 300)
								$valor_flete = $aer_100[$x] * $multiplicador;
							elseif($filasr300 > 0 && $_POST['kilo_c'] >= 300 && $_POST['kilo_c'] < 500)
								$valor_flete = $aer_300[$x] * $multiplicador;
							elseif($filasr500 > 0 && $_POST['kilo_c'] >= 500 && $_POST['kilo_c'] < 1000)
								$valor_flete = $aer_500[$x] * $multiplicador;
							elseif($filasr1000 > 0 && $_POST['kilo_c'] >= 1000)
								$valor_flete = $aer_1000[$x] * $multiplicador;
							
							
							$moneda = scai_get_name($datost["moneda"],'monedas', 'idmoneda', 'codigo');
							
							//si el flete es menor que el minimo, suma el minimo

							if($valor_flete  < $aer_minimo[$x])
								$valor_flete = $aer_minimo[$x] ;
							
							
							
							$liquidador .= "<td>$valor_flete $moneda</td>";
							
							
							//si la moneda es Euros, lo multiplica por el valor del euro en dolares
							if($moneda =="EURO") {
								if(!$_POST['euro_en_dolar'])
									$total_flete .= "Digite el Valor del Euro en Dolares";
								else
									$total_flete += $valor_flete * $_POST['euro_en_dolar'];
							}elseif($moneda =="COP"){
								if(!$_POST['dolar_en_pesos'])
									$valor_rec = "Digite el Valor del Dolar en Pesos";
								else
									$valor_rec = number_format($valor_rec / $_POST['dolar_en_pesos'],2,".","") ;
							}
							
							$total_flete += $valor_flete ;
								
									
							$liquidador .= " <td>$total_flete</td>";
							$x++;
						}else{
							$liquidador .= " <td colspan ='2' align='center'><strong>Digite el Kilo Cargable</strong></td>";
						}
						$liquidador .= "
					</tr>";
				$total_concepto += $total_flete;
				$total_flete =0;
				}			
			}
			$total_cot += $total_concepto;
			$liquidador .= "
			<tr><td colspan='4' align='center'style='color:#FFFFFF' bgcolor='#a01313'><strong>Total Flete: $total_concepto USD</strong></td></tr>
		</table>
		<br>";
	}//Termina impresion de fletes
	



	//Recargos Origen
	$sql_rec = "
	SELECT recargos_origen.nombre as nombre, 
			recargos_origen.tipo_cont as tipo_cont, 
			recargos_origen.moneda as moneda, 
			recargos_origen.tipo as tipo, 
			origen_por_cotizacion.valor_venta as valor,
			origen_por_cotizacion.minimo_venta  as minimo,
			cotizacion_origen.mostrar_var as mostrar_var
	FROM recargos_origen, 
			origen_por_cotizacion,
			cotizacion_origen
	WHERE 
		recargos_origen.idrecargo_origen = origen_por_cotizacion.idrecargo_origen 
		and origen_por_cotizacion.idcotizacion_origen = cotizacion_origen.idcotizacion_origen 
		and cotizacion_origen.idcot_temp =".$_GET['id']."";
	

	//echo $sql_rec;
	$qry_rec=mysqli_query($link,$sql_rec);
	
	$total_concepto=0;

	if(mysqli_num_rows($qry_rec) > 0){
		$liquidador .= "
		<p>
		<table border='1' cellpadding='3' cellspacing='0' class	='tabla' align='center' width='70%'>
			<tr><td bgcolor='#a01313'style='color:#FFFFFF' align='center' colspan='4'><strong>RECARGOS ORIGEN</strong></td></tr>
			<tr>
				<td bgcolor='#a01313'style='color:#FFFFFF' align='center' ><strong>Recargo</strong></td>";

				$liquidador .= ($_GET['cl']=="fcl") ? "<td bgcolor='#a01313' style='color:#FFFFFF'><strong>Tipo de Contenedor</strong></td>":"";
				
				$liquidador .="
				<td style='color:#FFFFFF' bgcolor='#a01313'><strong>Valor</strong></td>
				<td style='color:#FFFFFF' bgcolor='#a01313'><strong>Valor en Dolares</strong></td>
			</tr>";
			
			while($recargo_o = mysqli_fetch_array($qry_rec)){
				//el recargo en fcl es deacuerdo al tipo de contenedor, en aereo y lcl no importa
				if($recargo_o["tipo_cont"] =="20")
					$multiplicador = (is_numeric($_POST['no_20'])) ? $_POST['no_20'] : 1;
				elseif($recargo_o["tipo_cont"] =="40")
					$multiplicador = (is_numeric($_POST['no_40'])) ? $_POST['no_40'] : 1;
				elseif($recargo_o["tipo_cont"] =="40hq")
					$multiplicador = (is_numeric($_POST['no_40hq'])) ? $_POST['no_40hq'] : 1;

				
			
				$liquidador .= "
				<tr>";
					$liquidador .= ($recargo_o['mostrar_var']=="1") ? "<td>".$recargo_o['nombre']."-". ucfirst($recargo_o['tipo']) ."</td>":"<td>Gastos</td>";
					$liquidador .=($_GET['cl']=="fcl") ? "<td>".$recargo_o['tipo_cont']."&nbsp;</td>": "" ;
					$liquidador .= "
					<td>";

						//Si el recargo es por contenedor multiplica por numero de contenedores, si es hbl no

						if( strtolower($recargo_o['tipo'])  == "hbl" || strtolower($recargo_o['tipo']) == "hawb" ){
							//si es menor que el minimo pone el menor
							$valor_rec = ($recargo_o['valor'] < $recargo_o['minimo'] ) ? $recargo_o['minimo'] : $recargo_o['valor'];
						}else{
							//si es menor que el minimo pone el menor si no lo multiplica por el peso
							$valor_rec = (($recargo_o['valor'] * $multiplicador) < $recargo_o['minimo'] ) ? $recargo_o['minimo'] : $recargo_o['valor'] * $multiplicador;						
						}
					
						
						
						$moneda = scai_get_name($recargo_o["moneda"],"monedas","idmoneda","codigo");
						$liquidador .= "$valor_rec $moneda	
						
					</td>
					<td>";
						if($recargo_o["tipo"] =="cont" && $recargo_o["tipo_cont"] ==""){
							$valor_rec = "Selecccione un Tipo de contenedor desde el tarifario";
						}else{
							if($moneda =="EURO") {
								if(!$_POST['euro_en_dolar'])
									$valor_rec = "Digite el Valor del Euro en Dolares";
								else
									$valor_rec = $valor_rec * $_POST['euro_en_dolar'];
							}elseif($moneda =="COP"){
								if(!$_POST['dolar_en_pesos'])
									$valor_rec = "Digite el Valor del Dolar en Pesos";
								else
									$valor_rec = number_format($valor_rec * $_POST['dolar_en_pesos'],2,".","") ;
							}
						}
						$liquidador .="
						$valor_rec
					</td>
				</tr>";
				$total_concepto += $valor_rec;
				$valor_rec=0;
				
			}
			$liquidador .= "
			<tr><td colspan ='4' align ='center'style='color:#FFFFFF'  bgcolor='#a01313'	><strong>Total Recargos: $total_concepto USD</strong></td></tr>	
		</table>
		</p>";
		$total_cot +=$total_concepto;
	}
	//Termina impresion de recargos de origen	
	

		
	//Almacena el valor del collection fee, el cual es la suma del total del flete con el total del recargo de origen
	$ValorCollF = $total_cot;
	

	//Seguro
	$sql_seg = "select * from cot_seg where idcot_temp='".$_GET["id"]."'";
	$qry_seg=mysqli_query($link,$sql_seg);
	
	$total_concepto=0;
	if(mysqli_num_rows($qry_seg) > 0){
		
		
		$liquidador .= "
		<p>
		<table border='1' cellpadding='3' cellspacing='0' class	='tabla' align='center' width='70%'>
			<tr><td bgcolor='#a01313'style='color:#FFFFFF' align='center' colspan='2'><strong>SEGURO</strong></td></tr>
			<tr>
				<td bgcolor='#a01313'style='color:#FFFFFF' align='center' ><strong>Valor del Seguro</strong></td>
				<tdstyle='color:#FFFFFF' bgcolor='#a01313'><strong>Valor</strong></td>";
				
				$liquidador .="
			</tr>";
			while($seguro = mysqli_fetch_array($qry_seg)){
				$total_concepto += $seguro["porcentaje"] * $seguro["monto_aseg"] / 100;
				$total_concepto = ($total_concepto < $seguro["minimo"]) ? $seguro["minimo"] : $total_concepto;
				$liquidador .= "
				<tr>
					<td>".$seguro["porcentaje"]."% de ".$seguro["monto_aseg"]." USD</td>
					<td>".$total_concepto."</td>
				</tr>";

			}
			$liquidador .= "
			<tr><td colspan ='4' align ='center' style='color:#FFFFFF' bgcolor='#a01313'>
				<strong>Total Seguro: $total_concepto USD</strong></td></tr>	
		</table>
		</p>";
		$total_cot +=$total_concepto;
	}
	//Termina impresion de Seguro
	
	
	
	//Inicia Impresion de otm
	if($_POST['otm20'] || $_POST['otm40'] || $_POST['otm40hq'] || $_POST['otmlcl'] ){ //Si hay alguna otm selecccionada muestra la tabla, de lo contrario no
		$liquidador .= "
		<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='70%'>
			<tr>
				<tr><td bgcolor='#a01313'style='color:#FFFFFF' align='center' colspan='5'><strong>OTM</strong></td></tr>";

		if($_POST['dolar_en_pesos']){ // Las otms estan en pesos, por lo tanto debe digitarse el valor del dolar en pesos
			$liquidador .= "<p>";
		
			if($_GET['cl'] == "fcl"){
				$otm_qry20 = mysqli_query($link,"select * from cot_otm where idcot_otm = ".$_POST['otm20'] ) ;
				$otm_qry40 = mysqli_query($link,"select * from cot_otm where idcot_otm = ".$_POST['otm40'] ) ;
				$otm_qry40hq = mysqli_query($link,"select * from cot_otm where idcot_otm = ".$_POST['otm40hq'] ) ;
				
				$otm20 = ($otm_qry20) ? mysqli_fetch_array($otm_qry20) : NULL;
				$otm40 = ($otm_qry40) ? mysqli_fetch_array($otm_qry40) : NULL;
				$otm40hq = ($otm_qry40hq) ? mysqli_fetch_array($otm_qry40hq) : NULL;
				
				$liquidador .= "
							<tr bgcolor='#a01313' style='font-weight:bold;text-align:center'>";
								$liquidador .= ($_POST['otm20']) ? "<td>Valor 20</td>" : "";
								$liquidador .= ($_POST['otm40']) ? "<td>Valor 40</td>" : "";
								$liquidador .= ($_POST['otm40hq']) ? "<td>Valor 40</td>" : "";
		
								$liquidador .="
								<td>Valor en D�lares</td>
							</tr>
							<tr>";
								if($_POST['otm20']){
									$valor_otm = number_format(($otm20["valor_venta"]  * $no_20) / $_POST['dolar_en_pesos'],2,",","");
									$valor_rec +=$valor_otm;
									$liquidador .= "<td>$valor_otm USD</td>";
								}
								
								if($_POST['otm40']){
									$valor_otm = number_format(($otm40["valor_venta"]  * $no_40) / $_POST['dolar_en_pesos'],2,",","");
									$valor_rec +=$valor_otm;
									$liquidador .= "<td>$valor_otm USD</td>";
								}
								
								if($_POST['otm40hq']){
									$valor_otm = number_format(($otm40hq["valor_venta"]  * $no_40hq) / $_POST['dolar_en_pesos'],2,",","");
									$valor_rec +=$valor_otm;
									$liquidador .= "<td>$valor_otm USD</td>";
								}

								$liquidador .="
								
								<td>$valor_rec USD</td>
						</tr>
						<tr><td colspan ='5' align ='center' style='color:#FFFFFF' bgcolor='#a01313'>
							<strong>Total Otm: $valor_rec  USD</strong></td></tr>
						
				";
				$total_cot +=$valor_rec;
			}elseif($_GET['cl'] == "lcl"){
				$otm_qrylcl = mysqli_query($link,"select * from cot_otm where idcot_otm = ".$_POST['otmlcl'] ) ;
				
				$otmlcl = ($otm_qrylcl) ? mysqli_fetch_array($otm_qrylcl) : NULL;
				
				$liquidador .= "
					<tr bgcolor='#a01313' style='font-weight:bold;text-align:center'>";
						$liquidador .= "<td>Valor</td>";

						$liquidador .="
						<td>Valor en D�lares</td>
					</tr>
					<tr>";
						if($_POST['otmlcl']){
							$valor_otm = number_format(($otmlcl["valor_venta"]  * $multiplicador) / $_POST['dolar_en_pesos'],2,",","");
							$valor_rec +=$valor_otm;
							$liquidador .= "<td>$valor_otm USD</td>";
						}
						$liquidador .="
						
						<td>$valor_rec USD</td>
				</tr>
				<tr><td colspan ='5' align ='center'style='color:#FFFFFF'  bgcolor='#a01313'>
					<strong>Total Otm: $valor_rec  USD</strong></td></tr>";
					
				$total_cot +=$valor_rec;
			}
		}else
			$liquidador .= "<tr><td colspan = '4'><font style='color:#CC0000'>Digite el valor del d�lar en pesos</font></td></tr>";
			
			$liquidador .= "
		</table>
		</p>";
	}
	//Termina Impresion de Otm
	
	
	
	//Inicia impresion de Recargos Locales cliente
	$sql_rec_cli="
	select recargos_local_cliente.nombre as nombre, 
		recargos_local_cliente.tipo as tipo, 
		recargos_local_cliente.moneda as moneda,
		
		local_por_cliente.valor_venta as valor, 
		local_por_cliente.minimo_venta as minimo,
		
		
		totales_cliente_local.mostrar_var as mostrar_var,
		totales_cliente_local.collection_fee as collection_fee,
		totales_cliente_local.min_collection_fee as min_collection_fee,
		totales_cliente_local.caf as caf,
		totales_cliente_local.min_caf as min_caf,
		totales_cliente_local.mostrar_collection_fee as mostrar_coll,
		totales_cliente_local.mostrar_caf as mostrar_caf
	from local_por_cliente, 
		recargos_local_cliente,
		totales_cliente_local
	where 
		local_por_cliente.idcot_temp='".$_GET['id']."'
		and  local_por_cliente.idrecargo_local = recargos_local_cliente.idrecargo_local_cliente
		and totales_cliente_local.idcot_temp = ".$_GET['id'];
		
		
	//echo $sql_rec_cli;
	$qry_rec_cli = mysqli_query($link,$sql_rec_cli);
	
	$total_concepto=0;
	$colspan=0;
	if(mysqli_num_rows($qry_rec_cli) > 0){
		$liquidador .= "<p>
		
		<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='70%'>
			<tr><td bgcolor='#a01313'style='color:#FFFFFF' align='center' colspan='5'><strong>RECARGOS LOCALES CLIENTE</strong></td></tr>
			<tr>
				<td bgcolor='#a01313' style='color:#FFFFFF' align='center' ><strong>Recargo</strong></td>";
					//Si es fcl muestra los contenedores de 20,40 y 40hq si aplica
					if($_GET['cl'] == "fcl"){
						if($filasr20 > 0){
							$liquidador .= "<td bgcolor='#a01313' style='color:#FFFFFF'align='center'><strong>Valor 20</strong></td>" ;
							$colspan++;
						}

						if($filasr40 > 0){
							$liquidador .= "<td bgcolor='#a01313' style='color:#FFFFFF'align='center'><strong>Valor 40</strong></td>" ;
							$colspan++;
						}

						if($filasr40hq > 0){
							$liquidador .= "<td bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>Valor 40 H.Q</strong></td>";
							$colspan++;
						}
						
					}else
						$liquidador .="<td bgcolor='#a01313'><strong>Valor</strong></td>";
				
					$liquidador .="
				<td style='color:#FFFFFF' bgcolor='#a01313'><strong>Valor en Dolares</strong></td>
			</tr>

			";
			while($recargos_cli = mysqli_fetch_array($qry_rec_cli)){

				$valor_rec_fcl=0;
				$liquidador .= "<tr>";
					$liquidador .= "<td>".$recargos_cli["nombre"]."-". ucfirst($recargos_cli["tipo"]) ."</td>";
					
					if($_GET['cl'] == "lcl" || $_GET['cl'] == "aereo"){
						//Si no es hbl
						if(ucfirst($recargos_cli["tipo"]) != "Hbl" && ucfirst($recargos_cli["tipo"]) != "Hawb"){
							//si el valor multiplicado por el contenedor es menor que el precio minimo
							if(($recargos_cli["valor"] * $multiplicador) < $recargos_cli["minimo"])
								$valor_rec = $recargos_cli["minimo"];
							else //si el valor multiplicado por el contenedor es mayor que el precio minimo
								$valor_rec = $recargos_cli["valor"] * $multiplicador;
						}else{
							//si el valor es menor que el minimo pone el minimo
							if($recargos_cli["valor"] < $recargos_cli["minimo"])
								$valor_rec = $recargos_cli["minimo"];
							else
								$valor_rec = $recargos_cli["valor"];
						}
	
	
						$moneda = " ".scai_get_name($recargos_cli["moneda"],"monedas","idmoneda","codigo");
						
						$valor_rec_fcl= 0;
						
						$liquidador .= "
						<td>
							$valor_rec $moneda
						</td>";
					
					}elseif($_GET['cl'] == "fcl" && $recargos_cli["tipo"] != "hbl" ){//Si es fcl muestra los contenedores de 20,40 y 40hq si aplica
						$valor_rec = $recargos_cli["valor"];
						if($filasr20 > 0) {
							if($valor_rec * $no_20 < $recargos_cli["minimo"]){
								$valor_rec_fcl += $recargos_cli["minimo"];
								$liquidador .=  "<td>".$recargos_cli["minimo"]." $moneda</td>";//Solo multiplica si el recargo es por contenedor
							}else{
								$valor_rec_fcl += $valor_rec * $no_20;
								$liquidador .=  "<td>".$valor_rec * $no_20." $moneda</td>";//Solo multiplica si el recargo es por contenedor
							
							}
								
						}
						
						if($filasr40 > 0) {
							if($valor_rec * $no_40 < $recargos_cli["minimo"]){
								$valor_rec_fcl += $recargos_cli["minimo"];
								$liquidador .=  "<td>".$recargos_cli["minimo"]." $moneda</td>";//Solo multiplica si el recargo es por contenedor
							}else{
								$valor_rec_fcl += $valor_rec * $no_40;
								$liquidador .=  "<td>".$valor_rec * $no_40." $moneda</td>";//Solo multiplica si el recargo es por contenedor
							
							}
								
						}
						
						if($filasr40hq > 0) {
							if($valor_rec * $no_40hq < $recargos_cli["minimo"]){
								$valor_rec_fcl += $recargos_cli["minimo"];
								$liquidador .=  "<td>".$recargos_cli["minimo"]." $moneda</td>";//Solo multiplica si el recargo es por contenedor
							}else{
								$valor_rec_fcl += $valor_rec * $no_40hq;
								$liquidador .=  "<td>".$valor_rec * $no_40hq." $moneda</td>";//Solo multiplica si el recargo es por contenedor
							}
								
						}
						$valor_rec = $valor_rec_fcl;
					}elseif($_GET['cl'] == "fcl" && $recargos_cli["tipo"] == "hbl" ){
						//si el valor es menor que el minimo pone el minimo
						if($recargos_cli["valor"] < $recargos_cli["minimo"])
							$valor_rec = $recargos_cli["minimo"];
						else
							$valor_rec = $recargos_cli["valor"];
							
						$valor_rec_fcl += $valor_rec;
						$liquidador .=  "<td colspan ='$colspan'>".$valor_rec." $moneda</td>";//Solo multiplica si el recargo es por contenedor

					
					}


					
					if(trim($moneda) =="EURO") {
						if(!$_POST['euro_en_dolar'])
							$valor_rec = "Digite el Valor del Euro en Dolares";
						else
							$valor_rec = $valor_rec * $_POST['euro_en_dolar'];
					}elseif(trim($moneda) =="COP"){
						if(!$_POST['dolar_en_pesos'])
							$valor_rec = "Digite el Valor del Dolar en Pesos";
						else
							$valor_rec = number_format($valor_rec / $_POST['dolar_en_pesos'],2,".","");
					}
					
					$liquidador .="
					<td>
						$valor_rec
					</td>";
				$total_concepto += $valor_rec;	
				
				//Evalua si muestra el caf y el collection fee, de ser asi almacena en variables los valores para luego mostrarlos
				if($recargos_cli["mostrar_coll"] == "1"){
					$porc_coll = $recargos_cli["collection_fee"];
					$min_coll = $recargos_cli["min_collection_fee"];
				}

				if($recargos_cli["mostrar_caf"] == "1"){
					$porc_caf = $recargos_cli["caf"];
					$min_caf = $recargos_cli["min_caf"];
				}
			
				
			}
			$total_cot += $total_concepto;
			
			//CAF
			if($porc_caf){
				$ValorCaf = $total_cot * ($porc_caf / 100);

				//Evalua que el resultado del porcentaje del collection fee no sea menor al valor minimo		
				if($ValorCaf < $min_caf)
					$ValorCaf = $min_caf;
				else
					$ValorCaf = $ValorCaf;

				$liquidador .= "
				<tr>
					<td>CAF: ($porc_caf% de $total_cot) </td>
					<td colspan = '4'>
						$ValorCaf USD
					</td>
				</tr>";
				$total_concepto += $ValorCaf;
				$total_cot += $ValorCaf;
			}

			//Collection_fee
			if($porc_coll){
				$ValorCollFee = $ValorCollF * ($porc_coll / 100);
				
				//Evalua que el resultado del porcentaje del collection fee no sea menor al valor minimo		
				if($ValorCollFee < $min_coll)
					$ValorCollFee = "$min_coll";
				else
					$ValorCollFee = "$ValorCollFee";

				$liquidador .= "
				<tr>
					<td>Collection fee($porc_coll%):</td>
					<td colspan = '4'>
						$ValorCollFee USD
					</td>
				</tr>";
				$total_concepto += $ValorCollFee;
				$total_cot += $ValorCollFee;
			}
			
			
			$liquidador .= "
			<tr><td  bgcolor='#a01313'style='color:#FFFFFF' colspan ='5' align='center'><strong>Total Recargos: $total_concepto $moneda</strong></td></tr>
		</table></p>";
	}
	//Termina recargos Locales cliente
				



	//Recargos Locales			

	$porc_caf = null;
	$porc_coll = null;
	$sql_rec_loc = "
	select
		recargos_local.nombre as nombre,
		recargos_local.tipo as tipo,
		recargos_local.moneda as moneda,
		local_por_cotizacion.valor_venta as valor_venta, 
		local_por_cotizacion.minimo_venta as minimo_venta,
		totales_cotizacion_local.mostrar_var as mostrar_var,
		totales_cotizacion_local.collection_fee as collection_fee,
		totales_cotizacion_local.min_collection_fee as min_collection_fee,
		totales_cotizacion_local.caf as caf,
		totales_cotizacion_local.min_caf as min_caf,
		totales_cotizacion_local.mostrar_collection_fee as mostrar_coll,
		totales_cotizacion_local.mostrar_caf as mostrar_caf
	from 
		recargos_local, 
		local_por_cotizacion,
		cotizacion_local,
		totales_cotizacion_local
	where
		recargos_local.idrecargo_local = local_por_cotizacion.idrecargo_local 
		and local_por_cotizacion.idcotizacion_local = cotizacion_local.idcotizacion_local
		and local_por_cotizacion.idcotizacion_local = totales_cotizacion_local.idcotizacion_local
		and cotizacion_local.idcot_temp = ".$_GET['id']."
		and totales_cotizacion_local.idnaviera = recargos_local.idnaviera" ;

	$qry_rec_loc = mysqli_query($link,$sql_rec_loc);
	

	$total_concepto=0;
	$colspan =0;
	if(mysqli_num_rows($qry_rec_loc) > 0){
		$liquidador .= "
		<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='70%'>
			<tr><td colspan = '5' align='center'style='color:#FFFFFF' bgcolor='#a01313'><strong>RECARGOS LOCALES</strong></td></tr>
			<tr>
				<td bgcolor='#a01313'style='color:#FFFFFF' align='center' ><strong>Recargo</strong></td>";
					//Si es fcl muestra los contenedores de 20,40 y 40hq si aplica
					if($_GET['cl'] == "fcl"){
						if($filasr20 > 0){
							$liquidador .=  "<td bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>Valor 20</strong></td>" ;
							$colspan++;
						}
							
						if($filasr40 > 0){
							$liquidador .= "<td bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>Valor 40</strong></td>";
							$colspan++;
						}
							
						if($filasr40hq > 0){
							$liquidador .= "<td bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>Valor 40 H.Q</strong></td>";
							$colspan++;
						}
					}else
						$liquidador .="<tdstyle='color:#FFFFFF' bgcolor='#a01313'><strong>Valor</strong></td>";
				
					$liquidador .="
				<tdstyle='color:#FFFFFF' bgcolor='#a01313'><strong>Valor en Dolares</strong></td>
			</tr>";
			
			
			$total_concepto=0;
			while($recargos_loc = mysqli_fetch_array($qry_rec_loc)){
				$valor_rec_fcl=0;
				$liquidador .= "<tr>";
					$liquidador .= "<td>".$recargos_loc["nombre"]."-". ucfirst($recargos_loc["tipo"] ) ."</td>";
					
					if($_GET['cl'] != "fcl"){
						//Si no es hbl
						if(ucfirst($recargos_loc["tipo"]) != "Hbl" && ucfirst($recargos_loc["tipo"]) != "Hawb"){
							//si el valor multiplicado por el contenedor es menor que el precio minimo
							if(($recargos_loc["valor_venta"] * $multiplicador) < $recargos_loc["minimo_venta"])
								$valor_rec = $recargos_loc["minimo_venta"];
							else //si el valor multiplicado por el contenedor es mayor que el precio minimo
								$valor_rec = $recargos_loc["valor_venta"] * $multiplicador;
						}else{
							//si el valor es menor que el minimo pone el minimo
							if($recargos_loc["valor_venta"] < $recargos_loc["minimo_venta"])
								$valor_rec = $recargos_loc["minimo_venta"];
							else
								$valor_rec = $recargos_loc["valor_venta"];
						}
	
						$moneda = " ".scai_get_name($recargos_loc["moneda"],"monedas","idmoneda","codigo");
						
						$liquidador .= "<td>$valor_rec $moneda</td>";
						//Si es fcl muestra los contenedores de 20,40 y 40hq si aplica
					}//elseif($_GET['cl'] == "fcl" && $recargos_loc["tipo"] != "hbl"){Se cambia para que muestre hbl y cont
					 elseif($_GET['cl'] == "fcl" && $recargos_loc["tipo"] != ""){   
						$valor_rec = $recargos_loc["valor_venta"];
						
						if($filasr20 > 0) {
							if($valor_rec * $no_20 < $recargos_loc["minimo_venta"]){
								$valor_rec_fcl += $recargos_loc["minimo_venta"];
								$liquidador .=  "<td>".$recargos_loc["minimo_venta"]." $moneda</td>";//Solo multiplica si el recargo es por contenedor
							}else{
							
								$valor_rec_fcl += $valor_rec * $no_20;
								$liquidador .=  "<td>".$valor_rec * $no_20." $moneda</td>";//Solo multiplica si el recargo es por contenedor
							}
						}
						
						if($filasr40 > 0) {
							if($valor_rec * $no_40 < $recargos_loc["minimo_venta"]){
								$valor_rec_fcl += $recargos_loc["minimo_venta"];
								$liquidador .=  "<td>".$recargos_loc["minimo_venta"]." $moneda</td>";//Solo multiplica si el recargo es por contenedor
							}else{
								$valor_rec_fcl += $valor_rec * $no_40;
								$liquidador .=  "<td>".$valor_rec * $no_40." $moneda</td>";//Solo multiplica si el recargo es por contenedor
							}
						}
						
						if($filasr40hq > 0) {
							if($valor_rec * $no_40hq < $recargos_loc["minimo_venta"]){
								$valor_rec_fcl += $recargos_loc["minimo_venta"];
								$liquidador .=  "<td>".$recargos_loc["minimo_venta"]." $moneda</td>";//Solo multiplica si el recargo es por contenedor
							}else{
								$valor_rec_fcl += $valor_rec * $no_40hq;
								$liquidador .=  "<td>".$valor_rec * $no_40hq." $moneda</td>";//Solo multiplica si el recargo es por contenedor
							}
						}
						
						
						$valor_rec = $valor_rec_fcl;
					}

					if($moneda =="EURO") {
						if(!$_POST['euro_en_dolar'])
							$valor_rec = "Digite el Valor del Euro en Dolares";
						else
							$valor_rec = $valor_rec * $_POST['euro_en_dolar'];
					}elseif($moneda =="COP"){
						if(!$_POST['dolar_en_pesos'])
							$valor_rec = "Digite el Valor del Dolar en Pesos";
						else
							$valor_rec = number_format($valor_rec / $_POST['dolar_en_pesos'],2,".","") ;
					}
					$liquidador .="
					<td>
						$valor_rec
					</td>";
				$total_concepto += $valor_rec;	

				//Evalua si muestra el caf y el collection fee, de ser asi almacena en variables los valores para luego mostrarlos
				if($recargos_loc["mostrar_coll"] == "1"){
					$porc_coll = $recargos_loc["collection_fee"];
					$min_coll = $recargos_loc["min_collection_fee"];
				}

				if($recargos_loc["mostrar_caf"] == "1"){
					$porc_caf = $recargos_loc["caf"];
					$min_caf = $recargos_loc["min_caf"];
				}

			}
			
			$total_cot += $total_concepto;//Total, se genera aca para calcular el caf, pero luego se vuelve a calcular
			
			//CAF
			if($porc_caf){
				$ValorCaf = $total_cot * ($porc_caf / 100);

				//Evalua que el resultado del porcentaje del collection fee no sea menor al valor minimo		
				if($ValorCaf < $min_caf)
					$ValorCaf = $min_caf;
				else
					$ValorCaf = $ValorCaf;

				$liquidador .= "
				<tr>
					<td>CAF: ($porc_caf% de $total_cot) </td>
					<td colspan = '4'>
						$ValorCaf USD
					</td>
				</tr>";
				$total_concepto += $ValorCaf;
				$total_cot += $ValorCaf;
			}

			//Collection_fee
			if($porc_coll){
				$ValorCollFee = $ValorCollF * ($porc_coll / 100);
				
				//Evalua que el resultado del porcentaje del collection fee no sea menor al valor minimo		
				
				if($ValorCollFee < $min_coll)
					$ValorCollFee = "$min_coll";
				else
					$ValorCollFee = "$ValorCollFee";

				$liquidador .= "
				<tr>
					<td>Collection fee($porc_coll%):</td>
					<td colspan = '4'>
						$ValorCollFee USD
					</td>
				</tr>";
				$total_concepto += $ValorCollFee;
				$total_cot += $ValorCollFee;
			}

			

			
			$liquidador .= "
			<tr><td colspan ='5'  bgcolor='#a01313'style='color:#FFFFFF' align='center'><strong>Total Recargos : $total_concepto USD</strong></td></tr>
		</table>";
	}

	
	$liquidador .= 	"
	<p>
	<table border='1' cellpadding='2' cellspacing='0' class='tabla' align='center' width='30%'>
		<tr>
			<td style='color:#FFFFFF' bgcolor='#a01313'><strong>Total:</strong></td><td>$total_cot USD</td>
		</tr>
	</table>
	</p>
	";

	
	echo $liquidador;
	?>

</form>
</body>