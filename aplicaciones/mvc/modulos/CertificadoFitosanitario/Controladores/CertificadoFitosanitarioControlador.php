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
use Agrodb\Catalogos\Modelos\LocalizacionLogicaNegocio;
use Agrodb\Catalogos\Modelos\PuertosLogicaNegocio;
use Agrodb\Catalogos\Modelos\IdiomasLogicaNegocio;
use Agrodb\Catalogos\Modelos\MediosTransporteLogicaNegocio;
use Agrodb\InspeccionFitosanitaria\Modelos\InspeccionFitosanitariaLogicaNegocio;
use Agrodb\InspeccionFitosanitaria\Modelos\TotalInspeccionFitosanitariaLogicaNegocio;
use Agrodb\Catalogos\Modelos\TiposProduccionFitosanitariasLogicaNegocio;
use Agrodb\CertificadoFitosanitario\Modelos\PaisesPuertosTransitoLogicaNegocio;
use Agrodb\CertificadoFitosanitario\Modelos\PaisesPuertosDestinoLogicaNegocio;
use Agrodb\CertificadoFitosanitario\Modelos\CertificadoFitosanitarioProductosLogicaNegocio;
use Agrodb\RegistroOperador\Modelos\OperacionesLogicaNegocio;
use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;
use Agrodb\GUath\Modelos\FichaEmpleadoLogicaNegocio;
use Agrodb\CertificadoFitosanitario\Modelos\DocumentosAdjuntosLogicaNegocio;
use Agrodb\FirmaDocumentos\Modelos\DocumentosLogicaNegocio;
use Agrodb\Catalogos\Modelos\SubtipoProductosLogicaNegocio;
use Agrodb\Catalogos\Modelos\ProductosLogicaNegocio;
use Agrodb\RegistroOperador\Modelos\CodigosPoaLogicaNegocio;
use Agrodb\InspeccionFitosanitaria\Modelos\ConfigurarEstadoInspeccionPaisLogicaNegocio;

class CertificadoFitosanitarioControlador extends BaseControlador{

	private $lNegocioCertificadoFitosanitario = null;

	private $modeloCertificadoFitosanitario = null;

	private $lNegocioLocalizacion = null;

	private $lNegocioIdiomas = null;

	private $lNegocioMediosTransporte = null;

	private $lNegocioPuertos = null;

	private $lNegocioInspeccionFitosanitaria = null;

	private $lNegocioTotalInspeccionFitosanitaria = null;

	private $lNegocioTiposProduccionFitosanitarias = null;
	
	private $lNegocioPaisesPuertosTransito = null;
	
	private $lNegocioPaisesPuertosDestino = null;
	
	private $lNegocioCertificadoFitosanitarioProductos = null;
	
	private $lNegocioOperaciones = null;
	
	private $lNegocioFichaEmpleado = null;
	
	private $lNegocioDocumentosAdjuntos = null;
	
	private $lNegocioDocumentos = null;
	
	private $lNegocioSubtipoProductos = null;
	
	private $lNegocioProductos = null;
	
	private $lNegocioCodigosPoa = null;
	
	private $lNegocioConfigurarEstadoInspeccionPais = null;
	
	private $accion = null;

	private $datosGenerales = null;

	private $datosFormaPago = null;

	private $datosProductos = null;
	
	private $datosPaisDestino = null;
	
	private $datosPuertosTransito = null;
	
	private $datosExportador = null;
	
	private $datosDocumentosAdjuntos = null;
	
	private $datosRevisionDocumental = null;
	
	private $datosCertificadoFitosanitario = null;
	
	private $datosDesestimiento = null;
	
	private $datosMotivoAnulacion = null;
	
	private $banderaAnulaReemplaza = null;
	
	private $mensajeAnulaReemplaza = null;

	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->lNegocioCertificadoFitosanitario = new CertificadoFitosanitarioLogicaNegocio();
		$this->modeloCertificadoFitosanitario = new CertificadoFitosanitarioModelo();
		$this->lNegocioLocalizacion = new LocalizacionLogicaNegocio();
		$this->lNegocioIdiomas = new IdiomasLogicaNegocio();
		$this->lNegocioMediosTransporte = new MediosTransporteLogicaNegocio();
		$this->lNegocioPuertos = new PuertosLogicaNegocio();
		$this->lNegocioInspeccionFitosanitaria = new InspeccionFitosanitariaLogicaNegocio();
		$this->lNegocioTotalInspeccionFitosanitaria = new TotalInspeccionFitosanitariaLogicaNegocio();
		$this->lNegocioTiposProduccionFitosanitarias = new TiposProduccionFitosanitariasLogicaNegocio();
		$this->lNegocioPaisesPuertosTransito = new PaisesPuertosTransitoLogicaNegocio();
		$this->lNegocioPaisesPuertosDestino = new PaisesPuertosDestinoLogicaNegocio();
		$this->lNegocioCertificadoFitosanitarioProductos = new CertificadoFitosanitarioProductosLogicaNegocio();
		$this->lNegocioOperaciones = new OperacionesLogicaNegocio();
		$this->lNegocioFichaEmpleado = new FichaEmpleadoLogicaNegocio();
		$this->lNegocioDocumentosAdjuntos = new DocumentosAdjuntosLogicaNegocio();
		$this->lNegocioDocumentos = new DocumentosLogicaNegocio();
		$this->lNegocioSubtipoProductos = new SubtipoProductosLogicaNegocio();
		$this->lNegocioProductos = new ProductosLogicaNegocio();
		$this->lNegocioCodigosPoa = new CodigosPoaLogicaNegocio();
		$this->lNegocioConfigurarEstadoInspeccionPais = new ConfigurarEstadoInspeccionPaisLogicaNegocio();
		set_exception_handler(array(
			$this,
			'manejadorExcepciones'));
	}

	/**
	 * Método de inicio del controlador
	 */
	public function index(){
		
		$identificadorSolicitante = $this->identificador;
		$fechaActual = date('Y-m-d');
		$banderaOpcionBusqueda = true;
		
		$query = "identificador_solicitante = '" . $identificadorSolicitante . "' and fecha_creacion_certificado >= '". $fechaActual . " 00:00:00'  and fecha_creacion_certificado <= '". $fechaActual . " 24:00:00' ORDER BY fecha_creacion_certificado DESC";
		
		$modeloCertificadoFitosanitario = $this->lNegocioCertificadoFitosanitario->buscarLista($query);
		$this->panelBusquedaCertificado = $this->cargarPanelCertificadosFitosanitarios($identificadorSolicitante, $banderaOpcionBusqueda);
		$this->tablaHtmlCertificadoFitosanitario($modeloCertificadoFitosanitario);
		require APP . 'CertificadoFitosanitario/vistas/listaCertificadoFitosanitarioVista.php';
	}
	
	/**
	 * Método para visualizar estado de solicitudes
	 */
	public function estadoSolicitudes(){
	    
	    $identificadorSolicitante = $this->identificador;
	    $fechaActual = date('Y-m-d');
	    $banderaOpcionBusqueda = true;
	    
	    $query = "fecha_creacion_certificado >= '". $fechaActual . " 00:00:00'  and fecha_creacion_certificado <= '". $fechaActual . " 24:00:00' ORDER BY fecha_creacion_certificado DESC";
	    
	    $modeloCertificadoFitosanitario = $this->lNegocioCertificadoFitosanitario->buscarLista($query);
	    $this->panelBusquedaCertificado = $this->cargarPanelCertificadosFitosanitarios($identificadorSolicitante, $banderaOpcionBusqueda);
	    $this->tablaHtmlCertificadoFitosanitario($modeloCertificadoFitosanitario);
	    require APP . 'CertificadoFitosanitario/vistas/listaEstadoCertificadoFitosanitarioVista.php';
	}
	/**
	 * Método para desplegar el formulario vacio
	 */
	public function nuevo(){
		$this->accion = "Nuevo certificado fitosanitario";
		$identificador = $this->identificador;
		$resultadoUsuarioInterno = $this->lNegocioFichaEmpleado->buscarDatosUsuarioContrato($identificador);
		
		if(isset($resultadoUsuarioInterno->current()->identificador)){
		    $tipoUsuario = "Interno";
		}else{
		    $tipoUsuario = "Externo";
		}
		
		$this->datosGenerales = $this->construirDatosGenealesCertificadoFitosanitario([], $tipoUsuario);
		$this->datosFormaPago = $this->construirDatosFormaPago([], $tipoUsuario);
		require APP . 'CertificadoFitosanitario/vistas/formularioCertificadoFitosanitarioVista.php';
	}

	/**
	 * Método para registrar en la base de datos -CertificadoFitosanitario
	 */
	public function guardar(){
		$estado = 'exito';
		$mensaje = '';

		$datosLocalizacion = [
			'codigo_vue' => 'EC',
			'categoria' => 0];

		$identificadorOperador = $this->identificador;
		$qDatosLocalizacion = $this->lNegocioLocalizacion->buscarLista($datosLocalizacion);
		$idPaisOrigen = $qDatosLocalizacion->current()->id_localizacion;

		$idPuertoEmbarque = $_POST['id_puerto_embarque'];
		$qDatosPuertoEmbarque = $this->lNegocioPuertos->buscar($idPuertoEmbarque);
		$idProvinciaPuertoEmbarque = $qDatosPuertoEmbarque->getIdProvincia();
		
		
		$_POST['identificador_solicitante'] = $identificadorOperador;
		$_POST['id_pais_origen'] = $idPaisOrigen;
		$_POST['id_provincia_puerto_embarque'] = $idProvinciaPuertoEmbarque;
		$_POST['estado_certificado'] = 'Creado';
		
		if($_POST['forma_pago'] === 'saldo'){
		    $_POST['descuento'] = 'No';
		}

		$idCertificadoFitosanitario = $this->lNegocioCertificadoFitosanitario->guardar($_POST);

		echo json_encode(array(
			"estado" => $estado,
			"mensaje" => $mensaje,
			"contenido" => $idCertificadoFitosanitario));
	}

	/**
	 * Obtenemos los datos del registro seleccionado para editar - Tabla: CertificadoFitosanitario
	 */
	public function editar(){
		$this->accion = "Certificado fitosanitario";		
		$this->datosCertificadoFitosanitario = $this->lNegocioCertificadoFitosanitario->buscar($_POST["id"]);
		//$tipoSolicitud = $this->modeloCertificadoFitosanitario->getTipoSolicitud();
		//echo $tipoSolicitud = $this->datosCertificadoFitosanitario->getTipoSolicitud();
		$tipoUsuario = "";
		$tipoAccion = "editar";
		
		$identificador = $this->identificador;
		$resultadoUsuarioInterno = $this->lNegocioFichaEmpleado->buscarDatosUsuarioContrato($identificador);
		
		if(isset($resultadoUsuarioInterno->current()->identificador)){
		    $tipoUsuario = "Interno";
		}else{
		    $tipoUsuario = "Externo";
		}
		
		/*switch ($tipoSolicitud == "musaceas") {
			case value:
			;
			break;
			
			default:
				;
			break;
		}*/
		
		$this->datosGenerales = $this->construirDatosGenealesCertificadoFitosanitario($this->datosCertificadoFitosanitario, $tipoUsuario);
		$this->datosFormaPago = $this->construirDatosFormaPago($this->datosCertificadoFitosanitario, $tipoUsuario);
		$this->datosPaisDestino = $this->construirDatosPuertosDestino($this->datosCertificadoFitosanitario, $tipoUsuario);
		$this->datosProductos = $this->construirDatosProductos($this->datosCertificadoFitosanitario, $tipoUsuario);
		$this->datosPuertosTransito = $this->construirDatosPuertosTransito($this->datosCertificadoFitosanitario, $tipoUsuario);
		$this->datosExportador = $this->construirDatosExportador($this->datosCertificadoFitosanitario, $tipoUsuario);
		$this->datosDocumentosAdjuntos = $this->construirDatosDocumentosAdjuntos($this->datosCertificadoFitosanitario, $tipoUsuario, $tipoAccion);
		$this->datosRevisionDocumental = $this->construirDatosRevisionDocumental($this->datosCertificadoFitosanitario);
		require APP . 'CertificadoFitosanitario/vistas/formularioEditarCertificadoFitosanitarioVista.php';
	}
	
	/**
	 * Obtenemos los datos del registro seleccionado para anular y reemplazar - Tabla: CertificadoFitosanitario
	 */
	public function anulaReemplaza(){
	    
	    $this->accion = "Anula y reemplaza";
	    $elementos = array();
	    $banderaMostrarDatos = false;
	    
	    if(!empty($_POST['elementos'])){
	        $elementos = explode(',', $_POST['elementos']);
	    }	    
	    
	    if(empty($elementos)){
	        $this->banderaAnulaReemplaza = 'anulaReemplaza';
	        $this->mensajeAnulaReemplaza = 'Por favor seleccione un registro.';
	    }	    
	    
	    if(count($elementos) > 1){       
	        $this->banderaAnulaReemplaza = 'anulaReemplaza';
	        $this->mensajeAnulaReemplaza = 'Por favor seleccione un registro a la vez.';        
	    }
	        
	    if(count($elementos) == 1){
	        
	        $this->datosCertificadoFitosanitario = $this->lNegocioCertificadoFitosanitario->buscar($elementos[0]);
	        $estadoCertificado = $this->datosCertificadoFitosanitario->getEstadoCertificado();
	        $esReemplazo = $this->datosCertificadoFitosanitario->getEsReemplazo();
	        $estadoEphyto = $this->datosCertificadoFitosanitario->getEstadoEphyto();
	        
	        if($estadoCertificado === "Aprobado"){
	            
	            if(empty($esReemplazo)){
	                
	                if($estadoEphyto === 'Enviado'){	                
                        $banderaMostrarDatos = true;
	                }else{
	                    $this->banderaAnulaReemplaza = 'anulaReemplaza';
	                    $this->mensajeAnulaReemplaza = 'La solicitud se encuentra en proceso de transmisión, intente más tarde.';
	                }	                
	                
	            }else{
	                $this->banderaAnulaReemplaza = 'anulaReemplaza';
	                $this->mensajeAnulaReemplaza = 'La solicitud actual es un reemplazo, no puede ser anulada y reemplazada.';
	            }
	            
	        }else{            
	            $this->banderaAnulaReemplaza = 'anulaReemplaza';
	            $this->mensajeAnulaReemplaza = 'Seleccione una solicitud en estado aprobado.';
	        }
	        
	    }
	    
	    if($banderaMostrarDatos){

	        $tipoUsuario = "";
	        $tipoAccion = "anulaReemplaza";
	        
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
	        $this->datosMotivoAnulacion = $this->construirDatosMotivoAnulacion();
	        
	    }
	    
	    require APP . 'CertificadoFitosanitario/vistas/formularioAnulaReemplazaCertificadoFitosanitarioVista.php';
	}

	/**
	 * Método para borrar un registro en la base de datos - CertificadoFitosanitario
	 */
	public function borrar(){
		$this->lNegocioCertificadoFitosanitario->borrar($_POST['elementos']);
	}

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
		  class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'CertificadoFitosanitario\CertificadoFitosanitario"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
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
	 * Combo de Forma de pago
	 */
	public function cargarFormaPago(){
		return '<option value="">Seleccionar....</option>
    	<option value="efectivo">Comprobante de depósito</option>
    	<option value="saldo">Saldo</option>';
	}

	/**
	 * Método para desplegar el tipo de produccion
	 */
	public function obtenerTipoProduccionPorIdioma(){
		$idioma = $_POST['idioma'];
		echo '<option value="">Seleccione...</option>' . $this->comboTipoProduccionFitosanitariasPorIdioma($idioma);
	}

	/**
	 * Método para listar medios de transporte de acuerdo al idioma
	 */
	public function obtenerMediosTransportePorIdioma(){
		$idioma = $_POST['idioma'];
		echo '<option value="">Seleccione...</option>' . $this->comboMediosTransportePorIdioma($idioma);
	}

	/**
	 * Método para obtener los puertos de acuerdo un medio de trasnporte seleccionado
	 */
	public function obtenerPuertosPorNombreMedioTransporte(){
		$datosLocalizacion = [
			'codigo_vue' => 'EC',
			'categoria' => 0];

		$qDatosLocalizacion = $this->lNegocioLocalizacion->buscarLista($datosLocalizacion);
		$idLocalizacion = $qDatosLocalizacion->current()->id_localizacion;

		$nombreMedioTransporte = $_POST["nombreMedioTrasporte"];

		switch ($nombreMedioTransporte) {
			case 'Aéreo':
			case 'Aerial':
				$nombreMedioTransporte = "Aéreo";
			break;
			case 'Marítimo':
			case 'Maritime':
				$nombreMedioTransporte = "Marítimo";
			break;
			case 'Terrestre':
			case 'Land':
				$nombreMedioTransporte = "Terrestre";
			break;
		}

		$arrayParametros = array(
			'idLocalizacion' => $idLocalizacion,
			'nombreMedioTrasporte' => $nombreMedioTransporte);

		$puertos = $this->lNegocioCertificadoFitosanitario->obtenerPuertosPorNombreMedioTrasporte($arrayParametros);

		$comboPuertos = "";
		$comboPuertos .= '<option value="">Seleccionar....</option>';

		foreach ($puertos as $item){
			$comboPuertos .= '<option value="' . $item->id_puerto . '" data-nombrepuerto="' . $item->nombre_puerto . '" >' . $item->nombre_puerto . ' - ' . $item->codigo_puerto . '</option>';
		}

		echo $comboPuertos;
	}

	/**
	 * Metodo validar numeo de solicitud de inspeccion ingresado
	 */
	public function obtenerDatosInspeccionFitosanitaria(){
		$validacion = "Exito";
		$mensaje = "";
		$resultado = "";
		$validarNumeroSolicitud = false;
		$datosBusqueda = "";

		$idCertificadoFitosanitario = $_POST['idCertificadoFitosanitario'];
		$numeroSolicitudInspeccion = $_POST['numeroSolicitudInspeccion'];
		$idTipoProduccion = $_POST['idTipoProduccion'];
		$tipoSolicitud = $_POST['tipoSolicitud'];

		if ($numeroSolicitudInspeccion){

			$qDatosPaisPuertoDestino = $this->lNegocioPaisesPuertosDestino->obtenerPaisesPuertosDestinoPorIdCertificadoFitosanitario($idCertificadoFitosanitario);
			
			if($qDatosPaisPuertoDestino->count()){
			
				$idPaisDestinoRegistrado = $qDatosPaisPuertoDestino->current()->id_pais_destino;
				
				$consultaVerificarTipoSolicitud = "numero_solicitud = '" . $numeroSolicitudInspeccion . "' and tipo_solicitud = '" . $tipoSolicitud . "'";
				$verificarTipoSolicitud = $this->lNegocioInspeccionFitosanitaria->buscarLista($consultaVerificarTipoSolicitud);
				
				if($verificarTipoSolicitud->count()){
				    
				    $consultaVerificarTipoProduccion = "numero_solicitud = '" . $numeroSolicitudInspeccion . "' and id_tipo_produccion = " . $idTipoProduccion;
				    $verificarTipoProduccion = $this->lNegocioInspeccionFitosanitaria->buscarLista($consultaVerificarTipoProduccion);
				    
				    if($verificarTipoProduccion->count()){
			        
				        $arrayVerificarPaisDestino = ['numero_solicitud' => $numeroSolicitudInspeccion
				                                     , 'id_pais_destino' => $idPaisDestinoRegistrado
				                                     ];
				        
				        $verificarSolicitudPaisDestino = $this->lNegocioInspeccionFitosanitaria->buscarLista($arrayVerificarPaisDestino);
				        
				        if($verificarSolicitudPaisDestino->count()){
				            
				            //----Inicio validar si posee configuración de estado inspeccion - pais enviado----//
				            $datosConfigurarEstadoInspeccionPais = ['tipo_certificado' => $tipoSolicitud
                                    				                , 'id_pais' => $idPaisDestinoRegistrado
                                    				               ];
				            
				            $verificarConfiguracionEstadoInspeccionPais = $this->lNegocioConfigurarEstadoInspeccionPais->buscarLista($datosConfigurarEstadoInspeccionPais);
																			             
				            if($verificarConfiguracionEstadoInspeccionPais->count()){
				                $datosBusqueda = "('Aprobado', 'Enviado')";				                
				            }else{
				                $datosBusqueda = "('Aprobado')";																					   
				            }
				            //----Fin validar si posee configuración de estado inspeccion - pais enviado----//
				        
    				        $consultaVerificar = "numero_solicitud = '" . $numeroSolicitudInspeccion . "' and estado_inspeccion_fitosanitaria IN ". $datosBusqueda;
            				$verificarSolicitud = $this->lNegocioInspeccionFitosanitaria->buscarLista($consultaVerificar);
            				
            				if ($verificarSolicitud->count()){
            				    
            					$idInspeccionFitosanitaria = $verificarSolicitud->current()->id_inspeccion_fitosanitaria;
            					$tipoSolicitud = $verificarSolicitud->current()->tipo_solicitud;            					
            					$resultado = $this->construirDatosProductosExportacion($idInspeccionFitosanitaria, $idCertificadoFitosanitario); 
			  
            				}else{					  
            					$validacion = 'Fallo';
            					$mensaje = 'El número de inspección ingresado es incorrecto o no posee un estado permitido para su uso.';					
            				}
			 		
				        }else{				            
				            $validacion = 'Fallo';
				            $mensaje = 'El número de inspección ingresado no pertenece al país de destino del certificado.';				            
				        }
        				
				    }else{
				        $validacion = 'Fallo';
				        $mensaje = 'El número de inspección ingresado no pertenece al tipo de producción del certificado.';
				    }
    				
    			}else{
    			    $validacion = 'Fallo';
    			    $mensaje = 'El número de inspección ingresado no pertenece al tipo de solicitud del certificado.';
    			}
				
			}else{
				$validacion = 'Fallo';
				$mensaje = 'Debe registrar un pais de destino antes de registrar un producto.';
			}
		}else{
			$validacion = 'Fallo';
			$mensaje = 'El número de inspección no debe estar vacío.';
		}

		echo json_encode(array(
			'validacion' => $validacion,
			'mensaje' => $mensaje,
			'resultado' => $resultado));
	}

	/**
	 * Metodo para construir los productos resultado de inspeccion
	 */
	public function construirDatosProductosExportacion($idInspeccionFitosanitaria, $idCertificadoFitosanitario){
		$datos = "";
		$check = "";
		$cantidad = "";
		$pesoNeto = "";
		$pesoBruto = "";

		$qDatosCertificadoFitosanitario = $this->lNegocioCertificadoFitosanitario->buscar($idCertificadoFitosanitario);
		$idIdiomaCertificado = $qDatosCertificadoFitosanitario->getIdIdioma();
		
		$qDatosIdioma = $this->lNegocioIdiomas->buscar($idIdiomaCertificado);
		$codigoIdioma = $qDatosIdioma->getCodigoIdioma();
		
		$datosTotalInspeccionFitosanitaria = $this->lNegocioTotalInspeccionFitosanitaria->obtenerDatosInspeccionFitosanitariaAprobado($idInspeccionFitosanitaria);

		foreach ($datosTotalInspeccionFitosanitaria as $item){

			$idTotalInspeccionFitosanitaria = $item['id_total_inspeccion_fitosanitaria'];
			$idInspeccionFitosanitaria = $item['id_inspeccion_fitosanitaria'];
			$fechaInspeccion = $item['fecha_inspeccion'];
						
			if($item['total_cantidad_aprobada'] > 0 || $item['total_peso_aprobado'] > 0){
			    $check = '<input type="checkbox" name="id_total_inspeccion_fitosanitaria[]" value="' . $idTotalInspeccionFitosanitaria . '" data-fechainspeccion = "' . $fechaInspeccion . '" data-idinspeccionfitosanitaria = "' . $idInspeccionFitosanitaria . '">';
				$cantidad = '<input type="text" name="cantidad_comercial[]" value="' . $item['total_cantidad_aprobada'] . '" style="width: 60px;" maxlenght="10" oninput="formatearCantidadProducto(this)" onchange="validarCantidades(' . $idTotalInspeccionFitosanitaria . ', this)" autocomplete="off" />';
				$pesoNeto = '<input type="text" name="peso_neto[]" value="' . $item['total_peso_aprobado'] . '" style="width: 60px;" maxlenght="10" oninput="formatearCantidadProducto(this)" onchange="validarCantidades(' . $idTotalInspeccionFitosanitaria . ', this)" autocomplete="off" />';
				$pesoBruto = '<input type="text" name="peso_bruto[]" value="" style="width: 60px;" maxlenght="9" oninput="formatearCantidadProducto(this)" autocomplete="off" />';
			}else{
				$cantidad = $item['total_cantidad_aprobada'];
				$pesoNeto = $item['total_peso_aprobado'];
			}			
			
			$datos .= '<tr>
						<td>' . $check . '</td>
						<td>' . $item['nombre_subtipo_producto'] . '/' . $item['nombre_producto'] . '</td>
						<td>' . $item['total_cantidad_aprobada'] . ' ' . $this->obtenerUnidadFitosanitaria($item['id_unidad_cantidad_producto'], $codigoIdioma) . '</td>
						<td>' . $item['total_peso_aprobado'] . ' ' . $this->obtenerUnidadFitosanitaria($item['id_unidad_peso_producto'], $codigoIdioma) . '</td>
						<td>' . $cantidad . '</td>
						<td>' . $pesoNeto . '</td>
						<td>' . $pesoBruto . '</td>
						</tr>';
		}

		return $datos;
	}

	/**
	 * Método para validar la cantidad de producto agregado
	 */
	public function validarCantidades(){
		$validacion = "Fallo";
		$resultado = "";
		$valorCantidad = "";
		$idTotalInspeccionFitosanitaria = $_POST["id_total_inspeccion_fitosanitaria"];
		$cantidad = $_POST['cantidad'];
		$tipoCantidad = $_POST['tipo_cantidad'];

		$qValorCantidad = $this->lNegocioTotalInspeccionFitosanitaria->buscar($idTotalInspeccionFitosanitaria);

		if (($cantidad > 0) && trim($cantidad) != ""){

			switch ($tipoCantidad) {
				case "cantidad_comercial[]":
					if ($cantidad <= $qValorCantidad->getTotalCantidadAprobada()){
						$validacion = "Exito";
						$valorCantidad = $cantidad;
					}else{
						$valorCantidad = $qValorCantidad->getTotalCantidadAprobada();
					}
				break;
				case "peso_neto[]":
					if ($cantidad <= $qValorCantidad->getTotalPesoAprobado()){
						$validacion = "Exito";
						$valorCantidad = $cantidad;
					}else{
						$valorCantidad = $qValorCantidad->getTotalPesoAprobado();
					}
				break;
			}
		}else{

			switch ($tipoCantidad) {
				case "cantidad_comercial[]":
					$valorCantidad = $qValorCantidad->getTotalCantidadAprobada();
				break;
				case "peso_neto[]":
					$valorCantidad = $qValorCantidad->getTotalPesoAprobado();
					break;
			}			
			
		}
		
		echo json_encode(array(
			'resultado' => $resultado,
			'validacion' => $validacion,
			'cantidad' => $valorCantidad
		));
		
	}

	/**
	 * Metodo para construir los puertos por pais
	 */
	public function buscarPuertosPorIdPais(){
		
		$idLocalizacion = $_POST['idLocalizacion'];
		
		echo '<option value="">Seleccione...</option>'
			. $this->comboPuertosPorIdentificador($idLocalizacion);
	
	}	
	
	/**
	 * Metodo para validar si el exportador posee los productos e exportar
	 */
	public function validarProductosExportador(){
		
		$validacion = "";
		$mensaje = "";
		$resultado = "";
		$productosAgregados = "";
		$idCertificadoFitosanitario = $_POST['idCertificadoFitosanitario'];
		$identificadorExportador = $_POST['identificadorExportador'];
		
		$qDatosProductosCertificadoFitosanitario = $this->lNegocioCertificadoFitosanitarioProductos->buscarLista(['id_certificado_fitosanitario' => $idCertificadoFitosanitario]);
		
		if($qDatosProductosCertificadoFitosanitario->count()){
		
			$datosProductoExportador = ['id_certificado_fitosanitario' => $idCertificadoFitosanitario];
			
			$qProductos = $this->lNegocioCertificadoFitosanitarioProductos->buscarLista($datosProductoExportador);
			
			foreach ($qProductos as $llave => $valor) {
				$productosAgregados .= $valor['id_producto'] . ', ';
			}
			
			$productosAgregados = trim($productosAgregados, ', ');
			
			$datosOperadorProducto = ['identificador_operador' => $identificadorExportador,
										'tipo_operacion' => 'SVEXP',
										'id_producto' => $productosAgregados,
										'estado' => 'registrado'
									];
			
			$qDatosOperador = $this->lNegocioOperaciones->obtenerOperadoresPorTipoOperacionPorIdProductoPorEstado($datosOperadorProducto);
			
			if($qDatosOperador->count()){
				
				$validacion = 'Exito';
				$nombreOperador = $qDatosOperador->current()->nombre_operador;
				$direccionOperador = $qDatosOperador->current()->direccion_operador;
				
				$resultado = ['nombreOperador' => $nombreOperador,
								'direccionOperador' => $direccionOperador
							];
				
			}else{
				
				$validacion = 'Fallo';
				$mensaje = 'El exportador no posee un registro de operador con los productos registrados.';
				
			}
			
		}else{
			
			$validacion = 'Fallo';
			$mensaje = 'Por favor registre un producto antes de ingresar un exportador.';
			
		}
		
		echo json_encode(array(
			'validacion' => $validacion,
			'mensaje' => $mensaje,
			'resultado' => $resultado
		));
		
	}
	
	/**
	 * Metodo para validar si el código poa pertenece a una exportador
	 */
	public function validarCodigoPoaExportador(){
	    
	    $validacion = "";
	    $mensaje = "";
	    $resultado = "";
	   
	    $identificadorExportador = $_POST['identificadorExportador'];
	    $codigoPoaExportador = $_POST['codigoPoaExportador'];
	    
	    $arrayParametros = array(
	        'identificadorOperador' => $identificadorExportador,
	        'codigoPoa' => $codigoPoaExportador
	    );
	    
	    if(preg_match("/^[0-9]{4}-[0-9]{1}$/", $codigoPoaExportador)){
	        
	        $verificarCodigoPoa = $this->lNegocioCodigosPoa->buscarCodigoPoaPorOperador($arrayParametros);
	        
	        if(isset($verificarCodigoPoa->current()->codigo_poa)){
	            $validacion = 'Exito';
	            echo json_encode(array('mensaje' => $mensaje,'validacion' => $validacion));
	        }else{
	            $validacion = 'Fallo';
	            $mensaje = 'El código POA ingresado no está registrado o no corresponde al exportador.';
	        }
	        
	    }else{
	        $validacion = 'Fallo';
	        $mensaje = 'El código POA ingresado no posee el formato correcto.';
	    }    
	        	    
	    echo json_encode(array(
	        'validacion' => $validacion,
	        'mensaje' => $mensaje,
	        'resultado' => $resultado
	    ));
	    
	}
	
	/**
	 * Método para actualizar los datos generales de la solicitud
	 */
	public function actualizarDatosGeneralesCertificadoFitosanitario(){
				
		$validacion = "";
		$resultado = "";
		
		$resultado = $this->lNegocioCertificadoFitosanitario->actualizarDatosGeneralesCertificadoFitosanitario($_POST);
		
		if($resultado){
			$validacion = "Exito";
			$resultado = "Los datos han sido actualizados.";
		}else{
			$validacion = "Fallo";
			$resultado = "Ocurrio un error al actualizar la información.";
		}
		
		echo json_encode(array(
			'resultado' => $resultado,
			'validacion' => $validacion));
	}
	
	/**
	 * Método para enviar la solicitud
	 */
	public function enviarSolicitud(){

	    $idCertificadoFitosanitario = $_POST['id_certificado_fitosanitario'];
		$_POST['identificador_solicitante'] = $this->identificador;
		
		$qDatosCertificadoFitosanitario = $this->lNegocioCertificadoFitosanitario->buscar($idCertificadoFitosanitario);
		$estadoActualCertificado = $qDatosCertificadoFitosanitario->getEstadoCertificado();
			
		switch ($estadoActualCertificado){
		    
		    case 'Subsanacion':
		        $_POST['estado_certificado'] = 'Subsanado';
		    break;		    
		    default:
		        $_POST['estado_certificado'] = 'Documental';
		    break;
		    
		}
		
		$resultado = $this->lNegocioCertificadoFitosanitario->enviarSolicitud($_POST);
		
		if($resultado){
			Mensajes::exito(Constantes::GUARDADO_CON_EXITO);
		}else{
			Mensajes::fallo("Ocurrio un error al guardar la información.");
		}

	}
	
	/**
	 * Método para enviar la solicitud de anula y reemplaza
	 */
	public function enviarAnulaReemplaza(){
	    
	    $estado = 'exito';
	    $mensaje = '';
	    $idCertificadoFitosanitario = $_POST['id_certificado_fitosanitario'];
	    $_POST['identificador_solicitante'] = $this->identificador;
	    	    
	    $qCertificadoFitosanitario = $this->lNegocioCertificadoFitosanitario->buscar($idCertificadoFitosanitario);
	    
	    $identificadorSolicitante = $qCertificadoFitosanitario->getIdentificadorSolicitante();
	    $identificadorExportador = $qCertificadoFitosanitario->getIdentificadorExportador();
	    $tipoSolicitud = $qCertificadoFitosanitario->getTipoSolicitud();
	    $idIdioma = $qCertificadoFitosanitario->getIdIdioma();
	    $estadoCertificado = "Creado";
	    $idTipoProduccion = $qCertificadoFitosanitario->getIdTipoProduccion();
	    $idPaisOrigen = $qCertificadoFitosanitario->getIdPaisOrigen();
	    $fechaEmbarque = $qCertificadoFitosanitario->getFechaEmbarque();
	    $idMedioTransporte = $qCertificadoFitosanitario->getIdMedioTransporte();
	    $idPuertoEmbarque = $qCertificadoFitosanitario->getIdPuertoEmbarque();
	    $idProvinciaPuertoEmbarque = $qCertificadoFitosanitario->getIdProvinciaPuertoEmbarque();
	    $nombreMarca = $qCertificadoFitosanitario->getNombreMarca();
	    $informacionAdicional = $qCertificadoFitosanitario->getInformacionAdicional();
	    $codigoCertificadoImportacion = $qCertificadoFitosanitario->getCodigoCertificadoImportacion();
	    $nombreConsignatario = $qCertificadoFitosanitario->getNombreConsignatario();
	    $direccionConsignatario = $qCertificadoFitosanitario->getDireccionConsignatario();
	    $esReemplazo = "Si";
	    $motivoReemplazo = $_POST['motivo_reemplazo'];
	    $idCertificadoFitosanitarioReemplazo = $idCertificadoFitosanitario;
	    
	    $datosCertificadoFitosanitario = ['identificador_solicitante' => $identificadorSolicitante
	        , 'identificador_exportador' => $identificadorExportador
	        , 'tipo_solicitud' => $tipoSolicitud
	        , 'id_idioma' => $idIdioma
	        , 'estado_certificado' => $estadoCertificado
	        , 'id_tipo_produccion' => $idTipoProduccion
	        , 'id_pais_origen' => $idPaisOrigen
	        , 'fecha_embarque' => $fechaEmbarque
	        , 'id_medio_transporte' => $idMedioTransporte
	        , 'id_puerto_embarque' => $idPuertoEmbarque
	        , 'id_provincia_puerto_embarque' => $idProvinciaPuertoEmbarque
	        , 'nombre_marca' => $nombreMarca
	        , 'informacion_adicional' => $informacionAdicional
	        , 'codigo_certificado_importacion' => $codigoCertificadoImportacion
	        , 'nombre_consignatario' => $nombreConsignatario
	        , 'direccion_consignatario' => $direccionConsignatario
	        , 'es_reemplazo' => $esReemplazo
	        , 'motivo_reemplazo' => $motivoReemplazo
	        , 'id_certificado_reemplazo' => $idCertificadoFitosanitarioReemplazo
			, 'fecha_reemplazo_certificado' => 'now()'
	    ];

	    if($qCertificadoFitosanitario->getCodigoPoa()){	        
	        $codigoPoa = $qCertificadoFitosanitario->getCodigoPoa();	        
	        $datosCertificadoFitosanitario += ['codigo_poa' => $codigoPoa];
	    }
	    
	    $idCertificadoFitosanitario = $this->lNegocioCertificadoFitosanitario->enviarAnulaReemplaza($datosCertificadoFitosanitario);
	    
	    echo json_encode(array(
	        "estado" => $estado,
	        "mensaje" => $mensaje,
	        "contenido" => $idCertificadoFitosanitario));
	    
	}
	
	///////////////////////////////////////////////////////////////////
	///////////////////GENERACION DE CERTIFICADO //////////////////////
	///////////////////////////////////////////////////////////////////
	
	/**
	 * Proceso automático para generar certificados
	 */
	public function paGeneracionCertificadoFitosanitario(){
		
		echo "\n".'Proceso Automático de generación de certificados'."\n"."\n";
		
		$consulta = "certificado = 'No' and estado_certificado = 'Aprobado' LIMIT 20";
		
		$certificados = $this->lNegocioCertificadoFitosanitario->buscarLista($consulta);
		
		foreach ($certificados as $fila) {
			$arrayParametros = array(
				'id_certificado_fitosanitario' => $fila['id_certificado_fitosanitario'],
				'codigo_certificado' => $fila['codigo_certificado']
			);
			
			$mensaje = $this->generarCertificadoFitosanitarioAutomatico($arrayParametros);
			
			echo $mensaje . "\n";
		}
		
		echo "\n";
	}

	/**
	 * Función para generar el certificado y anexo individual de manera automática
	 */
	public function generarCertificadoFitosanitarioAutomatico($arrayParametros)
	{
		$anio = date('Y');
		$mes = date('m');
		$dia = date('d');
		
		$datos = array(
			'id_certificado_fitosanitario' => $arrayParametros['id_certificado_fitosanitario'],
			'certificado' => 'W'
		);
		
		$this->lNegocioCertificadoFitosanitario->actualizarEstadoGeneracionCertificado($datos);
		
		$idCertificadoFitosanitario = $arrayParametros['id_certificado_fitosanitario'];
		$codigoCertificado = $arrayParametros['codigo_certificado'];
		
		if (strlen($idCertificadoFitosanitario) > 0) {
			
			$rutaFechaCertificado = $anio . "/" . $mes . "/" . $dia . "/";
			
			//Obtener datos del inspector de revision documental
			
			$qDatosCertificadoFitosanitario = $this->lNegocioCertificadoFitosanitario->buscar($idCertificadoFitosanitario);
			$identificadorRevision = $qDatosCertificadoFitosanitario->getIdentificadorRevision();
			
			$resultadoUsuarioInterno = $this->lNegocioFichaEmpleado->buscarDatosUsuarioContrato($identificadorRevision);
			$nombreInspector = $resultadoUsuarioInterno->current()->nombre;
			$provinciaInspector = $resultadoUsuarioInterno->current()->provincia;
			
			//Generar el Certificado
			$this->lNegocioCertificadoFitosanitario->generarCertificado($idCertificadoFitosanitario, $codigoCertificado, $rutaFechaCertificado, $nombreInspector, $provinciaInspector);
			$certificado = CERT_FITO_URL . "certificados/" . $rutaFechaCertificado . "C" . $codigoCertificado . ".pdf";
			$certificadoFirma = CERT_FITO_CERT_URL_TCPDF . "certificados/" . $rutaFechaCertificado . "C" . $codigoCertificado . ".pdf";
			
			//Generar el Anexo
			$this->lNegocioCertificadoFitosanitario->generarAnexo($idCertificadoFitosanitario, $codigoCertificado, $rutaFechaCertificado, $nombreInspector, $provinciaInspector);
			$anexo = CERT_FITO_URL . "certificados/" . $rutaFechaCertificado . "A" . $codigoCertificado . ".pdf";
			$anexoFirma = CERT_FITO_CERT_URL_TCPDF. "certificados/" . $rutaFechaCertificado . "A" . $codigoCertificado . ".pdf";
			
			$arrayParametrosCertificado = array(
				'id_certificado_fitosanitario' => $idCertificadoFitosanitario,
				'tipo_adjunto' => 'Certificado Fitosanitario',
				'ruta_adjunto' => $certificado
			);
			
			$idCertificado = $this->lNegocioDocumentosAdjuntos->guardar($arrayParametrosCertificado);
			
			$arrayParametrosAnexo = array(
				'id_certificado_fitosanitario' => $idCertificadoFitosanitario,
				'tipo_adjunto' => 'Anexo Certificado',
				'ruta_adjunto' => $anexo
			);
			
			$idAnexo = $this->lNegocioDocumentosAdjuntos->guardar($arrayParametrosAnexo);
			
			$mensaje = 'Se ha generado el certificado ' . $idCertificadoFitosanitario . '-'. $codigoCertificado;
			
			$datos = array(
				'id_certificado_fitosanitario' => $idCertificadoFitosanitario,
				'certificado' => 'Si'
			);
			
			$this->lNegocioCertificadoFitosanitario->actualizarEstadoGeneracionCertificado($datos);
			
			//Firma Electrónica
			$arrayDocumentoCertificado = array(
				'archivo_entrada' => $certificadoFirma,
				'archivo_salida' => $certificadoFirma,
			    'identificador' => $identificadorRevision, //'1717299596',
				'razon_documento' => 'Certificación fitosanitaria de exportación.',
				'tabla_origen' => 'g_certificado_fitosanitario.documentos_adjuntos',
				'campo_origen' => 'id_documento_adjunto',
				'id_origen' => $idCertificado,
				'estado' => 'Por atender',
				'proceso_firmado' => 'NO'
			);
			
			$this->lNegocioDocumentos->guardar($arrayDocumentoCertificado);
			
			//Firma Electrónica
			$arrayDocumentoAnexo = array(
				'archivo_entrada' => $anexoFirma,
				'archivo_salida' => $anexoFirma,
			    'identificador' => $identificadorRevision, //'1717299596',
				'razon_documento' => 'Certificación fitosanitaria de exportación.',
				'tabla_origen' => 'g_certificado_fitosanitario.documentos_adjuntos',
				'campo_origen' => 'id_documento_adjunto',
				'id_origen' => $idAnexo,
				'estado' => 'Por atender',
				'proceso_firmado' => 'NO'
			);
			
			$this->lNegocioDocumentos->guardar($arrayDocumentoAnexo);
			
		} else {
			$mensaje = 'No se pudo generar el certificado ' . $idCertificadoFitosanitario .'-'.$codigoCertificado;
		}
		
		return $mensaje;
	}
	
	/**
	 * Proceso automático para generar certificados XML y envio a HUB
	 */
	public function paGenerarXmlWebServicesCertificadosFitosanitario(){
		
		$fecha = date("Y-m-d h:m:s");
		echo Constantes::IN_MSG .'<b>PROCESO AUTOMÁTICO DE GENERACIÓN DE ARCHIVO XML PARA ENVIÓ DE WEB SERVICES A TRAVÉS DE HUB '.$fecha.'</b>\n';
		
		$this->lNegocioCertificadoFitosanitario->procesoGenerarXmlWebServicesCertificadosFitosanitario();
		
		echo Constantes::IN_MSG .'<b>FIN PROCESO DE GENERACIÓN DE ARCHIVO XML PARA ENVIÓ DE WEB SERVICES A TRAVÉS DE HUB '.$fecha.'</b>';
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
	    
	    $idProvinciaRevision = '';
	    $identificadorOperador = $this->identificador;
	    $idTipoProducto = $_POST['idTipoProducto'];
	    $idSubtipoProducto = $_POST['idSubtipoProducto'];
	    $idProducto = $_POST['idProducto'];
	    $estadoCertificado = (empty($_POST["estadoCertificado"]) ? "" : "'" . $_POST["estadoCertificado"] . "'");
	    $tipoSolicitud = $_POST["tipoSolicitud"];
	    $paisDestino = $_POST["paisDestino"];
	    $fechaInicio = $_POST["fechaInicio"];
	    $fechaFin = $_POST["fechaFin"];
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
	
	/**
	 * Método para obtener los subtipos de productos por idTipoProducto
	 */
	public function buscarSubtipoProductoPorIdTipoProducto()
	{
	    $validacion = "Exito";
	    $mensaje = "";
	    $resultado = "";
	    $comboSubtipoProducto = "";

	    $idTipoProducto = $_POST['idTipoProducto'];
	    	   
	    $comboSubtipoProducto = '<option value="">Seleccione...</option>';
	    
	    $query = "estado = 1 and id_tipo_producto = $idTipoProducto ORDER BY nombre ASC";
	    
	    $combo = $this->lNegocioSubtipoProductos->buscarLista($query);
	    
	    foreach ($combo as $item){
	        $comboSubtipoProducto .= '<option value="' . $item->id_subtipo_producto . '">' . $item->nombre . '</option>';
	    }
	    
	    $resultado = $comboSubtipoProducto;	    

	    echo json_encode(array(
	        'validacion' => $validacion,
	        'mensaje' => $mensaje,
	        'resultado' => $resultado
	    ));
	}
	
	/**
	 * Método para obtener los productos por idSubtipoProducto
	 */
	public function buscarProductoPorIdSubtipoProducto()
	{
	    $validacion = "Exito";
	    $mensaje = "";
	    $resultado = "";
	    $comboProducto = "";

	    $idSubtipoProducto = $_POST['idSubtipoProducto'];
	    	   
	    $comboProducto = '<option value="">Seleccione...</option>';
	    
	    $query = "estado = 1 and id_subtipo_producto = $idSubtipoProducto ORDER BY nombre_comun ASC";
	    
	    $combo = $this->lNegocioProductos->buscarLista($query);
	    
	    foreach ($combo as $item){
	        $comboProducto .= '<option value="' . $item->id_producto . '">' . $item->nombre_comun . '</option>';
	    }
	    
	    $resultado = $comboProducto;	    

	    echo json_encode(array(
	        'validacion' => $validacion,
	        'mensaje' => $mensaje,
	        'resultado' => $resultado
	    ));
	}
	
	/**
	 * Método para listar los certificados fitosanitarios
	 * por tipo operador e identificador
	 */
	public function listarEstadoCertificadosFitosanitariosFiltrados()
	{
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    $idProvinciaRevision = '';
	    $identificadorOperador = '';
	    $idTipoProducto = $_POST['idTipoProducto'];
	    $idSubtipoProducto = $_POST['idSubtipoProducto'];
	    $idProducto = $_POST['idProducto'];
	    $estadoCertificado = (empty($_POST["estadoCertificado"]) ? "" : "'" . $_POST["estadoCertificado"] . "'");
	    $tipoSolicitud = $_POST["tipoSolicitud"];
	    $paisDestino = $_POST["paisDestino"];
	    $fechaInicio = $_POST["fechaInicio"];
	    $fechaFin = $_POST["fechaFin"];
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
	
	/**
	 * Método para actualizar cantidad y pesos de producto
	 */
	public function actualizarCantidades()
	{
	    $validacion = "Fallo";
	    $resultado = "";
	    $valorCantidad = "";
	    $banderaGuardar = false;
	    $idCertificadoFitosanitarioProducto = $_POST['id_certificado_fitosanitario_producto'];	    
	    
	    $qDatosProductos = $this->lNegocioCertificadoFitosanitarioProductos->buscar($idCertificadoFitosanitarioProducto);
	    $idCertificadoFitosanitario = $qDatosProductos->getIdCertificadoFitosanitario();
	    $idTotalInspeccionFitosanitaria = $qDatosProductos->getIdTotalInspeccionFitosanitaria();
	    $idProducto = $qDatosProductos->getIdProducto();
	    $cantidad = $_POST['cantidad'];
	    $tipoCantidad = $_POST['tipo_cantidad'];
	    	    
	    $qDatosCertificadoFitosanitarioOrigen = $this->lNegocioCertificadoFitosanitario->buscar($idCertificadoFitosanitario);
	    $idCertificadoReemplazo = $qDatosCertificadoFitosanitarioOrigen->getIdCertificadoReemplazo();
	    
	    $datosCertificadoOrigen = ['id_certificado_fitosanitario' => $idCertificadoReemplazo
                        	        , 'id_total_inspeccion_fitosanitaria' => $idTotalInspeccionFitosanitaria
                        	        , 'id_producto' => $idProducto];
	    
	    $qDatosProductoOrigen = $this->lNegocioCertificadoFitosanitarioProductos->buscarLista($datosCertificadoOrigen);
	    $cantidadOrigen = $qDatosProductoOrigen->current()->cantidad_comercial;
	    $pesoNetoOrigen = $qDatosProductoOrigen->current()->peso_neto;
	    $pesoBrutoOrigen = $qDatosProductoOrigen->current()->peso_bruto;

	    if (($cantidad > 0) && trim($cantidad) != "") {
	        
	        $datosProducto = ['id_certificado_fitosanitario_producto' => $idCertificadoFitosanitarioProducto
	                           , $tipoCantidad => $cantidad];
	        
	        switch ($tipoCantidad) {
	            case "cantidad_comercial":
	                if ($cantidad <= $cantidadOrigen){
	                    $validacion = "Exito";
	                    $valorCantidad = $cantidad;
	                    $banderaGuardar = true;	                    
	                }else{
	                    $valorCantidad = $cantidadOrigen;
	                }
	                break;
	            case "peso_neto":
	                if ($cantidad <= $pesoNetoOrigen){
	                    $validacion = "Exito";
	                    $valorCantidad = $cantidad;
	                    $banderaGuardar = true;
	                }else{
	                    $valorCantidad = $pesoNetoOrigen;
	                }
	                break;
	            case "peso_bruto":
	                if ($cantidad <= $pesoBrutoOrigen){
	                    $validacion = "Exito";
	                    $valorCantidad = $cantidad;
	                    $banderaGuardar = true;
	                }else{
	                    $valorCantidad = $pesoBrutoOrigen;
	                }
	                break;
	        }
	        
	        if($banderaGuardar){
	            $this->lNegocioCertificadoFitosanitarioProductos->guardar($datosProducto);
	        }
	        
	        
	    } else {
	        
	        switch ($tipoCantidad) {
	            case "cantidad_comercial":
	                $valorCantidad = $cantidadOrigen;
	                break;
	            case "peso_neto":
	                $valorCantidad = $pesoNetoOrigen;
	                break;
	            case "peso_bruto":
	                $valorCantidad = $pesoBrutoOrigen;
	                break;
	        }	        
	        
	    }
	    
	    echo json_encode(array(
	        'resultado' => $resultado,
	        'validacion' => $validacion,
	        'cantidad' => $valorCantidad
	    ));
	    
	}
	
}
