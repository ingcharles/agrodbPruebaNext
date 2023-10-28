<header>
    <nav>
        <form action="aplicaciones/reportes/generarReporteOperadorParametrizado.php" method="post">

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
                <tr>
                <td>Tipo Operacion:</td>
						<td>
						<select id="cbxTipoOperacionArea" name="cbxTipoOperacionArea" style ="width: 100%;" >
                            <option value="RO Viveros">RO Viveros</option>
							<option value="RO Ferias y Comercialización SA">RO Ferias y Comercialización SA</option>	
                            <option value="RO_Productor_Ave_Porcino">RO Productor Avícola y Porcino</option>
							<option value="RO Predios de Cuarentena SA">RO Predios de Cuarentena SA</option>	
                            <option value="RO Apícola">RO Apícola</option>
							<option value="RO Material Reproductivo">RO Material Reproductivo</option>	
                            <option value="Empresas Fertilizantes">Empresas Fertilizantes</option>
							<option value="Empresas Agrícolas">Empresas Agrícolas</option>	
                            <option value="RO Centros de Faenamiento">RO Centros de Faenamiento</option>
							<option value="RO Industria Láctea">RO Industria Láctea</option>	
                            <option value="RO Acopio de Leche Cruda">RO Acopio de Leche Cruda</option>
							<option value="RO Almacenistas RIA">RO Almacenistas RIA</option>	
                            <option value="RO Centros de Propagación de Especies Vegetales">RO Centros Propagación de Vegetales</option>
							<option value="Exportación de Mercancías Pecuarias">Exportación de Mercancías Pecuarias</option>	
                            <option value="RO Ferias de Exposición Animal">RO Ferias de Exposición Animal</option>
							<option value="RO Predios de Cuarentena SV">RO Predios de Cuarentena SV</option>	
                            <option value="IAV">RO Registro de Insumos Pecuarios</option>
							<option value="IAP">RO Registro de Insumos Agrícolas</option>	
                            <option value="SA">RO Sanidad Animal</option>	
                            <option value="CGRIA">Coordinación Registro Insumos Agropecuarios</option>	
                            <option value="SV">RO Sanidad Vegetal</option>						
                            <option value="LT">RO Laboratorios</option>
                            <option value="AI">RO Inocuidad de Alimentos</option>
                            <option value="IAF">RO Registro Insumo Fertilizantes</option>						                           
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

