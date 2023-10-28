<?php
 /**
 * Controlador PresentacionesPlaguicidasBio
 *
 * Este archivo controla la lógica del negocio del modelo:  PresentacionesPlaguicidasBioModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-22
 * @uses    PresentacionesPlaguicidasBioControlador
 * @package RegistroProductoRia
 * @subpackage Controladores
 */
 namespace Agrodb\RegistroProductoRia\Controladores;
 use Agrodb\RegistroProductoRia\Modelos\PresentacionesPlaguicidasBioLogicaNegocio;
 use Agrodb\RegistroProductoRia\Modelos\PresentacionesPlaguicidasBioModelo;
use Agrodb\RegistroProductoRia\Modelos\CodigosComplementariosSuplementariosPlaguicidasBioLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\SolicitudesRegistroProductosLogicaNegocio;
 
class PresentacionesPlaguicidasBioControlador extends BaseControlador 
{

		 private $lNegocioPresentacionesPlaguicidasBio = null;
		 private $modeloPresentacionesPlaguicidasBio = null;
		 private $lNegocioSolicitudesRegistroProductos = null;
		 private $lNegocioCodigosComplementariosSuplementariosPlaguicidasBio = null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioPresentacionesPlaguicidasBio = new PresentacionesPlaguicidasBioLogicaNegocio();
		 $this->modeloPresentacionesPlaguicidasBio = new PresentacionesPlaguicidasBioModelo();
		 $this->lNegocioSolicitudesRegistroProductos = new SolicitudesRegistroProductosLogicaNegocio();
		 $this->lNegocioCodigosComplementariosSuplementariosPlaguicidasBio = new CodigosComplementariosSuplementariosPlaguicidasBioLogicaNegocio();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloPresentacionesPlaguicidasBio = $this->lNegocioPresentacionesPlaguicidasBio->buscarPresentacionesPlaguicidasBio();
		 $this->tablaHtmlPresentacionesPlaguicidasBio($modeloPresentacionesPlaguicidasBio);
		 require APP . 'RegistroProductoRia/vistas/listaPresentacionesPlaguicidasBioVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo PresentacionesPlaguicidasBio"; 
		 require APP . 'RegistroProductoRia/vistas/formularioPresentacionesPlaguicidasBioVista.php';
		}	/**
		* Método para registrar en la base de datos -PresentacionesPlaguicidasBio
		*/
		public function guardar()
		{
		    
		    $validacion = "";
		    $resultado = "Datos ingresados con exito";
		    
		    $idCodigoComplementarioSuplementario = $_POST['id_codigo_complementario_suplementario'];
		    $presentacion = trim($_POST['presentacion']);
		    $idUnidad = $_POST['id_unidad'];
		    $unidad = $_POST['unidad'];
		    $filaPresentacionPlaguicida = '';
		    
		    $arrayParametros = array(
		        'id_codigo_complementario_suplementario' => $idCodigoComplementarioSuplementario,
		        'presentacion' => $presentacion,
		        'id_unidad' => $idUnidad,
		        'unidad' => $unidad
		    );
		    
		    $verificarPresentacionPlaguicida = $this->lNegocioPresentacionesPlaguicidasBio->buscarLista($arrayParametros);
		    
		    if (count($verificarPresentacionPlaguicida) === 0) {
		        $datosPresentacionPlaguicida = array(
		            'id_codigo_complementario_suplementario' => $idCodigoComplementarioSuplementario,
		            'presentacion' => $presentacion,
		            'id_unidad' => $idUnidad,
		            'unidad' => $unidad
		        );
		        
		        $idPresentacion = $this->lNegocioPresentacionesPlaguicidasBio->guardar($datosPresentacionPlaguicida);
		        
		        $filaPresentacionPlaguicida = $this->generarFilaPresentacion($idPresentacion, $datosPresentacionPlaguicida);
		        
		        echo json_encode(array(
		            'validacion' => $validacion,
		            'resultado' => $resultado,
		            'filaPresentacionPlaguicida' => $filaPresentacionPlaguicida
		        ));
		        
		    } else {
		        $validacion = "Fallo";
		        $resultado = "La presentación ya ha sido ingresada.";
		        echo json_encode(array(
		            'validacion' => $validacion,
		            'resultado' => $resultado
		        ));
		    }
		    
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: PresentacionesPlaguicidasBio
		*/
		public function editar()
		{
		 $this->accion = "Editar PresentacionesPlaguicidasBio"; 
		 $this->modeloPresentacionesPlaguicidasBio = $this->lNegocioPresentacionesPlaguicidasBio->buscar($_POST["id"]);
		 require APP . 'RegistroProductoRia/vistas/formularioPresentacionesPlaguicidasBioVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - PresentacionesPlaguicidasBio
		*/
		public function borrar()
		{
		  $this->lNegocioPresentacionesPlaguicidasBio->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - PresentacionesPlaguicidasBio
		*/
		 public function tablaHtmlPresentacionesPlaguicidasBio($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_presentacion'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'RegistroProductoRia\presentacionesplaguicidasbio"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_presentacion'] . '</b></td>
<td>'
		  . $fila['id_codigo_complementario_suplementario'] . '</td>
<td>' . $fila['presentacion']
		  . '</td>
<td>' . $fila['id_unidad'] . '</td>
</tr>');
		}
		}
	}
	
	public function presentacionPlaguicida()
	{
	    $this->accion = "Detalle de presentaciones";
	    
	    $idCodigoComplemetarioSuplementario = $_POST['id_codigo_complementario_suplementario'];
	    $idPartidaArancelaria = $_POST['id_partida_arancelaria'];
	    $idSolicitudRegistroProducto = $_POST['id_solicitud_registro_producto'];
	    $datoOrigen = $_POST['dato_origen'];
	    
	    $qSolicitudRegistroProducto = $this->lNegocioSolicitudesRegistroProductos->buscar($idSolicitudRegistroProducto);
	    $estado = $qSolicitudRegistroProducto->getEstado();
	    
	    $arrayParametros = ['idSolicitudRegistroProducto' => $idSolicitudRegistroProducto
	        , 'idPartidaArancelaria' => $idPartidaArancelaria
	        , 'idCodigoComplemetarioSuplementario' => $idCodigoComplemetarioSuplementario
	    ];
	    
	    $this->presentacionPlaguicida =  $this->crearPresentacionPlaguicida($arrayParametros, $estado, $datoOrigen);
	    
	    require APP . 'RegistroProductoRia/vistas/formularioPresentacionesPlaguicidasVista.php';
	}
	
	public function crearPresentacionPlaguicida($arrayParametros, $estado, $datoOrigen){
	    
	    $banderaAcciones = false;
	    $filaPresentacionPlaguicida = '';
	    $ingresoDatos = '';
	    $idPartidaArancelaria = $arrayParametros['idPartidaArancelaria'];
	    $idCodigoComplementarioSuplementario = $arrayParametros['idCodigoComplemetarioSuplementario'];
	    $idSolicitudRegistroProducto = $arrayParametros['idSolicitudRegistroProducto'];
	    
	    $qDatosCodigoComplementarioSuplementarioPlaguicida = $this->lNegocioCodigosComplementariosSuplementariosPlaguicidasBio->buscar($idCodigoComplementarioSuplementario);
	    $codigoComplementario = $qDatosCodigoComplementarioSuplementarioPlaguicida->getCodigoComplementario();
	    $codigoSuplementario = $qDatosCodigoComplementarioSuplementarioPlaguicida->getCodigoSuplementario();
	    
	    switch ($estado) {
	        case 'creado':
	        case 'subsanacion':
	            $banderaAcciones = true;
	            $ingresoDatos = '<div data-linea="1">
                    				<label>Presentación: </label>
                    				<input name="presentacion" id="presentacion" type="text" class="validacion">
                    			</div>
                                <div data-linea="2">
                    				<label>Unidad: </label>
                                    <select id="id_unidad_medida" name="id_unidad_medida" class="validacion">
						            <option value="">Seleccione...</option>
                    				' . $this->comboUnidadesMedida() . '
                                    </select>
                    			</div>
                                <div data-linea="3">
                    				<button type="submit" class="mas" id="agregarPresentacionPlaguicida">Agregar</button>
                    			</div>';
	            break;
	    }
	    
	    $arrayConsulta = [
	        'id_codigo_complementario_suplementario' => $idCodigoComplementarioSuplementario
	    ];
	    
	    $qDatosPresentacionesPlaguicidas = $this->lNegocioPresentacionesPlaguicidasBio->buscarLista($arrayConsulta);
	    
	    foreach ($qDatosPresentacionesPlaguicidas as $datosPresentacionesPlaguicidas) {
	        
	        $idPresentacion = $datosPresentacionesPlaguicidas['id_presentacion'];
	        $presentacion = $datosPresentacionesPlaguicidas['presentacion'];
	        $unidad = $datosPresentacionesPlaguicidas['unidad'];
	        
	        $filaPresentacionPlaguicida .=
	        '<tr id="fila' . $idPresentacion . '">
                    <td>' . $presentacion . ' ' . $unidad . '</td>';
	        if ($banderaAcciones) {
	            $filaPresentacionPlaguicida .= '<td style="width: 20px;" class="borrar">
                                                    <button type="button" name="eliminar" class="icono" onclick="fn_eliminarPresentacionPlaguicida(' . $idPresentacion . '); return false;"/>
                                                </td>';
	        }
	        $filaPresentacionPlaguicida .= '</tr>';
	        
	    }
	    
	    return '<form id="regresar" data-rutaAplicacion="' . URL_MVC_FOLDER .'RegistroProductoRia" data-opcion="CodigosComplementariosSuplementariosPlaguicidasBio/codigoComplementarioSuplementarioPlaguicida" data-destino="detalleItem">
                	<input type="hidden" id="id_partida_arancelaria" name="id_partida_arancelaria" value="' . $idPartidaArancelaria . '" readonly="readonly"/>
                    <input type="hidden" name="id" value="' . $idSolicitudRegistroProducto . '" readonly="readonly"/>
                	<input type="hidden" id="id_codigo_complementario_suplementario" name="id_codigo_complementario_suplementario" value="' . $idCodigoComplementarioSuplementario . '" readonly="readonly"/>
                    <input type="hidden" name="dato_origen" value="' . $datoOrigen . '" >
                    <div data-linea="3">
                	   <button class="regresar">Regresar a códigos</button>
                	</div>
                </form>
                <fieldset>
                    <legend>Código complementario y suplementario</legend>
                    <div data-linea="1">
                       <label>Código complementario: </label>'
                	    . $codigoComplementario .
                	    '</div>
                     <div data-linea="1">
                       <label>Código suplementario: </label>'
                	        . $codigoSuplementario .
                	        '</div>
                </fieldset>
                <fieldset id="fPresentacionPlaguicida">
        			<legend>Presentaciones</legend>
                '. $ingresoDatos . '
        		<table id="tPresentacionPlaguicida" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Presentación</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>' . $filaPresentacionPlaguicida . '</tbody>
                </table>
            </fieldset>';
                	        
	}
	
	/**
	 * Método para generar fila de la presentacion
	 */
	public function generarFilaPresentacion($idPresentacion, $datosPresentacionPlaguicida)
	{
	    $this->listaDetalles = '
                        <tr id="fila' . $idPresentacion . '">
                            <td>' . $datosPresentacionPlaguicida['presentacion'] . ' ' . $datosPresentacionPlaguicida['unidad'] . '</td>
                            <td style="width: 20px;" class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarPresentacionPlaguicida(' . $idPresentacion . '); return false;"/></td>
                        </tr>';
	    
	    return $this->listaDetalles;
	}

}
