<?
include('sesion/sesion.php');
include("conection/conectar.php");
include_once("permite.php");
include_once("scripts/recover_nombre.php");
set_time_limit(0);



?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="css/admin_internas.css" rel="stylesheet" type="text/css">

    </head>
	<body>
	<!--Titulo-->
   

  

        <br>

        </table><?php $array_order_number = array(); ?>
        <table width="90%" cellpadding="5" align="center" id="tabla" class="contenidotab"  >
          <tr>
            <td class="tittabla">Order number</td>
            <td class="tittabla">No. Operación </td>
            <td class="tittabla">Modalidad</td>
            <td class="tittabla">Origen</td>
            <td class="tittabla">Destino</td>
            <td class="tittabla">Naviera</td>
            <td width="90" class="tittabla">Cantidad</td>
          </tr>
		  
		  <?
		  //Consulta los reportes de estado en lo que la feha actual esté entre los siguientes 15 dias de cada eta
		  
		  $sql="select 
		  			estado.*,
					pt_origen.nombre as origen,
					pt_destino.nombre as destino
					
				from reporte_estado_cli  as estado
				inner join aeropuertos_puertos as pt_origen on estado.puerto_origen = pt_origen.idaeropuerto_puerto
				inner join aeropuertos_puertos as pt_destino on estado.puerto_destino = pt_destino.idaeropuerto_puerto
				where CURDATE() >= estado.eta and CURDATE() <=  DATE_ADD(estado.eta,INTERVAL 15 DAY)   ";
		  $qryRep = mysqli_query($link,$sql);
		  while( $reporte = mysqli_fetch_array($qryRep) ){
			  ?>
			  <tr bgcolor="<? echo ($color == "#CCCCCC") ? $color = "#FFFFFF" : $color = "#CCCCCC"; ?>">
				<td>
				 <a href="re_flete_cli.php?idcliente=<? echo $reporte["idcliente"];?>&idreporte_estado=<? echo $reporte["idreporte_estado"];?>">
					<? echo $reporte["number"];?>
				 </a>
				</td>
				<td><? echo "";?></td>
				<td><? echo $reporte["clasificacion"];?></td>
				<td><? echo $reporte["origen"];?></td>
				<td><? echo $reporte["destino"];?></td>
				<td><? echo $reporte["naviera"];?></td>
				<td>
					<?
					if($reporte["clasificacion"]  =="fcl"){
						echo ($reporte['n20']) ? "<p>Cont. 20: ".$reporte['n20']."</p>" : "" ;
						echo ($reporte['n40']) ? "<p>Cont. 40: ".$reporte['n40']."</p>" : "" ;
						echo ($reporte['n40hq']) ? "<p>Cont. 40hq: ".$reporte['n40hq']."</p>" : "" ;
					}elseif($reporte['clasificacion']  =="lcl"){
						echo "<p>Peso: ".$reporte['peso']."</p><p>Volumen: ".$reporte['volumen']."</p>";
					}elseif($reporte['clasificacion']  =="aereo"){
						echo "<p>Peso: ".$reporte['peso']."</p>";
					}
				?>
				</td>
			  </tr>
		  <?
		  }
		  ?>
			
         </table>

	</body>
</html>