<?php

	//include('sesion/sesion.php');
	
	include("conection/conectar.php");	

	include_once("permite.php");
	
	$iden=$_SESSION['numberid'];
	$login=$_SESSION['nick'];
	$perfil=$_SESSION['perfil'];

?>
<link href="css/admin_internas.css" rel="stylesheet" type="text/css">
<body><!--  onLoad="mueveReloj()"-->
<!--TABLAS DE PANTALLA INICIAL MUESTRA LAS ALERTAS-->
<table align="center" border="0" width="100%">
<tr>
<td>
			<table align="center" width="100%" border="0">
				<tr><td align="center">Alertas de Cumplea&ntilde;os</td></tr>
				<tr>
					<td align="center">
						<iframe name="dele" src="notas.php?al=cumple" width="100%" height="100" frameborder="0" scrolling="no">
						[Su navegador no soporta iframes, contacte a su webmaster.]
						</iframe>
					</td>
				</tr>
			</table>
</td>
<td>
			<table align="center" width="100%" border="0">
				<tr><td align="center">Alertas de Vencimientos de tarifas</td></tr>
				<tr>
					<td align="center">
						<iframe name="dele" src="notas.php?al=vence" width="100%" height="100" frameborder="0" scrolling="no">
						[Su navegador no soporta iframes, contacte a su webmaster.]
						</iframe>
					</td>
				</tr>
			</table>
</td>
<td>
			<table align="center" width="100%" border="0">
				<tr><td align="center">Alertas de Vencimientos de documentos</td></tr>
				<tr>
					<td align="center">
						<iframe name="dele" src="notas.php?al=doc" width="100%" height="100" frameborder="0" scrolling="no">
						[Su navegador no soporta iframes, contacte a su webmaster.]
						</iframe>
					</td>
				</tr>
			</table>
</td>
<? 
die();
include('alertas_comercial.php'); ?>
</table>	
</body>