<header>
	<nav><?php echo $this->panelBusqueda; ?></nav>
	<nav><?php echo $this->crearAccionBotones();?></nav>
</header>

<div id="paginacion" class="normal"></div>

<table id="tablaItems">
	<thead>
		<tr>
			<th>#</th>
			<th>Identificador</th>
			<th>Usuario</th>
			<th>Aplicación</th>
			<th>Perfil</th>
		</tr>
	</thead>
	<tbody></tbody>
</table>

<script>
	var area =<?php echo json_encode($this->area);?>;
	var tipoUsuario =<?php echo json_encode($this->tipoUsuario);?>;
	
	$(document).ready(function () {
		construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
		$("#listadoItems").removeClass("comunes");
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
	});

	$("#moduloFiltro").change(function () {
		$("#perfilFiltro").val('');
    	$("#perfilFiltro").attr('disabled', 'disabled');
    	$("#identificadorFiltro").val('');
    	
        if ($("#moduloFiltro option:selected").val() !== "") {
        	
        	fn_cargarPerfilesXAplicacion();
        }
    });

	$("#btnFiltrar").click(function (event) {
		event.preventDefault();
		fn_filtrar();
	});

	//Lista de perfiles por aplicación
	function fn_cargarPerfilesXAplicacion() {
        var idAplicacion = $("#moduloFiltro option:selected").val();
        
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
            });
        }else{
        	$("#perfilFiltro").val('');
        	$("#perfilFiltro").attr('disabled', 'disabled');
        }
    }

	//Función para realizar la búsqueda de usuarios con aplicación asignada
	function fn_filtrar() {
		event.preventDefault();
		fn_limpiar();

		var error = false;

		if($("#moduloFiltro option:selected").val() == ''){			
			$("#moduloFiltro").addClass("alertaCombo");
			error = true;
		}
		
		if($("#perfilFiltro option:selected").val() == ''){			
			$("#perfilFiltro").addClass("alertaCombo");
			error = true;
		}	
        
		if (!error) {
			$("#paginacion").html("<div id='cargando'>Cargando...</div>");
			  $.post("<?php echo URL ?>AdministracionAplicaciones/AdministracionAplicaciones/listarUsuariosXAplicacionFiltradas",
		    	{
				  moduloFiltro: $("#moduloFiltro option:selected").val(),
				  perfilFiltro: $("#perfilFiltro option:selected").val(),
				  identificadorFiltro: $("#identificadorFiltro").val(),
				  area : area,
        	      tipoUsuario : tipoUsuario
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
	}

	function fn_limpiar() {
		$(".alertaCombo").removeClass("alertaCombo");
		$('#estado').html('');
	}
	
</script>