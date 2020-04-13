<? 
include('./sesion/sesion.php');
include("./conection/conectar.php");	
include_once("./permite.php");
include_once("scripts/recover_nombre.php");
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
</script>
<? 
$_GET['cl'] = scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "clasificacion");

if($_POST['datosok']=='si')
{
	$sqldel = "delete from rn_fletes where idreporte='$_GET[idcot_temp]'";
	$exedel = mysqli_query($link,$sqldel);	
	
	if(isset($_POST['sel']))//para lcl
	{
		foreach($_POST['sel'] as $id)
		{
			$idtarifario = scai_get_name("$id","tipo_lcl", "idtipo_lcl", "idtarifario");
			$baf = $_POST['baf_lcl'.$idtarifario];
			$total_neta = $_POST['total_neta'.$idtarifario];
			$minimo_venta = $_POST['minimo_venta'.$idtarifario];
			
			$name = $_POST['name'.$idtarifario];
			$tax_id = $_POST['tax_id'.$idtarifario];
			$address = $_POST['address'.$idtarifario];
			$phone = $_POST['phone'.$idtarifario];
			$contact = $_POST['contact'.$idtarifario];
			$email = $_POST['email'.$idtarifario];
			$city = $_POST['city'.$idtarifario];
			$ordnum = $_POST['ordnum'.$idtarifario];
			$sqltp = "select * from tipo_lcl where idtipo_lcl='$id'"; 
			$exetp = mysqli_query($link,$sqltp);
			$datostp = mysqli_fetch_array($exetp);
			
			$fleteventa = $datostp['total_neta'];
			
			if ($total_neta != '')
				$fleteventa = $total_neta;
				
			if($baf=='1')
				$fleteventa = $fleteventa - $datostp['incremento_baf'].'<br>';
				
			$sql = "select idcot_fletes from cot_fletes where idtipo='$id' and idtarifario='$idtarifario' and idcot_temp='$_GET[idcot_temp]'";
			$exe = mysqli_query($link,$sql);
			$datos = mysqli_fetch_array($exe);
			
			$queryins="INSERT INTO rn_fletes (
							idcot_fletes, 
							idtipo, 
							idreporte, 
							baf, 
							fleteventa, 
							total_neta, 
							minimo_venta, 
							condiciones, 
							name, 
							tax_id, 
							address, 
							phone, 
							contact, 
							email, 
							city, 
							order_number
						) VALUES(
							'$datos[idcot_fletes]', 
							'$id', 
							'$_GET[idcot_temp]', 
							'$baf', 
							'$fleteventa', 
							'$total_neta', 
							'$minimo_venta', 
							'$_POST[condiciones_flete]', 
							'$name', 
							'$tax_id', 
							'$address', 
							'$phone', 
							'$contact', 
							'$email',
							'$city', 
							'$ordnum'
						)";
			//print $_POST['total_neta'.$idtarifario].'<br>';die();
			$buscarins=mysqli_query($link,$queryins);
			
		}		 
	}
			//aereo-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	$sqldel = "delete from rn_fletes_aereo where idreporte='$_GET[idcot_temp]'";
	//print $sqldel.'<br>';
	$exedel = mysqli_query($link,$sqldel);	
	
	if(isset($_POST['sel_minimo']))
	{
		foreach($_POST['sel_minimo'] as $id)
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $_POST['venta_minimo'.$id];
			
			$name = $_POST['name'.$idtarifario_aereo];
			$tax_id = $_POST['tax_id'.$idtarifario_aereo];
			$address = $_POST['address'.$idtarifario_aereo];
			$phone = $_POST['phone'.$idtarifario_aereo];
			$contact = $_POST['contact'.$idtarifario_aereo];
			$email = $_POST['email'.$idtarifario_aereo];
			$ordnum = $_POST['ordnum'.$idtarifario_aereo];
			$city = $_POST['city'.$idtarifario_aereo];
			$depot = $_POST['depot'.$idtarifario_aereo];
				
			$sql = "select idcot_fletes_aereo from cot_fletes_aereo where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_GET[idcot_temp]'";
			$exe = mysqli_query($link,$sql);
			$datos = mysqli_fetch_array($exe);
			
			$queryins="INSERT INTO rn_fletes_aereo (idcot_fletes_aereo, idtipo_aereo, idreporte, venta, condiciones, name, tax_id, address, phone, contact, email, city, depot, order_number) VALUES('$datos[idcot_fletes_aereo]', '$id', '$_GET[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$name', '$tax_id', '$address', '$phone', '$contact', '$email', '$city', '$depot', '$ordnum')";
			//print $queryins.'<br>';die();
			$buscarins=mysqli_query($link,$queryins);
		}		 
	}
	if(isset($_POST['sel_normal']))
	{
		foreach($_POST['sel_normal'] as $id)
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $_POST['venta_normal'.$id];
			
			$name = $_POST['name'.$idtarifario_aereo];
			$tax_id = $_POST['tax_id'.$idtarifario_aereo];
			$address = $_POST['address'.$idtarifario_aereo];
			$phone = $_POST['phone'.$idtarifario_aereo];
			$contact = $_POST['contact'.$idtarifario_aereo];
			$email = $_POST['email'.$idtarifario_aereo];
			$city = $_POST['city'.$idtarifario_aereo];
			$depot = $_POST['depot'.$idtarifario_aereo];
			$ordnum = $_POST['ordnum'.$idtarifario_aereo];				
			$sql = "select idcot_fletes_aereo from cot_fletes_aereo where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_GET[idcot_temp]'";
			$exe = mysqli_query($link,$sql);
			$datos = mysqli_fetch_array($exe);
			
			$queryins="INSERT INTO rn_fletes_aereo (idcot_fletes_aereo, 
								idtipo_aereo, 
								idreporte, 
								venta, 
								condiciones, 
								name, 
								tax_id, 
								address, 
								phone, 
								contact, 
								email, 
								city, 
								depot, 
								order_number
						) VALUES(
							'$datos[idcot_fletes_aereo]', 
							'$id', 
							'$_GET[idcot_temp]', 
							'$venta', 
							'$_POST[condiciones_flete]', 
							'$name', 
							'$tax_id', 
							'$address', 
							'$phone', 
							'$contact', 
							'$email', 
							'$city', 
							'$depot',
						'$ordnum')";
			
			$buscarins=mysqli_query($link,$queryins);
		}		 
	}
	if(isset($_POST['sel45']))
	{
		foreach($_POST['sel45'] as $id)
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $_POST['venta45'.$id];
			
			$name = $_POST['name'.$idtarifario_aereo];
			$tax_id = $_POST['tax_id'.$idtarifario_aereo];
			$address = $_POST['address'.$idtarifario_aereo];
			$phone = $_POST['phone'.$idtarifario_aereo];
			$contact = $_POST['contact'.$idtarifario_aereo];
			$email = $_POST['email'.$idtarifario_aereo];
			$city = $_POST['city'.$idtarifario_aereo];
			$depot = $_POST['depot'.$idtarifario_aereo];
			$ordnum = $_POST['ordnum'.$idtarifario_aereo];	
				
			$sql = "select idcot_fletes_aereo from cot_fletes_aereo where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_GET[idcot_temp]'";
			$exe = mysqli_query($link,$sql);
			$datos = mysqli_fetch_array($exe);
			
			$queryins="INSERT INTO rn_fletes_aereo (idcot_fletes_aereo, idtipo_aereo, idreporte, venta, condiciones, name, tax_id, address, phone, contact, email, city, depot, order_number) VALUES('$datos[idcot_fletes_aereo]', '$id', '$_GET[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$name', '$tax_id', '$address', '$phone', '$contact', '$email', '$city', '$depot', '$ordnum')";
			
			$buscarins=mysqli_query($link,$queryins);
		}		 
	}
	if(isset($_POST['sel100']))
	{
		foreach($_POST['sel100'] as $id)
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $_POST['venta100'.$id];
			
			$name = $_POST['name'.$idtarifario_aereo];
			$tax_id = $_POST['tax_id'.$idtarifario_aereo];
			$address = $_POST['address'.$idtarifario_aereo];
			$phone = $_POST['phone'.$idtarifario_aereo];
			$contact = $_POST['contact'.$idtarifario_aereo];
			$email = $_POST['email'.$idtarifario_aereo];
			$city = $_POST['city'.$idtarifario_aereo];
			$depot = $_POST['depot'.$idtarifario_aereo];
			$ordnum = $_POST['ordnum'.$idtarifario_aereo];
			$sql = "select idcot_fletes_aereo from cot_fletes_aereo where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_GET[idcot_temp]'";
			$exe = mysqli_query($link,$sql);
			$datos = mysqli_fetch_array($exe);
			
			$queryins="INSERT INTO rn_fletes_aereo (idcot_fletes_aereo, idtipo_aereo, idreporte, venta, condiciones, name, tax_id, address, phone, contact, email, city, depot, order_number) VALUES('$datos[idcot_fletes_aereo]', '$id', '$_GET[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$name', '$tax_id', '$address', '$phone', '$contact', '$email', '$city', '$depot', '$ordnum')";
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
		}		 
	}
	if(isset($_POST['sel300']))
	{
		foreach($_POST['sel300'] as $id)
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $_POST['venta300'.$id];
			
			$name = $_POST['name'.$idtarifario_aereo];
			$tax_id = $_POST['tax_id'.$idtarifario_aereo];
			$address = $_POST['address'.$idtarifario_aereo];
			$phone = $_POST['phone'.$idtarifario_aereo];
			$contact = $_POST['contact'.$idtarifario_aereo];
			$email = $_POST['email'.$idtarifario_aereo];
			$city = $_POST['city'.$idtarifario_aereo];
			$depot = $_POST['depot'.$idtarifario_aereo];
			$ordnum = $_POST['ordnum'.$idtarifario_aereo];	
			$sql = "select idcot_fletes_aereo from cot_fletes_aereo where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_GET[idcot_temp]'";
			$exe = mysqli_query($link,$sql);
			$datos = mysqli_fetch_array($exe);
			
			$queryins="INSERT INTO rn_fletes_aereo (idcot_fletes_aereo, idtipo_aereo, idreporte, venta, condiciones, name, tax_id, address, phone, contact, email, city, depot, order_number) VALUES('$datos[idcot_fletes_aereo]', '$id', '$_GET[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$name', '$tax_id', '$address', '$phone', '$contact', '$email', '$city', '$depot', '$ordnum')";
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
		}		 
	}
	if(isset($_POST['sel500']))
	{
		foreach($_POST['sel500'] as $id)
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $_POST['venta500'.$id];
			
			$name = $_POST['name'.$idtarifario_aereo];
			$tax_id = $_POST['tax_id'.$idtarifario_aereo];
			$address = $_POST['address'.$idtarifario_aereo];
			$phone = $_POST['phone'.$idtarifario_aereo];
			$contact = $_POST['contact'.$idtarifario_aereo];
			$email = $_POST['email'.$idtarifario_aereo];
			$city = $_POST['city'.$idtarifario_aereo];
			$depot = $_POST['depot'.$idtarifario_aereo];
			$ordnum = $_POST['ordnum'.$idtarifario_aereo];
				
			$sql = "select idcot_fletes_aereo from cot_fletes_aereo where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_GET[idcot_temp]'";
			$exe = mysqli_query($link,$sql);
			$datos = mysqli_fetch_array($exe);
			
			$queryins="INSERT INTO rn_fletes_aereo (idcot_fletes_aereo, idtipo_aereo, idreporte, venta, condiciones, name, tax_id, address, phone, contact, email, city, depot, order_number) VALUES('$datos[idcot_fletes_aereo]', '$id', '$_GET[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$name', '$tax_id', '$address', '$phone', '$contact', '$email', '$city', '$depot', '$ordnum')";
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
		}		 
	}
	if(isset($_POST['sel1000']))
	{
		foreach($_POST['sel1000'] as $id)
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $_POST['venta1000'.$id];
			
			$name = $_POST['name'.$idtarifario_aereo];
			$tax_id = $_POST['tax_id'.$idtarifario_aereo];
			$address = $_POST['address'.$idtarifario_aereo];
			$phone = $_POST['phone'.$idtarifario_aereo];
			$contact = $_POST['contact'.$idtarifario_aereo];
			$email = $_POST['email'.$idtarifario_aereo];
			$city = $_POST['city'.$idtarifario_aereo];
			$depot = $_POST['depot'.$idtarifario_aereo];


			$ordnum = $_POST['ordnum'.$idtarifario_aereo];
			$sql = "select idcot_fletes_aereo from cot_fletes_aereo where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_GET[idcot_temp]'";
			$exe = mysqli_query($link,$sql);
			$datos = mysqli_fetch_array($exe);

			$queryins="INSERT INTO rn_fletes_aereo (idcot_fletes_aereo, 
													idtipo_aereo, 
													idreporte, 
													venta, 
													condiciones, 
													name, 
													tax_id, 
													address, 
													phone, 
													contact, 
													email, 
													city, 
													depot, 
													order_number
											) VALUES(
												'$datos[idcot_fletes_aereo]', 
												'$id', 
												'$_GET[idcot_temp]', 
												'$venta', 
												'$_POST[condiciones_flete]', 
												'$name', 
												'$tax_id', 
												'$address', 
												'$phone', 
												'$contact', 
												'$email', 
												'$city', 
												'$depot', 
												'$ordnum'
											)";
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
		}		 
	}
	if(isset($_POST['sel20']))
	{
		foreach($_POST['sel20'] as $id)
		{
			$cantidad = $_POST['cantidad'.$id];
			
			$idtarifario = scai_get_name("$id","tipo", "idtipo", "idtarifario");
			$baf = $_POST['baf'.$idtarifario];
			$gri = $_POST['gri'.$idtarifario];
			$pss = $_POST['pss'.$idtarifario];
			$all_in_20 = $_POST['all_in_20'.$idtarifario];
			$all_in_40 = $_POST['all_in_40'.$idtarifario];
			$all_in_40hq = $_POST['all_in_40hq'.$idtarifario];
			$total_neta = $_POST['total_neta'.$idtarifario];
			
			$name = $_POST['name'.$idtarifario];
			$tax_id = $_POST['tax_id'.$idtarifario];
			$address = $_POST['address'.$idtarifario];
			$phone = $_POST['phone'.$idtarifario];
			$contact = $_POST['contact'.$idtarifario];
			$email = $_POST['email'.$idtarifario];
			$city = $_POST['city'.$idtarifario];
			$ordnum = $_POST['ordnum'.$idtarifario];


			
			
			$sqltp = "select * from tipo where idtipo='$id'"; 
			$exetp = mysqli_query($link,$sqltp);
			$datostp = mysqli_fetch_array($exetp);
			
			$fleteventa = $datostp['all_in'];
			
			if ($all_in_20 != '')
				$fleteventa = $all_in_20;
				
			if($baf=='1')
				$fleteventa = $fleteventa - $datostp['baf'].'<br>';
			if($gri=='1')	
				$fleteventa = $fleteventa - $datostp['gri_1'].'<br>';
			if($pss=='1')
				$fleteventa = $fleteventa - $datostp['peak_season'].'<br>';
				
			$sql = "select idcot_fletes from cot_fletes where idtipo='$id' and idtarifario='$idtarifario' and idcot_temp='$_GET[idcot_temp]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$datos = mysqli_fetch_array($exe);
			
			$queryins="INSERT INTO rn_fletes (
							idcot_fletes, 
							idtipo, 
							idreporte, 
							baf, 
							gri, 
							pss, 
							fleteventa, 
							all_in_20, 
							all_in_40, 
							all_in_40hq, 
							total_neta,
							condiciones,
							name,
							tax_id, 
							address, 
							phone, 
							contact, 
							email, 
							city,
							cantidad,
							order_number
						)VALUES(
							'$datos[idcot_fletes]', 
							'$id', 
							'$_GET[idcot_temp]', 
							'$baf',
							'$gri',
							'$pss',
							'$fleteventa',
							'$all_in_20',
							'$all_in_40',
							'$all_in_40hq',
							'$total_neta',
							'$_POST[condiciones_flete]',
							'$name',
							'$tax_id',
							'$address',
							'$phone',
							'$contact',
							'$email',
							'$city',
							'$cantidad',
							'$ordnum'
						)";	
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
		}
	}
	if(isset($_POST['sel40']))
	{
		foreach($_POST['sel40'] as $id)
		{
			$cantidad = $_POST['cantidad'.$id];
			
			$idtarifario = scai_get_name("$id","tipo", "idtipo", "idtarifario");
			$baf = $_POST['baf'.$idtarifario];
			$gri = $_POST['gri'.$idtarifario];
			$pss = $_POST['pss'.$idtarifario];
			$all_in_20 = $_POST['all_in_20'.$idtarifario];
			$all_in_40 = $_POST['all_in_40'.$idtarifario];
			$all_in_40hq = $_POST['all_in_40hq'.$idtarifario];
			$total_neta = $_POST['total_neta'.$idtarifario];
			
			$name = $_POST['name'.$idtarifario];
			$tax_id = $_POST['tax_id'.$idtarifario];
			$address = $_POST['address'.$idtarifario];
			$phone = $_POST['phone'.$idtarifario];
			$contact = $_POST['contact'.$idtarifario];
			$email = $_POST['email'.$idtarifario];
			$city = $_POST['city'.$idtarifario];
			$ordnum = $_POST['ordnum'.$idtarifario];
			
			$sqltp = "select * from tipo where idtipo='$id'"; 
			$exetp = mysqli_query($link,$sqltp);
			$datostp = mysqli_fetch_array($exetp);
			
			$fleteventa = $datostp['all_in'];
			
			if ($all_in_40 != '')
				$fleteventa = $all_in_40;
				
			if($baf=='1')
				$fleteventa = $fleteventa - $datostp['baf'].'<br>';
			if($gri=='1')	
				$fleteventa = $fleteventa - $datostp['gri_1'].'<br>';
			if($pss=='1')
				$fleteventa = $fleteventa - $datostp['peak_season'].'<br>';
				
			$sql = "select idcot_fletes from cot_fletes where idtipo='$id' and idtarifario='$idtarifario' and idcot_temp='$_GET[idcot_temp]'";
			$exe = mysqli_query($link,$sql);
			$datos = mysqli_fetch_array($exe);
			
			$queryins="INSERT INTO rn_fletes (
							idcot_fletes, 
							idtipo, 
							idreporte, 
							baf, 
							gri, 
							pss, 
							fleteventa, 
							all_in_20, 
							all_in_40, 
							all_in_40hq, 
							total_neta,
							condiciones, 
							name, 
							tax_id, 
							address, 
							phone, 
							contact, 
							email, 
							city, 
							cantidad, 
							order_number
						) VALUES(
							'$datos[idcot_fletes]'
							, '$id', 
							'$_GET[idcot_temp]', 
							'$baf', 
							'$gri', 
							'$pss', 
							'$fleteventa', 
							'$all_in_20', 
							'$all_in_40', 
							'$all_in_40hq', 
							'$total_neta', 
							'$_POST[condiciones_flete]', 
							'$name', 
							'$tax_id', 
							'$address', 
							'$phone', 
							'$contact', 
							'$email', 
							'$city', 
							'$cantidad',
							'$ordnum'
						)";	
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
		}
	}
	if(isset($_POST['sel40hq']))
	{
		foreach($_POST['sel40hq'] as $id)
		{
			$cantidad = $_POST['cantidad'.$id];
			
			$idtarifario = scai_get_name("$id","tipo", "idtipo", "idtarifario");
			$baf = $_POST['baf'.$idtarifario];
			$gri = $_POST['gri'.$idtarifario];
			$pss = $_POST['pss'.$idtarifario];
			$all_in_20 = $_POST['all_in_20'.$idtarifario];
			$all_in_40 = $_POST['all_in_40'.$idtarifario];
			$all_in_40hq = $_POST['all_in_40hq'.$idtarifario];
			$total_neta = $_POST['total_neta'.$idtarifario];
			
			$name = $_POST['name'.$idtarifario];
			$tax_id = $_POST['tax_id'.$idtarifario];
			$address = $_POST['address'.$idtarifario];
			$phone = $_POST['phone'.$idtarifario];
			$contact = $_POST['contact'.$idtarifario];
			$email = $_POST['email'.$idtarifario];
			$city = $_POST['city'.$idtarifario];
			$ordnum = $_POST['ordnum'.$idtarifario];
			$sqltp = "select * from tipo where idtipo='$id'"; 
			$exetp = mysqli_query($link,$sqltp);
			$datostp = mysqli_fetch_array($exetp);
			
			$fleteventa = $datostp['all_in'];
			
			if ($all_in_40hq != '')
				$fleteventa = $all_in_40hq;
			
			if($baf=='1')
				$fleteventa = $fleteventa - $datostp['baf'].'<br>';
			if($gri=='1')	
				$fleteventa = $fleteventa - $datostp['gri_1'].'<br>';
			if($pss=='1')
				$fleteventa = $fleteventa - $datostp['peak_season'].'<br>';
			
			$sql = "select idcot_fletes from cot_fletes where idtipo='$id' and idtarifario='$idtarifario' and idcot_temp='$_GET[idcot_temp]'";
			$exe = mysqli_query($link,$sql);
			$datos = mysqli_fetch_array($exe);
			
			$queryins="INSERT INTO rn_fletes (
							idcot_fletes, 
							idtipo, 
							idreporte,
							baf, 
							gri, 
							pss, 
							fleteventa, 
							all_in_20, 
							all_in_40, 
							all_in_40hq, 
							total_neta,
							condiciones, 
							name, 
							tax_id, 
							address, 
							phone, 
							contact, 
							email, 
							city, 
							cantidad, 
							order_number
						) VALUES(
							'$datos[idcot_fletes]', 
							'$id', 
							'$_GET[idcot_temp]', 
							'$baf', 
							'$gri', 
							'$pss', 
							'$fleteventa', 
							'$all_in_20', 
							'$all_in_40', 
							'$all_in_40hq', 
							'$total_neta', 
							'$_POST[condiciones_flete]', 
							'$name', 
							'$tax_id', 
							'$address', 
							'$phone', 
							'$contact', 
							'$email', 
							'$city', 
							'$cantidad', 
							'$ordnum'
						)";	

			$buscarins=mysqli_query($link,$queryins);
		}
	}



	if(!$buscarins)
			print ("<script>alert('No se pudo guardar el registro')</script>");
		else
			print "<script>alert('El registro ha sido guardado satisfactoriamente')</script>";		
}
?>
<form name="formulario" id="formulario" method="post">
<input name="datosok" type="hidden" value="no" />

<table width="100%" align="center">
    <tr>
        <td class="subtitseccion" style="text-align:center" >FLETE COTIZACI&Oacute;N <? print scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero"); ?><br><br></td>
    </tr>
</table>
<?

if($_GET['cl']=='fcl')
	include("rn_search_flete_fcl.php");
elseif($_GET['cl']=='lcl')
	include("rn_search_flete_lcl.php");	
elseif($_GET['cl']=='aereo')
	include("rn_search_flete_aereo.php");
?>
<table>
	<tr>
        <td colspan="5" align="left">
            <table>
                <tr>
                	<td width="60" class="botonesadmin"><a href="modalidades.php?idcot_temp=<? print $_GET['idcot_temp']; ?>" onClick="">Atras</a></td>
                	<? if(puedo("c","REPORTES_NEGOCIO")==1 || puedo("m","REPORTES_NEGOCIO")==1) { ?>
                    <td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
                    <? } ?>
                </tr>
            </table> 
        </td>        	
    </tr>
</table>
</form>
