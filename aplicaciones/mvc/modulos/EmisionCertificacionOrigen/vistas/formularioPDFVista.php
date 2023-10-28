<iframe width="100%" height="100%"  src="<?php 
if($this->modeloEmisionCertificado->getRutaCertificado() != ''){
	echo $this->modeloEmisionCertificado->getRutaCertificado(); 
}else{
	echo("ruta de certificado vacio..!");
}
	
?>" frameborder="0" allowfullscreen></iframe>

<script type="text/javascript">
	$(document).ready(function() {
		$(".alertaCombo").removeClass("alertaCombo");
		$('#estado').html('');
	});
</script>