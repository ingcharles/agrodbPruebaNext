<?php
 /**
 * Lógica del negocio de FactorRiesgoModelo
 *
 * Este archivo se complementa con el archivo FactorRiesgoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-06-02
 * @uses    FactorRiesgoLogicaNegocio
 * @package HistoriasClinicas
 * @subpackage Modelos
 */
  namespace Agrodb\HistoriasClinicas\Modelos;
  
  use Agrodb\HistoriasClinicas\Modelos\IModelo;
 
class FactorRiesgoLogicaNegocio implements IModelo 
{

	 private $modeloFactorRiesgo = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloFactorRiesgo = new FactorRiesgoModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new FactorRiesgoModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdFactorRiesgo() != null && $tablaModelo->getIdFactorRiesgo() > 0) {
		return $this->modeloFactorRiesgo->actualizar($datosBd, $tablaModelo->getIdFactorRiesgo());
		} else {
		unset($datosBd["id_factor_riesgo"]);
		return $this->modeloFactorRiesgo->guardar($datosBd);
		}
	}

	/**
	 * guardar factor riesgo y detalle de factor riesgo
	*/
	public function guardarFactorDetalle(Array $datos){
		try{
			$this->modeloFactorRiesgo = new FactorRiesgoModelo();
			$proceso = $this->modeloFactorRiesgo->getAdapter()
				->getDriver()
				->getConnection();
			if (! $proceso->beginTransaction()){
				throw new \Exception('No se pudo iniciar la transacción: Agregar historia ocupacional');
			}
			$tablaModelo = new FactorRiesgoModelo($datos);
			$datosBd = $tablaModelo->getPrepararDatos();
			unset($datosBd["id_factor_riesgo"]);
			$idFactorRiesgo = $this->modeloFactorRiesgo->guardar($datosBd);

			if (! $idFactorRiesgo){
				throw new \Exception('No se registo los datos en la tabla factor_riesgo');
			}
			if (isset($_POST['subtipoList'])){
				$lnegocioDetalleFactorRiesgo = new DetalleFactorRiesgoLogicaNegocio();
				foreach ($_POST['subtipoList'] as $item){
					$datos = array(
						'id_factor_riesgo' => $idFactorRiesgo,
						'id_subtipo_proced_medico' => $item);
					$statement = $this->modeloFactorRiesgo->getAdapter()
						->getDriver()
						->createStatement();
					$sqlInsertar = $this->modeloFactorRiesgo->guardarSql('detalle_factor_riesgo', $this->modeloFactorRiesgo->getEsquema());
					$sqlInsertar->columns($lnegocioDetalleFactorRiesgo->columnas());
					$sqlInsertar->values($datos, $sqlInsertar::VALUES_MERGE);
					$sqlInsertar->prepareStatement($this->modeloFactorRiesgo->getAdapter(), $statement);
					$statement->execute();
				}
			}
			$proceso->commit();
			return true;
		}catch (\Exception $ex){
			$proceso->rollback();
			throw new \Exception($ex->getMessage());
			return false;
		}
		;
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloFactorRiesgo->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return FactorRiesgoModelo
	*/
	public function buscar($id)
	{
		return $this->modeloFactorRiesgo->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloFactorRiesgo->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloFactorRiesgo->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarFactorRiesgo()
	{
	$consulta = "SELECT * FROM ".$this->modeloFactorRiesgo->getEsquema().". factor_riesgo";
		 return $this->modeloFactorRiesgo->ejecutarSqlNativo($consulta);
	}

	/**
	 * Columnas de la tabla g_historias_clinicas.factor_riesgo
	 *
	 * @return string
	 */
	public function columnas(){
		$columnas = array(
			'id_historia_clinica',
			'cargo_factor',
			'actividades_factor',
			'medidas_factor',
			'id_procedimiento_medico',
			'id_tipo_procedimiento_medico');
		return $columnas;
	}

}
