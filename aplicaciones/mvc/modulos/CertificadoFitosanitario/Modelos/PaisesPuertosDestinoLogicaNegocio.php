<?php
 /**
 * Lógica del negocio de PaisesPuertosDestinoModelo
 *
 * Este archivo se complementa con el archivo PaisesPuertosDestinoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    PaisesPuertosDestinoLogicaNegocio
 * @package CertificadoFitosanitario
 * @subpackage Modelos
 */
  namespace Agrodb\CertificadoFitosanitario\Modelos;
  
  use Agrodb\CertificadoFitosanitario\Modelos\IModelo;
 
class PaisesPuertosDestinoLogicaNegocio implements IModelo 
{

	 private $modeloPaisesPuertosDestino = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloPaisesPuertosDestino = new PaisesPuertosDestinoModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new PaisesPuertosDestinoModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdPaisPuertoDestino() != null && $tablaModelo->getIdPaisPuertoDestino() > 0) {
		return $this->modeloPaisesPuertosDestino->actualizar($datosBd, $tablaModelo->getIdPaisPuertoDestino());
		} else {
		unset($datosBd["id_pais_puerto_destino"]);
		return $this->modeloPaisesPuertosDestino->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloPaisesPuertosDestino->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return PaisesPuertosDestinoModelo
	*/
	public function buscar($id)
	{
		return $this->modeloPaisesPuertosDestino->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloPaisesPuertosDestino->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloPaisesPuertosDestino->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarPaisesPuertosDestino()
	{
	$consulta = "SELECT * FROM ".$this->modeloPaisesPuertosDestino->getEsquema().". paises_puertos_destino";
		 return $this->modeloPaisesPuertosDestino->ejecutarSqlNativo($consulta);
	}
	
	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 *
	 * @return array|ResultSet
	 */
	public function obtenerPaisesPuertosDestinoPorIdCertificadoFitosanitario($idCertificadoFitosanitario)
	{
		$consulta = "SELECT 
						DISTINCT cf.id_certificado_fitosanitario
						, ppd.id_pais_destino
					FROM 
						g_certificado_fitosanitario.certificado_fitosanitario cf
					INNER JOIN g_certificado_fitosanitario.paises_puertos_destino ppd ON ppd.id_certificado_fitosanitario = cf.id_certificado_fitosanitario
					WHERE
						cf.id_certificado_fitosanitario = " . $idCertificadoFitosanitario . ";";
		return $this->modeloPaisesPuertosDestino->ejecutarSqlNativo($consulta);
	}
	
	

}
