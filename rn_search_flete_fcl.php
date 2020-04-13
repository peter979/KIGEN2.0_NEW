
<?
include('sesion/sesion.php');
include("conection/conectar.php");	
include_once("permite.php");
include_once("scripts/recover_nombre.php");

$sesi=session_id();

 /**************/
$_POST['nav']=str_replace(" ","%",$_POST['nav']); 
$_POST['origen']=str_replace(" ","%",$_POST['origen']); 
$_POST['destination']=str_replace(" ","%",$_POST['destination']); 
 
 /****************/					
if($_POST['idcot_temp']!='')
	$_GET['idcot_temp'] = $_POST['idcot_temp'];
				  
?>				  



<div id="eyes2" style="width:100%; height:auto; overflow-x: scroll; overflow-y: scroll;">


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


function validarcheckeo_fcl(name, id20, id40, id40hq)
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
		font-size: 11pt;
		display: none;
		width: 160px;
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
		font-size: 11pt;
		color: #FFFFFF;
		background-color: #FF6800;
		border: 1px solid #FF6800;
	}
	
	
	
</style>

<?
$sql = "select * from modalidades_reportes where idcot_temp='$_GET[idcot_temp]'";
//print $sql.'<br>';
$exe = mysql_query($sql,$link);
$datos = mysql_fetch_array($exe);

if($_POST['filtrado']=='1')
	$sqlfl = "select idtipo from rn_fletes_tmp where idreporte='$_GET[idcot_temp]'";
else
	$sqlfl = "select idtipo from rn_fletes where idreporte='$_GET[idcot_temp]'";
//print $sqlfl.'<br>';
$exefl = mysql_query($sqlfl, $link);
$idfletes[] = '0';
while ($datosfl = mysql_fetch_array($exefl))
{
	$idfletes[] = $datosfl['idtipo'];
}
//print_r($idfletes);
/*$sqlfl = "select idtipo from cot_fletes_tmp where idcot_temp='$_GET[idcot_temp]'";
//print $sqlfl.'<br>';
$exefl = mysql_query($sqlfl, $link);
$idfletes_tmp[] = '0';
while ($datosfl = mysql_fetch_array($exefl))
{
	$idfletes_tmp[] = $datosfl['idtipo'];
}*/		
//print_r($idfletes_tmp);	
?>

<table width="100%" > 
	<tr>
    	<td colspan="17"></td>
    	<td class="tittabla" colspan="7" align="center">SHIPPER</td>
    </tr>
    <tr>
        <!--<td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Sel</td>-->
        <!--<td class="tittabla">Clonar</td>-->
	<td class="tittabla">Naviera</td>
        <td class="tittabla">Agente</td>
        <!--<td class="tittabla">N&uacute;mero de contrato</td>-->
        <td class="tittabla">Puerto Origen</td>
        <td class="tittabla">Pais</td>
        <td class="tittabla">Puerto Destino</td>
        <td class="tittabla">Servicio via</td>
        <td class="tittabla">Tiempo de transito</td>
        <!--<td class="tittabla">Tarifa valida desde</td>-->
        <td class="tittabla">Vigencia</td>
        <td class="tittabla">Moneda</td>
        <td class="tittabla20">Fete 20</td>
        <td class="tittabla40">Flete 40</td>        
        <td class="tittabla40hq">Flete 40HQ</td>
        <td class="tittabla40hq">BAF</td>
        <td class="tittabla40hq">GRI</td>
        <td class="tittabla40hq">PSS</td>

        <td class="tittabla">Tarifa Neta </td>
        <td class="tittabla">NOMBRE*</td>
        <td class="tittabla">NIT</td>
        <td class="tittabla">CIUDAD</td>			
    	<td class="tittabla">DIRECCI&Oacute;N</td>      					
    	<td class="tittabla">TELEFONO</td>				
    	<td class="tittabla">CONTACTO</td>
        <td class="tittabla">EMAIL</td>
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
		
		$sqlad="select * from tarifario where puerto_origen in (
					select idaeropuerto_puerto from aeropuertos_puertos where 
						nombre like '%$_POST[origen]%'
					) and puerto_destino in (
						select idaeropuerto_puerto from aeropuertos_puertos where 
							nombre like '%$_POST[destination]%'
					)and idnaviera in (
								select idproveedor_agente from proveedores_agentes where nombre like '%$_POST[nav]%' and tipo='naviera'
					)and clasificacion='fcl' 
					and idtarifario in (
								select idtarifario from cot_fletes where idcot_temp='$_GET[idcot_temp]'
					)";
		if($_POST['ver_sel']=='1')
		{
			$sqlad .= " and idtarifario in (select idtarifario from cot_fletes where idcot_temp='$_POST[idcot_temp]')";
		}
		$sqlad .= " and estado='1'";
		//print $sqlad.'<br>';
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
		//echo $sqlpag;
        $cantpag=mysql_num_rows($buscarpag);
	//print $sqlpag;
        for($i=0;$i<$cantpag;$i++)
        {
            $datosad=mysql_fetch_array($buscarpag);
			
			$sql20 = "select * from tipo where tipo='20' and idtarifario='$datosad[idtarifario]'";
			$exe20 = mysql_query($sql20, $link);
			$datos20 = mysql_fetch_array($exe20);
			
			$sql40 = "select * from tipo where tipo='40' and idtarifario='$datosad[idtarifario]'";
			$exe40 = mysql_query($sql40, $link);
			$datos40 = mysql_fetch_array($exe40);
			
			$sql40hq = "select * from tipo where tipo='40hq' and idtarifario='$datosad[idtarifario]'";
			$exe40hq = mysql_query($sql40hq, $link);
			$datos40hq = mysql_fetch_array($exe40hq);
			
			$sqln = "select NOW() as ahora";
			$exen = mysql_query($sqln, $link);
			$datosn3 = mysql_fetch_array($exen);
			$color = '#000000';	
			if($datosad['fecha_vigencia'] < $datosn3['ahora'])
				$color = '#FF0000';
            ?>  
             <tr>                    
                <!--<td class="contenidotab" style="color:<? print $color; ?>"><input name="modSel[]" type="checkbox" onClick="" value="<? print $datosad['idtarifario']; ?>" /></td>-->
                <? $alias = scai_get_name("$datosad[idnaviera]", "proveedores_agentes", "idproveedor_agente", "alias");	?>
         	<!--<td class="contenidotab" style="color:<? print $color; ?>"><input type="radio" name="group1" value="ID"></td>-->
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[idnaviera]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[idagente]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
                <!--<td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['num_contrato'];?></td>-->
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[puerto_origen]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[idpais]", "paises", "idpais", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[puerto_destino]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['servicio_via'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['tiempo_trans'];?></td>
                <!--<td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['fecha_valida'];?></td>-->
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['fecha_vigencia'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[moneda]","monedas", "idmoneda", "codigo");?></td>
                <?
				$msg20 = "Flete ".$datos20['flete']." <br> BAF ".$datos20['baf']." <br> ISPS ".$datos20['isps']." <br> GRI 1 ".$datos20['gri_1']." <br> Peak Season ".$datos20['peak_season']." <br> GRI 2 ".$datos20['gri_2']." <br> GRI 3 ".$datos20['gri_3']." <br> Courrier ".$datos20['courrier']." <br> Coload Fee ".$datos20['coload_fee']." <br> Port Congestion ".$datos20['port_congestion']." <br> Margen ".$datos20['margen']." <center><strong><br> All In ".$datos20['all_in']." <br> Flete + BAF + ISPS + GRI 1 + GRI 2 + GRI 3 + Peak Season + Courrier + Coload Fee + Port Congestion + Margen <br></strong></center> ";
				
				$msg40 = "Flete ".$datos40['flete']." <br> BAF ".$datos40['baf']." <br> ISPS ".$datos40['isps']." <br> GRI 1 ".$datos40['gri_1']." <br> Peak Season ".$datos40['peak_season']." <br> GRI 2 ".$datos40['gri_2']." <br> GRI 3 ".$datos40['gri_3']." <br> Courrier ".$datos40['courrier']." <br> Coload Fee ".$datos40['coload_fee']." <br> Port Congestion ".$datos40['port_congestion']." <br> Margen ".$datos40['margen']." <center><strong><br> All In ".$datos40['all_in']." <br> Flete + BAF + ISPS + GRI 1 + GRI 2 + GRI 3 + Peak Season + Courrier + Coload Fee + Port Congestion + Margen <br></strong></center> ";
				
				$msg40hq = "Flete ".$datos40hq['flete']." <br> BAF ".$datos40hq['baf']." <br> ISPS ".$datos40hq['isps']." <br> GRI 1 ".$datos40hq['gri_1']." <br> Peak Season ".$datos40hq['peak_season']." <br> GRI 2 ".$datos40hq['gri_2']." <br> GRI 3 ".$datos40hq['gri_3']." <br> Courrier ".$datos40hq['courrier']." <br> Coload Fee ".$datos40hq['coload_fee']." <br> Port Congestion ".$datos40hq['port_congestion']." <br> Margen ".$datos40hq['margen']." <center><strong><br> All In ".$datos40hq['all_in']." <br> Flete + BAF + ISPS + GRI 1 + GRI 2 + GRI 3 + Peak Season + Courrier + Coload Fee + Port Congestion + Margen <br></strong></center> ";				
				
				if($_POST['filtrado']=='1')
					$sqlv = "select * from cot_fletes_tmp where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosad[idtarifario]'";	
				else
				$sqlv = "select * from cot_fletes where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosad[idtarifario]'";
				//print $sqlv.'<br>';
				$exev = mysql_query($sqlv, $link);
				$datosv =  mysql_fetch_array($exev);
                ?>
                                
                <td class="contenidotab" style="color:<? print $color; ?>">
                    <input  type="text" id="all_in_20<? print $datosad['idtarifario']; ?>" name="all_in_20<? print $datosad['idtarifario']; ?>" class="tex2" value="<? if($datosv['all_in_20']=='') print $datos20['all_in']; else print $datosv['all_in_20']; ?>" maxlength="20" size="3" onchange="formulario.n_all_in_20<? print $datos20['idtipo']; ?>.value=this.value" onblur="validarFletes('20', <? print $datosad['idtarifario']; ?>, <? if($datosv['all_in_20']=='') print $datos20['all_in']; else print $datosv['all_in_20']; ?>, <? print $datos20['all_in']; ?>, <? print $datos20['margen']; ?>);" style="color:<? print $color; ?>;width:45px;" readonly/>
                                
                    <input type="hidden" id="n_all_in_20<? print $datos20['idtipo']; ?>"  name="n_all_in_20<? print $datos20['idtipo']; ?>" value="<? if($datosv['all_in_20']=='') print $datos20['all_in']; else print $datosv['all_in_20']; ?>"/>
                   
					<?
                    $sqlrn = "select idcot_fletes from cot_fletes where idtipo='$datos20[idtipo]' and idtarifario='$datosad[idtarifario]' and idcot_temp='$_GET[idcot_temp]'";
                    //print $sqlrn.'<br>';
                    $exern = mysql_query($sqlrn, $link);
                    $filasrn = mysql_num_rows($exern);
					
					$sql = "select * from rn_fletes where idtipo='$datos20[idtipo]' and idreporte='$_GET[idcot_temp]'";
					//print $sql.'<br>';
					$exe2 = mysql_query($sql, $link);
					$datos2 = mysql_fetch_array($exe2);
                    ?>     
                  	<input id="sel20" name="sel20[]" type="checkbox" onClick="" value="<? print $datos20['idtipo']; ?>" onMouseOver="return overlib('<? print $msg20;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" <? if(in_array($datos20['idtipo'], $idfletes) /*|| in_array($datos20['idtipo'], $idfletes_tmp)*/) print 'checked'; if($filasrn == 0) print 'disabled'; ?>/> <? //print $datos20['idtipo']; ?>
                
                	Cantidad<input type="text" id="cantidad<? print $datos20['idtipo']; ?>" name="cantidad<? print $datos20['idtipo']; ?>" value="<? print $datos2['cantidad']; ?>" style="width:45px;"/>                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                    <input type="text" id="all_in_40<? print $datosad['idtarifario']; ?>" name="all_in_40<? print $datosad['idtarifario']; ?>" class="tex2" value="<? if($datosv['all_in_40']=='') print $datos40['all_in']; else print $datosv['all_in_40']; ?>" maxlength="20" size="3" onchange="formulario.n_all_in_40<? print $datos40['idtipo']; ?>.value=this.value" onblur="validarFletes('40', <? print $datosad['idtarifario']; ?>, <? if($datosv['all_in_40']=='') print $datos40['all_in']; else print $datosv['all_in_40']; ?>, <? print $datos40['all_in']; ?>, <? print $datos40['margen']; ?>);" style="color:<? print $color; ?>;width:45px;" readonly//>
                    
                    <input type="hidden" id="n_all_in_40<? print $datos40['idtipo']; ?>"  name="n_all_in_40<? print $datos40['idtipo']; ?>" value="<? if($datosv['all_in_40']=='') print $datos40['all_in']; else print $datosv['all_in_40']; ?>"/>                    
                    <?
					$sqlrn = "select idcot_fletes from cot_fletes where idtipo='$datos40[idtipo]' and idtarifario='$datosad[idtarifario]' and idcot_temp='$_GET[idcot_temp]'";
					//print $sqlrn.'<br>';
					$exern = mysql_query($sqlrn, $link);
					$filasrn = mysql_num_rows($exern);
					
					$sql = "select * from rn_fletes where idtipo='$datos40[idtipo]' and idreporte='$_GET[idcot_temp]'";
					//print $sql.'<br>';
					$exe2 = mysql_query($sql, $link);
					$datos2 = mysql_fetch_array($exe2);
					?> 
                    <input id="sel40" name="sel40[]" type="checkbox" onClick="" value="<? print $datos40['idtipo']; ?>" onMouseOver="return overlib('<? print $msg40;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" <? if(in_array($datos40['idtipo'], $idfletes) /*|| in_array($datos40['idtipo'], $idfletes_tmp)*/) print 'checked'; if($filasrn == 0) print 'disabled'; ?> /> <? //print $datos40['idtipo']; ?>
                    
                    Cantidad<input type="text" id="cantidad<? print $datos40['idtipo']; ?>" name="cantidad<? print $datos40['idtipo']; ?>" value="<? print $datos2['cantidad']; ?>" style="width:45px;"/>                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                    <input type="text" id="all_in_40hq<? print $datosad['idtarifario']; ?>" name="all_in_40hq<? print $datosad['idtarifario']; ?>" class="tex2" value="<? if($datosv['all_in_40hq']=='') print $datos40hq['all_in']; else print $datosv['all_in_40hq']; ?>" maxlength="20" size="3" onchange="formulario.n_all_in_40hq<? print $datos40hq['idtipo']; ?>.value=this.value" onblur="validarFletes('40hq', <? print $datosad['idtarifario']; ?>, <? if($datosv['all_in_40hq']=='') print $datos40hq['all_in']; else print $datosv['all_in_40hq']; ?>, <? print $datos40hq['all_in']; ?>, <? print $datos40hq['margen']; ?>);" style="color:<? print $color; ?>;width:45px;" readonly//>
                    
                    <input type="hidden" id="n_all_in_40hq<? print $datos40hq['idtipo']; ?>"  name="n_all_in_40hq<? print $datos40hq['idtipo']; ?>" value="<? if($datosv['all_in_40hq']=='') print $datos40hq['all_in']; else print $datosv['all_in_40hq']; ?>"/>
                    
                    <?
					$sqlrn = "select idcot_fletes from cot_fletes where idtipo='$datos40hq[idtipo]' and idtarifario='$datosad[idtarifario]' and idcot_temp='$_GET[idcot_temp]'";
					//print $sqlrn.'<br>';
					$exern = mysql_query($sqlrn, $link);
					$filasrn = mysql_num_rows($exern);
					
					$sql = "select * from rn_fletes where idtipo='$datos40hq[idtipo]' and idreporte='$_GET[idcot_temp]'";
					//print $sql.'<br>';
					$exe2 = mysql_query($sql, $link);
					$datos2 = mysql_fetch_array($exe2);
					?>
                    <input id="sel40hq" name="sel40hq[]" type="checkbox" onClick="" value="<? print $datos40hq['idtipo']; ?>" onMouseOver="return overlib('<? print $msg40hq;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" <? if(in_array($datos40hq['idtipo'], $idfletes) /*|| in_array($datos40hq['idtipo'], $idfletes_tmp)*/) print 'checked'; if($filasrn == 0) print 'disabled'; ?> />  <? //print $datos40hq['idtipo']; ?>
                    
                    Cantidad<input type="text" id="cantidad<? print $datos40hq['idtipo']; ?>" name="cantidad<? print $datos40hq['idtipo']; ?>" value="<? print $datos2['cantidad']; ?>" style="width:45px;"/>                </td> 
                <td class="contenidotab" style="color:<? print $color; ?>">
                <input id="baf<? print $datosad['idtarifario']; ?>" name="baf<? print $datosad['idtarifario']; ?>" type="checkbox" value="1" onclick="validarcheckeo_fcl(this.name, 'n_baf<? print $datos20['idtipo']; ?>', 'n_baf<? print $datos40['idtipo']; ?>', 'n_baf<? print $datos40hq['idtipo']; ?>')" <? if($datosv['baf']=='1') print 'checked'; ?> disabled/>				
                <input type="hidden" id="n_baf<? print $datos20['idtipo']; ?>" value="<? if($datosv['baf']=='1') print $datosv['baf']; else print '0'; ?>" />
                <input type="hidden" id="n_baf<? print $datos40['idtipo']; ?>" value="<? if($datosv['baf']=='1') print $datosv['baf']; else print '0'; ?>" />
                <input type="hidden" id="n_baf<? print $datos40hq['idtipo']; ?>" value="<? if($datosv['baf']=='1') print $datosv['baf']; else print '0'; ?>" />                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                <input id="gri<? print $datosad['idtarifario']; ?>" name="gri<? print $datosad['idtarifario']; ?>" type="checkbox" value="1" <? if($datosv['gri']=='1') print 'checked'; ?> onclick="validarcheckeo_fcl(this.name, 'n_gri<? print $datos20['idtipo']; ?>', 'n_gri<? print $datos40['idtipo']; ?>', 'n_gri<? print $datos40hq['idtipo']; ?>')" disabled/>
                <input type="hidden" id="n_gri<? print $datos20['idtipo']; ?>" value="<? if($datosv['gri']=='1') print $datosv['gri']; else print '0'; ?>" />
                <input type="hidden" id="n_gri<? print $datos40['idtipo']; ?>" value="<? if($datosv['gri']=='1') print $datosv['gri']; else print '0'; ?>" />
                <input type="hidden" id="n_gri<? print $datos40hq['idtipo']; ?>" value="<? if($datosv['gri']=='1') print $datosv['gri']; else print '0'; ?>" />                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                <input id="pss<? print $datosad['idtarifario']; ?>" name="pss<? print $datosad['idtarifario']; ?>" type="checkbox" value="1" <? if($datosv['pss']=='1') print 'checked'; ?> onclick="validarcheckeo_fcl(this.name, 'n_pss<? print $datos20['idtipo']; ?>', 'n_pss<? print $datos40['idtipo']; ?>', 'n_pss<? print $datos40hq['idtipo']; ?>')" disabled/>
                <input type="hidden" id="n_pss<? print $datos20['idtipo']; ?>" value="<? if($datosv['pss']=='1') print $datosv['pss']; else print '0'; ?>" />
                <input type="hidden" id="n_pss<? print $datos40['idtipo']; ?>" value="<? if($datosv['pss']=='1') print $datosv['pss']; else print '0'; ?>" />
                <input type="hidden" id="n_pss<? print $datos40hq['idtipo']; ?>" value="<? if($datosv['pss']=='1') print $datosv['pss']; else print '0'; ?>" />                </td>                
               
                <?
				$sqlrn = "select * from rn_fletes where idcot_fletes in (select idcot_fletes from cot_fletes where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosad[idtarifario]') and (name!='' or tax_id!='' or city!='' or address!='' or phone!='' or contact!='' or email!='')"; 
				//print $sqlrn.'<br>';
				$exern = mysql_query($sqlrn, $link);
				
				$datosrn =  mysql_fetch_array($exern);

				?>
				 <td class="contenidotab"><input id="total_neta<? print $datosad['idtarifario']; ?>" name="total_neta<? print $datosad['idtarifario']; ?>" value="<? print $datosrn['total_neta']; ?>"/></td>
                <td class="contenidotab"><input id="name<? print $datosad['idtarifario']; ?>" name="name<? print $datosad['idtarifario']; ?>" value="<? print $datosrn['name']; ?>"/></td>
                <td class="contenidotab"><input id="tax_id<? print $datosad['idtarifario']; ?>" name="tax_id<? print $datosad['idtarifario']; ?>" value="<? print $datosrn['tax_id']; ?>"/></td>
                <td class="contenidotab"><input id="city<? print $datosad['idtarifario']; ?>" name="city<? print $datosad['idtarifario']; ?>" value="<? print $datosrn['city']; ?>"/></td>
                <td class="contenidotab"><input id="address<? print $datosad['idtarifario']; ?>" name="address<? print $datosad['idtarifario']; ?>" value="<? print $datosrn['address']; ?>"/></td>
                <td class="contenidotab"><input id="phone<? print $datosad['idtarifario']; ?>" name="phone<? print $datosad['idtarifario']; ?>" value="<? print $datosrn['phone']; ?>"/></td>
                <td class="contenidotab"><input id="contact<? print $datosad['idtarifario']; ?>" name="contact<? print $datosad['idtarifario']; ?>" value="<? print $datosrn['contact']; ?>"/></td>
                <td class="contenidotab"><input id="email<? print $datosad['idtarifario']; ?>" name="email<? print $datosad['idtarifario']; ?>" value="<? print $datosrn['email']; ?>"/></td>
		
		<td class="contenidotab">
	
			<div id="lista<? print $i;?>" class="fill" style="font-family: Arial;font-size: 8pt;	display: none;position:relative; color: #FF6800; background-color: #D0D0D0;border: 1px solid #FF6800; overflow: auto;	height: 100px;	top: -1px;"></div>
			  <label>
			  <?
					$sqlnomb="select clientes.idcliente, clientes.nombre from clientes, cot_temp where clientes.idcliente = cot_temp.idcliente and cot_temp.idcot_temp =".$_GET['idcot_temp'];
					$nomb=mysql_query($sqlnomb, $link);
					$anomb=mysql_fetch_array($nomb);
					 
					$sqlorden="select reporte_estado_cli.number from reporte_estado_cli, clientes where 
									clientes.idcliente = reporte_estado_cli.idcliente 
									and clientes.nombre = '".$anomb['nombre']."' 
									and reporte_estado_cli.clasificacion = 'fcl' 
									and reporte_estado_cli.number not in (
										select rn_fletes.order_number from rn_fletes, cot_fletes, cot_temp, clientes where 
											rn_fletes.idcot_fletes = cot_fletes.idcot_fletes 
											and cot_fletes.idcot_temp = cot_temp.idcot_temp 
											and cot_temp.idcliente = clientes.idcliente and clientes.nombre = '".$anomb['nombre']."'
									)";
					$norden=mysql_query($sqlorden, $link);

				 ?>
				 
				 
			  <select name="ordnum<? print $datosad['idtarifario']; ?>" id="ordnum <? print $datosad['idtarifario']; ?>">
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
			  //obtiene el id del reporte de estado con el numero de orden
			  

			 if($datosrn['order_number'] != ""){ //si ya tiene asignada numero de orden
				 $idReporteEstado = scai_get_name($datosrn['order_number'], "reporte_estado_cli", "number", "idreporte_estado");
				 $idCliente = scai_get_name($datosrn['order_number'], "reporte_estado_cli", "number", "idcliente");
				 ?>
				 <br />
				 <a href="re_flete_cli.php?idcliente=<?= $idCliente;?>&idreporte_estado=<?= $idReporteEstado;?>">Reporte de estado</a>
				 <?
				 
			 }
			  ?>
			  </label>
			</div>		
		</td>
		
                <?
                if($datos['seguro']=='1')
				{
		$portorgn=scai_get_name("$datosad[puerto_origen]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre")." "." ".scai_get_name("$datosad[idpais]", "paises", "idpais", "nombre");
		$portdst=scai_get_name("$datosad[puerto_destino]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");
					?>
                    <td class="contenidotab">
                        <a href="sh_seg.php?idcot_temp=<? print $_GET['idcot_temp']; ?>&idtarifario=<? print $datosad['idtarifario']; ?>&orgn=<? print $portorgn;?> &dst=<? print $portdst?> ">Seguro</a>                    </td>
                    <?
				}
				?>
            </tr>         
        <?
        }
        ?>   
</table>
		



			
</div>