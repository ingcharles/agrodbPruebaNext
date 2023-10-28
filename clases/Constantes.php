<?php

class Constantes {
    
	const NOMBRE_INSTITUCION = 'AGENCIA DE REGULACIÓN Y CONTROL FITO Y ZOOSANITARIO - AGROCALIDAD';
	const RUTA_SERVIDOR_OPT = '/var/www/html';
	const RUTA_APLICACION = 'agrodbPrueba';
	const RUTA_DOMINIO = 'https://pruebasguia.agrocalidad.gob.ec'; // 1 pruebas http://181.112.155.173 // 2 produccion https://guia.agrocalidad.gob.ec
	const SCRIPT_MAPS = '<script src="https://maps.googleapis.com/maps/api/js"></script>';
	const IDENTIFICADOR_RECAUDADOR = '1722551049';//Magdalena Paucar
	const ITEM_TARIFARIO_MUSACEAS = '01.01.010'; //Item de servicio para cobro automatico de musaceas CFE
	const ITEM_TARIFARIO_ORNAMENTALES = '01.01.011'; //Item de servicio para cobro automatico de ornamentales CFE
	const ITEM_TARIFARIO_IAP = '05.03.002'; //Item de servicio para cobro automatico de productos plaguicidas
	const ITEM_TARIFARIO_IAV = '05.03.003'; //Item de servicio para cobro automatico de productos veterinarios
	const ITEM_TARIFARIO_IAF = '05.06.023'; //Item de servicio para cobro automatico de productos fertilizantes
	const ITEM_TARIFARIO_RPRIA_FER = '05.06.020'; //Item de servicio para cobro automatico de registro de productos fertilizantes
	const ITEM_TARIFARIO_RPRIA_BIO = '05.02.007'; //Item de servicio para cobro automatico de registro de bioplaguicidas
	const ITEM_TARIFARIO_RPRIA_CLO_FER = '05.06.021'; //Item de servicio para cobro automatico de registro de productos clones fertilziantes
	const IP_SERVIDOR_VUE = '192.168.200.9'; //IP de servidor VUE
	const PUERTO_SERVIDOR_VUE = '5432'; //Ruta de archivos para documentos anexos en VUE
	const BASE_VUE = 'Solicitudes_Dev'; //Nombre de la base de datos en VUE
	const USUARIO_VUE = 'postgres'; //Usuario base VUE
	const CLAVE_VUE = 'Agrocalidad2022.'; //Clave base VUE
	const RUTA_ARCHIVOS_VUE = 'D:\attach\DEV\documentosGUIA'; //Ruta para envío de archivos --windows 'D:\attach\PROD\documentosGUIA' -- linux ->/app/attach/vueadm
	const RUTA_CORTA_ARCHIVOS_VUE = 'DEV/'; //Ruta para envío de archivos --windows 'PROD/' -- linux ->/app/attach/vueadm
	const IP_SERVIDOR_VUE_FTP = '192.168.200.8'; //IP de servidor VUE
	const PUERTO_SERVIDOR_VUE_FTP = '22'; //Ruta de archivos para documentos anexos en VUE
	const USUARIO_VUE_FTP = 'ftpuser'; //Usuario ftp VUE
	const CLAVE_VUE_FTP = 'Agro2016*'; //Clave ftp VUE
	const RUTA_CARPETA_FTP = './DEV/documentosGUIA'; //Clave ftp VUE --Linux '/app/attach/vueadm/2023'

	public static function tipoAreas() //Funcion que permite declarar los tipos de areas por reportes
    {
        return new class() extends Constantes {
            public $SANIDAD_ANIMAL = "SA";
            public $SANIDAD_VEGETAL = "SV";
        };
    }
	
	public static function tipoReporte() //Funcion que permite declarar los estados en un reporte
    {
        return new class() extends Constantes {
            public $APROBADO = "aprobado";
           
        };
    }
	
}
?>