<?php

	use Agrodb\Core\JasperReport;
use Zend\Validator\File\Exists;


	 $jasper = new JasperReport();
	 $datosReporte = array();

	$ruta = REG_CAP_URL_CERT . 'certificado/'; 

	if (! file_exists($ruta)) {
		mkdir($ruta, 0777, true);
	}

	$idProvincia = isset($_POST['id_provincia']) ? $_POST['id_provincia'] : '';
	$idCoordinacion = isset($_POST['id_coordinacion']) ? $_POST['id_coordinacion'] : '';
	$fechaInicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
	$fechaFin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';
	$idDireccion = isset($_POST['id_direccion']) ? $_POST['id_direccion'] : '';
	$idProvincia = isset($_POST['id_provinciaFiltro']) ? $_POST['id_provinciaFiltro'] : '';
	$codProvincia = isset($_POST['codProvincia']) ? $_POST['codProvincia'] : '';
	$identificador = isset($_POST['identificadorTecnico']) ? $_POST['identificadorTecnico'] : '';
	$oficina = isset($_POST['oficina']) ? $_POST['oficina'] : '';
	$tipoUsuario = isset($_POST['tipoUsuario']) ? $_POST['tipoUsuario'] : '';
	$nombreCoor = isset($_POST['nombreCoor']) ? $_POST['nombreCoor'] : '';
	$nombreDir = isset($_POST['nombreDir']) ? $_POST['nombreDir'] : '';
	$nombreProvincia = isset($_POST['nombre_provincia']) ? $_POST['nombre_provincia'] : '';

	$datosReporte = array(
		'tipoSalidaReporte' => array('pdf'),
		'conexionBase' => 'SI',
		'rutaSalidaReporte' => 'RegistroCapacitaciones/archivos/certificado/' . $idCoordinacion.$identificador
	);	

	$parametrosReporte = array(
		'fondoCertificado'=> RUTA_IMG_GENE.'fondoCertificado.png',
		'fechaInicio' => $fechaInicio,
		'fechaFin' => $fechaFin,
		'idCoordinacion' => $idCoordinacion,
		'idDireccion' => $idDireccion,
		'identificadorTecnico' => $_POST['identificadorTecnico'],
		'nombreTecnico' => $_POST['nombreTecnico'],
		'nombreArea' => $_POST['nombreArea'], 
		'idProvinciaFiltro' => $idProvincia,
		'nombreCoor' => ucfirst($nombreCoor),
		'nombreDir' => ucfirst($nombreDir)
		
	);
	
	if($tipoUsuario == 'Responsable'){
		if($codProvincia == 'PC' && $oficina!=''){
			$idGestion = isset($_POST['idArea']) ? $_POST['idArea'] : '';
			$datoResporte[] = ($datosReporte+=[
				'rutaReporte' => 'RegistroCapacitaciones/vistas/reportes/reporteCapacitacionesPlantaCentral.jasper',
			]);
			$datosReporte['parametrosReporte'] = $parametrosReporte+= [
				'idGestion' => $idGestion,
				'idProvincia' => $idProvincia
			];
		}else if($codProvincia == '' && $oficina!=''){
			$idGestion = isset($_POST['idArea']) ? $_POST['idArea'] : '';
			$datoResporte[] = ($datosReporte+=[
				'rutaReporte' => 'RegistroCapacitaciones/vistas/reportes/reporteCapacitacionesGeneralPlantaCentral.jasper',
			]);
			$datosReporte['parametrosReporte'] = $parametrosReporte+= [
				'idGestion' => $idGestion,
				'idProvincia' => $idProvincia
			];
		}

	}
	if($tipoUsuario == 'TecnicoPlantaCentral'){
		$idGestion = isset($_POST['idArea']) ? $_POST['idArea'] : '';
		$datoResporte[] = ($datosReporte+=[
			'rutaReporte' => 'RegistroCapacitaciones/vistas/reportes/reporteCapacitacionesTecnicoPlantaCentral.jasper',
		]);
			$datosReporte['parametrosReporte'] = $parametrosReporte+= [
				'idGestion' => $idGestion,
				'idProvincia' => $idProvincia
			];
}
	if($tipoUsuario == 'TecnicoPichinchaCanton'){
		$idGestion = isset($_POST['idArea']) ? $_POST['idArea'] : '';
		$datoResporte[] = ($datosReporte+=[
			'rutaReporte' => 'RegistroCapacitaciones/vistas/reportes/reporteCapacitacionesTecnicoPlantaCentral.jasper',
		]);
			$datosReporte['parametrosReporte'] = $parametrosReporte+= [
				'idGestion' => $idGestion,
			];
	}
	if($tipoUsuario == 'TecnicoProvincia'){
		$datoResporte[] = ($datosReporte+=[
			'rutaReporte' => 'RegistroCapacitaciones/vistas/reportes/reporteCapacitacionesTecnicoProvincia.jasper',
		]);
		$datosReporte['parametrosReporte'] = $parametrosReporte+= [
			'idProvincia' => $idProvincia,
			'nombreProvincia' => $nombreProvincia,
		];
	}
	 
		$link = 'certificado/' .  $idCoordinacion.$identificador. ".pdf";	
		$exists = is_file(REG_CAP_URL_CERT.$link);
	
	If ($exists) {
		unlink(REG_CAP_URL_CERT.$link);
	}

	$jasper->generarArchivo($datosReporte);
	$contenido = REG_CAP_URL.$link;

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>

<body>

<embed id="visor" src="<?php echo $contenido; ?>" width="540" height="500">

</body>

<script type="text/javascript">

</script>
</html>