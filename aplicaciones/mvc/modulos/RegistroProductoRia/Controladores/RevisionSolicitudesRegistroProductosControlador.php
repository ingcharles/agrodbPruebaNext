<?php
/**
 * Controlador RevisionSolicitudesRegistroProductos
 *
 * Este archivo controla la lógica del negocio del modelo:  SolicitudesRegistroProductosModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-20
 * @uses    RevisionSolicitudesRegistroProductosControlador
 * @package RegistroProductoRia
 * @subpackage Controladores
 */

namespace Agrodb\RegistroProductoRia\Controladores;


use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;
use Agrodb\RegistroProductoRia\Modelos\SolicitudesRegistroProductosLogicaNegocio;
use Agrodb\RevisionFormularios\Modelos\AsignacionCoordinadorLogicaNegocio;
use Agrodb\RevisionFormularios\Modelos\AsignacionInspectorLogicaNegocio;
use Agrodb\Usuarios\Modelos\UsuariosPerfilesLogicaNegocio;

class RevisionSolicitudesRegistroProductosControlador extends BaseControlador
{
    private $lNegocioSolicitudesRegistroProductos = null;
    private $lNegocioUsuariosPerfiles = null;
    private $lNegocioAsignacionCoordinador = null;
    private $lNegocioAsignacionInspector = null;

    private $pestania = null;
    private $accion = null;
    private $datosGenerales = null;
    private $comboPerfilRevision = null;
    private $rutaFecha = null;
    private $resultadoRevision = null;
    private $tipoSolicitud = null;


    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioUsuariosPerfiles = new UsuariosPerfilesLogicaNegocio();
        $this->lNegocioAsignacionCoordinador = new AsignacionCoordinadorLogicaNegocio();
        $this->lNegocioAsignacionInspector = new AsignacionInspectorLogicaNegocio();
        $this->rutaFecha = date('Y') . '/' . date('m') . '/' . date('d');

        $this->lNegocioSolicitudesRegistroProductos = new SolicitudesRegistroProductosLogicaNegocio();
        set_exception_handler(array(
            $this,
            'manejadorExcepciones'));
    }

    /**
     * Método de inicio del controlador
     */
    public function asignarSolicitudes()
    {
        $this->cargarPanelSolicitudes('asignadoInspeccion', true);

        $arrayParametros = [
            'identificador' => '',
            'nombreProducto' => '',
            'estadoSolicitud' => "'asignadoInspeccion'",
            'numeroSolicitud' => '',
            'tipoSolicitud' => '',
            'fecha' => '',
            'identificador_revisor' => ''
        ];

        $modeloSolicitudesRegistroProductos = $this->lNegocioSolicitudesRegistroProductos->buscarFiltroSolicitudesRegistroProductos($arrayParametros);
        $this->tablaHtmlSolicitudesRegistroProductos($modeloSolicitudesRegistroProductos);
        require APP . 'RegistroProductoRia/vistas/listaRevisionSolicitudesRegistroProductosVista.php';
    }

    /**
     * Método de inicio del controlador
     */
    public function revisionTecnicaSolicitudes()
    {
        $this->tipoSolicitud = $this->tipoSolicitudPorOpcion($_POST['nombreOpcion']);

        $this->cargarPanelSolicitudes('asignadoInspeccion', true);

        $arrayParametros = [
            'identificador' => '',
            'nombreProducto' => '',
            'estadoSolicitud' => "'asignadoInspeccion'",
            'numeroSolicitud' => '',
            'tipoSolicitud' => $this->tipoSolicitud,
            'fecha' => '',
            'identificador_revisor' => $this->usuarioActivo()
        ];

        $modeloSolicitudesRegistroProductos = $this->lNegocioSolicitudesRegistroProductos->buscarFiltroSolicitudesRegistroProductos($arrayParametros);
        $this->tablaHtmlSolicitudesRegistroProductoPorAtender($modeloSolicitudesRegistroProductos);
        require APP . 'RegistroProductoRia/vistas/listaAtenderSolicitudesRegistroProductosVista.php';
    }

    /**
     * Desplegar la lista de solicitudes de producto
     */
    public function listarRegistroSolicitudesProductos()
    {
        $estado = 'EXITO';
        $mensaje = '';
        $arrayParametros = array(
            'identificador' => '',
            'nombreProducto' => $_POST['nombreProducto'],
            'estadoSolicitud' => ($_POST['estadoSolicitud'] ? "'" . $_POST['estadoSolicitud'] . "'" : ''),
            'numeroSolicitud' => '',
            'tipoSolicitud' => '',
            'fecha' => $_POST['fecha'],
            'identificador_revisor' => ''
        );

        $modeloSolicitudesRegistroProductos = $this->lNegocioSolicitudesRegistroProductos->buscarFiltroSolicitudesRegistroProductos($arrayParametros);

        if ($modeloSolicitudesRegistroProductos->count() == 0) {
            $estado = 'FALLO';
            $mensaje = 'No existen registros para la búsqueda.';
        }

        $this->tablaHtmlSolicitudesRegistroProductos($modeloSolicitudesRegistroProductos);
        $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
        echo json_encode(array(
                'estado' => $estado,
                'mensaje' => $mensaje,
                'contenido' => $contenido)
        );
    }

    /**
     * Desplegar la lista de solicitudes de producto
     */
    public function listarRegistroSolicitudesProductoPorAtender()
    {
        $estado = 'EXITO';
        $mensaje = '';
        $arrayParametros = array(
            'identificador' => '',
            'nombreProducto' => $_POST['nombreProducto'],
            'estadoSolicitud' => ($_POST['estadoSolicitud'] ? "'" . $_POST['estadoSolicitud'] . "'" : ''),
            'numeroSolicitud' => '',
            'tipoSolicitud' => $_POST['tipoSolicitud'],
            'fecha' => $_POST['fecha'],
            'identificador_revisor' => $this->usuarioActivo()
        );

        $modeloSolicitudesRegistroProductos = $this->lNegocioSolicitudesRegistroProductos->buscarFiltroSolicitudesRegistroProductos($arrayParametros);

        if ($modeloSolicitudesRegistroProductos->count() == 0) {
            $estado = 'FALLO';
            $mensaje = 'No existen registros para la búsqueda.';
        }

        $this->tablaHtmlSolicitudesRegistroProductoPorAtender($modeloSolicitudesRegistroProductos);
        $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
        echo json_encode(array(
                'estado' => $estado,
                'mensaje' => $mensaje,
                'contenido' => $contenido)
        );

    }

    /**
     * Construye el código HTML para desplegar la lista de - Solicitudes productos
     */
    public function tablaHtmlSolicitudesRegistroProductos($tabla)
    {
        $contador = 0;
        foreach ($tabla as $fila) {

            $estado = $this->estado($fila['estado']);
            $tipoSolicitud = $this->tipoSolicitud($fila['tipo_solicitud']);
            $fechaAproximada = isset($fila['fecha_confirmacion_pago']) ? date("d-m-Y", strtotime($fila['fecha_confirmacion_pago'] . "+ 1 month")) : '';


            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_solicitud_registro_producto'] . '"
		            class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia\RevisionSolicitudesRegistroProductos"
		            data-opcion="asignarTecnico" ondragstart="drag(event)" draggable="true"
		            data-destino="detalleItem">
		                <td>' . ++$contador . '</td>
		                <td>' . $fila['numero_solicitud'] . '</td>
                        <td>' . $tipoSolicitud . '</td>
                        <td>' . $fila['nombre_producto'] . '</td>
                        <td>' . $estado . '</td>
                        <td>' . $fila['nombre_revisor'] . '</td>
                        <td>' . $fechaAproximada . '</td>
                </tr>');
        }
    }

    /**
     * Construye el código HTML para desplegar la lista de - Solicitudes productos revision
     */
    public function tablaHtmlSolicitudesRegistroProductoPorAtender($tabla)
    {
        $contador = 0;
        foreach ($tabla as $fila) {

            $estado = $this->estado($fila['estado']);
            $tipoSolicitud = $this->tipoSolicitud($fila['tipo_solicitud']);
            $fechaAproximada = isset($fila['fecha_confirmacion_pago']) ? date("d-m-Y", strtotime($fila['fecha_confirmacion_pago'] . "+ 1 month")) : '';

            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_solicitud_registro_producto'] . '"
		            class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia\RevisionSolicitudesRegistroProductos"
		            data-opcion="revisarSolicitudRegistroProductoTecnico" ondragstart="drag(event)" draggable="true"
		            data-destino="detalleItem">
		                <td>' . ++$contador . '</td>
		                <td>' . $fila['numero_solicitud'] . '</td>
                        <td>' . $tipoSolicitud . '</td>
                        <td>' . $fila['nombre_producto'] . '</td>
                        <td>' . $estado . '</td>
                        <td>' . $fila['nombre_revisor'] . '</td>
                        <td>' . $fechaAproximada . '</td>
                </tr>');
        }
    }

    public function asignarTecnico()
    {
        $idSolicitudRegistroProducto = explode(',', ($_POST['id'] === '_asignar' ? $_POST['elementos'] : $_POST['id']));

        foreach ($idSolicitudRegistroProducto as $solicitud) {
            $datosSolicitudRegistroProducto = $this->lNegocioSolicitudesRegistroProductos->buscar($solicitud);

            $identificadorOperador = $datosSolicitudRegistroProducto->getIdentificadorOperador();
            $this->tipoSolicitud = $datosSolicitudRegistroProducto->getTipoSolicitud();

            $operador = $this->lNegocioSolicitudesRegistroProductos->obtenerDatosOperador($identificadorOperador);
            $this->datosGenerales .= $this->datosGeneralesOperador($operador);

            $this->datosGenerales .= $this->datosProductoRegistro($datosSolicitudRegistroProducto, $this->tipoSolicitud);

            $this->datosGenerales .= '<hr><br>';
        }

        $arrayParametros = array(
            'idSolicitud' => $idSolicitudRegistroProducto,
            'tipoSolicitud' => 'registroProductoRia',
            'tipoInspector' => 'Técnico');

        $this->desplegarDetalleRevisoresAsignados($arrayParametros);
        $this->cargarTecnicosAsigancionRevisionFormularios($this->tipoSolicitud);

        require APP . 'RegistroProductoRia/vistas/formularioRevisionSolicitudesRegistroProductosVista.php';

    }

    /**
     * Metodo para cargar el combo de asignacion de tecnicos
     */
    public function cargarTecnicosAsigancionRevisionFormularios($tipoSolicitud)
    {
        $perfil = "('".$this->tipoSolicitudPorPerfil($tipoSolicitud)."')";

        $arrayParametros = array(
            'codigo_perfil' => $perfil);

        $tecnicosAsignacion = $this->lNegocioUsuariosPerfiles->buscarUsuariosInternosPorPerfil($arrayParametros);

        foreach ($tecnicosAsignacion as $item) {
            $this->comboPerfilRevision .= '<option value="' . $item->identificador . '" >' . $item->nombre . ' ' . $item->apellido . '</option>';
        }

        $this->comboPerfilRevision;
    }

    /**
     * Método para registrar en la base de datos el técnico asignado
     */
    public function guardarAsignacionRevisor()
    {
        $revisorAsignado = $_POST['revisorAsignado'];
        $nombreRevisorAsignado = $_POST['nombreRevisorAsignado'];
        $asignante = $_SESSION['usuario'];
        $idSolicitud = $_POST['idSolicitud'];
        $tipoSolicitud = $_POST['tipoSolicitud'];
        $tipoInspector = $_POST['tipoInspector'];

        $filaRevisorAsignado = "";
        $banderaRegistro = false;

        $validacion = "Fallo";
        $resultado = "La solicitud solo puede ser asignada a un técnico a la vez.";

        $arraySolicitudes = explode(",", $idSolicitud);

        foreach ($arraySolicitudes as $solicitud) {

            $arrayParametros = array(
                'identificador_inspector' => $revisorAsignado,
                'fecha_asignacion' => 'now()',
                'identificador_asignante' => $asignante,
                'id_solicitud' => $solicitud,
                'tipo_solicitud' => $tipoSolicitud,
                'tipo_inspector' => $tipoInspector);

            $procesoValidacion = $this->lNegocioAsignacionCoordinador->guardar($arrayParametros);

            if ($procesoValidacion) {

                $banderaRegistro = true;

                $arrayParametrosAsignacion = array(
                    'id_solicitud_registro_producto' => $solicitud,
                    'estado' => 'asignadoInspeccion',
                    'identificador_revisor' => $revisorAsignado);

                $this->lNegocioSolicitudesRegistroProductos->actualizarEstadoSolictudRegistroProducto($arrayParametrosAsignacion);

                $datosSolicitud = $this->lNegocioSolicitudesRegistroProductos->buscar($solicitud);
                $numeroSolicitud = $datosSolicitud->getNumeroSolicitud();
                $provinciaOperador = $datosSolicitud->getProvinciaOperador();

                $arrayParametrosFila = array(
                    'id_asignacion_coordinador' => $procesoValidacion,
                    'numero_solicitud' => $numeroSolicitud,
                    'provincia_operador' => $provinciaOperador,
                    'nombre_inspector_asignado' => $nombreRevisorAsignado,
                    'id_solicitud_registro_producto' => $solicitud,
                    'provincia_operador' => $provinciaOperador
                );

                $filaRevisorAsignado .= $this->generarFilaRevisorAsignado($arrayParametrosFila);
            } else {
                break;
            }
        }

        if ($banderaRegistro) {

            $validacion = "Exito";
            $resultado = "";

            echo json_encode(array(
                'validacion' => $validacion,
                'resultado' => $resultado,
                'filaRevisorAsignado' => $filaRevisorAsignado));
        } else {

            echo json_encode(array(
                'validacion' => $validacion,
                'resultado' => $resultado));
        }
    }

    /**
     * Método para agregar una fila del revisor asignado a una solicitud.
     */
    public function generarFilaRevisorAsignado($arrayParametros)
    {
        $idAsignacionCoordinador = $arrayParametros['id_asignacion_coordinador'];
        $numeroSolicitud = $arrayParametros['numero_solicitud'];
        $nombreInspectorAsignado = $arrayParametros['nombre_inspector_asignado'];
        $idSolicitudRegistroProducto = $arrayParametros['id_solicitud_registro_producto'];
        $provinciaOperador = $arrayParametros['provincia_operador'];

        $this->listaRevisorAsignado = '
                        <tr id="fila' . $idAsignacionCoordinador . '">
                            <td>' . $numeroSolicitud . '</td>
                            <td>' . $nombreInspectorAsignado . '</td>
                            <td>' . $provinciaOperador . '</td>
                            <td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarDetalleRevisorAsignado(' . $idAsignacionCoordinador . ', ' . $idSolicitudRegistroProducto . '); return false;"/></td>
                        </tr>';

        return $this->listaRevisorAsignado;
    }

    /**
     * Método para borrar una fila de un revisor asignado
     */
    public function eliminarAsignacionRevisor()
    {
        $idAsignacionCordinador = $_POST['idAsignacionCoordinador'];
        $this->lNegocioAsignacionCoordinador->borrar($idAsignacionCordinador);

        $arrayParametros = array(
            'id_solicitud_registro_producto' => $_POST['idSolicitudRegistroProducto'],
            'estado' => 'inspeccion',
            'identificador_revisor' => null
        );

        $this->lNegocioSolicitudesRegistroProductos->actualizarEstadoSolictudRegistroProducto($arrayParametros);
    }

    /**
     * Método para listar los revisaores asignadasos a una solicitud de proveedor en el exterior
     */
    public function desplegarDetalleRevisoresAsignados($arrayParametros)
    {
        $arraySolicitudes = $arrayParametros['idSolicitud'];
        $tipoSolicitud = $arrayParametros['tipoSolicitud'];
        $tipoInspector = $arrayParametros['tipoInspector'];

        $this->generarFilaRevisorAsignado = "";

        foreach ($arraySolicitudes as $solicitud) {

            $arrayParametros = array(
                'id_solicitud' => $solicitud,
                'tipo_solicitud' => $tipoSolicitud,
                'tipo_inspector' => $tipoInspector);

            $procesoValidacion = $this->lNegocioAsignacionCoordinador->buscarAsignacionCoordinador($arrayParametros);

            if (isset($procesoValidacion->current()->id_asignacion_coordinador)) {

                $datosSolicitudRegistroProducto = $this->lNegocioSolicitudesRegistroProductos->buscar($solicitud);

                $numeroSolicitud = $datosSolicitudRegistroProducto->getNumeroSolicitud();
                $provinciaOperador = $datosSolicitudRegistroProducto->getProvinciaOperador();
                $nombreRevisorAsignado = $procesoValidacion->current()->nombre_revisor;

                $arrayParametrosFila = array(
                    'id_asignacion_coordinador' => $procesoValidacion->current()->id_asignacion_coordinador,
                    'numero_solicitud' => $numeroSolicitud,
                    'provincia_operador' => $provinciaOperador,
                    'nombre_inspector_asignado' => $nombreRevisorAsignado,
                    'id_solicitud_registro_producto' => $solicitud,
                    'provincia_operador' => $provinciaOperador
                );

                $this->generarFilaRevisorAsignado .= $this->generarFilaRevisorAsignado($arrayParametrosFila);
            }
        }

        $this->generarFilaRevisorAsignado;
    }

    public function revisarSolicitudRegistroProductoTecnico()
    {
        $idSolicitudRegistroProducto = $_POST['id'];
        $this->numeroPestania = (isset($_POST['numero_pestania'])) ? $_POST['numero_pestania'] : null;
		$datoOrigen = "Tecnico";

        $datosSolicitudesRegistroProductos = $this->lNegocioSolicitudesRegistroProductos->buscar($idSolicitudRegistroProducto);

        $identificadorOperador = $datosSolicitudesRegistroProductos->getIdentificadorOperador();
        $tipoSolicitud = $datosSolicitudesRegistroProductos->getTipoSolicitud();

        $operador = $this->lNegocioSolicitudesRegistroProductos->obtenerDatosOperador($identificadorOperador);
        $this->datosGenerales = $this->datosGeneralesOperador($operador);

        $solicitudesRegistroProductoControlador = new SolicitudesRegistroProductosControlador();
        
        $this->pestania = $solicitudesRegistroProductoControlador->cargarSolicitud($idSolicitudRegistroProducto, $tipoSolicitud, $datoOrigen);

        $this->resultadoRevisionTecnica($idSolicitudRegistroProducto);

        require APP . 'RegistroProductoRia/vistas/formularioAtenderSolicitudesRegistroProductosVista.php';
    }

    public function resultadoRevisionTecnica($idSolicitudRegistroProducto)
    {
        $this->resultadoRevision = ' 
            <form id="resuladoRevisionTecnica" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia" data-opcion="RevisionSolicitudesRegistroProductos/guardarProcesoRevisionTecnica" data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
                <input type="hidden" id="id_solicitud_registro_producto" name="id_solicitud_registro_producto" value="' . $idSolicitudRegistroProducto . '" />
                <fieldset  id="fResuladoRevisionTecnica">
                    <legend>Resultado revisión técnica</legend>
                    <div data-linea="3">
                        <label>Resultado: </label>
                        <select id="resultado_revisor" name="resultado_revisor" class="validacion">
                            <option value="">Seleccione....</option>
                            <option value="aprobado">Aprobar</option>
                            <option value="rechazado">Rechazar</option>
                            <option value="subsanacion">Subsanar</option>
                        </select>
                    </div>
                    <label>Observación: </label>
                    <div data-linea="24">
                        <textarea name="observacion_revisor" rows="3" maxlength="1000" class="validacion"></textarea>
                    </div>
                    <label>Cargar informe: </label>
                    <div data-linea="5">
                        <input type="hidden" class="rutaArchivo" id="ruta_revisor" name="ruta_revisor" value="0"/>
                        <input type="file" class="archivo validacion" id="v_ruta_revisor" accept="application/pdf" />
                        <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . 'B)</div>
                        <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                    </div>  
                </fieldset>
                
                <div data-linea="6">
                    <button id="guardarResultado" type="submit" class="guardar">Enviar resultado</button>
                </div>
            </form> ';
    }

    public function guardarProcesoRevisionTecnica()
    {
        $idSolicitudRegistroProducto = $_POST['id_solicitud_registro_producto'];
        $resultadoRevisor = $_POST['resultado_revisor'];
        $observacionRevisor = $_POST['observacion_revisor'];
        $rutaRevisor = $_POST['ruta_revisor'];
        $identificadorRevisor = $this->usuarioActivo();
        $rutaCertificado = '';

        if($resultadoRevisor === 'aprobado'){
            $rutaCertificado = $this->lNegocioSolicitudesRegistroProductos->guardarDatosProducto($idSolicitudRegistroProducto, $rutaRevisor);
        }

        $datos = [
            'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
            'estado' => $resultadoRevisor,
            'identificador_revisor' => $identificadorRevisor,
            'observacion_revisor' => $observacionRevisor,
            'ruta_revisor' => $rutaRevisor,
            'ruta_certificado' => $rutaCertificado
        ];

        $this->lNegocioSolicitudesRegistroProductos->actualizarDatosRevisionTecnica($datos);

        $arrayRevisionSolicitudes = array(
            'identificador_inspector' => $identificadorRevisor,
            'fecha_asignacion' => 'now()',
            'identificador_asignante' => $identificadorRevisor,
            'tipo_solicitud' => 'registroProductoRia',
            'tipo_inspector' => 'Técnico',
            'id_operador_tipo_operacion' => 0,
            'id_historial_operacion' => 0,
            'id_solicitud' => $idSolicitudRegistroProducto,
            'estado' => 'Técnico',
            'fecha_inspeccion' => 'now()',
            'observacion' => $observacionRevisor,
            'estado_siguiente' => $resultadoRevisor,
            'orden' => 1,
            'ruta_archivo' => $rutaRevisor
        );

        $this->lNegocioAsignacionInspector->guardar($arrayRevisionSolicitudes);
        Mensajes::exito(Constantes::GUARDADO_CON_EXITO);
    }
}
