<?php 
session_start();
if (isset($_SESSION['usuario'])){
	header('Location: index.php');
}
/*if($_GET['identificador'] != '1722551049'){
	header('Location: ../agrodbOut.html');
}*/

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Sistema GUIA - Pruebas</title>
<!-- link
	href='http://fonts.googleapis.com/css?family=Text+Me+One|Poiret+One|Open+Sans'	rel='stylesheet' type='text/css'-->
<script src="aplicaciones/general/funciones/agrdbfunc.js" type="text/javascript"></script>
<script src="aplicaciones/general/funciones/jquery-1.9.1.js" type="text/javascript"></script>



<link rel='stylesheet' href='aplicaciones/general/estilos/agrodb.css'>

</head>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-97784251-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-97784251-1');
</script>
<body>

	<form id="ingreso" data-rutaAplicacion="general" data-opcion="validar" data-accionEnExito="REDIRECCIONAR">
	 <div align="left" style="position: absolute;">
		<img src="aplicaciones/general/img/magapAct.png" width="90" height="85">
	</div>
	 <div align="right">
		<img src="aplicaciones/general/img/Agro.png" width="90" height="85">
	 </div>
		<table>
			<tr>
				<th><p>Ingreso a sistema GUIA - Pruebas</p></th>
			</tr>
			<tr>
				<td class="atencion"><a href="aplicaciones/publico/registroOperador/registroOperador.php">¿Representa
						usted a un operador o empresa? Regístrese aquí.</a>
				</td>
			</tr>
			<tr>
				<td>
					<img src="aplicaciones/general/img/user.png" width="19" height="24"> 
					<label>Usuario</label> <input id="identificador" name="identificador" type="text">
				</td>
			</tr>
			<tr>
				<td>
					<img src="aplicaciones/general/img/lock.png" width="19" height="24"> 
						<label>Contraseña</label> <input id="clave" name="clave" type="password">
					<a href="aplicaciones/publico/recuperarClave/validarDatos.php" target="_self" class="recuperarClave">Olvidó su contraseña o su usuario está inactivo</a>
				</td>
			</tr>
			<tr>
				<td align="center">
					<button id="submit" type="submit" disabled="disabled">Ingresar</button>
				</td>
			</tr>
			<tr>
				<td id="estado"></td>
			</tr>
			<tr>
				<td><div id="mapa"></div></td>
			</tr>



			<tr>
				<td class="acerca">
					<p align="center">Sistema Gestor Unificado de Información</p>
					<p align="center">Agrocalidad <?php echo date("Y")?></p>
					<p align="center">Gestión Tecnológica</p>
				</td>
			</tr>
		</table>
		<div></div>
	</form>
	
	<!--div id="popup" style="display: none;">
    	<div class="content-popup">	        
	        	<div>
		           <h2>Agrocalidad informa</h2>
		           <hr/>
					<div>
						<img class="estilo-popup-imagen" src="aplicaciones/general/img/informeAgrocalidad1.jpeg">
						<!--a href="https://www.agrocalidad.gob.ec/wp-content/uploads/2023/04/Tarifario-agrocalidad-2023.pdf" target="_blank"><img class="estilo-popup-imagen" src="aplicaciones/general/img/Importación-01.png"></a -->
						
					<!--/div>
							
		           <div style="text-align: center;">
		           		<button style = "text-align: center;" id="close" type="button" >Continuar</button>
		           </div>		           
	        	</div>
	    	</div>    
	</div-->

</body>
<script type="text/javascript">

//Revisa el tipo del navegador y su versión para habilitar el acceso
var isChrome = !!window.chrome;                          
var isIE = /*@cc_on!@*/false;                            

if (isChrome){ 
	  $("#submit").removeAttr("disabled");
	}

if (isIE){ 
	$("#submit").attr("disabled","disabled");
	$("#estado").html("Su navegador no es soportado por el Sistema Guía, y algunas funcionalidades no se ejecutarán correctamente. Le recomendamos instale la última versión de <a target='_blank' href='http://www.mozilla.org/es-ES/firefox/new/'>Firefox</a> ó <a target='_blank' href='https://www.google.com/intl/es-419/chrome/browser/?hl=es-419&brand=CHMI'>Google Chrome</a>").addClass("alerta");
	}

if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)){ 
	 var ffversion=new Number(RegExp.$1); 
	 if (ffversion>=20){
	  $("#submit").removeAttr("disabled");
	 }
	 else 
		$("#estado").html("La versión de su navegador no es soportada por el Sistema Guía, y algunas funcionalidades no se ejecutarán correctamente. Le recomendamos actualice <a target='_blank' href='http://www.mozilla.org/es-ES/firefox/new/'>su versión</a> o instale <a target='_blank' href='https://www.google.com/intl/es-419/chrome/browser/?hl=es-419&brand=CHMI'>Google Chrome</a>").addClass("alerta");
	}

/*function mostrarUbicacion(position){*/
	//$("#mapa").html("Latitud: " + posicion.coords.latitude + ", Longitud: " + posicion.coords.longitude);
	//$("#estado").html("Ingresando desde: " + position.address.city);
	//$("#submit").removeAttr("disabled");
	//$("#estado").html("Latitud: " + position.coords.latitude + ", Longitud: " + position.coords.longitude);
	//$("#mapa").parent().show();
	//var latlng = new google.maps.LatLng(-0.1891383, -78.4879849);
	/*var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);  
 	var myOptions = {  
		 zoom: 15,  
		 center: latlng,  
		 mapTypeControl: false,  
		 navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},  
		 mapTypeId: google.maps.MapTypeId.ROADMAP  
	 };  
 	var map = new google.maps.Map(document.getElementById("mapa"), myOptions);  
  
	 var marker = new google.maps.Marker({  
	 position: latlng,  
	 map: map,  
	 title:""  
	 });*/

	//$("#estado").html("latitud: "+position.coords.latitude+" y longitud: "+ position.coords.longitude + ". "+$_SERVER['REMOTE_ADDR']);
/*}*/

function error(error){
	$("#mapa").html("No se puede determinar su localización geográfica debido a '"+error.message+"' ("+error.code+")");
}

$(document).ready(function(){
	$("#mapa").parent().hide();
	
	$('#popup').fadeIn('slow');
	$('.popup-overlay').fadeIn('slow');
	$('.popup-overlay').height($(window).height());
	
	//$("#mapa").html(<?php echo $_SERVER['REMOTE_ADDR']?>);
	
	/*if (!( typeof navigator.geolocation == "undefined" || navigator.geolocation.shim )) {  
		 navigator.geolocation.getCurrentPosition(mostrarUbicacion, error,{enableHighAccuracy: true, maximumAge:60000, timeout: 4000});  
	} else {  
		$("#mapa").htm('Debe usar un navegador que soporte geolocalización');  
	}*/
	
	$(document).bind("contextmenu",function(e){
	   return false;
	});
	
	//$("#submit").attr("disabled","disabled");
});


$("#ingreso").submit(function(event){
	event.preventDefault();
	error = false;
	$(".alertaCombo").removeClass("alertaCombo");

	if($("#identificador").val()=="" || !$.trim($("#identificador").val())){
		error = true;		
		$("#identificador").addClass("alertaCombo");
	}

	if($("#clave").val()=="" || !$.trim($("#clave").val())){		
		error = true;
		$("#clave").addClass("alertaCombo");		
	}
	
	if (error){
		$("#estado").html("Por favor revise el formato de la información ingresada.").addClass('alerta');
	}else{	
	 event.preventDefault();
	 ejecutarJson($(this),new ingreso());
	}	
});

	function ingreso(){
	 this.ejecutar = function(msg) {
	  mostrarMensaje("Iniciando...","EXITO");
	 };
	}
	
$('#close').click(function(){
    $('#popup').fadeOut('slow');
    $('.popup-overlay').fadeOut('slow');
});
</script>
</html>
