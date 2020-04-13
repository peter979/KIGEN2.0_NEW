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
function validarcheckeo(name, id)
{
	if(document.getElementById(name).checked)
	{
		document.getElementById(id).value = '1';
	}
	else
	{
		document.getElementById(id).value = '0';
	}
}
</script>
				  
<div id="eyes2" style="width:100%; height:100%; overflow-x: scroll; overflow-y: scroll;">

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
        <td class="tittabla">Naviera</td>
        <td class="tittabla">Agente</td>
        <td class="tittabla">N&uacute;mero de contrato</td>
        <td class="tittabla">Puerto Origen</td>
        <td class="tittabla">Pais</td>
        <td class="tittabla">Puerto Destino</td>
        <td class="tittabla">Servicio via</td>
        <td class="tittabla">Fecha Ultima Actualizaci&oacute;n</td>
        <td class="tittabla">Tarifa valida desde</td>
        <td class="tittabla">Vigencia</td>
        <td class="tittabla">Moneda</td>
        <td class="tittabla">Observaciones</td>
        <td class="tittabla40hq">Total Venta ALL IN WM</td>    
        <td class="tittabla40hq">Minimo Venta</td>    
        <td class="tittabla20">TT Aprox</td> 
        <td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Sel</td>
        <td class="tittabla40hq">BAF</td>
    </tr>    
        <?
		/*FALTA AREGAR AL SQL BUSCAR POR NAVIERA*/
		$sqlad="select * from tarifario where 
					puerto_origen in (
						select idaeropuerto_puerto from aeropuertos_puertos where nombre like '%$_POST[origen]%') 
					and puerto_destino in (
						select idaeropuerto_puerto from aeropuertos_puertos where nombre like '%$_POST[destination]%') 
					and idnaviera in (
						select idproveedor_agente from proveedores_agentes where nombre like '%$_POST[nav]%' and tipo='coloader') 
					and clasificacion='lcl'
					and fecha_vigencia > '".date("Y-m-d")."'
					";
					
		if($_POST['ver_sel']=='1'){
			$sqlad .= " and idtarifario in (select idtarifario from cot_fletes where idcot_temp='$_POST[idcot_temp]')";
		}		
		if($_POST['aeropuerto_origen']!='' && $_POST['aeropuerto_origen']!='N')
			$sqlad .= " and idpais='$_POST[aeropuerto_origen]'";	
		
		$sqlad .= " and estado='1'";
		$exead=mysql_query($sqlad,$link);		
      	while($datosad=mysql_fetch_array($exead))
        {
			$sqlcl = "select * from tipo_lcl where idtarifario='$datosad[idtarifario]'";
			$exelcl = mysql_query($sqlcl, $link);
			$datoslcl = mysql_fetch_array($exelcl);
			
			$sqltp = "select * from tipo_lcl where idtarifario='$datosad[idtarifario]'";
			$exetp = mysql_query($sqltp, $link);
			$datostp = mysql_fetch_array($exetp);
			
			$sqln = "select NOW() as ahora";
			$exen = mysql_query($sqln, $link);
			$datosn3 = mysql_fetch_array($exen);
			$color = '#000000';	
			if($datosad['fecha_vigencia'] < $datosn3['ahora'])
				$color = '#FF0000';
            ?>  
             <tr>         
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[idnaviera]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[idagente]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['num_contrato'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[puerto_origen]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[idpais]", "paises", "idpais", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[puerto_destino]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['servicio_via'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['fecha_ul_act'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['fecha_valida'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['fecha_vigencia'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[moneda]","monedas", "idmoneda", "codigo");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['observaciones'];?></td>

                <?
				if($_POST['filtrado']=='1')
					$sqlv = "select * from cot_fletes_tmp where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosad[idtarifario]'";	
				else
					$sqlv = "select * from cot_fletes where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosad[idtarifario]'";
				$exev = mysql_query($sqlv, $link);
				$datosv =  mysql_fetch_array($exev);
				?>                
                <td class="contenidotab" style="color:<? print $color; ?>">
					<? $msg = 'TON/CBM compra: '.$datoslcl['ton_cbm'].'<br>GRI 4: '.$datoslcl['margen'].'<br>Incremento BAF: '.$datoslcl['incremento_baf']; ?>
					<input type="text" id="total_neta<? print $datosad['idtarifario']; ?>" name="total_neta<? print $datosad['idtarifario']; ?>" class="tex2" value="<? if($datosv['total_neta']=='') print $datoslcl['total_neta']; else print $datosv['total_neta']; ?>" maxlength="20" size="3" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" onchange="formulario.n_total_neta<? print $datostp['idtipo_lcl']; ?>.value=this.value" onblur="validarFletes('lcl_neta', <? print $datosad['idtarifario']; ?>, <? if($datosv['total_neta']=='') print $datoslcl['total_neta']; else print $datosv['total_neta']; ?>, <? print $datoslcl['total_neta']; ?>, <? print $datoslcl['margen']; ?>);" style="color:<? print $color; ?>;width:45px;"/>
                    
                    <input type="hidden" id="n_total_neta<? print $datostp['idtipo_lcl']; ?>"  name="n_total_neta<? print $datostp['idtipo_lcl']; ?>" value="<? if($datosv['total_neta']=='') print $datoslcl['total_neta']; else print $datosv['total_neta']; ?>" />
                    <input type="hidden" id="u_total_neta<? print $datostp['idtipo_lcl']; ?>" name="u_total_neta<? print $datostp['idtipo_lcl']; ?>" value="" />
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
					<? $msg = 'Minimo compra: '.$datoslcl['minimo'].'<br>GRI 4: '.$datoslcl['margen_minimo']; ?>
                    <input type="text" id="minimo_venta<? print $datosad['idtarifario']; ?>" name="minimo_venta<? print $datosad['idtarifario']; ?>" class="tex2" value="<? if($datosv['minimo_venta']=='') print $datoslcl['minimo_venta']; else print $datosv['minimo_venta']; ?>" maxlength="20" size="3" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" onchange="formulario.n_minimo_venta<? print $datostp['idtipo_lcl']; ?>.value=this.value" onblur="validarFletes('lcl_minimo', <? print $datosad['idtarifario']; ?>, <? if($datosv['minimo_venta']=='') print $datoslcl['minimo_venta']; else print $datosv['minimo_venta']; ?>, <? print $datoslcl['minimo_venta']; ?>, <? print $datoslcl['margen_minimo']; ?>);" style="color:<? print $color; ?>;width:45px;"/>
                    
                    <input type="hidden" id="n_minimo_venta<? print $datostp['idtipo_lcl']; ?>"  name="n_minimo_venta<? print $datostp['idtipo_lcl']; ?>" value="<? if($datosv['minimo_venta']=='') print $datoslcl['minimo_venta']; else print $datosv['minimo_venta']; ?>" />
                    <input type="hidden" id="u_minimo_venta<? print $datostp['idtipo_lcl']; ?>" name="u_minimo_venta<? print $datostp['idtipo_lcl']; ?>" value="" />
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['tiempo_trans'];?></td>
                
                <?
				if($_POST['filtrado']=='1')
					$sqlv = "select * from cot_fletes_tmp where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosad[idtarifario]'";
				else
					$sqlv = "select * from cot_fletes where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosad[idtarifario]'";
				$exev = mysql_query($sqlv, $link);
				$datosv =  mysql_fetch_array($exev);				
                ?>                   
                <td class="contenidotab" style="color:<? print $color; ?>"><input id="sel" name="sel[]" type="checkbox" onClick="" value="<? print $datostp['idtipo_lcl']; ?>" <? if(in_array($datostp['idtipo_lcl'], $idfletes)) print 'checked'; ?> /></td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                <input id="baf_lcl<? print $datosad['idtarifario']; ?>" name="baf_lcl<? print $datosad['idtarifario']; ?>" type="checkbox" value="1" onclick="validarcheckeo(this.name, 'n_baf_lcl<? print $datostp['idtipo_lcl']; ?>')" <? if($datosv['baf']=='1') print 'checked'; ?> />
                <input type="hidden" id="n_baf_lcl<? print $datostp['idtipo_lcl']; ?>" value="<? if($datosv['baf']=='1') print $datosv['baf']; else print '0'; ?>" />
                </td>
            </tr>          
        <?
        }
        ?>
		
</table>
</div>