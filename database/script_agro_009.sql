/*

 Formulario de Cerficación

 ************************************************************
*/

CREATE TABLE f_inspeccion.certificacionf11
(
  id                  SERIAL NOT NULL,
  id_tablet           INTEGER,
  numero_reporte      CHARACTER VARYING(64),
  ruc                 CHARACTER VARYING(13),
  exportador          CHARACTER VARYING(256),
  sitio_inspeccion    CHARACTER VARYING(256),
  provincia           CHARACTER VARYING(256),
  canton              CHARACTER VARYING(256),
  parroquia           CHARACTER VARYING(256),
  importador          CHARACTER VARYING(256),
  direccion           CHARACTER VARYING(256),
  medio_transporte    CHARACTER VARYING(64),
  fecha_embarque      TIMESTAMP WITHOUT TIME ZONE,
  observaciones       TEXT,
  representante       CHARACTER VARYING(256),
  fecha_vigencia      TIMESTAMP WITHOUT TIME ZONE,
  fecha_inspeccion    TIMESTAMP WITHOUT TIME ZONE,
  usuario_id          CHARACTER VARYING(13),
  usuario             CHARACTER VARYING(150),
  tablet_id           CHARACTER VARYING(20),
  tablet_version_base CHARACTER VARYING(10),
  CONSTRAINT certificacionf11_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.certificacionf11 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.certificacionf11.numero_reporte IS 'Reporte';
COMMENT ON COLUMN f_inspeccion.certificacionf11.ruc IS 'RUC de exportador';
COMMENT ON COLUMN f_inspeccion.certificacionf11.exportador IS 'Exportador';
COMMENT ON COLUMN f_inspeccion.certificacionf11.sitio_inspeccion IS 'Sitio de inspección';
COMMENT ON COLUMN f_inspeccion.certificacionf11.provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.certificacionf11.canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.certificacionf11.parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.certificacionf11.importador IS 'Importador';
COMMENT ON COLUMN f_inspeccion.certificacionf11.direccion IS 'Dirección de importador';
COMMENT ON COLUMN f_inspeccion.certificacionf11.medio_transporte IS 'Medio de transporte';
COMMENT ON COLUMN f_inspeccion.certificacionf11.fecha_embarque IS 'Fecha de embarque';
COMMENT ON COLUMN f_inspeccion.certificacionf11.observaciones IS 'Observaciones';
COMMENT ON COLUMN f_inspeccion.certificacionf11.representante IS 'Representante';
COMMENT ON COLUMN f_inspeccion.certificacionf11.fecha_vigencia IS 'Fecha vigencia';
COMMENT ON COLUMN f_inspeccion.certificacionf11.fecha_inspeccion IS 'Fecha inspección';
COMMENT ON COLUMN f_inspeccion.certificacionf11.usuario_id IS 'Cédula de inspector';
COMMENT ON COLUMN f_inspeccion.certificacionf11.usuario IS 'Inspector';

CREATE TABLE f_inspeccion.certificacionf11_detalle_envios
(
  id                            SERIAL NOT NULL,
  id_padre                      INTEGER,
  id_tablet                     INTEGER,
  ruc_operador                  CHARACTER VARYING(64),
  operador                      CHARACTER VARYING(256),
  id_sitio                      CHARACTER VARYING(64),
  sitio                         CHARACTER VARYING(256),
  provincia                     CHARACTER VARYING(256),
  canton                        CHARACTER VARYING(256),
  parroquia                     CHARACTER VARYING(256),
  id_tipo_producto              CHARACTER VARYING(64),
  tipo_producto                 CHARACTER VARYING(256),
  id_subtipo_producto           CHARACTER VARYING(64),
  subtipo_producto              CHARACTER VARYING(256),
  id_producto                   CHARACTER VARYING(64),
  producto                      CHARACTER VARYING(256),
  pais_destino                  CHARACTER VARYING(256),
  peso_neto                     NUMERIC,
  unidad_cantidad_total         CHARACTER VARYING(32),
  cantidad_total                INTEGER,
  unidad_cantidad_inspeccionada CHARACTER VARYING(32),
  cantidad_inspeccionada        INTEGER,
  requiere_tratamiento          CHARACTER VARYING(2),
  fecha_tratamiento             TIMESTAMP WITHOUT TIME ZONE,
  tratamiento                   CHARACTER VARYING(256),
  otros                         CHARACTER VARYING(256),
  producto_quimico              CHARACTER VARYING(256),
  unidad_duracion_tratamiento   CHARACTER VARYING(32),
  duracion_tratamiento          NUMERIC,
  temperatura                   NUMERIC,
  concentracion                 NUMERIC,
  incumplimiento_requisito      CHARACTER VARYING(64),
  detalles                      CHARACTER VARYING(64),
  medida_adoptada               CHARACTER VARYING(256),
  CONSTRAINT certificacionf11_detalle_envios_pkey PRIMARY KEY (id),
  CONSTRAINT fk_certificacionf11_envios_ordenes FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.certificacionf11 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.ruc_operador IS 'RUC de operador';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.operador IS 'Operador';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.sitio IS 'Sitio';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.tipo_producto IS 'Tipo de producto';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.subtipo_producto IS 'Subtipo de producto';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.producto IS 'Producto';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.pais_destino IS 'País de destino';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.peso_neto IS 'Peso neto (Kg.)';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.unidad_cantidad_total IS 'Unidad de cantidad total';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.cantidad_total IS 'Cantidad total';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.unidad_cantidad_inspeccionada IS 'Unidad de cantidad inspeccionada';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.cantidad_inspeccionada IS 'Cantidad inspeccionada';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.requiere_tratamiento IS 'Requiere tratamiento';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.fecha_tratamiento IS 'Fecha de tratamiento';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.tratamiento IS 'Tramiento';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.otros IS 'Otros';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.producto_quimico IS 'Producto químico';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.unidad_duracion_tratamiento IS 'Unidad de duración tratamiento';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.duracion_tratamiento IS 'Duración de tratamiento';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.temperatura IS 'Temperatura en C°';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.concentracion IS 'Concentración (%)';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.incumplimiento_requisito IS 'Incumplimiento de requerimientos';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.detalles IS 'Detalles';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.medida_adoptada IS 'Medida adoptada';


CREATE TABLE f_inspeccion.certificacionf11_detalle_ordenes
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
  nombre_producto      CHARACTER VARYING(64)  DEFAULT 'exportación',
  peso_muestra         NUMERIC                DEFAULT 0,
  prediagnostico       CHARACTER VARYING(256) DEFAULT 'N/A',
  tipo_cliente         CHARACTER VARYING(64)  DEFAULT 'Interno',
  CONSTRAINT certificacionf11_detalle_ordenes_pkey PRIMARY KEY (id),
  CONSTRAINT fk_certificacionf11_detalle_ordenes FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.certificacionf11 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE f_inspeccion.certificacionf11_detalle_resultados
(
  id                   SERIAL NOT NULL,
  id_padre             INTEGER,
  id_tablet            INTEGER,
  ruc_operador         CHARACTER VARYING(13),
  operador             CHARACTER VARYING(256),
  id_sitio             CHARACTER VARYING(32),
  sitio                CHARACTER VARYING(256),
  id_producto          CHARACTER VARYING(32),
  producto             CHARACTER VARYING(256),
  plaga                CHARACTER VARYING(256),
  individuos           CHARACTER VARYING(64),
  estado               CHARACTER VARYING(32),
  analisis_laboratorio CHARACTER VARYING(2),
  CONSTRAINT certificacionf11_detalle_resultados_pkey PRIMARY KEY (id),
  CONSTRAINT fk_certificacionf11_detalle_resultados FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.certificacionf11 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_resultados.ruc_operador IS 'RUC';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_resultados.operador IS 'Operador';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_resultados.sitio IS 'Sitio';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_resultados.producto IS 'Producto';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_resultados.plaga IS 'Plaga';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_resultados.individuos IS 'N° individuos';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_resultados.estado IS 'Estado';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_resultados.analisis_laboratorio IS 'Análisis de laboratorio';

/*
Reporte 22
Pantalla de REPORTE DE INSPECCIÓN PARA CERTIFICACIÓN FITOSANITARIA DE PLANTAS, PRODUCTOS VEGETALES Y ARTÍCULOS REGLAMENTADOS DE EXPORTACIÓN

#059 Trello
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
  'Reporte de inspección para certificación fitosanitaria de plantas, productos vegetales y artículos reglamentados',
  'reporteInspeccionCertificacionFitoPPVAR',
  22);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteInspeccionCertificacionFitoPPVAR'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteInspeccionCertificacionFitoPPVAR' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/


CREATE TABLE f_inspeccion.certificacionf12
(
  id                               SERIAL NOT NULL,
  id_tablet                        INTEGER,
  numero_reporte                   CHARACTER VARYING(64),
  ruc_empresa_tratamiento          CHARACTER VARYING(64),
  razon_social_empresa_tratamiento CHARACTER VARYING(256),
  id_planta_tratamiento            CHARACTER VARYING(64),
  planta_tratamiento               CHARACTER VARYING(256),
  turno                            CHARACTER VARYING(32),
  fecha_inspeccion                 TIMESTAMP WITHOUT TIME ZONE,
  usuario_id                       CHARACTER VARYING(13),
  usuario                          CHARACTER VARYING(150),
  tablet_id                        CHARACTER VARYING(20),
  tablet_version_base              CHARACTER VARYING(10),
  CONSTRAINT certificacionf12_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.certificacionf12 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.certificacionf12.numero_reporte IS 'Reporte';
COMMENT ON COLUMN f_inspeccion.certificacionf12.ruc_empresa_tratamiento IS 'RUC empresa tratamiento';
COMMENT ON COLUMN f_inspeccion.certificacionf12.razon_social_empresa_tratamiento IS 'Empresa de tratamiento';
COMMENT ON COLUMN f_inspeccion.certificacionf12.planta_tratamiento IS 'Centro de tratemiento';
COMMENT ON COLUMN f_inspeccion.certificacionf12.turno IS 'Turno';
COMMENT ON COLUMN f_inspeccion.certificacionf12.fecha_inspeccion IS 'Fecha y hora de inspección';
COMMENT ON COLUMN f_inspeccion.certificacionf12.usuario_id IS 'Cédula del inspector';
COMMENT ON COLUMN f_inspeccion.certificacionf12.usuario IS 'Inspector';

CREATE TABLE f_inspeccion.certificacionf12_detalle_muestras
(
  id                         SERIAL NOT NULL,
  id_padre                   INTEGER,
  id_tablet                  INTEGER,
  ruc_empresa_finca          CHARACTER VARYING(64),
  razon_social_empresa_finca CHARACTER VARYING(64),
  id_finca                   CHARACTER VARYING(64),
  finca                      CHARACTER VARYING(64),
  lote                       CHARACTER VARYING(64),
  variedad                   CHARACTER VARYING(64),
  numero_gavetas             CHARACTER VARYING(64),
  numero_frutos_muestra      CHARACTER VARYING(64),
  larvas_vivas               CHARACTER VARYING(64),
  larvas_muertas             CHARACTER VARYING(64),
  guia_remision              CHARACTER VARYING(64),
  destino                    CHARACTER VARYING(64),
  numero_camiones INTEGER,
  observaciones              CHARACTER VARYING(64),
  CONSTRAINT certificacionf12_detalle_muestras_pkey PRIMARY KEY (id),
  CONSTRAINT fk_certificacionf12_detalle_muestras FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.certificacionf12 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

COMMENT ON COLUMN f_inspeccion.certificacionf12_detalle_muestras.ruc_empresa_finca IS 'RUC fincas';
COMMENT ON COLUMN f_inspeccion.certificacionf12_detalle_muestras.razon_social_empresa_finca IS 'Empresa finca';
COMMENT ON COLUMN f_inspeccion.certificacionf12_detalle_muestras.finca IS 'Finca';
COMMENT ON COLUMN f_inspeccion.certificacionf12_detalle_muestras.lote IS 'Lote';
COMMENT ON COLUMN f_inspeccion.certificacionf12_detalle_muestras.variedad IS 'Variedad';
COMMENT ON COLUMN f_inspeccion.certificacionf12_detalle_muestras.numero_gavetas IS 'Número de gavetas';
COMMENT ON COLUMN f_inspeccion.certificacionf12_detalle_muestras.numero_frutos_muestra IS 'Número de fruto de muestras';
COMMENT ON COLUMN f_inspeccion.certificacionf12_detalle_muestras.larvas_vivas IS 'Larvas vivas';
COMMENT ON COLUMN f_inspeccion.certificacionf12_detalle_muestras.larvas_muertas IS 'Larvas muertas';
COMMENT ON COLUMN f_inspeccion.certificacionf12_detalle_muestras.guia_remision IS 'Guías de remisión';
COMMENT ON COLUMN f_inspeccion.certificacionf12_detalle_muestras.destino IS 'Destino';
COMMENT ON COLUMN f_inspeccion.certificacionf12_detalle_muestras.numero_camiones IS 'Número de camiones';
COMMENT ON COLUMN f_inspeccion.certificacionf12_detalle_muestras.observaciones IS 'Observaciones';

/*
Reporte 23
Pantalla de REPORTE DE INSPECCIÓN FITOSANITARIA DE FRUTOS MUESTREADOS en el GUIA
#059 Trello
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
  'Reporte de inspección fintosanitaria de frutos muestreados',
  'reporteInspeccionFitosanitariaFrutosMuestreados',
  23);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteInspeccionFitosanitariaFrutosMuestreados'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteInspeccionFitosanitariaFrutosMuestreados' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/

CREATE TABLE f_inspeccion.certificacionf13
(
  id                  SERIAL NOT NULL,
  id_tablet           INTEGER,
  numero_reporte      CHARACTER VARYING(64),
  ruc_agencia_carga   CHARACTER VARYING(13),
  agencia_carga       CHARACTER VARYING(256),
  eeuu                NUMERIC,
  rusia               NUMERIC,
  holanda             NUMERIC,
  chile               NUMERIC,
  otros               NUMERIC,
  totales             NUMERIC,
  representante       CHARACTER VARYING(256),
  fecha_inspeccion    TIMESTAMP WITHOUT TIME ZONE,
  usuario_id          CHARACTER VARYING(13),
  usuario             CHARACTER VARYING(150),
  tablet_id           CHARACTER VARYING(20),
  tablet_version_base CHARACTER VARYING(10),
  CONSTRAINT certificacionf13_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.certificacionf13 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.certificacionf13.numero_reporte IS 'Reporte';
COMMENT ON COLUMN f_inspeccion.certificacionf13.ruc_agencia_carga IS 'RUC de Agencia de carga';
COMMENT ON COLUMN f_inspeccion.certificacionf13.agencia_carga IS 'Agencia de carga';
COMMENT ON COLUMN f_inspeccion.certificacionf13.eeuu IS 'Número de fulls coordinasdas EEUU';
COMMENT ON COLUMN f_inspeccion.certificacionf13.rusia IS 'Número de fulls coordinasdas Rusia';
COMMENT ON COLUMN f_inspeccion.certificacionf13.holanda IS 'Número de fulls coordinasdas Holanda';
COMMENT ON COLUMN f_inspeccion.certificacionf13.chile IS 'Número de fulls coordinasdas Chile';
COMMENT ON COLUMN f_inspeccion.certificacionf13.otros IS 'Número de fulls coordinasdas otros';
COMMENT ON COLUMN f_inspeccion.certificacionf13.totales IS 'Número de fulls coordinasdas totales';
COMMENT ON COLUMN f_inspeccion.certificacionf13.representante IS 'Representante de agencia';
COMMENT ON COLUMN f_inspeccion.certificacionf13.fecha_inspeccion IS 'Fecha de inspección';
COMMENT ON COLUMN f_inspeccion.certificacionf13.usuario_id IS 'Cédula del inspector';
COMMENT ON COLUMN f_inspeccion.certificacionf13.usuario IS 'Inspector';

CREATE TABLE f_inspeccion.certificacionf13_detalle_guias
(
  id                     SERIAL NOT NULL,
  id_padre               INTEGER,
  id_tablet              INTEGER,
  guia_madre             CHARACTER VARYING(256),
  guia_hija              CHARACTER VARYING(256),
  id_destino             CHARACTER VARYING(32),
  destino                CHARACTER VARYING(256),
  ruc_exportador         CHARACTER VARYING(13),
  exportador             CHARACTER VARYING(256),
  id_centro_acopio       CHARACTER VARYING(64),
  centro_acopio          CHARACTER VARYING(256),
  provincia              CHARACTER VARYING(256),
  canton                 CHARACTER VARYING(256),
  parroquia              CHARACTER VARYING(256),
  id_tipo_producto       CHARACTER VARYING(64),
  tipo_producto          CHARACTER VARYING(256),
  id_subtipo_producto    CHARACTER VARYING(64),
  subtipo_producto       CHARACTER VARYING(256),
  id_producto            CHARACTER VARYING(64),
  producto               CHARACTER VARYING(256),
  cajas                  NUMERIC,
  cajas_inpeccion        NUMERIC,
  codigo_finca           CHARACTER VARYING(2),
  adhesivo_inspeccionado CHARACTER VARYING(2),
  observaciones          TEXT,
  medida_adoptada        CHARACTER VARYING(256),
  cajas_detenidas        NUMERIC,
  CONSTRAINT certificacionf13_detalle_guias_pkey PRIMARY KEY (id),
  CONSTRAINT fk_certificacionf13_detalle_guias FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.certificacionf13 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.guia_madre IS 'Número de guía madre';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.guia_hija IS 'Número de guía hija';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.destino IS 'Destino';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.ruc_exportador IS 'RUC de exportador';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.exportador IS 'Exportador';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.centro_acopio IS 'Centro de acopio';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.tipo_producto IS 'Tipo de producto';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.subtipo_producto IS 'Subtipo de producto';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.producto IS 'Producto';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.cajas IS 'No. cajas/finca';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.cajas_inpeccion IS 'No. cajas inspección/finca';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.codigo_finca IS 'Presencia código de finca';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.adhesivo_inspeccionado IS 'Presencia adhesivo inspeccionado';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.observaciones IS 'Observaciones';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.medida_adoptada IS 'Medida adoptada';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_guias.cajas_detenidas IS 'No. cajas/finca detenidas';

CREATE TABLE f_inspeccion.certificacionf13_detalle_ordenes
(
  id                          SERIAL NOT NULL,
  id_padre                    INTEGER,
  id_tablet                   INTEGER,
  actividad_origen            CHARACTER VARYING(50)  DEFAULT 'Certificación fitosanitaria',
  analisis                    TEXT,
  aplicacion_producto_quimico CHARACTER VARYING(16)  DEFAULT 'N/A',
  codigo_muestra              CHARACTER VARYING(50),
  conservacion                CHARACTER VARYING(50),
  tipo_muestra                CHARACTER VARYING(50),
  descripcion_sintomas        CHARACTER VARYING(150) DEFAULT 'N/A',
  fase_fenologica             CHARACTER VARYING(50)  DEFAULT 'N/A',
  nombre_producto             CHARACTER VARYING(50)  DEFAULT 'Exportación',
  peso_muestra                NUMERIC                DEFAULT 0,
  prediagnostico              CHARACTER VARYING(150) DEFAULT 'N/A',
  tipo_cliente                CHARACTER VARYING(50)  DEFAULT 'Interno',
  CONSTRAINT certificacionf13_detalle_ordenes_pkey PRIMARY KEY (id),
  CONSTRAINT fk_certificacionf13_detalle_ordenes FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.certificacionf13 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE f_inspeccion.certificacionf13_detalle_resultados
(
  id                   SERIAL NOT NULL,
  id_padre             INTEGER,
  id_tablet            INTEGER,
  ruc_exportador         CHARACTER VARYING(13),
  exportador             CHARACTER VARYING(256),
  id_destino             CHARACTER VARYING(32),
  destino                CHARACTER VARYING(256),
  id_producto          CHARACTER VARYING(32),
  producto             CHARACTER VARYING(256),
  plaga                CHARACTER VARYING(256),
  individuos           CHARACTER VARYING(64),
  estado               CHARACTER VARYING(32),
  analisis_laboratorio CHARACTER VARYING(2),
  CONSTRAINT certificacionf13_detalle_resultados_pkey PRIMARY KEY (id),
  CONSTRAINT fk_certificacionf13_detalle_resultados FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.certificacionf13 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_resultados.ruc_exportador IS 'RUC';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_resultados.exportador IS 'Exportador';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_resultados.destino IS 'País de destino';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_resultados.producto IS 'Producto';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_resultados.plaga IS 'Plaga';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_resultados.individuos IS 'N° individuos';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_resultados.estado IS 'Estado';
COMMENT ON COLUMN f_inspeccion.certificacionf13_detalle_resultados.analisis_laboratorio IS 'Análisis de laboratorio';


/*
Reporte 24
Pantalla de REPORTE DE INSPECCIÓN DE AGENCIA DE CARGA en el GUIA
#062 Trello
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
  'Reporte de inspección en agencias de carga',
  'reporteInspeccionAgenciasCarga',
  24);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteInspeccionAgenciasCarga'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteInspeccionAgenciasCarga' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/


/*

SEGUIMIENTO CUARENTENARIO
SCRIPT EDISON
*/
/*
--CREACIÓN DE ESQUEMA.
CREATE SCHEMA g_seguimiento_cuarentenario

  --CREACIÓN DE TABLAS DEL FORMULARIO.

  CREATE TABLE g_seguimiento_cuarentenario.seguimientos_cuarentenarios
  (
    id_seguimiento_cuarentenario serial NOT NULL,
    id_destinacion_aduanera integer,
    estado character varying(32),
    numero_seguimientos integer,
    numero_plantas integer,
    cantidad_producto_cierre integer,
    fecha_cierre timestamp without time zone,
    observacion_cierre character varying(512),
    CONSTRAINT seguimiento_cuarentenario_pkey PRIMARY KEY (id_seguimiento_cuarentenario)
  )

  CREATE TABLE g_seguimiento_cuarentenario.detalle_seguimientos_carentenarios
  (
    id_detalle_seguimientos_carentenarios serial NOT NULL,
    id_seguimiento_cuarentenario integer,
    secuencial_seguimiento integer,
    fecha_seguimiento timestamp without time zone,
    resultado_inspeccion character varying(32),
    observacion_seguimiento character varying(512),
    CONSTRAINT detalle_seguimientos_carentenarios_pkey PRIMARY KEY (id_detalle_seguimientos_carentenarios),
    CONSTRAINT detalle_seguimientos_carenten_id_seguimiento_cuarentenario_fkey FOREIGN KEY (id_seguimiento_cuarentenario)
    REFERENCES g_seguimiento_cuarentenario.seguimientos_cuarentenarios (id_seguimiento_cuarentenario) MATCH SIMPLE
    ON UPDATE NO ACTION ON DELETE NO ACTION
  )*/



CREATE TABLE f_inspeccion.controlf04
(
  id                                   SERIAL NOT NULL,
  id_tablet                            INTEGER,
  id_seguimiento_cuarentenario         CHARACTER VARYING(32),
  ruc_operador                          CHARACTER VARYING(13),
  razon_social                         CHARACTER VARYING(256),
  codigo_pais_origen                          CHARACTER VARYING(64),
  pais_origen                          CHARACTER VARYING(256),
  producto                             CHARACTER VARYING(256),
  subtipo_producto                     CHARACTER VARYING(256),
  peso                                 CHARACTER VARYING(256),
  numero_plantas_ingreso               INTEGER,
  codigo_provincia                     CHARACTER VARYING(32),
  provincia                            CHARACTER VARYING(256),
  codigo_canton                        CHARACTER VARYING(32),
  canton                               CHARACTER VARYING(256),
  codigo_parroquia                     CHARACTER VARYING(32),
  parroquia                            CHARACTER VARYING(256),
  nombre_scpe                          CHARACTER VARYING(256),
  tipo_operacion                       CHARACTER VARYING(256),
  tipo_cuarentena_condicion_produccion CHARACTER VARYING(256),
  fase_seguimiento                     CHARACTER VARYING(256),
  codigo_lote                          CHARACTER VARYING(256),
  numero_seguimientos_planificados     INTEGER,
  cantidad_total                       NUMERIC,
  cantidad_vigilada                    NUMERIC,
  actividad                            CHARACTER VARYING(256),
  etapa_cultivo                        CHARACTER VARYING(256),
  registro_monitoreo_plagas            CHARACTER VARYING(256),
  ausencia_plagas                      CHARACTER VARYING(256),
  cantidad_afectada                    NUMERIC,
  porcentaje_incidencia                NUMERIC,
  porcentaje_severidad                 NUMERIC,
  fase_desarrollo_plaga                CHARACTER VARYING(256),
  organo_afectado                      CHARACTER VARYING(256),
  distribucion_plaga                   CHARACTER VARYING(256),
  poblacion                            CHARACTER VARYING(256),
  descripcion_sintomas                 CHARACTER VARYING(256),
  envio_muestra                        CHARACTER VARYING(256),
  resultado_inspeccion                 CHARACTER VARYING(256),
  numero_plantas_inspeccion            INTEGER,
  observaciones                        TEXT,
  fecha_inspeccion                     TIMESTAMP WITHOUT TIME ZONE,
  usuario_id                           CHARACTER VARYING(13),
  usuario                              CHARACTER VARYING(150),
  tablet_id                            CHARACTER VARYING(20),
  tablet_version_base                  CHARACTER VARYING(10),
  CONSTRAINT controlf04_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.controlf04 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.controlf04.ruc_operador IS 'RUC operador';
COMMENT ON COLUMN f_inspeccion.controlf04.razon_social IS 'Razón social';
COMMENT ON COLUMN f_inspeccion.controlf04.pais_origen IS 'País de origen';
COMMENT ON COLUMN f_inspeccion.controlf04.producto IS 'Producto';
COMMENT ON COLUMN f_inspeccion.controlf04.subtipo_producto IS 'Subtipo';
COMMENT ON COLUMN f_inspeccion.controlf04.peso IS 'Peso';
COMMENT ON COLUMN f_inspeccion.controlf04.numero_plantas_ingreso IS 'Número plantas ingreso';
COMMENT ON COLUMN f_inspeccion.controlf04.provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.controlf04.canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.controlf04.parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.controlf04.nombre_scpe IS 'Nombre del SCPE';
COMMENT ON COLUMN f_inspeccion.controlf04.tipo_operacion IS 'Tipo operación';
COMMENT ON COLUMN f_inspeccion.controlf04.tipo_cuarentena_condicion_produccion IS 'Tipo cuarentena/condición de producción';
COMMENT ON COLUMN f_inspeccion.controlf04.fase_seguimiento IS 'Fase de seguimiento';
COMMENT ON COLUMN f_inspeccion.controlf04.codigo_lote IS 'Código de lote';
COMMENT ON COLUMN f_inspeccion.controlf04.numero_seguimientos_planificados IS 'Número de seguimientos planificados';
COMMENT ON COLUMN f_inspeccion.controlf04.cantidad_total IS 'Cantidad total';
COMMENT ON COLUMN f_inspeccion.controlf04.cantidad_vigilada IS 'Cantidad vigilada';
COMMENT ON COLUMN f_inspeccion.controlf04.actividad IS 'Actividad';
COMMENT ON COLUMN f_inspeccion.controlf04.etapa_cultivo IS 'Etapa de cultivo';
COMMENT ON COLUMN f_inspeccion.controlf04.registro_monitoreo_plagas IS 'Posee registro de monitoreo de plagas';
COMMENT ON COLUMN f_inspeccion.controlf04.ausencia_plagas IS 'Ausencia de plagas';
COMMENT ON COLUMN f_inspeccion.controlf04.cantidad_afectada IS 'Cantidad afectada';
COMMENT ON COLUMN f_inspeccion.controlf04.porcentaje_incidencia IS '% incidencia';
COMMENT ON COLUMN f_inspeccion.controlf04.porcentaje_severidad IS '% severidad';
COMMENT ON COLUMN f_inspeccion.controlf04.fase_desarrollo_plaga IS 'Fase de desarrollo plaga';
COMMENT ON COLUMN f_inspeccion.controlf04.organo_afectado IS 'Órgano afectado de la planta';
COMMENT ON COLUMN f_inspeccion.controlf04.distribucion_plaga IS 'Distribución de la plaga';
COMMENT ON COLUMN f_inspeccion.controlf04.poblacion IS 'Población';
COMMENT ON COLUMN f_inspeccion.controlf04.descripcion_sintomas IS 'Descripción de síntomas';
COMMENT ON COLUMN f_inspeccion.controlf04.envio_muestra IS 'Envío muestra a laboratorio';
COMMENT ON COLUMN f_inspeccion.controlf04.resultado_inspeccion IS 'Resultado inspección';
COMMENT ON COLUMN f_inspeccion.controlf04.numero_plantas_inspeccion IS 'Número de plantas en la inspección';
COMMENT ON COLUMN f_inspeccion.controlf04.observaciones IS 'Observaciones';
COMMENT ON COLUMN f_inspeccion.controlf04.fecha_inspeccion IS 'Fecha de inspección';
COMMENT ON COLUMN f_inspeccion.controlf04.usuario_id IS 'Cédula inspector';
COMMENT ON COLUMN f_inspeccion.controlf04.usuario IS 'Inspector';

CREATE TABLE f_inspeccion.controlf04_detalle_ordenes
(
  id                          SERIAL NOT NULL,
  id_padre                    INTEGER,
  id_tablet                   INTEGER,
  actividad_origen            CHARACTER VARYING(50)  DEFAULT 'Cuarentena',
  analisis                    TEXT,
  aplicacion_producto_quimico CHARACTER VARYING(16),
  codigo_muestra              CHARACTER VARYING(50),
  conservacion                CHARACTER VARYING(50)  DEFAULT 'Envase apropiado',
  tipo_muestra                CHARACTER VARYING(50),
  descripcion_sintomas        CHARACTER VARYING(150),
  fase_fenologica             CHARACTER VARYING(50)  DEFAULT 'N/A',
  nombre_producto             CHARACTER VARYING(50)  DEFAULT 'Importación',
  peso_muestra                NUMERIC                DEFAULT 0,
  prediagnostico              CHARACTER VARYING(150),
  tipo_cliente                CHARACTER VARYING(50)  DEFAULT 'Interno',
  CONSTRAINT controlf04_detalle_ordenes_pkey PRIMARY KEY (id),
  CONSTRAINT fk_controlf04_detalle_ordenes FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.controlf04 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);


/*
Reporte 25
Pantalla de REPORTE DE INSPECCIÓN DE AGENCIA DE CARGA en el GUIA
#018 Trello
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
  'Reporte de seguimiento cuarentenario',
  'reporteSeguimientoCuarentenario',
  25);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteSeguimientoCuarentenario'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteSeguimientoCuarentenario' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/

/*
Reporte 26
Pantalla de REPORTE DE INSPECCIÓN DE AGENCIA DE CARGA en el GUIA
NO EXISTE EN TRELLO
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
  'Reporte de tránsito internacional',
  'reporteTransitoInternacional',
  26);

INSERT INTO g_programas.acciones (
  id_opcion,
  descripcion,
  orden,
  id_aplicacion)
VALUES (
  (SELECT o.id_opcion
   FROM g_programas.opciones o
   WHERE o.pagina = 'reporteTransitoInternacional'),
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
         WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteTransitoInternacional' AND
               o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND
               a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/
