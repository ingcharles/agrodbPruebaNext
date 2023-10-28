<?php
 /**
 * Controlador Empresa
 *
 * Este archivo controla la lógica del negocio del modelo:  EmpresaModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-08-31
 * @uses    EmpresaControlador
 * @package EmisionCertificacionOrigen
 * @subpackage Controladores
 */
 namespace Agrodb\EmisionCertificacionOrigen\Controladores;
 use Agrodb\EmisionCertificacionOrigen\Modelos\EmpresaLogicaNegocio;
 use Agrodb\EmisionCertificacionOrigen\Modelos\EmpresaModelo;
 use Agrodb\EmisionCertificacionOrigen\Modelos\EmpresaEmpleadoModelo;
 use Agrodb\EmisionCertificacionOrigen\Modelos\EmpresaEmpleadoLogicaNegocio;
 use Agrodb\Core\Constantes;
 use Agrodb\Core\Mensajes;
 
class EmpresaControlador extends BaseControlador 
{

		 private $lNegocioEmpresa = null;
		 private $modeloEmpresa = null;
		 private $lNegocioEmpresaEmpleado = null;
		 private $modeloEmpresaEmpleado = null;
		 private $accion = null;
		 private $buscarEmpleadoPorId = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioEmpresa = new EmpresaLogicaNegocio();
		 $this->modeloEmpresa = new EmpresaModelo();
		 $this->lNegocioEmpresaEmpleado = new EmpresaEmpleadoLogicaNegocio();
		 $this->modeloEmpresaEmpleado = new EmpresaEmpleadoModelo();
		 $this->contenidoBusqueda = '';
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $this->cargarPanelAdministracion();
		 $modeloEmpresa = $this->lNegocioEmpresa->buscarEmpleadosPorEmpresa($_SESSION['usuario']);
		 $this->tablaHtmlEmpresa($modeloEmpresa);
		 require APP . 'EmisionCertificacionOrigen/vistas/listaEmpresaVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo Empleado"; 
		 require APP . 'EmisionCertificacionOrigen/vistas/formularioEmpresaVistaNuevo.php';
		}	/**
		* Método para registrar en la base de datos -Empresa
		*/
		public function guardar()
		{
			
			$arrayParametros = array(
				'identificador' => $_SESSION['usuario'],
			);
			$empresa = $this->lNegocioEmpresa->obtenerDatosUsuario($arrayParametros);

			$_POST["identificador_empresa"] = $empresa->current()->identificador;
			$_POST["nombre_empresa"] = $empresa->current()->nombres;

			$datos = explode('-', $_POST['datosEmpleado']);
			$_POST["identificador_empleado"] = trim($datos[1]);
			$_POST["nombres_empleado"] = $datos[0];

			$_POST['banderaEmpresa'] = false;
			$_POST['banderaEmpleado'] = false;
			$_POST['banderaEmpresaEmpleado'] = false;
			


			$buscarEmpresaRegistrada = $this->lNegocioEmpresa->buscarEmpresaRegistrada($_POST['identificador_empresa'],$_POST['nombre_empresa']);
			if ($buscarEmpresaRegistrada->count() > 0){
				$idEmpresa = $buscarEmpresaRegistrada->current()->id_empresa;
				$buscarEmpleadoRegistrado = $this->lNegocioEmpresa->buscarEmpleadoRegistrado($_POST['identificador_empleado'],$_POST['nombres_empleado'],NULL);
				if ($buscarEmpleadoRegistrado->count() > 0){
					$idEmpleado = $buscarEmpleadoRegistrado->current()->id_empleado;
					$buscarEmpresaEmpleadoRegistrado = $this->lNegocioEmpresa->buscarEmpresaEmpleadoRegistrado($idEmpleado,$idEmpresa);
					if($buscarEmpresaEmpleadoRegistrado->count() > 0){
						$estado = "Fallo";
						$mensaje = "Este empleado ya se encuenta registrado en esta empresa..! ";
						echo json_encode(array(
							'estado' => $estado, 
							'mensaje' => $mensaje
						));	
					}else{
						$buscarEmpresaEmpleadoRegistrado = $this->lNegocioEmpresa->buscarEmpresaEmpleadoRegistrado($idEmpleado,NULL);
						if($buscarEmpresaEmpleadoRegistrado->count() > 0){
							$estado = "Fallo";
							$mensaje = "Este empleado ya se encuenta registrado en otra empresa..! ";
							echo json_encode(array(
								'estado' => $estado, 
								'mensaje' => $mensaje
							));	
						}else{
							$_POST['idEmpresaObtenida'] = $idEmpresa;
							$_POST['idEmpleadoObtenido'] = $idEmpleado;
							$_POST['banderaEmpresaEmpleado'] = true;
							$this->insertarDatos($_POST);
						}

					}
				}else{
					$_POST['idEmpresaObtenida'] = $idEmpresa;
					$_POST['banderaEmpleado'] = true;
					$_POST['banderaEmpresaEmpleado'] = true;
					$this->insertarDatos($_POST);
				}

			}else{
				$buscarEmpleadoRegistrado = $this->lNegocioEmpresa->buscarEmpleadoRegistrado($_POST['identificador_empleado'],$_POST['nombres_empleado'],NULL);
				if ($buscarEmpleadoRegistrado->count() > 0){
					$idEmpleado = $buscarEmpleadoRegistrado->current()->id_empleado;
					$buscarEmpresaEmpleadoRegistrado = $this->lNegocioEmpresa->buscarEmpresaEmpleadoRegistrado($idEmpleado,NULL);
					if($buscarEmpresaEmpleadoRegistrado->count() > 0){
						$estado = "Fallo";
						$mensaje = "Este empleado ya se encuenta registrado en otra empresa..! ";
						echo json_encode(array(
							'estado' => $estado, 
							'mensaje' => $mensaje
						));	
					}else{
						$_POST['banderaEmpresa'] = true;
						$_POST['idEmpleadoObtenido'] = $idEmpleado;
						$_POST['banderaEmpresaEmpleado'] = true;
						$this->insertarDatos($_POST);
					}
				}else{
					$_POST['banderaEmpresa'] = true;
					$_POST['banderaEmpleado'] = true;
					$_POST['banderaEmpresaEmpleado'] = true;
					$this->insertarDatos($_POST);
				}
				
			}

		  
		}	
		//metodo que sirve para guardar los datos del empleado hacia una empresa
		public function insertarDatos($datos)
		{
			$identificadorEmpleado = $datos['identificador_empleado'] ;
			$this->lNegocioEmpresa->guardar($datos);
			$this->asignarModulo($identificadorEmpleado);
			Mensajes::exito(Constantes::GUARDADO_CON_EXITO);
		}

		//metodo que sirve para activar/inactivar un empleado de una empresa
		public function activarInactivarEmpleadoEmpresa(){
			
			$datos = explode('-', $_POST['empresa_empleado']);
			$arrayParametros = array(
				'idEmpresa' => $datos[0],
				'idEmpleado' => $datos[1],
				'estado' => $datos[2],
			);
			$this->lNegocioEmpresa->cambiarEstadoEmpleado($arrayParametros);
			if($arrayParametros['estado'] == 'activo'){
				$this->eliminarModulo($_POST['identificadorEmpleado']);
			}
			Mensajes::exito(Constantes::GUARDADO_CON_EXITO);
		}

		//asginar modulo a empleado de empresa
		public function asignarModulo($identificadorEmpleado)
		{
			$this->lNegocioEmpresa->activarModulo($identificadorEmpleado);
			$this->lNegocioEmpresa->activarPerfil($identificadorEmpleado);
		}

		//quitar modulo a empleado de empresa
		public function eliminarModulo($identificadorEmpleado)
		{
			$this->lNegocioEmpresa->eliminarModulo($identificadorEmpleado);
			$this->lNegocioEmpresa->eliminarPerfil($identificadorEmpleado);
		}

		/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: Empresa
		*/
		public function editar()
		{
		 $this->accion = "Inactivar Empleado"; 
		 $this->modeloEmpresa = $this->lNegocioEmpresa->buscar($_POST["id"]);
		
		 $this->busquedaEmpleados($_POST["id"]);

		 require APP . 'EmisionCertificacionOrigen/vistas/formularioEmpresaVistaEditar.php';
		}	/**
		* Método para borrar un registro en la base de datos - Empresa
		*/
		public function borrar()
		{
		  $this->lNegocioEmpresa->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - Empresa
		*/	
		 public function tablaHtmlEmpresa($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_empresa']. "-".$fila['id_empleado'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'EmisionCertificacionOrigen\empresa"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; ">' . $fila['nombre_empresa'] . '</td>
		  <td>'. $fila['nombres_empleado'] . '</td>
		  <td><b>' . $fila['estado']. '</b></td>
		  </tr>');
		}
		}
	}


	public function cargarPanelAdministracion()
	 {
	 
		 $this->panelBusquedaAdministrador = '<table class="filtro" style="width: 100%;">
			 <tbody>
			 
				 <tr  style="width: 100%;">
					 <td  style="align : left"><label>Identificación Empleado:</label> </td>
						 <td>
						 <input id="identificador" type="text" name="identificador" >
							 
						 </td>
				 </tr>
				 <tr class="tecnico">
					 <td><label>Nombre Empleado:</label> </td>
						 <td>
							 <input id="nombre_empleado" type="text" name="nombre_empleado" value="" >
						 </td>
				 </tr>
				 <tr class="tecnico">
				 <td><label>Apellido Empleado:</label> </td>
					 <td>
						 <input id="apellido_empleado" type="text" name="apellido_empleado" value="" >
					 </td>
			 	</tr>
				 <tr>
					 <td class="col-sm-6">
						 Los campos con * son obligatorios.
					 </td> 
					 <td class="col-sm-6">
						 <button type="button" id="btnFiltrar">Consultar</button>
					 </td> 
				 </tr>
			 </tbody>
		 </table>';
	 }

	 public function buscarEmpleados(){
		$estado = '';
		$mensaje = '';
		$contenido = '';
		$arrayParametros = array(
			'identificador' => $_POST['identificadorEmpleado'],
			'nombreEmpleado' => $_POST['nombreEmpleado'],
		);

		$empleados = $this->lNegocioEmpresa->obtenerDatosUsuario($arrayParametros);
		if($empleados->count() > 0){
			$arrayObj = array("Seleccione....");
			foreach($empleados as $item){
				array_push($arrayObj, ($item->nombres.' - '.$item->identificador));	
	   		}
			   $estado = 'EXITO';
			   $contenido =$arrayObj;
		}else{
			$estado = 'FALLO';
			$mensaje = 'No se encontraron registros para la búsqueda realizada...!';
			
		}
		$arrayObj = null;
		echo json_encode(array(
			'estado' => $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido
		));
	 }

	 public function busquedaEmpleados($idEmpleado){
		$codEmpleado = explode('-', $idEmpleado);
		$this->buscarEmpleadoPorId = $this->lNegocioEmpresa->buscarEmpleadoRegistrado(NULL, NULL, $codEmpleado[1]);

		$estado = $this->buscarEmpleadoPorId->current()->estado;

		if($estado == 'activo'){
			$estadoBoton = 'Inactivar';
		}else{
			$estadoBoton = 'Activar';
		}

		$this->contenidoBusqueda= '<fieldset>
								<legend>Datos del Empleado</legend>
								<input id="identificadorEmpleado" name="empresa_empleado" type="hidden" value="' . $idEmpleado ."-".$estado. '"/>
								<div data-linea="1">
									<label>Identificación Empleado:</label>
									<input id="identificadorEmpleado"  name="identificadorEmpleado" type="text" value="' . $this->buscarEmpleadoPorId->current()->identificador_empleado . '" readonly/>
								</div>
								<div data-linea="1">
									<label>Nombres o Apellidos:</label>
									<input  id="nombreEmpleado"  type="text"  value="' . trim($this->buscarEmpleadoPorId->current()->nombres_empleado) . '" readonly/>
								</div>
							</fieldset>
							
							<div data-linea="4" class="editable">
							<button type="submit" class="guardar" id="inactivar">' . $estadoBoton . '</button>';
		return $this->contenidoBusqueda;				
	 }
	 public function listarEmpleadosRegistrados()
	 {
		 
		 $estado = '';
		 $mensaje = '';
		 $contenido = '';
 
		 $identificador = $_POST['identificador'];
		 $nombre_empleado = $_POST['nombre_empleado'];
		 $apellido_empleado = $_POST['apellido_empleado'];
		 
 
		 $arrayParametros = array(
			 'identificador' => $identificador,
			 'nombre_empleado' => $nombre_empleado ,
			 'apellido_empleado' => $apellido_empleado ,
		 );
 
		$datosEmpleados = $this->lNegocioEmpresaEmpleado->listarEmpleadosCentroFaenamiento($arrayParametros);
		 
		 if($datosEmpleados->count() != 0){
			 $this->tablaHtmlEmpresa($datosEmpleados);
			 $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
			 $estado = 'EXITO';
		 }else{
			 $estado = 'FALLO';
			 $mensaje = 'No se encontraron registros...!';
		 }
		 
 
		 echo json_encode(array(
			 'estado' => $estado,
			 'mensaje' => $mensaje,
			 'contenido' => $contenido
		 ));
	 }
}
