<?php

class ControladorEvaluaciones{


	
	public function listarEvaluacionesHabilitadas ($conexion,$identificador,$tipo){
		
		$busqueda = '';
		switch ($tipo){
			case 'EVALUACION': $busqueda = 'a.estado = true and'; break;
			case 'REIMPRESION': $busqueda = 'a.estado = false and'; break;
		}
		
		$res = $conexion->ejecutarConsulta("select
												a.identificador,
												a.estado as estado_evaluacion,
												e.fecha_creacion,
												e.estado as estado_evaluacion,
												e.id_evaluacion,
												e.nombre
											from
												g_evaluacion.aplicantes a,
												g_evaluacion.evaluaciones e
											where
												a.id_evaluacion = e.id_evaluacion and 
												".$busqueda."
												e.estado = 1 and
												a.identificador = '$identificador'
											order by
												e.fecha_creacion;");
		return $res;
	}
	
		
	public function obtenerDatosEvaluacion($conexion, $evaluacion){
		$res = $conexion->ejecutarConsulta("select
												*
											from
												g_evaluacion.evaluaciones e
											where
												e.id_evaluacion = $evaluacion");
				return $res;
	}
	
	public function obtenerPreguntas($conexion, $evaluacion){
		$res = $conexion->ejecutarConsulta("select												
												*												
											from
												g_evaluacion.preguntas p,
												g_evaluacion.evaluaciones e
											where	
												p.id_evaluacion = e.id_evaluacion and
												p.id_evaluacion = $evaluacion");
		return $res;
	}
	
	public function obtenerOpciones($conexion, $evaluacion){
		$res = $conexion->ejecutarConsulta("select
												*
											from
												g_evaluacion.opciones
											where
												id_evaluacion = $evaluacion
											order by
												id_opcion, id_pregunta");
		return $res;
	}
	
	public function guardarPregunta($conexion, $evaluacion, $pregunta, $identificador, $idResultadoEvaluacion){
		$res = $conexion->ejecutarConsulta("INSERT INTO 
														g_evaluacion.respuestas(id_evaluacion, id_pregunta, identificador, id_resultado_evaluacion)
   											VALUES ($evaluacion,$pregunta,'$identificador','$idResultadoEvaluacion');");
		return $res;
	}
	
	
	public function grabarRespuesta($conexion, $pregunta,$opcion,$identificador,$evaluacion){
		
		$res = $conexion->ejecutarConsulta("update
												g_evaluacion.respuestas
											set
												id_opcion = $opcion
											where
												identificador = '$identificador' and
												id_evaluacion = $evaluacion and 
												id_pregunta = $pregunta and
												id_resultado_evaluacion = (SELECT max(id_resultado_evaluacion) FROM g_evaluacion.respuestas WHERE identificador = '$identificador' and id_evaluacion = $evaluacion);");
	
				//$this->actualizarNotificacion($conexion, $identificador);
	
				return $res;
	}
	
	
	public function grabarHora($conexion, $identificador, $evaluacion, $duracion){
		$res = $conexion->ejecutarConsulta("UPDATE
												g_evaluacion.aplicantes
											SET
												fecha_inicio = NOW(),
												fecha_fin = (NOW() + interval '$duracion minutes')
											WHERE
												identificador = '$identificador'
												AND
												id_evaluacion = $evaluacion;");
	
	
				return $res;
	}
	
	
	
	public function estadoAplicante ($conexion,$identificador,$evaluacion){
		$res = $conexion->ejecutarConsulta("select
													*
											from
													g_evaluacion.aplicantes a
											where
													a.id_evaluacion = $evaluacion and
													a.identificador = '$identificador';");
				return $res;
	}
	
	public function preguntasAplicante ($conexion,$identificador,$evaluacion, $idResultadoEvaluacion){
		$res = $conexion->ejecutarConsulta("select
												r.id_pregunta,
												p.descripcion,
												p.ruta_imagen
											from
												g_evaluacion.respuestas r,
												g_evaluacion.preguntas p
											where
												r.id_pregunta = p.id_pregunta and
												r.id_evaluacion = $evaluacion and
												r.identificador = '$identificador'and 
												r.id_resultado_evaluacion = $idResultadoEvaluacion;");
		return $res;
	}
	
	public function obtenerCalificacion($conexion, $evaluacion, $identificador, $numeroResultadoEvaluacion){
		$res = $conexion->ejecutarConsulta("select
												COUNT(id_respuesta) as num_preguntas,
												SUM(ponderacion) as calificacion
											from
												g_evaluacion.respuestas
											where
												id_evaluacion = '$evaluacion' and
												identificador = '$identificador' and
												id_resultado_evaluacion = '$numeroResultadoEvaluacion';");
				return $res;
	}
	
	public function quitarEvaluacion($conexion, $identificador, $evaluacion){
		$res = $conexion->ejecutarConsulta("update 
												g_evaluacion.aplicantes
											set 
												estado = false,
												fecha_fin = now()
											where
												identificador = '$identificador' and
												id_evaluacion = $evaluacion;");
		
		$this->actualizarNotificacion($conexion, $identificador);
		
		return $res;
	}
	
		
	public function actualizarNotificacion($conexion, $identificador){
	$res = $conexion->ejecutarConsulta("select 
												g_programas.actualizarnotificaciones(
													-1,
													'$identificador',
											(SELECT
											a.id_aplicacion
											FROM
											g_programas.aplicaciones a
											WHERE
											a.codificacion_aplicacion='PRG_EVALUACION'));");
			return $res;
	}
	
	public function datosImpresion($conexion, $identificador, $evaluacion){
		
		$res = $conexion->ejecutarConsulta("select
												e.nombre as evaluacion,
												a.nombre,
												a.apellido,
												a.fecha_inicio,
												a.fecha_fin,
												e.imprimir
											from
												g_evaluacion.aplicantes a,
												g_evaluacion.evaluaciones e
											where
												a.id_evaluacion = e.id_evaluacion and
												a.id_evaluacion = '$evaluacion' and
												a.identificador = '$identificador';");
		return $res;
		
	}
	
	public function guardarResultadoEvaluacion($conexion, $identificador, $oportunidad, $evaluacion){
		$res = $conexion->ejecutarConsulta("INSERT INTO
													g_evaluacion.resultado_evaluaciones(identificador, fecha_inicio, numero_oportunidad, id_evaluacion)
											VALUES ('$identificador',now(),$oportunidad, $evaluacion) returning id_resultado_evaluacion ;");
				return $res;
	}
	
	public function buscarNumeroOportunidad($conexion, $identificador, $idEvaluacion){
		$res = $conexion->ejecutarConsulta("SELECT 
												COALESCE(
													MAX(
														CAST(numero_oportunidad as  numeric(5))),0)+1 as codigo 
											FROM 
												g_evaluacion.resultado_evaluaciones 
											WHERE 
												identificador  = '$identificador' and
												id_evaluacion = '$idEvaluacion';");
		return $res;
	}
	
	public function buscarOportunidadActual($conexion, $identificador, $idEvaluacion){
		$res = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_evaluacion.resultado_evaluaciones
											WHERE
												identificador  = '$identificador' and
												id_evaluacion = '$idEvaluacion'and 
												numero_oportunidad = (	SELECT 
																			MAX(numero_oportunidad) 
																		FROM
																			g_evaluacion.resultado_evaluaciones
																		WHERE
																			identificador  = '$identificador' and
																			id_evaluacion = '$idEvaluacion');");
				return $res;
	}
	
	public function actualizarResultadoEvaluacion($conexion, $identificador, $idResultadoEvaluacion, $calificacion){
		$res = $conexion->ejecutarConsulta("update
												g_evaluacion.resultado_evaluaciones
											set
												fecha_fin = 'now()',
												calificacion = $calificacion
											where
												identificador = '$identificador' and
												id_resultado_evaluacion = $idResultadoEvaluacion;");
	
				$this->actualizarNotificacion($conexion, $identificador);
	
		return $res;
	}
	
	public function obtenerAplicantesPendientes($conexion,$estado,$busqueda){
		$consulta="SELECT 
						id_activacion,identificador,nombre,apellido, id_evaluacion 
					FROM
						g_evaluacion.activacion_evaluaciones
					WHERE
						estado=$estado
						$busqueda";
		
		$res=$conexion->ejecutarConsulta($consulta);
		return $res;		
		
	}
	
	public function ingresarAplicantes($conexion,$identificador,$nombre,$apellido,$idEvaluacion){		
		$consulta ="select g_evaluacion.insertarOactualizarAplicantes('$identificador',$idEvaluacion,'$nombre','$apellido',true)";
		$res=$conexion->ejecutarConsulta($consulta);
		return $res;
	}
	
	public function inactivarAplicantes($conexion,$identificador,$idEvaluacion){
		$consulta="UPDATE
						g_evaluacion.aplicantes
					SET
						estado='false'
					WHERE
						identificador='$identificador'
						and id_evaluacion=$idEvaluacion";
			
		$res=$conexion->ejecutarConsulta($consulta);
		return $res;
	}
	
	public function actualizarEstadoActivacion($conexion,$idActivacion,$estado){
		$consulta="UPDATE 
						g_evaluacion.activacion_evaluaciones
					 SET
						 estado=$estado
					 WHERE
					 	id_activacion=$idActivacion";
		
		$res=$conexion->ejecutarConsulta($consulta);
		return $res;
	}
	
public function datosUsuarioExterno($conexion, $identificador){
	    
	    $res = $conexion->ejecutarConsulta("select
                                                distinct a.*,
												e.nombre as nombre_evaluacion,
                                                case when a.estado is true then 'Activo'
                        	                       else
                        	                        'Inactivo'
                        	                       end::varchar as estado_evaluacion
											from
												g_usuario.usuarios u
												INNER JOIN g_usuario.usuarios_perfiles up ON u.identificador = up.identificador
                                                INNER JOIN g_usuario.perfiles p ON up.id_perfil = p.id_perfil
												INNER JOIN g_evaluacion.aplicantes a ON a.identificador = u.identificador
												INNER JOIN g_evaluacion.evaluaciones e ON e.id_evaluacion = a.id_evaluacion
											where
												up.identificador = '$identificador' and 
                                                p.codificacion_perfil = 'PFL_USUAR_EXT' and
                                                e.estado = 1;");
	    return $res;
	}
	
	public function listarEvaluacionesXAreaXTipo ($conexion,$idArea,$tipo){
	    
	    $res = $conexion->ejecutarConsulta("select												
												e.*
											from
												g_evaluacion.evaluaciones e
											where
												e.estado = 1 and
												e.id_area = '$idArea' and
                                                e.tipo_evaluacion = '$tipo'
											order by
												e.nombre;");
	    return $res;
	}
	
	public function crearUsuario ($conexion, $identificador){
	    
	    $res = $conexion->ejecutarConsulta("INSERT INTO 
                                                g_usuario.usuarios(identificador, nombre_usuario, clave, estado) 
                                                select  '$identificador','$identificador',md5('$identificador".".1"."'),'1' 
                                                where not exists 
                                                (select identificador 
                                                    from g_usuario.usuarios 
                                                    where identificador='$identificador');");
	    return $res;
	}
	
	public function actualizarClaveUsuario ($conexion, $identificador){
	    
	    $res = $conexion->ejecutarConsulta("UPDATE g_usuario.usuarios SET clave=md5('$identificador".".1"."'), 
                                            estado=1 WHERE identificador='$identificador';");
	    return $res;
	}
	
	public function asignarAplicacion ($conexion, $identificador, $codificacion){
	    
	    $res = $conexion->ejecutarConsulta("INSERT INTO 
                                                g_programas.aplicaciones_registradas
                                                ( id_aplicacion, identificador, cantidad_notificacion, mensaje_notificacion) 
                                                SELECT (SELECT id_aplicacion FROM g_programas.aplicaciones WHERE codificacion_aplicacion='$codificacion'), '$identificador', 1, 'evaluaciones' 
                                                where not exists (select identificador from g_programas.aplicaciones_registradas where identificador='$identificador' 
                                                and id_aplicacion=(SELECT id_aplicacion FROM g_programas.aplicaciones WHERE codificacion_aplicacion='$codificacion'));");
	    return $res;
	}
	
	public function asignarPerfil ($conexion, $identificador, $codificacion){
	    
	    $res = $conexion->ejecutarConsulta("INSERT INTO g_usuario.usuarios_perfiles( identificador, id_perfil) 
                                            SELECT '$identificador',(SELECT id_perfil FROM g_usuario.perfiles WHERE codificacion_perfil = '$codificacion') where not exists 
                                            (SELECT identificador from g_usuario.usuarios_perfiles where 
                                            identificador='$identificador' and id_perfil=(SELECT id_perfil FROM g_usuario.perfiles WHERE codificacion_perfil = '$codificacion'));");
	    return $res;
	}
	
	public function asignarEvaluacion ($conexion, $identificador, $nombres, $apellidos, $idEvaluacion){
	    
	    $res = $conexion->ejecutarConsulta("INSERT INTO g_evaluacion.aplicantes
                                            ( identificador, id_evaluacion, estado, nombre, apellido) 
                                            SELECT '$identificador', $idEvaluacion, true, '$nombres', '$apellidos' 
                                            where not exists (select identificador from g_evaluacion.aplicantes where 
                                            identificador='$identificador' and id_evaluacion=$idEvaluacion);");
	    return $res;
	}
	
	public function reiniciarEvaluacion ($conexion, $identificador, $idEvaluacion){
	    
	    $res = $conexion->ejecutarConsulta("UPDATE g_evaluacion.aplicantes SET 
                                            estado=true, fecha_inicio=null, fecha_fin=null 
                                            WHERE  identificador='$identificador' and 
                                            id_evaluacion=$idEvaluacion;");
	    return $res;
	}
	
	public function datosUsuarioEvaluacion($conexion, $identificador, $idEvaluacion){
	    
	    $res = $conexion->ejecutarConsulta("select
                                                a.*,
												e.nombre as nombre_evaluacion
											from
												g_evaluacion.aplicantes a
                                                INNER JOIN g_evaluacion.evaluaciones e ON e.id_evaluacion = a.id_evaluacion
											where
												a.identificador = '$identificador' and
                                                a.id_evaluacion = $idEvaluacion;");
	    return $res;
	}
	
	public function desactivarEvaluacion ($conexion, $identificador, $idEvaluacion){
	    
	    $res = $conexion->ejecutarConsulta("UPDATE g_evaluacion.aplicantes SET
                                            estado=false
                                            WHERE  identificador='$identificador' and
                                            id_evaluacion=$idEvaluacion;");
	    return $res;
	}
	
	public function generarReporteEvaluacionesSimple($conexion, $idEvaluacion, $fechaInicio, $identificador){
	    
	    $query = '';
	    
	    if ($identificador != ''){
	        $query = " and r.identificador = '$identificador'";
	    }
	    
	    $res = $conexion->ejecutarConsulta("SELECT 
                                            	r.identificador,a.nombre ||' ' || a.apellido nombres, r.fecha_inicio, r.fecha_fin, 
                                                    r.numero_oportunidad, r.calificacion, e.nombre
                                            FROM 
                                            	g_evaluacion.resultado_evaluaciones r, g_evaluacion.aplicantes a, 
                                                g_evaluacion.evaluaciones e,
                                            	(SELECT 
                                            	r.identificador,	
                                                    max(r.id_resultado_evaluacion) id_resultado_evaluacion
                                            FROM 
                                            	g_evaluacion.resultado_evaluaciones r
                                            WHERE
                                            	r.id_evaluacion=".$idEvaluacion."
                                            	group by 1
                                            ) as t1
                                            WHERE	
                                            	e.id_evaluacion = a.id_evaluacion
												and a.identificador = r.identificador
                                            	and r.id_evaluacion = a.id_evaluacion
                                            	and r.id_resultado_evaluacion = t1.id_resultado_evaluacion
                                            	and r.calificacion is not null
                                                and r.fecha_inicio >= '".$fechaInicio." 00:00:00'".
	                                            $query ."
                                            	order by 2;");
	    return $res;
	}
	
	public function generarReporteEvaluacionesCuestionario($conexion, $idEvaluacion, $fechaInicio, $identificador){
	    
	    $query = '';
	    
	    if ($identificador != ''){
	        $query = " and r.identificador = '$identificador'";
	    }
	    
	    $res = $conexion->ejecutarConsulta("SELECT
                                            	r.identificador, e.nombre, p.id_pregunta, a.apellido ||' '|| a.nombre aplicantes,p.descripcion pregunta, 
                                            	r.opcion_respuesta respuesta, r.ponderacion valor, r.fecha_respuesta, rs.calificacion
                                            FROM 
                                            	g_evaluacion.resultado_evaluaciones rs RIGHT OUTER JOIN g_evaluacion.respuestas r on rs.id_resultado_evaluacion = r.id_resultado_evaluacion
                                            	INNER JOIN g_evaluacion.evaluaciones e on e.id_evaluacion = rs.id_evaluacion
                                                INNER JOIN g_evaluacion.preguntas p on r.id_pregunta = p.id_pregunta
                                            	INNER JOIN g_evaluacion.aplicantes a on a.identificador = r.identificador,
                                            	(SELECT 
                                            	r.identificador,	
                                                    max(r.id_resultado_evaluacion) id_resultado_evaluacion
                                            	FROM 
                                            		g_evaluacion.resultado_evaluaciones r
                                            	WHERE
                                            		r.id_evaluacion=$idEvaluacion
                                            		group by 1
                                            	) as t1
                                            WHERE
                                            	r.id_evaluacion=$idEvaluacion	
                                            	and r.id_evaluacion = a.id_evaluacion
                                                and r.id_resultado_evaluacion = t1.id_resultado_evaluacion
                                                and r.fecha_respuesta >= '".$fechaInicio." 00:00:00'".
	                                            $query ."
                                            ORDER BY
                                            	aplicantes, 2");
	    return $res;
	}
	
	//Usuario Interno
	public function datosUsuarioInterno($conexion, $identificador){
	    
	    $res = $conexion->ejecutarConsulta("select
                                                distinct a.*,
												e.nombre as nombre_evaluacion,
                                                case when a.estado is true then 'Activo'
                        	                       else
                        	                        'Inactivo'
                        	                       end::varchar as estado_evaluacion
											from
												g_usuario.usuarios u
												INNER JOIN g_usuario.usuarios_perfiles up ON u.identificador = up.identificador
                                                INNER JOIN g_usuario.perfiles p ON up.id_perfil = p.id_perfil
												INNER JOIN g_evaluacion.aplicantes a ON a.identificador = u.identificador
												INNER JOIN g_evaluacion.evaluaciones e ON e.id_evaluacion = a.id_evaluacion
											where
												up.identificador = '$identificador' and
                                                p.codificacion_perfil in ('PFL_USUAR_INT', 'PFL_USUAR_CIV_PR') and
                                                e.estado = 1;");
	    return $res;
	}
	
	public function informacionUsuarioInterno ($conexion,$identificador){
	    
	    $res = $conexion->ejecutarConsulta("select
												e.*
											from
												g_uath.ficha_empleado e
                                                INNER JOIN g_usuario.usuarios_perfiles up ON e.identificador = up.identificador
                                                INNER JOIN g_usuario.perfiles p ON up.id_perfil = p.id_perfil
											where
												e.estado_empleado = 'activo' and
												e.identificador = '$identificador' and
                                                p.codificacion_perfil in ('PFL_USUAR_INT', 'PFL_USUAR_CIV_PR') 
											order by
												e.nombre;");
	    return $res;
	}
}