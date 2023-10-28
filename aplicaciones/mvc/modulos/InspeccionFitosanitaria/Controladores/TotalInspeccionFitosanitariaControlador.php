<?php
 /**
 * Controlador TotalInspeccionFitosanitaria
 *
 * Este archivo controla la lógica del negocio del modelo:  TotalInspeccionFitosanitariaModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-07-21
 * @uses    TotalInspeccionFitosanitariaControlador
 * @package Inspeccionfitosanitaria
 * @subpackage Controladores
 */
 namespace Agrodb\Inspeccionfitosanitaria\Controladores;
 use Agrodb\Inspeccionfitosanitaria\Modelos\TotalInspeccionFitosanitariaLogicaNegocio;
 use Agrodb\Inspeccionfitosanitaria\Modelos\TotalInspeccionFitosanitariaModelo;
 
class TotalInspeccionFitosanitariaControlador extends BaseControlador 
{

		 private $lNegocioTotalInspeccionFitosanitaria = null;
		 private $modeloTotalInspeccionFitosanitaria = null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioTotalInspeccionFitosanitaria = new TotalInspeccionFitosanitariaLogicaNegocio();
		 $this->modeloTotalInspeccionFitosanitaria = new TotalInspeccionFitosanitariaModelo();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloTotalInspeccionFitosanitaria = $this->lNegocioTotalInspeccionFitosanitaria->buscarTotalInspeccionFitosanitaria();
		 $this->tablaHtmlTotalInspeccionFitosanitaria($modeloTotalInspeccionFitosanitaria);
		 require APP . 'Inspeccionfitosanitaria/vistas/listaTotalInspeccionFitosanitariaVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo TotalInspeccionFitosanitaria"; 
		 require APP . 'Inspeccionfitosanitaria/vistas/formularioTotalInspeccionFitosanitariaVista.php';
		}	/**
		* Método para registrar en la base de datos -TotalInspeccionFitosanitaria
		*/
		public function guardar()
		{
		  $this->lNegocioTotalInspeccionFitosanitaria->guardar($_POST);
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: TotalInspeccionFitosanitaria
		*/
		public function editar()
		{
		 $this->accion = "Editar TotalInspeccionFitosanitaria"; 
		 $this->modeloTotalInspeccionFitosanitaria = $this->lNegocioTotalInspeccionFitosanitaria->buscar($_POST["id"]);
		 require APP . 'Inspeccionfitosanitaria/vistas/formularioTotalInspeccionFitosanitariaVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - TotalInspeccionFitosanitaria
		*/
		public function borrar()
		{
		  $this->lNegocioTotalInspeccionFitosanitaria->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - TotalInspeccionFitosanitaria
		*/
		 public function tablaHtmlTotalInspeccionFitosanitaria($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_total_inspeccion_fitosanitaria'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'Inspeccionfitosanitaria\totalinspeccionfitosanitaria"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_total_inspeccion_fitosanitaria'] . '</b></td>
<td>'
		  . $fila['id_inspeccion_fitosanitaria'] . '</td>
<td>' . $fila['id_producto']
		  . '</td>
<td>' . $fila['nombre_producto'] . '</td>
</tr>');
		}
		}
	}

}
