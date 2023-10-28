<?php
 /**
 * Lógica del negocio de TransitoInternacionalModelo
 *
 * Este archivo se complementa con el archivo TransitoInternacionalControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-11-08
 * @uses    TransitoInternacionalLogicaNegocio
 * @package TransitoInternacional
 * @subpackage Modelos
 */
  namespace Agrodb\TransitoInternacional\Modelos;
  
  use Agrodb\TransitoInternacional\Modelos\IModelo;
 
class TransitoInternacionalLogicaNegocio implements IModelo 
{

	 private $modeloTransitoInternacional = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloTransitoInternacional = new TransitoInternacionalModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new TransitoInternacionalModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdTransitoInternacional() != null && $tablaModelo->getIdTransitoInternacional() > 0) {
		return $this->modeloTransitoInternacional->actualizar($datosBd, $tablaModelo->getIdTransitoInternacional());
		} else {
		unset($datosBd["id_transito_internacional"]);
		return $this->modeloTransitoInternacional->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloTransitoInternacional->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return TransitoInternacionalModelo
	*/
	public function buscar($id)
	{
		return $this->modeloTransitoInternacional->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloTransitoInternacional->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloTransitoInternacional->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarTransitoInternacional()
	{
	$consulta = "SELECT * FROM ".$this->modeloTransitoInternacional->getEsquema().". transito_internacional";
		 return $this->modeloTransitoInternacional->ejecutarSqlNativo($consulta);
	}

}
