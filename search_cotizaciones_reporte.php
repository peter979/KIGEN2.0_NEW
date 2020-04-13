<?
include('./sesion/sesion.php');
include("./conection/conectar.php");
include_once("./permite.php");
include_once("scripts/recover_nombre.php");
$sesi=session_id();

 /**************/
$_POST['nav']=str_replace(" ","%",$_POST['nav']);
$_POST['origen']=str_replace(" ","%",$_POST['origen']);
$_POST['destination']=str_replace(" ","%",$_POST['destination']);

 /****************/
?>
<div id="eyes2" style="width:100%; height:90%; overflow-x: scroll; overflow-y: scroll;">

<script>
function validaEnvia3(form, idcot)
{
	form.exi.value = idcot;
	//alert('idcot' + idcot + 'exi' + form.exi.value);
	form.submit();
}
</script>
<?
//print 'exi '.$_POST['exi'].'<br>';
if($_POST['exi']!='no')
{
	$resultado = $_POST['resultado'.$_POST['exi']];
	$vigencia = $_POST['vigencia'.$_POST['exi']];
	$sql="update cot_temp set resultado='$resultado'";

	if($vigencia != '')
		$sql .= ", vigencia='$vigencia'";

	$sql .= " where idcot_temp='$_POST[exi]'";
	//print $sql.'<br>';
	$exe = mysql_query($sql, $link);
}
?>

<input name="exi" type="hidden" value="no" />
<table width="100%">
     <tr>
        <td class="subtitseccion" colspan="3" style="text-align:center; font-size:10px">Esta en la secci&oacute;n de reporte de negocio, puede ver las cotizaciones que han sido marcadas como terminadas, para comenzar verifica que el estado de la cotizaci&oacute;n sea exitosa e ingresa la vigencia, a continuaci&oacute;n aparecer&aacute; un v&iacute;nculo Selec Modalidades, una vez seleccionadas podr&aacute; acceder a las modalidades haciendo clic en el n&uacute;mero de la cotizaci&oacute;n<br><br></td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td class="tittabla" width="1%">#</td>
        <td class="tittabla">N&uacute;mero</td>

        <td class="tittabla">Sel Modalidades</td>
        <td class="tittabla">Cliente</td>
        <td class="tittabla">Nombre contacto</td>
        <td class="tittabla">Fecha</td>
        <td class="tittabla">Vigencia</td>
        <td class="tittabla">Estado</td>
        <td class="tittabla">Resultado</td>
	<td class="tittabla">Usuario</td>
	<td class="tittabla">SI. Guardados</td>
    </tr>
        <?
		$sqlad = "select * from cot_temp where estado='terminada' AND (resultado='exitosa')";
		if ($_GET['filtro1']!='' && $_GET['filtro1']!='N')
			$sqlad .= " AND  clasificacion='$_GET[filtro1]'";
		if ($_GET['filtro2']!='')
			$sqlad .= " AND idcliente in (select idcliente from clientes where nombre like '%$_GET[filtro2]%')";
		if ($_GET['filtro3']!='' && $_GET['filtro3']!='N')
			$sqlad .= " AND idusuario='$_GET[filtro3]'";
			//$sqlad .= " AND idusuario in (select idusuario from usuarios where nombre like '%$_GET[filtro3]%')";

		if ($_GET['filtro4'] && $_GET['filtro4b'] && $_GET['filtro4']!="N" && $_GET['filtro4b']!="N")
			$sqlad .= " AND vigencia BETWEEN '$_GET[filtro4]' AND '$_GET[filtro4b] '";

		if ($_GET['filtro5']=='1')
			$sqlad .= " AND idcot_temp in (select idcot_temp from cot_otm)";
		if ($_GET['filtro6']=='1')
			$sqlad .= " AND idcot_temp in (select idcot_temp from cot_seg)";
		if ($_GET['filtro7']=='1')
			$sqlad .= " AND idcot_temp in (select idcot_temp from cot_adu)";
		if ($_GET['filtro5']=='0')
			$sqlad .= " AND idcot_temp not in (select idcot_temp from cot_otm)";
		if ($_GET['filtro6']=='0')
			$sqlad .= " AND idcot_temp not in (select idcot_temp from cot_seg)";
		if ($_GET['filtro7']=='0')
			$sqlad .= " AND idcot_temp not in (select idcot_temp from cot_adu)";
		if ($_GET['filtro8']!='')
			$sqlad .= " AND numero like '%$_GET[filtro8]%'";
		if ($_GET['filtro9']!='' && $_GET['filtro9']!='N')
			$sqlad .= " AND  estado='$_GET[filtro9]'";
		if ($_GET['filtro10']!='' && $_GET['filtro10']!='N')
			$sqlad .= " AND  resultado='$_GET[filtro10]'";

		if ($_GET['filtro11']!='' && $_GET['filtro11']!='N')
			$sqlad .= " AND idcot_temp in (select idcot_temp from cot_fletes where idtarifario in (select idtarifario from tarifario where puerto_origen='$_GET[filtro11]'))";
		if ($_GET['filtro12']!='' && $_GET['filtro12']!='N')
			$sqlad .= " AND idcot_temp in (select idcot_temp from cot_fletes where idtarifario in (select idtarifario from tarifario where puerto_destino='$_GET[filtro12]'))";

		if ($_GET['filtro13'] && $_GET['filtro14'] && $_GET['filtro13']!="N" && $_GET['filtro14']!="N")
			$sqlad .= " AND fecha_hora BETWEEN '$_GET[filtro13]' AND '$_GET[filtro14] '";

if($_SESSION['perfil'] == "2"){
		$sqlad .= " and idcliente in(select idcliente from clientes where idvendedor in (select idvendedor_customer from vendedores_customer where idusuario = ".$_SESSION['numberid']."))";
	}


		$sqlad .= " order by fecha_hora desc";

		//print $sqlad.'<br>';
		$exead=mysql_query($sqlad,$link);
		$cant=mysql_num_rows($exead);

        $regxpag = 20;//cantidad de items por pagina
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
		$y=1;
        for($i=0;$i<$cantpag;$i++)
        {
            $datosad=mysql_fetch_array($buscarpag);

			if($datosad['estado']=="en_proceso")
			{
				$url="paso5_final.php?idcot_temp=$datosad[idcot_temp]&cl=$datosad[clasificacion]";
			}
			if($datosad['estado']=="terminada")
			{
				$url="paso5_final.php?idcot_temp=$datosad[idcot_temp]&cl=$datosad[clasificacion]&accion=nada";
			}

		?>
		<?if($_SESSION['perfil'] == "2"){ // si es comercial solo muestra sus propios clientes
	$sqlad .= " AND idvendedor = (select idusuario from usuarios where idusuario = ".$_SESSION['numberid']." limit 0,1) ";

}?>
             <tr>
			 	<td class="contenidotab"><? print $y;?></td>
                <?
                $sqlm = "select * from modalidades_reportes where idcot_temp='$datosad[idcot_temp]' and (flete='1' or otm='1' or seguro='1' or aduana='1' or bodega='1' or terrestre='1')";
				//print $sqlm.'<br>';
				$exem = mysql_query($sqlm, $link);
				$filasm = mysql_num_rows($exem);
                ?>
                <td class="contenidotab"><? if($filasm > 0) { ?><a href="modalidades.php?idcot_temp=<? print $datosad['idcot_temp']; ?>" title="Click para abrir"><? print $datosad['numero'];?></a><? } else print $datosad['numero'];	 ?></td>
                <td class="contenidotab"><?

					if($datosad['resultado']=='exitosa' /*&& substr($datosad['vigencia'], 0, 10)!='' && substr($datosad['vigencia'], 0, 10)!='0000-00-00'*/) { ?>
						<a href="sel_cotizaciones.php?idcot_temp=<? print $datosad['idcot_temp'];?>" title="Click para abrir">Sel Modalidades</a><? } ?></td>
                <td class="contenidotab"><? if(scai_get_name("$datosad[idcliente]","clientes", "idcliente", "nombre")!="") print scai_get_name("$datosad[idcliente]","clientes", "idcliente", "nombre"); else print $datosad['razon_social'];?></td>
                <td class="contenidotab"><? print $datosad['nombre'];?></td>
                <td class="contenidotab"><? print $datosad['fecha_hora'];?></td>
                <td class="contenidotab"><? print $datosad['vigencia'];?></td>

				<? if($datosad['estado']=="en_proceso") $roj="#FF0000"; else $roj="";?>
                <td class="contenidotab" style="color:<? print $roj;?>;"><? print $datosad['estado']; ?></td>
                <td class="contenidotab">
                	Resultado&nbsp;<select name="resultado<? print $datosad['idcot_temp']; ?>" id="resultado<? print $datosad['idcot_temp']; ?>" onChange="validaEnvia3(formulario, <? print $datosad['idcot_temp']; ?>)">
					<option value="N">Seleccione</option>
					<option value="exitosa" <? if($datosad['resultado']=="exitosa") print " selected";?>>Exitosa</option>
					<option value="no_exitosa" <? if($datosad['resultado']=="no_exitosa") print " selected";?>>No exitosa</option>
					</select>
                    <?
					if($datosad['resultado']=="exitosa")
					{
						?>
                    Vigencia
                    <input id="vigencia<? print $datosad['idcot_temp']; ?>" name="vigencia<? print $datosad['idcot_temp']; ?>" value="<? print substr($datosad['vigencia'], 0, 10);?>" maxlength="50" size="7" readonly>
                    <input class="botonesadmin" style="color:#FFFFFF;" onClick="return showCalendar('vigencia<? print $datosad['idcot_temp']; ?>');" type='reset' value='...' name='reset'>
                    <input type="button" class="botonesadmin" style="color:#FFFFFF;" id="guardarvigencia" name="guardarvigencia" value="Guardar" onclick="validaEnvia3(formulario, <? print $datosad['idcot_temp']; ?>)" />
                    	<?
					}
					?>
                </td>
				<td class="contenidotab"><? print scai_get_name("$datosad[idusuario]","usuarios", "idusuario", "nombre")." ".scai_get_name("$datosad[idusuario]","usuarios", "idusuario", "apellido")?></td>


		<?
			$ships= Array();
			$ships[0]='shipping_instruction';
			$ships[1]='shipping_instruction_adu';
			$ships[2]='shipping_instruction_bod';
			$ships[3]='shipping_instruction_otm';
			$ships[4]='shipping_instruction_seg';
			$ships[5]='shipping_instruction_terrestre';
			$totships='';
			$total;
			for ($j=0;$j<6;$j++){

			$sqlfl="SELECT numero as contar, count(*) as tot FROM ".$ships[$j]." WHERE 			idreporte='$datosad[idcot_temp]' group by contar";
			$exefl = mysql_query($sqlfl, $link);
			//print $sqlfl;

			$numfl=mysql_fetch_array($exefl);
			if($numfl['contar']!='')$espacio="<br>"; else $espacio="";
			$totships.=$numfl['contar'].$espacio;
			//$total=$total+$numfl['tot'];
			}
			//print $sqlfl;
			?>
			<td class="contenidotableft"><?print $totships?></td>



            </tr>
        <?
		$totships=0;
		$y++;
        }
        ?>

<tr>
<td class="contenidotab"><?print ""?></td>
<td class="contenidotab"><?print ""?></td>
<td class="contenidotab"><?print ""?></td>
<td class="contenidotab"><?print ""?></td>
<td class="contenidotab"><?print ""?></td>
<td class="contenidotab"><?print ""?></td>
<td class="contenidotab"><?print ""?></td>
<td class="contenidotab"><?print ""?></td>
<td class="contenidotab"><?print ""?></td>
<td class="contenidotab"><?print ""?></td>
<td align="center" class="contenidotableft" ><?//print "Total Cant SI ".$total?></td>
</tr>
    <!--<tr>
        <td colspan="5" align="center">
            <table>
                <tr>
                	<? if(puedo("c","TARIFARIO")==1) { ?>
                	<td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="nuevoRegistro();">Agregar</a></td>
                    <? } ?>
                    <? if(puedo("e","TARIFARIO")==1) { ?>
                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="eliminaRegistros()">Eliminar</a></td>
                    <? } ?>
                </tr>
            </table>
        </td>
    </tr>-->
</table>
</div>
