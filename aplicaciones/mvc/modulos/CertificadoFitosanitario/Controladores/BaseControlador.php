<?php

/**
 * Controlador Base
 *
 * Este archivo contiene métodos comunes para todos los controladores
 *
 * @property AGROCALIDAD
 * @author Carlos Anchundia
 * @date      2022-07-21
 * @uses BaseControlador
 * @package CertificadoFitosanitario
 * @subpackage Controladores
 */
namespace Agrodb\CertificadoFitosanitario\Controladores;

session_start();

use Agrodb\Core\Comun;
use Agrodb\Catalogos\Modelos\IdiomasLogicaNegocio;
use Agrodb\CertificadoFitosanitario\Modelos\PaisesPuertosTransitoLogicaNegocio;
use Agrodb\Catalogos\Modelos\TiposProduccionFitosanitariasLogicaNegocio;
use Agrodb\Catalogos\Modelos\MediosTransporteLogicaNegocio;
use Agrodb\Catalogos\Modelos\PuertosLogicaNegocio;
use Agrodb\CertificadoFitosanitario\Modelos\PaisesPuertosDestinoLogicaNegocio;
use Agrodb\CertificadoFitosanitario\Modelos\CertificadoFitosanitarioProductosLogicaNegocio;
use Agrodb\RegistroOperador\Modelos\OperadoresLogicaNegocio;
use Agrodb\CertificadoFitosanitario\Modelos\DocumentosAdjuntosLogicaNegocio;
use Agrodb\Financiero\Modelos\OrdenPagoLogicaNegocio;
use Agrodb\GUath\Modelos\FichaEmpleadoLogicaNegocio;
use Agrodb\Catalogos\Modelos\UnidadesFitosanitariasLogicaNegocio;
use Agrodb\CertificadoFitosanitario\Modelos\CertificadoFitosanitarioLogicaNegocio;
use Agrodb\InspeccionFitosanitaria\Modelos\TotalInspeccionFitosanitariaLogicaNegocio;
use Agrodb\InspeccionFitosanitaria\Modelos\InspeccionFitosanitariaLogicaNegocio;
use Agrodb\Catalogos\Modelos\LocalizacionLogicaNegocio;

class BaseControlador extends Comun{

	public $itemsFiltrados = array();

	public $codigoJS = null;
	
	public $lNegocioIdiomasBc = null;
	
	public $lNegocioMediosTransporteBc = null;
	
	public $lNegocioPuertosBc = null;
	
	public $lNegocioPaisesPuertosDestinoBc = null;
	
	public $lNegocioPaisesPuertosTransitoBc = null;
	
	public $lNegocioTiposProduccionFitosanitariasBc = null;
	
	public $lNegocioOperadoresBc = null;
	
	public $lNegocioDocumentosAdjuntosBc = null;
	
	public $lNegocioOrdenPagoBc = null;
	
	public $lNegocioFichaEmpleadoBc = null;
	
	public $lNegocioUnidadesFitosanitariasBc = null;
	
	public $lNegocioCertificadoFitosanitarioBc = null;
	
	public $lNegocioTotalInspeccionFitosanitariaBc = null;
	
	public $lNegocioInspeccionFitosanitariaBc = null;
	
	public $lNegocioLocalizacionBc = null;

	/**
	 * Constructor
	 */
	function __construct($destinoUrl = true){
	    if($destinoUrl){
	        parent::usuarioActivo();
	    }
		// Si se requiere agregar código concatenar la nueva cadena con ejemplo $this->codigoJS.=alert('hola');
		$this->codigoJS = \Agrodb\Core\Mensajes::limpiar();
		$this->lNegocioIdiomasBc = new IdiomasLogicaNegocio();
		$this->lNegocioMediosTransporteBc = new MediosTransporteLogicaNegocio();
		$this->lNegocioPuertosBc = new PuertosLogicaNegocio();
		$this->lNegocioPaisesPuertosDestinoBc = new PaisesPuertosDestinoLogicaNegocio();
		$this->lNegocioPaisesPuertosTransitoBc = new PaisesPuertosTransitoLogicaNegocio();
		$this->lNegocioTiposProduccionFitosanitariasBc = new TiposProduccionFitosanitariasLogicaNegocio();
		$this->lNegocioCertificadoFitosanitarioProductoBc = new CertificadoFitosanitarioProductosLogicaNegocio();
		$this->lNegocioOperadoresBc = new OperadoresLogicaNegocio();
		$this->lNegocioDocumentosAdjuntosBc = new DocumentosAdjuntosLogicaNegocio();
		$this->lNegocioOrdenPagoBc = new OrdenPagoLogicaNegocio();
		$this->lNegocioFichaEmpleadoBc = new FichaEmpleadoLogicaNegocio();
		$this->lNegocioUnidadesFitosanitariasBc = new UnidadesFitosanitariasLogicaNegocio();
		$this->lNegocioCertificadoFitosanitarioBc = new CertificadoFitosanitarioLogicaNegocio();
		$this->lNegocioTotalInspeccionFitosanitariaBc = new TotalInspeccionFitosanitariaLogicaNegocio();
		$this->lNegocioInspeccionFitosanitariaBc = new InspeccionFitosanitariaLogicaNegocio();
		$this->lNegocioLocalizacionBc = new LocalizacionLogicaNegocio();
		
		$this->rutaFecha = date('Y').'/'.date('m').'/'.date('d');
	}

	public function crearTabla(){
		$tabla = "//No existen datos para mostrar...";
		if (count($this->itemsFiltrados) > 0){
			$tabla = '$(document).ready(function() {
			construirPaginacion($("#paginacion"),' . json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE) . ');
			$("#listadoItems").removeClass("comunes");
			});';
		}

		return $tabla;
	}
	
	public function construirDatosGenealesCertificadoFitosanitario($certificadoFitosanitario, $tipoUsuario){
		
	    $datosReemplazo = "";
		$datosEliminacion = "";
	    
		if($certificadoFitosanitario){
			$estadoCertificadoFitosanitario = $certificadoFitosanitario->getEstadoCertificado();
			$esReemplazo = $certificadoFitosanitario->getEsReemplazo();
			
			if($esReemplazo === "Si"){
			    $idCertificadoReemplazo = $certificadoFitosanitario->getIdCertificadoReemplazo();
			    
			    $qDatosCertificadoReemplazo = $this->lNegocioCertificadoFitosanitarioBc->buscarLista(array('id_certificado_fitosanitario' => $idCertificadoReemplazo));
			    $codigoCertificadoReemplazo = $qDatosCertificadoReemplazo->current()->codigo_certificado;
			    $motivoReemplazo = $qDatosCertificadoReemplazo->current()->motivo_reemplazo;
			    
			    $datosReemplazo = '<hr/><div data-linea="12">
                                    <label for="motivo_reemplazo">Motivo de anulación y reemplazo:</label> ' . $motivoReemplazo . '
                                    </div>
                                    <div data-linea="13">
						          <p class="nota">Este certificado reemplaza y anula al certificado fitosanitario N° <b>'
			        . $codigoCertificadoReemplazo .
			        '</b>.</p></div>';
			}
			
			if($estadoCertificadoFitosanitario === "Eliminado"){
			    
			    $motivoEliminacion = $certificadoFitosanitario->getObservacionRevision();
			    
			    $datosEliminacion = '<hr/><div data-linea="14">
                                    <label for="motivo_eliminacion">Motivo de eliminación:</label> ' . $motivoEliminacion . '
                                    </div>';
			}
			
		}else{
			$estadoCertificadoFitosanitario = null;
		}
					
		$datos = "";
		$datosAnulacionReemplazo = "";		
		
		switch ($estadoCertificadoFitosanitario) {
			case 'Creado':
			case 'Documental':
			case 'pago':
			case 'verificacion':
			case 'Aprobado':
			case 'Rechazado':
			case 'Subsanacion':
			case 'Subsanado':
			case 'Anulado':
			case 'generarOrden':
			case 'Eliminado':
				
				$nombreIdioma = "";
				$nombreMedioTrasporte = "";
				$nombrePuertoEmbarque = "";
				$codigoCertificado = "N/A";
				
				if($certificadoFitosanitario->getCodigoCertificado() != null){
				    $codigoCertificado = $certificadoFitosanitario->getCodigoCertificado();
				}
				
				$idIdioma = $certificadoFitosanitario->getIdIdioma();
				$idMedioTransporte = $certificadoFitosanitario->getIdMedioTransporte();
				$idPuertoEmbarque = $certificadoFitosanitario->getIdPuertoEmbarque();
				
				$qDatosIdioma = $this->lNegocioIdiomasBc->buscar($idIdioma);
				$codigoIdioma = $qDatosIdioma->getCodigoIdioma();
				
				$qDatosMedioTransporte = $this->lNegocioMediosTransporteBc->buscar($idMedioTransporte);
				
				$qDatosPuertoEmbarque = $this->lNegocioPuertosBc->buscar($idPuertoEmbarque);
				$nombrePuertoEmbarque = $qDatosPuertoEmbarque->getNombrePuerto();
				
				switch ($codigoIdioma) {
					case 'SPA':
						$nombreIdioma = $qDatosIdioma->getNombreIdioma();
						$nombreMedioTrasporte = $qDatosMedioTransporte->getTipo();
						break;
					case 'ENG':
						$nombreIdioma = $qDatosIdioma->getNombreIdiomaIngles();
						$nombreMedioTrasporte = $qDatosMedioTransporte->getTipoIngles();
						break;
				}
				
				$idTipoProduccion = $certificadoFitosanitario->getIdTipoProduccion();
				$qTipoProduccion = $this->lNegocioTiposProduccionFitosanitariasBc->buscar($idTipoProduccion);
				$nombreTipoProduccion = $qTipoProduccion->getNombreTipoProduccionFitosanitaria();
				
				$datos .= '<div data-linea="1">
						<label for="codigo_certificado">Código de certificado: </label>' . $codigoCertificado . '</div>
                    <div data-linea="2">
						<label for="tipo_solicitud">Tipo de Solicitud: </label>' . $this->equivalenciaTipoSolicitud($certificadoFitosanitario->getTipoSolicitud()) . '</div>
					<div data-linea="2">
						<label for="id_idioma">Idioma: </label>' . $nombreIdioma . '</div>
					<hr/>
					<div data-linea="3">
						<label for="id_tipo_produccion">Tipo de producción: </label>' . $nombreTipoProduccion . '</div>
					<div data-linea="3">
						<label for="id_medio_transporte">Medio de Transporte: </label>' . $nombreMedioTrasporte . '</div>';
				
				if(($estadoCertificadoFitosanitario === "Creado" || $estadoCertificadoFitosanitario === "Subsanacion") && $tipoUsuario === "Externo"){
				    				    
					$datos .= '<div data-linea="4">
    						<label for="fecha_embarque">Fecha de Embarque: </label> <input
    							type="text" id="fecha_embarque" name="fecha_embarque" value="' . date('Y-m-d', strtotime($certificadoFitosanitario->getFechaEmbarque())) . '" 
                                placeholder="Ejm: 2021-02-01" class="validacion" readonly="readonly" autocomplete="off" />
    					</div>
                        <div data-linea="4">
						<label for="id_puerto_embarque">Puerto de Embarque: </label> <select
							id="id_puerto_embarque" name="id_puerto_embarque" class="validacion">'
    						. $this->obtenerPuertosPorNombreMedioTransporteSubsanacion($nombreMedioTrasporte, $idPuertoEmbarque) .
						'</select>
                        </div>
					    <hr/>
                        <div data-linea="6">
							<label for="nombre_marca">Nombre de Marcas: </label> <input
								type="text" id="nombre_marca" name="nombre_marca" value="' . $certificadoFitosanitario->getNombreMarca() . '"
								placeholder="Ejm: Marca A" class="validacion" maxlength="200" autocomplete="off" />
						</div>
						<div data-linea="7">
							<label for="nombre_consignatario">Nombre del Consignatario: </label>
							<input type="text" id="nombre_consignatario"
								name="nombre_consignatario" value="' . $certificadoFitosanitario->getNombreConsignatario() . '"
								placeholder="Ejm: Juan Adrés Torres Mejía" class="validacion" maxlength="200" autocomplete="off" />
						</div>
						<div data-linea="8">
							<label for="direccion_consignatario">Dirección del Consignatario: </label>
							<input type="text" id="direccion_consignatario"
								name="direccion_consignatario" value="' . $certificadoFitosanitario->getDireccionConsignatario() . '"
								placeholder="Ejm: Av. Vicente Rocafuerte" class="validacion" maxlength="200" autocomplete="off" />
						</div>
                        <div data-linea="9">
                        <label for="codigo_certificado_importacion">N° permiso importación: </label>
						<input type="text" id="codigo_certificado_importacion"
							name="codigo_certificado_importacion" value="' . $certificadoFitosanitario->getCodigoCertificadoImportacion() . '"
							placeholder="Ejm: 12456789651" maxlength="50" autocomplete="off" />
					</div>
						<hr/>
						<div data-linea="10">
							<label for="informacion_adicional">Información Adicional del Envío: </label>
						</div>
						<div data-linea="11">
							<textarea id="informacion_adicional" name="informacion_adicional" placeholder="Ingrese información adicional" maxlength="15000" autocomplete="off">' . $certificadoFitosanitario->getInformacionAdicional() . '</textarea>
						</div>'
					   . $datosReemplazo;
				}else{
				    
				    if($estadoCertificadoFitosanitario === "Anulado"){				    
    				    $datosAnulacionReemplazo = '<hr/><div data-linea="12">
                                                    <label for="motivo_reemplazo">Motivo de anulación y reemplazo: </label>'
                                					. $certificadoFitosanitario->getMotivoReemplazo() .
                                					'</div>';
				    }
					
					$datos .= '<div data-linea="4">
						<label for="fecha_embarque">Fecha de Embarque: </label>' . date('Y-m-d', strtotime($certificadoFitosanitario->getFechaEmbarque())) . '</div>
					<div data-linea="4">
						<label for="id_puerto_embarque">Puerto de Embarque: </label>' . $nombrePuertoEmbarque . '</div>
					<hr/>
                        <div data-linea="6">
						<label for="nombre_marca">Nombre de Marcas: </label>'
						. $certificadoFitosanitario->getNombreMarca() .
						'</div>
					<div data-linea="7">
						<label for="nombre_consignatario">Nombre del Consignatario: </label>'
						. $certificadoFitosanitario->getNombreConsignatario() .
					'</div>
					<div data-linea="8">
						<label for="direccion_consignatario">Dirección del Consignatario: </label>'
						. $certificadoFitosanitario->getDireccionConsignatario() .
					'</div>
                    <div data-linea="9">
                        <label for="codigo_certificado_importacion">N° permiso importación: </label>'
                        . $certificadoFitosanitario->getCodigoCertificadoImportacion() .
					'</div>
					<hr/>
					<div data-linea="10">
						<label for="informacion_adicional">Información Adicional del Envío: </label>
					</div>
					<div data-linea="11">'
						. $certificadoFitosanitario->getInformacionAdicional() .
					'</div>' . $datosAnulacionReemplazo . $datosReemplazo . $datosEliminacion;
					
				}							
				
				break;
			default:
				
				$datos = '<div data-linea="1">
					<label for="tipo_solicitud">Tipo de Solicitud: </label>
					<select id="tipo_solicitud" name="tipo_solicitud" class="validacion">
						<option value="">Seleccione....</option>
						<option value="musaceas">Musáceas</option>
						<option value="otros">Otros</option>
						<!-- option value="ornamentales">Ornamentales</option>
						<option value="otros">Otros</option -->
					</select>
					</div>
					<div data-linea="1">
						<label for="id_idioma">Idioma: </label>
						<select id="id_idioma"name="id_idioma" class="validacion" disabled="disabled">
							<option value="">Seleccione....</option>' . $this->comboIdiomas() . '</select>
					</div>
					<hr/>
					<div data-linea="3">
						<label for="id_tipo_produccion">Tipo de producción:</label>
						<select id="id_tipo_produccion" name="id_tipo_produccion" class="validacion" disabled="disabled">
							<option value="">Seleccionar....</option>
						</select>
					</div>
					<div data-linea="3">
						<label for="id_medio_transporte">Medio de Transporte: </label>
						<select id="id_medio_transporte" name="id_medio_transporte" class="validacion" disabled="disabled">
							<option value="">Seleccione....</option>' . $this->comboMediosTransportePorIdioma('ESP') . '</select>
					</div>
					<div data-linea="4">
						<label for="fecha_embarque">Fecha de Embarque: </label> <input
							type="text" id="fecha_embarque" name="fecha_embarque" value="" placeholder="Ejm: 2021-02-01" class="validacion" readonly="readonly" disabled="disabled" autocomplete="off" />
					</div>
					<div data-linea="4">
						<label for="id_puerto_embarque">Puerto de Embarque: </label> <select
							id="id_puerto_embarque" name="id_puerto_embarque" class="validacion"
							disabled="disabled">
							<option value="">Seleccionar....</option>
						</select>
					</div>
					<hr/>
					<div data-linea="6">
						<label for="nombre_marca">Nombre de Marcas: </label> <input
							type="text" id="nombre_marca" name="nombre_marca" value=""
							placeholder="Ejm: Marca A" class="validacion" maxlength="200" autocomplete="off" />
					</div>
					<div data-linea="7">
						<label for="nombre_consignatario">Nombre del Consignatario: </label>
						<input type="text" id="nombre_consignatario"
							name="nombre_consignatario" value=""
							placeholder="Ejm: Juan Adrés Torres Mejía" class="validacion" maxlength="200" autocomplete="off" />
					</div>
					<div data-linea="8">
						<label for="direccion_consignatario">Dirección del Consignatario: </label>
						<input type="text" id="direccion_consignatario"
							name="direccion_consignatario" value=""
							placeholder="Ejm: Av. Vicente Rocafuerte" class="validacion" maxlength="200" autocomplete="off" />
					</div>										
                    <div data-linea="9">
                        <label for="codigo_certificado_importacion">N° permiso importación: </label>
						<input type="text" id="codigo_certificado_importacion"
							name="codigo_certificado_importacion" value=""
							placeholder="Ejm: 12456789651" maxlength="50" autocomplete="off" />
					</div>
                    <hr/>
                    <div data-linea="10">
						<label for="informacion_adicional">Información Adicional del Envío: </label>
					</div>
					<div data-linea="11">
						<textarea id="informacion_adicional" name="informacion_adicional" placeholder="Ingrese información adicional" maxlength="15000" autocomplete="off" ></textarea>
					</div>';
				break;
		}
		
		return '<fieldset>
                        <legend>Datos generales</legend>' . $datos . '</fieldset>';
	}
	
	/**
	 * Metodo para construir los datos generales de un certificado fitosanitario
	 */
	public function construirDatosFormaPago($certificadoFitosanitario, $tipoUsuario){
		
		if($certificadoFitosanitario){
			$estadoCertificadoFitosanitario = $certificadoFitosanitario->getEstadoCertificado();
		}else{
			$estadoCertificadoFitosanitario = null;
		}
		
		$datos = "";
		$accion = "";
		$descuento = "";
		$motivoDescuento = "";
		$datosOrdenPago = "";
				
		switch ($estadoCertificadoFitosanitario) {
			case 'Creado':
			case 'Documental':
			case 'pago':
			case 'verificacion':
			case 'Aprobado':
			case 'Rechazado':
			case 'Subsanacion':
			case 'Subsanado':
			case 'Anulado':
			case 'generarOrden':
			case 'Eliminado':
			    
			    $idCertificadoFitosanitario = $certificadoFitosanitario->getIdCertificadoFitosanitario();
				$tipoSolicitud = $certificadoFitosanitario->getTipoSolicitud();
			    $esReemplazo = $certificadoFitosanitario->getEsReemplazo();
				$formaPago = $certificadoFitosanitario->getFormaPago();
				$estadoPago = "";
				
				if(($estadoCertificadoFitosanitario === "Creado" || $estadoCertificadoFitosanitario === "Subsanacion") && $tipoUsuario === "Externo"){
					$accion = '<div data-linea="1">
								<button type="submit" class="guardar">Guardar</button>
							</div>';	
				}
				
				if($formaPago === "efectivo"){
                    $estadoPago = '3';
				}
				
				if($formaPago === "saldo"){
				    switch($tipoSolicitud){				        
				        case 'musaceas':
				            $estadoPago = '5';
				            break;
				        default:
				            $estadoPago = '3';
				            break;
				    }
				}
				
				if(empty($esReemplazo)){
				
    				if ($estadoCertificadoFitosanitario === 'verificacion' || $estadoCertificadoFitosanitario === 'Aprobado') {
    				    
    				    $datosConsultaFinanciero = [
    				        'id_solicitud' => $idCertificadoFitosanitario,
    				        'tipo_solicitud' => 'certificadoFito',
    				        'estado' => $estadoPago
    				    ];
    				    
    					$qDatosFinanciero = $this->lNegocioOrdenPagoBc->buscarLista($datosConsultaFinanciero);
    					
    					if($qDatosFinanciero->count()){				
        										
        					$totalPagar = $qDatosFinanciero->current()->total_pagar;
        					$ordenPago = $qDatosFinanciero->current()->orden_pago; 				
        					
        					$datosOrdenPago = '<div data-linea="4">
        											<label>Monto a pagar:</label> <span class="alerta">$ ' .$totalPagar . '</span>
        											</br><a href="' . $ordenPago . '" target="_blank" class="archivo_cargado" id="archivo_cargado">Descargar orden de pago</a>
        										</div>';
    					
    					}
    					
    					$datosConsultaFinanciero = [
    					    'id_solicitud' => $idCertificadoFitosanitario,
    					    'tipo_solicitud' => 'certificadoFito',
    					    'estado' => 4
    					];
    					
    					$qDatosFinanciero = $this->lNegocioOrdenPagoBc->buscarLista($datosConsultaFinanciero);
    					
    					if($qDatosFinanciero->count()){
    					    
    					    $totalPagar = $qDatosFinanciero->current()->total_pagar;
    					    $factura = $qDatosFinanciero->current()->comprobante_factura;
    					    
    					    $datosOrdenPago = '<div data-linea="4">
        											<label>Monto pagado:</label> <span class="alerta">$ ' .$totalPagar . '</span>
        											</br><a href="' . $factura . '" target="_blank" class="archivo_cargado" id="archivo_cargado">Descargar factura</a>
        										</div>';
    					    
    					}
    					
    				}
				
				}
				
				$motivoDescuento = ($certificadoFitosanitario->getMotivoDescuento() != null ? $certificadoFitosanitario->getMotivoDescuento() : "N/A");
				$descuento = ($certificadoFitosanitario->getDescuento() != null ? $certificadoFitosanitario->getDescuento() : "N/A");
				$formaPago = $certificadoFitosanitario->getFormaPago();
												
				$datos = '<div data-linea="1">
									<label for="forma_pago">Forma de Pago: </label>' . $this->equivalenciaFormaPago($formaPago) . '</div>
								<div data-linea="2">
									<label for="descuento">Descuento: </label>' . $descuento . '</div>
								<div data-linea="3">
									<label for="motivo_descuento">Motivo del Descuento: </label>' . $motivoDescuento . '</div>' . $datosOrdenPago;
				break;
			default:
				$datos = '<div data-linea="1">
					<label for="forma_pago">Forma de Pago: </label> <select
					id="forma_pago" name="forma_pago" class="validacion"
						disabled="disabled">' . $this->cargarFormaPago() . '</select>
						</div>
						<div data-linea="1">
							<label for="descuento">Descuento: </label> <select id="descuento"
								name="descuento" class="validacion" disabled="disabled">' . $this->comboSiNo() . '</select>
						</div>
						<div data-linea="2">
							<label for="motivo_descuento">Motivo del Descuento: </label> <input
								type="text" id="motivo_descuento" name="motivo_descuento" value=""
								placeholder="Ingrese el motivo del descuento" maxlength="64" class="validacion"
								disabled="disabled" />
						</div>';
				break;
		}
		return '<fieldset>
                        <legend>Forma de Pago</legend>' . $datos . '</fieldset>'
                        	. $accion;
	}
	
	/**
	 * Metodo para construir los datos de los productos
	 */
	public function construirDatosProductos($certificadoFitosanitario, $tipoUsuario){
		
		$idCertificadoFitosanitario = $certificadoFitosanitario->getIdCertificadoFItosanitario();
	    $estadoCertificadoFitosanitario = $certificadoFitosanitario->getEstadoCertificado();
	    $esReemplazo = $certificadoFitosanitario->getEsReemplazo();
				
		$qDatosCertificadoFitosanitario = $this->lNegocioCertificadoFitosanitarioBc->buscar($idCertificadoFitosanitario);
		$idIdiomaCertificado = $qDatosCertificadoFitosanitario->getIdIdioma();
		
		$qDatosIdioma = $this->lNegocioIdiomasBc->buscar($idIdiomaCertificado);
		$codigoIdioma = $qDatosIdioma->getCodigoIdioma();
		
		$datosNumeroInspeccion = "";
		$datos = "";
		$filaProducto = "";
		$accion = "";
		$query = 'id_certificado_fitosanitario =' . $certificadoFitosanitario->getIdCertificadoFitosanitario() . ' ORDER BY id_certificado_fitosanitario_producto ASC';
		
		$qDatosCertificadoFitosanitarioProductos = $this->lNegocioCertificadoFitosanitarioProductoBc->buscarLista($query);
		
		foreach ($qDatosCertificadoFitosanitarioProductos as $item) {
						
			$idCertificadoFitosanitarioProducto = $item['id_certificado_fitosanitario_producto'];
			$nombreSubtipoProducto = $item['nombre_subtipo_producto'];
			$nombreProducto = $item['nombre_producto'];
			$cantidadComercial = $item['cantidad_comercial'];
			$idUnidadCantidadComercial = $item['id_unidad_cantidad_comercial'];
			$pesoNeto = $item['peso_neto'];
			$idUnidadPesoNeto = $item['id_unidad_peso_neto'];
			$pesoBruto = $item['peso_bruto'];
			$idUnidadPesoBruto = $item['id_unidad_peso_bruto'];
			$idTotalInspeccionFitosanitaria = $item['id_total_inspeccion_fitosanitaria'];
			
			if((($estadoCertificadoFitosanitario === "Creado" && empty($esReemplazo)) || ($estadoCertificadoFitosanitario === "Subsanacion" && empty($esReemplazo))) && $tipoUsuario === "Externo"){
				$accion = '<td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarDetalleProducto(' . $idCertificadoFitosanitarioProducto . '); return false;"/></td>';
			}
			
			$qDatosTotalInspeccion = $this->lNegocioTotalInspeccionFitosanitariaBc->buscar($idTotalInspeccionFitosanitaria);
			$idInspeccionFitosanitaria = $qDatosTotalInspeccion->getIdInspeccionFitosanitaria();
			$qDatosInspeccion= $this->lNegocioInspeccionFitosanitariaBc->buscar($idInspeccionFitosanitaria);
			$numeroInspeccion = $qDatosInspeccion->getNumeroSolicitud();
			
			if($esReemplazo === "Si" && $tipoUsuario === "Externo"){
			    
			    switch ($estadoCertificadoFitosanitario){
			    
			        case 'Creado':
			        case 'Subsanacion':
        			    $filaProducto .= '<tr id="filapr' . $idCertificadoFitosanitarioProducto . '">
                                    <td>' . $numeroInspeccion . '</td>
                                    <td>' . $nombreSubtipoProducto . '/' . $nombreProducto . '</td>
                                    <td><input type="text" name="cantidad_comercial" value="' . $cantidadComercial . '" style="width: 70px;" onchange="actualizarCantidades(' . $idCertificadoFitosanitarioProducto . ', this)"  maxlenght="10" oninput="formatearCantidadProducto(this)" onchange="validarCantidades(' . $idTotalInspeccionFitosanitaria . ', this)" > ' . $this->obtenerUnidadFitosanitaria($idUnidadCantidadComercial, $codigoIdioma). '</td>
        							<td><input type="text" name="peso_neto" value="' . $pesoNeto . '" style="width: 70px;" onchange="actualizarCantidades(' . $idCertificadoFitosanitarioProducto . ', this)" maxlenght="10" oninput="formatearCantidadProducto(this)" onchange="validarCantidades(' . $idTotalInspeccionFitosanitaria . ', this)" > ' . $this->obtenerUnidadFitosanitaria($idUnidadPesoNeto, $codigoIdioma) . '</td>
        							<td><input type="text" name="peso_bruto" value="' . $pesoBruto . '" style="width: 70px;" onchange="actualizarCantidades(' . $idCertificadoFitosanitarioProducto . ', this)" maxlenght="10" oninput="formatearCantidadProducto(this)" onchange="validarCantidades(' . $idTotalInspeccionFitosanitaria . ', this)" > ' . (isset($idUnidadPesoBruto) ? $this->obtenerUnidadFitosanitaria($idUnidadPesoBruto, $codigoIdioma) : '') . '</td>'
        							    . $accion .
        							    '</tr>';
        			break;
        			default:
        			    $filaProducto .= '<tr id="filapr' . $idCertificadoFitosanitarioProducto . '">
                            <td>' . $numeroInspeccion . '</td>
                            <td>' . $nombreSubtipoProducto . '/' . $nombreProducto . '</td>
                            <td>' . $cantidadComercial . ' ' . $this->obtenerUnidadFitosanitaria($idUnidadCantidadComercial, $codigoIdioma). '</td>
							<td>' . $pesoNeto . ' ' . $this->obtenerUnidadFitosanitaria($idUnidadPesoNeto, $codigoIdioma) . '</td>
							<td>' . $pesoBruto . ' ' . (isset($idUnidadPesoBruto) ? $this->obtenerUnidadFitosanitaria($idUnidadPesoBruto, $codigoIdioma) : '') . '</td>'
							    . $accion .
							    '</tr>';
        			break;
			    
			    }
			    
			}else{
			    
			    $filaProducto .= '<tr id="filapr' . $idCertificadoFitosanitarioProducto . '">
                            <td>' . $numeroInspeccion . '</td>
                            <td>' . $nombreSubtipoProducto . '/' . $nombreProducto . '</td>
                            <td>' . $cantidadComercial . ' ' . $this->obtenerUnidadFitosanitaria($idUnidadCantidadComercial, $codigoIdioma). '</td>
							<td>' . $pesoNeto . ' ' . $this->obtenerUnidadFitosanitaria($idUnidadPesoNeto, $codigoIdioma) . '</td>
							<td>' . $pesoBruto . ' ' . (isset($idUnidadPesoBruto) ? $this->obtenerUnidadFitosanitaria($idUnidadPesoBruto, $codigoIdioma) : '') . '</td>'
							    . $accion .
							    '</tr>';
			    
			}
			
		}
		
		switch ($estadoCertificadoFitosanitario) {
			case 'Creado':
			case 'Subsanacion':
			    
			    if($tipoUsuario === "Externo" && empty($esReemplazo)){
			        $datosNumeroInspeccion = '<div data-linea="1">
							<label for="numero_solicitud_inspeccion">Número de inspección: </label>
							<input type="text" id="numero_solicitud_inspeccion" name="numero_solicitud_inspeccion" value="" class="validacion" autocomplete="off">
						</div>
						<table style="width:100%">
						<thead>
						<tr>
							<th></th>
							<th>Producto</th>
							<th>Cantidad disponible</th>
							<th>Peso disponible</th>
							<th>Cantidad</th>
							<th>Peso neto</th>
							<th>Peso bruto</th>
						</tr>
						</thead>
						<tbody id="tProductosInspeccion">
						</tbody>
						</table>
						<div data-linea="2">
							<button type="button" class="mas" id="agregarProductoInspeccion">Agregar</button>
						</div>';
			    }
			    
				$datos = $datosNumeroInspeccion . '<table style="width:100%">
						<thead>
						<tr>
						</tr>
						<th colspan="6">Productos agregados</th>
						<tr>
                            <th>N° inspección</th>
							<th>Producto</th>
							<th>Cantidad</th>
							<th>Peso neto</th>
							<th>Peso bruto</th>
							<th></th>
						</tr>
						</thead>
						<tbody id="tProductosExportacion">'
						. $filaProducto .
						'</tbody>
						</table>';
				break;
			case 'Documental':
			case 'pago':
			case 'verificacion':
			case 'Aprobado':
			case 'Rechazado':
			case 'Subsanado':
			case 'Anulado':
			case 'generarOrden':
			case 'Eliminado':
				
				$datos = '<table style="width:100%">
						<thead>
						<tr>
						</tr>
						<th colspan="6">Productos agregados</th>
						<tr>
                        <th>N° inspección</th>
						<th>Producto</th>
						<th>Cantidad</th>
						<th>Peso neto</th>
						<th>Peso bruto</th>
						<th></th>
						</tr>
						</thead>
						<tbody id="tProductosExportacion">'
						. $filaProducto .
						'</tbody>
						</table>';
				break;
		}
		return '<fieldset id="fProductosExportacion">
                        <legend>Productos</legend>' . $datos . '</fieldset>';
	}
	
	/**
	 * Metodo para construir los datos de los puertos de destino
	 */
	public function construirDatosPuertosDestino($certificadoFitosanitario, $tipoUsuario){
		
		$estadoCertificadoFitosanitario = $certificadoFitosanitario->getEstadoCertificado();
		$esReemplazo = $certificadoFitosanitario->getEsReemplazo();
		
		$datosPaisPuerto = "";
		$datos = "";
		$filaPaisPuertoDestino = "";
		$accion = "";
		$idIdioma = $certificadoFitosanitario->getIdIdioma();
		$comboPaises = "";
		
		$qDatosIdioma = $this->lNegocioIdiomasBc->buscar($idIdioma);
		$codigoIdioma = $qDatosIdioma->getCodigoIdioma();
		
		$qDatosPaisPuertoDestino = $this->lNegocioPaisesPuertosDestinoBc->buscarLista(array('id_certificado_fitosanitario' => $certificadoFitosanitario->getIdCertificadoFitosanitario()));
		
		foreach ($qDatosPaisPuertoDestino as $item) {
			
		    $idPaisDestino = $item['id_pais_destino'];
			$idPaisPuertoDestino = $item['id_pais_puerto_destino'];
			$nombrePaisDestino = $item['nombre_pais_destino'];
			$nombrePuertoDestino = $item['nombre_puerto_destino'];
			
			if(($estadoCertificadoFitosanitario === "Creado" || $estadoCertificadoFitosanitario === "Subsanacion") && $tipoUsuario === "Externo"){
				$accion = '<td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarDetallePaisPuertoDestino(' . $idPaisPuertoDestino . '); return false;"/></td>';
			}		
			
			$filaPaisPuertoDestino .= '<tr id="filapd' . $idPaisPuertoDestino . '">
                            <td>' . $nombrePaisDestino . '</td>
                            <td>' . $nombrePuertoDestino . '</td>'
                            . $accion .
                       '</tr>';
		}
		
		if($esReemplazo === "Si"){
		    $comboPaises = $this->comboPaisesPorIdioma($codigoIdioma, $idPaisDestino, false);		    
		}else{
		    $comboPaises = $this->comboPaisesPorIdioma($codigoIdioma, null, true);
		}
		
		switch ($estadoCertificadoFitosanitario) {
			case 'Creado':
			case 'Subsanacion':
				
			    if($tipoUsuario === "Externo"){
			        $datosPaisPuerto = '<div data-linea="1">
							<label for="id_pais_destino">País de destino: </label>
							<select id="id_pais_destino" name="id_pais_destino" class="validacion">
								<option value="">Seleccione...</option>'
			            . $comboPaises .
						'</select>
						</div>
						<div data-linea="2">
							<label for="id_puerto_destino">Puerto de destino: </label>
							<select id="id_puerto_destino" name="id_puerto" class="validacion">
							<option value="">Seleccione...</option>
						</select>
						</div>						
						<div data-linea="3">
							<button type="button" class="mas" id="agregarPaisPuertoDestino">Agregar</button>
						</div>';
			    }
			    
				$datos = $datosPaisPuerto . '<table style="width:100%">
						<thead>
						<tr>
							<th>País</th>
							<th>Puerto</th>
							<th></th>
						</tr>
						</thead>
						<tbody id="tPuertoDestino">'
							. $filaPaisPuertoDestino .
							'</tbody>
						</table>';
				
			    
				break;
			case 'Documental':
			case 'pago':
			case 'verificacion':
			case 'Aprobado':
			case 'Rechazado':
			case 'Subsanado':
			case 'Anulado':
			case 'generarOrden':
			case 'Eliminado':
			    
				$datos = '<table style="width:100%">
						<thead>
						<tr>
							<th>País</th>
							<th>Puerto</th>
							<th></th>
						</tr>
						</thead>
						<tbody id="tPuertoDestino">'
							. $filaPaisPuertoDestino .
							'</tbody>
						</table>';
				break;
		}
		return '<fieldset id="fPuertoDestino">
               <legend>Puertos de destino</legend>' . $datos . '</fieldset>';
	}
	
	/**
	 * Metodo para construir los datos de los puertos de transito
	 */
	public function construirDatosPuertosTransito($certificadoFitosanitario, $tipoUsuario){
		
		$estadoCertificadoFitosanitario = $certificadoFitosanitario->getEstadoCertificado();
		
		$datosPaisPuerto = "";
		$datos = "";
		$filaPaisPuertoTransito = "";
		$accion = "";
		$idIdioma = $certificadoFitosanitario->getIdIdioma();
		
		$qDatosIdioma = $this->lNegocioIdiomasBc->buscar($idIdioma);
		$codigoIdioma = $qDatosIdioma->getCodigoIdioma();
		
		$qDatosPaisPuertoTransito = $this->lNegocioPaisesPuertosTransitoBc->buscarLista(array('id_certificado_fitosanitario' => $certificadoFitosanitario->getIdCertificadoFitosanitario()));
		
		foreach ($qDatosPaisPuertoTransito as $item) {
			
			$idPaisPuertoTransito = $item['id_pais_puerto_transito'];
			$nombrePaisTransito = $item['nombre_pais_transito'];
			$nombrePuertoTransito = $item['nombre_puerto_transito'];
			$nombreMedioTransporteTransito = $item['nombre_medio_transporte_transito'];
			
			if(($estadoCertificadoFitosanitario === "Creado" || $estadoCertificadoFitosanitario === "Subsanacion") && $tipoUsuario === "Externo"){
				$accion = '<td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarDetallePaisPuertoTransito(' . $idPaisPuertoTransito . '); return false;"/></td>';
			}			
			
			$filaPaisPuertoTransito .= '<tr id="filappt' . $idPaisPuertoTransito . '">
                            <td>' . $nombrePaisTransito . '</td>
                            <td>' . $nombrePuertoTransito . '</td>
                            <td>' . $nombreMedioTransporteTransito . '</td>'
                            . $accion . 
                       		'</tr>';
		}		
		
		switch ($estadoCertificadoFitosanitario) {
			case 'Creado':
			case 'Subsanacion':
				
			    if($tipoUsuario === "Externo"){
			        $datosPaisPuerto = '<div data-linea="1">
							<label for="id_pais_transito">País de tránsito: </label>
							<select id="id_pais_transito" name="id_pais_transito" class="validacion">
							<option value="">Seleccione...</option>'
					. $this->comboPaisesPorIdioma($codigoIdioma, null, true) .
					'</select>
						</div>
						<div data-linea="1">
							<label for="id_puerto_transito">Puerto de tránsito: </label>
							<select id="id_puerto_transito" name="id_puerto_transito" class="validacion">
							<option value="">Seleccione...</option>
						</select>
						</div>
						<div data-linea="2">
							<label for="id_medio_transporte_transito">Medio de transporte: </label>
							<select id="id_medio_transporte_transito" name="id_medio_transporte_transito" class="validacion">
							<option value="">Seleccione...</option>'
						. $this->comboMediosTransportePorIdioma($codigoIdioma) .
						'</select>
						</div>
						<div data-linea="3">
							<button type="button" class="mas" id="agregarPaisPuertoTransito">Agregar</button>
						</div>';
			    }
			    
			    $datos = $datosPaisPuerto . '<table style="width:100%">
						<thead>
						<tr>
							<th>País</th>
							<th>Puerto</th>
							<th>Medio transporte</th>
							<th></th>
						</tr>
						</thead>
						<tbody id="tPaisPuertoTransito">'
							. $filaPaisPuertoTransito .
							'</tbody>
						</table>';
				break;
			case 'Documental':
			case 'pago':
			case 'verificacion':
			case 'Aprobado':
			case 'Rechazado':
			case 'Subsanado':
			case 'Anulado':
			case 'generarOrden':
			case 'Eliminado':
				
				$datos = '<table style="width:100%">
						<thead>
						<tr>
							<th>País</th>
							<th>Puerto</th>
							<th>Medio transporte</th>
							<th></th>
						</tr>
						</thead>
						<tbody id="tPaisPuertoTransito">'
							. $filaPaisPuertoTransito .
							'</tbody>
						</table>';
				break;
		}
		return '<fieldset id="fPaisPuertoTransito">
                        <legend>Países, puertos de tránsito, medios de transporte</legend>' . $datos . '</fieldset>';
	}
	
	/**
	 * Metodo para construir los datos del exportador
	 */
	public function construirDatosExportador($certificadoFitosanitario, $tipoUsuario){
		
		$estadoCertificadoFitosanitario = $certificadoFitosanitario->getEstadoCertificado();
		$esReemplazo = $certificadoFitosanitario->getEsReemplazo();
		
		$datos = "";
		$codigoPoa = "";
		
		$idTipoProduccion = $certificadoFitosanitario->getIdTipoProduccion();
		
		$qTipoProduccion = $this->lNegocioTiposProduccionFitosanitariasBc->buscar($idTipoProduccion);
		$codigoTipoProduccion = $qTipoProduccion->getCodigoTipoProduccionFitosanitaria();
				
		switch ($estadoCertificadoFitosanitario) {
			case 'Creado':
			case 'Subsanacion':
			    
			    if($tipoUsuario === "Externo" && empty($esReemplazo)){
			    
			        if($codigoTipoProduccion === "ORGA"){
			            $codigoPoa = '<div data-linea="4">
							<label for="direccion_exportador">Código POA: </label>
							<input type="text" id="codigo_poa_exportador" name="codigo_poa_exportador" value="" class="validacion" autocomplete="off" >
						</div>';
			        }
			        
    				$datos = '<div data-linea="1">
    							<label for="identificador_exportador">Identificador exportador: </label>
    							<input type="text" id="identificador_exportador" name="identificador_exportador" value="" class="validacion" autocomplete="off">
    						</div>
    						<div data-linea="2">
    							<label for="nombre_exportador">Nombre/Razón social: </label>
    							<input type="text" id="nombre_exportador" name="nombre_exportador" value="" class="validacion" autocomplete="off" readonly="readonly" disabled="disabled">
    						</div>
    						<div data-linea="3">
    							<label for="direccion_exportador">Dirección: </label>
    							<input type="text" id="direccion_exportador" name="direccion_exportador" value="" class="validacion" autocomplete="off" readonly="readonly" disabled="disabled">
    						</div>'
    					. $codigoPoa;
				
			    }else{
			        
			        $identificadorExportador = $certificadoFitosanitario->getIdentificadorExportador();
			        
			        $qDatosExportador = $this->lNegocioOperadoresBc->obtenerInformacionOperadorPorIdentificador($identificadorExportador);
					
					if($qDatosExportador->count()){
						
						$nombreExportador = $qDatosExportador->current()->nombre_operador;
						$direccionExportador = $qDatosExportador->current()->direccion_operador;
						
						if($codigoTipoProduccion === "ORGA"){
							$codigoPoa = '<div data-linea="4">
							<label for="direccion_exportador">Código POA: </label>'
								. $certificadoFitosanitario->getCodigoPoa() .
								'</div>';
						}
						
						$datos = '<div data-linea="1">
								<label for="identificador_exportador">Identificador exportador: </label>'
							. $identificadorExportador .
							'</div>
							<div data-linea="2">
								<label for="nombre_exportador">Nombre/Razón social: </label>'
								. $nombreExportador .
								'</div>
							<div data-linea="3">
								<label for="direccion_exportador">Dirección: </label>'
									. $direccionExportador .
									'</div>'
										. $codigoPoa;
							
					}
					
			    }
					
				break;
			case 'Documental':
			case 'pago':
			case 'verificacion':
			case 'Aprobado':
			case 'Rechazado':
			case 'Subsanado':
			case 'Anulado':
			case 'generarOrden':
			case 'Eliminado':
				
				$identificadorExportador = $certificadoFitosanitario->getIdentificadorExportador();
				
				$qDatosExportador = $this->lNegocioOperadoresBc->obtenerInformacionOperadorPorIdentificador($identificadorExportador);
				$nombreExportador = $qDatosExportador->current()->nombre_operador;
				$direccionExportador = $qDatosExportador->current()->direccion_operador;
								
				if($codigoTipoProduccion === "ORGA"){
				    $codigoPoa = '<div data-linea="4">
						<label for="direccion_exportador">Código POA: </label>'
				        . $certificadoFitosanitario->getCodigoPoa() .
				        '</div>';
				}
				
				$datos = '<div data-linea="1">
							<label for="identificador_exportador">Identificador exportador: </label>'
							. $identificadorExportador .
						'</div>
						<div data-linea="2">
							<label for="nombre_exportador">Nombre/Razón social: </label>'
							. $nombreExportador .
						'</div>
						<div data-linea="3">
							<label for="direccion_exportador">Dirección: </label>'
							. $direccionExportador .
						'</div>'
						    . $codigoPoa;
				break;
		}
		return '<fieldset id="fDatosExportador">
                        <legend>Datos del exportador</legend>' . $datos . '</fieldset>';
	}
	
	/**
	 * Metodo para construir los datos de documentos adjuntos
	 */
	public function construirDatosDocumentosAdjuntos($certificadoFitosanitario, $tipoUsuario, $tipoAccion){
		
		$estadoCertificadoFitosanitario = $certificadoFitosanitario->getEstadoCertificado();
		$esReemplazo = $certificadoFitosanitario->getEsReemplazo();
		
		$datos = "";
		$accion = "";
		
		if(($estadoCertificadoFitosanitario === "Creado" || $estadoCertificadoFitosanitario === "Subsanacion") && $tipoUsuario === "Externo"){

		    switch ($tipoAccion) {
		        case 'editar':
		          $accion = '<div data-linea="1">
        						<button type="submit" id="bEnviarSolicitud" class="guardar">Enviar solicitud</button>
        					</div>';
		        break;
		    }
		    
		}
		
		switch ($estadoCertificadoFitosanitario) {
			case 'Creado':
			case 'Subsanacion':
			    
			    if($tipoUsuario === "Externo"){
			    
    				$datos = '<div data-linea="1">
    							<input type="hidden" id="ruta_adjunto" class="ruta_adjunto"
    								name="ruta_adjunto" value="" /> <input type="file" class="archivo"
    									accept="application/msword | application/pdf | image/*" />
    									<div class="estadoCarga">En espera de archivo... (Tamaño máximo' . ini_get('upload_max_filesize') . '</div>
    								<button type="button" id="subirArchivo"
    									data-rutaCarga="'. CERT_FIT_DOC_ADJ . $this->rutaFecha . '">Subir
    									archivo</button>
    							</div>
    										
    							<div data-linea="2">
    								<label for="ruta_enlace_adjunto">Ruta a documentos de respaldo (mayor
    									a 6Mbs): </label> <input type="text" id="ruta_enlace_adjunto"
    									name="ruta_enlace_adjunto" value=""
    									placeholder="Ingrese el enlace del archivo" maxlength="256" autocomplete="off"/>
    							</div>';
				
			    }
			    
				break;
			case 'Documental':
			case 'pago':
			case 'verificacion':
			case 'Aprobado':
			case 'Rechazado':
			case 'Subsanado':
			case 'Anulado':
			case 'generarOrden':
			case 'Eliminado':
				
				$contador = 0;
				
				$qDatosDocumentosAdjuntos = $this->lNegocioDocumentosAdjuntosBc->buscarLista(array('id_certificado_fitosanitario' => $certificadoFitosanitario->getIdCertificadoFitosanitario()));
				
				foreach ($qDatosDocumentosAdjuntos as $item) {
				    
				    $tipoAdjunto = $item['tipo_adjunto'];
				    $documentoAdjunto = "";
				    $documentoAdjuntoUno = "";
				    
				    if($estadoCertificadoFitosanitario != "Anulado"){
				        
				        if($tipoAdjunto != "XML Ephyto"){
				            
				            if($tipoAdjunto === "Documento"){
				                if(isset($item['ruta_adjunto'])){
				                    $documentoAdjunto = $item['ruta_adjunto'];
				                }
				                
				                if(isset($item['ruta_enlace_adjunto'])){
				                    $documentoAdjuntoUno = $item['ruta_enlace_adjunto'];
				                }
				            }else{
				                if(isset($item['ruta_adjunto'])){
				                    $documentoAdjunto = $item['ruta_adjunto'];
				                }
				            }
				            
				            $datos .= '<div data-linea="' . $contador++ . '">'
				                . $contador . '.- ' . trim(($documentoAdjunto != "" ? '<a href="' . $documentoAdjunto . '" target="_blank">' . $item['tipo_adjunto'] . '</a>' : '') . ($documentoAdjuntoUno != "" ? ' / <a href="' . $documentoAdjuntoUno . '" target="_blank">' . $item['tipo_adjunto'] . '</a>' : ''), '/ ') .
				                '</div>';
				                
				        }
				        
				    }else{
					    
					    if($tipoAdjunto != "XML Ephyto" && $tipoAdjunto != "Certificado Fitosanitario" && $tipoAdjunto != "Anexo Certificado"){
					        
					        if($tipoAdjunto === "Documento"){
					            if(isset($item['ruta_adjunto'])){
					                $documentoAdjunto = $item['ruta_adjunto'];
					            }
					            
					            if(isset($item['ruta_enlace_adjunto'])){
					                $documentoAdjuntoUno = $item['ruta_enlace_adjunto'];
					            }
					        }else{
					            if(isset($item['ruta_adjunto'])){
					                $documentoAdjunto = $item['ruta_adjunto'];
					            }
					        }
					        
					        $datos .= '<div data-linea="' . $contador++ . '">'
    					        . $contador . '.- ' . trim(($documentoAdjunto != "" ? '<a href="' . $documentoAdjunto . '" target="_blank">' . $item['tipo_adjunto'] . '</a>' : '') . ($documentoAdjuntoUno != "" ? ' / <a href="' . $documentoAdjuntoUno . '" target="_blank">' . $item['tipo_adjunto'] . '</a>' : ''), '/ ') .
    					        '</div>';
					            
					    }
					    
					}
					
				}
				
				break;
		}
		
		return '<fieldset id="fDocumentos adjuntos">
                        <legend>Documentos adjuntos</legend>' . $datos . '</fieldset>'
                        	. $accion;
		
	}
	
	/**
	 * Metodo para construir los datos de revision documental
	 */
	public function construirDatosRevisionDocumental($certificadoFitosanitario){
		
		$estadoCertificadoFitosanitario = $certificadoFitosanitario->getEstadoCertificado();
		$identificadorRevision = $certificadoFitosanitario->getIdentificadorRevision();
		$observacionRevision = $certificadoFitosanitario->getObservacionRevision();
		
		$datos = "";
		
		if(isset($identificadorRevision)){
		
			switch ($estadoCertificadoFitosanitario) {
				case 'Aprobado':
				case 'Rechazado':
				case 'Subsanacion':
					
					$qDatosRevision = $this->lNegocioFichaEmpleadoBc->buscar($identificadorRevision);
					
					$datos = '<div data-linea="1">
								<label for="identificador_revision">Identificador revisor: </label>'
								. $identificadorRevision .
							'</div>
                            <div data-linea="2">
                                <label for="nombre_revision">Nombre: </label>' . $qDatosRevision->getNombre() . ' ' . $qDatosRevision->getApellido() . '
                            </div>
							<div data-linea="3">
								<label for="observacion_revision">Observación: </label>'
								. $observacionRevision .
							'</div>';
								
    				return '<fieldset>
    				<legend>Resultado de revisión documental</legend>' . $datos . '</fieldset>';
					
				break;
				
			}		
		
		}
		
	}
	
	///////////////////
	/////PANELES///////
	
	/**
	 * Construye el código HTML para desplegar panel de busqueda para certificados fitosanitarios
	 */
	public function cargarPanelCertificadosFitosanitarios($identificador, $banderaOpcionBusqueda)
	{
			
		$resultadoUsuarioInterno = $this->lNegocioFichaEmpleadoBc->buscarDatosUsuarioContrato($identificador);
		$mostrarOpcionBusqueda = "";
		$colspan = "";
		
		if($banderaOpcionBusqueda){
		    $mostrarOpcionBusqueda = '<td>Estado: </td>
        						<td>
        							<select id="bEstadoCertificado" name="bEstadoCertificado" style="width: 100%;">
                        				<option value="">Seleccionar....</option>'
                    		        . $this->comboEstadosFitosanitarios() .
                    		        '</select>
                                                     </td>';
		}else{
		    $colspan = 'colspan="4"';		    
		}
		
		if(isset($resultadoUsuarioInterno->current()->identificador)){		    
		    //$identificadorUsuario = $identificador;
		}else{
			//$identificadorUsuario = $identificador;
		}
		
		$datos = '<table class="filtro" style="width: 100%; text-align:left;">
                                                                                                            	
                                                <tbody>
                                                    <tr>
                                                        <th colspan="4">Consulta de Certificados Fitosanitarios:</th>
                                                    </tr>
                                                            	
                                					<tr>
                                						<td>Tipo de Solicitud: </td>
                                						<td ' . $colspan . '>
                                							<select id="bTipoSolicitud" name="bTipoSolicitud" style="width: 100%;">
                                                				<option value="">Seleccionar....</option>
                                                                <option value="musaceas">Musáceas</option>
																<option value="otros">Otros</option>
                                                                <!-- option value="ornamentales">Ornamentales</option>
                                                                <option value="otros">Otros</option -->
                                                            </select>
                                                        </td>'
		                                              . $mostrarOpcionBusqueda .                                                      
                                                    '</tr>
                                                    <tr>
                                						<td>Tipo de producto: </td>
                                						<td colspan="3">
                                							<select id="bTipoProducto" name="bTipoProducto" style="width: 100%;">
                                                			     <option value="">Seleccionar....</option>'
                                                			     . $this->comboTipoProductoPorArea('SV') .
                                                			     '</select>
                                                        </td>                                						
                                					</tr>
                                                    <tr>
                                						<td>Subtipo de producto: </td>
                                						<td colspan="3">
                                							<select id="bSubtipoProducto" name="bSubtipoProducto" style="width: 100%;">
                                                                <option value="">Seleccionar....</option>
                                                            </select>
                                                        </td>                                						
                                					</tr>
                                                    <tr>
                                						<td>Producto: </td>
                                						<td colspan="3">
                                							<select id="bProducto" name="bProducto" style="width: 100%;">
                                                                <option value="">Seleccionar....</option>
                                                            </select>
                                                        </td>                                						
                                					</tr>
                                                    <tr>
                                						<td>País de Destino: </td>
                                						<td colspan="3">
                                							<select id="bPaisDestino" name="bPaisDestino" style="width: 100%;">
                                                			     <option value="">Seleccionar....</option>' .
                                                			     $this->comboPaises() .
                                                			     '</select>
                                                        </td>                                						
                                					</tr>                                                    
													<tr>
                                						<td >Número de certificado: </td>
                                						<td colspan="3">
                                							<input id="bNumeroCertificado" type="text" name="bNumeroCertificado" value="" style="width: 100%" maxlength="128">
                                						</td>
                                                    </tr>
                                                    <tr>
                                						<td >F. Inicio: </td>
                                						<td>
                                							<input id="bFechaInicio" type="text" name="bFechaInicio" value="" style="width: 100%" maxlength="128" readonly="readonly">
                                						</td>
                                                        <td >F. Fin: </td>
                                						<td>
                                							<input id="bFechaFin" type="text" name="bFechaFin" value="" style="width: 100%" maxlength="128" readonly="readonly">
                                						</td>
                                					</tr>
                                					<tr>
                                						<td colspan="4" style="text-align: end;">
                                							<button id="btnFiltrar">Consultar</button>
                                						</td>
                                					</tr>
                                				</tbody>
                                			</table>';
                                                			     
                                                			     return $datos;
	}
	
	function equivalenciaTipoSolicitud($tipoSolicitud){
	    
	    $tipo = "";
	    
	    switch($tipoSolicitud){
	        
	        case 'musaceas':
	            $tipo = 'Musáceas';
	        break;
	        case 'ornamentales':
	            $tipo = 'Ornamentales';
	        break;
	        case 'otros':
	            $tipo = 'Otros';
	        break;
	            
	    }
	    
	    return $tipo;
	    
	}
	
	function equivalenciaEstadosFitosanitarios($estadoSolicitud){
	    
	    $estado = "";
	    
	    switch($estadoSolicitud){
	        
	        case 'Creado':
	            $estado = 'Creado';
	        break;
	        case 'Documental':
	            $estado = 'Revisión documental';
	        break;
	        case 'generarOrden':
	            $estado = 'Por generar orden';
	        break;	        
	        case 'pago':
	            $estado = 'Asignación de pago';
	        break;
	        case 'verificacion':
	            $estado = 'Verificación de pago';
	        break;
	        case 'Rechazado':
	            $estado = 'Rechazado';
	        break;
	        case 'Aprobado':
	            $estado = 'Aprobado';
	        break;
	        case 'Subsanacion':
	            $estado = 'Subsanación';
	        break;
	        case 'Subsanado':
	            $estado = 'Subsanado';
	        break;
	        case 'Anulado':
	            $estado = 'Anulado';
	        break;
			case 'Eliminado':
	            $estado = 'Eliminado';
	        break;
	            
	    }
	    
	    return $estado;
	    
	}
	
	function comboEstadosFitosanitarios(){
	    
	    $comboEstados = "";
	    
	    $arrayEstados = ['Creado' => 'Creado'
	        , 'Documental' => 'Revisión Documental'
	        , 'pago' => 'Asignación de pago'
	        , 'verificacion' => 'Verificación de pago'
	        , 'Subsanacion' => 'Subsanación'
	        , 'Subsanado' => 'Subsanado'
	        , 'Rechazado' => 'Rechazado'
	        , 'Aprobado' => 'Aprobado'
	        , 'Anulado' => 'Anulado'
			, 'Eliminado' => 'Eliminado'
	    ];   
	    
	    foreach ($arrayEstados as $llave => $valor) {
	        $comboEstados .= '<option value="' . $llave . '">' . $valor .'</option>';
	    }
	    
	    return $comboEstados;	    
	    
	}

	function equivalenciaFormaPago($formaPago){
	    
	    $pago = "";
	    
	    switch($formaPago){
	        
	        case 'efectivo':
	            $pago = 'Comprobante de depósito';
	            break;
	        case 'saldo':
	            $pago = 'Saldo';
	            break;
	        default:
	            $pago = 'N/A';
	           break;
	            
	    }
	    
	    return $pago;
	    
	}

	public function obtenerUnidadFitosanitaria($idUnidadFitosanitaria, $codigoIdioma) {
	    
	    $nombreUnidadFitosanitaria = "";
	    $qDatosUnidadFitosanitaria = $this->lNegocioUnidadesFitosanitariasBc->buscar($idUnidadFitosanitaria);
	    
	    if($codigoIdioma === "SPA"){
	        $nombreUnidadFitosanitaria = $qDatosUnidadFitosanitaria->getNombreUnidadFitosanitaria();
	    }
	    
	    if($codigoIdioma === "ENG"){
	        $nombreUnidadFitosanitaria = $qDatosUnidadFitosanitaria->getNombreUnidadFitosanitariaIngles();
	    }
	    
	    return $nombreUnidadFitosanitaria;
	    
	}
	
	public function construirDatosMotivoAnulacion(){
	    
	    $datos = "";

        $datos .= '<div data-linea="1">
                        <label>Motivo de anulación y reemplazo:</label>
        	            <input type="text" id="motivo_reemplazo" name="motivo_reemplazo" value="" class="validacion">
    	            </div>';	    
	    return '<fieldset>
                        <legend>Datos de anulación y reemplazo</legend>' . $datos . '</fieldset>';
	}
	
	/**
	 * Método para obtener los puertos de acuerdo un medio de trasnporte seleccionado
	 */
	public function obtenerPuertosPorNombreMedioTransporteSubsanacion($nombreMedioTransporte, $idPuertoEmbarque){
	    $datosLocalizacion = [
	        'codigo_vue' => 'EC',
	        'categoria' => 0];
	    
	    $qDatosLocalizacion = $this->lNegocioLocalizacionBc->buscarLista($datosLocalizacion);
	    $idLocalizacion = $qDatosLocalizacion->current()->id_localizacion;
	    
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
	    
	    $puertos = $this->lNegocioCertificadoFitosanitarioBc->obtenerPuertosPorNombreMedioTrasporte($arrayParametros);
	    
	    $comboPuertos = "";
	    $comboPuertos .= '<option value="">Seleccionar....</option>';
	    
	    foreach ($puertos as $item){
	        
	        if($idPuertoEmbarque == $item['id_puerto']){
	            $comboPuertos .= '<option value="' . $item->id_puerto . '" data-nombrepuerto="' . $item->nombre_puerto . '" selected="selected">' . $item->nombre_puerto . ' - ' . $item->codigo_puerto . '</option>';
	        }else{	        
	           $comboPuertos .= '<option value="' . $item->id_puerto . '" data-nombrepuerto="' . $item->nombre_puerto . '" >' . $item->nombre_puerto . ' - ' . $item->codigo_puerto . '</option>';
	        }
	    }
	    
	    return $comboPuertos;
	}
	
	
}
