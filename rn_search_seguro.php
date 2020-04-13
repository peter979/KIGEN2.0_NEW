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

<div id="eyes_otm" style="width:100%; height:auto; overflow-x: scroll; overflow-y: scroll;">

<table width="100%">
    <tr>
        <td class="subtitseccion" colspan="3" style="text-align:center; font-size:10px">Estas en la modalidad de seguro del reporte de negocio <? print scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero") ?><? if($datosm['flete']=='1') print '. Puedes acceder a los Shipping Instruction de seguro desde la modalidad Flete'; ?><br><br></td>
    </tr>
</table>
<table width="100%"> 
    <tr>
        <td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Seleccionar</td>
        <td class="tittabla">Proveedor</td>
        <td class="tittabla">Porcentaje(%)</td>
        <td class="tittabla">Minimo($)</td>
        <td class="tittabla">Moneda</td> 
        <td class="tittabla">Fecha creaci&oacute;n</td>
        <td class="tittabla">Fecha validez</td>
    </tr>    
        <?
		$sqlseg2 = "select * from seguro where estado='1' and idseguro in (select idseguro from cot_seg where idcot_temp='$_GET[idcot_temp]') order by fecha_creacion DESC";
		//print $sqlseg2.'<br>';
		$exeseg2 = mysql_query($sqlseg2, $link);
		
		$cant=mysql_num_rows($exeseg2);
		
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
        $buscarpag=mysql_query($sqlpag,$link);
        $cantpag=mysql_num_rows($buscarpag);
		
		
		$sqlseg = "select * from rn_seg where idreporte='$_GET[idcot_temp]'";
		//print $sqlseg.'<br>';
		$exeseg = mysql_query($sqlseg, $link);
		$idseguros[] = '0';
		
		while ($datoseg = mysql_fetch_array($exeseg))
		{
			$idseguros[] = scai_get_name("$datoseg[idcot_seg]", "cot_seg", "idcot_seg", "idseguro");
		}
		
        for($i=0;$i<$cantpag;$i++)
        {
			$datoseg2 = mysql_fetch_array($buscarpag);
			
			$sqlseg = "select * from cot_seg where idcot_temp='$_GET[idcot_temp]' and idseguro='$datoseg2[idseguro]'";
			//print $sqlseg.'<br>';
			$exeseg = mysql_query($sqlseg, $link);
			$datoseg = mysql_fetch_array($exeseg);
			
			$sqln = "select NOW() as ahora";
			$exen = mysql_query($sqln, $link);
			$datosn3 = mysql_fetch_array($exen);
			$color = '#000000';	
			if($datoseg2['fecha_validez'] < $datosn3['ahora'])
				$color = '#FF0000';		
            ?>  
             <tr> 
                <td class="contenidotab" style="color:<? print $color; ?>"><input name="selsg[]" type="checkbox" onClick="" value="<? print $datoseg2['idseguro']; ?>" <? if(in_array($datoseg2['idseguro'], $idseguros)) print 'checked'; ?> /></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datoseg2[idproveedor]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>">
					<? $msg = 'Porcentaje compra: '.$datoseg2['porcentaje'].'<br>Margen: '.$datoseg2['margen_porcentaje']; ?>
                    <input id="porcentaje<? print $datoseg2['idseguro']; ?>" name="porcentaje<? print $datoseg2['idseguro']; ?>" class="tex2" value="<? if($datoseg['porcentaje']=='') print $datoseg2['porcentaje_venta']; else print $datoseg['porcentaje']; ?>" maxlength="50" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>" readonly>
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<? $msg = 'Minimo compra: '.$datoseg2['minimo'].'<br>Margen: '.$datoseg2['margen_minimo']; ?>
                	<input id="minimo_seg<? print $datoseg2['idseguro']; ?>" name="minimo_seg<? print $datoseg2['idseguro']; ?>" class="tex2" value="<? if($datoseg['minimo']=='') print $datoseg2['minimo_venta']; else print $datoseg['minimo']; ?>" maxlength="50" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>" readonly>
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datoseg2[moneda]", "monedas", "idmoneda", "codigo");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datoseg2['fecha_creacion'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datoseg2['fecha_validez'];?></td>
            </tr>
            <?
        }
        ?>
</table>
<?
$sqlseg = "select * from cot_seg where idcot_temp='$_GET[idcot_temp]'";
//print $sqlseg.'<br>';
$exeseg = mysql_query($sqlseg, $link);
$datoseg = mysql_fetch_array($exeseg);
?>    
<table align="center">	
    <tr>
        <td class="contenidotab">Monto Asegurable</td> 
        <td><input id="monto_aseg" name="monto_aseg" class="tex2" value="<? print $datoseg['monto_aseg']; ?>" maxlength="50" readonly></td>
    </tr>
</table>
</div>