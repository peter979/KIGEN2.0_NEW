<?
	
	
if ($_GET['preforma'] != 'si')
include('./sesion/sesion.php');
include("./conection/conectar.php");
include_once("./permite.php");
include_once("./alertas.php");
include_once("scripts/recover_nombre.php");

include('./sendSms.php');


$_GET['idcot_temp'] = "";

if ($_GET['name'] == '')
    $name = str_replace("{file_name}", $_GET['idshipping'], scai_get_name("nombre_archivo_rep_estado", "parametros", "nombre", "valor"));
$name = str_replace(' ', '_', $name);
?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style>
	#tbBotones input[type=submit]{
		font-size:8.5px;
	}
</style>
<?


if ($_GET['exporta'] == 'si') {
    if ($_GET['preforma'] != 'si') {
        Header("Content-Disposition: inline; filename=$name.doc");
        Header("Content-Description: PHP3 Generated Data");
        Header("Content-type: application/vnd.ms-word; name='$name.doc'"); //comenta esta linea para ver la salida en web
        flush;
    }else{
        print "<style type='text/css'>
		body,td,th
		{
			font-size: 11px;
		
		</style>";
    }
    ?><?
} else {
    ?>
    <link href="./css/admin_internas.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="./js/jquery.js"></script>
	<script type="text/javascript" src="./js/main.js"></script>
	<script type="text/javascript" src="./js/shadowbox-base.js"></script>
	<script type="text/javascript" src="./js/shadowbox.js"></script>
	<script type="text/javascript" src="./js/jquery-1.2.6.pack.js"></script>
	<script type="text/javascript" src="./js/jquery-1.2.1.pack.js" ></script>
	<script type="text/javascript" src="./js/funciones.js"></script>
	<script type="text/javascript" src="./js/funcionesValida.js"></script>
	<script type="text/javascript" src="./js/calendar.js"></script>
	<script type="text/javascript" src="./js/calendar-en.js.js"></script>
	<script type="text/javascript" src="./js/jquery.js"></script>
	<script type="text/javascript" src="./js/main.js"></script>
	<script type="text/javascript" src="./js/shadowbox-base.js"></script>
	<script type="text/javascript" src="./js/shadowbox.js"></script>
	<script type="text/javascript" src="./js/jquery-1.2.6.pack.js"></script>
	<script type="text/javascript" src="./js/jquery-1.2.1.pack.js" ></script>
	<script type="text/javascript" src="./js/jquery-1.8.3.js" ></script>
	<script type="text/javascript" src="./js/funciones.js"></script>
	<script type="text/javascript" src="./js/funcionesValida.js"></script>
	<script type="text/javascript" src="./js/calendar.js"></script>
	<script type="text/javascript" src="./js/calendar-en.js.js"></script>
	<? include('./scripts/scripts.php');?>
    <script>
        var x;
		x=$(document);
		x.ready(inicializarEventos);
		
		function inicializarEventos(){
			$(".numerico").keyup(numerico);//Valida campos numericos
			$(".devuelto_cont").click(getCal);//Calendario para campos de tipo de contenedor
		}
		function getCal(){
			var id = $(this).attr("id");
			return showCalendar(id);
		}
		function numerico(e) {

			//Permite unicamente campos numericos
		  if ((e.keyCode < 48 || e.keyCode > 57) && e.keyCode != 8  && e.keyCode != 188){
			  e.preventDefault();
		  }
		}
        function validadjunto(form, eli)
        {
            form.listaeli2.value = eli;
            form.submit()
        }
        

        function validaEnvia(form)
        {
            if (form.idestado != null)
            {
                //lista_id = '';
                lista_f = '';
                lista_h = '';
                lista_m = '';
                lista_d = '';
                listaeli = '';
                ponerComa = false;
				
            }
            else
            {
                alert("Debe agregar por lo menos un estado");
                return false;
            }
        	
            if(form.number.value==""){
                alert("Debe digitar un numero de orden");
                return false
            }
        	
            form.datosok.value="si";
            form.submit()
        }
        function recargar(form)
        {
            form.submit()
        }
            
        var numero = 0;
        var maximo = 50;
        var cantact = 0;
        // Funciones comunes
        c= function (tag) { // Crea un elemento
            return document.createElement(tag);
        }
        d = function (id) { // Retorna un elemento en base al id
            return document.getElementById(id);
        }
        e = function (evt) { // Retorna el evento
            return (!evt) ? event : evt;
        }
        f = function (evt) { // Retorna el objeto que genera el evento
            return evt.srcElement ?  evt.srcElement : evt.target;
        }

		var liberacion = 0;
        addField = function (opc) {
				//Permite Crear un Nuevo comentario 
				var table = document.getElementById("status");
				if(!document.getElementById('fecha')){
					var row = table.insertRow(2);		
					var td1 = document.createElement("TD")
					row.appendChild(td1).innerHTML="<? echo date("Y-m-d")?>";
					
					<?
					$horaAct = date("H");
					$minAct = date("i");
					?>
					var td2 = document.createElement("TD")
					row.appendChild(td2).innerHTML="<? echo date("H:i")?>"; 

					var td3 = document.createElement("TD")
					row.appendChild(td3).innerHTML="<textarea name='descripcion[]' required></textarea>"; 					
					



					if(liberacion == 0){ //solo si no existe liberacion crea el check para crearla
						row.appendChild(td3).innerHTML += "<input type='checkbox' name ='liberacion[]'>Liberacion"; 
					}else{
						row.appendChild(td3).innerHTML += "<input type='hidden' value='off' name ='liberacion[]'>"; 
					}
					
					
					
				
				}
				
        }
        removeField = function (evt) {
            lnk = f(e(evt));
            td = d(lnk.name);
            td.parentNode.removeChild(td);
            cantact--;
        }

		var radAdj = 0;
        addField2 = function () {

			
			$("#contiene2").append("<table><tr id='fila1'><td id='caja2' class='contenidotab' align='right'>Interno: <input name='adjunto_"+radAdj+"' value='interno' type='radio'><br>Agente: <input name='adjunto_"+radAdj+"' value='agente' type='radio'><br>Cliente: <input name='adjunto_"+radAdj+"' value='cliente' type='radio'></td><td class='contenidotab'><input id='formato_adjunto' name='formato_adjunto[]' type='file'></td></tr></table>");
			radAdj++;
			
        }
        	
        function enviamail(form)
        {
            form.submit()
        }
        function desabilitarzona(form){
            form.deshok.value="si";
            form.submit()
        }
        	
        function desabilitarcuadro(form){
            form.descuadrook.value="si";
            form.submit()
        }	
        	
        function showmed()
        {
            $('div[@class=campos]').slideToggle("slow",function(){
                /*$('div[@class=campos]').slideUp("slow");*/
            });
        }
		var idCont =0;
		function addCont(){ //Crea un nuevo input para agregar un contenedor
			idCont++;
			$("#contenedores").append("<div style='white-space:nowrap'>Numero:<input type='text' name='contenedor[]' class='contenedor'> Tipo: <select name='tipoCont[]' class='contenedor'><option></option><option>20</option><option>40</option><option>40Hq</option></select> Devuelto:<input type='text' name='devuelto[]' class='contenedor devuelto_cont' id='cont_"+idCont+"' onClick='return showCalendar(\"cont_"+idCont+"\")' readonly></div><br>");
		}
    </script>

    <?
}

if ($_GET['exporta'] == 'si') {
    ?><style type="text/css">
        body{
            font-family:<? print scai_get_name("exportar_word_fuente", "parametros", "nombre", "valor"); ?>;
            font-size:<? print scai_get_name("exportar_word_tamano_fuente", "parametros", "nombre", "valor"); ?>pt;
        }

        div.campos
        {	
            display:none;
        }

    </style>
    <?
}

if ($_POST['listaeli2'] != '') {
    $sql = "delete from formatos_adjunto where idformato='$_POST[listaeli2]'";
    $exe = mysqli_query($link,$sql);
}
if ($_POST['deshok'] == 'si') {

    $sql = "update reporte_estado_cli set estado_zona='$_POST[deshabilitarz]' where idreporte_estado='$_GET[idreporte_estado]' and idcliente='$_GET[idcliente]'";
    $exe = mysqli_query($link,$sql);
}

if ($_POST['descuadrook'] == 'si') {

    $sql = "update reporte_estado_cli set deshabilitar='$_POST[deshabilitar]' where idreporte_estado='$_GET[idreporte_estado]' and idcliente='$_GET[idcliente]'";
    $exe = mysqli_query($link,$sql);
}


if ($_POST['notifycam'] == 'si') {
    $lista_f = explode("|", $_POST['lista_f']);
    $lista_h = explode("|", $_POST['lista_h']);
    $lista_m = explode("|", $_POST['lista_m']);
    $lista_d = explode("|", $_POST['lista_d']);
    $listaeli = explode("|", $_POST['listaeli']);
	
    if ($estadosenviar = 'si') {
        $desde = 'comercial';
        include('mail_notificacion_estado_com.php');
    }
}

if ($_POST['datosok'] == 'si') {




    //$lista_id = explode("|", $_POST['lista_id']);
    $lista_f = explode("|", $_POST['lista_f']);
    $lista_h = explode("|", $_POST['lista_h']);
    $lista_m = explode("|", $_POST['lista_m']);
    $lista_d = explode("|", $_POST['lista_d']);
    $listaeli = explode("|", $_POST['listaeli']);

    $sql = "select idreporte_estado from reporte_estado_cli where idreporte_estado='$_GET[idreporte_estado]'";
    $exe = mysqli_query($link,$sql);
    $filas = mysqli_num_rows($exe);


	function send_mail($opc,$idRep){
		include("./conection/conectar.php");
		session_start();

			if(!require_once("phpmailer/class.phpmailer.php"))
				echo "no phpmailer class";
			if(!require_once("phpmailer/class.smtp.php"))
				echo "no smtp class";
				
			if(!$mail = new PHPMailer())
				echo "no creó objecto";

		
		
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
		
		$mail->CharSet = 'UTF-8';
	
		//------------------------------------------------------------
		$mail->Subject = "Nuevo servicio de $opc";
		
		/*
		<p style='color:#FF0000;text-align:center'>**PARA CUALQUIER  INQUIETUD Y/O SOLICITUD,  POR FAVOR ASEGURARSE DE RESPONDE CON COPIA A TODOS LOS CORREOS ELECTRONICOS  MENCIONADOS EN ESTE MENSAJE**</p>
			<table width='100%' align='center'>
				<tr>
					<td class='subtitseccion' style='text-align:center;color:#ffffff'><strong>CARGA ". strtoupper($opc) ."</strong></td>
				</tr>	
			</table>
			<br />
		*/
		
		$msg ="
			
			<p>
				Se apróxima una carga con servicio de $opc, con la siguiente información:
			</p>
			
			<table width='70%' align='center' border='1'>
				<tr>
					<td class='tittabla' bgcolor='#a01313' style='text-align:center;color:#ffffff' colspan='2'><strong>DATOS DE LA CARGA</strong></td>
				</tr>
				<tr>
					<td class='contenidotab'></td>
					
					
				</tr>
				<tr>
					<td class='contenidotab' valign='top'>
						<table width='100%' align='center'>	
							<tr>
								<td class='contenidotab'><strong>CLIENTE</strong> " . scai_get_name($_GET['idcliente'], "clientes", "idcliente", "nombre") . "</td>
							</tr>
							<tr>
								<td class='contenidotab'><strong>ETD: </strong> ".$_POST["etd"]."</td>
							</tr>
							<tr>
								<td class='contenidotab'><strong>PEDIDO: </strong>".$_POST["number"]."</td>
							</tr>
							<tr>
								<td class='contenidotab'><strong>SHIPPER: </strong>".$_POST["shipper"]."</td>
							</tr>
						</table>			
					</td>
					
				</tr>    
			</table>
			
			<p>

			</p>
			<br />
			<table width='100%' align='center'>
				<tr>
					<td class='contenidotab'>Agradezco su amable atencion y cualquier inquietud al respecto, con gusto la atenderemos.<br /><br />
					Cordialmente,<br />";
					$sql_sign = "select * from usuarios where idusuario='".$_SESSION['numberid']."'";
					$exe_sql_sign = mysqli_query($link,$sql_sign);
					$row_exe_sql_sign = mysqli_fetch_array($exe_sql_sign);
				
					$sql_sign2 = "select * from vendedores_customer where idusuario='".$_SESSION['numberid']."'";
					$exe_sql_sign2 = mysqli_query($link,$sql_sign2);
					$row_exe_sql_sign2 = mysqli_fetch_array($exe_sql_sign2);
				
					$msg .= '<br><br>' . $row_exe_sql_sign2['nombre'];
				/*	$msg .= '<strong><br>' . scai_get_name("$row_exe_sql_sign2[idcargo]", "cargos", "idcargo", "nombre") . '</strong>';
					$msg .= '<br>Address: ' . $row_exe_sql_sign2['direccion'];*/
					$msg .= '<br>Phone: ' . $row_exe_sql_sign2['telefono'];
					$msg .= '<br>Movil: ' . $row_exe_sql_sign2['celular'];
					$msg .= '<br>E-mail: ' . $row_exe_sql_sign2['email'];
				
					$sqlpm = "select * from parametros where idparametro='32'";
					$exepm = mysqli_query($link,$sqlpm);
					$cond = mysqli_fetch_array($exepm);
					$msg .= '<br>Web site: ' . $cond['valor'];
				
					$msg .= "</td>
				</tr>
			</table>";
			//logo-----------------------------------------------------------------------------------------------------------
	/*		$logo = "
			<table width='100%' align='center' style='border-collapse: collapse; border: 4px solid orange;'>
				<tr>
					<td align='left' width='40%'>
						<p style='text-align: center; font-size:8pt; font-weight: bold;'>Este espacio fue diseñado para nuestros asociados de negocio, si desea pautar con nosotros, contáctenos al PBX (571) 8050075 Adriana Arias</p>
					</td>
					<td align='left'>
						<a href='http://www.distrielectricosje.com'><img src='http://190.158.236.5/gateway/images/logo_complementario.jpg' border='0' height='75' style='margin-right: 5px;' /></a>
						<a href='http://newline.com.co/'><img src='http://190.158.236.5/gateway/images/logo_complementario_2.png' border='0' height='75' style='margin-right: 5px;' /></a>
					</td>
				</tr>
			</table><br />
			";*/
			$logo .= "
			<table width='100%' align='center'>
				<tr>
					<td align='left'>
				<img src='http://appkigen.co/demo/images/logo.png' border='0' width='198' height='60' />
					</td>
				</tr>
			</table>";
		$mail->Body = $msg;
	
		$mail->AddAddress("fernandocortes@civilnet.co");
		//$mail->AddAddress("desarrollador1@civilnet.co");
		
		if(!$mail->Send()){
			/*echo "<script>alert('Error al enviar email de ". strtoupper($opc) .", Contacte al administrador')</script>";*/
			echo $mail->ErrorInfo;
		}else
			echo "<script>alert('Envió $opc')</script>";
	}

    if ($_POST['deshabilitar'] == '')
        $_POST['deshabilitar'] = '0';
    
	if ($filas == 0) {
		//Valida que el numero de orden no exista
		$sqlON = "select number from reporte_estado_cli where number = '".$_POST["number"]."'";
		$qryON = mysqli_query($link,$sqlON);

		
		if( mysqli_num_rows($qryON) > 0 ){?>
			<p>
				<font class="error">El numero de orden <strong><?= $_POST["number"]?></strong> ya existe</font>
			</p>
			<a href="#" onClick="history.back()">Volver</a>
			<?
			die();
		}
		
        $sql = "insert into reporte_estado_cli (
					ref,
					ref2,
					hbl, 
					emision_hbl,
					motonave, 
					deshabilitar, 
					numshipping, 
					idshipping, 
					idcliente, 
					idusuario,
					clasificacion,
					idincoterm,
					aduana, 
					number, 
					shipper, 
					peso, 
					volumen, 
					puerto_origen, 
					puerto_destino, 
					mercancia, 
					etd, 
					eta, 
					n20, 
					n40, 
					n40hq, 
					naviera, 
					request_ship_date, 
					exon_deposito,
					exon_dropoff,
					dias_libres,
					dias_libres_gw,
					val20gw,
					val40gw,
					val40Hqgw,					
					operativo,
					asignacion,
					rentabilidad,
					agente,
					servicio_cliente,
					fecha_creacion,
					recibido,
					mbl,
					emision_mbl,
					no_factura,
					fecha_factura,
					fecha_conexion,
					gastos_destino,
					aduanaChk,
					otmChk,
					terrestreChk
				) values(
					'$_POST[ref]',
					'$_POST[ref2]', 
					'$_POST[hbl]', 
					'$_POST[emision_hbl]',
					'$_POST[motonave]', 
					'$_POST[deshabilitar]', 
					'$_GET[numshipping]', 
					'$_GET[idshipping]', 
					'$_GET[idcliente]', 
					".$_SESSION["numberid"].", 
					'$_POST[clasificacion]',
					'$_POST[idincoterm]', 
					'$_POST[aduana]', 
					'$_POST[number]', 
					'$_POST[shipper]', 
					'$_POST[peso]',
					'$_POST[volumen]', 
					'$_POST[puerto_origen]', 
					'$_POST[puerto_destino]', 
					'$_POST[mercancia]', 
					'$_POST[etd]', 
					'$_POST[eta]', 
					'$_POST[n20]', 
					'$_POST[n40]', 
					'$_POST[n40hq]', 
					'$_POST[naviera]', 
					'$_POST[request_ship_date]', 
					'$_POST[exon_deposito]',
					'$_POST[exon_dropoff]',
					'$_POST[dias_libres]',
					'$_POST[val20gw]',
					'$_POST[val40gw]',
					'$_POST[val40Hqgw]',
					'$_POST[dias_libres_gw]',
					'$_POST[operativo]',
					'$_POST[asignacion]',
					'$_POST[rentabilidad]',
					'$_POST[agente]',
					'$_POST[idcustomer]',
					NOW(),
					'$_POST[recibido]',
					'$_POST[mbl]',
					'$_POST[emision_mbl]',
					'$_POST[factura]',
					'$_POST[fecha_fact]',
					'$_POST[fecha_conexion]',
					'$_POST[gastos_destino]',
					'$_POST[aduanaChk]',
					'$_POST[otmChk]',
					'$_POST[terrestreChk]'
				)";
				
			
				
        $exe = mysqli_query($link,$sql);
        if (!$exe)
            print ("<script>alert('No se pudo guardar el registro')</script>");
        else{
			crearAlerta("NULL",12,1,$_POST["number"]);
            print "<script>alert ('El registro ha sido guardado satisfactoriamente')</script>";
		}

        $sql2 = "SELECT LAST_INSERT_ID() ultimo FROM reporte_estado_cli";
        $exe2 = mysqli_query($link,$sql2);
        $row = mysqli_fetch_array($exe2);
        $idreporte_estado = $row['ultimo'];
		
		
		
		if($_POST["aduanaChk"] == "1")
			send_mail("aduana",$idreporte_estado);

		if($_POST["otmChk"] == "1")
			send_mail("otm",$idreporte_estado);

		if($_POST["terrestreChk"] == "1")
			send_mail("terrestre",$idreporte_estado);
    }

    elseif ($filas > 0) {
        $sql2 = "select idreporte_estado,aduanaChk,otmChk,terrestreChk from reporte_estado_cli where idreporte_estado='$_GET[idreporte_estado]'";
        $exe2 = mysqli_query($link,$sql2);
        $row = mysqli_fetch_array($exe2);
        $idreporte_estado = $row['idreporte_estado'];
		
		
		//Valida si el la aduanaChk,otmChk o terrestreChk fueron camnbiados, de ser así enía el comunicado
		if($_POST["aduanaChk"] != $row["aduanaChk"] && $_POST["aduanaChk"] != "")
			send_mail("aduana",$idreporte_estado);

		if($_POST["otmChk"] != $row["otmChk"] && $_POST["otmChk"] != "")
			send_mail("otm",$idreporte_estado);

		if($_POST["terrestreChk"] != $row["terrestreChk"] && $_POST["terrestreChk"] != "")
			send_mail("terrestre",$idreporte_estado);

	
	
        $sql = "update reporte_estado_cli set 
					ref='$_POST[ref]',
					ref2='$_POST[ref2]', 
					hbl='$_POST[hbl]', 
					motonave='$_POST[motonave]', 
					deshabilitar='$_POST[deshabilitar]', 
					clasificacion='$_POST[clasificacion]', 
					idincoterm='$_POST[idincoterm]', 
					aduana='$_POST[aduana]', 
					numshipping='$_POST[numshipping]', 
					number='$_POST[number]', 
					shipper='$_POST[shipper]', 
					peso='$_POST[peso]', 
					volumen='$_POST[volumen]', 
					puerto_origen='$_POST[puerto_origen]', 
					puerto_destino='$_POST[puerto_destino]', 
					mercancia='$_POST[mercancia]', 
					etd='$_POST[etd]', 
					eta='$_POST[eta]', 
					n20='$_POST[n20]', 
					n40='$_POST[n40]', 
					n40hq='$_POST[n40hq]', 
					naviera='$_POST[naviera]', 
					request_ship_date='$_POST[request_ship_date]', 
					exon_deposito='$_POST[exon_deposito]' ,
					exon_dropoff='$_POST[exon_dropoff]' ,
					dias_libres='$_POST[dias_libres]' ,
					dias_libres_gw='$_POST[dias_libres_gw]' ,
					val20gw = '$_POST[val20gw]',
					val40gw = '$_POST[val40gw]',
					val40Hqgw = '$_POST[val40Hqgw]',
					operativo='$_POST[operativo]' ,
					asignacion='$_POST[asignacion]' ,
					rentabilidad='$_POST[rentabilidad]' ,
					agente='$_POST[agente]' ,
					servicio_cliente='$_POST[idcustomer]',";
					
					$sql .= ($_POST['rdo_operativo']) ? "rdo_operativo='".date("Y-m-d H:i:s")."'," : "";
					$sql .= ($_POST['entrega_sc']) ? "entrega_sc='".date("Y-m-d H:i:s")."'," : "";
					
					$sql .= 
					"recibido='$_POST[recibido]',
					mbl='$_POST[mbl]',
					emision_mbl='$_POST[emision_mbl]',
					no_factura='$_POST[factura]',
					fecha_factura='$_POST[fecha_fact]',
					fecha_conexion='$_POST[fecha_conexion]',
					gastos_destino='$_POST[gastos_destino]',
					emision_hbl='$_POST[emision_hbl]',
					status='$_POST[status]',
					aduanaChk = '$_POST[aduanaChk]',
					otmChk = '$_POST[otmChk]',
					terrestreChk = '$_POST[terrestreChk]'
				where idreporte_estado='$_GET[idreporte_estado]' and idcliente='$_GET[idcliente]'";
        $exe = mysqli_query($link,$sql);
        if (!$exe)
            print ("<script>alert('No se pudo guardar el registro')</script>");
        else{

			//Genera el nuevo status y direcciona al formulario de envío si se selecciona alguno de los comunicados automaticos de los botones de la cabecera
			if($_POST['msgAut'] != ""){
				//Obtiene el nuevo status de la base de datos
				include("re_flete_cli_AddStd.php");
				$descripcion = $Estados[0];
				

				//Envía mensaje de texto
					//Obtiene numeros de telefono
					$sqlCel = "select celular from contactos_todos where idcliente = ".$_GET["idcliente"]." and comunicadoSms = 1";
					$qryCel = mysqli_query($link,$sqlCel);
					

					
					if($Estados[1] != "" && sizeof($qryCel) > 0){ //si tiene estado y numero de celular para enviar

						while($celular = mysqli_fetch_array($qryCel)){
							if($celular[0] != "")
								$destino .= "57".$celular[0].",";
						}

						$destino = substr($destino,0,strlen($destino)-1);
						
						//if($_POST["clasificacion"] == "fcl"){ //Temporalmente envia solo a cargas fcl

							$resp= sendSMS($destino, "$Estados[1]", false);
							
							if (!$resp)
								print "<script>alert('SMS enviado a ".$destino."')</script>";
							else
								echo strstr($resp,"ERROR");
						//}
						
					
						
					}
			

				$newEstado = "insert into estados_cli (
									idreporte_estado,
									tipo,
									fecha,
									hora,
									descripcion,
									idusuario
							   )values(
									".$_GET['idreporte_estado'].",
									'maritimo',
									'".date("Y-m-d")."',
									'".date("H:i:s")."',
									\"$descripcion\",
									".$_SESSION["numberid"]."
							   )";

				if(!mysqli_query($link,$newEstado)){
					echo "No Creó el nuevo estado<br>".mysqli_error();
					die();
				}
				$_GET['sendAut'] = "true"; //Para que se direccione al envio del comunicado

			}

			
	         print "<script>alert ('El registro ha sido guardado satisfactoriamente!')</script>";
		}

        $sql2 = "select idreporte_estado,aduanaChk,otmChk,terrestreChk from reporte_estado_cli where idreporte_estado='$_GET[idreporte_estado]'";
        $exe2 = mysqli_query($link,$sql2);
        $row = mysqli_fetch_array($exe2);
        $idreporte_estado = $row['idreporte_estado'];
		
		
    }

	$_GET['idreporte_estado'] = ($_GET['idreporte_estado']) ? $_GET['idreporte_estado'] : $idreporte_estado;
	
	
	//ALMACENA LOS CONTENEDORES, borrando primero los que ya existen y luego los vuelve a crear
	if($_REQUEST['contenedor']){ //si hay contenedores 
		$delContenedor = mysqli_query($link,"delete from contenedores where idreporte_estado = ".$_GET['idreporte_estado']);
		if($delContenedor){ //si elimina
			$i=0;
			


			for($i=0 ; $i<=count($_REQUEST['contenedor'])-1 ; $i++ ){
				if($_REQUEST['contenedor'][$i] != ""){
					$insCont = "INSERT INTO `contenedores` (
									`idreporte_estado`, 
									`number`,
									`devuelto`,
									`tipo`
								) VALUES (
									".$_GET['idreporte_estado'].",
									'".$_REQUEST['contenedor'][$i]."',
									'".$_REQUEST['devuelto'][$i]."',
									'".$_REQUEST['tipoCont'][$i]."'
								);";
					mysqli_query($link,$insCont);
				}
			}
		}
	}
	
	
	//ALMACENA LOS NUEVOS ESTADOS
	//borra los existentes y crea nuevamente todos, esto para no confundir entre creacion y edicion


	//if(mysqli_query($link,"delete from estados_cli where idreporte_estado = ".$_GET['idreporte_estado'])){
		
		for($x = 0 ; $x<= count($_POST['descripcion']) - 1 ; $x++){
			
			$insEstado = "INSERT INTO `estados_cli` (
							`idreporte_estado` ,
							`tipo` ,
							`fecha` ,
							`hora` ,
							`descripcion`,
							idusuario
						)VALUES (
							'".$_GET['idreporte_estado']."', 
							'maritimo', 
							'".date("Y-m-d")."', 
							'".date("H").":".date("i").":00', 
							'".$_POST['descripcion'][$x]."',
							".$_SESSION["numberid"]."
							
							);";
			if(!mysqli_query($link,$insEstado)){
				echo "no almacenó la obervacion<br>".mysqli_error()."<br>$insEstado" ;die();
			}
			
			//almacena Liberacion si existe
			$lastId = mysqli_insert_id();
			if($_POST['liberacion'][$x] == "on"){
				$sqlLib = "update reporte_estado_cli set liberacion = ".$lastId." where idreporte_estado = ".$_GET['idreporte_estado'].";";
				//echo $sqlLib;die();
				if(!mysqli_query($link,$sqlLib)){
					echo "No almacenó la liberacion";die();
				}
			}

		}


	//}
	
	
    $estadosreportados = '';
    $estadosenviar = '';
    $nuevo = '';
	
	

    if ($estadosenviar = 'si') {
        $desde = 'comercial';
    }

    $ponerComa = false;
    $lista = "";
    for ($n = 0; $n < count($listaeli); $n++) {
        if ($listaeli[$n] != '') {
            if ($ponerComa == true)
                $lista = $lista . ',';
            $lista = $lista . $listaeli[$n];
            $ponerComa = true;
        }
    }


    //adjunto---------------------------------------------------------------------------------------------------------------

	//( sizeof($_FILES['formato_adjunto']["name"]) > 0 ) {
	//foreach($_FILES['formato_adjunto']["name"] as $adj){
	for($i=0; $i<= sizeof($_FILES['formato_adjunto']["name"])-1 ; $i++ ){
		if($_FILES['formato_adjunto']["name"][$i] != ""){
		//	if ($mueve = move_uploaded_file($_FILES['formato_adjunto']["tmp_name"][$i], "erpoperativo/formatos_adjunto/" .$_FILES['formato_adjunto']['name'][$i])) {
			if ($mueve = move_uploaded_file($_FILES['formato_adjunto']["tmp_name"][$i], "doc/doc_adjuntos/" .$_FILES['formato_adjunto']['name'][$i])) {
				$nombre = $_FILES['formato_adjunto']["name"][$i];
				
				if($_POST['adjunto_'.$i] == "")
					$estado = "comercial";
				else
					$estado = $_POST['adjunto_'.$i];
	
				
	
	
				$sql = "INSERT INTO formatos_adjunto (idreporte_estado, idusuario, nombre, fecha, tipo) VALUES ('$idreporte_estado', '$_SESSION[numberid]', '$nombre', NOW(), '$estado')";
	
				$exe = mysqli_query($link,$sql);
				if(!$exe){
					echo mysqli_error();
				}
			}
		}
	}


    //-------------------------------------------------------------------------------------------------------------------
	
	//Si $_GET['sendAut'] es verdadero, direcciona al envio del comunicado automaticamente, si no, direcciona al mismo form
	if($_GET['sendAut'] != "true"){
	    ?><script>document.location.href='<? print $_SERVER['PHP_SELF']; ?>?idcliente=<? print $_GET['idcliente']; ?>&idreporte_estado=<? print $idreporte_estado; ?>'</script><?
	}
}




if($_GET['idestado_cli']){
	if(mysqli_query($link,"delete from estados_cli where idestado = ".$_GET['idestado_cli']))
		echo "<script>alert('Registro Eliminado');window.location='re_flete_cli.php?idcliente=".$_GET['idcliente']."&idreporte_estado=".$_GET['idreporte_estado']."'</script>";
	else
		echo "'El registro no se eliminó, contacte al administrador'<br>";
}
?>



<form enctype="multipart/form-data" name="formulario" id="formulario" method="post">

	
    <input name="datosok" id="datosok" type="hidden" value="no" />
    <input name="deshok" type="hidden" value="no" />
    <input name="descuadrook" type="hidden" value="no" />
    <input name="notifycam" type="hidden" value="no" />
    <input type="hidden" name="lista_f" value="" />
    <input type="hidden" name="lista_h" value="" />
    <input type="hidden" name="lista_m" value="" />
    <input type="hidden" name="lista_d" value="" />
    <input type="hidden" name="listaeli" value="" />
    <input type="hidden" name="listaeli2" value="" />

    <?
    $sqlre = "select * from reporte_estado_cli where idreporte_estado='$_GET[idreporte_estado]'";

    $exere = mysqli_query($link,$sqlre);
    $datosre = mysqli_fetch_array($exere);
    ?>

    <table width="100%" align="center">	
        <?
        if ($_GET['exporta'] == 'si' && $_GET['preforma'] != 'si') {
            ?>
            <tr>
                <td align="left"><? include('./logo.php'); ?></td>
            </tr>
            <?
        }
        ?>
        <tr>

            <?
            $chargue = '';
            if ($_POST['clasificacion'] != '') {
                if ($_POST['clasificacion'] == 'aereo') {
                    $chargue = 'AEREA';
                } else {
                    $chargue = 'MARITIMA';
                }
            } else {
                if ($datosre['clasificacion'] == 'aereo') {
                    $chargue = 'AEREA';
                } else {
                    $chargue = 'MARITIMA';
                }
            }
            ?>
            <td class="subtitseccion" style="text-align:center"><strong>REPORTE DE ESTADO DE CARGA <? print $chargue; ?><? if ($_GET['idcot_temp'] != '')
                print ' ' . scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero"); ?></strong><br><br></td>
        </tr>
	</table>

	<div <? echo (puedo("l","REPORTES_ESTADO") ==1 && $_SESSION['perfil'] != "14" ) ? "" : "style='display:none'"; ?> >
		<table width="100%">
			<?
			if ($_GET['exporta'] != 'si' || $_GET['preforma'] == 'si') {
				$sql = "select * from formatos_adjunto where (tipo='comercial' or tipo = 'interno' or tipo ='agente' or tipo ='cliente') and idreporte_estado='$datosre[idreporte_estado]'";
				$exeft = mysqli_query($link,$sql);
				?>
				<tr>
					<td class="contenidotab" style="text-align:center">
						<table width="70%" align="center">
							<?
							while ($datosft = mysqli_fetch_array($exeft)) {
								if($datosft["tipo"] == "interno" || $datosft["tipo"] == "agente")
									$color = "#E2E2E2";
								else
									$color = "#FFFFFF";
								?>
								<tr bgcolor="<? echo $color;?>">
									<td class="contenidotab" style="text-align:center">
										<?
										$adjunto = str_replace("#","%23",$datosft['nombre']); //Reemplaza numeroal por %23 para poder ver el adjunto
										
										//Solo los administradores pueden ver los adjuntos internos, el resto solo verá el nombre para saber que ya se cargó
										if(($datosft["tipo"] == "interno" || $datosft["tipo"] == "agente") && $_SESSION['perfil'] == 1){?>
										<!--<a href="erpoperativo/formatos_adjunto/<? print $adjunto; ?>" target="_blank">-->
											<a href="doc/doc_adjuntos/<? print $adjunto; ?>" target="_blank">    
												<? print $datosft['nombre']; 
												echo ($datosft["tipo"] == "agente") ? "(Agente)" : "";
												?>
											</a>
										
										<?
										}elseif($datosft["tipo"] != "interno" && $datosft["tipo"] != "agente"){?>
										<!--<a href="erpoperativo/formatos_adjunto/<? print $adjunto; ?>" target="_blank">-->
											<a href="doc/doc_adjuntos/<? print $adjunto; ?>" target="_blank">    
												<? print $datosft['nombre']; 
												echo ($datosft["tipo"] == "cliente") ? "(Cliente)" : "";
												?>
											</a>
										
										<?
										}else{
											print $datosft['nombre']; 

										}
										?>

									</td>
									<? if ($_GET['preforma'] != 'si') { ?>
										<td class="contenidotab"><? print $datosft['fecha']; ?></td>
										<td class="contenidotab"><? print scai_get_name("$datosft[idusuario]", "vendedores_customer", "idusuario", "nombre"); ?></td>
										<td class="contenidotab"><a href="javascript: void(0)" onClick="validadjunto(formulario, '<? print $datosft['idformato']; ?>')"><img src="./images/borrar.png" border="0" width="20px"></a></td>
									<? } ?>
								</tr>
								<?
							}
							?>
						</table>
						<div id="contiene2" align="center" >
							
						</div>
					</td>
				</tr>
				<tr>
					<td class="contenidotab" valign="top" style="text-align:center"><div id="contiene2" align="center"></div>
				</tr>
				<?
			}
			?>
			<tr>
				<td class="contenidotab" style="text-align:center"><? if ($_GET['exporta'] != 'si') { ?>
					<a href="javascript: void(0)" class="contenidotab" style="color:#FF0000" onClick="addField2()"><strong>A&ntilde;adir Archivo(+)</strong></a>
					
					<? } ?>
				</td>
			</tr>
			<?
			if ($_GET['exporta'] != 'si') {
				?>
				<tr>
					<?
					$sql = "select distinct idreporte_estado from estados where idestado_cli in (select idestado from estados_cli where idreporte_estado='$datosre[idreporte_estado]')";
					//print $sql.'<br>';
					$exees = mysqli_query($link,$sql);
					$filase = mysqli_num_rows($exees);
					if ($datosre['idreporte_estado'] != '' && $filase > 0) {
						?>
		  <tr>
						<td class="subtitseccion" style="text-align:center; font-size:10px; color:#FF0000">Estos estados ya han sido adicionados a el(los) Shipping Instruction <?
				$e = 0;
				while ($datoses = mysqli_fetch_array($exees)) {
					if ($e > 0)
						print ', ';
					print scai_get_name("$datoses[idreporte_estado]", "reporte_estado", "idreporte_estado", "numshipping");
					$e++;
				}
						?>
							<br></td>
		  </tr>
					<?
				}
				?>
				<td class="subtitseccion" style="text-align:center; font-size:10px">Aca puedes ingresar la informaci&oacute;n del reporte de estado  del Shipping Instruction seleccionado<br><br></td>
				<tr>
					<td class="contenidotab" style="text-align:center; font-size:10px"><strong>Deshablitaci&oacute;n permanente Cuadro de Seguimientos</strong> 
						<?
						if ($_POST['deshabilitar'] != '')
							$seleccionado = $_POST['deshabilitar']; else
							$seleccionado = $datosre['deshabilitar'];
						?>&nbsp;
						<select id="deshabilitar" name="deshabilitar" onChange="desabilitarcuadro(formulario);">
							<option value="0" <? if ($seleccionado == '0')
							print 'selected'; ?>>NO</option>
							<option value="1" <? if ($seleccionado == '1')
									print 'selected'; ?>>SI</option>
						</select>
	
						<strong>Deshablitaci&oacute;n permanente Zona Clientes</strong> 
						<?
						if ($_POST['deshabilitarz'] != '')
							$seleccionado = $_POST['deshabilitarz']; else
							$seleccionado = $datosre['deshabilitarz'];
						?>&nbsp;
						<select id="deshabilitarz" name="deshabilitarz" onChange="desabilitarzona(formulario);">
							<option value="0" <? if ($seleccionado == '0')
									print 'selected'; ?>>NO</option>
							<option value="1" <? if ($seleccionado == '1')
									print 'selected'; ?>>SI</option>
						</select>
	
	
					</td>
				</tr>
	
						<?
					}
					?>
			<tr>
				<td class="contenidotab" style="text-align:right"><? if ($datosh['numero'] != '')
						print 'SHIPMENT ID: ' . $datosh['numero']; ?> </td>
			</tr>
		</table> 
	</div>
		<?

    if ($_GET['exporta'] != 'si') {
        ?>
		<!--Botones-->
		<input type="hidden" name="msgAut" id="msgAut">
        <table id="tbBotones">
            <tr>
				
                <td colspan="5" align="left"><table>
                  <tr>
                    <?
							if ($datosre['idreporte_estado'] != '' && (puedo("l","REPORTES_ESTADO") == 1)	) { 
								//MUESTRA BOTONES DE ACUERDO AL PERFIL, AL ADMINISTRADOR LE MUESTRA TODOS
								
								if($_SESSION['perfil'] == "12" || $_SESSION['perfil'] == "1"){ //Servicio al cliente?>
                    <td width="60" class="botonesadmin">
						
						<input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px" onClick="form.datosok.value='si';form.msgAut.value='agradecimiento_1'" value="AGRAD. 1">
					</td>
                    <td width="60" class="botonesadmin">
						<input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px" onClick="form.datosok.value='si';form.msgAut.value='agradecimiento_2'" value="AGRAD. 2">
					
					</td>
                    <td width="40" class="botonesadmin">
						<input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px;" onClick="form.datosok.value='si';form.msgAut.value='detalles_carga'" value="D. DE CARGA">
						
					</td>
                    <td width="60" class="botonesadmin">
						<input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px;" onClick="form.datosok.value='si';form.msgAut.value='booking'" value="BOOKING">
						
					</td>
                    <td width="60" class="botonesadmin">
						<input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px;" onClick="form.datosok.value='si';form.msgAut.value='pre_booking'" value="PRE-BOOKING">
					</td>
                    <td width="60" class="botonesadmin">
						<input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px;" onClick="form.datosok.value='si';form.msgAut.value='confirmacion_zarpe'" value="C. DE ZARPE">
					</td>
                    <?
					}
					if($_SESSION['perfil'] == "9" || $_SESSION['perfil'] == "1" || $_SESSION['perfil'] == "12"){ //Servicio al cliente;?>
                    	<td width="60" class="botonesadmin">
							<input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px;" onClick="form.datosok.value='si';form.msgAut.value='prealerta'" value="PREALERTA">
						</td>
						<td width="60" class="botonesadmin">
							<input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px;" onClick="form.datosok.value='si';form.msgAut.value='confirmacion_arribo'" value="C. DE ARRIBO">
						</td>
                    <? 
								
					}

					if($_SESSION['perfil'] == "15" || $_SESSION['perfil'] == "1"){ //Servicio al cliente;?>
						<td width="60" class="botonesadmin">
							<input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px;" onClick="form.datosok.value='si';form.msgAut.value='factura'" value="FACTURA">
						</td>
						<td width="60" class="botonesadmin">
							
							<input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px;" onClick="form.datosok.value='si';form.msgAut.value='factura_certificados'" value="FACT. Y CERT.">
							</td>
						<td width="60" class="botonesadmin">
							<input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px;" onClick="form.datosok.value='si';form.msgAut.value='cert_flete'" value="CERT. FLETES">
						</td>
						<td width="60" class="botonesadmin">
							<input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px;" onClick="form.datosok.value='si';form.msgAut.value='contenedores'" value="CONTENEDORES">
						</td>
						<td width="60" class="botonesadmin">
							<input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px;" onClick="form.datosok.value='si';form.msgAut.value='nota_credito'" value="N. CREDITO">
						</td>
						<?
					}
					if($_SESSION['perfil'] == "15" || $_SESSION['perfil'] == "1" || $_SESSION['perfil'] == "12"){?>
                    <td width="60" class="botonesadmin">
						<input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px;" onClick="form.datosok.value='si';form.msgAut.value='draft_hbl'" value="DRAFT HBL">
					</td>
                    <td width="60" class="botonesadmin">
						  <input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px;" onClick="form.datosok.value='si';form.msgAut.value='hbl_final'" value="HBL FINAL">
					  
					  </td>
					  
                    <?
								}
								?>
                    <?
							}
							?>
                    <td class="botonesadmin">
						  <input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px;" onClick="form.datosok.value='si';form.msgAut.value='seguro'" value="SEGURO">
					  
					  </td>
                  </tr>
                  <tr>
                    <td width="60" class="botonesadmin"><a href="seguimientos_cliente.php?idcliente=<? print $_GET['idcliente']; ?>" onClick="">Atras</a></td>
                    <td width="60" class="botonesadmin"><input name="submit" type="submit" class="botonesadmin" style="border-style:none;height:40px" onClick="form.datosok.value='si'" value="GUARDAR">                    
					<td width="60" class="botonesadmin">

						<input type="button" class="botonesadmin" style="border-style:none;height:40px" onClick="window.location='sel_cotizaciones.php'" value="REPORTE NEGOCIO">

					
					</td>
					<td width="60" class="botonesadmin">
						
						<input type="button" class="botonesadmin" style="border-style:none;height:40px" onClick="window.location='shipping_instruction.php?order_number=<?= $datosre['number'];?>'" value="SHIPPING INSTRUCTION">
					
					</td>
                    <td width="60" class="botonesadmin"><a href="#" onClick="formail.submit();">ENVIAR EMAIL</a> </td>
                  </tr>
                </table>
                  </td>        	
            </tr>
        </table>
    <?
    } elseif ($_GET['exporta'] == 'si' && $_GET['preforma'] == 'si') {
        ?>
        <table>
            <tr>
                <td colspan="5" align="left">
                    <table>
                        <tr>
                            <td width="60" class="botonesadmin"><a href="./zona_clientes/descargas.php?idcliente=<? print $_GET['idcliente']; ?>" onClick="">Atras</a></td>
							
                        </tr>
                    </table> 
                </td>        	
            </tr>
        </table>
        <?
    }
    ?>
		<br />
	<div <? echo ($_SESSION['perfil'] != "14" ) ? "" : "style='display:none'"; ?> >
		<table width="70%" align="center" border="<?
					if ($_GET['exporta'] == 'si')
						print '1'; else
						print '0';
					?>">
			<tr>
				<td class="tittabla" bgcolor='#a01313' style='text-align:center;color:#ffffff' colspan="2"><strong>DATOS DE LA CARGA</strong></td>
				<td class="tittabla" bgcolor='#a01313' style='text-align:center;color:#ffffff'><strong>MERCANCIA</strong></td>
			</tr>
			<tr>
				<td class="contenidotab">
					<strong>USUARIO: </strong>
				<?= scai_get_name($datosre['idusuario'],"usuarios", "idusuario", "nombre");?></td>
			  <td class="contenidotab"><strong>MODALIDAD</strong><?
					if ($_GET['exporta'] == 'si')
						print strtoupper($datosre['clasificacion']); else {
						if ($_POST['clasificacion'] != '')
							$comparador = $_POST['clasificacion']; 
						else
							$comparador = $datosre['clasificacion'];
						?>
	
						<select id="clasificacion" name="clasificacion" onChange="recargar(formulario);">
							<option value="N"> Seleccione </option>
							<option value="fcl" <? if ($comparador == 'fcl')
									print 'selected'; ?>> FCL </option>
							<option value="lcl" <? if ($comparador == 'lcl')
									print 'selected'; ?>> LCL </option>
							<option value="aereo" <? if ($comparador == 'aereo')
						print 'selected'; ?>> AEREO </option>
						</select>
					     <? } ?>
						 Muelle: 
						  <input type="text" id="aduana" name="aduana" value="<?
							   if ($_POST['aduana'] != '')
								   print $_POST['aduana']; else
								   print $datosre['aduana'];
							   ?>" size="10"/>
			  </td>
				<td class="contenidotab"><?
						   if ($_GET['exporta'] == 'si') {
							   if ($_POST['mercancia'] != '')
								   print $_POST['mercancia']; else
								   print $datosre['mercancia'];
						   } else {
							   ?><input type="text" id="mercancia" name="mercancia" value="<?
							   if ($_POST['mercancia'] != '')
								   print $_POST['mercancia']; else
								   print $datosre['mercancia'];
							   ?>" size="10"/><? } ?></td>
			</tr>
			<tr>
				<td class="contenidotab" valign="top">
					<table width="100%" align="center">	
						<tr>
							<td class="contenidotab"><strong>CLIENTE</strong></td>
							<td class="contenidotab"> <? print scai_get_name("$_GET[idcliente]", "clientes", "idcliente", "nombre"); ?></td>
						</tr>
						<tr>
							<td class="contenidotab"><strong>TARIFA NETA:</strong></td>
							<td class="contenidotab"> <? print scai_get_name($datosre['number'],"rn_fletes", "order_number", "total_neta"); ?></td>
						</tr>
						<tr>
							<td class="contenidotab"><strong>No. DE ORDEN</strong></td>
							<td class="contenidotab">
								<input type="text" id="number" class="tex1" name="number" value="<? print $datosre['number'];?>" size="5" required/>
								<?
								$sqlOper = "select numero from shipping_instruction where order_number = '".$datosre['number']."'";
								$qryOper = mysqli_query($link,$sqlOper);
								if(!$qryOper)
									echo "mal<br>".mysqli_error() ;
								if(mysqli_num_rows($qryOper) > 1 )
									echo "Varios registros para <strong>".$datosre['number']."</strong>";
								elseif(mysqli_num_rows($qryOper) == 1){
									$Oper = mysqli_fetch_array($qryOper);
									echo "Operación:". substr($Oper["numero"],0,2);
								}
								?>
							</td>
							</tr>
							<tr>
							<td class="contenidotab"><strong>INCOTERM:</strong></td>
							<?if ($_GET['exporta'] == 'si') {
									if ($_POST['idincoterm'] != '')
										print $_POST['idincoterm']; else
										print $datosre['idincoterm'];?><td>
			<!--		<input readonly type="text" class="tex1" id="incoterm" name="incoterm" value="<?
								if ($_GET['exporta'] == 'si') {
									if ($_POST['idincoterm'] != '')
										print $_POST['idincoterm']; else
										print $datosre['idincoterm'];
								};?>">-->
								<?
								
							/*	if ($_POST['incoterm'] != '')
										$comparador = $_POST['incoterm']; else
										$comparador = $datosre['incoterm'];
									if ($_GET['exporta'] == 'si')
										print scai_get_name("$comparador", "incoterms", "idincoterm", "codigo");
							*/	

								$icoterm = "select idincoterm from shipping_instruction where order_number ='" .$datosre['number']."'";
								$qryincot = mysqli_query($link,$icoterm);
								$cod = mysqli_fetch_array($qryincot);
							    $cod;
							    if($cod){
							    $sqlincot = "SELECT codigo FROM incoterms WHERE idincoterm = '".$cod['number']."'";
								$qryincot = mysqli_query($link,$sqlincot);
								print scai_get_name("$qryincot", "incoterms", "idincoterm", "codigo");
							    }
    					       	
							    		
    							?>
    							
    							</td><? }?>
						</tr>
						<tr>
							<td class="contenidotab"><strong>ETD</strong></td>
							<td class="contenidotab">
								<?
								if ($_GET['exporta'] == 'si') {
									if ($_POST['etd'] != '')
										print $_POST['etd']; else
										print $datosre['etd'];
								} else {
									?><input type="text" id="etd" class="tex1" name="etd" value="<?
									if ($_POST['etd'] != '')
										print $_POST['etd']; else
										print $datosre['etd'];
									?>" readonly  size="8"  onClick="return showCalendar('etd');"/><? } ?></td>
						</tr>
						<tr>
							<td class="contenidotab"><strong>ETA</strong></td>
							<td class="contenidotab">
									<?
									if ($_GET['exporta'] == 'si') {
										if ($_POST['eta'] != '')
											print $_POST['eta']; else
											print $datosre['eta'];
									} else {
										?><input type="text" id="eta" name="eta" class="tex1" value="<?
									if ($_POST['eta'] != '')
										print $_POST['eta']; else
										print $datosre['eta'];
										?>" readonly  size="8" onClick="return showCalendar('eta');"/><? } ?></td>
						</tr>
						<tr>
							<td class="contenidotab"><strong>FECHA CONEXIÓN </strong></td>
							<td class="contenidotab">
								<input type="text" id="fecha_conexion" name="fecha_conexion" class="tex1" value="<?
								if ($_POST['fecha_conexion'] != '')
									print $_POST['fecha_conexion']; else
									print $datosre['fecha_conexion'];
									?>" readonly  size="8" onClick="return showCalendar('fecha_conexion');"/>
							</td>
							
						</tr>
						<tr>
							<td class="contenidotab"><strong>ORIGEN</strong> </td>
							<td class="contenidotab">
									<?
									if ($_POST['puerto_origen'] != '')
										$comparador = $_POST['puerto_origen']; else
										$comparador = $datosre['puerto_origen'];
									if ($_GET['exporta'] == 'si')
										print scai_get_name("$comparador", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");
									else {
										?>
											<select id="puerto_origen" name="puerto_origen" class="tex1">
												<option value="N"> Seleccione </option>
											<?
											$es = "select * from aeropuertos_puertos where tipo='puerto' or tipo='aeropuerto' order by nombre";
											$exe = mysqli_query($link,$es);
											while ($row = mysqli_fetch_array($exe)) {
												$sel = "";
												if ($comparador == $row['idaeropuerto_puerto'])
													$sel = "selected";
												print "<option value='$row[idaeropuerto_puerto]' $sel>$row[nombre]</option>";
											}
											?>
											</select>
												<?
											}
											?>
							</td>
						</tr>															
						<tr>
							<td class="contenidotab"><strong>DESTINO</strong> </td>
							<td class="contenidotab">
								<?
								if ($_POST['puerto_destino'] != '')
									$comparador = $_POST['puerto_destino']; else
									$comparador = $datosre['puerto_destino'];
								if ($_GET['exporta'] == 'si')
									print scai_get_name("$comparador", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");
								else {
									?>
										<select id="puerto_destino" name="puerto_destino" class="tex1">
											<option value="N"> Seleccione </option>
										<?
										$es = "select * from aeropuertos_puertos where tipo='puerto' or tipo='aeropuerto' order by nombre";
										$exe = mysqli_query($link,$es);
										while ($row = mysqli_fetch_array($exe)) {
											$sel = "";
											if ($comparador == $row['idaeropuerto_puerto'])
												$sel = "selected";
											print "<option value='$row[idaeropuerto_puerto]' $sel>$row[nombre]</option>";
										}
										?>
										</select>
									<?
								}
								?>
							</td>
						</tr>
						<tr>
							<td class="contenidotab"><strong>REQUEST SHIP DATE</strong></td>

							<td class="contenidotab">
								<?
								if ($_GET['exporta'] == 'si') {
									if ($_POST['request_ship_date'] != '')
										print $_POST['request_ship_date']; else
										print $datosre['request_ship_date'];
								} else {
									?><input type="text" id="request_ship_date" class="tex1" name="request_ship_date" value="<?
									if ($_POST['request_ship_date'] != '')
										print $_POST['request_ship_date']; else
										print $datosre['request_ship_date'];
									?>" readonly  size="8"  onClick="return showCalendar('request_ship_date');"/><? } ?></td>

					<!--		<td class="contenidotab">
								<?
								if ($_GET['exporta'] == 'si') {
									if ($_POST['request_ship_date'] != '')
										print $_POST['request_ship_date'];
									else
										print $datosre['request_ship_date'];
								} else {
									?>
									<input type="text" id="request_ship_date" name="request_ship_date" class="tex1" value="<? echo ($_POST['request_ship_date'] != '') ? $_POST['request_ship_date'] :$datosre['request_ship_date'];?>" onClick="return showCalendar('request_ship_date');" readonly />
									
								<? } ?>
							</td>-->
						</tr>
						<tr>
							<td class="contenidotab">
							
							<?
							if ($_POST['clasificacion'] != '')
								$comparador = $_POST['clasificacion']; 
							else
								$comparador = $datosre['clasificacion'];?>							
							<strong> <? echo ($comparador =="aereo") ? "AEROLINEA" : "NAVIERA" ;?> </strong> <?
	
							?>
							</td>
							<td>
								<? 
								//Consulta tabla de agentes - Aerolineas
								$sqlNav = "select * from proveedores_agentes where 1 ";
								$sqlNav .= ($comparador == "aereo") ? "and tipo = 'aerolinea'" : " and tipo = 'naviera'";
								$qryNav = mysqli_query($link,$sqlNav);
								?>
								<select name="naviera" class="tex1">
									<option></option>
									<?
									while($naviera = mysqli_fetch_array($qryNav)){
										//Valida si la naviera está seleccionada
										if($datosre['naviera'] == $naviera["nombre"]){
											$sel = "selected='selected'";
											$tieneNav = true;
										}else
											$sel = "";?>
										<option <? echo $sel?> value="<? echo $naviera["nombre"];?>"><? echo $naviera["nombre"];?></option>
									<?
									}
									if( $tieneNav != true ){ //Si la naviera que existe no está en el listado de navieras
										?><option selected="selected" value="<? echo $datosre['naviera'];?>"><? echo $datosre['naviera'];?></option><?
									}
									?>
								</select>
							</td>
						</tr>
						

					<!--<tr>
							<td class="contenidotab"><strong>EXONERACIÓN DE DEPOSITO</strong></td>
							<td>
								<?
									   if ($_GET['exporta'] == 'si') {
										   if ($_POST['exon_deposito'] != '')
											   print $_POST['terminos_negociacion']; 
											else
											   print $datosre['exon_deposito'];
									   }else{ 
									   ?>
									   
									   	<select name="exon_deposito">
											<option></option>
											<option value="si" <? echo ($datosre['exon_deposito'] =="si") ? "selected='selected'" : ""; ?> >
												Si
											</option>
											<option value="no" <? echo ($datosre['exon_deposito'] =="no") ? "selected='selected'" : ""; ?> >
												No</option>
										</select>
									   	<?
										} ?>
							</td>
						</tr>-->
						
						
						<tr>
							<td class="contenidotab"><strong>EXONERACIÓN DE DEPOSITO</strong></td>
							<td class="contenidotab"><?
									   if ($_GET['exporta'] == 'si') {
										   if ($_POST['exon_deposito'] != '')
											   print $_POST['terminos_negociacion']; 
											else
											   print $datosre['exon_deposito'];
									   }else{ 
									   ?>
								<input type="radio" value="si" <? echo ($datosre['exon_deposito'] == "si") ? "checked='checked'" : ""; ?> name="exon_deposito">Si 
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" value="no" <? echo ($datosre['exon_deposito'] == "no") ? "checked='checked'" : ""; ?>  name="exon_deposito">No
							</td>
						</tr>

						
						<tr>
							<td class="contenidotab"><strong>EXONERACIÓN DROP - OFF</strong></td>
							<td class="contenidotab">
								<input type="radio" value="si" <? echo ($datosre['exon_dropoff'] == "si") ? "checked='checked'" : ""; ?> name="exon_dropoff">Si 
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" value="no" <? echo ($datosre['exon_dropoff'] == "no") ? "checked='checked'" : ""; ?>  name="exon_dropoff">No

							</td>	<?
										} ?>
						</tr>
						<tr>
							<td class="contenidotab"><strong>DIAS LIBRES</strong></td>
							<td class="contenidotab">
								Nav:
								<input type="text" name="dias_libres" value="<? echo $datosre['dias_libres'] ; ?>" class="numerico" style="width:40px">
								KGN:
								<input type="text" name="dias_libres_gw" value="<? echo $datosre['dias_libres_gw'] ; ?>" class="numerico" style="width:40px"><br>
							</td>
						</tr>
						<tr class="contenidotab">
								<td><strong>VALOR CONTENEDOR:</strong></td>    
								<td> 20:<input type="text" value="<?= $datosre['val20gw']?>" name="val20gw" class="numerico" style="width:40px"> 
									 40:<input type="text" value="<?= $datosre['val40gw']?>" name="val40gw" class="numerico" style="width:40px"> 
									 40Hq:<input type="text" value="<?= $datosre['val40Hqgw']?>" name="val40Hqgw" class="numerico" style="width:40px"> 
								</td>
					  </tr>
						<tr>
							<td class="contenidotab"><strong>ASIGNACION</strong></td>
							<td>
								<select name="asignacion" class="tex1">
									<option></option>
									<option <? echo ($datosre["asignacion"] == "FHC") ? "selected='selected'" : "" ;?> >FHC</option>
									<option <? echo ($datosre["asignacion"] == "NOMINACION") ? "selected='selected'" : "" ;?>>
										NOMINACION</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="contenidotab"><strong>AGENTE</strong></td>
							<td class="contenidotab">
								<?
								//Trae el agente de la cotizacion
								if($datosre["clasificacion"] != "aereo"){
									$sqlAge = "
									SELECT * FROM `proveedores_agentes` where  idproveedor_agente  = (
										select idagente from tarifario where idtarifario = (
											select idtarifario from cot_fletes where idcot_fletes = (
												select idcot_fletes from rn_fletes where order_number = '".$datosre["number"]."' 
											)
										)
									)";
								}else{
									$sqlAge = "
									SELECT * FROM `proveedores_agentes` where  idproveedor_agente  = (
										select idagente from tarifario_aereo where idtarifario_aereo = (
											select idtarifario_aereo from cot_fletes_aereo where idcot_fletes_aereo = (
												select idcot_fletes_aereo from rn_fletes_aereo where order_number = '".$datosre["number"]."' 
											)
										)
									)";
								}

							$qryAge = mysqli_query($link,$sqlAge);

							if($datosre["number"] == ""){
								echo "";
							}else if(mysqli_errno() == "1242"){
								echo "Existe mas de un registro con el numero de orden <strong>".$datosre["number"]."</strong>";
							}else{
								$agente = mysqli_fetch_array($qryAge);
								echo $agente["nombre"]; /*
								?><input type="text" name="agente" value="<? echo $agente["nombre"]; ?>" class="tex1" readonly=""><?
								
								
							   if ($_GET['exporta'] == 'si') {
								   if ($_POST['agente'] != '')
									   print $_POST['agente']; else
									   print $datosre['agente'];
							   } else {?>
									<input type="text" name="agente" value="<? echo $datosre['agente']; ?>" class="tex1"><? 
								} */
							}				
							?>	
							</td>
						</tr>
						<tr class="contenidotab">
							<td class="contenidotab"><strong>OPERATIVO ASIGNADO</strong></td>
<!--							<td>
								<? $qry_oper = mysqli_query($link,"select * from usuarios where idperfil = 3"); ?>
								<select name="operativo" class="tex1">
									<option></option>
									<? while($operativo = mysqli_fetch_array($qry_oper)){?>
										<option value="<? echo $operativo["idusuario"] ?>" <? echo ($operativo["idusuario"] == $datosre["operativo"]) ? "selected='selected'" : "" ?>>
											<? echo $operativo["nombre"]." ".$operativo["apellido"]; ?></option>
									<? }?>
								</select>
							</td>-->
							<td><? $idoperativo = scai_get_name("$_GET[idcliente]", "clientes", "idcliente", "idoperativo"); 
									echo scai_get_name($idoperativo, "vendedores_customer", "idvendedor_customer", "nombre");
							?>
							</td>
						</tr>
						<tr class="contenidotab">
							<td class="contenidotab"><strong>SERVICIO AL CLIENTE</strong></td>
<!--							<td>
								<select id="idcustomer" name="idcustomer" class="tex1"  >
								<?
								$es = "select * from vendedores_customer order by nombre";
								$exe=mysqli_query($link,$es);
								while($row=mysqli_fetch_array($exe)){?>
									<option value='<? echo $row["idvendedor_customer"]?>' <? echo ($row["idvendedor_customer"] == $datosre["servicio_cliente"]) ? "selected='selected'" : ""?>>
										<? echo $row["nombre"]?>
									</option><?
								}
								?>
							</select>
							</td>-->
							<td><? $idcustomer = scai_get_name("$_GET[idcliente]", "clientes", "idcliente", "idcustomer"); 
									echo scai_get_name($idcustomer, "vendedores_customer", "idvendedor_customer", "nombre");
							?>
							</td>
						</tr>
						<tr class="contenidotab">
							<td class="contenidotab"><strong>COMERCIAL</strong></td>
							<td><? $idVendedor = scai_get_name("$_GET[idcliente]", "clientes", "idcliente", "idvendedor"); 
									echo scai_get_name($idVendedor, "vendedores_customer", "idvendedor_customer", "nombre");
							?>
							</td>
						</tr>
						<tr class="contenidotab">
							<td class="contenidotab"><strong>RENTABILIDAD</strong></td>
							<td class="contenidotab">
								<?
								//Muestra la rentabilidad solo financiero y admin
								if($_SESSION['perfil'] == "1" || $_SESSION['perfil'] == "15") {?>
									<input type="text" class="numerico" name="rentabilidad" value="<?= $datosre["rentabilidad"]?>">
								<?
								}else{?>
									<input type="hidden" class="numerico" name="rentabilidad" value="<?= $datosre["rentabilidad"]?>">
								<?
								}
								?>
							</td>
						</tr>
					</table>
				</td>
			  <td class="contenidotab" colspan="2" valign="top">
			    <table width="100%" align="center">	
						<tr>
							<td width="100" class="contenidotab"><strong>SHIPPER </strong> &nbsp;</td>
						    <td width="100" class="contenidotab"><?
								if ($_GET['exporta'] == 'si') {
									if ($_POST['shipper'] != '')
										print $_POST['shipper']; else
										print $datosre['shipper'];
								} else {
									?>
									<!--
						      <input type="text" id="shipper" name="shipper" value="<?
								if ($_POST['shipper'] != '')
									print $_POST['shipper']; else
									print $datosre['shipper'];
								?>" class="tex1"/>-->
								<?
								//Muestra todos los shipper creados en la db
								$sqlShipCli = "select 
													shipper.nombre as nombre,
													shipper.id as id
												from shipper 
												inner join shipperclientes as spc on spc.idCliente = shipper.idcliente
												where idCliente = ".$datosre['idcliente'];
								$sqlShipCli = "select 
													shipper.nombre as nombre, 
													shipper.id as id 
												from shipper 
												inner join shipperclientes as spc on spc.idShipper = shipper.id 
												where spc.idCliente =".$_GET["idcliente"];

								?>
								
								<select name="shipper" class="tex1">
									<!--Lo siguiente para los shipper que están creados  (digitados )no se pierdan valida si existe en la tabla shipper si no quiere decir que está digitado directamente en la table reporte_estado_cli y lo muestra-->
									<?
									//Busca el shipper del campo
									$qryShip = mysqli_query($link,"select * from shipper where id = ".$datosre['shipper']);
									
									if( mysqli_num_rows($qryShip) ==0 ){ //Echo si no lo encuentra en la db de shipper, muestra el que están en la db reporte_estado_cli
										?><option value="<?= $datosre['shipper']?>"><?= $datosre['shipper']?></option><?
									}else{
										$shipper = mysqli_fetch_array($qryShip);
										?><option value="<?= $shipper['nombre']; ?>"><?= $shipper['nombre']; ?></option><?
									}
									

									$qryShip = mysqli_query($link,$sqlShipCli);
									
									while( $shipper = mysqli_fetch_array($qryShip) ){
										?><option value="<?= $shipper['id']; ?>"><?= $shipper['nombre']; ?></option><?
									}
									
									?>
									
									
								</select>
								
								
								
					        <? } ?></td>
						</tr>
						<tr>
							<td width="100" class="contenidotab"><strong>KG</strong> </td>
						    <td width="100" class="contenidotab"><?
							if ($_GET['exporta'] == 'si') {
								if ($_POST['peso'] != '')
									print $_POST['peso']; else
									print $datosre['peso'];
							} else {
								?>
						      <input type="text" id="peso" name="peso" value="<? echo $datosre['peso'];?>" class="numerico"/>
					        <? } ?></td>
						</tr>
						<tr>
							<td width="100" class="contenidotab"><strong>M3</strong> </td>
						    <td width="100" class="contenidotab"><?
								if ($_GET['exporta'] == 'si') {
									if ($_POST['volumen'] != '')
										print $_POST['volumen']; else
										print $datosre['volumen'];
								} else {
									?>
						      <input type="text" id="volumen" name="volumen" value="<? print $datosre['volumen'];?>" class="numerico" />
					        <? } ?></td>
						</tr>
						<tr>
							<td class="contenidotab">
							<?
							if ($_POST['clasificacion'] != '')
								$comparador = $_POST['clasificacion']; 
							else
								$comparador = $datosre['clasificacion'];?>
						  <strong><? echo ($comparador =="aereo") ? "N&Uacute;MERO DE VUELO" : "MOTONAVE" ;?></strong></td>
						    <td width="100" class="contenidotab"><?
							if ($_GET['exporta'] == 'si') {
								if ($_POST['motonave'] != '')
									print $_POST['motonave']; else
									print $datosre['motonave'];
							} else {
									?>
                              <input type="text" size="8" id="motonave" name="motonave" value="<?
								if ($_POST['motonave'] != '')
									print $_POST['motonave']; else
									print $datosre['motonave'];
									?>" class="tex1"/>
                            <? } ?></td>
						</tr>
						<tr>
							<td width="100" class="contenidotab"><strong>HBL - HAWB / EMISIÓN</strong></td>
					      <td width="100" class="contenidotab"><?
								if ($_GET['exporta'] == 'si') {
									if ($_POST['hbl'] != '')
										print $_POST['hbl']; else
										print $datosre['hbl'];
								} else {
									?>
						      <input type="text" id="hbl" name="hbl" value="<?
									   if ($_POST['hbl'] != '')
										   print $_POST['hbl']; else
										   print $datosre['hbl'];
									?>" class="tex2"/>
					        <? }  ?>
					        <select id="emision_hbl" name="emision_hbl" class="emision_hbl">
                              <option></option>
                              <option <? echo ($datosre['emision_hbl'] == "DESTINO") ? "selected='selected'" : ""?>  >DESTINO</option>
                              <option <? echo ($datosre['emision_hbl'] == "ORIGEN") ? "selected='selected'" : ""?>>ORIGEN</option>
                            </select></td>
						</tr>
						<tr>
							<td width="100" class="contenidotab">
								<? if($datosre['clasificacion'] == "fcl"){?>
									<strong>No Contenedor(<a href="#" onClick="addCont()"><small>Crear</small></a>) 
								<? }?>
							</strong></td>
							<td class="contenidotab">
								<? if($datosre['clasificacion'] == "fcl"){?>
									<!--
									<input type="text" id="ref2" name="ref2" value="<? print $datosre['ref2'];?>" class="tex1"/>-->
									<div id="contenedores" style="height:70px;overflow:scroll;"><?
										//Contenedores
										$sqlCont = "select * from contenedores where idreporte_estado = '".$_GET['idreporte_estado']."' and idreporte_estado != 0";
										$qryCont = mysqli_query($link,$sqlCont); 
										while($contenedor = mysqli_fetch_array($qryCont)){?>
											<div style="white-space:nowrap">
												Number:<input type="text" name="contenedor[]" value="<? echo $contenedor["number"];?>" class="contenedor">
												Tipo:
												<select name="tipoCont[]" class="contenedor">
													<option></option>
													<option <? echo ($contenedor["tipo"] == "20") ? "selected='selected'": ""?> >
														20</option>
													<option  <? echo ($contenedor["tipo"] == "40") ? "selected='selected'": ""?> >
														40</option>
													<option <? echo ($contenedor["tipo"] == "40Hq") ? "selected='selected'": ""?> >40Hq</option>
												</select>
												Devuelto:<input type="text" name="devuelto[]" value="<? echo $contenedor["devuelto"];?>" class="contenedor devuelto_cont" id="contenedor_<? echo $contenedor["idcontenedor"];?>" readonly>
												
											</div>
											<br>
										<?
										}
										?>
									</div><?
								}?>
							</td>
						</tr>
						<tr>
							<td class="contenidotab">
							    <strong>No. Manifiesto </strong></td>
						    <td class="contenidotab">
						      <input type="text" id="ref" name="ref" value="<? print $datosre['ref'];?>" class="tex1"/>
					        <br>
					        <?
									   if ($_GET['exporta'] == 'si') {
										   if ($_POST['ref2'] != '')
											   print $_POST['ref2']; else
											   print $datosre['ref2'];
									   } else {
									?>
					        
					        <? } ?></td>
						</tr>
						<tr>
							<td class="contenidotab"><strong>Recibido</strong></td>
							<td class="contenidotab"><input type="text" id="recibido" class="tex1" name="recibido" value="<?
									if ($_POST['recibido'] != '')
										print $_POST['recibido']; else
										print $datosre['recibido'];
									?>" readonly  size="8"  onClick="return showCalendar('recibido');"/></td>
						</tr>
						<tr>
							<td class="contenidotab"><strong>MBL / Emisión </strong></td>
						  <td class="contenidotab">
							<input type="text" id="mbl" name="mbl" value="<?
									if ($_POST['mbl'] != '')
										print $_POST['mbl']; else
										print $datosre['mbl'];
									?>" class="tex2"  />
							<select id="emision_mbl" name="emision_mbl" class="tex2">
                              <option></option>
                              <option <? echo ($datosre['emision_mbl'] == "DESTINO") ? "selected='selected'" : ""?>>DESTINO</option>
                              <option <? echo ($datosre['emision_mbl'] == "ORIGEN") ? "selected='selected'" : ""?>>ORIGEN</option>
                            </select></td>
						</tr>
						<tr>
							<td class="contenidotab"><strong>Numero/Fecha  Factura</strong></td>
						  <td class="contenidotab">
						  	<input type="text" id="factura" name="factura" value="<?
									if ($_POST['factura'] != '')
										print $_POST['factura']; else
										print $datosre['no_factura'];
									?>"  class="tex2"  />
						    <input type="text" id="fecha_fact" name="fecha_fact" value="<?
									if ($_POST['fecha_fact'] != '')
										print $_POST['fecha_fact']; else
										print $datosre['fecha_factura'];
									?>" readonly  class="tex2"  onClick="return showCalendar('fecha_fact');"/></td>
						</tr>
						<tr>
						  <td class="contenidotab"><strong>Radicación a Puerto </strong></td>
						  <td class="contenidotab">
						    <input type="text" id="gastos_destino" name="gastos_destino" value="<?
									if ($_POST['gastos_destino'] != '')
										print $_POST['gastos_destino']; else
										print $datosre['gastos_destino'];
									?>" readonly  class="tex1"  onClick="return showCalendar('gastos_destino');"/></td>
						</tr>
						<? if($_GET['idreporte_estado']){?>
							<tr>
							  <td class="contenidotab"><strong>Estado de la Operación</strong></td>
							  <td class="contenidotab">
									<input type="radio" value="Abierta" name="status" <? echo ($datosre['status'] == "Abierta") ? "checked='checked'" : ""?> > Abierta
									<input type="radio" value="Cerrada" name="status"  <? echo ($datosre['status'] == "Cerrada") ? "checked='checked'" : ""?>> Cerrada							  </td>
							</tr>
							<tr>
							  <td class="contenidotab"><strong>Recibido Operativo</strong></td>
							  <td class="contenidotab">
								  <? if($datosre['rdo_operativo'] == "0000-00-00 00:00:00"){ //si no está seleccionado?>
										<input type="checkbox" name="rdo_operativo" value="1" onClick="formulario.datosok.value='si';formulario.submit();">
									<? }else{
											echo $datosre['rdo_operativo'];
									}?>							  </td>
							</tr>
							<tr>
							  <td class="contenidotab"><strong>Entregado Sc</strong></td>
							  <td class="contenidotab">
								<? if($datosre['entrega_sc'] == "0000-00-00 00:00:00"){ //si no está seleccionado?>
									<input type="checkbox" name="entrega_sc" value="1" onClick="formulario.datosok.value='si';formulario.submit();">
								<? }else{
										echo $datosre['entrega_sc'];
								}?>							  </td>
							</tr>
						<?
						}
						if ($_POST['clasificacion'] == 'fcl' || ($datosre['clasificacion'] == 'fcl' && $_POST['clasificacion'] == '')) {
							?>
							<tr>
								<td colspan="2" class="contenidotab"><strong>TAMANO DE CONTENEDOR</strong><br>
	
								<?
								if ($_GET['exporta'] == 'si') {
									if ($_POST['n20'] != '' || $datosre['n20'] != '') {
										if ($_POST['n20'] != '')
											print $_POST['n20']; else
											print $datosre['n20']; print ' X 20<br>';
									}
								} else {
									?><input type="text" id="n20" name="n20" value="<?
									if ($_POST['n20'] != '')
										print $_POST['n20']; else
										print $datosre['n20'];
									?>" size="5"/><strong> X 20</strong><br><? } ?>
				
									<?
									if ($_GET['exporta'] == 'si') {
										if ($_POST['n40'] != '' || $datosre['n40'] != '') {
											if ($_POST['n40'] != '')
												print $_POST['n40']; else
												print $datosre['n40']; print ' X 40<br>';
										}
									} else {
										?><input type="text" id="n40" name="n40" value="<?
									if ($_POST['n20'] != '')
										print $_POST['n40']; else
										print $datosre['n40'];
										?>" size="5"/><strong> X 40</strong><br><? } 
										if ($_GET['exporta'] == 'si') {
											if ($_POST['n40hq'] != '' || $datosre['n40hq'] != '') {
												if ($_POST['n40hq'] != '')
													print $_POST['n40hq']; else
													print $datosre['n40hq']; print ' X 40HQ';
											}
										} else {
											?><input type="text" id="n40hq" name="n40hq" value="<?
									if ($_POST['n20'] != '')
										print $_POST['n40hq']; else
										print $datosre['n40hq'];
											?>" size="5"/><strong> X 40HQ</strong> <? } ?>											</td>
										<?
								}
								?>
				  </tr>
								<tr class="contenidotab">
									<td colspan="2">
										<? if($datosre['otmChk'] != "1"){?>
											<input type="checkbox" name="otmChk" value="1" onClick="formulario.datosok.value='si';formulario.submit();">
										<? }else{?>
											<input type="hidden" name="otmChk" value="1">
											<img src="./images/Check.jpg" width="15">
										<? }?>
										<strong>Otm</strong>									
									</td>
								</tr>
								<tr class="contenidotab">
									<td colspan="2">
										<? if($datosre['aduanaChk'] != "1"){?>
											<input type="checkbox" name="aduanaChk" value="1"  onClick="formulario.datosok.value='si';formulario.submit();">
										<? }else{?>
											<input type="hidden" name="aduanaChk" value="1" >
											<img src="./images/Check.jpg" width="15">
										<? }?>
										<strong>Aduana</strong>									</td>
								</tr>
								<tr class="contenidotab">
									<td colspan="2">
										<? if($datosre['terrestreChk'] != "1"){?>
											<input type="checkbox" name="terrestreChk" value="1" onClick="formulario.datosok.value='si';formulario.submit();">
										<? }else{?>
											<input type="hidden" name="terrestreChk" value="1">
											<img src="./images/Check.jpg" width="15">
										<? }?>
										<strong>Terrestre</strong>									</td>
								</tr>
				</table>
				

			  </td>
			</tr>    
		</table>
		<br />
	</div>
	
	 <? if ($_GET['exporta'] != 'si') { ?>
	 	<a href="javascript: void(0)" class="contenidotab" style="color:#FF0000" onClick="addField('general')">
			<strong>A&ntilde;adir Item(+)</strong></a><? 
	} ?>
    <table width="100%" align="center" border="<?
        if ($_GET['exporta'] == 'si')
            print '1'; else
            print '0';
            ?>" id='status' cellpadding="5">
        <tr>
            <td class="tittabla" bgcolor='#a01313' style='text-align:center;color:#ffffff' colspan="5">
			<strong>ESTADO DEL TRANSPORTE</strong></td>
        </tr>
        <tr>
            <td class="tittabla" bgcolor='#a01313' style='text-align:center;color:#ffffff'><strong>FECHA</strong></td>
			<td class="tittabla" bgcolor='#a01313' style='text-align:center;color:#ffffff'><strong>USUARIO</strong></td>
            <td class="tittabla" bgcolor='#a01313' style='text-align:center;color:#ffffff'><strong>HORA</strong></td>
            <td class="tittabla" bgcolor='#a01313' style='text-align:center;color:#ffffff'><strong>DESCRIPCI&Oacute;N</strong></td>
                <? if ($_GET['exporta'] != 'si') { ?><td class="contenidotab">Eliminar</td><? } ?>
        </tr>
		<?
		$sqle = "select * from estados_cli where idreporte_estado='$datosre[idreporte_estado]' and tipo='maritimo' order by fecha desc, hora desc";
		$exee = mysqli_query($link,$sqle);
		while ($datose = mysqli_fetch_array($exee)) {?>
            <tr>
                <td class="contenidotab" valign="top">
					   <!--<input type="hidden" id="idestado" name="idestado" value="<? print $datose['idestado']; ?>"/>-->
					  <? print $datose['fecha'];  ?>		
				</td>
				<td class="contenidotab" valign="top"><?= scai_get_name($datose['idusuario'],"usuarios", "idusuario", "nombre");?></td>
              <td class="contenidotab" valign="top">
                    <? print $datose['hora']; ?>                
			  </td>
                <td class="contenidotab" valign="top" width="600">
					<? print str_replace("\n","<br>",$datose['descripcion']) ;  ?>			
				</td>
				<? if ($_GET['exporta'] != 'si') { 
                	if(puedo("l","REPORTES_ESTADO") == 1){ ?>
						<td class="contenidotab" valign="top">
							<? 
							if($_SESSION['perfil'] == "1"){?>
								<a href="?idcliente=<? echo $_GET['idcliente']?>&idreporte_estado=<? echo $_GET['idreporte_estado']?>&idestado_cli=<? echo $datose["idestado"]?>" onClick=" return confirm('¿Realmente desea eliminar este registro?')">Eliminar</a>
						</td><? 
							}
					}
				} ?>
            </tr><?
        }
        if ($_GET['exporta'] != 'si') { ?>
            <tr>
            	<td class="contenidotab" valign="top" colspan="6"><div id="contiene" align="left"></div> </td>
			</tr> <?
         }?> 
    </table>
      
    <br />

       <? if ($_GET['preforma'] != 'si') { ?>
        <table width="100%" align="center">
            <tr>
                <td class="contenidotab">Agradezco su amable atenci&oacute;n  y cualquier inquietud al respecto, con gusto la atenderemos.<br /><br />
                    Cordialmente,<br />
                            <?
                            $sqlvend = "select idcustomer from clientes where idcliente='$_GET[idcliente]'";
                            $exevend = mysqli_query($link,$sqlvend);
                            $datosvend = mysqli_fetch_array($exevend);

                            $sqluse = "select idusuario,nombre from vendedores_customer where idvendedor_customer='$datosvend[idcustomer]'";
                            $exeuse = mysqli_query($link,$sqluse);
                            $datosp = mysqli_fetch_array($exeuse);

                            if ($datosp['idusuario'] != '')
                                $idusuario = $datosp['idusuario']; 
							else
                                $idusuario = $_SESSION['numberid'];
								

                            $sql_sign = "select * from usuarios where idusuario='$idusuario'";
                            $exe_sql_sign = mysqli_query($link,$sql_sign);
                            $row_exe_sql_sign = mysqli_fetch_array($exe_sql_sign);
							
							
                            $sql_sign2 = "select * from vendedores_customer where idusuario=$idusuario";
                            $exe_sql_sign2 = mysqli_query($link,$sql_sign2);
                            $row_exe_sql_sign2 = mysqli_fetch_array($exe_sql_sign2);


                            //print '<br><br>'.$row_exe_sql_sign['nombre']." ".$row_exe_sql_sign['apellido'];
                            print '<br><br>' . $row_exe_sql_sign2['nombre'];
                         /*   print '<strong><br>' . scai_get_name("$row_exe_sql_sign2[idcargo]", "cargos", "idcargo", "nombre") . '</strong>';
                            print '<br>Address: ' . $row_exe_sql_sign2['direccion'];*/
                            print '<br>Phone: ' . $row_exe_sql_sign2['telefono'];
                            print '<br>Movil: ' . $row_exe_sql_sign2['celular'];
                            //print '<br>USA Phone: '.$row_exe_sql_sign2['telefono'];
                            print '<br>E-mail: ' . $row_exe_sql_sign2['email'];

                            $sqlpm = "select * from parametros where idparametro='32'";
                            //print $sqlpm.'<br>';
                            $exepm = mysqli_query($link,$sqlpm);
                            $cond = mysqli_fetch_array($exepm);
                            print '<br>Web site: ' . $cond['valor'];
                            ?>        
                </td>
            </tr>
        </table>
    <? } ?>
   
</form>
<?



?>
<form method="post" action="mail_alerta_cli.php?cliente=<? print $_GET['idcliente']; ?>&idreporte_estado=<? print $datosre['idreporte_estado']; ?>" name="formail" id="formail">
    <?
	/*
	<p style='color:#FF0000;text-align:center'>**PARA CUALQUIER  INQUIETUD Y/O SOLICITUD,  POR FAVOR ASEGURARSE DE RESPONDE CON COPIA A TODOS LOS CORREOS ELECTRONICOS  MENCIONADOS EN ESTE MENSAJE**</p>
	
	<table width='100%' align='center'>
		<tr>
			<td class='subtitseccion' style='text-align:center;color:#ffffff'><strong>REPORTE DE ESTADO DE CARGA " . $chargue . " " . scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero") . "</strong><br><br></td>
		</tr>	
		<tr>
			<td class='contenidotab' style='text-align:right'> SHIPMENT ID: " . $datosre['numero'] . "</td>
		</tr>
	</table>
	<br />
	*/
    $msg = "
    	<p style='color:#FF0000;text-align:center'><strong>
			***FAVOR NO RESPONDER A ESTE CORREO, PARA CUALQUIER INQUIETUD Y/O SOLICITUD, COMUNICARSE CON EL CONTACTO INFORMADO EN EL CUERPO DEL MENSAJE***</strong>
		</p>
	<table width='70%' align='center' border='1'>
		<tr>
			<td class='tittabla' bgcolor='#a01313' style='text-align:center;color:#ffffff' colspan='2'><strong>DATOS DE LA CARGA</strong></td>
			<td class='tittabla' bgcolor='#a01313' style='text-align:center;color:#ffffff'><strong>MERCANCIA</strong></td>
		</tr>
		<tr>
			<td class='contenidotab'></td>
			<td class='contenidotab'><strong>MODALIDAD</strong> " . strtoupper($datosre['clasificacion']) . "</td>
			<td class='contenidotab'>" . $datosre['mercancia'] . "</td>
		</tr>
		<tr>
			<td class='contenidotab' valign='top'>
				<table width='100%' align='center'>	
					<tr>
						<td class='contenidotab'><strong>CLIENTE</strong> " . scai_get_name("$datosre[idcliente]", "clientes", "idcliente", "nombre") . "</td>
					</tr>
					<tr>
						<td class='contenidotab'><strong>No. DE ORDEN</strong> " . $datosre['number'] . "</td>
					</tr>
					<tr>
						<td class='contenidotab'><strong>ETD</strong> " . $datosre['etd'] . "</td>
					</tr>
					<tr>
						<td class='contenidotab'><strong>ETA</strong> " . $datosre['eta'] . "</td>
					</tr>
					<tr>
						<td class='contenidotab'><strong>ORIGEN</strong> " . scai_get_name("$datosre[puerto_origen]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre") . "</td>
					</tr>
					 <tr>
						<td class='contenidotab'><strong>DESTINO</strong> " . scai_get_name("$datosre[puerto_destino]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre") . "</td>
					</tr>
					<tr>
						<td class='contenidotab'><strong>REQUEST SHIP DATE</strong> " . $datosre['request_ship_date'] . "</td>
					</tr>
	
					<tr>
					
						<td class='contenidotab'><strong>TERMINOS DE NEGOCIACION</strong> " . scai_get_name("$datosre[idincoterm]", "incoterms", "idincoterm", "codigo") . "</td>
					</tr>
				</table>
			</td>
			<td class='contenidotab' colspan='2' valign='top'>
				<table width='100%' align='center'>	
					<tr>
						<td class='contenidotab'><strong>SHIPPER </strong> "; 
						
							//Busca el shipper del campo
							$qryShip = mysqli_query($link,"select * from shipper where id = ".$datosre['shipper']);
							
							if( mysqli_num_rows($qryShip) ==0 ){ //Echo si no lo encuentra en la db de shipper, muestra el que están en la db reporte_estado_cli
								$msg .= $datosre['shipper'];
							}else{
								$shipper = mysqli_fetch_array($qryShip);
								$msg .= $shipper['nombre'];
							}
						
						
						$msg .= "</td>
					</tr>
					<tr>
						<td class='contenidotab'><strong>KG </strong>" . $datosre['peso'] . "</td>
					</tr>
					<tr>
						<td class='contenidotab'><strong>M3 </strong>" . $datosre['volumen'] . "</td>
					</tr>
			<tr>
				<td class='contenidotab'><strong>";
				$msg .= ($datosre['clasificacion'] =="aereo") ? " N&Uacute;MERO DE VUELO " : "MOTONAVE ";
	
				$msg .= "</strong>" . $datosre['motonave'] . "</td>
			</tr>
			<tr>
				<td class='contenidotab'><strong>HBL </strong>" . $datosre['hbl'] . "</td>
			</tr>
			
			<tr>
				<td class='contenidotab'><strong>No Contenedor</strong> ".$datosre['ref2'] . "</td>
			</tr>
					<tr>
				<td class='contenidotab'><strong>No Manifiesto</strong> ".$datosre['ref'] . "</td>
			</tr>
					";
		if ($_POST['clasificacion'] == 'fcl' || ($datosre['clasificacion'] == 'fcl' && $_POST['clasificacion'] == '')) {
			$msg .= "<tr>
							<td class='contenidotab'><strong>TAMANO DE CONTENEDOR</strong><br>";
			if ($datosre['n20'] != '')
				$msg .= $datosre['n20'] . " X 20<br>";
			if ($datosre['n40'] != '')
				$msg .= $datosre['n40'] . " X 40<br>";
			if ($datosre['n40hq'] != '')
				$msg .= $datosre['n40hq'] . " X 40HQ";
			$msg .= "</td>
						</tr>";
		}
		$msg .= "
				</table>
			</td>
		</tr>    
	</table>
	<br />

	<table width='100%' align='center' border='1'>
		<tr>
			<td class='tittabla' bgcolor='#a01313' style='text-align:center;color:#ffffff' colspan='";
		if ($_GET['exporta'] == 'si')
			$msg .='3'; else
			$msg .='4'; $msg .="'><strong>ESTADO DEL TRANSPORTE</strong></td>
		</tr>
		<tr>
			<td class='tittabla' bgcolor='#a01313' style='text-align:center;color:#ffffff'><strong>FECHA</strong></td>
			<td class='tittabla' bgcolor='#a01313' style='text-align:center;color:#ffffff'><strong>HORA</strong></td>
			<td class='tittabla' bgcolor='#a01313' style='text-align:center;color:#ffffff'><strong>DESCRIPCION</strong></td>       
		</tr>";
	
		$sqle = "select * from estados_cli where idreporte_estado='$datosre[idreporte_estado]' and tipo='maritimo' order by fecha desc, hora desc";
		$exee = mysqli_query($link,$sqle);
		
		while ($datose = mysqli_fetch_array($exee)) {
			$msg .= "
			<tr>
				<td class='contenidotab' valign='top'>" . $datose['fecha'] . "</td>
				<td class='contenidotab' valign='top'>" . $datose['hora'] . "</td>
				<td class='contenidotab' valign='top'>" . nl2br($datose['descripcion']) . "</td>
			</tr>";
		}
	
	
	
	
		$msg .= "
	</table>
	<table width='100%' align='center'>
		<tr>
			<td class='contenidotab'>Agradezco su amable atencion y cualquier inquietud al respecto, con gusto la atenderemos.<br /><br />
			Cordialmente,<br />";
	
		if ($datosp['idusuario'] != '')
			$idusuario = $datosp['idusuario']; else
			$idusuario = $_SESSION['numberid'];
		$sql_sign = "select * from usuarios where idusuario='$idusuario'";
		$exe_sql_sign = mysqli_query($link,$sql_sign);
		$row_exe_sql_sign = mysqli_fetch_array($exe_sql_sign);
	
		$sql_sign2 = "select * from vendedores_customer where idusuario='$row_exe_sql_sign[idusuario]'";
		$exe_sql_sign2 = mysqli_query($link,$sql_sign2);
		$row_exe_sql_sign2 = mysqli_fetch_array($exe_sql_sign2);
	
		$msg .= '<br><br>' . $row_exe_sql_sign2['nombre'];
	/*	$msg .= '<strong><br>' . scai_get_name("$row_exe_sql_sign2[idcargo]", "cargos", "idcargo", "nombre") . '</strong>';
		$msg .= '<br>Address: ' . $row_exe_sql_sign2['direccion'];*/
		$msg .= '<br>Phone: ' . $row_exe_sql_sign2['telefono'];
		$msg .= '<br>Movil: ' . $row_exe_sql_sign2['celular'];
		$msg .= '<br>E-mail: ' . $row_exe_sql_sign2['email'];
	
		$sqlpm = "select * from parametros where idparametro='32'";
		$exepm = mysqli_query($link,$sqlpm);
		$cond = mysqli_fetch_array($exepm);
		$msg .= '<br>Web site: ' . $cond['valor'];
	
		$msg .= "</td>
		</tr>
	</table>";
	
	//logo---------------------------------------------------------------------------------------------------------------------------
/*$logo = "
			<table width='100%' align='center' style='border-collapse: collapse; border: 4px solid orange;'>
				<tr>
					<td align='left' width='40%'>
						<p style='text-align: center; font-size:8pt; font-weight: bold;'>Este espacio fue diseñado para nuestros asociados de negocio, si desea pautar con nosotros, contáctenos al PBX (571) 8050075 Adriana Arias</p>
					</td>
					<td align='left'>
						<a href='http://www.distrielectricosje.com'><img src='http://190.158.236.5/gateway/images/logo_complementario.jpg' border='0' height='75' style='margin-right: 5px;' /></a>
						<a href='http://newline.com.co/'><img src='http://190.158.236.5/gateway/images/logo_complementario_2.png' border='0' height='75' style='margin-right: 5px;' /></a>
					</td>
				</tr>
			</table><br />
			";
	*/$logo .= "
	<table width='100%' align='center'>
		<tr>
			<td align='left'>
				<img src='http://appkigen.co/demo/images/logo.png' border='0' width='198' height='60' />
			</td>
		</tr>
	</table>";
    $msg = $logo . $msg;
	
	
	
    ?>
    
    <input type="hidden" name="msg" value="<? print $msg; ?>" />
    <input type="hidden" id="asunto" name="asunto" value="KIGEN - REPORTE DE CARGA <? print $chargue ?>" />
    <input type="hidden" id="shipment_id" name="shipment_id" value="<? print $datosh['numero']; ?>" />
    <input type="hidden" name="no_orden" id="no_orden" value="<?
    if ($_POST['number'] != '')
        print $_POST['number']; else
        print $datosre['number'];
    ?>"/>
	<?
	$idShipper = (int)$datosre['shipper'];
	if($idShipper > 0)
		$shipper = scai_get_name($idShipper,"shipper","id","nombre");
	else
		$shipper = $datosre['shipper'];
	?>
    <input type="hidden" name="nom_shipper" id="nom_shipper" value="<?= $shipper;?>"/>
    <input type="hidden" id="fuente" name="fuente" value="re_flete_cli.php?idcliente=<? print $_GET['idcliente']; ?>&idreporte_estado=<? print $_GET['idreporte_estado']; ?>">
</form>

	<?
	if($_GET['sendAut'] == "true"){
	?><script>
		formail.submit();
	</script><?
	}
	?>

</body>
</html>