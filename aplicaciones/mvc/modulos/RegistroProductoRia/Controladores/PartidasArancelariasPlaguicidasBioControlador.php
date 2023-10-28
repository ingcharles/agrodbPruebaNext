<?php
 /**
 * Controlador PartidasArancelariasPlaguicidasBio
 *
 * Este archivo controla la lógica del negocio del modelo:  PartidasArancelariasPlaguicidasBioModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-22
 * @uses    PartidasArancelariasPlaguicidasBioControlador
 * @package RegistroProductoRia
 * @subpackage Controladores
 */
 namespace Agrodb\RegistroProductoRia\Controladores;
 use Agrodb\RegistroProductoRia\Modelos\PartidasArancelariasPlaguicidasBioLogicaNegocio;
 use Agrodb\RegistroProductoRia\Modelos\PartidasArancelariasPlaguicidasBioModelo;
 
class PartidasArancelariasPlaguicidasBioControlador extends BaseControlador 
{

		 private $lNegocioPartidasArancelariasPlaguicidasBio = null;
		 private $modeloPartidasArancelariasPlaguicidasBio = null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioPartidasArancelariasPlaguicidasBio = new PartidasArancelariasPlaguicidasBioLogicaNegocio();
		 $this->modeloPartidasArancelariasPlaguicidasBio = new PartidasArancelariasPlaguicidasBioModelo();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloPartidasArancelariasPlaguicidasBio = $this->lNegocioPartidasArancelariasPlaguicidasBio->buscarPartidasArancelariasPlaguicidasBio();
		 $this->tablaHtmlPartidasArancelariasPlaguicidasBio($modeloPartidasArancelariasPlaguicidasBio);
		 require APP . 'RegistroProductoRia/vistas/listaPartidasArancelariasPlaguicidasBioVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo PartidasArancelariasPlaguicidasBio"; 
		 require APP . 'RegistroProductoRia/vistas/formularioPartidasArancelariasPlaguicidasBioVista.php';
		}	/**
		* Método para registrar en la base de datos -PartidasArancelariasPlaguicidasBio
		*/
		public function guardar()
		{
		  $this->lNegocioPartidasArancelariasPlaguicidasBio->guardar($_POST);
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: PartidasArancelariasPlaguicidasBio
		*/
		public function editar()
		{
		 $this->accion = "Editar PartidasArancelariasPlaguicidasBio"; 
		 $this->modeloPartidasArancelariasPlaguicidasBio = $this->lNegocioPartidasArancelariasPlaguicidasBio->buscar($_POST["id"]);
		 require APP . 'RegistroProductoRia/vistas/formularioPartidasArancelariasPlaguicidasBioVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - PartidasArancelariasPlaguicidasBio
		*/
		public function borrar()
		{
		  $this->lNegocioPartidasArancelariasPlaguicidasBio->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - PartidasArancelariasPlaguicidasBio
		*/
		 public function tablaHtmlPartidasArancelariasPlaguicidasBio($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_partida_arancelaria'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'RegistroProductoRia\partidasarancelariasplaguicidasbio"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_partida_arancelaria'] . '</b></td>
<td>'
		  . $fila['id_solicitud_registro_producto'] . '</td>
<td>' . $fila['partida_arancelaria']
		  . '</td>
<td>' . $fila['id_partida_arancelaria'] . '</td>
</tr>');
		}
		}
	}
	
	public function crearPartidaArancelariaProducto($parametros, $estado, $datoOrigen)
	{
	    
	    $idSolicitudRegistroProducto = $parametros['id_solicitud_registro_producto'];
	    
	    $banderaAcciones = false;
	    $ingresoDatos = '';
	    $filaPartidaArancelaria = '';
	    
	    switch ($estado) {
	        case 'creado':
	        case 'subsanacion':
	            
	            $banderaAcciones = true;
	            
	            $ingresoDatos = '<div data-linea="1">
                                    <label>Partida: </label>
                                    <input type="text" id="partida_arancelaria" name="partida_arancelaria" class="validacion">
                                </div>
                                    <div data-linea="2">
                                    <button type="submit" class="mas" id="agregarPartidaArancelaria">Agregar</button>
                                </div>';
	            break;
	    }
	    
	    $arrayConsulta = [
	        'id_solicitud_registro_producto' => $idSolicitudRegistroProducto
	    ];
	    
	    $qDatosPartidaArancelaria = $this->lNegocioPartidasArancelariasPlaguicidasBio->buscarLista($arrayConsulta);
	    
	    foreach ($qDatosPartidaArancelaria as $datosPartidaArancelaria) {
	        
	        $idPartidaArancelaria = $datosPartidaArancelaria['id_partida_arancelaria'];
	        $nombrePartidaArancelaria = $datosPartidaArancelaria['partida_arancelaria'];
	        
	        $filaPartidaArancelaria .=
	        '<tr id="fila' . $idPartidaArancelaria . '">
                    <td>' . $nombrePartidaArancelaria . '</td>
	                <td style="width: 20px;" class="abrir">
                    <form class="abrir" data-rutaAplicacion="'. URL_MVC_FOLDER .'RegistroProductoRia" data-opcion="CodigosComplementariosSuplementariosPlaguicidasBio/codigoComplementarioSuplementarioPlaguicida" data-destino="detalleItem" data-accionEnExito="NADA" >
    				    <input type="hidden" name="id_partida_arancelaria" value="' . $idPartidaArancelaria . '" readonly="readonly"/>
                        <input type="hidden" name="id" value="' . $idSolicitudRegistroProducto . '" readonly="readonly"/>
                        <input type="hidden" name="dato_origen" value="' . $datoOrigen . '" readonly="readonly"/>
                        <button class="icono" type="submit" ></button>
                    </form>
                    </td>';
	        if ($banderaAcciones) {
	            $filaPartidaArancelaria .= '<td style="width: 20px;" class="borrar">
                                                <button type="button" name="eliminar" class="icono" onclick="fn_eliminarPartidaArancelaria(' . $idPartidaArancelaria . '); return false;"/>
                                            </td>';
	        }
	        $filaPartidaArancelaria .= '</tr>';
	    }
	    
	    return '<fieldset id="fPartidaArancelaria">
                <legend>Partida Arancelaria</legend>
                ' . $ingresoDatos . '
                <table id="tPartidaArancelaria" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Partida</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>' . $filaPartidaArancelaria . '</tbody>
                </table>
            </fieldset>';
	}
	
	/**
	 * Método para generar fila de la partida arancelaria registrada
	 */
	public function generarFilaPartidaArancelaria($idPartidaArancelaria, $datosPartidaArancelaria, $datoOrigen)
	{
	    $this->listaDetalles = '
                        <tr id="fila' . $idPartidaArancelaria . '">
                            <td>' . $datosPartidaArancelaria['partida_arancelaria'] . '</td>
                            <td style="width: 20px;" class="abrir">
                            <form class="abrir" data-rutaAplicacion="'. URL_MVC_FOLDER .'RegistroProductoRia" data-opcion="CodigosComplementariosSuplementariosPlaguicidasBio/codigoComplementarioSuplementarioPlaguicida" data-destino="detalleItem" data-accionEnExito="NADA" >
            				    <input type="hidden" name="id_partida_arancelaria" value="' . $idPartidaArancelaria . '" >
                                <input type="hidden" name="id" value="' . $datosPartidaArancelaria['id_solicitud_registro_producto'] . '" >
                                <input type="hidden" name="dato_origen" value="' . $datoOrigen . '" readonly="readonly"/>
                                <button class="icono" type="submit" ></button>
                            </form>
                            </td>
                            <td style="width: 20px;" class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarPartidaArancelaria(' . $idPartidaArancelaria . '); return false;"/></td>
                        </tr>';
	    
	    return $this->listaDetalles;
	}

}
