<?php
 /**
 * Controlador RedistribucionCuv
 *
 * Este archivo controla la lógica del negocio del modelo:  RedistribucionCuvModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2023-03-21
 * @uses    RedistribucionCuvControlador
 * @package AsignacionCuv
 * @subpackage Controladores
 */
 namespace Agrodb\AsignacionCuv\Controladores;
 use Agrodb\AsignacionCuv\Modelos\RedistribucionCuvLogicaNegocio;
 use Agrodb\AsignacionCuv\Modelos\RedistribucionCuvModelo;
 
class RedistribucionCuvControlador extends BaseControlador 
{

		 private $lNegocioRedistribucionCuv = null;
		 private $modeloRedistribucionCuv = null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioRedistribucionCuv = new RedistribucionCuvLogicaNegocio();
		 $this->modeloRedistribucionCuv = new RedistribucionCuvModelo();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloRedistribucionCuv = $this->lNegocioRedistribucionCuv->buscarRedistribucionCuv();
		 $this->tablaHtmlRedistribucionCuv($modeloRedistribucionCuv);
		 require APP . 'AsignacionCuv/vistas/listaRedistribucionCuvVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo RedistribucionCuv"; 
		 require APP . 'AsignacionCuv/vistas/formularioRedistribucionCuvVista.php';
		}	/**
		* Método para registrar en la base de datos -RedistribucionCuv
		*/
		public function guardar()
		{
		  $this->lNegocioRedistribucionCuv->guardar($_POST);
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: RedistribucionCuv
		*/
		public function editar()
		{
		 $this->accion = "Editar RedistribucionCuv"; 
		 $this->modeloRedistribucionCuv = $this->lNegocioRedistribucionCuv->buscar($_POST["id"]);
		 require APP . 'AsignacionCuv/vistas/formularioRedistribucionCuvVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - RedistribucionCuv
		*/
		public function borrar()
		{
		  $this->lNegocioRedistribucionCuv->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - RedistribucionCuv
		*/
		 public function tablaHtmlRedistribucionCuv($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_redistribucion_cuv'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'AsignacionCuv\redistribucioncuv"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_redistribucion_cuv'] . '</b></td>
<td>'
		  . $fila['id_solicitud_redistribucion_cuv'] . '</td>
<td>' . $fila['codigo_cuv_inicio']
		  . '</td>
<td>' . $fila['codigo_cuv_fin'] . '</td>
</tr>');
		}
		}
	}

}
