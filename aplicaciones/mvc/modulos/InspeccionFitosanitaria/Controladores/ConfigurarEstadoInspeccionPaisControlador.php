<?php
/**
 * Controlador ConfigurarEstadoInspeccionPais
 *
 * Este archivo controla la lógica del negocio del modelo:  ConfigurarEstadoInspeccionPaisModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-07-21
 * @uses    ConfigurarEstadoInspeccionPaisControlador
 * @package InspeccionFitosanitaria
 * @subpackage Controladores
 */
namespace Agrodb\InspeccionFitosanitaria\Controladores;

use Agrodb\InspeccionFitosanitaria\Modelos\ConfigurarEstadoInspeccionPaisLogicaNegocio;
use Agrodb\InspeccionFitosanitaria\Modelos\ConfigurarEstadoInspeccionPaisModelo;
use Agrodb\Catalogos\Modelos\LocalizacionLogicaNegocio;

class ConfigurarEstadoInspeccionPaisControlador extends BaseControlador
{

    private $lNegocioConfigurarEstadoInspeccionPais = null;

    private $modeloConfigurarEstadoInspeccionPais = null;
    
    private $lNegocioLocalizacion = null;

    private $accion = null;
    
    private $datosRegistro = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioConfigurarEstadoInspeccionPais = new ConfigurarEstadoInspeccionPaisLogicaNegocio();
        $this->modeloConfigurarEstadoInspeccionPais = new ConfigurarEstadoInspeccionPaisModelo();
        $this->lNegocioLocalizacion = new LocalizacionLogicaNegocio();
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
        $modeloConfigurarEstadoInspeccionPais = $this->lNegocioConfigurarEstadoInspeccionPais->buscarConfigurarEstadoInspeccionPais();
        $this->tablaHtmlConfigurarEstadoInspeccionPais($modeloConfigurarEstadoInspeccionPais);
        require APP . 'InspeccionFitosanitaria/vistas/listaConfigurarEstadoInspeccionPaisVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nuevo registro";
        $accion = 'nuevo';
        $this->datosRegistro = $this->construirDatosRegistro($accion);
        
        require APP . 'InspeccionFitosanitaria/vistas/formularioConfigurarEstadoInspeccionPaisVista.php';
    }

    /**
     * Método para registrar en la base de datos -ConfigurarEstadoInspeccionPais
     */
    public function guardar()
    {
        
        $estado = 'exito';
        $mensaje = '';
        
        if(isset($_POST['id_estado_inspeccion_pais'])){
            
            $idEstadoInspeccionPais = $this->lNegocioConfigurarEstadoInspeccionPais->guardar($_POST);
            
            echo json_encode(array(
                "estado" => $estado,
                "mensaje" => $mensaje,
                "contenido" => $idEstadoInspeccionPais));
            
        }else{
            
            $idLocalizacion = $_POST['id_pais'];
            $_POST['permitir_uso_enviada'] = (isset($_POST['permitir_uso_enviada']) ? $_POST['permitir_uso_enviada'] : 'Si');
            
            $qDatosLocalizacion = $this->lNegocioLocalizacion->buscar($idLocalizacion);
            $nombrePais = $qDatosLocalizacion->getNombre();
            $_POST['nombre_pais'] = $nombrePais;
            
            $busqueda = ['tipo_certificado' => $_POST['tipo_certificado']
                            , 'id_pais' => $_POST['id_pais']
                        ];
            
            $verificarConfiguracion = $this->lNegocioConfigurarEstadoInspeccionPais->buscarLista($busqueda);
            
            if($verificarConfiguracion->count()){
                
                $nombrePais = $verificarConfiguracion->current()->nombre_pais;
                $tipoCertificado = $this->equivalenciaTipoSolicitud($verificarConfiguracion->current()->tipo_certificado);
                
                $estado = 'fallo';
                $mensaje = 'Ya existe un registro para el tipo de certificado: ' . $tipoCertificado . ', país: ' . $nombrePais . ' ya fue registrada.';              
                
            }else{
                
                $this->lNegocioConfigurarEstadoInspeccionPais->guardar($_POST);
                
            }
            
            echo json_encode(array(
                "estado" => $estado,
                "mensaje" => $mensaje));
            
        }
       
    }

    /**
     * Obtenemos los datos del registro seleccionado para editar - Tabla: ConfigurarEstadoInspeccionPais
     */
    public function editar()
    {
        $this->accion = "Editar registro";
        $accion = 'editar';
        $this->modeloConfigurarEstadoInspeccionPais = $this->lNegocioConfigurarEstadoInspeccionPais->buscar($_POST["id"]);
        $this->datosRegistro = $this->construirDatosRegistro($accion);
        require APP . 'InspeccionFitosanitaria/vistas/formularioConfigurarEstadoInspeccionPaisVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - ConfigurarEstadoInspeccionPais
     */
    public function borrar()
    {
        $this->lNegocioConfigurarEstadoInspeccionPais->borrar($_POST['elementos']);
    }

    /**
     * Construye el código HTML para desplegar la lista de - ConfigurarEstadoInspeccionPais
     */
    public function tablaHtmlConfigurarEstadoInspeccionPais($tabla)
    {
        {
            $contador = 0;
            foreach ($tabla as $fila) {
                $this->itemsFiltrados[] = array(
                    '<tr id="' . $fila['id_estado_inspeccion_pais'] . '"
                    		  class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'InspeccionFitosanitaria\ConfigurarEstadoInspeccionPais"
                    		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
                    		  data-destino="detalleItem">
                    		  <td>' . ++ $contador . '</td>
                    <td>' . $this->equivalenciaTipoSolicitud($fila['tipo_certificado']) . '</td>
                    <td>' . $fila['nombre_pais'] . '</td>
                    <td style="text-align: center;">' . $fila['dias_vigencia'] . '</td>
                    <td style="text-align: center;">' . $fila['permitir_uso_enviada'] . '</td>
                    </tr>');
		}
		}
	}
	
	/**
	 * Método para construir los datos generales de la condiguracion de estado - pais
	 */
	public function construirDatosRegistro($accion){
	 	        
	    $datos = '';
	    
	    switch ($accion){
	      
	        case 'nuevo':
	            
	            $datos = '<div data-linea="1">
            			<label for="tipo_certificado">Tipo de certificado: </label>
                        <select id="tipo_certificado" name="tipo_certificado" class="validacion">
    						<option value="">Seleccione....</option>
    						<option value="musaceas">Musáceas</option>
	                        <!-- option value="ornamentales">Ornamentales</option -->
                            <option value="otros">Otros</option>
    				    </select>
            		</div>
	                
            		<div data-linea="2">
            			<label for="id_pais">País: </label>
                        <select id="id_pais" name="id_pais" class="validacion">
                            <option value="">Seleccione...</option>'
	                        . $this->comboPaises() .
	                '</select>
            		</div>
	                    
            		<div data-linea="3">
            			<label for="dias_vigencia">Días de vigencia de inspección: </label>
            			<input type="number" id="dias_vigencia" name="dias_vigencia" value="" min="1"
            			placeholder="Ejm:1" maxlength="8" class="validacion" />
            		</div>';
	                        
	        break;
	        
	        case 'editar':
	            
	            $datos = '<div data-linea="1">
            			<label for="tipo_certificado">Tipo de certificado: </label>'
                            . $this->equivalenciaTipoSolicitud($this->modeloConfigurarEstadoInspeccionPais->getTipoCertificado()) .
    				    '</div>
	                
            		<div data-linea="2">
            			<label for="id_pais">País: </label>'
                        . $this->modeloConfigurarEstadoInspeccionPais->getNombrePais() .
	                '</div>
	                    
            		<div data-linea="3">
            			<label for="dias_vigencia">Días de vigencia de inspección: </label>
            			<input type="number" id="dias_vigencia" name="dias_vigencia" value="' . $this->modeloConfigurarEstadoInspeccionPais->getDiasVigencia() . '" min="1"
            			placeholder="Ejm:1" maxlength="8" class="validacion" />
            		</div>
	                    
            		<div data-linea="4">
            			<label for="permitir_uso_enviada">Permitir uso de inspección en estado "Enviado": </label>
                        <select id="permitir_uso_enviada" name="permitir_uso_enviada" class="validacion">
            			<option value="">Seleccione...</option>'
	                    . $this->comboSiNo($this->modeloConfigurarEstadoInspeccionPais->getPermitirUsoEnviada()) .
	                    '</select>
            		</div>
                    <input type="hidden" id="id_estado_inspeccion_pais" name="id_estado_inspeccion_pais" value="' . $this->modeloConfigurarEstadoInspeccionPais->getIdEstadoInspeccionPais() . '" readonly="readonly" />';
	                    
	        break;
	        
	    }	       
	
	   return '<fieldset>
                   <legend>Datos de registro</legend>'
	               . $datos . 
	           '</fieldset>
        		<div data-linea="5">
        			<button type="submit" class="guardar">Guardar</button>
        		</div>';
	    
	}
	
	function equivalenciaTipoSolicitud($tipoCertificado){
	    
	    $tipo = "";
	    
	    switch($tipoCertificado){
	        
	        case 'musaceas':
	            $tipo = 'Musáceas';
	            break;
	        case 'ornamentales':
	            $tipo = 'Ornamentales';
	            break;
	        case 'otros':
	            $tipo = 'Otros';
	            break;
	            
	    }
	    
	    return $tipo;
	    
	}

}
