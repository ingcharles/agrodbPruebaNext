<?php
/**
 * Controlador CertificadoFitosanitario
 *
 * Este archivo controla la lógica del negocio del modelo: CertificadoFitosanitarioModelo y Vistas
 *
 * @author AGROCALIDAD
 * @date   2022-07-21
 * @uses CertificadoFitosanitarioControlador
 * @package CertificadoFitosanitario
 * @subpackage Controladores
 */
namespace Agrodb\CertificadoFitosanitario\Controladores;

use Agrodb\CertificadoFitosanitario\Modelos\CertificadoFitosanitarioLogicaNegocio;
use Agrodb\CertificadoFitosanitario\Modelos\CertificadoFitosanitarioModelo;
use Agrodb\CertificadoFitosanitario\Modelos\PaisesPuertosDestinoLogicaNegocio;
use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;
use Agrodb\GUath\Modelos\FichaEmpleadoLogicaNegocio;

class RevisionCertificadoFitosanitarioControlador extends BaseControlador{

	private $lNegocioCertificadoFitosanitario = null;

	private $modeloCertificadoFitosanitario = null;

	private $lNegocioPaisesPuertosDestino = null;
	
	private $lNegocioFichaEmpleado = null;
	
	private $accion = null;

	private $datosGenerales = null;

	private $datosFormaPago = null;

	private $datosProductos = null;
	
	private $datosPaisDestino = null;
	
	private $datosPuertosTransito = null;
	
	private $datosExportador = null;
	
	private $datosDocumentosAdjuntos = null;
	
	private $datosCertificadoFitosanitario = null;
	
	private $datosRevisionDocumental = null;
	
	private $panelBusquedaCertificado = null;

	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->lNegocioCertificadoFitosanitario = new CertificadoFitosanitarioLogicaNegocio();
		$this->modeloCertificadoFitosanitario = new CertificadoFitosanitarioModelo();
		$this->lNegocioPaisesPuertosDestino = new PaisesPuertosDestinoLogicaNegocio();
		$this->lNegocioFichaEmpleado = new FichaEmpleadoLogicaNegocio();
		set_exception_handler(array(
			$this,
			'manejadorExcepciones'));
	}

	/**
	 * Método de inicio del controlador
	 */
	public function index(){
		
	    $identificador = $this->identificador;
		$idProvinciaRevision = $_SESSION['idProvincia'];
		$estadoCertificado = "('Documental', 'Subsanado')";
		$fechaActual = date('Y-m-d');
		$banderaOpcionBusqueda = false;

		$query = "id_provincia_puerto_embarque = $idProvinciaRevision and estado_certificado in " . $estadoCertificado . " and fecha_creacion_certificado >= '" . $fechaActual . " 00:00:00' and fecha_creacion_certificado <= '" . $fechaActual . " 24:00:00' ORDER BY fecha_creacion_certificado DESC";
		
		$modeloCertificadoFitosanitario = $this->lNegocioCertificadoFitosanitario->buscarLista($query);
		$this->panelBusquedaCertificado = $this->cargarPanelCertificadosFitosanitarios($identificador, $banderaOpcionBusqueda);
		$this->tablaHtmlCertificadoFitosanitario($modeloCertificadoFitosanitario);
		require APP . 'CertificadoFitosanitario/vistas/listaRevisionCertificadoFitosanitarioVista.php';
	}

	/**
	 * Método para registrar en la base de datos el resultadod e la revision documental
	 */
	public function guardarRevisionDocumental(){
		
		$_POST['identificador_inspector'] = $this->identificador;
			
		$resultado = $this->lNegocioCertificadoFitosanitario->guardarRevisionDocumental($_POST);
		
		if($resultado){
			Mensajes::exito(Constantes::GUARDADO_CON_EXITO);
		}else{
			Mensajes::fallo("Ocurrio un error al guardar la información.");
		}
		
	}

	/**
	 * Obtenemos los datos del registro seleccionado para revision de solicitudes - Tabla: CertificadoFitosanitario
	 */
	public function revisionDocumentalSolicitud(){
		$this->accion = "Certificado fitosanitario";		
		$this->datosCertificadoFitosanitario = $this->lNegocioCertificadoFitosanitario->buscar($_POST["id"]);
		$tipoUsuario = "";
		$tipoAccion = "editar";
		
		$identificador = $this->identificador;
		$resultadoUsuarioInterno = $this->lNegocioFichaEmpleado->buscarDatosUsuarioContrato($identificador);
		
		if(isset($resultadoUsuarioInterno->current()->identificador)){
		    $tipoUsuario = "Interno";
		}else{
		    $tipoUsuario = "Externo";
		}
		
		$this->datosGenerales = $this->construirDatosGenealesCertificadoFitosanitario($this->datosCertificadoFitosanitario, $tipoUsuario);
		$this->datosFormaPago = $this->construirDatosFormaPago($this->datosCertificadoFitosanitario, $tipoUsuario);
		$this->datosPaisDestino = $this->construirDatosPuertosDestino($this->datosCertificadoFitosanitario, $tipoUsuario);
		$this->datosProductos = $this->construirDatosProductos($this->datosCertificadoFitosanitario, $tipoUsuario);
		$this->datosPuertosTransito = $this->construirDatosPuertosTransito($this->datosCertificadoFitosanitario, $tipoUsuario);
		$this->datosExportador = $this->construirDatosExportador($this->datosCertificadoFitosanitario, $tipoUsuario);
		$this->datosDocumentosAdjuntos = $this->construirDatosDocumentosAdjuntos($this->datosCertificadoFitosanitario, $tipoUsuario, $tipoAccion);
		$this->datosRevisionDocumental = $this->construirDatosRevisionDocumental($this->datosCertificadoFitosanitario);
		require APP . 'CertificadoFitosanitario/vistas/formularioRevisionDocumentalCertificadoFitosanitarioVista.php';
	}

	/**
	 * Método para borrar un registro en la base de datos - CertificadoFitosanitario
	 */
	/*public function borrar(){
		$this->lNegocioCertificadoFitosanitario->borrar($_POST['elementos']);
	}*/

	/**
	 * Construye el código HTML para desplegar la lista de - CertificadoFitosanitario
	 */
	public function tablaHtmlCertificadoFitosanitario($tabla){
		{
			$contador = 0;
			foreach ($tabla as $fila){
				
				$idCertificadoFitosanitario = $fila['id_certificado_fitosanitario'];
				
				$qDatosPaisDestino = $this->lNegocioPaisesPuertosDestino->buscarLista(['id_certificado_fitosanitario' => $idCertificadoFitosanitario]);
				$nombrePaisDestino = (empty($qDatosPaisDestino->current()->nombre_pais_destino) ? "" : $qDatosPaisDestino->current()->nombre_pais_destino);
				
				$this->itemsFiltrados[] = array(
					'<tr id="' . $fila['id_certificado_fitosanitario'] . '"
		  class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'CertificadoFitosanitario\RevisionCertificadoFitosanitario"
		  data-opcion="revisionDocumentalSolicitud" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++ $contador . '</td>
		  <td>' . $this->equivalenciaTipoSolicitud($fila['tipo_solicitud']) . '</td>
		  <td style="white - space:nowrap; "><b>' . ($fila['codigo_certificado'] != "" ? $fila['codigo_certificado'] : "TEMPORAL") . '</b></td>
<td>' . $nombrePaisDestino . '</td>
<td>' . date('Y-m-d', strtotime($fila['fecha_creacion_certificado'])) . '</td>
<td>' . $this->equivalenciaEstadosFitosanitarios($fila['estado_certificado']) . '</td>
</tr>');
			}
		}
	}

	/**
	 * Metodo para construir los datos generales de un certificado fitosanitario
	 */
	public function construirDatosRevisionDocumental($certificadoFitosanitario){
				
		$datos = '<div data-linea="1">
									<label for="resultado_revision">Resultado de revisión: </label>					
					<select id="resultado_revision" name="resultado_revision" class="validacion">
						<option value="">Seleccione...</option>
						<option value="documentalAprobado">Aprobado</option>
                        <option value="Subsanacion">Subsanacion</option>
						<option value="Rechazado">Rechazado</option>
					</select>
				</div>
				<div data-linea="2">
					<label for="observacion_revision">Observación: </label>
					<input type="text" id="observacion_revision" name="observacion_revision" value="" maxlength="510" class="validacion" autocomplete="off">
				</div>';
		
		return '<fieldset>
                        <legend>Resultado de revisión documental</legend>' . $datos . '</fieldset>
				<div data-linea="1">
					<button type="submit" id="bEnviarResultado" class="guardar">Enviar resultado</button>
				</div>';
	}	
	
	/**
	 * Método para listar los certificados fitosanitarios
	 * por tipo operador e identificador
	 */
	public function listarCertificadosFitosanitariosFiltrados()
	{
		$estado = 'EXITO';
		$mensaje = '';
		$contenido = '';
		
		$idProvinciaRevision = $_SESSION['idProvincia'];
		$identificadorOperador = '';
		$tipoSolicitud = $_POST["tipoSolicitud"];
		$idTipoProducto = $_POST['idTipoProducto'];
		$idSubtipoProducto = $_POST['idSubtipoProducto'];
		$idProducto = $_POST['idProducto'];
		$paisDestino = $_POST["paisDestino"];
		$fechaInicio = $_POST["fechaInicio"];
		$fechaFin = $_POST["fechaFin"];
		$estadoCertificado = "'Documental', 'Subsanado'";
		$numeroCertificado = $_POST["numeroCertificado"];
		
		$arrayParametros = array(
		    'identificadorOperador' => $identificadorOperador,
		    'tipoSolicitud' => $tipoSolicitud,
		    'idTipoProducto' => $idTipoProducto,
		    'idSubtipoProducto' => $idSubtipoProducto,
		    'idProducto' => $idProducto,
		    'estadoCertificado' => $estadoCertificado,
		    'paisDestino' => $paisDestino,
		    'fechaInicio' => $fechaInicio,
		    'fechaFin' => $fechaFin,
		    'idProvinciaPuertoEmbarque' => $idProvinciaRevision,
		    'numeroCertificado' => $numeroCertificado
		);
		
		$certificadosFitosanitarios = $this->lNegocioCertificadoFitosanitario->buscarCertificadosFitosanitariosPorFiltroRevisionDocumental($arrayParametros);
		
		$this->tablaHtmlCertificadoFitosanitario($certificadosFitosanitarios);
		$contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
		
		echo json_encode(array(
			'estado' => $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido
		));
	}
	
}
