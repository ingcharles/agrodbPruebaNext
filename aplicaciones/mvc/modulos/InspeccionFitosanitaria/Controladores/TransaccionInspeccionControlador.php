<?php
 /**
 * Controlador TransaccionInspeccion
 *
 * Este archivo controla la lógica del negocio del modelo:  TransaccionInspeccionModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-15
 * @uses    TransaccionInspeccionControlador
 * @package InspeccionFitosanitaria
 * @subpackage Controladores
 */
 namespace Agrodb\InspeccionFitosanitaria\Controladores;
 use Agrodb\InspeccionFitosanitaria\Modelos\TransaccionInspeccionLogicaNegocio;
 use Agrodb\InspeccionFitosanitaria\Modelos\TransaccionInspeccionModelo;
 
class TransaccionInspeccionControlador extends BaseControlador 
{

		 private $lNegocioTransaccionInspeccion = null;
		 private $modeloTransaccionInspeccion = null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioTransaccionInspeccion = new TransaccionInspeccionLogicaNegocio();
		 $this->modeloTransaccionInspeccion = new TransaccionInspeccionModelo();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloTransaccionInspeccion = $this->lNegocioTransaccionInspeccion->buscarTransaccionInspeccion();
		 $this->tablaHtmlTransaccionInspeccion($modeloTransaccionInspeccion);
		 require APP . 'InspeccionFitosanitaria/vistas/listaTransaccionInspeccionVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo TransaccionInspeccion"; 
		 require APP . 'InspeccionFitosanitaria/vistas/formularioTransaccionInspeccionVista.php';
		}	/**
		* Método para registrar en la base de datos -TransaccionInspeccion
		*/
		public function guardar()
		{
		  $this->lNegocioTransaccionInspeccion->guardar($_POST);
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: TransaccionInspeccion
		*/
		public function editar()
		{
		 $this->accion = "Editar TransaccionInspeccion"; 
		 $this->modeloTransaccionInspeccion = $this->lNegocioTransaccionInspeccion->buscar($_POST["id"]);
		 require APP . 'InspeccionFitosanitaria/vistas/formularioTransaccionInspeccionVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - TransaccionInspeccion
		*/
		public function borrar()
		{
		  $this->lNegocioTransaccionInspeccion->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - TransaccionInspeccion
		*/
		 public function tablaHtmlTransaccionInspeccion($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_transaccion_inspeccion'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'InspeccionFitosanitaria\transaccioninspeccion"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_transaccion_inspeccion'] . '</b></td>
<td>'
		  . $fila['id_inspeccion_fitosanitaria'] . '</td>
<td>' . $fila['id_producto_inspeccion_fitosanitaria']
		  . '</td>
<td>' . $fila['valor_egreso'] . '</td>
</tr>');
		}
		}
	}

}
