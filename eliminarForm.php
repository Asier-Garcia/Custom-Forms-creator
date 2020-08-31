<!DOCTYPE html>
<?php session_start();
    //Incluyo los datos de la conexion
    include("funciones.php");
    
    //Conecto con la BD
    $conexion = conexion();

?>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Creación de formularios</title>
		<script src="validar.js"></script>
		<link rel="stylesheet" href="pestañas.css"/>
		<style>
			.error {
				border: solid 2px #FF0000;
			}
		</style>
	</head>
<body>
<?php
	include "menu.php";
    if(isset($_REQUEST['nomForm'])){
?>
<div style="margin-left:130px">
  <div class="w3-padding">FORMULARIO</div>
<?php
		$nombre = $_REQUEST['nomForm'];

		$drop = "DROP TABLE ". $nombre .";";
		$sentencia = array($drop);
		if(ejecutaSQLarray($sentencia, $conexion)){
			echo "Ha ocurrido un error, no se pudo eliminar ese formulario";
		}else{
			//elimino también el fichero 
			unlink("formularios/" . $nombre .".html");
			echo "Formulario eliminado correctamente";
			echo " <meta http-equiv='refresh' content='0.5; index.php?des=eliminar1';'>";
		}

	}
?>
	</div>
	</body>
</html>