<?php

class ControladorMovilizacionVegetal
{
    
    public function obtenerIdentificadorAsignarAplicacion($conexion){
        
        $consulta = "SELECT
                    	DISTINCT op.identificador_operador
                    FROM
                    	g_operadores.operaciones op
                    INNER JOIN g_catalogos.tipos_operacion top on op.id_tipo_operacion = top.id_tipo_operacion
                    	WHERE 
                        top.id_area || top.codigo IN ('SVACO', 'SVFRA', 'SVALM', 'SVPRP', 'SVMIM', 'SVPRO', 'SVVVE') 
                        and op.estado in ('registrado', 'registradoObservacion')
                    EXCEPT
                    SELECT ta.identificador FROM (SELECT
                                                    	DISTINCT ar.identificador
                                                    FROM
                                                    	g_programas.aplicaciones_registradas ar
                                                    INNER JOIN g_programas.aplicaciones a ON a.id_aplicacion = ar.id_aplicacion
                                                    WHERE
                                                    	a.codificacion_aplicacion = 'PRG_MOV_VEG') ta
                    INNER JOIN (SELECT 
                    				DISTINCT (up.identificador)
                    			FROM 
                    				g_usuario.perfiles p
                    			INNER JOIN g_usuario.usuarios_perfiles up ON up.id_perfil = p.id_perfil
                    			WHERE 
                                    p.codificacion_perfil = 'PFL_USR_MOV') tup ON tup.identificador = ta.identificador;";
        
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }

    
}