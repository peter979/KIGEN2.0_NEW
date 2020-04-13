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
		theme : "advanced",
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

function winback(URL){
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,screenX=250,screenY=50,statusbar=yes,menubar=0,resizable=0,width=900,height=400');");
}
function validaEnvia2(form){
	form.marca.value="si";
	form.submit();
}
function validaEnvia3(form){
	form.exi.value="si";
	form.submit();
}
function showDiv(capa){
	if($(capa).css("display") == "block")
		$(capa).hide();
	else
		$(capa).show();

	return false;
}

</script>
<style type="text/css">

    div.capa10{
        /*display:none;*/
    }
    div.capa11{
        display:none;
    }
    div.capa12{
        display:none;
    }
    div.capa13{
        display:none;
    }
    div.capa131{
        display:none;
    }
    div.capa14{
        display:none;
    }
</style>

<?
if($_GET['opc'] == "icoterm"){
    $updt = "update cot_temp set icoterm = '".$_POST['icoterm']."' where idcot_temp = ".$_GET['idcot_temp'];
    if(mysqli_query($link,$updt)){
        echo "<script>alert('Terminos de negociación almacenados');</script>";
    }else{
        echo "No almaceno los terminos<br>".mysqli_error()."<br>$updt";
    }

}
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


	function eliminaActual(form){
		form.varelimi.value="si";
		form.submit()
	}

	function validaPais(form){
		form.submit()
	}

	function borrar(form)
	{
		document.location.href = 'clientes.php';
	}

	function irAtras(form)
	{
		form.destinok.value='atras';
		form.datosok.value='si';
		form.submit()
	}
</script>
    <script language="javascript" type="text/javascript">
	function framePrint3(whichFrame){
		cotizacion.focus();
		cotizacion.print();
	}
</script>
</head>
<?
$sqlrn = "select idreporte from reporte_negocios where idcot_temp='$_GET[idcot_temp]'";
$exern = mysqli_query($link,$sqlrn);
$filasrn = mysqli_num_rows($exern);

if($_GET['nueva']=='si'){
    $sqlnueva = "
		insert into cot_temp (
			idcontacto_todos,
			idcliente,
			idusuario,
			clasificacion,
			numero,
			nombre,
			cargo,
			email,
			ciudad,
			fecha_hora,
			resultado,
			presentacion,
			observaciones,
			notas_fletes,
			notas_otm,
			estado
		) (
			select
				idcontacto_todos,
				idcliente,
				idusuario,
				clasificacion,
				numero,
				nombre,
				cargo,
				email,
				ciudad,
				fecha_hora,
				resultado,
				presentacion,
				observaciones,
				notas_fletes,
				notas_otm,
				estado
			from
				cot_temp
			where idcot_temp='$_GET[idcot_temp]')";
    if(!$exenueva = mysqli_query($link,$sqlnueva))
        echo "No almacenó contacte al administrador";

    $sqlast = "SELECT LAST_INSERT_ID() ultimo FROM cot_temp";
    $exelast = mysqli_query($link,$sqlast);
    $row = mysqli_fetch_array($exelast);
    $nuevo_idcot_temp = $row['ultimo'];

    $sqlnueva = "select * from cot_temp where idcot_temp='$_GET[idcot_temp]'";
    $exenueva = mysqli_query($link,$sqlnueva);
    $datosn = mysqli_fetch_array($exenueva);

    $nuevo_numero = scai_get_name("$_SESSION[numberid]","usuarios", "idusuario", "codigo").$nuevo_idcot_temp;
    $sqlnueva = "update cot_temp set numero='$nuevo_numero', fecha_hora=NOW(), idusuario='$_SESSION[numberid]' where idcot_temp='$nuevo_idcot_temp'";
    $exenueva = mysqli_query($link,$sqlnueva);

    if($datosn['clasificacion'] == 'fcl' || $datosn['clasificacion'] == 'lcl')
        $sqlnueva = "select idcot_fletes from cot_fletes where idcot_temp='$_GET[idcot_temp]'";
    if($datosn['clasificacion'] == 'aereo')
        $sqlnueva = "select idcot_fletes_aereo from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]'";
    //print $sqlnueva.'<br>';
    $exenueva3 = mysqli_query($link,$sqlnueva);
    while($datosn2 = mysqli_fetch_array($exenueva3)){
        if($datosn['clasificacion'] == 'fcl' || $datosn['clasificacion'] == 'lcl')
            $sqlnueva2 = "insert into cot_fletes(idtipo, idtarifario, idcot_temp, baf, gri, pss, fleteventa, all_in_20, all_in_40, all_in_40hq, total_neta, minimo_venta, condiciones) (select idtipo, idtarifario, idcot_temp, baf, gri, pss, fleteventa, all_in_20, all_in_40, all_in_40hq, total_neta, minimo_venta, condiciones from cot_fletes where idcot_fletes='$datosn2[idcot_fletes]')";

        if($datosn['clasificacion'] == 'aereo')
            $sqlnueva2 = "insert into cot_fletes_aereo(idtipo_aereo, idtarifario_aereo, idcot_temp, valor, margen, venta, condiciones) (select idtipo_aereo, idtarifario_aereo, idcot_temp, valor, margen, venta, condiciones from cot_fletes_aereo where idcot_fletes_aereo='$datosn2[idcot_fletes_aereo]')";
        $exenueva2 = mysqli_query($link,$sqlnueva2);

        if($datosn['clasificacion'] == 'fcl' || $datosn['clasificacion'] == 'lcl')
            $sqlast = "SELECT LAST_INSERT_ID() ultimo FROM cot_fletes";
        if($datosn['clasificacion'] == 'aereo')
            $sqlast = "SELECT LAST_INSERT_ID() ultimo FROM cot_fletes_aereo";
        $exelast = mysqli_query($link,$sqlast);
        $row = mysqli_fetch_array($exelast);
        $nuevo_id = $row['ultimo'];

        if($datosn['clasificacion'] == 'fcl' || $datosn['clasificacion'] == 'lcl')
            $sqlnueva2 = "update cot_fletes set idcot_temp='$nuevo_idcot_temp' where idcot_fletes='$nuevo_id'";
        if($datosn['clasificacion'] == 'aereo')
            $sqlnueva2 = "update cot_fletes_aereo set idcot_temp='$nuevo_idcot_temp' where idcot_fletes_aereo='$nuevo_id'";
        $exenueva = mysqli_query($link,$sqlnueva2);

        //actualización valores------------------------

        if($datosn['clasificacion'] == 'fcl' || $datosn['clasificacion'] == 'lcl')
            $sqln = "select * from cot_fletes where idcot_fletes='$nuevo_id'";
        if($datosn['clasificacion'] == 'aereo')
            $sqln = "select * from cot_fletes_aereo where idcot_fletes_aereo='$nuevo_id'";
        //print $sqln.'<br>';
        $exen = mysqli_query($link,$sqln);
        $datosn4 = mysqli_fetch_array($exen);

        if($datosn['clasificacion'] == 'fcl' || $datosn['clasificacion'] == 'lcl')
            $fecha_vigencia = scai_get_name("$datosn4[idtarifario]", "tarifario", "idtarifario", "fecha_vigencia");
        if($datosn['clasificacion'] == 'aereo')
            $fecha_vigencia = scai_get_name("$datosn4[idtarifario_aereo]", "tarifario_aereo", "idtarifario_aereo", "fecha_vigencia");

        if($datosn['clasificacion'] == 'fcl'){
            $sqln = "select * from tipo where idtipo='$datosn4[idtipo]'";
            $exen = mysqli_query($link,$sqln);
            $datosn5 = mysqli_fetch_array($exen);

            $fleteventa = $datosn4['all_in'];
            if ($datosn5['all_in'] != '')
                $fleteventa = $datosn5['all_in'];

            if($datosn4['baf']=='1')
                $fleteventa = $fleteventa - $datosn5['baf'].'<br>';
            if($datosn4['gri']=='1')
                $fleteventa = $fleteventa - $datosn5['gri_1'].'<br>';
            if($datosn4['pss']=='1')
                $fleteventa = $fleteventa - $datosn5['peak_season'].'<br>';

            $sqln = "select * from tipo where idtarifario='$datosn4[idtarifario]' and tipo='20'";
            $exen = mysqli_query($link,$sqln);
            $datosn4 = mysqli_fetch_array($exen);
            $all_in_20 = $datosn4['all_in'];

            $sqln = "select * from tipo where idtarifario='$datosn4[idtarifario]' and tipo='40'";
            $exen = mysqli_query($link,$sqln);
            $datosn4 = mysqli_fetch_array($exen);
            $all_in_40 = $datosn4['all_in'];

            $sqln = "select * from tipo where idtarifario='$datosn4[idtarifario]' and tipo='40hq'";
            $exen = mysqli_query($link,$sqln);
            $datosn4 = mysqli_fetch_array($exen);
            $all_in_40hq = $datosn4['all_in'];
        }elseif($datosn['clasificacion'] == 'lcl'){
            $sqln = "select * from tipo_lcl where idtipo_lcl='$datosn4[idtipo]'";
            $exen = mysqli_query($link,$sqln);
            $datosn4 = mysqli_fetch_array($exen);

            $fleteventa = $datosn4['total_neta'];
            $total_neta = $datosn4['total_neta'];
            $minimo_venta = $datosn4['minimo_venta'];
        }elseif($datosn['clasificacion'] == 'aereo'){
            $sqln = "select * from tipo_aereo where idtipo_aereo='$datosn4[idtipo_aereo]'";
            $exen = mysqli_query($link,$sqln);
            $datosn4 = mysqli_fetch_array($exen);
            $venta = $datosn4['venta'];
        }


        if($datosn['clasificacion'] == 'fcl' || $datosn['clasificacion'] == 'lcl')
            $sqlnueva4 = "update cot_fletes set  fleteventa='$fleteventa', all_in_20='$all_in_20', all_in_40='$all_in_40', all_in_40hq='$all_in_40hq', total_neta='$total_neta', minimo_venta='$minimo_venta' where idcot_fletes='$nuevo_id'";
        if($datosn['clasificacion'] == 'aereo')
            $sqlnueva4 = "update cot_fletes_aereo set venta='$venta' where idcot_fletes_aereo='$nuevo_id'";
        $exenueva4 = mysqli_query($link,$sqlnueva4);
    }
    //-------------------------------------------------------------------------

    $sqlnueva = "select idcot_adu from cot_adu where idcot_temp='$_GET[idcot_temp]'";
    $exenueva = mysqli_query($link,$sqlnueva);
    while($datosn2 = mysqli_fetch_array($exenueva)){
        $sqlnueva2 = "insert into cot_adu(idaduana, idcot_temp, porcentaje, minimo, observaciones, descripcion, mostrar) (select idaduana, idcot_temp, porcentaje, minimo, observaciones, descripcion, mostrar from cot_adu where idcot_adu='$datosn2[idcot_adu]')";
        $exenueva2 = mysqli_query($link,$sqlnueva2);

        $sqlast = "SELECT LAST_INSERT_ID() ultimo FROM cot_adu";
        $exelast = mysqli_query($link,$sqlast);
        $row = mysqli_fetch_array($exelast);
        $nuevo_id = $row['ultimo'];

        $sqlnueva2 = "update cot_adu set idcot_temp='$nuevo_idcot_temp' where idcot_adu='$nuevo_id'";
        $exenueva2 = mysqli_query($link,$sqlnueva2);

        //actualización valores-------------------------------------------

        $sqln = "select * from cot_adu where idcot_adu='$nuevo_id'";
        $exen = mysqli_query($link,$sqln);
        $datosn4 = mysqli_fetch_array($exen);

        $fecha_vigencia = scai_get_name("$datosn4[idaduana]", "aduana", "idaduana", "fecha_validez");

        $sqln = "select * from aduana where idaduana='$datosn4[idaduana]'";
        $exen = mysqli_query($link,$sqln);
        $datosn4 = mysqli_fetch_array($exen);

        $porcentaje = $datosn4['porcentaje_venta'];
        $minimo = $datosn4['minimo_venta'];

        $sqlnueva4 = "update cot_adu set porcentaje='$porcentaje', minimo='$minimo' where idcot_adu='$nuevo_id'";
        $exenueva4 = mysqli_query($link,$sqlnueva4);
        //----------------------------------------------------------------------------------------------
    }

    $sqlnueva = "select idcot_bodega from cot_bodegas where idcot_temp='$_GET[idcot_temp]'";
    $exenueva = mysqli_query($link,$sqlnueva);
    while($datosn2 = mysqli_fetch_array($exenueva)){
        $sqlnueva2 = "insert into cot_bodegas(idbodega, idcot_temp, advaloren_venta, min_advaloren, mes_fraccion_venta, min_mes_fraccion, mes_fraccion_40_venta, min_mes_fraccion_40, condiciones) (select idbodega, idcot_temp, advaloren_venta, min_advaloren, mes_fraccion_venta, min_mes_fraccion, mes_fraccion_40_venta, min_mes_fraccion_40, condiciones from cot_bodegas where idcot_bodega='$datosn2[idcot_bodega]')";
        $exenueva2 = mysqli_query($link,$sqlnueva2);

        $sqlast = "SELECT LAST_INSERT_ID() ultimo FROM cot_bodegas";
        $exelast = mysqli_query($link,$sqlast);
        $row = mysqli_fetch_array($exelast);
        $nuevo_id = $row['ultimo'];

        $sqlnueva2 = "update cot_bodegas set idcot_temp='$nuevo_idcot_temp' where idcot_bodega='$nuevo_id'";
        $exenueva2 = mysqli_query($link,$sqlnueva2);

        //actualización valores----------------------------------

        $sqln = "select * from cot_bodegas where idcot_bodega='$nuevo_id'";
        $exen = mysqli_query($link,$sqln);
        $datosn4 = mysqli_fetch_array($exen);

        $fecha_vigencia = scai_get_name("$datosn4[idbodega]", "bodega", "idbodega", "fecha_validez");

        $sqln = "select * from bodega where idbodega='$datosn4[idbodega]'";
        $exen = mysqli_query($link,$sqln);
        $datosn4 = mysqli_fetch_array($exen);

        $advaloren_venta = $datosn4['advaloren_venta'];
        $min_advaloren = $datosn4['min_advaloren'];
        $mes_fraccion_venta = $datosn4['mes_fraccion_venta'];
        $min_mes_fraccion = $datosn4['min_mes_fraccion'];
        $mes_fraccion_40_venta = $datosn4['mes_fraccion_40_venta'];
        $min_mes_fraccion_40 = $datosn4['min_mes_fraccion_40'];

        $sqlnueva4 = "update cot_bodegas set advaloren_venta='$advaloren_venta', min_advaloren='$min_advaloren', mes_fraccion_venta='$mes_fraccion_venta', min_mes_fraccion='$min_mes_fraccion', mes_fraccion_40_venta='$mes_fraccion_40_venta', min_mes_fraccion_40='$min_mes_fraccion_40' where idcot_adu='$nuevo_id'";
        $exenueva4 = mysqli_query($link,$sqlnueva4);
        //--------------------------------------------------------------------------------------
    }

    $sqlnueva = "select idcot_otm from cot_otm where idcot_temp='$_GET[idcot_temp]'";
    $exenueva = mysqli_query($link,$sqlnueva);
    while($datosn2 = mysqli_fetch_array($exenueva)){
        $sqlnueva2 = "insert into cot_otm(idotm, idcot_temp, valor_venta, condiciones, documentacion, devolucion, escolta) (select idotm, idcot_temp, valor_venta, condiciones, documentacion, devolucion, escolta from cot_otm where idcot_otm='$datosn2[idcot_otm]')";
        $exenueva2 = mysqli_query($link,$sqlnueva2);

        $sqlast = "SELECT LAST_INSERT_ID() ultimo FROM cot_otm";
        $exelast = mysqli_query($link,$sqlast);
        $row = mysqli_fetch_array($exelast);
        $nuevo_id = $row['ultimo'];

        $sqlnueva2 = "update cot_otm set idcot_temp='$nuevo_idcot_temp' where idcot_otm='$nuevo_id'";
        $exenueva2 = mysqli_query($link,$sqlnueva2);

        //actualización valores---------------------------------------------------------------------------------------

        $sqln = "select * from cot_otm where idcot_otm='$nuevo_id'";
        $exen = mysqli_query($link,$sqln);
        $datosn4 = mysqli_fetch_array($exen);

        $fecha_vigencia = scai_get_name("$datosn4[idotm]", "otm", "idotm", "fecha_validez");

        $sqln = "select * from otm where idotm='$datosn4[idotm]'";
        $exen = mysqli_query($link,$sqln);
        $datosn4 = mysqli_fetch_array($exen);

        $valor_venta = $datosn4['valor_venta'];

        $sqlnueva4 = "update cot_otm set valor_venta='$valor_venta' where idcot_otm='$nuevo_id'";
        $exenueva4 = mysqli_query($link,$sqlnueva4);
        //---------------------------------------------------------------------------------------------
    }

    $sqlnueva = "select idcot_seg from cot_seg where idcot_temp='$_GET[idcot_temp]'";
    $exenueva = mysqli_query($link,$sqlnueva);
    while($datosn2 = mysqli_fetch_array($exenueva)){
        $sqlnueva2 = "insert into cot_seg(idseguro, idcot_temp, porcentaje, monto_aseg, minimo, valor, observaciones, descripcion, mostrar) (select idseguro, idcot_temp, porcentaje, monto_aseg, minimo, valor, observaciones, descripcion, mostrar from cot_seg where idcot_seg='$datosn2[idcot_seg]')";
        $exenueva2 = mysqli_query($link,$sqlnueva2);

        $sqlast = "SELECT LAST_INSERT_ID() ultimo FROM cot_seg";
        $exelast = mysqli_query($link,$sqlast);
        $row = mysqli_fetch_array($exelast);
        $nuevo_id = $row['ultimo'];

        $sqlnueva2 = "update cot_seg set idcot_temp='$nuevo_idcot_temp' where idcot_seg='$nuevo_id'";
        $exenueva2 = mysqli_query($link,$sqlnueva2);

        //actualización valores-----------------------------------------------------------------------------------------

        $sqln = "select * from cot_seg where idcot_seg='$nuevo_id'";
        $exen = mysqli_query($link,$sqln);
        $datosn4 = mysqli_fetch_array($exen);

        $fecha_vigencia = scai_get_name("$datosn4[idseguro]", "seguro", "idseguro", "fecha_validez");

        $sqln = "select * from seguro where idseguro='$datosn4[idseguro]'";
        $exen = mysqli_query($link,$sqln);
        $datosn4 = mysqli_fetch_array($exen);

        $porcentaje = $datosn4['porcentaje_venta'];
        $minimo = $datosn4['minimo_venta'];
        $sqlnueva4 = "update cot_seg set porcentaje='$porcentaje', minimo='$minimo' where idcot_seg='$nuevo_id'";
        $exenueva4 = mysqli_query($link,$sqlnueva4);
        //-------------------------------------------------------------------------------------------------------------------------
    }

    $sqlnueva = "select idcot_terrestre from cot_terrestre where idcot_temp='$_GET[idcot_temp]'";
    $exenueva = mysqli_query($link,$sqlnueva);
    while($datosn2 = mysqli_fetch_array($exenueva)){
        $sqlnueva2 = "insert into cot_terrestre(idterrestre, idcot_temp, valor_venta, condiciones, documentacion, devolucion, escolta) (select idterrestre, idcot_temp, valor_venta, condiciones, documentacion, devolucion, escolta from cot_terrestre where idcot_terrestre='$datosn2[idcot_terrestre]')";
        $exenueva2 = mysqli_query($link,$sqlnueva2);

        $sqlast = "SELECT LAST_INSERT_ID() ultimo FROM cot_terrestre";
        $exelast = mysqli_query($link,$sqlast);
        $row = mysqli_fetch_array($exelast);
        $nuevo_id = $row['ultimo'];

        $sqlnueva2 = "update cot_terrestre set idcot_temp='$nuevo_idcot_temp' where idcot_terrestre='$nuevo_id'";
        $exenueva2 = mysqli_query($link,$sqlnueva2);

        //actualización valores---------------------------------------------------------------------------------------------------

        $sqln = "select * from cot_terrestre where idcot_terrestre='$nuevo_id'";
        $exen = mysqli_query($link,$sqln);
        $datosn4 = mysqli_fetch_array($exen);

        $fecha_vigencia = scai_get_name("$datosn4[idterrestre]", "terrestre", "idterrestre", "fecha_validez");

        $sqln = "select * from terrestre where idterrestre='$datosn4[idterrestre]'";
        $exen = mysqli_query($link,$sqln);
        $datosn4 = mysqli_fetch_array($exen);

        $valor_venta = $datosn4['valor_venta'];

        $sqlnueva4 = "update cot_terrestre set valor_venta='$valor_venta' where idcot_terrestre='$nuevo_id'";
        $exenueva4 = mysqli_query($link,$sqlnueva4);
        //---------------------------------------------------------------------
    }

    $sqlnueva2 = "insert into cotizacion_local(idcot_temp, clasificacion, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, valor_gastos_hbl, valor_gastos_cont, valor_gastos_wm, observaciones) (select idcot_temp, clasificacion, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, valor_gastos_hbl, valor_gastos_cont, valor_gastos_wm, observaciones from cotizacion_local where idcot_temp='$_GET[idcot_temp]')";
    $exenueva2 = mysqli_query($link,$sqlnueva2);

    $sqlast = "SELECT LAST_INSERT_ID() ultimo FROM cotizacion_local";
    $exelast = mysqli_query($link,$sqlast);
    $row = mysqli_fetch_array($exelast);
    $nuevo_id = $row['ultimo'];

    $sqlnueva2 = "update cotizacion_local set idcot_temp='$nuevo_idcot_temp' where idcotizacion_local='$nuevo_id'";
    $exenueva2 = mysqli_query($link,$sqlnueva2);

    $sqlnueva2 = "select idcotizacion_local from cotizacion_local where idcot_temp='$_GET[idcot_temp]'";
    $exenueva2 = mysqli_query($link,$sqlnueva2);
    $datosn2 = mysqli_fetch_array($exenueva2);

    $sqlnueva2 = "INSERT INTO totales_cotizacion_local (
					idnaviera,
					idcotizacion_local,
					nombre_gastos_hbl,
					nombre_gastos_cont,
					nombre_gastos_wm,
					valor_gastos_hbl,
					valor_gastos_hbl_min,
					valor_gastos_hbl_min5,
					valor_gastos_hbl_min10, valor_gastos_hbl_min15, valor_gastos_cont, valor_gastos_wm, valor_gastos_wm_min, valor_gastos_wm_min5, valor_gastos_wm_min10, valor_gastos_wm_min15, mostrar_var, collection_fee, min_collection_fee, caf, min_caf, mostrar_collection_fee, mostrar_caf, mostrar_rangos, mostrar_referencia, nombre_gastos_hawb, nombre_gastos_embarque, nombre_gastos_kilo, valor_gastos_hawb, valor_gastos_embarque, valor_gastos_kilo) (select idnaviera, idcotizacion_local, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, valor_gastos_hbl,valor_gastos_hbl_min, valor_gastos_hbl_min5, valor_gastos_hbl_min10, valor_gastos_hbl_min15, valor_gastos_cont, valor_gastos_wm, valor_gastos_wm_min, valor_gastos_wm_min5, valor_gastos_wm_min10, valor_gastos_wm_min15, mostrar_var, collection_fee, min_collection_fee, caf, min_caf, mostrar_collection_fee, mostrar_caf, mostrar_rangos, mostrar_referencia, nombre_gastos_hawb, nombre_gastos_embarque, nombre_gastos_kilo, valor_gastos_hawb, valor_gastos_embarque, valor_gastos_kilo from totales_cotizacion_local where idcotizacion_local='$datosn2[idcotizacion_local]')";
    $exenueva2 = mysqli_query($link,$sqlnueva2);

    $sqlast = "SELECT LAST_INSERT_ID() ultimo FROM totales_cotizacion_local";
    $exelast = mysqli_query($link,$sqlast);
    $row = mysqli_fetch_array($exelast);
    $nuevo_id2 = $row['ultimo'];

    $sqlnueva2 = "update totales_cotizacion_local set idcotizacion_local='$nuevo_id' where idtotal_cotizacion_local='$nuevo_id2'";
    $exenueva2 = mysqli_query($link,$sqlnueva2);

    $sqlnueva2 = "select distinct idrecargo_local from local_por_cotizacion where idcotizacion_local='$datosn2[idcotizacion_local]'";
    $exenueva2 = mysqli_query($link,$sqlnueva2);

    while($datosn3 = mysqli_fetch_array($exenueva2)){
        $sqln = "select * from recargos_local where idrecargo_local='$datosn3[idrecargo_local]'";
        $exen = mysqli_query($link,$sqln);
        $datosn4 = mysqli_fetch_array($exen);


        $sqln = "INSERT INTO local_por_cotizacion (idrecargo_local, idcotizacion_local, valor_venta, minimo_venta) VALUES ('$datosn4[idrecargo_local]', '$nuevo_id', '$datosn4[valor_venta]', '$datosn4[minimo_venta]')";
        $exen = mysqli_query($link,$sqln);
    }

    //recargos cliente------------------------------------------------------------------------

    $sqlnueva2 = "INSERT INTO totales_cliente_local (idcot_temp, idnaviera, idcliente_local, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, valor_gastos_hbl,valor_gastos_hbl_min, valor_gastos_hbl_min5, valor_gastos_hbl_min10, valor_gastos_hbl_min15, valor_gastos_cont, valor_gastos_wm, valor_gastos_wm_min, valor_gastos_wm_min5, valor_gastos_wm_min10, valor_gastos_wm_min15, mostrar_var, collection_fee, min_collection_fee, caf, min_caf, mostrar_collection_fee, mostrar_caf, mostrar_rangos, mostrar_referencia, nombre_gastos_hawb, nombre_gastos_embarque, nombre_gastos_kilo, valor_gastos_hawb, valor_gastos_embarque, valor_gastos_kilo) (select idcot_temp, idnaviera, idcliente_local, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, valor_gastos_hbl,valor_gastos_hbl_min, valor_gastos_hbl_min5, valor_gastos_hbl_min10, valor_gastos_hbl_min15, valor_gastos_cont, valor_gastos_wm, valor_gastos_wm_min, valor_gastos_wm_min5, valor_gastos_wm_min10, valor_gastos_wm_min15, mostrar_var, collection_fee, min_collection_fee, caf, min_caf, mostrar_collection_fee, mostrar_caf, mostrar_rangos, mostrar_referencia, nombre_gastos_hawb, nombre_gastos_embarque, nombre_gastos_kilo, valor_gastos_hawb, valor_gastos_embarque, valor_gastos_kilo from totales_cliente_local where idcot_temp='$_GET[idcot_temp]')";
    $exenueva2 = mysqli_query($link,$sqlnueva2);

    $sqlast = "SELECT LAST_INSERT_ID() ultimo FROM totales_cliente_local";
    $exelast = mysqli_query($link,$sqlast);
    $row = mysqli_fetch_array($exelast);
    $nuevo_id = $row['ultimo'];

    $sqlnueva2 = "update totales_cliente_local set idcot_temp='$nuevo_idcot_temp' where idtotal_cliente_local='$nuevo_id'";
    $exenueva2 = mysqli_query($link,$sqlnueva2);

    $sqlnueva2 = "select distinct idrecargo_local from local_por_cliente where idcot_temp='$_GET[idcot_temp]'";
    $exenueva2 = mysqli_query($link,$sqlnueva2);

    while($datosn3 = mysqli_fetch_array($exenueva2))
    {
        $sqln = "select * from recargos_local_cliente where idrecargo_local_cliente='$datosn3[idrecargo_local]'";
        $exen = mysqli_query($link,$sqln);
        $datosn4 = mysqli_fetch_array($exen);

        $idcliente = scai_get_name("$nuevo_idcot_temp","cot_temp", "idcot_temp", "idcliente");
        $sqln = "INSERT INTO local_por_cliente (idcot_temp, idrecargo_local, idcliente, valor_venta, minimo_venta) VALUES ('$nuevo_idcot_temp', '$datosn4[idrecargo_local_cliente]', '$idcliente', '$datosn4[valor_venta]', '$datosn4[minimo_venta]')";
        $exen = mysqli_query($link,$sqln);
    }

    //recargos origen------------------------------------------------------------------------

    $sqlnueva2 = "INSERT INTO cotizacion_origen (
						mostrar_var,
						idcot_temp,
						clasificacion,
						nombre_gastos_hbl,
						nombre_gastos_cont,
						nombre_gastos_wm,
						nombre_gastos_hawb,
						nombre_gastos_embarque,
						nombre_gastos_kilo,
						valor_gastos_hbl,
						valor_gastos_cont,
						valor_gastos_wm,
						valor_gastos_hawb,
						valor_gastos_embarque,
						valor_gastos_kilo,
						observaciones
						) (select mostrar_var, idcot_temp, clasificacion, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, nombre_gastos_hawb, nombre_gastos_embarque, nombre_gastos_kilo, valor_gastos_hbl, valor_gastos_cont, valor_gastos_wm, valor_gastos_hawb, valor_gastos_embarque, valor_gastos_kilo, observaciones from cotizacion_origen where idcot_temp='$_GET[idcot_temp]')";


    $exenueva2 = mysqli_query($link,$sqlnueva2);

    $sqlast = "SELECT LAST_INSERT_ID() ultimo FROM cotizacion_origen";
    $exelast = mysqli_query($link,$sqlast);
    $row = mysqli_fetch_array($exelast);
    $nuevo_id = $row['ultimo'];

    $sqlnueva2 = "update cotizacion_origen set idcot_temp='$nuevo_idcot_temp' where idcotizacion_origen='$nuevo_id'";
    $exenueva2 = mysqli_query($link,$sqlnueva2);

    $idcotizacion_origen = scai_get_name("$_GET[idcot_temp]", "cotizacion_origen", "idcot_temp", "idcotizacion_origen");
    $sqlnueva2 = "select distinct idrecargo_origen from origen_por_cotizacion where idcotizacion_origen='$idcotizacion_origen'";
    $exenueva2 = mysqli_query($link,$sqlnueva2);

    while($datosn3 = mysqli_fetch_array($exenueva2)){
        $sqln = "select * from recargos_origen where idrecargo_origen='$datosn3[idrecargo_origen]'";
        $exen = mysqli_query($link,$sqln);
        $datosn4 = mysqli_fetch_array($exen);

        $sqln = "INSERT INTO origen_por_cotizacion (idrecargo_origen, idcotizacion_origen, valor_venta) VALUES ('$datosn4[idrecargo_origen]', '$nuevo_id', '$datosn4[valor]')";
        $exen = mysqli_query($link,$sqln);
    }
    $_GET['idcot_temp'] = $nuevo_idcot_temp;
    ?><script>document.location='paso5_final.php?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl']?>&nueva=no';</script><?
}



if($_POST['destinok']=='atras'){
    $destino = 'tarif_recargos_local.php';?>
    <script>
		document.location='<? print $destino; ?>?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl']?>&nueva=no';
	</script><?
}

if($_POST['marca']=='si'){
    $querymod="update $tabla set estado='terminada' where $llave='$_GET[idcot_temp]'";

    $buscarmod=mysqli_query($link,$querymod);
    if($buscarmod)
        print ("<script>alert('Cotizacion marcada')</script>");
}
if($_POST['exi']=='si'){
    $querymod="update $tabla set resultado='$_POST[resultado]',motivo_no_exit = '".$_POST['no_exitosa']."' where $llave='$_GET[idcot_temp]'";

    $buscarmod=mysqli_query($link,$querymod);
    if($buscarmod)
        print ("<script>alert('Cotizacion $_POST[resultado]')</script>");
}


if (isset($_POST['idcliente']) && $_POST['idcliente']!='')
    $_GET['idcliente'] == $_POST['idcliente'];


if($_POST['estado']){
    $sqlEstado = "INSERT INTO `seguimientos_cot` (
					`idcot_temp`,
					`fecha`,
					`seguimiento`
				) VALUES (
					'".$_GET['idcot_temp']."',
					'".date("Y-m-d H:i:s")."',
					'".$_POST['estado']."'
				);";
    if(mysqli_query($link,$sqlEstado))
        echo "<script>alert('Guardo')</script>";
}

?>

<body style="background-color: transparent;" oncontextmenu="return false;">
<form name="formulario" method="post">
    <input name="datosok" type="hidden" value="no" />

    <input name="destinok" type="hidden" value="siguiente" />
    <input name="varelimi" type="hidden" value="no" />
    <input name="marca" type="hidden" value="no" />
    <input name="exi" type="hidden" value="no" />
    <input type="hidden" name="listaEliminar" value="" />
    <input name="idcliente" type="hidden" value="<? print $_GET['idcliente'] ?>" />
    <input name="xyz" type="hidden" value="" /><?

    if($_GET['idcliente'] != ''){
        $sqlad = "select * from clientes where idcliente='$_GET[idcliente]'";
        $exead = mysqli_query($link,$sqlad);
        $datosad = mysqli_fetch_array($exead);

        ?><script>validaPais(document.getElementByName('formulario'));</script><?
    }
    /*
    if(isset($_GET['xyz']) and $_GET['xyz']!="")
        $_POST['xyz'] = $_GET['xyz'];
    if(isset($_POST['xyz']) and $_POST['xyz']!=""){
        $sql = "SELECT * FROM clientes WHERE nombre LIKE '%$_POST[xyz]%'";
        $query = mysqli_query($link,$sql);
        $filas = mysqli_num_rows($query);
        if ($filas == 0)
            print ("<script>alert('Este cliente no existe vuelva a intentarlo')</script>");
        else
        {
            if ($filas == 1)
            {
                $row = mysqli_fetch_array($query);
                print ("<script>document.location.href='".$_SERVER['PHP_SELF']."?idcliente=$row[idcliente]&nueva=no'</script>");
            }
        }
    }*/
    ?>

    <table border="0" width="100%">
        <tr>
            <td align="center">
                <span class="contenidotab" style="font-size:14px;"><a href="paso1_selcliente.php?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl']?>">Paso 1: Seleccionar cliente</a>|<a href="cotizador.php?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl']?>">Paso 2: Seleccionar fletes</a>|<a href="tarif_recargos_origen.php?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl']?>">Paso 3: Cotizar recargos de origen</a>|<a href="tarif_recargos_local.php?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl']?>">Paso 4: Cotizar recargos locales</a></span>
            </td>
        </tr>
    </table>

    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center">
        <tr>
            <td class="subtitseccion" style="text-align:center" colspan="4">
                <? if($_GET['idcot_temp']!='') print 'COTIZACI&Oacute;N '.scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero").', '?>PASO 5 DE 5: FINALIZAR <? print $_GET['cl'];  ?> <br><br>
            </td>
        </tr>
    </table>

    <table width="100%" align="center">
        <tr>
            <td>
                <table>
                    <tr>
                        <? if(puedo("m","COTIZACION")==1 && $filasrn==0) { ?>
                            <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="irAtras(formulario);">Atras</a></td>
                        <? } ?>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center">
        <tr>
            <td align="center" valign="top">
                <table border="0" width="100%" cellpadding="5" cellspacing="0" align="center" style="font-size:11px;">
                    <tr>
                        <td>
                            <table border="0" width="100%">
                                <?
                                $sqlad2 = "select * from cot_temp where idcot_temp='$_GET[idcot_temp]'";
                                $exead2 = mysqli_query($link,$sqlad2);
                                $datosad2 = mysqli_fetch_array($exead2);?>



                                </tr>
                                <? if(puedo("m","COTIZACION")==1) { ?>
                                    <tr>
                                        <td>
                                        </td>
                                    </tr><?
                                } ?>
                            </table>
                        </td>
                    </tr>
                    <tr><td align="center">Operaciones</td></tr>
                    <? if(puedo("m","COTIZACION")==1) { ?>
                        <tr>
                            <td  align="left">
                                <?
                                if($_GET['accion']=="nada")
                                {
                                    $mena="Marcada como terminada";
                                    $est="disabled";
                                }
                                else
                                    $mena="Marcar como terminada";
                                ?>

                                <input type="button" class="botonesadmin" style="font-size:11px; color:#FFFFFF;" <? print $est;?> value="<? print $mena;?>" name="marcar" onClick="validaEnvia2(formulario)">
                                <?
                                $etha="select * from cot_temp where idcot_temp='$_GET[idcot_temp]'";
                                $la_row=mysqli_query($link,$etha);
                                $joar=mysqli_fetch_array($la_row);

                                if($joar['estado']=="terminada"){?>
                                    Resultado&nbsp;<select name="resultado" id="resultado" onChange="validaEnvia3(formulario)">
                                    <option value="N">Seleccione</option>
                                    <option value="exitosa" <? if($joar['resultado']=="exitosa") print " selected";?>>Exitosa</option>
                                    <option value="no_exitosa" <? if($joar['resultado']=="no_exitosa") print " selected";?>>No exitosa</option>
                                    </select><?
                                }?>
                                <?
                                if($joar['resultado']=="no_exitosa"){ //crea text para justificar por que la cotizacion no es exitosa
                                ?>
                                <p class="subtitseccion">Indique el motivo por el cual, la cotizacion no es exitosa:<p>
                                    <textarea name="no_exitosa" onChange="validaEnvia3(formulario)"><? echo $joar['motivo_no_exit'];?></textarea>
                                    <?
                                    }
                                    ?>

                            </td>
                        </tr>
                    <? } ?>
                    <tr><td height="7"></td>


                    <tr>
                        <td align="left">
                            <? if(puedo("m","COTIZACION")==1) { ?>
                                <input type="button" class="botonesadmin" style="font-size:11px; color:#FFFFFF;" value="Ajustar condiciones de fletes" name="email" onClick="javascript:winback('notas_cot.php?id=<? print $_GET['idcot_temp'];?>&cl=<? print $_GET['cl'] ?>&campo=cond')">
                            <? } ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <input type="button" class="botonesadmin" style="font-size:11px; color:#FFFFFF;" value="Imprimir" name="imprimir" onClick="javascript:framePrint3('cotizacion');">
                        </td>
                    </tr>
                </table><br>

                <?
                    $sqlf = "select * from cot_fletes where idcot_temp='".$_GET["idcot_temp"]."'";
                    $exef = mysqli_query($link,$sqlf);
                    $filasf = mysqli_num_rows($exef);
                    $item=1;

                    if($filasf > 0 && $_GET['cl'] == 'fcl'|| $_GET['cl']=='lcl'){
                        $sqlc = "select distinct idtarifario from cot_fletes where idcot_temp='".$_GET["idcot_temp"]."'";
                        $exec = mysqli_query($link,$sqlc);

                        while($datosc= mysqli_fetch_array($exec)){
                            $sqlt = "select * from tarifario where idtarifario='".$datosc["idtarifario"]."'";
                            $exet = mysqli_query($link,$sqlt);

                            if($datost = mysqli_fetch_array($exet)){
                                $sqlv = "select * from cot_fletes where idcot_temp='".$_GET["idcot_temp"]."' and idtarifario='".$datosc["idtarifario"]."'";
                                $exev = mysqli_query($link,$sqlv);
                                $datosv =  mysqli_fetch_array($exev);

                                $sqln = "select NOW() as ahora";
                                $exen = mysqli_query($link,$sqln);
                                $datosn3 = mysqli_fetch_array($exen);
                                $color = '#000000';
                                if($datost['fecha_vigencia'] < $datosn3['ahora']) {
                                    $color = '#FF0000';
                                }

                                echo "
                                    <table border='0' width='100%' cellpadding='0' cellspacing='0'     align='center' style='font-size:11px;'>
                                    <td height='40' class='subtitseccion' style='text-align:center'>OBSERVACIONES DEL TARIFARIO FLETE</td>
                                        <tr>
                                            <td align='center' >".$datost['observaciones']."</td>
                                        </tr>
                                    </table>&nbsp
                                ";
                            }

                        }
                    }

                    if($_GET['cl'] == 'aereo'){
                        $sqlc = "select distinct idtarifario_aereo from cot_fletes_aereo where idcot_temp='".$_GET["idcot_temp"]."'";
                        $exec = mysqli_query($link,$sqlc);

                        while($datosc= mysqli_fetch_array($exec)){
                            $sqlt = "select * from tarifario_aereo where idtarifario_aereo='".$datosc["idtarifario_aereo"]."'";
                            $exet = mysqli_query($link,$sqlt);
                            while($datost = mysqli_fetch_array($exet)){
                                $sqlv = "select * from cot_fletes_aereo where idcot_temp='".$_GET["idcot_temp"]."' and idtarifario_aereo='".$datosc["idtarifario_aereo"]."'";
                                $exev = mysqli_query($link,$sqlv);
                                $datosv =  mysqli_fetch_array($exev);

                                $sqln = "select NOW() as ahora";
                                $exen = mysqli_query($link,$sqln);
                                $datosn3 = mysqli_fetch_array($exen);
                                $color = '#000000';
                                if($datost['fecha_vigencia'] < $datosn3['ahora']) {
                                    $color = '#FF0000';
                                }

                                echo "
                                    <table border='0' width='100%' cellpadding='0' cellspacing='0'     align='center' style='font-size:11px;'>
                                    <td height='40' class='subtitseccion' style='text-align:center'>OBSERVACIONES DEL TARIFARIO FLETE</td>
                                        <tr>
                                            <td align='center' >".$datost['restricciones']."</td>
                                        </tr>
                                    </table>&nbsp
                            ";
                            }
                        }
                    }
                ?>

                <table border="0" width="100%" align="center">
                    <tr align="center">
                        <td height="40" class="subtitseccion" style="text-align:center">TERMINOS DE NEGOCIACIÓN</td>
                    </tr>
                    <tr align="center">
                        <td>
                            <select name="icoterm" class="tex1" onChange="form.action='?idcot_temp=<?= $_GET['idcot_temp']?>&cl=<?= $_GET['cl']?>&opc=icoterm';form.submit();">
                                <option></option>
                                <option value="EXW" <? echo( $joar["icoterm"] == "EXW" ) ? "selected='selected'" : "" ;?>>EXW - Ex Works </option>
                                <option value="FAS" <? echo( $joar["icoterm"] == "FAS" ) ? "selected='selected'" : "" ;?>>FAS - Free Alongside Ship</option>
                                <option value="FCA" <? echo( $joar["icoterm"] == "FCA" ) ? "selected='selected'" : "" ;?>>FCA - Free Carrier</option>
                                <option value="FOB" <? echo( $joar["icoterm"] == "FOB" ) ? "selected='selected'" : "" ;?>>FOB - Free On Board</option>
                                <option value="CFR" <? echo( $joar["icoterm"] == "CFR" ) ? "selected='selected'" : "" ;?>>CFR - Cost and Freight</option>
                                <option value="CIF" <? echo( $joar["icoterm"] == "CIF" ) ? "selected='selected'" : "" ;?>>CIF - Cost, Insurance and Freight</option>
                                <option value="CPT" <? echo( $joar["icoterm"] == "CPT" ) ? "selected='selected'" : "" ;?>>CPT - Carrier Paid To</option>
                                <option value="CIP" <? echo( $joar["icoterm"] == "CIP" ) ? "selected='selected'" : "" ;?>>CIP - Carrier and Insurance Paid to</option>
                                <option value="DAT" <? echo( $joar["icoterm"] == "DAT" ) ? "selected='selected'" : "" ;?>>DAT - Delivered At Terminal</option>
                                <option value="DAP" <? echo( $joar["icoterm"] == "DAP" ) ? "selected='selected'" : "" ;?>>DAP - Delivered At Place</option>
                                <option value="DDP" <? echo( $joar["icoterm"] == "DDP" ) ? "selected='selected'" : "" ;?>>DDP - Delivered Duty Paid</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <br>
                <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" style="font-size:11px;">

                    <tr><td align="center">Notas de fletes(ser&aacute;n adicionadas a la cotizaci&oacute;n en negrilla)</td></tr>
                    <tr>
                        <td align="center">
                            <iframe name="notas" id="notas" src="notas_cot.php?id=<? print $_GET['idcot_temp'];?>&cl=<? print $_GET['cl']?>&campo=flete" style="overflow-x:auto; overflow-y:auto; width:270; height:270;" frameborder="0"></iframe>
                        </td>
                    </tr>
                </table>
                <br>
                <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" style="font-size:11px;">
                    <tr><td align="center">Notas de otm (ser&aacute;n adicionadas a la cotizaci&oacute;n en negrilla)</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <iframe name="notas" id="notas" src="notas_cot.php?id=<? print $_GET['idcot_temp'];?>&cl=<? print $_GET['cl']?>&campo=otm" style="overflow-x:auto; overflow-y:auto; width:270; height:270;" frameborder="0"></iframe>
                        </td>
                </table>
                <br>

                <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" style="font-size:11px;">
                    <tr><td height='40' class='subtitseccion' style='text-align:center'>OBSERVACIONES ADICIONALES</td></tr>
                    <tr>
                        <td align="center">
                            <iframe name="observaciones" id="observaciones" src="observaciones.php?id=<? print $_GET['idcot_temp'];?>&cl=<? print $_GET['cl']?>" style="overflow-x:auto; overflow-y:auto; width:270; height:270;" frameborder="0"></iframe>
                        </td>
                </table>
            </td>
            <td align="center" valign="top">

                <iframe name="cotizacion" id="cotizacion"  src="preview.php?tipo=final&id=<? print $_GET['idcot_temp'];?>&cl=<? print $_GET['cl']?>" style="overflow-x:hidden; overflow-y:auto; width:600px; height:500px; background-color:FFFFFF;" frameborder="1"></iframe>


                <p>
                    <img src="images/down.png"> <a href="#" onClick="showDiv(seguimientosCot);"> Seguimiento de Cotizacion </a> <img src="images/down.png">
                <div id="seguimientosCot" style="display:none">
                    <table border="1" width="80%">
                        <tr class="tittabla">
                            <td width="20%">Fecha</td>
                            <td width="80%">Estado</td>
                        </tr>

                        <tr class="contenidotab">
                            <td><?= date("Y-m-d");?></td>
                            <td>
                                <form method="post" action="?idcot_temp=<?= $_GET['idcot_temp']?>&cl=<?= $_GET['cl']?>">
                                    <textarea name="estado" required></textarea>
                                    <input type="submit" value="Guardar" class="botonesadmin">
                                </form>
                            </td>
                        </tr>
                        <?
                        $sqlSeg = "select * from seguimientos_cot where idcot_temp = ".$_GET['idcot_temp']." order by fecha desc";
                        $qrySeg = mysqli_query($link,$sqlSeg);
                        while( $seguimiento = mysqli_fetch_array($qrySeg) ){?>
                            <tr class="contenidotab">
                                <td><?= $seguimiento["fecha"];?></td>
                                <td><?= $seguimiento["seguimiento"];?></td>
                            </tr>
                            <?
                        }
                        ?>
                    </table>
                </div>
                </p>

            </td>

            <td align="center" valign="top">
                <div style="width:100%; height:200px; overflow-y:auto;">
                    <br><br><br>
            </td>
        </tr>

    </table>
    </td>
    </tr>
    </table>







    <table width="100%" align="center">
        <tr>
            <td>
                <table>
                    <tr>
                        <? if(puedo("m","COTIZACION")==1 && $filasrn==0) { ?>
                            <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="irAtras(formulario);">Atras</a></td><?
                        } ?>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
</body>