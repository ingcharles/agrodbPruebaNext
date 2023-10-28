<header>
  <h1><?= $this->accion ?></h1>
</header>
<?php 
  $distribucionInicialCuv = $this->modeloDistribucionInicialCuv;
  $provincia = $distribucionInicialCuv->getProvincia();
  $anio = $distribucionInicialCuv->getAnio();
  $siglas = $distribucionInicialCuv->getSiglas();
  $prefijo = $distribucionInicialCuv->getPrefijoCuvNumerico();
  $inicio = $distribucionInicialCuv->getCodigoCuvInicio();
  $fin = $distribucionInicialCuv->getCodigoCuvFin();
$cuvInicio = "{$siglas}-{$anio}-{$prefijo}-{$inicio}";
$cuvFin = "{$siglas}-{$anio}-{$prefijo}-{$fin}";
?>

<fieldset>
  <legend>Provincia asignada:</legend>
  <div data-linea="1">
    <label for="provincia">Provincia:</label>
    <?= $provincia ?>
  </div>
  <div data-linea="1">
    <label for="anio">Año:</label>
    <?= $anio ?>
  </div>
  <div data-linea="1">
    <label for="anio">Cantidad:</label>
    <?= $distribucionInicialCuv->getCantidad() ?>
  </div>
</fieldset>
<fieldset>
<legend>Serie CUV</legend>
<div data-linea="2">
    <label for="anio">CUV Inicio:</label>
    <?= $cuvInicio ?>
  </div>
  <div data-linea="2">
    <label for="anio">CUV Fin:</label>
    <?= $cuvFin ?>
  </div>
</fieldset>


<script type="text/javascript">
  $(document).ready(function() {
    construirValidador();
    distribuirLineas();
  });
</script>