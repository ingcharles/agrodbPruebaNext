/*
 
 Monitoreo de trampas - MOSCA

 ************************************************************
*/

CREATE TABLE f_inspeccion.moscaf01
(
  id                  SERIAL NOT NULL,
  id_tablet           INTEGER,
  fecha_inspeccion    TIMESTAMP WITHOUT TIME ZONE,
  usuario_id          CHARACTER VARYING(13),
  usuario             CHARACTER VARYING(150),
  tablet_id           CHARACTER VARYING(20),
  tablet_version_base CHARACTER VARYING(10),
  CONSTRAINT moscaf01_pkey PRIMARY KEY (id)
);


CREATE TABLE f_inspeccion.moscaf01_detalle_trampas
(
  id                           SERIAL NOT NULL,
  id_padre                     INTEGER,
  id_tablet                    INTEGER,
  id_provincia                 CHARACTER VARYING(32),
  nombre_provincia             CHARACTER VARYING(64),
  id_canton                    CHARACTER VARYING(32),
  nombre_canton                CHARACTER VARYING(64),
  id_parroquia                 CHARACTER VARYING(32),
  nombre_parroquia             CHARACTER VARYING(64),
  id_lugar_instalacion         CHARACTER VARYING(32),
  nombre_lugar_instalacion     CHARACTER VARYING(64),
  numero_lugar_instalacion     INTEGER,
  id_tipo_atrayente            CHARACTER VARYING(32),
  nombre_tipo_atrayente        CHARACTER VARYING(64),
  tipo_trampa                  CHARACTER VARYING(64),
  codigo_trampa                CHARACTER VARYING(64),
  semana                       INTEGER,
  coordenada_x                 CHARACTER VARYING(6),
  coordenada_y                 CHARACTER VARYING(8),
  coordenada_z                 CHARACTER VARYING(4),
  fecha_instalacion            TIMESTAMP WITHOUT TIME ZONE,
  estado_trampa                CHARACTER VARYING(16),
  exposicion                   CHARACTER VARYING(4),
  condicion                    CHARACTER VARYING(16),
  cambio_trampa                CHARACTER VARYING(4),
  cambio_plug                  CHARACTER VARYING(4),
  especie_principal            CHARACTER VARYING(100),
  estado_fenologico_principal  CHARACTER VARYING(100),
  especie_colindante           CHARACTER VARYING(100),
  estado_fenologico_colindante CHARACTER VARYING(100),
  numero_especimenes           INTEGER,
  observaciones                TEXT,
  envio_muestra                CHARACTER VARYING(32),
  estado_registro              CHARACTER VARYING(16),
  fecha_inspeccion             TIMESTAMP WITHOUT TIME ZONE,
  usuario_id                   CHARACTER VARYING(13),
  usuario                      CHARACTER VARYING(150),
  tablet_id                    CHARACTER VARYING(20),
  tablet_version_base          CHARACTER VARYING(10),
  CONSTRAINT moscaf01_detalle_trampas_pkey PRIMARY KEY (id),
  CONSTRAINT fk_moscaf01_detalle_trampas FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.moscaf01 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE INDEX ON f_inspeccion.moscaf01_detalle_trampas USING BTREE (id_provincia ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.moscaf01_detalle_trampas USING BTREE (id_canton ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.moscaf01_detalle_trampas USING BTREE (id_lugar_instalacion ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.moscaf01_detalle_trampas USING BTREE (id_tipo_atrayente ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.moscaf01_detalle_trampas USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.nombre_provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.id_provincia IS 'Código de provincia';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.nombre_canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.id_canton IS 'Código de cantón';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.nombre_parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.id_parroquia IS 'Código de parroquia';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.id_lugar_instalacion IS 'Código de lugar de instalación';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.nombre_lugar_instalacion IS 'Lugar de instalación';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.numero_lugar_instalacion IS 'Número de instalación';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.tipo_trampa IS 'Tipo de trampa';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.id_tipo_atrayente IS 'Código tipo de atrayente';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.nombre_tipo_atrayente IS 'Tipo de atrayente';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.codigo_trampa IS 'Código de trampa';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.semana IS 'Semana de servicio';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.coordenada_x IS 'Coordenada X';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.coordenada_y IS 'Coordenada Y';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.coordenada_z IS 'Coordenada Z';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.fecha_instalacion IS 'Fecha de instalación de trampa';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.exposicion IS 'Exposición';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.condicion IS 'Condición';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.cambio_trampa IS 'Cambio de trampa';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.cambio_plug IS 'Cambio de plug';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.estado_trampa IS 'Estado';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.especie_principal IS 'Especie principal';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.estado_fenologico_principal IS 'Estado fenológico de especie principal';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.especie_colindante IS 'Especie colindante';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.estado_fenologico_colindante IS 'Estado fenológico de especie colindante';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.numero_especimenes IS 'Número de especímenes capturados';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.observaciones IS 'Observación';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.envio_muestra IS 'Envío de muestra';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.fecha_inspeccion IS 'Fecha de servicio';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.usuario_id IS 'Cédula inspector';
COMMENT ON COLUMN f_inspeccion.moscaf01_detalle_trampas.usuario IS 'Inspector';

CREATE TABLE f_inspeccion.moscaf01_detalle_ordenes
(
  id                          SERIAL NOT NULL,
  id_padre                    INTEGER,
  id_tablet                   INTEGER,
  actividad_origen            CHARACTER VARYING(50)  DEFAULT 'Programas específicos - PNMMF',
  analisis                    CHARACTER VARYING(250),
  codigo_muestra              CHARACTER VARYING(50),
  conservacion                CHARACTER VARYING(50)  DEFAULT 'Envase apropiado',
  tipo_muestra                CHARACTER VARYING(50),
  descripcion_sintomas        CHARACTER VARYING(150) DEFAULT 'N/A',
  fase_fenologica             CHARACTER VARYING(50)  DEFAULT 'N/A',
  nombre_producto             CHARACTER VARYING(50)  DEFAULT 'Otros',
  peso_muestra                NUMERIC                DEFAULT 0,
  prediagnostico              CHARACTER VARYING(150) DEFAULT 'Mosca de la fruta',
  tipo_cliente                CHARACTER VARYING(50)  DEFAULT 'Interno',
  aplicacion_producto_quimico CHARACTER VARYING(16)  DEFAULT 'N/A',
  CONSTRAINT moscaf01_detalle_ordenes_pkey PRIMARY KEY (id),
  CONSTRAINT fk_moscaf01_detalle_ordenes FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.moscaf01 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

/*
Reporte 5
Pantalla de REPORTE GENERAL DE TRAMPEO DE MOSCA en el GUIA

*/

INSERT INTO g_programas.opciones (
  id_aplicacion,
  nombre_opcion,
  pagina,
  orden)
VALUES (
  (SELECT a.id_aplicacion
   FROM g_programas.aplicaciones a
   WHERE a.codificacion_aplicacion = 'PRG_REP'),
  'Reporte general de trampeo de mosca',
  'reporteGeneralTrampeoMosca',
  5);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteGeneralTrampeoMosca'),
  'TODO',
  1,
  (SELECT a.id_aplicacion
   FROM g_programas.aplicaciones a
   WHERE a.codificacion_aplicacion = 'PRG_REP'));


INSERT INTO g_programas.acciones_perfiles (
  id_perfil,
  id_accion)
VALUES ((SELECT p.id_perfil
         FROM g_usuario.perfiles p
         WHERE p.codificacion_perfil = 'CSV_REPOR_CONSU'
         LIMIT 1),
        (SELECT a.id_accion
         FROM g_programas.opciones o, g_programas.acciones a, g_programas.aplicaciones ap
         WHERE
           a.id_opcion = o.id_opcion AND o.pagina = 'reporteGeneralTrampeoMosca' AND o.id_aplicacion = ap.id_aplicacion
           AND ap.codificacion_aplicacion = 'PRG_REP' AND a.id_aplicacion = ap.id_aplicacion AND
           a.id_opcion = o.id_opcion));


/*
FIN
*/


/*
Reporte 6
Pantalla de REPORTE MTD (MOSCA) en el GUIA
Tarjeta #025

SE COMENTA ESTA SECCIÓN YA QUE MTD NO SE PUEDE GENERAR SIN DATOS DE LABORATORIO
*/
/*
INSERT INTO g_programas.opciones(
            id_aplicacion, 
			nombre_opcion,  
			pagina, 
			orden)
    VALUES (
			(SELECT a.id_aplicacion FROM g_programas.aplicaciones a WHERE a.codificacion_aplicacion = 'PRG_REP'), 
			'Reporte MTD (mosca)', 
			'reporteMTDMosca',
			6);
			
INSERT INTO g_programas.acciones(
			id_opcion, 
			descripcion, 
			orden, 
			id_aplicacion)
    VALUES (
			(SELECT o.id_opcion FROM g_programas.opciones o WHERE o.pagina = 'reporteMTDMosca'), 
			'TODO', 
			1, 
			(SELECT a.id_aplicacion FROM g_programas.aplicaciones a WHERE a.codificacion_aplicacion = 'PRG_REP'));

			
INSERT INTO g_programas.acciones_perfiles(
            id_perfil,
			id_accion)
    VALUES ((SELECT p.id_perfil FROM g_usuario.perfiles p WHERE p.codificacion_perfil = 'CSV_REPOR_CONSU' LIMIT 1), 
			(SELECT a.id_accion FROM g_programas.opciones o, g_programas.acciones a, g_programas.aplicaciones ap WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteMTDMosca' AND o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));
*/
/*
FIN
*/
