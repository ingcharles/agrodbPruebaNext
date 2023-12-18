<?php
/**
 * Lógica del negocio de AsignacionCupoModelo
 *
 * Este archivo se complementa con el archivo AsignacionCupoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-12-08
 * @uses    AsignacionCupoLogicaNegocio
 * @package MovilizacionVegetal
 * @subpackage Modelos
 */
namespace Agrodb\MovilizacionVegetal\Modelos;

use Agrodb\MovilizacionVegetal\Modelos\IModelo;

class AsignacionCupoLogicaNegocio implements IModelo
{

    private $modeloAsignacionCupo = null;

    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloAsignacionCupo = new AsignacionCupoModelo();
    }

    /**
     * Guarda el registro actual
     *
     * @param array $datos
     * @return int
     */
    public function guardar(Array $datos)
    {
        $tablaModelo = new AsignacionCupoModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdAsignacionCupo() != null && $tablaModelo->getIdAsignacionCupo() > 0) {
            return $this->modeloAsignacionCupo->actualizar($datosBd, $tablaModelo->getIdAsignacionCupo());
        } else {
            unset($datosBd["id_asignacion_cupo"]);
            return $this->modeloAsignacionCupo->guardar($datosBd);
        }
    }

    /**
     * Borra el registro actual
     *
     * @param
     *            string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modeloAsignacionCupo->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return AsignacionCupoModelo
     */
    public function buscar($id)
    {
        return $this->modeloAsignacionCupo->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloAsignacionCupo->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloAsignacionCupo->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarAsignacionCupo($arrayParametros)
    {
        $identificacionOperador = $arrayParametros['identificacionOperador'];
        $nombreOperador = $arrayParametros['nombreOperador'];
        $provincia = $arrayParametros['provincia'];
        $fechaInicio = $arrayParametros['fechaInicio'];
        $fechaFin = $arrayParametros['fechaFin'];

        $identificacionOperador = ($identificacionOperador == "") ? "NULL" : "'" . $identificacionOperador . "'";
        $nombreOperador = ($nombreOperador == "") ? "NULL" : " '%" . $nombreOperador . "%'";
        $provincia = ($provincia == "") ? "NULL" : " '%" . $provincia . "%'";
        $fechaInicio = ($fechaInicio == "") ? "NULL" : "'" . $fechaInicio . " 00:00:00'";
        $fechaFin = ($fechaFin == "") ? "NULL" : "'" . $fechaFin . " 24:00:00'";

        $consulta = "SELECT 
                    	ac.id_asignacion_cupo
                    	, s.nombre_lugar AS nombre_sitio
                    	, a.nombre_area || '-' || top.nombre AS nombre_area
                    	, p.nombre_comun AS nombre_producto
                    	, ac.lote
                    	, ac.cupo_asignado
                    	, ac.cupo_disponible
                    	, ac.anio_asignacion_cupo
                    FROM 
                    	g_movilizacion_vegetal.asignacion_cupo ac
                    	INNER JOIN g_operadores.sitios s ON s.id_sitio = ac.id_sitio
                    	INNER JOIN g_operadores.areas a ON a.id_area = ac.id_area
                    	INNER JOIN g_catalogos.productos p ON p.id_producto = ac.id_producto
						INNER JOIN g_operadores.productos_areas_operacion pao ON pao.id_area = a.id_area
                        INNER JOIN g_operadores.operaciones op ON op.id_operacion = pao.id_operacion and op.id_producto = ac.id_producto
                        INNER JOIN g_catalogos.tipos_operacion top ON top.id_tipo_operacion = op.id_tipo_operacion
                        INNER JOIN g_operadores.operadores o ON o.identificador = op.identificador_operador
                        INNER JOIN (SELECT id_tabla_origen, tabla_origen FROM g_movilizacion_vegetal.transaccion_cupo_movilizacion GROUP BY id_tabla_origen, tabla_origen) ttcm ON ttcm.id_tabla_origen = ac.id_asignacion_cupo
                    WHERE
                    	(" . $identificacionOperador . " is NULL or s.identificador_operador = " . $identificacionOperador . ")
                        AND (" . $nombreOperador . " is NULL or o.razon_social ILIKE " . $nombreOperador . ")
                        AND (" . $provincia . " is NULL or s.provincia ILIKE " . $provincia . ")
                        AND (" . $fechaInicio . " is NULL or ac.fecha_creacion >= " . $fechaInicio . ")
                        AND (" . $fechaFin . " is NULL or ac.fecha_creacion <= " . $fechaFin . ")
                        AND ac.estado_asignacion_cupo = 'Activo'
                        AND ttcm.tabla_origen = 'g_movilizacion_vegetal.asignacion_cupo'
                    ORDER BY
                    	ac.fecha_creacion DESC;";

        return $this->modeloAsignacionCupo->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarAsignacionCupoPorIdAsignacionCupo($idAsignacionCupo)
    {
        $consulta = "SELECT 
                    	ac.id_asignacion_cupo
                    	, o.identificador
                    	, CASE WHEN o.razon_social = '' THEN o.nombre_representante ||' '|| o.apellido_representante ELSE o.razon_social END AS nombre_operador
                    	, s.nombre_lugar AS nombre_sitio
                    	, s.provincia AS provincia_sitio
                    	, a.nombre_area || '-' || top.nombre AS nombre_area
                        , s.identificador_operador||'.'||s.codigo_provincia || s.codigo ||a.codigo||a.secuencial AS codigo_area
                    	, p.nombre_comun AS nombre_producto
                    	, ac.lote
                    	, ROUND(CAST(ac.cupo_asignado AS NUMERIC), 2) AS cupo_asignado
                        , uf.codigo_unidad_fitosanitaria AS codigo_unidad
                        , ROUND(CAST(ac.cupo_disponible AS NUMERIC), 2) AS cupo_disponible
                    	, ac.anio_asignacion_cupo
                    FROM 
                    	g_movilizacion_vegetal.asignacion_cupo ac
                    	INNER JOIN g_operadores.sitios s ON s.id_sitio = ac.id_sitio
                    	INNER JOIN g_operadores.areas a ON a.id_area = ac.id_area
                    	INNER JOIN g_catalogos.unidades_fitosanitarias uf On uf.id_unidad_fitosanitaria = ac.id_unidad_medida
                    	INNER JOIN g_catalogos.productos p ON p.id_producto = ac.id_producto
                    	INNER JOIN g_operadores.productos_areas_operacion pao ON pao.id_area = a.id_area
                    	INNER JOIN g_operadores.operaciones op ON op.id_operacion = pao.id_operacion and op.id_producto = ac.id_producto
                    	INNER JOIN g_catalogos.tipos_operacion top ON top.id_tipo_operacion = op.id_tipo_operacion
                    	INNER JOIN g_operadores.operadores o ON o.identificador = op.identificador_operador
                    WHERE
                    	ac.id_asignacion_cupo = '" . $idAsignacionCupo . "';";

        return $this->modeloAsignacionCupo->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function guardarAsignacionCupo($arrayParametros)
    {
        $idSitio = $arrayParametros['id_sitio'];
        $idArea = $arrayParametros['id_area'];
        $idProducto = $arrayParametros['id_producto'];
        $idUnidadMedida = $arrayParametros['id_unidad_medida'];
        $lote = $arrayParametros['lote'];
        $cupoAsignado = $arrayParametros['cupo_asignado'];
        $anioAsignacionCupo = $arrayParametros['anio_asignacion_cupo'];
        $identificadorResponsable = $arrayParametros['identificador_responsable'];
        $tipoTransaccionCupo = $arrayParametros['tipo_transaccion_cupo'];

        $consulta = "SELECT * FROM g_movilizacion_vegetal.f_transaccion_cupo_movilizacion(" . $idSitio . ", " . $idArea . ", " . $idProducto . ", " . $idUnidadMedida . ", '" . $lote . "'
                                                                            , " . $cupoAsignado . ", null, " . $anioAsignacionCupo . ", '" . $identificadorResponsable . "', " . $tipoTransaccionCupo . ", null);";

        $resultado = $this->modeloAsignacionCupo->ejecutarSqlNativo($consulta);

        $arrayResultado = $resultado->current()->f_transaccion_cupo_movilizacion;
        $arrayResultado = json_decode($arrayResultado, true);

        return $arrayResultado;
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function actualizarAsignacionCupo($arrayParametros)
    {
        $idAsignacionCupo = $arrayParametros['id_asignacion_cupo'];
        $cupoAdicional = $arrayParametros['cupo_adicional'];
        $identificadorResponsable = $arrayParametros['identificador_responsable'];
        $tipoTransaccionCupo = $arrayParametros['tipo_transaccion_cupo'];

        $consulta = "SELECT * FROM g_movilizacion_vegetal.f_transaccion_cupo_movilizacion( null, null, null, null, null, null, " . $cupoAdicional . ", null, '" . $identificadorResponsable . "', " . $tipoTransaccionCupo . ", " . $idAsignacionCupo . ");";

        $resultado = $this->modeloAsignacionCupo->ejecutarSqlNativo($consulta);

        $arrayResultado = $resultado->current()->f_transaccion_cupo_movilizacion;
        $arrayResultado = json_decode($arrayResultado, true);

        return $arrayResultado;
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function eliminarAsignacionCupo($arrayParametros)
    {
        $idAsignacionCupo = $arrayParametros['id_asignacion_cupo'];
        $identificadorResponsable = $arrayParametros['identificador_responsable'];
        $tipoTransaccionCupo = $arrayParametros['tipo_transaccion_cupo'];

        $consulta = "SELECT * FROM g_movilizacion_vegetal.f_transaccion_cupo_movilizacion(null, null, null, null, null, null, null, null, '" . $identificadorResponsable . "', " . $tipoTransaccionCupo . ", " . $idAsignacionCupo . ");";

        $resultado = $this->modeloAsignacionCupo->ejecutarSqlNativo($consulta);

        $arrayResultado = $resultado->current()->f_transaccion_cupo_movilizacion;
        $arrayResultado = json_decode($arrayResultado, true);

        return $arrayResultado;
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function obtenerHistorialAsignacionCupo($idAsignacionCupo)
    {
        $consulta = "SELECT
                    	CASE WHEN tcm.tipo_transaccion_cupo = 1 THEN 'Asignación de cupo'
                    	WHEN tcm.tipo_transaccion_cupo = 2 THEN 'Cupo adicional' END AS tipo_registro
                    	, tcm.cantidad_ingreso_cupo || ' ' || uf.codigo_unidad_fitosanitaria AS cantidad
                    	, ROUND(CAST(SUM(tcm.cantidad_ingreso_cupo) OVER () AS NUMERIC), 2) || ' ' || uf.codigo_unidad_fitosanitaria AS cantidad_total
                    	, TO_CHAR(tcm.fecha_creacion, 'YYYY-MM-DD') AS fecha_registro
                    	, tcm.nombre_responsable AS tecnico_responsable
                     FROM
                        g_movilizacion_vegetal.asignacion_cupo ac
                        INNER JOIN g_movilizacion_vegetal.transaccion_cupo_movilizacion tcm ON tcm.id_tabla_origen = ac.id_asignacion_cupo
                        INNER JOIN g_catalogos.unidades_fitosanitarias uf ON uf.id_unidad_fitosanitaria = ac.id_unidad_medida
                     WHERE
                        ac.id_asignacion_cupo = " . $idAsignacionCupo . "
                        and tcm.tabla_origen = 'g_movilizacion_vegetal.asignacion_cupo';";

        return $this->modeloAsignacionCupo->ejecutarSqlNativo($consulta);
    }
    
    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function caducarCupoAnualMovilizacion()
    {
       
        $consulta = "SELECT * FROM g_movilizacion_vegetal.f_caducar_cupo_anual_movilizacion();";
        
        $this->modeloAsignacionCupo->ejecutarSqlNativo($consulta);
        
        return true;
        
    }
    
}
