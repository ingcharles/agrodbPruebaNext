<?php

/**
 * Controlador Base
 *
 * Este archivo contiene métodos comunes para todos los controladores
 *
 * @property  AGROCALIDAD
 * @author    Carlos Anchundia
 * @date      2022-10-21
 * @uses      BaseControlador
 * @package   EnsayoEficacia
 * @subpackage Controladores
 */

namespace Agrodb\EnsayoEficacia\Controladores;

session_start();

use Agrodb\Core\Comun;


class BaseControlador extends Comun
{
    public $itemsFiltrados = array();
    public $codigoJS = null;

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

    public function estado($estado)
    {
        switch ($estado) {
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
            case 'organismoInspeccion':
                $estado = 'Asignar organismo de Inspección';
                break;
            case 'ingresarResultado':
                $estado = 'Ingresar resultados';
                break;
            case 'asignadoInspeccionResultado':
                $estado = 'Asignado revisión técnica de resultados';
                break;
            case 'inspeccionResultado':
                $estado = 'Revisión técnica de resultados';
                break;
            case 'subsanacion':
                $estado = 'Subsanación revisión técnica';
                break;
            case 'subsanacionResultado':
                $estado = 'Subsanación revisión técnica resultados';
                break;
            case 'aprobado':
                $estado = 'Aprobado';
                break;
            case 'rechazado':
                $estado = 'Rechazado';
                break;
        }
        return $estado;
    }

    public function tipoSolicitud($tipoSolicitud)
    {
        switch ($tipoSolicitud) {
            case 'registro':
                $tipoSolicitud = 'Registro';
                break;
            case 'ampliacionCondicionesUso':
                $tipoSolicitud = 'Ampliación/Cambio en las condiciones de uso';
                break;
            case 'modificacionDosis':
                $tipoSolicitud = 'Modificación de dosis';
                break;
            case 'reevaluacion':
                $tipoSolicitud = 'Revaluación';
                break;
            case 'usoAdicionalregistroProceso':
                $tipoSolicitud = 'Uso adicional para registro en proceso';
                break;
        }
        return $tipoSolicitud;
    }

    public function tipoProducto($tipoProducto)
    {
        switch ($tipoProducto) {
            case 'quimico':
                $tipoProducto = 'Químico';
                break;
            case 'biologico':
                $tipoProducto = 'Biológico';
                break;
        }
        return $tipoProducto;
    }

    public function datosGeneralesOperador($operador)
    {
        $datos = '<fieldset>
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

        return $datos;

    }

    public function datosSolicitud($solicitud)
    {
        $datos = '<fieldset>
                    <legend>
                        Datos de solicitud
                    </legend>
                    
                    <div data-linea="2">
                        <label>Tipo de solicitud: </label>' . $this->tipoSolicitud($solicitud->getTipoSolicitud()) . '
                    </div>
                    <div data-linea="3">
                        <label>Tipo de producto: </label>' . $this->tipoProducto($solicitud->getTipoProducto()) . '
                    </div>
                    <div data-linea="4">
                        <label>Producto: </label>' . $solicitud->getProducto() . '
                    </div>
                    <div data-linea="5">
                        <label>Título del ensayo: </label>' . $solicitud->getTituloEnsayo() . '
                    </div>
                    <div data-linea="6">
                        <label>Categoría toxicológica: </label>' . $solicitud->getNombreCategoriaToxicologica() . '
                    </div>
                  </fieldset>';

        return $datos;

    }

    public function documentosAdjuntos($solicitud)
    {
        $datos = '<fieldset>
                    <legend>
                        Documentos requeridos
                    </legend>
                    
                    <div data-linea="2">
                        <label>Ficha técnica: </label>' . ($solicitud->getRutaFichaTecnica() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>':'<a href='.$solicitud->getRutaFichaTecnica().' target="_blank" class="archivo_cargado">Archivo Cargado</a>') . '
                    </div>
                    <div data-linea="3">
                        <label>Permiso de importación de muestra: </label>' . ($solicitud->getRutaPermisoImportacionMuestra() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>':'<a href='.$solicitud->getRutaPermisoImportacionMuestra().' target="_blank" class="archivo_cargado">Archivo Cargado</a>') . '
                    </div>
                    <div data-linea="4">
                        <label>Protocolo: </label>' . ($solicitud->getRutaProtocolo() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>':'<a href='.$solicitud->getRutaProtocolo().' target="_blank" class="archivo_cargado">Archivo Cargado</a>') . '
                    </div>
                  </fieldset>';

        return $datos;

    }

    public function resultadoRevisionTecnica($solicitud, $datosEmpleado)
    {
        $datos = '<fieldset>
                    <legend>
                        Revisión técnica
                    </legend>
                    
                    <label>Técnico revisor </label>
                    
                    <div data-linea="1">
                        <label>Nombre: </label>' . $datosEmpleado->getNombre() . ' ' . $datosEmpleado->getApellido() . '
                    </div>
                    <div data-linea="2">
                        <label>Correo: </label>' . $datosEmpleado->getMailInstitucional() . '
                    </div>';

        if($solicitud->getResultadoRevisorTecnico()) {
            $datos .= '<label>Observaciones emitidas </label>
                        <div data-linea="3">
                            <label>Resultado: </label>' . $this->estado($solicitud->getResultadoRevisorTecnico()) . '
                        </div>
                        <div data-linea="4">
                            <label>Observacion: </label>' . $solicitud->getObservacionRevisorTecnico() . '
                        </div>
                        <div data-linea="5">
                            <label>Adjunto: </label>' . ($solicitud->getRutaRevisorTecnico() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $solicitud->getRutaRevisorTecnico() . ' target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>') . '
                        </div>';
        }

        $datos .='</fieldset>';

        return $datos;

    }

    public function resultadoRevisionResultado($solicitud, $datosEmpleado)
    {
        $datos = '<fieldset>
                    <legend>
                        Revisión de resultado de ensayo de eficacia
                    </legend>
                    
                     <label>Técnico revisor </label>
                    
                    <div data-linea="1">
                        <label>Nombre: </label>' . $datosEmpleado->getNombre() . ' ' . $datosEmpleado->getApellido() . '
                    </div>
                    <div data-linea="2">
                        <label>Correo: </label>' . $datosEmpleado->getMailInstitucional() . '
                    </div>';

        if($solicitud->getResultadoRevisorResultado()) {
            $datos .= '<label>Observaciones emitidas </label>
                    <div data-linea="3">
                        <label>Resultado: </label>' . $this->estado($solicitud->getResultadoRevisorResultado()) . '
                    </div>
                    <div data-linea="4">
                        <label>Observacion: </label>' . $solicitud->getObservacionRevisorResultado() . '
                    </div>
                    <div data-linea="5">
                        <label>Informe de resultado (1): </label>' . ($solicitud->getRutaInformeUno() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $solicitud->getRutaInformeUno() . ' target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>') . '
                    </div>
                    <div data-linea="6">
                        <label>Informe de resultado (2): </label>' . ($solicitud->getRutaInformeDos() == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>' : '<a href=' . $solicitud->getRutaInformeDos() . ' target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>') . '
                    </div>';
        }

        $datos .='</fieldset>';

        return $datos;

    }

    public function datosOrganismoInspeccion($organismo)
    {
        $datos = '<fieldset>
                    <legend>
                        Organismo de inspección
                    </legend>
                    
                    <div data-linea="1">
                        <label>Organismo: </label>' . $organismo->getRazonSocial() . '
                    </div>
                    </fieldset>';

        return $datos;

    }

    public function resultadoEnsayoEficacia($solicitud, $esOperador, $esOrganismo)
    {
        $datos = '<fieldset>
                    <legend>
                        Resultado del Ensayo de Eficacia
                    </legend>';

        if($esOperador){
            $datos .= '
                    <label>Operador: </label>
                    <div data-linea="1">
                        <label>Informe de resultado (1): </label>' . ($solicitud['ruta_informe_operador_uno'] == '0' || $solicitud['ruta_informe_operador_uno'] == null ? '<span class="alerta">No ha subido ningún archivo aún</span>':'<a href='.$solicitud['ruta_informe_operador_uno'].' target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>') . '
                    </div>
                    <div data-linea="2">
                        <label>Informe de resultado (2): </label>' . ($solicitud['ruta_informe_operador_dos'] == '0' || $solicitud['ruta_informe_operador_dos'] == null ? '<span class="alerta">No ha subido ningún archivo aún</span>':'<a href='.$solicitud['ruta_informe_operador_dos'].' target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>') . '
                    </div>';
        }

        if($esOrganismo){
            $datos .= '
                    <label>Organismo de inspección: </label>
                    <div data-linea="3">
                        <label>Informe de resultado (1): </label>' . ($solicitud['ruta_informe_organismo_uno'] == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>':'<a href='.$solicitud['ruta_informe_organismo_uno'].' target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>') . '
                    </div>
                    <div data-linea="4">
                        <label>Informe de resultado (2): </label>' . ($solicitud['ruta_informe_organismo_dos'] == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>':'<a href='.$solicitud['ruta_informe_organismo_dos'].' target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>') . '
                    </div>';
        }

        $datos .= '</fieldset>';

        return $datos;

    }

    public function datosFinancieroEnsayoEficacia($datosFinanciero)
    {
        $datos = '<fieldset>
                    <legend>Información de pago</legend>
                        <div data-linea="1">
						<label>Monto a pagar:</label> <span class="alerta">$ '.$datosFinanciero['total_pagar'].'</span>
                        </br><a href="'.$datosFinanciero['orden_pago'].'" target="_blank" class="archivo_cargado" id="archivo_cargado">Descargar orden de pago: </a>
					</div>
                </fieldset>';

        return $datos;
    }

    public function datosAdicionalesEnsayoEficacia($solicitud)
    {
        $datos = '<fieldset id="datosAdicionales">
                    <legend>Datos adicionales:</legend>
                    <div data-linea="1">
                        <label>Observación: </label>' . ($solicitud->Observacion ? $solicitud->Observacion:'N/A') . '
                    </div>
                    <div data-linea="2">
                        <label>Solicitud pertenece a cultivo menor: </label>' . ($solicitud->CultivoMenor ? 'Si':'No') . '
                    </div>
                </fieldset>';

        return $datos;
    }

    public function cargarPanelBusquedaSolicitud()
    {
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
	                            						<td >Número solicitud: </td>
	                            						<td colspan="3">
                                                            <input id="numeroSolicitud" type="text" name="numeroSolicitud" value="" >
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
