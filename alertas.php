<?
include("./conection/conectar.php");
function crearAlerta($idUsuario,$idPerfil,$tipo,$orderNumber){
	global $link;
	$sqlCreate = "INSERT INTO `alertas` (
						`id_usuario`, 
						`id_perfil`, 
						`order_number`, 
						`tipo`, 
						`habilitada`
					) VALUES (
						$idUsuario, 
						$idPerfil, 
						'$orderNumber',
						$tipo, 
						'1'
					); ";
	if(!mysqli_query($link,$sqlCreate)){
		echo "nooooo<br>".mysqli_error()."<br>".$sqlCreate."<br>" ;die();
	}
	
	
}

function getNumAlertas($idPerfil,$idUsuario){
 global $link;
 $sqlAlert = "select * from alertas where (id_perfil = $idPerfil or id_usuario = $idUsuario)	 and habilitada = 1";

 $qryAlert = mysqli_query($sqlAlert);
 return  mysqli_num_rows($qryAlert);
}
function getNameAlert($tipo){
	switch($tipo){
		case 1:
			return "Creacion de nuevo reporte de estado";
			break;
	}

}
/*
	TIPOS DE ALERTAS
		1.Se activaa servicio al cliente, cuando se crea un reporte de estado
*/
?>
