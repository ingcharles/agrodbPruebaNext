<?php
 /**
 * Controlador CodigosComplementariosSuplementariosPlaguicidasBio
 *
 * Este archivo controla la lógica del negocio del modelo:  CodigosComplementariosSuplementariosPlaguicidasBioModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-22
 * @uses    CodigosComplementariosSuplementariosPlaguicidasBioControlador
 * @package RegistroProductoRia
 * @subpackage Controladores
 */
 namespace Agrodb\RegistroProductoRia\Controladores;
 use Agrodb\RegistroProductoRia\Modelos\CodigosComplementariosSuplementariosPlaguicidasBioLogicaNegocio;
 use Agrodb\RegistroProductoRia\Modelos\CodigosComplementariosSuplementariosPlaguicidasBioModelo;
use Agrodb\RegistroProductoRia\Modelos\SolicitudesRegistroProductosLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\PartidasArancelariasPlaguicidasBioLogicaNegocio;
 
class CodigosComplementariosSuplementariosPlaguicidasBioControlador extends BaseControlador 
{

		 private $lNegocioCodigosComplementariosSuplementariosPlaguicidasBio = null;
		 private $modeloCodigosComplementariosSuplementariosPlaguicidasBio = null;
		 private $lNegocioSolicitudesRegistroProductos = null;
		 private $lNegocioPartidasArancelariasPlaguicidasBio = null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioCodigosComplementariosSuplementariosPlaguicidasBio = new CodigosComplementariosSuplementariosPlaguicidasBioLogicaNegocio();
		 $this->modeloCodigosComplementariosSuplementariosPlaguicidasBio = new CodigosComplementariosSuplementariosPlaguicidasBioModelo();
		 $this->lNegocioSolicitudesRegistroProductos = new SolicitudesRegistroProductosLogicaNegocio();
		 $this->lNegocioPartidasArancelariasPlaguicidasBio = new PartidasArancelariasPlaguicidasBioLogicaNegocio();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloCodigosComplementariosSuplementariosPlaguicidasBio = $this->lNegocioCodigosComplementariosSuplementariosPlaguicidasBio->buscarCodigosComplementariosSuplementariosPlaguicidasBio();
		 $this->tablaHtmlCodigosComplementariosSuplementariosPlaguicidasBio($modeloCodigosComplementariosSuplementariosPlaguicidasBio);
		 require APP . 'RegistroProductoRia/vistas/listaCodigosComplementariosSuplementariosPlaguicidasBioVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo CodigosComplementariosSuplementariosPlaguicidasBio"; 
		 require APP . 'RegistroProductoRia/vistas/formularioCodigosComplementariosSuplementariosPlaguicidasBioVista.php';
		}	/**
		* Método para registrar en la base de datos -CodigosComplementariosSuplementariosPlaguicidasBio
		*/
		public function guardar()
		{
		    
		    $validacion = "";
		    $resultado = "Datos ingresados con exito";
		    
		    $idSolicitudRegistroProducto = $_POST['id_solicitud_registro_producto'];
		    $idPartidaArancelaria = $_POST['id_partida_arancelaria'];
		    $codigoComplementario = $_POST['codigo_complementario'];
		    $codigoSuplementario = $_POST['codigo_suplementario'];
		    $filaCodigoComplementarioSuplementarioPlaguicida = '';
		    $datoOrigen = "Operador";
		    
		    $arrayParametros = array(
		        'id_partida_arancelaria' => $idPartidaArancelaria,
		        'codigo_complementario' => $codigoComplementario,
		        'codigo_suplementario' => $codigoSuplementario
		    );
		    
		    $verificarCodigoComplementarioSuplementarioPlaguicida = $this->lNegocioCodigosComplementariosSuplementariosPlaguicidasBio->buscarLista($arrayParametros);
		    
		    if (count($verificarCodigoComplementarioSuplementarioPlaguicida) === 0) {
		        
		        $datosCodigoComplementarioSuplementarioPlaguicida = array(
		            'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
		            'id_partida_arancelaria' => $idPartidaArancelaria,
		            'codigo_complementario' => $codigoComplementario,
		            'codigo_suplementario' => $codigoSuplementario
		        );
		        
		        $idCodigoComplementarioSuplementario = $this->lNegocioCodigosComplementariosSuplementariosPlaguicidasBio->guardar($datosCodigoComplementarioSuplementarioPlaguicida);
		        
		        $filaCodigoComplementarioSuplementarioPlaguicida = $this->generarFilaCodigoComplementarioSuplementario($idCodigoComplementarioSuplementario, $datosCodigoComplementarioSuplementarioPlaguicida, $datoOrigen);
		        
		        echo json_encode(array(
		            'validacion' => $validacion,
		            'resultado' => $resultado,
		            'filaCodigoComplementarioSuplementarioPlaguicida' => $filaCodigoComplementarioSuplementarioPlaguicida
		        ));
		        
		    } else {
		        $validacion = "Fallo";
		        $resultado = "El código complementario y suplementario ya ha sido ingresado.";
		        echo json_encode(array(
		            'validacion' => $validacion,
		            'resultado' => $resultado
		        ));
		    }
		    
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: CodigosComplementariosSuplementariosPlaguicidasBio
		*/
		public function editar()
		{
		 $this->accion = "Editar CodigosComplementariosSuplementariosPlaguicidasBio"; 
		 $this->modeloCodigosComplementariosSuplementariosPlaguicidasBio = $this->lNegocioCodigosComplementariosSuplementariosPlaguicidasBio->buscar($_POST["id"]);
		 require APP . 'RegistroProductoRia/vistas/formularioCodigosComplementariosSuplementariosPlaguicidasBioVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - CodigosComplementariosSuplementariosPlaguicidasBio
		*/
		public function borrar()
		{
		  $this->lNegocioCodigosComplementariosSuplementariosPlaguicidasBio->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - CodigosComplementariosSuplementariosPlaguicidasBio
		*/
		 public function tablaHtmlCodigosComplementariosSuplementariosPlaguicidasBio($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_codigo_complementario_suplementario'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'RegistroProductoRia\codigoscomplementariossuplementariosplaguicidasbio"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_codigo_complementario_suplementario'] . '</b></td>
<td>'
		  . $fila['id_partida_arancelaria'] . '</td>
<td>' . $fila['codigo_complementario']
		  . '</td>
<td>' . $fila['codigo_suplementario'] . '</td>
</tr>');
		}
		}
	}

	public function codigoComplementarioSuplementarioPlaguicida()
	{
	    $this->accion = "Detalle de códigos complementarios y suplementarios";
	    $idSolicitudRegistroProducto = $_POST['id'];
	    $idPartidaArancelaria = $_POST['id_partida_arancelaria'];
	    $datoOrigen = $_POST['dato_origen'];
	    
	    $qSolicitudRegistroProducto = $this->lNegocioSolicitudesRegistroProductos->buscar($idSolicitudRegistroProducto);
	    $estado = $qSolicitudRegistroProducto->getEstado();
	    
	    $arrayParametros = ['idSolicitudRegistroProducto' => $idSolicitudRegistroProducto
	        , 'idPartidaArancelaria' => $idPartidaArancelaria
	    ];
	    
	    $this->codigoComplementarioSuplementarioPlaguicida =  $this->crearCodigoComplementarioSuplementarioPlaguicida($arrayParametros, $estado, $datoOrigen);
	    
	    require APP . 'RegistroProductoRia/vistas/formularioCodigosComplementariosSuplementariosVista.php';
	}
	
	public function crearCodigoComplementarioSuplementarioPlaguicida($arrayParametros, $estado, $datoOrigen){
	    
	    $banderaAcciones = false;
	    $filaCodigoComplementarioSuplementarioPlaguicida = '';
	    $ingresoDatos = '';
	    $idPartidaArancelaria = $arrayParametros['idPartidaArancelaria'];
	    $idSolicitudRegistroProducto = $arrayParametros['idSolicitudRegistroProducto'];
	    
	    $qDatosPartidaArancelaria = $this->lNegocioPartidasArancelariasPlaguicidasBio->buscar($idPartidaArancelaria);
	    $partidaArancelaria = $qDatosPartidaArancelaria->getPartidaArancelaria();
	    
	    
	    
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
                    				<label>Código complementario: </label>
                    				<select id="codigo_complementario" name="codigo_complementario" class="validacion">
                    					<option value="0000">0000</option>
                    				</select>
                    			</div>
                    			<div data-linea="1">
                    				<label>Código suplementario: </label>
                    				<select id="codigo_suplementario" name="codigo_suplementario" class="validacion">
                    					<option value="0000">0000</option>
                    					<option value="0001">0001</option>
                    					<option value="0002">0002</option>
                    					<option value="0003">0003</option>
                    					<option value="0004">0004</option>
                    					<option value="0005">0005</option>
                    					<option value="0006">0006</option>
                    					<option value="0007">0007</option>
                    					<option value="0008">0008</option>
                    					<option value="0009">0009</option>
                    					<option value="0010">0010</option>
                    					<option value="0011">0011</option>
                    					<option value="0012">0012</option>
                    					<option value="0013">0013</option>
                    					<option value="0014">0014</option>
                    					<option value="0015">0015</option>
                    					<option value="0016">0016</option>
                    					<option value="0017">0017</option>
                    					<option value="0018">0018</option>
                    					<option value="0019">0019</option>
                    					<option value="0020">0020</option>
                    				</select>
                    			</div>
                    			<div data-linea="4">
                    				<button type="submit" class="mas" id="agregarCodigoComplementarioSuplementarioPlaguicida">Agregar</button>
                    			</div>';
	            break;
	    }
	    
	    $arrayConsulta = [
	        'id_partida_arancelaria' => $idPartidaArancelaria
	    ];
	    
	    $qDatosCodigoCompementarioSuplementarioPlaguicida = $this->lNegocioCodigosComplementariosSuplementariosPlaguicidasBio->buscarLista($arrayConsulta);
	    
	    foreach ($qDatosCodigoCompementarioSuplementarioPlaguicida as $datosCodigoComplementarioSuplementarioPlaguicida) {
	        
	        $idCodigoComplementarioSuplementario = $datosCodigoComplementarioSuplementarioPlaguicida['id_codigo_complementario_suplementario'];
	        $codigoComplementario = $datosCodigoComplementarioSuplementarioPlaguicida['codigo_complementario'];
	        $codigoSuplementario = $datosCodigoComplementarioSuplementarioPlaguicida['codigo_suplementario'];
	        
	        $filaCodigoComplementarioSuplementarioPlaguicida .=
	        '<tr id="fila' . $idCodigoComplementarioSuplementario . '">
                    <td>' . $codigoComplementario . '</td>
                    <td>' . $codigoSuplementario . '</td>
	                <td style="width: 20px;" class="abrir">
                    <form class="abrir" data-rutaAplicacion="'. URL_MVC_FOLDER .'RegistroProductoRia" data-opcion="PresentacionesPlaguicidasBio/presentacionPlaguicida" data-destino="detalleItem" data-accionEnExito="NADA" >
    				    <input type="hidden" name="id_codigo_complementario_suplementario" value="' . $idCodigoComplementarioSuplementario . '" >
                        <input type="hidden" name="id_partida_arancelaria" name="id_partida_arancelaria" value="' . $idPartidaArancelaria . '" >
                        <input type="hidden" name="id_solicitud_registro_producto" value="' . $idSolicitudRegistroProducto . '" >
                        <input type="hidden" name="dato_origen" value="' . $datoOrigen . '" >
                        <button class="icono" type="submit" ></button>
                    </form>
                    </td>';
	        if ($banderaAcciones) {
	            $filaCodigoComplementarioSuplementarioPlaguicida .= '<td style="width: 20px;" class="borrar">
                                                                <button type="button" name="eliminar" class="icono" onclick="fn_eliminarCodigoComplementarioSuplementarioPlaguicida(' . $idCodigoComplementarioSuplementario . '); return false;"/>
                                                            </td>';
	        }
	        $filaCodigoComplementarioSuplementarioPlaguicida .= '</tr>';
	        
	    }
	    
	    return '<form id="regresar" data-rutaAplicacion="' . URL_MVC_FOLDER .'RegistroProductoRia" data-opcion="' . $paginaDestino . '" data-destino="detalleItem">
                	<input type="hidden" id="id_partida_arancelaria" name="id_partida_arancelaria" value="' . $idPartidaArancelaria . '" readonly="readonly"/>
                    <input type="hidden" id="id" name="id" value="' . $idSolicitudRegistroProducto . '" readonly="readonly"/>
                	<input type="hidden" name="numero_pestania" value="2" readonly="readonly"/>
                	<div data-linea="3">
                	   <button class="regresar">Regresar a partidas</button>
                	</div>
                </form>
                <fieldset>
                   <legend>Partida Arancelaria</legend>
                    <div data-linea="1">
                       <label>Partida: </label>'
                        . $partidaArancelaria .
                        '</div>
                </fieldset>
        		<fieldset id="fCodigoComplementarioSuplementarioPlaguicida">
        			<legend>Código complementario y suplementario</legend>
        			' . $ingresoDatos . '
        		<table id="tCodigoComplementarioSuplementarioPlaguicida" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Código complementario</th>
                            <th>Código Suplementario</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>' . $filaCodigoComplementarioSuplementarioPlaguicida . '</tbody>
                </table>
            </fieldset>';
                        
	}
	
	/**
	 * Método para generar fila del codigo complementario suplementario registrado
	 */
	public function generarFilaCodigoComplementarioSuplementario($idCodigoComplementarioSuplementario, $datosCodigoComplementarioSuplementario, $datoOrigen)
	{
	    $this->listaDetalles = '
                        <tr id="fila' . $idCodigoComplementarioSuplementario . '">
                            <td>' . $datosCodigoComplementarioSuplementario['codigo_complementario'] . '</td>
                            <td>' . $datosCodigoComplementarioSuplementario['codigo_suplementario'] . '</td>
                            <td style="width: 20px;" class="abrir">
                            <form class="abrir" data-rutaAplicacion="'. URL_MVC_FOLDER .'RegistroProductoRia" data-opcion="PresentacionesPlaguicidasBio/presentacionPlaguicida" data-destino="detalleItem" data-accionEnExito="NADA" >
            				    <input type="hidden" name="id_codigo_complementario_suplementario" value="' . $idCodigoComplementarioSuplementario . '" >
                                <input type="hidden" name="id_partida_arancelaria" value="' . $datosCodigoComplementarioSuplementario['id_partida_arancelaria'] . '" >
                                <input type="hidden" name="id_solicitud_registro_producto" value="' . $datosCodigoComplementarioSuplementario['id_solicitud_registro_producto'] . '" >
                                <input type="hidden" name="dato_origen" value="' . $datoOrigen . '" >
                                <button class="icono" type="submit" ></button>
                            </form>
                            </td>
                            <td style="width: 20px;" class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarCodigoComplementarioSuplementarioPlaguicida(' . $idCodigoComplementarioSuplementario . '); return false;"/></td>
                        </tr>';
	    
	    return $this->listaDetalles;
	}
	
}
