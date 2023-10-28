<?php
/**
 * Lógica del negocio de SolicitudesModelo
 *
 * Este archivo se complementa con el archivo SolicitudesControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-10-21
 * @uses    SolicitudesLogicaNegocio
 * @package EnsayoEficacia
 * @subpackage Modelos
 */

namespace Agrodb\EnsayoEficacia\Modelos;

use Agrodb\EnsayoEficacia\Modelos\IModelo;
use Agrodb\RegistroOperador\Modelos\OperadoresLogicaNegocio;

class SolicitudesLogicaNegocio implements IModelo
{

    private $modeloSolicitudes = null;


    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloSolicitudes = new SolicitudesModelo();
    }

    /**
     * Guarda el registro actual
     * @param array $datos
     * @return int
     */
    public function guardar(array $datos)
    {
        $tablaModelo = new SolicitudesModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdSolicitud() != null && $tablaModelo->getIdSolicitud() > 0) {
            return $this->modeloSolicitudes->actualizar($datosBd, $tablaModelo->getIdSolicitud());
        } else {
            unset($datosBd["id_solicitud"]);
            $numeroSolicitud = $this->generarNumeroSolicitud();
            $datosBd["numero_solicitud"] = $numeroSolicitud->current()->f_generar_numero_solicitud;
            return $this->modeloSolicitudes->guardar($datosBd);
        }
    }

    /**
     * Borra el registro actual
     * @param string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modeloSolicitudes->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return SolicitudesModelo
     */
    public function buscar($id)
    {
        return $this->modeloSolicitudes->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloSolicitudes->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloSolicitudes->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarSolicitudes()
    {
        $consulta = "SELECT * FROM " . $this->modeloSolicitudes->getEsquema() . ". solicitudes";
        return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarSolicitudesEnsayoEficacia($arrayParametros)
    {
        $identificador = $arrayParametros['identificador'] != "" ? "'" . $arrayParametros['identificador'] . "'" : "NULL";
        $nombreProducto = $arrayParametros['nombreProducto'] != "" ? "'%" . $arrayParametros['nombreProducto'] . "%'" : "NULL";
        $estadoSolicitud = $arrayParametros['estadoSolicitud'] != "" ? $arrayParametros['estadoSolicitud'] : "NULL";
        $numeroSolicitud = $arrayParametros['numeroSolicitud'] != "" ? "'" . $arrayParametros['numeroSolicitud'] . "'" : "NULL";
        $identificadorRevisorTecnico = isset($arrayParametros['identificadorRevisorTecnico']) ? "'" . $arrayParametros['identificadorRevisorTecnico'] . "'" : "NULL";
        $identificadorRevisorResultado = isset($arrayParametros['identificadorRevisorResultado']) ? "'" . $arrayParametros['identificadorRevisorResultado'] . "'" : "NULL";
        $fecha = $arrayParametros['fecha'] != "" ? "'" . $arrayParametros['fecha'] . "'" : "NULL";

        $consulta = "SELECT
                        s.id_solicitud,
                        s.tipo_solicitud,
                        s.tipo_producto,
                        s.producto,
                        s.fecha_creacion,
                        s.razon_social,                        
                        s.estado,
                        s.numero_solicitud,
                        s.identificador_revisor_tecnico,
                        s.identificador_revisor_resultado
                     FROM 
                        g_ensayo_eficacia_mvc.solicitudes s
					 WHERE
                        ($identificador is NULL or s.identificador_operador = $identificador)
                        and ($nombreProducto is NULL or s.producto ilike $nombreProducto)
                        and (($estadoSolicitud) is NULL or s.estado IN ($estadoSolicitud))
                        and ($numeroSolicitud is NULL or s.numero_solicitud = $numeroSolicitud)
                        and ($identificadorRevisorTecnico is NULL or s.identificador_revisor_tecnico = $identificadorRevisorTecnico)
                        and ($identificadorRevisorResultado is NULL or s.identificador_revisor_resultado = $identificadorRevisorResultado)
                        and ($fecha is NULL or to_char(s.fecha_creacion,'YYYY-MM-DD') = $fecha)  
                    ORDER BY s.fecha_creacion ASC";

        return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
    }

    /**
     * Consulta datos del operador .
     *
     * @return Operadores
     */
    public function obtenerDatosOperador($identificador)
    {
        $lNegocioOperadores = new OperadoresLogicaNegocio();

        $operador = $lNegocioOperadores->buscar($identificador);

        return $operador;
    }

    /**
     * Genera nuero de soliciud.
     *
     * @return array|ResultSet
     */
    public function generarNumeroSolicitud()
    {
        $consulta = "SELECT * FROM g_ensayo_eficacia_mvc.f_generar_numero_solicitud();";

        return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada para actualizar
     * los datos del estado de la solicitud.
     *
     * @return array|ResultSet
     */
    public function actualizarEstadoEnsayoEficacia($arrayParametros)
    {
        $actualizacion = '';
        $idSolicitudProducto = $arrayParametros['id_solicitud'];
        $estadoSolicitud = $arrayParametros['estado'];
        $identificadorRevisor = $arrayParametros['identificador_revisor_tecnico'];
        $identificadorRevisorResultado = $arrayParametros['identificador_revisor_resultado'];

        if (isset($identificadorRevisor) && ($identificadorRevisor != '')) {
            $actualizacion .= ", identificador_revisor_tecnico = '" . $identificadorRevisor . "'";
        }

        if (isset($identificadorRevisorResultado) && ($identificadorRevisorResultado != '')) {
            $actualizacion .= ", identificador_revisor_resultado = '" . $identificadorRevisorResultado . "'";
        }

        $consulta = "UPDATE
                    	g_ensayo_eficacia_mvc.solicitudes
                    SET
                    	estado = '" . $estadoSolicitud . "'
                    	" . $actualizacion . "
                    WHERE
                    	id_solicitud = '" . $idSolicitudProducto . "';";

        return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function actualizarEstadoRevisionEnsayoEficacia($arrayParametros)
    {
        $actualizacion = '';

        $idSolicitud = $arrayParametros['id_solicitud'];
        $estado = $arrayParametros['estado'];
        $estadoAnterior = $arrayParametros['estado_anterior'];
        $observacionRevisorTecnico = $arrayParametros['observacion_revisor_tecnico'];
        $rutaRevisorTecnico = $arrayParametros['ruta_revisor_tecnico'];
        $identificadorRevisorResultado = $arrayParametros['identificador_revisor_resultado'];
        $observacionRevisorResultado = $arrayParametros['observacion_revisor_resultado'];
        $rutaInformeUno = $arrayParametros['ruta_informe_uno'];
        $rutaInformeDos = $arrayParametros['ruta_informe_dos'];
        $resultadoRevisorTecnico = $arrayParametros['resultado_revisor_tecnico'];
        $resultadoRevisorResultado = $arrayParametros['resultado_revisor_resultado'];


        if ($estado === 'subsanacion') {
            $actualizacion .= ", fecha_subsanacion = 'now()'";
        }

        if ($estado === 'rechazado' || $estado === 'aprobado') {
            $actualizacion .= ", fecha_aprobacion = 'now()'";
        }

        if (isset($estadoAnterior) && ($estadoAnterior != '')) {
            $actualizacion .= ", estado_anterior = '" . $estadoAnterior . "'";
        }

        if (isset($observacionRevisorTecnico) && ($observacionRevisorTecnico != '')) {
            $actualizacion .= ", observacion_revisor_tecnico = '" . $observacionRevisorTecnico . "'";
        }

        if (isset($rutaRevisorTecnico) && ($rutaRevisorTecnico != '')) {
            $actualizacion .= ", ruta_revisor_tecnico = '" . $rutaRevisorTecnico . "'";
        }

        if (isset($identificadorRevisorResultado) && ($identificadorRevisorResultado != '')) {
            $actualizacion .= ", identificador_revisor_resultado = '" . $identificadorRevisorResultado . "'";
        }

        if (isset($observacionRevisorResultado) && ($observacionRevisorResultado != '')) {
            $actualizacion .= ", observacion_revisor_resultado = '" . $observacionRevisorResultado . "'";
        }

        if (isset($rutaInformeUno) && ($rutaInformeUno != '')) {
            $actualizacion .= ", ruta_informe_uno = '" . $rutaInformeUno . "'";
        }

        if (isset($rutaInformeDos) && ($rutaInformeDos != '')) {
            $actualizacion .= ", ruta_informe_dos = '" . $rutaInformeDos . "'";
        }

        if (isset($resultadoRevisorTecnico) && ($resultadoRevisorTecnico != '')) {
            $actualizacion .= ", resultado_revisor_tecnico = '" . $resultadoRevisorTecnico . "'";
        }

        if (isset($resultadoRevisorResultado) && ($resultadoRevisorResultado != '')) {
            $actualizacion .= ", resultado_revisor_resultado = '" . $resultadoRevisorResultado . "'";
        }

        $consulta = "  UPDATE
                        	g_ensayo_eficacia_mvc.solicitudes 
                        SET
                            estado = '$estado'
                        	" . $actualizacion . "
                        WHERE
                            id_solicitud = '$idSolicitud';";

        return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
    }

}
