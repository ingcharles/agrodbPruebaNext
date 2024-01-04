<?php
/**
 * Controlador AsignacionCupo
 *
 * Este archivo controla la lógica del negocio del modelo:  AsignacionCupoModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2023-12-08
 * @uses    AsignacionCupoControlador
 * @package MovilizacionVegetal
 * @subpackage Controladores
 */
namespace Agrodb\MovilizacionVegetal\Controladores;

use Agrodb\Catalogos\Modelos\ProductosLogicaNegocio;
use Agrodb\Catalogos\Modelos\UnidadesFitosanitariasLogicaNegocio;
use Agrodb\MovilizacionVegetal\Modelos\AsignacionCupoLogicaNegocio;
use Agrodb\MovilizacionVegetal\Modelos\AsignacionCupoModelo;
use Agrodb\MovilizacionVegetal\Modelos\MovilizacionModelo;
use Agrodb\RegistroOperador\Modelos\AreasLogicaNegocio;
use Agrodb\RegistroOperador\Modelos\OperadoresLogicaNegocio;
use Agrodb\Core\Mensajes;

class AsignacionCupoControlador extends BaseControlador
{

    private $lNegocioAsignacionCupo = null;

    private $modeloAsignacionCupo = null;

    private $accion = null;

    private $idUnidad = null;

    private $nombreUnidad = null;

    private $modeloMovilizacion = null;

    private $lNegocioOperadores = null;

    private $lNegocioAreas = null;

    private $lNegocioUnidadesFitosanitarias = null;

    private $lNegocioProductos = null;

    private $panelBusqueda = null;

    private $datosGenerales = null;

    private $historialAsignacionCupo = null;
    
    private $banderaEliminarCupo = null;
    
    private $mensajeEliminarCupo = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioAsignacionCupo = new AsignacionCupoLogicaNegocio();
        $this->modeloAsignacionCupo = new AsignacionCupoModelo();
        $this->modeloMovilizacion = new MovilizacionModelo();
        $this->lNegocioOperadores = new OperadoresLogicaNegocio();
        $this->lNegocioAreas = new AreasLogicaNegocio();
        $this->lNegocioUnidadesFitosanitarias = new UnidadesFitosanitariasLogicaNegocio();
        // $this->modeloAreas = new AreasModelo();
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
        $fechaActual = date('Y-m-d');
        $this->panelBusqueda = $this->cargarPanelAsignacionCupo();
        
        $arrayParametros = ['identificacionOperador' => ""
                            , 'nombreOperador' => ""
                            , 'provincia' => ""
                            , 'fechaInicio' => $fechaActual
                            , 'fechaFin' => $fechaActual
                            ];
        
        $modeloAsignacionCupo = $this->lNegocioAsignacionCupo->buscarAsignacionCupo($arrayParametros);
        $this->tablaHtmlAsignacionCupo($modeloAsignacionCupo);
        
        require APP . 'MovilizacionVegetal/vistas/listaAsignacionCupoVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nueva asignación de cupo"; // 55 - KGM

        $arrayParametros = array(
            'codigo_unidad_fitosanitaria' => 'KGM'
        );

        $qUnidad = $this->lNegocioUnidadesFitosanitarias->buscarLista($arrayParametros);
        $this->idUnidad = $qUnidad->current()->id_unidad_fitosanitaria;
        $this->nombreUnidad = $qUnidad->current()->nombre_unidad_fitosanitaria;

        $estadoAsignacionCupo = 'Nuevo';
        $this->datosGenerales = $this->construirDatosGenerales($estadoAsignacionCupo);

        require APP . 'MovilizacionVegetal/vistas/formularioAsignacionCupoVista.php';
    }

    /**
     * Método para registrar en la base de datos - AsignacionCupo
     */
    public function guardar()
    {
        $_POST['anio_asignacion_cupo'] = date("Y");
        $_POST['identificador_responsable'] = $this->identificador;
        $_POST['tipo_transaccion_cupo'] = 1; // tipo:asignacionCupo

        $arrayParametros = $_POST;

        $resultado = $this->lNegocioAsignacionCupo->guardarAsignacionCupo($arrayParametros);

        if ($resultado['resultado'] == 'fallo') {
            Mensajes::fallo($resultado['mensaje']);
        } else {
            Mensajes::exito($resultado['mensaje']);
        }
    }

    /**
     * Método para registrar en la base de datos - AsignacionCupoAdicional
     */
    public function actualizarCupoAdicional()
    {
        $_POST['identificador_responsable'] = $this->identificador;
        $_POST['tipo_transaccion_cupo'] = 2; // tipo:cupoAdicional

        $arrayParametros = $_POST;

        $resultado = $this->lNegocioAsignacionCupo->actualizarAsignacionCupo($arrayParametros);

        echo json_encode(array(
            "estado" => $resultado['resultado'],
            "mensaje" => $resultado['mensaje'],
            "id" => $resultado['id']
        ));
    }

    /**
     * Obtenemos los datos del registro seleccionado para editar - Tabla: AsignacionCupo
     */
    public function editar()
    {
        $this->accion = "Editar asignación de cupo";
        $idAsignacionCupo = $_POST["id"];
        $estadoAsignacionCupo = 'Editar';
        $this->datosGenerales = $this->construirDatosGenerales($estadoAsignacionCupo, $idAsignacionCupo);
        $this->historialAsignacionCupo = $this->construirHistorialAsignacionCupo($idAsignacionCupo);
        require APP . 'MovilizacionVegetal/vistas/formularioCupoAdicionalVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - AsignacionCupo
     */
    public function eliminar()
    {
        $this->accion = "Eliminar asignación de cupo";
        $elementos = array();
        
        if(!empty($_POST['elementos'])){
            $elementos = explode(',', $_POST['elementos']);
        }
        
        if(empty($elementos)){
            $this->banderaEliminarCupo = 'eliminarCupo';
            $this->mensajeEliminarCupo = 'Por favor seleccione un registro.';
        }
        
        if(count($elementos) > 1){
            $this->banderaEliminarCupo = 'eliminarCupo';
            $this->mensajeEliminarCupo = 'Por favor seleccione un registro a la vez.';
        }
        
        if(count($elementos) == 1){            
            $idAsignacionCupo = $elementos[0];
            
            $estadoAsignacionCupo = 'Eliminar';
            $this->datosGenerales = $this->construirDatosGenerales($estadoAsignacionCupo, $idAsignacionCupo);
            $this->historialAsignacionCupo = $this->construirHistorialAsignacionCupo($idAsignacionCupo);           
        }
        
        require APP . 'MovilizacionVegetal/vistas/formularioAsignacionCupoVista.php';
        
    }

    /**
     * Método para registrar en la base de datos - EliminarCupo
     */
    public function eliminarCupo()
    {
        $_POST['identificador_responsable'] = $this->identificador;
        $_POST['tipo_transaccion_cupo'] = 5; // tipo:eliminarCupo

        $arrayParametros = $_POST;

        $resultado = $this->lNegocioAsignacionCupo->eliminarAsignacionCupo($arrayParametros);

        if ($resultado['resultado'] == 'Fallo') {
            Mensajes::fallo($resultado['mensaje']);
        } else {
            Mensajes::exito($resultado['mensaje']);
        }
    }

    /**
     * Construye el código HTML para desplegar la lista de - AsignacionCupo
     */
    public function tablaHtmlAsignacionCupo($tabla)
    {
        {
            $contador = 0;
            foreach ($tabla as $fila) {
                $this->itemsFiltrados[] = array(
                    '<tr id="' . $fila['id_asignacion_cupo'] . '"
		  class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'MovilizacionVegetal/AsignacionCupo"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td><b>' . ++ $contador . '</b></td>
		  <td>' . $fila['nombre_sitio'] . '</td>
        <td>' . $fila['nombre_area'] . '</td>
        <td>' . $fila['nombre_producto'] . '</td>
        <td>' . $fila['lote'] . '</td>
        <td>' . $fila['cupo_asignado'] . '</td>
        <td>' . $fila['cupo_disponible'] . '</td>
        <td>' . $fila['anio_asignacion_cupo'] . '</td>
</tr>'
                );
            }
        }
    }

    /**
     * Método para obtener los sitios del operador
     */
    public function buscarOperadorSitioAsignarCupo()
    {
        $identificador = $_POST["identificador_operador"];
        $razonSocial = $_POST["nombre_operador"];

        $arrayParametros = array(
            'nombre_provincia' => $_POST["provincia"],
            'identificador' => $identificador,
            'razon_social' => $razonSocial ?? null,
            'area' => 'SV'
        );

        $operadores = $this->lNegocioOperadores->obtenerOperadorSitioAsignarCupo($arrayParametros);

        $comboSitio = "";
        $comboSitio .= '<option value="">Seleccione...</option>';

        foreach ($operadores as $item) {
            $comboSitio .= '<option value="' . $item->id_sitio . '" data-identificador="' . $item->identificador . '" data-nombre="' . $item->razon . '" data-nombre_sitio="' . $item->sitio . '" data-codigo_sitio="' . $item->identificador . '.' . $item->codigo_provincia . $item->codigo . '"  data-codigo_provincia="' . $item->codigo_provincia . '">' . $item->identificador . '-' . $item->razon . '-' . $item->sitio . '</option>';
        }

        echo $comboSitio;
        exit();
    }

    /**
     * Método para obtener las áreas del sitio de origen del operador
     */
    public function buscarAreasOperadorAsignarCupo()
    {
        $identificador = $_POST["identificador_operador"];
        $idSitio = $_POST["id_sitio"];

        $arrayParametros = array(
            'id_sitio' => $idSitio,
            'area' => 'SV'
        );

        $areas = $this->lNegocioAreas->obtenerAreasOperadorAsignarCupo($arrayParametros);

        $comboArea = "";
        $comboArea .= '<option value="">Seleccione....</option>';

        foreach ($areas as $item) {
            $comboArea .= '<option value="' . $item->id_area . '" data-nombre="' . $item->nombre_area . '" data-codigo_area="' . $identificador . '.' . $item->codigo_area . '">' . $item->nombre_area . '-' . $item->nombre_tipo_operacion . '</option>';
        }

        echo $comboArea;
        exit();
    }

    /**
     * Método para obtener los productos del área del sitio del operador
     */
    public function buscarProductoAreasOperadoresAsignarCupo()
    {
        $id_area = $_POST["id_area"];

        $arrayParametros = array(
            'id_area' => $id_area
        );

        $productos = $this->lNegocioProductos->obtenerProductoAreasOperadoresAsignarCupo($arrayParametros);

        $comboProductos = "";
        $comboProductos .= '<option value="">Seleccione...</option>';

        foreach ($productos as $item) {
            $comboProductos .= '<option value="' . $item->id_producto . '" >' . $item->nombre_comun . '</option>';
        }

        echo $comboProductos;
        exit();
    }

    public function cargarPanelAsignacionCupo()
    {
        $datosBusqueda = '<table class="filtro" style="width: 100%; text-align:left;">
                                    <tbody>
                                        <tr>
                                            <th colspan="4">Consultar registros de asignación de cupo</th>
                                        </tr>    
                                        <tr>
                    						<td>*Identificación operador: </td>
                    						<td>
                    							<input id="identificacionOperador" type="text" name="identificacionOperador" maxlength="13" style="width: 100%">
                    						</td>
    
                    						<td>*Nombre operador: </td>
                    						<td>
                    							<input id="nombreOperador" type="text" name="nombreOperador" maxlength="512" style="width: 100%">
                    						</td>
                    					</tr>
                                        <tr>
                    						<td>Provincia: </td>
                    						<td colspan="3">
                    							<select id="provincia" name="provincia" style="width: 100%">
                                                <option value="">Seleccione...</option>' . $this->comboProvinciasEc() . '</select>
                    						</td>
                                        </tr>
                                        <tr  style="width: 100%;">
                    						<td >Fecha Inicio: </td>
                    						<td>
                    							<input id="fechaInicio" type="text" name="fechaInicio" readonly="readonly" style="width: 100%">
                    						</td>
                                                    
                    						<td >Fecha Fin: </td>
                    						<td>
                    							<input id="fechaFin" type="text" name="fechaFin" readonly="readonly" style="width: 100%">
                    						</td>
                    					</tr>           
                    					<tr>
                    						<td colspan="4" style="text-align: end;">
                    							<button id="btnFiltrar">Consultar</button>
                    						</td>
                    					</tr>
                    				</tbody>
                    			</table>';

        return $datosBusqueda;
    }

    public function listarAsignacionCupoFiltrado()
    {
        $estado = 'EXITO';
        $mensaje = '';
        $contenido = '';

        $modeloAsignacionCupo = $this->lNegocioAsignacionCupo->buscarAsignacionCupo($_POST);
        $this->tablaHtmlAsignacionCupo($modeloAsignacionCupo);

        $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);

        echo json_encode(array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'contenido' => $contenido
        ));
    }

    public function construirDatosGenerales($estadoAsignacionCupo, $idAsignacionCupo = null)
    {
        $datos = "";

        switch ($estadoAsignacionCupo) {

            case 'Nuevo':
                $datos = '<form id="formulario" data-rutaAplicacion="' . URL_MVC_FOLDER . 'MovilizacionVegetal" data-opcion="AsignacionCupo/guardar" data-destino="detalleItem"
                    	data-accionEnExito="ACTUALIZAR" method="post" autocomplete="off">
                    	<input type="hidden" name="id_unidad_medida" value="' . $this->idUnidad . '" readonly="readonly" />
                        <fieldset>
                    		<legend>Registro de cupo</legend>
                    
                    		<div data-linea="1">
                    			<label for="id_provincia">Provincia: </label> <select
                    				id="id_provincia" name="id_provincia">
                    				<option value="">Seleccione...</option>' . $this->comboProvinciasEc() . '</select>
                    		</div>
                    
                    		<div data-linea="2">
                    			<label for="identificador_operador">Identificador Operador: </label> <input
                    				type="text" id="identificador_operador"
                    				name="identificador_operador" value=""
                    				placeholder="Identificador del operador" maxlength="13" />
                    		</div>
                    
                    		<div data-linea="2">
                    			<label for="nombre_operador">Nombre Operador: </label> <input
                    				type="text" id="nombre_operador" name="nombre_operador" value=""
                    				placeholder="Nombre del operador" maxlength="128" />
                    		</div>
                    
                    		<div data-linea="3">
                    			<button type="button" class="buscar"
                    				onclick="obtenerOperadorSitioAsignarCupo()">Buscar</button>
                    		</div>
                    
                    		<hr />
                    
                    		<div data-linea="4">
                    			<label for="id_sitio">Sitio: </label> <select id="id_sitio"
                    				name="id_sitio" class="validacion">
                    				<option value="">Seleccione...</option>
                    			</select>
                    		</div>
                    
                    		<div data-linea="5">
                    			<label for="id_area">Área: </label> <select id="id_area"
                    				name="id_area" class="validacion">
                    				<option value="">Seleccione...</option>
                    			</select>
                    		</div>
                    
                    		<div data-linea="5">
                    			<label for="codigo_area">Código área: </label> <input type="text"
                    				id="codigo_area" value="" readonly="readonly" class="validacion" />
                    		</div>
                    		<div data-linea="6">
                    			<label for="id_producto">Producto: </label> <select id="id_producto"
                    				name="id_producto" class="validacion">
                    				<option value="">Seleccione...</option>
                    			</select>
                    		</div>
                    		<div data-linea="7">
                    			<label for="lote">Lote: </label> <input type="text" id="lote"
                    				name="lote" value="" placeholder="Número de lote" class="validacion"
                    				maxlength="128" />
                    		</div>
                    		<div data-linea="8">
                    			<label for="cupo_asignado">Estimación de consecha (' . $this->nombreUnidad . '): </label>
                    			<input type="text" id="cupo_asignado" name="cupo_asignado" value=""
                    				placeholder="Cantidad de la estimación de cosecha"
                    				class="validacion" maxlength="10"
                    				oninput="formatearCantidadProducto(this)" />
                    		</div>
                    	</fieldset>
                    	<div data-linea="13">
                    		<button type="submit" class="guardar">Guardar</button>
                    	</div>
                    </form>';
                break;

            case 'Editar':
            case 'Eliminar':

                $qDatosAsignacionCupo = $this->lNegocioAsignacionCupo->buscarAsignacionCupoPorIdAsignacionCupo($idAsignacionCupo);
                $nombreProvincia = $qDatosAsignacionCupo->current()->provincia_sitio;
                $identificadorOperador = $qDatosAsignacionCupo->current()->identificador;
                $nombreOperador = $qDatosAsignacionCupo->current()->nombre_operador;
                $nombreSitio = $qDatosAsignacionCupo->current()->nombre_sitio;
                $nombreArea = $qDatosAsignacionCupo->current()->nombre_area;
                $codigoArea = $qDatosAsignacionCupo->current()->codigo_area;
                $nombreProducto = $qDatosAsignacionCupo->current()->nombre_producto;
                $lote = $qDatosAsignacionCupo->current()->lote;
                $cupoAsignado = $qDatosAsignacionCupo->current()->cupo_asignado;
                $nombreUnidad = $qDatosAsignacionCupo->current()->nombre_unidad;
                $idAsignacionCupo = $qDatosAsignacionCupo->current()->id_asignacion_cupo;
                $cupoDisponible = $qDatosAsignacionCupo->current()->cupo_disponible;
                $anioAsignacionCupo = $qDatosAsignacionCupo->current()->anio_asignacion_cupo;

                $datoCupoAdicional = "";
                $datoGuardar = "";
                $rutaFormulario = "";
                $accionExito = "";

                switch ($estadoAsignacionCupo) {

                    case 'Editar':

                        $rutaFormulario = "actualizarCupoAdicional";

                        $datoCupoAdicional = '<div data-linea="9"><label for="cupo_adicional">Cupo adicional (' . $nombreUnidad . '): </label><input type="text" id="cupo_adicional" name="cupo_adicional" value=""
                				placeholder="Cupo adicional de la estimación de cosecha"
                				class="validacion" maxlength="10"
                				oninput="formatearCantidadProducto(this)" /></div>';

                        $datoGuardar = '<input type="hidden" id="id" name="id" /><div data-linea="13">
                            		<button type="submit" class="guardar">Guardar</button>
                            	</div>';

                        break;

                    case 'Eliminar':

                        $rutaFormulario = "eliminarCupo";
                        $accionExito = 'data-accionEnExito="ACTUALIZAR"';

                        $datoGuardar = '<div data-linea="13">
                                		<button type="submit" class="guardar">Eliminar</button>
                                	</div>';

                        break;
                }

                $datos = '<form id="formulario" data-rutaAplicacion="' . URL_MVC_FOLDER . 'MovilizacionVegetal" data-opcion="AsignacionCupo/' . $rutaFormulario . '" data-destino="detalleItem" 
                    	' . $accionExito . ' method="post" autocomplete="off">
                        <input type="hidden" name="id_asignacion_cupo" value="' . $idAsignacionCupo . '" readonly="readonly" />
                        <fieldset>
                    		<legend>Registro de cupo</legend>
                    
                    		<div data-linea="1">
                    			<label for="id_provincia">Provincia: </label>' . $nombreProvincia . '</div>

                            <div data-linea="1">
                    			<label for="anio_asignacion_cupo">Año de asignación de cupo: </label>' . $anioAsignacionCupo . '</div>
                    
                    		<div data-linea="2">
                    			<label for="identificador_operador">Identificador Operador: </label>' . $identificadorOperador . '</div>
                    
                    		<div data-linea="3">
                    			<label for="nombre_operador">Nombre Operador: </label>' . $nombreOperador . '</div>
                    
                    		<div data-linea="4">
                    			<label for="id_sitio">Sitio: </label>' . $nombreSitio . '</div>
                    
                    		<div data-linea="5">
                    			<label for="id_area">Área: </label>' . $nombreArea . '</div>
                    
                    		<div data-linea="5">
                    			<label for="codigo_area">Código área: </label>' . $codigoArea . '</div>
                    		<div data-linea="6">
                    			<label for="id_producto">Producto: </label>' . $nombreProducto . '</div>
                    		<div data-linea="7">
                    			<label for="lote">Lote: </label>' . $lote . '</div>
                    		<div data-linea="8">
                    			<label for="cupo_asignado">Cupo asignado (' . $nombreUnidad . '): </label>' . $cupoAsignado . '</div>
                            <div data-linea="8">
                    			<label for="cupo_disponible">Cupo disponible (' . $nombreUnidad . '): </label>' . $cupoDisponible . '</div>
                            ' . $datoCupoAdicional . '
                    	</fieldset>' . $datoGuardar . '</form>';
                break;
        }

        return $datos;
    }

    public function construirHistorialAsignacionCupo($idAsignacionCupo)
    {
        $qDatosHistorialCupo = $this->lNegocioAsignacionCupo->obtenerHistorialAsignacionCupo($idAsignacionCupo);

        $datos = "";

        if ($qDatosHistorialCupo->count()) {

            $datos = '<br><fieldset>
                        <legend>Historial de cupos</legend>
                        <table style="width:100%">
                        <thead>
                            <tr>
                                <th>Tipo registro</th>
                                <th>Cantidad</th>
                                <th>Fecha de registro</th>
                                <th>Técnico responsable</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($qDatosHistorialCupo as $datoHistorialCupo) {
                $tipoRegistro = $datoHistorialCupo['tipo_registro'];
                $cantidad = $datoHistorialCupo['cantidad'];
                $fechaRegistro = $datoHistorialCupo['fecha_registro'];
                $tecnicoResponsable = $datoHistorialCupo['tecnico_responsable'];
                $cantidadTotal = $datoHistorialCupo['cantidad_total'];

                $datos .= '<tr>
                    <td>' . $tipoRegistro . '</td>
                    <td>' . $cantidad . '</td>
                    <td>' . $fechaRegistro . '</td>
                    <td>' . $tecnicoResponsable . '</td>
                </tr>';
            }

            $datos .= '<tr>
                            <td><b>Total cupo: </b></td>
                            <td><b>' . $cantidadTotal . '</b></td>
                            <tdcolspan="2"></td>
                        </tr>
                </tbody>
        </table>
        </fieldset>';
        }

        return $datos;
    }
    
    /**
     * Proceso automático para caducar el cupo anual por area, producto y anio
     */
    public function paCaducarCupoAnualMovilizacion(){
        
        echo "\n".'Inicio proceso Automático de cambio de estado a caducado de movilizaciones'."\n"."\n";
                  
            $this->lNegocioAsignacionCupo->caducarCupoAnualMovilizacion();
        
        echo "\n".'Fin proceso Automático de cambio de estado a caducado de movilizaciones'."\n"."\n";
            
    }
}
