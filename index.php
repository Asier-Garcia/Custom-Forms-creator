
<!DOCTYPE html>
<html lang="en">
<?php session_start(); include("funciones.php"); error_reporting(E_ERROR | E_PARSE);?>
<head>
    <meta charset="UTF-8">
    <title>Creación de formularios</title>
    <script src="validar.js"></script>
	<link rel="stylesheet" href="pestañas.css"/>
	<link rel="stylesheet" href="estilos.css"/>
	<!-- JS, Popper.js, and jQuery -->
		<script src="bootstrap/js/jquery-3.5.1.slim.min.js"></script>
		<script src="bootstrap/js/popper.min.js" ></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!-- CSS only -->
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
</head>

<body>

	<div class="w3-sidebar w3-bar-block w3-black w3-card" style="width:130px">
		<h5 class="w3-bar-item">Opciones</h5>
		<button class="w3-bar-item w3-button tablink" onclick="openLink(event, 'principal')">Menú</button>
		<button class="w3-bar-item w3-button tablink" onclick="openLink(event, 'anadir')">Añadir</button>
		<button class="w3-bar-item w3-button tablink" onclick="openLink(event, 'eliminar1')">Eliminar</button>
		<button class="w3-bar-item w3-button tablink" onclick="openLink(event, 'editar')">Editar</button>
	</div>

<div style="margin-left:130px">
  <div class="w3-padding">FORMULARIO</div>
  		<div id="principal" class="w3-container city w3-animate-zoom" style="display:none">
			<h2>Menú principal</h2>
			<div id="enlaces" class="jumbotron d-flex align-items-center">
			<div class="container text-center">
			<?php
				$path  = 'formularios/';
				
				//$files = array_diff(scandir($path), array('.', '..'));
				$files = scandir($path);

				for($i = 2 ; $i < count($files); $i++){ //empiezo en 2 para omitir el . y los .. que devuelve scardir, no se porque array_diff no funciona

					echo "<a id='enlace" . $i."' target='_blank' class= 'enlaces' href='formularios/" . $files[$i]."' >" . $files[$i] . "</a>
						<button class='copyButton' onclick='copiarClipboard(event);'><i class='material-icons'>content_copy</i></button>
						<input class = 'ocult' id = 'ocult". $i ."' type='text' /><br>";
				}

			?>
			</div>	
			</div>
		</div>
		<div id="anadir" class="w3-container city w3-animate-opacity" style="display:none">
			<form method="post" action="anadirForm.php" id="formulario">

			<!--Campo de texto de una sola linea (tipo texto)-->
				<div id="container">
					<div id="template0">
						<fieldset>

							<div class="form-group">
								<label>
									<textarea  class="form-control" name="campo[]" rows="3" cols="50" required placeholder="Pregunta"></textarea>
								</label>
								
							</div>
							<div class="form-group">
								<div>
									<label for="tipoI" > Tipo del campo</label>

									<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"/>					
									<select class="form-control" name="tipoI[]" id="tipoI" onchange="cambioSelect(event);" >
											<option disabled>--- Múltiple ---</option>
											<option value="checkbox">Casillas </option>
											<option value="select" >Desplegable</option>
											<option value="radio">Varias opciones </option>

											<option disabled>--- Inputs ---</option>

											<option value="text">Respuesta corta </option>
											<option value="textarea">Párrafo</option>
											<option value="color">Color</option>
											<option value="pass">Contraseña</option>
											<option value="tel">Teléfono</option>
											<option value="email">E-mail</option>
											<option value="date">Fecha</option>
											<option value="datetime-local">datetime</option>
											<option value="range">Rango</option>
											<option value="file">Subir archivos</option>
											<option value="month">"Dia de Mes"</option>
											<option value="number">Un número</option>	
									</select>
								</div>
								
								<div id="containerMu">
									<button class="simb" onclick="anadirMu(event); return false;">+</button>
									<button class="simb" onclick="eliminarMu(event); return false;" >x</button>
										
									<div id="templateMu0">
										<label id="labelMu"><input type="text" name="opcionM[0][]"/></label>
									</div>
									
								</div>
							</div>

							<!--<div class="form-group">
								<label for="obli"> ¿Quieres que sea obligatorio?</label>
								<select name="obligatorio[]" id="obli" >
									<option value="si">Si</option>
									<option value="no">No</option>
								</select>
							</div>-->


							<!-- Default switch -->
							<div class="custom-control custom-switch">
								<input name="obligatorio[]" type="checkbox" class="custom-control-input" id="obli0" value="1">
								<input type="hidden" name="obligatorio[]" value="0" />
								<label class="custom-control-label" for="obli0"> ¿Quieres que sea obligatorio?</label>
							</div>

							<button id="anadir" onclick="anadirC(event); return false;" >Añadir</button>
							<button id="eliminar"onclick="eliminarC(event); return false;" >Eliminar</button>

							<input type="hidden" name="numMultiple" id="s1" value=""/>
							<!--onclick="eliminarC(event); return false;"-->
						</fieldset> 
					</div>
				</div>
			<button type="submit" name="submit" value="Continuar" id="enviar">Continuar</button>

			</form>
		</div>

		<div id="eliminar1" class="w3-container city w3-animate-zoom" style="display:none">
			<table id="tabEli">
				<thead>
                    
				</thead>
				<tbody>
			<?php
					
					$conexion = conexion();
					$res = mysqli_query($conexion, "SELECT table_name FROM information_schema.tables WHERE table_schema = 'formulariobase'");

					while ($registro = mysqli_fetch_row($res)){
				?>
						<tr>
							<td> <?php echo $registro[0] ?></td>
							<td><form  method="post" action="eliminarForm.php">
									<input type='hidden' name='nomForm' value="<?php echo $registro[0];?>"/>
									<input type="submit" name="submitFinal" value="Eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar ese formulario?')"/>
							</form></td>
						</tr>
			<?php	}	?>

				</tbody>
			</table>
		</div>

		<div id="editar" class="w3-container city w3-animate-zoom" style="display:none">
			<table>
				<thead>
                    <tr>
                        <th><h3>Nombre</h3></th>
                    </tr>
				</thead>
				<tbody>
			<?php
					
					$conexion = conexion();

					$res = mysqli_query($conexion, "SELECT table_name FROM information_schema.tables WHERE table_schema = 'formulariobase'");

					while ($registro = mysqli_fetch_row($res)){
			?>
						<tr>
							<td> <?php echo $registro[0]; ?></td>

							<td><form  method="post" action="editarForm.php">
									<input type='hidden' name='nomForm' value="<?php echo $registro[0];?>"/>
									<input type="submit" value="Editar"/>
							</form></td>
						</tr>
			<?php	}	?>

				</tbody>
				</table>
		</div>
</div>
</body>
</html>
<?php if(isset($_REQUEST["des"])){ ?>
	<script>
		document.getElementById("<?php echo $_REQUEST["des"]?>").style.display = "block";
	</script>
	<?php }?>
