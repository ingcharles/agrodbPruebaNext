<?php

class ControladorMagBanano{

    public function obtenerInformacionUsuarios($conexion, $fecha){

        // --fecha_actualizacion >= '$fecha 00:00:01' 
        // --and 
        // identificacion is not null ;";

        $consulta  = "SELECT 
                            tipo_identificacion, identificacion, razon_social, nombre_rep_legal, 
                            apellido_rep_legal, nombre_rep_tec, apellido_rep_tec, provincia, 
                            canton, parroquia, direccion, telefono, correo_electronico, actividad, 
                            estado_usuario, fecha_actualizacion
                        FROM 
                            banano.informacion_general_usuarios
                        WHERE 
                            
                            identificacion is not null ;";
        
        $res = $conexion->ejecutarConsulta($consulta);
        return $res;

    }


    public function actualizarOperadoresBanano($conexion, $valores){

        $consulta="UPDATE operadores_banano as t1 set	
                        tipo_operador=t2.tipo_identificacion,
                        identificador=t2.identificacion,
                        razon_social=t2.razon_social,
                        nombre_representante=t2.nombre_rep_legal,
                        apellido_representante=t2.apellido_rep_legal,
                        nombre_tecnico=t2.apellido_rep_legal,
                        apellido_tecnico=t2.nombre_rep_tec,
                        provincia=t2.provincia,
                        canton=t2.canton,
                        parroquia=t2.parroquia,
                        direccion=t2.apellido_rep_tec,
                        telefono_uno=t2.telefono,
                        correo=t2.correo_electronico,		
                        tipo_actividad=t2.actividad,
                        estado=t2.estado_usuario,
                        fecha_actualizacion = t2.fecha_actualizacion::timestamp without time zone,
                        clave = t2.clave
                    FROM 
                        (values
                            $valores
                        ) as t2(tipo_identificacion,identificacion, razon_social, nombre_rep_legal, apellido_rep_legal,nombre_rep_tec, apellido_rep_tec, provincia, canton, parroquia, direccion, telefono, correo_electronico , actividad, estado_usuario, fecha_actualizacion, clave)
                    WHERE
                        t1.identificador::text = t2.identificacion;";
        
        $res = $conexion->ejecutarConsulta($consulta);
        return $res;

    }


    public function insertarOperadoresBanano($conexion, $valores){
        $consulta ="
                    with data(tipo_identificacion, identificacion, razon_social, nombre_rep_legal, apellido_rep_legal,
                    nombre_rep_tec, apellido_rep_tec, provincia, canton, parroquia, direccion, telefono, correo_electronico,
                    actividad, estado_usuario, fecha_actualizacion, clave)  as (
                    values
                    $valores
                    ) 
                    INSERT into operadores_banano (
                    identificador,
                    razon_social,
                    nombre_representante,
                    apellido_representante,
                    nombre_tecnico,
                    apellido_tecnico,
                    direccion,
                    telefono_uno,
                    correo,
                    clave,
                    parroquia,
                    provincia,
                    canton,
                    tipo_operador,
                    tipo_actividad,
                    estado,
                    fecha_actualizacion
                    ) 
                    SELECT 
                    t1.identificacion, 
                    t1.razon_social, 
                    t1.nombre_rep_legal, 
                    t1.apellido_rep_legal,
                    t1.nombre_rep_tec, 
                    t1.apellido_rep_tec, 
                    t1.direccion, 
                    t1.telefono, 
                    t1.correo_electronico,
                    t1.clave,
                    t1.parroquia,
                    t1.provincia, 
                    t1.canton, 
                    t1.tipo_identificacion, 
                    t1.actividad, 
                    t1.estado_usuario,
                    t1.fecha_actualizacion::timestamp without time zone
                    FROM data t1
                    WHERE not exists (select 1 from operadores_banano ob where ob.identificador = t1.identificacion);";
        
        $res = $conexion->ejecutarConsulta($consulta);
        return $res;
    }


    public function obtenerProveedores($conexion, $fecha){
        // fecha_actualizacion >= '$fecha 00:00:01' 
        // and exportador is not null
        // and productor is not null;";
        $consulta="SELECT 
                        exportador, productor, producto, estado_contrato, fecha_actualizacion
                    FROM 
                        banano.proveedores
                    WHERE
                       
						exportador is not null
						and productor is not null;";
        
        $res = $conexion->ejecutarConsulta($consulta);
        return $res;
    }


    public function actualizarPorveedoresbanano($conexion,$valores){
        $consulta="UPDATE proveedores_banano as t1 set
                        exportador = t2.exportador,
                        productor = t2.productor,
                        producto = t2.producto,	                   
                        estado_contrato = t2.estado_contrato,
                        fecha_actualizacion = t2.fecha_actualizacion::timestamp without time zone
                    FROM 
                        (values
                            $valores
                        ) as t2(exportador, productor, producto, estado_contrato, fecha_actualizacion)
                    WHERE
                        t1.exportador::text = t2.exportador
                        and t1.productor::text = t2.productor
						and t1.producto::text = t2.producto;";
        
        $res = $conexion->ejecutarConsulta($consulta);
        return $res;
    }


    public function insertarProveedores($conexion, $valores){
        $consulta="with data(exportador, productor, producto, estado_contrato, fecha_actualizacion)  as (
                        values
                        $valores
                    ) 
                    insert into proveedores_banano (exportador, productor, producto, estado_contrato, fecha_actualizacion) 
                    SELECT t1.exportador, t1.productor, t1.producto, t1.estado_contrato, t1.fecha_actualizacion::timestamp without time zone
                    FROM data t1
                    WHERE not exists (select 1 
										from proveedores_banano pb 
										where pb.exportador = t1.exportador 
											and pb.productor = t1.productor
											and pb.producto = t1.producto);";
        
        $res = $conexion->ejecutarConsulta($consulta);
        return $res;
    }


    public function obtenerRegistroOperador($conexion,$fecha){// --fecha_actualizacion >= '$fecha 00:00:01' and  despues del were
        $consulta="SELECT 
                        identificacion, nombre_sitio, superficie, provincia, canton, 
                        parroquia, direccion, telefono, latitud_utm, longitud_utm, tipo_area, 
                        superficie_area, nombre_area, operacion, producto, estado_hacienda, 
                        codigo_transaccional, fecha_actualizacion,estado_verificacion
                    FROM 
                        banano.registro_operador
                    WHERE
                       
                        identificacion not in ('0000000000000','null') ";

        // $consulta="SELECT 
        //                 identificacion, nombre_sitio, superficie, provincia, canton, 
        //                 parroquia, direccion, telefono, latitud_utm, longitud_utm, tipo_area, 
        //                 superficie_area, nombre_area, operacion, producto, estado_hacienda, 
        //                 codigo_transaccional, fecha_actualizacion,estado_verificacion
        //             FROM 
        //                 banano_prue.registro_operador
        //             WHERE
        //             identificacion in (
        //                 '0992711639001',
        //                 '0791702496001',
        //                 '0991468439001',
        //                 '0916866767001',
        //                 '0791839858001',
        //                 '0916866767001'
        //                 ) ";
        
        $res = $conexion->ejecutarConsulta($consulta);
        return $res;
    }

     public function actualizarOperacionesBanano($conexion, $valores){
        $consulta ="UPDATE operaciones_banano as t1
                    SET
                        identificador=t2.identificador, 
                        nombre_sitio=t2.nombre_sitio, 
                        superficie_total=t2.superficie_total::double precision, 
                        provincia=t2.provincia, 
                        canton=t2.canton, 
                        parroquia=t2.parroquia, 
                        direccion=t2.direccion, 
                        telefono=t2.telefono, 
                        latitud=t2.latitud, 
                        longitud=t2.longitud, 
                        tipo_area=t2.tipo_area, 
                        superficie_utilizada=t2.superficie_utilizada::double precision, 
                        nombre_area=t2.nombre_area, 
                        tipo_operacion=t2.tipo_operacion, 
                        producto=t2.producto, 
                        estado=t2.estado, 
                        codigo_hacienda=t2.codigo_hacienda, 
                        fecha_actualizacion=t2.fecha_actualizacion::timestamp without time zone
                    FROM (
                        VALUES
                        $valores
                        )
                    as
                        t2(identificador, 
                        nombre_sitio, 
                        superficie_total, 
                        provincia, 
                        canton, 
                        parroquia, 
                        direccion, 
                        telefono, 
                        latitud, 
                        longitud, 
                        tipo_area, 
                        superficie_utilizada, 
                        nombre_area, 
                        tipo_operacion, 
                        producto, 
                        estado, 
                        codigo_hacienda, 
                        fecha_actualizacion)
                    WHERE
                        t1.identificador = t2.identificador 
						and t1.codigo_hacienda = t2.codigo_hacienda
						and t1.nombre_sitio = t2.nombre_sitio
						and t1.superficie_total = t2.superficie_total::double precision
						and t1.tipo_area = t2.tipo_area
						and t1.nombre_area = t2.nombre_area
						and t1.tipo_operacion = t2.tipo_operacion
						and t1.producto = t2.producto";
                        
        $res = $conexion->ejecutarConsulta($consulta);
        return $res;
    }

    

    public function insertarOperacionesBanano($conexion,$valores){
        $consulta="with data 
                        (identificacion, nombre_sitio, superficie, provincia, canton, 
                        parroquia, direccion, telefono, latitud_utm, longitud_utm, tipo_area, 
                        superficie_area, nombre_area, operacion, producto, estado_hacienda, 
                        codigo_hacienda, fecha_actualizacion) 
                    as (values
                        $valores
                        )
                    INSERT INTO operaciones_banano (identificador, nombre_sitio, superficie_total, provincia, 
                        canton, parroquia, direccion, telefono, latitud, longitud, tipo_area, 
                        superficie_utilizada, nombre_area, tipo_operacion, producto, 
                        estado, codigo_hacienda, fecha_actualizacion)
                    SELECT 
                        t1.identificacion, t1.nombre_sitio, t1.superficie::double precision, t1.provincia, t1.canton, 
                        t1.parroquia, t1.direccion, t1.telefono, t1.latitud_utm, t1.longitud_utm, t1.tipo_area, 
                        t1.superficie_area::double precision, t1.nombre_area, t1.operacion, t1.producto, t1.estado_hacienda, 
                        t1.codigo_hacienda, t1.fecha_actualizacion::timestamp without time zone
                    FROM
                        data t1
                    WHERE
                        not exists (SELECT 1 FROM operaciones_banano ob 
									WHERE 
										ob.identificador = t1.identificacion 
										and ob.codigo_hacienda = t1.codigo_hacienda
										and ob.estado in ('Atendida','Por atender','Por inactivar','W','Inactivado'))";
        
        $res = $conexion->ejecutarConsulta($consulta);
        return $res;
    }
}