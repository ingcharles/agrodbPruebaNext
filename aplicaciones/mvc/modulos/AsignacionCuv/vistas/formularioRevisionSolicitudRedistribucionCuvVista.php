<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>AsignacionCuv' data-opcion='RevisionSolicitudRedistribucionCuv/aprobarSolicitudTecnicoPlantaCentral' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
	<fieldset>
		<legend>Detalle Solicitud</legend>		
		
		<div data-linea="2">
			<label for="txtFecha">Fecha</label>
			<input type="text" id="txtFecha" name="txtFecha"
				value="<?php echo date('Y-m-d', strtotime($this->modeloSolicitudRedistribucionCuv->getFechaCreacion())); ?>"
                placeholder="Fecha Creación"/>
		</div>	

		<div data-linea="3">
			<label for="txtTecnicoProvincia">Técnico de Provincia</label>
			<input type="text" name="txtTecnicoProvincia" id="txtTecnicoProvincia" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getTecnicoProvincia() ?>">
		</div>	

		<div data-linea="7">
			<label for="txtProvinciaSolicitante">Provincia Solicitante</label>
			<input type="text" name="txtProvinciaSolicitante" id="txtProvinciaSolicitante" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getProvinciaDestino() ?>">
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
		<div data-linea="9">
		<label for="prefijo_cuv_numerico">prefijo_cuv_numerico </label>
			<input type="text" id="prefijo_cuv_numerico" name="prefijo_cuv_numerico" value="<?php echo $this->modeloSolicitudRedistribucionCuv->getPrefijoCuvNumerico(); ?>"
			placeholder="Es el numero de tres cifras antes del codigo del CUV" required maxlength="3"/>
		</div>

		<div data-linea="18">

			<input type="hidden" name="id_solicitud_redistribucion_cuv" id="id_solicitud_redistribucion_cuv" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getIdSolicitudRedistribucionCuv() ?>">

			<input type="hidden" name="siglas" id="siglas" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getSiglas() ?>">

			<input type="hidden" name="anio" id="anio" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getAnio() ?>">

			<input type="hidden" name="id_provincia_origen" id="id_provincia_origen" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getIdProvinciaOrigen() ?>">

			<input type="hidden" name="id_provincia_destino" id="id_provincia_destino" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getIdProvinciaDestino() ?>">

			<input type="hidden" name="provincia_destino" id="provincia_destino" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getProvinciaDestino() ?>">

			<input type="hidden" name="tecnico_planta_central" id="tecnico_planta_central" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getTecnicoPlantaCentral() ?>">

			<input type="hidden" name="estado_solicitud" id="estado_solicitud" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getEstadoSolicitud() ?>">

			<input type="hidden" name="estado" id="estado" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getEstado() ?>">

			<input type="hidden" name="tecnico_provincia_identificador" id="tecnico_provincia_identificador" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getTecnicoProvinciaIdentificador() ?>">

			<input type="hidden" name="tecnico_planta_central_identificador" id="tecnico_planta_central_identificador" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getTecnicoPlantaCentralIdentificador() ?>">

			<input type="hidden" name="fecha_creacion" id="fecha_creacion" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getFechaCreacion() ?>">

			<input type="hidden" id="array_cuv" name="array_cuv" value="" readonly="readonly" />

			<input type="hidden" id="codigoCUVfin" name="codigoCUVfin" value="" readonly="readonly" />

			<input type="hidden" id="accion" name="accion" value="">

		</div>
	</fieldset >

	<fieldset>
        <legend>Redistribución en Provincias</legend>
		<div data-linea="9">
            <label for="slct_provincia_origen">Provincia Origen</label>
			<select id="slct_provincia_origen" name="slct_provincia_origen">
                <option value=""> Seleccionar....</option>
                <?php echo $this->comboProvinciasEc($this->modeloSolicitudRedistribucionCuv->getIdProvinciaOrigen());?>
            </select>
        </div>
		<div data-linea="9">
		<label for="slct_provincia_destino">Provincia Destino</label>
			<select id="slct_provincia_destino" name="slct_provincia_destino" required="true">
                <option value=""> Seleccionar....</option>
                <?php echo $this->comboProvinciasEc($this->modeloSolicitudRedistribucionCuv->getIdProvinciaDestino());?>
            </select>
        </div>
		<div data-linea="10">
		<label for="txt_provincia_origen">Cantidad Disponible</label>
			<input type="text" name="cantidadDisponible" id="cantidadDisponible" value ="">
		</div>
		<div data-linea="12">
		<label for="txt_provincia_destino" hidden>Cantidad Disponible</label>
			<input type="text" name="cantidadDisponible_destino" id="cantidadDisponible_destino" value ="" hidden>
		</div>
		<div data-linea="11">
		<label for="txt_cantidad_reasignar">Cantidad a Reasignar</label>
			<input type="text" name="txt_cantidad_reasignar" id="txt_cantidad_reasignar" value ="" inputmode="numeric" pattern="[0-9]*">
		</div>
		<div data-linea="14">
		<label for="observaciones">Observaciones</label>
			<input type="text" name="observaciones" id="observaciones" value ="" required>
		</div>
		<div data-linea="15">
			<button type="button" class="mas" id="agregar">Agregar</button>
		</div>
    </fieldset>
	<fieldset>
        <legend>Tabla</legend>
        <div class="table-responsive" data-linea="17">
            <table id="tabla_agregar" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Provincia Destino</th>
                        <th>Serie Inicio</th>
                        <th>Serie fin</th>
                        <th>Cantidad</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </fieldset>
	<div data-linea="19">
        <div style="text-align:center;width:100%">
            <button type="submit" class="guardar" id="aprobar">Aprobar</button>
            <button type="submit" class="menos" id="rechazar">Rechazar</button>
        </div>
    </div>
</form >
<script type ="text/javascript">
	$(document).ready(function() {
		construirValidador();
		distribuirLineas();

		$("#cantidadDisponible").attr('readonly', true);
		$("#txt_cantidad_reasignar").attr('readonly', true);
		$("#agregar").attr('disabled', true);
		$("#aprobar").attr('disabled', true);
		
		$("#aprobar").click(function() {
			setAccion('aprobar');
		});
		$("#rechazar").click(function() {
			setAccion('rechazar');
		});
		function setAccion(accion) {
			$("#accion").val(accion);
		}
		var elementosDeshabilitar = ['#txtFecha','#txtTecnicoProvincia','#txtProvinciaSolicitante','#cantidad_solicitada','#slct_provincia_destino'];
		elementosDeshabilitar.forEach(function(elemento) {
            $(elemento).on('mousedown', function(event) {
                event.preventDefault();
                this.blur();
                window.focus();
            });
        });
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

	$('#slct_provincia_origen').change(function() {
		$("#estado").html("");
		var idProvincia = $(this).val(); // Obtener el valor seleccionado del select
        obtenerCantidadProvinciaOrigen(idProvincia); // Llamar a la función para obtener la cantidad
	});

	<!-- Código JavaScript relacionado con Boton Filtrar-->
	function obtenerCantidadProvinciaOrigen(idProvincia) {
		var prefijo_cuv_numerico =  $('#prefijo_cuv_numerico').val();

		if (isNaN(prefijo_cuv_numerico) || !/^\d+$/.test(prefijo_cuv_numerico) || prefijo_cuv_numerico === '') {
			$("#estado").html("Por favor ingrese un prefijo en detalle solicitud.").addClass("alerta");
			$("#slct_provincia_origen").attr('disabled', false);
			return;
		}
		var anio =  $('#anio').val();
		// Realizar petición AJAX al servidor para verificar la cantidad de la provincia origen
		var url = "<?php echo URL ?>AsignacionCuv/RevisionSolicitudRedistribucionCuv/cantidadDisponibleProvinciaOrigen";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idProvincia: idProvincia,
            prefijo_cuv_numerico: prefijo_cuv_numerico,
            anio: anio
        },
        dataType: "json",   
        success: function(response) {
			var cantidadDisponible = response.resultado['cantidad_inicial'] - response.resultado['cantidad_asignada'] - response.resultado['cantidad_redistribuida_enviada'];

            if (response['validacion'] == 'Exito') {
				$("#estado").html("");
				mostrarMensaje(response.mensaje, "EXITO");
                $('#cantidadDisponible').val(cantidadDisponible);
				var cantidadReasignar = $('#txt_cantidad_reasignar').val();
				// Preparar parámetros para la búsqueda.
				var parametros = {
					idProvincia: idProvincia,
					prefijo_cuv_numerico: prefijo_cuv_numerico,
					anio: anio
				};
				calcularSeriesProvinciaOrigen(parametros);
                //originalDisponibilidadCantidad = diferencia; // Actualizar el valor original
                /*$('#serieInicio').val(siglas+'-'+anio+'-'+prefijo_cuv_numerico+'-'+serieInicio);
                $('#serieFin').val(siglas+'-'+anio+'-'+prefijo_cuv_numerico+'-'+serieFin);
                $("#aprobar").attr('disabled', true);*/
            } else if(response['validacion'] == 'Fallo') {
				console.log(response['validacion']);
				console.log("entro aqui");
                mostrarMensaje(response.mensaje, "FALLO");
				$('#cantidadDisponible').val('');
                $("#txt_cantidad_reasignar").attr('readonly', true);
            } else if(cantidadDisponible == 0) {
				$("#estado").html("");
				$('#cantidadDisponible').val(cantidadDisponible);
                mostrarMensaje("No hay cantidad disponible en provincia", "FALLO");
                $("#txt_cantidad_reasignar").attr('readonly', true);
            } 
        }
    });
	}
	<!-- FIN -->

	<!-- Código JavaScript relacionado con Boton Filtrar-->
	function calcularSeriesProvinciaOrigen(array) {
		var url = "<?php echo URL ?>AsignacionCuv/RevisionSolicitudRedistribucionCuv/calcularUltimaSerieProvinciaOrigen";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idProvincia: array['idProvincia'],
            prefijo_cuv_numerico: array['prefijo_cuv_numerico'],
            anio: array['anio'],
        },
        dataType: "json",
        success: function(response) {
			if (response['validacion'] == 'Exito') {
				$("#txt_cantidad_reasignar").attr('readonly', false);
				$('#slct_provincia_origen').prop('disabled', true);
				$('#codigoCUVfin').val(response.resultado);
				mostrarMensaje(response.mensaje, "EXITO");
			} else{
				mostrarMensaje(response.mensaje, "FALLO");
			}
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
	});
	}
	<!-- FIN -->

	<!-- Código JavaScript relacionado con la cantidad a reasignar-->
	function isValidNumber(value) {
		return !isNaN(value) && parseInt(value) == parseFloat(value);
	}
	$('#txt_cantidad_reasignar').on('input', function() {
		var cantidadDisponible = parseInt($('#cantidadDisponible').val());
		var cantidadDisponibleOriginal = cantidadDisponible;
		var cantidadReasignar = parseInt($('#txt_cantidad_reasignar').val());
		$("#estado").html("");
		if (isNaN(cantidadReasignar) || !isValidNumber(cantidadReasignar)) {
			mostrarMensaje("No es un número válido.", "FALLO");
		} else if (cantidadReasignar === '') {
			parseInt($('#cantidadDisponible').val(cantidadDisponibleOriginal));
			mostrarMensaje("Ingrese una cantidad a reasignar.", "FALLO");
		} else if (cantidadDisponible < cantidadReasignar) {
			mostrarMensaje("Excede la cantidad disponible.", "FALLO");
		} else {
			$("#agregar").attr('disabled', false);
			mostrarMensaje("La cantidad a reasignar es válida.", "EXITO");
		}
		$("#agregar").attr('disabled', !($("#estado").html() === "La cantidad a reasignar es válida."));
	});
	<!-- FIN -->

	<!-- Código JavaScript relacionado con la tabla -->
	const agregarBtn = document.getElementById('agregar');
	const guardarBtn = document.getElementById('aprobar');
    const tabla = document.getElementById('tabla_agregar');
    const formulario = document.getElementById('formulario');

	// Declarar variable para el contador
	let contador = 1;
    
    // Evento que acciona el agregar una fila a la tabla
    agregarBtn.addEventListener('click', agregarFila);
	    // Función para agregar una fila a la tabla
	function agregarFila() {
        $("#agregar").attr('disabled', true);
		$("#txt_cantidad_reasignar").attr('readonly', true);
		$("#aprobar").attr('disabled', false);

        // Obtener valores del formulario
        const id_solicitud_redistribucion_cuv = formulario.querySelector('#id_solicitud_redistribucion_cuv').value;
        const slct_provincia_origen = formulario.querySelector('#slct_provincia_origen').value;
		const codigoCUVfin = formulario.querySelector('#codigoCUVfin').value;
		const siglas = formulario.querySelector('#siglas').value;
		const anio = formulario.querySelector('#anio').value;
		const prefijo_cuv_numerico = formulario.querySelector('#prefijo_cuv_numerico').value;
		const observaciones = formulario.querySelector('#observaciones').value;

		const txt_cantidad_reasignar = formulario.querySelector('#txt_cantidad_reasignar').value;
		const cantidadDisponible = formulario.querySelector('#cantidadDisponible').value;
		const slct_provincia_origen_text = formulario.querySelector('#slct_provincia_origen');
		const selectedOption = slct_provincia_origen_text.options[slct_provincia_origen_text.selectedIndex];
		const selectedTextProvincia = selectedOption.textContent;
		// Verificar que los campos no estén vacíos
		if (cantidadDisponible === '' || txt_cantidad_reasignar === '' || slct_provincia_origen === '' || observaciones === '') {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
			return;
		}

		<!-- Código JavaScript relacionado con el calculo de cuvs -->
		var numeroCerosParam = "<?php echo $this->numeroCeros; ?>";
		var inicio = parseInt(codigoCUVfin)+1;
		var fin = parseInt(codigoCUVfin)+parseInt(txt_cantidad_reasignar);
		var inicioCuvSerie = inicio.toString().padStart(numeroCerosParam, '0');
		var finCuvSerie = fin.toString().padStart(numeroCerosParam, '0');
		var inicioCuv = siglas+"-"+anio+"-"+prefijo_cuv_numerico+"-"+inicio.toString().padStart(7, '0');
		var finCuv = siglas+"-"+anio+"-"+prefijo_cuv_numerico+"-"+fin.toString().padStart(7, '0');
		<!-- FIN -->

        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td>${contador}</td>
            <td hidden>${id_solicitud_redistribucion_cuv}</td>
            <td hidden>${slct_provincia_origen}</td>
            <td hidden>${txt_cantidad_reasignar}</td>
            <td hidden>${inicioCuvSerie}</td>
            <td hidden>${finCuvSerie}</td>
            <td>${selectedTextProvincia}</td>
            <td>${inicioCuv}</td>
            <td>${finCuv}</td>
            <td>${txt_cantidad_reasignar}</td>
            <td hidden>${observaciones}</td>
            <td hidden>${prefijo_cuv_numerico}</td>
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
			$('#slct_provincia_origen').prop('disabled', false);
			$("#aprobar").attr('disabled', true);
        });
    }
	<!-- FIN -->

	<!-- Código JavaScript relacionado con la tabla -->
	guardarBtn.addEventListener('click', (event) => {
		event.preventDefault();
		// Obtener la tabla de agregados
		const tablaAgregados = $('#tabla_agregar tbody tr');
		// Verificar si la tabla tiene elementos
		if (tablaAgregados.length > 0) {
			// Si la tabla tiene elementos, procesar los datos y enviar el formulario
			// Crear array para almacenar los datos
			const datos = [];
			// Iterar sobre las filas de la tabla
			tablaAgregados.each(function() {
				const id_solicitud_redistribucion_cuv = $(this).find('td:eq(1)').text();
				const idProvincia = $(this).find('td:eq(2)').text();
				const provincia = $(this).find('td:eq(6)').text();
				const inicioCuvSerie = $(this).find('td:eq(4)').text();
				const finCuvSerie = $(this).find('td:eq(5)').text();
				const cantidadReasignar = $(this).find('td:eq(9)').text();
				const observaciones = $(this).find('td:eq(10)').text();
				const prefijo_cuv_numerico = $(this).find('td:eq(11)').text();
				// Crear objeto con los datos de la fila
				const filaDatos = {
					id_solicitud_redistribucion_cuv: id_solicitud_redistribucion_cuv,
					idProvincia: idProvincia,
					provincia: provincia,
					inicioCuvSerie: inicioCuvSerie,
					finCuvSerie: finCuvSerie,
					cantidadReasignar: cantidadReasignar,
					observaciones: observaciones,
					prefijo_cuv_numerico: prefijo_cuv_numerico
				};
				// Agregar objeto al array de datos
				datos.push(filaDatos);
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
	<!-- FIN -->
</script>
