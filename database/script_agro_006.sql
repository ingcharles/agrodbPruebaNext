/*
 
 Monitoreo de trampas - VIGILANCIA

 ************************************************************
*/

CREATE TABLE f_inspeccion.vigilanciaf01
(
  id                  SERIAL NOT NULL,
  id_tablet           INTEGER,
  fecha_inspeccion    TIMESTAMP WITHOUT TIME ZONE,
  usuario_id          CHARACTER VARYING(13),
  usuario             CHARACTER VARYING(150),
  tablet_id           CHARACTER VARYING(20),
  tablet_version_base CHARACTER VARYING(10),
  CONSTRAINT vigilanciaf01_pkey PRIMARY KEY (id)
);


CREATE TABLE f_inspeccion.vigilanciaf01_detalle_trampas
(
  id                       SERIAL NOT NULL,
  id_padre                 INTEGER,
  id_tablet                INTEGER,
  fecha_instalacion        TIMESTAMP WITHOUT TIME ZONE,
  codigo_trampa            CHARACTER VARYING(64),
  tipo_trampa              CHARACTER VARYING(64),
  id_provincia             CHARACTER VARYING(32),
  nombre_provincia         CHARACTER VARYING(64),
  id_canton                CHARACTER VARYING(32),
  nombre_canton            CHARACTER VARYING(64),
  id_parroquia             CHARACTER VARYING(32),
  nombre_parroquia         CHARACTER VARYING(64),
  estado_trampa            CHARACTER VARYING(8),
  coordenada_x             CHARACTER VARYING(6),
  coordenada_y             CHARACTER VARYING(8),
  coordenada_z             CHARACTER VARYING(4),
  id_lugar_instalacion     CHARACTER VARYING(32),
  nombre_lugar_instalacion CHARACTER VARYING(64),
  numero_lugar_instalacion INTEGER,
  fecha_inspeccion         TIMESTAMP WITHOUT TIME ZONE,
  semana                   CHARACTER VARYING(64),
  usuario_id               CHARACTER VARYING(13),
  usuario                  CHARACTER VARYING(150),
  propiedad_finca          CHARACTER VARYING(64),
  condicion_trampa         CHARACTER VARYING(64),
  especie                  CHARACTER VARYING(64),
  procedencia              CHARACTER VARYING(64),
  condicion_cultivo        CHARACTER VARYING(64),
  etapa_cultivo            CHARACTER VARYING(64),
  exposicion               CHARACTER VARYING(64),
  cambio_feromona          CHARACTER VARYING(2),
  cambio_papel             CHARACTER VARYING(2),
  cambio_aceite            CHARACTER VARYING(2),
  cambio_trampa            CHARACTER VARYING(2),
  numero_especimenes       INTEGER,
  diagnostico_visual       CHARACTER VARYING(256),
  fase_plaga               CHARACTER VARYING(256),
  observaciones            TEXT,
  envio_muestra            CHARACTER VARYING(2),
  tablet_id                CHARACTER VARYING(20),
  tablet_version_base      CHARACTER VARYING(10),
  CONSTRAINT vigilanciaf01_detalle_trampas_pkey PRIMARY KEY (id),
  CONSTRAINT fk_vigilanciaf01_detalle_trampas FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.vigilanciaf01 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE INDEX ON f_inspeccion.vigilanciaf01_detalle_trampas USING BTREE (nombre_provincia ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.vigilanciaf01_detalle_trampas USING BTREE (nombre_canton ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.vigilanciaf01_detalle_trampas USING BTREE (diagnostico_visual ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.vigilanciaf01_detalle_trampas USING BTREE (especie ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.vigilanciaf01_detalle_trampas USING BTREE (envio_muestra ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.vigilanciaf01_detalle_trampas USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.fecha_instalacion IS 'Fecha instalacion';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.codigo_trampa IS 'Código de trampa';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.tipo_trampa IS 'Tipo de trampa';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.id_provincia IS 'Código de provincia';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.nombre_provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.id_canton IS 'Código de cantón';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.nombre_canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.id_parroquia IS 'Código de parroquia';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.nombre_parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.estado_trampa IS 'Estado de la trampa';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.coordenada_x IS 'X';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.coordenada_y IS 'Y';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.coordenada_z IS 'Z';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.id_lugar_instalacion IS 'Código de lugar de instalación';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.nombre_lugar_instalacion IS 'Nombre de lugar de instalación';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.numero_lugar_instalacion IS 'Número de lugar de instalación';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.fecha_inspeccion IS 'Fecha de inspección (Servicio)';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.semana IS 'Semana';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.usuario_id IS 'Cédula de inspector';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.usuario IS 'Inspector';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.propiedad_finca IS 'Propiedad/Finca';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.condicion_trampa IS 'Condición de la trampa';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.especie IS 'Especie vegetal/Producto';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.procedencia IS 'Procedencia';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.condicion_cultivo IS 'Condición del cultivo';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.etapa_cultivo IS 'Etapa del cultivo';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.exposicion IS 'Exposición (días)';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.cambio_feromona IS 'Cambio de feromona';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.cambio_papel IS 'Cambio de papel absorbente';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.cambio_aceite IS 'Cambio de aceite';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.cambio_trampa IS 'Cambio de trampa';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.numero_especimenes IS 'Número de espcímenes capturados';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.diagnostico_visual IS 'Diagnostico visual';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.fase_plaga IS 'Fase de desarrollo de la plaga';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.observaciones IS 'Observaciones';
COMMENT ON COLUMN f_inspeccion.vigilanciaf01_detalle_trampas.envio_muestra IS 'Envío de muestra';


CREATE TABLE f_inspeccion.vigilanciaf01_detalle_ordenes
(
  id                          SERIAL NOT NULL,
  id_padre                    INTEGER,
  id_tablet                   INTEGER,
  actividad_origen            CHARACTER VARYING(64)  DEFAULT 'Vigilancia fitosanitaria',
  analisis                    TEXT,
  codigo_muestra              CHARACTER VARYING(64),
  conservacion                CHARACTER VARYING(64)  DEFAULT 'Envase apropiado',
  tipo_muestra                CHARACTER VARYING(64)  DEFAULT 'Insectos en alcohol',
  descripcion_sintomas        CHARACTER VARYING(256) DEFAULT 'N/A',
  fase_fenologica             CHARACTER VARYING(64)  DEFAULT 'N/A',
  nombre_producto             CHARACTER VARYING(64),
  peso_muestra                NUMERIC                DEFAULT 0,
  prediagnostico              CHARACTER VARYING(256),
  tipo_cliente                CHARACTER VARYING(64)  DEFAULT 'Interno',
  aplicacion_producto_quimico CHARACTER VARYING(16),
  CONSTRAINT vigilanciaf01_detalle_ordenes_pkey PRIMARY KEY (id),
  CONSTRAINT fk_vigilanciaf01_detalle_ordenes FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.vigilanciaf01 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

/*
Reporte 9
Pantalla de REPORTE GENERAL DE TRAMPEO VIGILANCIA en el GUIA

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
  'Reporte general de trampeo Vigilancia',
  'reporteGeneralTrampeoVigilancia',
  9);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteGeneralTrampeoVigilancia'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteGeneralTrampeoVigilancia' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/