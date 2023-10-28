<?php
 /**
 * Lógica del negocio de ProductosTempModelo
 *
 * Este archivo se complementa con el archivo ProductosTempControlador.
 *
 * @author  AGROCALIDAD
 * @date    2020-09-18
 * @uses    ProductosTempLogicaNegocio
 * @package EmisionCertificacionOrigen
 * @subpackage Modelos
 */
  namespace Agrodb\EmisionCertificacionOrigen\Modelos;
  
  use Agrodb\EmisionCertificacionOrigen\Modelos\IModelo;
 
class ProductosTempLogicaNegocio implements IModelo 
{

	 private $modeloProductosTemp = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloProductosTemp = new ProductosTempModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		
		$tablaModelo = new ProductosTempModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdProductosTemp() != null && $tablaModelo->getIdProductosTemp() > 0) {
		return $this->modeloProductosTemp->actualizar($datosBd, $tablaModelo->getIdProductosTemp());
		} else {
		unset($datosBd["id_productos_temp"]);
		return $this->modeloProductosTemp->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloProductosTemp->borrar($id);
	}
	public function borrarPorParametro($param, $value) {
	    $this->modeloProductosTemp->borrarPorParametro($param, $value);
	}
	
	public function borrarTablasTemporales($cedulaUsuario, $banderaPerfil) {
	    $arrayParametros = array('identificador_operador' => $cedulaUsuario, 'perfil' => $banderaPerfil);
	    $consulta = $this->obtenerEspecie($arrayParametros);
	    $lnegocioSubproducto = new SubproductosTempLogicaNegocio();
	    foreach ($consulta as $value) {
	        $lnegocioSubproducto->borrarPorParametro('id_productos_temp',$value['id_productos_temp']);
			$this->modeloProductosTemp->borrarPorParametro('identificador_operador',"'".$value['identificador_operador']."'");
	    }
	    $this->modeloProductosTemp->borrarPorParametro('identificador_operador',"'".$cedulaUsuario."'");
	}
	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return ProductosTempModelo
	*/
	public function buscar($id)
	{
		return $this->modeloProductosTemp->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloProductosTemp->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloProductosTemp->buscarLista($where, $order, $count, $offset);
	}

	public function obtenerEspecie($arrayParametros){
		if($arrayParametros['perfil']){
			$condicion =" ";
		}else{
			
			$condicion = " WHERE identificador_operador='".$arrayParametros['identificador_operador']."'";
		}
	   $consulta ="
            SELECT 
				identificador_operador, tipo_especie, id_productos_temp, codigo_canal, num_Canales_obtenidos, row_number() over() as contador
            FROM 
                g_emision_certificacion_origen.productos_temp".$condicion."
             order by 2;";    
	   return $this->modeloProductosTemp->ejecutarConsulta($consulta);
	}
	
	public function obtenerSumaProduccionTemp($arrayParametros){
	    $buscar='id_productos_temp';
	    if(array_key_exists('num_canales_obtenidos_uso', $arrayParametros)){
	        $buscar = "sum(num_canales_obtenidos_uso) as total";
	    }
	    if(array_key_exists('num_canales_uso_industri', $arrayParametros)){
	        $buscar = "sum(num_canales_uso_industri) as total";
	    }
	    $consulta ="
            SELECT
                ".$buscar."
            FROM
                g_emision_certificacion_origen.productos_temp
            WHERE
                identificador_operador='".$arrayParametros['identificador_operador']."' 
                and tipo_especie ='".$arrayParametros['tipo_especie']."';";
	    return $this->modeloProductosTemp->ejecutarSqlNativo($consulta);
	}
	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarProductosTemp()
	{
	$consulta = "SELECT * FROM ".$this->modeloProductosTemp->getEsquema().". productos_temp";
		 return $this->modeloProductosTemp->ejecutarSqlNativo($consulta);
	}

	public function buscarProduccionPorSitioArea($arrayParametros)
	{
		$consulta = "
				SELECT *
				FROM g_emision_certificacion_origen.registro_produccion rp 
				INNER JOIN g_emision_certificacion_origen.productos pro ON rp.id_registro_produccion = pro.id_registro_produccion 
				LEFT JOIN g_emision_certificacion_origen.subproductos S ON s.id_productos = pro.id_productos 
				INNER JOIN g_operadores.sitios sit ON sit.id_sitio = rp.id_sitio 
				WHERE pro.fecha_faenamiento = '".$arrayParametros['fecha_faenamiento']."' and rp.identificador_operador = '".$arrayParametros['identificador_operador']."'
				and pro.tipo_especie = '".$arrayParametros['tipo_especie']."' 
				and rp.id_sitio = ".$arrayParametros['id_sitio']." 
				and rp.id_area =".$arrayParametros['id_area']."";
		 return $this->modeloProductosTemp->ejecutarSqlNativo($consulta);
	}

}
