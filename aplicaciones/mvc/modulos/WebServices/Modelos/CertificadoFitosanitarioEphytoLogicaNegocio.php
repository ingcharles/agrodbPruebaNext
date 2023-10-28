<?php
namespace Agrodb\WebServices\Modelos;

use Agrodb\Core\Constantes;
use Zend\Soap\Client;
use Agrodb\WebServices\Modelos\CertificadoFitosanitarioEphyto\StructType\Envelope;


class CertificadoFitosanitarioEphytoLogicaNegocio{

	public function coneccionWebServicesEphyto(){
		
		$clientOptions = array(
			'local_cert' => Constantes::RUTA_SERVIDOR_OPT.'/'.Constantes::RUTA_APLICACION.'/'.'aplicaciones/mvc/modulos/WebServices/Modelos/CertificadoFitosanitarioEphyto/certificado/nppo-ec.pem',//PRUEBAS
		    //'local_cert' => Constantes::RUTA_SERVIDOR_OPT.'/'.Constantes::RUTA_APLICACION.'/'.'aplicaciones/mvc/modulos/WebServices/Modelos/CertificadoFitosanitarioEphyto/certificado/_.agrocalidad.gob.ec.pem',//PRODUCCION
			'passphrase' => 'nppoECp12',
			'soap_version' => SOAP_1_1,
			'encoding' => 'UTF-8',
			'location' => 'https://uat-hub.ephytoexchange.org/hub/DeliveryService'
		);
		
		
		var_dump( $clientOptions);		
		$clienteEphyto = new Client('https://uat-hub.ephytoexchange.org/hub/DeliveryService?wsdl', $clientOptions);//PRUEBAS
		//$clienteEphyto = new Client('https://hub.ephytoexchange.org/hub/DeliveryService?wsdl', $clientOptions);//PRODUCCION
		
		if(isset($clienteEphyto)){
			echo "tiene valor";
		}else{
			echo "no tiene valor";
		}
		
		return $clienteEphyto;
	}
	
	public function envioEphyto($coneccion, $arrayParametros) {

		$envelope = new Envelope();

		$envelope->setFrom($arrayParametros['pais_origen']);
		$envelope->setTo($arrayParametros['pais_destino']);
		$envelope->setNPPOCertificateNumber($arrayParametros['numero_certificado']);
		$envelope->setCertificateType($arrayParametros['tipo_certificado']);
		$envelope->setCertificateStatus($arrayParametros['estado_certificado']);
		$envelope->setContent($arrayParametros['contenido_xml']);

		$coneccion->DeliverEnvelope(array('env'=>$envelope));

		
	}
}
