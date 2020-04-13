<?
include('sesion/sesion.php');
include("conection/conectar.php");	
include_once("permite.php");
include_once("scripts/recover_nombre.php");
$sesi=session_id();		  
?>
<script>
function validarcheckeo(name, id)
{
	//alert(name + ',' + id);
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

<div id="eyes_terrestre" style="width:100%; height:auto; overflow-x: scroll; overflow-y: scroll;">

<?
/*print '$_GET[filtro1] '.$_GET['filtro1'].'<br>';
print '$_GET[filtro2] '.$_GET['filtro2'].'<br>';
print '$_GET[filtro3] '.$_GET['filtro3'].'<br>';
print '$_GET[filtro4] '.$_GET['filtro4'].'<br>';*/
?>
<table width="100%"> 
    <tr>
        <td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Seleccionar</td>
        <td class="tittabla">Devolucion contenedor</td>
        <td class="tittabla">Servicio de escoltas</td>
        <td class="tittabla">Proveedor</td>
        <? if($_GET['cl']=='fcl' || $_GET['cl']=='lcl') { ?>
        <td class="tittabla"><? if($_GET['cl']=='fcl') print 'Tipo'; elseif($_GET['cl']=='lcl') print 'Rango'; ?></td> 
        <? } ?>
        
        <td class="tittabla">Nombre</td>
        <td class="tittabla"><? if($_GET['cl']=='aereo') print 'Aeropuerto Origen'; else print 'Puerto Origen'; ?></td>
        <td class="tittabla">Ciudad Destino</td>
      	<td class="tittabla">Valor($)</td>
        <td class="tittabla">Fecha validez</td>
    </tr>    
        <?
		$sqlo = "select idcot_terrestre from rn_terrestre where idreporte='$_GET[idcot_temp]'";
		//print $sqlo.'<br>';
		$exeo = mysql_query($sqlo, $link);
		$idterrestres[] = '0';
		while ($datoso = mysql_fetch_array($exeo))
		{
			$idterrestres[] =  scai_get_name("$datoso[idcot_terrestre]", "cot_terrestre", "idcot_terrestre", "idterrestre");
		}
		//print_r($idterrestres); 	
				
		$sqlterrestre="select * from terrestre where clasificacion='$_GET[cl]' and idterrestre in (select idterrestre from cot_terrestre where idcot_temp='$_GET[idcot_temp]')";
		if ($_GET['filtro1']!='' && $_GET['filtro1']!='N')
			$sqlterrestre .= " AND  idproveedor='$_GET[filtro1]'";
		if ($_GET['filtro2']!='')
			$sqlterrestre .= " AND (nombre like '%$_GET[filtro2]%' or idtipoterrestre in (select idtipoterrestre from tipoterrestre where nombre like '%$_GET[filtro2]%'))";
		if ($_GET['filtro3']!='' && $_GET['filtro3']!='N')
			$sqlterrestre .= " AND  puerto_origen='$_GET[filtro3]'";
		if ($_GET['filtro4']!='' && $_GET['filtro4']!='N')
			$sqlterrestre .= " AND idciudad='$_GET[filtro4]'";
		$sqlterrestre .= " and estado='1'";	
		//print $sqlterrestre.'<br>';
		$exeterrestre=mysql_query($sqlterrestre,$link);
		$cant=mysql_num_rows($exeterrestre);	
		
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
        $sqlpag = $sqlterrestre." LIMIT $regini, $regxpag";
        $buscarpag=mysql_query($sqlpag,$link);
        $cantpag=mysql_num_rows($buscarpag);
        for($i=0;$i<$cantpag;$i++)
        {
            $datosterrestre=mysql_fetch_array($buscarpag);
			
			$sqln = "select NOW() as ahora";
			$exen = mysql_query($sqln, $link);
			$datosn3 = mysql_fetch_array($exen);
			$color = '#000000';	
			if($datosterrestre['fecha_validez'] < $datosn3['ahora'])
				$color = '#FF0000';
			?>  
             <tr>                   
                <td class="contenidotab" style="color:<? print $color; ?>"><input id="selterrestre" name="selterrestre[]" type="checkbox" onClick="" value="<? print $datosterrestre['idterrestre']; ?>" <? if(in_array($datosterrestre['idterrestre'], $idterrestres)) print 'checked'; ?>/></td>
                
                <?
				$sqlv = "select * from cot_terrestre where idcot_temp='$_GET[idcot_temp]' and idterrestre='$datosterrestre[idterrestre]'";
				//	print $sqlv.'<br>';
				$exev = mysql_query($sqlv, $link);
				$datosv =  mysql_fetch_array($exev);
				?>
                <td class="contenidotab" style="color:<? print $color; ?>">
                <input id="selterrestre_dev<? print $datosterrestre['idterrestre']; ?>" name="selterrestre_dev<? print $datosterrestre['idterrestre']; ?>" type="checkbox" value="1" <? if($datosv['devolucion']=='1') print 'checked'; ?> onclick="validarcheckeo(this.name, 'n_selterrestre_dev<? print $datosterrestre['idterrestre']; ?>')" disabled/>
                
                <input type="hidden" id="n_selterrestre_dev<? print $datosterrestre['idterrestre']; ?>" value="<? if($datosv['devolucion']=='1') print $datosv['devolucion']; else print '0'; ?>" />
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                <input id="selterrestre_esc<? print $datosterrestre['idterrestre']; ?>" name="selterrestre_esc<? print $datosterrestre['idterrestre']; ?>" type="checkbox" value="1" <? if($datosv['escolta']=='1') print 'checked'; ?> onclick="validarcheckeo(this.name, 'n_selterrestre_esc<? print $datosterrestre['idterrestre']; ?>')" disabled/>
                
                <input type="hidden" id="n_selterrestre_esc<? print $datosterrestre['idterrestre']; ?>" value="<? if($datosv['escolta']=='1') print $datosv['escolta']; else print '0'; ?>" />
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosterrestre[idproveedor]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
                
                <? if($_GET['cl']=='fcl' || $_GET['cl']=='lcl') { ?>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosterrestre[idtipoterrestre]", "tipoterrestre", "idtipoterrestre", "nombre");?></td>
                <? } ?>
                
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosterrestre['nombre'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosterrestre[puerto_origen]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosterrestre[idciudad]", "ciudades", "idciudad", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<? $msg = 'Valor compra: '.$datosterrestre['valor'].'<br>Margen: '.$datosterrestre['margen']; ?>
                    <input id="venta_terrestre<? print $datosterrestre['idterrestre']; ?>" name="venta_terrestre<? print $datosterrestre['idterrestre']; ?>" type="text" onClick="" value="<? if($datosv['valor_venta']=='') print $datosterrestre['valor_venta']; else print $datosv['valor_venta']; ?>" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>" readonly>
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print substr($datosterrestre['fecha_validez'], 0, 10);?></td>
            </tr>          
        <?
        }
        ?> 
</table>
</div>