<?php
/**
 * Controlador SolicitudesProductos
 *
 * Este archivo controla la lógica del negocio del modelo:  SolicitudesProductosModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-07-13
 * @uses    SolicitudesProductosControlador
 * @package ModificacionProductoRia
 * @subpackage Controladores
 */

namespace Agrodb\ModificacionProductoRia\Controladores;

use Agrodb\Catalogos\Modelos\ProductosInocuidadLogicaNegocio;
use Agrodb\Catalogos\Modelos\ProductosLogicaNegocio;
use Agrodb\Catalogos\Modelos\SubtipoProductosLogicaNegocio;
use Agrodb\Catalogos\Modelos\TipoProductosLogicaNegocio;
use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;
use Agrodb\Financiero\Modelos\OrdenPagoLogicaNegocio;
use Agrodb\GUath\Modelos\FichaEmpleadoLogicaNegocio;
use Agrodb\ModificacionProductoRia\Modelos\DetalleSolicitudesProductosLogicaNegocio;
use Agrodb\ModificacionProductoRia\Modelos\SolicitudesProductosLogicaNegocio;
use Agrodb\ModificacionProductoRia\Modelos\SolicitudesProductosModelo;
use Agrodb\ModificacionProductoRia\Modelos\CategoriasToxicologicasLogicaNegocio;
use Agrodb\ModificacionProductoRia\Modelos\PeriodosReingresosLogicaNegocio;

class SolicitudesProductosControlador extends BaseControlador
{

    private $lNegocioSolicitudesProductos = null;

    private $lNegocioTipoProducto = null;

    private $lNegocioSubtipoProducto = null;

    private $lNegocioProducto = null;

    private $lNegocioProductoInocuidad = null;

    private $lNegocioDetalleSolicitudesProducto = null;

    private $modeloSolicitudesProductos = null;

    private $lNegocioCategoriaToxicologica = null;

    private $lNegocioPeriodoReingreso = null;

    private $lNegocioProductos = null;

    private $lNegocioFichaEmpleado = null;

    private $lNegocioOrdenPago = null;

    private $accion = null;

    private $pestania = null;

    private $datosGenerales = null;

    private $rutaFecha = null;

    private $datosRevision = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioSolicitudesProductos = new SolicitudesProductosLogicaNegocio();
        $this->modeloSolicitudesProductos = new SolicitudesProductosModelo();

        $this->lNegocioTipoProducto = new TipoProductosLogicaNegocio();
        $this->lNegocioSubtipoProducto = new SubtipoProductosLogicaNegocio();
        $this->lNegocioProducto = new ProductosLogicaNegocio();
        $this->lNegocioProductoInocuidad = new ProductosInocuidadLogicaNegocio();
        $this->lNegocioDetalleSolicitudesProducto = new DetalleSolicitudesProductosLogicaNegocio();
        $this->lNegocioCategoriaToxicologica = new CategoriasToxicologicasLogicaNegocio();
        $this->lNegocioPeriodoReingreso = new PeriodosReingresosLogicaNegocio();
        $this->lNegocioProductos = new ProductosLogicaNegocio();
        $this->lNegocioFichaEmpleado = new FichaEmpleadoLogicaNegocio();
        $this->lNegocioOrdenPago = new OrdenPagoLogicaNegocio();
        $this->rutaFecha = date('Y') . '/' . date('m') . '/' . date('d');

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
        $this->cargarPanelSolicitudes();
        $arrayParametros = array(
            'identificador' => $this->identificador,
            'numeroSolicitud' => '',
            'estadoSolicitud' => '',
            'fecha' => '',
            'idArea' => '',
        );
        $modeloSolicitudesProductos = $this->lNegocioSolicitudesProductos->obtenerSolicitudesProductos($arrayParametros);
        $this->tablaHtmlSolicitudesProductos($modeloSolicitudesProductos);
        require APP . 'ModificacionProductoRia/vistas/listaSolicitudesProductosVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nuevo modificación producto";
        $idetificador = $this->identificador;
        $operador = $this->lNegocioSolicitudesProductos->obtenerDatosOperador($idetificador);
        $arrayDatosSolicitud = array(
            'numeroSolicitud' => '',
            'rutaEtiquetaProducto' => '',
            'observacion' => ''
        );
        $this->datosGenerales = $this->datosGeneralesOperador($operador, $arrayDatosSolicitud);
        require APP . 'ModificacionProductoRia/vistas/formularioSolicitudesProductosVista.php';
    }

    /**
     * Método para registrar en la base de datos -SolicitudesProductos
     */
    public function guardar()
    {
        $estado = 'exito';
        $mensaje = '';
        $idSolicitudModificacionProducto = '';
        
        if(isset($_POST['id_tipo_modificacion_producto']) && isset($_POST['tipo_modificacion'])){
        
        $idetificador = $this->identificador;
        $operador = $this->lNegocioSolicitudesProductos->obtenerDatosOperador($idetificador);

        $_POST['identificador_operador'] = $operador->getIdentificador();
        $_POST['razon_social'] = $operador->getRazonSocial();
        $_POST['representante_legal'] = $operador->getNombreRepresentante() . ' ' . $operador->getApellidoRepresentante();
        $_POST['direccion'] = $operador->getDireccion();
        $_POST['telefono'] = $operador->getTelefonoUno() === '' ? $operador->getTelefonoDos() : $operador->getTelefonoUno();
        $_POST['correo'] = $operador->getCorreo();
        $_POST['representante_tecnico'] = $operador->getNombreTecnico() . ' ' . $operador->getApellidoTecnico();
        $_POST['provincia_operador'] = $operador->getProvincia();

        $idSolicitudModificacionProducto = $this->lNegocioSolicitudesProductos->guardar($_POST);
        
        }else{
            $estado = 'error';
            $mensaje = 'Seleccione al menos un tipo de modificación';
        }
        
        echo json_encode(array(
            "estado" => $estado,
            "mensaje" => $mensaje,
            "contenido" => $idSolicitudModificacionProducto
        ));
    }

    /**
     * Obtenemos los datos del registro seleccionado para editar - Tabla: SolicitudesProductos
     */
    public function editar()
    {
        $this->accion = "Modificación de producto";
        $idSolicitudProducto = $_POST['id'];
        $modificaciones = [];
        $totalTiempoAtencion = 0;
        $tipoOpcion = $_POST['nombreOpcion'] ?? '';

        $datosSolicitud = $this->lNegocioSolicitudesProductos->buscar($idSolicitudProducto);
        $identificadorOperador = $datosSolicitud->getIdentificadorOperador();
        $idArea = $datosSolicitud->getIdArea();
        $idProducto = $datosSolicitud->getIdProducto();
        $estadoSolicitudProducto = $datosSolicitud->getEstadoSolicitudProducto();
        $numeroRegistro = $datosSolicitud->getNumeroRegistro();
        $numeroSolicitud = $datosSolicitud->getNumeroSolicitud();
        $rutaEtiquetaProducto = $datosSolicitud->getRutaEtiquetaProducto();
        $observacion = $datosSolicitud->getObservacion();

        $arrayDatosSolicitud = array(
            'numeroSolicitud' => $numeroSolicitud,
            'rutaEtiquetaProducto' => $rutaEtiquetaProducto,
            'observacion' => $observacion
        );

        $operador = $this->lNegocioSolicitudesProductos->obtenerDatosOperador($identificadorOperador);
        $this->datosGenerales = $this->datosGeneralesOperador($operador, $arrayDatosSolicitud);

        $datosConsultaProducto = [
            'id_producto' => $idProducto
            , 'estado_solicitud_producto' => $estadoSolicitudProducto
        ];

        $producto = $this->lNegocioProductos->obtenerDatosProductoModificacionRia($datosConsultaProducto);

        $datosProducto = $producto->toArray();
        $datosProducto[0]['numero_registro'] = $numeroRegistro;
        $this->datosGenerales .= $this->datosGeneralesProducto($datosProducto[0]);

        $datosConsultaFinanciero = [
            'id_solicitud' => $idSolicitudProducto,
            'tipo_solicitud' => 'modificacionProductoRia',
            'estado' => 3
        ];

        if ($estadoSolicitudProducto === 'verificacion') {
            $financiero = $this->lNegocioOrdenPago->buscarLista($datosConsultaFinanciero);
            $datosFinanciero = $financiero->toArray();
            $this->datosGenerales .= $this->datosFinancieroModificacionProducto($datosFinanciero[0]);
        }

        $tiposModificacion = $this->lNegocioDetalleSolicitudesProducto->obtenerDetallesSolicitudesModificacionProducto($idSolicitudProducto);
        $tiposModificacion->buffer();
        $this->datosGenerales .= $this->datosGeneralesModificacionProducto($tiposModificacion);
        $this->datosGenerales .= '<hr><br>';

        $solicitarEtiqueta = false;
        $requiereCultivo = false;
        $cantidadTiposModificaciones = $tiposModificacion->count();

        foreach ($tiposModificacion as $item) {

            $totalTiempoAtencion = $totalTiempoAtencion + $item->tiempo_atencion;

            if ($item->requiere_etiqueta) {
                $solicitarEtiqueta = true;
            }

            if ($item['codigo_modificacion'] == 'modificarUso' && $item['id_area'] == 'IAP') {
                $requiereCultivo = true;
            }

            $modificaciones[] = array(
                'modificaciones' => $item->codigo_modificacion,
                'tiempo_atencion' => $item->tiempo_atencion,
                'id_detalle_solicitud_producto' => $item->id_detalle_solicitud_producto,
                'estado_solicitud_producto' => $tipoOpcion ? 'verSolicitud' : $estadoSolicitudProducto,
                'ruta_documento_respaldo' => $item->ruta_documento_respaldo,
                'requiere_respaldo' => $item->requiere_respaldo,
                'requiere_cultivo' => false
            );
        }
									
        $totalTiempoAtencion = intdiv($totalTiempoAtencion, $cantidadTiposModificaciones);
		 
        $this->datosTiempoAtencion = $this->cargarPanelTiempoAtencion($totalTiempoAtencion);

        switch ($estadoSolicitudProducto) {

            case 'Creado':
                if (!$tipoOpcion) {
                    $modificaciones[] = array(
                        'modificaciones' => 'aceptarTerminos',
                        'tiempo_atencion' => '',
                        'id_detalle_solicitud_producto' => '',
                        'estado_solicitud_producto' => '',
                        'ruta_documento_respaldo' => '',
                        'requiere_respaldo' => '',
                        'requiere_cultivo' => $requiereCultivo
                    );
                }
                break;
            case 'subsanacion':
                if (!$tipoOpcion) {
                    $modificaciones[] = array(
                        'modificaciones' => 'aceptarTerminos',
                        'tiempo_atencion' => '',
                        'id_detalle_solicitud_producto' => '',
                        'estado_solicitud_producto' => $estadoSolicitudProducto,
                        'ruta_documento_respaldo' => '',
                        'requiere_respaldo' => '',
                        'requiere_cultivo' => false
                    );
                }
                $fichaEmpleado = $this->lNegocioFichaEmpleado->buscar($datosSolicitud->getIdentificadorRevisor());
                $this->datosRevision = $this->datosResultadoRevisionProducto($datosSolicitud, $fichaEmpleado, $estadoSolicitudProducto);
                break;
            case 'asignadoInspeccion':
                $fichaEmpleado = $this->lNegocioFichaEmpleado->buscar($datosSolicitud->getIdentificadorRevisor());
                $this->datosRevision = $this->datosResultadoRevisionProducto($datosSolicitud, $fichaEmpleado, $estadoSolicitudProducto);
                break;
            case 'Aprobado':
            case 'Rechazado':
                $modificaciones[] = array(
                    'modificaciones' => 'datosGenerales',
                    'tiempo_atencion' => '',
                    'id_detalle_solicitud_producto' => '',
                    'estado_solicitud_producto' => $estadoSolicitudProducto,
                    'ruta_documento_respaldo' => '',
                    'requiere_respaldo' => '',
                    'requiere_cultivo' => false
                );
                $fichaEmpleado = $this->lNegocioFichaEmpleado->buscar($datosSolicitud->getIdentificadorRevisor());
                $this->datosRevision = $this->datosResultadoRevisionProducto($datosSolicitud, $fichaEmpleado, $estadoSolicitudProducto);
                break;
            default:
                $modificaciones[] = array(
                    'modificaciones' => 'datosGenerales',
                    'tiempo_atencion' => '',
                    'id_detalle_solicitud_producto' => '',
                    'estado_solicitud_producto' => $estadoSolicitudProducto,
                    'ruta_documento_respaldo' => '',
                    'requiere_respaldo' => '',
                    'requiere_cultivo' => false
                );
                break;
        }

        $parametros = array(
            'id_solicitud_producto' => $idSolicitudProducto,
            'id_area' => $idArea,
            'id_producto' => $idProducto,
            'solicitar_etiqueta' => $solicitarEtiqueta,
            'requiere_cultivo' => false
        );

        $this->generarPestaniasPorTipoModificacion($modificaciones, $parametros);
        require APP . 'ModificacionProductoRia/vistas/formularioEditarSolicitudesProductosVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - SolicitudesProductos
     */
    public function borrar()
    {
        $idSolicitudProducto = $_POST['elementos'];
        $this->modeloSolicitudesProductos = $this->lNegocioSolicitudesProductos->buscar($idSolicitudProducto);

        if ($this->modeloSolicitudesProductos->getEstadoSolicitudProducto() === 'Creado') {
            $identificadorOperador = $this->modeloSolicitudesProductos->getIdentificadorOperador();
            $idArea = $this->modeloSolicitudesProductos->getIdArea();
            $idProducto = $this->modeloSolicitudesProductos->getIdProducto();
            $estadoSolicitudProducto = $this->modeloSolicitudesProductos->getEstadoSolicitudProducto();
            $numeroRegistro = $this->modeloSolicitudesProductos->getNumeroRegistro();
            $numeroSolicitud = $this->modeloSolicitudesProductos->getNumeroSolicitud();
            $rutaEtiquetaProducto = $this->modeloSolicitudesProductos->getRutaEtiquetaProducto();
            $observacion = $this->modeloSolicitudesProductos->getObservacion();

            $arrayDatosSolicitud = array(
                'numeroSolicitud' => $numeroSolicitud,
                'rutaEtiquetaProducto' => $rutaEtiquetaProducto,
                'observacion' => $observacion
            );

            $operador = $this->lNegocioSolicitudesProductos->obtenerDatosOperador($identificadorOperador);
            $this->datosGenerales = $this->datosGeneralesOperador($operador, $arrayDatosSolicitud);

            $datosConsultaProducto = [
                'id_producto' => $idProducto
                , 'estado_solicitud_producto' => $estadoSolicitudProducto
            ];

            $producto = $this->lNegocioProductos->obtenerDatosProductoModificacionRia($datosConsultaProducto);

            $datosProducto = $producto->toArray();
            $datosProducto[0]['numero_registro'] = $numeroRegistro;
            $this->datosGenerales .= $this->datosGeneralesProducto($datosProducto[0]);

            $tiposModificacion = $this->lNegocioDetalleSolicitudesProducto->obtenerDetallesSolicitudesModificacionProducto($idSolicitudProducto);
            $tiposModificacion->buffer();
            $this->datosGenerales .= $this->datosGeneralesModificacionProducto($tiposModificacion);

            require APP . 'ModificacionProductoRia/vistas/formularioEliminarSolicitudesProductosVista.php';
        } else {
            echo 'Solo es posible eliminar solicitudes en estado Creado';
        }
    }

    public function eliminar()
    {
        $idSolicitudProducto = $_POST['id_solicitud_producto'];

        $this->lNegocioSolicitudesProductos->borrar($idSolicitudProducto);
        echo json_encode(array(
                'estado' => 'exito',
                'mensaje' => 'Registro eliminado exitosamente')
        );
    }

    /**
     * Construye el código HTML para desplegar la lista de - SolicitudesProductos
     */
    public function tablaHtmlSolicitudesProductos($tabla, $tipo = null)
    {
        {
            $contador = 0;
            foreach ($tabla as $fila) {
                $estado = '';
                switch ($fila['estado_solicitud_producto']) {
                    case 'Creado':
                        $estado = 'Creado';
                        break;
                    case 'pago':
                        $estado = 'Asignación de pago';
                        break;
                    case 'verificacion':
                        $estado = 'Verificación de pago';
                        break;
                    case 'inspeccion':
                        $estado = 'Revisión técnica';
                        break;
                    case 'asignadoInspeccion':
                        $estado = 'Asignado revisión técnica';
                        break;
                    case 'subsanacion':
                        $estado = 'Subsanación';
                        break;
                    case 'Aprobado':
                        $estado = 'Aprobado';
                        break;
                    case 'Rechazado':
                        $estado = 'Rechazado';
                        break;
                    case 'generarOrden':
                        $estado = 'Generar orden de pago';
                        break;
                    case 'Eliminado':
                        $estado = 'Eliminado';
                        break;
                }

                $this->itemsFiltrados[] = array(
                    '<tr id="' . $fila['id_solicitud_producto'] . '"
                        class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'ModificacionProductoRia\SolicitudesProductos"
                        data-opcion="editar" ondragstart="drag(event)" draggable="true"
                        data-destino="detalleItem" data-nombre="' . $tipo . '">
                        <td>' . ++$contador . '</td>
                        <td>' . $fila['numero_solicitud'] . '</td>
                        <td>' . $fila['identificador_operador'] . '</td>
						<td>' . date('Y-m-d', strtotime($fila['fecha_envio_subsanacion'])) . '</td>
						<td>' . $fila['nombre_producto'] . '</td>
						<td>' . $fila['nombre_area_tematica'] . '</td>
                        <td>' . $estado . '</td>
                    </tr>'
                );
            }
        }
    }

    public function generarPestaniasPorTipoModificacion($modificaciones, $parametros)
    {
        $idArea = $parametros['id_area'];

        foreach ($modificaciones as $modificacionValor) {

            $modificacion = $modificacionValor['modificaciones'];
            $tiempoAtencion = $modificacionValor['tiempo_atencion'];
            $idDetalleSolicitudProducto = $modificacionValor['id_detalle_solicitud_producto'];
            $estadoSolicitudProducto = $modificacionValor['estado_solicitud_producto'];
            $parametros['tipo_modificacion'] = $modificacion;
            $parametros['ruta_documento_respaldo'] = $modificacionValor['ruta_documento_respaldo'];
            $parametros['requiere_respaldo'] = ($modificacionValor['requiere_respaldo'] ? ' validacion' : '');
            $parametros['requiere_cultivo'] = $modificacionValor['requiere_cultivo'];

            $this->pestania .= '
             <div class="pestania">
             <input type="hidden" name="id_detalle_solicitud_producto' . $modificacion . '" id="id_detalle_solicitud_producto' . $modificacion . '" value="' . $idDetalleSolicitudProducto . '">';

            switch ($idArea) {
                case 'IAP':
                    switch ($modificacion) {
                        case 'modificarCategoriaToxicologica':
                            $categoriasToxicologicasControlador = new CategoriasToxicologicasControlador();
                            $this->pestania .= $categoriasToxicologicasControlador->modificarCategoriaToxicologica($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarPeriodoReingreso':
                            $periodosReingresosControlador = new PeriodosReingresosControlador();
                            $this->pestania .= $periodosReingresosControlador->modificarPeriodoReingreso($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarVidaUtil':
                            $vidasUtilesControlador = new VidasUtilesControlador();
                            $this->pestania .= $vidasUtilesControlador->modificarVidaUtil($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarEstadoRegistro':
                            $estadosRegistrosControlador = new EstadosRegistrosControlador();
                            $this->pestania .= $estadosRegistrosControlador->modificarEstadoRegistro($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarAdicionPresentacionPlaguicida':
                            $adicionesPresentacionesPlaguicidasControlador = new AdicionesPresentacionesPlaguicidasControlador();
                            $this->pestania .= $adicionesPresentacionesPlaguicidasControlador->modificarAdicionPresentacionPlaguicida($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarTitularidadProducto':
                            $titularidadProductoControlador = new TitularesProductosControlador();
                            $this->pestania .= $titularidadProductoControlador->modificarTitularidadProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarFabricanteFormulador':
                            $fabricanteFormuladorControlador = new FabricantesFormuladoresControlador();
                            $this->pestania .= $fabricanteFormuladorControlador->modificarFabricanteFormuladorProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarUso':
                            $usosControlador = new UsosControlador();
                            $this->pestania .= $usosControlador->modificarUsoProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarManufacturador':
                            $manufacturadorControlador = new ManufacturadoresControlador();
                            $this->pestania .= $manufacturadorControlador->modificarManufacturadorProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarEtiqueta':
                            $this->pestania .= $this->modificarEtiquetaProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarNombreComercial':
                            $nombresComercialesControlador = new NombresComercialesControlador();
                            $this->pestania .= $nombresComercialesControlador->modificarNombreComercial($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'resultadoRevision':
                            $revisionSolicitudesControlador = new RevisionSolicitudesProductoControlador();
                            $this->pestania .= $revisionSolicitudesControlador->resultadoRevisionTecnica($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'aceptarTerminos':
                            $this->pestania .= $this->aceptarTerminos($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'datosGenerales':
                            $this->pestania .= $this->datosGenerales($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                    }
                    break;
                case 'IAV':
                    switch ($modificacion) {
                        case 'modificarCategoriaToxicologica':
                            $categoriasToxicologicasControlador = new CategoriasToxicologicasControlador();
                            $this->pestania .= $categoriasToxicologicasControlador->modificarCategoriaToxicologica($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarViaAdmimistracionDosis':
                            $viasAdministracionesDosisControlador = new ViasAdministracionesDosisControlador();
                            $this->pestania .= $viasAdministracionesDosisControlador->modificarViaAdministracionDosis($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarPeriodoRetiro':
                            $periodosRetirosControlador = new PeriodosRetirosControlador();
                            $this->pestania .= $periodosRetirosControlador->modificarPeriodoRetiro($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarVidaUtil':
                            $vidasUtilesControlador = new VidasUtilesControlador();
                            $this->pestania .= $vidasUtilesControlador->modificarVidaUtil($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarNombreComercial':
                            $nombresComercialesControlador = new NombresComercialesControlador();
                            $this->pestania .= $nombresComercialesControlador->modificarNombreComercial($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarEstadoRegistro':
                            $estadosRegistrosControlador = new EstadosRegistrosControlador();
                            $this->pestania .= $estadosRegistrosControlador->modificarEstadoRegistro($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarAdicionPresentacion':
                            $adicionesPresentacionesControlador = new AdicionesPresentacionesControlador();
                            $this->pestania .= $adicionesPresentacionesControlador->modificarAdicionPresentacion($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarTitularidadProducto':
                            $titularidadProductoControlador = new TitularesProductosControlador();
                            $this->pestania .= $titularidadProductoControlador->modificarTitularidadProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarFabricanteFormulador':
                            $fabricanteFormuladorControlador = new FabricantesFormuladoresControlador();
                            $this->pestania .= $fabricanteFormuladorControlador->modificarFabricanteFormuladorProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarUso':
                            $usosControlador = new UsosControlador();
                            $this->pestania .= $usosControlador->modificarUsoProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarComposicion':
                            $usosControlador = new ComposicionesControlador();
                            $this->pestania .= $usosControlador->modificarComposicionProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarEtiqueta':
                            $this->pestania .= $this->modificarEtiquetaProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarDeclaracionVenta':
                            $denominacionVenta = new DenominacionesVentasControlador();
                            $this->pestania .= $denominacionVenta->modificarDenominacionVentaProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarClasificacionProducto':
                            $clasificacionProductoControlador = new ClasificacionProductoControlador();
                            $this->pestania .= $clasificacionProductoControlador->modificarClasificacionProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'resultadoRevision':
                            $revisionSolicitudesControlador = new RevisionSolicitudesProductoControlador();
                            $this->pestania .= $revisionSolicitudesControlador->resultadoRevisionTecnica($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'aceptarTerminos':
                            $this->pestania .= $this->aceptarTerminos($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'datosGenerales':
                            $this->pestania .= $this->datosGenerales($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                    }
                    break;
                case 'IAF':
                    switch ($modificacion) {
                        case 'modificarEstadoRegistro':
                            $estadosRegistrosControlador = new EstadosRegistrosControlador();
                            $this->pestania .= $estadosRegistrosControlador->modificarEstadoRegistro($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarViaAdmimistracionDosis':
                            $viasAdministracionesDosisControlador = new ViasAdministracionesDosisControlador();
                            $this->pestania .= $viasAdministracionesDosisControlador->modificarViaAdministracionDosis($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarAdicionPresentacion':
                            $adicionesPresentacionesControlador = new AdicionesPresentacionesControlador();
                            $this->pestania .= $adicionesPresentacionesControlador->modificarAdicionPresentacion($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarTitularidadProducto':
                            $titularidadProductoControlador = new TitularesProductosControlador();
                            $this->pestania .= $titularidadProductoControlador->modificarTitularidadProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarFabricanteFormulador':
                            $fabricanteFormuladorControlador = new FabricantesFormuladoresControlador();
                            $this->pestania .= $fabricanteFormuladorControlador->modificarFabricanteFormuladorProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarUso':
                            $usosControlador = new UsosControlador();
                            $this->pestania .= $usosControlador->modificarUsoProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'modificarEtiqueta':
                            $this->pestania .= $this->modificarEtiquetaProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'resultadoRevision':
                            $revisionSolicitudesControlador = new RevisionSolicitudesProductoControlador();
                            $this->pestania .= $revisionSolicitudesControlador->resultadoRevisionTecnica($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'aceptarTerminos':
                            $this->pestania .= $this->aceptarTerminos($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                        case 'datosGenerales':
                            $this->pestania .= $this->datosGenerales($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto);
                            break;
                    }
                    break;
            }
            $this->pestania .= '</div>';
        }

        return $this->pestania;
    }

    public function aceptarTerminos($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto)
    {
        $idSoliciudProducto = $parametros['id_solicitud_producto'];
        $solicitarEtiqueta = $parametros['solicitar_etiqueta'];
        $requiereCultivo = $parametros['requiere_cultivo'];

        $aceptarTerminos = ' <form id="finalizarSolicitud" data-rutaAplicacion="' . URL_MVC_FOLDER . 'ModificacionProductoRia" data-opcion="SolicitudesProductos/guardarFinalizarSolicitud" data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
        <input type="hidden" id="id_solicitud_producto" name="id_solicitud_producto" value="' . $idSoliciudProducto . '" />
        <input type="hidden" id="array_ruta_documento_respaldo" name="array_ruta_documento_respaldo" value="" readonly="readonly" />
        <fieldset  id="fAceptarTerminos">
        <legend>Finalizar solicitud</legend>
            <div data-linea="1">
                <label>Observación: </label>
                <input type="text" name="observacion" id="observacion" maxlength="500">
            </div>
			<div data-linea="2">
                <label>Link para acceso a documentos con firma: </label>
            </div>
            <div data-linea="3">
                <input type="text" name="enlace_documento" id="enlace_documento" maxlength="2000">
            </div>
            <hr/>';

        if ($solicitarEtiqueta) {

            $aceptarTerminos .= '<div data-linea="4">
                                    <label>Etiqueta producto:</label>
                                </div>
                                <div data-linea="5">
                                    <input type="hidden" class="rutaArchivo" id="rRutaEtiqueta" name="ruta_etiqueta_producto" value="0"/>
                                    <input type="file" class="archivo validacion" id="vRutaEtiqueta" accept="application/pdf" />
                                    <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                                    <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . MODI_PROD_RIA_URL . $this->rutaFecha . '">Subir archivo</button>
                                </div>
                                <hr/>';
        }

        if ($estadoSolicitudProducto != 'subsanacion') {

            $aceptarTerminos .= '<div data-linea="6">
                                    <label><input type="checkbox" id="terminos" name="terminos" value="Si" class="validacionterminos"> ACEPTO TÉRMINOS Y CONDICIONES GENERALES DE USO - </label><a href="' . MODI_PROD_RIA_URL . 'terminos/terminosYCondiciones.pdf' . '" target="_blank">Leer</a>
                                 </div>
                                 <div data-linea="7">
                                        <label><input type="checkbox" id="descuento" name="descuento" value="Si"> SOY PERSONA NATURAL DE TERCERA EDAD O ARTESANO</label>
                                 </div>';
            if ($requiereCultivo) {
                $aceptarTerminos .= '<div data-linea="8">
                                        <label><input type="checkbox" id="cultivo_menor" name="cultivo_menor" value="Si"> SOLICITUD PERTENECE A CULTIVO MENOR </label>
                                 </div>';
            }
        }
        $aceptarTerminos .= '
        </fieldset>
        <div data-linea="4">
            <button id="finalizarSolicitudUsuario" type="submit" class="guardar" data-requiereetiqueta="' . $solicitarEtiqueta . '">Enviar solicitud</button>
        </div>
        </form> ';
        return $aceptarTerminos;
    }

    public function datosGenerales($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSolicitudProducto)
    {
        $datoEtiqueta = "";
        $datoCultivo = "";
		$datoDocumento = "";
        $solicitarEtiqueta = $parametros['solicitar_etiqueta'];
        $idSolicitudProducto = $parametros['id_solicitud_producto'];
        $qDatosSolicitudProducto = $this->lNegocioSolicitudesProductos->buscar($idSolicitudProducto);
        $observacion = ($qDatosSolicitudProducto->getObservacion() == "") ? 'N/A' : $qDatosSolicitudProducto->getObservacion();
        $rutaEtiquetaProducto = $qDatosSolicitudProducto->getRutaEtiquetaProducto();
        $requiereCultivo = $parametros['requiere_cultivo'];
		$enlaceDocumento = $qDatosSolicitudProducto->getEnlaceDocumento();

        if ($solicitarEtiqueta) {
            $datoEtiqueta .= '<div data-linea="2">
                            <label>Ruta etiqueta: </label><a href="' . $rutaEtiquetaProducto . '" target="_blank">Descagar etiqueta</a>
                        </div>';
        }

        if ($requiereCultivo) {
            $datoCultivo .= '<div data-linea="4">
                            <label>Cultivo menor: </label>Si
                        </div>';
        }
		
		if ($enlaceDocumento) {
            $datoDocumento .= '<div data-linea="5">
                            <label>Enlace documento: </label><a href="' . $enlaceDocumento . '" target="_blank">Descagar documento</a>
                        </div>';
        }

        $datosGenerales = '<fieldset  id="fDatosGenerales">
                            <legend>Datos generales</legend>
                            <div data-linea="1">
                                <label>Observación: </label>' . $observacion . '
                            </div>' . $datoEtiqueta . $datoCultivo . $datoDocumento;

        $datosGenerales .= '</fieldset>';

        return $datosGenerales;
    }

    /* Metodo para finalizar el envío de solcitud */
    public function guardarFinalizarSolicitud()
    {
        $estado = '';
        $mensaje = '';

        $idSolicitudModificacionProducto = $_POST['id_solicitud_producto'];

        $verificarRegistro = $this->lNegocioSolicitudesProductos->verificarRegistrosSoliciud($idSolicitudModificacionProducto);

        if ($verificarRegistro->current()->f_verificar_registros) {

            $estado = 'exito';
            $mensaje = 'La solicitud fue registrada con éxito';

            $qEstadoActualSolicitudProducto = $this->lNegocioSolicitudesProductos->buscar($idSolicitudModificacionProducto);
            $estadoActualSolicitudProducto = $qEstadoActualSolicitudProducto->getEstadoSolicitudProducto();

            switch ($estadoActualSolicitudProducto) {

                case 'Creado':

                    $tiposModificacion = $this->lNegocioDetalleSolicitudesProducto->obtenerDetallesSolicitudesModificacionProducto($idSolicitudModificacionProducto);
                    $fasePago = false;

                    foreach ($tiposModificacion as $item) {
                        if ($item->fase_pago) {
                            $fasePago = true;
                        }
                    }

                    if ($fasePago) {
                        $estadoSolicitudProducto = 'pago';
                    } else {
                        $estadoSolicitudProducto = 'asignadoInspeccion';
                    }

                    if (isset($_POST['cultivo_menor'])) {
                        $estadoSolicitudProducto = 'asignadoInspeccion';
                    }

                    break;
                case 'subsanacion':
                    $estadoSolicitudProducto = 'asignadoInspeccion';
                    $_POST['estado_actual_solicitud_producto'] = $estadoActualSolicitudProducto;
                    $_POST['array_ruta_documento_respaldo'] = json_decode($_POST['array_ruta_documento_respaldo'], true);
                    break;
            }

            $_POST['estado_solicitud_producto'] = $estadoSolicitudProducto;
            $_POST['fecha_envio_subsanacion'] = 'now()';

            $this->lNegocioSolicitudesProductos->guardarFinalizarSolitud($_POST);
        } else {

            $estado = 'error';
            $mensaje = 'Por favor llene todos los regitros de la solicitud.';
        }

        echo json_encode(array(
            "estado" => $estado,
            "mensaje" => $mensaje
        ));
    }

    public function obtenerTipoProductoPorIdArea()
    {
        $idArea = $_POST['id_area'];

        $comboTipoProducto = '<option value="">Seleccionar....</option>';
        $comboTipoModificacion = '<option value="">Seleccionar....</option>';

        $datos = [
            'id_area' => $idArea,
            'estado' => 1,
            'identificador_operador' => $this->usuarioActivo()
        ];
        $tipoProducto = $this->lNegocioProductoInocuidad->obtenerTipoProductoXOperadorAreaEstado($datos);

        foreach ($tipoProducto as $item) {
            $comboTipoProducto .= '<option value="' . $item->id_tipo_producto . '">' . $item->nombre . '</option>';
        }

        $tipoModificacion = $this->lNegocioSolicitudesProductos->obtenerTipoModificacionProducto($idArea);

        foreach ($tipoModificacion as $item) {
            $comboTipoModificacion .= '<option value="' . $item->id_tipo_modificacion_producto . '" data-tiempoatencion="' . $item->dias_atencion . '">' . $item->tipo_modificacion . '</option>';
        }

        echo json_encode(array(
            'estado' => 'EXITO',
            'comboTipoProducto' => $comboTipoProducto,
            'comboTipoModificacion' => $comboTipoModificacion
        ));
    }

    public function obtenerSubtipoProductoPorIdTipoProducto()
    {
        $idTipoProducto = $_POST['id_tipo_producto'];

        $comboSubtipoProducto = '<option value="">Seleccionar....</option>';
        $datos = [
            'id_tipo_producto' => $idTipoProducto,
            'estado' => 1,
            'identificador_operador' => $this->usuarioActivo()
        ];
        $subtipoProducto = $this->lNegocioProductoInocuidad->obtenerSubtipoProductoXOperadorAreaEstado($datos);

        foreach ($subtipoProducto as $item) {
            $comboSubtipoProducto .= '<option value="' . $item->id_subtipo_producto . '">' . $item->nombre . '</option>';
        }

        echo json_encode(array(
            'estado' => 'EXITO',
            'comboSubtipoProducto' => $comboSubtipoProducto
        ));
    }

    public function obtenerProductoPorIdSubtipoProducto()
    {
        $idSubtipoProducto = $_POST['id_subtipo_producto'];

        $comboProducto = '<option value="">Seleccionar....</option>';
        $datos = [
            'id_subtipo_producto' => $idSubtipoProducto,
            'estado' => 1,
            'identificador_operador' => $this->usuarioActivo()
        ];
        $producto = $this->lNegocioProductoInocuidad->obtenerProductoXOperadorAreaEstado($datos);

        foreach ($producto as $item) {
            $comboProducto .= '<option value="' . $item->id_producto . '">' . $item->nombre_comun . '</option>';
        }

        echo json_encode(array(
            'estado' => 'EXITO',
            'comboProducto' => $comboProducto
        ));
    }

    public function obtenerNumeroRegistroProducto()
    {
        $idProducto = $_POST['id_producto'];

        $numeroRegistro = $this->lNegocioProductoInocuidad->buscar($idProducto);

        echo json_encode(array(
            'estado' => 'EXITO',
            'numeroRegistro' => $numeroRegistro->getNumeroRegistro()
        ));
    }

    public function modificarEtiquetaProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSoliciudProducto)
    {
        $tipoModificacion = $parametros['tipo_modificacion'];
        $idSolicitudProducto = $parametros['id_solicitud_producto'];
        $rutaDocumentoRespaldo = $parametros['ruta_documento_respaldo'];
        $filaEtiqueta = '';
        $ingresoDatos = '';
        $banderaAcciones = false;

        switch ($estadoSoliciudProducto) {

            case 'Creado':
            case 'subsanacion':

                $banderaAcciones = true;
                $ingresoDatos = '
                                <div data-linea="1">
                                    <label>Etiquetas:</label>
                                    <input type="hidden" name="id_solicitud_producto" id="id_solicitud_producto" value="' . $idSolicitudProducto . '" data-tiempoatencion="' . $tiempoAtencion . ' días"/>
                                </div>
                                <div data-linea="2">
                                    <input type="hidden" class="rutaArchivo" id="r' . $tipoModificacion . 'RutaEtiqueta" name="ruta_etiqueta" value="0"/>
                                    <input type="file" class="archivo validacion" id="v' . $tipoModificacion . 'RutaEtiqueta" accept="application/pdf" />
                                    <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                                    <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . MODI_PROD_RIA_URL . $this->rutaFecha . '">Subir archivo</button>
                                </div>';

                $ingresoDatos .= '<hr/>
                                <div data-linea="3">
                                    <label>Documento de respaldo:</label>
                                </div>
                                <div data-linea="4">
                                    <input type="hidden" class="rutaArchivo" id="r' . $tipoModificacion . '" name="ruta_documento_respaldo" value="0"/>
                                    <input type="file" class="archivo' . $parametros['requiere_respaldo'] . '" id="v' . $tipoModificacion . '" accept="application/pdf" />
                                    <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                                    <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . MODI_PROD_RIA_URL . $this->rutaFecha . '">Subir archivo</button>
                                </div>
                                <hr/>
                                <div data-linea="5">
                        			<button type="button" class="mas" id="agregarEtiqueta" data-tipomodificacion="' . $tipoModificacion . '">Agregar</button>
                        		</div>';
                break;
        }

        $datosEtiqueta = $this->lNegocioSolicitudesProductos->buscar($idSolicitudProducto);
        $rutaEtiqueta = $datosEtiqueta->getRutaEtiquetaProducto();

        if ($rutaEtiqueta) {
            $filaEtiqueta .= '<tr id="fila' . $idSolicitudProducto . '">
                    <td><a href="' . $rutaEtiqueta . '" target="_blank">Etiqueta</a></td>';
            if ($banderaAcciones) {
                $filaEtiqueta .= '<td class="borrar">
                        <button type="button" name="eliminar" class="icono" onclick="fn_eliminarEtiqueta(' . $idSolicitudProducto . '); return false;"/>
                    </td>';
            }
            $filaEtiqueta .= '</tr>';
        }

        $modificarEtiqueta = '';

        if ($rutaDocumentoRespaldo) {
            $modificarEtiqueta .= '
            <fieldset>
                <legend>Documento adjunto</legend>
                <div data-linea="1">
                    <label>Documento de respaldo: </label>' . ($rutaDocumentoRespaldo === 0 ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $rutaDocumentoRespaldo . ' target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>') . '
                </div>
            </fieldset>';
        }

        $modificarEtiqueta .= '
            <fieldset  id="fEtiquetaProducto">
                <legend>Etiqueta</legend>
                ' . $ingresoDatos . '
                <table id="tEtiquetaProducto" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Etiqueta</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>' . $filaEtiqueta . '</tbody>
                </table>
            </fieldset>';

        return $modificarEtiqueta;
    }

    /**
     * Método para listar titularidad de producto agregada
     */
    public function generarFilaEtiquetaProducto($idSolicitudProducto, $datosEtiqueta, $tiempoAtencion)
    {
        $this->listaDetalles = '
                        <tr id="fila' . $datosEtiqueta['id_solicitud_producto'] . '">
                            <td><a href="' . $datosEtiqueta['ruta_etiqueta_producto'] . '" target="_blank">Etiqueta</a></td>
                            <td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarEtiqueta(' . $idSolicitudProducto . '); return false;"/></td>
                        </tr>';

        return $this->listaDetalles;
    }

    public function eliminarEtiqueta()
    {
        $_POST['ruta_etiqueta_producto'] = null;
        $_POST['id_tipo_modificacion_producto'] = [];

        $this->lNegocioSolicitudesProductos->guardar($_POST);
    }

    public function cargarPanelSolicitudes()
    {
        $this->panelBusqueda = '<table class="filtro" style="width: 100%;">
                                            	<tbody>
	                                                <tr>
	                                                    <th colspan="4">Buscar solicitud:</th>
	                                                </tr>
	                                                <tr  style="width: 100%;">
	                            						<td >Número de solicitud: </td>
	                            						<td colspan="3">
	                            							<input id="numeroSolicitud" type="text" name="numeroSolicitud" value="" >
	                            						</td>
            
	                            					</tr>
                                                    <tr  style="width: 100%;">
	                            						<td >Estado Solicitud: </td>
	                            						<td colspan="3">
                                                            <select style="width: 100%;" id="estadoSolicitud" name= "estadoSolicitud" >
        		                                              <option value="">Seleccione...</option>
        		                                              <option value="Creado">Creado</option>
        		                                              <option value="pago">Asiganción de pago</option>
        		                                              <option value="verificacion">Verificación de pago</option>
                                                              <option value="inspeccion">Revisión técnica</option>
                                                              <option value="asignadoInspeccion">Asignado revisión técnica</option>
                                                              <option value="subsanacion">Subsanación</option>
                                                              <option value="Aprobado">Aprobado</option>
                                                              <option value="Rechazado">Rechazado</option>
        	                                                </select>
	                            						</td>
            
	                            					</tr>
                                                    <tr  style="width: 100%;">
	                            						<td >Fecha: </td>
	                            						<td colspan="3">
	                            							<input id="fecha" type="text" name="fecha" value="" readonly>
	                            						</td>
            
	                            					</tr>
            
                            						<td colspan="4" style="text-align: end;">
                            							<button id="btnFiltrar">Filtrar lista</button>
                            						</td>
                            					</tr>
                            				</tbody>
                            			</table>';
    }

    public function cargarPanelVerSolicitudes()
    {
        $this->panelBusqueda = '<table id="filtro" class="filtro" style="width: 100%;">
                                            	<tbody>
	                                                <tr>
	                                                    <th colspan="4">Buscar solicitud:</th>
	                                                </tr>
	                                                <tr  style="width: 100%;">
	                            						<td >Área temática: </td>
	                            						<td colspan="3">
	                            							<select style="width: 100%;" id="idArea" name= "idArea" >
                                                                <option value="">Seleccione...</option>
                                                                <option value="IAP">Agrícola</option>
                                                                <option value="IAF">Fertilizante</option>
                                                                <option value="IAV">Pecuario</option>
        	                                                </select>
	                            						</td>
	                            					</tr>
	                                                <tr  style="width: 100%;">
	                            						<td >Número de solicitud: </td>
	                            						<td colspan="3">
	                            							<input id="numeroSolicitud" type="text" name="numeroSolicitud" value="" >
	                            						</td>
	                            					</tr>
                                                    <tr  style="width: 100%;">
	                            						<td >Estado Solicitud: </td>
	                            						<td colspan="3">
                                                            <select style="width: 100%;" id="estadoSolicitud" name= "estadoSolicitud" >
        		                                              <option value="">Seleccione...</option>
        		                                              <option value="Creado">Creado</option>
        		                                              <option value="pago">Asiganción de pago</option>
        		                                              <option value="verificacion">Verificación de pago</option>
                                                              <option value="inspeccion">Revisión técnica</option>
                                                              <option value="asignadoInspeccion">Asignado revisión técnica</option>
                                                              <option value="subsanacion">Subsanación</option>
                                                              <option value="Aprobado">Aprobado</option>
                                                              <option value="Rechazado">Rechazado</option>
        	                                                </select>
	                            						</td>
	                            					</tr>
	                            					<tr  style="width: 100%;">
	                            						<td >Identificador: </td>
	                            						<td colspan="3">
	                            							<input class="validacion" id="identificador" type="text" name="identificador" value="" >
	                            						</td>
	                            					</tr>
                                                    <tr  style="width: 100%;">
	                            						<td >Fecha: </td>
	                            						<td colspan="3">
	                            							<input id="fecha" type="text" name="fecha" value="" readonly>
	                            						</td>
	                            					</tr>
                            						<td colspan="4" style="text-align: end;">
                            							<button id="btnFiltrar">Filtrar lista</button>
                            						</td>
                            					</tr>
                            				</tbody>
                            			</table>';
    }

    public function filtrarInformacion()
    {
        $estado = 'EXITO';
        $mensaje = '';
        $contenido = '';
        $modeloSolicitudesProductos = array();
        $tipo = $_POST['tipo'];

        $arrayParametros = array(
            'identificador' => $this->identificador,
            'numeroSolicitud' => $_POST['numeroSolicitud'],
            'estadoSolicitud' => $_POST['estadoSolicitud'],
            'fecha' => $_POST['fecha'],
            'idArea' => '',
        );

        if ($tipo === 'verSolicitud') {
            $arrayParametros = array(
                'idArea' => $_POST['idArea'],
                'identificador' => $_POST['identificador'],
                'numeroSolicitud' => $_POST['numeroSolicitud'],
                'estadoSolicitud' => $_POST['estadoSolicitud'],
                'fecha' => $_POST['fecha'],
            );
        }

        $modeloSolicitudesProductos = $this->lNegocioSolicitudesProductos->obtenerSolicitudesProductos($arrayParametros);

        if ($modeloSolicitudesProductos->count() == 0) {
            $estado = 'FALLO';
            $mensaje = 'No existen registros para la busqueda.';
        }

        $this->tablaHtmlSolicitudesProductos($modeloSolicitudesProductos, $tipo);
        $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
        echo json_encode(array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'contenido' => $contenido));

    }

    public function verSolicitud()
    {
        $this->cargarPanelVerSolicitudes();
        require APP . 'ModificacionProductoRia/vistas/listaVerSolicitudesProductosVista.php';
    }

}
