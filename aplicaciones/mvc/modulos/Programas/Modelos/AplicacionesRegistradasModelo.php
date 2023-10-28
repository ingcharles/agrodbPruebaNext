<?php
/**
 * Modelo AplicacionesRegistradasModelo
 *
 * Este archivo se complementa con el archivo   AplicacionesRegistradasLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2023-02-09
 * @uses    AplicacionesRegistradasModelo
 * @package Programas
 * @subpackage Modelos
 */
namespace Agrodb\Programas\Modelos;

use Agrodb\Core\ModeloBase;
use Agrodb\Core\ValidarDatos;

class AplicacionesRegistradasModelo extends ModeloBase
{

    /**
     *
     * @var Integer Campo requerido
     *      Campo visible en el formulario
     *      Identificador que hace referencia al id de aplicación registrada
     */
    protected $idAplicacion;

    /**
     *
     * @var String Campo requerido
     *      Campo visible en el formulario
     *      Identificador del funcionario
     */
    protected $identificador;

    /**
     *
     * @var Integer Campo requerido
     *      Campo visible en el formulario
     *      Número que indica la cantidad de procesos pendientes en el módulo
     */
    protected $cantidadNotificacion;

    /**
     *
     * @var String Campo requerido
     *      Campo visible en el formulario
     *      Mensaje descriptivo que acompaña a la cantidad de notificaciones
     */
    protected $mensajeNotificacion;

    /**
     * Campos del formulario
     *
     * @var array
     */
    private $campos = Array();

    /**
     * Nombre del esquema
     */
    private $esquema = "g_programas";

    /**
     * Nombre de la tabla: aplicaciones_registradas
     */
    private $tabla = "aplicaciones_registradas";

    /**
     * Clave primaria
     */
    private $clavePrimaria = "id_aplicacion";

    /**
     * Secuencia
     */
    private $secuencial = 'g_programas"."aplicaciones_registradas_id_aplicacion_seq';

    /**
     * Constructor
     * $datos - Puede ser los campos del formualario que deben considir con los campos de la tabla
     *
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
        if (! method_exists($this, $method)) {
            throw new \Exception('Clase Modelo: AplicacionesRegistradasModelo. Propiedad especificada invalida: set' . $name);
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
        if (! method_exists($this, $method)) {
            throw new \Exception('Clase Modelo: AplicacionesRegistradasModelo. Propiedad especificada invalida: get' . $name);
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
     * Get g_programas
     *
     * @return null
     */
    public function getEsquema()
    {
        return $this->esquema;
    }

    /**
     * Set idAplicacion
     *
     * Identificador que hace referencia al id de aplicación registrada
     *
     * @parámetro Integer $idAplicacion
     * @return IdAplicacion
     */
    public function setIdAplicacion($idAplicacion)
    {
        $this->idAplicacion = (integer) $idAplicacion;
        return $this;
    }

    /**
     * Get idAplicacion
     *
     * @return null|Integer
     */
    public function getIdAplicacion()
    {
        return $this->idAplicacion;
    }

    /**
     * Set identificador
     *
     * Identificador del funcionario
     *
     * @parámetro String $identificador
     * @return Identificador
     */
    public function setIdentificador($identificador)
    {
        $this->identificador = (string) $identificador;
        return $this;
    }

    /**
     * Get identificador
     *
     * @return null|String
     */
    public function getIdentificador()
    {
        return $this->identificador;
    }

    /**
     * Set cantidadNotificacion
     *
     * Número que indica la cantidad de procesos pendientes en el módulo
     *
     * @parámetro Integer $cantidadNotificacion
     * @return CantidadNotificacion
     */
    public function setCantidadNotificacion($cantidadNotificacion)
    {
        $this->cantidadNotificacion = (integer) $cantidadNotificacion;
        return $this;
    }

    /**
     * Get cantidadNotificacion
     *
     * @return null|Integer
     */
    public function getCantidadNotificacion()
    {
        return $this->cantidadNotificacion;
    }

    /**
     * Set mensajeNotificacion
     *
     * Mensaje descriptivo que acompaña a la cantidad de notificaciones
     *
     * @parámetro String $mensajeNotificacion
     * @return MensajeNotificacion
     */
    public function setMensajeNotificacion($mensajeNotificacion)
    {
        $this->mensajeNotificacion = (string) $mensajeNotificacion;
        return $this;
    }

    /**
     * Get mensajeNotificacion
     *
     * @return null|String
     */
    public function getMensajeNotificacion()
    {
        return $this->mensajeNotificacion;
    }

    /**
     * Guarda el registro actual
     *
     * @param array $datos
     * @return int
     */
    public function guardar(Array $datos)
    {
        return parent::guardar($datos);
    }

    /**
     * Actualiza un registro actual
     *
     * @param array $datos
     * @param int $id
     * @return int
     */
    public function actualizar(Array $datos, $id)
    {
        return parent::actualizar($datos, $this->clavePrimaria . " = " . $id);
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
        return parent::borrar($this->clavePrimaria . " = " . $id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return AplicacionesRegistradasModelo
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
