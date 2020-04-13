<?
include_once('./sesion/sesion.php');
include("./conection/conectar.php");	
include_once("./permite.php");
include_once("scripts/recover_nombre.php");
include('scripts/scripts.php');

?>
<html>
<head>
	<link href="./css/admin_internas.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="./js/jquery.js"></script>
	<script type="text/javascript" src="./js/funciones.js"></script>
	
</head>
	<body>
		<p></p><p></p>
		<h3 class="subtitseccion">Reporte de documentos vencidos</h3>
		<p></p><p></p>
		<form method="post" action="">
			<!--Tabla de filtros-->
			<table align="center" cellpadding="7" class="contenidotab">
				<tr>
					<td colspan="4" class="tittabla">Fecha de Vencimiento</td>
				</tr>
				<tr>
					<td>Desde:</td>
					<td>
					<input id="desde" name="desde" value="<? echo $_POST['desde'] ?>" size="7" onClick="return showCalendar('desde');" readonly  required>
													
					</td>
					<td>Hasta</td><td><input id="hasta" name="hasta" value="<? echo $_POST['hasta'] ?>" size="7" onClick="return showCalendar('hasta');" readonly required ></td>
				</tr>
				<tr><td colspan="4" align="center"><input type="submit" value="Buscar" class="botonesadmin" /> </td></tr>
			</table>
		</form>
		<?
		$sql = "select doc.fecha_vencimiento as vencimiento,clientes.nombre as cliente,documentos.nombre as documento from clientes_has_documentos as doc
				inner join clientes on doc.idcliente = clientes.idcliente
				inner join documentos on doc.iddocumento = documentos.iddocumento
				where doc.fecha_vencimiento >= '".$_POST['desde']."' and doc.fecha_vencimiento <= '".$_POST['hasta']."'";
		if(!$qrySql = mysqli_query($link,$sql))
			echo "<p>No consult� <br>.".mysqli_error()."$sql</p>";

		?>

		<table cellpadding="6" class="contenidotab" align="center">
			<tr class="tittabla">
				<td>Cliente</td>
				<td>Documento</td>
				<td>Fecha de Vencimiento</td>
			</tr>
			<? while ( $documentos = mysqli_fetch_array($qrySql) ){?>
				<tr bgcolor="<? echo ($color == "#CCCCCC") ? $color = "#FFFFFF" : $color = "#CCCCCC" ?>">
					<td><? echo $documentos["cliente"]?></td>
					<td><? echo $documentos["documento"]?></td>
					<td><? echo $documentos["vencimiento"]?></td>
				</tr>
			
			<?
			}
			?>
		</table>
	</body>
</html>