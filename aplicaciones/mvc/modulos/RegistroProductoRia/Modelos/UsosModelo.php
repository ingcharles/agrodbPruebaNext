<?php
/**
 * Modelo UsosModelo
 *
 * Este archivo se complementa con el archivo   UsosLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-20
 * @uses    UsosModelo
 * @package RegistroProductoRia
 * @subpackage Modelos
 */

namespace Agrodb\RegistroProductoRia\Modelos;

use Agrodb\Core\ModeloBase;
use Agrodb\Core\ValidarDatos;

class UsosModelo extends ModeloBase
{

    /**
     * @var Integer
     * Campo requerido
     * Campo visible en el formulario
     * Identificador unico de la tabla
     */
    protected $idUso;
    /**
     * @var Integer
     * Campo requerido
     * Campo visible en el formulario
     *
     */
    protected $idSolicitudRegistroProducto;
    /**
     * @var Integer
     * Campo requerido
     * Campo visible en el formulario
     * Identificador del uso aplicado al producto
     */
    protected $idUsoAplicado;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Nombre del tipo de aplicacion del uso al producto o instalacion
     */
    protected $aplicadoA;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Descripcion del uso aplicado a
     */
    protected $instalacion;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Nombre del uso seleccionado
     */
    protected $nombreUso;

    /**
     * Campos del formulario
     * @var array
     */
    private $campos = array();

    /**
     * Nombre del esquema
     *
     */
    private $esquema = "g_registro_productos";

    /**
     * Nombre de la tabla: usos
     *
     */
    private $tabla = "usos";

    /**
     *Clave primaria
     */
    private $clavePrimaria = "id_uso";


    /**
     *Secuencia
     */
    private $secuencial = 'g_registro_productos"."usos_id_uso_seq';


    /**
     * Constructor
     * $datos - Puede ser los campos del formualario que deben considir con los campos de la tabla
     * @parámetro  array|null $datos
     * @retorna void
     */
    public function __construct(array $datos = null)
    {
        if (is_array($datos)) {
            $this->setOptions($datos);
        }
        $features = new \Zend\Db\TableGateway\Feature\SequenceFeature($this->clavePrimaria, $this->secuencial);
        parent::__construct($this->esquema, $this->tabla, $features);
    }

    /**
     * Permitir el acceso a la propiedad
     *
     * @parámetro  string $name
     * @parámetro  mixed $value
     * @retorna void
     */
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (!method_exists($this, $method)) {
            throw new \Exception('Clase Modelo: UsosModelo. Propiedad especificada invalida: set' . $name);
        }
        $this->$method($value);
    }

    /**
     * Permitir el acceso a la propiedad
     *
     * @parámetro  string $name
     * @retorna mixed
     */
    public function __get($name)
    {
        $method = 'get' . $name;
        if (!method_exists($this, $method)) {
            throw new \Exception('Clase Modelo: UsosModelo. Propiedad especificada invalida: get' . $name);
        }
        return $this->$method();
    }

    /**
     * Llena el modelo con datos
     *
     * @parámetro  array $datos
     * @retorna Modelo
     */
    public function setOptions(array $datos)
    {
        $methods = get_class_methods($this);
        foreach ($datos as $key => $value) {
            $key_original = $key;
            if (strpos($key, '_') > 0) {
                $aux = preg_replace_callback(" /[-_]([a-z]+)/ ", function ($string) {
                    return ucfirst($string[1]);
                }, ucwords($key));
                $key = $aux;
            }
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
                $this->campos[$key_original] = $key;
            }
        }
        return $this;
    }

    /**
     * Recupera los datos validados del modelo y lo retorna en un arreglo
     *
     * @return Array
     */
    public function getPrepararDatos()
    {
        $claseArray = get_object_vars($this);
        foreach ($this->campos as $key => $value) {
            $this->campos[$key] = $claseArray[lcfirst($value)];
        }
        return $this->campos;
    }

    /**
     * Set $esquema
     *
     * Nombre del esquema del módulo
     *
     * @parámetro $esquema
     * @return Nombre del esquema de la base de datos
     */
    public function setEsquema($esquema)
    {
        $this->esquema = $esquema;
        return $this;
    }

    /**
     * Get g_registro_productos
     *
     * @return null|
     */
    public function getEsquema()
    {
        return $this->esquema;
    }

    /**
     * Set idUso
     *
     *Identificador unico de la tabla
     *
     * @parámetro Integer $idUso
     * @return IdUso
     */
    public function setIdUso($idUso)
    {
        $this->idUso = (integer)$idUso;
        return $this;
    }

    /**
     * Get idUso
     *
     * @return null|Integer
     */
    public function getIdUso()
    {
        return $this->idUso;
    }

    /**
     * Set idSolicitudRegistroProducto
     *
     *
     *
     * @parámetro Integer $idSolicitudRegistroProducto
     * @return IdSolicitudRegistroProducto
     */
    public function setIdSolicitudRegistroProducto($idSolicitudRegistroProducto)
    {
        $this->idSolicitudRegistroProducto = (integer)$idSolicitudRegistroProducto;
        return $this;
    }

    /**
     * Get idSolicitudRegistroProducto
     *
     * @return null|Integer
     */
    public function getIdSolicitudRegistroProducto()
    {
        return $this->idSolicitudRegistroProducto;
    }

    /**
     * Set idUsoAplicado
     *
     *Identificador del uso aplicado al producto
     *
     * @parámetro Integer $idUsoAplicado
     * @return IdUsoAplicado
     */
    public function setIdUsoAplicado($idUsoAplicado)
    {
        $this->idUsoAplicado = (integer)$idUsoAplicado;
        return $this;
    }

    /**
     * Get idUsoAplicado
     *
     * @return null|Integer
     */
    public function getIdUsoAplicado()
    {
        return $this->idUsoAplicado;
    }

    /**
     * Set aplicadoA
     *
     *Nombre del tipo de aplicacion del uso al producto o instalacion
     *
     * @parámetro String $aplicadoA
     * @return AplicadoA
     */
    public function setAplicadoA($aplicadoA)
    {
        $this->aplicadoA = (string)$aplicadoA;
        return $this;
    }

    /**
     * Get aplicadoA
     *
     * @return null|String
     */
    public function getAplicadoA()
    {
        return $this->aplicadoA;
    }

    /**
     * Set instalacion
     *
     *Descripcion del uso aplicado a
     *
     * @parámetro String $instalacion
     * @return Instalacion
     */
    public function setInstalacion($instalacion)
    {
        $this->instalacion = (string)$instalacion;
        return $this;
    }

    /**
     * Get instalacion
     *
     * @return null|String
     */
    public function getInstalacion()
    {
        return $this->instalacion;
    }

    /**
     * Set nombreUso
     *
     *Nombre del uso seleccionado
     *
     * @parámetro String $nombreUso
     * @return NombreUso
     */
    public function setNombreUso($nombreUso)
    {
        $this->nombreUso = (string)$nombreUso;
        return $this;
    }

    /**
     * Get nombreUso
     *
     * @return null|String
     */
    public function getNombreUso()
    {
        return $this->nombreUso;
    }

    /**
     * Guarda el registro actual
     * @param array $datos
     * @return int
     */
    public function guardar(array $datos)
    {
        return parent::guardar($datos);
    }

    /**
     * Actualiza un registro actual
     * @param array $datos
     * @param int $id
     * @return int
     */
    public function actualizar(array $datos, $id)
    {
        return parent::actualizar($datos, $this->clavePrimaria . " = " . $id);
    }

    /**
     * Borra el registro actual
     * @param string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        return parent::borrar($this->clavePrimaria . " = " . $id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return UsosModelo
     */
    public function buscar($id)
    {
        return $this->setOptions(parent::buscar($this->clavePrimaria . " = " . $id));
        return $this;
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return parent::buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return parent::buscarLista($where);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function ejecutarConsulta($consulta)
    {
        return parent::ejecutarConsulta($consulta);
    }

}
