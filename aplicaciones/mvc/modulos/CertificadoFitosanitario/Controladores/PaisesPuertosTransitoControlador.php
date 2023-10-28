<?php
/**
 * Controlador PaisesPuertosTransito
 *
 * Este archivo controla la lógica del negocio del modelo: PaisesPuertosTransitoModelo y Vistas
 *
 * @author AGROCALIDAD
 * @date   2022-07-21
 * @uses PaisesPuertosTransitoControlador
 * @package CertificadoFitosanitario
 * @subpackage Controladores
 */
namespace Agrodb\CertificadoFitosanitario\Controladores;

use Agrodb\CertificadoFitosanitario\Modelos\PaisesPuertosTransitoLogicaNegocio;
use Agrodb\CertificadoFitosanitario\Modelos\PaisesPuertosTransitoModelo;

class PaisesPuertosTransitoControlador extends BaseControlador{

	private $lNegocioPaisesPuertosTransito = null;

	private $modeloPaisesPuertosTransito = null;

	private $accion = null;

	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->lNegocioPaisesPuertosTransito = new PaisesPuertosTransitoLogicaNegocio();
		$this->modeloPaisesPuertosTransito = new PaisesPuertosTransitoModelo();
		set_exception_handler(array(
			$this,
			'manejadorExcepciones'));
	}

	/**
	 * Método de inicio del controlador
	 */
	public function index(){
		$modeloPaisesPuertosTransito = $this->lNegocioPaisesPuertosTransito->buscarPaisesPuertosTransito();
		$this->tablaHtmlPaisesPuertosTransito($modeloPaisesPuertosTransito);
		require APP . 'CertificadoFitosanitario/vistas/listaPaisesPuertosTransitoVista.php';
	}

	/**
	 * Método para desplegar el formulario vacio
	 */
	public function nuevo(){
		$this->accion = "Nuevo PaisesPuertosTransito";
		require APP . 'CertificadoFitosanitario/vistas/formularioPaisesPuertosTransitoVista.php';
	}

	/**
	 * Método para registrar en la base de datos -PaisesPuertosTransito
	 */
	public function guardar(){
		
		$validacion = "";
		$resultado = "";
		$datosPuertoTransito = $_POST;
		
		$datosValidarPaisPuertoTransito = ['id_certificado_fitosanitario' => $datosPuertoTransito['id_certificado_fitosanitario'] 
											, 'id_pais_transito' => $datosPuertoTransito['id_pais_transito']
											, 'id_puerto_transito' => $datosPuertoTransito['id_puerto_transito']
											];
		
		$validarPaisPuertoTransito = $this->lNegocioPaisesPuertosTransito->buscarLista($datosValidarPaisPuertoTransito);
		
		if(!$validarPaisPuertoTransito->count()){
		
			$idPaisPuertoTransito = $this->lNegocioPaisesPuertosTransito->guardar($datosPuertoTransito);
			
			if($idPaisPuertoTransito){
			
				$datosPuertoTransito['id_pais_puerto_transito'] = $idPaisPuertoTransito;
				
				$filaPaisPuertoTransito = $this->generarFilaPaisPuertoTransito($datosPuertoTransito);
						
				echo json_encode(array(
					'validacion' => $validacion,
					'resultado' => $resultado,
					'filaPaisPuertoTransito' => $filaPaisPuertoTransito
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
			$resultado = "No se puede regitrar el mismo país y puerto de tránsito.";
			echo json_encode(array(
				'validacion' => $validacion,
				'resultado' => $resultado
			));
			
		}
		
	}

	/**
	 * Obtenemos los datos del registro seleccionado para editar - Tabla: PaisesPuertosTransito
	 */
	public function editar(){
		$this->accion = "Editar PaisesPuertosTransito";
		$this->modeloPaisesPuertosTransito = $this->lNegocioPaisesPuertosTransito->buscar($_POST["id"]);
		require APP . 'CertificadoFitosanitario/vistas/formularioPaisesPuertosTransitoVista.php';
	}

	/**
	 * Método para borrar un registro en la base de datos - PaisesPuertosTransito
	 */
	public function borrar(){
		$this->lNegocioPaisesPuertosTransito->borrar($_POST['id_pais_puerto_transito']);
	}

	/**
	 * Construye el código HTML para desplegar la lista de - PaisesPuertosTransito
	 */
	public function tablaHtmlPaisesPuertosTransito($tabla){
		{
			$contador = 0;
			foreach ($tabla as $fila){
				$this->itemsFiltrados[] = array(
					'<tr id="' . $fila['id_pais_puerto_transito'] . '"
		  class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'CertificadoFitosanitario\paisespuertostransito"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++ $contador . '</td>
		  <td style="white - space:nowrap; "><b>' . $fila['id_pais_puerto_transito'] . '</b></td>
<td>' . $fila['id_certificado_fitosanitario'] . '</td>
<td>' . $fila['id_pais_transito'] . '</td>
<td>' . $fila['nombre_pais_transito'] . '</td>
</tr>');
		}
		}
	}
	
	/**
	 * Método para generar fila de pais, puerto, transito
	 */
	public function generarFilaPaisPuertoTransito($datos)
	{
		
		$idPaisPuertoTransito = $datos['id_pais_puerto_transito'];
		$nombrePaisTransito = $datos['nombre_pais_transito'];
		$nombrePuertoTransito = $datos['nombre_puerto_transito'];
		$nombreMedioTransporteTransito = $datos['nombre_medio_transporte_transito'];
		
		$filaPaisPuertoTransito = '<tr id="filappt' . $idPaisPuertoTransito . '">
                            <td>' . $nombrePaisTransito . '</td>
                            <td>' . $nombrePuertoTransito . '</td>
                            <td>' . $nombreMedioTransporteTransito . '</td>					
                            <td class="borrar"><button type="button" name="eliminar" class="icono" onclick="fn_eliminarDetallePaisPuertoTransito(' . $idPaisPuertoTransito . '); return false;"/></td>
                       </tr>';
		
		return $filaPaisPuertoTransito;
		
	}

}
