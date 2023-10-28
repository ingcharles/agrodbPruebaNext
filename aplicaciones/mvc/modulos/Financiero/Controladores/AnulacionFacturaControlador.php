<?php
/**
 * Controlador AnulacionFactura
 *
 * Este archivo controla la lógica del negocio del modelo:  AnulacionFacturaModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-07-21
 * @uses    AnulacionFacturaControlador
 * @package Financiero
 * @subpackage Controladores
 */
namespace Agrodb\Financiero\Controladores;

use Agrodb\Financiero\Modelos\AnulacionFacturaLogicaNegocio;
use Agrodb\Financiero\Modelos\AnulacionFacturaModelo;
use Agrodb\Financiero\Modelos\OrdenPagoLogicaNegocio;
use Agrodb\Core\Mensajes;

class AnulacionFacturaControlador extends BaseControlador
{

    private $lNegocioAnulacionFactura = null;

    private $modeloAnulacionFactura = null;
    
    private $lNegocioOrdenPago = null;

    private $accion = null;
    
    private $datosAnulacionFactura = null;
    
    private $panelAnulacionFactura = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioAnulacionFactura = new AnulacionFacturaLogicaNegocio();
        $this->modeloAnulacionFactura = new AnulacionFacturaModelo();
        $this->lNegocioOrdenPago = new OrdenPagoLogicaNegocio();
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
        
        $fechaActual = date('Y-m-d');
 
        $arrayParametros = ['ruc' => null
                            , 'numero_establecimiento'=> null
                            , 'numero_factura' => null
                            , 'fecha_inicio' => $fechaActual
                            , 'fecha_fin' => $fechaActual];
        
        $this->panelAnulacionFactura = $this->cargarPanelAnulacionFactura();
        $modeloAnulacionFactura = $this->lNegocioAnulacionFactura->buscarFiltroAnulacionFactura($arrayParametros);
        $this->tablaHtmlAnulacionFactura($modeloAnulacionFactura);
        require APP . 'Financiero/vistas/listaAnulacionFacturaVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nuevo anulación factura";
        $estado = 'Nuevo';
        
        $this->datosAnulacionFactura = $this->construirDatosAnulacionFactura($estado);
        require APP . 'Financiero/vistas/formularioAnulacionFacturaVista.php';
    }

    /**
     * Método para registrar en la base de datos -AnulacionFactura
     */
    public function guardar()
    {

        $ruc = $_POST['ruc'];
        $numero_establecimiento = $_POST['numero_establecimiento'];
        $numero_factura = $_POST['numero_factura'];
        $numero_glpi = $_POST['numero_glpi'];
        $motivo_anulacion = $_POST['motivo_anulacion'];
        
        $arrayDatosOrdenPago = ['ruc_institucion' => $ruc
            , 'numero_establecimiento' => $numero_establecimiento
            , 'numero_factura' => $numero_factura
            , 'numero_glpi' => $numero_glpi
            , 'motivo_anulacion' => $motivo_anulacion
            , 'identificador_usuario' => $_SESSION['usuario']
        ];

        $resultado = $this->lNegocioAnulacionFactura->enviarSolicitud($arrayDatosOrdenPago);

               
        if($resultado['resultado'] == 'Error'){
            Mensajes::fallo($resultado['mensaje']);
        }else{
            Mensajes::exito($resultado['mensaje']);
        }
        
    }

    /**
     * Obtenemos los datos del registro seleccionado para editar - Tabla: AnulacionFactura
     */
    public function editar()
    {
        $this->accion = "Registro de anulación de factura";
        $this->modeloAnulacionFactura = $this->lNegocioAnulacionFactura->buscar($_POST["id"]);
        $estado = 'Abrir';
        
        $this->datosAnulacionFactura = $this->construirDatosAnulacionFactura($estado);
        
        require APP . 'Financiero/vistas/formularioAnulacionFacturaVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - AnulacionFactura
     */
    public function borrar()
    {
        $this->lNegocioAnulacionFactura->borrar($_POST['elementos']);
    }

    /**
     * Construye el código HTML para desplegar la lista de - AnulacionFactura
     */
    public function tablaHtmlAnulacionFactura($tabla)
    {
        {
            $contador = 0;
            foreach ($tabla as $fila) {
                $this->itemsFiltrados[] = array(
                    '<tr id="' . $fila['id_anulacion_factura'] . '"
		  class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'Financiero\AnulacionFactura"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++ $contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['numero_factura'] . '</b></td>
            <td>' . $fila['numero_glpi'] . '</td>
            <td>' . $fila['fecha_anulacion_factura'] . '</td>
            </tr>');
		}
		}
	}
	
	/**
	 * Método para desplegar numeros de establecimiento
	 */
	public function obtenerNumeroEstablecimientoPorRuc(){
	    $ruc = $_POST['ruc'];
	    echo '<option value="">Seleccione...</option>' . $this->comboNumeroEstablecimientoPorRuc($ruc);
	}
	
	
	/**
	 * Método para desplegar la informacion de registro y visualizacion
	 */
	public function construirDatosAnulacionFactura($estado){
	    
	    $datos = "";
	    
	    switch ($estado) {
	        case 'Nuevo':
	            $datos .= '<fieldset>
            		<legend>Datos de la factura</legend>
	                
            		<div data-linea="1">
            			<label for="ruc">Ruc: </label>
            			<select id="ruc" name="ruc" class="validacion">
            				<option value="">Seleccione...</option>'
	                . $this->comboRucInstitucion() .
	                '</select>
            		</div>
	                    
            		<div data-linea="2">
            			<label for="numero_establecimiento">Número de establecimiento: </label>
            			<select id="numero_establecimiento" name="numero_establecimiento" class="validacion">
            				<option value="">Seleccione...</option>
            			</select>
            		</div>
	                    
            		<div data-linea="3">
            			<label for="numero_factura">Número de factura: </label>
            			<input type="text" id="numero_factura" name="numero_factura" value="" placeholder="Ejm: 000024563" class="validacion" maxlength="9" oninput="validarEnteros(this)"/>
            		</div>
	                    
            		<div data-linea="4">
            			<label for="numero_glpi">Número de GLPI: </label>
            			<input type="text" id="numero_glpi" name="numero_glpi" value="" placeholder="Ejm: 23456" class="validacion" maxlength="8" />
            		</div>
	                    
            		<div data-linea="5">
            			<label for="motivo_anulacion">Motivo de la anulación: </label>
            			<input type="text" id="motivo_anulacion" name="motivo_anulacion" value="" placeholder="Ejm: Solicitud por correo electrónico" class="validacion" maxlength="510" />
            		</div>
            	</fieldset>
            	<div data-linea="6">
            		<button type="submit" class="guardar">Guardar</button>
            	</div>';
	        break;
	        
	        case 'Abrir':
	            
	            $idAnulacionFactura = $this->modeloAnulacionFactura->getIdAnulacionFactura();

	            $qDatosFactura = $this->lNegocioAnulacionFactura->buscarAnulacionFacturaPorIdAnulacionFactura($idAnulacionFactura);
	            $rucInstitucion = $qDatosFactura->current()->ruc_institucion;
	            $numeroFactura = $qDatosFactura->current()->numero_factura;
	            $numeroGlpi = $qDatosFactura->current()->numero_glpi;
	            $motivoAnulacion = $qDatosFactura->current()->motivo_anulacion;
	            $totalFactuta = $qDatosFactura->current()->total_pagar;
	            
	            $datos .= '<fieldset>
            		<legend>Datos de la factura</legend>
	                
            		<div data-linea="1">
            			<label for="ruc">Ruc: </label>'
	                   . $rucInstitucion .
            		'</div>
	                    
            		<div data-linea="2">
            			<label for="numero_establecimiento">Número de factura: </label>'
                        . $numeroFactura .
            		'</div>
	                    
            		<div data-linea="3">
            			<label for="numero_glpi">Número de GLPI: </label>'
            			. $numeroGlpi .
            		'</div>
	                    
            		<div data-linea="4">
            			<label for="motivo_anulacion">Motivo de la anulación: </label>'
            		    . $motivoAnulacion .
            		'</div>

                    <div data-linea="5">
            			<label for="total_pagar">Total de la factura: </label>
            		    $ ' . $totalFactuta .
            		'</div>

            	</fieldset>';
	        break;
	    }
	    
	    return $datos;
	    
	}
	
	/**
	 * Construye el código HTML para desplegar panel de busqueda para facturas anuladas
	 */
	public function cargarPanelAnulacionFactura()
	{
	    
	    $datos = '<table id="busquedaFactura" class="filtro" style="width: 100%; text-align:left;">
	        
                                                <tbody>
                                                    <tr>
                                                        <th colspan="4">Consulta de facturas anuladas:</th>
                                                    </tr>
	        
                                					<tr>
                                						<td>Ruc: </td>
                                						<td colspan="3">
                                							<select id="bRuc" name="bRuc" class="validacion" style="width: 100%;" class="validacion">
                                                    				<option value="">Seleccione...</option>'
                                        	                . $this->comboRucInstitucion() .
                                        	                '</select>
                                                        </td>                                					
                                					</tr>
                                                    <tr>
                                						<td>N° establecimiento: </td>
                                						<td>
                                							<select id="bNumeroEstablecimiento" name="bNumeroEstablecimiento" class="validacion">
                                                			     <option value="">Seleccionar....</option>
                                						        </select>
                                                        </td>
                                						<td>N° factura: </td>
                                						<td>
                                							<input type="text" id="bNumeroFactura" name="bNumeroFactura" class="validacion">
                                                        </td>
                                					</tr>
                                                    <tr>
                                						<td >F. Inicio: </td>
                                						<td>
                                							<input id="bFechaInicio" type="text" name="bFechaInicio" value="" style="width: 100%" maxlength="128" readonly="readonly" class="validacion">
                                						</td>
                                                        <td >F. Fin: </td>
                                						<td>
                                							<input id="bFechaFin" type="text" name="bFechaFin" value="" style="width: 100%" maxlength="128" readonly="readonly" class="validacion">
                                						</td>
                                					</tr>
                                					<tr>
                                						<td colspan="4" style="text-align: end;">
                                							<button id="btnFiltrar">Consultar</button>
                                						</td>
                                					</tr>
                                				</tbody>
                                			</table>';
                                                			     
        return $datos;
	}
	
	/**
	 * Método para listar las facturas
	 * anuladas
	 */
	public function listarFacturasAnuladas()
	{
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    $ruc = $_POST["bRuc"];
	    $numeroEstablecimiento = $_POST["bNumeroEstablecimiento"];
	    $numeroFactura = $_POST["bNumeroFactura"];
	    $fechaInicio = $_POST["bFechaInicio"];
	    $fechaFin = $_POST["bFechaFin"];
	    	    
	    $arrayParametros = ['ruc' => $ruc
                	        , 'numero_establecimiento'=> $numeroEstablecimiento
                	        , 'numero_factura' => $numeroFactura
                	        , 'fecha_inicio' => $fechaInicio
                	        , 'fecha_fin' => $fechaFin];
	    
	    $facturasAnuladas = $this->lNegocioAnulacionFactura->buscarFiltroAnulacionFactura($arrayParametros);
	    
	    $this->tablaHtmlAnulacionFactura($facturasAnuladas);
	    $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	

}
