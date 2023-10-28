<?php
/**
 * Controlador Solicitudes
 *
 * Este archivo controla la lógica del negocio del modelo:  SolicitudesModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-10-21
 * @uses    SolicitudesControlador
 * @package EnsayoEficacia
 * @subpackage Controladores
 */

namespace Agrodb\EnsayoEficacia\Controladores;

use Agrodb\EnsayoEficacia\Modelos\OrganismosInspeccionLogicaNegocio;
use Agrodb\EnsayoEficacia\Modelos\ResultadosEnsayoLogicaNegocio;
use Agrodb\EnsayoEficacia\Modelos\SolicitudesLogicaNegocio;
use Agrodb\EnsayoEficacia\Modelos\SolicitudesModelo;
use Agrodb\Financiero\Modelos\OrdenPagoLogicaNegocio;
use Agrodb\GUath\Modelos\FichaEmpleadoLogicaNegocio;
use Agrodb\Usuarios\Modelos\UsuariosLogicaNegocio;

class SolicitudesControlador extends BaseControlador
{

    private $lNegocioSolicitudes = null;
    private $modeloSolicitudes = null;
    private $lNegocioOrdenPago = null;
    private $lNegocioOrganismosInspeccion = null;
    private $lNegocioResultadosEnsayo = null;
    private $lNegocioFichaEmpleado = null;
    private $lNegocioUsuario = null;
    private $accion = null;
    private $panelBusqueda = null;
    private $datosGenerales = null;
    private $estado = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioSolicitudes = new SolicitudesLogicaNegocio();
        $this->modeloSolicitudes = new SolicitudesModelo();
        $this->lNegocioOrdenPago = new OrdenPagoLogicaNegocio();
        $this->lNegocioOrganismosInspeccion = new OrganismosInspeccionLogicaNegocio();
        $this->lNegocioResultadosEnsayo = new ResultadosEnsayoLogicaNegocio();
        $this->lNegocioFichaEmpleado = new FichaEmpleadoLogicaNegocio();
        $this->lNegocioUsuario = new UsuariosLogicaNegocio();
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
            'estadoSolicitud' => '',
            'numeroSolicitud' => '',
            'fecha' => ''
        );
        $modeloSolicitudes = $this->lNegocioSolicitudes->buscarSolicitudesEnsayoEficacia($arrayParametros);
        $this->tablaHtmlSolicitudes($modeloSolicitudes);
        require APP . 'EnsayoEficacia/vistas/listaSolicitudesVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nueva solicitud de ensayo de eficacia";
        $identificador = $this->usuarioActivo();
        $this->estado = 'creado';
        $operador = $this->lNegocioSolicitudes->obtenerDatosOperador($identificador);
        $this->datosGenerales = $this->datosGeneralesOperador($operador);
        require APP . 'EnsayoEficacia/vistas/formularioSolicitudesVista.php';
    }

    /**
     * Método para registrar en la base de datos -Solicitudes
     */
    public function guardar()
    {
        $estado = 'exito';
        $mensaje = '';

        $idetificador = $this->usuarioActivo();
        $operador = $this->lNegocioSolicitudes->obtenerDatosOperador($idetificador);
        $idSolicitud = $_POST['id_solicitud'];

        $_POST['identificador_operador'] = $operador->getIdentificador();
        $_POST['razon_social'] = $operador->getRazonSocial();
        $_POST['representante_legal'] = $operador->getNombreRepresentante() . ' ' . $operador->getApellidoRepresentante();
        $_POST['direccion'] = $operador->getDireccion();
        $_POST['telefono'] = $operador->getTelefonoUno() === '' ? $operador->getTelefonoDos() : $operador->getTelefonoUno();
        $_POST['correo'] = $operador->getCorreo();
        $_POST['representante_tecnico'] = $operador->getNombreTecnico() . ' ' . $operador->getApellidoTecnico();
        $_POST['provincia_operador'] = $operador->getProvincia();
        $_POST['estado'] = isset($_POST['cultivo_menor'] ) ? 'inspeccion' : 'pago';

        if($idSolicitud){
            $solicitud = $this->lNegocioSolicitudes->buscar($idSolicitud);
            $_POST['estado'] = $solicitud->getEstadoAnterior();
        }

        $idSolicitudEnsayo = $this->lNegocioSolicitudes->guardar($_POST);

        echo json_encode(array(
            "estado" => $estado,
            "mensaje" => $mensaje,
            "contenido" => $idSolicitudEnsayo
        ));
    }

    /**
     *Obtenemos los datos del registro seleccionado para editar - Tabla: Solicitudes
     */
    public function editar()
    {
        $this->accion = "Editar solicitud de ensayo de eficacia";
        $identificador = $this->usuarioActivo();
        $this->modeloSolicitudes = $this->lNegocioSolicitudes->buscar($_POST["id"]);

        $operador = $this->lNegocioSolicitudes->obtenerDatosOperador($identificador);
        $this->datosGenerales = $this->datosGeneralesOperador($operador);
																						   
        $datosEmpleado = $this->lNegocioFichaEmpleado->buscar($this->modeloSolicitudes->getIdentificadorRevisorTecnico());
        $this->datosGenerales .= $this->resultadoRevisionTecnica($this->modeloSolicitudes, $datosEmpleado);

        if($this->modeloSolicitudes->getIdentificadorRevisorResultado() != ''){
            $datosEmpleado = $this->lNegocioFichaEmpleado->buscar($this->modeloSolicitudes->getIdentificadorRevisorResultado());
            $this->datosGenerales .= $this->resultadoRevisionResultado($this->modeloSolicitudes, $datosEmpleado);
        }

        $this->estado =  $this->modeloSolicitudes->getEstado();
        require APP . 'EnsayoEficacia/vistas/formularioSolicitudesVista.php';
    }

    /**
     *Obtenemos los datos del registro seleccionado para editar - Tabla: Solicitudes
     */
    public function verSolicitud()
    {
        $this->accion = "Solicitud de ensayo de eficacia";

        $idSolicitud = $_POST['id'];
        $verificarTipoSolicitud = isset($_POST['nombreOpcion']);

        $this->modeloSolicitudes = $this->lNegocioSolicitudes->buscar($idSolicitud);

        $identificador = $this->modeloSolicitudes->getIdentificadorOperador();
        $operador = $this->lNegocioSolicitudes->obtenerDatosOperador($identificador);

        $this->datosGenerales = $this->datosGeneralesOperador($operador);
        $this->datosGenerales .= $this->datosSolicitud($this->modeloSolicitudes);
        $this->datosGenerales .= $this->datosAdicionalesEnsayoEficacia($this->modeloSolicitudes);
        $this->datosGenerales .= $this->documentosAdjuntos($this->modeloSolicitudes);
        if($this->modeloSolicitudes->getIdentificadorRevisorTecnico() != ''){
            $datosEmpleado = $this->lNegocioFichaEmpleado->buscar($this->modeloSolicitudes->getIdentificadorRevisorTecnico());
            $this->datosGenerales .= $this->resultadoRevisionTecnica($this->modeloSolicitudes, $datosEmpleado);
        }

        $organismoInspeccion = $this->lNegocioOrganismosInspeccion->buscarLista(['id_solicitud' => $idSolicitud]);

        if($organismoInspeccion->count()){
            $operadorOrganismo = $this->lNegocioSolicitudes->obtenerDatosOperador($organismoInspeccion->current()->identificador_organismo_inspeccion);
            $this->datosGenerales .= $this->datosOrganismoInspeccion($operadorOrganismo);
        }

        $resultadoEnsayo = $this->lNegocioResultadosEnsayo->buscarLista(['id_solicitud' => $idSolicitud]);


        if($resultadoEnsayo->count()){
            $datosResultadoEnsayo = $resultadoEnsayo->toArray();
            $this->datosGenerales .= $this->resultadoEnsayoEficacia($datosResultadoEnsayo[0], true, $verificarTipoSolicitud);
        }

        if($this->modeloSolicitudes->getIdentificadorRevisorResultado()){
            $datosEmpleado = $this->lNegocioFichaEmpleado->buscar($this->modeloSolicitudes->getIdentificadorRevisorResultado());
            $this->datosGenerales .= $this->resultadoRevisionResultado($this->modeloSolicitudes, $datosEmpleado);
        }

        $datosConsultaFinanciero = [
            'id_solicitud' => $idSolicitud,
            'tipo_solicitud' => 'ensayoEficacia',
            'estado' => 3
        ];

        if ($this->modeloSolicitudes->getEstado() === 'verificacion') {
            $financiero = $this->lNegocioOrdenPago->buscarLista($datosConsultaFinanciero);
            $datosFinanciero = $financiero->toArray();
            $this->datosGenerales .= $this->datosFinancieroEnsayoEficacia($datosFinanciero[0]);
        }

        require APP . 'EnsayoEficacia/vistas/verFormularioSolicitudesVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - Solicitudes
     */
    public function borrar()
    {
        $this->lNegocioSolicitudes->borrar($_POST['elementos']);
    }

    /**
     * Construye el código HTML para desplegar la lista de - Solicitudes
     */
    public function tablaHtmlSolicitudes($tabla)
    {
        $contador = 0;

        foreach ($tabla as $fila) {
            $estado = $this->estado($fila['estado']);
            $tipoSolicitud = $this->tipoSolicitud($fila['tipo_solicitud']);
            $tipoProducto = $this->tipoProducto($fila['tipo_producto']);

            switch ($fila['estado']){
                case 'subsanacion':
                case 'organismoInspeccion':
                    $pagina = 'editar';
                    break;
                default:
                    $pagina = 'verSolicitud';
            }

            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_solicitud'] . '"
                      class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'EnsayoEficacia\Solicitudes"
                      data-opcion="' . $pagina . '" ondragstart="drag(event)" draggable="true"
                      data-destino="detalleItem">
                      <td>' . ++$contador . '</td>
                      <td>' . $fila['numero_solicitud'] . '</td>
                      <td>' . $tipoSolicitud . '</td>
                      <td>' . $tipoProducto . '</td>
                      <td>' . $fila['producto'] . '</td>
                      <td>' . $estado . '</td>
                    </tr>');
        }
    }

    public function tablaHtmlSolicitudesVerSolicitudes($tabla)
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
							  class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'EnsayoEficacia\Solicitudes"
							  data-opcion="verSolicitud" ondragstart="drag(event)" draggable="true"
							  data-destino="detalleItem" data-nombre="verSolicitud">
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
        		                                              <option value="">Seleccione...</option>
        		                                              <option value="pago">Asiganción de pago</option>
        		                                              <option value="verificacion">Verificación de pago</option>
        		                                              <option value="asignadoInspeccion">Asignado revisión técnica</option>
                                                              <option value="inspeccion">Revisión técnica</option>
                                                              <option value="organismoInspeccion">Asignar organismo de Inspección</option>
                                                              <option value="ingresarResultado">Ingresar resultados</option>
                                                               <option value="asignadoInspeccionResultado">Asignado revisión técnica de resultados</option>
                                                              <option value="inspeccionResultado">Revisión técnica de resultados</option>
                                                              <option value="subsanacion">Subsanación revisión técnica</option>
                                                              <option value="subsanacionResultado">Subsanación revisión técnica resultados</option>
                                                              <option value="aprobado">Aprobado</option>
                                                              <option value="rechazado">Rechazado</option>
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
	                            						<td >Identificador: </td>
	                            						<td colspan="3">
	                            							<input class="validacion" id="identificador" type="text" name="identificador" value="" >
	                            						</td>
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
        		                                              <option value="">Seleccione...</option>
        		                                              <option value="pago">Asiganción de pago</option>
        		                                              <option value="verificacion">Verificación de pago</option>
        		                                              <option value="asignadoInspeccion">Asignado revisión técnica</option>
                                                              <option value="inspeccion">Revisión técnica</option>
                                                              <option value="organismoInspeccion">Asignar organismo de Inspección</option>
                                                              <option value="ingresarResultado">Ingresar resultados</option>
                                                               <option value="asignadoInspeccionResultado">Asignado revisión técnica de resultados</option>
                                                              <option value="inspeccionResultado">Revisión técnica de resultados</option>
                                                              <option value="subsanacion">Subsanación revisión técnica</option>
                                                              <option value="subsanacionResultado">Subsanación revisión técnica resultados</option>
                                                              <option value="aprobado">Aprobado</option>
                                                              <option value="rechazado">Rechazado</option>
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
        $tipo = isset($_POST['tipo']);
        $arrayParametros = array(
            'identificador' => $this->usuarioActivo(),
            'nombreProducto' => $_POST['nombreProducto'],
            'estadoSolicitud' => ($_POST['estadoSolicitud'] ? "'" .$_POST['estadoSolicitud']."'" : ''),
            'numeroSolicitud' => '',
            'fecha' => $_POST['fecha']
        );

        if($tipo){
            $arrayParametros = array(
                'identificador' => $_POST['identificador'],
                'nombreProducto' => $_POST['nombreProducto'],
                'estadoSolicitud' => ($_POST['estadoSolicitud'] ? "'" .$_POST['estadoSolicitud']."'" : ''),
                'numeroSolicitud' => '',
                'fecha' => $_POST['fecha']
            );
        }

        $modeloSolicitudes = $this->lNegocioSolicitudes->buscarSolicitudesEnsayoEficacia($arrayParametros);

        if($modeloSolicitudes->count() == 0){
            $estado = 'FALLO';
            $mensaje = 'No existen registros para la búsqueda.';
        }

        if($tipo){
            $this->tablaHtmlSolicitudesVerSolicitudes($modeloSolicitudes);
        }else{
            $this->tablaHtmlSolicitudes($modeloSolicitudes);
        }

        $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
        echo json_encode(array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'contenido' => $contenido));
    }

    public function verSolicitudTecnico()
    {
        $this->cargarPanelVerSolicitudes();
        require APP . 'EnsayoEficacia/vistas/listaVerSolicitudesVista.php';
    }
}
