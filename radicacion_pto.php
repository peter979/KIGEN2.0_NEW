<? include('sesion/sesion.php');
include("conection/conectar.php");
include_once("permite.php");
include('scripts/scripts.php');
include_once("scripts/recover_nombre.php");
require("./phpmailer/class.phpmailer.php");
$tabla = "usuarios";
$llave = "idusuario";
?>
<html>
<head>
	<link href="css/admin_internas.css" rel="stylesheet" type="text/css">
	<?
	//Sirve para mostar la fecha en Espa�ol
	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","S�bado");
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	//envia el Email
	if($_GET['opc']=="send_mail"){
		ini_set('max_execution_time', 0); //Tiempo maximo ilimitado
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
		$mail->IsHTML(true);

		$msg = str_replace("\\","",$_POST['msg']); // Mnesaje que va a enviar
		$mail->Body = $msg;
		$moto = scai_get_name($_POST['mbl'],"reporte_estado_cli","mbl","motonave");
		$eta = scai_get_name($_POST['mbl'],"reporte_estado_cli","mbl","eta");
		$mail->Subject = "Radicaci�n Portuaria / MBL: ".$_POST['mbl']." / MN:$moto / ETA:$eta ";


		//Extra los email, y quita espacios en blanco
		$email = explode(",",$_POST['correos']);

		//Adjuntos

		foreach($_FILES['Adjunto']['tmp_name'] as $key => $tmp_name)
		{
			$file_name = $_FILES['Adjunto']['name'][$key];
			$file_size =$_FILES['Adjunto']['size'][$key];
			$file_tmp =$_FILES['Adjunto']['tmp_name'][$key];


			if($file_size > 3000000){
				echo "No se adjunt� el archivo ".$file_name." por que supera los 3 Mb";
				die();
			}
			$mail->AddAttachment($file_tmp, $file_name);
			$adjHistoria .= $file_name."," ;
		}




		/*
		//Valida que cada uno de los adjuntos no superen los 500 kb
		if($_FILES['mblAdj']['size'] > 500000 || $_FILES['hblAdj']['size'] > 500000){
			echo "<script>alert('Alguno de los adjuntos supera 500 kb');window.location='radicacion_pto.php'</script>";
		}


		if(!$mail->AddAttachment($_FILES['mblAdj']['tmp_name'], $_FILES['mblAdj']['name']))
			echo "No adjunt� el MBL!<br>";

		if(!$mail->AddAttachment($_FILES['hblAdj']['tmp_name'], $_FILES['hblAdj']['name']))
			echo "No adjunt� el HBL!<br>";^*/


		/*
		foreach( $_REQUEST["Adjunto"] as $file ){
			echo "$file <br>";
		}*/



		foreach($email as $contacto){
			$mail->AddAddress(trim($contacto),"");//
		}

		//almacena el comunicado enviado en alguno de los reportes de estados, para dejar el hist�rico de envio, y luego si se ha enviado no permite enviarlo nuevamente sino ver el comunicado que se envi�
		$msg = "
				<p><strong>Correos:</strong>".$_POST['correos']."</p>
				<p>
					<strong>Adjuntos:</strong>$adjHistoria
				 </p>
				 <p><strong>Asunto:Radicaci�n puerto</strong></p>
				 <p><strong>Mensaje:</strong><br>
				 	$msg
				 </p>d";
		if(!$mail->Send()){
			echo "<strong>No envi� a todos los contactos </strong><br>".$mail->ErrorInfo;
		}else{
			if(!mysqli_query($link,"update reporte_estado_cli set radicacion_pto = \"$msg\" where mbl = '".$_POST['mbl']."'")){
				echo "No almacen� comunicado <br>".mysqli_error()."<br>";die();
			}
			echo "<script>alert('Comunicado enviado');window.location='radicacion_pto.php';</script>";
		}



	}
	?>
	<script>
		function addRow() {


			var table = document.getElementById("tbAdjuntos");
			var row = table.insertRow(0);
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);
			cell1.innerHTML = "Adjunte MBL(M�x 500 kb)";
			cell2.innerHTML = "<input type=\"file\" name=\"Adjunto[]\" required>";
		}
	</script>
</head>


<body style="background-attachment: scroll;background-repeat: no-repeat;text-align: center" class="contenidotab">

		<? if(!$_POST['mbl']){?>
			<form method="post" action="radicacion_pto.php" name="search">
				DIGITE EL MBL: <input type="text" name="mbl" id="mbl" required> <input type="submit" value="Buscar." class="botonesadmin">
				<!--Muestra las radicaciones que faltan por enviar-->
				<p>
				Radicaciones Pendientes Por enviar:<br>
				<table class="tabla" align="center">
					<tr class="tittabla"	>
						<td>Master</td><td>Enviar</td>
					</tr>
					<?
					echo $_POST['mbl'];
					//mues
					$sqlMblsinRad = mysqli_query($link,"select distinct(mbl) from reporte_estado_cli where mbl != '' and radicacion_pto ='' ");
					while($Radicaciones = mysqli_fetch_array($sqlMblsinRad)){
						if ($color == "#FFFFFF")  $color = "#CCCCCC"; else $color = "#FFFFFF"; ?>
						<tr height="30px" bgcolor='<? echo $color; ?>'><td><? echo $Radicaciones["mbl"]?></td>
						<td><a href="#" onClick="document.getElementById('mbl').value='<? echo $Radicaciones["mbl"]?>';document.search.submit();">Enviar</a></td></tr><?
					}
					?>
				</table>
				</p>
			</form>
		<?
		}else{
			//consulta si el mbl existe en la base de datos, si no, muestra un mensaje y no permite ver la tabla
			$mblSql = mysqli_query($link,"select * from reporte_estado_cli where mbl = '".$_POST['mbl']."'");
			if(mysqli_num_rows($mblSql) == 0){
				echo "El mbl <strong>".$_POST['mbl']."</strong> no existe en la base de datos ";
				?><input type="button" class="botonesadmin" onClick="window.location='radicacion_pto.php'" value="<<Volver"><?

				die();
			}
			//Consulta, si no se a enviado el comunicado permite enviarlo, si ya se envi� muestra el hist�tico
			$qryHist = mysqli_query($link,"select * from reporte_estado_cli where mbl = '".$_POST['mbl']."' and radicacion_pto != ''");
			if(mysqli_num_rows($qryHist) > 0){ //si ya se envi�
				echo "<font style='color:#FF0000;font-weight:bold'>Este Comunicado ya fue enviado</font>";
				$historico = mysqli_fetch_array($qryHist);
				echo $historico["radicacion_pto"];
				?><input type="button" onClick="window.location='radicacion_pto.php'" class="botonesadmin" value="<<Volver"><?
				die();
			}
			$HblMb = mysqli_fetch_array($mblSql); //Permite para mostrar informacion del mbl que se debe repetir en todos los hbl's entonces con esto myuestra solo uno

			if($HblMb["aduanaChk"] == "1" || $HblMb["otmChk"] == "1" || $HblMb["terrestreChk"] == "1" || $HblMb["dtaChk"] == "1" ){
				$msgDocumentos = "<p style='font-size:24px;color:#FF0000'>No enviar notificaci�n de entrega de documentos liberados</p>";?><?
			}

			$msg = "

			<table width='40%' style='font-size:11px;color:#333333;'>
				<tr>
					<td colspan='2'><img src='http://".$_SERVER['HTTP_HOST']."/gateway/images/header_blanco.png' width='250px'></td>
				</tr><tr height='60px'>
					<td colspan='2' valign='top'>".$dias[date('w')].' '.date('d').' de '.$meses[date('n')-1]. ' del '.date('Y')."</td>
				</tr>

				<tr><td style='font-weight:700'>PTO EMBARQUE</td>
					<td>".scai_get_name($HblMb['puerto_origen'], 'aeropuertos_puertos', 'idaeropuerto_puerto', 'nombre')."</td>
				</tr>
				<tr><td style='font-weight:700'>PTO DESCARGUE</td>
					<td>".scai_get_name($HblMb['puerto_destino'], 'aeropuertos_puertos', 'idaeropuerto_puerto', 'nombre')."</td>
				</tr>
				<tr><td style='font-weight:700'>ETA</td><td>".$HblMb['eta']."</td></tr>
				<tr><td style='font-weight:700'>NAVIERA O COLOADER</td><td>".$HblMb['naviera']."</td></tr>
				<tr><td style='font-weight:700'>MN ARRIBO</td><td>".$HblMb['motonave']."</td></tr>
			</table>
			$msgDocumentos
			";
			?>

			<p>
			<?
			$msg .= "
			<table border='1' width='70%' style='font-size:11px;color:#333333;border-collapse:collapse;'>
				<tr height='40px' style='font-weight:800;text-align:center'>
					<td colspan='2'>&nbsp;</td>
					<td>MBL No:</td>
					<td colspan='2' style='font-size:20px'>".$HblMb['mbl'].":</td>
				</tr>
				<tr height='25px' style='font-weight:700;text-align:center'>
					<td>OPERACI�N</td>
					<td>SHIPPER</td>
					<td>CONSIGNEE</td>
					<td>HBL</td>
					<td>EMISI�N Y/O HBL</td>
				</tr>
				";


				$mblSql = mysqli_query($link,"select * from reporte_estado_cli where mbl = '".$_POST['mbl']."'");
				while($hbl = mysqli_fetch_array($mblSql)){
					$msg .= "
					<tr height='25px'>
						<td>";
							if( $hbl['clasificacion'] == 'aereo') //Si es aereo busca en la tabla rn_fletes_aero
								$shippingSql = "select numero from shipping_instruction where idreporte = (	select idreporte from rn_fletes_aereo where `order_number` ='".$hbl['number']."')";
							else
							{
								$shippingSql = "select numero from shipping_instruction where order_number ='".$hbl['number']."'";
							}
							$shippingQry = mysqli_query($link,$shippingSql);

							$shipping = mysqli_fetch_array($shippingQry);

							$msg .= $shipping[0]."
						</td>
						<td>".$hbl['shipper']."</td>
						<td>".scai_get_name($hbl['idcliente'], 'clientes', 'idcliente', 'nombre')."</td>
						<td>".$hbl['hbl']."</td>
						<td>".$hbl['emision_hbl']."</td>
					</tr>";


				}
			$sqlUsu = mysqli_query($link,"select * from usuarios where idusuario =".$_SESSION['numberid']);
			$Usuario = mysqli_fetch_array($sqlUsu);
			$msg .="
			</table>
			</p>
			<p style='font-size:11px;color:#333333;text-align:center'>
				MBL ORIGINAL EMISION EN:".$HblMb["emision_mbl"]."
			</p>
			<p style='font-size:11px;color:#333333;text-align:left'>
				<strong>".$Usuario["nombre"]." ".$Usuario["Apellido"]."</strong><BR>
				".$Usuario["email"]."<BR>
				KIGEN<BR>
			</p>";

			?>
			<form name="radicacion" method="post" action="" enctype="multipart/form-data" style="text-align:left">
				<p></p>
				Escriba los correos(separados por una coma):<input type="text" name="correos" size="40" required>
				<input type="hidden" name="mbl" value="<? echo $_POST['mbl']; ?>">
				<br>
				<table style="font-size:10px" id="tbAdjuntos" cellpadding="5">
					<tr>
						<td>Adjunte MBL(M&aacute;x 500 kb)</td>
						<td><input type="file" name="Adjunto[]" required></td>
					</tr>
					<tr><td colspan="2" align="center">
							<input type="button" value="Agregar Adjunto" class="botonesadmin" onClick="addRow()">
						</td>
					</tr>
				</table>


				<input type="submit" onClick="radicacion.action='?opc=send_mail';this.value='Espere..'" class="botonesadmin" value="Enviar">
				<div style="width:50%;margin: 40px auto;overflow:auto;border:ridge;"><? echo $msg;?></div>
				<input type="button" onClick="window.location='radicacion_pto.php'" class="botonesadmin" value="<<Volver">
				<textarea style="visibility:hidden" name="msg"><? echo $msg?></textarea>
				<input type="hidden" value="<? echo $HblMb['mbl']?>" name="mbl">
			</form><?
		}
		?>
</body>
</html>
