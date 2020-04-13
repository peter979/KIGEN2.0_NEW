<?php
session_start();
/*if(!isset($_SESSION['numberid']))
	$_SESSION['numberid'] = '';
if(!isset($_SESSION['nick']))
	$_SESSION['nick'] = '';
if(!isset($_SESSION['perfil']))
	$_SESSION['perfil'] = '';*/
?>
<HTML>
<head>
<title></title>
<link rel="SHORTCUT ICON" href="../images/logo.jpg">
<link href="../css/site.css" rel="stylesheet" type="text/css" />
<link href="../css/ap.css" rel="stylesheet" type="text/css" />
<link href="css/admin_internas.css" rel="stylesheet" type="text/css">
<script src="js/funcionesValida.js" type="text/javascript"></script>
</head>
<script>
function validaEnvia(form){
	//if (validarSelec('version', 'Por favor seleccione la version') == false) return false;
	form.submit()
}
</script>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background:url(img/back_gral.gif)  repeat-x;
/*	background-color:#efefdd;*/
}-->
</style>

<?php
if(!$_POST["dele"]){
	if(isset($HTTP_COOKIE_VARS["nada"])){
		?>
		<script type='text/javascript'>
			document.location.href="auten.php"
		</script>
		<?php
	}

	?>
	<body bgcolor="#ffffff" oncontextmenu="return false;" onmousemove="movLay(event)">
<style type="text/css">
div.lay
{
	position: absolute;
}
div.casca
{
	width: 10%%;
	height: 20px;
	background-image:url(../images/barra.jpg);
	background-repeat:no-repeat;
	background-position:center;
	cursor: move;
}
</style>
<script type="text/javascript" src="../scripts/move.js"></script>
<br><br><br>

<form name="formulario" method="post" action="auten.php" style="background-image:url(../img/bg_1.jpg)">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
<!--        <td height="4" bgcolor="#696868"></td>-->
      </tr>
      <tr>
        <td height="4" bgcolor="#a01313"></td>
      </tr>
</table>

	<br>
<table width="30%" border="1" cellspacing="1" cellpadding="0" align="center">
            <tr>
              <td height="105" align="center" valign="middle">
			  <table width="88%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="24%" class="tex6" style="padding-top:10px; font-size:12px;">Usuario:</td>
                  <td width="70%" align="center">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="user" type="text" class="tex6" id="user" size="30" onFocus="if(this.value=='Ingresa usuario') this.value='';" onBlur="if(this.value=='') this.value='Ingresa usuario';" value="Ingresa usuario" />
                  </td>
                </tr>
                <tr>
                  <td class="tex6" style="padding-top:10px; font-size:12px;">Contrase&ntilde;a:</td>
                  <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="passw" type="password" class="tex6" id="Ingrese passw" size="30" onFocus="if(this.value=='Ingresa contrase�a') this.value='';" onBlur="if(this.value=='') this.value='Ingrese contrase�a';" value="Ingrese contrase�a" /></td>
                </tr>
				<tr><td colspan="2">&nbsp;</td></tr>
                <tr>
                	<td width="24%" class="tex6" style="padding-top:10px; font-size:12px;">beta Version:</td>
                    <td width="70%" align="center">&nbsp;&nbsp;&nbsp;&nbsp;
                    <select id="version" name="version">
                    <option value="comercial" selected >Comercial</option>
                    <option value="operativo" <? if($_POST['version']=='operativo') print 'selected'; ?> >Operativo</option>
                    <option value="crm" <? if($_POST['version']=='crm') print 'selected'; ?> >Agenda</option>
                    </select>
                    </td>
                </tr>
                <tr>

                      <td height="20" valign="middle" colspan="2" align="center">
					  	<table width="40%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td align="center" nowrap="nowrap">
								  <input name="dele" type="submit" class="botonesadmin" style="color:#FFFFFF;" value="Entrar"  onClick="validaEnvia(formulario)" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  <input type="reset" class="botonesadmin" value="Limpiar" style="color:#FFFFFF;">
								</td>
							</tr>
						</table>
					</td>
    	      </tr>
		</table>
	</td>
</tr>
<tr></tr>
</table>
<br>

<br>
<table width="766" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
  <!---<td height="60" colspan="2" align="center" valign="middle" class="tex7" >&copy; 2009 - 2011 All rights reserved<br></td>--->
	<td height="60" colspan="2" align="center" valign="middle" class="barnavinf">
	<table width="234" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="81" style="font-size:10px; color:#666666" class="tex4">Powered by:&nbsp;&nbsp;&nbsp;</td>
        <td width="153" class="tex7"><a href="http://www.civilnet.com.co" target="_blank"><img src="images/civil.png" aling="center"></a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
       <tr>
 <!--       <td height="4" bgcolor="#696868"></td>-->
      </tr>
      <tr>
        <td height="4" bgcolor="#a01313"></td>
      </tr>
</table>
</form>
<p><strong>Para una mejor experiencia recomendamos usar Mozilla Firefox.</strong></p>

</body>
</HTML>
<?php
}
if(isset($_POST["dele"]) && $_POST["dele"]=="Entrar"){
include("conection/conectar.php");
$user=$_POST["user"];
$passw=$_POST["passw"];

	$sqlas="SELECT idusuario, idperfil, login FROM usuarios WHERE login='$user' AND pass=MD5('$passw') AND estado='1'";
	$canas=mysqli_query($link,$sqlas);
	$t=mysqli_num_rows($canas);
	if($t==0){
		?>
			<script type='text/javascript'>
				alert("Acceso negado");
				document.location.href="index.php";
			</script>
		<?
	}
	if($t==1){

		$row = mysqli_fetch_array($canas);
		$_SESSION['numberid'] = $row['idusuario'];
		$_SESSION['nick'] = $row['login'];
		$_SESSION['perfil'] = $row['idperfil'];
		/*print_r($_SESSION);
		die;*/
		//$hoy=date('Y-n-d G:i:s');
		$restriccion = 'no';
		include_once("permite.php");
		/*
		Este fragmento era para generar un log de eventos pero no se termina
		if(($_POST['version']=='comercial' && puedo("l","COMERCIAL")==0) || ($_POST['version']=='operativo' && puedo("l","OPERATIVO")==0) || ($_POST['version']=='crm' && puedo("l","AGENDA")==0))
			$restriccion = 'si';
		if($restriccion=='si'){
			?>
			<script type='text/javascript'>
				alert("Acceso negado para este modulo");
				<? if(file_exists("./erpcrm/agenda/auth/process.php")) { ?>
					document.location.href = "./erpcrm/agenda/auth/process.php";
				<? } else { ?>
					document.location.href = "sesion/cerrar.php";
				<? } ?>
			</script>
			<?
		}
		else{
			//header("Location: index.php?vs=".$_POST['version']);
			?>
			<script type='text/javascript'>
				document.location.href="index.php?vs=<? print $_POST['version']; ?>";
			</script>
			<?
		}
		*/
		?>
			<script type='text/javascript'>
				document.location.href="index.php?vs=<? print $_POST['version']; ?>";
			</script>

		<?
	}
}
?>
