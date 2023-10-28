<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<?php 
    echo $this->datosOperador;
    echo $this->datosExportacion;?>
	<form id="formularioAtenderInspeccion" data-rutaAplicacion="<?php echo URL_MVC_FOLDER  ?>InspeccionFitosanitaria" data-opcion="RevisionInspeccionFitosanitaria/guardarAtenderInspeccion" data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
        <?php echo $this->datosProductoresAgregados;
        echo $this->datosConfirmacion;
        echo $this->datosInspeccion;
        ?>
        <div data-linea="1">
        	<button type="submit" class="guardar">Guardar</button>
       	</div>
    </form>

<script type ="text/javascript">
	
	var idPaisDestino = <?php echo json_encode($this->modeloInspeccionFitosanitaria->getIdPaisDestino());?>;
	var idInspeccionFitosanitaria = <?php echo json_encode($this->modeloInspeccionFitosanitaria->getIdInspeccionFitosanitaria());?>;
	
    $(document).ready(function() {
        construirValidador();
        distribuirLineas();
        formatearCantidadProducto("input[name='cantidad_aprobada']");
        formatearCantidadProducto("input[name='peso_aprobado']");
        formatearCantidadProducto("input[name='cantidad_inspeccionada']");
        formatearCantidadProducto("input[name='peso_inspeccionado']");
    });
	
	function formatearCantidadProducto(inputElement) {
        $(inputElement).on('input', function () {
            var valor = this.value.replace(/[^\d.]/g, ''); // Elimina caracteres no numéricos ni puntos
            var partes = valor.split('.');
            
            if (partes.length > 1) {
                partes[0] = partes[0].substring(0, 7); // Limita a enterosMaximos enteros
                partes[1] = partes[1].substring(0, 2); // Limita a decimalesMaximos decimales
                valor = partes.join('.');
            } else if (partes[0].length > 7) {
                valor = partes[0].substring(0, 7); // Limita a enterosMaximos enteros si no hay parte decimal
            }
            
            this.value = valor;
        });
    }
	
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
    
	//Funcion para agregar fila de detalle de exportadores productos
    $("#formularioAtenderInspeccion").submit(function (event) {
    	$(".alertaCombo").removeClass("alertaCombo");
        event.preventDefault();
        var error = false;	
        
        $("#tProductoresAgregados tbody .productos").each(function(){

			let cantidadAprobada = $(this).find('input[name="cantidad_aprobada"]').val();
			let pesoAprobado = $(this).find('input[name="peso_aprobado"]').val();
			let cantidadInspeccionada = $(this).find('input[name="cantidad_inspeccionada"]').val();
			let pesoInspeccionado = $(this).find('input[name="peso_inspeccionado"]').val();
			
			if ((!$.trim(cantidadAprobada)) || cantidadAprobada <= 0){
				error = true;
				$(this).find('input[name="cantidad_aprobada"]').addClass("alertaCombo");
			}
			
			if ((!$.trim(pesoAprobado)) || pesoAprobado <= 0){
				error = true;
				$(this).find('input[name="peso_aprobado"]').addClass("alertaCombo");
			}
			
			if($("#estado_inspeccion_fitosanitaria option:selected").val() == "Aprobado"){			
				if ((!$.trim(cantidadInspeccionada)) || cantidadInspeccionada <= 0){
					error = true;
					$(this).find('input[name="cantidad_inspeccionada"]').addClass("alertaCombo");
				}
				
				if ((!$.trim(pesoInspeccionado)) || pesoInspeccionado <= 0){
					error = true;
					$(this).find('input[name="peso_inspeccionado"]').addClass("alertaCombo");
				}
			}		
		});
		
		$('#formularioAtenderInspeccion .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });
        
		if (!error) {
		
    			let arrayProductoresAgregados = [];
    			let datosProductoresAgregados = [];
		
				$('#tProductoresAgregados tbody .productos').each(function (rows) {				
        
        			let idProductoInspeccionFitosanitaria = $(this).find('td').find('input[name="id_producto_inspeccion_fitosanitaria"]').val();
        			let cantidadAprobada = $(this).find('td').find('input[name="cantidad_aprobada"]').val();			
        			let pesoAprobado = $(this).find('td').find('input[name="peso_aprobado"]').val();
        			let cantidadInspeccionada = $(this).find('td').find('input[name="cantidad_inspeccionada"]').val();
        			let pesoInspeccionado = $(this).find('td').find('input[name="peso_inspeccionado"]').val();
            						
    				datosProductoresAgregados = {"id_producto_inspeccion_fitosanitaria" : idProductoInspeccionFitosanitaria, "cantidad_aprobada" : cantidadAprobada, "peso_aprobado":pesoAprobado, 'cantidad_inspeccionada' : cantidadInspeccionada, 'peso_inspeccionado' : pesoInspeccionado};
    				agregarElementos(arrayProductoresAgregados, datosProductoresAgregados, $("#array_productos_inspeccion"));   			
    
    			});
		        
		        var respuesta = JSON.parse(ejecutarJson($("#formularioAtenderInspeccion")).responseText);

				/*if (respuesta.estado == 'exito'){
		       		$("#estado").html(respuesta.mensaje);
		       		$("#_actualizar").click();
					$("#detalleItem").html('<div class="mensajeInicial">Arrastre aquí un item para revisarlo.</div>');
		        }*/
	        
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});
	
	//Funcion que agrega elementos a un array
    //Recibe array, datos del array y el objeto donde se almacena
    function agregarElementos(array, datos, objeto){
    	array.push(datos);
    	objeto.val(JSON.stringify(array));
	}
	
	$("#estado_inspeccion_fitosanitaria").change(function () {
		if($("#estado_inspeccion_fitosanitaria option:selected").val() == "Aprobado"){
			$("#tiempo_vigencia").prop('disabled', false);
		}else{
			$("#tiempo_vigencia").prop('disabled', true);
		}
	});
	
	function actualizarCantidades(idExportadorProducto, elemento) {

    	$.post("<?php echo URL ?>InspeccionFitosanitaria/ProductosInspeccionFitosanitaria/actualizarCantidades",
            {
            	id_producto_inspeccion_fitosanitaria : idExportadorProducto,
            	cantidad : elemento.value,
            	tipo_cantidad : elemento.name
            }, function (data) {
            	if(data.validacion == "Fallo"){
    				$(elemento).val(data.cantidad);	     		
            	}
            }, 'json');
            
	}	
    
</script>
