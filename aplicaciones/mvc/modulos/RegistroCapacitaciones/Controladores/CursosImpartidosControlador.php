<?php
 /**
 * Controlador CursosImpartidos
 *
 * Este archivo controla la lógica del negocio del modelo:  CursosImpartidosModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-08-31
 * @uses    CursosImpartidosControlador
 * @package RegistroCapacitaciones
 * @subpackage Controladores
 */
namespace Agrodb\RegistroCapacitaciones\Controladores;
use Agrodb\RegistroCapacitaciones\Modelos\CursosImpartidosLogicaNegocio;
use Agrodb\Estructura\Modelos\FuncionariosLogicaNegocio;
use Agrodb\RegistroCapacitaciones\Modelos\CursosImpartidosModelo;
use Agrodb\RegistroCapacitaciones\Modelos\PublicoMetaLogicaNegocio;
use Agrodb\RegistroCapacitaciones\Modelos\PublicoAsistenteLogicaNegocio;
use Agrodb\RegistroCapacitaciones\Modelos\TemasCursosLogicaNegocio;
use Agrodb\RegistroCapacitaciones\Modelos\PublicoObjetivoLogicaNegocio;
use Agrodb\RegistroCapacitaciones\Modelos\CapacitadoresLogicaNegocio;
use Agrodb\RegistroCapacitaciones\Modelos\TemasEjecutadosLogicaNegocio;
use Agrodb\Usuarios\Modelos\UsuariosPerfilesLogicaNegocio;
use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;
use Agrodb\Core\JasperReport;

 
class CursosImpartidosControlador extends BaseControlador 
{

	private $lNegocioCursosImpartidos = null;
	private $lNegocioFuncionarios = null;
	private $modeloCursosImpartidos = null;
	private $accion = null;
	private $datosCursoImpartido = null;
	private $lNegocioPublicosMeta = null;
	private $lNegocioPublicosAsistente= null;
	private $lNegocioTemasCursos = null;
	private $lNegocioPublicoObjetivo = null;
	private $comboPublicoObjetivo = null;
	private $comboCursosCapacitaciones = null;
	private $comboTemasCursos = null;
	private $comboFuncionarios = null;
	private $lNegocioCapacitadores = null;
	private $lNegocioTemasEjecutados = null;
	private $lNegocioUsuariosPerfiles = null;
	private $banderaEliminar = null;
	
	private $mensajeEliminar = null;

	

	/**
		* Constructor
		*/
		 function __construct()
		{
			parent::__construct();
			$this->lNegocioCursosImpartidos = new CursosImpartidosLogicaNegocio();
			$this->lNegocioFuncionarios = new FuncionariosLogicaNegocio();
			$this->modeloCursosImpartidos = new CursosImpartidosModelo();
			$this->lNegocioPublicosMeta = new PublicoMetaLogicaNegocio();
			$this->lNegocioPublicosAsistente = new PublicoAsistenteLogicaNegocio();
			$this->lNegocioTemasCursos = new TemasCursosLogicaNegocio();
			$this->lNegocioPublicoObjetivo = new PublicoObjetivoLogicaNegocio();
			$this->lNegocioCapacitadores = new CapacitadoresLogicaNegocio();
			$this->lNegocioTemasEjecutados = new TemasEjecutadosLogicaNegocio();
			$this->lNegocioUsuariosPerfiles = new UsuariosPerfilesLogicaNegocio();
			$this->contenidoInformacionCapacitacion = '';
			$this->contenidoLugarCapacitacion = '';
			$this->contenidoPublicoMeta = '';
			$this->contenidoDetallePublico = '';
			$this->contenidoDatosCapacitador = '';
			$this->contenidoDatosGenerales = '';
			$this->datosCursosImpartidos = '';
			$this->cargarContenidoPublicosMeta = '';
			$this->cargarContenidoTemasEjecutados = '';
			$this->cargarContenidoPublicosAsistente = '';
			$this->cargarContenidoDatosCapacitador = '';
			$this->cantidad = 0;
			$this->contenidoTemasEspecificos = '';
			$this->comboCoordinacionPanel ="";
			$this->comboDireccionPanel ="";
			$this->comboProvinciaPanel ="";
			
		   
			set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
			//responsables (Administrador)
			
			$perfilUsuarioAdmin = $this->perfilUsuario($_SESSION['usuario'],'PFL_REP_CAP');
			$banderaPerfil = false;
			if(count($perfilUsuarioAdmin) > 0){
				$banderaPerfil = true;
			}
			$this->cargarPanelAdministracionBusqueda();
			$arrayParametros = array(
				'cedula' => $_SESSION['usuario'],
				'perfil' => $banderaPerfil
				);
		 $modeloCursosImpartidos = $this->lNegocioCursosImpartidos->buscarCapacitacionesFiltradas($arrayParametros);
		 $this->tablaHtmlCursosImpartidos($modeloCursosImpartidos);
		 $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
		require APP . 'RegistroCapacitaciones/vistas/listaCursosImpartidosVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
			$banderaVisualizar=true;
			$bandera = '';
			$idCursoImpartido='';
			$this->comboListapaises();
			$this->comboListaProvincias();
			$this->cargarCoordinaciones();
			$this->construirInformacionCapacitacion($banderaVisualizar,$bandera, $idCursoImpartido );
			$this->construirLugarCapacitacion($banderaVisualizar);
			$this->construirPublicoMeta($banderaVisualizar);
			$this->construirDetallePublico($banderaVisualizar);
			$this->construirDatosCapacitador($banderaVisualizar);
			$this->construirDatosGenerales($banderaVisualizar);
			$this->accion = "Registrar Capacitación"; 
			require APP . 'RegistroCapacitaciones/vistas/formularioCursosImpartidosVistaNuevo.php';
		}	/**
		* Método para registrar en la base de datos -CursosImpartidos
		*/
		public function guardar()
		{
			
			$_POST['identificador'] = $this->identificador;
		  	$this->lNegocioCursosImpartidos->guardar($_POST);
		  	Mensajes::exito(Constantes::GUARDADO_CON_EXITO);
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: CursosImpartidos
		*/
		public function editar()
		{
			$banderaVisualizar=false;
			
			$this->construirInformacionCapacitacion($banderaVisualizar);
			$this->construirLugarCapacitacion($banderaVisualizar);
			$this->construirPublicoMeta($banderaVisualizar);
			$this->construirDetallePublico($banderaVisualizar);
			$this->construirDatosCapacitador($banderaVisualizar);
			$this->construirDatosGenerales($banderaVisualizar);
		 	$this->accion = "Visualización Capacitación";
			
		 	$this->modeloCursosImpartidos = $this->lNegocioCursosImpartidos->buscar($_POST["id"]);
		 	require APP . 'RegistroCapacitaciones/vistas/formularioCursosImpartidosVistaEditar.php';
		}	/**
		* Método para borrar un registro en la base de datos - CursosImpartidos
		*/
		public function borrar()
		{
		  $this->lNegocioCursosImpartidos->borrar($_POST['elementos']);
		} /**	
		
		* Método para borrar un registro en la base de datos - CursosImpartidos
		*/ 
		public function eliminar()
		{
	
			$perfilUsuarioAdmin = $this->perfilUsuario($_SESSION['usuario'],'PFL_REP_CAP');

			$arrayIdCurso = array();   
			$arrayIdCurso = explode(',', $_POST['elementos']);
			
			if(count($perfilUsuarioAdmin) == 0){
				$this->banderaEliminar = 'AccesoDenegado';
	            $this->mensajeEliminar= 'Su perfil no permite eliminar la información de un curso de capacitación';
				
				require APP . 'RegistroCapacitaciones/vistas/formularioCursoImpartidoVistaEditarUsuario.php';
			}else{

				if($_POST['elementos'] !='' && count($arrayIdCurso) == 1){

					$_POST['id'] = $_POST['elementos'];
					$banderaVisualizar=false;
					$this->construirInformacionCapacitacion($banderaVisualizar);
					$this->construirLugarCapacitacion($banderaVisualizar);
					$this->construirPublicoMeta($banderaVisualizar);
					$this->construirDetallePublico($banderaVisualizar);
					$this->construirDatosCapacitador($banderaVisualizar);
					$this->construirDatosGenerales($banderaVisualizar);
					$this->accion = "Visualización Capacitación";
					
					$this->modeloCursosImpartidos = $this->lNegocioCursosImpartidos->buscar($_POST["id"]);
					require APP . 'RegistroCapacitaciones/vistas/formularioCursosImpartidosVistaEditar.php';
				}else{
					$this->banderaEliminar = 'eliminarCurso';
	                $this->mensajeEliminar= 'Por favor debe seleccionar un registro a la vez...!!';
					require APP . 'RegistroCapacitaciones/vistas/formularioCursoImpartidoVistaEditarUsuario.php';
				}
			}
			
		  
		}
		
		
		/**
		* Construye el código HTML para desplegar la lista de - CursosImpartidos
		*/
		 public function tablaHtmlCursosImpartidos($tabla) {
		
		 $contador = 0;
		  	foreach ($tabla as $fila) {
		    $this->itemsFiltrados[] = array(
		  	'<tr id="' . $fila['id_curso_impartido'] . '"
		    class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'RegistroCapacitaciones\CursosImpartidos"
		    data-opcion="editar" ondragstart="drag(event)" draggable="true"
		    data-destino="detalleItem">
		 		<td>' . ++$contador . '</td>
		  	  <td style="white - space:nowrap; "><b>' . date("Y-m-d",strtotime($fila['fecha_ejecucion'])) . '</b></td>
		  	  <td>'. $fila['nombre_curso'] . '</td>
		  	  <td>' . $fila['nombre_direccion']. '</td>
				<td>' . $fila['tipo'] . '</td>
				<td style="text-align:center;">' . $fila['total_asistentes'] . '</td>
				<td>' . $fila['nombre_provincia'] . '</td>
			</tr>');
		}
		if(count($tabla) == 0){
			$this->itemsFiltrados[] = array(
				'<tr 
			  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'RegistroCapacitaciones\CursosImpartidos"
			  data-opcion="editar" ondragstart="drag(event)" draggable="true"
			  data-destino="detalleItem">
				   <td></td>
				  <td style="white - space:nowrap; "><b></b></td>
				  <td></td>
				  <td></td>
				  <td></td>
				  <td style="text-align:center;"></td>
				  <td></td>
			  </tr>');
		}
		
	}

	//panel de busqueda paraa obtener las capacitaciones (opcion Admin de Capacitaciones)
	public function cargarPanelAdministracionBusqueda()
	{
		$this->mostrarCombosBusqueda();
		$this->panelBusqueda = '<table class="filtro">
		<tbody>
		<tr style="width: 100%;" colspan="4">
			<td><label>*Fecha Inicio:</label> </td>
			<td>
				
				<input id="fechaInicioFiltro" type="text" name="fechaInicioFiltro" required="required" readonly="readonly">
			</td>
			<td><label>*Fecha Fin:</label> </td>
			<td>
				
				<input id="fechaFinFiltro" type="text" name="fechaFinFiltro" required="required" readonly="readonly">
			</td>
		</tr>
		<tr>
			'.$this->comboCoordinacionPanel.'
		</tr>
		<tr>
			'.$this->comboDireccionPanel.'
		</tr>
		<tr colspan="4">
			<td ><label>Tema de Capacitación:</label> </td>
			<td colspan=3>
				<input type="text" id="nombreCursoFiltro" name="nombreCursoFiltro" style="width: 100%;" />
			</td>
		</tr>
		
		<tr colspan="5">
			<td ><label>Provincia:</label> </td>
			<td colspan=3>
				<select id="id_provincia" name="id_provincia" style="width: 100%;" >
					<option value="">Seleccione....</option>
						'.$this->comboListaProvincias().'
				</select>
							   </td>

		<tr  style="width: 100%;">
			<td colspan="2" style="text-align:left;background-color:transparent">
				Los campos con * son obligatorios.
			</td>
			<td colspan="6" style="text-align:right;background-color:transparent">
				<button type="button" id="btnBuscar">Buscar</button>
			</td>
		</tr>
		</tbody>
	</table>';
	}

	
	//funcion que muestra el combo de coordinaciony direccion segun el perfil
	public function mostrarCombosBusqueda(){
        $usuarioPerfil = $this->perfilUsuario($_SESSION['usuario'],'PFL_ADM_CAP');
		if($usuarioPerfil->count() == 1){
            $this->comboCoordinacionPanel='<td><label>*Coordinación:</label> </td>
								<td colspan=3>
								<select id="id_coordinacionBusqueda" name="id_coordinacionSelect" style="width: 100%;" required>
								<option value="">Seleccione....</option>'.$this->cargarCoordinacionesPanel($_SESSION['idGestion'],$_SESSION['usuario']).'</select>
								</td>';
             $this->comboDireccionPanel = '<td><label>*Dirección:</label> </td>
			 					<td colspan=3>
								<select id="id_direccionBusqueda" name="id_direccionselect" style="width: 100%;" required>
								<option value="">Seleccione....</option>'.$this->cargarDireccionesPanel($_SESSION['idGestion'],$_SESSION['usuario']).'</select>
								</td>';
			//  $this->comboProvinciaPanel = '<td><label>*Provincia:</label> </td>
			// 				   <td colspan=3>
			// 				   <select id="id_provincia" name="id_provincia" style="width: 100%;" >
			// 				   		<option value="">Seleccione....</option>
			// 				  		 '.$this->comboListaProvincias().'
			// 					</select>
			// 				   </td>';
        }
	}

	//funcion que determina el perfil asignado a un usuario logeado
	public function perfilUsuario($cedula,$perfil){
        return $this->lNegocioUsuariosPerfiles->buscarUsuariosXAplicacionPerfil($cedula,$perfil);
    }

    //control de datos de buscqueda
	public function controldeDatosBusqueda(){
		
		$parametrosBusqueda = array(
			'fecha_inicio' => $_POST['fechaInicio'],
			'fecha_fin' => $_POST['fechaFin'],
			'coordinacion' => ((isset($_POST['coordinacion']) && ($_POST['coordinacion'] != '')) ? $_POST['coordinacion'] : ''),
			'direccion' => ((isset($_POST['direccion']) && $_POST['direccion'] != '' )? $_POST['direccion'] : ''),
			'nombre_curso' => ((isset($_POST['nombreCurso']) && ($_POST['nombreCurso'] != '') )? $_POST['nombreCurso'] : ''),
			'provincia' => ((isset($_POST['provincia']) && ($_POST['provincia'] != '') )? $_POST['provincia'] : '')
		);

		
		$fechaCalculada = date("Y-m-d",strtotime($parametrosBusqueda['fecha_inicio']."+ 3 month"));
		$fechaActual= date('Y-m-d', time()); 

		if($parametrosBusqueda['nombre_curso'] !='' && ($parametrosBusqueda['fecha_fin'] == '' && $parametrosBusqueda['fecha_fin'] == '')){

			$this->listarCursosImpartidosFiltradas($parametrosBusqueda);

		}else if(((($parametrosBusqueda['fecha_fin'] > $parametrosBusqueda['fecha_inicio']) && ($parametrosBusqueda['fecha_fin'] <= $fechaCalculada)) && ($parametrosBusqueda['fecha_fin'] <= $fechaActual))  ){
					$this->listarCursosImpartidosFiltradas($parametrosBusqueda);
				}else if($parametrosBusqueda['fecha_fin'] < $parametrosBusqueda['fecha_inicio']){
						$estado = 'FALLO';
						$mensaje = 'La Fech- Fin no puede ser menor a la fecha inicio.'; 
						echo json_encode(array(
							'estado' => $estado,
							'mensaje' => $mensaje
							
						));
					}else if($parametrosBusqueda['fecha_fin'] < $parametrosBusqueda['fecha_inicio'] || $parametrosBusqueda['fecha_fin'] > $fechaActual || $parametrosBusqueda['fecha_fin'] == $parametrosBusqueda['fecha_inicio'] ) {
								$this->listarCursosImpartidosFiltradas($parametrosBusqueda);
						}
	}

	//funcion para listar todas las capacitaciones obtenidas dado el cirterio de busqueda(fechainicio, fechafin, nombreCapacitacion)
	public function listarCursosImpartidosFiltradas($parametrosBusqueda)
	{

		$usuarioPerfil= $this->lNegocioUsuariosPerfiles->buscarUsuariosXAplicacionPerfil($_SESSION['usuario'],'PFL_ADM_CAP');
        if($usuarioPerfil->count() == 1){
			
			$parametrosBusqueda+= [
				'cedula' => ''
			];
			
		}else{
			$parametrosBusqueda += array(
				'cedula' => $_SESSION['usuario'],
			);
		}
		
	
		$solicitudes = $this->lNegocioCursosImpartidos->buscarCapacitacionesFiltradas($parametrosBusqueda);
		if (($solicitudes->count())>0){
			$this->tablaHtmlCursosImpartidos($solicitudes);
			$contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
			$estado = 'Exito';
			$mensaje = '';
			
		}else{
			$this->tablaHtmlCursosImpartidos($solicitudes);
			$contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
			$estado = 'FALLO';
		     $mensaje = 'No se encontraron registros para la búsqueda establecida..!'; 
		   
		}
		echo json_encode(array(
			'estado' => $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido
			));
	}


//funcion que crea las filas en la tabla agregar publico objetivo
	public function agregarDetallePublico(){

		$estado = 'EXITO';
		$mensaje = '';
		$contenido = '';

		$genero = $_POST['genero'];
		$cantidad = $_POST['cantidad'];

		$arrayParametros = array(
			'genero' => $genero,
			'cantidad' => $cantidad,
		);

		$contenido ='<tr >
						<td style="text-align:center;">'.$arrayParametros['genero'].'</td>
						<input type="hidden"  name="arrayGeneroDetalle[]" value="'.$arrayParametros['genero'].'" />
						<td style="text-align:center;" class="cantidad">'.$arrayParametros['cantidad'].'</td>
						<input type="hidden"  name="arrayCantidadDetalle[]" value="'.$arrayParametros['cantidad'].'" />
						<td class="borrar" style="text-align:center;"><button class="icono" onclick="eliminarDetallePublico(this); return false"></button></td>
					</tr>';
		echo json_encode(array
		(
			'estado'=> $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido
		));


	}

//funcion para obtener todos los funcionarios por coordinacion  provincia 

	public function cargarFuncionarios(){
		$id_coordinacion = $_POST['id_coordinacion'];
		$idProvincia = $_POST['idProvincia'];
		
		$arrayParametros = array(
		'id_coordinacion' => $id_coordinacion,
		'idProvincia' => $idProvincia
		);
		$this->comboFuncionarios='<option value = "">Seleccione....</option>';
		$funcionarios =  $this->lNegocioFuncionarios->buscarFuncionariosXCoordinacionXProvincia($arrayParametros);
		foreach ($funcionarios as $item){
			$this->comboFuncionarios .= '<option value="' . $item->identificador . '">' . $item->nombre . '</option>';
		}
		echo $this->comboFuncionarios;
		exit();
	}

//funcion que crea las filas en la tabla Capacitador
	public function agregarDatosCapacitadores(){

		$estado = 'EXITO';
		$mensaje = '';
		$contenido = '';

		if($_POST['nombreCapacitador'] != ''){
			$nombreCapacitador = $_POST['nombreCapacitador'];
		}else{
			$nombreCapacitador = $_POST['funcionarioCapacitador'];
		}

		if(($_POST['idPais'] == '') || !isset($_POST['idPais'])){
			$_POST['idPais'] = '';
			$_POST['nombrePais'] = '';

		}else{
			$lugarCapacitador = $_POST['nombrePais'];
		}

		if($_POST['idProvincia'] == '' || !isset($_POST['idProvincia'])){
			$_POST['idProvincia'] = '';
			$_POST['nombreProvincia'] = '';
		}else{
			$lugarCapacitador = $_POST['nombreProvincia'];

		}

		$contenido ='<tr id="'.$nombreCapacitador.'">
						<td style="text-align:left;" id="nombreCapacitador">'.$nombreCapacitador.'</td>
						<td style="text-align:center;" id="tipoCapacitador">'.$_POST['tipoCapacitador'].'</td>
						<td style="text-align:center;" id="lugarCapacitacion">'.$lugarCapacitador.'</td>
						<input type="hidden"  name="arrayIdentificador[]"  value="'.$_POST['identificadorCapacitador'].'">
						<input type="hidden"  name="arrayNombreCapacitador[]"  value="'.$nombreCapacitador.'"/>
						<input type="hidden"  name="arrayInstitucionCapacitador[]"  value="'.$_POST['institucion'].'">
						<input type="hidden"  name="arrayIdProvincia[]"  value="'.$_POST['idProvincia'].'">
						<input type="hidden"  name="arrayNombreProvincia[]"  value="'.$_POST['nombreProvincia'].'">
						<input type="hidden"  name="arrayIdPais[]"  value="'.$_POST['idPais'].'"/>
						<input type="hidden"  name="arrayNombrePais[]"  value="'.$_POST['nombrePais'].'"/>
						<input type="hidden"  name="arrayTipoCapacitador[]"  value="'.$_POST['tipoCapacitador'].'"/>
						<td class="borrar" style="text-align:center;"><button class="icono" onclick="eliminarDatosCapacitador(this)"></button></td>
					</tr>';

		echo json_encode(array
		(
			'estado'=> $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido
		));
	}

	//funcion para obtener todos los temas cursos registrados
	public function cargarTemasCursosXCursoSeleccionado(){

		$idCurso = $_POST['idCurso'];
		$temasCursos =  $this->lNegocioTemasCursos->obtenerTemasXCursoCapacitacion($idCurso);
		foreach ($temasCursos as $item){
			$this->comboTemasCursos .= '<option value="' . $item->id_tema_curso . '">' . $item->nombre_tema . '</option>';
		}
		echo $this->comboTemasCursos;
		exit();
	}

	//funcion que obtiene el publico objetico de un curso de cpacitacion
	public function cargarCatalogoPublicoXCursoCapacitacion(){
		
		$idCursoCapacitacion = $_POST['idCursoCapacitacion'];
		$publicoObjetivo =  $this->lNegocioPublicoObjetivo->obtenerPublicoObjetivoXCursoCapacitacion($idCursoCapacitacion);
		foreach ($publicoObjetivo as $item){
			$this->comboPublicoObjetivo .= '<option value="' . $item->id_publico_objetivo . '">' . $item->nombre_publico . '</option>';
		}
		echo $this->comboPublicoObjetivo;
		exit();
		
	}


	
	public function construirInformacionCapacitacion($banderaVisualizar){
		if($banderaVisualizar){
			$this->contenidoInformacionCapacitacion ='<fieldset>
			<legend>Información Capacitación</legend>				
				
				<div data-linea="1">
				<label for="fecha_ejecucion">Fecha: </label>
				<input type="text" id="fecha_ejecucion" name="fecha_ejecucion" value="" readonly="readonly"/>
			</div>	
			<div data-linea="2">
			<label for="id_coordinacion">Coordinación: </label>
				<select id="id_coordinacion" name="id_coordinacion" style="width: 100%;" >
				<option value="">Seleccione....</option>'.
				$this->comboCoordinacion.'</select>
			</div>		
			<div data-linea="3">
			<label for="id_direccion">Dirección: </label>
				<select id="id_direccion" name="id_direccion" style="width: 100%;" disabled="disabled">
					<option value="">Seleccione....</option>
				</select>
				
			</div>	
			<div data-linea="4">
				<label for="tipo">Tipo: </label>
					<select id="idTipo" name="tipo">
						<option value="">Seleccione</option>
						<option value="Presencial" >Presencial</option>
						<option value="Virtual" >Virtual</option>
						<option value="Hibrida" >Híbrida</option>
				</select>
			</div>	
			<div data-linea="5">
				<label for="nombre_curso">Nombre de Capacitación: </label>
				<select id="id_curso" name="id_curso_capacitacion" style="width: 100%;" disabled="disabled">
				<option value="">Seleccione....</option>'.
				$this->comboCursosCapacitaciones.'</select>
				<input type="hidden" id="nombreCurso" name="nombre_capacitacion" value="" />
		</div>	
			<div data-linea="6">
			<label for="tema_curso">Temas Específicos: </label>
				<select id="nombre_tema"  style="width: 100%;" disabled="disabled">
				<option value="">Seleccione....</option>'.
				$this->comboTemasCursos.'</select>
			</div>
			<div data-linea="7">
				<button id="btnAgregarTema" type="buttom" class="mas" onclick="agregarTemasEspecificos(); return false">Agregar</button>
			</div>
			<div style="width: 100%;">
				<table style="width: 100%; " id="tablaTemasEspecificos">
					<thead>
					<tr>
						<th>Nombre</th>
						<th>Eliminar</th>
					</tr>
					</thead>
					<tbody  >
					'. $this->contenidoTemasEspecificos.'
					</tbody>
				</table>
			</div>

		</fieldset >';
	}else{
		$this->datosCursoImpartido = $this->lNegocioCursosImpartidos->obtenerCursoImpartidoXId($_POST["id"]);
		$this->cargarTemasEjecutados();
		$this->contenidoInformacionCapacitacion ='<fieldset>
			<legend>Información Capacitación</legend>				

				<div data-linea="1">
				<label for="fecha_ejecucion">Fecha: </label>
				<input type="text" id="fecha_ejecucion" name="fecha_ejecucion" value="'. date("Y-m-d",strtotime($this->datosCursoImpartido->current()->fecha_ejecucion )).'" disabled/>
			</div>	
			<div data-linea="2">
			<label for="id_Coordinacion">Coordinación: </label>
				<input type="text" id="id_Coordinacion" name="id_Coordinacion" value="'.$this->datosCursoImpartido->current()->nombre_coordinacion .'" disabled/>
			</div>		
			<div data-linea="3">
			<label for="id_direccion">Dirección: </label>
				<input type="text" id="id_direccion" name="id_direccion" value="'.$this->datosCursoImpartido->current()->nombre_direccion .'" disabled/>
			</div>	
			<div data-linea="4">
				<label for="nombre_capacitacion">Nombre Capacitación: </label>
				<input type="text" id="nombre_capacitacion" name="nombre_capacitacion" value="'.$this->datosCursoImpartido->current()->nombre_capacitacion .'" disabled/>
			</div>	
			<div data-linea="5">
				<label for="tipo">Tipo: </label>
				<input type="text" id="tipo" name="tipo" value="'.$this->datosCursoImpartido->current()->tipo .'" disabled/>
			</div>
			<div data-linea="6">
				<label for="tipo">Temas Específicos: </label>
			</div>
			<div style="width: 100%;">
				<table style="width: 100%; " id="tablaPublico">
					<thead>
					<tr>
						<th>Nombre</th>
					</tr>
					</thead>
					<tbody>
					'. $this->cargarContenidoTemasEjecutados.'
					</tbody>
				</table>
			</div>		
		</fieldset >';
		}
	}

	public function construirLugarCapacitacion($banderaVisualizar){
	
		if($banderaVisualizar){
			$this->contenidoLugarCapacitacion = '<fieldset >
			<legend>Lugar Capacitación</legend>
			<div data-linea="1">
			<label for="provincia">Provincia: </label>
			<select id="idProvincia" name="id_provincia" style="width: 100%;">
				<option value="">Seleccione....</option>'.
				$this->comboProvincias.'
				<input type="hidden" id="nombreProvincia" name="nombre_provincia" value="" />
				</select>
			</div>				

			<div data-linea="1">
			<label for="id_canton">Cantón: </label>
				<select id="idCanton" name="id_canton" style="width: 100%;" disabled="disabled">
					<option value="">Seleccione....</option>
				</select>'.
				$this->comboCantones.'
				<input type="hidden" id="nombreCanton" name="nombre_canton" value="" />
			</div>				

			<div data-linea="2">
			<label for="id_parroquia">Parroquia: </label>
				<select id="idParroquia" name="id_parroquia" style="width: 100%;" disabled="disabled">
					<option value="">Seleccione....</option>
				</select>'.
				$this->comboCantones.'
				<input type="hidden" id="nombreParroquia" name="nombre_parroquia" value="" />
			</div>	
			<div data-linea="2" >
			<label id="id-Oficina">Oficina: </label>
				<select id="idOficina" name="id_oficina" style="width: 100%;" disabled="disabled">
					<option value="">Seleccione....</option>
				</select>
				<input type="hidden" id="nombreOficina" name="nombre_oficina" value="" />
			</div>
			<div data-linea="3">
				<label for="sitio">Sitio Específico: </label>
				<input type="text" id="idSitio" name="sitio" rows="1" cols="50" onKeyUp="contadorPalabrasInputSitio(this)" maxlength="60" placeholder=" Escribe aqui el lugar de capacitación..."></input>
				<div id="textarea_feedbackSitio"></div>
			</div>	
			</fieldset >';
		}else{
			$this->datosCursoImpartido = $this->lNegocioCursosImpartidos->obtenerCursoImpartidoXId($_POST["id"]);
			$oficina='';
			if(($this->datosCursoImpartido->current()->nombre_oficina)!=''){
				$oficina='<div data-linea="2">
						<label for="id_parroquia">Oficina: </label>
						<input type="text" id="id_Oficina" name="id_Oficina" value="'.$this->datosCursoImpartido->current()->nombre_oficina .'" disabled/>	
						</div>';
			}
			$this->contenidoLugarCapacitacion = '<fieldset >
				<legend>Lugar Capacitación</legend>
				<div data-linea="1">
				<label for="provincia">Provincia: </label>
				<input type="text" id="id_Provincia" name="id_Provincia" value="'.$this->datosCursoImpartido->current()->nombre_provincia .'" disabled/>
				</div>				
		
				<div data-linea="1">
				<label for="id_canton">Cantón: </label>
					<input type="text" id="id_Canton" name="id_Canton" value="'.$this->datosCursoImpartido->current()->nombre_canton .'" disabled/>					
				</div>				
		
				<div data-linea="2">
				<label for="id_parroquia">Parroquia: </label>
					<input type="text" id="id_Parroquia" name="id_Parroquia" value="'.$this->datosCursoImpartido->current()->nombre_parroquia .'" disabled/>		
				</div>	
				'.$oficina.'
				<div data-linea="3">
					<label for="sitio">Sitio Específico: </label>
					<input type="text" id="id_Sitio" name="id_Sitio" value="'.$this->datosCursoImpartido->current()->sitio .'" disabled />
				</div>	
			</fieldset >';
		}
		return $this->contenidoLugarCapacitacion;
	}

	public function construirPublicoMeta($banderaVisualizar){
		if($banderaVisualizar){
			$this->contenidoPublicoMeta = '<fieldset>
			<legend>Público Meta</legend>
			<div data-linea="1">
			<label for="publicoObjetivo">Nombre del Público Meta:</label>
				<select id="idPublicoObjetivo" name="id_publico_objetivo" style="width: 100%;" disabled="disabled">
					<option value="">Seleccione....</option>
					</select>'.$this->comboPublicoObjetivo.'
			</div>
			<div data-linea="2">
				<button type="buttom" class="mas" onclick="agregarPublico(); return false">Agregar</button>
			</div>
			<div style="width: 100%;">
				<table style="width: 100%; " id="tablaPublico">
					<thead>
					<tr>
						<th>Nombre</th>
						<th>Eliminar</th>
					</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
	
			</div>
		</fieldset>	';	
		}else{
			$this->cargarPublicoMeta();
			$this->contenidoPublicoMeta = '<fieldset>
			<legend>Público Meta</legend>
			<div style="width: 100%;">
				<table style="width: 100%; " id="tablaPublico">
					<thead>
					<tr>
						<th>Nombre</th>
					</tr>
					</thead>
					<tbody>
					'. $this->cargarContenidoPublicosMeta.'
					</tbody>
				</table>
			</div>
		</fieldset>	';
		}
	}

	public function construirDetallePublico($banderaVisualizar){
		if($banderaVisualizar){
			$this->contenidoDetallePublico = '<fieldset>	
			<legend>Detalle Público</legend>
			<div data-linea="1">
				<label for="id_genero">Genero:</label>
					<select id="genero" >
						<option value="">Seleccione....</option>
						<option value="Masculino">Masculino</option>					
						<option value="Femenino">Femenino</option>					
				</select>
			</div>
			<div data-linea="1" >
			<label for="cantidad">Cantidad: </label>
				<input class="input-number" type="text" id="cantidad"  value="" />
			</div>
			<div >
			* Registrar el género solo si existe asistentes por favor. 
			</div>
			<div data-linea="2">
				<button  type="buttom" class="mas" onclick="agregarDetallePublico(); return false">Agregar</button>
			</div>
			<div style="width: 100%;">
				<table style="width: 100%; " id="tablaDetallePublico">
					<thead>
					<tr>
						<th>Nombre</th>
						<th>Cantidad</th>
						<th>Eliminar</th>
					</tr>
					</thead>
					<tbody  >
					</tbody>
				</table>
	
			</div>
			<div data-linea="3" >
			<label for="totalAsistentes">Total Asistentes: </label>
				<input type="text" id="totalAsistentes" name="total_asistentes" value="" readonly />
			</div>
		</fieldset>	';
			
		}else{
			$this->cargarPublicoAsistente();
			$this->contenidoDetallePublico = '<fieldset>	
			<legend>Detalle Público</legend>
			<div style="width: 100%;">
				<table style="width: 100%; " id="tablaDetallePublico">
					<thead>
					<tr>
						<th>Nombre</th>
						<th>Cantidad</th>
					</tr>
					</thead>
					<tbody  >
					'.$this->cargarContenidoPublicosAsistente.'
					</tbody>
				</table>
	
			</div>
			<div data-linea="3" >
			<label for="totalAsistentes">Total Asistentes: </label>
				<input type="text" id="totalAsistentes" name="totalAsistentes" value="'.$this->cantidad.'" disabled />
			</div>
		</fieldset>	';
		}
	}

	public function construirDatosCapacitador($banderaVisualizar){
		if($banderaVisualizar){
			$this->contenidoDatosCapacitador = '<fieldset>	
		<legend>Datos Capacitador</legend>
		<div data-linea="1">
			<label for="id_TipoCapacitador">Tipo de Capacitador:</label>
				<select id="id_TipoCapacitador">
					<option value="">Seleccione....</option>
					<option value="Interno">Interno</option>					
					<option value="Externo">Externo</option>					
			</select>
		</div>
		<div data-linea="2" id="coordinacionCapacitador">
		<label for="id_CoordinacionCapacitador">Coordinación: </label>
			<select id="id_CoordinacionCapacitador" name="coordinacionCapacitador" style="width: 100%;" disabled="disabled" >
			<option value="">Seleccione....</option>
					'.$this->comboCoordinacion.'
			</select>
		</div>
		<div data-linea="3" id="nombreCapacitador" >
		<label for="idNombreCapacitador">Nombre: </label>
			<input type="text" id="id_NombreCapacitador" value="" disabled="disabled" />
		</div>	
		<div data-linea="4" id="provinciaCapacitador">
		<label for="id_ProvinciaCapacitador">Provincia: </label>
			<select id="id_ProvinciaCapacitador" style="width: 100%;" disabled="disabled">
			<option value="">Seleccione....</option>'.
			$this->comboProvincias.'
			</select>
		</div>	
		</div>		
		<div data-linea="5" id="paisCapacitador">
		<label for="id_PaisCapacitador">País: </label>
		<select id="id_PaisCapacitador"  style="width: 100%;" disabled="disabled" >
			<option value="">Seleccione....</option>'.
			$this->comboPaises.'
			</select>
		</div>	
		<div data-linea="6" id="funcionarioCapacitador">
		<label for="id_Funcionario">Funcionario: </label>
			<select id="id_Funcionario"  style="width: 100%;" disabled="disabled">
			<option value="first">Seleccione....</option>'.
			$this->comboFuncionarios.'
			</select>
		</div>
		<div data-linea="7" id="institucionCapacitador" >
		<label for="id_InstitucionCapacitador">Institución: </label>
			<input type="text" id="id_InstitucionCapacitador" value="" disabled="disabled" />
		</div>
		<div data-linea="8">
		<button  type="buttom" class="mas" onclick="agregarCapacitador(); return false">Agregar</button>
		</div>
		<div style="width: 100%;">
			<table style="width: 100%; " id="tablaCapacitador" class="datosCapacitador">
				<thead>
				<tr>
					<th>Nombre Capacitador</th>
					<th>Tipo</th>
					<th>Prov.Labora/País</th>
					<th>Eliminar</th>
				</tr>
				</thead>
				<tbody >
				</tbody>
			</table>
		</div>
	    </fieldset >';
			
		}else{
			$this->cargarDatosCapacitador();
			$this->contenidoDatosCapacitador = '
				
			<fieldset>	
				<legend>Datos Capacitador</legend>
			<div style="width: 100%;">
				<table style="width: 100%; " id="tablaCapacitador" class="datosCapacitador">
					<thead>
					<tr>
						<th>Nombre Capacitador</th>
						<th>Tipo</th>
						<th>Prov.Labora/Pais</th>
						
					</tr>
					</thead>
					<tbody >
					'.$this->cargarContenidoDatosCapacitador.'
					</tbody>
				</table>
			</div>
			</fieldset >';
		}
	}

	public function construirDatosGenerales($banderaVisualizar){
		if($banderaVisualizar){
			$this->contenidoDatosGenerales = '<fieldset >
			<legend>Datos Generales</legend>
		 	<div data-linea="1">
				<label for="archivo_asistentes">Constancia Asistentes:  </label> (Documento de registro o listado de personas que asistieron al taller.)
				<input type="hidden" id="archivoCons" class="rutaArchivo" name="archivo_constancia_asistentes" value="0"/>
				<input type="file" id="archivoConstancia" class="archivo" accept="application/msword | application/pdf | image/*"/>
				<div class="estadoCarga">En espera de archivo... (Tamaño máximo'.ini_get('upload_max_filesize').'B)</div>
				<button type="button" id="btnAsistencia" class="subirArchivo adjunto" data-rutaCarga="aplicaciones/mvc/modulos/RegistroCapacitaciones/archivos/asistencias">Subir archivo</button>
			</div>				
			<div data-linea="2">
			<label for="archivo_evidencia">Evidencia: </label> (Documento con fotografías.)
				<input type="hidden" id="archivoEvi" class="rutaArchivo" name="archivo_evidencia" value="0"/>
				<input type="file" id="archivoEvidencia" class="archivo" accept="application/msword | application/pdf | image/*"/>
				<div class="estadoCarga">En espera de archivo... (Tamaño máximo'.ini_get('upload_max_filesize').'B)</div>
				<button type="button" id="btnEvidencia"  class="subirArchivo adjunto" data-rutaCarga="aplicaciones/mvc/modulos/RegistroCapacitaciones/archivos/evidencias">Subir archivo</button>
			</div>
		
			<div data-linea="3" >
				<label for="conclusion">Conclusión/Recomendación: </label>
			</div>
				<textarea id="text_conclusion" onKeyUp="contadorPalabrasInput(this)" name="conclusion" rows="5" cols="50" maxlength="512" placeholder=" Escribe aqui tu conclusión..."></textarea>
			<div id="textarea_feedback"></div>

		</fieldset >';
		}else{
			$this->datosCursoImpartido = $this->lNegocioCursosImpartidos->obtenerCursoImpartidoXId($_POST["id"]);
			$this->contenidoDatosGenerales = '<fieldset >
			<legend>Datos Generales</legend>
			<div data-linea="1">
				<label for="archivo_evidencia">Asistencia: </label>
				<a href="'.$this->datosCursoImpartido->current()->archivo_constancia_asistentes.'" target="_blank" class="archivo_cargado">Archivo Asistencia</a>
			    </div>				
		   <div data-linea="1">
		   		<label for="archivo_evidencia">Evidencia: </label>
		   		<a href="'.$this->datosCursoImpartido->current()->archivo_evidencia.'" target="_blank" class="archivo_cargado">Archivo Evidencia</a>
				   </div>
		   <div data-linea="2" >
			   <label for="conclusion">Conclusión/Recomendación: </label>
		   </div>
				<textarea id="text_conclusion" rows="5" cols="50" maxlength="512" disabled = "disabled">'.$this->datosCursoImpartido->current()->conclusion .'</textarea>
		   <div id="textarea_feedback"></div>

	       </fieldset >';
		}
		if(isset($_POST["elementos"])){
			$this->contenidoDatosGenerales = '<div data-linea="2">
												<button id="eliminar" type="buttom"  onclick="eliminarCursoImpartido('.$_POST["id"].'); return false">Eliminar</button>
											</div>';
		}
	}

	//funcion que carga los temas ejecutados de los cursos dado un id de curso impartido
	public function cargarTemasEjecutados(){	
		$this->datosTemasEjecutados = $this->lNegocioTemasEjecutados->obtenerTemasEjecutadosXCursoCapacitacion($_POST["id"]);
		if (isset($this->datosTemasEjecutados)){
			foreach ($this->datosTemasEjecutados as $item) {
					$this->cargarContenidoTemasEjecutados .='<tr>
					<td style="text-align:center;">'.$item['nombre_temas_ejecutado'].'</td>
				</tr>';
			}
		}
		$this->cargarContenidoTemasEjecutados;
	}

	//funcion que carga los publicos objetivos de los cursos dado un id de curso impartido
	public function cargarPublicoMeta(){	
	
		$this->datosPublicoMeta = $this->lNegocioPublicosMeta->obtenerPublicoMetaXCursoCapacitacion($_POST["id"]);
		if (isset($this->datosPublicoMeta)){
			foreach ($this->datosPublicoMeta as $item) {

					$this->cargarContenidoPublicosMeta .='<tr id="'.$item['id_publico_meta'].'">
					<td style="text-align:center;" id="nombre_publico">'.$item['nombre_publico'].'</td>
				</tr>';
			}
		}
		$this->cargarContenidoPublicosMeta;
	}
	

	//funcion que carga el detalle publico de los cursos dado un id de curso de impartido
	public function cargarPublicoAsistente(){	
		$this->cantidad=0;
		$this->datosPublicoAsistente = $this->lNegocioPublicosAsistente->obtenerPublicoAsistenteXIdCursoImpartido($_POST["id"]);
		if (isset($this->datosPublicoAsistente)){
			foreach ($this->datosPublicoAsistente as $item) {
					$this->cargarContenidoPublicosAsistente .='<tr id="'.$item['id_publico_asistente'].'">
					<td style="text-align:center;" id="nombre_publico">'.$item['genero'].'</td>
					<td style="text-align:center;" id="nombre_publico">'.$item['cantidad'].'</td>
					<input type="hidden" id="genero" name="arrayGeneroAsistente[]"  value="'.$item['genero'].'">
					<input type="hidden" id="cantidad" name="arrayCantidadAsistente[]"  value="'.$item['cantidad'].'">
				</tr>';
				$this->cantidad += $item['cantidad'];
			}
           
		}
		$this->cargarContenidoPublicosAsistente;
	}

	//funcion que crea las filas en la tabla Temas Especificos
	public function agregarTemaEspecifico(){
		
		$estado = 'EXITO';
		$mensaje = '';
		$contenidoTemasEspecificos = '';

		$id_tema = $_POST['id_tema'];
		$nombre_tema = $_POST['nombre_tema'];

		$arrayParametros = array(
			'id_tema' => $id_tema,
			'nombre_tema' => $nombre_tema,
		);

		$contenidoTemasEspecificos ='<tr>
						<td style="text-align:left;">'.$arrayParametros['nombre_tema'].'</td>
						<input type="hidden" id="idTemasCursos" name="arrayIdTemasCursos[]"  value="'.$arrayParametros['id_tema'].'">
						<input type="hidden" id="temasCursos" name="arrayNombreTemasCursos[]"  value="'.$arrayParametros['nombre_tema'].'">
						<td class="borrar" style="text-align:center;"><button class="icono" onclick="eliminarTemaEspecifico(this)"></button></td>
					</tr>';
		echo json_encode(array
		(
			'estado'=> $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenidoTemasEspecificos
		));
	}

	//funcion que carga el detalle publico de los cursos dado un id de curso de impartido
	public function cargarDatosCapacitador(){	
		
		$this->datosCapacitadores = $this->lNegocioCapacitadores->obtenerCapacitadoresXIdCursoImpartido($_POST["id"]);
		if (isset($this->datosCapacitadores)){
			foreach ($this->datosCapacitadores as $item) {
				$lugarCapacitador = '';
				if(isset($item['nombre_provincia']) && ($item['nombre_provincia'] !='') ){
					$lugarCapacitador = $item['nombre_provincia'];
				}else if((isset($item['nombre_pais']) && ($item['nombre_pais'] !='') )){
					$lugarCapacitador = $item['nombre_pais'];
				}
				$this->cargarContenidoDatosCapacitador .='<tr>
				<td style="text-align:left;" id="nombreCapacitador">'.$item['nombre_capacitador'].'</td>
					<td style="text-align:center;" id="tipoCapacitador">'.$item['tipo_capacitador'].'</td>
					<td style="text-align:center;" id="lugarCapacitacion">'.$lugarCapacitador.'</td>
					
				</tr>';
			}
           
		}
		$this->cargarContenidoDatosCapacitador;
	}

	//funcion que crea las filas en la tabla agregar publico objetivo
	public function agregarPublicoMeta(){
		$estado = 'EXITO';
		$mensaje = '';
		$contenidoPublicoMeta = '';

		$id_publico = $_POST['id_publico'];
		$nombre_publico = $_POST['nombre_publico'];

		$arrayParametros = array(
			'id_publico' => $id_publico,
			'nombre_publico' => $nombre_publico
		);

		$contenidoPublicoMeta ='<tr>
						<td style="text-align:left;">'.$arrayParametros['nombre_publico'].'</td>
						<input type="hidden"  name="arrayIdPublicoMeta[]"  value="'.$arrayParametros['id_publico'].'">
						<input type="hidden"  name="arrayNombrePublicoMeta[]"  value="'.$arrayParametros['nombre_publico'].'">
						<td class="borrar" style="text-align:center;"><button class="icono" onclick="eliminarPublico(this); return false"></button></td>
					</tr>';
		echo json_encode(array
		(
			'estado'=> $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenidoPublicoMeta
		));
	}

	//funcion que eliminar el registro de un curso de impartido
	public function eliminarCursoImpartido(){	

		$estado = 'EXITO';
		$mensaje = 'Registro borrado con exito...!';
		$contenido = '';
		$cantidadCursos = array();
		$cantidadCursos = explode(',', $_POST["id_curso_impartido"]);

		if( count($cantidadCursos) ==1){
			$rutaArchivos = $this->lNegocioCursosImpartidos->buscar($_POST["id_curso_impartido"]);

            $ruta = $rutaArchivos->getArchivoConstanciaAsistentes();
            $link = explode('/', $ruta);
            $exists = is_file(REG_CAP_URL_CERT ."asistencias/".$link[6]);
            If ($exists) {
                unlink(REG_CAP_URL_CERT ."asistencias/".$link[6]);
            }

            $ruta = $rutaArchivos->getArchivoEvidencia();
            $link = explode('/', $ruta);
            $exists = is_file(REG_CAP_URL_CERT ."evidencias/".$link[6]);
            If ($exists) {
                unlink(REG_CAP_URL_CERT ."evidencias/".$link[6]);
            }
        
            $this->lNegocioCursosImpartidos->eliminarCursoImpartidoXId($_POST["id_curso_impartido"]);
            $arrayParametros = array(
                'cedula' => $_SESSION['usuario']
                );
            $modeloCursosImpartidos = $this->lNegocioCursosImpartidos->buscarCapacitacionesFiltradas($arrayParametros);
            $this->tablaHtmlCursosImpartidos($modeloCursosImpartidos);
            $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
            echo json_encode(array
            (
                'estado'=> $estado,
                'mensaje' => $mensaje,
                'contenido' => $contenido
            ));
            
		}
	}
	
}
