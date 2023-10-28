<?php
 /**
 * Lógica del negocio de Vigilanciaf02Modelo
 *
 * Este archivo se complementa con el archivo Vigilanciaf02Controlador.
 *
 * @author  AGROCALIDAD
 * @date    2021/03/10
 * @uses    Vigilanciaf02LogicaNegocio
 * @package AplicacionMovilInternos
 * @subpackage Modelos
 */
  namespace Agrodb\FormulariosInspeccion\Modelos;
  
  use Agrodb\FormulariosInspeccion\Modelos\IModelo;
  use Agrodb\Core\Excepciones\GuardarExcepcion;
  use Agrodb\FormulariosInspeccion\Modelos\Vigilanciaf02DetalleOrdenesModelo;
use Exception;

class Vigilanciaf02LogicaNegocio implements IModelo 
{

	 private $modeloVigilanciaf02 = null;
	 private $modeloVigilanciaf02DetalleOrdenes = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloVigilanciaf02 = new Vigilanciaf02Modelo();
	 $this->modeloVigilanciaf02DetalleOrdenes = new Vigilanciaf02DetalleOrdenesModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new Vigilanciaf02Modelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getId() != null && $tablaModelo->getId() > 0) {
		return $this->modeloVigilanciaf02->actualizar($datosBd, $tablaModelo->getId());
		} else {
		unset($datosBd["id"]);
		return $this->modeloVigilanciaf02->guardar($datosBd);
	}

		
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloVigilanciaf02->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return Vigilanciaf02Modelo
	*/
	public function buscar($id)
	{
		return $this->modeloVigilanciaf02->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloVigilanciaf02->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloVigilanciaf02->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarVigilanciaf02()
	{
	$consulta = "SELECT * FROM ".$this->modeloVigilanciaf02->getEsquema().". vigilanciaf02";
		 return $this->modeloVigilanciaf02->ejecutarSqlNativo($consulta);
	}

	/**
	 * Guardar registro de vigilancia fitosanitaria
	 */
	public function guardarVigilancia($arrayParametros){

		$rutaArchivo = 'ruta foto';
		$link = '';

		if($arrayParametros['foto'] != ''){
			$rutaArchivo = 'modulos/AplicacionMovilInternos/archivos/fotosVigilanciaSV/'.md5(time()).'.jpg';
			file_put_contents($rutaArchivo, base64_decode($arrayParametros['foto']));
			$rutaArchivo = URL_PROTOCOL . URL_DOMAIN . URL_GUIA .'/mvc/'. $rutaArchivo;
			$link = '<a href="'.$rutaArchivo.'">Foto</a>';
		}else{
			$rutaArchivo = '';
		}

		$consulta = "INSERT INTO f_inspeccion.vigilanciaf02(
								id_tablet,
								codigo_provincia,
								nombre_provincia,
								codigo_canton,
								nombre_canton,
								codigo_parroquia,
								nombre_parroquia,
								nombre_propietario_finca,
								localidad_via,
								coordenada_x,
								coordenada_y,
								coordenada_z,
								denuncia_fitosanitaria,
								nombre_denunciante,
								telefono_denunciante,
								direccion_denunciante,
								correo_electronico_denunciante,
								especie_vegetal,
								cantidad_total,
								cantidad_vigilada,
								unidad,
								sitio_operacion,
								condicion_produccion,
								etapa_cultivo,
								actividad,
								manejo_sitio_operacion,
								ausencia_plaga,
								plaga_diagnostico_visual_prediagnostico,
								cantidad_afectada,
								porcentaje_incidencia,
								porcentaje_severidad,
								tipo_plaga,
								fase_desarrollo_plaga,
								organo_afectado,
								distribucion_plaga,
								poblacion,
								diagnostico_visual,
								descripcion_sintomas_p,
								envio_muestra,
								observaciones,
								fecha_inspeccion,
								usuario_id,
								usuario,
								tablet_id,
								tablet_version_base,
								ruta_foto,
								longitud_imagen,
								latitud_imagen,
								altura_imagen
								)
					VALUES('".$arrayParametros['id_tablet']."',
							'".$arrayParametros['codigo_provincia']."',
							'".$arrayParametros['nombre_provincia']."',
							'".$arrayParametros['codigo_canton']."',
							'".$arrayParametros['nombre_canton']."',
							'".$arrayParametros['codigo_parroquia']."',
							'".$arrayParametros['nombre_parroquia']."',
							'".$arrayParametros['nombre_propietario_finca']."',
							'".$arrayParametros['localidad_via']."',
							'".$arrayParametros['coordenada_x']."',
							'".$arrayParametros['coordenada_y']."',
							'".$arrayParametros['coordenada_z']."',
							'".$arrayParametros['denuncia_fitosanitaria']."',
							'".$arrayParametros['nombre_denunciante']."',
							'".$arrayParametros['telefono_denunciante']."',
							'".$arrayParametros['direccion_denunciante']."',
							'".$arrayParametros['correo_electronico_denunciante']."',
							'".$arrayParametros['especie_vegetal']."',
							'".$arrayParametros['cantidad_total']."',
							'".$arrayParametros['cantidad_vigilada']."',
							'".$arrayParametros['unidad']."',
							'".$arrayParametros['sitio_operacion']."',
							'".$arrayParametros['condicion_produccion']."',
							'".$arrayParametros['etapa_cultivo']."',
							'".$arrayParametros['actividad']."',
							'".$arrayParametros['manejo_sitio_operacion']."',
							'".$arrayParametros['ausencia_plaga']."',
							'".$arrayParametros['plaga_diagnostico_visual_prediagnostico']."',
							'".$arrayParametros['cantidad_afectada']."',
							'".$arrayParametros['porcentaje_incidencia']."',
							'".$arrayParametros['porcentaje_severidad']."',
							'".$arrayParametros['tipo_plaga']."',
							'".$arrayParametros['fase_desarrollo_plaga']."',
							'".$arrayParametros['organo_afectado']."',
							'".$arrayParametros['distribucion_plaga']."',
							'".$arrayParametros['poblacion']."',
							'".$arrayParametros['diagnostico_visual']."',
							'".$arrayParametros['descripcion_sintomas_p']."',
							'".$arrayParametros['envio_muestra']."',
							'".$arrayParametros['observaciones']."',
							'".$arrayParametros['fecha_inspeccion']."',
							'".$arrayParametros['usuario_id']."',
							'".$arrayParametros['usuario']."',
							'".$arrayParametros['tablet_id']."',
							'".$arrayParametros['tablet_version_base']."',
							'".$link."',
							'".$arrayParametros['longitud_imagen']."',
							'".$arrayParametros['latitud_imagen']."',
							'".$arrayParametros['altura_imagen']."'
							)
							RETURNING id;";
		
		return $this->modeloVigilanciaf02->ejecutarSqlNativo($consulta);
	}


	/**
	 * Guardar orden de laboratorio
	 */
	public function guardarOrdenLaboratorio($arrayParametros){

		$consulta = "INSERT INTO f_inspeccion.vigilanciaf02_detalle_ordenes(
							id_padre,
							id_tablet,
							analisis,
							codigo_muestra,
							conservacion,
							tipo_muestra
							)
					VALUES (
							'".$arrayParametros['id_padre']."',
							'".$arrayParametros['id_tablet']."',
							'".$arrayParametros['analisis']."',
							'".$arrayParametros['codigo_muestra']."',
							'".$arrayParametros['conservacion']."',
							'".$arrayParametros['tipo_muestra']."'
							);";
		
		return $this->modeloVigilanciaf02->ejecutarSqlNativo($consulta);
	}

	/**
	 * Guardar vigilancia cabecera y detalle
	 */
	public function guardarVigilanciaTryCatch(Array $datos, Array $datosLboratorio) {
		try{
			
			$procesoIngreso = $this->modeloVigilanciaf02->getAdapter()
				->getDriver()
				->getConnection();
			$procesoIngreso->beginTransaction();

			$contador=0;
			
			foreach($datos as $registro){

				$statement = $this->modeloVigilanciaf02->getAdapter()
				->getDriver()
				->createStatement();

				$rutaArchivo = 'ruta foto';
				$link = null;

				if($registro['foto'] != ''){
					$rutaArchivo = 'modulos/AplicacionMovilInternos/archivos/fotosVigilanciaSV/'.md5(time()).$contador.'.jpg';
					file_put_contents($rutaArchivo, base64_decode($registro['foto']));
					$rutaArchivo = URL_PROTOCOL . URL_DOMAIN . URL_GUIA .'/mvc/'. $rutaArchivo;
					$link = '<a href="'.$rutaArchivo.'">Foto</a>';
				}else{
					$rutaArchivo = '';
				}
		
				$campos = array(					
					"id_tablet" => $registro["id_tablet"],
					"codigo_provincia" => $registro["codigo_provincia"],
					"nombre_provincia" => $registro["nombre_provincia"],
					"codigo_canton" => $registro["codigo_canton"],
					"nombre_canton" => $registro["nombre_canton"],
					"codigo_parroquia" => $registro["codigo_parroquia"],
					"nombre_parroquia" => $registro["nombre_parroquia"],
					"nombre_propietario_finca" => $registro["nombre_propietario_finca"],
					"localidad_via" => $registro["localidad_via"],
					"coordenada_x" => $registro["coordenada_x"],
					"coordenada_y" => $registro["coordenada_y"],
					// "coordenada_z" => $registro["coordenada_z"],
					"denuncia_fitosanitaria" => $registro["denuncia_fitosanitaria"],
					"nombre_denunciante" => $registro["nombre_denunciante"],
					"telefono_denunciante" => $registro["telefono_denunciante"],
					"direccion_denunciante" => $registro["direccion_denunciante"],
					"correo_electronico_denunciante" => $registro["correo_electronico_denunciante"],
					"especie_vegetal" => $registro["especie_vegetal"],
					"cantidad_total" => $registro["cantidad_total"],
					"cantidad_vigilada" => $registro["cantidad_vigilada"],
					"unidad" => $registro["unidad"],
					"sitio_operacion" => $registro["sitio_operacion"],
					"condicion_produccion" => $registro["condicion_produccion"],
					"etapa_cultivo" => $registro["etapa_cultivo"],
					"actividad" => $registro["actividad"],
					"manejo_sitio_operacion" => $registro["manejo_sitio_operacion"],
					"ausencia_plaga" => $registro["ausencia_plaga"],
					"plaga_diagnostico_visual_prediagnostico" => $registro["plaga_diagnostico_visual_prediagnostico"],
					"cantidad_afectada" => $registro["cantidad_afectada"],
					"porcentaje_incidencia" => $registro["porcentaje_incidencia"],
					"porcentaje_severidad" => $registro["porcentaje_severidad"],
					"tipo_plaga" => $registro["tipo_plaga"],
					"fase_desarrollo_plaga" => $registro["fase_desarrollo_plaga"],
					"organo_afectado" => $registro["organo_afectado"],
					"distribucion_plaga" => $registro["distribucion_plaga"],
					"poblacion" => $registro["poblacion"],
					"diagnostico_visual" => $registro["diagnostico_visual"],
					"descripcion_sintomas_p" => $registro["descripcion_sintomas_p"],
					"envio_muestra" => $registro["envio_muestra"],
					"observaciones" => $registro["observaciones"],
					"fecha_inspeccion" => $registro["fecha_inspeccion"],
					"usuario_id" => $registro["usuario_id"],
					"usuario" => $registro["usuario"],
					"tablet_id" => $registro["tablet_id"],
					"tablet_version_base" => $registro["tablet_version_base"],
					"ruta_foto" => $link,
					"longitud_imagen" => $registro["longitud_imagen"],
					"latitud_imagen" => $registro["latitud_imagen"],
					"altura_imagen" => $registro["altura_imagen"],
				);

				if($registro['cantidad_total'] == '.') $registro['cantidad_total'] = null;
				if($registro['cantidad_vigilada'] == '.') $registro['cantidad_vigilada'] = null;
				if($registro['cantidad_afectada'] == '.') $registro['cantidad_afectada'] = null;
				if($registro['porcentaje_incidencia'] == '.') $registro['porcentaje_incidencia'] = null;
				if($registro['porcentaje_severidad'] == '.') $registro['porcentaje_severidad'] = null;
				if($registro['poblacion'] == '.') $registro['poblacion'] = null;

				if($registro['nombre_denunciante'] == null || $registro['nombre_denunciante'] == '' ) unset($campos['nombre_denunciante']);
				if($registro['telefono_denunciante'] == null || $registro['telefono_denunciante'] == '' ) unset($campos['telefono_denunciante']);
				if($registro['direccion_denunciante'] == null || $registro['direccion_denunciante'] == '' ) unset($campos['direccion_denunciante']);
				if($registro['correo_electronico_denunciante'] == null || $registro['correo_electronico_denunciante'] == '' ) unset($campos['correo_electronico_denunciante']);

				if($registro['cantidad_total'] == null || $registro['cantidad_total'] == '') unset($campos['cantidad_total']);
				if($registro['cantidad_vigilada'] == null || $registro['cantidad_vigilada'] == '') unset($campos['cantidad_vigilada']);
				if($registro['plaga_diagnostico_visual_prediagnostico'] == null || $registro['plaga_diagnostico_visual_prediagnostico'] == '') unset($campos['plaga_diagnostico_visual_prediagnostico']);
				if($registro['cantidad_afectada'] == null || $registro['cantidad_afectada'] == '') unset($campos['cantidad_afectada']);
				if($registro['porcentaje_incidencia'] == null || $registro['porcentaje_incidencia'] == '') unset($campos['porcentaje_incidencia']);
				if($registro['porcentaje_severidad'] == null || $registro['porcentaje_severidad'] == '') unset($campos['porcentaje_severidad']);
				if($registro['tipo_plaga'] == null || $registro['tipo_plaga'] == '') unset($campos['tipo_plaga']);
				if($registro['fase_desarrollo_plaga'] == null || $registro['fase_desarrollo_plaga'] == '') unset($campos['fase_desarrollo_plaga']);
				if($registro['organo_afectado'] == null || $registro['organo_afectado'] == '') unset($campos['organo_afectado']);
				if($registro['distribucion_plaga'] == null || $registro['distribucion_plaga'] == '') unset($campos['distribucion_plaga']);
				if($registro['poblacion'] == null || $registro['poblacion'] == '') unset($campos['poblacion']);
				if($registro['diagnostico_visual'] == null || $registro['diagnostico_visual'] == '') unset($campos['diagnostico_visual']);
				if($registro['descripcion_sintomas_p'] == null || $registro['descripcion_sintomas_p'] == '') unset($campos['descripcion_sintomas_p']);
				if($registro['envio_muestra'] == null || $registro['envio_muestra'] == '') unset($campos['envio_muestra']);
				if($registro['observaciones'] == null || $registro['observaciones'] == '') unset($campos['observaciones']);
				if($registro['fecha_inspeccion'] == null || $registro['fecha_inspeccion'] == '') unset($campos['fecha_inspeccion']);
				if($registro['usuario_id'] == null || $registro['usuario_id'] == '') unset($campos['usuario_id']);
				if($registro['usuario'] == null || $registro['usuario'] == '') unset($campos['usuario']);
				if($registro['tablet_id'] == null || $registro['tablet_id'] == '') unset($campos['tablet_id']);
				if($registro['tablet_version_base'] == null || $registro['tablet_version_base'] == '') unset($campos['tablet_version_base']);
				if($registro['foto'] == null || $registro['foto'] == '') unset($campos['ruta_foto']);
				if($registro['longitud_imagen'] == null || $registro['longitud_imagen'] == '') unset($campos['longitud_imagen']);
				if($registro['latitud_imagen'] == null || $registro['latitud_imagen'] == '') unset($campos['latitud_imagen']);
				if($registro['altura_imagen'] == null || $registro['altura_imagen'] == '') unset($campos['altura_imagen']);

				$arrayColumnasCabecera = array_keys($campos);

				$sqlInsertar = $this->modeloVigilanciaf02->guardarSql('vigilanciaf02', $this->modeloVigilanciaf02->getEsquema());
				$sqlInsertar->columns($arrayColumnasCabecera);
				$sqlInsertar->values($campos, $sqlInsertar::VALUES_MERGE);
				$sqlInsertar->prepareStatement($this->modeloVigilanciaf02->getAdapter(), $statement);
				$statement->execute();
				$id = $this->modeloVigilanciaf02->adapter->driver->getLastGeneratedValue($this->modeloVigilanciaf02->getEsquema() . '.vigilanciaf02_id_seq');

				foreach($datosLboratorio as $orden){

					$statement = $this->modeloVigilanciaf02->getAdapter()
					->getDriver()
					->createStatement();

					if ($orden['id_vigilancia'] == $registro['id']){

						$campos = array(
							'id_padre' => $id,
							'id_tablet' => $registro['id_tablet'],
							'analisis' => $orden['analisis'],
							'codigo_muestra' => $orden['codigo_muestra'],
							'conservacion' => $orden['conservacion'],
							'tipo_muestra' => $orden['tipo_muestra'],
						);

						$arrayColumnasCabecera = array_keys($campos);
						
						$sqlInsertar = $this->modeloVigilanciaf02->guardarSql('vigilanciaf02_detalle_ordenes', 'f_inspeccion');
						$sqlInsertar->columns($arrayColumnasCabecera);
						$sqlInsertar->values($campos, $sqlInsertar::VALUES_MERGE);
						$sqlInsertar->prepareStatement($this->modeloVigilanciaf02->getAdapter(), $statement);
						$statement->execute();
						
					}
				}

				$contador++;

			}
					
			http_response_code(200);
			echo json_encode(array('estado' => 'exito', 'mensaje' => 'Registros almacenados en el Sistema GUIA exitosamente'));
			$procesoIngreso->commit();
		} catch (Exception $ex){
			http_response_code(400);
			echo json_encode(array('estado' => 'error', 'mensaje' => $ex->getMessage()));
			$procesoIngreso->rollback();
			throw new GuardarExcepcion($ex, array('origen' => 'Agro servicios', 'ws'=>'RestWsVigilanciaControlador', 'archivo' => 'Vigilanciaf02LogicaNegocio', 'metodo' => 'guardarVigilanciaTryCatch', 'datos' => $datos));
		}
	}
}
