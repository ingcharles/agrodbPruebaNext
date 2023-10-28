<?php
 /**
 * Lógica del negocio de Vigilanciaf01Modelo
 *
 * Este archivo se complementa con el archivo Vigilanciaf01Controlador.
 *
 * @author  AGROCALIDAD
 * @date    2021/08/23
 * @uses    Vigilanciaf01LogicaNegocio
 * @package FormulariosInspeccion
 * @subpackage Modelos
 */
  namespace Agrodb\FormulariosInspeccion\Modelos;
  
  use Agrodb\Token\Modelos\TokenLogicaNegocio;
  use Agrodb\FormulariosInspeccion\Modelos\IModelo;
  use Agrodb\Core\Excepciones\GuardarExcepcion;
  use Exception;

class Vigilanciaf01LogicaNegocio implements IModelo 
{

	 private $modeloVigilanciaf01 = null;
	 private $lNegocioToken = null;

	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloVigilanciaf01 = new Vigilanciaf01Modelo();
	 $this->lNegocioToken = new TokenLogicaNegocio();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new Vigilanciaf01Modelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getId() != null && $tablaModelo->getId() > 0) {
		return $this->modeloVigilanciaf01->actualizar($datosBd, $tablaModelo->getId());
		} else {
		unset($datosBd["id"]);
		return $this->modeloVigilanciaf01->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloVigilanciaf01->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return Vigilanciaf01Modelo
	*/
	public function buscar($id)
	{
		return $this->modeloVigilanciaf01->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloVigilanciaf01->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloVigilanciaf01->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarVigilanciaf01()
	{
	$consulta = "SELECT * FROM ".$this->modeloVigilanciaf01->getEsquema().". vigilanciaf01";
		 return $this->modeloVigilanciaf01->ejecutarSqlNativo($consulta);
	}

	/**
	 * Método que guarda las inspecciones de trampas de vigilancia
	 */
	public function guardarTrampas($cabecera, $trampas, $ordenes){

		$arrayToken = $this->lNegocioToken->validarToken(RUTA_PUBLIC_KEY_AGROSERVICIOS);

        if ($arrayToken['estado'] == 'exito') {

			$LAdministacionTrampas = new \Agrodb\AdministracionTrampas\Modelos\AdministracionTrampasLogicaNegocio();
		
			try{

				$procesoIngreso = $this->modeloVigilanciaf01->getAdapter()
						->getDriver()
						->getConnection();
				$procesoIngreso->beginTransaction();
		
				$statement = $this->modeloVigilanciaf01->getAdapter()
					->getDriver()
					->createStatement();

				foreach($cabecera as $registro){ 

					$campos = array (
						'id_tablet' => $registro['id_tablet'],
						'fecha_inspeccion' => $registro['fecha_inspeccion'],
						'usuario_id' => $registro['usuario_id'],
						'usuario' => $registro['usuario'],
						'tablet_id' => $registro['tablet_id'],
						'tablet_version_base' => $registro['tablet_version_base'],
					);

					$arrayColumnasCabecera = array_keys($campos);

					$sqlInsertar = $this->modeloVigilanciaf01->guardarSql('vigilanciaf01', $this->modeloVigilanciaf01->getEsquema());
					$sqlInsertar->columns($arrayColumnasCabecera);
					$sqlInsertar->values($campos, $sqlInsertar::VALUES_MERGE);
					$sqlInsertar->prepareStatement($this->modeloVigilanciaf01->getAdapter(), $statement);
					$statement->execute();
					$id = $this->modeloVigilanciaf01->adapter->driver->getLastGeneratedValue($this->modeloVigilanciaf01->getEsquema() . '.vigilanciaf01_id_seq');

					$statement2 = $this->modeloVigilanciaf01->getAdapter()
							->getDriver()
							->createStatement();			
					
					$contador=0;

					foreach($trampas as $registroTrampa){

						$rutaArchivo = 'ruta foto';
						$link = '';

						if($registroTrampa['foto'] != ''){
							$rutaArchivo = 'modulos/AplicacionMovilInternos/archivos/fotosTrampasSV/'.md5(time()).$contador.'.jpg';
							file_put_contents($rutaArchivo, base64_decode($registroTrampa['foto']));
							$rutaArchivo = URL_PROTOCOL . URL_DOMAIN . URL_GUIA .'/mvc/'. $rutaArchivo;
							$link = '<a href="'.$rutaArchivo.'">Foto</a>';
						}else{
							$rutaArchivo = '';
						}

						if ($registroTrampa['id_padre'] == $registro['id']){

							$campos = array(								
								'id_padre' => $id,
								'id_tablet' => $registroTrampa['id_tablet'],
								'fecha_instalacion' => $registroTrampa['fecha_instalacion'],
								'codigo_trampa' => $registroTrampa['codigo_trampa'],
								'tipo_trampa' => $registroTrampa['tipo_trampa'],
								'id_provincia' => $registroTrampa['id_provincia'],
								'nombre_provincia' => $registroTrampa['nombre_provincia'],
								'id_canton' => $registroTrampa['id_canton'],
								'nombre_canton' => $registroTrampa['nombre_canton'],
								'id_parroquia' => $registroTrampa['id_parroquia'],
								'nombre_parroquia' => $registroTrampa['nombre_parroquia'],
								'estado_trampa' => $registroTrampa['estado_trampa'],
								'coordenada_x' => $registroTrampa['coordenada_x'],
								'coordenada_y' => $registroTrampa['coordenada_y'],
								'coordenada_z' => $registroTrampa['coordenada_z'],
								'id_lugar_instalacion' => $registroTrampa['id_lugar_instalacion'],
								'nombre_lugar_instalacion' => $registroTrampa['nombre_lugar_instalacion'],
								'numero_lugar_instalacion' => $registroTrampa['numero_lugar_instalacion'],
								'fecha_inspeccion' => $registroTrampa['fecha_inspeccion'],
								'semana' => $registroTrampa['semana'],
								'usuario_id' => $registroTrampa['usuario_id'],
								'usuario' => $registroTrampa['usuario'],
								'propiedad_finca' => $registroTrampa['propiedad_finca'],
								'condicion_trampa' => $registroTrampa['condicion_trampa'],
								'especie' => $registroTrampa['especie'],
								'procedencia' => $registroTrampa['procedencia'] == '--' ? '' : $registroTrampa['procedencia'],
								'condicion_cultivo' => $registroTrampa['condicion_cultivo'],
								'etapa_cultivo' => $registroTrampa['etapa_cultivo'],
								'exposicion' => $registroTrampa['exposicion'],
								'cambio_feromona' => $registroTrampa['cambio_feromona'],
								'cambio_papel' => $registroTrampa['cambio_papel'],
								'cambio_aceite' => $registroTrampa['cambio_aceite'],
								'cambio_trampa' => $registroTrampa['cambio_trampa'],
								'numero_especimenes' => $registroTrampa['numero_especimenes'],
								'diagnostico_visual' => $registroTrampa['diagnostico_visual'] == '--' ? '' : $registroTrampa['diagnostico_visual'],
								'fase_plaga' => $registroTrampa['fase_plaga'] == '--' ? '' : $registroTrampa['fase_plaga'],
								'observaciones' => $registroTrampa['observaciones'],
								'envio_muestra' => $registroTrampa['envio_muestra'],
								'tablet_id' => $registroTrampa['tablet_id'],
								'tablet_version_base' => $registroTrampa['tablet_version_base'],
								'ruta_foto' => $link,
							);

							$arrayColumnasCabecera = array_keys($campos);
							
							$sqlInsertar = $this->modeloVigilanciaf01->guardarSql('vigilanciaf01_detalle_trampas', 'f_inspeccion');
							$sqlInsertar->columns($arrayColumnasCabecera);
							$sqlInsertar->values($campos, $sqlInsertar::VALUES_MERGE);
							$sqlInsertar->prepareStatement($this->modeloVigilanciaf01->getAdapter(), $statement2);
							$statement2->execute();
							$contador++;

							if($registroTrampa['estado_trampa'] == 'inactivo'){
								$LAdministacionTrampas->actualizarEstadoAdminstracionTrampaTransaccion($registroTrampa['codigo_trampa']);							
							}

						}

					}

					$statement3 = $this->modeloVigilanciaf01->getAdapter()
							->getDriver()
							->createStatement();

					foreach($ordenes as $orden){

						
						if ($orden['id_padre'] == $registro['id']){

							$campos = array(
								'id_padre' => $id,
								'id_tablet' => $orden['id_tablet'],
								'analisis' => $orden['analisis'],
								'codigo_muestra' => $orden['codigo_muestra'],
								'tipo_muestra' => $orden['tipo_muestra'],
								'nombre_producto' => $orden['nombre_producto'],
								'prediagnostico' => $orden['prediagnostico'],
								'aplicacion_producto_quimico' => $orden['aplicacion_producto_quimico'],
								'codigo_trampa_padre' => $orden['codigo_trampa_padre']
							);

							$arrayColumnasCabecera = array_keys($campos);
							
							$sqlInsertar = $this->modeloVigilanciaf01->guardarSql('vigilanciaf01_detalle_ordenes', 'f_inspeccion');
							$sqlInsertar->columns($arrayColumnasCabecera);
							$sqlInsertar->values($campos, $sqlInsertar::VALUES_MERGE);
							$sqlInsertar->prepareStatement($this->modeloVigilanciaf01->getAdapter(), $statement3);
							$statement3->execute();
							
						}
					}

				}

				echo json_encode(array('estado' => 'exito', 'mensaje' => 'Registros almacenados en el Sistema GUIA exitosamente'));
				http_response_code(200);
				$procesoIngreso->commit();
			} catch (Exception $ex){
				http_response_code(400);
				echo json_encode(array('estado' => 'error', 'mensaje' => $ex->getMessage()));
				$procesoIngreso->rollback();
				throw new GuardarExcepcion($ex, array('origen' => 'Agro servicios', 'ws'=>'RestWsTrampeoVigilanciaControlador', 'archivo' => 'Vigilanciaf01LogicaNegocio', 'metodo' => 'guardarTrampas', 'datos' => $cabecera));
			}

		} else{
			echo json_encode($arrayToken);
		}
		
	}

}
