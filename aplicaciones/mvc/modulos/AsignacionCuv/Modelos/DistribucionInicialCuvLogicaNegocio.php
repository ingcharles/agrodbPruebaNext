<?php
 /**
 * Lógica del negocio de DistribucionInicialCuvModelo
 *
 * Este archivo se complementa con el archivo DistribucionInicialCuvControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-03-21
 * @uses    DistribucionInicialCuvLogicaNegocio
 * @package AsignacionCuv
 * @subpackage Modelos
 */
  namespace Agrodb\AsignacionCuv\Modelos;
  
  use Agrodb\AsignacionCuv\Modelos\IModelo;
  use PhpOffice\PhpSpreadsheet\IOFactory;
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Style\Alignment;
  use PhpOffice\PhpSpreadsheet\Style\Border;
  use PhpOffice\PhpSpreadsheet\Style\Color;
  use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
  use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter;
  use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing;

 
class DistribucionInicialCuvLogicaNegocio implements IModelo 
{

	 private $modeloDistribucionInicialCuv = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloDistribucionInicialCuv = new DistribucionInicialCuvModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new DistribucionInicialCuvModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdDistribucionInicialCuv() != null && $tablaModelo->getIdDistribucionInicialCuv() > 0) {
		return $this->modeloDistribucionInicialCuv->actualizar($datosBd, $tablaModelo->getIdDistribucionInicialCuv());
		} else {
		unset($datosBd["id_distribucion_inicial_cuv"]);
		$datosBd["estado"] = 1;
		return $this->modeloDistribucionInicialCuv->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloDistribucionInicialCuv->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return DistribucionInicialCuvModelo
	*/
	public function buscar($id)
	{
		return $this->modeloDistribucionInicialCuv->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloDistribucionInicialCuv->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloDistribucionInicialCuv->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarDistribucionInicialCuv()
	{
	$consulta = "SELECT * FROM ".$this->modeloDistribucionInicialCuv->getEsquema().". distribucion_inicial_cuv ORDER BY fecha_creacion DESC";
		return $this->modeloDistribucionInicialCuv->ejecutarSqlNativo($consulta);
	}
	public function ultimoValorCUVFin($arrayParametros)
	{
		$anio = $arrayParametros["anio"];
        $prefijo = $arrayParametros["prefijo_cuv_numerico"];
        $provincia = $arrayParametros["provincia"];
		$consulta = "SELECT dicuv.codigo_cuv_fin FROM g_asignacion_cuv.distribucion_inicial_cuv dicuv WHERE dicuv.anio = {$anio} AND dicuv.prefijo_cuv_numerico = '{$prefijo}' AND dicuv.provincia = '{$provincia}' ORDER BY dicuv.codigo_cuv_fin DESC LIMIT 1;" ;
		return $this->modeloDistribucionInicialCuv->ejecutarSqlNativo($consulta);
	}
	public function ultimoCodigoCUVFin($arrayParametros)
	{
		$anio = $arrayParametros["anio"];
		$consulta = "SELECT dicuv.codigo_cuv_fin FROM g_asignacion_cuv.distribucion_inicial_cuv dicuv WHERE dicuv.anio = {$anio} ORDER BY dicuv.codigo_cuv_fin DESC LIMIT 1;" ;
		return $this->modeloDistribucionInicialCuv->ejecutarSqlNativo($consulta);
	}
	public function solapamientoCuv($arrayParametros)
	{
		$anio = $arrayParametros["anio"];
        $prefijo = $arrayParametros["prefijo"];
		$inicio = $arrayParametros['inicio'];
		$fin = $arrayParametros['fin'];
		$consulta = "SELECT COUNT(*) as solapamiento, dicuv.provincia FROM g_asignacion_cuv.distribucion_inicial_cuv dicuv WHERE dicuv.codigo_cuv_inicio <= '{$fin}' AND dicuv.codigo_cuv_fin >= '{$inicio}'AND dicuv.anio = {$anio} AND dicuv.prefijo_cuv_numerico = '{$prefijo}' GROUP BY dicuv.provincia" ;
		return $this->modeloDistribucionInicialCuv->ejecutarSqlNativo($consulta);
	}
	public function buscarXanioYProvincia($arrayParametros) {
		$anio = $arrayParametros["anio"];
		$idProvincia = $arrayParametros["id_provincia"];
		$consulta = "SELECT * FROM g_asignacion_cuv.distribucion_inicial_cuv dicuv WHERE dicuv.estado = '1'";
	
		if ($anio !== 0) {
			$consulta .= " AND dicuv.anio = {$anio}";
		}
	
		if ($idProvincia !== 0) {
			$consulta .= " AND dicuv.id_provincia = {$idProvincia}";
		}
	
		return $this->modeloDistribucionInicialCuv->ejecutarSqlNativo($consulta);
	}

	public function buscarXanioYNombreProvincia($arrayParametros){
		$anio = $arrayParametros["anio"];
        $nombreProvincia = $arrayParametros["provinciaNombre"];
		$consulta = "SELECT * FROM g_asignacion_cuv.distribucion_inicial_cuv dicuv WHERE dicuv.anio = {$anio} AND dicuv.provincia = '{$nombreProvincia}' AND dicuv.estado = '1'" ;
		return $this->modeloDistribucionInicialCuv->ejecutarSqlNativo($consulta);

	}

	public function rangoCuvInicioFin($arrayParametros)
	{
		$idProvincia = $arrayParametros["idProvincia"];
		$prefijoCuvNumerico = $arrayParametros["prefijoCuvNumerico"];
		$anio = $arrayParametros["anio"];
		$consulta = "SELECT * FROM g_asignacion_cuv.distribucion_inicial_cuv dicuv WHERE dicuv.anio = '{$anio}' AND dicuv.id_provincia = '{$idProvincia}' AND dicuv.prefijo_cuv_numerico = '{$prefijoCuvNumerico}' ORDER BY dicuv.codigo_cuv_fin DESC LIMIT 1;" ;
		return $this->modeloDistribucionInicialCuv->ejecutarSqlNativo($consulta);
	}

	public function buscarCuvXProvinciasEntreFechas($arrayParametros)
	{
		$fechaInicio = $arrayParametros["fechaInicio"];
		$fechaFin = $arrayParametros["fechaFin"];
		$anio = $arrayParametros["anio"];
		$provincia = $arrayParametros["provincia"];
		$consulta = "SELECT
		TO_CHAR(dicv.fecha_creacion, 'DD/MM/YYYY') AS Fecha,
		dicv.provincia,
		COALESCE(dicv.cantidad::bigint, 0)- COALESCE(ec.cantidad::bigint, 0)-COALESCE(rc.cantidad::bigint, 0) as cuv_disponibles,
		'PPC-'||dicv.anio || '-' || dicv.prefijo_cuv_numerico || '-' || dicv.codigo_cuv_inicio AS Serie_Inicio,
		'PPC-'||dicv.anio || '-' || dicv.prefijo_cuv_numerico || '-' || dicv.codigo_cuv_fin AS Serie_Fin,
		COALESCE(ec.cantidad::bigint, 0) AS cuv_asignados,
		COALESCE(rc.cantidad, 0) AS cuv_entregados,
		dicv.cantidad::bigint AS total
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
			sac.anio = '{$anio}' -- Eliminamos las condiciones específicas de provincia y prefijo_cuv_numerico
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
		src.anio = '{$anio}' -- Eliminamos las condiciones específicas de provincia y prefijo_cuv_numerico
	GROUP BY 
		src.id_provincia_origen, 
		src.prefijo_cuv_numerico, 
		src.anio
	) AS rc ON dicv.id_provincia = rc.id_provincia_origen
		AND dicv.prefijo_cuv_numerico = rc.prefijo_cuv_numerico
		AND dicv.anio = rc.anio
	WHERE 
		dicv.anio = '{$anio}' -- Eliminamos las condiciones específicas de provincia y prefijo_cuv_numerico;
		" ;
		if (!empty($fechaInicio)) {
			$consulta .= " AND dicv.fecha_creacion >= '{$fechaInicio}'";
		}
		
		if (!empty($fechaFin)) {
			$consulta .= " AND dicv.fecha_creacion <= '{$fechaFin}'";
		}

		if (!empty($provincia)) {
			$consulta .= " AND dicv.id_provincia = '{$provincia}'";
		}

		return $this->modeloDistribucionInicialCuv->ejecutarSqlNativo($consulta);
	}

	public function exportarArchivoExcelCuvs($datos)
    {
		$fecha_actual = date("d_m_Y");
        $hoja = new Spreadsheet();
        $documento = $hoja->getActiveSheet();
        $i = 3;
        $j = 2;

		// Combinar celdas para el título
		$documento->mergeCells('A1:H1');
		$documento->setCellValue('A1', 'INFORME DE CUV EN PROVINCIAS');
		// Configurar estilo para el título centrado
		$tituloStyle = [
			'alignment' => [
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER,
			],
			'font' => [
				'bold' => true,
				'size' => 16,
			],
		];

		$documento->getStyle('A1')->applyFromArray($tituloStyle);
		$documento->getStyle('A1:H1')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THICK)->setColor(new Color('000000'));

        $documento->setCellValueByColumnAndRow(1, $j, 'Fecha');
        $documento->setCellValueByColumnAndRow(2, $j, 'Provincia');
        $documento->setCellValueByColumnAndRow(3, $j, 'CUV Disponible');
        $documento->setCellValueByColumnAndRow(4, $j, 'Serie Inicio');
        $documento->setCellValueByColumnAndRow(5, $j, 'Serie Fin');
        $documento->setCellValueByColumnAndRow(6, $j, 'Cuv Asignados');
        $documento->setCellValueByColumnAndRow(7, $j, 'Cuv Entregados');
        $documento->setCellValueByColumnAndRow(8, $j, 'Total');

		for ($col = 1; $col <= 8; $col++) {
			$documento->getStyleByColumnAndRow($col, $j)->applyFromArray([
				'borders' => [
					'outline' => [
						'borderStyle' => Border::BORDER_THICK,
						'color' => ['argb' => '000000'], // Color del borde (negro)
					],
				],
				'font' => [
					'bold' => true, // Texto en negrita
				],
			]);
		}
		
		$j++; 
		

        if ($datos != '') {
            foreach ($datos as $fila) {
                $documento->setCellValueByColumnAndRow(1, $i, $fila['fecha']);
                $documento->setCellValueByColumnAndRow(2, $i, $fila['provincia']);
                $documento->setCellValueByColumnAndRow(3, $i, $fila['cuv_disponibles']);
                $documento->setCellValueByColumnAndRow(4, $i, $fila['serie_inicio']);
                $documento->setCellValueByColumnAndRow(5, $i, $fila['serie_fin']);
                $documento->setCellValueByColumnAndRow(6, $i, $fila['cuv_asignados']);
                $documento->setCellValueByColumnAndRow(7, $i, $fila['cuv_entregados']);
                $documento->setCellValueByColumnAndRow(8, $i, $fila['total']);
				// Aplicar bordes a la fila actual de datos
				$documento->getStyle("A$i:H$i")->applyFromArray([
					'borders' => [
						'allBorders' => [
							'borderStyle' => Border::BORDER_THIN,
							'color' => ['argb' => '000000'], // Color del borde (negro)
						],
					],
				]);
                $i ++;
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Informe_Cuv_Provincia_'.$fecha_actual.'.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $writer = IOFactory::createWriter($hoja, 'Xlsx');
        $writer->save('php://output');
        exit();
    }


	public function buscarOperadoresEntreFechas($arrayParametros)
	{
		$fechaInicio = $arrayParametros["fechaInicio"];
		$fechaFin = $arrayParametros["fechaFin"];
		$anio = $arrayParametros["anio"];
		$operador = $arrayParametros["operador"];
		$consulta = "WITH primera_consulta AS (
			SELECT
				sac.fecha_creacion AS fecha_creacion,
				sac.operador_solicitante AS operador_solicitante,
				sac.tecnico_aprobo AS tecnico_aprobo,
				sac.cantidad_solicitada AS cantidad_solicitada,
				ec.cantidad AS cuv_usados,
				COALESCE(dic.cantidad::numeric, 0) - COALESCE(ecsc.cantidad::numeric, 0) - COALESCE(rc.cantidad::numeric, 0) as cuv_disponible,
				ec.codigo_cuv_inicio,
				ec.codigo_cuv_fin
				
			FROM
				g_asignacion_cuv.solicitud_asignacion_cuv sac
			LEFT JOIN
				g_asignacion_cuv.distribucion_inicial_cuv dic
			ON
				sac.id_provincia = dic.id_provincia
			AND
				sac.anio = dic.anio
			LEFT JOIN
				g_asignacion_cuv.entregas_cuv ec
			ON
				sac.id_solicitud_asignacion_cuv = ec.id_solicitud_asignacion_cuv
			--
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
					sac.anio = '{$anio}'
				GROUP BY
					sac.id_provincia,
					sac.prefijo_cuv_numerico,
					sac.anio
			) AS ecsc ON dic.id_provincia = ecsc.id_provincia
				AND dic.prefijo_cuv_numerico = ecsc.prefijo_cuv_numerico
				AND dic.anio = ecsc.anio
			--
			--
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
				src.anio = '{$anio}'
			GROUP BY 
				src.id_provincia_origen, 
				src.prefijo_cuv_numerico, 
				src.anio
			) AS rc ON dic.id_provincia = rc.id_provincia_origen
				AND dic.prefijo_cuv_numerico = rc.prefijo_cuv_numerico
				AND dic.anio = rc.anio
			--
			WHERE
				sac.anio = '{$anio}'
				and sac.estado_solicitud = 'Aprobada'
			),
			segunda_consulta AS (
			SELECT 
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
			top.id_area || top.codigo IN ('SAOPI', 'SAOPT')
			and op.estado = 'registrado'
			GROUP BY 1, 2, 3
			
			)
			
			SELECT
				TO_CHAR(pc.fecha_creacion, 'DD/MM/YYYY') AS Fecha,
				pc.operador_solicitante,
				pc.tecnico_aprobo,
				pc.cantidad_solicitada,
				pc.cuv_usados,
				pc.cuv_disponible,
				pc.codigo_cuv_inicio,
				pc.codigo_cuv_fin,
				sc.nombre_razon_social,
				sc.representante_legal,
				sc.operaciones_registradas
			FROM
				primera_consulta pc
			JOIN
				segunda_consulta sc
			ON
				pc.operador_solicitante = sc.nombre_razon_social
			" ;
		if (!empty($fechaInicio)) {
			$consulta .= " AND pc.fecha_creacion >= '{$fechaInicio}'";
		}
		
		if (!empty($fechaFin)) {
			$consulta .= " AND pc.fecha_creacion <= '{$fechaFin}'";
		}

		if (!empty($operador) && $operador !== 'Todos') {
			$consulta .= " AND sc.operaciones_registradas ='{$operador}'";
		}

		return $this->modeloDistribucionInicialCuv->ejecutarSqlNativo($consulta);
	}

	public function exportarArchivoExcelProveedorCuvs($datos)
    {
		$fecha_actual = date("d_m_Y");
        $hoja = new Spreadsheet();
        $documento = $hoja->getActiveSheet();
        $i = 3;
        $j = 2;

		// Combinar celdas para el título
		$documento->mergeCells('A1:K1');
		$documento->setCellValue('A1', 'INFORME DE CUV POR OPERADOR');
		// Configurar estilo para el título centrado
		$tituloStyle = [
			'alignment' => [
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER,
			],
			'font' => [
				'bold' => true,
				'size' => 16,
			],
		];

		$documento->getStyle('A1')->applyFromArray($tituloStyle);
		$documento->getStyle('A1:K1')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THICK)->setColor(new Color('000000'));

        $documento->setCellValueByColumnAndRow(1, $j, 'Fecha');
        $documento->setCellValueByColumnAndRow(2, $j, 'Operador Solicitante');
        $documento->setCellValueByColumnAndRow(3, $j, 'Tecnico Aprobo');
        $documento->setCellValueByColumnAndRow(4, $j, 'Cantidad Solicitada');
        $documento->setCellValueByColumnAndRow(5, $j, 'Cuv Usados');
        $documento->setCellValueByColumnAndRow(6, $j, 'Cuv Disponible');
        $documento->setCellValueByColumnAndRow(7, $j, 'Código Cuv Inicio');
        $documento->setCellValueByColumnAndRow(8, $j, 'Código Cuv Fin');
        $documento->setCellValueByColumnAndRow(9, $j, 'Nombre Razon Social');
        $documento->setCellValueByColumnAndRow(10, $j, 'Representante Legal');
        $documento->setCellValueByColumnAndRow(11, $j, 'Operaciones Registradas');

		for ($col = 1; $col <= 11; $col++) {
			$documento->getStyleByColumnAndRow($col, $j)->applyFromArray([
				'borders' => [
					'outline' => [
						'borderStyle' => Border::BORDER_THICK,
						'color' => ['argb' => '000000'], // Color del borde (negro)
					],
				],
				'font' => [
					'bold' => true, // Texto en negrita
				],
			]);
		}
		
		$j++; 
		

        if ($datos != '') {
            foreach ($datos as $fila) {
                $documento->setCellValueByColumnAndRow(1, $i, $fila['fecha']);
                $documento->setCellValueByColumnAndRow(2, $i, $fila['operador_solicitante']);
                $documento->setCellValueByColumnAndRow(3, $i, $fila['tecnico_aprobo']);
                $documento->setCellValueByColumnAndRow(4, $i, $fila['cantidad_solicitada']);
                $documento->setCellValueByColumnAndRow(5, $i, $fila['cuv_usados']);
                $documento->setCellValueByColumnAndRow(6, $i, $fila['cuv_disponible']);
                $documento->setCellValueByColumnAndRow(7, $i, $fila['codigo_cuv_inicio']);
                $documento->setCellValueByColumnAndRow(8, $i, $fila['codigo_cuv_fin']);
                $documento->setCellValueByColumnAndRow(9, $i, $fila['nombre_razon_social']);
                $documento->setCellValueByColumnAndRow(10, $i, $fila['representante_legal']);
                $documento->setCellValueByColumnAndRow(11, $i, $fila['operaciones_registradas']);
				// Aplicar bordes a la fila actual de datos
				$documento->getStyle("A$i:K$i")->applyFromArray([
					'borders' => [
						'allBorders' => [
							'borderStyle' => Border::BORDER_THIN,
							'color' => ['argb' => '000000'], // Color del borde (negro)
						],
					],
				]);
                $i ++;
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Informe_Operadores_Cuvs_'.$fecha_actual.'.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $writer = IOFactory::createWriter($hoja, 'Xlsx');
        $writer->save('php://output');
        exit();
    }
	
}
