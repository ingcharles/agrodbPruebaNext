<?php
/**
 * Controlador Usos
 *
 * Este archivo controla la lógica del negocio del modelo:  UsosModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-20
 * @uses    UsosControlador
 * @package RegistroProductoRia
 * @subpackage Controladores
 */

namespace Agrodb\RegistroProductoRia\Controladores;

use Agrodb\RegistroProductoRia\Modelos\UsosLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\UsosModelo;

class UsosControlador extends BaseControlador
{

    private $lNegocioUsos = null;
    private $modeloUsos = null;
    private $accion = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioUsos = new UsosLogicaNegocio();
        $this->modeloUsos = new UsosModelo();
        set_exception_handler(array($this, 'manejadorExcepciones'));
    }

    /**
     * Método de inicio del controlador
     */
    public function index()
    {
        $modeloUsos = $this->lNegocioUsos->buscarUsos();
        $this->tablaHtmlUsos($modeloUsos);
        require APP . 'RegistroProductoRia/vistas/listaUsosVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nuevo Usos";
        require APP . 'RegistroProductoRia/vistas/formularioUsosVista.php';
    }

    /**
     * Método para registrar en la base de datos -Usos
     */
    public function guardar()
    {
        $this->lNegocioUsos->guardar($_POST);
    }

    /**
     *Obtenemos los datos del registro seleccionado para editar - Tabla: Usos
     */
    public function editar()
    {
        $this->accion = "Editar Usos";
        $this->modeloUsos = $this->lNegocioUsos->buscar($_POST["id"]);
        require APP . 'RegistroProductoRia/vistas/formularioUsosVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - Usos
     */
    public function borrar()
    {
        $this->lNegocioUsos->borrar($_POST['elementos']);
    }

    /**
     * Construye el código HTML para desplegar la lista de - Usos
     */
    public function tablaHtmlUsos($tabla)
    {
        $contador = 0;
        foreach ($tabla as $fila) {
            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_uso'] . '"
                    class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia\usos"
                    data-opcion="editar" ondragstart="drag(event)" draggable="true"
                    data-destino="detalleItem">
                    <td>' . ++$contador . '</td>
                    <td style="white - space:nowrap; "><b>' . $fila['id_uso'] . '</b></td>
                    <td>' . $fila['id_solicitud_registro_producto'] . '</td>
                    <td>' . $fila['id_uso_aplicado'] . '</td>
                    <td>' . $fila['aplicado_a'] . '</td>
                </tr>');
        }
    }

    public function crearUsoProducto($parametros, $estado)
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

                $ingresoDatos = '<div data-linea="17">
                                    <label>Aplicado a: </label>
                                    <select id="aplicado_a" name="aplicado_a" required class="validacion">
							            <option value="">Seleccione....</option>
                                        <option value="Instalacion">Instalación</option>
                                        <option value="Producto">Producto</option>
						            </select>
                                </div>
                                <div data-linea="18">
                                    <label>Uso</label>
                                    <select id="id_uso_producto" name="id_uso_producto" required class="validacion">
                                        <option value="">Seleccione....</option>
                                        ' . $this->comboUsos($idArea) . '
                                    </select>
                                    <input type="hidden" name="nombre_uso" id="nombre_uso"/>
                                    <input type="hidden" name="id_area" id="id_area" value="' . $idArea . '" />
                                </div>
                                <div data-linea="19" class="UsoInstalacion" style="display: none">	
                                    <label>Instalación</label>
						            <input type="text" id="instalacion"  class="validacion"/>
                                </div>
                                <div data-linea="20" class="UsoProducto" style="display: none">	
                                    <label>Producto</label>
						            <input type="text" id="instalacion_producto"  class="validacion"/>
                                </div>
                                <div data-linea="4">
                        			<button type="button" class="mas" id="agregarUso">Agregar</button>
                        		</div>';
                break;
        }

        $arrayConsulta = [
            'id_solicitud_registro_producto' => $idSolicitudRegistroProducto
        ];

        $qDatosUso = $this->lNegocioUsos->buscarLista($arrayConsulta);

        foreach ($qDatosUso as $datosUso) {

            $idUso = $datosUso['id_uso'];
            $nombreUso = $datosUso['nombre_uso'];
            $aplicadoA = $datosUso['aplicado_a'];
            $instalacion = $datosUso['instalacion'];

            $filaUso .=
                '<tr id="fila' . $idUso . '">
                    <td>' . $nombreUso . '</td>
                    <td>' . $aplicadoA . '</td>
                    <td>' . $instalacion . '</td>';
            if ($banderaAcciones) {
                $filaUso .=
                    '<td class="borrar">
                        <button type="button" name="eliminar" class="icono" onclick="fn_eliminarUso(' . $idUso . '); return false;"/>
                    </td>';
            }
            $filaUso .= '</tr>';
        }

        return '
            <fieldset  id="fUsoProducto">
                <legend>Uso Autorizado</legend>
                ' . $ingresoDatos . '
                <table id="tUsoProducto" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Uso</th>
                            <th>Aplicado a</th>
                            <th>Instalación/Producto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>' . $filaUso . '</tbody>
                </table>
            </fieldset>';
    }

    /**
     * Método para listar titularidad de producto agregada
     */
    public function generarFilaUsoProductoFertilizante($idUsoProducto, $datosUsoProducto)
    {
        $this->listaDetalles = '
                        <tr id="fila' . $idUsoProducto . '">
                            <td>' . $datosUsoProducto['nombre_uso'] . '</td>
                        <td>' . $datosUsoProducto['aplicado_a'] . '</td>
                        <td>' . $datosUsoProducto['instalacion'] . '</td>
                            <td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarUso(' . $idUsoProducto . '); return false;"/></td>
                        </tr>';

        return $this->listaDetalles;
    }

}
