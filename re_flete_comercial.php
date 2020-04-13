<?
if($_GET['preforma']!='si') 
include('../sesion/sesion.php');
include("../conection/conectar.php");	
include_once("../permite.php");
include_once("scripts/recover_nombre.php");


$_GET['idcot_temp'] = ""; 

$decision=substr($_GET['numshipping'], 0,1);
$table='';
if($decision==4){
	$table='shipping_instruction';
	$idsh='idshipping_instruction';
}
if($decision==6){
	$table='shipping_instruction_adu';
	$idsh='idshipping_instruction_adu';
}
if($decision==9){
	$table='shipping_instruction_bod';
	$idsh='idshipping_instruction_bod';
}
if($decision==7){
	$table='shipping_instruction_otm';
	$idsh='idshipping_instruction_otm';
}

if($decision==8){
	$table='shipping_instruction_seg'; 
	$idsh='idshipping_instruction_seg';
}

if($decision==5){
	$table='shipping_instruction_terrestre';
	$idsh='idshipping_terrestre';
}

if($decision==3){
	$table='shipping_instruction';
	$idsh='idshipping_instruction';
}

$_GET['idcot_temp'] = scai_get_name("$_GET[idshipping]","$table","$idsh","idreporte");


if($_GET['name']=='')
	$name=str_replace("{file_name}", $_GET['idcot_temp'], scai_get_name("nombre_archivo_rep_estado","parametros","nombre","valor"));
$name=str_replace(' ','_', $name);

if($_GET['exporta']=='si')
{
	if($_GET['preforma']!='si')
	{
		Header("Content-Disposition: inline; filename=$name.doc");
		Header("Content-Description: PHP3 Generated Data"); 
		Header("Content-type: application/vnd.ms-word; name='$name.doc'");//comenta esta linea para ver la salida en web
		flush;
	}
	else
	{
		print "<style type='text/css'>
		body,td,th
		{
			font-size: 11px;
		
		</style>";
	}
	?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?
}else{
	?>
    <link href="../css/admin_internas.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/main.js"></script>
	<script type="text/javascript" src="../js/shadowbox-base.js"></script>
	<script type="text/javascript" src="../js/shadowbox.js"></script>
	<script type="text/javascript" src="../js/jquery-1.2.6.pack.js"></script>
	<script type="text/javascript" src="../js/jquery-1.2.1.pack.js" ></script>
	<script type="text/javascript" src="../js/funciones.js"></script>
	<script type="text/javascript" src="../js/funcionesValida.js"></script>
	<script type="text/javascript" src="../js/calendar.js"></script>
	<script type="text/javascript" src="../js/calendar-en.js.js"></script>
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
    
    <? include('../scripts/scripts.php'); ?><script>
	
	function validadjunto(form, eli)
	{
		form.listaeli2.value = eli;
		form.submit()
	}
	
    function enviarCambio(form){
		 if (form.idestado != null){
			lista_id = '';
			lista_f = '';
			lista_h = '';
			lista_m = '';
			lista_d = '';
			listaeli = '';
			ponerComa = false;
			if(form.idestado.length <= 1 || form.idestado.length == null)
			{
				if(form.fecha.value != "")
				{
					if(form.fecha.value == '')
					{
						alert("Digite la fecha");
						form.fecha.focus();
						return false;
					}
					if(form.hora.value == 'N')
					{
						alert("Seleccione hora");
						form.hora.focus();
						return false;
					}
					if(form.minu.value == 'N')
					{
						alert("Seleccione minutos");
						form.minu.focus();
						return false;
					}    
					if(form.descripcion.value == '')
					{
						alert("Digite la descripcion");
						form.descripcion.focus();
						return false;
					}
					lista_id = form.idestado.value;
					lista_f = form.fecha.value;
					lista_h = form.hora.value;
					lista_m = form.minu.value;
					lista_d = form.descripcion.value;
		
					if (form.eliminar.checked)
						listaeli = form.eliminar.value;
				}
			}
			else
			{
				cantact = form.idestado.length;
				for(i=0; i<cantact; i++)
				{
					if(form.fecha[i].value != "")
					{
						if(form.fecha[i].value == '')
						{
							alert("Digite la fecha");
							form.fecha[i].focus();
							return false;
						}
						if(form.hora[i].value == 'N')
						{
							alert("Seleccione la hora");
							form.hora[i].focus();
							return false;
						}
						if(form.minu[i].value == 'N')
						{
							alert("Seleccione minutos");
							form.minu[i].focus();
							return false;
						}
						if(form.descripcion[i].value == '')
						{
							alert("Digite descripcion");
							form.descripcion[i].focus();
							return false;
						}
						
						if (ponerComa == true)
						{
							lista_id = lista_id + '|';
							lista_f = lista_f + '|';
							lista_h = lista_h + '|';
							lista_m = lista_m + '|';
							lista_d = lista_d + '|';						
							listaeli = listaeli + '|';
						}
						lista_id = lista_id + form.idestado[i].value;
						lista_f = lista_f + form.fecha[i].value;
						lista_h = lista_h + form.hora[i].value;
						lista_m = lista_m + form.minu[i].value;
						lista_d = lista_d + form.descripcion[i].value;
				
						if (form.eliminar[i].checked)
							listaeli = listaeli + form.eliminar[i].value;
						ponerComa = true;
					}
				}
			}
			form.lista_id.value = lista_id;
			form.lista_f.value = lista_f;
			form.lista_h.value = lista_h;
			form.lista_m.value = lista_m;
			form.lista_d.value = lista_d;
			form.listaeli.value = listaeli;		
		 }

		form.notifycam.value="si";
		form.submit()
    }

    function validaEnvia(form){
        if (form.idestado != null)
        {
            lista_id = '';
            lista_f = '';
            lista_h = '';
            lista_m = '';
            lista_d = '';
            listaeli = '';
            ponerComa = false;
			
            if(form.idestado.length <= 1 || form.idestado.length == null)
            {
                if(form.fecha.value != "")
                {
                    if(form.fecha.value == '')
                    {
                        alert("Digite la fecha");
                        form.fecha.focus();
                        return false;
                    }
                    if(form.hora.value == 'N')
                    {
                        alert("Seleccione hora");
                        form.hora.focus();
                        return false;
                    }
					if(form.minu.value == 'N')
                    {
                        alert("Seleccione minutos");
                        form.minu.focus();
                        return false;
                    }    
                    if(form.descripcion.value == '')
                    {
                        alert("Digite la descripcion");
                        form.descripcion.focus();
                        return false;
                    }
                    lista_id = form.idestado.value;
                    lista_f = form.fecha.value;
                    lista_h = form.hora.value;
                    lista_m = form.minu.value;
                    lista_d = form.descripcion.value;
        
                    if (form.eliminar.checked)
                        listaeli = form.eliminar.value;
                }
            }
            else
            {
                cantact = form.idestado.length;
                for(i=0; i<cantact; i++)
                {
                    if(form.fecha[i].value != "")
                    {
					
                        if(form.fecha[i].value == '')
                        {
                            alert("Digite la fecha");
                            form.fecha[i].focus();
                            return false;
                        }
                        if(form.hora[i].value == 'N')
                        {
                            alert("Seleccione la hora");
                            form.hora[i].focus();
                            return false;
                        }
						if(form.minu[i].value == 'N')
						{
							alert("Seleccione minutos");
							form.minu[i].focus();
							return false;
						}
                        if(form.descripcion[i].value == '')
                        {
                            alert("Digite descripcion");
                            form.descripcion[i].focus();
                            return false;
                        }
                        
                        if (ponerComa == true)
                        {
                            lista_id = lista_id + '|';
                            lista_f = lista_f + '|';
                            lista_h = lista_h + '|';
                            lista_m = lista_m + '|';
                            lista_d = lista_d + '|';						
                            listaeli = listaeli + '|';
                        }
						
                        lista_id = lista_id + form.idestado[i].value;
                        lista_f = lista_f + form.fecha[i].value;
                        lista_h = lista_h + form.hora[i].value;
                        lista_m = lista_m + form.minu[i].value;
                        lista_d = lista_d + form.descripcion[i].value;

                		<? if(puedo("l","REPORTES_ESTADO") == 1){ ?>
							if (form.eliminar[i].checked)
								listaeli = listaeli + form.eliminar[i].value;
						<? }?>
                        ponerComa = true;
                    }
					
                }
            }
		
            form.lista_id.value = lista_id;
            form.lista_f.value = lista_f;
            form.lista_h.value = lista_h;
            form.lista_m.value = lista_m;
            form.lista_d.value = lista_d;
            form.listaeli.value = listaeli;		
        }
        else
        {
            alert("Debe agregar por lo menos un estado");
            return false;
        }

        form.datosok.value="si";
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
    
    addField = function () {
        if(cantact<maximo)
        {
            container = d('contiene');

   	tr = c('tr');
	tr.id = 'fila' + (++numero);
            td = c('td');
            td.className = 'contenidotab';
            td.id = 'caja' + (++numero);
            td.align = 'center';
            td.valign ='top';
    
            field0 = c('input');
            field0.name = 'fecha';
            field0.id = 'fecha';
            field0.type = 'text';
            field0.value = '<? print date('Y-m-d'); ?>';
            
            select1 = c('select');
            select1.name = 'hora';
            select1.id = 'hora';
            opt0 = c('option');
            opt0.value = 'N';
            opt0.text =  'Hora';
            select1.appendChild(opt0);
            <?
            for($h=0; $h<=24; $h++)
            {
                ?>
                opt<? print ($h + 1); ?> = c('option');
                opt<? print ($h + 1); ?>.value = '<? print $h; ?>';
                opt<? print ($h + 1); ?>.text =  '<? print $h; ?>';
                select1.appendChild(opt<? print $h; ?>);
                <?
            }
            ?>
            
            select2 = c('select');
            select2.name = 'minu';
            select2.id = 'minu';
            opt0 = c('option');
            opt0.value = 'N';
            opt0.text =  'Min';
            select2.appendChild(opt0);
            <?
            for($h=0; $h<=60; $h++)
            {
                ?>
                opt<? print ($h + 1); ?> = c('option');
                opt<? print ($h + 1); ?>.value = '<? print $h; ?>';
                opt<? print ($h + 1); ?>.text =  '<? print $h; ?>';
                select2.appendChild(opt<? print $h; ?>);
                <?
            }
            ?>
            
            field3 = c('input');
            field3.name = 'descripcion';
            field3.id = 'descripcion';
            field3.type = 'text';
            field3.value = '';
            
            hidden0 = c('input');
            hidden0.name = 'idestado';
            hidden0.id = 'idestado';
            hidden0.type = 'hidden';
    
            hidden1 = c('input');
            hidden1.name = 'eliminar';
            hidden1.id = 'eliminar';
            hidden1.type = 'hidden';
    
            a = c('a');
            a.name = td.id;
            a.href = 'javascript: void(0)';
            a.onclick = removeField;
            a.innerHTML = 'Quitar';
            a.className="tex1";
            
            button0 = c('input');
            button0.name = 'calendario'
            button0.id = 'calendario';
            button0.type = 'button';
            button0.value = '...';
            button0.style.color = '#FFFFFF';
            //button0.onclick = return showCalendar(field0.name);
            //button0.onclick = showCalendar(field0.name);
            button0.className="botonesadmin";
            
	tr.appendChild(td);
            td.appendChild(field0);
            td.appendChild(button0);		
            td.appendChild(select1);	
            td.appendChild(select2);
            td.appendChild(field3);	
            td.appendChild(hidden0);
            td.appendChild(hidden1);
            td.appendChild(a);
            container.appendChild(tr);
            cantact++;
         }
    }
    removeField = function (evt) {
       lnk = f(e(evt));
       td = d(lnk.name);
       td.parentNode.removeChild(td);
       cantact--;
    }

	addField2 = function () {
        if(cantact<maximo)
        {
            container = d('contiene2');

   	tr = c('tr');
	tr.id = 'fila' + (++numero);
            td = c('td');
            td.className = 'contenidotab';
            td.id = 'caja' + (++numero);
            td.align = 'center';
            td.valign ='top';
    
            field0 = c('input');
            field0.name = 'formato_adjunto' + cantact;
            field0.id = 'formato_adjunto' + cantact;
            field0.type = 'file';
            field0.value = '';
            
            hidden0 = c('input');
            hidden0.name = 'idadjunto';
            hidden0.id = 'idadjunto';
            hidden0.type = 'hidden';
    
            hidden1 = c('input');
            hidden1.name = 'eliminar';
            hidden1.id = 'eliminar';
            hidden1.type = 'hidden';
    
            a = c('a');
            a.name = td.id;
            a.href = 'javascript: void(0)';
            a.onclick = removeField;
            a.innerHTML = 'Quitar';
            a.className="tex1";
            
	tr.appendChild(td);
            td.appendChild(field0);
            td.appendChild(hidden0);
            td.appendChild(hidden1);
            td.appendChild(a);
            container.appendChild(tr);
            cantact++;
         }
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
    </script>
    <?
}

if($_GET['exporta']=='si'){
	?><style type="text/css">
    body{
    font-family:<? print scai_get_name("exportar_word_fuente","parametros","nombre","valor");?>;
    font-size:<? print scai_get_name("exportar_word_tamano_fuente","parametros","nombre","valor");?>pt;
    }
    </style>
    <?
} 


if($decision==4 || $decision==7 || $decision==8){
	$_GET['idtarifario'] = scai_get_name("$_GET[idshipping]","$table","$idsh","idtarifario");
}
$_GET['cl'] = scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "clasificacion");
$order_number = scai_get_name("$_GET[idshipping]", "shipping_instruction", "idshipping_instruction", "order_number");


if($_POST['listaeli2']!=''){
	$sql = "delete from formatos_adjunto where idformato='$_POST[listaeli2]'";
	$exe = mysqli_query($link,$sql);
}

$idcliente = scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "idcliente");
$sql = "select * from reporte_estado_cli where number='$order_number' and idcliente='$idcliente'";
$exerc = mysqli_query($link,$sql);

/*	
while($datosrc = mysqli_fetch_array($exerc))
{
	$sql = "select * from reporte_estado where idshipping='$_GET[idshipping]' and numshipping='$_GET[numshipping]'";
	$exer = mysqli_query($link,$sql);
	$filasr = mysqli_num_rows($exer);

	if($filasr > 0)
	{
		$datosr = mysqli_fetch_array($exer);
		$idreporte_estado = $datosr['idreporte_estado'];

	}
	else
	{
		$sql = "INSERT INTO reporte_estado (ref, ref2,idshipping, numshipping, mercancia, etd, eta, motonave, hbl, naviera, request_ship_date, terminos_negociacion) values ('$datosrc[ref]','$datosrc[ref2]', '$id', '$numero', '$datosrc[mercancia]', '$datosrc[etd]', '$datosrc[eta]', '$datosrc[motonave]', '$datosrc[hbl]', '$datosrc[naviera]', '$datosrc[request_ship_date]', '$datosrc[terminos_negociacion]')";
		$exer = mysqli_query($link,$sql);
	
		$sql = "SELECT LAST_INSERT_ID() ultimo FROM reporte_estado";
		$exer = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($exer);
		$idreporte_estado = $row['ultimo'];
	}


	$exec = mysqli_query($link,$sql);

	$sql = "update estados set idreporte_estado='$idreporte_estado', descripcion=replace(descripcion, 'cvn_newstate_gate', '') where idestado_cli in (select idestado from estados_cli where idreporte_estado='$datosrc[idreporte_estado]') and idreporte_estado='$datosrc[idreporte_estado]' and descripcion like '%cvn_newstate_gate'";

	$exec = mysqli_query($link,$sql);

	$sql = "INSERT INTO estados (idestado_cli, idreporte_estado, tipo, fecha, hora, descripcion) (select idestado, '$idreporte_estado', tipo, fecha, hora, descripcion from estados_cli where idreporte_estado='$datosrc[idreporte_estado]' and idestado not in (select idestado_cli from estados where idreporte_estado='$idreporte_estado'))";
	$exec = mysqli_query($link,$sql);
	
	

	$sql = "insert into formatos_adjunto (idformato_comercial, idreporte_estado, idusuario, nombre, fecha, tipo) (select idformato, '$idreporte_estado', idusuario, nombre, fecha, 'operativo' from formatos_adjunto where idreporte_estado='$datosrc[idreporte_estado]' and tipo='comercial' and idformato_comercial='0' and idformato not in (select idformato_comercial from formatos_adjunto where idreporte_estado='$idreporte_estado'))";
	$exec = mysqli_query($link,$sql);
}*/



if($_POST['deshok']=='si'){
	$sql = "update reporte_estado set estado_zona='$_POST[deshabilitarz]' where idshipping='$_GET[idshipping]'";
	$exe= mysqli_query($link,$sql);
}

if($_POST['descuadrook']=='si'){
	$sql = "update reporte_estado set deshabilitar='$_POST[deshabilitar]' where idshipping='$_GET[idshipping]'";
	$exe= mysqli_query($link,$sql);
}



if($_POST['notifycam']=='si'){
	$lista_id = explode("|", $_POST['lista_id']);
	$lista_f = explode("|", $_POST['lista_f']);
	$lista_h = explode("|", $_POST['lista_h']);
	$lista_m = explode("|", $_POST['lista_m']);
	$lista_d = explode("|", $_POST['lista_d']);
	$listaeli = explode("|", $_POST['listaeli']);
	for($n=0; $n<count($lista_id); $n++)
	{
		if($lista_id[$n] != '')
		{
			$sql = "select idestado from estados where idestado='$lista_id[$n]'";
			//print $sql.'<br>';
			$exe = mysqli_query($link,$sql);
			$filas = mysqli_num_rows($exe);
			
			$hora = $lista_h[$n].":".$lista_m[$n].":00";
			
			if($filas == 0)
				$nuevo='si';

			$estadosreportados.="<tr><td>$lista_f[$n] - $hora</td><td>$lista_d[$n]</td></tr>";
			$estadosenviar='si';
			
		}
		elseif($lista_id[$n] == '')
		{
			$hora = $lista_h[$n].":".$lista_m[$n].":00";		
			$nuevo='si';
			$estadosreportados.="<tr><td>$lista_f[$n] - $hora</td><td>$lista_d[$n]</td></tr>";
			$estadosenviar='si';
		}
	}
	if($estadosenviar='si'){
		$desde='operativo';
		include('mail_notificacion_estado.php');
	}

}

if($_POST['datosok']=='si'){
	$lista_id = explode("|", $_POST['lista_id']);
	$lista_f = explode("|", $_POST['lista_f']);
	$lista_h = explode("|", $_POST['lista_h']);
	$lista_m = explode("|", $_POST['lista_m']);
	$lista_d = explode("|", $_POST['lista_d']);
	$listaeli = explode("|", $_POST['listaeli']);

	$sql = "select idreporte_estado from reporte_estado where idshipping='$_GET[idshipping]' and numshipping='$_GET[numshipping]'";

	$exe = mysqli_query($link,$sql);
	$filas = mysqli_num_rows($exe);
	
	if($_POST['deshabilitar']=='') $_POST['deshabilitar'] = '0';
	if($filas == 0){ //Crea
		$sql = "insert into reporte_estado (ref, ref2, deshabilitar, numshipping, idshipping, mercancia, etd, eta, n20, n40, n40hq, motonave, hbl, naviera, request_ship_date, terminos_negociacion) values('$_POST[ref]','$_POST[ref2]', '$_POST[deshabilitar]', '$_GET[numshipping]', '$_GET[idshipping]', '$_POST[mercancia]', '$_POST[etd]', '$_POST[eta]', '$_POST[n20]', '$_POST[n40]', '$_POST[n40hq]', '$_POST[motonave]', '$_POST[hbl]', '$_POST[naviera]','$_POST[request_ship_date]','$_POST[terminos_negociacion]')";
		$exe = mysqli_query($link,$sql);
		if(!$exe)
			print ("<script>alert('No se pudo guardar el registro')</script>");
		else
			print "<script>alert ('El registro ha sido guardado satisfactoriamente')</script>";
	
		$sql2 = "SELECT LAST_INSERT_ID() ultimo FROM reporte_estado";
		$exe2 = mysqli_query($link,$sql2);
		$row = mysqli_fetch_array($exe2);
		$idreporte_estado = $row['ultimo'];
	}
	
	elseif($filas > 0) //Edita
	{

		$sql = "update reporte_estado set ref='$_POST[ref]',ref2='$_POST[ref2]', deshabilitar='$_POST[deshabilitar]', mercancia='$_POST[mercancia]', etd='$_POST[etd]', eta='$_POST[eta]', n20='$_POST[n20]', n40='$_POST[n40]', n40hq='$_POST[n40hq]', motonave='$_POST[motonave]', hbl='$_POST[hbl]', naviera='$_POST[naviera]', request_ship_date='$_POST[request_ship_date]', terminos_negociacion='$_POST[terminos_negociacion]' where idshipping='$_GET[idshipping]'";
		//print $sql.'<br>';
		$exe = mysqli_query($link,$sql);
		if(!$exe)
			print ("<script>alert('No se pudo guardar el registro')</script>");
		else
			print "<script>alert ('El registro ha sido guardado satisfactoriamente!')</script>";
		
		$sql2 = "select idreporte_estado from reporte_estado where idshipping='$_GET[idshipping]' and numshipping='$_GET[numshipping]'";
		//print $sql.'<br>';
		$exe2 = mysqli_query($link,$sql2);
		$row = mysqli_fetch_array($exe2);
		$idreporte_estado = $row['idreporte_estado'];
	}
	//Almacena estados
	$estadosreportados='';
	$estadosenviar='';
	$nuevo='';

	for($n=0; $n<count($lista_id); $n++)	{
		$hora = $lista_h[$n].":".$lista_m[$n].":00";
		if($lista_id[$n] != '')//Edita los estados ya creados
		{
			$sql = "update estados set fecha='$lista_f[$n]', hora='$hora', descripcion='$lista_d[$n]' 
			where idestado='$lista_id[$n]'";
			$exe = mysqli_query($link,$sql);
			$estadosenviar='si';
		}
		elseif($lista_id[$n] == '') //Crea los nuevos estados en la db
		{
			$sql = "insert into estados (idreporte_estado, tipo, fecha, hora, descripcion) values('$idreporte_estado', 'maritimo', '$lista_f[$n]', '$hora', '$lista_d[$n]')";

			$exe = mysqli_query($link,$sql);			
			$nuevo='si';
			if($exe && $nuevo=='si'){

			$estadosreportados.="<tr><td>$lista_f[$n] - $hora</td><td>$lista_d[$n]</td></tr>";
			$estadosenviar='si';
			}
		}
	}

	if($estadosenviar='si'){
		$desde='operativo';
	}	

		
	$ponerComa = false;
	$lista = "";
	for ($n=0; $n<count($listaeli); $n++){
		if ($listaeli[$n] != '')
		{
			if ($ponerComa == true)
				$lista = $lista.',';
			$lista = $lista.$listaeli[$n];
			$ponerComa = true;
		}
	}
	if ($lista!='' or $lista!=NULL)
	{
		$sql = "delete from estados_cli where idestado in (select idestado_cli from estados where idestado in ($lista))";
		$exe = mysqli_query($link,$sql);

		$sql = "DELETE FROM estados WHERE idestado IN ($lista)";
		$exe = mysqli_query($link,$sql);
	}

	$order_number = scai_get_name("$_GET[idshipping]", "shipping_instruction", "idshipping_instruction", "order_number");

	$sql = "select * from reporte_estado_cli where number='$order_number'";
	$exe = mysqli_query($link,$sql);
	$filas = mysqli_num_rows($exe);

	if($filas > 0)
	{
		while($datosrc = mysqli_fetch_array($exe)){
			$sql = "INSERT INTO estados (idestado_cli, idreporte_estado, tipo, fecha, hora, descripcion) (select idestado, idreporte_estado, tipo, fecha, hora, concat(descripcion, 'cvn_newstate_gate') from estados_cli where idreporte_estado='$datosrc[idreporte_estado]' and idestado not in (select idestado_cli from estados where idreporte_estado='$idreporte_estado') order by idestado asc)";

			$exec = mysqli_query($link,$sql);

			$sql = "update estados set idreporte_estado='$idreporte_estado', descripcion=replace(descripcion, 'cvn_newstate_gate', '') where idestado_cli in (select idestado from estados_cli where idreporte_estado='$datosrc[idreporte_estado]') and idreporte_estado='$datosrc[idreporte_estado]' and descripcion like '%cvn_newstate_gate'";
			$exec = mysqli_query($link,$sql);
			
		}		
	}
	//adjunto---------------------------------------------------------------------------------------------------------------

	foreach($_FILES as $adjunto){
		if($adjunto['name']!='')
		{
			if ($mueve = move_uploaded_file($adjunto['tmp_name'], "./formatos_adjunto/".$adjunto['name']))
			{
				$nombre = $adjunto['name'];
				$sql = "INSERT INTO formatos_adjunto (idreporte_estado, idusuario, nombre, fecha, tipo) VALUES ('$idreporte_estado', '$_SESSION[numberid]', '$nombre', NOW(), 'operativo')";
				$exe = mysqli_query($link,$sql);
			}
		}
	}
}
?>
<form enctype="multipart/form-data" name="formulario" id="formulario" method="post">
	<input name="datosok" type="hidden" value="no" />
	<input name="deshok" type="hidden" value="no" />
	<input name="descuadrook" type="hidden" value="no" />
	<input name="notifycam" type="hidden" value="no" />
	<input type="hidden" name="lista_id" value="" />
	<input type="hidden" name="lista_f" value="" />
	<input type="hidden" name="lista_h" value="" />
	<input type="hidden" name="lista_m" value="" />
	<input type="hidden" name="lista_d" value="" />
	<input type="hidden" name="listaeli" value="" />
	<input type="hidden" name="listaeli2" value="" />
	<?
	if($_GET['cl'] == 'fcl' || $_GET['cl'] == 'lcl')
		$sqlt = "select * from tarifario where idtarifario='$_GET[idtarifario]'";	
	if($_GET['cl'] == 'aereo')
		$sqlt = "select * from tarifario_aereo where idtarifario_aereo='$_GET[idtarifario]'";
	

	$exet = mysqli_query($link,$sqlt);
	$datost =  mysqli_fetch_array($exet);
	
	$sql = "select * from cot_temp where idcot_temp='$_GET[idcot_temp]'";
	$exe = mysqli_query($link,$sql);
	$datos = mysqli_fetch_array($exe);
	
	$sqlc = "select * from clientes where idcliente='$datos[idcliente]'";
	$exec = mysqli_query($link,$sqlc);
	$datosc = mysqli_fetch_array($exec);
	
	$sqlsh = "select * from $table where $idsh='$_GET[idshipping]'";
	$exesh = mysqli_query($link,$sqlsh);
	$datosh = mysqli_fetch_array($exesh);
	
	if($_GET['cl'] == 'aereo')
		$sqlrn = "select * from rn_fletes_aereo where idcot_fletes_aereo in (select idcot_fletes_aereo from cot_fletes_aereo where idcot_temp='$_GET[idcot_temp]' and idtarifario_aereo='$datosh[idtarifario]')";
	else
		$sqlrn = "select * from rn_fletes where idcot_fletes in (select idcot_fletes from cot_fletes where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosh[idtarifario]')"; 
	$exern = mysqli_query($link,$sqlrn);
	$datosrn =  mysqli_fetch_array($exern);
	
	$sqlre = "select * from reporte_estado where idshipping='$_GET[idshipping]'";
	$exere = mysqli_query($link,$sqlre);
	$datosre = mysqli_fetch_array($exere);
	
	$sql = "select * from hbl where idreporte='$_GET[idcot_temp]' and idtarifario='$datosh[idtarifario]'";
	$exe = mysqli_query($link,$sql);
	$datosbl = mysqli_fetch_array($exe);
	
	$sqlf = "select * from factura where idreporte='$_GET[idcot_temp]' and idhbl='$datosbl[idhbl]'";
	$exef = mysqli_query($link,$sqlf);
	$datosf = mysqli_fetch_array($exef);
	
	$sql = "select * from reporte_estado_cli where number='$order_number'";
	$exe = mysqli_query($link,$sql);
	$datosrc = mysqli_fetch_array($exe)
	?>
	
	
		<div <? echo (puedo("l","REPORTES_ESTADO") == 1) ? "" : "style='display:none'";?> >
			<table width="100%" align="center">	
				<?
				if($_GET['exporta']=='si' && $_GET['preforma']!='si')
				{
					?>
					<tr>
						<td align="left"><? include('../logo.php'); ?></td>
					</tr>
					<?
				}
				?>
				<tr>
					<td class="subtitseccion" style="text-align:center"><strong>REPORTE DE ESTADO DE CARGA <? if($_GET['cl'] == 'aereo') print 'AEREA '; else print 'MARITIMA '; ?>  <? print scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero"); ?></strong><br><br></td>
				</tr>
				<?
				if($_GET['exporta']!='si' || $_GET['preforma']=='si')
				{
					$sql = "select * from formatos_adjunto where tipo='operativo' and idreporte_estado='$datosre[idreporte_estado]'";
					$exeft = mysqli_query($link,$sql);
					
					?>
					<tr>
						<td class="contenidotab" style="text-align:center">
							<table width="70%" align="center">
							<?
							while($datosft = mysqli_fetch_array($exeft))
							{
								?>
								<tr>
									<td class="contenidotab" style="text-align:center"><a href="formatos_adjunto/<? print $datosft['nombre']; ?>" target="_blank"><? print $datosft['nombre']; ?></a>
									<? if($_GET['exporta']!='si' && $datosft['idformato_comercial']!='' && $datosft['idformato_comercial']!='0') print " <br><span style='color:#FF0000'>Originado desde el modulo comercial</span>";
									?>
									</td>
									<? if($_GET['preforma']!='si') { ?>
										<td class="contenidotab"><? print $datosft['fecha']; ?></td>
										<td class="contenidotab"><? print scai_get_name("$datosft[idusuario]", "vendedores_customer", "idusuario", "nombre"); ?></td>
										<td class="contenidotab"><a href="javascript: void(0)" onclick="validadjunto(formulario, '<? print $datosft['idformato']; ?>')"><img src="../images/borrar.png" border="0" width="20px"></a></td>
									<? } ?>
								</tr>
								<?
							}
							?>
							</table>
						</td>
					</tr>
					<tr>
						<td class="contenidotab" valign="top" style="text-align:center"><div id="contiene2" align="center"></div>
					</tr>
					<?
				}
				?>
				<tr>
					<td class="contenidotab" style="text-align:center"><? if($_GET['exporta']!='si') { ?><a href="javascript: void(0)" class="contenidotab" style="color:#FF0000" onClick="addField2()"><strong>A&ntilde;adir Archivo(+)</strong></a><? } ?></td>
				</tr>
				<?
				if($_GET['exporta']!='si')
				{
					?>
					<tr>
						<td class="subtitseccion" style="text-align:center; font-size:10px">Aca puedes ingresar la informaci&oacute;n del reporte de estado  del Shipping Instruction seleccionado<br><br></td>
				<tr>
					<td class="contenidotab" style="text-align:center; font-size:10px"><strong>Deshablitaci&oacute;n permanente Cuadro de Seguimientos</strong> 
					<? if($_POST['deshabilitar']!='') $seleccionado = $_POST['deshabilitar']; else $seleccionado = $datosre['deshabilitar']; ?>&nbsp;
					<select id="deshabilitar" name="deshabilitar" onchange="desabilitarcuadro(formulario);">
						<option value="0" <? if($seleccionado=='0') print 'selected'; ?>>NO</option>
						<option value="1" <? if($seleccionado=='1') print 'selected'; ?>>SI</option>
					</select>
					
					<strong>Deshablitaci&oacute;n permanente Zona Clientes</strong> 
					<? if($_POST['deshabilitarz']!='') $seleccionado = $_POST['deshabilitarz']; else $seleccionado = $datosre['estado_zona']; ?>&nbsp;
					<select id="deshabilitarz" name="deshabilitarz" onchange="desabilitarzona(formulario);">
						<option value="0" <? if($seleccionado=='0') print 'selected'; ?>>NO</option>
						<option value="1" <? if($seleccionado=='1') print 'selected'; ?>>SI</option>
					</select>
					
					
					</td>
				</tr>
					<?
				}
				?>
				<tr>
					<td class="contenidotab" style="text-align:right"><? if($datosh['numero']!='') print 'SHIPMENT ID: '.$datosh['numero']; ?> </td>
				</tr>
			</table>
			<br />
			
			
			<table width="70%" align="center" border="<? if($_GET['exporta']=='si') print '1'; else print '0'; ?>">
				<tr>
					<td class="tittabla" bgcolor='#FF6600' style='text-align:center' colspan="2"><strong>DATOS DE LA CARGA</strong></td>
					<td width="14%" bgcolor='#FF6600' class="tittabla" style='text-align:center'><strong>MERCANCIA</strong></td>
				</tr>
				<tr>
					<td width="58%" class="contenidotab"></td>
					<td width="28%" class="contenidotab"><strong>MODALIDAD</strong> <? print strtoupper($_GET['cl']); ?> </td>
					<td class="contenidotab"><? if($_GET['exporta']=='si') print $datosre['mercancia']; else { ?><input type="text" size="10" id="mercancia" name="mercancia" value="<? print $datosre['mercancia']; ?>"/><? } ?></td>
				</tr>
				<tr>
					<td class="contenidotab" valign="top">
						<table width="100%" align="center">	
							<tr>
								<td class="contenidotab"><strong>CLIENTE</strong></td>
							    <td width="280" class="contenidotab"><? print $datosc['nombre']?></td>
							</tr>
							<tr>
								<td class="contenidotab"><strong>No. DE ORDEN</strong></td>
							    <td width="280" class="contenidotab"><? print scai_get_name("$_GET[idshipping]","shipping_instruction","idshipping_instruction","order_number"); ?></td>
							</tr>
							<tr>
								<td class="contenidotab"><strong>ETD</strong></td>
							    <td width="280" class="contenidotab"><? if($_GET['exporta']=='si') print $datosre['etd']; else { ?>
						      <input type="text" size="15" id="etd2" name="etd2" value="<? print $datosre['etd']; ?>" readonly="readonly"/> 
							  <input class="botonesadmin" style="color:#FFFFFF;" onclick="return showCalendar('etd2');" type='reset' value='...' name='reset2' />
						      <? } ?></td>
							</tr>
							<tr>
								<td class="contenidotab"><strong>ETA</strong></td>
							    <td width="280" class="contenidotab"><? if($_GET['exporta']=='si') print $datosre['eta']; else { ?><input type="text" size="15" id="eta" name="eta" value="<? print $datosre['eta']; ?>" readonly/>
							    <input class="botonesadmin" style="color:#FFFFFF;" onClick="return showCalendar('eta');" type='reset' value='...' name='reset' /><? } ?></td>
							</tr>
							<tr>
						<td class="contenidotab"><strong>ORIGEN</strong>
							  </td>
							<td width="250" class="contenidotab"><?
						$mod_comercial = '';
						if($_GET['cl'] == 'aereo')
						{
							if($datost['aeropuerto_origen']!='' && $datost['aeropuerto_origen']!='0')
								$seleccionado = $datost['aeropuerto_origen'];
							else
							{
								$seleccionado = $datosrc['puerto_origen'];
								$mod_comercial = 'si';
							}
						}
						else
						{
							if($datost['puerto_origen']!='' && $datost['puerto_origen']!='0')
								$seleccionado = $datost['puerto_origen'];
							else
							{
								$seleccionado = $datosrc['puerto_origen'];
								$mod_comercial = 'si';
							}
						}
						print scai_get_name($seleccionado,"aeropuertos_puertos", "idaeropuerto_puerto", "nombre");
						if($_GET['exporta']!='si' && $mod_comercial=='si')
							print " <span style='color:#FF0000'>Originado desde el modulo comercial</span>";
						?></td>
							</tr>															
							 <tr>
						<td class="contenidotab"><strong>DESTINO</strong>
												</td>
							<td width="250" class="contenidotab"><?
						$mod_comercial = '';
						if($_GET['cl'] == 'aereo')
						{
							if($datost['aeropuerto_destino']!='' && $datost['aeropuerto_destino']!='0')
								$seleccionado = $datost['aeropuerto_destino'];
							else
							{
								$seleccionado = $datosrc['puerto_destino'];
								$mod_comercial = 'si';
							}
						}
						else
						{
							if($datost['puerto_destino']!='' && $datost['puerto_destino']!='0')
								$seleccionado = $datost['puerto_destino'];
							else
							{
								$seleccionado = $datosrc['puerto_destino'];
								$mod_comercial = 'si';
							}
						}
						print scai_get_name($seleccionado,"aeropuertos_puertos", "idaeropuerto_puerto", "nombre");
						if($_GET['exporta']!='si' && $mod_comercial=='si')
							print " <span style='color:#FF0000'>Originado desde el modulo comercial</span>";
						?></td>
						    </tr>
							<tr>
									<td class="contenidotab"><strong>REQUEST SHIP DATE</strong>										</td>
						            <td width="250" class="contenidotab"><?
										if ($_GET['exporta'] == 'si') {
											if ($_POST['request_ship_date'] != '')
												print $_POST['request_ship_date'];
											else
												print $datosre['request_ship_date'];
										} else {
											?>
											<input type="text" id="request_ship_date" name="request_ship_date" value="<?
										if ($_POST['request_ship_date'] != '')
											print $_POST['request_ship_date']; else
											print $datosre['request_ship_date'];
										?>" readonly  size="15"/>
											<input class="botonesadmin" style="color:#FFFFFF;" onClick="return showCalendar('request_ship_date');" type='reset' value='...' name='reset' />
										<? } ?>									</td>
						  </tr>
								<tr>
									<td class="contenidotab"><strong>NAVIERA</strong>										</td>
							      <td width="250" class="contenidotab"><?
											   if ($_GET['exporta'] == 'si') {
												   if ($_POST['naviera'] != '')
													   print $_POST['naviera']; else
													   print $datosre['naviera'];
											   } else {
											?><input name="naviera" type="text" id="naviera" value="<?
										if ($_POST['naviera'] != '')
											print $_POST['naviera']; else
											print $datosre['naviera'];
											?>" size="21" maxlength="60"/>
								    <? } ?>									</td>
								</tr>
								<tr>
									<td colspan="2" class="contenidotab"><strong>TERMINOS DE NEGOCIACI&Oacute;N</strong>
									<?
											   if ($_GET['exporta'] == 'si') {
												   if ($_POST['terminos_negociacion'] != '')
													   print $_POST['terminos_negociacion']; else
													   print $datosre['terminos_negociacion'];
											   } else {
											?><textarea id="terminos_negociacion" name="terminos_negociacion" rows="4" cols="50"><?
										if ($_POST['terminos_negociacion'] != '')
											print $_POST['terminos_negociacion']; else
											print $datosre['terminos_negociacion'];
											?></textarea><? } ?>								  </td>
								</tr>
					  </table>
					</td>
					<td class="contenidotab" colspan="2" valign="top">
						<table width="100%" align="center">	
							<tr>
								<td width="100" class="contenidotab"><strong>SHIPPER </strong></td>
							    <td width="85" class="contenidotab"><? if($datosrn['name']!='') print $datosrn['name']; else { print $datosrc['shipper']; if($_GET['exporta']!='si') print " <span style='color:#FF0000'>Originado desde el modulo comercial</span>"; } ?></td>
							</tr>
							<?					
							$sqlct = "select * from contenedores where idhbl='$datosbl[idhbl]'";
							$exect = mysqli_query($link,$sqlct);
							$peso = 0;
							$piezas = 0;
							$volumen = 0;
							while($datosct = mysqli_fetch_array($exect))
							{
								if($_GET['cl']=='aereo')
								{
									$peso += $datosct['measurement'];//Chargeable Weight
									//print $peso.'<br>';	
								}
								
								else
								{
									$kgs = $datosct['gross'];
									$cbm = $datosct['measurement'] * 1000;
									$volumen += $datosct['measurement'];
									
									if($kgs > $cbm)
										$peso += $kgs;
									else
										$peso += $cbm;
										
									//print $peso.'<br>';
								}		
								$piezas += $datosct['units'];						
								//print 'kgs'.$kgs.'<br>';
								//print 'cbm'.$cbm.'<br>';			
							}
							?>
							<tr>
								<td width="100" class="contenidotab"><strong>KG</strong></td>
							    <td width="85" class="contenidotab"><? if($datosf['peso']!='') print $datosf['peso']; elseif($peso > 0) print $peso; else { print $datosrc['peso']; if($_GET['exporta']!='si') print " <span style='color:#FF0000'>Originado desde el modulo comercial</span>"; } ?></td>
							</tr>
							<?
							if($_GET['cl']=='aereo')
							{
								?>
								<tr>
									<td width="100" class="contenidotab"><strong>PIEZAS</strong></td>
								    <td width="85" class="contenidotab"><? if($datosf['piezas']!='') print $datosf['piezas']; else print $piezas; ?></td>
								</tr>
								<?
							}
							else
							{
								?>   
								<tr>
									<td width="100" class="contenidotab"><strong>M3</strong></td>
								    <td width="85" class="contenidotab"><? if($volumen > 0) print $volumen; else { print $datosrc['volumen']; if($_GET['exporta']!='si') print " <span style='color:#FF0000'>Originado desde el modulo comercial</span>"; } ?></td>
								</tr>
								<tr>
									<td width="100" class="contenidotab"><strong>MOTONAVE</strong></td>
								    <td width="85" class="contenidotab"><?
									if ($_GET['exporta'] == 'si') {
										if ($_POST['motonave'] != '')
											print $_POST['motonave']; else
											print $datosre['motonave'];
									} else {
											?><input type="text" size="8" id="motonave" name="motonave" value="<?
										if ($_POST['motonave'] != '')
											print $_POST['motonave']; else
											print $datosre['motonave'];
											?>"/><? } ?></td>
								</tr>
								<tr>
									<td width="100" class="contenidotab"><strong>HBL / HAWB</strong></td>
								    <td width="85" class="contenidotab"> <?
										if ($_GET['exporta'] == 'si') {
											if ($_POST['hbl'] != '')
												print $_POST['hbl']; else
												print $datosre['hbl'];
										} else {
											?><input type="text" size="8" id="hbl" name="hbl" value="<?
											   if ($_POST['hbl'] != '')
												   print $_POST['hbl']; else
												   print $datosre['hbl'];
											?>"/><? } ?></td>
								</tr>
						<tr>
							<td width="100" class="contenidotab"><strong>REF 1</strong><br>
						    <br><strong>REF 2</strong></td>
					      <td width="85" class="contenidotab"><? if($_GET['exporta']=='si') { if($_POST['ref']!='') print $_POST['ref']; else print $datosre['ref']; } else { ?>
				          <input type="text" size="8" id="ref3" name="ref3" value="<? if($_POST['ref']!='') print $_POST['ref']; else print $datosre['ref']; ?>"/><br />
						      <? } ?>
						      <? if($_GET['exporta']=='si') { if($_POST['ref2']!='') print $_POST['ref2']; else print $datosre['ref2']; } else { ?>
						      <input type="text" size="8" id="ref22" name="ref22" value="<? if($_POST['ref2']!='') print $_POST['ref2']; else print $datosre['ref2']; ?>"/>
						      <? } ?></td>
						</tr>
								<?
							}
							 
							if($_GET['cl']=='fcl')
							{	
								?>
								<tr>
									<td colspan="2" class="contenidotab"><strong>TAMANO DE CONTENEDOR</strong><br>
									<?
									$sql = "select * from rn_fletes where idcot_fletes in (select idcot_fletes from cot_fletes where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosh[idtarifario]') and idtipo in (select idtipo from tipo where tipo='20') and idreporte='$_GET[idcot_temp]'";
									//print $sql.'<br>';
									$exe = mysqli_query($link,$sql);
									$datos2 = mysqli_fetch_array($exe);
									?>
									 <? if($_GET['exporta']=='si') { if($datosre['n20']!='' || $datos2['cantidad']!='' || $datosrc['n20']!='') { if($datosre['n20']!='') print $datosre['n20']; elseif($datos2['cantidad']!='') print $datos2['cantidad']; else print $datosrc['n20']; print ' X 20<br>'; } } else { ?><input type="text" size="8" id="n20" name="n20" value="<? if($datosre['n20']!='') print $datosre['n20']; elseif($datos2['cantidad']!='') print $datos2['cantidad']; else { print $datosrc['n20']; } ?>"/><? if($datosre['n20']=='' && $datos2['cantidad']=='') print " <span style='color:#FF0000'>Originado desde el modulo comercial</span>"; ?><strong> X 20</strong><br><? } ?>
									<?
									$sql = "select * from rn_fletes where idcot_fletes in (select idcot_fletes from cot_fletes where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosh[idtarifario]') and idtipo in (select idtipo from tipo where tipo='40') and idreporte='$_GET[idcot_temp]'";
									//print $sql.'<br>';
									$exe = mysqli_query($link,$sql);
									$datos2 = mysqli_fetch_array($exe);
									?>
									<? if($_GET['exporta']=='si') { if($datosre['n40']!='' || $datos2['cantidad']!='' || $datosrc['n40']!='') { if($datosre['n40']!='') print $datosre['n40']; elseif($datos2['cantidad']!='') print $datos2['cantidad']; else print $datosrc['n40']; print ' X 40<br>'; } } else { ?><input type="text" size="8" id="n40" name="n40" value="<? if($datosre['n40']!='') print $datosre['n40']; elseif($datos2['cantidad']!='') print $datos2['cantidad']; else print $datosrc['n40']; ?>"/><? if($datosre['n40']=='' && $datos2['cantidad']=='') print " <span style='color:#FF0000'>Originado desde el modulo comercial</span>"; ?><strong> X 40</strong><br><? } ?>
									<?
									$sql = "select * from rn_fletes where idcot_fletes in (select idcot_fletes from cot_fletes where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosh[idtarifario]') and idtipo in (select idtipo from tipo where tipo='40hq') and idreporte='$_GET[idcot_temp]'";
									//print $sql.'<br>';
									$exe = mysqli_query($link,$sql);
									$datos2 = mysqli_fetch_array($exe);
									?>
									<? if($_GET['exporta']=='si') { if($datosre['n40hq']!='' || $datos2['cantidad']!='' || $datosrc['n40hq']!='') { if($datosre['n40hq']!='') print $datosre['n40hq']; elseif($datos2['cantidad']!='') print $datos2['cantidad']; else print $datosrc['n40hq']; print ' X 40HQ'; } } else { ?><input type="text" size="8" id="n40hq" name="n40hq" value="<? if($datosre['n40hq']!='') print $datosre['n40hq']; elseif($datos2['cantidad']!='') print $datos2['cantidad']; else print $datosrc['n40hq']; ?>"/><? if($datosre['n40hq']=='' && $datos2['cantidad']=='') print " <span style='color:#FF0000'>Originado desde el modulo comercial</span>"; ?><strong> X 40HQ</strong><? } ?>									</td>
								</tr>
								<?
							}
							?>
						</table>
					</td>
				</tr>    
			</table>
			<br />
		</div>
		<table width="100%" align="center" border="<? if($_GET['exporta']=='si') print '1'; else print '0'; ?>">
			<tr>
				<td class="tittabla" bgcolor='#FF6600' style='text-align:center' colspan="<? if($_GET['exporta']=='si') print '3'; else print '4'; ?>"><strong>ESTADO DEL TRANSPORTE</strong></td>
			</tr>
			<tr>
				<td class="tittabla" bgcolor='#FF6600' style='text-align:center'><strong>FECHA</strong></td>
				<td class="tittabla" bgcolor='#FF6600' style='text-align:center'><strong>HORA</strong></td>
				<td class="tittabla" bgcolor='#FF6600' style='text-align:center'><strong>DESCRIPCI&Oacute;N</strong></td>
				<? if($_GET['exporta']!='si') { ?><td class="contenidotab">Eliminar</td><? } ?>
			</tr>
			<?
		
				$sqle = "select * from estados where idreporte_estado='$datosre[idreporte_estado]' and tipo='maritimo' order by fecha desc, hora desc";
		
			$exee = mysqli_query($link,$sqle);
			while($datose = mysqli_fetch_array($exee)){
				?>
				<tr>
					<td class="contenidotab" valign="top">
						<? if($_GET['exporta']!='si' && $datose['idestado_cli']!='' && $datose['idestado_cli']!='0') 
							print "<span style='color:#FF0000'>Originado desde el modulo comercial<br></span>"; ?>
						<input type="hidden" id="idestado" name="idestado" value="<? print $datose['idestado']; ?>"/>
						<? 
						if($_GET['exporta']=='si') print $datose['fecha']; 
						
						else { ?>
							<input type="text" size="8" id="fecha" name="fecha" value="<? print $datose['fecha']; ?>"/>
							<input class="botonesadmin" style="color:#FFFFFF;" onClick="return showCalendar('fecha');" 
							type='reset' value='...' name='reset' />
					<? } ?>
					</td>
					<td class="contenidotab" valign="top">
						<? if($_GET['exporta']=='si') print $datose['hora']; else { ?>
							<?  $saca=explode(":",$datose['hora']); ?>
							<select id="hora" name="hora" >
								<option value="N"> Hora </option>
								<?
								for($h=0;$h<=23;$h++)
								{
									print "saca = ".$saca;
									if($saca[0]==$h)
										print "<option selected value='$h'>".$h."</option>";
									else
										print "<option value='$h'>".$h."</option>";
								}
								?>
							</select>
							:
							<select id="minu" name="minu" >
								<option value="N"> Min </option>
								<?
								for($i=0;$i<=59;$i++)
								{
									if($saca[1]==$i)
										print "<option selected value='$i'>".$i."</option>";
									else
										print "<option value='$i'>".$i."</option>";
								}
								?>
							</select>
							<?
						}
						?>
					</td>
					<td class="contenidotab" valign="top"><? if($_GET['exporta']=='si') print $datose['descripcion']; else { ?><textarea id="descripcion " name="descripcion" rows="7"><? print $datose['descripcion']; ?></textarea><? } ?></td>
					<? 
					if($_GET['exporta']!='si') { 
						if(puedo("e","ZONA_CLIENTES") == 1){  //Si tiene permisos para eliminar ..?>
							<td class="contenidotab" valign="top">
								<input type="checkbox" id="eliminar" name="eliminar" value="<? print $datose['idestado']; ?>">
							</td><? 
						}				
					} ?>
				</tr>
				<?
			}
			if($_GET['exporta']!='si')
			{
				?>
				<tr>
					<td class="contenidotab" valign="top" colspan="6"><div id="contiene" align="left"></div>
				</tr>
				<?
			}
			?> 
		</table>
	<? 
	if($_GET['exporta']!='si') { 
		?><a href="javascript: void(0)" class="contenidotab" style="color:#FF0000" onClick="addField()">
			<strong>A&ntilde;adir Item(+)</strong></a><? 
	} ?>
	<br />
	
	<? 
	if($_GET['preforma']!='si') { ?>
		<table width="100%" align="center">
			<tr>
				<td class="contenidotab">
					Agradezco su amable atenci&oacute;n  y cualquier inquietud al respecto, con gusto la atenderemos.<br /><br />
					Cordialmente,<br />
					<?
					
					$sqlvend="select idvendedor from clientes where idcliente='$idcliente'";
						$exevend=mysqli_query($link,$sqlvend);
						//print $sqlvend;
						$datosvend=mysqli_fetch_array($exevend);
						$sqluse="select idusuario from vendedores_customer where idvendedor_customer='$datosvend[idvendedor]'";
						$exeuse=mysqli_query($link,$sqluse);
						//print $sqluse;
						$datosp=mysqli_fetch_array($exeuse);
					
					if($datosp['idusuario']!='') $idusuario = $datosp['idusuario']; else $idusuario = $_SESSION['numberid'];
					$sql_sign="select * from usuarios where idusuario='$idusuario'";
					$exe_sql_sign=mysqli_query($link,$sql_sign);
					$row_exe_sql_sign=mysqli_fetch_array($exe_sql_sign);
					
					$sql_sign2 = "select * from vendedores_customer where idusuario='$row_exe_sql_sign[idusuario]'";
					//print $sql_sign2.'<br>';
					$exe_sql_sign2=mysqli_query($link,$sql_sign2);
					$row_exe_sql_sign2=mysqli_fetch_array($exe_sql_sign2);
					
					//print '<br><br>'.$row_exe_sql_sign['nombre']." ".$row_exe_sql_sign['apellido'];
					print '<br><br>'.$row_exe_sql_sign2['nombre'];
					print '<strong><br>'.scai_get_name("$row_exe_sql_sign2[idcargo]","cargos","idcargo","nombre").'</strong>';
					print '<br>Address: '.$row_exe_sql_sign2['direccion'];
					print '<br>Phone: '.$row_exe_sql_sign2['telefono'];
					print '<br>Movil: '.$row_exe_sql_sign2['celular'];
					//print '<br>USA Phone: '.$row_exe_sql_sign2['telefono'];
					print '<br>E-mail: '.$row_exe_sql_sign2['email'];
					
					$sqlpm = "select * from parametros where idparametro='32'";
					//print $sqlpm.'<br>';
					$exepm = mysqli_query($link,$sqlpm);
					$cond = mysqli_fetch_array($exepm);
					print '<br>Web site: '.$cond['valor'];
					?>        
				</td>
			</tr>
		</table>
	<? 
	} 
	if($_GET['exporta']!='si'){?>
		<table>
			<tr>
				<td colspan="5" align="left">
					<table>
						<tr>
							<?
							if($datosre['idreporte_estado']!='' && (puedo("l","REPORTES_ESTADO") == 1))
							{
								?>
								<td width="60" class="botonesadmin"><a href="<? print $_SERVER['PHP_SELF']; ?>?idshipping=<? print $_GET['idshipping']; ?>&exporta=si&numshipping=<? print $_GET['numshipping']; ?>" onClick="">Exportar a Word</a></td>
								<td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="enviamail(formail)">Enviar email</a></td>
								<?
							}
							?>                        
							<td width="60" class="botonesadmin"><a href="../seguimientos_cliente.php?idcliente=<? print scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "idcliente"); ?>" onClick="">Atras</a></td>
	
	
							<td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>
				<td width="60" class="botonesadmin"><a href="javascript: void(0)" 		onClick="enviarCambio(formulario);">Notificar Cambio</a></td>
							
	
	
						</tr>
					</table> 
				</td>        	
			</tr>
		</table>
		<?
	}
	elseif($_GET['exporta']=='si' && $_GET['preforma']=='si'){
		?>
		<table>
			<tr>
				<td colspan="5" align="left">
				<table>
					<tr>
						<td width="60" class="botonesadmin"><a href="../zona_clientes/descargas.php?idcliente=<? print scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "idcliente"); ?>" onClick="">Atras</a></td>
					</tr>
				</table> 
				</td>        	
			</tr>
		</table>
		<?
	}
	?>
</form>
<form method="post" action="mail_alerta.php?cliente=<? print scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "idcliente"); ?>&idreporte_estado=<? print $datosre['idreporte_estado']; ?>&idshipping=<? echo $_GET['idshipping'];?>&envio=REPORTE DE ESTADO" name="formail" id="formail">

	<? 
	if($_GET['cl'] == 'aereo') $chargue= 'AEREA'; else $chargue='MARITIMA'; 
	
	/*
	<table width='100%' align='center'>	
				<tr>
					<td class='subtitseccion' style='text-align:center'><strong>REPORTE DE ESTADO DE CARGA ".$chargue." ".scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero")."</strong><br><br></td>
				</tr>	
				<tr>
					<td class='contenidotab' style='text-align:right'>"; if($datosh['numero']!='') $msg .= 'SHIPMENT ID: '.$datosh['numero']; $msg .= "</td>
				</tr>
			</table>
			<br />
	*/
	
	$msg = "			
			<table width='70%' align='center' border='1'>
				<tr>
					<td class='tittabla' bgcolor='#FF6600' style='text-align:center' colspan='2'><strong>DATOS DE LA CARGA</strong></td>
					<td class='tittabla' bgcolor='#FF6600' style='text-align:center'><strong>MERCANCIA</strong></td>
				</tr>
				<tr>
					<td class='contenidotab'></td>
					<td class='contenidotab'><strong>MODALIDAD</strong> ".strtoupper($_GET['cl'])."</td>
					<td class='contenidotab'>".$datosre['mercancia']."</td>
				</tr>
				<tr>
					<td class='contenidotab' valign='top'>
						<table width='100%' align='center'>	
							<tr>
								<td class='contenidotab'><strong>CLIENTE</strong> ".$datosc['nombre']."</td>
							</tr>
							<tr>
								<td class='contenidotab'><strong>No. DE ORDEN</strong> ".scai_get_name("$_GET[idshipping]","shipping_instruction","idshipping_instruction","order_number")."</td>
							</tr>
							<tr>
								<td class='contenidotab'><strong>ETD</strong> ".$datosre['etd']."</td>
							</tr>
							<tr>
								<td class='contenidotab'><strong>ETA</strong> ".$datosre['eta']."</td>
							</tr>
							<tr>
						<td class='contenidotab'><strong>ORIGEN</strong> ";
						$mod_comercial = '';
						if($_GET['cl'] == 'aereo')
						{
							if($datost['aeropuerto_origen']!='' && $datost['aeropuerto_origen']!='0')
								$seleccionado = $datost['aeropuerto_origen'];
							else
								$seleccionado = $datosrc['puerto_origen'];
						}
						else
						{
							if($datost['puerto_origen']!='' && $datost['puerto_origen']!='0')
								$seleccionado = $datost['puerto_origen'];
							else
								$seleccionado = $datosrc['puerto_origen'];
						}
						$msg .= scai_get_name($seleccionado,"aeropuertos_puertos", "idaeropuerto_puerto", "nombre")."</td>
							</tr>
							 <tr>
									<td class='contenidotab'><strong>DESTINO</strong> ";
						$mod_comercial = '';
						if($_GET['cl'] == 'aereo')
						{
							if($datost['aeropuerto_destino']!='' && $datost['aeropuerto_destino']!='0')
								$seleccionado = $datost['aeropuerto_destino'];
							else
								$seleccionado = $datosrc['puerto_destino'];
						}
						else
						{
							if($datost['puerto_destino']!='' && $datost['puerto_destino']!='0')
								$seleccionado = $datost['puerto_destino'];
							else
								$seleccionado = $datosrc['puerto_destino'];
						}
						$msg .= scai_get_name($seleccionado,"aeropuertos_puertos", "idaeropuerto_puerto", "nombre")."</td>
							</tr>
							<tr>
								<td class='contenidotab'><strong>REQUEST SHIP DATE</strong> " . $datosre['request_ship_date'] . "</td>
							</tr>
							<tr>
								<td class='contenidotab'><strong>NAVIERA</strong> " . $datosre['naviera'] . "</td>
							</tr>
							<tr>
								<td class='contenidotab'><strong>TERMINOS DE NEGOCIACION</strong> " . $datosre['terminos_negociacion'] . "</td>
							</tr>
						</table>
					</td>
					<td class='contenidotab' colspan='2' valign='top'>
						<table width='100%' align='center'>	
							<tr>
								<td class='contenidotab'><strong>SHIPPER </strong> "; if($datosrn['name']!='') $msg .= $datosrn['name']; else $msg .= $datosrc['shipper']; $msg .= "</td>
							</tr>
							<tr>
								<td class='contenidotab'><strong>KG </strong>"; if($datosf['peso']!='') $msg .= $datosf['peso']; elseif($peso > 0) $msg .= $peso; else $msg .= $datosrc['peso']; $msg .= "</td>
							</tr>";
							if($_GET['cl']=='aereo')
							{
								$msg .= "<tr>
									<td class='contenidotab'><strong>PIEZAS </strong>"; if($datosf['piezas']!='') $msg .= $datosf['piezas']; else $msg .= $piezas; $msg .= "</td>
								</tr>";
							}
							else
							{
								$msg .= "<tr>
									<td class='contenidotab'><strong>M3 </strong>"; if($volumen > 0) $msg .= $volumen; else $msg .= $datosrc['volumen']; $msg .= "</td>
								</tr>";
							}
					$msg .= "
								<tr>
						<td class='contenidotab'><strong>MOTONAVE </strong>" . $datosre['motonave'] . "</td>
					</tr>
					<tr>
						<td class='contenidotab'><strong>HBL </strong>" . $datosre['hbl'] . "</td>
					</tr>
								<tr>
								<td class='contenidotab'><strong>REF 1 </strong>".$datosre['ref']."</td>
							</tr>
							<tr>
								<td class='contenidotab'><strong>REF 2 </strong>".$datosre['ref2']."</td>
							</tr>
							";				
							if($_GET['cl']=='fcl')
							{						
								$msg .= "<tr>
									<td class='contenidotab'><strong>TAMANO DE CONTENEDOR</strong><br>";
			
									$sql = "select * from rn_fletes where idcot_fletes in (select idcot_fletes from cot_fletes where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosh[idtarifario]') and idtipo in (select idtipo from tipo where tipo='20') and idreporte='$_GET[idcot_temp]'";
									//print $sql.'<br>';
									$exe = mysqli_query($link,$sql);
									$datos2 = mysqli_fetch_array($exe);
									if($datosre['n20']!='' || $datos2['cantidad']!='' || $datosrc['n20']!='')
									{
										if($datosre['n20']!='') $msg .= $datosre['n20']; elseif($datos2['cantidad']!='') $msg .= $datos2['cantidad']; else $msg .= $datosrc['n20']; $msg .= ' X 20<br>';
									}
			
									$sql = "select * from rn_fletes where idcot_fletes in (select idcot_fletes from cot_fletes where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosh[idtarifario]') and idtipo in (select idtipo from tipo where tipo='40') and idreporte='$_GET[idcot_temp]'";
									//print $sql.'<br>';
									$exe = mysqli_query($link,$sql);
									$datos2 = mysqli_fetch_array($exe);
									if($datosre['n40']!='' || $datos2['cantidad']!='' || $datosrc['n40']!='')
									{
										if($datosre['n40']!='') $msg .= $datosre['n40']; elseif($datos2['cantidad']!='') $msg .= $datos2['cantidad']; else $msg .= $datosrc['n40']; $msg .= ' X 40<br>';
									}
							
									$sql = "select * from rn_fletes where idcot_fletes in (select idcot_fletes from cot_fletes where idcot_temp='$_GET[idcot_temp]' and idtarifario='$datosh[idtarifario]') and idtipo in (select idtipo from tipo where tipo='40hq') and idreporte='$_GET[idcot_temp]'";
									//print $sql.'<br>';
									$exe = mysqli_query($link,$sql);
									$datos2 = mysqli_fetch_array($exe);
									if($datosre['n40hq']!='' || $datos2['cantidad']!='' || $datosrc['n40hq']!='')
									{
										if($datosre['n40hq']!='') $msg .= $datosre['n40hq']; elseif($datos2['cantidad']!='') $msg .= $datos2['cantidad']; else $msg .= $datosrc['n40hq']; $msg .= ' X 40HQ';
									}
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
					<td class='tittabla' bgcolor='#FF6600' style='text-align:center' colspan='"; if($_GET['exporta']=='si') $msg .='3'; else $msg .='4'; $msg .="'><strong>ESTADO DEL TRANSPORTE</strong></td>
				</tr>
				<tr>
					<td class='tittabla' bgcolor='#FF6600' style='text-align:center'><strong>FECHA</strong></td>
					<td class='tittabla' bgcolor='#FF6600' style='text-align:center'><strong>HORA</strong></td>
					<td class='tittabla' bgcolor='#FF6600' style='text-align:center'><strong>DESCRIPCI&Oacute;N</strong></td>       
				</tr>";
				$sqle = "select * from estados where idreporte_estado='$datosre[idreporte_estado]' and tipo='maritimo' order by fecha desc, hora desc";
				//print $sqle.'<br>';
				$exee = mysqli_query($link,$sqle);
				while($datose = mysqli_fetch_array($exee))
				{
					$msg .= "
					<tr>
						<td class='contenidotab' valign='top'>".$datose['fecha']."</td>
						<td class='contenidotab' valign='top'>".$datose['hora']."</td>
						<td class='contenidotab' valign='top'>".$datose['descripcion']."</td>            
					</tr>";
				}
				$msg .= "
			</table>
			<table width='100%' align='center'>
				<tr>
					<td class='contenidotab'>Agradezco su amable atencion  y cualquier inquietud al respecto, con gusto la atenderemos.<br /><br />
					Cordialmente,<br />";
				
					if($datosp['idusuario']!='') $idusuario = $datosp['idusuario']; else $idusuario = $_SESSION['numberid'];
					$sql_sign="select * from usuarios where idusuario='$idusuario'";
					$exe_sql_sign=mysqli_query($link,$sql_sign);
					$row_exe_sql_sign=mysqli_fetch_array($exe_sql_sign);
					
					$sql_sign2 = "select * from vendedores_customer where idusuario='$row_exe_sql_sign[idusuario]'";
					//print $sql_sign2.'<br>';
					$exe_sql_sign2=mysqli_query($link,$sql_sign2);
					$row_exe_sql_sign2=mysqli_fetch_array($exe_sql_sign2);
					
					//print '<br><br>'.$row_exe_sql_sign['nombre']." ".$row_exe_sql_sign['apellido'];
					$msg .= '<br><br>'.$row_exe_sql_sign2['nombre'];
					$msg .= '<strong><br>'.scai_get_name("$row_exe_sql_sign2[idcargo]","cargos","idcargo","nombre").'</strong>';
					$msg .= '<br>Address: '.$row_exe_sql_sign2['direccion'];
					$msg .= '<br>Phone: '.$row_exe_sql_sign2['telefono'];
					$msg .= '<br>Movil: '.$row_exe_sql_sign2['celular'];
					//$msg .= '<br>USA Phone: '.$row_exe_sql_sign2['telefono'];
					$msg .= '<br>E-mail: '.$row_exe_sql_sign2['email'];
					
					$sqlpm = "select * from parametros where idparametro='32'";
					//$msg .= $sqlpm.'<br>';
					$exepm = mysqli_query($link,$sqlpm);
					$cond = mysqli_fetch_array($exepm);
					$msg .= '<br>Web site: '.$cond['valor'];
					  
					$msg .= "</td>
				</tr>
			</table>";
			//logo-----------------------------------------------------------------------------------------------
			$logo = "
			<table width='100%' align='center' style='border-collapse: collapse; border: 4px solid orange;'>
				<tr>
					<td align='left' width='40%'>
						<p style='text-align: center; font-size:8pt; font-weight: bold;'>Este espacio fue dise&ntilde;ado para nuestros asociados de negocio, si desea pautar con nosotros, cont&aacute;ctenos al PBX (571) 8050075 Adriana Arias</p>
					</td>
					<td align='left'>
						<a href='http://www.distrielectricosje.com'><img src='http://190.158.236.5/gateway/images/logo_complementario.jpg' border='0' height='75' /></a>
					</td>
				</tr>
			</table><br />
			";
			/*$logo .= "
			<table width='100%' align='center'>
				<tr>
					<td align='left'>
						<img src='http://190.158.236.5/gateway/images/header_blanco.png' border='0' width='198' height='60' />
					</td>
				</tr>
			</table>";*/
	$msg = $logo.$msg;?>
	<input type="hidden" id="msg" name="msg" value="<? print $msg; ?>" />
	<input type="hidden" id="asunto" name="asunto" value="REPORTE DE ESTADO DE CARGA <? if($_GET['cl'] == 'aereo') print 'AEREA'; else print 'MARITIMA'; ?>" />
	<input type="hidden" id="shipment_id" name="shipment_id" value="<? print $datosh['numero']; ?>" />
	<input type="hidden" id="fuente" name="fuente" value="re_flete_comercial.php?idshipping=<? print $_GET['idshipping'].'&numshipping='.$_GET['numshipping'].'&cl='.$_GET['cl']; ?>">
	<input type="hidden" name="no_orden" id="no_orden" value="<? print scai_get_name("$_GET[idshipping]", "shipping_instruction", "idshipping_instruction", "order_number"); ?>"/>
		<input type="hidden" name="nom_shipper" id="nom_shipper" value="<? if ($datosrn[name] != ''){print $datosrn[name]; }else {print $datosrc[shipper];}?>"/>
</form>
