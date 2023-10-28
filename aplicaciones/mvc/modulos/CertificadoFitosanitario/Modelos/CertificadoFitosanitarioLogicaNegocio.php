<?php
/**
 * Lógica del negocio de CertificadoFitosanitarioModelo
 *
 * Este archivo se complementa con el archivo CertificadoFitosanitarioControlador.
 *
 * @author AGROCALIDAD
 * @date    2022-07-21
 * @uses CertificadoFitosanitarioLogicaNegocio
 * @package CertificadoFitosanitario
 * @subpackage Modelos
 */
namespace Agrodb\CertificadoFitosanitario\Modelos;

use Agrodb\CertificadoFitosanitario\Modelos\IModelo;
use Agrodb\Core\Excepciones\GuardarExcepcion;
use Agrodb\RevisionFormularios\Modelos\AsignacionInspectorLogicaNegocio;
use Agrodb\Core\JasperReport;
use Spatie\ArrayToXml\ArrayToXml;
use Agrodb\Core\Constantes;
use Agrodb\ConfiguracionCertificadoFitosanitarioHub\Modelos\ConfiguracionFitosanitarioLogicaNegocio;
use Agrodb\WebServices\Modelos\CertificadoFitosanitarioEphytoLogicaNegocio;
use Agrodb\Catalogos\Modelos\UnidadesFitosanitariasLogicaNegocio;
use Agrodb\Catalogos\Modelos\TratamientosLogicaNegocio;
use Agrodb\Catalogos\Modelos\ProductosLogicaNegocio;
use Agrodb\Catalogos\Modelos\TiposTratamientoLogicaNegocio;
use Agrodb\Catalogos\Modelos\IdiomasLogicaNegocio;
use Agrodb\Catalogos\Modelos\LocalizacionLogicaNegocio;
use Agrodb\GUath\Modelos\FichaEmpleadoLogicaNegocio;
use Agrodb\Catalogos\Modelos\PuertosLogicaNegocio;
use Agrodb\Catalogos\Modelos\MediosTransporteLogicaNegocio;
use Agrodb\FirmaDocumentos\Modelos\FirmantesLogicaNegocio;
use Agrodb\RegistroOperador\Modelos\OperadoresLogicaNegocio;

class CertificadoFitosanitarioLogicaNegocio implements IModelo{

	private $modeloCertificadoFitosanitario = null;
	
	private $lNegocioAsignacionInspector = null;
	
	private $lNegocioLocalizacion = null;
	
	private $lNegocioPaisesPuertosDestino = null;
	
	private $lNegocioPaisesPuertosTransito = null;
	
	private $lNegocioPuertos = null;
	
	private $lNegocioMediosTransporte = null;
	
	private $lNegocioIdioma = null;
	
	private $lNegocioProductos = null;
	
	private $lNegocioUnidadesFitosanitarias = null;
	
	private $lNegocioTiposTratamiento = null;

	private $lNegocioTratamientos = null;
	
	private $lNegocioFichaEmpleado = null;
		
	private $lNegocioCertificadoFitosanitarioProductos = null;
	
	private $lNegocioIdentificador = null;
	
	private $lNegocioDocumentosAdjuntos = null;
	
	private $lNegocioOperadores = null;
	
	/**
	 * Constructor
	 *
	 * @retorna void
	 */
	public function __construct(){
		$this->modeloCertificadoFitosanitario = new CertificadoFitosanitarioModelo();
		$this->lNegocioAsignacionInspector = new AsignacionInspectorLogicaNegocio();
		$this->lNegocioLocalizacion = new LocalizacionLogicaNegocio();
		$this->lNegocioPaisesPuertosDestino = new PaisesPuertosDestinoLogicaNegocio();
		$this->lNegocioPaisesPuertosTransito = new PaisesPuertosTransitoLogicaNegocio();
		$this->lNegocioPuertos = new PuertosLogicaNegocio();
		$this->lNegocioMediosTransporte = new MediosTransporteLogicaNegocio();
		$this->lNegocioIdioma = new IdiomasLogicaNegocio();
		$this->lNegocioProductos = new ProductosLogicaNegocio();
		$this->lNegocioUnidadesFitosanitarias = new UnidadesFitosanitariasLogicaNegocio();
		$this->lNegocioTiposTratamiento = new TiposTratamientoLogicaNegocio();
		$this->lNegocioTratamientos = new TratamientosLogicaNegocio();
		$this->lNegocioFichaEmpleado = new FichaEmpleadoLogicaNegocio();
		$this->lNegocioCertificadoFitosanitarioProductos = new CertificadoFitosanitarioProductosLogicaNegocio();
		$this->lNegocioIdentificador = new FirmantesLogicaNegocio();
		$this->lNegocioDocumentosAdjuntos = new DocumentosAdjuntosLogicaNegocio();
		$this->lNegocioOperadores = new OperadoresLogicaNegocio();
	}

	/**
	 * Guarda el registro actual
	 *
	 * @param array $datos
	 * @return int
	 */
	public function guardar(Array $datos){
		
		try{
		
			$tablaModelo = new CertificadoFitosanitarioModelo($datos);
			$procesoIngreso = $this->modeloCertificadoFitosanitario->getAdapter()
			->getDriver()
			->getConnection();
			$procesoIngreso->beginTransaction();		
			
			$datosBd = $tablaModelo->getPrepararDatos();
			if ($tablaModelo->getIdCertificadoFitosanitario() != null && $tablaModelo->getIdCertificadoFitosanitario() > 0){
				$idCertificadoFitosanitario = $this->modeloCertificadoFitosanitario->actualizar($datosBd, $tablaModelo->getIdCertificadoFitosanitario());
			}else{
				unset($datosBd["id_certificado_fitosanitario"]);
				$idCertificadoFitosanitario =  $this->modeloCertificadoFitosanitario->guardar($datosBd);
			}
			
			$procesoIngreso->commit();
			return $idCertificadoFitosanitario;
		
		}catch (GuardarExcepcion $ex){
			$procesoIngreso->rollback();
			throw new \Exception($ex->getMessage());
		}
	}

	/**
	 * Borra el registro actual
	 *
	 * @param
	 *        	string Where|array $where
	 * @return int
	 */
	public function borrar($id){
		$this->modeloCertificadoFitosanitario->borrar($id);
	}

	/**
	 *
	 * Buscar un registro de con la clave primaria
	 *
	 * @param int $id
	 * @return CertificadoFitosanitarioModelo
	 */
	public function buscar($id){
		return $this->modeloCertificadoFitosanitario->buscar($id);
	}

	/**
	 * Busca todos los registros
	 *
	 * @return array|ResultSet
	 */
	public function buscarTodo(){
		return $this->modeloCertificadoFitosanitario->buscarTodo();
	}

	/**
	 * Busca una lista de acuerdo a los parámetros <params> enviados.
	 *
	 * @return array|ResultSet
	 */
	public function buscarLista($where = null, $order = null, $count = null, $offset = null){
		return $this->modeloCertificadoFitosanitario->buscarLista($where, $order, $count, $offset);
	}

	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 *
	 * @return array|ResultSet
	 */
	public function buscarCertificadoFitosanitario(){
		$consulta = "SELECT * FROM " . $this->modeloCertificadoFitosanitario->getEsquema() . ". certificado_fitosanitario";
		return $this->modeloCertificadoFitosanitario->ejecutarSqlNativo($consulta);
	}

	/**
	 * Ejecuta una consulta(SQL) personalizada para obtener los puertos
	 * de acuerdo a un medio de transporte
	 *
	 * @return array|ResultSet
	 */
	public function obtenerPuertosPorNombreMedioTrasporte($arrayParametros){
		$idLocalizacion = $arrayParametros['idLocalizacion'];
		$nombreMedioTransporte = $arrayParametros['nombreMedioTrasporte'];

		$consulta = "SELECT
                    	id_puerto
                    	, nombre_puerto
                    	, id_pais
                    	, codigo_puerto
                    	, codigo_pais
                    	, tipo_puerto
                    	, nombre_provincia
                    	, id_provincia
                    FROM
                    	g_catalogos.puertos
                    WHERE
                        tipo_puerto = '" . $nombreMedioTransporte . "'
                        and id_pais = '" . $idLocalizacion . "'
                        and nombre_provincia is not null
                    ORDER BY nombre_puerto ASC;";

		return $this->modeloCertificadoFitosanitario->ejecutarSqlNativo($consulta);
	}
	
	/**
	 * Actualiza el registro de datos generales de un certificado
	 *
	 * @param array $datos
	 * @return int
	 */
	public function actualizarDatosGeneralesCertificadoFitosanitario(Array $datos){

		try{
			
			$resultado = false;
			$idCertificadoFitosanitario = $datos['id_certificado_fitosanitario'];
			$fechaEmbarque = $datos['fecha_embarque'];
			$idPuertoEmbarque =  $datos['id_puerto_embarque'];
			$nombreMarca = $datos['nombre_marca'];
			$nombreConsignatario = $datos['nombre_consignatario'];
			$direccionConsignatario = $datos['direccion_consignatario'];
			$codigoCertificadoImportacion = $datos['codigo_certificado_importacion'];
			$informacionAdicional = $datos['informacion_adicional'];
			
			$idPuertoEmbarque = $_POST['id_puerto_embarque'];
			$qDatosPuertoEmbarque = $this->lNegocioPuertos->buscar($idPuertoEmbarque);
			$idProvinciaPuertoEmbarque = $qDatosPuertoEmbarque->getIdProvincia();
			
			$datosGenerales = ['fecha_embarque' => $fechaEmbarque,
			    'id_puerto_embarque' => $idPuertoEmbarque,
			    'id_provincia_puerto_embarque' => $idProvinciaPuertoEmbarque,
			    'nombre_marca' => $nombreMarca,
			    'nombre_consignatario' => $nombreConsignatario,
				'direccion_consignatario' => $direccionConsignatario,
			    'codigo_certificado_importacion' => $codigoCertificadoImportacion,
				'informacion_adicional' => $informacionAdicional
			];
			
			$procesoIngreso = $this->modeloCertificadoFitosanitario->getAdapter()
			->getDriver()
			->getConnection();
			$procesoIngreso->beginTransaction();
			
			$statement = $this->modeloCertificadoFitosanitario->getAdapter()
			->getDriver()
			->createStatement();
			
			$sqlActualizar = $this->modeloCertificadoFitosanitario->actualizarSql('certificado_fitosanitario', $this->modeloCertificadoFitosanitario->getEsquema());
			$sqlActualizar->set($datosGenerales);
			$sqlActualizar->where(array('id_certificado_fitosanitario' => $idCertificadoFitosanitario));
			$sqlActualizar->prepareStatement($this->modeloCertificadoFitosanitario->getAdapter(), $statement);
			$statement->execute();
			
			$resultado = true;
			
			$procesoIngreso->commit();
			
			return $resultado;
			
		}catch (GuardarExcepcion $ex){
			$procesoIngreso->rollback();
			throw new \Exception($ex->getMessage());
		}
	}
	
	/**
	 * Metodo que guarda la solicitud
	 *
	 * @param array $datos
	 * @return int
	 */
	public function enviarSolicitud(Array $datos){
		
		try{
			
			$resultado = false;
			$numeroDigitos = 5;
			$anio = date('y');
			$identificadorSolicitante = $datos['identificador_solicitante'];
			$idCertificadoFitosanitario = $datos['id_certificado_fitosanitario'];			
			$estadoCertificado = $datos['estado_certificado'];
					
			$qCertificadoFitosanitario = $this->buscar($idCertificadoFitosanitario);
			$tipoSolicitud = $qCertificadoFitosanitario->getTipoSolicitud();
			$esReemplazo = $qCertificadoFitosanitario->getEsReemplazo();
			
			$procesoIngreso = $this->modeloCertificadoFitosanitario->getAdapter()
			->getDriver()
			->getConnection();
			$procesoIngreso->beginTransaction();
			
			/*switch ($tipoSolicitud) {
				case 'musaceas':
				;
				break;
				
				default:
					;
				break;
			}*/
											
			$statement = $this->modeloCertificadoFitosanitario->getAdapter()
			->getDriver()
			->createStatement();
					
			$datosExportador = ['estado_certificado' => $estadoCertificado];
			
			if(empty($esReemplazo)){
			    $identificadorExportador = $datos['identificador_exportador'];
			    $datosExportador += ['identificador_exportador' => $identificadorExportador];
			}
			
			if($estadoCertificado === "Documental"){
			    $qCodigoCertificado = $this->generarCodigoCertificado($identificadorSolicitante, $anio, $idCertificadoFitosanitario);
			    $codigoGenerado = $qCodigoCertificado->current()->f_generarcodigocertificado;
			    $datosExportador += ['codigo_certificado' => $codigoGenerado];
			}
			
			if(isset($datos['codigo_poa_exportador'])){
			    $codigoPoa = $datos['codigo_poa_exportador'];
			    $datosExportador += ['codigo_poa' => $codigoPoa];			    
			}
			
			$sqlActualizar = $this->modeloCertificadoFitosanitario->actualizarSql('certificado_fitosanitario', $this->modeloCertificadoFitosanitario->getEsquema());
			$sqlActualizar->set($datosExportador);
			$sqlActualizar->where(array('id_certificado_fitosanitario' => $idCertificadoFitosanitario));
			$sqlActualizar->prepareStatement($this->modeloCertificadoFitosanitario->getAdapter(), $statement);
			$statement->execute();
			
		    if($estadoCertificado === "Documental"){

    			$statement = $this->modeloCertificadoFitosanitario->getAdapter()
    			->getDriver()
    			->createStatement();    			
    			
    			if(empty($esReemplazo)){
    			
        			if(!empty($datos['ruta_adjunto']) || !empty($datos['ruta_enlace_adjunto'])){
        			
            			$datosAdjuntos = ['id_certificado_fitosanitario' => $idCertificadoFitosanitario,
            							'tipo_adjunto' => 'Documento'];
            			
            			if(!empty($datos['ruta_adjunto'])){
            				$rutaAdjunto = $datos['ruta_adjunto'];
            				$datosAdjuntos += ['ruta_adjunto' => $rutaAdjunto];
            			}else{
            				unset($datos['ruta_adjunto']);
            			}
            			
            			if(!empty($datos['ruta_enlace_adjunto'])){
            				$rutaEnlaceAdjunto = $datos['ruta_enlace_adjunto'];
            				$datosAdjuntos += ['ruta_enlace_adjunto' => $rutaEnlaceAdjunto];
            			}else{
            				unset($datos['ruta_enlace_adjunto']);
            			}
            
            			$sqlInsertar = $this->modeloCertificadoFitosanitario->guardarSql('documentos_adjuntos', $this->modeloCertificadoFitosanitario->getEsquema());
            			$sqlInsertar->columns(array_keys($datosAdjuntos));
            			$sqlInsertar->values($datosAdjuntos, $sqlInsertar::VALUES_MERGE);
            			$sqlInsertar->prepareStatement($this->modeloCertificadoFitosanitario->getAdapter(), $statement);
            			$statement->execute();
            			
        			}
        			
    			}
    			
    			if(!empty($esReemplazo)){
    			    
    			    $datosDocumetosAdjuntos = ['id_certificado_fitosanitario' => $idCertificadoFitosanitario
    			        , 'tipo_adjunto' => 'Documento'];
    			    
    			    $qDocumentosAdjuntos = $this->lNegocioDocumentosAdjuntos->buscarLista($datosDocumetosAdjuntos);
    			    
    			    if($qDocumentosAdjuntos->count()){
    			        
    			        $idDocumentoAdjunto = $qDocumentosAdjuntos->current()->id_documento_adjunto;
    			        
    			        if(!empty($datos['ruta_adjunto']) || !empty($datos['ruta_enlace_adjunto'])){
    			            
    			            $datosAdjuntos = ['tipo_adjunto' => 'Documento'];
    			            
    			            if(!empty($datos['ruta_adjunto'])){
    			                $rutaAdjunto = $datos['ruta_adjunto'];
    			                $datosAdjuntos += ['ruta_adjunto' => $rutaAdjunto];
    			            }else{
    			                unset($datos['ruta_adjunto']);
    			            }
    			            
    			            if(!empty($datos['ruta_enlace_adjunto'])){
    			                $rutaEnlaceAdjunto = $datos['ruta_enlace_adjunto'];
    			                $datosAdjuntos += ['ruta_enlace_adjunto' => $rutaEnlaceAdjunto];
    			            }else{
    			                unset($datos['ruta_enlace_adjunto']);
    			            }
    			            
    			            $sqlActualizar = $this->modeloCertificadoFitosanitario->actualizarSql('documentos_adjuntos', $this->modeloCertificadoFitosanitario->getEsquema());
    			            $sqlActualizar->set($datosAdjuntos);
    			            $sqlActualizar->where(array('id_documento_adjunto' => $idDocumentoAdjunto));
    			            $sqlActualizar->prepareStatement($this->modeloCertificadoFitosanitario->getAdapter(), $statement);
    			            $statement->execute();
    			            
    			        }
    			        
    			    }
    			       			
    			}
    			
		    }
			
			if($estadoCertificado === "Subsanado"){
			    
			    $statement = $this->modeloCertificadoFitosanitario->getAdapter()
			    ->getDriver()
			    ->createStatement();
			    
			    $datosDocumetosAdjuntos = ['id_certificado_fitosanitario' => $idCertificadoFitosanitario
			        , 'tipo_adjunto' => 'Documento'];
			    
			    $qDocumentosAdjuntos = $this->lNegocioDocumentosAdjuntos->buscarLista($datosDocumetosAdjuntos);
				
				if($qDocumentosAdjuntos->count()){
				
					$idDocumentoAdjunto = $qDocumentosAdjuntos->current()->id_documento_adjunto;
					
					if(!empty($datos['ruta_adjunto']) || !empty($datos['ruta_enlace_adjunto'])){
			        
						$datosAdjuntos = ['tipo_adjunto' => 'Documento'];
						
						if(!empty($datos['ruta_adjunto'])){
							$rutaAdjunto = $datos['ruta_adjunto'];
							$datosAdjuntos += ['ruta_adjunto' => $rutaAdjunto];
						}else{
							unset($datos['ruta_adjunto']);
						}
						
						if(!empty($datos['ruta_enlace_adjunto'])){
							$rutaEnlaceAdjunto = $datos['ruta_enlace_adjunto'];
							$datosAdjuntos += ['ruta_enlace_adjunto' => $rutaEnlaceAdjunto];
						}else{
							unset($datos['ruta_enlace_adjunto']);
						}
						
						$sqlActualizar = $this->modeloCertificadoFitosanitario->actualizarSql('documentos_adjuntos', $this->modeloCertificadoFitosanitario->getEsquema());
						$sqlActualizar->set($datosAdjuntos);
						$sqlActualizar->where(array('id_documento_adjunto' => $idDocumentoAdjunto));
						$sqlActualizar->prepareStatement($this->modeloCertificadoFitosanitario->getAdapter(), $statement);
						$statement->execute();
						
					}
				
				}else{                

					if(!empty($datos['ruta_adjunto']) || !empty($datos['ruta_enlace_adjunto'])){

						$datosAdjuntos = ['id_certificado_fitosanitario' => $idCertificadoFitosanitario,
            							'tipo_adjunto' => 'Documento'];
						
						if(!empty($datos['ruta_adjunto'])){
							$rutaAdjunto = $datos['ruta_adjunto'];
							$datosAdjuntos += ['ruta_adjunto' => $rutaAdjunto];
						}else{
							unset($datos['ruta_adjunto']);
						}
						
						if(!empty($datos['ruta_enlace_adjunto'])){
							$rutaEnlaceAdjunto = $datos['ruta_enlace_adjunto'];
							$datosAdjuntos += ['ruta_enlace_adjunto' => $rutaEnlaceAdjunto];
						}else{
							unset($datos['ruta_enlace_adjunto']);
						}

						$sqlInsertar = $this->modeloCertificadoFitosanitario->guardarSql('documentos_adjuntos', $this->modeloCertificadoFitosanitario->getEsquema());
						$sqlInsertar->columns(array_keys($datosAdjuntos));
						$sqlInsertar->values($datosAdjuntos, $sqlInsertar::VALUES_MERGE);
						$sqlInsertar->prepareStatement($this->modeloCertificadoFitosanitario->getAdapter(), $statement);
						$statement->execute();
					
					}
					
				}
			    
			}     
			
			$resultado = true;
			
			$procesoIngreso->commit();
			
			return $resultado;
			
		}catch (GuardarExcepcion $ex){
			$procesoIngreso->rollback();
			throw new \Exception($ex->getMessage());
		}
	}
	
	/**
	 * Funcion para generar el numero de certificado por operador
	 */
	function generarCodigoCertificado($identificadorSolicitante, $anio, $idCertificadoFitosanitario){
		
	    $consulta = "SELECT g_certificado_fitosanitario.f_generarcodigocertificado('" . $identificadorSolicitante . "', '" . $anio . "', '" . $idCertificadoFitosanitario . "');";
	    
	    return $this->modeloCertificadoFitosanitario->ejecutarSqlNativo($consulta);
		
	}
	
	/**
	 * Metodo que guarda la solicitud de anula reemplaza
	 *
	 * @param array $datos
	 * @return int
	 */
	public function enviarAnulaReemplaza(Array $datos){
	    
	    try{
	        
	        $resultado = false;
	       	        
	        $procesoIngreso = $this->modeloCertificadoFitosanitario->getAdapter()
	        ->getDriver()
	        ->getConnection();
	        $procesoIngreso->beginTransaction();
	        
	        $statement = $this->modeloCertificadoFitosanitario->getAdapter()
	        ->getDriver()
	        ->createStatement();
	        
	        $idCertificadoReemplazo = $datos['id_certificado_reemplazo'];	        
	        $motivoReemplazo = $datos['motivo_reemplazo'];
	        $fechaReemplazoCertificado = $datos['fecha_reemplazo_certificado'];
	        unset($datos['motivo_reemplazo']);
	        unset($datos['fecha_reemplazo_certificado']);
	        
	        $sqlInsertar = $this->modeloCertificadoFitosanitario->guardarSql('certificado_fitosanitario', $this->modeloCertificadoFitosanitario->getEsquema());
	        $sqlInsertar->columns(array_keys($datos));
	        $sqlInsertar->values($datos, $sqlInsertar::VALUES_MERGE);
	        $sqlInsertar->prepareStatement($this->modeloCertificadoFitosanitario->getAdapter(), $statement);
	        $statement->execute();
	        $idCertificadoFitosanitario = $this->modeloCertificadoFitosanitario->adapter->driver->getLastGeneratedValue($this->modeloCertificadoFitosanitario->getEsquema() . '.certificado_fitosanitario_id_certificado_fitosanitario_seq');
	        	        
	        $qDatosProductos = $this->lNegocioCertificadoFitosanitarioProductos->buscarLista(array('id_certificado_fitosanitario' => $idCertificadoReemplazo));
	        	                
	        foreach ($qDatosProductos as $item) {
	            
	            $arrayDatosProducto = "";
	            
	            $idTotalInspeccionFitosanitaria = $item['id_total_inspeccion_fitosanitaria'];
	            $idSubtipoProducto = $item['id_subtipo_producto'];
	            $nombreSubtipoProducto = $item['nombre_subtipo_producto'];
	            $idProducto = $item['id_producto'];
                $nombreProducto = $item['nombre_producto'];
                $cantidadComercial = $item['cantidad_comercial'];
                $idUnidadCantidadComercial = $item['id_unidad_cantidad_comercial'];
                $codigoUnidadCantidadComercial = $item['codigo_unidad_cantidad_comercial'];
                $pesoNeto = $item['peso_neto'];
                $idUnidadPesoNeto = $item['id_unidad_peso_neto'];
                $codigoUnidadPesoNeto = $item['codigo_unidad_peso_neto'];
                $pesoBruto = $item['peso_bruto'];
                $idUnidadPesoBruto = $item['id_unidad_peso_bruto'];
                $codigoUnidadPesoBruto = $item['codigo_unidad_peso_bruto'];
                $idTipoTratamiento = $item['id_tipo_tratamiento'];
                $codigoTipoTratamiento = $item['codigo_tipo_tratamiento'];
                $idTratamiento = $item['id_tratamiento'];
                $codigoTratamiento = $item['codigo_tratamiento'];
                $idDuracion = $item['id_duracion'];
                $codigoUnidadDuracion = $item['codigo_unidad_duracion'];
                $duracion = $item['duracion'];
                $idTemperatura = $item['id_temperatura'];
                $codigoUnidadTemperatura = $item['codigo_unidad_temperatura'];
                $temperatura = $item['temperatura'];
                $fechatemperatura = $item['fecha_tratamiento'];
                $productoQuimico = $item['producto_quimico'];
                $idConcetracion = $item['id_concentracion'];
                $fechaInspeccion = $item['fecha_inspeccion'];
                $codigoUnidadConcentracion = $item['codigo_unidad_concentracion'];
                $concentracion = $item['concentracion'];
                
                $arrayDatosProducto = ['id_certificado_fitosanitario' => $idCertificadoFitosanitario
                                        , 'id_total_inspeccion_fitosanitaria' => $idTotalInspeccionFitosanitaria
                                        , 'id_subtipo_producto' => $idSubtipoProducto
                                        , 'nombre_subtipo_producto' => $nombreSubtipoProducto
                                        , 'id_producto' => $idProducto
                                        , 'nombre_producto' => $nombreProducto
                                        , 'cantidad_comercial' => $cantidadComercial
                                        , 'id_unidad_cantidad_comercial' => $idUnidadCantidadComercial
                                        , 'codigo_unidad_cantidad_comercial' => $codigoUnidadCantidadComercial
                                        , 'peso_neto' => $pesoNeto
                                        , 'id_unidad_peso_neto' => $idUnidadPesoNeto
                                        , 'codigo_unidad_peso_neto' => $codigoUnidadPesoNeto
                                        , 'peso_bruto' => $pesoBruto
                                        , 'id_unidad_peso_bruto' => $idUnidadPesoBruto
                                        , 'codigo_unidad_peso_bruto' => $codigoUnidadPesoBruto
                                        , 'fecha_inspeccion' => $fechaInspeccion];
                
                if(isset($idTipoTratamiento)){
                    $arrayDatosProducto += ['id_tipo_tratamiento' => $idTipoTratamiento
                                            , 'codigo_tipo_tratamiento' => $codigoTipoTratamiento];
                }
                
                if(isset($idTratamiento)){
                    $arrayDatosProducto += ['id_tratamiento' => $idTratamiento
                                            , 'codigo_tratamiento' => $codigoTratamiento
                                            , 'id_duracion' => $idDuracion
                                            , 'codigo_unidad_duracion' => $codigoUnidadDuracion
                                            , 'duracion' => $duracion
                                            , 'fecha_tratamiento' => $fechatemperatura];
                }
                
                if(isset($idTemperatura)){
                    $arrayDatosProducto += ['id_temperatura' => $idTemperatura
                                            , 'codigo_unidad_temperatura' => $codigoUnidadTemperatura
                                            , 'temperatura' => $temperatura];
                }
                
                if(isset($idConcetracion)){
                    $arrayDatosProducto += ['producto_quimico' => $productoQuimico];
                }
                
                if(isset($idConcetracion)){
                    $arrayDatosProducto += ['id_concentracion' => $idConcetracion
                                            , 'codigo_unidad_concentracion' => $codigoUnidadConcentracion
                                            , 'concentracion' => $concentracion];
                }
                
                $statement = $this->modeloCertificadoFitosanitario->getAdapter()
                ->getDriver()
                ->createStatement();
                
                $sqlInsertar = $this->modeloCertificadoFitosanitario->guardarSql('certificado_fitosanitario_productos', $this->modeloCertificadoFitosanitario->getEsquema());
                $sqlInsertar->columns(array_keys($arrayDatosProducto));
                $sqlInsertar->values($arrayDatosProducto, $sqlInsertar::VALUES_MERGE);
                $sqlInsertar->prepareStatement($this->modeloCertificadoFitosanitario->getAdapter(), $statement);
                $statement->execute();               
                
	        }
	        
	        $qDatosPaisPuertoDestino = $this->lNegocioPaisesPuertosDestino->buscarLista(array('id_certificado_fitosanitario' => $idCertificadoReemplazo));
	        
	        foreach ($qDatosPaisPuertoDestino as $item) {
	            
	            $arrayDatosPaisPuertoDestino = "";
	            
	            $idPaisDestino = $item['id_pais_destino'];
	            $nombrePaisDestino = $item['nombre_pais_destino'];
	            $idPuertoDestino = $item['id_puerto_destino'];
	            $nombrePuertoDestino = $item['nombre_puerto_destino'];
	            
	            $arrayDatosPaisPuertoDestino = ['id_certificado_fitosanitario' => $idCertificadoFitosanitario
	                                            , 'id_pais_destino' => $idPaisDestino
                            	                , 'nombre_pais_destino' => $nombrePaisDestino
                            	                , 'id_puerto_destino' => $idPuertoDestino
                            	                , 'nombre_puerto_destino' => $nombrePuertoDestino];
	            
	            $statement = $this->modeloCertificadoFitosanitario->getAdapter()
	            ->getDriver()
	            ->createStatement();
	            
	            $sqlInsertar = $this->modeloCertificadoFitosanitario->guardarSql('paises_puertos_destino', $this->modeloCertificadoFitosanitario->getEsquema());
	            $sqlInsertar->columns(array_keys($arrayDatosPaisPuertoDestino));
	            $sqlInsertar->values($arrayDatosPaisPuertoDestino, $sqlInsertar::VALUES_MERGE);
	            $sqlInsertar->prepareStatement($this->modeloCertificadoFitosanitario->getAdapter(), $statement);
	            $statement->execute();   
	            
	        }
	        
	        $qDatosPaisPuertoTransito = $this->lNegocioPaisesPuertosTransito->buscarLista(array('id_certificado_fitosanitario' => $idCertificadoReemplazo));
	        
	        foreach ($qDatosPaisPuertoTransito as $item) {
	            
	            $arrayDatosPaisPuertoTransito = "";
	            
	            $idPaistransito = $item['id_pais_transito'];
	            $nombrePaisTransito = $item['nombre_pais_transito'];
	            $idPuertoTransito = $item['id_puerto_transito'];
	            $nombrePuertoTransito = $item['nombre_puerto_transito'];
	            $idMedioTransporteTransito = $item['id_medio_transporte_transito'];
	            $nombreMedioTransportetransito = $item['nombre_medio_transporte_transito'];
	            
	            $arrayDatosPaisPuertoTransito = ['id_certificado_fitosanitario' => $idCertificadoFitosanitario
                            	                , 'id_pais_transito' => $idPaistransito
                            	                , 'nombre_pais_transito' => $nombrePaisTransito
                            	                , 'id_puerto_transito' => $idPuertoTransito
                            	                , 'nombre_puerto_transito' => $nombrePuertoTransito
                            	                , 'id_medio_transporte_transito' => $idMedioTransporteTransito
                            	                , 'nombre_medio_transporte_transito' => $nombreMedioTransportetransito];
	            
	            $statement = $this->modeloCertificadoFitosanitario->getAdapter()
	            ->getDriver()
	            ->createStatement();
	            
	            $sqlInsertar = $this->modeloCertificadoFitosanitario->guardarSql('paises_puertos_transito', $this->modeloCertificadoFitosanitario->getEsquema());
	            $sqlInsertar->columns(array_keys($arrayDatosPaisPuertoTransito));
	            $sqlInsertar->values($arrayDatosPaisPuertoTransito, $sqlInsertar::VALUES_MERGE);
	            $sqlInsertar->prepareStatement($this->modeloCertificadoFitosanitario->getAdapter(), $statement);
	            $statement->execute();
	            
	        }
	        
	        $qDatosDocumentosAdjuntos = $this->lNegocioDocumentosAdjuntos->buscarLista(array('id_certificado_fitosanitario' => $idCertificadoReemplazo, 'tipo_adjunto' => 'Documento'));
	        
	        foreach ($qDatosDocumentosAdjuntos as $item) {
	            
	            $arrayDatosDocumentosAdjuntos = "";
	            
	            $tipoAdjunto = $item['tipo_adjunto'];
	            $rutaAdjunto = $item['ruta_adjunto'];
	            $rutaEnlaceAdjunto = $item['ruta_enlace_adjunto'];
                
                $arrayDatosDocumentosAdjuntos = ['id_certificado_fitosanitario' => $idCertificadoFitosanitario
                                                , 'tipo_adjunto' => $tipoAdjunto];
                
                if(isset($rutaAdjunto)){
                    $arrayDatosDocumentosAdjuntos += ['ruta_adjunto' => $rutaAdjunto];
                }
                
                if(isset($rutaEnlaceAdjunto)){
                    $arrayDatosDocumentosAdjuntos += ['ruta_enlace_adjunto' => $rutaEnlaceAdjunto];
                }
                
                $statement = $this->modeloCertificadoFitosanitario->getAdapter()
                ->getDriver()
                ->createStatement();
                
                $sqlInsertar = $this->modeloCertificadoFitosanitario->guardarSql('documentos_adjuntos', $this->modeloCertificadoFitosanitario->getEsquema());
                $sqlInsertar->columns(array_keys($arrayDatosDocumentosAdjuntos));
                $sqlInsertar->values($arrayDatosDocumentosAdjuntos, $sqlInsertar::VALUES_MERGE);
                $sqlInsertar->prepareStatement($this->modeloCertificadoFitosanitario->getAdapter(), $statement);
                $statement->execute();
	                        
	        }
	        
	        $statement = $this->modeloCertificadoFitosanitario->getAdapter()
	        ->getDriver()
	        ->createStatement();
	        
	        $datosCertificadoFitosanitario = "";
	        
	        $datosCertificadoFitosanitario = ['estado_certificado' => 'Anulado'
                                	           , 'motivo_reemplazo' => $motivoReemplazo
	                                           , 'fecha_reemplazo_certificado' => $fechaReemplazoCertificado
	                                           , 'certificado' => 'No'
	                                           , 'estado_ephyto' => 'Por atender'
	                                           ];
	        
	        $sqlActualizar = $this->modeloCertificadoFitosanitario->actualizarSql('certificado_fitosanitario', $this->modeloCertificadoFitosanitario->getEsquema());
	        $sqlActualizar->set($datosCertificadoFitosanitario);
	        $sqlActualizar->where(array('id_certificado_fitosanitario' => $idCertificadoReemplazo));
	        $sqlActualizar->prepareStatement($this->modeloCertificadoFitosanitario->getAdapter(), $statement);
	        $statement->execute();	        
	        
	        $resultado = $idCertificadoFitosanitario;
	        
	        $procesoIngreso->commit();
	        
	        return $resultado;
	        
	    }catch (GuardarExcepcion $ex){
	        $procesoIngreso->rollback();
	        throw new \Exception($ex->getMessage());
	    }
	}
	
	/**
	 * Metodo que guarda la revision documental de la solicitud
	 *
	 * @param array $datos
	 * @return int
	 */
	public function guardarRevisionDocumental(Array $datos){
		
		try{			
			
			$resultado = false;
			$idCertificadoFitosanitario = $datos['id_certificado_fitosanitario'];
			$identificadorRevision = $datos['identificador_inspector'];
			$identificadorAsignante = $datos['identificador_inspector'];
			$observacionRevision = $datos['observacion_revision'];
			$fechaRevision = "now()";
			
			$qDatosCertificadoFitosanitario = $this->buscar($idCertificadoFitosanitario);
			$esReemplazo = $qDatosCertificadoFitosanitario->getEsReemplazo(); 
			
			if(empty($esReemplazo)){			    
			    if($datos['resultado_revision'] == "documentalAprobado"){
			        $resultadoRevision = "pago";
			    }else{
			        $resultadoRevision = $datos['resultado_revision'];
			    }			    
			}else{			    
			    if($datos['resultado_revision'] == "documentalAprobado"){
			        $resultadoRevision = "Aprobado";
			    }else{
			        $resultadoRevision = $datos['resultado_revision'];
			    }
			}
						
			$procesoIngreso = $this->modeloCertificadoFitosanitario->getAdapter()
			->getDriver()
			->getConnection();
			$procesoIngreso->beginTransaction();
			
			$statement = $this->modeloCertificadoFitosanitario->getAdapter()
			->getDriver()
			->createStatement();
			
			$datosRevision = ['identificador_revision' => $identificadorRevision,
							'observacion_revision' => $observacionRevision,
							'estado_certificado' => $resultadoRevision,
							'fecha_revision' => $fechaRevision
							];
			
			if($resultadoRevision === "Rechazado" && empty($esReemplazo)){
			    
                $qDatosProductos = $this->lNegocioCertificadoFitosanitarioProductos->buscarLista(array('id_certificado_fitosanitario' => $idCertificadoFitosanitario));
			    
                foreach ($qDatosProductos as $item){                    
                   
                    $idTotalInspeccionFitosanitaria = $item['id_total_inspeccion_fitosanitaria'];
                    $cantidadComercial = $item['cantidad_comercial'];
                    $pesoNeto = $item['peso_neto'];
                    
                    $arrayDatosProductoAgregado = [
                        'tipo_transaccion' => 'ingreso',
                        'id_total_inspeccion_fitosanitaria' => $idTotalInspeccionFitosanitaria,
                        'cantidad_ingreso' => $cantidadComercial,
                        'peso_ingreso' => $pesoNeto,
                        'cantidad_egreso' => 0,
                        'peso_egreso' => 0];
                    
                    $this->lNegocioCertificadoFitosanitarioProductos->guardarTransaccionProductoAgregado($arrayDatosProductoAgregado);
                                        
                }
			    
			}
			
						
			$sqlActualizar = $this->modeloCertificadoFitosanitario->actualizarSql('certificado_fitosanitario', $this->modeloCertificadoFitosanitario->getEsquema());
			$sqlActualizar->set($datosRevision);
			$sqlActualizar->where(array(
				'id_certificado_fitosanitario' => $idCertificadoFitosanitario));
			$sqlActualizar->prepareStatement($this->modeloCertificadoFitosanitario->getAdapter(), $statement);
			$statement->execute();
			
			//Construye el array para el registro de informacion en tablas de revision de solicitudes
			
			$datosRevision = ['identificador_inspector' => $identificadorRevision,
							 'fecha_asignacion' => 'now()',
							 'identificador_asignante' => $identificadorAsignante,
							 'tipo_solicitud' => 'certificadoFito',
							 'tipo_inspector' => 'Documental',
							 'id_operador_tipo_operacion' => 0,
							 'id_historial_operacion' => 0,
							 'id_solicitud' => $idCertificadoFitosanitario,
							 'estado' => 'Documental',
							 'fecha_inspeccion' => 'now()',
							 'observacion' => $observacionRevision,
							 'estado_siguiente' => $resultadoRevision,
							 'orden' => 1];
			
			$this->lNegocioAsignacionInspector->guardar($datosRevision);
			
			$resultado = true;
						
			$procesoIngreso->commit();
			
			return $resultado;
			
		}catch (GuardarExcepcion $ex){
			$procesoIngreso->rollback();
			throw new \Exception($ex->getMessage());
		}
		
	}
	
	/**
	 * Ejecuta una consulta(SQL) personalizada para actualizar el
	 * estado de la generacion del certificado.
	 *
	 * @return array|ResultSet
	 */
	public function actualizarEstadoGeneracionCertificado($arrayParametros)
	{
		$idCertificadoFitosanitario = $arrayParametros['id_certificado_fitosanitario'];
		$certificado = $arrayParametros['certificado'];
		
		$consulta = "UPDATE
                         g_certificado_fitosanitario.certificado_fitosanitario
                     SET
                       certificado = '" . $certificado . "'
                     WHERE
                        id_certificado_fitosanitario = '" . $idCertificadoFitosanitario . "';";
		
		return $this->modeloCertificadoFitosanitario->ejecutarSqlNativo($consulta);
	}
	
	/**
	 * Función para crear el PDF del certificado
	 */
	public function generarCertificado($idSolicitud, $nombreArchivo, $rutaFechaCertificado, $nombreInspector, $provinciaInspector)
	{
		$jasper = new JasperReport();
		$datosReporte = array();
		$ruta = CERT_FITO_CERT_URL_TCPDF . 'certificados/' . $rutaFechaCertificado;
		
		//---local---//
		/*$rutaCertificado = 'http://localhost/agrodbPrueba/' . CERT_FITO_URL . 'certificados/' . $rutaFechaCertificado;
		 $rutaAnexo = 'http://localhost/agrodbPrueba/' . CERT_FITO_URL . 'certificados/' . $rutaFechaCertificado;*/
		
		//---Pruebas---//
		$rutaCertificado = 'http://181.112.155.163/agrodbPrueba/' . CERT_FITO_URL . 'certificados/' . $rutaFechaCertificado;
		$rutaAnexo = 'http://181.112.155.163/agrodbPrueba/' . CERT_FITO_URL . 'certificados/' . $rutaFechaCertificado;
		
		/*//---Produccion---//
		 $rutaCertificado = 'https://guia.agrocalidad.gob.ec/agrodb/' . CERT_FITO_URL . 'certificados/' . $rutaFechaCertificado;
		 $rutaAnexo = 'https://guia.agrocalidad.gob.ec/agrodb/' . CERT_FITO_URL . 'certificados/' . $rutaFechaCertificado;*/
		
		if (! file_exists($ruta)) {
			mkdir($ruta, 0777, true);
		}
		
		$datosReporte = array(
			'rutaReporte' => 'CertificadoFitosanitario/vistas/reportes/CertificadoFitosanitario.jasper',
			'rutaSalidaReporte' => 'CertificadoFitosanitario/archivos/certificados/' . $rutaFechaCertificado . 'C' . $nombreArchivo,
			'tipoSalidaReporte' => array(
				'pdf'
			),
			'parametrosReporte' => array(
				'idSolicitud' => (int) $idSolicitud,
				'nombreInspector' => $nombreInspector,
				'lugarExpedicion' => $provinciaInspector,
				'fondoCertificado' => RUTA_IMG_GENE . 'fondoCertificadoCFE.png',
				'rutaCertificado' => $rutaCertificado . 'C' . $nombreArchivo . '.pdf',
				'rutaAnexo' => $rutaAnexo . 'A' . $nombreArchivo . '.pdf'
			),
			'conexionBase' => 'SI'
		);
		
		$jasper->generarArchivo($datosReporte);
	}
	
	/**
	 * Función para crear el PDF del anexo
	 */
	public function generarAnexo($idSolicitud, $nombreArchivo, $rutaFechaCertificado, $nombreInspector, $provinciaInspector)
	{
		$jasper = new JasperReport();
		$datosReporte = array();
		
		$ruta = CERT_FITO_CERT_URL_TCPDF . 'certificados/' . $rutaFechaCertificado;
		
		if (! file_exists($ruta)) {
			mkdir($ruta, 0777, true);
		}
		
		$datosReporte = array(
			'rutaReporte' => 'CertificadoFitosanitario/vistas/reportes/AnexoCertificadoFitosanitario.jasper',
			'rutaSalidaReporte' => 'CertificadoFitosanitario/archivos/certificados/' . $rutaFechaCertificado . 'A' . $nombreArchivo,
			'tipoSalidaReporte' => array(
				'pdf'
			),
			'parametrosReporte' => array(
				'idSolicitud' => (int) $idSolicitud,
				'nombreInspector' => $nombreInspector,
				'lugarExpedicion' => $provinciaInspector,
				'fondoCertificadoHorizontal' => RUTA_IMG_GENE . 'fondoCertificadoCFEHorizontal.png'
			),
			'conexionBase' => 'SI'
		);
		
		$jasper->generarArchivo($datosReporte);
	}
	
	///////////////////////////
	///////////EPHYTO//////////
	
	/*
	 * Proceso de gereracion de XML Ephyto HUB
	 */
	function procesoGenerarXmlWebServicesCertificadosFitosanitario()
	{
		$lNegocioConfiguracionFitosanitario = new ConfiguracionFitosanitarioLogicaNegocio();
		
		$arrayParametros = array(
			'tipo_configuracion_fitosanitario' => 'emision',
			'plataforma_fitosanitario' => 'hub'
		);
		
		$paisConfiguracionFitosanitario = $lNegocioConfiguracionFitosanitario->buscarLista($arrayParametros);
		
		echo Constantes::IN_MSG . 'Obtención de configuración de envió ephyto\n';
		
		$idPaiesDestino = null;
		
		foreach ($paisConfiguracionFitosanitario as $pais) {
			$idPaiesDestino .= $pais['id_localizacion_fitosanitario'] . ', ';
		}
		
		echo Constantes::IN_MSG . 'Actualización de certificados por enviar HUB\n';
		
		$idPaiesDestino = " (" . rtrim($idPaiesDestino, ', ') . ") ";
		
		$arrayParametros = array(
			'id_pais_destino' => $idPaiesDestino,
			'condicion' => ' IN ',
			'estado' => 'Por atender'
		);
		
		$this->actualizarEstadoEphytoCertificadoFitosanitario($arrayParametros);
		
		echo Constantes::IN_MSG . 'Actualización de certificados que no se envian por HUB\n';
		
		$arrayParametros = array(
			'id_pais_destino' => $idPaiesDestino,
			'condicion' => ' NOT IN ',
			'estado' => 'Enviado',
		    'observacion_ephyto' => 'Cambio de estado_ephyto realizado automaticamente debido a que país destino no posee recepción a través de HUB'
		);

		$this->actualizarEstadoEphytoCertificadoFitosanitario($arrayParametros);
		
		echo Constantes::IN_MSG . 'Generación archivo XML Certificado Fitosanitario\n';
		
		$this->obtenerCertificadosFitosanitarioPorEnviarEphyto();
	}
	
	/**
	 * Ejecuta una consulta(SQL) personalizada para actualizar el
	 * estado de un certificado para envio ephyto
	 *
	 * @return array|ResultSet
	 */
	public function actualizarEstadoEphytoCertificadoFitosanitario($arrayParametros)
	{
		$idPaisDestino = $arrayParametros['id_pais_destino'];
		$condicion = $arrayParametros['condicion'];
		$estado = $arrayParametros['estado'];
		$observacionEphyto = isset($arrayParametros['observacion_ephyto']) ? ", observacion_ephyto = '" . $arrayParametros['observacion_ephyto'] . "'" : "";
				
		$consulta = "UPDATE
                        g_certificado_fitosanitario.certificado_fitosanitario
					SET
                       estado_ephyto = '$estado' $observacionEphyto
					FROM g_certificado_fitosanitario.paises_puertos_destino ppd                     
                     WHERE
						 ppd.id_certificado_fitosanitario = g_certificado_fitosanitario.certificado_fitosanitario.id_certificado_fitosanitario
                        and ppd.id_pais_destino $condicion $idPaisDestino
						and g_certificado_fitosanitario.certificado_fitosanitario.estado_certificado = 'Aprobado'
						and g_certificado_fitosanitario.certificado_fitosanitario.estado_ephyto is null;";
		
		return $this->modeloCertificadoFitosanitario->ejecutarSqlNativo($consulta);
	}
	
	/**
	 * Obtención de certificado fitosanitario para envio por Ephyto
	 */
	public function obtenerCertificadosFitosanitarioPorEnviarEphyto()
	{
		
		//$firmaXmlEphyto = new \Agrodb\WebServices\Modelos\FirmaXmlLogicaNegocio();
		
		echo Constantes::IN_MSG . 'Obtencion de certificado Fitosanitario para generación de  archivo XML\n';
		
		$query = "estado_ephyto = 'Por atender' and estado_certificado in ('Aprobado', 'Anulado')";
		
		$certificadoFitosanitario = $this->buscarLista($query);
		
		$certificadoFitosanitarioEphyto = new CertificadoFitosanitarioEphytoLogicaNegocio();
		$coneccion = $certificadoFitosanitarioEphyto->coneccionWebServicesEphyto();
		
		foreach ($certificadoFitosanitario as $certificado) {
			
			echo Constantes::IN_MSG . 'Certificado fitosanitario ' . $certificado['codigo_certificado'] . '\n';
			
			echo Constantes::IN_MSG . 'Actualziar estado envio de XML Certificado fitosanitario Ephyto HUB a W\n';
			
			$arrayParametros = array(
				'estado_ephyto' => 'W',
				'id_certificado_fitosanitario' => $certificado['id_certificado_fitosanitario']
			);
			
			$this->actualizar($arrayParametros);
			
			$datosCertificado = $this->generarXMLCertificadosFitosanitarioPorEnviarEphyto($certificado);
			
			//Obtener datos del inspector de revision documental						
			$identificadorInspector = '1717299596';//$certificado['identificador_revision'];			
			$datosFirmante = $this->lNegocioIdentificador->buscar($identificadorInspector);
			$rutaArchivo = $datosFirmante->getRutaArchivo();
			
			//$rutaXml = Constantes::RUTA_SERVIDOR_OPT . '/' . Constantes::RUTA_APLICACION . '/' .$datosCertificado['ruta_xml'];
			//$rutaLlave = $rutaArchivo . '_key.pem';
			//$rutaCertificado = $rutaArchivo . '.pem';
			
			//$firmaXmlEphyto->firmarXML($rutaXml, $rutaLlave, $rutaCertificado, $rutaXml);
			
			echo Constantes::IN_MSG . 'Guardado de XML Certificado fitosanitario Adjunto\n';
			
			$arrayParametros = array(
				'id_certificado_fitosanitario' => $certificado['id_certificado_fitosanitario'],
				'tipo_adjunto' => 'XML Ephyto'
			);
			
			$verificarAdjunto = $this->lNegocioDocumentosAdjuntos->buscarLista($arrayParametros);
			
			if ($verificarAdjunto->count()) {
				$arrayParametros += array(
					'ruta_adjunto' => $datosCertificado['ruta_xml'],
					'estado_adjunto' => 'Activo',
					'id_documento_adjunto' => $verificarAdjunto->current()->id_documento_adjunto
				);
			} else {
				$arrayParametros += array(
					'ruta_adjunto' => $datosCertificado['ruta_xml'],
					'estado_adjunto' => 'Activo'
				);
			}
			
			$this->lNegocioDocumentosAdjuntos->guardar($arrayParametros);
			
			echo Constantes::IN_MSG . 'Envio de XML Certificado fitosanitario Ephyto HUB\n';
			
			$contenido = file_get_contents(Constantes::RUTA_SERVIDOR_OPT.'/'.Constantes::RUTA_APLICACION.'/'.$datosCertificado['ruta_xml']);
			
			switch ($certificado['estado_certificado']) {
			    case 'Aprobado':
			        $codigoEstadoCertificado = '70';
			        break;
			    case 'Anulado':
			        $codigoEstadoCertificado = '40';
			        break;
			}
			
			$arrayParametros = array(
				'pais_origen' => $datosCertificado['pais_origen'],
				'pais_destino' => $datosCertificado['pais_destino'],
				'numero_certificado' => $datosCertificado['numero_certificado'],
				'tipo_certificado' => '851',
			    'estado_certificado' => $codigoEstadoCertificado, //'70',
				'contenido_xml' => $contenido
			);
			echo 11111;
			$certificadoFitosanitarioEphyto->envioEphyto($coneccion, $arrayParametros);
			
			echo Constantes::IN_MSG . 'Actualizar estado envio de XML Certificado fitosanitario Ephyto HUB\n';
			
			$arrayParametros = array(
				'estado_ephyto' => 'Enviado',
				'id_certificado_fitosanitario' => $certificado['id_certificado_fitosanitario']
			);
			
			$this->actualizar($arrayParametros);
		}
	}
	
	/**
	 * Generación de archivo XML certificado fitosanitario para envio por Ephyto
	 */
	public function generarXMLCertificadosFitosanitarioPorEnviarEphyto($certificado)
	{
		$comun = new \Agrodb\Core\Comun();
		
		$certificadoFitosanitarioCabecera = array();
		$certificadoFitosanitario = array();
		
		$idCertificadoFitosanitario = $certificado['id_certificado_fitosanitario'];
		$esReemplazo = $certificado['es_reemplazo'];
		$estadoCertificado = $certificado['estado_certificado'];
		$numeroCertificado = $certificado['codigo_certificado'];
		$nombreCiudad = "";
		$provinciaOrigen = "";
		$nombreConsignatario = $certificado['nombre_consignatario'];
		$direccionConsignatario = $certificado['direccion_consignatario'];
		$identificadorExportador = $certificado['identificador_exportador'];
		$nombreMarca = $certificado['nombre_marca'];
		//$fechaVigencia = date('c', strtotime($certificado['fecha_creacion_certificado']));
		$fechaEmbarque = date('c', strtotime($certificado['fecha_embarque']));
		$informacionAdicional = ($certificado['informacion_adicional'] == '' ? 'Sin información' : $certificado['informacion_adicional']);
		$fechaInspeccion = date('c', strtotime($certificado['fecha_revision']));
		$fechaFinVigencia = date('c', strtotime($certificado['fecha_creacion_certificado']));
		$rutaFecha = date('Y') . '/' . date('m') . '/' . date('d');
		$declaracionAdicional = "";
		
		//Declaracion adicional		
		$qDeclaracionAdicional = $this->obtenerDeclaracionAdicionalPorIdCertificadoFitosanitario($idCertificadoFitosanitario);
		$declaracionAdicional = $qDeclaracionAdicional->current()->informacion_adicional;
		
		//Provincia origen
		$idProvinciaPuertoEmbarque = $certificado['id_provincia_puerto_embarque'];
		$qDatosProvinciaOrigen = $this->lNegocioLocalizacion->buscar($idProvinciaPuertoEmbarque);		
		$nombreCiudad = $qDatosProvinciaOrigen->getNombre();
		$provinciaOrigen = $qDatosProvinciaOrigen->getNombre();
		
		
		$parametrosConsulta = array(
			'id_certificado_fitosanitario' => $idCertificadoFitosanitario
		);
		
		//Obtener datos del inspector de revision documental
		$identificadorInspector = $certificado['identificador_revision'];
		
		$resultadoUsuarioInterno = $this->lNegocioFichaEmpleado->buscarDatosUsuarioContrato($identificadorInspector);
		$nombreTecnicoAprobador = $resultadoUsuarioInterno->current()->nombre;
				
		
		//////////////////////
		///Datos pais origen//
		
		$idPaisOrigen = $certificado['id_pais_origen'];
		$qDatosPaisOrigen = $this->lNegocioLocalizacion->buscar($idPaisOrigen);
		$codigoPaisOrigen = $qDatosPaisOrigen->getCodigo();
		$nombrePaisOrigen = $qDatosPaisOrigen->getNombre();
		
		//////////////////////
		//Datos pais destino//
			
		$qDatosPaisDestino = $this->lNegocioPaisesPuertosDestino->buscarLista($parametrosConsulta);
		$idPaisDestino = $qDatosPaisDestino->current()->id_pais_destino;
		$qPaisDestino = $this->lNegocioLocalizacion->buscar($idPaisDestino);
		$codigoPaisDestino = $qPaisDestino->getCodigo();
		$nombrePaisDestino = $qPaisDestino->getNombre();

		
		$idPuertoDestino = $qDatosPaisDestino->current()->id_puerto_destino;
		$qDatosPuertoDestino = $this->lNegocioPuertos->buscar($idPuertoDestino);
		$codigoPuertoDestino = $qDatosPuertoDestino->getCodigoPuerto();
		
		if(strlen($codigoPuertoDestino) == 5){		    
		    $codigoPuertoDestino = $codigoPuertoDestino;		    
		}else{
		    $codigoPaisPuerto = $qDatosPuertoDestino->getCodigoPais();
		    $codigoPuertoDestino = $codigoPaisPuerto . $codigoPuertoDestino; 
		}		
		
		$nombrePuertoDestino = $qDatosPuertoDestino->getNombrePuerto();
		
		
		$medioTransporte = $this->lNegocioMediosTransporte->buscarLista(array(
			'id_medios_transporte' => $certificado['id_medio_transporte']
		));
		
		$arrayExportadores = array();
		$certificadoFitosanitarioProductos = array(
			'ram:IncludedSPSConsignmentItem' => array(
				'ram:IncludedSPSTradeLineItem' => array()
			)
		);		
		
		$datosProductoExportador = $this->lNegocioCertificadoFitosanitarioProductos->buscarLista($parametrosConsulta);
				
		$contador = 1;
		
		$qDatosExportador = $this->lNegocioOperadores->obtenerInformacionOperadorPorIdentificador($identificadorExportador);
		$nombreExportador = $qDatosExportador->current()->nombre_operador;
		$direccionExportador = $qDatosExportador->current()->direccion_operador;
		
		$arrayExportadores[] = array(
		    'nombre_exportador' => $nombreExportador,
		    'direccion_exportador' => $direccionExportador
		);
		
		foreach ($datosProductoExportador as $productoExportador) {
									
			$fechaInspeccionProducto = date('c', strtotime($productoExportador['fecha_inspeccion']));
			$cantidadComercial = $productoExportador['cantidad_comercial'];
			$codigoUnidadCantidadComercial = $productoExportador['codigo_unidad_cantidad_comercial'];
			$codigoUnidadPesoNeto = $productoExportador['codigo_unidad_peso_neto'];			
			$productoQuimico = $productoExportador['producto_quimico'];
			$duracionTratamiento = "";
			$nombreTratamiento = "";
			$codigoTratamiento = "";
			$nombreUnidadDuracionTratamiento = "";									 
			$temperaturaTratamiento = "";
			$nombreTemperaturaTratamiento = "";
			$codigoTemperaturaTratamiento = "";
			$concentracion = "";
			$nombreConcentracion = "";
			$datosTemperatura = "N/A";
			$fechaTratamientoProducto = "N/A";
			
			//$unidadMedidaCantidadComercial = $this->lNegocioUnidadesFitosanitarias->buscar($productoExportador['id_unidad_cantidad_comercial']);
			
			if(isset($productoExportador['id_tipo_tratamiento'])){
			
				$idTipoTratamiento = $productoExportador['id_tipo_tratamiento'];
				$qDatosTipoTratamiento = $this->lNegocioTiposTratamiento->buscar($idTipoTratamiento);
				$nombreTipoTratamiento = $qDatosTipoTratamiento->getNombreTipoTratamiento();
			
			}
			
			$qDatosProducto = $this->lNegocioProductos->buscar($productoExportador['id_producto']);
			$nombreProducto = $qDatosProducto->getNombreComun();
			$nombreCientificoProducto = $qDatosProducto->getNombreCientifico();			
			
			if (isset($productoExportador['id_tratamiento'])) {
				$duracionTratamiento = $productoExportador['duracion'];
				
				$unidadTratamiento = $this->lNegocioTratamientos->buscar($productoExportador['id_tratamiento']);
				$nombreTratamiento = $unidadTratamiento->getNombreTratamiento();
				$codigoTratamiento = $unidadTratamiento->getCodigoTratamiento();
				
				$unidadDuracionTratamiento = $this->lNegocioUnidadesFitosanitarias->buscar($productoExportador['id_duracion']);
				$nombreUnidadDuracionTratamiento = $unidadDuracionTratamiento->getNombreUnidadFitosanitaria();
			}
			
			if (isset($productoExportador['id_temperatura'])) {
				$temperaturaTratamiento = $productoExportador['temperatura'];
				$unidadTemperaturaTratamiento = $this->lNegocioUnidadesFitosanitarias->buscar($productoExportador['id_temperatura']);
				$nombreTemperaturaTratamiento = $unidadTemperaturaTratamiento->getNombreUnidadFitosanitaria();
				$codigoTemperaturaTratamiento = $unidadTemperaturaTratamiento->getCodigoUnidadFitosanitaria();
			}
					
			if (isset($productoExportador['id_concentracion'])) {
				$concentracion = $productoExportador['concentracion'];
				$unidadConcentracion = $this->lNegocioUnidadesFitosanitarias->buscar($productoExportador['id_concentracion']);
				$nombreConcentracion = $unidadConcentracion->getNombreUnidadFitosanitaria();
			}
			
			if (isset($productoExportador['id_temperatura'])) {
			    $productoQuimico = (isset($productoQuimico) ? '; Producto químico: ' . $productoQuimico : '');
			    $fechaTratamientoProducto = date('c', strtotime($productoExportador['fecha_tratamiento']));
			    $datosTemperatura = 'Fecha: ' . $fechaTratamientoProducto . '; Tipo: ' . $nombreTipoTratamiento . '; Duración: ' . $duracionTratamiento . ' ' . $nombreUnidadDuracionTratamiento . '; Tratamiento: ' . $nombreTratamiento . '; Temperatura: ' . $temperaturaTratamiento . ' ' . $nombreTemperaturaTratamiento . $productoQuimico . '; Concentración: ' . $concentracion . ' ' . $nombreConcentracion;
			}
			
			$productoCertificado = array(
				'ram:SequenceNumeric' => $contador ++,
				'ram:Description' => 'Ninguno',
				'ram:CommonName' => array(
					'_attributes' => array(
						'languageID' => 'es'
					),
					'_value' => $nombreProducto
				),
				'ram:ScientificName' => $nombreCientificoProducto,
				'ram:IntendedUse' => array(
					'_attributes' => array(
						'languageID' => 'es'
					),
					'_value' => 'Ninguno'
				),
				'ram:NetWeightMeasure' => array(
					'_attributes' => array(
						'unitCode' => $codigoUnidadPesoNeto
					),
					'_value' => $productoExportador['peso_neto']
				),
				'ram:NetVolumeMeasure' => array(
    				 '_attributes' => array(
    				    'unitCode' => $codigoUnidadCantidadComercial
    				 ),
    				 '_value' => $cantidadComercial
				 ),				 
			    'ram:AdditionalInformationSPSNote' => array(
			        array(
			            'ram:Subject' => 'ADTLIL',
			            'ram:Content' => array(
			                '_attributes' => array(
			                    'languageID' => 'es'
			                ),
			                '_value' => $declaracionAdicional
			            )
			        ),
			        array(
			            'ram:Subject' => 'ADDITLIL',
			            'ram:Content' => $fechaInspeccionProducto
			        )
			    ),
				'ram:ApplicableSPSClassification' => array(
					array(
						'ram:SystemName' => 'IPPCPCVP',
						'ram:ClassName' => array(
							'_attributes' => array(
								'languageID' => 'es'
							),
							'_value' => 'Frutas y hortalizas'
						)
					)
				),
				'ram:PhysicalSPSPackage' => array(
					array(
						'ram:LevelCode' => '1',
					    'ram:TypeCode' => $codigoUnidadCantidadComercial,
						'ram:ItemQuantity' => $cantidadComercial
					)
				),
				'ram:OriginSPSCountry' => array(
					array(
						'ram:ID' => $codigoPaisOrigen ,
						'ram:Name' => $nombrePaisOrigen,
						'ram:SubordinateSPSCountrySubDivision' => array(
							'ram:Name' => $provinciaOrigen,
							'ram:HierarchicalLevelCode' => '0'
						)
					)
				)
			);
			
			if(isset($productoExportador['id_tratamiento'])){
			    $productoCertificado['ram:AppliedSPSProcess'] = array(
			        'ram:TypeCode' => 'ZZZ',
			        'ram:ApplicableSPSProcessCharacteristic' => array(
			            array(
			                'ram:Description' => array(
			                    array(
			                        '_value' => 'TTFT'
			                    ),
			                    array(
			                        '_attributes' => array(
			                            'languageID' => 'es'
			                        ),
			                        '_value' => $datosTemperatura . '; Información Adicional: No hay información adicional disponible'
			                    )
			                )
			            )
			        )
			    );
			}
			
			if (isset($productoExportador['id_unidad_peso_bruto'])) {
				$pesoBruto = array(
					'ram:GrossWeightMeasure' => array(
						'_attributes' => array(
							'unitCode' => $codigoUnidadPesoNeto//$unidadMedidaPeso->current()->codigo_unidad_fitosanitaria
						),
						'_value' => $productoExportador['peso_bruto']
					)
				);
				
				$comun->insertarElementoArrayPosicion($productoCertificado, 'ram:NetVolumeMeasure', $pesoBruto);
			}

			/*if (isset($productoExportador['fecha_inspeccion'])) {
				$campoFechaInspeccion = array(
					'ram:AdditionalInformationSPSNote' => array(
						array(
							'ram:Subject' => 'ADDITLIL',
							'ram:Content' => $fechaInspeccionProducto
						)
					)
				);
				
				$comun->insertarElementoArrayPosicion($productoCertificado, 'ram:ApplicableSPSClassification', $campoFechaInspeccion);
			}*/
			
			if (isset($productoExportador['id_tratamiento'])) {
				$aDuracionTramiento = array(
					'ram:CompletionSPSPeriod' => array(
						'ram:StartDateTime' => array(
							'udt:DateTimeString' => $fechaTratamientoProducto
						),
						'ram:EndDateTime' => array(
							'udt:DateTimeString' => $fechaTratamientoProducto
						),
						'ram:DurationMeasure' => array(
							'_attributes' => array(
								'unitCode' => $codigoTratamiento
							),
							'_value' => $duracionTratamiento
						)
					)
				);
				
				$comun->insertarElementoArrayPosicion($productoCertificado['ram:AppliedSPSProcess'], 'ram:ApplicableSPSProcessCharacteristic', $aDuracionTramiento);
			}/* else {
				$aDuracionTramiento = array(
					'ram:CompletionSPSPeriod' => array(
						'ram:StartDateTime' => array(
							'udt:DateTimeString' => $fechaTratamientoProducto
						),
						'ram:EndDateTime' => array(
							'udt:DateTimeString' => $fechaTratamientoProducto
						)
					)
				);
				
				$comun->insertarElementoArrayPosicion($productoCertificado['ram:AppliedSPSProcess'], 'ram:ApplicableSPSProcessCharacteristic', $aDuracionTramiento);
			}*/
			
			if (isset($productoExportador['id_temperatura'])) {
				$aTemperaturaTratamiento = array(
					array(
						'ram:Description' => 'TTTM',
						'ram:ValueMeasure' => array(
							'_attributes' => array(
								'unitCode' => $codigoTemperaturaTratamiento
							),
							'_value' => $temperaturaTratamiento
						)
					)
				);				
				
				$comun->insertarElementoArrayPosicion($productoCertificado['ram:AppliedSPSProcess']['ram:ApplicableSPSProcessCharacteristic'], '1', $aTemperaturaTratamiento);
			}
			
			array_push($certificadoFitosanitarioProductos['ram:IncludedSPSConsignmentItem']['ram:IncludedSPSTradeLineItem'], $productoCertificado);			
			
		}
		
		$arrayExportadores = array_map("unserialize", array_unique(array_map("serialize", $arrayExportadores)));
		$nombresExportador = implode(', ', array_column($arrayExportadores, 'nombre_exportador'));
		$direccionesExportador = implode(', ', array_column($arrayExportadores, 'direccion_exportador'));

		$certificadoFitosanitarioCabecera = array(
			'rootElementName' => 'rsm:SPSCertificate',
			'_attributes' => array(
				'xmlns:udt' => 'urn:un:unece:uncefact:data:standard:UnqualifiedDataType:21',
				'xmlns:ram' => 'urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:21',
				'xmlns:rsm' => 'urn:un:unece:uncefact:data:standard:SPSCertificate:17'
			)
		);
		
		switch ($estadoCertificado) {
	       case 'Aprobado':
	           $codigoEstadoCertificado = '70';
	       break;
	       case 'Anulado':
	           $codigoEstadoCertificado = '40';
	       break;
	   }
		
		$certificadoFitosanitario = array(
			'rsm:SPSExchangedDocument' => array(
				'ram:Name' => 'CERTIFICADO FITOSANITARIO DE EXPORTACIÓN',
				'ram:ID' => $numeroCertificado,
				'ram:TypeCode' => '851',
				'ram:StatusCode' => $codigoEstadoCertificado,
				'ram:IssueDateTime' => array(
					'udt:DateTimeString' => $fechaEmbarque
				),
				'ram:IssuerSPSParty' => array(
					'ram:Name' => 'Organización de Protección Fitosanitaria de Ecuador'
				),
				'ram:IncludedSPSNote' => array(
					array(
						'ram:Subject' => 'SPSFL',
						'ram:Content' => '5'
					),
					array(
						'ram:Subject' => 'ADEDL',
						'ram:Content' => array(
							'_attributes' => array(
								'languageID' => 'es'
							),
							'_value' => $informacionAdicional
						)
					),
					array(
						'ram:Subject' => 'ADDIEDL',
						'ram:Content' => $fechaInspeccion
					),
				    array(
				        'ram:Subject' => 'DMCL',
				        'ram:Content' => $nombreMarca
				    )
				),
				'ram:SignatorySPSAuthentication' => array(
					'ram:ActualDateTime' => array(
						'udt:DateTimeString' => $fechaFinVigencia
					),
					'ram:IssueSPSLocation' => array(
						'ram:Name' => $nombreCiudad
					),
					'ram:ProviderSPSParty' => array(
						'ram:Name' => 'Ninguno',
						'ram:SpecifiedSPSPerson' => array(
							'ram:Name' => $nombreTecnicoAprobador
						)
					),
					'ram:IncludedSPSClause' => array(
						'ram:ID' => '1',
						'ram:Content' => 'Por la presente se certifica que las plantas, productos vegetales u otros artículos reglamentados descritos aquí se han inspeccionado y/o sometido a ensayo de acuerdo con los procedimientos oficiales adecuados y se considera que están libres de las plagas cuarentenarias especificadas por la parte contrante importadora y que cumplan los requisitos fitosanitarios vigentes de la parte contratante importadora, incluidos los relativos a las plagas no cuarentenarias reglamentadas.'
					)
				)
			),
			'rsm:SPSConsignment' => array(
				'ram:ConsignorSPSParty' => array(
					'ram:Name' => $nombresExportador,
					'ram:SpecifiedSPSAddress' => array(
						'ram:LineOne' => $direccionesExportador
					)
				),
				'ram:ConsigneeSPSParty' => array(
					'ram:Name' => $nombreConsignatario,
					'ram:SpecifiedSPSAddress' => array(
						'ram:LineOne' => $direccionConsignatario
					)
				),
				'ram:ExportSPSCountry' => array(
					'ram:ID' => $codigoPaisOrigen,
					'ram:Name' => $nombrePaisOrigen
				),
				'ram:ImportSPSCountry' => array(
					'ram:ID' => $codigoPaisDestino,
					'ram:Name' => $nombrePaisDestino
				),
				'ram:UnloadingBaseportSPSLocation' => array(
					'ram:ID' => $codigoPuertoDestino,
					'ram:Name' => $nombrePuertoDestino
				),
				'ram:ExaminationSPSEvent' => array(
					'ram:OccurrenceSPSLocation' => array(
						'ram:Name' => 'Ninguno'
					)
				),
				'ram:MainCarriageSPSTransportMovement' => array(
					'ram:ModeCode' => $medioTransporte->current()->codigo_hub,
					'ram:UsedSPSTransportMeans' => array(
						'ram:Name' => array(
							'_attributes' => array(
								'languageID' => 'es'
							),
							'_value' => $medioTransporte->current()->tipo
						)
					)
				)
			)
		);
		
		if(!empty($esReemplazo)){
		    
		    $idCertificadoReemplazo = $certificado['id_certificado_reemplazo'];		    
		    		    
		    $datosCertificadoReemplazo = $this->buscar($idCertificadoReemplazo);
		    $codigoCertificadoReemplazo = $datosCertificadoReemplazo->getCodigoCertificado();
		    $motivoReemplazo = $datosCertificadoReemplazo->getMotivoReemplazo();		    
		    $fechaReemplazo = date('c', strtotime($datosCertificadoReemplazo->getFechaReemplazoCertificado()));
			
		    $datosReemplazo = array(
		        array(
		            'ram:Subject' => 'ADRP',
		            'ram:Content' => '4'
		        ),
		        array(
		            'ram:Subject' => 'ADRPN',
		            'ram:Content' => $codigoCertificadoReemplazo
		        ),
		        array(
		            'ram:Subject' => 'ADRPR',
		            'ram:Content' => $motivoReemplazo
		        ),
		        array(
		            'ram:Subject' => 'ADRD',
		            'ram:Content' => $fechaReemplazo
		        )
		    );
		    
		    $comun->insertarElementoArrayPosicion($certificadoFitosanitario['rsm:SPSExchangedDocument']['ram:IncludedSPSNote'], 4, $datosReemplazo);
		    
		}
		
		$certificadoFitosanitario['rsm:SPSConsignment'] += $certificadoFitosanitarioProductos;
		
		$resultoXml = ArrayToXml::convert($certificadoFitosanitario, $certificadoFitosanitarioCabecera, true, 'UTF-8', '1.0', [
			'formatOutput' => true
		]);
		
		$dom = new \DOMDocument();
		$dom->preserveWhiteSpace = TRUE;
		$dom->loadXML($resultoXml);
		
		$rutaDominio = Constantes::RUTA_SERVIDOR_OPT . '/' . Constantes::RUTA_APLICACION . '/';
		$rutaArchivo = 'aplicaciones/mvc/modulos/CertificadoFitosanitario/archivos/certificados/' . $rutaFecha . '/';
		$nombreArchivo = $numeroCertificado . '.xml';
		
		if (! file_exists($rutaDominio . $rutaArchivo)) {
			mkdir($rutaDominio . $rutaArchivo, 0777, true);
		}
		// Save XML as a file
		$dom->save($rutaDominio . $rutaArchivo . $nombreArchivo);
		
		return array(
			'contenido_xml' => $resultoXml,
			'pais_origen' => $codigoPaisOrigen,
			'pais_destino' => $codigoPaisDestino,
			'numero_certificado' => $numeroCertificado,
			'ruta_xml' => $rutaArchivo . $nombreArchivo
		);
	}
	
	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 * Buscar certificados fitosanitarios usando filtros.
	 *
	 * @return array|ResultSet
	 */
	public function buscarCertificadosFitosanitariosPorFiltroRevisionDocumental($arrayParametros)
	{
		$identificadorOperador = $arrayParametros['identificadorOperador'];
		$tipoSolicitud = $arrayParametros['tipoSolicitud'];
		$idTipoProducto = $arrayParametros['idTipoProducto'];
		$idSubtipoProducto = $arrayParametros['idSubtipoProducto'];
		$idProducto = $arrayParametros['idProducto'];
		$paisDestino = $arrayParametros['paisDestino'];		
		$fechaInicio = $arrayParametros['fechaInicio'];
		$fechaFin = $arrayParametros['fechaFin'];
		$idProvinciaPuertoEmbarque = $arrayParametros['idProvinciaPuertoEmbarque'];
		$estadoCertificado = $arrayParametros['estadoCertificado'];
		$numeroCertificado = $arrayParametros['numeroCertificado'];
				
		$identificadorOperador = ($identificadorOperador == "") ? "NULL" : "'" . $identificadorOperador . "'";
		$tipoSolicitud = ($tipoSolicitud == "") ? "NULL" : "'" . $tipoSolicitud . "'";
		$idTipoProducto = ($idTipoProducto == "") ? "NULL" : "'" . $idTipoProducto . "'";
		$idSubtipoProducto = ($idSubtipoProducto == "") ? "NULL" : "'" . $idSubtipoProducto . "'";
		$idProducto = ($idProducto == "") ? "NULL" : "'" . $idProducto . "'";
		$paisDestino = ($paisDestino == "") ? "NULL" : "'" . $paisDestino . "'";
		$fechaInicio = ($tipoSolicitud == "") ? "NULL" : "'" . $fechaInicio . " 00:00:00'";
		$fechaFin = ($tipoSolicitud == "") ? "NULL" : "'" . $fechaFin . " 24:00:00'";
		$numeroCertificado = ($numeroCertificado == "") ? "NULL" : "'" . $numeroCertificado . "'";
		$idProvinciaPuertoEmbarque = ($idProvinciaPuertoEmbarque == "") ? "NULL" : "'" . $idProvinciaPuertoEmbarque . "'";
		$estadoCertificado = $estadoCertificado != "" ? "(" . $estadoCertificado . ")" : "(NULL)";
		
		$consulta = "SELECT
							DISTINCT                   
							cf.id_certificado_fitosanitario
							, cf.tipo_solicitud
							, cf.codigo_certificado
							, ppd.id_pais_destino
							, l.nombre
							, cf.fecha_creacion_certificado
							, cf.estado_certificado as estado_certificado
						 FROM
							g_certificado_fitosanitario.certificado_fitosanitario cf
						LEFT JOIN g_certificado_fitosanitario.certificado_fitosanitario_productos cfp ON cfp.id_certificado_fitosanitario = cf.id_certificado_fitosanitario
						LEFT JOIN g_catalogos.productos p ON p.id_producto = cfp.id_producto
						LEFT JOIN g_catalogos.subtipo_productos stp ON stp.id_subtipo_producto = p.id_subtipo_producto
						LEFT JOIN g_catalogos.tipo_productos tp ON tp.id_tipo_producto = stp.id_tipo_producto
						LEFT JOIN g_certificado_fitosanitario.paises_puertos_destino ppd ON ppd.id_certificado_fitosanitario = cf.id_certificado_fitosanitario
						LEFT JOIN g_catalogos.localizacion l ON l.id_localizacion = ppd.id_pais_destino
						WHERE
                        (" . $idProvinciaPuertoEmbarque . " is NULL or cf.id_provincia_puerto_embarque = " . $idProvinciaPuertoEmbarque . ")						
                        and (" . $identificadorOperador . " is NULL or cf.identificador_solicitante = " . $identificadorOperador . ")
                        and (" . $tipoSolicitud . " is NULL or cf.tipo_solicitud = " . $tipoSolicitud . ")
                        and (" . $idTipoProducto . " is NULL or tp.id_tipo_producto = " . $idTipoProducto . ")
                        and (" . $idSubtipoProducto . " is NULL or stp.id_subtipo_producto = " . $idSubtipoProducto . ")
                        and (" . $idProducto . " is NULL or p.id_producto = " . $idProducto . ")
                        and (" . $paisDestino . " is NULL or ppd.id_pais_destino = " . $paisDestino . ")
                        and (" . $fechaInicio . " is NULL or cf.fecha_creacion_certificado >= " . $fechaInicio . ")
                        and (" . $fechaFin . " is NULL or cf.fecha_creacion_certificado <= " . $fechaFin . ")
                        and (" . $numeroCertificado . " is NULL or cf.codigo_certificado = " . $numeroCertificado . ")
                        and (" . $estadoCertificado . " is NULL or cf.estado_certificado IN " . $estadoCertificado . ")
                    ORDER BY fecha_creacion_certificado DESC;";
		
		return $this->modeloCertificadoFitosanitario->ejecutarSqlNativo($consulta);
	}
	
	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 * Buscar certificados fitosanitarios usando filtros.
	 *
	 * @return array|ResultSet
	 */
	public function obtenerDeclaracionAdicionalPorIdCertificadoFitosanitario($idCertificadoFitosanitario)
	{
	    $consulta = "SELECT
                        	tr.id_certificado_fitosanitario
                        	, STRING_AGG(informacion_adicional, ', ') AS informacion_adicional
                        FROM
                        	(SELECT
                        	 	cfp.id_certificado_fitosanitario
                        		, COALESCE(COALESCE(STRING_AGG (DISTINCT (trf.informacion_adicional), ', '), '') || COALESCE(STRING_AGG (DISTINCT (trt.informacion_adicional), ', '), ''), 'N/A') AS informacion_adicional
                        	FROM
                        		g_certificado_fitosanitario.certificado_fitosanitario_productos cfp
                        	INNER JOIN (SELECT 
                        					cfp.id_certificado_fitosanitario
                        					, ep.id_certificado_fitosanitario_producto
                        					, p.nombre_comun || ' / ' || p.nombre_cientifico AS nombre_producto
                        					, COALESCE(STRING_AGG (DISTINCT (r.detalle_impreso), ', '), 'N/A') AS informacion_adicional
                        				FROM 
                        					g_certificado_fitosanitario.certificado_fitosanitario cfp
                        					INNER JOIN g_certificado_fitosanitario.paises_puertos_destino ppd ON ppd.id_certificado_fitosanitario = cfp.id_certificado_fitosanitario
                        					INNER JOIN g_certificado_fitosanitario.certificado_fitosanitario_productos ep ON cfp.id_certificado_fitosanitario = ep.id_certificado_fitosanitario
                        					INNER JOIN g_catalogos.productos p ON ep.id_producto = p.id_producto
                        					INNER JOIN g_requisitos.requisitos_comercializacion rc ON rc.id_producto = ep.id_producto
                        					INNER JOIN g_requisitos.requisitos_asignados ra ON rc.id_requisito_comercio = ra.id_requisito_comercio
                        					INNER JOIN g_requisitos.requisitos r ON ra.requisito = r.id_requisito
                        				WHERE
                        					rc.id_localizacion = ppd.id_pais_destino 
                        					AND ra.tipo = 'Exportación' 
                        					AND r.tipo = 'Exportación' 
                        					AND r.estado = 1
                        				GROUP BY cfp.id_certificado_fitosanitario, p.nombre_comun, p.nombre_cientifico, ep.id_certificado_fitosanitario_producto) trf ON trf.id_certificado_fitosanitario_producto = cfp.id_certificado_fitosanitario_producto
                        	LEFT JOIN (SELECT 
                        					cfp.id_certificado_fitosanitario
                        					, ep.id_certificado_fitosanitario_producto
                        					, p.nombre_comun || ' / ' || p.nombre_cientifico AS nombre_producto
                        					, COALESCE(STRING_AGG (DISTINCT (r.detalle_impreso), ', '), 'N/A') AS informacion_adicional
                        				FROM 
                        					g_certificado_fitosanitario.certificado_fitosanitario cfp
                        					INNER JOIN g_certificado_fitosanitario.paises_puertos_transito ppt ON ppt.id_certificado_fitosanitario = cfp.id_certificado_fitosanitario
                        					INNER JOIN g_certificado_fitosanitario.certificado_fitosanitario_productos ep ON cfp.id_certificado_fitosanitario = ep.id_certificado_fitosanitario
                        					INNER JOIN g_catalogos.productos p ON ep.id_producto = p.id_producto
                        					INNER JOIN g_requisitos.requisitos_comercializacion rc ON rc.id_producto = ep.id_producto
                        					INNER JOIN g_requisitos.requisitos_asignados ra ON rc.id_requisito_comercio = ra.id_requisito_comercio
                        					INNER JOIN g_requisitos.requisitos r ON ra.requisito = r.id_requisito
                        				WHERE
                        					rc.id_localizacion = ppt.id_pais_transito 
                        					AND ra.tipo = 'Tránsito' 
                        					AND r.tipo = 'Tránsito' 
                        					AND r.estado = 1		   		
                        				GROUP BY cfp.id_certificado_fitosanitario, p.nombre_comun, p.nombre_cientifico, ep.id_certificado_fitosanitario_producto) trt ON trt.id_certificado_fitosanitario_producto = cfp.id_certificado_fitosanitario_producto
                        	GROUP BY cfp.id_certificado_fitosanitario, trf.informacion_adicional) tr
                        	WHERE
                        		tr.id_certificado_fitosanitario = '" . $idCertificadoFitosanitario . "'
                        	GROUP BY tr.id_certificado_fitosanitario;";
		
		return $this->modeloCertificadoFitosanitario->ejecutarSqlNativo($consulta);
	}
	
	public function actualizar(Array $datos)
	{
		$tablaModelo = new CertificadoFitosanitarioModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		
		if ($tablaModelo->getIdCertificadoFitosanitario() != null && $tablaModelo->getIdCertificadoFitosanitario() > 0) {
			$this->modeloCertificadoFitosanitario->actualizar($datosBd, $tablaModelo->getIdCertificadoFitosanitario());
		}
	}
	
	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 *
	 * @return array|ResultSet
	 */
	public function buscarCertificadoFitosanitarioPorCodigoCertificadoPorEstado($arrayParametros)
	{
	    $codigoCertificado = $arrayParametros['codigo_certificado'];
	    $estadoCertificado = $arrayParametros['estado_certificado'];
	    
	    $consulta = "SELECT
                    	cf.id_certificado_fitosanitario
                    	, cf.codigo_certificado
                    	, TO_CHAR((CASE
                    		WHEN cf.tipo_solicitud = 'musaceas'THEN cf.fecha_embarque
                    		ELSE cf.fecha_aprobacion_certificado
                    		END), 'YYYY-MM-DD') as fecha_emision
                    	, cf.identificador_solicitante
                    	, CASE WHEN o.razon_social = '' THEN o.nombre_representante ||' '|| o.apellido_representante ELSE o.razon_social END nombre_operador
                    	, cf.estado_certificado
                    	, (l.nombre || ' / ' || l.nombre_ingles) AS nombre_pais_destino
                    	, STRING_AGG(DISTINCT(cfp.nombre_producto), ', ') AS nombre_producto
                    	, STRING_AGG(DISTINCT(da.ruta_adjunto), ', ') AS ruta_adjunto
                    FROM
                    	g_certificado_fitosanitario.certificado_fitosanitario cf
                    	INNER JOIN g_catalogos.tipos_produccion_fitosanitarias tpro ON tpro.id_tipo_produccion_fitosanitaria = cf.id_tipo_produccion
                    	INNER JOIN g_certificado_fitosanitario.certificado_fitosanitario_productos cfp ON cf.id_certificado_fitosanitario = cfp.id_certificado_fitosanitario
                    	INNER JOIN g_operadores.operadores o ON cf.identificador_solicitante = o.identificador
                    	INNER JOIN g_certificado_fitosanitario.documentos_adjuntos da ON cf.id_certificado_fitosanitario = da.id_certificado_fitosanitario
                    	INNER JOIN g_certificado_fitosanitario.paises_puertos_destino ppd ON ppd.id_certificado_fitosanitario = cf.id_certificado_fitosanitario
                    	INNER JOIN g_catalogos.localizacion l ON l.id_localizacion = ppd.id_pais_destino
                    WHERE
                    	cf.codigo_certificado = '" . $codigoCertificado . "'
                        and cf.estado_certificado = '" . $estadoCertificado . "'
						and da.tipo_adjunto IN ('Certificado Fitosanitario', 'Anexo Certificado')
                    	GROUP BY cf.id_certificado_fitosanitario, cf.codigo_certificado, fecha_emision , cf.identificador_solicitante, nombre_operador, cf.estado_certificado, l.nombre, l.nombre_ingles;";
	    
	    return $this->modeloCertificadoFitosanitario->ejecutarSqlNativo($consulta);
	}
	
}
