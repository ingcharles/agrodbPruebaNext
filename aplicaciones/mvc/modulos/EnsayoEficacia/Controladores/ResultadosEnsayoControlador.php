<?php
/**
 * Controlador ResultadosEnsayo
 *
 * Este archivo controla la lógica del negocio del modelo:  ResultadosEnsayoModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-10-21
 * @uses    ResultadosEnsayoControlador
 * @package EnsayoEficacia
 * @subpackage Controladores
 */

namespace Agrodb\EnsayoEficacia\Controladores;

use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;
use Agrodb\EnsayoEficacia\Modelos\OrganismosInspeccionLogicaNegocio;
use Agrodb\EnsayoEficacia\Modelos\OrganismosInspeccionModelo;
use Agrodb\EnsayoEficacia\Modelos\ResultadosEnsayoLogicaNegocio;
use Agrodb\EnsayoEficacia\Modelos\ResultadosEnsayoModelo;
use Agrodb\EnsayoEficacia\Modelos\SolicitudesLogicaNegocio;
use Agrodb\EnsayoEficacia\Modelos\SolicitudesModelo;
use Agrodb\GUath\Modelos\FichaEmpleadoLogicaNegocio;

class ResultadosEnsayoControlador extends BaseControlador
{

    private $lNegocioResultadosEnsayo = null;
    private $modeloResultadosEnsayo = null;
    private $lNegocioSolicitudes = null;
    private $modeloSolicitudes = null;
    private $lNegocioOrganismosInspeccion = null;
    private $lNegocioFichaEmpleado = null;
    private $accion = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioResultadosEnsayo = new ResultadosEnsayoLogicaNegocio();
        $this->modeloResultadosEnsayo = new ResultadosEnsayoModelo();
        $this->lNegocioSolicitudes = new SolicitudesLogicaNegocio();
        $this->modeloSolicitudes = new SolicitudesModelo();
        $this->lNegocioOrganismosInspeccion = new OrganismosInspeccionLogicaNegocio();
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
            'estadoSolicitud' => "'ingresarResultado', 'subsanacionResultado'",
            'fecha' => ''
        );

        $resultadoOperador = $this->lNegocioResultadosEnsayo->obtenerSolicitudesIngresarResultadosOperador($arrayParametros);
        $resultadoOrganismo = $this->lNegocioResultadosEnsayo->obtenerSolicitudesIngresarResultadosOrganismo($arrayParametros);

        $this->tablaHtmlResultadosEnsayo($resultadoOperador);
        $this->tablaHtmlResultadosEnsayo($resultadoOrganismo);

        require APP . 'EnsayoEficacia/vistas/listaResultadosEnsayoVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nuevo ResultadosEnsayo";
        require APP . 'EnsayoEficacia/vistas/formularioResultadosEnsayoVista.php';
    }

    /**
     * Método para registrar en la base de datos -ResultadosEnsayo
     */
    public function guardar()
    {
        $_POST['identificador'] = $this->usuarioActivo();
        $this->lNegocioResultadosEnsayo->guardarResultadoEnsayo($_POST);
        Mensajes::exito(Constantes::GUARDADO_CON_EXITO);
    }

    /**
     *Obtenemos los datos del registro seleccionado para editar - Tabla: ResultadosEnsayo
     */
    public function editar()
    {
        $this->accion = "Ingresar Resultados de Ensayo de Eficacia";
        $idSolicitud = $_POST['id'];

        $this->modeloSolicitudes = $this->lNegocioSolicitudes->buscar($idSolicitud);

        $identificador = $this->modeloSolicitudes->getIdentificadorOperador();

        $operador = $this->lNegocioSolicitudes->obtenerDatosOperador($identificador);
        $datosEmpleado = $this->lNegocioFichaEmpleado->buscar($this->modeloSolicitudes->getIdentificadorRevisorTecnico());

        $this->datosGenerales = $this->datosGeneralesOperador($operador);
        $this->datosGenerales .= $this->datosSolicitud($this->modeloSolicitudes);
        $this->datosGenerales .= $this->resultadoRevisionTecnica($this->modeloSolicitudes, $datosEmpleado);

        $organismoInspeccion = $this->lNegocioOrganismosInspeccion->buscarLista(['id_solicitud' => $idSolicitud]);
        $operadorOrganismo = $this->lNegocioSolicitudes->obtenerDatosOperador($organismoInspeccion->current()->identificador_organismo_inspeccion);
        $this->datosGenerales .= $this->datosOrganismoInspeccion($operadorOrganismo);

        if($this->modeloSolicitudes->getEstado() === 'subsanacionResultado'){
            $datosEmpleado = $this->lNegocioFichaEmpleado->buscar($this->modeloSolicitudes->getIdentificadorRevisorResultado());
            $this->datosGenerales .= $this->resultadoRevisionResultado($this->modeloSolicitudes, $datosEmpleado);
        }

        require APP . 'EnsayoEficacia/vistas/formularioResultadosEnsayoVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - ResultadosEnsayo
     */
    public function borrar()
    {
        $this->lNegocioResultadosEnsayo->borrar($_POST['elementos']);
    }

    /**
     * Construye el código HTML para desplegar la lista de - ResultadosEnsayo
     */
    public function tablaHtmlResultadosEnsayo($tabla)
    {
        $contador = 0;
        foreach ($tabla as $fila) {
            $estado = $this->estado($fila['estado']);
            $tipoSolicitud = $this->tipoSolicitud($fila['tipo_solicitud']);
            $tipoProducto = $this->tipoProducto($fila['tipo_producto']);

            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_solicitud'] . '"
		            class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'EnsayoEficacia\ResultadosEnsayo"
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
        		                                              <option value="ingresarResultado" selected>Ingresar resultados</option>
        		                                              <option value="subsanacionResultado">Subsanación</option>
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
            'estadoSolicitud' => "'" .$_POST['estadoSolicitud']."'",
            'fecha' => $_POST['fecha']
        );

        $resultadoOperador = $this->lNegocioResultadosEnsayo->obtenerSolicitudesIngresarResultadosOperador($arrayParametros);
        $resultadoOrganismo = $this->lNegocioResultadosEnsayo->obtenerSolicitudesIngresarResultadosOrganismo($arrayParametros);


        if ($resultadoOperador->count() == 0 && $resultadoOrganismo->count() == 0) {
            $estado = 'FALLO';
            $mensaje = 'No existen registros para la búsqueda.';
        }

        $this->tablaHtmlResultadosEnsayo($resultadoOperador);
        $this->tablaHtmlResultadosEnsayo($resultadoOrganismo);
        $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
        echo json_encode(array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'contenido' => $contenido));

    }
}
