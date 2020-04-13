<?
include_once("./alertas.php");
?>
<table align="center" border="0" width="100%">

</table>

<ul id="MenuBar1" class="MenuBarHorizontal">
<?
for($i=0;$i<$num;$i++)
{
$opcion=mysqli_result($link,$exe,$i,"id_mod");
if($opcion=="ADMINISTRACION")//ADMINISTRACION
{
?>

	<li><a href="javascript:void(0);" style="font-size:11px;" class="MenuBarItemSubmenu" target="ppal">Administracion<br />&nbsp;</a>
		<ul>
			<li><a href="perfiles.php" style="font-size:11px;" target="ppal"><strong>Administrar Perfiles</strong></a></li>
			<li><a href="usuarios.php" style="font-size:11px;" target="ppal"><strong>Administrar Usuarios</strong></a></li>
			<li><a href="permisos.php" style="font-size:11px;" target="ppal"><strong>Administrar Permisos</strong></a></li>
            <li><a href="contacto_puerto.php" style="font-size:11px;" target="ppal"><strong>Administrar Contacto Puerto</strong></a></li>
		</ul>
	</li>
<?
}
}
?>
<?
for($i=0;$i<$num;$i++){
	$opcion=mysqli_result($link,$exe,$i,"id_mod");
	if($opcion=="CLIENTES"){ //CLIENTES ?>	
		<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Clientes<br />&nbsp;</a>
			<ul>
				<li><a href="clientes.php?idcliente=<? print $_GET['idcliente'] ?>" style="font-size:11px;" target="ppal">
					<strong>Admin. Clientes y cont&aacute;ctos</strong></a>
				</li>
				<li><a href="reporte_doc_cli.php" style="font-size:11px;" target="ppal">
					<strong>Reporte Vencimiento de documentos</strong></a>
				</li>
				<li><a href="shipper.php" style="font-size:11px;" target="ppal"><strong>SHIPPER</strong></a></li>
				<li><a href="desercion_cli.php" style="font-size:11px;" target="ppal"><strong>Informe - Deserci&oacute;n de Clientes</strong></a></li>
					<? if(puedo("c","LISTAR_CLIENTE")) { ?>
						<li><a href="tablacli.php" style="font-size:11px;" target="_blank"><strong>Listar Clientes</strong></a></li>
						<li><a href="solicitar_cotizacion.php" style="font-size:11px;" target="ppal"><strong>Solicitar Cotizaci&oacute;n</strong></a></li>
						<li><a href="comunicado_masivo.php" style="font-size:11px;" target="ppal"><strong>Comunicados Masivos</strong></a></li>
					<? }
					if(puedo("c","REPORTE_CLIENTE")) { ?>
						<li><a href="javascript:winbackex('scripts/export.php?table=clientes')" style="font-size:11px;">
							<strong>Exportar listado de Clientes</strong></a>
						</li><? 
					}
					for($i=0;$i<$num;$i++)
					{
						$opcion=mysqli_result($link,$exe,$i,"id_mod");
						if($opcion=="CLIENTES")//DOCUMENTOS
						{
						?>
							<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Documentos</a>
								<ul>
									<li><a href="documentos.php" style="font-size:11px;" target="ppal">
										<strong>Administrar Documentos</strong></a></li>
									<li><a href="tabladocumentos.php" style="font-size:11px;" target="_blank">
										<strong>Listar Documentos</strong></a></li>
								</ul>
							</li>
						<?
						}
					}
				?>
			</ul>
		</li><?
		}
}

for($i=0;$i<$num;$i++){
	$opcion=mysqli_result($link,$exe,$i,"id_mod");
	if($opcion=="PROVEEDORES"){//PROVEEDORES?>
		<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Proveedores<br />&nbsp;</a>
			<ul>
			<li><a href="mail_proveedores.php" style="font-size:11px;" target="ppal"><strong>Enviar email</strong></a></li>
			<li><a href="javascript:void(0);" target="ppal">Operativos</a>
			<ul>
	
	
	
	
				<li><a href="javascript:void(0);" target="ppal">Agentes&nbsp;</a>
				<ul>
				<li><a href="proveedores_agentes.php?tipo=agente" style="font-size:11px;" target="ppal"><strong>Admin. Agentes y cont&aacute;ctos</strong></a></li>
				<li><a href="tablapro.php?tipo=agente" style="font-size:11px;" target="_blank"><strong>Listar Agentes</strong></a></li>
				<li><a href="tablapro.php?tipo=agente" style="font-size:11px;" target="_blank"><strong>Listar Contactos</strong></a></li>
				<li><a href="javascript:winbackex('scripts/export.php?table=proveedores_agentes&tipo=agente')" style="font-size:11px;"><strong>Exportar listado de Agentes</strong></a></li>

				</ul>
				</li>
	
	
	
	
				<li><a href="javascript:void(0);" target="ppal">Aerolineas</a>
				<ul>
				<li><a href="proveedores_agentes.php?tipo=aerolinea" style="font-size:11px;" target="ppal"><strong>Admin. aerolineas y cont&aacute;ctos</strong></a></li>
				<li><a href="tablapro.php?tipo=aerolinea" style="font-size:11px;" target="_blank"><strong>Listar aerolineas</strong></a></li>
				<li><a href="tablapro.php?tipo=aerolinea" style="font-size:11px;" target="_blank"><strong>Listar Contactos aerolineas Proveedores Administrativos</strong></a></li>
				<li><a href="javascript:winbackex('scripts/export.php?table=proveedores_agentes&tipo=aerolinea')" style="font-size:11px;"><strong>Exportar listado de aerolineas</strong></a></li>
				</ul>
				</li>


				<li><a href="javascript:void(0);"target="ppal">Navieras</a>
				<ul>
				<li><a href="javascript:void(0);" target="ppal">Acceso Navieras</a>
					<ul>
						<? //Consulta las navieras que tengan pagina web, para enlistarlas en el menu
						$sqlNavWeb = "SELECT * FROM `proveedores_agentes` WHERE tipo = 'naviera' and `pagina_web` != '' ";
						$qryNav = mysqli_query($link,$sqlNavWeb);
						while( $navWeb = mysqli_fetch_array($qryNav)){ ?>
							<li><a href="<? echo $navWeb["pagina_web"];?>" style="font-size:11px;" target="ppal"><strong><? echo $navWeb["nombre"];?></strong></a></li>
						<? 
						}?>
						<li><a href="proveedores_agentes.php?tipo=aerolinea" style="font-size:11px;" target="ppal"><strong>Admin. aerolineas y cont&aacute;ctos</strong></a></li>	
					</ul>
				</li>
				<li><a href="proveedores_agentes.php?tipo=naviera" style="font-size:11px;" target="ppal"><strong>Admin. Navieras y cont&aacute;ctos</strong></a></li>
				<li><a href="tablapro.php?tipo=naviera" style="font-size:11px;" target="_blank"><strong>Listar Navieras</strong></a></li>
				<li><a href="tablapro.php?tipo=naviera" style="font-size:11px;" target="_blank"><strong>Listar Contactos Navieras Proveedores Administrativos</strong></a></li>
				<li><a href="javascript:winbackex('scripts/export.php?table=proveedores_agentes&tipo=naviera')" style="font-size:11px;"><strong>Exportar listado de Navieras</strong></a></li>
				</ul>
				</li>

			<li><a href="javascript:void(0);"  target="ppal">Coloader</a>
				<ul>
				<li><a href="proveedores_agentes.php?tipo=coloader" style="font-size:11px;" target="ppal"><strong>Admin. Coloader y cont&aacute;ctos</strong></a></li>
				<li><a href="tablapro.php?tipo=coloader" style="font-size:11px;" target="_blank"><strong>Listar Coloader de aduana</strong></a></li>
				<li><a href="tablapro.php?tipo=coloader" style="font-size:11px;" target="_blank"><strong>Listar Contactos Coloader</strong></a></li>
				<li><a href="javascript:winbackex('scripts/export.php?table=proveedores_agentes&tipo=coloader')" style="font-size:11px;"><strong>Exportar listado de Coloader</strong></a></li>
				</ul>
				</li>
			<li><a href="javascript:void(0);" target="ppal">OTM y terrestre</a>
				<ul>
				<li><a href="proveedores_agentes.php?tipo=otm" style="font-size:11px;" target="ppal"><strong>Admin. OTM y cont&aacute;ctos</strong></a></li>
				<li><a href="tablapro.php?tipo=otm" style="font-size:11px;" target="_blank"><strong>Listar OTM</strong></a></li>
				<li><a href="tablapro.php?tipo=otm" style="font-size:11px;" target="_blank"><strong>Listar Contactos OTM</strong></a></li>
				<li><a href="javascript:winbackex('scripts/export.php?table=proveedores_agentes&tipo=otm')" style="font-size:11px;"><strong>Exportar listado de OTM</strong></a></li>
				</ul>
			</li>
			<li><a href="javascript:void(0);"  target="ppal">Bodegas</a>
				<ul>
				<li><a href="proveedores_agentes.php?tipo=bodega" style="font-size:11px;" target="ppal"><strong>Admin. Bodegas y  cont&aacute;ctos</strong></a></li>
				<li><a href="tablapro.php?tipo=bodega" style="font-size:11px;" target="_blank"><strong>Listar Bodegas</strong></a></li>
				<li><a href="tablapro.php?tipo=bodega" style="font-size:11px;" target="_blank"><strong>Listar Contactos Bodegas</strong></a></li>
				<li><a href="javascript:winbackex('scripts/export.php?table=proveedores_agentes&tipo=bodega')" style="font-size:11px;"><strong>Exportar listado de Bodegas</strong></a></li>
				</ul>
			</li>
			<li><a href="javascript:void(0);"  target="ppal">Seguros</a>
				<ul>
				<li><a href="proveedores_agentes.php?tipo=seguro" style="font-size:11px;" target="ppal"><strong>Admin. Seguros y  cont&aacute;ctos</strong></a></li>
				<li><a href="tablapro.php?tipo=seguro" style="font-size:11px;" target="_blank"><strong>Listar Seguros</strong></a></li>
				<li><a href="tablapro.php?tipo=seguro" style="font-size:11px;" target="_blank"><strong>Listar Contactos Seguros</strong></a></li>
				<li><a href="javascript:winbackex('scripts/export.php?table=proveedores_agentes&tipo=seguro')" style="font-size:11px;"><strong>Exportar listado de Seguros</strong></a></li>
				</ul>
			</li>
			<li><a href="javascript:void(0);"  target="ppal">Agentes de aduana</a>
				<ul>
				<li><a href="proveedores_agentes.php?tipo=aduana" style="font-size:11px;" target="ppal"><strong>Admin. Agentes de aduana y  cont&aacute;ctos</strong></a></li>
				<li><a href="tablapro.php?tipo=aduana" style="font-size:11px;" target="_blank"><strong>Listar Agentes de aduana</strong></a></li>
				<li><a href="tablapro.php?tipo=aduana" style="font-size:11px;" target="_blank"><strong>Listar Contactos Agentes de aduana</strong></a></li>
				<li><a href="javascript:winbackex('scripts/export.php?table=proveedores_agentes&tipo=agente')" style="font-size:11px;"><strong>Exportar listado de Agentes de aduana</strong></a></li>
				</ul>
			</li>
			</ul>  
			</li> 
		<li><a href="javascript:void(0);"  target="ppal">Administrativos</a>
			<ul>
			<li><a href="proveedores_agentes.php?tipo=administrativo" style="font-size:11px;" target="ppal"><strong>Admin. Proveedores Administrativos y  cont&aacute;ctos</strong></a></li>  
			<li><a href="tablapro.php?tipo=proveedor" style="font-size:11px;" target="_blank"><strong>Listar Proveedores Administrativos</strong></a></li>
			<li><a href="tablapro.php?tipo=administrativo" style="font-size:11px;" target="_blank"><strong>Listar Contactos Proveedores Administrativos</strong></a></li>
			<li><a href="javascript:winbackex('scripts/export.php?table=proveedores_agentes&tipo=administrativo')" style="font-size:11px;"><strong>Exportar listado de Proveedores Administrativos</strong></a></li>            
			</ul>
		</li>
		<li><a href="javascript:void(0);"  target="ppal">Financieros</a>
			<ul>
			<li><a href="proveedores_agentes.php?tipo=financiero" style="font-size:11px;" target="ppal"><strong>Admin. Proveedores Financieros y  cont&aacute;ctos</strong></a></li>  
			<li><a href="tablapro.php?tipo=financiero" style="font-size:11px;" target="_blank"><strong>Listar Proveedores Financieros</strong></a></li>
			<li><a href="tablapro.php?tipo=financiero" style="font-size:11px;" target="_blank"><strong>Listar Contactos Proveedores Financieros</strong></a></li>
			
			</ul>
		</li>
			</ul>
		</li><?
	}
}

for($i=0;$i<$num;$i++){
	$opcion=mysqli_result($link,$exe,$i,"id_mod");
	if($opcion=="AEROPUERTOS_PUERTOS"){//AEROPUERTOS/PUERTOS ?>
		<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Aeropuertos / Puertos</a>
			<ul>
			
			<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Aeropuertos</a>
			<ul>
				<li><a href="aeropuertos_puertos.php?tipo=aeropuerto" style="font-size:11px;" target="ppal"><strong>Administrar Aeropuertos</strong></a></li>
				<li><a href="tablapuertos.php?tipo=aeropuerto" style="font-size:11px;" target="_blank"><strong>Listar Aeropuertos</strong></a></li>
			</ul>
			</li>
			
			
						<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Puertos</a>
							<ul>
								<li><a href="aeropuertos_puertos.php?tipo=puerto" style="font-size:11px;" target="ppal"><strong>Administrar Puertos</strong></a></li>
								<li><a href="tablapuertos.php?tipo=puerto" style="font-size:11px;" target="_blank"><strong>Listar Puertos</strong></a></li>
							</ul>
						</li>
					
			</ul>
		</li>
	<?
	}
}

?>
<?
for($i=0;$i<$num;$i++)
{
$opcion=mysqli_result($link,$exe,$i,"id_mod");
if($opcion=="PAISES_CIUDADES")//PAISES_CIUDADES
{
?>
	<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Paises<br>/ciudades&nbsp;</a>
		<ul>
			<li><a href="paises.php" style="font-size:11px;" target="ppal"><strong>Administrar Paises/ciudades</strong></a></li>
		</ul>
	</li>
<?
}
}
?>

<?
for($i=0;$i<$num;$i++)
{
$opcion=mysqli_result($link,$exe,$i,"id_mod");
if($opcion=="PARAMETROS_COMERCIAL")//PARAMETROS_COMERCIAL
{
?>
	<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Parametrizar cotizaciones</a>
		<ul>
        	<li><a href="parametros_cotizacion.php?pr=general" style="font-size:11px;" target="ppal"><strong>General</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=flete&cl=fcl" style="font-size:11px;" target="ppal"><strong>Flete FCL</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=flete&cl=lcl" style="font-size:11px;" target="ppal"><strong>Flete LCL</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=flete&cl=aereo" style="font-size:11px;" target="ppal"><strong>Flete Aereo</strong></a></li           
         	><li><a href="parametros_cotizacion.php?pr=otm&cl=fcl" style="font-size:11px;" target="ppal"><strong>OTM FCL</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=otm&cl=lcl" style="font-size:11px;" target="ppal"><strong>OTM LCL</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=terrestre&cl=fcl" style="font-size:11px;" target="ppal"><strong>Carga nacionalizada FCL</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=terrestre&cl=lcl" style="font-size:11px;" target="ppal"><strong>Carga nacionalizada LCL</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=terrestre&cl=aereo" style="font-size:11px;" target="ppal"><strong>Carga nacionalizada Aereo</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=seguro&cl=fcl" style="font-size:11px;" target="ppal"><strong>Seguro FCL</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=seguro&cl=lcl" style="font-size:11px;" target="ppal"><strong>Seguro LCL</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=seguro&cl=aereo" style="font-size:11px;" target="ppal"><strong>Seguro Aereo</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=aduana&cl=fcl" style="font-size:11px;" target="ppal"><strong>Aduana FCL</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=aduana&cl=lcl" style="font-size:11px;" target="ppal"><strong>Aduana LCL</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=aduana&cl=aereo" style="font-size:11px;" target="ppal"><strong>Aduana Aereo</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=bodega&cl=fcl" style="font-size:11px;" target="ppal"><strong>Bodega FCL</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=bodega&cl=lcl" style="font-size:11px;" target="ppal"><strong>Bodega LCL</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=bodega&cl=aereo" style="font-size:11px;" target="ppal"><strong>Bodega Aereo</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=collection" style="font-size:11px;" target="ppal"><strong>Collection Fee</strong></a></li>
            <li><a href="parametros_cotizacion.php?pr=caf" style="font-size:11px;" target="ppal"><strong>CAF</strong></a></li>
            <?
			for($i=0;$i<$num;$i++)
			{
			$opcion=mysqli_result($link,$exe,$i,"id_mod");
			if($opcion=="FRECUENCIAS")//FRECUENCIAS
			{
			?>
				<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Frecuencias&nbsp;</a>
					<ul>
						<li><a href="frecuencias.php" style="font-size:11px;" target="ppal"><strong>Administrar Frecuencias</strong></a></li>
						<li><a href="tablafrecuencias.php" style="font-size:11px;" target="_blank"><strong>Listar Frecuencias</strong></a></li>
					</ul>
				</li>
			<?
			}
			}
			?>
            <?
			for($i=0;$i<$num;$i++)
			{
			$opcion=mysqli_result($link,$exe,$i,"id_mod");
			if($opcion=="MONEDAS")//FRECUENCIAS
			{
			?>
				<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Monedas&nbsp;</a>
					<ul>
						<li><a href="monedas.php" style="font-size:11px;" target="ppal"><strong>Administrar Monedas</strong></a></li>
						<li><a href="tablamonedas.php" style="font-size:11px;" target="_blank"><strong>Listar Monedas</strong></a></li>
					</ul>
				</li>
			<?
			}
			}
			?>
    	</ul>
	</li>
<?
}
}
?>
<?
for($i=0;$i<$num;$i++) {
$opcion=mysqli_result($link,$exe,$i,"id_mod");
if($opcion=="TARIFARIO"){//TARIFARIO ?>
	<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Tarifarios <br>FCL</a>
	
		<ul>
            <li><a href="tarifario.php" style="font-size:11px;" target="ppal"><strong>Tarifario FCL</strong></a></li>
            <li><a href="recargos_origen.php" style="font-size:11px;" target="ppal"><strong>Admin Recargos Origen FCL</strong></a></li>
            <li><a href="recargos_local.php?cl=fcl" style="font-size:11px;" target="ppal"><strong>Admin Recargos Locales FCL</strong></a></li>
            <li><a href="tarifas_vencidas.php?cl=fcl" style="font-size:11px;" target="ppal"><strong>Enviar tarifas vencidas FCL</strong></a></li>
    	</ul>
	</li>
<?
}
}
?>
<?
for($i=0;$i<$num;$i++)
{
$opcion=mysqli_result($link,$exe,$i,"id_mod");
if($opcion=="TARIFARIO")//TARIFARIO
{
?>
	<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Tarifarios <br>LCL</a>
	
		<ul>	
            <li><a href="tarifario_lcl.php" style="font-size:11px;" target="ppal"><strong>Tarifario LCL</strong></a></li>
            <li><a href="recargos_origen_lcl.php" style="font-size:11px;" target="ppal"><strong>Admin Recargos Origen LCL</strong></a></li>
			<li><a href="recargos_local.php?cl=lcl" style="font-size:11px;" target="ppal"><strong>Admin Recargos Locales LCL</strong></a></li>
            <li><a href="tarifas_vencidas.php?cl=lcl" style="font-size:11px;" target="ppal"><strong>Enviar tarifas vencidas LCL</strong></a></li>
    	</ul>
	</li>
<?
}
}
?>
<?
for($i=0;$i<$num;$i++)
{
$opcion=mysqli_result($link,$exe,$i,"id_mod");
if($opcion=="TARIFARIO")//TARIFARIO
{
?>
	<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Tarifarios Aereo</a>
		<ul>	
            <li><a href="tarifario_aereo.php" style="font-size:11px;" target="ppal"><strong>Tarifario Aereo</strong></a></li>
            <li><a href="recargos_origen_aereo.php" style="font-size:11px;" target="ppal"><strong>Admin Recargos Origen Aereo</strong></a></li>
			<li><a href="recargos_local.php?cl=aereo" style="font-size:11px;" target="ppal"><strong>Admin Recargos Locales Aereo</strong></a></li>
            <li><a href="tarifas_vencidas.php?cl=aereo" style="font-size:11px;" target="ppal"><strong>Enviar tarifas vencidas Aereo</strong></a></li>
    	</ul>
	</li>
<?
}
}
?>

<?
for($i=0;$i<$num;$i++)
{
$opcion=mysqli_result($link,$exe,$i,"id_mod");
if($opcion=="TARIFARIO")//TARIFARIO
{
?>
	<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Tarifarios Conexos</a>
		<ul>
        	<li><a href="otm.php?cl=fcl" style="font-size:11px;" target="ppal"><strong>Tarifario OTM FCL</strong></a></li>
            <li><a href="otm.php?cl=lcl" style="font-size:11px;" target="ppal"><strong>Tarifario OTM LCL</strong></a></li>
            <li><a href="terrestre.php?cl=fcl" style="font-size:11px;" target="ppal"><strong>Carga nacionalizada FCL</strong></a></li>
            <li><a href="terrestre.php?cl=lcl" style="font-size:11px;" target="ppal"><strong>Carga nacionalizada LCL</strong></a></li>
            <li><a href="terrestre.php?cl=aereo" style="font-size:11px;" target="ppal"><strong>Carga nacionalizada Aereo</strong></a></li>
            <li><a href="dta.php?cl=fcl" style="font-size:11px;" target="ppal"><strong>DTA - FCL</strong></a></li>
            <li><a href="dta.php?cl=lcl" style="font-size:11px;" target="ppal"><strong>DTA - LCL</strong></a></li>
			<li><a href="dta.php?cl=aereo" style="font-size:11px;" target="ppal"><strong>DTA - Aereo</strong></a></li>
			
			
            <li><a href="recargos_local_otm.php?cl=lcl" style="font-size:11px;" target="ppal"><strong>Recargos locales OTM LCL</strong></a></li>
            <li><a href="seguro.php" style="font-size:11px;" target="ppal"><strong>Tarifario Seguro</strong></a></li>
            <li><a href="aduana.php" style="font-size:11px;" target="ppal"><strong>Tarifario Aduana</strong></a></li> 
            <li><a href="bodega.php?cl=fcl" style="font-size:11px;" target="ppal"><strong>Tarifario Bodega FCL</strong></a></li>
            <li><a href="bodega.php?cl=lcl" style="font-size:11px;" target="ppal"><strong>Tarifario Bodega LCL</strong></a></li>
            <li><a href="bodega.php?cl=aereo" style="font-size:11px;" target="ppal"><strong>Tarifario Bodega Aereo</strong></a></li> 
    	</ul>
	</li>
<?
}
}
?>
<?
for($i=0;$i<$num;$i++)
{
$opcion=mysqli_result($link,$exe,$i,"id_mod");
if($opcion=="COTIZACION")//COTIZACION
{
?>
	<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Cotizaciones<br />&nbsp;</a>
		<ul>
        	<li><a href="consultar_cotizaciones.php" style="font-size:11px;" target="ppal"><strong>Consultar cotizaciones</strong></a></li>
		<? if(puedo("c","REPORTE_COTIZACION")) { ?>
           	<li><a href="generar_reportes.php" style="font-size:11px;" target="ppal"><strong>Generar reportes</strong></a></li>
		<? }?>
		<? if(puedo("c","COTIZACION")) { ?>
			<li><a href="paso1_selcliente.php?cl=aereo" style="font-size:11px;" target="ppal"><strong>Asistente de cotizaciones aereas</strong></a></li>        	
			<li><a href="paso1_selcliente.php?cl=fcl" style="font-size:11px;" target="ppal"><strong>Asistente de cotizaciones FCL</strong></a></li>
			<li><a href="paso1_selcliente.php?cl=lcl" style="font-size:11px;" target="ppal"><strong>Asistente de cotizaciones LCL</strong></a></li>
		<? } ?>         
    	</ul>
	</li>
<?
}
}
?>
<?
for($i=0;$i<$num;$i++)
{
	$opcion=mysqli_result($link,$exe,$i,"id_mod");
	if($opcion=="REPORTES_NEGOCIO")//REPORTES_NEGOCIO
	{
	?>
		<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Reporte de negocio</a>
			<ul>
				<li><a href="sel_cotizaciones.php" style="font-size:11px;" target="ppal"><strong>Crear reporte de negocio</strong></a></li>
			</ul>
		</li>
	<?
	}
}

for($i=0;$i<$num;$i++){
	$opcion=mysqli_result($link,$exe,$i,"id_mod");
	
	if($opcion=="ZONA_CLIENTES")//ZONA_CLIENTES
	{
	?>
		<li><a href="javascript:void(0);" class="MenuBarItemSubmenu" target="ppal">Zona <br> clientes</a>
			<ul>
				<li><a href="resumen_clientes_comercial.php" style="font-size:11px;" target="ppal"><strong>Reporte estados</strong></a></li>
				<?

				if(puedo("l","REPORTES_ESTADO") == 1){
				?>
					<li><a href="resumen_clientes_comercial.php?opc=estadisticas" style="font-size:11px;" target="ppal"><strong>Informe - Reporte estados</strong></a></li>
					<?
					if($_SESSION["perfil"] != "2"){?>
						<li><a href="cuadro_do.php" style="font-size:11px;" target="ppal"><strong>Cuadro DO</strong></a></li>
					<?
					}
					?>
					<li><a href="contenedores.php" style="font-size:11px;" target="ppal"><strong>Contenedores</strong></a></li>
				    <li><a href="indicadores_gestion.php" style="font-size:11px;" target="ppal"><strong>Indicadores de Gesti&oacute;n</strong></a></li>
			    <? }?>
			</ul>
		</li>
	<?
	}
}
//Permisos de puerto
if( puedo("l","PUERTO") == "1" ){?>
	<li><a href="puertos.php" class="" target="ppal">Puertos<br />&nbsp;</a>
<?
 }
 
 //Consulta las alertas

?>

<li><a href="showAlertas.php" target="ppal">Alertas(<?= getNumAlertas($_SESSION["perfil"],$_SESSION["numberid"]);?>)<br>&nbsp;</a>

<script type="text/javascript">
<!--

swfobject.registerObject("FlashID");
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>

</ul><script type="text/javascript">
<!--
swfobject.registerObject("FlashID");
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>