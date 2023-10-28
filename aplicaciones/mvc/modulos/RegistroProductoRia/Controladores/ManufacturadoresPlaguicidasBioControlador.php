<?php
 /**
 * Controlador ManufacturadoresPlaguicidasBio
 *
 * Este archivo controla la lógica del negocio del modelo:  ManufacturadoresPlaguicidasBioModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-22
 * @uses    ManufacturadoresPlaguicidasBioControlador
 * @package RegistroProductoRia
 * @subpackage Controladores
 */
 namespace Agrodb\RegistroProductoRia\Controladores;
 use Agrodb\RegistroProductoRia\Modelos\ManufacturadoresPlaguicidasBioLogicaNegocio;
 use Agrodb\RegistroProductoRia\Modelos\ManufacturadoresPlaguicidasBioModelo;
 use Agrodb\RegistroProductoRia\Modelos\SolicitudesRegistroProductosLogicaNegocio;
 use Agrodb\RegistroProductoRia\Modelos\FabricantesFormuladoresLogicaNegocio;
 
class ManufacturadoresPlaguicidasBioControlador extends BaseControlador 
{

		 private $lNegocioManufacturadoresPlaguicidasBio = null;
		 private $modeloManufacturadoresPlaguicidasBio = null;
		 private $lNegocioSolicitudesRegistroProductos = null;
		 private $lNegocioFabricantesFormuladores = null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioManufacturadoresPlaguicidasBio = new ManufacturadoresPlaguicidasBioLogicaNegocio();
		 $this->modeloManufacturadoresPlaguicidasBio = new ManufacturadoresPlaguicidasBioModelo();
		 $this->lNegocioSolicitudesRegistroProductos = new SolicitudesRegistroProductosLogicaNegocio();
		 $this->lNegocioFabricantesFormuladores = new FabricantesFormuladoresLogicaNegocio();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloManufacturadoresPlaguicidasBio = $this->lNegocioManufacturadoresPlaguicidasBio->buscarManufacturadoresPlaguicidasBio();
		 $this->tablaHtmlManufacturadoresPlaguicidasBio($modeloManufacturadoresPlaguicidasBio);
		 require APP . 'RegistroProductoRia/vistas/listaManufacturadoresPlaguicidasBioVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo ManufacturadoresPlaguicidasBio"; 
		 require APP . 'RegistroProductoRia/vistas/formularioManufacturadoresPlaguicidasBioVista.php';
		}	/**
		* Método para registrar en la base de datos -ManufacturadoresPlaguicidasBio
		*/
		public function guardar()
		{
		    
		    $validacion = "";
		    $resultado = "Datos ingresados con exito";
		    
		    $idFabricanteFormulador = $_POST['id_fabricante_formulador'];
		    $manufacturador = $_POST['manufacturador'];
		    $idPaisOrigen = $_POST['id_pais_origen'];
		    $paisOrigen = $_POST['pais_origen'];
		    
		    $arrayParametro = array(
		        'id_fabricante_formulador' => $idFabricanteFormulador,
		        'manufacturador' => $manufacturador,
		        'id_pais_origen' => $idPaisOrigen,
		        'pais_origen' => $paisOrigen
		    );
		    
		    $verificarManufacturador = $this->lNegocioManufacturadoresPlaguicidasBio->buscarLista($arrayParametro);
		    
		    if (count($verificarManufacturador) === 0) {
		        
		        $datosManufacturador = array(
		            'id_fabricante_formulador' => $idFabricanteFormulador,
		            'manufacturador' => $manufacturador,
		            'id_pais_origen' => $idPaisOrigen,
		            'pais_origen' => $paisOrigen
		        );
		        
		        $idManufacturador = $this->lNegocioManufacturadoresPlaguicidasBio->guardar($datosManufacturador);
		        
		        $filaManufacturador= $this->generarFilaManufacturador($idManufacturador, $datosManufacturador);
		        
		        echo json_encode(array(
		            'validacion' => $validacion,
		            'resultado' => $resultado,
		            'filaManufacturador' => $filaManufacturador
		        ));
		        
		    } else {
		        $validacion = "Fallo";
		        $resultado = "El manufacturador y país ya han sido ingresados.";
		        echo json_encode(array(
		            'validacion' => $validacion,
		            'resultado' => $resultado
		        ));
		    }
		    
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: ManufacturadoresPlaguicidasBio
		*/
		public function editar()
		{
		 $this->accion = "Editar ManufacturadoresPlaguicidasBio"; 
		 $this->modeloManufacturadoresPlaguicidasBio = $this->lNegocioManufacturadoresPlaguicidasBio->buscar($_POST["id"]);
		 require APP . 'RegistroProductoRia/vistas/formularioManufacturadoresPlaguicidasBioVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - ManufacturadoresPlaguicidasBio
		*/
		public function borrar()
		{
		  $this->lNegocioManufacturadoresPlaguicidasBio->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - ManufacturadoresPlaguicidasBio
		*/
		 public function tablaHtmlManufacturadoresPlaguicidasBio($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_manufacturadores_plaguicidas_bio'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'RegistroProductoRia\manufacturadoresplaguicidasbio"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_manufacturadores_plaguicidas_bio'] . '</b></td>
<td>'
		  . $fila['id_fabricante_formulador'] . '</td>
<td>' . $fila['manufacturadores_plaguicidas_bio']
		  . '</td>
<td>' . $fila['id_pais_origen'] . '</td>
</tr>');
		}
		}
	}
	
	public function manufacturador()
	{
	    $this->accion = "Detalle de manufacturador";
	    $idSolicitudRegistroProducto = $_POST['id_solicitud_registro_producto'];
	    $idFabricateFormulador = $_POST['id_fabricante_formulador'];
	    $datoOrigen = $_POST['dato_origen'];
	    
	    $qSolicitudRegistroProducto = $this->lNegocioSolicitudesRegistroProductos->buscar($idSolicitudRegistroProducto);
	    $estado = $qSolicitudRegistroProducto->getEstado();
	    
	    $arrayParametros = ['idSolicitudRegistroProducto' => $idSolicitudRegistroProducto
	        , 'idFabricanteFormulador' => $idFabricateFormulador
	    ];
	    
	    $this->manufacturador =  $this->crearManufacturador($arrayParametros, $estado, $datoOrigen);
	    
	    require APP . 'RegistroProductoRia/vistas/formularioManufacturadoresVista.php';
	}
	
	public function crearManufacturador($arrayParametros, $estado, $datoOrigen){
	    
	    $banderaAcciones = false;
	    $filaManufacturador = '';
	    $ingresoDatos = '';
	    $idFabricanteFormulador = $arrayParametros['idFabricanteFormulador'];
	    $idSolicitudRegistroProducto = $arrayParametros['idSolicitudRegistroProducto'];
	    	    
	    $qDatosFabricanteFormulador = $this->lNegocioFabricantesFormuladores->buscar($idFabricanteFormulador);
	    $fabricanteFormulador = $qDatosFabricanteFormulador->getNombre();
	    $tipo = $qDatosFabricanteFormulador->getTipo();
	    $paisOrigen = $qDatosFabricanteFormulador->getPaisOrigen();
	    
	    if($datoOrigen === "Operador"){
	        $paginaDestino = "SolicitudesRegistroProductos/editar";
	    }
	    
	    if($datoOrigen === "Tecnico"){
	        $paginaDestino = "RevisionSolicitudesRegistroProductos/revisarSolicitudRegistroProductoTecnico";
	    }
	    
	    switch ($estado) {
	        case 'creado':
	        case 'subsanacion':
	            $banderaAcciones = true;
	            $ingresoDatos = '<div data-linea="1">
                                    <label>Manufacturador </label>
                                    <input type="text" name="manufacturador" id="manufacturador" class="validacion">
                                </div>
                                <div data-linea="2">
                                    <label>País origen: </label>
                                    <select id="pais_origen" name="pais_origen" class="validacion">
                                    ' . $this->comboPaises() . '
                                    </select>
                                </div>
                                <div data-linea="3">
                    				<button type="submit" class="mas" id="agregarManufacturador">Agregar</button>
                    			</div>';
	            break;
	    }
	    
	    $arrayConsulta = [
	        'id_fabricante_formulador' => $idFabricanteFormulador
	    ];
	    
	    $qDatosManufacturador = $this->lNegocioManufacturadoresPlaguicidasBio->buscarLista($arrayConsulta);
	    
	    foreach ($qDatosManufacturador as $datosManufacturador) {
	        
	        $idManufacturador = $datosManufacturador['id_manufacturador'];
	        $manufacturador = $datosManufacturador['manufacturador'];
	        $paisOrigenManufacturador = $datosManufacturador['pais_origen'];
	        
	        $filaManufacturador .=
	        '<tr id="fila' . $idManufacturador . '">
                    <td>' . $manufacturador . '</td>
                    <td>' . $paisOrigenManufacturador . '</td>';
	        if ($banderaAcciones) {
	            $filaManufacturador .= '<td style="width: 20px;" class="borrar">
                                            <button type="button" name="eliminar" class="icono" onclick="fn_eliminarManufacturador(' . $idManufacturador . '); return false;"/>
                                        </td>';
	        }
	        $filaManufacturador .= '</tr>';
	        
	    }
	    
	    return '<form id="regresar" data-rutaAplicacion="' . URL_MVC_FOLDER .'RegistroProductoRia" data-opcion="' . $paginaDestino . '" data-destino="detalleItem">
                	<input type="hidden" id="id_fabricante_formulador" name="id_fabricante_formulador" value="' . $idFabricanteFormulador . '" readonly="readonly"/>
                    <input type="hidden" id="id" name="id" value="' . $idSolicitudRegistroProducto . '" readonly="readonly"/>
                	<input type="hidden" name="numero_pestania" value="4" readonly="readonly"/>
                	<div data-linea="3">
                	   <button class="regresar">Regresar a Fabricante/Formulador</button>
                	</div>
                </form>
                <fieldset>
                   <legend>' . ucfirst($tipo) . '</legend>
                    <div data-linea="1">
                       <label>' . ucfirst($tipo) . ': </label>'
                           . $fabricanteFormulador .
                           '</div>
                        <div data-linea="2">
                    <label>País origen: </label>
					' . $paisOrigen . '
                </div>
                </fieldset>
        		<fieldset id="fManufacturador">
        			<legend>Manufacturador</legend>
        			' . $ingresoDatos . '
        		<table id="tManufacturador" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Manufacturador</th>
                            <th>País</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>' . $filaManufacturador . '</tbody>
                </table>
            </fieldset>';
                           
	}
	
	/**
	 * Método para generar fila de manufacturador
	 */
	public function generarFilaManufacturador($idManufacturador, $datosManufacturador)
	{
	    $this->listaDetalles = '
                        <tr id="fila' . $idManufacturador . '">
                            <td>' . $datosManufacturador['manufacturador'] . '</td>
                            <td>' . $datosManufacturador['pais_origen'] . '</td>
                            <td style="width: 20px;" class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarManufacturador(' . $idManufacturador . '); return false;"/></td>
                        </tr>';
	    
	    return $this->listaDetalles;
	}

}
