<header>
	<h1 id="tituloCabecera"><?php echo $this->accion; ?></h1>
</header>
	<link rel='stylesheet'
	href='<?php echo URL_MVC_MODULO ?>HistoriasClinicas/vistas/estilos/estiloModal.css'>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>HistoriasClinicas' data-opcion='HistoriaClinica/guardarRegistros' data-destino="detalleItem"  method="post">

<input type="hidden" id="id_historia_clinica" name="id_historia_clinica" value="" />
<input type="hidden" name="contenidoPDF" id="contenidoPDF">

<input type="hidden" name="evaluacionPrimariaInput" id="evaluacionPrimariaInput">
<input type="hidden" name="evaluacionPrimariaTxtInput" id="evaluacionPrimariaTxtInput">

<div class="pestania">
<fieldset id="contenedorBusqueda">
		<legend id="tituloCabecera">Nueva ficha inicial</legend>	
		<div data-linea="1">
			<label for="identificador">Documento de identificación:</label>
			<input type="text" id="identificador" name="identificador" value=""
			placeholder="Identificador" maxlength="16" />
		</div>	
				
		<div data-linea="1">
			<button type="button" class="buscar">Buscar</button>
		</div>
		<div data-linea="2">
			<label for="fecha_creacion">Fecha creación Historia Clínica:</label>
			<span><?php echo date("Y-m-d");  ?></span>
		</div>	
					
</fieldset>
	<fieldset id="divFuncionario">
		<?php echo $this->divUsuarioEmpresa;?>
	</fieldset>
	
	<div data-linea="3" id="contenedorCrearHistorio">
			<button type="button" id="crearHistoria" class="guardar" >Crear Historia Clínica</button>
	</div>
</div>

<div class="pestania">
	<fieldset id="motivoConsulta">
		<legend>B. Motivo de consulta</legend>				
		<div data-linea="1">
			<label >Motivo de consulta: </label>
			<span>Evaluación preocupacional / inicial</span>
		</div>						 					
	</fieldset >
</div>


<div class="pestania">
	<fieldset>
		<legend>C. Antecedentes personales</legend>				
		<div data-linea="1">
			<label for="id_tipo_procedimiento_medico_anteced_salud">Antecedentes:</label>
			<select id="id_tipo_procedimiento_medico_anteced_salud" name= "id_tipo_procedimiento_medico_anteced_salud">
				<?php echo $this->comboTipoProcedimiento('Antecedentes de salud');?>
			</select>
		</div>	
	</fieldset >

	<fieldset id="detalleAntecedentesSalud">
	</fieldset>

	<fieldset>
		<legend>Antecedentes clínicos y quirúrgicos agregados</legend>	
		<div id="listaAntecedentesSalud" style="width:100%"><?php echo $this->listarAntecedentesSalud($this->idHistorialClinica);?></div>
	</fieldset>
</div>


<div class="pestania">
	<fieldset>
		<legend>Exámenes realizados</legend>				

		<div data-linea="1">
			<label for="tipo_examen_realizado">Exámen realizado:</label>
			<select id="tipo_examen_realizado" name= "tipo_examen_realizado">
				<?php echo $this->comboTipoExamen();?>
			</select>
		</div>	
	</fieldset >

	<fieldset id="detalleExamenesRealizados">
	</fieldset>

	<fieldset>
		<legend>Exámenes realizados agregados</legend>	
		<div id="listaExamenesRealizados" style="width:100%"><?php echo $this->listarExamenesRealizados($this->idHistorialClinica);?></div>
	</fieldset>
</div>

<div class="pestania">
	<fieldset>
		<legend>Método de planificación familiar (personal masculino)</legend>				

		<div data-linea="1" id="metodoPlanificacionFamiliar">
			<label for="tipo_metodo_planificacion">Tipo:</label>
			<select id="tipo_metodo_planificacion" name= "tipo_metodo_planificacion">
				<?php echo $this->comboTipoMetodoPlanificacion();?>
			</select>
		</div>	
	</fieldset >

	<fieldset id="detalleMetodoPlanificacion">
	</fieldset>

	<fieldset>
		<legend>Métodos planificación agregados</legend>	
		<div id="listaMetodosPlanificacion" style="width:100%"><?php echo $this->listarMetodoPlanificacion($this->idHistorialClinica);?></div>
	</fieldset>
</div>

<div class="pestania">
	<fieldset>
		<legend>Hábitos tóxicos</legend>				
		<div data-linea="1">
			<label for="id_tipo_procedimiento_medico_habitos">Tipo de hábito:</label>
			<select id="id_tipo_procedimiento_medico_habitos" name= "id_tipo_procedimiento_medico_habitos" >
        		<?php echo $this->comboTipoProcedimiento('Frecuencia de drogas');?>
        	</select>
		</div>				
	</fieldset >
	<fieldset id="detalleHabitos">
	</fieldset>
	<fieldset>
		<legend>Hábitos tóxicos - Agregados</legend>		
		<div id="listaHabitos" style="width:100%"><?php echo $this->listarHabitos($this->idHistorialClinica);?></div>
	</fieldset>
</div>


<div class="pestania">
	<fieldset>
	<legend>Estilo de vida</legend>				
		<div data-linea="1">
			<label for="tipo_actividad">Tipo:</label>
			<select id="tipo_actividad" name= "tipo_actividad" >
        		<?php echo $this->comboActividad();?>
        	</select>
		</div>				
	</fieldset >
	<fieldset id="detalleEstiloVida">
	</fieldset>
	<fieldset>
		<legend>Estilo de vida - Agregados</legend>
		<div id="listaActividades" style="width:100%"><?php echo $this->listarActividad($this->idHistorialClinica);?></div>
	</fieldset>
</div>

<div class="pestania">
	<fieldset>
		<legend>Antecedentes de trabajo de historia ocupacional</legend>				
		<div data-linea="1">
			<label for="empresa">Empresa:</label>
			<input type="text" id="empresa" name="empresa" value=""
			placeholder="Nombre de la empresa"  maxlength="64" />
		</div>				
		<div data-linea="2">
			<label for="cargo">Puesto de trabajo: </label>
			<input type="text" id="cargo" name="cargo" value="" maxlength="64" />
		</div>	
		<div data-linea="3">
			<label for="actividades_trabajo">Actividades que desempeñaba: </label>
			<input type="text" id="actividades_trabajo" name="actividades_trabajo" value="" maxlength="64" />
		</div>
		<div data-linea="4">
			<label for="tiempo_exposicion">Tiempo de trabajo (meses): </label>
			<input type="text" id="tiempo_exposicion" name="tiempo_exposicion" value=""
			placeholder="Tiempo" maxlength="4" />
		</div>	
		<div data-linea="4">
			<label for="id_tipo_procedimiento_medico">Riesgo:</label>
			<select
				id="id_tipo_procedimiento_medico" name="id_tipo_procedimiento_medico">
				 <?php echo $this->comboTipoProcedimiento('Exposición'); ?>
			</select>
		</div>				
		<div data-linea="5">
			<label for="observaciones_trabajo">Observaciones: </label>
			<input type="text" id="observaciones_trabajo" name="observaciones_trabajo" value="" maxlength="256"  oninput="contador(this)"/>
		</div>
		<div data-linea="6">
			<span id="counter_observaciones_trabajo" style="font-size:11px"># carácteres, le quedan #.</span>
		</div>
		<div data-linea="7">
			<button type="button" class="mas" id="agregarExposicion">Agregar</button>
		</div>								
	</fieldset >
	<fieldset>
		<legend>Antecedentes de trabajo - agregados</legend>	
		<div id="listaHistoriaOcupacional" style="width:100%"><?php echo $this->listarHistoriaOcupacional($this->idHistorialClinica);?></div>	
	</fieldset>	
</div>


	<div class="pestania">
	<fieldset>
		<legend>Accidentes de trabajo (descripción)</legend>						
		<div data-linea="1">
			<label for="reportado_iess">¿Fué calificado por el Instituto de Seguridad Social correspondiente?: </label>
			<select id="reportado_iess" name= "reportado_iess">
				<?php echo $this->comboOpcion();?>
			</select>
		</div>				
		<div data-linea="2">
			<label for="instituto_seguridad">Especificar:</label>
			<select id="instituto_seguridad" name= "instituto_seguridad">
				<?php echo $this->comboSeguridadSocial();?>
			</select>
		</div>
		<div data-linea="2">
			<label for="fecha_trabajo_accidente">Fecha (aaaa/mm/dd): </label>
			<input type="text" id="fecha_trabajo_accidente" name="fecha_trabajo_accidente" value=""  maxlength="10" readonly/>
		</div>			
		<div data-linea="3">
			<label for="id_historia_ocupacional_accidente">Nombre de la empresa donde se presentó el accidente:</label>
			<select id="id_historia_ocupacional_accidente" name= "id_historia_ocupacional_accidente">
				<?php echo $this->comboHistoriaOcupacional($this->idHistorialClinica);?>
			</select>
		</div>	
		<div data-linea="4">
			<label for="puesto_trabajo_accidente">Puesto de trabajo:</label>
			<input type="text" id="puesto_trabajo_accidente" name="puesto_trabajo_accidente" value="" maxlength="32" />
		</div>				
		<div data-linea="5">
			<label for="area_trabajo_accidente">Área:</label>
			<input type="text" id="area_trabajo_accidente" name="area_trabajo_accidente" value="" maxlength="32" />
		</div>	
		<div data-linea="6">
			<label for="naturaleza_lesion">Tipo de lesión:</label>
			<input type="text" id="naturaleza_lesion" name="naturaleza_lesion" value="" maxlength="32" />
		</div>				

		<div data-linea="6">
			<label for="parte_afectada">Parte del cuerpo afectada:</label>
			<input type="text" id="parte_afectada" name="parte_afectada" value="" maxlength="32" />
		</div>	
		<div data-linea="7">
			<label for="dias_incapacidad">Días de incapacidad:</label>
			<input type="number" id="dias_incapacidad" name="dias_incapacidad" value=""  maxlength="3" />
		</div>				
		<div data-linea="7">
			<label for="secuelas">Secuelas: </label>
			<input type="text" id="secuelas" name="secuelas" value="" maxlength="32" />
		</div>
		<div data-linea="8">
			<label for="observaciones_trabajo_accidente">Observaciones:</label>
			<input type="text" id="observaciones_trabajo_accidente" name="observaciones_trabajo_accidente" value="" maxlength="128" />
		</div>	
		<div data-linea="9">
			<button type="button" class="mas" id="agregarAccidente">Agregar</button>
		</div>			
	</fieldset >
	<fieldset>
		<legend>Accidentes de trabajo - agregados</legend>	
		<div id="listaAccidenteLaboral" style="width:100%"><?php echo $this->listarAccidenteLaboral($this->idHistorialClinica);?></div>		
	</fieldset>
	</div>

	<div class="pestania">
		<fieldset>
			<legend>Enfermedades profesionales</legend>				
			<div data-linea="1">
				<label for="reportado_iess_enfermedad">¿Fué calificado por el Instituto de Seguridad Social correspondiente?: </label>
				<select id="reportado_iess_enfermedad" name= "reportado_iess_enfermedad">
					<?php echo $this->comboOpcion();?>
				</select>
			</div>	

			<div data-linea="2">
				<label for="instituto_seguridad_enfermedad">Especificar:</label>
				<select id="instituto_seguridad_enfermedad" name= "instituto_seguridad_enfermedad">
					<?php echo $this->comboSeguridadSocial();?>
				</select>
			</div>			

			<div data-linea="2">
				<label for="fecha_diagnostico">Fecha (aaaa/mm/dd): </label>
				<input type="text" id="fecha_diagnostico" name="fecha_diagnostico" value="<?php echo $this->modeloEnfermedadProfesional->getFechaDiagnostico(); ?>"
				placeholder="Seleccionar fecha"  maxlength="10" readonly/>
			</div>				

			<div data-linea="3">
				<label for="nombre_empresa_enfermedad">Nombre de la empresa:</label>
				<input type="text" id="nombre_empresa_enfermedad" name="nombre_empresa_enfermedad" value="" maxlength="32" />
			</div>	

			<div data-linea="4">
				<label for="puesto_trabajo_enfermedad">Puesto de trabajo:</label>
				<input type="text" id="puesto_trabajo_enfermedad" name="puesto_trabajo_enfermedad" value="" maxlength="32" />
			</div>				

			<div data-linea="5">
				<label for="area_trabajo_enfermedad">Área:</label>
				<input type="text" id="area_trabajo_enfermedad" name="area_trabajo_enfermedad" value="" maxlength="32" />
			</div>	

			<div data-linea="6">
				<label for="id_cie_enfermedad">CIE 10:</label>
				<select id="id_cie_enfermedad" name= "id_cie_enfermedad">
					<?php echo $this->comboCie10('codigo');?>
				</select>
			</div>

			<div data-linea="6">
				<label for="secuelas_enfermedad">Secuelas: </label>
				<input type="text" id="secuelas_enfermedad" name="secuelas_enfermedad" value="" maxlength="64" />
			</div>

			<div data-linea="7">
				<label for="observaciones_trabajo_enfermedad">Observaciones:</label>
				<input type="text" id="observaciones_trabajo_enfermedad" name="observaciones_trabajo_enfermedad" value="" maxlength="128" />
			</div>				
			
			<div data-linea="8">
				<button type="button" class="mas" id="agregarEnfermedad">Agregar</button>
			</div>
		</fieldset >
		<fieldset>
			<legend>Enfermedades profesionales - agregados</legend>	
			<div id="listaAEnfermedadProfesionales" style="width:100%"><?php echo $this->listarEnfermedadesProfesionales($this->idHistorialClinica);?></div>		
		</fieldset>
	</div>

	<div class="pestania">
	<fieldset>
		<legend>Antecedentes familiares (detallar el parentesco)</legend>				
		<div data-linea="1">
			<label for="id_tipo_procedimiento_medico_accidente">Parentesco:</label>
			<select id="id_tipo_procedimiento_medico_accidente" name= "id_tipo_procedimiento_medico_accidente">
				<?php echo $this->comboTipoProcedimiento('Parentesco');?>
			</select>
		</div>				

		<div data-linea="1">
			<label for="origen_parentesco">Origen del parentesco:</label>
			<select id="origen_parentesco" name= "origen_parentesco">
				<?php echo $this->comboOrigenParentesco();?>
			</select>
		</div>			

		<div data-linea="2">
			<label for="enfermedad_general">Enfermedad General: </label>
			<select id="enfermedad_general" name= "enfermedad_general">
				<?php echo $this->comboCie10('descripcion');?>
			</select>
		</div>

		<div data-linea="3">
			<label for="tipo_enfermedad_familiar">Tipo de enfermedad: </label>
			<select id="tipo_enfermedad_familiar" name= "tipo_enfermedad_familiar">
				<?php echo $this->comboTipoEnfermedad();?>
			</select>
		</div>				
		
		<div data-linea="4">
			<label for="especifique_familiar">Especifique: </label>
			<input type="text" id="especifique_familiar" name="especifique_familiar" maxlength="128" disabled />
		</div>	

		<div data-linea="5">
			<label for="observaciones">Observaciones: </label>
			<input type="text" id="observaciones" name="observaciones" value="" maxlength="128" />
		</div>	

		<div data-linea="6">
			<button type="button" class="mas" id="agregarAntecedentesFamiliares">Agregar</button>
		</div>
	</fieldset >
	<fieldset>
		<legend>Antecedentes familiares - agregados</legend>
		<div id="listaAntecedentesFamiliares" style="width:100%"><?php echo $this->listarAntecedentesFamiliares($this->idHistorialClinica);?></div>
	</fieldset>
	</div>


	<div class="pestania">
		<fieldset>
			<legend>Factores de riesgos del puesto de trabajo actual</legend>							
			<div data-linea="1">
				<label for="cargo_factor">Puesto de trabajo/area: </label>
				<input type="text" id="cargo_factor" name="cargo_factor" value="" maxlength="64" readonly />
			</div>			
			<div data-linea="2">
				<label for="actividades_factor">Actividades: </label>
				<input type="text" id="actividades_factor" name="actividades_factor" value="" maxlength="64" />
			</div>
			<div data-linea="3">
				<label for="medidas_factor">Medidas preventidas: </label>
				<input type="text" id="medidas_factor" name="medidas_factor" value="" maxlength="64" />
			</div>	
			<div data-linea="4">
				<label for="id_tipo_procedimiento_medico_factor">Tipo de Exposición:</label>
				<select
					id="id_tipo_procedimiento_medico_factor" name="id_tipo_procedimiento_medico_factor">
					 <?php echo $this->comboTipoProcedimiento('Exposición'); ?>
				</select>
			</div>						
			<div data-linea="5" id="subtipos">
			</div>
			<div data-linea="6">
			<button type="button" class="mas" id="agregarFactoresRiesgo">Agregar</button>
			</div>								
		</fieldset >
		<fieldset>
			<legend>Factores de riesgos - agregados</legend>	
			<div id="listaFactoresRiesgo" style="width:100%"><?php echo $this->listarFactoresRiesgo($this->idHistorialClinica);?></div>	
		</fieldset>	
	</div>


	<div class="pestania">
		<fieldset>
			<legend>Actividades extra laborales</legend>							
			<div data-linea="1">
				<label for="descripcion_actividad_extra">Descripción: </label>
				<textarea id="descripcion_actividad_extra" name="descripcion_actividad_extra" rows="5" cols="50"></textarea>
			</div>			
			<div data-linea="2">
			<button type="button" class="mas" id="agregarActividadesExtras">Agregar</button>
			</div>								
		</fieldset >
		<fieldset>
			<legend>Actividades extra laborales agregadas</legend>	
			<div id="listarActividadesExtras" style="width:100%"><?php echo $this->listarActividadesExtras($this->idHistorialClinica);?></div>	
		</fieldset>	
	</div>

	<div class="pestania">
		<fieldset>
			<legend>Enfermedad actual</legend>							
			<div data-linea="1">
				<label for="descripcion_enfermedad_actual">Descripción: </label>
				<textarea id="descripcion_enfermedad_actual" name="descripcion_enfermedad_actual" rows="5" cols="50"></textarea>
			</div>			
			<div data-linea="2">
				<button type="button" class="mas" id="agregarEnfermedadActual">Agregar</button>
			</div>								
		</fieldset >
		<fieldset>
			<legend>Enfermedad actual agregadas</legend>	
			<div id="listarEnfermedadActual" style="width:100%"><?php echo $this->listarEnfermedadActual($this->idHistorialClinica);?></div>	
		</fieldset>	
	</div>

	<div class="pestania">
	<fieldset>
		<legend>Revisión actual de órganos y sistemas</legend>	
		<?php echo $this->listarElementosPorAparatos($this->idHistorialClinica);?>
		<div data-linea="1">
			<button type="button" class="mas" id="agregarRevisionOrganos">Agregar</button>
		</div>
	</fieldset>
	<fieldset>
		<legend>Revisión actual de órganos y sistemas - Agregados</legend>	
		<div id="listaRevisionOrganos" style="width:100%"><?php echo $this->listarRevisionOrganos($this->idHistorialClinica);?></div>
	</fieldset>
	</div>

	<div class="pestania">
	<fieldset>
		<legend>Evaluación primaria</legend>				

		<div data-linea="1">
			<label for="tension_arterial">Presión arterial (mm/Hg):</label>
			<input type="text" id="tension_arterial" name="tension_arterial" value="<?php echo $this->modeloExamenFisico->getTensionArterial();?>"
			placeholder="Presión arterial"  maxlength="9" />
		</div>				

		<div data-linea="1">
			<label for="saturacion_oxigeno">Saturación de Oxígeno (02%): </label>
			<input type="text" id="saturacion_oxigeno" name="saturacion_oxigeno" value="<?php echo $this->modeloExamenFisico->getSaturacionOxigeno();?>"
			placeholder="Saturación de oxígeno"  maxlength="6" />
		</div>				

		<div data-linea="2">
			<label for="frecuencia_cardiaca">Frecuencia cardiaca (Lat/min):</label>
			<input type="text" id="frecuencia_cardiaca" name="frecuencia_cardiaca" value="<?php echo $this->modeloExamenFisico->getFrecuenciaCardiaca();?>"
			placeholder="Frecuencia cardiaca"  maxlength="6" />
		</div>				

		<div data-linea="2">
			<label for="frecuencia_respiratoria">Frecuencia respiratoria (fr/min): </label>
			<input type="text" id="frecuencia_respiratoria" name="frecuencia_respiratoria" value="<?php echo $this->modeloExamenFisico->getFrecuenciaRespiratoria();?>"
			placeholder="Frecuencia respiratoria"  maxlength="6" />
		</div>				

		<div data-linea="3">
			<label for="talla_mts">Talla (cm): </label>
			<input type="text" id="talla_mts" name="talla_mts" value="<?php echo $this->modeloExamenFisico->getTallaMts();?>"
			placeholder="Talla en cms"  maxlength="6" />
		</div>				

		<div data-linea="3">
			<label for="temperatura_c">Temperatura (°C):</label>
			<input type="text" id="temperatura_c" name="temperatura_c" value="<?php echo $this->modeloExamenFisico->getTemperaturaC();?>"
			placeholder="Temperatura"  maxlength="6" />
		</div>				

		<div data-linea="3">
			<label for="peso_kg">Peso (Kg):</label>
			<input type="text" id="peso_kg" name="peso_kg" value="<?php echo $this->modeloExamenFisico->getPesoKg();?>"
			placeholder="Peso"  maxlength="6" />
		</div>				

		<div data-linea="4">
			<label for="imc">Índice de masa corporal IMC (Peso (kg) / Talla (m2)):</label>
			<input type="text" id="imc" name="imc" value="<?php echo $this->modeloExamenFisico->getImc();?>"
			placeholder="Imc"  maxlength="6" readonly/>
		</div>				

		<div data-linea="5">
			<label for="interpretacion_imc">Interpretación IMC:</label>
			<input type="text" id="interpretacion_imc" name="interpretacion_imc" value="<?php echo $this->modeloExamenFisico->getInterpretacionImc();?>"
			placeholder="Interpretación IMC"  maxlength="16" readonly/>
		</div>

		<div data-linea="5">
			<label for="perimetro_abdominal">Perímetro abdominal (cm):</label>
			<input type="text" id="perimetro_abdominal" name="perimetro_abdominal" value="<?php echo $this->modeloExamenFisico->getPerimetroAbdominal();?>"
			placeholder="Perímetro abdominal"  maxlength="16"/>
		</div>				

	</fieldset >
	<fieldset>
		<legend>Evaluación Primaria</legend>				
        <?php echo $this->listarEvaluacion($this->idHistorialClinica);?>
	</fieldset >
	</div>

	<div class="pestania">
		<fieldset>
			<legend>Resultado por exámenes</legend>				
			<div data-linea="1">
				<label for="id_tipo_procedimiento_medico_exa_clinicos"><strong>Tipo de examen:</strong></label>
				<select id="id_tipo_procedimiento_medico_exa_clinicos" name= "id_tipo_procedimiento_medico_exa_clinicos" >
	        		<?php echo $this->comboTipoProcedimiento('Resultados exámen');?>
	        	</select>
			</div>				
		</fieldset >
		<fieldset id="detalleExamenesClinicos">
			</fieldset>
		<fieldset>
			<legend>Exámenes Clínicos - Agregados</legend>
			<div id="listaExamenesClinicos" style="width:100%"><?php echo $this->listarExamenesClinicos($this->idHistorialClinica);?></div>
		</fieldset>
	</div>

	<div class="pestania">
	<fieldset>
		<legend>Diagnóstico</legend>				

		<div data-linea="1">
			<label for="enfermedad_diagnostico">Enfermedad:</label>
			<input type="text" id="enfermedad_diagnostico" name="enfermedad_diagnostico" value="" placeholder="Enfermedad" maxlength="256" />
		</div>	

		<div data-linea="2">
			<label for="enfermedad_general_diagnosticada">Enfermedad General: </label>
			<select id="enfermedad_general_diagnosticada" name= "enfermedad_general_diagnosticada">
				<?php echo $this->comboCie10('descripcion');?>
			</select>
		</div>				

		<div data-linea="3">
			<label for="id_cie_diagnosticada">Código CIE 10:</label>
			<select id="id_cie_diagnosticada" name= "id_cie_diagnosticada">
				<?php echo $this->comboCie10('codigo');?>
			</select>
		</div>

		<div data-linea="3">
			<label for="subliteral">Subliteral:</label>
			<input type="text" id="subliteral" name="subliteral" value="" placeholder="subliteral"  maxlength="2" />
		</div>	

		<div data-linea="4">
			<label for="diagnostico">Diagnóstico:</label>
			<input type="text" id="diagnostico" name="diagnostico" value=""
			placeholder="diagnostico"  maxlength="128" />
		</div>				
		<div data-linea="5">
			<label for="estado_diagnostico">Estado: </label>
		</div>				
		<div data-linea="5">
			<input type="radio" name="estado_diagnostico[]" value="Presuntivo" />
			  <label for="estado_diagnostico">Presuntivo </label>
		</div>				

		<div data-linea="5">
			<input type="radio"  name="estado_diagnostico[]" value="Definitivo" />
			<label for="estado_diagnostico">Definitivo</label>
		</div>				

					
        <div data-linea="5">
			<button type="button" class="mas" id="agregarDiagnostico">Agregar</button>
		</div>
	</fieldset >
	<fieldset>
		<legend>Diagnósticos agregados</legend>	
		<div id="listaDiagnostico" style="width:100%"><?php echo $this->listarDiagnostico($this->idHistorialClinica);?></div>
	</fieldset>
	<fieldset>
		<legend>Aptitud médica para el trabajo</legend>				

		<div data-linea="1">
			<label for="descripcion_concepto">Tipo de aptitud:</label>
			<select id="descripcion_concepto" name= "descripcion_concepto">
				<?php echo $this->comboAptitud('codigo');?>
			</select>
		</div>	
		
		<div data-linea="2">
			<label id="tipo_restriccion_limitacion_label" for=tipo_restriccion_limitacion>Limitaciones: </label>
			<input type="text" id="tipo_restriccion_limitacion" name="tipo_restriccion_limitacion" value="<?php echo $this->modeloHistoriaClinica->getTipoRestriccionLimitacion(); ?>"
			placeholder="Limitación" maxlength="128" />
		</div>

		<div data-linea="3">
			<label id="tipo_restriccion_observacion_label" for=tipo_restriccion_observacion>Observación: </label>
			<input type="text" id="tipo_restriccion_observacion" name="tipo_restriccion_observacion" value="<?php echo $this->modeloHistoriaClinica->getTipoRestriccionObservacion(); ?>"
			placeholder="Observación" maxlength="128" />
		</div>

	</fieldset >
	</div>
	<div class="pestania">
		<fieldset>
		<legend>Recomendaciones y/o tratamiento</legend>				

		<div data-linea="1">
				<label for="descripcion_recomendaciones">Descripción: </label>
				<textarea id="descripcion_recomendaciones" name="descripcion_recomendaciones" rows="5" cols="50"></textarea>
			</div>			
			<div data-linea="2">
				<button type="button" class="mas" id="agregarRecomendacionTratamiento">Agregar</button>
			</div>
		</fieldset >	

		<fieldset>
			<legend>Recomendaciones y/o tratamiento - agregadas</legend>	
			<div id="listarRecomendacionTratamiento" style="width:100%"><?php echo $this->listarRecomendacionTratamiento($this->idHistorialClinica);?></div>	
		</fieldset>				

		<fieldset>
			<?php echo $this->firma;?>	
		</fieldset >
		<fieldset id="pdfHistoriaClinica">
			<legend>Historia Clínica PDF</legend>
			 <a href="<?php echo $this->adjuntoHistoriaClinica;?>" target="_blank" class="archivo_cargado" id="archivo_cargado">Descargar historia clínica</a>
		</fieldset >
		<div id="actualizarHistorial">
			<strong>Nota: Al hacer clic en el botón Actualizar, se guardarán las modificaciones realizadas en la historia clínica y con la información del médico ocupacional actualizado.</strong>
		</div>
		<div data-linea="5">
		 	<div id="cargarHistoriaClinica"></div>
			<button type="submit" class="guardar" id="guardarHistoriaClinica">Guardar historia clinica</button>
		</div>
		<fieldset id="registroCambios">
			<legend>Registro de modificaciones</legend>				
				<?php echo $this->historico;?>
	   </fieldset >
</div>
</form >
	<!-- Modal para datos del detalle del formulario -->
<div class="modal fade" id="modalDetalle" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">DETALLE DEL REGISTRO</h4>
				<div id="estado"></div>
			</div>
			<div class="modal-body">

				<div id="divDetalle">
				
				</div>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			<div id="estadoDetalle"></div>

		</div>
	</div>
</div>


<script type ="text/javascript">
var id_historia_clinica=<?php echo json_encode($this->idHistorialClinica);?>;
var descripcion_concepto=<?php echo json_encode($this->modeloHistoriaClinica->getDescripcionConcepto());?>;
var estado = <?php echo json_encode($this->estado);?>;
var adjuntoHC = <?php echo json_encode($this->adjuntoHistoriaClinica);?>;
	$(document).ready(function() {
		mostrarMensaje("", "FALLO");
		construirValidador();
		distribuirLineas();
		$("#modalDetalle").hide();
		construirAnimacion($(".pestania"));
        
        if(estado == 'nuevo'){
        	$("#crearHistoria").attr('disabled','disabled');
        	$("#registroCambios").hide();
        	$("#actualizarHistorial").hide();
        }else{
        	$("#contenedorCrearHistorio").remove();
        	$("#contenedorBusqueda").remove();
        	$("#registroCambios").show();
        	$("#actualizarHistorial").show();
        }
        $("#porcentaje_discapacidad").numeric();
		$("#tiempo_exposicion").numeric();
		$("#detalleAntecedentesSalud").hide();
		$("#detalleHabitos").hide();
		$("#detalleEstiloVida").hide();
		$("#saturacion_oxigeno").numeric();
		$("#frecuencia_cardiaca").numeric();
		$("#frecuencia_respiratoria").numeric();
		$("#dias_incapacidad").numeric();
		$("#talla_mts").numeric();
		$("#temperatura_c").numeric();
		$("#peso_kg").numeric();
		$("#detalleExamenesClinicos").hide();
		$(".archivo").val('');
		$("#detalleParaclinicos").hide();
		$("#pdfHistoriaClinica").hide();
		$("#detalleExamenesRealizados").hide();
		$("#detalleMetodoPlanificacion").hide();

		$("#subliteral").numeric();
		$("#tipo_restriccion_limitacion").hide();
		$("#tipo_restriccion_limitacion_label").hide();
		$("#tipo_restriccion_observacion").hide();
		$("#tipo_restriccion_observacion_label").hide();

		if(id_historia_clinica != null){
			$("#guardarHistoriaClinica").html('Actualizar historia clinica');
			$('#id_historia_clinica').val(id_historia_clinica);
			}
		if(adjuntoHC != null){
			$("#pdfHistoriaClinica").show();
			}
		//************************************************
		$("#descripcion_concepto").val(descripcion_concepto);
	 });

	$("#formulario").submit(function (event) {
	//$("#guardarHistoriaClinica").click(function (event) {

		var arrayEvaluacionPrimaria = $("input[name='evaluacionPrimaria[]']").map(function(){ if($(this).prop("checked")){return $(this).attr("id");}}).get();
		var arrayEvaluacionPrimariaTxt = $("input[name='evaluacionPrimariatxt[]']").map(function(){ if($(this).val()){return $(this).attr("id")+'-'+$(this).val()}}).get();

		$("#evaluacionPrimariaInput").val(JSON.stringify(arrayEvaluacionPrimaria));
		$("#evaluacionPrimariaTxtInput").val(JSON.stringify(arrayEvaluacionPrimariaTxt));


		event.preventDefault();
		var texto = "Por favor revise los campos obligatorios.";
		$(".alertaCombo").removeClass("alertaCombo");
		mostrarMensaje("", "FALLO");
		var error = false;

		if(!$.trim($("#tension_arterial").val())){
			   $("#tension_arterial").addClass("alertaCombo");
			   texto="Por favor revise los campos obligatorios en evaluación primaria";
			   error = true;
		}
		 if(!esCampoValidoExp("#tension_arterial",4)){
			 $("#tension_arterial").addClass("alertaCombo");
			   texto="Por favor solo números y / en evaluación primaria";
			   error = true;
		 }
		if(!$.trim($("#saturacion_oxigeno").val())){
			   $("#saturacion_oxigeno").addClass("alertaCombo");
			   texto="Por favor revise los campos obligatorios en evaluación primaria";
			   error = true;
		}
		if(!$.trim($("#frecuencia_cardiaca").val())){
			   $("#frecuencia_cardiaca").addClass("alertaCombo");
			   texto="Por favor revise los campos obligatorios en evaluación primaria";
			   error = true;
		}
		if(!$.trim($("#frecuencia_respiratoria").val())){
			   $("#frecuencia_respiratoria").addClass("alertaCombo");
			   texto="Por favor revise los campos obligatorios en evaluación primaria";
			   error = true;
		}
		if(!$.trim($("#talla_mts").val())){
			   $("#talla_mts").addClass("alertaCombo");
			   texto="Por favor revise los campos obligatorios en evaluación primaria";
			   error = true;
		}
		if(!$.trim($("#temperatura_c").val())){
			   $("#temperatura_c").addClass("alertaCombo");
			   texto="Por favor revise los campos obligatorios en evaluación primaria";
			   error = true;
		}
		if(!$.trim($("#peso_kg").val())){
			   $("#peso_kg").addClass("alertaCombo");
			   texto="Por favor revise los campos obligatorios en evaluación primaria";
			   error = true;
		}
		if(!$.trim($("#imc").val())){
			   $("#imc").addClass("alertaCombo");
			   texto="Por favor revise los campos obligatorios en evaluación primaria";
			   error = true;
		}
		if(!$.trim($("#interpretacion_imc").val())){
			   $("#interpretacion_imc").addClass("alertaCombo");
			   texto="Por favor revise los campos obligatorios en evaluación primaria";
			   error = true;
		}

		if(!$.trim($("#perimetro_abdominal").val())){
			   $("#perimetro_abdominal").addClass("alertaCombo");
			   texto="Por favor revise los campos obligatorios en evaluación primaria";
			   error = true;
		}
		//******************************************************
		if(!$("input[name='evaluacionPrimaria[]']").is(':checked') ){
			   $("#bodyEvaluacion").addClass("alertaCombo");
			   texto="Por favor revise los campos obligatorios en evaluacion primaria";
			   error = true;
		  }

		 //*************************************************
		 if(!$.trim($("#descripcion_concepto").val())){
			   $("#descripcion_concepto").addClass("alertaCombo");
			   texto="Por favor revise los campos obligatorios en aptitud médica";
			   error = true;
		}

		if($("#descripcion_concepto").val() == 'Apto en observación'){
			if(!$.trim($("#tipo_restriccion_observacion").val())){
			   $("#tipo_restriccion_observacion").addClass("alertaCombo");
			  texto="Por favor revise los campos obligatorios en aptitud médica";
			   error = true;
		  }
		}

		if($("#descripcion_concepto").val() == 'Apto con limitaciones'){
			if(!$.trim($("#tipo_restriccion_limitacion").val())){
			   $("#tipo_restriccion_limitacion").addClass("alertaCombo");
			  texto="Por favor revise los campos obligatorios en aptitud médica";
			   error = true;
		  }
		}

		if (!error) {
			var respuesta = JSON.parse(ejecutarJson($(this)).responseText);
			if (respuesta.estado == 'EXITO')
			{
				mostrarMensaje(respuesta.mensaje, respuesta.estado);
				abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"),"#listadoItems",true);
				$("#contenidoPDF").val(respuesta.contenido);
				$($(this)).attr('data-opcion', 'HistoriaClinica/certificadopdf');
				abrir($(this),event,false);
			}
			else 
			{
				mostrarMensaje(respuesta.mensaje, "FALLO");
			}
		} 
		else 
		{
			$("#estado").html(texto).addClass("alerta");
		}
	});


		//cpontrolar opcion otros de factores de riesgo
	function habilitarFactoresEspecifique(element) {
	  if ($(element).is(':checked')) {
	    $('#otros_factor').prop('disabled', false);
	  } else {
	    $('#otros_factor').prop('disabled', true);
	  }
	}


	//Función que agrega información del funcionario
      $(".buscar").click(function(){
    	$(".alertaCombo").removeClass("alertaCombo");
    	if($('#identificador').val()){
    	mostrarMensaje("", "FALLO");
    	$.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/buscarFuncionario", 
                {
            		identificador: $('#identificador').val()
                }, function (data) {
                	if (data.estado === 'EXITO') {
                		 $("#divFuncionario").html(data.usuarioEmpresa);
	                   	 $("#crearHistoria").removeAttr('disabled');
	                   	 mostrarMensaje(data.mensaje, data.estado);
	                     distribuirLineas();
	                     var primerNombre = $('label[for="primer_nombre"]').next('span').text();
	                     var camelPrimerNombre = primerNombre.charAt(0).toUpperCase() + primerNombre.slice(1).toLowerCase();
	                     var primerApellido = $('label[for="primer_apellido"]').next('span').text();
	                     var camelPrimerApellido = primerApellido.charAt(0).toUpperCase() + primerApellido.slice(1).toLowerCase();
	                     var nuevoTituloCabecera= "Nueva ficha inicial " + " - " + camelPrimerNombre + "  " + camelPrimerApellido;
	                     var puestoTrabajo = $("label[for='nombre_puesto']").next("span").text();
	                     $("#cargo_factor").val(puestoTrabajo); 
						$("#tituloCabecera").text(nuevoTituloCabecera);
						if(data.sexo == 'M'){
							$("#tipo_examen_realizado option[value='Papanicolaou']").remove();
							$("#tipo_examen_realizado option[value='Colposcopia']").remove();
							$("#tipo_examen_realizado option[value='Eco mamario']").remove();
							$("#tipo_examen_realizado option[value='Mamografía']").remove();
							$("#metodoPlanificacionFamiliar").show();
						}
						else{
							$("#tipo_examen_realizado option[value='Antígeno prostático']").remove();
							$("#tipo_examen_realizado option[value='Eco prostático']").remove();
							$("#metodoPlanificacionFamiliar").hide();
						}

                    } else {
                    	mostrarMensaje(data.mensaje, "FALLO");
                        $("#divFuncionario").html(data.usuarioEmpresa);
                        $("#crearHistoria").attr('disabled','disabled');
                        distribuirLineas();
                    }
        }, 'json');
        
    	}else{
    		mostrarMensaje("El campo esta vacio !!", "FALLO");
    		$('#identificador').addClass("alertaCombo");
    	}
    });

     //listar subtipos 
      $("#id_tipo_procedimiento_medico_factor").change(function () {
          if($('#id_tipo_procedimiento_medico_factor').val() != ''){
    	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/buscarSubtipos", 
                  {
              		tipoProcedimiento: $('#id_tipo_procedimiento_medico_factor').val()
                  }, function (data) {
                  	if (data.estado === 'EXITO') {
                          $("#subtipos").html(data.contenido);
                          mostrarMensaje(data.mensaje, data.estado);
                          distribuirLineas();
                      } else {
                    	  mostrarMensaje(data.mensaje, "FALLO");
                          $("#subtipos").html(data.contenido);
                          distribuirLineas();
                      }
          }, 'json');
          }
      });
	
	//crear historia clinica
	$("#crearHistoria").click(function (){
		if($("#identificador_paciente").val() != ''){
			if(validarCamposFuncionario()){
			 $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/crearHistoriaClinica", 
                  {
              		identificador_paciente: $('#identificador_paciente').val(),
              		tipo_discapacidad: $('#tipo_discapacidad').val(),
              		porcentaje_discapacidad: $('#porcentaje_discapacidad').val(),
              		actividades_relevantes: $('#actividades_relevantes').val(),
              		id_datos_contrato: $('#id_datos_contrato').val()

                  }, function (data) {
                  	if (data.estado === 'EXITO') {
                  		id_historia_clinica = data.contenido;
                  		$("#id_historia_clinica").val(id_historia_clinica);
                		$(".buscar").attr('disabled','disabled');
                		$("#crearHistoria").attr('disabled','disabled');
                		mostrarMensaje(data.mensaje, data.estado);
                      	distribuirLineas();
                      } else {
                    	 mostrarMensaje(data.mensaje, "FALLO");
                         distribuirLineas();
                      }
          			}, 'json');
			}
			else{
			mostrarMensaje("Todos los campos deben estar llenos - DATOS PERSONAL!!", "FALLO");
			}
		
		}else{
			mostrarMensaje("Debe seleccionar un funcionario !!", "FALLO");
			}
		});

 //********historial ocupacional************************************
      $("#agregarExposicion").click(function () {
			var texto = "Por favor revise los campos obligatorios.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
			var error = false;

			if(!$.trim($("#cargo").val())){
	  			   $("#cargo").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#id_tipo_procedimiento_medico").val())){
	  			   $("#id_tipo_procedimiento_medico").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#tiempo_exposicion").val())){
	  			   $("#tiempo_exposicion").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		if(!$.trim($("#actividades_trabajo").val())){
	  			   $("#actividades_trabajo").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		if(!$.trim($("#observaciones_trabajo").val())){
	  			   $("#observaciones_trabajo").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!id_historia_clinica){
				   texto = "Debe crear la Historia Clínica !!.";
	  			   error = true;
	  		  } 
			if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarExposicion", 
		                  {
			  		         id_historia_clinica: id_historia_clinica,
			  		         empresa:$("#empresa").val(),
				  		     cargo:$("#cargo").val(),
				  		     id_tipo_procedimiento_medico: $("#id_tipo_procedimiento_medico").val(),
				  		     tiempo_exposicion:$("#tiempo_exposicion").val(),
				  		     actividades_trabajo:$("#actividades_trabajo").val(),
				  		     observaciones_trabajo:$("#observaciones_trabajo").val(),
				  		     
		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listaHistoriaOcupacional").html(data.contenido);
		                  		$("#id_historia_ocupacional_accidente").html(data.accidente);
		                  		$("#cargo").val('');
		                  		$("#empresa").val('');
		                  		$("#tiempo_exposicion").val('');
		                  		$("#id_tipo_procedimiento_medico").val('');
		                  		$("#actividades_trabajo").val('');
		                  		$("#observaciones_trabajo").val('');
			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
      });

// eliminar subtipos agregados
     function eliminarSubtipo(id){
         $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarExposicion", 
                 {
                    id_historia_clinica: id_historia_clinica,
        	        id_historia_ocupacional: id
	  		         		  		     
                 }, function (data) {
                 	if (data.estado === 'EXITO') {
                 		$("#listaHistoriaOcupacional").html(data.contenido);
                 		$("#id_historia_ocupacional_accidente").html(data.accidente);
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                     } else {
                     	mostrarMensaje(data.mensaje, "FALLO");
                     }
         }, 'json');

      }

//seleccionar subtipos *************************************************
     function verificarCheckbox(id){
         if($(".checkTodos").prop("checked")){
        	 $(".case").prop("checked", true);
         }else{
        	 $(".case").prop("checked", false);
             }
         }


      //********enfermedad laboral***************************************
      $("#agregarEnfermedad").click(function () {
			var texto = "Por favor revise los campos obligatorios.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
			var error = false;

			if(!$.trim($("#reportado_iess_enfermedad").val())){
	  			   $("#reportado_iess_enfermedad").addClass("alertaCombo");
	  			   error = true;
	  		  }

	  		if($('#reportado_iess_enfermedad').val() == 'Si'){
	  			if(!$.trim($("#instituto_seguridad_enfermedad").val())){
	  			   $("#instituto_seguridad_enfermedad").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		}
	  		
	  		if(!$.trim($("#fecha_diagnostico").val())){
	  			   $("#fecha_diagnostico").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		if(!$.trim($("#nombre_empresa_enfermedad").val())){
	  			   $("#nombre_empresa_enfermedad").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		if(!$.trim($("#puesto_trabajo_enfermedad").val())){
	  			   $("#puesto_trabajo_enfermedad").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#area_trabajo_enfermedad").val())){
	  			   $("#area_trabajo_enfermedad").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#id_cie_enfermedad").val())){
	  			   $("#id_cie_enfermedad").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#secuelas_enfermedad").val())){
	  			   $("#secuelas_enfermedad").addClass("alertaCombo");
	  			   error = true;
	  		  }

	  		if(!$.trim($("#observaciones_trabajo_enfermedad").val())){
	  			   $("#observaciones_trabajo_enfermedad").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!id_historia_clinica){
				   texto = "Debe crear la Historia Clínica !!.";
	  			   error = true;
	  		  } 
	  		
			if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarEnfermedad", 
		                  {
			  		         id_historia_clinica: id_historia_clinica,
			  		         reportado_iess_enfermedad: $("#reportado_iess_enfermedad").val(),
			  		         instituto_seguridad_enfermedad:$("#instituto_seguridad_enfermedad").val(),
			  		         fecha_diagnostico: $("#fecha_diagnostico").val(),
			  		         nombre_empresa_enfermedad:$("#nombre_empresa_enfermedad").val(),
			  		         puesto_trabajo_enfermedad: $("#puesto_trabajo_enfermedad").val(),
			  		         area_trabajo_enfermedad:$("#area_trabajo_enfermedad").val(),
			  		         id_cie_enfermedad:$("#id_cie_enfermedad").val(),
			  		         secuelas_enfermedad:$("#secuelas_enfermedad").val(),
			  		         observaciones_trabajo_enfermedad:$("#observaciones_trabajo_enfermedad").val(),
				  		     
		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listaAEnfermedadProfesionales").html(data.contenido);
				  		        $("#reportado_iess_enfermedad").val('');
				  		        $("#instituto_seguridad_enfermedad").val('');
				  		        $("#fecha_diagnostico").val('');
				  		        $("#nombre_empresa_enfermedad").val('');
				  		        $("#puesto_trabajo_enfermedad").val('');
				  		        $("#area_trabajo_enfermedad").val('');
				  		        $("#id_cie_enfermedad").val('');
				  		        $("#secuelas_enfermedad").val('');
				  		        $("#observaciones_trabajo_enfermedad").val('');

			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
      });

      // eliminar enfermedad laboral
     function eliminarEnfermedad(id){
         $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarEnfermedad", 
                 {
                    id_historia_clinica: id_historia_clinica,
                    id_enfermedad_profesional: id
	  		         		  		     
                 }, function (data) {
                 	if (data.estado === 'EXITO') {
                 		$("#listaAEnfermedadProfesionales").html(data.contenido);
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                     } else {
                     	mostrarMensaje(data.mensaje, "FALLO");
                     }
         }, 'json');

      }



     //********accidente laboral***************************************
      $("#agregarAccidente").click(function () {
			var texto = "Por favor revise los campos obligatorios.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
			var error = false;

			if(!$.trim($("#reportado_iess").val())){
	  			   $("#reportado_iess").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		if(!$.trim($("#fecha_trabajo_accidente").val())){
	  			   $("#fecha_trabajo_accidente").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#id_historia_ocupacional_accidente").val())){
	  			   $("#id_historia_ocupacional_accidente").addClass("alertaCombo");
	  			   error = true;
	  		  }

	  		if($('#reportado_iess').val() == 'Si'){
	  			if(!$.trim($("#instituto_seguridad").val())){
	  			   $("#instituto_seguridad").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		}
	  		
	  		if(!$.trim($("#puesto_trabajo_accidente").val())){
	  			   $("#puesto_trabajo_accidente").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		if(!$.trim($("#area_trabajo_accidente").val())){
	  			   $("#area_trabajo_accidente").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#naturaleza_lesion").val())){
	  			   $("#naturaleza_lesion").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#dias_incapacidad").val())){
	  			   $("#dias_incapacidad").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#parte_afectada").val())){
	  			   $("#parte_afectada").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#secuelas").val())){
	  			   $("#secuelas").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		if(!$.trim($("#observaciones_trabajo_accidente").val())){
	  			   $("#observaciones_trabajo_accidente").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!id_historia_clinica){
				   texto = "Debe crear la Historia Clínica !!.";
	  			   error = true;
	  		  } 
	  		
			if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarAccidente", 
		                  {
			  		         id_historia_clinica: id_historia_clinica,
			  		         reportado_iess: $("#reportado_iess").val(),
			  		         id_historia_ocupacional:$("#id_historia_ocupacional_accidente").val(),
			  		         naturaleza_lesion: $("#naturaleza_lesion").val(),
			  		         dias_incapacidad:$("#dias_incapacidad").val(),
			  		         parte_afectada: $("#parte_afectada").val(),
			  		         secuelas:$("#secuelas").val(),

			  		         fecha_trabajo_accidente:$("#fecha_trabajo_accidente").val(),
			  		         instituto_seguridad:$("#instituto_seguridad").val(),
			  		         puesto_trabajo_accidente:$("#puesto_trabajo_accidente").val(),
			  		         area_trabajo_accidente:$("#area_trabajo_accidente").val(),
			  		         observaciones_trabajo_accidente:$("#observaciones_trabajo_accidente").val()
				  		     
		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listaAccidenteLaboral").html(data.contenido);
				  		        $("#reportado_iess").val('');
				  		        $("#id_historia_ocupacional_accidente").val('');
				  		        $("#naturaleza_lesion").val('');
				  		        $("#dias_incapacidad").val('');
				  		        $("#parte_afectada").val('');
				  		        $("#secuelas").val('');

				  		        $("#fecha_trabajo_accidente").val('');
				  		        $("#instituto_seguridad").val('');
				  		        $("#puesto_trabajo_accidente").val('');
				  		        $("#area_trabajo_accidente").val('');
				  		        $("#observaciones_trabajo_accidente").val('');

			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
      });
      // eliminar accidentes agregados
     function eliminarAccidente(id){
         $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarAccidente", 
                 {
                    id_historia_clinica: id_historia_clinica,
                    id_accidentes_laborales: id
	  		         		  		     
                 }, function (data) {
                 	if (data.estado === 'EXITO') {
                 		$("#listaAccidenteLaboral").html(data.contenido);
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                     } else {
                     	mostrarMensaje(data.mensaje, "FALLO");
                     }
         }, 'json');

      }

   //******fecha de diagnostico************************************************
     $("#fecha_diagnostico").datepicker({
     	yearRange: "c:c",
     	changeMonth: false,
         changeYear: false,
         dateFormat: 'yy-mm-dd',
       });

     $("#fecha_trabajo_accidente").datepicker({
     	yearRange: "c:c",
     	changeMonth: false,
         changeYear: false,
         dateFormat: 'yy-mm-dd',
       });

     //*******enfermedad profesional*******************************************
     $("#tiene_enfermedad").change(function () {
		if($("#tiene_enfermedad").val() == 'No'){
			
    		$("#fecha_diagnostico").attr('disabled','disabled');
    		$("#descripcion").attr('disabled','disabled');
    		$("#fecha_diagnostico").val('');
    		$("#descripcion").val('');
		}else{
			$("#fecha_diagnostico").removeAttr('disabled');
			$("#descripcion").removeAttr('disabled');
			}
     });

     //*******antecedentes familiares (detallar parentesco) ********************
     $("#tipo_enfermedad_familiar").change(function () {
		if($("#tipo_enfermedad_familiar").val() == '8. Otros'){
			$("#especifique_familiar").removeAttr('disabled');
		}else{
			$("#especifique_familiar").attr('disabled','disabled');
		}
     });

     //**********cie10*********************************************************
     $("#enfermedad_general").change(function () {
	     $("#id_cie").val($(this).val());
     });
     $("#id_cie").change(function () {
    	 $("#enfermedad_general").val($(this).val());
     });
     //********accidente laboral*************************************** 
     $("#agregarAntecedentesFamiliares").click(function () {
			var texto = "Por favor revise los campos obligatorios.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
			var error = false;
			if(!$.trim($("#id_tipo_procedimiento_medico_accidente").val())){
	  			   $("#id_tipo_procedimiento_medico_accidente").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		if(!$.trim($("#origen_parentesco").val())){
	  			   $("#origen_parentesco").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#enfermedad_general").val())){
	  			   $("#enfermedad_general").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		if(!$.trim($("#tipo_enfermedad_familiar").val())){
	  			   $("#tipo_enfermedad_familiar").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		if(!$.trim($("#especifique_familiar").val()) && ($("#tipo_enfermedad_familiar").val() == '8. Otros')){
	  			   $("#especifique_familiar").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		if(!$.trim($("#observaciones").val())){
	  			   $("#observaciones").addClass("alertaCombo");
	  			   error = true;
	  		  }

			if(!id_historia_clinica){
				   texto = "Debe crear la Historia Clínica !!.";
	  			   error = true;
	  		  } 
			if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarAntecedentesFamiliares", 
		                  {
			  		         id_historia_clinica:id_historia_clinica,
			  		         id_tipo_procedimiento_medico:$("#id_tipo_procedimiento_medico_accidente").val(),
			  		         origen_parentesco:$("#origen_parentesco").val(),
			  		         enfermedad_general:$("#enfermedad_general").val(),
			  		         tipo_enfermedad_familiar:$("#tipo_enfermedad_familiar").val(),
			  		         especifique_familiar:$("#especifique_familiar").val(),
			  		         observaciones:$("#observaciones").val()
				  		     
		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listaAntecedentesFamiliares").html(data.contenido);
		                  		$("#id_tipo_procedimiento_medico_accidente").val('');
				  		        $("#origen_parentesco").val('');
				  		        $("#enfermedad_general").val('');
				  		        $("#tipo_enfermedad_familiar").val('');
				  		        $("#especifique_familiar").val('');
				  		        $("#observaciones").val('');
			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
     });
     // eliminar accidentes agregados
    function eliminarAntecedentesFamiliares(id){
        $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarAntecedentesFamiliares", 
                {
                   id_historia_clinica: id_historia_clinica,
                   id_anteced_salud_familiar: id
	  		         		  		     
                }, function (data) {
                	if (data.estado === 'EXITO') {
                		$("#listaAntecedentesFamiliares").html(data.contenido);
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                    } else {
                    	mostrarMensaje(data.mensaje, "FALLO");
                    }
        }, 'json');

     }

//******************************** examenes realizado *************************************** 
  $("#tipo_examen_realizado").change(function () {
	  if($("#tipo_examen_realizado").val()){
	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/buscarExamenesRealizados", 
              {
                 id_historia_clinica:id_historia_clinica,
                 tipo_examen_realizado: $("#tipo_examen_realizado").val(),
                 tipo: $("#tipo_examen_realizado option:selected").text()
	  		         		  		     
              }, function (data) {
              	if (data.estado === 'EXITO') {
              		    $("#detalleExamenesRealizados").html(data.contenido);
              		    $("#detalleExamenesRealizados").show();
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
	                    $("#examen_tiempo").numeric();
                  } else {
                  	mostrarMensaje(data.mensaje, "FALLO");
                  }
      }, 'json');
	  }else{
		  $("#detalleExamenesRealizados").html('');
		  $("#detalleExamenesRealizados").hide();
		   }
     });

	function agregarExamenesRealizados()
	{
			event.stopImmediatePropagation();
			var texto = "Por favor revise los campos obligatorios.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
			var error = false;
			error = validarCamposExamenesRealizados();
			if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarExamenesRealizados", 
		                  {
			  		         id_historia_clinica:id_historia_clinica,
			  		         tiempo_anios:$("#examen_tiempo").val(),
			  		         resultado:$("#examen_resultado").val(),
			  		         tipo_examen:$("#tipo_examen_realizado").val()
				  		     
		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listaExamenesRealizados").html(data.contenido);
		                  		$("#detalleExamenesRealizados").html('');
		           		        $("#detalleExamenesRealizados").hide();
			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
	   }

	function eliminarExamenRealizado(id){
	   $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarExamenRealizado", 
	           {
	              id_historia_clinica: id_historia_clinica,
	              id_examen_realizado: id
	  		         		  		     
	           }, function (data) {
	           	if (data.estado === 'EXITO') {
	           		    $("#listaExamenesRealizados").html(data.contenido);
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
	               } else {
	               	mostrarMensaje(data.mensaje, "FALLO");
	               }
	   }, 'json');

	}



//******************************** metodo planificacion *************************************** 
  $("#tipo_metodo_planificacion").change(function () {
	  if($("#tipo_metodo_planificacion").val()){
	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/buscarMetodoPlanificacion", 
              {
                 id_historia_clinica:id_historia_clinica,
                 tipo_metodo_planificacion: $("#tipo_metodo_planificacion").val(),
                 tipo: $("#tipo_metodo_planificacion option:selected").text()
	  		         		  		     
              }, function (data) {
              	if (data.estado === 'EXITO') {
              		    $("#detalleMetodoPlanificacion").html(data.contenido);
              		    $("#detalleMetodoPlanificacion").show();
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
	                    $("#hijos_vivos").numeric();
	                    $("#hijos_muertos").numeric();

                  } else {
                  	mostrarMensaje(data.mensaje, "FALLO");
                  }
      }, 'json');
	  }else{
		  $("#detalleMetodoPlanificacion").html('');
		  $("#detalleMetodoPlanificacion").hide();
		   }
     });

	function agregarMetodoPlanificacion()
	{
			event.stopImmediatePropagation();
			var texto = "Por favor revise los campos obligatorios.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
			var error = false;
			error = validarCamposMetodoPlanificacion();
			if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarMetodoPlanificacion", 
		                  {
			  		         id_historia_clinica:id_historia_clinica,
			  		         tipo_metodo:$("#tipo_metodo_planificacion").val(),
			  		         hijos_vivos:$("#hijos_vivos").val(),
			  		         hijos_muertos:$("#hijos_muertos").val(),
			  		         otro_metodo:$("#otro_metodo").val()
				  		     
		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listaMetodosPlanificacion").html(data.contenido);
		                  		$("#detalleMetodoPlanificacion").html('');
		           		        $("#detalleMetodoPlanificacion").hide();
			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
	   }
	   
	function eliminarMetodoPlanificacion(id){
	   $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarMetodoPlanificacion", 
	           {
	              id_historia_clinica: id_historia_clinica,
	              id_metodo_planificacion: id
	  		         		  		     
	           }, function (data) {
	           	if (data.estado === 'EXITO') {
	           		    $("#listaMetodosPlanificacion").html(data.contenido);
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
	               } else {
	               	mostrarMensaje(data.mensaje, "FALLO");
	               }
	   }, 'json');

	}

 //********Factores de Riesgo************************************
      $("#agregarFactoresRiesgo").click(function () {
			var texto = "Por favor revise los campos obligatorios.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
			var error = false;
			if(!$.trim($("#cargo_factor").val())){
	  			   $("#cargo_factor").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#actividades_factor").val())){
	  			   $("#actividades_factor").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		if(!$.trim($("#medidas_factor").val())){
	  			   $("#medidas_factor").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#id_tipo_procedimiento_medico_factor").val())){
	  			   $("#id_tipo_procedimiento_medico_factor").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		if($("input[name='subtipoList[]']").length > 0 && !$("input[name='subtipoList[]']").is(':checked') && !$('#checboxOtrosFactores').is(':checked')){
	  			 texto = "Debe seleccionar un subtipo de exposición !!.";
	  			$("#subtipos").addClass("alertaCombo");
	  			 error = true;
		  		}

		  	if($('#checboxOtrosFactores').is(':checked')){
		  		if(!$.trim($("#otros_factor").val())){
	  			   $("#otros_factor").addClass("alertaCombo");
	  			   error = true;
	  		  }
		  	}

			if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarFactorRiesgo", 
		                  {
			  		         id_historia_clinica: id_historia_clinica,
			  		         cargo_factor:$("#cargo_factor").val(),
				  		     actividades_factor:$("#actividades_factor").val(),
				  		     medidas_factor: $("#medidas_factor").val(),
				  		     id_tipo_procedimiento_medico: $("#id_tipo_procedimiento_medico_factor").val(),
				  		     otros_factor: $("#otros_factor").val(),
				  		     subtipoList:$("input[name='subtipoList[]']").map(function(){ if($(this).prop("checked")){return $(this).val();}}).get()
				  		     
		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listaFactoresRiesgo").html(data.contenido);		                  		
		                  		$("#cargo_factor").val('');
		                  		$("#actividades_factor").val('');
		                  		$("#medidas_factor").val('');
		                  		$("#id_tipo_procedimiento_medico_factor").val('');
		                  		$("#subtipos").html('');
			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
      });

    function eliminarFactorRiesgo(id){
         $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarFactorRiesgo", 
                 {
                    id_historia_clinica: id_historia_clinica,
        	        id_factor_riesgo: id
	  		         		  		     
                 }, function (data) {
                 	if (data.estado === 'EXITO') {
                 		$("#listaFactoresRiesgo").html(data.contenido);
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                     } else {
                     	mostrarMensaje(data.mensaje, "FALLO");
                     }
         }, 'json');
      }


//********Actividades Extra laborales************************************
      $("#agregarActividadesExtras").click(function () {
			var texto = "Por favor revise los campos obligatorios.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
			var error = false;
			if(!$.trim($("#descripcion_actividad_extra").val())){
	  			   $("#descripcion_actividad_extra").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarActividadesExtras", 
		                  {
			  		         id_historia_clinica: id_historia_clinica,
			  		         descripcion: $("#descripcion_actividad_extra").val(),
			  		         tipo: 'A'

		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listarActividadesExtras").html(data.contenido);		                  		
		                  		$("#descripcion_actividad_extra").val('');
			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
      });

    function eliminarActividadesExtras(id){
         $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarActividadesExtras", 
                 {
                    id_historia_clinica: id_historia_clinica,
        	        id_actividad_enfermedad: id
	  		         		  		     
                 }, function (data) {
                 	if (data.estado === 'EXITO') {
                 		$("#listarActividadesExtras").html(data.contenido);
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                     } else {
                     	mostrarMensaje(data.mensaje, "FALLO");
                     }
         }, 'json');
      }


//**************************Enfermedad Actual ************************************
      $("#agregarEnfermedadActual").click(function () {
			var texto = "Por favor revise los campos obligatorios.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
			var error = false;
			if(!$.trim($("#descripcion_enfermedad_actual").val())){
	  			   $("#descripcion_enfermedad_actual").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarEnfermedadActual", 
		                  {
			  		         id_historia_clinica: id_historia_clinica,
			  		         descripcion:$("#descripcion_enfermedad_actual").val(),
			  		         tipo:'E'
				  		     
		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listarEnfermedadActual").html(data.contenido);		                  		
		                  		$("#descripcion_enfermedad_actual").val('');
			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
      });

    function eliminarEnfermedadActual(id){
         $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarEnfermedadActual", 
                 {
                    id_historia_clinica: id_historia_clinica,
        	        id_actividad_enfermedad: id
	  		         		  		     
                 }, function (data) {
                 	if (data.estado === 'EXITO') {
                 		$("#listarEnfermedadActual").html(data.contenido);
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                     } else {
                     	mostrarMensaje(data.mensaje, "FALLO");
                     }
         }, 'json');
      }


//**************************Recomendaciones y tratamiento ************************************
      $("#agregarRecomendacionTratamiento").click(function () {
			var texto = "Por favor revise los campos obligatorios.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
			var error = false;
			if(!$.trim($("#descripcion_recomendaciones").val())){
	  			   $("#descripcion_recomendaciones").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarRecomendacionTratamiento", 
		                  {
			  		         id_historia_clinica: id_historia_clinica,
			  		         descripcion:$("#descripcion_recomendaciones").val()
				  		     
		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listarRecomendacionTratamiento").html(data.contenido);		                  		
		                  		$("#descripcion_recomendaciones").val('');
			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
      });

    function eliminarRecomendacionTratamiento(id){
         $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarRecomendacionTratamiento", 
                 {
                    id_historia_clinica: id_historia_clinica,
        	        id_recomendaciones: id
	  		         		  		     
                 }, function (data) {
                 	if (data.estado === 'EXITO') {
                 		$("#listarRecomendacionTratamiento").html(data.contenido);
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                     } else {
                     	mostrarMensaje(data.mensaje, "FALLO");
                     }
         }, 'json');
      }


//********************************antecedentes de salud *************************************** 
  $("#id_tipo_procedimiento_medico_anteced_salud").change(function () {
	  if($("#id_tipo_procedimiento_medico_anteced_salud").val()){
	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/buscarAntecedentesSalud", 
              {
                 id_historia_clinica:id_historia_clinica,
                 id_tipo_procedimiento_medico: $("#id_tipo_procedimiento_medico_anteced_salud").val(),
                 tipo: $("#id_tipo_procedimiento_medico_anteced_salud option:selected").text()
	  		         		  		     
              }, function (data) {
              	if (data.estado === 'EXITO') {
              		    $("#detalleAntecedentesSalud").html(data.contenido);
              		    $("#detalleAntecedentesSalud").show();
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                  } else {
                  	mostrarMensaje(data.mensaje, "FALLO");
                  }
      }, 'json');
	  }else{
		  $("#detalleAntecedentesSalud").html('');
		  $("#detalleAntecedentesSalud").hide();
		   }
     });

  //****************************************************************************************
        function agregarAntecedentesSalud(){
    		event.stopImmediatePropagation();
			var texto = "Por favor revise los campos obligatorios.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
			var error = false;
			error = validarCamposAntecedentes($("#id_tipo_procedimiento_medico_anteced_salud option:selected").text());
			if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarAntecedentesSalud", 
		                  {
			  		         id_historia_clinica:id_historia_clinica,
			  		         id_tipo_procedimiento_medico:$("#id_tipo_procedimiento_medico_anteced_salud").val(),
			  		         id_cie:$("#id_cie_salud").val(),
			  		         enfermedad_general:$("#enfermedad_general_salud").val(),
			  		         diagnostico:$("#diagnostico_salud").val(),
			  		         observaciones:$("#observaciones_salud").val(),
			  		         menarquia:$("#menarquia").val(),
			  		         ciclo_mestrual:$("#ciclo_mestrual").val(),
			  		         fecha_ultima_regla:$("#fecha_ultima_regla").val(),
			  		         numero_gestaciones:$("#numero_gestaciones").val(),
			  		         numero_partos:$("#numero_partos").val(),
			  		         numero_cesareas:$("#numero_cesareas").val(),
			  		         numero_abortos:$("#numero_abortos").val(),
			  		         numero_hijos_vivos:$("#numero_hijos_vivos").val(),
			  		         numero_hijos_muertos:$("#numero_hijos_muertos").val(),
			  		         embarazo:$("#embarazo").val(),
			  		         semanas_gestacion:$("#semanas_gestacion").val(),
			  		         numero_ecos:$("#numero_ecos").val(),
			  		         numero_controles_embarazo:$("#numero_controles_embarazo").val(),
			  		         complicaciones:$("#complicaciones").val(),
			  		         vida_sexual_activa:$("#vida_sexual_activa").val(),
			  		         planificacion_familiar:$("#planificacion_familiar").val(),
			  		         tipo_planificacion_familiar:$("#tipo_planificacion_familiar").val(),
			  		         metodo_planificacion:$("#metodo_planificacion").val()
				  		     
		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listaAntecedentesSalud").html(data.contenido);
		                  		$("#detalleAntecedentesSalud").html('');
		           		        $("#detalleAntecedentesSalud").hide();
			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
    }
    // eliminar antecedentes de salud agregados  informacionAntecedentesSalud
   function eliminarAntecedentesSalud(id){
       $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarAntecedentesSalud", 
               {
                  id_historia_clinica: id_historia_clinica,
                  id_antecedentes_salud: id
	  		         		  		     
               }, function (data) {
               	if (data.estado === 'EXITO') {
               		    $("#listaAntecedentesSalud").html(data.contenido);
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                   } else {
                   	mostrarMensaje(data.mensaje, "FALLO");
                   }
       }, 'json');

    }
   // previsualizar información antecedentes de salud agregados  
   function informacionAntecedentesSalud(id){
       $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/informacionAntecedentesSalud", 
               {
                  id_historia_clinica: id_historia_clinica,
                  id_antecedentes_salud: id
	  		         		  		     
               }, function (data) {
               		    $('#modalDetalle').modal('show');
                        $("#divDetalle").html(data);
       });

    }
   //**********cie10*********************************************************
   $(document).on('change','#enfermedad_general_salud',function(){
	   event.stopPropagation();
	  $("#id_cie_salud").val($(this).val());
   });
   $(document).on('change','#id_cie_salud',function(){
	   event.stopPropagation();
  	 $("#enfermedad_general_salud").val($(this).val());
   });
	//*****************verificar campos***********************************
	function validarCamposAntecedentes(opt){
		var error1 = false;
		switch (opt) { 
		case 'Clínicos': 
			if(!$.trim($("#enfermedad_general_salud").val())){
	  			   $("#enfermedad_general_salud").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#id_cie_salud").val())){
	  			   $("#id_cie_salud").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#diagnostico_salud").val())){
	  			   $("#diagnostico_salud").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#observaciones_salud").val())){
	  			   $("#observaciones_salud").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			break;
		case 'Gineco Obstétricos': 

			if(!$.trim($("#menarquia").val())){
	  			   $("#menarquia").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#ciclo_mestrual").val())){
	  			   $("#ciclo_mestrual").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#fecha_ultima_regla").val())){
	  			   $("#fecha_ultima_regla").addClass("alertaCombo");
	  			   error1 = true;
	  		  }			
			if(!$.trim($("#numero_gestaciones").val())){
	  			   $("#numero_gestaciones").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#numero_partos").val())){
	  			   $("#numero_partos").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#numero_cesareas").val())){
	  			   $("#numero_cesareas").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#numero_abortos").val())){
	  			   $("#numero_abortos").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#numero_hijos_vivos").val())){
	  			   $("#numero_hijos_vivos").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#numero_hijos_muertos").val())){
	  			   $("#numero_hijos_muertos").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#embarazo").val())){
	  			   $("#embarazo").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
	  		  
			if($("#embarazo").val() == 'Si'){
				
			if(!$.trim($("#semanas_gestacion").val())){
	  			   $("#semanas_gestacion").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#numero_ecos").val())){
	  			   $("#numero_ecos").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#numero_controles_embarazo").val())){
	  			   $("#numero_controles_embarazo").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#complicaciones").val())){
	  			   $("#complicaciones").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			}
			if(!$.trim($("#vida_sexual_activa").val())){
	  			   $("#vida_sexual_activa").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#planificacion_familiar").val())){
	  			   $("#planificacion_familiar").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if($("#planificacion_familiar").val() == 'Si'){
    			if(!$.trim($("#tipo_planificacion_familiar").val())){
    	  			   $("#tipo_planificacion_familiar").addClass("alertaCombo");
    	  			   error1 = true;
    	  		  }
			}
			if($("#tipo_planificacion_familiar").val() == 'Otros'){
    			if(!$.trim($("#metodo_planificacion").val())){
    	  			   $("#metodo_planificacion").addClass("alertaCombo");
    	  			   error1 = true;
    	  		  }
			}

			break;
		default:
			if(!$.trim($("#diagnostico_salud").val())){
	  			   $("#diagnostico_salud").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
			if(!$.trim($("#observaciones_salud").val())){
	  			   $("#observaciones_salud").addClass("alertaCombo");
	  			   error1 = true;
	  		  }
	       }
		  return error1;
	    
		}


	function validarCamposExamenesRealizados(){
		var error1 = false;
		if(!$.trim($("#examen_tiempo").val()))
		{
		   $("#examen_tiempo").addClass("alertaCombo");
		   error1 = true;
	  	}
	  	if(!$.trim($("#examen_resultado").val()))
		{
		   $("#examen_resultado").addClass("alertaCombo");
		   error1 = true;
	  	}

	 	return error1;
	}

	function validarCamposMetodoPlanificacion(){
		var error1 = false;
		if(!$.trim($("#tipo_metodo_planificacion").val()))
		{
		   $("#tipo_metodo_planificacion").addClass("alertaCombo");
		   error1 = true;
	  	}
		if(!$.trim($("#hijos_vivos").val()))
		{
		   $("#hijos_vivos").addClass("alertaCombo");
		   error1 = true;
	  	}
	  	if(!$.trim($("#hijos_muertos").val()))
		{
		   $("#hijos_muertos").addClass("alertaCombo");
		   error1 = true;
	  	}

	  	if($("#tipo_metodo_planificacion").val()=='Otros')
		{
		   if(!$.trim($("#otro_metodo").val())){
		   		$("#otro_metodo").addClass("alertaCombo");
		   		error1 = true;
		   }
		   
	  	}

	 	return error1;
	}


	//************embarazo**************************
	$(document).on('change','#embarazo',function(){
		   event.stopPropagation();
		   if($(this).val() == 'Si'){
				 $("#semanas_gestacion").removeAttr('disabled');
				 $("#numero_ecos").removeAttr('disabled');
				 $("#numero_controles_embarazo").removeAttr('disabled');
				 $("#complicaciones").removeAttr('disabled');
	       }else{
	        	 $("#semanas_gestacion").val('');
				 $("#numero_ecos").val('');  
				 $("#numero_controles_embarazo").val('');
				 $("#complicaciones").val('');  
	        	 $("#semanas_gestacion").attr('disabled','disabled');
				 $("#numero_ecos").attr('disabled','disabled');
				 $("#numero_controles_embarazo").attr('disabled','disabled');
				 $("#complicaciones").attr('disabled','disabled');
	      }
	   });
	//************planificación familiar**************************
	$(document).on('change','#planificacion_familiar',function(){
		   event.stopPropagation();
		   if($(this).val() == 'Si'){
				 $("#tipo_planificacion_familiar").removeAttr('disabled');
	       }else{
	       	     $("#tipo_planificacion_familiar").attr('disabled','disabled');
	        	 $("#metodo_planificacion").attr('disabled','disabled');
	        	 $("#tipo_planificacion_familiar").val('');
	       	     $("#metodo_planificacion").val('');
	      }
	   });

	//************tipo planificación familiar**************************
	$(document).on('change','#tipo_planificacion_familiar',function(){
		   event.stopPropagation();
		   if($(this).val() == 'Otros'){
				 $("#metodo_planificacion").removeAttr('disabled');
	       }else{
	        	 $("#metodo_planificacion").val('');
	        	 $("#metodo_planificacion").attr('disabled','disabled');
	      }
	   });

	//******fecha de ultima regla************************************************
	$(document).on('click',"#ciclo_mestrual", function(){
    $("#fecha_ultima_regla").datepicker({
    	yearRange: "c:c",
    	changeMonth: false,
        changeYear: false,
        dateFormat: 'yy-mm-dd',
      });
	});
	//**************fecha inmunizacion********************************************
	 $("#fecha_ultima_dosis").datepicker({
    	yearRange: "c:c",
    	changeMonth: false,
        changeYear: false,
        dateFormat: 'yy-mm',
      });
	//*******************************sistemas *************************************
	 $("#agregarRevisionOrganos").click(function () {
    		event.stopImmediatePropagation();
			var texto = "Debe seleccionar un campo.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
 			var error = false;
            var subtipoList = $("input[name='revisionAparatos[]']").map(function(){ if($(this).prop("checked")){return $(this).attr("id")+','+$(this).val()}}).get();
	        var subtipoTxt = $("input[name='revisionAparatosTxt[]']").map(function(){ if($(this).val()){return $(this).attr("id")+','+$(this).val()}}).get();
        	if(subtipoList.length == 0){
        		if(subtipoTxt.length == 0){
        			$("#bodyOrganos").addClass("alertaCombo");
        			error = true;
        		}
        	}
            	if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarRevisionOrganos", 
		                  {
			  		         id_historia_clinica:id_historia_clinica,
			  		         subtipoList:subtipoList,
			  		         subtipoTxt:subtipoTxt
			  		         
		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listaRevisionOrganos").html(data.contenido);
		                  		$("input[name='revisionAparatos[]']").attr('checked', false);
		               		    $("input[name='revisionAparatosTxt[]']").val('');
			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
    });
    // eliminar revision organos y sistemas  
   function eliminarRevisionOrganos(id){
       $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarRevisionOrganos", 
               {
                  id_historia_clinica: id_historia_clinica,
                  id_revision_organos_sistemas: id
	  		         		  		     
               }, function (data) {
               	if (data.estado === 'EXITO') {
               		    $("#listaRevisionOrganos").html(data.contenido);
               		    $("input[name='revisionAparatos[]']").attr('checked', false);
               		    $("input[name='revisionAparatosTxt[]']").val('');
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                   } else {
                   	mostrarMensaje(data.mensaje, "FALLO");
                   }
       }, 'json');

    }
 //*******************************inmunizaciones *************************************
	 $("#agregarInmunizacion").click(function () {
  		    event.stopImmediatePropagation();
			var texto = "Por favor revise los campos obligatorios.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
			var error = false;
			if(!$.trim($("#id_tipo_procedimiento_medico_inmunizacion").val())){
	  			   $("#id_tipo_procedimiento_medico_inmunizacion").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#numero_dosis").val())){
	  			   $("#numero_dosis").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#fecha_ultima_dosis").val())){
	  			   $("#fecha_ultima_dosis").addClass("alertaCombo");
	  			   error = true;
	  		  }
      	
          	if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarInmunizacion", 
		                  {
			  		         id_historia_clinica:id_historia_clinica,
			  		         id_tipo_procedimiento_medico:$("#id_tipo_procedimiento_medico_inmunizacion").val(),
			  		         numero_dosis:$("#numero_dosis").val(),
			  		         fecha_ultima_dosis: $("#fecha_ultima_dosis").val()
			  		         
		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listaInmunizacion").html(data.contenido);
		               		    $("#id_tipo_procedimiento_medico_inmunizacion").val('');
		               		    $("#numero_dosis").val('');
		               		    $("#fecha_ultima_dosis").val('');
			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
  });
  // eliminar Inmunizacion
 function eliminarInmunizacion(id){
     $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarInmunizacion", 
             {
                id_historia_clinica: id_historia_clinica,
                id_inmunizacion: id
	  		         		  		     
             }, function (data) {
             	if (data.estado === 'EXITO') {
             		    $("#listaInmunizacion").html(data.contenido);
             		    $("#id_tipo_procedimiento_medico_inmunizacion").val('');
              		    $("#numero_dosis").val('');
              		    $("#fecha_ultima_dosis").val('');
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                 } else {
                 	mostrarMensaje(data.mensaje, "FALLO");
                 }
     }, 'json');

  }


 //********habitos *************************************** 
 $("#id_tipo_procedimiento_medico_habitos").change(function () {
	  if($("#id_tipo_procedimiento_medico_habitos").val() && $("#id_tipo_procedimiento_medico_habitos option:selected").text() != 'Ninguno'){
        	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/buscarHabitos", 
                     {
                        id_historia_clinica:id_historia_clinica,
                        id_tipo_procedimiento_medico: $("#id_tipo_procedimiento_medico_habitos").val(),
                        tipo: $("#id_tipo_procedimiento_medico_habitos option:selected").text()
        	  		         		  		     
                     }, function (data) {
                     	if (data.estado === 'EXITO') {
                     		    $("#detalleHabitos").html(data.contenido);
                     		    $("#detalleHabitos").show();
        	                    mostrarMensaje(data.mensaje, data.estado);
        	                    distribuirLineas();
                         } else {
                         	mostrarMensaje(data.mensaje, "FALLO");
                         }
             }, 'json');
	  }else{
		  $("#detalleHabitos").html('');
		  $("#detalleHabitos").hide();
		  mostrarMensaje("", "FALLO");
		   }
    });
 //****************************************************************************************
       function agregarHabitos(){
   		event.stopImmediatePropagation();
			var texto = "Por favor revise los campos obligatorios.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
			var error = false;
			error = validarCamposHabitos($("#id_tipo_procedimiento_medico_habitos option:selected").text());
			if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarHabitos", 
		                  {
			  		         id_historia_clinica:id_historia_clinica,
			  		         id_tipo_procedimiento_medico:$("#id_tipo_procedimiento_medico_habitos").val(),

			  		         habito_toxico:$("#habito_toxico").val(),
			  		         exconsumidor:$("#exconsumidor").val(),
			  		         cantidad_habito:$("#cantidad_habito").val(),
			  		         meses_habito:$("#meses_habito").val(),
			  		         meses_habito_abstinencia:$("#meses_habito_abstinencia").val(),
			  		         sustancias:$("#sustancias").val(),
		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listaHabitos").html(data.contenido);
		                  		$("#detalleHabitos").html('');
		           		        $("#detalleHabitos").hide();
			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
   }
   // eliminar habitos
  function eliminarHabitos(id){
      $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarHabitos", 
              {
                 id_historia_clinica: id_historia_clinica,
                 id_habitos: id
	  		         		  		     
              }, function (data) {
              	if (data.estado === 'EXITO') {
              		    $("#listaHabitos").html(data.contenido);
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                  } else {
                  	mostrarMensaje(data.mensaje, "FALLO");
                  }
      }, 'json');

   }

	//*****************verificar campos habitos***********************************
	function validarCamposHabitos(opt)
	{
		var error1 = false;
		switch (opt) 
		{ 
			case '': 
	    		error1 = true;
				break;		
			case 'Otras drogas':
				if(!$.trim($("#id_tipo_procedimiento_medico_habitos").val())){
	 			   $("#id_tipo_procedimiento_medico_habitos").addClass("alertaCombo");
	 			   error1 = true;
	 		      }
	 		    if($("#habito_toxico").val()=="Si")
	 		    {
					if(!$.trim($("#sustancias").val())){
			  			   $("#sustancias").addClass("alertaCombo");
			  			   error1 = true;
			  		  }
					if(!$.trim($("#exconsumidor").val())){
			  			   $("#exconsumidor").addClass("alertaCombo");
			  			   error1 = true;
			  		  }
					if(!$.trim($("#cantidad_habito").val())){
			  			   $("#cantidad_habito").addClass("alertaCombo");
			  			   error1 = true;
			  		  }
			  		  if(!$.trim($("#meses_habito").val()) || (parseInt($("#meses_habito").val()) > 999) || (parseInt($("#meses_habito").val()) < 1)){
			  			   $("#meses_habito").addClass("alertaCombo");
			  			   error1 = true;
			  		  }
			  		 if($("#exconsumidor").val() == 'Si'){
				  		  if(!$.trim($("#meses_habito_abstinencia").val()) || (parseInt($("#meses_habito_abstinencia").val()) > 999) || (parseInt($("#meses_habito_abstinencia").val()) < 1)){
				  			   $("#meses_habito_abstinencia").addClass("alertaCombo");
				  			   error1 = true;
				  		  }
				  	}
			  	}
				break;
			default:
				if(!$.trim($("#id_tipo_procedimiento_medico_habitos").val()))
				{
	 			   $("#id_tipo_procedimiento_medico_habitos").addClass("alertaCombo");
	 			   error1 = true;
	 		    }
	 		    if($("#habito_toxico").val()=="Si")
	 		    {
					if(!$.trim($("#exconsumidor").val())){
			  			   $("#exconsumidor").addClass("alertaCombo");
			  			   error1 = true;
			  		  }
					if(!$.trim($("#cantidad_habito").val())){
			  			   $("#cantidad_habito").addClass("alertaCombo");
			  			   error1 = true;
			  		  }
			  		  if(!$.trim($("#meses_habito").val()) || (parseInt($("#meses_habito").val()) > 999) || (parseInt($("#meses_habito").val()) < 1)){
			  			   $("#meses_habito").addClass("alertaCombo");
			  			   error1 = true;
			  		  }
			  		  if($("#exconsumidor").val() == 'Si'){
				  		  if(!$.trim($("#meses_habito_abstinencia").val()) || (parseInt($("#meses_habito_abstinencia").val()) > 999) || (parseInt($("#meses_habito_abstinencia").val()) < 1)){
				  			   $("#meses_habito_abstinencia").addClass("alertaCombo");
				  			   error1 = true;
				  		  }
				  		}
			  	}
			  	break;
		  }
		return error1;
	}


	$(document).on('change',"#exconsumidor", function(){
		if($(this).val() == 'Si'){
			$("#meses_habito_abstinencia").removeAttr('disabled');
		}
		else{
			$("#meses_habito_abstinencia").attr('disabled','disabled');
			$("#meses_habito_abstinencia").val('');
		}
	});


	$(document).on('change',"#habito_toxico", function(){
		
		if($(this).val() == 'Si')
		{
			$("#exconsumidor").removeAttr('disabled');
			$("#cantidad_habito").removeAttr('disabled');
			$("#meses_habito").removeAttr('disabled');
			if($("#id_tipo_procedimiento_medico_habitos option:selected").text() == 'Otras drogas'){
				$("#sustancias").removeAttr('disabled');
			}
		}
		else
		{
			$("#exconsumidor").attr('disabled','disabled');
			$("#cantidad_habito").attr('disabled','disabled');
			$("#meses_habito").attr('disabled','disabled');
			$("#exconsumidor").val('');
			$("#cantidad_habito").val('');
			$("#meses_habito").val('');
			if($("#id_tipo_procedimiento_medico_habitos option:selected").text() == 'Otras drogas'){
				$("#sustancias").attr('disabled','disabled');
				$("#sustancias").val('');
			}
		}
	});


	$(document).on('change',"#descripcion_concepto", function(){
		
		if($(this).val() == 'Apto en observación')
		{
			$("#tipo_restriccion_observacion").show();
			$("#tipo_restriccion_limitacion").hide();
			$("#tipo_restriccion_observacion_label").show();
			$("#tipo_restriccion_limitacion_label").hide();
			$("#tipo_restriccion_limitacion").val('');
			
		}
		else if($(this).val() == 'Apto con limitaciones')
		{
			$("#tipo_restriccion_limitacion").show();
			$("#tipo_restriccion_observacion").hide();
			$("#tipo_restriccion_limitacion_label").show();
			$("#tipo_restriccion_observacion_label").hide();
			$("#tipo_restriccion_observacion").val('');
			
		}
		else{
			$("#tipo_restriccion_limitacion").hide();
			$("#tipo_restriccion_observacion").hide();
			$("#tipo_restriccion_limitacion_label").hide();
			$("#tipo_restriccion_observacion_label").hide();
			$("#tipo_restriccion_observacion").val('');
			$("#tipo_restriccion_limitacion").val('');
		}
	});


	 //*****************agregar actividades***********************************************************************

	 $("#tipo_actividad").change(function () {
		  if($("#tipo_actividad").val() && $("#tipo_actividad option:selected").text() != 'Ninguno'){
	        	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/buscarEstiloVida", 
	                     {
	                        id_historia_clinica:id_historia_clinica,
	                        tipo: $("#tipo_actividad option:selected").text()
	        	  		         		  		     
	                     }, function (data) {
	                     	if (data.estado === 'EXITO') {
	                     		    $("#detalleEstiloVida").html(data.contenido);
	                     		    $("#detalleEstiloVida").show();
	        	                    mostrarMensaje(data.mensaje, data.estado);
	        	                    distribuirLineas();
	                         } else {
	                         	mostrarMensaje(data.mensaje, "FALLO");
	                         }
	             }, 'json');
		  }else{
			  $("#detalleEstiloVida").html('');
			  $("#detalleEstiloVida").hide();
			  mostrarMensaje("", "FALLO");
			   }
    });

     function agregarActividad() 
     {
		    event.stopImmediatePropagation();
			var texto = "Por favor revise los campos obligatorios.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
			var error = false;
			if(!$.trim($("#confirma_estilo").val())){
	  			   $("#confirma_estilo").addClass("alertaCombo");
	  			   error = true;
	  		  }

	  		 if($('#confirma_estilo').val() == 'Si')
	  		 {
				if(!$.trim($("#tiempo_cantidad").val())){
		  			   $("#tiempo_cantidad").addClass("alertaCombo");
		  			   error = true;
		  		  }
		  		if(!$.trim($("#actividad_medicina").val())){
		  			   $("#actividad_medicina").addClass("alertaCombo");
		  			   error = true;
		  		  }
		  	}

			if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarActividad", 
		                  {
			  		         id_historia_clinica:id_historia_clinica,
			  		         tipo_actividad:$("#tipo_actividad").val(),
			  		         confirma_estilo:$("#confirma_estilo").val(),
			  		         tiempo_cantidad:$("#tiempo_cantidad").val(),
			  		         actividad_medicina:$("#actividad_medicina").val(),
		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listaActividades").html(data.contenido);
		                  		$("#confirma_estilo").val('');
		                  		$("#tiempo_cantidad").val('');
		                  		$("#actividad_medicina").val('');
			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
	}

// eliminar actividades
function eliminarActividad(id){
   $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarActividad", 
           {
              id_historia_clinica: id_historia_clinica,
              id_estilo_vida: id
	  		         		  		     
           }, function (data) {
           	if (data.estado === 'EXITO') {
           		    $("#listaActividades").html(data.contenido);
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
               } else {
               	mostrarMensaje(data.mensaje, "FALLO");
               }
   }, 'json');

}

$(document).on('change',"#confirma_estilo", function(){
		if($(this).val() == 'Si'){
			$("#tiempo_cantidad").removeAttr('disabled');
			$("#actividad_medicina").removeAttr('disabled');
		}
		else{
			$("#tiempo_cantidad").attr('disabled','disabled');
			$("#tiempo_cantidad").val('');
			$("#actividad_medicina").attr('disabled','disabled');
			$("#actividad_medicina").val('');
		}
	});


//*************************examen físico****************************************
     $("#talla_mts").change(function () {
         if($(this).val() != 0 && $(this).val() !='' ){
				if($("#peso_kg").val() != '' ){
						var imc = $("#peso_kg").val() / (($(this).val()/100)*($(this).val()/100));
						if(imc != 0){
							$("#imc").val(imc.toFixed(2));
							$("#interpretacion_imc").val(resultadoImc(imc.toFixed(2)));
							}else{
								$("#imc").val('');
								$("#interpretacion_imc").val('');
								}
					}else{
						$("#imc").val('');
						$("#interpretacion_imc").val('');
						}
             }else{
            	 $("#imc").val('');
            	 $("#interpretacion_imc").val('');
                 }
     });
     $("#peso_kg").change(function () {
    	 if($(this).val() != 0 && $(this).val() !='' ){
				if($("#talla_mts").val() != ''  && $("#talla_mts").val() != 0){
						var imc = $("#peso_kg").val() / (($("#talla_mts").val()/100)*($("#talla_mts").val()/100));
						if(imc != 0){
							$("#imc").val(imc.toFixed(2));
							$("#interpretacion_imc").val(resultadoImc(imc.toFixed(2)));
							}else{
								$("#imc").val('');
								$("#interpretacion_imc").val('');
								}
					}else{
						$("#imc").val('');
						$("#interpretacion_imc").val('');
						}
          }else{
        	  $("#imc").val('');
        	  $("#interpretacion_imc").val('');
              }
     });
     function resultadoImc(imc){
    	 if(imc >= 18.5 && imc <= 24.9){
				return 'Normal';
				}
    	 if(imc >= 25 && imc <= 29.9){
				return 'Sobrepeso';
				}
    	 if(imc >= 30 && imc <= 34.9){
				return 'Obeso';
				}
    	 if(imc >= 35 && imc <= 39.9){
				return 'Obeso severo';
				}
    	 if(imc >= 40){
				return 'Obeso morvido';
				}
         }
     //*******************************************evaluacion primaria********
     function verificarEvaPrimaria(id,tipo,sub){
         if($("#"+id).val() == 'Si'){
        	 $("#No-"+tipo+"-"+sub).prop("checked", false);
             }else {
            	 $("#Si-"+tipo+"-"+sub).prop("checked", false);
                 }
     }
     //**************************************examenes clinicos**************
  $("#id_tipo_procedimiento_medico_exa_clinicos").change(function () {
	  if($("#id_tipo_procedimiento_medico_exa_clinicos").val()){
	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/buscarExamenesClinicos", 
              {
                 id_historia_clinica:id_historia_clinica,
                 id_tipo_procedimiento_medico: $("#id_tipo_procedimiento_medico_exa_clinicos").val(),
                 tipo: $("#id_tipo_procedimiento_medico_exa_clinicos option:selected").text()
	  		         		  		     
              }, function (data) {
              	if (data.estado === 'EXITO') {
              		    $("#detalleExamenesClinicos").html(data.contenido);
              		    $("#detalleExamenesClinicos").show();
              		    activarFecha();
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                  } else {
                  	mostrarMensaje(data.mensaje, "FALLO");
                  }
      }, 'json');
	  }else{
		  $("#detalleExamenesClinicos").html('');
		  $("#detalleExamenesClinicos").hide();
		   }
     });
  //****************************************************************************************

	function agregarExamenesClinicos()
	{
		subirArchivoAdjunto()
		  .then(function(response) {
		    agregarExamenesClinicos2(response.idAdjunto);
		  })
		  .catch(function(error) {
		     console.error("Error al subir el archivo:", error);
		  });
	}

    function agregarExamenesClinicos2($idArchivoAdjunto)
    {
		event.stopImmediatePropagation();
		var texto = "Por favor revise los campos obligatorios.";
		$(".alertaCombo").removeClass("alertaCombo");
		mostrarMensaje("", "FALLO");
		var error = false;

		if(!$.trim($("#fecha_examen").val())){
  			   $("#fecha_examen").addClass("alertaCombo");
  			   error = true;
  		  }

  		var elemento = $("#resultado_examen_clinico");
		var valorResultado;
		if (elemento.length) {
		  valorResultado = elemento.val();
		} else {
		  valorResultado = '';
		}

		if (!error) {
		  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarExamenesClinicos", 
	                  {
		  		         id_historia_clinica:id_historia_clinica,
		  		         id_tipo_procedimiento_medico:$("#id_tipo_procedimiento_medico_exa_clinicos").val(),
		  		         fecha_examen:$("#fecha_examen").val(),
		  		         resultado:valorResultado,
		  		         observacion:$("#observacion_examen_clinico").val(),
		  		         estado_clinico:$("input[name='estado_clinico[]']").map(function(){ if($(this).prop("checked")){return $(this).attr("id")+'-'+$(this).val();}}).get(),
		  		         observaciones:$("input[name='observaciones_examen_clinico[]']").map(function(){ if($(this).val()){return $(this).attr("id")+'-'+$(this).val();}}).get(),
		  		         id_adjuntos_historia_clinica: $idArchivoAdjunto,
		  		         id_tipo: $("#id_tipo_procedimiento_medico_exa_clinicos option:selected").val()
							  	
	                  }, function (data) {
	                  	if (data.estado === 'EXITO') {
	                  		$("#listaExamenesClinicos").html(data.contenido);
	                  		$("#detalleExamenesClinicos").html('');
	           		        $("#detalleExamenesClinicos").hide();
	           		        $("#id_tipo_procedimiento_medico_exa_clinicos").val('');
		                    mostrarMensaje(data.mensaje, data.estado);
		                    distribuirLineas();
	                      } else {
	                      	mostrarMensaje(data.mensaje, "FALLO");
	                      }
	          }, 'json');
		} else {
			mostrarMensaje(texto, "FALLO");
		}
    }

    // eliminar examenes clinicos
   function eliminarExamenesClinicos(id, tipo){
       $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarExamenesClinicos", 
               {
                  id_historia_clinica: id_historia_clinica,
                  id_detalle_examenes_clinicos: id,
                  tipoEliminar: tipo
               }, function (data) {
               	if (data.estado === 'EXITO') {
               		    $("#listaExamenesClinicos").html(data.contenido);
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                   } else {
                   	mostrarMensaje(data.mensaje, "FALLO");
                   }
       }, 'json');

    } 

   //********************verificar opcion******
    function verificarExaClinicos(id,tipo,sub){
         if($("#"+id).val() == 'Si')
         {
    	 	$("#No-"+tipo+"-"+sub).prop("checked", false);
    	 	$("#t-"+tipo+"-"+sub).attr("disabled", false);
         }
         else 
         {
        	 $("#Si-"+tipo+"-"+sub).prop("checked", false);
        	 $("#t-"+tipo+"-"+sub).attr("disabled", true);
        	 $("#t-"+tipo+"-"+sub).val('');
         }
     }

   function activarFecha(){
	   $("#fecha_examen").datepicker({
	    	yearRange: "c:c",
	    	changeMonth: false,
	        changeYear: false,
	        dateFormat: 'yy-mm-dd',
	      });
   }
//****************************subir documentos adjuntos examenes clinicos***********

function subirArchivoAdjunto() {
  return new Promise(function(resolve, reject) {
    var texto = "Por favor revise los campos obligatorios.";
    $(".alertaCombo").removeClass("alertaCombo");
    mostrarMensaje("", "FALLO");
    var error = false;

    if(!$.trim($(".archivo").val())){
		   $(".archivo").addClass("alertaCombo");
		   error = true;
	  }

    var boton = $("#botonSubirArchivoAdjunto");
    var archivo = boton.parent().find(".archivo");
    var rutaArchivo = boton.parent().find(".rutaArchivo");
    var extension = archivo.val().split('.');
    var estado = boton.parent().find(".estadoCarga");

    if (!error) {
      var file = archivo[0].files[0];
      var data = new FormData();
      data.append('archivo', file);
      var url = "<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarDocumentosAdjuntos";
      var get = "?id_historia_clinica=" + id_historia_clinica + "&descripcion_adjunto=" + $("#descripcion_adjunto").val();
      var elemento = rutaArchivo;
      var funcion = new cargaAdjunto(estado, archivo, boton);

      $.ajax({
        url: url + get,
        type: 'POST',
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        beforeSend: function(info) {
          funcion.esperar("");
        },
        success: function(info) {
          var obj = JSON.parse(info);
          if (obj.estado == 'EXITO') {
            elemento.val(obj.estado);
            funcion.exito(obj.mensaje);
            $("#descripcion_adjunto").val('');
            $(".archivo").val('');
            $("#listaAdjuntosHistoria").html(obj.contenido);
            funcion.exito(obj.mensaje);
            //mostrarMensaje(obj.mensaje, obj.estado);
            distribuirLineas();
            resolve(obj);
          } else {
            elemento.val('0');
            funcion.error(obj.mensaje);
            mostrarMensaje(obj.mensaje, obj.estado);
            reject(obj);
          }
        },
        error: function(info) {
          var obj = JSON.parse(info);
          elemento.val('0');
          funcion.error(obj.mensaje);
          mostrarMensaje(obj.mensaje, obj.estado);
          reject(obj);
        }
      });
    } else {
      mostrarMensaje(texto, "FALLO");
      reject();
    }
  });
}


   function cargaAdjunto(estado, archivo, boton) {
       this.esperar = function (msg) {
           estado.html("Cargando el archivo...");
           archivo.removeClass("rojo");
           archivo.addClass("amarillo");
       };

       this.exito = function (msg) {
           estado.html("En espera de archivo... (Tamaño máximo < ?php echo ini_get('upload_max_filesize'); ? >B)");
           archivo.removeClass("amarillo rojo");
           //boton.attr("disabled", "disabled");
          // estado.html("El archivo ha sido cargado.");
          // archivo.addClass("verde");
       };

       this.error = function (msg) {
           estado.html(msg);
           archivo.removeClass("amarillo verde");
           archivo.addClass("rojo");
       };
   }


    // eliminar examenes paraclinicos
   function eliminarParaclinicos(id){
       $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarParaclinicos", 
               {
                  id_historia_clinica: id_historia_clinica,
                  id_examen_paraclinicos: id
	  		         		  		     
               }, function (data) {
               	if (data.estado === 'EXITO') {
               		    $("#listaParaclinicos").html(data.contenido);
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
                   } else {
                   	mostrarMensaje(data.mensaje, "FALLO");
                   }
       }, 'json');

    } 
   function verificarRespuestaParacli(id,tipo,sub){
       if($("#"+id).val() == 'Si'){
      	 $("#n-"+tipo+"-"+sub).prop("checked", false);
           }else {
          	 $("#s-"+tipo+"-"+sub).prop("checked", false);
               }
   }
   function verificarOidoParaclinicos(id,tipo,sub){
       if($("#"+id).val() == 'Derecho'){
      	 $("#i-"+tipo+"-"+sub).prop("checked", false);
      	 $("#b-"+tipo+"-"+sub).prop("checked", false);
      }
      if($("#"+id).val() == 'Izquierdo') {
    	 $("#d-"+tipo+"-"+sub).prop("checked", false);
       	 $("#b-"+tipo+"-"+sub).prop("checked", false);
          }
      if($("#"+id).val() == 'Bilateral'){
        	$("#d-"+tipo+"-"+sub).prop("checked", false);
            $("#i-"+tipo+"-"+sub).prop("checked", false);
              }
   }

   //**************************impresion diagnosticada****************************
    $("#enfermedad_general_diagnosticada").change(function () {
	     $("#id_cie_diagnosticada").val($(this).val());
     });
     $("#id_cie_diagnosticada").change(function () {
    	 $("#enfermedad_general_diagnosticada").val($(this).val());
     });

     $("#agregarDiagnostico").click(function () {
 		    event.stopImmediatePropagation();
			var texto = "Por favor revise los campos obligatorios.";
			$(".alertaCombo").removeClass("alertaCombo");
			mostrarMensaje("", "FALLO");
			var error = false;
			if(!$.trim($("#enfermedad_diagnostico").val())){
	  			   $("#enfermedad_diagnostico").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		  if(!$.trim($("#subliteral").val())){
	  			   $("#subliteral").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#id_cie_diagnosticada").val())){
	  			   $("#id_cie_diagnosticada").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$.trim($("#enfermedad_general_diagnosticada").val())){
	  			   $("#enfermedad_general_diagnosticada").addClass("alertaCombo");
	  			   error = true;
	  		  }
			if(!$("input[name='estado_diagnostico[]']").is(':checked') ){
	  			 texto = "Debe seleccionar un campo !!.";
	  			$("input[name='estado_diagnostico[]']").addClass("alertaCombo");
	  			 error = true;
		  		}
			if(!$.trim($("#diagnostico").val())){
	  			   $("#diagnostico").addClass("alertaCombo");
	  			   error = true;
	  		  }
	  		
			if (!error) {
			  	  $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/agregarDiagnostico", 
		                  {
			  		         id_historia_clinica:id_historia_clinica,
			  		         enfermedad: $("#enfermedad_diagnostico").val(),
			  		         id_cie:$("#id_cie_diagnosticada").val(),
			  		         subliteral:$("#subliteral").val(),
			  		         diagnostico:$("#diagnostico").val(),
			  		         estado_diagnostico:$("input[name='estado_diagnostico[]']").map(function(){ if($(this).prop("checked")){return $(this).val();}}).get()
			  		         
		                  }, function (data) {
		                  	if (data.estado === 'EXITO') {
		                  		$("#listaDiagnostico").html(data.contenido);
		           		        $("#id_cie_diagnosticada").val('');
		           		        $("#enfermedad_general_diagnosticada").val('');
		           		        $("#diagnostico").val('');
		           		     	$("#enfermedad_diagnostico").val('');
		           		     	$("#subliteral").val('');
		           		  		$("input[name='estado_diagnostico[]']").prop("checked", false);
			                    mostrarMensaje(data.mensaje, data.estado);
			                    distribuirLineas();
		                      } else {
		                      	mostrarMensaje(data.mensaje, "FALLO");
		                      }
		          }, 'json');
			} else {
				mostrarMensaje(texto, "FALLO");
			}
         });
         // eliminar impresion diagnosticada
        function eliminarDiagnostico(id){
            $.post("<?php echo URL ?>HistoriasClinicas/historiaClinica/eliminarDiagnostico", 
                    {
                       id_historia_clinica: id_historia_clinica,
                       id_impresion_diagnostica: id
        	  		         		  		     
                    }, function (data) {
                    	if (data.estado === 'EXITO') {
                    		    $("#listaDiagnostico").html(data.contenido);
        	                    mostrarMensaje(data.mensaje, data.estado);
        	                    distribuirLineas();
                        } else {
                        	mostrarMensaje(data.mensaje, "FALLO");
                        }
            }, 'json');
        
         }

	    function validarNumero() {
	      var numero = document.getElementById('porcentaje_discapacidad').value;
	      if (numero < 1 || numero > 99) {
	      	var label = $("label[for='tiene_discapacidad']");
			var span = label.next();
			if(span.text() != "NO" )
			{
				$("#porcentaje_discapacidad").addClass("alertaCombo");
	        	return false;
			}
			else{
				return true;
			}
	      }
	      else{
	      	 $("#porcentaje_discapacidad").removeClass("alertaCombo");
	      	 return true;
	      }
	    }

	    function contador(elemento){
	        var maxLength = $(elemento).attr('maxlength');
	        var currentLength = $(elemento).val().length;
	        var remainingChars = maxLength - currentLength;
	        var counter = '#counter_' +  $(elemento).attr('id');
	        $(counter).text(`${maxLength} carácteres, le quedan ${remainingChars}.`);
	    }

	    function validarCamposFuncionario() 
	    {
		  var divFuncionario = $('#divFuncionario');
		  var spans = divFuncionario.find('span');
		  var inputs = divFuncionario.find('input');
		  var selects = divFuncionario.find('select');

		  // Verificar si todos los campos span no están vacíos
		  var spansVacios = spans.toArray().every(function(span) {
		    return $(span).text().trim() !== '';
		  });

		var label = $("label[for='tiene_discapacidad']");
		var span = label.next();
		if(span.text() != "NO" ){
		  // Verificar si todos los campos input no están vacíos
		  var inputsVacios = inputs.toArray().every(function(input) {
		    return $(input).val().trim() !== '';
		  });

		  // Verificar si todos los campos input no están vacíos
		  var selectsVacios = selects.toArray().every(function(select) {
		    return $(select).val().trim() !== '';
		  });

		  // Retornar true si todos los campos no están vacíos, de lo contrario, retornar false
		  return spansVacios && inputsVacios && selectsVacios && validarNumero();
		}
		else{
			// Retornar true si todos los campos no están vacíos, de lo contrario, retornar false
		  return spansVacios && ($('#actividades_relevantes').val() != '') && validarNumero();
		}  
	}

</script>