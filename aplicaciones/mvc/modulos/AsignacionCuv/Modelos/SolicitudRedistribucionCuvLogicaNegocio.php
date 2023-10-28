<?php
 /**
 * Lógica del negocio de SolicitudRedistribucionCuvModelo
 *
 * Este archivo se complementa con el archivo SolicitudRedistribucionCuvControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-03-21
 * @uses    SolicitudRedistribucionCuvLogicaNegocio
 * @package AsignacionCuv
 * @subpackage Modelos
 */
  namespace Agrodb\AsignacionCuv\Modelos;
  
  use Agrodb\AsignacionCuv\Modelos\IModelo;
  use Agrodb\Core\JasperReport;
 
class SolicitudRedistribucionCuvLogicaNegocio implements IModelo 
{

	 private $modeloSolicitudRedistribucionCuv = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloSolicitudRedistribucionCuv = new SolicitudRedistribucionCuvModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new SolicitudRedistribucionCuvModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdSolicitudRedistribucionCuv() != null && $tablaModelo->getIdSolicitudRedistribucionCuv() > 0) {
		return $this->modeloSolicitudRedistribucionCuv->actualizar($datosBd, $tablaModelo->getIdSolicitudRedistribucionCuv());
		} else {
		unset($datosBd["id_solicitud_redistribucion_cuv"]);
		return $this->modeloSolicitudRedistribucionCuv->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloSolicitudRedistribucionCuv->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return SolicitudRedistribucionCuvModelo
	*/
	public function buscar($id)
	{
		return $this->modeloSolicitudRedistribucionCuv->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloSolicitudRedistribucionCuv->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloSolicitudRedistribucionCuv->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarSolicitudRedistribucionCuv()
	{
	$consulta = "SELECT * FROM ".$this->modeloSolicitudRedistribucionCuv->getEsquema().". solicitud_redistribucion_cuv";
		 return $this->modeloSolicitudRedistribucionCuv->ejecutarSqlNativo($consulta);
	}
	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarSolicitudRedistribucionCuvPorCedula($identificadorTecnicoProvincia)
	{
	$consulta = "SELECT * FROM ".$this->modeloSolicitudRedistribucionCuv->getEsquema().". solicitud_redistribucion_cuv where tecnico_provincia_identificador = '{$identificadorTecnicoProvincia}' and estado = '1'";
		 return $this->modeloSolicitudRedistribucionCuv->ejecutarSqlNativo($consulta);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarSolicitudRedistribucionCuvPorEstadoPendiente()
	{
	$consulta = "SELECT * FROM ".$this->modeloSolicitudRedistribucionCuv->getEsquema().". solicitud_redistribucion_cuv where estado_solicitud = 'Pendiente' and estado = '1'";
		 return $this->modeloSolicitudRedistribucionCuv->ejecutarSqlNativo($consulta);
	}

	public function buscarSolicitudesRedistribucionFechas($arrayParametros)
	{
		$fechaInicio = $arrayParametros["fechaInicio"];
		$fechaFin = $arrayParametros["fechaFin"];
		$estado_solicitud = $arrayParametros["estado_solicitud"];
		$identificador_tecnico_provincia = $arrayParametros["identificador_tecnico_provincia"];
		$consulta = "SELECT * FROM g_asignacion_cuv.solicitud_redistribucion_cuv srcuv WHERE srcuv.fecha_creacion >= '{$fechaInicio}'::timestamp 
		AND srcuv.fecha_creacion <= ('{$fechaFin}'::date + INTERVAL '1 day' - INTERVAL '1 second')
		AND srcuv.estado = '1'
		AND srcuv.tecnico_provincia_identificador = '{$identificador_tecnico_provincia}'";
		if ($estado_solicitud === 'Todos') {
			$consulta .= " AND srcuv.estado_solicitud IN ('Aprobado','Pendiente','Pendiente Envío','Rechazada')";
		} else {
			$consulta .= " AND srcuv.estado_solicitud = '{$estado_solicitud}'";
		}
		return $this->modeloSolicitudRedistribucionCuv->ejecutarSqlNativo($consulta);
	}

	public function calculoRedisAsignaciEnviadaProvincia($arrayParametros)
	{
		$idProvincia = $arrayParametros["idProvincia"];
		$prefijo_cuv_numerico = $arrayParametros["prefijo_cuv_numerico"];
		$anio = $arrayParametros["anio"];
		$consulta = "SELECT
		dicv.provincia,
		dicv.cantidad::bigint AS cantidad_inicial,
		COALESCE(ec.cantidad, 0) AS cantidad_asignada,
		COALESCE(rc.cantidad, 0) AS cantidad_redistribuida_enviada
	FROM 
		g_asignacion_cuv.distribucion_inicial_cuv AS dicv
	LEFT JOIN (
		SELECT
			sac.id_provincia,
			sac.prefijo_cuv_numerico,
			sac.anio,
			SUM(eac.cantidad::INTEGER) AS cantidad
		FROM
			g_asignacion_cuv.solicitud_asignacion_cuv AS sac
		LEFT JOIN
			g_asignacion_cuv.entregas_cuv AS eac ON sac.id_solicitud_asignacion_cuv = eac.id_solicitud_asignacion_cuv
		WHERE
			sac.id_provincia = '{$idProvincia}'
			AND sac.prefijo_cuv_numerico = '{$prefijo_cuv_numerico}'
			AND sac.anio = '{$anio}'
		GROUP BY
			sac.id_provincia,
			sac.prefijo_cuv_numerico,
			sac.anio
	) AS ec ON dicv.id_provincia = ec.id_provincia
		AND dicv.prefijo_cuv_numerico = ec.prefijo_cuv_numerico
		AND dicv.anio = ec.anio
	LEFT JOIN (
		SELECT 
		src.id_provincia_origen, 
		src.prefijo_cuv_numerico, 
		src.anio, 
		SUM(redistribucion_cuv.cantidad_reasignada::INTEGER) AS cantidad 
	FROM 
		g_asignacion_cuv.redistribucion_cuv 
	INNER JOIN 
		g_asignacion_cuv.solicitud_redistribucion_cuv src 
	ON 
		( 
			g_asignacion_cuv.redistribucion_cuv.id_solicitud_redistribucion_cuv = 
			src.id_solicitud_redistribucion_cuv) 
	WHERE 
		src.id_provincia_origen = '{$idProvincia}' 
	AND src.prefijo_cuv_numerico = '{$prefijo_cuv_numerico}'
	AND src.anio = '{$anio}'
	GROUP BY 
		src.id_provincia_origen, 
		src.prefijo_cuv_numerico, 
		src.anio
	) AS rc ON dicv.id_provincia = rc.id_provincia_origen
		AND dicv.prefijo_cuv_numerico = rc.prefijo_cuv_numerico
		AND dicv.anio = rc.anio
	WHERE 
		dicv.id_provincia = '{$idProvincia}' 
		AND dicv.prefijo_cuv_numerico = '{$prefijo_cuv_numerico}' 
		AND dicv.anio = '{$anio}';";
		return $this->modeloSolicitudRedistribucionCuv->ejecutarSqlNativo($consulta);
	}
	public function ultimaSerieProvinciaOrigen($arrayParametros)
	{
		$idProvincia = $arrayParametros["idProvincia"];
		$prefijo_cuv_numerico = $arrayParametros["prefijo_cuv_numerico"];
		$anio = $arrayParametros["anio"];
		$consulta = "SELECT
		sac.id_provincia,
		sac.siglas,
		sac.anio,
		sac.prefijo_cuv_numerico,
		eac.codigo_cuv_inicio,
		eac.codigo_cuv_fin,
		SUM(eac.cantidad::INTEGER) AS cantidad,
		CASE
			WHEN sac.id_solicitud_asignacion_cuv IS NOT NULL THEN 'asignación'
			ELSE 'redistribución'
		END AS tipo
	FROM
		g_asignacion_cuv.solicitud_asignacion_cuv AS sac
		LEFT JOIN
		g_asignacion_cuv.entregas_cuv AS eac ON sac.id_solicitud_asignacion_cuv = eac.id_solicitud_asignacion_cuv
		WHERE
			sac.id_provincia = '{$idProvincia}'
			AND sac.prefijo_cuv_numerico = '{$prefijo_cuv_numerico}'
			AND sac.anio = '{$anio}'
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
		CASE
			WHEN src.id_solicitud_redistribucion_cuv IS NOT NULL THEN 'redistribución'
			ELSE 'asignación'
		END AS tipo
	FROM
		g_asignacion_cuv.solicitud_redistribucion_cuv AS src
		LEFT JOIN
		g_asignacion_cuv.redistribucion_cuv AS rc ON src.id_solicitud_redistribucion_cuv = rc.id_solicitud_redistribucion_cuv
		WHERE
			src.id_provincia_origen = '{$idProvincia}'
			AND src.prefijo_cuv_numerico = '{$prefijo_cuv_numerico}'
			AND src.anio = '{$anio}'
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
		codigo_cuv_inicio,
		codigo_cuv_fin;";
		return $this->modeloSolicitudRedistribucionCuv->ejecutarSqlNativo($consulta);
	}

	public function generarCertificado($idSolicitudAsignacionRedistribucion, $nombreArchivo)
	{
		$jasper = new JasperReport();
		$datosReporte = array();
		$anio = date('Y');
		$mes = date('m');
		$dia = date('d');
		$ruta = REDISTRI_CUV_URL_TCPDF . 'redistribucion/'. $anio . '/' . $mes . '/' . $dia . '/';
		if (! file_exists($ruta)) {
			mkdir($ruta, 0777, true);
		}
			$datosReporte = array(
				'rutaReporte' => 'AsignacionCuv/vistas/reportes/reporteRedistribucionCuvs.jasper',
				'rutaSalidaReporte' => 'AsignacionCuv/archivos/redistribucion/'. $anio . '/' . $mes . '/' . $dia . '/' .$nombreArchivo,
				'tipoSalidaReporte' => array('pdf'),
				'parametrosReporte' => array(   'id_solicitud_redistribucion_cuv_jasper' => (int)$idSolicitudAsignacionRedistribucion,
												'fondoCertificado'=> RUTA_IMG_GENE.'fondoCertificado.png'
												),
				'conexionBase' => 'SI'
			);
			
			$jasper->generarArchivo($datosReporte);
	}
}
