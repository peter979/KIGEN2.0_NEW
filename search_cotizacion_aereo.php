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
<script>
function validarcheckeo_aereo(name, id_minimo, id_normal, id45, id100, id300, id500, id1000)
{
	//alert(name + ',' + id20 + ',' + id40 + ',' + id40hq);
	if(document.getElementById(name).checked)
	{
		document.getElementById(id_minimo).value = '1';
		document.getElementById(id_normal).value = '1';
		document.getElementById(id45).value = '1';
		document.getElementById(id100).value = '1';
		document.getElementById(id300).value = '1';
		document.getElementById(id500).value = '1';
		document.getElementById(id1000).value = '1';
	}
	else
	{
		document.getElementById(id_minimo).value = '0';
		document.getElementById(id_normal).value = '0';
		document.getElementById(id45).value = '0';
		document.getElementById(id100).value = '0';
		document.getElementById(id300).value = '0';
		document.getElementById(id500).value = '0';
		document.getElementById(id1000).value = '0';
	}
}
</script>
				  
<div id="eyes2" style="width:100%; height:100%; overflow-x: scroll; overflow-y: scroll;">
<?
if($_POST['filtrado']=='1')
	$sqlfl = "select idtipo_aereo from cot_fletes_aereo_tmp where idcot_temp='$_GET[idcot_temp]'";
else
	$sqlfl = "select idtipo_aereo from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]'";
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
      	<td class="tittabla">Observaciones</td>        
               
        <!--<td class="tittabla20">Valor MINIMO</td>
        <td class="tittabla20">GRI 4</td>-->
        <td class="tittabla20">MIN</td>
        
        <!--<td class="tittabla40">Valor NORMAL</td>
        <td class="tittabla40">GRI 4</td>-->
        <td class="tittabla40">NOR</td>
        
        <!--<td class="tittabla40hq">Valor +45K</td>
        <td class="tittabla40hq">GRI 4</td>-->
        <td class="tittabla40hq">M&aacute;s de 45 Kg</td>
        
        <!--<td class="tittabla">Valor +100K</td>
        <td class="tittabla">GRI 4</td>-->
        <td class="tittabla">M&aacute;s de 100 Kg</td>
        
        <!--<td class="tittabla20">Valor +300K</td>
        <td class="tittabla20">GRI 4</td>-->
        <td class="tittabla20">M&aacute;s de 300 Kg</td>
        
        <!--<td class="tittabla40">Valor +500K</td>
        <td class="tittabla40">GRI 4</td>-->
        <td class="tittabla40">M&aacute;s de 500 Kg</td>
        
        <!--<td class="tittabla40hq">Valor +1000K</td>
        <td class="tittabla40hq">GRI 4</td>-->
        <td class="tittabla40hq">M&aacute;s de 1000 Kg</td>
        
        <td class="tittabla">Security Surcharget</td>
        <td class="tittabla">MZ</td>
        <td class="tittabla">Fuel Surcharget</td>
    </tr>
     <?
		/*FALTA AREGAR AL SQL BUSCAR POR NAVIERA*/
		//$sqlad="select * from tarifario_aereo where aeropuerto_origen in (select idaeropuerto_puerto from aeropuertos_puertos where nombre like '%$_POST[origen]%') and aeropuerto_destino in (select idaeropuerto_puerto from aeropuertos_puertos where nombre like '%$_POST[destination]%') and idaerolinea in (select idproveedor_agente from proveedores_agentes where nombre like '%$_POST[nav]%' and tipo='aerolinea')";
		
		$sqlad="select * from tarifario_aereo where idaerolinea in (select idproveedor_agente from proveedores_agentes where nombre like '%$_POST[nav]%' and tipo='aerolinea')";
		
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
		//print $sqlad;
		$exead=mysql_query($sqlad,$link);
		while($datosad=mysql_fetch_array($exead))
        {	
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
			//print $sql1000.'<br>';
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
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['restricciones'];?></td>

                <!--<td class="contenidotab" style="color:<? print $color; ?>"><? print $datos_minimo['valor'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datos_minimo['margen'];?></td>-->
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<input id="sel_minimo" name="sel_minimo[]" type="checkbox" onClick="" value="<? print $datos_minimo['idtipo_aereo']; ?>" <? if(in_array($datos_minimo['idtipo_aereo'], $idfletes)) print 'checked'; ?>/>
                    <?	
					if($_POST['filtrado']=='1')
						$sqlv = "select * from cot_fletes_aereo_tmp where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos_minimo[idtipo_aereo]'";	
					else
                    	$sqlv = "select * from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos_minimo[idtipo_aereo]'";
					//	print $sqlv.'<br>';
					$exev = mysql_query($sqlv, $link);
					$datosv =  mysql_fetch_array($exev);
                	?>                
                	<? $msg = 'Valor compra: '.$datos_minimo['valor'].'<br>GRI 4: '.$datos_minimo['margen']; ?>
                    <input type="text" id="venta_minimo<? print $datos_minimo['idtipo_aereo']; ?>" name="venta_minimo<? print $datos_minimo['idtipo_aereo']; ?>" value="<? if($datosv['venta']=='') { if($datos_minimo['venta']=='') print '0'; else print $datos_minimo['venta']; } else print $datosv['venta']; ?>" maxlength="20" size="4" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" onblur="validarFletes('aereo_minimo',<? print $datos_minimo['idtipo_aereo']; ?>, <? if($datosv['venta']=='') { if($datos_minimo['venta']=='') print '0'; else print $datos_minimo['venta']; } else print $datosv['venta']; ?>, <? print $datos_minimo['venta']; ?>, <? print $datos_minimo['margen']; ?>);" style="color:<? print $color; ?>"/>
                    <input type="hidden" id="u_venta_minimo<? print $datos_minimo['idtipo_aereo']; ?>" name="u_venta_minimo<? print $datos_minimo['idtipo_aereo']; ?>" value="" />
                </td>
                
                <!--<td class="contenidotab" style="color:<? print $color; ?>"><? print $datos_normal['valor'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datos_normal['margen'];?></td>-->
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<input id="sel_normal" name="sel_normal[]" type="checkbox" onClick="" value="<? print $datos_normal['idtipo_aereo']; ?>" <? if(in_array($datos_normal['idtipo_aereo'], $idfletes)) print 'checked'; ?>/>
                    <?
					if($_POST['filtrado']=='1')
						$sqlv = "select * from cot_fletes_aereo_tmp where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos_normal[idtipo_aereo]'";	
					else
                    	$sqlv = "select * from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos_normal[idtipo_aereo]'";
					//	print $sqlv.'<br>';
					$exev = mysql_query($sqlv, $link);
					$datosv =  mysql_fetch_array($exev);
                	?>
                	<? $msg = 'Valor compra: '.$datos_normal['valor'].'<br>GRI 4: '.$datos_normal['margen']; ?>
                    <input type="text" id="venta_normal<? print $datos_normal['idtipo_aereo']; ?>" name="venta_normal<? print $datos_normal['idtipo_aereo']; ?>" value="<? if($datosv['venta']=='') { if($datos_normal['venta']=='') print '0'; else print $datos_normal['venta']; } else print $datosv['venta']; ?>" maxlength="20" size="4" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" onblur="validarFletes('aereo_normal',<? print $datos_normal['idtipo_aereo']; ?>, <? if($datosv['venta']=='') { if($datos_normal['venta']=='') print '0'; else print $datos_normal['venta']; } else print $datosv['venta']; ?>, <? print $datos_normal['venta']; ?>, <? print $datos_normal['margen']; ?>);" style="color:<? print $color; ?>"/>
                    <input type="hidden" id="u_venta_normal<? print $datos_normal['idtipo_aereo']; ?>" name="u_venta_normal<? print $datos_normal['idtipo_aereo']; ?>" value="" />
                </td>
                
                <!--<td class="contenidotab" style="color:<? print $color; ?>"><? print $datos45['valor'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datos45['margen'];?></td>-->
                <td class="contenidotab" style="color:<? print $color; ?>">
               		<input id="sel45" name="sel45[]" type="checkbox" onClick="" value="<? print $datos45['idtipo_aereo']; ?>" <? if(in_array($datos45['idtipo_aereo'], $idfletes)) print 'checked'; ?>/>
                    <?
					if($_POST['filtrado']=='1')
						$sqlv = "select * from cot_fletes_aereo_tmp where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos45[idtipo_aereo]'";	
					else
                    	$sqlv = "select * from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos45[idtipo_aereo]'";
					//	print $sqlv.'<br>';
					$exev = mysql_query($sqlv, $link);
					$datosv =  mysql_fetch_array($exev);
                	?>
                	<? $msg = 'Valor compra: '.$datos45['valor'].'<br>GRI 4: '.$datos45['margen']; ?>
                    <input type="text" id="venta45<? print $datos45['idtipo_aereo']; ?>" name="venta45<? print $datos45['idtipo_aereo']; ?>" value="<? if($datosv['venta']=='') { if($datos45['venta']=='') print '0'; else print $datos45['venta']; } else print $datosv['venta']; ?>" maxlength="20" size="4" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" onblur="validarFletes('aereo45',<? print $datos45['idtipo_aereo']; ?>, <? if($datosv['venta']=='') { if($datos45['venta']=='') print '0'; else print $datos45['venta']; } else print $datosv['venta']; ?>, <? print $datos45['venta']; ?>, <? print $datos45['margen']; ?>);" style="color:<? print $color; ?>"/>
                    <input type="hidden" id="u_venta45<? print $datos45['idtipo_aereo']; ?>" name="u_venta45<? print $datos45['idtipo_aereo']; ?>" value="" />
                </td>
                
                <!--<td class="contenidotab" style="color:<? print $color; ?>"><? print $datos100['valor'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datos100['margen'];?></td>-->
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<input id="sel100" name="sel100[]" type="checkbox" onClick="" value="<? print $datos100['idtipo_aereo']; ?>" <? if(in_array($datos100['idtipo_aereo'], $idfletes)) print 'checked'; ?>/>
                    <?
					if($_POST['filtrado']=='1')
						$sqlv = "select * from cot_fletes_aereo_tmp where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos100[idtipo_aereo]'";
					else
                    	$sqlv = "select * from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos100[idtipo_aereo]'";
					//	print $sqlv.'<br>';
					$exev = mysql_query($sqlv, $link);
					$datosv =  mysql_fetch_array($exev);
                	?>
                	<? $msg = 'Valor compra: '.$datos100['valor'].'<br>GRI 4: '.$datos100['margen']; ?>
                    <input type="text" id="venta100<? print $datos100['idtipo_aereo']; ?>" name="venta100<? print $datos100['idtipo_aereo']; ?>" value="<? if($datosv['venta']=='') { if($datos100['venta']=='') print '0'; else print $datos100['venta']; } else print $datosv['venta']; ?>" maxlength="20" size="4" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" onblur="validarFletes('aereo100',<? print $datos100['idtipo_aereo']; ?>, <? if($datosv['venta']=='') { if($datos100['venta']=='') print '0'; else print $datos100['venta']; } else print $datosv['venta']; ?>, <? print $datos100['venta']; ?>, <? print $datos100['margen']; ?>);" style="color:<? print $color; ?>"/>
                    <input type="hidden" id="u_venta100<? print $datos100['idtipo_aereo']; ?>" name="u_venta100<? print $datos100['idtipo_aereo']; ?>" value="" />
                </td>
                
                <!--<td class="contenidotab" style="color:<? print $color; ?>"><? print $datos300['valor'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datos300['margen'];?></td>-->
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<input id="sel300" name="sel300[]" type="checkbox" onClick="" value="<? print $datos300['idtipo_aereo']; ?>" <? if(in_array($datos300['idtipo_aereo'], $idfletes)) print 'checked'; ?>/>
                    <?
					if($_POST['filtrado']=='1')
						$sqlv = "select * from cot_fletes_aereo_tmp where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos300[idtipo_aereo]'";
					else
                    	$sqlv = "select * from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos300[idtipo_aereo]'";
					//	print $sqlv.'<br>';
					$exev = mysql_query($sqlv, $link);
					$datosv =  mysql_fetch_array($exev);
                	?>
                	<? $msg = 'Valor compra: '.$datos300['valor'].'<br>GRI 4: '.$datos300['margen']; ?>
                    <input type="text" id="venta300<? print $datos300['idtipo_aereo']; ?>" name="venta300<? print $datos300['idtipo_aereo']; ?>" value="<? if($datosv['venta']=='') { if($datos300['venta']=='') print '0'; else print $datos300['venta']; } else print $datosv['venta']; ?>" maxlength="20" size="4" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" onblur="validarFletes('aereo300',<? print $datos300['idtipo_aereo']; ?>, <? if($datosv['venta']=='') { if($datos300['venta']=='') print '0'; else print $datos300['venta']; } else print $datosv['venta']; ?>, <? print $datos300['venta']; ?>, <? print $datos300['margen']; ?>);" style="color:<? print $color; ?>"/>
                    <input type="hidden" id="u_venta300<? print $datos300['idtipo_aereo']; ?>" name="u_venta300<? print $datos300['idtipo_aereo']; ?>" value="" />
                </td>                
                <!--<td class="contenidotab" style="color:<? print $color; ?>"><? print $datos500['valor'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datos500['margen'];?></td>-->
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<input id="sel500" name="sel500[]" type="checkbox" onClick="" value="<? print $datos500['idtipo_aereo']; ?>" <? if(in_array($datos500['idtipo_aereo'], $idfletes)) print 'checked'; ?>/>
                    <?
					if($_POST['filtrado']=='1')
						$sqlv = "select * from cot_fletes_aereo_tmp where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos500[idtipo_aereo]'";
					else
                    	$sqlv = "select * from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos500[idtipo_aereo]'";
					//	print $sqlv.'<br>';
					$exev = mysql_query($sqlv, $link);
					$datosv =  mysql_fetch_array($exev);
                	?>
                	<? $msg = 'Valor compra: '.$datos500['valor'].'<br>GRI 4: '.$datos500['margen']; ?>
                    <input type="text" id="venta500<? print $datos500['idtipo_aereo']; ?>" name="venta500<? print $datos500['idtipo_aereo']; ?>" value="<? if($datosv['venta']=='') { if($datos500['venta']=='') print '0'; else print $datos500['venta']; } else print $datosv['venta']; ?>" maxlength="20" size="4" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" onblur="validarFletes('aereo500',<? print $datos500['idtipo_aereo']; ?>, <? if($datosv['venta']=='') { if($datos500['venta']=='') print '0'; else print $datos500['venta']; } else print $datosv['venta']; ?>, <? print $datos500['venta']; ?>, <? print $datos500['margen']; ?>);"  style="color:<? print $color; ?>"/>
                    <input type="hidden" id="u_venta500<? print $datos500['idtipo_aereo']; ?>" name="u_venta500<? print $datos500['idtipo_aereo']; ?>" value="" />
                </td>
                
                <!--<td class="contenidotab" style="color:<? print $color; ?>"><? print $datos1000['valor'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datos1000['margen'];?></td>-->
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<input id="sel1000" name="sel1000[]" type="checkbox" onClick="" value="<? print $datos1000['idtipo_aereo']; ?>" <? if(in_array($datos1000['idtipo_aereo'], $idfletes)) print 'checked'; ?>/>
                    <?
					if($_POST['filtrado']=='1')
						$sqlv = "select * from cot_fletes_aereo_tmp where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos1000[idtipo_aereo]'";
					else
                    	$sqlv = "select * from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]' and idtipo_aereo='$datos1000[idtipo_aereo]'";
					//print $sqlv.'<br>';
					$exev = mysql_query($sqlv, $link);
					$datosv =  mysql_fetch_array($exev);
                	?>
                	<? $msg = 'Valor compra: '.$datos1000['valor'].'<br>GRI 4: '.$datos1000['margen']; ?>
                    <input type="text" id="venta1000<? print $datos1000['idtipo_aereo']; ?>" name="venta1000<? print $datos1000['idtipo_aereo']; ?>" value="<? if($datosv['venta']=='') { if($datos1000['venta']=='') print '0'; else print $datos1000['venta']; } else print $datosv['venta']; ?>" maxlength="20" size="4" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" onblur="validarFletes('aereo1000',<? print $datos1000['idtipo_aereo']; ?>, <? if($datosv['venta']=='') { if($datos1000['venta']=='') print '0'; else print $datos1000['venta']; } else print $datosv['venta']; ?>, <? print $datos1000['venta']; ?>, <? print $datos1000['margen']; ?>);" style="color:<? print $color; ?>" />
                    <input type="hidden" id="u_venta1000<? print $datos1000['idtipo_aereo']; ?>" name="u_venta1000<? print $datos1000['idtipo_aereo']; ?>" value="" />
                </td>
                <?
				if($_POST['filtrado']=='1')
					$sqlv = "select * from cot_fletes_aereo_tmp where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]'";
				else
					$sqlv = "select * from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosad[idtarifario_aereo]'";
				//print $sqlv.'<br>';
				$exev = mysql_query($sqlv, $link);
				$datosv =  mysql_fetch_array($exev);
				?>
                <td class="contenidotab" style="color:<? print $color; ?>">
                    <input id="security<? print $datosad['idtarifario_aereo']; ?>" name="security<? print $datosad['idtarifario_aereo']; ?>" type="checkbox" value="1" onclick="validarcheckeo_aereo(this.name, 'n_security<? print $datos_minimo['idtipo_aereo']; ?>', 'n_security<? print $datos_normal['idtipo_aereo']; ?>', 'n_security<? print $datos45['idtipo_aereo']; ?>', 'n_security<? print $datos100['idtipo_aereo']; ?>', 'n_security<? print $datos300['idtipo_aereo']; ?>', 'n_security<? print $datos500['idtipo_aereo']; ?>', 'n_security<? print $datos1000['idtipo_aereo']; ?>')" <? if($datosv['security']=='1') print 'checked'; ?>/>				
                    <input type="hidden" id="n_security<? print $datos_minimo['idtipo_aereo']; ?>" value="<? if($datosv['security']=='1') print $datosv['security']; else print '0'; ?>" />
                    <input type="hidden" id="n_security<? print $datos_normal['idtipo_aereo']; ?>" value="<? if($datosv['security']=='1') print $datosv['security']; else print '0'; ?>" />
                    <input type="hidden" id="n_security<? print $datos45['idtipo_aereo']; ?>" value="<? if($datosv['security']=='1') print $datosv['security']; else print '0'; ?>" />
                    <input type="hidden" id="n_security<? print $datos100['idtipo_aereo']; ?>" value="<? if($datosv['security']=='1') print $datosv['security']; else print '0'; ?>" />
                    <input type="hidden" id="n_security<? print $datos300['idtipo_aereo']; ?>" value="<? if($datosv['security']=='1') print $datosv['security']; else print '0'; ?>" />
                    <input type="hidden" id="n_security<? print $datos500['idtipo_aereo']; ?>" value="<? if($datosv['security']=='1') print $datosv['security']; else print '0'; ?>" />
                    <input type="hidden" id="n_security<? print $datos1000['idtipo_aereo']; ?>" value="<? if($datosv['security']=='1') print $datosv['security']; else print '0'; ?>" />           
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                    <input id="mz<? print $datosad['idtarifario_aereo']; ?>" name="mz<? print $datosad['idtarifario_aereo']; ?>" type="checkbox" value="1" onclick="validarcheckeo_aereo(this.name, 'n_mz<? print $datos_minimo['idtipo_aereo']; ?>', 'n_mz<? print $datos_normal['idtipo_aereo']; ?>', 'n_mz<? print $datos45['idtipo_aereo']; ?>', 'n_mz<? print $datos100['idtipo_aereo']; ?>', 'n_mz<? print $datos300['idtipo_aereo']; ?>', 'n_mz<? print $datos500['idtipo_aereo']; ?>', 'n_mz<? print $datos1000['idtipo_aereo']; ?>')" <? if($datosv['mz']=='1') print 'checked'; ?>/>				
                    <input type="hidden" id="n_mz<? print $datos_minimo['idtipo_aereo']; ?>" value="<? if($datosv['mz']=='1') print $datosv['mz']; else print '0'; ?>" />
                    <input type="hidden" id="n_mz<? print $datos_normal['idtipo_aereo']; ?>" value="<? if($datosv['mz']=='1') print $datosv['mz']; else print '0'; ?>" />
                    <input type="hidden" id="n_mz<? print $datos45['idtipo_aereo']; ?>" value="<? if($datosv['mz']=='1') print $datosv['mz']; else print '0'; ?>" />
                    <input type="hidden" id="n_mz<? print $datos100['idtipo_aereo']; ?>" value="<? if($datosv['mz']=='1') print $datosv['mz']; else print '0'; ?>" />
                    <input type="hidden" id="n_mz<? print $datos300['idtipo_aereo']; ?>" value="<? if($datosv['mz']=='1') print $datosv['mz']; else print '0'; ?>" />
                    <input type="hidden" id="n_mz<? print $datos500['idtipo_aereo']; ?>" value="<? if($datosv['mz']=='1') print $datosv['mz']; else print '0'; ?>" />
                    <input type="hidden" id="n_mz<? print $datos1000['idtipo_aereo']; ?>" value="<? if($datosv['mz']=='1') print $datosv['mz']; else print '0'; ?>" />                </td>
                    <td class="contenidotab" style="color:<? print $color; ?>">
                    <input id="fuel<? print $datosad['idtarifario_aereo']; ?>" name="fuel<? print $datosad['idtarifario_aereo']; ?>" type="checkbox" value="1" onclick="validarcheckeo_aereo(this.name, 'n_fuel<? print $datos_minimo['idtipo_aereo']; ?>', 'n_fuel<? print $datos_normal['idtipo_aereo']; ?>', 'n_fuel<? print $datos45['idtipo_aereo']; ?>', 'n_fuel<? print $datos100['idtipo_aereo']; ?>', 'n_fuel<? print $datos300['idtipo_aereo']; ?>', 'n_fuel<? print $datos500['idtipo_aereo']; ?>', 'n_fuel<? print $datos1000['idtipo_aereo']; ?>')" <? if($datosv['fuel']=='1') print 'checked'; ?>/>				
                    <input type="hidden" id="n_fuel<? print $datos_minimo['idtipo_aereo']; ?>" value="<? if($datosv['fuel']=='1') print $datosv['fuel']; else print '0'; ?>" />
                    <input type="hidden" id="n_fuel<? print $datos_normal['idtipo_aereo']; ?>" value="<? if($datosv['fuel']=='1') print $datosv['fuel']; else print '0'; ?>" />
                    <input type="hidden" id="n_fuel<? print $datos45['idtipo_aereo']; ?>" value="<? if($datosv['fuel']=='1') print $datosv['fuel']; else print '0'; ?>" />
                    <input type="hidden" id="n_fuel<? print $datos100['idtipo_aereo']; ?>" value="<? if($datosv['fuel']=='1') print $datosv['fuel']; else print '0'; ?>" />
                    <input type="hidden" id="n_fuel<? print $datos300['idtipo_aereo']; ?>" value="<? if($datosv['fuel']=='1') print $datosv['fuel']; else print '0'; ?>" />
                    <input type="hidden" id="n_fuel<? print $datos500['idtipo_aereo']; ?>" value="<? if($datosv['fuel']=='1') print $datosv['fuel']; else print '0'; ?>" />
                    <input type="hidden" id="n_fuel<? print $datos1000['idtipo_aereo']; ?>" value="<? if($datosv['fuel']=='1') print $datosv['fuel']; else print '0'; ?>" />                </td>
            </tr>
                      
        <?
        }
        ?> 
</table>
</div>