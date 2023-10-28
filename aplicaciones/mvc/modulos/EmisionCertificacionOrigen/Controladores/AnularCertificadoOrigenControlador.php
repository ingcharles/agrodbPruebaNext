<?php
/**
 * Controlador Productos
 *
 * Este archivo controla la lógica del negocio del modelo:  ProductosModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2020-09-18
 * @uses    ProductosControlador
 * @package EmisionCertificacionOrigen
 * @subpackage Controladores
 */
namespace Agrodb\EmisionCertificacionOrigen\Controladores;
use Agrodb\EmisionCertificacionOrigen\Modelos\RegistroProduccionLogicaNegocio;
use Agrodb\EmisionCertificacionOrigen\Modelos\RegistroProduccionModelo;
use Agrodb\EmisionCertificacionOrigen\Modelos\EmisionCertificadoLogicaNegocio;
use Agrodb\EmisionCertificacionOrigen\Modelos\EmisionCertificadoModelo;
use Agrodb\EmisionCertificacionOrigen\Modelos\DetalleEmisionCertificadoLogicaNegocio;
use Agrodb\EmisionCertificacionOrigen\Modelos\DetalleEmisionCertificadoModelo;


class AnularCertificadoOrigenControlador extends BaseControlador 
{

	// use Agrodb\Core\Constantes;
	// use Agrodb\Core\Mensajes;
	private $lNegocioRegistroProduccion = null;
	private $modeloRegistroProduccion = null;
	private $lNegocioEmisionCertificado = null;
	private $modeloEmisionCertificado = null;
	private $lNegocioDetalleEmisionCertificado = null;
	private $modeloDetalleEmisionCertificado = null;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

		$this->lNegocioRegistroProduccion = new RegistroProduccionLogicaNegocio();
		// $this->modeloRegistroProduccion = new RegistroProduccionModelo();
		$this->lNegocioEmisionCertificado = new EmisionCertificadoLogicaNegocio();
		$this->modeloEmisionCertificado = new EmisionCertificadoModelo();
		$this->lNegocioDetalleEmisionCertificado = new DetalleEmisionCertificadoLogicaNegocio();
		$this->modeloDetalleEmisionCertificado = new DetalleEmisionCertificadoModelo();

	
       
        set_exception_handler(array(
            $this,
            'manejadorExcepciones'
        ));
    }

    /**
     * Método de inicio del controlador
     */
    public function index()
    {
		$this->cargarPanelAdministracion();
		 require APP . 'EmisionCertificacionOrigen/vistas/listaCertificadoEmitidos.php';
      
       
    }
	
	/**
	*Obtenemos los datos del registro seleccionado para editar - Tabla: RegistroProduccion
	*/
	public function editar(){
			
			$this->accion = "Anular Certificado de Origen y Movilización"; 
			$this->modeloEmisionCertificado = $this->lNegocioEmisionCertificado->obtenerDatosCertificadoEmitido($_POST["id"]);
			
			
			$arrayDatosGenerales = array();
			$arrayDatosOrigen = array();
			$arrayDatosDestino = array();
			$arrayDatosMovilizacion = array();

					foreach($this->modeloEmisionCertificado as $item){
						 $datosArray = (array) $item->row_to_json;
						 $datosArray1 = (array) $datosArray[0];
						 $hola = json_decode($datosArray1[0]);
						 $datosArray2 = (array) $hola;
						foreach($datosArray2 as $key=>$valor){
							if (str_contains($valor, "ori")){	
								$arrayDatosOrigen[$key] = $this->separaCadena($valor);
							}else if (str_contains($valor, "des")){
								$arrayDatosDestino[$key] = $this->separaCadena($valor);
							}
							else if (str_contains($valor, "mov")){
								$arrayDatosMovilizacion[$key] = $this->separaCadena($valor);
							}else {
								$arrayDatosGenerales[$key] = $valor;
							}
						}
					}
			$this->construirDatosGenerales($arrayDatosGenerales,$_POST["id"]);
     		$this->construirDatosOrigen($arrayDatosOrigen);
    		$this->construirDatosDestino($arrayDatosDestino);
    		$this->construirDatosMovilizacion($arrayDatosMovilizacion);
    		$this->construirDatosDetalleProductosMovilizar($_POST["id"]);
    		$this->construirDatosDetalleSubProductosMovilizar();
			$this->construirDatosAnularCertificado();
			require APP . 'EmisionCertificacionOrigen/vistas/formularioAnularCertificadoOrigenVista.php'; 
		}

		public function separaCadena($dato){
			$separador = "+";
			$separada = explode($separador, $dato);
			return $separada[0];
		}
		/**
		*Método para anular el certificado Emitido
		*/
		public function anularCertificadoEmitido(){

			$arrayParametros = array('identificador'=> $_SESSION['usuario'], 'id_emision_certificado' => $_POST['id_emision'],'motivo' => $_POST['motivo']);
			$this->lNegocioDetalleEmisionCertificado->inactivarDetalleEmisionCertificado($arrayParametros);
			$this->lNegocioEmisionCertificado->inactivarCertificado($arrayParametros);
			
		}

    /**
	* Construye el código HTML para desplegar la lista de - RegistroProduccion
	*/
	 public function tablaHtmlEmisionCertificados($tabla) {
	{
		$contador = 0;
		foreach ($tabla as $fila) {
			$this->itemsFiltrados[] = array(
				'<tr id="' . $fila['id_emision_certificado'] .'"	
				class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'EmisionCertificacionOrigen\anularCertificadoOrigen"
				data-opcion="editar" ondragstart="drag(event)" draggable="true"
				data-destino="detalleItem">
				<td>' . ++$contador . '</td>
				<td style="white - space:nowrap; "><b>' . $fila['fecha_creacion'] . '</b></td>
				<td>' . $fila['nombre_lugar'] . '</td>
				<td>' . $fila['numero_certificado'] . '</td>
				<td>' . $fila['tipo_especie'] . '</td>
				</tr>');
				
			  }
	
		}
		
	
	}
  
    
    /**
     * Construye el código HTML para desplegar panel de busqueda para los reportes
     */

	public function cargarPanelAdministracion()
	{
		
		$this->panelBusquedaAdministrador = '<table class="filtro" style="width: 100%;">
			<tbody>
			
				<tr  style="width: 100%;">
					<td  style="align : left"><label>*Provincia:</label> </td>
						<td>
						<input id="provincia" type="text" name="provincia" value="' . $_SESSION['nombreProvincia'] . '" readonly>
							
						</td>
				</tr>
				<tr class="tecnico">
					<td><label>*N° Certificado:</label> </td>
						<td>
							<input id="numeroCertificado" type="text" name="numeroCertificado" value="" >
						</td>
				</tr>
				
				<tr>
					<td class="col-sm-6">
						Los campos con * son obligatorios.
					</td> 
					<td class="col-sm-6">
						<button type="button" id="btnFiltrar">Consultar</button>
					</td> 
				</tr>
			</tbody>
		</table>';
	}

	//funcion para listar todos los certificados emitidos por provincia
	public function listarCertificadoEmitidos()
	{
		
		$estado = '';
		$mensaje = '';
		$contenido = '';

		$provincia = $_POST['provincia'];
		$numero_certificado = $_POST['numero_certificado'];
		

		$arrayParametros = array(
			'provincia' => $provincia,
			'numero_certificado' => $numero_certificado ,
		);

		$modeloEmisionCertificado = $this->lNegocioEmisionCertificado->listarCertificadosEmitidos($arrayParametros);
		
		if($modeloEmisionCertificado->count() != 0){
			$this->tablaHtmlEmisionCertificados($modeloEmisionCertificado);
			$contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
			$estado = 'EXITO';
		}else{
			$estado = 'FALLO';
			$mensaje = 'No se encontraron registros...!';
		}
		

		echo json_encode(array(
			'estado' => $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido
		));
	}

	public function construirDatosGenerales($arrayDatosGenerales,$id){

		$this->contenidoDatosGenerales ='<fieldset id="centroFaenamiento">
											<legend>Datos Generales</legend>
											<input type="hidden" id ="id_emision" name="id_emision"  value="'.$id.'" "/>				
											<div data-linea="1">
												<label for="provincia">Lugar de Emisión: </label>
												' . $arrayDatosGenerales['provincia_origen_general'] . '
											</div>				
											<div data-linea="1">
												<label for="sitio">N° Certificado: </label>
												' . $arrayDatosGenerales['numero_certificado_general'] . '
											</div>				
											<div data-linea="2">
												<label for="area">Fecha Emisión: </label>
												' . $arrayDatosGenerales['fecha_emision_general'] . '
											</div>
											<div data-linea="2">
												<label for="area">Fecha Vigencia: </label>
												' . $arrayDatosGenerales['fecha_vigencia']  . '
											</div>					
										</fieldset >';
		

		
		return $this->contenidoDatosGenerales;
	}

	public function construirDatosOrigen($arrayDatosOrigen){

			$this->contenidoDatosOrigen ='<fieldset id="centroFaenamiento">
											<legend>Datos Origen</legend>				
											<div data-linea="1">
													<label for="provincia">Identificación CF: </label>
													'.$arrayDatosOrigen['identificador_operador'].'
											</div>				
											<div data-linea="2">
												<label for="sitio">Nombre CF: </label>
												'.$arrayDatosOrigen['razon_social_origen'].'
											</div>				
											<div data-linea="3">
												<label for="area">Nombre Sitio: </label>
												'.$arrayDatosOrigen['nombre_sitio'].'
											</div>	
											<div data-linea="3">
												<label for="area">Provincia: </label>
												'.$arrayDatosOrigen['provincia_origen'].'
											</div>	
											<div data-linea="4">
												<label for="area">Cantón: </label>
												'.$arrayDatosOrigen['canton_origen'].'
											</div>
											<div data-linea="4">
												<label for="area">Parroquia: </label>
												'.$arrayDatosOrigen['parroquia_origen'].'
											</div>
											<div data-linea="3">
												<label for="area">Dirección: </label>
												'.$arrayDatosOrigen['direccion_origen'].'
											</div>					
										</fieldset >';
		return $this->contenidoDatosOrigen;
	}

	public function construirDatosDestino($arrayDatosDestino){
		
			$this->contenidoDatosDestino ='<fieldset id="centroFaenamiento">
											<legend>Datos Destino</legend>				
											<div data-linea="1">
												<label for="provincia">Identificación del Destino: </label>
												'.$arrayDatosDestino['identificador_destino'].'
											</div>				
											<div data-linea="2">
												<label for="sitio">Nombre del Destino: </label>
												'.$arrayDatosDestino['razon_social_destino'].'
											</div>				
											<div data-linea="3">
												<label for="area">Provincia: </label>
												'.$arrayDatosDestino['provincia_des'].'
											</div>	
											<div data-linea="3">
												<label for="area">Cantón: </label>
												'.$arrayDatosDestino['canton_des'].'
											</div>	
											<div data-linea="4">
												<label for="area">Parroquia: </label>
												'.$arrayDatosDestino['parroquia_des'].'
											</div>
											<div data-linea="4">
												<label for="area">Dirección: </label>
												'.$arrayDatosDestino['direccion_destino'].'
											</div>	
											<div data-linea="5">
												<label for="area">Tipo de Producto a Movilizar: </label>
												'.$arrayDatosDestino['tipo_producto_movilizar_canal'].'
											</div>					
										</fieldset >';
		return $this->contenidoDatosDestino;
	}

	public function construirDatosMovilizacion($arrayDatosMovilizacion){
		
			$this->contenidoDatosMovilizacion ='<fieldset id="centroFaenamiento">
											<legend>Datos Movilización</legend>				
											<div data-linea="1">
												<label for="provincia">Identificación del Medio de Transporte: </label>
												'.$arrayDatosMovilizacion['identificador_movilizacion'].'
											</div>				
											<div data-linea="2">
												<label for="sitio">Nombre del Medio de Transporte: </label>
												'.$arrayDatosMovilizacion['nombremovilizar'].'
											</div>				
											<div data-linea="3">
												<label for="area">Placa/Caract. Contenedor: </label>
												'.$arrayDatosMovilizacion['placa_vehiculo'].'
											</div>					
										</fieldset >';
		return $this->contenidoDatosMovilizacion;
	}

	public function construirDatosDetalleProductosMovilizar($idEmisionCertificado){
		
		$this->contenidoDatosDetalleProductosMovilizar ='<fieldset id="centroFaenamiento">
											<legend>Detalle de Productos a Movilizar</legend>				
											'.$this->listarProductos($idEmisionCertificado).'					
										</fieldset >';
		return $this->contenidoDatosDetalleProductosMovilizar;
	}
	public function construirDatosDetalleSubProductosMovilizar(){
		
		$this->contenidoDatosDetalleSubProductosMovilizar ='<fieldset id="centroFaenamiento">
											<legend>Detalle de Subproductos a Movilizar</legend>				
											
																
										</fieldset >';
		return $this->contenidoDatosDetalleSubProductosMovilizar;
	}

	public function construirDatosAnularCertificado(){
		
		$this->contenidoDatosAnularCertificado ='<fieldset id="centroFaenamiento">
											<legend>Anular Certificado de Origen y Movilización</legend>				
											<div data-linea="1">
												<label for="area">Motivo de Anulación: </label>
												<select id="idEstadoCertificado" name="id_estado_certificado" style="width: 100%;">
													<option value="">Seleccione....</option>
													<option value="1">Error Humano</option>
												</select>
											</div>	
											<div data-linea="2" >
												<label for="motico">Descripción Anulación: </label>
													</div>
													<textarea id="text_motivo" onKeyUp="contadorPalabrasInput(this)" name="motivo" rows="5" cols="128" maxlength="128" placeholder=" Escriba aqui una descripción breve de la eliminación..."></textarea>
													<div id="textarea_feedback">
											</div>
																
										</fieldset >';
		return $this->contenidoDatosAnularCertificado;
	}
	

	public function listarProductos($idEmisionCertificado){
		$consulta= $this->lNegocioEmisionCertificado->listaProductosemisionCertificado($idEmisionCertificado);
	    $html=$datos='';
	    if($consulta->count()){
	        $contador=0;
	        foreach ($consulta as $item) {
	            $datos .= '<tr>';
	            $datos .= '<td>'.++$contador.'</td>';
	            $datos .= '<td>'.$item->fecha_produccion.'</td>';
	            $datos .= '<td>'.$item->tipo_especie.'</td>';
	            $datos .= '<td align="center">'.$item->codigo_canal.'</td>';
	            $datos .= '<td align="center">'.$item->tipo_movilizacion_canal.'</td>';
	            $datos .= '</tr>';
	        }
	        $html = '
        				<table style="width:100%">
        					<thead><tr>
        						<th>#</th>
        						<th>Fecha faenamiento</th>
        						<th>Especie</th>
                                <th>Código Canal</th>
                                <th>tipo Movilización</th>
                               
        						</tr></thead>
        					<tbody>'.$datos.'</tbody>
        				</table>';
	    }
	    return $html;
	}

	public function listarSubProductos($idEmisionCertificado){
		$consulta= $this->lNegocioEmisionCertificado->listaSubproductosemisionCertificado($idEmisionCertificado);
	    $html=$datos='';
	    if($consulta->count()){
	        $contador=0;
	        foreach ($consulta as $item) {
	            $datos .= '<tr>';
	            $datos .= '<td>'.++$contador.'</td>';
	            $datos .= '<td>'.$item->fecha_produccion.'</td>';
	            $datos .= '<td>'.$item->tipo_especie.'</td>';
	            $datos .= '<td align="center">'.$item->subproductol.'</td>';
	            $datos .= '<td align="center">'.$item->lote_movilizar.'</td>';
	            $datos .= '<td align="center">'.$item->cantidad_movilizar.'</td>';
	            $datos .= '</tr>';
	        }
	        $html = '
        				<table style="width:100%">
        					<thead><tr>
        						<th>#</th>
        						<th>Fecha faenamiento</th>
        						<th>Especie</th>
                                <th>Subproductos</th>
                                <th>Lote</th>
                                <th>Cantidad</th>
        						</tr></thead>
        					<tbody>'.$datos.'</tbody>
        				</table>';
	    }
	    return $html;
	}
	

}