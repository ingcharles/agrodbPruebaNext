<?php
 /**
 * Lógica del negocio de EntregasCuvModelo
 *
 * Este archivo se complementa con el archivo EntregasCuvControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-03-21
 * @uses    EntregasCuvLogicaNegocio
 * @package AsignacionCuv
 * @subpackage Modelos
 */
  namespace Agrodb\AsignacionCuv\Modelos;
  
  use Agrodb\AsignacionCuv\Modelos\IModelo;
 
class EntregasCuvLogicaNegocio implements IModelo 
{

	 private $modeloEntregasCuv = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloEntregasCuv = new EntregasCuvModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new EntregasCuvModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdEntregasCuv() != null && $tablaModelo->getIdEntregasCuv() > 0) {
		return $this->modeloEntregasCuv->actualizar($datosBd, $tablaModelo->getIdEntregasCuv());
		} else {
		unset($datosBd["id_entregas_cuv"]);
		return $this->modeloEntregasCuv->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloEntregasCuv->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return EntregasCuvModelo
	*/
	public function buscar($id)
	{
		return $this->modeloEntregasCuv->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloEntregasCuv->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloEntregasCuv->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarEntregasCuv()
	{
	$consulta = "SELECT * FROM ".$this->modeloEntregasCuv->getEsquema().". entregas_cuv";
		 return $this->modeloEntregasCuv->ejecutarSqlNativo($consulta);
	}
	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarEntregasCuvPorProvinciaAnioPrefijo($arrayParametros)
	{
		$idProvincia = $arrayParametros["idProvincia"];
		$prefijoCuvNumerico = $arrayParametros["prefijoCuvNumerico"];
		$anio = $arrayParametros["anio"];
		$consulta = "SELECT *
		FROM g_asignacion_cuv.entregas_cuv cuventreg
		INNER JOIN g_asignacion_cuv.solicitud_asignacion_cuv solcuv
			ON cuventreg.id_solicitud_asignacion_cuv = solcuv.id_solicitud_asignacion_cuv
		WHERE solcuv.id_provincia = '{$idProvincia}'
			AND solcuv.anio = '{$anio}'
			AND solcuv.prefijo_cuv_numerico = '{$prefijoCuvNumerico}'
		ORDER BY cuventreg.id_entregas_cuv DESC
		LIMIT 1;";
		return $this->modeloEntregasCuv->ejecutarSqlNativo($consulta);
	}
	public function buscarEntregasPoridSolicitud($id)
	{
		$consulta = "SELECT 
		* 
	FROM 
		g_asignacion_cuv.entregas_cuv entreCuv 
	WHERE 
		entreCuv.id_solicitud_asignacion_cuv = '{$id}' 
	AND entreCuv.estado = '1';";
		return $this->modeloEntregasCuv->ejecutarSqlNativo($consulta);
	}

	public function buscarCodigoCuvFinPorProvinciaAnioPrefijo($arrayParametros)
	{
		$idProvincia = $arrayParametros["idProvincia"];
		$prefijoCuvNumerico = $arrayParametros["prefijoCuvNumerico"];
		$anio = $arrayParametros["anio"];
		$consulta = "SELECT
		sac.id_provincia,
		sac.siglas,
		sac.anio,
		sac.prefijo_cuv_numerico,
		eac.codigo_cuv_inicio,
		eac.codigo_cuv_fin,
		SUM(eac.cantidad::INTEGER) AS cantidad,
		'asignación' AS tipo
	FROM
		g_asignacion_cuv.solicitud_asignacion_cuv AS sac
		LEFT JOIN
		g_asignacion_cuv.entregas_cuv AS eac ON sac.id_solicitud_asignacion_cuv = eac.id_solicitud_asignacion_cuv
	WHERE
		sac.id_provincia = '{$idProvincia}' 
		AND sac.prefijo_cuv_numerico = '{$prefijoCuvNumerico}'
		AND sac.anio = '{$anio}'
		AND eac.codigo_cuv_inicio IS NOT NULL
		AND eac.codigo_cuv_fin IS NOT NULL
	GROUP BY
		sac.id_provincia,
		sac.siglas,
		sac.anio,
		sac.prefijo_cuv_numerico,
		eac.codigo_cuv_inicio,
		eac.codigo_cuv_fin,
		sac.id_solicitud_asignacion_cuv
	
	UNION ALL
	
	SELECT
		src.id_provincia_origen,
		src.siglas,
		src.anio,
		src.prefijo_cuv_numerico,
		COALESCE(NULLIF(rc.codigo_cuv_inicio, '')::TEXT, '0') AS codigo_cuv_inicio,
		COALESCE(NULLIF(rc.codigo_cuv_fin, '')::TEXT, '0') AS codigo_cuv_fin,
		COALESCE(SUM(rc.cantidad_reasignada::INTEGER), 0) AS cantidad,
		'redistribución' AS tipo
	FROM
		g_asignacion_cuv.solicitud_redistribucion_cuv AS src
		LEFT JOIN
		g_asignacion_cuv.redistribucion_cuv AS rc ON src.id_solicitud_redistribucion_cuv = rc.id_solicitud_redistribucion_cuv
	WHERE
		src.id_provincia_origen = '{$idProvincia}'
		AND src.prefijo_cuv_numerico = '{$prefijoCuvNumerico}'
		AND src.anio = '{$anio}'
		AND rc.codigo_cuv_inicio IS NOT NULL
		AND rc.codigo_cuv_fin IS NOT NULL
	GROUP BY
		src.id_provincia_origen,
		src.siglas,
		src.anio,
		src.prefijo_cuv_numerico,
		rc.codigo_cuv_inicio,
		rc.codigo_cuv_fin,
		src.id_solicitud_redistribucion_cuv
	ORDER BY
		id_provincia,
		siglas,
		prefijo_cuv_numerico,
		codigo_cuv_inicio DESC,
		codigo_cuv_fin DESC
		LIMIT 1";
		return $this->modeloEntregasCuv->ejecutarSqlNativo($consulta);
	}

}
