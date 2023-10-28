<?php
/**
 * Modelo ResultadosEnsayoModelo
 *
 * Este archivo se complementa con el archivo   ResultadosEnsayoLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-10-21
 * @uses    ResultadosEnsayoModelo
 * @package EnsayoEficacia
 * @subpackage Modelos
 */

namespace Agrodb\EnsayoEficacia\Modelos;

use Agrodb\Core\ModeloBase;
use Agrodb\Core\ValidarDatos;

class ResultadosEnsayoModelo extends ModeloBase
{

    /**
     * @var Integer
     * Campo requerido
     * Campo visible en el formulario
     * Identificador unico de la tabla
     */
    protected $idResultadoEnsayo;
    /**
     * @var Integer
     * Campo requerido
     * Campo visible en el formulario
     * Llave foranea de la tabla de solicitudes
     */
    protected $idSolicitud;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena el identificador del operador
     */
    protected $identificadorOperador;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta del informe del operador uno
     */
    protected $rutaInformeOperadorUno;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta del informe del operador uno
     */
    protected $rutaInformeOperadorDos;
    /**
     * @var Date
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la fecha de ingreos del resultado del enesayo de eficacia por parte del operador
     */
    protected $fechaCreacionOperador;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena el identificador del organismo de inspeccion
     */
    protected $identificadorOrganismo;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta del informe del organismo de inspeccion uno
     */
    protected $rutaInformeOrganismoUno;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta del informe del organismo de inspeccion dos
     */
    protected $rutaInformeOrganismoDos;
    /**
     * @var Date
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la fecha de ingreos del resultado del ensayo de eficacia por parte del organismo de inspeccion
     */
    protected $fechaCreacionOrganismo;

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
     * Nombre de la tabla: resultados_ensayo
     *
     */
    private $tabla = "resultados_ensayo";

    /**
     *Clave primaria
     */
    private $clavePrimaria = "id_resultado_ensayo";


    /**
     *Secuencia
     */
    private $secuencial = 'g_ensayo_eficacia_mvc"."resultados_ensayo_id_resultado_ensayo_seq';


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
            throw new \Exception('Clase Modelo: ResultadosEnsayoModelo. Propiedad especificada invalida: set' . $name);
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
            throw new \Exception('Clase Modelo: ResultadosEnsayoModelo. Propiedad especificada invalida: get' . $name);
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
     * Set idResultadoEnsayo
     *
     *Identificador unico de la tabla
     *
     * @parámetro Integer $idResultadoEnsayo
     * @return IdResultadoEnsayo
     */
    public function setIdResultadoEnsayo($idResultadoEnsayo)
    {
        $this->idResultadoEnsayo = (integer)$idResultadoEnsayo;
        return $this;
    }

    /**
     * Get idResultadoEnsayo
     *
     * @return null|Integer
     */
    public function getIdResultadoEnsayo()
    {
        return $this->idResultadoEnsayo;
    }

    /**
     * Set idSolicitud
     *
     *Llave foranea de la tabla de solicitudes
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
     * Set identificadorOperador
     *
     *Campo que almacena el identificador del operador
     *
     * @parámetro String $identificadorOperador
     * @return IdentificadorOperador
     */
    public function setIdentificadorOperador($identificadorOperador)
    {
        $this->identificadorOperador = (string)$identificadorOperador;
        return $this;
    }

    /**
     * Get identificadorOperador
     *
     * @return null|String
     */
    public function getIdentificadorOperador()
    {
        return $this->identificadorOperador;
    }

    /**
     * Set rutaInformeOperadorUno
     *
     *Campo que almacena la ruta del informe del operador uno
     *
     * @parámetro String $rutaInformeOperadorUno
     * @return RutaInformeOperadorUno
     */
    public function setRutaInformeOperadorUno($rutaInformeOperadorUno)
    {
        $this->rutaInformeOperadorUno = (string)$rutaInformeOperadorUno;
        return $this;
    }

    /**
     * Get rutaInformeOperadorUno
     *
     * @return null|String
     */
    public function getRutaInformeOperadorUno()
    {
        return $this->rutaInformeOperadorUno;
    }

    /**
     * Set rutaInformeOperadorDos
     *
     *Campo que almacena la ruta del informe del operador uno
     *
     * @parámetro String $rutaInformeOperadorDos
     * @return RutaInformeOperadorDos
     */
    public function setRutaInformeOperadorDos($rutaInformeOperadorDos)
    {
        $this->rutaInformeOperadorDos = (string)$rutaInformeOperadorDos;
        return $this;
    }

    /**
     * Get rutaInformeOperadorDos
     *
     * @return null|String
     */
    public function getRutaInformeOperadorDos()
    {
        return $this->rutaInformeOperadorDos;
    }

    /**
     * Set fechaCreacionOperador
     *
     *Campo que almacena la fecha de ingreos del resultado del enesayo de eficacia por parte del operador
     *
     * @parámetro Date $fechaCreacionOperador
     * @return FechaCreacionOperador
     */
    public function setFechaCreacionOperador($fechaCreacionOperador)
    {
        $this->fechaCreacionOperador = (string)$fechaCreacionOperador;
        return $this;
    }

    /**
     * Get fechaCreacionOperador
     *
     * @return null|Date
     */
    public function getFechaCreacionOperador()
    {
        return $this->fechaCreacionOperador;
    }

    /**
     * Set identificadorOrganismo
     *
     *Campo que almacena el identificador del organismo de inspeccion
     *
     * @parámetro String $identificadorOrganismo
     * @return IdentificadorOrganismo
     */
    public function setIdentificadorOrganismo($identificadorOrganismo)
    {
        $this->identificadorOrganismo = (string)$identificadorOrganismo;
        return $this;
    }

    /**
     * Get identificadorOrganismo
     *
     * @return null|String
     */
    public function getIdentificadorOrganismo()
    {
        return $this->identificadorOrganismo;
    }

    /**
     * Set rutaInformeOrganismoUno
     *
     *Campo que almacena la ruta del informe del organismo de inspeccion uno
     *
     * @parámetro String $rutaInformeOrganismoUno
     * @return RutaInformeOrganismoUno
     */
    public function setRutaInformeOrganismoUno($rutaInformeOrganismoUno)
    {
        $this->rutaInformeOrganismoUno = (string)$rutaInformeOrganismoUno;
        return $this;
    }

    /**
     * Get rutaInformeOrganismoUno
     *
     * @return null|String
     */
    public function getRutaInformeOrganismoUno()
    {
        return $this->rutaInformeOrganismoUno;
    }

    /**
     * Set rutaInformeOrganismoDos
     *
     *Campo que almacena la ruta del informe del organismo de inspeccion dos
     *
     * @parámetro String $rutaInformeOrganismoDos
     * @return RutaInformeOrganismoDos
     */
    public function setRutaInformeOrganismoDos($rutaInformeOrganismoDos)
    {
        $this->rutaInformeOrganismoDos = (string)$rutaInformeOrganismoDos;
        return $this;
    }

    /**
     * Get rutaInformeOrganismoDos
     *
     * @return null|String
     */
    public function getRutaInformeOrganismoDos()
    {
        return $this->rutaInformeOrganismoDos;
    }

    /**
     * Set fechaCreacionOrganismo
     *
     *Campo que almacena la fecha de ingreos del resultado del ensayo de eficacia por parte del organismo de inspeccion
     *
     * @parámetro Date $fechaCreacionOrganismo
     * @return FechaCreacionOrganismo
     */
    public function setFechaCreacionOrganismo($fechaCreacionOrganismo)
    {
        $this->fechaCreacionOrganismo = (string)$fechaCreacionOrganismo;
        return $this;
    }

    /**
     * Get fechaCreacionOrganismo
     *
     * @return null|Date
     */
    public function getFechaCreacionOrganismo()
    {
        return $this->fechaCreacionOrganismo;
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
     * @return ResultadosEnsayoModelo
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
