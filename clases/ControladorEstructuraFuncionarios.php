<?php

class ControladorEstructuraFuncionarios{
	
public function nivelesAreaConsultada($conexion,$idAreaFuncionario){
	
	//---devolver niveles del área consultada-----------------------------------------------------------------------
	$areaRecursiva = pg_fetch_assoc($conexion->ejecutarConsulta("WITH RECURSIVE area_cte(id, nombre_area, path,clasificacion) AS (
																SELECT
																	tn.id_area,tn.nombre,tn.id_area::TEXT AS path,tn.clasificacion
																FROM
																	g_estructura.area AS tn
																WHERE
																	tn.id_area_padre IS NULL and estado=1
																UNION ALL
																SELECT
																	c.id_area, c.nombre,(p.path || ',' || c.id_area::TEXT),c.clasificacion
																FROM
																	area_cte AS p,g_estructura.area AS c
																WHERE
																	c.id_area_padre = p.id and
																	c.estado=1
																)SELECT
																	*
																FROM
																	area_cte AS n
																WHERE
																	n.id='$idAreaFuncionario'
																ORDER BY n.id ASC;"));
															
	return $areaRecursiva;
	
}
	
public function verificarResponsable($conexion, $identificador){

 $sqlScript="SELECT 
					*
				FROM g_estructura.responsables res,
					g_estructura.area ar 
				WHERE 
					res.identificador='$identificador' and 
					res.responsable = true and
					ar.id_area = res.id_area";
	$res = $conexion->ejecutarConsulta($sqlScript);
	return $res;
}	
	
	
public function datosFuncionario($conexion, $identificador){

	$sqlScript="SELECT 
	            apellido ||' '||nombre as usuario
				FROM
					g_uath.ficha_empleado
				WHERE
					identificador='$identificador'";
	$res = $conexion->ejecutarConsulta($sqlScript);
	return $res;
}
	
	
	public function obtenerNombreArea($conexion, $idArea){
	
		$sqlScript="SELECT
						*
					FROM
						g_estructura.area
					WHERE
						id_area='$idArea'
						and estado = 1";
		$res = $conexion->ejecutarConsulta($sqlScript);
		
		return $res;
	}
//----------------------------------------------------------------------------------------------
	public function devolverResponsable($conexion, $identificadorUsuario){
			//Área de usuario para revisión y aprobación de jefe inmediato
			$areaUsuario = pg_fetch_assoc($conexion->ejecutarConsulta("SELECT
																			a.*
																		FROM
																			g_estructura.area as a,
																			g_estructura.funcionarios as f
																		WHERE
																			a.id_area = f.id_area
																			and f.identificador = '$identificadorUsuario'"));
			$idAreaFuncionario=$areaUsuario['id_area'];
			$areaRecursiva=$this->nivelesAreaConsultada($conexion,$idAreaFuncionario);
			
			
			$tipoArea = $areaRecursiva['clasificacion'];
			$arrayAreas = explode(',', $areaRecursiva['path']);
			$numAreas = sizeof($arrayAreas)-1;
			$categoriaArea = $areaRecursiva['categoria_area'];		
			
			if($areaUsuario['clasificacion']=='Planta Central'){
				
				$idArea=$arrayAreas[1];
				$identificadorJefe = pg_fetch_result($conexion->ejecutarConsulta("SELECT
																					*
																					FROM
																						g_estructura.responsables
																					WHERE
																						id_area = '$idArea'
																						and responsable = true
																						and estado = 1;"), 0, 'identificador');
				
				$nombreArea = pg_fetch_assoc($this->obtenerNombreArea($conexion, $idArea));
				$nombreArea = $nombreArea['nombre'];
				
			}else{	
					
				$idArea=$arrayAreas[3];
				$identificadorJefe = pg_fetch_result($conexion->ejecutarConsulta("SELECT
																					*
																					FROM
																						g_estructura.responsables
																					WHERE
																						id_area = '$idArea'
																						and responsable = true
																						and estado = 1;"), 0, 'identificador');
				
				$nombreArea = pg_fetch_assoc($this->obtenerNombreArea($conexion, $idArea));
				$nombreArea = $nombreArea['nombre'];
				
			}					
					
			$usuarioDatos = pg_fetch_assoc($this->datosFuncionario($conexion, $identificadorJefe));		
			
			$resultConsulta = array(
					'identificador'	=>	$identificadorJefe,
					'nombreArea'	=>	$nombreArea,
					'idAreaJefe'	=>	$idArea,
					'usuario'	=> $usuarioDatos['usuario'],
					'idAreaFuncionario' => $idAreaFuncionario
			);		
			
			return $resultConsulta;
	}
	
	public function obtenerResponsablePorArea($conexion, $idArea){
	    
	    $sqlScript="SELECT
	            apellido ||' '||nombre as usuario
				FROM
					g_uath.ficha_empleado fe INNER JOIN g_estructura.responsables res ON fe.identificador =res.identificador
				WHERE
					id_area='$idArea'
                    and prioridad = 1
                    and responsable = true";
	    $res = $conexion->ejecutarConsulta($sqlScript);
	    return $res;
	}
	
	public function obtenerEstructuraXUnidadPrincial($conexion, $idArea){
	    
	    $res = $conexion->ejecutarConsulta("with recursive path(id_area,nombre,id_area_padre,estado,clasificacion, categoria_area, zona_area) as
                                                    	        (select id_area,nombre,id_area_padre,estado,clasificacion, categoria_area, zona_area
                                                    	            from g_estructura.area
                                                    	            where id_area = '$idArea'
                                                    	            union
                                                    	            select a.id_area,a.nombre,a.id_area_padre,a.estado,a.clasificacion, a.categoria_area, a.zona_area
                                                    	            from g_estructura.area a, path as rs
                                                    	            where a.id_area_padre = rs.id_area)
                                                    	        SELECT * FROM path ORDER BY id_area ASC;");
	    return $res;
	}
	
	public function obtenerUsuariosEstructuraXUnidadPrincial($conexion, $idArea){
	    
	    $res = $conexion->ejecutarConsulta("select fe.* from g_uath.ficha_empleado fe where fe.estado_empleado='activo' and fe.identificador in (
                                            	select f.identificador from g_estructura.funcionarios f where f.estado=1 and f.id_area in (
                                            			with recursive path(id_area) as 
                                            			    (select id_area
                                            			     from g_estructura.area 
                                            			     where id_area = '$idArea' and estado=1
                                            			     union
                                            			     select a.id_area
                                            			     from g_estructura.area a, path as rs
                                            			     where a.id_area_padre = rs.id_area) 
                                            			     SELECT * FROM path ORDER BY id_area ASC
                                            	)
                                            ) order by fe.apellido asc");
	    return $res;
	}
	public function obtenerDirectorProvincial($conexion, $nombreProvincia){
	    
	    $consulta = "select
                    	f.identificador,
                    	fe.nombre,
                    	fe.apellido,
                        fe.nombre ||' '|| fe.apellido as nombre_director,
                        ar.nombre as nombre_area,
                        ar.id_area
                    from
                    	g_estructura.responsables f,
                    	g_uath.ficha_empleado fe,
                        g_estructura.area ar
                    where
                        ar.id_area = f.id_area and
                    	f.estado = 1 and
                    	f.responsable is true and
                    	activo = 1 and
                    	f.identificador = fe.identificador and
                    	f.id_area = (select
                    					a.id_area
                    				from
                    					g_estructura.area a
                    				where
                    					nombre like '%$nombreProvincia%' and
                    					estado =1 and
                    					categoria_area=3)";
	    
	    $res = $conexion->ejecutarConsulta($consulta);
	    
	    return $res;
	}
	
	public function obtenerCoordinacionesGenerales($conexion){
	    
	    $res = $conexion->ejecutarConsulta("SELECT
                                                *
                                            FROM
                                                g_estructura.area
                                        	WHERE
                                                estado=1 and
                                            	id_area_padre='DE' and
                                            	categoria_area=3;");
	    
	    return $res;
	}
	
	public function obtenerEstructuraPlantaCentral($conexion){
	    
	    $res = $conexion->ejecutarConsulta("SELECT 
                                                * 
                                            FROM 
                                                g_estructura.area
                                            WHERE 
                                                estado=1 and
                                                categoria_area in (3,4) and
                                                clasificacion = 'Planta Central'
                                            ORDER BY 2;");
	    
	    return $res;
	}
	
	public function obtenerEstructuraPlantaCentralGeneral($conexion){
	    
	    $res = $conexion->ejecutarConsulta("SELECT
                                                *
                                            FROM
                                                g_estructura.area
                                            WHERE
                                                estado=1 and
                                                categoria_area in (3,4) and
                                                clasificacion = 'Planta Central' and
												id_area_padre = 'DE'
                                            ORDER BY 2;");
	    
	    return $res;
	}
	
	public function obtenerUsuariosEstructuraXUnidadPrincialActivos($conexion, $idArea){
	    
	    $res = $conexion->ejecutarConsulta("select fe.* from g_uath.ficha_empleado fe 
                                                INNER JOIN g_uath.datos_contrato dc ON fe.identificador = dc.identificador
                                                where dc.estado = 1 and fe.estado_empleado='activo' and fe.identificador in (
                                                	select f.identificador from g_estructura.funcionarios f where f.estado=1 and f.id_area in (
                                                			with recursive path(id_area) as 
                                                			    (select id_area
                                                			     from g_estructura.area 
                                                			     where id_area = '$idArea' and estado=1
                                                			     union
                                                			     select a.id_area
                                                			     from g_estructura.area a, path as rs
                                                			     where a.id_area_padre = rs.id_area) 
                                                			     SELECT * FROM path ORDER BY id_area ASC
                                                	)
                                                ) order by fe.apellido asc");
	    return $res;
	}
	
	public function obtenerFuncionariosNacionalActivos($conexion){
	    
	    $res = $conexion->ejecutarConsulta("select
                                                fe.*
                                            from g_uath.ficha_empleado fe
                                                INNER JOIN g_uath.datos_contrato dc ON fe.identificador = dc.identificador
                                            where
                                                dc.estado = 1 and
                                                fe.estado_empleado='activo'
                                                order by fe.apellido asc");
	    return $res;
	}
	
	public function obtenerFuncionariosInternosNacionalActivos($conexion){
	    
	    $res = $conexion->ejecutarConsulta("select
                                                fe.*
                                            from g_uath.ficha_empleado fe
                                                INNER JOIN g_uath.datos_contrato dc ON fe.identificador = dc.identificador
                                            where
                                                dc.estado = 1 and
                                                fe.estado_empleado='activo' and
                                                dc.regimen_laboral not in ('Servicios Civiles - Profesionales')
                                                order by fe.apellido asc");
	    return $res;
	}
}
?>