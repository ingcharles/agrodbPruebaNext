$.getScript("aplicaciones/inocuidad/js/globals.js",function(){console.log("globals loaded");});

$(document).ready(function() {
   
    $("#fs_detalle_rechazo").hide();
    $("#registroValores").hide();
    

    $('#actualizaLaboratorio').submit(function(event) {
        mostrarMensaje("","");

        if($("#ic_obs_rechazo").val() == 'rechazado'){

            $("#fsregistroValores").hide();
            $(".alertaCombo").removeClass("alertaCombo");
            var error = false;
            if(!$.trim($("#observacion_rechazo").val()) || !esCampoValido("#observacion_rechazo") || $("#observacion_rechazo").val() == ""){
                 error = true;
                 $("#observacion_rechazo").addClass("alertaCombo");
                 mostrarMensaje("Por favor revise los campos obligatorios...!","FALLO");
            }
            if(error == false){
                event.preventDefault();
                ejecutarJson($(this),new resetFormulario($("#actualizaLaboratorio")));
            }else{
                event.preventDefault();
            }
           
        }else{
            event.preventDefault();
    
                if(validarRequeridos($("#actualizaLaboratorio"))){
                    
                    ejecutarJson($(this),new resetFormulario($("#actualizaLaboratorio")));
                }else{
                    mostrarMensaje("Por favor revise los campos obligatorios.","FALLO");
                }
        }
    });

    

    $('#labSolicitud').click(function(){
        $.post("aplicaciones/mvc/laboratorios/solicitudes/aplicacion/app1/475", function(data){
            console.log(data);
        });
    });

    $("#fecha_recepcion_muestra").datepicker({
		changeMonth: true,
        changeYear: true
	});

    $("#fecha_analisis_muestra").datepicker({
		startDate: new Date(),
		changeMonth: true,
	    changeYear: true,
	});

    
    $('#numero_informe_lab').click(function(){
        mostrarMensaje("","");
        $(".alertaCombo").removeClass("alertaCombo");
        if($('#fecha_recepcion_muestra').val() > $('#fecha_analisis_muestra').val()){
            $("#fecha_analisis_muestra").addClass("alertaCombo");
            mostrarMensaje("Por favor revise la fecha de análisis de muestra no puede ser menor a la fecha de recepción de muestra.","FALLO");
        }

        
    });
    
    $("#rechazar").on("click",function(){
        $("#fs_detalle_rechazo").show();
        $("#ic_obs_rechazo").val('rechazado');
        $("#fs_detalle").hide();
    });

     //inactivar campos y ocultar botones en perfil de administrador y planificador
     var inputElement = document.getElementById('perfilUsuario');
     var valor = inputElement.value;
     if(valor == 1){
        $("#fecha_recepcion_muestra").prop("disabled",true);
        $("#fecha_analisis_muestra").prop("disabled",true);
        $("#numero_informe_lab").prop("disabled",true);
        $("#numero_memorando").prop("disabled",true);
        $("#observaciones").prop("disabled",true);
        $("#observacion_rechazo").prop("disabled",true);
        $("#guardar").hide();
        $("#enviar").hide();
        $("#rechazar").hide();
        $("#file-attach").hide();  
     }
});