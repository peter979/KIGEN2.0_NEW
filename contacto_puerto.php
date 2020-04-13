<?
	include('sesion/sesion.php');
	include("conection/conectar.php");	
	include("scripts/recover_nombre.php");	
	include_once("permite.php");

	$tabla = "contactos_puerto";
	$llave = "idcontacto_puerto";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/admin_internas.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="js/funcionesValida.js"></script>


<?
//Editar
if ($_GET['accion']=="editar"){
	$idcontacto_puerto=$_POST['idcontacto_puerto'];
	$nombre=$_POST['nombre'];
	$alias=$_POST['alias'];
	$telefonos=$_POST['telefonos'];
	$email_empresarial=$_POST['email_empresarial'];
	
	
	$update="UPDATE contactos_puerto SET 
		alias='$alias',
		nombre = '$nombre',
		telefonos = '$telefonos',
		email_empresarial = '$email_empresarial'
		WHERE idcontacto_puerto =$idcontacto_puerto";

	if($exe_update=mysqli_query($link,$update)){
		echo "<script>alert('El registro se Edito correctamente');</script>";
	}else{
		echo "<script>alert('El registro no se pudo editar, contacte al administrador');</script>";
	}

}
/*if ($_GET['accion']=="nuevo"){
	$idcontacto_puerto=$_POST['idcontacto_puerto'];
	$nombre=$_POST['nombre'];
	$alias=$_POST['alias'];
	$telefonos=$_POST['telefonos'];
	$email_empresarial=$_POST['email_empresarial'];
	
	
	$update="INSERT INTO $tabla SET 
		alias='$alias',
		nombre = '$nombre',
		telefonos = '$telefonos',
		email_empresarial = '$email_empresarial'
		WHERE idcontacto_puerto =$idcontacto_puerto";

	if($exe_update=mysqli_query($link,$update)){
		echo "<script>alert('El contacto se creo correctamente');</script>";
	}else{
		echo "<script>alert('El registro no se pudo crear');</script>";
	}
}*/
if ($_GET['accion']=="nuevo"){
	$idcontacto_puerto=$_POST['idcontacto_puerto'];
	$nombre=$_POST['nombre'];
	$idciudad=$_POST['idciudad'];
	$alias=$_POST['alias'];
	$telefonos=$_POST['telefonos'];
	$email_empresarial=$_POST['email_empresarial'];
	
	
	$update="INSERT INTO $tabla (
					nombre, 
					idciudad,
					alias,
					telefonos,
					email_empresarial 
				) VALUES(
					UCASE('$_POST[nombre]'), 
					UCASE('$_POST[idciudad]'),
					UCASE('$_POST[alias]'),
					UCASE('$_POST[telefonos]'),
					'$_POST[email_empresarial]'
				)";

	if($exe_update=mysqli_query($link,$update)){
		echo "<script>alert('El contacto se creo correctamente');</script>";
	}else{
		echo "<script>alert('El contacto no se pudo crear, contacte al administrador');</script>";
	}

	
}
//VARIABLE PARA ELIMINAR ESTA ACTIVA 
if($_POST['accion']=="eliminar"){
		$queryelim="DELETE FROM $tabla WHERE $llave IN ($_POST '')";
		$buscarelim=mysqli_query($link,$queryelim);
		if(!$buscarelim) print mysqli_error();
		//include("upd_usuarios.php");
		
}

?>
</head>

<body style="background-color: transparent;">
<h3 align="center">Contactos de Puerto</h3>
<form name="consulta" method="post" action="">

<? $sql_con="select * from contactos_puerto";
	$exe_con=mysqli_query($link,$sql_con);
?>
<table border="1" align="center">
    <tr class="tittabla">
<!---            <td height="20"><a href="javascript: void(0)" onClick="nuevoRegistro()" onMouseOver="MM_swapImage('Image2','','images/bot_nuevo2.jpg',1)" onMouseOut="MM_swapImgRestore()">Nuevo</a></td>   --> </tr>
	<tr class="tittabla">
    	<td>Alias</td>
    	<td>Ciudad</td>
	 	<td>Nombre</td>
	 	<td>Telefonos</td>
	 	<td>EMAIL</td>
	 	<td>Editar</td>

    </tr>
	<? while($result_con=mysqli_fetch_array($exe_con)){?>
   	<tr class="contenidotab">
    	<td><? echo $result_con['alias'];?></td>
    	<td><? echo scai_get_name($result_con['idciudad'], "ciudades", "idciudad", "nombre");?></td>
    	<td><? echo $result_con['nombre'];?></td>
    	<td><? echo $result_con['telefonos'];?></td>
    	<td><? echo $result_con['email_empresarial'];?></td>
    	<td class="botonesadmin"><a href="?idcontacto_puerto=<? echo $result_con['idcontacto_puerto']?>">Editar</a></td>
    </tr>
    <? }?>
</table>
</form>


<? //Modulo para la edicion de registros
if($_GET['idcontacto_puerto']!=""){
?>
<form name="editar" method="post" action="?accion=editar">
<input type="hidden" name="idcontacto_puerto" value="<? echo $_GET['idcontacto_puerto']; ?>" >

<? $sql_con1="select * from contactos_puerto where idcontacto_puerto=".$_GET['idcontacto_puerto'];
	$exe_con1=mysqli_query($link,$sql_con1);
	$result_con1=mysqli_fetch_array($exe_con1);
?>
	<table class="contenidotab" align="center">
    	<tr>
        	<td class="tittabla">Alias</td>
	    	<td><input type="text" name="alias" value="<? echo $result_con1['alias'];?>" class="tex7"></td>
        </tr>
    	<tr>
        	<td class="tittabla">Ciudad</td>
	    	<td><? echo scai_get_name($result_con1['idciudad'], "ciudades", "idciudad", "nombre");?></td>
        </tr>
    	<tr>
        	<td class="tittabla">Nombre</td>
	    	<td><input type="text" name="nombre" value="<? echo $result_con1['nombre'];?>" class="tex7"></td>
        </tr>
    	<tr>
        	<td class="tittabla">Telefonos</td>
	    	<td><input type="text" name="telefonos" value="<? echo $result_con1['telefonos'];?>" class="tex7"></td>
        </tr>
    	<tr>
        	<td class="tittabla">EMAIL</td>
	    	<td><input type="text" name="email_empresarial" value="<? echo $result_con1['email_empresarial'];?>" class="tex7"></td>
        </tr>
        <tr>
        	<td colspan="2" align="center"> <a href="javascript:document.editar.submit()"><strong class="botonesadmin">Guardar</strong></a></td>
        </tr>

    </table>
</form>
<? }?>


<form name="nuevo" method="post" action="?accion=nuevo">
<input type="hidden" name="idcontacto_puerto">
	<table class="contenidotab" align="center">
    	<tr>
        	<td class="tittabla">Alias</td>
	    	<td><input type="insert" name="alias" value="<? echo $result_con1['alias'];?>" class="tex7"></td>
        </tr>
    	<tr>
        	<td class="tittabla">Ciudad</td>
<!--	    	<td><? echo scai_get_name($result_con1['idciudad'], "ciudades", "idciudad", "nombre");?></td>-->
	    							<td width="63%" align="left">
							<select name="idciudad" class="tex7">
								<option value="N"> Seleccione </option>
								<option value="136" <?php if($result_con1=='136') echo "selected";?> >BUENAVENTURA</option>
								<option value="137" <?php if($result_con1=='137') echo "selected";?> >CARTAGENA</option>
								<option value="191" <?php if($result_con1=='191') echo "selected";?> >BARRANQUILLA</option>
								<option value="491" <?php if($result_con1=='491') echo "selected";?> >SANTA MARTA</option>						</select>						</td>
        </tr>
    	<tr>
        	<td class="tittabla">Nombre</td>
	    	<td><input type="insert" name="nombre" value="<? echo $result_con1['nombre'];?>" class="tex7"></td>
        </tr>
    	<tr>
        	<td class="tittabla">Telefonos</td>
	    	<td><input type="insert" name="telefonos" value="<? echo $result_con1['telefonos'];?>" class="tex7"></td>
        </tr>
    	<tr>
        	<td class="tittabla">EMAIL</td>
	    	<td><input type="insert" name="email_empresarial" value="<? echo $result_con1['email_empresarial'];?>" class="tex7"></td>
        </tr>
        <tr>
        	<td colspan="2" align="center"> <a href="javascript:document.nuevo.submit(0)"><strong class="botonesadmin">Guardar</strong></a></td>
        </tr>

    </table>
</form>


</body>
</html>
