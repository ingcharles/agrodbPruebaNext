<?php
 /**
 * Lógica del negocio de UsuariosModelo
 *
 * Este archivo se complementa con el archivo UsuariosControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-05-25
 * @uses    UsuariosLogicaNegocio
 * @package ServicioWebRest
 * @subpackage Modelos
 */
  namespace Agrodb\ServiciosWebRest\Modelos;
  
  use Agrodb\ServiciosWebRest\Modelos\IModelo;
 // use Agrodb\ServiciosWebRest\Controladores\auTokenControlador;
  use Agrodb\Token\JwtVerify;
  use Agrodb\Token\Modelos\TokenLogicaNegocio;
class UsuariosLogicaNegocio implements IModelo 
{

	 private $modeloUsuarios = null;
     private $lNegocioToken=null;

	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
		//$this->lNegocioToken = new auTokenControlador();
	    $this->modeloUsuarios = new UsuariosModelo();
 		$this ->lNegocioToken=new TokenLogicaNegocio();

	 //set_exception_handler(array($this, 'manejadorExcepciones'));
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new UsuariosModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdUsuario() != null && $tablaModelo->getIdUsuario() > 0) {
		return $this->modeloUsuarios->actualizar($datosBd, $tablaModelo->getIdUsuario());
		} else {
		unset($datosBd["id_usuario"]);
		return $this->modeloUsuarios->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloUsuarios->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return UsuariosModelo
	*/
	public function buscar($id)
	{
		return $this->modeloUsuarios->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloUsuarios->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloUsuarios->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarUsuarios()
	{
	$consulta = "SELECT * FROM ".$this->modeloUsuarios->getEsquema().". usuarios";
		 return $this->modeloUsuarios->ejecutarSqlNativo($consulta);
	}


	/**
	* busca si el usuario esta ingresado en la base de datos del guia .
	*
	* @return array|ResultSet
	*/
	public function validarUsuarioWs($identificador,$pwdEncriptada)
	{
		$condicion="identificador='$identificador' and clave='$pwdEncriptada'";
		$consulta="SELECT tipo_cliente,token FROM g_servicios_web.usuarios where ".$condicion.";";
		 return $this->modeloUsuarios->ejecutarSqlNativo($consulta);
	}

	 /**
     * funcion para retornar 
     * 
     * @return Json Retorna un objeto json de base de datos con extructura  Geojson
     */
	public function obtenerInformeFusariun($fechaInicio,$fechaFin,$tipoEnfermedad)
	{
		set_time_limit(300);  
		$fechaInicio = ("'".$fechaInicio."'");
        $fechaFin = ("'".$fechaFin."'");
		$tipoEnfermedad=("'%".$tipoEnfermedad."%'");
        $consulta = "select *from f_inspeccion.fs_vigilancia_rt4_fusariun($fechaInicio,$fechaFin,$tipoEnfermedad);";
		$response=$this->modeloUsuarios->ejecutarSqlNativo($consulta);
        return $response;
	}

	 /**
     * Verifica un token válido
     * 
     * @return Array Retorna un array([estado] => '',[mensaje] =>'' ) Con la llave 'estado' del token (exito/error) y la llave 'mensaje' con el detalle de la validación
     */
    public function validarTokenBearNull($token,$rutaPublicKey)
    {
         $headers = apache_request_headers();
         $headers = array_change_key_case($headers, CASE_LOWER);
         if (isset($headers['authorization'])) {
			$cabecera = str_replace("Bearer ", "", $headers['authorization']);
		 	if($cabecera =="593"){
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
