<?php
session_start();
include("conection/conectar.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>.:TEST-KIGEN:.</title>
	    
	<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
	<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
        <!--<link href="todo.css" rel="stylesheet" type="text/css" />-->
	<!--<script type="text/javascript" src="js/jquery-1.8.3.js"></script>-->
	<style type="text/css">
	/*COLOR Y FONDO DE APLICATIVO*/
	body {
		margin-left: 0px;
		margin-top: 0px; 
		margin-right: 0px;
		margin-bottom: 0px;
/*		background-image: url(images/fondoSite.jpg);
		background-repeat: repeat-x;*/
		background-color: #FFFFFF;
                font-family: 'Quicksand', serif;
	}
	
	
	.toptablas {
		background-position:top;
		font-size:11px;
	
		text-align:left;
		padding-left:5px;
	}
	
	body {
		margin-left: 0px;
		margin-top: 0px;
	
	
	}
	</style>
	<?

    if($_SESSION['numberid']==""){ //si no se ha inciado session muestra la pantalla del nombre del programa?>
		<style>
			#overlay {
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background-color: #000;
				filter:alpha(opacity=70);
				-moz-opacity:0.7;
				-khtml-opacity: 0.7;
				opacity: 0.7;
				z-index: 100;
				display: none;
			}
			
			.popup{
				width: 100%;
				margin: 0 auto;
				display: none;
				position: fixed;
				z-index: 101;
		
			}
			.cnt223{
				min-width: 650px;
				width: 600px;
				min-height: 210px;
				margin: 100px auto;
				background: #f3f3f3;
				position: relative;
				z-index: 103;
				padding: 10px;
				border-radius: 5px;
				box-shadow: 0 2px 5px #000;
			}
			.cnt223 p{
				clear: both;
				color: #555555;
				text-align: justify;
			}
			.cnt223 p a{
				color: #d91900;
				font-weight: bold;
			}
			.cnt223 .x{
				float: right;
				height: 35px;
				left: 22px;
				position: relative;
				top: -25px;
				width: 34px;
			}
			.cnt223 .x:hover{
				cursor: pointer;
			}
		</style>
		<script type='text/javascript'>
			$(function(){
				var overlay = $('<div id="overlay"></div>');
				overlay.show();
				overlay.appendTo(document.body);
				$('.popup').show();
				$('.close').click(function(){
				$('.popup').hide();
				overlay.appendTo(document.body).remove();
				return false;
			});
			
			$('.x').click(function(){
				$('.popup').hide();
				overlay.appendTo(document.body).remove();
				return false;
			});
		});
		</script><?
	}
	?>
</head>

<body>
<?
if($_SESSION['numberid']==""){?>
	<div class='popup'>
		<div class='cnt223' style="text-align:center">
		

			<!--	<img src="images/gatewaysoft.png" />-->
			<br/>
			<?php 
			$sqlMessage = "select * from messages where active = '1'";
			$dates = mysqli_query($link,$sqlMessage);
			$message = @mysqli_fetch_array($dates); 
			?>
			<p style="font-size: 15px; color: red; font-weight: 500; text-align:center;"><?php echo $message['message']; ?></p>
			<br/>
			<a href='' class='close'>Entrar</a>

		</div>
	</div>
	
<?
}
?>
<div align="center">
<table width="94%" border="0" cellpadding="0" cellspacing="0">
    <tr>
       <!-- <td width="65%" class="contenidotab>" bgcolor="#FFFFFF">-->
			<?
            if($_SESSION['perfil']!='')
            {
				print "<span class='tex2' style='font-size:20px;'>Bienvenido</span><br>";
				$login=$_SESSION['nick'];
				$perfil=$_SESSION['perfil'];
				$query="select * from modulos where cc='$perfil'";
				$exe=mysqli_query($link,$query);
				$num=mysqli_num_rows($exe);//numero de modulos en los que tiene acceso
				
				$rt="select nombre from perfiles where id_perfil='$perfil' and estado='1'";
				$exx=mysqli_query($link,$rt);
				$es=mysqli_fetch_array($exx);
				print "<span class='tex2' style='font-size:12px;'>USUARIO: $login &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Perfil: $es[nombre]</span>";
            }

            ?>
    	</td>
        <?
        if($_SESSION['numberid']!="")
		{
			?><!--COLOR CONTENEDOR LOGO Y MODULO-->
        	<td class="contenidotab" bgcolor="#FFFFFF" nowrap="nowrap"><? include('selecciona_modulo.php');?></td>
        	<?
		}
		?>
        
        <td width="35%" height="80%" align="center" valign="bottom" bgcolor="#FFFFFF"><img src="images/logo.png" >
      
    	</td>
    </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>

        <td width="100%" valign="top" align="center">
			<?
            // print "rock ".$_SESSION['numberid'];
            if($_SESSION['numberid']=="")
            	include("auten.php");
            if($_SESSION['numberid']!="")
           		include("inicio.php");
            ?>
        </td>
    </tr>
</table>

</div>
</body>
</html>
