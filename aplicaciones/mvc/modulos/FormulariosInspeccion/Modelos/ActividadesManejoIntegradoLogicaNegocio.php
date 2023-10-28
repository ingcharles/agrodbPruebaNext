<?php
 /**
 * Lógica del negocio de ActividadesManejoIntegradoModelo
 *
 * Este archivo se complementa con el archivo ActividadesManejoIntegradoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023/04/12
 * @uses    ActividadesManejoIntegradoLogicaNegocio
 * @package RestWsActividadManejoIntegrado
 * @subpackage Modelos
 */
namespace Agrodb\FormulariosInspeccion\Modelos;

use Agrodb\Catalogos\Modelos\MedidasControlModelo;
use Agrodb\FormulariosInspeccion\Modelos\IModelo;
  use Agrodb\Token\Modelos\TokenLogicaNegocio;
  use Agrodb\Core\Excepciones\GuardarExcepcion;
 use Zend\Db\Sql\Expression;
  use Exception;
 
class ActividadesManejoIntegradoLogicaNegocio implements IModelo 
{

	 private $modeloActividadesManejoIntegrado = null;
	 private $lNegocioToken = null;
	 private $storeProcedure=null;

	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloActividadesManejoIntegrado = new ActividadesManejoIntegradoModelo();
	 $this->lNegocioToken = new TokenLogicaNegocio();
	 $this->storeProcedure=new Expression();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new ActividadesManejoIntegradoModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getId() != null && $tablaModelo->getId() > 0) {
		return $this->modeloActividadesManejoIntegrado->actualizar($datosBd, $tablaModelo->getId());
		} else {
		unset($datosBd["id"]);
		return $this->modeloActividadesManejoIntegrado->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloActividadesManejoIntegrado->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return ActividadesManejoIntegradoModelo
	*/
	public function buscar($id)
	{
		return $this->modeloActividadesManejoIntegrado->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloActividadesManejoIntegrado->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloActividadesManejoIntegrado->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarActividadesManejoIntegrado()
	{
	$consulta = "SELECT * FROM ".$this->modeloActividadesManejoIntegrado->getEsquema().". actividades_manejo_integrado";
		 return $this->modeloActividadesManejoIntegrado->ejecutarSqlNativo($consulta);
	}



	

	/**
	* Guarda los registros del manejo integrado de Actividad
	*
	*/
	public function guardarManejoIntegradoActividad( $arrayManejoActividad)
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			  $arrayToken = $this->lNegocioToken->validarToken(RUTA_PUBLIC_KEY_AGROSERVICIOS);
				
			  if($arrayToken['estado'] == 'exito'){
			try{
				$manejoActividad=json_encode($arrayManejoActividad);
				$jsonfinal = ("'".$manejoActividad."'");
				$cero=0;
				$callquery=" CALL f_inspeccion.sp_insertar_actividad_manejo_integrado($jsonfinal,$cero)";
				$resultado =$this->modeloActividadesManejoIntegrado->ejecutarSqlNativo($callquery);
			
				$rest1= $resultado->current()->insertado;
				
	
				if($rest1==1){
						 http_response_code(200);
						 echo json_encode(array('estado' => 'exito', 'mensaje' => 'Registros almancenados en el Sistema GUIA exitosamente'));
				}else{
					http_response_code(400);
					echo json_encode(array('estado' => 'error'));
					throw new GuardarExcepcion( array('origen' => 'Agro servicios', 'ws'=>'RestWsActividadesManejoIntegradoControlador', 'archivo' => 'ActividadesManejoIntegradoLogicaNegocio', 'metodo' => 'guardarManejoActividadIntegridad', 'datos' => $arrayManejoActividad));
				}
			}catch(Exception $ex){
				http_response_code(400);
				echo json_encode(array('estado' => 'error', 'mensaje' => $ex->getMessage()));
			}
		  } else{
			  	echo json_encode($arrayToken);
			 }	
			
		}

	}


}
