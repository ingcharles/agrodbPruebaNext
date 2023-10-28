<?php
/**
 * Controlador FabricantesFormuladores
 *
 * Este archivo controla la lógica del negocio del modelo:  FabricantesFormuladoresModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-20
 * @uses    FabricantesFormuladoresControlador
 * @package RegistroProductoRia
 * @subpackage Controladores
 */

namespace Agrodb\RegistroProductoRia\Controladores;

use Agrodb\RegistroProductoRia\Modelos\FabricantesFormuladoresLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\FabricantesFormuladoresModelo;

class FabricantesFormuladoresControlador extends BaseControlador
{

    private $lNegocioFabricantesFormuladores = null;
    private $modeloFabricantesFormuladores = null;
    private $accion = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioFabricantesFormuladores = new FabricantesFormuladoresLogicaNegocio();
        $this->modeloFabricantesFormuladores = new FabricantesFormuladoresModelo();
        set_exception_handler(array($this, 'manejadorExcepciones'));
    }

    /**
     * Método de inicio del controlador
     */
    public function index()
    {
        $modeloFabricantesFormuladores = $this->lNegocioFabricantesFormuladores->buscarFabricantesFormuladores();
        $this->tablaHtmlFabricantesFormuladores($modeloFabricantesFormuladores);
        require APP . 'RegistroProductoRia/vistas/listaFabricantesFormuladoresVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nuevo FabricantesFormuladores";
        require APP . 'RegistroProductoRia/vistas/formularioFabricantesFormuladoresVista.php';
    }

    /**
     * Método para registrar en la base de datos -FabricantesFormuladores
     */
    public function guardar()
    {
        $this->lNegocioFabricantesFormuladores->guardar($_POST);
    }

    /**
     *Obtenemos los datos del registro seleccionado para editar - Tabla: FabricantesFormuladores
     */
    public function editar()
    {
        $this->accion = "Editar FabricantesFormuladores";
        $this->modeloFabricantesFormuladores = $this->lNegocioFabricantesFormuladores->buscar($_POST["id"]);
        require APP . 'RegistroProductoRia/vistas/formularioFabricantesFormuladoresVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - FabricantesFormuladores
     */
    public function borrar()
    {
        $this->lNegocioFabricantesFormuladores->borrar($_POST['elementos']);
    }

    /**
     * Construye el código HTML para desplegar la lista de - FabricantesFormuladores
     */
    public function tablaHtmlFabricantesFormuladores($tabla)
    {
        $contador = 0;
        foreach ($tabla as $fila) {
            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_fabricante_formulador'] . '"
                    class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia\fabricantesformuladores"
                    data-opcion="editar" ondragstart="drag(event)" draggable="true"
                    data-destino="detalleItem">
                    <td>' . ++$contador . '</td>
                    <td style="white - space:nowrap; "><b>' . $fila['id_fabricante_formulador'] . '</b></td>
                    <td>'. $fila['id_solicitud_registro_producto'] . '</td>
                    <td>' . $fila['nombre'] . '</td>
                    <td>' . $fila['tipo'] . '</td>
                </tr>');
        }
    }

    public function crearFabricanteFormuladorProducto($parametros, $estado, $datoOrigen = null)
    {
        
        $idSolicitudRegistroProducto = $parametros['id_solicitud_registro_producto'];
        $tipoSolicitud = $parametros['tipo_solicitud'];

        $banderaAcciones = false;
        $ingresoDatos = '';
        $filaFabricanteFormulador = '';
        $ingresoBoton = '';
        $colspan = '';
		$fabricanteFormulador = '';
        
        switch ($estado) {
            case 'creado':
            case 'subsanacion':

                $banderaAcciones = true;
				
				if($tipoSolicitud === "fertilizantes"){
                	$fabricanteFormulador = '<option value="Titular del registro">Titular del registro</option>
									<option value="Elaborador por Contrato Nacional">Elaborador por Contrato Nacional</option>
									<option value="Extranjero">Extranjero</option>';
                }else{                	
                	$fabricanteFormulador = '<option value="Fabricante">Fabricante</option>
                                        <option value="Formulador">Formulador</option>';                	
                }

                $ingresoDatos = '<div data-linea="1">
                                    <label>Tipo: </label>									
                                    <select id="tipo" name="tipo" class="validacion" required>
									<option value="">Seleccione....</option>'
									. $fabricanteFormulador .																				  												  
                                    '</select>
                                </div>
                                <div data-linea="2">
                                    <label>Nombre: </label>
                                        <input type="text" name="nombre_fabricante_formulador" id="nombre_fabricante_formulador" class="validacion" required/>
                                </div>
                                <div data-linea="3">
                                    <label>País origen: </label>
                                    <select id="id_pais_origen" name="id_pais_origen" class="validacion" required>
                                        <option value="">Seleccione....</option>
                                        ' . $this->comboPaises() . '
                                    </select>
                                    <input type="hidden" name="nombre_pais_origen" id="nombre_pais_origen" />
                                </div>
                                <div data-linea="4">
                        			<button type="button" class="mas" id="agregarFabricanteFormulador">Agregar</button>
                        		</div>';
                break;
        }

        $arrayConsulta = [
            'id_solicitud_registro_producto' => $idSolicitudRegistroProducto
        ];

        $qDatosFabricanteFormulador = $this->lNegocioFabricantesFormuladores->buscarLista($arrayConsulta);

        foreach ($qDatosFabricanteFormulador as $datosFabricanteFormulador) {

            $idFabricanteFormulador = $datosFabricanteFormulador['id_fabricante_formulador'];
            $tipo = $datosFabricanteFormulador['tipo'];
            $nombre = $datosFabricanteFormulador['nombre'];
            $nombrePais = $datosFabricanteFormulador['pais_origen'];
            
            if($tipoSolicitud === "bioplaguicidas"){
                $colspan = 'colspan="2"';
                $ingresoBoton = '<td style="width: 20px;" class="abrir">
                <form class="abrir" data-rutaAplicacion="'. URL_MVC_FOLDER .'RegistroProductoRia" data-opcion="ManufacturadoresPlaguicidasBio/manufacturador" data-destino="detalleItem" data-accionEnExito="NADA" >
                <input type="hidden" name="id_fabricante_formulador" value="' . $idFabricanteFormulador . '" >
                <input type="hidden" name="id_solicitud_registro_producto" value="' . $idSolicitudRegistroProducto . '" >
                <input type="hidden" name="dato_origen" value="' . $datoOrigen . '" readonly="readonly"/>
                <button class="icono" type="submit" ></button>
                </form>
                </td>';
            }            
            
            $filaFabricanteFormulador .=
                '<tr id="fila' . $idFabricanteFormulador . '">
                    <td>' . $tipo . '</td>
                    <td>' . $nombre . '</td>
                    <td>' . $nombrePais . '</td>' . $ingresoBoton;
            if ($banderaAcciones) {
                $filaFabricanteFormulador .= '<td class="borrar">
                        <button type="button" name="eliminar" class="icono" onclick="fn_eliminarFabricanteFormulador(' . $idFabricanteFormulador . '); return false;"/>
                    </td>';
            }
            $filaFabricanteFormulador .= '</tr>';
        }

        return '
            <fieldset  id="fFabricanteFormuladorProducto">
                <legend>Fabricante/formulador</legend>
                ' . $ingresoDatos . '
                <table id="tFabricanteFormuladorProducto" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>País</th>
                            <th ' . $colspan . '></th>
                            <th ' . $colspan . '></th>
                        </tr>
                    </thead>
                    <tbody>' . $filaFabricanteFormulador . '</tbody>
                </table>
            </fieldset>';
    }

    /**
     * Método para listar titularidad de producto agregada
     */
    public function generarFilaFabricanteFormuladorProducto($idFabricanteFormuladorProducto, $datosFabricanteProducto, $datoOrigen)
    {
        $ingresoBoton = '';
        $tipoSolicitud = $datosFabricanteProducto['tipo_solicitud'];
        
        if($tipoSolicitud === "bioplaguicidas"){
            $ingresoBoton = '<td style="width: 20px;" class="abrir">
                <form class="abrir" data-rutaAplicacion="'. URL_MVC_FOLDER .'RegistroProductoRia" data-opcion="ManufacturadoresPlaguicidasBio/manufacturador" data-destino="detalleItem" data-accionEnExito="NADA" >
                <input type="hidden" name="id_fabricante_formulador" value="' . $idFabricanteFormuladorProducto . '" >
                <input type="hidden" name="id_solicitud_registro_producto" value="' . $datosFabricanteProducto['id_solicitud_registro_producto'] . '" >
                <input type="hidden" name="dato_origen" value="' . $datoOrigen . '" readonly="readonly"/>
                <button class="icono" type="submit" ></button>
                </form>
                </td>';
        }
        
        $this->listaDetalles = '
                        <tr id="fila' . $idFabricanteFormuladorProducto . '">
                            <td>' . $datosFabricanteProducto['tipo'] . '</td>
                            <td>' . $datosFabricanteProducto['nombre'] . '</td>
                            <td>' . $datosFabricanteProducto['pais_origen'] . '</td>'
                            . $ingresoBoton . '<td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarFabricanteFormulador(' . $idFabricanteFormuladorProducto . '); return false;"/></td>
                        </tr>';

        return $this->listaDetalles;
    }

}
