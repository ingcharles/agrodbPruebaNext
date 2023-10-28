<?php
/**
 * Modelo SolicitudesRegistroProductosModelo
 *
 * Este archivo se complementa con el archivo   SolicitudesRegistroProductosLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    SolicitudesRegistroProductosModelo
 * @package RegistroProductoRia
 * @subpackage Modelos
 */

namespace Agrodb\RegistroProductoRia\Modelos;

use Agrodb\Core\ModeloBase;
use Agrodb\Core\ValidarDatos;

class SolicitudesRegistroProductosModelo extends ModeloBase
{

    /**
     * @var Integer
     * Campo requerido
     * Campo visible en el formulario
     * Identificador unico de la tabla
     */
    protected $idSolicitudRegistroProducto;
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
     * @var Integer
     * Campo requerido
     * Campo visible en el formulario
     * Identificador unico de la tabla g_catalogos.tipos_productos
     */
    protected $idTipoProducto;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Nombre del tipo de producto
     */
    protected $nombreTipoProducto;
    /**
     * @var Integer
     * Campo requerido
     * Campo visible en el formulario
     * Identificador unico de la tabla g_catalogo.subtipo_productos
     */
    protected $idSubtipoProducto;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Nombre del subtipo de producto
     */
    protected $nombreSubtipoProducto;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Partida arancelaria del producto
     */
    protected $partidaArancelaria;
    /**
     * @var Integer
     * Campo requerido
     * Campo visible en el formulario
     * Identificador unico de la tabla g_catalogos.formulacion
     */
    protected $idFormulacion;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Nombre del producto
     */
    protected $nombreProducto;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Nombre de la formulacion
     */
    protected $nombreFormulacion;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Dosis del producto
     */
    protected $dosis;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Unidad de medida de la dosis ingresada
     */
    protected $unidadDosis;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Periodo de reingreso del producto
     */
    protected $periodoReingreso;
    /**
     * @var Integer
     * Campo requerido
     * Campo visible en el formulario
     * Identificador de la categoria toxicologica
     */
    protected $idCategoriaToxicologica;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Nombre de la categoria toxicologica
     */
    protected $nombreCategoriaToxicologica;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Datos de estabilidad
     */
    protected $estabilidad;
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
     * Campo que almacena la ruta del certificado de compsocion y vida util
     */
    protected $rutaComposicionVidaUtil;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta del certificado de analisis de laboratorio
     */
    protected $rutaAnalisisLaboratorio;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta de la etiqueta
     */
    protected $rutaEtiqueta;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta de la declaracion juramentada
     */
    protected $rutaDeclaracionJuramentada;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta de los envases y  embalajes
     */
    protected $rutaEnvasesEmbalajes;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta de los analisis y composiciones
     */
    protected $rutaAnalisisComposicion;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta de otro tipo de anexos necesarios para el registro del producto
     */
    protected $rutaOtros;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * true, no se realiza asignación de tasa automática
     */
    protected $requiereDescuento;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     *
     */
    
    protected $pagoEnsayoEficacia;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     *
     */
    
    protected $provinciaOperador;
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
     * Campo que almacena la fecha de confirmacion de la solicitud
     */
    protected $fechaConfirmacionPago;
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
     * Campo que almacea el identificador del técnico que realiza la inspeccion
     */
    protected $identificadorRevisor;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Observacion del revisor en el proceso de revision tecnica
     */
    protected $observacionRevisor;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Ruta a documento con las observaciones del proceso de revision tecnica
     */
    protected $rutaRevisor;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena el resultado de la revision tecnica
     */
    protected $resultadoRevisor;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Tipo de solicitud de registro de producto
     */
    protected $tipoSolicitud;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Ruta de certificado de registro de producto aprobado
     */
    protected $rutaCertificado;
    /**
     * @var Integer
     * Campo requerido
     * Campo visible en el formulario
     * Identificador unico de la tabla g_catalogo.productos
     */
    protected $idProducto;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Nombre del producto al cual se relacionado el producto clon
     */
    protected $nombreComun;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Numero de registro del producto
     */
    protected $numeroRegistro;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta de la etiqueta aprobada del producto
     */
    protected $rutaEtiquetaAprobada;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta de la etiqueta y hoja informativa
     */
    protected $rutaEtiquetaHojaInformativa;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta de la hoja de seguridad del producto
     */
    protected $rutaProductoFormuladoTerminado;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la ruta de la ficha tecnica para bioquimicos
     */
    protected $rutaSemioquimico;
    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena el tipo de plaguicida
     */
    protected $tipoPlaguicida;

    /**
     * @var String
     * Campo requerido
     * Campo visible en el formulario
     * Campo que almacena la observacion del operador
     */
    protected $observacionOperador;

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
     * Nombre de la tabla: solicitudes_registro_productos
     *
     */
    private $tabla = "solicitudes_registro_productos";

    /**
     *Clave primaria
     */
    private $clavePrimaria = "id_solicitud_registro_producto";


    /**
     *Secuencia
     */
    private $secuencial = 'g_registro_productos"."solicitudes_registro_producto_id_solicitud_registro_product_seq';


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
            throw new \Exception('Clase Modelo: SolicitudesRegistroProductosModelo. Propiedad especificada invalida: set' . $name);
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
            throw new \Exception('Clase Modelo: SolicitudesRegistroProductosModelo. Propiedad especificada invalida: get' . $name);
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
     * Set idSolicitudRegistroProducto
     *
     *Identificador unico de la tabla
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
     * Set idTipoProducto
     *
     *Identificador unico de la tabla g_catalogos.tipos_productos
     *
     * @parámetro Integer $idTipoProducto
     * @return IdTipoProducto
     */
    public function setIdTipoProducto($idTipoProducto)
    {
        $this->idTipoProducto = (integer)$idTipoProducto;
        return $this;
    }

    /**
     * Get idTipoProducto
     *
     * @return null|Integer
     */
    public function getIdTipoProducto()
    {
        return $this->idTipoProducto;
    }

    /**
     * Set nombreTipoProducto
     *
     *Nombre del tipo de producto
     *
     * @parámetro String $nombreTipoProducto
     * @return NombreTipoProducto
     */
    public function setNombreTipoProducto($nombreTipoProducto)
    {
        $this->nombreTipoProducto = (string)$nombreTipoProducto;
        return $this;
    }

    /**
     * Get nombreTipoProducto
     *
     * @return null|String
     */
    public function getNombreTipoProducto()
    {
        return $this->nombreTipoProducto;
    }

    /**
     * Set idSubtipoProducto
     *
     *Identificador unico de la tabla g_catalogo.subtipo_productos
     *
     * @parámetro Integer $idSubtipoProducto
     * @return IdSubtipoProducto
     */
    public function setIdSubtipoProducto($idSubtipoProducto)
    {
        $this->idSubtipoProducto = (integer)$idSubtipoProducto;
        return $this;
    }

    /**
     * Get idSubtipoProducto
     *
     * @return null|Integer
     */
    public function getIdSubtipoProducto()
    {
        return $this->idSubtipoProducto;
    }

    /**
     * Set nombreSubtipoProducto
     *
     *Nombre del subtipo de producto
     *
     * @parámetro String $nombreSubtipoProducto
     * @return NombreSubtipoProducto
     */
    public function setNombreSubtipoProducto($nombreSubtipoProducto)
    {
        $this->nombreSubtipoProducto = (string)$nombreSubtipoProducto;
        return $this;
    }

    /**
     * Get nombreSubtipoProducto
     *
     * @return null|String
     */
    public function getNombreSubtipoProducto()
    {
        return $this->nombreSubtipoProducto;
    }

    /**
     * Set partidaArancelaria
     *
     *Partida arancelaria del producto
     *
     * @parámetro String $partidaArancelaria
     * @return PartidaArancelaria
     */
    public function setPartidaArancelaria($partidaArancelaria)
    {
        $this->partidaArancelaria = (string)$partidaArancelaria;
        return $this;
    }

    /**
     * Get partidaArancelaria
     *
     * @return null|String
     */
    public function getPartidaArancelaria()
    {
        return $this->partidaArancelaria;
    }

    /**
     * Set idFormulacion
     *
     *Identificador unico de la tabla g_catalogos.formulacion
     *
     * @parámetro Integer $idFormulacion
     * @return IdFormulacion
     */
    public function setIdFormulacion($idFormulacion)
    {
        $this->idFormulacion = (integer)$idFormulacion;
        return $this;
    }

    /**
     * Get idFormulacion
     *
     * @return null|Integer
     */
    public function getIdFormulacion()
    {
        return $this->idFormulacion;
    }

    /**
     * Set nombreProducto
     *
     *Nombre del producto
     *
     * @parámetro String $nombreProducto
     * @return NombreProducto
     */
    public function setNombreProducto($nombreProducto)
    {
        $this->nombreProducto = (string)$nombreProducto;
        return $this;
    }

    /**
     * Get nombreProducto
     *
     * @return null|String
     */
    public function getNombreProducto()
    {
        return $this->nombreProducto;
    }

    /**
     * Set nombreFormulacion
     *
     *Nombre de la formulacion
     *
     * @parámetro String $nombreFormulacion
     * @return NombreFormulacion
     */
    public function setNombreFormulacion($nombreFormulacion)
    {
        $this->nombreFormulacion = (string)$nombreFormulacion;
        return $this;
    }

    /**
     * Get nombreFormulacion
     *
     * @return null|String
     */
    public function getNombreFormulacion()
    {
        return $this->nombreFormulacion;
    }

    /**
     * Set dosis
     *
     *Dosis del producto
     *
     * @parámetro String $dosis
     * @return Dosis
     */
    public function setDosis($dosis)
    {
        $this->dosis = (string)$dosis;
        return $this;
    }

    /**
     * Get dosis
     *
     * @return null|String
     */
    public function getDosis()
    {
        return $this->dosis;
    }

    /**
     * Set unidadDosis
     *
     *Unidad de medida de la dosis ingresada
     *
     * @parámetro String $unidadDosis
     * @return UnidadDosis
     */
    public function setUnidadDosis($unidadDosis)
    {
        $this->unidadDosis = (string)$unidadDosis;
        return $this;
    }

    /**
     * Get unidadDosis
     *
     * @return null|String
     */
    public function getUnidadDosis()
    {
        return $this->unidadDosis;
    }

    /**
     * Set periodoReingreso
     *
     *Periodo de reingreso del producto
     *
     * @parámetro String $periodoReingreso
     * @return PeriodoReingreso
     */
    public function setPeriodoReingreso($periodoReingreso)
    {
        $this->periodoReingreso = (string)$periodoReingreso;
        return $this;
    }

    /**
     * Get periodoReingreso
     *
     * @return null|String
     */
    public function getPeriodoReingreso()
    {
        return $this->periodoReingreso;
    }

    /**
     * Set idCategoriaToxicologica
     *
     *Identificador de la categoria toxicologica
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
     *Nombre de la categoria toxicologica
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
     * Set estabilidad
     *
     *Datos de estabilidad
     *
     * @parámetro String $estabilidad
     * @return Estabilidad
     */
    public function setEstabilidad($estabilidad)
    {
        $this->estabilidad = (string)$estabilidad;
        return $this;
    }

    /**
     * Get estabilidad
     *
     * @return null|String
     */
    public function getEstabilidad()
    {
        return $this->estabilidad;
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
     * Set rutaComposicionVidaUtil
     *
     *Campo que almacena la ruta del certificado de compsocion y vida util
     *
     * @parámetro String $rutaComposicionVidaUtil
     * @return RutaComposicionVidaUtil
     */
    public function setRutaComposicionVidaUtil($rutaComposicionVidaUtil)
    {
        $this->rutaComposicionVidaUtil = (string)$rutaComposicionVidaUtil;
        return $this;
    }

    /**
     * Get rutaComposicionVidaUtil
     *
     * @return null|String
     */
    public function getRutaComposicionVidaUtil()
    {
        return $this->rutaComposicionVidaUtil;
    }

    /**
     * Set rutaAnalisisLaboratorio
     *
     *Campo que almacena la ruta del certificado de analisis de laboratorio
     *
     * @parámetro String $rutaAnalisisLaboratorio
     * @return RutaAnalisisLaboratorio
     */
    public function setRutaAnalisisLaboratorio($rutaAnalisisLaboratorio)
    {
        $this->rutaAnalisisLaboratorio = (string)$rutaAnalisisLaboratorio;
        return $this;
    }

    /**
     * Get rutaAnalisisLaboratorio
     *
     * @return null|String
     */
    public function getRutaAnalisisLaboratorio()
    {
        return $this->rutaAnalisisLaboratorio;
    }

    /**
     * Set rutaEtiqueta
     *
     *Campo que almacena la ruta de la etiqueta
     *
     * @parámetro String $rutaEtiqueta
     * @return RutaEtiqueta
     */
    public function setRutaEtiqueta($rutaEtiqueta)
    {
        $this->rutaEtiqueta = (string)$rutaEtiqueta;
        return $this;
    }

    /**
     * Get rutaEtiqueta
     *
     * @return null|String
     */
    public function getRutaEtiqueta()
    {
        return $this->rutaEtiqueta;
    }

    /**
     * Set rutaDeclaracionJuramentada
     *
     *Campo que almacena la ruta de la declaracion juramentada
     *
     * @parámetro String $rutaDeclaracionJuramentada
     * @return RutaDeclaracionJuramentada
     */
    public function setRutaDeclaracionJuramentada($rutaDeclaracionJuramentada)
    {
        $this->rutaDeclaracionJuramentada = (string)$rutaDeclaracionJuramentada;
        return $this;
    }

    /**
     * Get rutaDeclaracionJuramentada
     *
     * @return null|String
     */
    public function getRutaDeclaracionJuramentada()
    {
        return $this->rutaDeclaracionJuramentada;
    }

    /**
     * Set rutaEnvasesEmbalajes
     *
     *Campo que almacena la ruta de los envases y  embalajes
     *
     * @parámetro String $rutaEnvasesEmbalajes
     * @return RutaEnvasesEmbalajes
     */
    public function setRutaEnvasesEmbalajes($rutaEnvasesEmbalajes)
    {
        $this->rutaEnvasesEmbalajes = (string)$rutaEnvasesEmbalajes;
        return $this;
    }

    /**
     * Get rutaEnvasesEmbalajes
     *
     * @return null|String
     */
    public function getRutaEnvasesEmbalajes()
    {
        return $this->rutaEnvasesEmbalajes;
    }

    /**
     * Set rutaAnalisisComposicion
     *
     *Campo que almacena la ruta de los analisis y composiciones
     *
     * @parámetro String $rutaAnalisisComposicion
     * @return RutaAnalisisComposicion
     */
    public function setRutaAnalisisComposicion($rutaAnalisisComposicion)
    {
        $this->rutaAnalisisComposicion = (string)$rutaAnalisisComposicion;
        return $this;
    }

    /**
     * Get rutaAnalisisComposicion
     *
     * @return null|String
     */
    public function getRutaAnalisisComposicion()
    {
        return $this->rutaAnalisisComposicion;
    }

    /**
     * Set rutaOtros
     *
     *Campo que almacena la ruta de otro tipo de anexos necesarios para el registro del producto
     *
     * @parámetro String $rutaOtros
     * @return RutaOtros
     */
    public function setRutaOtros($rutaOtros)
    {
        $this->rutaOtros = (string)$rutaOtros;
        return $this;
    }

    /**
     * Get rutaOtros
     *
     * @return null|String
     */
    public function getRutaOtros()
    {
        return $this->rutaOtros;
    }

    /**
     * Set requiereDescuento
     *
     *true, no se realiza asignación de tasa automática
     *
     * @parámetro String $requiereDescuento
     * @return RequiereDescuento
     */
    public function setRequiereDescuento($requiereDescuento)
    {
        $this->requiereDescuento = (string)$requiereDescuento;
        return $this;
    }

    /**
     * Get requiereDescuento
     *
     * @return null|String
     */
    public function getRequiereDescuento()
    {
        return $this->requiereDescuento;
    }
    
    /**
     * Set pagoEnsayoEficacia
     *
     *pago ensayo eficacia
     *
     * @parámetro String $pagoEnsayoEficacia
     * @return PagoEnsayoEficacia
     */
    public function setPagoEnsayoEficacia($pagoEnsayoEficacia)
    {
        $this->pagoEnsayoEficacia = (string)$pagoEnsayoEficacia;
        return $this;
    }
    
    /**
     * Get pagoEnsayoEficacia
     *
     * @return null|String
     */
    public function getPagoEnsayoEficacia()
    {
        return $this->pagoEnsayoEficacia;
    }

    /**
     * Set provinciaOperador
     *
     *
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
     * Set fechaConfirmacionPago
     *
     *Campo que almacena la fecha de confirmacion de la solicitud
     *
     * @parámetro Date $fechaConfirmacionPago
     * @return FechaConfirmacionPago
     */
    public function setFechaConfirmacionPago($fechaConfirmacionPago)
    {
        $this->fechaConfirmacionPago = (string)$fechaConfirmacionPago;
        return $this;
    }

    /**
     * Get fechaConfirmacionPago
     *
     * @return null|Date
     */
    public function getFechaConfirmacionPago()
    {
        return $this->fechaConfirmacionPago;
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
     * Set identificadorRevisor
     *
     *Campo que almacea el identificador del técnico que realiza la inspeccion
     *
     * @parámetro String $identificadorRevisor
     * @return IdentificadorRevisor
     */
    public function setIdentificadorRevisor($identificadorRevisor)
    {
        $this->identificadorRevisor = (string)$identificadorRevisor;
        return $this;
    }

    /**
     * Get identificadorRevisor
     *
     * @return null|String
     */
    public function getIdentificadorRevisor()
    {
        return $this->identificadorRevisor;
    }

    /**
     * Set observacionRevisor
     *
     *Observacion del revisor en el proceso de revision tecnica
     *
     * @parámetro String $observacionRevisor
     * @return ObservacionRevisor
     */
    public function setObservacionRevisor($observacionRevisor)
    {
        $this->observacionRevisor = (string)$observacionRevisor;
        return $this;
    }

    /**
     * Get observacionRevisor
     *
     * @return null|String
     */
    public function getObservacionRevisor()
    {
        return $this->observacionRevisor;
    }

    /**
     * Set rutaRevisor
     *
     *Ruta a documento con las observaciones del proceso de revision tecnica
     *
     * @parámetro String $rutaRevisor
     * @return RutaRevisor
     */
    public function setRutaRevisor($rutaRevisor)
    {
        $this->rutaRevisor = (string)$rutaRevisor;
        return $this;
    }

    /**
     * Get rutaRevisor
     *
     * @return null|String
     */
    public function getRutaRevisor()
    {
        return $this->rutaRevisor;
    }

    /**
     * Set resultadoRevisor
     *
     *Campo que almacena el resultado de la revision tecnica
     *
     * @parámetro String $resultadoRevisor
     * @return ResultadoRevisor
     */
    public function setResultadoRevisor($resultadoRevisor)
    {
        $this->resultadoRevisor = (string)$resultadoRevisor;
        return $this;
    }

    /**
     * Get resultadoRevisor
     *
     * @return null|String
     */
    public function getResultadoRevisor()
    {
        return $this->resultadoRevisor;
    }

    /**
     * Set tipoSolicitud
     *
     *Tipo de solicitud de registro de producto
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
     * Set rutaCertificado
     *
     *Ruta de certificado de registro de producto aprobado
     *
     * @parámetro String $rutaCertificado
     * @return RutaCertificado
     */
    public function setRutaCertificado($rutaCertificado)
    {
        $this->rutaCertificado = (string)$rutaCertificado;
        return $this;
    }

    /**
     * Get rutaCertificado
     *
     * @return null|String
     */
    public function getRutaCertificado()
    {
        return $this->rutaCertificado;
    }

    /**
     * Set idProducto
     *
     *Identificador unico de la tabla g_catalogo.productos
     *
     * @parámetro Integer $idProducto
     * @return IdProducto
     */
    public function setIdProducto($idProducto)
    {
        $this->idProducto = (integer)$idProducto;
        return $this;
    }

    /**
     * Get idProducto
     *
     * @return null|Integer
     */
    public function getIdProducto()
    {
        return $this->idProducto;
    }

    /**
     * Set nombreComun
     *
     *Nombre del producto al cual se relacionado el producto clon
     *
     * @parámetro String $nombreComun
     * @return NombreComun
     */
    public function setNombreComun($nombreComun)
    {
        $this->nombreComun = (string)$nombreComun;
        return $this;
    }

    /**
     * Get nombreComun
     *
     * @return null|String
     */
    public function getNombreComun()
    {
        return $this->nombreComun;
    }

    /**
     * Set numeroRegistro
     *
     *Numero de registro del producto
     *
     * @parámetro String $numeroRegistro
     * @return NumeroRegistro
     */
    public function setNumeroRegistro($numeroRegistro)
    {
        $this->numeroRegistro = (string)$numeroRegistro;
        return $this;
    }

    /**
     * Get numeroRegistro
     *
     * @return null|String
     */
    public function getNumeroRegistro()
    {
        return $this->numeroRegistro;
    }

    /**
     * Set rutaEtiquetaAprobada
     *
     *Campo que almacena la ruta de la etiqueta aprobada del producto
     *
     * @parámetro String $rutaEtiquetaAprobada
     * @return RutaEtiquetaAprobada
     */
    public function setRutaEtiquetaAprobada($rutaEtiquetaAprobada)
    {
        $this->rutaEtiquetaAprobada = (string)$rutaEtiquetaAprobada;
        return $this;
    }

    /**
     * Get rutaEtiquetaAprobada
     *
     * @return null|String
     */
    public function getRutaEtiquetaAprobada()
    {
        return $this->rutaEtiquetaAprobada;
    }

    /**
     * Set rutaEtiquetaHojaInformativa
     *
     *Campo que almacena la ruta de la etiqueta y hoja informativa
     *
     * @parámetro String $rutaEtiquetaHojaInformativa
     * @return RutaEtiquetaHojaInformativa
     */
    public function setRutaEtiquetaHojaInformativa($rutaEtiquetaHojaInformativa)
    {
        $this->rutaEtiquetaHojaInformativa = (string)$rutaEtiquetaHojaInformativa;
        return $this;
    }

    /**
     * Get rutaEtiquetaHojaInformativa
     *
     * @return null|String
     */
    public function getRutaEtiquetaHojaInformativa()
    {
        return $this->rutaEtiquetaHojaInformativa;
    }

    /**
     * Set rutaProductoFormuladoTerminado
     *
     *Campo que almacena la ruta de la hoja de seguridad del producto
     *
     * @parámetro String $rutaProductoFormuladoTerminado
     * @return RutaProductoFormuladoTerminado
     */
    public function setRutaProductoFormuladoTerminado($rutaProductoFormuladoTerminado)
    {
        $this->rutaProductoFormuladoTerminado = (string)$rutaProductoFormuladoTerminado;
        return $this;
    }

    /**
     * Get rutaProductoFormuladoTerminado
     *
     * @return null|String
     */
    public function getRutaProductoFormuladoTerminado()
    {
        return $this->rutaProductoFormuladoTerminado;
    }

    /**
     * Set rutaSemioquimico
     *
     *Campo que almacena la ruta de la ficha tecnica para bioquimicos
     *
     * @parámetro String $rutaSemioquimico
     * @return RutaSemioquimico
     */
    public function setRutaSemioquimico($rutaSemioquimico)
    {
        $this->rutaSemioquimico = (string)$rutaSemioquimico;
        return $this;
    }

    /**
     * Get rutaSemioquimico
     *
     * @return null|String
     */
    public function getRutaSemioquimico()
    {
        return $this->rutaSemioquimico;
    }

    /**
     * Set tipoPlaguicida
     *
     *Campo que almacena el tipo de plaguicida
     *
     * @parámetro String $tipoPlaguicida
     * @return TipoPlaguicida
     */
    public function setTipoPlaguicida($tipoPlaguicida)
    {
        $this->tipoPlaguicida = (string)$tipoPlaguicida;
        return $this;
    }

    /**
     * Get rutaSemioquimico
     *
     * @return null|String
     */
    public function getTipoPlaguicida()
    {
        return $this->tipoPlaguicida;
    }

    /**
     * Set observacionOperador
     *
     * @parámetro String $observacionOperador
     * @return ObservacionOperador
     */
    public function setObservacionOperador($observacionOperador)
    {
        $this->observacionOperador = (string) $observacionOperador;
        return $this;
    }

    /**
     * Get observacionOperador
     *
     * @return null|String
     */
    public function getObservacionOperador()
    {
        return $this->observacionOperador;
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
     * @return SolicitudesRegistroProductosModelo
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
