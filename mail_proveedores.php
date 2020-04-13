<?
include('sesion/sesion.php');
include("conection/conectar.php");
include_once("permite.php");
include_once("scripts/recover_nombre.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/admin_internas.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/main.js"></script>
<script type="text/javascript" src="./js/shadowbox-base.js"></script>
<script type="text/javascript" src="./js/shadowbox.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.1.pack.js" ></script>
<script type="text/javascript" src="./js/funciones.js"></script>
<script type="text/javascript" src="./js/funcionesValida.js"></script>
<script type="text/javascript" src="js/clients_list.js"></script>

<? include("scripts/prepare_clients_list.php");?>
<? include('scripts/scripts.php'); ?>

<script language="javascript">
	function validaEnviat(form, tipo)
	{
		if (validarSelec('tipo', 'Seleccine el tipo') == false) return false;
		form.action='<? print $_SERVER['PHP_SELF'];?>?tipo='+tipo;
		form.submit();
	}
	function validaEnviap(form, tipo, proveedor, cliente)
	{
		//if (validarSelec('proveedor', 'Seleccione el proveedor') == false) return false;
		//if (validarSelec('cliente', 'Seleccione el cliente') == false) return false;

		form.action='<? print $_SERVER['PHP_SELF'];?>?tipo='+tipo+'&proveedor='+proveedor + '&cliente='+cliente;
		form.submit();
	}

	function validaEnvia2(form, tipo, proveedor)
	{
		//alert ('validaEnvia2 ' + 'tipo ' + tipo + ' proveedor ' + proveedor);
		form.action='<? print $_SERVER['PHP_SELF'];?>?tipo='+tipo+'&proveedor='+proveedor;
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
if($_POST["datosok"]=="si")
{
	require("phpmailer/class.phpmailer.php");

	$subject = $_POST['asunto'];
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

//$mail->SMTPDebug  = 2;

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

	$_POST['mensaje'] = str_replace('\\', '',$_POST['mensaje']);
//logo---------------------------------------------------------------------------------------------------------------------------
$logo = "<table width='100%' align='center'>
	<tr>
		<td align='left'><img src='".scai_get_name("url_logo","parametros","nombre","valor")."' border='0' width='198' height='60' /></td>
	</tr>
</table>";
$_POST['mensaje'] = $logo.$_POST['mensaje'];

	$mail->Body = $_POST['mensaje'];

	$sql = "select * from adjuntos_proveedores where idproveedor='$_GET[proveedor]' and estado='1'";
	//print $sql.;
	$exe=mysqli_query($link,$sql);
	while($datosa = mysqli_fetch_array($exe))
	{
		if($_POST['adjunto'.$datosa['idadjunto']]!='')
        {
			$mail->AddAttachment("adjuntos_proveedores/$datosa[nombre]", "$datosa[nombre]");
			$adjuntos .= $adjuntos[$g].', ';//concatena para guardarlos en la tabla y luego mostrarlos
			//print 'adjuntos '.$adjuntos;
        }
	}

	$sql = "select * from clientes where estado='1'";
	$exe=mysqli_query($link,$sql);
	while($datos = mysqli_fetch_array($exe))
	{
		$sql = "select * from contactos_todos where idcliente='$datos[idcliente]' and estado='1'";
		$exec =mysqli_query($link,$sql);
		while($datosc = mysqli_fetch_array($exec))
		{
			if($_POST['contacto'.$datosc['idcontacto_todos']]!='')
			{
				$mail->AddAddress($datosc['correo'],"");
				$correos .= $datosc['correo'].', ';
				$mail->Send();
				$mail->ClearAddresses();
				//print 'correos '.$correos;
			}
		}
	}

	if($_POST['adicionales']!='')
	{
		$adicionales = explode(',', $_POST['adicionales']);
		for($g=0; $g<count($adicionales); $g++)
		{
			$mail->AddAddress("$adicionales[$g]","");
			//$correos .= $adicionales[$g].', ';
			$mail->Send();
			$mail->ClearAddresses();
			//print 'correos '.$correos.;
		}
	}
	$orig = array("“", "”", "'"); //caracteres que busco
	$reem = array("&ldquo;", "&rdquo;", "&apos;"); // caracter con los que reemplazo
	for ($f=0; $f<count($orig); $f++)
		$_POST['mensaje'] = str_replace($orig[$f], $reem[$f], $_POST['mensaje']);

	$sql = "insert into enviados_proveedores(idproveedor, idusuario, emails, adicionales, adjuntos, asunto, contenido, fecha) VALUES ('$_GET[idproveedor]', '$_SESSION[numberid]', '$correos', '$_POST[adicionales]', 'adjuntos', '$subject', '$_POST[mensaje]', NOW())";
	//print $sql.'<br>';
	$exe = mysqli_query($link,$sql);
}
?>
<html>
<body bgcolor="#FFFFFF">
<link href="Forms.css" rel="stylesheet" type="text/css" />
<form enctype="multipart/form-data" name="formulario" method="post" action="">
<input name="datosok" type="hidden" value="no" />
<table align="center" width="100%">
	<tr>
		<td class="contenidotab" style="text-align:center">
            Seleccione tipo
            <select name="tipo" id="tipo" onChange="validaEnviat(formulario, this.value)" >
                <option value="N">Seleccione</option>
                <? $tipo=$_GET['tipo']; ?>
                <option value="aerolinea" <? if($tipo=='aerolinea') print 'selected' ?>>aerolinea</option>
                <option value="coloader" <? if($tipo=='coloader') print 'selected' ?>>coloader</option>
                <option value="aduana" <? if($tipo=='aduana') print 'selected' ?>>aduana</option>
                <option value="naviera" <? if($tipo=='naviera') print 'selected' ?>>naviera</option>
                <option value="otm" <? if($tipo=='otm') print 'selected' ?>>otm</option>
                <option value="bodega" <? if($tipo=='bodega') print 'selected' ?>>bodega</option>
                <option value="seguro" <? if($tipo=='seguro') print 'selected' ?>>seguro</option>
                <option value="agente" <? if($tipo=='agente') print 'selected' ?>>agente</option>
                <option value="administrativo" <? if($tipo=='administrativo') print 'selected' ?>>administrativo</option>
                <option value="financiero" <? if($tipo=='financiero') print 'selected' ?>>financiero</option>
            </select>
		</td>
	</tr>
    <?
    if($tipo!="")
	{
		?>
        <tr>
            <td class="contenidotab" style="text-align:center">
            Seleccione proveedor
            <select name="proveedor" id="proveedor" onChange="validaEnviap(formulario, '<? print $tipo; ?>', this.value, '<? print $_GET['cliente']; ?>')" >
                <option value="N">Seleccione</option>
                <?
                $proveedor=$_GET['proveedor'];
                $uno="select * from proveedores_agentes where estado='1' and tipo='$tipo'";
                $jota=mysqli_query($link,$uno);
                while($ache=mysqli_fetch_array($jota))
                {
					if($ache['idproveedor_agente']=="$proveedor")
						print "<option value='$ache[idproveedor_agente]' selected>$ache[nombre]</option>";
					else
						print "<option value='$ache[idproveedor_agente]'>$ache[nombre]</option>";
                }
                ?>
            </select>
            </td>
        </tr>
        <tr>
            <td class="contenidotab" style="text-align:center">
            Seleccione cliente
            <select name="cliente" id="cliente" onChange="validaEnviap(formulario, '<? print $tipo; ?>', '<? print $_GET['proveedor']; ?>', this.value)" >
                <option value="N">Seleccione</option>
                <?
                $cliente=$_GET['cliente'];
                $uno="select * from clientes where estado='1' order by nombre";
                $jota=mysqli_query($link,$uno);
                while($ache=mysqli_fetch_array($jota))
                {
					if($ache['idcliente']=="$cliente")
						print "<option value='$ache[idcliente]' selected>$ache[nombre]</option>";
					else
						print "<option value='$ache[idcliente]'>$ache[nombre]</option>";
                }
                ?>
            </select>
            </td>
        </tr>
        <?
	}
	?>
</table>
<?
if($proveedor!='' && $proveedor!='N' && $cliente!='' && $cliente!='N')
{
	?>
	<table align="center" width="80%">
		<?
		$sql = "select * from adjuntos_proveedores where idproveedor='$_GET[proveedor]' and estado='1'";
		//print $sql.'<br>';
		$exe=mysqli_query($link,$sql);
		while($datosa = mysqli_fetch_array($exe))
		{
			?>
            <tr>
                <td class="contenidotab"><input type="checkbox" id="adjunto<? print $datosa['idadjunto']; ?>" name="adjunto<? print $datosa['idadjunto']; ?>" value="<? print $datosa['idadjunto']; ?>"></td>
                <td class="contenidotab" nowrap><? print $datosa['nombre'].' - '.$datosa['fecha_creacion']  ; ?></td>
                <td class="contenidotab"><? print $datosa['descripcion'] ; ?></td>
            </tr>
        	<?
		}
		?>
		</table>
        <br>
        <table align="center">
            <tr>
                <td class="contenidotab" style="text-align:center">
                <a href="javascript:void(0);" onClick="showmed()"><img src="images/up.png" width="13" height="8" border="0">&nbsp;Listar contactos<img src="images/up.png" width="13" height="8" border="0"></a>
                <div class="campos">
                <table align="center">
                <?
                $sql = "select * from clientes where estado='1'";
				if($cliente!='' && $cliente!='N')
					$sql .= " and idcliente='$cliente'";
				$sql .= " order by nombre";
				//print $sql.'<br>';
                $exe=mysqli_query($link,$sql);
                while($datos = mysqli_fetch_array($exe))
                {
                    $sql = "select * from contactos_todos where idcliente='$datos[idcliente]' and estado='1'";
                    $exec =mysqli_query($link,$sql);
                    while($datosc = mysqli_fetch_array($exec))
                    {
                    ?>
                    <tr>
                        <td class="contenidotab"><input type="checkbox" id="contacto<? print $datosc['idcontacto_todos']; ?>" name="contacto<? print $datosc['idcontacto_todos']; ?>"></td>
                        <!--<td class="contenidotab"><? print $datos['nombre']; ?></td>-->
                        <td class="contenidotab"><? print $datosc['nombre']; ?></td>
                        <td class="contenidotab"><? print $datosc['correo']; ?></td>
                    </tr>
                    <?
                    }
                }
		        ?>
                </table>
                <br>
                </div>
                </td>
            </tr>
            <tr>
                <td class="contenidotab" style="text-align:center">
                	Asunto <input type="text" value="" maxlength="300" id="asunto" name="asunto" size="100">
                </td>
            </tr>
            <tr>
                <td class="contenidotab" style="text-align:center">
                	Correos adicionales (separados por coma): <input type="text" value="" maxlength="300" id="adicionales" name="adicionales" size="100">
                </td>
            </tr>
           <!-- <tr>
            	<td class="contenidotab" style="text-align:center">
                	Asunto: <input type="text" value="" maxlength="300" id="asunto" name="asunto" size="100">
                </td>
            </tr>-->
            <tr>
                <td class="contenidotab" style="text-align:center" align="center">
                	<textarea name="mensaje" id="mensaje" style="height : 350px; width : 750px;"></textarea>
                </td>
            </tr>
            <tr>
                <td align="center">
                	<input type="button" value="Enviar" name="enviar" id="enviar" class="botonesadmin" style="color:#FFFFFF" onClick="validaEnvia2(formulario, '<? print $tipo; ?>', '<? print $proveedor; ?>');this.disabled=true; this.value='Enviando, por favor espere...'">
                </td>
            </tr>

<?
}

	?>
</table>
</form>
</body>
</html>
