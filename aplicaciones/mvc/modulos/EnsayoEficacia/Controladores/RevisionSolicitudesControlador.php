<?php
/**
 * Controlador Revision Solicitudes
 *
 * Este archivo controla la lógica del negocio del modelo: SolicitudesModelo y Vistas
 *
 * @author AGROCALIDAD
 * @date   2021-08-23
 * @uses RevisionSolicitudesControlador
 * @package RevisionSolicitudes
 * @subpackage Controladores
 */

namespace Agrodb\EnsayoEficacia\Controladores;

use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;
use Agrodb\EnsayoEficacia\Modelos\OrganismosInspeccionLogicaNegocio;
use Agrodb\EnsayoEficacia\Modelos\ResultadosEnsayoLogicaNegocio;
use Agrodb\EnsayoEficacia\Modelos\SolicitudesLogicaNegocio;
use Agrodb\GUath\Modelos\FichaEmpleadoLogicaNegocio;
use Agrodb\RevisionFormularios\Modelos\AsignacionCoordinadorLogicaNegocio;
use Agrodb\RevisionFormularios\Modelos\AsignacionInspectorLogicaNegocio;
use Agrodb\Usuarios\Modelos\UsuariosLogicaNegocio;
use Agrodb\Usuarios\Modelos\UsuariosPerfilesLogicaNegocio;

class RevisionSolicitudesControlador extends BaseControlador
{
    private $lNegocioSolicitudes = null;
    private $lNegocioUsuariosPerfiles = null;
    private $lNegocioAsignacionCoordinador = null;
    private $lNegocioAsignacionInspector = null;
    private $lNegocioOrganismosInspeccion = null;
    private $lNegocioResultadosEnsayo = null;
    private $lNegocioUsuario = null;
    private $lNegocioFichaEmpleado = null;
    private $pestania = null;
    private $accion = null;
    private $datosGenerales = null;
    private $comboPerfilRevision = null;
    private $rutaFecha = null;


    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioSolicitudes = new SolicitudesLogicaNegocio();
        $this->lNegocioUsuariosPerfiles = new UsuariosPerfilesLogicaNegocio();
        $this->lNegocioAsignacionCoordinador = new AsignacionCoordinadorLogicaNegocio();
        $this->lNegocioAsignacionInspector = new AsignacionInspectorLogicaNegocio();
        $this->lNegocioOrganismosInspeccion = new OrganismosInspeccionLogicaNegocio();
        $this->lNegocioResultadosEnsayo = new ResultadosEnsayoLogicaNegocio();
        $this->lNegocioUsuario = new UsuariosLogicaNegocio();
        $this->lNegocioFichaEmpleado = new FichaEmpleadoLogicaNegocio();
        $this->rutaFecha = date('Y') . '/' . date('m') . '/' . date('d');

        set_exception_handler(array(
            $this,
            'manejadorExcepciones'));
    }

    /**
     * Método de inicio del controlador
     */
    public function asignarSolicitudes()
    {
        $this->cargarPanelBusquedaSolicitud();

        $arrayParametros = array(
            'identificador' => '',
            'nombreProducto' => '',
            'numeroSolicitud' => '',
            'fecha' => '',
            'estadoSolicitud' => "'inspeccion', 'asignadoInspeccion','inspeccionResultado'"
        );

        $solicitudesModificacion = $this->lNegocioSolicitudes->buscarSolicitudesEnsayoEficacia($arrayParametros);
        $this->tablaHtmlSolicitudes($solicitudesModificacion);
        require APP . 'EnsayoEficacia/vistas/listaRevisionSolicitudesVista.php';
    }

    /**
     * Método de inicio del controlador
     */
    public function atenderRevisionTecnica()
    {
        $this->cargarPanelBusquedaSolicitud();

        $arrayParametros = array(
            'identificador' => '',
            'nombreProducto' => '',
            'numeroSolicitud' => '',
            'fecha' => '',
            'identificadorRevisorTecnico' => $this->usuarioActivo(),
            'estadoSolicitud' => "'asignadoInspeccion'"
        );

        $solicitudesModificacion = $this->lNegocioSolicitudes->buscarSolicitudesEnsayoEficacia($arrayParametros);
        $this->tablaHtmlSolicitudesPorAtender($solicitudesModificacion);
        require APP . 'EnsayoEficacia/vistas/listaAtenderSolicitudesVista.php';
    }

    /**
     * Desplegar la lista de solicitudes de producto
     */
    public function listarSolicitudes()
    {
        $estado = 'EXITO';
        $mensaje = '';
        $contenido = '';

        $arrayParametros = array(
            'identificador' => '',
            'nombreProducto' => $_POST['nombreProducto'],
            'numeroSolicitud' => $_POST['numeroSolicitud'],
            'fecha' => $_POST['fecha'],
            'estadoSolicitud' => "'inspeccion', 'asignadoInspeccion'"
        );

        $solicitudesModificacion = $this->lNegocioSolicitudes->buscarSolicitudesEnsayoEficacia($arrayParametros);

        if ($solicitudesModificacion->count()) {
            $this->tablaHtmlSolicitudes($solicitudesModificacion);
            $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
        } else {
            $contenido = \Zend\Json\Json::encode('');
            $mensaje = 'No existen registros';
            $estado = 'FALLO';
        }

        echo json_encode(array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'contenido' => $contenido));
    }

    /**
     * Desplegar la lista de solicitudes de producto
     */
    public function listarSolicitudesPorAtender()
    {
        $estado = 'EXITO';
        $mensaje = '';
        $contenido = '';

        $arrayParametros = array(
            'identificador' => '',
            'nombreProducto' => $_POST['nombreProducto'],
            'numeroSolicitud' => $_POST['numeroSolicitud'],
            'fecha' => $_POST['fecha'],
            'identificadorRevisorTecnico' => $this->usuarioActivo(),
            'estadoSolicitud' => "'asignadoInspeccion'"
        );

        $solicitudesModificacion = $this->lNegocioSolicitudes->buscarSolicitudesEnsayoEficacia($arrayParametros);

        if ($solicitudesModificacion->count()) {
            $this->tablaHtmlSolicitudesPorAtender($solicitudesModificacion);
            $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
        } else {
            $contenido = \Zend\Json\Json::encode('');
            $mensaje = 'No existen registros';
            $estado = 'FALLO';
        }

        echo json_encode(array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'contenido' => $contenido));
    }

    /**
     * Construye el código HTML para desplegar la lista de - Solicitudes productos
     */
    public function tablaHtmlSolicitudes($tabla)
    {
        $contador = 0;
        foreach ($tabla as $fila) {
            $tipoSolicitud = $this->tipoSolicitud($fila['tipo_solicitud']);
            $tipoProducto = $this->tipoProducto($fila['tipo_producto']);
            $estado = $this->estado($fila['estado']);
            $identificadorRevisor = $fila['identificador_revisor_resultado'] ?? $fila['identificador_revisor_tecnico'] ?? '';
            if($identificadorRevisor){
                $identificadorRevisor = $this->lNegocioUsuario->buscarUsuarioInterno(['identificador' => $identificadorRevisor, 'clave' => '']);
            }
            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_solicitud'] . '"
							  class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'EnsayoEficacia\RevisionSolicitudes"
							  data-opcion="asignarTecnico" ondragstart="drag(event)" draggable="true"
							  data-destino="detalleItem">
							  <td>' . ++$contador . '</td>
							  <td>' . $tipoSolicitud . '</td>
                              <td>' . $tipoProducto . '</td>
                              <td>' . $fila['producto'] . '</td>
                              <td>' . $fila['razon_social'] . '</td>
                              <td>' . $estado . '</td>
                              <td>' . ( $identificadorRevisor ? $identificadorRevisor->current()->nombre : '') . '</td>
					</tr>');
        }
    }

    /**
     * Construye el código HTML para desplegar la lista de - Solicitudes productos revision
     */
    public function tablaHtmlSolicitudesPorAtender($tabla)
    {
        $contador = 0;
        foreach ($tabla as $fila) {
            $tipoSolicitud = $this->tipoSolicitud($fila['tipo_solicitud']);
            $tipoProducto = $this->tipoProducto($fila['tipo_producto']);

            switch ($fila['estado']) {
                case 'asignadoInspeccion':
                    $pagina = 'revisarSolicitudTecnico';
                    break;
                case 'inspeccionResultado':
                    $pagina = 'revisarSolicitudResultado';
                    break;
            }

            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_solicitud'] . '"
							  class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'EnsayoEficacia\RevisionSolicitudes"
							  data-opcion="' . $pagina . '" ondragstart="drag(event)" draggable="true"
							  data-destino="detalleItem">
							  <td>' . ++$contador . '</td>
							  <td>' . $fila['numero_solicitud'] . '</td>
							  <td>' . $tipoSolicitud . '</td>
                              <td>' . $tipoProducto . '</td>
                              <td>' . $fila['producto'] . '</td>
                              <td>' . $fila['razon_social'] . '</td>
					</tr>');
        }
    }

    public function asignarTecnico()
    {
        $idSolicitud = explode(',', ($_POST['id'] === '_asignar' ? $_POST['elementos'] : $_POST['id']));
        $this->datosGenerales = '';

        foreach ($idSolicitud as $solicitud) {
            $this->modeloSolicitudes = $this->lNegocioSolicitudes->buscar($solicitud);
            $identificador = $this->modeloSolicitudes->getIdentificadorOperador();

            $operador = $this->lNegocioSolicitudes->obtenerDatosOperador($identificador);

            $this->datosGenerales .= $this->datosGeneralesOperador($operador);
            $this->datosGenerales .= $this->datosSolicitud($this->modeloSolicitudes);
            $this->datosGenerales .= $this->datosAdicionalesEnsayoEficacia($this->modeloSolicitudes);
            $this->datosGenerales .= $this->documentosAdjuntos($this->modeloSolicitudes);
            $this->datosGenerales .= '<hr><br>';
        }

        $arrayParametros = array(
            'idSolicitud' => $idSolicitud,
            'tipoSolicitud' => 'ensayoEficacia',
            'tipoInspector' => 'Técnico');

        $this->desplegarDetalleRevisoresAsignados($arrayParametros);
        $this->cargarTecnicosAsigancionRevisionFormularios();

        require APP . 'EnsayoEficacia/vistas/formularioRevisionSolicitudesVista.php';

    }

    /**
     * Metodo para cargar el combo de asignacion de tecnicos
     */
    public function cargarTecnicosAsigancionRevisionFormularios()
    {
        $perfil = "('PFL_TEC_ENSA_EFI')";

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
        $asignante = $this->usuarioActivo();
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

                $datosSolicitud = $this->lNegocioSolicitudes->buscar($solicitud);
                $numeroSolicitud = $datosSolicitud->getNumeroSolicitud();
                $provinciaOperador = $datosSolicitud->getProvinciaOperador();

                if ($datosSolicitud->getEstado() == 'inspeccion') {
                    $arrayParametrosAsignacion = array(
                        'id_solicitud' => $solicitud,
                        'estado' => 'asignadoInspeccion',
                        'identificador_revisor_tecnico' => $revisorAsignado,
                        'identificador_revisor_resultado' => '',
                    );
                }

                if ($datosSolicitud->getEstado() == 'inspeccionResultado') {
                    $arrayParametrosAsignacion = array(
                        'id_solicitud' => $solicitud,
                        'estado' => 'inspeccionResultado',
                        'identificador_revisor_resultado' => $revisorAsignado,
                        'identificador_revisor_tecnico' => ''
                    );
                }

                $this->lNegocioSolicitudes->actualizarEstadoEnsayoEficacia($arrayParametrosAsignacion);

                $arrayParametrosFila = array(
                    'id_asignacion_coordinador' => $procesoValidacion,
                    'numero_solicitud' => $numeroSolicitud,
                    'provincia_operador' => $provinciaOperador,
                    'nombre_inspector_asignado' => $nombreRevisorAsignado,
                    'id_solicitud' => $solicitud,
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
        $idSolicitud = $arrayParametros['id_solicitud'];
        $provinciaOperador = $arrayParametros['provincia_operador'];

        $this->listaRevisorAsignado = '
                        <tr id="fila' . $idAsignacionCoordinador . '">
                            <td>' . $numeroSolicitud . '</td>
                            <td>' . $nombreInspectorAsignado . '</td>
                            <td>' . $provinciaOperador . '</td>
                            <td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarDetalleRevisorAsignado(' . $idAsignacionCoordinador . ', ' . $idSolicitud . '); return false;"/></td>
                        </tr>';

        return $this->listaRevisorAsignado;
    }

    /**
     * Método para borrar una fila de un revisor asignado
     */
    public function eliminarAsignacionRevisor()
    {
        $idAsignacionCordinador = $_POST['idAsignacionCoordinador'];
        $idSolicitud = $_POST['idSolicitud'];
        $this->lNegocioAsignacionCoordinador->borrar($idAsignacionCordinador);

        $datosSolicitud = $this->lNegocioSolicitudes->buscar($idSolicitud);

        if ($datosSolicitud->getEstado() == 'asignadoInspeccion') {
            $arrayParametros = array(
                'id_solicitud' => $idSolicitud,
                'estado' => 'inspeccion',
                'identificador_revisor_tecnico' => 'null',
                'identificador_revisor_resultado' => '',
            );
        }

        if ($datosSolicitud->getEstado() == 'inspeccionResultado') {
            $arrayParametros = array(
                'id_solicitud' => $idSolicitud,
                'estado' => 'inspeccionResultado',
                'identificador_revisor_resultado' => 'null',
                'identificador_revisor_tecnico' => ''
            );
        }

        $this->lNegocioSolicitudes->actualizarEstadoEnsayoEficacia($arrayParametros);
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

                $datosSolicitud = $this->lNegocioSolicitudes->buscar($solicitud);
                $numeroSolicitud = $datosSolicitud->getNumeroSolicitud();
                $provinciaOperador = $datosSolicitud->getProvinciaOperador();
                $nombreRevisorAsignado = $procesoValidacion->current()->nombre_revisor;

                $arrayParametrosFila = array(
                    'id_asignacion_coordinador' => $procesoValidacion->current()->id_asignacion_coordinador,
                    'numero_solicitud' => $numeroSolicitud,
                    'provincia_operador' => $provinciaOperador,
                    'nombre_inspector_asignado' => $nombreRevisorAsignado,
                    'id_solicitud' => $solicitud,
                    'provincia_operador' => $provinciaOperador
                );

                $this->generarFilaRevisorAsignado .= $this->generarFilaRevisorAsignado($arrayParametrosFila);
            }
        }

        $this->generarFilaRevisorAsignado;
    }

    public function revisarSolicitudTecnico()
    {
        $idSolicitud = $_POST['id'];

        $this->modeloSolicitudes = $this->lNegocioSolicitudes->buscar($idSolicitud);

        $identificador = $this->modeloSolicitudes->getIdentificadorOperador();

        $operador = $this->lNegocioSolicitudes->obtenerDatosOperador($identificador);

        $this->datosGenerales .= $this->datosGeneralesOperador($operador);
        $this->datosGenerales .= $this->datosSolicitud($this->modeloSolicitudes);
        $this->datosGenerales .= $this->datosAdicionalesEnsayoEficacia($this->modeloSolicitudes);
        $this->datosGenerales .= $this->documentosAdjuntos($this->modeloSolicitudes);

        $this->datosGenerales .= '<hr><br>';

        require APP . 'EnsayoEficacia/vistas/formularioAtenderSolicitudesVista.php';
    }

    public function guardarProcesoRevisionTecnica()
    {
        $idSolicitud = $_POST['id_solicitud'];
        $resultado = $_POST['resultado'];
        $observacion = $_POST['observacion'];
        $rutaResultadoRevision = $_POST['informeRevision'];
        $identificadorRevisorTecnico = $this->usuarioActivo();

        $arrayParametrosResultado = array(
            'id_solicitud' => $idSolicitud,
            'estado' => $resultado,
            'estado_anterior' => 'asignadoInspeccion',
            'observacion_revisor_tecnico' => $observacion,
            'ruta_revisor_tecnico' => $rutaResultadoRevision,
            'identificador_revisor_resultado' => $identificadorRevisorTecnico,
            'observacion_revisor_resultado' => '',
            'ruta_informe_uno' => '',
            'ruta_informe_dos' => '',
            'resultado_revisor_tecnico' => ($resultado === 'organismoInspeccion' ? 'aprobado' : $resultado),
            'resultado_revisor_resultado' => ''
        );

        $this->lNegocioSolicitudes->actualizarEstadoRevisionEnsayoEficacia($arrayParametrosResultado);

        $arrayRevisionSolicitudes = array(
            'identificador_inspector' => $identificadorRevisorTecnico,
            'fecha_asignacion' => 'now()',
            'identificador_asignante' => $identificadorRevisorTecnico,
            'tipo_solicitud' => 'modificacionProductoRia',
            'tipo_inspector' => 'Técnico',
            'id_operador_tipo_operacion' => 0,
            'id_historial_operacion' => 0,
            'id_solicitud' => $idSolicitud,
            'estado' => 'Técnico',
            'fecha_inspeccion' => 'now()',
            'observacion' => $observacion,
            'estado_siguiente' => $resultado,
            'orden' => 1,
            'ruta_archivo' => $rutaResultadoRevision
        );

        $this->lNegocioAsignacionInspector->guardar($arrayRevisionSolicitudes);

        Mensajes::exito(Constantes::GUARDADO_CON_EXITO);

    }

    /**
     * Método de inicio del controlador
     */
    public function atenderRevisionTecnicaResultados()
    {
        $this->cargarPanelBusquedaSolicitud();

        $arrayParametros = array(
            'identificador' => '',
            'nombreProducto' => '',
            'numeroSolicitud' => '',
            'fecha' => '',
            'identificadorRevisorResultado' => $this->usuarioActivo(),
            'estadoSolicitud' => "'inspeccionResultado'"
        );

        $solicitudesModificacion = $this->lNegocioSolicitudes->buscarSolicitudesEnsayoEficacia($arrayParametros);
        $this->tablaHtmlSolicitudesPorAtender($solicitudesModificacion);
        require APP . 'EnsayoEficacia/vistas/listaAtenderResultadoSolicitudesVista.php';
    }

    /**
     * Desplegar la lista de solicitudes de producto
     */
    public function listarSolicitudesResultadoPorAtender()
    {
        $estado = 'EXITO';
        $mensaje = '';
        $contenido = '';

        $arrayParametros = array(
            'identificador' => '',
            'nombreProducto' => $_POST['nombreProducto'],
            'numeroSolicitud' => $_POST['numeroSolicitud'],
            'fecha' => $_POST['fecha'],
            'identificadorRevisorResultado' => $this->usuarioActivo(),
            'estadoSolicitud' => "'inspeccionResultado'"
        );

        $solicitudesModificacion = $this->lNegocioSolicitudes->buscarSolicitudesEnsayoEficacia($arrayParametros);

        if ($solicitudesModificacion->count()) {
            $this->tablaHtmlSolicitudesPorAtender($solicitudesModificacion);
            $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
        } else {
            $contenido = \Zend\Json\Json::encode('');
            $mensaje = 'No existen registros';
            $estado = 'FALLO';
        }

        echo json_encode(array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'contenido' => $contenido));
    }

    public function revisarSolicitudResultado()
    {
        $idSolicitud = $_POST['id'];

        $this->modeloSolicitudes = $this->lNegocioSolicitudes->buscar($idSolicitud);

        $identificador = $this->modeloSolicitudes->getIdentificadorOperador();

        $operador = $this->lNegocioSolicitudes->obtenerDatosOperador($identificador);
        $datosEmpleado = $this->lNegocioFichaEmpleado->buscar($this->modeloSolicitudes->getIdentificadorRevisorTecnico());

        $this->datosGenerales .= $this->datosGeneralesOperador($operador);
        $this->datosGenerales .= $this->datosSolicitud($this->modeloSolicitudes);
        $this->datosGenerales .= $this->datosAdicionalesEnsayoEficacia($this->modeloSolicitudes);
        $this->datosGenerales .= $this->documentosAdjuntos($this->modeloSolicitudes);
        $this->datosGenerales .= $this->resultadoRevisionTecnica($this->modeloSolicitudes, $datosEmpleado);

        $organismoInspeccion = $this->lNegocioOrganismosInspeccion->buscarLista(['id_solicitud' => $idSolicitud]);
        $operadorOrganismo = $this->lNegocioSolicitudes->obtenerDatosOperador($organismoInspeccion->current()->identificador_organismo_inspeccion);
        $this->datosGenerales .= $this->datosOrganismoInspeccion($operadorOrganismo);

        $resultadoEnsayo = $this->lNegocioResultadosEnsayo->buscarLista(['id_solicitud' => $idSolicitud]);
        $datosResultadoEnsayo = $resultadoEnsayo->toArray();
        $this->datosGenerales .= $this->resultadoEnsayoEficacia($datosResultadoEnsayo[0], true, true);

        $this->datosGenerales .= '<hr><br>';

        require APP . 'EnsayoEficacia/vistas/formularioAtenderResultadoSolicitudesVista.php';
    }

    public function guardarProcesoRevisionResultado()
    {
        $idSolicitud = $_POST['id_solicitud'];
        $resultado = $_POST['resultado'];
        $observacion = $_POST['observacion'];
        $rutaInformeUno = $_POST['ruta_informe_uno'];
        $rutaInformeDos = $_POST['ruta_informe_dos'];
        $dirigidoA = $_POST['dirigido_a'];
        $identificadorRevisorResultado = $this->usuarioActivo();

        $arrayParametrosResultado = array(
            'id_solicitud' => $idSolicitud,
            'estado' => $resultado,
            'estado_anterior' => 'inspeccionResultado',
            'observacion_revisor_tecnico' => '',
            'ruta_revisor_tecnico' => '',
            'identificador_revisor_resultado' => '',
            'observacion_revisor_resultado' => $observacion,
            'ruta_informe_uno' => $rutaInformeUno,
            'ruta_informe_dos' => $rutaInformeDos,
            'resultado_revisor_tecnico' => '',
            'resultado_revisor_resultado' => $resultado
        );

        $this->lNegocioSolicitudes->actualizarEstadoRevisionEnsayoEficacia($arrayParametrosResultado);

        if($resultado == 'subsanacionResultado'){

            $arrayParametros = array(
                'id_solicitud' => $idSolicitud,
                'dirigido_a' => $dirigidoA
            );

            $this->lNegocioResultadosEnsayo->actualizarOperadorResultadosEnsayo($arrayParametros);

        }

        $arrayRevisionSolicitudes = array(
            'identificador_inspector' => $identificadorRevisorResultado,
            'fecha_asignacion' => 'now()',
            'identificador_asignante' => $identificadorRevisorResultado,
            'tipo_solicitud' => 'modificacionProductoRia',
            'tipo_inspector' => 'Técnico',
            'id_operador_tipo_operacion' => 0,
            'id_historial_operacion' => 0,
            'id_solicitud' => $idSolicitud,
            'estado' => 'Técnico',
            'fecha_inspeccion' => 'now()',
            'observacion' => $observacion,
            'estado_siguiente' => $resultado,
            'orden' => 1,
            'ruta_archivo' => $rutaInformeUno
        );

        $this->lNegocioAsignacionInspector->guardar($arrayRevisionSolicitudes);

        Mensajes::exito(Constantes::GUARDADO_CON_EXITO);

    }
}
