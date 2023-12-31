<?php
/**
 * Modelo ExamenesEquinoModelo
 *
 * Este archivo se complementa con el archivo   ExamenesEquinoLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-02-18
 * @uses    ExamenesEquinoModelo
 * @package PasaporteEquino
 * @subpackage Modelos
 */
namespace Agrodb\PasaporteEquino\Modelos;

use Agrodb\Core\ModeloBase;
use Agrodb\Core\ValidarDatos;

class ExamenesEquinoModelo extends ModeloBase
{

    /**
     *
     * @var Integer Campo requerido
     *      Campo visible en el formulario
     *     
     */
    protected $idExamenEquino;

    /**
     *
     * @var Date Campo requerido
     *      Campo visible en el formulario
     *     
     */
    protected $fechaCreacion;

    /**
     *
     * @var String Campo requerido
     *      Campo visible en el formulario
     *     
     */
    protected $resultadoExamen;

    /**
     *
     * @var String Campo requerido
     *      Campo visible en el formulario
     *     
     */
    protected $laboratorio;

    /**
     *
     * @var String Campo requerido
     *      Campo visible en el formulario
     *     
     */
    protected $numInforme;

    /**
     *
     * @var Date Campo requerido
     *      Campo visible en el formulario
     *     
     */
    protected $fechaExamen;

    /**
     *
     * @var Integer Campo requerido
     *      Campo visible en el formulario
     *     
     */
    protected $idEquino;

    /**
     * Campos del formulario
     *
     * @var array
     */
    private $campos = Array();

    /**
     * Nombre del esquema
     */
    private $esquema = "g_pasaporte_equino";

    /**
     * Nombre de la tabla: examenes_equino
     */
    private $tabla = "examenes_equino";

    /**
     * Clave primaria
     */
    private $clavePrimaria = "id_examen_equino";

    /**
     * Secuencia
     */
    private $secuencial = 'g_pasaporte_equino"."examenes_equino_id_examen_equino_seq';

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
            throw new \Exception('Clase Modelo: ExamenesEquinoModelo. Propiedad especificada invalida: set' . $name);
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
            throw new \Exception('Clase Modelo: ExamenesEquinoModelo. Propiedad especificada invalida: get' . $name);
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
     * Get g_pasaporte_equino
     *
     * @return null
     */
    public function getEsquema()
    {
        return $this->esquema;
    }

    /**
     * Set idExamenEquino
     *
     *
     *
     * @parámetro Integer $idExamenEquino
     * @return IdExamenEquino
     */
    public function setIdExamenEquino($idExamenEquino)
    {
        $this->idExamenEquino = (integer) $idExamenEquino;
        return $this;
    }

    /**
     * Get idExamenEquino
     *
     * @return null|Integer
     */
    public function getIdExamenEquino()
    {
        return $this->idExamenEquino;
    }

    /**
     * Set fechaCreacion
     *
     *
     *
     * @parámetro Date $fechaCreacion
     * @return FechaCreacion
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = (string) $fechaCreacion;
        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return null|Date
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set resultadoExamen
     *
     *
     *
     * @parámetro String $resultadoExamen
     * @return ResultadoExamen
     */
    public function setResultadoExamen($resultadoExamen)
    {
        $this->resultadoExamen = (string) $resultadoExamen;
        return $this;
    }

    /**
     * Get resultadoExamen
     *
     * @return null|String
     */
    public function getResultadoExamen()
    {
        return $this->resultadoExamen;
    }

    /**
     * Set laboratorio
     *
     *
     *
     * @parámetro String $laboratorio
     * @return Laboratorio
     */
    public function setLaboratorio($laboratorio)
    {
        $this->laboratorio = (string) $laboratorio;
        return $this;
    }

    /**
     * Get laboratorio
     *
     * @return null|String
     */
    public function getLaboratorio()
    {
        return $this->laboratorio;
    }

    /**
     * Set numInforme
     *
     *
     *
     * @parámetro String $numInforme
     * @return NumInforme
     */
    public function setNumInforme($numInforme)
    {
        $this->numInforme = (string) $numInforme;
        return $this;
    }

    /**
     * Get numInforme
     *
     * @return null|String
     */
    public function getNumInforme()
    {
        return $this->numInforme;
    }

    /**
     * Set fechaExamen
     *
     *
     *
     * @parámetro Date $fechaExamen
     * @return FechaExamen
     */
    public function setFechaExamen($fechaExamen)
    {
        $this->fechaExamen = (string) $fechaExamen;
        return $this;
    }

    /**
     * Get fechaExamen
     *
     * @return null|Date
     */
    public function getFechaExamen()
    {
        return $this->fechaExamen;
    }

    /**
     * Set idEquino
     *
     *
     *
     * @parámetro Integer $idEquino
     * @return IdEquino
     */
    public function setIdEquino($idEquino)
    {
        $this->idEquino = (integer) $idEquino;
        return $this;
    }

    /**
     * Get idEquino
     *
     * @return null|Integer
     */
    public function getIdEquino()
    {
        return $this->idEquino;
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
     * @return ExamenesEquinoModelo
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
