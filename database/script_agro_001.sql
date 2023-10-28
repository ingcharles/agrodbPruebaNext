/*

Se debe agregar columna para contar envios en tabla de DDA (script de Edison)

*/


CREATE SCHEMA f_inspeccion;

CREATE TABLE f_inspeccion.controlf01
(
  id                              SERIAL NOT NULL,
  id_tablet                       INTEGER,
  dda                             CHARACTER VARYING(25), -- Documento de Destinación Aduanera
  pfi                             CHARACTER VARYING(25), -- Permiso Fitosanitario de Importación
  dictamen_final                  CHARACTER VARYING(50), -- Dictamen final de inspección
  observaciones                   TEXT, -- Observaciones de la inspección
  envio_muestra                   CHARACTER VARYING(5), -- ¿Envío de muestra?
  usuario_id                      CHARACTER VARYING(13), -- Identificación de inspector
  usuario                         CHARACTER VARYING(150), -- Inspector
  fecha_inspeccion                TIMESTAMP WITHOUT TIME ZONE, -- Fecha de la inspección
  tablet_id                       CHARACTER VARYING(20),
  tablet_version_base             CHARACTER VARYING(10),
  pregunta01                      CHARACTER VARYING(5), -- Descripción del producto coincide con el producto físico
  pregunta02                      CHARACTER VARYING(5), -- Cantidad del producto vegetal es menor o igual al autorizado
  pregunta03                      CHARACTER VARYING(5), -- Los embalajes de madera cuentan con la marca autorizada del país de origen
  pregunta04                      CHARACTER VARYING(5), -- La marca es legible
  pregunta05                      CHARACTER VARYING(5), -- Ausencia de daño de insectos
  pregunta06                      CHARACTER VARYING(5), -- Ausencia de insectos vivos en los embalajes
  pregunta07                      CHARACTER VARYING(5), -- Ausencia de corteza
  pregunta08                      CHARACTER VARYING(5), -- Empaques nuevos de primer uso
  pregunta09                      INTEGER, -- No. de contenedores/vehiculos del envio
  pregunta10                      INTEGER, -- No. de contenedores seleccionados para el aforo
  pregunta11                      CHARACTER VARYING(30), -- Criterio usado para la división de los envíos en lotes
  categoria_riesgo                CHARACTER VARYING(2),
  seguimiento_cuarentenario       CHARACTER VARYING(2),
  provincia                       CHARACTER VARYING(50),
  peso_ingreso                    NUMERIC,
  numero_embalajes_envio          INTEGER,
  numero_embalajes_inspeccionados INTEGER,
  CONSTRAINT controlf01_pkey PRIMARY KEY (id)
);

CREATE INDEX ON f_inspeccion.controlf01 USING BTREE (dda ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.controlf01 USING BTREE (pfi ASC NULLS LAST);
CREATE INDEX ON f_inspeccion.controlf01 USING BTREE (fecha_inspeccion ASC NULLS LAST);

COMMENT ON COLUMN f_inspeccion.controlf01.dda IS 'Documento de Destinación Aduanera';
COMMENT ON COLUMN f_inspeccion.controlf01.pfi IS 'Permiso Fitosanitario de Importación';
COMMENT ON COLUMN f_inspeccion.controlf01.dictamen_final IS 'Dictamen final de inspección';
COMMENT ON COLUMN f_inspeccion.controlf01.observaciones IS 'Observaciones de la inspección';
COMMENT ON COLUMN f_inspeccion.controlf01.envio_muestra IS '¿Envío de muestra?';
COMMENT ON COLUMN f_inspeccion.controlf01.usuario_id IS 'Identificación de inspector';
COMMENT ON COLUMN f_inspeccion.controlf01.usuario IS 'Inspector';
COMMENT ON COLUMN f_inspeccion.controlf01.fecha_inspeccion IS 'Fecha de la inspección';
COMMENT ON COLUMN f_inspeccion.controlf01.pregunta01 IS 'Descripción del producto coincide con el producto físico';
COMMENT ON COLUMN f_inspeccion.controlf01.pregunta02 IS 'Cantidad del producto vegetal es menor o igual al autorizado';
COMMENT ON COLUMN f_inspeccion.controlf01.pregunta03 IS 'Los embalajes de madera cuentan con la marca autorizada del país de origen';
COMMENT ON COLUMN f_inspeccion.controlf01.pregunta04 IS 'La marca es legible';
COMMENT ON COLUMN f_inspeccion.controlf01.pregunta05 IS 'Ausencia de daño de insectos';
COMMENT ON COLUMN f_inspeccion.controlf01.pregunta06 IS 'Ausencia de insectos vivos en los embalajes';
COMMENT ON COLUMN f_inspeccion.controlf01.pregunta07 IS 'Ausencia de corteza';
COMMENT ON COLUMN f_inspeccion.controlf01.pregunta08 IS 'Empaques nuevos de primer uso';
COMMENT ON COLUMN f_inspeccion.controlf01.pregunta09 IS 'No. de contenedores/vehiculos del envio';
COMMENT ON COLUMN f_inspeccion.controlf01.pregunta10 IS 'No. de contenedores seleccionados para el aforo';
COMMENT ON COLUMN f_inspeccion.controlf01.pregunta11 IS 'Criterio usado para la división de los envíos en lotes';
COMMENT ON COLUMN f_inspeccion.controlf01.categoria_riesgo IS 'Categoría de riesgo';
COMMENT ON COLUMN f_inspeccion.controlf01.seguimiento_cuarentenario IS '¿Requiere seguimiento cuarentenario?';
COMMENT ON COLUMN f_inspeccion.controlf01.provincia IS 'Provincia';
COMMENT ON COLUMN f_inspeccion.controlf01.peso_ingreso IS 'Peso de ingreso';
COMMENT ON COLUMN f_inspeccion.controlf01.numero_embalajes_envio IS 'Embalajes de envío';
COMMENT ON COLUMN f_inspeccion.controlf01.numero_embalajes_inspeccionados IS 'Embalajes inspeccionados';

CREATE TABLE f_inspeccion.controlf01_detalle_lotes
(
  id                     SERIAL NOT NULL,
  id_padre               INTEGER,
  id_tablet              INTEGER,
  descripcion            TEXT,
  numero_cajas           INTEGER,
  cajas_muestra          INTEGER,
  porcentaje_inspeccion  NUMERIC,
  ausencia_suelo         CHARACTER VARYING(5),
  ausencia_contaminantes CHARACTER VARYING(5),
  ausencia_sintomas      CHARACTER VARYING(5),
  ausencia_plagas        CHARACTER VARYING(5),
  dictamen               CHARACTER VARYING(50),
  CONSTRAINT controlf01_detalle_lotes_pkey PRIMARY KEY (id),
  CONSTRAINT fk_controlf01_detalle_lotes FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.controlf01 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

COMMENT ON COLUMN f_inspeccion.controlf01_detalle_lotes.ausencia_suelo IS 'Ausencia de suelo';
COMMENT ON COLUMN f_inspeccion.controlf01_detalle_lotes.ausencia_contaminantes IS 'Ausencia de contaminantes';
COMMENT ON COLUMN f_inspeccion.controlf01_detalle_lotes.ausencia_sintomas IS 'Ausencia de sintomas';
COMMENT ON COLUMN f_inspeccion.controlf01_detalle_lotes.ausencia_plagas IS 'Ausencia de plagas';

CREATE TABLE f_inspeccion.controlf01_detalle_ordenes
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
  CONSTRAINT controlf01_detalle_ordenes_pkey PRIMARY KEY (id),
  CONSTRAINT fk_controlf01_detalle_ordenes FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.controlf01 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE f_inspeccion.controlf01_detalle_productos_ingresados
(
  id                 SERIAL NOT NULL,
  id_padre           INTEGER,
  id_tablet          INTEGER,
  nombre             CHARACTER VARYING(150),
  cantidad_declarada NUMERIC,
  cantidad_ingresada NUMERIC,
  unidad             CHARACTER VARYING(5),
  subtipo            CHARACTER VARYING(50),
  CONSTRAINT controlf01_detalle_productos_ingresados_pkey PRIMARY KEY (id),
  CONSTRAINT fk_controlf01_detalle_productos_ingresados FOREIGN KEY (id_padre)
  REFERENCES f_inspeccion.controlf01 (id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE CASCADE
);

COMMENT ON COLUMN f_inspeccion.controlf01_detalle_productos_ingresados.nombre IS 'Producto';
COMMENT ON COLUMN f_inspeccion.controlf01_detalle_productos_ingresados.cantidad_declarada IS 'Cantidad declarada';
COMMENT ON COLUMN f_inspeccion.controlf01_detalle_productos_ingresados.cantidad_ingresada IS 'Cantidad ingresada durante inspección';
COMMENT ON COLUMN f_inspeccion.controlf01_detalle_productos_ingresados.unidad IS 'Unidad de peso';
COMMENT ON COLUMN f_inspeccion.controlf01_detalle_productos_ingresados.subtipo IS 'Subtipo';

