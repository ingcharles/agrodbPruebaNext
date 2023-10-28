<?php
 /**
 * Controlador PublicoObjetivo
 *
 * Este archivo controla la lógica del negocio del modelo:  PublicoObjetivoModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-08-31
 * @uses    PublicoObjetivoControlador
 * @package RegistroCapacitaciones
 * @subpackage Controladores
 */
 namespace Agrodb\RegistroCapacitaciones\Controladores;
 use Agrodb\RegistroCapacitaciones\Modelos\PublicoObjetivoLogicaNegocio;
 use Agrodb\RegistroCapacitaciones\Modelos\PublicoMetaLogicaNegocio;
 use Agrodb\RegistroCapacitaciones\Modelos\PublicoObjetivoModelo;
 use Agrodb\RegistroCapacitaciones\Modelos\PublicoMetaModelo;
 
class PublicoObjetivoControlador extends BaseControlador 
{

		 private $lNegocioPublicoObjetivo = null;
		 private $lNegocioPublicoMeta = null;
		 private $modeloPublicoObjetivo = null;
		 private $modeloPublicoMeta=null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioPublicoObjetivo = new PublicoObjetivoLogicaNegocio();
		 $this->lNegocioPublicoMeta = new PublicoMetaLogicaNegocio();
		 $this->modeloPublicoObjetivo = new PublicoObjetivoModelo();
		 $this->modeloPublicoMeta=new PublicoMetaModelo();
		 $this->datosPublicoMeta = '';
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloPublicoObjetivo = $this->lNegocioPublicoObjetivo->buscarPublicoObjetivo();		
		 $this->tablaHtmlPublicoObjetivo($modeloPublicoObjetivo);
		 require APP . 'RegistroCapacitaciones/vistas/listaPublicoObjetivoVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo PublicoObjetivo"; 
		 require APP . 'RegistroCapacitaciones/vistas/formularioPublicoObjetivoVista.php';
		}	/**
		* Método para registrar en la base de datos -PublicoObjetivo
		*/
		public function guardar()
		{
		  $this->lNegocioPublicoObjetivo->guardar($_POST);
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: PublicoObjetivo
		*/
		public function editar()
		{
		 $this->accion = "Editar PublicoObjetivo"; 
		 $this->modeloPublicoObjetivo = $this->lNegocioPublicoObjetivo->buscar($_POST["id"]);
		 require APP . 'RegistroCapacitaciones/vistas/formularioPublicoObjetivoVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - PublicoObjetivo
		*/
		public function borrar()
		{
			
			$publicoObjetivo = $this->datosPublicoObjetivo = $this->lNegocioPublicoObjetivo->obtenerPublicoObjetivoXCursoCapacitacion($_POST["idCurso"]);
			if($publicoObjetivo->count()>1){
				$publicoMeta = $this->datosPublicoMeta = $this->lNegocioPublicoMeta->obtenerPublicoMetaXid($_POST["elementos"]);
				if($publicoMeta->count() == 0){
					$this->lNegocioPublicoObjetivo->borrar($_POST['elementos']);
					echo('EXITO');
				}else{
					echo('Fallo');
				}
			}else{
				echo('Empty');
			}
		}
		  //echo("entro a eliminar");
			//$this->lNegocioPublicoObjetivo->borrar($_POST['elementos']);
			
			/**
		* Construye el código HTML para desplegar la lista de - PublicoObjetivo
		*/
		 public function tablaHtmlPublicoObjetivo($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_publico_objetivo'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'RegistroCapacitaciones\publicoobjetivo"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_publico_objetivo'] . '</b></td>
			<td>'
		  . $fila['nombre_publico'] . '</td>
			<td>' . $fila['estado']
		  . '</td>
			<td>' . $fila['id_curso_capacitacion'] . '</td>
			</tr>');
		}
		}
	}

}
