<?php

/**
 * Controlador Base
 *
 * Este archivo contiene métodos comunes para todos los controladores
 *
 * @property AGROCALIDAD
 * @author Carlos Anchundia
 * @date      2022-12-15
 * @uses BaseControlador
 * @package InspeccionFitosanitaria
 * @subpackage Controladores
 */
namespace Agrodb\InspeccionFitosanitaria\Controladores;

session_start();

use Agrodb\Core\Comun;
use Agrodb\RegistroOperador\Modelos\OperadoresLogicaNegocio;
use Agrodb\Catalogos\Modelos\ProductosLogicaNegocio;
use Agrodb\InspeccionFitosanitaria\Modelos\ProductosInspeccionFitosanitariaLogicaNegocio;
use Agrodb\Usuarios\Modelos\UsuariosPerfilesLogicaNegocio;

class BaseControlador extends Comun{

	public $itemsFiltrados = array();

	public $codigoJS = null;

	/**
	 * Constructor
	 */
	function __construct(){
		parent::usuarioActivo();
		// Si se requiere agregar código concatenar la nueva cadena con ejemplo $this->codigoJS.=alert('hola');
		$this->codigoJS = \Agrodb\Core\Mensajes::limpiar();
	}

	public function crearTabla(){
		$tabla = "//No existen datos para mostrar...";
		if (count($this->itemsFiltrados) > 0){
			$tabla = '$(document).ready(function() {
			construirPaginacion($("#paginacion"),' . json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE) . ');
			$("#listadoItems").removeClass("comunes");
			});';
		}

		return $tabla;
	}

	/**
	 * Método para construir los datos generales del operador que genera la solicitud
	 */
	public function construirDetalleOperador(){
		$operadoresLogicaNegocio = new OperadoresLogicaNegocio();
		$identificador = $this->identificador;
		$arrayParametros = [
			'identificador' => $identificador];

		$datosOperador = $operadoresLogicaNegocio->obtenerDatosOperadores($arrayParametros);

		if (isset($datosOperador->current()->identificador)){

			$datos = '<fieldset>
                        <legend>Datos generales</legend>
                            <div data-linea="1">
                                <label>Razón social: </label>' . $datosOperador->current()->nombre_operador . '
                            <div>
                            <div data-linea="2">
                                <label>Ruc: </label>' . $datosOperador->current()->identificador . '
                            <div>
                            <div data-linea="3">
                                <label>Representante legal: </label>' . $datosOperador->current()->representante_legal . '
                            <div>
                            <div data-linea="4">
                                <label>Dirección: </label>' . $datosOperador->current()->direccion . '
                            <div>
                            <div data-linea="5">
                                <label>Teléfono: </label>' . $datosOperador->current()->telefono . '
                            <div>
                            <div data-linea="6">
                                <label>Correo: </label>' . $datosOperador->current()->correo . '
                            <div>
							<div data-linea="7">
                                <label>Representante técnico: </label>' . $datosOperador->current()->representante_tecnico . '
                            <div>
                        </fieldset>';

			return $datos;
		}
	}

	/**
	 * Método para construir los datos generales del operador que genera la solicitud en revision
	 */
	public function construirDetalleOperadorRevision($identificadorOperador){
		$operadoresLogicaNegocio = new OperadoresLogicaNegocio();
		$identificador = $identificadorOperador;
		$arrayParametros = [
			'identificador' => $identificador];
		
		$datosOperador = $operadoresLogicaNegocio->obtenerDatosOperadores($arrayParametros);
		
		if (isset($datosOperador->current()->identificador)){
			
			$datos = '<fieldset>
                        <legend>Datos generales</legend>
                            <div data-linea="1">
                                <label>Razón social: </label>' . $datosOperador->current()->nombre_operador . '
                            <div>
                            <div data-linea="2">
                                <label>Ruc: </label>' . $datosOperador->current()->identificador . '
                            <div>
                            <div data-linea="3">
                                <label>Representante legal: </label>' . $datosOperador->current()->representante_legal . '
                            <div>
                            <div data-linea="4">
                                <label>Dirección: </label>' . $datosOperador->current()->direccion . '
                            <div>
                            <div data-linea="5">
                                <label>Teléfono: </label>' . $datosOperador->current()->telefono . '
                            <div>
                            <div data-linea="6">
                                <label>Correo: </label>' . $datosOperador->current()->correo . '
                            <div>
							<div data-linea="7">
                                <label>Representante técnico: </label>' . $datosOperador->current()->representante_tecnico . '
                            <div>
                        </fieldset>';
			
			return $datos;
		}
	}
	
	/**
	 * Método para construir los datos generales del operador que genera la solicitud
	 */
	public function estadosSolicitud(){
		$datos = '<select style="width: 100%;" id="b_estado" name= "b_estado1">
                    <option value="">Seleccione...</option>
                    <option value="Creado">Creado</option>
                    <option value="Enviado">Enviado</option>
                    <option value="Confirmado">Confirmado</option>
					<option value="Subsanado">Subsanado</option>
					<option value="Subsanacion">Subsanación</option>
                    <option value="Aprobado">Aprobado</option>
					<option value="Caducado">Caducado</option>
                    <option value="Rechazado">Rechazado</option>
                    <option value="Desistido">Desistido</option>
                </select>';

		return $datos;
	}

	public function cargarPanelSolicitudes($esInspector){
		$estadoSolicitud = "";
		$datosProducto = "";

		if (!$esInspector){
			$estadoSolicitud = '<tr  style="width: 100%;">
	        <td >Estado solicitud: </td>
	        <td colspan="3">' . $this->estadosSolicitud() . '</td>	            
	            </tr>';
		}else{
		    $datosProducto = '<tr>
        						<td>Tipo de producto: </td>
        						<td colspan="3">
        							<select id="b_tipo_producto" name="b_tipo_producto" style="width: 100%;">
                        			     <option value="">Seleccionar....</option>'
                        			     . $this->comboTipoProductoPorArea('SV') .
                        			     '</select>
                                </td>                                						
        					</tr>
                            <tr>
        						<td>Subtipo de producto: </td>
        						<td colspan="3">
        							<select id="b_subtipo_producto" name="b_tipo_producto" style="width: 100%;">
                                        <option value="">Seleccionar....</option>
                                    </select>
                                </td>                                						
        					</tr>
                            <tr>
        						<td>Producto: </td>
        						<td colspan="3">
        							<select id="b_producto" name="b_producto" style="width: 100%;">
                                        <option value="">Seleccionar....</option>
                                    </select>
                                </td>                                						
        					</tr>';		    
		}

		$this->panelBusqueda = '<table class="filtro" style="width: 100%;">
                                            	<tbody>
	                                                <tr>
	                                                    <th colspan="4">Buscar solicitud:</th>
	                                                </tr>
	                                                <tr  style="width: 100%;">
	                            						<td >País destino: </td>
	                            						<td colspan="3">
	                            						     <select style="width: 100%;" id="b_id_pais_destino" name= "b_id_pais_destino">
                                                             <option value="">Seleccione...</option>' . $this->comboPaises() . '</select></td>
													<tr  style="width: 100%;">
	                            						<td >Número solicitud: </td>
	                            						<td colspan="3">
														<input style="width: 100%;" type="text" id="b_numero_solicitud" name="b_numero_solicitud" value="">
	                            						</td>            
	                            					</tr>' . $estadoSolicitud . $datosProducto . '<tr  style="width: 100%;">
	                            						<td>Fecha inicio: </td>
	                            						<td>
	                            							<input id="b_fecha_inicio" type="text" name="b_fecha_inicio" value="" style="width: 100%;" readonly>
	                            						</td>
                                                        <td>Fecha fin: </td>
	                            						<td>
	                            							<input id="b_fecha_fin" type="text" name="b_fecha_fin" value="" style="width: 100%;" readonly>
	                            						</td>                
	                            					</tr>	                
                            						<td colspan="4" style="text-align: end;">
                            							<button id="btnFiltrar">Filtrar lista</button>
                            						</td>
                            					</tr>
                            				</tbody>
                            			</table>';
	}

	public function validarConstruirComboLugarInspeccion($idInspeccionFitosanitaria, $idPaisDestino){
		$lNegocioProductos = new ProductosLogicaNegocio();
		$lNegocioProductosInspeccionFitosanitaria = new ProductosInspeccionFitosanitariaLogicaNegocio();

		$qProductosInspeccionFitosanitaria = $lNegocioProductosInspeccionFitosanitaria->buscarLista(array(
			'id_inspeccion_fitosanitaria' => $idInspeccionFitosanitaria));

		$banderaClasificacion = false;
		$validarProtocolo = false;
		$arrayProtocolo = false;
		$arrayClasificacion = array();
		$codigoLugarInspeccion = "";
		$tipoSolicitud = "";
		$comboLugarInspeccion = "";

		foreach ($qProductosInspeccionFitosanitaria as $productosInspeccionFitosanitaria){

			$idProducto = $productosInspeccionFitosanitaria['id_producto'];

			$qDatoProducto = $lNegocioProductos->obtenerDatosProductoSubtipoProductoPorIdProducto($idProducto, $idPaisDestino);
			$clasificacionProducto = $qDatoProducto->current()->clasificacion;
			$protocoloProducto = $qDatoProducto->current()->protocolo_producto_pais;

			if (isset($clasificacionProducto)){
				$arrayClasificacion[] = $clasificacionProducto;
			}

			if (isset($protocoloProducto)){
				$arrayProtocolo[] = $protocoloProducto;
				$validarProtocolo = true;
				// Al menos un producto es de otros con protocolo
				if ($clasificacionProducto === "otros"){
					$banderaClasificacion = true;
				}
			}
		}

		if ($validarProtocolo){
			$arrayProtocolo = array_unique($arrayProtocolo);
		}

		$arrayClasificacion = array_unique($arrayClasificacion);

		if (count($arrayClasificacion) == 1){

			// Todos son musaceas
			if (in_array("musaceas", $arrayClasificacion)){
				$tipoSolicitud = "musaceas";
				$codigoLugarInspeccion = "ACOPROPUE";
			}

			// Todos son otros y no tienen protocolos
			if (in_array("otros", $arrayClasificacion)){
				$tipoSolicitud = "otros";
				if (! $arrayProtocolo){
					$codigoLugarInspeccion = "ACOAGC";
				}
			}
		}
		/*
		 * echo "<pre>";
		 * print_r($arrayProtocolo);
		 * echo "<pre>";
		 */

		// Son musaceas y otros sin protocolo
		if (count($arrayClasificacion) == 2){
			$tipoSolicitud = "otros";
			if (! $arrayProtocolo){
				$codigoLugarInspeccion = "ACOAGC";
			}
			if ($arrayProtocolo){
				$codigoLugarInspeccion = "ACO";
			}
		}

		if ($banderaClasificacion){
			$tipoSolicitud = "otros";
			$codigoLugarInspeccion = "ACO";
		}

		$datosComboLugarInspeccion = "";

		switch ($codigoLugarInspeccion) {
			case 'ACOPROPUE':
				$datosComboLugarInspeccion = '
                    <option value="">Seleccione...</option>
                    <option value="ACO">Acopio</option>
                    <option value="PRO">Lugar de producción</option>
                    <option value="PUE">Puerto</option>';
			break;
			case 'ACOAGC':
				$datosComboLugarInspeccion = '
                    <option value="">Seleccione...</option>
                    <option value="ACO">Acopio</option>
                    <option value="AGE">Agencia de carga</option>';
			break;
			case 'ACO':
				$datosComboLugarInspeccion = '
                    <option value="">Seleccione...</option>
                    <option value="ACO">Acopio</option>';
			break;
			default:
				$datosComboLugarInspeccion = '
                    <option value="">Seleccione...</option>';
			break;
		}

		$comboLugarInspeccion = '<select id="id_area" name="id_area" class="validacion" data-tiposolicitud="' . $tipoSolicitud . '">' . $datosComboLugarInspeccion . '</select>';

		return array(
			'comboLugarInspeccion' => $comboLugarInspeccion,
			'tipoSolicitud' => $tipoSolicitud);
	}

	public function cargarPanelSolicitudesRevisionEstadoSolicitud(){
		$this->panelBusqueda = '<table class="filtro" style="width: 100%;">
                                            	<tbody>
	                                                <tr>
	                                                    <th colspan="4">Buscar solicitud:</th>
	                                                </tr>
	                                                <tr  style="width: 100%;">
	                            						<td >País destino: </td>
	                            						<td colspan="3">
	                            						     <select style="width: 100%;" id="b_id_pais_destino" name= "b_id_pais_destino">
                                                             <option value="">Seleccione...</option>' . $this->comboPaises() . '</select></td>
	            
	                            						</tr>
														<tr  style="width: 100%;">
	                            						<td >Número solicitud: </td>
	                            						<td colspan="3">
														<input style="width: 100%;" type="text" id="b_numero_solicitud" name="b_numero_solicitud" value="">
	                            						</td>            
	                            						</tr>
											            <tr  style="width: 100%;">
												        <td >Estado solicitud: </td>
												        <td colspan="3">' . $this->estadosSolicitud() . '</td>
											            </tr>
														<tr  style="width: 100%;">
	                            						<td >Identificador: </td>
	                            						<td colspan="3">
	                            							<input id="b_identificador_operador" type="text" name="b_identificador_operador" value="" style="width: 100%;">
	                            						</td>
	                
	                            					</tr>
	                                               <tr  style="width: 100%;">
	                            						<td>Fecha inicio: </td>
	                            						<td>
	                            							<input id="b_fecha_inicio" type="text" name="b_fecha_inicio" value="" style="width: 100%;" readonly>
	                            						</td>
                                                        <td>Fecha fin: </td>
	                            						<td>
	                            							<input id="b_fecha_fin" type="text" name="b_fecha_fin" value="" style="width: 100%;" readonly>
	                            						</td>	                
	                            					</tr>
	                
                            						<td colspan="4" style="text-align: end;">
                            							<button id="btnFiltrar">Filtrar lista</button>
                            						</td>
                            					</tr>
                            				</tbody>
                            			</table>';
	}
	
	/**
	 * Método para construir los la impresion del tipo de lugar de inspeccion
	 */
	public function construirLugarInspeccion($tipoArea){
		
		$lugarInspeccion = "";
		
		switch ($tipoArea){
			case 'ACO':
				$lugarInspeccion = 'Centro de acopio';
			break;
			case 'PUE':
				$lugarInspeccion = 'Puerto';
			break;
			case 'PRO':
				$lugarInspeccion = 'Lugar de producción';
			break;
			case 'AGE':
			    $lugarInspeccion = 'Agencia de carga';
			break;
			
		}
		
		return $lugarInspeccion;
		
	}
	
	/**
	 * Método para obtener perfil
	 */
	public function obtenerPerfilInspectorFitosanitario($identificador){
	    
	    $usuariosPerfilesLogicaNegocio = new UsuariosPerfilesLogicaNegocio();
	    
	    $inspector = false;
        $codificacionPerfil = "'PFL_CON_INS_FITO', 'PFL_TEC_INS_FITO'";
	    $arrayParametros = ['identificador' => $identificador
                	        , 'codificacion_perfil' => $codificacionPerfil];
	    
	    $datosUsuario = $usuariosPerfilesLogicaNegocio->buscarUsuariosPorIdentificadorPorCodigoPerfil($arrayParametros);
	    
	    if($datosUsuario->count()){
	        $inspector = true;
	    }
	    
	    return $inspector;
	    
	}

}
