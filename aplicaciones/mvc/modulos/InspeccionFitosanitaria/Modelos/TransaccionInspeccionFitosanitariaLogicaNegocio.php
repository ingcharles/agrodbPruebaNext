<?php
 /**
 * Lógica del negocio de TransaccionInspeccionFitosanitariaModelo
 *
 * Este archivo se complementa con el archivo TransaccionInspeccionFitosanitariaControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    TransaccionInspeccionFitosanitariaLogicaNegocio
 * @package InspeccionFitosanitaria
 * @subpackage Modelos
 */
  namespace Agrodb\InspeccionFitosanitaria\Modelos;
  
  use Agrodb\InspeccionFitosanitaria\Modelos\IModelo;
 
class TransaccionInspeccionFitosanitariaLogicaNegocio implements IModelo 
{

	 private $modeloTransaccionInspeccionFitosanitaria = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloTransaccionInspeccionFitosanitaria = new TransaccionInspeccionFitosanitariaModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new TransaccionInspeccionFitosanitariaModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdTransaccionInspeccionFitosanitaria() != null && $tablaModelo->getIdTransaccionInspeccionFitosanitaria() > 0) {
		return $this->modeloTransaccionInspeccionFitosanitaria->actualizar($datosBd, $tablaModelo->getIdTransaccionInspeccionFitosanitaria());
		} else {
		unset($datosBd["id_transaccion_inspeccion_fitosanitaria"]);
		return $this->modeloTransaccionInspeccionFitosanitaria->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloTransaccionInspeccionFitosanitaria->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return TransaccionInspeccionFitosanitariaModelo
	*/
	public function buscar($id)
	{
		return $this->modeloTransaccionInspeccionFitosanitaria->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloTransaccionInspeccionFitosanitaria->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloTransaccionInspeccionFitosanitaria->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarTransaccionInspeccionFitosanitaria()
	{
	$consulta = "SELECT * FROM ".$this->modeloTransaccionInspeccionFitosanitaria->getEsquema().". transaccion_inspeccion_fitosanitaria";
		 return $this->modeloTransaccionInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
	}
	
	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 * para guardar la transaccion generada de la inspeccion realizada
	 * @return array|ResultSet
	 */
	public function guardarTransaccionInspeccion($arrayParametros)
	{
		
	    $idInspeccionFitosnitaria = $arrayParametros['id_inspeccion_fitosanitaria'];
		
		$consulta = "SELECT g_inspeccion_fitosanitaria.f_guardar_transaccion(" . $idInspeccionFitosnitaria . ")";
		return $this->modeloTransaccionInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
	}
	
	public function guardarTransaccionInspeccionEnviada($arrayParametros)
	{
	    
	    $idInspeccionFitosanitaria = $arrayParametros['id_inspeccion_fitosanitaria'];
	    
	    $consulta = "SELECT g_inspeccion_fitosanitaria.f_guardar_transaccion_solicitud_enviada(" . $idInspeccionFitosanitaria . ")";
	    return $this->modeloTransaccionInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
	}

}
