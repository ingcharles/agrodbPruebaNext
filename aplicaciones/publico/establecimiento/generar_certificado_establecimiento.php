<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

//C:\xampp\htdocs\agrodbPrueba\vendor\autoload.php
//Fatal error: require_once(): Failed opening required 'C:\xampp\htdocs\agrodbPrueba\aplicaciones\publico\establecimiento/vendor/autoload.php' (include_path='C:\xampp\php\PEAR')

use Mpdf\Mpdf;


// Obtener las fotos del formulario
$fotografiaIzquierda = $_FILES['fotografiaIzquierda']['tmp_name'];
$fotografiaDerecha = $_FILES['fotografiaDerecha']['tmp_name'];
$fotografiaFrontal = $_FILES['fotografiaFrontal']['tmp_name'];
// Guardar las fotos en el servidor
move_uploaded_file($fotografiaIzquierda, 'img/temp/fotografiaIzquierda.jpg');
move_uploaded_file($fotografiaDerecha, 'img/temp/fotografiaDerecha.jpg');
move_uploaded_file($fotografiaFrontal, 'img/temp/fotografiaFrontal.jpg');

$_POST['array_cuv'] = json_decode($_POST['array_cuv'], true);
$_POST['array_puertos'] = json_decode($_POST['array_puertos'], true);

// Obtener los datos del propietario del formulario
$nombresApellidos = $_POST['nombresApellidos'] ?? '';
$direccionDomicilio = $_POST['direccionDomicilio'] ?? '';
$documentoIdentidad = $_POST['documentoIdentidad'] ?? '';
$provincia = $_POST['array_cuv'][0]['provinciaNombre'] ?? '';
$canton = $_POST['array_cuv'][0]['cantonNombre'] ?? '';
$parroquia = $_POST['array_cuv'][0]['parroquiaNombre'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$correoElectronico = $_POST['correoElectronico'] ?? '';

$nombresApellidosDestino = $_POST['nombresApellidosDestino'] ?? '';
$paisDestino = $_POST['array_puertos'][0]['paisNombre'] ?? '';
$direccionDestino = $_POST['direccionDestino'] ?? '';
$fechaViaje = $_POST['fechaViaje'] ?? '';
$puntoFronterizoSalida = $_POST['array_puertos'][0]['puertoNombre'] ?? '';


$temperatura = $_POST['temperatura'] ?? '';
$frecuenciaCardiaca = $_POST['frecuenciaCardiaca'] ?? '';
$frecuenciaRespiratoria = $_POST['frecuenciaRespiratoria'] ?? '';
$verificacionEdad = $_POST['verificacionEdad'] ?? '';
$gusanoBarrenador = $_POST['gusanoBarrenador'] ?? '';
$parasitosExternos = $_POST['parasitosExternos'] ?? '';

// Obtener los datos de vacunaciones del formulario por POST
$vacuna1 = [
    'enfermedad' => $_POST['enfermedadVacuna1'] ?? '',
    'nombre' => $_POST['nombreVacuna1'] ?? '',
    'fechaVacunacion' => $_POST['fechaVacunacion1'] ?? '',
    'fechaRevacunacion' => $_POST['fechaRevacunacion1'] ?? '',
    'fechaExpiracion' => $_POST['fechaExpiracion1'] ?? '',
    'lote' => $_POST['loteVacuna1'] ?? '',
    'registro' => $_POST['registroVacuna1'] ?? '',
    'laboratorio' => $_POST['laboratorioVacuna1'] ?? ''
];

$vacuna2 = [
    'enfermedad' => $_POST['enfermedadVacuna2'] ?? '',
    'nombre' => $_POST['nombreVacuna2'] ?? '',
    'fechaVacunacion' => $_POST['fechaVacunacion2'] ?? '',
    'fechaRevacunacion' => $_POST['fechaRevacunacion2'] ?? '',
    'fechaExpiracion' => $_POST['fechaExpiracion2'] ?? '',
    'lote' => $_POST['loteVacuna2'] ?? '',
    'registro' => $_POST['registroVacuna2'] ?? '',
    'laboratorio' => $_POST['laboratorioVacuna2'] ?? ''
];

$titulacionAnticuerpos = [
    'fechaTomaMuestra' => $_POST['fechaTomaMuestra'] ?? '',
    'fechaResultado' => $_POST['fechaResultado'] ?? '',
    'resultadoAnticuerpos' => $_POST['resultadoAnticuerpos'] ?? '',
    'czeEnvioMuestra' => $_POST['czeEnvioMuestra'] ?? ''
];

// Obtener los datos de desparasitaciones del formulario por POST
$desparasitaciones = [
    'interna' => [
        'fechaAplicacion' => $_POST['fechaAplicacionInterna'] ?? '',
        'horaAplicacion' => $_POST['horaAplicacionInterna'] ?? '',
        'nombreComercial' => $_POST['nombreComercialInterna'] ?? '',
        'fabricante' => $_POST['fabricanteInterna'] ?? '',
        'principioActivo' => $_POST['principioActivoInterna'] ?? '',
        'dosis' => $_POST['dosisInterna'] ?? ''
    ],
    'externa' => [
        'fechaAplicacion' => $_POST['fechaAplicacionExterna'] ?? '',
        'horaAplicacion' => $_POST['horaAplicacionExterna'] ?? '',
        'nombreComercial' => $_POST['nombreComercialExterna'] ?? '',
        'fabricante' => $_POST['fabricanteExterna'] ?? '',
        'principioActivo' => $_POST['principioActivoExterna'] ?? '',
        'dosis' => $_POST['dosisExterna'] ?? ''
    ]
];
// Obtener los datos de Observaciones y Firma de Responsabilidad del formulario por POST
$observaciones = $_POST['observaciones'] ?? '';
$firmaResponsabilidad = [
    'nombreVeterinario' => $_POST['nombreVeterinario'] ?? '',
    'registroSenecyt' => $_POST['registroSenecyt'] ?? '',
    'ciCc' => $_POST['ciCc'] ?? ''
];
// Crear el contenido del certificado en HTML
$html = "
<head>
    <link rel='stylesheet' type='text/css' href='css/customReporte.css'>
</head>
<body>
    <h1>Certificado de Animal</h1>
    <h2>1. Datos del Animal</h2>
    <p>Fotografias:</p>
    <ul>
        <li>Fotografía lateral izquierda:</li>
        <img src='img/temp/fotografiaIzquierda.jpg' alt='Fotografía lateral izquierda' style='width: 200px;'><br>

        <li>Fotografía lateral derecha:</li>
        <img src='img/temp/fotografiaDerecha.jpg' alt='Fotografía lateral derecha' style='width: 200px;'><br>

        <li>Fotografía Vista frontal:</li>
        <img src='img/temp/fotografiaFrontal.jpg' alt='Fotografía Vista frontal' style='width: 200px;'><br>
    </ul>
    <table>
    <tr>
      <th>Nombre</th>
      <th>Especie</th>
      <th>Raza</th>
      <th>Sexo</th>
      <th>Color</th>
      <th>Edad (meses)</th>
      <th>Peso</th>
      <th>N° Chip</th>
      <th>Fecha de aplicación</th>
      <th>Esterilizado</th>
    </tr>
    <tr>
      <td><span>" . $_POST['nombreAnimal'] . "</span></td>
      <td><span>" . $_POST['especieAnimal'] . "</span></td>
      <td>". $_POST['razaAnimal'] . "</td>
      <td>". $_POST['sexoAnimal'] ."</td>
      <td>" . $_POST['colorAnimal'] ."</td>
      <td>". $_POST['edadAnimal'] ."</td>
      <td>" . $_POST['pesoAnimal'] ."</td>
      <td>" . $_POST['chipAnimal'] ."</td>
      <td>". $_POST['fechaAplicacion'] ."</td>
      <td>". $_POST['esterilizadoAnimal'] ."</td>
    </tr>
  </table><br><br><br><br><br><br><br><br>
  


    <h2>2. Datos del Propietario</h2>
    <h2>Datos del Propietario o persona que viaja con el animal</h2>

    <table>
    <tr>
      <th>Categoría</th>
      <th>Valor</th>
    </tr>
    <tr>
      <td><b>Nombres y apellidos:</b></td>
      <td><span>{$nombresApellidos}</span></td>
    </tr>
    <tr>
      <td><b>Dirección del domicilio en Ecuador:</b></td>
      <td><span>{$direccionDomicilio}</span></td>
    </tr>
    <tr>
      <td><b>Documento de identidad:</b></td>
      <td><span>{$documentoIdentidad}</span></td>
    </tr>
    <tr>
      <td><b>Provincia:</b></td>
      <td><span>{$provincia}</span></td>
    </tr>
    <tr>
      <td><b>Cantón:</b></td>
      <td><span>{$canton}</span></td>
    </tr>
    <tr>
      <td><b>Parroquia:</b></td>
      <td><span>{$parroquia}</span></td>
    </tr>
    <tr>
      <td><b>Teléfono:</b></td>
      <td><span>{$telefono}</span></td>
    </tr>
    <tr>
      <td><b>Correo Electrónico:</b></td>
      <td><span>{$correoElectronico}</span></td>
    </tr>
  </table>
  


    <h2>3.Datos del Destino</h2>
    <table>
  <tr>
    <th>Categoría</th>
    <th>Valor</th>
  </tr>
  <tr>
    <td>Nombres y apellidos del destinatario:</td>
    <td><span>$nombresApellidosDestino</span></td>
  </tr>
  <tr>
    <td>País de destino:</td>
    <td><span>$paisDestino</span></td>
  </tr>
  <tr>
    <td>Dirección:</td>
    <td><span>$direccionDestino</span></td>
  </tr>
  <tr>
    <td>Fecha de viaje:</td>
    <td><span>$fechaViaje</span></td>
  </tr>
  <tr>
    <td>Punto fronterizo de la salida:</td>
    <td><span>$puntoFronterizoSalida</span></td>
  </tr>
</table>


    <h2>4.Inspección Clínica</h2>
    <table>
    <tr>
      <th>Categoría</th>
      <th>Valor</th>
    </tr>
    <tr>
      <td>Temperatura:</td>
      <td><span>$temperatura</span></td>
    </tr>
    <tr>
      <td>Frecuencia cardiaca:</td>
      <td><span>$frecuenciaCardiaca</span></td>
    </tr>
    <tr>
      <td>Frecuencia respiratoria:</td>
      <td><span>$frecuenciaRespiratoria</span></td>
    </tr>
    <tr>
      <td>Verificación de la edad:</td>
      <td><span>$verificacionEdad</span></td>
    </tr>
    <tr>
      <td>Gusano Barrenador:</td>
      <td><span>$gusanoBarrenador</span></td>
    </tr>
    <tr>
      <td>Parásitos externos:</td>
      <td><span>$parasitosExternos</span></td>
    </tr>
  </table>
  

    <h2>5.Vacunaciones</h2>

    <!-- Vacuna 1 -->
    <h3>Vacuna 1</h3>
    <table>
    <tr>
      <th>Categoría</th>
      <th>Valor</th>
    </tr>
    <tr>
      <td>Enfermedad:</td>
      <td><span>{$vacuna1['enfermedad']}</span></td>
    </tr>
    <tr>
      <td>Nombre de la vacuna:</td>
      <td><span>{$vacuna1['nombre']}</span></td>
    </tr>
    <tr>
      <td>Fecha de vacunación:</td>
      <td><span>{$vacuna1['fechaVacunacion']}</span></td>
    </tr>
    <tr>
      <td>Fecha de revacunación:</td>
      <td><span>{$vacuna1['fechaRevacunacion']}</span></td>
    </tr>
    <tr>
      <td>Fecha de expiración del producto:</td>
      <td><span>{$vacuna1['fechaExpiracion']}</span></td>
    </tr>
    <tr>
      <td>Lote:</td>
      <td><span>{$vacuna1['lote']}</span></td>
    </tr>
    <tr>
      <td>N° de Registro:</td>
      <td><span>{$vacuna1['registro']}</span></td>
    </tr>
    <tr>
      <td>Laboratorio:</td>
      <td><span>{$vacuna1['laboratorio']}</span></td>
    </tr>
  </table>
  

    <!-- Vacuna 2 -->
    <h3>Vacuna 2</h3>
    <table>
    <tr>
      <th>Categoría</th>
      <th>Valor</th>
    </tr>
    <tr>
      <td>Enfermedad:</td>
      <td><span>{$vacuna2['enfermedad']}</span></td>
    </tr>
    <tr>
      <td>Nombre de la vacuna:</td>
      <td><span>{$vacuna2['nombre']}</span></td>
    </tr>
    <tr>
      <td>Fecha de vacunación:</td>
      <td><span>{$vacuna2['fechaVacunacion']}</span></td>
    </tr>
    <tr>
      <td>Fecha de revacunación:</td>
      <td><span>{$vacuna2['fechaRevacunacion']}</span></td>
    </tr>
    <tr>
      <td>Fecha de expiración del producto:</td>
      <td><span>{$vacuna2['fechaExpiracion']}</span></td>
    </tr>
    <tr>
      <td>Lote:</td>
      <td><span>{$vacuna2['lote']}</span></td>
    </tr>
    <tr>
      <td>N° de Registro:</td>
      <td><span>{$vacuna2['registro']}</span></td>
    </tr>
    <tr>
      <td>Laboratorio:</td>
      <td><span>{$vacuna2['laboratorio']}</span></td>
    </tr>
  </table>
  


    <h2>6. Titulación de Anticuerpos</h2>

    <table>
    <tr>
      <th>Categoría</th>
      <th>Valor</th>
    </tr>
    <tr>
      <td>Fecha de toma de la muestra:</td>
      <td><span>{$titulacionAnticuerpos['fechaTomaMuestra']}</span></td>
    </tr>
    <tr>
      <td>Fecha de resultado:</td>
      <td><span>{$titulacionAnticuerpos['fechaResultado']}</span></td>
    </tr>
    <tr>
      <td>Resultado (al menos 0.5 UI/ml):</td>
      <td><span>{$titulacionAnticuerpos['resultadoAnticuerpos']}</span></td>
    </tr>
    <tr>
      <td>CZE: envío de la muestra</td>
      <td><span>{$titulacionAnticuerpos['czeEnvioMuestra']}</span></td>
    </tr>
  </table>
  

    
    <h2>7. Desparasitaciones</h2>

    <h3>a. Tipo Interna</h3>
    <table>
  <tr>
    <th>Categoría</th>
    <th>Valor</th>
  </tr>
  <tr>
    <td>Fecha de aplicación:</td>
    <td><span>{$desparasitaciones['interna']['fechaAplicacion']}</span></td>
  </tr>
  <tr>
    <td>Hora:</td>
    <td><span>{$desparasitaciones['interna']['horaAplicacion']}</span></td>
  </tr>
  <tr>
    <td>Nombre comercial:</td>
    <td><span>{$desparasitaciones['interna']['nombreComercial']}</span></td>
  </tr>
  <tr>
    <td>Fabricante del producto:</td>
    <td><span>{$desparasitaciones['interna']['fabricante']}</span></td>
  </tr>
  <tr>
    <td>Principio activo:</td>
    <td><span>{$desparasitaciones['interna']['principioActivo']}</span></td>
  </tr>
  <tr>
    <td>Dosis:</td>
    <td><span>{$desparasitaciones['interna']['dosis']}</span></td>
  </tr>
</table>


    <h3>b. Tipo Externa</h3>
    <table>
  <tr>
    <th>Categoría</th>
    <th>Valor</th>
  </tr>
  <tr>
    <td>Fecha de aplicación:</td>
    <td><span>{$desparasitaciones['externa']['fechaAplicacion']}</span></td>
  </tr>
  <tr>
    <td>Hora:</td>
    <td><span>{$desparasitaciones['externa']['horaAplicacion']}</span></td>
  </tr>
  <tr>
    <td>Nombre comercial:</td>
    <td><span>{$desparasitaciones['externa']['nombreComercial']}</span></td>
  </tr>
  <tr>
    <td>Fabricante del producto:</td>
    <td><span>{$desparasitaciones['externa']['fabricante']}</span></td>
  </tr>
  <tr>
    <td>Principio activo:</td>
    <td><span>{$desparasitaciones['externa']['principioActivo']}</span></td>
  </tr>
  <tr>
    <td>Dosis:</td>
    <td><span>{$desparasitaciones['externa']['dosis']}</span></td>
  </tr>
</table><br><br><br><br>


    <h2>8. Observaciones</h2>
    <p>Observaciones: $observaciones</p><br><br><br><br>

    <!-- Firma de Responsabilidad -->
    <h2>Firma de Responsabilidad</h2>
    <table>
  <tr>
    <th>Categoría</th>
    <th>Valor</th>
  </tr>
  <tr>
    <td>Fecha de examen clínico</td>
    <td><span>{$_POST['examenClinicofecha']}</span></td>
  </tr>
  <tr>
    <td>Nombre del Médico Veterinario:</td>
    <td><span>{$firmaResponsabilidad['nombreVeterinario']}</span></td>
  </tr>
  <tr>
    <td>N° Registro en el Senecyt:</td>
    <td><span>{$firmaResponsabilidad['registroSenecyt']}</span></td>
  </tr>
  <tr>
    <td>CI/CC:</td>
    <td><span>{$firmaResponsabilidad['ciCc']}</span></td>
  </tr>
  <tr>
    <td>Firma de Responsabilidad</td>
    <td><span></span></td>
  </tr>
</table>


    <span>1 Rabia.- la vacuna vigente tiene que haber sido aplicada posterior a la identificacion con el microchip.</span><br>
    <span>2 Titulación de Anticuerpos.- Es necesario realizar esta prueba solo si el país destino solicita.</span><br>    
    <span><strong>Nota:</strong>Este documento no reemplaza el Certificado Zoosanitario de Exportacion emitido por la Agencia de Regulación y Control Fito y Zoosanitario</span><br>    
</body>
    ";

    
// Crear un objeto mpdf
$mpdf = new Mpdf();
//$mpdf->showImageErrors = true;
// Generar el PDF
$mpdf->WriteHTML($html);

// Enviar el PDF al navegador y mostrarlo en una nueva ventana
$mpdf->Output('certificado.pdf', 'I'); // 'I' para abrir en el navegador
exit;

?>