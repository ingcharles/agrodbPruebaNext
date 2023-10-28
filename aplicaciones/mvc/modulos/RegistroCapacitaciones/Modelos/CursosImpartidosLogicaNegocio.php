<?php
 /**
 * Lógica del negocio de CursosImpartidosModelo
 *
 * Este archivo se complementa con el archivo CursosImpartidosControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    CursosImpartidosLogicaNegocio
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroCapacitaciones\Modelos;
  
  use Agrodb\RegistroCapacitaciones\Modelos\IModelo;
  use Agrodb\Core\Excepciones\GuardarExcepcion;

 
class CursosImpartidosLogicaNegocio implements IModelo 
{

	 private $modeloCursosImpartidos = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloCursosImpartidos = new CursosImpartidosModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		try{


		$tablaModelo = new CursosImpartidosModelo($datos);
		$procesoIngreso = $this->modeloCursosImpartidos->getAdapter()
			->getDriver()
			->getConnection();
		$procesoIngreso->beginTransaction();
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdCursoImpartido() != null && $tablaModelo->getIdCursoImpartido() > 0) {
			return $this->modeloCursosImpartidos->actualizar($datosBd, $tablaModelo->getIdCursoImpartido());
		} else {
			unset($datosBd["id_curso_impartido"]);
			$idCursoImpartido = $this->modeloCursosImpartidos->guardar($datosBd);
		}
		//tabla temas ejecutados
		$statement = $this->modeloCursosImpartidos->getAdapter()
		->getDriver()
		->createStatement();
		
		$idTemasCursos = isset($_POST['arrayIdTemasCursos']) ? $_POST['arrayIdTemasCursos'] : '';
		$nombreTemasCursos = isset($_POST['arrayNombreTemasCursos']) ? $_POST['arrayNombreTemasCursos'] : '';
		if((is_countable($idTemasCursos)) && ((is_countable($nombreTemasCursos)) )){
			for ($i = 0; $i < count($idTemasCursos); $i ++){
				$datosTemasEjecutados = array(
					'id_tema_curso' =>$idTemasCursos[$i],
					'nombre_temas_ejecutado' => $nombreTemasCursos[$i],
					'id_curso_impartido' => $idCursoImpartido
				);
				$sqlInsertar = $this->modeloCursosImpartidos->guardarSql('temas_ejecutados', $this->modeloCursosImpartidos->getEsquema());
				$sqlInsertar->columns(array_keys($datosTemasEjecutados));
				$sqlInsertar->values($datosTemasEjecutados, $sqlInsertar::VALUES_MERGE);
				$sqlInsertar->prepareStatement($this->modeloCursosImpartidos->getAdapter(), $statement);
				$statement->execute();
			}
		}

	//guardo publico meta
	$statement = $this->modeloCursosImpartidos->getAdapter()
		->getDriver()
		->createStatement();
		
		$idPublicoMeta = isset($_POST['arrayIdPublicoMeta']) ? $_POST['arrayIdPublicoMeta'] : '';
		$nombrePublicoMeta = isset($_POST['arrayNombrePublicoMeta']) ? $_POST['arrayNombrePublicoMeta'] : '';
		if((is_countable($idPublicoMeta)) && ((is_countable($nombrePublicoMeta)) )){
			for ($i = 0; $i < count($idPublicoMeta); $i ++){
				$datosPublicoMeta = array(
					'id_publico_objetivo' =>$idPublicoMeta[$i],
					'nombre_publico' => $nombrePublicoMeta[$i],
					'id_curso_impartido' => $idCursoImpartido
				);
				$sqlInsertar = $this->modeloCursosImpartidos->guardarSql('publico_meta', $this->modeloCursosImpartidos->getEsquema());
				$sqlInsertar->columns(array_keys($datosPublicoMeta));
				$sqlInsertar->values($datosPublicoMeta, $sqlInsertar::VALUES_MERGE);
				$sqlInsertar->prepareStatement($this->modeloCursosImpartidos->getAdapter(), $statement);
				$statement->execute();
			}
		}
	//guardo detalle publico
	$statement = $this->modeloCursosImpartidos->getAdapter()
		->getDriver()
		->createStatement();
				
		if(count($datos['arrayGeneroDetalle']) < 2 ){
			if($datos['arrayGeneroDetalle'][0] == 'Masculino'){
				array_push($_POST['arrayGeneroDetalle'], 'Femenino');
				array_push($_POST['arrayCantidadDetalle'], 0);
			}else if ($datos['arrayGeneroDetalle'][0] == 'Femenino'){

				array_push($_POST['arrayGeneroDetalle'], 'Masculino');
				array_push($_POST['arrayCantidadDetalle'], 0);
			}
		}
		$cantidad = isset($_POST['arrayCantidadDetalle']) ? $_POST['arrayCantidadDetalle'] : '';
		$genero = isset($_POST['arrayGeneroDetalle']) ? $_POST['arrayGeneroDetalle'] : '';
		
		if((is_countable($cantidad)) && ((is_countable($genero)) )){
			for ($i = 0; $i < count($cantidad); $i ++){
				$datosPublicoAsistente = array(
					'cantidad' =>$cantidad[$i],
					'genero' => $genero[$i],
					'id_curso_impartido' => $idCursoImpartido
				);
				$sqlInsertar = $this->modeloCursosImpartidos->guardarSql('publico_asistente', $this->modeloCursosImpartidos->getEsquema());
				$sqlInsertar->columns(array_keys($datosPublicoAsistente));
				$sqlInsertar->values($datosPublicoAsistente, $sqlInsertar::VALUES_MERGE);
				$sqlInsertar->prepareStatement($this->modeloCursosImpartidos->getAdapter(), $statement);
				$statement->execute();
				
			}
		}
	//guardo datos capacitador
	$statement = $this->modeloCursosImpartidos->getAdapter()
		->getDriver()
		->createStatement();
		
		$identificadorCapacitador = isset($_POST['arrayIdentificador']) ? $_POST['arrayIdentificador'] : '';
		$nombreCapacitador = isset($_POST['arrayNombreCapacitador']) ? $_POST['arrayNombreCapacitador'] : '';
		$institucionCapacitador = isset($_POST['arrayInstitucionCapacitador']) ? $_POST['arrayInstitucionCapacitador'] : '';
		$idProvincia = isset($_POST['arrayIdProvincia']) ? $_POST['arrayIdProvincia'] : '';
		$nombreProvincia = isset($_POST['arrayNombreProvincia']) ? $_POST['arrayNombreProvincia'] : '';
		$idPais = isset($_POST['arrayIdPais']) ? $_POST['arrayIdPais'] : '';
		$nombrePais = isset($_POST['arrayNombrePais']) ? $_POST['arrayNombrePais'] : '';
		$tipoCapacitador= isset($_POST['arrayTipoCapacitador']) ? $_POST['arrayTipoCapacitador'] : '';

		if(is_countable($identificadorCapacitador)) {

			for ($i = 0; $i < count($identificadorCapacitador); $i ++){
				$datosCapacitador = array(
					'identificador_capacitador' =>$identificadorCapacitador[$i],
					'nombre_capacitador' => $nombreCapacitador[$i],
					'institucion' => $institucionCapacitador[$i],
					'id_provincia' => intval( $idProvincia[$i]),
					'nombre_provincia' => $nombreProvincia[$i],
					'id_pais' => intval($idPais[$i]),
					'nombre_pais' => $nombrePais[$i],
					'id_curso_impartido' => $idCursoImpartido,
					'tipo_capacitador' => $tipoCapacitador[$i],
				);
				$sqlInsertar = $this->modeloCursosImpartidos->guardarSql('capacitadores', $this->modeloCursosImpartidos->getEsquema());
				$sqlInsertar->columns(array_keys($datosCapacitador));
				$sqlInsertar->values($datosCapacitador, $sqlInsertar::VALUES_MERGE);
				$sqlInsertar->prepareStatement($this->modeloCursosImpartidos->getAdapter(), $statement);
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
		$this->modeloCursosImpartidos->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return CursosImpartidosModelo
	*/
	public function buscar($id)
	{
		return $this->modeloCursosImpartidos->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloCursosImpartidos->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloCursosImpartidos->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarCursosImpartidos()
	{
	$consulta = "SELECT * FROM ".$this->modeloCursosImpartidos->getEsquema().". cursos_impartidos";
		 return $this->modeloCursosImpartidos->ejecutarSqlNativo($consulta);
	}

	//funcion que lista los cursos dados criterios de busqueda
	public function buscarCapacitacionesFiltradas($arrayParametros){

		// print_r("<pre>");
		// print_r($arrayParametros) ;

		$busqueda = 'true ';
	
		if((isset($arrayParametros['fecha_inicio']) && ($arrayParametros['fecha_inicio'] != '')) && (isset($arrayParametros['fecha_fin']) && ($arrayParametros['fecha_fin'] != '')) && (isset($arrayParametros['nombre_curso']) && ($arrayParametros['nombre_curso'] != ''))){
			
			$busqueda .= " AND ci.fecha_ejecucion BETWEEN '" . $arrayParametros['fecha_inicio'] . "' AND  '" . $arrayParametros['fecha_fin'] . "' AND cc.nombre_curso ilike ('%".$arrayParametros['nombre_curso']."%')";
		
		}else if (isset($arrayParametros['fecha_inicio']) && ($arrayParametros['fecha_inicio'] != '') && isset($arrayParametros['fecha_fin']) && ($arrayParametros['fecha_fin'] != '')) {	 
			
			$busqueda .= " AND ci.fecha_ejecucion BETWEEN '" . $arrayParametros['fecha_inicio'] . "' AND  '" . $arrayParametros['fecha_fin']."'";
		
		}else if (isset($arrayParametros['nombre_curso']) && ($arrayParametros['nombre_curso'] != '')) {
			
			$busqueda .= " cc.nombre_curso ilike ('%".$arrayParametros['nombre_curso']."%')";
	
		}
	
		if((isset($arrayParametros['cedula']) && ($arrayParametros['cedula'] != ''))){
			$busqueda .= "AND ci.identificador ='" .$arrayParametros['cedula']."'";
		}
		if(isset($arrayParametros['coordinacion']) && $arrayParametros['coordinacion'] != '' && $arrayParametros['direccion'] != ''){
			$busqueda .="AND ci.id_coordinacion = '".$arrayParametros['coordinacion']."'
			AND ci.id_direccion = '".$arrayParametros['direccion']."'";
		}

		if ((isset($arrayParametros['perfil'])) && ($arrayParametros['perfil'] != '')){
			$busqueda = "";
		}else{
			$busqueda = 'where true ';
	
			if((isset($arrayParametros['fecha_inicio']) && ($arrayParametros['fecha_inicio'] != '')) && (isset($arrayParametros['fecha_fin']) && ($arrayParametros['fecha_fin'] != '')) && (isset($arrayParametros['nombre_curso']) && ($arrayParametros['nombre_curso'] != ''))){
				
				$busqueda .= " AND ci.fecha_ejecucion BETWEEN '" . $arrayParametros['fecha_inicio'] . "' AND  '" . $arrayParametros['fecha_fin'] . "' AND cc.nombre_curso ilike ('%".$arrayParametros['nombre_curso']."%')";
			
			}else if (isset($arrayParametros['fecha_inicio']) && ($arrayParametros['fecha_inicio'] != '') && isset($arrayParametros['fecha_fin']) && ($arrayParametros['fecha_fin'] != '')) {	 
				
				$busqueda .= " AND ci.fecha_ejecucion BETWEEN '" . $arrayParametros['fecha_inicio'] . "' AND  '" . $arrayParametros['fecha_fin']."'";
			
			}else if (isset($arrayParametros['nombre_curso']) && ($arrayParametros['nombre_curso'] != '')) {
				
				$busqueda .= " cc.nombre_curso ilike ('%".$arrayParametros['nombre_curso']."%')";
		
			}
		
			if((isset($arrayParametros['cedula']) && ($arrayParametros['cedula'] != ''))){
				$busqueda .= "AND ci.identificador ='" .$arrayParametros['cedula']."'";
			}
			if(isset($arrayParametros['coordinacion']) && $arrayParametros['coordinacion'] != '' && $arrayParametros['direccion'] != ''){
				$busqueda .="AND ci.id_coordinacion = '".$arrayParametros['coordinacion']."'
				AND ci.id_direccion = '".$arrayParametros['direccion']."'";
			}
		}
		if (isset($arrayParametros['provincia']) && $arrayParametros['provincia'] != '' && $arrayParametros['provincia'] != 'Seleccione....'){
			$busqueda .=" AND nombre_provincia ILIKE ('%".$arrayParametros['provincia']."%')";

		}
	
			$consulta = " SELECT 
							ci.id_curso_impartido
							,ci.fecha_ejecucion
							,cc.nombre_curso, ac.nombre as nombre_direccion
							,ci.tipo
							,ci.total_asistentes
							,ci.nombre_provincia
							from g_administracion_capacitaciones.cursos_impartidos ci 
								INNER JOIN g_administracion_capacitaciones.temas_ejecutados te 
									ON ci.id_curso_impartido = te.id_curso_impartido 
								INNER JOIN g_estructura.area ac
									ON ci.id_direccion = ac.id_area
								INNER JOIN g_administracion_capacitaciones.cursos_capacitaciones cc
									ON cc.id_curso_capacitacion = ci.id_curso_capacitacion
							 " . $busqueda . " 
							group by ci.id_curso_impartido,ci.fecha_ejecucion, cc.nombre_curso, ac.nombre , ci.tipo, ci.total_asistentes ORDER BY ci.id_curso_impartido DESC;";
		return $this->modeloCursosImpartidos->ejecutarSqlNativo($consulta);
	}
	
	public function obtenerCursoImpartidoXId($idCursoImpartido){
		$consulta = "SELECT  
						ci.fecha_ejecucion
						,ci.nombre_capacitacion
						,ci.tipo
						,ci.conclusion
						,ci.archivo_constancia_asistentes
						,ci.archivo_evidencia
						,ac.nombre as nombre_coordinacion
						,ad.nombre as nombre_direccion 
						,ci.nombre_provincia, 
						ci.nombre_canton
						,ci.nombre_parroquia
						,ci.nombre_oficina
						,ci.sitio
					from g_administracion_capacitaciones.cursos_impartidos ci
						INNER JOIN g_estructura.area ac
							ON ci.id_coordinacion = ac.id_area 
						INNER JOIN g_estructura.area ad
							ON ci.id_direccion = ad.id_area 
						INNER JOIN g_catalogos.localizacion lp
							ON lp.id_localizacion = ci.id_provincia
						where id_curso_impartido=$idCursoImpartido;";
		return $this->modeloCursosImpartidos->ejecutarSqlNativo($consulta);
	}

	public function eliminarCursoImpartidoXId($idCursoImpartido){
		$consulta = "SELECT * FROM g_administracion_capacitaciones.eliminar_curso_impartido($idCursoImpartido)";
		return $this->modeloCursosImpartidos->ejecutarSqlNativo($consulta);
	}

}
