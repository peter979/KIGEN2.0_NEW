<?
include('sesion/sesion.php');
include("conection/conectar.php");	
include_once("permite.php");
include_once("scripts/recover_nombre.php");
$sesi=session_id();		  
?>
<script>
function validarcheckeo(name, id){

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

<div id="eyes_dta" style="width:100%; height:50%; overflow-x: scroll; overflow-y: scroll;">


<table width="100%"> 
    <tr>
        <td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Seleccionar</td>
        <td class="tittabla">Devolucion contenedor</td>
        <td class="tittabla">Servicio de escoltas</td> 
        <td class="tittabla">Proveedor</td>

        
        <td class="tittabla">Nombre</td>
        <td class="tittabla"><? if($_GET['cl']=='aereo') print 'Aeropuerto Origen'; else print 'Puerto Origen'; ?></td>
        <td class="tittabla">Ciudad Destino</td>
      	<td class="tittabla">Valor($)</td>
      	<td class="tittabla">Moneda</td>
      	<td class="tittabla">Observaciones</td>
        <td class="tittabla">Fecha validez</td>
    </tr>    
        <?
		$sqlo = "select iddta from cot_dta where idcot_temp='$_GET[idcot_temp]'";
		$exeo = mysql_query($sqlo, $link);
		$iddtas[] = '0';
		while ($datoso = mysql_fetch_array($exeo))
		{
			$iddtas[] = $datoso['iddta'];
		}
				
		$sqldta="select * from dta where clasificacion='$_GET[cl]'";
		if ($_GET['filtro1']!='' && $_GET['filtro1']!='N')
			$sqldta .= " AND  idproveedor='$_GET[filtro1]'";
		if ($_GET['filtro2']!='')
			$sqldta .= " AND (nombre like '%$_GET[filtro2]%' or idtipodta in (select idtipodta from tipodta where nombre like '%$_GET[filtro2]%'))";
		if ($_GET['filtro3']!='' && $_GET['filtro3']!='N')
			$sqldta .= " AND  puerto_origen='$_GET[filtro3]'";
		if ($_GET['filtro4']!='' && $_GET['filtro4']!='N')
			$sqldta .= " AND idciudad='$_GET[filtro4]'";
		$sqldta .= " and estado='1'";	
		$exedta=mysql_query($sqldta,$link);
		$cant=mysql_num_rows($exedta);	
                $pag = 1;
        $buscarpag=mysql_query($sqldta,$link);
        $cantpag=mysql_num_rows($buscarpag);
        while($datosdta=mysql_fetch_array($buscarpag)){
			
			$sqln = "select NOW() as ahora";
			$exen = mysql_query($sqln, $link);
			$datosn3 = mysql_fetch_array($exen);
			$color = '#000000';	
			if($datosdta['fecha_validez'] < $datosn3['ahora'])
				$color = '#FF0000';
			?>  
             <tr>                   
                <td class="contenidotab" style="color:<? print $color; ?>"><input id="seldta" name="seldta[]" type="checkbox" onClick="" value="<? print $datosdta['iddta']; ?>" <? if(in_array($datosdta['iddta'], $iddtas)) print 'checked'; ?>/></td>
                
                <?
				$sqlv = "select * from cot_dta where idcot_temp='$_GET[idcot_temp]' and iddta='$datosdta[iddta]'";
				$exev = mysql_query($sqlv, $link);
				$datosv =  mysql_fetch_array($exev);
				?>
                <td class="contenidotab" style="color:<? print $color; ?>">
                <input id="seldta_dev<? print $datosdta['iddta']; ?>" name="seldta_dev<? print $datosdta['iddta']; ?>" type="checkbox" value="1" <? if($datosv['devolucion']=='1') print 'checked'; ?> onclick="validarcheckeo(this.name, 'n_seldta_dev<? print $datosdta['iddta']; ?>')"/>
                
                <input type="hidden" id="n_seldta_dev<? print $datosdta['iddta']; ?>" value="<? if($datosv['devolucion']=='1') print $datosv['devolucion']; else print '0'; ?>" />
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                <input id="seldta_esc<? print $datosdta['iddta']; ?>" name="seldta_esc<? print $datosdta['iddta']; ?>" type="checkbox" value="1" <? if($datosv['escolta']=='1') print 'checked'; ?> onclick="validarcheckeo(this.name, 'n_seldta_esc<? print $datosdta['iddta']; ?>')"/>
                
                <input type="hidden" id="n_seldta_esc<? print $datosdta['iddta']; ?>" value="<? if($datosv['escolta']=='1') print $datosv['escolta']; else print '0'; ?>" />
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosdta[idproveedor]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
                

                
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosdta['nombre'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosdta[puerto_origen]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosdta[idciudad]", "ciudades", "idciudad", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<? $msg = 'Valor compra: '.$datosdta['valor'].'<br>Margen: '.$datosdta['margen']; ?>
                    <input id="venta_dta<? print $datosdta['iddta']; ?>" name="venta_dta<? print $datosdta['iddta']; ?>" type="text" onClick="" value="<? if($datosv['valor_venta']=='') print $datosdta['valor_venta']; else print $datosv['valor_venta']; ?>" onMouseOver="return overlib('<? print $msg;?>', BELOW, BGCOLOR, '#000000', FGCOLOR, '#FFFFFF', TEXTCOLOR, '#787878' , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>">
                    <input type="hidden" id="u_venta_dta<? print $datosdta['iddta']; ?>" name="u_venta_dta<? print $datosdta['iddta']; ?>" value="" />
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>"><?print scai_get_name("$datosdta[moneda]", "monedas", "idmoneda", "codigo");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosdta['observaciones'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print substr($datosdta['fecha_validez'], 0, 10);?></td>
            </tr>          
        <?
        }
        ?> 
</table>
</div>