<?
	include('sesion/sesion.php');
	include("conection/conectar.php");
	include_once("permite.php");
	include_once("scripts/recover_nombre.php");
?>

<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/main.js"></script>
<script type="text/javascript" src="./js/shadowbox-base.js"></script>
<script type="text/javascript" src="./js/shadowbox.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="./js/jquery-1.2.1.pack.js" ></script>



<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/admin_internas.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/funciones.js"></script>
<script type="text/javascript" src="./js/funcionesValida.js"></script>
<!--FUNCION DE MOSTRAR RESULTADOS MIENTRAS SE ESCRIBE, PARA TEXT RAZON SOCIAL-->
<? include("scripts/prepare_clients_list.php");?>
<script type="text/javascript" src="js/clients_list.js"></script>
<?php include('scripts/scripts.php'); ?>

<script language="javascript">
function validaEnvia(form)
{
	form.datosok.value="si";
	form.submit()
}


function eliminaActual(form)
{
	form.varelimi.value="si";
	form.submit()
}

function validaPais(form)
{
	form.submit()
}

function borrar(form)
{
	document.location.href = 'clientes.php';
}
</script>
</head>

<body style="background-color: transparent;">
<form name="formulario" method="post">
<table width="100%" align="center" class="contenidotab">
	<tr>
    	<td class="subtitseccion" style="text-align:center" colspan="4">CONSULTAR COTIZACIONES<br><br></td>
    </tr>
    <tr>
        <td align="center">
            Fecha&nbsp;
            <?
			function ultimo_dia($m,$y)
			{
				return strftime("%d", mktime(0, 0, 0, $m+1, 0, $y));
			}

			function mes_anterior($m)
			{
				if($m == 1)
					return 12;
				else
					return $m - 1;
			}

			if ($_POST['filtro13'])
			{
				$_POST['filtro13'] = str_replace("\\", "", $_POST['filtro13']);
				$filtro13 = $_POST['filtro13'];
			}
			else
			{
				$anio = date('Y');
				if(date('m')=='1' || date('m')=='01')
					$anio = $anio-1;

				$filtro13 = date($anio.'-'.mes_anterior(date('m')).'-01');
			}
			?>
            Inicio&nbsp;
            <input name="filtro13" id="filtro13" type="text" value="<? print $filtro13;?>" maxlength="70" size="9" readonly>
        <input class="botonesadmin" style="color:#FFFFFF;" onClick="return showCalendar('filtro13');" type='reset' value='Calendario' name='reset' />
            <?php
			if ($_POST['filtro14'])
			{
				$_POST['filtro14'] = str_replace("\\", "", $_POST['filtro14']);
				$filtro14 = $_POST['filtro14'];
			}
			else
			{
				$ultimodia = ultimo_dia(date('m'),date('y'));
				$filtro14 = date('Y-'.date('m').'-'.ultimo_dia(date('m'), date('Y')));
			}
			?>
            Fin&nbsp;<input name="filtro14" id="filtro14" type="text" value="<? print $filtro14;?>" maxlength="70" size="9" readonly>
            <input class="botonesadmin" style="color:#FFFFFF;" onClick="return showCalendar('filtro14');" type='reset' value='Calendario' name='reset' />
            Vigencia&nbsp;
            <? $_POST['filtro4'] = str_replace("\\", "", $_POST['filtro4']); ?>
            Inicio&nbsp;<input name="filtro4" id="filtro4" type="text" value="<? print $_POST['filtro4']?>" maxlength="70" size="9" readonly>
            <input class="botonesadmin" style="color:#FFFFFF;" onClick="return showCalendar('filtro4');" type='reset' value='Calendario' name='reset' />
            <? $_POST['filtro4b'] = str_replace("\\", "", $_POST['filtro4b']); ?>
            Fin&nbsp;<input name="filtro4b" id="filtro4b" type="text" value="<? print $_POST['filtro4b']?>" maxlength="70" size="9" readonly>
            <input class="botonesadmin" style="color:#FFFFFF;" onClick="return showCalendar('filtro4b');" type='reset' value='Calendario' name='reset' />        </td>
    </tr>
    <tr align="center">
    	<td class="tit_vueltas" align="center">
            <? $_POST['filtro8'] = str_replace("\\", "", $_POST['filtro8']); ?>
            N&uacute;mero de cotizaci&oacute;n&nbsp;
            <input name="filtro8" id="filtro8"  class="tex3" type="text" value="<? print $_POST['filtro8']?>" maxlength="70" size="15">
			Order Number
            <input name="order_number" id="order_number"  class="tex3" type="text" value="<? print $_POST['order_number']?>">
            <? $_POST['filtro2'] = str_replace("\\", "", $_POST['filtro2']); ?>
            Cliente&nbsp;
      <input name="filtro2" id="filtro2" type="text" value="<? print $_POST['filtro2']?>" maxlength="70" size="50">

			<? $_POST['filtro3'] = str_replace("\\", "", $_POST['filtro3']); ?>
            <!--Comercial&nbsp;<input name="filtro3" id="filtro3"  class="tex3" type="text" value="<? print $_POST['filtro3']?>" maxlength="70" size="15">-->

            Comercial&nbsp;
            <select name="filtro3" class="Ancho_120px" id="filtro3">
                <option value="N"> Seleccione </option>
				<?
                $es="select idusuario, nombre from usuarios order by nombre";
                $exe=mysqli_query($link,$es);
                while($row=mysqli_fetch_array($exe))
                {
                    $sel = "";
                    if($_POST['filtro3']==$row['idusuario'])
                        $sel = "selected";
					$nombre = scai_get_name("$row[idusuario]","vendedores_customer", "idusuario", "nombre");
                    print "<option value='$row[idusuario]' $sel>$nombre</option>";
                }
                ?>
            </select>
            <!--OTM&nbsp;<input name="filtro5" id="filtro5" type="checkbox" onClick="" value="1" <? if($_POST['filtro5']=='1') print 'checked'; ?>/>-->
            <!--Seguro&nbsp;<input name="filtro6" id="filtro6" type="checkbox" onClick="" value="1" <? if($_POST['filtro6']=='1') print 'checked'; ?>/>-->
            <!--Aduana&nbsp;<input name="filtro7" id="filtro7" type="checkbox" onClick="" value="1" <? if($_POST['filtro7']=='1') print 'checked'; ?>/>-->        Tipo&nbsp;
            <select name="filtro1" class="Ancho_120px" id="filtro1">
                <option value="N">Seleccione</option>
                <option value="fcl" <? if($_POST['filtro1']=='fcl') print 'selected'; ?> >FCL</option>
                <option value="lcl" <? if($_POST['filtro1']=='lcl') print 'selected'; ?> >LCL</option>
                <option value="aereo" <? if($_POST['filtro1']=='aereo') print 'selected'; ?> >AEREO</option>
            </select>            </td>
    </tr>
    <tr align="center" nowrap>
        <td>
            OTM&nbsp;
            <select name="filtro5" class="Ancho_120px" id="filtro5">
                    <option value="N">Seleccione</option>
                <option value="1" <? if($_POST['filtro5']=='1') print 'selected'; ?> >SI</option>
                <option value="0" <? if($_POST['filtro5']=='0') print 'selected'; ?> >NO</option>
            </select>
            Seguro&nbsp;
            <select name="filtro6" class="Ancho_120px" id="filtro6">
                <option value="N">Seleccione</option>
                <option value="1" <? if($_POST['filtro6']=='1') print 'selected'; ?> >SI</option>
                <option value="0" <? if($_POST['filtro6']=='0') print 'selected'; ?> >NO</option>
            </select>
            Aduana&nbsp;
            <select name="filtro7" class="Ancho_120px" id="filtro7">
                <option value="N">Seleccione</option>
                <option value="1" <? if($_POST['filtro7']=='1') print 'selected'; ?> >SI</option>
                <option value="0" <? if($_POST['filtro7']=='0') print 'selected'; ?> >NO</option>
            </select>

            Estado&nbsp;
            <select name="filtro9" class="Ancho_120px" id="filtro9">
                <option value="N">Seleccione</option>
                <option value="en_proceso" <? if($_POST['filtro9']=='en_proceso') print 'selected'; ?> >en_proceso</option>
                <option value="terminada" <? if($_POST['filtro9']=='terminada') print 'selected'; ?> >Seguimiento</option>
            </select>
            Resultado&nbsp;
            <select name="filtro10" class="Ancho_120px" id="filtro10">
                <option value="N">Seleccione</option>
                <option value="exitosa" <? if($_POST['filtro10']=='exitosa') print 'selected'; ?> >Exitosa</option>
                <option value="no_exitosa" <? if($_POST['filtro10']=='no_exitosa') print 'selected'; ?> >No Exitosa</option>
            </select>
        	Origen&nbsp;
        	<select id="filtro11" name="filtro11" class="tex2" >
                <option value="N"> Seleccione </option>
                <?
                $es="select * from aeropuertos_puertos where tipo='puerto' order by nombre";
                $exe=mysqli_query($link,$es);
                while($row=mysqli_fetch_array($exe))
                {
                    $sel = "";
                    if($_POST['filtro11']==$row['idaeropuerto_puerto'])
                        $sel = "selected";
                    print "<option value='$row[idaeropuerto_puerto]' $sel>$row[nombre]</option>";
                }
                ?>
            </select>
            Destino&nbsp;
        	<select id="filtro12" name="filtro12" class="tex2" >
                <option value="N"> Seleccione </option>
                <?
                $es="select * from aeropuertos_puertos where tipo='puerto' order by nombre";
                $exe=mysqli_query($link,$es);
                while($row=mysqli_fetch_array($exe))
                {
                    $sel = "";
                    if($_POST['filtro12']==$row['idaeropuerto_puerto'])
                        $sel = "selected";
                    print "<option value='$row[idaeropuerto_puerto]' $sel>$row[nombre]</option>";
                }
                ?>
            </select>        </td>
    </tr>
    <tr>
        <td class="tit_vueltas" align="center">
        	<!--<input name="boton" class="botonesadmin" style="color:#FFFFFF;" value="Buscar" type="button" onClick="document.location = '<? print $_SERVER['PHP_SELF']; ?>?filtro1=' + document.forms[0].filtro1.value + '&filtro2=' + document.forms[0].filtro2.value + '&filtro3=' + document.forms[0].filtro3.value + '&filtro4=' + document.forms[0].filtro4.value + '&filtro4b=' + document.forms[0].filtro4b.value + '&filtro5=' + document.forms[0].filtro5.value + '&filtro6=' + document.forms[0].filtro6.value + '&filtro7=' + document.forms[0].filtro7.value + '&filtro8=' + document.forms[0].filtro8.value + '&filtro9=' + document.forms[0].filtro9.value + '&filtro10=' + document.forms[0].filtro10.value + '&filtro11=' + document.forms[0].filtro11.value + '&filtro12=' + document.forms[0].filtro12.value + '&filtro13=' + document.forms[0].filtro13.value + '&filtro14=' + document.forms[0].filtro14.value;">
            &nbsp;<input name="boton2" class="botonesadmin" style="color:#FFFFFF;" value="Restablecer filtros" type="button" onClick="document.location = '<? print $_SERVER['PHP_SELF']; ?>';"> -->
			<input type="submit" value="Buscar" class="botonesadmin">
			<input type="button" value="Reestablecer Filtros" class="botonesadmin" onClick="window.location=''">
			       </td>
    </tr>
</table>

<? include("search_cot_anteriores.php"); ?>
</form>
