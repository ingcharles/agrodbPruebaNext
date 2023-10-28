<?php
/**
 * Created by IntelliJ IDEA.
 * User: antonio
 * Date: 24/01/18
 * Time: 22:12
 */
 
 require_once '../../../../clases/Constantes.php';
 
 $constg = new Constantes();
 
$_SESSION['_ABSPATH_']=$_SERVER['DOCUMENT_ROOT'] . '/'.$constg::RUTA_APLICACION.'/';

?>

<script src="aplicaciones/inocuidad/componentes/archivo-adjunto/js/historialForm.js"/>
<form  id="Form" method="POST" enctype="multipart/form-data">
   <input type="hidden" value="" id="adjunto_tabla" name="adjunto_tabla">
    <input type="hidden" value="" id="adjunto_registro" name="adjunto_registro">
</form>