<header>
    <h1><?php echo $this->accion; ?></h1>
</header>

    <?php echo $this->datosGenerales; ?>

<script type="text/javascript">

    $(document).ready(function () {
        construirValidador();
        distribuirLineas();
    });

</script>
