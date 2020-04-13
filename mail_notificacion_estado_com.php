<?


include('sesion/sesion.php');
include('conection/conectar.php');
require("phpmailer/class.phpmailer.php");
include_once("scripts/recover_nombre.php");



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


if($desde='operativo'){
$numero = scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero");
$idcliente = scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "idcliente");
}
else{
$idcliente= $_GET['idcliente'];
}

$nomcliente = scai_get_name("$_GET[idcliente]", "clientes", "idcliente", "nombre");
$apecliente = scai_get_name("$_GET[idcliente]", "clientes", "idcliente", "apellido");


$idoperativo = scai_get_name("$_GET[idcliente]", "clientes", "idcliente", "idoperativo");
$email = scai_get_name("$idoperativo", "vendedores_customer", "idvendedor_customer", "email");
$nomoperativo=scai_get_name("$idoperativo", "vendedores_customer", "idvendedor_customer", "nombre");
$idcomercial = scai_get_name("$_GET[idcliente]", "clientes", "idcliente", "idcustomer");
$email_comercial = scai_get_name("$idcomercial", "vendedores_customer", "idvendedor_customer", "email");
$nomcomercial=scai_get_name("$idcomercial", "vendedores_customer", "idvendedor_customer", "nombre");
$numeroorden='';
$titulo='';

if($_POST['number']!='') $numeroorden=$_POST['number']; else $numeroorden= $datosre['number'];
$titulo="SE HAN AGREGADO ESTADOS AL SIGUIENTE REPORTE DE ESTADO";

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
mce_style='text-align:center'><b><br>".$titulo." </b><br>
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
mce_style='text-align:center' colspan='9' bgcolor='#ff6600'><b>NOTIFICACI&Oacute;N<br>
</b></td>
</tr>

<tr>
<td>
N&uacute;mero de orden
</td>
<td>
".$numeroorden."
</td>
</tr>
<tr>
<td class='tittabla' style='text-align: center;'
mce_style='text-align:center' colspan='9' bgcolor='#ff6600'>
<b>ESTADOS</b>
</td>
</tr>
<tr>
<td>
<b>Fecha / Hora</b>
</td>
<td>
<b>Estado</b>
</td>
</tr>
".$estadosreportados."


</tbody>
</table>
<p><br>
</p>
<br>
<br>
</body>
</html>";



//logo---------------------------------------------------------------------------------------------------------------------------

$subject="NOTIFICACION REPORTE DE ESTADO $_GET[idcot_temp]   / Cliente: $nomcliente $apecliente    / Order Number: $numeroorden";

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
//$mail->AddAddress("cvn.desarrollador1@gmail.com","");




//print 'idcot_temp '.$_GET['idcot_temp'].'<br>';
//print 'idcliente '.$idcliente.'<br>';
//print 'idcustomer '.$idcustomer.'<br>';
//print 'email '.$email.'<br>';

$mail->AddAddress($email,"");
$mail->AddAddress($email_comercial,"");
$mail->AddAddress("fernandocortes@civilnet.co","");
$mail->Send();
$mail->ClearAddresses();
?>
