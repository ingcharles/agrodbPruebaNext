/*

 Formulario de MONITOREO DE VIGILANCIA

 ************************************************************
*/

CREATE TABLE f_inspeccion.vigilanciaf02
(
  id serial NOT NULL,
  id_tablet integer,
  codigo_provincia character varying(32),
  nombre_provincia character varying(256),
  codigo_canton character varying(32),
  nombre_canton character varying(256),
  codigo_parroquia character varying(32),
  nombre_parroquia character varying(256),
  nombre_propietario_finca character varying(256),
  localidad_via character varying(32),
  coordenada_x character varying(6),
  coordenada_y character varying(8),
  coordenada_z character varying(4),
  denuncia_fitosanitaria character varying(2),
  nombre_denunciante character varying(256),
  telefono_denunciante character varying(32),
  direccion_denunciante character varying(32),
  correo_electronico_denunciante character varying(64),
  especie_vegetal character varying(256),
  cantidad_total numeric,
  cantidad_vigilada numeric,
  unidad character varying(16),
  sitio_operacion character varying(64),
  condicion_produccion character varying(16),
  etapa_cultivo character varying(32),
  actividad character varying(64),
  manejo_sitio_operacion character varying(8),
  ausencia_plaga character varying(2),
  plaga_diagnostico_visual_prediagnostico character varying(64),
  cantidad_afectada numeric,
  porcentaje_incidencia numeric,
  porcentaje_severidad numeric,
  tipo_plaga character varying(16),
  fase_desarrollo_plaga character varying(32),
  organo_afectado character varying(32),
  distribucion_plaga character varying(32),
  poblacion numeric,
  diagnostico_visual character varying(64),
  descripcion_sintomas_p character varying(64),
  envio_muestra character varying(2),
  observaciones text,
  fecha_inspeccion timestamp without time zone,
  usuario_id character varying(13),
  usuario character varying(150),
  tablet_id character varying(20),
  tablet_version_base character varying(10),
  CONSTRAINT viliganciaf02_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.vigilanciaf02 USING btree (fecha_inspeccion ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.vigilanciaf02 USING btree (actividad ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.vigilanciaf02 USING btree (especie_vegetal ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.vigilanciaf02 USING btree (diagnostico_visual ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.vigilanciaf02 USING btree (porcentaje_incidencia ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.vigilanciaf02 USING btree (porcentaje_severidad ASC NULLS LAST);



COMMENT ON COLUMN f_inspeccion.vigilanciaf02.codigo_provincia IS 'Código provincia';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.nombre_provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.codigo_canton IS 'Código cantón';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.nombre_canton IS 'Cantón';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.codigo_parroquia IS 'Código parroquia';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.nombre_parroquia IS 'Parroquia';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.nombre_propietario_finca IS 'Propietario/Finca';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.localidad_via IS 'Localidad/Vía';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.coordenada_x IS 'X';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.coordenada_y IS 'Y';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.coordenada_z IS 'Z';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.denuncia_fitosanitaria IS 'Denuncia fitosanitaria';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.nombre_denunciante IS 'Nombre de denunciante';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.telefono_denunciante IS 'Teléfono de denunciante';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.direccion_denunciante IS 'Dirección de denunciante';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.correo_electronico_denunciante IS 'Correo electrónico de denunciante';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.especie_vegetal IS 'Especie vegetal';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.cantidad_total IS 'Cantidad total de especie';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.cantidad_vigilada IS 'Cantidad vigilada de especie';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.unidad IS 'Unidad';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.sitio_operacion IS 'Sitio de operación';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.condicion_produccion IS 'Condición de la producción';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.etapa_cultivo IS 'Etapa de cultivo';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.actividad IS 'Actividad';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.manejo_sitio_operacion IS 'Manejo del sitio de operacióin';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.ausencia_plaga IS 'Ausencia de plaga';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.plaga_diagnostico_visual_prediagnostico IS 'Plaga/Diagnóstico visual o prediagnostico';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.cantidad_afectada IS 'Cantidad afectada';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.porcentaje_incidencia IS '% de incidencia';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.porcentaje_severidad IS '% de severidad';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.tipo_plaga IS 'Tipo de plaga';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.fase_desarrollo_plaga IS 'Fase de desarrollo de plaga';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.organo_afectado IS 'Órgano afectado';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.distribucion_plaga IS 'Distribución de la plaga';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.poblacion IS 'Población';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.diagnostico_visual IS 'Diagnóstico visual';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.descripcion_sintomas_p IS 'Descripción de síntomas';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.envio_muestra IS 'Envío de muestra';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.observaciones IS 'Observaciones';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.fecha_inspeccion IS 'Fecha de inspección';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.usuario_id IS 'Indentificación de inspector';
COMMENT ON COLUMN f_inspeccion.vigilanciaf02.usuario IS 'Inspector';

CREATE TABLE f_inspeccion.vigilanciaf02_detalle_ordenes
(
  id serial NOT NULL,
  id_padre integer,
  id_tablet integer,
  actividad_origen character varying(64) DEFAULT 'Vigilancia fitosanitaria',
  analisis text,
  codigo_muestra character varying(64),
  conservacion character varying(64),
  tipo_muestra character varying(64),
  descripcion_sintomas character varying(256) DEFAULT 'N/A',
  fase_fenologica character varying(64) DEFAULT 'N/A',
  nombre_producto character varying(64) DEFAULT 'Otros',
  peso_muestra numeric DEFAULT 0,
  prediagnostico character varying(256) DEFAULT 'N/A',
  tipo_cliente character varying(64) DEFAULT 'Interno',
  aplicacion_producto_quimico CHARACTER VARYING(16) DEFAULT 'N/A',
  CONSTRAINT vigilanciaf02_detalle_ordenes_pkey PRIMARY KEY (id),
  CONSTRAINT fk_vigilanciaf02_detalle_ordenes FOREIGN KEY (id_padre)
      REFERENCES f_inspeccion.vigilanciaf02 (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
);

/*
Reporte 10
Pantalla de REPORTE GENERAL DE MONITOREO DE TRAMPAS en el GUIA
#038 y #039 Trello
*/

INSERT INTO g_programas.opciones(
            id_aplicacion,
			nombre_opcion,
			pagina,
			orden)
    VALUES (
			(SELECT a.id_aplicacion FROM g_programas.aplicaciones a WHERE a.codificacion_aplicacion = 'PRG_REP'),
			'Reporte general de monitoreo de vigilancia',
			'reporteGeneralMonitoreoVigilancia',
			10);

INSERT INTO g_programas.acciones(
			id_opcion,
			descripcion,
			orden,
			id_aplicacion)
    VALUES (
			(SELECT o.id_opcion FROM g_programas.opciones o WHERE o.pagina = 'reporteGeneralMonitoreoVigilancia'),
			'TODO',
			1,
			(SELECT a.id_aplicacion FROM g_programas.aplicaciones a WHERE a.codificacion_aplicacion = 'PRG_REP'));


INSERT INTO g_programas.acciones_perfiles(
            id_perfil,
			id_accion)
    VALUES ((SELECT p.id_perfil FROM g_usuario.perfiles p WHERE p.codificacion_perfil = 'CSV_REPOR_CONSU' LIMIT 1),
			(SELECT a.id_accion FROM g_programas.opciones o, g_programas.acciones a, g_programas.aplicaciones ap WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteGeneralMonitoreoVigilancia' AND o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/

/*
Reporte 11
Pantalla de REPORTE DE ESPECIMENTES CAPTURADOS VIGILANCIA en el GUIA
#042 Trello
*/

INSERT INTO g_programas.opciones(
            id_aplicacion,
			nombre_opcion,
			pagina,
			orden)
    VALUES (
			(SELECT a.id_aplicacion FROM g_programas.aplicaciones a WHERE a.codificacion_aplicacion = 'PRG_REP'),
			'Reporte de especímenes capturados vigilancia',
			'reporteEspecimenesCapturadosVigilancia',
			11);

INSERT INTO g_programas.acciones(
			id_opcion,
			descripcion,
			orden,
			id_aplicacion)
    VALUES (
			(SELECT o.id_opcion FROM g_programas.opciones o WHERE o.pagina = 'reporteEspecimenesCapturadosVigilancia'),
			'TODO',
			1,
			(SELECT a.id_aplicacion FROM g_programas.aplicaciones a WHERE a.codificacion_aplicacion = 'PRG_REP'));


INSERT INTO g_programas.acciones_perfiles(
            id_perfil,
			id_accion)
    VALUES ((SELECT p.id_perfil FROM g_usuario.perfiles p WHERE p.codificacion_perfil = 'CSV_REPOR_CONSU' LIMIT 1),
			(SELECT a.id_accion FROM g_programas.opciones o, g_programas.acciones a, g_programas.aplicaciones ap WHERE a.id_opcion = o.id_opcion AND o.pagina = 'reporteEspecimenesCapturadosVigilancia' AND o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));


/*
FIN
*/



