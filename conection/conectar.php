<?
$db="appkigen_test";

//$link=civilnet_gateway("","admin");
//$link=mysqli_connect("localhost","appkigen_dev","uW?O%,3N^Rzy");//Se conecta con usuario de produccion
$link=mysqli_connect("localhost","root","");//Se conecta con usuario de produccion

if(!$link){
	print "<br>Error al conectar con el servidor";die();
}if(!mysqli_select_db($link,$db))
	print "<br>Error en la conexion con la base de datos";

//mysqli_query ("SET NAMES 'utf8'");
date_default_timezone_set("America/Bogota");


//Configuracion de email
 $host_envios="mail.appkigen.co";
 $email_envios="kigen@appkigen.co";
 $email_real="kigen@appkigen.co";
 $password_envios="SmND(QX.d8&";
 $secure="ssl";
 $port=465;


?>
