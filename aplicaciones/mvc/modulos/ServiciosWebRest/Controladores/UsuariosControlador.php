<?php
 /**
 * Controlador Usuarios
 *
 * Este archivo controla la lógica del negocio del modelo:  UsuariosModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2023-05-25
 * @uses    UsuariosControlador
 * @package ServicioWebRest
 * @subpackage Controladores
 */
 namespace Agrodb\ServiciosWebRest\Controladores;
 use Agrodb\ServiciosWebRest\Modelos\UsuariosLogicaNegocio;
 use Agrodb\ServiciosWebRest\Modelos\UsuariosModelo;
 use Agrodb\ServiciosWebRest\Controladores\BaseControlador;
 
class UsuariosControlador extends BaseControlador 
{

		 private $lNegocioUsuarios = null;
		 private $modeloUsuarios = null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioUsuarios = new UsuariosLogicaNegocio();
		 $this->modeloUsuarios = new UsuariosModelo();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloUsuarios = $this->lNegocioUsuarios->buscarUsuarios();
		 $this->tablaHtmlUsuarios($modeloUsuarios);
		 require APP . 'ServicioWebRest/vistas/listaUsuariosVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo Usuarios"; 
		 require APP . 'ServicioWebRest/vistas/formularioUsuariosVista.php';
		}	/**
		* Método para registrar en la base de datos -Usuarios
		*/
		public function guardar()
		{
		  $this->lNegocioUsuarios->guardar($_POST);
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: Usuarios
		*/
		public function editar()
		{
		 $this->accion = "Editar Usuarios"; 
		 $this->modeloUsuarios = $this->lNegocioUsuarios->buscar($_POST["id"]);
		 require APP . 'ServicioWebRest/vistas/formularioUsuariosVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - Usuarios
		*/
		public function borrar()
		{
		  $this->lNegocioUsuarios->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - Usuarios
		*/
		 public function tablaHtmlUsuarios($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_usuario'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'ServicioWebRest\usuarios"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_usuario'] . '</b></td>
<td>'
		  . $fila['identificador'] . '</td>
<td>' . $fila['clave']
		  . '</td>
<td>' . $fila['token'] . '</td>
</tr>');
		}
		}
	}

}
