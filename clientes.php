<?
	include('sesion/sesion.php');
	include("conection/conectar.php");
	include_once("permite.php");
	include_once("scripts/recover_nombre.php");
	require("phpmailer/class.phpmailer.php");
	include("phpmailer/class.smtp.php");

	$llave = "idcliente";
?>

<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/main.js"></script>
<script type="text/javascript" src="./js/shadowbox-base.js"></script>
<script type="text/javascript" src="./js/shadowbox.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.1.pack.js" ></script>
<script type="text/javascript" src="./js/jquery-1.8.3.js" ></script>




<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="css/admin_internas.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="./js/funciones.js"></script>
	<script type="text/javascript" src="./js/funcionesValida.js"></script>


	<!--FUNCION DE MOSTRAR RESULTADOS MIENTRAS SE ESCRIBE, PARA TEXT RAZON SOCIAL-->
	<? include("scripts/prepare_clients_list.php");?>
	<script type="text/javascript" src="js/clients_list.js"></script>
	<?php include('scripts/scripts.php'); ?>
	<script language="javascript">
	var x;
	x=$(document);
	x.ready(inicializarEventos);

	function inicializarEventos(){
		$(".numerico").keydown(numerico);//Valida campos numericos
	}

	function numerico(e) {
		//Permite unicamente campos numericos

	  if ((e.keyCode < 48 || e.keyCode > 57  ) && e.keyCode != 8){
		  e.preventDefault();
	  }
	}

	function validaEnvia(form)
	{//SE DESAHABILITA VALIDAR EL TIPO PARA CUANDO CREAN EL USUARIO FernandoCo
		//if(form.tipo.value!='potencial')
		{
			if (validarTexto('nit', 'Por favor ingrese el NIT') == false) return false;
		}

		form.datosok.value="si";
		form.submit()
	}

	function validaBuscar(form)
	{
		if (form.nombre.value == "")
		{
			alert('Digite la razon social');
			form.nombre.focus();
			return false;
		}

		form.xyz.value = form.nombre.value;
		form.submit();
	}

	function eliminaActual(form)
	{
		alert("Va a eliminar este cliente de la base de datos.");
		var conf = confirm("Esta operacion no se puede revetir, ¿Desea eliminar el cliente de la base de datos?");
		if(conf == true){
			form.varelimi.value="si";
			form.submit()
		}else
			return false;

	}

	function validaPais(form)
	{
		form.submit()
	}

	function borrar(form)
	{
		document.location.href = 'clientes.php';
	}

	function ShowDiv(capa){
		var id = capa.split(",");


		for (var x=0;x<id.length;x++){
			var div = document.getElementById(id[x]);

			if(div.style.display == "none")
				div.style.display = "block"
			else
				div.style.display = "none"
		}
		//document.location.href = 'clientes.php';

	}
	function showEl(elemento){
		$(elemento).show("fast");
	}

	function calculaTotal(form)
	{
		form.nueRegistro.value = 'si';
		form.submit()
	}

	function limpiar(tipo, cad_rg, idnaviera)
	{
		//alert('tipo ' + tipo + ' cad_rg ' + cad_rg + ' idnaviera ' + idnaviera);
		var idrgs = cad_rg.split(',');
		for(var i =0; i < idrgs.length; i++)
		{
			var limpia_checks = 'document.formulario.recargo'+idrgs[i]+'.checked=false';
			//alert (limpia_checks);
			eval(limpia_checks);
		}
		if(tipo == 'cont')
		{
			var campo_gasto = 'valor_gastos_cont';
		}
		if(tipo == 'hbl')
		{
			var campo_gasto = 'valor_gastos_hbl';
		}
		if(tipo == 'wm')
		{
			var campo_gasto = 'valor_gastos_wm';
		}
		if(tipo == 'hawb')
		{
			var campo_gasto = 'valor_gastos_hawb';
		}
		if(tipo == 'embarque')
		{
			var campo_gasto = 'valor_gastos_embarque';
		}
		var limpia_suma = "document.formulario."+campo_gasto+idnaviera+".value = '0'";
		//alert(limpia_suma);
		eval(limpia_suma);
	}

	function addi(a,b,c,d,e)
	{
		var variablevar = 'val=document.formulario.valor_venta'+a+'.value';
		eval(variablevar);

		if(e == 'lcl')
		{
			var variablemin = 'mini=document.formulario.minimo_venta'+a+'.value';
			eval (variablemin);
		}

		var contr='document.formulario.'+b+'.checked';
		if(c == 'cont')
		{
			var campo_gasto = 'valor_gastos_cont';
		}
		if(c == 'hbl')
		{
			var campo_gasto = 'valor_gastos_hbl';
		}
		if(c == 'wm')
		{
			var campo_gasto = 'valor_gastos_wm';
		}
		if(c == 'hawb')
		{
			var campo_gasto = 'valor_gastos_hawb';
		}
		if(c == 'embarque')
		{
			var campo_gasto = 'valor_gastos_embarque';
		}

		var si = "document.formulario."+campo_gasto+d+".value == ''";
		var entonces = "document.formulario."+campo_gasto+d+".value = '0'";
		var asignacion = "var digi=parseInt(document.formulario."+campo_gasto+d+".value)";

		if(eval(si)==true)
		{
			eval(entonces);
		}
		eval(asignacion);

		if(e == 'lcl')
		{
			var si_min = "document.formulario."+campo_gasto+'_min'+d+".value == ''";
			var entonces_min = "document.formulario."+campo_gasto+'_min'+d+".value = '0'";
			var asignacion_min = "var digi_min=parseInt(document.formulario."+campo_gasto+'_min'+d+".value)";

			if(eval(si_min)==true)
			{
				eval(entonces_min);
			}
			eval(asignacion_min);

			var si_min5 = "document.formulario."+campo_gasto+'_min5'+d+".value == ''";
			var entonces_min5 = "document.formulario."+campo_gasto+'_min5'+d+".value = '0'";
			var asignacion_min5 = "var digi_min5=parseInt(document.formulario."+campo_gasto+'_min5'+d+".value)";

			if(eval(si_min5)==true)
			{
				eval(entonces_min5);
			}
			eval(asignacion_min5);

			var si_min10 = "document.formulario."+campo_gasto+'_min10'+d+".value == ''";
			var entonces_min10 = "document.formulario."+campo_gasto+'_min10'+d+".value = '0'";
			var asignacion_min10 = "var digi_min10=parseInt(document.formulario."+campo_gasto+'_min10'+d+".value)";

			if(eval(si_min10)==true)
			{
				eval(entonces_min10);
			}
			eval(asignacion_min10);

			var si_min15 = "document.formulario."+campo_gasto+'_min15'+d+".value == ''";
			var entonces_min15 = "document.formulario."+campo_gasto+'_min15'+d+".value = '0'";
			var asignacion_min15 = "var digi_min15=parseInt(document.formulario."+campo_gasto+'_min15'+d+".value)";

			if(eval(si_min15)==true)
			{
				eval(entonces_min15);
			}
			eval(asignacion_min15);
		}

		if(eval(contr)==true)
		{
			var adicion = 'document.formulario.'+campo_gasto+d+'.value=(parseInt(digi)+parseInt(val))';

			if(e == 'lcl')
			{
				var adicion_min = 'document.formulario.'+campo_gasto+'_min'+d+'.value=(parseInt(digi_min)+parseInt(mini))';
				var adicion_min5 = 'document.formulario.'+campo_gasto+'_min5'+d+'.value=(parseInt(digi_min5)+(parseInt(val)*5))';
				var adicion_min10 = 'document.formulario.'+campo_gasto+'_min10'+d+'.value=(parseInt(digi_min10)+(parseInt(val)*10))';
				var adicion_min15 = 'document.formulario.'+campo_gasto+'_min15'+d+'.value=(parseInt(digi_min15)+(parseInt(val)*15))';
			}
		}
		else
		{
			var adicion = 'document.formulario.'+campo_gasto+d+'.value=(parseInt(digi)-parseInt(val))';

			if(e == 'lcl')
			{
				var adicion_min = 'document.formulario.'+campo_gasto+'_min'+d+'.value=(parseInt(digi_min)-parseInt(mini))';
				var adicion_min5 = 'document.formulario.'+campo_gasto+'_min5'+d+'.value=(parseInt(digi_min5)-(parseInt(val)*5))';
				var adicion_min10 = 'document.formulario.'+campo_gasto+'_min10'+d+'.value=(parseInt(digi_min10)-(parseInt(val)*10))';
				var adicion_min15 = 'document.formulario.'+campo_gasto+'_min15'+d+'.value=(parseInt(digi_min15)-(parseInt(val)*15))';
			}
		}

		eval(adicion);

		if(e == 'lcl')
		{
			eval(adicion_min);
			eval(adicion_min5);
			eval(adicion_min10);
			eval(adicion_min15);
		}

	}

	function AddRow(elemento){
		var div = $(elemento);

		if(div.css("display") == "none")
			div.show();
		else
			div.hide();

	}
	</script>
</head>

<?

if($_POST['datosok']=='si'){
	if($_POST['idcliente'] == ''){
		$queryins="INSERT INTO clientes (
						idoperativo,
						idvendedor,
						idcustomer,
						idciudad,
						nombre,
						tipo,
						nit,
						direccion,
						telefonos,
						fax,
						email_empresarial,
						fecha_creacion,
						observaciones,
						usuario,
						pass
					) VALUES(
						UCASE('$_POST[idoperativo]'),
						UCASE('$_POST[idvendedor]'),
						UCASE('$_POST[idcustomer]'),
						'$_POST[idciudad]',
						UCASE('$_POST[nombre]'),
						'$_POST[tipo]',
						'$_POST[nit]',
						UCASE('$_POST[direccion]'),
						UCASE('$_POST[telefonos]'),
						UCASE('$_POST[fax]'),
						'$_POST[email_empresarial]',
						NOW(),
						UCASE('$_POST[observaciones]'),
						'$_POST[email_empresarial]',
						'$_POST[pass]'
					)";

		$buscarins_ppal=mysqli_query($link,$queryins);

		$sqlast = "SELECT LAST_INSERT_ID() ultimo FROM clientes";
		$querylast = mysqli_query($link,$sqlast);
		$row = mysqli_fetch_array($querylast);
		$idcliente = $row['ultimo'];
/*TEST para que no guarde con mismo nit o nombre
		if($buscarins_ppal=$_POST['nit']){
			print ("<script>alert('NIT existe')</script>");
		}*/




		if($buscarins_ppal){
			$sqlcond = "INSERT INTO condiciones_generales (
							idcliente,
							credito,
							cupo_max,
							liberacion_auto,
							regimen,
							retefuente,
							reteica,
							fecha_max_facturacion,
							dias_credito,
							observaciones
						) VALUES(
							'$idcliente',
							UCASE('$_POST[credito]'),
							UCASE('$_POST[cupo_max]'),
							'$_POST[liberacion_auto]',
							'$_POST[regimen]',
							UCASE('$_POST[retefuente]'),
							UCASE('$_POST[reteica]'),
							'$_POST[fecha_max_facturacion]',
							'$_POST[dias_credito]',
							UCASE('$_POST[observaciones_cond]')
						)";
			$execond = mysqli_query($link,$sqlcond);




			/*
			if (isset($_POST['docs'])){
				foreach($_POST['docs'] as $id){
					$fecha_vencimiento = $_POST['fecha_vencimiento'.$id];
					$fecha_recibo = $_POST['fecha_recibo'.$id];
					$sql="INSERT INTO clientes_has_documentos (
								idcliente,
								iddocumento,
								fecha_vencimiento,
								fecha_recibo
						  ) VALUES(
						  		'$idcliente',
								'$id',
								'$fecha_vencimiento',
								'$fecha_recibo'
							)";
					$exe= mysqli_query($sql,$link);
				}
			}*/

			//Ingreso de recargos---
			for($k=0; $k < 3; $k++)
			{
				if($k == 0)
					$clasif = 'fcl';
				if($k == 1)
					$clasif = 'lcl';
				if($k == 2)
					$clasif = 'aereo';

				$sqlct = "select * from cliente_local where idcliente='$idcliente' and clasificacion='$clasif'";
				//print $sqlct.'<br>';
				$exect = mysqli_query($link,$sqlct);
				$filasct = mysqli_num_rows($exect);

				$collection_fee = $_POST['collection_fee'.$clasif];
				$min_collection_fee = $_POST['min_collection_fee'.$clasif];
				$caf = $_POST['caf'.$clasif];
				$min_caf = $_POST['min_caf'.$clasif];
				$nombre_gastos_hbl = $_POST['nombre_gastos_hbl'.$clasif];
				$nombre_gastos_cont = $_POST['nombre_gastos_cont'.$clasif];
				$nombre_gastos_wm = $_POST['nombre_gastos_wm'.$clasif];
				$nombre_gastos_hawb = $_POST['nombre_gastos_hawb'.$clasif];
				$nombre_gastos_embarque = $_POST['nombre_gastos_embarque'.$clasif];
				$nombre_gastos_kilo = $_POST['nombre_gastos_kilo'.$clasif];
				$observaciones = $_POST['observaciones'.$clasif];

				if($filasct == 0)
					$queryins="INSERT INTO cliente_local (idcliente, clasificacion, collection_fee, min_collection_fee, caf, min_caf, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, nombre_gastos_hawb, nombre_gastos_embarque, nombre_gastos_kilo, observaciones) VALUES ('$idcliente', '$clasif', '$collection_fee', '$min_collection_fee', '$caf', '$min_caf', UCASE('$nombre_gastos_hbl'), UCASE('$nombre_gastos_cont'), UCASE('$nombre_gastos_wm'), UCASE('$nombre_gastos_hawb'), UCASE('$nombre_gastos_embarque'), UCASE('$nombre_gastos_kilo'), UCASE('$observaciones'))";
				else
					$queryins = "UPDATE cliente_local SET collection_fee='$collection_fee', min_collection_fee='$min_collection_fee', caf='$caf', min_caf='$min_caf', nombre_gastos_hbl=UCASE('$nombre_gastos_hbl'), nombre_gastos_cont=UCASE('$nombre_gastos_cont'), nombre_gastos_wm=UCASE('$nombre_gastos_wm'), nombre_gastos_hawb=UCASE('$nombre_gastos_hawb'), nombre_gastos_embarque=UCASE('$nombre_gastos_embarque'), nombre_gastos_kilo=UCASE('$nombre_gastos_kilo'), observaciones=UCASE('$observaciones') WHERE idcliente='$idcliente' and clasificacion='$clasif'";
				//print $queryins.'<br>';
				$buscarins=mysqli_query($link,$queryins);
			}
		}
		//---
		if(!$buscarins_ppal){
			print ("<script>alert('No se pudo ingresar el registro')</script>");
		}else
		{
			print "<script>alert ('El registro ha sido ingresado satisfactoriamente')</script>";
		}
	}elseif($_POST['idcliente'] != ''){
		$Observaciones =  str_replace("\"","'",$_POST["observaciones"]);
		$queryins="UPDATE clientes SET
						idoperativo=UCASE('$_POST[idoperativo]'),
						idvendedor=UCASE('$_POST[idvendedor]'),
						idcustomer=UCASE('$_POST[idcustomer]'),
						idciudad='$_POST[idciudad]',
						nombre=UCASE('$_POST[nombre]'),
						tipo='$_POST[tipo]',
						nit='$_POST[nit]',
						direccion=UCASE('$_POST[direccion]'),
						telefonos=UCASE('$_POST[telefonos]'),
						fax=UCASE('$_POST[fax]'),
						email_empresarial='$_POST[email_empresarial]',
						observaciones=UCASE(\"$Observaciones\"),
						usuario='$_POST[email_empresarial]',
						pass='$_POST[pass]'
					WHERE $llave='$_POST[idcliente]'";
		//print $queryins;
		$buscarins_ppal=mysqli_query($link,$queryins);

		if($buscarins_ppal)
		{
			$sqlcond = "select * from condiciones_generales WHERE idcliente='$_POST[idcliente]'";

			$execond = mysqli_query($link,$sqlcond);
			$filascond = mysqli_num_rows($execond);

			if($filascond!=0)
			{
				$sqlcond = "UPDATE condiciones_generales SET
								credito=UCASE('$_POST[credito]'),
								cupo_max=UCASE('$_POST[cupo_max]'),
								liberacion_auto='$_POST[liberacion_auto]',
								regimen='$_POST[regimen]',
								retefuente=UCASE('$_POST[retefuente]'),
								reteica=UCASE('$_POST[reteica]'),
								fecha_max_facturacion='$_POST[fecha_max_facturacion]',
								dias_credito='$_POST[dias_credito]',
								observaciones=UCASE('$_POST[observaciones_cond]')
							WHERE $llave='$_POST[idcliente]'";
				$execond = mysqli_query($link,$sqlcond);
			}
			else
			{
				$sqlcond = "INSERT INTO condiciones_generales (
									idcliente,
									credito,
									cupo_max,
									liberacion_auto,
									regimen,
									retefuente,
									reteica,
									fecha_max_facturacion,
									dias_credito,
									observaciones
								) VALUES(
									'$_POST[idcliente]',
									'$_POST[credito]',
									'$_POST[cupo_max]',
									'$_POST[liberacion_auto]',
									'$_POST[regimen]',
									UCASE('$_POST[retefuente]'),
									UCASE('$_POST[reteica]'),
									'$_POST[fecha_max_facturacion]',
									'$_POST[dias_credito]',
									UCASE('$_POST[observaciones_cond]')
								)";
				$execond = mysqli_query($link,$sqlcond);
			}

			//Documentos
			/*
			$sql= "delete from clientes_has_documentos where idcliente='$_POST[idcliente]'";
			$exe= mysqli_query($sql, $link);
			if (isset($_POST['docs']))
			{
				foreach($_POST['docs'] as $id)
				{
					$fecha_vencimiento = $_POST['fecha_vencimiento'.$id];
					$fecha_recibo = $_POST['fecha_recibo'.$id];
					//Carga el adjunto si existe
					if($_FILES["adjunto".$id]["tmp_name"]){
						$prefijo = date("ymdhis");
						$adjunto = "dc".$prefijo.$_FILES['adjunto'.$id]['name'];

						if(!move_uploaded_file($_FILES["adjunto".$id]["tmp_name"], "file/$adjunto")){
							echo "No almacenó el adjunto $adjunto";
						}
					}else{
						$adjunto = $_POST["adjunto".$id];
					}

					$sql="INSERT INTO clientes_has_documentos (
							idcliente,
							iddocumento,
							fecha_vencimiento,
							fecha_recibo,
							adjunto
						  ) VALUES(
						  	'$_POST[idcliente]',
							'$id',
							'$fecha_vencimiento',
							'$fecha_recibo',
							'$adjunto'
						  )";

					$exe= mysqli_query($sql,$link);
					if(!$exe)
						echo "no almacenó<br>".mysqli_error();
				}
			}*/



			$i=0;
			//Elimina los adjuntos existentes para reescribirlos
			mysqli_query($link,"delete from clientes_has_documentos where idcliente=".$_GET['idcliente']);
			//*******Carga los Documentos**************

			foreach($_POST['fecha_recibo'] as $documento){

				if($_FILES['adjunto']["name"][$i]){ //Si se realiza la carga de algun adjunto
					$prefijo = date("ymdhis");
					$adjunto = "dc".$prefijo.$_FILES['adjunto']["name"][$i];

				//	if(!move_uploaded_file($_FILES['adjunto']["tmp_name"][$i], "file/$adjunto")){
					if(!move_uploaded_file($_FILES['adjunto']["tmp_name"][$i], "doc/doc_clientes/$adjunto")){
						echo "No almacenó el adjunto $adjunto";
					}

				}else{
					$adjunto = $_POST['adjHidden'][$i];
				}
				$sqlNewDocHas = "INSERT INTO `clientes_has_documentos` (
									`idcliente`,
									`iddocumento`,
									`fecha_vencimiento`,
									`fecha_recibo`,
									`estado`,
									`adjunto`
								) VALUES (
									'".$_GET['idcliente']."',
									'".$_POST["idDoc"][$i]."',
									'".$_POST['fecha_vencimiento'][$i]."',
									'".$_POST['fecha_recibo'][$i]."',
									'1',
									'$adjunto'
								); ";
				if(!mysqli_query($link,$sqlNewDocHas)){
					echo "no guardo <br>".mysqli_error();die();
				}
				$i++;
			}

			//Nuevo documento
			if($_POST['documentoNombre']!= ""){ //si se crea un nuevo documento, lo agrega
				if($_POST['otroDocumento'] != ""){ //Si crea un nuevo tipo de documento
					$qryNewDoc = mysqli_query($link,"insert into documentos (nombre)values('".$_POST['otroDocumento']."')");
					$idDoc = mysqli_fetch_row(mysqli_query("SELECT max(iddocumento) from documentos"));
					$idDoc = $idDoc[0];
				}else //De lo conrtario toma el id del seleccionado
					$idDoc = $_POST['documentoNombre'];

				//Carga el documento
				$adjunto ="";
				if($_FILES["adjunto_nuevo"]["tmp_name"]){
					$prefijo = date("ymdhis");
					$adjunto = "dc".$prefijo.$_FILES["adjunto_nuevo"]['name'];

				//	if(!move_uploaded_file($_FILES["adjunto_nuevo"]["tmp_name"], "file/$adjunto")){
					if(!move_uploaded_file($_FILES["adjunto_nuevo"]["tmp_name"], "doc/doc_clientes/$adjunto")){
						echo "No almacenó el adjunto $adjunto";
					}
				}

				$sqlNewDocHas = "INSERT INTO `clientes_has_documentos` (
									`idcliente`,
									`iddocumento`,
									`fecha_vencimiento`,
									`fecha_recibo`,
									`estado`,
									`adjunto`
								) VALUES (
									'".$_GET['idcliente']."',
									'$idDoc',
									'".$_POST['fecha_vencimiento_nuevo']."',
									'".$_POST['fecha_recibo_nuevo']."',
									'1',
									'$adjunto'
								); ";

				if(!mysqli_query($link,$sqlNewDocHas)){
					$documento = scai_get_name($_POST["documentoNombre"],"documentos","iddocumento","nombre").$_POST["documentoNombre"];
					echo "<script>alert('el documento $documento ya existe');window.location='clientes.php?idcliente=".$_GET['idcliente']."'</script>";
				}


			}

			//Ingreso de recargos---
			for($k=0; $k < 3; $k++)
			{
				if($k == 0)
					$clasif = 'fcl';
				if($k == 1)
					$clasif = 'lcl';
				if($k == 2)
					$clasif = 'aereo';

				$sqlct = "select * from cliente_local where idcliente='$_POST[idcliente]' and clasificacion='$clasif'";
				//print $sqlct.'<br>';
				$exect = mysqli_query($link,$sqlct);
				$filasct = mysqli_num_rows($exect);

				$collection_fee = $_POST['collection_fee'.$clasif];
				$min_collection_fee = $_POST['min_collection_fee'.$clasif];
				$caf = $_POST['caf'.$clasif];
				$min_caf = $_POST['min_caf'.$clasif];
				$nombre_gastos_hbl = $_POST['nombre_gastos_hbl'.$clasif];
				$nombre_gastos_cont = $_POST['nombre_gastos_cont'.$clasif];
				$nombre_gastos_wm = $_POST['nombre_gastos_wm'.$clasif];
				$nombre_gastos_hawb = $_POST['nombre_gastos_hawb'.$clasif];
				$nombre_gastos_embarque = $_POST['nombre_gastos_embarque'.$clasif];
				$nombre_gastos_kilo = $_POST['nombre_gastos_kilo'.$clasif];
				$observaciones = $_POST['observaciones'.$clasif];

				if($filasct == 0)
					$queryins="INSERT INTO cliente_local (idcliente, clasificacion, collection_fee, min_collection_fee, caf, min_caf, nombre_gastos_hbl, nombre_gastos_cont, nombre_gastos_wm, nombre_gastos_hawb, nombre_gastos_embarque, nombre_gastos_kilo, observaciones) VALUES ('$_POST[idcliente]', '$clasif', '$collection_fee', '$min_collection_fee', '$caf', '$min_caf', UCASE('$nombre_gastos_hbl'), UCASE('$nombre_gastos_cont'), UCASE('$nombre_gastos_wm'), UCASE('$nombre_gastos_hawb'), UCASE('$nombre_gastos_embarque'), UCASE('$nombre_gastos_kilo'), UCASE('$observaciones'))";
				else
					$queryins = "UPDATE cliente_local SET collection_fee='$collection_fee', min_collection_fee='$min_collection_fee', caf='$caf', min_caf='$min_caf', nombre_gastos_hbl=UCASE('$nombre_gastos_hbl'), nombre_gastos_cont=UCASE('$nombre_gastos_cont'), nombre_gastos_wm=UCASE('$nombre_gastos_wm'), nombre_gastos_hawb=UCASE('$nombre_gastos_hawb'), nombre_gastos_embarque=UCASE('$nombre_gastos_embarque'), nombre_gastos_kilo=UCASE('$nombre_gastos_kilo'), observaciones=UCASE('$observaciones') WHERE idcliente='$_POST[idcliente]' and clasificacion='$clasif'";
				//print $queryins.'<br>';
				$buscarins=mysqli_query($link,$queryins);


			}//end for

		}
		if(!$buscarins_ppal){
				echo mysqli_error()."<--<br><br>$queryins";
				die();
			print ("<script>alert('No se pudo modificar el registro')</script>");
		}else
			print "<script>alert ('El registro ha sido modificado satisfactoriamente')</script>"; ?>
		<script>
		  document.location.href='clientes.php?idcliente=<? if($_POST['idcliente']!='') print $_POST['idcliente']; else print $idcliente; ?>';
		</script><?
	}
}elseif($_POST['comentarioArea']){
	//Almacena los comentarios si existen
	$UdtVis = "update clientes set visitas =CONCAT('
					".date("Y-m-d H:i:s")." -::-
					".$_POST['comentarioArea']." -::-
					".$_POST['actividad']."
					-//-',visitas )
			where idcliente =".$_POST['idcliente'];
	if(!mysqli_query($link,$UdtVis))
		echo "No almacenó la Visita, Contacte al administrador<br>".mysqli_error() ;


	//Envia email Notificando A com3
//	$mail = new PHPMailer();


	$mail = new PHPMailer();


//	$mail->IsSMTP();
	$mail->Timeout=1200;//20 minutos

	//-----------------------------------------------------------------------
	$mail->SMTPAuth   = true; //enable SMTP authentication

	$mail->SMTPSecure = $secure;
	$mail->Host = $host_envios;
	$mail->Port = $port;
	$mail->Username = $email_envios;
	$mail->Password = $password_envios;
    $mail->isHTML(true);

	$mail->From = "$email_real";
	$mail->FromName = 'KIGEN'."\r\n";
	$mail->Sender = "$email_real";//return-path
	$mail->ConfirmReadingTo = "$email_real";


	$mail->CharSet = 'ISO-8859-1';

	//------------------------------------------------------------
	$mail->Subject = "Nuevo comentario de Visita de cliente";



	$msg ="
		<html>
		<head>
		<meta content='text/html; charset=ISO-8859-1'
http-equiv='content-type'>	
		<style type='text/css'>

		.tabla{
			font-family:Tahoma;
			font-size:10px;
			color:#333333;
		}
		</style>
		</head>


		<body>
			<p>
			<table align='left' width='100%' border='0' class='tabla' cellpadding='0' cellspacing='0'>
				<tr>
					<td align='left'>
						<img src='http://appkigen.co/demo/images/logo.png' border='0' width='198' height='60' />
					</td>
				</tr>

				<tr>
				  <td align='left' height='10'><br><br><br>Se ha realizado una visita al cliente <strong>".scai_get_name($_POST["idcliente"],"clientes","idcliente","nombre")."</strong> y se generaron los siguiente comentarios </td>
				</tr>
			</table>
			</p><br><br><br><br><br><br>
			<table id='tabla' class='contenidotab' cellpadding='5' align='center' width='70%'>

				<tr bgcolor='#a01313' style='color:#FFFFFF'>
					<td width='20%'><strong>FECHA</strong></td>
					<td><strong>OBSERVACION</strong></td>
				<!--<td>Notificado a:</td>-->

				</tr>";
				//Historico de Visitas
				$visitaSql = mysqli_query($link,"select visitas from clientes where idcliente = ".$_POST['idcliente']);
				$visitaExe = mysqli_fetch_array($visitaSql);

				$visitas = explode('-//-',$visitaExe['visitas']);
				foreach($visitas as $result){
					$columna = explode('-::-',$result);
                    $color = "";
                    $Actividad = trim($columna[2]);

					$msg .="
					<tr bgcolor='$color'>
						<td>".$columna[0]."</td>
						<td>".$columna[1]."</td>
					<!--<td>";
							if(trim($columna[2]) == "1")
								$msg .=  "Solicitud de Cotización";
							elseif(trim($columna[2]) == "2")
								 $msg .= "Queja o Reclamo";
							else
								$msg .= "&nbsp;";
						$msg .= "
						</td>-->
					</tr>";
                    break;
				}
				$msg .="
			  </table>



			 <table align='left' width='100%' border='0' class='tabla' cellpadding='0' cellspacing='0'>
				</tr><tr><td align='right' height='12'></td></tr>
				<tr><td align='justify'>Cordialmente</td></tr>
				<tr><td align='justify'>";

		if($idusuario = $_SESSION['numberid']);
        $sql_sign="select * from usuarios where idusuario='$idusuario'";
		$exe_sql_sign=mysqli_query($link,$sql_sign);
		$row_exe_sql_sign=mysqli_fetch_array($exe_sql_sign);
		
		$sql_sign2 = "select * from vendedores_customer where idusuario='$row_exe_sql_sign[idusuario]'";
		//print $sql_sign2.'<br>';
		$exe_sql_sign2=mysqli_query($link,$sql_sign2);
		$row_exe_sql_sign2=mysqli_fetch_array($exe_sql_sign2);


				$sql_sign2 = 'select * from vendedores_customer where idusuario='.$_SESSION['numberid']	;
				$exe_sql_sign2=mysqli_query($link,$sql_sign2);
				$row_exe_sql_sign2=mysqli_fetch_array($exe_sql_sign2);


				$msg .="
				<br><br>".$row_exe_sql_sign2["nombre"]."
				<strong><br>".scai_get_name($row_exe_sql_sign2["idcargo"],cargos,idcargo,nombre)."</strong>
				<br>Address: ".$row_exe_sql_sign2["direccion"]."
				<br>Phone: ".$row_exe_sql_sign2["telefono"]."
				<br>Movil: ".$row_exe_sql_sign2["celular"]."
				<br>E-mail: ".$row_exe_sql_sign2["email"]."


				</td></tr>
				</tr><tr><td align='right' height='12'></td></tr>

			</table>
			</table>
			<br>
		</body>
		</html>";
	$mail->Body = $msg;

	//Pone en copia a com3
	$email = explode(",",$_POST['actividad']);
	foreach($email as $e){
		$mail->AddAddress($e);
	}

	//pone en copia al comercial asignado al cliente
	$comercial = scai_get_name($_POST["idcliente"],"clientes","idcliente","idvendedor");
	$EmailCom = scai_get_name($comercial,"vendedores_customer","idvendedor_customer","email");
	$mail->AddAddress($EmailCom);


/*	if(trim($Actividad) == "1"){
		$mail->AddAddress("fern_a_ndocor_t_es92@hotmail.com");
	}elseif(trim($Actividad) == "2"){
		$mail->AddAddress("fern_a_ndocor_t_es92@hotmail.com");
	}*/


	if($mail->Send())
		echo "<script>alert('Email enviado satisfactoriamente');window.location='?idcliente=".$_POST['idcliente']."'</script>";
	else{
		echo $mail->ErrorInfo;
		echo "<script>alert('Error al enviar email, Contacte al administrador')</script>"; 
	}
}


if($_POST['varelimi']=='si')
{
	$queryelim="DELETE FROM clientes WHERE $llave='$_POST[idcliente]'";
	$buscarelim=mysqli_query($link,$queryelim);
	if(!$buscarelim)
		print mysqli_error();

	$sqlcond="DELETE FROM condiciones_generales WHERE idcliente='$_POST[idcliente]'";
	$execond==mysqli_query($link,$sqlcond);

	$sqldrec = "DELETE FROM recargos_local_cliente WHERE idcliente='$_POST[idcliente]'";
	$exedrec = mysqli_query($link,$sqldrec);

	?><script>document.location.href='<? print $_SERVER['PHP_SELF'];?>'</script><?
}

if (isset($_POST['idcliente']) && $_POST['idcliente']!='')
	$_GET['idcliente'] == $_POST['idcliente'];
?>

<body style="background-color: transparent;">
  <form name="formulario" method="post" enctype="multipart/form-data">
	<input name="datosok" type="hidden" value="no" />
	<input name="varelimi" type="hidden" value="no" />
	<input type="hidden" name="listaEliminar" value="" />
	<input name="idcliente" type="hidden" value="<? print $_GET['idcliente'] ?>" />
	<input name="xyz" type="hidden" value="" />
	<?
		if($_GET['idcliente'] != '')
		{
			$sqlad = "select * from clientes where $llave='$_GET[idcliente]'";
			$exead = mysqli_query($link,$sqlad);
			$datosad = mysqli_fetch_array($exead);

			$sqlad2 = "select * from condiciones_generales where idcliente='$_GET[idcliente]'";
			$exead2 = mysqli_query($link,$sqlad2);
			$datosad2 = mysqli_fetch_array($exead2);

			?><script>validaPais(document.getElementByName('formulario'));</script><?
		}
	if(isset($_GET['xyz']) and $_GET['xyz']!="")
		$_POST['xyz'] = $_GET['xyz'];
		if(isset($_POST['xyz']) and $_POST['xyz']!="")
		{
			$sql = "SELECT * FROM clientes WHERE nombre LIKE '%$_POST[xyz]%'";
			$query = mysqli_query($link,$sql);
			$filas = mysqli_num_rows($query);
			if ($filas == 0)
				print ("<script>alert('Este cliente no existe vuelva a intentarlo')</script>");
			else
			{
				if ($filas == 1)
				{
					$row = mysqli_fetch_array($query);
					print ("<script>document.location.href='".$_SERVER['PHP_SELF']."?idcliente=$row[idcliente]'</script>");
				}
				?>
				<table width="50%"align="center">
					<tr align="center">
						<td valign="top">
							<?
							$regxpag = 5;
							$totpag = ceil($filas / $regxpag);
							$pag = $_GET['pag'];
							if (!$pag)
								$pag = 1;
							else
							{
								if (is_numeric($pag) == false)
									$pag = 1;
							}
							$regini = ($pag - 1) * $regxpag;
							$sqlpag = $sql." LIMIT $regini, $regxpag";
							$buscarpag = mysqli_query($link,$sqlpag);
							while($row=mysqli_fetch_array($buscarpag))
							{
								print "<a href=".$_SERVER['PHP_SELF']."?idcliente=$row[idcliente]>$row[nombre]</a><br>";
							}
							?>
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td width="200" height="20" align="center" valign="middle">&nbsp;</td>
									<td height="20" align="center" valign="middle">
									<a href="javascript:void(0)" onClick="document.location='<? print $_SERVER['PHP_SELF']; ?>?pag=1&xyz=<? print $_POST['xyz']; ?>'">&lt;&lt;</a>
									</td>
									<td height="20" align="center" valign="middle">
										<? if ($pag != 1) { ?><a href="javascript:void(0)" onClick="document.location='<? print $_SERVER['PHP_SELF']; ?>?pag=<? print ($pag - 1); ?>&xyz=<? print $_POST['xyz']; ?>'"><? } ?>&lt;<? if ($pag != 1) { ?></a><? } ?>
									</td>
									<td height="20" align="center" valign="middle">
										<!--<a href="#">1-2-3-4</a>-->
										<select name="pag" onChange="document.location='<? print $_SERVER['PHP_SELF']; ?>?xyz=<? print $_POST['xyz']; ?>&pag=' + document.forms[0].pag.value;">
											<?
											for ($i=1; $i<=$totpag; $i++)
											{
												if ($i == $pag)
													print "<option value=$i selected>$i</option>";
												else
													print "<option value=$i>$i</option>";
											}
											?>
										</select>
									</td>
									<td height="20" align="center" valign="middle">
										<? if ($pag != $totpag) { ?><a href="javascript: void(0)" onClick="document.location='<? print $_SERVER['PHP_SELF']; ?>?pag=<? print ($pag + 1); ?>&xyz=<? print $_POST['xyz']; ?>'"><? } ?>&gt;<? if ($pag != $totpag) { ?></a><? } ?>
									</td>
									<td height="20" align="center" valign="middle">
										<a href="javascript: void(0)" onClick="document.location='<? print $_SERVER['PHP_SELF']; ?>?pag=<? print $totpag; ?>&xyz=<? print $_POST['xyz']; ?>'">&gt;&gt;</a>
									</td>
									<td width="200" height="20" align="center" valign="middle">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			<?
			}
		}

		?>

	<table border="0" width="100%" >
		<tr >
			<td class="subtitseccion" style="text-align:left" colspan="4">
				<a href="javascript:void(0);" class="subtitseccion" onClick="ShowDiv('capa10')"><? print strtoupper(clientes); ?> / CONT&Aacute;CTOS</a><br><br>
			</td>
		</tr>

		<tr>
			<td align="left" class="subtitseccion" colspan="4">
			  <div id="capa10" style="display:block">
				<table width="100%" align="center">
					<tr>
						<td class="contenidotab" colspan="2">RAZON SOCIAL:</td>
						<td colspan="2">
							<table width="60%">
								<tr>
									<td><input id="nombre" name="nombre" class="tex1" value="<? if($_POST['nombre']!='') print $_POST['nombre']; else print $datosad['nombre']; ?>" maxlength="50" onKeyUp="Complete(this, event)" size="40"></td>
									<td class="botonesadmin" ><a href="javascript:void(0)" onClick="validaBuscar(formulario);">Buscar</a>

									</td>
								<!--	<td class="botonesadmin"><a href="javascript: void(0)" onClick="borrar(formulario)" >Nuevo</a></td>-->
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="contenidotab" width="20%">NIT*</td>
						<td  width="30%"><input id="nit" name="nit" class="numerico" value="<? if($_POST['nit']!='') print $_POST['nit']; else print $datosad['nit']; ?>" maxlength="50" size="29"></td>
					  <td class="contenidotab" width="20%">TIPO*</td>
						
						
						
						
						
						
						
						<td width="30%"><? if($_SESSION['perfil']=='1') { //administrador ?>
							<select id="tipo" name="tipo" class="tex1" >
								<option value="N"> Seleccione </option>
								<option value="activo" <? if($_POST['tipo']!='') $comparador=$_POST['tipo']; else $comparador=$datosad['tipo']; if($comparador=='activo') print 'selected' ?>> ACTIVO</option>
								<option value="potencial" <? if($_POST['tipo']!='') $comparador=$_POST['tipo']; else $comparador=$datosad['tipo']; if($comparador=='potencial') print 'selected' ?>> POTENCIAL</option>
								<option value="descartado" <? echo ($datosad["tipo"] == "descartado") ? "selected='selected'" : "";?>> DESCARTADO</option><? } else print strtoupper($datosad['tipo']); ?>
							</select>

							</td>
					</tr>
					<tr>
						<td class="contenidotab">PAIS*</td>
						<td>
							<select id="idpais" name="idpais" class="tex1" onChange="validaPais(formulario);" >
								<option value="N"> Seleccione </option>
								<?
								$es="select * from paises order by nombre";
								$exe=mysqli_query($link,$es);
								if($_POST['idpais']!='')
									$comparador = $_POST['idpais'];
								else
								{
									$sqlp = "select idpais from ciudades where idciudad='$datosad[idciudad]'";
									$exep = mysqli_query($link,$sqlp);
									$datosp = mysqli_fetch_array($exep);
									$comparador = $datosp['idpais'];
								}
								while($row=mysqli_fetch_array($exe))
								{
									$sel = "";
									if($comparador == $row['idpais'])
										$sel = "selected";
									print "<option value='$row[idpais]' $sel>$row[nombre]</option>";
								}
								?>
							</select>
						</td>
						<? if($_POST['idpais']=='')
						{
							$sqlp = "select idpais from ciudades where idciudad='$datosad[idciudad]'";
							$exep = mysqli_query($link,$sqlp);
							$datosp = mysqli_fetch_array($exep);
							$_POST['idpais'] = $datosp['idpais'];
						}
						?>
						<td class="contenidotab">CIUDAD</td>
						<td>
							<select id="idciudad" name="idciudad" class="tex1" >
								<option value="N"> Seleccione </option>
								<?
								$es = "select * from ciudades where idpais='$_POST[idpais]' order by nombre";
								$exe=mysqli_query($link,$es);
								if($_POST['idciudad']!='N' && $_POST['idciudad']!='')
									$comparador = $_POST['idciudad'];
								else
									$comparador = $datosad['idciudad'];
								while($row=mysqli_fetch_array($exe))
								{
									$sel = "";
									if($comparador == $row['idciudad'])
										$sel = "selected";
									print "<option value='$row[idciudad]' $sel>$row[nombre]</option>";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="contenidotab">VENDEDOR</td>
						<td>
							<select id="idvendedor" name="idvendedor" class="tex1" >
								<option value="N"> Seleccione </option>
								<?
								if($_POST['idvendedor']!='N' && $_POST['idvendedor']!='')
									$idvendedor = $_POST['idvendedor'];
								else
								{
									$idvendedor = $datosad['idvendedor'];
								}

								//$es="select * from vendedores_customer where idcargo in (select idcargo from cargos where nombre='VENDEDOR' and idarea in (select idarea from areas where nombre='COMERCIAL')) order by nombre";
					$es = "select * from vendedores_customer order by nombre";
								$exe=mysqli_query($link,$es);
								while($row=mysqli_fetch_array($exe))
								{
									$sel = "";
									if($idvendedor==$row['idvendedor_customer'])//se cambio FernandoCo
										$sel = "selected";
									print "<option value='$row[idvendedor_customer]' $sel>$row[nombre]</option>";//se cambio FernandoCo
								}
								?>
							</select>
						</td>
						<td class="contenidotab">SERVICIO AL CLIENTE</td>
						<td>
							<select id="idcustomer" name="idcustomer" class="tex1"  >
								<option value="N"> Seleccione </option>
								<?
								if($_POST['idcustomer']!='N' && $_POST['idcustomer']!='')
									$idcustomer = $_POST['idcustomer'];
								else
								{
									$idcustomer = $datosad['idcustomer'];
								}

								$es = "select * from vendedores_customer order by nombre";
								$exe=mysqli_query($link,$es);
								while($row=mysqli_fetch_array($exe))
								{
									$sel = "";
								if($idcustomer==$row['idvendedor_customer'])
									$sel = "selected";
								print "<option value='$row[idvendedor_customer]' $sel>$row[nombre]</option>";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="contenidotab">DIRECCION</td>
						<td><input id="direccion" name="direccion" class="tex1" value="<? if($_POST['direccion']!='') print $_POST['direccion']; else print $datosad['direccion']; ?>" maxlength="100" size="40"></td>
						<td class="contenidotab">TELEFONOS</td>
						<td><input id="telefonos" name="telefonos" class="tex1" value="<? if($_POST['telefonos']!='') print $_POST['telefonos']; else print $datosad['telefonos']; ?>" maxlength="50" size="40"></td>
					</tr>
					<tr>
						<td class="contenidotab">EMAIL (login zona clientes)</td>
						<td><input id="email_empresarial" name="email_empresarial" class="tex1" value="<? if($_POST['email_empresarial']!='') print $_POST['email_empresarial']; else print $datosad['email_empresarial']; ?>" maxlength="50" size="40"></td>
						<td class="contenidotab">PASSWORD (login zona clientes)</td>
						<td><? if($_SESSION['perfil']=='1') { //administrador ?><input id="pass" name="pass" class="tex1" value="<? if($_POST['pass']!='') print $_POST['pass']; else print $datosad['pass']; ?>" maxlength="150" size="40"><? } else print "&nbsp;<span style='color:#f00;font-size:11px;'>Visible solo para perfil administrador</span>"; ?></td>
					</tr>
					<tr>
						<td class="contenidotab">FAX</td>
						<td><input id="fax" name="fax" class="tex1" value="<? if($_POST['fax']!='') print $_POST['fax']; else print $datosad['fax']; ?>" maxlength="50" size="40"></td>
						<td class="contenidotab">OPERATIVO</td>
						<td>
							<select id="idoperativo" name="idoperativo" class="tex1"  >
								<option value="N"> Seleccione </option>
								<?
								if($_POST['idoperativo']!='N' && $_POST['idoperativo']!='')
									$idoperativo = $_POST['idoperativo'];
								else
								{
									$idoperativo = $datosad['idoperativo'];
								}
								$es = "select * from vendedores_customer order by nombre";
								$exe=mysqli_query($link,$es);
								while($row=mysqli_fetch_array($exe))
								{
									$sel = "";
									if($idoperativo==$row['idvendedor_customer'])
										$sel = "selected";
									print "<option value='$row[idvendedor_customer]' $sel>$row[nombre]</option>";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="contenidotab" colspan="1" >OBSERVACIONES</td>
						<td colspan="3"><textarea name="observaciones" id="observaciones" class="tex1s"  cols="95" rows="3"><?
						//SI EL COMERCIAL LOGUEADO ES DIFERENTE NO DEJA VER OBSERVACIONES FernandoCo
						$verobservaciones = scai_get_name("$idvendedor","vendedores_customer","idvendedor_customer","idusuario");
                    if($_SESSION['perfil'] == "2" && $verobservaciones != $_SESSION["numberid"]){
	                }
						
						elseif($_POST['observaciones']!='') print $_POST['observaciones']; else print $datosad['observaciones']; ?></textarea><br>
						<?//SI EL COMERCIAL LOGUEADO ES DIFERENTE NO DEJA VER CONTACTOS FernandoCo
						$vercontactos = scai_get_name("$idvendedor","vendedores_customer","idvendedor_customer","idusuario");
                	if($_SESSION['perfil'] == "2" && $vercontactos != $_SESSION["numberid"]){
                	}
						
						elseif($_GET['idcliente']!="")
						{
							?>
					<!--		<a href="tablacli.php" class="botonesadmin" style="color:#FFFFFF;" target="_top" >Abrir lista</a>-->

							<?
						}
						?>
						</td>
					</tr>
				</table>

				<?
				//SI EL COMERCIAL LOGUEADO ES DIFERENTE NO DEJA VER CONTACTOS FernandoCo
						$ver = scai_get_name("$idvendedor","vendedores_customer","idvendedor_customer","idusuario");
                	if($_SESSION['perfil'] == "2" && $ver != $_SESSION["numberid"]){
                	}
				
				
				elseif($_GET['idcliente']){?>
					<!--Comentarios que alimenta el comercial en sus visitas a los clientes-->
						<p class="contenidotab" style="text-align:center;">
							<h3 style="display:inline"> Visitas</h3> <a href="#" onClick="AddRow(crearVisita)" style="font-size:11px">(Crear Secuencia)</a>
							<a href="#" onClick="ShowDiv('ShowVisitas,VisitasUp,VisitasDown')"> <div id="VisitasUp" style="display:block"> <img src="images/up.png"></div> <div id="VisitasDown" style="display:none"> <img src="images/down.png"></div> </a>
						</p>
					<div id="ShowVisitas">
						<table id="tabla" class="contenidotab" cellpadding="5">
							<tr class="tittabla">
								<td><strong>Fecha / Hora</strong></td>
								<td><strong>Observacion</strong></td>
						    	<td>Notificar a</td>

							</tr>
							<tr id="crearVisita" style="display:none">
								<td><?= date("Y-m-d H:i:s")?></td>
								<td>
								<textarea name='comentarioArea' id='comentarioArea' cols='55' rows = '11' required></textarea><br><input type='submit' class='botonesadmin' value='Guardar'>

								</td>
								<td> 
                                    <select name='actividad' >
										<option></option>
										<option value='fernandocortes@civilnet.co'>fernando</option>
										</select>								</td>

							</tr>
							<?
						//Las visitas se almacenan en un solo campo de la tabla clientes, entre ellas se sepan por el juego de caracteres '-//-', esto para no crear mas tablas en la base de datos. ahora con un explode se cera una matriz a partir de este campo y se muestran en pantalla todas las visitas las cuales se han guardado de forma desceendente
							$visitas = explode("-//-",$datosad['visitas']);
							foreach($visitas as $result){
								$columna = explode("-::-",$result);
								?>
								<tr bgcolor="<? echo ($color == "#CCCCCC") ? $color = "white" : $color ="#CCCCCC"?>">
									<td><? echo $columna[0]?></td>
									<td><? echo $columna[1]?></td>
							    	<td> <?
										if (trim($columna[2]) == "1")
											;
										elseif(trim($columna[2]) == "2")
											;
										else
											echo $columna[2];
										?>
									</td>
								</tr>
							<? }?>
						  </table>
					 </div>


					<?
					}

				?>
                </td>
		</tr>

	</table>

	<?
	//Obtiene el id de usuario del comercial logueado
	$idUsusarioVen = scai_get_name("$idvendedor","vendedores_customer","idvendedor_customer","idusuario");

	//Si el usuario comercial logueado no es el mismo asignado no permite ver el resto de la información
	if($_SESSION['perfil'] == "2" && $idUsusarioVen != $_SESSION["numberid"]){

	}else{ ?>
		<br>
		<table width="100%" align="center">
			<tr>
				<td bgcolor="#fc8286" colspan="4" height="4"></td>
			</tr>
			<tr>
				<td align="center" class="subtitseccion" style="text-align:left" colspan="4"><a href="javascript:void(0);" class="subtitseccion" onClick="ShowDiv('capa11')">CONDICIONES GENERALES</a><br>
				  <br></td>
			</tr>
			<tr>
				<td align="left" class="subtitseccion" colspan="4">
					<div id="capa11" style="display:none">
					<table width="100%" align="center">
						<tr>
							<td class="contenidotab">CREDITO</td>
							<td><input id="credito" name="credito" class="tex1" value="<? if($_POST['credito']!='') print $_POST['credito']; else print $datosad2['credito']; ?>" maxlength="50" size="40"></td>
							<td class="contenidotab">CUPO MAXIMO</td>
							<td><input id="cupo_max" name="cupo_max" class="tex1" value="<? if($_POST['cupo_max']!='') print $_POST['cupo_max']; else print $datosad2['cupo_max']; ?>" maxlength="50" size="40"></td>
						</tr>
							<td class="contenidotab">LIBERACION AUTOMATICA</td>
							<td>
								<select id="liberacion_auto" name="liberacion_auto" class="tex1" >
									<option value="N"> Seleccione </option>
									<?
									if($_POST['liberacion_auto']!='N' && $_POST['liberacion_auto']!='')
										$liberacion_auto = $_POST['liberacion_auto'];
									else
									{
										$liberacion_auto = $datosad2['liberacion_auto'];
									}
									?>
									<option value='1' <? if($liberacion_auto=='1') print 'selected'; ?> >Si</option>
									<option value='0' <? if($liberacion_auto=='0') print 'selected'; ?> >No</option>
								</select>
							</td>
							<td class="contenidotab">REGIMEN</td>
							<td>
								<select id="regimen" name="regimen" class="tex1" >
									<option value="N"> Seleccione </option>
									<?
									if($_POST['regimen']!='N' && $_POST['regimen']!='')
										$regimen = $_POST['regimen'];
									else
									{
										$regimen = $datosad2['regimen'];
									}
									?>
									<option value='simplificado' <? if($regimen=='simplificado') print 'selected'; ?> >Simplificado</option>
									<option value='comun' <? if($regimen=='comun') print 'selected'; ?> >Com&uacute;n</option>
									<option value='gran_contribuyente' <? if($regimen=='gran_contribuyente') print 'selected'; ?> >Gran Contribuyente</option>
								</select>    	</td>
						</tr>
						<tr>
							<td class="contenidotab">RETEFUENTE</td>
							<td><input id="retefuente" name="retefuente" class="tex1" value="<? if($_POST['retefuente']!='') print $_POST['retefuente']; else print $datosad2['retefuente']; ?>" maxlength="50" size="40"></td>
							<td class="contenidotab">RETEICA</td>
							<td><input id="reteica" name="reteica" class="tex1" value="<? if($_POST['reteica']!='') print $_POST['reteica']; else print $datosad2['reteica']; ?>" maxlength="50" size="40"></td>
						</tr>
						<tr>
							<td class="contenidotab">FECHA M&Aacute;XIMA DE FACTURACI&Oacute;N</td>
							<td>
							<input id="fecha_max_facturacion" name="fecha_max_facturacion" class="tex1" value="<? if($_POST['fecha_max_facturacion']!='') print $_POST['fecha_max_facturacion']; else print $datosad2['fecha_max_facturacion']; ?>" maxlength="50"></td>
						   <td class="contenidotab">DIAS DE CREDITO</td>
							<td><input id="dias_credito" name="dias_credito" value="<? if($_POST['dias_credito']!='') print $_POST['dias_credito']; else print $datosad2['dias_credito']; ?>" maxlength="2" size="2"></td>
						</tr>
						<tr>
						<tr>
							<td class="contenidotab" colspan="2" >OBSERVACIONES</td>
							<td colspan="2"><textarea name="observaciones_cond" id="observaciones_cond" class="tex1"  cols="40" rows="4"><? if($_POST['observaciones_cond']!='') print $_POST['observaciones_cond']; else print $datosad2['observaciones']; ?></textarea></td>
						</tr>
					</table>
					</div>
				</td>
			</tr>
		</table>



		<table width="100%" align="center">
			<tr>
				<td bgcolor="#fc8286" colspan="4" height="4"></td>
			</tr>
			<tr>
				<td align="center" class="subtitseccion" style="text-align:left" colspan="4"><a href="javascript:void(0);" class="subtitseccion" onClick="ShowDiv('capa12')">DOCUMENTACI&Oacute;N</a><br><br></td>
			</tr>
			<tr>
				<td colspan="4" height="4">
					<div id="capa12" style="display:none" >

						<table width="70%" align="center" cellpadding="6">
							<tr><td colspan="4"><a href="#" onClick="showEl(nuevoDoc)">Nuevo</a></td></tr>
							<tr class="tittabla">
								<td align="center" width="50%"><strong>DOCUMENTO</strong></td>
								<td align="center" width="25%"><strong>FECHA DE RECIBO</strong></td>
								<td align="center" width="25%"><strong>FECHA DE VENCIMIENTO</strong></td>
								<td align="center" width="25%"><strong>ADJUNTO</strong></td>
							</tr>
							<?
							//Consulta los documentos de clientes
							$sqlDoc = "select * from clientes_has_documentos where idcliente =".$_GET['idcliente'];
							$qryDoc= mysqli_query($sqlDoc);
							$x=0;
							while($documentos = mysqli_fetch_array($qryDoc)){


							?>
							<tr>
								<td class="contenidotab" align="center" width="50%"><strong>
									<? echo scai_get_name($documentos["iddocumento"],"documentos","iddocumento","nombre");?></strong>
									<input type="hidden" name="idDoc[]" value="<? echo $documentos["iddocumento"];?>">
								</td>
								<td class="contenidotab" align="center" width="25%">
									<input name="fecha_recibo[]" id="fr_<? echo $x;?>"  value="<? echo $documentos["fecha_recibo"];?>" readonly onClick="return showCalendar('fr_<? echo $x;?>');">
								</td>
								<td class="contenidotab" align="center" width="25%">
									<input name="fecha_vencimiento[]" id="fv_<? echo $x;?>"  value="<? echo $documentos["fecha_vencimiento"];?>" readonly onClick="return showCalendar('fv_<? echo $x;?>');">
								</td>
								<td class="contenidotab" align="center" width="25%"><strong>
									<?
									if($documentos["adjunto"]!= ""){
										$adjunto = substr($documentos["adjunto"],14,strlen($documentos["adjunto"]));
										?>
								<!--	<a href="file/<? echo $documentos["adjunto"]?>" target="_blank"><? echo $adjunto;?></a></strong>-->
										<a href="doc/doc_clientes/<? echo $documentos["adjunto"]?>" target="_blank"><? echo $adjunto;?></a></strong>
										<input type="hidden" name="adjHidden[<? echo $x;?>]" value="<? echo $documentos["adjunto"];?>">
									<?
									}else{?>
										<input type="file" name="adjunto[<? echo $x;?>]">
									<?
									}

									?>
								</td>
							</tr><?
							$x++;
							}
							?>
							<tr id="nuevoDoc" style="display:none">
								<td class="contenidotab" align="center" width="50%">
									<select name="documentoNombre">
										<option></option><?
										$qryDocName = mysqli_query($link,"select * from documentos");
										while($docName = mysqli_fetch_array($qryDocName) ){?>
											<option value="<? echo $docName["iddocumento"];?>"><? echo $docName["nombre"];?></option>
										<?
										}?>
										<option value="otro" onClick="showEl(otroDocumento);">Otro</option>
									</select>
									<input type="text" id="otroDocumento" name="otroDocumento" style="display:none">
								</td>
								<td class="contenidotab" align="center" width="25%">
									<input name="fecha_recibo_nuevo" id="fr_<? echo $x;?>"  value="<? echo $documentos["fecha_recibo"];?>" readonly onClick="return showCalendar('fr_<? echo $x;?>');" required>
								</td>
								<td class="contenidotab" align="center" width="25%">
									<input name="fecha_vencimiento_nuevo" id="fv_<? echo $x;?>"  value="<? echo $documentos["fecha_vencimiento"];?>" readonly onClick="return showCalendar('fv_<? echo $x;?>');">
								</td>
								<td class="contenidotab" align="center" width="25%">
									<input type="file" name="adjunto_nuevo">

								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>

		<?
		for($k=0; $k < 3; $k++)
		{
			if($k == 0)
			{
				$clasif = 'fcl';
				$capa = '13';
			}
			if($k == 1)
			{
				$clasif = 'lcl';
				$capa = '131';
			}
			if($k == 2)
			{
				$clasif = 'aereo';
				$capa = '132';
			}
			?>
			<table width="100%" align="center">
				<tr>
					<td bgcolor="#fc8286" colspan="4" height="4"></td>
				</tr>
				<tr>
					<td align="center" class="subtitseccion" style="text-align:left" colspan="7">
						<a href="javascript:void(0);" class="subtitseccion" onClick="ShowDiv('capa<? echo $capa?>');">RECARGOS LOCALES <? print strtoupper($clasif); ?></a><br></td>
				</tr>
				<tr>
				  <td align="center" class="subtitseccion" style="text-align:left" colspan="7">&nbsp;</td>
				</tr>
			</table>
			<div id="capa<? print $capa; ?>" style="display:none">
			<?
			$sqlr = "select * from cliente_local where idcliente='$datosad[idcliente]' and clasificacion='$clasif'";
			$exer = mysqli_query($link,$sqlr);
			$filasr = mysqli_num_rows($exer);
			$datosr = mysqli_fetch_array($exer);
			?>
			<table width="100%" align="center">
				<tr>
					<td class="contenidotab">Collection Fee(%)</td>
					<td><input id="collection_fee<? print $clasif; ?>" name="collection_fee<? print $clasif; ?>" class="tex1" value="<? if($_POST['collection_fee'.$clasif]!='') print $_POST['collection_fee'.$clasif]; else print $datosr['collection_fee']; ?>" maxlength="50" size="40"></td>
					<td class="contenidotab">Minimo Collection Fee($)</td>
					<td><input id="min_collection_fee<? print $clasif; ?>" name="min_collection_fee<? print $clasif; ?>" class="tex1" value="<? if($_POST['min_collection_fee'.$clasif]!='') print $_POST['min_collection_fee'.$clasif]; else print $datosr['min_collection_fee']; ?>" maxlength="150" size="40"></td>
				</tr>
				<tr>
					<td class="contenidotab">CAF(%)</td>
					<td><input id="caf<? print $clasif; ?>" name="caf<? print $clasif; ?>" class="tex1" value="<? if($_POST['caf'.$clasif]!='') print $_POST['caf'.$clasif]; else print $datosr['caf']; ?>" maxlength="50" size="40"></td>
					<td class="contenidotab">Minimo CAF($)</td>
					<td><input id="min_caf<? print $clasif; ?>" name="min_caf<? print $clasif; ?>" class="tex1" value="<? if($_POST['min_caf'.$clasif]!='') print $_POST['min_caf'.$clasif]; else print $datosr['min_caf']; ?>" maxlength="150" size="40"></td>
				</tr>
				<tr>
					<? if ($clasif == 'fcl' || $clasif == 'lcl') { ?>
						<td class="contenidotab">Nombre gastos hbl</td>
						<td><input id="nombre_gastos_hbl<? print $clasif; ?>" name="nombre_gastos_hbl<? print $clasif; ?>" class="tex1" value="<? if($_POST['nombre_gastos_hbl'.$clasif]!='') print $_POST['nombre_gastos_hbl'.$clasif]; else print $datosr['nombre_gastos_hbl']; ?>" maxlength="50" size="40"></td>

						<? if ($clasif == 'lcl') { ?>
							<td class="contenidotab">Nombre gastos wm</td>
							<td><input id="nombre_gastos_wm<? print $clasif; ?>" name="nombre_gastos_wm<? print $clasif; ?>" class="tex1" value="<? if($_POST['nombre_gastos_wm'.$clasif]!='') print $_POST['nombre_gastos_wm'.$clasif]; else print $datosr['nombre_gastos_wm']; ?>" maxlength="150" size="40"></td>
						 <?  }
						if ($clasif == 'fcl') { ?>
							<td class="contenidotab">Nombre gastos cont</td>
							<td><input id="nombre_gastos_cont<? print $clasif; ?>" name="nombre_gastos_cont<? print $clasif; ?>" class="tex1" value="<? if($_POST['nombre_gastos_cont'.$clasif]!='') print $_POST['nombre_gastos_cont'.$clasif]; else print $datosr['nombre_gastos_cont']; ?>" maxlength="50" size="40"></td>
						<? }
					}
					if ($clasif == 'aereo') { ?>
						<td class="contenidotab">Nombre gastos hawb</td>
						<td><input id="nombre_gastos_hawb<? print $clasif; ?>" name="nombre_gastos_hawb<? print $clasif; ?>" class="tex1" value="<? if($_POST['nombre_gastos_hawb'.$clasif]!='') print $_POST['nombre_gastos_hawb'.$clasif]; else print $datosr['nombre_gastos_hawb']; ?>" maxlength="50" size="40"></td>
						<td class="contenidotab">Nombre gastos embarque</td>
						<td><input id="nombre_gastos_embarque<? print $clasif; ?>" name="nombre_gastos_embarque<? print $clasif; ?>" class="tex1" value="<? if($_POST['nombre_gastos_embarque'.$clasif]!='') print $_POST['nombre_gastos_embarque'.$clasif]; else print $datosr['nombre_gastos_embarque']; ?>" maxlength="50" size="40"></td>
					<? } ?>
				</tr>
				<? if ($clasif == 'aereo' || $clasif == 'lcl') { ?>
				<tr>
					<td class="contenidotab">Nombre gastos kilo</td>
					<td><input id="nombre_gastos_kilo<? print $clasif; ?>" name="nombre_gastos_kilo<? print $clasif; ?>" class="tex1" value="<? if($_POST['nombre_gastos_kilo'.$clasif]!='') print $_POST['nombre_gastos_kilo'.$clasif]; else print $datosr['nombre_gastos_kilo']; ?>" maxlength="50" size="40"></td>
				</tr>
				<? } ?>

				<tr>
				<td class="contenidotab">Observaciones</td>
				<td colspan="3"><textarea name="observaciones<? print $clasif; ?>" id="observaciones<? print $clasif; ?>" class="tex1s"  cols="95" rows="3"><? if($_POST['observaciones'.$clasif]!='') print $_POST['observaciones'.$clasif]; else print $datosr['observaciones']; ?></textarea></td>
				</tr>
			</table>
			<iframe src="recargos_local_cliente.php?cl=<? print $clasif; ?>&idcliente=<? print $datosad['idcliente'];?>" width="100%" height="100%" scrolling="yes" frameborder="0"></iframe>
			</div>
			<?
		}

			$_POST['idcliente'] = $_GET['idcliente'];
		?>
		<table width="100%" align="center">
			<tr>
				<td bgcolor="#fc8286" colspan="4" height="4"></td>
			</tr>
			<tr>
				<td align="center" class="subtitseccion" style="text-align:left" colspan="4"><a href="javascript:void(0);" class="subtitseccion" onClick="ShowDiv('capa14')">CONTACTOS CLIENTE</a><br><br></td>
			</tr>
			<tr>
				<td colspan="4" height="4">
					<div id="capa14" style="display:none">
						<iframe src="contactos_clientes.php?idcliente=<? print $_POST['idcliente'] ?>" width="100%" height="100%" scrolling="yes" frameborder="0"></iframe>
					</div>
				</td>
			</tr>
		</table>
<!--Botones-->
	<br>
	<table width="100%" align="center">
		<tr>
			<td>
				<table>
					<tr>
						<?

						if ($_GET['idcliente'] != '')
						{
							if(puedo("m","CLIENTES")==1) { ?>
							<td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
						<td width="60"class="botonesadmin">
								<a href="clientes_print.php?idcliente=<?php print $_GET['idcliente']; ?>" target="_blank">Vista de Impresión</a>
					  </td>
							<?
							}
						}
						if ($_GET['idcliente'] != '')
						{
							if(puedo("e","CLIENTES")==1) { ?>
							<td width="60" class="botonesadmin">
								<a href="javascript: void(0)" onClick="eliminaActual(formulario)">
									Eliminar
								</a></td>
							<?
							}
						}
						if(puedo("c","CLIENTES")==1) { ?>
						<td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="borrar(formulario)" >Nuevo</a></td>
						<? } ?>
					</tr>
				</table>
			</td>
			<td>

			</td>
		</tr>
	</table>
	<?
	}
	if ($_GET['idcliente'] == '')
	{
		if(puedo("c","CLIENTES")==1) { ?>
			<table><tr>
				<td width="60"class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
			</tr></table>
		<?
		}
	}
	?>


</form>
</body>
