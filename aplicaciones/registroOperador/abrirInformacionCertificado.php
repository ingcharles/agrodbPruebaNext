<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>


<form
id="nuevoDocumento"
data-rutaAplicacion="registroOperador"
data-opcion="guardarDocumento"
data-destino="detalleItem">

	<fieldset>
		<legend>Representante técnico</legend>
		<div data-linea="1">
			<label>Número de productores</label>
			<input type="text" id="num_productores" name="num_productores"/>
		</div>
	</fieldset>

	<fieldset>
		<legend>Información del certificado orgánico nacional</legend>
		<div data-linea="2">
			<label>Número de certificado:</label>
			<input type="text" id="num_productores" name="num_productores"/>
		</div>
		<div data-linea="3">
			<label>Fecha de la última inspección:</label>
			<input type="text" id="fecha_ultima_inspeccion" name="fecha_ultima_inspeccion"/>
		</div>
		<div data-linea="4">
			<label>Fecha de certificación primera vez:</label>
			<input type="text" id="fecha_primera_certificacion" name="fecha_primera_certificacion"/>
		</div>
		<div data-linea="5">
			<label>Fecha de aniversario:</label>
			<input type="text" id="fecha_aniversario" name="fecha_aniversario"/>
		</div>
		<div data-linea="6">
			<label>Fecha de certificación vigilancia:</label>
			<input type="text" id="fecha_vigilancia_certificacion" name="fecha_vigilancia_certificacion"/>
		</div>
		<div data-linea="7">
			<label>Fecha de certificación renovación:</label>
			<input type="text" id="fecha_renovacion_certificacion" name="fecha_renovacion_certificacion"/>
		</div>
		<div data-linea="8">
			<label>Fecha de caducidad:</label>
			<input type="text" id="fecha_caducidad" name="fecha_caducidad"/>
		</div>
	</fieldset>

	<fieldset>
		<legend>Otros certificados orgánicos</legend>
		<div data-linea="9">
			<label>¿Posee otras certificaciones orgánicas?	</label>
			<label>	Si
				<input type="radio" id="otras_certificaciones_si" name="otras_certificaciones" value="Si" />
			</label>
			<label>	No
				<input type="radio" id="otras_certificaciones_no" name="otras_certificaciones" value="No" />
			</label>
		</div>

		<div data-linea="10">
			<label>USDA - NOP</label>
			<input type="checkbox" id="usda_nop" name="usda_nop"/>
			<input type="hidden" class="rutaArchivo" name="rutaArchivo" value="0"/>
			<input type="file" class="archivo" accept="application/msword | application/pdf | image/*" disabled/>
			<div class="estadoCarga">En espera de archivo... (Tamaño máximo <?php echo ini_get('upload_max_filesize'); ?>B)</div>
			<button type="button" class="subirArchivo adjunto" data-rutaCarga="aplicaciones/registroOperador/anexos" disabled>Subir archivo</button>
		</div>

		<div data-linea="11">
			<label>UE -2018/848</label>
			<input type="checkbox" id="ue_2018/848" name="ue_2018/848"/>
			<input type="hidden" class="rutaArchivo" name="rutaArchivo" value="0"/>
			<input type="file" class="archivo" accept="application/msword | application/pdf | image/*" disabled/>
			<div class="estadoCarga">En espera de archivo... (Tamaño máximo <?php echo ini_get('upload_max_filesize'); ?>B)</div>
			<button type="button" class="subirArchivo adjunto" data-rutaCarga="aplicaciones/registroOperador/anexos">Subir archivo</button>
		</div>

		<div data-linea="12">
			<label>JAS</label>
			<input type="checkbox" id="jas" name="jas"/>
			<input type="hidden" class="rutaArchivo" name="rutaArchivo" value="0"/>
			<input type="file" class="archivo" accept="application/msword | application/pdf | image/*" disabled/>
			<div class="estadoCarga">En espera de archivo... (Tamaño máximo <?php echo ini_get('upload_max_filesize'); ?>B)</div>
			<button type="button" class="subirArchivo adjunto" data-rutaCarga="aplicaciones/registroOperador/anexos">Subir archivo</button>
		</div>

		<div data-linea="13">
			<label>SUIZA</label>
			<input type="checkbox" id="suiza" name="suiza"/>
			<input type="hidden" class="rutaArchivo" name="rutaArchivo" value="0"/>
			<input type="file" class="archivo" accept="application/msword | application/pdf | image/*" disabled/>
			<div class="estadoCarga">En espera de archivo... (Tamaño máximo <?php echo ini_get('upload_max_filesize'); ?>B)</div>
			<button type="button" class="subirArchivo adjunto" data-rutaCarga="aplicaciones/registroOperador/anexos">Subir archivo</button>
		</div>

		<div data-linea="14">
			<label>CANADÁ</label>
			<input type="checkbox" id="canada" name="canada"/>
			<input type="hidden" class="rutaArchivo" name="rutaArchivo" value="0"/>
			<input type="file" class="archivo" accept="application/msword | application/pdf | image/*" disabled/>
			<div class="estadoCarga">En espera de archivo... (Tamaño máximo <?php echo ini_get('upload_max_filesize'); ?>B)</div>
			<button type="button" class="subirArchivo adjunto" data-rutaCarga="aplicaciones/registroOperador/anexos">Subir archivo</button>
		</div>

		<div data-linea="15">
			<label>Otros</label>
			<input type="checkbox" id="otros" name="otros"/>
			<label>Especifique</label>
			<input type="text" id="especifique_otros" name="especifique_otros" disabled="true">
			<input type="hidden" class="rutaArchivo" name="rutaArchivo" value="0"/>
			<input type="file" class="archivo" accept="application/msword | application/pdf | image/*" disabled/>
			<div class="estadoCarga">En espera de archivo... (Tamaño máximo <?php echo ini_get('upload_max_filesize'); ?>B)</div>
			<button type="button" class="subirArchivo adjunto" data-rutaCarga="aplicaciones/registroOperador/anexos">Subir archivo</button>	
		</div>

		<div data-linea="16">
			<button style="text-align: center;">Agregar</button>
		<div>
	</fieldset>

	<fieldset>
		<legend>Otros certificados orgánicos agregados</legend>

		<table id="certificadosAgregados" width="100%" >
			<thead>
				<tr>
					<th>#</th>
					<th>Certificado orgánico</th>
					<th>Opciones</th>
				<tr>
			</thead> 
			<tbody>
				<tr id="R">	 
				 <td align="center">1</td>
				 <td align="center">USDA - NOP</td>
				 <td align="center">
					 <input type="hidden" name="tipoAgregado" value=" 1" >
					 <input type="hidden" name="rutaCertificadoAgregado" value=" 2" >
					 <input type="hidden" name="especifiqueAgregado" value=" 3" >
					 <button type="button" class="menos">Eliminar</button>
				 </td>
				 </tr>
			</tbody>
		</table>

	</fieldset>

	<button>Enviar información del certificado</button>
</form>

</body>
</html>



<script type="text/javascript">
	
$('#num_productores').numeric();

$("input[type='checkbox']").on("change", function () 
{
    var archivoInput = $(this).siblings(".archivo");
    if ($(this).prop("checked")) 
    {
      archivoInput.prop("disabled", false);
    } else 
    {
      archivoInput.prop("disabled", true);
    }
 });

$("[id^='fecha']").datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: "yy-mm-dd"
});

$("button.subirArchivo").click(function (event) {
	nombre_archivo = "<?php echo $usuario . (md5(time())); ?>";
    var boton = $(this);
    var archivo = boton.parent().find(".archivo");
    var rutaArchivo = boton.parent().find(".rutaArchivo");
    var extension = archivo.val().split('.');
    var estado = boton.parent().find(".estadoCarga");
    if (extension[extension.length - 1].toUpperCase() == 'PDF') {
        subirArchivo(
            archivo
            , nombre_archivo
            , boton.attr("data-rutaCarga")
            , rutaArchivo
            , new carga(estado, archivo, boton)
        );
    } else {
        estado.html('Formato incorrecto, solo se admite archivos en formato PDF');
        archivo.val("");
    }
});

function carga(estado, archivo, boton) {
    this.esperar = function (msg) {
        estado.html("Cargando el archivo...");
        archivo.addClass("amarillo");
    };
    this.exito = function (msg) {
        estado.html("El archivo ha sido cargado.");
        archivo.removeClass("amarillo");
        archivo.addClass("verde");
        boton.attr("disabled", "disabled");
        $("#nuevoDocumento :submit").removeAttr("disabled");
    };
    this.error = function (msg) {
        estado.html(msg);
        archivo.removeClass("amarillo");
        archivo.addClass("rojo");
    };
}


</script>