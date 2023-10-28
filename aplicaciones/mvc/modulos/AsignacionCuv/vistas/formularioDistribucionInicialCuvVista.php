<header>
    <h1><?= $this->accion ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>AsignacionCuv'
    data-opcion='DistribucionInicialCuv/guardarListadoSecuencial' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR"
    method="post">
    <fieldset>
        <legend>Carga Inicial de CUV</legend>

        <div data-linea="3">
            <label for="id_provincia">Provincia</label>
            <select id="id_provincia" name="id_provincia" required="true">
                <option value=""> Seleccionar....</option>
                <?php echo $this->comboProvinciasEc($this->modeloDistribucionInicialCuv->getIdProvincia());
					//echo $this->combocomboprovincia($this->modeloDistribucionInicialCuv->getProvincia());
				?>
            </select>
        </div>

        <div data-linea="5">
            <label for="anio">Año</label>
            <select id="anio" name="anio" required="true">
                <?php echo $this->comboAnios($this->modeloDistribucionInicialCuv->getAnio());?>
            </select>
        </div>
        <div data-linea="6">
    <label for="prefijo_cuv_numerico">Prefijo CUV numérico</label>
    <input type="text" id="prefijo_cuv_numerico" name="prefijo_cuv_numerico"
        value="<?php echo $this->modeloDistribucionInicialCuv->getPrefijoCuvNumerico(); ?>"
        placeholder="Es el número de tres cifras antes del código del CUV" required maxlength="3"
        pattern="^(0?[1-9]|[1-9][0-9]|100)$">
    <span class="help-block" style="display:none;">Ingrese un número entre 001 y 100 (con ceros a la izquierda.)</span>
</div>
        <div data-linea="9">
            <label for="cantidad">Cantidad </label>
            <input type="text" id="cantidad" name="cantidad"
                value="<?php echo $this->modeloDistribucionInicialCuv->getCantidad(); ?>"
                placeholder="Cantidad de CUVS que se van a distribuir a provincia" required maxlength="7" />
        </div>

        <div data-linea="7">
            <label for="codigo_cuv_inicio" hidden>codigo_cuv_inicio </label>
            <input type="hidden" id="codigo_cuv_inicio" name="codigo_cuv_inicio"
                value="<?php echo $this->modeloDistribucionInicialCuv->getCodigoCuvInicio(); ?>"
                placeholder="Código Inicial de los CUV" maxlength="8" />
        </div>

        <div data-linea="8">
            <label for="codigo_cuv_fin" hidden>codigo_cuv_fin </label>
            <input type="hidden" id="codigo_cuv_fin" name="codigo_cuv_fin"
                value="<?php echo $this->modeloDistribucionInicialCuv->getCodigoCuvFin(); ?>"
                placeholder="Código Final de los CUV" maxlength="8" />
        </div>
        <div data-linea="14">

            <input type="hidden" name="id_distribucion_inicial_cuv" id="id_distribucion_inicial_cuv"
                value="<?php echo $this->modeloDistribucionInicialCuv->getIdDistribucionInicialCuv() ?>">

            <input type="hidden" name="siglas" id="siglas" value="PPC">

            <input type="hidden" name="estado" id="estado"
                value="<?php echo $this->modeloDistribucionInicialCuv->getEstado() ?>">

            <input type="hidden" name="identificador" id="identificador"
                value="<?php echo $this->modeloDistribucionInicialCuv->getIdentificador() ?>">

            <input type="hidden" name="fecha_creacion" id="fecha_creacion" value="<?php echo date("Y-m-d h:m:s"); ?>">
            <input type="hidden" name="nombreProvincia" id="nombreProvincia" value="">
            <input type="hidden" id="array_cuv" name="array_cuv" value="" readonly="readonly" />
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
                        <th>Provincia</th>
                        <th>Año</th>
                        <th>Cantidad</th>
                        <th>Prefijo CUV Numérico</th>
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







<script type="text/javascript">
$(document).ready(function() {
    construirValidador();
    distribuirLineas();
    $('#id_provincia').on('change', function() {
        var provincia = $('#id_provincia').val();
        buscarProvincia(provincia);
    });
    $('#cantidad').blur(function(event) {
            var valor = $(this).val();
            if (isNaN(valor)) {
                $("#estado").html("Por favor, ingrese solo números.").addClass("alerta");
                event.preventDefault();
            }
    });
});
// Obtener el input y el elemento span
const inputPrefijoCuvNumerico = document.querySelector('#prefijo_cuv_numerico');
const ayudaPrefijoCuvNumerico = document.querySelector('#prefijo_cuv_numerico ~ .help-block');

// Agregar controlador de eventos para la entrada del usuario
inputPrefijoCuvNumerico.addEventListener('input', () => {
    // Verificar si la entrada coincide con el patrón
    if (inputPrefijoCuvNumerico.validity.patternMismatch) {
        ayudaPrefijoCuvNumerico.style.display = 'block';
    } else {
        ayudaPrefijoCuvNumerico.style.display = 'none';
    }
});
// VARIABLES
const formulario = document.getElementById('formulario');
const tabla = document.getElementById('tabla_agregar');
const agregarBtn = document.getElementById('agregar');
const guardarBtn = document.getElementById('guardar');
let nombreProvincia = null;

// Función para verificar si una provincia ya fue agregada
function provinciaAgregada(nombreProvincia, anio) {
    var resultado = false;
    $('#tabla_agregar tbody tr').each(function() {
        var nombreProvinciaTabla = $(this).find('td:eq(1)').text();
        var anioTabla = $(this).find('td:eq(2)').text();
        if (nombreProvinciaTabla == nombreProvincia && anioTabla == anio) {
            resultado = true;
            return false; // Para salir del bucle
        }
    });
    return resultado;
}
function provinciaTieneCantidad(nombreProvincia, anio) {
    var resultado = false;
    // Realizar petición AJAX al servidor para verificar si la provincia tiene stock
    var url = "<?php echo URL ?>AsignacionCuv/DistribucionInicialCuv/obtenerCantidad";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            nombre_provincia: nombreProvincia,
            anio: anio,
        },
        dataType: "json",
        async: false,
        success: function(response) {
            console.log(response['mensaje']);
            if (response['validacion'] == 'Exito') {
                formulario.reset();
                resultado= false;
            } else if(response['validacion'] == 'Fallo') {
                resultado= true;
                formulario.reset();
                $("#estado").html("");
            }
        }
    });
    return resultado;
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
// Función para validar el prefijo CUV numérico
function validarPrefijo() {
  const prefijo = formulario.querySelector('#prefijo_cuv_numerico').value;
  const regex = /^[0-9]{3}$/; // Expresión regular para validar que sean 3 dígitos del 0 al 9

  if (!regex.test(prefijo)) {
    $("#estado").html("El prefijo CUV numérico debe ser un número de 3 dígitos").addClass("alerta");
    return false;
  }
  return true;
}
// Función para agregar una fila a la tabla
function agregarFila() {
    // Obtener valores del formulario
    const provincia = formulario.querySelector('#id_provincia').value;
    const anio = formulario.querySelector('#anio').value;
    const cantidad = formulario.querySelector('#cantidad').value;
    const prefijo = formulario.querySelector('#prefijo_cuv_numerico').value;
    const array_cuv = document.getElementById("array_cuv");

      // Validar que el prefijo CUV numérico sea un número de 3 dígitos
    if (!validarPrefijo()) {
        return;
    }
    // Verificar que cantidad sea un número
    if (isNaN(cantidad) || !/^\d+$/.test(cantidad)) {
        $("#estado").html("Por favor ingrese una cantidad válida.").addClass("alerta");
        return;
    }
    // Verificar que los campos no estén vacíos
    if (provincia === '' || anio === '' || cantidad === '' || prefijo === '') {
        //alert('Por favor, complete todos los campos');
        $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        return;
    }

      // Verificar si la provincia ya fue agregada
    if (provinciaAgregada(nombreProvincia, anio)) {
        $("#estado").html("La provincia ya fue agregada para el año seleccionado.").addClass("alerta");
        return;
    }
    if (!provinciaTieneCantidad(nombreProvincia, anio)) {
        $("#estado").html("La provincia ya tiene un stock para el año seleccionado.").addClass("alerta");
        return;
    }

    // Crear fila y agregar celdas
    const fila = document.createElement('tr');
    fila.innerHTML = `
	<td hidden>${provincia}</td>
    <td>${nombreProvincia}</td>
    <td>${anio}</td>
    <td>${cantidad}</td>
    <td>${prefijo}</td>
	<td><button class='menos'>Eliminar</button></td>`;

    // Agregar fila a la tabla
    tabla.querySelector('tbody').appendChild(fila);

    // Limpiar valores del formulario
    formulario.reset();
    $("#estado").html("");
    // Agregar controlador de eventos para botón de eliminar
    const btnEliminar = fila.querySelector('.menos');
    btnEliminar.addEventListener('click', () => {
        fila.remove();
    });
}


agregarBtn.addEventListener('click', agregarFila);
guardarBtn.addEventListener('click', (event) => {
    event.preventDefault();
    // Obtener la tabla de agregados
    var tablaAgregados = $('#tabla_agregar tbody tr');
    // Verificar si la tabla tiene elementos
    if (tablaAgregados.length > 0) {
        // Si la tabla tiene elementos, enviar el formulario
        const filas = tabla.rows;
        const datos = [];

        for (let i = 1; i < filas.length; i++) {
            const celdas = filas[i].cells;
            const filaDatos = {
                provincia: celdas[0].textContent,
                anio: celdas[2].textContent,
                cantidad: celdas[3].textContent,
                prefijo: celdas[4].textContent,
            };
            datos.push(filaDatos);
            //envio al controlador por Post a guardar el array
            $("#array_cuv").val(JSON.stringify(datos))
        }
        $('#formulario').submit();
    } else {
        // Si la tabla no tiene elementos, mostrar un mensaje de error
        $("#estado").html("Debe agregar al menos un elemento a la tabla.").addClass("alerta");
        //alert('Debe agregar al menos un elemento a la tabla');
    }
});

/* 	$('#guardar').click(function (event) {
		console.log("guardar");
		event.preventDefault();
		var cantidad = $("#cantidad").val();
		var anio = $("#anio").val();
		var prefijo = $("#prefijo_cuv_numerico").val();
		var inicio = $("#codigo_cuv_inicio").val();
		var fin = $("#codigo_cuv_fin").val();
		var url = "<?php echo URL ?>AsignacionCuv/DistribucionInicialCuv/verificarSolapamientoCuv";
		$.ajax({
			type: "POST",
			url: url,
			data: {
				cantidad : cantidad,
				anio : anio,
				prefijo: prefijo,
				inicio: inicio,
				fin: fin
			},
			dataType: "json",
			success: function (response) {
				
			}
		});
	}); */

$("#formulario").submit(function(event) {
    //console.log("Submit");
    event.preventDefault();
    var error = false;
    if (!error) {
        abrir($(this), event, false);
        abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"), "#listadoItems", true);
    } else {
        $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
    }
});
// $('#cantidad').keyup(function() {
//     if ($('#cantidad').val()) {
//         var cantidad = $(this).val();
//         var anio = $("#anio").val();
//         var prefijo = $("#prefijo_cuv_numerico").val();
//     } else {
//         $("#codigo_cuv_inicio").val('');
//         $("#codigo_cuv_fin").val('');
//         return false;
//     }
//     var url = "<?php echo URL ?>AsignacionCuv/DistribucionInicialCuv/calcularCuv";
//     /**Enviar Ajax*/
//     $.ajax({
//         type: 'POST',
//         url: url,
//         data: {
//             cantidad: cantidad,
//             anio: anio,
//             prefijo: prefijo
//         },
//         dataType: "json",
//         success: function(returnData) {
//             //debugger;
//             console.log(returnData);
//             if (returnData.validacion == 'Exito') {
//                 var inicio = (parseInt(returnData.resultado) + 1).toString().padStart(7, '0');
//                 var fin = (parseInt(inicio) + parseInt(cantidad) - 1).toString().padStart(7, '0');
//                 $("#codigo_cuv_inicio").val(inicio);
//                 $("#codigo_cuv_fin").val(fin);
//                 console.log(returnData);
//                 deshabilitarCampos();
//                 mostrarMensaje(returnData.mensaje, "EXITO");
//             } else if (returnData.validacion == 'Crea') {
//                 var inicio = (parseInt(returnData.resultado['codigo_cuv_fin'])).toString().padStart(
//                     7, '0');
//                 var fin = (parseInt(cantidad)).toString().padStart(7, '0');
//                 $("#codigo_cuv_inicio").val(inicio);
//                 $("#codigo_cuv_fin").val(fin);
//                 console.log(returnData);
//                 deshabilitarCampos();
//                 mostrarMensaje(returnData.mensaje, "EXITO");
//             } else {
//                 mostrarMensaje(returnData.mensaje, "FALLO");
//                 $("#formulario").trigger("reset");
//             }
//         }
//     });
// })

function deshabilitarCampos() {
    $("#codigo_cuv_inicio").attr('readonly', true);
    $("#codigo_cuv_fin").attr('readonly', true);
    $('#anio').attr('readonly', true);
}
</script>