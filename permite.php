<?
function puedo($permiso,$modulo)
{
	//include_once('sesion/sesion.php');
	include("conection/conectar.php");
	
	if($permiso == "l")
	{
		$sql="select * from modulos where modulos.cc='$_SESSION[perfil]' and id_mod='$modulo'";
		//print $sql.'<br>';
		$exe=mysqli_query($link,$sql);
		$num=mysqli_num_rows($exe);
		if ($num == 0)
			return 0;
		elseif($num > 0)
			return 1;		
	} 
	else
	{
		//ejemplo: select c from modulos where cc='1' and id_mod='Clientes/Proveedores'
		$sql="select $permiso from modulos where modulos.cc='$_SESSION[perfil]' and id_mod='$modulo'";
		//print $sql.'<br>';
		$exe=mysqli_query($link,$sql);
		$aja=mysqli_fetch_array($exe);
		return $aja["$permiso"];
	}
}
?>