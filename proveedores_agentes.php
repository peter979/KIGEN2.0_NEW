<?
	include('sesion/sesion.php');
	include("conection/conectar.php");
	include_once("permite.php");
	include_once("scripts/recover_nombre.php");

	$tabla = "proveedores_agentes";
	$llave = "idproveedor_agente";
	$tipo = $_GET['tipo'];
?>

<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/main.js"></script>
<script type="text/javascript" src="./js/shadowbox-base.js"></script>
<script type="text/javascript" src="./js/shadowbox.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.1.pack.js" ></script>
<script type="text/javascript" src="./js/jquery-1.8.3.js" ></script>

<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "condiciones_fletes",
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
	
	var x;
	x=$(document);
	x.ready(inicializarEventos);
	
	function inicializarEventos(){
		$(".numerico").keydown(numerico);//Valida campos numericos
	}
	
	function numerico(e) {
		//Permite unicamente campos numericos

	  if ((e.keyCode < 48 || e.keyCode > 57  ) && e.keyCode != 8){
		  e.preventDefault();
	  }
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
div.capa15
{
	display:none;
}
div.capa16
{
	display:none;
}
div.capa17
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
<? include("scripts/prepare_proveedores_list.php");?>
<script type="text/javascript" src="js/providers_list.js"></script>
<?php include('scripts/scripts.php'); ?>

<script language="javascript">
function validaEnvia(form)
{	
	//if (validarTexto('nombre', 'Por favor ingrese la razon social') == false) return false;
	//if (validarTexto('nit', 'Por favor ingrese el NIT') == false) return false;
	
	form.datosok.value="si";
	form.submit()
}

function validaBuscar(form)
{
	if (form.nombre.value == "")
	{
		alert('Digite la raz&oacute; social');
		form.nombre.focus();
		return false;
	}

	form.xyz.value = form.nombre.value;
	form.submit();
}

function eliminaActual(form)
{
	form.varelimi.value="si";
	form.submit()
}


function validadjunto(form, adjunto)
{
	form.adjuntoeli.value=adjunto;
	form.submit()
}

function validaPais(form)
{
	form.submit()
}

function borrar(form)
{
	document.location.href = 'proveedores_agentes.php?tipo=<? print $tipo ?>';
}

function showmed10()
{
	$('div[@class=capa10]').slideToggle("slow",function(){
		$('div[@class=capa11]').slideUp("slow");
		$('div[@class=capa12]').slideUp("slow");
		$('div[@class=capa13]').slideUp("slow");
		$('div[@class=capa131]').slideUp("slow");
		$('div[@class=capa14]').slideUp("slow");
		$('div[@class=capa15]').slideUp("slow");
		$('div[@class=capa16]').slideUp("slow");
		$('div[@class=capa17]').slideUp("slow");
	});
}
function showmed11()
{
	$('div[@class=capa11]').slideToggle("slow",function(){
		$('div[@class=capa10]').slideUp("slow");
		$('div[@class=capa12]').slideUp("slow");
		$('div[@class=capa13]').slideUp("slow");
		$('div[@class=capa131]').slideUp("slow");
		$('div[@class=capa14]').slideUp("slow");
		$('div[@class=capa15]').slideUp("slow");
		$('div[@class=capa16]').slideUp("slow");
		$('div[@class=capa17]').slideUp("slow");
	});
}
function showmed12()
{
	$('div[@class=capa12]').slideToggle("slow",function(){
		$('div[@class=capa10]').slideUp("slow");
		$('div[@class=capa11]').slideUp("slow");
		$('div[@class=capa13]').slideUp("slow");
		$('div[@class=capa131]').slideUp("slow");
		$('div[@class=capa14]').slideUp("slow");
		$('div[@class=capa15]').slideUp("slow");
		$('div[@class=capa16]').slideUp("slow");
		$('div[@class=capa17]').slideUp("slow");
	});
}
function showmed13()
{
	$('div[@class=capa13]').slideToggle("slow",function(){
		$('div[@class=capa10]').slideUp("slow");
		$('div[@class=capa11]').slideUp("slow");
		$('div[@class=capa12]').slideUp("slow");
		$('div[@class=capa131]').slideUp("slow");
		$('div[@class=capa14]').slideUp("slow");
		$('div[@class=capa15]').slideUp("slow");
		$('div[@class=capa16]').slideUp("slow");
		$('div[@class=capa17]').slideUp("slow");
	});
}
function showmed131()
{
	$('div[@class=capa131]').slideToggle("slow",function(){
		$('div[@class=capa10]').slideUp("slow");
		$('div[@class=capa11]').slideUp("slow");
		$('div[@class=capa12]').slideUp("slow");
		$('div[@class=capa13]').slideUp("slow");
		$('div[@class=capa14]').slideUp("slow");
		$('div[@class=capa15]').slideUp("slow");
		$('div[@class=capa16]').slideUp("slow");
		$('div[@class=capa17]').slideUp("slow");
	});
}
function showmed14()
{
	$('div[@class=capa14]').slideToggle("slow",function(){
		$('div[@class=capa10]').slideUp("slow");
		$('div[@class=capa11]').slideUp("slow");
		$('div[@class=capa12]').slideUp("slow");
		$('div[@class=capa13]').slideUp("slow");
		$('div[@class=capa131]').slideUp("slow");
		$('div[@class=capa15]').slideUp("slow");
		$('div[@class=capa16]').slideUp("slow");
		$('div[@class=capa17]').slideUp("slow");
	});
}
function showmed15()
{
	$('div[@class=capa15]').slideToggle("slow",function(){
		$('div[@class=capa10]').slideUp("slow");
		$('div[@class=capa11]').slideUp("slow");
		$('div[@class=capa12]').slideUp("slow");
		$('div[@class=capa13]').slideUp("slow");
		$('div[@class=capa131]').slideUp("slow");
		$('div[@class=capa14]').slideUp("slow");
		$('div[@class=capa16]').slideUp("slow");
		$('div[@class=capa17]').slideUp("slow");
	});
}
function showmed16()
{
	$('div[@class=capa16]').slideToggle("slow",function(){
		$('div[@class=capa10]').slideUp("slow");
		$('div[@class=capa11]').slideUp("slow");
		$('div[@class=capa12]').slideUp("slow");
		$('div[@class=capa13]').slideUp("slow");
		$('div[@class=capa131]').slideUp("slow");
		$('div[@class=capa14]').slideUp("slow");
		$('div[@class=capa15]').slideUp("slow");
		$('div[@class=capa17]').slideUp("slow");
	});
}
function showmed17()
{
	$('div[@class=capa17]').slideToggle("slow",function(){
		$('div[@class=capa10]').slideUp("slow");
		$('div[@class=capa11]').slideUp("slow");
		$('div[@class=capa12]').slideUp("slow");
		$('div[@class=capa13]').slideUp("slow");
		$('div[@class=capa131]').slideUp("slow");
		$('div[@class=capa14]').slideUp("slow");
		$('div[@class=capa15]').slideUp("slow");
		$('div[@class=capa16]').slideUp("slow");
	});
}

function calculaTotal(form)
{
	form.nueRegistro.value = 'si';
	form.submit()
}

function limpiar(tipo, cad_rg, idnaviera)
{
	//alert('tipo ' + tipo + ' cad_rg ' + cad_rg + ' idnaviera ' + idnaviera);
	var idrgs = cad_rg.split(','); 	
	for(var i =0; i < idrgs.length; i++)
	{
		var limpia_checks = 'document.formulario.recargo'+idrgs[i]+'.checked=false';
		//alert (limpia_checks);
		eval(limpia_checks);
	}	
	if(tipo == 'cont')
	{
		var campo_gasto = 'valor_gastos_cont';
	}
	if(tipo == 'hbl')
	{
		var campo_gasto = 'valor_gastos_hbl';		
	}
	if(tipo == 'wm')
	{
		var campo_gasto = 'valor_gastos_wm';
	}
	if(tipo == 'hawb')
	{
		var campo_gasto = 'valor_gastos_hawb';
	}
	if(tipo == 'embarque')
	{
		var campo_gasto = 'valor_gastos_embarque';
	}
	var limpia_suma = "document.formulario."+campo_gasto+idnaviera+".value = '0'";	
	//alert(limpia_suma);
	eval(limpia_suma);		
}

function addi_origen(a,b,c, clasif)
{
	//alert(c);
	var contr='document.formulario.'+b+'.checked';
	if(c == 'cont')
	{
		var campo_gasto = 'valor_gastos_cont' + clasif;
		/*if(document.formulario.valor_gastos_cont.value == '')
		{
			document.formulario.valor_gastos_cont.value = '0';
		}
		var digi=parseInt(document.formulario.valor_gastos_cont.value)*/
	}
	if(c == 'hbl')
	{
		var campo_gasto = 'valor_gastos_hbl' + clasif;
		
		/*if(document.formulario.valor_gastos_hbl.value == '')
		{
			document.formulario.valor_gastos_hbl.value = '0';
		}
		var digi=parseInt(document.formulario.valor_gastos_hbl.value)*/
	}
	if(c == 'wm')
	{
		var campo_gasto = 'valor_gastos_wm' + clasif;
		/*if(document.formulario.valor_gastos_wm.value == '')
		{
			document.formulario.valor_gastos_wm.value = '0';
		}
		var digi=parseInt(document.formulario.valor_gastos_wm.value)*/
	}
	if(c == 'hawb')
	{
		var campo_gasto = 'valor_gastos_hawb' + clasif;
		/*if(document.formulario.valor_gastos_hawb.value == '')
		{
			document.formulario.valor_gastos_hawb.value = '0';
		}
		var digi=parseInt(document.formulario.valor_gastos_hawb.value)*/
	}
	if(c == 'embarque')
	{
		var campo_gasto = 'valor_gastos_embarque' + clasif;
		/*if(document.formulario.valor_gastos_embarque.value == '')
		{
			document.formulario.valor_gastos_embarque.value = '0';
		}
		var digi=parseInt(document.formulario.valor_gastos_embarque.value)*/
	}
	
	//alert ('digi '+digi+' cont '+document.formulario.valor_gastos_cont.value+' hbl '+document.formulario.valor_gastos_hbl.value+' wm '+document.formulario.valor_gastos_wm.value+' a '+a);
	var si = "document.formulario."+campo_gasto+".value == ''";
	var entonces = "document.formulario."+campo_gasto+".value = '0'";
	var asignacion = "var digi=parseInt(document.formulario."+campo_gasto+".value)";
	
	if(eval(si)==true)
	{
		eval(entonces);
	}	
	eval(asignacion);
	
	if(eval(contr)==true)
	{
		var adicion = 'document.formulario.'+campo_gasto+'.value=(parseInt(digi)+parseInt(a))';
	}
	else
	{
		var adicion = 'document.formulario.'+campo_gasto+'.value=(parseInt(digi)-parseInt(a))';
	}
	eval(adicion);
}

function addi(a,b,c,d,e)
{
	var variablevar = 'val=document.formulario.valor_venta'+a+'.value';
	eval(variablevar);
	
	if(e == 'lcl')
	{
		var variablemin = 'mini=document.formulario.minimo_venta'+a+'.value';
		eval (variablemin);
	}
	
	var contr='document.formulario.'+b+'.checked';
	if(c == 'cont')
	{
		var campo_gasto = 'valor_gastos_cont';
	}
	if(c == 'hbl')
	{
		var campo_gasto = 'valor_gastos_hbl';		
	}
	if(c == 'wm')
	{
		var campo_gasto = 'valor_gastos_wm';
	}
	if(c == 'hawb')
	{
		var campo_gasto = 'valor_gastos_hawb';
	}
	if(c == 'embarque')
	{
		var campo_gasto = 'valor_gastos_embarque';
	}
	
	var si = "document.formulario."+campo_gasto+d+".value == ''";
	var entonces = "document.formulario."+campo_gasto+d+".value = '0'";
	var asignacion = "var digi=parseInt(document.formulario."+campo_gasto+d+".value)";
	
	if(eval(si)==true)
	{
		eval(entonces);
	}	
	eval(asignacion);
	
	if(e == 'lcl')
	{	
		var si_min = "document.formulario."+campo_gasto+'_min'+d+".value == ''";
		var entonces_min = "document.formulario."+campo_gasto+'_min'+d+".value = '0'";
		var asignacion_min = "var digi_min=parseInt(document.formulario."+campo_gasto+'_min'+d+".value)";
		
		if(eval(si_min)==true)
		{
			eval(entonces_min);
		}	
		eval(asignacion_min);
	
		var si_min5 = "document.formulario."+campo_gasto+'_min5'+d+".value == ''";
		var entonces_min5 = "document.formulario."+campo_gasto+'_min5'+d+".value = '0'";
		var asignacion_min5 = "var digi_min5=parseInt(document.formulario."+campo_gasto+'_min5'+d+".value)";
		
		if(eval(si_min5)==true)
		{
			eval(entonces_min5);
		}	
		eval(asignacion_min5);
		
		var si_min10 = "document.formulario."+campo_gasto+'_min10'+d+".value == ''";
		var entonces_min10 = "document.formulario."+campo_gasto+'_min10'+d+".value = '0'";
		var asignacion_min10 = "var digi_min10=parseInt(document.formulario."+campo_gasto+'_min10'+d+".value)";
		
		if(eval(si_min10)==true)
		{
			eval(entonces_min10);
		}	
		eval(asignacion_min10);
		
		var si_min15 = "document.formulario."+campo_gasto+'_min15'+d+".value == ''";
		var entonces_min15 = "document.formulario."+campo_gasto+'_min15'+d+".value = '0'";
		var asignacion_min15 = "var digi_min15=parseInt(document.formulario."+campo_gasto+'_min15'+d+".value)";
		
		if(eval(si_min15)==true)
		{
			eval(entonces_min15);
		}	
		eval(asignacion_min15);
	}
	
	if(eval(contr)==true)
	{
		var adicion = 'document.formulario.'+campo_gasto+d+'.value=(parseInt(digi)+parseInt(val))';
		
		if(e == 'lcl')
		{
			var adicion_min = 'document.formulario.'+campo_gasto+'_min'+d+'.value=(parseInt(digi_min)+parseInt(mini))';		
			var adicion_min5 = 'document.formulario.'+campo_gasto+'_min5'+d+'.value=(parseInt(digi_min5)+(parseInt(val)*5))';
			var adicion_min10 = 'document.formulario.'+campo_gasto+'_min10'+d+'.value=(parseInt(digi_min10)+(parseInt(val)*10))';
			var adicion_min15 = 'document.formulario.'+campo_gasto+'_min15'+d+'.value=(parseInt(digi_min15)+(parseInt(val)*15))';
		}
	}
	else
	{
		var adicion = 'document.formulario.'+campo_gasto+d+'.value=(parseInt(digi)-parseInt(val))';
		
		if(e == 'lcl')
		{
			var adicion_min = 'document.formulario.'+campo_gasto+'_min'+d+'.value=(parseInt(digi_min)-parseInt(mini))';		
			var adicion_min5 = 'document.formulario.'+campo_gasto+'_min5'+d+'.value=(parseInt(digi_min5)-(parseInt(val)*5))';
			var adicion_min10 = 'document.formulario.'+campo_gasto+'_min10'+d+'.value=(parseInt(digi_min10)-(parseInt(val)*10))';
			var adicion_min15 = 'document.formulario.'+campo_gasto+'_min15'+d+'.value=(parseInt(digi_min15)-(parseInt(val)*15))';
		}
	}
	
	eval(adicion);
	
	if(e == 'lcl')
	{
		eval(adicion_min);	
		eval(adicion_min5);
		eval(adicion_min10);
		eval(adicion_min15);
	}
	/*var si_result = "document.formulario."+campo_gasto+d+".value < 0";
	var entonces_result = "document.formulario."+campo_gasto+d+".value = '0'";

	if(eval(si_result)==true)
	{
		eval(entonces_result);
	}*/
}
</script>
</head>

<?
if($_POST['adjuntoeli']!='')
{
	$sql= "delete from adjuntos_proveedores where idadjunto='$_POST[adjuntoeli]'";
	//print $sql.'<br>'; 
	$exe= mysqli_query($link,$sql);
}

if($_POST['datosok']=='si')
{
	if(!isset($_POST['idproveedor_agente']) || $_POST['idproveedor_agente'] == '')
	{
		$queryins="INSERT INTO $tabla (
						nombre_patio, 
						idciudad, 
						tipo, 
						nombre,
						alias, 
						nit, 
						direccion, 
						telefonos, 
						email_empresarial, 
						info_bancaria, 
						sucursal, 
						agente_linea, 
						operador_cont, 
						val20,
						val40,
						val40Hq,
						pagina_web, 
						patios_cont, 
						corte_hbl, 
						docs_requeridos, 
						restricciones, 
						dir_bodega, 
						sitios_operacion, 
						sobregiro, 
						observaciones, 
						condiciones_fletes
					) VALUES(
						'$_POST[nombre_patio]', 
						'$_POST[idciudad]', 
						'$tipo', 
						UCASE('$_POST[nombre]'), 
						UCASE('$_POST[alias]'), 
						UCASE('$_POST[nit]'), 
						UCASE('$_POST[direccion]'), 
						UCASE('$_POST[telefonos]'),
						UCASE('$_POST[email_empresarial]'), 
						UCASE('$_POST[info_bancaria]'), 
						UCASE('$_POST[sucursal]'), 
						UCASE('$_POST[agente_linea]'), 
						UCASE('$_POST[operador_cont]'), 
						'$_POST[val20]',
						'$_POST[val40]',
						'$_POST[val40Hq]',
						UCASE('$_POST[pagina_web]'), 
						'$_POST[patios_cont]', 
						UCASE('$_POST[corte_hbl]'),  
						UCASE('$_POST[docs_requeridos]'), 
						UCASE('$_POST[restricciones]'), 
						UCASE('$_POST[dir_bodega]'), 
						UCASE('$_POST[sitios_operacion]'), 
						UCASE('$_POST[sobregiro]'), 
						UCASE('$_POST[observaciones]'), 
						'$_POST[condiciones_fletes]'
					)";
		//print $queryins;
		$buscarins_ppal=mysqli_query($link,$queryins);
		
		
		$sqlast = "SELECT LAST_INSERT_ID() ultimo FROM $tabla";	
		$querylast = mysqli_query($link,$sqlast);		
		$row = mysqli_fetch_array($querylast);
		$idproveedor_agente = $row['ultimo'];
		
		if(!$buscarins_ppal){
			print ("<script>alert('No se pudo ingresar el registro')</script>");

		}else
		{
		//	if ($mueve = move_uploaded_file($_FILES['adjunto']['tmp_name'], "adjuntos_proveedores/".$_FILES['adjunto']['name']))
		    if ($mueve = move_uploaded_file($_FILES['adjunto']['tmp_name'], "doc/doc_proveedores/".$_FILES['adjunto']['name']))
			{
				$nombre = $_FILES['adjunto']['name'];
				$sql = "INSERT INTO adjuntos_proveedores (idproveedor, idusuario, nombre, fecha_creacion, descripcion) VALUES ('$idproveedor_agente', '$_SESSION[numberid]', '$nombre', NOW(), '$_POST[descripcion_adjunto]')";
				//print $sql.'<br>';
				$query = mysqli_query($link,$sql);
			}
			
			$sqlcond = "INSERT INTO condiciones_especiales (idproveedor_agente, credito, cupo_max, liberacion_auto) VALUES('$idproveedor_agente', UCASE('$_POST[credito]'), UCASE('$_POST[cupo_max]'), '$_POST[liberacion_auto]')";
			//print $sqlcond.'<br>';
			$execond = mysqli_query($link,$sqlcond);
			
			if($tipo=='coloader')
			{
				$idcoloader = $idproveedor_agente;
//Ingreso de recargos origen-----------------------------------------------------------------------------------------------------------------
			for($k=0; $k < 3; $k++)
			{
				if($k == 0)
					$clasif = 'fcl';
				if($k == 1)	
					$clasif = 'lcl';
				if($k == 2)	
					$clasif = 'aereo';	
					
				$sqlct="select * from coloader_origen where idcoloader='$idcoloader' and clasificacion='$clasif'";
				//print $sqlct.'<br>';
				$exect =mysqli_query($link,$sqlct);
				$filasct = mysqli_num_rows($exect);
				
				if($filasct == 0)//if($_POST['modRegistro']=="no")
				{
					$nombre_gastos_hbl = $_POST['nombre_gastos_hbl'.$clasif];
					$nombre_gastos_cont = $_POST['nombre_gastos_cont'.$clasif];
					$nombre_gastos_wm = $_POST['nombre_gastos_wm'.$clasif];
					$nombre_gastos_hawb = $_POST['nombre_gastos_hawb'.$clasif];
					$nombre_gastos_embarque = $_POST['nombre_gastos_embarque'.$clasif];					
					$valor_gastos_hbl = $_POST['valor_gastos_hbl'.$clasif];
					$valor_gastos_cont = $_POST['valor_gastos_cont'.$clasif];
					$valor_gastos_wm = $_POST['valor_gastos_wm'.$clasif];
					$valor_gastos_hawb = $_POST['valor_gastos_hawb'.$clasif];
					$valor_gastos_embarque = $_POST['valor_gastos_embarque'.$clasif];
					
					$queryins="INSERT INTO coloader_origen (idcoloader, clasificacion, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, nombre_gastos_hawb, nombre_gastos_embarque, valor_gastos_hbl, valor_gastos_cont, valor_gastos_wm, valor_gastos_hawb, valor_gastos_embarque, observaciones) VALUES ('$idcoloader', '$clasif', UCASE('$nombre_gastos_hbl'), UCASE('$nombre_gastos_cont'), UCASE('$nombre_gastos_wm'), UCASE('$nombre_gastos_hawb'), UCASE('$nombre_gastos_embarque'), UCASE('$valor_gastos_hbl'), UCASE('$valor_gastos_cont'), UCASE('$valor_gastos_wm'), UCASE('$valor_gastos_hawb'), UCASE('$valor_gastos_embarque'), UCASE('$_POST[observaciones]'))";
					//print $queryins.'<br>';
					$buscarins=mysqli_query($link,$queryins);
					
					$sqlast = "SELECT LAST_INSERT_ID() ultimo FROM coloader_origen";	
					$querylast = mysqli_query($link,$sqlast);		
					$row = mysqli_fetch_array($querylast);
					$idcoloader_origen = $row['ultimo'];
					
					if($buscarins)
					{
						$sqlrg = "select * from recargos_origen where clasificacion='$clasif'";
						//print $sqlrg .'<br>';
						$exerg = mysqli_query($link,$sqlrg);
						while($datosrg = mysqli_fetch_array($exerg))
						{
							$idrecargo = $_POST['recargo_origen'.$datosrg['idrecargo_origen']];
							if($idrecargo!='')
							{
								$sql="INSERT INTO origen_por_coloader (idrecargo_origen, idcoloader_origen) VALUES ('$datosrg[idrecargo_origen]', '$idcoloader_origen')";
								//print $sql.'<br>';  
								$exe= mysqli_query($link,$sql);
							}
						}
					}
				}
				elseif($filasct > 0)
				{
					$exect = mysqli_query($link,$sqlct);
					$datosct = mysqli_fetch_array($exect);
					$idcoloader_origen = $datosct['idcoloader_origen'];
					
					$nombre_gastos_hbl = $_POST['nombre_gastos_hbl'.$clasif];
					$nombre_gastos_cont = $_POST['nombre_gastos_cont'.$clasif];
					$nombre_gastos_wm = $_POST['nombre_gastos_wm'.$clasif];
					$nombre_gastos_hawb = $_POST['nombre_gastos_hawb'.$clasif];
					$nombre_gastos_embarque = $_POST['nombre_gastos_embarque'.$clasif];					
					$valor_gastos_hbl = $_POST['valor_gastos_hbl'.$clasif];
					$valor_gastos_cont = $_POST['valor_gastos_cont'.$clasif];
					$valor_gastos_wm = $_POST['valor_gastos_wm'.$clasif];
					$valor_gastos_hawb = $_POST['valor_gastos_hawb'.$clasif];
					$valor_gastos_embarque = $_POST['valor_gastos_embarque'.$clasif];
					
					$queryins = "UPDATE coloader_origen SET 
									nombre_gastos_hbl=UCASE('$nombre_gastos_hbl'), 
									nombre_gastos_wm=UCASE('$nombre_gastos_wm'), 
									nombre_gastos_hawb=UCASE('$nombre_gastos_hawb'), 
									nombre_gastos_embarque=UCASE('$nombre_gastos_embarque'), 
									valor_gastos_hbl=UCASE('$valor_gastos_hbl'), 
									valor_gastos_cont=UCASE('$valor_gastos_cont'), 
									valor_gastos_wm=UCASE('$valor_gastos_wm'), 
									valor_gastos_hawb=UCASE('$valor_gastos_hawb'), 
									valor_gastos_embarque=UCASE('$valor_gastos_embarque'), 
									observaciones=UCASE('$_POST[observaciones]') 
								WHERE idcoloader_origen='$idcoloader_origen' and clasificacion='$clasif'";
					//print $queryins.'<br>';
					$buscarins=mysqli_query($link,$queryins);
					
					if($buscarins)
					{
						$sql= "delete from origen_por_coloader where idcoloader_origen='$idcoloader_origen'";
						print $sql.'<br>'; 
						$exe= mysqli_query($link,$sql);
						
						$sqlrg = "select * from recargos_origen where clasificacion='$clasif'";
						//print $sqlrg .'<br>';
						$exerg = mysqli_query($link,$sqlrg);
						while($datosrg = mysqli_fetch_array($exerg))
						{
							$idrecargo = $_POST['recargo_origen'.$datosrg['idrecargo_origen']];
							if($idrecargo!='')
							{
								$sql="INSERT INTO origen_por_coloader (idrecargo_origen, idcoloader_origen) VALUES ('$datosrg[idrecargo_origen]', '$idcoloader_origen')";
								//print $sql.'<br>';  
								$exe= mysqli_query($link,$sql);
							}
						}
					}
				}
			}

//Ingreso de recargos local-----------------------------------------------------------------------------------------------------------------
			for($k=0; $k < 3; $k++)
			{
				if($k == 0)
					$clasif = 'fcl';
				if($k == 1)	
					$clasif = 'lcl';
				if($k == 2)	
					$clasif = 'aereo';
			
				$sqlct="select * from coloader_local where idcoloader='$idcoloader'";
				//print $sqlct.'<br>';
				$exect =mysqli_query($link,$sqlct);
				$filasct = mysqli_num_rows($exect);
			
				if($filasct == 0)//if($_POST['modRegistro']=="no")
				{
					$queryins="INSERT INTO coloader_local (idcoloader, clasificacion, observaciones) VALUES ('$idcoloader', '$clasif', UCASE('$_POST[observaciones]'))";
					//print $queryins.'<br>';
					$buscarins=mysqli_query($link,$queryins);
					
					$sqlast = "SELECT LAST_INSERT_ID() ultimo FROM coloader_local";	
					$querylast = mysqli_query($link,$sqlast);		
					$row = mysqli_fetch_array($querylast);
					$idcoloader_local = $row['ultimo'];
					
					if($clasif=='fcl')
					{
						$tipo2 = 'tipo';
						$idtipo = 'idtipo';
					}
					elseif($clasif=='lcl')
					{
						$tipo2 = 'tipo_lcl';
						$idtipo = 'idtipo_lcl';
					}
					
					$sqlidt = "select distinct idtarifario from tarifario where clasificacion='$clasif'";
					if($clasif=='aereo')
						$sqlidt = "select distinct idtarifario_aereo as idtarifario from tarifario_aereo";
					//print $sqlidt .'<br>';
					$exeidt = mysqli_query($link,$sqlidt);
					
					$cad_idtar = '';
					while($datosidt = mysqli_fetch_array($exeidt))
					{
						if($cad_idtar != '')
							$cad_idtar .= ',';
						$cad_idtar .= " '".$datosidt['idtarifario'] ."'";		
					}
					if($cad_idtar == '')//si esta vacio adiciona el id cero
						$cad_idtar = "'0'";
					
					$sqlnav = "select distinct idnaviera from tarifario where idtarifario in ($cad_idtar)";
					if($clasif=='aereo')
						$sqlnav = "select distinct idaerolinea as idnaviera from tarifario_aereo where idtarifario_aereo in ($cad_idtar)";
					//print $sqlnav .'<br>';
					$exenav = mysqli_query($link,$sqlnav);
							
					while($datosnav = mysqli_fetch_array($exenav))
					{	
						$sqlrg = "select * from recargos_local where clasificacion='$clasif' and idnaviera='$datosnav[idnaviera]'";
						//print $sqlrg .'<br>';
						$exerg = mysqli_query($link,$sqlrg);
						$filasrg = mysqli_num_rows($exerg);
						
						if($filasrg > 0)
						{
							$nombre_gastos_hbl = $_POST['nombre_gastos_hbl'.$datosnav['idnaviera']];
							$nombre_gastos_cont = $_POST['nombre_gastos_cont'.$datosnav['idnaviera']];
							$nombre_gastos_wm = $_POST['nombre_gastos_wm'.$datosnav['idnaviera']];
							$nombre_gastos_hawb = $_POST['nombre_gastos_hawb'.$datosnav['idnaviera']];
							$nombre_gastos_embarque = $_POST['nombre_gastos_embarque'.$datosnav['idnaviera']];
							
							$valor_gastos_hbl = $_POST['valor_gastos_hbl'.$datosnav['idnaviera']];
							$valor_gastos_cont =  $_POST['valor_gastos_cont'.$datosnav['idnaviera']];
							$valor_gastos_wm =  $_POST['valor_gastos_wm'.$datosnav['idnaviera']];
							$valor_gastos_hawb =  $_POST['valor_gastos_hawb'.$datosnav['idnaviera']];
							$valor_gastos_embarque =  $_POST['valor_gastos_embarque'.$datosnav['idnaviera']];
							
							$mostrar_var = $_POST['mostrar_var'.$datosnav['idnaviera']];
							$collection_fee = $_POST['collection_fee'.$datosnav['idnaviera']];
							$min_collection_fee = $_POST['min_collection_fee'.$datosnav['idnaviera']];
							$caf = $_POST['caf'.$datosnav['idnaviera']]; 
							$min_caf = $_POST['min_caf'.$datosnav['idnaviera']];				
							$mostrar_collection_fee = $_POST['mostrar_collection_fee'.$datosnav['idnaviera']];
							$mostrar_caf = $_POST['mostrar_caf'.$datosnav['idnaviera']];
							$mostrar_referencia = $_POST['mostrar_referencia'.$datosnav['idnaviera']];
							
							if($clasif=='fcl' || $clasif=='aereo')
							{
								$queryins2="INSERT INTO totales_coloader_local (idnaviera, idcoloader_local, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, valor_gastos_hbl,valor_gastos_cont, valor_gastos_wm, mostrar_var, collection_fee, min_collection_fee, caf, min_caf, mostrar_collection_fee, mostrar_caf, mostrar_referencia, nombre_gastos_hawb, nombre_gastos_embarque, valor_gastos_hawb, valor_gastos_embarque) VALUES ('$datosnav[idnaviera]', '$idcoloader_local', UCASE('$nombre_gastos_hbl'), UCASE('$nombre_gastos_cont'), UCASE('$nombre_gastos_wm'), UCASE('$valor_gastos_hbl'), UCASE('$valor_gastos_cont'), UCASE('$valor_gastos_wm'), '$mostrar_var', UCASE('$collection_fee'), UCASE('$min_collection_fee'), UCASE('$caf'), UCASE('$min_caf'), UCASE('$mostrar_collection_fee'), UCASE('$mostrar_caf'), UCASE('$mostrar_referencia'), UCASE('$nombre_gastos_hawb'), UCASE('$nombre_gastos_embarque'), UCASE('$valor_gastos_hawb'), UCASE('$valor_gastos_embarque'))";
							}
							
							if($clasif=='lcl')
							{
								$valor_gastos_hbl_min = $_POST['valor_gastos_hbl_min'.$datosnav['idnaviera']];
								$valor_gastos_hbl_min5 = $_POST['valor_gastos_hbl_min5'.$datosnav['idnaviera']];
								$valor_gastos_hbl_min10 = $_POST['valor_gastos_hbl_min10'.$datosnav['idnaviera']];
								$valor_gastos_hbl_min15 = $_POST['valor_gastos_hbl_min15'.$datosnav['idnaviera']];
								$valor_gastos_wm_min =  $_POST['valor_gastos_wm_min'.$datosnav['idnaviera']];
								$valor_gastos_wm_min5 =  $_POST['valor_gastos_wm_min5'.$datosnav['idnaviera']];
								$valor_gastos_wm_min10 =  $_POST['valor_gastos_wm_min10'.$datosnav['idnaviera']];
								$valor_gastos_wm_min15 =  $_POST['valor_gastos_wm_min15'.$datosnav['idnaviera']];
								$mostrar_rangos =  $_POST['mostrar_rangos'.$datosnav['idnaviera']];
											
								$queryins2="INSERT INTO totales_coloader_local (idnaviera, idcoloader_local, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, valor_gastos_hbl,valor_gastos_hbl_min, valor_gastos_hbl_min5, valor_gastos_hbl_min10, valor_gastos_hbl_min15, valor_gastos_cont, valor_gastos_wm, valor_gastos_wm_min, valor_gastos_wm_min5, valor_gastos_wm_min10, valor_gastos_wm_min15, mostrar_var, collection_fee, min_collection_fee, caf, min_caf, mostrar_collection_fee, mostrar_caf, mostrar_rangos, mostrar_referencia, nombre_gastos_hawb, nombre_gastos_embarque, valor_gastos_hawb, valor_gastos_embarque) VALUES ('$datosnav[idnaviera]', '$idcoloader_local', UCASE('$nombre_gastos_hbl'), UCASE('$nombre_gastos_cont'), UCASE('$nombre_gastos_wm'), UCASE('$valor_gastos_hbl'), UCASE('$valor_gastos_hbl_min'), UCASE('$valor_gastos_hbl_min5'), UCASE('$valor_gastos_hbl_min10'), UCASE('$valor_gastos_hbl_min15'), UCASE('$valor_gastos_cont'), UCASE('$valor_gastos_wm'), UCASE('$valor_gastos_wm_min'), UCASE('$valor_gastos_wm_min5'), UCASE('$valor_gastos_wm_min10'), UCASE('$valor_gastos_wm_min15'), '$mostrar_var', UCASE('$collection_fee'), UCASE('$min_collection_fee'), UCASE('$caf'), UCASE('$min_caf'), UCASE('$mostrar_collection_fee'), UCASE('$mostrar_caf'), UCASE('$mostrar_rangos'), UCASE('$mostrar_referencia'), UCASE('$nombre_gastos_hawb'), UCASE('$nombre_gastos_embarque'), UCASE('$valor_gastos_hawb'), UCASE('$valor_gastos_embarque'))";
							}
							//print $queryins2.'<br>';
							$buscarins2=mysqli_query($link,$queryins2);
						}
					}
					if($buscarins)
					{
						$sqlrg = "select * from recargos_local where clasificacion='$clasif'";
						//print $sqlrg .'<br>';
						$exerg = mysqli_query($link,$sqlrg);
						while($datosrg = mysqli_fetch_array($exerg))
						{
							$idrecargo = $_POST['recargo'.$datosrg['idrecargo_local']];
							$valor_venta = $_POST['valor_venta'.$datosrg['idrecargo_local']];
							$minimo_venta = $_POST['minimo_venta'.$datosrg['idrecargo_local']];
							
							if($idrecargo!='')
							{
								$sql="INSERT INTO local_por_coloader (idrecargo_local, idcoloader, valor_venta, minimo_venta) VALUES ('$datosrg[idrecargo_local]', '$idcoloader', '$valor_venta', '$minimo_venta')";
								//print $sql.'<br>';  
								$exe= mysqli_query($link,$sql);
							}
						}
					}
				}
				elseif($filasct > 0)
				{
					$exect = mysqli_query($link,$sqlct);
					$datosct = mysqli_fetch_array($exect);
					$idcoloader_local = $datosct['idcoloader_local'];
					
					$queryins = "UPDATE coloader_local SET observaciones=UCASE('$_POST[observaciones]') WHERE idcoloader='$idcoloader'";
					//print $queryins.'<br>';
					$buscarins=mysqli_query($link,$queryins);
					
					if($clasif=='fcl')
					{
						$tipo2 = 'tipo';
						$idtipo = 'idtipo';
					}
					elseif($clasif=='lcl')
					{
						$tipo2 = 'tipo_lcl';
						$idtipo = 'idtipo_lcl';
					}
					$sqlidt = "select distinct idtarifario from tarifario where clasificacion='$clasif'";
					if($clasif=='aereo')
						$sqlidt = "select distinct idtarifario_aereo as idtarifario from tarifario_aereo";
					//print $sqlidt .'<br>';
					$exeidt = mysqli_query($link,$sqlidt);
					
					$cad_idtar = '';
					while($datosidt = mysqli_fetch_array($exeidt))
					{
						if($cad_idtar != '')
							$cad_idtar .= ',';
						$cad_idtar .= " '".$datosidt['idtarifario'] ."'";		
					}
					if($cad_idtar == '')//si esta vacio adiciona el id cero
						$cad_idtar = "'0'";
					
					$sqlnav = "select distinct idnaviera from tarifario where idtarifario in ($cad_idtar)";
					if($clasif=='aereo')
						$sqlnav = "select distinct idaerolinea as idnaviera from tarifario_aereo where idtarifario_aereo in ($cad_idtar)";
					//print $sqlnav .'<br>';
					$exenav = mysqli_query($link,$sqlnav);
							
					while($datosnav = mysqli_fetch_array($exenav))
					{	
						$sqlrg = "select * from recargos_local where clasificacion='$clasif' and idnaviera='$datosnav[idnaviera]'";
						//print $sqlrg .'<br>';
						$exerg = mysqli_query($link,$sqlrg);
						$filasrg = mysqli_num_rows($exerg);
						
						if($filasrg > 0)
						{
							$nombre_gastos_hbl = $_POST['nombre_gastos_hbl'.$datosnav['idnaviera']];
							$nombre_gastos_cont = $_POST['nombre_gastos_cont'.$datosnav['idnaviera']];
							$nombre_gastos_wm = $_POST['nombre_gastos_wm'.$datosnav['idnaviera']];
							$nombre_gastos_hawb = $_POST['nombre_gastos_hawb'.$datosnav['idnaviera']];
							$nombre_gastos_embarque = $_POST['nombre_gastos_embarque'.$datosnav['idnaviera']];
							
							$valor_gastos_hbl = $_POST['valor_gastos_hbl'.$datosnav['idnaviera']];
							$valor_gastos_cont =  $_POST['valor_gastos_cont'.$datosnav['idnaviera']];
							$valor_gastos_wm =  $_POST['valor_gastos_wm'.$datosnav['idnaviera']];
							$valor_gastos_hawb =  $_POST['valor_gastos_hawb'.$datosnav['idnaviera']];
							$valor_gastos_embarque =  $_POST['valor_gastos_embarque'.$datosnav['idnaviera']];
							
							$mostrar_var = $_POST['mostrar_var'.$datosnav['idnaviera']];
							$collection_fee = $_POST['collection_fee'.$datosnav['idnaviera']];
							$min_collection_fee = $_POST['min_collection_fee'.$datosnav['idnaviera']];
							$caf = $_POST['caf'.$datosnav['idnaviera']]; 
							$min_caf = $_POST['min_caf'.$datosnav['idnaviera']];
							$mostrar_collection_fee = $_POST['mostrar_collection_fee'.$datosnav['idnaviera']];
							$mostrar_caf = $_POST['mostrar_caf'.$datosnav['idnaviera']];
							$mostrar_referencia = $_POST['mostrar_referencia'.$datosnav['idnaviera']];
							
							$sqlct2 = "select * from totales_coloader_local where idnaviera='$datosnav[idnaviera]' and idcoloader_local='$idcoloader_local'";
							//print $sqlct2.'<br>';
							$exect2 = mysqli_query($link,$sqlct2);
							$filasct2 = mysqli_num_rows($exect2);
							
							if($filasct2 > 0)
							{
								if($clasif=='fcl' || $clasif=='aereo')
								{
									$queryins2="UPDATE totales_coloader_local SET nombre_gastos_hbl=UCASE('$nombre_gastos_hbl'), nombre_gastos_cont=UCASE('$nombre_gastos_cont'), nombre_gastos_wm=UCASE('$nombre_gastos_wm'), valor_gastos_hbl=UCASE('$valor_gastos_hbl'), valor_gastos_cont=UCASE('$valor_gastos_cont'), valor_gastos_wm=UCASE('$valor_gastos_wm'), mostrar_var='$mostrar_var', collection_fee=UCASE('$collection_fee'), min_collection_fee=UCASE('$min_collection_fee'), caf=UCASE('$caf'), min_caf=UCASE('$min_caf'), mostrar_collection_fee=UCASE('$mostrar_collection_fee'), mostrar_caf=UCASE('$mostrar_caf'), mostrar_referencia=UCASE('$mostrar_referencia'),  nombre_gastos_hawb=UCASE('$nombre_gastos_hawb'), nombre_gastos_embarque=UCASE('$nombre_gastos_embarque'), valor_gastos_hawb=UCASE('$valor_gastos_hawb'), valor_gastos_embarque=UCASE('$valor_gastos_embarque') where idnaviera='$datosnav[idnaviera]' and idcoloader_local='$idcoloader_local'";
								}
								
								if($clasif=='lcl')
								{
									$valor_gastos_hbl_min = $_POST['valor_gastos_hbl_min'.$datosnav['idnaviera']];
									$valor_gastos_hbl_min5 = $_POST['valor_gastos_hbl_min5'.$datosnav['idnaviera']];
									$valor_gastos_hbl_min10 = $_POST['valor_gastos_hbl_min10'.$datosnav['idnaviera']];
									$valor_gastos_hbl_min15 = $_POST['valor_gastos_hbl_min15'.$datosnav['idnaviera']];
									$valor_gastos_wm_min =  $_POST['valor_gastos_wm_min'.$datosnav['idnaviera']];
									$valor_gastos_wm_min5 =  $_POST['valor_gastos_wm_min5'.$datosnav['idnaviera']];
									$valor_gastos_wm_min10 =  $_POST['valor_gastos_wm_min10'.$datosnav['idnaviera']];
									$valor_gastos_wm_min15 =  $_POST['valor_gastos_wm_min15'.$datosnav['idnaviera']];
									$mostrar_rangos =  $_POST['mostrar_rangos'.$datosnav['idnaviera']];
												
									$queryins2="UPDATE totales_coloader_local SET nombre_gastos_hbl=UCASE('$nombre_gastos_hbl'), nombre_gastos_cont=UCASE('$nombre_gastos_cont'), nombre_gastos_wm=UCASE('$nombre_gastos_wm'), valor_gastos_hbl=UCASE('$valor_gastos_hbl'), valor_gastos_hbl_min=UCASE('$valor_gastos_hbl_min'), valor_gastos_hbl_min5=UCASE('$valor_gastos_hbl_min5'), valor_gastos_hbl_min10=UCASE('$valor_gastos_hbl_min10'), valor_gastos_hbl_min15=UCASE('$valor_gastos_hbl_min15'), valor_gastos_cont=UCASE('$valor_gastos_cont'), valor_gastos_wm=UCASE('$valor_gastos_wm'), valor_gastos_wm_min=UCASE('$valor_gastos_wm_min'),  valor_gastos_wm_min5=UCASE('$valor_gastos_wm_min5'), valor_gastos_wm_min10=UCASE('$valor_gastos_wm_min10'), valor_gastos_wm_min15=UCASE('$valor_gastos_wm_min15'), mostrar_var='$mostrar_var', collection_fee=UCASE('$collection_fee'), min_collection_fee=UCASE('$min_collection_fee'), caf=UCASE('$caf'), min_caf=UCASE('$min_caf'), mostrar_collection_fee=UCASE('$mostrar_collection_fee'), mostrar_caf=UCASE('$mostrar_caf'), mostrar_rangos=UCASE('$mostrar_rangos'), mostrar_referencia=UCASE('$mostrar_referencia'), nombre_gastos_hawb=UCASE('$nombre_gastos_hawb'), nombre_gastos_embarque=UCASE('$nombre_gastos_embarque'), valor_gastos_hawb=UCASE('$valor_gastos_hawb'), valor_gastos_embarque=UCASE('$valor_gastos_embarque') where idnaviera='$datosnav[idnaviera]' and idcoloader_local='$idcoloader_local'";
								}
							} 				
							elseif($filasct2 == 0)
							{
								if($clasif=='fcl' || $clasif=='aereo')
								{
									$queryins2="INSERT INTO totales_coloader_local (idnaviera, idcoloader_local, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, valor_gastos_hbl,valor_gastos_cont, valor_gastos_wm, mostrar_var, collection_fee, min_collection_fee, caf, min_caf, mostrar_collection_fee, mostrar_caf, mostrar_referencia, nombre_gastos_hawb, nombre_gastos_embarque, valor_gastos_hawb, valor_gastos_embarque) VALUES ('$datosnav[idnaviera]', '$idcoloader_local', UCASE('$nombre_gastos_hbl'), UCASE('$nombre_gastos_cont'), UCASE('$nombre_gastos_wm'), UCASE('$valor_gastos_hbl'), UCASE('$valor_gastos_cont'), UCASE('$valor_gastos_wm'), '$mostrar_var', UCASE('$collection_fee'), UCASE('$min_collection_fee'), UCASE('$caf'), UCASE('$min_caf'), UCASE('$mostrar_collection_fee'), UCASE('$mostrar_caf'), UCASE('$mostrar_referencia'), UCASE('$nombre_gastos_hawb'), UCASE('$nombre_gastos_embarque'), UCASE('$valor_gastos_hawb'), UCASE('$valor_gastos_embarque'))";
								}
								
								if($clasif=='lcl')
								{
									$valor_gastos_hbl_min = $_POST['valor_gastos_hbl_min'.$datosnav['idnaviera']];
									$valor_gastos_hbl_min5 = $_POST['valor_gastos_hbl_min5'.$datosnav['idnaviera']];
									$valor_gastos_hbl_min10 = $_POST['valor_gastos_hbl_min10'.$datosnav['idnaviera']];
									$valor_gastos_hbl_min15 = $_POST['valor_gastos_hbl_min15'.$datosnav['idnaviera']];
									$valor_gastos_wm_min =  $_POST['valor_gastos_wm_min'.$datosnav['idnaviera']];
									$valor_gastos_wm_min5 =  $_POST['valor_gastos_wm_min5'.$datosnav['idnaviera']];
									$valor_gastos_wm_min10 =  $_POST['valor_gastos_wm_min10'.$datosnav['idnaviera']];
									$valor_gastos_wm_min15 =  $_POST['valor_gastos_wm_min15'.$datosnav['idnaviera']];
									$mostrar_rangos =  $_POST['mostrar_rangos'.$datosnav['idnaviera']];
												
									$queryins2="INSERT INTO totales_coloader_local (idnaviera, idcoloader_local, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, valor_gastos_hbl,valor_gastos_hbl_min, valor_gastos_hbl_min5, valor_gastos_hbl_min10, valor_gastos_hbl_min15, valor_gastos_cont, valor_gastos_wm, valor_gastos_wm_min, valor_gastos_wm_min5, valor_gastos_wm_min10, valor_gastos_wm_min15, mostrar_var, collection_fee, min_collection_fee, caf, min_caf, mostrar_collection_fee, mostrar_caf, mostrar_rangos, mostrar_referencia, nombre_gastos_hawb, nombre_gastos_embarque, valor_gastos_hawb, valor_gastos_embarque) VALUES ('$datosnav[idnaviera]', '$idcoloader_local', UCASE('$nombre_gastos_hbl'), UCASE('$nombre_gastos_cont'), UCASE('$nombre_gastos_wm'), UCASE('$valor_gastos_hbl'), UCASE('$valor_gastos_hbl_min'), UCASE('$valor_gastos_hbl_min5'), UCASE('$valor_gastos_hbl_min10'), UCASE('$valor_gastos_hbl_min15'), UCASE('$valor_gastos_cont'), UCASE('$valor_gastos_wm'), UCASE('$valor_gastos_wm_min'), UCASE('$valor_gastos_wm_min5'), UCASE('$valor_gastos_wm_min10'), UCASE('$valor_gastos_wm_min15'), '$mostrar_var', UCASE('$collection_fee'), UCASE('$min_collection_fee'), UCASE('$caf'), UCASE('$min_caf'), UCASE('$mostrar_collection_fee'), UCASE('$mostrar_caf'), UCASE('$mostrar_rangos'), UCASE('$mostrar_referencia'), UCASE('$nombre_gastos_hawb'), UCASE('$nombre_gastos_embarque'), UCASE('$valor_gastos_hawb'), UCASE('$valor_gastos_embarque'))";
								}
							}				
							//print $queryins2.'<br>';
							$buscarins2=mysqli_query($link,$queryins2);
						}
					}
					
					if($buscarins)
					{
						$sql= "delete from local_por_coloader where idcoloader='$idcoloader' and idrecargo_local in (select idrecargo_local from recargos_local where clasificacion='$clasif')";
						//print $sql.'<br>'; 
						$exe= mysqli_query($link,$sql);
						
						$sqlrg = "select * from recargos_local where clasificacion='$clasif'";
						//print $sqlrg .'<br>';
						$exerg = mysqli_query($link,$sqlrg);
						while($datosrg = mysqli_fetch_array($exerg))
						{
							$idrecargo = $_POST['recargo'.$datosrg['idrecargo_local']];
							$valor_venta = $_POST['valor_venta'.$datosrg['idrecargo_local']];
							$minimo_venta = $_POST['minimo_venta'.$datosrg['idrecargo_local']];
							if($idrecargo!='')
							{
								$sql="INSERT INTO local_por_coloader (idrecargo_local, idcoloader, valor_venta, minimo_venta) VALUES ('$datosrg[idrecargo_local]', '$idcoloader', '$valor_venta', '$minimo_venta')";
								//print $sql.'<br>';  
								$exe= mysqli_query($link,$sql);
							}
						}
					}//end if		
				}//end elseif
			}//end for
//----------------------------------------------------------------------------------------------------------------------------------------
			}
			
			?><script>alert ('El registro ha sido ingresado satisfactoriamente')</script><?	
		}	
	}
	elseif(isset($_POST['idproveedor_agente']) && $_POST['idproveedor_agente'] != '')
	{
			$queryins="UPDATE $tabla SET 
						nombre_patio='$_POST[nombre_patio]', 
						idciudad='$_POST[idciudad]', 
						tipo='$tipo', 
						nombre=UCASE('$_POST[nombre]'), 
						alias=UCASE('$_POST[alias]'), 
						nit=UCASE('$_POST[nit]'), 
						direccion=UCASE('$_POST[direccion]'), 
						telefonos=UCASE('$_POST[telefonos]'), 
						email_empresarial=UCASE('$_POST[email_empresarial]'), 
						info_bancaria=UCASE('$_POST[info_bancaria]'), 
						sucursal=UCASE('$_POST[sucursal]'), 
						agente_linea=UCASE('$_POST[agente_linea]'), 
						operador_cont=UCASE('$_POST[operador_cont]'), 
						val20 = '$_POST[val20]',
						val40 = '$_POST[val40]',
						val40Hq = '$_POST[val40Hq]',
						pagina_web=UCASE('$_POST[pagina_web]'), 
						patios_cont='$_POST[patios_cont]', 
						corte_hbl=UCASE('$_POST[corte_hbl]'), 
						docs_requeridos=UCASE('$_POST[docs_requeridos]'), 
						restricciones=UCASE('$_POST[restricciones]'), 
						dir_bodega=UCASE('$_POST[dir_bodega]'), 
						sitios_operacion=UCASE('$_POST[sitios_operacion]'), 
						sobregiro=UCASE('$_POST[sobregiro]'), 
						observaciones=UCASE('$_POST[observaciones]'), 
						condiciones_fletes='$_POST[condiciones_fletes]' 
					WHERE $llave='$_POST[idproveedor_agente]'";
		//print $queryins;
		$buscarins_ppal=mysqli_query($link,$queryins);
	
		if(!$buscarins_ppal){
			print ("<script>alert('No se pudo modificar el registro')</script>");
		}else
		{			
		//	if ($mueve = move_uploaded_file($_FILES['adjunto']['tmp_name'], "adjuntos_proveedores/".$_FILES['adjunto']['name']))
		    if ($mueve = move_uploaded_file($_FILES['adjunto']['tmp_name'], "doc/doc_proveedores/".$_FILES['adjunto']['name']))
			{
				$nombre = $_FILES['adjunto']['name'];
				$sql = "INSERT INTO adjuntos_proveedores (idproveedor, idusuario, nombre, fecha_creacion, descripcion) VALUES ('$_POST[idproveedor_agente]', '$_SESSION[numberid]', '$nombre', NOW(), '$_POST[descripcion_adjunto]')";
				//print $sql.'<br>';
				$query = mysqli_query($link,$sql);
			}	
				
			$sqlcond = "select * from condiciones_especiales WHERE idproveedor_agente='$_POST[idproveedor_agente]'";
			
			$execond = mysqli_query($link,$sqlcond);
			$filascond = mysqli_num_rows($execond);
			
			if($filascond!=0)
			{
				$sqlcond = "UPDATE condiciones_especiales SET credito=UCASE('$_POST[credito]'), cupo_max=UCASE('$_POST[cupo_max]'), liberacion_auto='$_POST[liberacion_auto]' WHERE idproveedor_agente='$_POST[idproveedor_agente]'";
				//print $sqlcond.'<br>';
				$execond = mysqli_query($link,$sqlcond);
			}
			else
			{
				$sqlcond = "INSERT INTO condiciones_especiales (idproveedor_agente, credito, cupo_max, liberacion_auto) VALUES('$_POST[idproveedor_agente]', UCASE('$_POST[credito]'), UCASE('$_POST[cupo_max]'), '$_POST[liberacion_auto]')";
				//print $sqlcond.'<br>';
				$execond = mysqli_query($link,$sqlcond);
			}
			
			?><script>alert ('El registro ha sido modificado satisfactoriamente')</script><?
			
			if($tipo=='coloader')
			{
				$_POST['idcoloader'] = $_POST['idproveedor_agente'];
				
//Ingreso de recargos origen-----------------------------------------------------------------------------------------------------------------
			for($k=0; $k < 3; $k++)
			{
				if($k == 0)
					$clasif = 'fcl';
				if($k == 1)	
					$clasif = 'lcl';
				if($k == 2)	
					$clasif = 'aereo';
					
				$sqlct="select * from coloader_origen where idcoloader='$_POST[idcoloader]' and clasificacion='$clasif'";
				//print $sqlct.'<br>';
				$exect =mysqli_query($link,$sqlct);
				$filasct = mysqli_num_rows($exect);
				
				if($filasct == 0)//if($_POST['modRegistro']=="no")
				{
					$nombre_gastos_hbl = $_POST['nombre_gastos_hbl'.$clasif];
					$nombre_gastos_cont = $_POST['nombre_gastos_cont'.$clasif];
					$nombre_gastos_wm = $_POST['nombre_gastos_wm'.$clasif];
					$nombre_gastos_hawb = $_POST['nombre_gastos_hawb'.$clasif];
					$nombre_gastos_embarque = $_POST['nombre_gastos_embarque'.$clasif];					
					$valor_gastos_hbl = $_POST['valor_gastos_hbl'.$clasif];
					$valor_gastos_cont = $_POST['valor_gastos_cont'.$clasif];
					$valor_gastos_wm = $_POST['valor_gastos_wm'.$clasif];
					$valor_gastos_hawb = $_POST['valor_gastos_hawb'.$clasif];
					$valor_gastos_embarque = $_POST['valor_gastos_embarque'.$clasif];
					
					$queryins="INSERT INTO coloader_origen (idcoloader, clasificacion, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, nombre_gastos_hawb, nombre_gastos_embarque, valor_gastos_hbl, valor_gastos_cont, valor_gastos_wm, valor_gastos_hawb, valor_gastos_embarque, observaciones) VALUES ('$_POST[idcoloader]', '$clasif', UCASE('$nombre_gastos_hbl'), UCASE('$nombre_gastos_cont'), UCASE('$nombre_gastos_wm'), UCASE('$nombre_gastos_hawb'), UCASE('$nombre_gastos_embarque'), UCASE('$valor_gastos_hbl'), UCASE('$valor_gastos_cont'), UCASE('$valor_gastos_wm'), UCASE('$valor_gastos_hawb'), UCASE('$valor_gastos_embarque'), UCASE('$_POST[observaciones]'))";
					//print $queryins.'<br>';
					$buscarins=mysqli_query($link,$queryins);
					
					$sqlast = "SELECT LAST_INSERT_ID() ultimo FROM coloader_origen";	
					$querylast = mysqli_query($link,$sqlast);		
					$row = mysqli_fetch_array($querylast);
					$idcoloader_origen = $row['ultimo'];
					
					if($buscarins)
					{
						$sqlrg = "select * from recargos_origen where clasificacion='$clasif'";
						//print $sqlrg .'<br>';
						$exerg = mysqli_query($link,$sqlrg);
						while($datosrg = mysqli_fetch_array($exerg))
						{
							$idrecargo = $_POST['recargo_origen'.$datosrg['idrecargo_origen']];
							if($idrecargo!='')
							{
								$sql="INSERT INTO origen_por_coloader (idrecargo_origen, idcoloader_origen) VALUES ('$datosrg[idrecargo_origen]', '$idcoloader_origen')";
								//print $sql.'<br>';  
								$exe= mysqli_query($link,$sql);
							}
						}
					}
				}
				elseif($filasct > 0)
				{
					$exect = mysqli_query($link,$sqlct);
					$datosct = mysqli_fetch_array($exect);
					$idcoloader_origen = $datosct['idcoloader_origen'];
					
					$nombre_gastos_hbl = $_POST['nombre_gastos_hbl'.$clasif];
					$nombre_gastos_cont = $_POST['nombre_gastos_cont'.$clasif];
					$nombre_gastos_wm = $_POST['nombre_gastos_wm'.$clasif];
					$nombre_gastos_hawb = $_POST['nombre_gastos_hawb'.$clasif];
					$nombre_gastos_embarque = $_POST['nombre_gastos_embarque'.$clasif];					
					$valor_gastos_hbl = $_POST['valor_gastos_hbl'.$clasif];
					$valor_gastos_cont = $_POST['valor_gastos_cont'.$clasif];
					$valor_gastos_wm = $_POST['valor_gastos_wm'.$clasif];
					$valor_gastos_hawb = $_POST['valor_gastos_hawb'.$clasif];
					$valor_gastos_embarque = $_POST['valor_gastos_embarque'.$clasif];
					
					$queryins = "UPDATE coloader_origen SET nombre_gastos_hbl=UCASE('$nombre_gastos_hbl'), nombre_gastos_wm=UCASE('$nombre_gastos_wm'), nombre_gastos_hawb=UCASE('$nombre_gastos_hawb'), nombre_gastos_embarque=UCASE('$nombre_gastos_embarque'), valor_gastos_hbl=UCASE('$valor_gastos_hbl'), valor_gastos_cont=UCASE('$valor_gastos_cont'), valor_gastos_wm=UCASE('$valor_gastos_wm'), valor_gastos_hawb=UCASE('$valor_gastos_hawb'), valor_gastos_embarque=UCASE('$valor_gastos_embarque'), observaciones=UCASE('$_POST[observaciones]') WHERE idcoloader_origen='$idcoloader_origen' and clasificacion='$clasif'";
					//print $queryins.'<br>';
					$buscarins=mysqli_query($link,$queryins);
					
					if($buscarins)
					{
						$sql= "delete from origen_por_coloader where idcoloader_origen='$idcoloader_origen'";
						//print $sql.'<br>'; 
						$exe= mysqli_query($link,$sql);
						
						$sqlrg = "select * from recargos_origen where clasificacion='$clasif'";
						//print $sqlrg .'<br>';
						$exerg = mysqli_query($link,$sqlrg);
						while($datosrg = mysqli_fetch_array($exerg))
						{
							$idrecargo = $_POST['recargo_origen'.$datosrg['idrecargo_origen']];
							if($idrecargo!='')
							{
								$sql="INSERT INTO origen_por_coloader (idrecargo_origen, idcoloader_origen) VALUES ('$datosrg[idrecargo_origen]', '$idcoloader_origen')";
								//print $sql.'<br>';  
								$exe= mysqli_query($link,$sql);
							}
						}
					}
				}
			}
//Ingreso de recargos local-----------------------------------------------------------------------------------------------------------------
			for($k=0; $k < 3; $k++)
			{
				if($k == 0)
					$clasif = 'fcl';
				if($k == 1)	
					$clasif = 'lcl';
				if($k == 2)	
					$clasif = 'aereo';
			
				$sqlct="select * from coloader_local where idcoloader='$_POST[idcoloader]'";
				//print $sqlct.'<br>';
				$exect =mysqli_query($link,$sqlct);
				$filasct = mysqli_num_rows($exect);
			
				if($filasct == 0)//if($_POST['modRegistro']=="no")
				{
					$queryins="INSERT INTO coloader_local (idcoloader, clasificacion, observaciones) VALUES ('$_POST[idcoloader]', '$clasif', UCASE('$_POST[observaciones]'))";
					//print $queryins.'<br>';
					$buscarins=mysqli_query($link,$queryins);
					
					$sqlast = "SELECT LAST_INSERT_ID() ultimo FROM coloader_local";	
					$querylast = mysqli_query($link,$sqlast);		
					$row = mysqli_fetch_array($querylast);
					$idcoloader_local = $row['ultimo'];
					
					if($clasif=='fcl')
					{
						$tipo2 = 'tipo';
						$idtipo = 'idtipo';
					}
					elseif($clasif=='lcl')
					{
						$tipo2 = 'tipo_lcl';
						$idtipo = 'idtipo_lcl';
					}
					
					$sqlidt = "select distinct idtarifario from tarifario where clasificacion='$clasif'";
					if($clasif=='aereo')
						$sqlidt = "select distinct idtarifario_aereo as idtarifario from tarifario_aereo";
					//print $sqlidt .'<br>';
					$exeidt = mysqli_query($link,$sqlidt);
					
					$cad_idtar = '';
					while($datosidt = mysqli_fetch_array($exeidt))
					{
						if($cad_idtar != '')
							$cad_idtar .= ',';
						$cad_idtar .= " '".$datosidt['idtarifario'] ."'";		
					}
					if($cad_idtar == '')//si esta vacio adiciona el id cero
						$cad_idtar = "'0'";
					
					$sqlnav = "select distinct idnaviera from tarifario where idtarifario in ($cad_idtar)";
					if($clasif=='aereo')
						$sqlnav = "select distinct idaerolinea as idnaviera from tarifario_aereo where idtarifario_aereo in ($cad_idtar)";
					//print $sqlnav .'<br>';
					$exenav = mysqli_query($link,$sqlnav);
							
					while($datosnav = mysqli_fetch_array($exenav))
					{	
						$sqlrg = "select * from recargos_local where clasificacion='$clasif' and idnaviera='$datosnav[idnaviera]'";
						//print $sqlrg .'<br>';
						$exerg = mysqli_query($link,$sqlrg);
						$filasrg = mysqli_num_rows($exerg);
						
						if($filasrg > 0)
						{
							$nombre_gastos_hbl = $_POST['nombre_gastos_hbl'.$datosnav['idnaviera']];
							$nombre_gastos_cont = $_POST['nombre_gastos_cont'.$datosnav['idnaviera']];
							$nombre_gastos_wm = $_POST['nombre_gastos_wm'.$datosnav['idnaviera']];
							$nombre_gastos_hawb = $_POST['nombre_gastos_hawb'.$datosnav['idnaviera']];
							$nombre_gastos_embarque = $_POST['nombre_gastos_embarque'.$datosnav['idnaviera']];
							
							$valor_gastos_hbl = $_POST['valor_gastos_hbl'.$datosnav['idnaviera']];
							$valor_gastos_cont =  $_POST['valor_gastos_cont'.$datosnav['idnaviera']];
							$valor_gastos_wm =  $_POST['valor_gastos_wm'.$datosnav['idnaviera']];
							$valor_gastos_hawb =  $_POST['valor_gastos_hawb'.$datosnav['idnaviera']];
							$valor_gastos_embarque =  $_POST['valor_gastos_embarque'.$datosnav['idnaviera']];
							
							$mostrar_var = $_POST['mostrar_var'.$datosnav['idnaviera']];
							$collection_fee = $_POST['collection_fee'.$datosnav['idnaviera']];
							$min_collection_fee = $_POST['min_collection_fee'.$datosnav['idnaviera']];
							$caf = $_POST['caf'.$datosnav['idnaviera']]; 
							$min_caf = $_POST['min_caf'.$datosnav['idnaviera']];				
							$mostrar_collection_fee = $_POST['mostrar_collection_fee'.$datosnav['idnaviera']];
							$mostrar_caf = $_POST['mostrar_caf'.$datosnav['idnaviera']];
							$mostrar_referencia = $_POST['mostrar_referencia'.$datosnav['idnaviera']];
							
							if($clasif=='fcl' || $clasif=='aereo')
							{
								$queryins2="INSERT INTO totales_coloader_local (idnaviera, idcoloader_local, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, valor_gastos_hbl,valor_gastos_cont, valor_gastos_wm, mostrar_var, collection_fee, min_collection_fee, caf, min_caf, mostrar_collection_fee, mostrar_caf, mostrar_referencia, nombre_gastos_hawb, nombre_gastos_embarque, valor_gastos_hawb, valor_gastos_embarque) VALUES ('$datosnav[idnaviera]', '$idcoloader_local', UCASE('$nombre_gastos_hbl'), UCASE('$nombre_gastos_cont'), UCASE('$nombre_gastos_wm'), UCASE('$valor_gastos_hbl'), UCASE('$valor_gastos_cont'), UCASE('$valor_gastos_wm'), '$mostrar_var', UCASE('$collection_fee'), UCASE('$min_collection_fee'), UCASE('$caf'), UCASE('$min_caf'), UCASE('$mostrar_collection_fee'), UCASE('$mostrar_caf'), UCASE('$mostrar_referencia'), UCASE('$nombre_gastos_hawb'), UCASE('$nombre_gastos_embarque'), UCASE('$valor_gastos_hawb'), UCASE('$valor_gastos_embarque'))";
							}
							
							if($clasif=='lcl')
							{
								$valor_gastos_hbl_min = $_POST['valor_gastos_hbl_min'.$datosnav['idnaviera']];
								$valor_gastos_hbl_min5 = $_POST['valor_gastos_hbl_min5'.$datosnav['idnaviera']];
								$valor_gastos_hbl_min10 = $_POST['valor_gastos_hbl_min10'.$datosnav['idnaviera']];
								$valor_gastos_hbl_min15 = $_POST['valor_gastos_hbl_min15'.$datosnav['idnaviera']];
								$valor_gastos_wm_min =  $_POST['valor_gastos_wm_min'.$datosnav['idnaviera']];
								$valor_gastos_wm_min5 =  $_POST['valor_gastos_wm_min5'.$datosnav['idnaviera']];
								$valor_gastos_wm_min10 =  $_POST['valor_gastos_wm_min10'.$datosnav['idnaviera']];
								$valor_gastos_wm_min15 =  $_POST['valor_gastos_wm_min15'.$datosnav['idnaviera']];
								$mostrar_rangos =  $_POST['mostrar_rangos'.$datosnav['idnaviera']];
											
								$queryins2="INSERT INTO totales_coloader_local (idnaviera, idcoloader_local, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, valor_gastos_hbl,valor_gastos_hbl_min, valor_gastos_hbl_min5, valor_gastos_hbl_min10, valor_gastos_hbl_min15, valor_gastos_cont, valor_gastos_wm, valor_gastos_wm_min, valor_gastos_wm_min5, valor_gastos_wm_min10, valor_gastos_wm_min15, mostrar_var, collection_fee, min_collection_fee, caf, min_caf, mostrar_collection_fee, mostrar_caf, mostrar_rangos, mostrar_referencia, nombre_gastos_hawb, nombre_gastos_embarque, valor_gastos_hawb, valor_gastos_embarque) VALUES ('$datosnav[idnaviera]', '$idcoloader_local', UCASE('$nombre_gastos_hbl'), UCASE('$nombre_gastos_cont'), UCASE('$nombre_gastos_wm'), UCASE('$valor_gastos_hbl'), UCASE('$valor_gastos_hbl_min'), UCASE('$valor_gastos_hbl_min5'), UCASE('$valor_gastos_hbl_min10'), UCASE('$valor_gastos_hbl_min15'), UCASE('$valor_gastos_cont'), UCASE('$valor_gastos_wm'), UCASE('$valor_gastos_wm_min'), UCASE('$valor_gastos_wm_min5'), UCASE('$valor_gastos_wm_min10'), UCASE('$valor_gastos_wm_min15'), '$mostrar_var', UCASE('$collection_fee'), UCASE('$min_collection_fee'), UCASE('$caf'), UCASE('$min_caf'), UCASE('$mostrar_collection_fee'), UCASE('$mostrar_caf'), UCASE('$mostrar_rangos'), UCASE('$mostrar_referencia'), UCASE('$nombre_gastos_hawb'), UCASE('$nombre_gastos_embarque'), UCASE('$valor_gastos_hawb'), UCASE('$valor_gastos_embarque'))";
							}
							//print $queryins2.'<br>';
							$buscarins2=mysqli_query($link,$queryins2);
						}
					}
					if($buscarins)
					{
						$sqlrg = "select * from recargos_local where clasificacion='$clasif'";
						//print $sqlrg .'<br>';
						$exerg = mysqli_query($link,$sqlrg);
						while($datosrg = mysqli_fetch_array($exerg))
						{
							$idrecargo = $_POST['recargo'.$datosrg['idrecargo_local']];
							$valor_venta = $_POST['valor_venta'.$datosrg['idrecargo_local']];
							$minimo_venta = $_POST['minimo_venta'.$datosrg['idrecargo_local']];
							
							if($idrecargo!='')
							{
								$sql="INSERT INTO local_por_coloader (idrecargo_local, idcoloader, valor_venta, minimo_venta) VALUES ('$datosrg[idrecargo_local]', '$_POST[idcoloader]', '$valor_venta', '$minimo_venta')";
								//print $sql.'<br>';  
								$exe= mysqli_query($link,$sql);
							}
						}
					}
				}
				elseif($filasct > 0)
				{
					$exect = mysqli_query($link,$sqlct);
					$datosct = mysqli_fetch_array($exect);
					$idcoloader_local = $datosct['idcoloader_local'];
					
					$queryins = "UPDATE coloader_local SET observaciones=UCASE('$_POST[observaciones]') WHERE idcoloader='$_POST[idcoloader]'";
					//print $queryins.'<br>';
					$buscarins=mysqli_query($link,$queryins);
					
					if($clasif=='fcl')
					{
						$tipo2 = 'tipo';
						$idtipo = 'idtipo';
					}
					elseif($clasif=='lcl')
					{
						$tipo2 = 'tipo_lcl';
						$idtipo = 'idtipo_lcl';
					}
					$sqlidt = "select distinct idtarifario from tarifario where clasificacion='$clasif'";
					if($clasif=='aereo')
						$sqlidt = "select distinct idtarifario_aereo as idtarifario from tarifario_aereo";
					//print $sqlidt .'<br>';
					$exeidt = mysqli_query($link,$sqlidt);
					
					$cad_idtar = '';
					while($datosidt = mysqli_fetch_array($exeidt))
					{
						if($cad_idtar != '')
							$cad_idtar .= ',';
						$cad_idtar .= " '".$datosidt['idtarifario'] ."'";		
					}
					if($cad_idtar == '')//si esta vacio adiciona el id cero
						$cad_idtar = "'0'";
					
					$sqlnav = "select distinct idnaviera from tarifario where idtarifario in ($cad_idtar)";
					if($clasif=='aereo')
						$sqlnav = "select distinct idaerolinea as idnaviera from tarifario_aereo where idtarifario_aereo in ($cad_idtar)";
					//print $sqlnav .'<br>';
					$exenav = mysqli_query($link,$sqlnav);
							
					while($datosnav = mysqli_fetch_array($exenav))
					{	
						$sqlrg = "select * from recargos_local where clasificacion='$clasif' and idnaviera='$datosnav[idnaviera]'";
						//print $sqlrg .'<br>';
						$exerg = mysqli_query($link,$sqlrg);
						$filasrg = mysqli_num_rows($exerg);
						
						if($filasrg > 0)
						{
							$nombre_gastos_hbl = $_POST['nombre_gastos_hbl'.$datosnav['idnaviera']];
							$nombre_gastos_cont = $_POST['nombre_gastos_cont'.$datosnav['idnaviera']];
							$nombre_gastos_wm = $_POST['nombre_gastos_wm'.$datosnav['idnaviera']];
							$nombre_gastos_hawb = $_POST['nombre_gastos_hawb'.$datosnav['idnaviera']];
							$nombre_gastos_embarque = $_POST['nombre_gastos_embarque'.$datosnav['idnaviera']];
							
							$valor_gastos_hbl = $_POST['valor_gastos_hbl'.$datosnav['idnaviera']];
							$valor_gastos_cont =  $_POST['valor_gastos_cont'.$datosnav['idnaviera']];
							$valor_gastos_wm =  $_POST['valor_gastos_wm'.$datosnav['idnaviera']];
							$valor_gastos_hawb =  $_POST['valor_gastos_hawb'.$datosnav['idnaviera']];
							$valor_gastos_embarque =  $_POST['valor_gastos_embarque'.$datosnav['idnaviera']];
							
							$mostrar_var = $_POST['mostrar_var'.$datosnav['idnaviera']];
							$collection_fee = $_POST['collection_fee'.$datosnav['idnaviera']];
							$min_collection_fee = $_POST['min_collection_fee'.$datosnav['idnaviera']];
							$caf = $_POST['caf'.$datosnav['idnaviera']]; 
							$min_caf = $_POST['min_caf'.$datosnav['idnaviera']];
							$mostrar_collection_fee = $_POST['mostrar_collection_fee'.$datosnav['idnaviera']];
							$mostrar_caf = $_POST['mostrar_caf'.$datosnav['idnaviera']];
							$mostrar_referencia = $_POST['mostrar_referencia'.$datosnav['idnaviera']];
							
							$sqlct2 = "select * from totales_coloader_local where idnaviera='$datosnav[idnaviera]' and idcoloader_local='$idcoloader_local'";
							//print $sqlct2.'<br>';
							$exect2 = mysqli_query($link,$sqlct2);
							$filasct2 = mysqli_num_rows($exect2);
							
							if($filasct2 > 0)
							{
								if($clasif=='fcl' || $clasif=='aereo')
								{
									$queryins2="UPDATE totales_coloader_local SET nombre_gastos_hbl=UCASE('$nombre_gastos_hbl'), nombre_gastos_cont=UCASE('$nombre_gastos_cont'), nombre_gastos_wm=UCASE('$nombre_gastos_wm'), valor_gastos_hbl=UCASE('$valor_gastos_hbl'), valor_gastos_cont=UCASE('$valor_gastos_cont'), valor_gastos_wm=UCASE('$valor_gastos_wm'), mostrar_var='$mostrar_var', collection_fee=UCASE('$collection_fee'), min_collection_fee=UCASE('$min_collection_fee'), caf=UCASE('$caf'), min_caf=UCASE('$min_caf'), mostrar_collection_fee=UCASE('$mostrar_collection_fee'), mostrar_caf=UCASE('$mostrar_caf'), mostrar_referencia=UCASE('$mostrar_referencia'),  nombre_gastos_hawb=UCASE('$nombre_gastos_hawb'), nombre_gastos_embarque=UCASE('$nombre_gastos_embarque'), valor_gastos_hawb=UCASE('$valor_gastos_hawb'), valor_gastos_embarque=UCASE('$valor_gastos_embarque') where idnaviera='$datosnav[idnaviera]' and idcoloader_local='$idcoloader_local'";
								}
								
								if($clasif=='lcl')
								{
									$valor_gastos_hbl_min = $_POST['valor_gastos_hbl_min'.$datosnav['idnaviera']];
									$valor_gastos_hbl_min5 = $_POST['valor_gastos_hbl_min5'.$datosnav['idnaviera']];
									$valor_gastos_hbl_min10 = $_POST['valor_gastos_hbl_min10'.$datosnav['idnaviera']];
									$valor_gastos_hbl_min15 = $_POST['valor_gastos_hbl_min15'.$datosnav['idnaviera']];
									$valor_gastos_wm_min =  $_POST['valor_gastos_wm_min'.$datosnav['idnaviera']];
									$valor_gastos_wm_min5 =  $_POST['valor_gastos_wm_min5'.$datosnav['idnaviera']];
									$valor_gastos_wm_min10 =  $_POST['valor_gastos_wm_min10'.$datosnav['idnaviera']];
									$valor_gastos_wm_min15 =  $_POST['valor_gastos_wm_min15'.$datosnav['idnaviera']];
									$mostrar_rangos =  $_POST['mostrar_rangos'.$datosnav['idnaviera']];
												
									$queryins2="UPDATE totales_coloader_local SET nombre_gastos_hbl=UCASE('$nombre_gastos_hbl'), nombre_gastos_cont=UCASE('$nombre_gastos_cont'), nombre_gastos_wm=UCASE('$nombre_gastos_wm'), valor_gastos_hbl=UCASE('$valor_gastos_hbl'), valor_gastos_hbl_min=UCASE('$valor_gastos_hbl_min'), valor_gastos_hbl_min5=UCASE('$valor_gastos_hbl_min5'), valor_gastos_hbl_min10=UCASE('$valor_gastos_hbl_min10'), valor_gastos_hbl_min15=UCASE('$valor_gastos_hbl_min15'), valor_gastos_cont=UCASE('$valor_gastos_cont'), valor_gastos_wm=UCASE('$valor_gastos_wm'), valor_gastos_wm_min=UCASE('$valor_gastos_wm_min'),  valor_gastos_wm_min5=UCASE('$valor_gastos_wm_min5'), valor_gastos_wm_min10=UCASE('$valor_gastos_wm_min10'), valor_gastos_wm_min15=UCASE('$valor_gastos_wm_min15'), mostrar_var='$mostrar_var', collection_fee=UCASE('$collection_fee'), min_collection_fee=UCASE('$min_collection_fee'), caf=UCASE('$caf'), min_caf=UCASE('$min_caf'), mostrar_collection_fee=UCASE('$mostrar_collection_fee'), mostrar_caf=UCASE('$mostrar_caf'), mostrar_rangos=UCASE('$mostrar_rangos'), mostrar_referencia=UCASE('$mostrar_referencia'), nombre_gastos_hawb=UCASE('$nombre_gastos_hawb'), nombre_gastos_embarque=UCASE('$nombre_gastos_embarque'), valor_gastos_hawb=UCASE('$valor_gastos_hawb'), valor_gastos_embarque=UCASE('$valor_gastos_embarque') where idnaviera='$datosnav[idnaviera]' and idcoloader_local='$idcoloader_local'";
								}
							} 				
							elseif($filasct2 == 0)
							{
								if($clasif=='fcl' || $clasif=='aereo')
								{
									$queryins2="INSERT INTO totales_coloader_local (idnaviera, idcoloader_local, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, valor_gastos_hbl,valor_gastos_cont, valor_gastos_wm, mostrar_var, collection_fee, min_collection_fee, caf, min_caf, mostrar_collection_fee, mostrar_caf, mostrar_referencia, nombre_gastos_hawb, nombre_gastos_embarque, valor_gastos_hawb, valor_gastos_embarque) VALUES ('$datosnav[idnaviera]', '$idcoloader_local', UCASE('$nombre_gastos_hbl'), UCASE('$nombre_gastos_cont'), UCASE('$nombre_gastos_wm'), UCASE('$valor_gastos_hbl'), UCASE('$valor_gastos_cont'), UCASE('$valor_gastos_wm'), '$mostrar_var', UCASE('$collection_fee'), UCASE('$min_collection_fee'), UCASE('$caf'), UCASE('$min_caf'), UCASE('$mostrar_collection_fee'), UCASE('$mostrar_caf'), UCASE('$mostrar_referencia'), UCASE('$nombre_gastos_hawb'), UCASE('$nombre_gastos_embarque'), UCASE('$valor_gastos_hawb'), UCASE('$valor_gastos_embarque'))";
								}
								
								if($clasif=='lcl')
								{
									$valor_gastos_hbl_min = $_POST['valor_gastos_hbl_min'.$datosnav['idnaviera']];
									$valor_gastos_hbl_min5 = $_POST['valor_gastos_hbl_min5'.$datosnav['idnaviera']];
									$valor_gastos_hbl_min10 = $_POST['valor_gastos_hbl_min10'.$datosnav['idnaviera']];
									$valor_gastos_hbl_min15 = $_POST['valor_gastos_hbl_min15'.$datosnav['idnaviera']];
									$valor_gastos_wm_min =  $_POST['valor_gastos_wm_min'.$datosnav['idnaviera']];
									$valor_gastos_wm_min5 =  $_POST['valor_gastos_wm_min5'.$datosnav['idnaviera']];
									$valor_gastos_wm_min10 =  $_POST['valor_gastos_wm_min10'.$datosnav['idnaviera']];
									$valor_gastos_wm_min15 =  $_POST['valor_gastos_wm_min15'.$datosnav['idnaviera']];
									$mostrar_rangos =  $_POST['mostrar_rangos'.$datosnav['idnaviera']];
												
									$queryins2="INSERT INTO totales_coloader_local (idnaviera, idcoloader_local, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, valor_gastos_hbl,valor_gastos_hbl_min, valor_gastos_hbl_min5, valor_gastos_hbl_min10, valor_gastos_hbl_min15, valor_gastos_cont, valor_gastos_wm, valor_gastos_wm_min, valor_gastos_wm_min5, valor_gastos_wm_min10, valor_gastos_wm_min15, mostrar_var, collection_fee, min_collection_fee, caf, min_caf, mostrar_collection_fee, mostrar_caf, mostrar_rangos, mostrar_referencia, nombre_gastos_hawb, nombre_gastos_embarque, valor_gastos_hawb, valor_gastos_embarque) VALUES ('$datosnav[idnaviera]', '$idcoloader_local', UCASE('$nombre_gastos_hbl'), UCASE('$nombre_gastos_cont'), UCASE('$nombre_gastos_wm'), UCASE('$valor_gastos_hbl'), UCASE('$valor_gastos_hbl_min'), UCASE('$valor_gastos_hbl_min5'), UCASE('$valor_gastos_hbl_min10'), UCASE('$valor_gastos_hbl_min15'), UCASE('$valor_gastos_cont'), UCASE('$valor_gastos_wm'), UCASE('$valor_gastos_wm_min'), UCASE('$valor_gastos_wm_min5'), UCASE('$valor_gastos_wm_min10'), UCASE('$valor_gastos_wm_min15'), '$mostrar_var', UCASE('$collection_fee'), UCASE('$min_collection_fee'), UCASE('$caf'), UCASE('$min_caf'), UCASE('$mostrar_collection_fee'), UCASE('$mostrar_caf'), UCASE('$mostrar_rangos'), UCASE('$mostrar_referencia'), UCASE('$nombre_gastos_hawb'), UCASE('$nombre_gastos_embarque'), UCASE('$valor_gastos_hawb'), UCASE('$valor_gastos_embarque'))";
								}
							}				
							//print $queryins2.'<br>';
							$buscarins2=mysqli_query($link,$queryins2);
						}
					}
					
					if($buscarins)
					{
						$sql= "delete from local_por_coloader where idcoloader='$_POST[idcoloader]' and idrecargo_local in (select idrecargo_local from recargos_local where clasificacion='$clasif')";
						//print $sql.'<br>'; 
						$exe= mysqli_query($link,$sql);
						
						$sqlrg = "select * from recargos_local where clasificacion='$clasif'";
						//print $sqlrg .'<br>';
						$exerg = mysqli_query($link,$sqlrg);
						while($datosrg = mysqli_fetch_array($exerg))
						{
							$idrecargo = $_POST['recargo'.$datosrg['idrecargo_local']];
							$valor_venta = $_POST['valor_venta'.$datosrg['idrecargo_local']];
							$minimo_venta = $_POST['minimo_venta'.$datosrg['idrecargo_local']];
							if($idrecargo!='')
							{
								$sql="INSERT INTO local_por_coloader (idrecargo_local, idcoloader, valor_venta, minimo_venta) VALUES ('$datosrg[idrecargo_local]', '$_POST[idcoloader]', '$valor_venta', '$minimo_venta')";
								//print $sql.'<br>';  
								$exe= mysqli_query($link,$sql);
							}
						}
					}		
				}
			}//end for
//----------------------------------------------------------------------------------------------------------------------------------------
			}
		}	
	}
	?><script>document.location.href='proveedores_agentes.php?idproveedor_agente=<? if($_POST['idproveedor_agente']!='') print $_POST['idproveedor_agente']; else print $idproveedor_agente; ?>&tipo=<? print $tipo; ?>';</script><?
}

if($_POST['varelimi']=='si')
{
	$queryelim="DELETE FROM $tabla WHERE $llave='$_POST[idproveedor_agente]'";
	$buscarelim=mysqli_query($link,$queryelim);
	if(!$buscarelim)
		print mysqli_error();
		
	$sqlcond="DELETE FROM condiciones_especiales WHERE idproveedor_agente='$_POST[idproveedor_agente]'";
	$execond==mysqli_query($link,$sqlcond);	
	?><script>alert('El registro ha sido eliminado');
	document.location.href='<? print $_SERVER['PHP_SELF']."?tipo=$tipo";?>'</script><?
}

if (isset($_POST['idproveedor_agente']))
	$_GET['idproveedor_agente'] == $_POST['idproveedor_agente'];

?>


<body style="background-color: transparent;">
<form enctype="multipart/form-data" name="formulario" method="post">
<input name="datosok" type="hidden" value="no" />
<input name="varelimi" type="hidden" value="no" />
<input type="hidden" name="listaEliminar" value="" />
<input name="idproveedor_agente" type="hidden" value="<? print $_GET['idproveedor_agente'] ?>" />
<input name="xyz" type="hidden" value="" />

<input name="adjuntoeli" type="hidden" value="" />

<?
	if($_GET['idproveedor_agente'] != '')
	{
		$sqlad = "select * from $tabla where tipo='$tipo' and $llave=$_GET[idproveedor_agente]";
		$exead = mysqli_query($link,$sqlad);
		$datosad = mysqli_fetch_array($exead);
		
		$sqlad2 = "select * from condiciones_especiales where idproveedor_agente='$_GET[idproveedor_agente]'";
		$exead2 = mysqli_query($link,$sqlad2);
		$datosad2 = mysqli_fetch_array($exead2);
	}
?>
<?
if(isset($_GET['xyz']) and $_GET['xyz']!="")
	$_POST['xyz'] = $_GET['xyz'];
	if(isset($_POST['xyz']) and $_POST['xyz']!="")
	{
		$sql = "SELECT * FROM $tabla WHERE tipo='$tipo' and nombre LIKE '%$_POST[xyz]%'";
		$query = mysqli_query($link,$sql);
		$filas = mysqli_num_rows($query);
		if ($filas == 0)
			print ("<script>alert('Este registro no existe vuelva a intentarlo')</script>");
		else
		{
			if ($filas == 1)
			{
				$row = mysqli_fetch_array($query);
				print ("<script>document.location.href='".$_SERVER['PHP_SELF']."?idproveedor_agente=$row[idproveedor_agente]&tipo=$tipo'</script>");
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
							print "<a href=".$_SERVER['PHP_SELF']."?idproveedor_agente=$row[idproveedor_agente]&tipo=$tipo>$row[nombre]</a><br>";
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
									<select name="pag" onChange="document.location='<? print $_SERVER['PHP_SELF']; ?>?xyz=<? print $_POST['xyz']; ?>&tipo=<? print $tipo; ?>&pag=' + document.forms[0].pag.value;">
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
	}
	?> 
            
<table width="100%" >
	<tr>
    	<td class="subtitseccion" style="text-align:left"   colspan="2"><a href="javascript:void(0);" class="subtitseccion" onClick="showmed10()"><? print strtoupper($tipo); ?> / CONT&Aacute;CTOS</a><br><br></td>
    </tr>
    	<td align="center" class="subtitseccion" colspan="2">
    <div class="capa10">
    <table width="100%" align="center">
        <tr>
            <td class="contenidotab">RAZON SOCIAL*</td>    
            <td>       
                <table>
                    <tr>
                        <td>
                        <input id="nombre" name="nombre" class="tex1" value="<? if($_POST['nombre']!='') print $_POST['nombre']; else print $datosad['nombre']; ?>" maxlength="50" onKeyUp="Completep(this, event)"></td>
                        <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="validaBuscar(formulario);">Buscar</a></td>
                    </tr>
                </table>
            </td>       
        </tr>

        <tr>
            <td class="contenidotab">NIT*</td>   
            <td><input id="nit" name="nit" class="tex1" value="<? if($_POST['nit']!='') print $_POST['nit']; else print $datosad['nit']; ?>" maxlength="50"></td>
        </tr>
		<tr>
            <td class="contenidotab">REFERENCIA:</td>   
            <td><input id="alias" name="alias" class="tex1" value="<? echo $datosad['alias']; ?>" maxlength="50"></td>
        </tr>
        <? if($tipo=='naviera') { ?>
        <tr>
            <td class="contenidotab">AGENTE LINEA</td>   
            <td><input id="agente_linea" name="agente_linea" class="tex1" value="<? if($_POST['agente_linea']!='') print $_POST['agente_linea']; else print $datosad['agente_linea']; ?>" maxlength="50"></td>
        </tr>
        <tr>
            <td class="contenidotab">OPERADOR DE CONTENEDORES</td>   
            <td><input id="operador_cont" name="operador_cont" class="tex1" value="<? if($_POST['operador_cont']!='') print $_POST['operador_cont']; else print $datosad['operador_cont']; ?>" maxlength="50"></td>
        </tr>
        <tr>
        <? } ?>
            <td class="contenidotab">PAIS*</td>   
            <td>
                <select id="idpais" name="idpais" class="tex1" onChange="validaPais(formulario);" >
                    <option value="N"> Seleccione </option>
                    <?
                    $es="select * from paises order by nombre";
                    $exe=mysqli_query($link,$es);
                    if($_POST['idpais']!='')
                        $comparador = $_POST['idpais'];
                    else
                    {
                        $sqlp = "select idpais from ciudades where idciudad='$datosad[idciudad]'";
                        $exep = mysqli_query($link,$sqlp);
                        $datosp = mysqli_fetch_array($exep);
                        $comparador = $datosp['idpais']; 	
                    }
                    while($row=mysqli_fetch_array($exe))
                    {
                        $sel = "";
                        if($comparador == $row['idpais'])
                            $sel = "selected";
                        print "<option value='$row[idpais]' $sel>$row[nombre]</option>";
                    }
                    ?>
                </select>
            </td>    
        </tr>
        <tr>
        <? if($_POST['idpais']=='')
        {
            $sqlp = "select idpais from ciudades where idciudad='$datosad[idciudad]'";
            $exep = mysqli_query($link,$sqlp);
            $datosp = mysqli_fetch_array($exep);
            $_POST['idpais'] = $datosp['idpais'];
        }	
        ?>
            <td class="contenidotab">CIUDAD</td>   
            <td>
                <select id="idciudad" name="idciudad" class="tex1" >
                    <option value="N"> Seleccione </option>
                    <?
                    $es = "select * from ciudades where idpais='$_POST[idpais]' order by nombre"; 
                    $exe=mysqli_query($link,$es);
                    if($_POST['idciudad']!='N' && $_POST['idciudad']!='')
                        $comparador = $_POST['idciudad'];
                    else
                        $comparador = $datosad['idciudad']; 
                    while($row=mysqli_fetch_array($exe))
                    {
                        $sel = "";
                        if($comparador == $row['idciudad'])
                            $sel = "selected";
                        print "<option value='$row[idciudad]' $sel>$row[nombre]</option>";
                    }	
                    ?>
                </select>
            </td>    
        </tr>    
        <tr>
            <td class="contenidotab">DIRECCION</td>    
            <td><input id="direccion" name="direccion" value="<? if($_POST['direccion']!='') print $_POST['direccion']; else print $datosad['direccion']; ?>" maxlength="100" size="50"></td>
        </tr>
            <tr>
            <td class="contenidotab">TELEFONOS</td>    
            <td><input id="telefonos" name="telefonos" class="tex1" value="<? if($_POST['telefonos']!='') print $_POST['telefonos']; else print $datosad['telefonos']; ?>" maxlength="50"></td>
        </tr>
        <tr>
            <td class="contenidotab">EMAIL EMPRESARIAL</td>    
            <td><input id="email_empresarial" name="email_empresarial" class="tex1" value="<? if($_POST['email_empresarial']!='') print $_POST['email_empresarial']; else print $datosad['email_empresarial']; ?>" maxlength="50"></td>
        </tr>    
        <? if($tipo=='financiero') { ?>
        <tr>
            <td class="contenidotab">SOBREGIRO AUTORIZADO</td>    
            <td><input id="sobregiro" name="sobregiro" class="tex1" value="<? if($_POST['sobregiro']!='') print $_POST['sobregiro']; else print $datosad['sobregiro']; ?>" maxlength="50"></td>
        </tr>
        <? } ?>
        <tr>
            <td class="contenidotab">INFORMACION BANCARIA</td>    
          <td><textarea name="info_bancaria" id="info_bancaria" class="tex1"  cols="40" rows="7"><? if($_POST['info_bancaria']!='') print $_POST['info_bancaria']; else print $datosad['info_bancaria']; ?></textarea></td>
        </tr>
		
		
		
		
		
        <tr>
            <td class="contenidotab">PAGINA WEB</td>   
            <td><input id="pagina_web" name="pagina_web" class="tex1" value="<? if($_POST['pagina_web']!='') print $_POST['pagina_web']; else print $datosad['pagina_web']; ?>" maxlength="50"></td>
        </tr>
        <? if($tipo=='naviera') { ?>
		<tr class="contenidotab">
            <td>VALOR</td>    
            <td> 20:<input type="text" value="<?= $datosad['val20']?>" name="val20" class="numerico" style="width:40px"> 
				 40:<input type="text" value="<?= $datosad['val40']?>" name="val40" class="numerico" style="width:40px"> 
				 40Hq:<input type="text" value="<?= $datosad['val40Hq']?>" name="val40Hq" class="numerico" style="width:40px"> 
			</td>
        </tr>  
 
		
		
        <tr>
            <td class="contenidotab">PATIOS DE CONTENEDORES</td>
            <td>
                <select id="patios_cont" name="patios_cont" class="tex1" >
                <?
                    if($_POST['patios_cont']!='N' && $_POST['patios_cont']!='')
                        $comparador = $_POST['patios_cont'];
                    else
                        $comparador = $datosad['patios_cont'];
                ?>
                    <option value="N"> Seleccione </option>
                    <option value="bogota" <? if($comparador=='bogota') print 'selected';?> > Bogota </option>
                    <option value="medellin" <? if($comparador=='medellin') print 'selected';?> > Medellin </option>
                    <option value="cali" <? if($comparador=='cali') print 'selected';?> > Cali </option>    
                </select>
            </td>
        </tr>
	<tr>
            <td class="contenidotab">NOMBRE DE PATIO</td>   
            <td><input id="nombre_patio" name="nombre_patio" class="tex1" value="<? if($_POST['nombre_patio']!='') print $_POST['nombre_patio']; else print $datosad['nombre_patio']; ?>" maxlength="50"></td>
        </tr>
        <? } ?>
        <? if($tipo=='otm') { ?>
        <tr>
            <td class="contenidotab">CORTE DE HBL</td>    
            <td><input id="corte_hbl" name="corte_hbl" class="tex1" value="<? if($_POST['corte_hbl']!='') print $_POST['corte_hbl']; else print $datosad['corte_hbl']; ?>" maxlength="50"></td>
        </tr>
        <? } ?>
        <? if($tipo=='bodega') { ?>
        <tr>
            <td class="contenidotab">DIRECCION BODEGA</td>    
            <td><input id="dir_bodega" name="dir_bodega" class="tex1" value="<? if($_POST['dir_bodega']!='') print $_POST['dir_bodega']; else print $datosad['dir_bodega']; ?>" maxlength="50"></td>
        </tr>
        <? } ?>
        <? if($tipo=='otm' || $tipo=='bodega' || $tipo=='aduana') { ?>  
        <tr>
            <td class="contenidotab">DOCUMENTOS REQUERIDOS</td> 
            <td><textarea name="docs_requeridos" id="docs_requeridos" class="tex1"  cols="40" rows="7"><? if($_POST['docs_requeridos']!='') print $_POST['docs_requeridos']; else print $datosad['docs_requeridos']; ?></textarea></td>
        </tr>
        <? } ?>
        <? if($tipo=='otm' || $tipo=='bodega') { ?>
        <tr>
            <td class="contenidotab">RESTRICCIONES</td> 
            <td><textarea name="restricciones" id="restricciones" class="tex1"  cols="40" rows="7"><? if($_POST['restricciones']!='') print $_POST['restricciones']; else print $datosad['restricciones']; ?></textarea></td>
        </tr>
        <? } ?> 
        <? if($tipo=='aduana') { ?>      
        <tr>
            <td class="contenidotab">SUCURSAL</td>    
            <td><input id="sucursal" name="sucursal" class="tex1" value="<? if($_POST['sucursal']!='') print $_POST['sucursal']; else print $datosad['sucursal']; ?>" maxlength="50"></td>
        </tr>  
		

		
		 
        <tr>
            <td class="contenidotab">SITIOS DE OPERACION</td> 
            <td><textarea name="sitios_operacion" id="sitios_operacion" class="tex1"  cols="40" rows="7"><? if($_POST['sitios_operacion']!='') print $_POST['sitios_operacion']; else print $datosad['sitios_operacion']; ?></textarea></td>
        </tr>
        <? } ?>   
        <tr>
            <td class="contenidotab">OBSERVACIONES</td> 
            <td><textarea name="observaciones" id="observaciones" class="tex1"  cols="40" rows="7"><? if($_POST['observaciones']!='') print $_POST['observaciones']; else print $datosad['observaciones']; ?></textarea></td>
        </tr>
        <? if($tipo=='naviera' || $tipo=='coloader' || $tipo=='aerolinea') { ?>
         <tr>
            <td class="contenidotab" colspan="2" style="text-align:center">CONDICIONES FLETES<br><center><textarea name="condiciones_fletes" id="condiciones_fletes" cols="70" rows="7"><? if($_POST['condiciones_fletes']!='') print $_POST['condiciones_fletes']; else print $datosad['condiciones_fletes']; ?></textarea></center></td>
        </tr>
        <? }
		
		if($datosad['idproveedor_agente']!='')
		{
			$sql = "select * from adjuntos_proveedores where idproveedor='$datosad[idproveedor_agente]'";
			//print $sql.'<br>';
			$exe = mysqli_query ($sql);
			while($row = mysqli_fetch_array($exe))
			{
				?>
                <tr>
                <!--<td class="contenidotab" style="text-align:center" valign="top" colspan="2"><a href="./adjuntos_proveedores/<? print $row['nombre'];?>" target="_blank"><? print $row['nombre'].' subido por '.scai_get_name("$row[idusuario]","usuarios", "idusuario ", "nombre").' '.scai_get_name("$row[idusuario]","usuarios", "idusuario ", "apellido").' '.$row['fecha_creacion']; ?></a><a href="javascript:void(0);" onClick="validadjunto(formulario, '<? print $row['idadjunto']; ?>')"><img src="images/ico_eliminar.gif" border="0"></a></td>-->
                    <td class="contenidotab" style="text-align:center" valign="top" colspan="2"><a href="./doc/doc_proveedores/<? print $row['nombre'];?>" target="_blank"><? print $row['nombre'].' subido por '.scai_get_name("$row[idusuario]","usuarios", "idusuario ", "nombre").' '.scai_get_name("$row[idusuario]","usuarios", "idusuario ", "apellido").' '.$row['fecha_creacion']; ?></a><a href="javascript:void(0);" onClick="validadjunto(formulario, '<? print $row['idadjunto']; ?>')"><img src="images/ico_eliminar.gif" border="0"></a></td>
                    <td class="contenidotab" style="text-align:justify" valign="top"><? print $row['descripcion']; ?></td>
                </tr>
				<?
			}
		}
		?>
        <tr>
            <td class="contenidotab" colspan="2" style="text-align:center">ADJUNTO<br><input type="file" name="adjunto" id="adjunto" value="<? if($_POST['adjunto']!='') print $_POST['adjunto']; ?>" maxlength="50"></td>
        </tr>
        <tr>
            <td class="contenidotab" colspan="2" style="text-align:center">DESCRIPCI&Oacute;N ADJUNTO<br><center><textarea name="descripcion_adjunto" id="descripcion_adjunto" cols="70" rows="7"><? if($_POST['descripcion_adjunto']!='') print $_POST['descripcion_adjunto']; ?></textarea></center></td>
        </tr>
    </table>
    </div>
    </td>
    <tr>
    	<td bgcolor="#FEEFCF" colspan="4" height="4"></td>
    </tr>
    <tr>
    	<td align="center" class="subtitseccion" style="text-align:left" colspan="2"><a href="javascript:void(0);" class="subtitseccion" onClick="showmed11()">CONDICIONES GENERALES</a><br></td>
    </tr>
    	<td align="left" class="subtitseccion" colspan="2">
    	<div class="capa11">
    	<table width="100%" align="center">
            <tr>
                <td class="contenidotab">CREDITO</td>    
                <td><input id="credito" name="credito" class="tex1" value="<? if($_POST['credito']!='') print $_POST['credito']; else print $datosad2['credito']; ?>" maxlength="50" size="40"></td>
            <tr>
            </tr>
                <td class="contenidotab">CUPO MAXIMO</td>    
                <td><input id="cupo_max" name="cupo_max" class="tex1" value="<? if($_POST['cupo_max']!='') print $_POST['cupo_max']; else print $datosad2['cupo_max']; ?>" maxlength="50" size="40"></td>
            </tr>
                <td class="contenidotab">LIBERACION AUTOMATICA</td>    
                <td>
                    <select id="liberacion_auto" name="liberacion_auto" class="tex1" >
                        <option value="N"> Seleccione </option>
                        <?
                        if($_POST['liberacion_auto']!='N' && $_POST['liberacion_auto']!='')
                            $liberacion_auto = $_POST['liberacion_auto'];		
                        else
                        {	
                            $liberacion_auto = $datosad2['liberacion_auto'];  
                        } 
                        ?>  
                        <option value='1' <? if($liberacion_auto=='1') print 'selected'; ?> >Si</option>
                        <option value='0' <? if($liberacion_auto=='0') print 'selected'; ?> >No</option>
                    </select>
                </td>
            </tr>
    	</table>          
    </div>
</table>

<?
if($tipo=='coloader')
{
	$datosad['idcoloader'] = $datosad['idproveedor_agente']; 
	
	for($k=0; $k < 3; $k++)
	{
		if($k == 0)
		{
			$clasif = 'fcl';
			$capa = '15';
		}
		if($k == 1)
		{	
			$clasif = 'lcl';
			$capa = '16';
		}
		if($k == 2)	
		{
			$clasif = 'aereo';
			$capa = '17';
		}	
		?>
        <table width="100%" align="center">	
                <tr>
                    <td bgcolor="#FEEFCF" colspan="4" height="4"></td>
                </tr>
                <tr>
                    <td align="center" class="subtitseccion" style="text-align:left" colspan="7"><a href="javascript:void(0);" class="subtitseccion" onClick="showmed<? print $capa; ?>()">RECARGOS ORIGEN <? print strtoupper($clasif); ?></a><br></td>        
                </tr>
        </table> 
        
        <div class="capa<? print $capa; ?>">
      <table width="100%" align="center">
            <?
            $sqlrg = "select * from recargos_origen where clasificacion='$clasif'";
            //print $sqlrg .'<br>';
            $exerg = mysqli_query($link,$sqlrg);
            
            $sqlct="select * from coloader_origen where idcoloader='$datosad[idcoloader]' and clasificacion='$clasif'";
            //print $sqlct.'<br>';
            $exect =mysqli_query($link,$sqlct);
            $datosct = mysqli_fetch_array($exect);
            ?>
            
            <tr>
                <td class="tittabla">Recargo</td>
                <td class="tittabla">Tipo</td>
                <td class="tittabla">Valor</td>
                <td class="tittabla">Moneda</td>
                <td class="tittabla">Fecha de validez</td>
            </tr>
            <?
            while($datosrg = mysqli_fetch_array($exerg))
            {
                $totalhbl = 0;
                $totalcont = 0;
                $totalwm = 0;	
                $checked = '';
                
                $sqlr = "select idrecargo_origen from origen_por_coloader where idcoloader_origen = (select idcoloader_origen from coloader_origen where idcoloader='$datosad[idcoloader]' and clasificacion='$clasif')";
                
                //print $sqlr.'<br>';
                $exer = mysqli_query($link,$sqlr);
                while($datosr = mysqli_fetch_array($exer))
                {
                    if($datosr['idrecargo_origen'] == $datosrg['idrecargo_origen'])
                        $checked = 'checked';
        
                    if (scai_get_name("$datosr[idrecargo_origen]","recargos_origen", "idrecargo_origen", "tipo") == 'hbl')
                    {	
                        $valor = scai_get_name("$datosr[idrecargo_origen]", "recargos_origen", "idrecargo_origen", "valor");
                        //print $valor.'<br>';
                        $totalhbl = $totalhbl + $valor;
                    }
                    elseif(scai_get_name("$datosr[idrecargo_origen]","recargos_origen", "idrecargo_origen", "tipo") == 'cont')
                    {
                        $valor = scai_get_name("$datosr[idrecargo_origen]","recargos_origen", "idrecargo_origen", "valor");
                        //print $valor.'<br>';
                        $totalcont = $totalcont + $valor;
                    }
                    elseif(scai_get_name("$datosr[idrecargo_origen]","recargos_origen", "idrecargo_origen", "tipo") == 'wm')
                    {
                        $valor = scai_get_name("$datosr[idrecargo_origen]","recargos_origen", "idrecargo_origen", "valor");
                        //print $valor.'<br>';
                        $totalwm = $totalwm + $valor;
                    }
                }
                ?>
                <tr>
                    <td class="contenidotab">          
                          
                        <input id="recargo_origen<? print $datosrg['idrecargo_origen']; ?>" name="recargo_origen<? print $datosrg['idrecargo_origen']; ?>" type="checkbox" class="tex1" value="<? print $datosrg['valor']; ?>" <? print $checked; ?> onClick="addi_origen(this.value,this.name,'<? print $datosrg['tipo']; ?>', '<? print $clasif; ?>')" ><? print $datosrg['nombre'];?>
                    </td>
                    <td class="contenidotab"><? print $datosrg['tipo'];?></td>
                    <td class="contenidotab"><? print $datosrg['valor'];?></td>
                    <td class="contenidotab"><? print scai_get_name("$datosrg[moneda]","monedas", "idmoneda", "codigo"); ?></td>
                    <td class="contenidotab"><? print substr($datosrg['fecha_validez'],0 ,10); ?></td>
                    </td>
               </tr>
           <?
            }
            ?>	
            <!--<tr>
                <td class="contenidotab">Observaciones</td> 
                <td>
                    <textarea name="observaciones" id="observaciones" class="tex1"  cols="40" rows="3"><? print $datosct['observaciones']; ?></textarea>
                </td>
            </tr>-->  
        </table>        
        <table align="left">
            <tr>           
                <td align="center">
                    <?
                    $tpcon = 'text';
                    $tpwm = 'text';
                    $tphbl = 'text';
                    $tpaereo = 'text';
                    if($clasif=='fcl')
                    {
                        $tpwm = 'hidden';
                        $tpaereo = 'hidden';
                    }
                    elseif($clasif=='lcl')
                    {
                        $tpcon = 'hidden';
                        $tpaereo = 'hidden';
                    }
                    elseif($clasif=='aereo')
                    {
                        $tpwm = 'hidden';
                        $tpcon = 'hidden';
                        $tphbl = 'hidden';
                    }			
                    ?>
                    <input type="<? print $tpcon ?>" id="nombre_gastos_cont<? print $clasif; ?>" name="nombre_gastos_cont<? print $clasif; ?>" class="tex1" value="<? if($_POST['nombre_gastos_cont'.$clasif]!='') print $_POST['nombre_gastos_cont'.$clasif]; elseif($datosct['nombre_gastos_cont']=='') print 'GASTOS CONT(USD)'; else print $datosct['nombre_gastos_cont']; ?>" maxlength="50" size="40">
                    <input type="<? print $tpwm ?>" id="nombre_gastos_wm<? print $clasif; ?>" name="nombre_gastos_wm<? print $clasif; ?>" class="tex1" value="<? if($_POST['nombre_gastos_wm'.$clasif]!='') print $_POST['nombre_gastos_wm'.$clasif]; elseif($datosct['nombre_gastos_wm']=='') print 'GASTOS WM(USD)'; else print $datosct['nombre_gastos_wm']; ?>" maxlength="50" size="40">
                    
                    <input type="<? print $tpaereo ?>" id="nombre_gastos_hawb<? print $clasif; ?>" name="nombre_gastos_hawb<? print $clasif; ?>" class="tex1" value="<? if($_POST['nombre_gastos_hawb'.$clasif]!='') print $_POST['nombre_gastos_hawb'.$clasif]; elseif($datosct['nombre_gastos_hawb']=='') print 'GASTOS HAWB(USD)'; else print $datosct['nombre_gastos_hawb']; ?>" maxlength="50" size="40">                </td>
                <td align="center">
                    <input type="<? print $tpcon ?>" id="valor_gastos_cont<? print $clasif; ?>" name="valor_gastos_cont<? print $clasif; ?>" class="tex2" value="<? if($_POST['valor_gastos_cont'.$clasif]!='') print $_POST['valor_gastos_cont'.$clasif]; elseif($datosct['valor_gastos_cont']=='') print '0'; else print $datosct['valor_gastos_cont']; ?>" maxlength="50" size="40">
                    <input type="<? print $tpwm ?>" id="valor_gastos_wm<? print $clasif; ?>" name="valor_gastos_wm<? print $clasif; ?>" class="tex2" value="<? if($_POST['valor_gastos_wm'.$clasif]!='') print $_POST['valor_gastos_wm'.$clasif]; elseif($datosct['valor_gastos_wm']=='') print '0'; else print $datosct['valor_gastos_wm']; ?>" maxlength="50" size="40">
                    
                    <input type="<? print $tpaereo ?>" id="valor_gastos_hawb<? print $clasif; ?>" name="valor_gastos_hawb<? print $clasif; ?>" class="tex2" value="<? if($_POST['valor_gastos_hawb'.$clasif]!='') print $_POST['valor_gastos_hawb'.$clasif]; elseif($datosct['valor_gastos_hawb']=='') print '0'; else print $datosct['valor_gastos_hawb']; ?>" maxlength="50" size="40">                </td>
            </tr> 
                <td align="center"><input type="<? print $tphbl ?>" id="nombre_gastos_hbl<? print $clasif; ?>" name="nombre_gastos_hbl<? print $clasif; ?>" class="tex1" value="<? if($_POST['nombre_gastos_hbl'.$clasif]!='') print $_POST['nombre_gastos_hbl'.$clasif]; elseif($datosct['nombre_gastos_hbl']=='') print 'GASTOS HBL(USD)'; else print $datosct['nombre_gastos_hbl']; ?>" maxlength="50" size="40">
                  <input type="<? print $tpaereo ?>" id="nombre_gastos_embarque<? print $clasif; ?>" name="nombre_gastos_embarque<? print $clasif; ?>" class="tex1" value="<? if($_POST['nombre_gastos_embarque'.$clasif]!='') print $_POST['nombre_gastos_embarque'.$clasif]; elseif($datosct['nombre_gastos_embarque']=='') print 'GASTOS EMBARQUE(USD)'; else print $datosct['nombre_gastos_embarque']; ?>" maxlength="50" size="40">                </td>
                <td align="center">	
                    <input type="<? print $tphbl ?>" id="valor_gastos_hbl<? print $clasif; ?>" name="valor_gastos_hbl<? print $clasif; ?>" class="tex2" value="<? if($_POST['valor_gastos_hbl'.$clasif]!='') print $_POST['valor_gastos_hbl'.$clasif]; elseif($datosct['valor_gastos_hbl']=='') print '0'; else print $datosct['valor_gastos_hbl']; ?>" maxlength="50" size="40">
                    
                    <input type="<? print $tpaereo ?>" id="valor_gastos_embarque<? print $clasif; ?>" name="valor_gastos_embarque<? print $clasif; ?>" class="tex2" value="<? if($_POST['valor_gastos_embarque'.$clasif]!='') print $_POST['valor_gastos_embarque'.$clasif]; elseif($datosct['valor_gastos_embarque']=='') print '0'; else print $datosct['valor_gastos_embarque']; ?>" maxlength="50" size="40">                </td>
            </tr>
        </table>
  </div>
        <?
}
?>
<br>
<?
for($k=0; $k < 3; $k++)
{
	if($k == 0)
	{
		$clasif = 'fcl';
		$capa = '12';
	}
	if($k == 1)
	{	
		$clasif = 'lcl';
		$capa = '13';
	}
	if($k == 2)	
	{
		$clasif = 'aereo';
		$capa = '131';
	}	
	?>
    <table width="100%" align="center">	
        <tr>
            <td bgcolor="#FEEFCF" colspan="4" height="4"></td>
        </tr>
        <tr>
            <td align="center" class="subtitseccion" style="text-align:left" colspan="7"><a href="javascript:void(0);" class="subtitseccion" onClick="showmed<? print $capa; ?>()">RECARGOS LOCALES <? print strtoupper($clasif); ?></a><br></td>        
        </tr>
    </table> 
    <div class="capa<? print $capa; ?>">  
	<?
    if($clasif=='fcl')
    {
        $tipo2 = 'tipo';
        $idtipo = 'idtipo';
    }
    elseif($clasif=='lcl')
    {
        $tipo2 = 'tipo_lcl';
        $idtipo = 'idtipo_lcl';
    }
    $sqlidt = "select distinct idtarifario from tarifario where clasificacion='$clasif'";
    //print $sqlidt.'<br>';
    if($clasif=='aereo')
        $sqlidt = "select distinct idtarifario_aereo as idtarifario from tarifario_aereo";
    //print $sqlidt .'<br>';
    $exeidt = mysqli_query($link,$sqlidt);
    
    $cad_idtar = '';
    while($datosidt = mysqli_fetch_array($exeidt))
    {
        if($cad_idtar != '')
            $cad_idtar .= ',';
        $cad_idtar .= " '".$datosidt['idtarifario'] ."'";		
    }
    
    if($cad_idtar == '')//si esta vacio adiciona el id cero
        $cad_idtar = "'0'";
    
    $sqlnav = "select distinct idnaviera from tarifario where idtarifario in ($cad_idtar)";
    if($clasif=='aereo')
        $sqlnav = "select distinct idaerolinea as idnaviera from tarifario_aereo where idtarifario_aereo in ($cad_idtar)";
    //print $sqlnav .'<br>';
    $exenav = mysqli_query($link,$sqlnav);

    while($datosnav = mysqli_fetch_array($exenav))	
    {	
        $sqlrg = "select * from recargos_local where clasificacion='$clasif' and idnaviera='$datosnav[idnaviera]'";
        //print $sqlrg .'<br>';
        $exerg = mysqli_query($link,$sqlrg);
        $filasrg = mysqli_num_rows($exerg);
        //print 'filasrg '.$filasrg.'<br>';
        
        $sqlct="select * from coloader_local where idcoloader='$datosad[idcoloader]'";
        //print $sqlct.'<br>';
        $exect =mysqli_query($link,$sqlct);
        $datosct = mysqli_fetch_array($exect);
        
        if($filasrg > 0)
        {
            $sqltct = "select * from totales_coloader_local where idcoloader_local='$datosct[idcoloader_local]' and idnaviera='$datosnav[idnaviera]'";
            //print $sqtct.'<br>';
            $exetct = mysqli_query($link,$sqltct);
            $datostct = mysqli_fetch_array($exetct);
            ?> 
            <table width="100%" align="center">            
            <tr>
                <td class="tittabla" colspan="6">REF<? print $datosnav['idnaviera'].': '.scai_get_name("$datosnav[idnaviera]","proveedores_agentes", "idproveedor_agente", "nombre") ?></td>
            </tr>   
            <tr>
                <td class="tittabla">Recargo</td>
                <td class="tittabla">Tipo</td>
                <td class="tittabla">Valor($)</td>
                <td class="tittabla">Minimo($)</td>
                <td class="tittabla">Moneda</td>
                <td class="tittabla">Fecha de validez</td>
            </tr>
            <?
            while($datosrg = mysqli_fetch_array($exerg))
            {
                $checked = '';
                
                $sqlr = "select idrecargo_local from local_por_coloader where idcoloader='$datosad[idcoloader]' and idrecargo_local in (select idrecargo_local from recargos_local where idnaviera='$datosnav[idnaviera]')";
                //print $sqlr.'<br>';
                $exer = mysqli_query($link,$sqlr);
                while($datosr = mysqli_fetch_array($exer))
                {
                    if($datosr['idrecargo_local'] == $datosrg['idrecargo_local'])
                        $checked = 'checked';
                }
                
                $sqlv = "select * from local_por_coloader where idcoloader='$datosad[idcoloader]' and idrecargo_local='$datosrg[idrecargo_local]'";
                //print $sqlv.'<br>';
                $exev = mysqli_query($link,$sqlv);
                $datosv = mysqli_fetch_array($exev);
                ?>
                <tr>
                    <td class="contenidotab">                
                        <input id="recargo<? print $datosrg['idrecargo_local']; ?>" name="recargo<? print $datosrg['idrecargo_local']; ?>" type="checkbox" class="tex1" value="<? print $datosrg['idrecargo_local']; ?>" <? print $checked; ?> onClick="addi(this.value,this.name,'<? print $datosrg['tipo']; ?>','<? print $datosrg['idnaviera']; ?>','<? print $datosrg['clasificacion']; ?>')" ><? print 'recargo'.$datosrg['idrecargo_local']; ?> - <? print $datosrg['nombre'];?>
                    </td>
                    <td class="contenidotab"><? print $datosrg['tipo'];?></td>
                    
                    <?
                    $sqlcad = "select * from recargos_local where clasificacion='$datosrg[clasificacion]' and idnaviera='$datosrg[idnaviera]' and tipo='$datosrg[tipo]'";
                    //print $sqlcad .'<br>';
                    $execad = mysqli_query($link,$sqlcad);
                    $cad_rg = '';
                    while($datoscad = mysqli_fetch_array($execad))
                    {
                        if($cad_rg != '')
                            $cad_rg .= ',';
                        $cad_rg .= $datoscad['idrecargo_local'];
                    }
                    ?>
                    
                    <td class="contenidotab">
                        <? $msg = 'Valor compra: '.$datosrg['valor'].'<br>Margen: '.$datosrg['margen']; ?>
                        <!--<input type="text" id="valor_venta<? print $datosrg['idrecargo_local']; ?>" name="valor_venta<? print $datosrg['idrecargo_local']; ?>" class="tex2" value="<? if($datosv['valor_venta']=='') { if($datosrg['valor_venta']=='') print '0'; else print $datosrg['valor_venta']; } else print $datosv['valor_venta']; ?>" onBlur="addi('<? print $datosrg['idrecargo_local']; ?>','<? print 'recargo'.$datosrg['idrecargo_local']; ?>','<? print $datosrg['tipo']; ?>','<? print $datosrg['idnaviera']; ?>','<? print $datosrg['clasificacion']; ?>')" maxlength="20" size="3" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" onChange="limpiar('<? print $datosrg['tipo']; ?>', '<? print $cad_rg; ?>', '<? print $datosrg['idnaviera']; ?>');" />-->
                        <input type="text" id="valor_venta<? print $datosrg['idrecargo_local']; ?>" name="valor_venta<? print $datosrg['idrecargo_local']; ?>" class="tex2" value="<? if($_POST['valor_venta'.$datosrg['idrecargo_local']]!='') print $_POST['valor_venta'.$datosrg['idrecargo_local']]; elseif($datosv['valor_venta']=='') { if($datosrg['valor_venta']=='') print '0'; else print $datosrg['valor_venta']; } else print $datosv['valor_venta']; ?>" maxlength="20" size="3" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" onChange="limpiar('<? print $datosrg['tipo']; ?>', '<? print $cad_rg; ?>', '<? print $datosrg['idnaviera']; ?>');" />
                    </td>
                    <td class="contenidotab">
                        <? $msg = 'Minimo compra: '.$datosrg['minimo'].'<br>Margen: '.$datosrg['margen_minimo']; ?>
                        <input type="text" id="minimo_venta<? print $datosrg['idrecargo_local']; ?>" name="minimo_venta<? print $datosrg['idrecargo_local']; ?>" class="tex2" value="<? if($_POST['minimo_venta'.$datosrg['idrecargo_local']]!='') print $_POST['minimo_venta'.$datosrg['idrecargo_local']]; elseif($datosv['minimo_venta']=='') {if($datosrg['minimo_venta']=='') print '0'; print $datosrg['minimo_venta']; } else print $datosv['minimo_venta']; ?>" maxlength="20" size="3" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" />
                    </td>
                    <td class="contenidotab"><? print scai_get_name("$datosrg[moneda]","monedas", "idmoneda", "codigo"); ?></td>
                    <td class="contenidotab"><? print substr($datosrg['fecha_validez'],0 ,10); ?></td>
                    </td>
                </tr>
                <?
            }
            ?>
            </table>
            <table width="60%" align="center">
            <?     
            $sqltct = "select * from totales_coloader_local where idcoloader_local='$datosct[idcoloader_local]' and idnaviera='$datosnav[idnaviera]'";
            //print $sqtct.'<br>';
            $exetct = mysqli_query($link,$sqltct);
            $datostct = mysqli_fetch_array($exetct);

            $tpcon = 'text';
            $tpwm = 'text';
            $tphbl = 'text';
            $tpaereo = 'text';
            if($clasif=='fcl')
            {
                $tpwm = 'hidden';
                $tpaereo = 'hidden';
            }
            elseif($clasif=='lcl')
            {
                $tpcon = 'hidden';
                $tpaereo = 'hidden';
            }
            elseif($clasif=='aereo')
            {
                $tpwm = 'hidden';
                $tpcon = 'hidden';
                $tphbl = 'hidden';
            }			
            ?>
            <tr>
                <td align="center">
                    <input type="<? print $tpcon ?>" id="nombre_gastos_cont<? print $datosnav['idnaviera']; ?>" name="nombre_gastos_cont<? print $datosnav['idnaviera']; ?>" class="tex1" value="<? if($_POST['nombre_gastos_cont'.$datosnav['idnaviera']]!='') print $_POST['nombre_gastos_cont'.$datosnav['idnaviera']]; elseif($datostct['nombre_gastos_cont']=='') print 'GASTOS CONT(USD)'; else print $datostct['nombre_gastos_cont']; ?>" maxlength="50" size="40">
                    <input type="<? print $tpwm ?>" id="nombre_gastos_wm<? print $datosnav['idnaviera']; ?>" name="nombre_gastos_wm<? print $datosnav['idnaviera']; ?>" class="tex1" value="<? if($_POST['nombre_gastos_wm'.$datosnav['idnaviera']]!='') print $_POST['nombre_gastos_wm'.$datosnav['idnaviera']]; elseif($datostct['nombre_gastos_wm']=='') print 'GASTOS WM(USD)'; else print $datostct['nombre_gastos_wm']; ?>" maxlength="50" size="40">
                    
                    <input type="<? print $tpaereo ?>" id="nombre_gastos_hawb<? print $datosnav['idnaviera']; ?>" name="nombre_gastos_hawb<? print $datosnav['idnaviera']; ?>" class="tex1" value="<? if($_POST['nombre_gastos_hawb'.$datosnav['idnaviera']]!='') print $_POST['nombre_gastos_hawb'.$datosnav['idnaviera']]; elseif($datostct['nombre_gastos_hawb']=='') print 'GASTOS HAWB(USD)'; else print $datostct['nombre_gastos_hawb']; ?>" maxlength="50" size="40">
              </td>
              <td align="center">
                    <input type="<? print $tpcon ?>" id="valor_gastos_cont<? print $datosnav['idnaviera']; ?>" name="valor_gastos_cont<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($_POST['valor_gastos_cont'.$datosnav['idnaviera']]!='') print $_POST['valor_gastos_cont'.$datosnav['idnaviera']]; elseif($datostct['valor_gastos_cont']=='') print '0'; else print $datostct['valor_gastos_cont']; ?>" maxlength="50" size="40" >
                   
                    <input type="<? print $tpwm ?>" id="valor_gastos_wm<? print $datosnav['idnaviera']; ?>" name="valor_gastos_wm<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($_POST['valor_gastos_wm'.$datosnav['idnaviera']]!='') print $_POST['valor_gastos_wm'.$datosnav['idnaviera']]; elseif($datostct['valor_gastos_wm']=='') print '0'; else print $datostct['valor_gastos_wm']; ?>" maxlength="50" size="40" >
                    
                    <input type="<? print $tpaereo ?>" id="valor_gastos_hawb<? print $datosnav['idnaviera']; ?>" name="valor_gastos_hawb<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($_POST['valor_gastos_hawb'.$datosnav['idnaviera']]!='') print $_POST['valor_gastos_hawb'.$datosnav['idnaviera']]; elseif($datostct['valor_gastos_hawb']=='') print '0'; else print $datostct['valor_gastos_hawb']; ?>" maxlength="50" size="40" >
                </td>
            </tr> 
                <td align="center">
                    <input type="<? print $tphbl ?>" id="nombre_gastos_hbl<? print $datosnav['idnaviera']; ?>" name="nombre_gastos_hbl<? print $datosnav['idnaviera']; ?>" class="tex1" value="<? if($_POST['nombre_gastos_hbl'.$datosnav['idnaviera']]!='') print $_POST['nombre_gastos_hbl'.$datosnav['idnaviera']]; elseif($datostct['nombre_gastos_hbl']=='') print 'GASTOS HBL(USD)'; else print $datostct['nombre_gastos_hbl']; ?>" maxlength="50" size="40">
                    
                    <input type="<? print $tpaereo ?>" id="nombre_gastos_embarque<? print $datosnav['idnaviera']; ?>" name="nombre_gastos_embarque<? print $datosnav['idnaviera']; ?>" class="tex1" value="<? if($_POST['nombre_gastos_embarque'.$datosnav['idnaviera']]!='') print $_POST['nombre_gastos_embarque'.$datosnav['idnaviera']]; elseif($datostct['nombre_gastos_embarque']=='') print 'GASTOS EMBARQUE(USD)'; else print $datostct['nombre_gastos_embarque']; ?>" maxlength="50" size="40">
                 </td>
                <td align="center">	
                    <input type="<? print $tphbl ?>" id="valor_gastos_hbl<? print $datosnav['idnaviera']; ?>" name="valor_gastos_hbl<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($_POST['valor_gastos_hbl'.$datosnav['idnaviera']]!='') print $_POST['valor_gastos_hbl'.$datosnav['idnaviera']]; elseif($datostct['valor_gastos_hbl']=='') print '0'; else print $datostct['valor_gastos_hbl']; ?>" maxlength="50" size="40" >
                    
                    <input type="<? print $tpaereo ?>" id="valor_gastos_embarque<? print $datosnav['idnaviera']; ?>" name="valor_gastos_embarque<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($_POST['valor_gastos_embarque'.$datosnav['idnaviera']]!='') print $_POST['valor_gastos_embarque'.$datosnav['idnaviera']]; elseif($datostct['valor_gastos_embarque']=='') print '0'; else print $datostct['valor_gastos_embarque']; ?>" maxlength="50" size="40" >
                </td>
            </tr>
            <tr>
                <td class="contenidotab" align="center"><!--<input id="mostrar_collection_fee<? print $datosnav['idnaviera']; ?>" name="mostrar_collection_fee<? print $datosnav['idnaviera']; ?>" type="checkbox" class="tex1" value="1" <? if($datostct['mostrar_collection_fee']=='1') print 'checked'; ?> onChange="refrescar(formulario);" >-->Collection Fee(%)</td>
                <?
                $idp = '19';
                $sql = "select * from parametros where idparametro='$idp'";
                //print $sql.'<br>';
                $exe = mysqli_query($link,$sql);
                $cond = mysqli_fetch_array($exe);
                ?>
                <td align="center">                	
                            <input id="collection_fee<? print $datosnav['idnaviera']; ?>" name="collection_fee<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($_POST['collection_fee'.$datosnav['idnaviera']]!='') print $_POST['collection_fee'.$datosnav['idnaviera']]; elseif($datostct['collection_fee']=='') print $cond['valor']; else print $datostct['collection_fee']; ?>" maxlength="50" size="40" >
                </td>
            </tr>
            <tr>
                <td class="contenidotab" align="center">Minimo Collection Fee($)</td>
                <?
                $idp = '20';
                $sql = "select * from parametros where idparametro='$idp'";
                //print $sql.'<br>';
                $exe = mysqli_query($link,$sql);
                $cond = mysqli_fetch_array($exe);
                ?>
                <td align="center">                	
                            <input id="min_collection_fee<? print $datosnav['idnaviera']; ?>" name="min_collection_fee<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($_POST['min_collection_fee'.$datosnav['idnaviera']]!='') print $_POST['min_collection_fee'.$datosnav['idnaviera']]; elseif($datostct['min_collection_fee']=='') print $cond['valor']; else print $datostct['min_collection_fee']; ?>" maxlength="50" size="40" >
                </td>
            </tr>
            <tr>
                <td class="contenidotab" align="center"><!--<input id="mostrar_caf<? print $datosnav['idnaviera']; ?>" name="mostrar_caf<? print $datosnav['idnaviera']; ?>" type="checkbox" class="tex1" value="1" <? if($datostct['mostrar_caf']=='1') print 'checked'; ?> onChange="refrescar(formulario);" >-->CAF(%)</td>
                <?
                $idp = '21';
                $sql = "select * from parametros where idparametro='$idp'";
                //print $sql.'<br>';
                $exe = mysqli_query($link,$sql);
                $cond = mysqli_fetch_array($exe);
                ?>
                <td align="center">                	
                            <input id="caf<? print $datosnav['idnaviera']; ?>" name="caf<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($_POST['caf'.$datosnav['idnaviera']]!='') print $_POST['caf'.$datosnav['idnaviera']]; elseif($datostct['caf']=='') print $cond['valor']; else print $datostct['caf']; ?>" maxlength="50" size="40" >
                </td>
            </tr>
            <tr>
                <td class="contenidotab" align="center">Minimo CAF($)</td>
                <?
                $idp = '22';
                $sql = "select * from parametros where idparametro='$idp'";
                //print $sql.'<br>';
                $exe = mysqli_query($link,$sql);
                $cond = mysqli_fetch_array($exe);
                ?>
                <td align="center">                	
                            <input id="min_caf<? print $datosnav['idnaviera']; ?>" name="min_caf<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($_POST['min_caf'.$datosnav['idnaviera']]!='') print $_POST['min_caf'.$datosnav['idnaviera']]; elseif($datostct['min_caf']=='') print $cond['valor']; else print $datostct['min_caf']; ?>" maxlength="50" size="40" >
                </td>
            </tr>
            <?
            if($clasif=='lcl')
            {
                ?>
                <tr>
                    <td class="contenidotab" colspan="2">PARA MINIMAS</td>
                </tr>
                <tr>   
                    <td class="contenidotab" align="center">Mostrar rangos</td>
                    <td align="center">
                    <!--<input id="mostrar_rangos<? print $datosnav['idnaviera']; ?>" name="mostrar_rangos<? print $datosnav['idnaviera']; ?>" type="checkbox" class="tex1" value="1" <? if($datostct['mostrar_rangos']=='1') print 'checked'; ?> onChange="refrescar(formulario);" <? if($datostct['mostrar_var']=='1') print 'disabled'; ?> >-->
                    </td>
                </tr>
                <tr>
                    <td class="contenidotab"><? if($datostct['nombre_gastos_wm']=='') print 'GASTOS WM'; else print $datostct['nombre_gastos_wm']; ?></td>
                    <td align="center">                	
                        <input id="valor_gastos_wm_min<? print $datosnav['idnaviera']; ?>" name="valor_gastos_wm_min<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($datostct['valor_gastos_wm_min']=='') print '0'; else print $datostct['valor_gastos_wm_min']; ?>" maxlength="50" size="40" readonly >
                    </td>
                </tr> 
                <tr>
                    <td class="contenidotab"><? if($datostct['nombre_gastos_hbl']=='') print 'GASTOS HBL'; else print $datostct['nombre_gastos_hbl']; ?></td>
                    <td align="center">	
                      <input id="valor_gastos_hbl_min<? print $datosnav['idnaviera']; ?>" name="valor_gastos_hbl_min<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($datostct['valor_gastos_hbl_min']=='') print '0'; else print $datostct['valor_gastos_hbl_min']; ?>" maxlength="50" size="40" readonly >
                    </td>
                </tr>
                <tr>
                    <td class="contenidotab" colspan="2">PARA 5 WM</td>
                </tr>
                <tr>
                    <td class="contenidotab"><? if($datostct['nombre_gastos_wm']=='') print 'GASTOS WM'; else print $datostct['nombre_gastos_wm']; ?></td>
                    <td align="center">                	
                        <input id="valor_gastos_wm_min5<? print $datosnav['idnaviera']; ?>" name="valor_gastos_wm_min5<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($datostct['valor_gastos_wm_min5']=='') print '0'; else print $datostct['valor_gastos_wm_min5']; ?>" maxlength="50" size="40" readonly >
                    </td>
                </tr> 
                <tr>
                    <td class="contenidotab"><? if($datostct['nombre_gastos_hbl']=='') print 'GASTOS HBL'; else print $datostct['nombre_gastos_hbl']; ?></td>
                    <td align="center">	
                      <input id="valor_gastos_hbl_min5<? print $datosnav['idnaviera']; ?>" name="valor_gastos_hbl_min5<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($datostct['valor_gastos_hbl_min5']=='') print '0'; else print $datostct['valor_gastos_hbl_min5']; ?>" maxlength="50" size="40" readonly >
                    </td>
                </tr>
                <tr>
                    <td class="contenidotab" colspan="2">PARA 10 WM</td>
                </tr>
                <tr>
                    <td class="contenidotab"><? if($datostct['nombre_gastos_wm']=='') print 'GASTOS WM'; else print $datostct['nombre_gastos_wm']; ?></td>
                    <td align="center">                	
                        <input id="valor_gastos_wm_min10<? print $datosnav['idnaviera']; ?>" name="valor_gastos_wm_min10<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($datostct['valor_gastos_wm_min10']=='') print '0'; else print $datostct['valor_gastos_wm_min10']; ?>" maxlength="50" size="40" readonly >
                    </td>
                </tr> 
                <tr>
                    <td class="contenidotab"><? if($datostct['nombre_gastos_hbl']=='') print 'GASTOS HBL'; else print $datostct['nombre_gastos_hbl']; ?></td>
                    <td align="center">	
                      <input id="valor_gastos_hbl_min10<? print $datosnav['idnaviera']; ?>" name="valor_gastos_hbl_min10<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($datostct['valor_gastos_hbl_min10']=='') print '0'; else print $datostct['valor_gastos_hbl_min10']; ?>" maxlength="50" size="40" readonly >
                    </td>
                </tr>
                <tr>
                    <td class="contenidotab" colspan="2">PARA 15 WM</td>
                </tr>
                <tr>
                    <td class="contenidotab"><? if($datostct['nombre_gastos_wm']=='') print 'GASTOS WM'; else print $datostct['nombre_gastos_wm']; ?></td>
                    <td align="center">                	
                        <input id="valor_gastos_wm_min15<? print $datosnav['idnaviera']; ?>" name="valor_gastos_wm_min15<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($datostct['valor_gastos_wm_min15']=='') print '0'; else print $datostct['valor_gastos_wm_min15']; ?>" maxlength="50" size="40" readonly >
                    </td>
                </tr> 
                <tr>
                    <td class="contenidotab"><? if($datostct['nombre_gastos_hbl']=='') print 'GASTOS HBL'; else print $datostct['nombre_gastos_hbl']; ?></td>
                    <td align="center">	
                      <input id="valor_gastos_hbl_min15<? print $datosnav['idnaviera']; ?>" name="valor_gastos_hbl_min15<? print $datosnav['idnaviera']; ?>" class="tex2" value="<? if($datostct['valor_gastos_hbl_min15']=='') print '0'; else print $datostct['valor_gastos_hbl_min15']; ?>" maxlength="50" size="40" readonly >
                    </td>
                </tr>
                <?
            }
            ?>
        </table>
            <?
            }
        }	
        ?>
        <!--<table width="100%" align="center"> 	
            <tr>
                <td class="contenidotab">Observaciones</td> 
                <td>
                    <textarea name="observaciones" id="observaciones" class="tex1"  cols="40" rows="3"><? print $datosct['observaciones']; ?></textarea>
                </td>
            </tr>  
        </table>-->
    </div>
    <?
}
}
?>

<br><?
	$_POST['idproveedor_agente'] = $_GET['idproveedor_agente'];
?>	

<table width="100%" align="center">
	<tr>
    	<td bgcolor="#FEEFCF" colspan="4" height="4"></td>
    </tr>    
    <tr>
    	<td align="center" class="subtitseccion" style="text-align:left" colspan="4"><a href="javascript:void(0);" class="subtitseccion" onclick="showmed14()">CONTACTOS <? print strtoupper($tipo); ?></a><br><br></td>
    </tr>
	<tr>
    	<td colspan="4" height="100%" >
        	<div class="capa14" style="display:">
				<iframe src="contactos_proveedores.php?idproveedor_agente=<? print $_POST['idproveedor_agente'] ?>&tipo=<? print $tipo ?>" width="100%" height="700" scrolling="no" frameborder="0"></iframe>
 </div>
    	</td>
	</tr>
</table>
<br>
<table width="100%" align="center"> 
	<tr>
    	<td>
            <table>
                <tr>
                	<?
					if ($_GET['idproveedor_agente'] != '')
					{
						if(puedo("m","PROVEEDORES")==1) { ?>
                        <td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
                        <? 
						} 
                    }
					elseif ($_GET['idproveedor_agente'] == '')
					{
						if(puedo("c","PROVEEDORES")==1) { ?> 
                        <td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
                     	<? 
						} 
                    } 
					?>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                        
					<? if ($_GET['idproveedor_agente'] != '') 
					{
						if(puedo("e","PROVEEDORES")==1) { ?> 
                        <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="eliminaActual(formulario)">Eliminar</a></td> 
                    <? }
					}
					if(puedo("c","PROVEEDORES")==1) { ?>
                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="borrar(formulario)" >Nuevo</a></td>
                    <? } ?>
				</tr>
			</table>
    	</td>
	</tr>
</table>
    
       
</form>
</body>   