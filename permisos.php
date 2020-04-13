<?
	include('sesion/sesion.php');
	include("conection/conectar.php");	
	include_once("permite.php");
?>

<head>
<script>
function des(name)
{

	var e="document.che."+name+".checked";
	if(!eval(e))
	{
		var cr="document.che.cre_"+name+".disabled=true";
		var mo="document.che.mod_"+name+".disabled=true";
		var el="document.che.eli_"+name+".disabled=true";
		var cra="document.che.cre_"+name+".checked=false";
		var moa="document.che.mod_"+name+".checked=false";
		var ela="document.che.eli_"+name+".checked=false";
		eval(cr);
		eval(mo);
		eval(el);
		eval(cra);
		eval(moa);
		eval(ela);
	}
	if(eval(e))
	{

		var crw="document.che.cre_"+name+".disabled=false";
		var mow="document.che.mod_"+name+".disabled=false";
		var elw="document.che.eli_"+name+".disabled=false";
		eval(crw);
		eval(mow);
		eval(elw);
	}
}
</script>
</head>
<body bgcolor="#ffffff" link="#383838" alink="#383838">
<link href="css/admin_internas.css" rel="stylesheet" type="text/css">
<p>
<style>
.letra
	{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	.btm
	{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
		border-top-style: none;
		border-right-style: none;
		border-bottom-style: none;
		border-left-style: none;
		background-color: #D1D1D1;
	}
	.box {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	border-top-color: #FCFCFC;
	border-bottom-style: none;
	border-left-color: #FEFEFE;
	border-right-style: none;
	}
</style>
<?
//modulos sin espacios
$list_mod="select idmodulo, nombre from modulos_nombres where estado='1'";
$exe_list_mod=mysqli_query($link,$list_mod);
$h="0";
while($pors=mysqli_fetch_array($exe_list_mod))
{
	$mod[$h]=$pors["nombre"];
	$idmod[$h]=$pors["idmodulo"];
	$h++;
}
$num=count($mod);
$rowcolor="#F2F2F2";//color de cada fila
if($_POST['save'])
{
$cedula=$_POST['usuario'];
//print "usuario $cedula";

for($u=0;$u<$num;$u++)
{
	$modul=$_POST[''.$mod["$u"]];
	if($_POST[''.$mod["$u"]]!="")
	{
		if($_POST['cre_'.$mod["$u"]]=="") $crea=0; else $crea=1;
		if($_POST['mod_'.$mod["$u"]]=="") $modu=0; else $modu=1;
		if($_POST['eli_'.$mod["$u"]]=="") $elim=0; else $elim=1;
$aja="select cc from modulos where cc=$cedula and id_mod='$modul'";//busca modulos ya asingados a un usuario
$ejea=mysqli_query($link,$aja);
$tot=mysqli_num_rows($ejea);
		if($tot==1)//si ya tiene algunos permisos definidos
		{
			$queryper="update modulos set c=$crea, m=$modu, e=$elim where cc=$cedula and id_mod='$modul'";
			$eje=mysqli_query($link,$queryper);
//			print "$queryper<br>";
		}
		if($tot==0)//si el usuario seleccionado no tiene permisos definidos
		{
			$queryper="insert into modulos values($cedula,'$modul',$crea,$modu,$elim)";
	//		print "$queryper<br>";
			$eje=mysqli_query($link,$queryper);
		}
//print "<br>var ".$_POST[''.$mod["$u"]]." - $crea $modu $elim      $queryper";
	}//cierra if el nmbre del modulo que llega es diferente de vacio
	if($_POST[''.$mod["$u"]]=="")//si el modulo del for es vacio
	{
		$modul=$mod[$u];
		$aja="select cc from modulos where cc=$cedula and id_mod='$modul'";//busca si el modulo vacio ya fue asigando antes
		$ejea=mysqli_query($link,$aja);
		$tot=mysqli_num_rows($ejea);
		//print "<br>Modulo que existia pero llego vacio esta vez: $modul, filas $tot";
		if($tot==1)//si el modulo que llego vacio esta en la tabla quiere decir que encontro un registro, que existia
		{
			$del="delete from modulos where cc=$cedula and id_mod='$modul'";
			$exe=mysqli_query($link,$del);
		}
	}
}//cierra for que permite preguntas si los modulos que llegan son vacios o no
}//cierra if si presiono guardar
?>
</p>
<p><br>
</p>
<div align="center" class="letra"><strong>ADMINISTRACI&Oacute;N DE PERMISOS</strong></div>
<br>
<form method="post" name="che" action="permisos.php">
<TABLE width="90%" border="0" align="center" class="letra">
<tr><td align="center" colspan="2">
<? if ($_GET['usu']!="") { ?><input type="submit" name="save" value="Guardar permisos"  class="botonesadmin" style="color:#FFFFFF;">&nbsp;<? }?></td>
<td align="center">
<?
if($_GET['usu']!="")
{
	$ce=$_GET['usu'];
	?><input type="hidden" value="<? print $ce;?>" name="usuario"><?
	$ry="select nombre from perfiles where id_perfil='$ce'";
	$jer=mysqli_query($link,$ry);
	print "Permisos del perfil <strong>".mysqli_result($jer,0,"nombre")."</strong>";
}
else
	print "Seleccione un perfil para iniciar";
?></td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td valign="top">
<TABLE width="50%" border="0" align="center" class="letra">
<tr><td align="center" nowrap="nowrap" bgcolor='<? print $rowcolor;?>' colspan="2"><strong>Perfiles</strong></td></tr>
<?
$query="select * from perfiles order by nombre";
//print $query;

$je=mysqli_query($link,$query);
$tot=mysqli_num_rows($je);
for($i=0;$i<$tot;$i++)
{
	print "<tr><td bgcolor='$rowcolor' align='left' nowrap='nowrap' width='20%'><a href='permisos.php?usu=".mysqli_result($je,$i,"id_perfil")."' style='text-decoration:none;'>".mysqli_result($je,$i,"nombre")."</a></td></tr>";
}
?>
</TABLE>
</td>
<td valign="top">
<TABLE width="40%" border="0" align="center" class="letra">
	<tr bgcolor='<? print $rowcolor;?>'>
	<td align="center" valign="top" nowrap="nowrap" bgcolor='<? print $rowcolor;?>'><strong>Usuarios</strong></td>
</tr>
	<?
	$query="select * from usuarios where idperfil='$_GET[usu]' order by nombre";
	//print $query;
	$je=mysqli_query($link,$query);
	while($posh=mysqli_fetch_array($je))
	{
		print "<tr><td>$posh[nombre]<td></tr>";
	}
	
	?>

</TABLE>
</td>
<td valign="top">
	<TABLE width="40%" border="0" align="center" class="letra">
	<tr bgcolor='<? print $rowcolor;?>'><td align="center" nowrap="nowrap" bgcolor='<? print $rowcolor;?>'><strong>M&oacute;dulos</strong> (consultar)</td>
	<td>&nbsp;&nbsp;Crear&nbsp;&nbsp;&nbsp;</td>
	<td>Modificar&nbsp;</td>
	<td>Eliminar&nbsp;</td>
	</tr>

<?
for($j=0;$j<$num;$j++)
{
	print "<tr bgcolor='$rowcolor'>"?>
	<td nowrap class="letra">
	<input type='checkbox' name="<? print $mod[$j];?>" value="<? print "".$mod[$j];?>" onClick="des(this.name)"
	<? if($_GET['usu']!="")
	{
		$cd=$_GET['usu']; $ml=$mod[$j];
		$qu="select * from modulos where cc=$cd and id_mod='$ml'";
		$res=mysqli_query($link,$qu);
		$ni=mysqli_num_rows($res);
		if($ni==1)
			print "checked";
	 	if($ni==0)
			print "unchecked";
	}
	else
		print "unchecked disabled";
	?> >&nbsp;
	<font <? if($_GET['usu']=="") print "color='#999999'";?> class="letra" ><? print $mod[$j];?></font>

	</td>
	<td align='center'><? if($mod[$j]!="Backup") {?><input type='checkbox' name="<? print "cre_".$mod[$j];?>" <? if($ni==1) if(mysqli_result($res,0,"c")==1) print "checked"; else print "unchecked"; if($ni==0) print "disabled";?> <? if($_GET['usu']=="") print "disabled";?> value="<? print "".$mod[$j];?>"><? }?></td>
	<td align='center'><? if($mod[$j]!="Backup") {?><input type='checkbox' name="<? print "mod_".$mod[$j];?>" <? if($ni==1) if(mysqli_result($res,0,"m")==1) print "checked"; else print "unchecked"; if($ni==0) print "disabled";?> <? if($_GET['usu']=="") print "disabled";?> value="<? print "".$mod[$j];?>"><? }?></td>
	<td align='center'><? if($mod[$j]!="Backup") {?><input type='checkbox' name="<? print "eli_".$mod[$j];?>" <? if($ni==1) if(mysqli_result($res,0,"e")==1) print "checked"; else print "unchecked"; if($ni==0) print "disabled";?> <? if($_GET['usu']=="") print "disabled";?> value="<? print "".$mod[$j];?>"><? }?></td>
	<? print"</tr>";
}
?>

	</TABLE>
</td>
</tr>
</TABLE>
</form>
</BODY>

