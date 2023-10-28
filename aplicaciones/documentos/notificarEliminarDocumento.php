<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorDocumentos.php';

$conexion = new Conexion();
$cd = new ControladorDocumentos();

$identificadorUsuarioRegistro = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

</head>
<body>

<header>
	<h1>Confirmar eliminación</h1>
</header>

<div id="estado"></div>

	<p>El <b>documento</b> a ser eliminado es: </p>
	
	<?php
	
	$documentos = explode(",",$_POST['elementos']);
	
	$res = $cd->abrirDocumento($conexion, $documentos[0]);
		$documento = pg_fetch_assoc($res);
	
	echo '<fieldset><legend>Documentos Jurídicos</legend>';
		echo '<div><b>Código Documento: </b>' .$documento['id_documento'].' <br /><b>Asunto: </b>' .$documento['asunto'].' '.($documento['estado']=='1'?(strpos($documento['id_documento'], 'TMP-')== true ?'<div id="eliminar"></div>':''):'<div id="nEliminar" class="alerta">No se puede eliminar un documento con numeración.</div>').'  </div>';	
	echo'</fieldset>';
	?>
	
 

<form id="notificarEliminarDocumento" data-rutaAplicacion="documentos" data-opcion="eliminarDocumento" data-accionEnExito="ACTUALIZAR" >

	<input type='hidden' id='identificador' name='identificador' value="<?php echo $identificadorUsuarioRegistro;?>" />
	
	<fieldset>
		<legend>Observación</legend>

		<div data-linea="1">
			<textarea id="observacion" name="observacion"></textarea>
		</div>
	</fieldset>
			<input type="hidden" name="id" value="<?php echo $documento['id_documento'];?>"/>
							
	 <button id="eliminar" type="submit" class="eliminar" >Eliminar documento</button>
	
</form>

</body>

<script type="text/javascript">

var array_documento= <?php echo json_encode($documentos); ?>;			

$("#notificarEliminarDocumento").submit(function(event){

	 if($("#observacion").val()=="") {
	    	$("#observacion").focus();
	    	$("#observacion").addClass("alertaCombo");
	        alert("Debe ingresar una observación");
	        return false;
	  }else{
		  	event.preventDefault();
			ejecutarJson($(this));
	  }
});


$(document).ready(function(){

	distribuirLineas();
	construirValidador();

	if(array_documento == ''){
		$("#detalleItem").html('<div class="mensajeInicial">Seleccione un documento.</div>');
	}

	if($("#nEliminar").text()){
		$("#notificarEliminarDocumento").hide();
	}

});

</script>

</html>
