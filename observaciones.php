<?
	include('sesion/sesion.php');
	include("conection/conectar.php");	
	include_once("permite.php");
	include_once("scripts/recover_nombre.php");

	$tabla = "cot_temp";
	$llave = "idcot_temp";
?>

<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/main.js"></script>
<script type="text/javascript" src="./js/shadowbox-base.js"></script>
<script type="text/javascript" src="./js/shadowbox.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.1.pack.js" ></script>
<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "contenido",
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
</script>
<script>
function winback(URL)
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,screenX=250,screenY=50,statusbar=yes,menubar=0,resizable=0,width=600,height=700');");
}
function validaEnvia2()
{
	javascript:winback('preview.php?id=<? print $_GET['idcot_temp'];?>')
}
</script>
<style type="text/css">

div.capa10
{
	/*display:none;*/
}
div.capa11
{
	display:none;
}
div.capa12
{
	display:none;
}
div.capa13
{
	display:none;
}
div.capa131
{
	display:none;
}
div.capa14
{
	display:none;
}
</style>

<?
/*
function ruta_ima($x, $id_ima)
{
	$sql = "SELECT cp.urlCarpeta, md.nombreMedio FROM medios md, carpetas cp WHERE md.idcarpeta=cp.idcarpeta AND md.idmedio='$id_ima'";
	
	$query = mysqli_query ($sql);
	$row = mysqli_fetch_array($query);
	if ($x == '0')
		return "..".$row['urlCarpeta'].$row['nombreMedio'];
	else
		return "..".$row['urlCarpeta']."mini_".$row['nombreMedio'];
}*/
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/admin_internas.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/funciones.js"></script>
<script type="text/javascript" src="./js/funcionesValida.js"></script>
<!--FUNCION DE MOSTRAR RESULTADOS MIENTRAS SE ESCRIBE, PARA TEXT RAZON SOCIAL-->
<? include("scripts/prepare_clients_list.php");?>
<script type="text/javascript" src="js/clients_list.js"></script>
<?php include('scripts/scripts.php'); ?>

<script language="javascript">
function validaEnvia(form)
{
	
	form.datosok.value="si";
	form.submit()
}
/*
function validaBuscar(form)
{
	if (form.nombre.value == "")
	{
		alert('Digite la razon social');
		form.nombre.focus();
		return false;
	}

	form.xyz.value = form.nombre.value;
	form.submit();
}*/

function eliminaActual(form)
{
	form.varelimi.value="si";
	form.submit()
}

function validaPais(form)
{
	form.submit()
}

function borrar(form)
{
	document.location.href = 'clientes.php';
}
</script>
</head>

<?
if($_POST['datosok']=='si')
{
	if(!isset($_POST['idcot_temp']) || $_POST['idcot_temp'] == '')
	{
		
		$querymod="update $tabla set observaciones='$_POST[contenido]' where $llave='$_GET[id]'";

		$buscarmod=mysqli_query($link,$querymod);
		
					
		if(!$buscarmod)
			print ("<script>alert('No se pudo ingresar el registro')</script>");
	
	}
}

if($_POST['varelimi']=='si')
{
	$queryelim="DELETE FROM $tabla WHERE $llave='$_POST[idcot_temp]'";
	$buscarelim=mysqli_query($link,$queryelim);
	if(!$buscarelim)
		print mysqli_error();
	
	?><script>document.location.href='<? print $_SERVER['PHP_SELF'];?>'</script><?
}

if (isset($_POST['idcliente']) && $_POST['idcliente']!='')
	$_GET['idcliente'] == $_POST['idcliente'];
?>

<body style="background-color: transparent;" oncontextmenu="return false;">
<form name="formulario" method="post">
<input name="datosok" type="hidden" value="no" />
<input name="varelimi" type="hidden" value="no" />
<input type="hidden" name="listaEliminar" value="" />
<input name="idcliente" type="hidden" value="<? print $_GET['idcliente'] ?>" />
<input name="xyz" type="hidden" value="" />
<?
	if($_GET['idcliente'] != '')
	{
		$sqlad = "select * from clientes where idcliente='$_GET[idcliente]'";
//		print $sqlad.'<br>';
		$exead = mysqli_query($link,$sqlad);
		$datosad = mysqli_fetch_array($exead);
	
	}

	/*
	if(isset($_GET['xyz']) and $_GET['xyz']!="")
		$_POST['xyz'] = $_GET['xyz'];
	if(isset($_POST['xyz']) and $_POST['xyz']!="")
	{
		$sql = "SELECT * FROM clientes WHERE nombre LIKE '%$_POST[xyz]%'";
		print $sql.'<br>';
		$query = mysqli_query($link,$sql);
		$filas = mysqli_num_rows($query);
		if ($filas == 0)
			print ("<script>alert('Este cliente no existe vuelva a intentarlo')</script>");
		else
		{
			if ($filas == 1)
			{
				$row = mysqli_fetch_array($query);
				print ("<script>document.location.href='".$_SERVER['PHP_SELF']."?idcliente=$row[idcliente]'</script>");
			}
		}
	}*/
	?>
    
<?
if($_GET['id']!="")
{
$sqlad2 = "select * from cot_temp where idcot_temp='$_GET[id]'";
print $sqlad.'<br>';
$exead2 = mysqli_query($link,$sqlad2);
$datosad2 = mysqli_fetch_array($exead2);
}
?>
<table border="0" width="100%" align="center">    
	<tr>
    	<td align="center" class="subtitseccion" colspan="4">
			<textarea cols="7" rows="8" name="contenido" id="contenido" ><? print $datosad2['observaciones'];?></textarea>
        </td>
  </tr>
</table>

<?
	$_POST['idcliente'] = $_GET['idcliente'];
?>
<table width="100%" align="center">               
    <tr>
    	<td>
            <table>
                <tr>
                
					
					<?
				
						if(puedo("m","COTIZACION")==1) 
						{ 
						?> 
                        <td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar&nbsp;observaciones</a></td>
                     	<? 
						} 

					?> 
                </tr>
            </table>        </td>
        <td>
            <table>
                <tr>        
					<? if ($_GET['idcliente'] != '')
					{ 
                    	if(puedo("e","COTIZACION")==1) { ?>
                        <!--<td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="eliminaActual(formulario)">Eliminar</a></td>-->
                		<? 
						} 
                    } 
					if(puedo("c","COTIZACION")==1) { ?>                    
                    <!--<td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="borrar(formulario)" >Nuevo</a></td>-->
                    <? } ?>
            	</tr>
			</table>    	</td>        
    </tr>     
</table>                
