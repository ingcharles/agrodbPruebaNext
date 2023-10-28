<?php
/**
 * Controlador OrganismosInspeccion
 *
 * Este archivo controla la lógica del negocio del modelo:  OrganismosInspeccionModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-10-21
 * @uses    OrganismosInspeccionControlador
 * @package EnsayoEficacia
 * @subpackage Controladores
 */

namespace Agrodb\EnsayoEficacia\Controladores;

use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;
use Agrodb\EnsayoEficacia\Modelos\OrganismosInspeccionLogicaNegocio;
use Agrodb\EnsayoEficacia\Modelos\OrganismosInspeccionModelo;
use Agrodb\EnsayoEficacia\Modelos\SolicitudesLogicaNegocio;
use Agrodb\EnsayoEficacia\Modelos\SolicitudesModelo;
use Agrodb\GUath\Modelos\FichaEmpleadoLogicaNegocio;
use Agrodb\RegistroOperador\Modelos\OperacionesLogicaNegocio;

class OrganismosInspeccionControlador extends BaseControlador
{

    private $lNegocioOrganismosInspeccion = null;
    private $modeloOrganismosInspeccion = null;
    private $lNegocioSolicitudes = null;
    private $modeloSolicitudes = null;
    private $lNegocioOperaciones = null;
    private $lNegocioFichaEmpleado = null;
    private $accion = null;
    private $datosGenerales = null;
    private $comboOrganismos = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioOrganismosInspeccion = new OrganismosInspeccionLogicaNegocio();
        $this->modeloOrganismosInspeccion = new OrganismosInspeccionModelo();
        $this->lNegocioSolicitudes = new SolicitudesLogicaNegocio();
        $this->modeloSolicitudes = new SolicitudesModelo();
        $this->lNegocioOperaciones = new OperacionesLogicaNegocio();
        $this->lNegocioFichaEmpleado = new FichaEmpleadoLogicaNegocio();
        set_exception_handler(array($this, 'manejadorExcepciones'));
    }

    /**
     * Método de inicio del controlador
     */
    public function index()
    {
        $this->cargarPanelSolicitudes();

        $arrayParametros = array(
            'identificador' => $this->usuarioActivo(),
            'nombreProducto' => '',
            'estadoSolicitud' => "'organismoInspeccion'",
            'numeroSolicitud' => '',
            'fecha' => ''
        );

        $modeloSolicitudes = $this->lNegocioSolicitudes->buscarSolicitudesEnsayoEficacia($arrayParametros);
        $this->tablaHtmlOrganismosInspeccion($modeloSolicitudes);
        require APP . 'EnsayoEficacia/vistas/listaOrganismosInspeccionVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nuevo OrganismosInspeccion";
        require APP . 'EnsayoEficacia/vistas/formularioOrganismosInspeccionVista.php';
    }

    /**
     * Método para registrar en la base de datos -OrganismosInspeccion
     */
    public function guardar()
    {

        $idSolicitud = $_POST['id_solicitud'];

        $this->lNegocioOrganismosInspeccion->guardar($_POST);

        $arrayParametrosResultado = array(
            'id_solicitud' => $idSolicitud,
            'estado' => 'ingresarResultado',
            'estado_anterior' => 'organismoInspeccion',
            'observacion_revisor_tecnico' => '',
            'ruta_revisor_tecnico' => '',
            'identificador_revisor_resultado' => '',
            'observacion_revisor_resultado' => '',
            'ruta_informe_uno' => '',
            'ruta_informe_dos' => '',
            'resultado_revisor_tecnico' => '',
            'resultado_revisor_resultado' => ''
        );

        $this->lNegocioSolicitudes->actualizarEstadoRevisionEnsayoEficacia($arrayParametrosResultado);

        Mensajes::exito(Constantes::GUARDADO_CON_EXITO);
    }

    /**
     *Obtenemos los datos del registro seleccionado para editar - Tabla: OrganismosInspeccion
     */
    public function editar()
    {
        $this->accion = "Asignar Organismo de Inspección";
        $identificador = $this->usuarioActivo();
        $idSolicitud = $_POST['id'];

        $this->modeloSolicitudes = $this->lNegocioSolicitudes->buscar($idSolicitud);

        $operador = $this->lNegocioSolicitudes->obtenerDatosOperador($identificador);
        $datosEmpleado = $this->lNegocioFichaEmpleado->buscar($this->modeloSolicitudes->getIdentificadorRevisorTecnico());

        $this->datosGenerales = $this->datosGeneralesOperador($operador);
        $this->datosGenerales .= $this->datosSolicitud($this->modeloSolicitudes);
        $this->datosGenerales .= $this->documentosAdjuntos($this->modeloSolicitudes);
        $this->datosGenerales .= $this->resultadoRevisionTecnica($this->modeloSolicitudes, $datosEmpleado);

        $arrayParametros = array(
            'codigo_operacion' => "'ODI'",
            'id_area' => "'CGRIA'"
        );

        $organismoInspeccion = $this->lNegocioOperaciones->buscarOperacionPorTipoOperacionArea($arrayParametros);

        $this->datosOrganismoInspeccion($organismoInspeccion);

        require APP . 'EnsayoEficacia/vistas/formularioOrganismosInspeccionVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - OrganismosInspeccion
     */
    public function borrar()
    {
        $this->lNegocioOrganismosInspeccion->borrar($_POST['elementos']);
    }

    /**
     * Construye el código HTML para desplegar la lista de - OrganismosInspeccion
     */
    public function tablaHtmlOrganismosInspeccion($tabla)
    {
        $contador = 0;
        foreach ($tabla as $fila) {
            $estado = $this->estado($fila['estado']);
            $tipoSolicitud = $this->tipoSolicitud($fila['tipo_solicitud']);
            $tipoProducto = $this->tipoProducto($fila['tipo_producto']);

            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_solicitud'] . '"
		            class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'EnsayoEficacia\OrganismosInspeccion"
                    data-opcion="editar" ondragstart="drag(event)" draggable="true"
                    data-destino="detalleItem">
                        <td>' . ++$contador . '</td>
                        <td>' . $tipoSolicitud . '</td>
                        <td>' . $tipoProducto . '</td>
                        <td>' . $fila['producto'] . '</td>
                        <td>' . $estado . '</td>
                    </tr>');
        }
    }

    public function cargarPanelSolicitudes()
    {
        $this->panelBusqueda = '<table class="filtro" style="width: 100%;">
                                            	<tbody>
	                                                <tr>
	                                                    <th colspan="4">Buscar solicitud:</th>
	                                                </tr>
	                                                <tr  style="width: 100%;">
	                            						<td >Producto: </td>
	                            						<td colspan="3">
	                            							<input id="nombreProducto" type="text" name="nombreProducto" value="" >
	                            						</td>
            
	                            					</tr>
                                                    <tr  style="width: 100%;">
	                            						<td >Estado Solicitud: </td>
	                            						<td colspan="3">
                                                            <select style="width: 100%;" id="estadoSolicitud" name= "estadoSolicitud" >
        		                                              <option value="organismoInspeccion" selected>Asignar organismo de Inspección</option>
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

    public function filtrarSolicitudes()
    {
        $estado = 'EXITO';
        $mensaje = '';
        $arrayParametros = array(
            'identificador' => $this->usuarioActivo(),
            'nombreProducto' => $_POST['nombreProducto'],
            'estadoSolicitud' => ($_POST['estadoSolicitud'] ? "'" . $_POST['estadoSolicitud'] . "'" : ''),
            'numeroSolicitud' => '',
            'fecha' => $_POST['fecha']
        );
        $modeloSolicitudes = $this->lNegocioSolicitudes->buscarSolicitudesEnsayoEficacia($arrayParametros);

        if ($modeloSolicitudes->count() == 0) {
            $estado = 'FALLO';
            $mensaje = 'No existen registros para la búsqueda.';
        }

        $this->tablaHtmlOrganismosInspeccion($modeloSolicitudes);
        $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
        echo json_encode(array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'contenido' => $contenido));

    }

    public function datosOrganismoInspeccion($datosOperador)
    {
        foreach ($datosOperador as $organismo) {
            $this->comboOrganismos .= '<option value="' . $organismo->identificador_operador . '">' . $organismo->razon_social . ' - ' . $organismo->apellido_representante . ' ' . $organismo->nombre_representante . '</option>';
        }

    }
}
