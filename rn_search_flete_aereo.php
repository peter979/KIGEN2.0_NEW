<?
include('sesion/sesion.php');
include("conection/conectar.php");	
include_once("permite.php");
include_once("scripts/recover_nombre.php");
$sesi=session_id();


$_POST['nav']=str_replace(" ","%",$_POST['nav']); 
$_POST['origen']=str_replace(" ","%",$_POST['origen']); 
$_POST['destination']=str_replace(" ","%",$_POST['destination']); 
 
if($_POST['idcot_temp']!='')
	$_GET['idcot_temp'] = $_POST['idcot_temp'];		
		  
?>
<script type="text/javascript">
	var myDiv = 0;
	var xDiv = 0;
	var yDiv = 0;
	var IE = navigator.appName.toLowerCase().indexOf("microsoft") > -1;
	var Mozilla = navigator.appName.toLowerCase().indexOf("netscape") > -1;

	var textoAnt = "";
	var posicionListaFilling = 0;

	var datos = new Array();
	
	
	

	

	function ajaxobj() {
		try {
			_ajaxobj = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				_ajaxobj = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (E) {
				_ajaxobj = false;
			}
		}
	   
		if (!_ajaxobj && typeof XMLHttpRequest!='undefined') {
			_ajaxobj = new XMLHttpRequest();
		}
		
		return _ajaxobj;
	}
	
	function cargaLista(evt, obj, txt, listanom) {
		ajax = ajaxobj();
		ajax.open("GET", "ordenes.php?texto="+txt+"&idcot_temp=<?print $_GET['idcot_temp'];?>", true);
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				var datos = ajax.responseXML;
				var paises = datos.getElementsByTagName("pais");
				
				var listaPaises = new Array();
				if (paises) {
					for (var i=0; i<paises.length; i++) {
						listaPaises[listaPaises.length] = paises[i].firstChild.data;
					}
				}
				escribeLista(obj, listaPaises, listanom);
			}
		}
		ajax.send(null);
	}
	
	function escribeLista(obj, lista, nombrel) {
		var html = "";
		var fill = document.getElementById(nombrel);
		
		if (lista.length == 0) {
			// Si la lista es vacia no la mostramos
			fill.style.display = "none";
		} else {
			// Creamos una tabla con 
			// todos los elementos encontrados
			fill.style.display = "block";
			var html='<table cellspacing="0" '+
				'cellpadding="0" border="0" width="100%">';
			for (var i=0; i<lista.length; i++) {
				html += '<tr id="tr'+obj.id+i+
					'" '+(posicionListaFilling == i? 
						' class="fill" ': '')+
					' onmouseover="seleccionaFilling(\'tr'+
					obj.id+'\', '+i+
					')" onmousedown="seleccionaTextoFilling(\'tr'+
					obj.id+'\', '+i+')">';
				html += '<td>'+lista[i]+'</td></tr>';
			}
			html += '</table>';
		}

		// Escribimos la lista
		fill.innerHTML = html;
	}

	// Muestra las coincidencias en la lista
	function inputFilling(evt, obj, list) {
		var fill = document.getElementById(list.id);
		
		var elems = datos;
		
		var tecla = "";
		var lista = new Array();
		var res = obj.value;
		var borrar = false;
		
		// Almaceno la tecla pulsada
		if (!IE) {
		  tecla = evt.which;
		} else {
		  tecla = evt.keyCode;
		}
		
		var texto;
		// Si la tecla que pulso es una
		// letra o un espacio, o el intro
		// o la tecla borrar, almaceno lo 
		// que debo buscar
		if (!String.fromCharCode(tecla).match(/(\w|\s)/) && 
				tecla != 8 && 
				tecla != 13) {
			texto = textoAnt;
		} else {
			texto = obj.value;
		}
		
		textoAnt = texto;
		
		// Si el texto es distinto de vacio
		// o se pulsa ARRIBA o ABAJO
		// hago llamada AJAX para que 
		// me devuelva la lista de palabras
		// que coinciden con lo que hay
		// escrito en la caja
		if ((texto != null && texto != "") 
			|| (tecla == 40 || tecla == 38)) {
			cargaLista(evt, obj, texto, list.id);
		}
		
		
		// Según la letra que se pulse
		if (tecla == 37) { // Izquierda
			// No hago nada
		} else if (tecla == 38) { // Arriba
			// Subo la posicion en la
			// lista desplegable una posición
			if (posicionListaFilling > 0) {
				posicionListaFilling--;
			}
			// Corrijo la posición del scroll
			fill.scrollTop = posicionListaFilling*14;
		} else if (tecla == 39) { // Derecha
			// No hago nada
		} else if (tecla == 40) { // Abajo
			if (obj.value != "") {
				// Si no es la última palabra
				// de la lista
				if (posicionListaFilling < lista.length-1) { 
					// Corrijo el scroll
					fill.scrollTop = posicionListaFilling*14;
					// Bajo la posición de la lista
					posicionListaFilling++;
				} 
			}
		} else if (tecla == 8) { // Borrar <-
			// Se sube la lista del todo
			posicionListaFilling = 0;
			// Se permite borrar
			borrar = true;
		} else if (tecla == 13) { // Intro
			// Deseleccionamos el texto
			if (obj.createTextRange) {
				var r = obj.createTextRange();
				r.moveStart("character", 
					obj.value.length+1);
				r.moveEnd("character", 
					obj.value.length+1);
				r.select();
			} else if (obj.setSelectionRange) {
				obj.setSelectionRange(
					obj.value.length+1, 
					obj.value.length+1);
			}
			// Ocultamos la lista
			fill.style.display = "none";
			// Ponemos el puntero de 
			// la lista arriba del todo
			posicionListaFilling = 0;
			// Controlamos el scroll
			fill.scrollTop = 0;
			return true;
		} else {
			// En otro caso que siga
			// escribiendo
			posicionListaFilling = 0;
			fill.scrollTop = 0;
		}	
		
		// Si no se ha borrado
		if (!borrar) {
			if (lista.length != 0) {
				// Seleccionamos la parte del texto
				// que corresponde a lo que aparece
				// en la primera posición de la lista
				// menos el texto que realmente hemos
				// escrito
				obj.value = lista[posicionListaFilling];
				if (obj.createTextRange) {
					var r = obj.createTextRange();
					r.moveStart("character", 
						texto.length);
					r.moveEnd("character", 
						lista[posicionListaFilling].length);
					r.select();
				} else if (obj.setSelectionRange) {
					obj.setSelectionRange(
						texto.length, 
						lista[posicionListaFilling].length);
				}
			}
		}
		return true;
	}
  
  
	// Introduce el texto seleccionado
	function setInput(obj, fill) {
		obj.value = textoAnt;
		fill.style.display = "none";
		posicionListaFilling = 0;
	}

  
	// Cambia el estilo de
	// la palabra seleccionada
	// de la lista
	function seleccionaFilling(id, n) {
		document.getElementById(id + 
			n).className = "fill";
		document.getElementById(id + 
			posicionListaFilling).className = "";  	
		posicionListaFilling = n;
	}
  
	// Pasa el texto del filling a la caja
	function seleccionaTextoFilling (id, n) {
		textoAnt = document.getElementById(id + 
			n).firstChild.innerHTML;
		posicionListaFilling = 0;
	}
  	
 
	// Cambia la imagen cuando se pone 
	// encima el raton (nombre.ext 
	// por _nombre.ext)
	function cambiarImagen(obj, ok) {
		var marcada = obj.src.indexOf("/_") > 0;
		
		if (ok) {
			if (!marcada) {
			  var ruta = obj.src.substring(
				0, 
				obj.src.lastIndexOf("/")+1)+
				"_"+obj.src.substring(
					obj.src.lastIndexOf("/")+1);
			  obj.src = ruta;
			}
		} else {
			if (marcada) {
				var ruta = ""+obj.src.substring(
					0, obj.src.lastIndexOf("_"))+
					obj.src.substring(
						obj.src.lastIndexOf("/")+2);
				obj.src = ruta;
			}
		}
	
	}
function validarcheckeo(name, id20, id40, id40hq)
{
	//alert(name + ',' + id20 + ',' + id40 + ',' + id40hq);
	if(document.getElementById(name).checked)
	{
		document.getElementById(id20).value = '1';
		document.getElementById(id40).value = '1';
		document.getElementById(id40hq).value = '1';
	}
	else
	{
		document.getElementById(id20).value = '0';
		document.getElementById(id40).value = '0';
		document.getElementById(id40hq).value = '0';
	}


}


getDimensions = function(oElement) {
	var x, y, w, h;
	x = y = w = h = 0;
	if (document.getBoxObjectFor) { // Mozilla
	var oBox = document.getBoxObjectFor(oElement);
	x = oBox.x-1;
	w = oBox.width;
	y = oBox.y-1;
	h = oBox.height;
	}
	else if (oElement.getBoundingClientRect) { // IE
	var oRect = oElement.getBoundingClientRect();
	x = oRect.left-2;
	w = oElement.clientWidth;
	y = oRect.top-2;
	h = oElement.clientHeight;
	}
	return {x: x, y: y, w: w, h: h};
	}
	function darPosicion(nombre, lista){
	
	var myDiv = document.getElementById(nombre);
	var xDiv = getDimensions(myDiv).x;
	var yDiv = getDimensions(myDiv).y;
	var div = lista; 
		div.style.top= yDiv +"px";
	 	div.style.left= yDiv +"px";

	}
</script>
		<style type="text/css">
	div.contenedor {
		position: relative;
		width: 100px;
		margin: 0%;
	}
	div.fill {
		font-family: Arial;
		font-size: 8pt;
		display: none;
		width: 128px;
		position:relative;
		margin-top: 0%;
		margin-left:0%;
		color: #FF6800;
		background-color: #FF6800;
		border: 1px solid #FF6800;
		overflow: auto;
		height: 150px;
		top: -1px;
	}

	tr.fill {
		font-family: Arial;
		font-size: 8pt;
		color: #FFFFFF;
		background-color: #FF6800;
		border: 1px solid #FF6800;
	}
	
	
	
</style>		  
<div id="eyes2" style="width:100%; height:auto; overflow-x: scroll; overflow-y: scroll;">
<?
$sql = "select * from modalidades_reportes where idcot_temp='$_GET[idcot_temp]'";
//print $sql.'<br>';
$exe = mysql_query($sql,$link);
$datos = mysql_fetch_array($exe);

if($_POST['filtrado']=='1')
	$sqlfl = "select idtipo_aereo from rn_fletes_aereo_tmp where idreporte='$_GET[idcot_temp]'";
else
	$sqlfl = "select idtipo_aereo from rn_fletes_aereo where idreporte='$_GET[idcot_temp]'";
//print $sqlfl.'<br>';
$exefl = mysql_query($sqlfl, $link);
$idfletes[] = '0';
while ($datosfl = mysql_fetch_array($exefl))
{
	$idfletes[] = $datosfl['idtipo_aereo'];
}

?>
<table width="100%">
	<tr>
    	<td colspan="21"></td>
    	<td class="tittabla" colspan="9" align="center">SHIPPER</td>
    </tr>
	<tr>
        <td class="tittabla">Agente</td>
        <td class="tittabla">Aerolinea</td>
        <td class="tittabla">N&uacute;mero de contrato</td>
        <td class="tittabla">Aeropuerto Origen</td>
        <td class="tittabla">Pais</td>
        <td class="tittabla">Aeropuerto Destino</td>
        <td class="tittabla">Servicio via</td>
        
        <td class="tittabla">Security Surcharget</td>
        <td class="tittabla">MZ/Kg</td>
        <td class="tittabla">Fuel Surcharget</td>
        
        <td class="tittabla">Fecha Ultima Actualizaci&oacute;n</td>
        <td class="tittabla">Tarifa valida desde</td>
        <td class="tittabla">Vigencia</td>
      	<td class="tittabla">Moneda</td>        
        <td class="tittabla20">MIN</td>
        <td class="tittabla40">NOR</td>
        <td class="tittabla40hq">+45K</td>
        <td class="tittabla">+100K</td>
        <td class="tittabla20">+300K</td>
        <td class="tittabla40">+500K</td>
        <td class="tittabla40hq">+1000K</td>        
        <td class="tittabla">NOMBRE*</td>
        <td class="tittabla">NIT</td>
        <td class="tittabla">CIUDAD</td>			
    	<td class="tittabla">DIRECCI&Oacute;N</td>      					
    	<td class="tittabla">TELEFONO</td>				
    	<td class="tittabla">CONTACTO</td>
        <td class="tittabla">EMAIL</td>
        <td class="tittabla">DEPOT</td> 
	<td class="tittabla">ORDER NUMBER</td>
        <?
		if($datos['seguro']=='1')
		{
			?>
        	<td class="tittabla">Seguro</td>
            <?
		}
		?>       
    </tr>
     <?
		/*FALTA AREGAR AL SQL BUSCAR POR NAVIERA*/
		$sqlad="select * from tarifario_aereo where idaerolinea in (select idproveedor_agente from proveedores_agentes where nombre like '%$_POST[nav]%' and tipo='aerolinea')  and idtarifario_aereo in (select idtarifario_aereo from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]')";
		
		if($_POST['origen']!='' && $_POST['origen']!='N')
			$sqlad .= " and idagente='$_POST[origen]'";
		if($_POST['destination']!='' && $_POST['destination']!='N')
			$sqlad .= "and idpais='$_POST[destination]'";
		if($_POST['aeropuerto_origen']!='' && $_POST['aeropuerto_origen']!='N')
			$sqlad .= " and aeropuerto_origen='$_POST[aeropuerto_origen]'";			
			
		if($_POST['ver_sel']=='1')
		{
			$sqlad .= " and idtarifario_aereo in (select idtarifario_aereo from cot_fletes_aereo where idcot_temp='$_POST[idcot_temp]')";
		}
		$sqlad .= " and estado='1'";
		$exead=mysql_query($sqlad,$link);
		$cant=mysql_num_rows($exead);
	
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
        $buscarpag=mysql_query($sqlpag,$link);
        $cantpag=mysql_num_rows($buscarpag);

        for($i=0;$i<$cantpag;$i++)
        {
            $datosad=mysql_fetch_array($buscarpag);
			
			$sqlmin = "select * from tipo_aereo where tipo='minimo' and idtarifario_aereo='$datosad[idtarifario_aereo]'";
			$exemin = mysql_query($sqlmin, $link);
			$datos_minimo = mysql_fetch_array($exemin);
			
			$sqlnor = "select * from tipo_aereo where tipo='normal' and idtarifario_aereo='$datosad[idtarifario_aereo]'";
			$exenor = mysql_query($sqlnor, $link);
			$datos_normal = mysql_fetch_array($exenor);
					
			$sql45 = "select * from tipo_aereo where tipo='45' and idtarifario_aereo='$datosad[idtarifario_aereo]'";
			$exe45 = mysql_query($sql45, $link);
			$datos45 = mysql_fetch_array($exe45);
			
			$sql100 = "select * from tipo_aereo where tipo='100' and idtarifario_aereo='$datosad[idtarifario_aereo]'";
			$exe100 = mysql_query($sql100, $link);
			$datos100 = mysql_fetch_array($exe100);
			
			$sql300 = "select * from tipo_aereo where tipo='300' and idtarifario_aereo='$datosad[idtarifario_aereo]'";
			$exe300 = mysql_query($sql300, $link);
			$datos300 = mysql_fetch_array($exe300);
			
			$sql500 = "select * from tipo_aereo where tipo='500' and idtarifario_aereo='$datosad[idtarifario_aereo]'";
			$exe500 = mysql_query($sql500, $link);
			$datos500 = mysql_fetch_array($exe500);
			
			$sql1000 = "select * from tipo_aereo where tipo='1000' and idtarifario_aereo='$datosad[idtarifario_aereo]'";
			$exe1000 = mysql_query($sql1000, $link);
			$datos1000 = mysql_fetch_array($exe1000);
			
			$sqln = "select NOW() as ahora";
			$exen = mysql_query($sqln, $link);
			$datosn3 = mysql_fetch_array($exen);
			$color = '#000000';	
			if($datosad['fecha_vigencia'] < $datosn3['ahora'])
				$color = '#FF0000';
            ?>  
             <tr>                   
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[idagente]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[idaerolinea]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>                
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['num_contrato'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[aeropuerto_origen]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[idpais]", "paises", "idpais", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[aeropuerto_destino]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['servicio_via'];?></td>
                
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['security'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['MZ'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['fuel'];?></td>
                
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['fecha_ul_act'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['fecha_valida'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['fecha_vigencia'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[moneda]","monedas", "idmoneda", "codigo");?></td>                
                <td class="contenidotab" style="color:<? print $color; ?>">
                	
                    <? $sqlrn = "select idcot_fletes_aereo from cot_fletes_aereo where idtipo_aereo='$datos_minimo[idtipo_aereo]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idcot_temp='$_GET[idcot_temp]'";
					$exern = mysql_query($sqlrn, $link);
					$filasrn = mysql_num_rows($exern); ?>
					
                    <input id="sel_minimo" name="sel_minimo[]" type="checkbox" onClick="" value="<? print $datos_minimo['idtipo_aereo']; ?>" <? if(in_array($datos_minimo['idtipo_aereo'], $idfletes)) print 'checked'; if($filasrn == 0) print 'disabled'; ?>/>
                    <?
                    $sqlv = "select * from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos_minimo[idtipo_aereo]'";
					$exev = mysql_query($sqlv, $link);
					$datosv =  mysql_fetch_array($exev);
                	
					$msg = 'Valor compra: '.$datos_minimo['valor'].'<br>Margen: '.$datos_minimo['margen']; ?>
                    <input type="text" id="venta_minimo<? print $datos_minimo['idtipo_aereo']; ?>" name="venta_minimo<? print $datos_minimo['idtipo_aereo']; ?>" value="<? if($datosv['venta']=='') { if($datos_minimo['venta']=='') print '0'; else print $datos_minimo['venta']; } else print $datosv['venta']; ?>" maxlength="20" size="4" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" onblur="validarFletes('aereo_minimo',<? print $datos_minimo['idtipo_aereo']; ?>, <? if($datosv['venta']=='') { if($datos_minimo['venta']=='') print '0'; else print $datos_minimo['venta']; } else print $datosv['venta']; ?>, <? print $datos_minimo['venta']; ?>, <? print $datos_minimo['margen']; ?>);" style="color:<? print $color; ?>" readonly/>
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<?
					$sqlrn = "select idcot_fletes_aereo from cot_fletes_aereo where idtipo_aereo='$datos_normal[idtipo_aereo]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idcot_temp='$_GET[idcot_temp]'";
					$exern = mysql_query($sqlrn, $link);
					$filasrn = mysql_num_rows($exern);
					?>
                    <input id="sel_normal" name="sel_normal[]" type="checkbox" onClick="" value="<? print $datos_normal['idtipo_aereo']; ?>" <? if(in_array($datos_normal['idtipo_aereo'], $idfletes)) print 'checked'; if($filasrn == 0) print 'disabled'; ?>/>
                    <?
                    $sqlv = "select * from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos_normal[idtipo_aereo]'";
					$exev = mysql_query($sqlv, $link);
					$datosv =  mysql_fetch_array($exev);
                	?>
                	<? $msg = 'Valor compra: '.$datos_normal['valor'].'<br>Margen: '.$datos_normal['margen']; ?>
                    <input type="text" id="venta_normal<? print $datos_normal['idtipo_aereo']; ?>" name="venta_normal<? print $datos_normal['idtipo_aereo']; ?>" value="<? if($datosv['venta']=='') { if($datos_normal['venta']=='') print '0'; else print $datos_normal['venta']; } else print $datosv['venta']; ?>" maxlength="20" size="4" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" onblur="validarFletes('aereo_normal',<? print $datos_normal['idtipo_aereo']; ?>, <? if($datosv['venta']=='') { if($datos_normal['venta']=='') print '0'; else print $datos_normal['venta']; } else print $datosv['venta']; ?>, <? print $datos_normal['venta']; ?>, <? print $datos_normal['margen']; ?>);" style="color:<? print $color; ?>" readonly/>
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
               		<?
					$sqlrn = "select idcot_fletes_aereo from cot_fletes_aereo where idtipo_aereo='$datos45[idtipo_aereo]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idcot_temp='$_GET[idcot_temp]'";
					$exern = mysql_query($sqlrn, $link);
					$filasrn = mysql_num_rows($exern);
					?>
                    <input id="sel45" name="sel45[]" type="checkbox" onClick="" value="<? print $datos45['idtipo_aereo']; ?>" <? if(in_array($datos45['idtipo_aereo'], $idfletes)) print 'checked'; if($filasrn == 0) print 'disabled'; ?>/>
                    <?
                    $sqlv = "select * from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos45[idtipo_aereo]'";
					$exev = mysql_query($sqlv, $link);
					$datosv =  mysql_fetch_array($exev);
                	
					$msg = 'Valor compra: '.$datos45['valor'].'<br>Margen: '.$datos45['margen']; ?>
					
					
                    <input type="text" id="venta45<? print $datos45['idtipo_aereo']; ?>" name="venta45<? print $datos45['idtipo_aereo']; ?>" value="<? if($datosv['venta']=='') { if($datos45['venta']=='') print '0'; else print $datos45['venta']; } else print $datosv['venta']; ?>" maxlength="20" size="4" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" onblur="validarFletes('aereo45',<? print $datos45['idtipo_aereo']; ?>, <? if($datosv['venta']=='') { if($datos45['venta']=='') print '0'; else print $datos45['venta']; } else print $datosv['venta']; ?>, <? print $datos45['venta']; ?>, <? print $datos45['margen']; ?>);" style="color:<? print $color; ?>" readonly/>
                </td>
                
                
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<?
					$sqlrn = "select idcot_fletes_aereo from cot_fletes_aereo where idtipo_aereo='$datos100[idtipo_aereo]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idcot_temp='$_GET[idcot_temp]'";
					$exern = mysql_query($sqlrn, $link);
					$filasrn = mysql_num_rows($exern);
					?>
                    <input id="sel100" name="sel100[]" type="checkbox" onClick="" value="<? print $datos100['idtipo_aereo']; ?>" <? if(in_array($datos100['idtipo_aereo'], $idfletes)) print 'checked'; if($filasrn == 0) print 'disabled'; ?>/>
                    <?
                    $sqlv = "select * from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos100[idtipo_aereo]'";
					$exev = mysql_query($sqlv, $link);
					$datosv =  mysql_fetch_array($exev);
                	
					$msg = 'Valor compra: '.$datos100['valor'].'<br>Margen: '.$datos100['margen']; ?>
                    <input type="text" id="venta100<? print $datos100['idtipo_aereo']; ?>" name="venta100<? print $datos100['idtipo_aereo']; ?>" value="<? if($datosv['venta']=='') { if($datos100['venta']=='') print '0'; else print $datos100['venta']; } else print $datosv['venta']; ?>" maxlength="20" size="4" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" onblur="validarFletes('aereo100',<? print $datos100['idtipo_aereo']; ?>, <? if($datosv['venta']=='') { if($datos100['venta']=='') print '0'; else print $datos100['venta']; } else print $datosv['venta']; ?>, <? print $datos100['venta']; ?>, <? print $datos100['margen']; ?>);" style="color:<? print $color; ?>" readonly/>
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<?
					$sqlrn = "select idcot_fletes_aereo from cot_fletes_aereo where idtipo_aereo='$datos300[idtipo_aereo]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idcot_temp='$_GET[idcot_temp]'";
					$exern = mysql_query($sqlrn, $link);
					$filasrn = mysql_num_rows($exern);
					?>
                    <input id="sel300" name="sel300[]" type="checkbox" onClick="" value="<? print $datos300['idtipo_aereo']; ?>" <? if(in_array($datos300['idtipo_aereo'], $idfletes)) print 'checked'; if($filasrn == 0) print 'disabled'; ?>/>
                    <?
                    $sqlv = "select * from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos300[idtipo_aereo]'";
					$exev = mysql_query($sqlv, $link);
					$datosv =  mysql_fetch_array($exev);
                	
					$msg = 'Valor compra: '.$datos300['valor'].'<br>Margen: '.$datos300['margen']; ?>
					
                    <input type="text" id="venta300<? print $datos300['idtipo_aereo']; ?>" name="venta300<? print $datos300['idtipo_aereo']; ?>" value="<? if($datosv['venta']=='') { if($datos300['venta']=='') print '0'; else print $datos300['venta']; } else print $datosv['venta']; ?>" maxlength="20" size="4" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" onblur="validarFletes('aereo300',<? print $datos300['idtipo_aereo']; ?>, <? if($datosv['venta']=='') { if($datos300['venta']=='') print '0'; else print $datos300['venta']; } else print $datosv['venta']; ?>, <? print $datos300['venta']; ?>, <? print $datos300['margen']; ?>);" style="color:<? print $color; ?>" readonly/>
                </td>                
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<?
					$sqlrn = "select idcot_fletes_aereo from cot_fletes_aereo where idtipo_aereo='$datos500[idtipo_aereo]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idcot_temp='$_GET[idcot_temp]'";
					$exern = mysql_query($sqlrn, $link);
					$filasrn = mysql_num_rows($exern);
					?>
                    <input id="sel500" name="sel500[]" type="checkbox" onClick="" value="<? print $datos500['idtipo_aereo']; ?>" <? if(in_array($datos500['idtipo_aereo'], $idfletes)) print 'checked'; if($filasrn == 0) print 'disabled'; ?>/>
                    <?
                    $sqlv = "select * from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos500[idtipo_aereo]'";
					$exev = mysql_query($sqlv, $link);
					$datosv =  mysql_fetch_array($exev);
                	
					$msg = 'Valor compra: '.$datos500['valor'].'<br>Margen: '.$datos500['margen']; ?>
					
                    <input type="text" id="venta500<? print $datos500['idtipo_aereo']; ?>" name="venta500<? print $datos500['idtipo_aereo']; ?>" value="<? if($datosv['venta']=='') { if($datos500['venta']=='') print '0'; else print $datos500['venta']; } else print $datosv['venta']; ?>" maxlength="20" size="4" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" onblur="validarFletes('aereo500',<? print $datos500['idtipo_aereo']; ?>, <? if($datosv['venta']=='') { if($datos500['venta']=='') print '0'; else print $datos500['venta']; } else print $datosv['venta']; ?>, <? print $datos500['venta']; ?>, <? print $datos500['margen']; ?>);"  style="color:<? print $color; ?>" readonly/>
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<?
					$sqlrn = "select idcot_fletes_aereo from cot_fletes_aereo where idtipo_aereo='$datos1000[idtipo_aereo]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idcot_temp='$_GET[idcot_temp]'";
					$exern = mysql_query($sqlrn, $link);
					$filasrn = mysql_num_rows($exern);
					?>
                    <input id="sel1000" name="sel1000[]" type="checkbox" onClick="" value="<? print $datos1000['idtipo_aereo']; ?>" <? if(in_array($datos1000['idtipo_aereo'], $idfletes)) print 'checked'; if($filasrn == 0) print 'disabled'; ?>/>
                    <?
                    $sqlv = "select * from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos1000[idtipo_aereo]'";
					$exev = mysql_query($sqlv, $link);
					$datosv =  mysql_fetch_array($exev);
                	
					$msg = 'Valor compra: '.$datos1000['valor'].'<br>Margen: '.$datos1000['margen']; ?>
                    <input type="text" id="venta1000<? print $datos1000['idtipo_aereo']; ?>" name="venta1000<? print $datos1000['idtipo_aereo']; ?>" value="<? if($datosv['venta']=='') { if($datos1000['venta']=='') print '0'; else print $datos1000['venta']; } else print $datosv['venta']; ?>" maxlength="20" size="4" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" onblur="validarFletes('aereo1000',<? print $datos1000['idtipo_aereo']; ?>, <? if($datosv['venta']=='') { if($datos1000['venta']=='') print '0'; else print $datos1000['venta']; } else print $datosv['venta']; ?>, <? print $datos1000['venta']; ?>, <? print $datos1000['margen']; ?>);" style="color:<? print $color; ?>" readonly/>
                </td>
                
                <?
				$sqlrn = "select * from rn_fletes_aereo where idcot_fletes_aereo in (select idcot_fletes_aereo from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]') and (name!='' or tax_id!='' or address!='' or phone!='' or contact!='' or email!='' or depot!='')"; 
				//echo $sqlrn;
				$exern = mysql_query($sqlrn, $link);
				$datosrn =  mysql_fetch_array($exern);
				?>
                <td class="contenidotab">
					<input id="name<? print $datosad['idtarifario_aereo']; ?>" name="name<? print $datosad['idtarifario_aereo']; ?>" value="<? print $datosrn['name']; ?>"/></td>
                <td class="contenidotab">
					<input id="tax_id<? print $datosad['idtarifario_aereo']; ?>" name="tax_id<? print $datosad['idtarifario_aereo']; ?>" value="<? print $datosrn['tax_id']; ?>"/>
				</td>
                <td class="contenidotab">
					<input id="city<? print $datosad['idtarifario_aereo']; ?>" name="city<? print $datosad['idtarifario_aereo']; ?>" value="<? print $datosrn['city']; ?>"/>
				</td>
                <td class="contenidotab">
					<input id="address<? print $datosad['idtarifario_aereo']; ?>" name="address<? print $datosad['idtarifario_aereo']; ?>" value="<? print $datosrn['address']; ?>"/>
				</td>
                <td class="contenidotab">
					<input id="phone<? print $datosad['idtarifario_aereo']; ?>" name="phone<? print $datosad['idtarifario_aereo']; ?>" value="<? print $datosrn['phone']; ?>"/></td>
                <td class="contenidotab">
					<input id="contact<? print $datosad['idtarifario_aereo']; ?>" name="contact<? print $datosad['idtarifario_aereo']; ?>" value="<? print $datosrn['contact']; ?>"/></td>
                <td class="contenidotab">
					<input id="email<? print $datosad['idtarifario_aereo']; ?>" name="email<? print $datosad['idtarifario_aereo']; ?>" value="<? print $datosrn['email']; ?>"/></td>
                <td class="contenidotab">
					<input id="depot<? print $datosad['idtarifario_aereo']; ?>" name="depot<? print $datosad['idtarifario_aereo']; ?>" value="<? print $datosrn['depot']; ?>"/></td>
		<td class="contenidotab">

		
		
		<?
		
		$sqlorden="SELECT * FROM `reporte_estado_cli`
						WHERE `number` NOT
						IN (
							SELECT order_number
							FROM rn_fletes_aereo
						)
						AND idcliente = (select idcliente from cot_temp where idcot_temp = ".$_GET['idcot_temp'].")
						AND clasificacion = 'aereo'";

					$norden=mysql_query($sqlorden, $link);
				 ?>

			  <select name="ordnum<? print $datosad['idtarifario_aereo']; ?>" id="ordnum <? print $datosad['idtarifario_aereo']; ?>">
				 <option  selected="selected" value="<? echo $datosrn['order_number']; ?>"><? echo $datosrn['order_number']; ?></option>
				 <?
				 while ($dorden=mysql_fetch_array($norden))
				 {
					?>
						<option value="<? echo $dorden['number']; ?>"><? echo $dorden['number']; ?></option>
					<?
						
				  }
				?>
			  </select>
			<?
			 if($datosrn['order_number'] != ""){ //si ya tiene asignada numero de orden
				 $idReporteEstado = scai_get_name($datosrn['order_number'], "reporte_estado_cli", "number", "idreporte_estado");
				 $idCliente = scai_get_name($datosrn['order_number'], "reporte_estado_cli", "number", "idcliente");
				 ?>
				 <br />
				 <a href="re_flete_cli.php?idcliente=<?= $idCliente;?>&idreporte_estado=<?= $idReporteEstado;?>">Reporte de estado</a>
				 <?
				 
			 }?>
		
		<div class="contenedor"><div id="lista<?print $i;?>" class="fill" style="font-family: Arial;
		font-size: 8pt;	display: none;	width: 200px;	position:relative; color: #FF6800; background-color: #D0D0D0;border: 1px solid #FF6800;
		overflow: auto;	height: 100px;	top: -1px;"></div></div>
		<label>

		</label></td>
                <?
                if($datos['seguro']=='1')
				{
		$portorgn=scai_get_name("$datosad[aeropuerto_origen]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre")." "." ".scai_get_name("$datosad[idpais]", "paises", "idpais", "nombre");
		$portdst=scai_get_name("$datosad[aeropuerto_destino]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");
		?>
                    <td class="contenidotab">
                        <a href="sh_seg.php?idcot_temp=<? print $_GET['idcot_temp']; ?>&idtarifario=<? print $datosad['idtarifario_aereo']; ?>&orgn=<? print $portorgn;?> &dst=<? print $portdst?> ">Seguro</a>
                    </td>
                    <?
				}
				?>
            </tr>           
        <?
        }
        ?> 
</table>
</div>