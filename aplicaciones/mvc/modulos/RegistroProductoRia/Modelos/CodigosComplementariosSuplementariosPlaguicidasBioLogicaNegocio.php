<?php
 /**
 * Lógica del negocio de CodigosComplementariosSuplementariosPlaguicidasBioModelo
 *
 * Este archivo se complementa con el archivo CodigosComplementariosSuplementariosPlaguicidasBioControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-22
 * @uses    CodigosComplementariosSuplementariosPlaguicidasBioLogicaNegocio
 * @package RegistroProductoRia
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroProductoRia\Modelos;
  
  use Agrodb\RegistroProductoRia\Modelos\IModelo;
 
class CodigosComplementariosSuplementariosPlaguicidasBioLogicaNegocio implements IModelo 
{

	 private $modeloCodigosComplementariosSuplementariosPlaguicidasBio = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloCodigosComplementariosSuplementariosPlaguicidasBio = new CodigosComplementariosSuplementariosPlaguicidasBioModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new CodigosComplementariosSuplementariosPlaguicidasBioModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdCodigoComplementarioSuplementario() != null && $tablaModelo->getIdCodigoComplementarioSuplementario() > 0) {
		return $this->modeloCodigosComplementariosSuplementariosPlaguicidasBio->actualizar($datosBd, $tablaModelo->getIdCodigoComplementarioSuplementario());
		} else {
		unset($datosBd["id_codigo_complementario_suplementario"]);
		return $this->modeloCodigosComplementariosSuplementariosPlaguicidasBio->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloCodigosComplementariosSuplementariosPlaguicidasBio->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return CodigosComplementariosSuplementariosPlaguicidasBioModelo
	*/
	public function buscar($id)
	{
		return $this->modeloCodigosComplementariosSuplementariosPlaguicidasBio->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloCodigosComplementariosSuplementariosPlaguicidasBio->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloCodigosComplementariosSuplementariosPlaguicidasBio->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarCodigosComplementariosSuplementariosPlaguicidasBio()
	{
	$consulta = "SELECT * FROM ".$this->modeloCodigosComplementariosSuplementariosPlaguicidasBio->getEsquema().". codigos_complementarios_suplementarios_plaguicidas_bio";
		 return $this->modeloCodigosComplementariosSuplementariosPlaguicidasBio->ejecutarSqlNativo($consulta);
	}

}
