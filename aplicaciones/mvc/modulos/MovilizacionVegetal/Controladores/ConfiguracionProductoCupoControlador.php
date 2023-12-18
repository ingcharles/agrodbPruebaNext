<?php
/**
 * Controlador ConfiguracionProductoCupo
 *
 * Este archivo controla la lógica del negocio del modelo:  ConfiguracionProductoCupoModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2023-12-07
 * @uses    ConfiguracionProductoCupoControlador
 * @package MovilizacionVegetal
 * @subpackage Controladores
 */
namespace Agrodb\MovilizacionVegetal\Controladores;

use Agrodb\MovilizacionVegetal\Modelos\ConfiguracionProductoCupoLogicaNegocio;
use Agrodb\MovilizacionVegetal\Modelos\ConfiguracionProductoCupoModelo;
use Agrodb\Catalogos\Modelos\TipoProductosLogicaNegocio;
use Agrodb\Catalogos\Modelos\SubtipoProductosLogicaNegocio;
use Agrodb\Catalogos\Modelos\ProductosLogicaNegocio;
use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;

class ConfiguracionProductoCupoControlador extends BaseControlador
{

    private $lNegocioConfiguracionProductoCupo = null;

    private $modeloConfiguracionProductoCupo = null;
    
    private $lNegocioTipoProductos = null;
    
    private $lNegocioSubtipoProductos = null;
    
    private $lNegocioProductos = null;

    private $accion = null;

    private $datosGenerales = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioConfiguracionProductoCupo = new ConfiguracionProductoCupoLogicaNegocio();
        $this->modeloConfiguracionProductoCupo = new ConfiguracionProductoCupoModelo();
        $this->lNegocioTipoProductos = new TipoProductosLogicaNegocio();
        $this->lNegocioSubtipoProductos = new SubtipoProductosLogicaNegocio();
        $this->lNegocioProductos = new ProductosLogicaNegocio();
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
        $modeloConfiguracionProductoCupo = $this->lNegocioConfiguracionProductoCupo->buscarConfiguracionProductoCupo();
        $this->tablaHtmlConfiguracionProductoCupo($modeloConfiguracionProductoCupo);
        require APP . 'MovilizacionVegetal/vistas/listaConfiguracionProductoCupoVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nuevo configuración producto/cupo";
        $estadoProductoCupo = 'Nuevo';
        $this->datosGenerales = $this->construirDatosGenerales($estadoProductoCupo);
        require APP . 'MovilizacionVegetal/vistas/formularioConfiguracionProductoCupoVista.php';
    }

    /**
     * Método para registrar en la base de datos -ConfiguracionProductoCupo
     */
    public function guardar()
    {
        
        $idProducto = $_POST['id_producto'];
        $qValidarProducto = $this->lNegocioConfiguracionProductoCupo->buscarLista(array('id_producto' => $idProducto));
        
        if(!$qValidarProducto->count()){
            $_POST['identificador_responsable'] = $this->identificador;
            $resultado = $this->lNegocioConfiguracionProductoCupo->guardar($_POST);
            
            if($resultado){
                Mensajes::exito(Constantes::GUARDADO_CON_EXITO);
            }else{
                Mensajes::fallo("Ocurrio un error al guardar la información.");
            }
        
        }else{
            Mensajes::fallo("La configuración con el producto seleccionado ya se encuentra registrada.");
        }        
        
    }

    /**
     * Obtenemos los datos del registro seleccionado para editar - Tabla: ConfiguracionProductoCupo
     */
    public function editar()
    {
        $this->accion = "Abrir configuracion producto/cupo";
        $this->modeloConfiguracionProductoCupo = $this->lNegocioConfiguracionProductoCupo->buscar($_POST["id"]);
        $estadoProductoCupo = 'Editar';
        $this->datosGenerales = $this->construirDatosGenerales($estadoProductoCupo, $this->modeloConfiguracionProductoCupo);
        require APP . 'MovilizacionVegetal/vistas/formularioConfiguracionProductoCupoVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - ConfiguracionProductoCupo
     */
    public function borrar()
    {
        $this->lNegocioConfiguracionProductoCupo->borrar($_POST['elementos']);
    }

    /**
     * Construye el código HTML para desplegar la lista de - ConfiguracionProductoCupo
     */
    public function tablaHtmlConfiguracionProductoCupo($tabla)
    {
        {
            $contador = 0;
            foreach ($tabla as $fila) {
                $this->itemsFiltrados[] = array(
                    '<tr id="' . $fila['id_configuracion_producto_cupo'] . '"
		  class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'MovilizacionVegetal/ConfiguracionProductoCupo"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td><b>' . ++ $contador . '</b></td>
		  <td>' . $fila['nombre_tipo_producto'] . '</td>
<td>' . $fila['nombre_subtipo_producto'] . '</td>
<td>' . $fila['nombre_producto'] . '</td>
<td>' . $fila['estado_configuracion_producto_cupo'] . '</td>
<td>' . date('Y-m-d', strtotime($fila['fecha_creacion'])) . '</td>
</tr>'
                );
            }
        }
    }

    public function construirDatosGenerales($estadoProductoCupo, $modeloProductoCupo = null)
    {
        $datos = "";
        
        switch ($estadoProductoCupo){
            
            case 'Nuevo';
                $datos = '<form id="formulario" data-rutaAplicacion="'. URL_MVC_FOLDER . 'MovilizacionVegetal" data-opcion="ConfiguracionProductoCupo/guardar" data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
                    	<fieldset>
                    		<legend>Configuración producto/cupo</legend>
                    		<div data-linea="1">
                    			<label for="id_tipo_producto">Tipo de producto: </label>
                                <select id="id_tipo_producto" name="id_tipo_producto" class="validacion">
                                    <option value="">Seleccione...</option>'
                                    . $this->obtenerTipoProducto('SV') .
                                '</select>
                    			</div>
                        
                    		<div data-linea="2">
                    			<label for="id_subtipo_producto">Subtipo de producto: </label>
                                    <select id="id_subtipo_producto" name="id_subtipo_producto" class="validacion">
                                        <option value="">Seleccione...</option>
                                    </select>
                    			</div>
                        
                    		<div data-linea="3">
                    			<label for="id_producto">Producto: </label>
                    			<select id="id_producto" name="id_producto" class="validacion">
                                    <option value="">Seleccione...</option>
                                </select>
                            </div>
                            <p></p>
                            <hr/>
                            <p class="nota">Este producto queda configurado para ser movilizado bajo un control de cupos</p>
                    	</fieldset >
                        <div data-linea="1">
                			<button type="submit" class="guardar">Guardar</button>
                		</div>
                    </form >';
            break;
            case 'Editar':
                
                $idConfiguracionProductoCupo = $modeloProductoCupo->getIdConfiguracionProductoCupo();
                $idTipoProducto = $modeloProductoCupo->getIdTipoProducto();
                $idSubtipoProducto = $modeloProductoCupo->getIdSubtipoProducto();
                $idProducto = $modeloProductoCupo->getIdProducto();
                $estadoConfiguracionProductoCupo = $modeloProductoCupo->getEstadoConfiguracionProductoCupo();
                
                $qDatosTipoProducto = $this->lNegocioTipoProductos->buscar($idTipoProducto);
                $nombreTipoProducto = $qDatosTipoProducto->getNombre();
                
                $qDatosSubtipoProducto = $this->lNegocioSubtipoProductos->buscar($idSubtipoProducto);
                $nombreSubtipoProducto = $qDatosSubtipoProducto->getNombre();
                
                $qDatosProducto = $this->lNegocioProductos->buscar($idProducto);
                $nombreProducto = $qDatosProducto->getNombreComun();
                
                $datos = '<form id="formulario" data-rutaAplicacion="'. URL_MVC_FOLDER . 'MovilizacionVegetal" data-opcion="ConfiguracionProductoCupo/guardar" data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
                    	<input type="hidden" name="id_configuracion_producto_cupo" value="' . $idConfiguracionProductoCupo . '" readonly="readonly">
                        <fieldset>
                    		<legend>Configuración producto/cupo</legend>
                    		<div data-linea="1">
                    			<label for="id_tipo_producto">Tipo de producto: </label>'
                                . $nombreTipoProducto .
                    		'</div>
                        
                    		<div data-linea="2">
                    			<label for="id_subtipo_producto">Subtipo de producto: </label>'
                    			. $nombreSubtipoProducto .
                    			'</div>
                        
                    		<div data-linea="3">
                    			<label for="id_producto">Producto: </label>'
                    		    . $nombreProducto .	
                            '</div>
                            <div data-linea="4">
                    			<label for="estado_configuracion_producto_cupo">Control de cupo: </label>
                    			<select id="estado_configuracion_producto_cupo" name="estado_configuracion_producto_cupo" class="validacion">
                    			<option value="">Seleccione...</option>'
                                . $this->comboActivoInactivo($estadoConfiguracionProductoCupo) .
                                '</select>
                            </div>
                            <p></p>
                            <hr/>
                            <p class="nota">Este producto queda configurado para ser movilizado bajo un control de cupos</p>
                    	</fieldset >
                        <div data-linea="1">
                			<button type="submit" class="guardar">Guardar</button>
                		</div>
                    </form >';
            break;
        }
        
        

        return $datos;
    }
    
    public function obtenerTipoProducto($idArea) {
        
        $tipo = "";
        
        $combo = $this->lNegocioTipoProductos->obtenerTipoProductoConfiguracionProductoCupoPorIdArea($idArea);
               
        foreach ($combo as $item){
            $tipo .= '<option value="' . $item->id_tipo_producto . '">' . $item->nombre . '</option>';
        }              
               
        return $tipo;
        
    }
    
    public function obtenerSubtipoProductoPorIdTipoProducto() {

        $resultado = "";
        
        $idTipoProducto = $_POST["idTipoProducto"];
        
        $combo = $this->lNegocioSubtipoProductos->obtenerSubtipoProductoConfiguracionProductoCupoPorIdTipoProducto($idTipoProducto);
        
        $resultado .= '<option value="">Seleccione...</option>';
        
        foreach ($combo as $item){
            $resultado .= '<option value="' . $item->id_subtipo_producto . '">' . $item->nombre . '</option>';
        }   
               
        echo json_encode(array(
            'resultado' => $resultado
        ));
        
    }
    
    public function obtenerProductoPorIdSubtipoProducto() {
        
        $resultado = "";
        
        $idSubtipoProducto = $_POST["idSubtipoProducto"];
        
        $combo = $this->lNegocioProductos->obtenerProductoConfiguracionProductoCupoPorIdSubipoProducto($idSubtipoProducto);
        
        $resultado .= '<option value="">Seleccione...</option>';
        
        foreach ($combo as $item){
            $resultado .= '<option value="' . $item->id_producto . '">' . $item->nombre_comun . '</option>';
        }
        
        echo json_encode(array(
            'resultado' => $resultado
        ));
        
    }
    
    /**
     * Consulta los subtipos de producto por id tipo producto
     *
     * @param Integer $idTipoProducto
     * @return string
     *//*
    public function comboSubtipoProductoPorIdTipoProducto($idTipoProducto)
    {
        
        $subtipoProducto = new SubtipoProductosLogicaNegocio();
        $subtipos = "";
        
        $query = "estado = 1 and id_tipo_producto = '" . $idTipoProducto . "' order by nombre ASC";
        
        $combo = $subtipoProducto->buscarLista($query);
        
        $subtipos .= '<option value="">Seleccione...</option>';
        
        foreach ($combo as $item) {
            $subtipos .= '<option value="' . $item->id_subtipo_producto . '" data-nombre="' . $item->nombre . '">' . $item->nombre . '</option>';
        }
        
        return $subtipos;
        
    }*/
    
    /**
     * Consulta los productos por id subtipo producto
     *
     * @param Integer $idSubtipoProducto
     * @return string
     */
    /*public function comboProductoPorIdSubtipoProducto($idSubtipoProducto)
    {
        
        $producto = new ProductosLogicaNegocio();
        $productos = "";
        
        $query = "estado = 1 and id_subtipo_producto = '" . $idSubtipoProducto . "' order by nombre_comun ASC";
        
        $combo = $producto->buscarLista($query);
        
        $productos .= '<option value="">Seleccione...</option>';
        
        foreach ($combo as $item) {
            $productos .= '<option value="' . $item->id_producto . '" data-nombre="' . $item->nombre_comun . '">' . $item->nombre_comun . '</option>';
        }
        
        return $productos;
        
    }*/
    
    
}
