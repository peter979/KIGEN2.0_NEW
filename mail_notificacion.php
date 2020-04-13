<?
include('./sesion/sesion.php');
include('./conection/conectar.php');
require("phpmailer/class.phpmailer.php");
include_once("scripts/recover_nombre.php");

$subject="NOTIFICACION REPORTE DE NEGOCIO $_GET[idcot_temp]";

$cabeceras='MIME-Version: 1.0'."\r\n";
$cabeceras.='Content-type: text/html; charset=utf-8'."\r\n";
$cabeceras.='From: Kigen <kigen@civilnet.co>'."\r\n" ;

//print "id orden ".$_POST['id_orden']."<br>";
//print "destino ".$_POST['destino']."<br>";
//print "mensa ".$_POST['mensa']."<br>";

$mail = new PHPMailer();
//$mail->Host = "localhost";
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
$columnas="";
$numero = scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero");

$idcliente = scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "idcliente");
$nomcliente = scai_get_name("$idcliente", "clientes", "idcliente", "nombre");
$apecliente = scai_get_name("$idcliente", "clientes", "idcliente", "apellido");


$sqlmod="select * from modalidades_reportes where idcot_temp='$_GET[idcot_temp]'";
$exemod = mysqli_query($link,$sqlmod);
		$datosmod = mysqli_fetch_array($exemod);
$origen="";
$destino="";
//print $sqlmod;

$idcliente = scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "idcliente");

$idoperativo = scai_get_name("$idcliente", "clientes", "idcliente", "idoperativo");
$email = scai_get_name("$idoperativo", "vendedores_customer", "idvendedor_customer", "email");
$nomoperativo=scai_get_name("$idoperativo", "vendedores_customer", "idvendedor_customer", "nombre");
$idcomercial = scai_get_name("$idcliente", "clientes", "idcliente", "idcustomer");
$email_comercial = scai_get_name("$idcomercial", "vendedores_customer", "idvendedor_customer", "email");
$nomcomercial=scai_get_name("$idcomercial", "vendedores_customer", "idvendedor_customer", "nombre");


if($datosmod['flete']==1){
$modali= scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "clasificacion");

			if($modali == 'fcl' || $modali== 'lcl')
				$sqlrn = "select * from rn_fletes where idreporte='$_GET[idcot_temp]'";
			if($modali == 'aereo')
				$sqlrn = "select * from rn_fletes_aereo where idreporte='$_GET[idcot_temp]'";
			//print $sqlrn.'<br>';
			$exern = mysqli_query($link,$sqlrn);
			$filasrn = mysqli_num_rows($exern);

			while($datosrn=mysqli_fetch_array($exern)){

				if($modali == 'fcl' || $modali== 'lcl'){
				$sqlfletn="select * from cot_fletes where idcot_fletes='$datosrn[idcot_fletes]'";
				//print $sqlfletn;
				$exefletn = mysqli_query($link,$sqlfletn);
				$datosfletn = mysqli_fetch_array($exefletn);
				$origen=scai_get_name($datosfletn['idtarifario'], "tarifario", "idtarifario", "puerto_origen");
				$destino=scai_get_name($datosfletn['idtarifario'], "tarifario", "idtarifario", "puerto_destino");
				$naviera=scai_get_name($datosfletn['idtarifario'], "tarifario", "idtarifario", "idnaviera");
				$proveedor=scai_get_name($datosfletn['idtarifario'], "tarifario", "idtarifario", "idagente");
				$columnas.="<tr>
				<td colspan='9' class='contenidotab' valign='top'><span
				style='font-weight: bold;'>Flete Order Number: ".$datosrn['order_number']."</span><br>
				</td>
				</tr>
				<tr>
				<td colspan='1' style='vertical-align: top;'>Origen: ".scai_get_name($origen, "aeropuertos_puertos", "idaeropuerto_puerto", "nombre")." <br>
				</td>
				<td colspan='8' style='vertical-align: top;'>Destino: ".scai_get_name($destino, "aeropuertos_puertos", "idaeropuerto_puerto", "nombre")."<br>
				</td>
				</tr>
				<tr>
				<td style='vertical-align: top;'>Proveedor: ".scai_get_name($proveedor, "proveedores_agentes", "idproveedor_agente", "nombre")."<br>
				</td>
				<td colspan='8' style='vertical-align: top;'>Naviera: ".scai_get_name($naviera, "proveedores_agentes", "idproveedor_agente", "nombre")."<br>
				</td>
				</tr>";
				}
				if($modali == 'aereo'){
				$sqlfleta = "select * from cot_fletes_aereo where idcot_fletes_aereo='$datosrn[idcot_fletes_aereo]'";
				//print $sqlfleta;
				$exefleta = mysqli_query($link,$sqlfleta);
				$datosfleta = mysqli_fetch_array($exefleta);

				}


			}



}
$otm='';
$terrestre='';
$devolucion='';
$escolta='';
$seguro='';
$aduana='';
$bodega='';
if($datosmod['otm']==1){
$otm="SI";
}
else{
$otm="NO";
}

if($datosmod['terrestre']==1){
$terrestre="SI";
}
else{
$terrestre="NO";
}
if($datosmod['devolucion']==1){
$devolucion="SI";
}
else{
$devolucion="NO";
}
if($datosmod['escolta']==1){
$escolta="SI";
}
else{
$escolta="NO";
}
if($datosmod['seguro']==1){
$seguro="SI";
}else{
$seguro="NO";
}
if($datosmod['aduana']==1){
$aduana="SI";
}else{
$aduana="NO";
}
if($datosmod['bodega']==1){
$bodega="SI";
}else{
$bodega="NO";
}

$msg = "<html>
<head>
<meta content='text/html; charset=ISO-8859-1'
http-equiv='content-type'>
<title></title>
</head>
<body>
<table class='mceItemTable' align='center' width='100%'>
<tbody>
<tr>
<td class='subtitseccion' style='text-align: center;'
mce_style='text-align:center'><b><br>
SE HA NOTIFICADO EL REPORTE DE NEGOCIO ".$numero." A OPERACIONES</b><br>
<br>
Nombre del Cliente: ".$nomcliente." ".$apecliente." <br>
Comercial: ".$nomcomercial ." - ". $email_comercial."<br>
Operativo: ".$nomoperativo ." - ".$email."
</td>
</tr>
</tbody>
</table>
<p><br>
</p>
<table style='width: 776px; height: 136px;' align='center' border='1'>
<tbody>
<tr>
<td class='tittabla' style='text-align: center;'
mce_style='text-align:center' colspan='9' bgcolor='#ff6600'><b>NOTIFICACION<br>
</b></td>
</tr>

".$columnas."



<tr>
<td colspan='9' style='vertical-align: top;'><span
style='font-weight: bold;'>Operaciones</span><br>
</td>
</tr>
<tr>
<td style='vertical-align: top;'>Bodega</td>

<td style='vertical-align: top;'>Otm<br>
</td>
<td style='vertical-align: top;'>Terrestre<br>
</td>
<td style='vertical-align: top;'>Devolucion<br>
</td>
<td style='vertical-align: top;'>Escolta<br>
</td>
<td style='vertical-align: top;'>Seguro<br>
</td>
<td style='vertical-align: top;'>Aduanda<br>
</td>
</tr>
<tr>
<td style='vertical-align: top;'>".$bodega."
</td>
<td style='vertical-align: top;'>".$otm."<br>
</td>
<td style='vertical-align: top;'>".$terrestre."<br>
</td>
<td style='vertical-align: top;'>".$devolucion."<br>
</td>
<td style='vertical-align: top;'>".$escolta."<br>
</td>
<td style='vertical-align: top;'>".$seguro."<br>
</td>
<td style='vertical-align: top;'>".$aduana."<br>
</td>
</tr>
</tbody>
</table>
<p><br>
</p>
<br>
<br>
</body>
</html>";



//logo---------------------------------------------------------------------------------------------------------------------------



$mail->Subject = $subject;
$mail->Body = $msg;
$mail->AltBody = " ";
/*
if($_GET['destino']!='')
{
	$mails = explode(',', $_GET['destino']);

	//print_r($mails);
	//print count($mails);
	for($g=0; $g<count($mails); $g++)
	{
		//$mail->AddAddress("$mails[$g]","");
	}
}*/
//$mail->AddAddress("mbandres4@gmail.com","");




/*print 'idcot_temp '.$_GET['idcot_temp'].'<br>';
print 'idcliente '.$idcliente.'<br>';
print 'idcustomer '.$idcustomer.'<br>';
print 'email '.$email.'<br>';*/

$mail->AddAddress($email,"");
$mail->AddAddress($email_comercial,"");
//$mail->AddAddress("manager@gatewaysolutions.com.co","");
//$mail->AddAddress("oper3@gatewaysolutions.com.co","");
if($mail->Send())
{
	?>
	<script>alert("La notificacion ha sido enviada a <? print $email.', '.$email_comercial; ?>");</script>
	<?
}
else
{
	?>
	<script>alert("La notificacion no pudo ser enviada a <? print $email.', '.$email_comercial; ?>");</script>
	<?
}
$mail->ClearAddresses();
?>
