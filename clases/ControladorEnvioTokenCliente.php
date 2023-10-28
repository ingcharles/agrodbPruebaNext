<?php
class ControladorEnvioTokenCliente{

    public function actulizarTokenClientes($conexion)
    {
        $consulta = "select *from g_servicios_web.f_update_token_clientes();";
        $res = $conexion->ejecutarConsulta($consulta);
        return $res;

    }

    public function cuerpoCorreo($token){
        $familiaLetra = "font-family:'Text Me One', 'Segoe UI', 'Tahoma', 'Helvetica', 'freesans', 'sans-serif'";
		$letraCodigo = "font-family:'Segoe UI', 'Helvetica'";
        $cuerpoMensaje = '<table><tbody>
        <tr><td style="' . $familiaLetra . '; font-size:25px; color:rgb(255,206,0); font-weight:bold; text-transform:uppercase;">Agrocalidad <span style="color:rgb(19,126,255);">te </span> <span style="color:rgb(204,41,44);">saluda</span></td></tr>					
        <tr><td style="' . $familiaLetra . '; padding-top:20px; font-size:42px; color:rgb(236,107,109);">Token de acceso Para el consumo del End Point</td></tr>
        <tr><td style="' . $familiaLetra . '; padding-top:20px; font-size:14px;color:#2a2a2a;">Le notificamos que su token para acceder al end point se renueva constantemente.</tr>
        <tr><td style="' . $familiaLetra . '; padding-top:5px; font-size:14px;color:#2a2a2a;">Tu Token generado es: <span style="' . $letraCodigo . ' font-size:14px; font-weight:bold; color:#2a2a2a;">' .$token. '</span></td></tr>
        <tr><td style="' . $familiaLetra . '; padding-top:20px; font-size:14px;color:#2a2a2a;">Si necesita mas información puede comunicarse con nosotros al número 23960100 ext. 3203, 3204, 3205.</td></tr>
        <tr><td style="' . $familiaLetra . '; padding-top:20px; font-size:14px;color:#2a2a2a;">Gracias por utilizar nuestros servicios</td></tr>
        <tr><td style="' . $familiaLetra . '; padding-top:5px; font-size:14px;color:#2a2a2a;">El equipo de Desarrollo Tecnológico de Agrocalidad </td></tr>		
        </tbody></table>';
        return $cuerpoMensaje;
    }
}

?>