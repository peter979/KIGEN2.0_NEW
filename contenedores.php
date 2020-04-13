<?
include('./sesion/sesion.php');
include("./conection/conectar.php");
include_once("./permite.php");
include_once("scripts/recover_nombre.php");
include('scripts/scripts.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<script type="text/javascript" src="./js/jquery-1.8.3.js" ></script>
	
    <link href="./css/admin_internas.css" rel="stylesheet" type="text/css">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
	<?
	set_time_limit(0);
	function sumarFechas($fecha,$dias){
		$dias = ($dias =='') ? 0 : $dias;

		$nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) ;
		return date('Y-m-d',$nuevafecha );
	}
	function restarFechas($moras,$devuelto){
		if($moras == "0000-00-00" || $devuelto == "0000-00-00"){
			return 0;
		}else{
			$moras = strtotime($moras);
			$devuelto = strtotime($devuelto);
			$segundos = $devuelto - $moras;
			$diferencia_dias=intval($segundos/60/60/24);
			
			return  $diferencia_dias;
		}	
		
	}
	?>
</head>

<body>
<h2>Contenedores:</h2>
<form method="post">

	<p>
	<table class="tabla" width="75%" align="center" cellpadding="5">
		<tr class="tittabla"><td colspan="7">Filtros</td></tr>
		<tr>
			<td>Cliente:<input type="text" name="cliente" value="<? echo $_POST['cliente'];?>" /></td>
			<td>N. Orden:<input type="text" name="orden" value="<? echo $_POST['orden'];?>" /></td>
			<td>MBL:<input type="text" name="mbl" value="<? echo $_POST['mbl'];?>" /></td>
			<td>
				Tipo:
				<select name="tipoCont">
					<option></option>
					<option <? echo ($_POST['tipoCont'] == "20") ? "selected='selected'" : "" ; ?> >20</option>
					<option <? echo ($_POST['tipoCont'] == "40") ? "selected='selected'" : "" ; ?> >40</option>
					<option <? echo ($_POST['tipoCont'] == "40Hq") ? "selected='selected'" : "" ; ?> >40Hq</option>
				</select>
			</td>
			<td>No Contenedor:<input type="text" name="noContenedor" value="<? echo $_POST['noContenedor'];?>" /></td>
			<td>Naviera:<input type="text" name="naviera" value="<? echo $_POST['naviera'];?>" /></td>
			<td>Operador:<input type="text" name="operador" value="<? echo $_POST['operador'];?>" /></td>
			
		</tr>
		<tr>
			<td colspan="7" align="center">ETA:<br>
				Desde:
				<input id="desde" name="desde" onClick="return showCalendar('desde');" value="<?= $_POST["desde"];?>" size="7" readonly >
				Hasta:
				<input id="hasta" name="hasta" onClick="return showCalendar('hasta');" value="<?= $_POST["hasta"];?>" size="7" readonly >
				
			</td>
		</tr>
		<tr>
		  <td colspan="7" align="center"><input name="submit" type="submit" class="botonesadmin" value="Buscar" />
		    <input type="button" onclick="window.location='contenedores.php'" class="botonesadmin" value="Reestablecer" />
		    <input name="button" type="button" class="botonesadmin" onclick="window.location='contenedores_demoraMail.php'" value="Informe - Vencidos" /></td>
		</tr>
	</table>
	</p>
	<table cellpadding="10" width="80%" class="contenidotab tabla">
	  <tr class="tittabla">
 	  	<td>O. Number</td>
		<td>CLIENTE</td>
		<td>TIPO</td>
		<td>MBL</td>
		<td>No CONTENEDOR</td>
		<td>NAVIERA</td>
		<td>OPERADOR</td>
		<td>ETA</td>
		<td>DIAS LIBRES NAVIERA</td>
		<td>DIAS LIBRES GW</td>
		<td>PARA EL CLIENTE/INICIO MORAS</td>
		<td>TIEMPO REAL/INICIO DE MORAS    G-WAY</td>
		<td>DEVUELTO</td>
		<td>V MORAS X COBRAR GW</td>
		<td>V MORAS X    COBRAR NAVIERA</td>
		<td>TOTAL</td>
	  </tr>
	  <?
	  $sqlCont = "select
	  		 			clientes.idcliente as idcliente,
						clientes.nombre as cliente,
						rep.idreporte_estado as idrep,
						rep.number as number,
						rep.n20,
						rep.n40,
						rep.n40hq,
						rep.mbl,
						rep.hbl,
						cont.number as contenedor,
						cont.devuelto as devuelto,
						cont.tipo as tipo,
						rep.naviera,
						rep.eta,
						rep.naviera,
						rep.dias_libres as dias_libres,
						naviera.nombre as nombreNavera,
						naviera.operador_cont as operador,
						naviera.val20 as val20,
						naviera.val40 as val40,
						naviera.val40Hq as val40Hq,
						rep.val20gw as val20gw,
						rep.val40gw as val40gw,
						rep.val40Hqgw as val40Hqgw,
						rep.dias_libres_gw as dias_libres_gw
					from contenedores  as cont
					inner join reporte_estado_cli as rep on  rep.idreporte_estado = cont.idreporte_estado
					inner join clientes on clientes.idcliente = rep.idcliente 
					inner join proveedores_agentes as naviera on naviera.nombre = rep.naviera
					where 1
					and rep.clasificacion = 'fcl'
					and rep.number != ''";
		//Aplica filtros
		$sqlCont .= ($_POST['cliente']) ? " and clientes.nombre like '%".$_POST['cliente']."%'" : "";
		$sqlCont .= ($_POST['orden']) ? " and rep.number like '%".$_POST['orden']."%'" : "";
		
		$sqlCont .= ($_POST['mbl']) ? " and rep.mbl like '%".$_POST['mbl']."%'" : "";
		$sqlCont .= ($_POST['tipoCont']) ? " and cont.tipo = '".$_POST['tipoCont']."'" : "";
		$sqlCont .= ($_POST['noContenedor']) ? " and cont.number like '%".$_POST['noContenedor']."%'" : "";
		$sqlCont .= ($_POST['naviera']) ? " and naviera.nombre like '%".$_POST['naviera']."%'" : "";
		$sqlCont .= ($_POST['operador']) ? " and naviera.operador_cont like '%".$_POST['operador']."%'" : "";
		$sqlCont .= ($_POST['desde']) ? " and rep.eta >= '".$_POST['desde']."'" : "";
		$sqlCont .= ($_POST['hasta']) ? " and rep.eta <= '".$_POST['hasta']."'" : "";
		
		$sqlCont .= " order by cont.idcontenedor desc";
		//echo $sqlCont;die();
		
		//Aplica paginacion
		$cantRegistros=15;
		$pagina = (!$_POST["pagina"]) ? 0 : $_POST["pagina"]-1;
		$pagina = $pagina *$cantRegistros;

		
		$qryCont = mysqli_query($link,$sqlCont);
		$noPaginas = ceil(mysqli_num_rows($qryCont) / $cantRegistros);
		
		
		$sqlCont .= " limit $pagina,$cantRegistros";
		
		$qryCont = mysqli_query($link,$sqlCont);
		
		//echo "<br>".$sqlCont;
		
		
		while( $contenedor =  mysqli_fetch_array($qryCont)){?>
			  <tr bgcolor="<? echo ($color == "#CCCCCC") ? $color = "#FFFFFF": $color="#CCCCCC"; ?>">
			  	<td><a href="re_flete_cli.php?idcliente=<?= $contenedor["idcliente"];?>&idreporte_estado=<?= $contenedor["idrep"]?>">
					<? echo $contenedor["number"];?></a></td>
				<td><? echo $contenedor["cliente"];?></td>
				<td>
					<?
					echo $contenedor["tipo"];
					?>				
					</td>
				<td><? echo $contenedor["mbl"];?></td>
				<td><? echo $contenedor["contenedor"];?></td>
				<td><? echo $contenedor["naviera"];?></td>
				<td><? echo $contenedor["operador"];?></td>
				<td><? echo $contenedor["eta"];?></td>
				<td><? echo $contenedor["dias_libres"];?></td>
				<td><? echo $contenedor["dias_libres_gw"];?></td>
				<td><? 
					$moras = sumarFechas($contenedor["eta"],$contenedor["dias_libres"]);
					echo $moras;?></td>
				<td><? 
						$moras_gw = sumarFechas($contenedor["eta"],$contenedor["dias_libres_gw"]);
						echo $moras_gw;?></td>
				<td><? echo $contenedor["devuelto"];?></td>
				<td><? 
					$etaLessDev = restarFechas($contenedor["eta"],$contenedor["devuelto"]);
					$vMoraG = $etaLessDev - $contenedor["dias_libres_gw"] ;
					$vMoraG = ($vMoraG < 0) ? 0 : $vMoraG;
					
					
					
					switch($contenedor["tipo"]){
						case "20":
							$vMoraG = $vMoraG * $contenedor["val20gw"];
							break;
						case "40":
							$vMoraG = $vMoraG * $contenedor["val40gw"];
							break;
						case "40Hq":
							$vMoraG = $vMoraG * $contenedor["val40Hqgw"];
							break;
					}
					echo number_format($vMoraG,0,"",".") ;
					?></td>
				<td><? 
					$vMora = $etaLessDev - $contenedor["dias_libres"] ;
					$vMora = ($vMora < 0) ? 0 : $vMora;
					
					
					
					switch($contenedor["tipo"]){
						case "20":
							$vMora = $vMora * $contenedor["val20"];
							break;
						case "40":
							$vMora = $vMora * $contenedor["val40"];
							break;
						case "40Hq":
							$vMora = $vMora * $contenedor["val40Hq"];
							break;
					}
					echo number_format($vMora,0,"",".") ;
					?></td>
				<td><?= $vMoraG - $vMora?></td>
			  </tr><?
		}
		?>
	</table>
	
	<p>
  <table align="center" width="15%">
			<tr class="tittabla"><td>Paginaci�n</td></tr>
			<tr>
				<td align="center">
					<select name="pagina" onchange="form.submit()">
						<? for($i=1 ;$i<= $noPaginas ; $i++){?>
							<option <? echo ($i == $_POST['pagina']) ? "selected='selected'" : "";?>><? echo $i?></option>
						<?
							}
						?>
					</select>
				</td>
			</tr>
  </table>
	</p>
</form>
</body>
</html>
