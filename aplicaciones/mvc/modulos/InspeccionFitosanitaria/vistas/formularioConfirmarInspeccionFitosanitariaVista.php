<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<?php 
    echo $this->datosOperador;
    echo $this->datosExportacion;
    echo $this->datosProductoresAgregados;
    echo $this->datosConfirmacion; 
?>

<script type ="text/javascript">
	
	var idPaisDestino = <?php echo json_encode($this->modeloInspeccionFitosanitaria->getIdPaisDestino());?>;
	var idInspeccionFitosanitaria = <?php echo json_encode($this->modeloInspeccionFitosanitaria->getIdInspeccionFitosanitaria());?>;

    $(document).ready(function() {
        construirValidador();
        distribuirLineas();
    });

	//Funcion para agregar fila de detalle de exportadores productos
    $("#formularioConfirmarInspeccion").submit(function (event) {
        event.preventDefault();
        var error = false;

    	$('#formularioConfirmarInspeccion .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });
        
		if (!error) {
		        
		        var respuesta = JSON.parse(ejecutarJson($("#formularioConfirmarInspeccion")).responseText);

				/*if (respuesta.estado == 'exito'){
		       		$("#estado").html(respuesta.mensaje);
		       		$("#_actualizar").click();
					$("#detalleItem").html('<div class="mensajeInicial">Arrastre aquí un item para revisarlo.</div>');
		        }*/
	        
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});
	
	$("#fecha_inspeccion").datepicker({
        yearRange: "c:c",
        changeMonth: false,
        changeYear: false,
        dateFormat: 'yy-mm-dd',
    });

    $("#fecha_inspeccion").click(function () {
        $(this).val('');
    });
	
    function adicionalProducto(id){
    	event.preventDefault();
		visualizar = $("#resultadoInformacionProducto"+id).css("display");
        if(visualizar == "table-row") {
        	$("#resultadoInformacionProducto"+id).fadeOut('fast',function() {
            	$("#resultadoInformacionProducto"+id).css("display", "none");
            });
        }else{
        	$("#resultadoInformacionProducto"+id).fadeIn('fast',function() {
        		$("#resultadoInformacionProducto"+id).css("display", "table-row");
            });
        }
	}
	
	$("#hora_inspeccion").change(function () {
    	if (!validarHora($('#hora_inspeccion'))) {
    		$('#hora_inspeccion').val("");
    	}
    
    });
    
    function validarHora (input) {
        isValid = true;
        var currVal = $(input).val();
        if (currVal === ''){
            isValid = false;
     	}
        //Declarar Regex 
        var rxDatePattern = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/;
        var dtArray = currVal.match(rxDatePattern);
        if (dtArray === null){
            isValid = false;
     	}
        return isValid;
	};
    
</script>
