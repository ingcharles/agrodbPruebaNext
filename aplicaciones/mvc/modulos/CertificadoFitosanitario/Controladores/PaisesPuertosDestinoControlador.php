<?php
/**
 * Controlador PaisesPuertosDestino
 *
 * Este archivo controla la lógica del negocio del modelo: PaisesPuertosDestinoModelo y Vistas
 *
 * @author AGROCALIDAD
 * @date   2022-07-21
 * @uses PaisesPuertosDestinoControlador
 * @package CertificadoFitosanitario
 * @subpackage Controladores
 */
namespace Agrodb\CertificadoFitosanitario\Controladores;

use Agrodb\CertificadoFitosanitario\Modelos\PaisesPuertosDestinoLogicaNegocio;
use Agrodb\CertificadoFitosanitario\Modelos\PaisesPuertosDestinoModelo;
use Agrodb\CertificadoFitosanitario\Modelos\CertificadoFitosanitarioProductosLogicaNegocio;

class PaisesPuertosDestinoControlador extends BaseControlador{

	private $lNegocioPaisesPuertosDestino = null;

	private $modeloPaisesPuertosDestino = null;
	
	private $lNegocioCertificadoFitosanitarioProductos = null;

	private $accion = null;

	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->lNegocioPaisesPuertosDestino = new PaisesPuertosDestinoLogicaNegocio();
		$this->modeloPaisesPuertosDestino = new PaisesPuertosDestinoModelo();
		$this->lNegocioCertificadoFitosanitarioProductos = new CertificadoFitosanitarioProductosLogicaNegocio();
		set_exception_handler(array(
			$this,
			'manejadorExcepciones'));
	}

	/**
	 * Método de inicio del controlador
	 */
	public function index(){
		$modeloPaisesPuertosDestino = $this->lNegocioPaisesPuertosDestino->buscarPaisesPuertosDestino();
		$this->tablaHtmlPaisesPuertosDestino($modeloPaisesPuertosDestino);
		require APP . 'CertificadoFitosanitario/vistas/listaPaisesPuertosDestinoVista.php';
	}

	/**
	 * Método para desplegar el formulario vacio
	 */
	public function nuevo(){
		$this->accion = "Nuevo PaisesPuertosDestino";
		require APP . 'CertificadoFitosanitario/vistas/formularioPaisesPuertosDestinoVista.php';
	}

	/**
	 * Método para registrar en la base de datos -PaisesPuertosDestino
	 */
	public function guardar(){
				
		$validacion = "";
		$resultado = "";
		$banderaRegistrarPais = false;
		$datosPuertoDestino = $_POST;
		
		$qDatosPaisPuertoDestino = $this->lNegocioPaisesPuertosDestino->obtenerPaisesPuertosDestinoPorIdCertificadoFitosanitario($datosPuertoDestino['id_certificado_fitosanitario']);
		if($qDatosPaisPuertoDestino->count()){
			$idPaisDestinoRegistrado = $qDatosPaisPuertoDestino->current()->id_pais_destino;
			if($idPaisDestinoRegistrado == $datosPuertoDestino['id_pais_destino']){
				$banderaRegistrarPais = true;
			}
		}else{
			$banderaRegistrarPais = true;
		}
		
		if($banderaRegistrarPais){
		
			$datosValidarPaisPuertoDestino = ['id_certificado_fitosanitario' => $datosPuertoDestino['id_certificado_fitosanitario']
												, 'id_pais_destino' => $datosPuertoDestino['id_pais_destino']
												, 'id_puerto_destino' => $datosPuertoDestino['id_puerto_destino']
											];
			
			$validarPaisPuertoDestino = $this->lNegocioPaisesPuertosDestino->buscarLista($datosValidarPaisPuertoDestino);
			
			if(!$validarPaisPuertoDestino->count()){
				
				$idPaisPuertoDestino = $this->lNegocioPaisesPuertosDestino->guardar($datosPuertoDestino);
				
				if($idPaisPuertoDestino){
					
					$datosPuertoDestino['id_pais_puerto_destino'] = $idPaisPuertoDestino;
					
					$filaPaisPuertoDestino = $this->generarFilaPaisPuertoDestino($datosPuertoDestino);
					
					echo json_encode(array(
						'validacion' => $validacion,
						'resultado' => $resultado,
						'filaPuertoDestino' => $filaPaisPuertoDestino
					));
					
				}else{
					
					$validacion = "Fallo";
					$resultado = "Error al ingresar los datos";
					echo json_encode(array(
						'validacion' => $validacion,
						'resultado' => $resultado
					));
					
				}
				
			}else{
				
				$validacion = "Fallo";
				$resultado = "El puerto de destino ya se encuentra registrado.";
				echo json_encode(array(
					'validacion' => $validacion,
					'resultado' => $resultado
				));
				
			}
			
		}else{
			
			$validacion = "Fallo";
			$resultado = "No se puede registrar más de un país de destino.";
			echo json_encode(array(
				'validacion' => $validacion,
				'resultado' => $resultado
			));
			
			
		}
	}

	/**
	 * Obtenemos los datos del registro seleccionado para editar - Tabla: PaisesPuertosDestino
	 */
	public function editar(){
		$this->accion = "Editar PaisesPuertosDestino";
		$this->modeloPaisesPuertosDestino = $this->lNegocioPaisesPuertosDestino->buscar($_POST["id"]);
		require APP . 'CertificadoFitosanitario/vistas/formularioPaisesPuertosDestinoVista.php';
	}

	/**
	 * Método para borrar un registro en la base de datos - PaisesPuertosDestino
	 */
	public function borrar(){
		
		$validacion = "";
		$resultado = "";
		
		$qDatosCertificadoFitosanitarioProducto = $this->lNegocioCertificadoFitosanitarioProductos->buscarLista(['id_certificado_fitosanitario' => $_POST['id_certificado_fitosanitario']]);
		$qDatosPaisDestino = $this->lNegocioPaisesPuertosDestino->buscarLista(['id_certificado_fitosanitario' => $_POST['id_certificado_fitosanitario']]);
		
		if($qDatosCertificadoFitosanitarioProducto->count()){			
			if($qDatosPaisDestino->count() > 1){			
				$this->lNegocioPaisesPuertosDestino->borrar($_POST['id_pais_puerto_destino']);
			}else{
				$validacion = "Fallo";
				$resultado = "No se puede eliminar el país de destino si tiene registros de productos.";
			}
		}else{
			if($qDatosPaisDestino->count()){
				$this->lNegocioPaisesPuertosDestino->borrar($_POST['id_pais_puerto_destino']);
			}
		}
		
		echo json_encode(array(
			'validacion' => $validacion,
			'resultado' => $resultado
		));		
		
	}

	/**
	 * Construye el código HTML para desplegar la lista de - PaisesPuertosDestino
	 */
	public function tablaHtmlPaisesPuertosDestino($tabla){
		{
			$contador = 0;
			foreach ($tabla as $fila){
				$this->itemsFiltrados[] = array(
					'<tr id="' . $fila['id_pais_puerto_destino'] . '"
		  class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'CertificadoFitosanitario\paisespuertosdestino"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++ $contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_pais_puerto_destino'] . '</b></td>
<td>' . $fila['id_certificado_fitosanitario'] . '</td>
<td>' . $fila['id_pais_destino'] . '</td>
<td>' . $fila['nombre_pais_destino'] . '</td>
</tr>');
		}
		}
	}
	
	/**
	 * Método para generar fila de pais, puerto, transito
	 */
	public function generarFilaPaisPuertoDestino($datos)
	{
		
		$idPaisPuertoDestino = $datos['id_pais_puerto_destino'];
		$nombrePaisDestino = $datos['nombre_pais_destino'];
		$nombrePuertoDestino = $datos['nombre_puerto_destino'];
		
		$filaPaisPuertoTransito = '<tr id="filapd' . $idPaisPuertoDestino . '">
                            <td>' . $nombrePaisDestino . '</td>
                            <td>' . $nombrePuertoDestino . '</td>
                            <td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarDetallePaisPuertoDestino(' . $idPaisPuertoDestino . '); return false;"/></td>
                       </tr>';
		
		return $filaPaisPuertoTransito;
		
	}
	

}
