<?php
 /**
 * Lógica del negocio de CodigosCompSuplModelo
 *
 * Este archivo se complementa con el archivo CodigosCompSuplControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    CodigosCompSuplLogicaNegocio
 * @package Catalogos
 * @subpackage Modelos
 */
  namespace Agrodb\Catalogos\Modelos;
  
  use Agrodb\Catalogos\Modelos\IModelo;
 
class CodigosCompSuplLogicaNegocio implements IModelo 
{

	 private $modeloCodigosCompSupl = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloCodigosCompSupl = new CodigosCompSuplModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new CodigosCompSuplModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdCodigoCompSupl() != null && $tablaModelo->getIdCodigoCompSupl() > 0) {
		return $this->modeloCodigosCompSupl->actualizar($datosBd, $tablaModelo->getIdCodigoCompSupl());
		} else {
		unset($datosBd["id_codigo_comp_supl"]);
		return $this->modeloCodigosCompSupl->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloCodigosCompSupl->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return CodigosCompSuplModelo
	*/
	public function buscar($id)
	{
		return $this->modeloCodigosCompSupl->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloCodigosCompSupl->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloCodigosCompSupl->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarCodigosCompSupl()
	{
	$consulta = "SELECT * FROM ".$this->modeloCodigosCompSupl->getEsquema().". codigos_comp_supl";
		 return $this->modeloCodigosCompSupl->ejecutarSqlNativo($consulta);
	}

	/**
	 * Generar un combo de partidas arancelarias por productos para proceso de rectificacion de importaciones VUE de plaguicidas
	 *
	 * @return ResultSet
	 */
	public function comboCodigoCompSuplPartidaProductoPlaguicidaImportacion($idProducto){
	    
	    $selectCodigoProducto = '';
	    
	    $consulta = "SELECT
                    	*
                    FROM
                    	g_catalogos.partidas_arancelarias pa
                    	INNER JOIN g_catalogos.codigos_comp_supl ccs ON pa.id_partida_arancelaria = ccs.id_partida_arancelaria
                    WHERE
                    	pa.id_producto = $idProducto and
                    	pa.estado='activo' and
                    	ccs.estado='activo';";
	    
	    $partidas = $this->modeloCodigosCompSupl->ejecutarSqlNativo($consulta);
	    
	    foreach($partidas as $fila){
	        $selectCodigoProducto .= '<option value="' . $fila->codigo_complementario.$fila->codigo_suplementario . '" >' .  $fila->partida_arancelaria . ' - ' .$fila->codigo_complementario.$fila->codigo_suplementario . '</option>';
	    }
	    
	    return $selectCodigoProducto;
	}
}