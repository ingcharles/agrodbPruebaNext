<?php
 /**
 * Controlador ClasificacionProducto
 *
 * Este archivo controla la lógica del negocio del modelo:  ClasificacionProductoModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-09-10
 * @uses    ClasificacionProductoControlador
 * @package ModificacionProductoRia
 * @subpackage Controladores
 */
 namespace Agrodb\ModificacionProductoRia\Controladores;
 use Agrodb\ModificacionProductoRia\Modelos\ClasificacionProductoLogicaNegocio;
 use Agrodb\ModificacionProductoRia\Modelos\ClasificacionProductoModelo;
use Agrodb\Catalogos\Modelos\ProductosLogicaNegocio;
 
class ClasificacionProductoControlador extends BaseControlador 
{

		 private $lNegocioClasificacionProducto = null;
		 private $modeloClasificacionProducto = null;
		 private $lNegocioProductos = null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioClasificacionProducto = new ClasificacionProductoLogicaNegocio();
		 $this->modeloClasificacionProducto = new ClasificacionProductoModelo();
		 $this->lNegocioProductos = new ProductosLogicaNegocio();
		 $this->rutaFecha = date('Y') . '/' . date('m') . '/' . date('d');
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloClasificacionProducto = $this->lNegocioClasificacionProducto->buscarClasificacionProducto();
		 $this->tablaHtmlClasificacionProducto($modeloClasificacionProducto);
		 require APP . 'ModificacionProductoRia/vistas/listaClasificacionProductoVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo ClasificacionProducto"; 
		 require APP . 'ModificacionProductoRia/vistas/formularioClasificacionProductoVista.php';
		}	/**
		* Método para registrar en la base de datos -ClasificacionProducto
		*/
		public function guardar()
		{
		  $this->lNegocioClasificacionProducto->guardar($_POST);
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: ClasificacionProducto
		*/
		public function editar()
		{
		 $this->accion = "Editar ClasificacionProducto"; 
		 $this->modeloClasificacionProducto = $this->lNegocioClasificacionProducto->buscar($_POST["id"]);
		 require APP . 'ModificacionProductoRia/vistas/formularioClasificacionProductoVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - ClasificacionProducto
		*/
		public function borrar()
		{
		  $this->lNegocioClasificacionProducto->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - ClasificacionProducto
		*/
		 public function tablaHtmlClasificacionProducto($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_clasificacion_producto'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'ModificacionProductoRia\clasificacionproducto"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_clasificacion_producto'] . '</b></td>
<td>'
		  . $fila['id_detalle_solicitud_producto'] . '</td>
<td>' . $fila['id_tabla_origen']
		  . '</td>
<td>' . $fila['clasificacion_producto'] . '</td>
</tr>');
		}
		}
	}
	
	public function modificarClasificacionProducto($parametros, $tiempoAtencion, $idDetalleSolicitudProducto, $estadoSoliciudProducto)
	{
	    $tipoModificacion = $parametros['tipo_modificacion'];
	    $rutaDocumentoRespaldo = $parametros['ruta_documento_respaldo'];
	    $filaClasificacionProducto = '';
	    $ingresoDatos = '';
	    $banderaAcciones = false;

	    switch ($estadoSoliciudProducto) {
	        
	        case 'Creado':
	        case 'subsanacion':
	            
	            $qEstadoRegistroActual = $this->lNegocioProductos->buscarLista(array('id_producto' => $parametros['id_producto']));
	            $idProducto = $parametros['id_producto'];
	            $idSubtipoProducto = $qEstadoRegistroActual->current()->id_subtipo_producto;
	            
	            $banderaAcciones = true;
	            $ingresoDatos = '<div data-linea="1">
                                    <label>Subtipo producto: </label>
                                    <select name="id_subtipo_producto" id="id_subtipo_producto" data-tiempoatencion="' . $tiempoAtencion . ' días" class="validacion">
                                        <option value="">Seleccionar....</option>' . $this->comboSubtipoProductoPorIdSubtipoProducto($idProducto, $idSubtipoProducto) . '</select>
                                </div>';

	            $ingresoDatos .= '<hr/>
                                <div data-linea="2">
                                    <label>Documento de respaldo:</label>
                                </div>
                                <div data-linea="3">
                                    <input type="hidden" class="rutaArchivo" id="r' . $tipoModificacion . '" name="ruta_documento_respaldo" value="0"/>
                                    <input type="file" class="archivo'.$parametros['requiere_respaldo'].'" id="v' . $tipoModificacion . '" accept="application/pdf" />
                                    <div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . '</div>
                                    <button type="button" class="subirArchivo adjunto" data-rutaCarga="' . MODI_PROD_RIA_URL . $this->rutaFecha . '">Subir archivo</button>
                                </div>
                                <hr/>
                                <div data-linea="4">
                                    <button type="button" class="mas" id="agregarClasificacionProducto" data-tipomodificacion="' . $tipoModificacion . '">Agregar</button>
                        		</div>';
	            break;
	            
	    }
	    
	    $qClasificacionProducto = $this->lNegocioClasificacionProducto->buscarLista(array(
	        'id_detalle_solicitud_producto' => $idDetalleSolicitudProducto
	    ));
	    
	    $fila = 0;
	    
	    foreach ($qClasificacionProducto as $datosClasificacionProducto) {
	        
	        $fila = $fila + 1;
	        
	        $idDatoClasificacionProducto = $datosClasificacionProducto['id_clasificacion_producto'];
	        $clasificacionProducto = $datosClasificacionProducto['clasificacion_producto'];
	        	        	        
	        $filaClasificacionProducto .= '
                <tr id="fila' . $idDatoClasificacionProducto . '">
                    <td>' . ($clasificacionProducto != '' ? $clasificacionProducto : '') . '</td>';									
	        if ($banderaAcciones) {
	            $filaClasificacionProducto .= '<td class="borrar">
                        <button type="button" name="eliminar" class="icono" onclick="fn_eliminarClasificacionProducto(' . $idDatoClasificacionProducto . '); return false;"/>
                        </td>';
	        }
	        $filaClasificacionProducto .= '</tr>';
	    }
	    
	    $modificarClasificacionProducto = '';
	    
	    if($rutaDocumentoRespaldo){
	        $modificarClasificacionProducto .= '
            <fieldset>
                <legend>Documento adjunto</legend>
                <div data-linea="1">
                    <label>Certificado de producto: </label>' . ($rutaDocumentoRespaldo === 0 ? '<span class="alerta">No ha subido ningún archivo aún</span>':'<a href='.$rutaDocumentoRespaldo.' target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>') . '
                </div>
            </fieldset>';
	    }
	    
	    $modificarClasificacionProducto .= '<fieldset  id="fClasificacionProducto">
        <legend>Modificar clasificación de producto</legend>
        ' . $ingresoDatos . '
		<table id="tClasificacionProducto" style="width: 100%">
			<thead>
				<tr>
					<th>Descripción</th>
                    <th></th>
				</tr>
			</thead>
			<tbody>' . $filaClasificacionProducto . '</tbody>
		</table>
        </fieldset>';
	    
	    return $modificarClasificacionProducto;
	}
	
	/**
	 * Método para listar clasificacion producto agregado
	 */
	public function generarFilaClasificacionProducto($idClasificacionProducto, $datosClasificacionProducto, $tiempoAtencion)
	{
	    $clasificacionProducto = $datosClasificacionProducto['clasificacion_producto'];
	    
	    $this->listaDetalles = '
                        <tr id="fila' . $idClasificacionProducto . '">
                            <td>' . ($clasificacionProducto != '' ? $clasificacionProducto : '') . '</td>
                            <td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarClasificacionProducto(' . $idClasificacionProducto . '); return false;"/></td>
                        </tr>';
	    
	    return $this->listaDetalles;
	}

}
