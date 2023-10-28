<?php
 /**
 * Lógica del negocio de RegistroProduccionModelo
 *
 * Este archivo se complementa con el archivo RegistroProduccionControlador.
 *
 * @author  AGROCALIDAD
 * @date    2020-09-18
 * @uses    RegistroProduccionLogicaNegocio
 * @package EmisionCertificacionOrigen
 * @subpackage Modelos
 */
  namespace Agrodb\EmisionCertificacionOrigen\Modelos;
  
  use Agrodb\EmisionCertificacionOrigen\Modelos\IModelo;
 
class RegistroProduccionLogicaNegocio implements IModelo 
{

	 private $modeloRegistroProduccion = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloRegistroProduccion = new RegistroProduccionModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		
		$tablaModelo = new RegistroProduccionModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdRegistroProduccion() != null && $tablaModelo->getIdRegistroProduccion() > 0) {
		return $this->modeloRegistroProduccion->actualizar($datosBd, $tablaModelo->getIdRegistroProduccion());
		} else {
		unset($datosBd["id_registro_produccion"]);
		return $this->modeloRegistroProduccion->guardar($datosBd);
	}
	}
	
	/**
	 * Guarda el registro actual
	 * @param array $datos
	 * @return int
	 */
public function guardarProduccion(Array $datos)
	{
		
		if($datos['emergente'] == 'emergenteProduccion' || $datos['emergente'] == 'noEmergenteProduccion'){
			$arrayParametros = array(
				'ruc' => ($datos['emergente'] == 'emergenteProduccion' ? $datos['ruc'] : $_SESSION['usuario']),
				'id_sitio' => $datos['id_sitio'],
				'id_area' => $datos['id_area'],
				'tipo_especie' => $datos['especie'],
			);			
			$centroFaenamiento = $this->buscarProduccionSitioPorCentroFaenamiento($arrayParametros);
			$idRegistroProduccion = '';
			if (count($centroFaenamiento) > 0 ){
				if($datos['emergente'] == 'emergenteProduccion'){
					

					// $cedulaTecnico = $this->obtenerRegistroProduccionCentroFaenamiento($centroFaenamiento->current()->id_registro_produccion);
			
					if(($centroFaenamiento->current()->identificador_tecnico) == ''){
						$arrayParametros = array(
							'identificador_tecnico' =>  $datos['identificador_tecnico'],
							'id_registro_produccion' => $centroFaenamiento->current()->id_registro_produccion,
						);
						$this->actualizarTablaRegistroProduccionCentroFaenamiento($arrayParametros);

					}else{
						
						$cedulasTecnicosObtenidos = explode(",", $centroFaenamiento->current()->identificador_tecnico);
						if (!in_array($datos['identificador_tecnico'], $cedulasTecnicosObtenidos)) {
							$cedulaTecnico = ($centroFaenamiento->current()->identificador_tecnico.",". $datos['identificador_tecnico']);
								$arrayParametros = array(
									'identificador_tecnico' =>  $cedulaTecnico,
									'id_registro_produccion' => $centroFaenamiento->current()->id_registro_produccion,
								);
							$this->actualizarTablaRegistroProduccionCentroFaenamiento($arrayParametros);
						}
					}
				}
								
				$idRegistroProduccion = $centroFaenamiento->current()->id_registro_produccion;
				$tipoEspecie = $datos['especie'];
			}
		}
		
		if(isset($datos['ruc']) && $datos['ruc']!=''){
			$_SESSION['cedulaUsuario'] = $datos['ruc'];
		}
		
	    $lNegocioProductosTemp = new ProductosTempLogicaNegocio();
	    $resultado =  $lNegocioProductosTemp->buscarLista("identificador_operador='".$_SESSION['cedulaUsuario']."' order by 1");
		
	    if($resultado->count() > 0){
	        try{
	            $this->modeloRegistroProduccion = new RegistroProduccionModelo();
	            $proceso = $this->modeloRegistroProduccion->getAdapter()
	            ->getDriver()
	            ->getConnection();
	            if (! $proceso->beginTransaction()){
	                throw new \Exception('No se pudo iniciar la transacción: Guardar productos');
	            }
	            $datos['identificador_operador'] = $_SESSION['cedulaUsuario'];
				
				
	            $tablaModelo = new RegistroProduccionModelo($datos);
	            $datosBd = $tablaModelo->getPrepararDatos();
				if($idRegistroProduccion != ''){
					$idRegistro = $idRegistroProduccion;
				}else{
					if ($tablaModelo->getIdRegistroProduccion() != null && $tablaModelo->getIdRegistroProduccion() > 0) {
						$idRegistro = $this->modeloRegistroProduccion->actualizar($datosBd, $tablaModelo->getIdRegistroProduccion());
					} else {
						unset($datosBd["id_registro_produccion"]);
						$idRegistro = $this->modeloRegistroProduccion->guardar($datosBd);
					}
				}
	            
	            if (!$idRegistro)
	            {
	                throw new \Exception('No se registo los datos en la tabla registro_produccion');
	            }
	            //*************guadar productos*************

				if($idRegistroProduccion != ''){
					$arrayParametros = array(
						'id_registro_produccion' => $idRegistroProduccion,
						'tipo_especie' => $tipoEspecie,
						
					);
					$produccionObtenida = $this->obtenerPorductoCentroFaenamiento($arrayParametros);
					$idProductos = $produccionObtenida->current()->id_productos;
					$tipoEspecie = $produccionObtenida->current()->tipo_especie;
					$canalesObtenidos = $produccionObtenida->current()->num_canales_obtenidos;
					$canalesObtenidosUso = $produccionObtenida->current()->num_canales_obtenidos_uso;
					$canalesUsoIndustrial = $produccionObtenida->current()->num_canales_uso_industri;
					$numeroAnimalesRecibidos = $produccionObtenida->current()->num_animales_recibidos;
					$lnegocioProductos = new ProductosLogicaNegocio();
					foreach ($resultado as $item) {
						
						$datosTecnico = array(
							'id_productos' => ($idProductos),
							'id_registro_produccion' => ($idRegistroProduccion),
							'fecha_creacion' => ($produccionObtenida->current()->fecha_creacion),
							'codigo_canal' => $produccionObtenida->current()->codigo_canal,
							'num_canales_obtenidos' => ($item['num_canales_obtenidos']),
							'num_canales_obtenidos_uso' => ($item['num_canales_obtenidos_uso']),
							'num_canales_uso_industri' => ($item['num_canales_uso_industri']),
							'num_animales_recibidos' => ($item['num_animales_recibidos']),
							'id_productos' => $idProductos,
							'tipo_especie' => $tipoEspecie,
							'identificador_tecnico' => ($datos['emergente'] == 'emergenteProduccion' ? $datos['identificador_tecnico'] : ''), 
						);

						$this->ingresarTablaHistorialProductosCentroFaenamiento($datosTecnico);

						$datosProductos = array(
							'num_canales_obtenidos' => ($item['num_canales_obtenidos']+$canalesObtenidos),
							'num_canales_obtenidos_uso' => ($item['num_canales_obtenidos_uso']+$canalesObtenidosUso),
							'num_canales_uso_industri' => ($item['num_canales_uso_industri']+$canalesUsoIndustrial),
							'num_animales_recibidos' => ($item['num_animales_recibidos']+$numeroAnimalesRecibidos),
							
							'id_productos' => $idProductos,
							'tipo_especie' => $tipoEspecie,
						);

					}
					$this->actualizarTablaProductosCentroFaenamiento($datosProductos);

					$lNegocioSubproductosTemp = new SubproductosTempLogicaNegocio();
						$subPro =  $lNegocioSubproductosTemp->buscarLista("id_productos_temp=".$item['id_productos_temp']." order by 1");
						if($subPro->count() > 0){
							$lNegocioSubproductos = new SubproductosLogicaNegocio();
							foreach ($subPro as $value) {
								$datosSubproductos = array(
									'id_productos' => $idProductos,
									'subproducto' => $value['subproducto'],
									'cantidad' => $value['cantidad']
								);
								$subproductos = $this->obtenerSubPrductoCentroFaenamiento($datosSubproductos);
						
								if(count($subproductos) > 0){
									$cantidadObtenida = $subproductos->current()->cantidad;
									$datosInsertar = array(
										'id_productos' => $idProductos,
										'subproducto' => $value['subproducto'],
										'cantidad' => $value['cantidad'],
										'identificador_tecnico' => $datos['emergente'] == 'emergenteProduccion' ? $datos['identificador_tecnico'] : ''
									);
									$this->insertarTablaHistorialSubproductosCentroFaenamiento($datosInsertar);
									$datosActualizar = array(
										'id_productos' => $idProductos,
										'subproducto' => $value['subproducto'],
										'cantidad' => ($value['cantidad']+$cantidadObtenida),
										
									);
									$this->actualizarTablaSubproductosCentroFaenamiento($datosActualizar);
								}else{
									$this->insertarTablaSubproductosCentroFaenamiento($datosSubproductos);
								}
						    }
						}
				}else{
					foreach ($resultado as $item) {
						$lnegocioProductos = new ProductosLogicaNegocio();
						$datos = array(
							'id_registro_produccion' => $idRegistro,
							'num_canales_obtenidos' => $item['num_canales_obtenidos'],
							'num_canales_obtenidos_uso' => $item['num_canales_obtenidos_uso'],
							'num_canales_uso_industri' =>$item['num_canales_uso_industri'],
							'tipo_especie' => $item['tipo_especie'],
							'num_animales_recibidos' => $item['num_animales_recibidos'],
							'fecha_recepcion' => $item['fecha_recepcion'],
							'codigo_canal' => $item['codigo_canal'],
							'fecha_faenamiento' => $item['fecha_faenamiento'],
							'hora_inicio_recepcion' => $item['hora_inicio_recepcion'],
							'hora_fin_recepcion' => $item['hora_fin_recepcion'],
							'hora_inicio_faenamiento' => $item['hora_inicio_faenamiento'],
							'hora_fin_faenamiento' => $item['hora_fin_faenamiento'],
						);
						$statement = $this->modeloRegistroProduccion->getAdapter()
						->getDriver()
						->createStatement();
						$sqlInsertar = $this->modeloRegistroProduccion->guardarSql('productos', $this->modeloRegistroProduccion->getEsquema());
						$sqlInsertar->columns($lnegocioProductos->columnas());
						$sqlInsertar->values($datos, $sqlInsertar::VALUES_MERGE);
						$sqlInsertar->prepareStatement($this->modeloRegistroProduccion->getAdapter(), $statement);
						$statement->execute();
						$idProducto= $this->modeloRegistroProduccion->adapter->driver->getLastGeneratedValue($this->modeloRegistroProduccion->getEsquema() . '.productos_id_productos_seq');
						if (!$idProducto)
						{
							throw new \Exception('No se registo los datos en la tabla productos');
						}
						$lNegocioSubproductosTemp = new SubproductosTempLogicaNegocio();
						$subPro =  $lNegocioSubproductosTemp->buscarLista("id_productos_temp=".$item['id_productos_temp']." order by 1");
						if($subPro->count() > 0){
							$lNegocioSubproductos = new SubproductosLogicaNegocio();
							foreach ($subPro as $value) {
								$datos = array(
									'id_productos' => $idProducto,
									'subproducto' => $value['subproducto'],
									'cantidad' => $value['cantidad']
								);
								$statement = $this->modeloRegistroProduccion->getAdapter()
								->getDriver()
								->createStatement();
								$sqlInsertar = $this->modeloRegistroProduccion->guardarSql('subproductos', $this->modeloRegistroProduccion->getEsquema());
								$sqlInsertar->columns($lNegocioSubproductos->columnas());
								$sqlInsertar->values($datos, $sqlInsertar::VALUES_MERGE);
								$sqlInsertar->prepareStatement($this->modeloRegistroProduccion->getAdapter(), $statement);
								$statement->execute();
								
							}
						}
						
					}
				}
      
	            $proceso->commit();
	            return $idRegistro;
	        }catch (\Exception $ex){
	            $proceso->rollback();
	            throw new \Exception($ex->getMessage());
	            return 0;
	        }
	    }
	    
	}
	/**
	 * Guarda el registro actual
	 * @param array $datos
	 * @return int
	 */
	public function guardarProductos(Array $datos)
	{
	    try{
	        $this->modeloRegistroProduccion = new RegistroProduccionModelo();
	        $proceso = $this->modeloRegistroProduccion->getAdapter()
	    ->getDriver()
	    ->getConnection();
	    if (! $proceso->beginTransaction()){
	        throw new \Exception('No se pudo iniciar la transacción: Guardar productos');
	    }
	    $datos['identificador_operador'] = $_SESSION['usuario'];
	    $tablaModelo = new RegistroProduccionModelo($datos);
	    $datosBd = $tablaModelo->getPrepararDatos();
	    if ($tablaModelo->getIdRegistroProduccion() != null && $tablaModelo->getIdRegistroProduccion() > 0) {
	        $idRegistro = $this->modeloRegistroProduccion->actualizar($datosBd, $tablaModelo->getIdRegistroProduccion());
	    } else {
	        unset($datosBd["id_registro_produccion"]);
	        $idRegistro = $this->modeloRegistroProduccion->guardar($datosBd);
	    }
	    if (!$idRegistro)
	    {
	        throw new \Exception('No se registo los datos en la tabla registro_produccion');
	    }
	    //*************guadar detalle de productos*************
        	    if(isset($datos['tipo_especie'])){
        	            $lnegocioDetalleSolicitudInspeccion = new ProductosLogicaNegocio();
        	            $datos = array(
        	                'id_registro_produccion' => $idRegistro,
        	                'num_canales_obtenidos' => $datos['num_canales_obtenidos'],
        	                'num_canales_obtenidos_uso' => $datos['num_canales_obtenidos_uso'],
        	                'num_canales_uso_industri' =>$datos['num_canales_uso_industri'],
        	                'tipo_especie' => $datos['tipo_especie'],
        	                'num_animales_recibidos' => $datos['num_animales_recibidos'],
        	                'fecha_recepcion' => $datos['fecha_recepcion']
        	            );
        	            $statement = $this->modeloRegistroProduccion->getAdapter()
        	            ->getDriver()
        	            ->createStatement();
        	            $sqlInsertar = $this->modeloRegistroProduccion->guardarSql('productos', $this->modeloRegistroProduccion->getEsquema());
        	            $sqlInsertar->columns($lnegocioDetalleSolicitudInspeccion->columnas());
        	            $sqlInsertar->values($datos, $sqlInsertar::VALUES_MERGE);
        	            $sqlInsertar->prepareStatement($this->modeloRegistroProduccion->getAdapter(), $statement);
        	            $statement->execute();
        	    }else{
        	        throw new \Exception('No existe productos..!!');
        	    }
	    
	    $proceso->commit();
	    return $idRegistro;
	    }catch (\Exception $ex){
	        $proceso->rollback();
	        throw new \Exception($ex->getMessage());
	        return 0;
	    }
	    
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloRegistroProduccion->borrar($id);
	}
	public function borrarPorParametro($param, $value) {
	    $this->modeloRegistroProduccion->borrarPorParametro($param, $value);
	}
	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return RegistroProduccionModelo
	*/
	public function buscar($id)
	{
		return $this->modeloRegistroProduccion->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloRegistroProduccion->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloRegistroProduccion->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarRegistroProduccion()
	{
	$consulta = "SELECT * FROM ".$this->modeloRegistroProduccion->getEsquema().". registro_produccion";
		 return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);
	}
	
	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 *
	 * @return array|ResultSet
	 */
	public function listarRegistroProduccion($arrayParametros,$order='order by 1')
	{
			
		$busqueda='';
	    if(array_key_exists('fecha_creacion', $arrayParametros)){
	        $busqueda .= " and rp.fecha_creacion::date = '".$arrayParametros['fecha_creacion']."'";
	    }
	    if(array_key_exists('id_registro_produccion', $arrayParametros)){
	        $busqueda .= " and rp.id_registro_produccion = '".$arrayParametros['id_registro_produccion']."'";
	    }
	    if(array_key_exists('id_productos', $arrayParametros)){
	        $busqueda .= " and p.id_productos = ".$arrayParametros['id_productos'];
	    }
	    if(array_key_exists('fechaInicio', $arrayParametros)){
	        $busqueda .= " and rp.fecha_creacion::date BETWEEN '".$arrayParametros['fechaInicio']."' AND '".$arrayParametros['fechaFin']."'";
	    }
	    if(array_key_exists('fecha_recepcion', $arrayParametros)){
	        $busqueda .= " and fecha_recepcion ='".$arrayParametros['fecha_recepcion']."'";
	    }
	    if(array_key_exists('tipo_especie', $arrayParametros)){
	        $busqueda .= " and tipo_especie ='".$arrayParametros['tipo_especie']."'";
	    }
	    if(array_key_exists('fecha_faenamiento', $arrayParametros)){
	        $busqueda .= " and fecha_faenamiento ='".$arrayParametros['fecha_faenamiento']."'";
	    }

		if(!isset($arrayParametros['tipoUsuario']) && $arrayParametros['tipoUsuario'] ){
	        $arrayParametros['codSitio'] = 'emisi.sitio_origen';
	        $arrayParametros['codArea'] = 'emisi.area_origen';
	    }else{
			$arrayParametros['codSitio'] = 'rp.id_sitio';
			$arrayParametros['codArea'] = 'rp.id_area';
		}
		if (!array_key_exists('condicion', $arrayParametros)){
			$condicion = "LEFT";
		}else{
			$condicion = "INNER";
		}
		if (isset($arrayParametros['registroProduccion']) && $arrayParametros['registroProduccion'] == true){
			$identificador = " rp.identificador_tecnico ilike ('%".$arrayParametros['identificador_operador']."%')";
		}else{
			if(isset($arrayParametros['perfil']) && $arrayParametros['perfil'] == true){
				$identificador = " rp.identificador_tecnico ilike ('%".$arrayParametros['identificador_operador']."%')";
			}else{
				$identificador = " rp.identificador_operador = '".$arrayParametros['identificador_operador']."'";
			}
		}
		
		if(isset($arrayParametros['fecha_creacion_produccion'])){
			$fechaProduccion = " and rp.fecha_creacion::text ilike ('%". $arrayParametros['fecha_creacion_produccion'] ."%')";
		}else{
			$fechaProduccion = " ";
		}
	    //OBTENER TOTAL	
		$consulta = "
					SELECT rp.id_registro_produccion,fecha_faenamiento,rp.id_registro_produccion,sit.nombre_lugar, 
					fecha_recepcion, tipo_especie, num_canales_obtenidos,num_canales_obtenidos_uso, 
					num_canales_uso_industri,num_animales_recibidos, codigo_canal, 
					string_agg(distinct s.subproducto,', ') as subproducto, p.id_productos, to_char(rp.fecha_creacion,'yyyy-MM-dd HH24:MI:SS') as fecha_creacion 
					FROM g_emision_certificacion_origen.registro_produccion rp 
					INNER JOIN g_emision_certificacion_origen.productos p ON rp.id_registro_produccion = p.id_registro_produccion 
					LEFT JOIN g_emision_certificacion_origen.subproductos S ON s.id_productos = p.id_productos
					".$condicion." JOIN g_emision_certificacion_origen.emision_certificado emisi
					ON rp.identificador_operador = emisi.identificador_operador
					INNER JOIN g_operadores.sitios sit ON sit.id_sitio = ". $arrayParametros['codSitio'] ."
					INNER JOIN g_operadores.areas ar ON ar.id_area = ". $arrayParametros['codArea'] ."
                    WHERE 
                            ". $identificador ."
                            ".$busqueda. $fechaProduccion."  
							GROUP BY rp.id_registro_produccion,fecha_recepcion, tipo_especie,num_canales_obtenidos,num_canales_obtenidos_uso,
							num_canales_uso_industri,num_animales_recibidos, codigo_canal,  rp.id_registro_produccion,p.id_productos,fecha_faenamiento,sit.nombre_lugar ".$order.";";
		
	    return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);
	}
	
	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 *
	 * @return array|ResultSet
	 */
	public function listarRegistroSubProduccion($arrayParametros,$order='order by 1')
	{
	    $busqueda='';
	    if(array_key_exists('fecha_creacion', $arrayParametros)){
	        $busqueda .= " and rp.fecha_creacion::date = '".$arrayParametros['fecha_creacion']."'";
	    }
	    if(array_key_exists('id_registro_produccion', $arrayParametros)){
	        $busqueda .= " and rp.id_registro_produccion = '".$arrayParametros['id_registro_produccion']."'";
	    }
	    if(array_key_exists('id_productos', $arrayParametros)){
	        $busqueda .= " and p.id_productos = '".$arrayParametros['id_productos']."'";
	    }
	    if(array_key_exists('fechaInicio', $arrayParametros)){
	        $busqueda .= " and rp.fecha_creacion::date BETWEEN '".$arrayParametros['fechaInicio']."' AND '".$arrayParametros['fechaFin']."'";
	    }
	    if(array_key_exists('fecha_faenamiento', $arrayParametros)){
	        $busqueda .= " and p.fecha_faenamiento ='".$arrayParametros['fecha_faenamiento']."'";
	    }
	    if(array_key_exists('tipo_especie', $arrayParametros)){
	        $busqueda .= " and tipo_especie ='".$arrayParametros['tipo_especie']."'";
	    }
		if(array_key_exists('bandera', $arrayParametros) && !$arrayParametros['bandera']){
			if($arrayParametros['fecha_creacion_produccion'] != ""){
	        $busqueda .= " and rp.fecha_creacion::text ilike ('%".$arrayParametros['fecha_creacion_produccion']."%')";
			}else{
				$busqueda .= " ";
			}
	    }

		if(array_key_exists('banderaSubproducto', $arrayParametros) && $arrayParametros['banderaSubproducto']){
			$busqueda .= " and rp.fecha_creacion::text ilike ('%".$arrayParametros['fecha_creacion_produccion']."%')";
		}

	        $consulta = "
                    SELECT
                            rp.id_registro_produccion, fecha_recepcion, tipo_especie, num_canales_obtenidos,num_canales_obtenidos_uso,
                            num_canales_uso_industri,num_animales_recibidos, codigo_canal, string_agg(distinct s.subproducto,', ') as subproducto,
                            p.id_productos, s.id_subproductos, to_char( p.fecha_creacion, 'yyyy-MM-dd HH24:MI:SS') as fecha_creacion
                    FROM
                            g_emision_certificacion_origen.registro_produccion rp INNER JOIN g_emision_certificacion_origen.productos p
                            ON rp.id_registro_produccion = p.id_registro_produccion INNER JOIN g_emision_certificacion_origen.subproductos S
                            ON s.id_productos = p.id_productos
                    WHERE
                            rp.identificador_operador ='".$arrayParametros['identificador_operador']."'
                            ".$busqueda." 
							GROUP BY rp.id_registro_produccion,fecha_recepcion, tipo_especie,num_canales_obtenidos,num_canales_obtenidos_uso,
							num_canales_uso_industri,num_animales_recibidos, codigo_canal,  rp.id_registro_produccion,p.id_productos,s.id_subproductos  ".$order.";";
	    return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);
	}
	/**
	 * Ejecuta una consulta(SQL) personalizada para obtener los sitios.
	 *
	 * @return array|ResultSet
	 */
	public function buscarSitioFaenamiento($arrayParametros)
	{
	    
	    $busqueda='';
	    if(array_key_exists('id_centro_faenamiento', $arrayParametros)){
	        $busqueda .= " and id_centro_faenamiento ='".$arrayParametros['id_centro_faenamiento']."'";
	    }
		$consulta = "SELECT o.identificador as identificador_operador ,cf.id_centro_faenamiento 
						,s.nombre_lugar ,a.nombre_area , string_agg(distinct stp.nombre,', ') as especie 
					FROM g_operadores.operadores o 
					INNER JOIN g_operadores.sitios s ON s.identificador_operador = o.identificador 
						INNER JOIN g_operadores.areas a ON a.id_sitio = s.id_sitio 
						INNER JOIN g_operadores.productos_areas_operacion pao ON pao.id_area = a.id_area 
						INNER JOIN g_operadores.operaciones op ON op.id_operacion = pao.id_operacion 
						INNER JOIN g_catalogos.productos p ON p.id_producto = op.id_producto 
						INNER JOIN g_catalogos.subtipo_productos stp ON stp.id_subtipo_producto = p.id_subtipo_producto 
						INNER JOIN g_centros_faenamiento.centros_faenamiento cf ON cf.id_sitio = s.id_sitio and cf.id_area = a.id_area and cf.id_operador_tipo_operacion = op.id_operador_tipo_operacion
						WHERE
							cf.identificador_operador = '" . $arrayParametros['identificador_operador'] . "' and
							cf.criterio_funcionamiento in ('Habilitado','Activo')
							".$busqueda."group by o.identificador,cf.id_centro_faenamiento ,s.nombre_lugar ,a.nombre_area;";
							
	    $datosFaenadorSitio = $this->modeloRegistroProduccion->ejecutarConsulta($consulta);
	    $especie = $opcion=$idCentroFaenamiento='';
	    foreach ($datosFaenadorSitio as $item) {
	        $especie = explode(',', $item['especie']);
	        foreach ($especie as $valor) {
	            if (trim($valor) === 'AVICOLA') {
	                $valoresEspecie[] = 'Aves';
	            } else {
	                $valoresEspecie[] = 'Otros';
	            }
	        }
	        $valoresEspecie = array_unique($valoresEspecie);
	        $idCentroFaenamiento = $item['id_centro_faenamiento'];
	        if (in_array('Aves', $valoresEspecie)) {
	            $opcion = 'Menores';
	        }else{
	            $opcion = 'Mayores';
	        }
	    }
	    return array('tipo' => $opcion, 'idCentroFaenamiento' => $idCentroFaenamiento, 'especie' => $especie);
	}
	
	public function obtenerSubproducto($arrayParametros){

	    $busqueda='';
	    if (array_key_exists('nombre_comun', $arrayParametros)) {
	        $busqueda .= " and nombre_comun = '".$arrayParametros['nombre_comun']."'";
	    }
	  	$consulta ="
            SELECT 
                p.id_producto, nombre_comun, numero_piezas  
            FROM 
                g_catalogos.tipo_productos tp inner join g_catalogos.subtipo_productos stp on stp.id_tipo_producto = tp.id_tipo_producto
                inner join  g_catalogos.productos p on p.id_subtipo_producto = stp.id_subtipo_producto
            WHERE 
                id_area='" . $arrayParametros['id_area'] . "' and tp.nombre='" . $arrayParametros['nombreTipoProducto'] . "'
				and stp.nombre = '" . $arrayParametros['nombreSubtipo'] . "'
                and upper(nombre_comun) not in (upper('Canal')) and numero_piezas is not null and numero_piezas > 0
                 ".$busqueda.";";    
	   return $this->modeloRegistroProduccion->ejecutarConsulta($consulta);
	}
	
	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 *
	 * @return array|ResultSet
	 */
	public function buscarSubproductosXProductos($arrayParametros)
	{
	    $busqueda='true';
	    if (array_key_exists('id_productos', $arrayParametros)) {
	        $busqueda .= " and p.id_productos = ".$arrayParametros['id_productos'];
	    }
	    if(array_key_exists('id_registro_produccion', $arrayParametros)){
	        $busqueda .= " and rp.id_registro_produccion = ".$arrayParametros['id_registro_produccion'];
	    }
	    if(array_key_exists('identificador_operador', $arrayParametros)){
	        $busqueda .= " and rp.identificador_operador = '".$arrayParametros['identificador_operador']."'";
	    }
	    $consulta = "
                    SELECT
                            s.id_subproductos, fecha_recepcion,fecha_faenamiento, tipo_especie, s.subproducto, cantidad, 
                            (SELECT sum(cantidad) FROM g_emision_certificacion_origen.subproductos WHERE id_productos = p.id_productos) as resultado
                    FROM
                            g_emision_certificacion_origen.registro_produccion rp INNER JOIN g_emision_certificacion_origen.productos p
                            ON rp.id_registro_produccion = p.id_registro_produccion INNER JOIN g_emision_certificacion_origen.subproductos S
                            ON s.id_productos = p.id_productos
                    WHERE
                            ".$busqueda."
							 order by 1;";
	    return $this->modeloRegistroProduccion->ejecutarConsulta($consulta);
	}
	
	public function validarRegistroProduccionDiaria($arrayParametros)
	{
	    $consulta = "
                    SELECT
                            *
                    FROM
                            g_emision_certificacion_origen.registro_produccion rp INNER JOIN 
                            g_emision_certificacion_origen.productos p ON rp.id_registro_produccion = p.id_registro_produccion 
                    WHERE
                            rp.identificador_operador ='".$arrayParametros['identificador_operador']."'
                            and trim(p.tipo_especie) = trim('".$arrayParametros['tipo_especie']."')
                            and p.fecha_faenamiento = '".$arrayParametros['fecha_faenamiento']."'
							and rp.id_sitio = ".$arrayParametros['id_sitio']."
							and rp.id_area = ".$arrayParametros['id_area']."";
	    return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);
	}

	public function obtenerDatosCentroFaenamiento ($idRegistroProduccion,$admin){
		if ($admin){
			$param = "s";
		}else{
			$param = "rp";
		}
		$consulta = "
					SELECT 
						s.provincia,
	  					s.nombre_lugar,
	   					a.nombre_area,
	   					".$param.".identificador_operador ||'.'||s.codigo_provincia||''||s.codigo||''||a.codigo||''||a.secuencial as codigo
   					FROM 
   						g_emision_certificacion_origen.registro_produccion rp
						INNER JOIN g_operadores.sitios s ON s.id_sitio = rp.id_sitio
	   					INNER JOIN g_operadores.areas a ON a.id_area = rp.id_area
	   					INNER JOIN g_emision_certificacion_origen.productos p ON p.id_registro_produccion = rp.id_registro_produccion
   					WHERE
	  					rp.id_registro_produccion = ".$idRegistroProduccion."";
		return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);
	}

	public function listarRegistroProduccionPorEspecie($arrayParametros)
	{	   
	  $consulta = "SELECT rp.id_registro_produccion,fecha_faenamiento,rp.id_registro_produccion,sit.nombre_lugar, 
				fecha_recepcion, tipo_especie, num_canales_obtenidos,num_canales_obtenidos_uso, 
				num_canales_uso_industri,num_animales_recibidos, codigo_canal, 
				string_agg(distinct s.subproducto,', ') as subproducto, p.id_productos , rp.id_sitio, to_char( p.fecha_creacion, 'yyyy-MM-dd HH24:MI:SS') as fecha_creacion
				FROM g_emision_certificacion_origen.registro_produccion rp 
				INNER JOIN g_emision_certificacion_origen.productos p ON rp.id_registro_produccion = p.id_registro_produccion 
				LEFT JOIN g_emision_certificacion_origen.subproductos S ON s.id_productos = p.id_productos
				INNER JOIN g_operadores.sitios sit ON sit.id_sitio = rp.id_sitio
				WHERE 
						rp.identificador_operador ='".$arrayParametros['identificador_operador']."' 
						and tipo_especie ilike ('%".$arrayParametros['tipo_especie']."%') and fecha_faenamiento ='".$arrayParametros['fecha_faenamiento']."' 
						and rp.id_sitio = ".$arrayParametros['id_sitio']." and rp.id_area = ".$arrayParametros['id_area']."
						GROUP BY rp.id_registro_produccion,fecha_recepcion, tipo_especie,num_canales_obtenidos,num_canales_obtenidos_uso,
						num_canales_uso_industri,num_animales_recibidos, codigo_canal,  rp.id_registro_produccion,p.id_productos,fecha_faenamiento,sit.nombre_lugar order by 1 DESC;";

	    return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);
	}

	public function listarRegistroProduccionPorSubproducto($arrayParametros)
	{	
		if ($arrayParametros['tipo_especie'] == "Bovinos"){
			$condicion = "fecha_faenamiento";
		}else{
			$condicion = "fecha_recepcion";
		} 	
	    $consulta = "SELECT
					rp.id_registro_produccion, fecha_recepcion, tipo_especie, num_canales_obtenidos,num_canales_obtenidos_uso,
					num_canales_uso_industri,num_animales_recibidos, codigo_canal, 
					p.id_productos, to_char( p.fecha_creacion, 'yyyy-MM-dd HH24:MI:SS') as fecha_creacion
				FROM
					g_emision_certificacion_origen.registro_produccion rp INNER JOIN g_emision_certificacion_origen.productos p
					ON rp.id_registro_produccion = p.id_registro_produccion INNER JOIN g_emision_certificacion_origen.subproductos S
					ON s.id_productos = p.id_productos
				WHERE
					rp.identificador_operador ='".$arrayParametros['identificador_operador']."'
					and tipo_especie ilike ('%".$arrayParametros['tipo_especie']."%')
					and ".$condicion." = '".$arrayParametros['fecha_produccion']."'
					GROUP BY rp.id_registro_produccion,fecha_recepcion, tipo_especie,num_canales_obtenidos,num_canales_obtenidos_uso,
					num_canales_uso_industri,num_animales_recibidos, codigo_canal,  rp.id_registro_produccion,p.id_productos order by 1 DESC;";
				
	    return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);
	}
	public function buscarProduccionSitioPorCentroFaenamiento($arrayParametros)
	{	   
	    $consulta = "SELECT * 
					FROM g_emision_certificacion_origen.registro_produccion r
					inner join g_emision_certificacion_origen.productos p
					on r.id_registro_produccion = p.id_registro_produccion
					WHERE identificador_operador ='".$arrayParametros['ruc']."'
					and to_char( r.fecha_creacion, 'YYYY-MM-DD') = '".date('Y-m-d')."'
					and r.id_sitio =".$arrayParametros['id_sitio']." 
					and r.id_area = ".$arrayParametros['id_area']." 
					and p.tipo_especie = '".$arrayParametros['tipo_especie']."';";
				
	    return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);
	}
	

	public function obtenerPorductoCentroFaenamiento($arrayParametros){
		$consulta = "SELECT id_productos, num_canales_obtenidos, num_canales_obtenidos_uso, num_canales_uso_industri,  tipo_especie, num_animales_recibidos,  codigo_canal, fecha_creacion
		FROM g_emision_certificacion_origen.productos
		where id_registro_produccion =". $arrayParametros['id_registro_produccion'] ."and tipo_especie = '".$arrayParametros['tipo_especie']."';";
		return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);
	}

	public function actualizarTablaProductosCentroFaenamiento($arrayParametros){

		$consulta = "UPDATE g_emision_certificacion_origen.productos
		SET num_canales_obtenidos=".$arrayParametros['num_canales_obtenidos'].", num_canales_obtenidos_uso=".$arrayParametros['num_canales_obtenidos_uso'].", 
		num_canales_uso_industri=".$arrayParametros['num_canales_uso_industri'].",  num_animales_recibidos=".$arrayParametros['num_animales_recibidos']."
		where id_productos =". $arrayParametros['id_productos'] ."and tipo_especie = '".$arrayParametros['tipo_especie']."';";
		return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);


	}

	public function ingresarTablaHistorialProductosCentroFaenamiento($arrayParametros){

		$consulta = "INSERT INTO g_emision_certificacion_origen.historial_productos(
			id_productos, id_registro_produccion, num_canales_obtenidos, num_canales_obtenidos_uso,
			num_canales_uso_industri, fecha_creacion, tipo_especie, num_animales_recibidos,  
			codigo_canal, identificador_tecnico)
			VALUES (".$arrayParametros['id_productos'].",".$arrayParametros['id_registro_produccion'].",".$arrayParametros['num_canales_obtenidos'].",".$arrayParametros['num_canales_obtenidos_uso'].",
			        ".$arrayParametros['num_canales_uso_industri'].",'".$arrayParametros['fecha_creacion']."','".$arrayParametros['tipo_especie']."',".$arrayParametros['num_animales_recibidos'].",
					'".$arrayParametros['codigo_canal']."','".$arrayParametros['identificador_tecnico']."');";
		return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);
	}

	public function obtenerSubPrductoCentroFaenamiento($datos){
		$consulta = "SELECT id_productos, subproducto,cantidad
		FROM g_emision_certificacion_origen.subproductos
		where id_productos = ".$datos['id_productos']." and subproducto = '".$datos['subproducto']."';";
		return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);
	}

	public function actualizarTablaSubproductosCentroFaenamiento($cantidad){

		$consulta = "UPDATE g_emision_certificacion_origen.subproductos
					SET  cantidad=".$cantidad['cantidad']."
					WHERE id_productos = ".$cantidad['id_productos']." and subproducto='".$cantidad['subproducto']."';";
		return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);
	}

	public function insertarTablaHistorialSubproductosCentroFaenamiento($datosInsertar){

		$consulta = "INSERT INTO g_emision_certificacion_origen.historial_subproductos(
			id_productos, subproducto, cantidad, identificador_tecnico)
			VALUES (".$datosInsertar['id_productos'].", '".$datosInsertar['subproducto']."', ".$datosInsertar['cantidad'].", '".$datosInsertar['identificador_tecnico']."');";
		return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);
	}

	public function insertarTablaSubproductosCentroFaenamiento($arrayParametros){

		$consulta = "INSERT INTO g_emision_certificacion_origen.subproductos(
			id_productos, subproducto, cantidad)
			VALUES (".$arrayParametros['id_productos'].", '".$arrayParametros['subproducto']."', ".$arrayParametros['cantidad'].");";
		return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);
	}
	
	public function actualizarTablaRegistroProduccionCentroFaenamiento($arrayParametros){

		$consulta = "UPDATE g_emision_certificacion_origen.registro_produccion
		SET  identificador_tecnico='".$arrayParametros['identificador_tecnico']."'
		WHERE id_registro_produccion = ".$arrayParametros['id_registro_produccion'].";";
		return $this->modeloRegistroProduccion->ejecutarSqlNativo($consulta);
	}

	
}
