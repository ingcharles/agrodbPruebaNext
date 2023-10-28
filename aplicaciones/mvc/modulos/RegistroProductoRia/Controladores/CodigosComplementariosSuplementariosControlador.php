<?php
/**
 * Controlador CodigosComplementariosSuplementarios
 *
 * Este archivo controla la lógica del negocio del modelo:  CodigosComplementariosSuplementariosModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-20
 * @uses    CodigosComplementariosSuplementariosControlador
 * @package RegistroProductoRia
 * @subpackage Controladores
 */

namespace Agrodb\RegistroProductoRia\Controladores;

use Agrodb\RegistroProductoRia\Modelos\CodigosComplementariosSuplementariosLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\CodigosComplementariosSuplementariosModelo;

class CodigosComplementariosSuplementariosControlador extends BaseControlador
{

    private $lNegocioCodigosComplementariosSuplementarios = null;
    private $modeloCodigosComplementariosSuplementarios = null;
    private $accion = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioCodigosComplementariosSuplementarios = new CodigosComplementariosSuplementariosLogicaNegocio();
        $this->modeloCodigosComplementariosSuplementarios = new CodigosComplementariosSuplementariosModelo();
        set_exception_handler(array($this, 'manejadorExcepciones'));
    }

    /**
     * Método de inicio del controlador
     */
    public function index()
    {
        $modeloCodigosComplementariosSuplementarios = $this->lNegocioCodigosComplementariosSuplementarios->buscarCodigosComplementariosSuplementarios();
        $this->tablaHtmlCodigosComplementariosSuplementarios($modeloCodigosComplementariosSuplementarios);
        require APP . 'RegistroProductoRia/vistas/listaCodigosComplementariosSuplementariosVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nuevo CodigosComplementariosSuplementarios";
        require APP . 'RegistroProductoRia/vistas/formularioCodigosComplementariosSuplementariosVista.php';
    }

    /**
     * Método para registrar en la base de datos -CodigosComplementariosSuplementarios
     */
    public function guardar()
    {
        $this->lNegocioCodigosComplementariosSuplementarios->guardar($_POST);
    }

    /**
     *Obtenemos los datos del registro seleccionado para editar - Tabla: CodigosComplementariosSuplementarios
     */
    public function editar()
    {
        $this->accion = "Editar CodigosComplementariosSuplementarios";
        $this->modeloCodigosComplementariosSuplementarios = $this->lNegocioCodigosComplementariosSuplementarios->buscar($_POST["id"]);
        require APP . 'RegistroProductoRia/vistas/formularioCodigosComplementariosSuplementariosVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - CodigosComplementariosSuplementarios
     */
    public function borrar()
    {
        $this->lNegocioCodigosComplementariosSuplementarios->borrar($_POST['elementos']);
    }

    /**
     * Construye el código HTML para desplegar la lista de - CodigosComplementariosSuplementarios
     */
    public function tablaHtmlCodigosComplementariosSuplementarios($tabla)
    {
        $contador = 0;
        foreach ($tabla as $fila) {
            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_codigo_complementario_suplementario'] . '"
                      class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia\codigoscomplementariossuplementarios"
                      data-opcion="editar" ondragstart="drag(event)" draggable="true"
                      data-destino="detalleItem">
                      <td>' . ++$contador . '</td>
                      <td style="white - space:nowrap; "><b>' . $fila['id_codigo_complementario_suplementario'] . '</b></td>
                      <td>' . $fila['id_solicitud_registro_producto'] . '</td>
                      <td>' . $fila['codigo_complementario'] . '</td>
                      <td>' . $fila['codigo_suplementario'] . '</td>
                </tr>');
        }
    }

    public function crearCodigoComplementarioSuplementarioProducto($parametros, $estado)
    {
        
        $idSolicitudRegistroProducto = $parametros['id_solicitud_registro_producto'];

        $banderaAcciones = false;
        $ingresoDatos = '';
        $filaCodigoComplementarioSuplementario = '';

        switch ($estado) {
            case 'creado':
            case 'subsanacion':

                $banderaAcciones = true;

                $ingresoDatos = '<div data-linea="1">
                                    <label>Código complementario: </label>									
                                    <select id="codigo_complementario" name="codigo_complementario" class="validacion">
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
                                <div data-linea="2">
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
                                <div data-linea="3">
                        			<button type="button" class="mas" id="agregarCodigoComplemenarioSuplementario">Agregar</button>
                        		</div>';
                break;
        }

        $arrayConsulta = [
            'id_solicitud_registro_producto' => $idSolicitudRegistroProducto
        ];

        $qDatosCodigoComplementarioSuplementario = $this->lNegocioCodigosComplementariosSuplementarios->buscarLista($arrayConsulta);

        foreach ($qDatosCodigoComplementarioSuplementario as $codigoComplementarioSuplementario) {

            $idCodigoComplementarioSuplementario = $codigoComplementarioSuplementario['id_codigo_complementario_suplementario'];
            $codigoComplementario = $codigoComplementarioSuplementario['codigo_complementario'];
            $codigoSuplementario = $codigoComplementarioSuplementario['codigo_suplementario'];

            $filaCodigoComplementarioSuplementario .=
                '<tr id="fila' . $idCodigoComplementarioSuplementario . '">
                    <td>' . $codigoComplementario . '</td>
                    <td>' . $codigoSuplementario . '</td>';
            if ($banderaAcciones) {
                $filaCodigoComplementarioSuplementario .=
                    '<td class="borrar">
                        <button type="button" name="eliminar" class="icono" onclick="fn_eliminarCodigoComplementarioSuplementario(' . $idCodigoComplementarioSuplementario . '); return false;"/>
                    </td>';
            }
            $filaCodigoComplementarioSuplementario .= '</tr>';
        }

        return '
            <fieldset  id="fCodigoComplementarioSuplementarioProducto">
                <legend>Código complementario y suplementario</legend>
                ' . $ingresoDatos . '
                <table id="tCodigoComplementarioSuplementarioProducto" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Código complementario</th>
                            <th>Código suplementario</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>' . $filaCodigoComplementarioSuplementario . '</tbody>
                </table>
            </fieldset>';
    }

    /**
     * Método generar fila de composiciones
     */
    public function generarFilaCodigoComplementarioSuplementarioProducto($idCodigoComplementarioSuplementarioProducto, $datosCodigoComplementarioSuplementarioProducto)
    {
        $this->listaDetalles = '
                        <tr id="fila' . $idCodigoComplementarioSuplementarioProducto . '">
                            <td>' . $datosCodigoComplementarioSuplementarioProducto['codigo_complementario'] . '</td>
                            <td>' . $datosCodigoComplementarioSuplementarioProducto['codigo_suplementario'] . '</td>
                            <td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarCodigoComplementarioSuplementario(' . $idCodigoComplementarioSuplementarioProducto . '); return false;"/></td>
                        </tr>';

        return $this->listaDetalles;
    }
}
