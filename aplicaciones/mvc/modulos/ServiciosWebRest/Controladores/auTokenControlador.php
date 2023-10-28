<?php

/**
 * Controlador Alertas
 *
 * Este archivo controla la lógica del negocio del modelo: AlertasModelo y Vistas
 *
 * @author AGROCALIDAD
 * @date   2020-09-07
 * @uses AplicacionesControlador
 * @package AplicacionMovilInternos
 * @subpackage Controladores
 */

 namespace Agrodb\ServiciosWebRest\Controladores;
 use Agrodb\ServiciosWebRest\Modelos\UsuariosLogicaNegocio;
 use Agrodb\ServiciosWebRest\Modelos\UsuariosModelo;
 use Agrodb\Token\JwtVerify;
 use Agrodb\Core\Constantes;
 use Exception;

use Agrodb\Token\Modelos\TokenLogicaNegocio;

class auTokenControlador extends BaseControlador 
{

	private $lNegocioUsuario = null;
	
	private $lNegocioToken = null;
	private $modeloUsuarios =null;

	/**
	 * Constructor
	 */
	function __construct()
	{
		$this->lNegocioUsuario = new UsuariosLogicaNegocio();
		
		$this->lNegocioToken = new TokenLogicaNegocio();
		$this->modeloUsuarios = new UsuariosModelo();
		
		set_exception_handler(array(
			$this,
			'manejadorExcepciones'
		));
	}


	/**
	 * Método para validar en base si el usuario esta en base
	 */
	public function validarCliente($identificador,$clave)
	{
		$token = null;
		$pwdEncriptada=md5($clave);
		$perfil=$this->lNegocioUsuario->validarUsuarioWs($identificador,$pwdEncriptada);
			if (isset($perfil->current()->tipo_cliente)== Constantes::clienteServiciosWeb()->CLIENTE_EXTERNO) 
			{
				$key =$perfil->current()->token;
				$mensaje = "Usuario y contraseña correctos";
				$token = $this->lNegocioToken->auth(RUTA_KEY_AGROSERVICIOS);
				$token['key']=$key;
				return($token);
			}
			else{
				return array("estado" => "Error", "mensaje" => "Usuario Invalido");
			}
	  
	}

	 /**
     * Verifica un token válido
     * 
     * @return Array Retorna un array([estado] => '',[mensaje] =>'' ) Con la llave 'estado' del token (exito/error) y la llave 'mensaje' con el detalle de la validación
     */
    public function validarTokenBearNull($key,$token,$rutaPublicKey)
    {

         $headers = apache_request_headers();
         $headers = array_change_key_case($headers, CASE_LOWER);
		
         if (isset($headers['authorization'])) {
			$cabecera = str_replace("Bearer ", "", $headers['authorization']);
		 	if($cabecera ==$key){
		 		$tokenNew = $token;
		 	}
			else if(isset($cabecera)){
	 			return (array("estado" => "error", "mensaje" => "Cabecera Vacia"));
		 	}
			
            $jwtVerify = new JwtVerify($tokenNew, $rutaPublicKey);

            if ($jwtVerify->estado) {
				$statusCode = 200;
                return (array(
					"estado" => "exito", 
					"mensaje" => 'Token válido',
					"statusCode"=>$statusCode
				));
            } else {
                http_response_code(401);                
                return array("estado" => "error", "mensaje" => $jwtVerify->mensaje);
                
            }
		}else {

             http_response_code(401);  
			 header("Content-type: application/json; charset=utf-8");         
            return (array("estado" => "error", "mensaje" => "Token requerido"));
			
         }
    }

	
}


   
  


	

