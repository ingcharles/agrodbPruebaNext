<?php

 /**
 * Controlador Base
 *
 * Este archivo contiene métodos comunes para todos los controladores 
 *
 * @property  AGROCALIDAD
 * @author    Carlos Anchundia
 * @date      2020-03-23
 * @uses      BaseControlador
 * @package   CertificacionBPA
 * @subpackage Controladores
 */
namespace Agrodb\CertificacionBPA\Controladores;

session_start();

use Agrodb\Core\Comun;
 
 
class BaseControlador extends Comun
{
	public $itemsFiltrados = array();
	public $codigoJS = null;

	/**
	* Constructor
	*/
	function __construct() {
		parent::usuarioActivo();
		//Si se requiere agregar código concatenar la nueva cadena con  ejemplo $this->codigoJS.=alert('hola');
		$this->codigoJS = \Agrodb\Core\Mensajes::limpiar();
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
}