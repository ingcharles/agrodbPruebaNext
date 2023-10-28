<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>RegistroCapacitaciones' data-opcion='CursosImpartidos/guardar' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
<?php echo $this->contenidoInformacionCapacitacion;?>
<?php echo $this->contenidoLugarCapacitacion;?>
<?php echo $this->contenidoPublicoMeta;?>
<?php echo $this->contenidoDetallePublico;?>
<?php echo $this->contenidoDatosCapacitador;?>
<?php echo $this->contenidoDatosGenerales;?>

<div data-linea="4" class="editable">
    <button type="submit" class="guardar" id="hola">Guardar</button>
</div>

</form >
<div id="cargarMensajeTemporal"></div>
<script type ="text/javascript">
	$(document).ready(function() {
		$("#id-Oficina").hide();
		$("#idOficina").hide();
		construirValidador();
		distribuirLineas();
		$("#btnAgregarTema").attr('disabled', true);
		$("#estado").html("");	
		$("#coordinacionCapacitador").hide();
		$("#provinciaCapacitador").hide();
		$("#funcionarioCapacitador").hide();
		$("#nombreCapacitador").hide();
		$("#paisCapacitador").hide();
		$("#institucionCapacitador").hide();

		$("#id_NombreCapacitador").keypress(function (e) {
            var tecla = document.all ? tecla = e.keyCode : tecla = e.which;
            return !((tecla > 47 && tecla < 58) || tecla == 46);
        });
		
	});

	let idCurso;
	let banderaFecha = false;
	let banderaCantidad=false;

	$("#fecha_ejecucion").datepicker({
		startDate: new Date(),
		changeMonth: true,
	    changeYear: true,
		//minDate: "-3M +0D" ,
		//maxDate: 0
	});

	$('.input-number').on('input', function () { 
		this.value = this.value.replace(/[^0-9,]/g,'');
	});	

function contadorPalabrasInput(elemento){
	
	text_max  = $(elemento).attr("maxlength")
    	$('#textarea_feedback').html('Quedan ' + text_max + ' caracteres');
    	$(elemento).keyup(function() {
       	 	var text_length = $(elemento).val().length;
      	 	var text_remaining = text_max - text_length;
        $('#textarea_feedback').html('Quedan ' + text_remaining + ' caracteres');
    	});
}

function contadorPalabrasInputSitio(elemento){
	
	text_max  = $(elemento).attr("maxlength")
    	$('#textarea_feedbackSitio').html('Quedan ' + text_max + ' caracteres');
    	$(elemento).keyup(function() {
       	 	var text_length = $(elemento).val().length;
      	 	var text_remaining = text_max - text_length;
        $('#textarea_feedbackSitio').html('Quedan ' + text_remaining + ' caracteres');
    	});
}

	function zero(n) {
	return (n>9 ? '' : '0') + n;
	}
	var date = new Date();
	var fechaActual = date.getFullYear() +"-"+zero(date.getMonth()+1) +"-"+zero(date.getDate());


	$("#tablaPublico").each(function(){
			
			$("td #eliminar").attr('disabled', true);
		});

	$("#formulario").submit(function (event) {
		$("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Cargando...</div>").fadeIn();
		event.preventDefault();
		var error = false;
		mostrarMensaje("", "")
		$(".alertaCombo").removeClass("alertaCombo");

		if($("#fecha_ejecucion").val() == ''){
			error=true;
			$('#fecha_ejecucion').addClass("alertaCombo");	
		}

		if($("#idTipo").val() == 0){
			error=true;
			$('#idTipo').addClass("alertaCombo");	
		}
		if($("#id_direccion").val() == "Seleccione...."){
			error=true;
			$('#id_direccion').addClass("alertaCombo");	
		}

		if($("#idProvincia").val() == ''){
			error=true;
			$('#idProvincia').addClass("alertaCombo");	
		}
		if($("#idCanton").val() == ''){
			error=true;
			$('#idCanton').addClass("alertaCombo");	
		}else if($("#idCanton option:selected").text() == 'Quito'){
			
			if ($("#idParroquia option:selected").text() !='Iñaquito'){
				$("#idOficina").val('');
				error=false;
			}else if(($("#idOficina").val() == 'Seleccione....')){
				error=true;
				$("#idOficina").addClass("alertaCombo");	
			}
		}

		if($("#idParroquia").val() == '' || $("#idParroquia").val() == 'Seleccione....'){
			error=true;
			$('#idParroquia').addClass("alertaCombo");	
		}

		if($("#idSitio").val() == '' || (($("#idSitio").val()).replace(/ /g,''))=='' ){
			error = true;
			$('#idSitio').addClass("alertaCombo");	
		}

		if($("#text_conclusion").val() == ''){
			error=true;
			$('#text_conclusion').addClass("alertaCombo");	
		}

		if($("#archivoCons").val() == 0 || $("#archivoCons").val() == ""){
			error=true;
			$('#archivoConstancia').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}else if ($("#archivoCons").val() == "No se cargó archivo. Extención incorrecta"){
			error=true;
			$('#archivoConstancia').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}
	
		if($("#archivoEvi").val() == 0 || $("#archivoEvi").val() == ""){
			error=true;
			$('#archivoEvidencia').addClass("alertaCombo");	
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");
		}else if ($("#archivoEvidencia").val() == "No se cargó archivo. Extención incorrecta"){
			error=true;
			$('#archivoEvidencia').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");
		}

		var rows = document.getElementById('tablaTemasEspecificos').rows.length;
		if(rows==1){
			error=true;
			$('#tablaTemasEspecificos').addClass("alertaCombo");
		}

		var rows = document.getElementById('tablaPublico').rows.length;
		if(rows==1){
			error=true;
			$('#tablaPublico').addClass("alertaCombo");
		}
		var rows = document.getElementById('tablaDetallePublico').rows.length;
		if(rows==1){
			error=true;
			$('#tablaDetallePublico').addClass("alertaCombo");
		}

		var rows = document.getElementById('tablaCapacitador').rows.length;
		if(rows==1){
			error=true;
			$('#tablaCapacitador').addClass("alertaCombo");
		}
			if (!error) {
				setTimeout(function(){
					JSON.parse(ejecutarJson($("#formulario")).responseText);
					if(respuesta.estado == 'Exito'){
						$("#estado").html(respuesta.mensaje);
					}else{
						$("#estado").html(respuesta.mensaje);
					}
				}, 1000);
				
			} else {
				$("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Cargando...</div>").fadeOut();
				$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
			}
		
	});

 
function carga(estado, archivo, boton) {
        this.esperar = function (msg) {
            estado.html("Cargando el archivo...");
            archivo.addClass("amarillo");
        };

        this.exito = function (msg) {
            estado.html("El archivo ha sido cargado.");
            archivo.removeClass("amarillo");
            archivo.addClass("verde");
            boton.attr("disabled", "disabled");
            $("#nuevoDocumento :submit").removeAttr("disabled");
        };

        this.error = function (msg) {
            estado.html(msg);
            archivo.removeClass("amarillo");
            archivo.addClass("rojo");
        };
    }


/********************************************************/
//Inicio funcion que activa combo de ciudades dada una provincia

$("#idProvincia").change(function () {
	$("provincia").val('');
	$("#idCanton").val('');
	$("#idCanton").attr('disabled', 'disabled');
	$("#idParroquia").attr('disabled', 'disabled');
	$("#idParroquia").val('');
	$("#idOficina").attr('disabled', 'disabled');
	$("#idOficina").val('');
	$("#idSitio").val('');
	if ($("#idProvincia option:selected").val() !== "") {
		$("#nombreProvincia").val($("#idProvincia option:selected").text());
		fn_cargarCantonesXProvincia();
	}	
});

//fncion que carga las ciudades dada una provincia
function fn_cargarCantonesXProvincia() {

	var idProvincia = $("#idProvincia option:selected").val();
	
	if (idProvincia !== '') {

		$.post("<?php echo URL ?>RegistroCapacitaciones/Base/comboListaCantonesXProvincia/", 
		{
			idProvincia : idProvincia
		},
		function (data) {
			
			$("#idCanton").html(combo+data);
			$("#idCanton").removeAttr('disabled');
		});
	}else{
		$("#idCanton").val('');
		$("#idCanton").attr('disabled', 'disabled');
	}
}

//Inicio funcion que activa combo de parroquias dada un canton 

$("#idCanton").change(function () {
	$("#id-Oficina").hide();
	$("#idOficina").hide();
	$("canton").val('');
	$("#idParroquia").val('');
	$("#idOficina").val('');
	$("#idSitio").val('');
	if ($("#idCanton option:selected").val() !== "") {
		$("#nombreCanton").val($("#idCanton option:selected").text());
		fn_cargarParroquiasXCanton();
	}
	
});

//funcion que carga las las parroquias dado un canton
function fn_cargarParroquiasXCanton() {

	var idCanton = $("#idCanton option:selected").val();

	if (idCanton !== '') {

		$.post("<?php echo URL ?>RegistroCapacitaciones/CursosImpartidos/comboListaParroquiasXCanton/", 
		{
			idCanton : idCanton
		},
		function (data) {
			
			$("#idParroquia").html(combo+data);
			$("#idParroquia").removeAttr('disabled');
		});
	}else{
		$("#idParroquia").val('');
		$("#idParroquia").attr('disabled', 'disabled');
	}
}

//Inicio funcion que activa combo de oficinas cuando selecciona una parroquia
$("#idParroquia").change(function () {
	
	if ($("#idCanton option:selected").val() !== "") {
		$("#nombreParroquia").val($("#idParroquia option:selected").text());
		$("#idOficina").removeAttr('disabled',false);
		$("#idSitio").val('');
		fn_cargarOficinasXCanton();
	}
});

//funcion que carga las las oficinas dado un canton
function fn_cargarOficinasXCanton() {
	
	var idCanton = $("#idCanton option:selected").val();
	var nombreCanton = $("#idCanton option:selected").text();

	if (idCanton !== '') {

		$.post("<?php echo URL ?>RegistroCapacitaciones/CursosImpartidos/comboListaOficinasXCantones/", 
		{
			idCanton : idCanton,
			nombreCanton : nombreCanton
		},
		function (data) {
			
			$("#idOficina").html(combo+data);
			
		});
	}
}

// //obtener el nombre de la oficina seleccionada
$("#idOficina").change(function () {
	if($("#idOficina").val()!=''){
		
		$("#nombreOficina").val($("#idOficina option:selected").text());

	}
});

//Inicio funcion que activa el combo direcciones
$("#id_coordinacion").change(function () {
	$("coordinacion").val('');
	limpiarCamposCabecera();
	$("#id_direccion").attr('disabled', 'disabled');
	if ($("#id_coordinacion option:selected").val() !== "") {
		$("coordinacion").val($("#id_coordinacion option:selected").text());
		fn_cargarDireccionXCoordinacion();
	}
	
});

$("#id_coordinacion").change(function () {
	$("#tablaTemasEspecificos tbody tr").remove();
});

function limpiarCamposCabecera(){
	
	$("#id_direccion").val('');
	$('#id_direccion').prop('disabled', true);
	$("#idTipo").val('');
	$("#id_curso").val('');
	$('#id_curso').prop('disabled', true);
	$("#nombre_tema").val('');
	$('#nombre_tema').prop('disabled', true);
}

//funcion que carga las direcciones dado un id de coordinacion
function fn_cargarDireccionXCoordinacion() {
	
	var id_coordinacion = $("#id_coordinacion option:selected").val();
	
	if (id_coordinacion !== '') {
		$.post("<?php echo URL ?>RegistroCapacitaciones/Base/comboDireccionesXCoordinaciones/", 
		{
			id_coordinacion : id_coordinacion
		},
		function (data) {
			
			$("#id_direccion").html(combo+data);
			$("#id_direccion").removeAttr('disabled');
		});
	}else{
		$("#id_direccion").val('');
		$("#id_direccion").attr('disabled', 'disabled');
	}
}


//Inicio funcion que activa el combo nombres Capacitacion
$("#id_direccion").change(function () {
	
	$("#id_curso").val('');
	$("#id_curso").attr('disabled', false);
	if ($("#id_direccion option:selected").val() !== "") {
		fn_cargarTemasCursosXCoordinacionXDireccion();
	}
	
});

//funcion que carga llos temas cursos dado un id de coordinacion
function fn_cargarTemasCursosXCoordinacionXDireccion() {

	var id_coordinacion = $("#id_coordinacion option:selected").val();
	var id_direccion = $("#id_direccion option:selected").val();
	if (id_coordinacion !== '') {
		$.post("<?php echo URL ?>RegistroCapacitaciones/Base/cargarCursosCapacitacionesXIdCoordinacionXIdDireccion/", 
		{
			id_coordinacion : id_coordinacion,
			id_direccion : id_direccion,
		},
		function (data) {
			
			$("#id_curso").html(combo+data);
			$("#id_curso").removeAttr('disabled');
		});
	}else{
		$("#id_curso").val('');
		$("#id_curso").attr('disabled', 'disabled');
	}
}

function agregarPublico(){
	
		event.preventDefault();
			mostrarMensaje("", "")
	$(".alertaCombo").removeClass("alertaCombo");
	var error = false
	if($('#idPublicoObjetivo').val() == "" ){	
			error = true;
			$(this).addClass("alertaCombo");
		}
	if(!error){
		bandera=false;
		$("td").each(function(){
			if($(this).text()==$('#idPublicoObjetivo option:selected').text()){
				bandera=true;
			}
		});
		if(bandera==false){
			$.post("<?php echo URL ?>RegistroCapacitaciones/CursosImpartidos/agregarPublicoMeta", 
				{
					id_publico : $('#idPublicoObjetivo').val(),
					nombre_publico : $('#idPublicoObjetivo option:selected').text(),
			
				}, function (data) {
			
				if (data.estado === 'EXITO') {
					$("#tablaPublico tbody").append(data.contenido);
					mostrarMensaje(data.mensaje, data.estado);
				} else {
				mostrarMensaje(data.mensaje, "FALLO");
				}
			},  'json');
		}else{
			$("#estado").html("Este publico ya se encuentra agregado.").addClass('alerta');
		}
	}else{
		mostrarMensaje("Seleccione un publico por favor.", "FALLO");
	}
}

function eliminarPublico(e){
	const index = e.parentNode.parentNode.rowIndex;
	const tabla = document.getElementById('tablaPublico');
	const filas = tabla.rows.length;
	tabla.deleteRow(index);
}

var suma=0;

function agregarDetallePublico(){

event.preventDefault();
	mostrarMensaje("", "");
	$(".alertaCombo").removeClass("alertaCombo");
	var error = false;
	var rows = document.getElementById('tablaDetallePublico').rows.length;

	if($.trim($("#genero").val()) == "" && $.trim($("#cantidad").val()) == "" && rows==1){
		error=true;
		$('#genero').addClass("alertaCombo");
		$('#cantidad').addClass("alertaCombo");
	}else if ($.trim($("#cantidad").val()) == "" || $.trim($("#cantidad").val()) == 0 ){
		error=true;
		$('#cantidad').addClass("alertaCombo");
	}else if ($.trim($("#genero").val()) == ""){
		error=true;
		$('#genero').addClass("alertaCombo");
	}
	if ($("#cantidad").val() <= 0 && $("#cantidad").val()!=''){
		error=true;
		banderaCantidad=true;
		$('#cantidad').addClass("alertaCombo");
	}
	if(!error){
		bandera=false;
		$("td").each(function(){
			if($(this).text()===$("#genero").val()){
				bandera=true;
			}
		});
		if(bandera==false){
					
			$.post("<?php echo URL ?>RegistroCapacitaciones/CursosImpartidos/agregarDetallePublico", 
			{
				genero:$("#genero").val(),
				cantidad:$("#cantidad").val(),
			}, function (data) {
			
			if (data.estado === 'EXITO') {
				$("#tablaDetallePublico tbody").append(data.contenido);
				mostrarMensaje(data.mensaje, data.estado);
				calcularAsistentes();
				limpiarCampos();
			} else {
				mostrarMensaje(data.mensaje, "FALLO");
			}
		}, 'json');
		
		}else{
			$("#estado").html("Este detalle y la cantidad ya se encuentra agregado.").addClass('alerta');
		}
	}else{
		if(banderaCantidad == true){
			mostrarMensaje("La cantidad ingresada no es la correcta.", "FALLO");
		}else{
			mostrarMensaje("Por favor Ingrese un detalle y una cantidad para registrar.", "FALLO");
		}
	}	
}

//funcion que elimina el registro de la tabla detalle publico
function eliminarDetallePublico(e){

	const index = e.parentNode.parentNode.rowIndex;
	const tabla = document.getElementById('tablaDetallePublico');
	const filas = tabla.rows.length;
	tabla.deleteRow(index);
	calcularAsistentes();
}

//funcion que calcula el total de asistentes
function calcularAsistentes(){
	var totalAsistentes=0;
	var cantidad = 0;
	$("#tablaDetallePublico tbody tr").each(function(){
		var cantidad = $(this).find('td:eq(1)').text();
		totalAsistentes = totalAsistentes + parseInt(cantidad);
	});
	$("#totalAsistentes").val(totalAsistentes);
}

//Inicio funcion que activa/inactiva datos capacitador interno/externo
var combo = "<option>Seleccione....</option>";
$("#id_TipoCapacitador").change(function () {
	
	if ($("#id_TipoCapacitador").val() == "Interno"){
		limpiarCampos();
		$("#id_CoordinacionCapacitador").removeAttr("disabled");
		$("#id_NombreCapacitador").attr('disabled',true);
		$("#id_InstitucionCapacitador").attr('disabled',true);
		$("#id_PaisCapacitador").attr('disabled',true);

		$("#coordinacionCapacitador").show();
		$("#provinciaCapacitador").show();
		$("#funcionarioCapacitador").show();

		$("#nombreCapacitador").hide();
		$("#paisCapacitador").hide();
		$("#institucionCapacitador").hide();
		
	}else{
		limpiarCampos();
		$("#id_CoordinacionCapacitador").attr('disabled',true);
		$("#id_ProvinciaCapacitador").attr('disabled',true);
		$("#id_Funcionario").attr('disabled',true);
		$("#id_NombreCapacitador").removeAttr("disabled");
		$("#id_PaisCapacitador").removeAttr("disabled");
		$("#id_InstitucionCapacitador").removeAttr("disabled");

		$("#nombreCapacitador").show();
		$("#paisCapacitador").show();
		$("#institucionCapacitador").show();

		$("#coordinacionCapacitador").hide();
		$("#provinciaCapacitador").hide();
		$("#funcionarioCapacitador").hide();
	}
});

//Inicio funcion que activa el combo Provincias de capacitador seleccionado una coordinacion

$("#id_CoordinacionCapacitador").change(function () {
	
	$("#id_ProvinciaCapacitador").val('');
	$("#id_Funcionario").empty();	
	$("#id_ProvinciaCapacitador").removeAttr("disabled");

	
});



//Inicio funcion que activa el combo funcionarios de capacitador seleccionado uan provincia
$("#id_ProvinciaCapacitador").change(function () {
	$("#id_Funcionario").removeAttr("disabled");
		fn_cargarfuncionarios()
});


//funcion que carga todos los funcionarios seleccionado una coordinacion y una provincia
function fn_cargarfuncionarios() {


	var id_coordinacion = $("#id_CoordinacionCapacitador option:selected").val();
	var idProvincia = $("#id_ProvinciaCapacitador option:selected").val();
	if (id_coordinacion !== '' && idProvincia !== '') {
		$.post("<?php echo URL ?>RegistroCapacitaciones/CursosImpartidos/cargarFuncionarios", 
		{
			id_coordinacion : id_coordinacion,
			idProvincia : idProvincia,
		},
		function (datosFuncionario) {
			$("#id_Funcionario").html(datosFuncionario);
			$("#id_Funcionario").removeAttr('disabled');
		});
	}else{
		$("#id_Funcionario").val('');
		$("#id_Funcionario").attr('disabled', 'disabled');
	}
}

//funcion que controla que los campos del capacitador esten llenos 
function agregarCapacitador(){
	mostrarMensaje("", "");
    $(".alertaCombo").removeClass("alertaCombo");
    var error = false;
	if($("#id_TipoCapacitador").val()!=''){
		if($("#id_TipoCapacitador").val()==='Interno'){
			if($.trim($("#id_CoordinacionCapacitador").val())===''){
				error = true;
				$('#id_CoordinacionCapacitador').addClass("alertaCombo");
				$("#id_ProvinciaCapacitador").addClass("alertaCombo");
				$("#id_Funcionario").addClass("alertaCombo");
				mostrarMensaje("Los campos son obligatorios...!", "FALLO");
			}else if($.trim($("#id_ProvinciaCapacitador").val())===''){
				error = true;
				$("#id_ProvinciaCapacitador").addClass("alertaCombo");
				$("#id_Funcionario").addClass("alertaCombo");
				mostrarMensaje("Los campos son obligatorios...!", "FALLO");
			}else if($("#id_Funcionario option:selected").text()=='Seleccione....'){
				error = true;
				$("#id_Funcionario").addClass("alertaCombo");
				mostrarMensaje("Los campos son obligatorios...!", "FALLO");
			}else{
				agregarDatosCapacitador();
			}
		}else if($.trim($("#id_NombreCapacitador").val())==''){
				error = true;
           		$('#id_NombreCapacitador').addClass("alertaCombo");
           		$('#id_PaisCapacitador').addClass("alertaCombo");
           		$('#id_InstitucionCapacitador').addClass("alertaCombo");
				$("#id_InstitucionCapacitador").val('');
				mostrarMensaje("Los campos son obligatorios...!", "FALLO");
			}else if($.trim($("#id_PaisCapacitador").val())==''){
				$('#id_PaisCapacitador').addClass("alertaCombo");
           		$('#id_InstitucionCapacitador').addClass("alertaCombo");
				   mostrarMensaje("Los campos son obligatorios...!", "FALLO");
			}else if($.trim($("#id_InstitucionCapacitador").val())==''){
				$('#id_InstitucionCapacitador').addClass("alertaCombo");
				mostrarMensaje("Los campos son obligatorios...!", "FALLO");
			}else{
				agregarDatosCapacitador();
			}
	}else{
		$('#id_TipoCapacitador').addClass("alertaCombo");
		mostrarMensaje("Por seleccione un tipo de capacitador.", "FALLO");
	}
	
}

//funcion que lista los capacitadores ingresados
function agregarDatosCapacitador(){

		banderaCapacitador=true;

		$("#tablaCapacitador tbody tr").each(function(){
			var dato = $(this).attr('id');
			var nombreCapacitador = "";
			if($("#id_NombreCapacitador").val() != ""){
				nombreCapacitador = $("#id_NombreCapacitador").val();
			}else{
				nombreCapacitador = $("#id_Funcionario option:selected").text();
			}
			if(nombreCapacitador == dato){
				banderaCapacitador=false;
			}
		});
	
	if(banderaCapacitador){	
		$.post("<?php echo URL ?>RegistroCapacitaciones/CursosImpartidos/agregarDatosCapacitadores", {
			identificadorCapacitador : $("#id_Funcionario option:selected").val(),
			nombreCapacitador : $("#id_NombreCapacitador").val(),
			funcionarioCapacitador : $("#id_Funcionario option:selected").text(),
			institucion : $("#id_InstitucionCapacitador").val(),
			idProvincia : $("#id_ProvinciaCapacitador").val(),
			nombreProvincia : $("#id_ProvinciaCapacitador option:selected").attr('data-nombreprovincia'),
			idPais : $("#id_PaisCapacitador").val(),
			nombrePais : $("#id_PaisCapacitador option:selected").attr('data-nombrepais'),
			tipoCapacitador : $("#id_TipoCapacitador option:selected").val(),
				
		}, function (data) {
				
				if (data.estado === 'EXITO') {
					$("#tablaCapacitador tbody").append(data.contenido);
		    		mostrarMensaje(data.mensaje, data.estado);
					$("#id_Funcionario option:selected").val('');
		    	} else {
		    	    mostrarMensaje(data.mensaje, "FALLO");
		    	}
		    }, 'json');
	}else{
		mostrarMensaje("El funcionario ya se encuentra registrado.", "FALLO");
	}	
}

function eliminarDatosCapacitador(e){
	const index = e.parentNode.parentNode.rowIndex;
	const tabla = document.getElementById('tablaCapacitador');
	const filas = tabla.rows.length;
	tabla.deleteRow(index);
}

//Inicio funcion que activa el combo de tema dado un cuarso de capacitcion
$("#id_curso").change(function () {
	$("#nombre_tema").attr('disabled', 'disabled');
	if ($("#id_curso option:selected").val() !== "") {
		$("#nombreCurso").val($("#idCurso option:selected").text());
		
	
		fn_cargarTemasXCurso();
	}
});

//funcion que carga los temas de un curso
function fn_cargarTemasXCurso() {
	idCurso = $("#id_curso").val();
	$("#nombreCurso").val($("#id_curso option:selected").text());
	if (idCurso !== '') {
		$.post("<?php echo URL ?>RegistroCapacitaciones/CursosImpartidos/cargarTemasCursosXCursoSeleccionado/", 
		{
			idCurso : idCurso
		},
		function (data) {
			$("#nombre_tema").html(combo+data);
			$("#nombre_tema").removeAttr('disabled');
		});
	}else{
		$("#nombre_tema").val('');
		$("#nombre_tema").attr('disabled', 'disabled');
	}
	fn_cargarPublicoObjetivoXCursoCapacitacion(idCurso);
	$("#idPublicoObjetivo").attr('disabled', false);

}

//funcion que activa e inactiva el boton agregar temas especificos
$("#nombre_tema").change(function () {
	if($("#nombre_tema option:selected").text() == '' || $("#nombre_tema option:selected").text() == 'Seleccione....' ){
		$("#btnAgregarTema").attr('disabled', true);
		$("#nombre_tema option:selected").text() == '';
	}else{
		$("#btnAgregarTema").attr('disabled', false);
	}
	
});

function agregarTemasEspecificos(){
	var id_tema = $("#nombre_tema option:selected").val();
	
    event.preventDefault();
	   mostrarMensaje("", "");
	
	$(".alertaCombo").removeClass("alertaCombo");
	var error = false;

	if($("#nombre_tema option:selected").text() == "" || $("#nombre_tema option:selected").text() == "Seleccione...." ){	
			error = true;
			$(this).addClass("alertaCombo");
		}
	if(!error){
		bandera=false;
		$("td").each(function(){
			if($(this).text() == $("#nombre_tema option:selected").text()){
				bandera=true;
			}
		});
		if(bandera==false){
			$.post("<?php echo URL ?>RegistroCapacitaciones/CursosImpartidos/agregarTemaEspecifico", 
					{
						id_tema:$("#nombre_tema option:selected").val(),
						nombre_tema:$("#nombre_tema option:selected").text(),
			 
				   }, function (data) {
			
				if (data.estado === 'EXITO') {
					$("#tablaTemasEspecificos tbody").append(data.contenido);
						mostrarMensaje(data.mensaje, data.estado);
					} else {
						mostrarMensaje(data.mensaje, "FALLO");
					}
			  },  'json');
		}else{
			$("#estado").html("Este tema ya se encuentra agregado.").addClass('alerta');
			$("#btnAgregarTema").attr('disabled', true);
			limpiarCampos();
		}
	}else{
		mostrarMensaje("Seleccione un Tema por favor.", "FALLO");
	}	
	
}

//Eliminar temas especifico agregado
function eliminarTemaEspecifico(e){
	const index = e.parentNode.parentNode.rowIndex;
	const tabla = document.getElementById('tablaTemasEspecificos');
	const filas = tabla.rows.length;
	tabla.deleteRow(index);
}

/********************************************************/
//funcionq ue carga archivo adjunto asistencia
$("#btnAsistencia").click(function (event) {
	if($("#archivoConstancia").val() == 0){
		error=true;
		$('#archivoConstancia').addClass("alertaCombo");	
	}else{
		var boton = $(this);
		var nombre_archivo = "<?php echo 'asistencia_' . (md5(time())); ?>";
		var archivo = boton.parent().find(".archivo");
		var rutaArchivo = boton.parent().find(".rutaArchivo");
		var extension = archivo.val().split('.');
		var estado = boton.parent().find(".estadoCarga");
	  
		if (extension[extension.length - 1].toUpperCase() == 'PDF') {
	  
			subirArchivo(
				archivo
				, nombre_archivo
				, boton.attr("data-rutaCarga")
				, rutaArchivo
				, new carga(estado, archivo, boton)  
		    );
		} else {
			   estado.html('Formato incorrecto, solo se admite archivos en formato PDF');
			   archivo.val("0");        
		}
	}
});


//funcionq ue carga archivo adjunto evidencia
$("#btnEvidencia").click(function(){
	
	if($("#archivoEvidencia").val() == 0){
		error=true;
		$('#archivoEvidencia').addClass("alertaCombo");	
	}else{
		var boton = $(this);
		var nombre_archivo = "<?php echo 'evidencia_' . (md5(time())); ?>";
		var archivo = boton.parent().find(".archivo");
		var rutaArchivo = boton.parent().find(".rutaArchivo");
		var extension = archivo.val().split('.');
		var estado = boton.parent().find(".estadoCarga");
	  
		if (extension[extension.length - 1].toUpperCase() == 'PDF') {
	  
			subirArchivo(
				archivo
				, nombre_archivo
				, boton.attr("data-rutaCarga")
				, rutaArchivo
				, new carga(estado, archivo, boton)
				  
		    );
		} else {
			   estado.html('Formato incorrecto, solo se admite archivos en formato PDF');
			   archivo.val("0");        
		}
	}
});

	//funcion que carga el publico objetivo dado el curso de capacitacion
	function fn_cargarPublicoObjetivoXCursoCapacitacion(idCurso) {
			if (id_coordinacion !== '') {
				$.post("<?php echo URL ?>RegistroCapacitaciones/CursosImpartidos/cargarCatalogoPublicoXCursoCapacitacion/", 
				{
					idCursoCapacitacion : idCurso
				},
				function (data) {
					
					$("#idPublicoObjetivo").html(combo+data);
					$("#idPublicoObjetivo").removeAttr('disabled');
				});
		    }else{
				$("#idPublicoObjetivo").val('');
				$("#idPublicoObjetivo").attr('disabled', 'disabled');
		}	
		
	}

	//funcion que limpia todos los campos de la ventana 
	function limpiarCampos(){
		$("#genero").val('Seleccione....');
		$("#cantidad").val('');	
		$("#id_PaisCapacitador").val('');
		$("#id_ProvinciaCapacitador").val('');
		$("#id_NombreCapacitador").val('');
		$("#id_CoordinacionCapacitador").val('');
		$("#id_InstitucionCapacitador").val('');
		$("#nombre_tema").val('Selecciones....');
		$("#id_NombreCapacitador").val();
		$("#id_PaisCapacitador").val();
		$("#idPublicoFiltro").val('');
		$("#id_Funcionario option:selected").text('Seleccione....');
	}

//Inicio funcion que activa combo de oficina
$("#idParroquia").change(function () {
	
	if($("#idParroquia option:selected").text() =='Iñaquito'){
		$("#id-Oficina").show();
		$("#idOficina").show();
		
	}else{
		$("#id-Oficina").hide();
		$("#idOficina").hide();
		$("#idOficina").val('');
	}

});

</script>
