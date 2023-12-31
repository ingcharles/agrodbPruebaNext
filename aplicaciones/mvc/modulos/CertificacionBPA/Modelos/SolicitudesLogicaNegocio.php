<?php
 /**
 * Lógica del negocio de SolicitudesModelo
 *
 * Este archivo se complementa con el archivo SolicitudesControlador.
 *
 * @author  AGROCALIDAD
 * @date    2020-03-23
 * @uses    SolicitudesLogicaNegocio
 * @package CertificacionBPA
 * @subpackage Modelos
 */

namespace Agrodb\CertificacionBPA\Modelos;

use Agrodb\CertificacionBPA\Modelos\IModelo;
use Agrodb\Token\Modelos\TokenLogicaNegocio;
use Agrodb\FormulariosInspeccion\Modelos\Bpaf01LogicaNegocio;
use Agrodb\FormulariosInspeccion\Modelos\Bpaf01DetalleLogicaNegocio;
use Agrodb\RevisionFormularios\Modelos\AsignacionInspectorLogicaNegocio;
use Agrodb\RegistroOperador\Modelos\OperacionesLogicaNegocio;




use Agrodb\Core\Excepciones\GuardarExcepcion;
use Agrodb\Core\Excepciones\GuardarExcepcionConDatos;
use Agrodb\Core\Excepciones\BuscarExcepcion;
use Agrodb\Core\JasperReport;
use Agrodb\Correos\Modelos\CorreosLogicaNegocio;
use Agrodb\Core\Constantes;
use Exception;

class SolicitudesLogicaNegocio implements IModelo
{

    private $modeloSolicitudes = null;
    private $lNegocioToken = null;
    private $lNegocioBpaf01DetalleLogica = null;
    private $lNegocioBpaf01Logica = null;
    private $lNegocioOperaciones = null;
    private $lNegocioCorreos = null;
    private $rutaFecha  = null;
    /* Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloSolicitudes = new SolicitudesModelo();
        $this->lNegocioToken = new TokenLogicaNegocio();
        $this->lNegocioBpaf01DetalleLogica = new Bpaf01DetalleLogicaNegocio();
        $this->lNegocioBpaf01Logica = new Bpaf01LogicaNegocio();
        $this->lNegocioOperaciones = new OperacionesLogicaNegocio();
        $this->lNegocioCorreos = new CorreosLogicaNegocio();
        $this->rutaFecha = date('Y') . '/' . date('m') . '/' . date('d');
    }

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new SolicitudesModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		
		if ($tablaModelo->getIdSolicitud() != null && $tablaModelo->getIdSolicitud() > 0) {
		    return $this->modeloSolicitudes->actualizar($datosBd, $tablaModelo->getIdSolicitud());
		} else {
    		unset($datosBd["id_solicitud"]);
    		return $this->modeloSolicitudes->guardar($datosBd);
    	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloSolicitudes->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return SolicitudesModelo
	*/
	public function buscar($id)
	{
		return $this->modeloSolicitudes->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloSolicitudes->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloSolicitudes->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarSolicitudes()
	{
	$consulta = "SELECT * FROM ".$this->modeloSolicitudes->getEsquema().". solicitudes";
		 return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
	}

	public function buscarEstadoSolicitudes($identificador)
	{
	    $consulta = "   SELECT 
                            DISTINCT estado
                        FROM
                            g_certificacion_bpa.solicitudes
                        WHERE
                            identificador in ('$identificador')
                        GROUP BY
                            estado; ";
	    
	    return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
	}
	
	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 * Buscar solicitudes usando filtros.
	 *
	 * @return array|ResultSet
	 */
	public function buscarSolicitudesFiltradas($arrayParametros)
	{
	    $busqueda = '';
	    
	    if (isset($arrayParametros['id_solicitud']) && ($arrayParametros['id_solicitud'] != '')) {
	        $busqueda .= " and s.id_solicitud = " . $arrayParametros['id_solicitud'] . "";
	    } 
	    
	    $consulta = "  SELECT
                        	*
                        FROM
                        	g_certificacion_bpa.solicitudes s
                        WHERE
                            s.estado = 'Aprobado' 
                            " . $busqueda . "
                        ORDER BY
                        	s.id_solicitud ASC;";
	    
	    //echo $consulta;
	    return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
	}
	
	public function verificarAnularSolicitud($idSolicitud)
	{
	    $validacion = array(
	        'bandera' => false,
	        'estado' => "Fallo",
	        'mensaje' => "Ocurrió un error al anular la solicitud de certificación BPA",
	        'contenido' => null
	    );
	    
	    $resultado = $this->anularSolicitudes($idSolicitud);
	    
	    if ($resultado) {
	        $validacion['estado'] = "exito";
	        $validacion['mensaje'] = "Se ha anulado el registro.";
	        $validacion['bandera'] = true;
	    } else {
	        $validacion['estado'] = "Fallo";
	        $validacion['mensaje'] = "Ocurrió un error al anular la solicitud de BPA.";
	        $validacion['bandera'] = false;
	    }
	    
	    return $validacion;
	}
	
	/**
	 * Ejecuta una consulta(SQL) personalizada para obtener los productos que pueden ser modificados
	 *
	 * @return array|ResultSet
	 */
	public function anularSolicitudes($idSolicitud)
	{
	    $consulta = "UPDATE
                        g_certificacion_bpa.solicitudes
                	SET
                        estado='Anulado',
                        observacion_revision='Anulado por administrador ".$_SESSION['usuario']." en ".date('Y-m-d H:i:s')."'
                	WHERE
                        id_solicitud in ($idSolicitud);";
	    
	    return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
	}
 /**
     * Ejecuta consulta(SQL), para la obtención de las solicitudes en estado de inspección.
     *
     * @return array|ResultSet
     */
    public function buscarSolicitudesBpaInspeccionMovil($arrayParametros)
    {

        $arrayToken = $this->lNegocioToken->validarToken(RUTA_PUBLIC_KEY_AGROSERVICIOS);

        if ($arrayToken['estado'] == 'exito') {
            $res = null;
            $consulta = "SELECT row_to_json (res) AS res FROM ( SELECT array_to_json(array_agg(row_to_json(listado))) as cuerpo FROM (
                        	SELECT
                        		s.id_solicitud
                        		, s.identificador
                        		, s.fecha_creacion
                        		, s.es_asociacion
                        		, s.tipo_solicitud
                        		, s.tipo_explotacion
                        		, s.identificador_operador
                        		, UPPER(CASE WHEN s.razon_social = '' THEN s.nombre_representante_legal ELSE s.razon_social END) AS nombre_operador
                        		, st.nombre_lugar AS nombre_sitio
                                , st.provincia || ' - ' || st.canton || ' - ' || st.parroquia  AS ubicacion_sitio
                                , o.telefono_uno || ' - ' || o.celular_uno || ' - ' || o.correo  AS contacto_operador
                                , st.direccion AS direccion_sitio
                        		,  STRING_AGG(sap.nombre_producto, ', ') AS nombre_productos
                        		, s.estado
                        		, to_char(s.fecha_auditoria_programada, 'YYYY-MM-DD') AS fecha_auditoria_programada
                        		, s.provincia_revision
                        		, s.fecha_revision
                        		, s.tipo_revision
                                , g.nombre_resolucion
                        	FROM
                        		g_certificacion_bpa.solicitudes s
                        		INNER JOIN g_certificacion_bpa.sitios_areas_productos sap ON s.id_solicitud = sap.id_solicitud
								INNER JOIN g_operadores.sitios st ON s.id_sitio_unidad_produccion = st.id_sitio
                        		INNER JOIN g_operadores.operadores o ON s.identificador = o.identificador
                        		INNER JOIN g_catalogos.localizacion l ON UPPER(s.provincia_revision) = UPPER(l.nombre) and categoria = 1
                                INNER JOIN g_catalogos.guias_buenas_practicas g ON g.id_guia_buenas_practicas = s.id_resolucion
                        	WHERE
                        		s.estado in ('inspeccion')
                                AND s.id_resolucion = 1
                        		AND l.id_localizacion = " . $arrayParametros['provincia'] . "
                        		GROUP BY s.id_solicitud, nombre_operador, st.id_sitio, l.id_localizacion, o.telefono_uno || ' - ' || o.celular_uno || ' - ' || o.correo, g.nombre_resolucion
                        		ORDER BY s.id_solicitud
                        	) AS listado ) AS res;";

            $array = array();

            try {
                $res = $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
                $array['estado'] = 'exito';
                $array['mensaje'] = "Los datos han sido obtenidos satisfactoriamente";
                $cuerpo = json_decode($res->current()->res, true);
                $array['cuerpo'] = $cuerpo['cuerpo'] != null ? $cuerpo['cuerpo'] : [];
                echo json_encode($array);
            } catch (Exception $ex) {
                $array['estado'] = 'error';
                $array['mensaje'] = 'Error al obtener datos: ' . $ex;
                http_response_code(400);
                echo json_encode($array);
                throw new BuscarExcepcion($ex, array('archivo' => 'SolicitudesLogicaNegocio', 'metodo' => 'buscarSolicitudesBpaInspeccionMovil', 'consulta' => $consulta));
            }
        } else {
            echo json_encode($arrayToken);
        }
    }

    /**
     * Método para realizar el proceso de guardado de inspección de certificado BPA por apliactivo movil.
     *
     * @return array|ResultSet
     */
    public function guardarDatosInspeccionMovil($arrayParametros)
    {

        $arrayToken = $this->lNegocioToken->validarToken(RUTA_PUBLIC_KEY_AGROSERVICIOS);

        if ($arrayToken['estado'] == 'exito') {

            try {

                $procesoIngreso = $this->modeloSolicitudes->getAdapter()
                    ->getDriver()
                    ->getConnection();
                $procesoIngreso->beginTransaction();


                foreach ($arrayParametros['inspeccion'] as $value) {

                    $arrayResultadoInspeccion = array();
                    $arrayResumenChecklistInspeccion = array();
                    $arrayAuditoria = array();

                    foreach ($value->cabecera as $cabeceraLlave => $cabeceraValor) {
                        $arrayResultadoInspeccion += [
                            $cabeceraLlave => $cabeceraValor
                        ];
                    }

                    $solicitudBPA = $this->buscar($arrayResultadoInspeccion['id_solicitud']);

                    if ($solicitudBPA->getFechaAuditoria() == null) {
                        $arrayResultadoInspeccion += [
                            'fecha_auditoria' => $arrayResultadoInspeccion['fecha_auditoria']
                        ];
                    } else {
                        $arrayAuditoria = array(
                            'idSolicitud' => $arrayResultadoInspeccion['id_solicitud'],
                            'tipoAuditoria' => 'Complementaria'
                        );

                        $auditoriaComplementaria = $this->buscarAuditoriasSolicitadas($arrayAuditoria);

                        if (isset($auditoriaComplementaria->current()->id_solicitud)) {
                            $arrayResultadoInspeccion += [
                                'fecha_auditoria_complementaria' => $arrayResultadoInspeccion['fecha_auditoria']
                            ];
                        }
                    }

                    // Registra la fecha máxima en la que el usuario debe dar respuesta a la subsanación solicitada
                    $estado = $arrayResultadoInspeccion['estado'];
                    $idSolicitud  = $arrayResultadoInspeccion['id_solicitud'];
                    if ($estado == 'subsanacion') {
                        $fechaMaxRespuesta = $this->sumaDiaSemana(date("Y-m-d"), 15);
                        $arrayResultadoInspeccion += [
                            'fecha_max_respuesta' => $fechaMaxRespuesta
                        ];
                    }else if ($estado == 'noHabilitado') {
                        $arrayResultadoInspeccion['estado'] = "Rechazado";
                    }
                    //                 // Realiza la actualizacion de los campos de la tabla de solicitud
                    $idDatoInspeccionMovil = $this->guardar($arrayResultadoInspeccion);
                    $arrayResultadoInspeccion['estado'] = $estado;
                    if ($idDatoInspeccionMovil) {

                        //Actualiza los resumenes de inspecciones anteriores
                        $this->lNegocioBpaf01Logica->actualizarEstadoInspeccionBpaPorIdSolicitud($idSolicitud);

                        foreach ($value->checklist_resumen as $resumenChecklistLlave => $resumenChecklistValor) {

                            if (!is_array($resumenChecklistValor)) {
                                $arrayResumenChecklistInspeccion += [
                                    $resumenChecklistLlave => $resumenChecklistValor
                                ];
                            }
                        }

                        // Guarda el resumen de checklist de inspeccion
                        $idInspeccionBpa = $this->lNegocioBpaf01Logica->guardar($arrayResumenChecklistInspeccion);

                        foreach ($value->checklist_resumen->checklist_inspeccion as $item) {
                            $item->id_padre = $idInspeccionBpa;
                            $array = json_decode(json_encode($item), true);

                            $this->lNegocioBpaf01DetalleLogica->guardar($array);
                        }


                        $idSitio = $solicitudBPA->getIdSitioUnidadProduccion();
                        $solicitudes = $this->obtenerSolicitudesPorAsignarInspector($idSitio);
                        $arrayResultadoInspeccion['tipo_solicitud'] = "certificacionBPA";
                        foreach ($solicitudes as $fila) {
                            $arrayResultadoInspeccion['id_operacion'] = $fila['id_operacion'];

                            $this->lNegocioOperaciones->guardarResultadoInspeccion($arrayResultadoInspeccion);
                        }

                        //En caso de que el certificado debiera de generarse en la etapa de inspeccion descomentar este codigo
                        // if ($estado == 'Aprobado') {
                        //     //$solicitudBpa = $this->buscar($idSolicitud);
                        //     $tipoExplotacion = $solicitudBPA->getTipoExplotacion();
                        //     $identificador = $solicitudBPA->getIdentificadorOperador();
                        //     $fechaAuditoriaReal = $solicitudBPA->getFechaAuditoria();
                        //     $fechaAuditoriaComplementaria = $solicitudBPA->getFechaAuditoriaComplementaria();
                        //     $provinciaUnidadProduccion = $solicitudBPA->getProvinciaUnidadProduccion();
                        //     if ($fechaAuditoriaComplementaria != null) {
                        //         $fechaAuditoria = $fechaAuditoriaComplementaria;
                        //     } else {
                        //         $fechaAuditoria = $fechaAuditoriaReal;
                        //     }

                        //     //poner las fechas de aprobacion de inicio y fin (3 años)
                        //     $this->generarFechasVigencia($idSolicitud, $solicitudBPA->getTipoSolicitud(), $fechaAuditoria);

                        //     //crear el numero de certificado y guardar en el registro (crear funcion de numero certificado y de actualizar en registro
                        //     $certificado = '';

                        //     switch ($tipoExplotacion) {
                        //         case 'SA':
                        //             $area = 'PP';
                        //             break;
                        //         case 'SV':
                        //             $area = 'PA';
                        //             break;
                        //         case 'AI':
                        //             $area = 'PO';
                        //             break;
                        //     }


                        //     //buscar la combinacion del codigo hasta antes de la provincia y ver el numero para crear un secuencial
                        //     $anio = date("Y");
                        //     $certificado = 'AGRO-CBPA-' . $area . '-' . $identificador;
                        //     $secuencial = $this->generarNumeroCertificado($certificado);


                        //     // //guardar el código del certificado y el secuencial
                        //     // $this->lNegocioSolicitudes->actualizarEstadoSitiosSolicitud($idSolicitud, $secuencial, $certificado);


                        //     //guardar el código del certificado y el secuencial
                        //     $this->actualizarSecuencialCertificado($idSolicitud, $secuencial, $certificado);

                        //     //Creación de Certificado PDF
                        //     $nombreArchivo = 'bpa_' . $idSolicitud;

                        //     $rutaArchivo = CERT_BPA_URL_CERT_ADJ . $nombreArchivo . '.pdf';

                        //     $jasper = new JasperReport();
                        //     $datosReporte = array();

                        //     $ruta = CERT_BPA_URL_CERT;

                        //     if (!file_exists($ruta)) {
                        //         mkdir($ruta, 0777, true);
                        //     }

                        //     //Tabla de firmas físicas
                        //     $firmaResponsable = $this->lNegocioResponsablesCertificadosNegocio->obtenerFirmasResponsablePorProvincia($provinciaUnidadProduccion, 'AI');


                        //     $this->guardarRutaCertificado($idSolicitud, $rutaArchivo);

                        //     //Firma Electrónica
                        //     $parametrosFirma = array(
                        //         'archivo_entrada' => $rutaArchivo,
                        //         'archivo_salida' => $rutaArchivo,
                        //         'identificador' => $firmaResponsable->current()->identificador,
                        //         'razon_documento' => 'Certificado BPA',
                        //         'tabla_origen' => 'g_certificacion_bpa.solicitudes',
                        //         'campo_origen' => 'ruta_certificado',
                        //         'id_origen' => $idSolicitud,
                        //         'estado' => 'Por atender',
                        //         'proceso_firmado' => 'NO'
                        //     );

                        //     //Guardar registro para firma
                        //     $this->lNegocioFirmantesLogicaNegocio->ingresoFirmaDocumento($parametrosFirma);
                        // }
                        // if ($estado == "Aprobado") {
                        //     $datosReporte = array(
                        //         'rutaReporte' => 'CertificacionBPA/vistas/reportes/CertificadoNacional.jasper',
                        //         'rutaSalidaReporte' => 'CertificacionBPA/archivos/certificados/' . $nombreArchivo,
                        //         'tipoSalidaReporte' => array('pdf'),
                        //         'parametrosReporte' => array(
                        //             'idSolicitud' => (int)$idSolicitud,
                        //             'identificador' => $firmaResponsable->current()->identificador,
                        //             'rutaFondo' => RUTA_IMG_GENE . 'fondoCertificado.png'
                        //         ),
                        //         'conexionBase' => 'SI'
                        //     );

                        //     $jasper->generarArchivo($datosReporte);
                        // }


                    }
                }
                echo json_encode(array('estado' => 'exito', 'mensaje' => 'Registros almancenados en el Sistema GUIA exitosamente'));
                $procesoIngreso->commit();
            } catch (Exception $ex) {
                echo json_encode(array('estado' => 'error', 'mensaje' => $ex->getMessage()));
                $procesoIngreso->rollback();
                throw new GuardarExcepcionConDatos($ex);
            }
        } else {
            echo json_encode($arrayToken);
        }
    }

    public function buscarAuditoriasSolicitadas($arrayParametros)
    {

        $idSolicitud = $arrayParametros['idSolicitud'];
        $tipoAuditoria = $arrayParametros['tipoAuditoria'];

        $consulta = "SELECT
                    	a.*
                    FROM
                    	g_certificacion_bpa.auditorias_solicitadas a
                    WHERE
                    	a.id_solicitud =  " . $idSolicitud . " and
                    	a.id_tipo_auditoria in (
                    		SELECT
                    			id_tipo_auditoria
                    		FROM
                    			g_certificacion_bpa.tipos_auditorias
                    		WHERE
                            	tipo_auditoria like '%" . $tipoAuditoria . "%' and
                            	estado = 'Activo') and
                    	a.estado = 'Activo';";

        return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
    }

    public function sumaDiaSemana($fecha, $dias)
    {

        $datestart = strtotime($fecha);
        $diasemana = date('N', $datestart);
        $totaldias = $diasemana + $dias;
        $findesemana = intval($totaldias / 5) * 2;
        $diasabado = $totaldias % 5;
        if ($diasabado == 6) $findesemana++;
        if ($diasabado == 0) $findesemana = $findesemana - 2;

        $total = (($dias + $findesemana) * 86400) + $datestart;

        return date('Y-m-d', $total);
    }


    /**
     * Función para crear el PDF del checklist de inspeccion
     */
    public function generarChecklistInspeccionBpa($idSolicitud, $nombreArchivo)
    {
        $jasper = new JasperReport();
        $datosReporte = array();

        $ruta = CERT_BPA_URL_CHECK_MOV_TCPDF . $this->rutaFecha . '/';

        if (!file_exists($ruta)) {
            mkdir($ruta, 0777, true);
        }

        $rutaChecklistBpa = CERT_BPA_URL_CHECK_MOV . $this->rutaFecha . '/';

        $datosReporte = array(
            'rutaReporte' => 'CertificacionBPA/vistas/reportes/checklistAplicativoMovilBpa.jasper',
            'rutaSalidaReporte' => 'CertificacionBPA/archivos/checklistsMovil/' . $this->rutaFecha . '/' . $nombreArchivo,
            'tipoSalidaReporte' => array('pdf'),
            'parametrosReporte' => array('idSolicitud' => $idSolicitud, 'rutaLogoAgro' => RUTA_IMG_GENE . 'agrocalidad.png'),
            'conexionBase' => 'SI'
        );

        $jasper->generarArchivo($datosReporte);

        $rutaChecklist = $rutaChecklistBpa . $nombreArchivo . '.pdf';

        return $rutaChecklist;
    }


    public function obtenerSolicitudesPorGenerarChecklist()
    {

        $consulta = "SELECT
                    	DISTINCT
                    	so.id_solicitud
                    	, so.identificador
                    	, so.fecha_creacion
                    	, so.es_asociacion
                    	, so.tipo_solicitud
                    	, so.tipo_explotacion
                    	, so.origen_inspeccion
                    	, so.estado_checklist
						, op.id_operador_tipo_operacion
                    FROM
                    	g_certificacion_bpa.solicitudes so 
						INNER JOIN g_operadores.areas ar ON so.id_sitio_unidad_produccion = ar.id_sitio and ar.estado = 'creado'
						INNER JOIN g_operadores.productos_areas_operacion pa ON pa.id_area = ar.id_area and pa.estado = 'registrado'
						INNER JOIN g_operadores.operaciones op ON op.id_operacion = pa.id_operacion and op.estado = 'registrado'
						INNER JOIN g_catalogos.tipos_operacion top ON top.id_tipo_operacion = op.id_tipo_operacion and	top.codigo || top.id_area IN ('PROAI','PROSA','PROSV')
                    WHERE
                    	origen_inspeccion = 'aplicativoMovil'
                    	and estado_checklist = 'generar';";

        return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
    }

    public function obtenerSolicitudesPorAsignarInspector($idSitio)
    {

        $consulta = "SELECT
                    	DISTINCT
                    	so.id_solicitud
                    	, so.identificador
                    	, so.fecha_creacion
                    	, so.es_asociacion
                    	, so.tipo_solicitud
                    	, so.tipo_explotacion
                    	, so.origen_inspeccion
                    	, so.estado_checklist
						, op.id_operador_tipo_operacion
                        , min(op.id_operacion) AS id_operacion
                    FROM
                    	g_certificacion_bpa.solicitudes so 
						INNER JOIN g_operadores.areas ar ON so.id_sitio_unidad_produccion = ar.id_sitio and ar.estado = 'creado'
						INNER JOIN g_operadores.productos_areas_operacion pa ON pa.id_area = ar.id_area and pa.estado = 'registrado'
						INNER JOIN g_operadores.operaciones op ON op.id_operacion = pa.id_operacion and op.estado = 'registrado'
						INNER JOIN g_catalogos.tipos_operacion top ON top.id_tipo_operacion = op.id_tipo_operacion and	top.codigo || top.id_area IN ('PROAI','PROSA','PROSV')
                    WHERE
                    	origen_inspeccion = 'aplicativoMovil'
                    	and estado_checklist = 'generar'
                        and so.id_sitio_unidad_produccion =  " . $idSitio . "
                        group by id_solicitud, id_operador_tipo_operacion;";

        return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
    }


    public function actualizarEstadoSitiosSolicitud($idSolicitud, $estado)
    {

        $consulta = "UPDATE
                        g_certificacion_bpa.sitios_areas_productos
                    SET
                        estado = '$estado'
                    WHERE
                        id_solicitud = $idSolicitud;";

        return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
    }

    public function actualizarSecuencialCertificado($idSolicitud, $secuencial, $certificado)
    {

        $consulta = "UPDATE
												g_certificacion_bpa.solicitudes
											SET
												numero_certificado = '$certificado',
                                                numero_secuencial = '$secuencial'
											WHERE
												id_solicitud = $idSolicitud;";

        return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
    }

    public function guardarRutaCertificado($idSolicitud, $certificado)
    {

        $consulta = "UPDATE
												g_certificacion_bpa.solicitudes
											SET
												ruta_certificado = '$certificado'
											WHERE
												id_solicitud = $idSolicitud;";

        return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);;
    }

    public function generarNumeroCertificado($formato)
    {

        $consulta = "SELECT
                                                max(numero_secuencial) as numero
                                             FROM
                                                g_certificacion_bpa.solicitudes
                                             WHERE
                                                numero_certificado like '%" . $formato . "%';";

        $resultado = $this->modeloSolicitudes->ejecutarConsulta($consulta);
        $codigo = 0;
        foreach ($resultado  as $fila) {
            $codigo  = $fila['numero'];
        }
        $incremento = $codigo + 1;
        $secuencial = str_pad($incremento, 5, "0", STR_PAD_LEFT);

        return $secuencial;
    }

    public function generarFechasVigencia($idSolicitud, $tipoSolicitud, $fechaAuditoria)
    {

        if ($tipoSolicitud == 'Nacional') {
            //$fechaInicio = date('Y-m-d');
            $fechaFin = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date($fechaAuditoria))) . " + 3 years"));

            $consulta = "UPDATE
    												g_certificacion_bpa.solicitudes
    											SET
    												fecha_inicio_vigencia = '$fechaAuditoria',
                                                    fecha_fin_vigencia = '$fechaFin'
    											WHERE
    												id_solicitud = $idSolicitud;";
        } else {
            $consulta = "UPDATE
    												g_certificacion_bpa.solicitudes
    											SET
    												fecha_inicio_vigencia = fecha_inicio_equivalente,
                                                    fecha_fin_vigencia = fecha_fin_equivalente
    											WHERE
    												id_solicitud = $idSolicitud;";
        }

        return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
    }



    /**
     * Función para enviar correo electrónico
     */
    public function enviarCorreoInspeccionBpa($idSolicitud)
    {
        $solicitud = $this->buscar($idSolicitud);
        $estadoSolicitud = $solicitud->getEstado();
        $rutaChecklist =  Constantes::RUTA_SERVIDOR_OPT . '/' . Constantes::RUTA_APLICACION . '/' . $solicitud->getRutaChecklist();
        $correo = $solicitud->getCorreo();
        $nombreOperador = $solicitud->getNombreRepresentanteLegal();
        if ($estadoSolicitud == 'aprobacion') {
            $estadoSolicitud  = 'Aprobado';
        }
        $arrayCorreo = array(
            'asunto' => 'Inspección de Buenas Prácticas Agropecuarias (BPA)',
            'cuerpo' => 'El área de Inocuidad de los alimentos de la Agencia remite el día ' . $this->rutaFecha . ' el resultado ' . $estadoSolicitud . ' de la inspección Nº ' . $idSolicitud . ', remitido a ' . $nombreOperador . '.',
            'estado' => 'Por enviar',
            'codigo_modulo' => 'PRG_CERT_BPA',
            'tabla_modulo' => 'g_certificacion_bpa.solicitudes',
            'id_solicitud_tabla' => $idSolicitud
        );

        $arrayDestinatario = array(
            $correo
        );

        $arrayAdjuntos = array(
            $rutaChecklist
        );

        return $this->lNegocioCorreos->crearCorreoElectronico($arrayCorreo, $arrayDestinatario, $arrayAdjuntos);
    }
}