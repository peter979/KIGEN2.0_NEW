<? 
include('./sesion/sesion.php');
include("./conection/conectar.php");	
include_once("./permite.php");
include_once("scripts/recover_nombre.php");

if($_GET['name']=='')
	$name=str_replace("{file_name}", $_GET['idcot_temp'], scai_get_name("nombre_archivo_imprimir","parametros","nombre","valor"));
$name=str_replace(' ','_', $name);

if($_GET['exporta']=='si')
{
	Header("Content-Disposition: inline; filename=$name.doc");
	Header("Content-Description: PHP3 Generated Data"); 
	Header("Content-type: application/vnd.ms-word; name='$name.doc'");//comenta esta linea para ver la salida en web
	flush;
	?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?
}
else
{
	?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="./css/admin_internas.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="./js/funciones.js"></script>
    <script type="text/javascript" src="./js/funcionesValida.js"></script>
    
    <script type="text/javascript" src="./js/jquery.js"></script>
    <script type="text/javascript" src="./js/main.js"></script>
    <script type="text/javascript" src="./js/shadowbox-base.js"></script>
    <script type="text/javascript" src="./js/shadowbox.js"></script>
    <script type="text/javascript" src="./js/jquery-1.2.6.pack.js"></script>
    <script type="text/javascript" src="./js/jquery-1.2.1.pack.js" ></script>
    <script>
    function validaEnvia(form)
    {
        form.datosok.value="si";
        //alert(form.datosok.value);
        form.submit()
    }
    function suma(form)
    {
        if(form.fob.value == '')
            form.fob.value = 0;
        if(form.freight.value == '')
            form.freight.value = 0;
        if(form.duties.value == '')
            form.duties.value = 0;
        if(form.additional.value == '')
            form.additional.value = 0;
        if(form.charges.value == '')
            form.charges.value = 0;
            
        form.total.value = parseFloat(form.fob.value) + parseFloat(form.freight.value) + parseFloat(form.duties.value) + parseFloat(form.additional.value) + parseFloat(form.charges.value);
        form.total.value  = Math.round(form.total.value * 100)/100;
    }
    </script>
	<?
}

if($_GET['lectura']=='si') $_GET['exporta']='si' ;
if($_GET['exporta']=='si')
{
	?>
	<style type="text/css">
    body{
    /*background-color:#FFFFFF;*/
    /*background-image:url(images/fondo_cotizacion.jpg);*/
    font-family:<? print scai_get_name("exportar_word_fuente","parametros","nombre","valor");?>;
    font-size:<? print scai_get_name("exportar_word_tamano_fuente","parametros","nombre","valor");?>pt;
    }
    </style>
    <?
}  
$_GET['cl'] = scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "clasificacion");

if($_POST['datosok']=='si')
{
	//pdf--------------------------------------------------------------------------------------------------------------------
	if ($mueve = move_uploaded_file($_FILES['formato_pdf']['tmp_name'], "erpoperativo/formatos_pdf/".$_FILES['formato_pdf']['name']))
	{
		$nombre = $_FILES['formato_pdf']['name'];
		$sql = "INSERT INTO formatos_pdf (idusuario, nombre, fecha, tipo) VALUES ('$_SESSION[numberid]', '$nombre', NOW(), 'seguro')";
		//print $sql.'<br>';
		$query = mysql_query($sql, $link);
		
		$sql = "SELECT LAST_INSERT_ID() ultimo FROM formatos_pdf";
		$exe = mysql_query($sql, $link);
		$row = mysql_fetch_array($exe);
		$idformato = $row['ultimo'];
	}
	//-----------------------------------------------------------------------------------------------------------------------

	$sqldel = "delete from rn_seg where idreporte='$_GET[idcot_temp]'";
	//print $sqldel.'<br>';
	$exedel = mysql_query($sqldel, $link);
	
	if(isset($_POST['selsg']))
	{
		if ($mueve = move_uploaded_file($_FILES['formato_seguro']['tmp_name'], "formatos_seguro/".$_FILES['formato_seguro']['name']))
		{
			$nombre = $_FILES['formato_seguro']['name'];
			$sql = "INSERT INTO formatos_seguro (nombre, fecha) VALUES ('$nombre', NOW())";
			//print $sql.'<br>';
			$query = mysql_query($sql, $link);
			
			$sql = "SELECT LAST_INSERT_ID() ultimo FROM formatos_seguro";
			$exe = mysql_query($sql, $link);
			$row = mysql_fetch_array($exe);
			$idformato_seguro = $row['ultimo'];
		}
	
		foreach($_POST['selsg'] as $id)
		{
			$pc = $_POST['porcentaje'.$id];
			$mn = $_POST['minimo_seg'.$id];

			if($pc!='' || $mn!='')
			{
				$valor_seg = '0';
				if(isset($_POST['monto_aseg']) && $_POST['monto_aseg']!='0' && $_POST['monto_aseg']!='')
				{
					$valor_seg = $_POST['monto_aseg'] *($_POST['porcentaje'.$id] / 100);
				}
			
				if ($_POST['minimo_seg'.$id] > $valor_seg)	
				{
					$valor_seg = $_POST['minimo_seg'.$id];
				}
				
				$sql = "select idcot_seg from cot_seg where idseguro='$id' and idcot_temp='$_GET[idcot_temp]'";
				$exe = mysql_query($sql, $link);
				$datos = mysql_fetch_array($exe);
				
				$sqlseg = "INSERT INTO rn_seg (idcot_seg, idreporte, idformato_seguro, porcentaje, minimo, monto_aseg, valor, observaciones, descripcion, mostrar, name, tax_id, address, phone, contact, email, city) VALUES ('$datos[idcot_seg]', '$_GET[idcot_temp]', '$idformato_seguro', '$pc', '$mn', '$_POST[monto_aseg]', '$valor_seg', UCASE('$_POST[observaciones_seg]'), '$_POST[descripcion_seg]', '$_POST[mostrar_seg]', '$_POST[name]', '$_POST[tax_id]', '$_POST[address]', '$_POST[phone]', '$_POST[contact]', '$_POST[email]', '$_POST[city]')";
				//print $sqlseg.'<br>';
				$exeseg = mysql_query($sqlseg, $link);
			}
		}
		
		$sqlm = "select * from modalidades_reportes where idcot_temp='$_GET[idcot_temp]'";
		//print $sqlm.'<br>';
		$exem = mysql_query($sqlm,$link);
		$datosm = mysql_fetch_array($exem);
		
		if($datosm['flete']!='1')
		{
			$sql = "select * from shipping_instruction_seg where idreporte='$_GET[idcot_temp]' and idtarifario='0'";
			//print $sql.'<br>';
			$exe = mysql_query($sql, $link);
			$filas = mysql_num_rows($exe);
			$datosft = mysql_fetch_array($exe);
			
			if($idformato == '')
				$idformato = $datosft['idformato'];
			
			if($filas == 0)
			{
				$sql = "insert into shipping_instruction_seg (idformato, idreporte, idformato_seguro, idincoterm, depot, contact, email, commodity, transport, fob, freight, duties, additional, charges, total) values('$idformato', '$_GET[idcot_temp]', '$idformato_seguro', '$_POST[idincoterm]', '$_POST[depot]', '$_POST[contact_c]', '$_POST[email_c]', '$_POST[commodity]', '$_POST[transport]', '$_POST[fob]', '$_POST[freight]', '$_POST[duties]', '$_POST[additional]', '$_POST[charges]', '$_POST[total]')";
				//print $sql.'<br>';
				$exe = mysql_query($sql, $link);
				
				$sql = "SELECT LAST_INSERT_ID() ultimo FROM shipping_instruction_seg";
				$exe = mysql_query($sql, $link);
				$row = mysql_fetch_array($exe);
				$id = $row['ultimo'];
				$numero = '80'.date('y').date('m').trim(substr('000'.$id,-3));
		
				$sql = "update shipping_instruction_seg set numero='$numero' where idshipping_instruction_seg='$id'";
			}			
			elseif($filas > 0)
				$sql = "update shipping_instruction_seg set idformato='$idformato', idformato_seguro='$idformato_seguro', idincoterm='$_POST[idincoterm]', depot='$_POST[depot]', contact='$_POST[contact_c]', email='$_POST[email_c]', commodity='$_POST[commodity]', transport='$_POST[transport]', fob='$_POST[fob]', freight='$_POST[freight]', duties='$_POST[duties]', additional='$_POST[additional]', charges='$_POST[charges]', total='$_POST[total]' where idreporte='$_GET[idcot_temp]' and idtarifario='0'";
			
			//print $sql.'<br>';
			$exe = mysql_query($sql, $link);
		}			
		if(!$exeseg)
			print ("<script>alert('No se pudo guardar el registro')</script>");
		else
			print "<script>alert('El registro ha sido guardado satisfactoriamente')</script>";		
	}
	else
	{
		if(!$exedel)
			print ("<script>alert('No se pudo guardar el registro')</script>");
		else
			print "<script>alert('El registro ha sido guardado satisfactoriamente')</script>";
	}
}
?>
<form enctype="multipart/form-data" name="formulario" id="formulario" method="post">
<input name="datosok" type="hidden" value="no" />
<table width="100%" align="center">
    <?
    if($_GET['exporta']=='si')
	{
		?>
        <tr>
            <td align="left"><? include('./logo.php'); ?></td>
        </tr>
    	<?
	}
	?>
    <tr>
        <td class="subtitseccion" style="text-align:center" ><strong>SHIPPING INSTRUCTION SEGURO REPORTE <? print scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero"); ?></strong><br><br></td>
    </tr>
</table>
<?
$sqlsh = "select * from shipping_instruction_seg where idreporte='$_GET[idcot_temp]' and idtarifario='0'";
//print $sqlsh.'<br>';
$exesh = mysql_query($sqlsh, $link);
$datosh = mysql_fetch_array($exesh);

$sqlm = "select * from modalidades_reportes where idcot_temp='$_GET[idcot_temp]'";
//print $sqlm.'<br>';
$exem = mysql_query($sqlm,$link);
$datosm = mysql_fetch_array($exem);

//carga------------------------------------------------------------------------------------------------------------------------
if($_GET['exporta']!='si' && $datosm['flete']!='1')
{
	?>
	<table align="center">
		<?
		$sql = "select * from formatos_pdf where tipo='seguro' and idformato in (select idformato from shipping_instruction_seg where idshipping_instruction_seg='$datosh[idshipping_instruction_seg]')";
		$exeft = mysql_query($sql, $link);
		while($datosft = mysql_fetch_array($exeft))
		{
			?>
			<tr>
				<td class="contenidotab"><a href="./erpoperativo/formatos_pdf/<? print $datosft['nombre']; ?>" target="_blank">Documento PDF actual: <? print $datosft['nombre'].' - '.$datosft['fecha']; ?></a></td>
			</tr>
			<?
		}
		?>
		<tr>
			<td class="contenidotab">Documentos PDF</td>
		</tr>    
		<tr>        
			<td class="contenidotab"><input type="file" name="formato_pdf" id="formato_pdf"/></td>
		</tr>
	</table>
	<?
}
//-----------------------------------------------------------------------------------------------------------------------------

if($_GET['exporta']!='si')
{
	include("rn_search_seguro.php");
	?>
    
    <table align="center">
        <?
            $sql = "select * from  formatos_seguro where idformato_seguro in (select idformato_seguro from shipping_instruction_seg where idreporte='$_GET[idcot_temp]' and idtarifario='0') ";
            $exe = mysql_query($sql, $link);
            while($datos = mysql_fetch_array($exe))
            {
                ?>
                <tr>
                    <td class="contenidotab"><a href="./formatos_seguro/<? print $datos['nombre']; ?>" target="_blank">Formato seguro actual: <? print $datos['nombre'].' - '.$datos['fecha']; ?></a></td>
                </tr>
                <?
            }
        ?>
        <tr>
            <td class="contenidotab">Formato seguro</td>
        </tr>    
        <tr>        
            <td class="contenidotab"><input type="file" name="formato_seguro" id="formato_seguro"/></td>
        </tr>
    </table>
    <br />
    <?
}

$sqlrn = "select * from rn_seg where idreporte='$_GET[idcot_temp]'"; 
//print $sqlrn.'<br>';
$exern = mysql_query($sqlrn, $link);
$datosrn =  mysql_fetch_array($exern);

if($datosm['flete']!='1')
{
	?>
    <table width="<? if($_GET['exporta']=='si') print '100%'; else print '70%'; ?>" align="center" border="<? if($_GET['exporta']=='si') print '1'; else print '0'; ?>">
        <tr>
            <td class="contenidotab" colspan="3" style="text-align:right"><? if($datosh['numero']!='') print 'SHIPMENT ID: '.$datosh['numero']; ?> </td>
        </tr>
        <tr>
            <td class="contenidotab" rowspan="7"><strong>SHIPPER</strong></td>
            <? if($_GET['exporta']!='si') { ?><td class="tittabla" style="text-align:center">NOMBRE</td><? } ?>
            <td class="tittabla" style="text-align:center"><? if($_GET['exporta']=='si') print $datosrn['name']; else { ?><input id="name" name="name" value="<? print $datosrn['name']; ?>"/><? } ?></td>
        </tr>
        <tr>
            <? if($_GET['exporta']!='si') { ?><td class="tittabla" style="text-align:center">NIT</td><? } ?>
            <td class="tittabla" style="text-align:center"><? if($_GET['exporta']=='si') print $datosrn['tax_id']; else { ?><input id="tax_id" name="tax_id" value="<? print $datosrn['tax_id']; ?>"/><? } ?></td>
        </tr>
        <tr>
            <? if($_GET['exporta']!='si') { ?><td class="tittabla" style="text-align:center">CIUDAD</td><? } ?>
            <td class="tittabla" style="text-align:center"><? if($_GET['exporta']=='si') print $datosrn['city']; else { ?><input id="city" name="city" value="<? print $datosrn['city']; ?>"/><? } ?></td>
        </tr>
        <tr>			
            <? if($_GET['exporta']!='si') { ?><td class="tittabla" style="text-align:center">DIRECCI&Oacute;N</td><? } ?>
            <td class="tittabla" style="text-align:center"><? if($_GET['exporta']=='si') print $datosrn['address']; else { ?><input id="address" name="address" value="<? print $datosrn['address']; ?>"/><? } ?></td>
        </tr>
        <tr>      					
            <? if($_GET['exporta']!='si') { ?><td class="tittabla" style="text-align:center">TELEFONO</td><? } ?>
            <td class="tittabla" style="text-align:center"><? if($_GET['exporta']=='si') print $datosrn['phone']; else { ?><input id="phone" name="phone" value="<? print $datosrn['phone']; ?>"/><? } ?></td>	
        </tr>
        <tr>			
            <? if($_GET['exporta']!='si') { ?><td class="tittabla" style="text-align:center">CONTACTO</td><? } ?>
            <td class="tittabla" style="text-align:center"><? if($_GET['exporta']=='si') print $datosrn['contact']; else { ?><input id="contact" name="contact" value="<? print $datosrn['contact']; ?>"/><? } ?></td>
        </tr>
        <tr>
            <? if($_GET['exporta']!='si') { ?><td class="tittabla" style="text-align:center">EMAIL</td><? } ?>
            <td class="tittabla" style="text-align:center"><? if($_GET['exporta']=='si') print $datosrn['email']; else { ?><input id="email" name="email" value="<? print $datosrn['email']; ?>"/><? } ?></td>
        </tr>
        <?
        $sql = "select * from cot_temp where idcot_temp='$_GET[idcot_temp]'";
        //print $sql.'<br>';
        $exe = mysql_query($sql, $link);
        $datos = mysql_fetch_array($exe);
    
        $sqlc = "select * from clientes where idcliente='$datos[idcliente]'";
        //print $sqlc.'<br>';
        $exec = mysql_query($sqlc, $link);
        $datosc = mysql_fetch_array($exec);
    
        $sqlco = "select * from contactos_todos where idcliente='$datos[idcliente]'";
        //print $sqlco.'<br>';
        $execo=mysql_query($sqlco,$link);
        $filasco = mysql_num_rows($execo);
        $datosco = mysql_fetch_array($execo);
        ?>
        <tr>
            <td rowspan="6" class="contenidotab"><strong>CONSIGNEE</strong></td>
			<td class="tittabla" style="text-align:center" colspan="2"><? print $datosc['nombre']; ?></td>
        </tr>
        <tr>
            <td class="tittabla" style="text-align:center" colspan="2"><? print $datosc['nit']; ?></td>
            <!--<td class="contenidotab"><? print $datosc['nit']; ?></td>-->			
        </tr>
        <!--<tr>
            <td class="tittabla" style="text-align:center">DEPOT</td>
            <td class="contenidotab"><? if($_GET['exporta']=='si') print $datosh['depot']; else { ?><input id="depot" name="depot" value="<? print $datosh['depot']; ?>" onkeyup="formulario.depot2.value=this.value"/><? } ?></td>
        </tr>-->
        <tr>
            <td class="tittabla" style="text-align:center" colspan="2"><? print $datosc['direccion']; ?></td>
            <!--<td class="contenidotab"><? print $datosc['direccion']; ?></td>-->			
        </tr>
        <tr>
            <td class="tittabla" style="text-align:center" colspan="2"><? print $datosc['telefonos']; ?></td>
            <!--<td class="contenidotab"><? print $datosc['telefonos']; ?></td>-->				
        </tr>
        <tr>
            <? if($_GET['exporta']!='si') { ?><td class="tittabla" style="text-align:center">CONTACTO</td><? } ?>
            <td class="tittabla" style="text-align:center"><? if($_GET['exporta']=='si') { if($datosh['contact']!='') print $datosh['contact']; elseif($datos['nombre']!='') print $datos['nombre']; else print $datosco['nombre']; } else { ?><input id="contact_c" name="contact_c" value="<? if($datosh['contact']!='') print $datosh['contact']; elseif($datos['nombre']!='') print $datos['nombre']; else print $datosco['nombre']; ?>" onkeyup="formulario.contact2.value=this.value"/><? } ?></td>
        </tr>
        <tr>
            <? if($_GET['exporta']!='si') { ?><td class="tittabla" style="text-align:center">EMAIL</td><? } ?>
            <td class="tittabla" style="text-align:center"><? if($_GET['exporta']=='si') { if($datosh['email']!='') print $datosh['email']; elseif($datos['email']!='') print $datos['email']; else print $datosco['correo']; } else { ?><input id="email_c" name="email_c" value="<? if($datosh['email']!='') print $datosh['email']; elseif($datos['email']!='') print $datos['email']; else print $datosco['correo'];  ?>" onkeyup="formulario.email2.value=this.value"/><? } ?></td>
        </tr>
        <tr>
            <td rowspan="6" class="contenidotab"><strong>BENEFICIARY</strong></td>
			<td class="tittabla" style="text-align:center" colspan="2"><? print $datosc['nombre']; ?></td>
        </tr>
        <tr>
            <td class="tittabla" style="text-align:center" colspan="2"><? print $datosc['nit']; ?></td>
            <!--<td class="contenidotab"><? print $datosc['nit']; ?></td>-->			
        </tr>
        <!--<tr>
            <td class="tittabla" style="text-align:center">DEPOT</td>
            <td class="contenidotab"><? if($_GET['exporta']=='si') print $datosh['depot']; else { ?><input id="depot2" name="depot2" value="<? print $datosh['depot']; ?>" readonly/><? } ?></td>
        </tr>-->
        <tr>
            <td class="tittabla" style="text-align:center" colspan="2"><? print $datosc['direccion']; ?></td>
            <!--<td class="contenidotab"><? print $datosc['direccion']; ?></td>-->			
        </tr>
        <tr>
            <td class="tittabla" style="text-align:center" colspan="2"><? print $datosc['telefonos']; ?></td>
            <!--<td class="contenidotab"><? print $datosc['telefonos']; ?></td>-->				
        </tr>
        <tr>
            <? if($_GET['exporta']!='si') { ?><td class="tittabla" style="text-align:center">CONTACTO</td><? } ?>
            <td class="tittabla" style="text-align:center"><? if($_GET['exporta']=='si') { if($datosh['contact']!='') print $datosh['contact']; elseif($datos['nombre']!='') print $datos['nombre']; else print $datosco['nombre']; } else { ?><input id="contact2" name="contact2" value="<? if($datosh['contact']!='') print $datosh['contact']; elseif($datos['nombre']!='') print $datos['nombre']; else print $datosco['nombre']; ?>" readonly/><? } ?></td>
        </tr>
        <tr>
            <? if($_GET['exporta']!='si') { ?><td class="tittabla" style="text-align:center">EMAIL</td><? } ?>
            <td class="tittabla" style="text-align:center"><? if($_GET['exporta']=='si') { if($datosh['email']!='') print $datosh['email']; elseif($datos['email']!='') print $datos['email']; else print $datosco['correo']; } else { ?><input id="email2" name="email2" value="<? if($datosh['email']!='') print $datosh['email']; elseif($datos['email']!='') print $datos['email']; else print $datosco['correo'];  ?>" readonly/><? } ?></td>
        </tr>
</table>
<br />

<table align="center" border="<? if($_GET['exporta']=='si') print '1'; else print '0'; ?>"> 
        <tr>
            <td class="contenidotab"><strong>COMMODITY</strong></td>
          <td class="contenidotab" colspan="2"><? if($_GET['exporta']=='si') { if($datosh['commodity']!='') print $datosh['commodity']; else print 'According to commercial invoice'; } else { ?><input id="commodity" name="commodity" value="<? if($datosh['commodity']!='') print $datosh['commodity']; else print 'According to commercial invoice'; ?>"/><? } ?></td>
        </tr>
        <tr>
            <td class="contenidotab"><strong>INCOTERM</strong></td>
<td class="contenidotab" colspan="2">
            	<? if($_GET['exporta']=='si') print scai_get_name("$datosh[idincoterm]","incoterms","idincoterm","nombre"); else { ?>
                <select id="idincoterm" name="idincoterm" class="tex1">
                    <option value="N"> Seleccione </option>
                    <?
                    $es="select * from incoterms order by codigo";
                    $exe=mysql_query($es,$link);
                    while($row=mysql_fetch_array($exe))
                    {
                        $sel = "";
                        if($datosh['idincoterm'] == $row['idincoterm'])
                            $sel = "selected";
                        print "<option value='$row[idincoterm]' $sel>$row[codigo] - $row[nombre]</option>";
                    }
                    ?>
                </select>
                <? } ?>            </td>
        </tr>
        <tr>
            <td class="contenidotab"><strong>PRINCIPAL TRANSPORT</strong></td>
<td class="contenidotab" colspan="2">
            	<? if($_GET['exporta']=='si') print strtoupper($datosh['transport']); else { ?>
                <select id="transport" name="transport" class="tex1">
                    <option value="N"> Seleccione </option>
                    <option value="air" <? if($datosh['transport']=='air') print 'selected'; ?>> AIR </option>
                    <option value="land" <? if($datosh['transport']=='land') print 'selected'; ?>> LAND </option>
                    <option value="ocean" <? if($datosh['transport']=='ocean') print 'selected'; ?>> OCEAN </option>
                </select>
                <? } ?>            </td>
        </tr>
    </table>
    <br />
    
    <table align="center" border="<? if($_GET['exporta']=='si') print '1'; else print '0'; ?>">
        <tr>
            <td class="tittabla" style="text-align:center"><strong>ITEMS TO BE INSURED</strong></td>
            <td class="tittabla" style="text-align:center"><strong>VALUE IN USD</strong></td>
        </tr>
        <tr>
            <td class="contenidotab"><strong>FOB VALUE OF THE CARGO</strong></td>
          <td class="contenidotab"><? if($_GET['exporta']=='si') print $datosh['fob']; else { ?><input id="fob" name="fob" value="<? print $datosh['fob']; ?>" onchange="suma(formulario)"/><? } ?></td>
        </tr>
        <tr>
            <td class="contenidotab"><strong>FREIGHT</strong></td>
          <td class="contenidotab"><? if($_GET['exporta']=='si') print $datosh['freight']; else { ?><input id="freight" name="freight" value="<? print $datosh['freight']; ?>" onchange="suma(formulario)"/><? } ?></td>
        </tr>
        <tr>
            <td class="contenidotab"><strong>DUTIES</strong></td>
          <td class="contenidotab"><? if($_GET['exporta']=='si') print $datosh['duties']; else { ?><input id="duties" name="duties" value="<? print $datosh['duties']; ?>" onchange="suma(formulario)"/><? } ?></td>
        </tr>
        <tr>
            <td class="contenidotab"><strong>10% ADDITIONAL</strong></td>
          <td class="contenidotab"><? if($_GET['exporta']=='si') print $datosh['additional']; else { ?><input id="additional" name="additional" value="<? print $datosh['additional']; ?>" onchange="suma(formulario)"/><? } ?></td>
        </tr>
        <tr>
            <td class="contenidotab"><strong>ANOTHER CHARGES</strong></td>
          <td class="contenidotab"><? if($_GET['exporta']=='si') print $datosh['charges']; else { ?><input id="charges" name="charges" value="<? print $datosh['charges']; ?>" onchange="suma(formulario)"/><? } ?></td>
        </tr>
        <tr>
            <td class="contenidotab"><strong>TOTAL USD</strong></td>
          <td class="contenidotab"><? if($_GET['exporta']=='si') print $datosh['total']; else { ?><input id="total" name="total" value="<? print $datosh['total']; ?>" onchange="suma(formulario)" readonly/><? } ?></td>
        </tr>    
    </table>
    <br />
	<?
}
if($_GET['exporta']!='si' || $_GET['lectura']=='si')
{
	?>
    <table>
        <tr>
            <td colspan="5" align="left">
                <table>
                    <tr>
                    	<?
                        if($datosh['idshipping_instruction_seg']!='')
                        {
                            ?>
                            <td width="60" class="botonesadmin"><a href="<? print $_SERVER['PHP_SELF']; ?>?idcot_temp=<? print $_GET['idcot_temp']; ?>&exporta=si" onClick="">Exportar a Word</a></td>
                            <?
                        }
                        ?>                        
                        <? if($_GET['lectura']=='si') $destino = 'erpoperativo/op_modalidades.php'; else $destino = 'modalidades.php'; ?>
                        <td width="60" class="botonesadmin"><a href="<? print $destino; ?>?idcot_temp=<? print $_GET['idcot_temp']; ?>" onClick="">Atras</a></td>
                        <? if((puedo("c","REPORTES_NEGOCIO")==1 || puedo("m","REPORTES_NEGOCIO")==1) && $_GET['lectura']!='si') { ?>
                        <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
                        <? } ?>
                    </tr>
                </table>            </td>        	
        </tr>
    </table>
	<?
}
?>
</form>
