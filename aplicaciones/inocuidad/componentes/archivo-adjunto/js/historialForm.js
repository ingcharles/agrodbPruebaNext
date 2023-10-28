$(document).ready(function() {

    
    if($('#historial')[0].hasAttribute("data-tabla") && $('#historial')[0].hasAttribute("data-registro")){
        var tabla = $('#historial')[0].getAttribute("data-tabla");
        var registro = $('#historial')[0].getAttribute("data-registro");
        $('#adjunto_tabla').val(tabla);
        $('#adjunto_registro').val(registro);
    }

    mensajeLocal = function (texto,tipo) {
        var clase;

        // switch (tipo){
            // case 'EXITO': 
            clase = 'exito'; 
            // break;
            // case 'FALLO': clase = 'alerta'; break;
            // default: clase = '';
        // }

        $("#file_msg_box").html(texto);
        $("#file_msg_box").addClass(clase);
    };
});