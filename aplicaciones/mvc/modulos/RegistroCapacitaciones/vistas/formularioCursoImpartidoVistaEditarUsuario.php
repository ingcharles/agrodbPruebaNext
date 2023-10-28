<header>

</header>

<script type ="text/javascript">
    var banderaEliminar = <?php echo json_encode($this->banderaEliminar);?>;
	var mensajeEliminar = <?php echo json_encode($this->mensajeEliminar);?>;

    $(document).ready(function() {
		
		if(banderaEliminar == "eliminarCurso"){    		
    		$("#detalleItem").html('<div class="mensajeInicial">' + mensajeEliminar + '</div>');
        }
        if(banderaEliminar == "AccesoDenegado"){    		
    		$("#detalleItem").html('<div class="mensajeInicial">' + mensajeEliminar + '</div>');
        }
        
	 });
	
</script>


