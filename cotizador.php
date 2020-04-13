<?
	include('sesion/sesion.php');
	include("conection/conectar.php");	
	include_once("permite.php");
	include_once("scripts/recover_nombre.php");
	include('./scripts/scripts.php'); 

	$tabla = "tarifario";
	$llave = "idtarifario";
?>



<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="./css/admin_internas.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/funciones.js"></script>
<script type="text/javascript" src="./js/funcionesValida.js"></script>
<script type="text/javascript" src="./js/jquery-1.8.3.js" ></script>

<script>
	
	function searchCarga(idCot,cl){
		//Aplica filtros de carga nacionalizada con ajax
		//$("#searchNac").innerHTML = "resultoó bien";
		
		var proveedorNac = $("#proveedorNac").val();

		var origenNac = $("#origenNac").val();
		var destinoNac = $("#destinoNac").val();
		
		 $.ajax({ type: "GET",   
			 url: 'search_terrestre.php?idcot_temp='+idCot+'&cl='+cl+"&proveedorNac="+proveedorNac+"&origenNac="+origenNac+"&destinoNac="+destinoNac, 
			 datatype: "text/html",
			 success : function(res){
				$("#searchNac").html(res);
			 }
		});
		 
			
	}
</script>
<!--
<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.1.pack.js" ></script>-->



<script type="text/javascript" src="./js/main.js"></script>
<script type="text/javascript" src="./js/shadowbox-base.js"></script>
<script type="text/javascript" src="./js/shadowbox.js"></script>
<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "condiciones, condiciones_flete, condiciones_terrestre, descripcion_seg, descripcion_adu, condiciones_bg",
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

<style type="text/css">
.divCarga{
	display:none;
}
</style>



<script language="javascript">


function recoger_otm(filtre, filtre2, filtre3, filtre4, filtradotm)
{
	

	if( document.formulario.clasif_cot.value == 'aereo')
		return false;
	
	var lista_otm='';
	var lista_dev='';
	var lista_esc='';
	var lista_venta='';

	
	var ponerComa=false;
	if(document.formulario.selotm.length <= 1 || document.formulario.selotm.length == null)
	{
		if(document.formulario.selotm.checked)
		{
			lista_otm=document.formulario.selotm.value;
			lista_dev = lista_dev + document.getElementById('n_selotm_dev' + document.formulario.selotm.value).value;
			lista_esc = lista_esc + document.getElementById('n_selotm_esc' + document.formulario.selotm.value).value;			
			lista_venta = lista_venta + document.getElementById('venta_otm' + document.formulario.selotm.value).value;
		}
	}else
	{
		for(i=0;i<document.formulario.selotm.length;i++)
		{
			if(document.formulario.selotm[i].checked)
			{
				if(ponerComa==true)
				{
					lista_otm=lista_otm + ',';
				}
				lista_otm = lista_otm + document.formulario.selotm[i].value;
				ponerComa=true;
				
				if(lista_dev != '') { lista_dev = lista_dev + ','; }
				lista_dev = lista_dev + document.getElementById('n_selotm_dev' + document.formulario.selotm[i].value).value;
				
				if(lista_esc != '') { lista_esc = lista_esc + ','; }
				lista_esc = lista_esc + document.getElementById('n_selotm_esc' + document.formulario.selotm[i].value).value;
				
				if(lista_venta != '') { lista_venta = lista_venta + ','; }
				lista_venta = lista_venta + document.getElementById('venta_otm' + document.formulario.selotm[i].value).value;				
			}
		}
	}
	//alert('lista_otm ' + lista_otm + ' lista_dev ' + lista_dev + ' lista_esc ' + lista_esc + ' lista_venta ' + lista_venta);	
	guardatemp_otm(lista_otm, lista_dev, lista_esc, lista_venta);
	filtrar_otm(filtre, filtre2, filtre3, filtre4, filtradotm);
}

function validarFletes(tipo, idtarifario, actual, all_in, margen){
	if(tipo == 'aereo_minimo' || tipo == 'aereo_normal' || tipo == 'aereo45' || tipo == 'aereo100' || tipo == 'aereo300' || tipo == 'aereo500' || tipo == 'aereo1000' || tipo == 'lcl_neta' || tipo == 'lcl_minimo' || tipo == '20')
	{
		minimo = all_in - margen;
	
		if(tipo == 'aereo_minimo')
			nombre = 'venta_minimo';
		if(tipo == 'aereo_normal')
			nombre = 'venta_normal';
		if(tipo == 'aereo45')
			nombre = 'venta45';
		if(tipo == 'aereo100')
			nombre = 'venta100';
		if(tipo == 'aereo300')
			nombre = 'venta300';
		if(tipo == 'aereo500')
			nombre = 'venta500';
		if(tipo == 'aereo1000')
			nombre = 'venta1000';
	
		if(tipo == 'lcl_neta')
			nombre = 'total_neta';
		if(tipo == 'lcl_minimo')
			nombre = 'minimo_venta';
		if(tipo == '20')
			nombre = 'all_in_20';
	}
	
	if(tipo == '40' || tipo == '40hq')
	{
		minimo = all_in - margen;
		
		if(tipo == '40')
			nombre = 'all_in_40';
		if(tipo == '40hq')
			nombre = 'all_in_40hq';
	}
	if(document.getElementById(nombre + idtarifario).value < minimo)
	{
		alert('Este valor no puede ser menor a ' + minimo);
		document.getElementById(nombre + idtarifario).value = actual;
		return false;
	}
	
}

function recoger(filtre, filtre2, filtre3, filtre4, filtrado){

	<?
	
	if($_GET['cl']=='fcl')
	{
		?>		
		var lista20='';
		var lista_allin_20='';
		var lista_baf_20='';
		var lista_gri_20='';
		var lista_pss_20='';
		var ponerComa=false;
		if(document.formulario.sel20.length <= 1 || document.formulario.sel20.length == null)
		{
			if(document.formulario.sel20.checked)
			{
				lista20 = document.formulario.sel20.value;
				lista_allin_20 = document.getElementById('n_all_in_20' + document.formulario.sel20.value).value;
				lista_allin_20 = lista_allin_20 + '*' + document.getElementById('n_all_in_40' + (parseInt(document.formulario.sel20.value) + 1)).value;
				lista_allin_20 = lista_allin_20 + '*' + document.getElementById('n_all_in_40hq' + (parseInt(document.formulario.sel20.value) + 2)).value;
				
				lista_baf_20 = lista_baf_20 + document.getElementById('n_baf' + document.formulario.sel20.value).value;
				lista_gri_20 = lista_gri_20 + document.getElementById('n_gri' + document.formulario.sel20.value).value;
				lista_pss_20 = lista_pss_20 + document.getElementById('n_pss' + document.formulario.sel20.value).value;
			}
		}else
		{
			for(i=0;i<document.formulario.sel20.length;i++)
			{
				if(document.formulario.sel20[i].checked)
				{
					if(ponerComa==true)
					{
						lista20=lista20 + ',';
					}
					lista20=lista20 + document.formulario.sel20[i].value;
					ponerComa=true;
					
					if(lista_allin_20 != '') { lista_allin_20 = lista_allin_20 + ','; }
					lista_allin_20 = lista_allin_20 + document.getElementById('n_all_in_20' + document.formulario.sel20[i].value).value;
					lista_allin_20 = lista_allin_20 + '*' + document.getElementById('n_all_in_40' + (parseInt(document.formulario.sel20[i].value) + 1)).value;
					lista_allin_20 = lista_allin_20 + '*' + document.getElementById('n_all_in_40hq' + (parseInt(document.formulario.sel20[i].value) + 2)).value;
					
					if(lista_baf_20 != '') { lista_baf_20 = lista_baf_20 + ','; }				
					lista_baf_20 = lista_baf_20 + document.getElementById('n_baf' + document.formulario.sel20[i].value).value;
					
					if(lista_gri_20 != '') { lista_gri_20 = lista_gri_20 + ','; }				
					lista_gri_20 = lista_gri_20 + document.getElementById('n_gri' + document.formulario.sel20[i].value).value;
					
					if(lista_pss_20 != '') { lista_pss_20 = lista_pss_20 + ','; }				
					lista_pss_20 = lista_pss_20 + document.getElementById('n_pss' + document.formulario.sel20[i].value).value;	
				}
			}
		}
		//alert('lista20 ' + lista20);
		var lista40='';
		var lista_allin_40='';
		var lista_baf_40='';
		var lista_gri_40='';
		var lista_pss_40='';
		var ponerComa=false;
		if(document.formulario.sel40.length <= 1 || document.formulario.sel40.length == null)
		{
			if(document.formulario.sel40.checked)
			{
				lista40=document.formulario.sel40.value;
				lista_allin_40 = document.getElementById('n_all_in_20' + (parseInt(document.formulario.sel40.value) - 1)).value;
				lista_allin_40 = lista_allin_40 + '*' + document.getElementById('n_all_in_40' + document.formulario.sel40.value).value;			
				lista_allin_40 = lista_allin_40 + '*' + document.getElementById('n_all_in_40hq' + (parseInt(document.formulario.sel40.value) + 1)).value;
				
				lista_baf_40 = lista_baf_40 + document.getElementById('n_baf' + document.formulario.sel40.value).value;
				lista_gri_40 = lista_gri_40 + document.getElementById('n_gri' + document.formulario.sel40.value).value;
				lista_pss_40 = lista_pss_40 + document.getElementById('n_pss' + document.formulario.sel40.value).value;
			}
		}else
		{
			for(i=0;i<document.formulario.sel40.length;i++)
			{
	
				if(document.formulario.sel40[i].checked)
				{
					if(ponerComa==true)
					{
						lista40=lista40 + ',';
					}
					lista40=lista40 + document.formulario.sel40[i].value ;
					ponerComa=true;
					
					if(lista_allin_40 != '') { lista_allin_40 = lista_allin_40 + ','; }
					lista_allin_40 = lista_allin_40 + document.getElementById('n_all_in_20' + (parseInt(document.formulario.sel40[i].value) - 1)).value;
					lista_allin_40 = lista_allin_40 + '*' + document.getElementById('n_all_in_40' + document.formulario.sel40[i].value).value;
					lista_allin_40 = lista_allin_40 + '*' + document.getElementById('n_all_in_40hq' + (parseInt(document.formulario.sel40[i].value) + 1)).value;
					
					if(lista_baf_40 != '') { lista_baf_40 = lista_baf_40 + ','; }				
					lista_baf_40 = lista_baf_40 + document.getElementById('n_baf' + document.formulario.sel40[i].value).value;
					
					if(lista_gri_40 != '') { lista_gri_40 = lista_gri_40 + ','; }				
					lista_gri_40 = lista_gri_40 + document.getElementById('n_gri' + document.formulario.sel40[i].value).value;
					
					if(lista_pss_40 != '') { lista_pss_40 = lista_pss_40 + ','; }				
					lista_pss_40 = lista_pss_40 + document.getElementById('n_pss' + document.formulario.sel40[i].value).value;
				}
			}
		}
		//alert('lista40 ' + lista40);
		var lista40hq='';
		var lista_allin_40hq='';
		var lista_baf_40hq='';
		var lista_gri_40hq='';
		var lista_pss_40hq='';
		var ponerComa=false;
		if(document.formulario.sel40hq.length <= 1 || document.formulario.sel40hq.length == null)
		{
			if(document.formulario.sel40hq.checked)
			{
				lista40hq=document.formulario.sel40hq.value;
				lista_allin_40hq = document.getElementById('n_all_in_20' + (parseInt(document.formulario.sel40hq.value) - 2)).value;
				lista_allin_40hq = lista_allin_40hq + '*' + document.getElementById('n_all_in_40' + (parseInt(document.formulario.sel40hq.value) - 1)).value;
				lista_allin_40hq = lista_allin_40hq + '*' + document.getElementById('n_all_in_40hq' + document.formulario.sel40hq.value).value;
				
				lista_baf_40hq = lista_baf_40hq + document.getElementById('n_baf' + document.formulario.sel40hq.value).value;
				lista_gri_40hq = lista_gri_40hq + document.getElementById('n_gri' + document.formulario.sel40hq.value).value;
				lista_pss_40hq = lista_pss_40hq + document.getElementById('n_pss' + document.formulario.sel40hq.value).value;
			}
		}else
		{
			for(i=0;i<document.formulario.sel40hq.length;i++)
			{
				if(document.formulario.sel40hq[i].checked)
				{
					if(ponerComa==true)
					{
						lista40hq=lista40hq + ',';
					}
					lista40hq=lista40hq + document.formulario.sel40hq[i].value;
					ponerComa=true;
					
					if(lista_allin_40hq != '') { lista_allin_40hq = lista_allin_40hq + ','; }
					lista_allin_40hq = lista_allin_40hq + document.getElementById('n_all_in_20' + (parseInt(document.formulario.sel40hq[i].value) - 2)).value;
					lista_allin_40hq = lista_allin_40hq + '*' + document.getElementById('n_all_in_40' + (parseInt(document.formulario.sel40hq[i].value) - 1)).value;
					lista_allin_40hq = lista_allin_40hq + '*' + document.getElementById('n_all_in_40hq' + document.formulario.sel40hq[i].value).value;
					
					if(lista_baf_40hq != '') { lista_baf_40hq = lista_baf_40hq + ','; }				
					lista_baf_40hq = lista_baf_40hq + document.getElementById('n_baf' + document.formulario.sel40hq[i].value).value;
					
					if(lista_gri_40hq != '') { lista_gri_40hq = lista_gri_40hq + ','; }				
					lista_gri_40hq = lista_gri_40hq + document.getElementById('n_gri' + document.formulario.sel40hq[i].value).value;
					
					if(lista_pss_40hq != '') { lista_pss_40hq = lista_pss_40hq + ','; }				
					lista_pss_40hq = lista_pss_40hq + document.getElementById('n_pss' + document.formulario.sel40hq[i].value).value;
				}
			}
		}
		//alert('lista40hq ' + lista40hq);
		guardatemp(lista20, lista40, lista40hq, lista_allin_20, lista_allin_40, lista_allin_40hq, lista_baf_20, lista_baf_40, lista_baf_40hq, lista_gri_20, lista_gri_40, lista_gri_40hq, lista_pss_20, lista_pss_40, lista_pss_40hq);		
		
		<?
	}
	if($_GET['cl']=='lcl')
	{
		?>
		var lista='';
		var lista_total_neta='';
		var lista_minimo_venta='';
		var lista_baf_lcl='';

		var ponerComa=false;
		if(document.formulario.sel.length <= 1 || document.formulario.sel.length == null)
		{
			if(document.formulario.sel.checked)
			{
				lista=document.formulario.sel.value;
				lista_total_neta = lista_total_neta + document.getElementById('n_total_neta' + document.formulario.sel.value).value;
				lista_minimo_venta = lista_minimo_venta + document.getElementById('n_minimo_venta' + document.formulario.sel.value).value;
				
				lista_baf_lcl = lista_baf_lcl + document.getElementById('n_baf_lcl' + document.formulario.sel.value).value;
			}
		}else
		{
			for(i=0;i<document.formulario.sel.length;i++)
			{
				if(document.formulario.sel[i].checked)
				{
					if(ponerComa==true)
					{
						lista=lista + ',';
					}
					lista = lista + document.formulario.sel[i].value;
					ponerComa=true;
					
					if(lista_total_neta != '') { lista_total_neta = lista_total_neta + ','; }
					lista_total_neta = lista_total_neta + document.getElementById('n_total_neta' + document.formulario.sel[i].value).value;
					
					if(lista_minimo_venta != '') { lista_minimo_venta = lista_minimo_venta + ','; }
					lista_minimo_venta = lista_minimo_venta + document.getElementById('n_minimo_venta' + document.formulario.sel[i].value).value;
					
					if(lista_baf_lcl != '') { lista_baf_lcl = lista_baf_lcl + ','; }
					lista_baf_lcl = lista_baf_lcl + document.getElementById('n_baf_lcl' + document.formulario.sel[i].value).value;				
				}
			}
		}
		guardatemp_lcl(lista, lista_total_neta, lista_minimo_venta, lista_baf_lcl)		 
		//alert('lista ' + lista + ' lista_total_neta ' + lista_total_neta + ' lista_minimo_venta ' + lista_minimo_venta + ' lista_baf_lcl ' + lista_baf_lcl);
		<?
	}
	if($_GET['cl']=='aereo')
	{
		?>		
		var lista_minimo='';
		var lista_venta_minimo='';
		var lista_security_minimo='';
		var lista_mz_minimo='';
		var lista_fuel_minimo='';		
		var ponerComa=false;
		if(document.formulario.sel_minimo.length <= 1 || document.formulario.sel_minimo.length == null)
		{
			if(document.formulario.sel_minimo.checked)
			{
				lista_minimo = document.formulario.sel_minimo.value;
				lista_venta_minimo = document.getElementById('venta_minimo' + document.formulario.sel_minimo.value).value;
				lista_security_minimo = lista_security_minimo + document.getElementById('n_security' + document.formulario.sel_minimo.value).value;
				lista_mz_minimo = lista_mz_minimo + document.getElementById('n_mz' + document.formulario.sel_minimo.value).value;
				lista_fuel_minimo = lista_fuel_minimo + document.getElementById('n_fuel' + document.formulario.sel_minimo.value).value;
			}
		}else
		{
			for(i=0;i<document.formulario.sel_minimo.length;i++)
			{
				if(document.formulario.sel_minimo[i].checked)
				{
					if(ponerComa==true)
					{
						lista_minimo=lista_minimo + ',';
					}
					lista_minimo=lista_minimo + document.formulario.sel_minimo[i].value;
					ponerComa=true;
					
					if(lista_venta_minimo != '') { lista_venta_minimo = lista_venta_minimo + ','; }				
					lista_venta_minimo = lista_venta_minimo + document.getElementById('venta_minimo' + document.formulario.sel_minimo[i].value).value;
					
					if(lista_security_minimo != '') { lista_security_minimo = lista_security_minimo + ','; }				
					lista_security_minimo = lista_security_minimo + document.getElementById('n_security' + document.formulario.sel_minimo[i].value).value;					
					if(lista_mz_minimo != '') { lista_mz_minimo = lista_mz_minimo + ','; }				
					lista_mz_minimo = lista_mz_minimo + document.getElementById('n_mz' + document.formulario.sel_minimo[i].value).value;
					if(lista_fuel_minimo != '') { lista_fuel_minimo = lista_fuel_minimo + ','; }				
					lista_fuel_minimo = lista_fuel_minimo + document.getElementById('n_fuel' + document.formulario.sel_minimo[i].value).value;
				}
			}
		}
		//--------------------------------------------------------------------------------------------------------------------------------------------------------------
		var lista_normal='';
		var lista_venta_normal='';
		var lista_security_normal='';
		var lista_mz_normal='';
		var lista_fuel_normal='';	
		var ponerComa=false;
		if(document.formulario.sel_normal.length <= 1 || document.formulario.sel_normal.length == null)
		{
			if(document.formulario.sel_normal.checked)
			{
				lista_normal = document.formulario.sel_normal.value;
				lista_venta_normal = document.getElementById('venta_normal' + document.formulario.sel_normal.value).value;
				lista_security_normal = lista_security_normal + document.getElementById('n_security' + document.formulario.sel_normal.value).value;
				lista_mz_normal = lista_mz_normal + document.getElementById('n_mz' + document.formulario.sel_normal.value).value;
				lista_fuel_normal = lista_fuel_normal + document.getElementById('n_fuel' + document.formulario.sel_normal.value).value;
			}
		}else
		{
			for(i=0;i<document.formulario.sel_normal.length;i++)
			{
				if(document.formulario.sel_normal[i].checked)
				{
					if(ponerComa==true)
					{
						lista_normal=lista_normal + ',';
					}
					lista_normal=lista_normal + document.formulario.sel_normal[i].value;
					ponerComa=true;
					
					if(lista_venta_normal != '') { lista_venta_normal = lista_venta_normal + ','; }				
					lista_venta_normal = lista_venta_normal + document.getElementById('venta_normal' + document.formulario.sel_normal[i].value).value;
					
					if(lista_security_normal != '') { lista_security_normal = lista_security_normal + ','; }				
					lista_security_normal = lista_security_normal + document.getElementById('n_security' + document.formulario.sel_normal[i].value).value;					
					if(lista_mz_normal != '') { lista_mz_normal = lista_mz_normal + ','; }				
					lista_mz_normal = lista_mz_normal + document.getElementById('n_mz' + document.formulario.sel_normal[i].value).value;
					if(lista_fuel_normal != '') { lista_fuel_normal = lista_fuel_normal + ','; }				
					lista_fuel_normal = lista_fuel_normal + document.getElementById('n_fuel' + document.formulario.sel_normal[i].value).value;
				}
			}
		}
		//--------------------------------------------------------------------------------------------------------------------------------------------------------------
		var lista45='';
		var lista_venta45='';
		var lista_security45='';
		var lista_mz45='';
		var lista_fuel45='';
		var ponerComa=false;
		if(document.formulario.sel45.length <= 1 || document.formulario.sel45.length == null)
		{
			if(document.formulario.sel45.checked)
			{
				lista45 = document.formulario.sel45.value;
				lista_venta45 = document.getElementById('venta45' + document.formulario.sel45.value).value;
				lista_security45 = lista_security45 + document.getElementById('n_security' + document.formulario.sel45.value).value;
				lista_mz45 = lista_mz45 + document.getElementById('n_mz' + document.formulario.sel45.value).value;
				lista_fuel45 = lista_fuel45 + document.getElementById('n_fuel' + document.formulario.sel45.value).value;
			}
		}else
		{
			for(i=0;i<document.formulario.sel45.length;i++)
			{
				if(document.formulario.sel45[i].checked)
				{
					if(ponerComa==true)
					{
						lista45=lista45 + ',';
					}
					lista45=lista45 + document.formulario.sel45[i].value;
					ponerComa=true;
					
					if(lista_venta45 != '') { lista_venta45 = lista_venta45 + ','; }				
					lista_venta45 = lista_venta45 + document.getElementById('venta45' + document.formulario.sel45[i].value).value;
					
					if(lista_security45 != '') { lista_security45 = lista_security45 + ','; }				
					lista_security45 = lista_security45 + document.getElementById('n_security' + document.formulario.sel45[i].value).value;					
					if(lista_mz45 != '') { lista_mz45 = lista_mz45 + ','; }				
					lista_mz45 = lista_mz45 + document.getElementById('n_mz' + document.formulario.sel45[i].value).value;
					if(lista_fuel45 != '') { lista_fuel45 = lista_fuel45 + ','; }				
					lista_fuel45 = lista_fuel45 + document.getElementById('n_fuel' + document.formulario.sel45[i].value).value;
				}
			}
		}
		//--------------------------------------------------------------------------------------------------------------------------------------------------------------
		var lista100='';
		var lista_venta100='';
		var lista_security100='';
		var lista_mz100='';
		var lista_fuel100='';
		var ponerComa=false;
		if(document.formulario.sel100.length <= 1 || document.formulario.sel100.length == null)
		{
			if(document.formulario.sel100.checked)
			{
				lista100 = document.formulario.sel100.value;
				lista_venta100 = document.getElementById('venta100' + document.formulario.sel100.value).value;
				lista_security100 = lista_security100 + document.getElementById('n_security' + document.formulario.sel100.value).value;
				lista_mz100 = lista_mz100 + document.getElementById('n_mz' + document.formulario.sel100.value).value;
				lista_fuel100 = lista_fuel100 + document.getElementById('n_fuel' + document.formulario.sel100.value).value;
			}
		}else
		{
			for(i=0;i<document.formulario.sel100.length;i++)
			{
				if(document.formulario.sel100[i].checked)
				{
					if(ponerComa==true)
					{
						lista100=lista100 + ',';
					}
					lista100=lista100 + document.formulario.sel100[i].value;
					ponerComa=true;
					
					if(lista_venta100 != '') { lista_venta100 = lista_venta100 + ','; }				
					lista_venta100 = lista_venta100 + document.getElementById('venta100' + document.formulario.sel100[i].value).value;
					
					if(lista_security100 != '') { lista_security100 = lista_security100 + ','; }				
					lista_security100 = lista_security100 + document.getElementById('n_security' + document.formulario.sel100[i].value).value;					
					if(lista_mz100 != '') { lista_mz100 = lista_mz100 + ','; }				
					lista_mz100 = lista_mz100 + document.getElementById('n_mz' + document.formulario.sel100[i].value).value;
					if(lista_fuel100 != '') { lista_fuel100 = lista_fuel100 + ','; }				
					lista_fuel100 = lista_fuel100 + document.getElementById('n_fuel' + document.formulario.sel100[i].value).value;
				}
			}
		}
		//--------------------------------------------------------------------------------------------------------------------------------------------------------------
		var lista300='';
		var lista_venta300='';
		var lista_security300='';
		var lista_mz300='';
		var lista_fuel300='';
		var ponerComa=false;
		if(document.formulario.sel300.length <= 1 || document.formulario.sel300.length == null)
		{
			if(document.formulario.sel300.checked)
			{
				lista300 = document.formulario.sel300.value;
				lista_venta300 = document.getElementById('venta300' + document.formulario.sel300.value).value;
				lista_security300 = lista_security300 + document.getElementById('n_security' + document.formulario.sel300.value).value;
				lista_mz300 = lista_mz300 + document.getElementById('n_mz' + document.formulario.sel300.value).value;
				lista_fuel300 = lista_fuel300 + document.getElementById('n_fuel' + document.formulario.sel300.value).value;
			}
		}else
		{
			for(i=0;i<document.formulario.sel300.length;i++)
			{
				if(document.formulario.sel300[i].checked)
				{
					if(ponerComa==true)
					{
						lista300=lista300 + ',';
					}
					lista300=lista300 + document.formulario.sel300[i].value;
					ponerComa=true;
					
					if(lista_venta300 != '') { lista_venta300 = lista_venta300 + ','; }				
					lista_venta300 = lista_venta300 + document.getElementById('venta300' + document.formulario.sel300[i].value).value;
					
					if(lista_security300 != '') { lista_security300 = lista_security300 + ','; }				
					lista_security300 = lista_security300 + document.getElementById('n_security' + document.formulario.sel300[i].value).value;					
					if(lista_mz300 != '') { lista_mz300 = lista_mz300 + ','; }				
					lista_mz300 = lista_mz300 + document.getElementById('n_mz' + document.formulario.sel300[i].value).value;
					if(lista_fuel300 != '') { lista_fuel300 = lista_fuel300 + ','; }				
					lista_fuel300 = lista_fuel300 + document.getElementById('n_fuel' + document.formulario.sel300[i].value).value;
				}
			}
		}
		//-------------------------------------------------------------------------------------------
		var lista500='';
		var lista_venta500='';
		var lista_security500='';
		var lista_mz500='';
		var lista_fuel500='';
		var ponerComa=false;
		if(document.formulario.sel500.length <= 1 || document.formulario.sel500.length == null)
		{
			if(document.formulario.sel500.checked)
			{
				lista500 = document.formulario.sel500.value;
				lista_venta500 = document.getElementById('venta500' + document.formulario.sel500.value).value;
				lista_security500 = lista_security500 + document.getElementById('n_security' + document.formulario.sel500.value).value;
				lista_mz500 = lista_mz500 + document.getElementById('n_mz' + document.formulario.sel500.value).value;
				lista_fuel500 = lista_fuel500 + document.getElementById('n_fuel' + document.formulario.sel500.value).value;
			}
		}else
		{
			for(i=0;i<document.formulario.sel500.length;i++)
			{
				if(document.formulario.sel500[i].checked)
				{
					if(ponerComa==true)
					{
						lista500=lista500 + ',';
					}
					lista500=lista500 + document.formulario.sel500[i].value;
					ponerComa=true;
					
					if(lista_venta500 != '') { lista_venta500 = lista_venta500 + ','; }				
					lista_venta500 = lista_venta500 + document.getElementById('venta500' + document.formulario.sel500[i].value).value;
					
					if(lista_security500 != '') { lista_security500 = lista_security500 + ','; }				
					lista_security500 = lista_security500 + document.getElementById('n_security' + document.formulario.sel500[i].value).value;					
					if(lista_mz500 != '') { lista_mz500 = lista_mz500 + ','; }				
					lista_mz500 = lista_mz500 + document.getElementById('n_mz' + document.formulario.sel500[i].value).value;
					if(lista_fuel500 != '') { lista_fuel500 = lista_fuel500 + ','; }				
					lista_fuel500 = lista_fuel500 + document.getElementById('n_fuel' + document.formulario.sel500[i].value).value;
				}
			}
		}
		//------------------------------------------------------------------------------------------------
		var lista1000='';
		var lista_venta1000='';
		var lista_security1000='';
		var lista_mz1000='';
		var lista_fuel1000='';
		var ponerComa=false;
		if(document.formulario.sel1000.length <= 1 || document.formulario.sel1000.length == null)
		{
			if(document.formulario.sel1000.checked)
			{
				lista1000 = document.formulario.sel1000.value;
				lista_venta1000 = document.getElementById('venta1000' + document.formulario.sel1000.value).value;
				lista_security1000 = lista_security1000 + document.getElementById('n_security' + document.formulario.sel1000.value).value;
				lista_mz1000 = lista_mz1000 + document.getElementById('n_mz' + document.formulario.sel1000.value).value;
				lista_fuel1000 = lista_fuel1000 + document.getElementById('n_fuel' + document.formulario.sel1000.value).value;
			}
		}else
		{
			for(i=0;i<document.formulario.sel1000.length;i++)
			{
				if(document.formulario.sel1000[i].checked)
				{
					if(ponerComa==true)
					{
						lista1000=lista1000 + ',';
					}
					lista1000=lista1000 + document.formulario.sel1000[i].value;
					ponerComa=true;
					
					if(lista_venta1000 != '') { lista_venta1000 = lista_venta1000 + ','; }				
					lista_venta1000 = lista_venta1000 + document.getElementById('venta1000' + document.formulario.sel1000[i].value).value;
					
					if(lista_security1000 != '') { lista_security1000 = lista_security1000 + ','; }				
					lista_security1000 = lista_security1000 + document.getElementById('n_security' + document.formulario.sel1000[i].value).value;					
					if(lista_mz1000 != '') { lista_mz1000 = lista_mz1000 + ','; }				
					lista_mz1000 = lista_mz1000 + document.getElementById('n_mz' + document.formulario.sel1000[i].value).value;
					if(lista_fuel1000 != '') { lista_fuel1000 = lista_fuel1000 + ','; }				
					lista_fuel1000 = lista_fuel1000 + document.getElementById('n_fuel' + document.formulario.sel1000[i].value).value;
				}
			}
		}
		//--------------------------------------------------------------------------------------------------------------------------------------------------------------		
		guardatemp_aereo(lista_minimo, lista_normal, lista45, lista100, lista300, lista500, lista1000, lista_venta_minimo, lista_venta_normal, lista_venta45, lista_venta100, lista_venta300, lista_venta500, lista_venta1000, lista_security_minimo, lista_security_normal, lista_security45, lista_security100, lista_security300, lista_security500, lista_security1000, lista_mz_minimo, lista_mz_normal, lista_mz45, lista_mz100, lista_mz300, lista_mz500, lista_mz1000, lista_fuel_minimo, lista_fuel_normal, lista_fuel45, lista_fuel100, lista_fuel300, lista_fuel500, lista_fuel1000)		 
		
		<?
	}
	?>

	haber(filtre, filtre2, filtre3, filtre4, filtrado);
}
/*-------------------------------*/
function guardatemp(lista20, lista40, lista40hq, lista_allin_20, lista_allin_40, lista_allin_40hq, lista_baf_20, lista_baf_40, lista_baf_40hq, lista_gri_20, lista_gri_40, lista_gri_40hq, lista_pss_20, lista_pss_40, lista_pss_40hq)
{	
	solicida2 = cobra();
	solicida2.open("POST", "guarda_temp.php", true);
	solicida2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	solicida2.send("lista20="+lista20+"&lista40="+lista40+"&lista40hq="+lista40hq+"&lista_allin_20="+lista_allin_20+"&lista_allin_40="+lista_allin_40+"&lista_allin_40hq="+lista_allin_40hq+"&lista_baf_20="+lista_baf_20+"&lista_baf_40="+lista_baf_40+"&lista_baf_40hq="+lista_baf_40hq+"&lista_gri_20="+lista_gri_20+"&lista_gri_40="+lista_gri_40+"&lista_gri_40hq="+lista_gri_40hq+"&lista_pss_20="+lista_pss_20+"&lista_pss_40="+lista_pss_40+"&lista_pss_40hq="+lista_pss_40hq+"&idcot_temp="+<? print $_GET['idcot_temp']; ?>);
	solicida2.onreadystatechange = cambios14;
	
}

function guardatemp_lcl(lista, lista_total_neta, lista_minimo_venta, lista_baf_lcl)
{	
	solicida2 = cobra();
	solicida2.open("POST", "guarda_temp.php", true);
	solicida2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	solicida2.send("lista="+lista+"&lista_total_neta="+lista_total_neta+"&lista_minimo_venta="+lista_minimo_venta+"&lista_baf_lcl="+lista_baf_lcl+"&idcot_temp="+<? print $_GET['idcot_temp']; ?>);
	solicida2.onreadystatechange = cambios14;
}

function guardatemp_aereo(lista_minimo, lista_normal, lista45, lista100, lista300, lista500, lista1000, lista_venta_minimo, lista_venta_normal, lista_venta45, lista_venta100, lista_venta300, lista_venta500, lista_venta1000, lista_security_minimo, lista_security_normal, lista_security45, lista_security100, lista_security300, lista_security500, lista_security1000, lista_mz_minimo, lista_mz_normal, lista_mz45, lista_mz100, lista_mz300, lista_mz500, lista_mz1000, lista_fuel_minimo, lista_fuel_normal, lista_fuel45, lista_fuel100, lista_fuel300, lista_fuel500, lista_fuel1000)
{	
	
	solicida2 = cobra();
	solicida2.open("POST", "guarda_temp.php", true);
	solicida2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	solicida2.send("lista_minimo="+lista_minimo+"&lista_normal="+lista_normal+"&lista45="+lista45+"&lista100="+lista100+"&lista300="+lista300+"&lista500="+lista500+"&lista1000="+lista1000+"&lista_venta_minimo="+lista_venta_minimo+"&lista_venta_normal="+lista_venta_normal+"&lista_venta45="+lista_venta45+"&lista_venta100="+lista_venta100+"&lista_venta300="+lista_venta300+"&lista_venta500="+lista_venta500+"&lista_venta1000="+lista_venta1000+"&lista_security_minimo="+lista_security_minimo+"&lista_security_normal="+lista_security_normal+"&lista_security45="+lista_security45+"&lista_security100="+lista_security100+"&lista_security300="+lista_security300+"&lista_security500="+lista_security500+"&lista_security1000="+lista_security1000+"&lista_mz_minimo="+lista_mz_minimo+"&lista_mz_normal="+lista_mz_normal+"&lista_mz45="+lista_mz45+"&lista_mz100="+lista_mz100+"&lista_mz300="+lista_mz300+"&lista_mz500="+lista_mz500+"&lista_mz1000="+lista_mz1000+"&lista_fuel_minimo="+lista_fuel_minimo+"&lista_fuel_normal="+lista_fuel_normal+"&lista_fuel45="+lista_fuel45+"&lista_fuel100="+lista_fuel100+"&lista_fuel300="+lista_fuel300+"&lista_fuel500="+lista_fuel500+"&lista_fuel1000="+lista_fuel1000+"&idcot_temp="+<? print $_GET['idcot_temp']; ?>);
	
	solicida2.onreadystatechange = cambios14;
}

function guardatemp_otm(lista_otm, lista_dev, lista_esc, lista_venta)
{
	solicida2 = cobra();
	solicida2.open("POST", "guarda_temp.php", true);
	solicida2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	solicida2.send("lista_otm="+lista_otm+"&lista_dev="+lista_dev+"&lista_esc="+lista_esc+"&lista_venta="+lista_venta+"&idcot_temp="+<? print $_GET['idcot_temp']; ?>);
	solicida2.onreadystatechange = cambios14;
}

function cambios14()
{
	var capa_eyes14 = window.document.getElementById("eyes14");
	if(solicida2.readyState == 4)
	{
		capa_eyes14.innerHTML = solicida2.responseText;
	}
	else
	{
		capa_eyes14.innerHTML = '<img src="images/loading.gif" align="middle" /> Buscando...';
	}
}

/*-------------------------------*/

function validaEnvia(form)
{
	//if (validarTexto('num_contrato', 'Por favor ingrese el num_contrato') == false) return false;
	//if (validarTexto('nombre', 'Por favor ingrese el nombre') == false) return false;	
	
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

function adicionaTarifas(form)
{

	form.tarifasok.value = 'si';
	alert('Adiciono tarifas');
	setTimeout(form.submit(),5000);

	
}

function irAtras(form)
{
	//alert('irAtras');
	form.atrasok.value='si';
	form.tarifasok.value = 'si';
	form.submit()
}

function winback(URL)
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,screenX=250,screenY=50,statusbar=yes,menubar=0,resizable=0,width=900,height=700');");
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

function pause(mili)
{
	var date = new Date();
	var curdate = null;
	do { curdate = new Date(); }
	while((curdate - date) < mili)
}


	
function haber(filtre, filtre2, filtre3, filtre4, filtrado)
{

	ver_sel = '0';
	
	/*
	if(document.getElementById('ver_sel').checked)
	{
		ver_sel = document.getElementById('ver_sel').value;
	}*/

	<?
	if($_GET['cl']=='fcl')
	{
		?>
		var j = '';
		<?
	}
	if($_GET['cl']=='lcl')
	{
		?>
		var j = '_lcl';
		<?
	}
	if($_GET['cl']=='aereo')
	{
		?>
		var j = '_aereo';
		<?
	}
	?>
	
	//alert ('filtre ' + filtre + 'filtre2 ' + filtre2 + 'filtre3 ' + filtre3 + 'filtre4 ' + filtre4 + 'filtrado ' + filtrado);
	 pause(500);// para dar tiempo a que se guarden los temporales
	
	var capa_eyes = window.document.getElementById("eyes2");
	//solicita = new XMLHttpRequest();
	solicita = cobra();
	solicita.open("POST", "search_cotizacion" + j + ".php", true);
	solicita.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	solicita.send("nav="+filtre+"&origen="+filtre2+"&destination="+filtre3+"&aeropuerto_origen="+filtre4+"&idcot_temp="+<? print $_GET['idcot_temp']; ?>+"&ver_sel="+ver_sel+"&filtrado="+filtrado);
	solicita.onreadystatechange = cambios;

}

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

function filtrar_otm(filtre, filtre2, filtre3, filtre4, filtradotm)
{
	ver_sel_otm = '0';
	
	if(document.getElementById('ver_sel_otm').checked)
	{
		ver_sel_otm = document.getElementById('ver_sel_otm').value;
	}
	//alert('ver_sel_otm '+ver_sel_otm)
	pause(500);// para dar tiempo a que se guarden los temporales	
	
	var capa_eyes_otm = window.document.getElementById("eyes_otm");
	//solicita = new XMLHttpRequest();
	solicita = cobra();
	//alert('filtro1='+filtre+'&filtro2='+filtre2+'&filtro3='+filtre3+'&filtro4='+filtre4+'filtradotm' + filtradotm);
	solicita.open("GET", "search_otm.php?filtro1="+filtre+"&filtro2="+filtre2+"&filtro3="+filtre3+"&filtro4="+filtre4+"&idcot_temp="+<? print $_GET['idcot_temp']; ?>+"&cl="+"<? print $_GET['cl']; ?>"+"&ver_sel_otm="+ver_sel_otm+"&filtradotm="+filtradotm, true);
	solicita.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	solicita.send("filtro1="+filtre+"&filtro2="+filtre2+"&filtro3="+filtre3+"&filtro4="+filtre4+"&idcot_temp="+<? print $_GET['idcot_temp']; ?>+"&cl="+"<? print $_GET['cl']; ?>"+"&ver_sel_otm="+ver_sel_otm+"&filtradotm="+filtradotm);
	solicita.onreadystatechange = cambios_otm;
}

function cambios_otm()
{
	var capa_eyes_otm = window.document.getElementById("eyes_otm");
	if(solicita.readyState == 4)
	{
		capa_eyes_otm.innerHTML = solicita.responseText;
	}
	else
	{
		capa_eyes_otm.innerHTML = '<img src="images/loading.gif" align="middle" /> Buscando...';
	}

}

function showmed(capa){
	//Oculta todas las capas
	$(".divCarga").hide("slow");
	$(capa).show("slow");
}


</script>
</head>

<?
$sqlrn = "select idreporte from reporte_negocios where idcot_temp='$_GET[idcot_temp]'";

$exern = mysqli_query($link,$sqlrn);
$filasrn = mysqli_num_rows($exern);

if($_POST['datosok']=='si')
{
	if($_POST['modRegistro']=="no")
	{
		
	}
	else
	{
		
	}
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

if($_POST['tarifasok']=='si')
{

	//aca se adicionan las tarifas
	//selecciona las navieras antiguas-----------------------------------------------------------------------------------------
	if($_GET['cl']=='fcl')
	{
		$tipo = 'tipo';
		$idtipo = 'idtipo';
	}
	elseif($_GET['cl']=='lcl')
	{
		$tipo = 'tipo_lcl';
		$idtipo = 'idtipo_lcl';
	}
	

	if($_GET['cl']=='aereo')
		$sqlidt = "select distinct idtarifario_aereo as idtarifario from tipo_aereo where idtipo_aereo in(select idtipo_aereo from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]')";
	else
	   $sqlidt = "select distinct idtarifario from $tipo where $idtipo in(select idtipo from cot_fletes where idcot_temp='$_GET[idcot_temp]')";
	   
	 
	$exeidt = mysqli_query($link,$sqlidt);
	
	$cad_idtar = "''";
	
	//almacena los id de tarifario de la tabla tipo en una variable $cad_idtar
	while($datosidt = mysqli_fetch_array($exeidt)){
		if($cad_idtar != '')
			$cad_idtar .= ',';
		$cad_idtar .= " '".$datosidt['idtarifario'] ."'";
	}
	
	//Consulta Naviera
	if($_GET['cl']=='aereo')
		$sqlnav = "select distinct idaerolinea as idnaviera from tarifario_aereo where idtarifario_aereo in ($cad_idtar)";
	else
		$sqlnav = "select distinct idnaviera from tarifario where idtarifario in ($cad_idtar)";
	
	$exenav = mysqli_query($link,$sqlnav);
	
	
	//Almacena las navieras de la tabla tarifario en una variable $navold
	$navold = "''";
	while($datosnav = mysqli_fetch_array($exenav))	
	{
		if($navold != '')
			$navold .= ',';
		 $navold .= $datosnav['idnaviera'];
	}
	
	
	//------------------------------------------------------------------------------------------------------------------------
	//--SEGURO--
	$sqldel = "delete from cot_seg where idcot_temp='$_GET[idcot_temp]'";
	$exedel = mysqli_query($link,$sqldel);
	if(isset($_POST['selsg'])){
		foreach($_POST['selsg'] as $id){
			$pc = $_POST['porcentaje'.$id];
			$mn = $_POST['minimo_seg'.$id];
			
			if($pc!='' || $mn!=''){
				$valor_seg = '0';
				if(isset($_POST['monto_aseg']) && $_POST['monto_aseg']!='0' && $_POST['monto_aseg']!='')
				{
					$valor_seg = $_POST['monto_aseg'] *($_POST['porcentaje'.$id] / 100);
				}
			
				if ($_POST['minimo_seg'.$id] > $valor_seg)	
				{
					$valor_seg = $_POST['minimo_seg'.$id];
				}
				
				$sqlseg = "INSERT INTO cot_seg (idseguro, idcot_temp, porcentaje, minimo, monto_aseg, valor, observaciones, descripcion, mostrar) VALUES ('$id', '$_GET[idcot_temp]','$pc', '$mn', '$_POST[monto_aseg]', '$valor_seg', UCASE('$_POST[observaciones_seg]'), '$_POST[descripcion_seg]', '$_POST[mostrar_seg]')";
				$exeseg = mysqli_query($link,$sqlseg);

			}
		}
	}
	
	//--ADUANA---
	$sqldel = "delete from cot_adu where idcot_temp='$_GET[idcot_temp]'";
	$exedel = mysqli_query($link,$sqldel);
	if(isset($_POST['seladu'])){
		foreach($_POST['seladu'] as $id)
		{
			$pc = $_POST['porcentaje_adu'.$id];
			$mn = $_POST['minimo_adu'.$id];

			if($pc!='' || $mn!='')
			{
				$sqladu = "INSERT INTO cot_adu (idaduana, idcot_temp, porcentaje, minimo, observaciones, descripcion, mostrar) VALUES ('$id', '$_GET[idcot_temp]','$pc', '$mn', UCASE('$_POST[observaciones_adu]'), '$_POST[descripcion_adu]', '$_POST[mostrar_adu]')";
				$exeadu = mysqli_query($link,$sqladu);
			}
		}
	}



	//--OTM--
	$sqldelotm = "delete from cot_otm where idcot_temp='$_GET[idcot_temp]'";
	$exedelotm = mysqli_query($link,$sqldelotm);
	
	$sqldelotm = "delete from local_otm_por_cotizacion where idcot_temp='$_GET[idcot_temp]'";
	$exedelotm = mysqli_query($link,$sqldelotm);
	
	$queryins="INSERT INTO cot_otm (idotm, 
									idcot_temp, 
									valor_venta, 
									condiciones, 
									documentacion, 
									devolucion, 
									escolta) (select idotm, 
												idcot_temp, 
												valor_venta, 
												condiciones, 
												documentacion, 
												devolucion, 
												escolta 
											from cot_otm_tmp where idcot_temp='$_GET[idcot_temp]')";
	$buscarins=mysqli_query($link,$queryins);
	
	$queryins="update cot_otm set condiciones='$_POST[condiciones]', documentacion='$_POST[doc_req]' where idcot_temp='$_GET[idcot_temp]'";
	$buscarins=mysqli_query($link,$queryins);	
			
	$sqldel = "delete from cot_otm_tmp where idcot_temp='$_GET[idcot_temp]'";
	$exedel = mysqli_query($link,$sqldel);
	
	if(isset($_POST['selotm']))
	{
		foreach($_POST['selotm'] as $id)
		{
			$selotm_dev = $_POST['selotm_dev'.$id];
			$selotm_esc = $_POST['selotm_esc'.$id];
			
			$valor_venta = $_POST['venta_otm'.$id];
			
			$sqlotm = "select * from cot_otm where idotm='$id' and idcot_temp='$_GET[idcot_temp]' ";
			$exeotm = mysqli_query($link,$sqlotm);
			$filasotm = mysqli_num_rows($exeotm);
			
			if($filasotm == 0)
			{
				$queryins="INSERT INTO cot_otm (idotm, idcot_temp, valor_venta, condiciones, documentacion, devolucion, escolta) VALUES('$id', '$_GET[idcot_temp]', '$valor_venta', '$_POST[condiciones]', '$_POST[doc_req]', '$selotm_dev', '$selotm_esc')";
				//print $queryins.'<br>';
				$buscarins=mysqli_query($link,$queryins);
			}
		}
	}
	
	
	//--Recargos OTM
	$sqlrg = "select * from recargos_local_otm where clasificacion='$_GET[cl]'";
	$exerg = mysqli_query($link,$sqlrg);
	while($datosrg = mysqli_fetch_array($exerg)){
		$idrecargo_otm = $_POST['recargo_otm'.$datosrg['idrecargo_local']];
		$recargo_otm_valor_venta = $_POST['recargo_otm_valor_venta'.$datosrg['idrecargo_local']];
		$recargo_otm_minimo_venta = $_POST['recargo_otm_minimo_venta'.$datosrg['idrecargo_local']];
		
		if($idrecargo_otm!='')
		{
			$sql="INSERT INTO local_otm_por_cotizacion (idrecargo_local, idcot_temp, valor_venta, minimo_venta) VALUES ('$datosrg[idrecargo_local]', '$_GET[idcot_temp]', '$recargo_otm_valor_venta', '$recargo_otm_minimo_venta')";
			$exe= mysqli_query($link,$sql);
		}
	}
	
	
	//--Terrestre--
	$sqldelterrestre = "delete from cot_terrestre where idcot_temp='$_GET[idcot_temp]'";
	$exedelterrestre = mysqli_query($link,$sqldelterrestre);
	if(isset($_POST['selterrestre'])){
		foreach($_POST['selterrestre'] as $id){
			$selterrestre_dev = $_POST['selterrestre_dev'.$id];
			$selterrestre_esc = $_POST['selterrestre_esc'.$id];			
			$valor_venta = $_POST['venta_terrestre'.$id];
			$queryins="INSERT INTO cot_terrestre (
							idterrestre, 
							idcot_temp, 
							valor_venta, 
							condiciones, 
							documentacion, 
							devolucion, 
							escolta
						) VALUES(
							'$id', 
							'$_GET[idcot_temp]', 
							'$valor_venta', 
							'$_POST[condiciones_terrestre]', 
							'$_POST[doc_req]', 
							'$selterrestre_dev', 
							'$selterrestre_esc'
						)";

			$buscarins=mysqli_query($link,$queryins);
		}
	}

	//--Terrestre--
	$sqldelterrestre = "delete from cot_dta where idcot_temp='$_GET[idcot_temp]'";
	$exedelterrestre = mysqli_query($link,$sqldelterrestre);
	if(isset($_POST['seldta'])){
		foreach($_POST['seldta'] as $id){
			$seldta_dev = $_POST['seldta_dev'.$id];
			$seldta_esc = $_POST['seldta_esc'.$id];			
			$valor_venta = $_POST['venta_dta'.$id];
			$queryins="INSERT INTO cot_dta (
							iddta, 
							idcot_temp, 
							valor_venta, 
							condiciones, 
							documentacion, 
							devolucion, 
							escolta
						) VALUES(
							'$id', 
							'$_GET[idcot_temp]', 
							'$valor_venta', 
							'$_POST[condiciones_dta]', 
							'$_POST[doc_req]', 
							'$seldta_dev', 
							'$seldta_esc'
						)";

			$buscarins=mysqli_query($link,$queryins);
		}
	}
	
	
	//--Bodegas--
	$sqldel = "delete from cot_bodegas where idcot_temp='$_GET[idcot_temp]'";
	$exedel = mysqli_query($link,$sqldel);
	if(isset($_POST['selbg'])){
		foreach($_POST['selbg'] as $id)
		{
			$advaloren_venta = $_POST['advaloren_venta'.$id];
			$min_advaloren = $_POST['min_advaloren'.$id];
			$mes_fraccion_venta = $_POST['mes_fraccion_venta'.$id];
			$min_mes_fraccion = $_POST['min_mes_fraccion'.$id];
			$mes_fraccion_40_venta = $_POST['mes_fraccion_40_venta'.$id];
			
			if($_GET['cl']=='fcl')
			{
			$queryins="INSERT INTO cot_bodegas (idbodega, idcot_temp, advaloren_venta, min_advaloren, mes_fraccion_venta, mes_fraccion_40_venta, condiciones) VALUES('$id', '$_GET[idcot_temp]', '$advaloren_venta', '$min_advaloren', '$mes_fraccion_venta', '$mes_fraccion_40_venta', '$_POST[condiciones_bg]')";
			}
			elseif($_GET['cl']=='lcl' || $_GET['cl']=='aereo')
			{
				$queryins="INSERT INTO cot_bodegas (idbodega, idcot_temp, advaloren_venta, min_advaloren, mes_fraccion_venta, min_mes_fraccion, condiciones) VALUES('$id', '$_GET[idcot_temp]', '$advaloren_venta', '$min_advaloren', '$mes_fraccion_venta', '$min_mes_fraccion', '$_POST[condiciones_bg]')";
			}
						
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
		}
	}
	
	$sqldel = "delete from cot_fletes where idcot_temp='$_GET[idcot_temp]'";
	$exedel = mysqli_query($link,$sqldel);	

	$queryins="INSERT INTO cot_fletes (
						idtipo, 
						idtarifario, 
						idcot_temp, 
						baf, 
						gri, 
						pss, 
						fleteventa, 
						all_in_20, 
						all_in_40, 
						all_in_40hq, 
						total_neta, 
						minimo_venta
						) (select 
							idtipo, 
							idtarifario, 
							idcot_temp, 
							baf, 
							gri, 
							pss, 
							fleteventa, 
							all_in_20, 
							all_in_40, 
							all_in_40hq, 
							total_neta, 
							minimo_venta from cot_fletes_tmp where idcot_temp='$_GET[idcot_temp]')";
	$buscarins=mysqli_query($link,$queryins);
	
	$queryins = "update cot_fletes set condiciones='$_POST[condiciones_flete]' where idcot_temp='$_GET[idcot_temp]'";
	$buscarins=mysqli_query($link,$queryins);
			
	$sqldel = "delete from cot_fletes_tmp where idcot_temp='$_GET[idcot_temp]'";
	$exedel = mysqli_query($link,$sqldel);	
	
	if(isset($_POST['sel']))//para lcl
	{
		foreach($_POST['sel'] as $id)
		{
			$idtarifario = scai_get_name("$id","tipo_lcl", "idtipo_lcl", "idtarifario");
			$baf = $_POST['baf_lcl'.$idtarifario];
			$total_neta = $_POST['total_neta'.$idtarifario];
			$minimo_venta = $_POST['minimo_venta'.$idtarifario];
			
			$sqltp = "select * from tipo_lcl where idtipo_lcl='$id'"; 
			$exetp = mysqli_query($link,$sqltp);
			$datostp = mysqli_fetch_array($exetp);
			
			$fleteventa = $datostp['total_neta'];
			
			if ($total_neta != '')
				$fleteventa = $total_neta;
				
			if($baf=='1')
				$fleteventa = $fleteventa - $datostp['incremento_baf'].'<br>';
				
			$queryins="INSERT INTO cot_fletes (idtipo, idtarifario, idcot_temp, baf, fleteventa, total_neta, minimo_venta, condiciones) VALUES('$id', '$idtarifario', '$_GET[idcot_temp]', '$baf', '$fleteventa', '$total_neta', '$minimo_venta', '$_POST[condiciones_flete]')";
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
		}		 
	}
	
	//aereo--------------------------------------------------------------------------------------------------------------
	$sqldel = "delete from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]'";
	$exedel = mysqli_query($link,$sqldel);	
	
	
	//elimina las tarifas actuales
	
	//$sqldel = "delete FROM `tipo` WHERE `idtarifario` in (select idtarifario from tarifario where clasificacion='fcl' and fecha_vigencia > '2014-09-22' and idtarifario in (select idtarifario from cot_fletes where idcot_temp='$_GET[idcot_temp]') and estado='1' )";
	$exedel = mysqli_query($link,$sqldel);	
	
	
	$queryins="INSERT INTO cot_fletes_aereo (
					idtipo_aereo, 
					idtarifario_aereo, 
					idcot_temp, 
					venta, 
					condiciones, 
					security, 
					mz, 
					fuel) (select 
								idtipo_aereo, 
								idtarifario_aereo, 
								idcot_temp, 
								venta, 
								condiciones, 
								security, 
								mz, 
								fuel 
							from cot_fletes_aereo_tmp where idcot_temp='$_GET[idcot_temp]')";
	$buscarins=mysqli_query($link,$queryins);
	
	$queryins = "update cot_fletes_aereo set condiciones='$_POST[condiciones_flete]' where idcot_temp='$_GET[idcot_temp]'";
	$buscarins=mysqli_query($link,$queryins);
			
	$sqldel = "delete from cot_fletes_aereo_tmp where idcot_temp='$_GET[idcot_temp]'";
	$exedel = mysqli_query($link,$sqldel);
	
	

	if(isset($_POST['sel_minimo'])){
		foreach($_POST['sel_minimo'] as $id)
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $_POST['venta_minimo'.$id];
			$security = $_POST['security_minimo'.$id];
			$mz = $_POST['mz_minimo'.$id];
			$fuel = $_POST['fuel_minimo'.$id];
				
			$queryins="INSERT INTO cot_fletes_aereo (idtipo_aereo, idtarifario_aereo, idcot_temp, venta, condiciones, security, mz, fuel) VALUES('$id', '$idtarifario_aereo', '$_GET[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$security', '$mz', '$fuel')";
			$buscarins=mysqli_query($link,$queryins);
		}		 
	}
	if(isset($_POST['sel_normal'])){
		foreach($_POST['sel_normal'] as $id)
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $_POST['venta_normal'.$id];
			$security = $_POST['security_normal'.$id];
			$mz = $_POST['mz_normal'.$id];
			$fuel = $_POST['fuel_normal'.$id];
				
			$queryins="INSERT INTO cot_fletes_aereo (idtipo_aereo, idtarifario_aereo, idcot_temp, venta, condiciones, security, mz, fuel) VALUES('$id', '$idtarifario_aereo', '$_GET[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$security', '$mz', '$fuel')";
			$buscarins=mysqli_query($link,$queryins);
		}		 
	}
	
	//--Aereo
	if(isset($_POST['sel45'])){
		foreach($_POST['sel45'] as $id){
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $_POST['venta45'.$id];
			$security = $_POST['security45'.$id];
			$mz = $_POST['mz45'.$id];
			$fuel = $_POST['fuel45'.$id];
				
			$queryins="INSERT INTO cot_fletes_aereo (idtipo_aereo, idtarifario_aereo, idcot_temp, venta, condiciones, security, mz, fuel) VALUES('$id', '$idtarifario_aereo', '$_GET[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$security', '$mz', '$fuel')";
			$buscarins=mysqli_query($link,$queryins);
		}		 
	}
	if(isset($_POST['sel100'])){
		foreach($_POST['sel100'] as $id){
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $_POST['venta100'.$id];
			$security = $_POST['security100'.$id];
			$mz = $_POST['mz100'.$id];
			$fuel = $_POST['fuel100'.$id];
				
			$queryins="INSERT INTO cot_fletes_aereo (idtipo_aereo, idtarifario_aereo, idcot_temp, venta, condiciones, security, mz, fuel) VALUES('$id', '$idtarifario_aereo', '$_GET[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$security', '$mz', '$fuel')";
			$buscarins=mysqli_query($link,$queryins);
		}		 
	}
	if(isset($_POST['sel300'])){
		foreach($_POST['sel300'] as $id)
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $_POST['venta300'.$id];
			$security = $_POST['security300'.$id];
			$mz = $_POST['mz300'.$id];
			$fuel = $_POST['fuel300'.$id];
				
			$queryins="INSERT INTO cot_fletes_aereo (idtipo_aereo, idtarifario_aereo, idcot_temp, venta, condiciones, security, mz, fuel) VALUES('$id', '$idtarifario_aereo', '$_GET[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$security', '$mz', '$fuel')";
			$buscarins=mysqli_query($link,$queryins);
		}		 
	}
	if(isset($_POST['sel500'])){
		foreach($_POST['sel500'] as $id)
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $_POST['venta500'.$id];
			$security = $_POST['security500'.$id];
			$mz = $_POST['mz500'.$id];
			$fuel = $_POST['fuel500'.$id];
				
			$queryins="INSERT INTO cot_fletes_aereo (idtipo_aereo, idtarifario_aereo, idcot_temp, venta, condiciones, security, mz, fuel) VALUES('$id', '$idtarifario_aereo', '$_GET[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$security', '$mz', '$fuel')";
			$buscarins=mysqli_query($link,$queryins);
		}		 
	}
	if(isset($_POST['sel1000'])){
		foreach($_POST['sel1000'] as $id)
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $_POST['venta1000'.$id];
			$security = $_POST['security1000'.$id];
			$mz = $_POST['mz1000'.$id];
			$fuel = $_POST['fuel1000'.$id];
				
			$queryins="INSERT INTO cot_fletes_aereo (idtipo_aereo, idtarifario_aereo, idcot_temp, venta, condiciones, security, mz, fuel) VALUES('$id', '$idtarifario_aereo', '$_GET[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$security', '$mz', '$fuel')";
			$buscarins=mysqli_query($link,$queryins);
		}		 
	}
	
	
	//--fcl
	//aereo--------------------------------------------------------------------------------------------------------------

	
	if(isset($_POST['sel20'])){
		foreach($_POST['sel20'] as $id){
			$idtarifario = scai_get_name("$id","tipo", "idtipo", "idtarifario");
			$baf = $_POST['baf'.$idtarifario];
			$gri = $_POST['gri'.$idtarifario];
			$pss = $_POST['pss'.$idtarifario];
			$all_in_20 = $_POST['all_in_20'.$idtarifario];
			$all_in_40 = $_POST['all_in_40'.$idtarifario];
			$all_in_40hq = $_POST['all_in_40hq'.$idtarifario];
			
			$sqltp = "select * from tipo where idtipo='$id'"; 
			$exetp = mysqli_query($link,$sqltp);
			$datostp = mysqli_fetch_array($exetp);
			
			$fleteventa = $datostp['all_in'];
			
			if ($all_in_20 != '')
				$fleteventa = $all_in_20;
				
			if($baf=='1')
				$fleteventa = $fleteventa - $datostp['baf'].'<br>';
			if($gri=='1')	
				$fleteventa = $fleteventa - $datostp['gri_1'].'<br>';
			if($pss=='1')
				$fleteventa = $fleteventa - $datostp['peak_season'].'<br>';
				
			$queryins="INSERT INTO cot_fletes (
							idtipo, 
							idtarifario,
							idcot_temp, 
							baf, 
							gri, 
							pss, 
							fleteventa, 
							all_in_20, 
							all_in_40, 
							all_in_40hq, 
							condiciones
						) VALUES(
							'$id', 
							'$idtarifario', 
							'$_GET[idcot_temp]', 
							'$baf', 
							'$gri', 
							'$pss', 
							'$fleteventa', 
							'$all_in_20', 
							'$all_in_40', 
							'$all_in_40hq', 
							'$_POST[condiciones_flete]')";

			$buscarins=mysqli_query($link,$queryins);
		}
	}
	if(isset($_POST['sel40']))
	{
		foreach($_POST['sel40'] as $id)
		{
			$idtarifario = scai_get_name("$id","tipo", "idtipo", "idtarifario");
			$baf = $_POST['baf'.$idtarifario];
			$gri = $_POST['gri'.$idtarifario];
			$pss = $_POST['pss'.$idtarifario];
			$all_in_20 = $_POST['all_in_20'.$idtarifario];
			$all_in_40 = $_POST['all_in_40'.$idtarifario];
			$all_in_40hq = $_POST['all_in_40hq'.$idtarifario];
			
			$sqltp = "select * from tipo where idtipo='$id'"; 
			$exetp = mysqli_query($link,$sqltp);
			$datostp = mysqli_fetch_array($exetp);
			
			$fleteventa = $datostp['all_in'];
			
			if ($all_in_40 != '')
				$fleteventa = $all_in_40;
				
			if($baf=='1')
				$fleteventa = $fleteventa - $datostp['baf'].'<br>';
			if($gri=='1')	
				$fleteventa = $fleteventa - $datostp['gri_1'].'<br>';
			if($pss=='1')
				$fleteventa = $fleteventa - $datostp['peak_season'].'<br>';
				
			$queryins="INSERT INTO cot_fletes (idtipo, idtarifario, idcot_temp, baf, gri, pss, fleteventa, all_in_20, all_in_40, all_in_40hq, condiciones) VALUES('$id', '$idtarifario', '$_GET[idcot_temp]', '$baf', '$gri', '$pss', '$fleteventa', '$all_in_20', '$all_in_40', '$all_in_40hq', '$_POST[condiciones_flete]')";
			$buscarins=mysqli_query($link,$queryins);
		}
	}
	if(isset($_POST['sel40hq']))
	{
		foreach($_POST['sel40hq'] as $id)
		{
			$idtarifario = scai_get_name("$id","tipo", "idtipo", "idtarifario");
			$baf = $_POST['baf'.$idtarifario];
			$gri = $_POST['gri'.$idtarifario];
			$pss = $_POST['pss'.$idtarifario];
			$all_in_20 = $_POST['all_in_20'.$idtarifario];
			$all_in_40 = $_POST['all_in_40'.$idtarifario];
			$all_in_40hq = $_POST['all_in_40hq'.$idtarifario];
			
			$sqltp = "select * from tipo where idtipo='$id'"; 
			$exetp = mysqli_query($link,$sqltp);
			$datostp = mysqli_fetch_array($exetp);
			
			$fleteventa = $datostp['all_in'];
			
			if ($all_in_40hq != '')
				$fleteventa = $all_in_40hq;
			
			if($baf=='1')
				$fleteventa = $fleteventa - $datostp['baf'].'<br>';
			if($gri=='1')	
				$fleteventa = $fleteventa - $datostp['gri_1'].'<br>';
			if($pss=='1')
				$fleteventa = $fleteventa - $datostp['peak_season'].'<br>';
				
			$queryins="INSERT INTO cot_fletes (idtipo, idtarifario, idcot_temp, baf, gri, pss, fleteventa, all_in_20, all_in_40, all_in_40hq, condiciones) VALUES('$id', '$idtarifario', '$_GET[idcot_temp]', '$baf', '$gri', '$pss', '$fleteventa', '$all_in_20', '$all_in_40', '$all_in_40hq', '$_POST[condiciones_flete]')";
			$buscarins=mysqli_query($link,$queryins);
		}
	}

//VIGENCIA-------------------------------------------------------------------------------------------------------------------------------
	
		
//condiciones de los fletes por naviera---------------------------------------------------------------------------------------------------------------------------------------
	if($_GET['cl']=='fcl')
	{
		$tipo = 'tipo';
		$idtipo = 'idtipo';
	}
	elseif($_GET['cl']=='lcl')
	{
		$tipo = 'tipo_lcl';
		$idtipo = 'idtipo_lcl';
	}
	$sqlidt = "select distinct idtarifario from $tipo where $idtipo in(select idtipo from cot_fletes where idcot_temp='$_GET[idcot_temp]')";
	if($_GET['cl']=='aereo')
		$sqlidt = "select distinct idtarifario_aereo as idtarifario from tipo_aereo where idtipo_aereo in(select idtipo_aereo from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]')";
	//print $sqlidt .'<br>';
	$exeidt = mysqli_query($link,$sqlidt);
	
	$cad_idtar = "''";
	while($datosidt = mysqli_fetch_array($exeidt))
	{
		if($cad_idtar != '')
			$cad_idtar .= ',';
		$cad_idtar .= " '".$datosidt['idtarifario'] ."'";		
	}
	$sqlnav = "select distinct idnaviera from tarifario where idtarifario in ($cad_idtar) and idnaviera not in ($navold)";
	if($_GET['cl']=='aereo')
		$sqlnav = "select distinct idaerolinea as idnaviera from tarifario_aereo where idtarifario_aereo in ($cad_idtar) and idaerolinea not in ($navold)";
	//print $sqlnav .'<br>';
	$exenav = mysqli_query($link,$sqlnav);

	while($datosnav = mysqli_fetch_array($exenav))	
	{
		$condiciones_nav = scai_get_name("$datosnav[idnaviera]", "proveedores_agentes", "idproveedor_agente", "condiciones_fletes");
		if($condiciones_nav != '')
		{
			if($condiciones_fletes != '')
				$condiciones_fletes .= '<br>';
			$condiciones_fletes .= $condiciones_nav;
		}		
	}
	$conold = scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "condiciones_fletes");
	
	if($condiciones_fletes != '')
	{
		if($conold != '')
			$conold .= '<br>';
		$conold .= $condiciones_fletes;
	}
	
	$sql = "update cot_temp set condiciones_fletes='$conold' where idcot_temp='$_GET[idcot_temp]'";
	$exe = mysqli_query($link,$sql);
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	if($_POST['atrasok']=='si')
		$destino = 'paso1_selcliente.php';
	elseif($_POST['atrasok']=='no')
		$destino = 'tarif_recargos_origen.php';	
		
	?><script>document.location='<? print $destino; ?>?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl']?>';</script><?
}

if (isset($_POST['idtarifario']))
	$_GET['idtarifario'] == $_POST['idtarifario'];
?>
<body style="background-color: transparent;">
<form name="formulario" method="post">
<input name="clasif_cot" type="hidden" value="<? print $_GET['cl'] ?>" />
<input name="datosok" type="hidden" value="no" />
<input name="tarifasok" type="hidden" value="no" />
<input name="atrasok" type="hidden" value="no" />
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
$sqlad = "select * from $tabla";
$exead = mysqli_query($link,$sqlad);
$datosad = mysqli_fetch_array($exead);

	/*
	if(isset($_GET['xyz']) and $_GET['xyz']!="")
		$_POST['xyz'] = $_GET['xyz'];
	if(isset($_POST['xyz']) and $_POST['xyz']!="")
	{
		$sql = "SELECT * FROM $tabla WHERE num_contrato LIKE '%$_POST[xyz]%'";
		$query = mysqli_query($link,$sql);
		$filas = mysqli_num_rows($query);
		if ($filas == 0)
			print ("<script>alert('Esta tarifa no existe vuelva a intentarlo')</script>");
		else
		{
			if ($filas == 1)
			{
				$row = mysqli_fetch_array($query);
				print ("<script>document.location.href='".$_SERVER['PHP_SELF']."?idtarifario=$row[idtarifario]&cl=$_GET[cl]'</script>");
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
							print "<a href=".$_SERVER['PHP_SELF']."?idtarifario=$row[idtarifario]&cl=$_GET[cl]>$row[num_contrato]</a><br>";
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

if($_POST['nueRegistro'] == "si" || $_POST['idnaviera']!='') 
{
	if($_POST['modRegistro']=="si")
	{
	}	
}
?>  
<script>
function limpiar_filtros()
{
	document.getElementById('ver_sel').checked = false;
	document.formulario.naviera.value="";
	document.formulario.origen.value="";
	document.formulario.destination.value="";
	haber(document.formulario.naviera.value, document.formulario.origen.value, document.formulario.destination.value, document.formulario.aeropuerto_origen.value, '1');
}
</script>
<table border="0" width="100%">
	<tr>
		<td align="center">
			<span class="contenidotab" style="font-size:14px;"><a href="paso1_selcliente.php?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl']?>">Paso 1: Seleccionar cliente</a>|<a href="tarif_recargos_origen.php?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl']?>">Paso 3: Cotizar recargos de origen</a>|<a href="tarif_recargos_local.php?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl']?>">Paso 4: Cotizar recargos locales</a>|<a href="paso5_final.php?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl']?>">Paso 5: Finalizar</a></span>
		</td>
	</tr>
</table>
<div id="eyes14">
</div>
<table width="80%" align="center" class="contenidotab">
	<tr align="center">
    	<td height="40" colspan="4" class="subtitseccion" style="text-align:center"><? if($_GET['idcot_temp']!='') print 'COTIZACI&Oacute;N '.scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero").', '?>PASO 2 DE 5: SELECCIONAR FLETES <? print $_GET['cl'] ?> <a href="javascript:winback('preview.php?id=<? print $_GET['idcot_temp'];?>&cl=<? print $_GET['cl'] ?>')">(vista preliminar)</a><br>
   	  <br></td>
    </tr>
    <tr align="center">
    <td height="26" align="center" class="tit_vueltas"><? if($_GET['cl']=='aereo') print 'Aerolinea'; else print 'Naviera'; ?>
    <input name="naviera" id="naviera"  class="tex3" type="text" value="" maxlength="70" size="15" onKeyUp="" >
     
	 <? if($_GET['cl']=='aereo') 
     {
     	?>
        Agente
        <select id="origen" name="origen" class="tex2" >
            <option value="N"> Seleccione </option>
            <?
            $es="select * from proveedores_agentes where tipo='agente' order by nombre";
            $exe=mysqli_query($link,$es);
            while($row=mysqli_fetch_array($exe))	
            {
                $sel = '';
                if($_GET['origen']==$row['idproveedor_agente'])
                    $sel = 'selected';
                print "<option value='$row[idproveedor_agente]' $sel>$row[nombre]</option>";
            }
            ?>
        </select>
        Pais
        <select id="destination" name="destination" class="tex2" >
            <option value="N"> Seleccione </option>
            <?
            $es="select * from paises order by nombre";
            $exe=mysqli_query($link,$es);
            while($row=mysqli_fetch_array($exe))
            {
                $sel = "";
                if($_GET['destination']==$row['idpais'])
                    $sel = "selected";
                print "<option value='$row[idpais]' $sel>$row[nombre]</option>";
            }
            ?>
        </select>   
        Aeropuerto origen
        <select id="aeropuerto_origen" name="aeropuerto_origen" class="tex2" >
            <option value="N"> Seleccione </option>
            <?
            $es="select * from aeropuertos_puertos where tipo='aeropuerto' order by nombre";
            $exe=mysqli_query($link,$es);
            while($row=mysqli_fetch_array($exe))
            {
                $sel = "";
                if($_GET['aeropuerto_origen']==$row['idaeropuerto_puerto'])
                    $sel = "selected";
                print "<option value='$row[idaeropuerto_puerto]' $sel>$row[nombre]</option>";
            }
            ?>
        </select>              
        <?
     }
     else
     {
     	?>
        Puerto Origen <input name="origen" id="origen"  class="tex3" type="text" value="" maxlength="70" size="15" onKeyUp=""> 
        Puerto Destino <input name="destination" id="destination"  class="tex3" type="text" value="" maxlength="70" size="15" onKeyUp="">
        
        Pais
        <select id="aeropuerto_origen" name="aeropuerto_origen" class="tex2" >
            <option value="N"> Seleccione </option>
            <?
            $es="select * from paises order by nombre";
            $exe=mysqli_query($link,$es);
            while($row=mysqli_fetch_array($exe))
            {
                $sel = "";
                if($_GET['aeropuerto_origen']==$row['idpais'])
                    $sel = "selected";
                print "<option value='$row[idpais]' $sel>$row[nombre]</option>";
            }
            ?>
        </select>
        <?
     }
	?>
     &nbsp;&nbsp;&nbsp;					
	<input class="botonesadmin" style="color:#FFFFFF;" onClick="recoger(document.formulario.naviera.value, document.formulario.origen.value, document.formulario.destination.value, document.formulario.aeropuerto_origen.value, '1');" type='button' value='Buscar' name='buscar' />
    <input class="botonesadmin" style="color:#FFFFFF;" onClick="limpiar_filtros()" type='button' value='Limpiar filtros' name='limp_fil' />	
	  </td>
    </tr>     
</table>
<table>
	<tr>
        <td colspan="5" align="left">
            <table>
                <tr>
                	<? if(puedo("m","COTIZACION")==1 && $filasrn==0) { ?>
                    <td width="60" class="botonesadmin">
						<a href="javascript: void(0)" onClick="recoger(document.formulario.naviera.value, document.formulario.origen.value, document.formulario.destination.value, document.formulario.aeropuerto_origen.value, '1'); recoger_otm(document.forms[0].filtro1.value, document.forms[0].filtro2.value, document.forms[0].filtro3.value, document.forms[0].filtro4.value, '1'); irAtras(formulario);">Atras</a>
					</td>
					<td width="60" class="botonesadmin">
						
						<!--<a href="javascript: void(0)" onClick="recoger(document.formulario.naviera.value, document.formulario.origen.value, document.formulario.destination.value, document.formulario.aeropuerto_origen.value, '1'); recoger_otm(document.forms[0].filtro1.value, document.forms[0].filtro2.value, document.forms[0].filtro3.value, document.forms[0].filtro4.value, '1'); adicionaTarifas(formulario);">-->
					<a href="javascript: void(0)" onClick="recoger(document.formulario.naviera.value, document.formulario.origen.value, document.formulario.destination.value, document.formulario.aeropuerto_origen.value, '1'); recoger_otm(document.forms[0].filtro1.value, document.forms[0].filtro2.value, document.forms[0].filtro3.value, document.forms[0].filtro4.value, '1'); adicionaTarifas(formulario);">
					
						Siguente
					</a>
					</td>
                    <? } ?>
                </tr>
            </table> 
        </td>        	
    </tr>
</table>

<a href="javascript:void(0);" class="subtitseccion" onClick="showmed(divFlete)">Selecci&oacute;n de fletes</a><br>
<div class="divCarga" id="divFlete" > 
	<?
	if($_GET['cl']=='fcl')
		include("search_cotizacion.php");
	elseif($_GET['cl']=='lcl')
		include("search_cotizacion_lcl.php");	
	elseif($_GET['cl']=='aereo')
		include("search_cotizacion_aereo.php");
	?>
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
	
	$sqlcb = "select * from cot_fletes where idcot_temp='$_GET[idcot_temp]' limit 0,1";
	//print $sqlcb.'<br>';
	$execb = mysqli_query($link,$sqlcb);
	$datoscb= mysqli_fetch_array($execb);
	
	?>
    <table width="100%" align="center">	
<!--     <input type="hidden" name="condiciones_flete" id="condiciones_flete" value="">-->
<tr>
			<td align="center" class="subtitseccion" style="font-size:11px">Condiciones generales</td>
		</tr>
     <tr>
    	<td align="center"><textarea name="condiciones_flete" id="condiciones_flete" cols="100" rows="10"><? if($datoscb['condiciones_flete']=='') print $cond['valor']; else print $datoscb['condiciones_flete']; ?></textarea>
    	</td>
    </tr></table>
</div>



<? if($_GET['cl']!='aereo') { ?>
<a href="javascript:void(0);" class="subtitseccion" onClick="showmed(divOtm)">Selecci&oacute;n de OTM</a>
<? } ?>

<div class="divCarga" id="divOtm" > 
	<table width="80%" align="center" class="contenidotab">     
		<tr align="center">
			<td class="tit_vueltas" align="center">
				Seleccionadas
				<input name="ver_sel_otm" id="ver_sel_otm"  class="tex3" type="checkbox" value="1">        
				Proveedor&nbsp;
				<select name="filtro1" class="Ancho_120px" id="filtro1">
					<option value="N"> Seleccione </option>
					<?
					$es="select * from proveedores_agentes where tipo='otm' order by nombre";
					$exe=mysqli_query($link,$es);
					while($row=mysqli_fetch_array($exe))	
					{
						$sel = '';
						if($_GET['filtro1']==$row['idproveedor_agente'])
							$sel = 'selected';
						print "<option value='$row[idproveedor_agente]' $sel>$row[nombre]</option>";
					}
					?>
				</select>                    
				<? $_GET['filtro2'] = str_replace("\\", "", $_GET['filtro2']); ?>
				<? if($_GET['cl']=='fcl') print 'Tipo'; elseif($_GET['cl']=='lcl') print 'Rango'; ?>&nbsp;
				<select id="filtro2" name="filtro2" class="tex2">
					<option value="N"> Seleccione </option>
					<?
					$es="select * from tipotm where clasificacion='$_GET[cl]' order by nombre";
					$exe=mysqli_query($link,$es);
					while($row=mysqli_fetch_array($exe))	
					{
						$sel = '';
						if($_GET['filtro2']==$row['idtipotm'])
							$sel = 'selected';
						print "<option value='$row[idtipotm]' $sel>$row[nombre]</option>";
					}
					?>
				</select>
				
				Puerto Origen&nbsp;
				<?
				$es="select * from aeropuertos_puertos where tipo='puerto' and idaeropuerto_puerto in (select idaeropuerto_puerto from ciudades_has_aeropuertos_puertos where idciudad in (select idciudad from ciudades where idpais in(select idpais from paises where nombre='colombia'))) order by nombre";
	
				?>
				<select name="filtro3" class="Ancho_120px" id="filtro3">
					<option value="N"> Seleccione </option>
					<?
					$exe=mysqli_query($link,$es);
					while($row=mysqli_fetch_array($exe))
					{
						$sel = "";
						if($_GET['filtro3']==$row['idaeropuerto_puerto'])
							$sel = "selected";
						print "<option value='$row[idaeropuerto_puerto]' $sel>$row[nombre]</option>";
					}
					?>
				</select>
				Ciudad Destino&nbsp;
				<select name="filtro4" class="Ancho_120px" id="filtro4">
					<option value="N"> Seleccione </option>
					<?
					$es = "select * from ciudades where idpais in(select idpais from paises where nombre like '%colombia%') order by nombre"; 
					$exe=mysqli_query($link,$es);
					while($row=mysqli_fetch_array($exe))
					{
						$sel = "";
						if($_GET['filtro4'] == $row['idciudad'])
							$sel = "selected";
						print "<option value='$row[idciudad]' $sel>$row[nombre]</option>";
					}	
					?>
				</select>
				<input class="botonesadmin" style="color:#FFFFFF;" onClick="recoger_otm(document.forms[0].filtro1.value, document.forms[0].filtro2.value, document.forms[0].filtro3.value, document.forms[0].filtro4.value, '1');" type='button' value='Buscar' name='buscarotm' />
			</td>
		</tr>     
	</table><?
	
	include("search_otm.php"); 
	$sqlrg = "select * from recargos_local_otm where clasificacion='$_GET[cl]' and estado='1'";
	$exerg = mysqli_query($link,$sqlrg);
	$filasrg = mysqli_num_rows($exerg);
	if($filasrg > 0){
		?>
		<table width="100%" align="center"> 
		<tr>
			<td class="tittabla">Recargo</td>
			<td class="tittabla">Tipo</td>
			<td class="tittabla">Valor($)</td>
			<td class="tittabla">Minimo($)</td>
			<td class="tittabla">Fecha de validez</td>
		</tr>
		<?
		while($datosrg = mysqli_fetch_array($exerg))
		{
			$checked = '';
			
			$sqlr = "select idrecargo_local from local_otm_por_cotizacion where idcot_temp='$_GET[idcot_temp]'";
			//print $sqlr.'<br>';
			$exer = mysqli_query($link,$sqlr);
			while($datosr = mysqli_fetch_array($exer))
			{
				if($datosr['idrecargo_local'] == $datosrg['idrecargo_local'])
					$checked = 'checked';
			}
			
			$sqlv = "select * from local_otm_por_cotizacion where idcot_temp='$_GET[idcot_temp]' and idrecargo_local='$datosrg[idrecargo_local]'";
			//print $sqlv.'<br>';
			$exev = mysqli_query($link,$sqlv);
			$datosv = mysqli_fetch_array($exev);
			
			$sqln = "select NOW() as ahora";
			$exen = mysqli_query($link,$sqln);
			$datosn3 = mysqli_fetch_array($exen);
			$color = '#000000';	
			if($datosrg['fecha_validez'] < $datosn3['ahora'])
				$color = '#FF0000';	
			?>
			<tr>
				<td class="contenidotab" style="color:<? print $color; ?>">   
					<input id="recargo_otm<? print $datosrg['idrecargo_local']; ?>" name="recargo_otm<? print $datosrg['idrecargo_local']; ?>" type="checkbox" class="tex1" value="<? print $datosrg['idrecargo_local']; ?>" <? print $checked; ?> onClick="addi(this.value,this.name,'<? print $datosrg['tipo']; ?>','<? print $datosrg['idproveedor']; ?>','<? print $datosrg['clasificacion']; ?>')" ><? print $datosrg['nombre'];?>
				</td>
				<td class="contenidotab" style="color:<? print $color; ?>"><? print $datosrg['tipo'];?></td>
				<td class="contenidotab" style="color:<? print $color; ?>">
					<? $msg = 'Valor compra: '.$datosrg['valor'].'<br>Margen: '.$datosrg['margen']; ?>
					<input type="text" id="recargo_otm_valor_venta<? print $datosrg['idrecargo_local']; ?>" name="recargo_otm_valor_venta<? print $datosrg['idrecargo_local']; ?>" class="tex2" value="<? if($datosv['valor_venta']=='') { if($datosrg['valor_venta']=='') print '0'; else print $datosrg['valor_venta']; } else print $datosv['valor_venta']; ?>" onBlur="addi('<? print $datosrg['idrecargo_local']; ?>','<? print 'recargo'.$datosrg['idrecargo_local']; ?>','<? print $datosrg['tipo']; ?>','<? print $datosrg['idnaviera']; ?>','<? print $datosrg['clasificacion']; ?>')" maxlength="20" size="3" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>"/>
					<input type="hidden" id="u_recargo_otm_valor_venta<? print $datosrg['idrecargo_local']; ?>" name="u_recargo_otm_valor_venta<? print $datosrg['idrecargo_local']; ?>" value="" />                
				</td>
				<td class="contenidotab" style="color:<? print $color; ?>">
					<? $msg = 'Minimo compra: '.$datosrg['minimo'].'<br>Margen: '.$datosrg['margen_minimo']; ?>
					<input type="text" id="recargo_otm_minimo_venta<? print $datosrg['idrecargo_local']; ?>" name="recargo_otm_minimo_venta<? print $datosrg['idrecargo_local']; ?>" class="tex2" value="<? if($datosv['minimo_venta']=='') {if($datosrg['minimo_venta']=='') print '0'; print $datosrg['minimo_venta']; } else print $datosv['minimo_venta']; ?>" maxlength="20" size="3" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>"/>
					<input type="hidden" id="u_recargo_otm_minimo_venta<? print $datosrg['idrecargo_local']; ?>" name="u_recargo_otm_minimo_venta<? print $datosrg['idrecargo_local']; ?>" value="" />
				</td>
				<td class="contenidotab" style="color:<? print $color; ?>"><? print substr($datosrg['fecha_validez'],0 ,10); ?></td>
				</td>
			</tr>
			<?
		}
		?>
		</table>
		<?
	}
	?>
	<table width="100%" align="center">
		<?
		$sqlot = "select * from cot_otm where idcot_temp='$_GET[idcot_temp]'";
		//	print $sqlot.'<br>';
		$exeot = mysqli_query($link,$sqlot);
		$datosot =  mysqli_fetch_array($exeot);
		?>
		<tr>
			<td align="center" class="subtitseccion" style="font-size:11px">Condiciones generales</td>
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
			<td align="center" width="100%"><textarea cols="100" rows="10" name="condiciones" id="condiciones"><? if($datosot['condiciones']=='') print $cond['valor']; else print $datosot['condiciones']; ?></textarea>
			</td>
		</tr>
		
	<!--	<input type="hidden" name="doc_req" id="doc_req" value="<? if($datosot['documentacion']=='') print $cond['valor']; else print $datosot['documentacion']; ?>">-->
	</table>
</div>


<? if($_GET['cl']!='aereo') print '<br>'; ?>



<a href="javascript:void(0);" class="subtitseccion" onClick="showmed(cargaNac)">Selecci&oacute;n de Carga nacionalizada</a>

<div class="divCarga" id="cargaNac" > 
	<!--Filtros-->
	<table width="80%" align="center" class="contenidotab">     
		<tr align="center">
			<td class="tit_vueltas" align="center">
				Seleccionadas
				<input name="ver_sel_nac" id="ver_sel_nac"  class="tex3 search_terrestre" type="checkbox" value="1">        
				Proveedor&nbsp;
				<select name="proveedorNac" class="Ancho_120px search_terrestre" id="proveedorNac">
					<option value=""></option>
					<?
					$es="select * from proveedores_agentes where tipo='otm' order by nombre";
					$exe=mysqli_query($link,$es);
					while($row=mysqli_fetch_array($exe))	
					{
						$sel = '';
						if($_GET['filtro1']==$row['idproveedor_agente'])
							$sel = 'selected';
						print "<option value='$row[idproveedor_agente]' $sel>$row[nombre]</option>";
					}
					?>
				</select>                    
				<? $_GET['filtro2'] = str_replace("\\", "", $_GET['filtro2']); ?>
				<? if($_GET['cl']=='fcl') print 'Tipo'; elseif($_GET['cl']=='lcl') print 'Rango'; ?>&nbsp;
				
				
				Puerto Origen&nbsp;
				<?
				$es="select * from aeropuertos_puertos where tipo='puerto' and idaeropuerto_puerto in (select idaeropuerto_puerto from ciudades_has_aeropuertos_puertos where idciudad in (select idciudad from ciudades where idpais in(select idpais from paises where nombre='colombia'))) order by nombre";
	
				?>
				<select name="origenNac" class="Ancho_120px search_terrestre" id="origenNac">
					<option></option>
					<?
					$exe=mysqli_query($link,$es);
					while($row=mysqli_fetch_array($exe))
					{
						$sel = "";
						if($_GET['filtro3']==$row['idaeropuerto_puerto'])
							$sel = "selected";
						print "<option value='$row[idaeropuerto_puerto]' $sel>$row[nombre]</option>";
					}
					?>
				</select>
				Ciudad Destino&nbsp;
				<select name="destinoNac" class="Ancho_120px search_terrestre" id="destinoNac">
					<option></option>
					<?
					$es = "select * from ciudades where idpais in(select idpais from paises where nombre like '%colombia%') order by nombre"; 
					$exe=mysqli_query($link,$es);
					while($row=mysqli_fetch_array($exe))
					{
						$sel = "";
						if($_GET['filtro4'] == $row['idciudad'])
							$sel = "selected";
						print "<option value='$row[idciudad]' $sel>$row[nombre]</option>";
					}	
					?>
				</select>
				<input class="botonesadmin" style="color:#FFFFFF;" onClick="searchCarga('<?= $_GET['idcot_temp'];?>','<?= $_GET['cl'];?>')" type='button' value='Buscar' name='buscarotm' />
			</td>
		</tr>     
	</table>
	
	<div id="searchNac">
		<? include("search_terrestre.php"); ?>
	</div>

	<table width="100%" align="center">
		<?
		$sqlte = "select * from cot_terrestre where idcot_temp='$_GET[idcot_temp]'";
		//	print $sqlte.'<br>';
		$exete = mysqli_query($link,$sqlte);
		$datoste =  mysqli_fetch_array($exete);
		?>
		<tr>
			<td align="center" class="subtitseccion" style="font-size:11px">Condiciones generales</td>
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
			<td align="center" width="100%"><textarea cols="100" rows="10" name="condiciones_terrestre" id="condiciones_terrestre"><? if($datoste['condiciones']=='') print $cond['valor']; else print $datoste['condiciones']; ?></textarea>
			</td>
		</tr>
	</table>

</div>
<br>

<a href="javascript:void(0);" class="subtitseccion" onClick="showmed(cargaDta)">Selecci&oacute;n DTA</a>
<div class="divCarga" id="cargaDta" > 
	<? include("search_dta.php"); ?>
</div>
<br>

<a href="javascript:void(0);" class="subtitseccion" onClick="showmed(divSeguro)">Selecci&oacute;n de Seguro</a>
<div class="divCarga" id="divSeguro">
	<table width="100%"> 
		<tr>
			<td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Seleccionar</td>
			<td class="tittabla">Proveedor</td>
			<td class="tittabla">Porcentaje(%)</td>
			<td class="tittabla">Minimo($)</td>
			<td class="tittabla">Moneda</td> 
			<td class="tittabla">Fecha creación</td>
			<td class="tittabla">Fecha validez</td>
			<td class="tittabla">Observaciones</td>
		</tr>    
			<?
			$sqlseg2 = "select * from seguro where estado='1' order by fecha_creacion DESC";
			//print $sqlseg2.'<br>';
			$exeseg2 = mysqli_query($link,$sqlseg2);
			
			$cant=mysqli_num_rows($exeseg2);
			
			$regxpag = 10;
			$totpag = ceil($cant / $regxpag);
			$pag = $_GET['pag'];
			if (!$pag)
				$pag = 1;
			else
			{
				if (is_numeric($pag) == false)
					$pag = 1;
			}
			$regini = ($pag - 1) * $regxpag;
			$sqlpag = $sqlseg2." LIMIT $regini, $regxpag";
			$buscarpag=mysqli_query($link,$sqlpag);
			$cantpag=mysqli_num_rows($buscarpag);
			
			
			$sqlseg = "select * from cot_seg where idcot_temp='$_GET[idcot_temp]'";
			//print $sqlseg.'<br>';
			$exeseg = mysqli_query($link,$sqlseg);
			$idseguros[] = '0';
			
			while ($datoseg = mysqli_fetch_array($exeseg))
			{
				$idseguros[] = $datoseg['idseguro'];
			}
			
			for($i=0;$i<$cantpag;$i++)
			{
				$datoseg2 = mysqli_fetch_array($buscarpag);
				
				$sqlseg = "select * from cot_seg where idcot_temp='$_GET[idcot_temp]' and idseguro='$datoseg2[idseguro]'";
				//print $sqlseg.'<br>';
				$exeseg = mysqli_query($link,$sqlseg);
				$datoseg = mysqli_fetch_array($exeseg);
				
				$sqln = "select NOW() as ahora";
				$exen = mysqli_query($link,$sqln);
				$datosn3 = mysqli_fetch_array($exen);
				$color = '#000000';	
				if($datoseg2['fecha_validez'] < $datosn3['ahora'])
					$color = '#FF0000';		
				?>  
				 <tr> 
					<td class="contenidotab" style="color:<? print $color; ?>"><input name="selsg[]" type="checkbox" onClick="" value="<? print $datoseg2['idseguro']; ?>" <? if(in_array($datoseg2['idseguro'], $idseguros)) print 'checked'; ?> /></td>
					<td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datoseg2[idproveedor]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
					<td class="contenidotab" style="color:<? print $color; ?>">
						<? $msg = 'Porcentaje compra: '.$datoseg2['porcentaje'].'<br>Margen: '.$datoseg2['margen_porcentaje']; ?>
						<input id="porcentaje<? print $datoseg2['idseguro']; ?>" name="porcentaje<? print $datoseg2['idseguro']; ?>" class="tex2" value="<? if($datoseg['porcentaje']=='') print $datoseg2['porcentaje_venta']; else print $datoseg['porcentaje']; ?>" maxlength="50" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>">
						<input type="hidden" id="u_porcentaje<? print $datoseg2['idseguro']; ?>" name="u_porcentaje<? print $datoseg2['idseguro']; ?>" value="" />
					</td>
					<td class="contenidotab" style="color:<? print $color; ?>">
						<? $msg = 'Minimo compra: '.$datoseg2['minimo'].'<br>Margen: '.$datoseg2['margen_minimo']; ?>
						<input id="minimo_seg<? print $datoseg2['idseguro']; ?>" name="minimo_seg<? print $datoseg2['idseguro']; ?>" class="tex2" value="<? if($datoseg['minimo']=='') print $datoseg2['minimo_venta']; else print $datoseg['minimo']; ?>" maxlength="50" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>">
						<input type="hidden" id="u_minimo_seg<? print $datoseg2['idseguro']; ?>" name="u_minimo_seg<? print $datoseg2['idseguro']; ?>" value="" />
					</td>
					<td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datoseg2[moneda]", "monedas", "idmoneda", "codigo");?></td>
					<td class="contenidotab" style="color:<? print $color; ?>"><? print $datoseg2['fecha_creacion'];?></td>
					<td class="contenidotab" style="color:<? print $color; ?>"><? print $datoseg2['fecha_validez'];?></td>
					<td class="contenidotab" style="color:<? print $color; ?>"><? print $datoseg2['observaciones'];?></td>
				</tr>
				<?
			}
			?>
    </table>
        <?
		$sqlseg = "select * from cot_seg where idcot_temp='$_GET[idcot_temp]'";
		//print $sqlseg.'<br>';
		$exeseg = mysqli_query($link,$sqlseg);
		$datoseg = mysqli_fetch_array($exeseg);
		?>    
<table align="center">	
    <!--<tr>
    	<td class="contenidotab">Mostrar cotización de seguro <input id="mostrar_seg" name="mostrar_seg" type="checkbox" class="tex1" value="1" <? if($datoseg['mostrar']=='1') print 'checked'; ?> ></td>
    </tr>-->
    <tr>
        <td class="contenidotab">Monto Asegurable</td> 
        <td><input id="monto_aseg" name="monto_aseg" class="tex2" value="<? print $datoseg['monto_aseg']; ?>" maxlength="50" ></td>
    </tr>
    <tr>
    	<td class="contenidotab">Observaciones</td> 
        <td >
        	<textarea name="observaciones_seg" id="observaciones_seg" class="tex1"  cols="100" rows="5"><? print $datoseg['observaciones']; ?></textarea>
        </td>         
    </tr>
</table>
<table align="center">
    <tr>
        <td align="center" class="subtitseccion" style="font-size:11px">Descripci&oacute;n Seguro <? print strtoupper($_GET['cl']); ?></td>
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
        	<textarea name="descripcion_seg" id="descripcion_seg" cols="100" rows="10"><? if($datoseg['descripcion']=='') print $cond['valor']; else print $datoseg['descripcion']; ?></textarea>
     	</td>
    </tr>
</table>            
</div>
<br>
<a href="javascript:void(0);" class="subtitseccion" onClick="showmed(divAduana)">Selecci&oacute;n de Aduana</a>
<div class="divCarga" id="divAduana">
<table width="100%"> 
    <tr>
        <td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Seleccionar</td>
        <td class="tittabla">Proveedor</td>
        <td class="tittabla">Porcentaje(%)</td>
        <td class="tittabla">Minimo($)</td>
        <td class="tittabla">Moneda</td>
        <td class="tittabla">Fecha creación</td>
        <td class="tittabla">Fecha validez</td>
        <td class="tittabla">Observaciones</td>
    </tr>    
        <?
		$sqladu2 = "select * from aduana where estado='1' order by fecha_creacion";
		//print $sqladu2 .'<br>';
		$exeadu2 = mysqli_query($link,$sqladu2 );
		
		$cant=mysqli_num_rows($exeadu2);
		
        $regxpag = 10;
        $totpag = ceil($cant / $regxpag);
        $pag = $_GET['pag'];
        if (!$pag)
            $pag = 1;
        else
        {
            if (is_numeric($pag) == false)
                $pag = 1;
        }
        $regini = ($pag - 1) * $regxpag;
        $sqlpag = $sqladu2 ." LIMIT $regini, $regxpag";
        $buscarpag=mysqli_query($link,$sqlpag);
        $cantpag=mysqli_num_rows($buscarpag);
		
		
		$sqladu = "select * from cot_adu where idcot_temp='$_GET[idcot_temp]'";
		//print $sqladu.'<br>';
		$exeadu = mysqli_query($link,$sqladu);
		
		$idaduanas[] = '0';
		
		while ($datoadu = mysqli_fetch_array($exeadu))
		{
			$idaduanas[] = $datoadu['idaduana'];
		}
		
        for($i=0;$i<$cantpag;$i++)
        {
			$datoadu2 = mysqli_fetch_array($buscarpag);
			
			$sqladu = "select * from cot_adu where idcot_temp='$_GET[idcot_temp]' and idaduana='$datoadu2[idaduana]'";
			//print $sqlseg.'<br>';
			$exeadu = mysqli_query($link,$sqladu);
			$datoadu = mysqli_fetch_array($exeadu);
			
			$sqln = "select NOW() as ahora";
			$exen = mysqli_query($link,$sqln);
			$datosn3 = mysqli_fetch_array($exen);
			$color = '#000000';	
			if($datoadu2['fecha_validez'] < $datosn3['ahora'])
				$color = '#FF0000';					
            ?>  
             <tr> 
                <td class="contenidotab" style="color:<? print $color; ?>"><input name="seladu[]" type="checkbox" onClick="" value="<? print $datoadu2['idaduana']; ?>" <? if(in_array($datoadu2['idaduana'], $idaduanas)) print 'checked'; ?> /></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datoadu2[idproveedor]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<? $msg = 'Porcentaje compra: '.$datoadu2['porcentaje'].'<br>Margen: '.$datoadu2['margen_porcentaje']; ?>
                    <input id="porcentaje_adu<? print $datoadu2['idaduana']; ?>" name="porcentaje_adu<? print $datoadu2['idaduana']; ?>" class="tex2" value="<? if($datoadu['porcentaje']=='') print $datoadu2['porcentaje_venta']; else print $datoadu['porcentaje']; ?>" maxlength="50" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>">
                    <input type="hidden" id="u_porcentaje_adu<? print $datoadu2['idaduana']; ?>" name="u_porcentaje_adu<? print $datoadu2['idaduana']; ?>" value="" />
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<? $msg = 'Minimo compra: '.$datoadu2['minimo'].'<br>Margen: '.$datoadu2['margen_minimo']; ?>
                    <input id="minimo_adu<? print $datoadu2['idaduana']; ?>" name="minimo_adu<? print $datoadu2['idaduana']; ?>" class="tex2" value="<? if($datoadu['minimo']=='') print $datoadu2['minimo_venta']; else print $datoadu['minimo']; ?>" maxlength="50" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>">
                    <input type="hidden" id="u_minimo_adu<? print $datoadu2['idaduana']; ?>" name="u_minimo_adu<? print $datoadu2['idaduana']; ?>" value="" />
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datoadu2[moneda]", "monedas", "idmoneda", "codigo");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datoadu2['fecha_creacion'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datoadu2['fecha_validez'];?></td>                
				<td class="contenidotab" style="color:<? print $color; ?>"><? print $datoadu2['observaciones'];?></td>
            </tr>
            <?
        }
        ?>
        </table>
		<?
        $sqladu = "select * from cot_adu where idcot_temp='$_GET[idcot_temp]'";
        //print $sqlseg.'<br>';
        $exeadu = mysqli_query($link,$sqladu);
        $datoadu = mysqli_fetch_array($exeadu);					
        ?>
        
<table align="center">	
    <!--<tr>
    	<td class="contenidotab">Mostrar cotización de aduana <input id="mostrar_adu" name="mostrar_adu" type="checkbox" class="tex1" value="1" <? if($datoadu['mostrar']=='1') print 'checked'; ?> ></td>
    </tr>-->    
</table>
<table align="center">
    <tr>
        <td align="center" class="subtitseccion" style="font-size:11px">Descripci&oacute;n Aduana <? print strtoupper($_GET['cl']); ?></td>
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
            <textarea name="descripcion_adu" id="descripcion_adu" cols="100" rows="10"><? if($datoadu['descripcion']=='') print $cond['valor']; else print $datoadu['descripcion']; ?></textarea>
        </td>
    </tr>
</table>

    
</div>
<br>
<a href="javascript:void(0);" class="subtitseccion" onClick="showmed(divBodega)">Selecci&oacute;n de Bodega</a>
<div class="divCarga" id="divBodega">

<? include("search_bodega.php"); ?>

<table width="100%" align="center">
    <tr>
    	<td align="center" class="subtitseccion" style="font-size:11px">Condiciones generales</td>
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
	
	$sqlcb = "select * from cot_bodegas where idcot_temp='$_GET[idcot_temp]' limit 0,1";
	//print $sqlcb.'<br>';
	$execb = mysqli_query($link,$sqlcb);
	$datoscb= mysqli_fetch_array($execb);
	?>
    <tr>
    	<td align="center"><textarea name="condiciones_bg" id="condiciones_bg" cols="100" rows="10"><? if($datoscb['condiciones']=='') print $cond['valor']; else print $datoscb['condiciones']; ?></textarea>
    	</td>
    </tr>
</table>
   
</div>
<table>
	<tr>
        <td colspan="5" align="left">
            <table>
                <tr>
                	<? if(puedo("m","COTIZACION")==1 && $filasrn==0) { ?>
                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="recoger(document.formulario.naviera.value, document.formulario.origen.value, document.formulario.destination.value, document.formulario.aeropuerto_origen.value, '1'); recoger_otm(document.forms[0].filtro1.value, document.forms[0].filtro2.value, document.forms[0].filtro3.value, document.forms[0].filtro4.value, '1'); irAtras(formulario);">Atras</a></td>
                	<td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="recoger(document.formulario.naviera.value, document.formulario.origen.value, document.formulario.destination.value, document.formulario.aeropuerto_origen.value, '1'); recoger_otm(document.forms[0].filtro1.value, document.forms[0].filtro2.value, document.forms[0].filtro3.value, document.forms[0].filtro4.value, '1'); adicionaTarifas(formulario);">Siguente</a></td>
                    <? } ?>
                </tr>
            </table> 
        </td>        	
    </tr>
</table>
</form>
</body>   