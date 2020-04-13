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
	$sqldel = "delete from rn_bodegas where idreporte='$_GET[idcot_temp]'";
	//print $sqldel.'<br>';
	$exedel = mysqli_query($link,$sqldel);
	
	if(isset($_POST['selbg']))
	{
		foreach($_POST['selbg'] as $id)
		{
			$advaloren_venta = $_POST['advaloren_venta'.$id];
			$min_advaloren = $_POST['min_advaloren'.$id];
			$mes_fraccion_venta = $_POST['mes_fraccion_venta'.$id];
			$min_mes_fraccion = $_POST['min_mes_fraccion'.$id];
			$mes_fraccion_40_venta = $_POST['mes_fraccion_40_venta'.$id];
			
			$sql = "select idcot_bodega from cot_bodegas where idbodega='$id' and idcot_temp='$_GET[idcot_temp]'";
			$exe = mysqli_query($link,$sql);
			$datos = mysqli_fetch_array($exe);
				
			if($_GET['cl']=='fcl')
			{
				$queryins="INSERT INTO rn_bodegas (idcot_bodega, idreporte, advaloren_venta, min_advaloren, mes_fraccion_venta, mes_fraccion_40_venta, condiciones) VALUES('$datos[idcot_bodega]', '$_GET[idcot_temp]', '$advaloren_venta', '$min_advaloren', '$mes_fraccion_venta', '$mes_fraccion_40_venta', '$_POST[condiciones_bg]')";
			}
			elseif($_GET['cl']=='lcl' || $_GET['cl']=='aereo')
			{
				$queryins="INSERT INTO rn_bodegas (idcot_bodega, idreporte, advaloren_venta, min_advaloren, mes_fraccion_venta, min_mes_fraccion, condiciones) VALUES('$datos[idcot_bodega]', '$_GET[idcot_temp]', '$advaloren_venta', '$min_advaloren', '$mes_fraccion_venta', '$min_mes_fraccion', '$_POST[condiciones_bg]')";
			}			
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
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
        <td class="subtitseccion" style="text-align:center" >BODEGA COTIZACI&Oacute;N <? print scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero"); ?><br><br></td>
    </tr>
</table>
<?
include("rn_search_bodega.php");
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
