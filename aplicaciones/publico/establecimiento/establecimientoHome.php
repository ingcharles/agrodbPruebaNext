<?php
/**
 * User: Gabriel
 * Date: 20/09/23
 * Time: 14:44
 */

require_once '../../../clases/ControladorCatalogos.php';
require_once '../../../clases/Conexion.php';
$conexion = new Conexion();
$cc = new ControladorCatalogos();
$cantones = $cc->listarSitiosLocalizacion($conexion,'CANTONES');
$parroquias = $cc->listarSitiosLocalizacion($conexion,'PARROQUIAS');
$puertos = $cc->listarPuertosStodos($conexion);
//$puertos = pg_fetch_assoc($res);

?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../estilos/estiloapp.css">
    <link rel="stylesheet" href="../establecimiento/css/custom.css">
    <script src="../../general/funciones/jquery-1.9.1.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jqBarGraph.1.1.js"></script>
</head>

<body>
    <div class="contenido">
        <div class="title">Certificado de Salud Animal</div>
        <div class="date">Al
            <?php echo date("d  m  y") ?>
        </div>

        <form id="registroAnimalForm" action="generar_certificado_establecimiento.php" method="post"
            enctype="multipart/form-data">
            <!-- Sección 1: Datos del Animal -->
            <h2>1. Datos del Animal</h2>
            <label for="fotografiaIzquierda">Fotografía lateral izquierda:</label>
            <input type="file" name="fotografiaIzquierda" id="fotografiaIzquierda" accept="image/*" required><br>

            <label for="fotografiaDerecha">Fotografía lateral derecha:</label>
            <input type="file" name="fotografiaDerecha" id="fotografiaDerecha" accept="image/*" required><br>

            <label for="fotografiaFrontal">Fotografía Vista frontal:</label>
            <input type="file" name="fotografiaFrontal" id="fotografiaFrontal" accept="image/*" required><br>

            <label for="nombreAnimal">Nombre:</label>
            <input type="text" name="nombreAnimal" id="nombreAnimal" required><br>

            <label for="especieAnimal">Especie:</label>
            <input type="text" name="especieAnimal" id="especieAnimal" required><br>

            <label for="razaAnimal">Raza:</label>
            <input type="text" name="razaAnimal" id="razaAnimal"><br>

            <label for="sexoAnimal">Sexo:</label>
            <select name="sexoAnimal" id="sexoAnimal">
                <option value="macho">Macho</option>
                <option value="hembra">Hembra</option>
            </select><br>

            <label for="colorAnimal">Color:</label>
            <input type="text" name="colorAnimal" id="colorAnimal"><br>

            <label for="edadAnimal">Edad (meses):</label>
            <input type="number" name="edadAnimal" id="edadAnimal"><br>

            <label for="pesoAnimal">Peso:</label>
            <input type="number" name="pesoAnimal" id="pesoAnimal"><br>

            <label for="chipAnimal">N° chip:</label>
            <input type="text" name="chipAnimal" id="chipAnimal"><br>

            <label for="fechaAplicacion">Fecha de aplicación:</label>
            <input type="date" name="fechaAplicacion" id="fechaAplicacion"><br>

            <label for="esterilizadoAnimal">Esterilizado:</label>
            <input type="radio" name="esterilizadoAnimal" value="No" id="esterilizadoNo"> No
            <input type="radio" name="esterilizadoAnimal" value="SI" id="esterilizadoSI"> SI<br>

            <!-- Sección 2: Datos del Propietario -->
            <h2>Datos del Propietario o persona que viaja con el animal</h2>
            <label for="nombresApellidos">Nombres y apellidos:</label>
            <input type="text" name="nombresApellidos" id="nombresApellidos"><br>

            <label for="direccionDomicilio">Dirección del domicilio en Ecuador:</label>
            <input type="text" name="direccionDomicilio" id="direccionDomicilio"><br>

            <label for="documentoIdentidad">Documento de identidad:</label>
            <input type="text" name="documentoIdentidad" id="documentoIdentidad"><br>

            <label for="provincia">Provincia:</label>
            <select id="provincia" name="provincia">
                    <option value="">Provincia....</option>
                    <?php 
						$provincias = $cc->listarSitiosLocalizacion($conexion,'PROVINCIAS');
						foreach ($provincias as $provincia){
							echo '<option value="' . $provincia['codigo'] . '">' . $provincia['nombre'] . '</option>';
						}
					?>
            </select>

            <label for="canton">Cantón:</label>
            <select id="canton" name="canton" disabled="disabled">
            </select><br>

            <label for="parroquia">Parroquia:</label>
            <select id="parroquia" name="parroquia" disabled="disabled">
            </select><br>

            <label for="telefono">Teléfono:</label>
            <input type="tel" name="telefono" id="telefono"><br>

            <label for="correoElectronico">Correo Electrónico:</label>
            <input type="email" name="correoElectronico" id="correoElectronico"><br>


            <!-- Sección 3: Datos del Destino -->
            <h2>Datos del destino</h2>
            <label for="nombresApellidosDestino">Nombres y apellidos del destinatario:</label>
            <input type="text" name="nombresApellidosDestino" id="nombresApellidosDestino"><br>

            <label for="paisDestino">País de destino:</label>
            <select id="pais" name="pais">
                    <option value="">Pais de Destino....</option>
                    <?php 
                        $res = $cc->listarLocalizacion($conexion,'PAIS');
                    while ($paises = (pg_fetch_assoc($res))) {
                        echo '<option value="' . $paises['id_localizacion'] . '">' . $paises['nombre'] . '</option>';
                    }
					?>
            </select>

            <label for="direccionDestino">Dirección:</label>
            <input type="text" name="direccionDestino" id="direccionDestino"><br>

            <label for="fechaViaje">Fecha de viaje:</label>
            <input type="date" name="fechaViaje" id="fechaViaje"><br>

            <label for="puntoFronterizoSalida">Punto fronterizo de salida:</label>
            <select id="puntoFronterizoSalida" name="puntoFronterizoSalida" disabled="disabled">
            </select><br>


            <!-- Sección 4: Inspección Clínica -->

            <h2>Inspección Clínica</h2>
            <label for="temperatura">Temperatura:</label>
            <input type="text" name="temperatura" id="temperatura"><br>

            <label for="frecuenciaCardiaca">Frecuencia cardiaca:</label>
            <input type="text" name="frecuenciaCardiaca" id="frecuenciaCardiaca"><br>

            <label for="frecuenciaRespiratoria">Frecuencia respiratoria:</label>
            <input type="text" name="frecuenciaRespiratoria" id="frecuenciaRespiratoria"><br>

            <label for="verificacionEdad">Verificación de la edad:</label>
            <input type="text" name="verificacionEdad" id="verificacionEdad"><br>

            <label for="gusanoBarrenador">Gusano Barrenador:</label>
            <input type="text" name="gusanoBarrenador" id="gusanoBarrenador"><br>

            <label for="parasitosExternos">Parásitos externos:</label>
            <input type="text" name="parasitosExternos" id="parasitosExternos"><br>


            <!-- Sección 5: Vacunaciones -->
            <h2>Vacunaciones</h2>

            <!-- Vacuna 1 -->
            <h3>Vacuna 1</h3>
            <label for="enfermedadVacuna1">Enfermedad (Vacuna 1):</label>
            <input type="text" name="enfermedadVacuna1" id="enfermedadVacuna1"><br>

            <label for="nombreVacuna1">Nombre de la vacuna (Vacuna 1):</label>
            <input type="text" name="nombreVacuna1" id="nombreVacuna1"><br>

            <label for="fechaVacunacion1">Fecha de vacunación (Vacuna 1):</label>
            <input type="date" name="fechaVacunacion1" id="fechaVacunacion1"><br>

            <label for="fechaRevacunacion1">Fecha de revacunación (Vacuna 1):</label>
            <input type="date" name="fechaRevacunacion1" id="fechaRevacunacion1"><br>

            <label for="fechaExpiracion1">Fecha de expiración del producto (Vacuna 1):</label>
            <input type="date" name="fechaExpiracion1" id="fechaExpiracion1"><br>

            <label for="loteVacuna1">Lote (Vacuna 1):</label>
            <input type="text" name="loteVacuna1" id="loteVacuna1"><br>

            <label for="registroVacuna1">N° de Registro (Vacuna 1):</label>
            <input type="text" name="registroVacuna1" id="registroVacuna1"><br>

            <label for="laboratorioVacuna1">Laboratorio (Vacuna 1):</label>
            <input type="text" name="laboratorioVacuna1" id="laboratorioVacuna1"><br>

            <!-- Vacuna 2 -->
            <h3>Vacuna 2</h3>
            <label for="enfermedadVacuna2">Enfermedad (Vacuna 2):</label>
            <input type="text" name="enfermedadVacuna2" id="enfermedadVacuna2"><br>

            <label for="nombreVacuna2">Nombre de la vacuna (Vacuna 2):</label>
            <input type="text" name="nombreVacuna2" id="nombreVacuna2"><br>

            <label for="fechaVacunacion2">Fecha de vacunación (Vacuna 2):</label>
            <input type="date" name="fechaVacunacion2" id="fechaVacunacion2"><br>

            <label for="fechaRevacunacion2">Fecha de revacunación (Vacuna 2):</label>
            <input type="date" name="fechaRevacunacion2" id="fechaRevacunacion2"><br>

            <label for="fechaExpiracion2">Fecha de expiración del producto (Vacuna 2):</label>
            <input type="date" name="fechaExpiracion2" id="fechaExpiracion2"><br>

            <label for="loteVacuna2">Lote (Vacuna 2):</label>
            <input type="text" name="loteVacuna2" id="loteVacuna2"><br>

            <label for="registroVacuna2">N° de Registro (Vacuna 2):</label>
            <input type="text" name="registroVacuna2" id="registroVacuna2"><br>

            <label for="laboratorioVacuna2">Laboratorio (Vacuna 2):</label>
            <input type="text" name="laboratorioVacuna2" id="laboratorioVacuna2"><br>


            <!-- Sección 6: Titulación de Anticuerpos -->

            <h2>6. Titulación de Anticuerpos</h2>

            <label for="fechaTomaMuestra">Fecha de toma de la muestra:</label>
            <input type="date" name="fechaTomaMuestra" id="fechaTomaMuestra"><br>

            <label for="fechaResultado">Fecha de resultado:</label>
            <input type="date" name="fechaResultado" id="fechaResultado"><br>

            <label for="resultadoAnticuerpos">Resultado (al menos 0.5 UI/ml):</label>
            <input type="text" name="resultadoAnticuerpos" id="resultadoAnticuerpos"><br>

            <label for="czeEnvioMuestra">CZE: envío de la muestra</label>
            <input type="text" name="czeEnvioMuestra" id="czeEnvioMuestra"><br>


            <!-- Sección 7: Desparasitaciones -->
            <h2>7. Desparasitaciones</h2>

            <!-- Tipo Interna -->
            <h3>a. Tipo Interna</h3>

            <label for="fechaAplicacionInterna">Fecha de aplicación:</label>
            <input type="date" name="fechaAplicacionInterna" id="fechaAplicacionInterna">

            <label for="horaAplicacionInterna">Hora:</label>
            <input type="time" name="horaAplicacionInterna" id="horaAplicacionInterna">

            <label for="nombreComercialInterna">Nombre comercial:</label>
            <input type="text" name="nombreComercialInterna" id="nombreComercialInterna">

            <label for="fabricanteInterna">Fabricante del producto:</label>
            <input type="text" name="fabricanteInterna" id="fabricanteInterna">

            <label for="principioActivoInterna">Principio activo:</label>
            <input type="text" name="principioActivoInterna" id="principioActivoInterna">

            <label for="dosisInterna">Dosis:</label>
            <input type="text" name="dosisInterna" id="dosisInterna">

            <!-- Tipo Externa -->
            <h3>b. Tipo Externa</h3>

            <label for="fechaAplicacionExterna">Fecha de aplicación:</label>
            <input type="date" name="fechaAplicacionExterna" id="fechaAplicacionExterna">

            <label for="horaAplicacionExterna">Hora:</label>
            <input type="time" name="horaAplicacionExterna" id="horaAplicacionExterna">

            <label for="nombreComercialExterna">Nombre comercial:</label>
            <input type="text" name="nombreComercialExterna" id="nombreComercialExterna">

            <label for="fabricanteExterna">Fabricante del producto:</label>
            <input type="text" name="fabricanteExterna" id="fabricanteExterna">

            <label for="principioActivoExterna">Principio activo:</label>
            <input type="text" name="principioActivoExterna" id="principioActivoExterna">

            <label for="dosisExterna">Dosis:</label>
            <input type="text" name="dosisExterna" id="dosisExterna">


            <!-- Sección 8: Observaciones -->
            <h2>8. Observaciones</h2>
            <input type="text" name="observaciones" id="observaciones">


            <!-- Firma de Responsabilidad -->
            <h2>Firma de Responsabilidad</h2>
            <label>Fecha de examen clínico:</label>
            <input type="date" name="examenClinicofecha">
            <label>Nombre del Médico Veterinario:</label>
            <input type="text" name="nombreVeterinario">
            <label>N° Registro en el Senecyt:</label>
            <input type="text" name="registroSenecyt">
            <label>CI/CC:</label>
            <input type="text" name="ciCc">
            <input type="hidden" id="array_cuv" name="array_cuv" value="" readonly="readonly" />
            <input type="hidden" id="array_puertos" name="array_puertos" value="" readonly="readonly" />
            <!-- Botón de Enviar -->
            <input type="submit" value="Enviar" id="enviar">
        </form>

    </div>
    <script>
    // Función para mostrar la imagen seleccionada en cada input de tipo file
    $(document).ready(function () {
        $('#enviar').click(function() {
            //enviarProvincia();
        });

    });
    var array_canton = <?php echo json_encode($cantones); ?>;
    var array_parroquia = <?php echo json_encode($parroquias); ?>;
    var array_puertos = <?php echo json_encode($puertos); ?>;
    $("#provincia").change(function(event) {
        scanton = '0';
        scanton = '<option value="">Cantón...</option>';
        for (var i = 0; i < array_canton.length; i++) {
        if ($("#provincia").val() == array_canton[i]['padre']) {
            scanton += '<option value="' + array_canton[i]['codigo'] + '">' + array_canton[i]['nombre'] + '</option>';
            }
        }
        $('#canton').html(scanton);
        $("#canton").removeAttr("disabled");
        $("#codigoProvincia").val($("#provincia").val());
    });


    $("#canton").change(function() {
    sparroquia = '0';
    sparroquia = '<option value="">Parroquia...</option>';
    for (var i = 0; i < array_parroquia.length; i++) {
        if ($("#canton").val() == array_parroquia[i]['padre']) {
            sparroquia += '<option value="' + array_parroquia[i]['codigo'] + '">' + array_parroquia[i][
                'nombre'
            ] + '</option>';
        }
    }
    $('#parroquia').html(sparroquia);
    $("#parroquia").removeAttr("disabled");
    });

    $("#parroquia").change(function() {
        const datos = [];
        var provinciaSeleccionadaNombre = $('#provincia option:selected').text();
        var cantonSeleccionadaNombre = $('#canton option:selected').text();
        var parroquiaSeleccionadaNombre = $('#parroquia option:selected').text();
        const filaDatos = {
                provinciaNombre: provinciaSeleccionadaNombre,
                cantonNombre: cantonSeleccionadaNombre,
                parroquiaNombre: parroquiaSeleccionadaNombre
            };
        datos.push(filaDatos);
        $("#array_cuv").val(JSON.stringify(datos))
    });

    $("#pais").change(function() {
        var paisCodigo = $('#pais').val();
        spuerto = '0';
        spuerto = '<option value="">Puerto...</option>';
        for (var i = 0; i < array_puertos.length; i++) {
            if (paisCodigo == array_puertos[i]['id_pais']) {
            spuerto += '<option value="' + array_puertos[i]['id_puerto'] + '">' + array_puertos[i]['nombre_puerto'] + '</option>';
            }
        }
        $('#puntoFronterizoSalida').html(spuerto);
        $("#puntoFronterizoSalida").removeAttr("disabled");
    });
    $("#puntoFronterizoSalida").change(function() {
        const datos = [];
        var paisNombre = $('#pais option:selected').text();
        var puertoNombre = $('#puntoFronterizoSalida option:selected').text();
        var puertoNombreb = $(this).find('option:selected').text();
        console.log(puertoNombre);
        console.log(puertoNombreb);
        const filaDatos = {
            paisNombre: paisNombre,
            puertoNombre: puertoNombre
            };
        datos.push(filaDatos);
        $("#array_puertos").val(JSON.stringify(datos))
    });
    </script>
</body>

</html>