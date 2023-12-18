<header>
	<h1>
		<?php echo $this->accion; ?>
	</h1>
</header>
<div id="cargarMensajeTemporal"></div>

<?php 
    echo $this->datosGenerales; 
    echo $this->historialAsignacionCupo ?? "";
?>

<script type="text/javascript">
	$(document).ready(function() {
		construirValidador();
		distribuirLineas();
	});

	var combo = '<option value="">Seleccione...</option>';

	$("#formulario").submit(function(event) {
		event.preventDefault();
		var error = false;
		$(".alertaCombo").removeClass("alertaCombo");

		$("#formulario .validacion").each(function(i, obj) {
			if (!$.trim($(this).val())) {
				error = true;
				$(this).addClass("alertaCombo");
			}
		});

		if (!error) {
			var respuesta = JSON.parse(ejecutarJson($("#formulario")).responseText);
			
			if (respuesta.estado === 'exito'){
            		
            	$("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Guardando...</div>").fadeIn();
			            
            	setTimeout(function () {
                    abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"),"#listadoItems",true);
                    $("#id").val(respuesta.id);
                    $("#formulario").attr('data-opcion', 'AsignacionCupo/editar');
                    abrir($("#formulario"), event, false);
				}, 1000);
                
            }else {
                $("#estado").html(respuesta.mensaje).addClass("alerta");
            }
			
			
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});

	function fn_limpiar() {
		$(".alertaCombo").removeClass("alertaCombo");
		$("#estado").html("");
	}

	//Función para buscar información del sitio del operador
	function obtenerOperadorSitioAsignarCupo() {
		fn_limpiar();
		$("#id_sitio").html(combo);
		$("#id_area").html(combo);
		$("#codigo_area").val("");
		var nombre_provincia = $("#id_provincia option:selected").text();
		var identificador_operador = $("#identificador_operador").val();
		var nombre_operador = $("#nombre_operador").val();

		if (
			nombre_provincia !== "" &&
			(identificador_operador !== "" || nombre_operador !== "")
		) {
			$.post(
				"<?php echo URL ?>MovilizacionVegetal/AsignacionCupo/buscarOperadorSitioAsignarCupo", {
					provincia: nombre_provincia,
					identificador_operador: identificador_operador,
					nombre_operador: nombre_operador,
				},
				function(data) {
					$("#id_sitio").html(data);
				}
			);
		} else {
			if (!$.trim($("#id_provincia").val())) {
				$("#id_provincia").addClass("alertaCombo");
			}

			if (!$.trim($("#identificador_operador").val())) {
				if (!$.trim($("#nombre_operador").val())) {
					$("#identificador_operador").addClass("alertaCombo");
					$("#nombre_operador").addClass("alertaCombo");
				}
			}

			if (!$.trim($("#nombre_operador").val())) {
				if (!$.trim($("#identificador_operador").val())) {
					$("#identificador_operador").addClass("alertaCombo");
					$("#nombre_operador").addClass("alertaCombo");
				}
			}

			$("#estado")
				.html("Por favor ingrese la información requerida para continuar")
				.addClass("alerta");
		}
	}

	//Función para buscar información del area del sitio del operador
	$("#id_sitio").change(function() {
		fn_limpiar();
		$("#id_area").html(combo);
		$("#nombre_operador").val($("#id_sitio option:selected").attr("data-nombre"));
		var id_provincia = $("#id_provincia option:selected").val();
		var identificador_operador = $("#identificador_operador").val();
		var nombre_operador = $("#nombre_operador").val();
		var id_sitio = $("#id_sitio option:selected").val();

		if (id_sitio !== "") {
			$.post(
				"<?php echo URL ?>MovilizacionVegetal/AsignacionCupo/buscarAreasOperadorAsignarCupo", {
					id_sitio: id_sitio,
					identificador_operador: identificador_operador,
				},
				function(data) {
					$("#id_area").html(data);
				}
			);
		} else {
			$("#nombre_operador").html("");
			$("#estado")
				.html("Por favor ingrese la información requerida para continuar")
				.addClass("alerta");
		}
	});

	//Función para buscar información del producto
	$("#id_area").change(function() {
		var id_area = $("#id_area option:selected").val();
		if (id_area !== "") {
			$("#codigo_area").val(
				$("#id_area option:selected").attr("data-codigo_area")
			);
			$.post(
				"<?php echo URL ?>MovilizacionVegetal/AsignacionCupo/buscarProductoAreasOperadoresAsignarCupo", {
					id_area: id_area,
				},
				function(data) {
					$("#id_producto").html(data);
				}
			);
		} else {
			$("#codigo_area").val("");
			$("#estado")
				.html("Por favor ingrese la información requerida para continuar")
				.addClass("alerta");
		}
	});
	
	//Función para formatear cantidades
    function formatearCantidadProducto(inputElement) {
        var valor = inputElement.value.replace(/[^\d.]/g, ''); // Elimina caracteres no numéricos ni puntos
        var partes = valor.split('.');
        
        if (partes.length > 1) {
            partes[0] = partes[0].substring(0, 7); // Limita a enterosMaximos enteros
            partes[1] = partes[1].substring(0, 2); // Limita a decimalesMaximos decimales
            valor = partes.join('.');
        } else if (partes[0].length > 7) {
            valor = partes[0].substring(0, 7); // Limita a enterosMaximos enteros si no hay parte decimal
        }
        
        inputElement.value = valor;
	}
</script>