<?php
/**
 * Modelo SolicitudesModelo
 *
 * Este archivo se complementa con el archivo   SolicitudesLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-10-21
 * @uses    SolicitudesModelo
 * @package EnsayoEficacia
 * @subpackage Modelos
 */

namespace Agrodb\EnsayoEficacia\Modelos;

use Agrodb\Core\ModeloBase;
use Agrodb\Core\ValidarDatos;

class SolicitudesModelo extends ModeloBase
{

    /**
     * @var Integer
     * Campo requerido
     * Campo visible en el formulario
     * Identificador unico de la tabla
     */
    protected $idSolicitud;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena el numero de solicitud creada
     */
    protected $numeroSolicitud;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Cedula o RUC del operador
     */
    protected $identificadorOperador;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la razon social
     */
    protected $razonSocial;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena el nombre del representante legal del operador
     */
    protected $representanteLegal;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la direccion del operador
     */
    protected $direccion;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena el telefono del operador
     */
    protected $telefono;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena el correo del operador
     */
    protected $correo;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la informacion del representante tecnico del operador
     */
    protected $representanteTecnico;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena el tipo de solicitud: Ampliación, Modificación de dosis, Cambio en las
     * condiciones de uso, Revaluación.
     */
    protected $tipoSolicitud;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena los datos del tipo de producto: Químico, Biológico
     */
    protected $tipoProducto;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena el nombre del producto
     */
    protected $producto;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almance el nombre del ensayo de eficacia
     */
    protected $tituloEnsayo;
    /**
     * @var Integer
     * Campo requerido
     * Campo visible en el formulario
     * Llave foranea de la tabla de categorias toxicologicas
     */
    protected $idCategoriaToxicologica;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena el nombre de la categoria toxicologica
     */
    protected $nombreCategoriaToxicologica;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta de la ficha tecnica
     */
    protected $rutaFichaTecnica;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     *
     */
    protected $rutaPermisoImportacionMuestra;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta del protocolo
     */
    protected $rutaProtocolo;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena si el ensayo esta relaciondo con un tipo de cultivo menor
     */
    protected $cultivoMenor;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena el estado de la solicitud
     */
    protected $estado;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacea el nombre de la provincia del operador
     */
    protected $provinciaOperador;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacea el identificador del técnico que realiza el proceso de revision tecnica
     */
    protected $identificadorRevisorTecnico;
    /**
     * @var Date
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la fecha de creacion de la solicitud
     */
    protected $fechaCreacion;
    /**
     * @var Date
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la fecha de subsanacion de la solicitud
     */
    protected $fechaSubsanacion;
    /**
     * @var Date
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la fecha de estimada de atencion de la solicitud
     */
    protected $fechaAtencionEstimada;
    /**
     * @var Date
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la fecha de aprobacion de la solicitud
     */
    protected $fechaAprobacion;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena el estado anterior de la solicitud
     */
    protected $estadoAnterior;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Observacion del revisor en el proceso de revision tecnica
     */
    protected $observacionRevisorTecnico;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Ruta a documento con las observaciones del proceso de revision tecnica
     */
    protected $rutaRevisorTecnico;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacea el identificador del técnico que realiza el proceso de revision de resultados de ensayo de eficacia
     */
    protected $identificadorRevisorResultado;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Observacion del revisor en el proceso de revision de resultados de ensayo de eficacia
     */
    protected $observacionRevisorResultado;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta uno del resultado de revision de resulado de protocolo
     */
    protected $rutaInformeUno;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta dos del resultado de revision de resulado de protocolo
     */
    protected $rutaInformeDos;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena el resultado de la revision tecnica
     */
    protected $resultadoRevisorTecnico;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena el resultado de la revision de resultados
     */
    protected $resultadoRevisorResultado;
    
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la observacion del operador
     */
    protected $observacion;

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
     * Nombre de la tabla: solicitudes
     *
     */
    private $tabla = "solicitudes";

    /**
     *Clave primaria
     */
    private $clavePrimaria = "id_solicitud";


    /**
     *Secuencia
     */
    private $secuencial = 'g_ensayo_eficacia_mvc"."solicitudes_id_solicitud_seq';


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
            throw new \Exception('Clase Modelo: SolicitudesModelo. Propiedad especificada invalida: set' . $name);
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
            throw new \Exception('Clase Modelo: SolicitudesModelo. Propiedad especificada invalida: get' . $name);
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
     * Set idSolicitud
     *
     *Identificador unico de la tabla
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
     * Set numeroSolicitud
     *
     *Campo que almacena el numero de solicitud creada
     *
     * @parámetro String $numeroSolicitud
     * @return NumeroSolicitud
     */
    public function setNumeroSolicitud($numeroSolicitud)
    {
        $this->numeroSolicitud = (string)$numeroSolicitud;
        return $this;
    }

    /**
     * Get numeroSolicitud
     *
     * @return null|String
     */
    public function getNumeroSolicitud()
    {
        return $this->numeroSolicitud;
    }

    /**
     * Set identificadorOperador
     *
     *Cedula o RUC del operador
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
     * Set razonSocial
     *
     *Campo que almacena la razon social
     *
     * @parámetro String $razonSocial
     * @return RazonSocial
     */
    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = (string)$razonSocial;
        return $this;
    }

    /**
     * Get razonSocial
     *
     * @return null|String
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * Set representanteLegal
     *
     *Campo que almacena el nombre del representante legal del operador
     *
     * @parámetro String $representanteLegal
     * @return RepresentanteLegal
     */
    public function setRepresentanteLegal($representanteLegal)
    {
        $this->representanteLegal = (string)$representanteLegal;
        return $this;
    }

    /**
     * Get representanteLegal
     *
     * @return null|String
     */
    public function getRepresentanteLegal()
    {
        return $this->representanteLegal;
    }

    /**
     * Set direccion
     *
     *Campo que almacena la direccion del operador
     *
     * @parámetro String $direccion
     * @return Direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = (string)$direccion;
        return $this;
    }

    /**
     * Get direccion
     *
     * @return null|String
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set telefono
     *
     *Campo que almacena el telefono del operador
     *
     * @parámetro String $telefono
     * @return Telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = (string)$telefono;
        return $this;
    }

    /**
     * Get telefono
     *
     * @return null|String
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set correo
     *
     *Campo que almacena el correo del operador
     *
     * @parámetro String $correo
     * @return Correo
     */
    public function setCorreo($correo)
    {
        $this->correo = (string)$correo;
        return $this;
    }

    /**
     * Get correo
     *
     * @return null|String
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set representanteTecnico
     *
     *Campo que almacena la informacion del representante tecnico del operador
     *
     * @parámetro String $representanteTecnico
     * @return RepresentanteTecnico
     */
    public function setRepresentanteTecnico($representanteTecnico)
    {
        $this->representanteTecnico = (string)$representanteTecnico;
        return $this;
    }

    /**
     * Get representanteTecnico
     *
     * @return null|String
     */
    public function getRepresentanteTecnico()
    {
        return $this->representanteTecnico;
    }

    /**
     * Set tipoSolicitud
     *
     *Campo que almacena el tipo de solicitud: Ampliación, Modificación de dosis, Cambio en las
     * condiciones de uso, Revaluación.
     *
     * @parámetro String $tipoSolicitud
     * @return TipoSolicitud
     */
    public function setTipoSolicitud($tipoSolicitud)
    {
        $this->tipoSolicitud = (string)$tipoSolicitud;
        return $this;
    }

    /**
     * Get tipoSolicitud
     *
     * @return null|String
     */
    public function getTipoSolicitud()
    {
        return $this->tipoSolicitud;
    }

    /**
     * Set tipoProducto
     *
     *Campo que almacena los datos del tipo de producto: Químico, Biológico
     *
     * @parámetro String $tipoProducto
     * @return TipoProducto
     */
    public function setTipoProducto($tipoProducto)
    {
        $this->tipoProducto = (string)$tipoProducto;
        return $this;
    }

    /**
     * Get tipoProducto
     *
     * @return null|String
     */
    public function getTipoProducto()
    {
        return $this->tipoProducto;
    }

    /**
     * Set producto
     *
     *Campo que almacena el nombre del producto
     *
     * @parámetro String $producto
     * @return Producto
     */
    public function setProducto($producto)
    {
        $this->producto = (string)$producto;
        return $this;
    }

    /**
     * Get producto
     *
     * @return null|String
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set tituloEnsayo
     *
     *Campo que almance el nombre del ensayo de eficacia
     *
     * @parámetro String $tituloEnsayo
     * @return TituloEnsayo
     */
    public function setTituloEnsayo($tituloEnsayo)
    {
        $this->tituloEnsayo = (string)$tituloEnsayo;
        return $this;
    }

    /**
     * Get tituloEnsayo
     *
     * @return null|String
     */
    public function getTituloEnsayo()
    {
        return $this->tituloEnsayo;
    }

    /**
     * Set idCategoriaToxicologica
     *
     *Llave foranea de la tabla de categorias toxicologicas
     *
     * @parámetro Integer $idCategoriaToxicologica
     * @return IdCategoriaToxicologica
     */
    public function setIdCategoriaToxicologica($idCategoriaToxicologica)
    {
        $this->idCategoriaToxicologica = (integer)$idCategoriaToxicologica;
        return $this;
    }

    /**
     * Get idCategoriaToxicologica
     *
     * @return null|Integer
     */
    public function getIdCategoriaToxicologica()
    {
        return $this->idCategoriaToxicologica;
    }

    /**
     * Set nombreCategoriaToxicologica
     *
     *Campo que almacena el nombre de la categoria toxicologica
     *
     * @parámetro String $nombreCategoriaToxicologica
     * @return NombreCategoriaToxicologica
     */
    public function setNombreCategoriaToxicologica($nombreCategoriaToxicologica)
    {
        $this->nombreCategoriaToxicologica = (string)$nombreCategoriaToxicologica;
        return $this;
    }

    /**
     * Get nombreCategoriaToxicologica
     *
     * @return null|String
     */
    public function getNombreCategoriaToxicologica()
    {
        return $this->nombreCategoriaToxicologica;
    }

    /**
     * Set rutaFichaTecnica
     *
     *Campo que almacena la ruta de la ficha tecnica
     *
     * @parámetro String $rutaFichaTecnica
     * @return RutaFichaTecnica
     */
    public function setRutaFichaTecnica($rutaFichaTecnica)
    {
        $this->rutaFichaTecnica = (string)$rutaFichaTecnica;
        return $this;
    }

    /**
     * Get rutaFichaTecnica
     *
     * @return null|String
     */
    public function getRutaFichaTecnica()
    {
        return $this->rutaFichaTecnica;
    }

    /**
     * Set rutaPermisoImportacionMuestra
     *
     *
     *
     * @parámetro String $rutaPermisoImportacionMuestra
     * @return RutaPermisoImportacionMuestra
     */
    public function setRutaPermisoImportacionMuestra($rutaPermisoImportacionMuestra)
    {
        $this->rutaPermisoImportacionMuestra = (string)$rutaPermisoImportacionMuestra;
        return $this;
    }

    /**
     * Get rutaPermisoImportacionMuestra
     *
     * @return null|String
     */
    public function getRutaPermisoImportacionMuestra()
    {
        return $this->rutaPermisoImportacionMuestra;
    }

    /**
     * Set rutaProtocolo
     *
     *Campo que almacena la ruta del protocolo
     *
     * @parámetro String $rutaProtocolo
     * @return RutaProtocolo
     */
    public function setRutaProtocolo($rutaProtocolo)
    {
        $this->rutaProtocolo = (string)$rutaProtocolo;
        return $this;
    }

    /**
     * Get rutaProtocolo
     *
     * @return null|String
     */
    public function getRutaProtocolo()
    {
        return $this->rutaProtocolo;
    }

    /**
     * Set cultivoMenor
     *
     *Campo que almacena si el ensayo esta relaciondo con un tipo de cultivo menor
     *
     * @parámetro String $cultivoMenor
     * @return CultivoMenor
     */
    public function setCultivoMenor($cultivoMenor)
    {
        $this->cultivoMenor = (string)$cultivoMenor;
        return $this;
    }

    /**
     * Get cultivoMenor
     *
     * @return null|String
     */
    public function getCultivoMenor()
    {
        return $this->cultivoMenor;
    }

    /**
     * Set estado
     *
     *Campo que almacena el estado de la solicitud
     *
     * @parámetro String $estado
     * @return Estado
     */
    public function setEstado($estado)
    {
        $this->estado = (string)$estado;
        return $this;
    }

    /**
     * Get estado
     *
     * @return null|String
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set provinciaOperador
     *
     *Campo que almacea el nombre de la provincia del operador
     *
     * @parámetro String $provinciaOperador
     * @return ProvinciaOperador
     */
    public function setProvinciaOperador($provinciaOperador)
    {
        $this->provinciaOperador = (string)$provinciaOperador;
        return $this;
    }

    /**
     * Get provinciaOperador
     *
     * @return null|String
     */
    public function getProvinciaOperador()
    {
        return $this->provinciaOperador;
    }

    /**
     * Set identificadorRevisorTecnico
     *
     *Campo que almacea el identificador del técnico que realiza el proceso de revision tecnica
     *
     * @parámetro String $identificadorRevisorTecnico
     * @return IdentificadorRevisorTecnico
     */
    public function setIdentificadorRevisorTecnico($identificadorRevisorTecnico)
    {
        $this->identificadorRevisorTecnico = (string)$identificadorRevisorTecnico;
        return $this;
    }

    /**
     * Get identificadorRevisorTecnico
     *
     * @return null|String
     */
    public function getIdentificadorRevisorTecnico()
    {
        return $this->identificadorRevisorTecnico;
    }

    /**
     * Set fechaCreacion
     *
     *Campo que almacena la fecha de creacion de la solicitud
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
     * Set fechaSubsanacion
     *
     *Campo que almacena la fecha de subsanacion de la solicitud
     *
     * @parámetro Date $fechaSubsanacion
     * @return FechaSubsanacion
     */
    public function setFechaSubsanacion($fechaSubsanacion)
    {
        $this->fechaSubsanacion = (string)$fechaSubsanacion;
        return $this;
    }

    /**
     * Get fechaSubsanacion
     *
     * @return null|Date
     */
    public function getFechaSubsanacion()
    {
        return $this->fechaSubsanacion;
    }

    /**
     * Set fechaAtencionEstimada
     *
     *Campo que almacena la fecha de estimada de atencion de la solicitud
     *
     * @parámetro Date $fechaAtencionEstimada
     * @return FechaAtencionEstimada
     */
    public function setFechaAtencionEstimada($fechaAtencionEstimada)
    {
        $this->fechaAtencionEstimada = (string)$fechaAtencionEstimada;
        return $this;
    }

    /**
     * Get fechaAtencionEstimada
     *
     * @return null|Date
     */
    public function getFechaAtencionEstimada()
    {
        return $this->fechaAtencionEstimada;
    }

    /**
     * Set fechaAprobacion
     *
     *Campo que almacena la fecha de aprobacion de la solicitud
     *
     * @parámetro Date $fechaAprobacion
     * @return FechaAprobacion
     */
    public function setFechaAprobacion($fechaAprobacion)
    {
        $this->fechaAprobacion = (string)$fechaAprobacion;
        return $this;
    }

    /**
     * Get fechaAprobacion
     *
     * @return null|Date
     */
    public function getFechaAprobacion()
    {
        return $this->fechaAprobacion;
    }

    /**
     * Set estadoAnterior
     *
     *Campo que almacena el estado anterior de la solicitud
     *
     * @parámetro String $estadoAnterior
     * @return EstadoAnterior
     */
    public function setEstadoAnterior($estadoAnterior)
    {
        $this->estadoAnterior = (string)$estadoAnterior;
        return $this;
    }

    /**
     * Get estadoAnterior
     *
     * @return null|String
     */
    public function getEstadoAnterior()
    {
        return $this->estadoAnterior;
    }

    /**
     * Set observacionRevisorTecnico
     *
     *Observacion del revisor en el proceso de revision tecnica
     *
     * @parámetro String $observacionRevisorTecnico
     * @return ObservacionRevisorTecnico
     */
    public function setObservacionRevisorTecnico($observacionRevisorTecnico)
    {
        $this->observacionRevisorTecnico = (string)$observacionRevisorTecnico;
        return $this;
    }

    /**
     * Get observacionRevisorTecnico
     *
     * @return null|String
     */
    public function getObservacionRevisorTecnico()
    {
        return $this->observacionRevisorTecnico;
    }

    /**
     * Set rutaRevisorTecnico
     *
     *Ruta a documento con las observaciones del proceso de revision tecnica
     *
     * @parámetro String $rutaRevisorTecnico
     * @return RutaRevisorTecnico
     */
    public function setRutaRevisorTecnico($rutaRevisorTecnico)
    {
        $this->rutaRevisorTecnico = (string)$rutaRevisorTecnico;
        return $this;
    }

    /**
     * Get rutaRevisorTecnico
     *
     * @return null|String
     */
    public function getRutaRevisorTecnico()
    {
        return $this->rutaRevisorTecnico;
    }

    /**
     * Set identificadorRevisorResultado
     *
     *Campo que almacea el identificador del técnico que realiza el proceso de revision de resultados de ensayo de eficacia
     *
     * @parámetro String $identificadorRevisorResultado
     * @return IdentificadorRevisorResultado
     */
    public function setIdentificadorRevisorResultado($identificadorRevisorResultado)
    {
        $this->identificadorRevisorResultado = (string)$identificadorRevisorResultado;
        return $this;
    }

    /**
     * Get identificadorRevisorResultado
     *
     * @return null|String
     */
    public function getIdentificadorRevisorResultado()
    {
        return $this->identificadorRevisorResultado;
    }

    /**
     * Set observacionRevisorResultado
     *
     *Observacion del revisor en el proceso de revision de resultados de ensayo de eficacia
     *
     * @parámetro String $observacionRevisorResultado
     * @return ObservacionRevisorResultado
     */
    public function setObservacionRevisorResultado($observacionRevisorResultado)
    {
        $this->observacionRevisorResultado = (string)$observacionRevisorResultado;
        return $this;
    }

    /**
     * Get observacionRevisorResultado
     *
     * @return null|String
     */
    public function getObservacionRevisorResultado()
    {
        return $this->observacionRevisorResultado;
    }

    /**
     * Set rutaInformeUno
     *
     *Campo que almacena la ruta uno del resultado de revision de resulado de protocolo
     *
     * @parámetro String $rutaInformeUno
     * @return RutaInformeUno
     */
    public function setRutaInformeUno($rutaInformeUno)
    {
        $this->rutaInformeUno = (string)$rutaInformeUno;
        return $this;
    }

    /**
     * Get rutaInformeUno
     *
     * @return null|String
     */
    public function getRutaInformeUno()
    {
        return $this->rutaInformeUno;
    }

    /**
     * Set rutaInformeDos
     *
     *Campo que almacena la ruta dos del resultado de revision de resulado de protocolo
     *
     * @parámetro String $rutaInformeDos
     * @return RutaInformeDos
     */
    public function setRutaInformeDos($rutaInformeDos)
    {
        $this->rutaInformeDos = (string)$rutaInformeDos;
        return $this;
    }

    /**
     * Get rutaInformeDos
     *
     * @return null|String
     */
    public function getRutaInformeDos()
    {
        return $this->rutaInformeDos;
    }

    /**
     * Set resultadoRevisorTecnico
     *
     *Campo que almacena el resultado de la revision tecnica
     *
     * @parámetro String $resultadoRevisorTecnico
     * @return ResultadoRevisorTecnico
     */
    public function setResultadoRevisorTecnico($resultadoRevisorTecnico)
    {
        $this->resultadoRevisorTecnico = (string)$resultadoRevisorTecnico;
        return $this;
    }

    /**
     * Get resultadoRevisorTecnico
     *
     * @return null|String
     */
    public function getResultadoRevisorTecnico()
    {
        return $this->resultadoRevisorTecnico;
    }

    /**
     * Set resultadoRevisorResultado
     *
     *Campo que almacena el resultado de la revision de resultados
     *
     * @parámetro String $resultadoRevisorResultado
     * @return ResultadoRevisorResultado
     */
    public function setResultadoRevisorResultado($resultadoRevisorResultado)
    {
        $this->resultadoRevisorResultado = (string)$resultadoRevisorResultado;
        return $this;
    }

    /**
     * Get resultadoRevisorResultado
     *
     * @return null|String
     */
    public function getResultadoRevisorResultado()
    {
        return $this->resultadoRevisorResultado;
    }
    
    /**
     * Set observacion
     *
     *Campo que almacena la observacion del operador
     *
     * @parámetro String $observacion
     * @return observacion
     */
    public function setObservacion($observacion)
    {
        $this->observacion = (string)$observacion;
        return $this;
    }
    
    /**
     * Get observacion
     *
     * @return null|String
     */
    public function getObservacion()
    {
        return $this->observacion;
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
     * @return SolicitudesModelo
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
