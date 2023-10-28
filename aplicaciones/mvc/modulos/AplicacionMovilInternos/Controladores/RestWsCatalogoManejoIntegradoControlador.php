<?php
/**
 * Controlador Alertas
 *
 * Este archivo controla los combos de todo lo referente a 
 *
 * @author AGROCALIDAD
 * @date   2020-09-07
 * @uses AplicacionesControlador
 * @package AplicacionMovilInternos
 * @subpackage Controladores
 */
namespace Agrodb\AplicacionMovilInternos\Controladores;

use Agrodb\Catalogos\Modelos\ActividadManejoIntegradoLogicaNegocio;


class RestWsCatalogoManejoIntegradoControlador extends BaseControlador{

	private $lNegocioLocalizacion = null;
	private $lNegocioCatalogoActividaManejoIntegrado=null;


	/**
	 * Constructor
	 */
	function __construct(){
		$this->lNegocioCatalogoActividaManejoIntegrado=new ActividadManejoIntegradoLogicaNegocio();

		//$this->modeloLocalizacion = new LocalizacionModelo();
		set_exception_handler(array(
			$this,
			'manejadorExcepciones'));
	}
	
	
	/**
	 * Método de obtención de cantones
	 */
	public function obtenerCantones($provincia){
		
		$localizacion = $this->lNegocioLocalizacion->buscarCantones($provincia);
		echo json_encode($localizacion->toArray());
	}

	/**
	 * Método  para obtener el catálogo de cantones y parroquias por provincia si el parametro
	 * es null saca todas las provincias los cantones y las parroquias
	 * @param int provincia
	 * identificador de la provincia
	 */
	public function catalogoLocalizacionProvincia($provincia=null){
		
		$this->lNegocioLocalizacion->BuscarCatalogoCantonParroquiaPorProvincia($provincia);

	}

	/**
	 * KA: PRY-2022-009
	 * Método  para obtener todos los catalogos del formultario actividad Manejo
	 * Integrado cuando el codigo sea 1
	 * @param 
	 * Ninguno
	 */

	 public function catalogosActividadManejoIntegrado(){
		
		$this->lNegocioCatalogoActividaManejoIntegrado->ObtenerCatalogosActividadManejoIntegrado();

	}
}