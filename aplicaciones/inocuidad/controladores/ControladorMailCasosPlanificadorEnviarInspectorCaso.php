<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../servicios/ServiceCasoDAO.php';
require_once '../../../clases/ControladorMail.php';

class ControladorMailCasosPlanificadorEnviarInspectorCaso
{
	
    private $conexion;
	private $servicios;
    private $cMail;

	public function __construct($conexion)
    {
		
		$this->conexion = $conexion==null ? new Conexion() : $conexion;
		$this->servicios = new ServiceCasoDAO();
		$this->cMail = new ControladorMail();
    }

	public function enviarMailCasoPlanVigilancia($parametros){

		$arrayParametros = array(
			'inspector_id' => $parametros['inspector_id'],
			'usuario_id' => $parametros['usuario_id']
		);
		
		$qDatosInspector = pg_fetch_assoc($this->servicios->buscarDatosInspectorPlanVigilanciaPlanificador($this->conexion,$arrayParametros));
		$qDatosCaso = pg_fetch_assoc($this->servicios->obtenerIdCasoCreado($this->conexion,$parametros));


			$cuerpoMensaje= '<html xmlns="http://www.w3.org/1999/xhtml"><body style="margin:0; padding:0;">
					<style type="text/css">
					.titulo  {
					margin-top: 30px;
					width: 800px;
					text-align: center;
					font-size: 16px;
					font-weight: bold;
					font-family:Times New Roman;
					}
					.lineaDos{
					font-style: oblique;
					font-weight: normal;
					}
					.lineaLeft{
					text-align: left;
					}
					.lineaEspacio{
					height: 35px;
					}
					.lineaEspacioMedio{
					height: 50px;
					}
					.espacioLeft{
					padding-left: 15px;
					}
					</style>';
			$cuerpoMensaje.='<table class="titulo">
					<thead>
					<tr><th>Estimado Analista de Inocuidad,</th></tr>
					</thead>
					<tbody>
					<tr><td class="lineaDos lineaEspacio">Se ha designado el número de muestras a tomar para su provincia ('.$qDatosInspector['provincia'].') por el Programa de Residuos de Medicamentos Veterinarios.
					Se solicita de la manera más gentil, realizar la distribución de las muestras para este periodo para su aprobación.
					</td>	</tr>
					</tbody>
					<tfooter>
					<tr><td class="lineaEspacioMedio"></td></tr>
					<tr><td class="lineaDos lineaLeft espacioLeft"><span style="font-weight:bold;" > </span>Saludos cordiales, </td></tr>
					<tr><td class="lineaDos lineaLeft espacioLeft">'.$qDatosInspector['nombreplanificador'].'</td></tr>
					</tfooter>
					</table>';
	
			$asunto = 'NOTIFICACION ENVIO DE CASOS PLAN VIGILANCIA PLANIFICADOR CASO CREADO';
			$codigoModulo='PRG_ADM_INOC';
			$tablaModulo='g_inocuidad.ic_requerimiento';
	
			
				$destinatarios = "";
				if($qDatosInspector['mail_institucional']!= ''){
					$destinatarios  = explode('; ',$qDatosInspector['mail_institucional']);
	
				}else if($qDatosInspector['mail_personal'] !=''){
					$destinatarios  = explode('; ',$qDatosInspector['mail_personal']);
				}

				
				
				$qGuardarCorreo=$this->cMail->guardarCorreo($this->conexion, $asunto, $cuerpoMensaje, 'Por enviar', $codigoModulo, $tablaModulo, $qDatosCaso['ic_requerimiento_id']);
				$idCorreo=pg_fetch_result($qGuardarCorreo, 0, 'id_correo');
				$this->cMail->guardarDestinatario($this->conexion, $idCorreo,$destinatarios);	
	
	}
}

