<?php
 /**
 * Lógica del negocio de EspecieVegetalesModelo
 *
 * Este archivo se complementa con el archivo EspecieVegetalesControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023/04/12
 * @uses    EspecieVegetalesLogicaNegocio
 * @package RestWsReporteEnfermedadFC4
 * @subpackage Modelos
 */


 namespace Agrodb\ServiciosWebRest\Controladores;

 use Agrodb\ServiciosWebRest\Controladores\auTokenControlador;
 use Agrodb\Core\Excepciones\BuscarExcepcion;
use Agrodb\ServiciosWebRest\Modelos\UsuariosLogicaNegocio;
use Agrodb\Token\JwtVerify;
use Exception;
 
class RestWsReporteEnfermedadRt4Controlador extends BaseControlador 
{

	 private $lNegocioToken = null;
	 private $lNegocioFusariunInforme= null;

	/**
	* Constructor
	* 
	 */
	function __construct()
	{
	 $this->lNegocioToken = new auTokenControlador();
	 $this->lNegocioFusariunInforme=new UsuariosLogicaNegocio();
	 set_exception_handler(array($this, 'manejadorExcepciones'));
	}

	

	
	/**
	* Metodo para obtener el informe de catalogos de la enfermedad rt4 fusariun 
	*
	*/

	public function obtenerInformacionEnfermedadRt4()
	{
        $informacionEnfermedadFc4 = (array) json_decode(file_get_contents('php://input'));
		if(array_key_exists('identificador',$informacionEnfermedadFc4)
		   && array_key_exists('clave',$informacionEnfermedadFc4)
		   && array_key_exists('disease',$informacionEnfermedadFc4)
		   && array_key_exists('datebegin',$informacionEnfermedadFc4)
		   && array_key_exists('dateend',$informacionEnfermedadFc4)){
			$arrayToken = $this->lNegocioToken->validarCliente($informacionEnfermedadFc4['identificador'], $informacionEnfermedadFc4['clave']);
			if ($arrayToken['estado'] == 'exito' && $_SERVER['REQUEST_METHOD'] == 'POST') {
				$arrayToken = $this->lNegocioToken->validarTokenBearNull($arrayToken['key'],$arrayToken['token'],RUTA_PUBLIC_KEY_AGROSERVICIOS);
				if($arrayToken['mensaje']=="Token válido")
				{
					try{
						$arrayToken=null;
						$res = $this->lNegocioFusariunInforme->obtenerInformeFusariun($informacionEnfermedadFc4['datebegin'], $informacionEnfermedadFc4['dateend'],$informacionEnfermedadFc4['disease']);
						$rest1= $res->current()->fs_vigilancia_rt4_fusariun;
						header("Content-type: application/json; charset=utf-8");
						http_response_code(200);
						echo ($rest1);
					}catch (Exception $ex) {
						$array['estado'] = 'error';
						$array['mensaje'] = 'Error al obtener datos: ' . $ex;
						http_response_code(400);
						throw new BuscarExcepcion($ex, array('controlador'=>'RestWsReporteEnfermedadRt4','archivo' => 'obtenerInformacionEnfermedadRt4', 'metodo' => 'obtenerInformacionEnfermedadRt4', 'en la funcion' => 'generarGeojsonRt4Fusariun'));
					}
				}else{
					http_response_code(401);
					header("Content-type: application/json; charset=utf-8");
					echo json_encode(array("estado" => "error", "mensaje" => "No esta Autorizado"));
				}				
			} else{
				 http_response_code(401);
				$estado='Error';
				$mensaje='Usuario no encontrado';
				 header("Content-type: application/json; charset=utf-8");
				 echo json_encode(array("estado"=>$estado, "mensaje" => $mensaje));
				
			} 
		}else{
			http_response_code(400);
			$estado='Error';
			$mensaje='Formato del cuerpo de la request es invalido';
			 header("Content-type: application/json; charset=utf-8");
			 echo json_encode(array("estado"=>$estado, "mensaje" => $mensaje));
		}
	}
}
?>
