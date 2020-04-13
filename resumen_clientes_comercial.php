<?
include_once('./sesion/sesion.php');
include("./conection/conectar.php");	
include_once("./permite.php");
include_once("scripts/recover_nombre.php");
include('scripts/scripts.php');

if($_GET['limpia']=='si'){
	$sqlc = "delete from clientes_tmp where idusuario='$_SESSION[numberid]'";
	$exec = mysqli_query($link,$sqlc);
	print "<script>document.location.href='resumen_clientes.php'</script>";
}
?>
<link href="./css/admin_internas.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/funciones.js"></script>

<?

if($_GET['opc']=="estadisticas"){?>
	<form method="post" action="?opc=estadisticas">
		<table cellpadding="7" border="0" align="center" class="contenidotab">
			<tr>
				<td colspan="2" align="center" class="tittabla">Fecha Etd </td>
				<td colspan="2" align="center" class="tittabla">Fecha Eta </td>
				<td colspan="4" align="center" class="tittabla">Locacion:</td>
			</tr>

			<tr style="text-align:center">
				<td>Desde:<br />
				
				<input id="desde_etd" name="desde_etd" onClick="return showCalendar('desde_etd');" size="7" value="<? echo ($_POST['desde_etd']) ? $_POST['desde_etd'] : "" ;  ?>" readonly >
				<td>
					Hasta:<br /><input id="hasta_etd" name="hasta_etd" onClick="return showCalendar('hasta_etd');" size="7"  value="<? echo ($_POST['hasta_etd']) ? $_POST['hasta_etd'] : "" ;  ?>" readonly>
				</td>
				<td>Desde:<br />
				
				<input id="desde_eta" name="desde_eta" onClick="return showCalendar('desde_eta');" size="7"  value="<? echo ($_POST['desde_eta']) ? $_POST['desde_eta'] : "" ;  ?>" readonly>
				<td>
					Hasta:<br /><input id="hasta_eta" name="hasta_eta" onClick="return showCalendar('hasta_eta');" size="7" value="<? echo ($_POST['hasta_eta']) ? $_POST['hasta_eta'] : "" ;  ?>" readonly>
				</td>
				<td>Origen:<br />
					<? $sql_pto_o = mysqli_query($link,"select * from aeropuertos_puertos where tipo = 'puerto' and estado = '1' order by nombre asc"); ?>
					<select name="pto_o" id="pto_o" style="width:80px">
						<option></option>
						<? while($exe_pto_o = mysqli_fetch_array($sql_pto_o)){?>
							<option value="<? echo $exe_pto_o["idaeropuerto_puerto"];?>" <? echo ($exe_pto_o["idaeropuerto_puerto"] == $_POST["pto_o"]) ? "selected='selected'" : "" ?> >
								<? echo $exe_pto_o["nombre"]?>
							</option>
						<? }?>
					</select>
				</td>
				
				<td>
				Destino<br />
				<? $sql_pto_d = mysqli_query($link,"select * from aeropuertos_puertos where tipo = 'puerto' and estado = '1' order by nombre asc");?>
					<select name="pto_d" id="pto_d" style="width:80px">
						<option></option>
						<? while($exe_pto_d = mysqli_fetch_array($sql_pto_d)){?>
							<option value="<? echo $exe_pto_d["idaeropuerto_puerto"];?>" <? echo ($exe_pto_d["idaeropuerto_puerto"] == $_POST["pto_d"]) ? "selected='selected'" : "" ?> >
							<? echo $exe_pto_d["nombre"]?></option>
						<? }?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Cliente:</td>
				<td>
					<select>
						<?  $sql_cli = mysqli_query($link,"select * from clientes where estado 1");
						
							while( $exe_cli = mysqli_fetch_array($sql_cli)){?>
								<option><? echo $exe_cli["nombre"]?></option>
							<?
							
							}
						
						?>
						
					</select>
				</td>
			</tr>
			<tr><td colspan="8" align="center"><input type="submit" value="Consultar" class="botonesadmin" />
			  <input name="submit" type="button" onclick="window.location=''" class="botonesadmin" value="Borrar Filtros" /></td></tr>
		</table>
	</form>
	
	<?

	$pto_o = $_POST["pto_o"];
	$pto_d = $_POST["pto_d"];

	
	
	$sql = "SELECT count(`idreporte_estado`) as numero_registros , `clasificacion` FROM `reporte_estado_cli` where 1 ";
	$sql .= ($_POST['desde_etd']) ? " and etd > '".$_POST['desde_etd']."'" : "" ;
	$sql .= ($_POST['hasta_etd']) ? " and etd < '".$_POST['hasta_etd']."'" : "" ;
	$sql .= ($_POST['desde_eta']) ? " and eta > '".$_POST['desde_eta']."'" : "" ;
	$sql .= ($_POST['hasta_eta']) ? " and eta < '".$_POST['hasta_eta']."'" : "" ;
	
	
	$sql .= " and puerto_origen like '%".$_POST['pto_o']."%'
				and puerto_destino like '%".$_POST['pto_d']."%'	";
	
	
	$sql .= " GROUP BY `clasificacion`";
	$sql_qry= mysqli_query($link,$sql);
	
	

	while($exe_qry = mysqli_fetch_array($sql_qry)){
		$numero .= $exe_qry["numero_registros"].",";

	}

	?>
	<table cellpadding="10" class="contenidotab" align="center">
		<tr>
			<td rowspan="5">
				<img src="graph/graphpastel.php?dat=<? echo substr($numero,0,strlen($numero)-1)?>&bkg=FFFFFF&wdt=190&hgt=140" />
				<? $numero = explode(",",$numero);?>
			</td>
		</tr>
		<tr><td><img src="graph/graphref.php?ref=8&typ=1&dim=5&bkg=FFFFFF" />Fcl <? echo $numero[1] ?></td></tr>
		<tr><td><img src="graph/graphref.php?ref=5&typ=1&dim=5&bkg=FFFFFF" />Vacio <? echo $numero[0] ?></td></tr>
		<tr><td><img src="graph/graphref.php?ref=11&typ=1&dim=5&bkg=FFFFFF" />Lcl <? echo $numero[2] ?></td></tr>
		<tr><td><img src="graph/graphref.php?ref=14&typ=1&dim=5&bkg=FFFFFF" />Aereo <? echo $numero[3] ?></td></tr>
	</table>
	
	<br /><br />

<? }else{?>
		
		<script type="text/javascript">
		
		function validaEnvia(form)
		{
			form.datosok.value="si";
			form.submit()
		}
		
		function recoger_cli(filtre, filtre2, filtre3, filtre4, filtradocli)
		{
		/*
			var lista_cli='';
			var ponerComa=false;
			if(document.formulario.selcli.length <= 1 || document.formulario.selcli.length == null)
			{
				if(document.formulario.selcli.checked)
				{
					lista_cli=document.formulario.selcli.value;
				}
			}else
			{
				for(i=0;i<document.formulario.selcli.length;i++)
				{
					if(document.formulario.selcli[i].checked)
					{
						if(ponerComa==true)
						{
							lista_cli=lista_cli + ',';
						}
						lista_cli = lista_cli + document.formulario.selcli[i].value;
						ponerComa=true;		
					}
				}
			}
			guardatemp_cli(lista_cli);
			filtrar_cli(filtre, filtre2, filtre3, filtre4, filtradocli);*/
		}
		function guardatemp_cli(lista_cli){/*
			solicida2 = cobra();
			solicida2.open("POST", "guarda_temp_cli.php", true);
			solicida2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			solicida2.send("lista_cli="+lista_cli+"&clipag="+document.formulario.clipag.value);
			solicida2.onreadystatechange = cambios14;*/
		}
		
		function cambios14(){/*
			var capa_eyes14 = window.document.getElementById("eyes14");
			if(solicida2.readyState == 4)
			{
				capa_eyes14.innerHTML = solicida2.responseText;
			}
			else
			{
				capa_eyes14.innerHTML = '<img src="images/loading.gif" align="middle" /> Buscando...';
			}*/
		}
		
		function filtrar_cli(filtre, filtre2, filtre3, filtre4, filtradocli){
			/*
			ver_sel_cli = '0';
			
			if(document.getElementById('ver_sel_cli').checked)
			{
				ver_sel_cli = document.getElementById('ver_sel_cli').value;
			}
			pause(500);// para dar tiempo a que se guarden los temporales
			
			var capa_eyes_cli = window.document.getElementById("eyes_cli");
			//solicita = new XMLHttpRequest();
			solicita = cobra();
			solicita.open("GET", "search_cli.php?filtro1="+filtre+"&filtro2="+filtre2+"&filtro3="+filtre3+"&filtro4="+filtre4+"&ver_sel_cli="+ver_sel_cli+"&filtradocli="+filtradocli, true);
			solicita.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			solicita.send("filtro1="+filtre+"&filtro2="+filtre2+"&filtro3="+filtre3+"&filtro4="+filtre4+"&ver_sel_cli="+ver_sel_cli+"&filtradocli="+filtradocli);
			solicita.onreadystatechange = cambios_cli;*/
		}
		
		function cambios_cli()
		{
			/*
			var capa_eyes_cli = window.document.getElementById("eyes_cli");
			if(solicita.readyState == 4)
			{
				capa_eyes_cli.innerHTML = solicita.responseText;
			}
			else
			{
				capa_eyes_cli.innerHTML = '<img src="images/loading.gif" align="middle" /> Buscando...';
			}*/
		}
		
		function cobra()
		{
			/*
			if (window.XMLHttpRequest)
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
				return new XMLHttpRequest();
			}
			if (window.ActiveXObject)
			{
				// code for IE6, IE5
				return new ActiveXObject("Microsoft.XMLHTTP");
			}*/
		}
		
		function pause(mili)
		{
			/*
			var date = new Date();
			var curdate = null;
			do { curdate = new Date(); }
			while((curdate - date) < mili)
			*/
		}
		</script>
		
		<?
		if($_POST['datosok']=='si')
			print "<script>document.location.href='mail_cuadro_seguimientos.php';</script>";
		?>
		<form name="formulario" method="post">
		<input name="datosok" type="hidden" value="no" />
		<div id="eyes14"></div>
		<table width="100%" >
			<tr>
				<td class="subtitseccion" style="text-align:center">
				REPORTES DE ESTADO ZONA CLIENTES
		
			   
			<form name="formulario1" method="post">	
				 <? $_GET['filtro1'] = str_replace("\\", "", $_GET['filtro1']); ?>
					<table width="100%" align="center" class="contenidotab" border=0>     
				<tr>
					<td class="tit_vueltas" align="center" border="0"> Vendedor&nbsp;
		
				<select name="filtro1" class="Ancho_120px" id="filtro1" >
						<option value="N"> Seleccione </option>
						<?
						$es="select idvendedor_customer, nombre from vendedores_customer order by nombre";
						$exe=mysqli_query($link,$es);
						while($row=mysqli_fetch_array($exe))
						{
							$sel = "";
							if($_GET['filtro1']==$row['idvendedor_customer'])
								$sel = "selected";
							$nombre = scai_get_name("$row[idvendedor_customer]","vendedores_customer", "idvendedor_customer", "nombre");
							print "<option value='$row[idvendedor_customer]' $sel>$nombre</option>";
						}
						?>
					</select> Razon Social <input name="filtro3" id="filtro3"  type="text" value="<? print $_GET['filtro3']?>" maxlength="50" size="30">
		
				Order Number<input name="filtro4" id="filtro4"  type="text" value="<? print $_GET['filtro4']?>" maxlength="50" size="15">
		
				REF<input name="filtro5" id="filtro5"  type="text" value="<? print $_GET['filtro5']?>" maxlength="50" size="15">
				<br>
				</td>
				
				</tr>
				</table>
					
		
				<input name="boton" class="botonesadmin" style="color:#FFFFFF;" value="Buscar" type="button" onClick="document.location = '<? print $_SERVER['PHP_SELF']; ?>?filtro1=' + document.forms[0].filtro1.value + '&filtro3=' + document.forms[0].filtro3.value + '&filtro4=' + document.forms[0].filtro4.value + '&filtro5=' + document.forms[0].filtro5.value;">
					&nbsp;<input name="boton2" class="botonesadmin" style="color:#FFFFFF;" value="Restablecer filtros" type="button" onClick="document.location = '<? print $_SERVER['PHP_SELF']; ?>';">    
		</form>
				<br>
			  </td>
			</tr>
		</table>
		
		
		
		<? include("search_cli_comercial.php"); ?>
		
		</form>


<? }?>
