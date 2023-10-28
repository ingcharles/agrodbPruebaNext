<?php
	session_start();
	require_once '../../clases/Conexion.php';
	require_once '../../clases/ControladorVacaciones.php';
	require_once '../../clases/ControladorAreas.php';

	
	$conexion = new Conexion();
	$cv = new ControladorVacaciones();
	$ca = new ControladorAreas();
	
	$area = $ca->obtenerAreasDireccionesTecnicas($conexion, "('Planta Central','Oficina Técnica')", "(3,4,1)");
	
	$tipoPermiso = $cv->obtenerTipoPermiso($conexion);
	
	$subtipos = $cv->obtenerSubTipoPermiso($conexion);
	
	while ($fila = pg_fetch_assoc($subtipos)){
		$resTipos[] = array('id_subtipo_permiso'=>$fila['id_subtipo_permiso'],'nombre'=>$fila['descripcion_subtipo'],
				'minutos'=>$fila['minutos_permitidos'],'id_tipo_permiso'=>$fila['id_tipo_permiso'],
				'requiere_adjunto'=>$fila['requiere_adjunto'],'presentacion_reintegro'=>$fila['presentacion_despues_reintegro'],
				'detalle_permiso'=>$fila['detalle_permiso'], 'codigo'=>$fila['codigo']);
	}
		
?>

<header>

	<h1>Histórico vacaciones</h1>

	<nav>
	
	<form id="listarHistoricoVacaciones" data-rutaAplicacion="vacacionesPermisos" data-opcion="listaHistoricoVacaciones" data-destino="tabla">
		
		<table class="filtro">
		
			<tr>
				<th>Cédula:</th>
					<td>
						<input id="identificador" name="identificador" type="text"  style="width: 100%;"/>
					</td>
					
				<th>Estado:</th>
					<td>
						<select id="estadoVacacion" name="estadoVacacion" style="width: 100%;">
							<option value="" selected="selected">Selecione....</option>
							<option value="Aprobado">Aprobados</option>
							<option value="creado">Creados</option>
							<option value="InformeGenerado">Acción de personal generada</option>
							<option value="Rechazado">Rechazados</option>							
						</select>
					</td>	
			</tr>
			
			<tr>
				<th>Apellidos:</th>
					<td>
						<input id="apellidoUsuario" name="apellidoUsuario" type="text"  style="width: 100%;"/>
					</td>
				<th>Nombres:</th>
					<td>
						<input id="nombreUsuario" name="nombreUsuario" type="text"  style="width: 100%;"/>
					</td>		
			</tr>
			
			<tr>
				<th>Fecha inicio:</th>
					<td>
						<input id="fechaInicio" name="fechaInicio" type="text"  style="width: 100%;" readonly="readonly" />
					</td>
				<th>Fecha fin:</th>
					<td>
						<input id="fechaFin" name="fechaFin" type="text"  style="width: 100%;" readonly="readonly" />
					</td>		
			</tr>
			
			<tr>
				<th>Tipo permiso:</th>
					<td colspan="3">
						<select id="tipoSolicitud" name="tipoSolicitud" style="width: 100%;">
							<option value="" selected="selected">Seleccione....</option>
							<?php 
								while($fila = pg_fetch_assoc($tipoPermiso)){
									echo '<option value="' . $fila['id_permiso'] . '">' . $fila['descripcion_permiso'].' </option>';
								}			
							?>
						</select>
					</td>
			</tr>
			
			<tr id="tSubTipoPermiso">
				<th>Subtipo producto:</th>
					<td colspan="3">
						<select id="subtipoPermiso" name="subtipoPermiso" style="width: 100%;">
						</select>
					</td>
			</tr>
			
			<tr>
				<th>Área pertenece</th>
					<td colspan="3">
						<select id="area" name="area" style="width: 100%;">
							<option value="" selected="selected">Área....</option>
							<?php 
								while($fila = pg_fetch_assoc($area)){
									echo '<option value="' . $fila['id_area'] . '">' . $fila['nombre'] . '</option>';
								}			
							?>
						</select>
					</td>
			</tr>
								
			<tr>	
				<td colspan="5">
					<button>Filtrar</button>
				</td>
			</tr>

		</table>
		
	</form>
		
	</nav>

</header>

<div id="tabla"></div>

<script type="text/javascript">

var array_subTipos= <?php echo json_encode($resTipos); ?>;

$(document).ready(function(){

	$("#tSubTipoPermiso").hide();
	
	$("#fechaInicio").datepicker({
	    changeMonth: true,
	    changeYear: true,
	    onSelect: function(dateText, inst) {
	    	$('#fechaFin').datepicker('option', 'minDate', $("#fechaInicio" ).val()); 
	    }
	  });

	$("#fechaFin").datepicker({
	    changeMonth: true,
	    changeYear: true
	  });
		
});							

$("#listarHistoricoVacaciones").submit(function(event){

	event.preventDefault();
	$(".alertaCombo").removeClass("alertaCombo");
	var error = false; 

	if($("#fechaInicio").val()==""){	
		error = true;		
		$("#fechaInicio").addClass("alertaCombo");
	}

	if($("#fechaFin").val()==""){	
		error = true;		
		$("#fechaFin").addClass("alertaCombo");
	}

	if (!error){
		event.preventDefault();
		abrir($(this),event,false);
	}
	
});

$("#tipoSolicitud").change(function(){
	
	$("#tSubTipoPermiso").show();	
	subTiposPermisos = '<option value="" selected="selected">Seleccione....</option>';
	
	for(var i=0;i<array_subTipos.length;i++){
		if ($("#tipoSolicitud").val()==array_subTipos[i]['id_tipo_permiso']){
			subTiposPermisos += '<option value="'+array_subTipos[i]['id_subtipo_permiso']+'" data-minutos="'+array_subTipos[i]['minutos']+'" data-detalle="'+array_subTipos[i]['detalle_permiso']+'" data-codigo="'+array_subTipos[i]['codigo']+'">'+array_subTipos[i]['nombre']+'</option>';
		}
	}
	
	$('#subtipoPermiso').html(subTiposPermisos);
});	

</script>	

	