<?
include("conection/conectar.php");
include_once("scripts/recover_nombre.php");
?>
<style type="text/css">
#capa_rem
{
	position:absolute;
	left:3px;
	top:1px;
	width:300px;
	height:120px;
	clip:rect(0px 300px 80px 0px);
	visibility:hidden;
	overflow:hidden;
}
#capa_nota
{
	position:absolute;
}
</style>
<script language="JavaScript" type="text/javascript">
function lib_bwcheck()
{ //Browsercheck (needed)
	this.ver=navigator.appVersion
	this.agent=navigator.userAgent
	this.dom=document.getElementById?1:0
	this.opera5=this.agent.indexOf("Opera 5")>-1
	this.ie5=(this.ver.indexOf("MSIE 5")>-1 && this.dom && !this.opera5)?1:0; 
	this.ie6=(this.ver.indexOf("MSIE 6")>-1 && this.dom && !this.opera5)?1:0;
	this.ie7=(this.ver.indexOf("MSIE 7")>-1 && this.dom && !this.opera5)?1:0;
	this.ie4=(document.all && !this.dom && !this.opera5)?1:0;
	this.ie=this.ie4||this.ie5||this.ie6||this.ie7
	this.mac=this.agent.indexOf("Mac")>-1
	this.ns6=(this.dom && parseInt(this.ver) >= 5) ?1:0; 
	this.ns4=(document.layers && !this.dom)?1:0;
	this.bw=(this.ie6 || this.ie5 || this.ie7|| this.ie4 || this.ns4 || this.ns6 || this.opera5)
	return this
}
var bw=new lib_bwcheck()

/***************************************************************************
Use the style tag to change the placement and width of the layers.
If you are trying to place this into a table cell or something make the
position of the capa_rem layer relative...Remeber that that might crash
Netscape 4 though, Good luck!
********************************************************************************/

/****
Variables to set 
****/

//How do you want the script to work? 
//0 = Fade in - Fade out
//1 = Slide in - Fade out
//2 = Random 
nWorks = 1

//If you use the slide set these variables:
nSlidespeed = 10 //in px
nNewsheight = 100 //This is how long down it should start the slide.

nBetweendelay = 6000 //tiempo que dura la nota
nFont = 'arial,helvetica' //The font for the news.
nFontsize = 12 //Font size in pixel.
nFadespeed = 100 //The speed to fade in, in milliseconds.

//Set the colors, first color is same as background, last color is the color it stops at:
//You can have as many colors you want
nColor=new Array('#0000FF', '#FF0000')

//This is the news you wanna have, set the link and the text. If you don't wan't it to link anywhere
//use a # as the link
nNews=new Array()
//Copy there three lines and change the info and numbers to get more news.<br>

<?
if($_GET['al']=='cumple')
{
	$k = 0;	
	$sql = "select * from contactos_todos WHERE cumpleanos between DATE_SUB(NOW(), INTERVAL 1 DAY) and  DATE_ADD(NOW(), INTERVAL 5 DAY) order by cumpleanos desc";
	$exe = mysqli_query($link,$sql);
	$filas = mysqli_num_rows($exe);
	if($filas > 0)
	{
		$destino = '';
		$contacto = '';
		while($datos = mysqli_fetch_array($exe))
		{
			if($contacto != '')
				$contacto .= ',';
			$contacto = $datos['idcontacto_todos'];
			
			$sql = "select * from cumpleanos where idcontacto='$datos[idcontacto_todos]' and year(fecha)=".date('Y');
			$exe = mysqli_query($link,$sql);
			$filas2 = mysqli_num_rows($exe);
			
			if($filas2 == 0)
			{
				if($destino != '')
					$destino .= ',';
				$destino = $datos['correo'];
			}
			
			?>
			nNews[<? print $k;?>]=new Array()
			<?
			$cumpleanos = $datos['cumpleanos'];
			if($datos['cumpleanos']==date('Y-m-d'))	
				$cumpleanos = 'Hoy';
				
			$frase = 'Cumplea&ntilde;os de '.$datos['nombre'].' '.$cumpleanos;
			?>
			nNews[<? print $k;?>]["text"]="<? print $frase; ?>"
			nNews[<? print $k;?>]["link"]=""			
			<?
			$k+=1;
		}
	}
}

if($_GET['al']=='vence')
{
	$k = 0;	
	$sql = "select * from tarifario WHERE fecha_vigencia between DATE_SUB(NOW(), INTERVAL 1 DAY) and  DATE_ADD(NOW(), INTERVAL 5 DAY) order by fecha_vigencia desc";
	$exe = mysqli_query($link,$sql);
	$filas = mysqli_num_rows($exe);
	if($filas > 0)
	{
		while($datos = mysqli_fetch_array($exe))
		{
			?>
			nNews[<? print $k;?>]=new Array()
			<?
			$fecha_vigencia = $datos['fecha_vigencia'];
			if($datos['fecha_vigencia']==date('Y-m-d'))	
				$fecha_vigencia = 'Hoy';
			
			$naviera = scai_get_name("$datos[idnaviera]", "proveedores_agentes", "idproveedor_agente", "nombre");
            $agente = scai_get_name("$datos[idagente]", "proveedores_agentes", "idproveedor_agente", "nombre");			
			$puerto_origen = scai_get_name("$datos[puerto_origen]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");    
            $puerto_destino = scai_get_name("$datos[puerto_destino]", "aeropuertos_puertos", "idaeropuerto_puerto", "nombre");				
			
			$frase = 'Fecha vigencia de '.$datos['num_contrato'].', '.$naviera.', '.$agente.', '.$puerto_origen.', '.$puerto_destino.' vence '.$fecha_vigencia;
			?>
			nNews[<? print $k;?>]["text"]="<? print $frase; ?>"
			nNews[<? print $k;?>]["link"]=""			
			<?
			$k+=1;
		}
	}
}

if($_GET['al']=='doc')
{
	$k = 0;	
	$sql = "select * from clientes_has_documentos WHERE fecha_vencimiento between DATE_SUB(NOW(), INTERVAL 1 DAY) and  DATE_ADD(NOW(), INTERVAL 5 DAY) order by idcliente desc";
	$exe = mysqli_query($link,$sql);
	$filas = mysqli_num_rows($exe);
	if($filas > 0)
	{
		while($datos = mysqli_fetch_array($exe))
		{
			?>
			nNews[<? print $k;?>]=new Array()
			<?
			$fecha_vencimiento = $datos['fecha_vencimiento'];
			if($datos['fecha_vencimiento']==date('Y-m-d'))	
				$fecha_vencimiento = 'Hoy';
			
			$documento = scai_get_name("$datos[iddocumento]", "documentos", "iddocumento", "nombre");
            $nombre = scai_get_name("$datos[idcliente]", "clientes", "idcliente", "nombre");
			$apellido = scai_get_name("$datos[idcliente]", "clientes", "idcliente", "nombre");

			$frase = 'Fecha de vencimiento de '.$documento.' de '.$nombre.' '.$apellido.' es '.$fecha_vencimiento;
			?>
			nNews[<? print $k;?>]["text"]="<? print $frase; ?>"
			nNews[<? print $k;?>]["link"]=""			
			<?
			$k+=1;
		}
	}
}
?>
		
/*nNews[0]=new Array()

nNews[0]["text"]="Prueba alerta 1"
nNews[0]["link"]=""
nNews[1]=new Array()
nNews[1]["text"]="Prueba alerta 2"
nNews[1]["link"]=""
nNews[2]=new Array()
nNews[2]["text"]="Prueba alerta 3"
nNews[2]["link"]=""*/
	





/********************************************************************************
Object code...Object constructors and functions...
********************************************************************************/
function makeNewsObj(obj,nest,font,size,color,news,fadespeed,betweendelay,slidespeed,works,newsheight){
    nest=(!nest) ? "":'document.'+nest+'.'
   	this.css=bw.dom? document.getElementById(obj).style:bw.ie4?document.all[obj].style:bw.ns4?eval(nest+"document.layers." +obj):0;	
   	this.writeref=bw.dom? document.getElementById(obj):bw.ie4?document.all[obj]:bw.ns4?eval(nest+"document.layers." +obj+".document"):0;
	if(font){this.color=new Array(); this.color=eval(color); this.news=new Array(); this.news=eval(news)
		this.font=font; this.size=size; this.speed=fadespeed; this.delay=betweendelay; this.newsheight=newsheight;
		this.fadeIn=b_fadeIn;this.fadeOut=b_fadeOut; this.newsWrite=b_newsWrite; this.y=1
		this.slideIn=b_slideIn; this.moveIt=b_moveIt; this.slideSpeed=slidespeed; this.works=works
		if(bw.dom || bw.ie4){this.css.fontFamily=this.font; this.css.fontSize=this.size; this.css.color=this.color[0]}
	}
	this.obj = obj + "Object"; 	eval(this.obj + "=this"); return this
}

// A unit of measure that will be added when setting the position of a layer.
var px = bw.ns4||window.opera?"":"px";

function b_moveIt(x,y){this.x=x; this.y=y; this.css.left=this.x+px; this.css.top=this.y+px;}

function b_newsWrite(num,i){
	if (bw.ns4){
		this.writeref.write("<a href=\""+this.news[num]['link']+"\" target=\"myTarget\" style=\"text-decoration:none; font-size:"+this.size+"px\">"
			+"<font face=\""+this.font+"\" color=\""+this.color[i]+"\">"+this.news[num]['text']+"</font></a>")
		this.writeref.close()
	}else this.writeref.innerHTML = '<a id="'+this.obj+'link' +'" target="myTarget"  style="text-decoration:none; font-size:'+this.size+'px; color:'+this.color[i]+'" href="'+this.news[num]['link']+'">'+this.news[num]['text']+'</a>'
}
//Slide in
function b_slideIn(num,i){
	if (this.y>0){
		if (i==0){this.moveIt(0,this.newsheight); this.newsWrite(num,this.color.length-1)}
		this.moveIt(this.x,this.y-this.slideSpeed)
		i ++
		setTimeout(this.obj+".slideIn("+num+","+i+");",50)
	}else setTimeout(this.obj+".fadeOut("+num+","+(this.color.length-1)+")",this.delay)
}
//The fade functions
function b_fadeIn(num,i){
	if (i<this.color.length){
		if (i==0 || bw.ns4) this.newsWrite(num,i)
		else{
			obj = bw.ie4?eval(this.obj+"link"):document.getElementById(this.obj+"link")
			obj.style.color = this.color[i]
		}
		i ++
		setTimeout(this.obj+".fadeIn("+num+","+i+")",this.speed)
	}else setTimeout(this.obj+".fadeOut("+num+","+(this.color.length-1)+")",this.delay)
}

function b_fadeOut(num,i){
	if (i>=0){
		if (i==0 || bw.ns4) this.newsWrite(num,i)	
		else{
			obj = bw.ie4?eval(this.obj+"link"):document.getElementById(this.obj+"link")
			obj.style.color = this.color[i]
		}
		i --
		setTimeout(this.obj+".fadeOut("+num+","+i+")",this.speed)
	}else{
		num ++
		if(num==this.news.length) num=0
		works = !this.works?0:this.works==1?1:Math.round(Math.random())
		if(works==0) setTimeout(this.obj+".fadeIn("+num+",0)",500)
		else if (works==1){this.y=1; setTimeout(this.obj+".slideIn("+num+",0)",500)
		}
	}
}
/********************************************************************************************
The init function. Calls the object constructor and set some properties and starts the fade
*********************************************************************************************/
function fadeInit(){
	oNews = new makeNewsObj('capa_nota','capa_rem',nFont,nFontsize,"nColor","nNews",nFadespeed,nBetweendelay,nSlidespeed,nWorks,nNewsheight)
	oNewsCont = new makeNewsObj('capa_rem')
	works = !oNews.works?0:oNews.works==1?1:Math.round(Math.random())
	if (works==0) oNews.fadeIn(0,0)
	else if (works==1) oNews.slideIn(0,0)
	oNewsCont.css.visibility = "visible"
}

//Calls the init function on pageload. 
if(bw.bw) onload = fadeInit
</script></head><body marginleft="0" marginheight="0">
<!-- START DELETE -->
<div style="position: absolute; left: 0pt; top: 0pt;"></div>
<br><br><br>
<!-- END DELETE -->
<div style="visibility: visible;" id="capa_rem">
	<div style="font-family: arial,helvetica; font-size: 12px; color: rgb(255, 255, 255); left: 0px; top: 40px;" id="capa_nota">
	<a id="capa_notaObjectlink" target="myTarget" style="text-decoration: none; font-size: 12px; color: rgb(51, 51, 51);" href=""></a>
	</div>
</div>
</body></html>