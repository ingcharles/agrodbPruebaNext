<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='formularioNuevo' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>RegistroCapacitaciones' data-opcion='CursosCapacitaciones/guardar' data-destino='detalleItem' data-accionEnExito='ACTUALIZAR'>

<?php echo $this->contenidoCapacitacion;?>
<?php echo $this->contenidoTemaCurso;?>
<?php echo $this->contenidoPublicoMeta;?>

<div data-linea="4">
<button type="submit" class="guardar">Guardar</button>
</div>
	
</form >
<div id="cargarMensajeTemporal"></div>
<script type ="text/javascript">
	$(document).ready(function() {
		construirValidador();
		distribuirLineas();
		$("#agregarTemaEspecifico").attr('disabled', true);
		$("#agregarPublicoMeta").attr('disabled', true);
		$("#nombre_tema").click(function (e) {
			$("#nombre_tema").keypress(function (e) {
				if((($("#nombre_tema").val()).replace(/ /g,''))!=''){
					$("#agregarTemaEspecifico").attr('disabled', false);
				}
			}); 
    	});
		$("#nombre_tema").keyup(function(e){
			if(e.keyCode == 8){
				if($("#nombre_tema").val()=='' || (($("#nombre_tema").val()).replace(/ /g,''))==''){
						$("#agregarTemaEspecifico").attr('disabled', true);
					}
			}
		}) ;
		
	});

	$("#formularioNuevo").submit(function (event) {
		$("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Cargando...</div>").fadeIn();
		 event.preventDefault();
		 var error = false;
		 $(".alertaCombo").removeClass("alertaCombo");
	
		if($("#nombre_curso").val() == '' || (($("#nombre_curso").val()).replace(/ /g,''))==''){
		error=true;
		$('#nombre_curso').addClass("alertaCombo");
		}else{
			$('#nombre_curso').val(($('#nombre_curso').val()).toUpperCase());
		}

		if($("#objetivo").val() == '' || (($("#objetivo").val()).replace(/ /g,''))==''){
			error=true;
			$('#objetivo').addClass("alertaCombo");
		}

		if($("#normativa").val() == '' || (($("#normativa").val()).replace(/ /g,''))==''){
			error=true;
			$('#normativa').addClass("alertaCombo");
		}

		if($("#id_coordinacionSelect").text() == '' || $("#id_coordinacionSelect").val() == '' ){
			error=true;
			$('#id_coordinacionSelect').addClass("alertaCombo");
		}
		
		if( $("#id_direccionSelect").val() == 'Seleccione....' ){
			error=true;
			$('#id_direccionSelect').addClass("alertaCombo");	
		}

		var rows = document.getElementById('tablaTemaCurso').rows.length;
		if(rows==1){
			error=true;
			$('#tablaTemaCurso').addClass("alertaCombo");
		}
		var rows = document.getElementById('tablaPublico').rows.length;
		if(rows==1){
			error=true;
			$('#tablaPublico').addClass("alertaCombo");
		}
		if (!error) {
			setTimeout(function(){
				JSON.parse(ejecutarJson($("#formularioNuevo")).responseText);
			}, 1000);
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});

//Inicio funcion que activa el combo direcciones
var combo = "<option>Seleccione....</option>";
$("#id_coordinacionSelect").change(function () {
	
	$("#id_direccionSelect").val('');
	$("#id_direccionSelect").attr('disabled', false);
	if ($("#id_coordinacionSelect").val() != "") {
		fn_cargarDireccionXCoordinacion();
	}
	
});

//fncion que carga las direcciones dado un id de coordinacion
function fn_cargarDireccionXCoordinacion() {
	
	var id_coordinacion = $("#id_coordinacionSelect option:selected").val();
	if (id_coordinacion !== '') {
		$.post("<?php echo URL ?>RegistroCapacitaciones/Base/comboDireccionesXCoordinaciones/", 
		{
			id_coordinacion : id_coordinacion
		},
		function (data) {
			
			$("#id_direccionSelect").html(combo+data);
			$("#id_direccionSelect").removeAttr('disabled');			
		});
	}else{
		$("#id_direccionSelect").val('');
		$("#id_direccionSelect").attr('disabled', 'disabled');
	}
}



let sinTilde = (function(){
    let de = 'ÁÃÀÄÂÉËÈÊÍÏÌÎÓÖÒÔÚÜÙÛÑÇáãàäâéëèêíïìîóöòôúüùûñç',
         a = 'AAAAAEEEEIIIIOOOOUUUUNCaaaaaeeeeiiiioooouuuunc',
        re = new RegExp('['+de+']' , 'ug');

    return texto =>
        texto.replace(
            re, 
            match => a.charAt(de.indexOf(match))
        );
})();

//funcion que agrega temas a un curso de capacitacion
function agregarTemaCurso(){
	
	let palabraNueva = ((sinTilde($("#nombre_tema").val())).replace(/ /g,'')).toLowerCase();
	
	event.preventDefault();
       	mostrarMensaje("", "");
    	
    	$(".alertaCombo").removeClass("alertaCombo");
    	var error = false;

		if($.trim($("#nombre_tema").val()) == "" ){	
				error = true;
				$(this).addClass("alertaCombo");
				$("#nombre_tema").addClass("alertaCombo");
			}
        if(!error){
			bandera=false;
			$("td").each(function(){

				let palabraObtenida = ((sinTilde($(this).text())).replace(/ /g,'')).toLowerCase();
				if(palabraObtenida === palabraNueva  ){
					bandera=true;
				}
			});
			if(bandera==false){
				$.post("<?php echo URL ?>RegistroCapacitaciones/CursosCapacitaciones/agregarTema", 
		    {
	        	nombre_tema:$("#nombre_tema").val(),
		    }, function (data) {
				
				if (data.estado === 'EXITO') {
					$("#tablaTemaCurso tbody").append(data.contenido);
		    		mostrarMensaje(data.mensaje, data.estado);
					$("#nombre_tema").val('');
					$("#agregarTemaEspecifico").attr('disabled', true);

		    	} else {
		    	    mostrarMensaje(data.mensaje, "FALLO");
		    	}
		    }, 'json');
			}else{
				$("#estado").html("Este tema ya se encuentra agregado.").addClass('alerta');
			}
		}else{
			mostrarMensaje("Por favor Ingrese un tema para registrar.", "FALLO");
		}	
}


function eliminarTemaCurso(e){
	const index = e.parentNode.parentNode.rowIndex;
	const tabla = document.getElementById('tablaTemaCurso');
	const filas = tabla.rows.length;
	tabla.deleteRow(index);
}

//funcion que eliminar el registro de la tebla tema especifico
function eliminarRegistroTemaCurso(idTemaCurso){
	
            $.post("<?php echo URL ?>RegistroCapacitaciones/TemasCursos/borrar",
            {                
                elementos: idTemaCurso,
               
            },function (data) {
            	$("#" + idTemaCurso).remove();
            });
				
}

//activar/desactivar boton agregar
$("#idPublico").change(function () {
	if($("#idPublico").val()!=''){
		$("#agregarPublicoMeta").attr('disabled', false);
	}else{
		$("#agregarPublicoMeta").attr('disabled', true);
	}
});

//funcion que agrega publico objetivo a un curso
function agregarPublico(){

	event.preventDefault();
       	mostrarMensaje("", "");
    	
    	$(".alertaCombo").removeClass("alertaCombo");
    	var error = false;

		if($('#idPublico').val() == "" ){		
				error = true;
				$(this).addClass("alertaCombo");
				$('#idPublico').addClass("alertaCombo");
			}
        if(!error){
			bandera=false;
			$("td").each(function(){
				if($(this).text()==$("#idPublico option:selected").text()){
					bandera=true;
				}
			});
			if(bandera==false){
				$.post("<?php echo URL ?>RegistroCapacitaciones/CursosCapacitaciones/agregarPublico", 
		  	  		{
						id_publico : $('#idPublico').val(),
						nombre_publico : $('#idPublico option:selected').text(),
			 
	         	
		  	 		}, function (data) {
				
					if (data.estado === 'EXITO') {
						$("#tablaPublico tbody").append(data.contenido);
		  	  			mostrarMensaje(data.mensaje, data.estado);
						$("#idPublico").val('');
						$("#agregarPublicoMeta").attr('disabled', true);
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

//funcion que elimina el registro de la tebla publico Objetivo
function eliminarRegistroPublicoObjetivo(idPublicoObjetivo){
	
	$.post("<?php echo URL ?>RegistroCapacitaciones/PublicoObjetivo/borrar",
	{                
		elementos: idPublicoObjetivo,
	   
	},function (data) {
		$("#" + idPublicoObjetivo).remove();
	});
		
}

</script>


