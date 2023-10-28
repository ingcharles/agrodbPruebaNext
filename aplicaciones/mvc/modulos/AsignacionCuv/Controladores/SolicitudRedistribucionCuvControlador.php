<?php
 /**
 * Controlador SolicitudRedistribucionCuv
 *
 * Este archivo controla la lógica del negocio del modelo:  SolicitudRedistribucionCuvModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2023-03-21
 * @uses    SolicitudRedistribucionCuvControlador
 * @package AsignacionCuv
 * @subpackage Controladores
 */
 namespace Agrodb\AsignacionCuv\Controladores;
 use Agrodb\AsignacionCuv\Modelos\RedistribucionCuvLogicaNegocio;
 use Agrodb\AsignacionCuv\Modelos\RedistribucionCuvModelo;
 use Agrodb\AsignacionCuv\Modelos\SolicitudRedistribucionCuvLogicaNegocio;
 use Agrodb\AsignacionCuv\Modelos\SolicitudRedistribucionCuvModelo;
 
class SolicitudRedistribucionCuvControlador extends BaseControlador 
{

		 private $lNegocioSolicitudRedistribucionCuv = null;
		 private $modeloSolicitudRedistribucionCuv = null;
		 private $accion = null;
		 private $estadoSolicitudTemp = null;
		 private $datosResultadoRedistribucion = null;
		 private $lNegocioRedistribucionCuv = null;
		 private $modeloRedistribucionCuv = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioSolicitudRedistribucionCuv = new SolicitudRedistribucionCuvLogicaNegocio();
		 $this->modeloSolicitudRedistribucionCuv = new SolicitudRedistribucionCuvModelo();
		 $this->lNegocioRedistribucionCuv = new RedistribucionCuvLogicaNegocio();
		 $this->modeloRedistribucionCuv = new RedistribucionCuvModelo();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloSolicitudRedistribucionCuv = $this->lNegocioSolicitudRedistribucionCuv->buscarSolicitudRedistribucionCuvPorCedula($_SESSION['usuario']);
		$this->cargarPanelAdministracion();
		 $this->tablaHtmlSolicitudRedistribucionCuv($modeloSolicitudRedistribucionCuv);
		 require APP . 'AsignacionCuv/vistas/listaSolicitudRedistribucionCuvVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo SolicitudRedistribucionCuv"; 
		 require APP . 'AsignacionCuv/vistas/formularioSolicitudRedistribucionCuvVista.php';
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
		 $this->accion = "Editar SolicitudRedistribucionCuv"; 
		 $this->modeloSolicitudRedistribucionCuv = $this->lNegocioSolicitudRedistribucionCuv->buscar($_POST["id"]);
		 $this->modeloRedistribucionCuv= $this->lNegocioRedistribucionCuv->buscarRedistribucionPoridSolicitud($_POST["id"]);
		$estadoSolicitud = $this->modeloSolicitudRedistribucionCuv->getEstadoSolicitud();
		if($estadoSolicitud === 'Pendiente Envío')
		{
			require APP . 'AsignacionCuv/vistas/detalleRevisionSolucitudRedistribucion.php';
		}else if ($estadoSolicitud === 'Pendiente'){
			$this->estadoSolicitudTemp = 'Activar';
			$this->datosResultadoRedistribucion = $this->construirResultadoSolicitudRedistribucion($this->modeloSolicitudRedistribucionCuv);
			require APP . 'AsignacionCuv/vistas/formularioSolicitudRedistribucionCuvVista.php';
		}else if ($estadoSolicitud === 'Aprobado'||$estadoSolicitud === 'Rechazada'){
			$this->estadoSolicitudTemp = 'Desactivar';
			$this->datosResultadoRedistribucion = $this->construirResultadoSolicitudRedistribucion($this->modeloSolicitudRedistribucionCuv);
			require APP . 'AsignacionCuv/vistas/formularioSolicitudRedistribucionCuvVista.php';
		}
		}	/**
		* Método para borrar un registro en la base de datos - SolicitudRedistribucionCuv
		*/
		public function borrar()
		{
		  $this->lNegocioSolicitudRedistribucionCuv->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - SolicitudRedistribucionCuv
		*/
		 public function tablaHtmlSolicitudRedistribucionCuv($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_solicitud_redistribucion_cuv'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'AsignacionCuv\SolicitudRedistribucionCuv"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . date('d-m-Y', strtotime($fila['fecha_creacion'])) . '</b></td>
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
public function filtroBuscarSolicitudRedistribucion()
{
    // Obtener valores de campos de búsqueda desde la solicitud POST.
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $estadoSolicitud = $_POST['estado_solicitud'];

    // Preparar parámetros para la búsqueda.
    $arrayParametros = [
        'fechaInicio' => $fechaInicio,
        'fechaFin' => $fechaFin,
        'estado_solicitud' => $estadoSolicitud,
        'identificador_tecnico_provincia' => $_SESSION['usuario'],
    ];

    // Comprobar si se proporcionaron valores válidos para la búsqueda.
    if (
        ($fechaInicio != "" && $fechaFin != ""  && $estadoSolicitud != "") ||
        ($fechaInicio != 0 && $fechaFin != 0 && $estadoSolicitud != 0)
    ) {
        // Realizar búsqueda de las solicitudes según los parámetros.
        $valor = $this->lNegocioSolicitudRedistribucionCuv->buscarSolicitudesRedistribucionFechas($arrayParametros);

        // Comprobar si se encontraron resultados.
        if ($valor->count()) {
            // Generar tabla HTML y devolver resultados en formato JSON.
            $this->tablaHtmlSolicitudRedistribucionCuv($valor);
            $resultado = \Zend\Json\Json::encode($this->itemsFiltrados);
            echo json_encode(
                [
                    'validacion' => 'Exito',
                    'mensaje' => 'Se encontraron resultados',
                    'resultado' => $resultado
                ]
            );
        } else {
            // Devolver mensaje de error si no se encontraron resultados.
            echo json_encode(
                [
                    'validacion' => 'Fallo',
                    'mensaje' => 'No se encontraron resultados',
                    'resultado' => ''
                ]
            );
        }
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

public function enviarRedistribucion()
{
	$array = [
			'id_solicitud_redistribucion_cuv' => $_POST['id_solicitud_redistribucion_cuv'],
			'estado_solicitud' => 'Aprobado',
			'estado' => '1',
		];
		$this->lNegocioSolicitudRedistribucionCuv->guardar($array);
	}


	public function generarActaEntrega()
	{
		$mensaje = "";
		$validacion = "";
		$contenido = "";
		$anio = date('Y');
		$mes = date('m');
		$dia = date('d');
		$hora = date('H');
		$minutos = date('i');
		$segundos = date('s');
		//$id_solicitud = $_POST['idSolicitud'];
		$id_solicitud_redistribucion = $_POST['id_solicitud_redistribucion_cuv'];
		$nombreDocumento = "ACTA_ENTREGA-RECEPCION_" . $anio . "_" . $mes . "_" . $dia . "_".$hora.$minutos.$segundos;
		if (strlen($id_solicitud_redistribucion)>0) {
			$this->lNegocioSolicitudRedistribucionCuv->generarCertificado($id_solicitud_redistribucion,$nombreDocumento);
			$contenido = REDISTRI_CUV_URL . "redistribucion/" . $anio . "/" . $mes . "/" . $dia . "/" . $nombreDocumento . ".pdf";
			$mensaje = "Certificado generado con éxito";
			$validacion = 'Exito';
        } else {
            $mensaje = 'No se pudo generar el certificado';
            $estado = 'FALLO';
        }
		echo json_encode(array(
            'mensaje' => $mensaje,
            'validacion' => $validacion,
            'contenido' => REDISTRI_CUV_URL . "redistribucion/" . $anio . "/" . $mes . "/" . $dia . "/" . $nombreDocumento . ".pdf"
        ));
	}
	public function mostrarReporte()
    {
        $this->urlPdf = $_POST['id'];
        require APP . 'AsignacionCuv/vistas/visorPDF.php';
    }
}
