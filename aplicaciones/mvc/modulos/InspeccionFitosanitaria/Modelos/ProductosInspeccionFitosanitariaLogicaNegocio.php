<?php
/**
 * Lógica del negocio de ProductosInspeccionFitosanitariaModelo
 *
 * Este archivo se complementa con el archivo ProductosInspeccionFitosanitariaControlador.
 *
 * @author AGROCALIDAD
 * @date    2022-12-15
 * @uses ProductosInspeccionFitosanitariaLogicaNegocio
 * @package InspeccionFitosanitaria
 * @subpackage Modelos
 */
namespace Agrodb\InspeccionFitosanitaria\Modelos;

use Agrodb\InspeccionFitosanitaria\Modelos\IModelo;
use Agrodb\Core\Excepciones\GuardarExcepcion;

class ProductosInspeccionFitosanitariaLogicaNegocio implements IModelo{

	private $modeloProductosInspeccionFitosanitaria = null;

	/**
	 * Constructor
	 *
	 * @retorna void
	 */
	public function __construct(){
		$this->modeloProductosInspeccionFitosanitaria = new ProductosInspeccionFitosanitariaModelo();
	}

	/**
	 * Guarda el registro actual
	 *
	 * @param array $datos
	 * @return int
	 */
	public function guardar(Array $datos){
		try{

			$tablaModelo = new ProductosInspeccionFitosanitariaModelo($datos);
			$procesoIngreso = $this->modeloProductosInspeccionFitosanitaria->getAdapter()
			->getDriver()
			->getConnection();
			$procesoIngreso->beginTransaction();
			
			$datosBd = $tablaModelo->getPrepararDatos();
			if ($tablaModelo->getIdProductoInspeccionFitosanitaria() != null && $tablaModelo->getIdProductoInspeccionFitosanitaria() > 0){
				$idProductoInspeccionFitosanitaria = $this->modeloProductosInspeccionFitosanitaria->actualizar($datosBd, $tablaModelo->getIdProductoInspeccionFitosanitaria());
			}else{
				unset($datosBd["id_producto_inspeccion_fitosanitaria"]);
				$idProductoInspeccionFitosanitaria = $this->modeloProductosInspeccionFitosanitaria->guardar($datosBd);
			}

			$procesoIngreso->commit();
			return $idProductoInspeccionFitosanitaria;
			
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
		$this->modeloProductosInspeccionFitosanitaria->borrar($id);
	}

	/**
	 *
	 * Buscar un registro de con la clave primaria
	 *
	 * @param int $id
	 * @return ProductosInspeccionFitosanitariaModelo
	 */
	public function buscar($id){
		return $this->modeloProductosInspeccionFitosanitaria->buscar($id);
	}

	/**
	 * Busca todos los registros
	 *
	 * @return array|ResultSet
	 */
	public function buscarTodo(){
		return $this->modeloProductosInspeccionFitosanitaria->buscarTodo();
	}

	/**
	 * Busca una lista de acuerdo a los parámetros <params> enviados.
	 *
	 * @return array|ResultSet
	 */
	public function buscarLista($where = null, $order = null, $count = null, $offset = null){
		return $this->modeloProductosInspeccionFitosanitaria->buscarLista($where, $order, $count, $offset);
	}

	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 *
	 * @return array|ResultSet
	 */
	public function buscarProductosInspeccionFitosanitaria(){
		$consulta = "SELECT * FROM " . $this->modeloProductosInspeccionFitosanitaria->getEsquema() . ". productos_inspeccion_fitosanitaria";
		return $this->modeloProductosInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
	}
}
