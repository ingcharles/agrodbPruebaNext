$(document).ready(function() {

    //campos y vistas por defecto
    $("#idLabelCasos").hide();
    $("#casosCreados").hide();
    $("#enviar").hide();
    $("#file-attach").hide();
    $("#actualizar").hide();
    $("#eliminar").hide();
    $("#historial").hide();
    $("#rechazar").hide();
    $("#fechaInspeccionDia").hide();
    $("#fechaInspeccionMes").hide();
    $("#section_DN").hide();
    $("#checkbox").hide();
    $("#muestrasFaltantes1").hide();
    $("#observacion_planificador_rechazo").hide();
    $("#idLabelPlanificadorRechazo").hide();
    
 
    //mostrar botones cuando el caso es denuncia o notificacion
    if($("#estadoRegistro").val() == 'denunciaCreado' || $("#estadoRegistro").val() == 'notificacionCreado'){
        var inputElement = document.getElementById('perfilUsuario');
        var valor = inputElement.value;
        if (valor != 1){
            $("#enviar").show();
            $("#actualizar").show();
        }
    }


    //se activa cuando la opcion es nuevo
    if (!$("#ic_requerimiento_id").val()) {

        $("#fecha_solicitud").val($.datepicker.formatDate('dd/mm/yy', new Date()));

        var buttonElement = document.getElementById('actualizar');
        buttonElement.disabled = false;
       
        $("#ic_tipo_requerimiento_id").prop("disabled", false);
        $("#ic_producto_id").prop("disabled", false);
        $("#fecha_solicitud").prop("disabled", false);
        $("#duplicadorCasos").show(); 
        $("#cantidadRegistros").hide(); 
        $("#obsAdministrador").hide(); 
        $("#muestrasFaltantes").hide(); 
        $("#provinciaPlanificador").show(); 
        varificarTipoRequerimiento();
        $("#file-attach").hide();
        $("#actualizar").show();
    }

    //cuando es ya creado entra por el if 
    if ($("#ic_requerimiento_id").val()) {
        habilitarSecciones($("#ic_tipo_requerimiento_id").val());
    }

    
    $("#inspector_id").on("change", function () {
        var selectData = $(this).val();
        showInspectorProperties(selectData);
    });



    $("#ic_tipo_requerimiento_id").on("change", function () {
       
        $("#fecha_solicitud").val($.datepicker.formatDate('dd/mm/yy', new Date())); 
        //opcion plan de vigilancia (boton nuevo)
        if($("#ic_tipo_requerimiento_id").val() == 'PV'){
            $("#divPrograma").show(); 
            $("#section_DN").hide(); 
               document.getElementById("section_OBS").style.display = 'block';
        }else{
            $("#divPrograma").hide();
            $("#muestraRapida").hide();
        }

        //opcion denuncia (boton nuevo)
        if($("#ic_tipo_requerimiento_id").val() == 'DN'){
            $("#divPrograma").show();
            $("#section_DN").show();
            $("#provinciaPlanificador").hide();
            $("#muestraRapida").hide();
            //notificacion exterior
            $("#section_NE").hide();
            document.getElementById("section_OBS").style.display = 'block';   
        }

        //opcion notificacion exterior (boton nuevo)
        if($("#ic_tipo_requerimiento_id").val() == 'NE'){
            $("#divPrograma").show();
            $("#section_NE").show();
            $("#provinciaPlanificador").hide();
            $("#muestraRapida").hide();
            //denuncia
            $("#section_DN").hide();
            var inputElement = document.getElementById('perfilUsuario');
            var valor = inputElement.value;
            if (valor != 1 && $("#ic_tipo_requerimiento_id").val() == 'NE'){
                document.getElementById("section_OBS").style.display = 'block';
            }      
        }

    });

    $("#fecha_inspeccion").datepicker({
        changeMonth: true,
        changeYear: true
    });

    $(function() {
        $(".date-picker").datepicker({
            dateFormat: 'MM yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
    
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
            }
        });

        $(".date-picker").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });
    });
    
    $("#fecha_notificacion").datepicker({
        changeMonth: true,
        changeYear: true
    });
    $("#fecha_denuncia").datepicker({
        changeMonth: true,
        changeYear: true
    });

    $("#enviar").on("click",function(){
     

        var inputElement = document.getElementById('perfilUsuario');
        var valor = inputElement.value;
        if(valor == 1){
            $("#respuesta").val("enviar");
        }
        $("#enviarCaso").submit(); 
    });

    $("#rechazar").on("click",function(){
        event.preventDefault();

        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");

        $("#idLabelPlanificador").hide();
        $("#observacion_planificador").hide();

        $("#idLabelPlanificadorRechazo").show();
        $("#observacion_planificador_rechazo").show();

        var inputElement = document.getElementById('perfilUsuario');
        var valor = inputElement.value;
        if(valor == 1){
            if($("#observacion_planificador_rechazo").val() == ''){
                $("#observacion_planificador_rechazo").addClass("alertaCombo");
                mostrarMensaje("Por favor Ingrese una motivo del rechazo...!", "FALLO");	
            }else{

                $("#respuesta").val("rechazar");
                $("#observacion_planificador_envio").val($("#observacion_planificador_rechazo").val());
                $("#enviarCaso").submit();
            }
            
        }

       
    });

    $("#enviarCaso").submit(function(event){
        event.preventDefault();
        ejecutarJson($(this),new resetFormulario($("#enviarCaso")));
    });

    $('#actualizarCaso').submit(function (event) {
        
        mostrarMensaje("","");
        event.preventDefault();
        if (($("#numero_muestras").val()%2) !=0){
            mostrarMensaje("La cantidad de N° de Muestras debe ser par (multiplos de 2)...!","FALLO");
        }else{
            if ($("#fecha_denuncia").val() !=''){
                $("#fecha_denuncia").val($("#fecha_denuncia").val().replace(/\s/g, ""))
            }
            if (validarRequeridos($("#actualizarCaso"))) {
                if (formularioValido()) {
                    ejecutarJson($(this), new resetFormulario($("#actualizarCaso")));
                }
            } else
                mostrarMensaje("Por favor revise los campos obligatorios.", "FALLO");
        } 
    });

//*******************************************************************Seccion de Funciones**************************************************************** */
    function varificarTipoRequerimiento(){
        
        if( $("#ic_producto_id").val() == ''){
            // $("#divPrograma").hide();
            $("#muestraRapida").hide();
            $("#idLabel").hide();
        }else{
            listarProductosInsumos($("#ic_producto_id").val());
            programa_id.disabled = true;
            $("#muestraRapida").hide();
            $("#idLabel").hide();
        }
    } 
    
    cargarValoresTabla = function (tabla, strArr) {

        var array = strArr;//JSON.parse(strArr);
        for(var i=0;i<array.length;i++){
            if(tabla == "datosProducto")
                buildRowMuestraRapida(array[i]);
        }
    };

    buildRowMuestraRapida = function (objRow) {
      
        var htmlRow="<tr stamped='"+objRow.stamped+"'>" +
        "<td id='"+objRow.ic_insumo_id+"'>"+objRow.insumo+"</td>\n" +
        "<td id='"+objRow.ic_lmr_id+"'>"+objRow.lmr+"</td>\n" +
        "<td id='"+objRow.um+"'>"+objRow.um_name+"</td>\n" +
        "<td class='decimal'>"+objRow.limite_minimo+"</td>\n" +
        "<td class='decimal'>"+objRow.limite_maximo+"</td>\n" +
        "</tr>";
        $("#muestraRapida tbody").append(htmlRow);
    };


    //se activa cuando es nuevo
    $("#ic_producto_id").on("change", function () {
        if($("#ic_tipo_requerimiento_id").val() == 'PV'){
           
            if($("#ic_producto_id").val() !=''){
                listarProductosInsumos($("#ic_producto_id").val());
                limpiarTabla();
            }else{
                $("#muestraRapida").hide();

            }
        }
       
    });

    function habilitarSecciones(elem) {
        var diferenciasMuestras = 0;
        // Obtener el elemento de entrada por su ID
        var inputElement = document.getElementById('perfilUsuario');
        var valor = inputElement.value;
        try {
            if(valor == 1){  

                //perfil Administrador
                $("#cantidadRegistros").hide();
                $("#muestrasFaltantes").hide();
                $("#divPrograma").show();
                $("#obsAdministrador").hide();
                $("#provinciaPlanificador").hide(); 
             
                 numero_muestras.disabled = true;
                 provincia_id.disabled = true;
                 observacion.disabled = true;
                 inspector_id.disabled = true;
                 
                 document.getElementById("inspector_id").style.display = 'none';
                 document.getElementById("lblInspector").style.display = 'none'; 
                 document.getElementById("btnSearch").style.display = 'none';
                 document.getElementById("section_PVtecnico").style.display = 'none'; 
                 document.getElementById("section_casos").style.display = 'block';
                 
                 varificarTipoRequerimiento();
                 switch (elem) {
                     case 'PV':
                        if ($("#ic_requerimiento_id").val()){
                            $("#historial").show();
                        }
                         break;
                 }
                listarCasosPorId($("#ic_producto_id").val(),$("#provincia_id").val(),$("#programa_id").val(),$("#ic_tipo_requerimiento_id option:selected").attr('data-grupo'),$("#numero_muestras").val());
                
                //habilitar campos y secciones caso usuario cuando el requerimiento es denuncia
                if($("#ic_tipo_requerimiento_id").val() == 'DN'){
                    $("#ic_tipo_requerimiento_id").prop("disabled", true);
                    $("#programa_id").prop("disabled", true);
                    $("#numero_muestras").prop("disabled", true);
                    $("#ic_producto_id").prop("disabled", true);
                    $("#fecha_denuncia").prop("disabled", true);
                    $("#fuente_denuncia_id").prop("disabled", true);
                    $("#nombre_denunciante").prop("disabled", true);
                    $("#datos_denunciante").prop("disabled", true);
                    $("#descripcion_denuncia").prop("disabled", true);
                    $("#provincia_denuncia_id").prop("disabled", true);
                    $("#section_PVtecnico").hide();
                    $("#tablaMuestraRapida").hide();
                    $("#section_DN").show();
                    $("#obsAdministrador").hide();
                    $("#cantidadRegistros").hide();
                    $("#muestrasFaltantes").hide();
                    document.getElementById("section_OBS").style.display = 'block';
                    $("#tipo_requerimiento_id").val($("#ic_tipo_requerimiento_id").val());
                    $("#section_casos").hide();
                }
                //habilitar campos y secciones caso usuario cuando el requerimiento es notificacion
                if($("#ic_tipo_requerimiento_id").val() == 'NE'){
                    $("#ic_tipo_requerimiento_id").prop("disabled", true);
                    $("#programa_id").prop("disabled", true);
                    $("#numero_muestras").prop("disabled", true);
                    $("#ic_producto_id").prop("disabled", true);
                    $("#fecha_notificacion").prop("disabled", true);
                    $("#pais_notificacion_id").prop("disabled", true);
                    $("#section_PVtecnico").hide();
                    $("#tablaMuestraRapida").hide();
                    $("#section_NE").show();
                    $("#obsAdministrador").hide();
                    $("#cantidadRegistros").hide();
                    $("#muestrasFaltantes").hide();
                    document.getElementById("section_OBS").style.display = 'block';
                    tipo_requerimiento_id
                    $("#tipo_requerimiento_id").val($("#ic_tipo_requerimiento_id").val());
                    $("#section_casos").hide();
                    $("#actualizar").hide();
                    $("#file-attach").hide(); 
                    $("#enviar").hide(); 
                    
                }
            }else{
                //perfil Usuario
                
                $("#idLabel").hide();
                $("#muestraRapida").hide();
                $("#cantidadRegistros").show();
                $("#muestrasFaltantes").show();
                $("#obsAdministrador").show();
                $("#provinciaPlanificador").hide(); 
                $("#programa_id").show(); 
                $("#fechaInspeccionMes").show();
                $("#file-attach").show(); 
                
                document.getElementById("section_PVtecnico").style.display = 'block';
                muestras_faltantes.disabled = true;
                numero_muestras.disabled = true;
                observacionPlanificador.disabled = true;
                programa_id.disabled = true;
                numero_casos.disabled = true;
            
                document.getElementById("section_casos").style.display = 'none';
                listarProductosInsumos($("#ic_producto_id").val());
                var inputElement = document.getElementById('numero_muestras');
                var valor = inputElement.value;
                diferenciasMuestras = (valor);
                $("#muestras_faltantes").val(diferenciasMuestras);

                //botones
                $("#actualizar").prop("disabled", false);
                $("#numero_casos").prop("disabled", true);
          
                if($("#ic_tipo_requerimiento_id").val() == 'PV'){
                    if($("#estadoRegistro").val() == 'casoCreado' || $("#estadoRegistro").val() == 'rechazadoPlanificador'){
                        $("#actualizar").show();
                    }else if ($("#estadoRegistro").val() == 'casoGenerado'){
                        $("#enviar").show();
                        $("#actualizar").show();
                        
                    }
                }
    
           
                //habilitar campos y secciones caso usuario cuando el requerimiento es denuncia
                if($("#ic_tipo_requerimiento_id").val() == 'DN'){
                    $("#ic_tipo_requerimiento_id").prop("disabled", false);
                    $("#programa_id").prop("disabled", false);
                    $("#numero_muestras").prop("disabled", false);
                    $("#ic_producto_id").prop("disabled", false);
                    $("#section_PVtecnico").hide();
                    $("#tablaMuestraRapida").hide();
                    $("#section_DN").show();
                    $("#obsAdministrador").hide();
                    $("#cantidadRegistros").hide();
                    $("#muestrasFaltantes").hide();
                    $("#historial").hide();
                    $("#file-attach").show();
                    document.getElementById("section_OBS").style.display = 'block';
                    tipo_requerimiento_id
                    $("#tipo_requerimiento_id").val($("#ic_tipo_requerimiento_id").val());
                }
                //habilitar campos y secciones caso usuario cuando el requerimiento es notificacion
                if($("#ic_tipo_requerimiento_id").val() == 'NE'){
               
                    $("#ic_tipo_requerimiento_id").prop("disabled", false);
                    $("#programa_id").prop("disabled", false);
                    $("#numero_muestras").prop("disabled", false);
                    $("#ic_producto_id").prop("disabled", false);
                    $("#section_PVtecnico").hide();
                    $("#tablaMuestraRapida").hide();
                    $("#section_NE").show();
                    $("#obsAdministrador").hide();
                    $("#cantidadRegistros").hide();
                    $("#muestrasFaltantes").hide();
                    $("#historial").hide();
                    $("#file-attach").show();
                    $("#checkbox").show();
                    $("#enviar").hide();
                    document.getElementById("section_OBS").style.display = 'block';
                    $("#tipo_requerimiento_id").val($("#ic_tipo_requerimiento_id").val());
                }
            }
               
        } catch (e) {
            console.log(e);
        }
    }

    function limpiarTabla(){
        $("#muestraRapida tbody").empty();
    }

     function listarProductosInsumos (ic_producto_id){

        if(ic_producto_id && Number(ic_producto_id)>0){
            
            $.ajax({
                type: "POST",
                url: "./aplicaciones/inocuidad/servicios/ServiceCatalogos.php",
                data: {'catalogo': 'LISTAR_PRODUCTO_JSON', 'selectData': ic_producto_id},
                success: function (json) {
                  
                    let cantidadRegistros = Object.keys(json).length;
                
                    if(cantidadRegistros > 2) {

                        $("#idLabel").hide();
                        $("#muestraRapida").show();
                        
                        cargarValoresTabla("datosProducto",JSON.parse(json));
                        
                    }else{
                        
                        $("#muestraRapida").hide();
                        $("#idLabel").show();
        
                    }
                    
                }
               
            });
        }
    };

    formularioValido = function () {
        ret = false;
        if ($("#numero_muestras").val() && $("#numero_muestras").val() > 0)
            ret = true;
        else {
            $("#numero_muestras").val("1");
            ret = true;
        }
        return ret;
    };


    //funcion obtener casos creados
    function listarCasosPorId (ic_producto_id, provincia_id,programa_id, ic_tipo_requerimiento_id, numero_muestras){

        //captura de elementos para enviar registros    
        $("#cod_producto").val(ic_producto_id); 
        $("#cod_provincia").val(provincia_id);
        $("#cod_programa").val(programa_id);
        $("#tipo_requerimiento_id").val(ic_tipo_requerimiento_id);
        $("#muestras").val(numero_muestras);
   
          var objParametros = {};
          objParametros.producto_id = ic_producto_id;
          objParametros.provincia_id = provincia_id;
          objParametros.programa_id = programa_id;
          objParametros.ic_tipo_requerimiento_id = ic_tipo_requerimiento_id;
          objParametros.numero_muestras = numero_muestras;

          var inputElement = document.getElementById('perfilUsuario');
          var valor = inputElement.value;

            $.ajax({
                type: "POST",
                url: "./aplicaciones/inocuidad/servicios/ServiceCatalogos.php",
                data: {'catalogo': 'LISTAR_CASOS_JSON', 'selectData': JSON.stringify(objParametros)},
                success: function (json) {
                
                    if(json != 'null') {
                        
                        cargarValoresTablaCasos("datosCasos",JSON.parse(json));
                    }else{
                        if($("#estadoRegistro").val() != 'denunciaCreado'){
                            $("#casosCreados").hide();
                            $("#idLabelCasos").show();
                        } 
                    }
                }
               
            });
    };

    cargarValoresTablaCasos = function (tabla, strArr) {

        var array = strArr;//JSON.parse(strArr);
        if(array[0]==array[1]){
            $("#enviar").show();
            $("#rechazar").show();
            $("#historial").show();
            $("#idLabelCasos").hide();
            $("#casosCreados").show();
            $("#file-attach").show(); 
        }
        for(var i=0;i<array.length;i++){
            if(array[i] !=array[0] && array[i] !=array[1]){
                $("#casosCreados").show();
                if(tabla == "datosCasos")
                buildRowCasos(array[i]);
            }
        }
        
    };

    buildRowCasos = function (objRow) {
       
        var htmlRow="<tr stamped='"+objRow.stamped+"'>" +
        "<td id='"+objRow.fecha_inspeccion+"'>"+objRow.fecha_inspeccion+"</td>\n" +
        "<td id='"+objRow.nombre+"'>"+objRow.nombre+"</td>\n" +
        "<td id='"+objRow.observacion_tecnico+"'>"+objRow.observacion_tecnico+"</td>\n" +
        "</tr>";
        $("#casosCreados tbody").append(htmlRow);
    };

 //activa boton cuando la opcion es notificacion
    $("input[name='checkMuestra']").click(function() {
        if($("input[name='checkMuestra']").is(':checked')) {
        	$("#enviar").show();
        } else{
            $("#enviar").hide();  
        }
    });

    $("#numero_muestras").click(function() {
        // Obtener el valor actual del campo de entrada numérica
        var currentValue = parseInt($("#numero_muestras").val());
        
        // Incrementar el valor en dos unidades
        var newValue = currentValue + 1;
        
        // Actualizar el valor en el campo de entrada
        $("#numero_muestras").val(newValue);
    });
    
});




