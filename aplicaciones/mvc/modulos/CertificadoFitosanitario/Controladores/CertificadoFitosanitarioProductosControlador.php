<?php
/**
 * Controlador CertificadoFitosanitarioProductos
 *
 * Este archivo controla la lógica del negocio del modelo: CertificadoFitosanitarioProductosModelo y Vistas
 *
 * @author AGROCALIDAD
 * @date   2022-07-21
 * @uses CertificadoFitosanitarioProductosControlador
 * @package CertificadoFitosanitario
 * @subpackage Controladores
 */
namespace Agrodb\CertificadoFitosanitario\Controladores;

use Agrodb\CertificadoFitosanitario\Modelos\CertificadoFitosanitarioProductosLogicaNegocio;
use Agrodb\CertificadoFitosanitario\Modelos\CertificadoFitosanitarioProductosModelo;
use Agrodb\InspeccionFitosanitaria\Modelos\TotalInspeccionFitosanitariaLogicaNegocio;
use Agrodb\Catalogos\Modelos\IdiomasLogicaNegocio;
use Agrodb\CertificadoFitosanitario\Modelos\CertificadoFitosanitarioLogicaNegocio;
use Agrodb\InspeccionFitosanitaria\Modelos\InspeccionFitosanitariaLogicaNegocio;

class CertificadoFitosanitarioProductosControlador extends BaseControlador{

	private $lNegocioCertificadoFitosanitarioProductos = null;

	private $modeloCertificadoFitosanitarioProductos = null;
	
	private $lNegocioTotalInspeccionFitosanitaria = null;
	
	private $lNegocioInspeccionFitosanitaria = null;
	
	private $lNegocioCertificadoFitosanitario = null;
	
	private $lNegocioIdiomas = null;

	private $accion = null;

	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->lNegocioCertificadoFitosanitarioProductos = new CertificadoFitosanitarioProductosLogicaNegocio();
		$this->modeloCertificadoFitosanitarioProductos = new CertificadoFitosanitarioProductosModelo();
		$this->lNegocioTotalInspeccionFitosanitaria = new TotalInspeccionFitosanitariaLogicaNegocio();
		$this->lNegocioInspeccionFitosanitaria = new InspeccionFitosanitariaLogicaNegocio();
		$this->lNegocioCertificadoFitosanitario = new CertificadoFitosanitarioLogicaNegocio();
		$this->lNegocioIdiomas = new IdiomasLogicaNegocio();
		set_exception_handler(array(
			$this,
			'manejadorExcepciones'));
	}

	/**
	 * Método de inicio del controlador
	 */
	public function index(){
		$modeloCertificadoFitosanitarioProductos = $this->lNegocioCertificadoFitosanitarioProductos->buscarCertificadoFitosanitarioProductos();
		$this->tablaHtmlCertificadoFitosanitarioProductos($modeloCertificadoFitosanitarioProductos);
		require APP . 'CertificadoFitosanitario/vistas/listaCertificadoFitosanitarioProductosVista.php';
	}

	/**
	 * Método para desplegar el formulario vacio
	 */
	public function nuevo(){
		$this->accion = "Nuevo CertificadoFitosanitarioProductos";
		require APP . 'CertificadoFitosanitario/vistas/formularioCertificadoFitosanitarioProductosVista.php';
	}

	/**
	 * Método para registrar en la base de datos -CertificadoFitosanitarioProductos
	 */
	public function guardar(){
		$this->lNegocioCertificadoFitosanitarioProductos->guardar($_POST);
	}

	/**
	 * Obtenemos los datos del registro seleccionado para editar - Tabla: CertificadoFitosanitarioProductos
	 */
	public function editar(){
		$this->accion = "Editar CertificadoFitosanitarioProductos";
		$this->modeloCertificadoFitosanitarioProductos = $this->lNegocioCertificadoFitosanitarioProductos->buscar($_POST["id"]);
		require APP . 'CertificadoFitosanitario/vistas/formularioCertificadoFitosanitarioProductosVista.php';
	}

	/**
	 * Método para borrar un registro en la base de datos - CertificadoFitosanitarioProductos
	 */
	public function borrar(){
		$this->lNegocioCertificadoFitosanitarioProductos->borrar($_POST['id_certificado_fitosanitario_producto']);
	}

	/**
	 * Construye el código HTML para desplegar la lista de - CertificadoFitosanitarioProductos
	 */
	public function tablaHtmlCertificadoFitosanitarioProductos($tabla){
		{
			$contador = 0;
			foreach ($tabla as $fila){
				$this->itemsFiltrados[] = array(
					'<tr id="' . $fila['id_certificado_fitosanitario_producto'] . '"
		  class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'CertificadoFitosanitario\certificadofitosanitarioproductos"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++ $contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_certificado_fitosanitario_producto'] . '</b></td>
<td>' . $fila['id_certificado_fitosanitario'] . '</td>
<td>' . $fila['identificador_exportador']
		  . '</td>
<td>' . $fila['razon_social_exportador'] . '</td>
</tr>');
		}
		}
	}

	/**
	 * Método para borrar un registro en la base de datos - CertificadoFitosanitarioProductos
	 */
	public function agregarProductoInspeccionado(){
		
		$datosInspeccion = $_POST['datosInspeccion'];

		$validacion = "";
		$resultado = "";
		$filaProductoInspeccion = "";
		$banderaRegistrarProducto = true;
		$banderaUnidadIncorrecta = true;
		$productoRegistrado = "";
		$aResultadoRegistroProducto = "";
	
		if (is_array($datosInspeccion)){
		
			foreach ($datosInspeccion as $llave => $valor){
				
				$idCertificadoFitosanitario = $valor['idCertificadoFitosanitario'];
				$idTotalInspeccionado = $valor['idTotalInspeccionado'];
				
				$datosValidarRegistroProducto = [
					'id_certificado_fitosanitario' => $idCertificadoFitosanitario,
					'id_total_inspeccion_fitosanitaria' => $idTotalInspeccionado];
				
				$qValidarProductoRegistrado = $this->lNegocioCertificadoFitosanitarioProductos->buscarLista($datosValidarRegistroProducto);
				
				if ($qValidarProductoRegistrado->count()){
				    
					$nombreProducto = $qValidarProductoRegistrado->current()->nombre_producto;
					$productoRegistrado .= $nombreProducto . ', ';
					$banderaRegistrarProducto = false;
					
				}else{
				    
				    $qDatosProductoAgregado = $this->lNegocioTotalInspeccionFitosanitaria->obtenerDatosTotalInspeccionFitosanitaria($idTotalInspeccionado);
				    $idProductoAgregado = $qDatosProductoAgregado->current()->id_producto;
				    $idUnidadCantidadComercialAgregado = $qDatosProductoAgregado->current()->id_unidad_cantidad_producto;
				    
				    $qDatosProducto = $this->lNegocioCertificadoFitosanitarioProductos->buscarLista(array('id_certificado_fitosanitario' => $idCertificadoFitosanitario));
				    
				    foreach ($qDatosProducto as $datoProducto) {
				        $idProducto = $datoProducto['id_producto'];
				        $cantidadComercial = $datoProducto['id_unidad_cantidad_comercial'];
				        
				        if($idProductoAgregado == $idProducto){
				            if($idUnidadCantidadComercialAgregado != $cantidadComercial){
    				            $banderaUnidadIncorrecta = false;
    				            $banderaRegistrarProducto = false;
				            }
				        }
				        
				    }  
				    
				}
			}
		
		}
		
		if ($banderaRegistrarProducto){			
			$aResultadoRegistroProducto = $this->lNegocioCertificadoFitosanitarioProductos->agregarProductoInspeccionado($datosInspeccion);
			
			if($aResultadoRegistroProducto['validacion']){				
				$datosProducto = $aResultadoRegistroProducto['resultado'];				
				$filaProductoInspeccion = $this->generarFilaProductoIspeccionado($datosProducto);			
			}			
		}
		
		if(!$banderaRegistrarProducto){			
			$productoRegistrado = trim($productoRegistrado, ', ');
			$validacion = "Fallo";
			$resultado = "El producto " . $productoRegistrado . " ya se encuentra agregado para la solicitud de inspección.";			
		}
		
		if(!$banderaUnidadIncorrecta){
		    $validacion = "Fallo";
		    $resultado = "Debe registrar la misma unidad de medida en productos iguales.";
		}
				
		echo json_encode(array(
			'validacion' => $validacion,
			'resultado' => $resultado,
			'filaProductoInspeccion' => $filaProductoInspeccion
		));		
		
	}
	
	/**
	 * Método para generar fila de producto inspeccion
	 */
	public function generarFilaProductoIspeccionado($datos)
	{
		
		$filaProductoInspeccionado = "";
		
		$idCertificadoFitosanitario = $datos[0]['id_certificado_fitosanitario'];
		
		$qDatosCertificadoFitosanitario = $this->lNegocioCertificadoFitosanitario->buscar($idCertificadoFitosanitario);
		$idIdiomaCertificado = $qDatosCertificadoFitosanitario->getIdIdioma();
		
		$qDatosIdioma = $this->lNegocioIdiomas->buscar($idIdiomaCertificado);
		$codigoIdioma = $qDatosIdioma->getCodigoIdioma();
			
		foreach ($datos as $value) {
			
		    $datosPesoBruto = '<td></td>';
			$idCertificadoFitosanitarioProducto = $value['id_certificado_fitosanitario_producto'];
			$nombreSubtipoProducto = $value['nombre_subtipo_producto'];
			$nombreProducto = $value['nombre_producto'];
			$cantidadComercial = $value['cantidad_comercial'];
			$idUnidadCantidadComercial = $value['id_unidad_cantidad_comercial'];
			$pesoNeto = $value['peso_neto'];
			$idUnidadPesoNeto = $value['id_unidad_peso_neto'];			
			$idTotalInspeccionFitosanitaria = $value['id_total_inspeccion_fitosanitaria'];
			
			if(isset($value['id_unidad_peso_bruto'])){
			    $pesoBruto = $value['peso_bruto'];
			    $idUnidadPesoBruto = $value['id_unidad_peso_bruto'];
			    $datosPesoBruto = '<td>' . $pesoBruto . ' ' . $this->obtenerUnidadFitosanitaria($idUnidadPesoBruto, $codigoIdioma) . '</td>';
			}
			
			$qDatosTotalInspeccion = $this->lNegocioTotalInspeccionFitosanitaria->buscar($idTotalInspeccionFitosanitaria);
			$idInspeccionFitosanitaria = $qDatosTotalInspeccion->getIdInspeccionFitosanitaria();
			$qDatosInspeccion= $this->lNegocioInspeccionFitosanitaria->buscar($idInspeccionFitosanitaria);
			$numeroInspeccion = $qDatosInspeccion->getNumeroSolicitud();
									
			$filaProductoInspeccionado .= '<tr id="filapr' . $idCertificadoFitosanitarioProducto . '">
                            <td>' . $numeroInspeccion . '</td>
                            <td>' . $nombreSubtipoProducto . '/' . $nombreProducto . '</td>
                            <td>' . $cantidadComercial . ' ' . $this->obtenerUnidadFitosanitaria($idUnidadCantidadComercial, $codigoIdioma) . '</td>
							<td>' . $pesoNeto . ' ' . $this->obtenerUnidadFitosanitaria($idUnidadPesoNeto, $codigoIdioma) . '</td>'
							. $datosPesoBruto .
                            '<td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarDetalleProducto(' . $idCertificadoFitosanitarioProducto . '); return false;"/></td>
                       </tr>';
		}
		
		return $filaProductoInspeccionado;
		
	}
	
}
