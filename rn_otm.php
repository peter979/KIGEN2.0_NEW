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
<!--<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "corte_hbl",
		theme : "simple",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,media,searchreplace,print,contextmenu,paste,directionality,fullscreen",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
		theme_advanced_buttons2_add_before: "cut,copy,paste,pasteword,separator,separator",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_buttons3_add : "emotions,iespell,media,separator,ltr,rtl,separator",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
	    plugi2n_insertdate_dateFormat : "%Y-%m-%d",
	    plugi2n_insertdate_timeFormat : "%H:%M:%S",
		file_browser_callback : "fileBrowserCallBack",
		content_css : "../css/sitio.css",
		paste_use_dialog : false,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		theme_advanced_link_targets : "",
		paste_auto_cleanup_on_paste : true,
		paste_convert_headers_to_strong : false,
		paste_strip_class_attributes : "all",
		paste_remove_spans : false,
		paste_remove_styles : false
	});

	function fileBrowserCallBack(field_name, url, type, win) {
		// This is where you insert your custom filebrowser logic
		alert("Filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);

		// Insert new URL, this would normaly be done in a popup
		win.document.forms[0].elements[field_name].value = "someurl.htm";
	}
</script>-->
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
	$sqldelotm = "delete from rn_otm where idreporte='$_GET[idcot_temp]'";
	//print $sqldel.'<br>';
	$exedelotm = mysql_query($sqldelotm, $link);
	
	$sqldelotm = "delete from rn_local_otm_por_cotizacion where idreporte='$_GET[idcot_temp]'";
	//print $sqldel.'<br>';
	$exedelotm = mysql_query($sqldelotm, $link);
	
	if(isset($_POST['selotm']))
	{
		foreach($_POST['selotm'] as $id)
		{
			$selotm_dev = $_POST['selotm_dev'.$id];
			$selotm_esc = $_POST['selotm_esc'.$id];
			
			$valor_venta = $_POST['venta_otm'.$id];
			
			$sql = "select idcot_otm from cot_otm where idotm='$id' and idcot_temp='$_GET[idcot_temp]'";
			$exe = mysql_query($sql, $link);
			$datos = mysql_fetch_array($exe);
			
			$queryins="INSERT INTO rn_otm (idciudad, nombre, nit, deposito, direccion, idcot_otm, idreporte, valor_venta, condiciones, documentacion, corte_hbl) VALUES('$_POST[idciudad]', '$_POST[nombre]', '$_POST[nit]', '$_POST[deposito]', '$_POST[direccion]', '$datos[idcot_otm]', '$_GET[idcot_temp]', '$valor_venta', '$_POST[condiciones]', '$_POST[doc_req]', '$_POST[corte_hbl]')";
			//print $queryins.'<br>';
			$buscarins=mysql_query($queryins,$link);
		}
	}
	$sqlrg = "select * from recargos_local_otm where clasificacion='$_GET[cl]'";
	//print $sqlrg .'<br>';
	$exerg = mysql_query($sqlrg, $link);
	while($datosrg = mysql_fetch_array($exerg))
	{
		$idrecargo_otm = $_POST['recargo_otm'.$datosrg['idrecargo_local']];
		$recargo_otm_valor_venta = $_POST['recargo_otm_valor_venta'.$datosrg['idrecargo_local']];
		$recargo_otm_minimo_venta = $_POST['recargo_otm_minimo_venta'.$datosrg['idrecargo_local']];
		
		if($idrecargo_otm!='')
		{
			$sql="INSERT INTO rn_local_otm_por_cotizacion (idrecargo_local, idreporte, valor_venta, minimo_venta) VALUES ('$datosrg[idrecargo_local]', '$_GET[idcot_temp]', '$recargo_otm_valor_venta', '$recargo_otm_minimo_venta')";
			//print $sql.'<br>';  
			$exe= mysql_query($sql,$link);
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
        <td class="subtitseccion" style="text-align:center" >OTM COTIZACI&Oacute;N <? print scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero"); ?><br><br></td>
    </tr>
</table>
<?
	include("rn_search_otm.php");
?>
<table align="center">
	<tr>
		<td class="contenidotab" colspan="2">Corte HBL</td>
    </tr>
    <?
	$sqlrn = "select * from rn_otm where idreporte='$_GET[idcot_temp]'"; 
	//print $sqlrn.'<br>';
	$exern = mysql_query($sqlrn, $link);
	$datosrn =  mysql_fetch_array($exern);

	$sqlrn="select * from otm where clasificacion='$_GET[cl]' and idotm in (select idotm from cot_otm where idcot_temp='$_GET[idcot_temp]')";
	//print $sqlrn.'<br>';
	$exern = mysql_query($sqlrn, $link);
	$datosrn2 =  mysql_fetch_array($exern);

	$sql = "select * from proveedores_agentes where idproveedor_agente='$datosrn2[idproveedor]'";
	$exe = mysql_query($sql, $link);
	$datosp =  mysql_fetch_array($exe);
	
	$corte_hbl = scai_get_name("$datosrn2[idproveedor]","proveedores_agentes", "idproveedor_agente", "nombre").'<br>'.scai_get_name("$datosrn2[idproveedor]","proveedores_agentes", "idproveedor_agente", "nit").'<br>'."DEPOSITO HABILITADO O USUARIO DE ZONA FRANCA.<br>DIRECCION DEPOSITO.<br>CIUDAD DESTINO.<br>";
	?>
<tr>        
	<!--<td class="contenidotab"><textarea id="corte_hbl" name="corte_hbl"><? if($datosrn['corte_hbl']!='') print $datosrn['corte_hbl']; else print $corte_hbl; ?></textarea>-->
	<input type="hidden" id="corte_hbl" name="corte_hbl" value="<? if($datosrn['corte_hbl']!='') print $datosrn['corte_hbl']; else print $corte_hbl; ?>">
	</td>
</tr>
<tr>
	<td class="contenidotab">Nombre</td><td class="contenidotab"><input type="text" id="nombre" name="nombre" value="<? if($datosrn['nombre']!='') print $datosrn['nombre']; else print $datosp['nombre']; ?>"></td>
</tr>
<tr>
	<td class="contenidotab">NIT</td><td class="contenidotab"><input type="text" id="nit" name="nit" value="<? if($datosrn['nit']!='') print $datosrn['nit']; else print $datosp['nit']; ?>"></td>
</tr>
<tr>
	<td class="contenidotab">Deposito</td><td class="contenidotab"><input type="text" id="deposito" name="deposito" value="<? if($datosrn['deposito']!='') print $datosrn['deposito']; ?>"></td>
</tr>
<tr>
	<td class="contenidotab">Direcci&oacute;n</td><td class="contenidotab"><input type="text" id="direccion" name="direccion" value="<? if($datosrn['direccion']!='') print $datosrn['direccion']; else print $datosp['direccion']; ?>"></td>
</tr>
<tr>	
	<td class="contenidotab">Ciudad&nbsp;</td>
	<td class="contenidotab"><select id="idciudad" name="idciudad" class="tex1" >
			<option value="N"> Seleccione </option>
			<?
			if($datosrn['idciudad']!='') $seleccionado = $datosrn['idciudad']; else $seleccionado = $datosp['idciudad'];
			$es = "select * from ciudades order by nombre"; 
			$exe=mysql_query($es,$link);
			 
			while($row=mysql_fetch_array($exe))
			{
				$pais = scai_get_name("$row[idpais]", "paises", "idpais", "nombre");
				$sel = "";
				if($seleccionado == $row['idciudad'])
					$sel = "selected";
				print "<option value='$row[idciudad]' $sel>$row[nombre] - $pais</option>";
			}	
			?>
		</select>
	</td>	
    </tr>
</table>		
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
