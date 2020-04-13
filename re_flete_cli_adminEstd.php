<?
include('sesion/sesion.php');
include_once("permite.php");

include("./conection/conectar.php");
/*
Crea estados para luego visualizarlos en el moduylo de seguimientos
*/
//Valida que tenga permisos

if(puedo("1","Agregar_Estados")!=1){
	header("Location:ppal.php");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<script type="text/javascript" src="./js/jquery-1.8.3.js"></script>
	<!--Includes que conviernten textarea, en caja de texto con texto enriquecido-->
	<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
		tinyMCE.init({
			// General options		
			mode : "exact",
			elements : "txtEstado",
	        plugins : "paste",	
			paste_remove_spans:true,

			theme : "simple",
			content_css : "css/admin_internas.css",
       });

	var x;
	x=$(document);
	x.ready(inicializarEventos);
	
	function inicializarEventos(){
		$("#camposDb").dblclick(addCampo); //A�ade el campo al textarea
		$("#campoSms").dblclick(addCampoSms); //A�ade el campo al textarea
		$("#smsEstado").click(valCampo); //Cuando seleccione el textarea de sms valida que no est� seleccionando un campo, si es as� lo selecciona todo

	}
	function addCampo(){
		var valor = $("#camposDb option:selected" ).val();	
		tinymce.activeEditor.execCommand('mceInsertContent', true, "<input type='button' value='|@"+valor+"|' class='newStInptSeg' />");
	}
	function addCampoSms(){ /*
		var valor = ;	
		$("#smsEstado").append("|@"+valor+"|");*/
		var caretPos = document.getElementById("smsEstado").selectionStart;
		var textAreaTxt = jQuery("#smsEstado").val();
		var txtToAdd = " |@"+$("#campoSms option:selected" ).val()+"| ";
		$("#smsEstado").val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );

		 
	}	
	function valCampo(){
	
		//si a la izquierda encuentra un @ antes de encontrar un espacio o |, quiere decir que es un campo
		var position = $("#smsEstado").caret().start;
		alert(position);
	}
	
		
</script>
<style>
	#divAdj{
		text-align:left;
		width:800px;
		height:25px;
	}
	.divAdjHijo{
		background-color:#999999;
		width:auto;
		float:left;
		margin:2px 2px 2px 2px ;
		padding:2px 2px 2px 2px ;
	}
	.divAdjHijo input{
		background-color:#999999;
		border:none;
	}
	.imgDel{
		width:12px;
		cursor:pointer;
	}
</style>
<link href="./css/admin_internas.css" rel="stylesheet" type="text/css">
</head>

<body>
	
	


	<p>
	<?
	if($_GET['opc'] == "cambiar" || $_GET['opc'] == "nuevo"){ 	
		if($_GET['opc'] == "cambiar"){ //Si edita
			$sqlEst = mysqli_query($link,"select * from re_flete_cli_estados where id = ".$_GET['id']);
			$Estado = mysqli_fetch_array($sqlEst);
		}		
		
		?>
		<form method="post">
			<table align="center" border="1" style="border-collapse:collapse">
				<tr>
					<td colspan="2"><h3>Editar Estado:<input type="text" name="titulo"  value="<? echo $Estado["titulo"];?>" required/> </h3></td>
				</tr>
				<tr>
					<td>
						<h3>Web</h3>
						<textarea style="width:600px;height:200px" id="txtEstado" name="txtEstado">
							<div id="nuevoEstado">
								<? echo $Estado["estado"];?>
							</div>
						</textarea>					</td>
					<td align="center">
						<h4>Campos Seguimientos</h4>
						<select multiple="multiple" style="height:100px" id="camposDb">
							<option value='aduana'>ADUANA</option>
							<option value='eta'>ETA</option>
							<option value='etd'>ETD</option>
							<option value='fecha_factura'>FECHA_FACTURA</option>
							<option value='idcliente'>CLIENTE</option>
							<option value='motonave'>MOTONAVE</option>
							<option value='n20'>N20</option>
							<option value='n40'>N40</option>
							<option value='n40hq'>N40HQ</option>
							<option value='no_factura'>NO_FACTURA</option>
							<option value='peso'>PESO</option>
							<option value='puerto_destino'>PUERTO DESTINO</option>
							<option value='puerto_origen'>PUERTO ORIGEN</option>
							<option value='ref'>MANIFIESTO</option>
							<option value='shipper'>SHIPPER</option>
							<option value='volumen'>VOLUMEN</option>
							<option value='clasificacionHbl'>HBL / HAWB</option>
							<option value='clasificacionMoto'>MOTONAVE / AEROLINEA</option>
						</select>					
					</td>
				</tr>
				
<tr>
	  <td>
						<h3>Sms</h3>
						<textarea style="width:600px;height:200px" id="smsEstado" name="smsEstado"><? echo $Estado["estadoSms"];?></textarea>					
	  </td>
						<td>
						<strong>Campos Sms:</strong><br />
						  <select name="select" multiple="multiple" id="campoSms" style="height:100px">
						  <option value='number'>O. NUMBER</option>
                          <option value='aduana'>ADUANA</option>
                          <option value='eta'>ETA</option>
                          <option value='etd'>ETD</option>
                          <option value='fecha_factura'>FECHA_FACTURA</option>
                          <option value='idcliente'>CLIENTE</option>
                          <option value='motonave'>MOTONAVE</option>
                          <option value='n20'>N20</option>
                          <option value='n40'>N40</option>
                          <option value='n40hq'>N40HQ</option>
                          <option value='no_factura'>NO_FACTURA</option>
                          <option value='peso'>PESO</option>
                          <option value='puerto_destino'>PUERTO DESTINO</option>
                          <option value='puerto_origen'>PUERTO ORIGEN</option>
                          <option value='ref'>MANIFIESTO</option>
                          <option value='shipper'>SHIPPER</option>
                          <option value='volumen'>VOLUMEN</option>
                          <option value='clasificacionHbl'>HBL / HAWB</option>
                          <option value='clasificacionMoto'>MOTONAVE / AEROLINEA</option>
                        </select></td>
			  </tr>
				
				<tr>
					<td align="center">
						<?
						if($_GET['opc'] == "cambiar"){?>
							<input type="submit" value="Editar" onclick="form.action='?opc=edit&id=<? echo $_GET['id'];?>'" class="botonesadmin" />
						<? }else{?>
							<input type="submit" value="Crear" onclick="form.action='?opc=create'" class="botonesadmin" />
						<? }?>					</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</form>

	<? }else if($_GET['opc']== "edit"){

			if($_POST['adjuntos']){
				foreach($_POST['adjuntos'] as $adjunto){
					$adjuntos .= "$adjunto|";
				}
			}
			$adjuntos = substr($adjuntos,0,strlen($adjuntos)-1);

			//Valida que no tenga caracteres como @ o comillas
			$_POST['txtEstado'] = str_replace("'","\"",$_POST['txtEstado']); //comilla sencilla
			$_POST['smsEstado'] = str_replace("\"","",$_POST['smsEstado']); //comilla doble
			$_POST['smsEstado'] = str_replace("'","",$_POST['smsEstado']); //comilla sencilla
						
			$sqlEdit = "update re_flete_cli_estados set 
							estado = '".$_POST['txtEstado']."' ,
							titulo  = '". $_POST['titulo'] ."',
							estadoSms  = '". $_POST['smsEstado'] ."'
						where id = ".$_GET['id'];
			
			if(mysqli_query($link,$sqlEdit)){
				echo "<script>alert('Almaceno');window.location='re_flete_cli_adminEstd.php'</script>";
			}else{
				echo "No almacen� <BR> <input type='text' value='$sqlEdit'>";
			}
	}else if($_GET['opc']== "create"){
			//Valida que no tenga caracteres como @ o comillas

			if($_POST['adjuntos']){
				foreach($_POST['adjuntos'] as $adjunto){
					$adjuntos .= "$adjunto|";
				}
			}
			$adjuntos = substr($adjuntos,0,strlen($adjuntos)-1);


			$_POST['txtEstado'] = str_replace("'","\"",$_POST['txtEstado']); //comilla sencilla


			$sqlCreate = "insert into re_flete_cli_estados 
							(estado, titulo,estadoSms)values(
								'". $_POST['txtEstado'] ."',
								'". $_POST['titulo'] ."',
								'". $_POST['smsEstado'] ."'
							)";
			if( mysqli_query($link,$sqlCreate) ){
				echo "<script>alert('Almaceno');window.location='re_flete_cli_adminEstd.php'</script>";
			}else{
				echo "No almacen�<br>".$sqlCreate;
			}
	
	}else if($_GET['opc']== "del"){
		//Elimina un registro
			$sqlDelete = "delete from re_flete_cli_estados where id = ".$_GET['id'];
			if( mysqli_query($link,$sqlDelete) ){
				echo "<script>alert('Elimino');window.location='re_flete_cli_adminEstd.php'</script>";
			}else{
				echo "No almacen�<br>".$sqlCreate;
			}
	}else{?>
		   <table width="80%" border="0" cellpadding="5" cellspacing="1" class="contenidotab" align="center">
				<tr>
					<td colspan="2" style="font-weight:bold">Estados
						<?
							//Valida permisos de creacion
							if(puedo("c","Agregar_Estados")){?>
								(<a href="?opc=nuevo">Nuevo</a>)<?
							}
							?>
					</td>
				</tr>
				<tr class="tittabla">
					<td>Id</td>
					<td width="25%">Titulo</td>
					<td>Estado</td>
					<td>Editar</td>
					<td>Eliminar</td>
				</tr>
				<?
				$qryEstados = mysqli_query($link,"select * from re_flete_cli_estados") ;
				while($Estados = mysqli_fetch_array($qryEstados)){?>
					<tr bgcolor="<? echo ($color == "#CCCCCC") ? $color = "#FFFFFF" : $color = "#CCCCCC"; ?>">
						<td><? echo $Estados["id"];?></td>
						<td><? echo $Estados["titulo"];?></td>
						<td><? 
								echo $Estados["estado"];
						?></td>
						<td width="5%"><a href="?id=<? echo $Estados["id"]; ?>&opc=cambiar"> 
							<? //Valida permisos de modificacion
							if(puedo("m","Agregar_Estados")){?>
								<img src="images/modi.png" /></a> 
							<? }?>
						</td>
						<td>
						<? if(puedo("e","Agregar_Estados")){?>
							<a href="?opc=del&id=<? echo $Estados["id"];?>" onclick="return confirm('�Realmente desea eliminar este registro?')"><img src="images/close.png" /></a></td>
						<? }?>
							
					</tr>
				<?
				
				}
				
				?>
			</table><?
	
	}?>
	</p>
</body>
</html>
