<?php
/**
 * Controlador Firmantes
 *
 * Este archivo controla la lógica del negocio del modelo: FirmantesModelo y Vistas
 *
 * @author AGROCALIDAD
 * @date   2022-07-21
 * @uses FirmantesControlador
 * @package FirmaDocumentos
 * @subpackage Controladores
 */
namespace Agrodb\FirmaDocumentos\Controladores;

use Agrodb\FirmaDocumentos\Modelos\FirmantesLogicaNegocio;
use Agrodb\FirmaDocumentos\Modelos\FirmantesModelo;

use Agrodb\GUath\Modelos\FichaEmpleadoLogicaNegocio;
use Agrodb\GUath\Modelos\FichaEmpleadoModelo;
use Agrodb\Core\Comun;
use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;

class FirmantesControlador extends BaseControlador{

	private $lNegocioFirmantes = null;

	private $modeloFirmantes = null;

	private $accion = null;

	private $datosFirma = null;

	private $clave = null;
	private $lNegocioEmpleados = null;
	private $modeloEmpleados = null;

	protected $key=null;
	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->lNegocioFirmantes = new FirmantesLogicaNegocio();
		$this->modeloFirmantes = new FirmantesModelo();

		$this->lNegocioEmpleados = new FichaEmpleadoLogicaNegocio();
		$this->modeloEmpleados = new FichaEmpleadoModelo();

		set_exception_handler(array(
			$this,
			'manejadorExcepciones'));
	}

	/**
	 * Método de inicio del controlador
	 */
	public function index(){
		$arrayParametros = array('identificador' => $_SESSION['usuario']);
		$modeloFirmantes = $this->lNegocioFirmantes->buscarLista($arrayParametros);
		$this->tablaHtmlFirmantes($modeloFirmantes);
		require APP . 'FirmaDocumentos/vistas/listaFirmantesVista.php';
	}

	/**
	 * Método para desplegar el formulario vacio
	 */
	public function nuevo(){
		$estado = "nuevo";
		$this->datosFirma = $this->construirInformacionFirma($estado);
		$this->accion = "Nuevo Firmantes";
		require APP . 'FirmaDocumentos/vistas/formularioFirmantesVista.php';
	}

	/**
	 * Método para registrar en la base de datos -Firmantes
	 */
	public function guardar(){
		
		$claveEncriptada = null;
		$identificador = $_SESSION['usuario'];
		$claveEncriptada = $this->getClave($identificador);

		$success = null;
		$out_file = APP . FIRMA_CRT . $_SESSION['usuario'] . ".crt";

		$Lla_Cla = $_POST['clave'];
		$x509 = $this->lNegocioFirmantes->getSignData($Lla_Cla);

		//CODIGO PARA VALIDAR OTROS CERTIFICADOS
		$contadorExtras = 0;
		if (isset($x509["validTo_time_t"])) {
			while(date('Y-m-d', $x509['validTo_time_t']) < date("Y-m-d H:i:s"))
			{
				$x509 = $this->lNegocioFirmantes->getSignData($Lla_Cla, $contadorExtras);
				$fechaCad1 = date('Y-m-d', $x509['validTo_time_t']);
				$extension = $x509["extensions"];
				$serial = $x509["subject"];
				if($contadorExtras > 5){
					break;
				}
				$contadorExtras++;
			}
		}

		$validarCertificado = false;
		if (isset($x509["extensions"]) && is_array($x509["extensions"]) && array_key_exists("authorityInfoAccess", $x509["extensions"])) {
			if (isset($x509["subject"]) && is_array($x509["subject"]) && array_key_exists("serialNumber", $x509["subject"])) {
				$validarCertificado = true;
			}
		}

		if($x509==2){
			echo json_encode(array(
		                'estado' => 'errorFirma',
		                'mensaje' => Constantes::ERROR_FIRMA
		            ));
		}
		else{
			$success=array('creacion'=>date('Y-m-d H:i:s', $x509['validFrom_time_t']),'caducidad'=>date('Y-m-d', $x509['validTo_time_t']));
			if(($success['caducidad'] > date("Y-m-d H:i:s")) && $validarCertificado){

				$this->lNegocioFirmantes->convertP12toCrt($claveEncriptada,$Lla_Cla);

				$datosGuardar = array('identificador'=>$identificador, 'ruta_archivo'=>$out_file, 'clave'=>$claveEncriptada, 'fecha_caducidad_certificado'=>$success['caducidad'], 'fecha_creacion'=>$success['creacion'], 'estado'=>'Activo');
				$procesoValidacion = $this->lNegocioFirmantes->guardar($datosGuardar);
				if($procesoValidacion == 0){
					 echo json_encode(array(
		                'estado' => 'guardar',
		                'mensaje' => Constantes::GUARDADO_CON_EXITO
		            ));
				}
				elseif ($procesoValidacion == 1) {
					echo json_encode(array(
		                'estado' => 'actualizar',
		                'mensaje' => Constantes::ACTUALIZAR_FIRMA
		            ));
				}
				else{
					echo json_encode(array(
		                'estado' => 'error',
		                'mensaje' => Constantes::ERROR_GUARDAR
		            ));
				}
			}
			else{
				echo json_encode(array(
		                'estado' => 'caducidad',
		                'mensaje' => Constantes::ERROR_CADUCIDAD_FIRMA
		            ));
			}
		} 
	}

	/**
	 * Obtenemos los datos del registro seleccionado para editar - Tabla: Firmantes
	 */
	public function editar(){
		$this->accion = "Consultar Firmante";
		$estado = "editar";		
		$this->modeloFirmantes = $this->lNegocioFirmantes->buscar($_POST["id"]);
		$this->datosFirma = $this->construirInformacionFirma($estado);
		require APP . 'FirmaDocumentos/vistas/formularioFirmantesVista.php';
	}

	/**
	 * Método para borrar un registro en la base de datos - Firmantes
	 */
	public function borrar(){
		$this->lNegocioFirmantes->borrar($_POST['elementos']);
	}

	/**
	 * Construye el código HTML para desplegar la lista de - Firmantes
	 */
	public function tablaHtmlFirmantes($tabla){
		{
			$contador = 0;
			foreach ($tabla as $fila){
				$this->itemsFiltrados[] = array(
					'<tr id="' . $fila['identificador'] . '"
						  class="item" data-rutaAplicacion="' . URL_MVC_FOLDER . 'FirmaDocumentos\firmantes"
						  data-opcion="editar" ondragstart="drag(event)" draggable="true"
						  data-destino="detalleItem">
					  	<td>' . ++ $contador . '</td>
					  	<td style="white - space:nowrap; "><b>' . $fila['identificador'] . '</b></td>
						<td>' . $_SESSION['usuario'] . '.crt</td>
						<td>' . $fila['fecha_caducidad_certificado'] . '</td>
					</tr>');
			}
		}
	}

	public function getClave($identificador){
		$modeloEmpleados = $this->lNegocioEmpleados->buscar($identificador);
		$clave = strtolower(substr($modeloEmpleados->nombre, 0, 1)) . '_' . strtolower(explode(' ',$modeloEmpleados->apellido)[0]) . '@' . $identificador;
		$comun = new Comun();
		$claveEncriptada = $comun->encriptarClave($identificador, $clave);
		return $claveEncriptada;
	}

	public function uploadFile(){

		$uploadOk = 0;
		if(isset($_POST["submit"])){
			$target_dir = "FirmaDocumentos\archivos\certificados\\";
			$target_file = $target_dir . $_SESSION['usuario'] . '.p12';
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			if ($_FILES["fileToUpload"]["size"] > 500000) {
			  $uploadOk = 0;
			}

			if($imageFileType != "p12" ) {
				  $uploadOk = 0;
			}

			if ($uploadOk == 0) {
			  //echo "Sorry, your file was not uploaded.";
			} else {
			  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			    //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
			  } else {
			    $uploadOk = 0;
			  }
			}

		}
		

		return $uploadOk;
	}

	/**
	 * Método para desplegar el formulario
	 */
	public function construirInformacionFirma($estado){
		$datos = "";

		switch ($estado) {

			case 'nuevo':
				$datos .= '<fieldset>
								<legend>Firmante</legend>				

					        	<div data-linea="1">
									<label for="archivo_firma">Archivo .p12:  </label>
									<input type="hidden" class="rutaArchivo" name="ruta_archivo" value="0"/>
									<input type="file" id="archivoFirma" class="archivo" accept="application/p12"/>
									<div class="estadoCarga">En espera de archivo... (Tamaño máximo'.ini_get('upload_max_filesize').'B)</div>
									<button type="button" id="btnFirma" class="subirArchivo adjunto" data-rutaCarga="aplicaciones/mvc/modulos/FirmaDocumentos/archivos/firmas">Subir archivo</button>
								</div>		

								<div data-linea="2">
									<label for="clave">Clave: </label>
									<input type="password" class="" id="clave" name="clave"
									placeholder="" maxlength="512" />
								</div>	
							</fieldset>
							<div data-linea="3">
								<button type="submit" class="guardar">Guardar</button>
							</div>';
			break;
			case 'editar':
				$datos .= '<fieldset>
							<legend>Firmante</legend>				

							<div data-linea="1">
								<label for="identificador">Identificador: </label>' 
								. $this->modeloFirmantes->getIdentificador() .
							'</div>

							<div data-linea="2">
								<label for="identificador">Fecha creación: </label>' 
								. date('Y-m-d', strtotime($this->modeloFirmantes->getFechaCreacion())) .
							'</div>	

							<div data-linea="3">
								<label for="identificador">Fecha caducidad: </label>' 
								. $this->modeloFirmantes->getFechaCaducidadCertificado() .
							'</div>
							<div data-linea="4">
								<label for="identificador">Certificado: </label>
								<a href="aplicaciones/mvc/modulos/FirmaDocumentos/archivos/certificados/' . $_SESSION['usuario'] . '.crt" download> Descargar certificado </a>
							</div>
						</fieldset>';
			break;
		}

		return $datos;
	}
}
