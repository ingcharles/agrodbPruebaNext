<?php
/**
 * Controlador TitularesProductos
 *
 * Este archivo controla la lógica del negocio del modelo:  TitularesProductosModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-07-13
 * @uses    TitularesProductosControlador
 * @package ModificacionProductoRia
 * @subpackage Controladores
 */

namespace Agrodb\ModificacionProductoRia\Controladores;

use Agrodb\ModificacionProductoRia\Modelos\TitularesProductosLogicaNegocio;
use Agrodb\ModificacionProductoRia\Modelos\TitularesProductosModelo;
use Agrodb\RegistroOperador\Modelos\OperadoresLogicaNegocio;

class TitularesProductosControlador extends BaseControlador
{

    private $lNegocioTitularesProductos = null;

    private $lNegocioOperadores = null;

    private $modeloTitularesProductos = null;

    private $accion = null;

    private $rutaFecha = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioTitularesProductos = new TitularesProductosLogicaNegocio();
        $this->modeloTitularesProductos = new TitularesProductosModelo();

        $this->lNegocioOperadores = new OperadoresLogicaNegocio();

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
        $modeloTitularesProductos = $this->lNegocioTitularesProductos->buscarTitularesProductos();
        $this->tablaHtmlTitularesProductos($modeloTitularesProductos);
        require APP .
            'ModificacionProductoRia/vistas/listaTitularesProductosVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nuevo TitularesProductos";
        require APP .
            'ModificacionProductoRia/vistas/formularioTitularesProductosVista.php';
    }

    /**
     * Método para registrar en la base de datos -TitularesProductos
     */
    public function guardar()
    {
        $this->lNegocioTitularesProductos->guardar($_POST);
    }

    /**
     * Obtenemos los datos del registro seleccionado para editar - Tabla:
     * TitularesProductos
     */
    public function editar()
    {
        $this->accion = "Editar TitularesProductos";
        $this->modeloTitularesProductos = $this->lNegocioTitularesProductos->buscar(
            $_POST["id"]);
        require APP .
            'ModificacionProductoRia/vistas/formularioTitularesProductosVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - TitularesProductos
     */
    public function borrar()
    {
        $this->lNegocioTitularesProductos->borrar($_POST['elementos']);
    }

    /**
     * Construye el código HTML para desplegar la lista de - TitularesProductos
     */
    public function tablaHtmlTitularesProductos($tabla)
    {
        $contador = 0;
        foreach ($tabla as $fila) {
            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_titular_producto'] .
                '"class="item" data-rutaAplicacion="' . URL_MVC_FOLDER .
                'ModificacionProductoRia\titularesproductos"
            		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
            		  data-destino="detalleItem">
            		  <td>' . ++$contador . '</td>
            		  <td style="white - space:nowrap; "><b>' . $fila['id_titular_producto'] .
                '</b></td>
                    <td>' . $fila['id_detalle_solicitud_producto'] . '</td>
                    <td>' . $fila['identificador_operador'] . '</td>
                    <td>' . $fila['razon_social'] . '</td>
                    </tr>'
            );
        }
    }

    public function modificarTitularidadProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSoliciudProducto)
    {
		$idArea = $parametros['id_area'];								 
        $tipoModificacion = $parametros['tipo_modificacion'];
        $rutaDocumentoRespaldo = $parametros['ruta_documento_respaldo'];
        $filaTitularidadProducto = '';
        $ingresoDatos = '';
        $banderaAcciones = false;

        switch ($estadoSoliciudProducto) {

            case 'Creado':
            case 'subsanacion':
                
                $banderaAcciones = true;
                $ingresoDatos = '<div data-linea="1">
                                    <label>RUC empresa:</label>
                                    <input type="text" name="identificador_operador" id="identificador_operador" data-tiempoatencion="' . $tiempoAtencion . ' días"  data-idareasolicitud="' . $idArea . '" class="validacion" required/>
                                </div>
                                <div id="res_cliente" data-linea="2"></div>';               
                
                $ingresoDatos .= '<hr/>
                                <div data-linea="3">
                                    <label>Documento de respaldo:</label>
                                </div>
                                <div data-linea="4">
                                    <input type="hidden" class="rutaArchivo" id="r' . $tipoModificacion . '" name="ruta_documento_respaldo" value="0"/>
                                    <input type="file" class="archivo'.$parametros['requiere_respaldo'].'" id="v' . $tipoModificacion . '" accept="application/pdf" />
                                    <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . ')</div>
                                    <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . MODI_PROD_RIA_URL . $this->rutaFecha . '">Subir archivo</button>
                                </div>
                                <hr/>
                                <div data-linea="5">
                        			<button type="button" class="mas" id="agregarTitularidadProducto" data-tipomodificacion="' . $tipoModificacion . '">Agregar</button>
                        		</div>';
                break;

        }

        $qDatosTitularesProductos = $this->lNegocioTitularesProductos->buscarLista(array(
            'id_detalle_solicitud_producto' => $idDetalleSolicitudProducto
        ));

        foreach ($qDatosTitularesProductos as $datosTitularesProducto) {

            $idDatoTitularidadProducto = $datosTitularesProducto['id_titular_producto'];
            $identificadorOperador = $datosTitularesProducto['identificador_operador'];
			$razonSocial = $datosTitularesProducto['razon_social'];

            $filaTitularidadProducto .= '
                <tr id="fila' . $idDatoTitularidadProducto . '">
                    <td>' . ($identificadorOperador != '' ? $identificadorOperador : '') . '</td>
                    <td>' . ($razonSocial != '' ? $razonSocial : '') . '</td>';								
            if ($banderaAcciones) {
                $filaTitularidadProducto .= '<td class="borrar">
                        <button type="button" name="eliminar" class="icono" onclick="fn_eliminarTitularidadProducto(' . $idDatoTitularidadProducto . '); return false;"/>
                        </td>';
            }
            $filaTitularidadProducto .= '</tr>';
        }

        $modificarTitularidadProducto = '';

        if($rutaDocumentoRespaldo){
            $modificarTitularidadProducto .= '
            <fieldset>
                <legend>Documento adjunto</legend>
                <div data-linea="1">
                    <label>Documento de respaldo: </label>' . ($rutaDocumentoRespaldo === 0 ? '<span class="alerta">No ha subido ningún archivo aún</span>':'<a href='.$rutaDocumentoRespaldo.' target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>') . '
                </div>
            </fieldset>';
        }

        $modificarTitularidadProducto .= '<fieldset  id="fTitularidadProducto">
        <legend>Modificar transferencia de registro de producto</legend>
        ' . $ingresoDatos . '
		<table id="tTitularidadProducto" style="width: 100%">
			<thead>
				<tr>
					<th>RUC empresa</th>
					<th>Razón social</th>					  
					<th></th>
				</tr>
			</thead>
			<tbody>' . $filaTitularidadProducto . '</tbody>
		</table>
        </fieldset>';

        return $modificarTitularidadProducto;
    }

    public function obtenerOperador()
    {
        $estado = 'FALLO';

        $identificadorOperador = $_POST['identificador_operador'];
        $idArea = $_POST['tipo_solicitud'];
        
        $arrayParametros = ['identificador_operador' => $identificadorOperador
                            , 'id_area' => $idArea];

        $operador = $this->lNegocioOperadores->obtenerDatosOperadorPorIdentificadorOperadorPorTipoSolicitudRia($arrayParametros);

        $registroOperador = '<label>Razón social: </label> El RUC no está registrado, o no posee un producto con el tipo de solicitud seleccionada';

        if (!empty($operador->current()->identificador_operador)) {
            $estado = 'EXITO';
            $registroOperador = '
                <label>Razón social: </label> 
                <input type="text" id="razon_social" name="razon_social" value= "' . $operador->current()->nombre_razon_social . '"  readonly="readonly" required/>';
        }

        echo json_encode(array(
            'estado' => $estado,
            'registroOperador' => $registroOperador
        ));
    }

    /**
     * Método para listar titularidad de producto agregada
     */
    public function generarFilaTitularidadProducto($idTitularidadProducto, $datosTitularidadProducto, $tiempoAtencion)
    {

        $this->listaDetalles = '
                        <tr id="fila' . $idTitularidadProducto . '">
                            <td>' . ($datosTitularidadProducto['identificador_operador'] != '' ? $datosTitularidadProducto['identificador_operador'] : '') . '</td>
							<td>' . ($datosTitularidadProducto['razon_social'] != '' ? $datosTitularidadProducto['razon_social'] : '') . '</td>
                            <td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarTitularidadProducto(' . $idTitularidadProducto . '); return false;"/></td>
                        </tr>';

        return $this->listaDetalles;
    }
}