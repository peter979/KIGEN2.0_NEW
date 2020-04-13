<?php

set_time_limit(0);
include("conection/conectar.php");
include("permite.php");
include_once("scripts/recover_nombre.php");

function msg($parametro){
	include("conection/conectar.php");
	$sql2="select valor from parametros where nombre like '$parametro'";
	$exe_sql2=mysqli_query($link,$sql2);
	$alpha=mysqli_fetch_array($exe_sql2);
	return $alpha['valor'];
}

if($_GET['name']=="")
	$name=str_replace("{file_name}", $_GET['id'], msg("nombre_archivo_imprimir"));
	$name=str_replace(" ","_", $name);

	Header("Content-Disposition: inline; filename=$name.doc");
	Header("Content-Description: PHP3 Generated Data");
	if($_GET['opc']=="word"){
		Header("Content-type: application/vnd.ms-word; name='$name.doc'");//comenta esta linea para ver la salida en web
	}
	flush;




	$sql="select * from cot_temp where idcot_temp ='$_GET[id]'";
	$exe_sql=mysqli_query($link,$sql);
	$row=mysqli_fetch_array($exe_sql);
?>
<html>
<head>
<link href="css/admin_internas.css" rel="stylesheet" type="text/css">

<style type="text/css">
body{
	font-family:<? print msg("exportar_word_fuente");?>;
	font-size:<? print '10';//msg("exportar_word_tamano_fuente");?>pt;
}
</style>

<script>

function mostrardiv(capa) {
	div = document.getElementById(capa);
	if(div.style.display == 'none')
		div.style.display = '';
	else
		div.style.display='none';
}

function cerrar() {
	div = document.getElementById('flotante');
	div.style.display='none';
}
function val_send(){
	for (i=0;ele=document.msg.contacto[i];i++){ //Recorre los elementos de direccion
	  if (ele.type=='checkbox'){ //Valida si es checkbox
		if (ele.checked){ //Valida si esta seleccionado
		  return true;
		}
	  }
	}
	alert('Debe Selecccionar por lo menos un correo');
	return false;

}

</script>

</head>
<body>


<?



//Termina el script si es para exportar a word, si no imprime formulario de envio de comunicados, para enviar la comunicacion
if($_GET['opc']=="word"){
	echo str_replace("\\","",$_POST['txt_msg']);
	die();
}else if($_GET['opc']=="save"){ //Envia Email

	require("phpmailer/class.phpmailer.php");
	include("phpmailer/class.smtp.php");
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
    $mail->isHTML(true);

	$mail->From = "$email_real";
	$mail->FromName = 'Kigen'."\r\n";
	$mail->Sender = "$email_real";//return-path
	$mail->ConfirmReadingTo = "$email_real";

	$mail->CharSet = 'UTF-8';



	//------------------------------------------------------------
	$mail->Subject = $_POST['asunto'];
	$mail->AltBody = " ";

	$mail->Body = str_replace("\\","",$_POST['msg']);
	$adjuntos = '';

	if($_POST['condiciones_seg'] == "on"){//Adjunta las condiciones de seguro
		$mail->AddAttachment("file/CONDICIONES_DEL_SEGURO.pdf");
	}

	if($_POST['condiciones_gen'] == "on"){//Adjunta las condiciones de seguro
		$mail->AddAttachment("file/CONDICIONES GENERALES DE LA OFERTA.doc");
	}

	if($_POST['liquidador'] == "on"){//Adjunta las condiciones de seguro
		$mail->AddAttachment("liquidadores/Cotizacion-".$_POST['id_cot'].".xls","Pre - Liquidacion.xls");

	}
	if($_POST['presentacion'] == "on"){//Adjunta presentacion Gateway
		$mail->AddAttachment("file/Presentacion.ppsx","Presentacion.ppsx");

	}
	if($_POST['cond_otm'] == "on"){//Adjunta presentacion Gateway
		$mail->AddAttachment("file/CONDICIONES_OTM1.docx","CONDICIONES_OTM2.docx");

	}



	foreach($_POST['contacto'] as $contacto){
		if($contacto){
			$mail->AddAddress($contacto,"");

		}
	}



	if($_POST['mail_adic']){//emails adicionales
		$mail_adic=explode(",",$_POST['mail_adic']);
		foreach($mail_adic as $email){
			$mail->AddAddress($email,"");
		}
	}


	if($mail->Send())
		echo "<script>alert('Email enviado satisfactoriamente');window.location='index.php'</script>";
	else{
		echo $mail->ErrorInfo;
		echo "<script>alert('Error al enviar email, Contacte al administrador')</script>";
	}



}else if($_GET['opc']=="email"){



	$fp= fopen("liquidadores/Cotizacion-".$_POST['id_cot'].".xls","w");
	if(!fwrite($fp,str_replace("\\","",$_POST['txt_liq'])))
		echo "<script>alert('No se creo el liquidador, contacte al administrador')</script>";



	?>
	<form action="?opc=save&id_cot=<? echo $_POST['id_cot']	?>" method="post" onSubmit="return val_send()" name="msg">
	<table cellpadding="4" style="margin-top:35px" align="center" border="1">
		<tr>
			<td class="contenidotab" style="text-align:center">
				<div id="contactos" style="display:none;">
					<table align="center">
						<?
						$sql = "select * from contactos_todos where estado = '1' and idcliente = (select idcliente from cot_temp where idcot_temp = ".$_POST['id_cot'].")";

						$sql_qry=mysqli_query($link,$sql);
						while($exe_qry=mysqli_fetch_array($sql_qry)){?>
							<tr><td class="contenidotab">
							<input type="checkbox" name="contacto[]" id="contacto" value="<? echo $exe_qry['correo']?>">
							<input type="hidden" name="contacto[]" id="contacto" value="">
							</td>
							<td class="contenidotab"><? echo $exe_qry['nombre']; ?><br></td>
							<td class="contenidotab"><? echo $exe_qry['correo']?></td></tr>
						<?
						}
						?>
					</table>
				</div>
				<a href="javascript:mostrardiv('contactos');"><img src="images/up.png">Listar Contactos<img src="images/up.png"></a>
			</td>
		</tr>
		<tr>
			<td class="contenidotab" style="text-align:center">
				<div id="adjuntos" style="display:none;">
						<table align="center">
							<tr><td class="contenidotab"><input type="checkbox" id="condiciones_seg" name="condiciones_seg"></td>
							<td class="contenidotab"><a href="file/CONDICIONES_DEL_SEGURO.pdf" target="_blank">Condiciones de Seguro</a></td>
							</tr>
							<tr>
								<td class="contenidotab"><input type="checkbox" id="condiciones_gen" name="condiciones_gen"></td>
								<td class="contenidotab"><a href="file/CONDICIONES GENERALES DE LA OFERTA.doc" target="_blank">Condiciones generales de la oferta</a></td>
							</tr>
	    					<tr>
								<td class="contenidotab"><input type="checkbox" id="presentacion" name="presentacion"></td>
								<td class="contenidotab"><a href="file/Presentacion.ppsx" target="_blank">Presentacion KIGEN</a></td>
							</tr>
							<tr>
								<td class="contenidotab"><input type="checkbox" id="liquidador" name="liquidador"></td>
								<td class="contenidotab"><a href="liquidadores/Cotizacion-<? echo $_POST['id_cot'] ?>.xls" target="_blank">Pre-Liquidación</a></td>
							</tr>


					</table>
				</div>
				<a href="javascript:mostrardiv('adjuntos');"><img src="images/up.png">Listar Adjuntos<img src="images/up.png"></a>


			</td>
		</tr>
		<tr>
			<td class="contenidotab" style="text-align:center">Correos adicionales (separados por coma):<input type="text" name="mail_adic" style="width:300px" ></td>
		</tr>
		<tr>
			<td class="contenidotab" style="text-align:center">Asunto:
			<?
			$suje = "Cotizaci&oacute;n / ";

			$idcliente = scai_get_name($_POST['id_cot'], "cot_temp", "idcot_temp", "idcliente");
			$suje .= scai_get_name($idcliente, "clientes", "idcliente", "nombre"). " / ";
			$suje .= scai_get_name($_POST['id_cot'], "cot_temp", "idcot_temp", "numero");

			?>
			<input type="text" name="asunto" style="width:300px" value="<? echo $suje?> " >
			<input type="hidden" name="id_cot" value="<? echo $_POST['id_cot'] ?>" >

			</td>
        </tr>
		<tr>
			<td class="contenidotab" style="text-align:center">
			    
			    
				<div style="font-size:9px;width:600px;overflow-y:auto;overflow-x:hidden;height:350px;">
					<?

					$mensaje = str_replace("\\","",$_POST['txt_msg']);
					$mensaje = str_replace("\"","",$mensaje);
					echo $mensaje;
					?>
					<textarea name="msg" style="visibility:hidden"><? echo $mensaje;?></textarea>
				</div>
			</td>
		</tr>
		<tr>
			<td style="text-align:center">
				<input type="submit" class="botonesadmin" style="font-size:11px; color:#FFFFFF;" value="Enviar">
			</td>
		</tr>
	</table>
	</form>


<?

}
?>

</body>
</html>
