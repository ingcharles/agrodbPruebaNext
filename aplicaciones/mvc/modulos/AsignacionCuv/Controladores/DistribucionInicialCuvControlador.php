<?php
 /**
 * Controlador DistribucionInicialCuv
 *
 * Este archivo controla la lógica del negocio del modelo:  DistribucionInicialCuvModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2023-03-21
 * @uses    DistribucionInicialCuvControlador
 * @package AsignacionCuv
 * @subpackage Controladores
 */
 namespace Agrodb\AsignacionCuv\Controladores;
 use Agrodb\AsignacionCuv\Modelos\DistribucionInicialCuvLogicaNegocio;
 use Agrodb\AsignacionCuv\Modelos\DistribucionInicialCuvModelo;
 use Agrodb\Catalogos\Modelos\LocalizacionLogicaNegocio;
 use Agrodb\Catalogos\Modelos\LocalizacionModelo;
 use Agrodb\Core\Constantes;
 use Agrodb\Core\Mensajes;

class DistribucionInicialCuvControlador extends BaseControlador 
{
	     private $lNegocioLocalizacion = null;
		 private $modeloLocalizacion = null;
		 private $lNegocioDistribucionInicialCuv = null;
		 private $modeloDistribucionInicialCuv = null;
		 private $accion = null;
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioLocalizacion = new LocalizacionLogicaNegocio();
		 $this->lNegocioDistribucionInicialCuv = new DistribucionInicialCuvLogicaNegocio();
		 $this->modeloDistribucionInicialCuv = new DistribucionInicialCuvModelo();
		 $this->modeloLocalizacion = new LocalizacionModelo();
		 set_exception_handler(array($this, 'manejadorExcepciones'));
		}	/**
		* Método de inicio del controlador
		*/
		public function index()
		{
		$this->cargarPanelAdministracion();
		$modeloDistribucionInicialCuv = $this->lNegocioDistribucionInicialCuv->buscarDistribucionInicialCuv();
		$this->tablaHtmlDistribucionInicialCuv($modeloDistribucionInicialCuv);
		require APP . 'AsignacionCuv/vistas/listaDistribucionInicialCuvVista.php';
		}	/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{
		 $this->accion = "Nuevo DistribucionInicialCuv"; 
		 require APP . 'AsignacionCuv/vistas/formularioDistribucionInicialCuvVista.php';
		}	/**
		* Método para registrar en la base de datos -DistribucionInicialCuv
		*/
		public function guardar()
		{
		  $this->modeloLocalizacion = $this->lNegocioLocalizacion->buscar($_POST['id_provincia']);
		  $_POST['provincia'] = $this->modeloLocalizacion->getNombre();
		  $_POST['identificador'] = $_SESSION["usuario"];
		  $this->lNegocioDistribucionInicialCuv->guardar($_POST);
		}	/**
		* Método para registrar en la base de datos -DistribucionInicialCuv
		*/

		public function guardarListadoSecuencial()
		{
			$_POST['array_cuv'] = json_decode($_POST['array_cuv'], true);
			foreach ($_POST['array_cuv'] as $array) {
				$this->modeloLocalizacion = $this->lNegocioLocalizacion->buscar($array['provincia']);
				$arrayParametros = [
					'id_provincia' => $this->modeloLocalizacion->getIdLocalizacion(),
					'provincia' => $this->modeloLocalizacion->getNombre(),
					'anio' => $array['anio'],
					'cantidad' => $array['cantidad'],
					'prefijo_cuv_numerico' => $array['prefijo'],
					'id_distribucion_inicial_cuv' => '',
					'siglas' => $_POST['siglas'],
					'estado' => 1,
					'identificador' => $_SESSION["usuario"],
					'fecha_creacion' => date("Y-m-d h:m:s"),
				];
				$valorCuv  = $this->lNegocioDistribucionInicialCuv->ultimoCodigoCUVFin($arrayParametros);
				if (count($valorCuv) > 0) {
					echo "Hay registros";
					foreach ($valorCuv as $fila) {
						$last_cuv_fin = $fila['codigo_cuv_fin'];
						$last_cuv_number = (int)substr($last_cuv_fin, -Constantes::NUMERO_CEROS);
						$codigo_cuv_inicio = str_pad($last_cuv_number + 1, Constantes::NUMERO_CEROS, '0', STR_PAD_LEFT);
						$codigo_cuv_fin = str_pad($last_cuv_number + $array['cantidad'], Constantes::NUMERO_CEROS, '0', STR_PAD_LEFT);
						$arrayParametros['codigo_cuv_inicio'] = $codigo_cuv_inicio;
						$arrayParametros['codigo_cuv_fin'] = $codigo_cuv_fin;
					}
				} else {
					echo "No hay registros";
					$codigo_cuv_inicio = str_pad(1, Constantes::NUMERO_CEROS, '0', STR_PAD_LEFT);
					$codigo_cuv_fin = str_pad($array['cantidad'], Constantes::NUMERO_CEROS, '0', STR_PAD_LEFT);
					$arrayParametros['codigo_cuv_inicio'] = $codigo_cuv_inicio;
					$arrayParametros['codigo_cuv_fin'] = $codigo_cuv_fin;
				}
				$this->lNegocioDistribucionInicialCuv->guardar($arrayParametros);
			}
		}
		
		public function guardarListado()
		{
			$_POST['array_cuv'] = json_decode($_POST['array_cuv'], true);
			foreach ($_POST['array_cuv'] as $array) {
				$this->modeloLocalizacion = $this->lNegocioLocalizacion->buscar($array['provincia']);
				$arrayParametros = [
					'id_provincia' => $this->modeloLocalizacion->getIdLocalizacion(),
					'provincia' => $this->modeloLocalizacion->getNombre(),
					'anio' => $array['anio'],
					'cantidad' => $array['cantidad'],
					'prefijo_cuv_numerico' => $array['prefijo'],
					'color' => $array['color'],
					'id_distribucion_inicial_cuv' => '',
					'siglas' => $_POST['siglas'],
					'estado' => 1,
					'identificador' => $_SESSION["usuario"],
					'fecha_creacion' => date("Y-m-d h:m:s"),
				];
				$valorCuv = $this->lNegocioDistribucionInicialCuv->ultimoValorCUVFin($arrayParametros);
				if (count($valorCuv) > 0) {
					echo "Hay registros";
					foreach ($valorCuv as $fila) {
						$last_cuv_fin = $fila['codigo_cuv_fin'];
						$last_cuv_number = (int)substr($last_cuv_fin, -7);
						$codigo_cuv_inicio = str_pad($last_cuv_number + 1, 7, '0', STR_PAD_LEFT);
						$codigo_cuv_fin = str_pad($last_cuv_number + $array['cantidad'], 7, '0', STR_PAD_LEFT);
						$arrayParametros['codigo_cuv_inicio'] = $codigo_cuv_inicio;
						$arrayParametros['codigo_cuv_fin'] = $codigo_cuv_fin;
					}
				} else {
					echo "No hay registros";
					$codigo_cuv_inicio = str_pad(1, 7, '0', STR_PAD_LEFT);
					$codigo_cuv_fin = str_pad($array['cantidad'], 7, '0', STR_PAD_LEFT);
					$arrayParametros['codigo_cuv_inicio'] = $codigo_cuv_inicio;
					$arrayParametros['codigo_cuv_fin'] = $codigo_cuv_fin;
				}
				$this->lNegocioDistribucionInicialCuv->guardar($arrayParametros);
			}
		}/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: DistribucionInicialCuv
		*/
		public function editar()
		{
		 $this->accion = "Distribución Inicial De CUV"; 
		 $this->modeloDistribucionInicialCuv = $this->lNegocioDistribucionInicialCuv->buscar($_POST["id"]);
		 //require APP . 'AsignacionCuv/vistas/formularioDistribucionInicialCuvVista.php';
		 require APP . 'AsignacionCuv/vistas/formularioDistribucionCuvVista.php';
		}	/**
		* Método para borrar un registro en la base de datos - DistribucionInicialCuv
		*/
		public function borrar()
		{
		  $this->lNegocioDistribucionInicialCuv->borrar($_POST['elementos']);
		}	/**
		* Construye el código HTML para desplegar la lista de - DistribucionInicialCuv
		*/
		 public function tablaHtmlDistribucionInicialCuv($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
		   $this->itemsFiltrados[] = array(
		  '<tr id="' . $fila['id_distribucion_inicial_cuv'] . '"
		  class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'AsignacionCuv\DistribucionInicialCuv"
		  data-opcion="editar" ondragstart="drag(event)" draggable="true"
		  data-destino="detalleItem">
		  <td>' . ++$contador . '</td>
		  <td style="white - space:nowrap; "><b>'. date('d-m-Y', strtotime($fila['fecha_creacion'])) . '</b></td>
<td>'
		  . $fila['provincia'] . '</td>
<td>' . $fila['anio']
		  . '</td>
<td>' . $fila['siglas']."-". $fila['anio']."-" .$fila['prefijo_cuv_numerico']."-".$fila['codigo_cuv_inicio'].  '</td>
<td>' . $fila['siglas']."-". $fila['anio']."-" .$fila['prefijo_cuv_numerico']."-".$fila['codigo_cuv_fin'].  '</td>
<td>' . $fila['cantidad'] . '</td>
</tr>');
		}
		}
	}
	public function ultimoCodigoCUVFin()
	{
		$ultimoCodigoCUVFin = $this->lNegocioDistribucionInicialCuv->ultimoCodigoCUVFin();
		return $ultimoCodigoCUVFin;
	}
	public function calcularCuv(){
		$mensaje = "";
		$validacion = "";
		$resultado = "";
		$cantidad = $_POST['cantidad'];
		$anio = $_POST['anio'];
		$prefijo = $_POST['prefijo'];
		$arrayParametros = [
            'anio' => $anio,
            'prefijo' => $prefijo
        ];
		if ($prefijo != "" && $cantidad != "" && $anio != "") {
			# Obtener ultimo valor del CUV fin en BDD
			$valor = $this->lNegocioDistribucionInicialCuv->ultimoValorCUVFin($arrayParametros);
			if($valor->count()){
				foreach ($valor as $fila) {
					//echo $fila['codigo_cuv_fin'];
					$resultado = $fila['codigo_cuv_fin'];
					$mensaje = 'Se encontro el valor';
					$validacion = 'Exito'; 
				}
			} else {
				$valor = [
					'codigo_cuv_fin' => '1',
				];
				$resultado = $valor;
				$mensaje = 'Se inicio una nueva numeración.';
				$validacion = 'Crea';
			}
		}else{
			$mensaje = 'Por favor ingresa un prefijo o un año.';
			$validacion = 'Fallo';
		}
		echo json_encode(array(
            'mensaje' => $mensaje,
            'validacion' => $validacion,
            'resultado' => $resultado
        ));
	}
	/**
		* Método para registrar en la base de datos -DistribucionInicialCuv
		*/
		public function obtenerProvincia()
		{
			$id_provincia = (int)$_POST['idProvincia'];
			$valor = $this->modeloLocalizacion = $this->lNegocioLocalizacion->buscar($id_provincia);
		if ($valor->getIdLocalizacion() != null) {
			$resultado = array(
				'idProvincia' => $valor->getIdLocalizacion(),
				'nombreProvincia' => $valor->getNombre()
			);
			$mensaje = 'Se encontro el valor';
			$validacion = 'Exito'; 
		}
			echo json_encode(array(
				'mensaje' => $mensaje,
				'validacion' => $validacion,
				'resultado' => $resultado
			));
		}
	/**
		* Método para registrar en la base de datos -DistribucionInicialCuv
		*/
		public function obtenerCantidad()
		{
			$provinciaNombre = $_POST['nombre_provincia'];
			$anio = $_POST['anio'];
			$arrayParametros = [
				'anio' => $anio,
				'provinciaNombre' => $provinciaNombre
			];
			$valor = $this->modeloLocalizacion = $this->lNegocioDistribucionInicialCuv->buscarXanioYNombreProvincia($arrayParametros);
			$conteo = $valor->count();
			if ($conteo>0) {
				echo json_encode(
					array(
						'validacion' => 'Exito',
						'mensaje' => 'Se encontro el valor',
						'resultado' => $conteo
					)
				);
			} else {
				echo json_encode(
					array(
						'validacion' => 'Fallo',
						'mensaje' => 'No se encontro el valor',
						'resultado' => $conteo
					)
				);
			}
		}

		public function filtroBuscar()
		{
			$id_provincia = isset($_POST['idProvincia']) ? (int)$_POST['idProvincia'] : '';
			$anio = isset($_POST['anio']) ? (int)$_POST['anio'] : '';
			$arrayParametros = [
				'anio' => $anio,
				'id_provincia' => $id_provincia
			];
		
			if ($id_provincia === '' && $anio === '') {
				// Si no se seleccionó ningún valor en los filtros, devolver todos los registros sin filtrar
				$valor = $this->lNegocioDistribucionInicialCuv->buscarXanioYProvincia([]);
			} else {
				// Seleccionar registros con filtros aplicados
				$valor = $this->lNegocioDistribucionInicialCuv->buscarXanioYProvincia($arrayParametros);
			}
		
			if ($valor->count()) {
				$this->tablaHtmlDistribucionInicialCuv($valor);
				$resultado = \Zend\Json\Json::encode($this->itemsFiltrados);
				echo json_encode([
					'validacion' => 'Exito',
					'mensaje' => 'Se encontró el valor',
					'resultado' => $resultado
				]);
			} else {
				echo json_encode([
					'validacion' => 'Fallo',
					'mensaje' => 'No se encontró el valor',
					'resultado' => ''
				]);
			}
		}
		
	public function verificarSolapamientoCuv(){
		$mensaje = "";
		$validacion = "";
		$resultado = "";
		$cantidad = $_POST['cantidad'];
		$anio = $_POST['anio'];
		$prefijo = $_POST['prefijo'];
		$inicio = $_POST['inicio'];
		$fin = $_POST['fin'];
		$arrayParametros = [
            'anio' => $anio,
            'prefijo' => $prefijo,
            'inicio' => $inicio,
            'fin' => $fin,
        ];
		$valor = $this->lNegocioDistribucionInicialCuv->solapamientoCuv($arrayParametros);
		foreach ($valor as $fila) {
			var_dump($fila) ;
			$solapamiento = $fila['solapamiento'];
			if ($solapamiento == 0) {
				// Insertar el nuevo registro en la base de datos
			} else {
				// Mostrar un mensaje de error al usuario
				$provincia = $fila['provincia'];
				$mensaje = "Existe solapamiento de CUV en la provincia: $provincia";
				echo $mensaje;
				$validacion = 'Fallo';
			}
		}
		echo json_encode(array(
            'mensaje' => $mensaje,
            'validacion' => $validacion,
            'resultado' => $resultado
        ));
	}

	    /**
     * Construye el código HTML para desplegar un panel de busqueda de CUV por provincia
     */
    public function cargarPanelAdministracion()
    {
        $this->panelBusquedaAdministrador = '
		<head>
			<title>Buscar provincia</title>
		</head>
		<body>
			<table class="filtro">
				<thead>
					<tr>
						<th>Buscar provincia</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><label for="year">Año:</label></td>
						<td colspan=3>
						<select id="anioFiltro" name= "anioFiltro" >
							' . $this->comboAnios() . '
						</select>
						</td>
					</tr>
					<tr>
						<td><label for="province">Provincia:</label></td>
						<td colspan=3>
						<select id="provinciaFiltro" name= "provinciaFiltro" >
						<option value>Seleccione...</option>
							' . $this->comboProvinciasEc() . '
						</select>
						</td>
					</tr>
					<tr>
						<td colspan="2"><button type="submit" id="btnFiltrar">Buscar</button></td>
					</tr>
				</tbody>
			</table>
		</body>';

        
    }
}