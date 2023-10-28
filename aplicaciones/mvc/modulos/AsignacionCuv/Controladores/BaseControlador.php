<?php

 /**
 * Controlador Base
 *
 * Este archivo contiene métodos comunes para todos los controladores 
 *
 * @property  AGROCALIDAD
 * @author    Gabriel Chalco
 * @date      2023-03-21
 * @uses      BaseControlador
 * @package   AsignacionCuv
 * @subpackage Controladores
 */
namespace Agrodb\AsignacionCuv\Controladores;
use Agrodb\AsignacionCuv\Modelos\EntregasCuvLogicaNegocio;
use Agrodb\AsignacionCuv\Modelos\EntregasCuvModelo;
use Agrodb\AsignacionCuv\Modelos\RedistribucionCuvLogicaNegocio;
use Agrodb\AsignacionCuv\Modelos\RedistribucionCuvModelo;

session_start();

use Agrodb\Core\Comun;
 
 
class BaseControlador extends Comun
{
	public $itemsFiltrados = array();
	public $codigoJS = null;
	private $modeloEntregasCuvBC = null;
	private $lNegocioEntregasCuvBc = null;
	private $modeloRedistribucionCuvBC = null;
	private $lNegocioRedistribucionCuvBc = null;

	/**
	* Constructor
	*/
	function __construct() {
		parent::usuarioActivo();
		//Si se requiere agregar código concatenar la nueva cadena con  ejemplo $this->codigoJS.=alert('hola');
		$this->codigoJS = \Agrodb\Core\Mensajes::limpiar();
		$this->lNegocioEntregasCuvBc = new EntregasCuvLogicaNegocio();
		$this->modeloEntregasCuvBC = new EntregasCuvModelo();
		$this->lNegocioRedistribucionCuvBc = new RedistribucionCuvLogicaNegocio();
		$this->modeloRedistribucionCuvBC = new RedistribucionCuvModelo();
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

		/**
	 * Consulta los meses
	 */
	public function comboAnios($anioBusqu = null)
	{
	    $anio = date('Y');
	    $list = '<option value="">Seleccionar....</option>';
	    for($i=2023; $i<= $anio; $i++){
	        if ($i == $anioBusqu)
	        {
	            $list .= '<option value="' . $i . '" selected>' . $i. '</option>';
	        } else
	        {
	            $list .= '<option value="' . $i . '">' . $i . '</option>';
	        }
	    }
	    return $list;
	}

	public function construirResultadoSolicitud($SolicitudAsignacionCuv)
	{
		if($SolicitudAsignacionCuv){
			$estadoSolicitud = $SolicitudAsignacionCuv->getEstadoSolicitud();
			$idSolicitud = $SolicitudAsignacionCuv->getIdSolicitudAsignacionCuv();
			$siglas = $SolicitudAsignacionCuv->getSiglas();
			$anio = $SolicitudAsignacionCuv->getAnio();
			$prefijo = $SolicitudAsignacionCuv->getPrefijoCuvNumerico();
			$resultado = $siglas . '-' . $anio . '-' . $prefijo;
			$entregas = $this->lNegocioEntregasCuvBc->buscarEntregasPoridSolicitud($idSolicitud);
			//$cantidadEntregas = $entregas->getCantidad();
			foreach ($entregas as $entrega) {
				$cantidadEntregas = $entrega['cantidad'];
				$inicio = $entrega['codigo_cuv_inicio'];
				$fin = $entrega['codigo_cuv_fin'];
			}
		}else{
			$estadoSolicitud = null;
		}
		$datos = "";
		switch ($estadoSolicitud) {
			case 'Aprobada':
				$datos .= '
				<div data-linea="7">
					<label for="cantidadAsignada">Cantidad Asignada: </label>
					<input type="text" id="cantidadAsignada"
					name="cantidadAsignada" value="' . $cantidadEntregas . '" disabled />
				</div>
				<div data-linea="8">
					<label for="serieInicio">Serie Inicio: </label>
					<input type="text" id="serieInicio"
					name="serieInicio" value="' .$resultado.'-'. $inicio . '" disabled />
				</div>
				<div data-linea="8">
					<label for="serieFin">Serie Fin: </label>
					<input type="text" id="serieFin"
					name="serieFin" value="' .$resultado.'-'. $fin . '" disabled />
				</div>
				<div data-linea="9">
					<label for="observaciones">Observaciones: </label>
					<input type="text" id="observaciones"
					name="observaciones" value="' . $SolicitudAsignacionCuv->getObservaciones() . '" disabled />
					<input type="hidden" id="id_solicitud_asignacion_cuv" name="id_solicitud_asignacion_cuv"
					name="observaciones" value="' . $SolicitudAsignacionCuv->getIdSolicitudAsignacionCuv() . '"/>
				</div>
				<div data-linea="20">
					<button type="submit">Acta de Entrega-Recepción</button>
				</div>
				<div id="cargarMensajeTemporal"></div>';
				break;
			default:
				$datos .= '<div data-linea="10">
				<label for="resultadoNoAprobado">La asignación aún no ha sido aprobada.</label>
				</div>';
				break;
		}
	return '<fieldset><legend>Resultado Solicitud: </legend>' . $datos . '</fieldset>';
	}

	public function comboEstadoSolicitudCUV($estado = null){
		$combo = "";
		if ($estado == "Pendiente") {
			$combo .= '<option value="Pendiente" selected="selected">Pendiente</option>';
			$combo .= '<option value="Aprobada">Aprobada</option>';
			$combo .= '<option value="Rechazada">Rechazada</option>';
			$combo .= '<option value="Todos">Todos</option>';
		}
		else if($estado == "Aprobada") {
			$combo .= '<option value="Pendiente" selected="selected">Pendiente</option>';
			$combo .= '<option value="Aprobada">Aprobada</option>';
			$combo .= '<option value="Rechazada">Rechazada</option>';
			$combo .= '<option value="Todos">Todos</option>';
		}else if($estado == "Rechazada") {
			$combo .= '<option value="Pendiente" selected="selected">Pendiente</option>';
			$combo .= '<option value="Aprobada">Aprobada</option>';
			$combo .= '<option value="Rechazada">Rechazada</option>';
			$combo .= '<option value="Todos">Todos</option>';
		}else if($estado == "Todos"){
			$combo .= '<option value="Pendiente" selected="selected">Pendiente</option>';
			$combo .= '<option value="Aprobada">Aprobada</option>';
			$combo .= '<option value="Rechazada">Rechazada</option>';
			$combo .= '<option value="Todos">Todos</option>';
		}else {
			$combo .= '<option value="Pendiente">Pendiente</option>';
			$combo .= '<option value="Aprobada">Aprobada</option>';
			$combo .= '<option value="Rechazada">Rechazada</option>';
			$combo .= '<option value="Todos">Todos</option>';
		}
		return $combo;
	}

	/**
 * Genera un combo de estados de solicitud
 *
 * @param string $opcion Opción seleccionada
 * @return string
 */
public function comboEstadosSolicitudRedistribucion($opcion = null) {
    $combo = '<select id="slctEstadoRedist" name="slctEstadoRedist" style="width: 100%;">';
    
    $estados = array(
        "Todos" => "Todos",
        "Aprobado" => "Aprobado",
        "Pendiente" => "Pendiente",
        "Pendiente Envío" => "Pendiente Envío",
        "Rechazada" => "Rechazada"
    );

    foreach ($estados as $valor => $texto) {
        if ($opcion == $valor) {
            $combo .= '<option value="' . $valor . '" selected="selected">' . $texto . '</option>';
        } else {
            $combo .= '<option value="' . $valor . '">' . $texto . '</option>';
        }
    }

    $combo .= '</select>';
    return $combo;
}

	public function construirResultadoSolicitudRedistribucion($modeloSolicitudRedistribucionCuv)
	{
		if ($modeloSolicitudRedistribucionCuv) {
			$estadoSolicitudRedistribucion = $modeloSolicitudRedistribucionCuv->getEstadoSolicitud();
			$cantidadRedistribucion = $modeloSolicitudRedistribucionCuv->getCantidadSolicitada();
			$tecnicoProvincia = $modeloSolicitudRedistribucionCuv->getTecnicoProvincia();
			$provinciaDestino = $modeloSolicitudRedistribucionCuv->getProvinciaDestino();
			$redistribuciones = $this->lNegocioRedistribucionCuvBc->buscarRedistribucionPoridSolicitudNativo($modeloSolicitudRedistribucionCuv->getIdSolicitudRedistribucionCuv());
			if ($redistribuciones->count()) {
				foreach ($redistribuciones as $redistribucion) {
					$fecha_redistribucion = $redistribucion['fecha_redistribucion'];
					$codigo_cuv_inicio = $redistribucion['codigo_cuv_inicio'];
					$codigo_cuv_fin = $redistribucion['codigo_cuv_fin'];
				}
			}
		}
		else{
			$estadoSolicitudRedistribucion = null;
		}
		$datos = "";
		switch ($estadoSolicitudRedistribucion) {
			case 'Aprobado':
				$datos .= '
				<div data-linea="7">
					<label for="fecha_redistribucion">Fecha Redistribución: </label>
					<input type="text" id="fecha_redistribucion"
					name="fecha_redistribucion" value="' . $fecha_redistribucion . '" disabled />
				</div>
				<div data-linea="8">
					<label for="tecnicoProvincia">Técnico de Provincia: </label>
					<input type="text" id="tecnicoProvincia"
					name="tecnicoProvincia" value="' . $tecnicoProvincia . '" disabled />
				</div>
				<div data-linea="9">
					<label for="provinciaDestino">Provincia Destino: </label>
					<input type="text" id="provinciaDestino"
					name="provinciaDestino" value="' . $provinciaDestino . '" disabled />
				</div>
				<div data-linea="10">
					<label for="cantidadResignada">Cantidad Asignada: </label>
					<input type="text" id="cantidadResignada"
					name="cantidadResignada" value="' . $cantidadRedistribucion . '" disabled />
				</div>
				<div data-linea="11">
					<label for="codigo_cuv_inicio">CUV Inicio: </label>
					<input type="text" id="codigo_cuv_inicio"
					name="codigo_cuv_inicio" value="' . $codigo_cuv_inicio . '" disabled />
				</div>
				<div data-linea="11">
					<label for="codigo_cuv_fin">CUV Fin: </label>
					<input type="text" id="codigo_cuv_fin"
					name="codigo_cuv_fin" value="' . $codigo_cuv_fin . '" disabled />
				</div>
				<div data-linea="12">
					<input type="hidden" id="id_solicitud_redistribucion_cuv" name="id_solicitud_redistribucion_cuv"
					name="observaciones" value="' .$modeloSolicitudRedistribucionCuv->getIdSolicitudRedistribucionCuv(). '"/>
				</div>
				
				<div data-linea="20" style="text-align:center;width:100%">
					<button type="submit">Acta de Entrega-Recepción</button>
				</div>
				<div data-linea="9">
				<div id="cargarMensajeTemporal"></div>';
				break;
			case 'Rechazada':
					$datos .= '<div data-linea="14">
					<label for="resultadoNoAprobado">La Reasignación ha sido Rechazada</label>
					</div>';
					break;
			default:
				$datos .= '<div data-linea="10">
				<label for="resultadoNoAprobado">La Reasignación aún no ha sido aprobada.</label>
				</div>';
				break;
		}
		return '<fieldset><legend>Resultado Redistribución: </legend>' . $datos . '</fieldset>';

	}
}
