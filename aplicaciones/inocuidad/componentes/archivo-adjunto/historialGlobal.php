<?php
/**
 * Created by IntelliJ IDEA.
 * User: antonio
 * Date: 21/02/18
 * Time: 10:05
 */
require_once "../../Util.php";
$util = new Util();
?>
<meta charset="utf-8">
<link href="aplicaciones/inocuidad/componentes/archivo-adjunto/estilos/globaladjunto.css" rel="stylesheet"/>

<script src="aplicaciones/inocuidad/componentes/archivo-adjunto/js/globalHistorial.js"/>
<div id="file_dialog">
<div id="dataTable"></div>
    <div id="formContent"></div>
</div>

<script>
    $("#formContent").load("aplicaciones/inocuidad/componentes/archivo-adjunto/historialFile.php");
</script>
