<?php
/**
 * Controlador Reportes Módulo CUVs
 *
 * Este archivo controla la lógica del negocio del modelo:  VentanillasModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2023-09-06
 * @uses    SolicitudRedistribucionCuvControlador
 * @package AsignacionCuv
 * @subpackage Controladores
 */

namespace Agrodb\AsignacionCuv\Controladores;
use Agrodb\AsignacionCuv\Modelos\DistribucionInicialCuvLogicaNegocio;
use Agrodb\AsignacionCuv\Modelos\DistribucionInicialCuvModelo;
use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;

class ReportesControlador extends BaseControlador
{

    private $lNegocioDistribucionInicialCuv = null;
    private $modeloDistribucionInicialCuv = null;
    private $accion = null;
    
    private $formulario = null;
    private $valor = null;


    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->modeloDistribucionInicialCuv = new DistribucionInicialCuvModelo();
        $this->lNegocioDistribucionInicialCuv = new DistribucionInicialCuvLogicaNegocio();
        
        set_exception_handler(array(
            $this,
            'manejadorExcepciones'
        ));
    }

    /**
     * Método de inicio del controlador
     */
    public function index()
    {
        require APP . 'AsignacionCuv/vistas/listaOpcionesReportesCuvs.php';
    }
    
    /**
     * Método de inicio del controlador
     */
    public function reporteCuvsProvincia()
    {
        $this->cargarPanelReportes();
        require APP . 'AsignacionCuv/vistas/listaReporteProvinciaCuvs.php';
    }


        /**
     * Método de inicio del controlador
     */
    public function reporteOperadorCuvs()
    {
        $this->cargarPanelReportesOperador();
        require APP . 'AsignacionCuv/vistas/listaReporteOperadorCuvs.php';
    }


    public function cargarPanelReportes()
    {
        $this->panelBusquedaAdministrador = '<form id="filtrar" action="aplicaciones/mvc/AsignacionCuv/Reportes/exportarReporteSolicitudSecuenciaRevisionExcel" target="_blank" method="post">
        <table class="filtro" style="width: 100%; text-align:left;">
        <tbody>
            <tr>
                <th colspan="4">Reporte de los CUV</th>
            </tr>
            <tr>
                <td>Fecha inicio:</td>
                <td colspan="2"><input type="text" id="fechaInicio" name="fechaInicio"></td>                                           
                <td>Fecha fin:</td>
                <td colspan="2"><input type="text" id="fechaFin" name="fechaFin"></td>                                           
            </tr>
            <tr>
                <td>Año:</td>
                <td colspan="4">
                <select id="anioFiltro" name= "anioFiltro" style="width: 100%;>
                    ' . $this->comboAnios() . '
                </select>              
            </tr>
            <tr>
                <td>Provincia:</td>
                <td colspan="4">
                    <select id="provincia" name="provincia" style="width: 100%;">
                        <option value="">Seleccione...</option>
                        ' . $this->comboProvinciasEc() . '
                    </select>
                </td>                                     
            </tr>
            <tr>
            <td colspan="6" style="text-align: end;">
                <button type="submit">Generar Reporte</button>
            </td>
        </tr>
        </tbody>
    </table>
    </form>';
                                                                        
    }
    

    public function cargarPanelReportesOperador()
    {
        $this->panelBusquedaCuvOperador= '<form id="filtrar" action="aplicaciones/mvc/AsignacionCuv/Reportes/exportarReporteOperadoresExcel" target="_blank" method="post">
        <table class="filtro" style="width: 100%; text-align:left;">
        <tbody>
            <tr>
                <th colspan="4">Reporte de los CUV</th>
            </tr>
            <tr>
                <td>Fecha inicio:</td>
                <td colspan="2"><input type="text" id="fechaInicio" name="fechaInicio"></td>                                           
                <td>Fecha fin:</td>
                <td colspan="2"><input type="text" id="fechaFin" name="fechaFin"></td>                                           
            </tr>
            <tr>
                <td>Año:</td>
                <td colspan="4">
                <select id="anioFiltro" name= "anioFiltro" style="width: 100%;>
                    ' . $this->comboAnios() . '
                </select>
            </tr>
            <tr>
                <td>Provincia:</td>
                <td colspan="4">
                    <select id="operador" name="operador" style="width: 100%;">
                        <option value="">Seleccione...</option>
                        ' . $this->comboOperadorTPCyOI() . '
                    </select>
                </td>                                     
            </tr>
            <tr>
            <td colspan="6" style="text-align: end;">
                <button type="submit">Generar Reporte</button>
            </td>
        </tr>
        </tbody>
    </table>
    </form>';
                                                                        
    }

    public function exportarReporteSolicitudSecuenciaRevisionExcel() {
        $fechaInicio = $_POST["fechaInicio"];
        $anio = $_POST["anioFiltro"];
        $fechaFin = $_POST["fechaFin"];
        $provincia = $_POST["provincia"];        
        $arrayParametros = array(
            'fechaInicio' => $fechaInicio,            
            'fechaFin' => $fechaFin,
            'provincia' => $provincia,
            'anio' => $anio
        );
        
        $valor = $this->lNegocioDistribucionInicialCuv->buscarCuvXProvinciasEntreFechas($arrayParametros);
        
        $this->lNegocioDistribucionInicialCuv->exportarArchivoExcelCuvs($valor);
    }
    public function exportarReporteOperadoresExcel() {
        $fechaInicio = $_POST["fechaInicio"];
        $anio = $_POST["anioFiltro"];
        $fechaFin = $_POST["fechaFin"];
        $operador = $_POST["operador"];        
        $arrayParametros = array(
            'fechaInicio' => $fechaInicio,            
            'fechaFin' => $fechaFin,
            'operador' => $operador,
            'anio' => $anio
        );
        
        $valor = $this->lNegocioDistribucionInicialCuv->buscarOperadoresEntreFechas($arrayParametros);
        
        $this->lNegocioDistribucionInicialCuv->exportarArchivoExcelProveedorCuvs($valor);
    }
    /**
     * Combo de estados para trámites
     *
     * @param
     *            $respuesta
     * @return string
     */
    public function comboOperadorTPCyOI($opcion = null)
    {
        $combo = "";
        
        if ($opcion == "Operador Industrial") {
        	$combo .= '<option value="Todos">Todos</option>';
            $combo .= '<option value="Operador Industrial" selected="selected">Operador Industrial</option>';
            $combo .= '<option value="Operador Traspatio-Comercial">Operador Traspatio-Comercial</option>';
        } else if ($opcion == "Operador Traspatio-Comercial") {
        	$combo .= '<option value="Todos">Todos</option>';
            $combo .= '<option value="Operador Traspatio-Comercial" selected="selected">Operador Traspatio-Comercial</option>';
            $combo .= '<option value="Operador Industrial">Operador Industrial</option>';
        } else {
        	$combo .= '<option value="Todos" selected="selected">Todos</option>';
            $combo .= '<option value="Operador Traspatio-Comercial" >Operador Traspatio-Comercial</option>';
            $combo .= '<option value="Operador Industrial">Operador Industrial</option>';
        }        
        return $combo;
    }
    
}