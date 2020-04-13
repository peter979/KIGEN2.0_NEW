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

<?
/*print '$_GET[filtro1] '.$_GET['filtro1'].'<br>';
print '$_GET[filtro2] '.$_GET['filtro2'].'<br>';
print '$_GET[filtro3] '.$_GET['filtro3'].'<br>';
print '$_GET[filtro4] '.$_GET['filtro4'].'<br>';*/

if($_GET['filtradotm']=='1')
	$sqlo = "select idcot_otm from rn_otm_tmp where idreporte='$_GET[idcot_temp]'";
else
	$sqlo = "select idcot_otm from rn_otm where idreporte='$_GET[idcot_temp]'";
//print $sqlo.'<br>';
$exeo = mysql_query($sqlo, $link);
$idotms[] = '0';
while ($datoso = mysql_fetch_array($exeo))
{
	$idotms[] = scai_get_name("$datoso[idcot_otm]", "cot_otm", "idcot_otm", "idotm");
}
//print_r($idotms);
?>
<table width="100%"> 
    <tr>
        <td class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10">Seleccionar</td>
        <td class="tittabla">Devolucion contenedor (FCL)</td>
        <td class="tittabla">Servicio de escoltas</td> 
        <td class="tittabla">Proveedor OTM</td>        
        <td class="tittabla">Nombre</td>
        <td class="tittabla"><? if($_GET['cl']=='fcl') print 'Tipo'; elseif($_GET['cl']=='lcl') print 'Rango'; ?></td> 
        <td class="tittabla">Puerto Origen</td>
        <td class="tittabla">Ciudad Destino</td>
      	<td class="tittabla">Valor($)</td>
        <td class="tittabla">Fecha validez</td>
    </tr>    
        <?		 
		$sqlotm="select * from otm where clasificacion='$_GET[cl]' and idotm in (select idotm from cot_otm where idcot_temp='$_GET[idcot_temp]')";
		
		//print 'ver_sel_otm'.$_GET['ver_sel_otm'].'<br>';
		if($_GET['ver_sel_otm']=='1')
			$sqlotm .= " and idotm in (select idotm from cot_otm where idcot_temp='$_GET[idcot_temp]')";			
			
		if ($_GET['filtro1']!='' && $_GET['filtro1']!='N')
			$sqlotm .= " AND  idproveedor='$_GET[filtro1]'";
		if ($_GET['filtro2']!='' && $_GET['filtro2']!='N')
			$sqlotm .= " AND idtipotm='$_GET[filtro2]'";
		if ($_GET['filtro3']!='' && $_GET['filtro3']!='N')
			$sqlotm .= " AND  puerto_origen='$_GET[filtro3]'";
		if ($_GET['filtro4']!='' && $_GET['filtro4']!='N')
			$sqlotm .= " AND idciudad='$_GET[filtro4]'";
		$sqlotm .= " and estado='1'";
		//print $sqlotm.'<br>';
		$exeotm=mysql_query($sqlotm,$link);
		$cant=mysql_num_rows($exeotm);	
		
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
        $sqlpag = $sqlotm." LIMIT $regini, $regxpag";
        $buscarpag=mysql_query($sqlpag,$link);
        $cantpag=mysql_num_rows($buscarpag);
        for($i=0;$i<$cantpag;$i++)
        {
            $datosotm=mysql_fetch_array($buscarpag);
			
			$sqln = "select NOW() as ahora";
			$exen = mysql_query($sqln, $link);
			$datosn3 = mysql_fetch_array($exen);
			$color = '#000000';	
			if($datosotm['fecha_validez'] < $datosn3['ahora'])
				$color = '#FF0000';
			?>  
             <tr>                   
                <td class="contenidotab" style="color:<? print $color; ?>"><input id="selotm" name="selotm[]" type="checkbox" onClick="" value="<? print $datosotm['idotm']; ?>" <? if(in_array($datosotm['idotm'], $idotms)) print 'checked'; ?>/></td>
                
                <?
				if($_GET['filtradotm']=='1')
					$sqlv = "select * from cot_otm_tmp where idcot_temp='$_GET[idcot_temp]' and idotm='$datosotm[idotm]'";
				else
					$sqlv = "select * from cot_otm where idcot_temp='$_GET[idcot_temp]' and idotm='$datosotm[idotm]'";
				//print $sqlv.'<br>';
				$exev = mysql_query($sqlv, $link);
				$datosv =  mysql_fetch_array($exev);
				?>
                <td class="contenidotab" style="color:<? print $color; ?>">
                <input id="selotm_dev<? print $datosotm['idotm']; ?>" name="selotm_dev<? print $datosotm['idotm']; ?>" type="checkbox" value="1" <? if($datosv['devolucion']=='1') print 'checked'; ?> onclick="validarcheckeo(this.name, 'n_selotm_dev<? print $datosotm['idotm']; ?>')" <? if($_GET['cl']=='lcl') print 'disabled'; ?> disabled/>
                
                <input type="hidden" id="n_selotm_dev<? print $datosotm['idotm']; ?>" value="<? if($datosv['devolucion']=='1') print $datosv['devolucion']; else print '0'; ?>" />
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                <input id="selotm_esc<? print $datosotm['idotm']; ?>" name="selotm_esc<? print $datosotm['idotm']; ?>" type="checkbox" value="1" <? if($datosv['escolta']=='1') print 'checked'; ?> onclick="validarcheckeo(this.name, 'n_selotm_esc<? print $datosotm['idotm']; ?>')" disabled/>
                
                <input type="hidden" id="n_selotm_esc<? print $datosotm['idotm']; ?>" value="<? if($datosv['escolta']=='1') print $datosv['escolta']; else print '0'; ?>" />
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosotm[idproveedor]", "proveedores_agentes", "idproveedor_agente", "nombre");?></td>                
                <td class="contenidotab" style="color:<? print $color; ?>"><? print $datosotm['nombre'];?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosotm[idtipotm]", "tipotm", "idtipotm", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosotm[puerto_origen]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print scai_get_name("$datosotm[idciudad]", "ciudades", "idciudad", "nombre");?></td>
                <td class="contenidotab" style="color:<? print $color; ?>">
                	<? $msg = 'Valor compra: '.$datosotm['valor'].'<br>Margen: '.$datosotm['margen']; ?>
                    <input id="venta_otm<? print $datosotm['idotm']; ?>" name="venta_otm<? print $datosotm['idotm']; ?>" type="text" onClick="" value="<? if($datosv['valor_venta']=='') print $datosotm['valor_venta']; else print $datosv['valor_venta']; ?>" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>" readonly>
                </td>
                <td class="contenidotab" style="color:<? print $color; ?>"><? print substr($datosotm['fecha_validez'], 0, 10);?></td>
            </tr>          
        <?
        }
        ?> 
</table>

<?
$sqlrg = "select * from recargos_local_otm where clasificacion='$_GET[cl]' and estado='1'";
//print $sqlrg .'<br>';
$exerg = mysql_query($sqlrg, $link);
$filasrg = mysql_num_rows($exerg);
//print 'filasrg '.$filasrg.'<br>';		
if($filasrg > 0)
{
	?>
	<table width="100%" align="center"> 
	<tr>
		<td class="tittabla">Recargo</td>
		<td class="tittabla">Tipo</td>
		<td class="tittabla">Valor($)</td>
		<td class="tittabla">Minimo($)</td>
		<td class="tittabla">Fecha de validez</td>
	</tr>
	<?
	while($datosrg = mysql_fetch_array($exerg))
	{
		$checked = '';
		
		$sqlr = "select idrecargo_local from rn_local_otm_por_cotizacion where idreporte='$_GET[idcot_temp]'";
		//print $sqlr.'<br>';
		$exer = mysql_query($sqlr, $link);
		while($datosr = mysql_fetch_array($exer))
		{
			if($datosr['idrecargo_local'] == $datosrg['idrecargo_local'])
				$checked = 'checked';
		}
		
		$sqlv = "select * from local_otm_por_cotizacion where idcot_temp='$_GET[idcot_temp]' and idrecargo_local='$datosrg[idrecargo_local]'";
		//print $sqlv.'<br>';
		$exev = mysql_query($sqlv, $link);
		$datosv = mysql_fetch_array($exev);
		
		$sqln = "select NOW() as ahora";
		$exen = mysql_query($sqln, $link);
		$datosn3 = mysql_fetch_array($exen);
		$color = '#000000';	
		if($datosrg['fecha_validez'] < $datosn3['ahora'])
			$color = '#FF0000';	
		?>
		<tr>
			<td class="contenidotab" style="color:<? print $color; ?>">   
				<input id="recargo_otm<? print $datosrg['idrecargo_local']; ?>" name="recargo_otm<? print $datosrg['idrecargo_local']; ?>" type="checkbox" class="tex1" value="<? print $datosrg['idrecargo_local']; ?>" <? print $checked; ?> onClick="addi(this.value,this.name,'<? print $datosrg['tipo']; ?>','<? print $datosrg['idproveedor']; ?>','<? print $datosrg['clasificacion']; ?>')" ><? print $datosrg['nombre'];?>
			</td>
			<td class="contenidotab" style="color:<? print $color; ?>"><? print $datosrg['tipo'];?></td>
			<td class="contenidotab" style="color:<? print $color; ?>">
				<? $msg = 'Valor compra: '.$datosrg['valor'].'<br>Margen: '.$datosrg['margen']; ?>
				<input type="text" id="recargo_otm_valor_venta<? print $datosrg['idrecargo_local']; ?>" name="recargo_otm_valor_venta<? print $datosrg['idrecargo_local']; ?>" class="tex2" value="<? if($datosv['valor_venta']=='') { if($datosrg['valor_venta']=='') print '0'; else print $datosrg['valor_venta']; } else print $datosv['valor_venta']; ?>" onBlur="addi('<? print $datosrg['idrecargo_local']; ?>','<? print 'recargo'.$datosrg['idrecargo_local']; ?>','<? print $datosrg['tipo']; ?>','<? print $datosrg['idnaviera']; ?>','<? print $datosrg['clasificacion']; ?>')" maxlength="20" size="3" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>" readonly/>
			</td>
			<td class="contenidotab" style="color:<? print $color; ?>">
				<? $msg = 'Minimo compra: '.$datosrg['minimo'].'<br>Margen: '.$datosrg['margen_minimo']; ?>
				<input type="text" id="recargo_otm_minimo_venta<? print $datosrg['idrecargo_local']; ?>" name="recargo_otm_minimo_venta<? print $datosrg['idrecargo_local']; ?>" class="tex2" value="<? if($datosv['minimo_venta']=='') {if($datosrg['minimo_venta']=='') print '0'; print $datosrg['minimo_venta']; } else print $datosv['minimo_venta']; ?>" maxlength="20" size="3" onMouseOver="return overlib('<? print $msg;?>', BELOW, LEFT, BGCOLOR, '#FF9900', FGCOLOR, '#FF6600', TEXTCOLOR, '#FFFFFF', WIDTH , '200');" onMouseOut="return nd();" style="color:<? print $color; ?>" readonly/>
			</td>
			<td class="contenidotab" style="color:<? print $color; ?>"><? print substr($datosrg['fecha_validez'],0 ,10); ?></td>
			</td>
		</tr>
		<?
	}
	?>
	</table>
    <?
}
?>
</div>