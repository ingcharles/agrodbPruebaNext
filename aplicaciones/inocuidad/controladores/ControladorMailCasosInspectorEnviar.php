<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../servicios/ServiceCasoDAO.php';
require_once '../../../clases/ControladorMail.php';

class ControladorMailCasosInspectorEnviar
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

		$qDatosCaso = pg_fetch_assoc($this->servicios->buscarDatosCasosPlanVigilancia($this->conexion,$parametros));

		$arrayParametros = array(
			'inspector_id' => $qDatosCaso['inspector_id'],
			'ic_producto_id' => $qDatosCaso['ic_producto_id'],
			'provincia_id' => $qDatosCaso['provincia_id'],
			'ic_tipo_requerimiento_id' => $qDatosCaso['ic_tipo_requerimiento_id'],
			'numero_muestras' => $qDatosCaso['numero_muestras'],
			'id_grupo' => $qDatosCaso['id_grupo'],
			'usuario_id' => $qDatosCaso['usuario_id']
		);
		
		$qDatosInspector = pg_fetch_assoc($this->servicios->buscarDatosInspectorPlanVigilancia($this->conexion,$arrayParametros));	

		if($qDatosInspector['contador'] == $qDatosInspector['numero_muestras']){

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
					<tr><th>Estimado Planificador,</th></tr>
					</thead>
					<tbody>
					<tr><td class="lineaDos lineaEspacio">Por medio del presente, pongo en conocimiento que se han emitido la distribución de las muestras para este periodo por la provincia de '.$qDatosInspector['nombreprovincia'].' para el
					Programa de Residuos de medicamentos veterinarios.
					En este sentido; solicito de la manera más gentil, la aprobación de la planificación para el inicio de su ejecución.
					Seguro de que mi pedido ha sido atendido favorablemente, anticipo mi agradecimiento.
					</td>	</tr>
					</tbody>
					<tfooter>
					<tr><td class="lineaEspacioMedio"></td></tr>
					<tr><td class="lineaDos lineaLeft espacioLeft"><span style="font-weight:bold;" > </span>Saludos cordiales, </td></tr>
					<tr><td class="lineaDos lineaLeft espacioLeft">'.$qDatosInspector['nombreinspector'].'</td></tr>
					</tfooter>
					</table>';
	
			$asunto = 'NOTIFICACION ENVIO DE CASOS PLAN VIGILANCIA CASO ENVIADO';
			$codigoModulo='PRG_ADM_INOC';
			$tablaModulo='g_inocuidad.ic_requerimiento';
	
			
				$destinatarios = "";
				if($qDatosInspector['mail_institucional']!= ''){
					$destinatarios  = explode('; ',$qDatosInspector['mail_institucional']);
	
				}else if($fila['mail_personal'] !=''){
					$destinatarios  = explode('; ',$qDatosInspector['mail_personal']);
				}

				
				$idRequerimiento = explode(",", $qDatosInspector['codigo']);
				$posicion = ($qDatosInspector['numero_muestras']-1);
					
				$qGuardarCorreo=$this->cMail->guardarCorreo($this->conexion, $asunto, $cuerpoMensaje, 'Por enviar', $codigoModulo, $tablaModulo, $idRequerimiento[$posicion]);
				$idCorreo=pg_fetch_result($qGuardarCorreo, 0, 'id_correo');
				$this->cMail->guardarDestinatario($this->conexion, $idCorreo,$destinatarios);

				//actualizar campo correo inspector
				if($idCorreo !=0){
					foreach($idRequerimiento as $item){
						$this->servicios->actualizarEstadoMailRequerimientoInspector($this->conexion,$item);
					}
				}else{
					$resultado="";
				}
	
			$resultado = ($posicion);
		}
	}
}

