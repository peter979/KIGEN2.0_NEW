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
        <td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Seleccionar</td>
        <td class="tittabla">Proveedor</td>
        <td class="tittabla">Porcentaje(%)</td>
        <td class="tittabla">Minimo($)</td>
        <td class="tittabla">Moneda</td>
        <td class="tittabla">Fecha creaci&oacute;n</td>
        <td class="tittabla">Fecha validez</td>
    </tr>    
        <?
		$sqladu2 = "select * from aduana where estado='1' and idaduana in (select idaduana from cot_adu where idcot_temp='$_GET[idcot_temp]') order by fecha_creacion";
		//print $sqladu2 .'<br>';
		$exeadu2 = mysql_query($sqladu2 , $link);
		
		$cant=mysql_num_rows($exeadu2);
		
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
        $sqlpag = $sqladu2 ." LIMIT $regini, $regxpag";
        $buscarpag=mysql_query($sqlpag,$link);
        $cantpag=mysql_num_rows($buscarpag);
		
		
		$sqladu = "select * from rn_adu where idreporte='$_GET[idcot_temp]'";
		//print $sqladu.'<br>';
		$exeadu = mysql_query($sqladu, $link);
		
		$idaduanas[] = '0';
		
		while ($datoadu = mysql_fetch_array($exeadu))
		{
			$idaduanas[] = scai_get_name("$datoadu[idcot_adu]", "cot_adu", "idcot_adu", "idaduana");
		}

        for($i=0;$i<$cantpag;$i++)
        {
			$datoadu2 = mysql_fetch_array($buscarpag);
			
			$sqladu = "select * from cot_adu where idcot_temp='$_GET[idcot_temp]' and idaduana='$datoadu2[idaduana]'";
			//print $sqlseg.'<br>';
			$exeadu = mysql_query($sqladu, $link);
			$datoadu = mysql_fetch_array($exeadu);
			
			$sqln = "select NOW() as ahora";
			$exen = mysql_query($sqln, $link);
			$datosn3 = mysql_fetch_array($exen);
			$color = '#000000';	
			if($datoadu2['fecha_validez'] < $datosn3['ahora'])
				$color = '#FF0000';					
            ?>  
             <tr> 
                <td class="contenidotab" style="color:<? print $color; ?>"><input name="seladu[]" type="checkbox" onClick="" value="<? print $datoadu2['idaduana']; ?>" <? if(in_array($datoadu2['idaduana'], $idaduanas)) print 'checked'; ?> /></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datoadu2[idproveedor]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<? $msg = 'Porcentaje compra: '.$datoadu2['porcentaje'].'<br>Margen: '.$datoadu2['margen_porcentaje']; ?>
                    <input id="porcentaje_adu<? print $datoadu2['idaduana']; ?>" name="porcentaje_adu<? print $datoadu2['idaduana']; ?>" class="tex2" value="<? if($datoadu['porcentaje']=='') print $datoadu2['porcentaje_venta']; else print $datoadu['porcentaje']; ?>" maxlength="50" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>" readonly>
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<? $msg = 'Minimo compra: '.$datoadu2['minimo'].'<br>Margen: '.$datoadu2['margen_minimo']; ?>
                    <input id="minimo_adu<? print $datoadu2['idaduana']; ?>" name="minimo_adu<? print $datoadu2['idaduana']; ?>" class="tex2" value="<? if($datoadu['minimo']=='') print $datoadu2['minimo_venta']; else print $datoadu['minimo']; ?>" maxlength="50" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>" readonly>
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datoadu2[moneda]", "monedas", "idmoneda", "codigo");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datoadu2['fecha_creacion'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datoadu2['fecha_validez'];?></td>                
            </tr>
            <?
        }
        ?>
</table>
</div>