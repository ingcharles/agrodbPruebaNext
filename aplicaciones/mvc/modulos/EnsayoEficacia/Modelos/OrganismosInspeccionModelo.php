<?php
/**
 * Modelo OrganismosInspeccionModelo
 *
 * Este archivo se complementa con el archivo   OrganismosInspeccionLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-10-21
 * @uses    OrganismosInspeccionModelo
 * @package EnsayoEficacia
 * @subpackage Modelos
 */

namespace Agrodb\EnsayoEficacia\Modelos;

use Agrodb\Core\ModeloBase;
use Agrodb\Core\ValidarDatos;

class OrganismosInspeccionModelo extends ModeloBase
{

    /**
     * @var Integer
     * Campo requerido
     * Campo visible en el formulario
     * Identificador unico de la tabla
     */
    protected $idOrganismoInspeccion;
    /**
     * @var Integer
     * Campo requerido
     * Campo visible en el formulario
     * Llave foranea de la tabla de solicitudes de ensayo de eficacia
     */
    protected $idSolicitud;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacea el identificador del organismo de inspeccion al cual fue asigando el ensayo de eficacia
     */
    protected $identificadorOrganismoInspeccion;
    /**
     * @var Date
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la fecha de creacion de la tabla
     */
    protected $fechaCreacion;

    /**
     * Campos del formulario
     * @var array
     */
    private $campos = array();

    /**
     * Nombre del esquema
     *
     */
    private $esquema = "g_ensayo_eficacia_mvc";

    /**
     * Nombre de la tabla: organismos_inspeccion
     *
     */
    private $tabla = "organismos_inspeccion";

    /**
     *Clave primaria
     */
    private $clavePrimaria = "id_organismo_inspeccion";


    /**
     *Secuencia
     */
    private $secuencial = 'g_ensayo_eficacia_mvc"."organismos_inspeccion_id_organismo_inspeccion_seq';


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
            throw new \Exception('Clase Modelo: OrganismosInspeccionModelo. Propiedad especificada invalida: set' . $name);
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
            throw new \Exception('Clase Modelo: OrganismosInspeccionModelo. Propiedad especificada invalida: get' . $name);
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
     * Get g_ensayo_eficacia_mvc
     *
     * @return null|
     */
    public function getEsquema()
    {
        return $this->esquema;
    }

    /**
     * Set idOrganismoInspeccion
     *
     *Identificador unico de la tabla
     *
     * @parámetro Integer $idOrganismoInspeccion
     * @return IdOrganismoInspeccion
     */
    public function setIdOrganismoInspeccion($idOrganismoInspeccion)
    {
        $this->idOrganismoInspeccion = (integer)$idOrganismoInspeccion;
        return $this;
    }

    /**
     * Get idOrganismoInspeccion
     *
     * @return null|Integer
     */
    public function getIdOrganismoInspeccion()
    {
        return $this->idOrganismoInspeccion;
    }

    /**
     * Set idSolicitud
     *
     *Llave foranea de la tabla de solicitudes de ensayo de eficacia
     *
     * @parámetro Integer $idSolicitud
     * @return IdSolicitud
     */
    public function setIdSolicitud($idSolicitud)
    {
        $this->idSolicitud = (integer)$idSolicitud;
        return $this;
    }

    /**
     * Get idSolicitud
     *
     * @return null|Integer
     */
    public function getIdSolicitud()
    {
        return $this->idSolicitud;
    }

    /**
     * Set identificadorOrganismoInspeccion
     *
     *Campo que almacea el identificador del organismo de inspeccion al cual fue asigando el ensayo de eficacia
     *
     * @parámetro String $identificadorOrganismoInspeccion
     * @return IdentificadorOrganismoInspeccion
     */
    public function setIdentificadorOrganismoInspeccion($identificadorOrganismoInspeccion)
    {
        $this->identificadorOrganismoInspeccion = (string)$identificadorOrganismoInspeccion;
        return $this;
    }

    /**
     * Get identificadorOrganismoInspeccion
     *
     * @return null|String
     */
    public function getIdentificadorOrganismoInspeccion()
    {
        return $this->identificadorOrganismoInspeccion;
    }

    /**
     * Set fechaCreacion
     *
     *Campo que almacena la fecha de creacion de la tabla
     *
     * @parámetro Date $fechaCreacion
     * @return FechaCreacion
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = (string)$fechaCreacion;
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
     * @return OrganismosInspeccionModelo
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
