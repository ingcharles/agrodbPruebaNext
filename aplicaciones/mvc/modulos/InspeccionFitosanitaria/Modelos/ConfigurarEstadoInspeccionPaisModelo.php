<?php
/**
 * Modelo ConfigurarEstadoInspeccionPaisModelo
 *
 * Este archivo se complementa con el archivo   ConfigurarEstadoInspeccionPaisLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    ConfigurarEstadoInspeccionPaisModelo
 * @package InspeccionFitosanitaria
 * @subpackage Modelos
 */
namespace Agrodb\InspeccionFitosanitaria\Modelos;

use Agrodb\Core\ModeloBase;
use Agrodb\Core\ValidarDatos;

class ConfigurarEstadoInspeccionPaisModelo extends ModeloBase
{

    /**
     *
     * @var Integer Campo requerido
     *      Campo visible en el formulario
     *      Identificador unico de la tabla
     */
    protected $idEstadoInspeccionPais;

    /**
     *
     * @var String Campo requerido
     *      Campo visible en el formulario
     *      Campo que almacena el tipo de certificado
     */
    protected $tipoCertificado;

    /**
     *
     * @var Integer Campo requerido
     *      Campo visible en el formulario
     *      Campo que almacena el identificador del país g_catalogos.localizacion llave foranea
     */
    protected $idPais;

    /**
     *
     * @var String Campo requerido
     *      Campo visible en el formulario
     *      Campo que almacena el nombre del pais
     */
    protected $nombrePais;

    /**
     *
     * @var Integer Campo requerido
     *      Campo visible en el formulario
     *      Campo que permite dar vigencia a una solicitud de inspección en estado enviada, con el fin de controlar hasta cuando puede usarse para la emisión de un fito
     */
    protected $diasVigencia;

    /**
     *
     * @var String Campo requerido
     *      Campo visible en el formulario
     *      Campo que almacena si se permite activar el uso de inspecciones en estado enviada
     */
    protected $permitirUsoEnviada;

    /**
     * Campos del formulario
     *
     * @var array
     */
    private $campos = Array();

    /**
     * Nombre del esquema
     */
    private $esquema = "g_inspeccion_fitosanitaria";

    /**
     * Nombre de la tabla: configurar_estado_inspeccion_pais
     */
    private $tabla = "configurar_estado_inspeccion_pais";

    /**
     * Clave primaria
     */
    private $clavePrimaria = "id_estado_inspeccion_pais";

    /**
     * Secuencia
     */
    private $secuencial = 'g_inspeccion_fitosanitaria"."configurar_estado_inspeccion_pais_id_estado_inspeccion_pais_seq';

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
            throw new \Exception('Clase Modelo: ConfigurarEstadoInspeccionPaisModelo. Propiedad especificada invalida: set' . $name);
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
            throw new \Exception('Clase Modelo: ConfigurarEstadoInspeccionPaisModelo. Propiedad especificada invalida: get' . $name);
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
     * Get g_inspeccion_fitosanitaria
     *
     * @return null
     */
    public function getEsquema()
    {
        return $this->esquema;
    }

    /**
     * Set idEstadoInspeccionPais
     *
     * Identificador unico de la tabla
     *
     * @parámetro Integer $idEstadoInspeccionPais
     * @return IdEstadoInspeccionPais
     */
    public function setIdEstadoInspeccionPais($idEstadoInspeccionPais)
    {
        $this->idEstadoInspeccionPais = (integer) $idEstadoInspeccionPais;
        return $this;
    }

    /**
     * Get idEstadoInspeccionPais
     *
     * @return null|Integer
     */
    public function getIdEstadoInspeccionPais()
    {
        return $this->idEstadoInspeccionPais;
    }

    /**
     * Set tipoCertificado
     *
     * Campo que almacena el tipo de certificado
     *
     * @parámetro String $tipoCertificado
     * @return TipoCertificado
     */
    public function setTipoCertificado($tipoCertificado)
    {
        $this->tipoCertificado = (string) $tipoCertificado;
        return $this;
    }

    /**
     * Get tipoCertificado
     *
     * @return null|String
     */
    public function getTipoCertificado()
    {
        return $this->tipoCertificado;
    }

    /**
     * Set idPais
     *
     * Campo que almacena el identificador del país g_catalogos.localizacion llave foranea
     *
     * @parámetro Integer $idPais
     * @return IdPais
     */
    public function setIdPais($idPais)
    {
        $this->idPais = (integer) $idPais;
        return $this;
    }

    /**
     * Get idPais
     *
     * @return null|Integer
     */
    public function getIdPais()
    {
        return $this->idPais;
    }

    /**
     * Set nombrePais
     *
     * Campo que almacena el nombre del pais
     *
     * @parámetro String $nombrePais
     * @return NombrePais
     */
    public function setNombrePais($nombrePais)
    {
        $this->nombrePais = (string) $nombrePais;
        return $this;
    }

    /**
     * Get nombrePais
     *
     * @return null|String
     */
    public function getNombrePais()
    {
        return $this->nombrePais;
    }

    /**
     * Set diasVigencia
     *
     * Campo que permite dar vigencia a una solicitud de inspección en estado enviada, con el fin de controlar hasta cuando puede usarse para la emisión de un fito
     *
     * @parámetro Integer $diasVigencia
     * @return DiasVigencia
     */
    public function setDiasVigencia($diasVigencia)
    {
        $this->diasVigencia = (integer) $diasVigencia;
        return $this;
    }

    /**
     * Get diasVigencia
     *
     * @return null|Integer
     */
    public function getDiasVigencia()
    {
        return $this->diasVigencia;
    }

    /**
     * Set permitirUsoEnviada
     *
     * Campo que almacena si se permite activar el uso de inspecciones en estado enviada
     *
     * @parámetro String $permitirUsoEnviada
     * @return PermitirUsoEnviada
     */
    public function setPermitirUsoEnviada($permitirUsoEnviada)
    {
        $this->permitirUsoEnviada = (string) $permitirUsoEnviada;
        return $this;
    }

    /**
     * Get permitirUsoEnviada
     *
     * @return null|String
     */
    public function getPermitirUsoEnviada()
    {
        return $this->permitirUsoEnviada;
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
     * @return ConfigurarEstadoInspeccionPaisModelo
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
