<?php
 /**
 * Controlador SolicitudAsignacionCuv
 *
 * Este archivo controla la lógica del negocio del modelo:  SolicitudAsignacionCuvModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2023-03-21
 * @uses    SolicitudAsignacionCuvControlador
 * @package AsignacionCuv
 * @subpackage Controladores
 */
 namespace Agrodb\AsignacionCuv\Controladores;
 use Agrodb\AsignacionCuv\Modelos\DistribucionInicialCuvLogicaNegocio;
 use Agrodb\AsignacionCuv\Modelos\DistribucionInicialCuvModelo;
 use Agrodb\AsignacionCuv\Modelos\EntregasCuvLogicaNegocio;
 use Agrodb\AsignacionCuv\Modelos\EntregasCuvModelo;
 use Agrodb\AsignacionCuv\Modelos\SolicitudAsignacionCuvLogicaNegocio;
 use Agrodb\AsignacionCuv\Modelos\SolicitudAsignacionCuvModelo;
 use Agrodb\Catalogos\Modelos\LocalizacionLogicaNegocio;
 use Agrodb\Catalogos\Modelos\LocalizacionModelo;
 use Agrodb\GUath\Modelos\FichaEmpleadoLogicaNegocio;
 use Agrodb\Core\Constantes;

 
class SolicitudAsignacionCuvControlador extends BaseControlador 
{

		 private $lNegocioSolicitudAsignacionCuv = null;
		 private $modeloSolicitudAsignacionCuv = null;
		 private $lNegocioLocalizacion = null;
		 private $modeloLocalizacion = null;
		 private $lNegocioFichaEmpleado = null;
		 private $lNegocioEntregasCuv = null;
		 private $modeloEntregasCuv = null;
		 private $accion = null;
		 private $operadorIdentificador = null;
		 private $datosResultado = null;
		 private $lNegocioDistribucionInicialCuv = null;
		 private $modeloDistribucionInicialCuv = null;
		 private $numeroCeros = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		$this->lNegocioLocalizacion = new LocalizacionLogicaNegocio();
		 $this->lNegocioSolicitudAsignacionCuv = new SolicitudAsignacionCuvLogicaNegocio();
		 $this->lNegocioFichaEmpleado = new FichaEmpleadoLogicaNegocio();
		 $this->modeloSolicitudAsignacionCuv = new SolicitudAsignacionCuvModelo();
		 $this->modeloLocalizacion = new LocalizacionModelo();
		 $this->lNegocioEntregasCuv = new EntregasCuvLogicaNegocio();
		 $this->modeloEntregasCuv = new EntregasCuvModelo();
		 $this->lNegocioDistribucionInicialCuv = new DistribucionInicialCuvLogicaNegocio();
		 $this->modeloDistribucionInicialCuv = new DistribucionInicialCuvModelo();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	
		/**
		* Método para buscar si el usuario es interno o externo
		*/
		public function esInternoExterno($identificador){
			$resultadoUsuarioInterno = $this->lNegocioFichaEmpleado->buscarDatosUsuarioContrato($identificador);
			if(isset($resultadoUsuarioInterno->current()->identificador)){
				return $tipoUsuario = "Interno";
			}else{
				return $tipoUsuario = "Externo";
			}
		}
			/**
		* Método para buscar si el usuario es interno o externo
		*/
		public function cargarDatosIntExt($tipoUsuarioParam, $identificador){
			if(isset($tipoUsuarioParam) && $tipoUsuarioParam == "Externo"){
			$datosOperador = $this->lNegocioSolicitudAsignacionCuv->buscarDatosDelOperadorIoTPC($identificador);
			foreach ($datosOperador as $fila){
				$array = [
					'identificador_operador' => $fila['identificador_operador'],
					'nombre_razon_social' => $fila['nombre_razon_social']
				];
				return $array;
			}
			}else{

			}
		}
				/**
		* Método para cargar tabla lista segun sea interno o externo
		*/
		public function cargarListaInternoExterno($tipoUsuarioParam, $identificadorParam){
			if(isset($tipoUsuarioParam) && $tipoUsuarioParam == "Interno"){
				$tipoUsuario = "Interno";
				$modeloSolicitudAsignacionCuv = $this->lNegocioSolicitudAsignacionCuv->buscarSolicitudAsignacionCuvPendientes();
				$this->tablaHtmlSolicitudAsignacionCuv($modeloSolicitudAsignacionCuv);
				require APP . 'AsignacionCuv/vistas/listaSolicitudAsignacionCuvVista.php';
			}else{
				$tipoUsuario = "Externo";
				$modeloSolicitudAsignacionCuv = $this->lNegocioSolicitudAsignacionCuv->buscarSolicitudAsignacionCuvExternos($identificadorParam);
				$this->tablaHtmlSolicitudAsignacionCuv($modeloSolicitudAsignacionCuv);
				require APP . 'AsignacionCuv/vistas/listaSolicitudAsignacionCuvVista.php';
			}
		}
		public function index()
		{
		$identificador = $this->usuarioActivo();
		$tipoUsuario = $this->esInternoExterno($identificador);
		$operadorSolicitante = $this->cargarDatosIntExt($tipoUsuario,$identificador);
		if (isset($operadorSolicitante)) {
			# code...
			$_SESSION['identificador_operador'] = $operadorSolicitante['identificador_operador'];
			$_SESSION['nombre_razon_social'] = $operadorSolicitante['nombre_razon_social'];
			$this->operadorIdentificador = $operadorSolicitante['identificador_operador'];
		}
		$this->cargarPanelAdministracion();
		$this->cargarListaInternoExterno($tipoUsuario,$identificador);
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo SolicitudAsignacionCuv"; 
		 require APP . 'AsignacionCuv/vistas/formularioSolicitudAsignacionCuvVista.php';
		}	/**
		* Método para registrar en la base de datos -SolicitudAsignacionCuv
		*/
		public function guardar()
		{
			$_POST['array_cuv'] = json_decode($_POST['array_cuv'], true);

		foreach ($_POST['array_cuv'] as $value) {
			$array = [
				'id_solicitud_asignacion_cuv' => '',
				'id_provincia' => $value['id_provincia'],
				'provincia' => $value['provincia'],
				'siglas' => 'PPC',
				'operador_solicitante' => $_SESSION['nombre_razon_social'],
				'operador_solicitante_identificador' => $_SESSION['usuario'],
				'cantidad_solicitada' => $value['cantidad'],
				'tecnico_aprobo' => '',
				'estado_solicitud' => 'Pendiente',
				'estado' => 1,
				'observaciones' => '',
				'fecha_creacion' => $value['fecha'],
			];
			//var_dump($array);
			$this->lNegocioSolicitudAsignacionCuv->guardar($array);
		}	
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: SolicitudAsignacionCuv
		*/
		public function editar()
		{
			$identificador = $this->usuarioActivo();
			$tipoUsuario = $this->esInternoExterno($identificador);
			echo ($tipoUsuario);
			if(isset($tipoUsuario) && $tipoUsuario == "Interno"){
				$this->accion = "Revisión de solicitud asignación de CUV";
				$this->numeroCeros = Constantes::NUMERO_CEROS;
				$this->modeloSolicitudAsignacionCuv = $this->lNegocioSolicitudAsignacionCuv->buscar($_POST["id"]);
				require APP . 'AsignacionCuv/vistas/formularioRevisionSolicitudAsignacionCuv.php';
			}else{
				$this->accion = "Editar SolicitudAsignacionCuv";
				$this->modeloSolicitudAsignacionCuv = $this->lNegocioSolicitudAsignacionCuv->buscar($_POST["id"]);
				$this->datosResultado = $this->construirResultadoSolicitud($this->modeloSolicitudAsignacionCuv);
				require APP . 'AsignacionCuv/vistas/formularioSolicitudAsignacionCuvVista.php';
			}
		}	/**
		* Método para borrar un registro en la base de datos - SolicitudAsignacionCuv
		*/
		public function borrar()
		{
		  $this->lNegocioSolicitudAsignacionCuv->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - SolicitudAsignacionCuv
		*/
		public function tablaHtmlSolicitudAsignacionCuv($tabla) {
			$contador = 0;
			foreach ($tabla as $fila) {
				$fechaCreacion = date('d-m-Y', strtotime($fila['fecha_creacion']));
				$this->itemsFiltrados[] = array(
					'<tr id="' . $fila['id_solicitud_asignacion_cuv'] . '"
					class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'AsignacionCuv\SolicitudAsignacionCuv"
					data-opcion="editar" ondragstart="drag(event)" draggable="true"
					data-destino="detalleItem">
					<td>' . ++$contador . '</td>
					<td>' . $fechaCreacion . '</td>
					<td>' . $fila['provincia'] . '</td>
					<td>' . $fila['cantidad_solicitada'] . '</td>
					<td>' . $fila['estado_solicitud'] . '</td>
					</tr>'
				);
			}
		}
		

		/**
		* Método para obtener los atributos de la provincia, obtenidos por el id
		*/
		public function obtenerProvincia()
		{
			$id_provincia = (int)$_POST['idProvincia'];
			$valor = $this->modeloLocalizacion = $this->lNegocioLocalizacion->buscar($id_provincia);
		if ($valor->getIdLocalizacion() != null) {
			$resultado = array(
				'idProvincia' => $valor->getIdLocalizacion(),
				'nombreProvincia' => $valor->getNombre()
			);
			$mensaje = 'Se encontro el valor';
			$validacion = 'Exito'; 
		}
			echo json_encode(array(
				'mensaje' => $mensaje,
				'validacion' => $validacion,
				'resultado' => $resultado
			));
		}

		public function cargarPanelAdministracion()
		{
			$fechaInicioLimite = date('Y-m-d', strtotime('-3 months'));
			$this->operadorIdentificador;
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
						<td>Provincia:</td>
						<td colspan="4">
							<select id="provincia" name="provincia" style="width: 100%;">
								<option value="">Seleccione...</option>
								' . $this->comboProvinciasEc() . '
							</select>
						</td>                                     
                    </tr>
					<tr>
						<td>Estado:</td>
						<td colspan="4">
							<select id="estado_solicitud" name="estado_solicitud" style="width: 100%;">
								<option value="">Seleccione...</option>
								' . $this->comboEstadoSolicitudCUV() . '
							</select>
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

	public function filtroBuscarSolicitud()
	{
		$fechaInicio = $_POST['fechaInicio'];
		$fechaFin = $_POST['fechaFin'];
		$idProvincia = $_POST['provincia'];
		$estado_solicitud = $_POST['estado_solicitud'];
		$arrayParametros = [
			'fechaInicio' => $fechaInicio,
			'fechaFin' => $fechaFin,
			'idProvincia' => $idProvincia,
			'estado_solicitud' => $estado_solicitud,
			'identificador_operador' => $_SESSION['identificador_operador'],
		];
		if ($fechaInicio != "" && $fechaFin != "" && $idProvincia != "" && $estado_solicitud != "" || $fechaInicio != 0 && $fechaFin != 0 && $idProvincia != 0 && $estado_solicitud != 0) {
			# code...
			$valor = $this->lNegocioSolicitudAsignacionCuv->buscarSolicitudesFechasProv($arrayParametros);
			if($valor->count()){
				$this->tablaHtmlSolicitudAsignacionCuv($valor);
				$resultado = \Zend\Json\Json::encode($this->itemsFiltrados);
				echo json_encode(
					array(
						'validacion' => 'Exito',
						'mensaje' => 'Se encontro el valor',
						'resultado' => $resultado
					)
				);
			} else {
				echo json_encode(
					array(
						'validacion' => 'Fallo',
						'mensaje' => 'No se encontro el valor',
						'resultado' => ''
					)
				);
			}
		} else {
			# code...
			echo json_encode(
				array(
					'validacion' => 'Fallo',
					'mensaje' => 'Por favor seleccione todos los datos para Buscar la Solicitud.',
					'resultado' => ''
				)
			);
		}

	}

//SELECT * FROM g_asignacion_cuv.distribucion_inicial_cuv dicv WHERE dicv.id_provincia='241' AND dicv.prefijo_cuv_numerico = '001' AND dicv.anio = '2000'
	public function disponibilidadProvincia()
	{
		$mensaje = "";
		$validacion = "";
		$resultado = "";
		$idProvincia = $_POST['idProvincia'];
		$prefijoCuvNumerico = $_POST['prefijoCuvNumerico'];
		$anio = $_POST['anio'];
		$arrayParametros = [
			'idProvincia' => $idProvincia,
			'prefijoCuvNumerico' => $prefijoCuvNumerico,
			'anio' => $anio,
		];

		$valor = $this->modeloSolicitudAsignacionCuv = $this->lNegocioSolicitudAsignacionCuv->buscarDisponibilidadCuvDifirencia($arrayParametros);
		if ($valor->count() != 0) {
			foreach ($valor as $fila) {
				$cantidad = $fila['cantidad'];
				$siglas = $fila['siglas'];
				$anio = $fila['anio'];
				$prefijo_cuv_numerico = $fila['prefijo_cuv_numerico'];
				$codigo_cuv_inicio = $fila['codigo_cuv_inicio'];
				$codigo_cuv_fin = $fila['codigo_cuv_fin'];
				$provincia = $fila['provincia'];
				$diferencia = $fila['diferencia'];
				$resultado = array(
					'cantidad' => $cantidad,
					'siglas' => $siglas,
					'anio' => $anio,
					'prefijo_cuv_numerico' => $prefijo_cuv_numerico,
					'codigo_cuv_inicio' => $codigo_cuv_inicio,
					'codigo_cuv_fin' => $codigo_cuv_fin,
					'provincia' => $provincia,
					'diferencia' => $diferencia,
				);
				$mensaje = "Se encontro el valor";
				$validacion = 'Exito';
			}
		}
		else {
			$resultado = '';
			$validacion = 'Fallo';
			$mensaje = "No se encontro el valor";
		}
		echo json_encode(array(
            'mensaje' => $mensaje,
            'validacion' => $validacion,
            'resultado' => $resultado
        ));

	}

	public function obtenerSeries()
	{
		$mensaje = "";
		$validacion = "";
		$resultado = "";
		$idProvincia = $_POST['idProvincia'];
		$anio = $_POST['anio'];
		$cantidadAsignar = $_POST['cantidadAsignar'];
		$prefijoCuvNumerico = $_POST['prefijoCuvNumerico'];
		$provincia_nombre = $_POST['provincia_nombre'];
		$arrayParametros = [
			'idProvincia' => $idProvincia,
			'prefijoCuvNumerico' => $prefijoCuvNumerico,
			'anio' => $anio,
			'cantidadAsignar' => $cantidadAsignar,
			'provincia_nombre' => $provincia_nombre,
		];
		$entregas_cuv = $this->modeloEntregasCuv = $this->lNegocioEntregasCuv->buscarCodigoCuvFinPorProvinciaAnioPrefijo($arrayParametros);
		if ($entregas_cuv->count() != 0) {
			foreach ($entregas_cuv as $entreCuv) {
				//var_dump($entreCuv);
				$resultado = $entreCuv;
				$mensaje = "Se encontro el valor";
				$validacion = 'ExitoEntregaCuv';
			}
		}else {
			$distribucionInicial = $this->modeloDistribucionInicialCuv = $this->lNegocioDistribucionInicialCuv->rangoCuvInicioFin($arrayParametros);
			if ($distribucionInicial->count() != 0) {
				foreach ($distribucionInicial as $disInicial) {
					$resultado = $disInicial;
					$mensaje = "Se encontro el valor";
					$validacion = 'ExitoInicial';
				}
			} else {
				$resultado = '';
				$validacion = 'Fallo';
				$mensaje = "No se encontro el valor";
			}
		}
		echo json_encode(array(
            'mensaje' => $mensaje,
            'validacion' => $validacion,
            'resultado' => $resultado
        ));
	}
		
	public function aprobarSolicitud()
	{
		$mensaje = "";
		$validacion = "";
		$resultado = "";
		$accion = $_POST['accion'];
		//$idProvincia = $_POST['id_provincia'];
		$observaciones = $_POST['observaciones'];
		$nombreTecnico = $_SESSION['datosUsuario'];
		$identificadorTecnico = $_SESSION['usuario'];
		
		if ($accion == 'aprobar') {
			// Acción para aprobar
			$array = [
				'id_solicitud_asignacion_cuv' => $_POST['idSolicitudAsignacion'],
				'estado_solicitud' => 'Aprobada',
				'tecnico_aprobo' => $nombreTecnico,
				'tecnico_aprobo_identificador' => $identificadorTecnico,
				'observaciones' => $observaciones,
				'anio' => $_POST['anio'],
				'prefijo_cuv_numerico' => $_POST['prefijoCuvNumerico'],
			];
			$arrayEntregas = [
				'id_solicitud_asignacion_cuv' => $_POST['idSolicitudAsignacion'],
				'codigo_cuv_inicio' => $_POST['codigoInicio'],
				'codigo_cuv_fin' => $_POST['codigoFin'],
				'cantidad' => $_POST['cantidadAsignar'],
				'estado' => '1',
				'fecha_entrega' => date("Y-m-d")
			];
			$this->modeloDistribucionInicialCuv = $this->lNegocioSolicitudAsignacionCuv->guardar($array);
			$this-> lNegocioEntregasCuv->guardar($arrayEntregas);
		} elseif ($accion == 'rechazar') {
			// Acción para rechazar
			$array = [
				'id_solicitud_asignacion_cuv' => $_POST['idSolicitudAsignacion'],
				'estado_solicitud' => 'Rechazada',
				'tecnico_aprobo' => $nombreTecnico,
				'tecnico_aprobo_identificador' => $identificadorTecnico,
				'observaciones' => $observaciones,
			];
			$this->modeloDistribucionInicialCuv = $this->lNegocioSolicitudAsignacionCuv->guardar($array);
		} else {
			// Acción predeterminada si no se selecciona nada
		}
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
		$id_solicitud = $_POST['id_solicitud_asignacion_cuv'];
		$fecha_actual = date('Y-m-d H:i:s'); // Fecha y hora actual en formato "AAAA-MM-DD HH:MM:SS"
		$nombreDocumento = "ACTA_ENTREGA-RECEPCION_" . $anio . "_" . $mes . "_" . $dia . "_".$hora.$minutos.$segundos;
		//echo ($id_solicitud);

		if (strlen($id_solicitud)>0) {
			$this->lNegocioSolicitudAsignacionCuv->generarCertificado($id_solicitud,$nombreDocumento);
			$contenido = SOLIC_CUV_URL . "certificado/" . $anio . "/" . $mes . "/" . $dia . "/" . $nombreDocumento . ".pdf";
			$mensaje = "Certificado generado con éxito";
			$validacion = 'Exito';
        } else {
            $mensaje = 'No se pudo generar el certificado';
            $estado = 'FALLO';
        }
		echo json_encode(array(
            'mensaje' => $mensaje,
            'validacion' => $validacion,
            'contenido' => SOLIC_CUV_URL . "certificado/" . $anio . "/" . $mes . "/" . $dia . "/" . $nombreDocumento . ".pdf"
        ));
	}
	    /**
     * Método para desplegar el certificado PDF
     */
    public function mostrarReporte()
    {
        $this->urlPdf = $_POST['id'];
        require APP . 'AsignacionCuv/vistas/visorPDF.php';
    }
}