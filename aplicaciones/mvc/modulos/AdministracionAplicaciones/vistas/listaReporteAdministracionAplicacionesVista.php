<header>
	<nav><?php echo $this->panelBusquedaReporte; ?></nav>
</header>

<script>
	var area =<?php echo json_encode($this->area);?>;
	var tipoUsuario =<?php echo json_encode($this->tipoUsuario);?>;
	
	$(document).ready(function () {
		construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
		$("#listadoItems").removeClass("comunes");
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
	});

	/*$("#btnFiltrar").click(function (event) {
		event.preventDefault();
		fn_filtrar();
	});*/
	
	//Lista de las coordinaciones y direcciones
    $("#unidadFiltro").change(function () {
    
		$("#moduloFiltro").val('');
		$("#perfilFiltro").val('');
		$("#identificadorFiltro").val('');
    	
        if ($("#unidadFiltro option:selected").val() !== "") {        	
        	fn_cargarAplicacionForm();
        }else{
        	$("#moduloFiltro").html(combo);
        	$("#moduloFiltro").attr('disabled', 'disabled');
        	$("#perfilFiltro").html(combo);
			$("#identificadorFiltro").val('');
        }
    });
    
    //Lista de perfiles por aplicación
	function fn_cargarAplicacionForm() {
        var idArea = $("#unidadFiltro option:selected").val();
        
        if (idArea !== '') {
        	$.post("<?php echo URL ?>AdministracionAplicaciones/AdministracionAplicaciones/comboModuloXCoordDir/", 
			{
        		area : idArea,
        		tipoUsuario : tipoUsuario
			},
            function (data) {
                $("#moduloFiltro").html(data);
                $("#moduloFiltro").removeAttr('disabled');
				$("#perfilFiltro").html(combo);
				$("#identificadorFiltro").val('');
            });
        }else{
        	$("#moduloFiltro").html(combo);
        	$("#moduloFiltro").attr('disabled', 'disabled');
        	$("#perfilFiltro").html(combo);
			$("#identificadorFiltro").val('');
        }
    }
	
	//Lista de los módulos
    $("#moduloFiltro").change(function () {
		$("#perfilFiltro").html(combo);
		$("#identificadorFiltro").val('');
    	
        if ($("#moduloFiltro option:selected").val() !== "") {        	
        	fn_cargarPerfilesXAplicacionForm();
        }else{
        	$("#perfilFiltro").html(combo);
        	$("#perfilFiltro").attr('disabled', 'disabled');
        	$("#identificadorFiltro").val('');
        }
    });
    
    //Lista de perfiles por aplicación
	function fn_cargarPerfilesXAplicacionForm() {
        var idAplicacion = $("#moduloFiltro option:selected").val();
        var area = $("#unidadFiltro option:selected").val();
        
        if (idAplicacion !== '') {
        	$.post("<?php echo URL ?>AdministracionAplicaciones/AdministracionAplicaciones/comboPerfilesXAplicacionXTipoUsuario/", 
			{
        		idAplicacion : idAplicacion,
        		area : area,
        		tipoUsuario : tipoUsuario
			},
            function (data) {
                $("#perfilFiltro").html(data);
                $("#perfilFiltro").removeAttr('disabled');
                $("#identificadorFiltro").val('');
            });
        }else{
        	$("#perfilFiltro").html(combo);
        	$("#perfilFiltro").attr('disabled', 'disabled');
        	$("#identificadorFiltro").val('');
        }
    }
    
    

	//Función para realizar la búsqueda de usuarios con aplicación asignada
	/*function fn_filtrar() {
		event.preventDefault();
		fn_limpiar();

		var error = false;

		if($("#unidadFiltro option:selected").val() == ''){			
			$("#unidadFiltro").addClass("alertaCombo");
			error = true;
		}
		
		if($("#moduloFiltro option:selected").val() == ''){			
			$("#moduloFiltro").addClass("alertaCombo");
			error = true;
		}
		
		if($("#perfilFiltro option:selected").val() == ''){			
			$("#perfilFiltro").addClass("alertaCombo");
			error = true;
		}	
        
		if (!error) {<----------------------------------PENDIENTE!!!!!!!!!!!!!!!!!
			$("#paginacion").html("<div id='cargando'>Cargando...</div>");
			  $.post("<?php echo URL ?>AdministracionAplicaciones/AdministracionAplicaciones/exportarReporteAplicacionesAsignadasExcel",
		    	{
				  moduloFiltro: $("#moduloFiltro option:selected").val(),
				  perfilFiltro: $("#perfilFiltro option:selected").val(),
				  identificadorFiltro: $("#identificadorFiltro").val()
		        },
		      	function (data) {
		        	if (data.estado === 'FALLO') {
	                mostrarMensaje(data.mensaje, "FALLO");
	                } else {
	                	construirPaginacion($("#paginacion"), JSON.parse(data.contenido));
	                }
		        }, 'json');
		} else {
			$("#estado").html();
			mostrarMensaje("Por favor revise los campos obligatorios.", "FALLO");
		}		
	}*/

	function fn_limpiar() {
		$(".alertaCombo").removeClass("alertaCombo");
		$('#estado').html('');
	}
	
</script>