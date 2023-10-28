<?php
/**
 * Lógica del negocio de FirmantesModelo
 *
 * Este archivo se complementa con el archivo FirmantesControlador.
 *
 * @author AGROCALIDAD
 * @date    2022-01-14
 * @uses FirmantesLogicaNegocio
 * @package FirmaDocumentos
 * @subpackage Modelos
 */
namespace Agrodb\FirmaDocumentos\Modelos;

use Agrodb\Core\Excepciones\GuardarExcepcion;
use Agrodb\FirmaDocumentos\Modelos\IModelo;
use Agrodb\FirmaDocumentos\Controladores\Firmap12;

class FirmantesLogicaNegocio implements IModelo{

	private $modeloFirmantes = null;

	/**
	 * Constructor
	 *
	 * @retorna void
	 */
	public function __construct(){
		$this->modeloFirmantes = new FirmantesModelo();
	}

	/**
	 * Guarda el registro actual
	 *
	 * @param array $datos
	 * @return int
	 */
	public function guardar(Array $datos){

		try{
			
			$procesoIngreso = $this->modeloFirmantes->getAdapter()
				->getDriver()
				->getConnection();
			$procesoIngreso->beginTransaction();

			$statement = $this->modeloFirmantes->getAdapter()
			->getDriver()
			->createStatement();

			//consultar 
			$identificador = $datos['identificador'];
			$modeloFirmantes = $this->buscar($identificador);

			//guardar
			if($modeloFirmantes->identificador == null){
				$sqlInsertar = $this->modeloFirmantes->guardarSql('firmantes', $this->modeloFirmantes->getEsquema());
				$sqlInsertar->columns(array_keys($datos));
				$sqlInsertar->values($datos, $sqlInsertar::VALUES_MERGE);
				$sqlInsertar->prepareStatement($this->modeloFirmantes->getAdapter(), $statement);
				$accion = 0;
			}
			//actualizar
			else{
				$sqlActualizar = $this->modeloFirmantes->actualizarSql('firmantes', $this->modeloFirmantes->getEsquema());
				$sqlActualizar->set($datos);
				$sqlActualizar->where(array('identificador' => $identificador));
				$sqlActualizar->prepareStatement($this->modeloFirmantes->getAdapter(), $statement);
				$accion = 1;
			}
			$statement->execute();
			$procesoIngreso->commit();
			return $accion;
		}catch (GuardarExcepcion $ex){
			$procesoIngreso->rollback();
			throw new \Exception($ex->getMessage());
		}
	}

	public function getSignData($Lla_Cla, $contadorExtras = null){
		$firma = new Firmap12();
		$target_file = APP . FIRMA_P12 . $_SESSION['usuario'] . ".p12";
		$firma->setKey($target_file,$Lla_Cla, false, $contadorExtras); 
		$x509=$firma->getKeyData();
		return $x509;
	}

	public function convertP12toCrt($claveEncriptada, $Lla_Cla){
		$target_file = APP . FIRMA_P12 . $_SESSION['usuario'] . ".p12";
		$out_file = APP . FIRMA_CRT . $_SESSION['usuario'] . ".crt";
		$comando = "openssl pkcs12 -in " . $target_file . " -out " . $out_file .  " -nodes -passout pass:" . $claveEncriptada . " -passin pass:" . $Lla_Cla;
		shell_exec($comando);
	}

	/**
	 * Borra el registro actual
	 *
	 * @param
	 *        	string Where|array $where
	 * @return int
	 */
	public function borrar($id){
		$this->modeloFirmantes->borrar($id);
	}

	/**
	 *
	 * Buscar un registro de con la clave primaria
	 *
	 * @param int $id
	 * @return FirmantesModelo
	 */
	public function buscar($id){
		return $this->modeloFirmantes->buscar($id);
	}

	/**
	 * Busca todos los registros
	 *
	 * @return array|ResultSet
	 */
	public function buscarTodo(){
		return $this->modeloFirmantes->buscarTodo();
	}

	/**
	 * Busca una lista de acuerdo a los parámetros <params> enviados.
	 *
	 * @return array|ResultSet
	 */
	public function buscarLista($where = null, $order = null, $count = null, $offset = null){
		return $this->modeloFirmantes->buscarLista($where, $order, $count, $offset);
	}

	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 *
	 * @return array|ResultSet
	 */
	public function buscarFirmantes(){
		$consulta = "SELECT * FROM " . $this->modeloFirmantes->getEsquema() . ". firmantes";
		return $this->modeloFirmantes->ejecutarSqlNativo($consulta);
	}
}
