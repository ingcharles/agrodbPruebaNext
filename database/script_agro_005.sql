/*
 
 Formulario de CARACTERIZACION FRUTICOLA

 ************************************************************
*/

CREATE TABLE f_inspeccion.moscaf02
(
  id                          SERIAL NOT NULL,
  id_tablet                   INTEGER,
  nombre_asociacion_productor CHARACTER VARYING(256),
  identificador               CHARACTER VARYING(13),
  telefono                    CHARACTER VARYING(32),
  codigo_provincia            CHARACTER VARYING(32),
  provincia                   CHARACTER VARYING(64),
  codigo_canton               CHARACTER VARYING(32),
  canton                      CHARACTER VARYING(64),
  codigo_parroquia            CHARACTER VARYING(32),
  parroquia                   CHARACTER VARYING(64),
  sitio                       CHARACTER VARYING(256),
  especie                     CHARACTER VARYING(256),
  variedad                    CHARACTER VARYING(256),
  area_produccion_estimada    NUMERIC,
  coordenada_x                CHARACTER VARYING(6),
  coordenada_y                CHARACTER VARYING(8),
  coordenada_z                CHARACTER VARYING(4),
  observaciones               TEXT,
  fecha_inspeccion            TIMESTAMP WITHOUT TIME ZONE,
  usuario_id                  CHARACTER VARYING(13),
  usuario                     CHARACTER VARYING(150),
  tablet_id                   CHARACTER VARYING(20),
  tablet_version_base         CHARACTER VARYING(10),
  CONSTRAINT moscaf02_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.moscaf02 USING BTREE (nombre_asociacion_productor ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.moscaf02 USING BTREE (provincia ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.moscaf02 USING BTREE (especie ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.moscaf02 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.moscaf02.nombre_asociacion_productor IS 'Asociación/Productor';
COMMENT ON COLUMN f_inspeccion.moscaf02.identificador IS 'Cédula/RUC';
COMMENT ON COLUMN f_inspeccion.moscaf02.telefono IS 'Teléfono';
COMMENT ON COLUMN f_inspeccion.moscaf02.codigo_provincia IS 'Código provincia';
COMMENT ON COLUMN f_inspeccion.moscaf02.provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.moscaf02.codigo_canton IS 'Código cantón';
COMMENT ON COLUMN f_inspeccion.moscaf02.canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.moscaf02.codigo_parroquia IS 'Código parroquia';
COMMENT ON COLUMN f_inspeccion.moscaf02.parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.moscaf02.sitio IS 'Sitio';
COMMENT ON COLUMN f_inspeccion.moscaf02.especie IS 'Especie de producto Hortofrutícula';
COMMENT ON COLUMN f_inspeccion.moscaf02.variedad IS 'Variedad de producto Hortofrutícula';
COMMENT ON COLUMN f_inspeccion.moscaf02.area_produccion_estimada IS 'Área de producción estimada (Ha)';
COMMENT ON COLUMN f_inspeccion.moscaf02.coordenada_x IS 'X';
COMMENT ON COLUMN f_inspeccion.moscaf02.coordenada_y IS 'Y';
COMMENT ON COLUMN f_inspeccion.moscaf02.coordenada_z IS 'Z';
COMMENT ON COLUMN f_inspeccion.moscaf02.observaciones IS 'Observaciones';
COMMENT ON COLUMN f_inspeccion.moscaf02.fecha_inspeccion IS 'Fecha de registro';
COMMENT ON COLUMN f_inspeccion.moscaf02.usuario_id IS 'Identificación inspector';
COMMENT ON COLUMN f_inspeccion.moscaf02.usuario IS 'Inspector';


/*
Reporte 7
Pantalla de REPORTE GENERAL DE PRODUCCION FRUTICOLA en el GUIA

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
  'Reporte general de caracterización frutícola',
  'reporteGeneralCaracterizacionFruticola',
  7);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteGeneralCaracterizacionFruticola'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteGeneralCaracterizacionFruticola' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/



/*
Reporte 8
Pantalla de REPORTE DE DUPLICADOS CARACTERIZACION FRUTICOLA en el GUIA

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
  'Reporte de duplicados de caracterización frutícola',
  'reporteDuplicadosCaracterizacionFruticola',
  8);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteDuplicadosCaracterizacionFruticola'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteDuplicadosCaracterizacionFruticola' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/



CREATE TABLE f_inspeccion.moscaf03
(
  id                    SERIAL NOT NULL,
  id_tablet             INTEGER,
  codigo_provincia      CHARACTER VARYING(32),
  nombre_provincia      CHARACTER VARYING(256),
  codigo_canton         CHARACTER VARYING(32),
  nombre_canton         CHARACTER VARYING(256),
  codigo_parroquia      CHARACTER VARYING(32),
  nombre_parroquia      CHARACTER VARYING(256),
  codigo_lugar_muestreo CHARACTER VARYING(4),
  nombre_lugar_muestreo CHARACTER VARYING(64),
  semana                INTEGER,
  coordenada_x          CHARACTER VARYING(6),
  coordenada_y          CHARACTER VARYING(8),
  coordenada_z          CHARACTER VARYING(4),
  fecha_inspeccion      TIMESTAMP WITHOUT TIME ZONE,
  usuario_id            CHARACTER VARYING(13),
  usuario               CHARACTER VARYING(256),
  tablet_id             CHARACTER VARYING(20),
  tablet_version_base   CHARACTER VARYING(10),
  CONSTRAINT moscaf03_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.moscaf03 USING BTREE (codigo_provincia ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.moscaf03 USING BTREE (codigo_canton ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.moscaf03 USING BTREE (codigo_lugar_muestreo ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.moscaf03 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.moscaf03.nombre_provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.moscaf03.nombre_canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.moscaf03.nombre_parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.moscaf03.nombre_lugar_muestreo IS 'Lugar de muestreo';
COMMENT ON COLUMN f_inspeccion.moscaf03.semana IS 'Semana';
COMMENT ON COLUMN f_inspeccion.moscaf03.coordenada_x IS 'X';
COMMENT ON COLUMN f_inspeccion.moscaf03.coordenada_y IS 'Y';
COMMENT ON COLUMN f_inspeccion.moscaf03.coordenada_z IS 'Z';
COMMENT ON COLUMN f_inspeccion.moscaf03.fecha_inspeccion IS 'Fecha de registro';
COMMENT ON COLUMN f_inspeccion.moscaf03.usuario_id IS 'Identificación inspector';
COMMENT ON COLUMN f_inspeccion.moscaf03.usuario IS 'Inspector';


CREATE TABLE f_inspeccion.moscaf03_detalle_ordenes
(
  id                          SERIAL NOT NULL,
  id_padre                    INTEGER,
  id_tablet                   INTEGER,
  actividad_origen            CHARACTER VARYING(50)  DEFAULT 'Programas específicos - PNMMF',
  analisis                    CHARACTER VARYING(250) DEFAULT 'Entomológico',
  aplicacion_producto_quimico CHARACTER VARYING(16),
  codigo_muestra              CHARACTER VARYING(50),
  conservacion                CHARACTER VARYING(50)  DEFAULT 'Envase apropiado',
  tipo_muestra                CHARACTER VARYING(50)  DEFAULT 'Frutas',
  descripcion_sintomas        CHARACTER VARYING(150),
  fase_fenologica             CHARACTER VARYING(50)  DEFAULT 'N/A',
  nombre_producto             CHARACTER VARYING(50)  DEFAULT 'Otros',
  peso_muestra                NUMERIC                DEFAULT 0,
  prediagnostico              CHARACTER VARYING(150) DEFAULT 'Mosca de la fruta',
  tipo_cliente                CHARACTER VARYING(50)  DEFAULT 'Interno',
  especie_vegetal             CHARACTER VARYING(256),
  sitio_muestreo              CHARACTER VARYING(32),
  numero_frutos_colectados    INTEGER,
  CONSTRAINT moscaf03_detalle_ordenes_pkey PRIMARY KEY (id),
  CONSTRAINT fk_moscaf03_detalle_ordenes FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.moscaf03 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

COMMENT ON COLUMN f_inspeccion.moscaf03_detalle_ordenes.codigo_muestra IS 'Código de la muestra';
COMMENT ON COLUMN f_inspeccion.moscaf03_detalle_ordenes.especie_vegetal IS 'Especie vegetal';
COMMENT ON COLUMN f_inspeccion.moscaf03_detalle_ordenes.sitio_muestreo IS 'Sitio de muestreo';
COMMENT ON COLUMN f_inspeccion.moscaf03_detalle_ordenes.numero_frutos_colectados IS 'Número de frutos colectados';


/*
Reporte 20
Pantalla de REPORTE DE DUPLICADOS CARACTERIZACION FRUTICOLA en el GUIA

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
  'Reporte de general de muestreo de frutos',
  'reporteGeneralMuestreoFrutos',
  20);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteGeneralMuestreoFrutos'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteGeneralMuestreoFrutos' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/