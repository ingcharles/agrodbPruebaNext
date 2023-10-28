<?php
/**
 * Lógica del negocio de CentrosFaenamientoModelo
 *
 * Este archivo se complementa con el archivo CentrosFaenamientoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2018-11-21
 * @uses    CentrosFaenamientoLogicaNegocio
 * @package CentrosFaenamiento
 * @subpackage Modelos
 */
namespace Agrodb\CentrosFaenamiento\Modelos;

use Agrodb\CentrosFaenamiento\Modelos\IModelo;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class CentrosFaenamientoLogicaNegocio implements IModelo
{

    private $modeloCentrosFaenamiento = null;

    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloCentrosFaenamiento = new CentrosFaenamientoModelo();
    }

    /**
     * Guarda el registro actual
     * 
     * @param array $datos
     * @return int
     */
    public function guardar(Array $datos)
    {
        $datos['identificador_registro'] = $_SESSION['usuario'];
        $tablaModelo = new CentrosFaenamientoModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdCentroFaenamiento() != null && $tablaModelo->getIdCentroFaenamiento() > 0) {
            
            switch ($tablaModelo->getCriterioFuncionamiento()){
            case 'Habilitado':
            case 'Activo':
                $estado = 'registrado';
            break;
            case 'Clausurado temporalmente':
            case 'Clausurado definitivamente':
            case 'Cerrado temporalmente':
            case 'Cerrado definitivamente':
                $estado = 'noHabilitado';
            break;
            }
            
            $estadoOperacion = $this->obtenerEstadoOperacionesRegistroOperador(array('id_operador_tipo_operacion' => $tablaModelo->getIdOperadorTipoOperacion()));
            
            if( $estadoOperacion->current()->estado != $estado){
                $this->actualizarEstadoOperacion(array('id_operador_tipo_operacion' => $tablaModelo->getIdOperadorTipoOperacion(), 'estado' => $estado));
            }
            
            return $this->modeloCentrosFaenamiento->actualizar($datosBd, $tablaModelo->getIdCentroFaenamiento());
        } else {
            unset($datosBd["id_centro_faenamiento"]);
            return $this->modeloCentrosFaenamiento->guardar($datosBd);
        }
    }
    public function guardarRegistros(Array $datos){
        try{
            $this->modeloCentrosFaenamiento = new CentrosFaenamientoModelo();
            $proceso = $this->modeloCentrosFaenamiento->getAdapter()
            ->getDriver()
            ->getConnection();
            if (! $proceso->beginTransaction()){
                throw new \Exception('No se pudo iniciar la transacción: actualizar centros de faenamiento ');
            }
            
            $datos['identificador_registro'] = $_SESSION['usuario'];
            $tablaModelo = new CentrosFaenamientoModelo($datos);
            $datosBd = $tablaModelo->getPrepararDatos();
            if ($tablaModelo->getIdCentroFaenamiento() != null && $tablaModelo->getIdCentroFaenamiento() > 0) {
                
                switch ($tablaModelo->getCriterioFuncionamiento()){
                    case 'Habilitado':
                    case 'Activo':
                        $estado = 'registrado';
                        break;
                    case 'Clausurado temporalmente':
                    case 'Clausurado definitivamente':
                    case 'Cerrado temporalmente':
                    case 'Cerrado definitivamente':
                        $estado = 'noHabilitado';
                        break;
                }
                
                $estadoOperacion = $this->obtenerEstadoOperacionesRegistroOperador(array('id_operador_tipo_operacion' => $tablaModelo->getIdOperadorTipoOperacion()));
                
                if( $estadoOperacion->current()->estado != $estado){
                    $this->actualizarEstadoOperacion(array('id_operador_tipo_operacion' => $tablaModelo->getIdOperadorTipoOperacion(), 'estado' => $estado));
                }
                
                $this->modeloCentrosFaenamiento->actualizar($datosBd, $tablaModelo->getIdCentroFaenamiento());
            } else {
                unset($datosBd["id_centro_faenamiento"]);
                $idCentroFaenamiento = $this->modeloCentrosFaenamiento->guardar($datosBd);
            }
            
            // *****************detalle canton provincia*********************************************
            if (isset($datos['cantonProvincia'])){
                $arrayEliminar = array();
                $arrayGuardar = array();
                $arrayDatos = array();
                $lnegocioDetalleCantonProvincia = new DetalleCantonProvinciaLogicaNegocio();
                
                $verificarElemento = $lnegocioDetalleCantonProvincia->buscarLista("id_centro_faenamiento = " . $tablaModelo->getIdCentroFaenamiento());
                
                if ($verificarElemento->count()){
                    foreach ($verificarElemento as $valor1){
                        $arrayDatos[] = $valor1->id_localizacion;
                        $ban = 1;
                        foreach ($datos['cantonProvincia'] as $valor2){
                            if ($valor1->id_localizacion == $valor2){
                                $ban = 0;
                            }
                        }
                        if ($ban){
                            $arrayEliminar[] = $valor1->id_detalle_canton_provincia;
                        }
                    }
                    
                    foreach ($datos['cantonProvincia'] as $valor2){
                        $ban = 1;
                        foreach ($arrayDatos as $valor1){
                            if ($valor1 == $valor2){
                                $ban = 0;
                            }
                        }
                        if ($ban){
                            $arrayGuardar[] = $valor2;
                        }
                    }
                    foreach ($arrayEliminar as $value){
                        $statement = $this->modeloCentrosFaenamiento->getAdapter()
                        ->getDriver()
                        ->createStatement();
                        $sqlActualizar = $this->modeloCentrosFaenamiento->borrarSql('detalle_canton_provincia', $this->modeloCentrosFaenamiento->getEsquema());
                        $sqlActualizar->where(array(
                            'id_detalle_canton_provincia' => $value));
                        $sqlActualizar->prepareStatement($this->modeloCentrosFaenamiento->getAdapter(), $statement);
                        $statement->execute();
                    }
                    foreach ($arrayGuardar as $value){
                        $arrayElemento = array(
                            'id_centro_faenamiento' => $datos['id_centro_faenamiento'],
                            'id_localizacion' => $value );
                        $statement = $this->modeloCentrosFaenamiento->getAdapter()
                        ->getDriver()
                        ->createStatement();
                        $sqlInsertar = $this->modeloCentrosFaenamiento->guardarSql('detalle_canton_provincia', $this->modeloCentrosFaenamiento->getEsquema());
                        $sqlInsertar->columns($lnegocioDetalleCantonProvincia->columnas());
                        $sqlInsertar->values($arrayElemento, $sqlInsertar::VALUES_MERGE);
                        $sqlInsertar->prepareStatement($this->modeloCentrosFaenamiento->getAdapter(), $statement);
                        $statement->execute();
                    }
                }else{
                    foreach ($datos['cantonProvincia'] as $value){
                        $arrayElemento = array(
                            'id_centro_faenamiento' => $datos['id_centro_faenamiento'],
                            'id_localizacion' => $value);
                        $statement = $this->modeloCentrosFaenamiento->getAdapter()
                        ->getDriver()
                        ->createStatement();
                        $sqlInsertar = $this->modeloCentrosFaenamiento->guardarSql('detalle_canton_provincia', $this->modeloCentrosFaenamiento->getEsquema());
                        $sqlInsertar->columns($lnegocioDetalleCantonProvincia->columnas());
                        $sqlInsertar->values($arrayElemento, $sqlInsertar::VALUES_MERGE);
                        $sqlInsertar->prepareStatement($this->modeloCentrosFaenamiento->getAdapter(), $statement);
                        $statement->execute();
                    }
                }
            }else{
                $statement = $this->modeloCentrosFaenamiento->getAdapter()
                ->getDriver()
                ->createStatement();
                $sqlActualizar = $this->modeloCentrosFaenamiento->borrarSql('detalle_canton_provincia', $this->modeloCentrosFaenamiento->getEsquema());
                $sqlActualizar->where(array(
                    'id_centro_faenamiento' => $datos['id_centro_faenamiento']));
                $sqlActualizar->prepareStatement($this->modeloCentrosFaenamiento->getAdapter(), $statement);
                $statement->execute();
            }
            // ********************************************************************************************** 
            
            $proceso->commit();
            return true;
        }catch (\Exception $ex){
            $proceso->rollback();
            throw new \Exception($ex->getMessage());
            return false;
        }
    }

    /**
     * Borra el regis$lNegocioCentrosFaenamientotro actual
     * 
     * @param
     *            string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modeloCentrosFaenamiento->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return CentrosFaenamientoModelo
     */
    public function buscar($id)
    {
        return $this->modeloCentrosFaenamiento->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloCentrosFaenamiento->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloCentrosFaenamiento->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarCentrosFaenamiento()
    {
        $consulta = "SELECT * FROM " . $this->modeloCentrosFaenamiento->getEsquema() . ". centros_faenamiento";
        return $this->modeloCentrosFaenamiento->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada, para obtener el registro de operador
     *
     * @return array|ResultSet
     *
     */
    public function buscarFaenadorPorIdentificadorOperador($arrayParametros)
    {
        $busqueda = '';
        if (array_key_exists('id_sitio', $arrayParametros)) {
            $busqueda = "and s.id_sitio = " . $arrayParametros['id_sitio']." and a.id_area = ". $arrayParametros['id_area']." and op.id_operador_tipo_operacion = ". $arrayParametros['id_operador_tipo_operacion'] ;
        }
        if (array_key_exists('provincia', $arrayParametros)) {
            $busqueda = "and s.provincia = '" . $arrayParametros['provincia']."'";
        }
        
        $consulta = "SELECT
                    	o.identificador as identificador_operador,
                    	case when o.razon_social = '' then o.nombre_representante ||' '|| o.apellido_representante else o.razon_social end razon_social,
                    	s.provincia,
                        string_agg(distinct stp.nombre,', ') as especie,
                        s.id_sitio,
                        a.id_area,
                        a.nombre_area,
                        s.nombre_lugar,
                        op.id_operador_tipo_operacion,
                        cf.id_centro_faenamiento,
                        cf.criterio_funcionamiento,
                        cf.observacion,
                        cf.codigo,
                        cf.tipo_centro_faenamiento,
                        cf.tipo_habilitacion
                    FROM
                    	g_operadores.operadores o 
                    	INNER JOIN g_operadores.sitios s ON s.identificador_operador = o.identificador
                        INNER JOIN g_operadores.areas a ON a.id_sitio = s.id_sitio
                        INNER JOIN g_operadores.productos_areas_operacion pao ON pao.id_area = a.id_area
                        INNER JOIN g_operadores.operaciones op ON op.id_operacion = pao.id_operacion
                        INNER JOIN g_catalogos.tipos_operacion top ON top.id_tipo_operacion = op.id_tipo_operacion
                        INNER JOIN g_catalogos.productos p ON p.id_producto = op.id_producto
                        INNER JOIN g_catalogos.subtipo_productos stp ON stp.id_subtipo_producto = p.id_subtipo_producto
                        LEFT JOIN g_centros_faenamiento.centros_faenamiento cf ON cf.id_sitio = s.id_sitio and cf.id_area = a.id_area and cf.id_operador_tipo_operacion = op.id_operador_tipo_operacion
                    WHERE
                    	s.identificador_operador = '" . $arrayParametros['identificador_operador'] . "'
                        and top.id_area = '" . $arrayParametros['id_area_tipo_operacion'] . "'
                        and top.codigo = '" . $arrayParametros['codigo'] . "'
                        and op.estado in ('registrado','noHabilitado')
                        " . $busqueda . "
                    GROUP BY 
                        o.identificador, s.provincia, s.id_sitio, a.id_area, s.nombre_lugar, a.nombre_area,op.id_operador_tipo_operacion, cf.id_centro_faenamiento;";
        
        $this->modeloCentrosFaenamiento->setCodigoEjecutable($consulta);
        
        return $this->modeloCentrosFaenamiento->ejecutarSqlNativo($consulta);
    }
    
    public function obtenerEstadoOperacionesRegistroOperador($arrayParametros){
        
        $consulta = "SELECT distinct estado as estado FROM g_operadores.operaciones WHERE id_operador_tipo_operacion = '" . $arrayParametros['id_operador_tipo_operacion'] . "'";
        
        return $this->modeloCentrosFaenamiento->ejecutarSqlNativo($consulta);
    }
    
    public function actualizarEstadoOperacion($arrayParametros){

        $consulta = "update
						g_operadores.operaciones o
					set
						estado_anterior = op.estado,
                        estado = '".$arrayParametros['estado'] . "',
                        observacion = 'Estado actualizado por medio del módulo de centros de faenamiento.',
                        fecha_modificacion = 'now()',
                        observacion_tecnica = 'Estado actualizado por medio del módulo de centros de faenamiento.'
					from
						g_operadores.operaciones op
					where
						o.id_operacion = op.id_operacion and
						op.id_operador_tipo_operacion = '" . $arrayParametros['id_operador_tipo_operacion'] . "'";

        $this->modeloCentrosFaenamiento->ejecutarSqlNativo($consulta);
        
        $consulta = "UPDATE 
                    	g_operadores.productos_areas_operacion pao
                    SET 
                    	estado = op.estado
                    FROM 
                    	g_operadores.operaciones op
                    WHERE
                    	pao.id_operacion = op.id_operacion
                    	and op.id_operador_tipo_operacion = '" . $arrayParametros['id_operador_tipo_operacion'] . "'";

        $this->modeloCentrosFaenamiento->ejecutarSqlNativo($consulta);
        
        $consulta = "UPDATE
                    	g_operadores.operadores_tipo_operaciones
                    SET
                    	estado = '".$arrayParametros['estado'] . "'
                    WHERE
                    	id_operador_tipo_operacion = '" . $arrayParametros['id_operador_tipo_operacion'] . "'";

        $this->modeloCentrosFaenamiento->ejecutarSqlNativo($consulta);
    }
//**************************modificado el 02-12-2020********************************
    public function obtenerNombreLocalizacion($idLocalizacion){
        
        $consulta = "SELECT 
                            nombre 
                    FROM 
                           g_catalogos.localizacion
                    WHERE id_localizacion = $idLocalizacion;";
        
        return $this->modeloCentrosFaenamiento->ejecutarSqlNativo($consulta);
    }

    public function obtenerDatosMovilizacionEmisionOrigen($arrayParametros){

        if ($arrayParametros['fecha_inicio'] != '' && $arrayParametros['fecha_fin'] != ''){ 
            $condicion = "detemisi.fecha_creacion::date BETWEEN '".$arrayParametros['fecha_inicio']."' AND '".$arrayParametros['fecha_fin']."'";
        }

        if ($arrayParametros['ruc'] != ''){
            $condicion.=" AND emisi.identificador_operador = '".$arrayParametros['ruc']."'";
        }

        if ($arrayParametros['provincia'] != ''){
            $condicion.=" AND sit.provincia = '".$arrayParametros['provincia']."'";
        }

        if ($arrayParametros['estado'] != ''){
            $condicion.=" AND cf.criterio_funcionamiento = '".$arrayParametros['estado']."'";
        }

   
        
        $consulta = "SELECT detemisi.fecha_creacion::date,emisi.identificador_operador::text, ope.razon_social,sit.nombre_lugar,
					sit.provincia, sit.canton,cf.criterio_funcionamiento, 
					TRIM(detemisi.tipo_especie) as tipo_especie,
					SUM(distinct p.num_animales_recibidos) numero_animales_recibidos,
					SUM(distinct p.num_canales_obtenidos) num_canales_obtenidos,
					SUM(distinct p.num_canales_uso_industri) num_canales_uso_industri,
					count(distinct detemisi.codigo_canal) as canales_movilizados,
					count(distinct emisi.id_emision_certificado) as numero_certificados,
					STRING_AGG(distinct emisi.id_emision_certificado::text,'-') as id_certificado,
					emisi.sitio_origen, emisi.area_origen, cf.codigo,string_agg(to_char(detemisi.fecha_creacion, 'yyyy-MM-dd HH24:MI:SS'),' / ') as fecha_creacion_produccion
					FROM g_emision_certificacion_origen.detalle_emision_certificado detemisi 
					INNER JOIN g_emision_certificacion_origen.emision_certificado emisi ON emisi.id_emision_certificado = detemisi.id_emision_certificado 
					INNER JOIN g_operadores.operadores ope ON ope.identificador = emisi.identificador_operador 
					INNER JOIN g_operadores.sitios sit ON sit.id_sitio = emisi.sitio_origen 
					INNER JOIN g_operadores.areas ar ON ar.id_area = emisi.area_origen 
					INNER JOIN g_emision_certificacion_origen.productos p ON p.id_productos = detemisi.id_productos 
					LEFT JOIN (select codigo,criterio_funcionamiento,id_sitio,id_area,especie from g_centros_faenamiento.centros_faenamiento) as cf ON (cf.id_sitio = emisi.sitio_origen AND cf.id_area = emisi.area_origen ) 
					WHERE (detemisi.estado_detalle = 'activo' or detemisi.estado_detalle is null) AND ".$condicion."
					GROUP BY detemisi.fecha_creacion::date, emisi.identificador_operador::text,ope.razon_social,sit.nombre_lugar,sit.provincia, sit.canton, detemisi.tipo_especie,emisi.sitio_origen,
								 emisi.area_origen, cf.codigo, cf.criterio_funcionamiento";
        
        return $this->modeloCentrosFaenamiento->ejecutarSqlNativo($consulta);
    }

    public function exportarArchivoExcelEmisionCertificacion($qDatos){
		$hoja = new Spreadsheet();
		$documento = $hoja->getActiveSheet();
		$i = 3;
		
		$estiloArrayTitulo = [
		    'alignment' => [
		        'horizontal' => 'center',
		        'vertical' => 'center',
		    ],
		    'font' => [
		        'name' => 'Calibri',
		        'bold' => true,
		        'size' => 18
		    ]
		];
		
		$estiloArrayCabecera = [
		    'alignment' => [
		        'horizontal' => 'center',
		        'vertical' => 'center',
		    ],
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => 'thin',
		            'color' => ['argb' => 'FF000000'],
		        ],
		    ],
		    'font' => [
		        'name' => 'Calibri',
		        'bold' => true,
		        'size' => 11,
		        'color' => ['argb' => 'FFFFFFFF'],
		    ],
		    'fill' => [
		        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
		        'rotation' => 90,
		        'startColor' => [
		            'argb' => 'FF6495ED',
		        ],
		        'endColor' => [
		            'argb' => 'FF6495ED',
		        ],
		    ],
		];
		
		$documento->getStyle('A1:D1')->applyFromArray($estiloArrayTitulo);
		$documento->getStyle('A2:N2')->applyFromArray($estiloArrayCabecera);
		
		$documento->setCellValueByColumnAndRow(1, 1, 'INFORME DE CENTROS DE FAENAMIENTO');
		$documento->mergeCells('A1:N1');
		$documento->getColumnDimension('A')->setAutoSize(true);
		$documento->getColumnDimension('B')->setAutoSize(true);
		$documento->getColumnDimension('C')->setAutoSize(true);
		$documento->getColumnDimension('D')->setAutoSize(true);
		$documento->getColumnDimension('E')->setAutoSize(true);
		$documento->getColumnDimension('F')->setAutoSize(true);
		$documento->getColumnDimension('G')->setAutoSize(true);
		$documento->getColumnDimension('H')->setAutoSize(true);
		$documento->getColumnDimension('I')->setAutoSize(true);
		$documento->getColumnDimension('J')->setAutoSize(true);
		$documento->getColumnDimension('K')->setAutoSize(true);
		$documento->getColumnDimension('L')->setAutoSize(true);
		$documento->getColumnDimension('M')->setAutoSize(true);
		$documento->getColumnDimension('N')->setAutoSize(true);
		
		$documento->setCellValue('A2','FECHA');
		$documento->setCellValue('B2','IDENTIFICACIÓN');
		$documento->setCellValue('C2','NOMBRE/RAZÓN SOCIAL');
		$documento->setCellValue('D2','SITIO');
		$documento->setCellValue('E2','PROVINCIA');
		$documento->setCellValue('F2','CANTÓN');
		$documento->setCellValue('G2','CODIGO DE REGISTRO');
		$documento->setCellValue('H2','ESTADO');
		$documento->setCellValue('I2','ESPECIE');
		$documento->setCellValue('J2','NÚMERO DE ANIMALES RECIBIDOS');
		$documento->setCellValue('K2','CANALES OBTENIDAS');
		$documento->setCellValue('L2','CANALES DE USO INDUSTRIAL');
		$documento->setCellValue('M2','CANALES/LOTES MOVILIZADAS');
		$documento->setCellValue('N2','NÚMERO DE CERTIFICADOS EMITIDOS');
		
		if ($qDatos != ''){

			$i = 3;
				foreach ($qDatos as $fila){
					$documento->setCellValueByColumnAndRow(1, $i,date("Y-m-d",strtotime($fila['fecha_creacion'])));
                    $documento->getCellByColumnAndRow(2, $i)->setValueExplicit($fila['identificador_operador'], 's');
					$documento->setCellValueByColumnAndRow(3, $i, $fila['razon_social']);
					$documento->setCellValueByColumnAndRow(4, $i, $fila['nombre_lugar']);
					$documento->setCellValueByColumnAndRow(5, $i, $fila['provincia']);
					$documento->setCellValueByColumnAndRow(6, $i, $fila['canton']);
					$documento->setCellValueByColumnAndRow(7, $i, $fila['codigo']);
					$documento->setCellValueByColumnAndRow(8, $i, $fila['criterio_funcionamiento']);
					$documento->setCellValueByColumnAndRow(9, $i, $fila['tipo_especie']);
					$documento->setCellValueByColumnAndRow(10, $i, $fila['numero_animales_recibidos']);
					$documento->setCellValueByColumnAndRow(11, $i, $fila['num_canales_obtenidos']);
					$documento->setCellValueByColumnAndRow(12, $i, $fila['num_canales_uso_industri']);
					$documento->setCellValueByColumnAndRow(13, $i, $fila['canales_movilizados']);
					$documento->setCellValueByColumnAndRow(14, $i, $fila['numero_certificados']);
					$i++;
				}
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="excelCentroFaenamiento.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $writer = IOFactory::createWriter($hoja, 'Xlsx');
        $writer->save('php://output');
        exit();
	}
    
}
