<?php
	include('sesion/sesion.php');
	include("conection/conectar.php");
	include_once("permite.php");
	include_once("scripts/recover_nombre.php");

	$tabla = "otm";
	$llave = "idotm";
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
<link href="./css/admin_internas.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/funciones.js"></script>
<script type="text/javascript" src="./js/funcionesValida.js"></script>
<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "exact",
	elements : "presentacion_gen, condiciones_gen, pie_gen, condiciones_otm, condiciones_bg, descripcion_adu, descripcion_seg, condiciones_terrestre, condiciones_flete",
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
</script>

<?php include('./scripts/scripts.php'); ?>

<script language="javascript">
function validaEnvia(form)
{
	form.datosok.value="si";
	form.submit()
}

/*
function validaBuscar(form)
{
	if (form.num_contrato.value == "")
	{
		alert('Digite el num_contrato');
		form.num_contrato.focus();
		return false;
	}

	form.xyz.value = form.num_contrato.value;
	form.submit();
}*/

function eliminaActual(form)
{
	form.varelimi.value="si";
	form.submit()
}

function validaTarifario(form)
{
	var seleccionados = 'cero';//valor en la posición cero para las validaciones array_search
	for(i=0; i < 10; i++)
	{
		if(formulario.sel[i].checked)
		{
			if(seleccionados!=='')
				seleccionados=seleccionados + ',';
			seleccionados=seleccionados + formulario.sel[i].value;
		}
	}
	form.seleccionados.value = seleccionados;
	form.submit()
}

function validaPais(form)
{
	form.nueRegistro.value = 'si';
	form.submit()
}

</script>
<script language="javascript">

function cobra()
{
		if (window.XMLHttpRequest)
		{
		  // code for IE7+, Firefox, Chrome, Opera, Safari
		  return new XMLHttpRequest();
		}
		if (window.ActiveXObject)
		{
		  // code for IE6, IE5
		  return new ActiveXObject("Microsoft.XMLHTTP");
		 }
}
/*
function haber(filtre, filtre2, filtre3)
{
	var capa_eyes = window.document.getElementById("eyes2");
	//solicita = new XMLHttpRequest();
	solicita = cobra();
	solicita.open("POST", "search_vuelta.php", true);
	solicita.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	solicita.send("nav="+filtre+"&origen="+filtre2+"&destination="+filtre3);
	solicita.onreadystatechange = cambios;
}*/
function cambios()
{
	var capa_eyes = window.document.getElementById("eyes2");
	if(solicita.readyState == 4)
	{
		capa_eyes.innerHTML = solicita.responseText;
	}
	else
	{
		capa_eyes.innerHTML = '<img src="images/loading.gif" align="middle" /> Buscando...';
	}

}
</script>
</head>

<?
if($_POST['datosok']=='si')
{
	if($_GET['pr']=='general')
	{
		$sql = "update parametros set valor='$_POST[presentacion_gen]' where idparametro='1'";
		$exe = mysqli_query($link,$sql);
		$sql = "update parametros set valor='$_POST[condiciones_gen]' where idparametro='2'";
		$exe = mysqli_query($link,$sql);
		$sql = "update parametros set valor='$_POST[pie_gen]' where idparametro='3'";
		$exe = mysqli_query($link,$sql);
	}

	if($_GET['pr']=='otm')
	{
		//$_POST['condiciones_otm'] = str_replace('&quot;', '"', $_POST['condiciones_otm']);

		if($_GET['cl']=='fcl')
			$sql = "update parametros set valor='$_POST[condiciones_otm]' where idparametro='7'";
		if($_GET['cl']=='lcl')
			$sql = "update parametros set valor='$_POST[condiciones_otm]' where idparametro='11'";
		$exe = mysqli_query($link,$sql);

		if($_GET['cl']=='fcl')
			$sql = "update parametros set valor='$_POST[doc_req_otm]' where idparametro='8'";
		if($_GET['cl']=='lcl')
			$sql = "update parametros set valor='$_POST[doc_req_otm]' where idparametro='12'";
		$exe = mysqli_query($link,$sql);
	}

	if($_GET['pr']=='bodega')
	{
		if($_GET['cl']=='fcl')
			$sql = "update parametros set valor='$_POST[condiciones_bg]' where idparametro='9'";
		if($_GET['cl']=='lcl')
			$sql = "update parametros set valor='$_POST[condiciones_bg]' where idparametro='10'";
		if($_GET['cl']=='aereo')
			$sql = "update parametros set valor='$_POST[condiciones_bg]' where idparametro='24'";
		$exe = mysqli_query($link,$sql);
	}

	if($_GET['pr']=='seguro')
	{
		if($_GET['cl']=='fcl')
			$sql = "update parametros set valor='$_POST[descripcion_seg]' where idparametro='13'";
		if($_GET['cl']=='lcl')
			$sql = "update parametros set valor='$_POST[descripcion_seg]' where idparametro='14'";
		if($_GET['cl']=='aereo')
			$sql = "update parametros set valor='$_POST[descripcion_seg]' where idparametro='25'";
		$exe = mysqli_query($link,$sql);
	}

	if($_GET['pr']=='aduana')
	{
		if($_GET['cl']=='fcl')
			$sql = "update parametros set valor='$_POST[descripcion_adu]' where idparametro='15'";
		if($_GET['cl']=='lcl')
			$sql = "update parametros set valor='$_POST[descripcion_adu]' where idparametro='16'";
		if($_GET['cl']=='aereo')
			$sql = "update parametros set valor='$_POST[descripcion_adu]' where idparametro='26'";
		$exe = mysqli_query($link,$sql);
	}

	if($_GET['pr']=='terrestre')
	{
		if($_GET['cl']=='fcl')
			$sql = "update parametros set valor='$_POST[condiciones_terrestre]' where idparametro='17'";
		if($_GET['cl']=='lcl')
			$sql = "update parametros set valor='$_POST[condiciones_terrestre]' where idparametro='18'";
		if($_GET['cl']=='aereo')
			$sql = "update parametros set valor='$_POST[condiciones_terrestre]' where idparametro='27'";
		$exe = mysqli_query($link,$sql);
	}
	if($_GET['pr']=='flete')
	{
		if($_GET['cl']=='fcl')
			$sql = "update parametros set valor='$_POST[condiciones_flete]' where idparametro='28'";
		if($_GET['cl']=='lcl')
			$sql = "update parametros set valor='$_POST[condiciones_flete]' where idparametro='29'";
		if($_GET['cl']=='aereo')
			$sql = "update parametros set valor='$_POST[condiciones_flete]' where idparametro='23'";
		$exe = mysqli_query($link,$sql);
	}
	if($_GET['pr']=='collection')
	{
		$sql = "update parametros set valor='$_POST[collection_fee]' where idparametro='19'";
		$exe = mysqli_query($link,$sql);
		$sql = "update parametros set valor='$_POST[min_collection_fee]' where idparametro='20'";
		$exe = mysqli_query($link,$sql);
		$sql = "update parametros set valor='$_POST[validez_collection_fee]' where idparametro='30'";
		$exe = mysqli_query($link,$sql);
	}
	if($_GET['pr']=='caf')
	{
		$sql = "update parametros set valor='$_POST[caf]' where idparametro='21'";
		$exe = mysqli_query($link,$sql);
		$sql = "update parametros set valor='$_POST[min_caf]' where idparametro='22'";
		$exe = mysqli_query($link,$sql);
		$sql = "update parametros set valor='$_POST[validez_caf]' where idparametro='31'";
		$exe = mysqli_query($link,$sql);
	}
	//print $sql.'<br>';
	?><script>document.location.href='parametros_cotizacion.php?pr=<? print $_GET['pr']; ?>&cl=<? print $_GET['cl']; ?>'</script><?
}

if($_POST['varelimi']=='si')
{
	$queryelim="DELETE FROM $tabla WHERE $llave IN (".str_replace('\\', '', $_POST['listaEliminar']).")";
	//print $queryelim."<br>";
	$buscarelim=mysqli_query($link,$queryelim);
	if(!$buscarelim)
		print mysqli_error();
	?><script>//document.location.href='<? print $_SERVER['PHP_SELF'];?>'</script><?
}

if (isset($_POST['idtarifario']))
	$_GET['idtarifario'] == $_POST['idtarifario'];
?>
<body style="background-color: transparent;">
<form name="formulario" method="post">
<input name="datosok" type="hidden" value="no" />
<input name="varelimi" type="hidden" value="no" />
<input type="hidden" name="listaEliminar" value="" />
<input name="xyz" type="hidden" value="" />
<input name="seleccionados" type="hidden" value="" />
<input type="hidden" name="nueRegistro" value="no" />
<? if($_POST['modRegistro'] == "si")
{
?>
	<input type="hidden" name="modRegistro" value="si" />
<?
}else
{
?>
	<input type="hidden" name="modRegistro" value="no" />
<?
}
	/*
	if(isset($_GET['xyz']) and $_GET['xyz']!="")
		$_POST['xyz'] = $_GET['xyz'];
	if(isset($_POST['xyz']) and $_POST['xyz']!="")
	{
		$sql = "SELECT * FROM $tabla WHERE nombre LIKE '%$_POST[xyz]%'";
		$query = mysqli_query($link,$sql);
		$filas = mysqli_num_rows($query);
		if ($filas == 0)
			print ("<script>alert('Este recargo no existe vuelva a intentarlo')</script>");
		else
		{
			if ($filas == 1)
			{
				$row = mysqli_fetch_array($query);
				print ("<script>document.location.href='".$_SERVER['PHP_SELF']."?idotm=$row[idotm]'</script>");
			}
			?>
			<table width="50%"align="center">
				<tr align="center">
					<td valign="top">
						<?
						$regxpag = 5;
						$totpag = ceil($filas / $regxpag);
						$pag = $_GET['pag'];
						if (!$pag)
							$pag = 1;
						else
						{
							if (is_numeric($pag) == false)
								$pag = 1;
						}
						$regini = ($pag - 1) * $regxpag;
						$sqlpag = $sql." LIMIT $regini, $regxpag";
						$buscarpag = mysqli_query($link,$sqlpag);
						while($row=mysqli_fetch_array($buscarpag))
						{
							print "<a href=".$_SERVER['PHP_SELF']."?idotm=$row[idotm]>$row[num_contrato]</a><br>";
						}
						?>
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="200" height="20" align="center" valign="middle">&nbsp;</td>
								<td height="20" align="center" valign="middle">
								<a href="javascript:void(0)" onClick="document.location='<? print $_SERVER['PHP_SELF']; ?>?pag=1&xyz=<? print $_POST['xyz']; ?>'">&lt;&lt;</a>
								</td>
								<td height="20" align="center" valign="middle">
									<? if ($pag != 1) { ?><a href="javascript:void(0)" onClick="document.location='<? print $_SERVER['PHP_SELF']; ?>?pag=<? print ($pag - 1); ?>&xyz=<? print $_POST['xyz']; ?>'"><? } ?>&lt;<? if ($pag != 1) { ?></a><? } ?>
								</td>
								<td height="20" align="center" valign="middle">
									<!--<a href="#">1-2-3-4</a>-->
									<select name="pag" onChange="document.location='<? print $_SERVER['PHP_SELF']; ?>?xyz=<? print $_POST['xyz']; ?>&pag=' + document.forms[0].pag.value;">
										<?
										for ($i=1; $i<=$totpag; $i++)
										{
											if ($i == $pag)
												print "<option value=$i selected>$i</option>";
											else
												print "<option value=$i>$i</option>";
										}
										?>
									</select>
								</td>
								<td height="20" align="center" valign="middle">
									<? if ($pag != $totpag) { ?><a href="javascript: void(0)" onClick="document.location='<? print $_SERVER['PHP_SELF']; ?>?pag=<? print ($pag + 1); ?>&xyz=<? print $_POST['xyz']; ?>'"><? } ?>&gt;<? if ($pag != $totpag) { ?></a><? } ?>
								</td>
								<td height="20" align="center" valign="middle">
                                <a href="javascript: void(0)" onClick="document.location='<? print $_SERVER['PHP_SELF']; ?>?pag=<? print $totpag; ?>&xyz=<? print $_POST['xyz']; ?>'">&gt;&gt;</a>
								</td>
								<td width="200" height="20" align="center" valign="middle">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		<?
		}
	}*/
	?>
<table width="100%" align="center">
    <tr>
    	<td align="center" class="subtitseccion" colspan="2"><? print 'PARAMETRIZACI&Oacute;N '.strtoupper($_GET['pr']).' '.strtoupper($_GET['cl']); ?></td>
    </tr>
</table>
<table width="100%" align="center">
	<?
    if($_GET['pr']=='general')
    {
        ?>
        <tr>
            <td align="center" class="subtitseccion" style="font-size:11px">Texto de presentaci&oacute;n aplica a todas las cotizaciones</td>
        </tr>
        <?
        $sql = "select * from parametros where idparametro='1'";
        //print $sql.'<br>';
        $exe = mysqli_query($link,$sql);
        $cond = mysqli_fetch_array($exe);
        ?>
        <tr>
            <td align="center">
                <textarea name="presentacion_gen" id="presentacion_gen" cols="100" rows="10"><? if($_POST['presentacion_gen']!='') print $_POST['presentacion_gen']; else print $cond['valor']; ?></textarea>            </td>
        </tr>
        <tr>
            <td align="center" class="subtitseccion" style="font-size:11px">Condiciones generales aplica a todas las cotizaciones</td>
        </tr>
        <?
        $sql = "select * from parametros where idparametro='2'";
        //print $sql.'<br>';
        $exe = mysqli_query($link,$sql);
        $cond = mysqli_fetch_array($exe);
        ?>
        <tr>
            <td align="center">
                <textarea name="condiciones_gen" id="condiciones_gen" cols="100" rows="10"><? if($_POST['condiciones_gen']!='') print $_POST['condiciones_gen']; else print $cond['valor']; ?></textarea>            </td>
        </tr>
        <tr>
            <td align="center" class="subtitseccion" style="font-size:11px">Pie de pagina aplica a todas las cotizaciones</td>
        </tr>
        <?
        $sql = "select * from parametros where idparametro='3'";
        //print $sql.'<br>';
        $exe = mysqli_query($link,$sql);
        $cond = mysqli_fetch_array($exe);
        ?>
        <tr>
            <td align="center">
                <textarea name="pie_gen" id="pie_gen" cols="100" rows="10"><? if($_POST['pie_gen']!='') print $_POST['pie_gen']; else print $cond['valor']; ?></textarea>            </td>
        </tr>
        <?
    }
    if($_GET['pr']=='otm')
    {
        ?>
        <tr>
            <td align="center" class="subtitseccion" style="font-size:11px">Condiciones generales y documentaci&oacute;n requerida aplica a todas las tarifas OTM <? print strtoupper($_GET['cl']); ?></td>
        </tr>
        <?
        if($_GET['cl']=='fcl')
            $idp = '7';
        elseif($_GET['cl']=='lcl')
            $idp = '11';
        $sql = "select * from parametros where idparametro='$idp'";
        //print $sql.'<br>';
        $exe = mysqli_query($link,$sql);
        $cond = mysqli_fetch_array($exe);
        ?>
        <tr>
            <td align="center">
                <textarea name="condiciones_otm" id="condiciones_otm" cols="100" rows="10"><? if($_POST['condiciones_otm']!='') print $_POST['condiciones_otm']; else print $cond['valor']; ?></textarea>            </td>
        </tr>
        <!--<tr>
            <td align="center" class="subtitseccion" style="font-size:11px">Documentaci&oacute;n requerida aplica a todas las tarifas OTM <? print strtoupper($_GET['cl']); ?></td>
        </tr>
        <?
        if($_GET['cl']=='fcl')
            $idp = '8';
        elseif($_GET['cl']=='lcl')
            $idp = '12';
        $sql = "select * from parametros where idparametro='$idp'";
        //print $sql.'<br>';
        $exe = mysqli_query($link,$sql);
        $cond = mysqli_fetch_array($exe);
        ?>
        <tr>
            <td align="center">
                <textarea name="doc_req_otm" id="doc_req_otm" cols="100" rows="10"><? if($_POST['doc_req_otm']!='') print $_POST['doc_req_otm']; else print $cond['valor']; ?></textarea>
            </td>
        </tr>-->
        <?
    }
    if($_GET['pr']=='bodega')
    {
        ?>
        <tr>
            <td align="center" class="subtitseccion" style="font-size:11px">Condiciones generales aplican a todas las bodegas <? print $_GET['cl']; ?> </td>
        </tr>
        <?
        if($_GET['cl']=='fcl')
            $idp = '9';
        elseif($_GET['cl']=='lcl')
            $idp = '10';
		elseif($_GET['cl']=='aereo')
            $idp = '24';
        $sql = "select * from parametros where idparametro='$idp'";
        //print $sql.'<br>';
        $exe = mysqli_query($link,$sql);
        $cond = mysqli_fetch_array($exe);
        ?>
        <tr>
            <td colspan="6" align="center">
                <textarea name="condiciones_bg" id="condiciones_bg" cols="100" rows="10"><? if($_POST['condiciones_bg']!='') print $_POST['condiciones_bg']; else print $cond['valor']; ?></textarea>            </td>
        </tr>
        <?
    }
    if($_GET['pr']=='aduana')
    {
        ?>
        <tr>
            <td align="center" class="subtitseccion" style="font-size:11px">Descripci&oacute;n que aplica a la asesoria aduanera <? print strtoupper($_GET['cl']); ?></td>
        </tr>
        <?
        if($_GET['cl']=='fcl')
            $idp = '15';
        elseif($_GET['cl']=='lcl')
            $idp = '16';
		elseif($_GET['cl']=='aereo')
            $idp = '26';
        $sql = "select * from parametros where idparametro='$idp'";
        //print $sql.'<br>';
        $exe = mysqli_query($link,$sql);
        $cond = mysqli_fetch_array($exe);
        ?>
        <tr>
            <td align="center">
                <textarea name="descripcion_adu" id="descripcion_adu" cols="100" rows="10"><? if($_POST['descripcion_adu']!='') print $_POST['descripcion_adu']; else print $cond['valor']; ?></textarea>            </td>
        </tr>
        <?
    }
    if($_GET['pr']=='seguro')
    {
        ?>
        <tr>
            <td align="center" class="subtitseccion" style="font-size:11px">Descripci&oacute;n que aplica al seguro de mercancia <? print strtoupper($_GET['cl']); ?></td>
        </tr>
        <?
        if($_GET['cl']=='fcl')
            $idp = '13';
        elseif($_GET['cl']=='lcl')
            $idp = '14';
		elseif($_GET['cl']=='aereo')
            $idp = '25';
        $sql = "select * from parametros where idparametro='$idp'";
        //print $sql.'<br>';
        $exe = mysqli_query($link,$sql);
        $cond = mysqli_fetch_array($exe);
        ?>
        <tr>
            <td align="center">
                <textarea name="descripcion_seg" id="descripcion_seg" cols="100" rows="10"><? if($_POST['descripcion_seg']!='') print $_POST['descripcion_seg']; else print $cond['valor']; ?></textarea>            </td>
        </tr>
        <?
    }
	if($_GET['pr']=='terrestre')
    {
        ?>
        <tr>
            <td align="center" class="subtitseccion" style="font-size:11px">Condiciones generales aplican a carga nacionalizada <? print $_GET['cl']; ?> </td>
        </tr>
        <?
        if($_GET['cl']=='fcl')
            $idp = '17';
        elseif($_GET['cl']=='lcl')
            $idp = '18';
		elseif($_GET['cl']=='aereo')
            $idp = '27';
        $sql = "select * from parametros where idparametro='$idp'";
        //print $sql.'<br>';
        $exe = mysqli_query($link,$sql);
        $cond = mysqli_fetch_array($exe);
        ?>
        <tr>
            <td colspan="6" align="center">
                <textarea name="condiciones_terrestre" id="condiciones_terrestre" cols="100" rows="10"><? if($_POST['condiciones_terrestre']!='') print $_POST['condiciones_terrestre']; else print $cond['valor']; ?></textarea>            </td>
        </tr>
        <?
    }
	if($_GET['pr']=='flete')
    {
        ?>
        <tr>
            <td align="center" class="subtitseccion" style="font-size:11px">Condiciones generales aplican a todos los fletes <? print $_GET['cl']; ?> </td>
        </tr>
        <?
		if($_GET['cl']=='fcl')
            $idp = '28';
        elseif($_GET['cl']=='lcl')
            $idp = '29';
		elseif($_GET['cl']=='aereo')
            $idp = '23';
        $sql = "select * from parametros where idparametro='$idp'";
        //print $sql.'<br>';
        $exe = mysqli_query($link,$sql);
        $cond = mysqli_fetch_array($exe);
        ?>
        <tr>
            <td colspan="6" align="center"><textarea name="condiciones_flete" id="condiciones_flete" cols="100" rows="10"><? if($_POST['condiciones_flete']!='') print $_POST['condiciones_flete']; else print $cond['valor']; ?>
            </textarea></td>
    </tr>
        <?
    }
    if($_GET['pr']=='collection')
    {
        ?>
        <tr>
            <td align="center" class="subtitseccion" style="font-size:11px">Collection fee<? print $_GET['cl']; ?> </td>
        </tr>
        <tr>
        	<td colspan="6" align="center">
                <table width="100%">
                <tr>
                    <td class="contenidotab" align="center">Collection Fee(%)</td>
                    <?
					$idp = '19';
					$sql = "select * from parametros where idparametro='$idp'";
					//print $sql.'<br>';
					$exe = mysqli_query($link,$sql);
					$cond = mysqli_fetch_array($exe);
					?>
                    <td align="center">
                    <input id="collection_fee" name="collection_fee" class="tex2" value="<? if($_POST['collection_fee']!='') print $_POST['collection_fee']; else print $cond['valor']; ?>" maxlength="50" size="40" >                    </td>
                </tr>
                <tr>
                    <td class="contenidotab" align="center"> Minimo Collection Fee($)</td>
                    <?
					$idp = '20';
					$sql = "select * from parametros where idparametro='$idp'";
					//print $sql.'<br>';
					$exe = mysqli_query($link,$sql);
					$cond = mysqli_fetch_array($exe);
					?>
                    <td align="center">
                    <input id="min_collection_fee" name="min_collection_fee" class="tex2" value="<? if($_POST['min_collection_fee']!='') print $_POST['min_collection_fee']; else print $cond['valor']; ?>" maxlength="50" size="40" >                    </td>
                </tr>
                <tr>
                    <td class="contenidotab" align="center">Fecha de validez</td>
                    <?
					$idp = '30';
					$sql = "select * from parametros where idparametro='$idp'";
					//print $sql.'<br>';
					$exe = mysqli_query($link,$sql);
					$cond = mysqli_fetch_array($exe);
					?>
                    <td align="center">
                    <input id="validez_collection_fee" name="validez_collection_fee" class="tex2" value="<? if($_POST['validez_collection_fee']!='') print $_POST['validez_collection_fee']; else print $cond['valor']; ?>" maxlength="50" size="40" readonly>
                    <input class="botonesadmin" style="color:#FFFFFF;" onClick="return showCalendar('validez_collection_fee');" type='reset' value='...' name='reset' />
                    </td>
                </tr>
                </table>            </td>
        </tr>
        <?
    }
    if($_GET['pr']=='caf')
    {
        ?>
        <tr>
            <td align="center" class="subtitseccion" style="font-size:11px">CAF<? print $_GET['cl']; ?> </td>
        </tr>
        <tr>
        	<td colspan="6" align="center">
                <table width="100%">
                <tr>
                    <td class="contenidotab" align="center">CAF(%)</td>
                    <?
					$idp = '21';
					$sql = "select * from parametros where idparametro='$idp'";
					//print $sql.'<br>';
					$exe = mysqli_query($link,$sql);
					$cond = mysqli_fetch_array($exe);
					?>
                    <td align="center">
                    <input id="caf" name="caf" class="tex2" value="<? if($_POST['caf']!='') print $_POST['caf']; else print $cond['valor']; ?>" maxlength="50" size="40" >                    </td>
                </tr>
                <tr>
                    <td class="contenidotab" align="center"> Minimo CAF($)</td>
                    <?
					$idp = '22';
					$sql = "select * from parametros where idparametro='$idp'";
					//print $sql.'<br>';
					$exe = mysqli_query($link,$sql);
					$cond = mysqli_fetch_array($exe);
					?>
                    <td align="center">
                    <input id="min_caf" name="min_caf" class="tex2" value="<? if($_POST['min_caf']!='') print $_POST['min_caf']; else print $cond['valor']; ?>" maxlength="50" size="40" >                    </td>
                </tr>
                <tr>
                    <td class="contenidotab" align="center">Fecha de validez</td>
                    <?
					$idp = '31';
					$sql = "select * from parametros where idparametro='$idp'";
					//print $sql.'<br>';
					$exe = mysqli_query($link,$sql);
					$cond = mysqli_fetch_array($exe);
					?>
                    <td align="center">
                    <input id="validez_caf" name="validez_caf" class="tex2" value="<? if($_POST['validez_caf']!='') print $_POST['validez_caf']; else print $cond['valor']; ?>" maxlength="50" size="40" readonly>
                    <input class="botonesadmin" style="color:#FFFFFF;" onClick="return showCalendar('validez_caf');" type='reset' value='...' name='reset' />
                    </td>
                </tr>
                </table>            </td>
        </tr>
        <?
    }
    ?>
</table>
<table>
    <tr>
        <?
			if(puedo("m","PARAMETROS_COMERCIAL")==1)
			{
				?>
				<td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
				<?
			}
        ?>
    </tr>
</table>
</form>
</body>
