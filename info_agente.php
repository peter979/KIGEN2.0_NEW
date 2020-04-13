<?
include('sesion/sesion.php');
include("conection/conectar.php");	
include_once("permite.php");
include_once("scripts/recover_nombre.php");
$sesi=session_id();
?>

<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "exact",
	elements : "infoagente",
	theme : "advanced",
	plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,media,searchreplace,print,contextmenu,paste,directionality,fullscreen",
	theme_advanced_buttons1_add : "fontselect,fontsizeselect",
	theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
	theme_advanced_buttons2_add_before: "cut,copy,paste,pasteword,separator,separator",
	theme_advanced_buttons3_add_before : "tablecontrols,separator",
	theme_advanced_buttons3_add : "emotions,iespell,media,separator,ltr,rtl,separator",
	
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",	
	theme_advanced_buttons1_add :"fontselect,fontsizeselect,separator,tablecontrols",
	
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
</script>

<link href="css/admin_internas.css" rel="stylesheet" type="text/css">
<form id="form_infoagente" name="form_infoagente">
<?
$sql = "select * from proveedores_agentes where idproveedor_agente='$_GET[idpro]'";
$exe = mysqli_query($link,$sql);
$datos = mysqli_fetch_array($exe);

if($datos['nombre']!='') $infoagente .= "$datos[nombre]<br>";
if($datos['nit']!='') $infoagente .= "$datos[nit]<br>";
if($datos['direccion']!='') $infoagente .= "$datos[direccion]<br>";
if($datos['telefonos']!='') $infoagente .= "$datos[telefonos]<br>";
if($datos['email_empresarial']!='') $infoagente .= "$datos[email_empresarial]<br>";
$infoagente .= "<br>";

$sql = "select * from contactos_todos where idproveedor_agente='$datos[idproveedor_agente]'";
$exe = mysqli_query($link,$sql);
$filas = mysqli_num_rows($exe);

if($filas > 0)
{
	?>
    <table width="100%" align="center" class="contenidotab">
        <tr>
            <td class="subtitseccion" style="text-align:center">INFORMACI&Oacute;N AGENTE <? print $datos['nombre']; ?><br><br></td>
        </tr>
    <?
    
	/*$infoagente_ct .= "<table>";
	while($datos = mysqli_fetch_array($exe))
	{
		if($datos['nombre']!='') $infoagente_ct .= "$datos[nombre]</td></tr>";
		if($datos['cargo']!='') $infoagente_ct .= "<tr><td>$datos[cargo]</td></tr>";
		if($datos['division']!='') $infoagente_ct .= "<tr><td>$datos[division]</td></tr>";
		if($datos['correo']!='') $infoagente_ct .= "<tr><td>$datos[correo]</td></tr>";
		if($datos['telefono']!='') $infoagente_ct .= "<tr><td>$datos[telefono]</td></tr>";
		if($datos['celular']!='') $infoagente_ct .= "<tr><td>$datos[celular]</td></tr>";
		$infoagente_ct .= "<tr><td>&nbsp;</td></tr>";
	}
	$infoagente_ct .= "</table>";*/
	while($datos = mysqli_fetch_array($exe))
	{
		if($datos['nombre']!='') $infoagente_ct .= "$datos[nombre]<br>";
		if($datos['cargo']!='') $infoagente_ct .= "$datos[cargo]<br>";
		if($datos['division']!='') $infoagente_ct .= "$datos[division]<br>";
		if($datos['correo']!='') $infoagente_ct .= "$datos[correo]<br>";
		if($datos['telefono']!='') $infoagente_ct .= "$datos[telefono]<br>";
		if($datos['celular']!='') $infoagente_ct .= "$datos[celular]<br>";
		$infoagente_ct .= "<br>";
	}
	?>
   		<tr> 
        	<td "contenidotab" style="text-align:center"><textarea id="infoagente" name="infoagente" cols="50" rows="20" ><span style="font-size:10px;font-family:tahoma;"><? print $infoagente; print $infoagente_ct ?></span></textarea></td>
		</tr>
		<tr>
            <td align="center" class="subtitseccion" style="text-align:center; font-size:11px" colspan="4" >Para seleccionar todo puedes hacer doble clic sobre un espacio en blanco en la derecha del area de texto</td>
       	</tr>
        <tr>
            <td "contenidotab" style="text-align:center" align="center">
                <table align="center">
                    <tr>        	
                        <td width="60"class="botonesadmin" align="center" style="text-align:center">
                        <a href="javascript: void(0)" onclick="javascript:form_infoagente.infoagente.focus();form_infoagente.infoagente.select();" style="text-align:center" />Seleccionar Todo</a>
                        </td>                        
                    </tr>
                </table>
            </td>
        </tr>       
    </table>
	<?
}
?>




        
</form>