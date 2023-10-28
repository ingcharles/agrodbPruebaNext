<?php
 /**
 * Controlador ActividadesManejoIntegrado
 *
 * Este archivo controla la lógica del negocio del modelo:  ActividadesManejoIntegradoModelo y  Vistas
 *
 * @author  Kleber Armijos
 * @date   2023/04/12
 * @uses    AplicacionesControlador
 * @package AplicacionMovilInternos
 * @subpackage Controladores
 */
 namespace Agrodb\AplicacionMovilInternos\Controladores;
 use Agrodb\FormulariosInspeccion\Modelos\ActividadesManejoIntegradoLogicaNegocio;
 use Agrodb\FormulariosInspeccion\Modelos\ActividadesManejoIntegradoModelo;

 
class RestWsActividadesManejoIntegradoControlador extends BaseControlador 
{

		private $lNegocioActividadesManejoIntegrado = null;
	/**
	* Constructor
	*/
	function __construct(){	
		$this->lNegocioActividadesManejoIntegrado = new ActividadesManejoIntegradoLogicaNegocio();
		set_exception_handler(array($this, 'manejadorExcepciones'));
	}	

	/**
	 * Método que guarda las Actividades de manejo integrado
	 */
	public function guardarManejoIntegradoActividad(){
		
			$manejoActividad =  (Array)json_decode(file_get_contents('php://input'));
			
			$this->lNegocioActividadesManejoIntegrado->
			guardarManejoIntegradoActividad($manejoActividad);
		
	}


}
