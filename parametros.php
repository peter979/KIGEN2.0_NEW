<?
include("conection/conectar.php");

if($_GET["opc"] =="save"){

	$x=0;
	
	if(!mysqli_query("delete from parametros") ){
		echo "<script>alert('No se pudo eliminar tabla, contacte al administrador')</script>";
		die();
	}else{
		foreach($_POST["valor"] as $result){
			$sql = "insert into parametros (nombre,valor) values ('".$_POST["nombre"][$x]."','".$_POST["valor"][$x]."')";
			if(!mysqli_query($sql)){
				echo "Un registro no se almaceno, contacte al administrador";
				die();
			}
			$x++;
			
		}
		echo "<script>alert('Edito');window.location='parametros.php'</script>";
	}

}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		elements : "contenido",
		theme : "simple",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,media,searchreplace,print,contextmenu,paste,directionality,fullscreen"});

	
</script>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/general.css" rel="stylesheet" type="text/css" />
<link href="css/admin_internas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form  name="form1" method="post" action="?opc=save" id="contenido">
  <table align="center">
    <tr>
      <td class="tittabla" bgcolor='#FF6600' style='text-align:center' colspan="2">EDICION DE PARAMETROS </td>
    </tr>
	<?  $parSql = mysqli_query("select * from parametros");
	$x=1;
					while( $parametro = mysqli_fetch_array($parSql) ){?>
    <tr>
      <td class="contenidotab"><? echo $parametro["nombre"]?></td>
      <td><input type="hidden" name="nombre[]" value="<? echo $parametro["nombre"]?>" />
        <textarea name="valor[]" ><? echo $parametro["valor"]?> </textarea></td>
    </tr>
	<?
		$x++;
		} 
	?>
    <tr>
      <td width="60" class="contenidotab"><input name="Submit" type="submit" class="botonesadmin" value="Guardar" /></td>
      <td class="contenidotab">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
