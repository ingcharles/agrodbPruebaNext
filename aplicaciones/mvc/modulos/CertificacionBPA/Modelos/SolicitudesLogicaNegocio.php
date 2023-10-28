<?php
 /**
 * Lógica del negocio de SolicitudesModelo
 *
 * Este archivo se complementa con el archivo SolicitudesControlador.
 *
 * @author  AGROCALIDAD
 * @date    2020-03-23
 * @uses    SolicitudesLogicaNegocio
 * @package CertificacionBPA
 * @subpackage Modelos
 */
  namespace Agrodb\CertificacionBPA\Modelos;
  
  use Agrodb\CertificacionBPA\Modelos\IModelo;
 
class SolicitudesLogicaNegocio implements IModelo 
{

	 private $modeloSolicitudes = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloSolicitudes = new SolicitudesModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new SolicitudesModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		
		if ($tablaModelo->getIdSolicitud() != null && $tablaModelo->getIdSolicitud() > 0) {
		    return $this->modeloSolicitudes->actualizar($datosBd, $tablaModelo->getIdSolicitud());
		} else {
    		unset($datosBd["id_solicitud"]);
    		return $this->modeloSolicitudes->guardar($datosBd);
    	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloSolicitudes->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return SolicitudesModelo
	*/
	public function buscar($id)
	{
		return $this->modeloSolicitudes->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloSolicitudes->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloSolicitudes->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarSolicitudes()
	{
	$consulta = "SELECT * FROM ".$this->modeloSolicitudes->getEsquema().". solicitudes";
		 return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
	}

	public function buscarEstadoSolicitudes($identificador)
	{
	    $consulta = "   SELECT 
                            DISTINCT estado
                        FROM
                            g_certificacion_bpa.solicitudes
                        WHERE
                            identificador in ('$identificador')
                        GROUP BY
                            estado; ";
	    
	    return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
	}
	
	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 * Buscar solicitudes usando filtros.
	 *
	 * @return array|ResultSet
	 */
	public function buscarSolicitudesFiltradas($arrayParametros)
	{
	    $busqueda = '';
	    
	    if (isset($arrayParametros['id_solicitud']) && ($arrayParametros['id_solicitud'] != '')) {
	        $busqueda .= " and s.id_solicitud = " . $arrayParametros['id_solicitud'] . "";
	    } 
	    
	    $consulta = "  SELECT
                        	*
                        FROM
                        	g_certificacion_bpa.solicitudes s
                        WHERE
                            s.estado = 'Aprobado' 
                            " . $busqueda . "
                        ORDER BY
                        	s.id_solicitud ASC;";
	    
	    //echo $consulta;
	    return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
	}
	
	public function verificarAnularSolicitud($idSolicitud)
	{
	    $validacion = array(
	        'bandera' => false,
	        'estado' => "Fallo",
	        'mensaje' => "Ocurrió un error al anular la solicitud de certificación BPA",
	        'contenido' => null
	    );
	    
	    $resultado = $this->anularSolicitudes($idSolicitud);
	    
	    if ($resultado) {
	        $validacion['estado'] = "exito";
	        $validacion['mensaje'] = "Se ha anulado el registro.";
	        $validacion['bandera'] = true;
	    } else {
	        $validacion['estado'] = "Fallo";
	        $validacion['mensaje'] = "Ocurrió un error al anular la solicitud de BPA.";
	        $validacion['bandera'] = false;
	    }
	    
	    return $validacion;
	}
	
	/**
	 * Ejecuta una consulta(SQL) personalizada para obtener los productos que pueden ser modificados
	 *
	 * @return array|ResultSet
	 */
	public function anularSolicitudes($idSolicitud)
	{
	    $consulta = "UPDATE
                        g_certificacion_bpa.solicitudes
                	SET
                        estado='Anulado',
                        observacion_revision='Anulado por administrador ".$_SESSION['usuario']." en ".date('Y-m-d H:i:s')."'
                	WHERE
                        id_solicitud in ($idSolicitud);";
	    
	    return $this->modeloSolicitudes->ejecutarSqlNativo($consulta);
	}
}