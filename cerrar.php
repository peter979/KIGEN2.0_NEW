<?php
session_name("current");
session_register("idusuario");
include("conection/conectar.php");

	if (!$_SESSION["idusuario"])
		print ("<script language='javascript' type='text/javascript'>document.location.href='descargas.php'</script>");
	session_destroy();
?>
<script type="text/javascript" language="JavaScript">
	parent.close();
	document.location.href="descargas.php";
</script>