<?php
 /**
 * Controlador EntregasCuv
 *
 * Este archivo controla la lógica del negocio del modelo:  EntregasCuvModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2023-03-21
 * @uses    EntregasCuvControlador
 * @package AsignacionCuv
 * @subpackage Controladores
 */
 namespace Agrodb\AsignacionCuv\Controladores;
 use Agrodb\AsignacionCuv\Modelos\EntregasCuvLogicaNegocio;
 use Agrodb\AsignacionCuv\Modelos\EntregasCuvModelo;
 
class EntregasCuvControlador extends BaseControlador 
{

		 private $lNegocioEntregasCuv = null;
		 private $modeloEntregasCuv = null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioEntregasCuv = new EntregasCuvLogicaNegocio();
		 $this->modeloEntregasCuv = new EntregasCuvModelo();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloEntregasCuv = $this->lNegocioEntregasCuv->buscarEntregasCuv();
		 $this->tablaHtmlEntregasCuv($modeloEntregasCuv);
		 require APP . 'AsignacionCuv/vistas/listaEntregasCuvVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo EntregasCuv"; 
		 require APP . 'AsignacionCuv/vistas/revisionSolicitudesAlerta.php';
		}	/**
		* Método para registrar en la base de datos -EntregasCuv
		*/
		public function guardar()
		{
		  $this->lNegocioEntregasCuv->guardar($_POST);
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: EntregasCuv
		*/
		public function editar()
		{
		 $this->accion = "Editar EntregasCuv"; 
		 $this->modeloEntregasCuv = $this->lNegocioEntregasCuv->buscar($_POST["id"]);
		 require APP . 'AsignacionCuv/vistas/formularioEntregasCuvVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - EntregasCuv
		*/
		public function borrar()
		{
		  $this->lNegocioEntregasCuv->borrar($_POST['elementos']);

		}	/**
		* Construye el código HTML para desplegar la lista de - EntregasCuv
		*/
		 public function tablaHtmlEntregasCuv($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_entregas_cuv'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'AsignacionCuv\EntregasCuv"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_entregas_cuv'] . '</b></td>
<td>'
		  . $fila['id_solicitud_asignacion_cuv'] . '</td>
<td>' . $fila['codigo_cuv_inicio']
		  . '</td>
<td>' . $fila['codigo_cuv_fin'] . '</td>
</tr>');
		}
		}
	}

}
