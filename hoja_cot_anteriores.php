<?
if($_GET['name']=="")
	$name="archivo.xls";
if($_GET['name']!="")
	$name=$_GET['name'];

Header("Content-Disposition: inline; filename=$name");
Header("Content-Description: PHP3 Generated Data"); 
Header("Content-type: application/vnd.ms-excel; name='Civilnet'");//comenta esta linea para ver la salida en web
flush;

include('sesion/sesion.php');
include("conection/conectar.php");	
include_once("permite.php");
include_once("scripts/recover_nombre.php");
?>
<table width="100%"> 
    <?
	/*FALTA AREGAR AL SQL BUSCAR POR NAVIERA*/
	$sqlad = "select * from cot_temp where 1";
	//print $sqlad;
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
		
	$sqlad .= " order by fecha_hora desc";
	
	//print $sqlad.'<br>';
	$exead=mysqli_query($link,$sqlad);
	?>
    <tr>
        <td class="tittabla" width="1%"><strong>#</strong></td>

        <td class="tittabla"><strong>N&uacute;mero</strong></td>
        <td class="tittabla" width="25%"><strong>Cliente</strong></td>        
        <td class="tittabla"><strong>Fecha</strong></td>
        <td class="tittabla"><strong>Vigencia</strong></td>
        <td class="tittabla"><strong>Estado</strong></td>
        <td class="tittabla"><strong>Resultado</strong></td>
        <!--<td class="tittabla" width="25%">Contacto</td>-->
		<td class="tittabla"><strong>Usuario</strong></td>
        <td class="tittabla" width="25%"><strong>Observaciones</strong></td>
    </tr>    
        <?
		$y = 1;		
		while ($datosad = mysqli_fetch_array($exead))
		{
		?>  
             <tr>
			 	<td class="contenidotab"><? print $y;?></td> 
                <td class="contenidotab"><? print $datosad['numero'];?></td>
                <td class="contenidotab"><? if(scai_get_name("$datosad[idcliente]","clientes", "idcliente", "nombre")!="") print scai_get_name("$datosad[idcliente]","clientes", "idcliente", "nombre"); else print $datosad['razon_social'];?></td>                
                <td class="contenidotab"><? print $datosad['fecha_hora'];?></td>
                <td class="contenidotab"><? print $datosad['vigencia'];?></td>
				
				<? if($datosad['estado']=="en_proceso") $roj="#FF0000"; else $roj="";?>
                <td class="contenidotab" style="color:<? print $roj;?>;"><? if($datosad['estado']=='terminada') print 'seguimiento'; else print $datosad['estado'];?></td>
                <td class="contenidotab" style="color:<? print $roj;?>;"><? if($datosad['estado']=="terminada") print $datosad['resultado']; else print 'N/A';?></td>
                <!--<td class="contenidotab"><? if($datosad['nombre']!='') print $datosad['nombre']; else print scai_get_name("$datosad[idusuario]","usuarios", "idusuario", "nombre")." ".scai_get_name("$datosad[idusuario]","usuarios", "idusuario", "apellido");?></td>-->
				<td class="contenidotab"><? print scai_get_name("$datosad[idusuario]","vendedores_customer", "idusuario", "nombre"); ?></td>
                <td class="contenidotab" style="color:<? print $roj;?>;">
				<?								
				print $datosad['observaciones'];?></td>
            </tr>          
        <?
		$y++;
        }
        ?>
</table>