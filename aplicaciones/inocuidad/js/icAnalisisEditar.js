$.getScript("aplicaciones/inocuidad/js/globals.js",function(){console.log("globals loaded");});

$(document).ready(function() {

    $('#actualizaEvaluacion').submit(function(event) {
        event.preventDefault();
        if(validarRequeridos($("#actualizaEvaluacion"))){
            ejecutarJson($(this),new resetFormulario($("#actualizaEvaluacion")));
        }else
            mostrarMensaje("Por favor revise los campos obligatorios.","FALLO");

    });
    $('#resultadoDecision').on("change",function(e){
        var selectData = $(this).val();
        if(selectData && selectData.length>0)
            $("#ic_resultado_decision_id").val(selectData);
    });
    $("#enviar").on("click",function(){
        $("#enviarEvaluacion").submit();
    });

    $("#enviarEvaluacion").submit(function(event){
        event.preventDefault();
        ejecutarJson($(this),new resetFormulario($("#enviarEvaluacion")));
        $("#enviar").prop('disabled', 'disabled');
    });

    //activar los botones y campos en el perfil de administrador y planificador
    var inputElement = document.getElementById('perfilUsuario');
    var valor = inputElement.value;
    if(valor == 1){
        $("#guardar").hide();
        $("#enviar").hide();
        $("#file-attach").hide();
        $("#observaciones").prop("disabled",true); 
        $("#resultadoDecision").prop("disabled",true); 
    }
});