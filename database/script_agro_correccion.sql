-- Cambio de nombre de formularios (opciones)

UPDATE g_programas.opciones
SET nombre_opcion = 'Reporte de Certificación Fitosanitaria de Exportación'
WHERE nombre_opcion = 'Reporte de inspección para certificación fitosanitaria de plantas, productos vegetales y artículos reglamentados';

UPDATE g_programas.opciones
SET nombre_opcion = 'Inspección piña en finca'
WHERE nombre_opcion = 'Reporte de inspección de moluscos plaga en fincas';

UPDATE g_programas.opciones
SET nombre_opcion = 'Reporte de inspección fintosanitaria de frutos de mango'
WHERE nombre_opcion = 'Reporte de inspección fintosanitaria de frutos muestreados';

-- Cambio de nombre de columnas (comentarios)

COMMENT ON COLUMN f_inspeccion.certificacionf11.fecha_embarque IS 'Fecha de embarque, vuelo o envío';
--COMMENT ON COLUMN f_inspeccion.certificacionf11.ruc IS 'RUC de exportador';
--COMMENT ON COLUMN f_inspeccion.certificacionf11.numero_reporte IS 'Número de reporte de inspección fitosanitaria';
COMMENT ON COLUMN f_inspeccion.certificacionf11_detalle_envios.incumplimiento_requisito IS 'Cumplimiento del requisito';

COMMENT ON COLUMN f_inspeccion.certificacionf10.numero_reporte IS 'Número de reporte de inspección fitosanitaria';
COMMENT ON COLUMN f_inspeccion.certificacionf10.ruc IS 'RUC de exportador';

COMMENT ON COLUMN f_inspeccion.certificacionf12.planta_tratamiento IS 'Planta de tratamiento';

COMMENT ON COLUMN f_inspeccion.certificacionf05.pregunta13 IS '¿Ausencia registros de reclamos, tanto de clientes como de organismos oficiales?';

COMMENT ON COLUMN f_inspeccion.certificacionf06.pregunta19 IS '¿Ausencia de registros de reclamos por cochinillas, tanto de clientes como de organismos oficiales?';

COMMENT ON COLUMN f_inspeccion.certificacionf07.pregunta10 IS '¿Ausencia de registros de reclamos por ácaros, tanto de clientes como de organismos oficiales?';

-- Setea a CERO los valores por defecto
ALTER TABLE f_inspeccion.moscaf01_detalle_trampas
   ALTER COLUMN numero_especimenes SET DEFAULT 0;

ALTER TABLE f_inspeccion.vigilanciaf01_detalle_trampas
   ALTER COLUMN numero_especimenes SET DEFAULT 0;

 ALTER TABLE f_inspeccion.vigilanciaf02
   ALTER COLUMN poblacion SET DEFAULT 0;

-- Pone CERO a valores viejos
UPDATE f_inspeccion.vigilanciaf01_detalle_trampas
SET numero_especimenes = 0
WHERE numero_especimenes IS NULL;

UPDATE f_inspeccion.vigilanciaf02
SET poblacion = 0
WHERE poblacion IS NULL;
