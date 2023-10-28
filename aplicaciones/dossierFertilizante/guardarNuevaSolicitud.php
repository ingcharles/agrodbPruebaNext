<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorRegistroOperador.php';

require_once '../../clases/ControladorEnsayoEficacia.php';
require_once '../../clases/ControladorDossierFertilizante.php';

$idUsuario= $_SESSION['usuario'];
$id_solicitud = $_POST['id_solicitud'];

$conexion = new Conexion();
$cr = new ControladorRegistroOperador();
$ce = new ControladorEnsayoEficacia();
$cf=new ControladorDossierFertilizante();

$dato['identificador'] = $idUsuario;
$dato['tipo_producto'] = htmlspecialchars ($_POST['tipo_producto'],ENT_NOQUOTES,'UTF-8');
$dato['direccion_referencia'] = htmlspecialchars ($_POST['dirReferencia'],ENT_NOQUOTES,'UTF-8');
$dato['ci_representante_legal'] = htmlspecialchars ($_POST['ciLegal'],ENT_NOQUOTES,'UTF-8');
$dato['email_representante_legal'] = htmlspecialchars ($_POST['correoLegal'],ENT_NOQUOTES,'UTF-8');


$dato['id_sitio'] = htmlspecialchars ($_POST['id_sitio'],ENT_NOQUOTES,'UTF-8');
$dato['id_area'] = htmlspecialchars ($_POST['id_area'],ENT_NOQUOTES,'UTF-8');
$dato['ci_representante_tecnico'] = htmlspecialchars ($_POST['ci_representante_tecnico'],ENT_NOQUOTES,'UTF-8');
$dato['objetivo'] = htmlspecialchars ($_POST['objetivo'],ENT_NOQUOTES,'UTF-8');
$dato['clon_registro_madre'] = htmlspecialchars ($_POST['clon_registro_madre'],ENT_NOQUOTES,'UTF-8');
$dato['declaracion_juramentada'] = htmlspecialchars ($_POST['declaracion_juramentada'],ENT_NOQUOTES,'UTF-8');
$dato['nivel']=intval($_POST['nivel']);


if($id_solicitud==null || $id_solicitud=='_nuevo'){

	try{

		$res=$cf->guardarSolicitud($conexion,$dato);
		if($res['tipo']=="insert"){
			$id_solicitud = $res['resultado'][0]['id_solicitud'];
		}
	}catch(Exception $e){}

}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />

</head>
<body>

	<header>
		<h1>Guardando solicitud de dossier fertilizante</h1>
	</header>

	<div id="estado"></div>

	<form id="frmGuardar" data-rutaAplicacion="dossierFertilizante" data-opcion="abrirSolicitudDossier" data-destino='detalleitem' data-accionEnExito="ACTUALIZAR">
		<input type="hidden" id="id" name="id" value="<?php echo $id_solicitud;?>" />
		<input type="hidden" id="id_protocolo" name="id_protocolo" value="<?php echo $id_solicitud;?>" />
		<fieldset>
			<legend>Importante...</legend>
			<label>La solicitud ha sido creada con el codigo temporal :</label>
			<input value="<?php echo $id_solicitud.' '; ?>" disabled="disabled" />
			<label>
				tiene 15 días para completar el formulario y enviarlo
			</label>

		</fieldset>

		<button id="btnGuardar" type="button" class="guardar">Regresar</button>
	</form>

</body>


<script type="text/javascript">

	var $id_solicitud= <?php echo json_encode($id_solicitud); ?>;

	$(document).ready(function(){

});

$('#btnGuardar').click(function (event) {
	event.preventDefault();

	var form=$(this).parent();

	form.attr('data-opcion', 'abrirSolicitudDossier');
	form.attr('data-destino', 'detalleItem');
	
	$("#estado").html("");
	abrir(form, event, true); 
	abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"), null, true);
});


</script>

</html>