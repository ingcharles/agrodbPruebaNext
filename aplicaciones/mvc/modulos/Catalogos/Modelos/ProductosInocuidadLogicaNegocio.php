<?php
/**
 * Lógica del negocio de ProductosInocuidadModelo
 *
 * Este archivo se complementa con el archivo ProductosInocuidadControlador.
 *
 * @author  AGROCALIDAD
 * @date    2021-07-21
 * @uses    ProductosInocuidadLogicaNegocio
 * @package Catalogos
 * @subpackage Modelos
 */
namespace Agrodb\Catalogos\Modelos;

use Agrodb\Catalogos\Modelos\IModelo;

class ProductosInocuidadLogicaNegocio implements IModelo
{

    private $modeloProductosInocuidad = null;

    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloProductosInocuidad = new ProductosInocuidadModelo();
    }

    /**
     * Guarda el registro actual
     *
     * @param array $datos
     * @return int
     */
    public function guardar(Array $datos)
    {
        $tablaModelo = new ProductosInocuidadModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        
        if ($tablaModelo->getIdProducto() != null && $tablaModelo->getIdProducto() > 0) {
            return $this->modeloProductosInocuidad->actualizar($datosBd, $tablaModelo->getIdProducto());
        } else {
            unset($datosBd["id_producto"]);
            return $this->modeloProductosInocuidad->guardar($datosBd);
        }
    }
    
    /**
     * Guarda el registro actual
     *
     * @param array $datos
     * @return int
     */
    public function guardarProductoRIA(Array $datos, $tipoSolicitud, $codificacionSubtipoProducto)
    {
        if($tipoSolicitud == 'Registro'){
            // Función para creación de número de registro único de Producto RIA
            $numRegistro = $this->generarCodigoProducto($codificacionSubtipoProducto);
            $datos['numero_registro'] = $numRegistro;
        }
        
        $tablaModelo = new ProductosInocuidadModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        
        if($tipoSolicitud == 'Registro'){            
            return $this->modeloProductosInocuidad->guardar($datosBd);
        }else{
            return $this->modeloProductosInocuidad->actualizar($datosBd, $tablaModelo->getIdProducto());
        }
    }

    /**
     * Borra el registro actual
     *
     * @param
     *            string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modeloProductosInocuidad->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return ProductosInocuidadModelo
     */
    public function buscar($id)
    {
        return $this->modeloProductosInocuidad->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloProductosInocuidad->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloProductosInocuidad->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarProductosInocuidad()
    {
        $consulta = "SELECT * FROM " . $this->modeloProductosInocuidad->getEsquema() . ". productos_inocuidad";
        return $this->modeloProductosInocuidad->ejecutarSqlNativo($consulta);
    }

    /**
     * Genera el número de identificación único del producto
     *
     * @return array|ResultSet
     */
    public function generarCodigoProducto($codigoSubtipo)
    {
        $formatoCodigo = "RIP-02-" . $codigoSubtipo . '-';
        $codigoBase = 'RIP-02-' . $codigoSubtipo;
        
        $consulta = "SELECT
						max(split_part(numero_registro, '$formatoCodigo' , 2)) as numero
					FROM
						g_catalogos.productos_inocuidad
					WHERE numero_registro LIKE '$codigoBase%';";

        $codigo = $this->modeloProductosInocuidad->ejecutarSqlNativo($consulta);
        $fila = $codigo->current();

        $idNumRegistro = array(
            'numero' => $fila['numero']
        );

        $incremento = (int)$idNumRegistro['numero'] + 1;
        $idNumRegistro = $formatoCodigo . str_pad($incremento, 5, "0", STR_PAD_LEFT);

        return $idNumRegistro;
    }

    /**
     * Ejecuta una consulta(SQL) personalizada para obtener los tipos de productos que tiene un operador
     * por área temática.
     *
     * @return array|ResultSet
     */
    public function obtenerTipoProductoXOperadorAreaEstado($arrayParametros) {

        $consulta = "   SELECT
                        	distinct tp.id_tipo_producto, tp.nombre, tp.id_area
                        FROM
                        	g_catalogos.productos_inocuidad pi
                        	INNER JOIN g_catalogos.productos p ON p.id_producto = pi.id_producto
                        	INNER JOIN g_catalogos.subtipo_productos sp ON p.id_subtipo_producto = sp.id_subtipo_producto
                        	INNER JOIN g_catalogos.tipo_productos tp ON sp.id_tipo_producto = tp.id_tipo_producto
                        WHERE
                        	p.id_dossier_pecuario is null and
                            tp.id_area = '".$arrayParametros['id_area']."' and
                            p.estado = '".$arrayParametros['estado']."' and
                            pi.id_operador = '".$arrayParametros['identificador_operador']."'
                        ORDER BY
                        	tp.nombre ASC;";

        return $this->modeloProductosInocuidad->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada para obtener los tipos de productos que tiene un operador
     * por área temática.
     *
     * @return array|ResultSet
     */
    public function obtenerSubtipoProductoXOperadorAreaEstado($arrayParametros) {

        $consulta = "   SELECT
                        	distinct sp.id_subtipo_producto, sp.nombre
                        FROM
                        	g_catalogos.productos_inocuidad pi
                        	INNER JOIN g_catalogos.productos p ON p.id_producto = pi.id_producto
                        	INNER JOIN g_catalogos.subtipo_productos sp ON p.id_subtipo_producto = sp.id_subtipo_producto
                        WHERE
                        	p.id_dossier_pecuario is null and
                            p.estado = '".$arrayParametros['estado']."' and
                            pi.id_operador = '".$arrayParametros['identificador_operador']."' and 
                            sp.id_tipo_producto = '".$arrayParametros['id_tipo_producto']."'
                        ORDER BY
                        	sp.nombre ASC;";

        return $this->modeloProductosInocuidad->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada para obtener los tipos de productos que tiene un operador
     * por área temática.
     *
     * @return array|ResultSet
     */
    public function obtenerProductoXOperadorAreaEstado($arrayParametros) {

        $consulta = "   SELECT
                        	distinct p.id_producto, p.nombre_comun, pi.numero_registro, pi.categoria_toxicologica
                        FROM
                        	g_catalogos.productos_inocuidad pi
                        	INNER JOIN g_catalogos.productos p ON p.id_producto = pi.id_producto
                        WHERE
                        	p.id_dossier_pecuario is null and
                            p.estado = '".$arrayParametros['estado']."' and
                            pi.id_operador = '".$arrayParametros['identificador_operador']."' and 
                            p.id_subtipo_producto = '".$arrayParametros['id_subtipo_producto']."'
                        ORDER BY
                        	p.nombre_comun ASC;";

        return $this->modeloProductosInocuidad->ejecutarSqlNativo($consulta);
    }
	
	/**
     * Guarda el registro actual
     *
     * @param array $datos
     * @return int
     */
    public function guardarProductoInocuidad(array $datos)
    {
        $tablaModelo = new ProductosInocuidadModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();

        return $this->modeloProductosInocuidad->guardar($datosBd);

    }
}