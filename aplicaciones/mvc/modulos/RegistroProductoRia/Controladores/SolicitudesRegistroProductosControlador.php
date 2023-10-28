<?php
/**
 * Controlador SolicitudesRegistroProductos
 *
 * Este archivo controla la lógica del negocio del modelo:  SolicitudesRegistroProductosModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-20
 * @uses    SolicitudesRegistroProductosControlador
 * @package RegistroProductoRia
 * @subpackage Controladores
 */

namespace Agrodb\RegistroProductoRia\Controladores;

use Agrodb\Catalogos\Modelos\FormulacionLogicaNegocio;
use Agrodb\Catalogos\Modelos\ProductosInocuidadLogicaNegocio;
use Agrodb\Catalogos\Modelos\SubtipoProductosLogicaNegocio;
use Agrodb\Catalogos\Modelos\TipoProductosLogicaNegocio;
use Agrodb\Financiero\Modelos\OrdenPagoLogicaNegocio;
use Agrodb\GUath\Modelos\DatosContratoLogicaNegocio;
use Agrodb\GUath\Modelos\FichaEmpleadoLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\CodigosComplementariosSuplementariosLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\CodigosComplementariosSuplementariosPlaguicidasBioLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\ComposicionesLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\FabricantesFormuladoresLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\ManufacturadoresPlaguicidasBioLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\PresentacionesLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\PresentacionesPlaguicidasBioLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\SolicitudesRegistroProductosLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\SolicitudesRegistroProductosModelo;
use Agrodb\RegistroProductoRia\Modelos\UsosLogicaNegocio;
use Agrodb\Catalogos\Modelos\CategoriaToxicologicaLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\PartidasArancelariasPlaguicidasBioLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\UsosProductosPlaguicidasBioLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\EnsayosEficaciaPlaguicidasBioLogicaNegocio;
use Agrodb\EnsayoEficacia\Modelos\SolicitudesLogicaNegocio;

class SolicitudesRegistroProductosControlador extends BaseControlador
{

    private $lNegocioSolicitudesRegistroProductos = null;
    private $lNegocioTipoProductos = null;
    private $lNegocioFormulacion = null;
    private $modeloSolicitudesRegistroProductos = null;

    private $lNegocioSubtipoProducto = null;
    private $lNegocioComposiciones = null;
    private $lNegocioCodigoComplementarioSuplementario = null;
    private $lNegocioPresentaciones = null;
    private $lNegocioFabricantesFormuladores = null;
    private $lNegocioManufacturadores = null;
    private $lNegocioUsos = null;
    private $lNegocioOrdenPago = null;
    private $lNegocioFichaEmpleado = null;
    private $lNegocioDatosContrato = null;

    private $lNegocioCategoriaToxicologica = null;
    private $lNegocioPartidasArancelariasPlaguicidasBio = null;
    private $lNegocioCodigoComplementariosSuplementariosBioplaguicidas = null;
    private $lNegocioPresentacionesBioplaguicidas = null;

    private $lNegocioUsosProductosPlaguicidasBio = null;
    private $lNegocioEnsayoEficacia = null;
    private $lNegocioEnsayosEficaciaPlaguicidasBio = null;

    private $lNegocioProductoInocuidad = null;

    private $accion = null;

    private $datosGenerales = null;
    private $pestania = null;
    private $rutaFecha = null;
    private $tipoSolicitud = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioSolicitudesRegistroProductos = new SolicitudesRegistroProductosLogicaNegocio();
        $this->modeloSolicitudesRegistroProductos = new SolicitudesRegistroProductosModelo();

        $this->lNegocioTipoProductos = new TipoProductosLogicaNegocio();
        $this->lNegocioFormulacion = new FormulacionLogicaNegocio();
        $this->lNegocioSubtipoProducto = new SubtipoProductosLogicaNegocio();
        $this->lNegocioComposiciones = new ComposicionesLogicaNegocio();
        $this->lNegocioCodigoComplementarioSuplementario = new CodigosComplementariosSuplementariosLogicaNegocio();
        $this->lNegocioPresentaciones = new PresentacionesLogicaNegocio();
        $this->lNegocioFabricantesFormuladores = new FabricantesFormuladoresLogicaNegocio();
        $this->lNegocioManufacturadores = new ManufacturadoresPlaguicidasBioLogicaNegocio();
        $this->lNegocioUsos = new UsosLogicaNegocio();
        $this->lNegocioOrdenPago = new OrdenPagoLogicaNegocio();
        $this->lNegocioFichaEmpleado = new FichaEmpleadoLogicaNegocio();
        $this->lNegocioDatosContrato = new DatosContratoLogicaNegocio();
        $this->lNegocioCategoriaToxicologica = new CategoriaToxicologicaLogicaNegocio();
        $this->lNegocioPartidasArancelariasPlaguicidasBio = new PartidasArancelariasPlaguicidasBioLogicaNegocio();
        $this->lNegocioCodigoComplementariosSuplementariosBioplaguicidas = new CodigosComplementariosSuplementariosPlaguicidasBioLogicaNegocio();
        $this->lNegocioPresentacionesBioplaguicidas = new PresentacionesPlaguicidasBioLogicaNegocio();
        $this->lNegocioUsosProductosPlaguicidasBio = new UsosProductosPlaguicidasBioLogicaNegocio();
        $this->lNegocioEnsayoEficacia = new SolicitudesLogicaNegocio();
        $this->lNegocioEnsayosEficaciaPlaguicidasBio = new EnsayosEficaciaPlaguicidasBioLogicaNegocio();
        $this->lNegocioProductoInocuidad = new ProductosInocuidadLogicaNegocio();
        $this->rutaFecha = date('Y') . '/' . date('m') . '/' . date('d');
        $this->numeroPestania = null;
        $this->idSolicitudRegistroProducto = null;
        $this->idPartidaArancelaria = null;

        set_exception_handler(array($this, 'manejadorExcepciones'));
    }

    /**
     * Método de inicio del controlador
     */
    public function index()
    {
        $this->cargarPanelSolicitudes();

        $arrayParametros = [
            'identificador' => $this->usuarioActivo(),
            'nombreProducto' => '',
            'estadoSolicitud' => '',
            'numeroSolicitud' => '',
            'tipoSolicitud' => '',
            'fecha' => '',
            'identificador_revisor' => ''
        ];

        $modeloSolicitudesRegistroProductos = $this->lNegocioSolicitudesRegistroProductos->buscarFiltroSolicitudesRegistroProductos($arrayParametros);
        $this->tablaHtmlSolicitudesRegistroProductos($modeloSolicitudesRegistroProductos);
        require APP . 'RegistroProductoRia/vistas/listaSolicitudesRegistroProductosVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nueva solicitud de registro de producto";
        $identificador = $this->usuarioActivo();
        $operador = $this->lNegocioSolicitudesRegistroProductos->obtenerDatosOperador($identificador);
        $this->datosGenerales = $this->datosGeneralesOperador($operador);
        require APP . 'RegistroProductoRia/vistas/formularioSolicitudesRegistroProductosVista.php';
    }

    /**
     * Método para registrar en la base de datos -SolicitudesRegistroProductos
     */
    public function guardar()
    {
        $estado = 'exito';
        $mensaje = '';

        $identificador = $this->usuarioActivo();
        $operador = $this->lNegocioSolicitudesRegistroProductos->obtenerDatosOperador($identificador);

        $_POST['identificador_operador'] = $operador->getIdentificador();
        $_POST['razon_social'] = $operador->getRazonSocial();
        $_POST['representante_legal'] = $operador->getNombreRepresentante() . ' ' . $operador->getApellidoRepresentante();
        $_POST['direccion'] = $operador->getDireccion();
        $_POST['telefono'] = $operador->getTelefonoUno() === '' ? $operador->getTelefonoDos() : $operador->getTelefonoUno();
        $_POST['correo'] = $operador->getCorreo();
        $_POST['representante_tecnico'] = $operador->getNombreTecnico() . ' ' . $operador->getApellidoTecnico();
        $_POST['provincia_operador'] = $operador->getProvincia();

        $idSolicitudRegistroProducto = $this->lNegocioSolicitudesRegistroProductos->guardar($_POST);

        echo json_encode(array(
            "estado" => $estado,
            "mensaje" => $mensaje,
            "contenido" => $idSolicitudRegistroProducto
        ));
    }

    /**
     *Obtenemos los datos del registro seleccionado para editar - Tabla: SolicitudesRegistroProductos
     */
    public function editar()
    {
        $this->accion = "Solicitud de registro de producto";
        $idSolicitud = $_POST['id'];
        $this->numeroPestania = (isset($_POST['numero_pestania'])) ? $_POST['numero_pestania'] : null;
        $this->modeloSolicitudesRegistroProductos = $this->lNegocioSolicitudesRegistroProductos->buscar($idSolicitud);
        $datoOrigen = "Operador";
        $tipoOpcion = $_POST['nombreOpcion'] ?? '';

        $identificador = $this->modeloSolicitudesRegistroProductos->getIdentificadorOperador();
        $idSolicitudRegistroProducto = null;
        $tipoSolicitud = $this->modeloSolicitudesRegistroProductos->getTipoSolicitud();

        $operador = $this->lNegocioSolicitudesRegistroProductos->obtenerDatosOperador($identificador);
        $this->datosGenerales = $this->datosGeneralesOperador($operador);
        $this->tipoSolicitud = $tipoSolicitud;

        $datosConsultaFinanciero = [
            'id_solicitud' => $idSolicitud,
            'tipo_solicitud' => 'registroProductoRia',
            'estado' => 3
        ];

        if ($this->modeloSolicitudesRegistroProductos->getEstado() === 'verificacion') {
            $financiero = $this->lNegocioOrdenPago->buscarLista($datosConsultaFinanciero);
            $datosFinanciero = $financiero->toArray();
            $this->datosGenerales .= $this->datosFinancieroRegistroProducto($datosFinanciero[0]);
        }

        if ($this->modeloSolicitudesRegistroProductos->getIdentificadorRevisor()) {
            $fichaEmpleado = $this->lNegocioFichaEmpleado->buscar($this->modeloSolicitudesRegistroProductos->getIdentificadorRevisor());
            $contrato = $this->lNegocioDatosContrato->buscarLista(['identificador' => $this->modeloSolicitudesRegistroProductos->getIdentificadorRevisor(), 'estado' => 1]);
            $contratoEmpleado = $contrato->toArray();
            $this->datosGenerales .= $this->datosTecnicoAsigando($fichaEmpleado, $contratoEmpleado[0]);
        }

        if ($this->modeloSolicitudesRegistroProductos->getResultadoRevisor()) {
            $datosRevisor = [
                'resultado_revisor' => $this->modeloSolicitudesRegistroProductos->getResultadoRevisor(),
                'observacion_revisor' => $this->modeloSolicitudesRegistroProductos->getObservacionRevisor(),
                'ruta_revisor' => $this->modeloSolicitudesRegistroProductos->getRutaRevisor(),
                'ruta_certificado' => $this->modeloSolicitudesRegistroProductos->getRutaCertificado()
            ];
            $this->datosGenerales .= $this->datosResultadoRevision($datosRevisor);
        }

        $this->cargarSolicitud($idSolicitudRegistroProducto, $tipoSolicitud, $datoOrigen, $tipoOpcion);

        require APP . 'RegistroProductoRia/vistas/formularioEditarSolicitudesRegistroProductosVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - SolicitudesRegistroProductos
     */
    public function borrar()
    {
        $idSolicitud = $_POST['elementos'];
        $identificador = $this->usuarioActivo();

        $this->modeloSolicitudesRegistroProductos = $this->lNegocioSolicitudesRegistroProductos->buscar($idSolicitud);
        if ($this->modeloSolicitudesRegistroProductos->getEstado() === 'creado') {
            $operador = $this->lNegocioSolicitudesRegistroProductos->obtenerDatosOperador($identificador);
            $this->datosGenerales = $this->datosGeneralesOperador($operador);
            $this->datosGenerales .= '<fieldset>
                                            <legend>Solicitud</legend>
                                            <div data-linea="1">
                                                <label for="id_tipo_producto">Tipo de solicitud: </label> ' . $this->tipoSolicitud($this->modeloSolicitudesRegistroProductos->getTipoSolicitud()) . '
                                            </div>
                                            <div data-linea="2">
                                                <label for="id_tipo_producto">Número de solicitud: </label> ' . $this->modeloSolicitudesRegistroProductos->getNumeroSolicitud() . '
                                            </div>
                                        </fieldset>';

            require APP . 'RegistroProductoRia/vistas/formularioEliminarSolicitudesRegistroProductosVista.php';
        } else {
            echo 'Solo es posible eliminar solicitudes en estado Creado';
        }
    }

    public function eliminar()
    {
        $idSolicitud = $_POST['id_solicitud'];

        $this->lNegocioSolicitudesRegistroProductos->borrar($idSolicitud);
        echo json_encode(array(
                'estado' => 'exito',
                'mensaje' => 'Registro eliminado exitosamente')
        );
    }

    /**
     * Construye el código HTML para desplegar la lista de - SolicitudesRegistroProductos
     */
    public function tablaHtmlSolicitudesRegistroProductos($tabla, $tipo = false)
    {
        $contador = 0;

        if($tipo){
            $tipo = 'verSolicitud';
        }else{
            $tipo = '';
        }

        foreach ($tabla as $fila) {
            $estado = $this->estado($fila['estado']);
            $tipoSolicitud = $this->tipoSolicitud($fila['tipo_solicitud']);
            $tiempo = $this->tipoSolicitudTiempo($fila['tipo_solicitud']);
            $fechaAproximada = isset($fila['fecha_confirmacion_pago']) ? date("d-m-Y", strtotime($fila['fecha_confirmacion_pago'] . $tiempo)) : '';

            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_solicitud_registro_producto'] . '"
		            class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia\SolicitudesRegistroProductos"
		            data-opcion="editar" ondragstart="drag(event)" draggable="true"
		            data-destino="detalleItem" data-nombre="' . $tipo . '">
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

    public function filtrarSolicitudesRegistroProducto()
    {
        $estado = 'EXITO';
        $mensaje = '';
        $tipo = isset($_POST['tipo']);
        $arrayParametros = array(
            'identificador' => $this->usuarioActivo(),
            'nombreProducto' => $_POST['nombreProducto'],
            'estadoSolicitud' => ($_POST['estadoSolicitud'] ? "'" . $_POST['estadoSolicitud'] . "'" : ''),
            'numeroSolicitud' => '',
            'tipoSolicitud' => '',
            'fecha' => $_POST['fecha'],
            'identificador_revisor' => ''
        );

        if($tipo){
            $arrayParametros = array(
                'identificador' => $_POST['identificador'],
                'nombreProducto' => $_POST['nombreProducto'],
                'estadoSolicitud' => ($_POST['estadoSolicitud'] ? "'" . $_POST['estadoSolicitud'] . "'" : ''),
                'numeroSolicitud' => '',
                'tipoSolicitud' => '',
                'fecha' => $_POST['fecha'],
                'identificador_revisor' => ''
            );
        }

        $modeloSolicitudesRegistroProductos = $this->lNegocioSolicitudesRegistroProductos->buscarFiltroSolicitudesRegistroProductos($arrayParametros);

        if ($modeloSolicitudesRegistroProductos->count() == 0) {
            $estado = 'FALLO';
            $mensaje = 'No existen registros para la búsqueda.';
        }

        $this->tablaHtmlSolicitudesRegistroProductos($modeloSolicitudesRegistroProductos, $tipo);
        $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
        echo json_encode(array(
                'estado' => $estado,
                'mensaje' => $mensaje,
                'contenido' => $contenido)
        );
    }

    public function cargarSolicitud($idSolicitudRegistroProducto, $tipoSolicitud, $datoOrigen, $tipoOpcion = '')
    {
        if ($idSolicitudRegistroProducto) {
            $this->modeloSolicitudesRegistroProductos = $this->lNegocioSolicitudesRegistroProductos->buscar($idSolicitudRegistroProducto);
        }

        if($tipoOpcion){
            $this->modeloSolicitudesRegistroProductos->setEstado('verSolicitud');
        }

        if ($tipoSolicitud === 'fertilizantes') {
            return $this->cargarPestanasProductoFertilizantes($tipoSolicitud);
        }

        if ($tipoSolicitud === 'bioplaguicidas') {
            return $this->cargarPestanasProductoBioplaguicidas($tipoSolicitud, $datoOrigen);
        }

        if ($tipoSolicitud === 'clonesfertilizantes' || $tipoSolicitud === 'clonesplaguicidas') {
            return $this->cargarPestanasProductoClones($tipoSolicitud);
        }
    }

    private function solicitudProductoFertilizantes($parametros, $estado)
    {
        $formularioProducto = '';
        $tipoSolicitud = $parametros['tipo_solicitud'];

        switch ($estado) {
            case 'creado':
            case 'subsanacion':

                $tipoProducto = '';
                $idSolicitudRegistroProducto = $parametros['id_solicitud_registro_producto'];
                $idArea = $parametros['id_area'];

                foreach ($this->lNegocioTipoProductos->buscarTipoProductoXArea($idArea) as $item) {
                    if ($this->modeloSolicitudesRegistroProductos->getIdTipoProducto() === $item->id_tipo_producto) {
                        $tipoProducto .= '<option value="' . $item->id_tipo_producto . '" selected>' . $item->nombre . '</option>';
                    } else {
                        $tipoProducto .= '<option value="' . $item->id_tipo_producto . '">' . $item->nombre . '</option>';
                    }

                }

                $formulacion = '';
                $qFormulacion = $this->lNegocioFormulacion->buscarFormulacionesXFiltro(['estado_formulacion' => 'Activo', 'id_area' => $idArea]);

                foreach ($qFormulacion as $item) {
                    if ($this->modeloSolicitudesRegistroProductos->getIdFormulacion() === $item->id_formulacion) {
                        $formulacion .= '<option value="' . $item->id_formulacion . '" selected>' . $item->formulacion . '</option>';
                    } else {
                        $formulacion .= '<option value="' . $item->id_formulacion . '">' . $item->formulacion . '</option>';
                    }
                }

                $formularioProducto =
                    '<form id="productoSolicitud" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia" data-opcion="SolicitudesRegistroProductos/guardarDatosProducto" data-destino="detalleItem" method="post">
                        <input type="hidden" id="id_solicitud_registro_producto" name="id_solicitud_registro_producto" value="' . $idSolicitudRegistroProducto . '" />
                        <input type="hidden" id="tipo_solicitud" name="tipo_solicitud" value="' . $this->modeloSolicitudesRegistroProductos->getTipoSolicitud() . '" />
                        <fieldset>
                            <legend>Producto</legend>
                            <div data-linea="1">
                                <label for="id_tipo_producto">Tipo de solicitud: </label> ' . $this->tipoSolicitud($this->modeloSolicitudesRegistroProductos->getTipoSolicitud()) . '
                            </div>
                            <div data-linea="2">
                                <label for="id_tipo_producto">Tipo de producto: </label>
                                <select name="id_tipo_producto" id="id_tipo_producto" class="validacion">
                                    <option value="">Seleccionar....</option>
                                    ' . $tipoProducto . '
                                </select>
                                <input type="hidden" name="nombre_tipo_producto" id="nombre_tipo_producto" value="' . $this->modeloSolicitudesRegistroProductos->getNombreTipoProducto() . '"/>
                            </div>
                            <div data-linea="3">
                                <label for="id_subtipo_producto">Subtipo de producto: </label>
                                <select name="id_subtipo_producto" id="id_subtipo_producto" class="validacion">
                                    <option value="">Seleccionar....</option>
                                    ' . $this->obtenerSubtipoProductoPorIdTipoProductoEditar() . '
                                </select>
                                <input type="hidden" name="nombre_subtipo_producto" id="nombre_subtipo_producto" value="' . $this->modeloSolicitudesRegistroProductos->getNombreSubtipoProducto() . '"/>
                            </div>
                            <div data-linea="4">
                                <label for="nombre_producto">Nombre de producto: </label>
                                <input type="text" name="nombre_producto" id="nombre_producto" class="validacion" value="' . $this->modeloSolicitudesRegistroProductos->getNombreProducto() . '"/>
                            </div>
                            <div data-linea="5">
                                <label for="partida_arancelaria">Partida arancelaria: </label>
                                <input name="partida_arancelaria" id="partida_arancelaria" type="text"  class="validacion" value="' . $this->modeloSolicitudesRegistroProductos->getPartidaArancelaria() . '"/>
                            </div>
                        </fieldset>
                        
                        <fieldset>
                            <legend>Características</legend>
                            <div data-linea="1">
                                <label for="id_formulacion">Formulación: </label>
                                <select name="id_formulacion" id="id_formulacion" class="validacion">
                                    <option value="">Seleccionar....</option>
                                    ' . $formulacion . '
                                </select>
                                <input type="hidden" name="nombre_formulacion" id="nombre_formulacion" value="' . $this->modeloSolicitudesRegistroProductos->getNombreFormulacion() . '"/>
                            </div>
                            <div data-linea="2">
                                <label for="dosis">Dosis: </label>
                                <input name="dosis" id="dosis" type="text" maxlength="1024" class="validacion" value="' . $this->modeloSolicitudesRegistroProductos->getDosis() . '"/>
                            </div>
                            <div data-linea="2">
                                <label for="unidad_dosis">Unidad de dosis: </label>
                                <select id="unidad_dosis" name="unidad_dosis" class="validacion">
                                    <option value="">Seleccionar....</option>
                                        ' . $this->comboUnidadesMedida($this->modeloSolicitudesRegistroProductos->getUnidadDosis()) . '
                                </select>
                            </div>
                            <div data-linea="3">
                                <label for="periodo_reingreso">Período de reingreso/vida útil: </label>
                                <input type="text" id="periodo_reingreso" name="periodo_reingreso" class="validacion" value="' . $this->modeloSolicitudesRegistroProductos->getPeriodoReingreso() . '"/>
                            </div>
                        </fieldset>
                        <div data-linea="15">
                            <button type="submit" class="guardar">Guardar</button>
                        </div>
                    </form>';
                break;
            default:
                $formularioProducto = $this->datosProductoRegistro($this->modeloSolicitudesRegistroProductos, $tipoSolicitud);
        }

        return $formularioProducto;


    }

    private function cargarPestanasProductoFertilizantes($tipoSolicitud)
    {
        $estado = $this->modeloSolicitudesRegistroProductos->getEstado();
        $parametros = [
            'id_area' => 'IAF',
            'id_solicitud_registro_producto' => $this->modeloSolicitudesRegistroProductos->getIdSolicitudRegistroProducto(),
            'tipo_solicitud' => $tipoSolicitud
        ];

        $this->pestania = '<div class="pestania">';
        $this->pestania .= $this->solicitudProductoFertilizantes($parametros, $estado);
        $this->pestania .= '</div>';

        $this->pestania .= '<div class="pestania">';
        $composicionControlador = new ComposicionesControlador();
        $this->pestania .= $composicionControlador->crearComposicionProducto($parametros, $estado);
        $this->pestania .= '</div>';

        $this->pestania .= '<div class="pestania">';
        $codigoComplementarioSuplementarioControlador = new CodigosComplementariosSuplementariosControlador();
        $this->pestania .= $codigoComplementarioSuplementarioControlador->crearCodigoComplementarioSuplementarioProducto($parametros, $estado);
        $this->pestania .= '</div>';

        $this->pestania .= '<div class="pestania">';
        $presentacionesController = new PresentacionesControlador();
        $this->pestania .= $presentacionesController->crearPresentacionProducto($parametros, $estado);
        $this->pestania .= '</div>';

        $this->pestania .= '<div class="pestania">';
        $fabricanteFormuladorController = new FabricantesFormuladoresControlador();
        $this->pestania .= $fabricanteFormuladorController->crearFabricanteFormuladorProducto($parametros, $estado);
        $this->pestania .= '</div>';

        $this->pestania .= '<div class="pestania">';
        $usoController = new UsosControlador();
        $this->pestania .= $usoController->crearUsoProducto($parametros, $estado);
        $this->pestania .= '</div>';

        $this->pestania .= '<div class="pestania">';
        $this->pestania .= $this->anexosFertilizantes($parametros, $estado);
        $this->pestania .= '</div>';

        return $this->pestania;
    }

    private function anexosFertilizantes($parametros, $estado)
    {

        $documentoProducto = '';
        $idSolicitudRegistroProducto = $parametros['id_solicitud_registro_producto'];

        switch ($estado) {
            case 'creado':
            case 'subsanacion':
                $documentoProducto = '
                <form id="finalizarSolicitud" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia" data-opcion="SolicitudesRegistroProductos/guardarFinalizarSolicitud" data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
                    <input type="hidden" id="id_solicitud_registro_producto" name="id_solicitud_registro_producto" value="' . $idSolicitudRegistroProducto . '" />
                    
                    <fieldset>
                        <legend>Observación</legend>
                        <div data-linea="1">
                            <input type="text" name="observacion_operador" id="observacion_operador">
                        </div>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Anexos</legend>
                        <div data-linea="1">
                            <label>Certificado de composición y Vida útil: </label>
                        </div>
                        <div data-linea="2">
                            <input type="hidden" class="rutaArchivo" id="ruta_composicion_vida_util" name="ruta_composicion_vida_util" value="0"/>
                            <input type="file" class="archivo validacion" id="archivo_ruta_composicion_vida_util" accept="application/pdf" />
                            <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                            <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                        </div>
                        
                        <div data-linea="3">
                            <label>Análisis de laboratorio: </label>
                        </div>
                        <div data-linea="4">
                            <input type="hidden" class="rutaArchivo" id="ruta_analisis_laboratorio" name="ruta_analisis_laboratorio" value="0"/>
                            <input type="file" class="archivo validacion" id="archivo_ruta_analisis_laboratorio" accept="application/pdf" />
                            <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                            <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                        </div>
                        
                        <div data-linea="5">
                            <label>Etiqueta: </label>
                        </div>
                        <div data-linea="6">
                            <input type="hidden" class="rutaArchivo" id="ruta_etiqueta" name="ruta_etiqueta" value="0"/>
                            <input type="file" class="archivo validacion" id="archivo_ruta_etiqueta" accept="application/pdf" />
                            <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                            <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                        </div>
                        
                        <div data-linea="7">
                            <label>Otros: </label>
                        </div>
                        <div data-linea="8">
                            <input type="hidden" class="rutaArchivo" id="ruta_otros" name="ruta_otros" value="0"/>
                            <input type="file" class="archivo" id="archivo_ruta_otros" accept="application/pdf" />
                            <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                            <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                        </div>';
                if ($estado != 'subsanacion') {
                    $documentoProducto .= '<hr/>
                        <div data-linea="9">
                            <label><input type="checkbox" id="requiere_descuento" name="requiere_descuento" value="Si"> Requiere descuento</label>
                        </div>
                        <div data-linea="10">
                            <label><input type="checkbox" id="pago_ensayo_eficacia" name="pago_ensayo_eficacia" value="Si"> Pago realizado en Ensayo de eficacia</label>
                        </div>';
                }

                $documentoProducto .= '</fieldset>
                    <div data-linea="15">
                        <button type="submit" class="guardar">Enviar solicitud</button>
                    </div>
                </form>';
                break;
            default:

                $documentoComposicionVidaUtil = $this->modeloSolicitudesRegistroProductos->getRutaComposicionVidaUtil() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $this->modeloSolicitudesRegistroProductos->getRutaComposicionVidaUtil() . ' target="_blank" class="archivo_cargado">Archivo Cargado</a>';
                $documentoAnalisisLaboratorio = $this->modeloSolicitudesRegistroProductos->getRutaAnalisisLaboratorio() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $this->modeloSolicitudesRegistroProductos->getRutaAnalisisLaboratorio() . ' target="_blank" class="archivo_cargado">Archivo Cargado</a>';
                $documentoEtiqueta = $this->modeloSolicitudesRegistroProductos->getRutaEtiqueta() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $this->modeloSolicitudesRegistroProductos->getRutaEtiqueta() . ' target="_blank" class="archivo_cargado">Archivo Cargado</a>';
                $documentoOtros = $this->modeloSolicitudesRegistroProductos->getRutaOtros() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $this->modeloSolicitudesRegistroProductos->getRutaOtros() . ' target="_blank" class="archivo_cargado">Archivo Cargado</a>';
                $requiereDescuento = $this->modeloSolicitudesRegistroProductos->getRequiereDescuento() ? 'Si' : 'No';
				$pagoEnsayoEficacia = $this->modeloSolicitudesRegistroProductos->getPagoEnsayoEficacia() ? 'Si' : 'No';

                $documentoProducto = '
                    <fieldset>
                        <legend>Observación</legend>
                        <span>' . $this->modeloSolicitudesRegistroProductos->getObservacionOperador() . '</span>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Anexos</legend>
                        <div data-linea="1">
                            <label>Certificado de composición y Vida útil: </label> ' . $documentoComposicionVidaUtil . '
                        </div>
                        
                        <div data-linea="3">
                            <label>Análisis de laboratorio: </label> ' . $documentoAnalisisLaboratorio . '
                        </div>
                        
                        <div data-linea="5">
                            <label>Etiqueta: </label> ' . $documentoEtiqueta . '
                        </div>
                        
                        <div data-linea="7">
                            <label>Otros: </label> ' . $documentoOtros . '
                        </div>
                        
                        <hr/>
                        
                        <div data-linea="9">
                            <label>Requiere descuento: </label> ' . $requiereDescuento . '
                        </div>
						
						<div data-linea="10">
                            <label>Pago realizado en Ensayo de eficacia: </label> ' . $pagoEnsayoEficacia . '
                        </div>
                    </fieldset>';
        }

        return $documentoProducto;
    }

    public function obtenerSubtipoProductoPorIdTipoProducto()
    {
        $idTipoProducto = $_POST['id_tipo_producto'];
        $tipoSolicitud = $_POST['tipo_solicitud'];
        $comboSubtipoProducto = '<option value="">Seleccionar....</option>';

        switch ($tipoSolicitud) {
            case 'clonesfertilizantes':
            case 'clonesplaguicidas':
                $datos = [
                    'id_tipo_producto' => $idTipoProducto,
                    'estado' => 1,
                    'identificador_operador' => $this->usuarioActivo()
                ];

                $subtipoProducto = $this->lNegocioProductoInocuidad->obtenerSubtipoProductoXOperadorAreaEstado($datos);

                foreach ($subtipoProducto as $item) {
                    $comboSubtipoProducto .= '<option value="' . $item->id_subtipo_producto . '">' . $item->nombre . '</option>';
                }

                break;
            default:
                $query = "estado = 1 and id_tipo_producto = $idTipoProducto order by nombre ASC";

                $subtipoProducto = $this->lNegocioSubtipoProducto->buscarLista($query);

                foreach ($subtipoProducto as $item) {
                    $comboSubtipoProducto .= '<option value="' . $item->id_subtipo_producto . '">' . $item->nombre . '</option>';
                }
        }

        echo json_encode(array(
            'estado' => 'EXITO',
            'comboSubtipoProducto' => $comboSubtipoProducto
        ));
    }

    public function obtenerSubtipoProductoPorIdTipoProductoEditar($tipoSolicitud = null)
    {

        if (!$this->modeloSolicitudesRegistroProductos->getIdSubtipoProducto()) {
            return;
        }

        $idTipoProducto = $this->modeloSolicitudesRegistroProductos->getIdTipoProducto();

        $comboSubtipoProducto = '';

        switch ($tipoSolicitud) {
            case 'clonesfertilizantes':
            case 'clonesplaguicidas':
                $datos = [
                    'id_tipo_producto' => $idTipoProducto,
                    'estado' => 1,
                    'identificador_operador' => $this->usuarioActivo()
                ];

                $subtipoProducto = $this->lNegocioProductoInocuidad->obtenerSubtipoProductoXOperadorAreaEstado($datos);

                foreach ($subtipoProducto as $item) {
                    if ($this->modeloSolicitudesRegistroProductos->getIdSubtipoProducto() === $item->id_subtipo_producto) {
                        $comboSubtipoProducto .= '<option value="' . $item->id_subtipo_producto . '" selected>' . $item->nombre . '</option>';
                    } else {
                        $comboSubtipoProducto .= '<option value="' . $item->id_subtipo_producto . '">' . $item->nombre . '</option>';
                    }
                }
                break;
            default:
                $query = "estado = 1 and id_tipo_producto = $idTipoProducto order by nombre ASC";

                $subtipoProducto = $this->lNegocioSubtipoProducto->buscarLista($query);

                foreach ($subtipoProducto as $item) {
                    if ($this->modeloSolicitudesRegistroProductos->getIdSubtipoProducto() === $item->id_subtipo_producto) {
                        $comboSubtipoProducto .= '<option value="' . $item->id_subtipo_producto . '" selected>' . $item->nombre . '</option>';
                    } else {
                        $comboSubtipoProducto .= '<option value="' . $item->id_subtipo_producto . '">' . $item->nombre . '</option>';
                    }

                }
        }

        return $comboSubtipoProducto;
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
            $comboProducto .= '<option value="' . $item->id_producto . '" data-numeroregistro="' . $item->numero_registro . '" data-categoriatoxicologica="' . $item->categoria_toxicologica . '">' . $item->nombre_comun . '</option>';
        }

        echo json_encode(array(
            'estado' => 'EXITO',
            'comboProducto' => $comboProducto
        ));
    }

    public function obtenerProductoPorIdSubTipoProductoEditar()
    {

        if (!$this->modeloSolicitudesRegistroProductos->getIdSubtipoProducto()) {
            return;
        }

        $idSubTipoProducto = $this->modeloSolicitudesRegistroProductos->getIdSubtipoProducto();

        $comboProducto = '';

        $datos = [
            'id_subtipo_producto' => $idSubTipoProducto,
            'estado' => 1,
            'identificador_operador' => $this->usuarioActivo()
        ];

        $producto = $this->lNegocioProductoInocuidad->obtenerProductoXOperadorAreaEstado($datos);

        foreach ($producto as $item) {
            if ($this->modeloSolicitudesRegistroProductos->getIdProducto() === $item->id_producto) {
                $comboProducto .= '<option value="' . $item->id_producto . '" data-numeroregistro="' . $item->numero_registro . '" data-categoriatoxicologica="' . $item->categoria_toxicologica . '" selected>' . $item->nombre_comun . '</option>';
            } else {
                $comboProducto .= '<option value="' . $item->id_producto . '" data-numeroregistro="' . $item->numero_registro . '" data-categoriatoxicologica="' . $item->categoria_toxicologica . '">' . $item->nombre_comun . '</option>';
            }
        }

        return $comboProducto;
    }

    public function guardarDatosProducto()
    {
        $estado = 'exito';
        $mensaje = '';

        $idSolicitudRegistroProducto = $this->lNegocioSolicitudesRegistroProductos->guardar($_POST);

        echo json_encode(array(
            "estado" => $estado,
            "mensaje" => $mensaje,
            "contenido" => $idSolicitudRegistroProducto
        ));
    }

    public function guardarFinalizarSolicitud()
    {
        $estado = 'exito';
        $mensaje = '';
        $idSolicitudRegistroProducto = $_POST['id_solicitud_registro_producto'];

        $datosRegistroProducto = $this->lNegocioSolicitudesRegistroProductos->buscar($idSolicitudRegistroProducto);

        $validarFormulario = $this->validarFormulario($idSolicitudRegistroProducto, $datosRegistroProducto->getTipoSolicitud());

        if ($datosRegistroProducto->getNombreProducto() !== '' && $validarFormulario['validacion']) {
            if ($datosRegistroProducto->getResultadoRevisor() == 'subsanacion') {
                $_POST['estado'] = 'asignadoInspeccion';
                $_POST['fecha_confirmacion_pago'] = 'now()';
            } else {
                if(isset($_POST['pago_ensayo_eficacia'])){
                    $_POST['estado'] = 'asignadoInspeccion';
                }else{
                    $_POST['estado'] = 'pago';
                }
                $_POST['requiere_descuento'] = isset($_POST['requiere_descuento']) ? 'true' : 'false';
                $_POST['pago_ensayo_eficacia'] = isset($_POST['pago_ensayo_eficacia']) ? 'true' : 'false';
            }

            $idSolicitudRegistroProducto = $this->lNegocioSolicitudesRegistroProductos->guardar($_POST);
        } else {
            $estado = 'error';
            $mensaje = $validarFormulario['mensaje'] ?: 'Por favor ingrese datos para las características generales del producto';
        }

        echo json_encode(array(
            "estado" => $estado,
            "mensaje" => $mensaje,
            "contenido" => $idSolicitudRegistroProducto
        ));
    }

    public function validarFormulario($idSolicitudRegistroProducto, $tipoSolicitud)
    {
        $mensaje = null;

        $datos = [
            'id_solicitud_registro_producto' => $idSolicitudRegistroProducto
        ];

        switch ($tipoSolicitud) {
            case 'fertilizantes':
                if (!$this->lNegocioCodigoComplementarioSuplementario->buscarLista($datos)->count()) {
                    return [
                        'validacion' => false,
                        'mensaje' => 'Por favor ingrese datos para la sección de códigos complementarios y suplementarios'
                    ];
                }

                if (!$this->lNegocioComposiciones->buscarLista($datos)->count()) {
                    return [
                        'validacion' => false,
                        'mensaje' => 'Por favor ingrese datos para la sección de composición'
                    ];
                }

                if (!$this->lNegocioPresentaciones->buscarLista($datos)->count()) {
                    return [
                        'validacion' => false,
                        'mensaje' => 'Por favor ingrese datos para la sección de presentaciones'
                    ];
                }

                if (!$this->lNegocioFabricantesFormuladores->buscarLista($datos)->count()) {
                    return [
                        'validacion' => false,
                        'mensaje' => 'Por favor ingrese datos para la sección fabricantes/formuladores'
                    ];
                }

                if (!$this->lNegocioUsos->buscarLista($datos)->count()) {
                    return [
                        'validacion' => false,
                        'mensaje' => 'Por favor ingrese datos para la sección uso autorizado'
                    ];
                }

                break;
            case 'bioplaguicidas':
                $partidaArancelaria = $this->lNegocioPartidasArancelariasPlaguicidasBio->buscarLista($datos);
                if (!$partidaArancelaria->count()) {
                    return [
                        'validacion' => false,
                        'mensaje' => 'Por favor ingrese datos para la sección de partida arancelaria'
                    ];
                }

                $datosPartida = [
                    'id_partida_arancelaria' => $partidaArancelaria->current()->id_partida_arancelaria
                ];

                $codigoComplementarioSuplementario = $this->lNegocioCodigoComplementariosSuplementariosBioplaguicidas->buscarLista($datosPartida);

                if (!$codigoComplementarioSuplementario->count()) {
                    return [
                        'validacion' => false,
                        'mensaje' => 'Por favor ingrese datos para la sección de códigos complementarios y suplementarios'
                    ];
                }

                $datosCodigoComplementarioSuplementario = [
                    'id_codigo_complementario_suplementario' => $codigoComplementarioSuplementario->current()->id_codigo_complementario_suplementario
                ];

                if (!$this->lNegocioPresentacionesBioplaguicidas->buscarLista($datosCodigoComplementarioSuplementario)->count()) {
                    return [
                        'validacion' => false,
                        'mensaje' => 'Por favor ingrese datos para la sección presentaciones'
                    ];
                }

                if (!$this->lNegocioComposiciones->buscarLista($datos)->count()) {
                    return [
                        'validacion' => false,
                        'mensaje' => 'Por favor ingrese datos para la sección de composición'
                    ];
                }

                $fabricanteFormulador = $this->lNegocioFabricantesFormuladores->buscarLista($datos);

                if (!$fabricanteFormulador->count()) {
                    return [
                        'validacion' => false,
                        'mensaje' => 'Por favor ingrese datos para la sección fabricantes/formuladores'
                    ];
                }

                /*$datosFabricanteFormulador = [
                    'id_fabricante_formulador' => $fabricanteFormulador->current()->id_fabricante_formulador
                ];

                if (!$this->lNegocioManufacturadores->buscarLista($datosFabricanteFormulador)->count()) {
                    return [
                        'validacion' => false,
                        'mensaje' => 'Por favor ingrese datos para la sección de manufacturador'
                    ];
                }*/

                if (!$this->lNegocioUsosProductosPlaguicidasBio->buscarLista($datos)->count()) {
                    return [
                        'validacion' => false,
                        'mensaje' => 'Por favor ingrese datos para la sección de uso autorizado'
                    ];
                }

                break;
        }

        return [
            'validacion' => true,
            'mensaje' => $mensaje
        ];
    }

    public function guardarDetalleSolicitud()
    {
        $idSolicitudRegistroProducto = $_POST['id_solicitud_registro_producto'];
        $tipo = ucfirst($_POST['tipo']);

        $validacion = "";
        $resultado = "Datos ingresados con exito";

        switch ($tipo) {
            case "Composicion":

                $idIngredienteActivo = $_POST['id_ingrediente_activo'];
                $ingredienteActivo = $_POST['ingrediente_activo'];
                $idTipoComponente = $_POST['id_tipo_componente'];
                $tipoComponente = $_POST['tipo_componente'];
                $concentracion = $_POST['concentracion'];
                $unidadMedida = $_POST['unidad_medida'];

                $arrayParametros = array(
                    'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                    'id_ingrediente_activo' => $idIngredienteActivo,
                    'id_tipo_componente' => $idTipoComponente,
                    'concentracion' => $concentracion
                );

                $verificarComposicionProducto = $this->lNegocioComposiciones->buscarLista($arrayParametros);

                if (count($verificarComposicionProducto) === 0) {

                    $datosComposicionProducto = array(
                        'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                        'id_ingrediente_activo' => $idIngredienteActivo,
                        'ingrediente_activo' => $ingredienteActivo,
                        'id_tipo_componente' => $idTipoComponente,
                        'tipo_componente' => $tipoComponente,
                        'concentracion' => $concentracion,
                        'unidad_medida' => $unidadMedida
                    );

                    $idComposicionProducto = $this->lNegocioComposiciones->guardar($datosComposicionProducto);

                    $composicionesControlador = new ComposicionesControlador();
                    $filaComposicionProducto = $composicionesControlador->generarFilaComposicionProducto($idComposicionProducto, $datosComposicionProducto);

                    echo json_encode(array(
                        'validacion' => $validacion,
                        'resultado' => $resultado,
                        'filaComposicionProducto' => $filaComposicionProducto
                    ));
                } else {
                    $validacion = "Fallo";
                    $resultado = "La composición ya ha sido ingresado.";
                    echo json_encode(array(
                        'validacion' => $validacion,
                        'resultado' => $resultado
                    ));
                }
                break;
            case 'CodigoComplementarioSuplementario':
                $codigoComplementario = $_POST['codigo_complementario'];
                $codigoSuplementario = $_POST['codigo_suplementario'];

                $arrayParametros = array(
                    'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                    'codigo_complementario' => $codigoComplementario,
                    'codigo_suplementario' => $codigoSuplementario
                );

                $verificarCodigoComplementarioSuplementarioProducto = $this->lNegocioCodigoComplementarioSuplementario->buscarLista($arrayParametros);

                if (count($verificarCodigoComplementarioSuplementarioProducto) === 0) {
                    $datosCodigoComplementarioSuplementarioProducto = array(
                        'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                        'codigo_complementario' => $codigoComplementario,
                        'codigo_suplementario' => $codigoSuplementario,
                    );

                    $idCodigoComplementarioSuplementarioProducto = $this->lNegocioCodigoComplementarioSuplementario->guardar($datosCodigoComplementarioSuplementarioProducto);

                    $codigoComplementarioSuplementarioControlador = new CodigosComplementariosSuplementariosControlador();
                    $filacodigoComplementarioSuplementario = $codigoComplementarioSuplementarioControlador->generarFilaCodigoComplementarioSuplementarioProducto($idCodigoComplementarioSuplementarioProducto, $datosCodigoComplementarioSuplementarioProducto);

                    echo json_encode(array(
                        'validacion' => $validacion,
                        'resultado' => $resultado,
                        'filaComposicionProducto' => $filacodigoComplementarioSuplementario
                    ));
                } else {
                    $validacion = "Fallo";
                    $resultado = "El código complementario y suplementario ya ha sido ingresado.";
                    echo json_encode(array(
                        'validacion' => $validacion,
                        'resultado' => $resultado
                    ));
                }
                break;
            case 'Presentacion':
                $presentacion = $_POST['presentacion'];
                $unidadMedida = $_POST['unidad_medida'];

                $arrayVerificarPresentacion = array(
                    'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                    'presentacion' => $presentacion,
                    'unidad_medida' => $unidadMedida,
                );

                $verificarAdicionPresentacion = $this->lNegocioPresentaciones->buscarLista($arrayVerificarPresentacion);

                if (count($verificarAdicionPresentacion) == 0) {
                    $qSubcodigo = $this->lNegocioPresentaciones->obtenerSubcodigoPresentacion($idSolicitudRegistroProducto);
                    $subcodigo = str_pad($qSubcodigo->current()->codigo, 4, "0", STR_PAD_LEFT);

                    $datosPresentacion = array(
                        'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                        'subcodigo' => $subcodigo,
                        'presentacion' => $presentacion,
                        'unidad_medida' => $unidadMedida
                    );

                    $idPresentacion = $this->lNegocioPresentaciones->guardar($datosPresentacion);

                    $presentacionesControlador = new PresentacionesControlador();

                    $filaPresentacion = $presentacionesControlador->generarFilaPresentacion($idPresentacion, $datosPresentacion);

                    echo json_encode(array(
                        'validacion' => $validacion,
                        'resultado' => $resultado,
                        'filaPresentacion' => $filaPresentacion
                    ));
                } else {
                    $validacion = "Fallo";
                    $resultado = "La presentación ya ha sido ingresada.";
                    echo json_encode(array(
                        'validacion' => $validacion,
                        'resultado' => $resultado
                    ));
                }

                break;
            case 'Fabricante':
            case 'Formulador':
            case 'Titular del registro':
            case 'Extranjero':
            case 'Elaborador por Contrato Nacional':
                $tipo = $_POST['tipo'];
                $nombre = $_POST['nombre'];
                $idPaisOrigen = $_POST['id_pais_origen'];
                $nombrePaisOrigen = $_POST['nombre_pais_origen'];
                $datoOrigen = "Operador";

                $arrayParametros = array(
                    'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                    'tipo' => $tipo,
                    'nombre' => $nombre,
                    'id_pais_origen' => $idPaisOrigen,
                );

                $verificarFabricanteFormuladorProducto = $this->lNegocioFabricantesFormuladores->buscarLista($arrayParametros);

                if (count($verificarFabricanteFormuladorProducto) === 0) {

                    $qDatosSolicitudRegistroProducto = $this->lNegocioSolicitudesRegistroProductos->buscar($idSolicitudRegistroProducto);
                    $tipoSolicitud = $qDatosSolicitudRegistroProducto->getTipoSolicitud();

                    $datosFabricantesFormuladoresProducto = array(
                        'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                        'tipo' => $tipo,
                        'nombre' => $nombre,
                        'id_pais_origen' => $idPaisOrigen,
                        'pais_origen' => $nombrePaisOrigen,
                        'tipo_solicitud' => $tipoSolicitud
                    );

                    $idFabricanteFormuladorProducto = $this->lNegocioFabricantesFormuladores->guardar($datosFabricantesFormuladoresProducto);

                    $fabricantesFormuladoresControlador = new FabricantesFormuladoresControlador();
                    $filaFabricanteFormuladorProducto = $fabricantesFormuladoresControlador->generarFilaFabricanteFormuladorProducto($idFabricanteFormuladorProducto, $datosFabricantesFormuladoresProducto, $datoOrigen);

                    echo json_encode(array(
                        'validacion' => $validacion,
                        'resultado' => $resultado,
                        'filaFabricanteFormuladorProducto' => $filaFabricanteFormuladorProducto
                    ));
                } else {
                    $validacion = "Fallo";
                    $resultado = "El fabricante/formulador ya ha sido ingresado.";
                    echo json_encode(array(
                        'validacion' => $validacion,
                        'resultado' => $resultado
                    ));
                }

                break;
            case 'Uso':
                $idUsoProducto = $_POST['id_uso_producto'];
                $nombreUso = $_POST['nombre_uso'];
                $aplicadoA = $_POST['aplicado_a'];
                $instalacion = $_POST['instalacion'];
                $instalacionProducto = $_POST['instalacion_producto'];

                $arrayParametros = array(
                    'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                    'id_uso_aplicado' => $idUsoProducto,
                    'aplicado_a' => $aplicadoA,
                    'instalacion' => ($instalacion === '' ? $instalacionProducto : $instalacion)
                );

                $verificarUsoProducto = $this->lNegocioUsos->buscarLista($arrayParametros);

                if (count($verificarUsoProducto) === 0) {

                    $datosUsoProducto = [
                        'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                        'id_uso_aplicado' => $idUsoProducto,
                        'nombre_uso' => $nombreUso,
                        'aplicado_a' => $aplicadoA,
                        'instalacion' => ($instalacion === '' ? $instalacionProducto : $instalacion),
                    ];

                    $idUso = $this->lNegocioUsos->guardar($datosUsoProducto);

                    $usosControlador = new UsosControlador();
                    $filaUsosProducto = $usosControlador->generarFilaUsoProductoFertilizante($idUso, $datosUsoProducto);

                    echo json_encode(array(
                        'validacion' => $validacion,
                        'resultado' => $resultado,
                        'filaUsoProducto' => $filaUsosProducto
                    ));
                } else {
                    $validacion = "Fallo";
                    $resultado = "El uso ya ha sido ingresado.";
                    echo json_encode(array(
                        'validacion' => $validacion,
                        'resultado' => $resultado
                    ));
                }

                break;

            case 'Partidaarancelaria':

                $partidaArancelaria = trim($_POST['partida_arancelaria']);
                $datoOrigen = "Operador";

                $arrayParametros = array(
                    'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                    'partida_arancelaria' => $partidaArancelaria
                );

                $verificarUso = $this->lNegocioPartidasArancelariasPlaguicidasBio->buscarLista($arrayParametros);

                if (count($verificarUso) === 0) {

                    $datosPartidaArancelaria = [
                        'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                        'partida_arancelaria' => $partidaArancelaria
                    ];

                    $idPartidaArancelaria = $this->lNegocioPartidasArancelariasPlaguicidasBio->guardar($datosPartidaArancelaria);

                    $partidasArancelariasControlador = new PartidasArancelariasPlaguicidasBioControlador();
                    $filaPartidaArancelaria = $partidasArancelariasControlador->generarFilaPartidaArancelaria($idPartidaArancelaria, $datosPartidaArancelaria, $datoOrigen);

                    echo json_encode(array(
                        'validacion' => $validacion,
                        'resultado' => $resultado,
                        'filaPartidaArancelaria' => $filaPartidaArancelaria
                    ));
                } else {
                    $validacion = "Fallo";
                    $resultado = "La partida arancelaria ya ha sido ingresada.";
                    echo json_encode(array(
                        'validacion' => $validacion,
                        'resultado' => $resultado
                    ));
                }

                break;

            case 'UsoPlaguicidaBio':

                $idSolicitudRegistroProducto = $_POST['id_solicitud_registro_producto'];
                $idCultivo = $_POST['id_cultivo'];
                $cultivoNombre = $_POST['cultivo_nombre_comun'];
                $cultivoNombreCientifico = $_POST['cultivo_nombre_cientifico'];
                $idPlaga = $_POST['id_plaga'];
                $plagaNombreComun = $_POST['plaga_nombre_comun'];
                $plagaNombreCientifico = $_POST['plaga_nombre_cientifico'];
                $dosis = $_POST['dosis'];
                $unidadDosis = $_POST['unidad_dosis'];
                $periodoCarencia = $_POST['periodo_carencia'];
                $gastoAgua = $_POST['gasto_agua'];
                $unidadGastoAgua = $_POST['unidad_gasto_agua'];

				$datosUso = [
					'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
					'id_cultivo' => $idCultivo,
					'cultivo_nombre_comun' => $cultivoNombre,
					'cultivo_nombre_cientifico' => $cultivoNombreCientifico,
					'id_plaga' => $idPlaga,
					'plaga_nombre_comun' => $plagaNombreComun,
					'plaga_nombre_cientifico' => $plagaNombreCientifico,
					'dosis' => $dosis,
					'unidad_dosis' => $unidadDosis,
					'periodo_carencia' => $periodoCarencia,
					'gasto_agua' => $gastoAgua,
					'unidad_gasto_agua' => $unidadGastoAgua
				];

				$idUso = $this->lNegocioUsosProductosPlaguicidasBio->guardar($datosUso);

				$usosProductosPlaguicidasBio = new UsosProductosPlaguicidasBioControlador();
				$filaUsoPlaguicidaBio = $usosProductosPlaguicidasBio->generarFilaUso($idUso, $datosUso);

				echo json_encode(array(
					'validacion' => $validacion,
					'resultado' => $resultado,
					'filaUsoPlaguicidaBio' => $filaUsoPlaguicidaBio
				));

                break;

            case 'EnsayoEficacia':

                $idSolicitudRegistroProducto = $_POST['id_solicitud_registro_producto'];
                $numeroSocilicitudEnsayoEficacia = $_POST['solicitud_ensayo_eficacia'];

                $arrayParametros = array(
                    'numero_solicitud' => $numeroSocilicitudEnsayoEficacia,
                    'estado' => 'Aprobado'
                );

                $verificarEnsayoAprobado = $this->lNegocioEnsayoEficacia->buscarLista($arrayParametros);

                if ($verificarEnsayoAprobado->count()) {

                    $datosVerificarUsoEnsayo = array(
                        'numero_solicitud' => $numeroSocilicitudEnsayoEficacia,
                    );

                    $verificarEnsayoEficacia = $this->lNegocioEnsayosEficaciaPlaguicidasBio->buscarLista($datosVerificarUsoEnsayo);

                    if (count($verificarEnsayoEficacia) === 0) {

                        $datosEnsayo = [
                            'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                            'numero_solicitud' => $numeroSocilicitudEnsayoEficacia
                        ];

                        $idEnsayoEficacia = $this->lNegocioEnsayosEficaciaPlaguicidasBio->guardar($datosEnsayo);

                        $ensayosEficacia = new EnsayosEficaciaPlaguicidasBioControlador();
                        $filaEnsayoEficacia = $ensayosEficacia->generarFilaEnsayo($idEnsayoEficacia, $datosEnsayo);

                        echo json_encode(array(
                            'validacion' => $validacion,
                            'resultado' => $resultado,
                            'filaEnsayoEficacia' => $filaEnsayoEficacia
                        ));
                    } else {
                        $validacion = "Fallo";
                        $resultado = "El número de solicitud de ensayo ya fue registrado.";
                        echo json_encode(array(
                            'validacion' => $validacion,
                            'resultado' => $resultado
                        ));
                    }

                } else {
                    $validacion = "Fallo";
                    $resultado = "El número de solicitud de ensayo no existe o no está en estado aprobado.";
                    echo json_encode(array(
                        'validacion' => $validacion,
                        'resultado' => $resultado
                    ));
                }

                break;

        }
    }

    private function cargarPestanasProductoBioplaguicidas($tipoSolicitud, $datoOrigen)
    {
        $estado = $this->modeloSolicitudesRegistroProductos->getEstado();
        $parametros = [
            'id_area' => 'IAP',
            'id_solicitud_registro_producto' => $this->modeloSolicitudesRegistroProductos->getIdSolicitudRegistroProducto(),
            'tipo_solicitud' => $tipoSolicitud
        ];

        $this->pestania = '<div class="pestania">';
        $this->pestania .= $this->solicitudProductoBioplaguicidas($parametros, $estado);
        $this->pestania .= '</div>';

        $this->pestania .= '<div class="pestania">';
        $partidasArancelarias = new PartidasArancelariasPlaguicidasBioControlador();
        $this->pestania .= $partidasArancelarias->crearPartidaArancelariaProducto($parametros, $estado, $datoOrigen);
        $this->pestania .= '</div>';

        $this->pestania .= '<div class="pestania">';
        $composicionControlador = new ComposicionesControlador();
        $this->pestania .= $composicionControlador->crearComposicionProducto($parametros, $estado);
        $this->pestania .= '</div>';

        $this->pestania .= '<div class="pestania">';
        $fabricanteFormuladorControlador = new FabricantesFormuladoresControlador();
        $this->pestania .= $fabricanteFormuladorControlador->crearFabricanteFormuladorProducto($parametros, $estado, $datoOrigen);
        $this->pestania .= '</div>';

        $this->pestania .= '<div class="pestania">';
        $usosControlador = new UsosProductosPlaguicidasBioControlador();
        $this->pestania .= $usosControlador->crearUso($parametros, $estado);
        $this->pestania .= '</div>';

        $this->pestania .= '<div class="pestania">';
        $ensayoEficaciaControlador = new EnsayosEficaciaPlaguicidasBioControlador();
        $this->pestania .= $ensayoEficaciaControlador->crearEnsayoEficacia($parametros, $estado);
        $this->pestania .= $this->anexosBioplaguicidas($parametros, $estado);
        $this->pestania .= '</div>';

        return $this->pestania;
    }

    private function solicitudProductoBioplaguicidas($parametros, $estado)
    {
        $formularioProducto = '';
        $tipoSolicitud = $parametros['tipo_solicitud'];

        switch ($estado) {
            case 'creado':
            case 'subsanacion':

                $tipoProducto = '';
                $idSolicitudRegistroProducto = $parametros['id_solicitud_registro_producto'];
                $idArea = $parametros['id_area'];
                $codificacionTipoProducto = 'TIPO_BPLAGUICIDA';

                foreach ($this->lNegocioTipoProductos->buscarTipoProductoPorAreaPorCodificacion($idArea, $codificacionTipoProducto) as $item) {
                    if ($this->modeloSolicitudesRegistroProductos->getIdTipoProducto() === $item->id_tipo_producto) {
                        $tipoProducto .= '<option value="' . $item->id_tipo_producto . '" selected>' . $item->nombre . '</option>';
                    } else {
                        $tipoProducto .= '<option value="' . $item->id_tipo_producto . '">' . $item->nombre . '</option>';
                    }

                }

                $categoriaToxicologica = '';
                $parametrosCategoriaToxicologica = ['id_area' => $idArea
                    , 'estado_categoria_toxicologica' => 'Activo'];

                $qCategoriaToxicologica = $this->lNegocioCategoriaToxicologica->buscarLista($parametrosCategoriaToxicologica);   //>buscarFormulacionesXFiltro(['estado_formulacion' => 'Activo', 'id_area' => $idArea]);

                foreach ($qCategoriaToxicologica as $item) {
                    if ($this->modeloSolicitudesRegistroProductos->getIdCategoriaToxicologica() === $item->id_categoria_toxicologica) {
                        $categoriaToxicologica .= '<option value="' . $item->id_categoria_toxicologica . '" selected>' . $item->categoria_toxicologica . '</option>';
                    } else {
                        $categoriaToxicologica .= '<option value="' . $item->id_categoria_toxicologica . '">' . $item->categoria_toxicologica . '</option>';
                    }
                }

                $formulacion = '';
                $qFormulacion = $this->lNegocioFormulacion->buscarFormulacionesXFiltro(['estado_formulacion' => 'Activo', 'id_area' => $idArea]);

                foreach ($qFormulacion as $item) {
                    if ($this->modeloSolicitudesRegistroProductos->getIdFormulacion() === $item->id_formulacion) {
                        $formulacion .= '<option value="' . $item->id_formulacion . '" selected>' . $item->formulacion . '</option>';
                    } else {
                        $formulacion .= '<option value="' . $item->id_formulacion . '">' . $item->formulacion . '</option>';
                    }
                }

                $formularioProducto =
                    '<form id="productoSolicitud" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia" data-opcion="SolicitudesRegistroProductos/guardarDatosProducto" data-destino="detalleItem" method="post">
                        <input type="hidden" id="id_solicitud_registro_producto" name="id_solicitud_registro_producto" value="' . $idSolicitudRegistroProducto . '" />
                        <input type="hidden" id="tipo_solicitud" name="tipo_solicitud" value="' . $this->modeloSolicitudesRegistroProductos->getTipoSolicitud() . '" />
                        <fieldset id="fProducto">
                            <legend>Producto</legend>
                            <div data-linea="1">
                                <label for="id_tipo_producto">Tipo de solicitud: </label> ' . $this->tipoSolicitud($this->modeloSolicitudesRegistroProductos->getTipoSolicitud()) . '
                            </div>';
                if ($estado === 'creado') {
                    $formularioProducto .= '<div data-linea="2">
                                <label for="id_tipo_producto">Tipo de producto: </label>
                                <select name="id_tipo_producto" id="id_tipo_producto" class="validacion">
                                    <option value="">Seleccionar....</option>
                                    ' . $tipoProducto . '
                                </select>
                                <input type="hidden" name="nombre_tipo_producto" id="nombre_tipo_producto" value="' . $this->modeloSolicitudesRegistroProductos->getNombreTipoProducto() . '"/>
                            </div>';
                } else {
                    $formularioProducto .= '<div data-linea="2">
                                <label for="tipo_plaguicida">Tipo de producto: </label> ' . $this->modeloSolicitudesRegistroProductos->getNombreTipoProducto() . '
                            </div>';
                }

                $formularioProducto .= '<div data-linea="3">
                                <label for="id_subtipo_producto">Subtipo de producto: </label>
                                <select name="id_subtipo_producto" id="id_subtipo_producto" class="validacion">
                                    <option value="">Seleccionar....</option>
                                    ' . $this->obtenerSubtipoProductoPorIdTipoProductoEditar() . '
                                </select>
                                <input type="hidden" name="nombre_subtipo_producto" id="nombre_subtipo_producto" value="' . $this->modeloSolicitudesRegistroProductos->getNombreSubtipoProducto() . '"/>
                            </div>
                            <div data-linea="4">
                                <label for="nombre_producto">Nombre de producto: </label>
                                <input type="text" name="nombre_producto" id="nombre_producto" class="validacion" value="' . $this->modeloSolicitudesRegistroProductos->getNombreProducto() . '"/>
                            </div>
                        </fieldset>
                                    
                        <fieldset>
                            <legend>Características</legend>
                            <div data-linea="1">
                                <label for="id_formulacion">Formulación: </label>
                                <select name="id_formulacion" id="id_formulacion" class="validacion">
                                    <option value="">Seleccionar....</option>
                                    ' . $formulacion . '
                                </select>
                                <input type="hidden" name="nombre_formulacion" id="nombre_formulacion" value="' . $this->modeloSolicitudesRegistroProductos->getNombreFormulacion() . '"/>
                            </div>
                            <div data-linea="2">
                                <label for="id_categoria_toxicologica">Categoría toxicológica: </label>
                                <select name="id_categoria_toxicologica" id="id_categoria_toxicologica" class="validacion">
                                    <option value="">Seleccionar....</option>
                                    ' . $categoriaToxicologica . '
                                </select>
                                <input type="hidden" name="nombre_categoria_toxicologica" id="nombre_categoria_toxicologica" value="' . $this->modeloSolicitudesRegistroProductos->getNombreCategoriaToxicologica() . '"/>
                            </div>
                            <div data-linea="3">
                                <label for="periodo_reingreso">Período de reingreso: </label>
                                <input type="text" id="periodo_reingreso" name="periodo_reingreso" class="validacion" value="' . $this->modeloSolicitudesRegistroProductos->getPeriodoReingreso() . '"/>
                            </div>
                            <div data-linea="4">
                                <label for="estabilidad">Estabilidad: </label>
                                <input type="text" id="estabilidad" name="estabilidad" class="validacion" value="' . $this->modeloSolicitudesRegistroProductos->getEstabilidad() . '"/>
                            </div>
                        </fieldset>
                        <div data-linea="15">
                            <button type="submit" class="guardar">Guardar</button>
                        </div>
                    </form>';
                break;
            default:
                $formularioProducto = $this->datosProductoRegistro($this->modeloSolicitudesRegistroProductos, $tipoSolicitud);
        }

        return $formularioProducto;

    }

    private function anexosBioplaguicidas($parametros, $estado)
    {

        $documentoProducto = '';
        $idSolicitudRegistroProducto = $parametros['id_solicitud_registro_producto'];

        switch ($estado) {
            case 'creado':
            case 'subsanacion':
                $documentoProducto = '                
                <form id="finalizarSolicitud" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia" data-opcion="SolicitudesRegistroProductos/guardarFinalizarSolicitud" data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
                    <input type="hidden" id="id_solicitud_registro_producto" name="id_solicitud_registro_producto" value="' . $idSolicitudRegistroProducto . '" />
                    
                    <fieldset>
                        <legend>Observación</legend>
                        <div data-linea="1">
                            <input type="text" name="observacion_operador" id="observacion_operador">
                        </div>
                    </fieldset>
                        
                    <fieldset>
                        <legend>Anexos</legend>
                        <div data-linea="1">
                            <label>Etiqueta: </label>
                        </div>
                        <div data-linea="2">
                            <input type="hidden" class="rutaArchivo" id="ruta_etiqueta_aprobada" name="ruta_etiqueta_aprobada" value="0"/>
                            <input type="file" class="archivo validacion" id="archivo_ruta_etiqueta_aprobada" accept="application/pdf" />
                            <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                            <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                        </div>
                                
                        <div data-linea="3">
                            <label>Certificados: </label>
                        </div>
                        <div data-linea="4">
                            <input type="hidden" class="rutaArchivo" id="ruta_etiqueta_hoja_informativa" name="ruta_etiqueta_hoja_informativa" value="0"/>
                            <input type="file" class="archivo" id="archivo_ruta_etiqueta_hoja_informativa" accept="application/pdf" />
                            <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                            <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                        </div>
                                
                        <div data-linea="5">
                            <label>Autorizaciones: </label>
                        </div>
                        <div data-linea="6">
                            <input type="hidden" class="rutaArchivo" id="ruta_producto_formulado_terminado" name="ruta_producto_formulado_terminado" value="0"/>
                            <input type="file" class="archivo" id="archivo_ruta_producto_formulado_terminado" accept="application/pdf" />
                            <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                            <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                        </div>
                                
                        <div data-linea="7">
                            <label>Declaración juramentada: </label>
                        </div>
                        <div data-linea="8">
                            <input type="hidden" class="rutaArchivo" id="ruta_semioquimico" name="ruta_semioquimico" value="0"/>
                            <input type="file" class="archivo" id="archivo_ruta_semioquimico" accept="application/pdf" />
                            <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                            <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                        </div>
                        <div data-linea="9">
                            <label>Otros: </label>
                        </div>
                        <div data-linea="10">
                            <input type="hidden" class="rutaArchivo" id="ruta_otros" name="ruta_otros" value="0"/>
                            <input type="file" class="archivo" id="archivo_ruta_otros" accept="application/pdf" />
                            <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                            <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                        </div>';
                if ($estado != 'subsanacion') {
                    $documentoProducto .= '<hr/>
                        <div data-linea="9">
                            <label><input type="checkbox" id="requiere_descuento" name="requiere_descuento" value="Si"> Requiere descuento</label>
                        </div>
                        <div data-linea="10">
                            <label><input type="checkbox" id="pago_ensayo_eficacia" name="pago_ensayo_eficacia" value="Si"> Pago realizado en Ensayo de eficacia</label>
                        </div>';
                }

                $documentoProducto .= '</fieldset>
                    <div data-linea="15">
                        <button type="submit" class="guardar">Enviar solicitud</button>
                    </div>
                </form>';
                break;
            default:

                $documentoEtiquetaAprobada = $this->modeloSolicitudesRegistroProductos->getRutaEtiquetaAprobada() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $this->modeloSolicitudesRegistroProductos->getRutaEtiquetaAprobada() . ' target="_blank" class="archivo_cargado">Archivo Cargado</a>';
                $documentoEtiquetaHojaInformativa = $this->modeloSolicitudesRegistroProductos->getRutaEtiquetaHojaInformativa() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $this->modeloSolicitudesRegistroProductos->getRutaEtiquetaHojaInformativa() . ' target="_blank" class="archivo_cargado">Archivo Cargado</a>';
                $documentoProductoFormulado = $this->modeloSolicitudesRegistroProductos->getRutaProductoFormuladoTerminado() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $this->modeloSolicitudesRegistroProductos->getRutaProductoFormuladoTerminado() . ' target="_blank" class="archivo_cargado">Archivo Cargado</a>';
                $documentoSemioquimico = $this->modeloSolicitudesRegistroProductos->getRutaProductoFormuladoTerminado() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $this->modeloSolicitudesRegistroProductos->getRutaProductoFormuladoTerminado() . ' target="_blank" class="archivo_cargado">Archivo Cargado</a>';
                $requiereDescuento = $this->modeloSolicitudesRegistroProductos->getRequiereDescuento() ? 'Si' : 'No';
				$pagoEnsayoEficacia = $this->modeloSolicitudesRegistroProductos->getPagoEnsayoEficacia() ? 'Si' : 'No';

                $documentoProducto = '
                    <fieldset>
                        <legend>Observación</legend>
                        <span>' . $this->modeloSolicitudesRegistroProductos->getObservacionOperador() . '</span>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Anexos</legend>
                        <div data-linea="1">
                            <label>Etiqueta: </label> ' . $documentoEtiquetaAprobada . '
                        </div>                                
                        <div data-linea="3">
                            <label>Certificados: </label> ' . $documentoEtiquetaHojaInformativa . '
                        </div>                                
                        <div data-linea="5">
                            <label>Autorizaciones: </label> ' . $documentoProductoFormulado . '
                        </div>                                
                        <div data-linea="7">
                            <label>Declaración juramentada: </label> ' . $documentoSemioquimico . '
                        </div>                                
                        <hr/>                                
                        <div data-linea="9">
                            <label>Requiere descuento: </label> ' . $requiereDescuento . '
                        </div>
						<div data-linea="10">
                            <label>Pago realizado en Ensayo de eficacia: </label> ' . $pagoEnsayoEficacia . '
                        </div>
                    </fieldset>';
        }

        return $documentoProducto;
    }

    private function cargarPestanasProductoClones($tipoSolicitud)
    {
        $estado = $this->modeloSolicitudesRegistroProductos->getEstado();
        $parametros = [
            'id_area' => $tipoSolicitud === 'clonesfertilizantes' ? 'IAF' : 'IAP',
            'id_solicitud_registro_producto' => $this->modeloSolicitudesRegistroProductos->getIdSolicitudRegistroProducto(),
            'tipo_solicitud' => $tipoSolicitud
        ];

        $this->pestania = '<div class="pestania">';
        $this->pestania .= $this->solicitudProductoClones($parametros, $estado);
        $this->pestania .= '</div>';

        $this->pestania .= '<div class="pestania">';
        $this->pestania .= $this->anexosClones($parametros, $estado);
        $this->pestania .= '</div>';

        return $this->pestania;
    }

    private function solicitudProductoClones($parametros, $estado)
    {
        $tipoSolicitud = $parametros['tipo_solicitud'];

        switch ($estado) {
            case 'creado':
            case 'subsanacion':

                $tipoProducto = '';
                $tipoPlaguicida = '';
                $idSolicitudRegistroProducto = $parametros['id_solicitud_registro_producto'];
                $idArea = $parametros['id_area'];

                $datos = [
                    'id_area' => $idArea,
                    'estado' => 1,
                    'identificador_operador' => $this->usuarioActivo()
                ];

                foreach ($this->lNegocioProductoInocuidad->obtenerTipoProductoXOperadorAreaEstado($datos) as $item) {
                    if ($this->modeloSolicitudesRegistroProductos->getIdTipoProducto() === $item->id_tipo_producto) {
                        $tipoProducto .= '<option value="' . $item->id_tipo_producto . '" selected>' . $item->nombre . '</option>';
                    } else {
                        $tipoProducto .= '<option value="' . $item->id_tipo_producto . '">' . $item->nombre . '</option>';
                    }

                }

                $datosTipoPlaguicida = [
                    'Bioplaguicida' => 'Bioplaguicida',
                    'PQUA' => 'PQUA'
                ];

                foreach ($datosTipoPlaguicida as $item) {
                    if ($this->modeloSolicitudesRegistroProductos->getTipoPlaguicida() === $item) {
                        $tipoPlaguicida .= '<option value="' . $item . '" selected>' . $item . '</option>';
                    } else {
                        $tipoPlaguicida .= '<option value="' . $item . '">' . $item . '</option>';
                    }

                }

                $formularioProducto =
                    '<form id="productoSolicitud" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia" data-opcion="SolicitudesRegistroProductos/guardarDatosProducto" data-destino="detalleItem" method="post">
                        <input type="hidden" id="id_solicitud_registro_producto" name="id_solicitud_registro_producto" value="' . $idSolicitudRegistroProducto . '" />
                        <input type="hidden" id="tipo_solicitud" name="tipo_solicitud" value="' . $this->modeloSolicitudesRegistroProductos->getTipoSolicitud() . '" />
                        <fieldset id="fProducto">
                            <legend>Producto</legend>
                            <div data-linea="1">
                                <label for="id_tipo_producto">Tipo de solicitud: </label> ' . $this->tipoSolicitud($this->modeloSolicitudesRegistroProductos->getTipoSolicitud()) . '
                            </div>';

                if ($idArea === 'IAP') {
                    if ($estado === 'creado') {
                        $formularioProducto .= '<div data-linea="2">
                                <label for="tipo_plaguicida">Tipo de plaguicida: </label>
                                <select name="tipo_plaguicida" id="tipo_plaguicida" class="validacion">
                                    <option value="">Seleccionar....</option>
                                    ' . $tipoPlaguicida . '
                                </select>
                            </div>
                            <div data-linea="3">
                                <label for="id_tipo_producto">Tipo de producto: </label>
                                <select name="id_tipo_producto" id="id_tipo_producto" class="validacion">
                                    <option value="">Seleccionar....</option>
                                    ' . $tipoProducto . '
                                </select>
                                <input type="hidden" name="nombre_tipo_producto" id="nombre_tipo_producto" value="' . $this->modeloSolicitudesRegistroProductos->getNombreTipoProducto() . '"/>
                            </div>';
                    } else {
                        $formularioProducto .= '<div data-linea="2">
                                <label for="tipo_plaguicida">Tipo de plaguicida: </label> ' . $this->modeloSolicitudesRegistroProductos->getTipoPlaguicida() . '
                            </div>
                            <div data-linea="3">
                                <label for="tipo_plaguicida">Tipo de producto: </label> ' . $this->modeloSolicitudesRegistroProductos->getNombreTipoProducto() . '
                            </div>';
                    }
                }

                if ($idArea === 'IAF') {
                    $formularioProducto .= '
                            <div data-linea="3">
                                <label for="id_tipo_producto">Tipo de producto: </label>
                                <select name="id_tipo_producto" id="id_tipo_producto" class="validacion">
                                    <option value="">Seleccionar....</option>
                                    ' . $tipoProducto . '
                                </select>
                                <input type="hidden" name="nombre_tipo_producto" id="nombre_tipo_producto" value="' . $this->modeloSolicitudesRegistroProductos->getNombreTipoProducto() . '"/>
                            </div>';
                }
                $formularioProducto .= '
                            <div data-linea="4">
                                <label for="id_subtipo_producto">Subtipo de producto: </label>
                                <select name="id_subtipo_producto" id="id_subtipo_producto" class="validacion">
                                    <option value="">Seleccionar....</option>
                                    ' . $this->obtenerSubtipoProductoPorIdTipoProductoEditar($tipoSolicitud) . '
                                </select>
                                <input type="hidden" name="nombre_subtipo_producto" id="nombre_subtipo_producto" value="' . $this->modeloSolicitudesRegistroProductos->getNombreSubtipoProducto() . '"/>
                            </div>
                            <div data-linea="5">
                                <label for="id_producto">Producto: </label>
                                <select name="id_producto" id="id_producto" class="validacion">
                                    <option value="">Seleccionar....</option>
                                    ' . $this->obtenerProductoPorIdSubTipoProductoEditar() . '
                                </select>
                                <input type="hidden" name="nombre_comun" id="nombre_comun" value="' . $this->modeloSolicitudesRegistroProductos->getNombreComun() . '"/>
                            </div>
                            <div data-linea="6">
                                <label for="nombre_producto">Número de registro: </label>
                                <input type="text" name="numero_registro" id="numero_registro" value="' . $this->modeloSolicitudesRegistroProductos->getNumeroRegistro() . '" readonly/>
                            </div>
                            <div data-linea="7">
                                <label for="nombre_producto">Categoría toxicológica: </label>
                                <input type="text" name="nombre_categoria_toxicologica" id="nombre_categoria_toxicologica" value="' . $this->modeloSolicitudesRegistroProductos->getNombreCategoriaToxicologica() . '" readonly/>
                            </div>
                            <div data-linea="8">
                                <label for="nombre_producto">Nombre del Clon: </label>
                                <input type="text" name="nombre_producto" id="nombre_producto" class="validacion" value="' . $this->modeloSolicitudesRegistroProductos->getNombreProducto() . '"/>
                            </div>
                        </fieldset>
                                    
                        <button type="submit" class="guardar">Guardar</button>
                    </form>';
                break;
            default:
                $formularioProducto = $this->datosProductoRegistro($this->modeloSolicitudesRegistroProductos, $tipoSolicitud);
        }

        return $formularioProducto;

    }

    private function anexosClones($parametros, $estado)
    {

        $documentoProducto = '';
        $idSolicitudRegistroProducto = $parametros['id_solicitud_registro_producto'];
        $tipoSolicitud = $parametros['tipo_solicitud'];

        switch ($estado) {
            case 'creado':
            case 'subsanacion':
                if($tipoSolicitud === 'clonesfertilizantes'){
                    $documentoProducto = '                
                        <form id="finalizarSolicitud" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia" data-opcion="SolicitudesRegistroProductos/guardarFinalizarSolicitud" data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
                            <input type="hidden" id="id_solicitud_registro_producto" name="id_solicitud_registro_producto" value="' . $idSolicitudRegistroProducto . '" />
                            
                            <fieldset>
                                <legend>Observación</legend>
                                <div data-linea="1">
                                    <input type="text" name="observacion_operador" id="observacion_operador">
                                </div>
                            </fieldset>
                                
                            <fieldset>
                                <legend>Anexos</legend>
                                <div data-linea="1">
                                    <label>Solicitud: </label>
                                </div>
                                <div data-linea="2">
                                    <input type="hidden" class="rutaArchivo" id="ruta_declaracion_juramentada" name="ruta_declaracion_juramentada" value="0"/>
                                    <input type="file" class="archivo" id="archivo_ruta_declaracion_juramentada" accept="application/pdf" />
                                    <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                                    <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                                </div>
                                        
                                <div data-linea="3">
                                    <label>Etiqueta producto matriz: </label>
                                </div>
                                <div data-linea="4">
                                    <input type="hidden" class="rutaArchivo" id="ruta_envases_embalajes" name="ruta_envases_embalajes" value="0"/>
                                    <input type="file" class="archivo" id="archivo_ruta_envases_embalajes" accept="application/pdf" />
                                    <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                                    <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                                </div>
                                        
                                <div data-linea="5">
                                    <label>Proyecto de etiqueta: </label>
                                </div>
                                <div data-linea="6">
                                    <input type="hidden" class="rutaArchivo" id="ruta_etiqueta" name="ruta_etiqueta" value="0"/>
                                    <input type="file" class="archivo validacion" id="archivo_ruta_etiqueta" accept="application/pdf" />
                                    <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                                    <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                                </div>';
                            if ($estado != 'subsanacion') {
                                $documentoProducto .= '<hr/>
                                <div data-linea="9">
                                    <label><input type="checkbox" id="requiere_descuento" name="requiere_descuento" value="Si"> Requiere descuento</label>
                                </div>
                                <div data-linea="10">
                                    <label><input type="checkbox" id="pago_ensayo_eficacia" name="pago_ensayo_eficacia" value="Si"> Pago realizado en Ensayo de eficacia</label>
                                </div>';
                            }

                            $documentoProducto .= '</fieldset>
                            <div data-linea="15">
                                <button type="submit" class="guardar">Enviar solicitud</button>
                            </div>
                        </form>';
                }

                if($tipoSolicitud === 'clonesplaguicidas'){
                    $documentoProducto = '                
                        <form id="finalizarSolicitud" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia" data-opcion="SolicitudesRegistroProductos/guardarFinalizarSolicitud" data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
                            <input type="hidden" id="id_solicitud_registro_producto" name="id_solicitud_registro_producto" value="' . $idSolicitudRegistroProducto . '" />
                            
                            <fieldset>
                                <legend>Observación</legend>
                                <div data-linea="1">
                                    <input type="text" name="observacion_operador" id="observacion_operador">
                                </div>
                            </fieldset>
                                
                            <fieldset>
                                <legend>Anexos</legend>
                                <div data-linea="1">
                                    <label>Declaración juramentada: </label>
                                </div>
                                <div data-linea="2">
                                    <input type="hidden" class="rutaArchivo" id="ruta_declaracion_juramentada" name="ruta_declaracion_juramentada" value="0"/>
                                    <input type="file" class="archivo" id="archivo_ruta_declaracion_juramentada" accept="application/pdf" />
                                    <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                                    <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                                </div>
                                        
                                <div data-linea="3">
                                    <label>Información de envase y embalajes: </label>
                                </div>
                                <div data-linea="4">
                                    <input type="hidden" class="rutaArchivo" id="ruta_envases_embalajes" name="ruta_envases_embalajes" value="0"/>
                                    <input type="file" class="archivo" id="archivo_ruta_envases_embalajes" accept="application/pdf" />
                                    <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                                    <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                                </div>
                                        
                                <div data-linea="5">
                                    <label>Etiqueta y Hoja informativa: </label>
                                </div>
                                <div data-linea="6">
                                    <input type="hidden" class="rutaArchivo" id="ruta_etiqueta" name="ruta_etiqueta" value="0"/>
                                    <input type="file" class="archivo" id="archivo_ruta_etiqueta" accept="application/pdf" />
                                    <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                                    <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                                </div>
                                
                                <div data-linea="7">
                                    <label>Certificado de análisis y composición: </label>
                                </div>
                                <div data-linea="8">
                                    <input type="hidden" class="rutaArchivo" id="ruta_analisis_composicion" name="ruta_analisis_composicion" value="0"/>
                                    <input type="file" class="archivo" id="archivo_ruta_analisis_composicion" accept="application/pdf" />
                                    <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                                    <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                                </div>
                                
                                        
                                <div data-linea="9">
                                    <label>Otros: </label>
                                </div>
                                <div data-linea="10">
                                    <input type="hidden" class="rutaArchivo" id="ruta_otros" name="ruta_otros" value="0"/>
                                    <input type="file" class="archivo" id="archivo_ruta_otros" accept="application/pdf" />
                                    <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                                    <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . REGISTRO_PRODUCTO_URL . $this->rutaFecha . '">Subir archivo</button>
                                </div>';
                            if ($estado != 'subsanacion') {
                                $documentoProducto .= '<hr/>
                                <div data-linea="9">
                                    <label><input type="checkbox" id="requiere_descuento" name="requiere_descuento" value="Si"> Requiere descuento</label>
                                </div>
                                <div data-linea="10">
                                    <label><input type="checkbox" id="pago_ensayo_eficacia" name="pago_ensayo_eficacia" value="Si"> Pago realizado en Ensayo de eficacia</label>
                                </div>';
                            }

                            $documentoProducto .= '</fieldset>
                            <div data-linea="15">
                                <button type="submit" class="guardar">Enviar solicitud</button>
                            </div>
                        </form>';
                }
                break;
            default:

                $documentoDeclaracionJuramentada = $this->modeloSolicitudesRegistroProductos->getRutaDeclaracionJuramentada() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $this->modeloSolicitudesRegistroProductos->getRutaDeclaracionJuramentada() . ' target="_blank" class="archivo_cargado">Archivo Cargado</a>';
                $documentoEnvasesEmbalajes = $this->modeloSolicitudesRegistroProductos->getRutaEnvasesEmbalajes() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $this->modeloSolicitudesRegistroProductos->getRutaEnvasesEmbalajes() . ' target="_blank" class="archivo_cargado">Archivo Cargado</a>';
                $documentoEtiqueta = $this->modeloSolicitudesRegistroProductos->getRutaEtiqueta() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $this->modeloSolicitudesRegistroProductos->getRutaEtiqueta() . ' target="_blank" class="archivo_cargado">Archivo Cargado</a>';
                $documentoAnalisisComposicion = $this->modeloSolicitudesRegistroProductos->getRutaAnalisisComposicion() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $this->modeloSolicitudesRegistroProductos->getRutaAnalisisComposicion() . ' target="_blank" class="archivo_cargado">Archivo Cargado</a>';
                $documentoOtros = $this->modeloSolicitudesRegistroProductos->getRutaOtros() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $this->modeloSolicitudesRegistroProductos->getRutaOtros() . ' target="_blank" class="archivo_cargado">Archivo Cargado</a>';
                $requiereDescuento = $this->modeloSolicitudesRegistroProductos->getRequiereDescuento() ? 'Si' : 'No';
				$pagoEnsayoEficacia = $this->modeloSolicitudesRegistroProductos->getPagoEnsayoEficacia() ? 'Si' : 'No';

                if($tipoSolicitud === 'clonesfertilizantes'){
                    $documentoProducto = '
                    <fieldset>
                        <legend>Observación</legend>
                        <span>' . $this->modeloSolicitudesRegistroProductos->getObservacionOperador() . '</span>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Anexos</legend>
                        <div data-linea="1">
                            <label>Solicitud: </label> ' . $documentoDeclaracionJuramentada . '
                        </div>                                
                        <div data-linea="2">
                            <label>Etiqueta producto matriz: </label> ' . $documentoEnvasesEmbalajes . '
                        </div>                                
                        <div data-linea="3">
                            <label>Proyecto de etiqueta: </label> ' . $documentoEtiqueta . '
                        </div>                           
                        <hr/>                                
                        <div data-linea="6">
                            <label>Requiere descuento: </label> ' . $requiereDescuento . '
                        </div>
                        <div data-linea="7">
                            <label>Pago realizado en Ensayo de eficacia: </label> ' . $pagoEnsayoEficacia . '
                        </div>
                    </fieldset>';
                }

                if($tipoSolicitud === 'clonesplaguicidas'){
                    $documentoProducto = '
                    <fieldset>
                        <legend>Observación</legend>
                        <span>' . $this->modeloSolicitudesRegistroProductos->getObservacionOperador() . '</span>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Anexos</legend>
                        <div data-linea="1">
                            <label>Declaración juramentada: </label> ' . $documentoDeclaracionJuramentada . '
                        </div>                                
                        <div data-linea="2">
                            <label>Información de envase y embalajes: </label> ' . $documentoEnvasesEmbalajes . '
                        </div>                                
                        <div data-linea="3">
                            <label>Etiqueta y Hoja informativa: </label> ' . $documentoEtiqueta . '
                        </div>                                
                        <div data-linea="4">
                            <label>Certificado de análisis y composición: </label> ' . $documentoAnalisisComposicion . '
                        </div>
                        <div data-linea="5">
                            <label>Otros: </label> ' . $documentoOtros . '
                        </div>                                
                        <hr/>                                
                        <div data-linea="6">
                            <label>Requiere descuento: </label> ' . $requiereDescuento . '
                        </div>
						<div data-linea="7">
                            <label>Pago realizado en Ensayo de eficacia: </label> ' . $pagoEnsayoEficacia . '
                        </div>
                    </fieldset>';
                }

        }

        return $documentoProducto;
    }

    public function verSolicitud()
    {
        $this->cargarPanelVerSolicitudes();
        require APP . 'RegistroProductoRia/vistas/listaVerSolicitudesRegistroProductosVista.php';
    }

}
