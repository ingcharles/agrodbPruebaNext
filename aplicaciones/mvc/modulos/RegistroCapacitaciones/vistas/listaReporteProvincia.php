<header>
	<nav><?php echo $this->panelBusquedaReporteProvincia;?></nav>
</header>

<script>


$("#generarReporteCapacitacionesPDF").submit(function(event){

	event.preventDefault();
       	mostrarMensaje("", "");
    	
    $(".alertaCombo").removeClass("alertaCombo");

    var error = false;

	if ($("#idProvinciaFiltro").val()=="PC" || $("#idProvinciaFiltro").val()==""){
		if($("#fechaInicio").val() == "" ){	
			error=true;
			$('#fechaInicio').addClass("alertaCombo");
		}
		if($("#fechaFin").val() == "" ){	
			error=true;
			$('#fechaFin').addClass("alertaCombo");
		}
		if($("#idProvinciaFiltro").val() == "" ){	
			error=true;
			$('#idProvinciaFiltro').addClass("alertaCombo");
		}
		if($("#idCoordinacion").val() == "" ){	
		error=true;
		$('#idCoordinacion').addClass("alertaCombo");
		}
		if(($("#idDireccion").val() == "") || ($("#idDireccion").val() == "Seleccione....") ){	
			error=true;
			$('#idDireccion').addClass("alertaCombo");
		}
	}else{
		if($("#fechaInicio").val() == "" ){	
			error=true;
			$('#fechaInicio').addClass("alertaCombo");
		}
		if($("#fechaFin").val() == "" ){	
			error=true;
			$('#fechaFin').addClass("alertaCombo");
		}
		if($("#idCoordinacion").val() == "" ){	
		error=true;
		$('#idCoordinacion').addClass("alertaCombo");
		}
		if(($("#idDireccion").val() == "") || ($("#idDireccion").val() == "Seleccione....") ){	
			error=true;
			$('#idDireccion').addClass("alertaCombo");
		}
		if($("#idProvinciaFiltro").val() == "" ){	
			error=true;
			$('#idProvinciaFiltro').addClass("alertaCombo");
		}
	}
    if(!error){
		abrir($(this),event,false);	
	}
});


$("#fechaInicio").datepicker({ 
	    changeMonth: true,
	    changeYear: true,
	    dateFormat: 'yy-mm-dd',
		numberOfMonths: 1,
	    onSelect: function(dateText, inst) {
        	var fecha=new Date($('#fechaInicio').datepicker('getDate')); 
        	fecha.setMonth(fecha.getMonth()+3);	 
      		$('#fechaFin').datepicker('option', 'minDate', $("#fechaInicio" ).val());
      		$('#fechaFin').datepicker('option', 'maxDate', fecha);
      		$('#fechaFin').datepicker('setDate', fecha);
	    }
	}).datepicker("setDate", new Date());

	$("#fechaFin").datepicker({ 
	    changeMonth: true,
	    changeYear: true,
	    dateFormat: 'yy-mm-dd',
		numberOfMonths: 1,
	    onSelect: function(dateText, inst) {
        	var fecha=new Date($('#fechaInicio').datepicker('getDate')); 
	    }
	}).datepicker("setDate", new Date());
	
	//Inicio funcion que activa el combo direcciones
	$("#idCoordinacion").change(function () {

		$("#idDireccion").val('');
		$("#idDireccion").attr('disabled', false);
		$("#idCursoCapacitacion").val('');
		$("#idCursoCapacitacion").attr('disabled', true);
		if ($("#idCoordinacion option:selected").val() !== "") {

			fn_cargarDireccionXCoordinacion();
			$("#nombre_coor").val($("#idCoordinacion option:selected").text());
		}
	});

	//funcion que carga las direcciones dado un id de coordinacion
	function fn_cargarDireccionXCoordinacion() {
		
		var id_coordinacion = $("#idCoordinacion option:selected").val();
		
		if (id_coordinacion !== '') {
			$.post("<?php echo URL ?>RegistroCapacitaciones/Base/comboDireccionesXCoordinaciones/", 
			{
				id_coordinacion : id_coordinacion
			},
			function (data) {
				
				$("#idDireccion").html(data);
				$("#idDireccion").removeAttr('disabled');
				$("#nombre_dir").val($("#idDireccion option:selected").text());
			});
		}else{
			$("#idDireccion").val('');
			$("#idDireccion").attr('disabled', 'disabled');
		}
	}

	//Inicio funcion que captura el nombre seleccionado del combo de direcciones
	$("#idDireccion").change(function () {
		$("#nombre_dir").val($("#idDireccion option:selected").text());
	});
	
	//Inicio funcion que captura el nombre de la provincia
	$("#idProvincia").val($("#idProvinciaFiltro").val());
	$("#nombreProvincia").val($("#idProvinciaFiltrooption:selected").text());
	$("#idProvinciaFiltro").change(function () {
		$("#idProvincia").val($("#idProvinciaFiltro").val());
		$("#nombreProvincia").val($("#idProvinciaFiltrooption:selected").text());
	});

	//Inicio funcion coordinacion Vista
	$("#idCoordinacion1").change(function () {

		if ($("#idCoordinacion1 option:selected").val() !== "") {
			$("#nombre_coor").val($("#idCoordinacion1 option:selected").text());
	}
	});



</script>
