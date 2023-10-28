<?php
/**
 * Lógica del negocio de OperacionesModelo
 *
 * Este archivo se complementa con el archivo OperacionesControlador.
 *
 * @author AGROCALIDAD
 * @date    2019-06-06
 * @uses OperacionesLogicaNegocio
 * @package RegistroOperador
 * @subpackage Modelos
 */
namespace Agrodb\RegistroOperador\Modelos;

use Agrodb\RegistroOperador\Modelos\IModelo;
use Agrodb\RevisionFormularios\Modelos\AsignacionInspectorLogicaNegocio;

class OperacionesLogicaNegocio implements IModelo{

    private $modeloOperaciones = null;
    
    private $lNegocioAsignacionInspector = null;

	/**
	 * Constructor
	 *
	 * @retorna void
	 */
	public function __construct(){
	    $this->modeloOperaciones = new OperacionesModelo();
	    $this->lNegocioAsignacionInspector = new AsignacionInspectorLogicaNegocio();
	}

	/**
	 * Guarda el registro actual
	 *
	 * @param array $datos
	 * @return int
	 */
	public function guardar(Array $datos){
		$tablaModelo = new OperacionesModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdOperacion() != null && $tablaModelo->getIdOperacion() > 0){
			return $this->modeloOperaciones->actualizar($datosBd, $tablaModelo->getIdOperacion());
		}else{
			unset($datosBd["id_operacion"]);
			return $this->modeloOperaciones->guardar($datosBd);
		}
	}
	
	public function guardarResultado(Array $datos, Array $resultado){
		try{
			$this->modeloOperaciones = new OperacionesModelo();
			$proceso = $this->modeloOperaciones->getAdapter()
				->getDriver()
				->getConnection();
			if (! $proceso->beginTransaction()){
				throw new \Exception('No se pudo iniciar la transacción: Guardar operaciones');
			}
			$tablaModelo = new OperacionesModelo($datos);
			$datosBd = $tablaModelo->getPrepararDatos();
			if ($tablaModelo->getIdOperacion() != null && $tablaModelo->getIdOperacion() > 0){
				$this->modeloOperaciones->actualizar($datosBd, $tablaModelo->getIdOperacion());
				$idRegistro = $tablaModelo->getIdOperacion();
			}
			if (! $idRegistro){
				throw new \Exception('No se registo los datos en la tabla productos_areas_operacion');
			}
			
			$arrayProdAreaOpe = array(
				'estado' => $datos['estado'],
				'observacion' => $datos['observacion']);
			$statement = $this->modeloOperaciones->getAdapter()
				->getDriver()
				->createStatement();
			$sqlActualizar = $this->modeloOperaciones->actualizarSql('productos_areas_operacion', $this->modeloOperaciones->getEsquema());
			$sqlActualizar->set($arrayProdAreaOpe);
			$sqlActualizar->where(array(
				'id_operacion' => $idRegistro));
			$sqlActualizar->prepareStatement($this->modeloOperaciones->getAdapter(), $statement);
			$statement->execute();		
			
			$this->lNegocioAsignacionInspector->guardar($resultado);
						
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
	 *
	 * @param
	 *        	string Where|array $where
	 * @return int
	 */
	public function borrar($id){
		$this->modeloOperaciones->borrar($id);
	}

	/**
	 *
	 * Buscar un registro de con la clave primaria
	 *
	 * @param int $id
	 * @return OperacionesModelo
	 */
	public function buscar($id){
		return $this->modeloOperaciones->buscar($id);
	}

	/**
	 * Busca todos los registros
	 *
	 * @return array|ResultSet
	 */
	public function buscarTodo(){
		return $this->modeloOperaciones->buscarTodo();
	}

	/**
	 * Busca una lista de acuerdo a los parámetros <params> enviados.
	 *
	 * @return array|ResultSet
	 */
	public function buscarLista($where = null, $order = null, $count = null, $offset = null){
		return $this->modeloOperaciones->buscarLista($where, $order, $count, $offset);
	}

	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 *
	 * @return array|ResultSet
	 */
	public function buscarOperaciones(){
		$consulta = "SELECT * FROM " . $this->modeloOperaciones->getEsquema() . ". operaciones";
		return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
	}
	
	/**
	 */
	public function obtenerOperacionesOperador($arrayParametros){
		$busqueda = '';
		if (array_key_exists('identificador_operador', $arrayParametros)){
			if ($arrayParametros['identificador_operador'] != ''){
				$busqueda .= " and s.identificador_operador  = '" . $arrayParametros['identificador_operador'] . "'";
			}
		}
		if (array_key_exists('razon_social', $arrayParametros)){
			if ($arrayParametros['razon_social'] != ''){
				$busqueda .= " and upper(o.razon_social)  = upper('" . $arrayParametros['razon_social'] . "')";
			}
		}
		if (array_key_exists('codigo', $arrayParametros)){
			if ($arrayParametros['codigo'] != ''){
				$busqueda .= " and upper(t.codigo)  = upper('" . $arrayParametros['codigo'] . "')";
			}
		}
		if (array_key_exists('id_area', $arrayParametros)){
			$busqueda .= " and t.id_area = '" . $arrayParametros['id_area'] . "'";
		}

		$consulta = " select
								distinct min(s.id_operacion) as id_operacion,
								s.identificador_operador,
								s.estado,
								s.id_tipo_operacion,
								t.nombre as nombre_tipo_operacion,
								st.provincia,
								st.id_sitio,
								st.nombre_lugar,
                                t.codigo
							from
								g_operadores.operaciones s,
								g_catalogos.tipos_operacion t,
								g_operadores.operadores o,
								g_operadores.productos_areas_operacion sa,
								g_operadores.areas a,
								g_operadores.sitios st,
								g_operadores.flujos_operaciones fo
							where
								s.id_tipo_operacion = t.id_tipo_operacion and
								s.identificador_operador = o.identificador and
								s.id_operacion = sa.id_operacion and
								sa.id_area = a.id_area and
								a.id_sitio = st.id_sitio and
								s.estado " . $arrayParametros['estado'] . " and
								t.id_flujo_operacion = fo.id_flujo and 
                                upper(st.provincia) = upper('" . $arrayParametros['provincia'] . "')
                                " . $busqueda . "
							group by s.identificador_operador, s.estado, s.id_tipo_operacion, nombre_tipo_operacion, st.provincia, st.id_sitio, a.id_area, t.codigo
							order by id_operacion;";
		return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
	}
	
	public function buscarNombreAreaPorSitioPorTipoOperacion($arrayParametros){
		$consulta = "SELECT array_to_string(ARRAY(
													SELECT
														distinct a.nombre_area
													FROM
														g_operadores.areas a INNER JOIN g_operadores.productos_areas_operacion pao ON a.id_area = pao.id_area
														INNER JOIN g_operadores.operaciones o ON pao.id_operacion = o.id_operacion
													WHERE
                                                        a.id_sitio = " . $arrayParametros['idSitio'] . " and o.id_tipo_operacion = " . $arrayParametros['idTipoOperacion'] . "
													),', ') as nombre_area;";

		return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
	}
	
	/**
	 * obtener informacion del operador
	 *
	 * @param string $identificador
	 */
	public function obtenerOperador($identificador){
		$consulta = "
                        SELECT row_to_json (operador)
                        FROM (
                            SELECT
                                o1.* ,
                                (
                                    SELECT array_to_json(array_agg(row_to_json(operaciones_n2)))
                                    FROM (
                                            select
                                                distinct on(topc2.id_area, topc2.nombre) topc2.*
                                            from
                                                g_operadores.operadores opr2
                                                , g_operadores.operaciones opc2
                                                , g_catalogos.tipos_operacion topc2
                                            where
                                                opr2.identificador = opc2.identificador_operador
                                                and opc2.id_tipo_operacion = topc2.id_tipo_operacion
                                                and opr2.identificador = o1.identificador
                                            order by
                                                topc2.id_area, topc2.nombre ) operaciones_n2
                                ) operaciones
                            FROM
                                g_operadores.operadores o1
                            WHERE
                                o1.identificador = '$identificador'
                        ) as operador";

		return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
	}
	
	public function abrirOperacion($arrayParametros){
		$consulta = "select
							o.id_operacion,
							o.id_tipo_operacion,
							o.identificador_operador,
							o.id_producto,
							o.nombre_producto,
							o.estado,
							o.id_producto,
							o.nombre_producto,
							o.observacion,
							o.nombre_pais,
							o.fecha_aprobacion,
							o.fecha_finalizacion,
							o.id_operador_tipo_operacion,
							o.id_historial_operacion,
							t.nombre,
							t.id_area as codigo_area,
							t.codigo as codigo_tipo_operacion,
							a.nombre_area as area,
							a.tipo_area,
							a.superficie_utilizada,
							ss.provincia,
							ss.canton,
							ss.parroquia,
							ss.id_sitio,
							ss.nombre_lugar as sitio,
							ss.direccion,
							ss.referencia,
							ss.croquis,
							pao.estado as estado_area,
							pao.ruta_archivo,
							pao.id_area,
							pao.observacion as observacion_area,
							ss.identificador_operador||'.'||ss.codigo_provincia || ss.codigo || a.codigo||a.secuencial as codificacion_area
						from
							g_operadores.operaciones o,
							g_operadores.productos_areas_operacion pao,
							g_operadores.areas a,
							g_catalogos.tipos_operacion t,
							g_operadores.sitios ss
						where
							o.identificador_operador = '" . $arrayParametros['identificadorOperador'] . "' and
							o.id_operacion = " . $arrayParametros['idOperacion'] . " and
							o.id_operacion = pao.id_operacion and
							pao.id_area = a.id_area and
							o.id_operacion = pao.id_operacion and
							o.id_tipo_operacion = t.id_tipo_operacion and
							a.id_sitio = ss.id_sitio
						order by
							o.id_producto;";
		return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
	}
	
    public function buscarOperacionEspecificaEnSitio($arrayParametros)
    {
        $consulta = "select
							o.id_operacion,
							o.id_tipo_operacion,
							o.identificador_operador,
							o.estado,
                            t.nombre,
							t.id_area as codigo_area,
							t.codigo as codigo_tipo_operacion,
                            a.id_area,
							a.nombre_area as area,
							a.tipo_area							
						from
							g_operadores.operaciones o,
							g_operadores.productos_areas_operacion pao,
							g_operadores.areas a,
							g_catalogos.tipos_operacion t,
							g_operadores.sitios ss
						where
							o.identificador_operador = '" . $arrayParametros['identificadorOperador'] . "' and
							t.codigo in ( " . $arrayParametros['codigoOperacion'] . " ) and
							o.id_operacion = pao.id_operacion and
							pao.id_area = a.id_area and
							o.id_operacion = pao.id_operacion and
							o.id_tipo_operacion = t.id_tipo_operacion and
							a.id_sitio = ss.id_sitio and
                            t.estado=1 and
							ss.id_sitio = " . $arrayParametros['idSitio'] . " and
							o.estado = " . $arrayParametros['estado'] . ";";
        
        //echo $consulta;
        return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
    }
	
	/**
	 */
	public function listarDatosVehiculoXIdAreaXidTipoOperacion($arrayParametros){
		$consulta = "SELECT
                        nombre_marca_vehiculo as marca,
                        nombre_modelo_vehiculo  as modelo,
                        nombre_tipo_vehiculo as tipoVehiculo,
                        nombre_color_vehiculo as colorVehiculo,
                        nombre_clase_vehiculo as clase,
                        placa_vehiculo,
                        anio_vehiculo,
                        capacidad_vehiculo,
                        codigo_unidad_medida
					FROM
						g_operadores.datos_vehiculos
					WHERE
						id_area = " . $arrayParametros['id_area'] . " and
						id_tipo_operacion = " . $arrayParametros['id_tipo_operacion'] . " and
						id_operador_tipo_operacion = " . $arrayParametros['id_operador_tipo_operacion'] . " and
						estado_dato_vehiculo = '" . $arrayParametros['estado'] . "'
						and id_dato_vehiculo = (SELECT
													max(id_dato_vehiculo)
												FROM
													g_operadores.datos_vehiculos
												WHERE
													id_area = " . $arrayParametros['id_area'] . " and
													id_tipo_operacion = " . $arrayParametros['id_tipo_operacion'] . " and
													id_operador_tipo_operacion = " . $arrayParametros['id_operador_tipo_operacion'] . " and
													estado_dato_vehiculo = '" . $arrayParametros['estado'] . "');";

		return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
	}
	
	/**
	 */
	public function obtenerAreaXIdOperacion($idOperacion){
		$consulta = "SELECT
			        	pao.id_area
			        FROM
				        g_operadores.operaciones op,
				        g_operadores.productos_areas_operacion pao
			        WHERE
				        op.id_operacion=pao.id_operacion
				        and op.id_operacion=" . $idOperacion . ";";
		return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
	}
	
	public function obtenerProductosPorIdOperadorTipoOperacionHistorico($arrayParametros){
		$consulta = "SELECT
						o.id_operacion, p.id_producto, nombre_comun, sp.nombre as nombre_subtipo, 
                        codificacion_subtipo_producto, tp.nombre as nombre_tipo, o.estado
					FROM
						g_operadores.operaciones o,
						g_catalogos.productos p,
						g_catalogos.subtipo_productos sp,
						g_catalogos.tipo_productos tp
					WHERE
						o.id_producto = p.id_producto
						and p.id_subtipo_producto = sp.id_subtipo_producto
						and sp.id_tipo_producto = tp.id_tipo_producto
						and id_operador_tipo_operacion in (" . $arrayParametros['id_operador_tipo_operacion'] . ")
						and id_historial_operacion in (" . $arrayParametros['id_historial_operacion'] . ")
                        and o.estado = '" . $arrayParametros['estado'] . "'
                        ;";

		return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
	}
	
	public function variedadesXOperacionesXProductos($idOperacion){
		$consulta = "SELECT
								       				v.nombre
								       			FROM
								       				g_operadores.operaciones_variedades ov,
								       				g_catalogos.variedades v,
								       				g_operadores.operaciones ope
								       			WHERE
								       				ov.id_operacion=ope.id_operacion and
								       				ov.id_variedad=v.id_variedad and
								       				ope.id_operacion='$idOperacion'
								       				order by 1";
		return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
	}

	public function obtenerTipoOperacionesPorIdentificadorProvincia($arrayParametros){
		$consulta = "SELECT
						distinct top.nombre, 
						top.id_tipo_operacion, 
						top.id_area,
						array_to_string(array_agg(distinct s.provincia), ', ') as nombre_provincia
					FROM
						g_operadores.sitios s
						INNER JOIN g_operadores.areas a ON s.id_sitio = a.id_sitio
						INNER JOIN g_operadores.productos_areas_operacion pao ON a.id_area = pao.id_area
						INNER JOIN g_operadores.operaciones op ON pao.id_operacion = op.id_operacion
						INNER JOIN g_catalogos.tipos_operacion top ON op.id_tipo_operacion = top.id_tipo_operacion
						INNER JOIN g_estructura.area ar ON top.id_area = ar.id_area
					WHERE
						op.identificador_operador = '" . $arrayParametros['identificador_operador'] . "'
						" . ($arrayParametros['nombre_provincia'] != '--' ? " and s.provincia ilike '%" . $arrayParametros['nombre_provincia'] . "%'" : "") . "
					GROUP BY 
						1, 2, 3
					ORDER BY
						top.nombre;";

		$tipoOperaciones = $this->modeloOperaciones->ejecutarSqlNativo($consulta);

		$arrayTipoOperacion = array();

		foreach ($tipoOperaciones as $tipoOperacion){

			switch ($tipoOperacion->id_area) {
				case 'SV':
					$codigoArea = strtolower($tipoOperacion->id_area);
					$nombreArea = 'Sanidad Vegetal';
				break;
				case 'SA':
					$codigoArea = strtolower($tipoOperacion->id_area);
					$nombreArea = 'Sanidad Animal';
				break;
				case 'IAV':
					$codigoArea = 'ria';
					$nombreArea = 'Registro de Insumos Pecuarios';
				break;
				case 'IAP':
					$codigoArea = 'ria';
					$nombreArea = 'Registro de Insumos Agrícolas';
				break;
				case 'IAF':
					$codigoArea = 'ria';
					$nombreArea = 'Registro de insumos fertilzantes';
				break;
				case 'CGRIA':
					$codigoArea = 'ria';
					$nombreArea = 'Coordinación de registros de insumos agropecuarios';
				break;
				case 'AI':
					$codigoArea = strtolower($tipoOperacion->id_area);
					$nombreArea = 'Inocuidad de los alimentos';
				break;
				case 'LT':
					$codigoArea = strtolower($tipoOperacion->id_area);
					$nombreArea = 'Laboratorios Tumbaco';
				break;
			}

			$arrayTipoOperacion[] = array(
				'operacion' => $tipoOperacion->nombre,
				'area' => $nombreArea,
				'areacod' => $codigoArea,
				'provincia' => $tipoOperacion->nombre_provincia);
		}

		return $arrayTipoOperacion;
	}
	
	public function buscarOperacionesProveedoresOperadorProducto ($arrayParametros){
		
		$consulta = "SELECT
						op.identificador_operador,
						op.id_tipo_operacion,
						op.estado,
						op.id_producto,
						top.nombre
					FROM
						g_operadores.proveedores pr,
						g_operadores.operaciones op,
						g_catalogos.tipos_operacion top
					WHERE
						pr.identificador_operador = '".$arrayParametros['identificador_operador']."'
						and pr.codigo_proveedor = op.identificador_operador
						and op.id_tipo_operacion = top.id_tipo_operacion
						and pr.id_producto = op.id_producto
						and top.nombre not in ('Exportador', 'Importador')
						and pr.id_producto = ".$arrayParametros['id_producto']."
						and op.estado IN ".$arrayParametros['estado'].";";
		
		return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
	}
	
	/**
	 * obtener tipo de operaciones registradas
	 */
	public function obtenerTipoOperacionesOperador($arrayParametros){
		$busqueda = '';

		if (array_key_exists('identificador_operador', $arrayParametros)){
			if ($arrayParametros['identificador_operador'] != ''){
				$busqueda .= " and op.identificador_operador  = '" . $arrayParametros['identificador_operador'] . "'";
			}
		}
		if (array_key_exists('razon_social', $arrayParametros)){
			if ($arrayParametros['razon_social'] != ''){
				$busqueda .= " and upper(o.razon_social)  = upper('" . $arrayParametros['razon_social'] . "')";
			}
		}
		if (array_key_exists('id_area', $arrayParametros)){
			$busqueda .= " and top.id_area = '" . $arrayParametros['id_area'] . "'";
		}

		$consulta = " 
                    SELECT 
                        top.nombre as operaciones_registradas, top.codigo
                    FROM 
                        g_operadores.sitios s
                        INNER JOIN g_operadores.areas a ON s.id_sitio = a.id_sitio
                        INNER JOIN g_operadores.productos_areas_operacion pao ON a.id_area = pao.id_area
                        INNER JOIN g_operadores.operaciones op ON pao.id_operacion = op.id_operacion
                        INNER JOIN g_operadores.operadores o ON op.identificador_operador = o.identificador
                        INNER JOIN g_catalogos.tipos_operacion top ON op.id_tipo_operacion = top.id_tipo_operacion
                    WHERE
                        op.estado " . $arrayParametros['estado'] . " and 
						permite_desplegar_administracion_operacion = 'true' and
                        upper(s.provincia) = upper('" . $arrayParametros['provincia'] . "')  
                        " . $busqueda . "
                    GROUP BY 1,2
								;";
		return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
	}
	
	public function buscarOperacionSitioOperador($arrayParametros)
    {
        $consulta = "SELECT
                        	distinct o.identificador_operador,
                        	op.razon_social,
                        	s.nombre_lugar,
                        	o.id_operador_tipo_operacion,
                            s.provincia
                        FROM
                        	g_operadores.operaciones o
                        	INNER JOIN g_operadores.operadores op ON o.identificador_operador = op.identificador
                        	INNER JOIN g_operadores.productos_areas_operacion pao ON o.id_operacion = pao.id_operacion
                        	INNER JOIN g_operadores.areas a ON a.id_area = pao.id_area
                        	INNER JOIN g_operadores.sitios s ON s.id_sitio = a.id_sitio
                        	INNER JOIN g_catalogos.tipos_operacion tp ON o.id_tipo_operacion = tp.id_tipo_operacion
                        WHERE
                        	tp.codigo in ('" . $arrayParametros['codigo_operacion'] . "') and
                        	tp.id_area in ('" . $arrayParametros['id_area'] . "') and
                        	o.identificador_operador = '" . $arrayParametros['identificador_operador'] . "' and
                        	o.estado = 'registrado'
                        LIMIT 1;";

        return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     * Busca las provincias en donde se tiene operaciones de un tipo especificado registradas
     *
     * @return array|ResultSet
     */
    public function comboProvinciaXOperacionesRegistradas($tipoOperacion)
    {
        $consulta = "   SELECT 
                        	distinct s.provincia,
                        	(SELECT l.id_localizacion from g_catalogos.localizacion l WHERE l.nombre = s.provincia and l.categoria=1) as id_provincia
                        FROM g_operadores.operaciones o
                            INNER JOIN g_catalogos.tipos_operacion tp on tp.id_tipo_operacion = o.id_tipo_operacion
                            INNER JOIN g_operadores.productos_areas_operacion pao on pao.id_operacion = o.id_operacion
                            INNER JOIN g_operadores.areas a ON pao.id_area = a.id_area
                            INNER JOIN g_operadores.sitios s ON a.id_sitio = s.id_sitio
                        WHERE
                            o.estado='registrado' and
                            tp.codigo in ($tipoOperacion);";

        return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
    }
	
	public function inactivarVehiculo($idOperadorTipoOperacion,$estadoNuevo,$estadoActual,$placaVehiculo){
	   
		   $consulta= "UPDATE 
							g_operadores.datos_vehiculos
						SET 
							estado_dato_vehiculo = '$estadoNuevo'												
						WHERE 
							id_dato_vehiculo = (SELECT 
													MAX(id_dato_vehiculo) 
												FROM 
													g_operadores.datos_vehiculos 
												WHERE 
													placa_vehiculo = '$placaVehiculo') 
													and estado_dato_vehiculo = '$estadoActual' 
													and id_operador_tipo_operacion = $idOperadorTipoOperacion;";
			return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
	}
	
	public function buscarOperacionPorTipoOperacionArea($arrayParametros){
        $consulta = "SELECT
                        	distinct o.identificador_operador,
                        	op.razon_social,
                        	op.nombre_representante,
                        	op.apellido_representante
                        FROM
                        	g_operadores.operaciones o
                        	INNER JOIN g_operadores.operadores op ON o.identificador_operador = op.identificador
                        	INNER JOIN g_catalogos.tipos_operacion tp ON o.id_tipo_operacion = tp.id_tipo_operacion
                        WHERE
                        	tp.codigo in (" . $arrayParametros['codigo_operacion'] . ") and
                        	tp.id_area in (" . $arrayParametros['id_area'] . ") and
                        	o.estado = 'registrado'
                        ORDER BY razon_social;";

        return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
    }
	
		public function buscarOperacionPorCodigoAreaPorTipoOperacion($arrayParametros)
	{
	    
	    $tipoLugarInspeccion = $arrayParametros['tipo_lugar_inspeccion'];
	    $codigoLugarInspeccion = $arrayParametros['codigo_lugar_inspeccion'];
	    
	    $consulta = "SELECT 
                    	DISTINCT 
                        a.id_area
                        , op.id_producto
                        , op.id_tipo_operacion
                        , o.identificador as identificador_operador
                    	, CASE WHEN o.razon_social = '' THEN o.nombre_representante ||' '|| o.apellido_representante ELSE o.razon_social end nombre_operador
                    	, s.id_sitio
                    	, s.nombre_lugar as nombre_sitio
                        , s.direccion || '-' || s.referencia as direccion
                    	, s.provincia || '/' || s.canton as nombre_provincia_canton
						, s.latitud
                        , s.longitud
                    	, a.id_area
                    	, a.nombre_area
                    	, s.identificador_operador || '.' || s.codigo_provincia || s.codigo || a.codigo || a.secuencial as codigo_area
                    	, top.nombre
                    FROM 
                    	g_operadores.sitios s
                    	INNER JOIN g_operadores.areas a ON a.id_sitio = s.id_sitio
                    	INNER JOIN g_operadores.productos_areas_operacion pao ON pao.id_area = a.id_area
                    	INNER JOIN g_operadores.operaciones op ON pao.id_operacion = op.id_operacion
                    	INNER JOIN g_catalogos.tipos_operacion top ON top.id_tipo_operacion = op.id_tipo_operacion
                        INNER JOIN g_operadores.operadores o ON o.identificador = op.identificador_operador
                    WHERE 
                    	s.identificador_operador||'.'||s.codigo_provincia || s.codigo ||a.codigo||a.secuencial = '" . $codigoLugarInspeccion . "'
                    	and top.id_area || top.codigo in " . $tipoLugarInspeccion . "
                        and op.estado NOT IN ('noHabilitado');";
	    
	    return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
	}
	
	public function buscarDatosSitioAreaPorCodigoArea($arrayParametros)
	{
	    
	    $codigoLugarInspeccion = $arrayParametros['codigo_lugar_inspeccion'];
	    
	    $consulta = "SELECT
                    	DISTINCT
                    	a.id_area
                    	, a.nombre_area
                        , s.direccion || '-' || s.referencia as direccion_area
                    	, s.identificador_operador || '.' || s.codigo_provincia || s.codigo || a.codigo || a.secuencial as codigo_area
                    	, s.codigo_provincia as id_provincia_area
                    	, s.provincia as nombre_provincia_area                    	
                    FROM
                    	g_operadores.sitios s
                    	INNER JOIN g_operadores.areas a ON a.id_sitio = s.id_sitio
                    	INNER JOIN g_operadores.productos_areas_operacion pao ON pao.id_area = a.id_area
                    WHERE
                    	s.identificador_operador||'.'||s.codigo_provincia || s.codigo ||a.codigo||a.secuencial = '" . $codigoLugarInspeccion . "';";
	    
	    return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
	}
	
	public function obtenerOperadoresPorTipoOperacionPorIdProductoPorEstado($datosOperadorProducto)
	{
		
		$identificadorOperador = $datosOperadorProducto['identificador_operador'];
		$tipoOperacion = $datosOperadorProducto['tipo_operacion'];
		$idProducto = $datosOperadorProducto['id_producto'];
		$estado = $datosOperadorProducto['estado'];
		
		$consulta = "SELECT * FROM (SELECT
						o.identificador as identificador_operador
                    	, CASE WHEN o.razon_social = '' THEN o.nombre_representante ||' '|| o.apellido_representante ELSE o.razon_social END nombre_operador
                    	, o.direccion as direccion_operador
						, array_agg(DISTINCT (op.id_producto)) as producto
					FROM
					g_operadores.operadores o
					INNER JOIN g_operadores.operaciones op ON op.identificador_operador = o.identificador
					INNER JOIN g_catalogos.tipos_operacion top ON top.id_tipo_operacion = op.id_tipo_operacion 
					WHERE						 
						o.identificador = '" . $identificadorOperador . "'
						and top.id_area || top.codigo = '" . $tipoOperacion . "'
						and op.id_producto IN (" . $idProducto . ")
						and op.estado = '" . $estado . "'
					GROUP BY o.identificador,
						nombre_operador,
						o.direccion)t1
						WHERE t1.producto @> ('{" . $idProducto . "}');";
		
		return $this->modeloOperaciones->ejecutarSqlNativo($consulta);
	}
	
}
