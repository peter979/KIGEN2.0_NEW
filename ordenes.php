<?php
	// Paises
	
	include('./sesion/sesion.php');
	include("./conection/conectar.php");	
	include_once("scripts/recover_nombre.php");
	$texto = $_GET["texto"];
	
	$idcl=scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "idcliente");
	$sqlmuestra="select number from reporte_estado_cli where idcliente=$idcl and number like '%$texto%'";
	$exemuestra=mysqli_query($link,$sqlmuestra);
	//print $sqlmuestra;


	// Devuelvo el XML con la palabra que mostramos (con los '_') y si hay éxito o no
	$xml  = '<?xml version="1.0" standalone="yes"?>';
	$xml .= '<datos>';
	while($datos=mysqli_fetch_array($exemuestra)){
	$xml .= '<pais>'.$datos['number'].'</pais>';
		
	}
	$xml .= '</datos>';
	header('Content-type: text/xml');
	echo $xml;		
?>
