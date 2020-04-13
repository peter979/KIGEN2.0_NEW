<?
	include('sesion/sesion.php');
	include("conection/conectar.php");	
	include_once("permite.php");

	$tabla = "perfiles";
	$llave = "id_perfil";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/admin_internas.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="js/funcionesValida.js"></script>

<script language="javascript">

function validaEnvia(form)
{
	if (validarTexto('nombre', 'Por favor ingrese el nombre') == false) return false;

	form.datosok.value="si";
	form.submit()
}
</script>
</head>
<?php
if($_POST['datosok']=="si")
{
	if($_POST['modRegistro']=="no") // quiere decir que es un registro nuevo
	{
		$queryins="INSERT INTO $tabla (nombre) VALUES (UCASE('$_POST[nombre]'))";
		$buscarins=mysqli_query($link,$queryins);
		if(!$buscarins)
			print ("<script>alert('Error al ingresar perfil')</script>");
		else
		{
			$sql = "SELECT LAST_INSERT_ID() ultimo FROM $tabla";
			$query = mysqli_query($link,$sql);
			$row = mysqli_fetch_array($query);
			$ultimo = $row['ultimo'];
			// ****************************** Modulos ******************************
			$idmodulo = $_POST['idmodulo'];
			for ($i=0; $i<count($idmodulo); $i++)
			{
				$sql = "INSERT INTO permisos_modulos ($llave, idmodulo) VALUES ('$ultimo', '$idmodulo[$i]')";
				$query = mysqli_query($link,$sql);
				//print $sql."<br>";
			}
			// ****************************** Modulos ******************************
		}
	}
	else //quiere decir que es un registro para modificar
	{
		$valor_llave = $_POST[$llave];
		$queryins="UPDATE $tabla SET nombre=UCASE('$_POST[nombre]') WHERE $llave='$valor_llave'";
		$buscarins=mysqli_query($link,$queryins);
		if(!$buscarins)
			print mysqli_error();
		else
		{
			// ****************************** Modulos ******************************
			$idmodulo = $_POST['idmodulo'];
			$sql = "DELETE FROM permisos_modulos WHERE $llave='$valor_llave'";
			//print $sql."<br>";
			$query = mysqli_query($link,$sql);
			for ($i=0; $i<count($idmodulo); $i++)
			{
				$sql = "INSERT INTO permisos_modulos ($llave, idmodulo) VALUES ('$valor_llave', '$idmodulo[$i]')";
				$query = mysqli_query($link,$sql);
				//print $sql."<br>";
			}
			// ****************************** Modulos ******************************
		}
		print ("<script>alert('El perfil ha sido actualizado')</script>");

	}
	//print ("$queryins");
}
//AHORA VERIFICAMOS SI LA VARIABLE ELIMINAR EST� ACTIVA
if($_POST['varelimi']=="si")
{
		$queryelim="DELETE FROM $tabla WHERE $llave IN ($_POST[listaEliminar])";
		$buscarelim=mysqli_query($link,$queryelim);
		if(!$buscarelim)
			print mysqli_error();
		else
		{
			$queryelim="DELETE FROM permisos_modulos WHERE $llave IN ($_POST[listaEliminar])";
			$buscarelim=mysqli_query($link,$queryelim);
		}
}
?></p>
<body style="background-color: transparent;">
<form name="formulario" method="post">
<table width="550" height="400" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="subtitseccion"><?php print strtoupper(str_replace("_", " ", $tabla)); ?></td>
      </tr>
    </table>
      		<br>
			  <input type="hidden" name="varelimi" value="no" />
              <input type="hidden" name="listaEliminar" value="" />
              <input type="hidden" name="nueRegistro" value="no" />
              <input type="hidden" name="conRegistro" value="no" />
              <?php if($_POST['modRegistro'] == "si")
				{
			   ?>
					  <input type="hidden" name="modRegistro" value="si" />
					  <?php
				}else
				{
			   ?>
					  <input type="hidden" name="modRegistro" value="no" />
					  <?php
			   }
			   ?>
    <table width="70%" border="0" cellspacing="0" cellpadding="0">
      <tr>
	  <?php
		if($_POST['nueRegistro'] == "si")
		{
		?>
        <td width="33%" align="center">
        	<table width="60%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin">
          		<tr>
            		<td height="20">Nuevo</td>
          		</tr>
        	</table>
        </td>
        <td width="33%" align="center">
        	<table width="60%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin">
          		<tr>
            		<td height="20">Eliminar</td>
          		</tr>
        	</table>
        </td>
        <td width="33%" align="center">
        	<table width="60%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin">
          		<tr>
            		<td height="20">(X) Salir</td>
          		</tr>
        	</table>
        </td>
      <?php
		}else{
		?>
		<td width="33%" align="center">
			<table width="60%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin" onClick="nuevoRegistro()" style="cursor:pointer;">
				<tr>
					<td height="20">Nuevo</td>
				</tr>
			</table>
        </td>
        <td width="33%" align="center">
        	<table width="60%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin" style="cursor:pointer;" onClick="eliminaRegistros()">
          		<tr>
            		<td height="20">Eliminar</td>
          		</tr>
        	</table>
        </td>
        <td width="33%" align="center">
        	<table width="60%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin" style="cursor:pointer;" onClick="document.location='ppal.php'">
          		<tr>
            		<td height="20">(X) Salir</td>
          		</tr>
        	</table>
        </td>
		<?php
		}
		?>

	  </tr>
    </table>








	 <?php

if($_POST['nueRegistro'] == "si")
{
?>
        <tr>
          <td><!-- AREA O BLOQUE DE INSERCI?N O MODIFICACI?N DEL REGISTRO SELECCIONADO -->
              <table  bordercolor="#000000" width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
				  <?php
					if($_POST['modRegistro']=="si")
					{
						$queryConsu = "SELECT * FROM $tabla WHERE $llave='$_POST[registroSel]'";
						$buscarConsu = mysqli_query($link,$queryConsu);
						$registroConsu = mysqli_fetch_array($buscarConsu);
						$id_perfil = $registroConsu['id_perfil'];
						$nombre = $registroConsu['nombre'];
					}
					else
					{
						$id_perfil = "";
						$nombre = "";
					}
					?>
				<table width="100%" border="0" cellspacing="1" cellpadding="0">
					<input type="hidden" name="<?php print $llave; ?>" id="<?php print $llave; ?>" value="<?php print $registroConsu[$llave]; ?>" />
					<tr>
						<td width="13%" align="left" class="letra">&nbsp;</td>
						<td width="24%" height="40" align="left" class="letra"><div align="left" class="contenidotab">NOMBRE</div></td>
						<td width="63%" align="left">
							<input name="nombre" id="nombre" class="tex1" type="text" value="<?php print $nombre; ?>" maxlength="50">
						</td>
					</tr>
					<tr>
						<td width="13%" align="left" class="letra">&nbsp;</td>
						<td width="13%" align="left" class="letra" colspan="11">
							<table width="100%" border="1" cellpadding="0" cellspacing="0">
								<tr>
									<td>
										<table width="100%" border="1" cellpadding="0" cellspacing="0">
											<tr><th class="contenidotab" colspan="2"><font size="+1">MODULOS</font></th></tr>
											<tr>
												<td width="100%" align="left" class="contenidotab" colspan="2">
												<?php
													$sqla = "SELECT idmodulo, nombre FROM modulos WHERE estado='1' ORDER BY nombre";
													$querya = mysqli_query($link,$sqla);
													print ("<table width=\"100%\" border=\"1\">");
														print ("<tr align=\"center\">");
															print ("<th class=\"tittabla\" height=\"20\">Modulo</th>");
															print ("<th class=\"tittabla\">Relacionado</th>");
															print ("<th class=\"tittabla\">&nbsp;</th>");
															print ("<th class=\"tittabla\" height=\"20\">Modulo</th>");
															print ("<th class=\"tittabla\">Relacionado</th>");
														print ("</tr>");
													$i = 0;
													while ($rowa = mysqli_fetch_array($querya))
													{
														$cheked = "";
														if ($id_perfil!="")
														{
															$sql_rel = "SELECT * FROM permisos_modulos WHERE $llave='$id_perfil' AND idmodulo='$rowa[idmodulo]'";
															$query_rel = mysqli_query($link,$sql_rel);
															$filas = mysqli_num_rows($query_rel);
															if ($filas > 0)
																$cheked = " checked";
														}
														if ($i % 2 == 0)
															print ("<tr align=\"center\">");
																print ("<td class=\"contenidotab\" height=\"20\">$rowa[nombre]</td>");
																print ("<td class=\"letra\" width=\"10%\" nowrap><input name=\"idmodulo[]\" id=\"idmodulo[]\" type=\"checkbox\" value=\"$rowa[idmodulo]\"$cheked></td>");
																if ($i % 2 == 0)
																	print ("<td class=\"letra\" width=\"10%\" height=\"20\">&nbsp;</td>");
														if ($i % 2 != 0)
															print ("</tr>");
														$i++;
													}
													print ("</table>");
												?>
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
                <tr>
                  <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="158"><input name="datosok" type="hidden" value="no" /></td>
                          <td height="20" class="botonesadmin">
                          	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin" onClick="validaEnvia(formulario);" style="cursor:pointer;">
								<tr>
									<td height="20">Guardar</td>
								</tr>
							</table>
                          </td>
                          <td width="52">&nbsp;</td>
                          <td width="91" class="botonesadmin">
                          	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin" onClick="cancelaIngreso()" style="cursor:pointer;">
								<tr>
									<td height="20">Cancelar</td>
								</tr>
							</table>
                          </td>
                          <td width="152" height="20">&nbsp;</td>
                        </tr>
                      </table>
					  </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
            </table>




	<?php
}
if($_POST['conRegistro'] == "si")
{
	//realizo la consulta para mostrar los valores almacenados en ese registro actualmente
	$queryConsu="SELECT * FROM $tabla WHERE $llave='$_POST[registroCons]'";
	$buscarConsu=mysqli_query($link,$queryConsu);
	$registroConsu=mysqli_fetch_array($buscarConsu);

?><BR>
              <table  bordercolor="#000000" width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellpadding="0" cellspacing="1" class="tex1">
                      <tr>
                        <td width="13%" align="left" class="letra">&nbsp;</td>
                        <td width="31%" align="left" class="contenidotab">ID PERFIL</td>
                        <td width="56%" align="left" class="contenidotab"><?php print $registroConsu['id_perfil']; ?></td>
                      </tr>
                      <tr>
                        <td align="left" class="letra">&nbsp;</td>
                        <td align="left" class="contenidotab">NOMBRE</td>
                        <td align="left" class="contenidotab"><?php print $registroConsu['nombre']; ?></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>
                        <input name="datosok" type="hidden" value="no" /><br>
						<table width="11%" height="22" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td width="60" class="botonesadmin">
									<table width="100%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin" onClick="cancelaIngreso()" style="cursor:pointer;">
										<tr>
											<td height="20">Ocultar</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
				  </td>
                </tr>
            </table>
        <?php
}
?>
	<br>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabla">
      <tr>
        <td width="10%" height="20" class="tittabla">Nombre</td>
        <td width="15%" height="20" class="tittabla"><img src="images/ico_consultar.gif" width="14" height="15" align="absmiddle"> Consultar</td>
        <td width="15%" height="20" class="tittabla"><img src="images/ico_modificar.gif" width="7" height="10"> Editar</td>
        <td width="17%" height="20" class="tittabla"><img src="images/ico_eliminar.gif" width="8" height="9"> Eliminar</td>
      </tr>
	   <?php
				$query0="SELECT * FROM $tabla ORDER BY nombre";
				$buscar0=mysqli_query($link,$query0);
				$cant0=mysqli_num_rows($buscar0);
				$regxpag = 10;
				$totpag = ceil($cant0 / $regxpag);
				$pag = $_GET['pag'];
				if (!$pag)
					$pag = 1;
				else
				{
					if (is_numeric($pag) == false)
						$pag = 1;
				}
				$regini = ($pag - 1) * $regxpag;
				$sqlpag = $query0." LIMIT $regini, $regxpag";
				$buscarpag=mysqli_query($link,$sqlpag);
				$cantpag=mysqli_num_rows($buscarpag);
				for($i=0;$i<$cantpag;$i++)
				{
					$registro=mysqli_fetch_array($buscarpag);
				?>
      <tr>
        <td height="20" class="contenidotab"><?php print $registro['nombre']; ?></td>
        <td height="20" class="contenidotab">
        	<input name="registroCons" type="radio" value="<?php print $registro[$llave]; ?>" onClick="consultarRegistro(<?php print $i;?>)"  >
        </td>
        <td height="20" class="contenidotab">
			<input name="registroSel" type="radio" value="<?php print $registro[$llave]; ?>" onClick="modificarRegistro(<?php print $i;?>)" >
		</td>
        <td height="20" class="contenidotab">
	       		<? 
				
				if($registro["$llave"]!="1")
				{
				?>
				<input name="eliSel" type="checkbox" onClick="" value="<?php print $registro[$llave]; ?>" />
				<?
				}
				?>
        </td>
      </tr>
      <?php
				}
				?>
    </table>
    <br>
    <table width="40%" border="0" cellpadding="0" cellspacing="0" class="tabla">
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
											<table width="100%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin" onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=1'" style="cursor:pointer;">
												<tr>
													<td height="15">&lt;&lt;</td>
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
											<table width="100%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin"<?php if ($pag != 1) { ?> onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=<?php print ($pag - 1); ?>'" style="cursor:pointer;"<?php } ?>>
												<tr>
													<td height="15">&lt;</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
							<td width="20%" align="center">
								<label>
								<select name="pag" class="combofecha" onChange="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=' + document.forms[0].pag.value;">
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
											<table width="100%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin"<?php if ($pag != $totpag) { ?> onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=<?php print ($pag + 1); ?>'" style="cursor:pointer;"<?php } ?>>
												<tr>
													<td height="15">&gt;</td>
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
											<table width="100%" border="0" cellpadding="0" cellspacing="0" class="botonesadmin" onClick="document.location='<?php print $_SERVER['PHP_SELF']; ?>?pag=<?php print $totpag; ?>'" style="cursor:pointer;">
												<tr>
													<td height="15">&gt;&gt;</td>
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
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
