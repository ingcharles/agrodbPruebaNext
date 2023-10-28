<?php
 /**
 * Controlador TransitoInternacional
 *
 * Este archivo controla la lógica del negocio del modelo:  TransitoInternacionalModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-11-08
 * @uses    TransitoInternacionalControlador
 * @package TransitoInternacional
 * @subpackage Controladores
 */
 namespace Agrodb\TransitoInternacional\Controladores;
 use Agrodb\TransitoInternacional\Modelos\TransitoInternacionalLogicaNegocio;
 use Agrodb\TransitoInternacional\Modelos\TransitoInternacionalModelo;
 
class TransitoInternacionalControlador extends BaseControlador 
{

		 private $lNegocioTransitoInternacional = null;
		 private $modeloTransitoInternacional = null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioTransitoInternacional = new TransitoInternacionalLogicaNegocio();
		 $this->modeloTransitoInternacional = new TransitoInternacionalModelo();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloTransitoInternacional = $this->lNegocioTransitoInternacional->buscarTransitoInternacional();
		 $this->tablaHtmlTransitoInternacional($modeloTransitoInternacional);
		 require APP . 'TransitoInternacional/vistas/listaTransitoInternacionalVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo TransitoInternacional"; 
		 require APP . 'TransitoInternacional/vistas/formularioTransitoInternacionalVista.php';
		}	/**
		* Método para registrar en la base de datos -TransitoInternacional
		*/
		public function guardar()
		{
		  $this->lNegocioTransitoInternacional->guardar($_POST);
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: TransitoInternacional
		*/
		public function editar()
		{
		 $this->accion = "Editar TransitoInternacional"; 
		 $this->modeloTransitoInternacional = $this->lNegocioTransitoInternacional->buscar($_POST["id"]);
		 require APP . 'TransitoInternacional/vistas/formularioTransitoInternacionalVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - TransitoInternacional
		*/
		public function borrar()
		{
		  $this->lNegocioTransitoInternacional->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - TransitoInternacional
		*/
		 public function tablaHtmlTransitoInternacional($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_transito_internacional'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'TransitoInternacional\transitointernacional"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_transito_internacional'] . '</b></td>
<td>'
		  . $fila['fecha_creacion'] . '</td>
<td>' . $fila['req_no']
		  . '</td>
<td>' . $fila['numero_documento'] . '</td>
</tr>');
		}
		}
	}

}
