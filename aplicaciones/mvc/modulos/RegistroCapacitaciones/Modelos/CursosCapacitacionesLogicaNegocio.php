<?php
 /**
 * Lógica del negocio de CursosCapacitacionesModelo
 *
 * Este archivo se complementa con el archivo CursosCapacitacionesControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    CursosCapacitacionesLogicaNegocio
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroCapacitaciones\Modelos;
  
  use Agrodb\RegistroCapacitaciones\Modelos\IModelo;
  use Agrodb\Core\Excepciones\GuardarExcepcion;
  
  use PhpOffice\PhpSpreadsheet\IOFactory;
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use Agrodb\Core\JasperReport;
  
 
class CursosCapacitacionesLogicaNegocio implements IModelo 
{

	 private $modeloCursosCapacitaciones = null;
	 private $idDatoCurso = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloCursosCapacitaciones = new CursosCapacitacionesModelo();
	
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos){
		try{
			
			$idDatoCurso = '';
			$tablaModelo = new CursosCapacitacionesModelo($datos);
			$procesoIngreso = $this->modeloCursosCapacitaciones->getAdapter()
				->getDriver()
				->getConnection();
			$procesoIngreso->beginTransaction();
			$datosBd = $tablaModelo->getPrepararDatos();
			if (isset($datos['id_curso_capacitacion']) != '' ) {
				
				$idDatoCurso = $datos['id_curso_capacitacion'];
			} else {
				unset($datosBd["id_curso_capacitacion"]);
				$idDatoCurso = $this->modeloCursosCapacitaciones->guardar($datosBd);
			}

		//guardo los temas en la tabla temas cursos
		$statement = $this->modeloCursosCapacitaciones->getAdapter()
			->getDriver()
			->createStatement();

		$temas = isset($_POST['temas']) ? $_POST['temas'] : '';
		if((is_countable($temas)) && count($temas) > 0){
			for ($i = 0; $i < count($temas); $i ++){
				$datosTemas = array(
					'nombre_tema' => $temas[$i],
					'id_curso_capacitacion' => $idDatoCurso
				);
	
			$sqlInsertar = $this->modeloCursosCapacitaciones->guardarSql('temas_cursos', $this->modeloCursosCapacitaciones->getEsquema());
			$sqlInsertar->columns(array_keys($datosTemas));
			$sqlInsertar->values($datosTemas, $sqlInsertar::VALUES_MERGE);
			$sqlInsertar->prepareStatement($this->modeloCursosCapacitaciones->getAdapter(), $statement);
			$statement->execute();
			}
		}

		//guardo los datos en la tabla publico objetivo
		$statement = $this->modeloCursosCapacitaciones->getAdapter()
		->getDriver()
		->createStatement();
		$idCatalogoPublico = isset($_POST['idCatalogoPublico']) ? $_POST['idCatalogoPublico'] : '';
		$publico = isset($_POST['publico']) ? $_POST['publico'] : '';
		if((is_countable($idCatalogoPublico)) && count($idCatalogoPublico) > 0){
			for ($i = 0; $i < count($idCatalogoPublico); $i ++){
				$datosPublico = array(
					'id_catalogo_publico' =>$idCatalogoPublico[$i],
					'nombre_publico' => $publico[$i],
					'id_curso_capacitacion' => $idDatoCurso
				);
				
			$sqlInsertar = $this->modeloCursosCapacitaciones->guardarSql('publico_objetivo', $this->modeloCursosCapacitaciones->getEsquema());
			$sqlInsertar->columns(array_keys($datosPublico));
			$sqlInsertar->values($datosPublico, $sqlInsertar::VALUES_MERGE);
			$sqlInsertar->prepareStatement($this->modeloCursosCapacitaciones->getAdapter(), $statement);
			$statement->execute();
			}
		}
		$procesoIngreso->commit();

			
	}catch (GuardarExcepcion $ex){
		$procesoIngreso->rollback();
		throw new \Exception($ex->getMessage());
	}
				
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloCursosCapacitaciones->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return CursosCapacitacionesModelo
	*/
	public function buscar($id)
	{
		return $this->modeloCursosCapacitaciones->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloCursosCapacitaciones->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloCursosCapacitaciones->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarCursosCapacitaciones()
	{
	$consulta = "SELECT * FROM ".$this->modeloCursosCapacitaciones->getEsquema().". cursos_capacitaciones";
		 return $this->modeloCursosCapacitaciones->ejecutarSqlNativo($consulta);
	}


	
			//funcion que lista los cursos dados criterios de busqueda
	public function buscarCapacitacionesFiltradas($arrayParametros){ 
	$busqueda = '';

	if (isset($arrayParametros['id_coordinacion']) && ($arrayParametros['id_coordinacion'] != '')) {
		$busqueda .= " cc.id_coordinacion = '" . $arrayParametros['id_coordinacion'] . "'";

		if (isset($arrayParametros['id_direccion']) && ($arrayParametros['id_direccion'] != '')) {
			$busqueda .= " and cc.id_direccion = '" . $arrayParametros['id_direccion'] . "'";
		}
		if (isset($arrayParametros['nombre_curso']) && ($arrayParametros['nombre_curso'] != '')) {
	  	   
			$busqueda .= " and cc.nombre_curso ilike ('%".$arrayParametros['nombre_curso']."%')";
		}
	}else if (isset($arrayParametros['nombre_curso']) && ($arrayParametros['nombre_curso'] != '')) {
	  	   
        $busqueda .= " cc.nombre_curso ilike ('%".$arrayParametros['nombre_curso']."%')";
	}

		$consulta = "SELECT cc.nombre_curso, cc.normativa, ad.nombre, cc.id_curso_capacitacion  
				from g_administracion_capacitaciones.cursos_capacitaciones cc
				INNER JOIN g_estructura.area ac
					ON cc.id_coordinacion = ac.id_area 
				INNER JOIN g_estructura.area ad
					ON cc.id_direccion = ad.id_area
				WHERE
					" . $busqueda . " and cc.estado =1
					ORDER BY
					cc.id_curso_capacitacion ASC;";
	return $this->modeloCursosCapacitaciones->ejecutarSqlNativo($consulta);
    }

	//funcion que obtiene los cursos de capacitacion con los nombres de la coordinacion y direccion para la vista editar
	public function obtenerCursoCapacitacion($id){
		$consulta = "SELECT cc.id_curso_capacitacion, cc.nombre_curso, cc.objetivo, cc.normativa, ac.nombre as nombre_coordinacion, ad.nombre as nombre_direccion 
			from g_administracion_capacitaciones.cursos_capacitaciones cc
				INNER JOIN g_estructura.area ac
					ON cc.id_coordinacion = ac.id_area 
				INNER JOIN g_estructura.area ad
					ON cc.id_direccion = ad.id_area 
				where id_curso_capacitacion = $id ;";	
		
		return $this->modeloCursosCapacitaciones->ejecutarSqlNativo($consulta);
	}

	//funcion que obtiene los cursos de capacitacion con los nombres de la coordinacion y direccion para la vista editar
	public function obtenerCursoCapacitacionXCoordinacionXDireccion($idCoordinacion, $idDireccion){
		$consulta = "SELECT cc.id_curso_capacitacion, cc.nombre_curso
				from  g_administracion_capacitaciones.cursos_capacitaciones cc
				where cc.id_coordinacion = '$idCoordinacion' AND cc.id_direccion = '$idDireccion' AND cc.estado = 1;";	
		return $this->modeloCursosCapacitaciones->ejecutarSqlNativo($consulta);
	}
    //funcion que buscar si un curso de capacitacion ya fue registrado
	public function buscarCursoCapacitacionXNombre($nombreCurso,$idCoordinacion,$idDireccion){
		$consulta = "SELECT * 
							FROM g_administracion_capacitaciones.cursos_capacitaciones
							WHERE 
								nombre_curso = '$nombreCurso'and
								id_coordinacion = '$idCoordinacion' and
								id_direccion = '$idDireccion' and estado =1;";
	   return $this->modeloCursosCapacitaciones->ejecutarSqlNativo($consulta);
    }

	//funcion que buscar si un curso de capacitacion ya fue registrado
	public function buscarTemasXCursoCapacitacion($nombretema){
		$consulta = "SELECT * 
			FROM g_administracion_capacitaciones.temas_cursos
			WHERE nombre_tema = '$nombretema';";
	   return $this->modeloCursosCapacitaciones->ejecutarSqlNativo($consulta);
    }

	//funcion que obtiene el tecnico logeado
	public function obtenerDatosTecnico($identificador){
		$consulta = "SELECT dc.nombre_puesto as cargoTecnico
					FROM g_uath.datos_contrato dc
					where dc.identificador = '$identificador'
					and dc.estado = 1";	
		
		return $this->modeloCursosCapacitaciones->ejecutarSqlNativo($consulta);
	}

	//funcion cursos de capacitaciones por identificador
	public function obtenerCursosCApacitacionXIdentificador($identificador){
		$consulta = "SELECT cc.identificador,cc.nombre_curso, cc.normativa, ad.nombre, cc.id_curso_capacitacion 
					FROM g_administracion_capacitaciones.cursos_capacitaciones cc 
					INNER JOIN g_estructura.area ac ON cc.id_coordinacion = ac.id_area
					INNER JOIN g_estructura.area ad ON cc.id_direccion = ad.id_area 
					WHERE cc.identificador = '". $identificador ."' AND cc.estado =1 ORDER BY cc.id_curso_capacitacion DESC;";			
		return $this->modeloCursosCapacitaciones->ejecutarSqlNativo($consulta);
	}

	public function buscarCursosCapacitacionReporteFiltrados($arrayParametros)
    {
       	
		$busqueda = 'True';
                
        if (isset($arrayParametros['fecha_inicio']) && ($arrayParametros['fecha_inicio'] != '') && (isset($arrayParametros['fecha_fin']) && ($arrayParametros['fecha_fin'] != '') )) {
            
			$busqueda .= " AND ci.fecha_creacion BETWEEN '" . $arrayParametros['fecha_inicio'] . "' AND  '" . $arrayParametros['fecha_fin'] . "'";
        }
        
        if (isset($arrayParametros['id_coordinacion']) && ($arrayParametros['id_coordinacion'] != '')) {
            $busqueda .= " and ci.id_coordinacion = '" . $arrayParametros['id_coordinacion'] . "'";
        }
        
        if (isset($arrayParametros['id_direccion']) && ($arrayParametros['id_direccion'] != '')) {
            $busqueda .= " and ci.id_direccion = '" . $arrayParametros['id_direccion'] . "'";
        }
        
        if (isset($arrayParametros['id_curso_capacitacion']) && ($arrayParametros['id_curso_capacitacion'] != '') && ($arrayParametros['id_curso_capacitacion'] != 'Seleccione....') ) {
            $busqueda .= " and cc.id_curso_capacitacion = '" . $arrayParametros['id_curso_capacitacion'] . "'";
        }

		if (isset($arrayParametros['cod_provincia']) &&  ($arrayParametros['cod_provincia'] != '')) {
          
				$busqueda .= " and ci.id_provincia = " . $arrayParametros['id_provincia']." AND ci.nombre_oficina in ('Oficina Planta Central')";
        }else{
		
			if (isset($arrayParametros['id_provincia']) && ($arrayParametros['id_provincia'] != '')) {
				$busqueda .= " and ci.id_provincia = " . $arrayParametros['id_provincia']." AND ci.nombre_oficina not in ('Oficina Planta Central')";
			}
		}
	
                
        	$consulta = " SELECT 
							distinct ci.id_curso_impartido
							,STRING_AGG(distinct (cap.nombre_capacitador), ',') as nombre_capacitador 
							, femenino.cantidad AS femenino , masculino.cantidad AS masculino 
							, ci.fecha_creacion, ci.fecha_ejecucion , ci.nombre_provincia , ci.nombre_canton 
							, ci.nombre_parroquia , ci.sitio , ci.total_asistentes 
							, cc.nombre_curso 
							,STRING_AGG(distinct (te.nombre_temas_ejecutado), ',') as nombre_tema 
							, ci.conclusion,ci.tipo,ci.archivo_constancia_asistentes,ci.archivo_evidencia
							FROM g_administracion_capacitaciones.cursos_impartidos ci 
								INNER JOIN g_administracion_capacitaciones.cursos_capacitaciones cc 
								ON ci.id_curso_capacitacion = cc.id_curso_capacitacion 
								INNER JOIN g_administracion_capacitaciones.temas_ejecutados te
								ON te.id_curso_impartido = ci.id_curso_impartido 
								INNER JOIN g_administracion_capacitaciones.capacitadores cap 
								ON cap.id_curso_impartido = ci.id_curso_impartido 
								INNER JOIN g_administracion_capacitaciones.publico_asistente pa 
								ON pa.id_curso_impartido = ci.id_curso_impartido 
								INNER JOIN g_administracion_capacitaciones.publico_asistente femenino
								ON femenino.id_curso_impartido = ci.id_curso_impartido 
								INNER JOIN g_administracion_capacitaciones.publico_asistente masculino
								ON masculino.id_curso_impartido = ci.id_curso_impartido 
							WHERE " . $busqueda . " and femenino.genero = 'Femenino' and masculino.genero = 'Masculino' and ci.identificador is not null  and ci.identificador<>''
								GROUP BY ci.id_curso_impartido , ci.fecha_ejecucion , ci.nombre_provincia , ci.nombre_canton 
								, ci.nombre_parroquia, ci.sitio , ci.total_asistentes , cc.nombre_curso 
								, ci.conclusion , femenino.cantidad , masculino.cantidad";
        return $this->modeloCursosCapacitaciones->ejecutarSqlNativo($consulta);
    }
    

	/**
     * Ejecuta un reporte en Excel de los pasaportes
     *
     * @return array|ResultSet
     */
    public function exportarArchivoExcelCursosCapacitacion($cursosCapacitacion){
			
		$hoja = new Spreadsheet();
		$documento = $hoja->getActiveSheet();
		$i = 3;
		
		$estiloArrayTitulo = [
		    'alignment' => [
		        'horizontal' => 'center',
		        'vertical' => 'center',
		    ],
		    'font' => [
		        'name' => 'Calibri',
		        'bold' => true,
		        'size' => 18
		    ]
		];
		
		$estiloArrayCabecera = [
		    'alignment' => [
		        'horizontal' => 'center',
		        'vertical' => 'center',
		    ],
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => 'thin',
		            'color' => ['argb' => 'FF000000'],
		        ],
		    ],
		    'font' => [
		        'name' => 'Calibri',
		        'bold' => true,
		        'size' => 11,
		        'color' => ['argb' => 'FFFFFFFF'],
		    ],
		    'fill' => [
		        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
		        'rotation' => 90,
		        'startColor' => [
		            'argb' => 'FF6495ED',
		        ],
		        'endColor' => [
		            'argb' => 'FF6495ED',
		        ],
		    ],
		];
		
		$documento->getStyle('A1:D1')->applyFromArray($estiloArrayTitulo);
		$documento->getStyle('A2:P2')->applyFromArray($estiloArrayCabecera);
		
		$documento->setCellValueByColumnAndRow(1, 1, 'MATRIZ DE CAPACITACIONES');
		$documento->mergeCells('A1:M1');
		$documento->getColumnDimension('A')->setAutoSize(true);
		$documento->getColumnDimension('B')->setAutoSize(true);
		$documento->getColumnDimension('C')->setAutoSize(true);
		$documento->getColumnDimension('D')->setAutoSize(true);
		$documento->getColumnDimension('E')->setAutoSize(true);
		$documento->getColumnDimension('F')->setAutoSize(true);
		$documento->getColumnDimension('G')->setAutoSize(true);
		$documento->getColumnDimension('H')->setAutoSize(true);
		$documento->getColumnDimension('I')->setAutoSize(true);
		$documento->getColumnDimension('J')->setAutoSize(true);
		$documento->getColumnDimension('K')->setAutoSize(true);
		$documento->getColumnDimension('L')->setAutoSize(true);
		$documento->getColumnDimension('M')->setAutoSize(true);
		$documento->getColumnDimension('N')->setAutoSize(true);
		$documento->getColumnDimension('O')->setAutoSize(true);
		$documento->getColumnDimension('P')->setAutoSize(true);
		
		$documento->setCellValue('A2','FECHA DE REGISTRO');
		$documento->setCellValue('B2','FECHA DE CAPACITACIÓN');
		$documento->setCellValue('C2','NOMBRE DEL RESPONSABLE DE CAPACITACIÓN');
		$documento->setCellValue('D2','PROVINCIA');
		$documento->setCellValue('E2','CANTÓN');
		$documento->setCellValue('F2','PARROQUIA');
		$documento->setCellValue('G2','SITIO ESPECÍFICO');
		$documento->setCellValue('H2','TOTAL HOMBRES');
		$documento->setCellValue('I2','TOTAL MUJERES');
		$documento->setCellValue('J2','PARTICIPANTES TOTAL');
		$documento->setCellValue('K2','TIPO CAPACITACIÓN');
		$documento->setCellValue('L2','TEMA DE CAPACITACIÓN');
		$documento->setCellValue('M2','TEMA ESPECÍFICO');
		$documento->setCellValue('N2','CONCLUSIÓN / RECOMENDACIÓN');
		$documento->setCellValue('O2','ARCHIVO ASISTENTES');
		$documento->setCellValue('P2','ARCHIVO EVIDENCIA');
		
		

		if ($cursosCapacitacion != ''){

			$i = 3;
				foreach ($cursosCapacitacion as $fila){

				

					if ($fila['archivo_constancia_asistentes'] === "0" || $fila['archivo_constancia_asistentes'] =='No se cargó archivo. Extención incorrecta'){
						$asistencia = "archivo no encontrado ";
					}else{
						$linkAsistencia = explode('/', $fila['archivo_constancia_asistentes']);
						$asistencia = (URL_PROTOCOL . URL_DOMAIN . URL_GUIA . REG_CAP_URL_ARCH."asistencias/".$linkAsistencia[6]);
						
					}

					
					if ($fila['archivo_evidencia'] === "0" || $fila['archivo_evidencia'] =='No se cargó archivo. Extención incorrecta'){
						$evidencia = "archivo no encontrado ";
					}else{
						
						$linkEvidencia = explode('/', $fila['archivo_evidencia']);
						$evidencia = (URL_PROTOCOL . URL_DOMAIN . URL_GUIA . REG_CAP_URL_ARCH."evidencias/".$linkEvidencia[6]);
					}
				
					$documento->setCellValueByColumnAndRow(1, $i,date("Y-m-d",strtotime($fila['fecha_creacion'])));
					$documento->setCellValueByColumnAndRow(2, $i,date("Y-m-d",strtotime($fila['fecha_ejecucion'])));
					$documento->setCellValueByColumnAndRow(3, $i, $fila['nombre_capacitador']);
					$documento->setCellValueByColumnAndRow(4, $i, $fila['nombre_provincia']);
					$documento->setCellValueByColumnAndRow(5, $i, $fila['nombre_canton']);
					$documento->setCellValueByColumnAndRow(6, $i, $fila['nombre_parroquia']);
					$documento->setCellValueByColumnAndRow(7, $i, $fila['sitio']);
					$documento->setCellValueByColumnAndRow(8, $i, $fila['masculino']);
					$documento->setCellValueByColumnAndRow(9, $i, $fila['femenino']);
					$documento->setCellValueByColumnAndRow(10, $i, $fila['total_asistentes']);
					$documento->setCellValueByColumnAndRow(11, $i, $fila['tipo']);
					$documento->setCellValueByColumnAndRow(12, $i, $fila['nombre_curso']);
					$documento->setCellValueByColumnAndRow(13, $i, $fila['nombre_tema']);
					$documento->setCellValueByColumnAndRow(14, $i, $fila['conclusion']);
					$documento->setCellValueByColumnAndRow(15, $i, $asistencia);
					$documento->setCellValueByColumnAndRow(16, $i, $evidencia);
					
					$i++;
				}
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="excelMatrizCapacitaciones.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $writer = IOFactory::createWriter($hoja, 'Xlsx');
        $writer->save('php://output');
        exit();
	}
}
