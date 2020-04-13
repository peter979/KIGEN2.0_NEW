<table width="100%"> 
    <tr>
    	<td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Seleccionar</td>
        <td class="tittabla">Proveedor bodega</td> 
        <td class="tittabla">Tarifa ad-valoren/CIF(%)</td>
        <? if($_GET['cl']=='lcl' || $_GET['cl']=='aereo') { ?>
            <td class="tittabla">Minimo Tarifa ad-valoren/CIF($)</td>
        <? } ?>
        <td class="tittabla"><? if($_GET['cl']=='lcl' || $_GET['cl']=='aereo') print 'Tarifa por mes o fracci&oacute;n'; elseif($_GET['cl']=='fcl') print 'Tarifa integral para contenedor de 20 por mes o fracci&oacute;n'; ?>($)</td>
        
		<? if($_GET['cl']=='lcl' || $_GET['cl']=='aereo') { ?>
        <td class="tittabla">Minimo Tarifa por mes o fracci&oacute;n($)</td>
        <? } ?>
        
		<? if($_GET['cl']=='fcl') { ?>
        <td class="tittabla">Tarifa integral para contenedor de 40 por mes o fracci&oacute;n($)</td> 
        <? } ?>
        
        <td class="tittabla">Manejo de carga x Kg.</td>
        <td class="tittabla">Minimo Manejo de carga x Kg.</td>
        <td class="tittabla">Fecha validez</td>        
    </tr>    
        <?
		$sqlad="select * from bodega where clasificacion='$_GET[cl]' and estado='1' and idbodega in (select idbodega from cot_bodegas where idcot_temp='$_GET[idcot_temp]')";
		//print $sqlad;
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
        
		$sqlbg = "select idcot_bodega from rn_bodegas where idreporte='$_GET[idcot_temp]'";
		//print $sqlbg.'<br>';
		$exebg = mysql_query($sqlbg, $link);
		$idbodegas[] = '0';
		while ($datosbg = mysql_fetch_array($exebg))
		{
			$idbodegas[] = scai_get_name("$datosbg[idcot_bodega]", "cot_bodegas", "	idcot_bodega", "idbodega");
		}				
     
		for($i=0;$i<$cantpag;$i++)
        {
            $datosad=mysql_fetch_array($buscarpag);
			
			$sqlv = "select * from cot_bodegas where idbodega='$datosad[idbodega]' and idcot_temp='$_GET[idcot_temp]'";
			//print $sqlv.'<br>';
			$exev = mysql_query($sqlv, $link);
			$datosv =  mysql_fetch_array($exev);
			
			$sqln = "select NOW() as ahora";
			$exen = mysql_query($sqln, $link);
			$datosn3 = mysql_fetch_array($exen);
			$color = '#000000';	
			if($datosad['fecha_validez'] < $datosn3['ahora'])
				$color = '#FF0000';	
            ?>  
             <tr>
             	<td class="contenidotab" style="color:<? print $color; ?>"><input name="selbg[]" type="checkbox" onClick="" value="<? print $datosad['idbodega']; ?>" <? if(in_array($datosad['idbodega'], $idbodegas)) print 'checked'; ?> /></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosad[idproveedor]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<? $msg = 'Tarifa ad-valoren/CIF(%) compra: '.$datosad['advaloren'].'<br>Margen: '.$datosad['margen']; ?>             
                	<input type="text" id="advaloren_venta<? print $datosad['idbodega']; ?>" name="advaloren_venta<? print $datosad['idbodega']; ?>" class="tex2" value="<? if($datosv['advaloren_venta']=='') print $datosad['advaloren_venta']; else print $datosv['advaloren_venta']; ?>" maxlength="20" size="3" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>" readonly/>
                </td>
                <? if($_GET['cl']=='lcl' || $_GET['cl']=='aereo') { ?>
                    <td class="contenidotab" style="color:<? print $color; ?>">
                    	<? $msg = 'Minimo Tarifa ad-valoren/CIF compra: '.$datosad['min_advaloren'].'<br>Margen: '.$datosad['margen_min_advaloren']; ?>
                        <input type="text" id="min_advaloren<? print $datosad['idbodega']; ?>" name="min_advaloren<? print $datosad['idbodega']; ?>" class="tex2" value="<? if($datosv['min_advaloren']=='') print $datosad['min_advaloren_venta']; else print $datosv['min_advaloren']; ?>" maxlength="20" size="3" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>" readonly/>
                    </td>
                <? } ?>
                <td class="contenidotab" style="color:<? print $color; ?>">  
                	<? if($_GET['cl']=='lcl' || $_GET['cl']=='aereo') $msg = 'Tarifa por mes o fracci&oacute;n '; elseif($_GET['cl']=='fcl') $msg = 'Tarifa integral para contenedor de 20 por mes o fracci&oacute;n'; $msg .= 'compra: '.$datosad['mes_fraccion'].'<br>Margen: '.$datosad['margen_mes_fraccion']; ?>           
                	<input type="text" id="mes_fraccion_venta<? print $datosad['idbodega']; ?>" name="mes_fraccion_venta<? print $datosad['idbodega']; ?>" class="tex2" value="<? if($datosv['mes_fraccion_venta']=='') print $datosad['mes_fraccion_venta']; else print $datosv['mes_fraccion_venta']; ?>" maxlength="20" size="3" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>" readonly/>
                </td>
                
                <? if($_GET['cl']=='lcl' || $_GET['cl']=='aereo') { ?>
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<? $msg = 'Minimo Tarifa por mes o fracci&oacute;n compra: '.$datosad['min_mes_fraccion'].'<br>Margen: '.$datosad['margen_min_mes_fraccion']; ?>
                	<input type="text" id="min_mes_fraccion<? print $datosad['idbodega']; ?>" name="min_mes_fraccion<? print $datosad['idbodega']; ?>" class="tex2" value="<? if($datosv['min_mes_fraccion']=='') print $datosad['min_mes_fraccion_venta']; else print $datosv['min_mes_fraccion']; ?>" maxlength="20" size="3" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>" readonly/>
                </td>
                <? } ?>
                
                <? if($_GET['cl']=='fcl') { ?>
                <td class="contenidotab" style="color:<? print $color; ?>"> 
                	<? $msg = 'Tarifa integral para contenedor de 40 por mes o fracci&oacute;n compra: '.$datosad['mes_fraccion_40'].'<br>Margen: '.$datosad['margen_mes_fraccion_40']; ?>            
                	<input type="text" id="mes_fraccion_40_venta<? print $datosad['idbodega']; ?>" name="mes_fraccion_40_venta<? print $datosad['idbodega']; ?>" class="tex2" value="<? if($datosv['mes_fraccion_40_venta']=='') print $datosad['mes_fraccion_40_venta']; else print $datosv['mes_fraccion_40_venta']; ?>" maxlength="20" size="3" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>" readonly/>
                </td>
                <? } ?>
                
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['manejo'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosad['min_manejo'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print substr($datosad['fecha_validez'],0 ,10);?></td>                
            </tr>          
        <?
        }
        ?>
</table>			  
</body>   