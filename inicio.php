<?php
	include('sesion/sesion.php');
	include("conection/conectar.php");
	include_once("permite.php");

	$iden=$_SESSION['numberid'];
	$login=$_SESSION['nick'];
	$perfil=$_SESSION['perfil'];

?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Kigen:.</title>
<link rel="SHORTCUT ICON" href="../images/logo.jpg">
<script src="scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css">
<script src="scripts/swfobject_modified.js" type="text/javascript"></script>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<style>

.toptablas {
    /*    background-image: url(images/fondoSite.jpg);*/
	background-position:top;
	font-size:11px;

	text-align:left;
	padding-left:5px;
}

body {
	margin-left: 0px;
	margin-top: 0px;
	overflow: auto;
        font-family: 'Montserrat', serif;

}
</style>
</head>
<body onLoad="ver()">

<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr>
        <td width="15" valign="top">&nbsp;</td>
<!--COLOR DE TABLA CENTRAL-->
        <td width="100%" valign="top" bgcolor="#FFFFFF">
    		<table width="100%" border="0" cellspacing="0" cellpadding="0">
    			<tr>
                    <td width="100%" valign="top">
   			<table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                           	<td  class="toptablas"><?
					if($_SESSION['numberid']!="")
							include("menu_sobre.php");
					if($_GET['vs']=='operativo')
						include('erpoperativo/menu_operativo.php');
					elseif($_GET['vs']=='crm')
						include('erpcrm/menu_crm.php');
					else
						include('menu.php');?>
				</td>
                            </tr>
                            <tr>
                            	<td><!--<img src="images/img_inf_tabla_menu.jpg" width="178" height="7">--></td>
                            </tr>
   						</table>
    				</td>
   				</tr>
   				<tr>
    			<td width="100%" align="center" valign="top">
				<?

				if($_GET['idcliente']=='')
				{
					if($_GET['vs']=='operativo')
						$ruta='erpoperativo/op_ppal.php';
					else
						$ruta='ppal.php';
				}
				elseif($_GET['idcliente']!='')
					$ruta='clientes.php?idcliente='.$_GET['idcliente'];
				?>
    				<iframe src="<? print $ruta; ?>" name="ppal" width="100%" height="550" allowtransparency="yes" scrolling="auto" frameborder="0" id="ppal"> [Su explorador no soporta marcos, por favor contacte a su webmaster.] </iframe>
    			</td>
    		</tr>
    	</table>
    </td>
    <tr>
    	<td width="15" valign="top">&nbsp;</td>

</table>
<table width="766" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr>
        <td colspan="2" align="center" valign="middle" class="barnavinf">
        	<table width="234" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="81" style="font-size:10px; color:#FFFFFF" class="tex4">Powered by:&nbsp;</td>
                    <td width="2" class="tex7"><a href="http://www.civilnet.com.co" target="_blank"><img src="images/civil.png" aling="center"></a>
                </tr>
       		</table>
        </td>
	</tr>

</table>
<br /><br /><br />
</body>
</html>
<script>

var txt="... Powered by Civilnet Ingenieria Ltda ... "
function ver()
{
   window.status = txt;
   txt = txt.substring(1, txt.length) + txt.charAt(0);
   window.setTimeout("ver()",150);
}
function winbackex(URL)
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=no,location=0,screenX=250,screenY=100,statusbar=no,menubar=0,resizable=0,width=700,height=500');");
}
</script>
