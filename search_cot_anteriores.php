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
function cortar_string ($string, $largo)
{
	$marca = "<!--corte-->";

	if (strlen($string) > $largo) {

	$string = wordwrap($string, $largo, $marca);
	$string = explode($marca, $string);
	$string = $string[0];
	}
	return $string;
}
?>

<script language="javascript">
function winback(URL)
{
       day = new Date();
       id = day.getTime();
       eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=yes,location=0,screenX=250,screenY=100,statusbar=yes,menubar=1,resizable=0,width=800,height=500');");
}
</script>

 <div id="eyes2" style="width:100%; height:90%; overflow-x: scroll; overflow-y: scroll;">
<?

?>
<table width="100%">
    <?
	/*FALTA AREGAR AL SQL BUSCAR POR NAVIERA*/
	$sqlad = "select * from cot_temp ";


	$sqlad .= ($_POST['order_number']) ? " INNER JOIN shipping_instruction ON cot_temp.idcot_temp = shipping_instruction.idreporte" : "";

	$sqlad .= " where 1 ";

	$sqlad .= ($_POST['order_number']) ? "AND shipping_instruction.order_number LIKE '%".$_POST['order_number']."%'" : "";

	if ($_POST['filtro1']!='' && $_POST['filtro1']!='N')
		$sqlad .= " AND  clasificacion='$_POST[filtro1]'";
	if ($_POST['filtro2']!='')
		$sqlad .= " AND idcliente in (select idcliente from clientes where nombre like '%$_POST[filtro2]%')";
	if ($_POST['filtro3']!='' && $_POST['filtro3']!='N')
		$sqlad .= " AND idusuario='$_POST[filtro3]'";
		//$sqlad .= " AND idusuario in (select idusuario from usuarios where nombre like '%$_POST[filtro3]%')";

	if ($_POST['filtro4'] && $_POST['filtro4b'] && $_POST['filtro4']!="N" && $_POST['filtro4b']!="N")
		$sqlad .= " AND vigencia BETWEEN '$_POST[filtro4]' AND '$_POST[filtro4b] '";

	if ($_POST['filtro5']=='1')
		$sqlad .= " AND idcot_temp in (select idcot_temp from cot_otm)";
	if ($_POST['filtro6']=='1')
		$sqlad .= " AND idcot_temp in (select idcot_temp from cot_seg)";
	if ($_POST['filtro7']=='1')
		$sqlad .= " AND idcot_temp in (select idcot_temp from cot_adu)";
	if ($_POST['filtro5']=='0')
		$sqlad .= " AND idcot_temp not in (select idcot_temp from cot_otm)";
	if ($_POST['filtro6']=='0')
		$sqlad .= " AND idcot_temp not in (select idcot_temp from cot_seg)";
	if ($_POST['filtro7']=='0')
		$sqlad .= " AND idcot_temp not in (select idcot_temp from cot_adu)";
	if ($_POST['filtro8']!='')
		$sqlad .= " AND numero like '%$_POST[filtro8]%'";
	if ($_POST['filtro9']!='' && $_POST['filtro9']!='N')
		$sqlad .= " AND  estado='$_POST[filtro9]'";
	if ($_POST['filtro10']!='' && $_POST['filtro10']!='N')
		$sqlad .= " AND  resultado='$_POST[filtro10]'";

	if ($_POST['filtro11']!='' && $_POST['filtro11']!='N')
		$sqlad .= " AND idcot_temp in (select idcot_temp from cot_fletes where idtarifario in (select idtarifario from tarifario where puerto_origen='$_POST[filtro11]'))";
	if ($_POST['filtro12']!='' && $_POST['filtro12']!='N')
		$sqlad .= " AND idcot_temp in (select idcot_temp from cot_fletes where idtarifario in (select idtarifario from tarifario where puerto_destino='$_POST[filtro12]'))";

	if ($_POST['filtro13'] && $_POST['filtro14'] && $_POST['filtro13']!="N" && $_POST['filtro14']!="N")
		$sqlad .= " AND fecha_hora BETWEEN '$_POST[filtro13]' AND '$_POST[filtro14] '";


	//Si esta loegueado como comercial, solo muestra los clientes que tiene a si mismo

	if($_SESSION['perfil'] == "2"){
		$sqlad .= " and idcliente in(select idcliente from clientes where idvendedor in (select idvendedor_customer from vendedores_customer where idusuario = ".$_SESSION['numberid']."))";
	}


	$sqlad .= " order by fecha_hora desc";


	$exead=mysql_query($sqlad,$link);
	$cant=mysql_num_rows($exead);
	?>
    <tr>
    	<td class="contenidotab" colspan="11" style="text-align:right"><strong>Resultados: <? print $cant; ?></strong></td>
    </tr>
    <tr>
        <td class="tittabla" width="1%">#</td>
		<td class="tittabla" title="Utiliza como base la cotizacion seleccionada para crear una nueva asignando un nuevo numero"><img src="images/ico_modificar.gif" width="7" height="10">Crear</td>
        <td class="tittabla">N&uacute;mero</td>
		<td class="tittabla">Order Number</td>
		<td class="tittabla">Tipo</td>
		<td class="tittabla" width="25%">Cliente</td>
        <td class="tittabla">Fecha</td>
        <td class="tittabla">Estado</td>
        <td class="tittabla">Estado</td>
		<td class="tittabla">Motivo - No Exito</td>
        <td class="tittabla">Resultado</td>
        <!--<td class="tittabla" width="25%">Contacto</td>-->
		<td class="tittabla">Usuario</td>
    </tr>
        <?
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
	if($pag!=1)$num=($pag-1)*20; else $num=0;
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
             <tr><!--OPCION CREAR-->
			 	<td class="contenidotab"><? print ($i+1)+$num ?> </td>
                <td class="contenidotab" title="Utiliza como base la cotizacion seleccionada para crear una nueva asignando un nuevo numero"><input name="registroSel" type="radio" value="<? print $datosad['idcot_temp']; ?>" onClick="document.location.href='<? print $url;?>&nueva=si'" <? if(puedo("c","COTIZACION")!=1) print 'disabled'; ?>></td>
                <!--OPCION ABRIR COTIZACION-->
                <td class="contenidotab"><a href="<? print $url;?>" title="Click para abrir"><? print $datosad['idcot_temp'];?>&nbsp;Abrir</a></td>
                <!--NUMERO DE ORDEN-->
				<td class="contenidotab"><? echo scai_get_name($datosad["idcot_temp"],"shipping_instruction", "idreporte", "order_number")?></td>
                <!---CLASIFICACION-->
				<td class="contenidotab">
					<?
					echo $datosad["clasificacion"];
					?></td>
				<!--NOMBRE DEL CLIENTE-->
                <td class="contenidotab"><? if(scai_get_name("$datosad[idcliente]","clientes", "idcliente", "nombre")!="") print scai_get_name("$datosad[idcliente]","clientes", "idcliente", "nombre"); else print $datosad['razon_social'];?></td>
                <!--FECHA-->
                <td class="contenidotab"><? print $datosad['fecha_hora'];?></td>
                <!--ESTADO-->
                <td class="contenidotab">
					<?
					$sql = "select seguimiento from seguimientos_cot where idcot_temp = ".$datosad['idcot_temp']." order by fecha desc limit 0,1" ;
					//echo $sql."<-";die();
					$qry = mysql_query($sql);
					$seguimiento = mysql_fetch_array($qry);
					echo $seguimiento["seguimiento"];
					?>
				</td>
                <!--ESTADO-->
				<? if($datosad['estado']=="en_proceso") $roj="#FF0000"; else $roj="";?>
                <td class="contenidotab" style="color:<? print $roj;?>;"><? if($datosad['estado']=='terminada') print 'seguimiento'; else print $datosad['estado'];?></td>
				<!--MOTIVO-->
				<td class="contenidotab">
					<?
					echo $datosad["motivo_no_exit"];
					?></td>
				<!--RESULTADO-->	
                <td class="contenidotab" style="color:<? print $roj;?>;"><? if($datosad['estado']=="terminada") print $datosad['resultado']; else print 'N/A';?></td>
                <!--USUARIO-->
				<td class="contenidotab"><? print scai_get_name("$datosad[idusuario]","vendedores_customer", "idusuario", "nombre"); ?></td>
            </tr>
        <?
		$y++;
        }
        ?>
</table>

<table width="100%">
<tr>
	<td align="center">
        <strong class="contenidotab">Nombre</strong>
        <input type="text" name="name" id="name" value="<? $name = "cotizaciones".date('Y-m-d').".xls"; print $name; ?>" class="letra" size="30" maxlength="30" />
        <input type="button" name="generar" id="generar" class="botonesadmin" style="color:#FFFFFF" value="Generar&nbsp;archivo" onClick="document.location = '<?php //print str_replace("search_cot_anteriores","hoja_cot_anteriores", $_SERVER['PHP_SELF']); ?>hoja_cot_anteriores.php?name=' + document.forms[0].name.value + '&filtro1=' + document.forms[0].filtro1.value + '&filtro2=' + document.forms[0].filtro2.value + '&filtro3=' + document.forms[0].filtro3.value + '&filtro4=' + document.forms[0].filtro4.value + '&filtro4b=' + document.forms[0].filtro4b.value + '&filtro5=' + document.forms[0].filtro5.value + '&filtro6=' + document.forms[0].filtro6.value + '&filtro7=' + document.forms[0].filtro7.value + '&filtro8=' + document.forms[0].filtro8.value + '&filtro9=' + document.forms[0].filtro9.value + '&filtro10=' + document.forms[0].filtro10.value + '&filtro11=' + document.forms[0].filtro11.value + '&filtro12=' + document.forms[0].filtro12.value + '&filtro13=' + document.forms[0].filtro13.value + '&filtro14=' + document.forms[0].filtro14.value;">
        <br>
    </td>
</tr>
</table>

<table width="40%" border="0" cellpadding="0" cellspacing="0" class="tabla" align="center">
      <tr>
        <td width="16%" height="20" class="tittabla"><img src="images/ico_paginas.gif" width="15" height="12" align="absmiddle"> Paginaci&oacute;n</td>
    </tr>
      <tr>
        <td height="20" align="center">
        			<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20%" align="center">
								<table width="50%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="15" class="botonesadmin">
											<table width="100%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin" onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=1';" style="cursor:pointer;">
												<tr>
													<td height="15" style="color:#FFFFFF">&lt;&lt;</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
							<td width="20%" align="center">
								<table width="50%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="15" class="botonesadmin">
											<table width="100%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin"<?php if ($pag != 1) { ?> onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=<?php print ($pag - 1); ?>'" style="cursor:pointer;"<?php } ?>>
												<tr>
													<td height="15" style="color:#FFFFFF">&lt;</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
							<td width="20%" align="center">
								<label>
								<select name="pag" class="combofecha" onChange="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=' + document.forms[0].pag.value;">
								<?php
									for ($i=1; $i<=$totpag; $i++)
									{
										if ($i == $pag)
											print "<option value=$i selected>$i</option>";
										else
											print "<option value=$i>$i</option>";
									}
								?>
								</select>
								</label>
							</td>
							<td width="20%" align="center">
								<table width="50%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="15" class="botonesadmin">
											<table width="100%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin"<?php if ($pag != $totpag) { ?> onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=<?php print ($pag + 1); ?>';" style="cursor:pointer;"<?php } ?>>
												<tr>
													<td height="15" style="color:#FFFFFF">&gt;</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
							<td width="20%" align="center">
								<table width="50%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="15" class="botonesadmin">
											<table width="100%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin" onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=<?php print $totpag; ?>';" style="cursor:pointer;">
												<tr>
													<td height="15" style="color:#FFFFFF">&gt;&gt;</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
   		</td>
	</tr>
   </table>
	</td>
</tr>
</table>
</div>
