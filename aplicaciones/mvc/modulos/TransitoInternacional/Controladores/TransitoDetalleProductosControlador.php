<?php
 /**
 * Controlador TransitoDetalleProductos
 *
 * Este archivo controla la lógica del negocio del modelo:  TransitoDetalleProductosModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-11-08
 * @uses    TransitoDetalleProductosControlador
 * @package TransitoInternacional
 * @subpackage Controladores
 */
 namespace Agrodb\TransitoInternacional\Controladores;
 use Agrodb\TransitoInternacional\Modelos\TransitoDetalleProductosLogicaNegocio;
 use Agrodb\TransitoInternacional\Modelos\TransitoDetalleProductosModelo;
 
class TransitoDetalleProductosControlador extends BaseControlador 
{

		 private $lNegocioTransitoDetalleProductos = null;
		 private $modeloTransitoDetalleProductos = null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioTransitoDetalleProductos = new TransitoDetalleProductosLogicaNegocio();
		 $this->modeloTransitoDetalleProductos = new TransitoDetalleProductosModelo();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloTransitoDetalleProductos = $this->lNegocioTransitoDetalleProductos->buscarTransitoDetalleProductos();
		 $this->tablaHtmlTransitoDetalleProductos($modeloTransitoDetalleProductos);
		 require APP . 'TransitoInternacional/vistas/listaTransitoDetalleProductosVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo TransitoDetalleProductos"; 
		 require APP . 'TransitoInternacional/vistas/formularioTransitoDetalleProductosVista.php';
		}	/**
		* Método para registrar en la base de datos -TransitoDetalleProductos
		*/
		public function guardar()
		{
		  $this->lNegocioTransitoDetalleProductos->guardar($_POST);
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: TransitoDetalleProductos
		*/
		public function editar()
		{
		 $this->accion = "Editar TransitoDetalleProductos"; 
		 $this->modeloTransitoDetalleProductos = $this->lNegocioTransitoDetalleProductos->buscar($_POST["id"]);
		 require APP . 'TransitoInternacional/vistas/formularioTransitoDetalleProductosVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - TransitoDetalleProductos
		*/
		public function borrar()
		{
		  $this->lNegocioTransitoDetalleProductos->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - TransitoDetalleProductos
		*/
		 public function tablaHtmlTransitoDetalleProductos($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_transito_detalle_productos'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'TransitoInternacional\transitodetalleproductos"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_transito_detalle_productos'] . '</b></td>
<td>'
		  . $fila['id_transito_internacional'] . '</td>
<td>' . $fila['fecha_creacion']
		  . '</td>
<td>' . $fila['req_no'] . '</td>
</tr>');
		}
		}
	}

}
