<header>
    <nav>
        <form action="aplicaciones/reportes/generarReporteImportacionSanidadAnimal.php" method="post">

            <table class="filtro">
                <tbody>
                <tr>
                    <td>Fecha Inicial</td>
                    <td><input name="fechaInicio" id="fechaInicio" type="text" required readonly></td>
                </tr>
                <tr>
                    <td>Fecha Final</td>
                    <td><input name="fechaFin" id="fechaFin" type="text" required readonly></td>
                </tr>
                <td>Tipo Reporte</td>
						<td>
						<select id="cbxTipoReporte" name="cbxTipoReporte" style ="width: 100%;" >
                            <option value="aprobado">Aprobados - Ampliados</option>
							<option value="rechazado">Rechazados</option>						                          
						</select>
						</td>
                </tr>

                <tr>
                    <td colspan="2">
                        <button>Generar reporte</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </nav>
</header>
<script>
    $(document).ready(function () {
        var fecha = new Date();
        fecha.setMonth(fecha.getMonth() - 3);
        $("#fechaInicio").datepicker({
            changeMonth: true,
            changeYear: true,
           
            dateFormat: "yy-mm-dd",
            defaultDate: -1
        }).datepicker('setDate', fecha);
        $("#fechaFin").datepicker({
            changeMonth: true,
            changeYear: true,
         
            dateFormat: "yy-mm-dd"
        }).datepicker('setDate', new Date());
    });
</script>

