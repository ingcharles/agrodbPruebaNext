<?php
/**
 * Controlador Presentaciones
 *
 * Este archivo controla la lógica del negocio del modelo:  PresentacionesModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-20
 * @uses    PresentacionesControlador
 * @package RegistroProductoRia
 * @subpackage Controladores
 */

namespace Agrodb\RegistroProductoRia\Controladores;

use Agrodb\RegistroProductoRia\Modelos\PresentacionesLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\PresentacionesModelo;

class PresentacionesControlador extends BaseControlador
{

    private $lNegocioPresentaciones = null;
    private $modeloPresentaciones = null;
    private $accion = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioPresentaciones = new PresentacionesLogicaNegocio();
        $this->modeloPresentaciones = new PresentacionesModelo();
        set_exception_handler(array($this, 'manejadorExcepciones'));
    }

    /**
     * Método de inicio del controlador
     */
    public function index()
    {
        $modeloPresentaciones = $this->lNegocioPresentaciones->buscarPresentaciones();
        $this->tablaHtmlPresentaciones($modeloPresentaciones);
        require APP . 'RegistroProductoRia/vistas/listaPresentacionesVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nuevo Presentaciones";
        require APP . 'RegistroProductoRia/vistas/formularioPresentacionesVista.php';
    }

    /**
     * Método para registrar en la base de datos -Presentaciones
     */
    public function guardar()
    {
        $this->lNegocioPresentaciones->guardar($_POST);
    }

    /**
     *Obtenemos los datos del registro seleccionado para editar - Tabla: Presentaciones
     */
    public function editar()
    {
        $this->accion = "Editar Presentaciones";
        $this->modeloPresentaciones = $this->lNegocioPresentaciones->buscar($_POST["id"]);
        require APP . 'RegistroProductoRia/vistas/formularioPresentacionesVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - Presentaciones
     */
    public function borrar()
    {
        $this->lNegocioPresentaciones->borrar($_POST['elementos']);
    }

    /**
     * Construye el código HTML para desplegar la lista de - Presentaciones
     */
    public function tablaHtmlPresentaciones($tabla)
    {
        $contador = 0;
        foreach ($tabla as $fila) {
            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_presentacion'] . '"
                        class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia\presentaciones"
                        data-opcion="editar" ondragstart="drag(event)" draggable="true"
                        data-destino="detalleItem">
                        <td>' . ++$contador . '</td>
                        <td style="white - space:nowrap; "><b>' . $fila['id_presentacion'] . '</b></td>
                        <td>' . $fila['id_solicitud_registro_producto'] . '</td>
                        <td>' . $fila['presentacion'] . '</td>
                        <td>' . $fila['unidad_medida'] . '</td>
                    </tr>');
        }
    }

    public function crearPresentacionProducto($parametros, $estado)
    {
        $idArea = $parametros['id_area'];
        $idSolicitudRegistroProducto = $parametros['id_solicitud_registro_producto'];

        $banderaAcciones = false;
        $ingresoDatos = '';
        $filaPresentacion = '';

        switch ($estado) {
            case 'creado':
            case 'subsanacion':

                $banderaAcciones = true;

                $ingresoDatos = '<div data-linea="1">
                                    <label>Presentación: </label>
                                    <input type="text" name="presentacion" id="presentacion" class="validacion" required/>
                                </div>
                                <div data-linea="2">
                                    <label>Unidad: </label>
                                    <select id="unidad_medida_presentacion" name="unidad_medida_presentacion" class="validacion" required>
                                        <option value="">Seleccione....</option>
                                        ' . $this->comboUnidadesMedida() . '
                                    </select>
                               </div>
                                <div data-linea="3">
                        			<button type="button" class="mas" id="agregarPresentacion">Agregar</button>
                        		</div>';
                break;
        }

        $arrayConsulta = [
            'id_solicitud_registro_producto' => $idSolicitudRegistroProducto
        ];

        $qDatosPresentacion = $this->lNegocioPresentaciones->buscarLista($arrayConsulta);

        foreach ($qDatosPresentacion as $datosPresentacion) {

            $idPresentacion = $datosPresentacion['id_presentacion'];
            $subcodigo = $datosPresentacion['subcodigo'];
            $presentacion = $datosPresentacion['presentacion'];
            $unidadMedida = $datosPresentacion['unidad_medida'];

            $filaPresentacion .=
                '<tr id="fila' . $idPresentacion . '">
                    <td>' . $subcodigo . '</td>
                    <td>' . $presentacion . '</td>
                    <td>' . $unidadMedida . '</td>';
            if ($banderaAcciones) {
                $filaPresentacion .=
                    '<td class="borrar">
                        <button type="button" name="eliminar" class="icono" onclick="fn_eliminarPresentacion(' . $idPresentacion . '); return false;"/>
                    </td>';
            }
            $filaPresentacion .= '</tr>';
        }

        return '
            <fieldset  id="fPresentacionProducto">
                <legend>Presentación</legend>
                ' . $ingresoDatos . '
                <table id="tPresentacionProducto" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Subcodigo</th>
                            <th>Presentación</th>
                            <th>Unidad</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>' . $filaPresentacion . '</tbody>
                </table>
            </fieldset>';
    }

    /**
     * Método para listar titularidad de producto agregada
     */
    public function generarFilaPresentacion($idPresentacion, $datosPresentacion)
    {

        $subcodigo = $datosPresentacion['subcodigo'];
        $presentacion = $datosPresentacion['presentacion'];
        $unidadMedida = $datosPresentacion['unidad_medida'];

        $this->listaDetalles = '
                        <tr id="fila' . $idPresentacion . '">
                            <td>' . $subcodigo . '</td>
                            <td>' . $presentacion . ' </td>
                            <td>' . $unidadMedida . ' </td>
                            <td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarPresentacion(' . $idPresentacion . '); return false;"/></td>
                        </tr>';

        return $this->listaDetalles;
    }
}
