<?php
 /**
 * Controlador TemasCursos
 *
 * Este archivo controla la lógica del negocio del modelo:  TemasCursosModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-08-31
 * @uses    TemasCursosControlador
 * @package RegistroCapacitaciones
 * @subpackage Controladores
 */
 namespace Agrodb\RegistroCapacitaciones\Controladores;
 use Agrodb\RegistroCapacitaciones\Modelos\TemasCursosLogicaNegocio;
 use Agrodb\RegistroCapacitaciones\Modelos\TemasCursosModelo;

 use Agrodb\RegistroCapacitaciones\Modelos\TemasEjecutadosLogicaNegocio;
 use Agrodb\RegistroCapacitaciones\Modelos\TemasEjecutadosModelo;
 
 
 
class TemasCursosControlador extends BaseControlador 
{

		 private $lNegocioTemasCursos = null;
		 private $lNegocioTemasEjecutados = null;
		 private $modeloTemasCursos = null;
		 private $accion = null;
		 private $datosTemasCurso = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioTemasCursos = new TemasCursosLogicaNegocio();
		 $this->modeloTemasCursos = new TemasCursosModelo();

		 $this->lNegocioTemasEjecutados = new TemasEjecutadosLogicaNegocio();
		 $this->modeloTemasEjecutados = new TemasEjecutadosModelo();

		 $this->contenidoTemaCurso = '';
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloTemasCursos = $this->lNegocioTemasCursos->buscarTemasCursos();
		 $this->tablaHtmlTemasCursos($modeloTemasCursos);
		 require APP . 'RegistroCapacitaciones/vistas/listaTemasCursosVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo TemasCursos"; 
		 require APP . 'RegistroCapacitaciones/vistas/formularioTemasCursosVista.php';
		}	/**
		* Método para registrar en la base de datos -TemasCursos
		*/
		public function guardar()
		{
		  $this->lNegocioTemasCursos->guardar($_POST);
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: TemasCursos
		*/
		public function editar()
		{
		 $this->accion = "Editar TemasCursos"; 
		 $this->modeloTemasCursos = $this->lNegocioTemasCursos->buscar($_POST["id"]);
		 require APP . 'RegistroCapacitaciones/vistas/formularioTemasCursosVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - TemasCursos
		*/
		public function borrar()
		{
			$temasCursos = $this->datosTemasCurso = $this->lNegocioTemasCursos->obtenerTemasXCursoCapacitacion($_POST["idCurso"]);
			
			if($temasCursos->count()>1){
				$temasEjecutados = $this->datosTemasEjecutados = $this->lNegocioTemasEjecutados->obtenerTemasEjecutadosXid($_POST["elementos"]);
				if($temasEjecutados->count() == 0){
					$this->lNegocioTemasCursos->borrar($_POST['elementos']);
					echo('EXITO');
					
				}else{
					echo('Fallo');
				}
			}else{
				echo('Empty');
			}
		}	
		/**
		* Construye el código HTML para desplegar la lista de - TemasCursos
		*/
		 public function tablaHtmlTemasCursos($tabla) {
			{
				$contador = 0;
				foreach ($tabla as $fila) {
				$this->itemsFiltrados[] = array(
				'<tr id="' . $fila['id_tema_curso'] . '"
				class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'RegistroCapacitaciones\temascursos"
				data-opcion="editar" ondragstart="drag(event)" draggable="true"
				data-destino="detalleItem">
				<td>' . ++$contador . '</td>
				<td style="white - space:nowrap; "><b>' . $fila['id_tema_curso'] . '</b></td>
					<td>'
				. $fila['nombre_tema'] . '</td>
					<td>' . $fila['estado']
					. '</td>
					<td>' . $fila['id_curso_capacitacion'] . '</td>
					</tr>');
					}
			}
		}

}
