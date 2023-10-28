/*
 Nota: requiere haber creado aplicación PRG_REP (script_agro_002.sql)

 ************************************************************
*/

/*
Reporte 2
Pantalla de reporte INSPECCIÓN DE PRODUCTOS IMPORTADOS POR INCUMPLIMIENTO en el GUIA

*/

INSERT INTO g_programas.opciones(
            id_aplicacion, 
			nombre_opcion,  
			pagina, 
			orden)
    VALUES (
			(SELECT a.id_aplicacion FROM g_programas.aplicaciones a WHERE a.codificacion_aplicacion = 'PRG_REP'), 
			'Incumplimiento en inspección de productos por país', 
			'inspeccionProductosImportadosPorIncumplimiento',
			2);
			
INSERT INTO g_programas.acciones(
			id_opcion, 
			descripcion, 
			orden, 
			id_aplicacion)
    VALUES (
			(SELECT o.id_opcion FROM g_programas.opciones o WHERE o.pagina = 'inspeccionProductosImportadosPorIncumplimiento'), 
			'TODO', 
			1, 
			(SELECT a.id_aplicacion FROM g_programas.aplicaciones a WHERE a.codificacion_aplicacion = 'PRG_REP'));

			
INSERT INTO g_programas.acciones_perfiles(
            id_perfil,
			id_accion)
    VALUES ((SELECT p.id_perfil FROM g_usuario.perfiles p WHERE p.codificacion_perfil = 'CSV_REPOR_CONSU' LIMIT 1), 
			(SELECT a.id_accion FROM g_programas.opciones o, g_programas.acciones a, g_programas.aplicaciones ap WHERE a.id_opcion = o.id_opcion AND o.pagina = 'inspeccionProductosImportadosPorIncumplimiento' AND o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));
/*
FIN
*/

/*
Reporte 3
Pantalla de reporte CANTIDAD PRODUCTOS IMPORTADOS POR PAIS en el GUIA

*/

INSERT INTO g_programas.opciones(
            id_aplicacion, 
			nombre_opcion,  
			pagina, 
			orden)
    VALUES (
			(SELECT a.id_aplicacion FROM g_programas.aplicaciones a WHERE a.codificacion_aplicacion = 'PRG_REP'), 
			'Cantidad de ingreso de productos por país', 
			'cantidadProductosImportadosPorPais',
			3);
			
INSERT INTO g_programas.acciones(
			id_opcion, 
			descripcion, 
			orden, 
			id_aplicacion)
    VALUES (
			(SELECT o.id_opcion FROM g_programas.opciones o WHERE o.pagina = 'cantidadProductosImportadosPorPais'), 
			'TODO', 
			1, 
			(SELECT a.id_aplicacion FROM g_programas.aplicaciones a WHERE a.codificacion_aplicacion = 'PRG_REP'));

			
INSERT INTO g_programas.acciones_perfiles(
            id_perfil,
			id_accion)
    VALUES ((SELECT p.id_perfil FROM g_usuario.perfiles p WHERE p.codificacion_perfil = 'CSV_REPOR_CONSU' LIMIT 1), 
			(SELECT a.id_accion FROM g_programas.opciones o, g_programas.acciones a, g_programas.aplicaciones ap WHERE a.id_opcion = o.id_opcion AND o.pagina = 'cantidadProductosImportadosPorPais' AND o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));
			
/*
FIN
*/

/*
Reporte 4
Pantalla de reporte CANTIDAD INCUMPLIMIENTO DE INGRESO DE PRODUCTOS POR PAIS en el GUIA

*/

INSERT INTO g_programas.opciones(
            id_aplicacion, 
			nombre_opcion,  
			pagina, 
			orden)
    VALUES (
			(SELECT a.id_aplicacion FROM g_programas.aplicaciones a WHERE a.codificacion_aplicacion = 'PRG_REP'), 
			'Incumplimiento en embalajes de madera por país y punto de control', 
			'incumplimientoEmbalajesMaderaPorPais',
			4);
			
INSERT INTO g_programas.acciones(
			id_opcion, 
			descripcion, 
			orden, 
			id_aplicacion)
    VALUES (
			(SELECT o.id_opcion FROM g_programas.opciones o WHERE o.pagina = 'incumplimientoEmbalajesMaderaPorPais'), 
			'TODO', 
			1, 
			(SELECT a.id_aplicacion FROM g_programas.aplicaciones a WHERE a.codificacion_aplicacion = 'PRG_REP'));

			
INSERT INTO g_programas.acciones_perfiles(
            id_perfil,
			id_accion)
    VALUES ((SELECT p.id_perfil FROM g_usuario.perfiles p WHERE p.codificacion_perfil = 'CSV_REPOR_CONSU' LIMIT 1), 
			(SELECT a.id_accion FROM g_programas.opciones o, g_programas.acciones a, g_programas.aplicaciones ap WHERE a.id_opcion = o.id_opcion AND o.pagina = 'incumplimientoEmbalajesMaderaPorPais' AND o.id_aplicacion = ap.id_aplicacion AND ap.codificacion_aplicacion = 'PRG_REP' AND a.id_aplicacion = ap.id_aplicacion AND a.id_opcion = o.id_opcion));
			

/*
FIN
*/


