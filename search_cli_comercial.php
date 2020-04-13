<?
include_once('./sesion/sesion.php');
include_once("./conection/conectar.php");	
include_once("./permite.php");
include_once("scripts/recover_nombre.php");
$sesi=session_id();		  

$parametros = " + '&filtro1=' + document.formulario.filtro1.value + '&filtro3=' + document.formulario.filtro3.value";

?>
<script>

function sel_todos()
{
	if(document.getElementById("all_off").checked)/*SELECCIONAR TODOS*/
	{
		if(document.formulario.selcli.length <= 1 || document.formulario.selcli.length == null)
		{
			document.formulario.selcli.checked = true;
		}else
		{
			for(i=0;i<document.formulario.selcli.length;i++)
			{
				document.formulario.selcli[i].checked = true;
			}
		}
	}
	else /*DES SELECCIONAR TODOS*/
	{
		if(document.formulario.selcli.length <= 1 || document.formulario.selcli.length == null)
		{
			document.formulario.selcli.checked = false;
		}else
		{
			for(i=0;i<document.formulario.selcli.length;i++)
			{
				document.formulario.selcli[i].checked = false;
			}
		}
	}
}

function validarcheckeo(name, id)
{
	//alert(name + ',' + id);
	if(document.getElementById(name).checked)
	{
		document.getElementById(id).value = '1';
	}
	else
	{
		document.getElementById(id).value = '0';
	}
}
</script>

<div id="eyes_cli" style="width:100%; height:100%; overflow-x: scroll; overflow-y: scroll;">
<?


//if($_GET['filtradocli']=='1')
$sqlc = "select idcliente from clientes_tmp where idusuario='$_SESSION[numberid]'";
/*else
	$sqlc = "select idcliente from clientes";*/
//print $sqlc.'<br>';
$exec = mysql_query($sqlc, $link);
$filasc = mysql_num_rows($exec);

$idclientes[] = '0';
while ($datosc = mysql_fetch_array($exec))
{
	$idclientes[] = $datosc['idcliente'];
}
//print_r($idclientes);
	 
$sqlc="select * from clientes where 1";	
//print 'ver_sel_cli'.$_GET['ver_sel_cli'].'<br>';

if($_GET['ver_sel_cli']=='1')
	$sqlc .= " and idcliente in (select idcliente from clientes_tmp where idusuario='$_SESSION[numberid]') ";			
	
if ($_GET['filtro1']!='' && $_GET['filtro1']!='N')
	$sqlc .= " AND idvendedor ='$_GET[filtro1]'";
	
	//select idvendedor_customer from vendedores_customer where nombre like '%$_GET[filtro2]%'
if ($_GET['filtro2']!='')
	$sqlc .= " AND  idoperativo in (select idvendedor_customer from vendedores_customer where nombre like '%$_GET[filtro2]%') ";

if ($_GET['filtro3']!='')
	$sqlc .= " AND nombre like '%$_GET[filtro3]%' ";

if ($_GET['filtro5']!='')
	$sqlc .= " AND idcliente in (select idcliente from reporte_estado_cli where ref like '%$_GET[filtro5]%' or ref2 like '%$_GET[filtro5]%') ";
	
	
//Si es comercial solo permite ver los clientes asignados
if($_SESSION['perfil'] == "2"){ // si es comercial solo muestra sus propios clientes
	$sqlc .= " AND idvendedor = (select idusuario from usuarios where idusuario = ".$_SESSION['numberid']." limit 0,1) ";

}

$sqlc .= " and estado='1' ";
$sqlc .= " order by nombre ";



$execc=mysql_query($sqlc,$link);
	$cant=mysql_num_rows($execc);

//print $sqlc.'<br>';
?>
<table width="100%" id="tabla" cellpadding="5" class="contenidotab"> 
	<tr>
		<!--<td class="tittabla"><img src="./images/ico_modificar.gif" width="7" height="10">Sel <input type="checkbox" name="all_off" id="all_off" onClick="sel_todos()"></td>-->
		<td class="tittabla">#</td>
		<td class="tittabla">Raz&oacute;n social</td>
		<td class="tittabla">NIT</td>
		<td class="tittabla">Vendedor</td>
		<td class="tittabla">Servicio al cliente</td>
		<td class="tittabla">Operativo</td>
	</tr>    
	<?











$regxpag = 20;//cantidad de items por pagina
        $totpag = ceil($cant / $regxpag);
        $pag = $_GET['pag'];
        if (!$pag)
            $pag = 1;
        else
        {
            if (is_numeric($pag) == false)
                $pag = 1;
        }
        $regini = ($pag - 1) * $regxpag;
        $sqlpag = $sqlc." LIMIT $regini, $regxpag";
        $buscarpag=mysql_query($sqlpag,$link);
        $cantpag=mysql_num_rows($buscarpag);
		$y=1;
	if($pag!=1)$num=($pag-1)*20; else $num=0;
        for($i=0;$i<$cantpag;$i++)
        {
            $datosc=mysql_fetch_array($buscarpag);


	$exec=mysql_query($sqlc,$link);

	$clipag = '';
	
		if($clipag!='')
			$clipag .= ',';
		$clipag .= $datosc['idcliente'];
		
		$color = ($color == "#CCCCCC") ? "white" : "#CCCCCC";
		?>
		<tr bgcolor="<? echo $color?>">

			<td><? print ($i+1)+$num ?> &nbsp;</td>
			<td>&nbsp;<a href="seguimientos_cliente.php?idcliente=<? print $datosc['idcliente']; ?>" target="ppal"><? print $datosc['nombre']; ?></a></td>
			<td>&nbsp;<? print $datosc['nit']; ?></td>
			<td>&nbsp; <? print scai_get_name("$datosc[idvendedor]","vendedores_customer", "idvendedor_customer", "nombre"); ?></td>
			<td> &nbsp;<? print  scai_get_name("$datosc[idcustomer]","vendedores_customer", "idvendedor_customer", "nombre"); ?></td>
			<td> &nbsp;<? print scai_get_name("$datosc[idoperativo]","vendedores_customer", "idvendedor_customer", "nombre"); ?></td>
		</tr>        
		<?
	

}
	?>
	<input type="hidden" id="clipag" name="clipag" value="<? print $clipag; ?>">
</table>









<table width="40%" border="0" cellpadding="0" cellspacing="0" class="tabla" align="center">
      <tr>
        <td width="16%" height="20" class="tittabla"><img src="images/ico_paginas.gif" width="15" height="12" align="absmiddle"> Paginaci&oacute;n</td>
        </tr>
      <tr>
        <td height="20" align="center">
        			<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20%" align="center">
								<table width="50%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="15" class="botonesadmin">
											<table width="100%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin" onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=1'<? print $parametros; ?>;" style="cursor:pointer;">
												<tr>
													<td height="15" style="color:#FFFFFF">&lt;&lt;</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
							<td width="20%" align="center">
								<table width="50%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="15" class="botonesadmin">
											<table width="100%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin"<?php if ($pag != 1) { ?> onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=<?php print ($pag - 1); ?>'<? print $parametros; ?>" style="cursor:pointer;"<?php } ?>>
												<tr>
													<td height="15" style="color:#FFFFFF">&lt;</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
							<td width="20%" align="center">
								<label>
								<select name="pag" class="combofecha" onChange="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag='+ document.forms[0].pag.value<? print $parametros; ?>;">
								<?php
									for ($i=1; $i<=$totpag; $i++)
									{
										if ($i == $pag)
											print "<option value=$i selected>$i</option>";
										else
											print "<option value=$i>$i</option>";
									}
								?>
								</select>
								</label>
							</td>
							<td width="20%" align="center">
								<table width="50%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="15" class="botonesadmin">
											<table width="100%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin"<?php if ($pag != $totpag) { ?> onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=<?php print ($pag + 1); ?>'<? print $parametros; ?>;" style="cursor:pointer;"<?php } ?>>
												<tr>
													<td height="15" style="color:#FFFFFF">&gt;</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
							<td width="20%" align="center">
								<table width="50%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="15" class="botonesadmin">
											<table width="100%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin" onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=<?php print $totpag; ?>'<? print $parametros; ?>;" style="cursor:pointer;">
												<tr>
													<td height="15" style="color:#FFFFFF">&gt;&gt;</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
        		</td>
      		</tr>
		</table>
	</td>
</tr>
</table>



</div>
