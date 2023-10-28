<?php
/**
 * Lógica del negocio de ResultadosEnsayoModelo
 *
 * Este archivo se complementa con el archivo ResultadosEnsayoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-10-21
 * @uses    ResultadosEnsayoLogicaNegocio
 * @package EnsayoEficacia
 * @subpackage Modelos
 */

namespace Agrodb\EnsayoEficacia\Modelos;

use Agrodb\EnsayoEficacia\Modelos\IModelo;

class ResultadosEnsayoLogicaNegocio implements IModelo
{

    private $modeloResultadosEnsayo = null;


    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloResultadosEnsayo = new ResultadosEnsayoModelo();
    }

    /**
     * Guarda el registro actual
     * @param array $datos
     * @return int
     */
    public function guardar(array $datos)
    {
        $tablaModelo = new ResultadosEnsayoModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdResultadoEnsayo() != null && $tablaModelo->getIdResultadoEnsayo() > 0) {
            return $this->modeloResultadosEnsayo->actualizar($datosBd, $tablaModelo->getIdResultadoEnsayo());
        } else {
            unset($datosBd["id_resultado_ensayo"]);
            return $this->modeloResultadosEnsayo->guardar($datosBd);
        }
    }

    /**
     * Borra el registro actual
     * @param string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modeloResultadosEnsayo->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return ResultadosEnsayoModelo
     */
    public function buscar($id)
    {
        return $this->modeloResultadosEnsayo->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloResultadosEnsayo->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloResultadosEnsayo->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarResultadosEnsayo()
    {
        $consulta = "SELECT * FROM " . $this->modeloResultadosEnsayo->getEsquema() . ". resultados_ensayo";
        return $this->modeloResultadosEnsayo->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada para actualizar
     * los datos del estado de la solicitud.
     *
     * @return array|ResultSet
     */
    public function obtenerSolicitudesIngresarResultadosOperador($arrayParametros)
    {
        $estadoSolicitud = $arrayParametros['estadoSolicitud'];
        $identificador = $arrayParametros['identificador'];
        $fecha = $arrayParametros['fecha'] != "" ? "'" . $arrayParametros['fecha'] . "'" : "NULL";
        $nombreProducto = $arrayParametros['nombreProducto'] != "" ? "'%" . $arrayParametros['nombreProducto'] . "%'" : "NULL";

        $consulta = "SELECT 
                            s.*
                    FROM 
                        g_ensayo_eficacia_mvc.solicitudes s
                        INNER JOIN g_ensayo_eficacia_mvc.organismos_inspeccion oi ON s.id_solicitud = oi.id_solicitud
                        FULL OUTER JOIN g_ensayo_eficacia_mvc.resultados_ensayo re ON s.id_solicitud = re.id_solicitud
                    WHERE 
                        s.identificador_operador = '" . $identificador . "'
                        and re.identificador_operador is null
                        and ($nombreProducto is NULL or s.producto ilike $nombreProducto)
                        and ($fecha is NULL or to_char(s.fecha_creacion,'YYYY-MM-DD') = $fecha)
                        and estado IN (" . $estadoSolicitud . ");";

        return $this->modeloResultadosEnsayo->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada para actualizar
     * los datos del estado de la solicitud.
     *
     * @return array|ResultSet
     */
    public function obtenerSolicitudesIngresarResultadosOrganismo($arrayParametros)
    {
        $estadoSolicitud = $arrayParametros['estadoSolicitud'];
        $identificador = $arrayParametros['identificador'];
        $fecha = $arrayParametros['fecha'] != "" ? "'" . $arrayParametros['fecha'] . "'" : "NULL";
        $nombreProducto = $arrayParametros['nombreProducto'] != "" ? "'%" . $arrayParametros['nombreProducto'] . "%'" : "NULL";

        $consulta = "SELECT 
                            s.*
                    FROM 
                        g_ensayo_eficacia_mvc.solicitudes s
                        INNER JOIN g_ensayo_eficacia_mvc.organismos_inspeccion oi ON s.id_solicitud = oi.id_solicitud
                        FULL OUTER JOIN g_ensayo_eficacia_mvc.resultados_ensayo re ON s.id_solicitud = re.id_solicitud
                    WHERE 
                        oi.identificador_organismo_inspeccion = '" . $identificador . "'
                        and re.identificador_organismo is null
                        and ($nombreProducto is NULL or s.producto ilike $nombreProducto)
                        and ($fecha is NULL or to_char(s.fecha_creacion,'YYYY-MM-DD') = $fecha)
                        and estado IN (" . $estadoSolicitud . ");";

        return $this->modeloResultadosEnsayo->ejecutarSqlNativo($consulta);
    }

    public function guardarResultadoEnsayo($arrayParametros)
    {
        $idSolicitud = $arrayParametros['id_solicitud'];
        $identificador = $arrayParametros['identificador'];

        $lNegocioSolicitudes = new SolicitudesLogicaNegocio();
        $lNegocioOrganismosInspeccion = new OrganismosInspeccionLogicaNegocio();

        $solicitudEnsayoEficacia = $lNegocioSolicitudes->buscar($idSolicitud);
        $organismoInspeccion = $lNegocioOrganismosInspeccion->buscarLista(['id_solicitud' => $idSolicitud]);

        $identificadorOperador = $solicitudEnsayoEficacia->getIdentificadorOperador();
        $identificadorOrganismo = $organismoInspeccion->current()->identificador_organismo_inspeccion;

        $revisionResultado = $this->buscarLista(['id_solicitud' => $idSolicitud]);
        $idRevisionResultado = $revisionResultado->count() ? $revisionResultado->current()->id_resultado_ensayo : '';

        if ($identificador == $identificadorOperador) {
            $arrayParametros = array(
                'id_solicitud' => $idSolicitud,
                'identificador_operador' => $identificador,
                'ruta_informe_operador_uno' => $arrayParametros['ruta_informe_uno'],
                'ruta_informe_operador_dos' => $arrayParametros['ruta_informe_dos'],
                'fecha_creacion_operador' => 'now()'
            );
        }

        if ($identificador == $identificadorOrganismo) {
            $arrayParametros = array(
                'id_solicitud' => $idSolicitud,
                'identificador_organismo' => $identificador,
                'ruta_informe_organismo_uno' => $arrayParametros['ruta_informe_uno'],
                'ruta_informe_organismo_dos' => $arrayParametros['ruta_informe_dos'],
                'fecha_creacion_organismo' => 'now()'
            );
        }

        if (isset($idRevisionResultado)) {
            $arrayParametros += [
                'id_resultado_ensayo' => $idRevisionResultado];
        }

        $this->guardar($arrayParametros);
        $revisionResultado = $this->buscarLista(['id_solicitud' => $idSolicitud]);
        $identificadorOperador = $revisionResultado->current()->identificador_operador;
        $identificadorOrganismo = $revisionResultado->current()->identificador_organismo;

        if ($identificadorOperador != '' && $identificadorOrganismo != '') {
            $arrayParametrosResultado = array(
                'id_solicitud' => $idSolicitud,
                'estado' => 'inspeccionResultado',
                'estado_anterior' => 'ingresarResultado',
                'observacion_revisor_tecnico' => '',
                'ruta_revisor_tecnico' => '',
                'identificador_revisor_resultado' => '',
                'observacion_revisor_resultado' => '',
                'ruta_informe_uno' => '',
                'ruta_informe_dos' => '',
                'resultado_revisor_tecnico' => '',
                'resultado_revisor_resultado' => ''
            );

            $lNegocioSolicitudes = new SolicitudesLogicaNegocio();
            $lNegocioSolicitudes->actualizarEstadoRevisionEnsayoEficacia($arrayParametrosResultado);
        }
    }

    /**
     * Ejecuta una consulta(SQL) de actualizacion de registro .
     *
     * @return array|ResultSet
     */
    public function actualizarOperadorResultadosEnsayo($arrayParametros)
    {
        $actualizacion = '';
        $idSolicitud = $arrayParametros['id_solicitud'];
        $dirigidoA = $arrayParametros['dirigido_a'];

        if ($dirigidoA === 'operador') {
            $actualizacion = "identificador_operador = null";
        }

        if ($dirigidoA === 'organismo') {
            $actualizacion = "identificador_organismo = null";
        }

        if ($dirigidoA === 'ambos') {
            $actualizacion = "identificador_operador = null, identificador_organismo = null";
        }

        $consulta = "UPDATE 
                           g_ensayo_eficacia_mvc.resultados_ensayo
                    SET 
                         " . $actualizacion . "
                    WHERE 
                        id_solicitud = '".$idSolicitud."';";

        return $this->modeloResultadosEnsayo->ejecutarSqlNativo($consulta);
    }

}
