<?php
 /**
 * Controlador SolicitudRedistribucionCuv
 *
 * Este archivo controla la lógica del negocio del modelo:  SolicitudRedistribucionCuvModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2023-03-21
 * @uses    RevisionSolicitudRedistribucionCuvControlador
 * @package AsignacionCuv
 * @subpackage Controladores
 */
 namespace Agrodb\AsignacionCuv\Controladores;
 use Agrodb\AsignacionCuv\Modelos\RedistribucionCuvLogicaNegocio;
 use Agrodb\AsignacionCuv\Modelos\SolicitudRedistribucionCuvLogicaNegocio;
 use Agrodb\AsignacionCuv\Modelos\SolicitudRedistribucionCuvModelo;
 use Agrodb\Core\Constantes;

 
class RevisionSolicitudRedistribucionCuvControlador extends BaseControlador 
{

		 private $lNegocioSolicitudRedistribucionCuv = null;
		 private $modeloSolicitudRedistribucionCuv = null;
		 private $accion = null;
		 private $lNegocioRedistribucionCuv = null;
		 private $numeroCeros = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioSolicitudRedistribucionCuv = new SolicitudRedistribucionCuvLogicaNegocio();
		 $this->lNegocioRedistribucionCuv = new RedistribucionCuvLogicaNegocio();
		 $this->modeloSolicitudRedistribucionCuv = new SolicitudRedistribucionCuvModelo();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloSolicitudRedistribucionCuv = $this->lNegocioSolicitudRedistribucionCuv->buscarSolicitudRedistribucionCuvPorEstadoPendiente();
		$this->cargarPanelAdministracion();
		 $this->tablaHtmlRevisionSolicitudRedistribucionCuv($modeloSolicitudRedistribucionCuv);
		 require APP . 'AsignacionCuv/vistas/listaSolicitudRevisionRedistribucionCuvVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Revisión de Solicitudes de Redistribución"; 
		 require APP . 'AsignacionCuv/vistas/mensajeRevisionSolicitudRedistribucion.php';
		}	/**
		* Método para registrar en la base de datos -SolicitudRedistribucionCuv
		*/
		public function guardar()
		{
		  $_POST['array_cuv'] = json_decode($_POST['array_cuv'], true);
		  foreach ($_POST['array_cuv'] as $value) {
			$array = [
				'id_solicitud_redistribucion_cuv' => '',
				'anio' => $value['anio'],
				'prefijo_cuv_numerico' => $value['prefijo_cuv_numerico'],
				'id_provincia_destino' => $value['idProvincia'],
				'provincia_destino' => $value['provincia'],
				'cantidad_solicitada' => $value['cantidad'],
				'siglas' => 'PPC',
				'tecnico_provincia' => $value['solicitante'],
				'tecnico_planta_central' => '',
				'estado_solicitud' => 'Pendiente',
				'estado' => '1',
				'observaciones' => '',
				'tecnico_provincia_identificador' => $_SESSION['usuario'],
				'tecnico_planta_central_identificador' => '',
				'fecha_creacion' => $value['fechaCreacion'],
				
			];
		  }
		  $this->lNegocioSolicitudRedistribucionCuv->guardar($array);
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: SolicitudRedistribucionCuv
		*/
		public function editar()
		{
		 $this->accion = "Revisión de solicitud de redistribución"; 
		 $this->numeroCeros = Constantes::NUMERO_CEROS;
		 $this->modeloSolicitudRedistribucionCuv = $this->lNegocioSolicitudRedistribucionCuv->buscar($_POST["id"]);
		 require APP . 'AsignacionCuv/vistas/formularioRevisionSolicitudRedistribucionCuvVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - SolicitudRedistribucionCuv
		*/
		public function borrar()
		{
		  $this->lNegocioSolicitudRedistribucionCuv->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - SolicitudRedistribucionCuv
		*/
		 public function tablaHtmlRevisionSolicitudRedistribucionCuv($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_solicitud_redistribucion_cuv'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'AsignacionCuv\RevisionSolicitudRedistribucionCuv"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['fecha_creacion'] . '</b></td>
<td>'
		  . $fila['tecnico_provincia'] . '</td>
<td>' . $fila['provincia_origen']
		  . '</td>
<td>' . $fila['cantidad_solicitada'] . '</td>
<td>' . $fila['estado_solicitud'] . '</td>
</tr>');
		}
		}
	}


	public function cargarPanelAdministracion()
	{
		$this->panelBusquedaAdministrador = '
		<table class="filtro" style="width: 100%; text-align:left;">
			<tbody>
				<tr>
					<th colspan="4">Buscar Solicitud:</th>
				</tr>
				<tr>
					<td>Fecha inicio:</td>
					<td colspan="2"><input type="text" id="fechaInicio" name="fechaInicio"></td>                                           
					<td>Fecha fin:</td>
					<td colspan="2"><input type="text" id="fechaFin" name="fechaFin"></td>                                           
				</tr>
				<tr>
					<td>Estado:</td>
					<td colspan="4">
                    ' . $this->comboEstadosSolicitudRedistribucion("Seleccionar...") . '
                </td>                                
				</tr>
				<tr>
				<td colspan="6" style="text-align: end;">
					<button type="submit" id="btnFiltrar">Buscar</button>
				</td>
			</tr>
			</tbody>
		</table>';
	}


	/**
 * Realiza una búsqueda de solicitudes de asignación CUV basada en los filtros proporcionados.
 */
public function cantidadDisponibleProvinciaOrigen()
{
    // Obtener valores de campos de búsqueda desde la solicitud POST.
    $idProvincia = $_POST['idProvincia'];
    $prefijo_cuv_numerico = $_POST['prefijo_cuv_numerico'];
    $anio = $_POST['anio'];

    // Preparar parámetros para la búsqueda.
    $arrayParametros = [
        'idProvincia' => $idProvincia,
        'prefijo_cuv_numerico' => $prefijo_cuv_numerico,
        'anio' => $anio
    ];

    // Comprobar si se proporcionaron valores válidos para la búsqueda.
    if (
        ($idProvincia != "" && $prefijo_cuv_numerico != "" && $anio != "" ) || ($idProvincia != 0 && $prefijo_cuv_numerico != 0 && $anio != 0)
    ) {
        // Realizar búsqueda de las solicitudes según los parámetros.
        $valor = $this->lNegocioSolicitudRedistribucionCuv->calculoRedisAsignaciEnviadaProvincia($arrayParametros);

        // Comprobar si se encontraron resultados.
        if ($valor->count()) {
			foreach ($valor as $fila) {
				$provincia = $fila['provincia'];
				$cantidad_inicial = $fila['cantidad_inicial'];
				$cantidad_asignada = $fila['cantidad_asignada'];
				$cantidad_redistribuida_enviada = $fila['cantidad_redistribuida_enviada'];

				$resultado = array(
					'provincia' => $provincia,
					'cantidad_inicial' => $cantidad_inicial,
					'cantidad_asignada' => $cantidad_asignada,
					'cantidad_redistribuida_enviada' => $cantidad_redistribuida_enviada
				);
				$mensaje = "Se encontro el valor";
				$validacion = 'Exito';
			}
        } else {
				$resultado = '';
				$mensaje = "No se encontraron resultados de disponibilidad en Provincia,(Por favor Ingrese la distribución Inicial en Provincia.)";
				$validacion = 'Fallo';

        }
		            // Devolver mensaje de error si no se encontraron resultados.
					echo json_encode(
						[
							'validacion' => $validacion,
							'mensaje' => $mensaje,
							'resultado' => $resultado
						]
					);
    } else {
        // Devolver mensaje de error si los valores de búsqueda son inválidos o incompletos.
        echo json_encode(
            [
                'validacion' => 'Fallo',
                'mensaje' => 'Por favor seleccione todos los datos para buscar la solicitud.',
                'resultado' => ''
            ]
        );
    }
}

public function calcularUltimaSerieProvinciaOrigen(){
	// Obtener valores de campos de búsqueda desde la solicitud POST.
	$idProvincia = $_POST['idProvincia'];
	$prefijo_cuv_numerico = $_POST['prefijo_cuv_numerico'];
	$anio = $_POST['anio'];
	// Preparar parámetros para la búsqueda.
	$arrayParametros = [
		'idProvincia' => $idProvincia,
		'prefijo_cuv_numerico' => $prefijo_cuv_numerico,
		'anio' => $anio
	];
	$valor = $this->lNegocioSolicitudRedistribucionCuv->ultimaSerieProvinciaOrigen($arrayParametros);
	// Comprobar si se encontraron resultados.
	if ($valor->count()) {
		foreach ($valor as $fila) {
			//$resultado[] = $fila;
			//$mensaje = "Se encontro el valor";
			//$validacion = 'Exito';
			$resultados[] = $fila; // La matriz de objetos JSON
			$maxCodigoCuvFin = 0;
			foreach ($resultados as $objeto) {
				$codigoCuvFin = $objeto['codigo_cuv_fin'];
				if ($codigoCuvFin !== null) {
					$maxCodigoCuvFin = max($maxCodigoCuvFin, intval($codigoCuvFin));
				}
			}
		}
		$resultado = $maxCodigoCuvFin;
		$mensaje = "Se encontro el valor";
		$validacion = 'Exito';
	} else {
		// Devolver mensaje de error si no se encontraron resultados.
		$resultado = '';
		$mensaje = "Por favor tiene que hacer una Asignacion Primero, o no hay una distribucion Inicial de la provincia";
		$validacion = 'Fallo';
	}
	echo json_encode(array(
		'mensaje' => $mensaje,
		'validacion' => $validacion,
		'resultado' => $resultado
	));
}


	public function aprobarSolicitudTecnicoPlantaCentral()
	{
		$accion = $_POST['accion'];
		$nombreTecnico = $_SESSION['datosUsuario'];
		$identificadorTecnico = $_SESSION['usuario'];
		if ($accion == 'aprobar') {
			$_POST['array_cuv'] = json_decode($_POST['array_cuv'], true);
			foreach ($_POST['array_cuv'] as $value) {
				$array = [
					'id_solicitud_redistribucion_cuv' => $_POST['id_solicitud_redistribucion_cuv'],
					'estado_solicitud' => 'Pendiente Envío',
					'tecnico_planta_central_identificador' => $identificadorTecnico,
					'tecnico_planta_central' => $nombreTecnico,
					'id_provincia_origen' => $value['idProvincia'],
					'provincia_origen' => $value['provincia'],
					'observaciones' => $value['observaciones'],
					'prefijo_cuv_numerico' => $value['prefijo_cuv_numerico'],
				];
				$arrayRedistribucionEntrega = [
					'id_solicitud_redistribucion_cuv' => $_POST['id_solicitud_redistribucion_cuv'],
					'codigo_cuv_inicio' => $value['inicioCuvSerie'],
					'codigo_cuv_fin' => $value['finCuvSerie'],
					'estado' => '1',
					'fecha_redistribucion' => date("Y-m-d"),
					'cantidad_reasignada' => $value['cantidadReasignar'],
				];
				$this->lNegocioSolicitudRedistribucionCuv->guardar($array);
				$this->lNegocioRedistribucionCuv->guardar($arrayRedistribucionEntrega);
			}
		} elseif ($accion == 'rechazar') {
			$array = [
				'id_solicitud_redistribucion_cuv' => $_POST['id_solicitud_redistribucion_cuv'],
				'estado_solicitud' => 'Rechazada',
				'tecnico_planta_central_identificador' => $identificadorTecnico,
				'tecnico_planta_central' => $nombreTecnico,
				'observaciones' => $_POST['id_solicitud_redistribucion_cuv']
			];
			$this->lNegocioSolicitudRedistribucionCuv->guardar($array);
		}
	}
}
