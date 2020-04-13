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
		elements : "presentacion",
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
	var seleccionado = 0;

	//if(document.getElementById('registroSel').length <= 1 || document.getElementById('registroSel').length == null)
	if(form.registroSel.length <= 1 || form.registroSel.length == null)
	{
		//if(document.getElementById('registroSel').checked==true)
		if(form.registroSel.checked==true)
		{
			seleccionado = seleccionado + 1;
		}
	}	
	else
	{
		//for(var n = 0; n < document.getElementById('registroSel').length; n++)
		for(var n = 0; n < form.registroSel.length; n++)
		{
			//if(document.getElementById('registroSel')[n].checked==true)
			if(form.registroSel[n].checked==true)
			{
				seleccionado = seleccionado + 1;
			}
		}
	}
	
	//alert('seleccionado ' + seleccionado + ' nombre ' + document.getElementById('nombre_con').value + ' cargo ' + document.getElementById('cargo').value);
	if(seleccionado == 0)
	{
		if (validarTexto('nombre_con', 'Por favor ingrese el nombre') == false) return false;
		if (validarTexto('cargo', 'Por favor ingrese el cargo') == false) return false;
		if (validarTexto('email', 'Por favor ingrese el email') == false) return false;
		if (valmail('email', 'Por favor ingrese un email valido') == false) return false;
	}
	
	if(seleccionado > 0 && (document.getElementById('nombre_con').value!='' || document.getElementById('cargo').value!='' || document.getElementById('email').value!=''))
	{
		if (validarTexto('nombre_con', 'Por favor ingrese el nombre') == false) return false;
		if (validarTexto('cargo', 'Por favor ingrese el cargo') == false) return false;
		if (validarTexto('email', 'Por favor ingrese el email') == false) return false;
		if (valmail('email', 'Por favor ingrese un email valido') == false) return false;
	}
	
	if (validarTexto('ciudad_con', 'Por favor ingrese la ciudad') == false) return false;
	if (validarTexto('presentacion', 'Por favor ingrese el texto de presentacion') == false) return false;
	
	form.datosok.value="si";
	form.submit()
}

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
}

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
$sqlrn = "select idreporte from reporte_negocios where idcot_temp='$_GET[idcot_temp]'";
$exern = mysqli_query($link,$sqlrn);
$filasrn = mysqli_num_rows($exern);

if($_POST['datosok']=='si')
{
	if(!isset($_GET['idcot_temp']) || $_GET['idcot_temp'] == '')
	{
		$queryins="INSERT INTO $tabla (idcontacto_todos, idcliente, idusuario, clasificacion, numero, nombre, cargo, email, ciudad, fecha_hora, presentacion) VALUES('$_POST[registroSel]','$_POST[idcliente]', '$_SESSION[numberid]', '$_GET[cl]', UCASE('$_POST[numero]'), UCASE('$_POST[nombre_con]'), UCASE('$_POST[cargo]'), '$_POST[email]', UCASE('$_POST[ciudad_con]'), NOW(), '$_POST[presentacion]')";
		//print $queryins.'<br>';
		$buscarins=mysqli_query($link,$queryins);
		
		$sqlast = "SELECT LAST_INSERT_ID() ultimo FROM $tabla";	
		$querylast = mysqli_query($link,$sqlast);		
		$row = mysqli_fetch_array($querylast);
		$idcot_temp = $row['ultimo'];
					
		if(!$buscarins){
			print ("<script>alert('No se pudo ingresar el registro.')</script>");

		}else
		{
			$numero = scai_get_name("$_SESSION[numberid]","usuarios", "idusuario", "codigo").$idcot_temp;
			$queryins="update $tabla set numero='$numero' where idcot_temp='$idcot_temp'";
			$buscarins=mysqli_query($link,$queryins);
		
			?><script>document.location='cotizador.php?idcot_temp=<? print $idcot_temp?>&cl=<? print $_GET['cl'] ?>';</script><?	
		}
	}
	elseif(isset($_GET['idcot_temp']) || $_GET['idcot_temp']!='')
	{
		$queryins="update $tabla set idcontacto_todos='$_POST[registroSel]', idcliente='$_POST[idcliente]', idusuario='$_SESSION[numberid]', nombre= UCASE('$_POST[nombre_con]'), cargo=UCASE('$_POST[cargo]'), email='$_POST[email]', ciudad=UCASE('$_POST[ciudad_con]'), presentacion='$_POST[presentacion]' where idcot_temp='$_GET[idcot_temp]'";
		//print $queryins.'<br>';
		$buscarins=mysqli_query($link,$queryins);
		
		if(!$buscarins)
			print ("<script>alert('No se pudo modificar el registro')</script>");
		else
		{
			?><script>document.location='cotizador.php?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl'] ?>';</script><?	
		}
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

if(isset($_GET['idcot_temp']) || $_GET['idcot_temp']!='')
{
	$_GET['idcliente'] = scai_get_name("$_GET[idcot_temp]","cot_temp", "idcot_temp", "idcliente");
	
	$sqlad2 = "select * from $tabla where $llave='$_GET[idcot_temp]'";
	//print $sqlad2.'<br>';
	$exead2 = mysqli_query($link,$sqlad2);
	$datosad2 = mysqli_fetch_array($exead2);
}

if(isset($_POST['idcliente']) && $_POST['idcliente']!='')
	$_GET['idcliente'] == $_POST['idcliente'];	
?>

<body style="background-color: transparent;">
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
		//print $sqlad.'<br>';
		$exead = mysqli_query($link,$sqlad);
		$datosad = mysqli_fetch_array($exead);
		
		?><script>validaPais(document.getElementByName('formulario'));</script><?
	}
?>
<?
if(isset($_GET['xyz']) and $_GET['xyz']!="")
	$_POST['xyz'] = $_GET['xyz'];
	if(isset($_POST['xyz']) and $_POST['xyz']!="")
	{
		$sql = "SELECT * FROM clientes WHERE nombre LIKE '%$_POST[xyz]%'";
		//print $sql.'<br>';
		$query = mysqli_query($link,$sql);
		$filas = mysqli_num_rows($query);
		if ($filas == 0)
			print ("<script>alert('Este cliente no existe vuelva a intentarlo')</script>");
		else
		{
			if ($filas == 1)
			{
				$row = mysqli_fetch_array($query);
				print ("<script>document.location.href='".$_SERVER['PHP_SELF']."?idcliente=$row[idcliente]&cl=$_GET[cl]'</script>");
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
							print "<a href=".$_SERVER['PHP_SELF']."?idcliente=$row[idcliente]&cl=$_GET[cl]>$row[nombre]</a><br>";
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
	}
if($_GET['idcot_temp']!='')
{
	?> 
	<table border="0" width="100%">
		<tr>
			<td align="center">
				<span class="contenidotab" style="font-size:14px;" style="color:#666666"><a href="cotizador.php?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl']?>">Paso 2: Seleccionar fletes</a>|<a href="tarif_recargos_origen.php?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl']?>">Paso 3: Cotizar recargos de origen</a>|<a href="tarif_recargos_local.php?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl']?>">Paso 4: Cotizar recargos locales</a>|<a href="paso5_final.php?idcot_temp=<? print $_GET['idcot_temp']?>&cl=<? print $_GET['cl']?>">Paso 5: Finalizar</a></span>
			</td>
		</tr>
	</table>
	<?
}
?>
           
<table border="0" width="100%">
	<tr>
    	<td class="subtitseccion" style="text-align:center" colspan="4"><? if($_GET['idcot_temp']!='') print 'COTIZACI&Oacute;N '.scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero").', '?>PASO 1 DE 5: SELECCIONAR CLIENTE <? print $_GET['cl'] ?> <br><br></td>
    </tr>
</table>
<table width="100%" align="center">
  <tr>
    	<td>
            <table>
                <tr>
                	<?
					if ($_GET['idcot_temp'] != '')
					{
						if(puedo("m","COTIZACION")==1 && $filasrn==0) { ?>
                        <td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Siguiente</a></td>
                        <? 
						} 
                    }
					elseif ($_GET['idcot_temp'] == '')
					{
						if(puedo("c","COTIZACION")==1 && $filasrn==0) { ?> 
                        <td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Siguiente</a></td>
                     	<? 
						} 
                    } 
					?> 
                </tr>
            </table>        </td>
        <td>
            <table>
                <tr>        
					<? if ($_GET['idcot_temp'] != '')
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
 <table border="0" width="100%">   
 <tr>
    	<td align="left" class="subtitseccion" colspan="4">
            <div class="capa10"> 
            <table width="100%" align="center">
                <tr>
                    <td class="contenidotab" colspan="2">RAZON SOCIAL</td>    
                    <td colspan="2">       
                        <table width="60%">
                            <tr>
                                <td ><input id="nombre" name="nombre" class="tex1" value="<? print $datosad['nombre']; ?>" maxlength="50" onKeyUp="Complete(this, event)" size="40"></td>
                                <td class="botonesadmin" ><a href="javascript:void(0)" onClick="validaBuscar(formulario);">Buscar</a></td>
                            </tr>
                        </table>                    </td>       
               	</tr>
                <tr>
                    <td class="contenidotab" width="20%">NIT*</td>   
                    <td  width="30%"><input id="nit" name="nit" class="tex1" value="<? print $datosad['nit']; ?>" maxlength="50" size="40" readonly></td>
                  <td class="contenidotab" width="20%">TIPO*</td>   
                  <td width="30%">
                    <input id="tipo" name="tipo" class="tex1" value="<? print strtoupper($datosad['tipo']); ?>" maxlength="50" size="40" readonly>
                  </td>
                </tr>             
                <tr>
                    <td class="contenidotab">PAIS*</td>   
                    <td>
                    	<input id="idpais" name="idpais" class="tex1" value="<? $sqlp = "select nombre from paises where idpais=(select idpais from ciudades where idciudad='$datosad[idciudad]')"; $exep = mysqli_query($link,$sqlp); $datosp = mysqli_fetch_array($exep); print $datosp['nombre']; ?>" maxlength="50" size="40" readonly>
                    </td> 
                    <td class="contenidotab">CIUDAD</td>   
                    <td>
                    	<input id="idciudad" name="idciudad" class="tex1" value="<? print scai_get_name("$datosad[idciudad]","ciudades", "idciudad", "nombre"); ?>" maxlength="50" size="40" readonly>
                   </td>    
                </tr> 
                <tr>
                    <td class="contenidotab">VENDEDOR</td>    
                    <td>
                    	<input id="idvendedor" name="idvendedor" class="tex1" value="<? print scai_get_name("$datosad[idvendedor]","vendedores_customer", "idvendedor_customer", "nombre"); ?>" maxlength="50" size="40" readonly>
                    </td>
                    <td class="contenidotab">SERVICIO AL CLIENTE</td>    
                    <td>
                    	<input id="idcustomer" name="idcustomer" class="tex1" value="<? print scai_get_name("$datosad[idcustomer]","vendedores_customer", "idvendedor_customer", "nombre"); ?>" maxlength="50" size="40" readonly>
                    </td>
                </tr>  
                <tr>
                    <td class="contenidotab">DIRECCION</td>    
                    <td><input id="direccion" name="direccion" class="tex1" value="<? print $datosad['direccion']; ?>" maxlength="50" size="40" readonly></td>
                    <td class="contenidotab">TELEFONOS</td>    
                    <td><input id="telefonos" name="telefonos" class="tex1" value="<? print $datosad['telefonos']; ?>" maxlength="50" size="40" readonly></td>
                </tr>                         
            </table>
            </div>
        </td>
    </tr>
</table>

<?
	$_POST['idcliente'] = $_GET['idcliente'];
?>
<table width="100%" align="center">   
    <tr>
    	<td align="center" class="subtitseccion" style="text-align:left" colspan="4">CONTACTOS CLIENTE<br><br></td>
    </tr>
    <tr>
    	<td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Sel</td>
        <td class="tittabla">Nombre</td>
        <td class="tittabla">Correo</td>
        <td class="tittabla">Cargo</td>
    </tr>
    
	<? 
	//print 'idclientes'.$_GET['idcliente'].'<br>'; 
	if($_GET['idcliente'] != '')
    {
    ?>   
        <?
        $sqlad = "select * from contactos_todos where idcliente='$_GET[idcliente]'";
		//print $sqlad.'<br>';
        $exead=mysqli_query($link,$sqlad);
		$filasad = mysqli_fetch_array($exead);
        ?>
       	<input type="hidden" name="num_cont" id="num_cont" value="<? print $filasad;?>">
        <? 		
        $cant=mysqli_num_rows($exead);
		
		if($cant == 0)
		{
		?>
			<input name="registroSel" id="registroSel" type="hidden" value="" onClick="" >
        <?
		}
		
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
        $sqlpag = $sqlad." LIMIT $regini, $regxpag";
        $buscarpag=mysqli_query($link,$sqlpag);
        $cantpag=mysqli_num_rows($buscarpag);
        for($i=0;$i<$cantpag;$i++)
        {
            $datosad=mysqli_fetch_array($buscarpag);
            ?>  
             <tr>
             	<td class="contenidotab"><input name="registroSel" id="registroSel" type="radio" value="<? print $datosad['idcontacto_todos']; ?>" onClick="" <? if($datosad2['idcontacto_todos']==$datosad['idcontacto_todos']) print 'checked'; ?> ></td>            
                <td class="contenidotab"><? print $datosad['nombre'];?></td>
                <td class="contenidotab"><? print $datosad['correo'];?></td>
                <td class="contenidotab"><? print $datosad['cargo'];?></td>
            </tr>          
        <?
        }
        ?>  
    <?
    }
	?>
</table>
<table width="100%" align="center">
	<tr>
    	<td align="center" class="subtitseccion" style="text-align:left; font-size:11px" colspan="4">Si la persona a quien va dirigida la cotizaci&oacute;n no aparece en la lista de contactos por favor ingresa su nombre y cargo</td>
    </tr>
	<tr>
    	<td class="contenidotab" width="20%">NOMBRE</td>   
    	<td  width="30%"><input id="nombre_con" name="nombre_con" class="tex1" value="<? print $datosad2['nombre']; ?>" maxlength="50" size="40"></td>
    </tr>
    <tr>    	
    	<td class="contenidotab" >CARGO</td>   
    	<td  width="30%"><input id="cargo" name="cargo" class="tex1" value="<? print $datosad2['cargo']; ?>" maxlength="50" size="40"></td>        
    </tr>
    <tr>    	
    	<td class="contenidotab" >EMAIL</td>   
    	<td  width="30%"><input id="email" name="email" class="tex1" value="<? print $datosad2['email']; ?>" maxlength="50" size="40"></td>        
    </tr>
    <?
	$sqlad = "select * from clientes where idcliente='$_GET[idcliente]'";
	//print $sqlad.'<br>';
	$exead = mysqli_query($link,$sqlad);
	$datosad = mysqli_fetch_array($exead);
	?>
    <tr>    	
    	<td class="contenidotab" >CIUDAD</td>   
    	<td  width="30%"><input id="ciudad_con" name="ciudad_con" class="tex1" value="<? if($datosad2['ciudad']!='') print $datosad2['ciudad']; else print 'BOGOTA'; //scai_get_name("$datosad[idciudad]","ciudades", "idciudad", "nombre"); ?>" maxlength="50" size="40"></td>        
    </tr>
</table>

<table width="100%" align="center">
<?
function msg($parametro)
{
	include("conection/conectar.php");
	$sql2="select valor from parametros where nombre like '$parametro'";
	$exe_sql2=mysqli_query($link,$sql2);
	$alpha=mysqli_fetch_array($exe_sql2);
	return $alpha['valor'];
	}
?>
<tr>
	<td align="center" class="subtitseccion" style="text-align:center; font-size:11px">	TEXTO DE PRESENTACI&Oacute;N</td>
</tr>
<tr>
	<td align="center"><textarea cols="100" rows="5" name="presentacion" id="presentacion" ><? print msg("texto_presentacion");?></textarea></td>
</tr>
</table>
<table width="100%" align="center">
  <tr>
    	<td>
            <table>
                <tr>
                	<?
					if ($_GET['idcot_temp'] != '')
					{
						if(puedo("m","COTIZACION")==1 && $filasrn==0) { ?>
                        <td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Siguiente</a></td>
                        <? 
						} 
                    }
					elseif ($_GET['idcot_temp'] == '')
					{
						if(puedo("c","COTIZACION")==1 && $filasrn==0) { ?> 
                        <td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Siguiente</a></td>
                     	<? 
						} 
                    } 
					?> 
                </tr>
            </table>        </td>
        <td>
            <table>
                <tr>        
					<? if ($_GET['idcot_temp'] != '')
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
           