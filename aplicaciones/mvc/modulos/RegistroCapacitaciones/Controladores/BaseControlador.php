<?php

 /**
 * Controlador Base
 *
 * Este archivo contiene métodos comunes para todos los controladores 
 *
 * @property  AGROCALIDAD
 * @author    Carlos Anchundia
 * @date      2022-08-31
 * @uses      BaseControlador
 * @package   RegistroCapacitaciones
 * @subpackage Controladores
 */
namespace Agrodb\RegistroCapacitaciones\Controladores;

session_start();

use Agrodb\Core\Comun;
use Agrodb\Catalogos\Modelos\CatalogosPublicoLogicaNegocio;
use Agrodb\Estructura\Modelos\AreaLogicaNegocio;
use Agrodb\GUath\Modelos\DatosContratoLogicaNegocio;
use Agrodb\Catalogos\Modelos\LocalizacionLogicaNegocio;
use Agrodb\GUath\Modelos\DatosContratoModelo;
use Agrodb\RegistroCapacitaciones\Modelos\CursosCapacitacionesLogicaNegocio;

 
 
class BaseControlador extends Comun
{
	public $itemsFiltrados = array();
	public $codigoJS = null;
	public $lNegocioCatalogosPublico = null;
	public $comboCoordinacion = null;
	public $comboCatalogoPublico = null;
	public $lNegocioArea = null;
	public $lNegocioDatosContrato = null;
	public $lNegocioLocalizacion = null;
	public $comboPaises = null;
	public $comboProvincias = null;
	public $comboCantones = null;
	public $comboParroquias = null;
	public $comboOficinas = null;
	private $comboCursosCapacitaciones = null;
	private $lNegocioCursosCapacitaciones = null;


	/**
	* Constructor
	*/
	function __construct() {
		parent::usuarioActivo();
		//Si se requiere agregar código concatenar la nueva cadena con  ejemplo $this->codigoJS.=alert('hola');
		$this->codigoJS = \Agrodb\Core\Mensajes::limpiar();
		$this->lNegocioCatalogosPublico = new CatalogosPublicoLogicaNegocio();
		$this->lNegocioArea = new AreaLogicaNegocio();
		$this->lNegocioDatosContrato = new DatosContratoLogicaNegocio();
		$this->lNegocioLocalizacion = new LocalizacionLogicaNegocio();
		$this->lNegocioCursosCapacitaciones = new CursosCapacitacionesLogicaNegocio();

		
	}
	public function crearTabla() {
		$tabla = "//No existen datos para mostrar...";
		if (count($this->itemsFiltrados) > 0) {
			$tabla = '$(document).ready(function() {
			construirPaginacion($("#paginacion"),' . json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE) . ');
			$("#listadoItems").removeClass("comunes");
			});';
		}

	return $tabla;
	}

	//funcion para obtener la coordinacion del usuario logeado 
	public function cargarCoordinacionesPanel($idArea, $identificador){

		$where = "id_gestion = '$idArea' AND identificador = '$identificador' AND estado = 1";
		$datosContrato = $this->lNegocioDatosContrato->buscarLista($where);
	
		$nombreCoordinacion = $datosContrato->current()->coordinacion;
		
		
		$where = "estado = 1 and clasificacion = 'Planta Central' and categoria_area in (3,1) ";
		$coordinacion =  $this->lNegocioArea->buscarLista($where);
		$this->comboCoordinacion = "";
		foreach ($coordinacion as $item){
			if($nombreCoordinacion == $item->nombre){
				$this->comboCoordinacion .= '<option value="' . $item->id_area . '">' . $item->nombre . '</option>';
			}
			
		}
		return $this->comboCoordinacion;
	}

	//funcion para obtener la direccion del usuario logeado
	public function cargarDireccionesPanel($idArea, $identificador){

		$where = "id_gestion = '$idArea' AND identificador = '$identificador' AND estado = 1";
		$datosContrato = $this->lNegocioDatosContrato->buscarLista($where);
		$nombreDireccion = $datosContrato->current()->direccion;

		$where = "estado = 1 and nombre = '$nombreDireccion' and categoria_area = 4";
		$direccion =  $this->lNegocioArea->buscarLista($where);
		$comboDireccion = '';
		foreach ($direccion as $item){
			$comboDireccion .= '<option value = "' . $item->id_area . '">' . $item->nombre . '</option>';
		}
		return $comboDireccion;
	}

	//funcion para obtener todas las coordinaciones principales 
	public function cargarCoordinaciones(){

		$where = "estado = 1 and clasificacion = 'Planta Central' and categoria_area in (3,1) ";
		$coordinacion =  $this->lNegocioArea->buscarLista($where);
		$this->comboCoordinacion = "";
		foreach ($coordinacion as $item){
			$this->comboCoordinacion .= '<option value="' . $item->id_area . '">' . $item->nombre . '</option>';
		}
		return $this->comboCoordinacion;
	}

	

	//funcion para obtener todas las direccion dada una coordinacion
	public function comboDireccionesXCoordinaciones(){
	
		$id_coordinacion = $_POST['id_coordinacion'];
		$where = "estado = 1 and id_area_padre = '$id_coordinacion' and categoria_area = 4";
		$area =  $this->lNegocioArea->buscarLista($where);
		$comboDireccion =  '';
		foreach ($area as $item){
				$comboDireccion .= '<option value = "' . $item->id_area . '">' . $item->nombre . '</option>';
		}
		echo $comboDireccion;
		exit();
	}

	//funcion que obtiene todos los datos de la tabla catalogo publico
	public function comboCatalogoPublico(){

		$catalogoPublico =  $this->lNegocioCatalogosPublico->buscarTodo();
		$this->comboCatalogoPublico = "";
		$this->comboCatalogoPublico .= '<select id = "idPublico"  style="width: 100%;" >
		<option value = "">Seleccione....</option>';

		foreach ($catalogoPublico as $item){
			$this->comboCatalogoPublico .= '<option value = "' . $item->id_catalogo_publico . '">' . $item->nombre . '</option>';
		}
		$this->comboCatalogoPublico .= '</select>';
		return $this->comboCatalogoPublico;
	}

		
	//funcion que obtiene todas las provincias
	public function comboListaPaises(){
		$localizacion =  $this->lNegocioLocalizacion->buscarPaises();
		$this->comboPaises = "";
		foreach ($localizacion as $item){
			$this->comboPaises .= '<option value = "' . $item->id_localizacion . '" data-nombrepais="'.$item->nombre.'">' . $item->nombre . '</option>';
		}
		return $this->comboPaises;
	}

	//funcion que obtiene todas las provincias
	public function comboListaProvincias(){
		$localizacion =  $this->lNegocioLocalizacion->buscarProvinciasEc();
		$this->comboProvincias = "";
		foreach ($localizacion as $item){
			$this->comboProvincias .= '<option value = "' . $item->id_localizacion . '" data-nombreprovincia="'.$item->nombre.'">' . $item->nombre . '</option>';
		}
		return $this->comboProvincias;
	}

	//funcion para obtener todos los cantones dada una provincia
	public function comboListaCantonesXProvincia(){
		
		$idProvincia = $_POST['idProvincia'];
		$canton =  $this->lNegocioLocalizacion->buscarCantones($idProvincia);
		$this->comboCantones = "";
		foreach ($canton as $item){
			$this->comboCantones .= '<option value = "' . $item->id_localizacion . '">' . $item->nombre . '</option>';
		}
		echo $this->comboCantones;
		exit();
	}

	//funcion para obtener todas las parroquias dado un canton
	public function comboListaParroquiasXCanton(){
		
		$idCanton = $_POST['idCanton'];
		
		$parroquia =  $this->lNegocioLocalizacion->buscarParroquias($idCanton);
		$this->comboParroquias = "";
		
		foreach ($parroquia as $item){
			$this->comboParroquias .= '<option value="' . $item->id_localizacion . '">' . $item->nombre . '</option>';
		}
		echo $this->comboParroquias;
		exit();
	}

	public function comboListaOficinasXCantones(){
		$idCanton = $_POST['idCanton'];
		$nombreCanton = $_POST['nombreCanton'];
		$oficinas =  $this->lNegocioLocalizacion->obtenerOficinasXCanton($idCanton);
		$this->comboOficinas = "";
		if($nombreCanton == "Quito"){
			foreach ($oficinas as $item){
				if($item->nombre == "Oficina Planta Central"){
					$this->comboOficinas .= '<option value="' . $item->id_localizacion . '">' . $item->nombre .'</option>';
				}
			}
		}else{
			foreach ($oficinas as $item){
				$this->comboOficinas .= '<option value="' . $item->id_localizacion . '">' . $item->nombre . '</option>';
			}
		}
		
		echo $this->comboOficinas;
		exit();
	}
	//funcion para obtener todos los cursos capacitaciones creados
	public function cargarCursosCapacitacionesXIdCoordinacionXIdDireccion(){
		
		$id_coordinacion = $_POST['id_coordinacion'];
		$id_direccion = $_POST['id_direccion'];
		
		$cursosCapacitaciones =  $this->lNegocioCursosCapacitaciones->obtenerCursoCapacitacionXCoordinacionXDireccion($id_coordinacion, $id_direccion);
		foreach ($cursosCapacitaciones as $item){
			$this->comboCursosCapacitaciones .= '<option value="' . $item->id_curso_capacitacion . '">' . $item->nombre_curso .'</option>';
		}
		echo $this->comboCursosCapacitaciones;
		exit();	
	}
}
