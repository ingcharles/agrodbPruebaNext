/*
DE EDISON
=========

ALTER TABLE g_catalogos.tipo_productos
ADD COLUMN codificacion_tipo_producto character varying(16);

UPDATE g_catalogos.tipo_productos
SET codificacion_tipo_producto = 'PRD_FLO_FOLL_COR'
WHERE nombre = 'Flores y follajes cortados';

UPDATE g_catalogos.tipo_productos
SET codificacion_tipo_producto = 'PRD_FR_HO_TU_FRE'
WHERE nombre = 'Frutas, hortalizas y tubérculos frescos';
*/

/*

 Formulario de Cerficación

 ************************************************************
*/

CREATE TABLE f_inspeccion.certificacionf01
(
  id                   SERIAL NOT NULL,
  id_tablet            INTEGER,
  numero_reporte       CHARACTER VARYING(32),
  semana_evaluacion    CHARACTER VARYING(4),
  semana_cosecha       CHARACTER VARYING(4),
  ruc                  CHARACTER VARYING(13),
  razon_social         CHARACTER VARYING(256),
  id_predio            CHARACTER VARYING(64),
  nombre_predio        CHARACTER VARYING(256),
  direccion            CHARACTER VARYING(256),
  provincia            CHARACTER VARYING(64),
  canton               CHARACTER VARYING(64),
  parroquia            CHARACTER VARYING(64),
  identificacion_lote  CHARACTER VARYING(64),
  material_vegetal     CHARACTER VARYING(64),
  variedad             CHARACTER VARYING(64),
  numero_plantas       CHARACTER VARYING(64),
  superficie           CHARACTER VARYING(64),
  tamano_muestra       INTEGER,
  numero_grupos        INTEGER,
  tiempo_cosecha       INTEGER,
  limpieza_drenaje     CHARACTER VARYING(2),
  uso_cebos            CHARACTER VARYING(2),
  uso_trampas          CHARACTER VARYING(2),
  eliminacion_moluscos CHARACTER VARYING(2),
  aplicacion_jabon     CHARACTER VARYING(2),
  infraestructura      CHARACTER VARYING(16),
  grado                CHARACTER VARYING(16),
  personal             CHARACTER VARYING(16),
  trazabilidad_lote    TEXT,
  promedio_grupos      NUMERIC,
  decision_tomada      CHARACTER VARYING(64),
  grupos_afectados     CHARACTER VARYING(64),
  indice_presencia     NUMERIC,
  representante        CHARACTER VARYING(256),
  observaciones        TEXT,
  fecha_inspeccion     TIMESTAMP WITHOUT TIME ZONE,
  usuario_id           CHARACTER VARYING(13),
  usuario              CHARACTER VARYING(150),
  tablet_id            CHARACTER VARYING(20),
  tablet_version_base  CHARACTER VARYING(10),
  CONSTRAINT certificacionf01_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.certificacionf01 USING BTREE (provincia ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.certificacionf01 USING BTREE (canton ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.certificacionf01 USING BTREE (parroquia ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.certificacionf01 USING BTREE (fecha_inspeccion ASC NULLS LAST);


COMMENT ON COLUMN f_inspeccion.certificacionf01.numero_reporte IS 'Reporte';
COMMENT ON COLUMN f_inspeccion.certificacionf01.semana_evaluacion IS 'Semana de evaluación';
COMMENT ON COLUMN f_inspeccion.certificacionf01.semana_cosecha IS 'Semana de cosecha';
COMMENT ON COLUMN f_inspeccion.certificacionf01.ruc IS 'RUC';
COMMENT ON COLUMN f_inspeccion.certificacionf01.razon_social IS 'Razón Social';
COMMENT ON COLUMN f_inspeccion.certificacionf01.nombre_predio IS 'Predio';
COMMENT ON COLUMN f_inspeccion.certificacionf01.direccion IS 'Dirección';
COMMENT ON COLUMN f_inspeccion.certificacionf01.provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.certificacionf01.canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.certificacionf01.parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.certificacionf01.identificacion_lote IS '(Calificación Lote) 1. Identificación';
COMMENT ON COLUMN f_inspeccion.certificacionf01.material_vegetal IS '(Calificación Lote) 2. Material vegetal';
COMMENT ON COLUMN f_inspeccion.certificacionf01.variedad IS '(Calificación Lote) 3. Variedad';
COMMENT ON COLUMN f_inspeccion.certificacionf01.numero_plantas IS '(Calificación Lote) 4. Número de plantas';
COMMENT ON COLUMN f_inspeccion.certificacionf01.superficie IS '(Calificación Lote) 5. Superficie';
COMMENT ON COLUMN f_inspeccion.certificacionf01.tamano_muestra IS '(Calificación Lote) 6. Tamaño de la muestra (No. plantas)';
COMMENT ON COLUMN f_inspeccion.certificacionf01.numero_grupos IS '(Calificación Lote) 7. Número de grupos';
COMMENT ON COLUMN f_inspeccion.certificacionf01.tiempo_cosecha IS '(Calificación Lote) 8. Tiempo antes de cosecha(semanas)';
COMMENT ON COLUMN f_inspeccion.certificacionf01.limpieza_drenaje IS '(Inspección) Limpieza de drenajes dentro del cultivo';
COMMENT ON COLUMN f_inspeccion.certificacionf01.uso_cebos IS '(Inspección) Uso de cebos molusquicidas (Dosis/Ha)';
COMMENT ON COLUMN f_inspeccion.certificacionf01.uso_trampas IS '(Inspección) Uso de trampas y recolección de moluscos';
COMMENT ON COLUMN f_inspeccion.certificacionf01.eliminacion_moluscos IS '(Inspección) Eliminación de moluscos colectados (método)';
COMMENT ON COLUMN f_inspeccion.certificacionf01.aplicacion_jabon IS '(Inspección) Aplicación de jabón potásico en lotes por cosechar';
COMMENT ON COLUMN f_inspeccion.certificacionf01.infraestructura IS '(Instalaciones) Infraestructura y organización';
COMMENT ON COLUMN f_inspeccion.certificacionf01.grado IS '(Instalaciones) Grado de limpieza';
COMMENT ON COLUMN f_inspeccion.certificacionf01.personal IS '(Instalaciones) Personal con equipo adecuado';
COMMENT ON COLUMN f_inspeccion.certificacionf01.trazabilidad_lote IS 'Trazabilidad del lote';
COMMENT ON COLUMN f_inspeccion.certificacionf01.promedio_grupos IS 'Promedio de grupos';
COMMENT ON COLUMN f_inspeccion.certificacionf01.decision_tomada IS 'Desición tomada';
COMMENT ON COLUMN f_inspeccion.certificacionf01.grupos_afectados IS 'Grupos afectados';
COMMENT ON COLUMN f_inspeccion.certificacionf01.indice_presencia IS 'Indice de presencia';
COMMENT ON COLUMN f_inspeccion.certificacionf01.representante IS 'Representante del operador';
COMMENT ON COLUMN f_inspeccion.certificacionf01.observaciones IS 'Observaciones';
COMMENT ON COLUMN f_inspeccion.certificacionf01.fecha_inspeccion IS 'Fecha de inspección';
COMMENT ON COLUMN f_inspeccion.certificacionf01.usuario_id IS 'Cédula del inspector';
COMMENT ON COLUMN f_inspeccion.certificacionf01.usuario IS 'Inspector';

CREATE TABLE f_inspeccion.certificacionf01_detalle_grupos
(
  id               SERIAL NOT NULL,
  id_padre         INTEGER,
  id_tablet        INTEGER,
  grupo            INTEGER,
  numero_caracoles INTEGER,
  CONSTRAINT certificacionf01_detalle_grupos_pkey PRIMARY KEY (id),
  CONSTRAINT fk_certificacionf01_detalle_grupos FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.certificacionf01 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

COMMENT ON COLUMN f_inspeccion.certificacionf01_detalle_grupos.grupo IS 'Grupo';
COMMENT ON COLUMN f_inspeccion.certificacionf01_detalle_grupos.numero_caracoles IS 'Caracoles encontrados';

CREATE TABLE f_inspeccion.certificacionf01_detalle_ordenes
(
  id                          SERIAL NOT NULL,
  id_padre                    INTEGER,
  id_tablet                   INTEGER,
  actividad_origen            CHARACTER VARYING(64)  DEFAULT 'Certificación fitosanitaria',
  analisis                    TEXT,
  codigo_muestra              CHARACTER VARYING(64),
  conservacion                CHARACTER VARYING(64),
  tipo_muestra                CHARACTER VARYING(64),
  descripcion_sintomas        CHARACTER VARYING(256) DEFAULT 'N/A',
  fase_fenologica             CHARACTER VARYING(64)  DEFAULT 'N/A',
  nombre_producto             CHARACTER VARYING(64)  DEFAULT 'Exportación',
  peso_muestra                NUMERIC                DEFAULT 0,
  prediagnostico              CHARACTER VARYING(256) DEFAULT 'N/A',
  tipo_cliente                CHARACTER VARYING(64)  DEFAULT 'Interno',
  aplicacion_producto_quimico CHARACTER VARYING(64)  DEFAULT 'N/A',
  CONSTRAINT certificacionf01_detalle_ordenes_pkey PRIMARY KEY (id),
  CONSTRAINT fk_certificacionf01_detalle_ordenes FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.certificacionf01 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

/*
Reporte 14
Pantalla de REPORTE INSPECCION DE MOLUSCOS PLAGA EN FINCAS en el GUIA
#050 Trello
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
  'Reporte de inspección de piña en fincas',
  'reporteInspeccionMoluscosPlagaFincas',
  14);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteInspeccionMoluscosPlagaFincas'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteInspeccionMoluscosPlagaFincas' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/

CREATE TABLE f_inspeccion.certificacionf02
(
  id                                         SERIAL NOT NULL,
  id_tablet                                  INTEGER,
  numero_reporte                             CHARACTER VARYING(32),
  ruc_exportador                             CHARACTER VARYING(13),
  razon_social_exportador                    CHARACTER VARYING(256),
  ruc_acopiador                              CHARACTER VARYING(64),
  acopiador                                  CHARACTER VARYING(256),
  codigo_registro_pallet_rechazado           CHARACTER VARYING(32),
  ruc_empresa_tratamiento_pallet             CHARACTER VARYING(13),
  nombre_empresa_tratamiento_pallet          CHARACTER VARYING(256),
  numero_factura_guia_remision               CHARACTER VARYING(32),
  id_lugar_rechazo                           CHARACTER VARYING(64),
  lugar_rechazo                              CHARACTER VARYING(256),
  sellos_ilegibles                           CHARACTER VARYING(2),
  presencia_corteza                          CHARACTER VARYING(2),
  plagas                                     CHARACTER VARYING(2),
  registro_tratamiento                       CHARACTER VARYING(2),
  otros                                      CHARACTER VARYING(64),
  cantidad_embalajes_rechazados              NUMERIC,
  envio_muestra                              CHARACTER VARYING(2),
  nombre_interesado_representante_exportador CHARACTER VARYING(256),
  observaciones                              TEXT,
  fecha_inspeccion                           TIMESTAMP WITHOUT TIME ZONE,
  usuario_id                                 CHARACTER VARYING(64),
  usuario                                    CHARACTER VARYING(64),
  tablet_id                                  CHARACTER VARYING(64),
  tablet_version_base                        CHARACTER VARYING(64),
  CONSTRAINT certificacionf02_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.certificacionf02 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.certificacionf02.numero_reporte IS 'Número de reporte';
COMMENT ON COLUMN f_inspeccion.certificacionf02.ruc_exportador IS 'RUC exportador';
COMMENT ON COLUMN f_inspeccion.certificacionf02.razon_social_exportador IS 'Razón social';
COMMENT ON COLUMN f_inspeccion.certificacionf02.ruc_acopiador IS 'RUC acopiador';
COMMENT ON COLUMN f_inspeccion.certificacionf02.acopiador IS 'Acopiador';
COMMENT ON COLUMN f_inspeccion.certificacionf02.codigo_registro_pallet_rechazado IS 'Código del registro del pallet rechazado';
COMMENT ON COLUMN f_inspeccion.certificacionf02.ruc_empresa_tratamiento_pallet IS 'RUC de empresa de tratamiento';
COMMENT ON COLUMN f_inspeccion.certificacionf02.nombre_empresa_tratamiento_pallet IS 'Empresa de tratamiento';
COMMENT ON COLUMN f_inspeccion.certificacionf02.numero_factura_guia_remision IS 'Factura/Guía de remisión';
COMMENT ON COLUMN f_inspeccion.certificacionf02.lugar_rechazo IS 'Lugar de rechazo';
COMMENT ON COLUMN f_inspeccion.certificacionf02.sellos_ilegibles IS '(Motivo rechazo) Sellos ilegible';
COMMENT ON COLUMN f_inspeccion.certificacionf02.presencia_corteza IS '(Motivo rechazo) Presencia de corteza';
COMMENT ON COLUMN f_inspeccion.certificacionf02.plagas IS '(Motivo rechazo) Plagas';
COMMENT ON COLUMN f_inspeccion.certificacionf02.registro_tratamiento IS '(Motivo rechazo) Registro de tratamiento';
COMMENT ON COLUMN f_inspeccion.certificacionf02.otros IS '(Motivo rechazo) Otros';
COMMENT ON COLUMN f_inspeccion.certificacionf02.cantidad_embalajes_rechazados IS 'Cantidad de embalajes rechazados';
COMMENT ON COLUMN f_inspeccion.certificacionf02.nombre_interesado_representante_exportador IS 'Nombre del interesado/Representante del exportador';
COMMENT ON COLUMN f_inspeccion.certificacionf02.observaciones IS 'Observaciones';
COMMENT ON COLUMN f_inspeccion.certificacionf02.fecha_inspeccion IS 'Fecha de inspeccion';
COMMENT ON COLUMN f_inspeccion.certificacionf02.usuario IS 'Inspector';

CREATE TABLE f_inspeccion.certificacionf02_detalle_ordenes
(
  id                   SERIAL NOT NULL,
  id_padre             INTEGER,
  id_tablet            INTEGER,
  actividad_origen     CHARACTER VARYING(64)  DEFAULT 'Certificación fitosanitaria',
  analisis             TEXT,
  codigo_muestra       CHARACTER VARYING(64),
  conservacion         CHARACTER VARYING(64),
  tipo_muestra         CHARACTER VARYING(64),
  descripcion_sintomas CHARACTER VARYING(256) DEFAULT 'N/A',
  fase_fenologica      CHARACTER VARYING(64)  DEFAULT 'N/A',
  nombre_producto      CHARACTER VARYING(64)  DEFAULT 'Exportación',
  peso_muestra         NUMERIC                DEFAULT 0,
  prediagnostico       CHARACTER VARYING(256) DEFAULT 'N/A',
  tipo_cliente         CHARACTER VARYING(64)  DEFAULT 'Interno',
  CONSTRAINT certificacionf02_detalle_ordenes_pkey PRIMARY KEY (id),
  CONSTRAINT fk_certificacionf02_detalle_ordenes FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.certificacionf02 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

/*
Reporte 15
Pantalla de REPORTE RECHAZO EMBALAJES DE MADERA en el GUIA
#046 Trello
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
  'Reporte de rechazo en embalajes de madera',
  'reporteRechazoEmbalajesMadera',
  15);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteRechazoEmbalajesMadera'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteRechazoEmbalajesMadera' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/

--TODO: REVISAR QUE PASO CON EL CAMPO NUMERO DE REGISTRO
CREATE TABLE f_inspeccion.certificacionf03
(
  id                  SERIAL NOT NULL,
  id_tablet           INTEGER,
  numero_reporte      CHARACTER VARYING(256),
  razon_social        CHARACTER VARYING(256),
  id_provincia        CHARACTER VARYING(64),
  provincia           CHARACTER VARYING(256),
  id_canton           CHARACTER VARYING(64),
  canton              CHARACTER VARYING(256),
  id_parroquia        CHARACTER VARYING(64),
  parroquia           CHARACTER VARYING(256),
  cultivo             CHARACTER VARYING(256),
  pregunta1           CHARACTER VARYING(2),
  pregunta2           CHARACTER VARYING(2),
  pregunta3           CHARACTER VARYING(2),
  pregunta4           CHARACTER VARYING(2),
  pregunta5           CHARACTER VARYING(2),
  pregunta6           CHARACTER VARYING(2),
  pregunta7           CHARACTER VARYING(2),
  pregunta8           CHARACTER VARYING(2),
  pregunta9           CHARACTER VARYING(2),
  pregunta10          CHARACTER VARYING(2),
  pregunta11          CHARACTER VARYING(2),
  pregunta12          CHARACTER VARYING(2),
  pregunta13          CHARACTER VARYING(2),
  pregunta14          CHARACTER VARYING(2),
  pregunta15          CHARACTER VARYING(2),
  pregunta16          CHARACTER VARYING(2),
  pregunta17          CHARACTER VARYING(2),
  pregunta18          CHARACTER VARYING(2),
  pregunta19          CHARACTER VARYING(2),
  pregunta20          CHARACTER VARYING(2),
  pregunta21          CHARACTER VARYING(2),
  representante       CHARACTER VARYING(256),
  resultado           CHARACTER VARYING(256),
  observaciones       TEXT,
  fecha_inspeccion    TIMESTAMP WITHOUT TIME ZONE,
  usuario_id          CHARACTER VARYING(64),
  usuario             CHARACTER VARYING(64),
  tablet_id           CHARACTER VARYING(64),
  tablet_version_base CHARACTER VARYING(64),
  CONSTRAINT certificacionf03_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.certificacionf03 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.certificacionf03.numero_reporte IS 'Número de reporte';
COMMENT ON COLUMN f_inspeccion.certificacionf03.razon_social IS 'Razón social';
COMMENT ON COLUMN f_inspeccion.certificacionf03.id_provincia IS 'Código provincia';
COMMENT ON COLUMN f_inspeccion.certificacionf03.provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.certificacionf03.id_canton IS 'Código cantón';
COMMENT ON COLUMN f_inspeccion.certificacionf03.canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.certificacionf03.id_parroquia IS 'Código parroquia';
COMMENT ON COLUMN f_inspeccion.certificacionf03.parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.certificacionf03.cultivo IS 'Cultivo';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta1 IS '¿Tiene la finca procedimientos para identificar sitios de mayor presencia por escamas en la plantación?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta2 IS '¿Tiene la finca procedimientos para identificar sitios de mayor presencia por escamas en la plantación?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta3 IS '¿Las corbatas se aplican en el tiempo indicado?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta4 IS '¿Se realiza un deschante correcto?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta5 IS '¿Existe un control de malezas adecuado?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta6 IS '¿Está el personal de campo capacitado en manejo de escamas?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta7 IS '¿Se realiza la inspección visual del 100% de los racimos que entran en la empacadora?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta8 IS '¿Se identifican los racimos con escamas para aplicar el tratamiento?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta9 IS '¿Se eliminan los racimos con exceso de escamas?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta10 IS '¿Tiene la finca sistema de agua a presión para lavado de racimos?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta11 IS '¿Los racimos identificados con escamas son desmanados en otra división?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta12 IS '¿Está capacitado el personal de empaque en manejo de escamas?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta13 IS '¿Se realiza limpieza de gajos con la plaga?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta14 IS '¿Se realiza inspección del 10% de la fruta en rodillos?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta15 IS '¿Maneja técnicamente la aplicación de plaguicidas y equipos apropiados?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta16 IS '¿Cuenta la finca con un plan de contingencia para cochinillas y demuestra la aplicación cuando es necesario?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta17 IS '¿Se realiza inspección del 5% de la fruta embalada?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta18 IS '¿Demuestra la finca que tiene un programa de capacitación formal?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta19 IS '¿Presentan registros de reclamos por escamas, tanto de clientes como de organismos oficiales?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta20 IS '¿Cuenta la finca con un formulario de monitoreo de la plaga?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.pregunta21 IS '¿Se realiza una limpieza adecuada a los protectores cuello de monja?';
COMMENT ON COLUMN f_inspeccion.certificacionf03.observaciones IS 'Obervaciones';
COMMENT ON COLUMN f_inspeccion.certificacionf03.resultado IS 'Resultado';
COMMENT ON COLUMN f_inspeccion.certificacionf03.representante IS 'Representante del operador';
COMMENT ON COLUMN f_inspeccion.certificacionf03.fecha_inspeccion IS 'Fecha de inspección';
COMMENT ON COLUMN f_inspeccion.certificacionf03.usuario_id IS 'Cédula del inspector';
COMMENT ON COLUMN f_inspeccion.certificacionf03.usuario IS 'Inspector';

/*
Reporte 12
Pantalla de REPORTE BANANO PROTOCOLO ESCAMAS en el GUIA
#050 Trello
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
  'Reporte de banano protocolo de escamas',
  'reporteBananoProtocoloEscamas',
  12);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteBananoProtocoloEscamas'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteBananoProtocoloEscamas' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/


CREATE TABLE f_inspeccion.certificacionf04
(
  id                     SERIAL NOT NULL,
  id_tablet              INTEGER,
  numero_reporte         CHARACTER VARYING(256),
  ruc_operador           CHARACTER VARYING(13),
  nombre_operador        CHARACTER VARYING(256),
  id_sitio_acopiador     CHARACTER VARYING(64),
  sitio_acopiador        CHARACTER VARYING(256),
  provincia              CHARACTER VARYING(256),
  canton                 CHARACTER VARYING(256),
  parroquia              CHARACTER VARYING(256),
  pregunta1              CHARACTER VARYING(4),
  pregunta2              CHARACTER VARYING(4),
  pregunta3              CHARACTER VARYING(4),
  pregunta4              CHARACTER VARYING(4),
  ingrediente_activo     CHARACTER VARYING(256),
  marca_comercial        CHARACTER VARYING(256),
  formulacion            CHARACTER VARYING(256),
  registro_agrocalidad   CHARACTER VARYING(256),
  fecha_caducidad        TIMESTAMP WITHOUT TIME ZONE,
  fecha_preparacion      TIMESTAMP WITHOUT TIME ZONE,
  fecha_validez          TIMESTAMP WITHOUT TIME ZONE,
  pregunta5              CHARACTER VARYING(4),
  pregunta6              CHARACTER VARYING(4),
  pregunta7              CHARACTER VARYING(4),
  pregunta8              CHARACTER VARYING(4),
  pregunta9              CHARACTER VARYING(4),
  pregunta10             CHARACTER VARYING(4),
  pregunta11             CHARACTER VARYING(4),
  pregunta12             CHARACTER VARYING(4),
  pregunta13             CHARACTER VARYING(4),
  pregunta14             CHARACTER VARYING(4),
  pregunta15             CHARACTER VARYING(4),
  pregunta16             CHARACTER VARYING(4),
  observaciones          TEXT,
  dictamen_final         CHARACTER VARYING(32),
  representante_operador CHARACTER VARYING(256),
  usuario                CHARACTER VARYING(256),
  usuario_id             CHARACTER VARYING(64),
  fecha_inspeccion       TIMESTAMP WITHOUT TIME ZONE,
  tablet_id              CHARACTER VARYING(64),
  tablet_version_base    CHARACTER VARYING(64),
  CONSTRAINT certificacionf04_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.certificacionf04 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.certificacionf04.numero_reporte IS 'Número de reporte';
COMMENT ON COLUMN f_inspeccion.certificacionf04.ruc_operador IS 'RUC';
COMMENT ON COLUMN f_inspeccion.certificacionf04.nombre_operador IS 'Operador';
COMMENT ON COLUMN f_inspeccion.certificacionf04.sitio_acopiador IS 'Sitio de acopio';
COMMENT ON COLUMN f_inspeccion.certificacionf04.provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.certificacionf04.canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.certificacionf04.parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta1 IS 'Tiene la finca un espacio físico adecuado para realizar el tratamiento: lugar exclusivo para el proceso, con buena ventilación; paredes, pisos y drenajes en buenas condiciones, limpios y ordenados.';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta2 IS 'Dispone de los materiales y equipos para realizar el tratamiento, marcados de uso exclusivo para desvitalización: mesa, reloj/cronómetro, probetas, tachos, gavetas.';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta3 IS 'El personal que realiza el tratamiento de desvitalización está capacitado y conoce el procedimiento.';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta4 IS 'El personal que realiza el tratamiento dispone del equipo de protección adecuado: botas, delantal plástico, guantes de látex, mascarillas, gafas.';
COMMENT ON COLUMN f_inspeccion.certificacionf04.ingrediente_activo IS 'Ingrediente activo utilizado';
COMMENT ON COLUMN f_inspeccion.certificacionf04.marca_comercial IS 'Marca comercial';
COMMENT ON COLUMN f_inspeccion.certificacionf04.formulacion IS 'Formulación';
COMMENT ON COLUMN f_inspeccion.certificacionf04.registro_agrocalidad IS 'Registro AGROCALIDAD';
COMMENT ON COLUMN f_inspeccion.certificacionf04.fecha_caducidad IS 'Fecha de caducidad';
COMMENT ON COLUMN f_inspeccion.certificacionf04.fecha_preparacion IS 'Fecha de preparación';
COMMENT ON COLUMN f_inspeccion.certificacionf04.fecha_validez IS 'Fecha de validez';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta5 IS 'La solución es nueva?';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta6 IS 'La solución es de hace 7 días :';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta7 IS 'La solución esta limpia';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta8 IS 'Profundidad  35 cm:';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta9 IS 'Tiempo de inmersión 20 min:';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta10 IS 'Los recipientes en los que realiza la desvitalización de los productos ornamentales se encuentran marcados a los 35cm.';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta11 IS 'Se lleva un registro ordenado y actualizado de la preparación de la solución para la desvitalización.';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta12 IS 'La poscosecha cuenta con un sistema de distinción para los ramos desvitalizados.';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta13 IS 'Se realiza un manejo adecuado de residuos del glifosato luego de su utilización para el tratamiento.';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta14 IS 'Se realiza la implementación del ensayo de enraizamiento, con supervisión de AGROCALIDAD.';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta15 IS 'La finca lleva un buen registro y toma de datos del ensayo.';
COMMENT ON COLUMN f_inspeccion.certificacionf04.pregunta16 IS 'Los resultados del ensayo de enraizamiento se encuentran dentro del rango establecido como aceptable según  el protocolo (1%).';
COMMENT ON COLUMN f_inspeccion.certificacionf04.observaciones IS 'Observaciones';
COMMENT ON COLUMN f_inspeccion.certificacionf04.dictamen_final IS 'Dictamen final';
COMMENT ON COLUMN f_inspeccion.certificacionf04.representante_operador IS 'Representante de operador';
COMMENT ON COLUMN f_inspeccion.certificacionf04.usuario IS 'Inspector';
COMMENT ON COLUMN f_inspeccion.certificacionf04.usuario_id IS 'Cédula de inspector';
COMMENT ON COLUMN f_inspeccion.certificacionf04.fecha_inspeccion IS 'Fecha de inspección';

CREATE TABLE f_inspeccion.certificacionf04_detalle_productos
(
  id                     SERIAL NOT NULL,
  id_padre               INTEGER,
  id_tablet              INTEGER,
  producto               CHARACTER VARYING(256),
  cantidad_tallos        NUMERIC,
  cantidad_inspeccionada NUMERIC,
  concentracion          CHARACTER VARYING(256),
  dosificacion           CHARACTER VARYING(256),
  volumen_solucion       CHARACTER VARYING(256),
  numero_recipientes     NUMERIC,
  volumen_total          CHARACTER VARYING(256),
  CONSTRAINT certificacionf04_detalle_productos_pkey PRIMARY KEY (id),
  CONSTRAINT fk_certificacionf04_detalle_productos FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.certificacionf04 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

COMMENT ON COLUMN f_inspeccion.certificacionf04_detalle_productos.producto IS 'Producto a desvitalizar';
COMMENT ON COLUMN f_inspeccion.certificacionf04_detalle_productos.cantidad_tallos IS 'Cantidad de tallos';
COMMENT ON COLUMN f_inspeccion.certificacionf04_detalle_productos.cantidad_inspeccionada IS 'Cantidad inspeccionada';
COMMENT ON COLUMN f_inspeccion.certificacionf04_detalle_productos.concentracion IS 'Concentración';
COMMENT ON COLUMN f_inspeccion.certificacionf04_detalle_productos.dosificacion IS 'Dosificación';
COMMENT ON COLUMN f_inspeccion.certificacionf04_detalle_productos.volumen_solucion IS 'Volumen de solución';
COMMENT ON COLUMN f_inspeccion.certificacionf04_detalle_productos.numero_recipientes IS 'Número de recipientes';
COMMENT ON COLUMN f_inspeccion.certificacionf04_detalle_productos.volumen_total IS 'Volumen Total';

/*
Reporte 20
Pantalla de REPORTE BANANO PROTOCOLO ESCAMAS en el GUIA
#050 Trello
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
  'Reporte de  protocolo de desvitalizacion',
  'reporteProtocoloDesvitalizacion',
  20);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteProtocoloDesvitalizacion'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteProtocoloDesvitalizacion' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/













CREATE TABLE f_inspeccion.certificacionf05
(
  id                  SERIAL NOT NULL,
  id_tablet           INTEGER,
  numero_reporte      CHARACTER VARYING(256),
  ruc                 CHARACTER VARYING(13),
  razon_social        CHARACTER VARYING(256),
  provincia           CHARACTER VARYING(256),
  canton              CHARACTER VARYING(256),
  parroquia           CHARACTER VARYING(256),
  id_sitio_produccion CHARACTER VARYING(64),
  sitio_produccion    CHARACTER VARYING(256),
  pregunta1           CHARACTER VARYING(2),
  pregunta2           CHARACTER VARYING(2),
  pregunta3           CHARACTER VARYING(2),
  pregunta4           CHARACTER VARYING(2),
  pregunta5           CHARACTER VARYING(2),
  pregunta6           CHARACTER VARYING(2),
  pregunta7           CHARACTER VARYING(2),
  pregunta8           CHARACTER VARYING(2),
  pregunta9           CHARACTER VARYING(2),
  pregunta10          CHARACTER VARYING(2),
  pregunta11          CHARACTER VARYING(2),
  pregunta12          CHARACTER VARYING(2),
  pregunta13          CHARACTER VARYING(2),
  pregunta14          CHARACTER VARYING(4),
  pregunta15          CHARACTER VARYING(4),
  representante       CHARACTER VARYING(256),
  resultado           CHARACTER VARYING(256),
  observaciones       TEXT,
  fecha_inspeccion    TIMESTAMP WITHOUT TIME ZONE,
  usuario_id          CHARACTER VARYING(64),
  usuario             CHARACTER VARYING(64),
  tablet_id           CHARACTER VARYING(64),
  tablet_version_base CHARACTER VARYING(64),
  CONSTRAINT certificacionf05_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.certificacionf05 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.certificacionf05.numero_reporte IS 'Número de reporte';
COMMENT ON COLUMN f_inspeccion.certificacionf05.ruc IS 'RUC';
COMMENT ON COLUMN f_inspeccion.certificacionf05.razon_social IS 'Razón social';
COMMENT ON COLUMN f_inspeccion.certificacionf05.provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.certificacionf05.canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.certificacionf05.parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.certificacionf05.sitio_produccion IS 'Sitio de inspección';
COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta1 IS 'Tiene la finca procedimientos para identificar sitios con presencia de Roya Blanca (RB) en la plantación : Señalización por nivel de incidencia o síntomas sospechosos';
COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta2 IS 'Presenta registros diarios de monitoreos visual en cada área?';
COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta3 IS 'En registros de monitoreo directo NO presentan identificación de síntomas y signos de RB';
COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta4 IS 'Aplican procedimientos para la desinfección de vehículos y personas al ingreso a la finca';
COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta5 IS 'Aplican procedimientos para la desinfección de personas al ingreso a cada invernadero';
COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta6 IS 'Revisa y registra diariamente en poscosecha el 10% de ramos presentes al momento de la inspección buscando Roya Blanca?';
COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta7 IS 'Revisa y registra diariamente en poscosecha (visual) el 100% de la flor buscando síntomas y signos de RB?';
COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta8 IS 'El monitoreador conoce el procedimiento y lo ejecuta adecuadamente?';
COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta9 IS 'Presenta registros (formatos) adecuados para monitoreo indirecto y directo desde hace 6 meses ?';
COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta10 IS 'Maneja técnicamente la aplicación de plaguicidas y con el uso de equipos apropiados';
COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta11 IS 'Cuenta la finca con un plan de contingencia para RB  y demuestra la aplicación cuando es necesario ?';
COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta12 IS 'Demuestra la finca que tiene un programa de capacitación formal ?';
COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta13 IS 'Ausencia registros de reclamos, tanto de clientes como de organismos oficiales?'; -- Cambiado por segunda vvez
COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta14 IS '(Implementación de Bioensayo) Presenta registros diarios de monitoreos visual al bioensayo?';
COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta15 IS '(Implementación de Bioensayo) Se toma muestras de hojas sintomáticas o asintomáticas para realizar analisis de Laboratorio';
COMMENT ON COLUMN f_inspeccion.certificacionf05.observaciones IS 'Obervaciones';
COMMENT ON COLUMN f_inspeccion.certificacionf05.representante IS 'Representante del operador';
COMMENT ON COLUMN f_inspeccion.certificacionf05.resultado IS 'Resultado';
COMMENT ON COLUMN f_inspeccion.certificacionf05.fecha_inspeccion IS 'Fecha de inspección';
COMMENT ON COLUMN f_inspeccion.certificacionf05.usuario_id IS 'Cédula del inspector';
COMMENT ON COLUMN f_inspeccion.certificacionf05.usuario IS 'Inspector';

/*
Reporte 13
Pantalla de REPORTE DE ORNAMENTALES PROTOCOLO ROYA BLANCA en el GUIA
#050 Trello
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
  'Reporte de ornamentales Protocolo Roya Blanca',
  'reporteOrnamentalesProtocoloRoyaBlanca',
  13);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteOrnamentalesProtocoloRoyaBlanca'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteOrnamentalesProtocoloRoyaBlanca' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/


CREATE TABLE f_inspeccion.certificacionf06
(
  id                  SERIAL NOT NULL,
  id_tablet           INTEGER,
  numero_reporte      CHARACTER VARYING(256),
  razon_social        CHARACTER VARYING(256),
  id_provincia        CHARACTER VARYING(64),
  provincia           CHARACTER VARYING(256),
  id_canton           CHARACTER VARYING(64),
  canton              CHARACTER VARYING(256),
  id_parroquia        CHARACTER VARYING(64),
  parroquia           CHARACTER VARYING(256),
  cultivo             CHARACTER VARYING(256),
  pregunta1           CHARACTER VARYING(2),
  pregunta2           CHARACTER VARYING(2),
  pregunta3           CHARACTER VARYING(2),
  pregunta4           CHARACTER VARYING(2),
  pregunta5           CHARACTER VARYING(2),
  pregunta6           CHARACTER VARYING(2),
  pregunta7           CHARACTER VARYING(2),
  pregunta8           CHARACTER VARYING(2),
  pregunta9           CHARACTER VARYING(2),
  pregunta10          CHARACTER VARYING(2),
  pregunta11          CHARACTER VARYING(2),
  pregunta12          CHARACTER VARYING(2),
  pregunta13          CHARACTER VARYING(2),
  pregunta14          CHARACTER VARYING(2),
  pregunta15          CHARACTER VARYING(2),
  pregunta16          CHARACTER VARYING(2),
  pregunta17          CHARACTER VARYING(2),
  pregunta18          CHARACTER VARYING(2),
  pregunta19          CHARACTER VARYING(2),
  pregunta20          CHARACTER VARYING(2),
  pregunta21          CHARACTER VARYING(2),
  representante       CHARACTER VARYING(256),
  resultado           CHARACTER VARYING(256),
  observaciones       TEXT,
  fecha_inspeccion    TIMESTAMP WITHOUT TIME ZONE,
  usuario_id          CHARACTER VARYING(64),
  usuario             CHARACTER VARYING(64),
  tablet_id           CHARACTER VARYING(64),
  tablet_version_base CHARACTER VARYING(64),
  CONSTRAINT certificacionf06_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.certificacionf06 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.certificacionf06.numero_reporte IS 'Número de reporte';
COMMENT ON COLUMN f_inspeccion.certificacionf06.razon_social IS 'Razón social';
COMMENT ON COLUMN f_inspeccion.certificacionf06.id_provincia IS 'Código provincia';
COMMENT ON COLUMN f_inspeccion.certificacionf06.provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.certificacionf06.id_canton IS 'Código cantón';
COMMENT ON COLUMN f_inspeccion.certificacionf06.canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.certificacionf06.id_parroquia IS 'Código parroquia';
COMMENT ON COLUMN f_inspeccion.certificacionf06.parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.certificacionf06.cultivo IS 'Cultivo';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta1 IS '¿Tiene la finca procedimientos para identificar sitios de mayor presencia por cochinillas en la plantación?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta2 IS '¿Se aplican las recomendaciones de corbatas con clorpirifos?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta3 IS '¿Las corbatas se aplican en el tiempo indicado?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta4 IS '¿Se realiza un deschante correcto?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta5 IS '¿Existe un control de malezas adecuado?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta6 IS '¿Está el personal de campo capacitado en manejo de cochinillas?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta7 IS '¿Se realiza la inspección visual del 100% de los racimos que entran en la empacadora?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta8 IS '¿Se identifican los racimos con cochinillas para aplicar el tratamiento?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta9 IS '¿Se eliminan los racimos con exceso de cochinillas?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta10 IS '¿Tiene la finca sistema de agua a presión para lavado de racimos?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta11 IS '¿Los racimos identificados con cochinillas son desmanados en otra división?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta12 IS '¿Está capacitado el personal de empaque en manejo de cochinillas?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta13 IS '¿Se realiza limpieza de gajos con la plaga?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta14 IS '¿Se realiza inspección del 10% de la fruta en rodillos?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta15 IS '¿Maneja técnicamente la aplicación de plaguicidas y equipos apropiados?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta16 IS '¿Cuenta la finca con un plan de contingencia para cochinillas y demuestra la aplicación cuando es necesario?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta17 IS '¿Se realiza inspección del 5% de la fruta embalada?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta18 IS '¿Demuestra la finca que tiene un programa de capacitación formal?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta19 IS '¿Presentan registros de reclamos por cochinillas, tanto de clientes como de organismos oficiales?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta20 IS '¿Cuenta la finca con un formulario de monitoreo de la plaga?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta21 IS '¿Se realiza una limpieza adecuada a los protectores cuello de monja?';
COMMENT ON COLUMN f_inspeccion.certificacionf06.observaciones IS 'Obervaciones';
COMMENT ON COLUMN f_inspeccion.certificacionf06.representante IS 'Representante del operador';
COMMENT ON COLUMN f_inspeccion.certificacionf06.resultado IS 'Resultado';
COMMENT ON COLUMN f_inspeccion.certificacionf06.fecha_inspeccion IS 'Fecha de inspección';
COMMENT ON COLUMN f_inspeccion.certificacionf06.usuario_id IS 'Cédula del inspector';
COMMENT ON COLUMN f_inspeccion.certificacionf06.usuario IS 'Inspector';

/*
Reporte 16
Pantalla de REPORTE DE ESPECIMENTES CAPTURADOS VIGILANCIA en el GUIA
#042 Trello
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
  'Reporte de Chequeo protocolo de envios libres de cochinillas',
  'reporteChequeoProtocoloEnvioLibreCochinillas',
  16);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteChequeoProtocoloEnvioLibreCochinillas'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteChequeoProtocoloEnvioLibreCochinillas' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/

CREATE TABLE f_inspeccion.certificacionf07
(
  id                  SERIAL NOT NULL,
  id_tablet           INTEGER,
  numero_reporte      CHARACTER VARYING(256),
  ruc                 CHARACTER VARYING(13),
  razon_social        CHARACTER VARYING(256),
  provincia           CHARACTER VARYING(256),
  canton              CHARACTER VARYING(256),
  parroquia           CHARACTER VARYING(256),
  id_sitio_produccion CHARACTER VARYING(64),
  sitio_produccion    CHARACTER VARYING(256),
  pregunta1           CHARACTER VARYING(2),
  pregunta2           CHARACTER VARYING(2),
  pregunta3           CHARACTER VARYING(2),
  pregunta4           CHARACTER VARYING(2),
  pregunta5           CHARACTER VARYING(2),
  pregunta6           CHARACTER VARYING(2),
  pregunta7           CHARACTER VARYING(2),
  pregunta8           CHARACTER VARYING(2),
  pregunta9           CHARACTER VARYING(2),
  pregunta10          CHARACTER VARYING(2),
  pregunta11          CHARACTER VARYING(2),
  representante       CHARACTER VARYING(256),
  resultado           CHARACTER VARYING(256),
  observaciones       TEXT,
  fecha_inspeccion    TIMESTAMP WITHOUT TIME ZONE,
  usuario_id          CHARACTER VARYING(64),
  usuario             CHARACTER VARYING(64),
  tablet_id           CHARACTER VARYING(64),
  tablet_version_base CHARACTER VARYING(64),
  CONSTRAINT certificacionf07_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.certificacionf07 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.certificacionf07.numero_reporte IS 'Número de reporte';
COMMENT ON COLUMN f_inspeccion.certificacionf07.ruc IS 'RUC';
COMMENT ON COLUMN f_inspeccion.certificacionf07.razon_social IS 'Razón social';
COMMENT ON COLUMN f_inspeccion.certificacionf07.provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.certificacionf07.canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.certificacionf07.parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.certificacionf07.sitio_produccion IS 'Sitio de producción';
COMMENT ON COLUMN f_inspeccion.certificacionf07.pregunta1 IS '¿Tiene la finca procedimientos para identificar sitios de mayor afectación por ácaros en cultivo y planos de monitoreo?';
COMMENT ON COLUMN f_inspeccion.certificacionf07.pregunta2 IS '¿En registros de monitoreo directo presenta  0% incidencia en tercio superior o zonas de producción?';
COMMENT ON COLUMN f_inspeccion.certificacionf07.pregunta3 IS '¿Revisa y registra diariamente en recepción de poscosecha la presencia de ácaros?';
COMMENT ON COLUMN f_inspeccion.certificacionf07.pregunta4 IS '¿Revisa y registra diariamente en poscosecha (visual) el 100% de la flor presencia de ácaros?';
COMMENT ON COLUMN f_inspeccion.certificacionf07.pregunta5 IS '¿El monitoreador conoce el procedimiento y lo ejecuta adecuadamente?';
COMMENT ON COLUMN f_inspeccion.certificacionf07.pregunta6 IS '¿Presenta registros (formatos) adecuados para monitoreo directo desde hace 2 meses?';
COMMENT ON COLUMN f_inspeccion.certificacionf07.pregunta7 IS '¿Maneja técnicamente la aplicación de plaguicidas y con el uso de equipos apropiados';
COMMENT ON COLUMN f_inspeccion.certificacionf07.pregunta8 IS '¿Cuenta la finca con un plan de contingencia para ácaros?';
COMMENT ON COLUMN f_inspeccion.certificacionf07.pregunta9 IS '¿Demuestra la finca que tiene un programa de capacitación formal?';
COMMENT ON COLUMN f_inspeccion.certificacionf07.pregunta10 IS '¿Presentan registros de reclamos por ácaros, tanto de clientes como de organismos oficiales?';
COMMENT ON COLUMN f_inspeccion.certificacionf07.pregunta11 IS '¿Control de hospederos secundarios en sitios periféricos de la finca?';
COMMENT ON COLUMN f_inspeccion.certificacionf07.observaciones IS 'Obervaciones';
COMMENT ON COLUMN f_inspeccion.certificacionf07.representante IS 'Representante del operador';
COMMENT ON COLUMN f_inspeccion.certificacionf07.resultado IS 'Resultado';
COMMENT ON COLUMN f_inspeccion.certificacionf07.fecha_inspeccion IS 'Fecha de inspección';
COMMENT ON COLUMN f_inspeccion.certificacionf07.usuario_id IS 'Cédula del inspector';
COMMENT ON COLUMN f_inspeccion.certificacionf07.usuario IS 'Inspector';

/*
Reporte 17
Pantalla de REPORTE DE ESPECIMENTES CAPTURADOS VIGILANCIA en el GUIA
#042 Trello
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
  'Reporte Protocolo de Ácaros',
  'reporteProtocoloAcaros',
  17);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteProtocoloAcaros'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteProtocoloAcaros' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/

CREATE TABLE f_inspeccion.certificacionf08
(
  id                  SERIAL NOT NULL,
  id_tablet           INTEGER,
  numero_reporte      CHARACTER VARYING(256),
  ruc                 CHARACTER VARYING(13),
  razon_social        CHARACTER VARYING(256),
  provincia           CHARACTER VARYING(256),
  canton              CHARACTER VARYING(256),
  parroquia           CHARACTER VARYING(256),
  id_sitio_produccion CHARACTER VARYING(64),
  sitio_produccion    CHARACTER VARYING(256),
  pregunta1           CHARACTER VARYING(2),
  pregunta2           CHARACTER VARYING(2),
  pregunta3           CHARACTER VARYING(2),
  pregunta4           CHARACTER VARYING(2),
  pregunta5           CHARACTER VARYING(2),
  pregunta6           CHARACTER VARYING(2),
  pregunta7           CHARACTER VARYING(2),
  pregunta8           CHARACTER VARYING(2),
  pregunta9           CHARACTER VARYING(2),
  pregunta10          CHARACTER VARYING(2),
  pregunta11          CHARACTER VARYING(2),
  pregunta12          CHARACTER VARYING(2),
  pregunta13          CHARACTER VARYING(2),
  pregunta14          CHARACTER VARYING(2),
  pregunta15          CHARACTER VARYING(2),
  pregunta16          CHARACTER VARYING(2),
  pregunta17          CHARACTER VARYING(2),
  pregunta18          CHARACTER VARYING(2),
  pregunta19          CHARACTER VARYING(2),
  representante       CHARACTER VARYING(256),
  resultado           CHARACTER VARYING(256),
  observaciones       TEXT,
  fecha_inspeccion    TIMESTAMP WITHOUT TIME ZONE,
  usuario_id          CHARACTER VARYING(64),
  usuario             CHARACTER VARYING(64),
  tablet_id           CHARACTER VARYING(64),
  tablet_version_base CHARACTER VARYING(64),
  CONSTRAINT certificacionf08_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.certificacionf08 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.certificacionf08.numero_reporte IS 'Número de reporte';
COMMENT ON COLUMN f_inspeccion.certificacionf08.ruc IS 'RUC';
COMMENT ON COLUMN f_inspeccion.certificacionf08.razon_social IS 'Razón social';
COMMENT ON COLUMN f_inspeccion.certificacionf08.provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.certificacionf08.canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.certificacionf08.parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.certificacionf08.sitio_produccion IS 'Sitio de inspección'; -- cambiado por segunda vez
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta1 IS 'Presenta  registros de monitoreo directo del 100% del cultivo  por tercios  y por estadios del minador';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta2 IS 'Posee trampas (placas) adecuadas de monitoreo indirecto?';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta3 IS 'Las trampas (placas) estan colocadas a la altura de los botones florales o punto de crecimiento?';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta4 IS 'Estan las trampas (placas) distribuidas aleatoriamente?';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta5 IS 'Existen trampas (placas) en todos los sitios de producción?';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta6 IS 'Presenta registros semanales de lectura de placas  en todos los sitios de producción.';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta7 IS 'Se lavan las trampas (placas) al menos 1 vez por semana ?';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta8 IS 'Tienen las trampas (placas) al momento de la visita pegante?';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta9 IS 'En registros de monitoreo indirecto presenta un promedio de 3 minador adulto / placa / bloque / finca';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta10 IS 'Presenta registros diarios de minador de las aspiradoras';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta11 IS 'Presenta promedio de aspiradora  2 adultos /cama';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta12 IS 'Los monitoriadores conocen  el procedimiento  y lo ejecuta adecuadamente';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta13 IS 'Presenta registros de monitoreos del 100%  de los ramos  procesados en post cosecha  y % de daño por minador';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta14 IS 'Presenta barreras fisicas de control de minador';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta15 IS 'Cuenta la finca con un plan de contingencia para minador y demuestra la aplicación cuando es necesario?';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta16 IS 'Posee la finca  proceso de trazabilidad inverso?';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta17 IS 'Demuestra la finca que tiene un programa de capacitación formal?';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta18 IS 'Ausencia de registros de reclamos tanto de cientes como organismos oficiales?';
COMMENT ON COLUMN f_inspeccion.certificacionf08.pregunta19 IS 'Control de hospederos secundarios en sitios periféricos de la finca';
COMMENT ON COLUMN f_inspeccion.certificacionf08.observaciones IS 'Obervaciones';
COMMENT ON COLUMN f_inspeccion.certificacionf08.representante IS 'Representante del operador';
COMMENT ON COLUMN f_inspeccion.certificacionf08.resultado IS 'Resultado';
COMMENT ON COLUMN f_inspeccion.certificacionf08.fecha_inspeccion IS 'Fecha de inspección';
COMMENT ON COLUMN f_inspeccion.certificacionf08.usuario_id IS 'Cédula del inspector';
COMMENT ON COLUMN f_inspeccion.certificacionf08.usuario IS 'Inspector';

/*
Reporte 17
Pantalla de REPORTE DE ESPECIMENTES CAPTURADOS VIGILANCIA en el GUIA
#042 Trello
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
  'Reporte Protocolo Minador',
  'reporteOrnamentalesProtocoloMinador',
  18);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteOrnamentalesProtocoloMinador'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteOrnamentalesProtocoloMinador' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/


/*
FIN
*/

CREATE TABLE f_inspeccion.certificacionf09
(
  id                  SERIAL NOT NULL,
  id_tablet           INTEGER,
  numero_reporte      CHARACTER VARYING(256),
  ruc                 CHARACTER VARYING(13),
  razon_social        CHARACTER VARYING(256),
  provincia           CHARACTER VARYING(256),
  canton              CHARACTER VARYING(256),
  parroquia           CHARACTER VARYING(256),
  id_sitio_produccion CHARACTER VARYING(64),
  sitio_produccion    CHARACTER VARYING(256),
  pregunta1           CHARACTER VARYING(2),
  pregunta2           CHARACTER VARYING(2),
  pregunta3           CHARACTER VARYING(2),
  pregunta4           CHARACTER VARYING(2),
  pregunta5           CHARACTER VARYING(2),
  pregunta6           CHARACTER VARYING(2),
  pregunta7           CHARACTER VARYING(2),
  pregunta8           CHARACTER VARYING(2),
  pregunta9           CHARACTER VARYING(2),
  pregunta10          CHARACTER VARYING(2),
  pregunta11          CHARACTER VARYING(2),
  pregunta12          CHARACTER VARYING(2),
  pregunta13          CHARACTER VARYING(2),
  pregunta14          CHARACTER VARYING(2),
  pregunta15          CHARACTER VARYING(2),
  pregunta16          CHARACTER VARYING(2),
  pregunta17          CHARACTER VARYING(2),
  pregunta18          CHARACTER VARYING(2),
  pregunta19          CHARACTER VARYING(2),
  pregunta20          CHARACTER VARYING(2),
  representante       CHARACTER VARYING(256),
  resultado           CHARACTER VARYING(256),
  observaciones       TEXT,
  fecha_inspeccion    TIMESTAMP WITHOUT TIME ZONE,
  usuario_id          CHARACTER VARYING(64),
  usuario             CHARACTER VARYING(64),
  tablet_id           CHARACTER VARYING(64),
  tablet_version_base CHARACTER VARYING(64),
  CONSTRAINT certificacionf09_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.certificacionf09 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.certificacionf09.numero_reporte IS 'Número de reporte';
COMMENT ON COLUMN f_inspeccion.certificacionf09.ruc IS 'RUC';
COMMENT ON COLUMN f_inspeccion.certificacionf09.razon_social IS 'Razón social';
COMMENT ON COLUMN f_inspeccion.certificacionf09.provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.certificacionf09.canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.certificacionf09.parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.certificacionf09.sitio_produccion IS 'Sitio de inspección'; -- cambiado por segunda vez
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta1 IS 'Tiene la finca procedimientos para identificar sitios de mayor afectación por trips en la plantación?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta2 IS 'Posee trampas (placas) adecuadas de monitoreo indirecto?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta3 IS 'Las trampas (placas) estan colocadas a la altura de los botones florales o punto de crecimiento?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta4 IS 'Estan las trampas (placas) distribuidas aleatoriamente ?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta5 IS 'Existen trampas (placas) en todos los sitios de producción?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta6 IS 'Tiene la finca al menos una placa cada 1000 m2?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta7 IS 'Se lavan las trampas (placas) al menos 1 vez por semana  ?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta8 IS 'Tienen las trampas (placas) al momento de la visita pegante?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta9 IS 'En registros de monitoreo indirecto presenta un promedio de 3 trips / placa / bloque / finca';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta10 IS 'Revisa y registra diariamente en poscosecha el 5% de tallos presentes al momento de la inspección buscando trips?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta11 IS 'Revisa y registra diariamente en poscosecha (visual) el 100% de la flor el daño de trips?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta12 IS 'Presenta registros diarios de monitoreos directos en campo?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta13 IS 'El monitoreador conoce el procedimiento y lo ejecuta adecuadamente?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta14 IS 'Presenta registros (formatos) adecuados para monitoreo indirecto y directo de los últimos 3 meses (mínimo)?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta15 IS 'Maneja técnicamente la aplicación de plaguicidas y con el uso de equipos apropiados';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta16 IS 'Cuenta la finca con un plan de contingencia para trips y demuestra la aplicación cuando es necesario ?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta17 IS 'Tiene la finca trampas periféricas (migración) con manejo de registros?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta18 IS 'Demuestra la finca que tiene un programa de capacitación formal?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta19 IS 'Ausencia de registros de reclamos tanto de clientes como de organismos oficiales?';
COMMENT ON COLUMN f_inspeccion.certificacionf09.pregunta20 IS 'Control de hospederos secundarios en sitios periféricos de la finca';
COMMENT ON COLUMN f_inspeccion.certificacionf09.observaciones IS 'Obervaciones';
COMMENT ON COLUMN f_inspeccion.certificacionf09.representante IS 'Representante del operador';
COMMENT ON COLUMN f_inspeccion.certificacionf09.resultado IS 'Resultado';
COMMENT ON COLUMN f_inspeccion.certificacionf09.fecha_inspeccion IS 'Fecha de inspección';
COMMENT ON COLUMN f_inspeccion.certificacionf09.usuario_id IS 'Cédula del inspector';
COMMENT ON COLUMN f_inspeccion.certificacionf09.usuario IS 'Inspector';

/*
Reporte 19
Pantalla de REPORTE DE ESPECIMENTES CAPTURADOS VIGILANCIA en el GUIA
#050 Trello
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
  'Reporte Ornamentales Protocolo Trips',
  'reporteOrnamentalesProtocoloTrips',
  19);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteOrnamentalesProtocoloTrips'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteOrnamentalesProtocoloTrips' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/



CREATE TABLE f_inspeccion.certificacionf10
(
  id                        SERIAL NOT NULL,
  id_tablet                 INTEGER,
  numero_reporte            CHARACTER VARYING(256),
  numero_reporte_inspeccion CHARACTER VARYING(256),
  ruc                       CHARACTER VARYING(13),
  exportador                CHARACTER VARYING(256),
  comprador                 CHARACTER VARYING(256),
  lote                      CHARACTER VARYING(64),
  calidad                   CHARACTER VARYING(64),
  sacos                     INTEGER,
  vapor                     CHARACTER VARYING(64),
  id_destino                CHARACTER VARYING(32),
  destino                   CHARACTER VARYING(64),
  id_centro_acopio          CHARACTER VARYING(64),
  centro_acopio             CHARACTER VARYING(64),
  fecha_analisis            TIMESTAMP WITHOUT TIME ZONE,
  muestra_inspector         CHARACTER VARYING(2),
  contra_muestra            CHARACTER VARYING(2),
  tipo_inspeccion           CHARACTER VARYING(64),
  tipo_cacao                CHARACTER VARYING(64),
  tipo_produccion           CHARACTER VARYING(64),
  inspeccion_adicional      CHARACTER VARYING(64),
  fermentacion              NUMERIC,
  fermentados               NUMERIC,
  grano_violeta             NUMERIC,
  grano_pizarroso           NUMERIC,
  mohos                     NUMERIC,
  danados_insectos          NUMERIC,
  vulnerado                 NUMERIC,
  trinitario                CHARACTER VARYING(64),
  multiples                 NUMERIC,
  partidos                  NUMERIC,
  plano_granza              NUMERIC,
  total_defectos            NUMERIC,
  impurezas_cacao           NUMERIC,
  materia_extrana           NUMERIC,
  peso_pepas                NUMERIC,
  pepas_gramos              INTEGER,
  humedad                   NUMERIC,
  medidor_humedad           CHARACTER VARYING(64),
  balanza_utilizada         CHARACTER VARYING(64),
  representante             CHARACTER VARYING(256),
  observaciones             TEXT,
  fecha_inspeccion          TIMESTAMP WITHOUT TIME ZONE,
  usuario_id                CHARACTER VARYING(64),
  usuario                   CHARACTER VARYING(64),
  tablet_id                 CHARACTER VARYING(64),
  tablet_version_base       CHARACTER VARYING(64),
  CONSTRAINT certificacionf10_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.certificacionf10 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.certificacionf10.numero_reporte IS 'Número de reporte';
COMMENT ON COLUMN f_inspeccion.certificacionf10.numero_reporte_inspeccion IS 'Número de reporte de inspección'
COMMENT ON COLUMN f_inspeccion.certificacionf10.ruc IS 'RUC';
COMMENT ON COLUMN f_inspeccion.certificacionf10.exportador IS 'Exportador';
COMMENT ON COLUMN f_inspeccion.certificacionf10.comprador IS 'Comprador';
COMMENT ON COLUMN f_inspeccion.certificacionf10.lote IS 'Lote';
COMMENT ON COLUMN f_inspeccion.certificacionf10.calidad IS 'Calidad';
COMMENT ON COLUMN f_inspeccion.certificacionf10.sacos IS 'Número de sacos';
COMMENT ON COLUMN f_inspeccion.certificacionf10.vapor IS 'Vapor';
COMMENT ON COLUMN f_inspeccion.certificacionf10.destino IS 'Destino';
COMMENT ON COLUMN f_inspeccion.certificacionf10.centro_acopio IS 'Centro de acopio';
COMMENT ON COLUMN f_inspeccion.certificacionf10.fecha_analisis IS 'Fecha análisis';
COMMENT ON COLUMN f_inspeccion.certificacionf10.muestra_inspector IS 'Muestra inspector';
COMMENT ON COLUMN f_inspeccion.certificacionf10.contra_muestra IS 'Contra muestra';
COMMENT ON COLUMN f_inspeccion.certificacionf10.tipo_inspeccion IS 'Tipo de inspección';
COMMENT ON COLUMN f_inspeccion.certificacionf10.tipo_cacao IS 'Tipo de cacao verificado';
COMMENT ON COLUMN f_inspeccion.certificacionf10.tipo_produccion IS 'Tipo de producción';
COMMENT ON COLUMN f_inspeccion.certificacionf10.inspeccion_adicional IS 'Inspección adicional';
COMMENT ON COLUMN f_inspeccion.certificacionf10.fermentacion IS '% buena fermentación';
COMMENT ON COLUMN f_inspeccion.certificacionf10.fermentados IS '% ligeramente fermentados';
COMMENT ON COLUMN f_inspeccion.certificacionf10.grano_violeta IS '% grano violeta';
COMMENT ON COLUMN f_inspeccion.certificacionf10.grano_pizarroso IS '% grano pizarroso';
COMMENT ON COLUMN f_inspeccion.certificacionf10.mohos IS '% mohos';
COMMENT ON COLUMN f_inspeccion.certificacionf10.danados_insectos IS '% dañados por insectos';
COMMENT ON COLUMN f_inspeccion.certificacionf10.vulnerado IS '% vulnerado';
COMMENT ON COLUMN f_inspeccion.certificacionf10.trinitario IS 'Contenido de cacao tipo trinitario (CCN-51)';
COMMENT ON COLUMN f_inspeccion.certificacionf10.multiples IS '% multiples';
COMMENT ON COLUMN f_inspeccion.certificacionf10.partidos IS '% partidos';
COMMENT ON COLUMN f_inspeccion.certificacionf10.plano_granza IS '% plano - granza';
COMMENT ON COLUMN f_inspeccion.certificacionf10.total_defectos IS '% Total defectos';
COMMENT ON COLUMN f_inspeccion.certificacionf10.impurezas_cacao IS '% impurezas de cacao';
COMMENT ON COLUMN f_inspeccion.certificacionf10.materia_extrana IS '% materia extraña';
COMMENT ON COLUMN f_inspeccion.certificacionf10.peso_pepas IS 'Peso de 100 pepas';
COMMENT ON COLUMN f_inspeccion.certificacionf10.pepas_gramos IS 'Número de pepas en 100 gramos';
COMMENT ON COLUMN f_inspeccion.certificacionf10.humedad IS '% humedad';
COMMENT ON COLUMN f_inspeccion.certificacionf10.medidor_humedad IS 'Medidor de humedad utilizado';
COMMENT ON COLUMN f_inspeccion.certificacionf10.balanza_utilizada IS 'Balanza utilizada';
COMMENT ON COLUMN f_inspeccion.certificacionf10.representante IS 'Nombre de representante del exportador';
COMMENT ON COLUMN f_inspeccion.certificacionf10.observaciones IS 'Observaciones';
COMMENT ON COLUMN f_inspeccion.certificacionf10.fecha_inspeccion IS 'Fecha de inspección';
COMMENT ON COLUMN f_inspeccion.certificacionf10.usuario_id IS 'Cédula de inspector';
COMMENT ON COLUMN f_inspeccion.certificacionf10.usuario IS 'Inspector';


/*
Reporte 21
Pantalla de REPORTE DE ESPECIMENTES CAPTURADOS VIGILANCIA en el GUIA
#050 Trello
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
  'Reporte de Calificación de lotes de cacao en grano',
  'reporteCalificacionLotesCacaoGrano',
  21);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteCalificacionLotesCacaoGrano'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteCalificacionLotesCacaoGrano' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/