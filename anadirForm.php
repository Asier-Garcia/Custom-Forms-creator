<!DOCTYPE html>
<?php session_start();
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
		<!-- CSS only -->
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >

		<!-- JS, Popper.js, and jQuery -->
		<script src="bootstrap/js/jquery-3.5.1.slim.min.js"></script>
		<script src="bootstrap/js/popper.min.js" ></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<style>
			.error {
				border: solid 2px #FF0000;
			}
			.formSub{
				background-color: lightgray;
				padding: 2%;
				margin: 1%;
				border-radius: 5px;
			}
			label{
				font-weight: bold;
			}

			.intro{
				margin-left: 3%;
			}
		</style>
	</head>
<body>
<?php 
	include "menu.php"; 
	if(isset($_REQUEST['submit'])){
		
?>
<div style="margin-left:130px">
  <div class="w3-padding">FORMULARIO</div>
	<div class="w3-container city w3-animate-opacity">
		<form class="formSub">
			
			<fieldset><legend>Formulario</legend>
			<?php
				mostrar();
			?>
			</fieldset>
		
		</form><br/>
		<!-- Confirmación por parte del usuario para crear el formulario con un input para que introduzca el nommbre-->
		<form action="anadirForm.php" method="post" class="intro">
			<label >Introduce un nombre para el formulario <input class='form-control' type="text" required name="nombreForm"></label>
			<input  type="submit" name="submitFinal" value="Continuar" id="enviar"  onclick="return confirm('Are you sure you want to Save?')"/>
		</form>
<?php
	}
		if(isset($_REQUEST["submitFinal"])){
			
			$nombre = "formulario_" . $_REQUEST["nombreForm"];
			//Creamos la tabla formulario e introducimos los datos
			if(empty($_SESSION["nomTabla"])){

				$create = "CREATE TABLE " . $nombre . " (id int NOT NULL AUTO_INCREMENT, campo varchar(500), tipo varchar(50), obligatorio varchar(3), opciones varchar(1000), 
				PRIMARY KEY (id));";
		
				if(mysqli_query($conexion, $create)){
					echo "Formulario creado con éxito <br/>";
					$_SESSION["nomTabla"] =  $nombre;
					echo " <meta http-equiv='refresh' content='0.5; index.php?des=anadir';'>";
				}else{
					echo "El nombre introducido ya existe";
					die();
				}
			}
			
			for($i = 0; $i < count($_SESSION['campo']); $i++){
				$cad = "";
				for($j = 0; $j < count($_SESSION['opciones'][$i]); $j++){
					$cad .= $_SESSION["opciones"][$i][$j] . "-";
				}
				$cad = substr($cad, 0, -1);
				
				$insert = "INSERT INTO " . $_SESSION["nomTabla"] ." VALUES ('', '" . $_SESSION['campo'][$i] ."' , '" . $_SESSION["tipoI"][$i] . "', 
				'" . $_SESSION['obligatorio'][$i]. "','" . $cad ."');";
			    
				if(!mysqli_query($conexion, $insert)){
					echo "error al insertar";
				}
			}
			
			//creo el doc. para subirlo a la web

			anadirHTML($_SESSION["contenido"]);



			session_destroy();
	}
	?>
		</div></div>
</body></html>

