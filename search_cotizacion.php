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
<div id="eyes2" style="width:100%; height:100%; overflow-x: scroll; overflow-y: scroll;">
<script>
function validarcheckeo_fcl(name, id20, id40, id40hq)
{
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
</script>
<?
if($_POST['filtrado']=='1')
	$sqlfl = "select idtipo from cot_fletes_tmp where idcot_temp='$_GET[idcot_temp]'";
else
	$sqlfl = "select idtipo from cot_fletes where idcot_temp='$_GET[idcot_temp]'";

$exefl = mysql_query($sqlfl, $link);
$idfletes[] = '0';
while ($datosfl = mysql_fetch_array($exefl))
{
	$idfletes[] = $datosfl['idtipo'];
}
?>
<table width="100%"> 
    <tr>
        <!--<td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Sel</td>-->
        <td class="tittabla">Naviera</td>
        <td class="tittabla">Agente</td>
        <td class="tittabla">N&uacute;mero de contrato</td>
        <td class="tittabla">Puerto Origen</td>
        <td class="tittabla">Pais</td>
        <td class="tittabla">Puerto Destino</td>
        <td class="tittabla">Servicio via</td>
        <td class="tittabla">Tiempo de transito</td>
        <td class="tittabla">Tarifa valida desde</td>
        <td class="tittabla">Vigencia</td>
        <td class="tittabla">Moneda</td>
        <td class="tittabla">Observaciones</td>
        <td class="tittabla20">Fete 20</td>
        <td class="tittabla40">Flete 40</td>        
        <td class="tittabla40hq">Flete 40HQ</td>
        <td class="tittabla40hq">BAF</td>
        <td class="tittabla40hq">GRI</td>
        <td class="tittabla40hq">PSS</td>
    </tr>    
	<?
	/*FALTA AREGAR AL SQL BUSCAR POR NAVIERA*/
	
	$sqlad="select * from tarifario where puerto_origen in (
						select idaeropuerto_puerto from aeropuertos_puertos where nombre like '%$_POST[origen]%') 
			and puerto_destino in (select idaeropuerto_puerto from aeropuertos_puertos where nombre like '%$_POST[destination]%') 
			and idnaviera in (select idproveedor_agente from proveedores_agentes where nombre like '%$_POST[nav]%' and tipo='naviera') 
			and clasificacion='fcl'
			and fecha_vigencia > '".date("Y-m-d")."'";

	if($_POST['ver_sel']=='1')
	{
		$sqlad .= " and idtarifario in (select idtarifario from cot_fletes where idcot_temp='$_POST[idcot_temp]')";
	}
	if($_POST['aeropuerto_origen']!='' && $_POST['aeropuerto_origen']!='N')
		$sqlad .= " and idpais='$_POST[aeropuerto_origen]'";
		
	$sqlad .= " and estado='1'";
	$exead=mysql_query($sqlad,$link);
	while($datosad=mysql_fetch_array($exead))
	{	
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
		                   
			<? $alias = scai_get_name("$datosad[idnaviera]", "proveedores_agentes", "idproveedor_agente", "alias");	?>         
			<td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[idnaviera]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
			<td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[idagente]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
			<td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['num_contrato'];?></td>
			<td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[puerto_origen]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");?></td>
			<td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[idpais]", "paises", "idpais", "nombre");?></td>
			<td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[puerto_destino]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");?></td>
			<td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['servicio_via'];?></td>
			<td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['tiempo_trans'];?></td>
			<td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['fecha_valida'];?></td>
			<td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['fecha_vigencia'];?></td>
			<td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[moneda]","monedas", "idmoneda", "codigo");?></td>
			<td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['observaciones'];?></td>

			<?
			$msg20 = "Flete ".$datos20['flete']." <br> BAF ".$datos20['baf']." <br> ISPS ".$datos20['isps']." <br> GRI 1 ".$datos20['gri_1']." <br> Peak Season ".$datos20['peak_season']." <br> GRI 2 ".$datos20['gri_2']." <br> GRI 3 ".$datos20['gri_3']." <br> Courrier ".$datos20['courrier']." <br> Coload Fee ".$datos20['coload_fee']." <br> Port Congestion ".$datos20['port_congestion']." <br> GRI 4 ".$datos20['margen']." <center><strong><br> All In ".$datos20['all_in']." <br> Flete + BAF + ISPS + GRI 1 + GRI 2 + GRI 3 + Peak Season + Courrier + Coload Fee + Port Congestion + GRI 4 <br></strong></center> ";
			
			$msg40 = "Flete ".$datos40['flete']." <br> BAF ".$datos40['baf']." <br> ISPS ".$datos40['isps']." <br> GRI 1 ".$datos40['gri_1']." <br> Peak Season ".$datos40['peak_season']." <br> GRI 2 ".$datos40['gri_2']." <br> GRI 3 ".$datos40['gri_3']." <br> Courrier ".$datos40['courrier']." <br> Coload Fee ".$datos40['coload_fee']." <br> Port Congestion ".$datos40['port_congestion']." <br> GRI 4 ".$datos40['margen']." <center><strong><br> All In ".$datos40['all_in']." <br> Flete + BAF + ISPS + GRI 1 + GRI 2 + GRI 3 + Peak Season + Courrier + Coload Fee + Port Congestion + GRI 4 <br></strong></center> ";
			
			$msg40hq = "Flete ".$datos40hq['flete']." <br> BAF ".$datos40hq['baf']." <br> ISPS ".$datos40hq['isps']." <br> GRI 1 ".$datos40hq['gri_1']." <br> Peak Season ".$datos40hq['peak_season']." <br> GRI 2 ".$datos40hq['gri_2']." <br> GRI 3 ".$datos40hq['gri_3']." <br> Courrier ".$datos40hq['courrier']." <br> Coload Fee ".$datos40hq['coload_fee']." <br> Port Congestion ".$datos40hq['port_congestion']." <br> GRI 4 ".$datos40hq['margen']." <center><strong><br> All In ".$datos40hq['all_in']." <br> Flete + BAF + ISPS + GRI 1 + GRI 2 + GRI 3 + Peak Season + Courrier + Coload Fee + Port Congestion + GRI 4 <br></strong></center> ";				
			
			if($_POST['filtrado']=='1')
				$sqlv = "select * from cot_fletes_tmp where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosad[idtarifario]'";	
			else
				$sqlv = "select * from cot_fletes where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosad[idtarifario]'";
			$exev = mysql_query($sqlv, $link);
			$datosv =  mysql_fetch_array($exev);
			?>
							
			<td class="contenidotab" style="color:<? print $color; ?>">
				<input  type="text" id="all_in_20<? print $datosad['idtarifario']; ?>" name="all_in_20<? print $datosad['idtarifario']; ?>" class="tex2" value="<? if($datosv['all_in_20']=='') print $datos20['all_in']; else print $datosv['all_in_20']; ?>" maxlength="20" size="3" onchange="formulario.n_all_in_20<? print $datos20['idtipo']; ?>.value=this.value" onblur="validarFletes('20', <? print $datosad['idtarifario']; ?>, <? if($datosv['all_in_20']=='') print $datos20['all_in']; else print $datosv['all_in_20']; ?>, <? print $datos20['all_in']; ?>, <? print $datos20['margen']; ?>);" style="color:<? print $color; ?>;width:45px;"/>
							
				<input type="hidden" id="n_all_in_20<? print $datos20['idtipo']; ?>"  name="n_all_in_20<? print $datos20['idtipo']; ?>" value="<? if($datosv['all_in_20']=='') print $datos20['all_in']; else print $datosv['all_in_20']; ?>"/>
				
				<input id="sel20" name="sel20[]" type="checkbox" onClick="" value="<? print $datos20['idtipo']; ?>" onMouseOver="return overlib('<? print $msg20;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" <? if(in_array($datos20['idtipo'], $idfletes) /*|| in_array($datos20['idtipo'], $idfletes_tmp)*/) print 'checked'; ?>/> <? //print $datos20['idtipo']; ?>
				<input type="hidden" id="u_all_in_20<? print $datosad['idtarifario']; ?>" name="u_all_in_20<? print $datosad['idtarifario']; ?>" value="" />
			</td> 
			
			<td class="contenidotab" style="color:<? print $color; ?>">
				<input type="text" id="all_in_40<? print $datosad['idtarifario']; ?>" name="all_in_40<? print $datosad['idtarifario']; ?>" class="tex2" value="<? if($datosv['all_in_40']=='') print $datos40['all_in']; else print $datosv['all_in_40']; ?>" maxlength="20" size="3" onchange="formulario.n_all_in_40<? print $datos40['idtipo']; ?>.value=this.value" onblur="validarFletes('40', <? print $datosad['idtarifario']; ?>, <? if($datosv['all_in_40']=='') print $datos40['all_in']; else print $datosv['all_in_40']; ?>, <? print $datos40['all_in']; ?>, <? print $datos40['margen']; ?>);" style="color:<? print $color; ?>;width:45px;"/>
				
				<input type="hidden" id="n_all_in_40<? print $datos40['idtipo']; ?>"  name="n_all_in_40<? print $datos40['idtipo']; ?>" value="<? if($datosv['all_in_40']=='') print $datos40['all_in']; else print $datosv['all_in_40']; ?>"/>
				
				<input id="sel40" name="sel40[]" type="checkbox" onClick="" value="<? print $datos40['idtipo']; ?>" onMouseOver="return overlib('<? print $msg40;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" <? if(in_array($datos40['idtipo'], $idfletes) /*|| in_array($datos40['idtipo'], $idfletes_tmp)*/) print 'checked'; ?> /> <? //print $datos40['idtipo']; ?>
				<input type="hidden" id="u_all_in_40<? print $datosad['idtarifario']; ?>" name="u_all_in_40<? print $datosad['idtarifario']; ?>" value="" />
			</td>
			
			<td class="contenidotab" style="color:<? print $color; ?>">
				<input type="text" id="all_in_40hq<? print $datosad['idtarifario']; ?>" name="all_in_40hq<? print $datosad['idtarifario']; ?>" class="tex2" value="<? if($datosv['all_in_40hq']=='') print $datos40hq['all_in']; else print $datosv['all_in_40hq']; ?>" maxlength="20" size="3" onchange="formulario.n_all_in_40hq<? print $datos40hq['idtipo']; ?>.value=this.value" onblur="validarFletes('40hq', <? print $datosad['idtarifario']; ?>, <? if($datosv['all_in_40hq']=='') print $datos40hq['all_in']; else print $datosv['all_in_40hq']; ?>, <? print $datos40hq['all_in']; ?>, <? print $datos40hq['margen']; ?>);" style="color:<? print $color; ?>;width:45px;"/>
				
				<input type="hidden" id="n_all_in_40hq<? print $datos40hq['idtipo']; ?>"  name="n_all_in_40hq<? print $datos40hq['idtipo']; ?>" value="<? if($datosv['all_in_40hq']=='') print $datos40hq['all_in']; else print $datosv['all_in_40hq']; ?>"/>
				
				<input id="sel40hq" name="sel40hq[]" type="checkbox" onClick="" value="<? print $datos40hq['idtipo']; ?>" onMouseOver="return overlib('<? print $msg40hq;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" <? if(in_array($datos40hq['idtipo'], $idfletes) /*|| in_array($datos40hq['idtipo'], $idfletes_tmp)*/) print 'checked'; ?> />  <? //print $datos40hq['idtipo']; ?>
				<input type="hidden" id="u_all_in_40hq<? print $datosad['idtarifario']; ?>" name="u_all_in_40hq<? print $datosad['idtarifario']; ?>" value="" /> 
			</td>                
			
			<td class="contenidotab" style="color:<? print $color; ?>">
				<input id="baf<? print $datosad['idtarifario']; ?>" name="baf<? print $datosad['idtarifario']; ?>" type="checkbox" value="1" onclick="validarcheckeo_fcl(this.name, 'n_baf<? print $datos20['idtipo']; ?>', 'n_baf<? print $datos40['idtipo']; ?>', 'n_baf<? print $datos40hq['idtipo']; ?>')" <? if($datosv['baf']=='1') print 'checked'; ?>/>				
				<input type="hidden" id="n_baf<? print $datos20['idtipo']; ?>" value="<? if($datosv['baf']=='1') print $datosv['baf']; else print '0'; ?>" />
				<input type="hidden" id="n_baf<? print $datos40['idtipo']; ?>" value="<? if($datosv['baf']=='1') print $datosv['baf']; else print '0'; ?>" />
				<input type="hidden" id="n_baf<? print $datos40hq['idtipo']; ?>" value="<? if($datosv['baf']=='1') print $datosv['baf']; else print '0'; ?>" />
			</td>
			
			
			
			<td class="contenidotab" style="color:<? print $color; ?>">
				<input id="gri<? print $datosad['idtarifario']; ?>" name="gri<? print $datosad['idtarifario']; ?>" type="checkbox" value="1" <? if($datosv['gri']=='1') print 'checked'; ?> onclick="validarcheckeo_fcl(this.name, 'n_gri<? print $datos20['idtipo']; ?>', 'n_gri<? print $datos40['idtipo']; ?>', 'n_gri<? print $datos40hq['idtipo']; ?>')"/>
				<input type="hidden" id="n_gri<? print $datos20['idtipo']; ?>" value="<? if($datosv['gri']=='1') print $datosv['gri']; else print '0'; ?>" />
				<input type="hidden" id="n_gri<? print $datos40['idtipo']; ?>" value="<? if($datosv['gri']=='1') print $datosv['gri']; else print '0'; ?>" />
				<input type="hidden" id="n_gri<? print $datos40hq['idtipo']; ?>" value="<? if($datosv['gri']=='1') print $datosv['gri']; else print '0'; ?>" />
			</td>
			<td class="contenidotab" style="color:<? print $color; ?>">
				<input id="pss<? print $datosad['idtarifario']; ?>" name="pss<? print $datosad['idtarifario']; ?>" type="checkbox" value="1" <? if($datosv['pss']=='1') print 'checked'; ?> onclick="validarcheckeo_fcl(this.name, 'n_pss<? print $datos20['idtipo']; ?>', 'n_pss<? print $datos40['idtipo']; ?>', 'n_pss<? print $datos40hq['idtipo']; ?>')"/>
				<input type="hidden" id="n_pss<? print $datos20['idtipo']; ?>" value="<? if($datosv['pss']=='1') print $datosv['pss']; else print '0'; ?>" />
				<input type="hidden" id="n_pss<? print $datos40['idtipo']; ?>" value="<? if($datosv['pss']=='1') print $datosv['pss']; else print '0'; ?>" />
				<input type="hidden" id="n_pss<? print $datos40hq['idtipo']; ?>" value="<? if($datosv['pss']=='1') print $datosv['pss']; else print '0'; ?>" />
			</td>
		 	
		</tr>     
	
	<?
	}
	?>   

</table>

</div>