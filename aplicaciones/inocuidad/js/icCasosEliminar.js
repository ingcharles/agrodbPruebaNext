$(document).ready(function() {

    //se activa cuando la opcion es nuevo
    if (!$("#ic_requerimiento_id").val()) {

        $("#fecha_solicitud").val($.datepicker.formatDate('dd/mm/yy', new Date()));

        var buttonElement = document.getElementById('actualizar');
        buttonElement.disabled = false;
       
        $("#file-attach").prop("disabled", false);
        $("#ic_tipo_requerimiento_id").prop("disabled", false);
        $("#ic_producto_id").prop("disabled", false);
        $("#fecha_solicitud").prop("disabled", false);
        $("#fechaSolicitudCaso").hide(); 
        $("#duplicadorCasos").show(); 
        $("#cantidadRegistros").hide(); 
        $("#obsAdministrador").hide(); 
        $("#muestrasFaltantes").hide(); 
        $("#provinciaPlanificador").show(); 
        varificarTipoRequerimiento();
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
        if($("#ic_tipo_requerimiento_id").val() == 'PV'){
            $("#divPrograma").show();  
        }else{
            $("#divPrograma").hide();
            $("#muestraRapida").hide();
        }
        var selected = this.value;
        $("#ic_tipo_requerimiento_id > option").each(function () {

            try {
                if (selected && this.value == selected)
                    document.getElementById("section_" + this.value).style.display = 'block';
                else
                    document.getElementById("section_" + this.value).style.display = 'none';
            } catch (e) {
                console.log(e);
            }
        });
        if (selected != null && selected != '') {
            document.getElementById("section_OBS").style.display = 'block';
        }
    });

    $("#fecha_inspeccion").datepicker({
        changeMonth: true,
        changeYear: true
    });
    $("#fecha_notificacion").datepicker({
        changeMonth: true,
        changeYear: true
    });
    $("#fecha_denuncia").datepicker({
        changeMonth: true,
        changeYear: true
    });
     
    $('#eliminarCaso').submit(function (event) {
        event.preventDefault();
        listaEliminar($("#ic_requerimiento_id").val(),$("#ic_producto_id").val(),$("#provincia_id").val(),$("#programa_id").val(),$("#ic_tipo_requerimiento_id option:selected").attr('data-grupo'),$("#numero_muestras").val());
        ejecutarJson($(this), new resetFormulario($("#eliminarCaso")));
    });

    //funcion obtener casos creados
    function listaEliminar (ic_requerimiento_id,ic_producto_id, provincia_id,programa_id, ic_tipo_requerimiento_id, numero_muestras){
        var objParametros = {};
        objParametros.requerimiento_id = ic_requerimiento_id;
        objParametros.producto_id = ic_producto_id;
        objParametros.provincia_id = provincia_id;
        objParametros.programa_id = programa_id;
        objParametros.ic_tipo_requerimiento_id = ic_tipo_requerimiento_id;
        objParametros.numero_muestras = numero_muestras;

        $.ajax({
                type: "POST",
                url: "./aplicaciones/inocuidad/servicios/ServiceCatalogos.php",
                data: {'catalogo': 'ELIMINAR_CASOS_JSON', 'selectData': JSON.stringify(objParametros)},
        });
    };


//*******************************************************************Seccion de Funciones**************************************************************** */
    function varificarTipoRequerimiento(){
        
        if( $("#ic_producto_id").val() == ''){
            $("#divPrograma").hide();
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
                 document.getElementById("section_OBS").style.display = 'block';
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
                         break;
                 }

                 //botones
                $("#actualizar").prop("disabled", true);
                $("#file-attach").prop("disabled", false);
                $("#historial").prop("disabled", false);
                 
                listarCasosPorId($("#ic_producto_id").val(),$("#provincia_id").val(),$("#programa_id").val(),$("#ic_tipo_requerimiento_id option:selected").attr('data-grupo'),$("#numero_muestras").val());
            }else{
                //perfil Usuario
                
                $("#idLabel").hide();
                $("#muestraRapida").hide();
                $("#cantidadRegistros").show();
                $("#muestrasFaltantes").show();
                $("#obsAdministrador").show();
                $("#provinciaPlanificador").hide(); 
                $("#programa_id").show(); 
                $("#fechaSolicitudCaso").show(); 
                
                
                
                document.getElementById("section_PVtecnico").style.display = 'block';
                muestras_faltantes.disabled = true;
                numero_muestras.disabled = true;
                observacionPlanificador.disabled = true;
                programa_id.disabled = true;
                numero_casos.disabled = true;
                

                document.getElementById("section_OBS").style.display = 'none';
                document.getElementById("section_casos").style.display = 'none';
                listarProductosInsumos($("#ic_producto_id").val());
                var inputElement = document.getElementById('numero_muestras');
                var valor = inputElement.value;
                diferenciasMuestras = (valor);
                $("#muestras_faltantes").val(diferenciasMuestras);

                //botones
                $("#numero_casos").prop("disabled", true);
                
              
                
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
   
          var objParametros = {};
          objParametros.producto_id = ic_producto_id;
          objParametros.provincia_id = provincia_id;
          objParametros.programa_id = programa_id;
          objParametros.ic_tipo_requerimiento_id = ic_tipo_requerimiento_id;
          objParametros.numero_muestras = numero_muestras;

            $.ajax({
                type: "POST",
                url: "./aplicaciones/inocuidad/servicios/ServiceCatalogos.php",
                data: {'catalogo': 'LISTAR_CASOS_JSON', 'selectData': JSON.stringify(objParametros)},
                success: function (json) {
                
                    if((Object.keys(json).length != 4)) {
                        $("#idLabelCasos").hide();
                        $("#casosCreados").show();
                        cargarValoresTablaCasos("datosCasos",JSON.parse(json));
                        
                    }else{
                        
                        $("#casosCreados").hide();
                        $("#idLabelCasos").show();
                    }
                    
                }
               
            });
    };



    cargarValoresTablaCasos = function (tabla, strArr) {


        var array = strArr;//JSON.parse(strArr);
        var arr=[];
        for(var i=0;i<array.length;i++){
            if(tabla == "datosCasos")

            buildRowCasos(array[i]);
           var a= JSON.stringify(array[i], null, "  ");
           if(i>1){
            arr.push(array[i]['ic_requerimiento_id']);
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

});




