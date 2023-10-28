<?php
/**
 * Controlador ProductosInspeccionFitosanitaria
 *
 * Este archivo controla la lógica del negocio del modelo:  ProductosInspeccionFitosanitariaModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-15
 * @uses    ProductosInspeccionFitosanitariaControlador
 * @package InspeccionFitosanitaria
 * @subpackage Controladores
 */
namespace Agrodb\InspeccionFitosanitaria\Controladores;

use Agrodb\InspeccionFitosanitaria\Modelos\ProductosInspeccionFitosanitariaLogicaNegocio;
use Agrodb\InspeccionFitosanitaria\Modelos\ProductosInspeccionFitosanitariaModelo;
use Agrodb\RegistroOperador\Modelos\OperadoresLogicaNegocio;
use Agrodb\Catalogos\Modelos\ProductosLogicaNegocio;
use Agrodb\Catalogos\Modelos\UnidadesFitosanitariasLogicaNegocio;
use Agrodb\InspeccionFitosanitaria\Modelos\InspeccionFitosanitariaLogicaNegocio;

class ProductosInspeccionFitosanitariaControlador extends BaseControlador
{

    private $lNegocioProductosInspeccionFitosanitaria = null;

    private $modeloProductosInspeccionFitosanitaria = null;
    
    private $lNegocioInspeccionFitosanitaria = null;

    private $lNegocioOperadores = null;

    private $lNegocioProductos = null;
    
    private $lNegocioUnidadesFitosanitarias = null;

    private $accion = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioProductosInspeccionFitosanitaria = new ProductosInspeccionFitosanitariaLogicaNegocio();
        $this->modeloProductosInspeccionFitosanitaria = new ProductosInspeccionFitosanitariaModelo();
        $this->lNegocioInspeccionFitosanitaria = new InspeccionFitosanitariaLogicaNegocio();
        $this->lNegocioOperadores = new OperadoresLogicaNegocio();
        $this->lNegocioProductos = new ProductosLogicaNegocio();
        $this->lNegocioUnidadesFitosanitarias = new UnidadesFitosanitariasLogicaNegocio();
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
        $modeloProductosInspeccionFitosanitaria = $this->lNegocioProductosInspeccionFitosanitaria->buscarProductosInspeccionFitosanitaria();
        $this->tablaHtmlProductosInspeccionFitosanitaria($modeloProductosInspeccionFitosanitaria);
        require APP . 'InspeccionFitosanitaria/vistas/listaProductosInspeccionFitosanitariaVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nuevo ProductosInspeccionFitosanitaria";
        require APP . 'InspeccionFitosanitaria/vistas/formularioProductosInspeccionFitosanitariaVista.php';
    }

    /**
     * Método para registrar en la base de datos -ProductosInspeccionFitosanitaria
     */
    public function guardar()
    {
        $validacion = "";
        $resultado = "Datos ingresados con exito";

        $idInspeccionFitosanitaria = $_POST['id_inspeccion_fitosanitaria'];
        $idPaisDestino = $_POST['id_pais_destino'];
        $idArea = $_POST['id_area'];
        $idTipoProducto = $_POST['id_tipo_producto'];
        $idSubtipoProducto = $_POST['id_subtipo_producto'];
        $idProducto = $_POST['id_producto'];
        $idUnidadCantidadProducto = $_POST['id_unidad_cantidad_producto'];
        $arrayUnidadCantidadProducto = array();
        $banderaValidarProducto = false;

        $arrayParametros = [
            'id_inspeccion_fitosanitaria' => $idInspeccionFitosanitaria,
            'id_area' => $idArea,
            'id_tipo_producto' => $idTipoProducto,
            'id_subtipo_producto' => $idSubtipoProducto,
            'id_producto' => $idProducto            
        ];
        
        $verificarProductosInspeccionFitosanitaria = $this->lNegocioProductosInspeccionFitosanitaria->buscarLista($arrayParametros);

        if (!$verificarProductosInspeccionFitosanitaria->count()) {
            
            $arrayProducto = [
            	'id_inspeccion_fitosanitaria' => $idInspeccionFitosanitaria,
            	'id_producto' => $idProducto
            ];
        	
            $verificarUnidadCantidadProducto = $this->lNegocioProductosInspeccionFitosanitaria->buscarLista($arrayProducto);
            
            foreach ($verificarUnidadCantidadProducto as $verificarUnidad) {
            	$arrayUnidadCantidadProducto[] = $verificarUnidad['id_unidad_cantidad_producto'];
            }
            
            if(count($arrayUnidadCantidadProducto)){
            	if(in_array($idUnidadCantidadProducto, $arrayUnidadCantidadProducto)){
            		$banderaValidarProducto = true;
            	}            	
            }else{
            	$banderaValidarProducto = true;
            }
            
            $arrayUnidadCantidadProducto = array_unique($arrayUnidadCantidadProducto);
            
            if($banderaValidarProducto){
	            	        	
	            if(empty($_POST['id_tipo_tratamiento'])){
	                unset($_POST['id_tipo_tratamiento']);
	                unset($_POST['nombre_tipo_tratamiento']);
	            }
	            
	            if(empty($_POST['id_tratamiento'])){
	                unset($_POST['id_tratamiento']);
	                unset($_POST['nombre_tratamiento']);
	            }
	            
	            if(empty($_POST['duracion'])){
	                unset($_POST['duracion']);
	                unset($_POST['id_duracion']);
	                unset($_POST['nombre_duracion']);
	            }
	            
	            if(empty($_POST['temperatura'])){
	                unset($_POST['temperatura']);
	                unset($_POST['id_temperatura']);
	                unset($_POST['nombre_temperatura']);
	            }
	            
	            if(empty($_POST['concentracion'])){
	                unset($_POST['concentracion']);
	                unset($_POST['id_concentracion']);
	                unset($_POST['nombre_concentracion']);
	            }
	            
	            if(empty($_POST['producto_quimico'])){
	                unset($_POST['producto_quimico']);
	            }
	            
	            if(empty($_POST['fecha_tratamiento'])){
	                unset($_POST['fecha_tratamiento']);
	            }           
	            
	            $idProductoInspeccionFitosanitaria = $this->lNegocioProductosInspeccionFitosanitaria->guardar($_POST);
	
	            $filaProductoInspeccionar = $this->generarFilaProductoInspeccionFitosanitaria($idProductoInspeccionFitosanitaria);
	            
	            $comboLugarInspeccion = $this->validarConstruirComboLugarInspeccion($idInspeccionFitosanitaria, $idPaisDestino);
	
	            echo json_encode(array(
	                'validacion' => $validacion,
	                'resultado' => $resultado,
	                'filaProductoInspeccionar' => $filaProductoInspeccionar,
	                'comboLugarInspeccion' => $comboLugarInspeccion['comboLugarInspeccion'],
	            	'tipoSolicitud' => $comboLugarInspeccion['tipoSolicitud']
	            ));
	            
            } else {
            	
            	$validacion = "Fallo";
            	$resultado = "Debe registrar la misma unidad de medida en productos iguales.";
            	echo json_encode(array(
            		'validacion' => $validacion,
            		'resultado' => $resultado
            	));
            	
            }
            
        } else {
            $validacion = "Fallo";
            $resultado = "El producto ya ha sido registrado.";
            echo json_encode(array(
                'validacion' => $validacion,
                'resultado' => $resultado
            ));
        }
    }

    /**
     * Método para generar fila de producto a inspeccionar
     */
    public function generarFilaProductoInspeccionFitosanitaria($idProductoInspeccionFitosanitaria)
    {
        
        $qDatosProducto = $this->lNegocioProductosInspeccionFitosanitaria->buscar($idProductoInspeccionFitosanitaria);
        $identificadorOperador = $qDatosProducto->getIdentificadorOperador();

        $arrayDatosOperador = [
            'identificador' => $identificadorOperador
        ];
        
        $qDatosOperador = $this->lNegocioOperadores->obtenerDatosOperadores($arrayDatosOperador);
        
        $productor = $qDatosOperador->current()->nombre_operador;     
        $finca = $qDatosProducto->getNombreArea();
        $nombreProvincia = $qDatosProducto->getNombreProvincia();
        $codigoArea = $qDatosProducto->getCodigoArea();
        $producto = $qDatosProducto->getNombreSubtipoProducto() . '/' . $qDatosProducto->getNombreProducto();
        $cantidad = $qDatosProducto->getCantidadProducto();
        $peso = $qDatosProducto->getPesoProducto();
        $nombreUnidadCantidadProducto = $qDatosProducto->getNombreUnidadCantidadProducto();
        $peso = $qDatosProducto->getPesoProducto();
        $nombreUnidadPesoProducto = $qDatosProducto->getNombreUnidadPesoProducto();
        $nombreTipoTratamiento = $qDatosProducto->getNombreTipoTratamiento();
        $duracionTratamiento = $qDatosProducto->getDuracion();
        $nombreUnidadDuracion = $qDatosProducto->getNombreDuracion();
        $fechaTaratamiento = $qDatosProducto->getFechaTratamiento();
        $productoQuimico = $qDatosProducto->getProductoQuimico();
        $nombreTratamiento = $qDatosProducto->getNombreTratamiento();
        $temperaturaTratamiento = $qDatosProducto->getTemperatura();
        $nombreUnidadTemperatura = $qDatosProducto->getNombreTemperatura();
        $concentracionTratamiento = $qDatosProducto->getConcentracion();
        $nombreUnidadConcentracion = $qDatosProducto->getNombreConcentracion();
        
        $this->listaDetalles = '
                        <tr id="fila' . $idProductoInspeccionFitosanitaria . '">
                            <td>' . $productor . '</td>
                            <td>' . $finca . '</td>
                            <td>' . $nombreProvincia . '</td>
							<td>' . $codigoArea . '</td>
                            <td>' . $producto . '</td>
                            <td>' . $cantidad . ' ' . $nombreUnidadCantidadProducto . '</td>
                            <td>' . $peso . ' ' . $nombreUnidadPesoProducto . '</td>
                            <td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarDetalleProductoInspeccion(' . $idProductoInspeccionFitosanitaria . '); return false;"/></td>
                        <td><button id="' . $idProductoInspeccionFitosanitaria .'" onclick="adicionalProducto(this.id)">Ver más</button></td></tr>
                        <tr id="resultadoInformacionProducto'. $idProductoInspeccionFitosanitaria .'" style="display:none;">
                                        <td colspan="5">
                                            <label>Tipo tratamiento: </label>' . ($nombreTipoTratamiento != "" ? $nombreTipoTratamiento : 'N/A') .
                                            '</br><label>Duración tratamiento: </label>' . ($duracionTratamiento != "" ? $duracionTratamiento . ' ' . $nombreUnidadDuracion : 'N/A') .
                                            '</br><label>Fecha tratamiento: </label>' . ($fechaTaratamiento != "" ? date('Y-m-d',strtotime($fechaTaratamiento)) : 'N/A') .
                                            '</br><label>Producto químico: </label>' . ($productoQuimico != "" ? $productoQuimico : 'N/A') .
                                            '</td>
                                        <td colspan="4">
                                            <label>Tratamiento: </label>' . ($nombreTratamiento != "" ? $nombreTratamiento : 'N/A') .
                                            '</br><label>Temperatura: </label>' . ($temperaturaTratamiento != "" ? $temperaturaTratamiento . ' ' . $nombreUnidadTemperatura : 'N/A') .
                                            '</br>'.
                                            '</br><label>Concentración: </label>' . ($concentracionTratamiento != "" ? $concentracionTratamiento . ' ' . $nombreUnidadConcentracion : 'N/A') .
                                            '</td>
                                    </tr>';

        return $this->listaDetalles;
    }

    /**
     * Obtenemos los datos del registro seleccionado para editar - Tabla: ProductosInspeccionFitosanitaria
     */
    public function editar()
    {
        $this->accion = "Editar ProductosInspeccionFitosanitaria";
        $this->modeloProductosInspeccionFitosanitaria = $this->lNegocioProductosInspeccionFitosanitaria->buscar($_POST["id"]);
        require APP . 'InspeccionFitosanitaria/vistas/formularioProductosInspeccionFitosanitariaVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - ProductosInspeccionFitosanitaria
     */
    public function borrar()
    {
        $this->lNegocioProductosInspeccionFitosanitaria->borrar($_POST['id_producto_inspeccion_fitosanitaria']);

        $idInspeccionFitosanitaria = $_POST['id_inspeccion_fitosanitaria'];
        
        $qProductosInspeccionFitosanitaria = $this->lNegocioInspeccionFitosanitaria->buscar($idInspeccionFitosanitaria);
        $idPaisDestino = $qProductosInspeccionFitosanitaria->getIdPaisDestino();

        $comboLugarInspeccion = $this->validarConstruirComboLugarInspeccion($idInspeccionFitosanitaria, $idPaisDestino);
        
        echo json_encode(array(
        	'comboLugarInspeccion' => $comboLugarInspeccion['comboLugarInspeccion'],
        	'tipoSolicitud' => $comboLugarInspeccion['tipoSolicitud']
        ));
    }

    /**
     * Construye el código HTML para desplegar la lista de - ProductosInspeccionFitosanitaria
     */
    public function tablaHtmlProductosInspeccionFitosanitaria($tabla)
    {
        {
            $contador = 0;
            foreach ($tabla as $fila) {
                $this->itemsFiltrados[] = array(
                    '<tr id="' . $fila['id_producto_inspeccion_fitosanitaria'] . '"
                    class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'InspeccionFitosanitaria\productosinspeccionfitosanitaria"
                    data-opcion="editar" ondragstart="drag(event)" draggable="true"
                    data-destino="detalleItem">
                    <td>' . ++ $contador . '</td>
                    <td style="white - space:nowrap; "><b>' . $fila['id_producto_inspeccion_fitosanitaria'] . '</b></td>
                    <td>' . $fila['id_inspeccion_fitosanitaria'] . '</td>
                    <td>' . $fila['id_area'] . '</td>
                    <td>' . $fila['codigo_area'] . '</td>
                    </tr>'
                );
            }
        }
    }

    /**
     * Método para construir los productores agregados
     */
    public function crearProductoresAgregados($idInspeccionFitosanitaria, $estado)
    {
        $filaProductosAgregados = '';
        $banderaAcciones = false;
        $banderaCantidadesAprobadas = false;
        $caberaCantidadesAprobadas = "";
        $nota = "";
        $tipoUsuario = $this->usuarioInterno;
        
        switch ($estado) {
            case 'Creado':
            case 'Subsanacion':
            	if(!$tipoUsuario){
                	$banderaAcciones = true;
            	}
                break;
            case 'Aprobado':
                $banderaCantidadesAprobadas = true;
                $caberaCantidadesAprobadas = '<th>Cant. aprob.</th>
                                              <th>Peso aprob.</th>
 											  <th>Cant. inspecc.</th>
											  <th>Peso. inspecc.</th>';
                $nota = '<p class="nota">Las cantidades autorizadas para la exportación se describen en los campos “cantidad aprobada” y “peso aprobado”.</p>';
                break;
        }

        $arrayParametros = [
            'id_inspeccion_fitosanitaria' => $idInspeccionFitosanitaria
        ];
        $qProductoresAgregados = $this->lNegocioProductosInspeccionFitosanitaria->buscarLista($arrayParametros);

        foreach ($qProductoresAgregados as $productosAgregados) {

            $identificadorOperador = $productosAgregados['identificador_operador'];
            $arrayDatosOperador = [
                'identificador' => $identificadorOperador
            ];
            $qDatosOperador = $this->lNegocioOperadores->obtenerDatosOperadores($arrayDatosOperador);
            $productor = $qDatosOperador->current()->nombre_operador;
            $idProductoInspeccionFitosanitaria = $productosAgregados['id_producto_inspeccion_fitosanitaria'];
            $finca = $productosAgregados['nombre_area'];
            $nombreProvincia = $productosAgregados['nombre_provincia'];
            $codigoArea = $productosAgregados['codigo_area'];
            $producto = $productosAgregados['nombre_subtipo_producto'] . '/' . $productosAgregados['nombre_producto'];
            $cantidad = $productosAgregados['cantidad_producto'];
            $peso = $productosAgregados['peso_producto'];
            $cantidadAprobada = $productosAgregados['cantidad_aprobada'];
            $pesoAprobado = $productosAgregados['peso_aprobado'];
            $cantidadInspeccionada = $productosAgregados['cantidad_inspeccionada'];
            $pesoInspeccionado = $productosAgregados['peso_inspeccionado'];
            $nombreUnidadCantidadProducto = $productosAgregados['nombre_unidad_cantidad_producto'];
            $peso = $productosAgregados['peso_producto'];
            $nombreUnidadPesoProducto = $productosAgregados['nombre_unidad_peso_producto'];
            $nombreTipoTratamiento = $productosAgregados['nombre_tipo_tratamiento'];
            $duracionTratamiento = $productosAgregados['duracion'];
            $nombreUnidadDuracion = $productosAgregados['nombre_duracion'];
            $fechaTaratamiento = $productosAgregados['fecha_tratamiento'];
            $productoQuimico = $productosAgregados['producto_quimico'];
            $nombreTratamiento = $productosAgregados['nombre_tratamiento'];
            $temperaturaTratamiento = $productosAgregados['temperatura'];
            $nombreUnidadTemperatura = $productosAgregados['nombre_temperatura'];
            $concentracionTratamiento = $productosAgregados['concentracion'];
            $nombreUnidadConcentracion = $productosAgregados['nombre_concentracion'];
            
            $filaProductosAgregados .= '<tr id="fila' . $idProductoInspeccionFitosanitaria . '">
                    <td>' . $productor . '</td>
                    <td>' . $finca . '</td>
                    <td>' . $nombreProvincia . '</td>
					<td>' . $codigoArea . '</td>
                    <td>' . $producto . '</td>
                    ';
            if ($banderaAcciones) {

                $filaProductosAgregados .= '<td>' . $cantidad . ' ' . $nombreUnidadCantidadProducto . '</td>
							                <td>' . $peso . ' ' . $nombreUnidadPesoProducto . '</td>
											<td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarDetalleProductoInspeccion(' . $idProductoInspeccionFitosanitaria . '); return false;"/></td>';
            } else {                               
                
                $filaProductosAgregados .= '<td>' . $cantidad . ' ' . $nombreUnidadCantidadProducto . '</td>
                <td>' . $peso . ' ' . $nombreUnidadPesoProducto . '</td>';
                
                if($banderaCantidadesAprobadas){
                    $filaProductosAgregados .= '<td><b>' . $cantidadAprobada . ' ' . $nombreUnidadCantidadProducto . '</b></td>
                    <td><b>' . $pesoAprobado . ' ' . $nombreUnidadPesoProducto . '</b></td>
					<td>' . $cantidadInspeccionada . ' ' . $nombreUnidadCantidadProducto . '</td>
                    <td>' . $pesoInspeccionado . ' ' . $nombreUnidadPesoProducto . '</td>';
                }
                
            }
            
            $filaProductosAgregados .= '<td><button id="' . $idProductoInspeccionFitosanitaria .'" onclick="adicionalProducto(this.id)">Ver más</button></td></tr>
            <tr id="resultadoInformacionProducto'. $idProductoInspeccionFitosanitaria .'" style="display:none;">
                            <td colspan="5">
                                <label>Tipo tratamiento: </label>' . ($nombreTipoTratamiento != "" ? $nombreTipoTratamiento : 'N/A') .
                                '</br><label>Duración tratamiento: </label>' . ($duracionTratamiento != "" ? $duracionTratamiento . ' ' . $nombreUnidadDuracion : 'N/A') .
                                '</br><label>Fecha tratamiento: </label>' . ($fechaTaratamiento != "" ? date('Y-m-d',strtotime($fechaTaratamiento)) : 'N/A') .
                                '</br><label>Producto químico: </label>' . ($productoQuimico != "" ? $productoQuimico : 'N/A') .
                                '</td>
                            <td colspan="4">
                                <label>Tratamiento: </label>' . ($nombreTratamiento != "" ? $nombreTratamiento : 'N/A') .
                                '</br><label>Temperatura: </label>' . ($temperaturaTratamiento != "" ? $temperaturaTratamiento . ' ' . $nombreUnidadTemperatura : 'N/A') .
                                '</br>'.
                                '</br><label>Concentración: </label>' . ($concentracionTratamiento != "" ? $concentracionTratamiento . ' ' . $nombreUnidadConcentracion : 'N/A') .
                                '</td>
                        </tr>';
        }

        return '<fieldset>
	               <legend>Productores agregados</legend>
                    <table id="tProductoresAgregados" style="width: 100%">
                    <thead>
                    	<tr>
                    		<th>Productor</th>
                    		<th>Finca</th>
                    		<th>Provincia</th>
							<th>Código</th>
                            <th>Producto</th>
                            <th>Cantidad sol.</th>
                            <th>Peso sol.</th>'
                            . $caberaCantidadesAprobadas . 
                            '<th colspan="2"></th>
                       </tr>
                    </thead>
                    <tbody>' . $filaProductosAgregados . '</tbody>
                    </table>'
                    . $nota .
                   '</fieldset>';
    }

    /**
     * Método para actualizar cantidad y peso de producto a inspeccionar
     */
    public function actualizarCantidades()
    {
        $validacion = "Fallo";
        $resultado = "";
        $valorCantidad = "";
        $idProductoInspeccionFitosanitaria = $_POST["id_producto_inspeccion_fitosanitaria"];
        $cantidad = $_POST['cantidad'];
        $tipoCantidad = $_POST['tipo_cantidad'];

        $qValorCantidad = $this->lNegocioProductosInspeccionFitosanitaria->buscar($idProductoInspeccionFitosanitaria);
                
        if (($cantidad > 0) && trim($cantidad) != "") {
                                    
            switch ($tipoCantidad) {
				case "cantidad_aprobada":
					if ($cantidad <= $qValorCantidad->getCantidadProducto()){
						$validacion = "Exito";
						$valorCantidad = $cantidad;
					}else{
						$valorCantidad = $qValorCantidad->getCantidadProducto();
					}
				break;
				case "peso_aprobado":
					if ($cantidad <= $qValorCantidad->getPesoProducto()){
						$validacion = "Exito";
						$valorCantidad = $cantidad;
					}else{
						$valorCantidad = $qValorCantidad->getPesoProducto();
					}
					break;
				case "cantidad_inspeccionada":
					if ($cantidad <= $qValorCantidad->getCantidadProducto()){
							$validacion = "Exito";
							$valorCantidad = $cantidad;
					}else{
						$valorCantidad = $qValorCantidad->getCantidadProducto();
					}
					break;
				case "peso_inspeccionado":
					if ($cantidad <= $qValorCantidad->getPesoProducto()){
						$validacion = "Exito";
						$valorCantidad = $cantidad;
					}else{
						$valorCantidad = $qValorCantidad->getPesoProducto();
					}
					break;
			}
			
			
        } else {            
            
            switch ($tipoCantidad) {
                case "cantidad_aprobada":
                    $valorCantidad = $qValorCantidad->getCantidadProducto();
                    break;
                case "peso_aprobado":
                    $valorCantidad = $qValorCantidad->getPesoProducto();
                    break;
                case "cantidad_inspeccionada":
                	$valorCantidad = $qValorCantidad->getCantidadProducto();
                	break;
                case "peso_inspeccionado":
                	$valorCantidad = $qValorCantidad->getPesoProducto();
                	break;
            }            
            
           
        }
        
        echo json_encode(array(
        	'resultado' => $resultado,
        	'validacion' => $validacion,
        	'cantidad' => $valorCantidad
        ));
        
    }
    
    /**
     * Método para construir los productores agregados
     */
    public function crearProductoresAgregadosAtenderInspeccion($idInspeccionFitosanitaria)
    {
        $filaProductosAgregados = '';

        $arrayParametros = [
            'id_inspeccion_fitosanitaria' => $idInspeccionFitosanitaria
        ];
        $qProductoresAgregados = $this->lNegocioProductosInspeccionFitosanitaria->buscarLista($arrayParametros);
        
        foreach ($qProductoresAgregados as $productosAgregados) {
            
            $identificadorOperador = $productosAgregados['identificador_operador'];
            $arrayDatosOperador = [
                'identificador' => $identificadorOperador
            ];
            $qDatosOperador = $this->lNegocioOperadores->obtenerDatosOperadores($arrayDatosOperador);
            $productor = $qDatosOperador->current()->nombre_operador;
            $idProductoInspeccionFitosanitaria = $productosAgregados['id_producto_inspeccion_fitosanitaria'];
            $finca = $productosAgregados['nombre_area'];
            $nombreProvincia = $productosAgregados['nombre_provincia'];
            $codigoArea = $productosAgregados['codigo_area'];
            $producto = $productosAgregados['nombre_subtipo_producto'] . '/' . $productosAgregados['nombre_producto'];
            $cantidad = $productosAgregados['cantidad_producto'];
            $nombreUnidadCantidadProducto = $productosAgregados['nombre_unidad_cantidad_producto'];
            $peso = $productosAgregados['peso_producto'];
            $nombreUnidadPesoProducto = $productosAgregados['nombre_unidad_peso_producto'];
            $nombreTipoTratamiento = $productosAgregados['nombre_tipo_tratamiento'];
            $duracionTratamiento = $productosAgregados['duracion'];
            $nombreUnidadDuracion = $productosAgregados['nombre_duracion'];
            $fechaTaratamiento = $productosAgregados['fecha_tratamiento'];
            $productoQuimico = $productosAgregados['producto_quimico'];
            $nombreTratamiento = $productosAgregados['nombre_tratamiento'];
            $temperaturaTratamiento = $productosAgregados['temperatura'];
            $nombreUnidadTemperatura = $productosAgregados['nombre_temperatura'];
            $concentracionTratamiento = $productosAgregados['concentracion'];
            $nombreUnidadConcentracion = $productosAgregados['nombre_concentracion'];

            $filaProductosAgregados .= '<tr id="fila' . $idProductoInspeccionFitosanitaria . '" class="productos">                    
                    <td>' . $productor . '</td>
                    <td>' . $finca . '</td>
                    <td>' . $nombreProvincia . '</td>
					<td>' . $codigoArea . '</td>
                    <td>' . $producto . '</td>
                    <td>' . $cantidad . ' ' . $nombreUnidadCantidadProducto . '</td>
                    <td>' . $peso . ' ' . $nombreUnidadPesoProducto . '</td>
                    <td><input type="text" name="cantidad_aprobada" value="' . $cantidad . '" style="width: 70px;" maxlenght="10" onchange="actualizarCantidades(' . $idProductoInspeccionFitosanitaria . ', this)"></td>
                    <td><input type="text" name="peso_aprobado" value="' . $peso . '" style="width: 70px;" maxlenght="10" onchange="actualizarCantidades(' . $idProductoInspeccionFitosanitaria . ', this)"></td>
                    <td><input type="text" name="cantidad_inspeccionada" value="" style="width: 70px;" maxlenght="10" onchange="actualizarCantidades(' . $idProductoInspeccionFitosanitaria . ', this)"></td>
					<td><input type="text" name="peso_inspeccionado" value="" style="width: 70px;" maxlenght="10" onchange="actualizarCantidades(' . $idProductoInspeccionFitosanitaria . ', this)"></td>
                    <td><input type="hidden" name="id_producto_inspeccion_fitosanitaria" value="' . $idProductoInspeccionFitosanitaria . '"></td>
                    <td><button id="' . $idProductoInspeccionFitosanitaria .'" onclick="adicionalProducto(this.id)">Ver más</button></td></tr>
                    <tr id="resultadoInformacionProducto'. $idProductoInspeccionFitosanitaria .'" style="display:none;">
                            <td colspan="5">
                                <label>Tipo tratamiento: </label>' . ($nombreTipoTratamiento != "" ? $nombreTipoTratamiento : 'N/A') .
                                '</br><label>Duración tratamiento: </label>' . ($duracionTratamiento != "" ? $duracionTratamiento . ' ' . $nombreUnidadDuracion : 'N/A') .
                                '</br><label>Fecha tratamiento: </label>' . ($fechaTaratamiento != "" ? date('Y-m-d',strtotime($fechaTaratamiento)) : 'N/A') .
                                '</br><label>Producto químico: </label>' . ($productoQuimico != "" ? $productoQuimico : 'N/A') .
                                '</td>
                            <td colspan="4">
                                <label>Tratamiento: </label>' . ($nombreTratamiento != "" ? $nombreTratamiento : 'N/A') .
                                '</br><label>Temperatura: </label>' . ($temperaturaTratamiento != "" ? $temperaturaTratamiento . ' ' . $nombreUnidadTemperatura : 'N/A') .
                                '</br>'.
                                '</br><label>Concentración: </label>' . ($concentracionTratamiento != "" ? $concentracionTratamiento . ' ' . $nombreUnidadConcentracion : 'N/A') .
                                '</td>
                        </tr>';
        }
        
        return '<fieldset>
	               <legend>Productores agregados</legend>
                    <table id="tProductoresAgregados">
                    <thead>
                    	<tr>
                    		<th>Productor</th>
                    		<th>Finca</th>
                    		<th>Provincia</th>
							<th>Código</th>
                            <th>Producto</th>
                            <th>Cantidad sol.</th>                            
                            <th>Peso sol.</th>
                            <th>Cant. aprob.</th>
                            <th>Peso aprob.</th>
                            <th>Cant. inspecc.</th>
							<th>Peso. inspecc.</th>
                            <th colspan="2"></th>
                       </tr>
                    </thead>
                    <tbody>' . $filaProductosAgregados . '</tbody>
                    </table>
                   </fieldset>';
    }
    
}
