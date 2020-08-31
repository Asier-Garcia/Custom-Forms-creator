<?php 
include("datosconexion.php");

function conexion(){
	$conexion = mysqli_connect(HOST, USER, PASSWORD, NAME);
    if(mysqli_connect_errno()){
        echo "Fallo al conectar con la BBDD";
        exit();
	}
	return $conexion;
}

function tratOblig($arrObli){ //trata el array obligatorio. Si es 1 salta 1 pos (la del input oculto) y si es 0 salta de 1 en 1 

	$i = 0;
	$j = 0;
	$arr = [];
	while($i < count($arrObli)){
		if($arrObli[$i] == 1){
			$arr[$j] = $arrObli[$i];
			$i = $i + 2;
		}else{
			$arr[$j] = $arrObli[$i];
			$i++;
		}
		$j++;
	}
	
	return $arr;
}

function mostrar(){ //mostrar un formulario de los datos solicitados por el usuario

	$_SESSION["obligatorio"] = tratOblig($_REQUEST['obligatorio']);

	$contenido = "";
	if(isset($_REQUEST['campo'])){$_SESSION["campo"] = $_REQUEST['campo'];}
	if(isset($_REQUEST['opcionM'])){$_SESSION["opciones"] = $_REQUEST['opcionM'];}
	if(isset($_REQUEST['tipoI'])){$_SESSION["tipoI"] = $_REQUEST['tipoI'];}


	for($i = 0; $i < count($_SESSION["campo"]); $i++){
		$cad = "<div class='form-group'><label> " . $_SESSION['campo'][$i];

		if($_SESSION["obligatorio"][$i] == "1") $obli = "required";
		else {
			$obli = "";
		}

		switch($_SESSION["tipoI"][$i]){
			
			case "text":
				$contenido .= $cad . " <input class='form-control' type = 'text' name = '".$_SESSION['campo'][$i]."' " . $obli ." /></label></div>";
				
				break;
			case "pass":
				$contenido .= $cad . "<input class='form-control'  type = 'password' name = '".$_SESSION['campo'][$i]."' " . $obli ." /></label></div>";
				
				break;
			case "tel":
				$contenido .= $cad . "<input class='form-control' type = 'tel' name = '".$_SESSION['campo'][$i]."' " . $obli ." /></label></div>";
				
				break;
			case "color":
				$contenido .= $cad . "<input class='form-control' type = 'color' name = '".$_SESSION['campo'][$i]."' " . $obli ." /></label></div>";
				
				break;
			case "email":
				$contenido .= $cad . "<input class='form-control'  type = 'email' name = '".$_SESSION['campo'][$i]."' " . $obli ." /></label></div>";
				
				break;
			case "date":
				$contenido .= $cad . "<input class='form-control' type = 'date' name = '".$_SESSION['campo'][$i]."' " . $obli ." /></label></div>";
				
				break;
			case "datetime-local":
				$contenido .= $cad . "<input class='form-control'  type = 'datetime-local' name = '".$_SESSION['campo'][$i]."' " . $obli ." /></label></div>";
				
				break;
			case "range":
				$contenido .= $cad . "<input class='form-control-range' type = 'range' id='input' name = '".$_SESSION['campo'][$i]."' " . $obli ."  
				min= '". $_SESSION["opciones"][$i][0]. "' max= '". $_SESSION["opciones"][$i][1]. "' oninput='output.value = input.value'/></label></div>";
				$contenido .= "<output id='output' name = 'outputN'>-</output>";
				
				break;
			case "file":
				$contenido .= $cad . "<input class='form-control-file' type = 'file' name = '".$_SESSION['campo'][$i]."' " . $obli ." /></label></div>";
				
				break;
			case "month":
				$contenido .= $cad . "<input class='form-control'  type = 'month' name = '".$_SESSION['campo'][$i]."' " . $obli ." /></label></div>";
				
				break;
			case "number":
				$contenido .= $cad . "<input class='form-control'  type = 'number' name = '".$_SESSION['campo'][$i]."' " . $obli ." /></label></div>";
				
				break;
			case "textarea":
				$contenido .= $cad . "<textarea class='form-control' type = 'text' name = '".$_SESSION['campo'][$i]."' " . $obli ." ></textarea></label></div>";
				
				break;

			//opciones multiples
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------

			case "select":
					$contenido .= "<label> " .$_SESSION['campo'][$i] . "<select class='form-control' name = '" . $_SESSION["campo"][$i] ."'" . $obli .">";
				
					for($j = 0 ; $j < count($_SESSION["opciones"][$i]) ; $j++){
						
						$contenido .= "<option value= " . $_SESSION["opciones"][$i][$j]. ">" . $_SESSION["opciones"][$i][$j] . "</option>";
					}
					$contenido .= "</select></label></div>";
					
				break;
			case "checkbox":
					  $contenido .= "<legend>" . $_SESSION["campo"][$i] . "</legend>";
					  for($j = 0 ; $j < count($_SESSION["opciones"][$i]) ; $j++){
							$name = str_replace(' ', '_', $_SESSION["opciones"][$i][$j]);
							$contenido .= "<div class='form-check'><input class='form-check-input' type='checkbox' id='" . $name . "' name = '" . $_SESSION["campo"][$i] . "' value = '".$name."'>
							<label class='form-check-label' for='" . $name ."'>" . $_SESSION["opciones"][$i][$j] . "</label></div>";
					  }
					  $contenido .= "</div>";
					  		
				break;
			case "radio":
					$contenido .= "<p>" . $_SESSION["campo"][$i] . "</p>";
					  for($j = 0 ; $j < count($_SESSION["opciones"][$i]) ; $j++){
							$name = str_replace(' ', '_', $_SESSION["opciones"][$i][$j]);
							$contenido .= "<div class='form-check'><input class='form-check-input' type='radio' id='" . $name . "' name = '" . $_SESSION["campo"][$i] . "' value = '".$name."'>
							<label class='form-check-label' for='" . $name ."'>" . $_SESSION["opciones"][$i][$j] . "</label></div>";
					  }
					  $contenido .= "</div>";
					  
				break;
			default:
				break;
			
		}	
	}
	echo $contenido;
	$_SESSION["contenido"] = $contenido;
}

function editarFichero(){
	$conexion = conexion();
	$select = mysqli_query($conexion, "select * from " . $_SESSION["nomForm"]);
		$contenido = "";
		while($registro =  mysqli_fetch_row($select)){
			if($registro[3]== "on"){$obli = "required";}else{$obli = "";}
			if(!empty($registro[4])){$opcio = explode("-", $registro[4]);}
			
			
			if($registro[2] == "textarea" || $registro[2] == "select" || $registro[2] == "checkbox" || $registro[2] == "radio" ||  $registro[2] == "range"){
				switch($registro[2]){
					case "range":
						$contenido .= "<label>" . $registro[1] ."<input type= 'range' id = 'inputRange' name = '" . $registro[1] . "' " . $obli . " min= '" . $opcio[0] . "' max= '" . $opcio[1] . "'
						oninput='outputRange.value = inputRange.value'/></label>";
						$contenido .= "<output id='outputRange' name= 'outputN'>-</output>";
						break;
					case "textarea":
						$contenido .= "<label>" . $registro[1] ."<textarea type='text' " . $obli ." name= '" . $registro[1] . "'></textarea></label>";
						break;
					case "select":
						
						$contenido .= "<label> " . $registro[1] . "<select name = '" . $registro[1] ."'" . $obli .">";
				
							for($j = 0 ; $j < count($opcio) ; $j++){
								
								$contenido .= "<option value= " . $opcio[$j]. " >" . $opcio[$j] . "</option>";
							}
						$contenido .= "</select></label>";
						break;
					case "checkbox":
						$contenido .= "<p>" . $registro[1] . "</p>";
						for($j = 0 ; $j < count($opcio) ; $j++){
								$name = str_replace(' ', '_', $opcio[$j]);
								$contenido .= "<input type='checkbox' id='" . $name . "' name = '" . $registro[1] . "' value = '".$name."'>
								<label for='" . $name ."'>" . $opcio[$j] . "</label>";
						}
						break;
					case "radio":
						$contenido .= "<p>" . $registro[1]  . "</p>";
						for($j = 0 ; $j < count($opcio) ; $j++){
								$name = str_replace(' ', '_', $opcio[$j]);
								$contenido .= "<input type='radio' id='" . $name . "' name = '" . $registro[1] . "' value = '".$name."'>
								<label for='" . $name ."'>" . $opcio[$j] . "</label><br>";
						}
						break;
				}
				
			}else{
				$contenido .= "<label> ".$registro[1] ." <input type = '". $registro[2]."' name = '" . $registro[1] ."' " . $obli . "/><label>";
			}
		}
		
		anadirHTML($contenido);
}

function anadirHTML($contenido){
		if(isset($_REQUEST["nombreForm"])){
			$_SESSION["nomForm"] = $_REQUEST["nombreForm"];
			$nombre = "formulario_" . $_SESSION["nomForm"];
		}else{
			$nombre = $_SESSION["nomForm"];
		}
		$ruta = "formularios/" . $nombre . ".html";
		$file = fopen($ruta, "w");
			
		//añado el contenido al fichero
			$html = '<html lang="en">
			<head>
				<meta charset="UTF-8">
				<title>Formulario</title>
				<script src="../validar.js"></script>
				<link rel="stylesheet" href="../pestañas.css"/>
				<link rel="stylesheet" href="../estilos.css"/>
				<!-- CSS only -->
				<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" >
		
				<!-- JS, Popper.js, and jQuery -->
				<script src="../bootstrap/js/jquery-3.5.1.slim.min.js"></script>
				<script src="../bootstrap/js/popper.min.js" ></script>
				<script src="../bootstrap/js/bootstrap.min.js"></script>
			</head>
			<body>
				<form type"post" action="' . $nombre . '" >
					<fieldset><legend>formulario</legend>' . $contenido . '
			</fieldset>
			<button type="submit">Enviar</button>
			</form></body></html>';
			fwrite($file, $html);
			fclose($file);
}

function ejecutaSQLarray($sentencias, $link){
	// SEGURIDAD: ASEGURAMOS LA EJECUCCION DE TODAS LAS SENTENCIAS SQL
   
		   // insertamos la sentencia BEGIN para indicar el comienzo de una transaccion
		   mysqli_query($link, "BEGIN");
		   // ejecutamos las sentencias
		   for($i = 0;$i < count($sentencias);$i++){
			   mysqli_query($link, $sentencias[$i]);
		   }
		   // indicamos el final de la transaccion, en este caso con COMMIT
		   mysqli_query($link, "COMMIT"); 
		   // Cerramos la conexion
		   mysqli_close($link);
	
}
?>