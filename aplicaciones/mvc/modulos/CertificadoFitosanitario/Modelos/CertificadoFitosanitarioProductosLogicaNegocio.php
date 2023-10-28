<?php
/**
 * Lógica del negocio de CertificadoFitosanitarioProductosModelo
 *
 * Este archivo se complementa con el archivo CertificadoFitosanitarioProductosControlador.
 *
 * @author AGROCALIDAD
 * @date    2022-07-21
 * @uses CertificadoFitosanitarioProductosLogicaNegocio
 * @package CertificadoFitosanitario
 * @subpackage Modelos
 */
namespace Agrodb\CertificadoFitosanitario\Modelos;

use Agrodb\CertificadoFitosanitario\Modelos\IModelo;
use Agrodb\Core\Excepciones\GuardarExcepcion;
use Agrodb\Catalogos\Modelos\ProductosLogicaNegocio;
use Agrodb\InspeccionFitosanitaria\Modelos\TotalInspeccionFitosanitariaLogicaNegocio;
use Agrodb\Catalogos\Modelos\UnidadesFitosanitariasLogicaNegocio;

class CertificadoFitosanitarioProductosLogicaNegocio implements IModelo{

	private $modeloCertificadoFitosanitarioProductos = null;

	private $lNegocioProductos = null;

	private $lNegocioTotalInspeccionFitosanitaria = null;
	
	private $lNegocioUnidadesFitosanitarias = null;

	/**
	 * Constructor
	 *
	 * @retorna void
	 */
	public function __construct(){
		$this->modeloCertificadoFitosanitarioProductos = new CertificadoFitosanitarioProductosModelo();
		$this->lNegocioProductos = new ProductosLogicaNegocio();
		$this->lNegocioTotalInspeccionFitosanitaria = new TotalInspeccionFitosanitariaLogicaNegocio();
		$this->lNegocioUnidadesFitosanitarias = new UnidadesFitosanitariasLogicaNegocio();
	}

	/**
	 * Guarda el registro actual
	 *
	 * @param array $datos
	 * @return int
	 */
	public function guardar(Array $datos){
		$tablaModelo = new CertificadoFitosanitarioProductosModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdCertificadoFitosanitarioProducto() != null && $tablaModelo->getIdCertificadoFitosanitarioProducto() > 0){
			return $this->modeloCertificadoFitosanitarioProductos->actualizar($datosBd, $tablaModelo->getIdCertificadoFitosanitarioProducto());
		}else{
			unset($datosBd["id_certificado_fitosanitario_producto"]);
			return $this->modeloCertificadoFitosanitarioProductos->guardar($datosBd);
		}
	}

	/**
	 * Borra el registro actual
	 *
	 * @param
	 *        	string Where|array $where
	 * @return int
	 */
	public function borrar($id){
		
		$idCertificadoFiosanitarioProducto = $_POST['id_certificado_fitosanitario_producto'];
		
		$qDatosProducto = $this->buscar($idCertificadoFiosanitarioProducto);
		$idTotalInspeccionFitosanitaria = $qDatosProducto->getIdTotalInspeccionFitosanitaria();
		$cantidadComercial = $qDatosProducto->getCantidadComercial();
		$pesoNeto = $qDatosProducto->getPesoNeto();
		
		$arrayDatosProductoAgregado = [
			'tipo_transaccion' => 'ingreso',
			'id_total_inspeccion_fitosanitaria' => $idTotalInspeccionFitosanitaria,
			'cantidad_ingreso' => $cantidadComercial,
			'peso_ingreso' => $pesoNeto,
			'cantidad_egreso' => 0,
			'peso_egreso' => 0];
		
		$resultadoTransaccion = $this->guardarTransaccionProductoAgregado($arrayDatosProductoAgregado);
		
		if ($resultadoTransaccion){
			
			$this->modeloCertificadoFitosanitarioProductos->borrar($id);
			
		}
		
		
	}

	/**
	 *
	 * Buscar un registro de con la clave primaria
	 *
	 * @param int $id
	 * @return CertificadoFitosanitarioProductosModelo
	 */
	public function buscar($id){
		return $this->modeloCertificadoFitosanitarioProductos->buscar($id);
	}

	/**
	 * Busca todos los registros
	 *
	 * @return array|ResultSet
	 */
	public function buscarTodo(){
		return $this->modeloCertificadoFitosanitarioProductos->buscarTodo();
	}

	/**
	 * Busca una lista de acuerdo a los parámetros <params> enviados.
	 *
	 * @return array|ResultSet
	 */
	public function buscarLista($where = null, $order = null, $count = null, $offset = null){
		return $this->modeloCertificadoFitosanitarioProductos->buscarLista($where, $order, $count, $offset);
	}

	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 *
	 * @return array|ResultSet
	 */
	public function buscarCertificadoFitosanitarioProductos(){
		$consulta = "SELECT * FROM " . $this->modeloCertificadoFitosanitarioProductos->getEsquema() . ". certificado_fitosanitario_productos";
		return $this->modeloCertificadoFitosanitarioProductos->ejecutarSqlNativo($consulta);
	}

	/**
	 * Guarda el registro actual
	 *
	 * @param array $datos
	 * @return int
	 */
	public function agregarProductoInspeccionado(Array $datos){
		
		$validacion = true;
		$resultado = "";

		try{

			$procesoIngreso = $this->modeloCertificadoFitosanitarioProductos->getAdapter()
				->getDriver()
				->getConnection();
			$procesoIngreso->beginTransaction();

			foreach ($datos as $llave => $valor){

				$arrayDatosProductoAgregado = array();
				$datosProducto = array();
				
				$idCertificadoFitosanitario = $valor['idCertificadoFitosanitario'];
				$idTotalInspeccionado = $valor['idTotalInspeccionado'];
				$cantidad = $valor['cantidad'];
				$pesoNeto = $valor['pesoNeto'];
				$fechaInspeccion = $valor['fechaInspeccion'];
				
				$qDatosProductoAgregado = $this->lNegocioTotalInspeccionFitosanitaria->obtenerDatosTotalInspeccionFitosanitaria($idTotalInspeccionado);
				
				$arrayDatosProductoAgregado = [
					'tipo_transaccion' => 'egreso',
					'id_total_inspeccion_fitosanitaria' => $qDatosProductoAgregado->current()->id_total_inspeccion_fitosanitaria,
					'cantidad_ingreso' => 0,
					'peso_ingreso' => 0,
					'cantidad_egreso' => $cantidad,
					'peso_egreso' => $pesoNeto];			
				
				$statement = $this->modeloCertificadoFitosanitarioProductos->getAdapter()
				->getDriver()
				->createStatement();

				$resultadoTransaccion = $this->guardarTransaccionProductoAgregado($arrayDatosProductoAgregado);

				if ($resultadoTransaccion){			

					$datosProducto = [
						'id_certificado_fitosanitario' => $idCertificadoFitosanitario,
						'id_total_inspeccion_fitosanitaria' => $qDatosProductoAgregado->current()->id_total_inspeccion_fitosanitaria,
						'id_subtipo_producto' => $qDatosProductoAgregado->current()->id_subtipo_producto,
						'nombre_subtipo_producto' => $qDatosProductoAgregado->current()->nombre_subtipo_producto,
						'id_producto' => $qDatosProductoAgregado->current()->id_producto,
						'nombre_producto' => $qDatosProductoAgregado->current()->nombre_producto,
						'cantidad_comercial' => $cantidad,
						'id_unidad_cantidad_comercial' => $qDatosProductoAgregado->current()->id_unidad_cantidad_producto,
						'codigo_unidad_cantidad_comercial' => $qDatosProductoAgregado->current()->codigo_unidad_cantidad_producto,
						'peso_neto' => $pesoNeto,
						'id_unidad_peso_neto' => $qDatosProductoAgregado->current()->id_unidad_peso_producto,
						'codigo_unidad_peso_neto' => $qDatosProductoAgregado->current()->codigo_unidad_peso_producto,
						'id_tipo_tratamiento' => $qDatosProductoAgregado->current()->id_tipo_tratamiento,
						'codigo_tipo_tratamiento' => $qDatosProductoAgregado->current()->codigo_tipo_tratamiento,
						'id_tratamiento' => $qDatosProductoAgregado->current()->id_tratamiento,
						'codigo_tratamiento' => $qDatosProductoAgregado->current()->codigo_tratamiento,
						'id_duracion' => $qDatosProductoAgregado->current()->id_duracion,
						'codigo_unidad_duracion' => $qDatosProductoAgregado->current()->codigo_unidad_duracion,
						'duracion' => $qDatosProductoAgregado->current()->duracion,
						'id_temperatura' => $qDatosProductoAgregado->current()->id_temperatura,
						'codigo_unidad_temperatura' =>$qDatosProductoAgregado->current()->codigo_unidad_temperatura,
						'temperatura' => $qDatosProductoAgregado->current()->temperatura,
						'fecha_tratamiento' => $qDatosProductoAgregado->current()->fecha_tratamiento,
						'producto_quimico' => $qDatosProductoAgregado->current()->producto_quimico,
						'id_concentracion' => $qDatosProductoAgregado->current()->id_concentracion,
						'fecha_inspeccion' => $fechaInspeccion,
						'codigo_unidad_concentracion' => $qDatosProductoAgregado->current()->codigo_unidad_concentracion,
						'concentracion' => $qDatosProductoAgregado->current()->concentracion
					];
					
					if(!empty($valor['pesoBruto'])){
						$pesoBruto = $valor['pesoBruto'];
						
						$qDatosPesoBruto = $this->lNegocioUnidadesFitosanitarias->buscarLista(array('codigo_unidad_fitosanitaria' => 'KGM'));
						$idUnidadPesoBruto = $qDatosPesoBruto->current()->id_unidad_fitosanitaria;
						$codigoUnidadPesoBruto = $qDatosPesoBruto->current()->codigo_unidad_fitosanitaria;
						
						$datosProducto += ['peso_bruto' => $pesoBruto];
						$datosProducto += ['id_unidad_peso_bruto' => $idUnidadPesoBruto];
						$datosProducto += ['codigo_unidad_peso_bruto' => $codigoUnidadPesoBruto];
					}
					
					$sqlInsertar = $this->modeloCertificadoFitosanitarioProductos->guardarSql('certificado_fitosanitario_productos', $this->modeloCertificadoFitosanitarioProductos->getEsquema());
					$sqlInsertar->columns(array_keys($datosProducto));
					$sqlInsertar->values($datosProducto, $sqlInsertar::VALUES_MERGE);
					$sqlInsertar->prepareStatement($this->modeloCertificadoFitosanitarioProductos->getAdapter(), $statement);
					$statement->execute();
					$idCertificadoFitosanitarioProducto = $this->modeloCertificadoFitosanitarioProductos->adapter->driver->getLastGeneratedValue($this->modeloCertificadoFitosanitarioProductos->getEsquema() . '.certificado_fitosanitario_pro_id_certificado_fitosanitario__seq');
					
					$datosProducto['id_certificado_fitosanitario_producto'] = $idCertificadoFitosanitarioProducto;
					
					$aProductos[] = $datosProducto;									
					
				}else{
					
					$validacion = false;					
					
				}

			}			
			
			$resultado = $aProductos;
			
			$procesoIngreso->commit();
			
			
			return array('validacion' => $validacion,
						'resultado' => $resultado);
			
		}catch (GuardarExcepcion $ex){
			$procesoIngreso->rollback();
			throw new \Exception($ex->getMessage());
		}
	}

	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 *
	 * @return array|ResultSet
	 */
	public function guardarTransaccionProductoAgregado($datosProductoRegistrado){

		$tipoTransaccion = $datosProductoRegistrado['tipo_transaccion'];
		$idTotalInspeccionFitosanitaria = $datosProductoRegistrado['id_total_inspeccion_fitosanitaria'];
		$cantidadIngreso = $datosProductoRegistrado['cantidad_ingreso'];
		$pesoIngreso = $datosProductoRegistrado['peso_ingreso'];
		$cantidadEgreso = $datosProductoRegistrado['cantidad_egreso'];
		$pesoEgreso = $datosProductoRegistrado['peso_egreso'];
		 
		 $consulta = "SELECT * FROM g_certificado_fitosanitario.f_agregar_descontar_saldo_inspeccion('". $tipoTransaccion . "', $idTotalInspeccionFitosanitaria, $cantidadIngreso, $pesoIngreso, $cantidadEgreso, $pesoEgreso)";
		 return $this->modeloCertificadoFitosanitarioProductos->ejecutarSqlNativo($consulta);
		 
		return 1;
	}
}
