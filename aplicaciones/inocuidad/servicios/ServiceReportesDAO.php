<?php
/**
 * Created by IntelliJ IDEA.
 * User: antonio
 * Date: 05/04/18
 * Time: 22:25
 */

class ServiceReportesDAO
{
    function cuentaDetallado(Conexion $conexion, $sqlWHERE){
        $strSQL = "
            SELECT COUNT(1)
            FROM G_INOCUIDAD.IC_V_REQUERIMIENTO REQ
            LEFT JOIN G_INOCUIDAD.IC_V_MUESTRA MU ON REQ.IC_REQUERIMIENTO_ID = MU.IC_REQUERIMIENTO_ID
            LEFT JOIN G_INOCUIDAD.IC_MUESTRA_RAPIDA RV ON RV.IC_MUESTRA_ID = MU.IC_MUESTRA_ID
            LEFT JOIN G_INOCUIDAD.IC_INSUMO INS ON INS.IC_INSUMO_ID = RV.IC_INSUMO_ID
            LEFT JOIN G_INOCUIDAD.IC_PRODUCTO_MUESTRA_RAPIDA PI ON PI.IC_PRODUCTO_ID = RV.IC_PRODUCTO_ID AND PI.IC_INSUMO_ID = RV.IC_INSUMO_ID
            LEFT JOIN g_catalogos.unidades_medidas umed on umed.id_unidad_medida::varchar = PI.UM
            LEFT JOIN G_INOCUIDAD.IC_V_ANALISIS_MUESTRA AM ON AM.IC_MUESTRA_ID = MU.IC_MUESTRA_ID
            LEFT JOIN G_INOCUIDAD.IC_EVALUACION_ANALISIS EV ON EV.IC_ANALISIS_MUESTRA_ID = AM.IC_ANALISIS_MUESTRA_ID
            LEFT JOIN G_INOCUIDAD.IC_RESULTADO_DESICION RD ON EV.IC_RESULTADO_DECISION_ID=RD.IC_RESULTADO_DECISION_ID
            LEFT JOIN G_INOCUIDAD.IC_EVALUACION_COMITE CM ON CM.IC_EVALUACION_ANALISIS_ID = EV.IC_EVALUACION_ANALISIS_ID
            ";
        $strSQL = $strSQL.$sqlWHERE;
        return $conexion->ejecutarConsulta($strSQL);
    }

    function reporteDetallado(Conexion $conexion,$sqlWHERE){
        
        $strSQL = "SELECT 
                    REQ.programa as  \"PROGRAMA\",
                    to_char( MU.fecha_muestreo, 'YYYY-MM-DD') as  \"FECHA DE TOMA DE LA MUESTRA\",
                    MU.codigo_muestras as  \"CoDIGO DE LA MUESTRA DE CAMPO\",
                    REQ.producto as  \"PRODUCTO\",
                    REQ.provincia as  \"PROVINCIA\",
                    MU.canton as  \"CANTON\",
                    MU.parroquia as  \"PARROQUIA\",
                    MU.origen_muestra_id as  \"ORIGEN MUESTRA\",
                    MU.nombre_establecimiento as  \"NOMBRE ESTABLECIMIENTO\",
                    MU.direccion_establecimiento as  \"DIRECCION ESTABLECIMIENTO\",
                    (SELECT nombre FROM g_inocuidad.ic_tipo_requerimiento WHERE ic_tipo_requerimiento_id = REQ.ic_tipo_requerimiento_id ) as \"TIPO MUESTRA\", 
                    MU.nombre_rep_legal as  \"NOMBRE DEL REPRESENTANTE LEGAL (NACIONAL O EMPRESA IMPORTADORA\",
                    MU.certificacion_zoosanitario as  \"CERTIFICADO ZOOSANITARIO DE PRODUCTIVIDAD Y MOVILIDAD\",
                    MU.pais_origen as  \"RAZON SOCIAL DEL EXPORTADOR (SOLO APLICA A FRONTERA) \",
                    MU.certificacion_sanitaria as  \"NUMERO PERMISO ZOOSANITARIO DE IMPORTACION\",
                    MU.razon_social_importador as  \"RAZON SOCIAL DEL IMPORTADOR\",
                    AM.numero_memorando as \"NUMERO DE QUIPUX DE ENVIO DE LA MUESTRA AL LABORATORIO\",
                    (select codigo_muestra from g_inocuidad.ic_detalle_muestra where IC_MUESTRA_ID=MU.IC_MUESTRA_ID AND lmr = (SELECT nombre FROM g_inocuidad.ic_lmr WHERE ic_lmr_id = PI.ic_lmr_id ) and analito = INS.nombre)	as \"CODIGO DE MUESTRA DE LABORATORIO\",
                    AM.fecha_recepcion_muestra as \"FECHA DE RECEPCION DE LA MUESTRA EN EL LABORATORIO\",
                    AM.fecha_analisis_muestra as \"FECHA DE ANALISIS DE LA MUESTRA\",
                INS.nombre as  \"CONTAMINANTE ANALIZADO\",
                umed.NOMBRE as  \"UNIDAD\",
                dm.residuo as \"RESULTADO\",
                PI.LIMITE_MINIMO as  \"LIMITE MINIMO\",
                PI.LIMITE_MAXIMO as  \"LIMITE MAXIMO\",
                (SELECT nombre FROM g_inocuidad.ic_lmr WHERE ic_lmr_id = PI.ic_lmr_id ) as \"NORMA\",
                CASE
                    WHEN RV.VALOR < PI.LIMITE_MINIMO THEN 'INFERIOR'
                    WHEN RV.VALOR > PI.LIMITE_MAXIMO THEN 'SUPERIOR'
                ELSE 'OK' 
                END AS \"+/-\",
                (select nombre from g_inocuidad.ic_resultado_desicion  rd
                inner join g_inocuidad.ic_evaluacion_analisis ea
                on ea.ic_resultado_decision_id = rd.ic_resultado_decision_id
                where ea.ic_muestra_id=MU.IC_MUESTRA_ID) as \"ACCIONES TOMADAS EN MUESTRAS TOMADAS (RESUMEN)\",
                (SELECT observacion FROM g_inocuidad.ic_evaluacion_analisis where ic_muestra_id = MU.IC_MUESTRA_ID ) as  \"OBSERVACIONES\"
                FROM G_INOCUIDAD.IC_V_REQUERIMIENTO REQ
                LEFT JOIN G_INOCUIDAD.IC_V_MUESTRA MU ON REQ.IC_REQUERIMIENTO_ID = MU.IC_REQUERIMIENTO_ID
                LEFT JOIN G_INOCUIDAD.IC_MUESTRA_RAPIDA RV ON RV.IC_MUESTRA_ID = MU.IC_MUESTRA_ID
                LEFT JOIN G_INOCUIDAD.IC_INSUMO INS ON INS.IC_INSUMO_ID = RV.IC_INSUMO_ID
                LEFT JOIN G_INOCUIDAD.IC_PRODUCTO_MUESTRA_RAPIDA PI ON PI.IC_PRODUCTO_ID = RV.IC_PRODUCTO_ID AND PI.IC_INSUMO_ID = RV.IC_INSUMO_ID
                LEFT JOIN g_catalogos.unidades_medidas umed on umed.id_unidad_medida::varchar = PI.UM
                LEFT JOIN G_INOCUIDAD.IC_V_ANALISIS_MUESTRA AM ON AM.IC_MUESTRA_ID = MU.IC_MUESTRA_ID 
                LEFT JOIN g_inocuidad.ic_detalle_muestra dm ON dm.ic_muestra_id = rv.ic_muestra_id AND dm.analito = (SELECT NOMBRE FROM G_INOCUIDAD.IC_INSUMO WHERE ic_insumo_id = RV.IC_INSUMO_ID)";
        $strSQL = $strSQL.$sqlWHERE;
        return $conexion->ejecutarConsulta($strSQL);
    }

    public function formatDate($dateString){
        $date = new DateTime($dateString);
        return $date->format('Y-m-d H:i:s');
    }
}