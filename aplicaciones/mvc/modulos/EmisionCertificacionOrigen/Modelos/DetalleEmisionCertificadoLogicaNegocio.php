<?php
 /**
 * Lógica del negocio de DetalleEmisionCertificadoModelo
 *
 * Este archivo se complementa con el archivo DetalleEmisionCertificadoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2020-09-18
 * @uses    DetalleEmisionCertificadoLogicaNegocio
 * @package EmisionCertificacionOrigen
 * @subpackage Modelos
 */
  namespace Agrodb\EmisionCertificacionOrigen\Modelos;
  
  use Agrodb\EmisionCertificacionOrigen\Modelos\IModelo;
 
class DetalleEmisionCertificadoLogicaNegocio implements IModelo 
{

	 private $modeloDetalleEmisionCertificado = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloDetalleEmisionCertificado = new DetalleEmisionCertificadoModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new DetalleEmisionCertificadoModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdDetalleEmisionCertificado() != null && $tablaModelo->getIdDetalleEmisionCertificado() > 0) {
		return $this->modeloDetalleEmisionCertificado->actualizar($datosBd, $tablaModelo->getIdDetalleEmisionCertificado());
		} else {
		unset($datosBd["id_detalle_emision_certificado"]);
		return $this->modeloDetalleEmisionCertificado->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		
		$this->modeloDetalleEmisionCertificado->borrar($id);
	}
	public function borrarPorParametro($param, $value) {
	    $this->modeloDetalleEmisionCertificado->borrarPorParametro($param, $value);
	}
	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return DetalleEmisionCertificadoModelo
	*/
	public function buscar($id)
	{
		return $this->modeloDetalleEmisionCertificado->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloDetalleEmisionCertificado->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloDetalleEmisionCertificado->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarDetalleEmisionCertificado()
	{
	$consulta = "SELECT * FROM ".$this->modeloDetalleEmisionCertificado->getEsquema().". detalle_emision_certificado";
		 return $this->modeloDetalleEmisionCertificado->ejecutarSqlNativo($consulta);
	}
	
	/**
	 * Columnas para guardar junto con el formulario
	 * @return string[]
	 */
	public function columnas()
	{
	    $columnas = array(
	        'id_emision_certificado',
	        'producto_movilizar',
	        'tipo_especie',
	        'tipo_producto_movilizar_canal',
	        'codigo_canal',
	        'destino',
	        'id_productos',
	        'fecha_produccion',
	        'tipo_movilizacion_canal'
	    );
	    return $columnas;
	}
	
	
	

	public function contadorCodigoCanal($arrayParametros){
		if(($arrayParametros['producto_movilizar'] == 'Canal con subproductos')){
			$condicion = "and producto_movilizar in ('".$arrayParametros['producto_movilizar']."','Canal')";
		}else{
			$condicion = "and producto_movilizar ='" . $arrayParametros['producto_movilizar'] . "'";
		}

		if(($arrayParametros['producto_movilizar'] == 'Canal')){
			$condicion = "and producto_movilizar in ('".$arrayParametros['producto_movilizar']."','Canal con subproductos')";
		}
	    	$consulta = "
                    SELECT 
                          count(destino) as repeticion, codigo_canal, destino,tipo_movilizacion_canal  
                    FROM 
                          g_emision_certificacion_origen.detalle_emision_certificado decert
						  INNER JOIN g_emision_certificacion_origen.emision_certificado ec  
						  ON decert.id_emision_certificado = ec.id_emision_certificado
            	    WHERE 
                        fecha_produccion='" . $arrayParametros['fecha_produccion'] . "' 
                        and tipo_especie='" . $arrayParametros['tipo_especie'] . "' 
                        
						".$condicion."
						and identificador_operador ='" . $arrayParametros['identificador_operador'] . "'  
                        and tipo_movilizacion_canal = '" . $arrayParametros['tipo_movilizacion_canal'] . "'
						and fecha_creacion_produccion ='" . $arrayParametros['fecha_creacion_produccion'] . "' 
						and estado_detalle = 'activo'  
            	    group by destino,codigo_canal,tipo_movilizacion_canal order by codigo_canal ;";
	    return $this->modeloDetalleEmisionCertificado->ejecutarSqlNativo($consulta);
	}

	public function contadorCodigoCanalConsumidas($arrayParametros){
		if(($arrayParametros['producto_movilizar'] == 'Canal con subproductos')){
			$condicion = "and producto_movilizar in ('".$arrayParametros['producto_movilizar']."','Canal')";
		}else{
			$condicion = "and producto_movilizar ='" . $arrayParametros['producto_movilizar'] . "'";
		}

		if(($arrayParametros['producto_movilizar'] == 'Canal')){
			$condicion = "and producto_movilizar in ('".$arrayParametros['producto_movilizar']."','Canal con subproductos')";
		}

		$consulta = "
				SELECT 
					  count(destino) as repeticion, codigo_canal, destino,tipo_movilizacion_canal  
				FROM 
					  g_emision_certificacion_origen.detalle_emision_certificado decert
					  INNER JOIN g_emision_certificacion_origen.emision_certificado ec  
					  ON decert.id_emision_certificado = ec.id_emision_certificado
				WHERE 
					fecha_produccion='" . $arrayParametros['fecha_produccion'] . "' 
					and tipo_especie='" . $arrayParametros['tipo_especie'] . "' 
					".$condicion."
					and identificador_operador ='" . $arrayParametros['identificador_operador'] . "' 
					and fecha_creacion_produccion ='" . $arrayParametros['fecha_creacion_produccion'] . "' 
					and estado_detalle = 'activo' 
				group by destino,codigo_canal,tipo_movilizacion_canal order by codigo_canal ;";
	return $this->modeloDetalleEmisionCertificado->ejecutarSqlNativo($consulta);
}
	
	public function obtenerDetalleEmisionCertificado($arrayParametros){
	    $consulta = "
                     SELECT
                         *
                    FROM
					      g_emision_certificacion_origen.emision_certificado ec 
                          inner join g_emision_certificacion_origen.detalle_emision_certificado dec on dec.id_emision_certificado = ec.id_emision_certificado
                     WHERE 
                        ec.identificador_operador ='".$arrayParametros['identificador_operador']."'
                        and fecha_produccion='" . $arrayParametros['fecha_produccion'] . "' 
                        and tipo_especie='" . $arrayParametros['tipo_especie'] . "' 
                        and producto_movilizar not in ('Subproductos')
                        and tipo_producto_movilizar_canal = '".$arrayParametros['tipo_producto_movilizar_canal']."'
						and fecha_creacion_produccion::text ilike '%". $arrayParametros['fecha_creacion_produccion']  ."%' and ec.estado in ('Vigente','Notificar','temporal') and dec.estado_detalle = 'activo';";
	    return $this->modeloDetalleEmisionCertificado->ejecutarSqlNativo($consulta);
	}
	
	public function obtenerDetalleEmisionCertificadoRegistrado($arrayParametros){
	    $busqueda = 'true';
	    if (array_key_exists('id_emision_certificado', $arrayParametros)) {
	        $busqueda .= " and id_emision_certificado=" . $arrayParametros['id_emision_certificado'] ;
	    }
	    if (array_key_exists('id_detalle_emision_certificado', $arrayParametros)) {
	        $busqueda .= " and id_detalle_emision_certificado in (" . $arrayParametros['id_detalle_emision_certificado'] . ")";
	    }
	    $consulta = "
                     SELECT 
                        tipo_especie, fecha_creacion::date AS fecha_produccion, id_productos
                        ,string_agg(distinct id_detalle_emision_certificado::text,', ') as id_detalle_emision_certificado
                    FROM 
                        g_emision_certificacion_origen.detalle_emision_certificado
                    WHERE 
                         ".$busqueda." GROUP BY 1,2,3 order by 1;";
	    return $this->modeloDetalleEmisionCertificado->ejecutarSqlNativo($consulta);
	}
	
	public function obtenerDetalleEmisionCertificadoLista($arrayParametros){
	    $busqueda = 'true';
	    if(array_key_exists('identificador_operador', $arrayParametros)){
	        $busqueda .= " and identificador_operador = '".$arrayParametros['identificador_operador']."'";
	    }
	    if (array_key_exists('id_emision_certificado', $arrayParametros)) {
	        $busqueda .= " and ec.id_emision_certificado=" . $arrayParametros['id_emision_certificado'] ;
	    }
	    if(array_key_exists('fecha_creacion', $arrayParametros)){
	        $busqueda .= " and ec.fecha_creacion::date = '".$arrayParametros['fecha_creacion']."'";
	    }
	    if(array_key_exists('producto_movilizar', $arrayParametros)){
	        $busqueda .= " and producto_movilizar not in ('".$arrayParametros['producto_movilizar']."')";
	    }
	    if(array_key_exists('tipo_especie', $arrayParametros)){
	        $busqueda .= " and tipo_especie = '".$arrayParametros['tipo_especie']."'";
	    }
		if(isset($arrayParametros['sitio_origen']) && isset($arrayParametros['area_origen'])){
			$sitio = $arrayParametros['sitio_origen'];
			$area = $arrayParametros['area_origen'];
			$fecha_produccion = " ";
		}else{
			$sitio = $arrayParametros['id_sitio'];
			$area = $arrayParametros['id_area'];
			$fecha_produccion = " and fecha_produccion = '". $arrayParametros['fecha_produccion']."'";
		}


		if(isset($arrayParametros['fecha_creacion_produccion']) && (isset($arrayParametros['agregarProduccion'])  != 'agregar')){
			$fecha_creacion_produccion = " and dec.fecha_creacion_produccion::text ilike ('%".$arrayParametros['fecha_creacion_produccion']."%') ";
		}else if (isset($arrayParametros['agregarProduccion']) && $arrayParametros['tipo_especie'] == 'Avícola'){
			$fechaActual=date("Y-m-d");
			// $fecha_creacion_produccion = " and to_char(dec.fecha_creacion_produccion, 'YYYY-MM-DD') = '".$fechaActual."'";
			$fecha_creacion_produccion = " ";
		}
	    	$consulta = "
                     SELECT
                        DISTINCT codigo_canal
                    FROM
                   	      g_emision_certificacion_origen.emision_certificado ec 
                          inner join g_emision_certificacion_origen.detalle_emision_certificado dec on dec.id_emision_certificado = ec.id_emision_certificado
                    WHERE
                        ".$busqueda." and (dec.estado_detalle ='activo' or dec.estado_detalle is null) and ec.sitio_origen = ".$sitio." 
						and area_origen = ".$area. $fecha_produccion . $fecha_creacion_produccion . " order by 1;";
	    return $this->modeloDetalleEmisionCertificado->ejecutarSqlNativo($consulta);
	}
	
	public function obtenerCantidadEmisionCertificado($arrayParametros){
		$consulta = "
                     SELECT
                         *
                    FROM
					      g_emision_certificacion_origen.emision_certificado ec
                          INNER JOIN g_emision_certificacion_origen.detalle_emision_certificado dec on dec.id_emision_certificado = ec.id_emision_certificado
                     WHERE
                        ec.identificador_operador ='".$arrayParametros['identificador_operador']."'
                        and fecha_produccion='" . $arrayParametros['fecha_produccion'] . "'
                        and tipo_especie='" . $arrayParametros['tipo_especie'] . "'
                        and producto_movilizar ='" . $arrayParametros['producto_movilizar'] . "'
						and tipo_movilizacion_canal ='" . $arrayParametros['tipo_movilizacion_canal'] . "'
                        and tipo_producto_movilizar_canal = '".$arrayParametros['tipo_producto_movilizar_canal']."'and dec.estado_detalle = 'activo'
						and dec.fecha_creacion::text ilike ('%" . $_POST['fecha_creacion_produccion'] ."%');";
		
		return $this->modeloDetalleEmisionCertificado->ejecutarSqlNativo($consulta);
	}

	public function eliminarDetalleEmisionCertificadoTemporal($idEmisionCertificado){
		$consulta = "
					DELETE
					FROM g_emision_certificacion_origen.detalle_emision_certificado where id_emision_certificado = $idEmisionCertificado ";
		
		return $this->modeloDetalleEmisionCertificado->ejecutarSqlNativo($consulta);
	}

	public function verificarRegistroEmisionCertificado($arrayParametros){
		$consulta = "
					SELECT * from g_emision_certificacion_origen.detalle_emision_certificado 
					WHERE codigo_canal = '".$arrayParametros['codigo_canal']."' 
						and destino = '".$arrayParametros['destino']."' and producto_movilizar ='".$arrayParametros['producto_movilizar']."' 
						and id_emision_certificado = ".$arrayParametros['id_emision_certificado']." and tipo_movilizacion_canal ='".$arrayParametros['tipo_movilizacion_canal']."' and tipo_especie = '".$arrayParametros['tipo_especie']."'";
		
		return $this->modeloDetalleEmisionCertificado->ejecutarSqlNativo($consulta);
	}

	public function buscarListaProductosAgregados($idEmisionCertificado){
		$consulta = "
					SELECT 
					fecha_produccion,tipo_especie, tipo_producto_movilizar_canal, 
					tipo_movilizacion_canal, codigo_canal , 
					(id_detalle_emision_certificado||'/'||codigo_canal||'/'||id_emision_certificado||'/'||fecha_produccion||'/'||tipo_especie) as codigo 
					FROM g_emision_certificacion_origen.detalle_emision_certificado 
					WHERE id_emision_certificado = ".$idEmisionCertificado." order by 1";
		
		return $this->modeloDetalleEmisionCertificado->ejecutarSqlNativo($consulta);
	}



	public function eliminarProductosAgregados($arrayParametros){
		$consulta = "
					DELETE FROM g_emision_certificacion_origen.detalle_emision_certificado
					WHERE codigo_canal ='".$arrayParametros['codigo_canal']."' 
					and id_emision_certificado = ".$arrayParametros['id_emision_certificado']." and fecha_produccion ='".$arrayParametros['fecha_produccion']."' and tipo_especie = '".$arrayParametros['tipo_especie']."'";
		return $this->modeloDetalleEmisionCertificado->ejecutarSqlNativo($consulta);
	}
	
	public function inactivarDetalleEmisionCertificado($arrayParametros){
		$consulta = "
					UPDATE g_emision_certificacion_origen.detalle_emision_certificado
					SET estado_detalle = 'inactivo', observacion_anulacion = 'Certificado inhabilitado por el tecnico, ".$arrayParametros['identificador']."'
					where id_emision_certificado = ".$arrayParametros['id_emision_certificado']." ";
		
		return $this->modeloDetalleEmisionCertificado->ejecutarSqlNativo($consulta);
	}

	public function eliminarDetalleEmisionCertificadoXId($idEmisionCertificado){
		$consulta = "DELETE FROM g_emision_certificacion_origen.detalle_emision_certificado where id_emision_certificado =".$idEmisionCertificado.";";
		
		return $this->modeloDetalleEmisionCertificado->ejecutarSqlNativo($consulta);
	}

	public function listarProductosCanalSubAgregados($idEmisionCertificado){
		$consulta = "SELECT tipo_especie,id_productos 
					FROM g_emision_certificacion_origen.detalle_emision_certificado 
					WHERE id_emision_certificado =".$idEmisionCertificado." group by tipo_especie,id_productos;";
		
		return $this->modeloDetalleEmisionCertificado->ejecutarSqlNativo($consulta);
	}

	public function obtenerDetalleEmisionCertificadoRegistradoXIdProducto($idProducto){
	    
	    $consulta = "SELECT tipo_especie, fecha_produccion, fecha_creacion_produccion
			FROM g_emision_certificacion_origen.detalle_emision_certificado
			where id_productos = $idProducto group by tipo_especie, fecha_produccion, fecha_creacion_produccion";
	    return $this->modeloDetalleEmisionCertificado->ejecutarSqlNativo($consulta);
	}

}
