<?php
/**
 * Controlador Composiciones
 *
 * Este archivo controla la lógica del negocio del modelo:  ComposicionesModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-20
 * @uses    ComposicionesControlador
 * @package RegistroProductoRia
 * @subpackage Controladores
 */

namespace Agrodb\RegistroProductoRia\Controladores;

use Agrodb\RegistroProductoRia\Modelos\ComposicionesLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\ComposicionesModelo;

class ComposicionesControlador extends BaseControlador
{

    private $lNegocioComposiciones = null;
    private $modeloComposiciones = null;
    private $accion = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioComposiciones = new ComposicionesLogicaNegocio();
        $this->modeloComposiciones = new ComposicionesModelo();
        set_exception_handler(array($this, 'manejadorExcepciones'));
    }

    /**
     * Método de inicio del controlador
     */
    public function index()
    {
        $modeloComposiciones = $this->lNegocioComposiciones->buscarComposiciones();
        $this->tablaHtmlComposiciones($modeloComposiciones);
        require APP . 'RegistroProductoRia/vistas/listaComposicionesVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nuevo Composiciones";
        require APP . 'RegistroProductoRia/vistas/formularioComposicionesVista.php';
    }

    /**
     * Método para registrar en la base de datos -Composiciones
     */
    public function guardar()
    {
        $this->lNegocioComposiciones->guardar($_POST);
    }

    /**
     *Obtenemos los datos del registro seleccionado para editar - Tabla: Composiciones
     */
    public function editar()
    {
        $this->accion = "Editar Composiciones";
        $this->modeloComposiciones = $this->lNegocioComposiciones->buscar($_POST["id"]);
        require APP . 'RegistroProductoRia/vistas/formularioComposicionesVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - Composiciones
     */
    public function borrar()
    {
        $this->lNegocioComposiciones->borrar($_POST['elementos']);
    }

    /**
     * Construye el código HTML para desplegar la lista de - Composiciones
     */
    public function tablaHtmlComposiciones($tabla)
    {
        $contador = 0;
        foreach ($tabla as $fila) {
            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_composicion'] . '"
                          class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia\composiciones"
                          data-opcion="editar" ondragstart="drag(event)" draggable="true"
                          data-destino="detalleItem">
                          <td>' . ++$contador . '</td>
                          <td style="white - space:nowrap; "><b>' . $fila['id_composicion'] . '</b></td>
                          <td>' . $fila['id_solicitud_registro_producto'] . '</td>
                          <td>' . $fila['id_tipo_componente'] . '</td>
                          <td>' . $fila['tipo_componente'] . '</td>
                    </tr>');
        }
    }

    public function crearComposicionProducto($parametros, $estado)
    {
        $idArea = $parametros['id_area'];
        $idSolicitudRegistroProducto = $parametros['id_solicitud_registro_producto'];

        $banderaAcciones = false;
        $ingresoDatos = '';
        $filaComposicion = '';

        switch ($estado) {
            case 'creado':
            case 'subsanacion':

                $banderaAcciones = true;

                $ingresoDatos = '<div data-linea="1">
                                    <label>Tipo: </label>									
                                    <select id="id_tipo_componente" name="id_tipo_componente" class="validacion" required>
                                        <option value="">Seleccione....</option>' . $this->comboTipoComponente($idArea) . '
                                    </select>
                                    <input type="hidden" name="tipo_componente" id="tipo_componente" />
                                </div>
                                <div data-linea="2">
                                    <label>Nombre: </label>
                                        <select id="id_ingrediente_activo" name="id_ingrediente_activo" class="validacion" required style="width: 419px;">
                                        <option value="">Seleccione....</option>' . (($idArea === "IAF") ? $this->comboIngredienteActivo($idArea) : "") . '                                                     
                                    </select>
                                    <input type="hidden" name="ingrediente_activo" id="ingrediente_activo" />
                                </div>
                                <div data-linea="3">
                                    <label>Concentración: </label>
                                    <input type="text" name="concentracion" id="concentracion" class="validacion" required/>
                                </div>
                                <div data-linea="4">
                                    <label>Unidad: </label>
                                    <select id="unidad_medida" name="unidad_medida" required class="validacion">
                                        <option value="">Seleccione....</option>' . $this->comboUnidadesMedida() . '
                                    </select>
                                </div>
                                <div data-linea="5">
                        			<button type="button" class="mas" id="agregarComposicion">Agregar</button>
                        		</div>';
                break;
        }

        $arrayConsulta = [
            'id_solicitud_registro_producto' => $idSolicitudRegistroProducto
        ];

        $qDatosComposicion = $this->lNegocioComposiciones->buscarLista($arrayConsulta);

        foreach ($qDatosComposicion as $datosComposicion) {

            $idComposicion = $datosComposicion['id_composicion'];
            $ingredienteActivo = $datosComposicion['ingrediente_activo'];
            $tipoComponente = $datosComposicion['tipo_componente'];
            $concentracion = $datosComposicion['concentracion'];
            $unidadMedida = $datosComposicion['unidad_medida'];

            $filaComposicion .=
                '<tr id="fila' . $idComposicion . '">
                    <td>' . $tipoComponente . '</td>
                    <td>' . $ingredienteActivo . '</td>
                    <td>' . $concentracion . ' ' . $unidadMedida . '</td>';
            if ($banderaAcciones) {
                $filaComposicion .=
                    '<td class="borrar">
                        <button type="button" name="eliminar" class="icono" onclick="fn_eliminarComposicion(' . $idComposicion . '); return false;"/>
                    </td>';
            }
            $filaComposicion .= '</tr>';
        }

        return '
            <fieldset  id="fComposicionProducto">
                <legend>Composición</legend>
                ' . $ingresoDatos . '
                <table id="tComposicionProducto" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Concentración</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>' . $filaComposicion . '</tbody>
                </table>
            </fieldset>';
    }

    /**
     * Método generar fila de composiciones
     */
    public function generarFilaComposicionProducto($idComposicionProducto, $datosComposicionProducto)
    {
        $this->listaDetalles = '
                        <tr id="fila' . $idComposicionProducto . '">
                            <td>' . $datosComposicionProducto['tipo_componente'] . '</td>
                            <td>' . $datosComposicionProducto['ingrediente_activo'] . '</td>
                            <td>' . $datosComposicionProducto['concentracion'] . ' ' . $datosComposicionProducto['unidad_medida'] . '</td>
                            <td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarComposicion(' . $idComposicionProducto . '); return false;"/></td>
                        </tr>';

        return $this->listaDetalles;
    }
	
	 /**
     * Método para obtener nombre composiciones
     */
    public function obtenerNombreTipoComposicion()
    {
        $validacion = "";
        $mensaje = "";
        $resultado = "";
        $comboTipoComposicion = "";
                
        $idArea = 'IAP';
        $tipoComposicion = $_POST['tipoComposicion'];
        
        $comboTipoComposicion .= '<select id="id_ingrediente_activo" name="id_ingrediente_activo">
                                    <option value="">Seleccione...</option>';
        
        if($tipoComposicion === "Ingrediente activo"){
            $comboTipoComposicion .= $this->comboIngredienteActivo($idArea);
        }else{
            $comboTipoComposicion .= $this->comboAditivoToxicologico($idArea);
        }
        
        $comboTipoComposicion .= '</select>';
            
        $validacion = 'Exito';
        $resultado = $comboTipoComposicion;        
        
        echo json_encode(array(
            'validacion' => $validacion,
            'mensaje' => $mensaje,
            'resultado' => $resultado
        ));
    }
}
