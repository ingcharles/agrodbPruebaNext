<?php
/**
 * Created by IntelliJ IDEA.
 * User: antonio
 * Date: 31/01/18
 * Time: 21:21
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../controladores/ControladorCatalogosInc.php';
require_once '../controladores/ControladorLmr.php';

$ic_lmr_id = $_POST['id'];

$controladorCatalogos = new ControladorCatalogosInc();
$parametrosCatalogo=$controladorCatalogos->obtenerComboCatalogosOpciones("PARAMETROS");

$controladorLmr= new ControladorLmr();
$lmr = $ic_lmr_id=='_nuevo'?null:$controladorLmr->getLmr($ic_lmr_id);
$ic_lmr_id = $ic_lmr_id=='_nuevo'?null:$ic_lmr_id;
?>
<!DOCTYPE html>
<html>
<head>
    <script src="aplicaciones/inocuidad/js/inocuidad_root.js" type="text/javascript"/>
    <meta charset="utf-8">

</head>
<body>
<header>
    <h1>Detalle LMRs</h1>
</header>
<div id="estado"></div>
<table class="soloImpresion">
    <tr>
        <td>
            <form id="editarLmr" data-rutaAplicacion="inocuidad" data-opcion="controladores/editarLmr" >
                <input type="hidden" id="ic_lmr_id" name="ic_lmr_id" value="<?php echo $ic_lmr_id;?>">
                <fieldset>
                    <legend>LMR</legend>

                    <div data-linea="1">
                        <label for="parametro_id">Parámetro</label>
                        <select id="parametro_id" name="parametro_id"  data-required>
                            <option value="">Tipo parámetro....</option>
                        </select>
                    </div>
                    <div data-linea="2">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre"  required value="<?php echo $lmr==null?'':$lmr->getNombre(); ?>"/>
                    </div>
                    <div data-linea="3">
                    	<label for="descripcion">Descripción</label>
                    </div>
                    <div data-linea="4">
                        <textarea rows="4" id="descripcion" name="descripcion"  data-required><?php echo $lmr==null?'':$lmr->getDescripcion(); ?></textarea>
                    </div>

                </fieldset>
                <button id="guardar" type="submit" class="guardar">Guardar</button>
            </form>
        </td>
    </tr>
</table>

</body>

<script>

var array_comboParametros = <?php echo json_encode($parametrosCatalogo);?>;
    for(var i=0; i<array_comboParametros.length; i++){
        $('#parametro_id').append(array_comboParametros[i]);
    }

    <?php if($lmr!=null){?>
        cargarValorDefecto("parametro_id","<?php echo $lmr->getParametroId();?>");
    <?php }?>       


    $("#editarLmr").submit(function(event){
        event.preventDefault();
        if(validarRequeridos($("#editarLmr"))) {
            ejecutarJson($(this), new resetFormulario($("#editarLmr")));
        }
    });
</script>
<script src="aplicaciones/inocuidad/js/globals.js"/>
</html>