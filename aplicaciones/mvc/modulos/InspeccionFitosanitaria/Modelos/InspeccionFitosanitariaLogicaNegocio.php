<?php
/**
 * Lógica del negocio de InspeccionFitosanitariaModelo
 *
 * Este archivo se complementa con el archivo InspeccionFitosanitariaControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-15
 * @uses    InspeccionFitosanitariaLogicaNegocio
 * @package InspeccionFitosanitaria
 * @subpackage Modelos
 */
namespace Agrodb\InspeccionFitosanitaria\Modelos;


use Agrodb\InspeccionFitosanitaria\Modelos\IModelo;
use Agrodb\RevisionFormularios\Modelos\AsignacionInspectorLogicaNegocio;
use Agrodb\Correos\Modelos\CorreosLogicaNegocio;
use Agrodb\RegistroOperador\Modelos\OperadoresLogicaNegocio;
use Agrodb\Core\Excepciones\GuardarExcepcion;
use Agrodb\Core\JasperReport;

class InspeccionFitosanitariaLogicaNegocio implements IModelo
{

    private $modeloInspeccionFitosanitaria = null;
    private $lNegocioTransaccionInspeccionFitosanitaria = null;
    private $lNegocioOperadores = null;
    private $lNegocioAsignacionInspector = null;
    private $lNegocioCorreos = null;
	private $lNegocioConfigurarEstadoInspeccionPais = null;
    private $rutaFecha = null;

    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloInspeccionFitosanitaria = new InspeccionFitosanitariaModelo();
        $this->lNegocioTransaccionInspeccionFitosanitaria = new TransaccionInspeccionFitosanitariaLogicaNegocio();
        $this->lNegocioAsignacionInspector = new AsignacionInspectorLogicaNegocio();
        $this->lNegocioOperadores = new OperadoresLogicaNegocio();
        $this->lNegocioCorreos = new CorreosLogicaNegocio();
		$this->lNegocioConfigurarEstadoInspeccionPais = new ConfigurarEstadoInspeccionPaisLogicaNegocio();
        $this->rutaFecha = date('Y').'/'.date('m').'/'.date('d');
    }

    /**
     * Guarda el registro actual
     *
     * @param array $datos
     * @return int
     */
    public function guardar(Array $datos)
    {
        
        try{
        
            $tablaModelo = new InspeccionFitosanitariaModelo($datos);
            $procesoIngreso = $this->modeloInspeccionFitosanitaria->getAdapter()
            ->getDriver()
            ->getConnection();
            $procesoIngreso->beginTransaction();            
            
            $datosBd = $tablaModelo->getPrepararDatos();
            if ($tablaModelo->getIdInspeccionFitosanitaria() != null && $tablaModelo->getIdInspeccionFitosanitaria() > 0) {      
                $idInspeccionFitosanitaria = $this->modeloInspeccionFitosanitaria->actualizar($datosBd, $tablaModelo->getIdInspeccionFitosanitaria());
            } else {
                unset($datosBd["id_inspeccion_fitosanitaria"]);            
                $idInspeccionFitosanitaria = $this->modeloInspeccionFitosanitaria->guardar($datosBd);
            }
            
            $procesoIngreso->commit();
            return $idInspeccionFitosanitaria;
        
        }catch (GuardarExcepcion $ex){
            $procesoIngreso->rollback();
            throw new \Exception($ex->getMessage());
        }
    }
    
    /**
     * Guarda el registro actual
     *
     * @param array $datos
     * @return int
     */
    public function guardarEnviarSolicitud(Array $datos)
    {
    	
    	try{   		

    		$idInspeccionFitosanitaria = $datos['id_inspeccion_fitosanitaria'];
    		unset($datos["id_inspeccion_fitosanitaria"]);
    		$banderaAprobacion = false;
    		
    		if($datos['estado_inspeccion_fitosanitaria'] === "Enviado"){
    			$numeroSolicitud = $this->generarNumeroSolicitud($datos['id_provincia_area']);
    			$datos["numero_solicitud"] = $numeroSolicitud->current()->f_generar_numero_solicitud;
    		}
    		
    		if($datos['estado_inspeccion_fitosanitaria'] === "Subsanacion"){
    			$datos['estado_inspeccion_fitosanitaria'] = 'Subsanado';
    		}
    		
    		$procesoIngreso = $this->modeloInspeccionFitosanitaria->getAdapter()
    		->getDriver()
    		->getConnection();
    		$procesoIngreso->beginTransaction();
    		
    		//Inicio validar si existe configuaración para tipo solicitud - pais en estado enviado
    		$datosInspeccionFitosanitaria = $this->buscar($idInspeccionFitosanitaria);
    		$idPaisDestino = $datosInspeccionFitosanitaria->getIdPaisDestino();
    		
    		$datosConfigurarEstadoInspeccionPais = ['tipo_certificado' => $datos['tipo_solicitud']
                                        		    , 'id_pais' => $idPaisDestino
                                        		      ];
    		
    		$verificarEstadoInspeccionPais = $this->lNegocioConfigurarEstadoInspeccionPais->buscarLista($datosConfigurarEstadoInspeccionPais);
    		
    		if($verificarEstadoInspeccionPais->count() && $datos['estado_inspeccion_fitosanitaria'] === "Enviado"){
                
    		    $banderaAprobacion = true;
    		    
                $tiempoVigencia = $verificarEstadoInspeccionPais->current()->dias_vigencia;
                $fechaActual = date("Y-m-d  H:i:s");
                
                $fechaVigencia = $this->calcularFechaVigencia($fechaActual, $tiempoVigencia);
                $datos += ['tiempo_vigencia' => $tiempoVigencia];
                $datos += ['fecha_vigencia' => $fechaVigencia];        
    		    
    		}
    		//Fin validar si existe configuaración para tipo solicitud - pais en estado enviado
    		
    		$statement = $this->modeloInspeccionFitosanitaria->getAdapter()
    		->getDriver()
    		->createStatement();
    		
    		$sqlActualizar = $this->modeloInspeccionFitosanitaria->actualizarSql('inspeccion_fitosanitaria', $this->modeloInspeccionFitosanitaria->getEsquema());
    		$sqlActualizar->set($datos);
    		$sqlActualizar->where(array('id_inspeccion_fitosanitaria' => $idInspeccionFitosanitaria));
    		$sqlActualizar->prepareStatement($this->modeloInspeccionFitosanitaria->getAdapter(), $statement);
    		$statement->execute();
    		
    		$procesoIngreso->commit();
									   		
    		if($banderaAprobacion){
    		    $arrayDatosTransaccion = ['id_inspeccion_fitosanitaria' => $idInspeccionFitosanitaria];
    		    $this->lNegocioTransaccionInspeccionFitosanitaria->guardarTransaccionInspeccionEnviada($arrayDatosTransaccion);
    		}
    		
    		return $idInspeccionFitosanitaria;
    		
    	}catch (GuardarExcepcion $ex){
    		$procesoIngreso->rollback();
    		throw new \Exception($ex->getMessage());
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
        $this->modeloInspeccionFitosanitaria->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return InspeccionFitosanitariaModelo
     */
    public function buscar($id)
    {
        return $this->modeloInspeccionFitosanitaria->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloInspeccionFitosanitaria->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloInspeccionFitosanitaria->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarInspeccionFitosanitaria()
    {
        $consulta = "SELECT * FROM " . $this->modeloInspeccionFitosanitaria->getEsquema() . ". inspeccion_fitosanitaria";
        return $this->modeloInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
    }

    /**
     * Genera nuero de soliciud.
     *
     * @return array|ResultSet
     */
    public function generarNumeroSolicitud($idProvinciaArea)
    {
        $consulta = "SELECT * FROM g_inspeccion_fitosanitaria.f_generar_numero_solicitud('" . $idProvinciaArea . "');";

        return $this->modeloInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function obtenerDatosAreaCodigoMag($arrayParametros)
    {
        $tipoCodigo = $arrayParametros["tipoCodigo"];
        $codigo = $arrayParametros["codigo"];
        $busqueda = "";
        $campoArea = "";

        switch ($tipoCodigo) {

            case "mag":
                $busqueda = " and upper(a.codigo_transaccional) = upper('" . $codigo . "') 
                                and top.id_area || top.codigo in ('SVPRB')";
                $campoArea = " a.codigo_transaccional";
                break;

            case "area":
                $busqueda = " and s.identificador_operador||'.'||s.codigo_provincia || s.codigo ||a.codigo||a.secuencial = '" . $codigo . "' 
                                and top.id_area || top.codigo in ('SVPRO', 'SVACO','SVCON')";
                $campoArea = " s.identificador_operador || '.' || s.codigo_provincia || s.codigo || a.codigo || a.secuencial";
                break;
        }

        $consulta = "SELECT 
                        DISTINCT
                    	o.identificador as identificador_operador
                    	, CASE WHEN o.razon_social = '' THEN o.nombre_representante ||' '|| o.apellido_representante ELSE o.razon_social end nombre_operador
                    	, s.id_sitio
                    	, s.nombre_lugar as nombre_sitio
                    	, s.provincia as nombre_provincia
                        , s.canton as nombre_canton
                    	, a.id_area
                    	, a.nombre_area
                    	, " . $campoArea . " as codigo_area
                    	, top.nombre
                     FROM 
                        g_operadores.sitios s
                        INNER JOIN g_operadores.areas a ON s.id_sitio = a.id_sitio
                        INNER JOIN g_operadores.productos_areas_operacion pao ON a.id_area = pao.id_area
                        INNER JOIN g_operadores.operaciones op ON pao.id_operacion = op.id_operacion
                        INNER JOIN g_catalogos.tipos_operacion top ON op.id_tipo_operacion = top.id_tipo_operacion
                        INNER JOIN g_operadores.operadores o ON o.identificador = s.identificador_operador
                     WHERE
                        op.estado in ('registrado','registradoObservacion')" . $busqueda . ";";

        return $this->modeloInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function obtenerTipoProductoPorAreaPorRequisitos($arrayParametros)
    {
        $idPaisDestino = $arrayParametros["idPaisDestino"];
        $idArea = $arrayParametros["idArea"];

        $consulta = "SELECT 
                    	DISTINCT
                    	tp.id_tipo_producto
                    	, tp.nombre as nombre_tipo_producto
                    FROM 
                    	g_catalogos.tipo_productos tp
                    	INNER JOIN g_catalogos.subtipo_productos stp ON tp.id_tipo_producto = stp.id_tipo_producto
                    	INNER JOIN g_catalogos.productos p ON stp.id_subtipo_producto = p.id_subtipo_producto
                    	INNER JOIN g_operadores.operaciones op ON p.id_producto = op.id_producto
                    	INNER JOIN g_operadores.productos_areas_operacion pao ON op.id_operacion = pao.id_operacion
                    	INNER JOIN g_operadores.areas a ON a.id_area = pao.id_area
                     	INNER JOIN g_requisitos.requisitos_comercializacion rc ON p.id_producto = rc.id_producto
                    	INNER JOIN g_requisitos.requisitos_asignados ra ON rc.id_requisito_comercio = ra.id_requisito_comercio
                    	INNER JOIN g_requisitos.requisitos r ON r.id_requisito = ra.requisito
                    WHERE
                    	tp.estado = 1
                    	and op.estado in ('registrado', 'registradoObservacion')
                    	and rc.tipo = 'SV'
                    	and ra.tipo = 'Exportación'
                    	and ra.estado = 'activo'
                    	and r.estado = '1'
                        and p.clasificacion NOT IN ('ornamentales')
                    	and a.id_area = " . $idArea . "
                    	and rc.id_localizacion = " . $idPaisDestino . ";";

        return $this->modeloInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function obtenerSubtipoProductoPorAreaPorRequisitos($arrayParametros)
    {
        $idPaisDestino = $arrayParametros["idPaisDestino"];
        $idArea = $arrayParametros["idArea"];
        $idTipoProducto = $arrayParametros["idTipoProducto"];

        $consulta = "SELECT 
                    	DISTINCT
                    	stp.id_subtipo_producto
                    	, stp.nombre as nombre_subtipo_producto
                    FROM 
                    	g_catalogos.subtipo_productos stp
                    	INNER JOIN g_catalogos.productos p ON stp.id_subtipo_producto = p.id_subtipo_producto
                    	INNER JOIN g_operadores.operaciones op ON p.id_producto = op.id_producto
                    	INNER JOIN g_operadores.productos_areas_operacion pao ON op.id_operacion = pao.id_operacion
                    	INNER JOIN g_operadores.areas a ON a.id_area = pao.id_area
                     	INNER JOIN g_requisitos.requisitos_comercializacion rc ON p.id_producto = rc.id_producto
                    	INNER JOIN g_requisitos.requisitos_asignados ra ON rc.id_requisito_comercio = ra.id_requisito_comercio
                    	INNER JOIN g_requisitos.requisitos r ON r.id_requisito = ra.requisito
                    WHERE
                    	stp.estado = 1
                    	and op.estado in ('registrado', 'registradoObservacion')
                    	and rc.tipo = 'SV'
                    	and ra.tipo = 'Exportación'
                    	and ra.estado = 'activo'
                    	and r.estado = '1'
                        and p.clasificacion NOT IN ('ornamentales')
                    	and rc.id_localizacion = " . $idPaisDestino . "
                    	and a.id_area = " . $idArea . "
                    	and stp.id_tipo_producto = " . $idTipoProducto . ";";

        return $this->modeloInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function obtenerProductoPorAreaPorRequisitos($arrayParametros)
    {
        $idPaisDestino = $arrayParametros["idPaisDestino"];
        $idArea = $arrayParametros["idArea"];
        $idSubtipoProducto = $arrayParametros["idSubtipoProducto"];

        $consulta = "SELECT 
                    	DISTINCT
                    	p.id_producto
                    	, p.nombre_comun as nombre_producto
                    FROM 
                    	g_catalogos.productos p                        
                    	INNER JOIN g_operadores.operaciones op ON p.id_producto = op.id_producto
                    	INNER JOIN g_operadores.productos_areas_operacion pao ON op.id_operacion = pao.id_operacion
                    	INNER JOIN g_operadores.areas a ON a.id_area = pao.id_area
                     	INNER JOIN g_requisitos.requisitos_comercializacion rc ON p.id_producto = rc.id_producto
                    	INNER JOIN g_requisitos.requisitos_asignados ra ON rc.id_requisito_comercio = ra.id_requisito_comercio
                    	INNER JOIN g_requisitos.requisitos r ON r.id_requisito = ra.requisito
                    WHERE
                    	p.estado = 1
                    	and op.estado in ('registrado', 'registradoObservacion')
                    	and rc.tipo = 'SV'
                    	and ra.tipo = 'Exportación'
                    	and ra.estado = 'activo'
                    	and r.estado = '1'
                        and p.clasificacion NOT IN ('ornamentales')
                    	and rc.id_localizacion = " . $idPaisDestino . "
                    	and a.id_area = " . $idArea . "
                    	and p.id_subtipo_producto = " . $idSubtipoProducto . ";";

        return $this->modeloInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
    }
    
    /**
     * Ejecuta una consulta(SQL) personalizada .
     * Consulta para obtener si existe un protocolo para un producto para un pais.
     *
     * @return array|ResultSet
     */
    public function validarProtocoloPorProductoPorPais($arrayParametros)
    {
        
        $idLocalizacion = $arrayParametros['id_localizacion'];
        $idProducto = $arrayParametros['id_producto'];
        
        $consulta = "SELECT
                                STRING_AGG (distinct(pr.id_protocolo::text), ',') as protocolo_producto_pais
                            FROM 
                                g_protocolos.protocolos_asignados pa
                            INNER JOIN g_protocolos.protocolos pr ON pa.id_protocolo = pr.id_protocolo
                            INNER JOIN g_protocolos.protocolos_comercializacion pc ON pa.id_protocolo_comercio = pc.id_protocolo_comercio
                            WHERE 
                                pc.id_localizacion = '" . $idLocalizacion . "'
                                and pc.id_producto in (" . $idProducto . ")
                                and pa.estado = 'activo'
                                and pr.estado_protocolo = '1'
                            HAVING COUNT(pr.id_protocolo) > 0;";

        return $this->modeloInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
    }
    
    /**
     * Ejecuta una consulta(SQL) personalizada para obtener los centros de acopio
     * autorizados de acuerdo al tipo solicitud, programa, operador y pais de destino
     *
     * @return array|ResultSet
     */
    public function obtenerProtocolosAreasAsignados($arrayParametros)
    {
        
        $idArea = $arrayParametros['id_area'];
        $idTipoOperacion = $arrayParametros['id_tipo_operacion'];
        
        $consulta = "SELECT
                            STRING_AGG (distinct(paa.id_protocolo::text), ',') as protocolo_area
                        FROM
                        	g_protocolos.protocolos_areas pra
                        	INNER JOIN g_protocolos.protocolos_areas_asignados paa ON pra.id_protocolo_area = paa.id_protocolo_area
                        	INNER JOIN g_protocolos.protocolos pr1 ON paa.id_protocolo = pr1.id_protocolo
                        WHERE
                        	pra.id_area = '" . $idArea . "'
                        	and pra.id_tipo_operacion  = '" . $idTipoOperacion . "'
                            and paa.estado_protocolo_asignado in ('aprobado', 'implementacion')
                        HAVING COUNT(paa.id_protocolo) > 0;";
        
        return $this->modeloInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
    }
    
    
    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarFiltroSolicitudesInspeccionFitosanitaria($arrayParametros)
    {
        
        $idPaisDestino = $arrayParametros['idPaisDestino'] != "" ? "'" . $arrayParametros['idPaisDestino'] . "'" : "NULL";
        $tipoSolicitud = $arrayParametros['tipoSolicitud'] != "" ? "(" . $arrayParametros['tipoSolicitud'] . ")" : "(NULL)";
        $numeroSolicitud = $arrayParametros['numeroSolicitud'] != "" ? "'" . $arrayParametros['numeroSolicitud'] . "'" : "NULL";
        $idProducto = $arrayParametros['idProducto'] != "" ? "'" . $arrayParametros['idProducto'] . "'" : "NULL";
        $estadoSolicitud = $arrayParametros['estadoSolicitud'] != "" ? "(" . $arrayParametros['estadoSolicitud'] . ")" : "(NULL)";
        $fechaInicio = $arrayParametros['fechaInicio'] != "" ? "'" . $arrayParametros['fechaInicio'] . " 00:00:00'" : "NULL";
        $fechaFin = $arrayParametros['fechaFin'] != "" ? "'" . $arrayParametros['fechaFin'] . " 24:00:00'" : "NULL";
        $nombreProvincia = $arrayParametros['nombreProvincia'] != "" ? "'" . $arrayParametros['nombreProvincia'] . "'" : "NULL";
        $identificadorSolicitante = $arrayParametros['identificadorSolicitante'] != "" ? "'" . $arrayParametros['identificadorSolicitante'] . "'" : "NULL";
 
        $consulta = "SELECT
						DISTINCT if.id_inspeccion_fitosanitaria
						, if.numero_solicitud
						, if.identificador_solicitante
						, CASE WHEN o.razon_social = '' THEN o.nombre_representante ||' '|| o.apellido_representante ELSE o.razon_social end nombre_operador
						, if.estado_inspeccion_fitosanitaria
						, if.nombre_pais_destino
						, if.nombre_provincia_area
						, if.fecha_creacion
					FROM
						g_inspeccion_fitosanitaria.inspeccion_fitosanitaria if
						INNER JOIN g_operadores.operadores o ON o.identificador = if.identificador_solicitante
                        LEFT JOIN g_inspeccion_fitosanitaria.productos_inspeccion_fitosanitaria ifp ON ifp.id_inspeccion_fitosanitaria = if.id_inspeccion_fitosanitaria			
					WHERE
                        ($estadoSolicitud is NULL or if.estado_inspeccion_fitosanitaria in " . $estadoSolicitud . ")
                        and ($tipoSolicitud is NULL or if.tipo_solicitud in " . $tipoSolicitud . ")
						and ($numeroSolicitud is NULL or if.numero_solicitud = " . $numeroSolicitud .")
                        and ($idProducto is NULL or ifp.id_producto = $idProducto)
                        and ($nombreProvincia is NULL or TRIM(REPLACE(LOWER(UNACCENT(if.nombre_provincia_area)), ' ', '')) = TRIM(REPLACE(LOWER(UNACCENT(" . $nombreProvincia . ")), ' ', '')))
                        and ($idPaisDestino is NULL or if.id_pais_destino = $idPaisDestino)
                        and ($identificadorSolicitante is NULL or if.identificador_solicitante = " . $identificadorSolicitante .")
						and ($fechaInicio is NULL or if.fecha_creacion >= " . $fechaInicio .")
                        and ($fechaFin is NULL or if.fecha_creacion <= " . $fechaFin .")
                    ORDER BY if.fecha_creacion ASC;";
        
        return $this->modeloInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
    }
    
	/**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarFiltroSolicitudesInspeccionFitosanitariaSinConsumir($arrayParametros)
    {
        
        $idPaisDestino = $arrayParametros['idPaisDestino'] != "" ? "'" . $arrayParametros['idPaisDestino'] . "'" : "NULL";
        $tipoSolicitud = $arrayParametros['tipoSolicitud'] != "" ? "(" . $arrayParametros['tipoSolicitud'] . ")" : "(NULL)";
        $numeroSolicitud = $arrayParametros['numeroSolicitud'] != "" ? "'" . $arrayParametros['numeroSolicitud'] . "'" : "NULL";
        $idProducto = $arrayParametros['idProducto'] != "" ? "'" . $arrayParametros['idProducto'] . "'" : "NULL";
        $estadoSolicitud = $arrayParametros['estadoSolicitud'] != "" ? "(" . $arrayParametros['estadoSolicitud'] . ")" : "(NULL)";
        $fechaInicio = $arrayParametros['fechaInicio'] != "" ? "'" . $arrayParametros['fechaInicio'] . " 00:00:00'" : "NULL";
        $fechaFin = $arrayParametros['fechaFin'] != "" ? "'" . $arrayParametros['fechaFin'] . " 24:00:00'" : "NULL";
        $nombreProvincia = $arrayParametros['nombreProvincia'] != "" ? "'" . $arrayParametros['nombreProvincia'] . "'" : "NULL";
        $identificadorSolicitante = $arrayParametros['identificadorSolicitante'] != "" ? "'" . $arrayParametros['identificadorSolicitante'] . "'" : "NULL";
                
        $consulta = "SELECT 
                        	DISTINCT tgif.id_inspeccion_fitosanitaria
                        	, tgif.numero_solicitud
                        	, tgif.identificador_solicitante
                        	, tgif.nombre_operador
                        	, tgif.estado_inspeccion_fitosanitaria
                        	, tgif.nombre_pais_destino
                        	, tgif.nombre_provincia_area
                        	, tgif.fecha_creacion
                        FROM (SELECT
                        			if.id_inspeccion_fitosanitaria
                        			, if.numero_solicitud
                        			, if.identificador_solicitante
                        			, CASE WHEN o.razon_social = '' THEN o.nombre_representante ||' '|| o.apellido_representante ELSE o.razon_social end nombre_operador
                        			, if.estado_inspeccion_fitosanitaria
                        			, if.nombre_pais_destino
                        			, if.nombre_provincia_area
                        			, if.fecha_creacion
                        		FROM
                        			g_inspeccion_fitosanitaria.inspeccion_fitosanitaria if
									INNER JOIN g_operadores.operadores o ON o.identificador = if.identificador_solicitante
                        			LEFT JOIN g_inspeccion_fitosanitaria.productos_inspeccion_fitosanitaria ifp ON ifp.id_inspeccion_fitosanitaria = if.id_inspeccion_fitosanitaria       
                        		WHERE
                                    ($estadoSolicitud is NULL or if.estado_inspeccion_fitosanitaria in " . $estadoSolicitud . ")
                                    and ($tipoSolicitud is NULL or if.tipo_solicitud in " . $tipoSolicitud . ")
            						and ($numeroSolicitud is NULL or if.numero_solicitud = " . $numeroSolicitud .")
                                    and ($idProducto is NULL or ifp.id_producto = $idProducto)
                                    and ($nombreProvincia is NULL or TRIM(REPLACE(LOWER(UNACCENT(if.nombre_provincia_area)), ' ', '')) = TRIM(REPLACE(LOWER(UNACCENT(" . $nombreProvincia . ")), ' ', '')))
                                    and ($idPaisDestino is NULL or if.id_pais_destino = $idPaisDestino)
                                    and ($identificadorSolicitante is NULL or if.identificador_solicitante = " . $identificadorSolicitante .")
            						and ($fechaInicio is NULL or if.fecha_creacion >= " . $fechaInicio .")
                                    and ($fechaFin is NULL or if.fecha_creacion <= " . $fechaFin .") ORDER BY if.fecha_creacion ASC) tgif
                        LEFT JOIN (SELECT
                        				DISTINCT tif.id_inspeccion_fitosanitaria
                        			FROM
                        				g_inspeccion_fitosanitaria.total_inspeccion_fitosanitaria tif
                        			INNER JOIN g_certificado_fitosanitario.certificado_fitosanitario_productos cfp ON cfp.id_total_inspeccion_fitosanitaria = tif.id_total_inspeccion_fitosanitaria) tgcf ON tgcf.id_inspeccion_fitosanitaria = tgif.id_inspeccion_fitosanitaria
                        			WHERE 
                        				tgcf.id_inspeccion_fitosanitaria IS NULL;";
        
        return $this->modeloInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
    }
    
    /**
     * Guarda el registro actual
     *
     * @param array $datos
     * @return int
     */
    public function guardarConfirmarInspeccion(Array $datos)
    {
        try{
            
            $idInspeccionFitosanitaria = $_POST['id_inspeccion_fitosanitaria'];
            $identificadorRevisor = $_POST['identificador_revisor'];
            $identificadorAsignante = $_POST['identificador_revisor'];
            $observacionRevisor = $_POST['observacion_revisor'];
            $estadoAterior = $_POST['estado_anterior_inspeccion_fitosanitaria'];
            $estadoSolicitud = 'Confirmado';
            $datos['estado_anterior_inspeccion_fitosanitaria'] = $estadoAterior;
            $datos['estado_inspeccion_fitosanitaria'] = $estadoSolicitud;
            
            $procesoIngreso = $this->modeloInspeccionFitosanitaria->getAdapter()
            ->getDriver()
            ->getConnection();
            $procesoIngreso->beginTransaction();
            
            $statement = $this->modeloInspeccionFitosanitaria->getAdapter()
            ->getDriver()
            ->createStatement();

            $sqlActualizar = $this->modeloInspeccionFitosanitaria->actualizarSql('inspeccion_fitosanitaria', $this->modeloInspeccionFitosanitaria->getEsquema());
            $sqlActualizar->set($datos);
            $sqlActualizar->where(array('id_inspeccion_fitosanitaria' => $idInspeccionFitosanitaria));
            $sqlActualizar->prepareStatement($this->modeloInspeccionFitosanitaria->getAdapter(), $statement);
            $statement->execute();
                        
            $arrayDatosRevisor = array(
                'identificador_inspector' => $identificadorRevisor,
                'fecha_asignacion' => 'now()',
                'identificador_asignante' => $identificadorAsignante,
                'tipo_solicitud' => 'inspeccionFitosanitaria',
                'tipo_inspector' => 'Técnico',
                'id_operador_tipo_operacion' => 0,
                'id_historial_operacion' => 0,
                'id_solicitud' => $idInspeccionFitosanitaria,
                'estado' => 'Técnico',
                'fecha_inspeccion' => 'now()',
                'observacion' => $observacionRevisor,
                'estado_siguiente' => $estadoSolicitud,
                'orden' => 1);
            
            $this->lNegocioAsignacionInspector->guardar($arrayDatosRevisor); 
            
            $this->enviarCorreo($idInspeccionFitosanitaria);
            
            $procesoIngreso->commit();
            
        }catch (GuardarExcepcion $ex){
            $procesoIngreso->rollback();
            throw new \Exception($ex->getMessage());
        }
        
    }
    
    /**
     * Guarda el registro actual
     *
     * @param array $datos
     * @return int
     */
    public function guardarAtenderInspeccion(Array $datos)
    {
        try{
            
            $idInspeccionFitosanitaria = $_POST['id_inspeccion_fitosanitaria'];
            $arrayProductosInspeccion = $_POST['array_productos_inspeccion'];
            $identificadorRevisor = $_POST['identificador_revisor'];
            $identificadorAsignante = $_POST['identificador_revisor'];
            $observacionRevisor = $_POST['observacion_revisor'];
            $estadoAterior = $_POST['estado_anterior_inspeccion_fitosanitaria']; 
            $estadoSolicitud = $_POST['estado_inspeccion_fitosanitaria'];    
            
            $fechaActual = date("Y-m-d  H:i:s");															 
            $rutaFecha = $this->rutaFecha . '/';
            $banderaAprobacion = false;
            
            $procesoIngreso = $this->modeloInspeccionFitosanitaria->getAdapter()
            ->getDriver()
            ->getConnection();
            $procesoIngreso->beginTransaction();
            
            $statement = $this->modeloInspeccionFitosanitaria->getAdapter()
            ->getDriver()
            ->createStatement();
            
            $datosAtenderInspeccion = ['id_inspeccion_fitosanitaria' => $idInspeccionFitosanitaria
                , 'identificador_revisor' => $identificadorRevisor
                , 'observacion_revisor' => $observacionRevisor
                , 'estado_anterior_inspeccion_fitosanitaria' => $estadoAterior
                , 'estado_inspeccion_fitosanitaria' => $estadoSolicitud
            ];
            
            if($estadoSolicitud == "Aprobado"){                
                $tiempoVigencia = $_POST['tiempo_vigencia'];                
                $qDatosInspeccionFitosanitaria = $this->buscar($idInspeccionFitosanitaria); 
                $nombreArchivo = $qDatosInspeccionFitosanitaria->getNumeroSolicitud();
                
                $fechaVigencia = $this->calcularFechaVigencia($fechaActual, $tiempoVigencia);
                $datosAtenderInspeccion += ['tiempo_vigencia' => $tiempoVigencia];
                $datosAtenderInspeccion += ['fecha_vigencia' => $fechaVigencia];
                $datosAtenderInspeccion += ['ruta_certificado_inspeccion' => INS_FITO_DOC_ADJ . $rutaFecha. $nombreArchivo . '.pdf'];
				$datosAtenderInspeccion += ['fecha_aprobacion' => 'now()'];
            }

            $sqlActualizar = $this->modeloInspeccionFitosanitaria->actualizarSql('inspeccion_fitosanitaria', $this->modeloInspeccionFitosanitaria->getEsquema());
            $sqlActualizar->set($datosAtenderInspeccion);
            $sqlActualizar->where(array('id_inspeccion_fitosanitaria' => $idInspeccionFitosanitaria));
            $sqlActualizar->prepareStatement($this->modeloInspeccionFitosanitaria->getAdapter(), $statement);
            $statement->execute();
            
            if($estadoSolicitud === "Aprobado"){
            
                $banderaAprobacion = true;
                
                $statement = $this->modeloInspeccionFitosanitaria->getAdapter()
                ->getDriver()
                ->createStatement();
                
                foreach ($arrayProductosInspeccion as $productoInspeccion) {
                    $idProductoInspeccionFitosanitaria = $productoInspeccion['id_producto_inspeccion_fitosanitaria'];
                    $catidadAprobada = $productoInspeccion['cantidad_aprobada'];
                    $pesoAprobado = $productoInspeccion['peso_aprobado'];
                    $cantidadInspeccionada = $productoInspeccion['cantidad_inspeccionada'];
                    $pesoInspeccionado = $productoInspeccion['peso_inspeccionado'];
                    
                    $datosProductosInspeccionados = ['cantidad_aprobada' => $catidadAprobada,
                                                    'peso_aprobado' => $pesoAprobado,
                                                    'cantidad_inspeccionada' => $cantidadInspeccionada,
                    								'peso_inspeccionado' => $pesoInspeccionado
                                                    ];
    
                    $sqlActualizar = $this->modeloInspeccionFitosanitaria->actualizarSql('productos_inspeccion_fitosanitaria', $this->modeloInspeccionFitosanitaria->getEsquema());
                    $sqlActualizar->set($datosProductosInspeccionados);
                    $sqlActualizar->where(array('id_producto_inspeccion_fitosanitaria' => $idProductoInspeccionFitosanitaria));
                    $sqlActualizar->prepareStatement($this->modeloInspeccionFitosanitaria->getAdapter(), $statement);
                    $statement->execute();
                                        
                }                
                
            }
            
            $arrayDatosRevisor = array(
                'identificador_inspector' => $identificadorRevisor,
                'fecha_asignacion' => 'now()',
                'identificador_asignante' => $identificadorAsignante,
                'tipo_solicitud' => 'inspeccionFitosanitaria',
                'tipo_inspector' => 'Técnico',
                'id_operador_tipo_operacion' => 0,
                'id_historial_operacion' => 0,
                'id_solicitud' => $idInspeccionFitosanitaria,
                'estado' => 'Técnico',
                'fecha_inspeccion' => 'now()',
                'observacion' => $observacionRevisor,
                'estado_siguiente' => $estadoSolicitud,
                'orden' => 1);
            
            $this->lNegocioAsignacionInspector->guardar($arrayDatosRevisor);
                                    
            $procesoIngreso->commit();
   
            if($banderaAprobacion){
            	$arrayDatosTransaccion = ['id_inspeccion_fitosanitaria' => $idInspeccionFitosanitaria];         	
            	$this->lNegocioTransaccionInspeccionFitosanitaria->guardarTransaccionInspeccion($arrayDatosTransaccion);  
                $this->generarDocumentoInspeccionFitosanitaria($idInspeccionFitosanitaria, $rutaFecha, $nombreArchivo);
            }
                        
        }catch (GuardarExcepcion $ex){
            $procesoIngreso->rollback();
            throw new \Exception($ex->getMessage());
        }
        
    }
    
    /**
     * Función para enviar correo electrónico
     */
    public function enviarCorreo($idInspeccionFitosanitaria)
    {
        $solicitud = $this->buscar($idInspeccionFitosanitaria);
        $identificadorOperador = $solicitud->getIdentificadorSolicitante();
        $numeroSolicitud = $solicitud->getNumeroSolicitud();
        $nombreArea = ($solicitud->getNombreArea() != "" ? $solicitud->getNombreArea() : $solicitud->getNombrePuertoEmbarque());
        $direccionArea = $solicitud->getDireccionArea();
        $fechaInspeccion = $solicitud->getFechaInspeccion();
        $horaInspeccion = $solicitud->getHoraInspeccion();
        $identificadorRevisor = $solicitud->getIdentificadorRevisor();
        $observacionRevisor = $solicitud->getObservacionRevisor();
        
        $operador = $this->lNegocioOperadores->buscar($identificadorOperador);
        $correo = $operador->getCorreo();
        $nombreOperador = ($operador->getRazonSocial() == "") ? $operador->getApellidoRepresentante() . ' ' . $operador->getNombreRepresentante() : $operador->getRazonSocial();
        
        $arrayDatosRevisor = ['identificador' => $identificadorRevisor];
        $qDatosRevisor = $this->obtenerDatosInspector($arrayDatosRevisor);
        $nombreRevisor = $qDatosRevisor->current()->nombre_inspector;
        
        $familiaLetra = "font-family:'Text Me One', 'Segoe UI', 'Tahoma', 'Helvetica', 'freesans', 'sans-serif'";
        
        $cuerpo = '<html xmlns="http://www.w3.org/1999/xhtml"><tbody><table>	
                    <tr><td style="'.$familiaLetra.'; padding-top:10px; font-size:14px;color:#2a2a2a;">Estimados señores ' . $nombreOperador .'</td></tr>
                    <tr><td style="'.$familiaLetra.'; padding-top:25px; font-size:14px;color:#2a2a2a; width: 80%; text-align:justify;">Por medio de la presente se comunica que la carga detallada en la Solicitud Nro.' . $numeroSolicitud . ', será inspeccionada en el lugar de inspección solicitado: ' . $nombreArea . ', ' . $direccionArea . ', el día ' . $this->devolverFechaEnLetras($fechaInspeccion) . ' a las ' . date('H:i', strtotime($horaInspeccion)) . '</td></tr>
                    <tr><td style="'.$familiaLetra.'; padding-top:25px; font-size:14px;color:#2a2a2a; width: 80%; text-align:justify;">Por consiguiente, el operador deberá contar con un representante autorizado, quien deberá acompañar en todo momento al técnico de Agrocalidad durante la inspección y tener a disposición personal para que realicen el re empaque de las cajas inspeccionadas por los técnicos de Agrocalidad, además tomarán todas las precauciones para que la inspección fitosanitaria se lleve con normalidad.</td></tr>
                    <tr><td style="'.$familiaLetra.'; padding-top:10px; font-size:14px;color:#2a2a2a;"><b>El técnico de Agrocalidad asignado para la inspección será: </b>' . $nombreRevisor . '</td></tr>
                    <tr><td style="'.$familiaLetra.'; padding-top:10px; font-size:14px;color:#2a2a2a;"><b>Observación del técnico de Agrocalidad: </b>' . $observacionRevisor . '</td></tr>
                    <tr><td style="'.$familiaLetra.'; padding-top:10px; font-size:14px;color:#2a2a2a;">Saludos cordiales.</td></tr>
                    </table></tbody></html>';
        
        $arrayCorreo = array(
            'asunto' => 'Confirmación de inspección fitosanitaria. ',
            'cuerpo' => $cuerpo,
            'estado' => 'Por enviar',
            'codigo_modulo' => 'PRG_INSP_FITO',
            'tabla_modulo' => 'g_inspeccion_fitosanitaria.inspeccion_fitosanitaria',
            'id_solicitud_tabla' => $idInspeccionFitosanitaria
        );
        
        $arrayDestinatario = array(
            $correo
        );
        
        return $this->lNegocioCorreos->crearCorreoElectronico($arrayCorreo, $arrayDestinatario);
    }
        
    /**
     * Función para sumar dias de vigencia
     */
    public function calcularFechaVigencia($fecha, $dias)
    {
        $fechaInicial= strtotime($fecha);
        $diaSemana = date('N', $fechaInicial);
        $totalDias = $diaSemana + $dias;
        $finDeSemana = intval( $totalDias/5) * 2 ;
        $diaSabado = $totalDias % 5 ;
        if ($diaSabado == 6) $finDeSemana++;
        if ($diaSabado == 0) $finDeSemana = $finDeSemana - 2;
        
        $total = (($dias + $finDeSemana) * 86400) + $fechaInicial ;
        $fechaFinal = date('Y-m-d H:i:s', $total);
        
        return $fechaFinal;
    }
    
    
    /**
     * Funcion que devuleve una fecha en letras
     */
    public function devolverFechaEnLetras($fecha)
    {
        $fecha = substr($fecha, 0, 10);
        $numeroDia = date('d', strtotime($fecha));
        $dia = date('l', strtotime($fecha));
        $mes = date('F', strtotime($fecha));
        $anio = date('Y', strtotime($fecha));
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
        
        return  $nombredia . ", " . $numeroDia . " de " . $nombreMes . " de " . $anio;
    }
    
    /**
     * Ejecuta una consulta(SQL) personalizada
     * para actualizar los datos de lugar de inspeccion
     *
     * @return array|ResultSet
     */
    public function actualizarDatosLugarInspeccion($arrayParametros)
    {
        
        $idInspeccionFitosanitaria = $arrayParametros['id_inspeccion_fitosanitaria'];
        $nombreArea = $arrayParametros['nombre_area'];
        $idProvinciaArea = $arrayParametros['id_provincia_area'];
        $latitud = $arrayParametros['latitud'];
        $longitud = $arrayParametros['longitud'];
        $fechaInspeccion = $arrayParametros['fecha_inspeccion'];
        $horaInspeccion = $arrayParametros['hora_inspeccion'];
        $observacion = $arrayParametros['observacion'];
        
        $consulta = "UPDATE 
                        	g_inspeccion_fitosanitaria.inspeccion_fitosanitaria
                        SET
                        	id_area = null
                        	, nombre_area = '" . $nombreArea . "'
                        	, codigo_area = null
                        	, direccion_area = null
                        	, id_provincia_area = '" . $idProvinciaArea . "'
                        	, nombre_provincia_area = null
                            , latitud = '" . $latitud ."'
                            , longitud = '" . $longitud . "'
                            , fecha_inspeccion = '" . $fechaInspeccion . "'
                            , hora_inspeccion = '" . $horaInspeccion ."'
                            , observacion = '" . $observacion ."'
                        WHERE 
                        	id_inspeccion_fitosanitaria = '" . $idInspeccionFitosanitaria . "';";
                                                        
        return $this->modeloInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
    }
    
    /**
     * Generar documento de inspeccion fitosanitaria
     *
     * @return
     */
    public function generarDocumentoInspeccionFitosanitaria($idInspeccionFitosanitaria, $rutaFecha, $nombreDocumento){
        
        $jasper = new JasperReport();
        $datosReporte = array();
        
        $ruta = INS_FITO_RUT_COMPL . $rutaFecha;
        
        if (! file_exists($ruta)){
            mkdir($ruta, 0777, true);
        }
        
        $rutaArchivo = 'InspeccionFitosanitaria/archivos/';
        $nombreArchivo = $nombreDocumento;
        
        $datosReporte = array(
            'rutaReporte' => 'InspeccionFitosanitaria/vistas/reportes/inspeccionFitosanitaria.jasper',
            'rutaSalidaReporte' => $rutaArchivo . $rutaFecha . $nombreArchivo,
            'tipoSalidaReporte' => array('pdf'),
            'parametrosReporte' => array('idInspeccionFitosanitaria' => (integer) $idInspeccionFitosanitaria,
                'fondoCertificado' => RUTA_IMG_GENE.'fondoCertificado.png'),
            'conexionBase' => 'SI'
        );
        
        $jasper->generarArchivo($datosReporte);
        
    }
    
    /**
     * Ejecuta una consulta(SQL) personalizada
     * para obtener los datos del inspector
     *
     * @return array|ResultSet
     */
    public function obtenerDatosInspector($arrayParametros)
    {
        
        $identificadorInspector = $arrayParametros['identificador'];
        
        $consulta = "SELECT
                    	ti.identificador
                    	, ti.nombre_inspector
                    FROM(SELECT
                    		identificador
                    		, nombre || ' ' || apellido AS nombre_inspector
                    	FROM
                    		g_uath.ficha_empleado
                    	UNION
                    	SELECT
                    		identificador
                    		, CASE WHEN razon_social = '' then nombre_representante ||' '|| apellido_representante else razon_social END AS nombre_inspector
                    	FROM
                    	g_operadores.operadores) ti
                    WHERE
                    	ti.identificador = '" . $identificadorInspector . "';";
        
        return $this->modeloInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
    }

	/**
     * Ejecuta una consulta(SQL) personalizada
     * para verificar si una inspeccion ya fue usada en un CFE
     *
     * @return array|ResultSet
     */
    public function verificarUsoInspeccionFitosanitaria($idInspeccionFitosanitaria)
    {
        
        $consulta = "SELECT
                			if.id_inspeccion_fitosanitaria
                			, if.numero_solicitud
                			, if.identificador_solicitante
                		FROM
                			g_inspeccion_fitosanitaria.inspeccion_fitosanitaria if
                			INNER JOIN g_inspeccion_fitosanitaria.total_inspeccion_fitosanitaria tif ON tif.id_inspeccion_fitosanitaria = if.id_inspeccion_fitosanitaria
                			INNER JOIN g_certificado_fitosanitario.certificado_fitosanitario_productos cfp ON cfp.id_total_inspeccion_fitosanitaria = tif.id_total_inspeccion_fitosanitaria
                		WHERE
                			if.id_inspeccion_fitosanitaria = '" . $idInspeccionFitosanitaria . "';";
        
        return $this->modeloInspeccionFitosanitaria->ejecutarSqlNativo($consulta);
    }

}
