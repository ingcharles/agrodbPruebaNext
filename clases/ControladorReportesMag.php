<?php
 require_once '../../../clases/Constantes.php';
class ControladorReportesMag
{
    #Region Selects
     /**
     * funcion para retornar 
     * 
     * @return ResultSet mismo que contiene la infromacion del registro de operador SA
     */
	public function obtenerReporteRegistroOperadorSA($conexion,$fechaInicio,$fechaFin)
	{
		set_time_limit(300);  
		$fechaInicio = ("'".$fechaInicio."'");
        $fechaFin = ("'".$fechaFin."'");
		$tipoArea=("'".Constantes::tipoAreas()->SANIDAD_ANIMAL."'");
        $consulta = "SELECT * from g_operadores.fs_retorna_reporte_operadores_parametrizado($fechaInicio,$fechaFin,$tipoArea);";
		$response = $conexion->ejecutarConsulta($consulta);
        return $response;
	}
    /**
     * funcion para retornar 
     * 
     * @return ResultSet mismo que contiene la infromacion del registro de operador SV
     */
	public function obtenerReporteRegistroOperadorSV($conexion,$fechaInicio,$fechaFin)
	{
		set_time_limit(300);  
		$fechaInicio = ("'".$fechaInicio."'");
        $fechaFin = ("'".$fechaFin."'");
		$tipoArea=("'".Constantes::tipoAreas()->SANIDAD_VEGETAL."'");
        $consulta = "SELECT * from g_operadores.fs_retorna_reporte_operadores_parametrizado($fechaInicio,$fechaFin,$tipoArea);";
		$response = $conexion->ejecutarConsulta($consulta);
        return $response;
	}

    /**
     * funcion para retornar 
     * 
     * @return ResultSet mismo que contiene la informacion de los certificadors de exportacion
     *  SV
     */
	public function obtenerReporteCertificadoExportacionSV($conexion,$fechaInicio,$fechaFin)
	{
		set_time_limit(300);  
		$fechaInicio = ("'".$fechaInicio."'");
        $fechaFin = ("'".$fechaFin."'");
        $consulta = "SELECT * from g_fito_exportacion.fs_reporte_fito_exportacion_subsanacion($fechaInicio, $fechaFin);";
		$response = $conexion->ejecutarConsulta($consulta);

        return $response;
	}

     /**
     * funcion para retornar 
     * 
     * @return ResultSet mismo que contiene la informacion de los certificadors de exportacion
     *  SV
     */
	public function obtenerReporteCertificadoImportacionSV($conexion,$fechaInicio,$fechaFin)
	{
		set_time_limit(300);  
		$fechaInicio = ("'".$fechaInicio."'");
        $fechaFin = ("'".$fechaFin."'");
        $consulta = "SELECT * from g_importaciones.fs_reporte_importaciones_subsanacion($fechaInicio,$fechaFin);";
		$response = $conexion->ejecutarConsulta($consulta);
        return $response;
	}

    
     /**
     * funcion para retornar 
     * 
     * @return ResultSet mismo que contiene la informacion de los certificadors de Importacion
     *  SA
     */
    public function obtenerReporteCertificadoImportacionSA($conexion,$fechaInicio,$fechaFin)
	{
		set_time_limit(300);  
        $tipoReporte = ("'".Constantes::tipoReporte()->APROBADO."'");
		$fechaInicio = ("'".$fechaInicio."'");
        $fechaFin = ("'".$fechaFin."'");
        $consulta = "SELECT * from g_importaciones.fs_reporte_importacion_sanidad_animal_2($fechaInicio, $fechaFin, $tipoReporte);";
		$response = $conexion->ejecutarConsulta($consulta);
        return $response;
	}
    
    
     /**
     * funcion para retornar 
     * 
     * @return ResultSet mismo que contiene la informacion de los certificadors de Exportacion
     *  SA
     */
    public function obtenerReporteCertificadoExportacionSA($conexion,$fechaInicio,$fechaFin)
	{
		set_time_limit(300);  
        $tipoReporte = ("'".Constantes::tipoReporte()->APROBADO."'");
		$fechaInicio = ("'".$fechaInicio."'");
        $fechaFin = ("'".$fechaFin."'");
        $consulta = "SELECT * from g_zoo_exportacion.f_zoosanitario_exportacion ($fechaInicio, $fechaFin);";
		$response = $conexion->ejecutarConsulta($consulta);
        return $response;
	}

    
     /**
     * funcion para retornar 
     * 
     * @return ResultSet mismo que contiene la informacion de los operadores
     *  que contienen certificacion BPA
     */
    public function obtenerReporteOperadoresCertificadosBPA($conexion,$fechaInicio,$fechaFin)
	{
		set_time_limit(300);  
        $tipoReporte = ("'".Constantes::tipoReporte()->APROBADO."'");
		$fechaInicio = ("'".$fechaInicio."'");
        //$fechaFin = ("'".$fechaFin."'");
        $consulta = "SELECT * from g_certificacion_bpa.f_operador_certificado_bpa($fechaInicio);";
		$response = $conexion->ejecutarConsulta($consulta);
        return $response;
	}
   


    #Region Inserts
    /**
     * funcion que permite insertar datos en la base de frontera del mag
     * inserta un objeto json de registro de operadores SA
    */
	public function insertarOperadoresMagSA($conexion,$qRegistroOperador)
	{
        try{
        $qRegistroOperador=("'[".$qRegistroOperador."]'");
        $consulta = "INSERT INTO 
        mag.operadores_agr_sa (datos_operadores_sa) 
        VALUES 
       ( $qRegistroOperador);";

        $res = $conexion->ejecutarConsulta($consulta);
        return $res;
        }catch (Exception $ex) {
            throw $ex;
        }
    }
     /**
     * funcion que permite insertar datos en la base de frontera del mag
     * inserta un objeto json de registro de operadores SV
    */
	public function insertarOperadoresMagSV($conexion,$qRegistroOperador)
	{
        try{
        $qRegistroOperador=("'[".$qRegistroOperador."]'");
        $consulta = "INSERT INTO 
        mag.operadores_agr_sv (datos_operadores_sv) 
        VALUES 
       ( $qRegistroOperador);";

        $res = $conexion->ejecutarConsulta($consulta);
        return $res;
        }catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Funcion que permite ingresar en base de frontera del mag 
     * inserta un objeto json de los certificados de exportacion SV
     */
    public function insertarCertificadoExportacionMagSV($conexion,$qCertificadoExportacion)
	{
        try{
        $qCertificadoExportacion=("'[".$qCertificadoExportacion."]'");
        $consulta = "INSERT INTO 
        mag.certificado_exportacion_agr_sv (datos_expotacion_sv) 
        VALUES 
       ( $qCertificadoExportacion);";

        $res = $conexion->ejecutarConsulta($consulta);
        return $res;
        }catch (Exception $ex) {
            throw $ex;
        }
    }
     
      /**
     * Funcion que permite ingresar en base de frontera del mag 
     * inserta un objeto json de los certificados de importacion SV
     */
    public function insertarCertificadoImportacionSV($conexion,$qCertificadoExportacion)
	{
        try{
        $qCertificadoExportacion=("'[".$qCertificadoExportacion."]'");
        $consulta = "INSERT INTO 
        mag.certificado_importacion_agr_sv (datos_importacion_sv) 
        VALUES 
       ( $qCertificadoExportacion);";

        $res = $conexion->ejecutarConsulta($consulta);
        return $res;
        }catch (Exception $ex) {
            throw $ex;
        }
    }

      /**
     * Funcion que permite ingresar en base de frontera del mag 
     * inserta un objeto json de los certificados de importacion SA
     */
    public function insertarCertificadoImportacionSA($conexion,$qCertificadoExportacion)
	{
        try{
            $qCertificadoExportacion=("'[".$qCertificadoExportacion."]'");
            $consulta = "INSERT INTO 
          mag.certificado_exportacion_agr_sa (datos_expotacion_sa) 
            VALUES 
           ( $qCertificadoExportacion);";
    
            $res = $conexion->ejecutarConsulta($consulta);
            return $res;
        }catch (Exception $ex) {
            throw $ex;
        }
            
         
       
    }

    
      /**
     * Funcion que permite ingresar en base de frontera del mag 
     * inserta un objeto json de los certificados de exportacion SA
     */
    public function insertarCertificadoExportacionSA($conexion,$qCertificadoExportacion)
	{
        try{
        $qCertificadoExportacion=("'[".$qCertificadoExportacion."]'");
        $consulta = "INSERT INTO 
      mag.certificado_importacion_agr_sa (datos_importacion_sa) 
        VALUES 
       ( $qCertificadoExportacion);";

        $res = $conexion->ejecutarConsulta($consulta);
        return $res;
        }catch (Exception $ex) {
                    throw $ex;
        }

    }

    /**
     * Funcion que permite ingresar en base de frontera del mag 
     * inserta un objeto json de los certificados de exportacion SA
     */
    public function insertarOperadoresCertificadoBPA($conexion,$qCertificadoExportacion)
	{
        try{
            $qCertificadoExportacion=("'[".$qCertificadoExportacion."]'");
            $consulta = "INSERT INTO 
            mag.operadores_certificado_bpa (datos_operadores_certificados_bpa) 
            VALUES 
        ( $qCertificadoExportacion);";

            $res = $conexion->ejecutarConsulta($consulta);
            return $res;
        }catch (Exception $ex) {
            throw $ex;
        }
    }



   
}
