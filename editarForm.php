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
	<!-- JS, Popper.js, and jQuery -->
		<script src="bootstrap/js/jquery-3.5.1.slim.min.js"></script>
		<script src="bootstrap/js/popper.min.js" ></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
		<!-- CSS only -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<style>
			form{
				
				background-color: lightgray;
				padding: 2%;
				margin: 1%;
				border-radius: 5px;
			
			}

			.cont{
				display: flex;
  				justify-content: center;
			}
			#add{
				width: 110%;
			}
		</style>
</head>
<body>
	
<?php 
include "menu.php";

    if(isset($_REQUEST['nomForm'])){

		$nombre = $_REQUEST['nomForm'];
		$_SESSION["nomForm"] = $nombre;
		$sel = mysqli_query($conexion, "select opciones from " . $nombre);
		
?>
<div style="margin-left:130px">
  <div class="w3-padding">FORMULARIO</div>
	<div class="w3-container city w3-animate-opacity">
	<form action="editarForm.php" method="post">
		<table>
		<thead>
            <tr>
				<th><h3></h3></th>
				<th><h3>Campo</h3></th>
				<th><h3>Tipo</h3></th>
				<th><h3>Obligatorio</h3></th>
				<!-- contar las opcines que hay en un campo( contar los - en el string de opciones + 1 )-->
				<?php
					$opciones = 0;
					while($reg =  mysqli_fetch_row($sel)){
						$opcionesF = substr_count($reg[0], "-");
						
						if($opcionesF > $opciones){
							$opciones = $opcionesF;
						}
					}
					$opciones = $opciones + 1;
					
					for($i =  1; $i <= $opciones ; $i++){
				?>

				<?php } ?>
				<th class="opcioMu" colspan="<?php echo $i?>"><h3>Opciones </h3></th>
				
				
            </tr>
				</thead>
<?php
		$select = mysqli_query($conexion, "select * from " . $nombre);
		while($registro =  mysqli_fetch_row($select)){
?>	
			<tr id="tr<?php echo $registro[0]?>">
				<td><form method="post" action="editarForm.php">
					<input type="hidden" name="idEl" value="<?php echo $registro[0] ?>">
					<button class="btn" name="eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar este campo?')"><i class="fa fa-trash"></i></button>
				</form></td>
				<td><textarea type="text" name="campo[]" rows="3" cols="25"><?php echo $registro[1]; ?></textarea></td>
				<td>
					<select name="tipo[]">
						<?php 
							if( $registro[2] == "checkbox" ||  $registro[2] == "select" ||  $registro[2] == "radio" ||  $registro[2] == "rango"){
						?>
								<option value="<?php echo $registro[2]?>"><?php echo $registro[2]?></option>
								<option value="checkbox">*checkbox*</option>
								<option value="select">*select*</option>
								<option value="radio">*radio*</option>
								<option value="range">*rango*</option>
					<?php	}else{    ?>
								<option value="<?php echo $registro[2]?>"><?php echo $registro[2]?></option>
								<option value="input">*input*</option>
								<option value="color">*color*</option>
								<option value="pass">*password*</option>
								<option value="tel">*teléfono*</option>
								<option value="email">*email*</option>
								<option value="date">*date*</option>
								<option value="datetime-local">*datetime*</option>
								<option value="file">*fichero*</option>
								<option value="month">*"dia de mes"*</option>
								<option value="number">*número*</option>
								<script>
									
										/*var nones = document.getElementsByClassName("opcioMu");
										for (var i = 0; i < nones.length ; i++ ){
											document.getElementsByClassName("opcioMu")[i].style.display = "none";
										}*/
									
								</script>
					<?php } ?>	
					</select>
				</td>
				<td>
					<?php 
					if($registro[3] == "1"){
						echo '<div class="custom-control custom-switch">
								<input name="obligatorio[]" type="checkbox" class="custom-control-input" id="obli" checked value="1">
								<input type="hidden" name="obligatorio[]" value="0" />
								<label class="custom-control-label" for="obli"> ¿obligatorio?</label>
							</div>';
					}else{
						echo '<div class="custom-control custom-switch">
								<input name="obligatorio[]" type="checkbox" class="custom-control-input" id="obli" value="1">
								<input type="hidden" name="obligatorio[]" value="0" />
								<label class="custom-control-label" for="obli"> ¿obligatorio?</label>
							</div>';
					}
					?>

				<script>
					valorSwitches();
					var swch = (document.getElementsByClassName("custom-control-input")); 
					var labl = (document.getElementsByClassName("custom-control-label"));
					
					for(var i = 0; i < swch.length; i++){
						var nm = ("obli" + i);

						swch[i].setAttribute("id", nm);
						labl[i].setAttribute("for", nm);
					}
					
				</script>
					
				</td> 

				<?php 
				$string = explode("-", $registro[4]);
					for($i = 0 ; $i < count($string); $i++){
						if($string[$i] != ""){ ?>
							<td class="opcioMu">
								<input type="text" name="op[<?php echo $registro[0] ?>][]" value="<?php echo $string[$i]?>" size="5">
							</td>
						<?php }else{ ?>
							<td>
								<input type="hidden"  name="op[<?php echo $registro[0] ?>][]">
							</td>

						<?php } ?>
				
			<?php   } ?>
			
			<td class="opcioMu">
				<?php 
					//para que solo deje añadir opciones a los campos que la vayan a utilizar
					if($registro[2] == "checkbox" ||  $registro[2] == "select" ||  $registro[2] == "radio" ||  $registro[2] == "rango"){ ?>
						<form id="add" action="editarForm.php" method="post">
							<input type="text" name="opMul" placeholder="Nueva opción" size="9">
							<input  type="hidden" name="idForm" value="<?php echo $registro[0] ?>">
							<button class="btn" name="anadirOpMul"><i class="material-icons">add</i></button>
						</form>
				<?php } ?>
				
			</td>
			</tr>
<?php		
		}
?>
		</table>
		
		

		<div class="cont">
			<button type="submit" name="guardarCambios" class="btn"><i class="material-icons">save</i><h7>Guardar</h7></button>
		</div>
	</form>

	<hr/> <!------------------------------------------------------------------------------------------------------------------------------------------------------------>

	<form action="editarForm.php" method="post">
		<table >
				<thead>
					<th>Nombre</th><th>Tipo</th><th>Obligatorio</th>
				</thead>
				<tbody>
					<tr>
						<td><textarea type="text" name="campoNue" rows="3" cols="25"></textarea></td>
						<td>
							<select name="tipoNue">
									<option disabled>--- Múltiple ---</option>
									<option value="checkbox">checkbox</option>
									<option value="select">select</option>
									<option value="radio">radio</option>

									<option disabled>--- Inputs ---</option>

									<option value="input">input</option>
									<option value="color">color</option>
									<option value="pass">password</option>
									<option value="tel">teléfono</option>
									<option value="email">email</option>
									<option value="date">date</option>
									<option value="datetime-local">datetime</option>
									<option value="range">rango</option>
									<option value="file">fichero</option>
									<option value="month">"dia de mes"</option>
									<option value="number">número</option>
									<option value="textarea">textarea</option>
							</select>
						</td>
						<td>
							<div class="custom-control custom-switch">
								<input name="obligatorioNue" type="checkbox" class="custom-control-input" id="obli" value="1">
								<label class="custom-control-label" for="obli"> ¿obligatorio?</label>
							</div>
						</td>

					</tr>
				</tbody>
			</table>
			<div class="cont">
				<button type="submit" class="btn" name="anadir"><i class="material-icons">add</i>Añadir</button>
			</div>
<?php       
	
}

if(isset($_REQUEST["anadirOpMul"])){ //añadir opciones al campo de opciones
	$op = $_REQUEST["opMul"];
	$id = $_REQUEST["idForm"];
	
	if($op != ""){
		$select = mysqli_query($conexion, "select opciones from " . $_SESSION["nomForm"] . " where id like '" . $id . "';");
		$cad = "";
			while($registro =  mysqli_fetch_row($select)){
				$cad = $registro[0];
			}
	
			$cad = $cad . "-" . $op;
			if($cad[0] == "-"){ //si empieza por -, lo quito
				$cad = substr($cad, 1);
			}
			
			$update = "UPDATE " . $_SESSION["nomForm"] ." SET opciones='".$cad."' WHERE id like '". $id ."';";
			mysqli_query($conexion, $update);
	
		//edito el fichero html donde está el fichero
		editarFichero();
	}
	
	echo "<meta http-equiv='refresh' content='0; editarForm.php?nomForm=" . $_SESSION["nomForm"] ."';'>";
}

if(isset($_REQUEST["anadir"])){ //añadir una nueva fila a la tabla, un nuevo campo al formulario

	if(!isset($_REQUEST["obligatorioNue"])){
		$_REQUEST["obligatorioNue"] = 0;
	}

	if(($_REQUEST["campoNue"])!= ""){
		$ins = "INSERT INTO " . $_SESSION["nomForm"] . " values('', '" . $_REQUEST["campoNue"]."', '" . $_REQUEST["tipoNue"]. "', '" . $_REQUEST["obligatorioNue"]. "', '')";
		mysqli_query($conexion, $ins);

		//edito el fichero html donde está el fichero
		editarFichero();
	}

	echo "<meta http-equiv='refresh' content='0; editarForm.php?nomForm=" . $_SESSION["nomForm"] ."';'>";
}


if(isset($_REQUEST["eliminar"])){ //eliminar campo del form
	
	$del = "DELETE FROM " . $_SESSION["nomForm"] ." WHERE id like '". $_REQUEST["idEl"] ."';";	
	mysqli_query($conexion, $del);

	//edito el fichero html donde está el fichero
	editarFichero();

	echo "<meta http-equiv='refresh' content='0; editarForm.php?nomForm=" . $_SESSION["nomForm"] ."';'>";
}
	

if(isset($_REQUEST["guardarCambios"])){
		//recoger los valores de todos los campos y hacer update, me da igual que los haya cambiado o no
		$_REQUEST["obligatorio"] = tratOblig($_REQUEST["obligatorio"]);
		
		$select = mysqli_query($conexion, "select id from " . $_SESSION["nomForm"]);
		while($registro =  mysqli_fetch_row($select)){
			$id = $registro[0];

			//tratar las opciones por si el usuario ha querido eliminar alguna de las opciones borrándola de su campo
			$cad = "";
			for($k = 0; $k < count($_REQUEST["op"][$id]) ; $k++){
				if($_REQUEST["op"][$id][$k] != ""){
					$cad .= $_REQUEST["op"][$id][$k] . "-";
				}
			}
			$cad = substr($cad, 0, -1); //si acaba por -, lo quito
			
			$consulta = "UPDATE " . $_SESSION["nomForm"] ." SET campo='". trim($_REQUEST["campo"][($id -1)])."', tipo='". trim($_REQUEST["tipo"][($id -1)]) ."', 
			obligatorio='". trim($_REQUEST["obligatorio"][($id -1)])."', opciones = '" . $cad . "' WHERE id like '".($id)."';";
			
			mysqli_query($conexion, $consulta);
			
		}
		//edito el fichero html donde está el fichero
		editarFichero();

		echo "<meta http-equiv='refresh' content='0; editarForm.php?nomForm=" . $_SESSION["nomForm"] ."';'>";
}
?>
</div>
</div>
	</div>
</body>
</html>
