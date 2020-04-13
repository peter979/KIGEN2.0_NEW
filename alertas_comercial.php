<?
include('sesion/sesion.php');
include("conection/conectar.php");	
include_once("permite.php");
include_once("scripts/recover_nombre.php");
?>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/shadowbox-base.js"></script>
<script type="text/javascript" src="js/shadowbox.js"></script>
<script type="text/javascript" src="js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="js/jquery-1.2.1.pack.js" ></script>

</head>

<?

//Consulta las alertas de comercial
$fletes = array();
$otms = array();
$terrestres = array();
$seguros = array();
$si_seguros =  array();
$aduanas = array();
$bodegas = array(); 



		

	$sql="
	select 
		cot_temp.* 
	from 
		cot_temp,
		modalidades_reportes 
	where 
		cot_temp.estado = 'terminada'
		and cot_temp.idcot_temp = modalidades_reportes.idcot_temp 
		and(
			modalidades_reportes.otm = '1' 
			or modalidades_reportes.seguro = '1' 
			or modalidades_reportes.aduana = '1' 
			or modalidades_reportes.bodega = '1' 
		)
	and cot_temp.idcliente in (
		select idcliente 
		from clientes 
		where idcustomer in (
			select idvendedor_customer from vendedores_customer where idusuario='$_SESSION[numberid]')
		)";



$exe3 = mysqli_query($link,$sql);
while($datos = mysqli_fetch_array($exe3))
{
	$sql = "select * from modalidades_reportes where idcot_temp='$datos[idcot_temp]'";

	$exe2 = mysqli_query($link,$sql);
	$modalidades = mysqli_fetch_array($exe2);
	
	if($modalidades['flete']=='1')
	{
		$_GET['cl'] = scai_get_name("$datos[idcot_temp]", "cot_temp", "idcot_temp", "clasificacion"); 

		if($_GET['cl'] == 'fcl' || $_GET['cl'] == 'lcl')		
			$sqlrn = "select * from rn_fletes where idreporte='$datos[idcot_temp]'";
		if($_GET['cl'] == 'aereo')
			$sqlrn = "select * from rn_fletes_aereo where idreporte='$datos[idcot_temp]'";

		$exern = mysqli_query($link,$sqlrn);
		$filasrn = mysqli_num_rows($exern);
	
		if($_GET['cl'] == 'fcl' || $_GET['cl'] == 'lcl')
			$sqlrn = "select * from rn_fletes where idreporte='$datos[idcot_temp]' and (name='')";
		if($_GET['cl'] == 'aereo')
			$sqlrn = "select * from rn_fletes_aereo where idreporte='$datos[idcot_temp]' and (name='')";

		$exern = mysqli_query($link,$sqlrn);
		$filasrn2 = mysqli_num_rows($exern);
		
		if($filasrn== 0 || $filasrn2 > 0)
		{
			$fletes[] = $datos['idcot_temp']; 
		}
	}

	if($modalidades['otm']=='1')
	{
		$sqlrn = "select * from rn_otm where idreporte='$datos[idcot_temp]'";
		$exern = mysqli_query($link,$sqlrn);
		$filasrn = mysqli_num_rows($exern);
	
		$sqlrn = "select * from rn_otm where idreporte='$datos[idcot_temp]' and corte_hbl=''";
		$exern = mysqli_query($link,$sqlrn);
		$filasrn2 = mysqli_num_rows($exern);
		if($filasrn== 0 || $filasrn2 > 0)
		{
			$otms[] = $datos['idcot_temp'];
		}
	}

	if($modalidades['terrestre']=='1')
	{
		$sqlrn = "select * from rn_terrestre where idreporte='$datos[idcot_temp]'";
		$exern = mysqli_query($link,$sqlrn);
		$filasrn = mysqli_num_rows($exern);
		if($filasrn== 0)
		{
			$terrestres[] = $datos['idcot_temp'];
		}
	}

	if($modalidades['seguro']=='1')
	{
		$sqlrn = "select * from rn_seg where idreporte='$datos[idcot_temp]'";
		$exern = mysqli_query($link,$sqlrn);
		$filasrn = mysqli_num_rows($exern);
					
		$sqlrn = "select * from shipping_instruction_seg where idreporte='$datos[idcot_temp]' and idformato_seguro='0'";
		$exern = mysqli_query($link,$sqlrn);
		$filasrn2 = mysqli_num_rows($exern);
		if($filasrn == 0 /*|| $filasrn2 > 0*/)
		{
			$seguros[] = $datos['idcot_temp'];
		}
	}

	if($modalidades['seguro']=='1' || $modalidades['flete']=='1')
	{
		$_GET['cl'] = scai_get_name("$datos[idcot_temp]", "cot_temp", "idcot_temp", "clasificacion"); 

		if($_GET['cl'] == 'fcl' || $_GET['cl'] == 'lcl')		
			$sqlrn = "select distinct idtarifario from cot_fletes where idcot_fletes in (select idcot_fletes from rn_fletes where idreporte='$datos[idcot_temp]')";
		if($_GET['cl'] == 'aereo')
			$sqlrn = "select distinct idtarifario_aereo from cot_fletes_aereo where idcot_fletes_aereo in (select idcot_fletes_aereo from rn_fletes_aereo where idreporte='$datos[idcot_temp]')";
		$exern = mysqli_query($link,$sqlrn);
		$filasrn = mysqli_num_rows($exern);
					
		$sqlrn = "select * from shipping_instruction_seg where idreporte='$datos[idcot_temp]' and idtarifario!='0'";
		$exern = mysqli_query($link,$sqlrn);


		$filasrn2 = mysqli_num_rows($exern);
		if($filasrn > 0 && $filasrn > $filasrn2)
		{
			$si_seguros[] = $datos['idcot_temp'];
		}
	}
		
	if($modalidades['aduana']=='1')
	{
		$sqlrn = "select * from rn_adu where idreporte='$datos[idcot_temp]'";
		$exern = mysqli_query($link,$sqlrn);
		$filasrn = mysqli_num_rows($exern);
		if($filasrn== 0)
		{
			$aduanas[] = $datos['idcot_temp'];
		}
	}

	if($modalidades['bodega']=='1')
	{
		$sqlrn = "select * from rn_bodegas where idreporte='$datos[idcot_temp]'";
		$exern = mysqli_query($link,$sqlrn);
		$filasrn = mysqli_num_rows($exern);
		if($filasrn== 0)
		{
			$bodegas[] = $datos['idcot_temp'];
		}
	}	
}

?>	
<script>
function showmeda(capa){
	var div = document.getElementById(capa);
	
	if(div.style.display == 'none')
		div.style.display = 'block';
	else
		div.style.display = 'none';

}


</script>

<table width="100%" align="center">
	<tr>
		<td align="center" class="subtitseccion" style="text-align:left" colspan="4">
			<a href="javascript:void(0);" class="subtitseccion" onClick="showmeda('flete')">
			<img src="images/up.png" border="0"/>FLETE </a><?  if(count($fletes)==0) print '(Vacio)'; else print '(Total '.count($fletes) .')'; ?><br><br></td>
	</tr>
</table>

<div style="display:none" id="flete">
	<table width="100%" align="center">
		<tr>
			<td class="tittabla">RN</td>
			<td class="tittabla">Cliente</td>
		</tr>    
		<?
		foreach ($fletes as $idreporte){	
			?>       
			<tr>
			<td class="contenidotab"><? print scai_get_name("$idreporte", "cot_temp", "idcot_temp", "numero"); ?></td>
			<td class="contenidotab"><? print scai_get_name(scai_get_name("$idreporte", "cot_temp", "idcot_temp", "idcliente"), "clientes", "idcliente", "nombre"); ?></td>
			</tr>
			<?
		}?>
	</table>
</div>
<table width="100%" align="center">
	<tr>
		<td align="center" class="subtitseccion" style="text-align:left" colspan="4">
			<a href="javascript:void(0);" class="subtitseccion" onClick="showmeda('shipping')"><img src="images/up.png" border="0"/>SHIPPING SEGURO </a>
			<?  if(count($si_seguros)==0) print '(Vacio)'; else print '(Total '.count($si_seguros) .')'; ?><br><br>
		</td>
	</tr>
</table>
<div style="display:none" id="shipping">
	<table width="100%" align="center">
		<tr>
			<td class="tittabla">RN</td>
			<td class="tittabla">Cliente</td>
		</tr>    
		<?
		foreach ($si_seguros as $idreporte){	
			?>       
			<tr>
			<td class="contenidotab"><? print scai_get_name("$idreporte", "cot_temp", "idcot_temp", "numero"); ?></td>
			<td class="contenidotab"><? print scai_get_name(scai_get_name("$idreporte", "cot_temp", "idcot_temp", "idcliente"), "clientes", "idcliente", "nombre"); ?></td>
			</tr>
			<?
		}
	?>
	</table>
</div>
<table width="100%" align="center">
	<tr>
		<td align="center" class="subtitseccion" style="text-align:left" colspan="4"><a href="javascript:void(0);" class="subtitseccion" onClick="showmeda('otm')"><img src="images/up.png" border="0"/>OTM </a><?  if(count($otms)==0) print '(Vacio)'; else print '(Total '.count($otms) .')'; ?><br><br>
		</td>
	</tr>
</table>
<div style="display:none" id="otm">
	<table width="100%" align="center">
		<tr>
		<td class="tittabla">RN</td>
		<td class="tittabla">Cliente</td>
		</tr>    
		<?
		foreach ($otms as $idreporte){	?>
		<tr>
			<td class="contenidotab"><? print scai_get_name("$idreporte", "cot_temp", "idcot_temp", "numero"); ?></td>
			<td class="contenidotab"><? print scai_get_name(scai_get_name("$idreporte", "cot_temp", "idcot_temp", "idcliente"), "clientes", "idcliente", "nombre"); ?></td>
		</tr>
		<?
		}
	?>
	</table>
</div>
<table width="100%" align="center">
	<tr>
		<td align="center" class="subtitseccion" style="text-align:left" colspan="4"><a href="javascript:void(0);" class="subtitseccion" onClick="showmeda('carga')"><img src="images/up.png" border="0"/>CARGA NACIONALIZADA </a><?  if(count($terrestres)==0) print '(Vacio)'; else print '(Total '.count($terrestres) .')'; ?><br><br>
		</td>
	</tr>
</table>

<div style="display:none" id="carga">
	<table width="100%" align="center">
		<tr>
			<td class="tittabla">RN</td>
			<td class="tittabla">Cliente</td>
		</tr>    
		<?
		foreach ($terrestres as $idreporte){	?>       
			<tr>
				<td class="contenidotab"><? print scai_get_name("$idreporte", "cot_temp", "idcot_temp", "numero"); ?></td>
				<td class="contenidotab"><? print scai_get_name(scai_get_name("$idreporte", "cot_temp", "idcot_temp", "idcliente"), "clientes", "idcliente", "nombre"); ?></td>
	
		</tr>
		<?
		}
	?>
	</table>
</div>

<table width="100%" align="center">
	<tr>
		<td align="center" class="subtitseccion" style="text-align:left" colspan="4"><a href="javascript:void(0);" class="subtitseccion" onClick="showmeda('seguro')"><img src="images/up.png" border="0"/>SEGURO </a><?  if(count($seguros)==0) print '(Vacio)'; else print '(Total '.count($seguros) .')'; ?><br><br></td>
	</tr>
</table>


<div style="display:none" id="seguro">
	<table width="100%" align="center">
		<tr>
			<td class="tittabla">RN</td>
			<td class="tittabla">Cliente</td>
		</tr>    
		<?
		foreach ($seguros as $idreporte){	?>
			<tr>
			<td class="contenidotab"><? print scai_get_name("$idreporte", "cot_temp", "idcot_temp", "numero"); ?></td>
			<td class="contenidotab"><? print scai_get_name(scai_get_name("$idreporte", "cot_temp", "idcot_temp", "idcliente"), "clientes", "idcliente", "nombre"); ?></td>
			</tr>
			<?
		}?>
	</table>
</div>


<table width="100%" align="center">
	<tr>
		<td align="center" class="subtitseccion" style="text-align:left" colspan="4"><a href="javascript:void(0);" class="subtitseccion" onClick="showmeda('aduana')"><img src="images/up.png" border="0"/>ADUANA </a><?  if(count($aduanas)==0) print '(Vacio)'; else print '(Total '.count($aduanas) .')'; ?><br><br></td>
	</tr>
</table>

<div style="display:none" id="aduana">
	<table width="100%" align="center">
		<tr>
		<td class="tittabla">RN</td>
		<td class="tittabla">Cliente</td>
		</tr>    
		<?
		foreach ($aduanas as $idreporte){	?>       
		<tr>
			<td class="contenidotab"><? print scai_get_name("$idreporte", "cot_temp", "idcot_temp", "numero"); ?></td>
			<td class="contenidotab"><? print scai_get_name(scai_get_name("$idreporte", "cot_temp", "idcot_temp", "idcliente"), "clientes", "idcliente", "nombre"); ?></td>
		</tr><?
		}
	?>
	</table>
</div>


<table width="100%" align="center">
	<tr>
	<td align="center" class="subtitseccion" style="text-align:left" colspan="4"><a href="javascript:void(0);" class="subtitseccion" onClick="showmeda('bodega')"><img src="images/up.png" border="0"/>BODEGA </a><?  if(count($bodegas)==0) print '(Vacio)'; else print '(Total '.count($bodegas) .')'; ?><br><br></td>
	</tr>
</table>
<div style="display:none" id="bodega">
<table width="100%" align="center">
	<tr>
	<td class="tittabla">RN</td>
	<td class="tittabla">Cliente</td>
	</tr>    
	<?
    foreach ($bodegas as $idreporte){	?>
		<tr>
		<td class="contenidotab"><? print scai_get_name("$idreporte", "cot_temp", "idcot_temp", "numero"); ?></td>
		<td class="contenidotab"><? print scai_get_name(scai_get_name("$idreporte", "cot_temp", "idcot_temp", "idcliente"), "clientes", "idcliente", "nombre"); ?></td>
		</tr>
		<?
    }
?>
</table>
</div>

