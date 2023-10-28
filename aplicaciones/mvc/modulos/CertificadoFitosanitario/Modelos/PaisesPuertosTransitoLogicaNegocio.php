<?php
/**
 * Lógica del negocio de PaisesPuertosTransitoModelo
 *
 * Este archivo se complementa con el archivo PaisesPuertosTransitoControlador.
 *
 * @author AGROCALIDAD
 * @date    2022-07-21
 * @uses PaisesPuertosTransitoLogicaNegocio
 * @package CertificadoFitosanitario
 * @subpackage Modelos
 */
namespace Agrodb\CertificadoFitosanitario\Modelos;

use Agrodb\CertificadoFitosanitario\Modelos\IModelo;
use Agrodb\Core\Excepciones\GuardarExcepcion;

class PaisesPuertosTransitoLogicaNegocio implements IModelo{

	private $modeloPaisesPuertosTransito = null;

	/**
	 * Constructor
	 *
	 * @retorna void
	 */
	public function __construct(){
		$this->modeloPaisesPuertosTransito = new PaisesPuertosTransitoModelo();
	}

	/**
	 * Guarda el registro actual
	 *
	 * @param array $datos
	 * @return int
	 */
	public function guardar(Array $datos){
		
		try{
		
			$tablaModelo = new PaisesPuertosTransitoModelo($datos);
			$procesoIngreso = $this->modeloPaisesPuertosTransito->getAdapter()
			->getDriver()
			->getConnection();
			$procesoIngreso->beginTransaction();
			
			$datosBd = $tablaModelo->getPrepararDatos();
			if ($tablaModelo->getIdPaisPuertoTransito() != null && $tablaModelo->getIdPaisPuertoTransito() > 0){
				$idPaisPuertoTransito =  $this->modeloPaisesPuertosTransito->actualizar($datosBd, $tablaModelo->getIdPaisPuertoTransito());
			}else{
				unset($datosBd["id_pais_puerto_transito"]);
				$idPaisPuertoTransito =  $this->modeloPaisesPuertosTransito->guardar($datosBd);
			}
			
			$procesoIngreso->commit();
			return $idPaisPuertoTransito;
					
		}catch (GuardarExcepcion $ex){
			$procesoIngreso->rollback();
			throw new \Exception($ex->getMessage());
		}
	}

	/**
	 * Borra el registro actual
	 *
	 * @param
	 *        	string Where|array $where
	 * @return int
	 */
	public function borrar($id){
		$this->modeloPaisesPuertosTransito->borrar($id);
	}

	/**
	 *
	 * Buscar un registro de con la clave primaria
	 *
	 * @param int $id
	 * @return PaisesPuertosTransitoModelo
	 */
	public function buscar($id){
		return $this->modeloPaisesPuertosTransito->buscar($id);
	}

	/**
	 * Busca todos los registros
	 *
	 * @return array|ResultSet
	 */
	public function buscarTodo(){
		return $this->modeloPaisesPuertosTransito->buscarTodo();
	}

	/**
	 * Busca una lista de acuerdo a los parámetros <params> enviados.
	 *
	 * @return array|ResultSet
	 */
	public function buscarLista($where = null, $order = null, $count = null, $offset = null){
		return $this->modeloPaisesPuertosTransito->buscarLista($where, $order, $count, $offset);
	}

	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 *
	 * @return array|ResultSet
	 */
	public function buscarPaisesPuertosTransito(){
		$consulta = "SELECT * FROM " . $this->modeloPaisesPuertosTransito->getEsquema() . ". paises_puertos_transito";
		return $this->modeloPaisesPuertosTransito->ejecutarSqlNativo($consulta);
	}
}
