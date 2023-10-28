<?php

/**
 * Lógica del negocio de FirmaXmlLogicaNegocio
 *
 *
 * @author AGROCALIDAD
 * @uses   FirmaXmlLogicaNegocio
 * @package WebServices
 * @subpackage Modelos
 */

namespace Agrodb\WebServices\Modelos;

use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;

class FirmaXmlLogicaNegocio
{
    
    /*public function __construct()
    {
        require ROOT . '../vendor/autoload.php';
    }*/
    
    /**
     * Funcion para realizar la firma de un documento xml
     *
     * @param
     * @return string
     */
    public function  firmarXML($rutaXml, $rutaLlave, $rutaCertificado, $rutaXmlSalida){

        // Load the XML to be signed
        $doc = new \DOMDocument();
        $doc->load($rutaXml);
        
        // Create a new Security object
        $objDSig = new XMLSecurityDSig();
        // Use the c14n exclusive canonicalization
        $objDSig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);
        // Sign using SHA-256
        $objDSig->addReference(
            $doc,
            XMLSecurityDSig::SHA256,
            array('http://www.w3.org/2000/09/xmldsig#enveloped-signature')
            );
        
        // Create a new (private) Security key
        $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, array('type'=>'private'));
        
        /*
         If key has a passphrase, set it using
         $objKey->passphrase = '<passphrase>';
         */
        
        // Load the private key
        $objKey->loadKey($rutaLlave, TRUE);
        
        // Sign the XML file
        $objDSig->sign($objKey);
        
        // Add the associated public key to the signature
        $objDSig->add509Cert(file_get_contents($rutaCertificado));
        
        // Append the signature to the XML
        $objDSig->appendSignature($doc->documentElement);
        // Save the signed XML
        $doc->save($rutaXmlSalida);
        
        return true;
    }
    
    
}
