<?php
/**
 * Controlador EnsayosEficaciaPlaguicidasBio
 *
 * Este archivo controla la lógica del negocio del modelo:  EnsayosEficaciaPlaguicidasBioModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-12-22
 * @uses    EnsayosEficaciaPlaguicidasBioControlador
 * @package RegistroProductoRia
 * @subpackage Controladores
 */

namespace Agrodb\RegistroProductoRia\Controladores;

use Agrodb\RegistroProductoRia\Modelos\EnsayosEficaciaPlaguicidasBioLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\EnsayosEficaciaPlaguicidasBioModelo;
use Agrodb\EnsayoEficacia\Modelos\SolicitudesLogicaNegocio;

class EnsayosEficaciaPlaguicidasBioControlador extends BaseControlador
{

    private $lNegocioEnsayosEficaciaPlaguicidasBio = null;
    private $modeloEnsayosEficaciaPlaguicidasBio = null;
	private $lNegocioEnsayoEficacia = null;
    private $accion = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioEnsayosEficaciaPlaguicidasBio = new EnsayosEficaciaPlaguicidasBioLogicaNegocio();
        $this->modeloEnsayosEficaciaPlaguicidasBio = new EnsayosEficaciaPlaguicidasBioModelo();
		$this->lNegocioEnsayoEficacia = new SolicitudesLogicaNegocio();
        set_exception_handler(array($this, 'manejadorExcepciones'));
    }

    /**
     * Método de inicio del controlador
     */
    public function index()
    {
        $modeloEnsayosEficaciaPlaguicidasBio = $this->lNegocioEnsayosEficaciaPlaguicidasBio->buscarEnsayosEficaciaPlaguicidasBio();
        $this->tablaHtmlEnsayosEficaciaPlaguicidasBio($modeloEnsayosEficaciaPlaguicidasBio);
        require APP . 'RegistroProductoRia/vistas/listaEnsayosEficaciaPlaguicidasBioVista.php';
    }

    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevo()
    {
        $this->accion = "Nuevo EnsayosEficaciaPlaguicidasBio";
        require APP . 'RegistroProductoRia/vistas/formularioEnsayosEficaciaPlaguicidasBioVista.php';
    }

    /**
     * Método para registrar en la base de datos -EnsayosEficaciaPlaguicidasBio
     */
    public function guardar()
    {
        $this->lNegocioEnsayosEficaciaPlaguicidasBio->guardar($_POST);
    }

    /**
     *Obtenemos los datos del registro seleccionado para editar - Tabla: EnsayosEficaciaPlaguicidasBio
     */
    public function editar()
    {
        $this->accion = "Editar EnsayosEficaciaPlaguicidasBio";
        $this->modeloEnsayosEficaciaPlaguicidasBio = $this->lNegocioEnsayosEficaciaPlaguicidasBio->buscar($_POST["id"]);
        require APP . 'RegistroProductoRia/vistas/formularioEnsayosEficaciaPlaguicidasBioVista.php';
    }

    /**
     * Método para borrar un registro en la base de datos - EnsayosEficaciaPlaguicidasBio
     */
    public function borrar()
    {
        $this->lNegocioEnsayosEficaciaPlaguicidasBio->borrar($_POST['elementos']);
    }

    /**
     * Construye el código HTML para desplegar la lista de - EnsayosEficaciaPlaguicidasBio
     */
    public function tablaHtmlEnsayosEficaciaPlaguicidasBio($tabla)
    {
        {
            $contador = 0;
            foreach ($tabla as $fila) {
                $this->itemsFiltrados[] = array(
                    '<tr id="' . $fila['id_ensayo_eficacia'] . '"
                        class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'RegistroProductoRia\ensayoseficaciaplaguicidasbio"
                        data-opcion="editar" ondragstart="drag(event)" draggable="true"
                        data-destino="detalleItem">
                        <td>' . ++$contador . '</td>
                        <td style="white - space:nowrap; "><b>' . $fila['id_ensayo_eficacia'] . '</b></td>
                        <td>'. $fila['id_solicitud_registro_producto'] . '</td>
                        <td>' . $fila['numero_solicitud']. '</td>
                        <td>' . $fila['id_ensayo_eficacia'] . '</td>
                    </tr>');
            }
        }
    }

    public function crearEnsayoEficacia($parametros, $estado)
    {

        $idSolicitudRegistroProducto = $parametros['id_solicitud_registro_producto'];

        $banderaAcciones = false;
        $ingresoDatos = '';
        $filaEnsayoEficacia = '';

        switch ($estado) {
            case 'creado':
            case 'subsanacion':

                $banderaAcciones = true;

                $ingresoDatos = '<div data-linea="1">
                                    <label>Núm. solicitud ensayo de eficacia: </label>
                                    <input type="text" name="solicitud_ensayo_eficacia" id="solicitud_ensayo_eficacia" class="validacion"/>
                                </div>
                                <div data-linea="2">
                    				<button type="submit" class="mas" id="agregarEnsayoEficacia">Agregar</button>
    			                </div>';
                break;
        }

        $arrayConsulta = [
            'id_solicitud_registro_producto' => $idSolicitudRegistroProducto
        ];

        $qDatosEnsayoEficacia = $this->lNegocioEnsayosEficaciaPlaguicidasBio->buscarLista($arrayConsulta);

        foreach ($qDatosEnsayoEficacia as $datosEnsayoEficacia) {

            $idEnsayoEficacia = $datosEnsayoEficacia['id_ensayo_eficacia'];
            $numeroSoliciudEnsayoEficacia = $datosEnsayoEficacia['numero_solicitud'];
			
			$qEnsayoEficacia = $this->lNegocioEnsayoEficacia->buscarLista(array('numero_solicitud' => $numeroSoliciudEnsayoEficacia));
			$productoEnsayoEficacia = $qEnsayoEficacia->current()->producto;

            $filaEnsayoEficacia .=
                '<tr id="fila' . $idEnsayoEficacia . '">
                    <td>' . $numeroSoliciudEnsayoEficacia . '</td>
					<td>' . $productoEnsayoEficacia . '</td>';
            if ($banderaAcciones) {
                $filaEnsayoEficacia .= '<td style="width: 20px;" class="borrar">
                                                <button type="button" name="eliminar" class="icono" onclick="fn_eliminarEnsayoEficacia(' . $idEnsayoEficacia . '); return false;"/>
                                            </td>';
            }
            $filaEnsayoEficacia .= '</tr>';
        }

        return '<fieldset id="fEnsayoEficacia">
                <legend>Ensayo de eficacia</legend>
                ' . $ingresoDatos . '
                    <table id="tEnsayoEficacia" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Solicitud</th>
                                <th></th>
                            </tr>
                        </thead>
                    <tbody>' . $filaEnsayoEficacia . '</tbody>
                </table>
            </fieldset>';
    }

    /**
     * Método para generar unafila deensay de eficacia
     */
    public function generarFilaEnsayo($idEnsayoEficacia, $datosEnsayo)
    {

        $this->listaDetalles = '
                        <tr id="fila' . $idEnsayoEficacia . '">
                            <td>' . $datosEnsayo['numero_solicitud'] . '</td>
							<td>' . $datosEnsayo['producto_ensayo_eficacia'] . '</td>
                            <td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarEnsayoEficacia(' . $idEnsayoEficacia . '); return false;"/></td>
                        </tr>';

        return $this->listaDetalles;

    }

}
