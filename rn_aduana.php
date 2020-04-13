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
	$sqldel = "delete from rn_adu where idreporte='$_GET[idcot_temp]'";
	//print $sqldel.'<br>';
	$exedel = mysqli_query($link,$sqldel);
	
	if(isset($_POST['seladu']))
	{	
		foreach($_POST['seladu'] as $id)
		{
			$pc = $_POST['porcentaje_adu'.$id];
			$mn = $_POST['minimo_adu'.$id];

			if($pc!='' || $mn!='')
			{
				$sql = "select idcot_adu from cot_adu where idaduana='$id' and idcot_temp='$_GET[idcot_temp]'";
				$exe = mysqli_query($link,$sql);
				$datos = mysqli_fetch_array($exe);
				
				$sqladu = "INSERT INTO rn_adu (idcot_adu, idreporte, porcentaje, minimo, observaciones, descripcion, mostrar) VALUES ('$datos[idcot_adu]', '$_GET[idcot_temp]','$pc', '$mn', UCASE('$_POST[observaciones_adu]'), '$_POST[descripcion_adu]', '$_POST[mostrar_adu]')";
				//print $sqladu.'<br>';
				$exeadu = mysqli_query($link,$sqladu);
			}
		}
	}
	
if(!$exeadu)
			print ("<script>alert('No se pudo guardar el registro')</script>");
		else
			print "<script>alert('El registro ha sido guardado satisfactoriamente')</script>";

}
?>
<form name="formulario" id="formulario" method="post">
<input name="datosok" type="hidden" value="no" />
<table width="100%" align="center">
    <tr>
        <td class="subtitseccion" style="text-align:center" >ADUANA COTIZACI&Oacute;N <? print scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero"); ?><br><br></td>
    </tr>
</table>
<?
include("rn_search_aduana.php");
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
