<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../servicios/ServiceCasoDAO.php';
require_once '../../../clases/ControladorMail.php';

class ControladorMailLaboratorioRechazo
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

	public function enviarMailLaboratorio($parametros){

		
		$id_muestra = $parametros['ic_muestra_id'];
		$id_analisis = $parametros['ic_analisis_muestra_id'];

		$qDatosCaso = pg_fetch_assoc($this->servicios->buscarDatosPlanificadorInspector($this->conexion,$id_muestra));

		$cedulaDestinatarios = array($qDatosCaso['inspector_id'], $qDatosCaso['usuario_id']);
	
		for ($i = 0; $i < count($cedulaDestinatarios); $i++) {
			$qDatosInspector = pg_fetch_assoc($this->servicios->buscarDatosDestinatario($this->conexion,$cedulaDestinatarios[$i]));
			if( count($qDatosInspector) > 0){
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
					<tr><th>Estimado Inspector de inocuidad,</th></tr>
					</thead>
					<tbody>
					<tr><td class="lineaDos lineaEspacio">Por medio del presente, pongo en conocimiento que la muestras con CÓDIGO '.$qDatosCaso['codigo_muestras'].' del Programa de Residuos de Medicamentos Veterinarios se
					encuentra rechazada por no cumplir con los parámetros establecidos de ingreso de muestra.
					Por lo que solicita la reprogramación de la muestra para el cumplimiento de la planificación establecida.
					</td>	</tr>
					</tbody>
					<tfooter>
					<tr><td class="lineaEspacioMedio"></td></tr>
					<tr><td class="lineaDos lineaLeft espacioLeft"><span style="font-weight:bold;" > </span>Saludos cordiales, </td></tr>
					<tr><td class="lineaDos lineaLeft espacioLeft"><span style="font-weight:bold;" > </span>LAboratorios. </td></tr>
					</tfooter>
					</table>';
	
				$asunto = 'NOTIFICACION LABORATORIO RECHAZO';
				$codigoModulo='PRG_ADM_INOC';
				$tablaModulo='g_inocuidad.ic_analisis_muestra';
	
			
				$destinatarios = "";
				if($qDatosInspector['mail_institucional']!= ''){
					$destinatarios  = explode('; ',$qDatosInspector['mail_institucional']);
	
				}else if($qDatosInspector['mail_personal'] !=''){
					$destinatarios  = explode('; ',$qDatosInspector['mail_personal']);
				}

				
				$posicion = ($qDatosCaso['codigo_muestras']);
					
				$qGuardarCorreo=$this->cMail->guardarCorreo($this->conexion, $asunto, $cuerpoMensaje, 'Por enviar', $codigoModulo, $tablaModulo, $id_analisis);
				$idCorreo=pg_fetch_result($qGuardarCorreo, 0, 'id_correo');
				$this->cMail->guardarDestinatario($this->conexion, $idCorreo,$destinatarios);
			}
			$resultado = ($qDatosCaso['codigo_muestras']);
		}
	
	}
}

