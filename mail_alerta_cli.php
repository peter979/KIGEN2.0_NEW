<?
include('./sesion/sesion.php');
include("./conection/conectar.php");
include_once("./permite.php");
include_once("scripts/recover_nombre.php");

//Cuando el envio de correo tiene un adjunto muy pesado toma mas tiempo de lo normal, pero si el script supera 30 segundos de ejecucion genera un error, para prevenir esto se le agrega la siguiente linea
set_time_limit(0);//Da un maximo de 1 minuto para correr el script y que no genere errorcuando elea muy pesado
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="./css/admin_internas.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/main.js"></script>
<script type="text/javascript" src="./js/shadowbox-base.js"></script>
<script type="text/javascript" src="./js/shadowbox.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.1.pack.js" ></script>
<script type="text/javascript" src="./js/funciones.js"></script>
<script type="text/javascript" src="./js/funcionesValida.js"></script>
<script type="text/javascript" src="./js/clients_list.js"></script>

<? include("./scripts/prepare_clients_list.php");?>
<? include('./scripts/scripts.php'); ?>

<script language="javascript">

	function validaEnvia(form, cliente)
	{
		form.action='<? print $_SERVER['PHP_SELF'];?>?cliente='+cliente;
		form.submit();
	}

	function validaEnvia2(form, tipo, proveedor)
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
function showmed2()
{
	$('div[@class=campos2]').slideToggle("slow",function(){
		/*$('div[@class=campos]').slideUp("slow");*/
	});
}
</script>
<style type="text/css">
div.campos
{
	display:none;
}
div.campos2
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


<?
if($_POST["datosok"]=="si")
{
	require("./phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();

	$mail->IsSMTP();
	$mail->Timeout=1200;//20 minutos

	//-----------------------------------------------------------------------
	$mail->SMTPAuth   = true; //enable SMTP authentication

	$mail->SMTPSecure = $secure;
	$mail->Host = $host_envios;
	$mail->Port = $port;
	$mail->Username = $email_envios;
	$mail->Password = $password_envios;

	$mail->From = "$email_real";
	$mail->FromName = 'Kigen'."\r\n";
	$mail->Sender = "$email_real";//return-path
	$mail->ConfirmReadingTo = "$email_real";

	$mail->CharSet = 'UTF-8';

//-----------------------------------------------------------------------
	$subject = $_POST['asunto2'];
	$mail->Subject = $subject;
	$mail->AltBody = " ";

	$_POST['mensaje'] = str_replace("\\", "",$_POST['mensaje']);
		$mail->Body = $_POST['mensaje'];
	$adjuntos = '';

	//adjuntos reporte estado------------------------------------------------------------------------------------------------
	if($_POST['idreporte_estado']!='')
	{
		$sql = "select * from formatos_adjunto where tipo='comercial' or tipo='cliente' and idreporte_estado='$_GET[idreporte_estado]'";
		//print $sql.'<br>';
		$exe = mysqli_query($link,$sql);
		while($datosft = mysqli_fetch_array($exe))
		{
			if($_POST['formato_adjunto'.$datosft['idformato']]!='')
			{
//				$mail->AddAttachment("./erpoperativo/formatos_adjunto/$datosft[nombre]", "$datosft[nombre]");
				$mail->AddAttachment("./doc/doc_adjuntos/$datosft[nombre]", "$datosft[nombre]");
				$adjuntos .= $datosft['nombre'].', ';//concatena para guardarlos en la tabla y luego mostrarlos
			}
		}
	}

	$sql = "select * from adjuntos_proveedores where idproveedor='$_GET[proveedor]' and estado='1'";
	//print $sql.;
	$exe=mysqli_query($link,$sql);
	while($datosa = mysqli_fetch_array($exe))
	{
		if($_POST['adjunto'.$datosa['idadjunto']]!='')
		{
//			$mail->AddAttachment("adjuntos_proveedores/$datosa[nombre]", "$datosa[nombre]");
			$mail->AddAttachment("doc/doc_proveedores/$datosa[nombre]", "$datosa[nombre]");
			$adjuntos .= $datosa['nombre'].', ';//concatena para guardarlos en la tabla y luego mostrarlos
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
			}
		}
	}

	if($_POST['adicionales']!='')
	{
		$adicionales = explode(',', $_POST['adicionales']);
		for($g=0; $g<count($adicionales); $g++)
		{
			$mail->AddAddress("$adicionales[$g]","");
		}
	}

	if($mail->Send())
	{
		$mail->ClearAddresses();

		?><script>alert('El mensaje ha sido enviado');</script><?

		$orig = array("“", "”", "'"); //caracteres que busco
		$reem = array("&ldquo;", "&rdquo;", "&apos;"); // caracter con los que reemplazo
		for ($f=0; $f<count($orig); $f++)
			$_POST['mensaje'] = str_replace($orig[$f], $reem[$f], $_POST['mensaje']);

		$sql = "insert into enviados_alertas_cli(idusuario, emails, adicionales, adjuntos, asunto, contenido, fecha) VALUES ('$_SESSION[numberid]', '$correos', '$_POST[adicionales]', 'adjuntos', '$subject', '$_POST[mensaje]', NOW())";
		//print $sql.'<br>';
		$exe = mysqli_query($link,$sql);
	}
	else
	{
		$mail->ClearAddresses();
		echo $mail->ErrorInfo."<-";
		/*
		?><script>alert('El mensaje no pudo ser enviado');</script><?
		*/
	}

}
?>
<html>
<body bgcolor="#FFFFFF">
<link href="Forms.css" rel="stylesheet" type="text/css" />
<form enctype="multipart/form-data" name="formulario" method="post" action="">
<input name="datosok" type="hidden" value="no" />
<input type="hidden" id="msg" name="msg" value="<? print str_replace("\\", "",$_POST['msg']); ?>">
<input type="hidden" id="asunto" name="asunto" value="<? print $_POST['asunto']; ?>">
<input type="hidden" id="shipment_id" name="shipment_id" value="<? print $_POST['shipment_id']; ?>">
<input type="hidden" id="fuente" name="fuente" value="<? print $_POST['fuente']; ?>">
<input type="hidden" id="idreporte_estado" name="idreporte_estado" value="<? print $_GET['idreporte_estado']; ?>">

<!--<table align="center" width="100%">
	<tr>
        <td class="contenidotab" style="text-align:center">
        Seleccione cliente
        <select name="cliente" id="cliente" onChange="validaEnvia(formulario, this.value)" >
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
</table>-->
<?
$cliente = $_GET['cliente'];
if($cliente!='' && $cliente!='N')
{
	?>
	<table align="center" width="80%">
		<?
		$sql = "select * from adjuntos_proveedores where idproveedor='$_GET[proveedor]' and estado='1'";
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
	<a href="javascript:void(0);" onClick="showmed2()"><img src="images/up.png" width="13" height="8" border="0">&nbsp;Listar adjuntos<img src="images/up.png" width="13" height="8" border="0"></a>
	<div class="campos2">


	<?
	if($_GET['idreporte_estado']!='')
	{
		$sql = "select * from formatos_adjunto where (tipo='comercial' or tipo ='cliente') and idreporte_estado='$_GET[idreporte_estado]'";

		$exe = mysqli_query($link,$sql);
		?>
		<table width="70%" align="center">
		<?
		while($datosft = mysqli_fetch_array($exe))
		{
			?>
			<tr>
				<td class="contenidotab"><input type="checkbox" id="formato_adjunto<? print $datosft['idformato']; ?>" name="formato_adjunto<? print $datosft['idformato']; ?>"></td>
				<td class="contenidotab">
<!--				<a href="./erpoperativo/formatos_adjunto/<? print $datosft['nombre']; ?>" target="_blank">-->
					<a href="./doc/doc_adjuntos/<? print $datosft['nombre']; ?>" target="_blank">
						<? print $datosft['nombre']; echo ($datosft["tipo"] == "cliente") ? "(cliente)" : "" ?>
					</a>

				</td>
				<td class="contenidotab"><? print $datosft['fecha']; ?></td>
				<td class="contenidotab"><? print scai_get_name("$datosft[idusuario]", "vendedores_customer", "idusuario", "nombre"); ?></td>
			</tr>
			<?
		}
		?>
		</table>
		<br>
		<?
	}
	?>
	</div>
	</td>
</tr>
		<tr>
                <td class="contenidotab" style="text-align:center">
                	Correos adicionales (separados por coma): <input type="text" value="" maxlength="300" id="adicionales" name="adicionales" size="50">
                </td>
            </tr>
            <tr>
            	<td class="contenidotab" style="text-align:center">
			<?php
                            $cliente_nom = strtoupper(scai_get_name("$cliente", "clientes", "idcliente", "nombre"));
                            $numshipping = ($_POST[numshipping]);
                            $order_number = strtoupper($_POST[no_orden]);
                            $nombre_shipper = strtoupper($_POST[nom_shipper]);
                            ?>
                            Asunto: <input type="text" value="<? print 'NS/ '.$numshipping.' S/ '.$nombre_shipper.' C/ '.$cliente_nom.' / PO '.$order_number; ?>" maxlength="300" id="asunto2" name="asunto2" size="50">

                </td>
            </tr>
            <tr>
                <td class="contenidotab" style="text-align:center" align="center">
					<div style="width:800px;height:400;overflow:scroll;">
						<? $Mensaje = str_replace("\'",'"',$_POST['msg']);
						echo $Mensaje;
						?>
					</div>
					<input type="hidden" name="mensaje" id="mensaje" value="<? print str_replace("\"","'",$Mensaje) ; ?>">

                </td>
            </tr>
            <tr>
                <td align="center">
                	<input type="button" value="Atras" name="atras" id="atras" class="botonesadmin" style="color:#FFFFFF" onClick="document.location = '<? print $_POST['fuente']; ?>'">
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
