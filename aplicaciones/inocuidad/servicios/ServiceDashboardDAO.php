<?php
/**
 * Created by IntelliJ IDEA.
 * User: antonio
 * Date: 19/02/18
 * Time: 11:14
 */

require_once "../Modelo/Dashboard.php";

class ServiceDashboardDAO
{
    public function __construct()
    {
    }

    public function recibidosVsDespachados($conexion){
       
        $queryAll = "select (select count(1)
                        from g_inocuidad.ic_requerimiento) as recibido,
                        (select count(1) from (
                        select ic_requerimiento_id
                        from g_inocuidad.ic_muestra 
                        group by ic_requerimiento_id) T) as atendido,
                        (select count(1) from (
                        select ic_requerimiento_id
                        from g_inocuidad.ic_muestra 
                        where ic_resultado_decision_id>0
                        group by ic_requerimiento_id) T) as despachado";
        try{
            $result = $conexion->ejecutarConsulta($queryAll);
            $filasPrd = pg_fetch_all($result);
            return $filasPrd;
        }catch (Exception $exc){
            return null;
        }
    }

    public function getAllDashboard($usuario,$conexion,$banderaPerfil){

        $condicion = " ";
                     
        if ($banderaPerfil){
            $condicion="CASE WHEN g_inocuidad.buscar_rol('PFL_CONF_INOC','$usuario') THEN 1=1  
                        ELSE usuario='$usuario' END";
        }else{
            $condicion="CASE WHEN g_inocuidad.buscar_rol('PFL_CONF_INOC','$usuario') THEN 1=1  
            ELSE inspector_id='$usuario' END";

        }

        $queryAll=" SELECT *
                FROM G_INOCUIDAD.IC_V_DASHBOARD 
                WHERE ".$condicion ;
       

        $filas = array();
        try{
            $result = $conexion->ejecutarConsulta($queryAll);
            while ($filasDashboard = pg_fetch_assoc($result)) {
                $dashboard = new Dashboard($filasDashboard['nombre_programa'],$filasDashboard['nombre_tipo_requerimiento'],
                    $filasDashboard['fecha_solicitud'],$filasDashboard['estado'],$filasDashboard['usuario'],$filasDashboard['ic_requerimiento_id'],
                    $filasDashboard['ic_muestra_id'],$filasDashboard['ic_analisis_muestra_id'],$filasDashboard['ic_evaluacion_analisis_id'],
                    $filasDashboard['ic_evaluacion_comite_id'],$filasDashboard['cancelado'],$filasDashboard['motivo_cancelacion'],$filasDashboard['provincia']);
                array_push($filas, $dashboard);
            }
        }catch(Exception $exc){
            return array();
        }
        return $filas;
    }

    public function obtenerPerfilUsuario($conexion,$idUsuario){

		$res = $conexion->ejecutarConsulta("SELECT
											usper.identificador,
											per.nombre as perfil,
											per.codificacion_perfil,
											femp.nombre || ' ' || femp.apellido as usuario
										FROM
											g_usuario.usuarios_perfiles AS usper
											INNER JOIN g_usuario.perfiles AS per ON per.id_perfil = usper.id_perfil
											INNER JOIN g_usuario.usuarios us ON us.identificador = usper.identificador
											INNER JOIN g_uath.ficha_empleado femp ON us.identificador = femp.identificador
										WHERE
											usper.identificador = '$idUsuario' AND 
											per.estado=1 AND 
											us.estado=1 AND
											per.codificacion_perfil = 'PFL_CONF_INOC';");		
		return $res;
	}
}