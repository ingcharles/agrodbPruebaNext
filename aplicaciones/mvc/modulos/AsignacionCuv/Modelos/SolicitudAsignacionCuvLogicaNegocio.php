<?php
 /**
 * Lógica del negocio de SolicitudAsignacionCuvModelo
 *
 * Este archivo se complementa con el archivo SolicitudAsignacionCuvControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-03-21
 * @uses    SolicitudAsignacionCuvLogicaNegocio
 * @package AsignacionCuv
 * @subpackage Modelos
 */
  namespace Agrodb\AsignacionCuv\Modelos;
  
  use Agrodb\AsignacionCuv\Modelos\IModelo;
  use Agrodb\Core\JasperReport;
 
class SolicitudAsignacionCuvLogicaNegocio implements IModelo 
{

	 private $modeloSolicitudAsignacionCuv = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloSolicitudAsignacionCuv = new SolicitudAsignacionCuvModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new SolicitudAsignacionCuvModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdSolicitudAsignacionCuv() != null && $tablaModelo->getIdSolicitudAsignacionCuv() > 0) {
		return $this->modeloSolicitudAsignacionCuv->actualizar($datosBd, $tablaModelo->getIdSolicitudAsignacionCuv());
		} else {
		unset($datosBd["id_solicitud_asignacion_cuv"]);
		return $this->modeloSolicitudAsignacionCuv->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloSolicitudAsignacionCuv->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return SolicitudAsignacionCuvModelo
	*/
	public function buscar($id)
	{
		return $this->modeloSolicitudAsignacionCuv->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloSolicitudAsignacionCuv->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloSolicitudAsignacionCuv->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarSolicitudAsignacionCuv()
	{
	$consulta = "SELECT * FROM ".$this->modeloSolicitudAsignacionCuv->getEsquema().". solicitud_asignacion_cuv";
		 return $this->modeloSolicitudAsignacionCuv->ejecutarSqlNativo($consulta);
	}
	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarSolicitudAsignacionCuvPendientes()
	{
	$consulta = "SELECT * FROM g_asignacion_cuv.solicitud_asignacion_cuv sa where sa.estado = '1' and sa.estado_solicitud = 'Pendiente';";
		 return $this->modeloSolicitudAsignacionCuv->ejecutarSqlNativo($consulta);
	}
	public function buscarSolicitudAsignacionCuvExternos($operadorIdentificador)
	{
	$consulta = "SELECT * FROM g_asignacion_cuv.solicitud_asignacion_cuv sa where sa.operador_solicitante_identificador = '{$operadorIdentificador}' and sa.estado = '1' and sa.estado_solicitud in ('Pendiente', 'Aprobada','Rechazada')";
		 return $this->modeloSolicitudAsignacionCuv->ejecutarSqlNativo($consulta);
	}

	public function buscarDatosDelOperadorIoTPC($identificador)
	{
	$consulta = "SELECT 
	op.identificador_operador
	, CASE WHEN o.razon_social = '' THEN o.nombre_representante ||' '|| o.apellido_representante ELSE o.razon_social END nombre_razon_social
	, o.nombre_representante ||' '|| o.apellido_representante as representante_legal
	, string_agg(distinct (top.nombre), ', ') as operaciones_registradas
	FROM 
	g_operadores.sitios s
	INNER JOIN g_operadores.areas a ON s.id_sitio = a.id_sitio
	INNER JOIN g_operadores.productos_areas_operacion pao ON a.id_area = pao.id_area
	INNER JOIN g_operadores.operaciones op ON pao.id_operacion = op.id_operacion
	INNER JOIN g_operadores.operadores o ON op.identificador_operador = o.identificador
	INNER JOIN g_catalogos.tipos_operacion top ON op.id_tipo_operacion = top.id_tipo_operacion
	WHERE
	op.estado = 'registrado' and op.identificador_operador = '{$identificador}'
	and top.id_area || top.codigo IN ('SAOPT', 'SAOPI')
	GROUP BY 1, 2, 3;";
		return $this->modeloSolicitudAsignacionCuv->ejecutarSqlNativo($consulta);
	}

	
	public function buscarSolicitudesFechasProv($arrayParametros)
	{
		$fechaInicio = $arrayParametros["fechaInicio"];
		$fechaFin = $arrayParametros["fechaFin"];
		$idProvincia = $arrayParametros["idProvincia"];
		$estado_solicitud = $arrayParametros["estado_solicitud"];
		$identificador_operador = $arrayParametros["identificador_operador"];
		$consulta = "SELECT * FROM g_asignacion_cuv.solicitud_asignacion_cuv sacuv WHERE sacuv.fecha_creacion >= '{$fechaInicio}'::timestamp 
		AND sacuv.fecha_creacion <= ('{$fechaFin}'::date + INTERVAL '1 day' - INTERVAL '1 second')
		AND sacuv.operador_solicitante_identificador = '{$identificador_operador}'
		AND sacuv.id_provincia = '{$idProvincia}'";
		if ($estado_solicitud === 'Todos') {
			$consulta .= " AND sacuv.estado_solicitud IN ('Aprobada','Rechazada','Pendiente')";
		} else {
			$consulta .= " AND sacuv.estado_solicitud = '{$estado_solicitud}'";
		}
		return $this->modeloSolicitudAsignacionCuv->ejecutarSqlNativo($consulta);
	}

	public function buscarDisponibilidadCuv($arrayParametros)
	{
		$idProvincia = $arrayParametros["idProvincia"];
		$prefijoCuvNumerico = $arrayParametros["prefijoCuvNumerico"];
		$anio = $arrayParametros["anio"];

		$consulta = "SELECT * FROM g_asignacion_cuv.distribucion_inicial_cuv dicv WHERE dicv.id_provincia='{$idProvincia}' AND dicv.prefijo_cuv_numerico = '{$prefijoCuvNumerico}' AND dicv.anio = '{$anio}'";
		 return $this->modeloSolicitudAsignacionCuv->ejecutarSqlNativo($consulta);
	}
	
	public function buscarDisponibilidadCuvDifirencia($arrayParametros)
	{
		$idProvincia = $arrayParametros["idProvincia"];
		$prefijoCuvNumerico = $arrayParametros["prefijoCuvNumerico"];
		$anio = $arrayParametros["anio"];

		$consulta = "SELECT
		dicv.id_distribucion_inicial_cuv,
		dicv.id_provincia,
		dicv.provincia,
		dicv.provincia,
		dicv.siglas,
		dicv.anio,
		dicv.prefijo_cuv_numerico,
		dicv.codigo_cuv_inicio,
		dicv.codigo_cuv_fin,
		dicv.cantidad,
		dicv.estado,
		dicv.identificador,
		dicv.cantidad::INTEGER - COALESCE((ec.cantidad::INTEGER), 0)- COALESCE((rc.cantidad::INTEGER), 0) AS diferencia
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
			AND sac.prefijo_cuv_numerico = '{$prefijoCuvNumerico}'
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
	AND src.prefijo_cuv_numerico = '{$prefijoCuvNumerico}'
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
		AND dicv.prefijo_cuv_numerico = '{$prefijoCuvNumerico}' 
		AND dicv.anio = '{$anio}';
	";
		return $this->modeloSolicitudAsignacionCuv->ejecutarSqlNativo($consulta);
	}

	public function generarCertificado($idSolicitudAsignacion, $nombreArchivo) {
		$jasper = new JasperReport();
		$datosReporte = array();
		$anio = date('Y');
		$mes = date('m');
		$dia = date('d');
		$ruta = SOLIC_CUV_URL_TCPDF . 'certificado/'. $anio . '/' . $mes . '/' . $dia . '/';
		if (! file_exists($ruta)) {
			mkdir($ruta, 0777, true);
		}
			$datosReporte = array(
				'rutaReporte' => 'AsignacionCuv/vistas/reportes/reporteSolicitudCuvs.jasper',
				'rutaSalidaReporte' => 'AsignacionCuv/archivos/certificado/'. $anio . '/' . $mes . '/' . $dia . '/' .$nombreArchivo,
				'tipoSalidaReporte' => array('pdf'),
				'parametrosReporte' => array(   'id_solicitud_cuv_jasper' => (int)$idSolicitudAsignacion,
												'fondoCertificado'=> RUTA_IMG_GENE.'fondoCertificado.png'
												),
				'conexionBase' => 'SI'
			);
			
			$jasper->generarArchivo($datosReporte);
	}
}
