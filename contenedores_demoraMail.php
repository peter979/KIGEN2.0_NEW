<?
include('./sesion/sesion.php');
include("./conection/conectar.php");
include_once("./permite.php");
include("scripts/recover_nombre.php");
include('scripts/scripts.php');
require("./phpmailer/class.phpmailer.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<script type="text/javascript" src="./js/jquery-1.8.3.js" ></script>

    <link href="./css/admin_internas.css" rel="stylesheet" type="text/css">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
	<script type="text/javascript" src="./js/jquery-1.8.3.js" ></script>
	<script>
		function show(id){
			var div = $("#"+id);
			if(div.css("display") == "none")
				div.show("slow");
			else
				div.hide("slow");

		}
	</script>

	<?

	set_time_limit(0);

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
	$mail->FromName = 'Kigen'."\r\n"; // encabezado de correo
	$mail->Sender = "$email_real";//return-path
	$mail->ConfirmReadingTo = "$email_real";

	$mail->CharSet = 'ISO-8859-1';


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


	function sendMail($idCliente,$msg) {
		global $mail;
		include("./conection/conectar.php");
		//include("scripts/recover_nombre.php");

		$subject = "Kigen - Contenedores vencidos";
		$mail->Subject = $subject;
		$mail->AltBody = " ";

		$sqlContactos = "select * from contactos_todos where idcliente = $idCliente";
		$qryContactos = mysqli_query($link,$sqlContactos );


		while($contactos = mysqli_fetch_array($qryContactos)){
			$mail->AddAddress($contactos['correo'],"");
			$contatoH .= "<li>".$contactos['correo']."</li>";
		}

		$mail->Body = $msg;
		$cliente = scai_get_name($idCliente, "clientes", "idcliente", "nombre");
		?><a href="#" onclick="show('<?= $idCliente?>')"><?= $cliente;?></a><?

		if($mail->Send()){ //Si envia muesta los resultados de los correos a los que envio ?>
			<div id="<?=$idCliente;?>" style="display:none"><ul><?= $contatoH?></ul></div><p>&nbsp;</p>
			<?
			$mail->ClearAddresses();
			$contatoH = "";
		}else{
			$contatoH = "<li>No envi� el comunciado</li>";
		}


	}
  $sqlCont = "SELECT
				ADDDATE(r.eta, INTERVAL r.dias_libres DAY) as fechaDev,
				r.idcliente as id_cliente,
				cli.nombre as cliente,
				r.mbl as mbl,
				c.tipo as tipo,
				c.number as number,
				n.nombre as naviera,
				r.eta as eta,
				r.idcliente as idcliente
			FROM `contenedores` as c

				inner join  reporte_estado_cli as r on r.idreporte_estado =  c.idreporte_estado
				inner join proveedores_agentes as n on n.nombre = r.naviera
				inner join clientes as cli on cli.idcliente = r.idcliente
				where c.devuelto ='0000-00-00'
				and ADDDATE(r.eta, INTERVAL r.dias_libres DAY) < now()
                order by cli.nombre asc";




	if($_GET['opc']== "enviar"){
			$qryCont = mysqli_query($link,$sqlCont);
			$clienteTmp="";

			?><h2>Resumen de enviados</h2><?
			while( $contenedor =  mysqli_fetch_array($qryCont)){
				$idCliente = $contenedor["idcliente"];
				$nombreCliente = $contenedor["cliente"];

				if($clienteTmp != $contenedor["idcliente"]){
					$msg .= "

					</table>";
					if($clienteTmp != ""){//env�a correo
						sendMail($clienteTmp,$msg);
					}

					$msg = "
					<p>Se�ores $nombreCliente,</p>
					<p>Reciban un cordial saludo</p>
					<p>A continuaci�n nos permitimos relacionar el listado de contenedores cuya fecha de devoluci�n est� vencida</p>
					<br /><br />
					<table cellpadding='10' width='80%' class='tabla' >
					  <tr style='background-color:#FF6600;font-weight:800;text-align:center;color:#FFFFFF'>
						<td>MBL</td>
						<td>CONTENEDOR</td>
						<td>TIPO</td>
						<td>D�AS DE MORA</td>
						<td>NAVIERA</td>
						<td>ETA</td>
					  </tr>";

				}
				if($color == "#CCCCCC")
					$color = "#FFFFFF";
				else
					$color="#CCCCCC";

				$msg .= "
				  <tr bgcolor='$color'>
					<td>".$contenedor["mbl"]."</td>
					<td>".$contenedor["number"]."</td>
					<td>".$contenedor["tipo"]."</td>
					<td>".restarFechas(date("Y-m-d"),$contenedor["fechaDev"])."</td>
					<td>".$contenedor["naviera"]."</td>
					<td>".$contenedor["eta"]."</td>
				  </tr>";
				if($clienteTmp != $contenedor["idcliente"]){
					$clienteTmp = $contenedor["idcliente"];
				}
			}
			$msg .= "
	  </table>";
	  sendMail($idCliente,$msg);
	  ?><a href="contenedores_demoraMail.php">Volver</a><?
	  die();
	}
	?>
</head>

<body>
<h2>Demora contenedores:</h2>
<form method="post">

	<p>
	</p>
	<div style="margin:20px 20px 20px 20px ">

	  <?


		$qryCont = mysqli_query($link,$sqlCont);
		$clienteTmp="";
		while( $contenedor =  mysqli_fetch_array($qryCont)){?>

			<?
			if($clienteTmp != $contenedor["cliente"]){?>
				</table>
				<br /><br />
				<a href="#" onclick="show('<?= $contenedor["idcliente"];?>')"><?= $contenedor["cliente"];?><img src="images/down.png" /></a>
				<table cellpadding="10" width="80%" class="tabla" id="<?= $contenedor["idcliente"]?>" style="display:none">
				  <tr class="tittabla">
					<td>MBL</td>
					<td>CONTENEDOR</td>
					<td>TIPO</td>
					<td>D�AS DE MORA</td>
					<td>NAVIERA</td>
					<td>ETA</td>
				  </tr>
				<?
			}
			?>
			  <tr bgcolor="<? echo ($color == "#CCCCCC") ? $color = "#FFFFFF": $color="#CCCCCC"; ?>">
				<td><? echo $contenedor["mbl"];?></td>
				<td><? echo $contenedor["number"];?></td>
				<td><? echo $contenedor["tipo"];?></td>
				<td><? echo restarFechas($contenedor["fechaDev"],date("Y-m-d"));?></td>
				<td><? echo $contenedor["naviera"];?></td>
				<td><? echo $contenedor["eta"];?></td>
			  </tr><?
			if($clienteTmp != $contenedor["cliente"])
				$clienteTmp = $contenedor["cliente"];
		}
		?>
  </table>
  <p></p>
  <input type="submit" value="Enviar"  class="botonesadmin" onclick="form.action='?opc=enviar';this.value='Enviando...'" />
</div>
</form>
</body>
</html>
