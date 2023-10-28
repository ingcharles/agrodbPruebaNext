<?php 

//require_once 'administrarArchivoFTP.php';

//$cFTP = new administrarArchivoFTP();
//$cFTP->obtenerArchivo();

?>

	<fieldset class="soloPantalla">
		<legend>Bajar Archivo</legend>
			<form id="subirArchivo" action="documento.php" method="post" enctype="multipart/form-data" target="_blank">
				<input name="archivoVUE" value="2014/01/22/11/2014-0000000000000000000000000001769_FLUJO.pdf" type="hidden"/>
				<input name="nombreArchivo" value="Nombre uno.pdf" type="hidden"/>
				<button type="submit" name="boton">Subir Archivo</button>
			</form>
	</fieldset>

