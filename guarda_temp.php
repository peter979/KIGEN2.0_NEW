<?
include_once("conection/conectar.php");
include_once("scripts/recover_nombre.php");
	
$sel = explode(',',$_POST['lista']);
$sel20 = explode(',',$_POST['lista20']);
$sel40 = explode(',',$_POST['lista40']);
$sel40hq = explode(',',$_POST['lista40hq']);

$selotm = explode(',',$_POST['lista_otm']);
/*
print_r($sel);
print_r($sel20);
print_r($sel40);
print_r($sel40hq);

print 'lista_total_neta '.$_POST['lista_total_neta'].'<br>';
print 'lista_minimo_venta '.$_POST['lista_minimo_venta'].'<br>';
print 'lista_baf_lcl '.$_POST['lista_baf_lcl'].'<br>';

print 'lista_allin_20 '.$_POST['lista_allin_20'].'<br>';
print 'lista_allin_40 '.$_POST['lista_allin_40'].'<br>';
print 'lista_allin_40hq '.$_POST['lista_allin_40hq'].'<br>';

print 'lista_baf_20 '.$_POST['lista_baf_20'].'<br>';
print 'lista_baf_40 '.$_POST['lista_baf_40'].'<br>';
print 'lista_baf_40hq '.$_POST['lista_baf_40hq'].'<br>';

print 'lista_gri_20 '.$_POST['lista_gri_20'].'<br>';
print 'lista_gri_40 '.$_POST['lista_gri_40'].'<br>';
print 'lista_gri_40hq '.$_POST['lista_gri_40hq'].'<br>';

print 'lista_pss_20 '.$_POST['lista_pss_20'].'<br>';
print 'lista_pss_40 '.$_POST['lista_pss_40'].'<br>';
print 'lista_pss_40hq '.$_POST['lista_pss_40hq'].'<br>';

print 'lista_dev '.$_POST['lista_dev'].'<br>';
print 'lista_esc '.$_POST['lista_esc'].'<br>';
print 'lista_venta '.$_POST['lista_venta'].'<br>';*/

$lista = explode(',',$_POST['lista']);
$lista_total_neta = explode(',',$_POST['lista_total_neta']);
$lista_minimo_venta = explode(',',$_POST['lista_minimo_venta']);
$lista_baf_lcl = explode(',',$_POST['lista_baf_lcl']);

$n_all_in_20 = explode(',',$_POST['lista_allin_20']);
$n_all_in_40 = explode(',',$_POST['lista_allin_40']);
$n_all_in_40hq = explode(',',$_POST['lista_allin_40hq']);

$lista_baf_20 = explode(',',$_POST['lista_baf_20']);
$lista_baf_40 = explode(',',$_POST['lista_baf_40']);
$lista_baf_40hq = explode(',',$_POST['lista_baf_40hq']);

$lista_gri_20 = explode(',',$_POST['lista_gri_20']);
$lista_gri_40 = explode(',',$_POST['lista_gri_40']);
$lista_gri_40hq = explode(',',$_POST['lista_gri_40hq']);

$lista_pss_20 = explode(',',$_POST['lista_pss_20']);
$lista_pss_40 = explode(',',$_POST['lista_pss_40']);
$lista_pss_40hq = explode(',',$_POST['lista_pss_40hq']);

$lista_dev = explode(',',$_POST['lista_dev']);
$lista_esc = explode(',',$_POST['lista_esc']);
$lista_venta = explode(',',$_POST['lista_venta']);

$sel_minimo = explode(',',$_POST['lista_minimo']);
$sel_normal = explode(',',$_POST['lista_normal']);
$sel45 = explode(',',$_POST['lista45']);
$sel100 = explode(',',$_POST['lista100']);
$sel300 = explode(',',$_POST['lista300']);
$sel500 = explode(',',$_POST['lista500']);
$sel1000 = explode(',',$_POST['lista1000']);
/*
print_r($sel_minimo);
print_r($sel_normal);
print_r($sel45);
print_r($sel100);
print_r($sel300);
print_r($sel500);
print_r($sel1000);*/
	
$lista_venta_minimo = explode(',',$_POST['lista_venta_minimo']);
$lista_venta_normal = explode(',',$_POST['lista_venta_normal']);
$lista_venta45 = explode(',',$_POST['lista_venta45']);
$lista_venta100 = explode(',',$_POST['lista_venta100']);
$lista_venta300 = explode(',',$_POST['lista_venta300']);
$lista_venta500 = explode(',',$_POST['lista_venta500']);
$lista_venta1000 = explode(',',$_POST['lista_venta1000']);
//--------------------------------------------------------------------------------------------------------------

/*print 'lista_security_minimo '.$_POST['lista_security_minimo'].'<br>';
print 'lista_security_normal '.$_POST['lista_security_normal'].'<br>';
print 'lista_security45 '.$_POST['lista_security45'].'<br>';
print 'lista_security100 '.$_POST['lista_security100'].'<br>';
print 'lista_security300 '.$_POST['lista_security300'].'<br>';
print 'lista_security500 '.$_POST['lista_security500'].'<br>';
print 'lista_security1000 '.$_POST['lista_security1000'].'<br>';

print 'lista_mz_minimo '.$_POST['lista_mz_minimo'].'<br>';
print 'lista_mz_normal '.$_POST['lista_mz_normal'].'<br>';
print 'lista_mz45 '.$_POST['lista_mz45'].'<br>';
print 'lista_mz100 '.$_POST['lista_mz100'].'<br>';
print 'lista_mz300 '.$_POST['lista_mz300'].'<br>';
print 'lista_mz500 '.$_POST['lista_mz500'].'<br>';
print 'lista_mz1000 '.$_POST['lista_mz1000'].'<br>';

print 'lista_fuel_minimo '.$_POST['lista_fuel_minimo'].'<br>';
print 'lista_fuel_normal '.$_POST['lista_fuel_normal'].'<br>';
print 'lista_fuel45 '.$_POST['lista_fuel45'].'<br>';
print 'lista_fuel100 '.$_POST['lista_fuel100'].'<br>';
print 'lista_fuel300 '.$_POST['lista_fuel300'].'<br>';
print 'lista_fuel500 '.$_POST['lista_fuel500'].'<br>';
print 'lista_fuel1000 '.$_POST['lista_fuel1000'].'<br>';*/

//--------------------------------------------------------------------------------------------------------------

$lista_security_minimo = explode(',',$_POST['lista_security_minimo']);
$lista_security_normal = explode(',',$_POST['lista_security_normal']);
$lista_security45 = explode(',',$_POST['lista_security45']);
$lista_security100 = explode(',',$_POST['lista_security100']);
$lista_security300 = explode(',',$_POST['lista_security300']);
$lista_security500 = explode(',',$_POST['lista_security500']);
$lista_security1000 = explode(',',$_POST['lista_security1000']);

$lista_mz_minimo = explode(',',$_POST['lista_mz_minimo']);
$lista_mz_normal = explode(',',$_POST['lista_mz_normal']);
$lista_mz45 = explode(',',$_POST['lista_mz45']);
$lista_mz100 = explode(',',$_POST['lista_mz100']);
$lista_mz300 = explode(',',$_POST['lista_mz300']);
$lista_mz500 = explode(',',$_POST['lista_mz500']);
$lista_mz1000 = explode(',',$_POST['lista_mz1000']);

$lista_fuel_minimo = explode(',',$_POST['lista_fuel_minimo']);
$lista_fuel_normal = explode(',',$_POST['lista_fuel_normal']);
$lista_fuel45 = explode(',',$_POST['lista_fuel45']);
$lista_fuel100 = explode(',',$_POST['lista_fuel100']);
$lista_fuel300 = explode(',',$_POST['lista_fuel300']);
$lista_fuel500 = explode(',',$_POST['lista_fuel500']);
$lista_fuel1000 = explode(',',$_POST['lista_fuel1000']);
$condiciones = $_POST['condiciones'];

if(isset($sel))//para lcl
{
	$n = 0;
	foreach($sel as $id)
	{
		if($id!='')
		{
			$idtarifario = scai_get_name("$id","tipo_lcl", "idtipo_lcl", "idtarifario");
			$baf = $lista_baf_lcl[$n];
			$total_neta = $lista_total_neta[$n];
			$minimo_venta = $lista_minimo_venta[$n];
			
			$sqltp = "select * from tipo_lcl where idtipo_lcl='$id'"; 
			$exetp = mysqli_query($link,$sqltp);
			$datostp = mysqli_fetch_array($exetp);
			
			$fleteventa = $datostp['total_neta'];
			
			if ($total_neta != '')
				$fleteventa = $total_neta;
				
			if($baf=='1')
				$fleteventa = $fleteventa - $datostp['incremento_baf'].'<br>';
			
			$sql = "select idcot_temp from  cot_fletes_tmp where idtipo='$id' and idtarifario='$idtarifario' and idcot_temp='$_POST[idcot_temp]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$filas = mysqli_num_rows($exe);
			
			if($filas == 0)
			{	
				$queryins="INSERT INTO cot_fletes_tmp (idtipo, idtarifario, idcot_temp, baf, fleteventa, total_neta, minimo_venta, condiciones) VALUES('$id', '$idtarifario', '$_POST[idcot_temp]', '$baf', '$fleteventa', '$total_neta', '$minimo_venta', '$condiciones')";
			}
			elseif($filas > 0)
			{
				$queryins="update cot_fletes_tmp set baf='$baf', fleteventa='$fleteventa', total_neta='$total_neta', minimo_venta='$minimo_venta' where idtipo='$id' and idtarifario='$idtarifario' and idcot_temp='$_POST[idcot_temp]'";
			}
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
			$n++;
		}
	}		 
}

if(isset($sel20))
{
	$n = 0;
	foreach($sel20 as $id)
	{	
		if($id!='')
		{
			$idtarifario = scai_get_name("$id","tipo", "idtipo", "idtarifario");
			$baf = $lista_baf_20[$n];
			$gri = $lista_gri_20[$n];
			$pss = $lista_pss_20[$n];
			
			$alls =  explode('*', $n_all_in_20[$n]);			
			$all_in_20 = $alls[0];
			$all_in_40 = $alls[1];
			$all_in_40hq = $alls[2];
			
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
			
			$sql = "select idcot_temp from  cot_fletes_tmp where idtipo='$id' and idtarifario='$idtarifario' and idcot_temp='$_POST[idcot_temp]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$filas = mysqli_num_rows($exe);
			
			if($filas == 0)
			{
				$queryins="INSERT INTO cot_fletes_tmp (idtipo, idtarifario, idcot_temp, baf, gri, pss, fleteventa, all_in_20, all_in_40, all_in_40hq, condiciones) VALUES('$id', '$idtarifario', '$_POST[idcot_temp]', '$baf', '$gri', '$pss', '$fleteventa', '$all_in_20', '$all_in_40', '$all_in_40hq', '$condiciones')";
			}
			elseif($filas > 0)
			{
				$queryins="update cot_fletes_tmp set baf='$baf', gri='$gri', pss='$pss', fleteventa='$fleteventa', all_in_20='$all_in_20', all_in_40='$all_in_40', all_in_40hq='$all_in_40hq' where idtipo='$id' and idtarifario='$idtarifario' and idcot_temp='$_POST[idcot_temp]'";
			}
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
			$n++;
		}
	}
}
if(isset($sel40))
{
	$n = 0;
	foreach($sel40 as $id)
	{
		if($id!='')
		{
			$idtarifario = scai_get_name("$id","tipo", "idtipo", "idtarifario");
			$baf = $lista_baf_40[$n];
			$gri = $lista_gri_40[$n];
			$pss = $lista_pss_40[$n];
			
			$alls =  explode('*', $n_all_in_40[$n]);			
			$all_in_20 = $alls[0];
			$all_in_40 = $alls[1];
			$all_in_40hq = $alls[2];
			
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
			
			$sql = "select idcot_temp from  cot_fletes_tmp where idtipo='$id' and idtarifario='$idtarifario' and idcot_temp='$_POST[idcot_temp]'";
			$exe = mysqli_query($link,$sql);
			$filas = mysqli_num_rows($exe);
			
			if($filas == 0)
			{
				$queryins="INSERT INTO cot_fletes_tmp (idtipo, idtarifario, idcot_temp, baf, gri, pss, fleteventa, all_in_20, all_in_40, all_in_40hq, condiciones) VALUES('$id', '$idtarifario', '$_POST[idcot_temp]', '$baf', '$gri', '$pss', '$fleteventa', '$all_in_20', '$all_in_40', '$all_in_40hq', '$condiciones')";
			}
			elseif($filas > 0)
			{
				$queryins="update cot_fletes_tmp set baf='$baf', gri='$gri', pss='$pss', fleteventa='$fleteventa', all_in_20='$all_in_20', all_in_40='$all_in_40', all_in_40hq='$all_in_40hq' where idtipo='$id' and idtarifario='$idtarifario' and idcot_temp='$_POST[idcot_temp]'";
			}
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
			$n++;
		}
	}
}
if(isset($sel40hq))
{
	$n = 0;
	foreach($sel40hq as $id)
	{
		if($id!='')
		{
			$idtarifario = scai_get_name("$id","tipo", "idtipo", "idtarifario");
			$baf = $lista_baf_40hq[$n];
			$gri = $lista_gri_40hq[$n];
			$pss = $lista_pss_40hq[$n];
			
			$alls =  explode('*', $n_all_in_40hq[$n]);			
			$all_in_20 = $alls[0];
			$all_in_40 = $alls[1];
			$all_in_40hq = $alls[2];
			
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
			
			$sql = "select idcot_temp from  cot_fletes_tmp where idtipo='$id' and idtarifario='$idtarifario' and idcot_temp='$_POST[idcot_temp]'";
			$exe = mysqli_query($link,$sql);
			$filas = mysqli_num_rows($exe);
			if($filas == 0)
			{
				$queryins="INSERT INTO cot_fletes_tmp (idtipo, idtarifario, idcot_temp, baf, gri, pss, fleteventa, all_in_20, all_in_40, all_in_40hq, condiciones) VALUES('$id', '$idtarifario', '$_POST[idcot_temp]', '$baf', '$gri', '$pss', '$fleteventa', '$all_in_20', '$all_in_40', '$all_in_40hq', '$condiciones')";
			}
			elseif($filas > 0)
			{
				$queryins="update cot_fletes_tmp set baf='$baf', gri='$gri', pss='$pss', fleteventa='$fleteventa', all_in_20='$all_in_20', all_in_40='$all_in_40', all_in_40hq='$all_in_40hq' where idtipo='$id' and idtarifario='$idtarifario' and idcot_temp='$_POST[idcot_temp]'";
			}
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
			$n++;
		}
	}
}

if(isset($selotm))
{
	foreach($selotm as $id)
	{
		if($id!='')
		{
			$selotm_dev = $lista_dev[$n];
			$selotm_esc = $lista_esc[$n];			
			$valor_venta = $lista_venta[$n];			
			//print_r($lista_venta);
			
			$sql = "select idcot_temp from  cot_otm_tmp where idotm='$id' and idcot_temp='$_POST[idcot_temp]'";
			$exe = mysqli_query($link,$sql);
			$filas = mysqli_num_rows($exe);			
			//print $sql.'<br>';
			
			if($filas == 0)
			{			
				$queryins="INSERT INTO cot_otm_tmp (idotm, idcot_temp, valor_venta, devolucion, escolta) VALUES('$id', '$_POST[idcot_temp]', '$valor_venta', '$selotm_dev', '$selotm_esc')";
			}
			elseif($filas > 0)
			{
				$queryins="update cot_otm_tmp set valor_venta='$valor_venta', devolucion='$selotm_dev', escolta='$selotm_esc' where idotm='$id' and idcot_temp='$_POST[idcot_temp]'";
			}
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
			$n++;			
		}
	}
}

//aereo----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
if(isset($sel_minimo))
{
	$n = 0;
	foreach($sel_minimo as $id)
	{
		if($id!='')
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $lista_venta_minimo[$n];
			$security = $lista_security_minimo[$n];
			$mz = $lista_mz_minimo[$n];
			$fuel = $lista_fuel_minimo[$n];
				
			$sql = "select idcot_temp from  cot_fletes_aereo_tmp where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_POST[idcot_temp]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$filas = mysqli_num_rows($exe);
			
			if($filas == 0)
			{
				$queryins="INSERT INTO cot_fletes_aereo_tmp (idtipo_aereo, idtarifario_aereo, idcot_temp, venta, condiciones, security, mz, fuel) VALUES('$id', '$idtarifario_aereo', '$_POST[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$security', '$mz', '$fuel')";
			}
			elseif($filas > 0)
			{
				$queryins="update cot_fletes_aereo_tmp set venta='$venta', condiciones='$_POST[condiciones_flete]', security='$security', mz='$mz', fuel='$fuel' where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_POST[idcot_temp]'";
			}
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
			$n++;
		}
	}		 
}
if(isset($sel_normal))
{
	$n = 0;
	foreach($sel_normal as $id)
	{
		if($id!='')
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $lista_venta_normal[$n];
			$security = $lista_security_normal[$n];
			$mz = $lista_mz_normal[$n];
			$fuel = $lista_fuel_normal[$n];
				
			$sql = "select idcot_temp from cot_fletes_aereo_tmp where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_POST[idcot_temp]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$filas = mysqli_num_rows($exe);
			
			if($filas == 0)
			{
				$queryins="INSERT INTO cot_fletes_aereo_tmp (idtipo_aereo, idtarifario_aereo, idcot_temp, venta, condiciones, security, mz, fuel) VALUES('$id', '$idtarifario_aereo', '$_POST[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$security', '$mz', '$fuel')";
			}
			elseif($filas > 0)
			{
				$queryins="update cot_fletes_aereo_tmp set venta='$venta', condiciones='$_POST[condiciones_flete]', security='$security', mz='$mz', fuel='$fuel' where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_POST[idcot_temp]'";
			}
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
			$n++;
		}
	}		 
}
if(isset($sel45))
{
	$n = 0;
	foreach($sel45 as $id)
	{
		if($id!='')
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $lista_venta45[$n];
			$security = $lista_security45[$n];
			$mz = $lista_mz45[$n];
			$fuel = $lista_fuel45[$n];
				
			$sql = "select idcot_temp from  cot_fletes_aereo_tmp where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_POST[idcot_temp]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$filas = mysqli_num_rows($exe);
			//print 'filas '.$filas.'<br>';
			
			if($filas == 0)
			{
				$queryins="INSERT INTO cot_fletes_aereo_tmp (idtipo_aereo, idtarifario_aereo, idcot_temp, venta, condiciones, security, mz, fuel) VALUES('$id', '$idtarifario_aereo', '$_POST[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$security', '$mz', '$fuel')";
			}
			elseif($filas > 0)
			{
				$queryins="update cot_fletes_aereo_tmp set venta='$venta', condiciones='$_POST[condiciones_flete]', security='$security', mz='$mz', fuel='$fuel' where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_POST[idcot_temp]'";
			}
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
			$n++;
		}
	}		 
}
if(isset($sel100))
{
	$n = 0;
	foreach($sel100 as $id)
	{
		if($id!='')
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $lista_venta100[$n];
			$security = $lista_security100[$n];
			$mz = $lista_mz100[$n];
			$fuel = $lista_fuel100[$n];
			
			$sql = "select idcot_temp from  cot_fletes_aereo_tmp where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_POST[idcot_temp]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$filas = mysqli_num_rows($exe);
			
			if($filas == 0)
			{
				$queryins="INSERT INTO cot_fletes_aereo_tmp (idtipo_aereo, idtarifario_aereo, idcot_temp, venta, condiciones, security, mz, fuel) VALUES('$id', '$idtarifario_aereo', '$_POST[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$security', '$mz', '$fuel')";
			}
			elseif($filas > 0)
			{
				$queryins="update cot_fletes_aereo_tmp set venta='$venta', condiciones='$_POST[condiciones_flete]', security='$security', mz='$mz', fuel='$fuel' where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_POST[idcot_temp]'";
			}
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
			$n++;
		}
	}		 
}
if(isset($sel300))
{
	$n = 0;
	foreach($sel300 as $id)
	{
		if($id!='')
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $lista_venta300[$n];
			$security = $lista_security300[$n];
			$mz = $lista_mz300[$n];
			$fuel = $lista_fuel300[$n];
				
			$sql = "select idcot_temp from  cot_fletes_aereo_tmp where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_POST[idcot_temp]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$filas = mysqli_num_rows($exe);
			
			if($filas == 0)
			{
				$queryins="INSERT INTO cot_fletes_aereo_tmp (idtipo_aereo, idtarifario_aereo, idcot_temp, venta, condiciones, security, mz, fuel) VALUES('$id', '$idtarifario_aereo', '$_POST[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$security', '$mz', '$fuel')";
			}
			elseif($filas > 0)
			{
				$queryins="update cot_fletes_aereo_tmp set venta='$venta', condiciones='$_POST[condiciones_flete]', security='$security', mz='$mz', fuel='$fuel' where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_POST[idcot_temp]'";
			}
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
			$n++;
		}
	}		 
}
if(isset($sel500))
{
	$n = 0;
	foreach($sel500 as $id)
	{
		if($id!='')
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $lista_venta500[$n];
			$security = $lista_security500[$n];
			$mz = $lista_mz500[$n];
			$fuel = $lista_fuel500[$n];
				
			$sql = "select idcot_temp from  cot_fletes_aereo_tmp where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_POST[idcot_temp]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$filas = mysqli_num_rows($exe);
			
			if($filas == 0)
			{
				$queryins="INSERT INTO cot_fletes_aereo_tmp (idtipo_aereo, idtarifario_aereo, idcot_temp, venta, condiciones, security, mz, fuel) VALUES('$id', '$idtarifario_aereo', '$_POST[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$security', '$mz', '$fuel')";
			}
			elseif($filas > 0)
			{
				$queryins="update cot_fletes_aereo_tmp set venta='$venta', condiciones='$_POST[condiciones_flete]', security='$security', mz='$mz', fuel='$fuel' where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_POST[idcot_temp]'";
			}
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
			$n++;
		}
	}		 
}
if(isset($sel1000))
{
	$n = 0;
	foreach($sel1000 as $id)
	{
		if($id!='')
		{
			$idtarifario_aereo = scai_get_name("$id","tipo_aereo", "idtipo_aereo", "idtarifario_aereo");
			$venta = $lista_venta1000[$n];
			$security = $lista_security1000[$n];
			$mz = $lista_mz1000[$n];
			$fuel = $lista_fuel1000[$n];
			
			$sql = "select idcot_temp from cot_fletes_aereo_tmp where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_POST[idcot_temp]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$filas = mysqli_num_rows($exe);
			
			if($filas == 0)
			{
				$queryins="INSERT INTO cot_fletes_aereo_tmp (idtipo_aereo, idtarifario_aereo, idcot_temp, venta, condiciones, security, mz, fuel) VALUES('$id', '$idtarifario_aereo', '$_POST[idcot_temp]', '$venta', '$_POST[condiciones_flete]', '$security', '$mz', '$fuel')";
			}
			elseif($filas > 0)
			{
				$queryins="update cot_fletes_aereo_tmp set venta='$venta', condiciones='$_POST[condiciones_flete]', security='$security', mz='$mz', fuel='$fuel' where idtipo_aereo='$id' and idtarifario_aereo='$idtarifario_aereo' and idcot_temp='$_POST[idcot_temp]'";
			}
			//print $queryins.'<br>';
			$buscarins=mysqli_query($link,$queryins);
			$n++;
		}
	}		 
}
?>