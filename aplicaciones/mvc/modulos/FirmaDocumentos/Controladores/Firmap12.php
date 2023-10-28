<?php
//var_dump(dirname(__FILE__));
//require_once dirname(__FILE__).'/XmlSecurity/DSig.php';
//require_once dirname(__FILE__).'/XmlSecurity/Key.php';
//require_once dirname(__FILE__)."/nuSoap/nusoap.php";

namespace Agrodb\FirmaDocumentos\Controladores;
use ass\XmlSecurity\DSig;
use ass\XmlSecurity\Key;

class Firmap12
{   
    protected $key=null;
    protected $data=array(
        'key_p12'=>null,
        'pass_key'=>null,
        'file_to_sign'=>null,
        'file_signed'=>null,
        'file_to_send'=>null,
        'file_autorized'=>null
    );
    public function __construct(array $config = array()){    
        $this->data=array_merge($this->data,$config);
    }

    public function setKey($file_key,$pass, $echo=false, $contadorExtras = null){
        try {
            if(!empty($file_key)&&!empty($pass)&&is_readable($file_key)){           
                $this->key = Key::factory(Key::RSA_SHA1, $file_key, true, Key::TYPE_PRIVATE, $pass, $contadorExtras);
                if(!$this->key->active){ $this->key=null; return false; }
                return true;
            } return false;
        } catch (Exception $e) { 
            if($echo) echo 'Excepcion Capturada: ',  $e->getMessage(), "\n";
            return false; 
        }    
    }

    public function getKeyData($file_key="", $pass="", $echo=false){
        try {
            if(!empty($file_key)&&!empty($pass)&&is_readable($file_key)){ 
                $this->setKey($file_key , $pass, $echo=false);
            }
            if(empty($this->key)) return 2;
            
            return $this->key->getDataKey();
        } catch (Exception $e) { 
            if($echo) echo 'Excepcion Capturada: ',  $e->getMessage(), "\n";
             
        }   
        return 1;
    }
        
}        
        
         
    