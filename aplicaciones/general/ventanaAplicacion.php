<?php 
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorAreas.php';
require_once '../../clases/ControladorAplicaciones.php';
require_once '../../clases/ControladorUsuarios.php';
require_once '../../clases/ControladorCatastro.php';
require_once '../../clases/ControladorVacaciones.php';													  

$conexion = new Conexion();
$cu = new ControladorUsuarios();
$ca = new ControladorAreas();
$cv = new ControladorVacaciones();								  

$identificadorUsuario = $_SESSION['usuario'];

$qDatoEmpleado = $cu->obtenerDatosEmpleado($conexion, $identificadorUsuario);
$datoEmpleado = pg_fetch_assoc($qDatoEmpleado);
$idLocalizacion = $datoEmpleado['id_localizacion'];
$idProvincia = $datoEmpleado['id_provincia'];
$nombreLocalizacion = $datoEmpleado['nombre_localizacion'];
$codigoLocalizacion = $datoEmpleado['codigo_localizacion'];
$nombreProvincia = $datoEmpleado['nombre_provincia'];
$_SESSION['idGestion'] = $datoEmpleado['id_gestion'];
												 

$areaUsuario = pg_fetch_assoc($ca->areaUsuario($conexion, $identificadorUsuario));

$_SESSION['idLocalizacion'] = $idLocalizacion ;
$_SESSION['nombreLocalizacion'] = $nombreLocalizacion;
$_SESSION['codigoLocalizacion'] = $codigoLocalizacion;
$_SESSION['idAplicacion'] = $_POST["idAplicacion"];
$_SESSION['idProvincia'] = $idProvincia;
$_SESSION['nombreProvincia'] = $nombreProvincia;
$_SESSION['idArea'] = $areaUsuario['id_area'];
$_SESSION['idGestion'] = $datoEmpleado['id_gestion'];
$_SESSION['datosUsuario'] = $datoEmpleado['dato_usuario'];

$qPermiso=$cv->obtenerPermisosCreados($conexion, $_SESSION['idArea']);
				   
$datoPermiso = pg_fetch_assoc($qPermiso);
$isAprovedAS =  $datoPermiso['existe'];

$qDatoUsuaro = $cu->verificarUsuario($conexion, $identificadorUsuario);
$datoUsuario = pg_fetch_assoc($qDatoUsuaro);
$aceptarPolitica = $datoUsuario['aceptar_politica'];

?>

<nav id="opcionesAplicacion">
	<h1>
		<?php echo $_POST["nombre"];?>
	</h1>
	<div>
		<?php 
		$ca = new ControladorAplicaciones();
		$res = $ca->obtenerOpcionesAplicacion($conexion, $_SESSION['idAplicacion'],$identificadorUsuario);
		
		if($aceptarPolitica == "t"){
		
    		while($fila = pg_fetch_assoc($res)){
    			echo '<a
    				href="#" id="' . $fila['estilo'] . '"
    				data-destino="areaTrabajo #listadoItems"
    				data-rutaAplicacion="' .(isset($fila['ruta_mvc']) ?  $fila['ruta_mvc'] : $_POST['app']). '"
    				data-idOpcion="' .$fila['id_opcion']. '"
    				data-opcion="' . $fila['pagina'] . '"
    				data-flujo = "'.$fila['id_flujo'].'"';
    			if($fila['nivel']=='1'){
                    echo'data-nivel = "'.$fila['nivel'].'"
                        data-padre = "'.$fila['id_padre'].'" style="padding-left: 50px !important;"';
    			}
    			if($fila['nivel']=='0'){
    			    echo'data-nivel = "'.$fila['nivel'].'"
    			    onmousedown="desplegarMenu(this)" style="background: #4f4f4f; padding-left: 35px !important;"';
    			}
    		   echo'data-nombre = "'.$fila['nombre_opcion'].'">' . $fila['nombre_opcion'] . '</a>';
    		}
		
		}
		?>
	</div>
</nav>
<section id="areaTrabajo">
	<section id="listadoItems"></section>
	<section id="detalleItem" ondragover="allowDrop(event)" ondrop="drop(event)"></section>
</section>

<?php 
if($aceptarPolitica == "f"){?>

    <div id="popup" style="display: none;">
    	<div class="content-popup">	        
            	<div>
    	           <h2>Aviso de uso y tratamiento de datos personales</h2>
    	           <hr/>
        			<div style="text-align:justify;">
        				En cumplimiento con lo dispuesto por la Ley Orgánica de Protección de Datos Personales (Art. 66), la Agencia de Regulación y Control Fito y Zoosanitario - AGROCALIDAD, pone en su conocimiento, que almacenará los datos que usted proporcione a través del sistema GUIA y aplicación móvil AGROSERVICIOS.  En ese sentido, usted otorga su consentimiento (Art. 8) voluntario, libre, previo, expreso, específico,  informado, e inequívoco a la Agencia de Regulación y Control Fito y Zoosanitario - AGROCALIDAD, para que realice el tratamiento (Art. 33), en cualquiera de sus modalidades, medios o soportes, de la información y los datos personales y de identificación que usted haya podido proporcionar para el uso de la Agencia de Regulación y Control Fito y Zoosanitario -  AGROCALIDAD acorde a las competencias estatutarias de cada Coordinación.       				
        			</div>
        			<hr/>						
    	           <div style="text-align: center;">
    	           		<button style = "text-align: left;" id="aceptarPoliticas" type="button">Aceptar</button>
    	           		<button style = "text-align: right; background-color:red;" id="salirGuia" type="button" >Salir</button>
    	           </div>		           
            	</div>
        	</div>    
    </div>
<?php } ?>

<script type="text/javascript">

var app = <?php echo json_encode($_POST['app']); ?> ;
var isAprovedAS = <?php echo json_encode($isAprovedAS); ?>;		 

	$("document").ready(function(event){	
		
		$('#popup').fadeIn('slow');
    	$('.popup-overlay').fadeIn('slow');
    	$('.popup-overlay').height($(window).height());
		
		if( app != 'general'){

			var n = app.indexOf("mvc");
			if(n==0){
				$("head").append("<link rel='stylesheet' href='aplicaciones/<?php  echo str_replace("mvc","mvc/modulos", $_POST['app']); ?>/vistas/estilos/estiloapp.css'>");
			}else{
				$("head").append("<link rel='stylesheet' href='aplicaciones/<?php  echo $_POST['app']; ?>/estilos/estiloapp.css'>");
			}
		}
		
		var validarMenuDesplegable = false;
	 	$("#opcionesAplicacion div a").each(function(){
	
	    	if($(this).attr("data-nivel")){   
		    	     
	        	if($(this).attr("data-nivel")=="0"){
	        		validarMenuDesplegable=true;
	        		var elemento = "#"+$(this).attr("id");
	        		$(elemento).unbind('click');
		           	$(elemento).removeAttr("data-destino");
	                $(elemento).removeAttr("data-rutaaplicacion");
	                $(elemento).removeAttr("data-opcion");
	                $(elemento).removeAttr("data-flujo");
	                $(elemento).removeAttr("data-nombre");
	                
	                if(!$(elemento).attr("status")){
	                	cerrarMenu(elemento);
	                }
	            }	
	        }   

			var opcion = "#"+$(this).attr("id");

			if( app =="vacacionesPermisos" && opcion=="#__autorizacionSolicitudes" && isAprovedAS==1 )/* || (opcion=="#__autorizarPlanificacionVacaciones" && isAprovedAPV)))*/{
				colors = ['#ef3e56', '#c7c7c7' ];
				var i = 0;
				animate_loop = function() {      
				$(opcion).addClass('abiertoColor');
				$('.abiertoColor').animate({backgroundColor:colors[(i++)%colors.length]
					}, 700, function(){
						animate_loop();
					});
				};
				animate_loop();			
			}
	    });	
		
		if(validarMenuDesplegable){
		 	$("#listadoItems").html('<div class="mensajeInicial">Seleccione una opción para revisarla.</div>');
	    }else{
			abrir($("#opcionesAplicacion div a").first(),"",true);
			$("title").html($("#opcionesAplicacion div a").first().attr('data-nombre'));
		}
		
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aquí un item para revisarlo.</div>');
		$("#listadoItems").removeClass("programas");
		crearBarraResize();	
	
	});
	
	$("#aceptarPoliticas").click(function () {
	        
        $.post("aplicaciones/general/politicaUsoDatos.php", function (data) {
            if (data.validacion === 'Exito') {
        		document.location.href = 'index.php';
   			}          
        }, 'json');	    

	});
	
	$("#salirGuia").click(function () {
		document.location.href = 'salir.php';
	});
	
	
	
</script>
