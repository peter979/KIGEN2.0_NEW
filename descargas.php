<?
echo "prueba";
session_name("current");
session_register("idusuario");
include("conection/conectar.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kigen</title>
<link href="todo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(images/fondoSite.jpg);
	background-repeat: repeat-x;
	background-color: #EF4E30;
}
-->
</style>
<script>
function validaenvia(form)
{
	if(form.user.value!="" & form.pass.value!="")
	{
		form.dele.value="si";
		form.submit();
	}
	else
		alert('Digite su nombre de usuario y contrasena');

}
</script>
<script src="scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>
<body>
<div align="center">
  <table width="634" border="0" cellpadding="0" cellspacing="0">
    <!--DWLayoutTable-->
    <tr>
      <td height="257" colspan="3" valign="top"><script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','974','height','257','src','swf/top','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','swf/top' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="974" height="257">
        <param name="movie" value="swf/top.swf" />
        <param name="quality" value="high" />
        <embed src="swf/top.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="974" height="257"></embed>
      </object></noscript></td>
    </tr>
    <tr>
      <td width="9" height="586" valign="top"><script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','9','height','586','src','swf/lateralIzq','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','wmode','transparent','movie','swf/lateralIzq' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="9" height="586">
          <param name="movie" value="swf/lateralIzq.swf" />
          <param name="quality" value="high" />
          <param name="wmode" value="transparent" />
          <embed src="swf/lateralIzq.swf" width="9" height="586" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent"></embed>
      </object></noscript></td>
      <td width="951" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="marcos">
        <!--DWLayoutTable-->
        <tr>
          <td width="413" height="568" valign="top" class="zonaTexto">

<!---------------------------------------------------------------------------------------------------->
<form name="formulario" action="descargas.php" method="post">
<input type="hidden" name="dele" value="no" />
<table width="750" height="174" border="0" align="center" cellpadding="9" cellspacing="0">
  <!--<tr>
    <td colspan="2" bgcolor="#CC6600"><p class="style27"><a href="../../../index.html"><img src="/public_html/html/images/logos/logosolo.jpg" width="60" height="58" border="0" /></a></p>
      <span class="style3">GATEWAY SOLUTIONS<br />
    </span><span class="style4">AGENTES DE CARGA INTERNACIONAL</span></td>
  </tr>
  <tr>
    <td width="635" height="8" bgcolor="#063052"><span class="style45"><a href="nosotros.html">Nosotros</a> |
        <a href="servicios_aire.html">Servicios</a> | <a href="consolidados.html">Consolidados
        Mar&iacute;timos</a>  | <a href="colombia.html">Colombia</a> |
    <a href="herramientas.html">Herramientas</a><a href="file:///Macintosh HD/Applications/nobarahayakawa/Sites/bemel/public_html/html/ESP/herramientas.html"> | </a>Cont&aacute;ctenos | <a href="condiciones.html">Condiciones Generales </a></span></td>
    <td width="29" align="right" bgcolor="#063052"><a href="../ENG/downloads.php"><img src="../images/botones/en_flag.jpg" width="20" height="13" border="0" /></a></td>
  </tr>-->
  <tr>
    <td height="9" colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td height="17" colspan="2" >
	<table width="80%" height="268" border="0" align="center" cellpadding="8" cellspacing="0" >
      <tr>
        <td width="51%" align="left" valign="top">
		<table align="center" border="0" width="100%">
				<tr><td><p class="style17">ZONA DE CLIENTES</p></td>
				<td class="style20" align="right"><? if($_SESSION["idusuario"]!="" or $_POST['dele']=="si") {?> <a href="cerrar.php"><strong>Cerrar sesi&oacute;n</strong></a><? }?></td></tr>
			</table>

<?
if($_SESSION["idusuario"]!="" or $_POST['dele']=="si")
{
$user=$_POST["user"];
$passw=$_POST["pass"];
//print "user $_POST[user]<br>pass $_POST[pass]";
/*$db="gateway";
$link=mysqli_connect("ifx-nt1.toservers.com,2434","bemel","admin");
mysqli_select_db($db);*/


//$encry="select HashBytes('MD5', '$_POST[pass]') as pass";
//$exe_encry=mysqli_query($link,$encry);
//$uno=mysqli_fetch_array($exe_encry);
//$var=$uno['pass'];
$var=$_POST["pass"];


$sql="select * FROM clientes WHERE usuario like '$user' AND pass like '$var'";
//print $sql;

if($_SESSION["idusuario"]!="")
	$sql="select * FROM clientes WHERE idusuarios ='$_SESSION[idusuario]'";

//print $sql;
$exe=mysqli_query($link,$sql);
$num=mysqli_num_rows($exe);
	if($num==0)
	{
		?>
			<script type='text/javascript'>
				alert("Acceso negado");
				document.location.href="descargas.php";
			</script>
		<?
	}
	if($num==1)
	{
	$j=1;
		$row=mysqli_fetch_array($exe);
		$_SESSION["idusuario"] = $row["idusuarios"];
		$dow="select * from documentos_desc where id='$row[idusuarios]'";

		$exe_dow=mysqli_query($link,$dow);

		print "<center class='style17'>Bienvenido $row[nombre] [$row[usuario]]</center>";

		print "<br><table align=\"center\" border=\"0\" width=\"90%\">";
		print "<tr align='center'>
		<td class=\"style22\" bgcolor='#CCCCCC'><strong>No.</strong></td>
		<td class=\"style22\" bgcolor='#CCCCCC'><strong>Archivo</strong></td>
		<td class=\"style22\" bgcolor='#CCCCCC'><strong>Descripci&oacute;n</strong></td>
		<td class=\"style22\" bgcolor='#CCCCCC'><strong>Fecha Ingreso</strong></td>
		<td>&nbsp;</td>
		</tr>";
		while($peta=mysqli_fetch_array($exe_dow))
		{
		$saca=explode(" ",$peta[fecha]);
				print "<tr><td class=\"style22\" align='center' bgcolor='#E8E8E8'>$j</td><td class=\"style48\" bgcolor='#E8E8E8'><a href=\"./file/$peta[doc]\" target=\"_blank\"  style=\"color:#333333\" title=\"Click derecho, &apos;Guardar enlace como...&apos;\"><strong>$peta[doc]</strong></a></td><td class=\"style22\" bgcolor='#E8E8E8'>$peta[descr]</td><td class=\"style22\" bgcolor='#E8E8E8'>$saca[0] $saca[1] $saca[2]</td><td class=\"style22\" align='center'><a href=\"./file/$peta[doc]\" target='_blank' title=\"Click derecho, &apos;Guardar enlace como...&apos;\"><img src='images.jpg' width='30' height='30' border='0' /></a></td></tr>";
			$j++;
		}
		print "</table>";
		//print "scai ".$_SESSION["idusuario"];

	}

}
if($_SESSION["idusuario"]=="")
{
//print "ajajaja ".$_SESSION["idusuario"];
?>

			<table align="center" border="0" width="80%">
				<tr>
					<td class="style22"><strong>Nombre de usuario:</strong></td><td><input type="text" value="@gateway.com.co" name="user" id="user" maxlength="70" class="style14" /></td>
				</tr>
				<tr>
					<td class="style22"><strong>Contrase&ntilde;a:</strong></td><td><input type="password" value="" name="pass" id="pass" maxlength="40" class="style14" /></td>
				</tr>
				<tr><td colspan="2" align="center"><input type="button" name="acepto" value="Ingresar" class="style22" onclick="validaenvia(formulario)" /></td></tr>
			</table>

<?
}

?>


</td>
     </tr>

    </table></td>
  </tr>
  <!--<tr>
    <td height="17" colspan="2" bgcolor="#FFFFFF"><p class="style25"><img src="../images/logos/logobasc100.gif" width="100" height="87" /></p>
      <p class="style25">ALL RIGHTS
        RESERVED  GATEWAY SOLUTIONS
        S.A. 2010</p></td>
  </tr>-->
</table>
</form>
<!---------------------------------------------------------------------------------------------------->

			</td>
      	</tr>
      </table></td>
      <td width="14" valign="top"><script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','14','height','586','src','swf/lateralDer','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','wmode','transparent','movie','swf/lateralDer' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="14" height="586">
          <param name="movie" value="swf/lateralDer.swf" />
          <param name="quality" value="high" />
        <param name="wmode" value="transparent" />
          <embed src="swf/lateralDer.swf" width="14" height="586" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent"></embed>
      </object></noscript></td>
    </tr>



    <tr>
      <td height="80" colspan="3" valign="top">
        <div align="center">
          <script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','974','height','90','src','swf/bottom','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','wmode','transparent','movie','swf/bottom' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="974" height="90">
            <param name="movie" value="swf/bottom.swf" />
            <param name="quality" value="high" />
            <param name="wmode" value="transparent" />
            <embed src="swf/bottom.swf" width="974" height="90" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent"></embed>
          </object></noscript>
          <br />
          <a href="http://www.ricardobarona.com" target="_blank"><img src="images/fondorbd.png" width="108" height="13" border="0" /></a><br />
          <br />
        </div></td>
    </tr>
  </table>
</div>
</body>
</html>
