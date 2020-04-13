<? include_once('./sesion/sesion.php');
include("./conection/conectar.php");	
include_once("./permite.php");
include_once("scripts/recover_nombre.php");
include('scripts/scripts.php');


?>
<html>
	<head>
		<title></title>

	
	<link href="./css/admin_internas.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="./js/jquery.js"></script>
	<script type="text/javascript" src="./js/funciones.js"></script>

	<script>
		function disabled_sel(opc){
			//Inhabilita o abilita el text de cliente o comercial, para solo permitir seleccionar una de las dos opciones 
			
			var cliente = document.getElementById("cliente");
			var usuario = document.getElementById("usuario");
			if(opc == "cliente"){
				cliente[0].selected = true;
			}
			
			
			if(opc == "usuario"){
				usuario[0].selected = true;
			}
		}
		
		//Muestra u oculta div que contiene los puertos de origen por cada tipo de embarque
		function show_div(div){
			var capa = document.getElementById(div);
			if(capa.style.display == "block")
				capa.style.display="none";
			else	
				capa.style.display="block";
		}
	</script>

	</head>
	
	
	<body>
	<?

	?>
		<!--Inicia Filtros-->
		<p>
		<?
		if($_SESSION['perfil'] != "2"){ //Si es comercial habilita solo los cliente de el ?>
			<form method="post">
				<table cellpadding="10" class="contenidotab" align="center">
					<tr><td class="tittabla" colspan="10">Filtros</td></tr>
					<tr>
						<td>Cliente</td>
						<td>
							<select name="cliente" id= "cliente" class="tex2"  onClick="disabled_sel('usuario')">
								<option></option>
								<?
									$SqlCli = mysqli_query($link,"select * from clientes order by nombre asc");
									while( $cliente = mysqli_fetch_array($SqlCli)){?>
										<option <? echo ($_POST['cliente'] == $cliente["idcliente"]) ? "selected='selected'" : "" ;?> value="<? echo $cliente["idcliente"]?>" >
											<? echo $cliente["nombre"]; ?>									</option>
										<?
									}
									
								?>
							</select>					</td>
						<td>Comercial</td>
						<td>
							<select name="usuario" id= "usuario" class="tex2" onClick="disabled_sel('cliente')">
								<option></option>
								<?
									$SqlUsu = mysqli_query($link,"select * from usuarios order by nombre asc");
									while( $usuarios = mysqli_fetch_array($SqlUsu)){?>
										<option <? echo ($_POST['usuario'] == $usuarios["idusuario"]) ? "selected='selected'" : "" ;?> value="<? echo $usuarios["idusuario"]?>" >
											<? echo $usuarios["nombre"]."  ".$usuarios["apellido"]; ?>									</option>
										<?
									}
									
								?>
							</select>					</td>
						<td>Origen</td>
						<td>
							<select name="origen" id= "origen" class="tex2">
								<option></option>
								<?
									$SqlOrg = mysqli_query($link,"select * from aeropuertos_puertos order by nombre asc");
									while( $origen = mysqli_fetch_array($SqlOrg)){?>
										<option <? echo ($_POST['origen'] == $origen["idaeropuerto_puerto"]) ? "selected='selected'" : "" ;?> value="<? echo $origen["idaeropuerto_puerto"]?>" >
											<? echo $origen["nombre"]; ?>									</option>
										<?
									}
									
								?>
							</select>					</td>
						<td>Destino</td>
						<td>
							<select name="destino" id= "destino" class="tex2">
								<option></option>
								<?
									$SqlDes = mysqli_query($link,"select * from aeropuertos_puertos order by nombre asc");
									while( $destino= mysqli_fetch_array($SqlDes)){?>
										<option <? echo ($_POST['destino'] == $destino["idaeropuerto_puerto"]) ? "selected='selected'" : "" ;?> value="<? echo $destino["idaeropuerto_puerto"]?>" >
											<? echo $destino["nombre"]; ?>									</option>
										<?
									}
									
								?>
							</select>					</td>
		
						<td>Tipo:</td>
						<td>
							<select name="tipo" id="tipo">
								<option></option>
								<option <? echo ($_POST['tipo'] == "fcl" ) ? "selected='selected'" : ""?> value="fcl">Fcl</option>
								<option <? echo ($_POST['tipo'] == "lcl" ) ? "selected='selected'" : ""?> value="lcl">Lcl</option>
								<option <? echo ($_POST['tipo'] == "aereo" ) ? "selected='selected'" : ""?> value="aereo">Aereo</option>
							</select>
						</td>
					</tr>
					<tr>
					  <td align="center" colspan="8">
							<input type="submit" value="Buscar" class="botonesadmin">
							<input type="button" class="botonesadmin" value="Restaurar Filtros" onClick="window.location='desercion_cli.php'">					</td>
					</tr>
				</table>
			</form><?
		}
		?>
		</p>
		<!--Termina Filtros-->
		
		
		<?
		//Mes actual reducido en 7 meses
		$MLess7 = date("Y-m-d",strtotime(date("Y-m-1")." - 7 months"));
		$TempM = $MLess7;
		

		//Si no ha seleccionado ningun cliente o comercial no permite visualizar la tabla
		
		if(!$_POST['cliente'] && !$_POST['usuario'] && $_SESSION['perfil'] != 2 ){
			?><center style='color:#666666;font-size:13px'>Seleccione un cliente o un Comercial</center><?
			die();
		
		}
		
		//Realiza Consulta
		$sqlRep = "
			SELECT 
				idreporte_estado,
				otmChk,
				clientes.nombre as cliente, 
				date_format( reporte_estado_cli.fecha_creacion, '%Y-%c' ) AS fecha, 
				clasificacion, 
				aeropuertos_puertos.nombre as puerto
				
			FROM 
				reporte_estado_cli, 
				clientes, 
				aeropuertos_puertos
			WHERE 
				reporte_estado_cli.fecha_creacion >= '$MLess7'
				AND reporte_estado_cli.idcliente = clientes.idcliente
				AND reporte_estado_cli.puerto_origen = aeropuertos_puertos.idaeropuerto_puerto";
			
				$sqlRep .= ($_POST['cliente']) ? " and reporte_estado_cli.idcliente = ".$_POST['cliente'] : "";
				$sqlRep .= ($_POST['usuario']) ? " and reporte_estado_cli.idcliente in(select idcliente from clientes where idvendedor in (select idvendedor_customer from vendedores_customer where idusuario= ".$_POST['usuario']."))" : "";
				
				$sqlRep .= ($_SESSION['perfil'] == "2") ? " and reporte_estado_cli.idcliente in(select idcliente from clientes where idvendedor in (select idvendedor_customer from vendedores_customer where idusuario= ".$_SESSION['numberid']."))" : "";
				
				
				$sqlRep .= ( $_POST['origen'] ) ? " and reporte_estado_cli.puerto_origen = ". $_POST['origen'] : "" ;
				$sqlRep .=  ( $_POST['destino'] ) ? " and reporte_estado_cli.puerto_destino = ". $_POST['destino'] : "" ;
				$sqlRep .=  ( $_POST['tipo'] ) ? " and 	reporte_estado_cli.clasificacion = '". $_POST['tipo']."'" : "" ;
				$sqlRep .= "	
			ORDER BY 
				clientes.nombre, 
				reporte_estado_cli.fecha_creacion, 
				clasificacion
			ASC ";


		
		if(!$qryRep = mysqli_query($link,$sqlRep))
			echo "<center style='color:#666666;font-size:13px'>La consulta no se realiz�, por favor contacte al administrador</center>";
		
		
		if( mysqli_num_rows($qryRep) == 0){
			echo "<center style='color:#666666;font-size:13px'>No se encontraron registros para esta consulta.</center>";die();
		}
		
		

		?>	
		
		
		<!--Inicia tabla principal-->
		<table align="center" cellpadding="5" id="tabla" class="contenidotab">	
			<!--Titulos-->
			<tr class="tittabla">
				<td align="center">Cliente</td>
				<?
				$TempM = $MLess7;
				while(date("m",strtotime($TempM)) != date("m",strtotime("+1 month")) ){?>
					<td><? 
						echo date("F",strtotime($TempM))."<br>";
						$TempM = date("Y-m-d",strtotime(date("$TempM")." + 1 months"));
						?>
					</td>
					
				
					<?
				}
				?>
			</tr>
			
			<?
			
			//Recorre resultados de la consulta
			while($reporte = mysqli_fetch_array($qryRep)){
				if(!$inicia){
					$inicia = true;
					$temporal = $reporte["cliente"];	
				}
				
				//Mientras el cliente no Cambie 
				while($reporte["cliente"] == $temporal && $temporal != ""){
					?>
					<tr <? $color = ($color == "#E6E6E6")  ? $color ="#FFFFFF" : $color = "#E6E6E6"; ?> bgcolor="<? echo $color;?>">
						<td><? echo $reporte["cliente"]; ?></td>
						<?						
						$TempM = $MLess7;
						while(date("m",strtotime($TempM)) != date("m",strtotime("+1 month")) ){ //Recorre los ultimos 7 meses
							echo "<td>";
							
							//si el mes del registro de la consulta coincide con el del while que muestra los ultimos 7 meses y el cliente es el mismo ....
							if(date("Y-m",strtotime($TempM)) == date("Y-m",strtotime($reporte["fecha"])) 
								&& $reporte["cliente"] == $temporal){
								$fcl = NULL;
								$lcl = NULL;
								$aereo = NULL;
								
								$NoFcl = NULL;
								$NoLcl = NULL;
								$NoAereo = NULL;
								
								//Este while permite sumar todos los registros del mismo mes con el mismo tipo de embarque
								do{	
									//almacena en distintos contadores de acuerdo al tipo de embarque y al puerto, para luego sacar un total y mostrarlos
									if($reporte["clasificacion"] == "fcl"){
										$fcl[$reporte["puerto"]]++ ;
										
										if($reporte["otmChk"] == "1")
											$otmFcl ++;

										
										$noContFcl = scai_get_name($reporte["idreporte_estado"], "contenedores", "idreporte_estado", "count(number)");
										
									}
									if($reporte["clasificacion"] == "lcl"){
										$lcl[$reporte["puerto"]]++ ;
											if($reporte["otmChk"] == 1)
												$otmLcl ++;
									}
									
									if($reporte["clasificacion"] == "aereo"){
										$aereo[$reporte["puerto"]]++ ;
										if($reporte["otmChk"] == 1)
											$otmAer ++;
									}
										
									$temporal = $reporte["cliente"];
									$reporte = mysqli_fetch_array($qryRep); 	
								}while(date("Y-m",strtotime($TempM)) == date("Y-m",strtotime($reporte["fecha"])) 
								&& $reporte["cliente"] == $temporal);
								
								
								//Muestra los resultados almacenados en los distintos array por puerto y tipo de embarque
								
								//fcl
								$div ="";
								if($fcl){ 
									$div_name = $reporte["cliente"]."_".date("m",strtotime($reporte["fecha"]))."_fcl";?>
									<p><?
											foreach($fcl as $result=>$i ){
												$div .= "$result($i)<br>";
												$NoFcl += $i;
											} 
										$title = "Cont:".$noContFcl.";";
										$title .= "Otm:".$otmFcl.";";
											?>
										
										<a href="#" title="<?= $title;?>" onClick="show_div('<? echo $div_name;?>')">Fcl(<? echo $NoFcl?>)</a>
										<div id="<? echo $div_name?>" style="margin-left:10px;display:none">
											<? echo $div;?>
										</div>
										</p><?
										
										$title ="";
										$noContFcl =0;
										$otmFcl=0;
										
										$total[date("m",strtotime($TempM))] = $total[date("m",strtotime($TempM))] + $NoFcl;
								}
								
								//lcl
								$div ="";
								if($lcl){ 
									$div_name = $reporte["cliente"]."_".date("m",strtotime($reporte["fecha"]))."_lcl";?>
									<p><?
											foreach($lcl as $result=>$i ){
												$div .= "$result($i)<br>";
												$NoLcl += $i;
											} 
										
										$title = "Otm:".$otmLcl.";";
											?>
										<a href="#" title="<?= $title;?>" onClick="show_div('<? echo $div_name;?>')">Lcl(<? echo $NoLcl?>)</a>
										<div id="<? echo $div_name?>" style="margin-left:10px;display:none">
											<? echo $div;?>
										</div>
										</p><?
										$total[date("m",strtotime($TempM))] = $total[date("m",strtotime($TempM))] + $NoLcl;
								}
								
								$otmLcl=0;
								$title ="";
								//aereo
								$div ="";
								if($aereo){ 
									$div_name = $reporte["cliente"]."_".date("m",strtotime($reporte["fecha"]))."_aereo";?>
									<p><?
											foreach($aereo as $result=>$i ){
												$div .= "$result($i)<br>";
												$NoAereo += $i;
											} 
											?>
										<a href="#" onClick="show_div('<? echo $div_name;?>')">Aereo(<? echo $NoAereo ?>)</a>
										<div id="<? echo $div_name?>" style="margin-left:10px;display:none">
											<? echo $div;?>
										</div>
										</p><?
										$total[date("m",strtotime($TempM))] = $total[date("m",strtotime($TempM))] + $NoAereo;
								}

							}else{ echo "&nbsp;";}
							$TempM = date("Y-m-d",strtotime(date("$TempM")." + 1 months")); //Aumenta en uno el mes
							
							echo "</td>";
						}
						$temporal = $reporte["cliente"];
					?>
					</tr>
					<?
				}?>
				
				<?
			}
		
			?>
		
			<!--Muestra totales-->
			<tr class="tittabla">
				<td align="center">Cliente</td>
				<?
				$TempM = $MLess7;
				while(date("m",strtotime($TempM)) != date("m",strtotime("+1 month"))){?>
					<td><? echo $total[date("m",strtotime($TempM))];?></td>
					
				
					<?
					$TempM = date("Y-m-d",strtotime(date("$TempM")." + 1 months"));
				}
				?>
			</tr>
		</table>
		<!---Termina Tabla Principal-->
		
		
		<!--Muestra Grafico
		<table align="center" style="padding:30px 0px 0px 0px" cellpadding="40px">
			<tr>
				<td>
					<?
					
					$TempM = $MLess7;
					$x=5;
					while(date("m",strtotime($TempM)) != date("m",strtotime("+1 month"))){?>
						<img src="graph/graphref.php?ref=<? echo $x;?>&typ=2&dim=5&bkg=FFFFFF">
							<font class="tex4"><? echo date("F", strtotime($TempM) ) ; ?> </font>
						<br><br>
						<?
						$x = $x+3;
						$TempM = date("Y-m-d",strtotime(date("$TempM")." + 1 months"));
					}
					?>
				</td>
				<td>
					<img src="graph/graphbarras.php?dat=<? foreach($total as $result) echo $result.","; ?>&bkg=FFFFFF&wdt=590&ttl=Desercion de Clientes"/>
				</td>
			</tr>
		</table>-->
		</div>


	</body>
</html>