<?php
/**
 * Controlador RevisionInspeccionFitosanitaria
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
use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;
use Agrodb\Catalogos\Modelos\TiposProduccionFitosanitariasLogicaNegocio;
use Agrodb\Catalogos\Modelos\PuertosLogicaNegocio;
use Agrodb\Catalogos\Modelos\LocalizacionLogicaNegocio;
use Agrodb\RegistroOperador\Modelos\OperadoresLogicaNegocio;

class RevisionInspeccionFitosanitariaControlador extends BaseControlador
{

    private $lNegocioInspeccionFitosanitaria = null;

    private $modeloInspeccionFitosanitaria = null;
    
    private $lNegocioTiposProduccionFitosanitarias = null;
    
    private $lNegocioPuertos = null;
    
    private $lNegocioLocalizacion = null;
    
    private $lNegocioOperadoradores = null;

    private $accion = null;
    
    private $datosConfirmacion = null;
    
    private $datosInspeccion = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioInspeccionFitosanitaria = new InspeccionFitosanitariaLogicaNegocio();
        $this->modeloInspeccionFitosanitaria = new InspeccionFitosanitariaModelo();
        $this->lNegocioTiposProduccionFitosanitarias = new TiposProduccionFitosanitariasLogicaNegocio();
        $this->lNegocioPuertos = new PuertosLogicaNegocio();
        $this->lNegocioLocalizacion = new LocalizacionLogicaNegocio();
        $this->lNegocioOperadoradores = new OperadoresLogicaNegocio();
        set_exception_handler(array(
            $this,
            'manejadorExcepciones'
        ));
    }

    /**
     * Método de inicio del controlador
     */
    public function confirmarInspeccion()
    {
        
        $fechaActual =  date('Y-m-d');
        $identificador = $this->usuarioActivo();
        $usuarioIterno = $this->usuarioInterno;
        $nombreProvincia = "";
        $tipoSolicitud = "";
        
        $esInspector = $this->obtenerPerfilInspectorFitosanitario($identificador);
        
        if($esInspector){
            if($usuarioIterno){
                $nombreProvincia = $this->nombreProvincia;
                $tipoSolicitud = "'musaceas', 'otros'";
            }else{
                $obtenerProvinciaOperador = $this->lNegocioOperadoradores->buscarLista(array('identificador' => $identificador));
                $nombreProvincia = $obtenerProvinciaOperador->current()->provincia;
                $tipoSolicitud = "'musaceas'";
            }
        }

        $this->cargarPanelSolicitudes($esInspector);
        
        $arrayParametros = ['idPaisDestino' => null
                            , 'tipoSolicitud' => $tipoSolicitud
        					, 'numeroSolicitud' => null
                            , 'idProducto' => null
                            , 'identificadorSolicitante' => null
                            , 'estadoSolicitud' => "'Enviado', 'Confirmado'"
                            , 'fechaInicio' => $fechaActual
                            , 'fechaFin' => $fechaActual
                            , 'nombreProvincia' => $nombreProvincia
                            , 'identificadorSolicitante' => null
                            ];

        $modeloInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscarFiltroSolicitudesInspeccionFitosanitariaSinConsumir($arrayParametros);
        $this->tablaHtmlConfirmarInspeccionFitosanitaria($modeloInspeccionFitosanitaria);
        require APP . 'InspeccionFitosanitaria/vistas/listaConfirmarInspeccionFitosanitariaVista.php';
    }
    
    /**
     * Método de inicio del controlador
     */
    public function atenderInspeccion()
    {
        
        $fechaActual =  date('Y-m-d');
        $identificador = $this->usuarioActivo();
        $usuarioIterno = $this->usuarioInterno;
        $nombreProvincia = "";
        $tipoSolicitud = "";
        
        $esInspector = $this->obtenerPerfilInspectorFitosanitario($identificador);
        
        if($esInspector){
            if($usuarioIterno){
                $nombreProvincia = $this->nombreProvincia;
                $tipoSolicitud = "'musaceas', 'otros'";
            }else{
                $obtenerProvinciaOperador = $this->lNegocioOperadoradores->buscarLista(array('identificador' => $identificador));
                $nombreProvincia = $obtenerProvinciaOperador->current()->provincia;
                $tipoSolicitud = "'musaceas'";
            }            
        }
        
        $this->cargarPanelSolicitudes($esInspector);
        
        $arrayParametros = ['idPaisDestino' => null
                            , 'tipoSolicitud' => $tipoSolicitud
				        	, 'numeroSolicitud' => null
                            , 'idProducto' => null
				            , 'identificadorSolicitante' => null
				            , 'estadoSolicitud' => "'Confirmado', 'Subsanado'"
                            , 'fechaInicio' => $fechaActual
                            , 'fechaFin' => $fechaActual
				            , 'nombreProvincia' => $nombreProvincia
				            , 'identificadorSolicitante' => null
				            ];
    
        $modeloInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscarFiltroSolicitudesInspeccionFitosanitaria($arrayParametros);
        $this->tablaHtmlInspeccionFitosanitaria($modeloInspeccionFitosanitaria);
        require APP . 'InspeccionFitosanitaria/vistas/listaAtenderInspeccionFitosanitariaVista.php';
    }

    /**
     * Método para registrar en la base de datos -InspeccionFitosanitaria
     */
    public function guardarConfirmarInspeccion()
    {
        
        $idInspeccionFitosanitaria = $_POST['id_inspeccion_fitosanitaria'];
        
        $verificarUsoInspeccion = $this->lNegocioInspeccionFitosanitaria->verificarUsoInspeccionFitosanitaria($idInspeccionFitosanitaria);
        
        if($verificarUsoInspeccion->count()){
                        
            Mensajes::fallo(Constantes::ERROR_INSPECCION_USADA);            
            
        }else{
            
            $qDatosInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscar($_POST['id_inspeccion_fitosanitaria']);
            $estadoActual = $qDatosInspeccionFitosanitaria->getEstadoInspeccionFitosanitaria();
            
            $_POST['estado_anterior_inspeccion_fitosanitaria'] = $estadoActual;
            $_POST['identificador_revisor'] = $this->usuarioActivo();
            $_POST['estado_inspeccion_fitosanitaria'] = 'Confirmado';
            $this->lNegocioInspeccionFitosanitaria->guardarConfirmarInspeccion($_POST);
            
            Mensajes::exito(Constantes::GUARDADO_CON_EXITO);
            
        }        
        
    }
    
    /**
     * Método para registrar en la base de datos -InspeccionFitosanitaria
     */
    public function guardarAtenderInspeccion()
    {
        
        $idInspeccionFitosanitaria = $_POST['id_inspeccion_fitosanitaria'];
        
        $qDatosInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscar($idInspeccionFitosanitaria);
        $estadoActual = $qDatosInspeccionFitosanitaria->getEstadoInspeccionFitosanitaria();
        
        $_POST['estado_anterior_inspeccion_fitosanitaria'] = $estadoActual;        
        $_POST['identificador_revisor'] = $this->usuarioActivo();
        $_POST['array_productos_inspeccion'] = json_decode($_POST['array_productos_inspeccion'], true);
        $this->lNegocioInspeccionFitosanitaria->guardarAtenderInspeccion($_POST);
        
        Mensajes::exito(Constantes::GUARDADO_CON_EXITO);
       
    }

    /**
     * Obtenemos los datos del registro seleccionado para editar - Tabla: InspeccionFitosanitaria
     */
    public function abrirConfirmarInspeccion()
    {
        $this->accion = "Confirmar inspección";
        $this->modeloInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscar($_POST["id"]);
        $estado = $this->modeloInspeccionFitosanitaria->getEstadoInspeccionFitosanitaria();
        $identificadorOperador = $this->modeloInspeccionFitosanitaria->getIdentificadorSolicitante();

        $controladorInspeccionFitosanitaria = new InspeccionFitosanitariaControlador();
        
        $this->datosOperador = $this->construirDetalleOperadorRevision($identificadorOperador);
        $this->datosExportacion = $this->construirDetalleDatosExportacion();
        $this->datosProductoresAgregados = $controladorInspeccionFitosanitaria->construirProductoresAgregados($_POST["id"], $estado);
        $this->datosConfirmacion = $this->construirDatosResultadoConfirmarInspeccion();

        require APP . 'InspeccionFitosanitaria/vistas/formularioConfirmarInspeccionFitosanitariaVista.php';
    }
    
    /**
     * Obtenemos los datos del registro seleccionado para editar - Tabla: InspeccionFitosanitaria
     */
    public function abrirAtenderInspeccion()
    {
        $this->accion = "Atender inspección";
        $this->modeloInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscar($_POST["id"]);
        $estado = $this->modeloInspeccionFitosanitaria->getEstadoInspeccionFitosanitaria();
        $identificadorOperador = $this->modeloInspeccionFitosanitaria->getIdentificadorSolicitante();
        
        $this->datosOperador = $this->construirDetalleOperadorRevision($identificadorOperador);
        $this->datosExportacion = $this->construirDetalleDatosExportacion();
        $this->datosProductoresAgregados = $this->construirProductoresAgregadosAtenderInspeccion($_POST["id"], $estado);
        $this->datosConfirmacion = $this->construirDatosResultadoConfirmarInspeccionAtender();
        $this->datosInspeccion = $this->construirDatosResultadoAtenderInspeccion();
        
        require APP . 'InspeccionFitosanitaria/vistas/formularioAtenderInspeccionFitosanitariaVista.php';
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
    public function tablaHtmlConfirmarInspeccionFitosanitaria($tabla)
    {
        {
            $contador = 0;
            foreach ($tabla as $fila) {
                $this->itemsFiltrados[] = array(
                    '<tr id="' . $fila['id_inspeccion_fitosanitaria'] . '"
                    class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'InspeccionFitosanitaria\RevisionInspeccionFitosanitaria"
                    data-opcion="abrirConfirmarInspeccion" ondragstart="drag(event)" draggable="true"
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
     * Construye el código HTML para desplegar la lista de - InspeccionFitosanitaria
     */
    public function tablaHtmlInspeccionFitosanitaria($tabla)
    {
        {
            $contador = 0;
            foreach ($tabla as $fila) {
                $this->itemsFiltrados[] = array(
                    '<tr id="' . $fila['id_inspeccion_fitosanitaria'] . '"
                    class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'InspeccionFitosanitaria\RevisionInspeccionFitosanitaria"
                    data-opcion="abrirAtenderInspeccion" ondragstart="drag(event)" draggable="true"
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
     * Desplegar la lista de solicitudes de confirmacion fitosanitaria
     */
    public function listarConfirmarSolicitudesInspeccionFitosanitaria()
    {
        $estado = 'EXITO';
        $mensaje = '';
        
        $fechaActual = date('Y-m-d');
        $identificador = $this->usuarioActivo();
        $usuarioIterno = $this->usuarioInterno;
        $nombreProvincia = "";
        $tipoSolicitud = "";
        $idPaisDestino = (isset($_POST['b_id_pais_destino'])) ? $_POST['b_id_pais_destino'] : '';
        $numeroSolicitud = (isset($_POST['b_numero_solicitud'])) ? $_POST['b_numero_solicitud'] : '';
        $idProducto = (isset($_POST['b_producto'])) ? $_POST['b_producto'] : '';
        $fechaInicio = (isset($_POST['b_fecha_inicio'])) ? $_POST['b_fecha_inicio'] : $fechaActual;
        $fechaFin = (isset($_POST['b_fecha_fin'])) ? $_POST['b_fecha_fin'] : $fechaActual;
         
        $esInspector = $this->obtenerPerfilInspectorFitosanitario($identificador);
        
        if($esInspector){
            if($usuarioIterno){
                $nombreProvincia = $this->nombreProvincia;
                $tipoSolicitud = "'musaceas', 'otros'";
                
            }else{
                $obtenerProvinciaOperador = $this->lNegocioOperadoradores->buscarLista(array('identificador' => $identificador));
                $nombreProvincia = $obtenerProvinciaOperador->current()->provincia;
                $tipoSolicitud = "'musaceas'";
            }            
        }
        
        $arrayParametros = ['idPaisDestino' => $idPaisDestino
                            , 'tipoSolicitud' => $tipoSolicitud
        					, 'numeroSolicitud' => $numeroSolicitud
                            , 'idProducto' => $idProducto
                            , 'identificadorSolicitante' => null
                            , 'estadoSolicitud' => "'Enviado', 'Confirmado'"
                            , 'fechaInicio' => $fechaInicio
                            , 'fechaFin' => $fechaFin
                            , 'nombreProvincia' => $nombreProvincia
                            , 'identificadorSolicitante' => null
                            ];
        
        $modeloInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscarFiltroSolicitudesInspeccionFitosanitariaSinConsumir($arrayParametros);
        
        if ($modeloInspeccionFitosanitaria->count() == 0) {
            $estado = 'FALLO';
            $mensaje = 'No existen registros para la búsqueda.';
        }
        
        $this->tablaHtmlConfirmarInspeccionFitosanitaria($modeloInspeccionFitosanitaria);
        $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
        echo json_encode(array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'contenido' => $contenido)
            );
        
    }
    
    /**
     * Desplegar la lista de solicitudes de confirmacion fitosanitaria
     */
    public function listarAtenderSolicitudesInspeccionFitosanitaria()
    {
        $estado = 'EXITO';
        $mensaje = '';        
        
        $fechaActual = date('Y-m-d');
        $identificador = $this->usuarioActivo();
        $usuarioIterno = $this->usuarioInterno;
        $nombreProvincia = "";
        $tipoSolicitud = "";
        $idPaisDestino = (isset($_POST['b_id_pais_destino'])) ? $_POST['b_id_pais_destino'] : '';
        $numeroSolicitud = (isset($_POST['b_numero_solicitud'])) ? $_POST['b_numero_solicitud'] : '';
        $idProducto = (isset($_POST['id_producto'])) ? $_POST['id_producto'] : '';
        $fechaInicio = (isset($_POST['b_fecha_inicio'])) ? $_POST['b_fecha_inicio'] : $fechaActual;
        $fechaFin = (isset($_POST['b_fecha_fin'])) ? $_POST['b_fecha_fin'] : $fechaActual;
                
        $esInspector = $this->obtenerPerfilInspectorFitosanitario($identificador);
        
        if($esInspector){
            if($usuarioIterno){
                $nombreProvincia = $this->nombreProvincia;
                $tipoSolicitud = "'musaceas', 'otros'";
            }else{
                $obtenerProvinciaOperador = $this->lNegocioOperadoradores->buscarLista(array('identificador' => $identificador));
                $nombreProvincia = $obtenerProvinciaOperador->current()->provincia;
                $tipoSolicitud = "'musaceas'";
            }            
        }
        
        $arrayParametros = ['idPaisDestino' => $idPaisDestino
                            , 'tipoSolicitud' => $tipoSolicitud
                        	, 'numeroSolicitud' => $numeroSolicitud
                            , 'idProducto' => $idProducto
                            , 'identificadorSolicitante' => null
                            , 'estadoSolicitud' => "'Confirmado', 'Subsanado'"
                            , 'fechaInicio' => $fechaInicio
                            , 'fechaFin' => $fechaFin
                            , 'nombreProvincia' => $nombreProvincia
                            , 'identificadorSolicitante' => null];
        
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
     * Método para construir los datos de exportacion
     */
    public function construirDetalleDatosExportacion()
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
    	
        $datos = '<fieldset>
                    <legend>Datos de exportación</legend>'
        			. $numeroSolicitud .
                    '<div data-linea="2">
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
                        <label>Lote de exp.: </label>' . $this->modeloInspeccionFitosanitaria->getLotesProducto() . '</div>
                    </fieldset>';

        return $datos;
    }

    /**
     * Método para construir los productores agregados
     */
    public function construirProductoresAgregadosAtenderInspeccion($idInspeccionFitosanitaria, $estado)
    {
        $productosInspeccionFitosanitaria = new ProductosInspeccionFitosanitariaControlador();
        $datos = $productosInspeccionFitosanitaria->crearProductoresAgregadosAtenderInspeccion($idInspeccionFitosanitaria);

        return $datos;
    }

    /**
     * Método para construir los datos del area a inspeccionar
     */
    public function construirDatosResultadoConfirmarInspeccion()
    {
    	$tipoArea = $this->modeloInspeccionFitosanitaria->getTipoArea();
    	$tipoLugarInspeccion = $this->construirLugarInspeccion($tipoArea);
    	
    	switch ($tipoArea){
    		case 'ACO':
    		case 'PRO':
			case 'AGE':
    			$codigoProvincia = $this->modeloInspeccionFitosanitaria->getIdProvinciaArea();
    			$codigoProvincia = str_pad($codigoProvincia, 3, "0", STR_PAD_LEFT);
    			$qDatosProvincia = $this->lNegocioLocalizacion->buscarLista(array('codigo_vue' => $codigoProvincia));
    			$idProvincia = $qDatosProvincia->current()->id_localizacion;
    			break;
    		case 'PUE':
    			$idPuertoEmbarque = $this->modeloInspeccionFitosanitaria->getIdPuertoEmbarque();
    			$qDatosPuerto = $this->lNegocioPuertos->buscar($idPuertoEmbarque);
    			$idProvincia = $qDatosPuerto->getIdProvincia();
    			break;
    	}
    	
    	$qDatosProvincia = $this->lNegocioLocalizacion->buscar($idProvincia);
    	$nombreProvincia = $qDatosProvincia->getNombre();
    	
        $datos = '<form id="formularioConfirmarInspeccion" data-rutaAplicacion="' . URL_MVC_FOLDER . 'InspeccionFitosanitaria" data-opcion="RevisionInspeccionFitosanitaria/guardarConfirmarInspeccion" data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
                <input type="hidden" id="id_inspeccion_fitosanitaria" name="id_inspeccion_fitosanitaria" value="' . $this->modeloInspeccionFitosanitaria->getIdInspeccionFitosanitaria() . '" readonly="readonly">
                <fieldset>
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
                    <div data-linea="3">
                	    <label>Nombre lugar: </label>' 
                	    . (($this->modeloInspeccionFitosanitaria->getNombreArea() == "") ? $this->modeloInspeccionFitosanitaria->getNombrePuertoEmbarque() : $this->modeloInspeccionFitosanitaria->getNombreArea()) . 
                	'</div>
                    <div data-linea="4">
                	    <label>Dirección: </label>' 
                	    . (($this->modeloInspeccionFitosanitaria->getNombreArea() == "") ? "N/A" : $this->modeloInspeccionFitosanitaria->getNombreArea()) . 
                	'</div>
                    <div data-linea="5">
                	    <label>Latitud: </label>' 
                	    . (($this->modeloInspeccionFitosanitaria->getLatitud() == "") ? "N/A" : $this->modeloInspeccionFitosanitaria->getLatitud()) . 
                	'</div>
                    <div data-linea="5">
                	    <label>Longitud: </label>' 
                	    . (($this->modeloInspeccionFitosanitaria->getLongitud() == "") ? "N/A" : $this->modeloInspeccionFitosanitaria->getLongitud()) . 
                    '</div>
                    <div data-linea="6">
                    <label>Observación: </label>' 
                        . $this->modeloInspeccionFitosanitaria->getObservacion() . '</div>
                    <div data-linea="7">
                	    <label>Fecha: </label>
                        <input type="text" id="fecha_inspeccion" name="fecha_inspeccion" value="' . $this->modeloInspeccionFitosanitaria->getFechaInspeccion() . '" class="validacion">
                    </div>
                    <div data-linea="7">
            	       <label>Hora: </label>
            	       <input type="text" id="hora_inspeccion" name="hora_inspeccion" value="' . date('H:i', strtotime($this->modeloInspeccionFitosanitaria->getHoraInspeccion())) . '" class="validacion" data-inputmask="' . "'mask': '99:99'" . '">
                    </div>
                    <div data-linea="8">
            	       <label>Observación técnica: </label>
            	       <input type="text" id="observacion_revisor" name="observacion_revisor" class="validacion" maxlength="1020">
                    </div>
                    </fieldset>
                    <div data-linea="1">
                    	<button type="submit" class="guardar">Confirmar</button>
                   	</div>
                    </form>';
        
        return $datos;
    }
    
    /**
     * Método para construir los datos del area a inspeccionar
     */
    public function construirDatosResultadoConfirmarInspeccionAtender()
    {
    	
    	$tipoArea = $this->modeloInspeccionFitosanitaria->getTipoArea();
    	$tipoLugarInspeccion = $this->construirLugarInspeccion($tipoArea);
    	
    	switch ($tipoArea){
    		case 'ACO':
    		case 'PRO':
			case 'AGE':
    			$codigoProvincia = $this->modeloInspeccionFitosanitaria->getIdProvinciaArea();
    			$codigoProvincia = str_pad($codigoProvincia, 3, "0", STR_PAD_LEFT);
    			$qDatosProvincia = $this->lNegocioLocalizacion->buscarLista(array('codigo_vue' => $codigoProvincia));
    			$idProvincia = $qDatosProvincia->current()->id_localizacion;
    			break;
    		case 'PUE':
    			$idPuertoEmbarque = $this->modeloInspeccionFitosanitaria->getIdPuertoEmbarque();
    			$qDatosPuerto = $this->lNegocioPuertos->buscar($idPuertoEmbarque);
    			$idProvincia = $qDatosPuerto->getIdProvincia();
    			break;
    	}
    	
    	$qDatosProvincia = $this->lNegocioLocalizacion->buscar($idProvincia);
    	$nombreProvincia = $qDatosProvincia->getNombre();
    	
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
                    <div data-linea="3">
                	    <label>Nombre lugar: </label>' 
                	    . (($this->modeloInspeccionFitosanitaria->getNombreArea() == "") ? $this->modeloInspeccionFitosanitaria->getNombrePuertoEmbarque() : $this->modeloInspeccionFitosanitaria->getNombreArea()) . 
                	'</div>
                    <div data-linea="4">
                	    <label>Dirección: </label>' 
                	    . (($this->modeloInspeccionFitosanitaria->getNombreArea() == "") ? "N/A" : $this->modeloInspeccionFitosanitaria->getNombreArea()) . 
                	'</div>
                    <div data-linea="5">
                	    <label>Latitud: </label>' 
                	    . $this->modeloInspeccionFitosanitaria->getLatitud() . 
                	'</div>
                    <div data-linea="5">
                	    <label>Longitud: </label>' 
                	    . $this->modeloInspeccionFitosanitaria->getLongitud() . 
                	'</div>
                    <div data-linea="6">
                        <label>Observación: </label>' 
                        . $this->modeloInspeccionFitosanitaria->getObservacion() . 
                    '</div>
                    <div data-linea="7">
                	    <label>Fecha: </label>' 
                	    . $this->modeloInspeccionFitosanitaria->getFechaInspeccion() . 
                	'</div>
                    <div data-linea="7">
            	       <label>Hora: </label>' 
            	       . date('H:i', strtotime($this->modeloInspeccionFitosanitaria->getHoraInspeccion())) . 
            	    '</div>
                    <div data-linea="8">
            	       <label>Observación técnica: </label>' 
            	       . $this->modeloInspeccionFitosanitaria->getObservacionRevisor() . 
            	    '</div>
                </fieldset>';
        
        return $datos;
    }
    
    /**
     * Método para construir los datos del area a inspeccionar
     */
    public function construirDatosResultadoAtenderInspeccion()
    {
        $datos = '<input type="hidden" id="array_productos_inspeccion" name="array_productos_inspeccion" value="" readonly="readonly" />
                <input type="hidden" id="id_inspeccion_fitosanitaria" name="id_inspeccion_fitosanitaria" value="' . $this->modeloInspeccionFitosanitaria->getIdInspeccionFitosanitaria() . '" readonly="readonly">
                <fieldset>
                    <legend id="fResultadoInspeccion">Resultado de inspección</legend>
                    <div data-linea="2">
                        <label>Resultado: </label>
                            <select id="estado_inspeccion_fitosanitaria" name="estado_inspeccion_fitosanitaria" class="validacion">
                                <option value="">Seleccione...</option>
                                <option value="Aprobado">Aprobado</option>
                                <option value="Subsanacion">Subsanación</option>
                                <option value="Rechazado">Rechazado</option>
                            </select>
                        </div>
                    <div data-linea="3">
                	    <label>Observación: </label>
                        <input type="text" id="observacion_revisor" name="observacion_revisor" value="" class="validacion" maxlength="1020">
                    </div>
                    <div data-linea="4">
                	    <label>Tiempo vigencia (días): </label>
                        <input type="number" id="tiempo_vigencia" name="tiempo_vigencia" value="1" min="1" class="validacion" disabled="disabled"> 
                    </div>
                </fieldset>';
        
        return $datos;
    }

}
