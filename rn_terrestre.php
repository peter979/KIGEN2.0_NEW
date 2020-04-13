<? 
include('./sesion/sesion.php');
include("./conection/conectar.php");	
include_once("./permite.php");
include_once("scripts/recover_nombre.php");
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="./css/admin_internas.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/funciones.js"></script>
<script type="text/javascript" src="./js/funcionesValida.js"></script>

<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/main.js"></script>
<script type="text/javascript" src="./js/shadowbox-base.js"></script>
<script type="text/javascript" src="./js/shadowbox.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.1.pack.js" ></script>
<script>
function validaEnvia(form)
{
	form.datosok.value="si";
	//alert(form.datosok.value);
	form.submit()
}
</script>
<? 
$_GET['cl'] = scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "clasificacion");

if($_POST['datosok']=='si')
{
	$sqldelterrestre = "delete from rn_terrestre where idreporte='$_GET[idcot_temp]'";
	//print $sqldel.'<br>';
	$exedelterrestre = mysql_query($sqldelterrestre, $link);
	
	if(isset($_POST['selterrestre']))
	{
		foreach($_POST['selterrestre'] as $id)
		{
			$selterrestre_dev = $_POST['selterrestre_dev'.$id];
			$selterrestre_esc = $_POST['selterrestre_esc'.$id];			
			$valor_venta = $_POST['venta_terrestre'.$id];
			
			$sql = "select idcot_terrestre from cot_terrestre where idterrestre='$id' and idcot_temp='$_GET[idcot_temp]'";
			$exe = mysql_query($sql, $link);
			$datos = mysql_fetch_array($exe);
			
			$queryins="INSERT INTO rn_terrestre (idcot_terrestre, idreporte, valor_venta, condiciones, documentacion, devolucion, escolta) VALUES('$datos[idcot_terrestre]', '$_GET[idcot_temp]', '$valor_venta', '$_POST[condiciones_terrestre]', '$_POST[doc_req]', '$selterrestre_dev', '$selterrestre_esc')";
			//print $queryins.'<br>';
			$buscarins=mysql_query($queryins,$link);
		}
	}
	if(!$buscarins)
			print ("<script>alert('No se pudo guardar el registro')</script>");
		else
			print "<script>alert('El registro ha sido guardado satisfactoriamente')</script>";
}
?>
<form name="formulario" id="formulario" method="post">
<input name="datosok" type="hidden" value="no" />
<table width="100%" align="center">
    <tr>
        <td class="subtitseccion" style="text-align:center" >CARGA NACIONALIZADA COTIZACI&Oacute;N <? print scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero"); ?><br><br></td>
    </tr>
</table>
<?
include("rn_search_terrestre.php");
?>
<table>
	<tr>
        <td colspan="5" align="left">
            <table>
                <tr>
                	<td width="60" class="botonesadmin"><a href="modalidades.php?idcot_temp=<? print $_GET['idcot_temp']; ?>" onClick="">Atras</a></td>
                	<? if(puedo("c","REPORTES_NEGOCIO")==1 || puedo("m","REPORTES_NEGOCIO")==1) { ?>
                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
                    <? } ?>
                </tr>
            </table> 
        </td>        	
    </tr>
</table>
</form>
