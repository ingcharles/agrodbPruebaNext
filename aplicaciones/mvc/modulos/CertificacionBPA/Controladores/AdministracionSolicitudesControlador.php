<?php
/**
 * Controlador Revisiones
 *
 * Este archivo controla la lógica del negocio para el proceso de revisión y Vistas
 *
 * @author  AGROCALIDAD
 * @date   2020-08-06
 * @uses    RevisionesControlador
 * @package CertificadoFitosanitario
 * @subpackage Controladores
 */
namespace Agrodb\CertificacionBPA\Controladores;

use Agrodb\CertificacionBPA\Modelos\SolicitudesLogicaNegocio;
use Agrodb\CertificacionBPA\Modelos\SolicitudesModelo;
use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;

class AdministracionSolicitudesControlador extends BaseControlador
{

    private $lNegocioSolicitudes = null;
    private $modeloSolicitudes = null;

    private $accion = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        $this->lNegocioSolicitudes = new SolicitudesLogicaNegocio();
        $this->modeloSolicitudes = new SolicitudesModelo();

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
        $this->cargarPanelAdministracion();

        require APP . 'CertificacionBPA/vistas/listaAdministracionSolicitudesVista.php';
    }

    /**
     * Construye el código HTML para desplegar la lista de - CertificadoFitosanitario
     */
    public function tablaHtmlSolicitudesRevisiones($tabla)
    {
        $contador = 0;

        foreach ($tabla as $fila) {

            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_solicitud'] . '"
                		  class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'CertificacionBPA/Solicitudes"
                                                		  data-opcion="abrir" ondragstart="drag(event)" draggable="true"
                                                		  data-destino="detalleItem">
                                                		  <td>' . ++ $contador . '</td>
                                                <td>' . $fila['id_solicitud'] . '</td>
                                                <td style="white - space:nowrap; "><b>' . $fila['tipo_solicitud'] . '</b></td>
                                                <td>' . $fila['razon_social'] . '</td>
                                                <td>' . $fila['estado'] . '</td>
                </tr>'
            );
        }
    }

    /**
     * Construye el código HTML para desplegar panel de busqueda para las solicitudes
     */
    public function cargarPanelAdministracion()
    {
        $this->panelBusquedaAdministrador = '<table class="filtro">
                                            <tbody>
                                                <tr></tr>
                                                <tr>
                            						<td>Número de solicitud: </td>
                            						<td colspan=3>
                                                        <input type="text" id="numeroTramiteFiltro" name="numeroTramiteFiltro" style="width: 100%;" />
                            						</td>
                                                </tr>
                            					<tr>
                            						<td colspan="3">
                            							<button type="button" id="btnFiltrar">Buscar</button>
                            						</td>                                                            
                            					</tr>
                            				</tbody>
                            			</table>';

        
    }

    /**
     * Método para listar las solicitudes registradas
     */
    public function listarSolicitudesAdministracionFiltradas()
    {
        $estado = 'EXITO';
        $mensaje = '';
        $contenido = '';

        $idExpediente = $_POST['numeroTramiteFiltro'];

        $arrayParametros = array(
            'id_solicitud' => $idExpediente
        );

        $solicitudes = $this->lNegocioSolicitudes->buscarSolicitudesFiltradas($arrayParametros);

        $this->tablaHtmlSolicitudesRevisiones($solicitudes);

        $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);

        echo json_encode(array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'contenido' => $contenido
        ));
    }
}