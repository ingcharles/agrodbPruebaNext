<?php
 /**
 * Controlador UsosProductosPlaguicidasBio
 *
 * Este archivo controla la lógica del negocio del modelo:  UsosProductosPlaguicidasBioModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-22
 * @uses    UsosProductosPlaguicidasBioControlador
 * @package RegistroProductoRia
 * @subpackage Controladores
 */
 namespace Agrodb\RegistroProductoRia\Controladores;
 use Agrodb\RegistroProductoRia\Modelos\UsosProductosPlaguicidasBioLogicaNegocio;
 use Agrodb\RegistroProductoRia\Modelos\UsosProductosPlaguicidasBioModelo;
 
class UsosProductosPlaguicidasBioControlador extends BaseControlador 
{

		 private $lNegocioUsosProductosPlaguicidasBio = null;
		 private $modeloUsosProductosPlaguicidasBio = null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioUsosProductosPlaguicidasBio = new UsosProductosPlaguicidasBioLogicaNegocio();
		 $this->modeloUsosProductosPlaguicidasBio = new UsosProductosPlaguicidasBioModelo();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		 $modeloUsosProductosPlaguicidasBio = $this->lNegocioUsosProductosPlaguicidasBio->buscarUsosProductosPlaguicidasBio();
		 $this->tablaHtmlUsosProductosPlaguicidasBio($modeloUsosProductosPlaguicidasBio);
		 require APP . 'RegistroProductoRia/vistas/listaUsosProductosPlaguicidasBioVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo UsosProductosPlaguicidasBio"; 
		 require APP . 'RegistroProductoRia/vistas/formularioUsosProductosPlaguicidasBioVista.php';
		}	/**
		* Método para registrar en la base de datos -UsosProductosPlaguicidasBio
		*/
		public function guardar()
		{
		  $this->lNegocioUsosProductosPlaguicidasBio->guardar($_POST);
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: UsosProductosPlaguicidasBio
		*/
		public function editar()
		{
		 $this->accion = "Editar UsosProductosPlaguicidasBio"; 
		 $this->modeloUsosProductosPlaguicidasBio = $this->lNegocioUsosProductosPlaguicidasBio->buscar($_POST["id"]);
		 require APP . 'RegistroProductoRia/vistas/formularioUsosProductosPlaguicidasBioVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - UsosProductosPlaguicidasBio
		*/
		public function borrar()
		{
		  $this->lNegocioUsosProductosPlaguicidasBio->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - UsosProductosPlaguicidasBio
		*/
		 public function tablaHtmlUsosProductosPlaguicidasBio($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_uso'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'RegistroProductoRia\usosproductosplaguicidasbio"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_uso'] . '</b></td>
<td>'
		  . $fila['id_solicitud_registro_producto'] . '</td>
<td>' . $fila['id_plaga']
		  . '</td>
<td>' . $fila['plaga_nombre_comun'] . '</td>
</tr>');
		}
		}
	}
	
	public function crearUso($parametros, $estado)
	{
	    $idArea = $parametros['id_area'];
	    $idSolicitudRegistroProducto = $parametros['id_solicitud_registro_producto'];
	    
	    $banderaAcciones = false;
	    $ingresoDatos = '';
	    $filaUso = '';
	    
	    switch ($estado) {
	        case 'creado':
	        case 'subsanacion':
	            
	            $banderaAcciones = true;
	            
	            $ingresoDatos = '<div data-linea="1">
						<label>Cultivo Nombre Científico: </label>
						<select id="id_cultivo" name="id_cultivo" class="validacion">
							<option value="">Seleccione...</option>'
							. $this->comboCultivos($idArea) .
						'</select>						
						</div>					
					<div data-linea="1">
						<label>Cultivo Nombre Común: </label>
						<input type="text" name="nombre_cultivo" id="nombre_cultivo" readonly="readonly"/>
					</div>					
					<div data-linea="2">
						<label>Plaga Nombre Científico: </label>
						<select id="id_plaga" name="id_plaga"  class="validacion">
							<option value="">Seleccione...</option>'
							. $this->comboUsos($idArea).
						'</select>						
					</div>					
					<div data-linea="2">
						<label>Plaga Nombre Común: </label>
						<input type="text" name="nombre_plaga" id="nombre_plaga" readonly="readonly"/>
					</div>					
					<div data-linea="3">
						<label>Dosis: </label>
						<input type="text" name="dosis" id="dosis" class="validacion"/>
					</div>					
					<div data-linea="3">	
						<select id="id_unidad_dosis" name="id_unidad_dosis" class="validacion">
    						<option value="">Seleccione...</option>'
    						. $this->comboUnidadesMedida() . 
    					'</select>
					</div>					
					<div data-linea="4">
						<label>Período de carencia: </label>
						<input type="text" name="periodo_carencia" id="periodo_carencia" class="validacion" />
					</div>					
					<div data-linea="5">
						<label>Gasto de agua: </label>
						<input type="text" name="gasto_agua" id="gasto_agua" />
					</div>					
					<div data-linea="5">
						<select id="id_unidad_medida_agua" name="id_unidad_medida_agua" >
    						<option value="" selected="selected">Seleccione...</option>'
    						. $this->comboUnidadesMedida() . 
    					'</select>
					</div>
                    <div data-linea="6">
            			<button type="button" class="mas" id="agregarUsoPlaguicidaBio">Agregar</button>
            		</div>';
	            break;
	    }
	    
	    $arrayConsulta = [
	        'id_solicitud_registro_producto' => $idSolicitudRegistroProducto
	    ];
	    
	    $qDatosUso = $this->lNegocioUsosProductosPlaguicidasBio->buscarLista($arrayConsulta);
	    
	    foreach ($qDatosUso as $datosUso) {

	        $idUso = $datosUso['id_uso'];
	        $plagaNombreComun = $datosUso['plaga_nombre_comun'];
	        $plagaNombreCientifico = $datosUso['plaga_nombre_cientifico'];
	        $cultivoNombreComun = $datosUso['cultivo_nombre_comun'];
	        $cultivoNombreCientifico = $datosUso['cultivo_nombre_cientifico'];
	        $dosis = $datosUso['dosis'];
	        $unidadDosis = $datosUso['unidad_dosis'];	        
	        $periodoCarencia = $datosUso['periodo_carencia'];
	        $gastoAgua = $datosUso['gasto_agua'];
	        $unidadGastoAgua = $datosUso['unidad_gasto_agua'];
	        
	        $filaUso .=
	        '<tr id="fila' . $idUso . '">
                    <td>' . $plagaNombreComun . '</td>
                    <td>' . $plagaNombreCientifico . '</td>
                    <td>' . $cultivoNombreComun . '</td>
                    <td>' . $cultivoNombreCientifico . '</td>
                    <td>' . $periodoCarencia . '</td>
                    <td>' . $gastoAgua . ' ' . $unidadGastoAgua . '</td>
                    <td>' . $dosis . ' ' . $unidadDosis . '</td>';
	        if ($banderaAcciones) {
	            $filaUso .=
	            '<td class="borrar">
                        <button type="button" name="eliminar" class="icono" onclick="fn_eliminarUsoPlaguicidaBio(' . $idUso . '); return false;"/>
                    </td>';
	        }
	        $filaUso .= '</tr>';
	    }
	    
	    return '
            <fieldset  id="fUsoPlaguicidaBio">
                <legend>Uso autorizado</legend>
                ' . $ingresoDatos . '
                <table id="tUsoPlaguicidaBio" style="width: 100%">
                    <thead>
    					<tr>
    						<th colspan="2">Cultivo</th>    					
    						<th colspan="2">Plaga</th>    					
    						<th colspan="3"></th>
    						<th colspan="1"></th>
    					</tr>
    					<tr>
    						<th>Nombre común</th>
    						<th>Nombre científico</th>    					
    						<th>Nombre común</th>
    						<th>Nombre científico</th>    					
    						<th>Período de carencia</th>
    						<th>Gasto de agua</th>
    						<th>Dosis</th>    						
    						<th></th>
    					</tr>
    				</thead>
                    <tbody>' . $filaUso . '</tbody>
                </table>
            </fieldset>';
	}
	
	/**
	 * Método generar fila de usos
	 */
	public function generarFilaUso($idUso, $datosUso)
	{
	    $this->listaDetalles = '
                        <tr id="fila' . $idUso . '">
                            <td>' . $datosUso['plaga_nombre_comun'] . '</td>
                            <td>' . $datosUso['plaga_nombre_cientifico'] . '</td>
                            <td>' . $datosUso['cultivo_nombre_comun'] . '</td>
                            <td>' . $datosUso['cultivo_nombre_cientifico'] . '</td>
                            <td>' . $datosUso['periodo_carencia'] . '</td>
                            <td>' . $datosUso['gasto_agua'] . ' '. $datosUso['unidad_gasto_agua'] . '</td>
                            <td>' . $datosUso['dosis'] . ' ' . $datosUso['unidad_dosis'] . '</td>
                            <td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarUsoPlaguicidaBio(' . $idUso . '); return false;"/></td>
                        </tr>';
	    
	    return $this->listaDetalles;
	}

}
