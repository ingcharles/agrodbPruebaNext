<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>AsignacionCuv' data-opcion='SolicitudRedistribucionCuv/guardar' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
	<fieldset>
		<legend>Solicitud de Redistribución</legend>				

		<div data-linea="3">
			<label for="anio">año</label>
			<select id="anio" name="anio" required="true">
                <?php echo $this->comboAnios($this->modeloSolicitudRedistribucionCuv->getAnio());?>
            </select>
		</div>				

		<div data-linea="6">
			<input type="hidden" id="provincia_origen" name="provincia_origen" value="<?php echo $this->modeloSolicitudRedistribucionCuv->getProvinciaOrigen(); ?>"
			placeholder="Nombre de la provincia origen de la tabla g_catalogos.localizacion(Destino) que va a dar sus CUV" required maxlength="8" />
		</div>

		<div data-linea="8">
            <label for="cantidad_solicitada">cantidad_solicitada </label>
            <input type="text" id="cantidad_solicitada" name="cantidad_solicitada"
                value="<?php echo $this->modeloSolicitudRedistribucionCuv->getCantidadSolicitada(); ?>"
                placeholder="Cantidad solicitada para redistribuir" required maxlength="8" />
        </div>

		<div data-linea="18">

			<input type="hidden" name="id_solicitud_redistribucion_cuv" id="id_solicitud_redistribucion_cuv" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getIdSolicitudRedistribucionCuv() ?>">

			<input type="hidden" name="siglas" id="siglas" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getSiglas() ?>">

			<input type="hidden" name="id_provincia_origen" id="id_provincia_origen" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getIdProvinciaOrigen() ?>">

			<input type="hidden" name="id_provincia_destino" id="id_provincia_destino" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getIdProvinciaDestino() ?>">

			<input type="hidden" name="provincia_destino" id="provincia_destino" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getProvinciaDestino() ?>">

			<input type="hidden" name="tecnico_provincia" id="tecnico_provincia" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getTecnicoProvincia() ?>">

			<input type="hidden" name="tecnico_planta_central" id="tecnico_planta_central" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getTecnicoPlantaCentral() ?>">

			<input type="hidden" name="estado_solicitud" id="estado_solicitud" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getEstadoSolicitud() ?>">

			<input type="hidden" name="estado" id="estado" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getEstado() ?>">

			<input type="hidden" name="observaciones" id="observaciones" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getObservaciones() ?>">

			<input type="hidden" name="tecnico_provincia_identificador" id="tecnico_provincia_identificador" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getTecnicoProvinciaIdentificador() ?>">

			<input type="hidden" name="tecnico_planta_central_identificador" id="tecnico_planta_central_identificador" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getTecnicoPlantaCentralIdentificador() ?>">

			<input type="hidden" name="fecha_creacion" id="fecha_creacion" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getFechaCreacion() ?>">

			<input type="hidden" id="array_cuv" name="array_cuv" value="" readonly="readonly" />

			<div data-linea="15">
				<button type="button" class="mas" id="agregar">Agregar</button>
			</div>
		</div>
	</fieldset >

	<fieldset>
        <legend>Tabla</legend>
        <div class="table-responsive" data-linea="17">
            <table id="tabla_agregar" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Solicitante</th>
                        <th>Provincia</th>
                        <th>Cantidad</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div data-linea="40" style="text-align:center;width:100%">
            <button id="guardar" type="submit" class="guardar">Enviar Solicitud</button>
        </div>
    </fieldset>

</form >
<form id='certificado' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>AsignacionCuv' 
    data-opcion='SolicitudRedistribucionCuv/generarActaEntrega' data-destino="detalleItem" method="post">
    <input type="hidden" id="id" name="id" />
        <?php
        echo $this->datosResultadoRedistribucion;
        ?>
    </form>
<script type ="text/javascript">
	$(document).ready(function() {
		construirValidador();
		distribuirLineas();
		const estado_param = "<?php echo $this->estadoSolicitudTemp; ?>";

		var elementosDeshabilitar = ['#anio', '#cantidad_solicitada'];
		if (estado_param == 'Desactivar') {
			elementosDeshabilitar.forEach(function(elemento) {
				$(elemento).on('mousedown', function(event) {
					event.preventDefault();
					this.blur();
					window.focus();
				});
			});
			$("#agregar, #guardar").attr('disabled', true);
		} else {
			// Restablecer el comportamiento normal de los elementos
			elementosDeshabilitar.forEach(function(elemento) {
				$(elemento).off('mousedown');
			});
			$("#guardar, #agregar").attr('disabled', false);
		}
	});

	$("#formulario").submit(function (event) {
		event.preventDefault();
		var error = false;
		if (!error) {
			abrir($(this), event, false);
			abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"),"#listadoItems",true);
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});

<!-- Código JavaScript relacionado con la tabla -->
/*VARIABLES*/
	const agregarBtn = document.getElementById('agregar');
	const guardarBtn = document.getElementById('guardar');
    const tabla = document.getElementById('tabla_agregar');
    const formulario = document.getElementById('formulario');
    var provinciaSession = "<?php echo $_SESSION['nombreProvincia']; ?>";
    var idProvinciaSession = "<?php echo $_SESSION['idProvincia']; ?>";
    var solicitanteSession = "<?php echo $_SESSION['nombre_usuario']; ?>";
    // Declarar variable para el contador
    let contador = 1;
    
    // Evento que acciona el agregar una fila a la tabla
    agregarBtn.addEventListener('click', agregarFila);

    // Función para agregar una fila a la tabla
    function agregarFila() {
        $("#agregar").attr('disabled', true);
        // Obtener valores del formulario
        const cantidadSolicitada = formulario.querySelector('#cantidad_solicitada').value;
        const anio = formulario.querySelector('#anio').value;
				/*VALIDACIONES*/
		// Verificar que los campos no estén vacíos
		if (cantidadSolicitada === '' || anio === '') {
			$("#agregar").attr('disabled', false);
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
			return;
		}

		// Verificar que cantidad sea un número
		if (isNaN(cantidadSolicitada) || !/^\d+$/.test(cantidadSolicitada)) {
			$("#estado").html("Por favor ingrese una cantidad válida.").addClass("alerta");
			$("#agregar").attr('disabled', false);
			return;
		}
        // Crear fila y agregar celdas
        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td>${contador}</td>
            <td>${solicitanteSession}</td>
            <td hidden>${idProvinciaSession}</td>
            <td>${provinciaSession}</td>
            <td>${cantidadSolicitada}</td>
			<td hidden>${anio}</td>
            <td><button class='menos'>Eliminar</button></td>`;
        // Incrementar el contador
        contador++;
        // Agregar fila a la tabla
        tabla.querySelector('tbody').appendChild(fila);
        // Limpiar valores del formulario
        formulario.reset();
        $("#estado").html("");
        // Agregar controlador de eventos para botón de eliminar
        const btnEliminar = fila.querySelector('.menos');
        btnEliminar.addEventListener('click', () => {
            fila.remove();
            // Reducir el contador
            contador--;
            $("#agregar").attr('disabled', false);
        });
    }
<!-- FIN TABLA -->


<!-- Código JavaScript relacionado con GUARDAR-->
	guardarBtn.addEventListener('click', (event) => {
		event.preventDefault();
		// Obtener la tabla de agregados
		const tablaAgregados = $('#tabla_agregar tbody tr');
		// Verificar si la tabla tiene elementos
		if (tablaAgregados.length > 0) {
			// Crear array para almacenar los datos
			const datos = [];
			// Iterar sobre las filas de la tabla
			tablaAgregados.each(function() {
				const solicitante = $(this).find('td:eq(1)').text();
				const idProvincia = $(this).find('td:eq(2)').text();
				const provincia = $(this).find('td:eq(3)').text();
				const cantidad = $(this).find('td:eq(4)').text();
				const anio = $(this).find('td:eq(5)').text();

				// Obtener el valor de PHP y establecerlo en el campo de formulario usando jQuery
				const fechaCreacion = "<?php echo date_create("now")->format('Y-m-d h:i:s'); ?>";
				// Crear objeto con los datos de la fila
				const filaDatos = {
					solicitante: solicitante,
					idProvincia: idProvincia,
					provincia: provincia,
					cantidad: cantidad,
					fechaCreacion: fechaCreacion,
					anio: anio
				};
				// Agregar objeto al array de datos
				datos.push(filaDatos);
				console.log(datos);
			});
			// Convertir el array de datos a JSON
			const datosJSON = JSON.stringify(datos);
			// Asignar el JSON al campo del formulario
			$("#array_cuv").val(datosJSON);
			// Enviar el formulario
			$('#formulario').submit();
		} else {
			// Si la tabla no tiene elementos, mostrar un mensaje de error
			$("#estado").html("Debe agregar al menos un elemento a la tabla.").addClass("alerta");
			//alert('Debe agregar al menos un elemento a la tabla');
		}
	});
<!-- FIN-->
$("#certificado").submit(function (event) {
		event.preventDefault();
		var error = false;
        if (!error) {
            $("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Cargando...</div>").fadeIn();
            setTimeout(function(){ 
                var respuesta = JSON.parse(ejecutarJson($("#certificado")).responseText);
                if (respuesta.validacion == 'Exito'){
		       		$("#id").val(respuesta.contenido);
		       		$("#certificado").attr('data-opcion', 'SolicitudRedistribucionCuv/mostrarReporte');
					abrir($("#certificado"),event,false);
		        }
            }, 1000);
        } else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
    });
</script>
