<?php 
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorRegistroOperador.php';
require_once '../../clases/ControladorAplicaciones.php';


$conexion = new Conexion();
$ca = new ControladorAplicaciones();
$cr = new ControladorRegistroOperador();


$tipoSolicitud = htmlspecialchars ($_POST['solicitudes'],ENT_NOQUOTES,'UTF-8');
$estado = htmlspecialchars ($_POST['estados'],ENT_NOQUOTES,'UTF-8');
$opcion = htmlspecialchars ($_POST['opcion'],ENT_NOQUOTES,'UTF-8');
$identificadorOperador = htmlspecialchars ($_POST['identificadorOperador'],ENT_NOQUOTES,'UTF-8');
$estadoActual = htmlspecialchars ($_POST['estadoActual'],ENT_NOQUOTES,'UTF-8');

$identificador = $_SESSION['usuario'];
//$provincia = $_SESSION['nombreProvincia'];
$provincia = $_POST['provincia'];

$condicion = 'Financiero';


$contador = 0;
$itemsFiltrados[] = array();

	echo'<header> <nav>';
			$res = $ca->obtenerAccionesPermitidas($conexion, $opcion, $identificador);
			while($fila = pg_fetch_assoc($res)){
				
				if($fila['estilo'] != '_agrupar' || $estado != 'verificacion'){
					
					echo '<a href="#"
						id="' . $fila['estilo'] . '"
						data-destino="detalleItem"
						data-opcion="' . $fila['pagina'] . '"
						data-rutaAplicacion="' . $fila['ruta'] . '"
						>'.(($fila['estilo']=='_seleccionar')?'<div id="cantidadItemsSeleccionados">0</div>':''). $fila['descripcion'] . '</a>';
				}
				
			}
	echo'</nav></header>';
	
	//Elección de tipo de formulario para impresión
	
	switch ($tipoSolicitud){
		
		case 'Operadores' :
			
			if($estado == 'pago'){
				
				$qSitios = $cr->obtenerSolicitudesOperadores($conexion, $provincia, $estado, 'SITIOS',$estadoActual,$tipoSolicitud,$identificadorOperador);
				$qOperadores = $cr->obtenerSolicitudesOperadores($conexion, $provincia, $estado, 'OPERACIONES',$estadoActual,$tipoSolicitud,$identificadorOperador);
				
				while($sitio = pg_fetch_assoc($qSitios)){
					echo '<div id="'.$sitio['id_sitio'].'">
						<h2>'.$sitio['nombre_lugar'].'</h2>
						<div class="elementos"></div>
					</div>';
				}
				

				$contador = 0;
				while($operacion = pg_fetch_assoc($qOperadores)){
					$categoria = $operacion['id_sitio'];
					$contenido = '<article
							id="'.$operacion['id_operacion'].'"
							class="item"
							data-rutaAplicacion="registroOperador"
							data-opcion="abrirOperacionFinancieroGrupo"
							ondragstart="drag(event)"
							draggable="true"
							data-destino="detalleItem">
							<span class="ordinal">'.++$contador.'</span>
							<span> # '.$operacion['id_operacion'].'</span><br />
							<span> Operación: '.$operacion['nombre'].'<br />
							<span> Producto: '.$operacion['nombre_producto'].'</span>
							<aside>'.date('j/n/Y',strtotime($operacion['fecha_creacion'])).'</aside>
					</article>';
			?>
					<script type="text/javascript">
						var contenido = <?php echo json_encode($contenido);?>;
						var categoria = <?php echo json_encode($categoria);?>;
						$("#"+categoria+" div.elementos").append(contenido);
					</script>
			<?php					
					}
				
			}else{
				
				$qOperadores = $cr->obtenerOperadorFinancieroVerificacion($conexion, $identificadorOperador, $estado, $provincia, $tipoSolicitud);
				
				while($operacion = pg_fetch_assoc($qOperadores)){

					echo  '<article
							id="'.$operacion['id_solicitud'].'"
							class="item"
							data-rutaAplicacion="registroOperador"
							data-opcion="abrirOperacionFinancieroGrupo"
							ondragstart="drag(event)"
							draggable="true"
							data-destino="detalleItem"
							data-nombre= "'.$operacion['id_grupo'].'">
							<span class="ordinal">'.++$contador.'</span>
							<span> # '.$operacion['id_solicitud'].'</span><br />
							<aside>'.$operacion['identificador_operador'].'</aside>
					</article>';
					
				}
				
			}
									
		break;
			
		default :
			echo 'Formulario desconocido';
		break;
		
	}
	
	
	
	?>

<script type="text/javascript"> 

	$("#listadoItems").addClass("comunes");
	$('#_agrupar').attr('data-rutaaplicacion','registroOperador');
	$('#_agrupar').attr('data-opcion','abrirOperacionFinancieroGrupo');
	
</script>

