<?php

/**
 * Controlador Base
 *
 * Este archivo contiene métodos comunes para todos los controladores
 *
 * @property  AGROCALIDAD
 * @author    Carlos Anchundia
 * @date      2022-12-20
 * @uses      BaseControlador
 * @package   RegistroProductoRia
 * @subpackage Controladores
 */

namespace Agrodb\RegistroProductoRia\Controladores;

session_start();

use Agrodb\Core\Comun;


class BaseControlador extends Comun
{
    public $itemsFiltrados = array();
    public $codigoJS = null;
    public $panelBusqueda = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::usuarioActivo();
        //Si se requiere agregar código concatenar la nueva cadena con  ejemplo $this->codigoJS.=alert('hola');
        $this->codigoJS = \Agrodb\Core\Mensajes::limpiar();
    }

    public function crearTabla()
    {
        $tabla = "//No existen datos para mostrar...";
        if (count($this->itemsFiltrados) > 0) {
            $tabla = '$(document).ready(function() {
			construirPaginacion($("#paginacion"),' . json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE) . ');
			$("#listadoItems").removeClass("comunes");
			});';
        }

        return $tabla;
    }

    public function cargarPanelSolicitudes($estadoDefecto = '', $desactivarCombo = false)
    {

        $estados = [
            'creado' => 'Creado',
            'pago' => 'Asignación de pago',
            'verificacion' => 'Verificación de pago',
            'asignadoInspeccion' => 'Asignado revisión técnica',
            'inspeccion' => 'Revisión técnica',
            'subsanacion' => 'Subsanación revisión técnica',
            'aprobado' => 'Aprobado',
            'rechazado' => 'Rechazado',
        ];

        $desactivarCombo = $desactivarCombo ? 'disabled' : '';

        $this->panelBusqueda = '<table class="filtro" style="width: 100%;">
                                            	<tbody>
	                                                <tr>
	                                                    <th colspan="4">Buscar solicitud:</th>
	                                                </tr>
	                                                <tr  style="width: 100%;">
	                            						<td >Producto: </td>
	                            						<td colspan="3">
	                            							<input id="nombreProducto" type="text" name="nombreProducto" value="" >
	                            						</td>
            
	                            					</tr>
                                                    <tr  style="width: 100%;">
	                            						<td >Estado Solicitud: </td>
	                            						<td colspan="3">
                                                            <select style="width: 100%;" id="estadoSolicitud" name= "estadoSolicitud">
        		                                                <option value="" ' . $desactivarCombo . '>Seleccione...</option>';
        foreach ($estados as $codigo => $valor) {
            if ($codigo === $estadoDefecto) {
                $this->panelBusqueda .= '<option value="' . $codigo . '" selected>' . $valor . '</option>';
            } else {
                $this->panelBusqueda .= '<option value="' . $codigo . '" ' . $desactivarCombo . '>' . $valor . '</option>';
            }
        }
        $this->panelBusqueda .= '</select>
	                            						</td>
	                            					</tr>
                                                    <tr  style="width: 100%;">
	                            						<td >Fecha: </td>
	                            						<td colspan="3">
	                            							<input id="fecha" type="text" name="fecha" value="" readonly>
	                            						</td>
            
	                            					</tr>
            
                            						<td colspan="4" style="text-align: end;">
                            							<button id="btnFiltrar">Filtrar lista</button>
                            						</td>
                            					</tr>
                            				</tbody>
                            			</table>';
    }

    public function estado($estado)
    {
        switch ($estado) {
            case 'creado':
                $estado = 'Creado';
                break;
            case 'pago':
                $estado = 'Asignación de pago';
                break;
            case 'verificacion':
                $estado = 'Verificación de pago';
                break;
            case 'inspeccion':
                $estado = 'Revisión técnica';
                break;
            case 'asignadoInspeccion':
                $estado = 'Asignado revisión técnica';
                break;
            case 'subsanacion':
                $estado = 'Subsanación';
                break;
            case 'aprobado':
                $estado = 'Aprobado';
                break;
            case 'rechazado':
                $estado = 'Rechazado';
                break;
            case 'generarOrden':
                $estado = 'Generación orden';
                break;
        }
        return $estado;
    }

    public function tipoSolicitud($tipoSolicitud)
    {
        switch ($tipoSolicitud) {
            case 'fertilizantes':
                $tipoSolicitud = 'Fertilizantes';
                break;
            case 'bioplaguicidas':
                $tipoSolicitud = 'Bioplaguicidas';
                break;
            case 'clonesfertilizantes':
                $tipoSolicitud = 'Clones fertilizantes';
                break;
            case 'clonesplaguicidas':
                $tipoSolicitud = 'Clones plaguicidas';
                break;
        }
        return $tipoSolicitud;
    }

    public function tipoSolicitudTiempo($tipoSolicitud)
    {
        $tiempo = '';
        switch ($tipoSolicitud) {
            case 'fertilizantes':
                $tiempo = '+ 1 month';
                break;
            case 'bioplaguicidas':
                $tiempo = '+ 35 days';
                break;
            case 'clonesfertilizantes':
                $tiempo = '+ 1 month';
                break;
            case 'clonesplaguicidas':
                $tiempo = '+ 1 month';
                break;
        }
        return $tiempo;
    }

    public function datosGeneralesOperador($operador)
    {
        return '<fieldset>
                    <legend>
                        Datos generales
                    </legend>
                    
                    <div data-linea="2">
                        <label>RUC/CI: </label>' . $operador->getIdentificador() . '
                    </div>
                    <div data-linea="3">
                        <label>Razón social: </label>' . $operador->getRazonSocial() . '
                    </div>
                    <div data-linea="4">
                        <label>Representante legal: </label>' . $operador->getNombreRepresentante() . ' ' . $operador->getApellidoRepresentante() . '
                    </div>
                    <div data-linea="5">
                        <label>Dirección: </label>' . $operador->getDireccion() . '
                    </div>
                    <div data-linea="6">
                        <label>Teléfono(s): </label>' . trim($operador->getTelefonoUno() . ' / ' . $operador->getTelefonoDos(), '/') . '
                    </div>
                    <div data-linea="7">
                        <label>Correo electrónico: </label>' . $operador->getCorreo() . '
                    </div>
                    <div data-linea="8">
                        <label>Representante técnico: </label>' . $operador->getNombreTecnico() . ' ' . $operador->getApellidoTecnico() . '
                    </div></fieldset>';

    }

    public function datosFinancieroRegistroProducto($datosFinanciero)
    {
        $datos = '<fieldset>
                    <legend>Información de pago</legend>
                        <div data-linea="1">
						<label>Monto a pagar:</label> <span class="alerta">$ ' . $datosFinanciero['total_pagar'] . '</span>
                        </br><a href="' . $datosFinanciero['orden_pago'] . '" target="_blank" class="archivo_cargado" id="archivo_cargado">Descargar orden de pago: </a>
					</div>
                </fieldset>';

        return $datos;
    }

    public function datosProductoRegistro($modeloSolicitudesRegistroProductos, $tipoSolicitud = null)
    {

        $datos = '';

        switch ($tipoSolicitud) {
            case 'fertilizantes':

                $datos = '<fieldset>
                        <legend>Producto</legend>
                        <div data-linea="1">
                            <label for="id_tipo_producto">Tipo de solicitud: </label> ' . $this->tipoSolicitud($modeloSolicitudesRegistroProductos->getTipoSolicitud()) . '
                        </div>
                        <div data-linea="2">
                            <label for="id_tipo_producto">Tipo de producto: </label> ' . $modeloSolicitudesRegistroProductos->getNombreTipoProducto() . '
                        </div>
                        <div data-linea="3">
                            <label for="id_subtipo_producto">Subtipo de producto: </label> ' . $modeloSolicitudesRegistroProductos->getNombreSubtipoProducto() . '
                        </div>
                        <div data-linea="4">
                            <label for="nombre_producto">Nombre de producto: </label> ' . $modeloSolicitudesRegistroProductos->getNombreProducto() . '
                        </div>
                        <div data-linea="5">
                            <label for="partida_arancelaria">Partida arancelaria: </label> ' . $modeloSolicitudesRegistroProductos->getPartidaArancelaria() . '
                        </div>
                    </fieldset>
                                
                    <fieldset>
                        <legend>Características</legend>
                        <div data-linea="1">
                            <label for="id_formulacion">Formulación: </label> ' . $modeloSolicitudesRegistroProductos->getNombreFormulacion() . '
                        </div>
                        <div data-linea="2">
                            <label for="dosis">Dosis: </label> ' . $modeloSolicitudesRegistroProductos->getDosis() . '
                        </div>
                        <div data-linea="2">
                            <label for="unidad_dosis">Unidad de dosis: </label> ' . $modeloSolicitudesRegistroProductos->getUnidadDosis() . '
                            </select>
                        </div>
                        <div data-linea="3">
                            <label for="periodo_reingreso">Período de reingreso/vida útil: </label> ' . $modeloSolicitudesRegistroProductos->getPeriodoReingreso() . '
                        </div>
                    </fieldset>';

                break;
            case 'bioplaguicidas':

                $datos = '<fieldset>
                        <legend>Producto</legend>
                        <div data-linea="1">
                            <label for="id_tipo_producto">Tipo de solicitud: </label> ' . $this->tipoSolicitud($modeloSolicitudesRegistroProductos->getTipoSolicitud()) . '
                        </div>
                        <div data-linea="2">
                            <label for="id_tipo_producto">Tipo de producto: </label> ' . $modeloSolicitudesRegistroProductos->getNombreTipoProducto() . '
                        </div>
                        <div data-linea="3">
                            <label for="id_subtipo_producto">Subtipo de producto: </label> ' . $modeloSolicitudesRegistroProductos->getNombreSubtipoProducto() . '
                        </div>
                        <div data-linea="4">
                            <label for="nombre_producto">Nombre de producto: </label> ' . $modeloSolicitudesRegistroProductos->getNombreProducto() . '
                        </div>
                    </fieldset>
                                
                    <fieldset>
                        <legend>Características</legend>
                        <div data-linea="1">
                            <label for="id_formulacion">Formulación: </label> ' . $modeloSolicitudesRegistroProductos->getNombreFormulacion() . '
                        </div>
                        <div data-linea="2">
                            <label for="categoria_toxicologica">Categoría toxicológica: </label> ' . $modeloSolicitudesRegistroProductos->getNombreCategoriaToxicologica() . '
                        </div>                  
                        <div data-linea="3">
                            <label for="periodo_reingreso">Período de reingreso/vida útil: </label> ' . $modeloSolicitudesRegistroProductos->getPeriodoReingreso() . '
                        </div>
                        <div data-linea="4">
                            <label for="estabilidad">Estabilidad: </label> ' . $modeloSolicitudesRegistroProductos->getEstabilidad() . '
                        </div>
                    </fieldset>';
                break;
            case 'clonesfertilizantes':
            case 'clonesplaguicidas':
                $datos = '<fieldset>
                        <legend>Producto</legend>
                        <div data-linea="1">
                            <label for="id_tipo_producto">Tipo de solicitud: </label> ' . $this->tipoSolicitud($modeloSolicitudesRegistroProductos->getTipoSolicitud()) . '
                        </div>';
                if($tipoSolicitud === 'clonesplaguicidas'){
                    $datos .= '<div data-linea="2">
                            <label for="tipo_plaguicida">Tipo de plaguicida: </label> ' . $modeloSolicitudesRegistroProductos->getTipoPlaguicida() . '
                        </div>';
                }
                $datos .= '<div data-linea="3">
                            <label for="id_tipo_producto">Tipo de producto: </label> ' . $modeloSolicitudesRegistroProductos->getNombreTipoProducto() . '
                        </div>
                        <div data-linea="4">
                            <label for="id_subtipo_producto">Subtipo de producto: </label> ' . $modeloSolicitudesRegistroProductos->getNombreSubtipoProducto() . '
                        </div>
                        <div data-linea="5">
                            <label for="nombre_producto">Producto: </label> ' . $modeloSolicitudesRegistroProductos->getNombreComun() . '
                        </div>
                        <div data-linea="6">
                            <label for="nombre_producto">Número de registro: </label> ' . $modeloSolicitudesRegistroProductos->getNumeroRegistro() . '
                        </div>
                        <div data-linea="7">
                            <label for="nombre_producto">Categoría toxicológica: </label> ' . $modeloSolicitudesRegistroProductos->getNombreCategoriaToxicologica() . '
                        </div>
                        <div data-linea="8">
                            <label for="nombre_producto">Nombre del Clon: </label> ' . $modeloSolicitudesRegistroProductos->getNombreProducto() . '
                        </div>
                    </fieldset>';
                break;
        }

        return $datos;
    }

    public function datosTecnicoAsigando($datosEmpleado, $contratoEmpleado)
    {
        return '<fieldset>
                    <legend>
                        Técnico Asignado
                    </legend>
                    
                    <div data-linea="1">
                        <label>Nombre: </label>' . $datosEmpleado->getNombre() . ' ' . $datosEmpleado->getApellido() . '
                    </div>
                    <div data-linea="2">
                        <label>Provincia: </label>' . $contratoEmpleado['provincia'] . '
                    </div>
                    <div data-linea="3">
                        <label>Correo: </label>' . $datosEmpleado->getMailInstitucional() . '
                    </div>
                    
                </fieldset>';
    }

    public function datosResultadoRevision($datos)
    {
        $resultadoRevision = '<fieldset>
                    <legend>
                        Resultado de revisión técnica
                    </legend>
                    
                    <div data-linea="1">
                        <label>Resultado: </label>' . $this->resultadoRevision($datos['resultado_revisor']) . '
                    </div>
                    <div data-linea="2">
                        <label>Observación: </label>' . $datos['observacion_revisor'] . '
                    </div>
                    <div data-linea="3">
                        <label>Documento: </label>' . (($datos['ruta_revisor'] == '0' || $datos['ruta_revisor'] == '') ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $datos['ruta_revisor'] . ' target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>') . '
                    </div>';
        if ($datos['ruta_certificado']) {
            $resultadoRevision .= '<div data-linea="4">
                        <label>Certificado de producto: </label>' . (($datos['ruta_certificado'] == '0' || $datos['ruta_certificado'] == '') ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $datos['ruta_certificado'] . ' target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>') . '
                    </div>';
        }

        $resultadoRevision .= '</fieldset>';

        return $resultadoRevision;
    }

    public function resultadoRevision($resultado)
    {
        switch ($resultado) {
            case 'aprobado':
                $estado = 'Aprobado';
                break;
            case 'rechazado':
                $estado = 'Rechazado';
                break;
            case 'subsanacion':
                $estado = 'Subsanación';
                break;
        }
        return $estado;
    }

    public function tipoSolicitudPorOpcion($nombreOpcion)
    {
        $tipoSolicitud = '';
        switch ($nombreOpcion) {
            case 'Revisión técnica fertilizantes':
                $tipoSolicitud = 'fertilizantes';
                break;
            case 'Revisión técnica Bio Plaguicidas':
                $tipoSolicitud = 'bioplaguicidas';
                break;
            case 'Revisión técnica clones fertilizantes':
                $tipoSolicitud = 'clonesfertilizantes';
                break;
            case 'Revisión técnica clones plaguicidas':
                $tipoSolicitud = 'clonesplaguicidas';
                break;
        }
        return $tipoSolicitud;
    }

    public function tipoSolicitudPorPerfil($tipoSolicitud)
    {
        $perfil = '';
        switch ($tipoSolicitud) {
            case 'fertilizantes':
                $perfil = 'PFL_TEC_RFE_PRO';
                break;
            case 'bioplaguicidas':
                $perfil = 'PFL_TEC_RBP_PRO';
                break;
            case 'clonesfertilizantes':
                $perfil = 'PFL_TEC_RCF_PRO';
                break;
            case 'clonesplaguicidas':
                $perfil = 'PFL_TEC_RCP_PRO';
                break;
        }
        return $perfil;
    }

    public function cargarPanelVerSolicitudes()
    {

        $estados = [
            'creado' => 'Creado',
            'pago' => 'Asignación de pago',
            'verificacion' => 'Verificación de pago',
            'asignadoInspeccion' => 'Asignado revisión técnica',
            'inspeccion' => 'Revisión técnica',
            'subsanacion' => 'Subsanación revisión técnica',
            'aprobado' => 'Aprobado',
            'rechazado' => 'Rechazado',
        ];

        $this->panelBusqueda = '<table id="filtro" class="filtro" style="width: 100%;">
                                            	<tbody>
	                                                <tr>
	                                                    <th colspan="4">Buscar solicitud:</th>
	                                                </tr>
	                                                <tr  style="width: 100%;">
	                            						<td >Identificador: </td>
	                            						<td colspan="3">
	                            							<input class="validacion" id="identificador" type="text" name="identificador" value="" >
	                            						</td>
	                            					</tr>
	                                                <tr  style="width: 100%;">
	                            						<td >Producto: </td>
	                            						<td colspan="3">
	                            							<input id="nombreProducto" type="text" name="nombreProducto" value="" >
	                            						</td>
            
	                            					</tr>
                                                    <tr  style="width: 100%;">
	                            						<td >Estado Solicitud: </td>
	                            						<td colspan="3">
                                                            <select style="width: 100%;" id="estadoSolicitud" name= "estadoSolicitud">
        		                                                <option value="">Seleccione...</option>';
                                                                foreach ($estados as $codigo => $valor) {
                                                                        $this->panelBusqueda .= '<option value="' . $codigo . '">' . $valor . '</option>';
                                                                }
                                                                $this->panelBusqueda .= '</select>
	                            						</td>
	                            					</tr>
                                                    <tr  style="width: 100%;">
	                            						<td >Fecha: </td>
	                            						<td colspan="3">
	                            							<input id="fecha" type="text" name="fecha" value="" readonly>
	                            						</td>
            
	                            					</tr>
            
                            						<td colspan="4" style="text-align: end;">
                            							<button id="btnFiltrar">Filtrar lista</button>
                            						</td>
                            					</tr>
                            				</tbody>
                            			</table>';
    }
}
