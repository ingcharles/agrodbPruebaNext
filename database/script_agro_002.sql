/*


SCRIPTS DE EDISON


 *****************************************************************************/

/*
ALTER TABLE g_catalogos.lugares_inspeccion ADD COLUMN id_puerto integer;

UPDATE g_catalogos.puertos SET nombre_provincia='Manabí', id_provincia =254  WHERE
id_puerto=22934;

INSERT INTO g_catalogos.lugares_inspeccion (nombre,codigo_vue, id_provincia, nombre_ciudad_vue, codigo_ciudad_vue, nombre_provincia) VALUES('CEBAF SAN MIGUEL','','262','Sucumbíos','NVL','Sucumbios');
INSERT INTO g_catalogos.lugares_inspeccion (nombre,codigo_vue, id_provincia, nombre_ciudad_vue, codigo_ciudad_vue, nombre_provincia) VALUES('MACARA','','252','Loja','LOH','Loja');
INSERT INTO g_catalogos.lugares_inspeccion (nombre,codigo_vue, id_provincia, nombre_ciudad_vue, codigo_ciudad_vue, nombre_provincia) VALUES('AEROPUERTO DE ESMERALDAS','','248','Esmeraldas','ESM','Esmeraldas');
INSERT INTO g_catalogos.lugares_inspeccion (nombre,codigo_vue, id_provincia, nombre_ciudad_vue, codigo_ciudad_vue, nombre_provincia) VALUES('AEROPUERTO DE MANTA','','254','Manta','PVO','Manabí');

UPDATE g_catalogos.lugares_inspeccion SET id_puerto=8944 WHERE  (id_lugar=1);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=39110 WHERE  (id_lugar=2);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=39110 WHERE  (id_lugar=3);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14255 WHERE  (id_lugar=4);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14255 WHERE  (id_lugar=5);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=11349 WHERE  (id_lugar=6);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=22933 WHERE  (id_lugar=7);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=39110 WHERE  (id_lugar=8);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=39110 WHERE  (id_lugar=9);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=39110 WHERE  (id_lugar=10);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14256 WHERE  (id_lugar=11);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14255 WHERE  (id_lugar=12);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14256 WHERE  (id_lugar=13);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14255 WHERE  (id_lugar=14);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=16141 WHERE  (id_lugar=15);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14256 WHERE  (id_lugar=16);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=30882 WHERE  (id_lugar=17);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14256 WHERE  (id_lugar=18);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14255 WHERE  (id_lugar=19);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=30882 WHERE  (id_lugar=20);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14255 WHERE  (id_lugar=21);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14256 WHERE  (id_lugar=22);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=39110 WHERE  (id_lugar=23);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14255 WHERE  (id_lugar=24);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=16141 WHERE  (id_lugar=25);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14255 WHERE  (id_lugar=26);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=16141 WHERE  (id_lugar=27);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=20651 WHERE  (id_lugar=28);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14256 WHERE  (id_lugar=29);


UPDATE g_catalogos.lugares_inspeccion SET id_puerto=30882 WHERE  (id_lugar=30);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=30882 WHERE  (id_lugar=31);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=20651 WHERE  (id_lugar=32);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=30882 WHERE  (id_lugar=33);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14256 WHERE  (id_lugar=34);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14256 WHERE  (id_lugar=35);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14255 WHERE  (id_lugar=36);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=16141 WHERE  (id_lugar=37);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=39110 WHERE  (id_lugar=38);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=39110 WHERE  (id_lugar=39);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14255 WHERE  (id_lugar=40);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=30882 WHERE  (id_lugar=41);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=30532 WHERE  (id_lugar=42);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=14255 WHERE  (id_lugar=43);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=27333 WHERE  (id_lugar=44);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=22304 WHERE  (id_lugar=45);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=11350 WHERE  (id_lugar=46);
UPDATE g_catalogos.lugares_inspeccion SET id_puerto=22934 WHERE  (id_lugar=47);

CREATE TABLE g_catalogos.tipos_envase
(
  id_envase serial NOT NULL,
  nombre_envase character varying(128),
  id_area character varying(10),
  estado character varying(8) DEFAULT 'activo'::character varying,
  CONSTRAINT tipos_envase_pkey PRIMARY KEY (id_envase)
)
WITH (
  OIDS=FALSE
);

INSERT INTO g_catalogos.tipos_envase (nombre_envase, id_area) VALUES('Canastas','SV');
INSERT INTO g_catalogos.tipos_envase (nombre_envase, id_area) VALUES('Bultos','SV');
INSERT INTO g_catalogos.tipos_envase (nombre_envase, id_area) VALUES('Cajas','SV');
INSERT INTO g_catalogos.tipos_envase (nombre_envase, id_area) VALUES('Fundas','SV');
INSERT INTO g_catalogos.tipos_envase (nombre_envase, id_area) VALUES('Gaveta','SV');
INSERT INTO g_catalogos.tipos_envase (nombre_envase, id_area) VALUES('Sacos','SV'); */


CREATE TABLE f_inspeccion.controlf02
(
  id                          SERIAL NOT NULL,
  id_tablet                   INTEGER,
  nombre_razon_social         CHARACTER VARYING(250),
  ruc_ci                      CHARACTER VARYING(13),
  id_pais_origen              CHARACTER VARYING(32),
  pais_origen                 CHARACTER VARYING(64),
  id_pais_procedencia         CHARACTER VARYING(32),
  pais_procedencia            CHARACTER VARYING(64),
  id_pais_destino             CHARACTER VARYING(32),
  pais_destino                CHARACTER VARYING(64),
  id_punto_ingreso            CHARACTER VARYING(32),
  punto_ingreso               CHARACTER VARYING(256),
  id_punto_salida             CHARACTER VARYING(32),
  punto_salida                CHARACTER VARYING(256),
  placa_vehiculo              CHARACTER VARYING(20),
  dda                         CHARACTER VARYING(25),
  precinto_sticker            CHARACTER VARYING(10),
  estado                      CHARACTER VARYING(10), -- Ingreso, Salida
  tipo_verificacion           CHARACTER VARYING(20), -- Fitosanitaria, Por medio de SENAE
  estado_precinto             CHARACTER VARYING(20),

  fecha_ingreso               TIMESTAMP WITHOUT TIME ZONE,
  usuario_id_ingreso          CHARACTER VARYING(13),
  usuario_ingreso             CHARACTER VARYING(150),
  tablet_id_ingreso           CHARACTER VARYING(20),
  tablet_version_base_ingreso CHARACTER VARYING(10),

  fecha_salida                TIMESTAMP WITHOUT TIME ZONE,
  usuario_id_salida           CHARACTER VARYING(13),
  usuario_salida              CHARACTER VARYING(150),
  tablet_id_salida            CHARACTER VARYING(20),
  tablet_version_base_salida  CHARACTER VARYING(10),

  CONSTRAINT controlf02_pkey PRIMARY KEY (id)
);

COMMENT ON COLUMN f_inspeccion.controlf02.nombre_razon_social IS 'Nombre de razón social';
COMMENT ON COLUMN f_inspeccion.controlf02.ruc_ci IS 'RUC/CI';
COMMENT ON COLUMN f_inspeccion.controlf02.pais_origen IS 'País de origen';
COMMENT ON COLUMN f_inspeccion.controlf02.pais_procedencia IS 'País de procedencia';
COMMENT ON COLUMN f_inspeccion.controlf02.pais_destino IS 'País de destino';
COMMENT ON COLUMN f_inspeccion.controlf02.punto_ingreso IS 'Punto de ingreso';
COMMENT ON COLUMN f_inspeccion.controlf02.punto_salida IS 'Punto de salida';
COMMENT ON COLUMN f_inspeccion.controlf02.placa_vehiculo IS 'Placa del vehículo';
COMMENT ON COLUMN f_inspeccion.controlf02.dda IS 'DDA';
COMMENT ON COLUMN f_inspeccion.controlf02.precinto_sticker IS 'Número precinto/sticker';
COMMENT ON COLUMN f_inspeccion.controlf02.estado IS 'Estado de carga';
COMMENT ON COLUMN f_inspeccion.controlf02.tipo_verificacion IS 'Tipo de verificación';
COMMENT ON COLUMN f_inspeccion.controlf02.estado_precinto IS 'Estado precinto/sticker a salida';
COMMENT ON COLUMN f_inspeccion.controlf02.fecha_ingreso IS 'Fecha de registro de ingreso';
COMMENT ON COLUMN f_inspeccion.controlf02.usuario_id_ingreso IS 'Cédula del inspector de registro de ingreso';
COMMENT ON COLUMN f_inspeccion.controlf02.usuario_ingreso IS 'Usuario de registro de ingreso';
COMMENT ON COLUMN f_inspeccion.controlf02.fecha_salida IS 'Fecha de registro de salida';
COMMENT ON COLUMN f_inspeccion.controlf02.usuario_id_salida IS 'Cédula del inspector de registro de salida';
COMMENT ON COLUMN f_inspeccion.controlf02.usuario_salida IS 'Usuario de registro de salida';

CREATE TABLE f_inspeccion.controlf02_detalle_productos
(
  id                  SERIAL NOT NULL,
  id_padre            INTEGER,
  id_tablet           INTEGER,
  partida_arancelaria CHARACTER VARYING(25),
  producto            CHARACTER VARYING(50),
  subtipo             CHARACTER VARYING(50),
  cantidad            NUMERIC,
  tipo_envase         CHARACTER VARYING(25),
  CONSTRAINT controlf02_detalle_productos_pkey PRIMARY KEY (id),
  CONSTRAINT fk_controlf02_detalle_productos FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.controlf02 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

COMMENT ON COLUMN f_inspeccion.controlf02_detalle_productos.partida_arancelaria IS 'Partida arancelaria';
COMMENT ON COLUMN f_inspeccion.controlf02_detalle_productos.producto IS 'Producto';
COMMENT ON COLUMN f_inspeccion.controlf02_detalle_productos.subtipo IS 'Subtipo';
COMMENT ON COLUMN f_inspeccion.controlf02_detalle_productos.cantidad IS 'Peso';
COMMENT ON COLUMN f_inspeccion.controlf02_detalle_productos.tipo_envase IS 'Tipo de envase';

CREATE TABLE f_inspeccion.controlf03
(
  id                                  SERIAL NOT NULL,
  id_tablet                           INTEGER,
  id_punto_control                    CHARACTER VARYING(32),
  punto_control                       CHARACTER VARYING(256),
  area_inspeccion                     CHARACTER VARYING(256),
  identidad_embalaje                  CHARACTER VARYING(50),
  id_pais_origen                      CHARACTER VARYING(32),
  pais_origen                         CHARACTER VARYING(64),
  numero_embalajes                    INTEGER,
  numero_unidades                     INTEGER,
  marca_autorizada                    CHARACTER VARYING(50),
  marca_autorizada_descripcion        CHARACTER VARYING(150),
  marca_legible                       CHARACTER VARYING(50),
  marca_legible_descripcion           CHARACTER VARYING(150),
  ausencia_dano_insectos              CHARACTER VARYING(50),
  ausencia_dano_insectos_descripcion  CHARACTER VARYING(150),
  ausencia_insectos_vivos             CHARACTER VARYING(50),
  ausencia_insectos_vivos_descripcion CHARACTER VARYING(150),
  ausencia_corteza                    CHARACTER VARYING(50),
  ausencia_corteza_descripcion        CHARACTER VARYING(150),
  razon_social                        CHARACTER VARYING(250),
  manifesto                           CHARACTER VARYING(250),
  producto                            CHARACTER VARYING(250),
  envio_muestra                       CHARACTER VARYING(20),
  observaciones                       TEXT,
  dicatamen_final                     CHARACTER VARYING(250),
  fecha_inspeccion                    TIMESTAMP WITHOUT TIME ZONE,
  usuario_id                          CHARACTER VARYING(13),
  usuario                             CHARACTER VARYING(150),
  tablet_id                           CHARACTER VARYING(20),
  tablet_version_base                 CHARACTER VARYING(10),
  CONSTRAINT controlf03_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.controlf03 USING BTREE (punto_control ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.controlf03 USING BTREE (pais_origen ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.controlf03 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.controlf03.punto_control IS 'Punto de control';
COMMENT ON COLUMN f_inspeccion.controlf03.area_inspeccion IS 'Área de inspección';
COMMENT ON COLUMN f_inspeccion.controlf03.identidad_embalaje IS 'Indentidad de embalaje';
COMMENT ON COLUMN f_inspeccion.controlf03.pais_origen IS 'País de origen';
COMMENT ON COLUMN f_inspeccion.controlf03.numero_embalajes IS 'Número de embalajes';
COMMENT ON COLUMN f_inspeccion.controlf03.numero_unidades IS 'Número de unidades';
COMMENT ON COLUMN f_inspeccion.controlf03.marca_autorizada IS 'Embalajes cuentan con marca autorizada';
COMMENT ON COLUMN f_inspeccion.controlf03.marca_autorizada_descripcion IS 'Descripción de marca autorizada';
COMMENT ON COLUMN f_inspeccion.controlf03.marca_legible IS 'Marca es legible';
COMMENT ON COLUMN f_inspeccion.controlf03.marca_legible_descripcion IS 'Descripción de marca legible';
COMMENT ON COLUMN f_inspeccion.controlf03.ausencia_dano_insectos IS 'Ausencia de daño de insectos';
COMMENT ON COLUMN f_inspeccion.controlf03.ausencia_dano_insectos_descripcion IS 'Descripción de ausencia de daño de insectos';
COMMENT ON COLUMN f_inspeccion.controlf03.ausencia_insectos_vivos IS 'Ausencia de insectos vivos';
COMMENT ON COLUMN f_inspeccion.controlf03.ausencia_insectos_vivos_descripcion IS 'Descripción de ausencia de insectos vivos';
COMMENT ON COLUMN f_inspeccion.controlf03.ausencia_corteza IS 'Ausencia de corteza';
COMMENT ON COLUMN f_inspeccion.controlf03.ausencia_corteza_descripcion IS 'Descripción de ausencia de corteza';
COMMENT ON COLUMN f_inspeccion.controlf03.razon_social IS 'Razón social';
COMMENT ON COLUMN f_inspeccion.controlf03.manifesto IS 'Manifesto';
COMMENT ON COLUMN f_inspeccion.controlf03.producto IS 'Producto';
COMMENT ON COLUMN f_inspeccion.controlf03.envio_muestra IS '¿Envío de muestra?';
COMMENT ON COLUMN f_inspeccion.controlf03.observaciones IS 'Observaciones de inspección';
COMMENT ON COLUMN f_inspeccion.controlf03.dicatamen_final IS 'Dictamen final de inspección';
COMMENT ON COLUMN f_inspeccion.controlf03.fecha_inspeccion IS 'Fecha de la inspección';
COMMENT ON COLUMN f_inspeccion.controlf03.usuario_id IS 'Cédula del inspector';
COMMENT ON COLUMN f_inspeccion.controlf03.usuario IS 'Nombre del inspector';


CREATE TABLE f_inspeccion.controlf03_detalle_ordenes
(
  id                          SERIAL NOT NULL,
  id_padre                    INTEGER,
  id_tablet                   INTEGER,

  actividad_origen            CHARACTER VARYING(50),
  analisis                    CHARACTER VARYING(2048),
  codigo_muestra              CHARACTER VARYING(50),
  conservacion                CHARACTER VARYING(50),
  tipo_muestra                CHARACTER VARYING(50),
  descripcion_sintomas        CHARACTER VARYING(150),
  fase_fenologica             CHARACTER VARYING(50),
  nombre_producto             CHARACTER VARYING(50),
  peso_muestra                NUMERIC,
  prediagnostico              CHARACTER VARYING(150),
  tipo_cliente                CHARACTER VARYING(50),
  aplicacion_producto_quimico CHARACTER VARYING(16) DEFAULT 'N/A',
  CONSTRAINT controlf03_detalle_orden_pkey PRIMARY KEY (id),
  CONSTRAINT fk_controlf03_detalle_orden FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.controlf03 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);


/*

Pantalla de reporte en el GUIA

*/

INSERT INTO g_programas.aplicaciones (
  nombre,
  version,
  ruta,
  descripcion,
  color,
  codificacion_aplicacion,
  estado_aplicacion)
VALUES (
  'Generador de reportes',
  '1.0',
  'reportes',
  'Generador de reportes para áreas operativas',
  '#74acff',
  'PRG_REP',
  'activo');

INSERT INTO g_programas.opciones (
  id_aplicacion,
  nombre_opcion,
  pagina,
  orden)
VALUES (
  (SELECT a.id_aplicacion
   FROM g_programas.aplicaciones a
   WHERE a.codificacion_aplicacion = 'PRG_REP'),
  'Inspección de productos importados',
  'inspeccionProductosImportados',
  1);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'inspeccionProductosImportados'),
  'TODO',
  1,
  (SELECT a.id_aplicacion
   FROM g_programas.aplicaciones a
   WHERE a.codificacion_aplicacion = 'PRG_REP'));


INSERT INTO g_usuario.perfiles (
  nombre,
  estado,
  id_aplicacion,
  codificacion_perfil)
VALUES (
  'Reporteador Sanidad Vegetal',
  1,
  (SELECT a.id_aplicacion
   FROM g_programas.aplicaciones a
   WHERE a.codificacion_aplicacion = 'PRG_REP'),
  'CSV_REPOR_CONSU');

INSERT INTO g_programas.acciones_perfiles (
  id_perfil,
  id_accion)
VALUES ((SELECT p.id_perfil
         FROM g_usuario.perfiles p
         WHERE p.codificacion_perfil = 'CSV_REPOR_CONSU'
         LIMIT 1),
        (SELECT a.id_accion
         FROM g_programas.opciones o, g_programas.acciones a, g_programas.aplicaciones ap
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'inspeccionProductosImportados' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));

INSERT INTO g_usuario.usuarios_perfiles
VALUES ('1722551049', (SELECT p.id_perfil
                       FROM g_usuario.perfiles p
                       WHERE p.codificacion_perfil = 'CSV_REPOR_CONSU'));

INSERT INTO g_programas.aplicaciones_registradas (id_aplicacion, identificador, cantidad_notificacion, mensaje_notificacion)
VALUES ((SELECT a.id_aplicacion
         FROM g_programas.aplicaciones a
         WHERE a.codificacion_aplicacion = 'PRG_REP'), '1722551049', 0, 'notificaciones');

/*
FIN
*/





