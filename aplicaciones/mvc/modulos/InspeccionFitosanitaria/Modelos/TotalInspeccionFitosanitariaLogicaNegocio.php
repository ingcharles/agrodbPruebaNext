<?php
/**
 * Lógica del negocio de TotalInspeccionFitosanitariaModelo
 *
 * Este archivo se complementa con el archivo TotalInspeccionFitosanitariaControlador.
 *
 * @author AGROCALIDAD
 * @date    2022-07-21
 * @uses TotalInspeccionFitosanitariaLogicaNegocio
 * @package InspeccionFitosanitaria
 * @subpackage Modelos
 */
namespace Agrodb\InspeccionFitosanitaria\Modelos;

use Agrodb\InspeccionFitosanitaria\Modelos\IModelo;

class TotalInspeccionFitosanitariaLogicaNegocio implements IModelo{

	private $modeloTotalInspeccionFitosanitaria = null;

	/**
	 * Constructor
	 *
	 * @retorna void
	 */
	public function __construct(){
		$this->modeloTotalInspeccionFitosanitaria = new TotalInspeccionFitosanitariaModelo();
	}

	/**
	 * Guarda el registro actual
	 *
	 * @param array $datos
	 * @return int
	 */
	public function guardar(Array $datos){
		$tablaModelo = new TotalInspeccionFitosanitariaModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdTotalInspeccionFitosanitaria() != null && $tablaModelo->getIdTotalInspeccionFitosanitaria() > 0){
			return $this->modeloTotalInspeccionFitosanitaria->actualizar($datosBd, $tablaModelo->getIdTotalInspeccionFitosanitaria());
		}else{
			unset($datosBd["id_total_inspeccion_fitosanitaria"]);
			return $this->modeloTotalInspeccionFitosanitaria->guardar($datosBd);
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
		$this->modeloTotalInspeccionFitosanitaria->borrar($id);
	}

	/**
	 *
	 * Buscar un registro de con la clave primaria
	 *
	 * @param int $id
	 * @return TotalInspeccionFitosanitariaModelo
	 */
	public function buscar($id){
		return $this->modeloTotalInspeccionFitosanitaria->buscar($id);
	}

	/**
	 * Busca todos los registros
	 *
	 * @return array|ResultSet
	 */
	public function buscarTodo(){
		return $this->modeloTotalInspeccionFitosanitaria->buscarTodo();
	}

	/**
	 * Busca una lista de acuerdo a los parámetros <params> enviados.
	 *
	 * @return array|ResultSet
	 */
	public function buscarLista($where = null, $order = null, $count = null, $offset = null){
		return $this->modeloTotalInspeccionFitosanitaria->buscarLista($where, $order, $count, $offset);
	}

	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 *
	 * @return array|ResultSet
	 */
	public function buscarTotalInspeccionFitosanitaria(){
		$consulta = "SELECT * FROM " . $this->modeloTotalInspeccionFitosanitaria->getEsquema() . ". total_inspeccion_fitosanitaria";
		return $this->modeloTotalInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
	}

	/**
	 * Metodo que verifica y obtiene los datos de una solicitud
	 *
	 * @return
	 */
	public function obtenerDatosInspeccionFitosanitariaAprobado($idInspeccionFitosanitaria){
		$consulta = "SELECT
							tif.id_total_inspeccion_fitosanitaria
							, tif.id_inspeccion_fitosanitaria
							, tif.id_subtipo_producto
							, stp.nombre as nombre_subtipo_producto
							, tif.id_producto
							, p.nombre_comun as nombre_producto
							, tif.total_cantidad_aprobada
							, tif.id_unidad_cantidad_producto
							, uf1.codigo_unidad_fitosanitaria as unidad_cantidad_producto
							, tif.total_peso_aprobado
							, tif.id_unidad_peso_producto
							, uf2.codigo_unidad_fitosanitaria as unidad_peso_producto
							, tif.fecha_inspeccion
						FROM
							g_inspeccion_fitosanitaria.total_inspeccion_fitosanitaria tif
							INNER JOIN g_catalogos.productos p ON p.id_producto = tif.id_producto
							INNER JOIN g_catalogos.subtipo_productos stp ON stp.id_subtipo_producto = tif.id_subtipo_producto
							INNER JOIN g_catalogos.unidades_fitosanitarias uf1 ON uf1.id_unidad_fitosanitaria = tif.id_unidad_cantidad_producto
							INNER JOIN g_catalogos.unidades_fitosanitarias uf2 ON uf2.id_unidad_fitosanitaria = tif.id_unidad_peso_producto
						WHERE
							tif.id_inspeccion_fitosanitaria = " . $idInspeccionFitosanitaria . ";";

		return $this->modeloTotalInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
	}
	
	/**
	 * Metodo que verifica y obtiene los datos de una solicitud
	 *
	 * @return
	 */
	public function obtenerDatosTotalInspeccionFitosanitaria($idTotalInspeccionFitosanitaria){
		$consulta = "SELECT
							tif.id_total_inspeccion_fitosanitaria
							, tif.id_inspeccion_fitosanitaria
							, tif.id_subtipo_producto
							, stp.nombre as nombre_subtipo_producto
							, tif.id_producto
							, p.nombre_comun as nombre_producto
							, tif.total_cantidad_aprobada
							, tif.id_unidad_cantidad_producto
							, ufcp.codigo_unidad_fitosanitaria as codigo_unidad_cantidad_producto
							, tif.total_peso_aprobado
							, tif.id_unidad_peso_producto
							, ufpp.codigo_unidad_fitosanitaria as codigo_unidad_peso_producto
							, tif.id_tipo_tratamiento
							, tt.codigo_tipo_tratamiento
							, tif.id_tratamiento
							, t.codigo_tratamiento
							, tif.id_duracion
							, ufd.codigo_unidad_fitosanitaria as codigo_unidad_duracion
							, tif.duracion
							, tif.id_temperatura
							, ute.codigo_unidad_fitosanitaria as codigo_unidad_temperatura
							, tif.temperatura
							, tif.fecha_tratamiento
							, tif.producto_quimico
							, tif.id_concentracion
							, uco.codigo_unidad_fitosanitaria as codigo_unidad_concentracion
							, tif.concentracion
						FROM
							g_inspeccion_fitosanitaria.total_inspeccion_fitosanitaria tif
							INNER JOIN g_catalogos.productos p ON p.id_producto = tif.id_producto
							INNER JOIN g_catalogos.subtipo_productos stp ON stp.id_subtipo_producto = tif.id_subtipo_producto
							INNER JOIN g_catalogos.unidades_fitosanitarias ufcp ON ufcp.id_unidad_fitosanitaria = tif.id_unidad_cantidad_producto
							INNER JOIN g_catalogos.unidades_fitosanitarias ufpp ON ufpp.id_unidad_fitosanitaria = tif.id_unidad_peso_producto
							LEFT JOIN g_catalogos.tipos_tratamiento tt ON tt.id_tipo_tratamiento = tif.id_tipo_tratamiento							
							LEFT JOIN g_catalogos.tratamientos t ON t.id_tratamiento = tif.id_tratamiento
							LEFT JOIN g_catalogos.unidades_fitosanitarias ufd ON ufd.id_unidad_fitosanitaria = tif.id_duracion
							LEFT JOIN g_catalogos.unidades_fitosanitarias ute ON ute.id_unidad_fitosanitaria = tif.id_temperatura
							LEFT JOIN g_catalogos.unidades_fitosanitarias uco ON uco.id_unidad_fitosanitaria = tif.id_concentracion
						WHERE
							tif.id_total_inspeccion_fitosanitaria = " . $idTotalInspeccionFitosanitaria . ";";
		
		return $this->modeloTotalInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
	}
}
