<?
include('../sesion/sesion.php');
include("../conection/conectar.php");
include_once("../permite.php");
include_once("scripts/recover_nombre.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/admin_internas.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/main.js"></script>
<script type="text/javascript" src="../js/shadowbox-base.js"></script>
<script type="text/javascript" src="../js/shadowbox.js"></script>
<script type="text/javascript" src="../js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="../js/jquery-1.2.1.pack.js" ></script>
<script type="text/javascript" src="../js/funciones.js"></script>
<script type="text/javascript" src="../js/funcionesValida.js"></script>
<script type="text/javascript" src="../js/clients_list.js"></script>

<? include("../scripts/prepare_clients_list.php");?>
<? include('../scripts/scripts.php'); ?>

<script language="javascript">

function validaEnvia2(form)
{
	form.datosok.value="si";
	form.submit()
}

function showmed()
{
	$('div[@class=campos]').slideToggle("slow",function(){
		/*$('div[@class=campos]').slideUp("slow");*/
	});
}
</script>
<style type="text/css">
div.campos
{
	display:none;
}
.stilo
{
	font-family:Tahoma;
	font-size:11px;
}
</style>
<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "mensaje",
		theme : "advanced",
		plugins : "table, save, advhr, advimage, advlink,emotions, iespell,insertdatetime, preview, zoom, media, searchreplace, print, contextmenu, paste, directionality, fullscreen",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,insertdate, inserttime, preview, zoom, separator,forecolor,backcolor",
		theme_advanced_buttons2_add_before: "cut,copy,paste, pasteword, separator, separator",
		theme_advanced_buttons3_add_before : "tablecontrols, separator",
		theme_advanced_buttons3_add : "emotions, iespell, media, separator, ltr, rtl, separator",
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

	function fileBrowserCallBack(field_name, url, type, win) {
		// This is where you insert your custom filebrowser logic
		alert("Filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);

		// Insert new URL, this would normaly be done in a popup
		win.document.forms[0].elements[field_name].value = "someurl.htm";
	}
</script>

<?
$sql = "select * from clientes where idcliente in (select idcliente from clientes_tmp where idusuario='$_SESSION[numberid]') order by nombre";
//print $sql.'<br>';
$exe = mysqli_query($link,$sql);
while($datosc = mysqli_fetch_array($exe))
{
	?>
	<script type="text/javascript">
	function showmedc<? print $datosc['idcliente']; ?>()
	{
		$('div[@class=capac<? print $datosc['idcliente']; ?>]').slideToggle("slow",function(){
			<?
			$sql = "select * from clientes_tmp where idusuario='$_SESSION[numberid]' and idcliente!='$datosc[idcliente]'";
			//print $sql.'<br>';
			$exe2 = mysqli_query($link,$sql);
			while($datosc2 = mysqli_fetch_array($exe2))
			{
				?>
				$('div[@class=capac<? print $datosc2['idcliente']; ?>]').slideUp("slow");
				<?
			}
			?>
		});
	}
	</script>
	<style type="text/css">
	div.capac<? print $datosc['idcliente']; ?>
	{
		display:none;
	}
        </style>
 	<?
}

if($_POST["datosok"]=="si")
{
	require("../phpmailer/class.phpmailer.php");

	$subject = $_POST['asunto2'];

	$mail = new PHPMailer();
	$mail->IsSMTP();
	/*$mail->Host = "mail.civilnet.com.co";
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Username   = "soporte@civilnet.com.co";  // GMAIL username
	$mail->Password   = "cvn2009";            // GMAIL password

	$mail->From = "noreply@gatewaysolutions.com.co";
	$mail->FromName = 'Gateway Solutions'."\r\n";
	$mail->Sender = "soporte@civilnet.com.co";//return-path*/
	$mail->Timeout=1200;//20 minutos

//-----------------------------------------------------------------------
$mail->SMTPAuth   = true; //enable SMTP authentication
//$mail->SMTPSecure = "tls";
//$mail->Port = 587;

$mail->SMTPSecure = $secure;
$mail->Host = $host_envios;
$mail->Port = $port;
$mail->Username = $email_envios;
$mail->Password = $password_envios;

$mail->From = "$email_real";
$mail->FromName = 'Kigen'."\r\n";
$mail->Sender = "$email_real";//return-path
$mail->ConfirmReadingTo = "$email_real";
//-----------------------------------------------------------------------

	$mail->Subject = $subject;
	$mail->AltBody = " ";
	$mail->Body = $_POST['mensaje'];

	$sql = "select * from clientes where idcliente in (select idcliente from clientes_tmp where idusuario='$_SESSION[numberid]') order by nombre";
	$exe=mysqli_query($link,$sql);
	while($datoscl = mysqli_fetch_array($exe))
	{
		$sql = "select * from contactos_todos where idcliente='$datoscl[idcliente]' and estado='1'";
		$exec =mysqli_query($link,$sql);
		while($datosc = mysqli_fetch_array($exec))
		{
			if($_POST['contacto'.$datosc['idcontacto_todos'].'-'.$datoscl['idcliente']]!='')
			{
				$mail->AddAddress($datosc['correo'],"");
				$correos .= $datosc['correo'].', ';
				//$mail->Send();
				//$mail->ClearAddresses();
				//print 'correos '.$correos;
			}
		}

		if($_POST['adicionales'.$datoscl['idcliente']]!='')
		{
			$adicionales = explode(',', $_POST['adicionales'.$datoscl['idcliente']]);
			for($g=0; $g<count($adicionales); $g++)
			{
				$mail->AddAddress("$adicionales[$g]","");
				//$mail->Send();
				//$mail->ClearAddresses();
			}
		}

//---------------------------------------------------------------------------------------------------------------------
if(isset($_POST['seles'.$datoscl['idcliente']]) || isset($_POST['selesc'.$datoscl['idcliente']]))
{
	$msg = "
<table width='100%' align='center' border='0' cellpadding='0' cellspacing='0' style='font-size:15px;'>
	<tr>
		<td class='subtitseccion' style='text-align:center'><strong>RESUMEN SEGUIMIENTO SEMANAL</strong><br><br></td>
	</tr>
</table>
<br>
<table width='100%' align='center' border='1'  cellpadding='0' cellspacing='0' style='font-size:10px;'>
	<tr>
		<td bgcolor='#FF6600'><strong>ORDEN DEL CLIENTE</strong></td>
		<td bgcolor='#FF6600'><strong>ORDEN INTERNA</strong></td>
		<td bgcolor='#FF6600'><strong>REF</strong></td>
		<td bgcolor='#FF6600'><strong>PROVEEDOR</strong></td>
		<td bgcolor='#FF6600'><strong>MODALIDAD</strong></td>
		<td bgcolor='#FF6600'><strong>ORIGEN</strong></td>
		<td bgcolor='#FF6600'><strong>DESTINO</strong></td>
		<td bgcolor='#FF6600'><strong>TON/M3</strong></td>
		<td bgcolor='#FF6600'><strong>CONT</strong></td>
		<td bgcolor='#FF6600'><strong>MOTONAVE</strong></td>
		<td bgcolor='#FF6600'><strong>ETD</strong></td>
		<td bgcolor='#FF6600'><strong>ETA</strong></td>
		<td bgcolor='#FF6600'><strong>N&Uacute;MERO BL</strong></td>
		<td bgcolor='#FF6600'><strong>ESTADO ACTUAL DEL EMBARQUE</strong></td>
	</tr>";

	$estados = '';
	foreach($_POST['seles'.$datoscl['idcliente']] as $id)
	{
		if($id!='')
		{
			if($estados!='')
				$estados .= ',';
			$estados .= $id;

			$sql = "select * from estados where idestado='$id'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$datose = mysqli_fetch_array($exe);

			$re = '';
			/*if($datose['tipo']=='maritimo')
				$re = '';
			if($datose['tipo']=='terrestre')
				$re = 'terrestre';*/

			$sql = "select * from reporte_estado".$re." where idreporte_estado='$datose[idreporte_estado]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$datosre = mysqli_fetch_array($exe);

			if(substr($datosre['numshipping'], 0, 2)=='30' || substr($datosre['numshipping'], 0, 2)=='40')
				$sh = '';
			if(substr($datosre['numshipping'], 0, 2)=='50')
				$sh = '_terrestre';
			if(substr($datosre['numshipping'], 0, 2)=='70')
				$sh = '_otm';
			if(substr($datosre['numshipping'], 0, 2)=='80')
				$sh = '_seg';
			if(substr($datosre['numshipping'], 0, 2)=='60')
				$sh = '_adu';
			if(substr($datosre['numshipping'], 0, 2)=='90')
				$sh = '_bod';

			if($sh=='_terrestre')
				$idsh = 'idshipping'.$sh;
			else
				$idsh = 'idshipping_instruction'.$sh;

			$sql = "select * from shipping_instruction".$sh." where $idsh='$datosre[idshipping]' and numero='$datosre[numshipping]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$datosh = mysqli_fetch_array($exe);

			$sql = "select * from confirmacion_arribo where idshipping='$datosh[$idsh]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$datosca = mysqli_fetch_array($exe);

			$sql = "select * from cot_temp where idcot_temp='$datosh[idreporte]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$datos = mysqli_fetch_array($exe);

			if($sh=='')
			{
				if($datos['clasificacion'] == 'fcl' || $datos['clasificacion'] == 'lcl')
					$sql = "select * from tarifario where idtarifario='$datosh[idtarifario]'";
				if($datos['clasificacion'] == 'aereo')
					$sql = "select * from tarifario_aereo where idtarifario_aereo='$datosh[idtarifario]'";
			}
			if($sh=='_adu')
				$sql = "select * from aduana where idaduana in (select idaduana from cot_adu where idcot_adu='$datosh[idcot_adu]')";
			if($sh=='_bod')
				$sql = "select * from bodega where idbodega in (select idbodega from cot_bodegas where idcot_bodega='$datosh[idcot_bodega]')";
			if($sh=='_otm')
				$sql = "select * from otm where idotm in (select idotm from cot_otm where idcot_otm='$datosh[idcot_otm]')";
			if($sh=='_seg')
			if($sh=='_terrestre')
				$sql = "select * from terrestre where idterrestre in (select idterrestre from cot_terrestre where idcot_terrestre='$datosh[idcot_terrestre]')";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$datost =  mysqli_fetch_array($exe);

			$sql = "select * from hbl where idreporte='$datosh[idreporte]' and idtarifario='$datosh[idtarifario]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$datosbl = mysqli_fetch_array($exe);

			$cls = array('20', '40', '40hq');
			foreach($cls as $cl)
			{
				$sql = "select * from rn_fletes where idcot_fletes in (select idcot_fletes from cot_fletes where idcot_temp='$datosh[idreporte]' and idtarifario='$datosh[idtarifario]') and idtipo in (select idtipo from tipo where tipo='$cl') and idreporte='$datosh[idreporte]'";
				//print $sql.'<br>';
				$exe = mysqli_query($link,$sql);
				$datosr = mysqli_fetch_array($exe);

				$cantidad[$cl] = $datosr['cantidad'];
			}

			$sql = "select * from contenedores where idhbl='$datosbl[idhbl]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$volumen = 0;
			while($datosct = mysqli_fetch_array($exe))
			{
				$volumen += $datosct['measurement'];
			}

			$msg .= "<tr>
				<td>".$datosh['order_number']."</td>
				<td>".$datosh['numero']."</td>
				<td>".$datosre['ref']."</td>
				<td>";

				if($sh=='')
				{
					if($datos['clasificacion']=='aereo')
						$seleccionado = $datost['idaerolinea'];
					else
						$seleccionado = $datost['idnaviera'];
				}
				else
					$seleccionado = $datost['idproveedor'];
				$msg .=$datosr['name']; //scai_get_name("$seleccionado","proveedores_agentes", "idproveedor_agente", "nombre");

				$msg .= "</td>
				<td>";

				if($sh=='') $msg .= strtoupper($datos['clasificacion']);
				if($sh=='_adu') $msg .= 'Aduana';
				if($sh=='_bod') $msg .= 'Bodega';
				if($sh=='_otm') $msg .= 'OTM';
				if($sh=='_seg') $msg .= 'Seguro';
				if($sh=='_terrestre') $msg .= 'Carga nacionalizada';

				$msg .= "</td>
				<td>";

				if($sh=='')
				{
					if($datos['clasificacion']=='aereo')
						$seleccionado = $datost['aeropuerto_origen'];
					else
						$seleccionado = $datost['puerto_origen'];
				}
				if($sh=='_otm' || $sh=='_terrestre')
					$seleccionado = $datost['puerto_origen'];
				$msg .= scai_get_name("$seleccionado","aeropuertos_puertos", "idaeropuerto_puerto", "nombre");

				$msg .= "</td>
				<td >";

				if($sh=='')
				{
					if($datos['clasificacion']=='aereo')
						$seleccionado = $datost['aeropuerto_destino'];
					else
						$seleccionado = $datost['puerto_destino'];
				}
				if($sh=='_otm' || $sh=='_terrestre')
					$seleccionado = $datost['idciudad'];
				if (scai_get_name("$seleccionado","aeropuertos_puertos", "idaeropuerto_puerto", "nombre")=='BUENAVENTURA')
				$dest='BUN';
				else if (scai_get_name("$seleccionado","aeropuertos_puertos", "idaeropuerto_puerto", "nombre")=='CARTAGENA')
				$dest='CTG';
				else
				$dest=scai_get_name("$seleccionado","aeropuertos_puertos", "idaeropuerto_puerto", "nombre");
				$msg .= $dest;

				$msg .= "</td>
				<td class='contenidotab'>".$volumen."</td>
				<td class='contenidotab'>"; if($cantidad['20']!='') $msg .= $cantidad['20'].'X 20<br>'; if($cantidad['40']!='') $msg .= $cantidad['40'].'X 40<br>'; if($cantidad['40hq']!='') $msg .= $cantidad['40hq'].'X 40 HQ<br>'; $msg .= "</td>
				<td class='contenidotab'>"; if($datosbl['voy_no']!='') $msg .= $datosbl['voy_no']; else $msg .= 'X CONFIRMAR'; $msg .= "</td>
				<td class='contenidotab'>"; if($datosca['fecha_arribo']!='' && $datosca['fecha_arribo']!='0000-00-00') $msg .= $datosca['fecha_arribo']; else $msg .= $datosre['etd']; $msg .= "</td>
				<td class='contenidotab'>".$datosre['eta']."</td>
				<td class='contenidotab'>".scai_get_name("$datosh[idreporte]","hbl", "idreporte", "numero")."</td>
				<td class='contenidotab'>".htmlentities($datose['descripcion'])."</td>
			</tr>";
		}
	}
	//Comercial---------------------------------------------------------------------------------------

	$estadosc = '';
	foreach($_POST['selesc'.$datoscl['idcliente']] as $id)
	{
		if($id!='')
		{
			if($estadosc!='')
				$estadosc .= ',';
			$estadosc .= $id;

			$sql = "select * from estados_cli where idestado='$id'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$datosec = mysqli_fetch_array($exe);

			$sql = "select * from reporte_estado_cli where idreporte_estado in (select idreporte_estado from estados_cli where idestado='$id')";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$datosrec = mysqli_fetch_array($exe);
			if(scai_get_name("$datosrec[puerto_destino]","aeropuertos_puertos", "idaeropuerto_puerto", "nombre")=='BUENAVENTURA')
			$dest='BUN';
			else if(scai_get_name("$datosrec[puerto_destino]","aeropuertos_puertos", "idaeropuerto_puerto", "nombre")=='CARTAGENA')
			$dest='CTG';
			else
			$dest=scai_get_name("$datosrec[puerto_destino]","aeropuertos_puertos", "idaeropuerto_puerto", "nombre");
			$msg .= "<tr>
				<td class='contenidotab'>".$datosrec['number']."</td>
				<td class='contenidotab'>&nbsp;</td>
				<td class='contenidotab'>".$datosrec['ref']."</td>
				<td class='contenidotab'>".$datosrec['shipper']."</td>
				<td class='contenidotab'>".strtoupper($datosrec['clasificacion'])."</td>
				<td class='contenidotab'>".scai_get_name("$datosrec[puerto_origen]","aeropuertos_puertos", "idaeropuerto_puerto", "nombre")."</td>
				<td class='contenidotab'>".$dest."</td>
				<td class='contenidotab'>". $datosrec['volumen']."</td>
				<td class='contenidotab'>"; if($datosrec['n20']!='') $msg .= $datosrec['n20'].'X 20<br>'; if($datosrec['n40']!='') $msg .= $datosrec['n40'].'X 40<br>'; if($datosrec['n40hq']!='') $msg .= $datosrec['n40hq'].'X 40 HQ<br>'; $msg .= "</td>
				<td class='contenidotab'>".$datosrec['motonave']."</td>
				<td class='contenidotab'>".$datosrec['etd']."</td>
				<td class='contenidotab'>".$datosrec['eta']."</td>
				<td class='contenidotab'>".$datosrec['hbl']."</td>
				<td class='contenidotab'>".htmlentities($datosec['descripcion'])."</td>
			</tr>";
		}
	}
	$msg .= "</table><br>";
	$msg .= "<table width='100%' align='center'>
	<tr>
		<td class='contenidotab'>Agradezco su amable atenci&oacute;n  y cualquier inquietud al respecto, con gusto la atenderemos.<br /><br />
		Cordialmente,<br />";

		$idusuario = $_SESSION['numberid'];
		$sql_sign="select * from usuarios where idusuario='$idusuario'";
		$exe_sql_sign=mysqli_query($link,$sql_sign);
		$row_exe_sql_sign=mysqli_fetch_array($exe_sql_sign);

		$sql_sign2 = "select * from vendedores_customer where idusuario='$row_exe_sql_sign[idusuario]'";
		//print $sql_sign2.'<br>';
		$exe_sql_sign2=mysqli_query($link,$sql_sign2);
		$row_exe_sql_sign2=mysqli_fetch_array($exe_sql_sign2);

		//print '<br><br>'.$row_exe_sql_sign['nombre']." ".$row_exe_sql_sign['apellido'];
		$msg .= '<br><br>'.$row_exe_sql_sign2['nombre'];
		$msg .= '<strong><br>'.scai_get_name("$row_exe_sql_sign2[idcargo]","cargos","idcargo","nombre").'</strong>';
		$msg .= '<br>Address: '.$row_exe_sql_sign2['direccion'];
		$msg .= '<br>Phone: '.$row_exe_sql_sign2['telefono'];
		$msg .= '<br>Movil: '.$row_exe_sql_sign2['celular'];
		//$msg .= '<br>USA Phone: '.$row_exe_sql_sign2['telefono'];
		$msg .= '<br>E-mail: '.$row_exe_sql_sign2['email'];

		$sqlpm = "select * from parametros where idparametro='32'";
		$exepm = mysqli_query($link,$sqlpm);
		$cond = mysqli_fetch_array($exepm);
		$msg .= '<br>Web site: '.$cond['valor'];
		$msg .= "</td>
	</tr>
	</table>";
//logo---------------------------------------------------------------------------------------------------------------------------
$logo = "<table width='100%' align='center'>
	<tr>
		<td align='left'><img src='".scai_get_name("url_logo","parametros","nombre","valor")."' border='0' width='198' height='60' /></td>
	</tr>
</table>";
$msg = $logo.$msg;
}
//---------------------------------------------------------------------------------------------------------------------
		$mail->Body = $msg;

		if(isset($_POST['seles'.$datoscl['idcliente']]) || isset($_POST['selesc'.$datoscl['idcliente']]))
		{
			//print $msg;
			if($mail->Send())
			{
				//$mail->ClearAddresses();
				?><script>alert('El mensaje para <? print $datoscl['nombre'] ?> ha sido enviado');</script><?

				$sql = "insert into enviados_seguimientos_cli(idcliente, idusuario, emails, adicionales, adjuntos, asunto, contenido, fecha, estados, estados_cli) VALUES ('$datoscl[idcliente]', '$_SESSION[numberid]', '$correos', '$_POST[adicionales]', 'adjuntos', '$subject', '$msg', NOW(), '$estados', '$estadosc')";
				//print $sql.'<br>';
				$exei = mysqli_query($link,$sql);
			}
			else
			{
				//$mail->ClearAddresses();
				?><script>alert('El mensaje para <? print $datoscl['nombre'] ?> no pudo ser enviado');</script><?
			}
		}
		$mail->ClearAddresses();
	}
}
?>

<link href="Forms.css" rel="stylesheet" type="text/css" />
<form enctype="multipart/form-data" name="formulario" method="post" action="">
<input name="datosok" type="hidden" value="no" />
<input type="hidden" id="msg" name="msg" value="<? print str_replace("\\", "",$_POST['msg']); ?>">
<input type="hidden" id="asunto" name="asunto" value="<? print $_POST['asunto']; ?>">
<input type="hidden" id="shipment_id" name="shipment_id" value="<? print $_POST['shipment_id']; ?>">
<input type="hidden" id="fuente" name="fuente" value="<? print $_POST['fuente']; ?>">
<input type="hidden" id="idshipping" name="idshipping" value="<? print $_POST['idshipping']; ?>">

<table width="100%" align="center">
	<tr>
<!-- 		<td class="subtitseccion" style="text-align:center"><strong>RESUMEN SEGUIMIENTO SEMANAL</strong><br><br></td> -->
	</tr>
	<tr>
		<td class="contenidotab" style="text-align:center">
			Asunto: <input type="text" value="<? print "RESUMEN DE SEGUIMIENTOS"; ?>" maxlength="300" id="asunto2" name="asunto2" size="50">
		</td>
	</tr>
</table>

<?
$sql = "select * from clientes where idcliente in (select idcliente from clientes_tmp where idusuario='$_SESSION[numberid]') order by nombre";
//print $sql.'<br>';
$execli = mysqli_query($link,$sql);
while($datosc = mysqli_fetch_array($execli))
{
	?>
	<table width="100%" align="center">
	<tr bgcolor="#FEEFCF">
    	<td align="center" class="subtitseccion" style="text-align:left" colspan="4"><a href="javascript:void(0);" class="subtitseccion" onClick="showmedc<? print $datosc['idcliente']; ?>()"><img src="../images/up.png" border="0"/><? print $datosc['nombre']; ?> </a></td>
	</tr>
	</table>
	<div class="capac<? print $datosc['idcliente']; ?>">
	<table align="center">
		<tr>
			<td class="contenidotab" style="text-align:center">
				<strong>Contactos </strong>
				<table align="center">
				<?
				$sql = "select * from clientes where estado='1' and idcliente='$datosc[idcliente]'";
				$sql .= " order by nombre";
				//print $sql.'<br>';
				$exec1=mysqli_query($link,$sql);
				while($datos = mysqli_fetch_array($exec1))
				{
					$sql = "select * from contactos_todos where idcliente='$datos[idcliente]' and estado='1'";
					$exec2 =mysqli_query($link,$sql);
					while($datosc2 = mysqli_fetch_array($exec2))
					{
					?>
					<tr>
						<td class="contenidotab"><input type="checkbox" id="contacto<? print $datosc2['idcontacto_todos'].'-'.$datosc['idcliente']; ?>" name="contacto<? print $datosc2['idcontacto_todos'].'-'.$datosc['idcliente']; ?>"></td>
						<td class="contenidotab"><? print $datosc2['nombre']; ?></td>
						<td class="contenidotab"><? print $datosc2['correo']; ?></td>
					</tr>
					<?
					}
				}
				?>
				</table>
				<br>
			</td>
		</tr>
		<tr>
			<td class="contenidotab" style="text-align:center">
				Correos adicionales (separados por coma): <input type="text" value="" maxlength="300" id="adicionales<? print $datosc['idcliente']; ?>" name="adicionales<? print $datosc['idcliente']; ?>" size="50">
			</td>
		</tr>
		<!--<tr>
			<td class="contenidotab" style="text-align:center" align="center">
				<textarea name="mensaje<? print $datosc['idcliente']; ?>" id="mensaje<? print $datosc['idcliente']; ?>" style="height : 350px; width : 750px;"><? print str_replace("\'",'"',$_POST['msg']); ?></textarea>
			</td>
		</tr>-->
		<tr>
		<td class="contenidotab" style="text-align:center" align="center">
		<table width="100%" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td class="tittabla">ENVIAR</td>
				<td class="tittabla">ORDEN DEL CLIENTE</td>
				<td class="tittabla">ORDEN INTERNA</td>
				<td class="tittabla">REF</td>
				<td class="tittabla">FECHA - HORA</td>
				<td class="tittabla">PROVEEDOR</td>
				<td class="tittabla">MODALIDAD</td>
				<td class="tittabla">ORIGEN</td>
				<td class="tittabla">DESTINO</td>
				<td class="tittabla">TON/M3</td>
				<td class="tittabla">CONT</td>
				<td class="tittabla">MOTONAVE</td>
				<td class="tittabla">ETD</td>
				<td class="tittabla">ETA</td>
				<td class="tittabla">N&Uacute;MERO BL</td>
				<td class="tittabla">ESTADO ACTUAL DEL EMBARQUE</td>
			</tr>
		<?
		$shippings = array('', '_adu', '_bod', '_otm', '_seg', '_terrestre');
		foreach($shippings as $sh)
		{
			$re = '';
			if($sh=='_otm' || $sh=='_terrestre')
			{
				$tipo = 'terrestre';
				//$re = '_terrestre';
			}
			else
			{
				$tipo = 'maritimo';
				//$re = '';
			}

			if($sh=='_terrestre')
				$idsh = 'idshipping'.$sh;
			else
				$idsh = 'idshipping_instruction'.$sh;

			/*$maxf = $maxh = '';

			$sql = "select idestado from estados where fecha IN (SELECT MAX(fecha) FROM estados GROUP BY idreporte_estado) GROUP BY idreporte_estado";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			while($datose = mysqli_fetch_array($exe))
			{
				if($maxf!='')
					$maxf .= ',';
				$maxf .= $datose['idestado'];
			}

			if($maxf!='')
			{
				$sql = "select idestado from estados where hora IN (SELECT MAX(hora) FROM estados where idestado in ($maxf) GROUP BY idreporte_estado) GROUP BY idreporte_estado";
				//print $sql.'<br>';
				$exe = mysqli_query($link,$sql);
				while($datose = mysqli_fetch_array($exe))
				{
					if($maxh!='')
						$maxh .= ',';
					$maxh .= $datose['idestado'];
				}
			}*/

			$sql = "select idestado from estados, reporte_estado".$re.", shipping_instruction".$sh.", cot_temp where  estados.idreporte_estado=reporte_estado".$re.".idreporte_estado and reporte_estado".$re.".idshipping=shipping_instruction".$sh.".$idsh and reporte_estado".$re.".numshipping=shipping_instruction".$sh.".numero and shipping_instruction".$sh.".idreporte=cot_temp.idcot_temp and cot_temp.idcliente='$datosc[idcliente]' and tipo='$tipo' and CONCAT(fecha,hora) in (select MAX(CONCAT(fecha,hora)) FROM estados GROUP BY idreporte_estado) and reporte_estado".$re.".deshabilitar='0' GROUP BY estados.idreporte_estado";

			/*if($maxh!='')
				$sql .= " and idestado in ($maxh)";*/

			$sql .= " order by fecha desc, hora desc";
			//print $sql.'<br>';
			$exee = mysqli_query($link,$sql);

			while($datose = mysqli_fetch_array($exee))
			{
				$sql = "select * from estados where idestado='$datose[idestado]'";
				//print $sql.'<br>';
				$exe = mysqli_query($link,$sql);
				$datose = mysqli_fetch_array($exe);

				$sql = "select * from reporte_estado".$re." where idreporte_estado='$datose[idreporte_estado]'";
				//print $sql.'<br>';
				$exe = mysqli_query($link,$sql);
				$datosre = mysqli_fetch_array($exe);

				$sql = "select * from shipping_instruction".$sh." where $idsh='$datosre[idshipping]' and numero='$datosre[numshipping]'";
				//print $sql.'<br>';
				$exe = mysqli_query($link,$sql);
				$datosh = mysqli_fetch_array($exe);

				$sql = "select * from confirmacion_arribo where idshipping='$datosh[$idsh]'";
				//print $sql.'<br>';
				$exe = mysqli_query($link,$sql);
				$datosca = mysqli_fetch_array($exe);

				$sql = "select * from cot_temp where idcot_temp='$datosh[idreporte]'";
				//print $sql.'<br>';
				$exe = mysqli_query($link,$sql);
				$datos = mysqli_fetch_array($exe);

				if($sh=='')
				{
					if($datos['clasificacion'] == 'fcl' || $datos['clasificacion'] == 'lcl')
						$sql = "select * from tarifario where idtarifario='$datosh[idtarifario]'";
					if($datos['clasificacion'] == 'aereo')
						$sql = "select * from tarifario_aereo where idtarifario_aereo='$datosh[idtarifario]'";
				}
				if($sh=='_adu')
					$sql = "select * from aduana where idaduana in (select idaduana from cot_adu where idcot_adu='$datosh[idcot_adu]')";
				if($sh=='_bod')
					$sql = "select * from bodega where idbodega in (select idbodega from cot_bodegas where idcot_bodega='$datosh[idcot_bodega]')";
				if($sh=='_otm')
					$sql = "select * from otm where idotm in (select idotm from cot_otm where idcot_otm='$datosh[idcot_otm]')";
				if($sh=='_seg')
				if($sh=='_terrestre')
					$sql = "select * from terrestre where idterrestre in (select idterrestre from cot_terrestre where idcot_terrestre='$datosh[idcot_terrestre]')";
				//print $sql.'<br>';
				$exe = mysqli_query($link,$sql);
				$datost =  mysqli_fetch_array($exe);

				$sql = "select * from hbl where idreporte='$datosh[idreporte]' and idtarifario='$datosh[idtarifario]'";
				//print $sql.'<br>';
				$exe = mysqli_query($link,$sql);
				$datosbl = mysqli_fetch_array($exe);

				$cls = array('20', '40', '40hq');
				foreach($cls as $cl)
				{
					$sql = "select * from rn_fletes where idcot_fletes in (select idcot_fletes from cot_fletes where idcot_temp='$datosh[idreporte]' and idtarifario='$datosh[idtarifario]') and idtipo in (select idtipo from tipo where tipo='$cl') and idreporte='$datosh[idreporte]'";
					//print $sql.'<br>';
					$exe = mysqli_query($link,$sql);
					$datosr = mysqli_fetch_array($exe);

					$cantidad[$cl] = $datosr['cantidad'];
				}

				$sql = "select * from contenedores where idhbl='$datosbl[idhbl]'";
				//print $sql.'<br>';
				$exe = mysqli_query($link,$sql);
				$volumen = 0;
				while($datosct = mysqli_fetch_array($exe))
				{
					$volumen += $datosct['measurement'];
				}
				?>
				<tr>
					<td class="contenidotab"><input type="checkbox" id="seles<? print $datosc['idcliente']; ?>" name="seles<? print $datosc['idcliente']; ?>[]" onClick="" value="<? print $datose['idestado']; ?>" checked/></td>
					<td class="contenidotab"><? print $datosh['order_number']; ?></td>
					<td class="contenidotab"><? print $datosh['numero']; ?></td>
					<td class="contenidotab"><? print $datosre['ref']; ?></td>
					<td class="contenidotab"><? print $datose['fecha'].' - '.$datose['hora']; ?></td>
					<td class="contenidotab">
					<?
					if($sh=='')
					{
						if($datos['clasificacion']=='aereo')
							$seleccionado = $datost['idaerolinea'];
						else
							$seleccionado = $datost['idnaviera'];
					}
					else
						$seleccionado = $datost['idproveedor'];
					//print scai_get_name("$seleccionado","proveedores_agentes", "idproveedor_agente", "nombre");
					print $datosr['name'];
					?>
					</td>
					<td class="contenidotab">
					<?
					if($sh=='') print strtoupper($datos['clasificacion']);
					if($sh=='_adu') print 'Aduana';
					if($sh=='_bod') print 'Bodega';
					if($sh=='_otm') print 'OTM';
					if($sh=='_seg') print 'Seguro';
					if($sh=='_terrestre') print 'Carga nacionalizada';
					?>
					</td>
					<td class="contenidotab">
					<?
					if($sh=='')
					{
						if($datos['clasificacion']=='aereo')
							$seleccionado = $datost['aeropuerto_origen'];
						else
							$seleccionado = $datost['puerto_origen'];
					}
					if($sh=='_otm' || $sh=='_terrestre')
						$seleccionado = $datost['puerto_origen'];

					print scai_get_name("$seleccionado","aeropuertos_puertos", "idaeropuerto_puerto", "nombre");
					?>
					</td>
					<td class="contenidotab">
					<?
					if($sh=='')
					{
						if($datos['clasificacion']=='aereo')
							$seleccionado = $datost['aeropuerto_destino'];
						else
							$seleccionado = $datost['puerto_destino'];
					}
					if($sh=='_otm' || $sh=='_terrestre')
						$seleccionado = $datost['idciudad'];
					if(scai_get_name("$seleccionado","aeropuertos_puertos", "idaeropuerto_puerto", "nombre")=='BUENAVENTURA')
					$dest='BUN';
					else if(scai_get_name("$seleccionado","aeropuertos_puertos", "idaeropuerto_puerto", "nombre")=='CARTAGENA')
					$dest='CTG';
					else
					$dest= scai_get_name("$seleccionado","aeropuertos_puertos", "idaeropuerto_puerto", "nombre");

					print $dest;
					//print $datosre['shipper'];
					?>
					</td>
					<td class="contenidotab"><? print $volumen; ?></td>
					<td class="contenidotab"><? if($cantidad['20']!='') print $cantidad['20'].'X 20<br>'; if($cantidad['40']!='') print $cantidad['40'].'X 40<br>'; if($cantidad['40hq']!='') print $cantidad['40hq'].'X 40 HQ<br>'; ?></td>
					<td class="contenidotab"><? if($datosbl['voy_no']!='') print $datosbl['voy_no']; else print 'X CONFIRMAR'; ?></td>
					<td class="contenidotab"><? if($datosca['fecha_arribo']!='' && $datosca['fecha_arribo']!='0000-00-00') print $datosca['fecha_arribo']; else print $datosre['etd']; ?></td>
					<td class="contenidotab"><? print $datosre['eta']; ?></td>
					<td class="contenidotab"><? print scai_get_name("$datosh[idreporte]","hbl", "idreporte", "numero"); ?></td>
					<td class="contenidotab"><? print htmlentities($datose['descripcion']); ?></td>
				</tr>
				<?
			}
		}
		//Comercial---------------------------------------------------------------------------------------

		$sql = "select * from reporte_estado_cli where idcliente='$datosc[idcliente]' and idreporte_estado not in (select distinct idreporte_estado from estados_cli where idestado in (select distinct idestado_cli from estados)) and deshabilitar='0'";
		//print $sql.'<br>';
		$exe = mysqli_query($link,$sql);

		while($datosrec = mysqli_fetch_array($exe))
		{
			$sql = "select * from estados_cli where idreporte_estado='$datosrec[idreporte_estado]' and CONCAT(fecha,hora) in (select MAX(CONCAT(fecha,hora)) FROM estados_cli where idreporte_estado='$datosrec[idreporte_estado]') order by fecha desc, hora desc";
			//print $sql.'<br>';
			$exec = mysqli_query($link,$sql);
			$filas = mysqli_num_rows($exec);
			$datosec = mysqli_fetch_array($exec);
			if($filas > 0)
			{
				?>
				<tr>
					<td class="contenidotab"><input type="checkbox" id="selesc<? print $datosc['idcliente']; ?>" name="selesc<? print $datosc['idcliente']; ?>[]" onClick="" value="<? print $datosec['idestado']; ?>" checked/></td>
					<td class="contenidotab"><? print $datosrec['number']; ?></td>
					<td class="contenidotab">&nbsp;</td>
					<td class="contenidotab"><? print $datosrec['ref']; ?></td>
					<td class="contenidotab"><? print $datosec['fecha'].' - '.$datosec['hora']; ?></td>
					<td class="contenidotab"><? print $datosrec['shipper']; ?></td>
					<td class="contenidotab"><? print strtoupper($datosrec['clasificacion']); ?></td>
					<td class="contenidotab"><? print scai_get_name("$datosrec[puerto_origen]","aeropuertos_puertos", "idaeropuerto_puerto", "nombre"); ?></td>
					<td class="contenidotab"><?
					if(scai_get_name("$datosrec[puerto_destino]","aeropuertos_puertos", "idaeropuerto_puerto", "nombre")=='BUENAVENTURA')
					print 'BUN';
					else if(scai_get_name("$datosrec[puerto_destino]","aeropuertos_puertos", "idaeropuerto_puerto", "nombre")=='CARTAGENA')
					print 'CTG';
					else
					scai_get_name("$datosrec[puerto_destino]","aeropuertos_puertos", "idaeropuerto_puerto", "nombre"); ?></td>
					<td class="contenidotab"><? print $datosrec['volumen']; ?></td>
					<td class="contenidotab"><? if($datosrec['n20']!='') print $datosrec['n20'].'X 20<br>'; if($datosrec['	n40']!='') print $datosrec['n40'].'X 40<br>'; if($datosrec['n40hq']!='') print $datosrec['n40hq'].'X 40 HQ<br>'; ?></td>
					<td class="contenidotab"><? print $datosrec['motonave']; ?></td>
					<td class="contenidotab"><? print $datosrec['etd']; ?></td>
					<td class="contenidotab"><? print $datosrec['eta']; ?></td>
					<td class="contenidotab"><? print $datosrec['hbl']; ?></td>
					<td class="contenidotab"><? print htmlentities($datosec['descripcion']); ?></td>
				</tr>
				<?
			}
		}
		?>
		</table>
		</td>
		</tr>
	</table>
	</div>
	<?
}
?>
<table width="100%" align="center">
	<tr>
    	<td class="contenidotab">Agradezco su amable atenci&oacute;n  y cualquier inquietud al respecto, con gusto la atenderemos.<br /><br />
        Cordialmente,<br />
        <?
	$idusuario = $_SESSION['numberid'];
	$sql_sign="select * from usuarios where idusuario='$idusuario'";
	$exe_sql_sign=mysqli_query($link,$sql_sign);
	$row_exe_sql_sign=mysqli_fetch_array($exe_sql_sign);

	$sql_sign2 = "select * from vendedores_customer where idusuario='$row_exe_sql_sign[idusuario]'";
	//print $sql_sign2.'<br>';
	$exe_sql_sign2=mysqli_query($link,$sql_sign2);
	$row_exe_sql_sign2=mysqli_fetch_array($exe_sql_sign2);

	//print '<br><br>'.$row_exe_sql_sign['nombre']." ".$row_exe_sql_sign['apellido'];
	print '<br><br>'.$row_exe_sql_sign2['nombre'];
	print '<strong><br>'.scai_get_name("$row_exe_sql_sign2[idcargo]","cargos","idcargo","nombre").'</strong>';
	print '<br>Address: '.$row_exe_sql_sign2['direccion'];
	print '<br>Phone: '.$row_exe_sql_sign2['telefono'];
	print '<br>Movil: '.$row_exe_sql_sign2['celular'];
	//print '<br>USA Phone: '.$row_exe_sql_sign2['telefono'];
	print '<br>E-mail: '.$row_exe_sql_sign2['email'];

	$sqlpm = "select * from parametros where idparametro='32'";
	//print $sqlpm.'<br>';
	$exepm = mysqli_query($link,$sqlpm);
	$cond = mysqli_fetch_array($exepm);
	print '<br>Web site: '.$cond['valor'];
	?>
        </td>
    </tr>
</table>
<br />
<table width="100%" align="center">
	<tr>
		<td align="center">
			<input type="button" value="Atras" name="atras" id="atras" class="botonesadmin" style="color:#FFFFFF" onClick="document.location = 'resumen_clientes.php'">
			<input type="button" value="Enviar" name="enviar" id="enviar" class="botonesadmin" style="color:#FFFFFF" onClick="validaEnvia2(formulario); this.disabled=true; this.value='Enviando, por favor espere...'">
		</td>
	</tr>
</table>
</form>
