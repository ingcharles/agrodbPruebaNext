<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='formularioEditar' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>RegistroCapacitaciones' data-opcion='CursosCapacitaciones/guardar' data-destino='detalleItem' data-accionEnExito='ACTUALIZAR'>

<?php echo $this->contenidoCapacitacion;?>
<?php echo $this->contenidoTemaCurso;?>
<?php echo $this->contenidoPublicoMeta;?>

<div data-linea="4">
<button type="submit" class="guardar">Guardar</button>
</div>


	
</form >
<script type ="text/javascript">

	$(document).ready(function() {
		construirValidador();
		distribuirLineas();
		mostrarMensaje("", "");
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

	$("#formularioEditar").submit(function (event) {
		 event.preventDefault();
		 var error = false;
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
				JSON.parse(ejecutarJson($("#formularioEditar")).responseText);
			}, 1000);
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});

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
	
	let palabraNueva = (sinTilde($("#nombre_tema").val())).replace(/ /g,'');
	
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

				let palabraObtenida = (sinTilde($(this).text())).replace(/ /g,'');
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
		mostrarMensaje("El registro ha sido Eliminado.", "EXITO");
	
}

//funcion que eliminar el registro de la tebla tema especifico
function eliminarRegistroTemaCurso(idTemaCurso,idCurso){
	var rows = document.getElementById('tablaTemaCurso').rows.length;
	if(rows>2){
		$.post("<?php echo URL ?>RegistroCapacitaciones/TemasCursos/borrar",
            {                
                elementos: idTemaCurso,
				idCurso : idCurso,
            },function (data) {
            	
				if(data==='EXITO'){
					$("#" + idTemaCurso).remove();
					mostrarMensaje("El registro ha sido Eliminado.", "EXITO");
				}else if(data==='Empty'){
					$("#estado").html();
					mostrarMensaje("Debe guardar antes un registro para poder eliminar.", "FALLO");
				}else if(data==='Fallo'){
					$("#estado").html();
					mostrarMensaje("Este tema ya se encuentra presente en un curso impartido..", "FALLO");
				}
            });
		
	}else{
		$("#estado").html();
		mostrarMensaje("Debe existir al menos un tema especifíco registrado por curso de capacitación.", "FALLO");
	}	
	
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
	mostrarMensaje("El registro ha sido Eliminado.", "EXITO");
	
}

//funcion que eliminar el registro de la tebla tema especifico
function eliminarRegistroPublicoObjetivo(idPublicoObjetivo,idCurso){
	//alert(idPublicoObjetivo);
	
	var rows = document.getElementById('tablaPublico').rows.length;
	if(rows>2){
		$.post("<?php echo URL ?>RegistroCapacitaciones/PublicoObjetivo/borrar",
            {                
                elementos: idPublicoObjetivo,
				idCurso : idCurso,
            },function (data) {
            	
				if(data==='EXITO'){
					$("#" + idPublicoObjetivo).remove();
					mostrarMensaje("El registro ha sido Eliminado.", "EXITO");
				}else if(data==='Empty'){
					$("#estado").html();
					mostrarMensaje("Debe guardar antes un registro para poder eliminar.", "FALLO");
				}else if(data==='Fallo'){
					$("#estado").html();
					mostrarMensaje("Este público ya se encuentra presente en un curso impartido..", "FALLO");
				}
            });
		
	}else{
		$("#estado").html();
		mostrarMensaje("Debe existir al menos un público registrado por curso de capacitación.", "FALLO");
	}		
}


</script>


