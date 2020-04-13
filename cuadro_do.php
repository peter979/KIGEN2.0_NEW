<?
include("./conection/conectar.php");	
include_once('./sesion/sesion.php'); 	
//Permite exportar a excel
if($_GET['opc'] == "exportarExcel"){
		header("Content-Type: application/vnd.ms-excel");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("content-disposition: attachment;filename=CuadroDo.xls");
		echo "<table>".$_POST['tablaTemp']."</table>";
		die();	

	}
	


include_once("./permite.php");
include_once("scripts/recover_nombre.php");
include('scripts/scripts.php');

	

	?>
	<html>
	<head>
		<title></title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="./css/admin_internas.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="./js/jquery.js"></script>
	<script type="text/javascript" src="./js/funciones.js"></script>
	<script>
		//Muestra u oculta las columnas de la tabla principal
		$(document).ready(function inicia() {			
			 
			 $(".showTr").click(showHide);
			 $(":submit").click(expExcel);
			 
			 function expExcel(){

			 	if($(this).attr("id") == "btnExcel"){
					$('#exportarExcel').val('1');
					$("#cuadro_form").attr("target","_blank");
				}else{
					$('#exportarExcel').val('0');
					$("#cuadro_form").attr("target","_self");
				}
			 	
			 }
			 function showHide(col){
				var col = $(this).attr("value");		
				if ($('#tabla td:nth-child('+col+')').is (':hidden'))
					$('#tabla td:nth-child('+col+')').show();
				else
					$('#tabla td:nth-child('+col+')').hide();
			 }
		})
			
			
			
			
	</script>
	
	
	
	<?
	
	function colSel($col){
		//Valida si la columna está entre los filtros de la tabla columnas, para mostrarla o no
		global $filtrosSel;
		
		if(in_array($col,$filtrosSel))
			return "";
		else{
			return "style='display:none'";

			
		}
	}
	
	//Almacena comentarios de serivicio al cliente y de Operativo, los cuales si digitan al final de la tabla
	if($_POST['s_cli_tmp']){ //Comentario Servicio al cliente
		
		//el nombre del textarea es el mismo id, el cual se pasa por post por medio de $_POST['s_cli_tmp'], para saber cual es el comentario que se cambio y se debe almacenar
		$comentario = $_POST[$_POST['s_cli_tmp']]; 
		$comentario = str_replace("'","",$comentario);
		$comentario = str_replace("\"","",$comentario);
		
		//Recupera el id del reporte de estado
		$id_rep = substr($_POST['s_cli_tmp'],9,strlen($_POST['s_cli_tmp']));
		
		//Cambia el comentario en la base de datos
		$sql = "update reporte_estado_cli set coment_servicio_cliente = '$comentario' where idreporte_estado = $id_rep";
		if(!$update = mysqli_query($link,$sql))
			echo "No Editó, contacte al administrador ".mysqli_error();
		else
			echo "<script>alert('Comentario Editado')</script>";
	}
	if($_POST['s_oper']){ //Comentario Servicio al cliente
		
		//el nombre del textarea es el mismo id, el cual se pasa por post por medio de $_POST['s_cli_tmp'], para saber cual es el comentario que se cambio y se debe almacenar
		$comentario = $_POST[$_POST['s_oper']]; 
		$comentario = str_replace("'","",$comentario);
		$comentario = str_replace("\"","",$comentario);

		//Recupera el id del reporte de estado
		$id_rep = substr($_POST['s_oper'],9,strlen($_POST['s_oper']));
		
		//Cambia el comentario en la base de datos
		$sql = "update reporte_estado_cli set coment_oper = '$comentario' where idreporte_estado = $id_rep";
		if(!$update = mysqli_query($link,$sql))
			echo "No Editó, contacte al administrador ".mysqli_error();
		else
			echo "<script>alert('Comentario Editado')</script>";
	}

		
	?>
	</head>

	
	<body>


		<!--Inicia Filtros-->
		<p>
		<form method="post" name="cuadro_form" id="cuadro_form">
		
		<?
		if($_POST['exportarExcel'] != "1"){ // Si no está exporando a excel
			?>
			<div>
				<table cellpadding="10" class="contenidotab" align="center">
					<tr><td class="tittabla" colspan="13"><div align="right">Filtros</div></td></tr>
					<tr>
					  <td colspan="3"><div align="center"><strong>Fecha de Creaci&oacute;n </strong></div></td>
					  <td colspan="3"><div align="center"><strong>ETD:</strong></div></td>
					  <td colspan="3"><div align="center"><strong>ETA:</strong></div></td>
				  </tr>
					<tr>
						
						<td><div align="right"><strong>Desde</strong>
						  <input id="desde" name="desde" onClick="return showCalendar('desde');" size="7" value="<? echo ($_POST['desde']) ? $_POST['desde'] : "" ;  ?>" readonly >
					  </div></td>
						
						<td><div align="right"><strong>Hasta</strong>
						  <input id="hasta" name="hasta" onClick="return showCalendar('hasta');" size="7" value="<? echo ($_POST['hasta']) ? $_POST['hasta'] : "" ;  ?>" readonly >
						</div></td>
						
						
						<td><div align="right"></div></td>
						<td><div align="right"><strong>Desde</strong>:
						  <input id="desde_etd" name="desde_etd" onClick="return showCalendar('desde_etd');" size="7" value="<? echo ($_POST['desde_etd']) ? $_POST['desde_etd'] : "" ;  ?>" readonly >
						</div></td>
		
						
					  <td><div align="right"><strong>Hasta</strong>:
						<input id="hasta_etd" name="hasta_etd" onClick="return showCalendar('hasta_etd');" size="7" value="<? echo ($_POST['hasta_etd']) ? $_POST['hasta_etd'] : "" ;  ?>" readonly >
					  </div></td>
						
						<td><div align="right"><strong>Desde</strong>:
						  <input id="desde_eta" name="desde_eta" onClick="return showCalendar('desde_eta');" size="7" value="<? echo ($_POST['desde_eta']) ? $_POST['desde_eta'] : "" ;  ?>" readonly >
						</div></td>
						<td><div align="right"><strong>Hasta</strong>:
						  <input id="hasta_eta" name="hasta_eta" onClick="return showCalendar('hasta_eta');" size="7" value="<? echo ($_POST['hasta_eta']) ? $_POST['hasta_eta'] : "" ;  ?>" readonly >
						</div></td>
					</tr>
					<tr>
					 <td align="center"><div align="right"><strong>Cliente : 
					  
					  </strong>
					  <? $qryCli = mysqli_query($link,"select * from clientes order by nombre asc"); ?>
					  <select name="cliente" class="tex2">
						  <option></option>
						<?
						while($clientes = mysqli_fetch_array($qryCli) ){?>
							<option value="<? echo $clientes["idcliente"]?>" <? echo ($clientes["idcliente"] == $_POST['cliente']) ? "selected='selected'" : ""?>>
							
								<? echo $clientes["nombre"]?></option>
						
						<?
						
						}
						?>
					  </select>
					  
					  </div>
					 </td>
					
					  <td align="center"><div align="right"><strong>Shipping Instruction : 
					  <input id="shipping" name="shipping" size="7" value="<? echo ($_POST['shipping']) ? $_POST['shipping'] : "" ;  ?>" >
					  </strong></div></td>
					  <td align="center">
					  <div align="right"><strong>Área</strong>:
						<?
						//La siguiente consulta, llama las áreas que existen en la tabla shipping instruction
						$qryArShp = mysqli_query($link,"SELECT distinct(mid(`numero`,1,2)) as area FROM `shipping_instruction`");

						?>
						<select name="area" class="tex2">
							<option></option>
							<? while($ArShp = mysqli_fetch_array($qryArShp)){ ?>
								<option <? echo ($_POST['area'] == $ArShp["area"]) ? "selected='selected'" : ""; ?>><? echo $ArShp["area"]; ?></option>
							<? }?>
						</select>
						</div>
					  </td>
					  <td>
						<div align="right"><strong>Shipper</strong>:
							<input type="text"  name="shipper" value="<? echo $_POST['shipper']?>" size="7">				  
						</div></td>
					  <td>
						<div align="right"><strong>Pedido:
						  <input type="text"  name="number" value="<? echo $_POST['number']?>" size="7">				  
						</strong></div></td>
					  <td align="center"><div align="right"><strong>Tipo de Embarque
						<select name="clasificacion">
						  <option></option>
						  <option <? echo ($_POST['clasificacion'] == "fcl") ? "selected='selected'" : ""; ?> value="fcl">Fcl</option>
						  <option <? echo ($_POST['clasificacion'] == "lcl") ? "selected='selected'" : ""; ?> value="lcl">Lcl</option>
						  <option <? echo ($_POST['clasificacion'] == "aereo") ? "selected='selected'" : ""; ?> value="aereo">Aereo</option>
					  </select>
										</strong></div></td>
					  <td>
						<strong>Naviera</strong>:
							<input type="text"  name="naviera" value="<? echo $_POST['naviera']?>" size="7">				  </td>
				  </tr>
				  <tr>
					<td><div align="right"><strong>Origen</strong>
					  <? $qryOrig = mysqli_query($link,"select * from aeropuertos_puertos order by nombre asc");?>
						<select name="origen" class="tex2">
						  <option></option>
						  <?
							while( $origen = mysqli_fetch_array($qryOrig) ){?>
						  <option value="<? echo $origen["idaeropuerto_puerto"]?>" <? echo ($_POST['origen'] == $origen["idaeropuerto_puerto"]) ? "selected='selected'" : ""?> >
							<? echo $origen["nombre"]." (".$origen["tipo"].")";?></option>
							<?
								
							}
							?>
					  </select>
					</div></td>
					<td><div align="right"><strong>Destino</strong>
					  <? $qryOrig = mysqli_query($link,"select * from aeropuertos_puertos order by nombre asc");?>
						<select name="destino" class="tex2">
						  <option></option>
						  <?
							while( $destino = mysqli_fetch_array($qryOrig) ){?>
						  <option value="<? echo $destino["idaeropuerto_puerto"]?>" <? echo ($_POST['destino'] == $destino["idaeropuerto_puerto"]) ? "selected='selected'" : ""?> >
							<? echo $destino["nombre"]." (".$destino["tipo"].")"?></option>
							<?
								
							}
							?>
					  </select>
					</div></td>
					<td>
						<div align="right"><strong>MBL</strong>:
							<input type="text" name="mbl" value="<? echo $_POST['mbl']?>" size="7">				
					  </div></td>
					<td>
						<div align="right"><strong>HBL</strong>:
							<input type="text" name="hbl" value="<? echo $_POST['hbl']?>" size="7">				
					  </div></td>
					
					<td>
						<div align="right"><strong>Operativo Asignado</strong>:
							<? $qry_oper = mysqli_query($link,"select * from usuarios where idperfil = 9"); ?>
							<select name="operativo" class="tex2"	>
								<option></option>
								<? while($operativo = mysqli_fetch_array($qry_oper)){?>
									<option value="<? echo $operativo["idusuario"] ?>" <? echo ($operativo["idusuario"] == $_POST["operativo"]) ? "selected='selected'" : "" ?>>
										<? echo $operativo["nombre"]." ".$operativo["apellido"]; ?></option>
								<? }?>
							</select>
					  </div></td>
					  <td>
						<div align="right"><strong>Comercial</strong>:
							<? $qry_oper = mysqli_query($link,"select * from usuarios where idperfil = 1 or idperfil = 2"); ?>
							<select name="comercial" class="tex2"	>
								<option></option>
								<? while($operativo = mysqli_fetch_array($qry_oper)){?>
									<option value="<? echo $operativo["idusuario"] ?>" <? echo ($operativo["idusuario"] == $_POST["comercial"]) ? "selected='selected'" : "" ?>>
										<? echo $operativo["nombre"]." ".$operativo["apellido"]; ?></option>
								<? }?>
							</select>
					  </div></td>
				  </tr>
				  <tr>
					  <td>
					  <div align="right"><strong>Sericio al Cliente Asignado</strong>:
						<select id="idcustomer" name="idcustomer" class="tex2"  >
							<option></option>
							<?
							$es = "select * from vendedores_customer order by nombre";
							$exe=mysqli_query($link,$es);
							while($row=mysqli_fetch_array($exe)){?>
								<option value='<? echo $row["idvendedor_customer"]?>' <? echo ($row["idvendedor_customer"] == $_POST["idcustomer"]) ? "selected='selected'" : ""?>>
									<? echo $row["nombre"]?>
								</option><?
							}
							?>
						</select>
						</div>
					  </td>
					  <td>
					  <div align="right"><strong>País</strong>:
						<select id="pais" name="pais" class="tex2"  >
							<option></option>
							<?
							$es = "select * from paises order by nombre";
							$exe=mysqli_query($link,$es);
							while($row=mysqli_fetch_array($exe)){?>
								<option value='<? echo $row["idpais"]?>' <? echo ($row["idpais"] == $_POST["pais"]) ? "selected='selected'" : ""?>>
									<? echo $row["nombre"]?>
								</option><?
							}
							?>
						</select>
						</div>
					  </td>
					  <td>
					  <div align="left"><strong>Finalizadas</strong>:<br>
						<input type="radio" name="fin" value="1" <? echo ($_POST['fin'] == "1") ? "checked='checked'" : ""?>>Si <br>
						<input type="radio" name="fin" value="0" <? echo ($_POST['fin'] != "1") ? "checked='checked'" : ""?>>No <br>
					  </div>
					  </td>
					  <td>
					  <div align="left"><strong>Asignación</strong>:<br>
						<select name="asignacion">
							<option></option>
							<option value="FHC">FHC</option>
							<option value="NOMINACION">Nominación</option>
						</select>
					  </div>
					  </td>
				  </tr>
					<tr>
					  <td align="center" colspan="8">
						<div align="center">
							  <input type="submit" value="Buscar" class="botonesadmin" onClick="document.getElementById('exportarExcel').value='';">
							  <input type="button" class="botonesadmin" value="Restaurar Filtros" onClick="window.location='cuadro_do.php'">					
							  <? if($_SESSION['perfil'] == "1"){ //Solo pueden exportar administradores?>
								  <input type="submit" class="botonesadmin" value="Exportar a Excel" id="btnExcel">
									
								<? }?>
								<input type="hidden" id="exportarExcel" name="exportarExcel">
								
						        <input type="button" class="botonesadmin" onClick="window.location='radicacion_pto.php'" value="Radicación">
						</div></td>
					</tr>
				</table>
			</div>
		<? }?>
		</p>
		<!--Termina Filtros-->
		
		
		<?
		if((!$_POST['desde'] || !$_POST['hasta']) && !$_POST['shipping'] && (!$_POST['desde_etd'] || !$_POST['hasta_etd'] )  && (!$_POST['desde_eta'] || !$_POST['hasta_eta'] )  && !$_POST['mbl']  && !$_POST['hbl'] ){?>
			<p class="contenidotab" style="color:#990000;font-weight:700">
			Filtre por alguno de los siguientes campos
			<ul class="contenidotab">
				<li>Fecha de Creacion (Desde - Hasta)</li>
				<li>Shipping Instruction</li>
				<li>ETD (Desde - Hasta)</li>
				<li>ETA (Desde - Hasta)</li>
				<li>HBL</li>
				<li>MBL</li>
			</ul>
			</p>
			<?
			die();
		}

		//Realiza Consulta
		$sqlRep = "
			SELECT reporte_estado_cli.* FROM `reporte_estado_cli`";
			
		

		
		//------FILTROS---------
		//shipping
		if($_POST['shipping'] ){
			//Consulta los numeros de orden en sus respectivas tablas dependiendo si es aereo o terrestre, se hace primero una consulta que llama todos los numeros de orden, se crea un array y luego se lleva este a una sobconsulta de la consulta principal, esto no se hace directamente en mysqli, por que queda tardándose casi 45 segundos, en este caso tarda menos de 1 segundo
			$sqlRep .= "
					INNER JOIN shipping_instruction ON reporte_estado_cli.number = shipping_instruction.order_number
					AND numero LIKE '%".$_POST['shipping']."%' and reporte_estado_cli.number != ''
					UNION
					SELECT reporte_estado_cli . *
					FROM reporte_estado_cli
					INNER JOIN rn_fletes_aereo ON reporte_estado_cli.number = rn_fletes_aereo.order_number
					INNER JOIN shipping_instruction ON shipping_instruction.idreporte = rn_fletes_aereo.idreporte
					AND shipping_instruction.numero LIKE '%".$_POST['shipping']."%' and reporte_estado_cli.number != ''";


		}else{
			//Fecha de creacion
			$sqlRep .= " where 1 ";
			$sqlRep .= ($_POST['desde']) ?  " and fecha_creacion >= '".$_POST['desde']."'" : "";
			$sqlRep .= ($_POST['hasta']) ?  " and fecha_creacion <= '".$_POST['hasta']."'" : "";
			
			//Etd
			$sqlRep .= ($_POST['desde_etd'] ) ? " and etd >= '".$_POST['desde_etd']."' " : "";
			$sqlRep .= ($_POST['hasta_etd'] ) ? " and etd <= '".$_POST['hasta_etd']."' " : "";
	
			//Eta
			$sqlRep .= ($_POST['desde_eta'] ) ? " and eta >= '".$_POST['desde_eta']."' " : "";
			$sqlRep .= ($_POST['hasta_eta'] ) ? " and eta <= '".$_POST['hasta_eta']."' " : "";
			
			//IdCliente
			$sqlRep .= ($_POST['cliente']) ? " and idcliente = ".$_POST['cliente'] : "";
			
			//Shipper
			$sqlRep .= ($_POST['shipper']) ? " and shipper like '%".$_POST['shipper']."%' " : "";
			
			//Pedido - Number
			$sqlRep .= ($_POST['number']) ? " and number like '%".$_POST['number']."%' " : "";

			//Clasificacion
			$sqlRep .= ($_POST['clasificacion']) ? " and clasificacion like '%".$_POST['clasificacion']."%' " : "";
			
			//Naviera
			$sqlRep .= ($_POST['naviera']) ? " and naviera like '%".$_POST['naviera']."%' " : "";
			
			//Origen
			$sqlRep .= ($_POST['origen']) ? " and puerto_origen = ".$_POST['origen']." " : "";
			
			//Destino
			$sqlRep .= ($_POST['destino']) ? " and puerto_destino = ".$_POST['destino']." " : "";

			//hbl
			$sqlRep .= ($_POST['hbl']) ? " and hbl like '%".$_POST['hbl']."%' " : "";

			//mbl
			$sqlRep .= ($_POST['mbl']) ? " and mbl like '%".$_POST['mbl']."%' " : "";

			//Operativo Asignado
			$sqlRep .= ($_POST['operativo']) ? " and operativo like '%".$_POST['operativo']."%' " : "";
			
			//Servicio al cliente Asignado
			$sqlRep .= ($_POST['idcustomer']) ? " and servicio_cliente like '%".$_POST['idcustomer']."%' " : "";
			
			//Comercial
			$sqlRep .= ($_POST['comercial']) ? " and reporte_estado_cli.idcliente in(select idcliente from clientes where idvendedor in (select idvendedor_customer from vendedores_customer where idusuario= ".$_POST['comercial']."))" : "";

			//Área
			$sqlRep .= ($_POST['area']) ? " and reporte_estado_cli.number in (select order_number from shipping_instruction where numero like '".$_POST['area']."%')" : "";
			
			//País
			$sqlRep .= ($_POST['pais']) ? " and reporte_estado_cli.puerto_origen in (select idaeropuerto_puerto from ciudades_has_aeropuertos_puertos where idciudad in (select idciudad from ciudades where idpais = ".$_POST['pais']."))" : "";
			
			//Status
			$sqlRep .= ($_POST['fin'] == 1) ? " and reporte_estado_cli.status = 'Cerrada'" : " and reporte_estado_cli.status = 'Abierta'";

			$sqlRep .= " order by eta desc";
		}
		
		//echo $sqlRep;die();

		if(date("Y-m-d",strtotime($_POST['hasta']))  < date("Y-m-d",strtotime($_POST['desde'])) ){
			echo "<center style='color:#666666;font-size:13px'>Fecha de inicio superior a fecha final.</center>";die();
		}

		if(!$qryRep = mysqli_query($link,$sqlRep)){
			echo "<center style='color:#666666;font-size:13px'>La consulta no se realizó, por favor contacte al administrador<br>".mysqli_error()."<br><br>$sqlRep</center>";die();
		}
		
		if( mysqli_num_rows($qryRep) == 0){
			echo "<center style='color:#666666;font-size:13px'>No se encontraron registros para esta consulta.</center>";die();
		}
		
		

		?>	
		<p>
			
			<?
			//Array que contiene las columnas
			$filasTab = array(
						"1"=>"Shipping",
						"2"=>"Agente",
						"3"=>"Cliente",
						"4"=>"Shipper",
						"5"=>"Pedido",
						"6"=>"Recibido",
						"7"=>"Tipo de Embarque",
						"8"=>"Naviera",
						"9"=>"Origen",
						"10"=>"Destino",
						"11"=>"ETD",
						"12"=>"MBL",
						"13"=>"HBL",
						"14"=>"Contenedor",
						"15"=>"Q. TEU",
						"16"=>"TEU",
						"17"=>"PESO KG",
						"18"=>"CBM/VOL",
						"19"=>"Motonave/Vuelo.",
						"20"=>"No Factura.",
						"21"=>"Fecha Factura",
						"22"=>"ETA.",
						"23"=>"Emisión MBL.",
						"24"=>"Emisión HBL.",
						"25"=>"Fecha Conexion.",
						"26"=>"Radicación Puerto",
						"27"=>"Entrega Sc",
						"28"=>"Recibido Operaciones",
						"29"=>"Muelle",
						"30"=>"Aduana",
						"31"=>"Otm",
						"32"=>"Terrestre"

			);
			
			if($_POST['filtros']){ //si hay filtros los aplica en ela columna
				$filtrosSel = $_POST['filtros'];
			}else{ //si no hay filtros deja los predeterminados
				$filtrosSel = array("1","3","5","9","10","11","22");
			}
			
			
			if($_POST['exportarExcel'] != "1"){
				?>
				<div style="height:130px;width:220px;overflow:scroll;">
					<table cellpadding="2" class="contenidotab" id="showCol">	
						<tr class="tittabla">
							<td align="center">Ver/ocultar</td>
							<td>Columna</td>
						</tr>
						<!--
						<tr><td><input type="checkbox" class="showTr" value="1"></td><td>Shipping</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="2"></td><td>Agente</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="3"></td><td>Cliente</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="4"></td><td>Shipper</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="5"></td><td>Pedido</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="6"></td><td>Recibido</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="7"></td><td>Tipo de Embarque</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="8"></td><td>Naviera</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="9"></td><td>Origen</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="10"></td><td>Destino</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="11"></td><td>ETD</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="12"></td><td>MBL</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="13"></td><td>HBL</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="14"></td><td>Contenedor</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="15"></td><td>Q. TEU</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="16"></td><td>TEU</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="17"></td><td>PESO KG</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="18"></td><td>CBM/VOL</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="19"></td><td>Motonave/Vuelo.</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="20"></td><td>No Factura.</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="21"></td><td>Fecha Factura</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="22"></td><td>ETA.</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="23"></td><td>Emisión MBL.</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="24"></td><td>Emisión HBL.</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="25"></td><td>Fecha Conexion.</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="26"></td><td>Radicación Puerto</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="27"></td><td>Entrega Sc</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="28"></td><td>Recibido Operaciones</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="29"></td><td>Muelle</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="30"></td><td>Aduana</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="31"></td><td>Otm</td></tr>
						<tr><td><input type="checkbox" class="showTr" value="32"></td><td>Terrestre</td></tr>
						-->
						<?
						
						
						foreach ($filasTab as $i => $value) {
							$chk = (in_array($i,$filtrosSel)) ? "checked='checked'": "";?>
							<tr>
								<td><input type="checkbox" name="filtros[]" class="showTr" value="<?= $i;?>" <?= $chk;?>></td>
								<td><?= $filasTab[$i]?></td>
							</tr>
							<?
						}
						
						?>
					</table>
				</div>
			<?
			}

			?>
		</p>
		<div>
			<input type="hidden" name="tablaTemp" id="tablaTemp">
			
			<!--Inicia tabla principal-->
			<table align="center" cellpadding="5" id="tabla" class="contenidotab" <? if($_POST['exportarExcel'] == 1 ) echo "style='white-space:nowrap'";?> >
				<!--Titulos-->
				<tr class="tittabla">
					<?
					$x = 1;
					
					?>
					<td <?= colSel($x);$x++?>>Shipping</td>
					<td <?= colSel($x);$x++?>>Agente</td>
					<td <?= colSel($x);$x++?>>Cliente</td>
					<td <?= colSel($x);$x++?>>Shipper</td>				
					<td <?= colSel($x);$x++?>>Pedido</td>
					<td <?= colSel($x);$x++?>>Recibido</td>
					<td <?= colSel($x);$x++?>>Tipo de Embarque</td>
					
					<td <?= colSel($x);$x++?>>Naviera</td>
					<td <?= colSel($x);$x++?>>Origen</td>
					<td <?= colSel($x);$x++?>>Destino</td>
					<td <?= colSel($x);$x++?>>ETD</td>
					<td <?= colSel($x);$x++?>>MBL/MAWB</td>
					<td <?= colSel($x);$x++?>>HBL/HAWB</td>
					<td <?= colSel($x);$x++?>>Contenedor / Piezas </td>
					<td <?= colSel($x);$x++?>>Q. TEU</td>
					<td <?= colSel($x);$x++?>>TEU</td>
					<td <?= colSel($x);$x++?>>PESO KG</td>
					<td <?= colSel($x);$x++?>>CBM/VOL</td>
					<td <?= colSel($x);$x++?>>Motonave/Vuelo.</td>				
					<td <?= colSel($x);$x++?>>No Factura</td>				
					<td <?= colSel($x);$x++?>>Fecha <br>
					Factura</td>
					
					<td <?= colSel($x);$x++?>>ETA</td>
					<td <?= colSel($x);$x++?>>Emisi&oacute;n<br>MBL</td>
					<td <?= colSel($x);$x++?>>Emisi&oacute;n<br>HBL</td>
					<td <?= colSel($x);$x++?>>Fecha<br>Conexi&oacute;n</td>
					<td <?= colSel($x);$x++?>>Radicacion <br>Puerto</td>
					<td <?= colSel($x);$x++?>>Entrega <br>Sc</td>
					<td <?= colSel($x);$x++?>>Recibido <br>Operativo</td>
					<td <?= colSel($x);$x++?>>Muelle</td>
					<td <?= colSel($x);$x++?>>Aduana</td>
					<td <?= colSel($x);$x++?>>Otm</td>
					<td <?= colSel($x);$x++?>>Terrestre</td>
					
					<td>Comerntarios<br>Servicio al Cliente
						<input type="hidden" name="s_cli_tmp" id="s_cli_tmp"><!--almacena temporalemente el id cuando se digite un valor en algun textarea de esta columna, para almacenarlo en la base de datos-->					</td>
				  <td>Comentarios<br>
				    Operaciones
					<input type="hidden" name="s_oper" id="s_oper"></td>
				</tr>
				
				<?


				
				//Recorre resultados de la consulta
				
				while($reporte = mysqli_fetch_array($qryRep)){
					$x = 1;
					$color = ($color == "#CCCCCC") ? "#FFFFFF" : "#CCCCCC";
					?>
					<tr bgcolor="<? echo $color;?>" style="text-align:center">
						<td <?= colSel($x);$x++?>><? 
							if( $reporte['clasificacion'] == "aereo") //Si es aereo busca en la tabla rn_fletes_aero
								$shippingSql = "select numero from shipping_instruction where idreporte = (select idreporte from rn_fletes_aereo where `order_number` ='".$reporte['number']."')";
							else
								$shippingSql = "select numero from shipping_instruction where order_number ='".$reporte['number']."'";
							
		
							
							if(!$shippingQry = mysqli_query($link,$shippingSql))
								echo  "<p style='color:#990000'>Order Number mal creada, seguramente se creó mas de una vez</p>" ;
							else{
								$shipping = mysqli_fetch_array($shippingQry);
								echo $shipping[0];
							}
						?>						
						</td>
						
						<td <?= colSel($x);$x++?>>
							<?
							if($reporte["clasificacion"] != "aereo"){
								$sqlAge = "
								SELECT * FROM `proveedores_agentes` where  idproveedor_agente  = (
									select idagente from tarifario where idtarifario = (
										select idtarifario from cot_fletes where idcot_fletes = (
											select idcot_fletes from rn_fletes where order_number = '".$reporte["number"]."' 
										)
									)
								)";
							}else{
								$sqlAge = "
								SELECT * FROM `proveedores_agentes` where  idproveedor_agente  = (
									select idagente from tarifario_aereo where idtarifario_aereo = (
										select idtarifario_aereo from cot_fletes_aereo where idcot_fletes_aereo = (
											select idcot_fletes_aereo from rn_fletes_aereo where order_number = '".$reporte["number"]."' 
										)
									)
								)";
							}
							if(!$qryAge = mysqli_query($link,$sqlAge)){
								echo  "<p style='color:#990000'>Order Number mal creada, seguramente se creó mas de una vez</p>" ;
							}else{
								$agente = mysqli_fetch_array($qryAge);
								echo $agente["nombre"];
							}
							
	
								
							?>					
						</td>
						<td <?= colSel($x);$x++?>><? echo scai_get_name($reporte["idcliente"],"clientes","idcliente","nombre");?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["shipper"]?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? 
							$sqlON = "select idreporte_estado,number from reporte_estado_cli where number = '".$reporte["number"]."'";
							$qryON = mysqli_query($link,$sqlON);
							$NoOn = mysqli_fetch_array($qryON) ;
							if( mysqli_num_rows($qryON) > 1 )
								echo $reporte["number"]; //Si el numero de orden está repetido, no da la opcion de direccionar, ps puede generar un error
							else {?>
								<a href="re_flete_cli.php?idcliente=<? echo $reporte["idcliente"];?>&idreporte_estado=<? echo $NoOn[0]?>"><? echo $reporte["number"];?></a><?
							}

						 ?>&nbsp;						</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["recibido"]?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["clasificacion"]?>&nbsp;</td>
						
						<td <?= colSel($x);$x++?>><? echo $reporte["naviera"]?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo scai_get_name($reporte["puerto_origen"],"aeropuertos_puertos","idaeropuerto_puerto","nombre"); ?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo scai_get_name($reporte["puerto_destino"],"aeropuertos_puertos","idaeropuerto_puerto","nombre"); ?>&nbsp;</td>
						
						<td <?= colSel($x);$x++?>><? echo $reporte["etd"]?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["mbl"]?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["hbl"]?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["ref"]?>&nbsp;</td>
						<td <?= colSel($x);$x++?>>
							<?
							if($_POST['exportarExcel'] != 1 ){
								echo ($reporte["n20"]) ? "20=".$reporte["n20"]." <br> " : "" ;
								echo ($reporte["n40"]) ? "40 = ".$reporte["n40"]." <br> " : "" ;
								echo ($reporte["n40hq"]) ? "40hq =".$reporte["n40hq"]." <br> " : "" ;
							}else{
								echo ($reporte["n20"]) ? "20=".$reporte["n20"] : "\n" ;
								echo ($reporte["n40"]) ? "40 = ".$reporte["n40"] : "\n" ;
								echo ($reporte["n40hq"]) ? "40hq =".$reporte["n40hq"] : "\n" ;
							}
							?>					&nbsp;</td>
						<td <?= colSel($x);$x++?>>
							<?
							//calcula el numero de teu (para cada de 20 = 1 teu, y para cada de 40 = 2 tu), y multiplica por el numero de contenedores indicados en reporte estado
							if($reporte["n20"]){ //contenedor de 20
								$teu += $reporte["n20"];
							}
							if($reporte["n40"]){ //contenedor de 40
								$teu += $reporte["n40"] * 2;
							}
							if($reporte["n40hq"]){ //contenedor de 40 hq
								$teu += $reporte["n40hq"] * 2;
							}
							echo $teu;
							$teu =0;
							?>
						</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["peso"]?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["volumen"]?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["motonave"]?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["no_factura"]?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["fecha_factura"]?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["eta"]?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["emision_mbl"]; ?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["emision_hbl"]; ?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["fecha_conexion"]; ?>&nbsp;</td>
						<td <?= colSel($x);$x++?>><? echo $reporte["gastos_destino"]; ?>&nbsp;</td>
						<td <?= colSel($x);$x++?>>&nbsp;<? echo $reporte["entrega_sc"]; ?></td>
						<td <?= colSel($x);$x++?>><? echo $reporte["rdo_operativo"]; ?></td>
						<td <?= colSel($x);$x++?>><? echo $reporte["aduana"]; ?></td>
						<td <?= colSel($x);$x++?>><? echo ($reporte["aduanaChk"] == "1") ? "<img src='./images/Check.jpg' width='25'>" : "" ; ?></td>
						<td <?= colSel($x);$x++?>><? echo ($reporte["otmChk"] == "1") ? "<img src='./images/Check.jpg' width='25'>" : "" ; ?></td>
						<td <?= colSel($x);$x++?>><? echo ($reporte["terrestreChk"] == "1") ? "<img src='./images/Check.jpg' width='25'>" : "" ; ?></td>
						
						<td>
						<? if($_POST['exportarExcel'] != 1 ){ ?>
							<textarea id="com_serv_<? echo $reporte["idreporte_estado"]?>" name="com_serv_<? echo $reporte["idreporte_estado"]?>" onChange="document.getElementById('s_cli_tmp').value=this.id;document.getElementById('exportarExcel').value='';cuadro_form.submit()"><? echo $reporte["coment_servicio_cliente"];?></textarea>
						<?
						}else{
							echo $reporte["coment_servicio_cliente"];
						}
						?>
						&nbsp;
						</td>
						<td>
						<? if($_POST['exportarExcel'] != 1 ){ ?>
							<textarea id="com_oper_<? echo $reporte["idreporte_estado"]?>" name="com_oper_<? echo $reporte["idreporte_estado"]?>" onChange="document.getElementById('s_oper').value=this.id;document.getElementById('exportarExcel').value='';cuadro_form.submit()"><? echo $reporte["coment_oper"];?></textarea>&nbsp;
						<?
						}else{
							echo $reporte["coment_oper"];
						}
						?>
						</td>
					</tr>
	
				
				<?
				}

				?>
			</table>
			<?
			//Elimina las columnas que están ocultas para que no aparezcan en el excel, almacena la tabla en el input tablaTemp, y reenvia el form, se hace este direccionamiento, por que de lo contrario no se ocultan las columnas en excel

			if($_POST['exportarExcel'] == "1"){

				?>
				<script>

					$("#tabla tbody tr").each(function (index) 
					{
						$(this).children("td").each(function (index2) 
						{
							if($(this).css("display") == "none"){
								$(this).remove();
							}
						})
						
					});
					$("#tablaTemp").val($("#tabla").html());
					cuadro_form.action='?opc=exportarExcel';
					
					cuadro_form.submit();
					
					

				</script><?
				
			}
			
			?>

		</div>
	</form>
	
	
	
		</div>


	</body>
</html>
