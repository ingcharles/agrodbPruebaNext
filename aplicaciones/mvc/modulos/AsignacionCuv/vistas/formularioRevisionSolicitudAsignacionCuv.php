<header>
	<h1><?php echo $this->accion; ?></h1>
</header>

<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>AsignacionCuv'
    data-opcion='SolicitudAsignacionCuv/aprobarSolicitud' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR"
    method="post">
    <fieldset>
        <legend>Detalle Solicitud</legend>
        <div div data-linea="1">
            <label for="fechaSolicitud">Fecha:</label>
            <input id="fechaSolicitud" name="fechaSolicitud" 
            value="<?php echo date('Y-m-d', strtotime($this->modeloSolicitudAsignacionCuv->getFechaCreacion())); ?>" 
            placeholder="Llave principal de la tabla" />
        </div>
        <div div data-linea="2">
            <label for="operadorSolicitante">Solicitante:</label>
            <input id="operadorSolicitante" name="operadorSolicitante" 
            value="<?php echo $this->modeloSolicitudAsignacionCuv->getOperadorSolicitante(); ?>" 
            placeholder="Llave principal de la tabla" />
        </div>
        <div data-linea="3">
            <label for="id_provincia">Provincia</label>
            <select id="id_provincia" name="id_provincia" required="true">
                <option value=""> Seleccionar....</option>
                <?php echo $this->comboProvinciasEc($this->modeloSolicitudAsignacionCuv->getIdProvincia());?>
            </select>
        </div>
        <div div data-linea="4">
            <label for="cantidadSolicitada">Cantidad Solicitada:</label>
            <input id="cantidadSolicitada" name="cantidadSolicitada" 
            value="<?php echo $this->modeloSolicitudAsignacionCuv->getCantidadSolicitada(); ?>" 
            placeholder="Llave principal de la tabla" />
        </div>
        <div data-linea="6">
            <label for="prefijoCuvNumerico">prefijo_cuv_numerico </label>
            <input type="text" id="prefijoCuvNumerico" name="prefijoCuvNumerico"
                value="<?php echo $this->modeloSolicitudAsignacionCuv->getPrefijoCuvNumerico(); ?>"
                placeholder="Es el numero de tres cifras antes del codigo del CUV" required maxlength="8" />
        </div>
        <div div data-linea="20">
            <input type="hidden" id="provincia_nombre" name="provincia_nombre" 
            value="<?php echo $this->modeloSolicitudAsignacionCuv->getProvincia(); ?>">
        </div>
        <div data-linea="21">
            <label for="anio">año </label>
            <select id="anio" name="anio" required="true">
                <?php echo $this->comboAnios($this->modeloSolicitudAsignacionCuv->getAnio());?>
            </select>
        </div>
        <div div data-linea="22">
            <input type="hidden" id="idSolicitudAsignacion" name="idSolicitudAsignacion" 
            value="<?php echo $this->modeloSolicitudAsignacionCuv->getIdSolicitudAsignacionCuv();?>">
        </div>
        <div div data-linea="23">
            <input type="hidden" id="siglas" name="siglas" 
            value="<?php echo $this->modeloSolicitudAsignacionCuv->getSiglas();?>">
        </div>
    </fieldset>
    <fieldset>
        <legend>Disponibilidad en Provincia</legend>
        <div div data-linea="8">
            <label for="disponibilidadCantidad">Disponibilidad en provincia: </label>
            <input id="disponibilidadCantidad" name="disponibilidadCantidad" 
            value=""
            placeholder="Cantidad disponible en provincia" />
        </div>
        <div div data-linea="9">
            <label for="serieInicio">Serie Inicio:</label>
            <input id="serieInicio" name="serieInicio" 
            value="" 
            placeholder="Serie Inicio" />
        </div>
        <div div data-linea="10">
            <label for="serieFin">Serie Fin:</label>
            <input id="serieFin" name="serieFin" 
            value="" 
            placeholder="Serie Fin" />
        </div>
    </fieldset>
    <fieldset>
        <legend>Resultado solicitud de asignación</legend>
        <div div data-linea="11">
            <label for="cantidadAsignar">Cantidad a asignar: </label>
            <input id="cantidadAsignar" name="cantidadAsignar" 
            value="" 
            placeholder="Cantidad que se asignara a cada provincia según la disponibilidad." />
        </div>
        <div data-linea="18">
            <button type="button" class="actualizar" id="btnActualizar">Actualizar</button>
        </div>
        <div div data-linea="12">
            <label for="serieInicioAsignar">Serie Inicio: </label>
            <input id="serieInicioAsignar" name="serieInicioAsignar" 
            value="" 
            placeholder="Serie Inicio que se asignara a cada provincia según la disponibilidad." />
        </div>
        <div div data-linea="13">
            <label for="serieFinAsignar">Serie Fin: </label>
            <input id="serieFinAsignar" name="serieFinAsignar" 
            value="" 
            placeholder="Serie Fin que se asignara a cada provincia según la disponibilidad." />
        </div>
        <div data-linea="16">
            <label for="observaciones">Observaciones: </label>
            <input id="observaciones" name="observaciones" 
            value="" 
            placeholder="Observaciones" required/>
        </div>
        <div data-linea="17">
            <div style="text-align:center;width:100%">
            <button type="submit" class="guardar" id="aprobar">Aprobar</button>
            <button type="submit" class="menos" id="rechazar">Rechazar</button>
        </div>
        </div>
        <input type="hidden" id="accion" name="accion" value="">
        <input type="hidden" id="codigoInicio" name="codigoInicio" value="">
        <input type="hidden" id="codigoFin" name="codigoFin" value="">	
        </div>
    </fieldset>
</form>

<script type="text/javascript">
$(document).ready(function() {
    construirValidador();
    distribuirLineas();
    $("#aprobar").click(function() {
        setAccion('aprobar');
    });
    $("#rechazar").click(function() {
        setAccion('rechazar');
    });
    function setAccion(accion) {
        $("#accion").val(accion);
    }
    $("#fechaSolicitud").attr('readonly', true);
    $("#operadorSolicitante").attr('readonly', true);
    $('#id_provincia').prop('disabled', true);
    $("#cantidadSolicitada").attr('readonly', true);
    $("#disponibilidadCantidad").attr('readonly', true);
    $("#serieInicio").attr('readonly', true);
    $("#serieFin").attr('readonly', true);
    // VARIABLES
    const formulario = document.getElementById('formulario');
    const tabla = document.getElementById('tabla_agregar');
    const agregarBtn = document.getElementById('agregar');
    const aprobarBtn = document.getElementById('aprobar');
    // Obtener el valor inicial de id_provincia
    var idProvincia = $('#id_provincia').val();
    // Asignar el valor de $this->modeloSolicitudAsignacionCuv a una variable JavaScript
    var provincia_nombre = $('#provincia_nombre').val();
    // Asignar el valor de $this->modeloSolicitudAsignacionCuv a una variable JavaScript
    var disponibilidadCantidad = $('#disponibilidadCantidad').val();

    var originalDisponibilidadCantidad = disponibilidadCantidad; // Guardar el valor original
    $('#anio').change(function() {
        // Obtener la cantidad correspondiente al valor inicial de id_provincia y llenar el campo cantidadAsignar
        obtenerCantidad(idProvincia);
    })

    // Obtener el elemento del campo cantidadAsignar
    var cantidadAsignarInput = document.getElementById('cantidadAsignar');
    // Escuchar el evento de cambio en el campo cantidadAsignar
    cantidadAsignarInput.addEventListener('input', function() {
        // Verificar si el campo está vacío
    if ($(this).val() === '') {
        // Restablecer el valor original
        $('#disponibilidadCantidad').val(originalDisponibilidadCantidad); // Restaurar el valor original
    }
    })

    $('#btnActualizar').on('click', function() {
        $("#aprobar").attr('disabled', false);
        $("#cantidadAsignar").attr('readonly', true);
        var cantidadAsignar = parseInt($('#cantidadAsignar').val());
        var disponibilidadCantidad = parseInt($('#disponibilidadCantidad').val());

        // Asignar el valor de $this->modeloSolicitudAsignacionCuv a una variable JavaScript
        var prefijoCuvNumericoAct = $('#prefijoCuvNumerico').val();
        // Asignar el valor de $this->modeloSolicitudAsignacionCuv a una variable JavaScript
        var anioAct = $('#anio').val();

        var array = {
        'cantidadAsignar': cantidadAsignar,
        'prefijoCuvNumerico': prefijoCuvNumericoAct,
        'idProvincia': idProvincia,
        'provincia_nombre': provincia_nombre,
        'anio': anioAct
    };
    console.log(array);
    // Realizar la asignación o mostrar un mensaje de error si es inválido
    if (!isNaN(cantidadAsignar) && cantidadAsignar <= disponibilidadCantidad && cantidadAsignar != 0) {
        // Realizar la asignación aquí
        console.log('Asignación exitosa');
        var nuevaDisponibilidad = disponibilidadCantidad - cantidadAsignar;
        $('#disponibilidadCantidad').val(nuevaDisponibilidad);
        obtenerDatos(array);
    } else {
        console.log('Cantidad inválida');
        $('#cantidadAsignar').val('');
        $('#serieInicioAsignar').val('');
        $('#serieFinAsignar').val('');
    }

    if(isNaN(cantidadAsignar)|| cantidadAsignar == 0){
        console.log('Entro en el vacio');
        console.log(cantidadAsignar);
        $('#disponibilidadCantidad').val(originalDisponibilidadCantidad); // Restaurar el valor original
        $('#cantidadAsignar').val('');
        $('#serieInicioAsignar').val('');
        $('#serieFinAsignar').val('');
        $("#aprobar").attr('disabled', true);
    }
    })


    // Función para obtener la cantidad correspondiente a un id_provincia dado y llenar el campo cantidadAsignar
    function obtenerCantidad(idProvincia) {
        // Asignar el valor de $this->modeloSolicitudAsignacionCuv a una variable JavaScript
        var prefijoCuvNumerico = $('#prefijoCuvNumerico').val();
        // Asignar el valor de $this->modeloSolicitudAsignacionCuv a una variable JavaScript
        var anio = $('#anio').val();
        // Realizar petición AJAX al servidor para verificar si la provincia tiene stock
        var url = "<?php echo URL ?>AsignacionCuv/SolicitudAsignacionCuv/disponibilidadProvincia";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idProvincia: idProvincia,
            prefijoCuvNumerico: prefijoCuvNumerico,
            provincia_nombre: provincia_nombre,
            anio: anio,
        },
        dataType: "json",   
        success: function(response) {
            if (response['validacion'] == 'Exito' && response.resultado['diferencia'] != 0) {
                //var disponibilidadCantidad = response.resultado['cantidad'];
                var diferencia = response.resultado['diferencia'];
                var siglas = response.resultado['siglas'];
                var anio = response.resultado['anio'];
                var prefijo_cuv_numerico = response.resultado['prefijo_cuv_numerico'];
                var serieInicio = response.resultado['codigo_cuv_inicio'];
                var serieFin = response.resultado['codigo_cuv_fin'];
                $('#disponibilidadCantidad').val(diferencia);
                originalDisponibilidadCantidad = diferencia; // Actualizar el valor original
                $('#serieInicio').val(siglas+'-'+anio+'-'+prefijo_cuv_numerico+'-'+serieInicio);
                $('#serieFin').val(siglas+'-'+anio+'-'+prefijo_cuv_numerico+'-'+serieFin);
                $("#estado").html("");
                $("#aprobar").attr('disabled', true);
            } else if(response['validacion'] == 'Fallo') {
                mostrarMensaje(response.mensaje, "FALLO");
                $("#aprobar").attr('disabled', true);
                $("#btnActualizar").attr('disabled', true);
            } else if(response.resultado['diferencia'] == 0) {
                mostrarMensaje(response.mensaje, "No hay disponibilidad en provincia.");
                var diferencia = response.resultado['diferencia'];
                $('#disponibilidadCantidad').val(diferencia);
                $("#aprobar").attr('disabled', true);
                $("#btnActualizar").attr('disabled', true);
            } 
        }
    });
    }

    function obtenerDatos(array) {
    var cantidadAsignar = array['cantidadAsignar'];
    // Realizar petición AJAX al servidor para verificar si la provincia tiene stock
    var url = "<?php echo URL ?>AsignacionCuv/SolicitudAsignacionCuv/obtenerSeries";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            anio: array['anio'],
            cantidadAsignar: array['cantidadAsignar'],
            idProvincia: array['idProvincia'],
            prefijoCuvNumerico: array['prefijoCuvNumerico'],
            provincia_nombre: array['provincia_nombre'],
        },
        dataType: "json",      
        success: function(response) {
            if (response['validacion'] == 'ExitoInicial') {
                console.log('obtenerDatos',response);
                console.log(response.resultado['codigo_cuv_inicio']);
                var inicio = "PPC"+"-"+response.resultado['anio']+"-"+response.resultado['prefijo_cuv_numerico']+"-"+response.resultado['codigo_cuv_inicio'];
                $('#serieInicioAsignar').val(inicio);
                var disponibilidadCantidad = parseInt($('#disponibilidadCantidad').val());
                var finTemporal = (parseInt(response.resultado['codigo_cuv_inicio'])+cantidadAsignar-1).toString().padStart(numeroCerosParam, '0');
                var fin = "PPC"+"-"+response.resultado['anio']+"-"+response.resultado['prefijo_cuv_numerico']+"-"+finTemporal;
                $('#serieFinAsignar').val(fin);
                //$('#disponibilidadCantidad').val(disponibilidadCantidad-cantidadAsignar);
                var codigoInicio = response.resultado['codigo_cuv_inicio'];
                var codigoFin = finTemporal;
                $('#codigoInicio').val(codigoInicio);
                $('#codigoFin').val(codigoFin);
            } else if(response['validacion'] == 'Fallo') {
                mostrarMensaje(response.mensaje, "FALLO");
            }else if(response['validacion'] == 'ExitoEntregaCuv') {
                console.log('ENtregas CUV',response);
                var inicioTemp = parseInt(response.resultado['codigo_cuv_fin'])+1
                var inicio = "PPC"+"-"+response.resultado['anio']+"-"+response.resultado['prefijo_cuv_numerico']+"-"+inicioTemp.toString().padStart(numeroCerosParam, '0');
                $('#serieInicioAsignar').val(inicio);
                var disponibilidadCantidad = parseInt($('#disponibilidadCantidad').val());
                var finTemporal = (inicioTemp+cantidadAsignar-1).toString().padStart(numeroCerosParam, '0');
                var fin = "PPC"+"-"+response.resultado['anio']+"-"+response.resultado['prefijo_cuv_numerico']+"-"+finTemporal;
                $('#serieFinAsignar').val(fin);
                //$('#disponibilidadCantidad').val(disponibilidadCantidad-cantidadAsignar);
                var codigoInicio = response.resultado['codigo_cuv_fin'];
                var codigoFin = finTemporal;
                $('#codigoInicio').val(codigoInicio);
                $('#codigoFin').val(codigoFin);
            }
        }
    });
    }
    
    // $('#cantidadAsignar').on('change', function() {
    //     var cantidadAsignar = parseFloat($(this).val());
    //     var disponibilidadCantidad = parseInt($('#disponibilidadCantidad').val());
    //     if (!isNaN(cantidadAsignar) && cantidadAsignar <= disponibilidadCantidad) {
    //         var nuevaDisponibilidad = disponibilidadCantidad - cantidadAsignar;
    //         $('#disponibilidadCantidad').val(nuevaDisponibilidad);
    //     } else {
    //         $(this).val('');
    //         $('#disponibilidadCantidad').val(originalDisponibilidadCantidad); // Restaurar el valor original
    //     }
    // });

    
    $('#disponibilidadCantidad').on('input', function() {
        var cantidadAsignar = parseInt($('#cantidadAsignar').val());
        if ($(this).val() === '') {
            $('#cantidadAsignar').val(cantidadAsignar);
        }
        if ($(this).val() === '') {
            $('#cantidadAsignar').val(cantidadAsignar);
        }
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
function setAccion(accion) {
        document.getElementById('accion').value = accion;
    }
    

    var numeroCerosParam = "<?php echo $this->numeroCeros; ?>";
});
</script>