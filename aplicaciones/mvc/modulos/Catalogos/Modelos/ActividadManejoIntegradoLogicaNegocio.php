<?php
 /**
 * Lógica del negocio de ActividadManejoIntegradoModelo
 *
 * Este archivo se complementa con el archivo ActividadManejoIntegradoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-06-23
 * @uses    ActividadManejoIntegradoLogicaNegocio
 * @package ServiciosWebRest
 * @subpackage Modelos
 */
  
  namespace Agrodb\Catalogos\Modelos;
  
  use Agrodb\Catalogos\Modelos\IModelo;
  use Agrodb\Token\Modelos\TokenLogicaNegocio;
  use Agrodb\Core\Excepciones\BuscarExcepcion;
  use \Exception;
 
class ActividadManejoIntegradoLogicaNegocio implements IModelo 
{

	 private $modeloActividadManejoIntegrado = null;
	 private $lNegocioToken = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloActividadManejoIntegrado = new ActividadManejoIntegradoModelo();
	 $this->lNegocioToken = new TokenLogicaNegocio();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new ActividadManejoIntegradoModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getId() != null && $tablaModelo->getId() > 0) {
		return $this->modeloActividadManejoIntegrado->actualizar($datosBd, $tablaModelo->getId());
		} else {
		unset($datosBd["id"]);
		return $this->modeloActividadManejoIntegrado->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloActividadManejoIntegrado->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return ActividadManejoIntegradoModelo
	*/
	public function buscar($id)
	{
		return $this->modeloActividadManejoIntegrado->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloActividadManejoIntegrado->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloActividadManejoIntegrado->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarActividadManejoIntegrado()
	{
	$consulta = "SELECT * FROM ".$this->modeloActividadManejoIntegrado->getEsquema().". actividad_manejo_integrado";
		 return $this->modeloActividadManejoIntegrado->ejecutarSqlNativo($consulta);
	}

	/**
	 * KA: PRY-2022-009
     * retorna un Json el catálogo de Actividades manejo integrado
	 * para los dropdown del cliente app.
     *
     * @return array|Json
     */
    public function ObtenerCatalogosActividadManejoIntegrado(){

        $arrayToken = $this->lNegocioToken->validarToken(RUTA_PUBLIC_KEY_AGROSERVICIOS);

        if ($arrayToken['estado'] == 'exito') {
		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			$condicion="codigo in('PLG_OBJ_CTRL',
			'ESP_HOSPE',
			'FUEN',
			'PLG_OBJ_DIA',
			'AC_MIP',
			'INSUM',
			'MED_CTRL',
			'ESCEN',
			'ESP_HORT_FRUT') and estado=1 ORDER BY  codigo ASC";
			$consulta="SELECT id,nombre,codigo FROM g_catalogos.actividad_manejo_integrado where ".$condicion.";";
            try {
				$res = $this->modeloActividadManejoIntegrado->ejecutarSqlNativo($consulta);
				$array['estado'] = 'exito';
				$array['mensaje'] = "Los datos han sido obtenidos satisfactoriamente";				
				$array['cuerpo'] = $res->toArray();
				http_response_code(200);
				echo json_encode($array,JSON_UNESCAPED_UNICODE);		
			} catch (Exception $ex) {
				$array['estado'] = 'error';
				$array['mensaje'] = 'Error al obtener datos: ' . $ex;
				http_response_code(400);
				echo json_encode($array,JSON_UNESCAPED_UNICODE);
				throw new BuscarExcepcion($ex, array('controlador'=>'RestWsCatalogosManejoIntegradoControlador','archivo' => 'ActividadManejoIntegradoLogicaNegocio', 'metodo' => 'ObtenerCatalogosActividadManejoIntegrado', 'consulta' => $consulta));
			}
		}
         } else{
            echo json_encode($arrayToken);
        }  
    }

}
