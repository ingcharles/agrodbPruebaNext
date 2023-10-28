<?php
require_once '../../../clases/Conexion.php';
require_once '../../../clases/ControladorMail.php';
require_once '../../../clases/ControladorRegistroOperador.php';
require_once '../../../clases/ControladorMailMasivo.php';

$conexion = new Conexion();
$cMail = new ControladorMail();
$cro = new ControladorRegistroOperador();
$cmm = new ControladorMailMasivo();

$documentosAdjuntos = array();
//array_push($documentosAdjuntos, 'D:\xampp\htdocs\agrodb\aplicaciones\procesosAutomaticos\mail\adjuntos/resolucionIAF .pdf');
//array_push($documentosAdjuntos, '/var/www/html/agrodb/aplicaciones/procesosAutomaticos/mail/adjuntos/Anexo1.xlsx');


$nombreRequerimiento="GLPI # 315783";
$areas = "'IAP','IAF'";
//$areas = "'IAV'";
//$areas = "'IAF'";
//$areas = "'IAV','IAP'";
//$areas = "'IAV','IAP','IAF','CGRIA'";
//$areas = "'IAV','IAP','IAF'";
$operaciones = "'DIS','ENV','FOR','FRA','AER','MAN','IMP','EXP','DMR','ALT','ODI','IEX','FED','FIE','IDE'"; //TODOS LAS EMPRESAS
//$operaciones = "'DIS','ENV','FOR','FRA','AER','MAN','IMP','EXP','DMR','ALT','ODI','IEX','FED','FIE','IDE','ALM'"; //TODOS
//$operaciones = "'DIS','FOR','FRA','ENV'";
//$operaciones = "'FRA','FOR','DIS','IMP'";
//$operaciones = "'FRA','IMP'";
//$operaciones = "'ALM'";
//$operaciones = "'FRA'";
//$operaciones = "'AER'";
//$operaciones = "'DIS','FIE','IDE','ENV'";


//$identificador  = "'1802328193001'";

$datosOperador=$cro->obtenerOperadoresPorTipoOperacionYarea($conexion,"(".$operaciones.")","(".$areas.")");
//$datosOperador = $cro->oenerOperadoresPorIdentificadorMasivo($conexion, "(".$identificador.")");

define('IN_MSG','<br/> >>> ');
$asunto = 'Informando de inconveniente en sistema GUIA y directrices de atención para la continuidad de los servicios críticos.';
$contador = 1;



$familiaLetra = "font-family:'Text Me One', 'Segoe UI', 'Tahoma', 'Helvetica', 'freesans', 'sans-serif'";
$letraCodigo = "font-family:'Segoe UI', 'Helvetica'";

$cuerpoMensaje='<html xmlns="http://www.w3.org/1999/xhtml"><tbody><table>
                    <tr><td style="'.$familiaLetra.'; padding-top:25px; font-size:14px;color:#2a2a2a; width: 80%; text-align:justify;">Estimado/a</td></tr>
					<tr><td style="'.$familiaLetra.'; padding-top:25px; font-size:14px;color:#2a2a2a; width: 80%; text-align:justify;">La Agencia de Regulación y Control Fito y Zoosanitario a través de la Dirección General de Tecnologías de la Información y Comunicación indica:</td></tr>
                    <tr><td style="'.$familiaLetra.'; padding-top:25px; font-size:14px;color:#2a2a2a; width: 80%; text-align:justify;">"(…) el día de hoy jueves 6 de julio de 2023 a las 13h40, el Sistema Gestor Unificado de Información para Agrocalidad – GUIA sufrió una avería crítica en sus bases de datos, ocasionando la pérdida de información de todos los módulos del sistema desde el 19 de abril de 2023 hasta la presente fecha".</td></tr>
                    <tr><td style="'.$familiaLetra.'; padding-top:25px; font-size:14px;color:#2a2a2a; width: 80%; text-align:justify;"></td>Por ello, la Coordinación General de Registro de Insumos Agropecuarios adoptará la estrategia detallada en el documento adjunto, con el objetivo de recuperar la información afectada y atender las solicitudes requeridas por los usuarios.</tr>
                    <tr><td style="'.$familiaLetra.'; padding-top:25px; font-size:14px;color:#2a2a2a; width: 80%; text-align:justify;">Adicional, las solicitudes generadas a través del sistema GUIA hasta el 18 de abril de 2023 se encuentran activas y completas, por lo que los operadores deben ingresar al sistema GUIA y revisar sus solicitudes con el objetivo de evidenciar que:</td></tr>
                    <tr><td style="'.$familiaLetra.'; padding-top:25px; font-size:14px;color:#2a2a2a; width: 80%; text-align:justify;"></td></tr>
                    <tr><td style="'.$familiaLetra.'; padding-top:25px; font-size:14px;color:#2a2a2a; width: 80%; text-align:justify;">
						<ul>
                        <li>1.- Si se encuentran en estado de revisión técnica, en trámite o subsanación; la solicitud debe continuar por el sistema GUIA.</li>
						<li>2.- En caso de que la solicitud se haya reversado a estados de creado, asignación de tasa, pago; su solicitud debe ingresar por el sistema QUIPUX acorde a las directrices detallados en el documento adjunto.</li>
                        </ul>
                     </td></tr>
					<tr><td style="'.$familiaLetra.'; padding-top:25px; font-size:14px;color:#2a2a2a; width: 80%; text-align:justify;">En el caso de tener consultas adicionales por favor comunicarnos a los correos electrónicos productosagricolas@agrocalidad.gob.ec (plaguicidas, fertilizantes y afines de uso agrícola) y productosveterinarios@agrocalidad.gob.ec (productos de uso veterinario).</td></tr>
					<tr><td style="'.$familiaLetra.'; padding-top:25px; font-size:14px;color:#2a2a2a; width: 80%; text-align:justify;">Saludos,</td></tr>
					<tr><td style="'.$familiaLetra.'; padding-top:25px; font-size:14px;color:#2a2a2a; width: 80%; text-align:justify;">Coordinación General de Registro de Insumos Agropecuarios.</td></tr>
</table></tbody></html>';

/*while ($fila = pg_fetch_assoc($datosOperador)){

$destinatario = array();
if($fila['correo']!= ''){
array_push($destinatario, $fila['correo']);
}

$fecha = date("Y-m-d h:m:s");

echo IN_MSG . $fecha;
echo IN_MSG . 'Envio correo electronico: '.$fila['nombres'].' '.$fila['identificador'];

$idMail = pg_fetch_result($cmm->guardarMailMasivo($conexion, $fila['identificador'], $fila['correo'] ,$nombreRequerimiento, str_replace("'", '' ,$operaciones), str_replace("'", '' ,$areas), 'Por enviar'), 0, 'id_mail_masivo');

$qGuardarCorreo=$cMail->guardarCorreo($conexion, $asunto, $cuerpoMensaje, 'Por enviar', 'PRG_MAIL_MASIVO', 'public.mail_masivo', $idMail);
$idCorreo=pg_fetch_result($qGuardarCorreo, 0, 'id_correo');
$cMail->guardarDestinatario($conexion, $idCorreo, $destinatario);
//$cMail->guardarDocumentoAdjunto($conexion, $idCorreo, $documentosAdjuntos);

echo $contador++.IN_MSG . 'Envio correo masivo asunto: '.$asunto.'.';
echo '</br>';
}*/

$destinatario = array();
array_push($destinatario, 'arqui.migenimo@hotmail.com');

$idMail = pg_fetch_result($cmm->guardarMailMasivo($conexion, $fila['identificador'], $fila['correo'] ,$nombreRequerimiento, str_replace("'", '' ,$operaciones), str_replace("'", '' ,$areas), 'Por enviar'), 0, 'id_mail_masivo');

$qGuardarCorreo=$cMail->guardarCorreo($conexion, $asunto, $cuerpoMensaje, 'Por enviar', 'PRG_MAIL_MASIVO', 'public.mail_masivo', $idMail);
$idCorreo=pg_fetch_result($qGuardarCorreo, 0, 'id_correo');
$cMail->guardarDestinatario($conexion, $idCorreo, $destinatario);
//$cMail->guardarDocumentoAdjunto($conexion, $idCorreo, $documentosAdjuntos);

echo IN_MSG . 'Envio correo masivo asunto: '.$asunto.'.';
echo '<br>';
?>