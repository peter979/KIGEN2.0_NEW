<?php
include("conexion.php");
include("funciones.php");
$op=new operaciones();



if(isset($_FILES["adjunto"]["name"])){
   $adjunto=Array();
   $adjunto=$_FILES["adjunto"]["name"];

   foreach($adjunto as $adj) 
        { 
         $tabla="archivos";
         $campos="adjunto,fecha,ruta";
         $ruta="files/";
         $fecha=date("y-m-d");
         $valores="'".$adj."','".$fecha."','".$ruta."'";
         $op->insertar($tabla,$campos,$valores);
        }    

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
 
    $campo='adjunto';
    $upload = new Multiupload();
    $upload->upFiles($adjunto,$campo);
   
  
}
  else{
    throw new Exception("Error Processing Request", 1);
}
    }




?>



<!DOCTYPE html>
<html>
<style>
  
.container{

  margin-top:200px;
}

.container {

  background-color:#FF6600;
}

.container a {
   color:#FFF;
}



</style>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script>

    $(document).ready(function() { 
      $("#adjunta").click(function() {
    $("#adjunto").append("<input type='file' name='adjunto[]'>");
   });
});

  </script>
</head>
<body>

<div class="container" style="border-width:0.1em; border-style:solid;">
 <span class="label label-primary">Documentos GATEWAY</span>
   
  <form class="form-horizontal"  method="post" action="legal.php" accept-charset="utf-8" enctype="multipart/form-data">
   <fieldset>
   <!-- Form Name -->
   <legend><h2 style="color:#FFF;">Compras</h2></legend>

<!-- Text input-->


<!-- File Button --> 
<div class="form-group">
  <div class="col-md-4" id="adjunto">
  <a href="#" id="adjunta">Adjuntar</a>
  </div>
</div>

<!-- Button -->
  <div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
   
  </div>
</div>
 <center><input type="submit" class="btn btn-default" id="boton" value="Guardar"></center>
</fieldset>
 </form>
   </div>
</body> 
</html>