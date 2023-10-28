<?php
/**
 * Controlador InspeccionFitosanitaria
 *
 * Este archivo controla la lógica del negocio del modelo:  InspeccionFitosanitariaModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-15
 * @uses    InspeccionFitosanitariaControlador
 * @package InspeccionFitosanitaria
 * @subpackage Controladores
 */
namespace Agrodb\InspeccionFitosanitaria\Controladores;

use Agrodb\InspeccionFitosanitaria\Modelos\InspeccionFitosanitariaLogicaNegocio;
use Agrodb\InspeccionFitosanitaria\Modelos\InspeccionFitosanitariaModelo;
use Agrodb\Catalogos\Modelos\PuertosLogicaNegocio;
use Agrodb\Catalogos\Modelos\LocalizacionLogicaNegocio;
use Agrodb\InspeccionFitosanitaria\Modelos\ProductosInspeccionFitosanitariaLogicaNegocio;
use Agrodb\Catalogos\Modelos\ProductosLogicaNegocio;
use Agrodb\RegistroOperador\Modelos\OperacionesLogicaNegocio;
use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;
use Agrodb\Catalogos\Modelos\TiposProduccionFitosanitariasLogicaNegocio;

class InspeccionFitosanitariaControlador extends BaseControlador
{

    private $lNegocioInspeccionFitosanitaria = null;

    private $modeloInspeccionFitosanitaria = null;

    private $lNegocioLocalizacion = null;

    private $lNegocioPuertos = null;

    private $lNegocioProductosInspeccionFitosanitaria = null;

    private $lNegocioProductos = null;

    private $lNegocioOperaciones = null;
    
    private $lNegocioTiposProduccionFitosanitarias = null;

    private $accion = null;

    private $datosOperador = null;

    private $datosExportacion = null;
    
    private $datosRevision = null;

    private $datosDescripcionEnvio = null;

    private $datosProductoresAgregados = null;

    private $datosInspeccion = null;
    
    private $banderaDesestimiento = null;
    
    private $mensajeDesestimiento = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioInspeccionFitosanitaria = new InspeccionFitosanitariaLogicaNegocio();
        $this->modeloInspeccionFitosanitaria = new InspeccionFitosanitariaModelo();
        $this->lNegocioLocalizacion = new LocalizacionLogicaNegocio();
        $this->lNegocioPuertos = new PuertosLogicaNegocio();
        $this->lNegocioProductosInspeccionFitosanitaria = new ProductosInspeccionFitosanitariaLogicaNegocio();
        $this->lNegocioProductos = new ProductosLogicaNegocio();
        $this->lNegocioOperaciones = new OperacionesLogicaNegocio();
        $this->lNegocioTiposProduccionFitosanitarias = new TiposProduccionFitosanitariasLogicaNegocio();

        set_exception_handler(array(
            $this,
            'manejadorExcepciones'
        ));
    }

    /**
     * Método de inicio del controlador
     */
    public function index()
    {        
        
        $identificadorOperador = $this->usuarioActivo();
        $fechaActual = date('Y-m-d');
        $esInspector = false;
        
        $this->cargarPanelSolicitudes($esInspector);       
        
        $arrayParametros = ['idPaisDestino' => null
                            , 'tipoSolicitud' => null
                        	, 'numeroSolicitud' => null
							, 'idProducto' => null
                        	, 'identificadorSolicitante' => $identificadorOperador
                        	, 'estadoSolicitud' => null
                            , 'fechaInicio' => $fechaActual
                            , 'fechaFin' => $fechaActual
                        	, 'nombreProvincia' => null        
                            ];        
        
        $modeloInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscarFiltroSolicitudesInspeccionFitosanitaria($arrayParametros);
        $this->tablaHtmlInspeccionFitosanitaria($modeloInspeccionFitosanitaria);
        require APP . 'InspeccionFitosanitaria/vistas/listaInspeccionFitosanitariaVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nueva solicitud de inspección";

        $this->datosOperador = $this->construirDetalleOperador();
        $this->datosExportacion = $this->construirDetalleDatosExportacion();

        require APP . 'InspeccionFitosanitaria/vistas/formularioInspeccionFitosanitariaVista.php';
    }

    /**
     * Método para registrar en la base de datos -InspeccionFitosanitaria
     */
    public function guardar()
    {
        $estado = 'exito';
        $mensaje = '';

        $identificador = $this->usuarioActivo();
        $_POST['identificador_solicitante'] = $identificador;
        $idPuertoEmbarque = $_POST['id_puerto_embarque'];
        $idPaisDestino = $_POST['id_pais_destino'];
        
        $qPuertoEmbarque = $this->lNegocioPuertos->buscar($idPuertoEmbarque);
        $nombrePuertoEmbarque = $qPuertoEmbarque->getNombrePuerto();
        $_POST['nombre_puerto_embarque'] = $nombrePuertoEmbarque;
        
        $qPaisDestino = $this->lNegocioLocalizacion->buscar($idPaisDestino);
        $nombrePaisDestino = $qPaisDestino->getNombre();
        $_POST['nombre_pais_destino'] = $nombrePaisDestino;        

        $idInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->guardar($_POST);

        echo json_encode(array(
            "estado" => $estado,
            "mensaje" => $mensaje,
            "contenido" => $idInspeccionFitosanitaria
        ));
    }

    /**
     * Obtenemos los datos del registro seleccionado para editar - Tabla: InspeccionFitosanitaria
     */
    public function editar()
    {
        $idInspeccionFitosanitaria = $_POST["id"];
        
        $this->accion = "Inspeccion fitosanitaria";
        $this->modeloInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscar($idInspeccionFitosanitaria);
        $estado = $this->modeloInspeccionFitosanitaria->getEstadoInspeccionFitosanitaria();

        $this->datosOperador = $this->construirDetalleOperador();
        $this->datosExportacion = $this->construirDetalleDatosExportacion($estado);
        $this->datosRevision = $this->construirDatosRevision($idInspeccionFitosanitaria);
        $this->datosDescripcionEnvio = $this->construirDescripcionEnvio($estado);
        $this->datosProductoresAgregados = $this->construirProductoresAgregados($idInspeccionFitosanitaria, $estado);
        $this->datosInspeccion = $this->construirDatosLugarInspeccion($idInspeccionFitosanitaria, $estado);

        require APP . 'InspeccionFitosanitaria/vistas/formularioEditarInspeccionFitosanitariaVista.php';
    }
    
    /**
     * Obtenemos los datos del registro seleccionado para desistir - Tabla: InspeccionFitosanitaria
     */
    public function desistir()
    {
        
        /*$this->accion = "Editar InspeccionFitosanitaria";
        $this->modeloInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscar($idInspeccionFitosanitaria);
        $estado = $this->modeloInspeccionFitosanitaria->getEstadoInspeccionFitosanitaria();
        
        $this->datosOperador = $this->construirDetalleOperador();
        $this->datosExportacion = $this->construirDetalleDatosExportacion($estado);
        $this->datosRevision = $this->construirDatosRevision($idInspeccionFitosanitaria);
        $this->datosDescripcionEnvio = $this->construirDescripcionEnvio($estado);
        $this->datosProductoresAgregados = $this->construirProductoresAgregados($idInspeccionFitosanitaria, $estado);
        $this->datosInspeccion = $this->construirDatosLugarInspeccion($idInspeccionFitosanitaria, $estado);
        
        require APP . 'InspeccionFitosanitaria/vistas/formularioEditarInspeccionFitosanitariaVista.php';*/
        $this->accion = "Desistir solicitud inspección fitosanitaria";
        $elementos = array();
        $banderaMostrarDatos = false;        
        
        if(!empty($_POST['elementos'])){
            $elementos = explode(',', $_POST['elementos']);
        }

        if(empty($elementos)){
            $this->banderaDesestimiento = 'desestimiento';
            $this->mensajeDesestimiento = 'Por favor seleccione un registro.';
        }
        
        if(count($elementos) > 1){
            $this->banderaDesestimiento = 'desestimiento';
            $this->mensajeDesestimiento = 'Por favor seleccione un registro a la vez.';
        }
        
        if(count($elementos) == 1){
            
            $idInspeccionFitosanitaria = $elementos[0];
            
            $this->modeloInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscar($idInspeccionFitosanitaria);
            $estado = $this->modeloInspeccionFitosanitaria->getEstadoInspeccionFitosanitaria();
            
            switch ($estado) {
                case 'Creado':
                case 'Enviado':
                case 'Confirmado':
                case 'Subsanacion':
                case 'Subsanado':
                    $banderaMostrarDatos = true;
                break;
                
                default:
                    $this->banderaDesestimiento = 'desestimiento';
                    $this->mensajeDesestimiento = 'No puede desistrir una solicitud en este estado.';
                break;
            }
            
        }
        
        if($banderaMostrarDatos){
            $estado = 'Desistido';
            $this->datosOperador = $this->construirDetalleOperador();
            $this->datosExportacion = $this->construirDetalleDatosExportacion($estado);
            $this->datosRevision = $this->construirDatosRevision($idInspeccionFitosanitaria);
            $this->datosDescripcionEnvio = $this->construirDescripcionEnvio($estado);
            $this->datosProductoresAgregados = $this->construirProductoresAgregados($idInspeccionFitosanitaria, $estado);
            $this->datosInspeccion = $this->construirDatosLugarInspeccion($idInspeccionFitosanitaria, $estado);
        }
        
        require APP . 'InspeccionFitosanitaria/vistas/formularioDesistirInspeccionFitosanitariaVista.php';
        
    }
    
    /**
     * Método para registrar desestimiento en la base de datos -InspeccionFitosanitaria
     */
    public function enviarDesestimiento()
    {

        $idInspeccionFitosanitaria = $_POST['id_inspeccion_fitosanitaria'];
        $qDatosInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscar($idInspeccionFitosanitaria);
        $estadoAnterior = $qDatosInspeccionFitosanitaria->getEstadoInspeccionFitosanitaria();
        
        $datos = ['id_inspeccion_fitosanitaria' => $idInspeccionFitosanitaria
                , 'estado_anterior_inspeccion_fitosanitaria' => $estadoAnterior
                , 'estado_inspeccion_fitosanitaria' => 'Desistido'
                , 'fecha_desestimiento' => 'now()'
                ];
        
        $this->lNegocioInspeccionFitosanitaria->guardar($datos);
        
        Mensajes::exito(Constantes::GUARDADO_CON_EXITO);
        
    }

    /**
     * Método para borrar un registro en la base de datos - InspeccionFitosanitaria
     */
    public function borrar()
    {
        $this->lNegocioInspeccionFitosanitaria->borrar($_POST['elementos']);
    }

    /**
     * Construye el código HTML para desplegar la lista de - InspeccionFitosanitaria
     */
    public function tablaHtmlInspeccionFitosanitaria($tabla)
    {
        {
            $contador = 0;
            foreach ($tabla as $fila) {
                $this->itemsFiltrados[] = array(
                    '<tr id="' . $fila['id_inspeccion_fitosanitaria'] . '"
                    class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'InspeccionFitosanitaria\InspeccionFitosanitaria"
                    data-opcion="editar" ondragstart="drag(event)" draggable="true"
                    data-destino="detalleItem">
                    <td>' . ++ $contador . '</td>
                    <td style="white - space:nowrap; "><b>' . $fila['numero_solicitud'] . '</b></td>
                    <td>' . $fila['nombre_operador'] . '</td>
                    <td>' . $fila['estado_inspeccion_fitosanitaria'] . '</td>
                    <td>' . $fila['nombre_pais_destino'] . '</td>
                    <td>' . $fila['nombre_provincia_area'] . '</td>
                    <td>' . date('Y-m-d H:i', strtotime($fila['fecha_creacion'])) . '</td>
                    </tr>'
                );
            }
        }
    }

    /**
     * Método para construir los datos de exportacion
     */
    public function construirDetalleDatosExportacion($estado = null)
    {
        $datos = '';
        $numeroSolicitud = '';
        
        if($this->modeloInspeccionFitosanitaria->getNumeroSolicitud()){
            $numeroSolicitud = '<div data-linea="1">
                            <label>Número de solicitud: </label>'
                            . $this->modeloInspeccionFitosanitaria->getNumeroSolicitud() .
                            '</div>';
        }
        
        switch ($estado) {

            case 'Creado':
            case 'Enviado':
            case 'Confirmado':
            case 'Subsanacion':            
            case 'Aprobado':
            case 'Subsanado':
            case 'Rechazado':
			case 'Caducado':
			case 'Desistido':

            	$idTipoProduccion = $this->modeloInspeccionFitosanitaria->getIdTipoProduccion();
            	$qTipoProduccion = $this->lNegocioTiposProduccionFitosanitarias->buscar($idTipoProduccion);
            	$nombreTipoProduccion = $qTipoProduccion->getNombreTipoProduccionFitosanitaria();
            	
                $datos .= $numeroSolicitud . '<div data-linea="2">
                            <label>Puerto de embarque: </label>
                            ' . $this->modeloInspeccionFitosanitaria->getNombrePuertoEmbarque() . '
                            </div>
                            <div data-linea="3">
                                <label>País destino: </label>
                                ' . $this->modeloInspeccionFitosanitaria->getNombrePaisDestino() . '
                            </div>
                            <div data-linea="4">
                                <label>Tipo de producción: </label>
                                ' . $nombreTipoProduccion . '
                            <div data-linea="5">
                            <label>Lote de exp.: </label>';
                
                            if($estado === "Creado" || $estado === "Subsanacion"){
                                $datos .= '<input type="text" id="m_lotes_producto" name="m_lotes_producto" value="' . $this->modeloInspeccionFitosanitaria->getLotesProducto() . '" placeholder="Registre un número de lote" maxlength="1020">';
                            }else{
                                $datos .= $this->modeloInspeccionFitosanitaria->getLotesProducto();
                            }
        
                            $datos .= '</div>';

                break;

            default:
                
                $codigoPais = "EC";
                $qPais = $this->lNegocioLocalizacion->buscarPaisesPorCodigo($codigoPais);
                $idPais = $qPais->current()->id_localizacion;

                $datos .= '<div data-linea="1">
                            <label>Puerto de embarque: </label>
                            <select id="id_puerto_embarque" name="id_puerto_embarque" class="validacion">
                                <option value="">Seleccione...</option>'
                                . $this->comboPuertosPorIdProvincia($idPais) . 
                            '</select>
                            </div>
                            <div data-linea="2">
                            <label>País destino: </label>
                            <select id="id_pais_destino" name="id_pais_destino" class="validacion">
                                <option value="">Seleccione...</option>'
                                . $this->comboPaises() .
                            '</select>
                            </div>
                            <div data-linea="3">
                                <label>Tipo de producción: </label>
                                <select id="id_tipo_produccion" name="id_tipo_produccion" class="validacion">
                                    <option value="">Seleccione...</option>
                                    ' . $this->comboTipoProduccionFitosanitariasPorIdioma('SPA') . '
                                </select>
                            </div>
                            <div data-linea="4">
                                <label>Lote de exp.: </label>
                                <input type="text" id="lotes_producto" name="lotes_producto" placeholder="Registre un número de lote" maxlength="1020">
                            </div>';

                break;
        }
        
        return '<fieldset>
	               <legend>Datos de exportación</legend>' . $datos . '</fieldset>';
    }
    
    /**
     * Método para construir los datos de revision tecnica
     */
    public function construirDatosRevision($idInspeccionFitosanitaria){
        
        $datos = "";
        $datosAdicionales = "";
        $qDatosRevision = $this->lNegocioInspeccionFitosanitaria->buscar($idInspeccionFitosanitaria);
        $identificadorRevisor = ($qDatosRevision->getIdentificadorRevisor() != null ? $qDatosRevision->getIdentificadorRevisor() : false);
        $resultadoRevision = $qDatosRevision->getEstadoInspeccionFitosanitaria();
        $observacionRevisor = $qDatosRevision->getObservacionRevisor();
        $tiempoVigencia = $qDatosRevision->getTiempoVigencia();
        $fechaVigencia = $qDatosRevision->getFechaVigencia();
        $estado = $qDatosRevision->getEstadoInspeccionFitosanitaria();
        $rutaCertificadoInspeccion = $qDatosRevision->getRutaCertificadoInspeccion(); 
        
        switch ($estado){

            case 'Confirmado':
            case 'Subsanacion':
            case 'Aprobado':
            case 'Rechazado':
			case 'Caducado':
			case 'Desistido':
			
				if($identificadorRevisor){
					$arrayDatosRevisor = ['identificador' => $identificadorRevisor];					
					$qDatosRevisor = $this->lNegocioInspeccionFitosanitaria->obtenerDatosInspector($arrayDatosRevisor);					
					$nombreRevisor = $qDatosRevisor->current()->nombre_inspector;				
				}else{					
					$identificadorRevisor = "Sistema GUIA";
					$nombreRevisor = "Sistema GUIA";
				}
				
                if($estado === "Aprobado"){                
                    $datosAdicionales = '<div data-linea="7">
                                            <label>Certificado de inspección: </label><a href="' . $rutaCertificadoInspeccion . '" target="_blank">Archivo</a>
                                        <div>';                
                }
                
                $datos = '<fieldset>
                    <legend>Resultado de inspección</legend>
                        <div data-linea="1">
                            <label>Identificador Revisor: </label>' . $identificadorRevisor . '
                        <div>
 						<div data-linea="2">
                            <label>Nombre Revisor: </label>' . $nombreRevisor . '
                        <div>
                        <div data-linea="3">
                            <label>Resultado: </label>' . $resultadoRevision . '
                        <div>
                        <div data-linea="4">
                            <label>Observación: </label>' . $observacionRevisor . '
                        <div>
                        <div>
                        <div data-linea="5">
                            <label>Tiempo de vigencia: </label>' . (isset($tiempoVigencia) ? $tiempoVigencia. ' días' : 'N/A') . '
                        <div>
                        <div data-linea="6">
                            <label>Fecha de vigencia: </label>' . (($fechaVigencia !== "") ? date('Y-m-d', strtotime($fechaVigencia)) : 'N/A') . '
                        <div>'
                         . $datosAdicionales .
                         '</fieldset>';
                
            break;            
            
        }
       
        return $datos;
        
    }

    /**
     * Método para construir los datos de las areas de productores a inspeccionar
     */
    public function construirDescripcionEnvio($estado)
    {

        $datos = "";

        switch ($estado) {
            case 'Creado':
            case 'Subsanacion':
                
                $datos = '<fieldset id="fDescripcionEnvio">
    	               <legend>Descripción del envío / Productores</legend>
                        <div data-linea="1">
                        	<input name="r_codigo" type="radio" value="mag"><span> Código MAG</span>
                        </div>
                        <div data-linea="1">
                        	<input name="r_codigo" type="radio" value="area"><span> Centro de Acopio o Lugar de producción</span>
                        </div>
                        <hr/>
                        <div data-linea="2">
                            <label>Ingrese el código: </label>
                            <input type="text" id="codigo" name="codigo" class="validacion" disabled="disabled">
                        </div>
                	    <div data-linea="3">
                    	    <label>Nombre lugar: </label>
                    	    <input type="text" id="nombre_lugar" name="nombre_lugar" disabled="disabled" readonly="readonly" data-idarea >
                	    </div>
                        <hr/>
                        <div data-linea="5">
                            <label>Tipo de producto: </label>
                            <select id="id_tipo_producto" name="id_tipo_producto" class="validacion">
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
                        <div data-linea="6">
                            <label>Subtipo de producto: </label>
                            <select id="id_subtipo_producto" name="id_subtipo_producto" class="validacion">
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
                        <div data-linea="7">
                            <label>Producto: </label>
                            <select id="id_producto" name="id_producto" class="validacion">
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
                        <hr/>
                        <div data-linea="8">
                            <label>Cantidad: </label>
                             <input type="text" id="cantidad_producto" name="cantidad_producto" class="validacion" placeholder="Ejm: 1256.23" autocomplete="off" maxlength="10">
                        </div>
                        <div data-linea="8">
                            <label>Unidad: </label>
                            <select id="id_unidad_cantidad_producto" name="id_unidad_cantidad_producto" class="validacion">
                                <option value="">Seleccione...</option>
                                ' . $this->comboUnidadesFitosanitaras('Medida') . '
                            </select>
                        </div>
                        <div data-linea="9">
                            <label>Peso: </label>
                             <input type="text" id="peso_producto" name="peso_producto" class="validacion" placeholder="Ejm: 1256.23" autocomplete="off" maxlength="10">
                        </div>
                        <div data-linea="9">
                            <label>Unidad: </label>
                            <select id="id_unidad_peso_producto" name="id_unidad_peso_producto" class="validacion">
                                <option value="">Seleccione...</option>
                                ' . $this->comboUnidadesFitosanitaras('Medida', 'KGM', true) . '
                            </select>
                        </div>
                        <hr/>
                        <div data-linea="10">
                            <label>Tipo tratamiento: </label>
                            <select id="id_tipo_tratamiento" name="id_tipo_tratamiento">
                                <option value="">Seleccione...</option>
                                ' . $this->comboTiposTratamientoPorIdioma('SPA') . '
                            </select>
                        </div>
                        <div data-linea="10">
                            <label>Tratamiento: </label>
                            <select id="id_tratamiento" name="id_tratamiento">
                                <option value="">Seleccione...</option>
                                ' . $this->comboTratamientosPorIdioma('SPA') . '
                            </select>
                        </div>
                        <div data-linea="11">
                            <label>Duración: </label>
                            <input type="text" id="duracion" name="duracion" placeholder="Ejm: 2" autocomplete="off" maxlength="6">
                        </div>
                        <div data-linea="11">
                            <select id="id_duracion" name="id_duracion">
                                <option value="">Seleccione...</option>
                                ' . $this->comboUnidadesFitosanitaras('Duracion') . '
                            </select>
                        </div>
                        <div data-linea="12">
                            <label>Temperatura: </label>
                            <input type="text" id="temperatura" name="temperatura" placeholder="Ejm: 42" autocomplete="off" maxlength="6">
                        </div>
                        <div data-linea="12">
                            <select id="id_temperatura" name="id_temperatura">
                                <option value="">Seleccione...</option>
                                ' . $this->comboUnidadesFitosanitaras('Temperatura') . '
                            </select>
                        </div>
                        <div data-linea="13">
                            <label>Fecha tratamiento: </label>
                            <input type="text" id="fecha_tratamiento" name="fecha_tratamiento" readonly="readonly" placeholder="Ejm: 2023-01-10" autocomplete="off">
                        </div>
                        <div data-linea="13">
                            <label>Producto químico: </label>
                            <input type="text" id="producto_quimico" name="producto_quimico" placeholder="Ejm: Químico" autocomplete="off" maxlength="60">
                        </div>
                        <div data-linea="14">
                            <label>Concentración: </label>
                            <input type="text" id="concentracion" name="concentracion" placeholder="Ejm: Concentración" autocomplete="off" maxlength="6">
                        </div>
                        <div data-linea="14">
                            <select id="id_concentracion" name="id_concentracion">
                                <option value="">Seleccione...</option>
                                ' . $this->comboUnidadesFitosanitaras('Concentracion') . '
                            </select>
                        </div>
                        <div data-linea="15">
                			<button type="button" class="mas" id="agregarProductor">Agregar</button>
                		</div></fieldset>';
            break;
            
        }

        return $datos;
    }

    /**
     * Método para construir los productores agregados
     */
    public function construirProductoresAgregados($idInspeccionFitosanitaria, $estado)
    {
        $productosInspeccionFitosanitaria = new ProductosInspeccionFitosanitariaControlador();
        $datos = $productosInspeccionFitosanitaria->crearProductoresAgregados($idInspeccionFitosanitaria, $estado);

        return $datos;
    }

    /**
     * Método para construir los datos del area a inspeccionar
     */
    public function construirDatosLugarInspeccion($idInspeccionFitosanitaria, $estado)
    {
        $datos = "";
        $comboLugarInspeccion = "";
        $datosInspeccion = "";

        $qInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscar($idInspeccionFitosanitaria);
        $idPaisDestino = $qInspeccionFitosanitaria->getIdPaisDestino();
        $tipoArea = $qInspeccionFitosanitaria->getTipoArea();
        
        switch ($estado) {

            case 'Creado':
            case 'Subsanacion':
                
                if ($estado === "Subsanacion"){
                    $datosInspeccion = '<div data-linea="7">
                                            <label>Fecha: </label>'
                                            . $this->modeloInspeccionFitosanitaria->getFechaInspeccion() .
                                        '</div>
                                        <div data-linea="7">
                                            <label>Hora: </label>'
                                            . date('H:i', strtotime($this->modeloInspeccionFitosanitaria->getHoraInspeccion())) .
                                        '</div>';
                }else{
                    $datosInspeccion = '<div data-linea="7">
                                        <label>Fecha: </label>
                                            <input type="text" id="fecha_lugar_inspeccion" name="fecha_lugar_inspeccion" value= "' . $this->modeloInspeccionFitosanitaria->getFechaInspeccion() . '" class="validacion" readonly="readonly" placeholder="Ejm: 2023-01-10" autocomplete="off">
                                        </div>
                                        <div data-linea="7">
                                        <label>Hora: </label>
                                            <input type="text" id="hora_lugar_inspeccion" name="hora_lugar_inspeccion" value= "' . $this->modeloInspeccionFitosanitaria->getHoraInspeccion() . '" class="validacion" data-inputmask="' . "'mask': '99:99'" . '" placeholder="Ejm: 12:54" autocomplete="off">
                                        </div>';
                }                             

                $comboLugarInspeccion = $this->validarConstruirComboLugarInspeccion($idInspeccionFitosanitaria, $idPaisDestino);
                
                $datos = '
                    <form id="formularioEnviarSolicitudInspeccion" data-rutaAplicacion="' . URL_MVC_FOLDER . 'InspeccionFitosanitaria" data-opcion="InspeccionFitosanitaria/enviarSolicitud" data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
                    <input type="hidden" id="id_inspeccion_fitosanitaria" name="id_inspeccion_fitosanitaria" value="' . $this->modeloInspeccionFitosanitaria->getIdInspeccionFitosanitaria() . '" />
                    <input type="hidden" id="estado_inspeccion_fitosanitaria" name="estado_inspeccion_fitosanitaria" value="' . $this->modeloInspeccionFitosanitaria->getEstadoInspeccionFitosanitaria() . '" />
					<input type="hidden" id="lotes_producto" name="lotes_producto" value="' . $this->modeloInspeccionFitosanitaria->getLotesProducto() . '" />
					<input type="hidden" id="tipo_solicitud" name="tipo_solicitud" value="' . $comboLugarInspeccion['tipoSolicitud'] . '" />                  
                    <fieldset>
                    <legend id="fDatosInspeccion">Datos de inspección</legend>
                    <div data-linea="1">
                        <label>Lugar de inspección: </label>' . $comboLugarInspeccion['comboLugarInspeccion'] . 
                    '</div>
                    <div data-linea="2">
                        <label>Código del lugar: </label>
                        <input type="text" id="codigo_lugar_inspeccion" name="codigo_lugar_inspeccion" disabled="disabled" autocomplete="off" maxlength="250">
                    </div>
					<div data-linea="3" id="dProvincia">
                    </div>
                    <div data-linea="4">
                	    <label>Nombre lugar: </label>
                	    <input type="text" id="nombre_lugar_inspeccion" name="nombre_lugar_inspeccion" disabled="disabled" readonly="readonly" autocomplete="off" maxlength="250">
            	    </div>
                    <div data-linea="5">
                	    <label>Dirección: </label>
                	    <input type="text" id="direccion_lugar_inspeccion" name="direccion_lugar_inspeccion" disabled="disabled" readonly="readonly" autocomplete="off" maxlength="250">
            	    </div>
                    <div data-linea="6">
                	    <label>Latitud: </label>
                	    <input type="text" id="latitud_lugar_inspeccion" name="latitud_lugar_inspeccion" disabled="disabled" autocomplete="off" maxlength="30">
            	    </div>
                    <div data-linea="6">
                	    <label>Longitud: </label>
                	    <input type="text" id="longitud_lugar_inspeccion" name="longitud_lugar_inspeccion" disabled="disabled" autocomplete="off" maxlength="30">
            	    </div>'
                    . $datosInspeccion .
                    '<div data-linea="8">
                	    <label>Observación: </label>
                	    <input type="text" id="observacion_lugar_inspeccion" name="observacion_lugar_inspeccion" placeholder="Registre una observación" autocomplete="off" maxlength="510">
            	    </div>                    
                    </fieldset>
                    <div data-linea="1">
                    	<button type="submit" class="guardar">Enviar solicitud</button>
                   	</div>
                    </form>';
                
                break;
                
            default:
            	
            	$tipoLugarInspeccion = $this->construirLugarInspeccion($tipoArea);
            	
            	switch ($tipoArea){
            		case 'ACO':
            		case 'PRO':
            		case 'AGE':
            			$codigoProvincia = $qInspeccionFitosanitaria->getIdProvinciaArea();
            			$codigoProvincia = str_pad($codigoProvincia, 3, "0", STR_PAD_LEFT);
            			$qDatosProvincia = $this->lNegocioLocalizacion->buscarLista(array('codigo_vue' => $codigoProvincia));
            			$idProvincia = $qDatosProvincia->current()->id_localizacion;
            			
            			break;
            		case 'PUE':
            			$idPuertoEmbarque = $qInspeccionFitosanitaria->getIdPuertoEmbarque();
            			$qDatosPuerto = $this->lNegocioPuertos->buscar($idPuertoEmbarque);
            			$idProvincia = $qDatosPuerto->getIdProvincia();
            			break;            		
            	}
            	
				$nombreProvincia =  "";
            	
            	if(isset($idProvincia)){            	
	            	$qDatosProvincia = $this->lNegocioLocalizacion->buscar($idProvincia);
	            	$nombreProvincia = $qDatosProvincia->getNombre();
				}
				
                $datos = '<fieldset>
                    <legend id="fDatosInspeccion">Datos de inspección</legend>
					<div data-linea="1">
                        <label>Provincia: </label>'
                	. (($nombreProvincia == "") ? "N/A" : $nombreProvincia) .
                    '</div>
					<div data-linea="1">
                        <label>Lugar de inspección: </label>'
                        . (($tipoLugarInspeccion == "") ? "N/A" : $tipoLugarInspeccion) .
                    '</div>
                    <div data-linea="2">
                        <label>Código del lugar: </label>'
                        . (($this->modeloInspeccionFitosanitaria->getCodigoArea() == "") ? "N/A" : $this->modeloInspeccionFitosanitaria->getCodigoArea()) .
                    '</div>
                    <div data-linea="4">
                	    <label>Nombre lugar: </label>'
                    	. (($this->modeloInspeccionFitosanitaria->getNombreArea() == "") ? "N/A" : $this->modeloInspeccionFitosanitaria->getNombreArea()) .
            	    '</div>
                    <div data-linea="5">
                	    <label>Dirección: </label>'
            	        . (($this->modeloInspeccionFitosanitaria->getDireccionArea() == "") ? "N/A" : $this->modeloInspeccionFitosanitaria->getDireccionArea()) .
            	    '</div>
                    <div data-linea="6">
                	    <label>Latitud: </label>'
            	        . (($this->modeloInspeccionFitosanitaria->getLatitud() == "") ? "N/A" : $this->modeloInspeccionFitosanitaria->getLatitud()) .
            	    '</div>
                    <div data-linea="6">
                	    <label>Longitud: </label>'
            	        . (($this->modeloInspeccionFitosanitaria->getLongitud() == "") ? "N/A" : $this->modeloInspeccionFitosanitaria->getLongitud()) .
            	    '</div>
                    <div data-linea="7">
                	    <label>Fecha: </label>'
            	        . (($this->modeloInspeccionFitosanitaria->getFechaInspeccion() == "") ? "N/A" : $this->modeloInspeccionFitosanitaria->getFechaInspeccion()) .
            	    '</div>
                    <div data-linea="7">
                	    <label>Hora: </label>'
            	        . (($this->modeloInspeccionFitosanitaria->getFechaInspeccion() == "") ? "N/A" : date('H:i', strtotime($this->modeloInspeccionFitosanitaria->getHoraInspeccion()))) .
            	    '</div>
                    <div data-linea="8">
                	    <label>Observación: </label>'
            	    	. (($this->modeloInspeccionFitosanitaria->getObservacion() == "") ? "N/A" : $this->modeloInspeccionFitosanitaria->getObservacion()).
            	    '</div>
                    </fieldset>';
                
            break;
        }

        return $datos;
    }

    /**
     * Método para obtener los centros de acopio por codigo
     */
    public function buscarAreaCodigoMag()
    {
        $validacion = "";
        $mensaje = "";
        $resultado = "";

        $tipoCodigo = $_POST["tipoCodigo"];
        $codigo = $_POST["codigo"];

        $arrayParametros = [
            'tipoCodigo' => $tipoCodigo,
            'codigo' => $codigo
        ];

        $datosAreaCodigoMag = $this->lNegocioInspeccionFitosanitaria->obtenerDatosAreaCodigoMag($arrayParametros);

        if ($datosAreaCodigoMag->count()) {

            $identificadorOperador = $datosAreaCodigoMag->current()->identificador_operador;
            $nombreOperador = $datosAreaCodigoMag->current()->nombre_operador;
            $idSitio = $datosAreaCodigoMag->current()->id_sitio;
            $nombreSitio = $datosAreaCodigoMag->current()->nombre_sitio;
            $nombreProvincia = $datosAreaCodigoMag->current()->nombre_provincia;
            $nombreCanton = $datosAreaCodigoMag->current()->nombre_canton;
            $idArea = $datosAreaCodigoMag->current()->id_area;
            $nombreArea = $datosAreaCodigoMag->current()->nombre_area;
            $codigoArea = $datosAreaCodigoMag->current()->codigo_area;
            $validacion = 'Exito';

            $resultado = ['identificadorProductor' => $identificadorOperador
                            , 'nombreOperador' => $nombreOperador
                            , 'idSitio' => $idSitio
                            , 'nombreSitio' => $nombreSitio
                            , 'nombreProvincia' => $nombreProvincia
                            , 'nombreCanton' => $nombreCanton
                            , 'idArea' => $idArea
                            , 'nombreArea' => $nombreArea
                            , 'codigoArea' => $codigoArea
                        ];
        } else {
            $validacion = 'Fallo';
            $mensaje = 'El código ingresado no corresponde a un Productor, Centro de acopio registrado.';
        }

        echo json_encode(array(
            'validacion' => $validacion,
            'mensaje' => $mensaje,
            'resultado' => $resultado
        ));
    }

    /**
     * Método para obtener los tipos de productos
     */
    public function obtenerTipoProductoPorArea()
    {
        $validacion = "";
        $mensaje = "";
        $resultado = "";
        $comboTipoProducto = "";

        $idPaisDestino = $_POST["idPaisDestino"];
        $idArea = $_POST["idArea"];

        $arrayParametros = [
            'idPaisDestino' => $idPaisDestino,
            'idArea' => $idArea
        ];

        $datosTipoOperacion = $this->lNegocioInspeccionFitosanitaria->obtenerTipoProductoPorAreaPorRequisitos($arrayParametros);

        if ($datosTipoOperacion->count()) {
            $comboTipoProducto .= '<select id="id_tipo_producto" name="id_tipo_producto">
                                    <option value="">Seleccione...</option>';
            foreach ($datosTipoOperacion as $item) {
                $comboTipoProducto .= '<option value="' . $item['id_tipo_producto'] . '">' . $item['nombre_tipo_producto'] . '</option>';
            }
            $comboTipoProducto .= '</select>';
            $validacion = 'Exito';
            $resultado = $comboTipoProducto;
        } else {
            $validacion = 'Fallo';
            $mensaje = 'El operador no posee tipos de productos con requisitos en el área seleccionada.';
        }

        echo json_encode(array(
            'validacion' => $validacion,
            'mensaje' => $mensaje,
            'resultado' => $resultado
        ));
    }

    /**
     * Método para obtener los subtipos de productos
     */
    public function obtenerSubtipoProductoPorArea()
    {
        $validacion = "";
        $mensaje = "";
        $resultado = "";
        $comboSubtipoProducto = "";

        $idPaisDestino = $_POST["idPaisDestino"];
        $idArea = $_POST["idArea"];
        $idTipoProducto = $_POST["idTipoProducto"];

        $arrayParametros = [
            'idPaisDestino' => $idPaisDestino,
            'idArea' => $idArea,
            'idTipoProducto' => $idTipoProducto
        ];

        $datosTipoOperacion = $this->lNegocioInspeccionFitosanitaria->obtenerSubtipoProductoPorAreaPorRequisitos($arrayParametros);

        if ($datosTipoOperacion->count()) {
            $comboSubtipoProducto .= '<select id="id_subtipo_producto" name="id_subtipo_producto">
                                    <option value="">Seleccione...</option>';
            foreach ($datosTipoOperacion as $item) {
                $comboSubtipoProducto .= '<option value="' . $item['id_subtipo_producto'] . '">' . $item['nombre_subtipo_producto'] . '</option>';
            }
            $comboSubtipoProducto .= '</select>';
            $validacion = 'Exito';
            $resultado = $comboSubtipoProducto;
        } else {
            $validacion = 'Fallo';
            $mensaje = 'El operador no posee subtipos de productos con requisitos en el área seleccionada.';
        }

        echo json_encode(array(
            'validacion' => $validacion,
            'mensaje' => $mensaje,
            'resultado' => $resultado
        ));
    }

    /**
     * Método para obtener los productos
     */
    public function obtenerProductoPorArea()
    {
        $validacion = "";
        $mensaje = "";
        $resultado = "";
        $comboProducto = "";

        $idPaisDestino = $_POST["idPaisDestino"];
        $idArea = $_POST["idArea"];
        $idSubtipoProducto = $_POST["idSubtipoProducto"];

        $arrayParametros = [
            'idPaisDestino' => $idPaisDestino,
            'idArea' => $idArea,
            'idSubtipoProducto' => $idSubtipoProducto
        ];

        $datosTipoOperacion = $this->lNegocioInspeccionFitosanitaria->obtenerProductoPorAreaPorRequisitos($arrayParametros);

        if ($datosTipoOperacion->count()) {
            $comboProducto .= '<select id="id_subtipo_producto" name="id_subtipo_producto">
                                    <option value="">Seleccione...</option>';
            foreach ($datosTipoOperacion as $item) {
                $comboProducto .= '<option value="' . $item['id_producto'] . '">' . $item['nombre_producto'] . '</option>';
            }
            $comboProducto .= '</select>';
            $validacion = 'Exito';
            $resultado = $comboProducto;
        } else {
            $validacion = 'Fallo';
            $mensaje = 'El operador no posee productos con requisitos en el área seleccionada.';
        }

        echo json_encode(array(
            'validacion' => $validacion,
            'mensaje' => $mensaje,
            'resultado' => $resultado
        ));
    }

    /**
     * Método para validar el lugar de inspeccion
     */
    public function buscarLugarInspeccionFitosanitaria()
    {
        $validacion = "";
        $mensaje = "";
        $resultado = "";
        $nombreProducto = "";
        $banderaMostrarDatosLugar = false;
        $arrayMostrarDatosLugar = array();
        $arrayProductosSolicitud = array();
        $arrayProductosLugarInspeccion = array();

        $idInspeccionFitosanitaria = $_POST['id_inspeccion_fitosanitaria'];
        $idPaisDestino = $_POST['id_pais_destino'];
        $tipoLugarInspeccion = $_POST['tipo_lugar_inspeccion'];
        $codigoLugarInspeccion = $_POST['codigo_lugar_inspeccion'];

        if ($_POST['tipo_lugar_inspeccion'] == 'ACO'){
            $tipo_lugar_inspeccion = "('SVACO','SVCON')";
        }else{
            $tipo_lugar_inspeccion = "('SV" . $tipoLugarInspeccion . "')";
        }

        $datosLugarInspeccion = [
            'tipo_lugar_inspeccion' => $tipo_lugar_inspeccion,
            'codigo_lugar_inspeccion' => $codigoLugarInspeccion
        ];

        // Se valida que el centro de acopio sea del tipo de operacion seleccionada y trae los productos
        $qProductosLugarInspeccion = $this->lNegocioOperaciones->buscarOperacionPorCodigoAreaPorTipoOperacion($datosLugarInspeccion);

        if ($qProductosLugarInspeccion->count()) {

            $qProductosSolicitud = $this->lNegocioProductosInspeccionFitosanitaria->buscarLista(array(
                'id_inspeccion_fitosanitaria' => $idInspeccionFitosanitaria
            ));
            
            foreach ($qProductosSolicitud as $productosSolicitud) {
                $arrayProductosSolicitud[] = $productosSolicitud['id_producto'];
            }
            
            foreach ($qProductosLugarInspeccion as $productosLugarInspeccion) {
                $arrayProductosLugarInspeccion[] = $productosLugarInspeccion['id_producto'];
            }
            
            $resultadoProdutos = array_diff($arrayProductosSolicitud, $arrayProductosLugarInspeccion);
            
            // Valida si el lugar de inspeccion posee todos los productos de la solicitud
            if (! $resultadoProdutos) {
                
                //echo "poseeeee";                
                
                //Recorro los productos
                foreach ($arrayProductosSolicitud as $productosValidar) {
                                                           
                    //echo "producto:" . $productosValidar . '<br/>';
                    
                    $idAreaLugarInspeccion = $productosLugarInspeccion['id_area'];
                    $idTipoOperacionLugarInspeccion = $productosLugarInspeccion['id_tipo_operacion'];
                    
                    $datosValidarProtocolo = [
                        'id_localizacion' => $idPaisDestino,
                        'id_producto' => $productosValidar
                    ];
                    
                    //Verifico si cada uno de los productos posee protocolos al pais seleccionado 
                    $qProtocolosProductoPais = $this->lNegocioInspeccionFitosanitaria->validarProtocoloPorProductoPorPais($datosValidarProtocolo);
                    
                    if ($qProtocolosProductoPais->count()) {
                        
                        $protocoloProductoPais = array();
                        //echo "SI POSEE PROTOCOLOS";
                                                
                        $protocoloProductoPais = explode(",", $qProtocolosProductoPais->current()->protocolo_producto_pais);
                        
                        $datosProtocolosAsignados = [
                            'id_area' => $idAreaLugarInspeccion,
                            'id_tipo_operacion' => $idTipoOperacionLugarInspeccion
                        ];
                        
                        //Verifico que el area tenga inspecciones de protocolo aprobadas
                        $qProtocolosAreasAsignados = $this->lNegocioInspeccionFitosanitaria->obtenerProtocolosAreasAsignados($datosProtocolosAsignados);
                        
                        if ($qProtocolosAreasAsignados->count()) {
                            
                            $protocoloAreaAsignado = array();
                            
                            $protocoloAreaAsignado = explode(",", $qProtocolosAreasAsignados->current()->protocolo_area);
                            
                            $resultadoInspeccionProtocolos = array_diff($protocoloProductoPais, $protocoloAreaAsignado);
                            
                            if (! $resultadoInspeccionProtocolos) {                                
                                $banderaMostrarDatosLugar = true;
                                $arrayMostrarDatosLugar[] = $banderaMostrarDatosLugar; //echo "TODO CHEVERE";
                            } else {
                                $banderaMostrarDatosLugar = false;
                                $arrayMostrarDatosLugar[] = $banderaMostrarDatosLugar;
                                $validacion = 'Fallo';
                                $mensaje = 'El código del área no posee inspecciones de protocolo aprobadas o en implementación.';
                            }
                        } else {
                            $banderaMostrarDatosLugar = false;
                            $arrayMostrarDatosLugar[] = $banderaMostrarDatosLugar;
                            $validacion = 'Fallo';
                            $mensaje = 'El código del área no posee inspecciones de protocolo aprobadas o en implementación.';
                        }
                    } else {
                        //echo "No existen configurados protocolos registrados al pais, se muestra el area";
                        $banderaMostrarDatosLugar = true;
                        $arrayMostrarDatosLugar[] = $banderaMostrarDatosLugar;
                    }
                    
                }
                
            }else{
                //echo "NO posee los productos";
               
                foreach ($resultadoProdutos as $productos) {
                    $qDatosProducto = $this->lNegocioProductos->buscar($productos);
                    $nombreProducto .= trim($qDatosProducto->getNombreComun(), ',');
                }
                                
                $banderaMostrarDatosLugar = false;
                $arrayMostrarDatosLugar[] = $banderaMostrarDatosLugar;
                $validacion = 'Fallo';
                $mensaje = 'El área no posee los productos seleccionados en la solicitud, ' . $nombreProducto . '.';
            }
            
            $arrayMostrarDatosLugar = array_unique($arrayMostrarDatosLugar);
            
            if (count($arrayMostrarDatosLugar) > 1) {
                $banderaMostrarDatosLugar = false;
            } else {
                if ($arrayMostrarDatosLugar[0] == true) {
                    $banderaMostrarDatosLugar = true;
                } else {
                    $banderaMostrarDatosLugar = false;
                }
            }
            
            if ($banderaMostrarDatosLugar) {
                
                $identificadorOperador = $productosLugarInspeccion['identificador_operador'];
                $nombreOperador = $productosLugarInspeccion['nombre_operador'];
                $idSitio = $productosLugarInspeccion['id_sitio'];
                $nombreSitio = $productosLugarInspeccion['nombre_sitio'];
                $nombreProvinciaCanton = $productosLugarInspeccion['nombre_provincia_canton'];
                $latitud = $productosLugarInspeccion['latitud'];
                $longitud = $productosLugarInspeccion['longitud'];
                $direccionSitio = $productosLugarInspeccion['direccion'];
                $idArea = $productosLugarInspeccion['id_area'];
                $nombreArea = $productosLugarInspeccion['nombre_area'];
                $codigoArea = $productosLugarInspeccion['codigo_area'];
                $validacion = 'Exito';
                
                $resultado = [
                    'identificadorProductor' => $identificadorOperador,
                    'nombreOperador' => $nombreOperador,
                    'idSitio' => $idSitio,
                    'nombreSitio' => $nombreSitio,
                    'direccionSitio' => $direccionSitio,
                    'nombreProvinciaCanton' => $nombreProvinciaCanton,
                    'latitud' => $latitud,
                    'longitud' => $longitud,
                    'idArea' => $idArea,
                    'nombreArea' => $nombreArea,
                    'codigoArea' => $codigoArea
                ];
            }    
            
        } else {

            $validacion = 'Fallo';
            $mensaje .= 'El código del área no correspondea un lugar de inspección seleccionado.';
        }

        echo json_encode(array(
            'validacion' => $validacion,
            'mensaje' => $mensaje,
            'resultado' => $resultado
        ));
    }
    
    /**
     * Método para registrar en la base de datos - el encio de la solicitud
     */
    public function enviarSolicitud()
    {
        
        $estado = null;
        $banderaLugarInspeccion = true;
        $banderaProvinciaInspeccion = true;
        $idInspeccionFitosanitaria = $_POST['id_inspeccion_fitosanitaria'];
        $tipoSolicitud = $_POST['tipo_solicitud'];
        $lotesProducto = $_POST['lotes_producto'];
        $codigoLugarInspeccion = isset($_POST['codigo_lugar_inspeccion']) ? $_POST['codigo_lugar_inspeccion'] : $banderaLugarInspeccion = false;
        $idProvinciaInspeccion = isset($_POST['id_provincia_inspeccion']) ? $_POST['id_provincia_inspeccion'] : $banderaProvinciaInspeccion = false;
        $observacionLugarInspeccion = $_POST['observacion_lugar_inspeccion'];
        $estadoActual = $_POST['estado_inspeccion_fitosanitaria'];
        $tipoArea = $_POST['id_area'];
        
        if($estadoActual === "Creado"){
            $estado = "Enviado";
        }
        
        if($estadoActual === "Subsanacion"){
            $estado = "Subsanado";            
        }
                
        $datosLugarInspeccion = ['id_inspeccion_fitosanitaria' => $idInspeccionFitosanitaria
        	, 'tipo_solicitud' => $tipoSolicitud
        	, 'lotes_producto' => $lotesProducto
            , 'observacion' => $observacionLugarInspeccion
            , 'estado_anterior_inspeccion_fitosanitaria' => $estadoActual
            , 'estado_inspeccion_fitosanitaria' => $estado
        ];                
        
        if(isset($_POST['fecha_lugar_inspeccion'])){
            $fechaLugarInspeccion = $_POST['fecha_lugar_inspeccion'];
            $horaLugarInspeccion = $_POST['hora_lugar_inspeccion'];
            $datosLugarInspeccion += ['fecha_inspeccion' => $fechaLugarInspeccion];
            $datosLugarInspeccion += ['hora_inspeccion' => $horaLugarInspeccion];
        }
        
        if($banderaLugarInspeccion && !$banderaProvinciaInspeccion){
            $qDatosLugarInspeccion = $this->lNegocioOperaciones->buscarDatosSitioAreaPorCodigoArea(array('codigo_lugar_inspeccion' => $codigoLugarInspeccion));
            $idArea = $qDatosLugarInspeccion->current()->id_area;
            $nombreArea = $qDatosLugarInspeccion->current()->nombre_area;
            $direccionArea = $qDatosLugarInspeccion->current()->direccion_area;
            $codigoArea = $qDatosLugarInspeccion->current()->codigo_area;
            $idProvinciaArea = $qDatosLugarInspeccion->current()->id_provincia_area;
            $nombreProvinciaArea = $qDatosLugarInspeccion->current()->nombre_provincia_area;
            $latitudLugarInspeccion = $_POST['latitud_lugar_inspeccion'];
            $longitudLugarInspeccion = $_POST['longitud_lugar_inspeccion'];

            $datosLugarInspeccion += ['tipo_area' => $tipoArea];
            $datosLugarInspeccion += ['id_area' => $idArea];
            $datosLugarInspeccion += ['nombre_area' => $nombreArea];
            $datosLugarInspeccion += ['direccion_area' => $direccionArea];
            $datosLugarInspeccion += ['codigo_area'=> $codigoArea];
            $datosLugarInspeccion += ['id_provincia_area' => $idProvinciaArea];
            $datosLugarInspeccion += ['nombre_provincia_area' => $nombreProvinciaArea];            
            $datosLugarInspeccion += ['latitud' => $latitudLugarInspeccion];
            $datosLugarInspeccion += ['longitud' => $longitudLugarInspeccion];
            
        }else{
        	
        	if($banderaProvinciaInspeccion){
        		
        		$nombreArea =  $_POST['nombre_lugar_inspeccion'];
        		$direccionArea = $_POST['direccion_lugar_inspeccion'];
        		$codigoArea = $_POST['codigo_lugar_inspeccion'];
        		
        		$idProvinciaInspeccion = $idProvinciaInspeccion;       		
        		$qDatosProvincia = $this->lNegocioLocalizacion->buscar($idProvinciaInspeccion);
        		$nombreProvincia = $qDatosProvincia->getNombre();
        		$idProvincia = str_pad((int)$qDatosProvincia->getCodigoVue(), 2, '0', STR_PAD_LEFT);
        		
        		$latitudLugarInspeccion = $_POST['latitud_lugar_inspeccion'];
        		$longitudLugarInspeccion = $_POST['longitud_lugar_inspeccion'];
        		
        		$datosLugarInspeccion += ['tipo_area' => $tipoArea];
        		$datosLugarInspeccion += ['id_area' => null];
        		$datosLugarInspeccion += ['nombre_area' => $nombreArea];
        		$datosLugarInspeccion += ['direccion_area' => $direccionArea];
        		$datosLugarInspeccion += ['codigo_area'=> $codigoArea];
        		$datosLugarInspeccion += ['id_provincia_area' => $idProvincia];
        		$datosLugarInspeccion += ['nombre_provincia_area' => $nombreProvincia];
        		$datosLugarInspeccion += ['latitud' => $latitudLugarInspeccion];
        		$datosLugarInspeccion += ['longitud' => $longitudLugarInspeccion];
        		
        	}else{
        	
	            $qPuertoEmbarque = $this->lNegocioInspeccionFitosanitaria->buscar($idInspeccionFitosanitaria);
	            $idPuertoEmbarque = $qPuertoEmbarque->getIdPuertoEmbarque();
	            
	            $qDatosPuerto = $this->lNegocioPuertos->buscar($idPuertoEmbarque);
	            $idProvinciaPuerto = $qDatosPuerto->getIdProvincia();
	            
	            $qDatosProvincia = $this->lNegocioLocalizacion->buscar($idProvinciaPuerto);
	            $nombreProvincia = $qDatosProvincia->getNombre();
	            $idProvincia = str_pad((int)$qDatosProvincia->getCodigoVue(), 2, '0', STR_PAD_LEFT);
	            
	            $datosLugarInspeccion += ['tipo_area' => $tipoArea];
	            $datosLugarInspeccion += ['id_area' => null];
	            $datosLugarInspeccion += ['nombre_area' => null];
	            $datosLugarInspeccion += ['direccion_area' => null];
	            $datosLugarInspeccion += ['codigo_area'=> null];
	            $datosLugarInspeccion += ['id_provincia_area' => $idProvincia];
	            $datosLugarInspeccion += ['nombre_provincia_area' => $nombreProvincia];
	            $datosLugarInspeccion += ['latitud' => null];
	            $datosLugarInspeccion += ['longitud' => null];
	            
        	}
        	
        }
        
        $idInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->guardarEnviarSolicitud($datosLugarInspeccion);

        if(isset($idInspeccionFitosanitaria)){                   
            Mensajes::exito(Constantes::GUARDADO_CON_EXITO);        
        }
        
    }
    
    /**
     * Desplegar la lista de solicitudes de inspeccion fitosanitaria
     */
    public function listarRegistroSolicitudesInspeccionFitosanitaria()
    {
        $estado = 'EXITO';
        $mensaje = '';

        $identificadorOperador = $this->usuarioActivo();
        $fechaActual = date('Y-m-d');
        $idPaisDestino = (isset($_POST['b_id_pais_destino'])) ? $_POST['b_id_pais_destino'] : '';
        $numeroSolicitud = (isset($_POST['b_numero_solicitud'])) ? $_POST['b_numero_solicitud'] : '';
        $idProducto = (isset($_POST['b_producto'])) ? $_POST['b_producto'] : '';
        $estadoSolicitud = (!empty($_POST['b_estado'])) ? "'" . $_POST['b_estado'] ."'" : '';
        $fechaInicio = (isset($_POST['b_fecha_inicio'])) ? $_POST['b_fecha_inicio'] : $fechaActual;
        $fechaFin = (isset($_POST['b_fecha_fin'])) ? $_POST['b_fecha_fin'] : $fechaActual;

        $arrayParametros = ['idPaisDestino' => $idPaisDestino
                            , 'tipoSolicitud' => null
        					, 'numeroSolicitud' => $numeroSolicitud
                            , 'idProducto' => $idProducto
                            , 'identificadorSolicitante' => $identificadorOperador
                            , 'estadoSolicitud' => $estadoSolicitud
                            , 'fechaInicio' => $fechaInicio
                            , 'fechaFin' => $fechaFin
                            , 'nombreProvincia' => null                
                            ];
                
        $modeloInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscarFiltroSolicitudesInspeccionFitosanitaria($arrayParametros);
        
        if ($modeloInspeccionFitosanitaria->count() == 0) {
            $estado = 'FALLO';
            $mensaje = 'No existen registros para la búsqueda.';
        }
        
        $this->tablaHtmlInspeccionFitosanitaria($modeloInspeccionFitosanitaria);
        $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
        echo json_encode(array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'contenido' => $contenido)
            );
        
    }
    
    /**
     * Método de inicio del controlador
     */
    public function revisionEstadoSolicitud()
    {
                
        $this->cargarPanelSolicitudesRevisionEstadoSolicitud();                
        
        $fechaActual =  date('Y-m-d');
        
        $condicion = " ORDER BY fecha_creacion DESC";
        $arrayParametros = ['idPaisDestino' => null
                            , 'tipoSolicitud' => null
                        	, 'numeroSolicitud' => null
                            , 'idProducto' => null
                        	, 'identificadorSolicitante' => null
                        	, 'estadoSolicitud' => null
                            , 'fechaInicio' => $fechaActual
                            , 'fechaFin' => $fechaActual
                        	, 'nombreProvincia' => null            
                            ];
        
        $modeloInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscarFiltroSolicitudesInspeccionFitosanitaria($arrayParametros, $condicion);
        $this->tablaHtmlRevisionEstadoInspeccionFitosanitaria($modeloInspeccionFitosanitaria);
        require APP . 'InspeccionFitosanitaria/vistas/listaRevisionEstadoInspeccionFitosanitariaVista.php';
    }
    
    /**
     * Desplegar la lista de solicitudes de inspeccion fitosanitaria
     */
    public function listarEstadoRegistroSolicitudesInspeccionFitosanitaria()
    {
        $estado = 'EXITO';
        $mensaje = '';        
        
        $fechaActual =  date('Y-m-d');
        $idPaisDestino = (isset($_POST['b_id_pais_destino'])) ? $_POST['b_id_pais_destino'] : '';
        $numeroSolicitud = (isset($_POST['b_numero_solicitud'])) ? $_POST['b_numero_solicitud'] : '';
        $idProducto = (isset($_POST['b_producto'])) ? $_POST['b_producto'] : '';
        $estadoSolicitud = (!empty($_POST['b_estado'])) ? "'" . $_POST['b_estado'] ."'" : '';
        $identificadorOperador = (isset($_POST['b_identificador_operador'])) ? $_POST['b_identificador_operador'] : '';
        $fechaInicio = (isset($_POST['b_fecha_inicio'])) ? $_POST['b_fecha_inicio'] : $fechaActual;
        $fechaFin = (isset($_POST['b_fecha_fin'])) ? $_POST['b_fecha_fin'] : $fechaActual;
        
        $condicion = " order by fecha_creacion DESC";
        $arrayParametros = ['idPaisDestino' => $idPaisDestino
                            , 'tipoSolicitud' => null
                        	, 'numeroSolicitud' => $numeroSolicitud
                            , 'idProducto' => $idProducto
                            , 'identificadorSolicitante' => $identificadorOperador
                            , 'estadoSolicitud' => $estadoSolicitud
                            , 'fechaInicio' => $fechaInicio
                            , 'fechaFin' => $fechaFin
                            , 'nombreProvincia' => null            
                            ];           
        
        $modeloInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscarFiltroSolicitudesInspeccionFitosanitaria($arrayParametros, $condicion);
        
        if ($modeloInspeccionFitosanitaria->count() == 0) {
            $estado = 'FALLO';
            $mensaje = 'No existen registros para la búsqueda.';
        }
        
        $this->tablaHtmlRevisionEstadoInspeccionFitosanitaria($modeloInspeccionFitosanitaria);
        $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
        echo json_encode(array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'contenido' => $contenido)
            );
        
    }
    
    /**
     * Construye el código HTML para desplegar la lista de - InspeccionFitosanitaria
     */
    public function tablaHtmlRevisionEstadoInspeccionFitosanitaria($tabla)
    {
        {
            $contador = 0;
            foreach ($tabla as $fila) {
                $this->itemsFiltrados[] = array(
                    '<tr id="' . $fila['id_inspeccion_fitosanitaria'] . '"
                    class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'InspeccionFitosanitaria\InspeccionFitosanitaria"
                    data-opcion="abrirRevisionEstadoSolicitud" ondragstart="drag(event)" draggable="true"
                    data-destino="detalleItem">
                    <td>' . ++ $contador . '</td>
                    <td style="white - space:nowrap; "><b>' . $fila['numero_solicitud'] . '</b></td>
                    <td>' . $fila['nombre_operador'] . '</td>
                    <td>' . $fila['estado_inspeccion_fitosanitaria'] . '</td>
                    <td>' . $fila['nombre_pais_destino'] . '</td>
                    <td>' . $fila['nombre_provincia_area'] . '</td>
                    <td>' . date('Y-m-d H:i', strtotime($fila['fecha_creacion'])) . '</td>
                    </tr>'
                );
            }
        }
    }
    
    /**
     * Obtenemos los datos del registro seleccionado para editar - Tabla: InspeccionFitosanitaria
     */
    public function abrirRevisionEstadoSolicitud()
    {
        $idInspeccionFitosanitaria = $_POST["id"];
        
        $this->accion = "Editar InspeccionFitosanitaria";
        $this->modeloInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscar($idInspeccionFitosanitaria);
        $identificadorOperador = $this->modeloInspeccionFitosanitaria->getIdentificadorSolicitante();
        $estado = $this->modeloInspeccionFitosanitaria->getEstadoInspeccionFitosanitaria();
        
        $this->datosOperador = $this->construirDetalleOperadorRevision($identificadorOperador);
        $this->datosExportacion = $this->construirDetalleDatosExportacionRevisarEstado();
        $this->datosRevision = $this->construirDatosRevision($idInspeccionFitosanitaria);
        $this->datosProductoresAgregados = $this->construirProductoresAgregados($idInspeccionFitosanitaria, $estado);
        $this->datosInspeccion = $this->construirDatosLugarInspeccion($idInspeccionFitosanitaria, null);
        
        require APP . 'InspeccionFitosanitaria/vistas/formularioEditarInspeccionFitosanitariaVista.php';
    }

    /**
     * Método para construir los datos de exportacion
     */
    public function construirDetalleDatosExportacionRevisarEstado()
    {
        $datos = '';
        $numeroSolicitud = '';
        
        $idTipoProduccion = $this->modeloInspeccionFitosanitaria->getIdTipoProduccion();
        $qTipoProduccion = $this->lNegocioTiposProduccionFitosanitarias->buscar($idTipoProduccion);
        $nombreTipoProduccion = $qTipoProduccion->getNombreTipoProduccionFitosanitaria();
        
        if($this->modeloInspeccionFitosanitaria->getNumeroSolicitud()){
            $numeroSolicitud = '<div data-linea="1">
                            <label>Número de solicitud: </label>'
                . $this->modeloInspeccionFitosanitaria->getNumeroSolicitud() .
                '</div>';
        }

        $datos .= $numeroSolicitud . '<div data-linea="2">
                    <label>Puerto de embarque: </label>
                    ' . $this->modeloInspeccionFitosanitaria->getNombrePuertoEmbarque() . '
                    </div>
                    <div data-linea="3">
                        <label>País destino: </label>
                        ' . $this->modeloInspeccionFitosanitaria->getNombrePaisDestino() . '
                    </div>
                    <div data-linea="4">
                        <label>Tipo de producción: </label>
                        ' . $nombreTipoProduccion . '
                    <div data-linea="5">
                    <label>Lote de exp.: </label>' . $this->modeloInspeccionFitosanitaria->getLotesProducto() . '
                    </div>';

        return '<fieldset>
           <legend>Datos de exportación</legend>' . $datos . '</fieldset>';
    }
    
    /**
     * Funcion que crea el combo de provincia
     */
    public function comboProvinciaInspeccion()
    {    	
    	$validacion = 'Exito';
    	$mensaje = "";
    	$resultado = "";
    	$comboProvincia = "";
    	$tipoArea = $_POST['tipoArea'];
    	
    	if($tipoArea === "PRO"){    	
    		$comboProvincia = '<label id="lid_provincia_inspeccion">Provincia: </label><select id="id_provincia_inspeccion" name="id_provincia_inspeccion" class="validacion">
    						<option value="">Seleccione...</option>'
							  . $this->comboProvinciasEc() .
							'</select>';    	
    	}
    	
		$resultado = $comboProvincia;
    	
		echo json_encode(array(
			'validacion' => $validacion,
			'mensaje' => $mensaje,
			'resultado' => $resultado
		));
		
    }
    
}
