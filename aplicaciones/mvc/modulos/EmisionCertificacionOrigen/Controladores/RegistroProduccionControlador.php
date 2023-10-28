<?php
 /**
 * Controlador RegistroProduccion
 *
 * Este archivo controla la lógica del negocio del modelo:  RegistroProduccionModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2020-09-18
 * @uses    RegistroProduccionControlador
 * @package EmisionCertificacionOrigen
 * @subpackage Controladores
 */
 namespace Agrodb\EmisionCertificacionOrigen\Controladores;
 use Agrodb\EmisionCertificacionOrigen\Modelos\RegistroProduccionLogicaNegocio;
 use Agrodb\EmisionCertificacionOrigen\Modelos\RegistroProduccionModelo;
 use Agrodb\EmisionCertificacionOrigen\Modelos\ProductosLogicaNegocio;
 use Agrodb\EmisionCertificacionOrigen\Modelos\ProductosModelo;
 use Agrodb\EmisionCertificacionOrigen\Modelos\ProductosTempLogicaNegocio;
 use Agrodb\EmisionCertificacionOrigen\Modelos\ProductosTempModelo;
 use Agrodb\EmisionCertificacionOrigen\Modelos\SubproductosTempLogicaNegocio;
 use Agrodb\EmisionCertificacionOrigen\Modelos\SubproductosTempModelo;
 use Agrodb\EmisionCertificacionOrigen\Modelos\SubproductosLogicaNegocio;
 use Agrodb\EmisionCertificacionOrigen\Modelos\SubproductosModelo;
 use Agrodb\EmisionCertificacionOrigen\Modelos\LocalizacionLogicaNegocio;
 use Agrodb\EmisionCertificacionOrigen\Modelos\LocalizacionModelo;
 use Agrodb\EmisionCertificacionOrigen\Modelos\EmpresaLogicaNegocio;
 use Agrodb\Usuarios\Modelos\UsuariosPerfilesLogicaNegocio;
 
class RegistroProduccionControlador extends BaseControlador 
{

		 private $lNegocioRegistroProduccion = null;
		 private $modeloRegistroProduccion = null;
		 
		 private $lNegocioProductos = null;
		 private $modeloProductos = null;
		 
		 private $lNegocioProductosTemp = null;
		 private $modeloProductosTemp = null;
		 
		 private $lNegocioSubproductosTemp = null;
		 private $modeloSubproductosTemp = null;
		 
		 private $lNegocioSubproductos = null;
		 private $modeloSubproductos = null;
		 
		 private $productosAgregados = null;
		 private $subProductosAgregados = null;
		 
		 private $lNegocioLocalizacion = null;
		 private $modeloLocalizacion = null;
		 
		 
		 private $accion = null;
		 private $especie=null;
		 private $tipo=null;
		 private $visualizar=null;
		 private $idRegistro=null;

		 private $lNegocioUsuariosPerfiles = null;

		 private $lNegocioEmpresa = null;
		 
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioRegistroProduccion = new RegistroProduccionLogicaNegocio();
		 $this->modeloRegistroProduccion = new RegistroProduccionModelo();
		 
		 $this->lNegocioProductos = new ProductosLogicaNegocio();
		 $this->modeloProductos = new ProductosModelo();
		 
		 $this->lNegocioProductosTemp = new ProductosTempLogicaNegocio();
		 $this->modeloProductosTemp = new ProductosTempModelo();
		 
		 $this->lNegocioSubProductosTemp = new SubproductosTempLogicaNegocio();
		 $this->modeloSubProductosTemp = new SubproductosTempModelo();
		 
		 $this->lNegocioSubproductos = new SubproductosLogicaNegocio();
		 $this->modeloSubproductos = new SubproductosModelo();
		 
		 $this->lNegocioLocalizacion = new LocalizacionLogicaNegocio();
		 $this->modeloLocalizacion = new LocalizacionModelo();

		 $this->contenidoCentroFaenamiento = '';

		 $this->lNegocioUsuariosPerfiles = new UsuariosPerfilesLogicaNegocio();

		 $this->lNegocioEmpresa = new EmpresaLogicaNegocio();
		 		 
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{

			$cedulaUsuario = $this->buscarEmpresaEmpleadoPorIdentificadorEmpleado($_SESSION['usuario']);

			$_SESSION['cedulaUsuario'] = $cedulaUsuario;
	
			$admin = false;
			$registroProduccion = false;
			$this->filtroOperaciones();
			$arrayParametros = array('identificador_operador'=> $cedulaUsuario);
		
			$perfilUsuarioAdmin = $this->perfilUsuario($_SESSION['usuario'],'PFL_EMI_CERT_EME');
			if(isset($perfilUsuarioAdmin) && ($perfilUsuarioAdmin->count()==1)){
				$admin = true;
				$registroProduccion = true;
				$arrayParametros[] = ($arrayParametros+=[
					'tipoUsuario' => $admin,
					'registroProduccion' => $registroProduccion
				]);
				$modeloRegistroProduccion = $this->lNegocioRegistroProduccion->listarRegistroProduccion($arrayParametros,'order by 1 desc');
				$this->tablaHtmlRegistroProduccion($modeloRegistroProduccion);
			    require APP . 'EmisionCertificacionOrigen/vistas/listaRegistroProduccionEmergenteVista.php';
			}else{
				
				
				$arrayParametros[] = ($arrayParametros+=[
					'tipoUsuario' => $admin,
				]);
				$modeloRegistroProduccion = $this->lNegocioRegistroProduccion->listarRegistroProduccion($arrayParametros,'order by 1 desc');
			$this->tablaHtmlRegistroProduccion($modeloRegistroProduccion);
			   require APP . 'EmisionCertificacionOrigen/vistas/listaRegistroProduccionVista.php';
			}

		}	/**
		* Método para desplegar el formulario vacio
		*/

		//funcion que detemrina si un usuario es empleado o empresa
		public function buscarEmpresaEmpleadoPorIdentificadorEmpleado($identificadorEmpleado){
			$identificador = '';
				$identificadorEmpresa = $this->lNegocioEmpresa->buscarEmpresaPorEmpleado($identificadorEmpleado);	
				if($identificadorEmpresa->count() > 0){
					$identificador = $identificadorEmpresa->current()->identificador_empresa;
				}else{
					$identificador = $this->usuarioActivo();
				}

				return $identificador;
		}

		public function perfilUsuario($cedula,$perfil){
			return $this->lNegocioUsuariosPerfiles->buscarUsuariosXAplicacionPerfil($cedula,$perfil);
		}

		public function nuevo()
		{
		
			$cedulaUsuario = $this->buscarEmpresaEmpleadoPorIdentificadorEmpleado($_SESSION['usuario']);

			$perfilUsuarioAdmin = $this->perfilUsuario($_SESSION['usuario'],'PFL_EMI_CERT_EME');
			$banderaPerfil =false;
			if($perfilUsuarioAdmin->count() >0){
				$banderaPerfil =true;
			}
			$this->lNegocioProductosTemp->borrarTablasTemporales($cedulaUsuario, $banderaPerfil);
					
			
			if(isset($perfilUsuarioAdmin) && ($perfilUsuarioAdmin->count()==1)){
				$this->accion = "Nueva Producción Emergente"; 
				require APP . 'EmisionCertificacionOrigen/vistas/formularioRegistroProduccionEmergenteVista.php';
			}else{

				$this->accion = "Nueva Producción"; 
				require APP . 'EmisionCertificacionOrigen/vistas/formularioRegistroProduccionVista.php';
			}

		}	/**
		* Método para registrar en la base de datos -RegistroProduccion
		*/
		public function guardar()
		{
			
			$this->lNegocioRegistroProduccion->guardar($_POST);
		}
		/**
		 * Método para registrar en la base de datos -RegistroProduccion
		 */
		public function guardarProduccion()
		{
			//guarda todos los datos de toda la vista agregar produccion
			$perfilUsuarioAdmin = $this->perfilUsuario($_SESSION['usuario'],'PFL_EMI_CERT_EME');
			if($perfilUsuarioAdmin->count() > 0){
				$_POST['identificador_tecnico'] = $_SESSION['usuario'];
			}else{
				$_POST['identificador_tecnico'] ='';
			}
		    $this->lNegocioRegistroProduccion->guardarProduccion($_POST);	
		}
		/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: RegistroProduccion
		*/
		public function editar()
		{
			$cedulaUsuario = $this->buscarEmpresaEmpleadoPorIdentificadorEmpleado($_SESSION['usuario']);
			$titulo ="";
			$admin = false;
			$perfil = false;
			$perfilUsuarioAdmin = $this->perfilUsuario($_SESSION['usuario'],'PFL_EMI_CERT_EME');
			if(isset($perfilUsuarioAdmin) && ($perfilUsuarioAdmin->count()==1)){
				$cedulaUsuario = $perfilUsuarioAdmin->current()->identificador;
				$admin = true;
				$perfil = true;
				$titulo = "Registro Producción Emergente";
				
			}else{
				$titulo = "Registro Producción";
			}
				
				$id = explode('-', $_POST['id']);
				$this->contenidoCentroFaenamiento($id[0],$admin);
				$this->modeloRegistroProduccion = $this->lNegocioRegistroProduccion->buscar($id[0]);
			
				$this->visualizar = 'si';
				$arrayParametros= array(
					'identificador_operador' => $cedulaUsuario,
					'id_productos' => $id[1],
					'tipoUsuario' => $admin,
					'perfil' => $perfil);

				$this->productosAgregados = $this->listarProductos($arrayParametros);
				$arrayParametros = array('id_productos' => $id[1]);
				$this->subProductosAgregados = $this->listarSubProductos($arrayParametros);
			
				$this->modeloProductos = $this->lNegocioProductos->buscar($id[1]);
			$this->accion = $titulo; 
				if($this->modeloRegistroProduccion->getTipo() =='Mayores'){
					//   require APP . 'EmisionCertificacionOrigen/vistas/formularioRegistroProduccionMayoresVista.php';
				}else{
					require APP . 'EmisionCertificacionOrigen/vistas/formularioRegistroProduccionMenoresVista.php';
				}
	
		}	/**
		* Método para borrar un registro en la base de datos - RegistroProduccion
		*/
		public function eliminar()
		{

			$cedulaUsuario = $this->buscarEmpresaEmpleadoPorIdentificadorEmpleado($_SESSION['usuario']);
		    if($_POST['elementos'] !=''){
				$id = explode('-', $_POST['elementos']);
				$this->modeloRegistroProduccion = $this->lNegocioRegistroProduccion->buscar($id[0]);
				$this->visualizar = 'eliminar';
				$perfilUsuarioAdmin = $this->perfilUsuario($_SESSION['usuario'],'PFL_EMI_CERT_EME');
				$banderaPerfil = false;
				if(isset($perfilUsuarioAdmin) && ($perfilUsuarioAdmin->count()==1)){
					$cedulaUsuario = $perfilUsuarioAdmin->current()->identificador;
					$banderaPerfil = true;
				}else{
					$cedulaUsuario = $_SESSION['usuario'];
				}
				$arrayParametros= array('identificador_operador' => $cedulaUsuario,'id_productos' => $id[1],'tipoUsuario' => false , 'perfil' => $banderaPerfil);
				
				$this->productosAgregados = $this->listarProductos($arrayParametros);
				$arrayParametros = array('id_productos' => $id[1]);
				$this->subProductosAgregados = $this->listarSubProductos($arrayParametros);
				$this->idRegistro = $id[1];
				if($this->modeloRegistroProduccion->getTipo() =='Mayores'){
					
					require APP . 'EmisionCertificacionOrigen/vistas/formularioRegistroProduccionMayoresVista.php';
				}else{
					
					require APP . 'EmisionCertificacionOrigen/vistas/formularioRegistroProduccionMenoresVista.php';
				}

		    }
		}	/**
		* Construye el código HTML para desplegar la lista de - RegistroProduccion
		*/
		 public function tablaHtmlRegistroProduccion($tabla) {
		{
			$cedulaUsuario = $this->buscarEmpresaEmpleadoPorIdentificadorEmpleado($_SESSION['usuario']);
			$perfilUsuarioAdmin = $this->perfilUsuario($cedulaUsuario,'PFL_EMI_CERT_EME');
			if(isset($perfilUsuarioAdmin) && ($perfilUsuarioAdmin->count()==1)){
				$contador = 0;
				foreach ($tabla as $fila) {
					$this->itemsFiltrados[] = array(
					'<tr id="' . $fila['id_registro_produccion'] . '-'.$fila['id_productos'].'"
					class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'EmisionCertificacionOrigen\registroProduccion"
					data-opcion="editar" ondragstart="drag(event)" draggable="true"
					data-destino="detalleItem">
					<td>' . ++$contador . '</td>
					<td style="white - space:nowrap; "><b>' . $fila['fecha_faenamiento'] . '</b></td>
					<td>' . $fila['nombre_lugar'] . '</td>
					<td>' . $fila['tipo_especie'] . '</td>
					</tr>');
					
			  	}
			}else{
				$contador = 0;
				foreach ($tabla as $fila) {
				 	$this->itemsFiltrados[] = array(
					'<tr id="' . $fila['id_registro_produccion'] . '-'.$fila['id_productos'].'"
					class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'EmisionCertificacionOrigen\registroProduccion"
					data-opcion="editar" ondragstart="drag(event)" draggable="true"
					data-destino="detalleItem">
					<td>' . ++$contador . '</td>
					<td style="white - space:nowrap; "><b>' . $fila['fecha_faenamiento'] . '</b></td>
					<td>' . $fila['nombre_lugar'] . '</td>
					<td>' . $fila['tipo_especie'] . '</td>
					<td align="center">' . $fila['num_animales_recibidos'] . '</td>
					<td align="center">' . $fila['num_canales_obtenidos'] . '</td>
					<td>' . $fila['subproducto'] . '</td>
					</tr>');
			  	}
			}
			
		
		}
	}

	//****************************filtra informacion segun parametros************
	public function filtrarInformacion(){
	
		

		$cedulaUsuario = $this->buscarEmpresaEmpleadoPorIdentificadorEmpleado($_SESSION['usuario']);
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    $modeloRegistroProduccion = array();
	    if(isset($_POST['fechaInicio']) && isset($_POST['fechaFin']) && $_POST['fechaInicio'] != '' && $_POST['fechaFin'] != '' ){
			$perfilUsuarioAdmin = $this->perfilUsuario($_SESSION['usuario'],'PFL_EMI_CERT_EME');
			if(isset($perfilUsuarioAdmin) && ($perfilUsuarioAdmin->count()== 0)){
				$tipoUsuario= false;
			}
	    $arrayParametros = array('identificador_operador'=> $cedulaUsuario,
								 'fechaInicio' => $_POST['fechaInicio'],
								 'fechaFin' => $_POST['fechaFin'], 
								 'tipoUsuario' => $tipoUsuario);
	    $modeloRegistroProduccion = $this->lNegocioRegistroProduccion->listarRegistroProduccion($arrayParametros);
	    if($modeloRegistroProduccion->count()==0){
	        $estado = 'FALLO';
	        $mensaje = 'No existen registros para la busqueda..!!';
	    }
	    }else{
	        $estado = 'FALLO';
	        $mensaje = 'Debe ingresar la fecha inicio y fecha fin..!!';
	    }
	    $this->tablaHtmlRegistroProduccion($modeloRegistroProduccion);
	    $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido));
	}
	/**
	 *
	 */
	public function listarCanalObtenido(){
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    $contenido= $this->comboNumeros($_POST['numCanalesObtenidos']);
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido));
	    
	}
	/**
	 * 
	 */
	public function listarCanalSinRestrUso(){
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    $contenido= $this->comboNumeros($_POST['numCanalesObtenidos']);
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido));
	    
	}
	/**
	 *
	 */
	public function listarCanalIndustr(){
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    $contenido= $_POST['numCanalesObtenidos']-$_POST['numCanalesObtenidosUso'];
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido));
	}
	/**
	 * 
	 */
public function agregarProduccion(){

		$campo = isset($_POST['emergente']) ? $_POST['emergente']: '';

		if($campo != 'emergenteProduccion'){
			$cedulaUsuario = $this->buscarEmpresaEmpleadoPorIdentificadorEmpleado($_SESSION['usuario']);
			$perfilUsuarioAdmin = $this->perfilUsuario($_SESSION['usuario'],'PFL_EMI_CERT_EME');
			if($perfilUsuarioAdmin->count() > 0){
				$cedulaUsuario = $_POST['ruc'];
			}
			$estado = 'EXITO';
			$mensaje = '';
			$contenido = '';
			$subContenido = '';
			$banValidarIngreso = true;
			
			$especie = trim($_POST['tipo_especie']);

			$arrayEspecie = array (
				"Avícola",
				"Porcinos",
				"Cunícola",
				"Cavia"
			);
																									 
			if(!in_array($especie, $arrayEspecie)){
				
				$arrayParametros = array(
					'fecha_faenamiento' => $_POST['fecha_faenamiento'],
					'identificador_operador' => $cedulaUsuario,
					'tipo_especie' => $_POST['tipo_especie'],
					'id_sitio' => $_POST['id_sitio'],
					'id_area' => $_POST['id_area']
				);
				$validarProduccion = $this->lNegocioProductosTemp->buscarProduccionPorSitioArea($arrayParametros);

				if($validarProduccion->count()){
					$banValidarIngreso=false;
				}
				if($banValidarIngreso){
				
					$validarProduccion = $this->lNegocioRegistroProduccion->validarRegistroProduccionDiaria($arrayParametros);
				}
				if($validarProduccion->count()){
					$banValidarIngreso=false;
				}
				if($perfilUsuarioAdmin->count() > 0){
					$banValidarIngreso=true;
				}
			}
			if($banValidarIngreso){
				$resultado =  $this->lNegocioProductosTemp->buscarLista("fecha_creacion::date = '".date('Y-m-d')."' and identificador_operador='".$cedulaUsuario."' order by 1 DESC LIMIT 1");
				$arrayParametros = array('identificador_operador' => $cedulaUsuario, 'fecha_creacion' => date('Y-m-d'));
					
					$perfilUsuarioAdmin = $this->perfilUsuario($_SESSION['usuario'],'PFL_EMI_CERT_EME');
					if(isset($perfilUsuarioAdmin) && ($perfilUsuarioAdmin->count()==1)){
						$arrayParametros[] = ($arrayParametros+=[
							'tipoUsuario' => true
						]);
					}else{
						$arrayParametros[] = ($arrayParametros+=[
							'tipoUsuario' => false
						]);
					}

				$resultProductos =  $this->lNegocioRegistroProduccion->listarRegistroProduccion($arrayParametros,'order by 1,8 desc limit 1');
			
				$codigoCanal=str_pad(1, 3, "0", STR_PAD_LEFT);
				if($resultProductos->count()){
					if($resultado->count()){
						$num= $resultado->current()->codigo_canal + $resultProductos->current()->codigo_canal +1;
						$codigoCanal = str_pad($num, 3, "0", STR_PAD_LEFT);
					}else{
						$num= $resultProductos->current()->codigo_canal +1;
						$codigoCanal = str_pad($num, 3, "0", STR_PAD_LEFT);
					}
				}else if($resultado->count()){
					$num= $resultado->current()->codigo_canal +1;
					$codigoCanal = str_pad($num, 3, "0", STR_PAD_LEFT);
				}
				$_POST['codigo_canal']=$codigoCanal;
				if(isset($_POST['ruc']) && $_POST['ruc'] != ''){
					$_POST['identificador_operador'] = $_POST['ruc'];

				}else{
					$_POST['identificador_operador']=$cedulaUsuario;
				}
				$result = $this->lNegocioProductosTemp->guardar($_POST);
				if($result > 0){
					if(isset($_POST['menores'])){
						$identificadorCentroFaenamiento = isset($_POST['ruc']) != '' ? $_POST['ruc'] : null;
						$contenido = $this->listarProductosTmpMenores($identificadorCentroFaenamiento);
					}else{
							$identificadorCentroFaenamiento = isset($_POST['ruc']) != '' ? $_POST['ruc'] : null;
						$contenido = $this->listarProductosTmp($identificadorCentroFaenamiento);
					}
					$identificadorCentroFaenamiento = isset($_POST['ruc']) != '' ? $_POST['ruc'] : null;
					
						$subContenido = $this->listarEspecie($identificadorCentroFaenamiento);
					}else{
						$estado = 'error';
						$mensaje = "Error al guardar los datos";
					}
			
			}else{
				$estado = 'error';
				$mensaje = "Producción con la misma especie ya registrada...!!";
				
			}
			
		}else{
			
				$result = $this->produccionEmergenteTecnicoCentroFaenamiento($_POST);
				$estado = $result[0];
				$mensaje = $result[1];
				$contenido = $result[2];
				$subContenido = $result[3];
			
			

		}
		
		echo json_encode(array(
			'estado' => $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido,
			'subContenido' => $subContenido
		));
																													
	}
										 
	public function produccionEmergenteTecnicoCentroFaenamiento($datos){
		$estado = 'EXITO';
		$mensaje = '';
		$contenido = '';
		$Mensaje = array();

		$especie = trim($_POST['tipo_especie']);
			$arrayEspecie = array (
				"Avícola",
				"Porcinos",
				"Cunícola",
				"Cavia"
			);
		if(!in_array($especie, $arrayEspecie)){
			$centroFaenamiento = $this->lNegocioRegistroProduccion->buscarProduccionSitioPorCentroFaenamiento($datos);
			if (count($centroFaenamiento) > 0){

				$resultado =  $this->lNegocioProductosTemp->buscarLista("fecha_creacion::date = '".date('Y-m-d')."' and identificador_operador='".$datos['ruc']."' order by 1 DESC LIMIT 1");
					$arrayParametros = array('identificador_operador' => $datos['ruc'], 'fecha_creacion' => date('Y-m-d'));
						
						$perfilUsuarioAdmin = $this->perfilUsuario($_SESSION['usuario'],'PFL_EMI_CERT_EME');
						if(isset($perfilUsuarioAdmin) && ($perfilUsuarioAdmin->count()==1)){
							$arrayParametros[] = ($arrayParametros+=[
								'tipoUsuario' => true
							]);
						}else{
							$arrayParametros[] = ($arrayParametros+=[
								'tipoUsuario' => false
							]);
						}

					$resultProductos =  $this->lNegocioRegistroProduccion->listarRegistroProduccion($arrayParametros,'order by 1,8 desc limit 1');
				
					$codigoCanal=str_pad(1, 3, "0", STR_PAD_LEFT);
					if($resultProductos->count()){
						if($resultado->count()){
							$num= $resultado->current()->codigo_canal + $resultProductos->current()->codigo_canal +1;
							$codigoCanal = str_pad($num, 3, "0", STR_PAD_LEFT);
						}else{
							$num= $resultProductos->current()->codigo_canal +1;
							$codigoCanal = str_pad($num, 3, "0", STR_PAD_LEFT);
						}
					}else if($resultado->count()){
						$num= $resultado->current()->codigo_canal +1;
						$codigoCanal = str_pad($num, 3, "0", STR_PAD_LEFT);
					}
					$datos['codigo_canal']=$codigoCanal;
					if(isset($datos['ruc']) && $datos['ruc'] != ''){
						$datos['identificador_operador'] = $datos['ruc'];

					}else{
						$datos['identificador_operador']=$cedulaUsuario;
					}
					$result = $this->lNegocioProductosTemp->guardar($datos);
					if($result > 0){
						if(isset($datos['menores'])){
							$identificadorCentroFaenamiento = isset($datos['ruc']) != '' ? $datos['ruc'] : null;
							$contenido = $this->listarProductosTmpMenores($identificadorCentroFaenamiento);
						}else{
								$identificadorCentroFaenamiento = isset($datos['ruc']) != '' ? $datos['ruc'] : null;
							$contenido = $this->listarProductosTmp($identificadorCentroFaenamiento);
						}
						$identificadorCentroFaenamiento = isset($datos['ruc']) != '' ? $datos['ruc'] : null;
						
							$subContenido = $this->listarEspecie($identificadorCentroFaenamiento);
						}else{
							$estado = 'error';
							$mensaje = "Error al guardar los datos";
							array_push($Mensaje,$estado);
							array_push($Mensaje,$mensaje);
						}
						$estado = 'EXITO';
						$mensaje = "";
						array_push($Mensaje,$estado);
						array_push($Mensaje,$mensaje);
						array_push($Mensaje,$contenido);	
						array_push($Mensaje,$subContenido);	
			
			}else{

				$estado = 'error';
				$mensaje = "El operador no tiene registrada una producción de esta especie en esta fecha..!";
				$contenido = "";
				$subContenido = "";
				
				array_push($Mensaje,$estado);
				array_push($Mensaje,$mensaje);
				array_push($Mensaje,$contenido);
				array_push($Mensaje,$subContenido);
			}
		}else{
			$estado = 'error';
			$mensaje = "No puede registrar producción para este tipo de especies..!";
			$contenido = "";
			$subContenido = "";
				
			array_push($Mensaje,$estado);
			array_push($Mensaje,$mensaje);
			array_push($Mensaje,$contenido);
			array_push($Mensaje,$subContenido);
		}

		return $Mensaje;	
	}
	
	
	/**
	 *
	 */
	public function eliminarProduccion(){
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
		$identificadorCentroFaenamiento = isset($_POST['ruc']) != '' ? $_POST['ruc'] : null;
	    $verificar=$this->lNegocioSubProductosTemp->buscarLista('id_productos_temp = '.$_POST['id']);
	    if($verificar->count() > 0){
	        $estado = 'error';
	        $mensaje = "Existen subproductos agregados al producto a eliminar..!!";
	    }else{
	        $this->lNegocioProductosTemp->borrar($_POST['id']);
	    }
	    $contenido = $this->listarProductosTmp($identificadorCentroFaenamiento);
	    $subContenido = $this->listarEspecie($identificadorCentroFaenamiento);
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido,
	        'subContenido' => $subContenido
	    ));
	}
	/**
	 * 
	 * @return string
	 */
	public function listarProductosTmp($cedulaCentroFaenamiento){
		$cedulaUsuario = $this->buscarEmpresaEmpleadoPorIdentificadorEmpleado($_SESSION['usuario']);
		if($cedulaCentroFaenamiento != null){
			$cedulaUsuario = $cedulaCentroFaenamiento;
		}		
	    $html=$datos='';
	    $resultado =  $this->lNegocioProductosTemp->buscarLista("identificador_operador='".$cedulaUsuario."' order by 1");
	    if($resultado->count()){
	        $contador=0;
	        foreach ($resultado as $item) {
	            
	            $datos .= '<tr>';
	            $datos .= '<td>'.++$contador.'</td>';
	            $datos .= '<td>'.$item->fecha_faenamiento.'</td>';
	            $datos .= '<td>'.$item->tipo_especie.'</td>';
	            $datos .= '<td align="center">'.$item->num_canales_obtenidos_uso.'</td>';
	            $datos .= '<td align="center">'.$item->num_canales_uso_industri.'</td>';
	            $datos .= '<td><button class="bEliminar icono" onclick="eliminarProducto('.$item->id_productos_temp.'); return false; "></button></td>';
	            $datos .= '</tr>';
	        }
	        $html = '
        				<table style="width:100%">
        					<thead><tr>
        						<th>#</th>
        						<th>Fecha faenamiento</th>
        						<th>Especie</th>
                                <th>N° canales obtenidas sin restricción de uso</th>
                                <th>N° canales obtenidas para uso industrial</th>
                                <th></th>
        						</tr></thead>
        					<tbody>'.$datos.'</tbody>
        				</table>';
	    }
	    return $html;
	}

	/**
	 *
	 * @return string
	 */
	public function listarProductosTmpMenores($cedulaCentroFaenamiento){
		$cedulaUsuario = $this->buscarEmpresaEmpleadoPorIdentificadorEmpleado($_SESSION['usuario']);
		if($cedulaCentroFaenamiento != null){
			$cedulaUsuario = $cedulaCentroFaenamiento;
		}
		
		// echo("cedulamodificada_:".$cedulaUsuario);
	    $html=$datos='';
	    $resultado =  $this->lNegocioProductosTemp->buscarLista("identificador_operador='".$cedulaUsuario."' order by 1");
	  
		if($resultado->count()){
	        $contador=0;
	        foreach ($resultado as $item) {
	            $datos .= '<tr>';
	            $datos .= '<td>'.++$contador.'</td>';
	            $datos .= '<td>'.$item->fecha_faenamiento.'</td>';
	            $datos .= '<td>'.$item->tipo_especie.'</td>';
	            $datos .= '<td align="center">'.$item->num_canales_obtenidos_uso.'</td>';
	            $datos .= '<td align="center">'.$item->num_canales_uso_industri.'</td>';
	            $datos .= '<td><button class="bEliminar icono" onclick="eliminarProducto('.$item->id_productos_temp.'); return false; "></button></td>';
	            $datos .= '</tr>'; 
	        }
	        $html = '
        				<table style="width:100%">
        					<thead><tr>
        						<th>#</th>
        						<th>Fecha faenamiento</th>
        						<th>Especie</th>
                                <th>N° canales obtenidas sin restricción de uso</th>
                                <th>N° canales obtenidas para uso industrial</th>
                                <th></th>
        						</tr></thead>
        					<tbody>'.$datos.'</tbody>
        				</table>';
	    }
	    return $html;
	}
	
	/**
	 *
	 * @return string
	 */
	public function listarProductos($arrayParametros){
		
	    $html=$datos='';
	    $consulta= $this->lNegocioRegistroProduccion->listarRegistroProduccion($arrayParametros);
	    if($consulta->count()){
	        $contador=0;
	        foreach ($consulta as $item) {
	            $datos .= '<tr>';
	            $datos .= '<td>'.++$contador.'</td>';
	            $datos .= '<td>'.$item->fecha_faenamiento.'</td>';
	            $datos .= '<td>'.$item->tipo_especie.'</td>';
	            $datos .= '<td align="center">'.$item->num_canales_obtenidos_uso.'</td>';
	            $datos .= '<td align="center">'.$item->num_canales_uso_industri.'</td>';
	            $datos .= '</tr>';
	        }
	        $html = '
        				<table style="width:100%">
        					<thead><tr>
        						<th>#</th>
        						<th>Fecha faenamiento</th>
        						<th>Especie</th>
                                <th>N° canales obtenidas sin restricción de uso</th>
                                <th>N° canales obtenidas para uso industrial</th>
                                <th></th>
        						</tr></thead>
        					<tbody>'.$datos.'</tbody>
        				</table>';
	    }
	    return $html;
	}
	
	public function listarEspecie($cedulaCentroFaenamiento){
		$cedulaUsuario = $this->buscarEmpresaEmpleadoPorIdentificadorEmpleado($_SESSION['usuario']);
		if($cedulaCentroFaenamiento != null){
			$cedulaUsuario = $cedulaCentroFaenamiento;
		}

		$perfilUsuarioAdmin = $this->perfilUsuario($_SESSION['usuario'],'PFL_EMI_CERT_EME');
		$banderaPerfil = false;
		   if ($perfilUsuarioAdmin->count() > 0){
			$banderaPerfil = true;
		   }	
	    $arrayParametros = array('identificador_operador' => $cedulaUsuario, 'perfil' => $banderaPerfil);
	    $resultado =  $this->lNegocioProductosTemp->obtenerEspecie($arrayParametros);
	    $combo = '<option value="">Seleccionar...</option>';
	    if($resultado->count()){
	        foreach ($resultado as $item) {
	            $combo .= '<option value="' . $item['tipo_especie'] . '-'.$item['num_canales_obtenidos'].'-'.$item['id_productos_temp'].'" >' .$item['contador'].' - '. $item['tipo_especie']. '</option>';
	        }
	    }
	    return $combo;
	}
	public function agregarSubproducto(){
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    $nombreSubtipo = explode('-', $_POST['tipoEspecieSub']);
	    $arrayParametros = array('id_area' => 'AI', 'nombreTipoProducto'=>'Productos y subproductos cárnicos en estado primario', 'nombreSubtipo' =>trim($nombreSubtipo[0]));
	    $consulta = $this->lNegocioRegistroProduccion->obtenerSubproducto($arrayParametros);
	    $combo = '<option value="">Seleccionar...</option>';
	    if($consulta->count()){
	        foreach ($consulta as $item) {
	            $combo .= '<option value="' . $item['numero_piezas'] . '" >' . $item['nombre_comun']. '</option>';
	        }
	    }else{
	        $estado = 'error';
	        $mensaje = 'Actualizar el campo número de piezas, en el módulo de Administración de productos';
	    }
	    $contenido = $combo;
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido));
	}
	
	public function numPiezaSubproducto(){
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    $utilizado = 0;
	    $num_canales = explode('-', $_POST['tipoEspecie']);
	    $numMax = $num_canales[1]*$_POST['numPiezas'];
	    
	    $result = $this->lNegocioSubProductosTemp->buscarLista("id_productos_temp=".$num_canales[2]." and subproducto='".$_POST['subproducto']."' and fecha_creacion::date='".date('Y-m-d')."'");
	    if($result->count()){
	        $utilizado = $result->current()->cantidad;
	    }
	    
	    $cantidadLibre   = $numMax - $utilizado;
	    
	    $contenido =   $contenido= $this->comboNumeros($cantidadLibre);
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido));
	}
	
	public function agregarSubProduccion(){
		$campo = isset($_POST['emergente']) ? $_POST['emergente']: '';

			$estado = 'EXITO';
			$mensaje = '';
			$contenido = '';
			$datos = explode('-', $_POST['tipo_especie_sub']);
			$total=0;
			$arrayParametros = array('id_area' => 'AI', 'nombreTipoProducto'=>'Productos y subproductos cárnicos en estado primario', 'nombreSubtipo' =>$datos[0],'nombre_comun' => $_POST['subproducto'] );
			$consulta = $this->lNegocioRegistroProduccion->obtenerSubproducto($arrayParametros);
			if($consulta->count()>0){
				foreach ($consulta as $value) {
					$total = $value['numero_piezas'] * $datos[1];
				}
			}
			$_POST['id_productos_temp'] =  $datos[2];
			$arrayParametros = array('id_productos_temp' => $datos[2],'subproducto' => $_POST['subproducto']);
			$cantidad = $this->lNegocioSubProductosTemp->sumarCantidadSubProductos($arrayParametros);
			if($cantidad->count()>0){
				if(($cantidad->current()->total+$_POST['cantidad'] )<= $total){
					$_POST['id_subproductos_temp'] = $cantidad->current()->id_subproductos_temp;
					$_POST['cantidad']=$cantidad->current()->total+$_POST['cantidad'];
					$result = $this->lNegocioSubProductosTemp->guardar($_POST);
					if($result > 0){
						$identificadorCentroFaenamiento = isset($_POST['ruc']) != '' ? $_POST['ruc'] : null;
						$contenido = $this->listarSubProductosTmp($identificadorCentroFaenamiento);
					}else{
						$estado = 'error';
						$mensaje = "Error al guardar los datos";
					}
				}else{
					$estado = 'error';
					$mensaje = "Excede la cantidad de producción diaria";
				}
				
			}else{
				$result = $this->lNegocioSubProductosTemp->guardar($_POST);
				if($result > 0){
					
					$identificadorCentroFaenamiento = isset($_POST['ruc']) != '' ? $_POST['ruc'] : null;
					$contenido = $this->listarSubProductosTmp($identificadorCentroFaenamiento);
				}else{
					$estado = 'error';
					$mensaje = "Error al guardar los datos";																		
				}
							   
													 
			}
		
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	/**
	 *
	 */
	public function eliminarSubproduccion(){
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    $this->lNegocioSubProductosTemp->borrar($_POST['id']);
		$identificadorCentroFaenamiento = isset($_POST['ruc']) != '' ? $_POST['ruc'] : null;
	    $contenido = $this->listarSubProductosTmp($identificadorCentroFaenamiento);
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 *
	 * @return string
	 */
	public function listarSubProductosTmp($identificadorCentroFaenamiento){
		$cedulaUsuario = $this->buscarEmpresaEmpleadoPorIdentificadorEmpleado($_SESSION['usuario']);
		if($identificadorCentroFaenamiento != null){
			$cedulaUsuario = $identificadorCentroFaenamiento;
		}
	    $html=$datos='';
	    $arrayParametros = array('identificador_operador' => $cedulaUsuario);
	    $resultado =  $this->lNegocioSubProductosTemp->buscarSubproductosXProductos($arrayParametros);
	    if($resultado->count()){
	        $contador=0; 
	        foreach ($resultado as $item) {
	            
	            $datos .= '<tr>';
	            $datos .= '<td>'.++$contador.'</td>';
	            $datos .= '<td>'.$item['fecha_faenamiento'].'</td>';
	            $datos .= '<td>'.$item['tipo_especie'].'</td>';
	            $datos .= '<td>'.$item['subproducto'].'</td>';
	            $datos .= '<td>'.$item['cantidad'].'</td>';
	            $datos .= '<td><button class="bEliminar icono" onclick="eliminarSubproducto('.$item['id_subproductos_temp'].'); return false; "></button></td>';
	            $datos .= '</tr>';
	        }
	        $html = '
        				<table style="width:100%">
        					<thead><tr>
        						<th>#</th>
        						<th>Fecha faenamiento</th>
        						<th>Especie</th>
                                <th>Subproducto</th>
                                <th>Cantidad</th>
                                <th></th>
        						</tr></thead>
        					<tbody>'.$datos.'</tbody>
        				</table>';
	    }
	    return $html;
	}
	
	/**
	 *
	 * @return string
	 */
	public function listarSubProductos($arrayParametros){
	    $html=$datos='';
	    $resultado =  $this->lNegocioRegistroProduccion->buscarSubproductosXProductos($arrayParametros);
	    if($resultado->count()){
	        $contador=0; 
	        foreach ($resultado as $item) {
	            
	            $datos .= '<tr>';
	            $datos .= '<td>'.++$contador.'</td>';
	            $datos .= '<td>'.$item['fecha_faenamiento'].'</td>';
	            $datos .= '<td>'.$item['tipo_especie'].'</td>';
	            $datos .= '<td>'.$item['subproducto'].'</td>';
	            $datos .= '<td>'.$item['cantidad'].'</td>';
	            $datos .= '</tr>';
	        }
	        $html = '
        				<table style="width:100%">
        					<thead><tr>
        						<th>#</th>
        						<th>Fecha faenamiento</th>
        						<th>Especie</th>
                                <th>Subproducto</th>
                                <th>Cantidad</th>
                                <th></th>
        						</tr></thead>
        					<tbody>'.$datos.'</tbody>
        				</table>';
	    }
	    return $html;
	}
	
	/**
	 *
	 */
	public function eliminarRegistro(){
	    $estado = 'EXITO';
	    $mensaje = 'Registro Borrado';
	    $contenido = '';
	    
	    $consultar = $this->lNegocioProductos->buscar($_POST['id']);
	    $verificar= $this->lNegocioProductos->buscarLista('id_registro_produccion ='.$consultar->getIdRegistroProduccion());
	    $this->lNegocioSubproductos->borrarPorParametro('id_productos',$_POST['id']);
	    if($verificar->count()==1){
	        $this->lNegocioProductos->borrar($_POST['id']);
	        $this->lNegocioRegistroProduccion->borrar($consultar->getIdRegistroProduccion());
	    }else{
	        $this->lNegocioProductos->borrar($_POST['id']);
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * filtro buscar sitio
	 */
	public function buscarSitio(){
		$cedulaUsuario = $this->buscarEmpresaEmpleadoPorIdentificadorEmpleado($_SESSION['usuario']);
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    if(isset($_POST['id'])){
	        $dato = explode('-', $_POST['id']);
	        $arrayParametros = array('identificador_operador' => $cedulaUsuario, 'provincia' => $dato[1], 'id_area_tipo_operacion' =>'AI', 'codigo' => 'FAE');
	        $contenido = $this->comboSitioCf($arrayParametros);
	    }else{
	        $estado = 'FALLO';
	        $mensaje ='Debe seleccionar la provincia...!!!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * filtro buscar area
	 */
	public function buscarArea(){
		$cedulaUsuario = $this->buscarEmpresaEmpleadoPorIdentificadorEmpleado($_SESSION['usuario']);
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if(isset($_POST['id'])){
	        $dato = explode('-', $_POST['id']);
	        $arrayParametros = array('identificador_operador' => $cedulaUsuario, 'id_sitio' => $dato[0], 'id_area_tipo_operacion' =>'AI', 'codigo' => 'FAE');
	        $contenido = $this->comboAreaCf($arrayParametros);
	    }else{
	        $estado = 'FALLO';
	        $mensaje ='Debe seleccionar el sitio...!!!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	public function buscarAreaEmergente(){
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if(isset($_POST['id']) && isset($_POST['ruc'])){
	        $dato = explode('-', $_POST['id']);
	        $arrayParametros = array('identificador_operador' => $_POST['ruc'], 'id_sitio' => $dato[0], 'id_area_tipo_operacion' =>'AI', 'codigo' => 'FAE');
	        $contenido = $this->comboAreaCf($arrayParametros);
	    }else{
	        $estado = 'FALLO';
	        $mensaje ='Debe seleccionar el sitio...!!!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * filtro buscar area
	 */
	public function buscarEspecie(){
		$cedulaUsuario = $this->buscarEmpresaEmpleadoPorIdentificadorEmpleado($_SESSION['usuario']);
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    $codigo = '';
	    $criterio = '';
	    $canton = '';
	    $parroquia = '';
	    $idProvincia='';
	    
	    
	    if(isset($_POST['id'])){
	        $dato = explode('-', $_POST['id']);
	        $arrayParametros = array('identificador_operador' => $cedulaUsuario, 'id_centro_faenamiento' => $dato[2]);
	        $contenido = $this->comboEspecieCf($arrayParametros);
	        $codigo=$dato[3];
	        $criterio=$dato[4];
	        if($criterio == 'Activo'){
	            $prov= $this->lNegocioLocalizacion->buscarLista("id_localizacion_padre = 66 and nombre='".$dato[1]."'");
	            $idProvincia = $prov->current()->id_localizacion;
	            $cant = $this->lNegocioLocalizacion->buscarLista("id_localizacion_padre =".$idProvincia." and nombre='".$dato[5]."'");
	            $canton = $this->comboCantonesECO($idProvincia, $cant->current()->id_localizacion);
	            $parroquia = $this->comboParroquiasECO($cant->current()->id_localizacion);
	            //$canton =  $cant->current()->id_localizacion;
	        }
	    }else{
	        $estado = 'FALLO';
	        $mensaje ='Debe seleccionar el área...!!!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido,
	        'codigo' => $codigo,
	        'criterio' => $criterio,
	        'canton' => $canton,
	        'provincia' => $idProvincia,
	        'parroquia' => $parroquia
	    ));
	}

	public function buscarEspecieEmergente(){
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    $codigo = '';
	    $criterio = '';
	    $canton = '';
	    $parroquia = '';
	    $idProvincia='';
	    
	    if(isset($_POST['id'] ) && isset($_POST['ruc'])){
	        $dato = explode('-', $_POST['id']);
	        $arrayParametros = array('identificador_operador' => $_POST['ruc'], 'id_centro_faenamiento' => $dato[2]);
	        $contenido = $this->comboEspecieCf($arrayParametros);
	        $codigo=$dato[3];
	        $criterio=$dato[4];
	        if($criterio == 'Activo'){
	            $prov= $this->lNegocioLocalizacion->buscarLista("id_localizacion_padre = 66 and nombre='".$dato[1]."'");
	            $idProvincia = $prov->current()->id_localizacion;
	            $cant = $this->lNegocioLocalizacion->buscarLista("id_localizacion_padre =".$idProvincia." and nombre='".$dato[5]."'");
	            $canton = $this->comboCantonesECO($idProvincia, $cant->current()->id_localizacion);
	            $parroquia = $this->comboParroquiasECO($cant->current()->id_localizacion);
	            //$canton =  $cant->current()->id_localizacion;
	        }
	    }else{
	        $estado = 'FALLO';
	        $mensaje ='Debe seleccionar el área...!!!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido,
	        'codigo' => $codigo,
	        'criterio' => $criterio,
	        'canton' => $canton,
	        'provincia' => $idProvincia,
	        'parroquia' => $parroquia
	    ));
	}
	//******************************crear combo numeros
	public function comboAnimalesRecibidos(){
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    if(isset($_POST['tipoEspecie'])){
	        if($_POST['tipoEspecie'] == 'AVICOLA'){
	            $contenido = $this->comboNumeros(5000);
	        }else{
	            $contenido = $this->comboNumeros(5000);
	        }
	    }else{
	        $estado = 'FALLO';
	        $mensaje ='Refrescar la página e internar nuevamente...!!!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	public function contenidoCentroFaenamiento($idRegistroProduccion,$admin){
		
		$this->modeloRegistroProduccion = $this->lNegocioRegistroProduccion->obtenerDatosCentroFaenamiento($idRegistroProduccion,$admin);
		$this->contenidoCentroFaenamiento = '
										<fieldset >
										<legend>Datos Centro de Faenamiento</legend>
											<div data-linea="1">
											<label for="provincia">Provincia: </label>
											'.$this->modeloRegistroProduccion->current()->provincia .'
										</div>				

										<div data-linea="1">
											<label for="sitio">Sitio: </label>
											'.$this->modeloRegistroProduccion->current()->nombre_lugar .'
										</div>				

										<div data-linea="2">
											<label for="area">Área: </label>
											'.$this->modeloRegistroProduccion->current()->nombre_area .'
										</div>				

										<div data-linea="2">
											<label for="codigo_area">Código de área: </label>
											'.$this->modeloRegistroProduccion->current()->codigo .'
										</div>
										</fieldset >';
		return $this->contenidoCentroFaenamiento;
	}


	public function labelProvinciaTecnico(){
	
	    $labelProvincia = '';
		
	    $labelProvincia = ' <input type="text" id ="nombre_provincia" name="nombre_provincia"  value="'.$_SESSION['nombreProvincia'].'" style="width: 100%;" readonly "/>';
	    return $labelProvincia;
	}

	public function buscarSitioEmergente(){
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    if(isset($_POST['provincia']) && isset($_POST['ruc'])){
	        $arrayParametros = array('nombre_provincia' => $_POST['provincia'], 'ruc'=> $_POST['ruc'], 'id_area_tipo_operacion' =>'AI', 'codigo' => 'FAE');
		
	        $contenido = $this->sitioCf($arrayParametros);
			
	    }else{
	        $estado = 'FALLO';
	        $mensaje ='Debe seleccionar la provincia...!!!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	
}
