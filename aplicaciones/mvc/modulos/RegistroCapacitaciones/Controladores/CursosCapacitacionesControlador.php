<?php
 /**
 * Controlador CursosCapacitaciones
 *
 * Este archivo controla la lógica del negocio del modelo:  CursosCapacitacionesModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-08-31
 * @uses    CursosCapacitacionesControlador
 * @package RegistroCapacitaciones
 * @subpackage Controladores
 */
 namespace Agrodb\RegistroCapacitaciones\Controladores;
 use Agrodb\RegistroCapacitaciones\Modelos\CursosCapacitacionesLogicaNegocio;
 use Agrodb\RegistroCapacitaciones\Modelos\CursosCapacitacionesModelo;
 use Agrodb\RegistroCapacitaciones\Modelos\TemasCursosLogicaNegocio;
 use Agrodb\RegistroCapacitaciones\Modelos\PublicoObjetivoLogicaNegocio;
 use Agrodb\Catalogos\Modelos\TiposOperacionLogicaNegocio;
 use Agrodb\Catalogos\Modelos\TiposOperacionModelo;
 use Agrodb\Core\Constantes;
 use Agrodb\Core\Mensajes;
 use Agrodb\Core\JasperReport;

class CursosCapacitacionesControlador extends BaseControlador 
{
		 private $lNegocioCursosCapacitaciones = null;
		 
		 private $lNegocioTemasCursos = null;
		 
		 private $lNegocioPublicosObjetivos = null;
		// private $modeloCursosCapacitaciones = null;
		 
		private $accion = null;
		
		private $datosCapacitacion = null;
		
		private $datosTemasCurso = null;
		
		private $datosPublicoObjetivo = null;
		
		private $datosTemasCursos = null;
		
		private $lNegocioTiposOperacion = null;
	
		private $modeloTiposOperacion = null;

		 
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
			$this->lNegocioCursosCapacitaciones = new CursosCapacitacionesLogicaNegocio();
			$this->modeloCursosCapacitaciones = new CursosCapacitacionesModelo();
			$this->contenido = '';
			$this->contenidoCapacitaciones = '';
			$this->contenidoTemaCurso = '';
			$this->contenidoPublicoMeta = '';
			$this->cargarContenidoTemasCursos = '';
			$this->cargarContenidoPublicosObjetivos = '';
			$this->lNegocioTemasCursos = new TemasCursosLogicaNegocio();
			$this->lNegocioPublicosObjetivos = new PublicoObjetivoLogicaNegocio();
			$this->lNegocioTiposOperacion = new TiposOperacionLogicaNegocio();
			$this->modeloTiposOperacion = new TiposOperacionModelo();


		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{

		//para que se muestre el panel de busqueda al momento de abrir la opcion
		$this->cargarPanelAdministracion();
		$solicitudes = $this->lNegocioCursosCapacitaciones->obtenerCursosCApacitacionXIdentificador($_SESSION['usuario']);

		$this->tablaHtmlCursoCapacitacionesRevisiones($solicitudes);

		$contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
		 require APP . 'RegistroCapacitaciones/vistas/listaCursosCapacitacionesVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
			$banderaVisualizar=true;
			$this->construirCapacitacion($banderaVisualizar);
			$this->construirTemaCurso($banderaVisualizar);
			$this->construirPublicoMeta($banderaVisualizar);
		    $this->comboCatalogoPublico();
		    $this->cargarCoordinaciones();
		    $this->accion = "Nuevo tema de Capacitación"; 
		    require APP . 'RegistroCapacitaciones/vistas/formularioCursosCapacitacionesVistaNuevo.php';
		}	/**
		* Método para registrar en la base de datos -CursosCapacitaciones
		*/
		public function guardar()
		{
			//echo ("holis");
			
			if ($_POST['banderaCapacitacion'] == 'nuevo'){
				$buquedaCursoCapacitacion = $this->lNegocioCursosCapacitaciones->buscarCursoCapacitacionXNombre($_POST['nombre_curso'],$_POST['id_coordinacion'],$_POST['id_direccion']);
				if(($buquedaCursoCapacitacion->count() == 0)){
					$this->insertarDatos();
					
				}else{
					$estado = "Fallo";
					$mensaje = "No se puede agregar este tema de curso por que ya se encuentra registrado ";
					echo json_encode(array(
						'estado' => $estado, 
						'mensaje' => $mensaje
					));	
				}
			}else if ($_POST['banderaCapacitacion'] == 'editar'){
				$this->insertarDatos();
			}

		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: CursosCapacitaciones
		*/
		public function insertarDatos()
		{
			$_POST['identificador'] = $this->identificador;
						$this->lNegocioCursosCapacitaciones->guardar($_POST);
						Mensajes::exito(Constantes::GUARDADO_CON_EXITO);
		}

		public function editar()
		{
			$banderaVisualizar=false;
			$this->construirCapacitacion($banderaVisualizar);
			$this->construirTemaCurso($banderaVisualizar);
			$this->construirPublicoMeta($banderaVisualizar);
		    $this->comboCatalogoPublico();
		    $this->accion = "Visualización Tema de Capacitación"; 
		 	require APP . 'RegistroCapacitaciones/vistas/formularioCursosCapacitacionesVistaEditar.php';
		}	/**
		* Método para borrar un registro en la base de datos - CursosCapacitaciones
		*/
		public function borrar()
		{
		  $this->lNegocioCursosCapacitaciones->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - CursosCapacitaciones
		*/
		//funcion que abre la ventana de una registro obtenido en la busqueda 
		public function tablaHtmlCursoCapacitacionesRevisiones($tabla) {
			
			 $contador = 0;
			  foreach ($tabla as $fila) {
			   $this->itemsFiltrados[] = array(
			  '<tr id="' . $fila['id_curso_capacitacion'] . '"
			  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'RegistroCapacitaciones/CursosCapacitaciones"
			  data-opcion="editar" ondragstart="drag(event)" draggable="true"
			  data-destino="detalleItem">
			  <td>' . ++$contador . '</td>
			  <td>'. $fila['nombre_curso'] . '</td>
			  <td>' . $fila['normativa']. '</td>
			  <td>'. $fila['nombre']. '</td>
			  </tr>');
			}
		}
		

	//panel de busqueda paraa obtener las capacitaciones (opcion Admin de Capacitaciones)
	public function cargarPanelAdministracion()
	{
		$this->panelBusquedaAdministrador = '<table class="filtro">
			<tbody>
				<tr>
					<td><label>*Coordinación:</label> </td>
						<td colspan=3>
							<select id="id_coordinacionBusqueda" name="id_coordinacionSelect" style="width: 100%;" required>
							<option value="">Seleccione....</option>'.$this->cargarCoordinacionesPanel($_SESSION['idGestion'],$_SESSION['usuario']).'</select>
						</td>
				</tr>
				<tr class="tecnico">
					<td><label>*Dirección:</label> </td>
						<td>
							<select id="id_direccionBusqueda" name="id_direccionselect" style="width: 100%;" required>
							<option value="">Seleccione....</option>'.$this->cargarDireccionesPanel($_SESSION['idGestion'],$_SESSION['usuario']).'</select>
						</td>
				</tr>
				<tr>
					<td><label>Tema de Capacitación:</label> </td>
					<td colspan=3>
						<input type="text" id="nombre_capacitacion" name="nombre_capacitacion" style="width: 100%;" />
					</td>
				</tr>
				<tr>
					<td class="col-sm-6">
						Los campos con * son obligatorios.
					</td> 
					<td class="col-sm-6">
						<button type="button" id="btnFiltrar">Buscar</button>
					</td> 
				</tr>
			</tbody>
		</table>';
	}

	//funcion para listar todas las capacitaciones obtenidas dado el cirterio de busqueda(coordinacion, direccion, nombre capacitacion)
	public function listarCursoCapacitacionesFiltradas()
	{
		$estado = 'EXITO';
		$mensaje = '';
		$contenido = '';

		$nombreCapacitacion = $_POST['nombre_capacitacion'];
		$id_coordinacion = $_POST['id_coordinacion'];
		$id_direccion = $_POST['id_direccion'];

		$arrayParametros = array(
			'nombre_curso' => $nombreCapacitacion,
			'id_coordinacion' => $id_coordinacion,
			'id_direccion' => $id_direccion,
			
		);

		$solicitudes = $this->lNegocioCursosCapacitaciones->buscarCapacitacionesFiltradas($arrayParametros);

		$this->tablaHtmlCursoCapacitacionesRevisiones($solicitudes);

		$contenido = \Zend\Json\Json::encode($this->itemsFiltrados);

		echo json_encode(array(
			'estado' => $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido
		));
	}


	//funcion que crea las filas en la tabla agregar temas especificos
	public function agregarTema(){

		$estado = 'EXITO';
		$mensaje = '';
		$contenido = '';

		$nombre_tema = $_POST['nombre_tema'];

		$arrayParametros = array(
			'nombre_tema' => $nombre_tema,
		);

		$contenido ='<tr >
						<td style="text-align:left;" id="nombre_tema">'.$arrayParametros['nombre_tema'].'</td>
						<input type="hidden" id="temasEspecificos" name="temas[]"  value="'.$arrayParametros['nombre_tema'].'">
						<td class="borrar" style="text-align:center;"><button class="icono" onclick="eliminarTemaCurso(this)"></button></td>
					</tr>';

		echo json_encode(array
		(
			'estado'=> $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido
		));

	}

	//funcion que crea las filas en la tabla agregar publico objetivo
	public function agregarPublico(){
			

		$estado = 'EXITO';
		$mensaje = '';
		$contenido = '';

		$id_publico = $_POST['id_publico'];
		$nombre_publico = $_POST['nombre_publico'];

		$arrayParametros = array(
			'id_publico' => $id_publico,
			'nombre_publico' => $nombre_publico
		);

		$contenido ='<tr>
						<td style="text-align:left;">'.$arrayParametros['nombre_publico'].'</td>
						<input type="hidden" id="idCatalogoPublico" name="idCatalogoPublico[]"  value="'.$arrayParametros['id_publico'].'">
						<input type="hidden" id="publico" name="publico[]"  value="'.$arrayParametros['nombre_publico'].'">
						<td class="borrar" style="text-align:center;"><button class="icono" onclick="eliminarPublico(this)"></button></td>
					</tr>';
		echo json_encode(array
		(
			'estado'=> $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido
		));
	}

	public function construirCapacitacion($banderaVisualizar){
		
		if($banderaVisualizar){
			$this->contenidoCapacitacion ='<fieldset >
				<legend>Capacitaciones</legend>
				<input type="hidden"  name="banderaCapacitacion" value="nuevo"style="width: 100%;" />
					<div data-linea="1">
						<label for="nombre_curso">Nombre Capacitación: </label>
						<input type="text" id="nombre_curso" name="nombre_curso" />
					</div>	
					<div data-linea="2">
						<label for="objetivo">Objetivo: </label>
						<input type="text" id="objetivo" name="objetivo" value=""/>
					</div>
					<div data-linea="3">
						<label for="normativa">Normativa: </label>
						<input type="text" id="normativa" name="normativa" value="" />
					</div>
					<div data-linea="4" >
						<label for="id_coordinacion">Coordinación: </label>
							<select id="id_coordinacionSelect" name="id_coordinacion" style="width: 100%;">
							<option value="">Seleccione....</option>'
							. $this->cargarCoordinaciones() .
							'</select>
					</div>	
					<div data-linea="5">
						<label for="id_direccion">Dirección: </label>
							<select id="id_direccionSelect" name="id_direccion" style="width: 100%;" disabled="disabled">
								<option value="">Seleccione....</option>
							</select>
					</div>					
			</fieldset>';
			
		}else{
			$this->datosCapacitacion = $this->lNegocioCursosCapacitaciones->obtenerCursoCapacitacion($_POST["id"]);

			$this->contenidoCapacitacion ='<fieldset>
			<legend>Capacitaciones</legend>
			<input type="hidden" name="banderaCapacitacion" value="editar"style="width: 100%;" />
			<input type="hidden" name="id_curso_capacitacion" value="'.$this->datosCapacitacion->current()->id_curso_capacitacion .'" />
				<div data-linea="1">
					<label for="nombre_curso">Nombre Capacitación: </label>
					<input type="text" id="nombre_curso" name="nombre_curso" value="'.$this->datosCapacitacion->current()->nombre_curso .'"
					disabled />
				</div>	
			<div data-linea="2">
				<label for="objetivo">Objetivo: </label>
				<input type="text" id="objetivo" name="objetivo" value="' . $this->datosCapacitacion->current()->objetivo . '" disabled />
			</div>
			<div data-linea="3">
				<label for="normativa">Normativa: </label>
				<input type="text" id="normativa" name="normativa" value="' . $this->datosCapacitacion->current()->normativa . '"
				disabled />
			</div>	
			<div data-linea="4">
				<label for="id_coordinacion">Coordinación: </label>
				<input type="text" id="coordinacion" name="coordinacion" value="' . $this->datosCapacitacion->current()->nombre_coordinacion . '"
				disabled />
			</div>				
			<div data-linea="5">
				<label for="id_direccion">Dirección: </label>
				<input type="text" id="id_direccion" name="id_direccion" value="' . $this->datosCapacitacion->current()->nombre_direccion . '"
				disabled />
			</div>			
			</fieldset>';

		}
		return $this->contenidoCapacitacion;
		
	}
	public function construirTemaCurso($banderaVisualizar){
		if($banderaVisualizar){
			$this->contenidoTemaCurso ='<fieldset>
			<legend>Tema Específico</legend>
			<div data-linea="1">
				<label for="nombre_tema">Nombre Tema Específico: </label>
				<input type="text" id="nombre_tema" name="nombre_tema"  />
			</div>	
			
			<div data-linea="2">
				<button id="agregarTemaEspecifico" type="buttom" class="mas" onclick="agregarTemaCurso(); return false">Agregar</button>
			</div>
			<div style="width: 100%;">
				<table style="width: 100%; " id="tablaTemaCurso">
					<thead>
					<tr>
						<th>Nombre</th>
						<th>Eliminar</th>
					</tr>
					</thead>
					<tbody  >
					</tbody>
				</table>

			</div>
		</fieldset>';

		}else{
			
			$this->cargarTemasCursos();
			$this->contenidoTemaCurso ='<fieldset>
			<legend>Tema Específico</legend>
			<div data-linea="1">
				<label for="nombre_tema">Nombre Tema Específico: </label>
				<input type="text" id="nombre_tema" name="nombre_tema"  />
			</div>	
			<div data-linea="2">
				<button id="agregarTemaEspecifico" type="buttom" class="mas" onclick="agregarTemaCurso(); return false">Agregar</button>
			</div>
			<div style="width: 100%;">
				<table style="width: 100%; " id="tablaTemaCurso">
					<thead>
					<tr>
						<th>Nombre</th>
						<th>Eliminar</th>
					</tr>
					</thead>
					<tbody  >
					'. $this->cargarContenidoTemasCursos.'
					</tbody>
				</table>
			</div>
		</fieldset>';
			
		}

		return $this->contenidoTemaCurso;
		
	}
	public function construirPublicoMeta($banderaVisualizar){
		if($banderaVisualizar){
			$this->contenidoPublicoMeta ='<fieldset>
			<legend>Público Meta</legend>
			<div data-linea="1" >
				<label for="nombre_publico">Nombre del Público Meta: </label>'
				. $this->comboCatalogoPublico() .
			'</div>	
			<div data-linea="2">
				<button id="agregarPublicoMeta" type="buttom" class="mas" onclick="agregarPublico(); return false">Agregar</button>
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
			$this->cargarPublicoObjetivo();
			$this->contenidoPublicoMeta ='<fieldset>
			<legend>Público Meta</legend>
				<div data-linea="1" >
					<label for="nombre_publico">Nombre del Público Meta: </label>'.
					$this->comboCatalogoPublico().
				'</div>	
				<div data-linea="2">
					<button id="agregarPublicoMeta" type="buttom" class="mas" onclick="agregarPublico(); return false">Agregar</button>
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
					'. $this->cargarContenidoPublicosObjetivos.'
					</tbody>
				</table>
				</div>
			</fieldset>';
			
		}
		return $this->contenidoPublicoMeta;
	}

	//funcion que carga los temas de los cursos dado un id de curso de capacitacion
	public function cargarTemasCursos(){

		$this->datosTemasCurso = $this->lNegocioTemasCursos->obtenerTemasXCursoCapacitacion($_POST["id"]);
		if (isset($this->datosTemasCurso)){
			foreach ($this->datosTemasCurso as $item) {
							
					$this->cargarContenidoTemasCursos .='<tr id="'.$item['id_tema_curso'].'">
						<td style="text-align:left;" id="nombre_tema">'.$item['nombre_tema'].'</td>
						<td class="borrar" style="text-align:center;"><button class="icono" onclick="eliminarRegistroTemaCurso('.$item['id_tema_curso'].','.$item["id_curso_capacitacion"].'); return false"></button></td>
					</tr>';
			}
		}
		$this->cargarContenidoTemasCursos;
	}
	//funcion que carga los publicos objetivos de los cursos dado un id de curso de capacitacion
	public function cargarPublicoObjetivo(){	
		$this->datosPublicoObjetivo = $this->lNegocioPublicosObjetivos->obtenerPublicoObjetivoXCursoCapacitacion($_POST["id"]);
		if (isset($this->datosPublicoObjetivo)){
			foreach ($this->datosPublicoObjetivo as $item) {
			
					$this->cargarContenidoPublicosObjetivos .='<tr id="'.$item['id_publico_objetivo'].'">
					<td style="text-align:left;" id="nombre_publico">'.$item['nombre_publico'].'</td>
					<td class="borrar" style="text-align:center;"><button class="icono" onclick="eliminarRegistroPublicoObjetivo('.$item['id_publico_objetivo'].','.$item['id_curso_capacitacion'].'); return false"></button></td>
				</tr>';
			}
		}
		$this->cargarContenidoPublicosObjetivos;
	}

	/**
     * Método para generar el reporte de pasaportes equinos en excel
     */
    public function exportarCursosCapacitacionExcel() {


		if(isset($_POST['id_provinciaFiltro']) && $_POST['id_provinciaFiltro'] == 'PC' ){
            $datosProvincia = $this->provinciaXNombre("Pichincha");
            if (isset($datosProvincia)){
                $_POST['id_provinciaFiltro'] = $datosProvincia->current()->id_localizacion;
                $_POST['codProvincia'] = 'PC';
            }
        }
		
		$fechaInicio = (isset($_POST["fecha_inicio"])?$_POST["fecha_inicio"]:'');
        $fechaFin =(isset($_POST["fecha_fin"])?$_POST["fecha_fin"]:'');
        $coordinacionFiltro = (isset($_POST["id_coordinacion"])?$_POST["id_coordinacion"]:'');
        $direccionFiltro = (isset($_POST["id_direccion"])?$_POST["id_direccion"]:'');
        $idCursoCapacitacionFiltro = (isset($_POST["id_curso_capacitacion"])?$_POST["id_curso_capacitacion"]:'');
        $provinciaFiltro = (isset($_POST["id_provinciaFiltro"])?$_POST["id_provinciaFiltro"]:'');
        $codProvincia = (isset($_POST['codProvincia'])?$_POST['codProvincia']:'');
				
		if  ($direccionFiltro == 'Seleccione....' || $fechaInicio == '' || $fechaFin == '' ){
			
			$estado = 'FALLO';
		     $mensaje = 'Los campos requeridos para poder generar el reporte es Fecha (Inicio-Fin), Coordinacion y Direccion.'; 
		    echo json_encode(array(
			'estado' => $estado,
			'mensaje' => $mensaje
			));
	
		}else{
			
			$arrayParametros = array(
				'fecha_fin' => $fechaFin,
				'fecha_inicio' => $fechaInicio,
				'id_coordinacion' => $coordinacionFiltro,
				'id_direccion' => $direccionFiltro,
				'id_curso_capacitacion' => $idCursoCapacitacionFiltro,
				'id_provincia' => $provinciaFiltro,
				'cod_provincia' => $codProvincia
			);
			
			$cursosCapacitacion = $this->lNegocioCursosCapacitaciones->buscarCursosCapacitacionReporteFiltrados($arrayParametros);
		
			$this->lNegocioCursosCapacitaciones->exportarArchivoExcelCursosCapacitacion($cursosCapacitacion);
		}
    }
	
}

