<?php
/**
 * Lógica del negocio de SolicitudesRegistroProductosModelo
 *
 * Este archivo se complementa con el archivo SolicitudesRegistroProductosControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-20
 * @uses    SolicitudesRegistroProductosLogicaNegocio
 * @package RegistroProductoRia
 * @subpackage Modelos
 */

namespace Agrodb\RegistroProductoRia\Modelos;

use Agrodb\Catalogos\Modelos\CodigosAdicionalesPartidasLogicaNegocio;
use Agrodb\Catalogos\Modelos\CodigosInocuidadLogicaNegocio;
use Agrodb\Catalogos\Modelos\ComposicionInocuidadLogicaNegocio;
use Agrodb\Catalogos\Modelos\FabricanteFormuladorLogicaNegocio;
use Agrodb\Catalogos\Modelos\ProductoInocuidadUsoLogicaNegocio;
use Agrodb\Catalogos\Modelos\ProductosInocuidadLogicaNegocio;
use Agrodb\Catalogos\Modelos\ProductosLogicaNegocio;
use Agrodb\Core\Constantes;
use Agrodb\Core\JasperReport;
use Agrodb\FirmaDocumentos\Modelos\DocumentosLogicaNegocio;
use Agrodb\RegistroOperador\Modelos\OperadoresLogicaNegocio;
use Agrodb\RegistroProductoRia\Modelos\IModelo;
use Agrodb\Catalogos\Modelos\PartidasArancelariasLogicaNegocio;
use Agrodb\Catalogos\Modelos\CodigosCompSuplLogicaNegocio;
use Agrodb\Catalogos\Modelos\PresentacionesPlaguicidasLogicaNegocio;
use Agrodb\Catalogos\Modelos\ManufacturadorLogicaNegocio;
use Agrodb\Catalogos\Modelos\UsosProductosPlaguicidasLogicaNegocio;

class SolicitudesRegistroProductosLogicaNegocio implements IModelo
{

    private $modeloSolicitudesRegistroProductos = null;
    private $rutaFecha = null;

    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloSolicitudesRegistroProductos = new SolicitudesRegistroProductosModelo();
        $this->rutaFecha = date('Y') . '/' . date('m') . '/' . date('d');
    }

    /**
     * Guarda el registro actual
     * @param array $datos
     * @return int
     */
    public function guardar(array $datos)
    {
        $tablaModelo = new SolicitudesRegistroProductosModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdSolicitudRegistroProducto() != null && $tablaModelo->getIdSolicitudRegistroProducto() > 0) {
            return $this->modeloSolicitudesRegistroProductos->actualizar($datosBd, $tablaModelo->getIdSolicitudRegistroProducto());
        } else {
            unset($datosBd["id_solicitud_registro_producto"]);
            $numeroSolicitud = $this->generarNumeroSolicitud($datosBd['tipo_solicitud']);
            $datosBd["numero_solicitud"] = $numeroSolicitud->current()->f_generar_numero_solicitud;
            return $this->modeloSolicitudesRegistroProductos->guardar($datosBd);
        }
    }

    /**
     * Borra el registro actual
     * @param string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modeloSolicitudesRegistroProductos->borrar($id);
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
        return $this->modeloSolicitudesRegistroProductos->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloSolicitudesRegistroProductos->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloSolicitudesRegistroProductos->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarSolicitudesRegistroProductos()
    {
        $consulta = "SELECT * FROM " . $this->modeloSolicitudesRegistroProductos->getEsquema() . ". solicitudes_registro_productos";
        return $this->modeloSolicitudesRegistroProductos->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarFiltroSolicitudesRegistroProductos($arrayParametros)
    {
        $identificador = $arrayParametros['identificador'] != "" ? "'" . $arrayParametros['identificador'] . "'" : "NULL";
        $identificadorRevisor = $arrayParametros['identificador_revisor'] != "" ? "'" . $arrayParametros['identificador_revisor'] . "'" : "NULL";
        $nombreProducto = $arrayParametros['nombreProducto'] != "" ? "'%" . $arrayParametros['nombreProducto'] . "%'" : "NULL";
        $estadoSolicitud = $arrayParametros['estadoSolicitud'] != "" ? $arrayParametros['estadoSolicitud'] : "NULL";
        $numeroSolicitud = $arrayParametros['numeroSolicitud'] != "" ? "'" . $arrayParametros['numeroSolicitud'] . "'" : "NULL";
        $tipoSolicitud = $arrayParametros['tipoSolicitud'] != "" ? "'" . $arrayParametros['tipoSolicitud'] . "'" : "NULL";
        $fecha = $arrayParametros['fecha'] != "" ? "'" . $arrayParametros['fecha'] . "'" : "NULL";

        $consulta = "SELECT
                        s.id_solicitud_registro_producto,
                        s.tipo_solicitud,
                        s.nombre_tipo_producto,
                        s.nombre_subtipo_producto,
                        s.nombre_producto,
                        s.fecha_creacion,
                        s.razon_social,                        
                        s.estado,
                        s.numero_solicitud,
                        s.identificador_revisor,
                        s.fecha_confirmacion_pago,
                        fe.nombre ||' '||fe.apellido as nombre_revisor
                     FROM 
                        g_registro_productos.solicitudes_registro_productos s
                        LEFT JOIN g_uath.ficha_empleado fe ON fe.identificador = s.identificador_revisor
					 WHERE
                        ($identificador is NULL or s.identificador_operador = $identificador)
                        and ($identificadorRevisor is NULL or s.identificador_revisor = $identificadorRevisor)
                        and ($nombreProducto is NULL or s.nombre_producto ilike $nombreProducto)
                        and (($estadoSolicitud) is NULL or s.estado IN ($estadoSolicitud))
                        and ($numeroSolicitud is NULL or s.numero_solicitud = $numeroSolicitud)
						and ($tipoSolicitud is NULL or s.tipo_solicitud = $tipoSolicitud)																 
                        and ($fecha is NULL or to_char(s.fecha_creacion,'YYYY-MM-DD') = $fecha)  
                    ORDER BY s.fecha_creacion ASC";

        return $this->modeloSolicitudesRegistroProductos->ejecutarSqlNativo($consulta);
    }

    /**
     * Consulta datos del operador .
     *
     * @return Operadores
     */
    public function obtenerDatosOperador($identificador)
    {
        $lNegocioOperadores = new OperadoresLogicaNegocio();

        return $lNegocioOperadores->buscar($identificador);

    }

    /**
     * Genera nuero de soliciud.
     *
     * @return array|ResultSet
     */
    public function generarNumeroSolicitud($tipoSolicitud)
    {
        $consulta = "SELECT * FROM g_registro_productos.f_generar_numero_solicitud('$tipoSolicitud');";

        return $this->modeloSolicitudesRegistroProductos->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada para actualizar
     * los datos del estado de la solicitud.
     *
     * @return array|ResultSet
     */
    public function actualizarEstadoSolictudRegistroProducto($arrayParametros)
    {
        $idSolicitudRegistroProducto = $arrayParametros['id_solicitud_registro_producto'];
        $estado = $arrayParametros['estado'];
        $identificadorRevisor = $arrayParametros['identificador_revisor'];

        $consulta = "UPDATE
                    	g_registro_productos.solicitudes_registro_productos
                    SET
                    	estado = '" . $estado . "',
                    	identificador_revisor = '" . $identificadorRevisor . "'
                    WHERE
                    	id_solicitud_registro_producto = '" . $idSolicitudRegistroProducto . "';";

        return $this->modeloSolicitudesRegistroProductos->ejecutarSqlNativo($consulta);
    }

    public function guardarDatosProducto($idSolicitudRegistroProducto, $rutaResultadoRevision)
    {
        $solicitudRegistroProducto = $this->buscar($idSolicitudRegistroProducto);

        $tipoSolicitud = $solicitudRegistroProducto->getTipoSolicitud();

        $datosRegistro = [
            'id_solicitud_registro_producto' => $idSolicitudRegistroProducto
        ];

        switch ($tipoSolicitud) {
            case 'fertilizantes':

                //Guardar datos de producto
                $lNegocioProductos = new ProductosLogicaNegocio();
                $nombreProducto = $solicitudRegistroProducto->getNombreProducto();
                $partidaArancelaria = $solicitudRegistroProducto->getPartidaArancelaria();
                $codigoProducto = $lNegocioProductos->generarCodigoProductoPartida($partidaArancelaria);
                $idSubtipoProducto = $solicitudRegistroProducto->getIdSubtipoProducto();

                $datosProducto = [
                    'nombre_comun' => $nombreProducto,
                    'partida_arancelaria' => $partidaArancelaria,
                    'codigo_producto' => $codigoProducto,
                    'ruta' => $rutaResultadoRevision,
                    'id_subtipo_producto' => $idSubtipoProducto,
                    'identificador_creacion' => 'G.U.I.A',
                ];

                $idProducto = $lNegocioProductos->guardar($datosProducto);

                //Guardar datos de producto inocuidad
                $idFormulacion = $solicitudRegistroProducto->getIdFormulacion();
                $nombreFormulacion = $solicitudRegistroProducto->getNombreFormulacion();
                $numeroRegistro = $solicitudRegistroProducto->getNumeroSolicitud();
                $dosis = $solicitudRegistroProducto->getDosis();
                $unidadDosis = $solicitudRegistroProducto->getUnidadDosis();
                $periodoReingreso = $solicitudRegistroProducto->getPeriodoReingreso();
                $observacion = 'Producto creado automáticamente debido a la aprobación de la solicitud de Registro de producto agrícola Nro. ' . $numeroRegistro;
                $identificadorOperador = $solicitudRegistroProducto->getIdentificadorOperador();

                $datosProductoInocuidad = [
                    'id_producto' => $idProducto,
                    'id_formulacion' => $idFormulacion,
                    'formulacion' => $nombreFormulacion,
                    'numero_registro' => $numeroRegistro,
                    'dosis' => $dosis,
                    'unidad_dosis' => $unidadDosis,
                    'periodo_reingreso' => $periodoReingreso,
                    'observacion' => $observacion,
                    'fecha_registro' => 'now()',
                    'id_operador' => $identificadorOperador,
                    'id_declaracion_venta' => 1,
                    'declaracion_venta' => 'Venta libre',
                ];

                $lNegocioProductosInocuidad = new ProductosInocuidadLogicaNegocio();
                $lNegocioProductosInocuidad->guardarProductoInocuidad($datosProductoInocuidad);

                //Datos de composicion
                $lNegocioComposicionInocuidad = new ComposicionInocuidadLogicaNegocio();
                $lNegocioComposiciones = new ComposicionesLogicaNegocio();

                $datosComposiciones = $lNegocioComposiciones->buscarLista($datosRegistro);

                foreach ($datosComposiciones as $composicion) {

                    $datosComposicion = [
                        'id_producto' => $idProducto,
                        'id_ingrediente_activo' => $composicion->id_ingrediente_activo,
                        'concentracion' => $composicion->concentracion,
                        'ingrediente_activo' => $composicion->ingrediente_activo,
                        'unidad_medida' => $composicion->unidad_medida,
                        'id_tipo_componente' => $composicion->id_tipo_componente,
                        'tipo_componente' => $composicion->tipo_componente
                    ];

                    $lNegocioComposicionInocuidad->guardar($datosComposicion);
                }

                //Datos codigo complementario suplementario
                $lNegocioCodigosAdicionalesPartida = new CodigosAdicionalesPartidasLogicaNegocio();
                $lNegocioCodigosComplementariosSuplementarios = new CodigosComplementariosSuplementariosLogicaNegocio();

                $datosCodigosComplemenariosSuplementarios = $lNegocioCodigosComplementariosSuplementarios->buscarLista($datosRegistro);

                foreach ($datosCodigosComplemenariosSuplementarios as $codigoComplementarioSuplementario) {

                    $datosCodigoComplementarioSuplementario = [
                        'id_producto' => $idProducto,
                        'codigo_complementario' => $codigoComplementarioSuplementario->codigo_complementario,
                        'codigo_suplementario' => $codigoComplementarioSuplementario->codigo_suplementario,
                    ];

                    $lNegocioCodigosAdicionalesPartida->guardarCodigoComplementarioSuplementario($datosCodigoComplementarioSuplementario);
                }

                //Datos presentacion
                $lNegocioCodigosInocuidad = new CodigosInocuidadLogicaNegocio();
                $lNegocioPresentaciones = new PresentacionesLogicaNegocio();

                $datosPresentaciones = $lNegocioPresentaciones->buscarLista($datosRegistro);

                foreach ($datosPresentaciones as $datoPresentacion) {
                    $datosPresentacion = [
                        'id_producto' => $idProducto,
                        'subcodigo' => $datoPresentacion->subcodigo,
                        'presentacion' => $datoPresentacion->presentacion,
                        'unidad_medida' => $datoPresentacion->unidad_medida,
                    ];

                    $lNegocioCodigosInocuidad->guardarProductoRIA($datosPresentacion);
                }

                //Datos fabricante formulador
                $lNegocioFabricanteFormulador = new FabricanteFormuladorLogicaNegocio();
                $lNegocioFabricantesFormuladores = new FabricantesFormuladoresLogicaNegocio();

                $datosFabricantesFormuladores = $lNegocioFabricantesFormuladores->buscarLista($datosRegistro);

                foreach ($datosFabricantesFormuladores as $fabricanteFormulador) {
                    $datosActualizacion = [
                        'id_producto' => $idProducto,
                        'nombre' => $fabricanteFormulador->nombre,
                        'tipo' => $fabricanteFormulador->tipo,
                        'id_pais_origen' => $fabricanteFormulador->id_pais_origen,
                        'pais_origen' => $fabricanteFormulador->pais_origen
                    ];

                    $lNegocioFabricanteFormulador->guardar($datosActualizacion);
                }

                //Datos Uso
                $lNegocioProductoInocuidadUso = new ProductoInocuidadUsoLogicaNegocio();
                $lNegocioUsos = new UsosLogicaNegocio();

                $datosUsos = $lNegocioUsos->buscarLista($datosRegistro);

                foreach ($datosUsos as $uso) {

                    $datosUso = [
                        'id_producto' => $idProducto,
                        'id_uso' => $uso->id_uso_aplicado,
                        'aplicado_a' => ($uso->aplicado_a == 'Producto' ? 'Instalacion' : $uso->aplicado_a),
                        'instalacion' => $uso->instalacion,
                    ];

                    $lNegocioProductoInocuidadUso->guardar($datosUso);
                }

                //Generacion de certificado

                $datos = [
                    'tipo_solicitud' => $tipoSolicitud,
                    'id_producto' => $idProducto,
                    'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                ];

                $rutaCertificado = $this->generarCertificado($datos);

                break;

            case 'bioplaguicidas':

                //Guardar datos de producto
                $lNegocioProductos = new ProductosLogicaNegocio();
                $nombreProducto = $solicitudRegistroProducto->getNombreProducto();
                $idSubtipoProducto = $solicitudRegistroProducto->getIdSubtipoProducto();

                $datosProducto = [
                    'nombre_comun' => $nombreProducto,
                    'ruta' => $rutaResultadoRevision,
                    'id_subtipo_producto' => $idSubtipoProducto,
                    'identificador_creacion' => 'G.U.I.A',
                ];

                $idProducto = $lNegocioProductos->guardar($datosProducto);

                //Guardar datos de producto inocuidad
                $idFormulacion = $solicitudRegistroProducto->getIdFormulacion();
                $nombreFormulacion = $solicitudRegistroProducto->getNombreFormulacion();
                $numeroRegistro = $solicitudRegistroProducto->getNumeroSolicitud();
                $idCategoriaToxicologica = $solicitudRegistroProducto->getIdCategoriaToxicologica();
                $categoriaToxicologica = $solicitudRegistroProducto->getNombreCategoriaToxicologica();
                $periodoReingreso = $solicitudRegistroProducto->getPeriodoReingreso();
                $estabilidad = $solicitudRegistroProducto->getEstabilidad();
                $observacion = 'Producto creado automáticamente debido a la aprobación de la solicitud de Registro de producto agrícola Nro. ' . $numeroRegistro;
                $identificadorOperador = $solicitudRegistroProducto->getIdentificadorOperador();

                $datosProductoInocuidad = [
                    'id_producto' => $idProducto,
                    'id_formulacion' => $idFormulacion,
                    'formulacion' => $nombreFormulacion,
                    'numero_registro' => $numeroRegistro,
                    'id_categoria_toxicologica' => $idCategoriaToxicologica,
                    'categoria_toxicologica' => $categoriaToxicologica,
                    'periodo_reingreso' => $periodoReingreso,
                    'estabilidad' => $estabilidad,
                    'observacion' => $observacion,
                    'fecha_registro' => 'now()',
                    'id_operador' => $identificadorOperador,
                    'id_declaracion_venta' => 1,
                    'declaracion_venta' => 'Venta libre',
                ];

                $lNegocioProductosInocuidad = new ProductosInocuidadLogicaNegocio();
                $lNegocioProductosInocuidad->guardarProductoInocuidad($datosProductoInocuidad);

                //Guardar partida arancelaria
                $lNegocioPartidasArancelariasPlaguicidasBio = new PartidasArancelariasPlaguicidasBioLogicaNegocio();
                $lNegocioPartidasArancelarias = new PartidasArancelariasLogicaNegocio();

                $lNegocioCodigosComplementariosSuplementariosPlaguicidasBio = new CodigosComplementariosSuplementariosPlaguicidasBioLogicaNegocio();
                $lNegocioCodigosComplementariosSuplementarios = new CodigosCompSuplLogicaNegocio();

                $lNegocioPresentacionesPlaguicidasBio = new PresentacionesPlaguicidasBioLogicaNegocio();
                $lNegocioPresentaciones = new PresentacionesPlaguicidasLogicaNegocio();

                $datosPartidasArancelarias = $lNegocioPartidasArancelariasPlaguicidasBio->buscarLista($datosRegistro);

                foreach ($datosPartidasArancelarias as $partidasArancelarias) {

                    $codigoProducto = '';
                    $idPartidaArancelariaBio = $partidasArancelarias['id_partida_arancelaria'];
                    $partidaArancelaria = $partidasArancelarias['partida_arancelaria'];
                    $codigoProductoAnterior = $lNegocioProductos->generarCodigoProductoPartida($partidaArancelaria);
                    $codigoProductoPlaguicida = $lNegocioProductos->generarCodigoProductoPartidaPlaguicida($partidaArancelaria);

                    if ($codigoProductoAnterior > $codigoProductoPlaguicida) {
                        $codigoProducto = $codigoProductoAnterior;
                    } else {
                        $codigoProducto = $codigoProductoPlaguicida;
                    }

                    $datosPartidaArancelaria = [
                        'id_producto' => $idProducto,
                        'partida_arancelaria' => $partidaArancelaria,
                        'codigo_producto' => $codigoProducto
                    ];

                    $idPartidaArancelaria = $lNegocioPartidasArancelarias->guardar($datosPartidaArancelaria);

                    //Guardar codigos complementarios suplementarios plaguicidas                    
                    $datosCodigosComplemenariosSuplementariosPlaguicidas = $lNegocioCodigosComplementariosSuplementariosPlaguicidasBio->buscarLista(['id_partida_arancelaria' => $idPartidaArancelariaBio]);

                    foreach ($datosCodigosComplemenariosSuplementariosPlaguicidas as $codigosComplementariosSuplementariosPlaguicidas) {

                        $idCodigoComplementarioSuplementarioBio = $codigosComplementariosSuplementariosPlaguicidas['id_codigo_complementario_suplementario'];

                        $datosCodigoComplementarioSuplementarioPlaguicida = [
                            'id_partida_arancelaria' => $idPartidaArancelaria,
                            'codigo_complementario' => $codigosComplementariosSuplementariosPlaguicidas['codigo_complementario'],
                            'codigo_suplementario' => $codigosComplementariosSuplementariosPlaguicidas['codigo_suplementario']
                        ];

                        $idCodigoComplementarioSuplementario = $lNegocioCodigosComplementariosSuplementarios->guardar($datosCodigoComplementarioSuplementarioPlaguicida);

                        //Guardar presentaciones plaguicidas
                        $datosPresentacionesPlaguicidas = $lNegocioPresentacionesPlaguicidasBio->buscarLista(['id_codigo_complementario_suplementario' => $idCodigoComplementarioSuplementarioBio]);

                        foreach ($datosPresentacionesPlaguicidas as $presentacionesPlaguicidas) {

                            $codigoPresentacion = $lNegocioProductos->generarCodigoPresentacionPlaguicida($idProducto, $idPartidaArancelaria, $idCodigoComplementarioSuplementario);

                            $datosPresentacionPlaguicida = [
                                'id_codigo_comp_supl' => $idCodigoComplementarioSuplementario,
                                'presentacion' => $presentacionesPlaguicidas['presentacion'],
                                'codigo_presentacion' => $codigoPresentacion,
                                'id_unidad' => $presentacionesPlaguicidas['id_unidad'],
                                'unidad' => $presentacionesPlaguicidas['unidad']
                            ];

                            $lNegocioPresentaciones->guardar($datosPresentacionPlaguicida);

                        }

                    }

                }

                //Guardar composicion
                $lNegocioComposicionInocuidad = new ComposicionInocuidadLogicaNegocio();
                $lNegocioComposiciones = new ComposicionesLogicaNegocio();

                $datosComposiciones = $lNegocioComposiciones->buscarLista($datosRegistro);

                foreach ($datosComposiciones as $composicion) {

                    $datosComposicion = [
                        'id_producto' => $idProducto,
                        'id_ingrediente_activo' => $composicion->id_ingrediente_activo,
                        'concentracion' => $composicion->concentracion,
                        'ingrediente_activo' => $composicion->ingrediente_activo,
                        'unidad_medida' => $composicion->unidad_medida,
                        'id_tipo_componente' => $composicion->id_tipo_componente,
                        'tipo_componente' => $composicion->tipo_componente
                    ];

                    $lNegocioComposicionInocuidad->guardar($datosComposicion);

                }

                //Guardar fabricante formulador
                $lNegocioFabricanteFormulador = new FabricanteFormuladorLogicaNegocio();
                $lNegocioFabricantesFormuladores = new FabricantesFormuladoresLogicaNegocio();

                $lNegocioManufacturadoresPlaguicidasBio = new ManufacturadoresPlaguicidasBioLogicaNegocio();
                $lNegocioManufacturadores = new ManufacturadorLogicaNegocio();

                $datosFabricantesFormuladores = $lNegocioFabricantesFormuladores->buscarLista($datosRegistro);

                foreach ($datosFabricantesFormuladores as $fabricanteFormulador) {

                    $idFabricanteFormuladorBio = $fabricanteFormulador['id_fabricante_formulador'];

                    $datosFabricanteFormulador = [
                        'id_producto' => $idProducto,
                        'nombre' => $fabricanteFormulador->nombre,
                        'tipo' => $fabricanteFormulador->tipo,
                        'id_pais_origen' => $fabricanteFormulador->id_pais_origen,
                        'pais_origen' => $fabricanteFormulador->pais_origen
                    ];

                    $idFabricanteFormulador = $lNegocioFabricanteFormulador->guardar($datosFabricanteFormulador);

                    $datosManufacturadores = $lNegocioManufacturadoresPlaguicidasBio->buscarLista(['id_fabricante_formulador' => $idFabricanteFormuladorBio]);

                    foreach ($datosManufacturadores as $manufacturadores) {

                        $datosManufacturador = [
                            'id_fabricante_formulador' => $idFabricanteFormulador,
                            'manufacturador' => $manufacturadores['manufacturador'],
                            'id_pais_origen' => $manufacturadores['id_pais_origen'],
                            'pais_origen' => $manufacturadores['pais_origen']
                        ];

                        $lNegocioManufacturadores->guardar($datosManufacturador);

                    }

                }

                //Guardar usos plaguicidas bio
                $lNegocioUsosProductosPlaguicidasBio = new UsosProductosPlaguicidasBioLogicaNegocio();
                $lNegocioUsosProductosPlaguicidas = new UsosProductosPlaguicidasLogicaNegocio();

                $datosUsos = $lNegocioUsosProductosPlaguicidasBio->buscarLista($datosRegistro);

                foreach ($datosUsos as $uso) {

                    $datosUso = [
                        'id_producto' => $idProducto,
                        'id_plaga' => $uso->id_plaga,
                        'plaga_nombre_comun' => $uso->plaga_nombre_comun,
                        'plaga_nombre_cientifico' => $uso->plaga_nombre_cientifico,
                        'id_cultivo' => $uso->id_cultivo,
                        'cultivo_nombre_comun' => $uso->cultivo_nombre_comun,
                        'cultivo_nombre_cientifico' => $uso->cultivo_nombre_cientifico,
                        'dosis' => $uso->dosis,
                        'unidad_dosis' => $uso->unidad_dosis,
                        'periodo_carencia' => $uso->periodo_carencia,
                        'gasto_agua' => $uso->gasto_agua,
                        'unidad_gasto_agua' => $uso->unidad_gasto_agua
                    ];

                    $lNegocioUsosProductosPlaguicidas->guardar($datosUso);

                }

                $datos = [
                    'tipo_solicitud' => $tipoSolicitud,
                    'id_producto' => $idProducto,
                    'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                ];

                $rutaCertificado = $this->generarCertificado($datos);

                break;

            case 'clonesfertilizantes':

                //Guardar datos de producto
                $lNegocioProductos = new ProductosLogicaNegocio();

                $nombreProducto = $solicitudRegistroProducto->getNombreProducto();
                $idSubtipoProducto = $solicitudRegistroProducto->getIdSubtipoProducto();
                $idProductoOrigen = $solicitudRegistroProducto->getIdProducto();

                $productoOrigen = $lNegocioProductos->buscar($idProductoOrigen);
                $codigoProducto = $lNegocioProductos->generarCodigoProductoPartida($productoOrigen->getPartidaArancelaria()=='' ? 0 : $productoOrigen->getPartidaArancelaria());

                $datosProducto = [
                    'nombre_comun' => $nombreProducto,
                    'partida_arancelaria' => $productoOrigen->getPartidaArancelaria(),
                    'codigo_producto' => $codigoProducto,
                    'ruta' => $rutaResultadoRevision,
                    'id_subtipo_producto' => $idSubtipoProducto,
                    'identificador_creacion' => 'G.U.I.A',
                ];

                $idProducto = $lNegocioProductos->guardar($datosProducto);

                $lNegocioProductosInocuidad = new ProductosInocuidadLogicaNegocio();
                $productoInocuidadOrigen = $lNegocioProductosInocuidad->buscar($idProductoOrigen);
                $nuevoNumeroRegistro = $this->generarNumeroClon(date('Y'));

                //Guardar datos de producto inocuidad
                $idFormulacion = $productoInocuidadOrigen->getIdFormulacion();
                $nombreFormulacion = $productoInocuidadOrigen->getFormulacion();
                $numeroRegistro = $productoInocuidadOrigen->getNumeroRegistro().'-CL-'.date('Y').'-'.str_pad($nuevoNumeroRegistro->current()->numero, 4, "0", STR_PAD_LEFT);
                $dosis = $productoInocuidadOrigen->getDosis();
                $unidadDosis = $productoInocuidadOrigen->getUnidadDosis();
                $periodoReingreso = $productoInocuidadOrigen->getPeriodoReingreso();
                $observacion = 'Producto creado automáticamente debido a la aprobación de la solicitud de Registro de producto clon fertilizantes Nro. ' . $numeroRegistro;
                $identificadorOperador = $solicitudRegistroProducto->getIdentificadorOperador();

                $datosProductoInocuidad = [
                    'id_producto' => $idProducto,
                    'id_formulacion' => $idFormulacion,
                    'formulacion' => $nombreFormulacion,
                    'numero_registro' => $numeroRegistro,
                    'dosis' => $dosis,
                    'unidad_dosis' => $unidadDosis,
                    'periodo_reingreso' => $periodoReingreso,
                    'observacion' => $observacion,
                    'fecha_registro' => 'now()',
                    'id_operador' => $identificadorOperador,
                    'id_declaracion_venta' => 1,
                    'declaracion_venta' => 'Venta libre',
                ];

                $lNegocioProductosInocuidad->guardarProductoInocuidad($datosProductoInocuidad);

                //Datos de composicion
                $lNegocioComposicionInocuidad = new ComposicionInocuidadLogicaNegocio();

                $datosComposiciones = $lNegocioComposicionInocuidad->buscarLista(['id_producto' => $idProductoOrigen]);

                foreach ($datosComposiciones as $composicion) {

                    $datosComposicion = [
                        'id_producto' => $idProducto,
                        'id_ingrediente_activo' => $composicion->id_ingrediente_activo,
                        'concentracion' => $composicion->concentracion,
                        'ingrediente_activo' => $composicion->ingrediente_activo,
                        'unidad_medida' => $composicion->unidad_medida,
                        'id_tipo_componente' => $composicion->id_tipo_componente,
                        'tipo_componente' => $composicion->tipo_componente
                    ];

                    $lNegocioComposicionInocuidad->guardar($datosComposicion);
                }

                //Datos codigo complementario suplementario
                $lNegocioCodigosAdicionalesPartida = new CodigosAdicionalesPartidasLogicaNegocio();

                $datosCodigosComplemenariosSuplementarios = $lNegocioCodigosAdicionalesPartida->buscarLista(['id_producto' => $idProductoOrigen]);

                foreach ($datosCodigosComplemenariosSuplementarios as $codigoComplementarioSuplementario) {

                    $datosCodigoComplementarioSuplementario = [
                        'id_producto' => $idProducto,
                        'codigo_complementario' => $codigoComplementarioSuplementario->codigo_complementario,
                        'codigo_suplementario' => $codigoComplementarioSuplementario->codigo_suplementario,
                    ];

                    $lNegocioCodigosAdicionalesPartida->guardarCodigoComplementarioSuplementario($datosCodigoComplementarioSuplementario);
                }

                //Datos presentacion
                $lNegocioCodigosInocuidad = new CodigosInocuidadLogicaNegocio();

                $datosPresentaciones = $lNegocioCodigosInocuidad->buscarLista(['id_producto' => $idProductoOrigen]);

                foreach ($datosPresentaciones as $datoPresentacion) {
                    $datosPresentacion = [
                        'id_producto' => $idProducto,
                        'subcodigo' => $datoPresentacion->subcodigo,
                        'presentacion' => $datoPresentacion->presentacion,
                        'unidad_medida' => $datoPresentacion->unidad_medida,
                    ];

                    $lNegocioCodigosInocuidad->guardarProductoRIA($datosPresentacion);
                }

                //Datos fabricante formulador
                $lNegocioFabricanteFormulador = new FabricanteFormuladorLogicaNegocio();

                $datosFabricantesFormuladores = $lNegocioFabricanteFormulador->buscarLista(['id_producto' => $idProductoOrigen]);

                foreach ($datosFabricantesFormuladores as $fabricanteFormulador) {
                    $datosActualizacion = [
                        'id_producto' => $idProducto,
                        'nombre' => $fabricanteFormulador->nombre,
                        'tipo' => $fabricanteFormulador->tipo,
                        'id_pais_origen' => $fabricanteFormulador->id_pais_origen,
                        'pais_origen' => $fabricanteFormulador->pais_origen
                    ];

                    $lNegocioFabricanteFormulador->guardar($datosActualizacion);
                }

                //Datos Uso
                $lNegocioProductoInocuidadUso = new ProductoInocuidadUsoLogicaNegocio();

                $datosUsos = $lNegocioProductoInocuidadUso->buscarLista(['id_producto' => $idProductoOrigen]);

                foreach ($datosUsos as $uso) {

                    $datosUso = [
                        'id_producto' => $idProducto,
                        'id_uso' => $uso->id_uso,

                        'aplicado_a' => $uso->aplicado_a,
                        'instalacion' => $uso->instalacion,
                    ];

                    if ($uso->id_aplicacion_producto) {
                        $datosUso['id_aplicacion_producto'] = $uso->id_aplicacion_producto;
                    }

                    $lNegocioProductoInocuidadUso->guardar($datosUso);
                }

                //Generacion de certificado

                $datos = [
                    'tipo_solicitud' => $tipoSolicitud,
                    'id_producto' => $idProducto,
                    'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                ];

                $rutaCertificado = $this->generarCertificado($datos);

                break;
            case 'clonesplaguicidas':

                //Guardar datos de producto
                $lNegocioProductos = new ProductosLogicaNegocio();
                $nombreProducto = $solicitudRegistroProducto->getNombreProducto();
                $idSubtipoProducto = $solicitudRegistroProducto->getIdSubtipoProducto();
                $idProductoOrigen = $solicitudRegistroProducto->getIdProducto();

                $datosProducto = [
                    'nombre_comun' => $nombreProducto,
                    'ruta' => $rutaResultadoRevision,
                    'id_subtipo_producto' => $idSubtipoProducto,
                    'identificador_creacion' => 'G.U.I.A',
                ];

                $idProducto = $lNegocioProductos->guardar($datosProducto);

                $lNegocioProductosInocuidad = new ProductosInocuidadLogicaNegocio();
                $productoInocuidadOrigen = $lNegocioProductosInocuidad->buscar($idProductoOrigen);
                $nuevoNumeroRegistro = $this->generarNumeroClon(date('Y'));

                //Guardar datos de producto inocuidad
                $idFormulacion = $productoInocuidadOrigen->getIdFormulacion();
                $nombreFormulacion = $productoInocuidadOrigen->getFormulacion();
                $numeroRegistro = $productoInocuidadOrigen->getNumeroRegistro().'-CL-'.date('Y').'-'.str_pad($nuevoNumeroRegistro->current()->numero, 4, "0", STR_PAD_LEFT);
                $idCategoriaToxicologica = $productoInocuidadOrigen->getIdCategoriaToxicologica();
                $categoriaToxicologica = $productoInocuidadOrigen->getCategoriaToxicologica();
                $periodoReingreso = $productoInocuidadOrigen->getPeriodoReingreso();
                $estabilidad = $productoInocuidadOrigen->getEstabilidad();
                $observacion = 'Producto creado automáticamente debido a la aprobación de la solicitud de Registro de producto agrícola Nro. ' . $numeroRegistro;
                $identificadorOperador = $solicitudRegistroProducto->getIdentificadorOperador();

                $datosProductoInocuidad = [
                    'id_producto' => $idProducto,
                    'id_formulacion' => $idFormulacion,
                    'formulacion' => $nombreFormulacion,
                    'numero_registro' => $numeroRegistro,
                    'id_categoria_toxicologica' => $idCategoriaToxicologica,
                    'categoria_toxicologica' => $categoriaToxicologica,
                    'periodo_reingreso' => $periodoReingreso,
                    'estabilidad' => $estabilidad,
                    'observacion' => $observacion,
                    'fecha_registro' => 'now()',
                    'id_operador' => $identificadorOperador,
                    'id_declaracion_venta' => 1,
                    'declaracion_venta' => 'Venta libre',
                ];

                $lNegocioProductosInocuidad->guardarProductoInocuidad($datosProductoInocuidad);

                $lNegocioPartidasArancelarias = new PartidasArancelariasLogicaNegocio();
                $lNegocioCodigosComplementariosSuplementarios = new CodigosCompSuplLogicaNegocio();
                $lNegocioPresentaciones = new PresentacionesPlaguicidasLogicaNegocio();

                $datosPartidasArancelarias = $lNegocioPartidasArancelarias->buscarLista(['id_producto' => $idProductoOrigen, 'estado' => 'activo']);

                foreach ($datosPartidasArancelarias as $partidasArancelarias) {

                    $codigoProducto = '';
                    $partidaArancelaria = $partidasArancelarias->partida_arancelaria;
                    $codigoProducto = $lNegocioProductos->generarCodigoProductoPartidaPlaguicida($partidaArancelaria);
                    $idPartidaArancelariaOriginal = $partidasArancelarias->id_partida_arancelaria;


                    $datosPartidaArancelaria = [
                        'id_producto' => $idProducto,
                        'partida_arancelaria' => $partidaArancelaria,
                        'codigo_producto' => $codigoProducto
                    ];

                    $idPartidaArancelaria = $lNegocioPartidasArancelarias->guardar($datosPartidaArancelaria);

                    //Guardar codigos complementarios suplementarios plaguicidas
                    $datosCodigosComplemenariosSuplementariosPlaguicidas = $lNegocioCodigosComplementariosSuplementarios->buscarLista(['id_partida_arancelaria' => $idPartidaArancelariaOriginal, 'estado' => 'activo']);

                    foreach ($datosCodigosComplemenariosSuplementariosPlaguicidas as $codigosComplementariosSuplementariosPlaguicidas) {

                        $idCodigoComplementarioSuplementarioOriginal = $codigosComplementariosSuplementariosPlaguicidas->id_codigo_comp_supl;

                        $datosCodigoComplementarioSuplementarioPlaguicida = [
                            'id_partida_arancelaria' => $idPartidaArancelaria,
                            'codigo_complementario' => $codigosComplementariosSuplementariosPlaguicidas->codigo_complementario,
                            'codigo_suplementario' => $codigosComplementariosSuplementariosPlaguicidas->codigo_suplementario
                        ];

                        $idCodigoComplementarioSuplementario = $lNegocioCodigosComplementariosSuplementarios->guardar($datosCodigoComplementarioSuplementarioPlaguicida);

                        //Guardar presentaciones plaguicidas
                        $datosPresentacionesPlaguicidas = $lNegocioPresentaciones->buscarLista(['id_codigo_comp_supl' => $idCodigoComplementarioSuplementarioOriginal]);

                        foreach ($datosPresentacionesPlaguicidas as $presentacionesPlaguicidas) {

                            $codigoPresentacion = $lNegocioProductos->generarCodigoPresentacionPlaguicida($idProducto, $idPartidaArancelaria, $idCodigoComplementarioSuplementario);

                            $datosPresentacionPlaguicida = [
                                'id_codigo_comp_supl' => $idCodigoComplementarioSuplementario,
                                'presentacion' => $presentacionesPlaguicidas->presentacion,
                                'codigo_presentacion' => $codigoPresentacion,
                                'id_unidad' => $presentacionesPlaguicidas->id_unidad,
                                'unidad' => $presentacionesPlaguicidas->unidad
                            ];
                            $lNegocioPresentaciones->guardar($datosPresentacionPlaguicida);
                        }
                    }
                }

                //Guardar composicion
                $lNegocioComposicionInocuidad = new ComposicionInocuidadLogicaNegocio();

                $datosComposiciones = $lNegocioComposicionInocuidad->buscarLista(['id_producto' => $idProductoOrigen]);

                foreach ($datosComposiciones as $composicion) {

                    $datosComposicion = [
                        'id_producto' => $idProducto,
                        'id_ingrediente_activo' => $composicion->id_ingrediente_activo,
                        'concentracion' => $composicion->concentracion,
                        'ingrediente_activo' => $composicion->ingrediente_activo,
                        'unidad_medida' => $composicion->unidad_medida,
                        'id_tipo_componente' => $composicion->id_tipo_componente,
                        'tipo_componente' => $composicion->tipo_componente
                    ];

                    $lNegocioComposicionInocuidad->guardar($datosComposicion);

                }

                //Guardar fabricante formulador
                $lNegocioFabricanteFormulador = new FabricanteFormuladorLogicaNegocio();
                $lNegocioManufacturadores = new ManufacturadorLogicaNegocio();

                $datosFabricantesFormuladores = $lNegocioFabricanteFormulador->buscarLista(['id_producto' => $idProductoOrigen, 'estado' => 'activo']);

                foreach ($datosFabricantesFormuladores as $fabricanteFormulador) {

                    $idFabricanteFormuladorOrigen = $fabricanteFormulador->id_fabricante_formulador;

                    $datosFabricanteFormulador = [
                        'id_producto' => $idProducto,
                        'nombre' => $fabricanteFormulador->nombre,
                        'tipo' => $fabricanteFormulador->tipo,
                        'id_pais_origen' => $fabricanteFormulador->id_pais_origen,
                        'pais_origen' => $fabricanteFormulador->pais_origen
                    ];

                    $idFabricanteFormulador = $lNegocioFabricanteFormulador->guardar($datosFabricanteFormulador);

                    $datosManufacturadores = $lNegocioManufacturadores->buscarLista(['id_fabricante_formulador' => $idFabricanteFormuladorOrigen, 'estado' => 'activo']);

                    foreach ($datosManufacturadores as $manufacturadores) {

                        $datosManufacturador = [
                            'id_fabricante_formulador' => $idFabricanteFormulador,
                            'manufacturador' => $manufacturadores->manufacturador,
                            'id_pais_origen' => $manufacturadores->id_pais_origen,
                            'pais_origen' => $manufacturadores->pais_origen
                        ];
                        $lNegocioManufacturadores->guardar($datosManufacturador);
                    }
                }

                //Guardar usos plaguicidas bio
                $lNegocioUsosProductosPlaguicidas = new UsosProductosPlaguicidasLogicaNegocio();

                $datosUsos = $lNegocioUsosProductosPlaguicidas->buscarLista(['id_producto' => $idProductoOrigen]);

                foreach ($datosUsos as $uso) {

                    $datosUso = [
                        'id_producto' => $idProducto,
                        'id_plaga' => $uso->id_plaga,
                        'plaga_nombre_comun' => $uso->plaga_nombre_comun,
                        'plaga_nombre_cientifico' => $uso->plaga_nombre_cientifico,
                        'id_cultivo' => $uso->id_cultivo,
                        'cultivo_nombre_comun' => $uso->cultivo_nombre_comun,
                        'cultivo_nombre_cientifico' => $uso->cultivo_nombre_cientifico,
                        'dosis' => $uso->dosis,
                        'unidad_dosis' => $uso->unidad_dosis,
                        'periodo_carencia' => $uso->periodo_carencia,
                        'gasto_agua' => $uso->gasto_agua,
                        'unidad_gasto_agua' => $uso->unidad_gasto_agua
                    ];

                    $lNegocioUsosProductosPlaguicidas->guardar($datosUso);

                }

                $datos = [
                    'tipo_solicitud' => $tipoSolicitud,
                    'id_producto' => $idProducto,
                    'id_solicitud_registro_producto' => $idSolicitudRegistroProducto,
                ];

                $rutaCertificado = $this->generarCertificado($datos);

                break;
        }
        return $rutaCertificado;
    }

    public function generarCertificado($datos)
    {
        $tipoSolicitud = $datos['tipo_solicitud'];
        $idProducto = $datos['id_producto'];
        $idSolicitudRegistroProducto = $datos['id_solicitud_registro_producto'];

        $jasper = new JasperReport();

        $rutaCompletaCertificado = REGISTRO_PRODUCTO_URL_REPORTE . 'certificados/' . $this->rutaFecha . '/';

        if (!file_exists($rutaCompletaCertificado)) {
            mkdir($rutaCompletaCertificado, 0777, true);
        }

        $rutaCortaCertificado = REGISTRO_PRODUCTO_URL . 'certificados/' . $this->rutaFecha . '/';

        switch ($tipoSolicitud) {
            case 'fertilizantes':
                $rutaReporte = 'RegistroProductoRia/vistas/reportes/CertificadoFertilizantes.jasper';
                $nombreArchivo = "CertificadoFertilizante_" . $idProducto;

                $parametros = [
                    'idSolicitud' => (int)$idProducto,
                    'rutaFondo' => RUTA_IMG_GENE . 'fondoCertificado.png',
                ];
                break;
            case 'bioplaguicidas':
                $rutaReporte = 'RegistroProductoRia/vistas/reportes/CertificadoPlaguicidasBio.jasper';
                $nombreArchivo = "CertificadoPlaguicidasBio_" . $idProducto;

                $parametros = [
                    'idProducto' => (int)$idProducto,
                    'rutaFondo' => RUTA_IMG_GENE . 'fondoCertificado.png',
                ];
                break;
            case 'clonesfertilizantes':
                $rutaReporte = 'RegistroProductoRia/vistas/reportes/CertificadoFertilizantes.jasper';
                $nombreArchivo = "CertificadoClonesFertilizante_" . $idProducto;

                $parametros = [
                    'idSolicitud' => (int)$idProducto,
                    'rutaFondo' => RUTA_IMG_GENE . 'fondoCertificado.png',
                ];
                break;
            case 'clonesplaguicidas':
                // $rutaReporte = 'RegistroProductoRia/vistas/reportes/CertificadoPlaguicidasBio.jasper';
                $rutaReporte = 'RegistroProductoRia/vistas/reportes/PlaguicidasComunidadAndina.jasper';
                $nombreArchivo = "CertificadoClonesPlaguicidas_" . $idProducto;

                $parametros = [
                    'idProducto' => (int)$idProducto,
                    'rutaFondo' => RUTA_IMG_GENE . 'fondoCertificado.png',
                ];
                break;
        }

        $datosReporte = array(
            'rutaReporte' => $rutaReporte,
            'rutaSalidaReporte' => 'RegistroProductoRia/archivos/certificados/' . $this->rutaFecha . '/' . $nombreArchivo,
            'tipoSalidaReporte' => array('pdf'),
            'parametrosReporte' => $parametros,
            'conexionBase' => 'SI');

        $jasper->generarArchivo($datosReporte);

        $contenido = $rutaCompletaCertificado . $nombreArchivo . '.pdf';

        //Firma Electrónica
        $arrayDocumento = array(
            'archivo_entrada' => $contenido,
            'archivo_salida' => $contenido,
            'identificador' => '1722773189',
            'razon_documento' => 'Certificado registro de producto',
            'tabla_origen' => 'g_registro_productos.solicitudes_registro_productos',
            'campo_origen' => 'id_solicitud_registro_producto',
            'id_origen' => $idSolicitudRegistroProducto,
            'estado' => 'Por atender',
            'proceso_firmado' => 'SI' //TODO:VERIFICAR
        );

        $lNegocioDocumentos = new DocumentosLogicaNegocio();
        $lNegocioDocumentos->guardar($arrayDocumento);

        $rutaCertificado = $rutaCortaCertificado . $nombreArchivo . '.pdf';

        return $rutaCertificado;
    }

    /**
     * Ejecuta una consulta(SQL) personalizada para actualizar
     * los datos del estado de la solicitud.
     *
     * @return array|ResultSet
     */
    public function actualizarDatosRevisionTecnica($arrayParametros)
    {
        $idSolicitudRegistroProducto = $arrayParametros['id_solicitud_registro_producto'];
        $estado = $arrayParametros['estado'];
        $identificadorRevisor = $arrayParametros['identificador_revisor'];
        $observacionRevisor = $arrayParametros['observacion_revisor'];
        $rutaRevisor = $arrayParametros['ruta_revisor'];
        $rutaCertificado = $arrayParametros['ruta_certificado'] === '' ? null : $arrayParametros['ruta_certificado'];
        $fechaActualizar = "fecha_aprobacion = 'now()'";

        if ($estado === 'subsanacion') {
            $fechaActualizar = "fecha_subsanacion = 'now()'";
        }

        $consulta = "UPDATE
                    	g_registro_productos.solicitudes_registro_productos
                    SET
                    	estado = '" . $estado . "',
                    	identificador_revisor = '" . $identificadorRevisor . "',
                    	observacion_revisor = '" . $observacionRevisor . "',
                    	ruta_revisor = '" . $rutaRevisor . "',
                    	ruta_certificado = '" . $rutaCertificado . "',
                    	resultado_revisor='" . $estado . "',                 	
                    	" . $fechaActualizar . "
                    WHERE
                    	id_solicitud_registro_producto = '" . $idSolicitudRegistroProducto . "';";

        return $this->modeloSolicitudesRegistroProductos->ejecutarSqlNativo($consulta);
    }
	
	public function generarNumeroClon($anio){
        $consulta = "SELECT
												COALESCE(MAX(substr(numero_registro,length(numero_registro)-3,length(numero_registro)))::numeric, 0)+1 AS numero
											FROM
												g_catalogos.productos_inocuidad
											WHERE
												numero_registro ilike '%-CL-$anio-%';";

        return $this->modeloSolicitudesRegistroProductos->ejecutarSqlNativo($consulta);
    }

}
