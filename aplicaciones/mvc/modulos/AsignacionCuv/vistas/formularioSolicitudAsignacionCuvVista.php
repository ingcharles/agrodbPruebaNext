<header>
    <h1><?php 
    echo $this->accion;
    ?>
    </h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>AsignacionCuv'
    data-opcion='SolicitudAsignacionCuv/guardar' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR"
    method="post">
    <fieldset>
        <legend>Solicitud de CUV (Certificado Único de vacunación)</legend>

        <div data-linea="1">
            <label for="id_solicitud_asignacion_cuv" hidden>id_solicitud_asignacion_cuv </label>
            <input type="hidden" id="id_solicitud_asignacion_cuv" name="id_solicitud_asignacion_cuv"
                value="<?php echo $this->modeloSolicitudAsignacionCuv->getIdSolicitudAsignacionCuv(); ?>"
                placeholder="Llave principal de la tabla" maxlength="8" />
        </div>

        <div data-linea="2">
            <label for="id_provincia">Provincia</label>
            <select id="id_provincia" name="id_provincia" required="true">
                <option value=""> Seleccionar....</option>
                <?php echo $this->comboProvinciasEc($this->modeloSolicitudAsignacionCuv->getIdProvincia());?>
            </select>
        </div>

        <div data-linea="3">
            <label for="provincia" hidden>provincia </label>
            <input type="hidden" id="provincia" name="provincia"
                value="<?php echo $this->modeloSolicitudAsignacionCuv->getProvincia(); ?>"
                placeholder="Nombre de la provincia de la tabla g_catalogos.localizacion(Destino)" maxlength="8" />
        </div>

        <div data-linea="4">
            <label for="siglas" hidden>siglas </label>
            <input type="hidden" id="siglas" name="siglas"
                value="<?php echo $this->modeloSolicitudAsignacionCuv->getSiglas(); ?>"
                placeholder="Siglas del CUV (PPC)" maxlength="8" />
        </div>


        <div data-linea="7">
            <label for="operador_solicitante" hidden>operador_solicitante </label>
            <input type="hidden" id="operador_solicitante" name="operador_solicitante"
                value="<?php echo $this->modeloSolicitudAsignacionCuv->getOperadorSolicitante(); ?>"
                placeholder="Operadores que solicitan cuv para su provincia" maxlength="13" />
        </div>

        <div data-linea="8">
            <label for="cantidad_solicitada">cantidad_solicitada </label>
            <input type="text" id="cantidad_solicitada" name="cantidad_solicitada"
                value="<?php echo $this->modeloSolicitudAsignacionCuv->getCantidadSolicitada(); ?>"
                placeholder="Cantidad solicitada para redistribuir" required maxlength="8" />
        </div>

        <div data-linea="9">
            <label for="tecnico_aprobo" hidden>tecnico_aprobo </label>
            <input type="hidden" id="tecnico_aprobo" name="tecnico_aprobo"
                value="<?php echo $this->modeloSolicitudAsignacionCuv->getTecnicoAprobo(); ?>"
                placeholder="Técnico encargado de la aprobación revisa la solicitud y verifica la disponibilidad de números CUV en la tabla distribucion_inicial_cuv"
                maxlength="8" />
        </div>

        <div data-linea="10">
            <label for="estado_solicitud_cuv" hidden>estado_solicitud </label>
            <input type="hidden" id="estado_solicitud_cuv" name="estado_solicitud_cuv"
                value="<?php echo $this->modeloSolicitudAsignacionCuv->getEstadoSolicitud(); ?>"
                placeholder="Estado de la las solicitudes aprobado, rechazado" maxlength="8" />
        </div>

        <div data-linea="11">
            <label for="estado" hidden>estado </label>
            <input type="hidden" id="estado" name="estado"
                value="<?php echo $this->modeloSolicitudAsignacionCuv->getEstado(); ?>" placeholder="Estado de la tabla"
                maxlength="8" />
        </div>

        <div data-linea="12">
            <label for="observaciones" hidden>observaciones </label>
            <input type="hidden" id="observaciones" name="observaciones"
                value="<?php echo $this->modeloSolicitudAsignacionCuv->getObservaciones(); ?>"
                placeholder="Observaciones de la solicitud" maxlength="8" />
        </div>

        <div data-linea="13">
            <label for="fecha_creacion" hidden>fecha_creacion </label>
            <input type="hidden" id="fecha_creacion" name="fecha_creacion" value="<?php echo date_create("now")->format('Y-m-d h:m:s'); ?>"
                placeholder="Fecha de creación del registro" maxlength="8" />
        </div>

		<input type="hidden" id="array_cuv" name="array_cuv" value="" readonly="readonly" />

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
                        <th>Fecha</th>
                        <th>Provincia</th>
                        <th>Cantidad</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div data-linea="40">
            <button id="guardar" type="submit" class="guardar">Guardar</button>
        </div>
    </fieldset>
</form>
    <h1>
    <form id='certificado' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>AsignacionCuv' 
    data-opcion='SolicitudAsignacionCuv/generarActaEntrega' data-destino="detalleItem" method="post">
    <input type="hidden" id="id" name="id" />
        <?php
        echo $this->datosResultado;
        ?>
    </form>
    </h1>
<script type="text/javascript">
$(document).ready(function() {
    construirValidador();
    distribuirLineas();
	$('#id_provincia').on('change', function() {
        var provincia = $('#id_provincia').val();
        buscarProvincia(provincia);
    });
});

$("#formulario").submit(function(event) {
    event.preventDefault();
    var error = false;
    if (!error) {
        abrir($(this), event, false);
        abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"), "#listadoItems", true);
    } else {
        $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
    }
});
// VARIABLES
const formulario = document.getElementById('formulario');
const tabla = document.getElementById('tabla_agregar');
const agregarBtn = document.getElementById('agregar');
const guardarBtn = document.getElementById('guardar');

var valorHidden = $('#estado_solicitud_cuv').val();
deshabilitarSegunEstado(valorHidden);

var id_solicitud_asignacion_cuv = $('#id_solicitud_asignacion_cuv').val();

let nombreProvincia = null;
// Declarar variable para el contador
let contador = 1;
// Evento que acciona el agregar una fila a la tabla
agregarBtn.addEventListener('click', agregarFila);
// Función para agregar una fila a la tabla
function agregarFila() {
	// Obtener valores del formulario
    const provincia = formulario.querySelector('#id_provincia').value;
    const fecha_creacion = formulario.querySelector('#fecha_creacion').value;
    const cantidad = formulario.querySelector('#cantidad_solicitada').value;
    //const anio = formulario.querySelector('#anio').value;
    //const prefijo_cuv_numerico = formulario.querySelector('#prefijo_cuv_numerico').value;
	const id_provincia = formulario.querySelector('#id_provincia').value;

    // Verificar que los campos no estén vacíos
    if (provincia === '' || cantidad === '') {
    $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
    return;
    }

	// Crear fila y agregar celdas
	const fila = document.createElement('tr');
	fila.innerHTML = `
	<td>${contador}</td>
    <td>${fecha_creacion}</td>
    <td>${nombreProvincia}</td>
    <td>${cantidad}</td>
    <td hidden>${id_provincia}</td>
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
    });
}
function buscarProvincia(id) {
    var id_provincia = id;
    var url = "<?php echo URL ?>AsignacionCuv/DistribucionInicialCuv/obtenerProvincia";
    //Obtener Provincia para presentar en la tabla
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idProvincia: id_provincia
        },
        dataType: "json",
        success: function(response) {
            console.log(response.resultado['nombreProvincia']);
            nombreProvincia = response.resultado['nombreProvincia'];
        }
    });
}
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
            const fecha = $(this).find('td:eq(1)').text();
            const provincia = $(this).find('td:eq(2)').text();
            const cantidad = $(this).find('td:eq(3)').text();
            const id_provincia = $(this).find('td:eq(4)').text();

            // Crear objeto con los datos de la fila
            const filaDatos = {
                fecha: fecha,
                provincia: provincia,
                cantidad: cantidad,
                id_provincia: id_provincia
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

//////////////////////////
function deshabilitarSegunEstado(estado_solicitud_cuv_param) {
    console.log(estado_solicitud_cuv_param);
    var elementosDeshabilitar = ['#id_provincia', '#cantidad_solicitada'];
    if (estado_solicitud_cuv_param == 'Aprobada' || estado_solicitud_cuv_param == 'Rechazada') {
        elementosDeshabilitar.forEach(function(elemento) {
            $(elemento).on('mousedown', function(event) {
                event.preventDefault();
                this.blur();
                window.focus();
            });
        });
        $("#guardar, #agregar").attr('disabled', true);
    } else {
        // Restablecer el comportamiento normal de los elementos
        elementosDeshabilitar.forEach(function(elemento) {
            $(elemento).off('mousedown');
        });
        $("#guardar, #agregar").attr('disabled', false);
    }
}

function actaEntregaRecepcion(idSolicitud) {
    console.log(idSolicitud);
    var id_solicitud = idSolicitud;
    var url = "<?php echo URL ?>AsignacionCuv/SolicitudAsignacionCuv/generarActaEntrega";
    
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idSolicitud: id_solicitud
        },
        dataType: "json",
        success: function(response) {
            //console.log(response['contenido']);
            //mostrarPDF(response['contenido']);
            $("#cargarMensajeTemporal").html("");
            setTimeout(function(){
                //var respuesta = JSON.parse(ejecutarJson($("#certificado")).responseText);
                if (response.validacion == 'Exito'){
                    $("#archivo_cargado").attr("href", response.contenido);
                }
			}, 1000);
        }
    });
}
function mostrarPDF(urlpdf) {
    var url_pdf = urlpdf;
    var url = "<?php echo URL ?>AsignacionCuv/SolicitudAsignacionCuv/mostrarReporte";
    
    $.ajax({
        type: "POST",
        url: url,
        data: {
            url_pdf: url_pdf
        },
        dataType: "html",
        success: function(response) {
            console.log("mostrarPDF");
            $("#cargarMensajeTemporal").html("");
        }
    });
}
$('#generar-reporte').click(function(e) {
    e.preventDefault();
    actaEntregaRecepcion(id_solicitud_asignacion_cuv);
    $("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Cargando...</div>").fadeIn();
});
$("#certificado").submit(function (event) {
		event.preventDefault();
		var error = false;
        if (!error) {
            $("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Cargando...</div>").fadeIn();
            setTimeout(function(){ 
                var respuesta = JSON.parse(ejecutarJson($("#certificado")).responseText);
                if (respuesta.validacion == 'Exito'){
		       		$("#id").val(respuesta.contenido);
		       		$("#certificado").attr('data-opcion', 'SolicitudAsignacionCuv/mostrarReporte');
					abrir($("#certificado"),event,false);
		        }
            }, 1000);
        } else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
    });
</script>