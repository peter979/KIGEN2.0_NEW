<?
include('./sesion/sesion.php');
include("./conection/conectar.php");	
include_once("./permite.php");
include_once("scripts/recover_nombre.php");

if($_POST['datosok']=='si')
{
	//fotos--------------------------------------------------------------------------------------------------------------------
	if ($mueve = move_uploaded_file($_FILES['formato_foto']['tmp_name'], "erpoperativo/formatos_foto/".$_FILES['formato_foto']['name']))
	{
		$nombre = $_FILES['formato_foto']['name'];
		$sql = "INSERT INTO formatos_foto (idusuario, nombre, fecha) VALUES ('$_SESSION[numberid]', '$nombre', NOW())";
		//print $sql.'<br>';
		$query = mysqli_query($link,$sql);
		
		$sql = "SELECT LAST_INSERT_ID() ultimo FROM formatos_foto";
		$exe = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($exe);
		$idformato = $row['ultimo'];
	}
	//-----------------------------------------------------------------------------------------------------------------------

	$sql = "select * from reporte_negocios where idcot_temp='$_GET[idcot_temp]'";
	//print $sql.'<br>';
	$exe = mysqli_query($link,$sql);
	$filas = mysqli_num_rows($exe);
	$datosft = mysqli_fetch_array($exe);

	if($idformato == '')
		$idformato = $datosft['idformato_foto'];

	if($filas > 0)
		$sql = "update reporte_negocios set idformato_foto='$idformato' where idcot_temp='$_GET[idcot_temp]'";
	else
		$sql = "insert into reporte_negocios (idcot_temp, idformato_foto) values('$_GET[idcot_temp]', '$idformato')";

	//print $sql.'<br>';
	$exe = mysqli_query($link,$sql);
}
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

<form enctype="multipart/form-data" name="formulario" id="formulario" method="post">
<input name="datosok" type="hidden" value="no" />
<table width="100%">
	<tr>
    	<td class="subtitseccion" style="text-align:center" >MODALIDADES COTIZACI&Oacute;N <? print scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "numero"); ?><br><br></td>
    </tr>
    <tr>
        <td class="subtitseccion" colspan="3" style="text-align:center; font-size:10px">Selecciona la modalidad para confirmar los origenes aceptados en la cotización<br><br></td>
    </tr>
</table>
<?
//carga------------------------------------------------------------------------------------------------------------------------
if($_GET['exporta']!='si')
{
	?>
	<table align="center">
		<?
		$sql = "select * from reporte_negocios where idcot_temp='$_GET[idcot_temp]'";
		//print $sql.'<br>';
		$exe = mysqli_query($link,$sql);
		$filas = mysqli_num_rows($exe);
		$datosft = mysqli_fetch_array($exe);

		$sql = "select * from formatos_foto where idformato_foto in (select idformato_foto from reporte_negocios where idformato_foto='$datosft[idformato_foto]')";
		//print $sql.'<br>';
		$exeft = mysqli_query($link,$sql);
		while($datosft = mysqli_fetch_array($exeft))
		{
			?>
			<tr>
				<td class="contenidotab"><a href="./erpoperativo/formatos_foto/<? print $datosft['nombre']; ?>" target="_blank">Fotos actual: <? print $datosft['nombre'].' - '.$datosft['fecha']; ?></a></td>
			</tr>
			<?
		}
		?>
		<tr>
			<td class="contenidotab">Fotos</td>
		</tr>    
		<tr>        
			<td class="contenidotab"><input type="file" name="formato_foto" id="formato_foto"/></td>
		</tr>
	</table>
	<?
}
//-----------------------------------------------------------------------------------------------------------------------------
?>
<table width="100%">
    <tr>
        <td class="tittabla">Modalidad</td>
    </tr>    
        <?
		$restricciones = 0;
		
		$sql = "select * from modalidades_reportes where idcot_temp='$_GET[idcot_temp]'";
		//print $sql.'<br>';
		$exe = mysqli_query($link,$sql);
		$datos = mysqli_fetch_array($exe);
		if($datos['flete']=='1')
		{
			$_GET['cl'] = scai_get_name("$_GET[idcot_temp]", "cot_temp", "idcot_temp", "clasificacion"); 
			
			$color = '#003300';	
			if($_GET['cl'] == 'fcl' || $_GET['cl'] == 'lcl')		
				$sqlrn = "select * from rn_fletes where idreporte='$_GET[idcot_temp]'";
			if($_GET['cl'] == 'aereo')
				$sqlrn = "select * from rn_fletes_aereo where idreporte='$_GET[idcot_temp]'";
			//print $sqlrn.'<br>';
			$exern = mysqli_query($link,$sqlrn);
			$filasrn = mysqli_num_rows($exern);

			if($_GET['cl'] == 'fcl' || $_GET['cl'] == 'lcl')
				$sqlrn = "select * from rn_fletes where idreporte='$_GET[idcot_temp]' and (name='')";
			if($_GET['cl'] == 'aereo')
				$sqlrn = "select * from rn_fletes_aereo where idreporte='$_GET[idcot_temp]' and (name='')";
			//print $sqlrn.'<br>';
			$exern = mysqli_query($link,$sqlrn);
			$filasrn2 = mysqli_num_rows($exern);
			if($filasrn== 0 || $filasrn2 > 0)
			{
				$color = '#FF0000';
				$restricciones += 1;
			}
			?>
            <tr>
            	<td class="contenidotab"><a href="rn_flete.php?idcot_temp=<? print $_GET['idcot_temp']; ?>" style="color:<? print $color; ?>">Flete<? if($datos['seguro']=='1') print '-Seguro'; ?></a></td>
            </tr>            
            <?
		}
		if($datos['otm']=='1')
		{
			$color = '#003300';			
			$sqlrn = "select * from rn_otm where idreporte='$_GET[idcot_temp]'";
			//print $sqlrn.'<br>';
			$exern = mysqli_query($link,$sqlrn);
			$filasrn = mysqli_num_rows($exern);
			//print 'filasrn '.$filasrn.'<br>';

			$sqlrn = "select * from rn_otm where idreporte='$_GET[idcot_temp]' and corte_hbl=''";
			//print $sqlrn.'<br>';
			$exern = mysqli_query($link,$sqlrn);
			$filasrn2 = mysqli_num_rows($exern);
			//print 'filasrn2 '.$filasrn2.'<br>';
			if($filasrn== 0 || $filasrn2 > 0)
			{
				$color = '#FF0000';
				$restricciones += 1;
			}
			?>
            <tr>
            	<td class="contenidotab" style="color:<? print $color; ?>"><a href="rn_otm.php?idcot_temp=<? print $_GET['idcot_temp']; ?>" style="color:<? print $color; ?>">OTM</a></td>
            </tr
            ><?
		}
		if($datos['terrestre']=='1')
		{
			$color = '#003300';			
			$sqlrn = "select * from rn_terrestre where idreporte='$_GET[idcot_temp]'";
			//print $sqlrn.'<br>';
			$exern = mysqli_query($link,$sqlrn);
			$filasrn = mysqli_num_rows($exern);
			if($filasrn== 0)
			{
				$color = '#FF0000';
				$restricciones += 1;
			}
			?>
            <tr>
            	<td class="contenidotab" style="color:<? print $color; ?>"><a href="rn_terrestre.php?idcot_temp=<? print $_GET['idcot_temp']; ?>" style="color:<? print $color; ?>">Carga nacionalizada</a></td>
            </tr
            ><?
		}
		if($datos['seguro']=='1')
		{
			$color = '#003300';
			$sqlrn = "select * from rn_seg where idreporte='$_GET[idcot_temp]'";
			//print $sqlrn.'<br>';
			$exern = mysqli_query($link,$sqlrn);
			$filasrn = mysqli_num_rows($exern);
						
			$sqlrn = "select * from shipping_instruction_seg where idreporte='$_GET[idcot_temp]' and idformato_seguro='0'";
			//print $sqlrn.'<br>';
			$exern = mysqli_query($link,$sqlrn);
			$filasrn2 = mysqli_num_rows($exern);
			if($filasrn == 0 /*|| $filasrn2 > 0*/)
			{
				$color = '#FF0000';
				$restricciones += 1;
			}
			?>
			<tr>
				<td class="contenidotab"><a href="rn_seguro.php?idcot_temp=<? print $_GET['idcot_temp']; ?>" style="color:<? print $color; ?>">Seguro</a></td>
			</tr>
			<?	
		}		
		if($datos['aduana']=='1')
		{
			$color = '#003300';			
			$sqlrn = "select * from rn_adu where idreporte='$_GET[idcot_temp]'";
			//print $sqlrn.'<br>';
			$exern = mysqli_query($link,$sqlrn);
			$filasrn = mysqli_num_rows($exern);
			if($filasrn== 0)
			{
				$color = '#FF0000';
				$restricciones += 1;
			}
			?>
            <tr>
            	<td class="contenidotab"><a href="rn_aduana.php?idcot_temp=<? print $_GET['idcot_temp']; ?>" style="color:<? print $color; ?>">Aduana</a></td>
            </tr>
        	<?
		}
		if($datos['bodega']=='1')
		{
			$color = '#003300';			
			$sqlrn = "select * from rn_bodegas where idreporte='$_GET[idcot_temp]'";
			//print $sqlrn.'<br>';
			$exern = mysqli_query($link,$sqlrn);
			$filasrn = mysqli_num_rows($exern);
			if($filasrn== 0)
			{
				$color = '#FF0000';
				$restricciones += 1;
			}
			?>
            <tr>
            	<td class="contenidotab"><a href="rn_bodega.php?idcot_temp=<? print $_GET['idcot_temp']; ?>" style="color:<? print $color; ?>">Bodega</a></td>
            </tr>
        	<?
		}
		?>
    </tr> 
</table>
<table>
	<tr>
        <td colspan="5" align="left">
            <table>
                <tr>
                	<td width="60" class="botonesadmin"><a href="sel_cotizaciones.php" onClick="">Atras</a></td>
                    <? if(puedo("c","REPORTES_NEGOCIO")==1 || puedo("m","REPORTES_NEGOCIO")==1) { ?>	
					<td width="60" class="botonesadmin"><a href="javascript: void(0)" onClick="validaEnvia(formulario);">Guardar</a></td>                    <?
					}
					if($restricciones == 0)
					{
						$sql = "select * from reporte_negocios where idcot_temp='$_GET[idcot_temp]'";
						$exe = mysqli_query($link,$sql);
						$filasrep = mysqli_num_rows($exe);
						
						if($filasrep == 0)
						{
							$sql = "insert into reporte_negocios(idcot_temp) values($_GET[idcot_temp])";
							$exe = mysqli_query($link,$sql);
						}
						?>
                        <td width="60" class="botonesadmin" title="Notificar a operaciones el cierre de este reporte de negocio"><a href="mail_notificacion.php?idcot_temp=<? print $_GET['idcot_temp']; ?>" onClick="">Notificar a operaciones</a></td>
                        <?
					}
					?>
                </tr>
            </table> 
        </td>        	
    </tr>
</table>
</form>
