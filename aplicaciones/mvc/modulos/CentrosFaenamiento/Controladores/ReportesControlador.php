<?php
/**
 * Controlador Productos
 *
 * Este archivo controla la lógica del negocio del modelo:  ProductosModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2020-09-18
 * @uses    ProductosControlador
 * @package EmisionCertificacionOrigen
 * @subpackage Controladores
 */
namespace Agrodb\CentrosFaenamiento\Controladores;
// use Agrodb\EmisionCertificacionOrigen\Modelos\RegistroProduccionLogicaNegocio;


class ReportesControlador extends BaseControlador 
{

	// use Agrodb\Core\Constantes;
	// use Agrodb\Core\Mensajes;
	// private $lNegocioRegistroProduccion = null;


    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

	
		// $this->modeloRegistroProduccion = new RegistroProduccionModelo();
		

	
       
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
       
		$this->cargarPanelAdministracion();
		require APP . 'CentrosFaenamiento/vistas/listaReporteVista.php';
      
       
    }
	
	/**
	*Obtenemos los datos del registro seleccionado para editar - Tabla: RegistroProduccion
	*/
	public function editar(){
			
			
	}

	

        /**
     * Construye el código HTML para desplegar panel de busqueda para los reportes
     */

	public function cargarPanelAdministracion()
	{
	
		$this->panelBusquedaAdministrador = '<form id="filtrarReporte" action="aplicaciones/mvc/CentrosFaenamiento/CentrosFaenamiento/exportarCentrosFaenamientoExcel" target="_blank" method="post">

		<table class="filtro" style="width: 100%;">
			<tbody>
				
				<tr  style="width: 100%;">
					<td ><label>*Fecha Inicio: </label> </td>
					<td>
						<input id="fechaInicio" type="text" name="fecha_inicio" required="required" readonly="readonly">
					</td>
							
					<td ><label>*Fecha Fin: </label></td>
					<td>
						<input id="fechaFin" type="text" name="fecha_fin" required="required" readonly="readonly">
					</td>
				</tr>
				<tr>
					<td colspan="2"><label>RUC: </label></td>
					<td colspan="2">
						<input id="idRuc" name="ruc" style="width: 100%;" >
						
					</td>
				</tr>
				<tr>
				<td colspan="2"><label>Provincia: </label></td>
					<td colspan="2">
						<select id="idProvinciaFiltro" name="id_provinciaFiltro" style="width: 100%;">
							<option value="">Seleccione....</option>'.
								$this->comboProvinciasEc().
							'</select>
						<input id="nombreProvincia" type="hidden" name="nombreProvincia" >
					</td>
				</tr>
				<td colspan="2"><label>Estado: </label></td>
					<td colspan="2">
					<select id="idEstado" name="estado" style="width: 100%;">
					<option value="">Seleccion....</option>
					<option value="Habilitado">Habilitado</option>
					
					<option value="Activo">Activo</option>
					<option value="Clausurado temporalmente">Clausurado Temporalmente</option>
					<option value="Clausurado definitivamente">Clausurado Definitivamente</option>
					<option value="Cerrado Temporalmente">Cerrado Temporalmente</option>
					<option value="Cerrado Definitivamente">Cerrado Temporalmente</option>
				</select>
					</td>
				</tr>
				<tr>
					<td class="col-sm-6">
						Los campos con * son obligatorios.
					</td> 
					<td class="col-sm-6">
						<td colspan="6" > <button type="submit" id="idReporte">Generar Reporte</button></td>
					</td> 
				</tr>
			</tbody>
		</table>
		</form>';
	}
		
}