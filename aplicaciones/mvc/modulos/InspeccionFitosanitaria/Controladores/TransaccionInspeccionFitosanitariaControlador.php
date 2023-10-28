<?php
 /**
 * Controlador TransaccionInspeccionFitosanitaria
 *
 * Este archivo controla la lógica del negocio del modelo:  TransaccionInspeccionFitosanitariaModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-07-21
 * @uses    TransaccionInspeccionFitosanitariaControlador
 * @package Inspeccionfitosanitaria
 * @subpackage Controladores
 */
 namespace Agrodb\Inspeccionfitosanitaria\Controladores;
 use Agrodb\Inspeccionfitosanitaria\Modelos\TransaccionInspeccionFitosanitariaLogicaNegocio;
 use Agrodb\Inspeccionfitosanitaria\Modelos\TransaccionInspeccionFitosanitariaModelo;
 
class TransaccionInspeccionFitosanitariaControlador extends BaseControlador 
{

		 private $lNegocioTransaccionInspeccionFitosanitaria = null;
		 private $modeloTransaccionInspeccionFitosanitaria = null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioTransaccionInspeccionFitosanitaria = new TransaccionInspeccionFitosanitariaLogicaNegocio();
		 $this->modeloTransaccionInspeccionFitosanitaria = new TransaccionInspeccionFitosanitariaModelo();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloTransaccionInspeccionFitosanitaria = $this->lNegocioTransaccionInspeccionFitosanitaria->buscarTransaccionInspeccionFitosanitaria();
		 $this->tablaHtmlTransaccionInspeccionFitosanitaria($modeloTransaccionInspeccionFitosanitaria);
		 require APP . 'Inspeccionfitosanitaria/vistas/listaTransaccionInspeccionFitosanitariaVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo TransaccionInspeccionFitosanitaria"; 
		 require APP . 'Inspeccionfitosanitaria/vistas/formularioTransaccionInspeccionFitosanitariaVista.php';
		}	/**
		* Método para registrar en la base de datos -TransaccionInspeccionFitosanitaria
		*/
		public function guardar()
		{
		  $this->lNegocioTransaccionInspeccionFitosanitaria->guardar($_POST);
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: TransaccionInspeccionFitosanitaria
		*/
		public function editar()
		{
		 $this->accion = "Editar TransaccionInspeccionFitosanitaria"; 
		 $this->modeloTransaccionInspeccionFitosanitaria = $this->lNegocioTransaccionInspeccionFitosanitaria->buscar($_POST["id"]);
		 require APP . 'Inspeccionfitosanitaria/vistas/formularioTransaccionInspeccionFitosanitariaVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - TransaccionInspeccionFitosanitaria
		*/
		public function borrar()
		{
		  $this->lNegocioTransaccionInspeccionFitosanitaria->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - TransaccionInspeccionFitosanitaria
		*/
		 public function tablaHtmlTransaccionInspeccionFitosanitaria($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_transaccion_inspeccion_fitosanitaria'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'Inspeccionfitosanitaria\transaccioninspeccionfitosanitaria"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_transaccion_inspeccion_fitosanitaria'] . '</b></td>
<td>'
		  . $fila['id_total_inspeccion_fitosanitaria'] . '</td>
<td>' . $fila['cantidad_aprobada_ingreso']
		  . '</td>
<td>' . $fila['cantidad_aprobada_egreso'] . '</td>
</tr>');
		}
		}
	}

}
