/*
<meta name="author" content="Asier García">
*/
var _counter = 0;
var _counterMu = 0;

function iniciar() {
	
	document.getElementById("enviar").addEventListener('click', comprobarNombres, false);
	document.getElementById("enviar").addEventListener('click', comprobarCampos, false);
	valorSwitches();
	//No se por qué pero los botones una vez añades más solo funcionan si agregas el evento en el propio boton con onclick, manejandolo con eventos creo 
	//que hay algún conficto de id y no lo añade correctamente(index line 50, 60, 76, 77)


	/*
	document.getElementById("anadir").addEventListener('click', anadirC, false);
	document.getElementById("eliminar").addEventListener('click', eliminarC, false);
	document.getElementById("anadirMu").addEventListener('click', anadirMu, false);
	document.getElementById("eliminarMu").addEventListener('click', eliminarMu, false);
	*/

}

function valorSwitches(){
	var switches = $(".custom-control-input");
							
	for(var i = 0; i < switches.length ; i++){
		var id = "#obli"+ i;
		$(id).on('change', function(){
			this.data = this.checked ? 1 : 0;
			//alert(this.value);
		}).change();
	}
}

function copiarClipboard(e) {
	
	var aes = document.getElementById("enlaces").childNodes[1].getElementsByTagName("a");
	for(var i = 0; i < aes.length ; i++){
		var text ="localhost/Asier/formulariobase/formularios/" + aes[i].textContent; 
		document.getElementById("ocult" + (i+2)).value = text;
	}

		var link = e.currentTarget.nextElementSibling; //el input oculto al que se le recoge el valor
		
		/* Select the text field */
		//link.focus();
		link.select();
	
		try {
			var successful = document.execCommand('copy');
			var msg = successful ? 'successful' : 'unsuccessful';
			console.log('Copying text command was ' + msg);
		} catch (err) {
			console.log('Oops, unable to copy');
		}
	}

function openLink(evt, animName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" w3-pale-red", "");
  }
  document.getElementById(animName).style.display = "block";
  evt.currentTarget.className += " w3-pale-red";
}


//añadir elementos del form
function anadirC(event) {
	event.preventDefault();
	_counter++;
	
    var oClone = document.getElementById("template0").cloneNode(true);
	oClone.id = ("template" + _counter );
	document.getElementById("container").appendChild(oClone);


	var inputs = document.getElementById("template" + _counter).childNodes[1].getElementsByTagName("div")[1].getElementsByTagName("input") //recojo los inputs del div(templateMu + _counter)
	var name = "opcionM[" + _counter + "][]";
	
	for (var i = 0; i < inputs.length; i++) {
		
		inputs[i].setAttribute("name", name);
	}

	//cambiar el id y el for del switch creado
	var swch = (document.getElementById("template" + _counter).childNodes[1].getElementsByTagName("div")[5].childNodes[1]); //el input del switch que se acaba de añadir
	var labl = (document.getElementById("template" + _counter).childNodes[1].getElementsByTagName("div")[5].childNodes[5]); //el label asociado al switch
	var nm = ("obli" + _counter);
	
	swch.setAttribute("id", nm); 
	labl.setAttribute("for", nm); 

	//valorSwitches();
	
}

function anadirMu(event) {
	event.preventDefault();
	_counterMu++;

	var oCloneMu = document.getElementById("templateMu0").cloneNode(true);
	oCloneMu.id = ("templateMu" + _counterMu );
    event.target.parentElement.appendChild(oCloneMu);
	
	var input = event.target.parentElement.lastChild.getElementsByTagName("input")[0]; //el input M[] que acabo de añadir
	var idM = event.target.parentElement.parentElement.parentElement.parentElement.id; //el template donde está el input para ponerle el mismo counter y saber de quien es la opcion
	
	idM = idM.substr(idM.length - 1 );
	
	input.setAttribute("name", "opcionM[" + idM + "][]");


}

//eliminar elementos del form

function eliminarC(event){
	event.preventDefault();
	
	var cont = event.target.parentElement.parentElement;
	cont.parentNode.removeChild(cont);
}

function eliminarMu(event){
	event.preventDefault();
	
	var cont = event.target.parentElement;
	cont.removeChild(cont.lastChild);
}

function comprobarCampos(e){
	var tipoM = document.getElementsByName("tipoM[]");
	var tipoI = document.getElementsByName("tipoI[]");
	
	for(var i = 0; i < tipoM.length ; i++){ //recorro todos los selects de todos los campos a introducir

		var valorI = tipoI[i].options[tipoI[i].selectedIndex].value;
		var valorM = tipoM[i].options[tipoM[i].selectedIndex].value;
		var opcM = document.getElementsByName("opcionM["+ i +"][]");

		if(valorM != "" && valorI !=""){
			alert("por favor, selecciona un solo tipo de input");
			e.preventDefault();
		}else if(valorM == "" && valorI ==""){
			alert("por favor, selecciona un tipo de input");
			e.preventDefault();
		}else if(valorM != "" && document.getElementById("templateMu"+i) == null){
			alert("por favor, introduce al menos un valor");
			e.preventDefault();
		}else if(valorI == "range" && opcM.length != 2 ){
			alert("por favor introduce 2 rangos min. y máx. para el campo rango");
			e.preventDefault();
		}

		for(var j = 0; j < opcM.length ; j++){
		
			if(valorM != "" && opcM[j].value == ""){
				alert("por favor, introduce un valor para todos los campos o elimina el vacío");
				e.preventDefault();
			}
		}

	}
	
}

//dependiendo de la opcion seleccionada del tipo de campo mostrar o no las opciones
function cambioSelect(e){
	var opc = e.target.value;
	//alert(opc);
	var div = e.target.parentNode.nextElementSibling;
    if(opc == "select" || opc == "checkbox" || opc == "radio" || opc == "range"){
		
		div.style.display = "inline";
		
	}else{
		div.style.display = "none";
	}
}

function comprobarNombres(e){
	var correcto = true;
	var inputs = document.getElementsByClassName("input");
	var valuesSoFar = [];

	for (var i = 0; i < inputs.length; i++) {
		//alert(inputs[i].value);
        var value = inputs[i].value;
        if (valuesSoFar.indexOf(value) !== -1) {
			correcto = false;
			break;
        }
        valuesSoFar.push(value);
    }

	if(!correcto){
		e.preventDefault();
		alert("no puede haber 2 campos con el mismo nombre");
	}

}

window.onload = iniciar; //Sin paréntesis