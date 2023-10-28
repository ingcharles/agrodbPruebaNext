<?php
 /**
 * Controlador HistoriaClinica
 *
 * Este archivo controla la lógica del negocio del modelo:  HistoriaClinicaModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2020-03-16
 * @uses    HistoriaClinicaControlador
 * @package HistoriasClinicas
 * @subpackage Controladores
 */
 namespace Agrodb\HistoriasClinicas\Controladores;
 use Agrodb\HistoriasClinicas\Modelos\HistoriaClinicaLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\HistoriaClinicaModelo;
 use Agrodb\HistoriasClinicas\Modelos\ProcedimientoMedicoLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\ProcedimientoMedicoModelo;
 use Agrodb\HistoriasClinicas\Modelos\TipoProcedimientoMedicoLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\TipoProcedimientoMedicoModelo;
 use Agrodb\HistoriasClinicas\Modelos\SubtipoProcedimientoMedicoLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\SubtipoProcedimientoMedicoModelo;
 /*****************************************************/
 use Agrodb\HistoriasClinicas\Modelos\HistoriaOcupacionalLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\HistoriaOcupacionalModelo;
 use Agrodb\HistoriasClinicas\Modelos\DetalleHistorialOcupacionalLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\DetalleHistorialOcupacionalModelo;
 use Agrodb\HistoriasClinicas\Modelos\AccidentesLaboralesLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\AccidentesLaboralesModelo;
 use Agrodb\HistoriasClinicas\Modelos\CieLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\CieModelo;
 use Agrodb\HistoriasClinicas\Modelos\AntecedentesSaludFamiliarLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\AntecedentesSaludFamiliarModelo;
 use Agrodb\HistoriasClinicas\Modelos\AntecedentesSaludLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\AntecedentesSaludModelo;
 use Agrodb\HistoriasClinicas\Modelos\DetalleAntecedentesSaludLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\DetalleAntecedentesSaludModelo;
 use Agrodb\HistoriasClinicas\Modelos\RevisionOrganosSistemasLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\RevisionOrganosSistemasModelo;
 use Agrodb\HistoriasClinicas\Modelos\DetalleRevisionOrganosSistemasLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\DetalleRevisionOrganosSistemasModelo;
 use Agrodb\HistoriasClinicas\Modelos\InmunizacionLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\InmunizacionModelo;
 use Agrodb\HistoriasClinicas\Modelos\HabitosLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\HabitosModelo;
 use Agrodb\HistoriasClinicas\Modelos\EstiloVidaLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\EstiloVidaModelo;
 use Agrodb\HistoriasClinicas\Modelos\ExamenFisicoLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\ExamenFisicoModelo;
 use Agrodb\HistoriasClinicas\Modelos\ExamenesClinicosLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\ExamenesClinicosModelo;
 use Agrodb\HistoriasClinicas\Modelos\DetalleExamenesClinicosLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\DetalleExamenesClinicosModelo;
 use Complex\Exception;
 use Agrodb\HistoriasClinicas\Modelos\AdjuntosHistoriaClinicaLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\AdjuntosHistoriaClinicaModelo;
 use Agrodb\HistoriasClinicas\Modelos\ExamenParaclinicosLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\ExamenParaclinicosModelo;
 use Agrodb\HistoriasClinicas\Modelos\DetalleExamenParaclinicosLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\DetalleExamenParaclinicosModelo;
 use Agrodb\HistoriasClinicas\Modelos\ImpresionDiagnosticaLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\ImpresionDiagnosticaModelo;
 use Agrodb\HistoriasClinicas\Modelos\AusentismoMedicoLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\AusentismoMedicoModelo;
 use Agrodb\HistoriasClinicas\Modelos\ElementoProteccionLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\ElementoProteccionModelo;
 use Agrodb\HistoriasClinicas\Modelos\EnfermedadProfesionalLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\EnfermedadProfesionalModelo;
 use Agrodb\HistoriasClinicas\Modelos\RecomendacionesLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\RecomendacionesModelo;
 use Agrodb\HistoriasClinicas\Modelos\EvaluacionPrimariaLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\EvaluacionPrimariaModelo;
 use Agrodb\HistoriasClinicas\Modelos\DetalleEvaluacionPrimariaLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\DetalleEvaluacionPrimariaModelo;
 use Agrodb\HistoriasClinicas\Modelos\LogLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\LogModelo;
 use Agrodb\Core\JasperReport;

 use Agrodb\Core\Excepciones\GuardarExcepcion;
 use Agrodb\GUath\Modelos\DatosContratoLogicaNegocio;
 use Agrodb\GUath\Modelos\DatosContratoModelo;
 use Agrodb\GUath\Modelos\FichaEmpleadoLogicaNegocio;
 use Agrodb\GUath\Modelos\FichaEmpleadoModelo;
 use Agrodb\HistoriasClinicas\Modelos\ExamenRealizadoLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\ExamenRealizadoModelo;
 use Agrodb\HistoriasClinicas\Modelos\MetodoPlanificacionLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\MetodoPlanificacionModelo;

 use Agrodb\HistoriasClinicas\Modelos\FactorRiesgoLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\FactorRiesgoModelo;
 use Agrodb\HistoriasClinicas\Modelos\DetalleFactorRiesgoLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\DetalleFactorRiesgoModelo;

 use Agrodb\HistoriasClinicas\Modelos\ActividadEnfermedadLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\ActividadEnfermedadModelo;

 use Agrodb\HistoriasClinicas\Modelos\CategoriaSubtipoProcedimientoLogicaNegocio;
 use Agrodb\HistoriasClinicas\Modelos\CategoriaSubtipoProcedimientoModelo;
 use TCPDI;
 use Agrodb\Core\Comun;

class HistoriaClinicaControlador extends BaseControlador 
{

		 private $lNegocioHistoriaClinica = null;
		 private $modeloHistoriaClinica = null;
		 private $lNegocioProcedimientoMedico = null;
		 private $modeloProcedimientoMedico = null;
		 private $lNegocioTipoProcedimientoMedico = null;
		 private $modeloTipoProcedimientoMedico = null;
		 private $lNegocioSubtipoProcedimientoMedico = null;
		 private $modeloSubtipoProcedimientoMedico = null;
		 /*****************************************************/
		 private $lNegocioHistoriaOcupacional = null;
		 private $modeloHistoriaOcupacional = null;
		 private $lNegocioDetalleHistorialOcupacional = null;
		 private $modeloDetalleHistorialOcupacional = null;
		 private $lNegocioAccidentesLaborales = null;
		 private $modeloAccidentesLaborales = null;
		 private $lNegocioCie = null;
		 private $modeloCie = null;
		 private $lNegocioAntecedentesSaludFamiliar = null;
		 private $modeloAntecedentesSaludFamiliar = null;
		 private $lNegocioAntecedentesSalud = null;
		 private $modeloAntecedentesSalud = null;
		 private $lNegocioDetalleAntecedentesSalud = null;
		 private $modeloDetalleAntecedentesSalud = null;
		 private $lNegocioRevisionOrganosSistemas = null;
		 private $modeloRevisionOrganosSistemas = null;
		 private $lNegocioDetalleRevisionOrganosSistemas = null;
		 private $modeloDetalleRevisionOrganosSistemas = null;
		 private $lNegocioInmunizacion = null;
		 private $modeloInmunizacion = null;
		 private $lNegocioHabitos = null;
		 private $modeloHabitos = null;
		 private $lNegocioEstiloVida = null;
		 private $modeloEstiloVidad = null;
		 private $lNegocioExamenFisico = null;
		 private $modeloExamenFisico = null;
		 private $lNegocioExamenesClinicos = null;
		 private $modeloExamenesClinicos = null;
		 private $lNegocioDetalleExamenesClinicos = null;
		 private $modeloDetalleExamenesClinicos = null;
		 private $lNegocioAdjuntosHistoriaClinica = null;
		 private $modeloAdjuntosHistoriaClinica = null;
		 private $lNegocioExamenParaclinicos = null;
		 private $modeloExamenParaclinicos = null;
		 private $lNegocioDetalleExamenParaclinicos = null;
		 private $modeloDetalleExamenParaclinicos = null;
		 private $lNegocioImpresionDiagnostica = null;
		 private $modeloImpresionDiagnostica = null;
		 //**********************************************
		 private $lNegocioAusentismoMedico = null;
		 private $modeloAusentismoMedico = null;
		 private $lNegocioElementoProteccion = null;
		 private $modeloElementoProteccion = null;
		 private $lNegocioEnfermedadProfesional = null;
		 private $modeloEnfermedadProfesional = null;
		 private $lNegocioRecomendaciones = null;
		 private $modeloRecomendaciones = null;
		 private $lNegocioEvaluacionPrimaria = null;
		 private $modeloEvaluacionPrimaria = null;
		 private $lNegocioDetalleEvaluacionPrimaria = null;
		 private $modeloDetalleEvaluacionPrimaria = null;
		 private $lNegocioLog = null;
		 private $modeloLog = null;
		 /*****************************************************/
		 private $accion = null;
		 private $idHistorialClinica = null;
		 private $estado = 'nuevo';
		 private $historico = null;
		 private $adjuntoHistoriaClinica = null;
		 protected $divUsuarioEmpresa = null;
		 private $lNegocioDatosContrato= null;
		 private $modeloDatosContrato = null;
		 private $lNegocioFichaEmpleado= null;
		 private $modeloFichaEmpleado = null;

		 private $lNegocioExamenRealizado= null;
		 private $modeloExamenRealizado = null;

		 private $lNegocioMetodoPlanificacion= null;
		 private $modeloMetodoPlanificacion = null;

		 private $lNegocioFactorRiesgo= null;
		 private $modeloFactorRiesgo = null;
		 private $lNegocioDetalleFactorRiesgo= null;
		 private $modeloDetalleFactorRiesgo = null;

		 private $lNegocioActividadEnfermedad= null;
		 private $modeloActividadEnfermedad = null;

		 private $lNegocioCategoriaSubtipoProcedimiento= null;
		 private $modeloCategoriaSubtipoProcedimiento = null;
		 
		 private $contenidoReporte = null;
		 private $sexo = '';
	/**
		* Constructor
		*/
		 function __construct()
		{
		parent::__construct();
		 $this->lNegocioHistoriaClinica = new HistoriaClinicaLogicaNegocio();
		 $this->modeloHistoriaClinica = new HistoriaClinicaModelo();
		 $this->lNegocioProcedimientoMedico = new ProcedimientoMedicoLogicaNegocio();
		 $this->modeloProcedimientoMedico = new ProcedimientoMedicoModelo();
		 $this->lNegocioTipoProcedimientoMedico = new TipoProcedimientoMedicoLogicaNegocio();
		 $this->modeloTipoProcedimientoMedico = new TipoProcedimientoMedicoModelo();
		 $this->lNegocioSubtipoProcedimientoMedico = new SubtipoProcedimientoMedicoLogicaNegocio();
		 $this->modeloSubtipoProcedimientoMedico = new SubtipoProcedimientoMedicoModelo();
		 /*****************************************************/
		 $this->lNegocioHistoriaOcupacional = new HistoriaOcupacionalLogicaNegocio();
		 $this->modeloHistoriaOcupacional = new HistoriaOcupacionalModelo();
		 $this->lNegocioDetalleHistorialOcupacional = new DetalleHistorialOcupacionalLogicaNegocio();
		 $this->modeloDetalleHistorialOcupacional = new DetalleHistorialOcupacionalModelo();
		 $this->lNegocioAccidentesLaborales = new AccidentesLaboralesLogicaNegocio();
		 $this->modeloAccidentesLaborales = new AccidentesLaboralesModelo();
		 $this->lNegocioCie = new CieLogicaNegocio();
		 $this->modeloCie = new CieModelo();
		 $this->lNegocioAntecedentesSaludFamiliar= new AntecedentesSaludFamiliarLogicaNegocio();
		 $this->modeloAntecedentesSaludFamiliar = new AntecedentesSaludFamiliarModelo();
		 $this->lNegocioAntecedentesSalud= new AntecedentesSaludLogicaNegocio();
		 $this->modeloAntecedentesSalud = new AntecedentesSaludModelo();
		 $this->lNegocioDetalleAntecedentesSalud= new DetalleAntecedentesSaludLogicaNegocio();
		 $this->modeloDetalleAntecedentesSalud = new DetalleAntecedentesSaludModelo();
		 $this->lNegocioRevisionOrganosSistemas= new RevisionOrganosSistemasLogicaNegocio();
		 $this->modeloRevisionOrganosSistemas = new RevisionOrganosSistemasModelo();
		 $this->lNegocioDetalleRevisionOrganosSistemas= new DetalleRevisionOrganosSistemasLogicaNegocio();
		 $this->modeloDetalleRevisionOrganosSistemas = new DetalleRevisionOrganosSistemasModelo();
		 $this->lNegocioInmunizacion= new InmunizacionLogicaNegocio();
		 $this->modeloInmunizacion = new InmunizacionModelo();
		 $this->lNegocioHabitos= new HabitosLogicaNegocio();
		 $this->modeloHabitos = new HabitosModelo();
		 $this->lNegocioEstiloVida= new EstiloVidaLogicaNegocio();
		 $this->modeloEstiloVidad = new EstiloVidaModelo();
		 $this->lNegocioExamenFisico= new ExamenFisicoLogicaNegocio();
		 $this->modeloExamenFisico = new ExamenFisicoModelo();
		 $this->lNegocioExamenesClinicos= new ExamenesClinicosLogicaNegocio();
		 $this->modeloExamenesClinicos = new ExamenesClinicosModelo();
		 $this->lNegocioDetalleExamenesClinicos= new DetalleExamenesClinicosLogicaNegocio();
		 $this->modeloDetalleExamenesClinicos = new DetalleExamenesClinicosModelo();
		 $this->lNegocioAdjuntosHistoriaClinica= new AdjuntosHistoriaClinicaLogicaNegocio();
		 $this->modeloAdjuntosHistoriaClinica = new AdjuntosHistoriaClinicaModelo();
		 $this->lNegocioExamenParaclinicos= new ExamenParaclinicosLogicaNegocio();
		 $this->modeloExamenParaclinicos = new ExamenParaclinicosModelo();
		 $this->lNegocioDetalleExamenParaclinicos= new DetalleExamenParaclinicosLogicaNegocio();
		 $this->modeloDetalleExamenParaclinicos = new DetalleExamenParaclinicosModelo();
		 $this->lNegocioImpresionDiagnostica = new ImpresionDiagnosticaLogicaNegocio();
		 $this->modeloImpresionDiagnostica = new ImpresionDiagnosticaModelo();
		 //***********************************
		 $this->lNegocioAusentismoMedico = new AusentismoMedicoLogicaNegocio();
		 $this->modeloAusentismoMedico = new AusentismoMedicoModelo();
		 $this->lNegocioElementoProteccion = new ElementoProteccionLogicaNegocio();
		 $this->modeloElementoProteccion = new ElementoProteccionModelo();
		 $this->lNegocioEnfermedadProfesional = new EnfermedadProfesionalLogicaNegocio();
		 $this->modeloEnfermedadProfesional = new EnfermedadProfesionalModelo();
		 $this->lNegocioRecomendaciones = new RecomendacionesLogicaNegocio();
		 $this->modeloRecomendaciones = new RecomendacionesModelo();
		 $this->lNegocioEvaluacionPrimaria = new EvaluacionPrimariaLogicaNegocio();
		 $this->modeloEvaluacionPrimaria = new EvaluacionPrimariaModelo;
		 $this->lNegocioDetalleEvaluacionPrimaria = new DetalleEvaluacionPrimariaLogicaNegocio();
		 $this->modeloDetalleEvaluacionPrimaria = new DetalleEvaluacionPrimariaModelo();
		 $this->lNegocioLog = new LogLogicaNegocio();
		 $this->modeloLog = new LogModelo();

		 $this->divUsuarioEmpresa = '';

		 $this->lNegocioDatosContrato = new DatosContratoLogicaNegocio();
		 $this->modeloDatosContrato = new DatosContratoModelo();
		 $this->lNegocioFichaEmpleado = new FichaEmpleadoLogicaNegocio();
		 $this->modeloFichaEmpleado = new FichaEmpleadoModelo();

		 $this->lNegocioExamenRealizado = new ExamenRealizadoLogicaNegocio();
		 $this->modeloExamenRealizado = new ExamenRealizadoModelo();

		 $this->lNegocioMetodoPlanificacion = new MetodoPlanificacionLogicaNegocio();
		 $this->modeloMetodoPlanificacion = new MetodoPlanificacionModelo();

		 $this->lNegocioFactorRiesgo= new FactorRiesgoLogicaNegocio;
		 $this->modeloFactorRiesgo = new FactorRiesgoModelo;
		 $this->lNegocioDetalleFactorRiesgo= new DetalleFactorRiesgoLogicaNegocio;
		 $this->modeloDetalleFactorRiesgo = new DetalleFactorRiesgoModelo;

		 $this->lNegocioActividadEnfermedad= new ActividadEnfermedadLogicaNegocio;
		 $this->modeloActividadEnfermedad = new ActividadEnfermedadModelo;

		 $this->lNegocioCategoriaSubtipoProcedimiento= new CategoriaSubtipoProcedimientoLogicaNegocio;
		 $this->modeloCategoriaSubtipoProcedimiento = new CategoriaSubtipoProcedimientoModelo;
		 
		 //set_exception_handler(array($this, 'manejadorExcepciones'));
		}	
		/**
		* Método de inicio del controlador
		*/
		public function index()
		{
    		 $this->perfilUsuario();
    		 if($this->perfilUsuario == 'PFL_MEDICO'){
    		     $modeloHistoriaClinica = $this->lNegocioHistoriaClinica->buscarHistoriaClinica();
    		     $this->tablaHtmlHistoriaClinica($modeloHistoriaClinica);
    		     $this->filtroHistorias();
    		     require APP . 'HistoriasClinicas/vistas/listaHistoriaClinicaVista.php';
    		 }else{
    		     $modeloHistoriaClinica = $this->lNegocioHistoriaClinica->buscarLista("identificador_paciente='".$_SESSION['usuario']."'");
    		     $this->tablaHtmlHistoriaClinicaPaciente($modeloHistoriaClinica);
    		     $this->filtroHistorias();
    		     require APP . 'HistoriasClinicas/vistas/listaHistoriaClinicaPacienteVista.php';
    		 }
		}	
		/**
		* Método para desplegar el formulario vacio
		*/
		public function nuevo()
		{

			 $this->divInformacionEmpresa('');
			 $this->accion = "Nueva ficha inicial"; 
			 $this->contenidoReporte = "";
			 $this->divInformacionPaciente('');
			 $this->divInformacionDiscapacidad('');
			 $this->divInformacionCargo('');

			 $arrayParametros = array('identificador' => $_SESSION['usuario']);
			 $resultFirma = $this->lNegocioHistoriaClinica->obtenerDatosProfesional($arrayParametros);
			 if($resultFirma->count()){
			 	$this->divInformacionFirma($resultFirma->current());
			 }else{
			 	$this->divInformacionFirma('');
			 }
			 require APP . 'HistoriasClinicas/vistas/formularioHistoriaClinicaVista.php';
		}	

		/**
		* Método para registrar en la base de datos -HistoriaClinica
		*/
		public function guardar()
		{
		   $this->lNegocioAccidentesLaborales->guardar($_POST);
		}
		  

		  /**
		   * Método para registrar en la base de datos -HistoriaClinica
		   */
		  public function guardarRegistros()
		  {
		  	  $comun = new Comun();
		      $estado = 'EXITO';
		      $mensaje = '';
		      $contenido = '';

		      ob_start();

		      if(isset($_POST['id_historia_clinica'])){
		          if(!empty($_POST['id_historia_clinica'])){

		          	  $_POST['evaluacionPrimariaInput'] = json_decode($_POST['evaluacionPrimariaInput']);
		          	  $_POST['evaluacionPrimariaTxtInput'] = json_decode($_POST['evaluacionPrimariaTxtInput']);
		          	  //exit();

		              $resultado = $this->lNegocioHistoriaClinica->guardarRegistros($_POST);
		              $modeloHistoriaClinica = $this->lNegocioHistoriaClinica->buscar($_POST['id_historia_clinica']);

		              if($resultado){
		                  
		                  $rutaReporte = 'HistoriasClinicas/vistas/reportes/historiaClinica.jasper';
		                  $rutaCarpeta = HIST_CLI_URL."adjuntosHistoriaClinica/".$modeloHistoriaClinica->getIdentificadorPaciente();
		                  if (!file_exists('../../' . $rutaCarpeta)) {
		                      mkdir('../../' .$rutaCarpeta, 0777, true);
		                  }
		                  $nombre = 'historia_clinica_';
		                  $rutaArchivo = "adjuntosHistoriaClinica/".$modeloHistoriaClinica->getIdentificadorPaciente()."/".$nombre.$modeloHistoriaClinica->getIdentificadorPaciente();

		                  $rutaReporte1 = 'HistoriasClinicas/vistas/reportes/historiaClinica1.jasper';
		                  $nombre1 = 'historia_clinica1_';
		                  $rutaArchivo1 = "adjuntosHistoriaClinica/".$modeloHistoriaClinica->getIdentificadorPaciente()."/".$nombre1.$modeloHistoriaClinica->getIdentificadorPaciente();

		                  $rutaReporte2 = 'HistoriasClinicas/vistas/reportes/historiaClinica2.jasper';
		                  $nombre2 = 'historia_clinica2_';
		                  $rutaArchivo2 = "adjuntosHistoriaClinica/".$modeloHistoriaClinica->getIdentificadorPaciente()."/".$nombre2.$modeloHistoriaClinica->getIdentificadorPaciente();

		                  $rutaReporte3 = 'HistoriasClinicas/vistas/reportes/historiaClinica3.jasper';
		                  $nombre3 = 'historia_clinica3_';
		                  $rutaArchivo3 = "adjuntosHistoriaClinica/".$modeloHistoriaClinica->getIdentificadorPaciente()."/".$nombre3.$modeloHistoriaClinica->getIdentificadorPaciente();

		                  $rutaReporte4 = 'HistoriasClinicas/vistas/reportes/historiaClinica4.jasper';
		                  $nombre4 = 'historia_clinica4_';
		                  $rutaArchivo4 = "adjuntosHistoriaClinica/".$modeloHistoriaClinica->getIdentificadorPaciente()."/".$nombre4.$modeloHistoriaClinica->getIdentificadorPaciente();

		                  try {
		                      $jasper = new JasperReport();
		                      $rutaArchivoBase = 'HistoriasClinicas/archivos/';

		                      $datosReporte1 = array();
		                      $datosReporte1 = array(
		                          'rutaReporte' => $rutaReporte1,
		                          'rutaSalidaReporte' => $rutaArchivoBase.$rutaArchivo1,
		                          'tipoSalidaReporte' => array('pdf'),
		                          'parametrosReporte' => array('idHistoriaClinica' => $_POST['id_historia_clinica'],'fondoCertificado' => RUTA_IMG_GENE.'fondoCertificado.png'),
		                          'conexionBase' => 'SI'
		                      );

		                      $datosReporte2 = array();
		                      $datosReporte2 = array(
		                          'rutaReporte' => $rutaReporte2,
		                          'rutaSalidaReporte' => $rutaArchivoBase.$rutaArchivo2,
		                          'tipoSalidaReporte' => array('pdf'),
		                          'parametrosReporte' => array('idHistoriaClinica' => $_POST['id_historia_clinica'],'fondoCertificado' => RUTA_IMG_GENE.'fondoCertificado.png'),
		                          'conexionBase' => 'SI'
		                      );

		                      $datosReporte3 = array();
		                      $datosReporte3 = array(
		                          'rutaReporte' => $rutaReporte3,
		                          'rutaSalidaReporte' => $rutaArchivoBase.$rutaArchivo3,
		                          'tipoSalidaReporte' => array('pdf'),
		                          'parametrosReporte' => array('idHistoriaClinica' => $_POST['id_historia_clinica'],'fondoCertificado' => RUTA_IMG_GENE.'fondoCertificado.png'),
		                          'conexionBase' => 'SI'
		                      );

		                      $datosReporte4 = array();
		                      $datosReporte4 = array(
		                          'rutaReporte' => $rutaReporte4,
		                          'rutaSalidaReporte' => $rutaArchivoBase.$rutaArchivo4,
		                          'tipoSalidaReporte' => array('pdf'),
		                          'parametrosReporte' => array('idHistoriaClinica' => $_POST['id_historia_clinica'],'fondoCertificado' => RUTA_IMG_GENE.'fondoCertificado.png'),
		                          'conexionBase' => 'SI'
		                      );

		                      $pdf = new PDF();
		                      $jasper->generarArchivo($datosReporte1);
		                      $jasper->generarArchivo($datosReporte2);
		                      $jasper->generarArchivo($datosReporte3);
		                      $jasper->generarArchivo($datosReporte4);

		                      	// Agrega las páginas del primer PDF
		                      	$primerPDF = HIST_CLI_URL_TCPDF.$rutaArchivo1.'.pdf';
								$pageCount1 = $pdf->setSourceFile($primerPDF);
								for ($pageNo = 1; $pageNo <= $pageCount1; $pageNo++) {
								    $tpl = $pdf->importPage($pageNo);
								    $pdf->AddPage();
								    $pdf->useTemplate($tpl);
								}

								// Agrega las páginas del segundo PDF
								$segundoPDF = HIST_CLI_URL_TCPDF.$rutaArchivo2.'.pdf';
								$pageCount2 = $pdf->setSourceFile($segundoPDF);
								for ($pageNo = 1; $pageNo <= $pageCount2; $pageNo++) {
								    $tpl = $pdf->importPage($pageNo);
								    $pdf->AddPage();
								    $pdf->useTemplate($tpl);
								}

								// Agrega las páginas del tercer PDF
								$tercerPDF = HIST_CLI_URL_TCPDF.$rutaArchivo3.'.pdf';
								$pageCount3 = $pdf->setSourceFile($tercerPDF);
								for ($pageNo = 1; $pageNo <= $pageCount3; $pageNo++) {
								    $tpl = $pdf->importPage($pageNo);
								    $pdf->AddPage();
								    $pdf->useTemplate($tpl);
								}
								
								// Agrega las páginas del cuarto PDF
								$cuartoPDF = HIST_CLI_URL_TCPDF.$rutaArchivo4.'.pdf';
								$pageCount4 = $pdf->setSourceFile($cuartoPDF);
								for ($pageNo = 1; $pageNo <= $pageCount4; $pageNo++) {
								    $tpl = $pdf->importPage($pageNo);
								    $pdf->AddPage();
								    $pdf->useTemplate($tpl);
								}

								$fechaFirma = date("Y-m-d H:i:s");
								$modeloFichaEmpleado = $this->lNegocioFichaEmpleado->buscar($modeloHistoriaClinica->getIdentificadorMedico());
		                    	$modeloDatosContrato = $this->lNegocioDatosContrato->buscarLista("identificador = '".$modeloHistoriaClinica->getIdentificadorMedico()."' and estado = 1");

								// FIRMAR PRIMERA VEZ EL DOCUMENTO PDF
								$informacionFirmante = array(
								    'Name' => $modeloFichaEmpleado->getNombre() . ' ' .  $modeloFichaEmpleado->getApellido(),
								    'Location' => $modeloDatosContrato->current()->provincia,
								    'Reason' => 'certificacion medica',
								    'ContactInfo' =>  $modeloFichaEmpleado->getCelular()
								);

								$arrayParametros = array('identificador' => $_SESSION['usuario']);
								$resultFirma = $this->lNegocioHistoriaClinica->obtenerDatosProfesional($arrayParametros);

								$claveFirmante = $comun->desencriptarClave($_SESSION['usuario'], $resultFirma->current()->clave);
								$pdf->setSignature('file://'.$resultFirma->current()->firma_medico, 'file://'.$resultFirma->current()->firma_medico, $claveFirmante, '', 1, $informacionFirmante,'A');	
								
								$datos = array(
									'archivo_salida' => HIST_CLI_URL_TCPDF.$rutaArchivo.'.pdf',
									'identificador' => $modeloHistoriaClinica->getIdentificadorMedico(),
									'nombre_firmante' => $modeloFichaEmpleado->getNombre() . ' ' .  $modeloFichaEmpleado->getApellido(),
									'telefono' => $modeloFichaEmpleado->getCelular(),
								    'cargo' => $modeloDatosContrato->current()->nombre_puesto,
								    'razon_documento' => "Historia clinica",
								    'localizacion' => $modeloDatosContrato->current()->provincia
								);
								$style = array('border' => 0,'vpadding' => 'auto', 'hpadding' => 'auto','fgcolor' => array(0,0,0), 'bgcolor' => false, 'module_width' => 1, 'module_height' => 1);
								$datosCodigoQR = 'FIRMADO POR: '.$datos['nombre_firmante'].' RAZON:'.$datos['razon_documento'].'LOCALIZACION: '.$datos['localizacion'].'FECHA FIRMADO:' .$fechaFirma;
								$margen_izquierdo = 25;
		                    	$margenInferior = 162;

								$pdf->write2DBarcode($datosCodigoQR, 'QRCODE,Q', $margen_izquierdo +1, $margenInferior -10, 15, 15, $style, 'N');
						        $pdf->SetFont('dejavusans', '', 7);
						        $pdf->writeHTMLCell(0, '', $margen_izquierdo + 16, $margenInferior - 8, 'Firmado electrónicamente por:', 0, 0, 0, true, 'L', true);
						        $pdf->Ln();
						        $pdf->SetFont('dejavusans', 'B', 6);
						        $pdf->writeHTMLCell(45, '', $margen_izquierdo + 16, '', $datos['nombre_firmante'], 0, 0, 0, true, 'L', true);
						        $pdf->Ln();
						        $pdf->writeHTMLCell(100, '', $margen_izquierdo + 16, '',  strtoupper($datos['cargo']), 0, 0, 0, true, 'L', true);

								$pdf->Output(HIST_CLI_URL_TCPDF.$rutaArchivo.'.pdf', 'F');

								//CODIGO PARA GENERAR ARCHIVO DE CERTIFICADO
								$nombreCertificado = 'certificado_historia_clinica_';
								$rutaArchivoCertificado = "adjuntosHistoriaClinica/".$modeloHistoriaClinica->getIdentificadorPaciente()."/".$nombreCertificado.$modeloHistoriaClinica->getIdentificadorPaciente();
								$rutaReporteCertificado = 'HistoriasClinicas/vistas/reportes/certificado.jasper';
								$rutaReporteCertificadoJrxml = 'HistoriasClinicas/vistas/reportes/certificado.jrxml';

								$datosReporteCertificado = array();
								$datosReporteCertificado = array(
									'rutaReporte' => $rutaReporteCertificado ,
									'rutaSalidaReporte' => $rutaArchivoBase.$rutaArchivoCertificado,
									'tipoSalidaReporte' => array('pdf'),
									'parametrosReporte' => array('idHistoriaClinica' => $_POST['id_historia_clinica'],'fondoCertificado' => RUTA_IMG_GENE.'fondoCertificado.png'),
									'conexionBase' => 'SI'
								);

								$jasper->generarArchivo($datosReporteCertificado);

								$pdfCertificado = new PDF();
								$certificadoPDF = HIST_CLI_URL_TCPDF.$rutaArchivoCertificado.'.pdf';

								$pageCountCertificado = $pdfCertificado->setSourceFile($certificadoPDF);
								for ($pageNo = 1; $pageNo <= $pageCountCertificado; $pageNo++) {
										$tplCertificado = $pdfCertificado->importPage($pageNo);
										$pdfCertificado->AddPage();
										$pdfCertificado->useTemplate($tplCertificado);
								}

								$pdfCertificado->setSignature('file://'.$resultFirma->current()->firma_medico, 'file://'.$resultFirma->current()->firma_medico, $claveFirmante, '', 1, $informacionFirmante,'A');	

								$pdfCertificado->write2DBarcode($datosCodigoQR, 'QRCODE,Q', $margen_izquierdo + 82, $margenInferior + 85, 15, 15, $style, 'N');
								$pdfCertificado->SetFont('dejavusans', '', 7);
								$pdfCertificado->writeHTMLCell(0, '', $margen_izquierdo + 97, $margenInferior + 87, 'Firmado por:', 0, 0, 0, true, 'L', true);
								$pdfCertificado->Ln();
								$pdfCertificado->SetFont('dejavusans', 'B', 6);
								$pdfCertificado->writeHTMLCell(45, '', $margen_izquierdo + 97, '', $datos['nombre_firmante'], 0, 0, 0, true, 'L', true);

								$pdfCertificado->Output(HIST_CLI_URL_TCPDF.$rutaArchivoCertificado.'.pdf', 'F');
								//FIN ARCHIVO DE CERTIFICADO 

								ob_end_clean();

		                      $contenido = HIST_CLI_URL.$rutaArchivoCertificado.'.pdf';
		                      $validar=1;

		                  } catch (\Exception  $e) {
		                      $validar=0;
		                  }
		                  if($validar){
		                      $adjuntoHC = $this->lNegocioAdjuntosHistoriaClinica->buscarLista("id_historia_clinica=".$_POST["id_historia_clinica"]." and id_procedimiento_medico is null");
		                      if($adjuntoHC->count()){
		                          $arrayAdjunto = array(
		                              'id_adjuntos_historia_clinica' => $adjuntoHC->current()->id_adjuntos_historia_clinica,
		                              'id_historia_clinica' => $_POST['id_historia_clinica'],
		                              'archivo_adjunto' => HIST_CLI_URL.$rutaArchivo.'.pdf',
		                              'descripcion_adjunto' => 'Historia Clínica pdf'
		                          );
		                      }else{
		                          $arrayAdjunto = array(
		                              'id_historia_clinica' => $_POST['id_historia_clinica'],
		                              'archivo_adjunto' => HIST_CLI_URL.$rutaArchivo.'.pdf',
		                              'descripcion_adjunto' => 'Historia Clínica pdf'
		                          );
		                      }

		                      $arrayCertificado= array(
		                              'id_historia_clinica' => $_POST['id_historia_clinica'],
		                              'archivo_adjunto' => HIST_CLI_URL.$rutaArchivoCertificado.'.pdf',
		                              'descripcion_adjunto' => 'Certificado Historia Clinica pdf'
		                       );
		                      $id = $this->lNegocioAdjuntosHistoriaClinica->guardar($arrayAdjunto);
		                      $this->lNegocioAdjuntosHistoriaClinica->guardar($arrayCertificado);

		                      //$jasper->generarReporteJasper($rutaReporteCertificadoJrxml,$datosReporteCertificado,$conexion,$datosReporteCertificado['rutaSalidaReporte'],'ninguno');

		                      if($id){
		                          $mensaje = 'Registro agregado correctamente';
		                      }else{
		                          $estado = 'FALLO';
		                          $mensaje = 'Error al guardar el registro..!!';
		                      }
		                  }else{
		                      $estado = 'ERROR';
		                      $mensaje = 'Error al crear el archivo pdf de la historia clínica';
		                  }
		              }else {
		                  $estado = 'ERROR';
		                  $mensaje = 'Error al guardar los datos !!';
		              }
		          }else{
		              $estado = 'ERROR';
		              $mensaje = 'Debe crear la historia clínica !!';
		          }
		      }else{
		          $estado = 'ERROR';
		          $mensaje = 'Debe crear la historia clínica !!';
		      }
		      
		      echo json_encode(array(
		          'estado' => $estado,
		          'mensaje' => $mensaje,
		          'contenido' => $contenido
		      ));
		}	/**
		*Obtenemos los datos del registro seleccionado para editar - Tabla: HistoriaClinica
		*/
		public function editar()
		{
		 $this->perfilUsuario();
		 $this->idHistorialClinica = $_POST['id'];
		 $this->estado = "editar";
		 $this->modeloHistoriaClinica = $this->lNegocioHistoriaClinica->buscar($_POST["id"]);
		 $adjuntoHC = $this->lNegocioAdjuntosHistoriaClinica->buscarLista("id_historia_clinica = ".$_POST["id"]." AND id_procedimiento_medico is null AND descripcion_adjunto = 'Historia Clínica pdf'");
		 if($adjuntoHC->count()){
		   $this->adjuntoHistoriaClinica = $adjuntoHC->current()->archivo_adjunto;
		 }
		 $enfermedadProfesional = $this->lNegocioEnfermedadProfesional->buscarLista("id_historia_clinica =".$_POST["id"]);
		 if($enfermedadProfesional->count()){
		     $this->modeloEnfermedadProfesional= $this->lNegocioEnfermedadProfesional->buscar($enfermedadProfesional->current()->id_enfermedad_profesional);
		 }
		 $examenFisico = $this->lNegocioExamenFisico->buscarLista("id_historia_clinica =".$_POST["id"]);
		 if($examenFisico->count()){
		     $this->modeloExamenFisico= $this->lNegocioExamenFisico->buscar($examenFisico->current()->id_examen_fisico);
		 }
		 $recomendaciones = $this->lNegocioRecomendaciones->buscarLista("id_historia_clinica =".$_POST["id"]);
		 if($recomendaciones->count()){
		     $this->modeloRecomendaciones= $this->lNegocioRecomendaciones->buscar($recomendaciones->current()->id_recomendaciones);
		 }
		 
		 $this->listarLog($_POST["id"]);
		 $arrayParametros = array('identificador_paciente' => $this->modeloHistoriaClinica->getIdentificadorPaciente());
		 $arrayParametrosEmpresa = array('identificador' => $this->modeloHistoriaClinica->getIdentificadorPaciente());
		 $this->divInformacionEmpresa($arrayParametrosEmpresa);
		 $resultado = $this->lNegocioHistoriaClinica->buscarInformacionPaciente($arrayParametros);
		 $this->divInformacionPaciente($resultado->current());
		 $resultCargo = $this->lNegocioHistoriaClinica->obtenerDatosContrato($arrayParametros);
		 $this->divInformacionDiscapacidad($resultado->current());
		 $this->divInformacionCargo($resultCargo->current());
		 
		 if($this->perfilUsuario == 'PFL_MEDICO'){
		     $arrayParametros = array(
		         'identificador' => $_SESSION['usuario']);
		     $resultFirma = $this->lNegocioHistoriaClinica->obtenerDatosProfesional($arrayParametros);
		     if($resultFirma->count()){
		         $this->divInformacionFirma($resultFirma->current());
		     }else{
		         $this->divInformacionFirma('');
		     }
		     $this->accion = "Editar Historia Clínica"; 
		     require APP . 'HistoriasClinicas/vistas/formularioHistoriaClinicaVista.php';
		 }else{
		     $this->accion = "Historia Clínica"; 
		     $arrayParametros = array(
		         'identificador' => $this->modeloHistoriaClinica->getIdentificadorMedico());
		     $resultFirma = $this->lNegocioHistoriaClinica->obtenerDatosFirma($arrayParametros);
		     if($resultFirma->count()){
		         $this->divInformacionNotificacion($resultFirma->current(),$this->modeloHistoriaClinica->getFechaCreacion());
		     }else{
		         $this->divInformacionNotificacion('');
		     }
		     require APP . 'HistoriasClinicas/vistas/formularioHistoriaClinicaReporteVista.php';
		 }
		
		}	
		/**
		* Método para borrar un registro en la base de datos - HistoriaClinica
		*/
		public function borrar()
		{
		  $this->lNegocioHistoriaClinica->borrar($_POST['elementos']);
		}	
		  /**
		* Construye el código HTML para desplegar la lista de - HistoriaClinica
		*/
		 public function tablaHtmlHistoriaClinica($tabla) {
		{
		 $contador = 0;
		  foreach ($tabla as $fila) {
    		  	$arrayParametros = array(
    		  		'identificador' => $fila['identificador_paciente']);
    		  	$resultConsulta = $this->lNegocioHistoriaClinica->obtenerDatosFirma($arrayParametros);
        		if(isset($resultConsulta->current()->funcionario)){
        		   $this->itemsFiltrados[] = array(
        		  '<tr id="' . $fila['id_historia_clinica'] . '"
        		    class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'HistoriasClinicas\historiaClinica"
        		    data-opcion="editar" ondragstart="drag(event)" draggable="true"
        		    data-destino="detalleItem">
        		    <td>' . ++$contador . '</td>
                      <td style="white - space:nowrap; "><b>' . date('d / m / Y',strtotime($fila['fecha_creacion'])) . '</b></td>
                    <td>'
                    	  . $fila['identificador_paciente'] . '</td>
                    <td>' . $resultConsulta->current()->funcionario . '</td>
                    </tr>');
        		}
		  }
		}
	}
	/**
	 * Construye el código HTML para desplegar la lista de - HistoriaClinica
	 */
	public function tablaHtmlHistoriaClinicaPaciente($tabla) {
	    {
	        $contador = 0;
	        foreach ($tabla as $fila) {
	            $this->itemsFiltrados[] = array(
	                '<tr id="' . $fila['id_historia_clinica'] . '"
    		    class="item" data-rutaAplicacion="'.URL_MVC_FOLDER.'HistoriasClinicas\historiaClinica"
    		    data-opcion="editar" ondragstart="drag(event)" draggable="true"
    		    data-destino="detalleItem">
    		    <td>' . ++$contador . '</td>
                  <td style="white - space:nowrap; "><b>' . date('d / m / Y',strtotime($fila['fecha_creacion'])) . '</b></td>
                <td> Historia Clínica</td>
                </tr>');
	        }
	    }
	}
	/**
	 * funcion para buscar informacion del funcionario
	 */
	public function buscarFuncionario(){
		$estado = 'EXITO';
		$mensaje = '';
		$paciente = '';
		$puesto = '';
		$discapacidad = '';
		
		$arrayParametros = array('identificador_paciente' => $_POST['identificador']);
		$resultado = $this->lNegocioHistoriaClinica->buscarInformacionPaciente($arrayParametros);

		if($resultado->count()>0){
			$this->divInformacionEmpresa($resultado->current());
			$empresa = $this->divInformacionEmpresa;

			$this->divInformacionPaciente($resultado->current());
			$paciente = $this->divInformacion;

			$this->divInformacionDiscapacidad($resultado->current());
			$discapacidad = $this->divDiscapacidad;

			$resultCargo = $this->lNegocioHistoriaClinica->obtenerDatosContrato($arrayParametros);
			$this->divInformacionCargo($resultCargo->current());
			$puesto = $this->divCargo;


			$this->divUsuarioEmpresa = $empresa . $paciente . $discapacidad . $puesto;
		}else{
			$estado = 'ERROR';
			$mensaje = 'No existe el funcionario buscado !!';
			$this->divInformacionEmpresa($resultado->current());
			$empresa = $this->divInformacionEmpresa;
			$this->divInformacionPaciente('');
			$paciente = $this->divInformacion;
			$this->divInformacionDiscapacidad('');
			$discapacidad = $this->divDiscapacidad;
			$this->divInformacionCargo('');
			$puesto = $this->divCargo;

			$this->divUsuarioEmpresa = $empresa . $paciente . $discapacidad . $puesto;
		}
		
		echo json_encode(array(
			'estado' => $estado,
			'mensaje' => $mensaje,
			'paciente' => $paciente,
			'puesto' => $puesto,
			'discapacidad' => $discapacidad,
			'usuarioEmpresa' => $this->divUsuarioEmpresa,
			'sexo' => $this->sexo
		));
	}
	

	/**
	 * funcion para construir la informacion de la empresa
	 * 
	 */
	public function divInformacionEmpresa($tabla) {
		
		if($tabla == ''){
			$arrayPaciente = array(
				'identificador' => ''	
			);

			$tabla = $arrayPaciente;
		}
		
		$div = '
		<legend>A. Datos del establecimiento - Empresa y Usuario</legend>	

		<div data-linea="1">
			<label for="identificador_paciente">Institución del sistema o nombre de la empresa: </label>
			<span>AGENCIA DE REGULACIÓN Y CONTROL FITO Y ZOOSANITARIO</span>
		</div>				

		<div data-linea="2">
			<label for="establecimiento_salud">Establecimiento de Salud: </label>
			<span>CONSULTORIO MÉDICO AGROCALIDAD</span>
		</div>	

		<div data-linea="3">
			<label for="ruc">RUC:</label>
			<span>176818883001</span>
		</div>				

		<div data-linea="3">
			<label for="ciuu">CIIU: </label>
			<span>48570</span>
		</div>				

		<div data-linea="4">
			<label for="numero_historia">Número de historia clínica:</label>
			<span>'.$tabla['identificador'].'</span>
		</div>				

		<div data-linea="4">
			<label for="numero_archivo">Número de archivo:</label>
			<span>'.$tabla['identificador'].'</span>
		</div>

		<hr>				
	';
		
		$this->divInformacionEmpresa = $div;
		$this->divUsuarioEmpresa .= $div;
	}


	/**
	 * funcion para construir la informacion del paciente
	 * 
	 */
	public function divInformacionPaciente($tabla) {
		
		if($tabla == ''){
			$arrayPaciente = array(
				'identificador' => '',
				'primer_apellido' => '',
				'segundo_apellido' => '',
				'primer_nombre' => '',
				'segundo_nombre' => '',
				'fecha_nacimiento' => '',
				'genero' => '',
				'estado_civil' => '',
				'edad' => '',
				'tipo_sangre' => '',
				'nivel_instruccion' => '',
				'convencional' => '',
			    'lateralidad' => '',
			    'religion' => '',
			    'canton' =>'',
			    'orientacion_sexual' => '',
			    'identidad_genero' => ''
			);
			$tabla = $arrayPaciente;
		}
		else{
			$nombresSeparados = $this->separarNombreCompleto($tabla['nombre']);
			$apellidosSeparados = $this->separarNombreCompleto($tabla['apellido']);
			$tabla['primer_nombre'] = $nombresSeparados['primer_nombre'];
			$tabla['segundo_nombre'] = $nombresSeparados['segundo_nombre'];
			$tabla['primer_apellido'] = $apellidosSeparados['primer_nombre'];
			$tabla['segundo_apellido'] = $apellidosSeparados['segundo_nombre'];
		}
		
		if($tabla['genero'] == 'Masculino'){
			$this->sexo = 'M';
		}
		else{
			$this->sexo = 'F';
		}

		$div = '

		<div data-linea="5">
			<label for="primer_apellido">Primer apellido: </label>
			<span>'.$tabla['primer_apellido'].'</span>
			<input type="hidden" id="identificador_paciente" name="identificador_paciente" value="'.$tabla['identificador'].'" maxlength="13" />
		</div>

		<div data-linea="5">
			<label for="segundo_apellido">Segundo apellido: </label>
			<span>'.$tabla['segundo_apellido'].'</span>
		</div>

		<div data-linea="6">
			<label for="primer_nombre">Primer nombre: </label>
			<span>'.$tabla['primer_nombre'].'</span>
		</div>

		<div data-linea="6">
			<label for="segundo_nombre">Segundo nombre: </label>
			<span>'.$tabla['segundo_nombre'].'</span>
		</div>

		<div data-linea="7">
			<label for="genero">Sexo: </label>
			<span>'.$tabla['genero'].'</span>
		</div>

		<div data-linea="7">
			<label for="edad">Edad (años):</label>
			<span>'.$tabla['edad'].'</span>
		</div>		

		<div data-linea="8">
			<label for="religion">Religión:</label>
			<span>'.$tabla['religion'].'</span>
		</div>	


		<div data-linea="8">
			<label for="tipo_sangre">Grupo sanguíneo: </label>
			<span>'.$tabla['tipo_sangre'].'</span>
		</div>

		<div data-linea="9">
			<label for="lateralidad">Lateralidad: </label>
			<span>'.$tabla['lateralidad'].'</span>
		</div>	
			

		<div data-linea="9">
			<label for="convencional">Orientación sexual:</label>
			<span>'.$tabla['orientacion_sexual'].'</span>
		</div>				

		<div data-linea="10">
			<label for="estado_civil">Identidad de género:</label>
			<span>'.$tabla['identidad_genero'].'</span>
		</div>						
		<hr>
	';
		
		$this->divInformacion = $div;
		$this->divUsuarioEmpresa .= $div;
	}
	
	/**
	 *
	 * funcion para construir la vista del contrato
	 */
	public function divInformacionDiscapacidad($tabla) {
		
		if($tabla == ''){
			$arrayDiscapacidad = array(
				'tiene_discapacidad' => '',
				'carnet_conadis_empleado' => '',
				'representante_familiar_discapacidad' => '',
				'carnet_conadis_familiar' => '',
				'tiene_enfermedad_catastrofica' => '',
				'nombre_enfermedad_catastrofica' => '',
				'tipo_discapacidad' => '',
				'porcentaje_discapacidad' => ''
			);
			$tabla = $arrayDiscapacidad;
		}

		if($tabla['tiene_discapacidad'] == 'NO'){
			$control = "disabled";
			$tabla['tipo_discapacidad'] = '';
			$tabla['porcentaje_discapacidad'] = 0;
		}
		else{
			$control = "";
		}
		
		$div = '			
		<div data-linea="11">
			<label for="tiene_discapacidad">Discapacidad:</label>
			<span>'.$tabla['tiene_discapacidad'].'</span>
		</div>

		<div data-linea="11">
			<label for="tipo_discapacidad">Tipo:</label>
			<select id="tipo_discapacidad" name= "tipo_discapacidad" '. $control . '>
        				'. $this->comboTipoDiscapacidad($tabla['tipo_discapacidad']).'
        	</select>
		</div>

		<div data-linea="11">
			<label for="porcentaje_discapacidad">Porcentaje:</label>
			<input type="number" id="porcentaje_discapacidad" name = "porcentaje_discapacidad" '. $control .' onchange="validarNumero()" value="'.$tabla['porcentaje_discapacidad'].'">
		</div>	
		<hr>			
	';
		
		$this->divDiscapacidad = $div;
		$this->divUsuarioEmpresa .= $div;
	}

	/**
	 * 
	 * funcion para construir la vista del contrato
	 */
	public function divInformacionCargo($tabla) {
		
		if($tabla == ''){
			$arrayCargo = array(
				'nombre_puesto' => '',
				'oficina' => '',
				'coordinacion' => '',
				'direccion' => '',
				'jornada_laboral' => '',
				'fecha_inicial' => '',
				'id_datos_contrato' => '',
				'actividades_relevantes' => ''
			);
			$tabla = $arrayCargo;
		}
		
		$div = '

		<div data-linea="12">
			<label for="fecha_inicial">Fecha de ingreso al trabajo: </label>
			<span>'.$tabla['fecha_inicial'].'</span>
			<input type="hidden" id="id_datos_contrato" name="id_datos_Contrato" value="'.$tabla['id_datos_contrato'].'"/>
		</div>	
		<div data-linea="12">
			<label for="jornada_laboral">Jornada laboral: </label>
			<span>'.$tabla['jornada_laboral'].'</span>
		</div>	

		<div data-linea="13">
			<label for="nombre_puesto">Puesto de trabajo:</label>
			<span>'.$tabla['nombre_puesto'].'</span>
		</div>				

		<div data-linea="13">
			<label for="direccion">Área de trabajo: </label>
			<span>'.$tabla['direccion'].'</span>
		</div>	

		<div data-linea="14">
			<label for="actividades_relevantes">Actividades relevantes al puesto de trabajo: </label>
			<input type="text" id="actividades_relevantes" name="observaciones_salud" value="'.$tabla['actividades_relevantes'].'" maxlength="62" oninput="contador(this)"/>
		</div>

		<div data-linea="15">
			<span id="counter_actividades_relevantes" style="font-size:11px"># carácteres, le quedan #.</span>
		</div>				
					
	';
		
		$this->divCargo = $div;
		$this->divUsuarioEmpresa .= $div;
	}

	
	/**
	 *
	 * funcion para construir la vista de la firma
	 */
	public function divInformacionFirma($tabla) {
		
		if($tabla == ''){
			$arrayFirma = array(
				'funcionario' => '',
				'identificador' => '',
				'firma_medico' => '',
				'firma_paciente' => ''
			);
			$tabla = $arrayFirma;
		}

		if(isset($tabla['firma_medico'])){
			if ($tabla['firma_medico']!=null || $tabla['firma_medico']!='')
			{
				$firma = '<span> Firma electrónica cargada. </span>';
			}
			else{
				$firma = '<span style="color:red;"> Por favor cargar su firma electrónica </span>';
			}
		}
		else{
			$firma = '<span style="color:red;"> Por favor cargar su firma electrónica </span>';
		}

		$div = '
		<legend>Datos del profesional</legend>				

		<div data-linea="1">
			<label for="fecha">Fecha:</label>
			<span>'.date('Y-m-d').'</span>
		</div>

		<div data-linea="2">
			<label for="hora">Hora:</label>
			<span>'.date('H:i:s').'</span>
		</div>	

		<div data-linea="3">
			<label for="funcionario">Nombres y Apellidos:</label>
			<span>'.$tabla['funcionario'].'</span>
		</div>							

		<div data-linea="4">
			<label for="identificador">Código:</label>
			<span>'.$tabla['identificador'].'</span>
		</div>

		<div data-linea="5">
			<label for="firma_medico">Firma Médico:</label>
			'. $firma . '
		</div>

	';
		
		$this->firma= $div;
	}
	
	/**
	 *
	 * funcion para construir la vista de la notificación
	 */
	public function divInformacionNotificacion($tabla,$fecha=null) {
	    
	    if($tabla == ''){
	        $arrayFirma = array(
	            'funcionario' => '',
	            'cargo' => '',
	            'identificador' => '',
	            'fecha_creacion' => ''
	        );
	        $tabla = $arrayFirma;
	    }
	    
	    $div = '
		<legend>Notificación</legend>
	    <div data-linea="1">
			<label for="funcionario">Fecha de creación de la Historia Clínica:</label>
			<span>'.date('Y-m-d', strtotime($fecha)).'</span>
		</div>
		<div data-linea="2">
			<label for="funcionario">Realizado por:</label>
			<span>'.$tabla['funcionario'].'</span>
		</div>
			    
		<div data-linea="3">
			<label for="cargo">Cargo: </label>
			<span>'.$tabla['cargo'].'</span>
		</div>
			    
		<div data-linea="4">
			<label for="identificador">CMP:</label>
			<span>'.$tabla['identificador'].'</span>
		</div>
	';
	    
	    $this->firma= $div;
	}
	/**
	 * crear subtipos
	 */
	public function listarSubtipos($subtipo){
		
		$datos='';
		$i=0;
		foreach ($subtipo as $item) {
			
			if($i==0){
				$datos .= '<tr>';
			}
			$datos .= '<td><input class="case" name="subtipoList[]" type="checkbox" value="'.$item->id_subtipo_proced_medico.'"> '.$item->subtipo.'</td>';
			$i++;
			if($i==3){
				$datos .= '<tr>';
				$i=0;
			}
		}
		
		$html = '
           <br>
			<label for="exposicion">Seleccione uno o varios subtipos de exposición: </label>
			<div>
			<table  style="width: 100%;">
			<tr> <td colspan="3"><input onclick="verificarCheckbox(id);" name="checkTodos" id="checkTodos" type="checkbox" class="checkTodos"> Seleccionar todos</td> </tr>
			'.$datos.'
			<tr> 
				<td><input onchange="habilitarFactoresEspecifique(this);" id="checboxOtrosFactores" name="checboxOtrosFactores" type="checkbox" value="otrosFactores"> Otros</td>
				<td><input id="otros_factor" name="otros_factor" type="text" maxlength="32" disabled="true" placeholder="Especifique"/></td>  
			</tr>
			</table>
         ';
		return $html;
	}
	
	/**
	 * funcion para buscar informacion de subtipos de exposicion
	 */
	public function buscarSubtipos(){
		$estado = 'EXITO';
		$mensaje = '';
		$contenido = '';
		
		$arrayIndex = " id_tipo_procedimiento_medico = ".$_POST['tipoProcedimiento']." AND estado = 'Activo'";
		$subtipo = $this->lNegocioSubtipoProcedimientoMedico->buscarLista($arrayIndex);
		
		if($subtipo->count()){
			$contenido = $this->listarSubtipos($subtipo);
		}
		
		echo json_encode(array(
			'estado' => $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido
		));
	}
	/**
	 * funcion para crear la historia clínica
	 */
	public function crearHistoriaClinica() {
		$estado = 'EXITO';
		$mensaje = '';
		$contenido = '';
		
		if($_POST['identificador_paciente'] != ''){
			$datos = array(
				'identificador_paciente' => $_POST['identificador_paciente'],
				'identificador_medico' => $_SESSION['usuario']
			);

			$datosFicha  = array(
				'identificador' => $_POST['identificador_paciente'],
				'porcentaje_discapacidad' => (int) $_POST['porcentaje_discapacidad'],
				'tipo_discapacidad' => $_POST['tipo_discapacidad']
			);

			$datosContrato  = array(
				'id_datos_contrato' => $_POST['id_datos_contrato'],
				'actividades_relevantes' => $_POST['actividades_relevantes']
			);
			

			$verificar = $this->lNegocioHistoriaClinica->buscarLista("identificador_paciente='".$_POST['identificador_paciente']."'");			
			if(!$verificar->count()){
				$idHistoria = $this->lNegocioHistoriaClinica->guardar($datos);
				$this->guardarFichaEmpleado($datosFicha);
				$this->guardarDatosContrato($datosContrato);

				$mensaje = 'Historia clínica creada correctamente';
				$contenido = $idHistoria;
			}else{
				$estado = 'ERROR';
				$mensaje = 'Historia clínica ya registrada !!';
			}
			
		}else{
			$estado = 'ERROR';
			$mensaje = 'Identificador del paciente vacio !!';
		}
		
		echo json_encode(array(
			'estado' => $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido
		));
	}
	/**
	 * funcion para agregar exposiciones en paciente
	 */
	public function agregarExposicion() {

		$estado = 'EXITO';
		$mensaje = '';
		$contenido = '';
		$accidente = '';
		
		if(isset($_POST['id_historia_clinica'])){
		    if(!empty($_POST['id_historia_clinica'])){
    			$arrayIndex = "nombre ='Exposición'";
    			$procedi = $this->lNegocioProcedimientoMedico->buscarLista($arrayIndex);
    			$_POST['id_procedimiento_medico'] = $procedi->current()->id_procedimiento_medico;
    			$resultado = $this->lNegocioHistoriaOcupacional->guardarHistoriaDetalle($_POST);
    			if($resultado){
    			    $contenido = $this->listarHistoriaOcupacional($_POST['id_historia_clinica']);
    			    $accidente = $this->comboHistoriaOcupacional($_POST['id_historia_clinica']);
    			    $mensaje = 'Registro agregado correctamente';
    			}else {
    			    $estado = 'ERROR';
    			    $mensaje = 'Error al guardar los datos !!';
    			}
		    }else{
		        $estado = 'ERROR';
		        $mensaje = 'Debe crear la historia clínica !!';
		    }
		}else{
			$estado = 'ERROR';
			$mensaje = 'Debe crear la historia clínica !!';
		}
		
		echo json_encode(array(
			'estado' => $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido,
		    'accidente' => $accidente
		));
	}
	/**
	 * funcion para eliminar exposiciones en paciente
	 */
	public function eliminarExposicion() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    $accidente = '';
	    
	    
	    if(isset($_POST['id_historia_ocupacional']) && isset($_POST['id_historia_clinica'])){
	        
	        $verificar = $this->lNegocioAccidentesLaborales->buscarLista("id_historia_ocupacional=".$_POST['id_historia_ocupacional']." and id_historia_clinica=".$_POST['id_historia_clinica']);
	        if($verificar->count() <= 0){
	        $this->lNegocioHistoriaOcupacional->borrar($_POST['id_historia_ocupacional']);
	        $contenido = $this->listarHistoriaOcupacional($_POST['id_historia_clinica']);
	        $accidente = $this->comboHistoriaOcupacional($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	        }else{
	            $estado = 'ERROR';
	            $mensaje = 'No se puede eliminar, se utiliza en Accidentes Laborales !!';
	        }
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido,
	        'accidente' => $accidente
	    ));
	}
	/**
	 * listar historia ocupacional agregada
	 */
	public function listarHistoriaOcupacional($idHistoriaClinica=null,$opt=1){
	    $datos=$html='';
	    if($idHistoriaClinica != null){
		$consulta = $this->lNegocioHistoriaOcupacional->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
		if($consulta->count()){
			foreach ($consulta as $item) {
			$tipo =	$this->lNegocioTipoProcedimientoMedico->buscar($item->id_tipo_procedimiento_medico);
			
			$datos .= '<tr>';
			$datos .= '<td>'.$item->empresa.'</td>';
			$datos .= '<td>'.$item->cargo.'</td>';
			$datos .= '<td>'.$item->actividades_trabajo.'</td>';
			$datos .= '<td>'.$item->tiempo_exposicion.'</td>';
			$datos .= '<td>'.$tipo->getTipo().'</td>';
			$datos .= '<td>'.$item->observaciones_trabajo.'</td>';
			if($opt){
    			$datos .= '<td><button class="bEliminar icono" onclick="eliminarSubtipo('.$item->id_historia_ocupacional.'); return false; "></button></td>';
			}else{
			    $datos .= '<td></td>';
			}
			$datos .= '<tr>';
			}
			
		$html = '
				<table style="width: 100%;">
					<thead><tr>
						<th>Empresa</th>
						<th>Puesto de trabajo</th>
						<th>Actvidades</th>
						<th>Tiempo</th>
						<th>Riesgo</th>
						<th>Observaciones</th>
						<th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>
           
          ';
		 }
	    }
		return $html;
	}
	
	/**
	 * combo historia ocupacional agregada
	 */
	public function comboHistoriaOcupacional($idHistoriaClinica=null,$idHistoriaOcupacional=null){
	    $combo = '<option value="">Seleccionar....</option>';
	    if($idHistoriaClinica != null){
	       $consulta = $this->lNegocioHistoriaOcupacional->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
	       if($consulta->count()){
	           foreach ($consulta as $item) {
	               if ($idHistoriaOcupacional == $item->id_historia_ocupacional)
	               {
	                   $combo .= '<option value="' . $item->id_historia_ocupacional . '" selected>' . $item->empresa. '</option>';
	               } else
	               {
	                   $combo .= '<option value="' . $item->id_historia_ocupacional . '">' . $item->empresa . '</option>';
	               }
	           }
	       }
	    }
	    
	    return $combo;
	}


	/**
	 * funcion para agregar factor de riesgo
	 */
	public function agregarFactorRiesgo() {

		$estado = 'EXITO';
		$mensaje = '';
		$contenido = '';
		
		if(isset($_POST['id_historia_clinica']) && !empty($_POST['id_historia_clinica'])){
			$arrayIndex = "nombre ='Exposición'";
			$procedi = $this->lNegocioProcedimientoMedico->buscarLista($arrayIndex);
			$_POST['id_procedimiento_medico'] = $procedi->current()->id_procedimiento_medico;
			$resultado = $this->lNegocioFactorRiesgo->guardarFactorDetalle($_POST);
			if($resultado){
			    $contenido = $this->listarFactoresRiesgo($_POST['id_historia_clinica']);
			    $mensaje = 'Registro agregado correctamente';
			}else {
			    $estado = 'ERROR';
			    $mensaje = 'Error al guardar los datos !!';
			}
		}
		else
		{
			$estado = 'ERROR';
			$mensaje = 'Debe crear la historia clínica !!';
		}
		echo json_encode(array(
			'estado' => $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido
		));
	}

	/**
	 * funcion para eliminar factor de riesgo
	 */
	public function eliminarFactorRiesgo() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';

	    if(isset($_POST['id_factor_riesgo']) && isset($_POST['id_historia_clinica']))
	    {
	    	$this->lNegocioDetalleFactorRiesgo->borrarPorParametro("id_factor_riesgo", $_POST['id_factor_riesgo']);
	        $this->lNegocioFactorRiesgo->borrar($_POST['id_factor_riesgo']);
	        $contenido = $this->listarFactoresRiesgo($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	/**
	 * listar factores de riesgo
	 */
	public function listarFactoresRiesgo($idHistoriaClinica=null,$opt=1){
	    $datos=$html='';
	    if($idHistoriaClinica != null){
		$consulta = $this->lNegocioFactorRiesgo->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
		if($consulta->count()){
			foreach ($consulta as $item) {
			$tipo =	$this->lNegocioTipoProcedimientoMedico->buscar($item->id_tipo_procedimiento_medico);
			
			$datos .= '<tr>';
			$datos .= '<td>'.$item->cargo_factor.'</td>';
			$datos .= '<td>'.$item->actividades_factor.'</td>';
			$datos .= '<td>'.$tipo->getTipo().'</td>';
			if($opt){
    			$datos .= '<td><button class="bEliminar icono" onclick="eliminarFactorRiesgo('.$item->id_factor_riesgo.'); return false; "></button></td>';
			}else{
			    $datos .= '<td></td>';
			}
			$datos .= '<tr>';
			}
			
		$html = '
				<table style="width: 100%;">
					<thead><tr>
						<th>Puesto de trabajo / área</th>
						<th>Actividades</th>
						<th>Tipo de exposición</th>
						<th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>
          ';
		 }
	    }
		return $html;
	}


//>>>>>>>>>>>>>>>>>>>>>>>>>>>> actividades extra laborales >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	public function agregarActividadesExtras() 
	{
		$estado = 'EXITO';
		$mensaje = '';
		$contenido = '';
		if(isset($_POST['id_historia_clinica']) && !empty($_POST['id_historia_clinica'])){
			$resultado = $this->lNegocioActividadEnfermedad->guardar($_POST);
			if($resultado){
			    $contenido = $this->listarActividadesExtras($_POST['id_historia_clinica']);
			    $mensaje = 'Registro agregado correctamente';
			}else {
			    $estado = 'ERROR';
			    $mensaje = 'Error al guardar los datos !!';
			}
		}
		else
		{
			$estado = 'ERROR';
			$mensaje = 'Debe crear la historia clínica !!';
		}
		echo json_encode(array(
			'estado' => $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido
		));
	}

	public function eliminarActividadesExtras() 
	{
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';

	    if(isset($_POST['id_actividad_enfermedad']) && isset($_POST['id_historia_clinica']))
	    {
	        $this->lNegocioActividadEnfermedad->borrar($_POST['id_actividad_enfermedad']);
	        $contenido = $this->listarActividadesExtras($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	public function listarActividadesExtras($idHistoriaClinica=null,$opt=1)
	{
	    $datos=$html='';
	    if($idHistoriaClinica != null){
		$consulta = $this->lNegocioActividadEnfermedad->buscarLista("id_historia_clinica =".$idHistoriaClinica." and tipo = 'A' order by 1 ");
		if($consulta->count()){
			foreach ($consulta as $item) {
			$datos .= '<tr>';
			$datos .= '<td>'.$item->descripcion.'</td>';
			if($opt){
    			$datos .= '<td><button class="bEliminar icono" onclick="eliminarActividadesExtras('.$item->id_actividad_enfermedad.'); return false; "></button></td>';
			}else{
			    $datos .= '<td></td>';
			}
			$datos .= '<tr>';
			}
			
		$html = '
				<table style="width: 100%;">
					<thead><tr>
						<th>Descripción</th>
						<th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>
          ';
		 }
	    }
		return $html;
	}


//>>>>>>>>>>>>>>>>>>>>>>>>>>>> enfermedad actual >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	public function agregarEnfermedadActual() 
	{
		$estado = 'EXITO';
		$mensaje = '';
		$contenido = '';
		
		if(isset($_POST['id_historia_clinica']) && !empty($_POST['id_historia_clinica'])){
			$resultado = $this->lNegocioActividadEnfermedad->guardar($_POST);
			if($resultado){
			    $contenido = $this->listarEnfermedadActual($_POST['id_historia_clinica']);
			    $mensaje = 'Registro agregado correctamente';
			}else {
			    $estado = 'ERROR';
			    $mensaje = 'Error al guardar los datos !!';
			}
		}
		else
		{
			$estado = 'ERROR';
			$mensaje = 'Debe crear la historia clínica !!';
		}
		echo json_encode(array(
			'estado' => $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido
		));
	}

	public function eliminarEnfermedadActual() 
	{
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';

	    if(isset($_POST['id_actividad_enfermedad']) && isset($_POST['id_historia_clinica']))
	    {
	        $this->lNegocioActividadEnfermedad->borrar($_POST['id_actividad_enfermedad']);
	        $contenido = $this->listarEnfermedadActual($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	public function listarEnfermedadActual($idHistoriaClinica=null,$opt=1)
	{
	    $datos=$html='';
	    if($idHistoriaClinica != null){
		$consulta = $this->lNegocioActividadEnfermedad->buscarLista("id_historia_clinica =".$idHistoriaClinica." and tipo = 'E' order by 1 ");
		if($consulta->count()){
			foreach ($consulta as $item) {
				$datos .= '<tr>';
				$datos .= '<td>'.$item->descripcion.'</td>';
				if($opt){
	    			$datos .= '<td><button class="bEliminar icono" onclick="eliminarEnfermedadActual('.$item->id_actividad_enfermedad.'); return false; "></button></td>';
				}else{
				    $datos .= '<td></td>';
				}
				$datos .= '<tr>';
			}
			
		$html = '
				<table style="width: 100%;">
					<thead><tr>
						<th>Descripción</th>
						<th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>
          ';
		 }
	    }
		return $html;
	}


	//>>>>>>>>>>>>>>>>>>>>>>>>>>>> Recomendacion y Tratamiento  >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	public function agregarRecomendacionTratamiento() 
	{
		$estado = 'EXITO';
		$mensaje = '';
		$contenido = '';
		
		if(isset($_POST['id_historia_clinica']) && !empty($_POST['id_historia_clinica'])){
			$resultado = $this->lNegocioRecomendaciones->guardar($_POST);
			if($resultado){
			    $contenido = $this->listarRecomendacionTratamiento($_POST['id_historia_clinica']);
			    $mensaje = 'Registro agregado correctamente';
			}else {
			    $estado = 'ERROR';
			    $mensaje = 'Error al guardar los datos !!';
			}
		}
		else
		{
			$estado = 'ERROR';
			$mensaje = 'Debe crear la historia clínica !!';
		}
		echo json_encode(array(
			'estado' => $estado,
			'mensaje' => $mensaje,
			'contenido' => $contenido
		));
	}

	public function eliminarRecomendacionTratamiento() 
	{
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';

	    if(isset($_POST['id_recomendaciones']) && isset($_POST['id_historia_clinica']))
	    {
	        $this->lNegocioRecomendaciones->borrar($_POST['id_recomendaciones']);
	        $contenido = $this->listarRecomendacionTratamiento($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	public function listarRecomendacionTratamiento($idHistoriaClinica=null,$opt=1)
	{
	    $datos=$html='';
	    if($idHistoriaClinica != null){
		$consulta = $this->lNegocioRecomendaciones->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
		if($consulta->count()){
			foreach ($consulta as $item) {
				$datos .= '<tr>';
				$datos .= '<td>'.$item->descripcion.'</td>';
				if($opt){
	    			$datos .= '<td><button class="bEliminar icono" onclick="eliminarRecomendacionTratamiento('.$item->id_recomendaciones.'); return false; "></button></td>';
				}else{
				    $datos .= '<td></td>';
				}
				$datos .= '<tr>';
			}
			
		$html = '
				<table style="width: 100%;">
					<thead><tr>
						<th>Descripción</th>
						<th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>
          ';
		 }
	    }
		return $html;
	}

//>>>>>>>>>>>>>>>>>>>>>>>>>>>> accidente laboral >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

	/**
	 * funcion para agregar accidente en paciente
	 */
	public function agregarAccidente() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    if(isset($_POST['id_historia_clinica']) && isset($_POST['id_historia_ocupacional'])){
	        if(!empty($_POST['id_historia_clinica'])){
    	        $resultado = $this->lNegocioAccidentesLaborales->guardar($_POST);
    	        if($resultado > 0){
    	            $contenido = $this->listarAccidenteLaboral($_POST['id_historia_clinica']);
    	            $mensaje = 'Registro agregado correctamente';
    	        }else {
    	            $estado = 'ERROR';
    	            $mensaje = 'Error al guardar los datos !!';
    	        }
	        }else{
	            $estado = 'ERROR';
	            $mensaje = 'Debe crear la historia clínica !!';
	        }
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * funcion para eliminar accidente en paciente
	 */
	public function eliminarAccidente() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    if(isset($_POST['id_accidentes_laborales']) && isset($_POST['id_historia_clinica'])){
	        $this->lNegocioAccidentesLaborales->borrar($_POST['id_accidentes_laborales']);
	        $contenido = $this->listarAccidenteLaboral($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	
	/**
	 * listar accdientes laborales
	 */
	public function listarAccidenteLaboral($idHistoriaClinica=null,$opt=1){
	    $datos=$html='';
	    if($idHistoriaClinica != null){
	    $consulta = $this->lNegocioAccidentesLaborales->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
	    if($consulta->count()){
	        foreach ($consulta as $item) {
	            $historiaOcupacional =	$this->lNegocioHistoriaOcupacional->buscar($item->id_historia_ocupacional);
	            $datos .= '<tr>';
	            $datos .= '<td>'.$item->reportado_iess.'</td>';
	            $datos .= '<td>'.$item->instituto_seguridad.'</td>';
	            $datos .= '<td>'.$item->fecha_trabajo_accidente.'</td>';

	            if($opt){
	               $datos .= '<td><button class="bEliminar icono" onclick="eliminarAccidente('.$item->id_accidentes_laborales.'); return false; "></button></td>';
	            }else{
	               $datos .='<td></td>'; 
	            }
	            $datos .= '<tr>';
	        }
	        
	        $html = '
				<table style="width: 100%;">
					<thead><tr>
						<th>Instituto de seguridad Social</th>
						<th>Especificar</th>
						<th>Fecha</th>
						<th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>
					    
           ';
	      }
	    }
	    return $html;
	}
	

	/**
	 * funcion para eliminar enfermedad
	 */
	public function agregarEnfermedad() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    if(isset($_POST['id_historia_clinica'])){
	        if(!empty($_POST['id_historia_clinica'])){
    	        $resultado = $this->lNegocioEnfermedadProfesional->guardar($_POST);
    	        if($resultado > 0){
    	            $contenido = $this->listarEnfermedadesProfesionales($_POST['id_historia_clinica']);
    	            $mensaje = 'Registro agregado correctamente';
    	        }else {
    	            $estado = 'ERROR';
    	            $mensaje = 'Error al guardar los datos !!';
    	        }
	        }else{
	            $estado = 'ERROR';
	            $mensaje = 'Debe crear la historia clínica !!';
	        }
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * funcion para eliminar enfermedad
	 */
	public function eliminarEnfermedad() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    if(isset($_POST['id_enfermedad_profesional']) && isset($_POST['id_historia_clinica'])){
	        $this->lNegocioEnfermedadProfesional->borrar($_POST['id_enfermedad_profesional']);
	        $contenido = $this->listarEnfermedadesProfesionales($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	public function listarEnfermedadesProfesionales($idHistoriaClinica=null,$opt=1){
	    $datos=$html='';
	    if($idHistoriaClinica != null){
	    $consulta = $this->lNegocioEnfermedadProfesional->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
	    if($consulta->count()){
	        foreach ($consulta as $item) {
	            $datos .= '<tr>';
	            $datos .= '<td>'.$item->reportado_iess_enfermedad.'</td>';
	            $datos .= '<td>'.$item->instituto_seguridad_enfermedad.'</td>';
	            $datos .= '<td>'.$item->fecha_diagnostico.'</td>';

	            if($opt){
	               $datos .= '<td><button class="bEliminar icono" onclick="eliminarEnfermedad('.$item->id_enfermedad_profesional.'); return false; "></button></td>';
	            }else{
	               $datos .='<td></td>'; 
	            }
	            $datos .= '<tr>';
	        }
	        
	        $html = '
				<table style="width: 100%;">
					<thead><tr>
						<th>Instituto de seguridad Social</th>
						<th>Especificar</th>
						<th>Fecha</th>
						<th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>
					    
           ';
	      }
	    }
	    return $html;
	}

	/**
	 * crear elementos de protección
	 */
	public function listarElementosProteccion($idHistoriaClinica=null){
	  
	    $arrayIndex = "nombre ='Elementos de protección'";
	    $procedi = $this->lNegocioProcedimientoMedico->buscarLista($arrayIndex);
	    $arrayIndex = "id_procedimiento_medico =".$procedi->current()->id_procedimiento_medico."";
	    $tipo = $this->lNegocioTipoProcedimientoMedico->buscarLista($arrayIndex);
	    $datos='';
	    $i=0;
	    foreach ($tipo as $item) {
	        if($i==0){
	            $datos .= '<tr>';
	        }
	        if($idHistoriaClinica != null){
	            $elementos = $this->lNegocioElementoProteccion->buscarLista("id_historia_clinica=".$idHistoriaClinica." and id_tipo_procedimiento_medico=".$item->id_tipo_procedimiento_medico);
	            if($elementos->count()){
	                $datos .= '<td><input class="elemProte" checked name="elementoProteccion[]" type="checkbox" value="'.$item->id_tipo_procedimiento_medico.'"> '.$item->tipo.'</td>';
	            }else{
	                $datos .= '<td><input class="elemProte" name="elementoProteccion[]" type="checkbox" value="'.$item->id_tipo_procedimiento_medico.'"> '.$item->tipo.'</td>';
	            }
	        }else{
	            $datos .= '<td><input class="elemProte" name="elementoProteccion[]" type="checkbox" value="'.$item->id_tipo_procedimiento_medico.'"> '.$item->tipo.'</td>';
	            }
	        
	         $i++;
	        if($i==3){
	            $datos .= '<tr>';
	            $i=0;
	        }
	    }
	    
	    $html = '
			<table  style="width: 100%;">
			'.$datos.'
			</table>
         ';
	    return $html;
	}
	
	/**
	 * Combo de tipo de procedimiento
	 */
	public function comboTipoProcedimiento($tipo,$idTipoProcedimientoMedico=null)
	{
	    $arrayIndex = "nombre ='".$tipo."' and estado='Activo'";
	    $procedi = $this->lNegocioProcedimientoMedico->buscarLista($arrayIndex);
	    if($procedi->count()){
	       $tipoProce = $this->lNegocioTipoProcedimientoMedico->buscarLista("id_procedimiento_medico =".$procedi->current()->id_procedimiento_medico." and estado='Activo' order by 1");
	    }
	    $combo = '<option value="">Seleccionar....</option>';
	    foreach ($tipoProce as $item)
	    {
	        if ($idTipoProcedimientoMedico == $item->id_tipo_procedimiento_medico)
	        {
	            $combo .= '<option value="' . $item->id_tipo_procedimiento_medico . '" selected>' . $item->tipo. '</option>';
	        } else
	        {
	            $combo .= '<option value="' . $item->id_tipo_procedimiento_medico . '">' . $item->tipo . '</option>';
	        }
	    }
	    return $combo;
	}

	/**
	 * combo cie 10
	 */
	public function comboCie10($opt, $idCie10=null){
	    $cie10 = $this->lNegocioCie->buscarLista("estado='Activo' order by 1");
	    $combo = '<option value="">Seleccionar....</option>';
	            foreach ($cie10 as $item) {
	                if($opt == 'codigo'){
	                    $text = $item->codigo;
	                }else{
	                    $text = $item->descripcion;
	                }
	                if ($idCie10 == $item->id_cie)
	                {
	                    $combo .= '<option value="' . $item->id_cie . '" selected>' . $text . '</option>';
	                } else
	                {
	                    $combo .= '<option value="' . $item->id_cie . '">' . $text . '</option>';
	                }
	            }
	    return $combo;
	}

	public function comboOrigenParentesco($tipo=null){
	    $parentesco = array('Materno', 'Paterno');
	    $combo = '<option value="">Seleccionar....</option>';
	            foreach ($parentesco as $item) {
	                if ($tipo == $item)
	                {
	                    $combo .= '<option value="' . $item . '" selected>' . $item . '</option>';
	                } else
	                {
	                    $combo .= '<option value="' . $item . '">' . $item . '</option>';
	                }
	            }
	    return $combo;
	}

	public function comboTipoEnfermedad($tipo=null){
	    $tipo = array('1. Enfermedad cardiovascular', '2. Enfermedad metabólica', '3. Enfermedad neurológica', '4. Enfermedad oncológica', '5. Enfermedad infecciosa','6. Enfermedad hereditaria / congénita', '7. Discapacidades', '8. Otros');
	    $combo = '<option value="">Seleccionar....</option>';
	            foreach ($tipo as $item) {
	                if ($tipo == $item)
	                {
	                    $combo .= '<option value="' . $item . '" selected>' . $item . '</option>';
	                } else
	                {
	                    $combo .= '<option value="' . $item . '">' . $item . '</option>';
	                }
	            }
	    return $combo;
	}

	public function comboTipoDiscapacidad($tipo=null){
	    $cie10 = array('Auditiva', 'Física', 'Intelectual', 'Lenguaje', 'Psicosocial', 'Visual', 'Múltiple');
	    $combo = '<option value="">Seleccionar....</option>';
	            foreach ($cie10 as $item) {
	                if ($tipo == $item)
	                {
	                    $combo .= '<option value="' . $item . '" selected>' . $item . '</option>';
	                } else
	                {
	                    $combo .= '<option value="' . $item . '">' . $item . '</option>';
	                }
	            }
	    return $combo;
	}

	public function comboAptitud($tipo=null){
	    $cie10 = array('Apto', 'Apto en observación', 'Apto con limitaciones', 'No apto');
	    $combo = '<option value="">Seleccionar....</option>';
	            foreach ($cie10 as $item) {
	                if ($tipo == $item)
	                {
	                    $combo .= '<option value="' . $item . '" selected>' . $item . '</option>';
	                } else
	                {
	                    $combo .= '<option value="' . $item . '">' . $item . '</option>';
	                }
	            }
	    return $combo;
	}

	
	/**
	 * funcion para agregar accidente en paciente
	 */
	public function agregarAntecedentesFamiliares() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if(isset($_POST['id_historia_clinica']) && isset($_POST['id_tipo_procedimiento_medico'])){
	        if(!empty($_POST['id_historia_clinica'])){
    	        $arrayIndex = "nombre ='Parentesco'";
    	        $procedi = $this->lNegocioProcedimientoMedico->buscarLista($arrayIndex);
    	        $_POST['id_procedimiento_medico'] = $procedi->current()->id_procedimiento_medico;
    	        $resultado = $this->lNegocioAntecedentesSaludFamiliar->guardar($_POST);
    	        if($resultado > 0){
    	            $contenido = $this->listarAntecedentesFamiliares($_POST['id_historia_clinica']);
    	            $mensaje = 'Registro agregado correctamente';
    	        }else {
    	            $estado = 'ERROR';
    	            $mensaje = 'Error al guardar los datos !!';
    	        }
    	        
        	    }else{
        	        $estado = 'ERROR';
        	        $mensaje = 'Debe crear la historia clínica !!';
        	    }
        }else{
            $estado = 'ERROR';
            $mensaje = 'Debe crear la historia clínica !!';
        }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * funcion para eliminar accidente en paciente
	 */
	public function eliminarAntecedentesFamiliares() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    if(isset($_POST['id_anteced_salud_familiar']) && isset($_POST['id_historia_clinica'])){
	        $this->lNegocioAntecedentesSaludFamiliar->borrar($_POST['id_anteced_salud_familiar']);
	        $contenido = $this->listarAntecedentesFamiliares($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	
	/**
	 * listar accdientes laborales
	 */
	public function listarAntecedentesFamiliares($idHistoriaClinica=null,$opt=1){
	    $datos=$html='';
	    if($idHistoriaClinica != null){
	    $consulta = $this->lNegocioAntecedentesSaludFamiliar->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
	    if($consulta->count()){
	        foreach ($consulta as $item) {
	            $parentesco =	$this->lNegocioTipoProcedimientoMedico->buscar($item->id_tipo_procedimiento_medico);
	            $datos .= '<tr>';
	            $datos .= '<td>'.$item->tipo_enfermedad_familiar.'</td>';
	            $datos .= '<td>'.$parentesco->getTipo().'</td>';
	            $datos .= '<td>'.$item->origen_parentesco.'</td>';
	            if($opt){
	               $datos .= '<td><button class="bEliminar icono" onclick="eliminarAntecedentesFamiliares('.$item->id_anteced_salud_familiar.'); return false; "></button></td>';
	            }else{
	               $datos .= '<td></td>';
	                
	            }
	            $datos .= '<tr>';
	        }
	        
	        $html = '
				<table style="width:100%">
					<thead><tr>
						<th>Tipo de enfermedad</th>
						<th>Parentesco</th>
						<th>Origen de parentesco</th>
						<th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>
           ';
	      }
	    }
	    return $html;
	}

	/**
	 * Buscar examenes realizados
	 */
	public function buscarExamenesRealizados() {
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if($_POST['id_historia_clinica'] != null && $_POST['tipo_examen_realizado'] != null){
	        
	        $contenido = $this->crearHtmlExamenesRealizados($_POST['tipo']);
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	/**
	 * mostrar inputs de examenes realizados
	 */
	public function crearHtmlExamenesRealizados($tipo) {

	    $txt = '
                <legend>'.$tipo.'</legend>
        		<div data-linea="4">
        			<label for="examen_tiempo">Tiempo (años):</label>
        			<input type="number" id="examen_tiempo" name="examen_tiempo" value=""/>
        		</div>
        		<div data-linea="5">
        			<label for="examen_resultado">Resultado:</label>
        			<input type="text" id="examen_resultado" name="examen_resultado" value="" maxlength="256" />
        		</div>		
                <div data-linea="6">
                		<button class="mas" onclick="agregarExamenesRealizados(); return false;">Agregar</button>
                </div>';
	    return $txt;
	    
	}

	/**
	 * funcion para agregar examenes realizados
	 */
	public function agregarExamenesRealizados() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if(isset($_POST['id_historia_clinica']) && !empty($_POST['id_historia_clinica']))
	    {
    	        $resultado = $this->lNegocioExamenRealizado->guardar($_POST);
    	        if($resultado)
    	        {
    	            $contenido = $this->listarExamenesRealizados($_POST['id_historia_clinica']);
    	            $mensaje = 'Registro agregado correctamente';
    	        }
    	        else 
    	        {
    	            $estado = 'ERROR';
    	            $mensaje = 'Error al guardar los datos !!';
    	        }
	    }
	    else
	    {
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	/**
	 * funcion para eliminar examenes realizados
	 */
	public function eliminarExamenRealizado() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    if(isset($_POST['id_historia_clinica'])){
	        
	        $this->lNegocioExamenRealizado->borrar($_POST['id_examen_realizado']);
	        $contenido = $this->listarExamenesRealizados($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	/**
	 * listar Examenes Realizados
	 */
	public function listarExamenesRealizados($idHistoriaClinica=null,$opt=1){
	    $datos=$html='';
	    if($idHistoriaClinica != null){
	        $consulta = $this->lNegocioExamenRealizado->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
	        if($consulta->count()){
	            foreach ($consulta as $item){

	                $datos .= '<tr>';
	                $datos .= '<td>'.$item->tipo_examen.'</td>';
	                $datos .= '<td>'.$item->tiempo_anios.'</td>';
	                $datos .= '<td>'.$item->resultado.'</td>';
	               
	                if($opt)
	                {
	                    $datos .= '<td><button class="bEliminar icono" onclick="eliminarExamenRealizado('.$item->id_examen_realizado.'); return false; "></button></td>';
	                }
	                else
	                {
	                    $datos .= '<td></td>';
	                }

	                $datos .= '<tr>';
	            }
	            
	            $html = '
				<table style="width:100%">
					<thead><tr>
						<th>Exámen realizado</th>
						<th>Tiempo</th>
						<th>Resultado</th>
						<th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>
           ';
	        }
	    }
	    return $html;
	}



////////////////////////////////////////INICIO METODO PLANIFICACION ////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Buscar metodo planificacion
	 */
	public function buscarMetodoPlanificacion() {
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if($_POST['id_historia_clinica'] != null && $_POST['tipo_metodo_planificacion'] != null){
	        
	        $contenido = $this->crearHtmlMetodoPlanificacion($_POST['tipo']);
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	/**
	 * mostrar inputs de metodo planificacion
	 */
	public function crearHtmlMetodoPlanificacion($tipo) {

		switch ($tipo) 
		{
	        case 'Otros':
				    $txt = '
			                <legend>'.$tipo.'</legend>
			                <div data-linea="4">
			        			<label for="otro_metodo">Otros métodos:</label>
			        			<input type="text" id="otro_metodo" name="otro_metodo" value="" maxlength="32"/>
			        		</div>
			        		<div data-linea="4">
			        			<label for="hijos_vivos">Hijos vivos:</label>
			        			<input type="number" id="hijos_vivos" name="hijos_vivos" value=""/>
			        		</div>
			        		<div data-linea="5">
			        			<label for="hijos_muertos">Hijos muertos:</label>
			        			<input type="number" id="hijos_muertos" name="hijos_muertos" value="" />
			        		</div>		
			                <div data-linea="6">
			                		<button class="mas" onclick="agregarMetodoPlanificacion(); return false;">Agregar</button>
			                </div>';
			                break;
			default:
					 $txt = '
			                <legend>'.$tipo.'</legend>
			        		<div data-linea="4">
			        			<label for="hijos_vivos">Hijos vivos:</label>
			        			<input type="number" id="hijos_vivos" name="hijos_vivos" value=""/>
			        		</div>
			        		<div data-linea="5">
			        			<label for="hijos_muertos">Hijos muertos:</label>
			        			<input type="number" id="hijos_muertos" name="hijos_muertos" value="" />
			        		</div>		
			                <div data-linea="6">
			                		<button class="mas" onclick="agregarMetodoPlanificacion(); return false;">Agregar</button>
			                </div>';
			         		break;
		}
	    return $txt;
	    
	}

	/**
	 * funcion para agregar metodo planificacion
	 */
	public function agregarMetodoPlanificacion() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if(isset($_POST['id_historia_clinica']) && !empty($_POST['id_historia_clinica']))
	    {
    	        $resultado = $this->lNegocioMetodoPlanificacion->guardar($_POST);
    	        if($resultado)
    	        {
    	            $contenido = $this->listarMetodoPlanificacion($_POST['id_historia_clinica']);
    	            $mensaje = 'Registro agregado correctamente';
    	        }
    	        else 
    	        {
    	            $estado = 'ERROR';
    	            $mensaje = 'Error al guardar los datos !!';
    	        }
	    }
	    else
	    {
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	/**
	 * funcion para eliminar metodo planificacion
	 */
	public function eliminarMetodoPlanificacion() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    if(isset($_POST['id_historia_clinica'])){
	        
	        $this->lNegocioMetodoPlanificacion->borrar($_POST['id_metodo_planificacion']);
	        $contenido = $this->listarMetodoPlanificacion($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	/**
	 * listar metodo planificacion
	 */
	public function listarMetodoPlanificacion($idHistoriaClinica=null,$opt=1){
	    $datos=$html='';
	    if($idHistoriaClinica != null){
	        $consulta = $this->lNegocioMetodoPlanificacion->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
	        if($consulta->count()){
	            foreach ($consulta as $item){

	                $datos .= '<tr>';
	                $datos .= '<td>'.$item->tipo_metodo.'</td>';
	                $datos .= '<td>'.$item->hijos_vivos.'</td>';
	                $datos .= '<td>'.$item->hijos_muertos.'</td>';
	               
	                if($opt)
	                {
	                    $datos .= '<td><button class="bEliminar icono" onclick="eliminarMetodoPlanificacion('.$item->id_metodo_planificacion.'); return false; "></button></td>';
	                }
	                else
	                {
	                    $datos .= '<td></td>';
	                }

	                $datos .= '<tr>';
	            }
	            
	            $html = '
				<table style="width:100%">
					<thead><tr>
						<th>Método planificación</th>
						<th>Hijos vivos</th>
						<th>Hijos muertos</th>
						<th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>
           ';
	        }
	    }
	    return $html;
	}


	///////////////////////////////////////////////FIN METODOS PLANIFICACION //////////////////////////////////////////////////////////



	/**
	 * Buscar antecedentes de salud
	 */
	public function buscarAntecedentesSalud() {
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if($_POST['id_historia_clinica'] != null && $_POST['id_tipo_procedimiento_medico'] != null){
	        
	        $contenido = $this->crearHtmlAntecedentesSalud($_POST['tipo']);
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}


	/**
	 * mostrar inputs de ingreso antecedentes de salud
	 */
	public function crearHtmlAntecedentesSalud($tipo) {
	    switch ($tipo) {
	        case 'Clínicos':
	        $txt = '
                <legend>'.$tipo.'</legend>
                <div data-linea="3">
        			<label for="enfermedad_general_salud">Enfermedad General: </label>
        			<select id="enfermedad_general_salud" name= "enfermedad_general_salud" >
        				'. $this->comboCie10('descripcion').'
        			</select>
        		</div>				
        
        		<div data-linea="3">
        			<label for="id_cie_salud">Código CIE 10:</label>
        			<select id="id_cie_salud" name= "id_cie_salud" >
        				'. $this->comboCie10('codigo').'
        			</select>
        		</div>		
        		
        		<div data-linea="4">
        			<label for="diagnostico_salud">Diagnóstico:</label>
        			<input type="text" id="diagnostico_salud" name="diagnostico_salud" value=""
        			placeholder="Diagnostico" maxlength="64" />
        		</div>		
        		<div data-linea="5">
        			<label for="observaciones_salud">Observaciones:</label>
        			<input type="text" id="observaciones_salud" name="observaciones_salud" value=""
        			placeholder="Observaciones" maxlength="256" />
        		</div>			
                <div data-linea="6">
                		<button class="mas" onclick="agregarAntecedentesSalud(); return false;">Agregar</button>
                		</div>';
	        break;
	        case 'Gineco Obstétricos':
	            $txt = '
                    <legend>'.$tipo.'</legend>

                    <div data-linea="1">
            			<label for="menarquia">Menarquia:</label>
            			<select id="menarquia" name= "menarquia" >
        				'. $this->comboMenarquia().'
        			    </select>
            		</div>

                    <div data-linea="1">
            			<label for="ciclo_mestrual">Ciclos:</label>
            			<select id="ciclo_mestrual" name= "ciclo_mestrual" >
        				'. $this->comboCicloMestrual().'
        			    </select>
            		</div>				
            
            		<div data-linea="1">
            			<label for="fecha_ultima_regla">Fecha de la útima menstruación: </label>
            			<input type="text" id="fecha_ultima_regla" name="fecha_ultima_regla" value=""
            			 maxlength="13" readonly/>
            		</div>								
            
            		<div data-linea="2">
            			<label for="numero_gestaciones">N° de gestas:</label>
            			<select id="numero_gestaciones" name= "numero_gestaciones" >
        				'. $this->comboNumeros(10,0).'
        			    </select>
            		</div>				
            
            		<div data-linea="2">
            			<label for="numero_partos">N° Partos:</label>
            			<select id="numero_partos" name= "numero_partos" >
        				'. $this->comboNumeros(10,0).'
        			    </select>
            		</div>				
            
            		<div data-linea="2">
            			<label for="numero_cesareas">N° Cesáreas:</label>
            			<select id="numero_cesareas" name= "numero_cesareas" >
        				'. $this->comboNumeros(10,0).'
        			    </select>
            		</div>				
            
            		<div data-linea="3">
            			<label for="numero_abortos">N° Abortos:</label>
            			<select id="numero_abortos" name= "numero_abortos" >
        				'. $this->comboNumeros(10,0).'
        			    </select>
            		</div>				
            
            		<div data-linea="3">
            			<label for="numero_hijos_vivos">N° Hijos vivos: </label>
            			<select id="numero_hijos_vivos" name= "numero_hijos_vivos" >
        				'. $this->comboNumeros(10,0).'
        			    </select>
            		</div>				
            
            		<div data-linea="3">
            			<label for="numero_hijos_muertos">N° Hijos muertos: </label>
            			<select id="numero_hijos_muertos" name= "numero_hijos_muertos" >
        				'. $this->comboNumeros(10,0).'
        			    </select>
            		</div>

            		<div data-linea="4">
            			<label for="vida_sexual_activa">Vida sexual activa: </label>
            			<select id="vida_sexual_activa" name= "vida_sexual_activa" >
        				'. $this->comboOpcion().'
        			    </select>
            		</div>				
            
            		<div data-linea="4">
            			<label for="planificacion_familiar">Método de planificación familiar: </label>
            			<select id="planificacion_familiar" name= "planificacion_familiar" >
        				'. $this->comboOpcion().'
        			    </select>
            		</div>

            		<div data-linea="5">
            			<label for="tipo_planificacion_familiar">Tipo: </label>
            			<select id="tipo_planificacion_familiar" name= "tipo_planificacion_familiar" disabled>
        				'. $this->comboMetodosPlanificacion().'
        			    </select>
            		</div>

            		<div data-linea="5">
            			<label for="metodo_planificacion">Otros métodos: </label>
            			<input type="text" id="metodo_planificacion" name="metodo_planificacion" value="" maxlength="32" disabled/>
            		</div>

            		<div data-linea="6">
            			<label for="embarazo">¿Embarazo?: </label>
            			<select id="embarazo" name= "embarazo" >
        				'. $this->comboOpcion().'
        			    </select>
            		</div>	
            		<div data-linea="6">
            			<label for="semanas_gestacion">Semanas de gestación: </label>
            			<select id="semanas_gestacion" name= "semanas_gestacion" disabled>
        				'. $this->comboNumeros(40,1).'
        			    </select>
            		</div>				
            
            		<div data-linea="7">
            			<label for="numero_ecos">N° Ecos: </label>
            			<select id="numero_ecos" name= "numero_ecos" disabled>
        				'. $this->comboNumeros(20,1).'
        			    </select>
            		</div>
            		<div data-linea="7">
            			<label for="numero_controles_embarazo">N° Controles embarazo: </label>
            			<select id="numero_controles_embarazo" name= "numero_controles_embarazo" disabled>
        				'. $this->comboNumeros(20,1).'
        			    </select>
            		</div>				
            
            		<div data-linea="8">
            			<label for="complicaciones">Complicaciones: </label>
            			<input type="text" id="complicaciones" name="complicaciones" value=""
            			placeholder="Complicaciones" maxlength="64" disabled/>
            		</div>

            		<div data-linea="9">
                    		<button class="mas" onclick="agregarAntecedentesSalud(); return false;">Agregar</button>
                    </div>
                ';
	        break;
	        
	        default:
	            $txt = '
                <legend>'.$tipo.'</legend>
        		<div data-linea="4">
        			<label for="diagnostico_salud">Diagnóstico:</label>
        			<input type="text" id="diagnostico_salud" name="diagnostico_salud" value=""
        			placeholder="Diagnostico" maxlength="64" />
        		</div>
        		<div data-linea="5">
        			<label for="observaciones_salud">Observaciones:</label>
        			<input type="text" id="observaciones_salud" name="observaciones_salud" value=""
        			placeholder="Observaciones" maxlength="256" />
        		</div>		
                <div data-linea="6">
                		<button class="mas" onclick="agregarAntecedentesSalud(); return false;">Agregar</button>
                		</div>	';
	        break;
	    }
	    return $txt;
	    
	}
	/**
	 * funcion para agregar accidente en paciente
	 */
	public function agregarAntecedentesSalud() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if(isset($_POST['id_historia_clinica'])){
	        if(!empty($_POST['id_historia_clinica'])){
    	        $arrayIndex = "nombre ='Antecedentes de salud'";
    	        $procedi = $this->lNegocioProcedimientoMedico->buscarLista($arrayIndex);
    	        $_POST['id_procedimiento_medico'] = $procedi->current()->id_procedimiento_medico;
    	        $resultado = $this->lNegocioAntecedentesSalud->guardarAntecedentesDetalle($_POST);
    	        if($resultado){
    	            $contenido = $this->listarAntecedentesSalud($_POST['id_historia_clinica']);
    	            $mensaje = 'Registro agregado correctamente';
    	        }else {
    	            $estado = 'ERROR';
    	            $mensaje = 'Error al guardar los datos !!';
    	        }
    	    }else{
    	        $estado = 'ERROR';
    	        $mensaje = 'Debe crear la historia clínica !!';
    	    }
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * funcion para eliminar antecedentes de salud
	 */
	public function eliminarAntecedentesSalud() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    if(isset($_POST['id_antecedentes_salud']) && isset($_POST['id_historia_clinica'])){
	        
	        $this->lNegocioDetalleAntecedentesSalud->borrarPorParametro("id_antecedentes_salud", $_POST['id_antecedentes_salud']);
	        $this->lNegocioAntecedentesSalud->borrar($_POST['id_antecedentes_salud']);
	        $contenido = $this->listarAntecedentesSalud($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	
	/**
	 * listar antecedentes de salud
	 */
	public function listarAntecedentesSalud($idHistoriaClinica=null,$opt=1){
	    $datos=$html='';
	    if($idHistoriaClinica != null){
	        $consulta = $this->lNegocioAntecedentesSalud->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
	        if($consulta->count()){
	            foreach ($consulta as $item) {
	                $antecedente =	$this->lNegocioTipoProcedimientoMedico->buscar($item->id_tipo_procedimiento_medico);
	                $detalle = $this->lNegocioDetalleAntecedentesSalud->buscarLista("id_antecedentes_salud =".$item->id_antecedentes_salud);
	                if( $antecedente->getTipo() == 'Gineco Obstétricos'){
	                    $prev = '<button class="bPrevisualizar icono" title="Información completa" onclick="informacionAntecedentesSalud('.$item->id_antecedentes_salud.'); return false; "></button>';
	                }
	                else{
	                	$prev = '';
	                }
                	$datos .= '<tr>';
	                $datos .= '<td>'.$antecedente->getTipo().'</td>';
	                $datos .= '<td>'.$detalle->current()->diagnostico.'</td>';
	                $datos .= '<td>'.$detalle->current()->observaciones.'</td>';
	                $datos .= '<td>'.$prev.'</td>';
	                
	                if($opt){
	                    $datos .= '<td><button class="bEliminar icono" onclick="eliminarAntecedentesSalud('.$item->id_antecedentes_salud.'); return false; "></button></td>';
	                }
	                else{
	                    $datos .= '<td></td>';
	                }
	                $datos .= '<tr>';
	            }
					$html = '<table style="width:100%">
							<thead><tr>
								<th>Tipo de antecedente</th>
								<th>Diagnóstico</th>
								<th>Observaciones</th>
								<th></th>
								<th></th>
								</tr></thead>
							<tbody>'.$datos.'</tbody>
						</table>';
	        }
	    }
	    return $html;
	}
	/**
	 * Muestra el modal de previsualizacion de detalle de antecedentes de salud
	 */
	public function informacionAntecedentesSalud(){
	    
	    $this->detalleAntecedentes = $this->listarDetalleAntecedentesSalud($_POST['id_antecedentes_salud']);
	    require APP . 'HistoriasClinicas/vistas/formularioDetalleAntecedentesSaludGineco.php';
	}
	
	/**
	 * listar detalle de antecedentes de salud
	 */
	public function listarDetalleAntecedentesSalud($idAntecedentesSalud=null){
	    $datos='';
	    if($idAntecedentesSalud != null){
	        $consulta = $this->lNegocioAntecedentesSalud->buscar($idAntecedentesSalud);
	        if($consulta){
	            $detalle = $this->lNegocioDetalleAntecedentesSalud->buscarLista("id_antecedentes_salud =".$consulta->getIdAntecedentesSalud());
	            foreach ($detalle as $item) {
    	                $datos .= '<tr>';
    	                $datos .= '<td>'.date('Y-m-d',strtotime($consulta->getFechaCreacion())).'</td>';
    	                $datos .= '<td>'.$item->menarquia.'</td>';
    	                $datos .= '<td>'.$item->ciclo_mestrual.'</td>';
    	                $datos .= '<td>'.$item->fecha_ultima_regla.'</td>';
    	                $datos .= '<td>'.$item->numero_gestaciones.'</td>';
    	                $datos .= '<td>'.$item->numero_partos.'</td>';
    	                $datos .= '<td>'.$item->numero_cesareas.'</td>';
    	                $datos .= '<td>'.$item->numero_abortos.'</td>';
    	                $datos .= '<td>'.$item->numero_hijos_vivos.'</td>';
    	                $datos .= '<td>'.$item->numero_hijos_muertos.'</td>';
    	                $datos .= '<td>'.$item->embarazo.'</td>';
    	                $datos .= '<td>'.$item->semanas_gestacion.'</td>';
    	                $datos .= '<td>'.$item->numero_ecos.'</td>';
    	                $datos .= '<td>'.$item->numero_controles_embarazo.'</td>';
    	                $datos .= '<td>'.$item->complicaciones.'</td>';
    	                $datos .= '<td>'.$item->vida_sexual_activa.'</td>';
    	                $datos .= '<td>'.$item->planificacion_familiar.'</td>';
    	                $datos .= '<td>'.$item->tipo_planificacion_familiar.'</td>';
    	                $datos .= '<td>'.$item->metodo_planificacion.'</td>';
    	                $datos .= '<tr>';
	            }
	        }
	    }
	    return $datos;
	}
	/**
	 * crear elementos de revisión por aparatos
	 */
	public function listarElementosPorAparatos($idHistoriaClinica=null){
	    
	    $procedi = $this->lNegocioProcedimientoMedico->buscarLista("nombre ='Revisión por aparatos' and estado ='Activo'");
	    $arrayIndex = "id_procedimiento_medico =".$procedi->current()->id_procedimiento_medico." and estado ='Activo' order by 5";
	    $tipo = $this->lNegocioTipoProcedimientoMedico->buscarLista($arrayIndex);
	    $datos='';
	    $i=0;
	    $arraySub = array();

	    $categoriaAnterior = '';
	    $categoriaNueva = '';

	    foreach ($tipo as $item) {
	        $arraySub [$i] = [$item->id_tipo_procedimiento_medico,$item->tipo];
	        $subtipo = $this->lNegocioSubtipoProcedimientoMedico->buscarLista("id_tipo_procedimiento_medico = ".$item->id_tipo_procedimiento_medico." and estado ='Activo' order by 6");
	        $controlarOtros = 0;

	        foreach ($subtipo as $sub) {
	        	$categoriaSubtipo =  $this->lNegocioCategoriaSubtipoProcedimiento->buscar($sub->id_categoria_subtipo_procedimiento);
	        	$categoriaNueva = $categoriaSubtipo->descripcion;
	        	if($categoriaAnterior != $categoriaNueva && $categoriaNueva != 'Sin categoria'){
	        		if($controlarOtros > 0){
	        			$arraySub [$i][]= [$item->id_tipo_procedimiento_medico,'Descripción'];
	        		}
	        		$arraySub [$i][]= ['categoriaSubtipo',$categoriaNueva];
	        		$categoriaAnterior = $categoriaNueva;
	        		$controlarOtros++;
	        	}
	            $arraySub [$i][]= [$sub->id_subtipo_proced_medico,$sub->subtipo];
	        }
	        $arraySub [$i][]= [$item->id_tipo_procedimiento_medico,'Descripción'];
	        $prueba = $arraySub[$i];
	        $i++;

	    }

	   $total = $this->lNegocioHistoriaClinica->contarElementosArray($arraySub);
	   
	    $i=$j=$v=$z=0;
	    foreach ($arraySub as $item) {
	        if($i==0){
	            $datos .= '<tr>';
	        }
	        $datos .= '<th> '.$item[1].'</th>';
	        $i++; $z++;

	        if($i==3 || $z==$total){

	            if($z==$total){
	                for($a=0; $a <= ($total-$j*3); $a++){
	                    $datos .='<th></th>';
	                }
	            }

	            $datos .= '</tr>';
	            for($i=0,$x=$v ; $i<3;$x++, $i++){
	                if(isset($arraySub[$x])){
	                $max []= ($this->lNegocioHistoriaClinica->contarElementosArray($arraySub[$x])-2);
	                }
	            }

	            for($p=0; $p < max($max); $p++){
    	            $datos .= '<tr>';
    	            for($i=0,$x=$v ; $i<3;$x++, $i++){
    	                if($i < count($max)){
        	                if($p < $max[$i]){
            	                    if($arraySub[$x][$p+2][1] != 'Descripción'){
            	                    	if($arraySub[$x][$p+2][0] == 'categoriaSubtipo'){
            	                    			$datos .= '<td><strong>'.$arraySub[$x][$p+2][1] .'</strong></td>';
            	                    	}
            	                    	else{
            	                    		$datos .= '<td><input name="revisionAparatos[]" type="checkbox" id="'.$arraySub[$x][0].'" value="'.$arraySub[$x][$p+2][0].'"> '.$arraySub[$x][$p+2][1].'</td>';
            	                    	}  
            	                    }else{
            	                        $datos .= '<td>'.$arraySub[$x][$p+2][1].'<br><input name="revisionAparatosTxt[]" type="text" id="'.$arraySub[$x][$p+2][0].'" maxlength="32"></td>';
            	                    }
        	                    }else{
        	                    $datos .= '<td></td>';
        	                }
    	                }else{
    	                    $datos .= '<td></td>';
    	                }
    	            }
    	            $datos .= '</tr>';
	            }

	            unset($max);
	            $j++;
	            $v=$v+3;
	            $i=0;
	            
	        }

	    }
	    $html = '
			<table  style="width: 100%;">
            <tbody id="bodyOrganos">'.$datos.'</tbody>
			</table>
         ';
	    return $html;
	}
	
	/**
	 * funcion para agregar revision organos sistemas
	 */
	public function agregarRevisionOrganos() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if(isset($_POST['id_historia_clinica']) && (isset($_POST['subtipoList']) || isset($_POST['subtipoTxt']))){
	        if(!empty($_POST['id_historia_clinica'])){
    	        $arrayIndex = "nombre ='Revisión por aparatos'";
    	        $procedi = $this->lNegocioProcedimientoMedico->buscarLista($arrayIndex);
    	        $_POST['id_procedimiento_medico'] = $procedi->current()->id_procedimiento_medico;
    	        $resultado = $this->lNegocioRevisionOrganosSistemas->guardarOrganosSistemasDetalle($_POST);
    	        if($resultado){
    	            $contenido = $this->listarRevisionOrganos($_POST['id_historia_clinica']);
    	            $mensaje = 'Registro agregado correctamente';
    	        }else {
    	            $estado = 'ERROR';
    	            $mensaje = 'Error al guardar los datos !!';
    	        }
	        }else{
	            $estado = 'ERROR';
	            $mensaje = 'Debe crear la historia clínica !!';
	        }
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica o seleccionar un campo!!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * funcion para eliminar revision organos
	 */
	public function eliminarRevisionOrganos() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    if(isset($_POST['id_revision_organos_sistemas']) && isset($_POST['id_historia_clinica'])){
	        
	        $this->lNegocioDetalleRevisionOrganosSistemas->borrarPorParametro("id_revision_organos_sistemas", $_POST['id_revision_organos_sistemas']);
	        $this->lNegocioRevisionOrganosSistemas->borrar($_POST['id_revision_organos_sistemas']);
	        $contenido = $this->listarRevisionOrganos($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * listar organos sistemas
	 */
	public function listarRevisionOrganos($idHistoriaClinica=null,$opt=1){
	    $datos=$html=$subt=$otros='';
	    if($idHistoriaClinica != null){
	        $consulta = $this->lNegocioRevisionOrganosSistemas->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
	        if($consulta->count()){
	            foreach ($consulta as $item) {
	                $tipo =	$this->lNegocioTipoProcedimientoMedico->buscar($item->id_tipo_procedimiento_medico);
	                
	                $detalle = $this->lNegocioDetalleRevisionOrganosSistemas->buscarLista("id_revision_organos_sistemas =".$item->id_revision_organos_sistemas);
	                if($detalle->count()){
	                    $subt=' ';
	                    $ban = false;
	                    foreach ($detalle as $subItem) {
	                        if($ban){
	                            $subt .= ', ';
	                        }
	                        if($subItem->id_subtipo_proced_medico != null){
	                           $subtipo = $this->lNegocioSubtipoProcedimientoMedico->buscar($subItem->id_subtipo_proced_medico);
	                           $subt .= $subtipo->getSubtipo();
	                        }else{
	                            $otros=$subItem->otros;
	                        }
	                        $ban = true;
	                    }
	                }
	                
	                $datos .= '<tr>';
	                $datos .= '<td>'.$tipo->getTipo().'</td>';
	                $datos .= '<td>'.$subt.'</td>';
	                $datos .= '<td>'.$otros.'</td>';
	                if($opt){
	                    $datos .= '<td><button class="bEliminar icono" onclick="eliminarRevisionOrganos('.$item->id_revision_organos_sistemas.'); return false; "></button></td>';
	                }else{
	                    $datos .= '<td></td>';
	                }
	                $datos .= '<tr>';
	                $subt=$otros='';
	            }
	            
	            $html = '
				<table style="width:100%">
					<thead><tr>
						<th>Tipo órgano/sistema</th>
						<th>Subtipo</th>
						<th>Otros</th>
						<th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>
           ';
	        }
	    }
	    return $html;
	}
	
	/**
	 * funcion para agregar Inmunizacion
	 */
	public function agregarInmunizacion() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if(isset($_POST['id_historia_clinica'])){
	        if(!empty($_POST['id_historia_clinica'])){
	            $arrayIndex = "nombre ='Inmunizaciones'";
	            $procedi = $this->lNegocioProcedimientoMedico->buscarLista($arrayIndex);
	            $_POST['id_procedimiento_medico'] = $procedi->current()->id_procedimiento_medico;
	            $_POST['fecha_ultima_dosis'] =$_POST['fecha_ultima_dosis'].'-01';
	            $resultado = $this->lNegocioInmunizacion->guardar($_POST);
	            if($resultado){
	                $contenido = $this->listarInmunizacion($_POST['id_historia_clinica']);
	                $mensaje = 'Registro agregado correctamente';
	            }else {
	                $estado = 'ERROR';
	                $mensaje = 'Error al guardar los datos !!';
	            }
	        }else{
	            $estado = 'ERROR';
	            $mensaje = 'Debe crear la historia clínica !!';
	        }
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica o seleccionar un campo!!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * funcion para eliminar Inmunizacion
	 */
	public function eliminarInmunizacion() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    if(isset($_POST['id_inmunizacion']) && isset($_POST['id_historia_clinica'])){
	        
	        $this->lNegocioInmunizacion->borrar($_POST['id_inmunizacion']);
	        $contenido = $this->listarInmunizacion($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * listar Inmunizacion
	 */
	public function listarInmunizacion($idHistoriaClinica=null,$opt=1){
	    $datos=$html='';
	    if($idHistoriaClinica != null){
	        $contador=0;
	        $consulta = $this->lNegocioInmunizacion->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
	        if($consulta->count()){
	            foreach ($consulta as $item) {
	                $tipo =	$this->lNegocioTipoProcedimientoMedico->buscar($item->id_tipo_procedimiento_medico);
	                $datos .= '<tr>';
	                $datos .= '<td>'.++$contador.'</td>';
	                $datos .= '<td>'.$tipo->getTipo().'</td>';
	                $datos .= '<td>'.date('Y-m',strtotime($item->fecha_ultima_dosis)).'</td>';
	                $datos .= '<td>'.$item->numero_dosis.'</td>';
	                if($opt){
	                    $datos .= '<td><button class="bEliminar icono" onclick="eliminarInmunizacion('.$item->id_inmunizacion.'); return false; "></button></td>';
	                }else{
	                    $datos .= '<td></td>';
	                }
	                $datos .= '<tr>';
	            }
	            
	            $html = '
				<table style="width:100%">
					<thead><tr>
						<th>#</th>
						<th>Vacuna</th>
						<th>FUD</th>
						<th>N° dosis</th>
                        <th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>
           ';
	        }
	    }
	    return $html;
	}
	/**
	 * Buscar habitos
	 */
	public function buscarHabitos() {
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if($_POST['id_historia_clinica'] != null && $_POST['id_tipo_procedimiento_medico'] != null){
	        
	        $verificar = $this->lNegocioHabitos->buscarLista("id_historia_clinica=".$_POST['id_historia_clinica']."and id_tipo_procedimiento_medico=".$_POST['id_tipo_procedimiento_medico']);
	        if($verificar->count()){
	            $estado = 'ERROR';
	            $mensaje = 'Ya existe el tipo habito seleccionado !!';
	        }else{
	           $contenido = $this->crearHtmlHabitos($_POST['tipo']);
	        }
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * mostrar inputs de ingreso de habitos
	 */
	public function crearHtmlHabitos($tipo) {
	    switch ($tipo) {
	        case 'Otras drogas':
	            $txt = '
                <legend>'.$tipo.'</legend>

        		<div data-linea="1">
        			<label for="habito_toxico">'.$tipo.': </label>
        			<select id="habito_toxico" name= "habito_toxico">
        				'. $this->comboOpcion().'
        			  </select>
        		</div>

        		<div data-linea="1">
        			<label for="exconsumidor">Exconsumidor:</label>
        			<select id="exconsumidor" name= "exconsumidor" disabled>
        				'. $this->comboOpcion().'
        			  </select>
        		</div>

        		<div data-linea="2">
        			<label for="sustancias">Detalle:</label>
        			<input type="text" id="sustancias" name="sustancias" maxlength="64" value="" disabled/>
        		</div>

        		<div data-linea="3">
        			<label for="cantidad_habito">Cantidad (semanal):</label>
        			<input type="text" id="cantidad_habito" name="cantidad_habito" maxlength="32" value="" disabled/>
        		</div>

                <div data-linea="3">
        			<label for="meses_habito">Tiempo de consumo (meses):</label>
        			<input type="number" id="meses_habito" name="meses_habito" min="1" max="999" value="" disabled/>
        		</div>

        		<div data-linea="4">
        			<label for="meses_habito_abstinencia">Tiempo abstienencia (meses):</label>
        			<input type="number" id="meses_habito_abstinencia" name="meses_habito_abstinencia" min="1" max="999" value="" disabled/>
        		</div>

                <div data-linea="6">
                		<button class="mas" onclick="agregarHabitos(); return false;">Agregar</button>
                </div>';
	            break;
	        default:
	           $txt = '
                <legend>'.$tipo.'</legend>

        		<div data-linea="1">
        			<label for="habito_toxico">'.$tipo.': </label>
        			<select id="habito_toxico" name= "habito_toxico">
        				'. $this->comboOpcion().'
        			  </select>
        		</div>

        		<div data-linea="1">
        			<label for="exconsumidor">Exconsumidor:</label>
        			<select id="exconsumidor" name= "exconsumidor" disabled>
        				'. $this->comboOpcion().'
        			  </select>
        		</div>

        		<div data-linea="2">
        			<label for="cantidad_habito">Cantidad (semanal):</label>
        			<input type="number" id="cantidad_habito" name="cantidad_habito" maxlength="32" value="" disabled/>
        		</div>

                <div data-linea="2">
        			<label for="meses_habito">Tiempo de consumo (meses):</label>
        			<input type="number" id="meses_habito" name="meses_habito" max="999" value="" disabled/>
        		</div>

        		<div data-linea="3">
        			<label for="meses_habito_abstinencia">Tiempo abstienencia (meses):</label>
        			<input type="number" id="meses_habito_abstinencia" name="meses_habito_abstinencia" max="999" value="" disabled/>
        		</div>

                <div data-linea="6">
                		<button class="mas" onclick="agregarHabitos(); return false;">Agregar</button>
                </div>';
	            break;
	    }
	    return $txt;
	    
	}
	
	/**
	 * funcion para agregar habitos
	 */
	public function agregarHabitos() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    $habito ='';
	    if(isset($_POST['id_historia_clinica'])){
	        if(!empty($_POST['id_historia_clinica'])){
	            $arrayIndex = "nombre ='Frecuencia de drogas'";
	            $procedi = $this->lNegocioProcedimientoMedico->buscarLista($arrayIndex);
	            $_POST['id_procedimiento_medico'] = $procedi->current()->id_procedimiento_medico;
	            if(isset($_POST['habito_toxico'] )){
    	                $habito = $_POST['habito_toxico'];
	            }
	            $resultado = $this->lNegocioHabitos->guardar($_POST);
	            if($resultado){
	                $contenido = $this->listarHabitos($_POST['id_historia_clinica']);
	                $mensaje = 'Registro agregado correctamente';
	            }else {
	                $estado = 'ERROR';
	                $mensaje = 'Error al guardar los datos !!';
	            }
	        }else{
	            $estado = 'ERROR';
	            $mensaje = 'Debe crear la historia clínica !!';
	        }
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica o seleccionar un campo!!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * funcion para eliminar Inmunizacion
	 */
	public function eliminarHabitos() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    if(isset($_POST['id_habitos']) && isset($_POST['id_historia_clinica'])){
	        
	        $this->lNegocioHabitos->borrar($_POST['id_habitos']);
	        $contenido = $this->listarHabitos($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * listar habitos
	 */
	public function listarHabitos($idHistoriaClinica=null,$opt=1){
	    $datos=$html='';
	    if($idHistoriaClinica != null){
	        $contador=0;
	        $consulta = $this->lNegocioHabitos->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
	        if($consulta->count()){
	            foreach ($consulta as $item) {
	                $tipo =	$this->lNegocioTipoProcedimientoMedico->buscar($item->id_tipo_procedimiento_medico);
	                $datos .= '<tr>';
	                $datos .= '<td>'.++$contador.'</td>';
	                $datos .= '<td>'.$tipo->getTipo().'</td>';
	                $datos .= '<td>'.$item->meses_habito.'</td>';
	                $datos .= '<td>'.$item->cantidad_habito.'</td>';
	                $datos .= '<td>'.$item->exconsumidor.'</td>';
	                $datos .= '<td>'.$item->meses_habito_abstinencia.'</td>';
	                if($opt){
	                    $datos .= '<td><button class="bEliminar icono" onclick="eliminarHabitos('.$item->id_habitos.'); return false; "></button></td>';
	                }else{
	                    $datos .= '<td></td>';
	                }
	                $datos .= '<tr>';
	            }
	            
	            $html = '
				<table style="width:100%">
					<thead><tr>
						<th>#</th>
						<th>Hábito</th>
						<th>Tiempo consumo</th>
						<th>Cantidad</th>
                        <th>Exconsumidor</th>
                        <th>Tiempo abstinencia</th>
                        <th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>';
	        }
	    }
	    return $html;
	}
	



	/**
	 * Buscar estilo de vida fisica, medicacion
	 */
	public function buscarEstiloVida() {
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if($_POST['id_historia_clinica'] != null){
	           $contenido = $this->crearHtmlEstiloVida($_POST['tipo']);     
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	/**
	 * mostrar inputs de ingreso de estilo de vida
	 */
	public function crearHtmlEstiloVida($tipo) {
	    switch ($tipo) {
	        case 'Física':
	            $txt = '
                <legend>Actividad física</legend>

                <div data-linea="1">
        			<label for="confirma_estilo">Actividad física: </label>
        			<select id="confirma_estilo" name= "confirma_estilo">
        				'. $this->comboOpcion().'
        			  </select>
        		</div>

        		<div data-linea="2">
					<label for="tiempo_cantidad">Tiempo/Cantidad: </label>
					<select id="tiempo_cantidad" name= "tiempo_cantidad" disabled>
		        		'. $this->comboActividadFisica() .'
		        	</select>
				</div>				

				<div data-linea="3">
					<label for="actividad_medicina">Cuál?:</label>
					<input type="text" id="actividad_medicina" name="actividad_medicina" value="" maxlength="128" disabled />
				</div>				
		        <div data-linea="4">
                		<button class="mas" onclick="agregarActividad(); return false;">Agregar</button>
                </div>';
	            break;
	        default:
	            $txt = '
                <legend>'.$tipo.'</legend>

                <div data-linea="1">
        			<label for="confirma_estilo">'.$tipo.': </label>
        			<select id="confirma_estilo" name= "confirma_estilo">
        				'. $this->comboOpcion().'
        			  </select>
        		</div>

        		<div data-linea="2">
					<label for="tiempo_cantidad">Tiempo/Cantidad: </label>
					<input type="text" id="tiempo_cantidad" name="tiempo_cantidad" maxlength="32" value="" disabled/>
				</div>				

				<div data-linea="3">
					<label for="actividad_medicina">Cuál?:</label>
					<input type="text" id="actividad_medicina" name="actividad_medicina" value=""maxlength="128" disabled/>
				</div>				
		        <div data-linea="4">
                		<button class="mas" onclick="agregarActividad(); return false;">Agregar</button>
                </div>';
	            break;
	    }
	    return $txt;
	    
	}

	/**
	 * funcion para agregar Stilo de vida
	 */
	public function agregarActividad() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';

	    if(isset($_POST['id_historia_clinica'])){
	        if(!empty($_POST['id_historia_clinica'])){
	        	$verificar = $this->lNegocioEstiloVida->buscarLista("id_historia_clinica=".$_POST['id_historia_clinica'] . "and tipo_actividad= '" .$_POST['tipo_actividad'] ."'");
	         	if(!$verificar->count()){
		            $resultado = $this->lNegocioEstiloVida->guardar($_POST);
		            if($resultado){
		                $contenido = $this->listarActividad($_POST['id_historia_clinica']);
		                $mensaje = 'Registro agregado correctamente';
		            }else {
		                $estado = 'ERROR';
		                $mensaje = 'Error al guardar los datos !!';
		            }
		        }
		        else{
		        	$estado = 'ERROR';
            		$mensaje = 'Ya existe el tipo de estilo de vida seleccionado !!';
		        }
	        }else{
	            $estado = 'ERROR';
	            $mensaje = 'Debe crear la historia clínica !!';
	        }
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica o seleccionar un campo!!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * funcion para eliminar actividad
	 */
	public function eliminarActividad() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    
	    if(isset($_POST['id_estilo_vida']) && isset($_POST['id_historia_clinica'])){
	        
	        $this->lNegocioEstiloVida->borrar($_POST['id_estilo_vida']);
	        $contenido = $this->listarActividad($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	        
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * listar actividad 
	 */
	public function listarActividad($idHistoriaClinica=null,$opt=1){
	    $datos=$html='';
	    if($idHistoriaClinica != null){
	        $contador=0;
	        $consulta = $this->lNegocioEstiloVida->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
	        if($consulta->count()){
	            foreach ($consulta as $item) {
	                $datos .= '<tr>';
	                $datos .= '<td>'.++$contador.'</td>';
	                $datos .= '<td>'.$item->tipo_actividad.'</td>';
	                $datos .= '<td>'.$item->tiempo_cantidad.'</td>';
	                $datos .= '<td>'.$item->actividad_medicina.'</td>';
	                if($opt){
	                    $datos .= '<td><button class="bEliminar icono" onclick="eliminarActividad('.$item->id_estilo_vida.'); return false; "></button></td>';
	                }else{
	                    $datos .= '<td></td>';
	                }
	                $datos .= '<tr>';
	            }
	            
	            $html = '
				<table style="width:100%">
					<thead><tr>
						<th>#</th>
						<th>Tipo</th>
						<th>Tiempo/Cantidad</th>
                        <th>Cual?</th>
                        <th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>
           ';
	        }
	    }
	    return $html;
	}
	/**
	 * listar evaluacion primaria
	 */
	public function listarEvaluacion($idHistoriaClinica=null){
	    $procedi = $this->lNegocioProcedimientoMedico->buscarLista("nombre ='Examen físico' and estado ='Activo'");
	    $arrayIndex = "id_procedimiento_medico =".$procedi->current()->id_procedimiento_medico." and estado ='Activo' order by 5";
	    $tipo = $this->lNegocioTipoProcedimientoMedico->buscarLista($arrayIndex);
	    $datos='';
	    
	    
	    foreach ($tipo as $item) {
	        $datos .= '<tr>';
	        $datos .= '<th colspan="4">'.$item->tipo.'</th>';
	        $datos .= '</tr>';
	        $datos .= '<tr>';
	        $datos .= '<td> </td>';
	        $datos .= '<td colspan="2"> Patología</td>';
	        $datos .= '<td> Observaciones</td>';
	        $datos .= '</tr>';
	        if(isset($idHistoriaClinica)){
	        $evaluacionPrima = $this->lNegocioEvaluacionPrimaria->buscarLista("id_historia_clinica = ".$idHistoriaClinica." and id_tipo_procedimiento_medico=".$item->id_tipo_procedimiento_medico);
	        }
	        $subtipo = $this->lNegocioSubtipoProcedimientoMedico->buscarLista("id_tipo_procedimiento_medico = ".$item->id_tipo_procedimiento_medico. " and estado ='Activo' order by 1");
	        foreach ($subtipo as $sub) {
	            $ban=1;
	            $datos .= '<tr>';
	            $datos .= '<td> '.$sub->subtipo.'</td>';
	            if(isset($idHistoriaClinica)){
	                if($evaluacionPrima->count()){
	                    $detalleEva = $this->lNegocioDetalleEvaluacionPrimaria->buscarLista("id_evaluacion_primaria=".$evaluacionPrima->current()->id_evaluacion_primaria." and id_subtipo_proced_medico=".$sub->id_subtipo_proced_medico);
	                    if($detalleEva->count()){
	                        $ban=0;
	                        if($detalleEva->current()->normal == 'Si'){
	                            $datos .= '<td> <input checked name="evaluacionPrimaria[]" type="checkbox" id="Si-'.$item->id_tipo_procedimiento_medico.'-'.$sub->id_subtipo_proced_medico.'" value="Si" onclick="verificarEvaPrimaria(id,'.$item->id_tipo_procedimiento_medico.','.$sub->id_subtipo_proced_medico.');  "> Si</td>';
	                            $datos .= '<td> <input  name="evaluacionPrimaria[]" type="checkbox" id="No-'.$item->id_tipo_procedimiento_medico.'-'.$sub->id_subtipo_proced_medico.'" value="No" onclick="verificarEvaPrimaria(id,'.$item->id_tipo_procedimiento_medico.','.$sub->id_subtipo_proced_medico.');  "> No</td>';
	                            $datos .= '<td> <input name="evaluacionPrimariatxt[]" type="text" id="'.$item->id_tipo_procedimiento_medico.'-'.$sub->id_subtipo_proced_medico.'" value="'.$detalleEva->current()->observaciones.'"> </td>';
	                        }else{
	                            $datos .= '<td> <input name="evaluacionPrimaria[]" type="checkbox" id="Si-'.$item->id_tipo_procedimiento_medico.'-'.$sub->id_subtipo_proced_medico.'" value="Si" onclick="verificarEvaPrimaria(id,'.$item->id_tipo_procedimiento_medico.','.$sub->id_subtipo_proced_medico.');  "> Si</td>';
	                            $datos .= '<td> <input checked name="evaluacionPrimaria[]" type="checkbox" id="No-'.$item->id_tipo_procedimiento_medico.'-'.$sub->id_subtipo_proced_medico.'" value="No" onclick="verificarEvaPrimaria(id,'.$item->id_tipo_procedimiento_medico.','.$sub->id_subtipo_proced_medico.');  "> No</td>';
	                            $datos .= '<td> <input name="evaluacionPrimariatxt[]" type="text" id="'.$item->id_tipo_procedimiento_medico.'-'.$sub->id_subtipo_proced_medico.'" value="'.$detalleEva->current()->observaciones.'"> </td>';
	                            
	                        }
	                    }
	                }
	            }
	            if($ban){
	            $datos .= '<td> <input name="evaluacionPrimaria[]" type="checkbox" id="Si-'.$item->id_tipo_procedimiento_medico.'-'.$sub->id_subtipo_proced_medico.'" value="Si" onclick="verificarEvaPrimaria(id,'.$item->id_tipo_procedimiento_medico.','.$sub->id_subtipo_proced_medico.');  "> Si</td>';
	            $datos .= '<td> <input name="evaluacionPrimaria[]" type="checkbox" id="No-'.$item->id_tipo_procedimiento_medico.'-'.$sub->id_subtipo_proced_medico.'" value="No" onclick="verificarEvaPrimaria(id,'.$item->id_tipo_procedimiento_medico.','.$sub->id_subtipo_proced_medico.');  "> No</td>';
	            $datos .= '<td> <input name="evaluacionPrimariatxt[]" type="text" id="'.$item->id_tipo_procedimiento_medico.'-'.$sub->id_subtipo_proced_medico.'" value=""> </td>';
	            $datos .= '</tr>';
	            }
	        }
	    }
	    
	    $html = '
			<table  style="width: 100%;">
            <tbody id="bodyEvaluacion">'.$datos.'</tbody>
			</table>
         ';
	    return $html;
	}
	/**
	 * Buscar examenes clinicos
	 */
	public function buscarExamenesClinicos() {
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if($_POST['id_historia_clinica'] != null && $_POST['id_tipo_procedimiento_medico'] != null){
	        $contenido = $this->crearHtmlExamenesClinicos($_POST);
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}

	/**
	 * mostrar inputs de ingreso examenes clinicos
	 */
	public function crearHtmlExamenesClinicos(array $datos) {
	            
	           $txt='';
	           $html = '
                <legend>'.$datos['tipo'].'</legend>
        		<div data-linea="1">
        			<label for="fecha_examen">Fecha de realización del exámen:</label>
        			<input type="text" id="fecha_examen" name="fecha_examen" value="" maxlength="13" readonly/>
        		</div>';
	            $tipo = $this->lNegocioSubtipoProcedimientoMedico->buscarLista("id_tipo_procedimiento_medico = ".$datos['id_tipo_procedimiento_medico']." and estado = 'Activo' order by 1");
	            
	            if($tipo->count()){
	            	 $txt .= '<tr> <td colspan="3"></td> <td>Resultados</td> </tr>';
	                foreach ($tipo as $value) {
	                    $txt .='<tr>';
	                    $txt .='<td>'.$value->subtipo.'</td>';

	                    $txt .= '<td> <input  name="estado_clinico[]" type="checkbox" id="Si-'.$datos['id_tipo_procedimiento_medico'].'-'.$value->id_subtipo_proced_medico.'" value="Si"  onclick="verificarExaClinicos(id,'.$datos['id_tipo_procedimiento_medico'].','.$value->id_subtipo_proced_medico.');  "> Si</td>';
	                    $txt .= '<td> <input  name="estado_clinico[]" type="checkbox" id="No-'.$datos['id_tipo_procedimiento_medico'].'-'.$value->id_subtipo_proced_medico.'" value="No"  onclick="verificarExaClinicos(id,'.$datos['id_tipo_procedimiento_medico'].','.$value->id_subtipo_proced_medico.');  "> No</td>';
                        $txt .='<td><input type="text" id="t-'.$datos['id_tipo_procedimiento_medico'].'-'.$value->id_subtipo_proced_medico.'" name="observaciones_examen_clinico[]" value="" placeholder="Resultado" maxlength="128" disabled/></td>';
	                    $txt .='</tr>';
	                }
	            }

	            $html .= '
        			<table  style="width: 100%;">
                    <tbody id="bodyExamenesClinicos">'.$txt.'</tbody>
        			</table>
        			<div data-linea="3">
	        			<label for="observacion_examen_clinico">Observaciones:</label>
	        			<input type="text" id="observacion_examen_clinico" name="observacion_examen_clinico" value=""  maxlength="256"/>
	        		</div>
					
					<div data-linea="5" id="documentoAdjunto">				
							<input type="hidden" class="rutaArchivo" name="archivo_adjunto" value="0"/>
							<input type="file" class="archivo" accept="application/pdf"/>
							<div class="estadoCarga">En espera de archivo... (Tamaño máximo ' . ini_get('upload_max_filesize') . 'B)</div>	
							<button style="display: none;" type="button" id="botonSubirArchivoAdjunto" class="subirArchivo adjunto" data-rutaCarga="'. URL_MVC_MODULO .'HistoriasClinicas/archivos/adjuntosHistoriaClinica" >Subir archivo</button>	
					</div>

                    <div data-linea="6">
                		<button class="mas" onclick="agregarExamenesClinicos(); return false;">Agregar</button>
                	</div>	';

	            return $html;
	}

	/**
	 * funcion para agregar accidente en paciente
	 */
	public function agregarExamenesClinicos() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if(isset($_POST['id_historia_clinica']) && isset($_POST['id_tipo_procedimiento_medico'])){
	        if(!empty($_POST['id_historia_clinica'])){
 	            $arrayIndex = "nombre ='Laboratorio'";
 	            $procedi = $this->lNegocioProcedimientoMedico->buscarLista($arrayIndex);
 	            $_POST['id_procedimiento_medico'] = $procedi->current()->id_procedimiento_medico;
 	            $resultado = $this->lNegocioExamenesClinicos->guardarExamenesDetalle($_POST);
 	            if($resultado){
 	                $contenido = $this->listarExamenesClinicos($_POST['id_historia_clinica']);
 	                $mensaje = 'Registro agregado correctamente';
 	            }else {
 	                $estado = 'ERROR';
 	                $mensaje = 'Error al guardar los datos !!';
 	            }
	        }else{
	            $estado = 'ERROR';
	            $mensaje = 'Debe crear la historia clínica !!';
	        }
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * funcion para eliminar antecedentes de salud
	 */
	public function eliminarExamenesClinicos() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if(isset($_POST['id_detalle_examenes_clinicos']) && isset($_POST['id_historia_clinica']) && $_POST['tipoEliminar'] == 'detalle'){
	        
	        $verificar = $this->lNegocioDetalleExamenesClinicos->buscar($_POST['id_detalle_examenes_clinicos']);
	        $examenCabecera = $this->lNegocioExamenesClinicos->buscar($verificar->getIdExamenesClinicos());
	        $contador = $this->lNegocioDetalleExamenesClinicos->buscarLista("id_examenes_clinicos = ".$verificar->getIdExamenesClinicos());
	        if($contador->count() == 1){
	            $this->lNegocioDetalleExamenesClinicos->borrarPorParametro("id_examenes_clinicos", $verificar->getIdExamenesClinicos());
	            $this->lNegocioAdjuntosHistoriaClinica->borrar($examenCabecera->getIdAdjuntosHistoriaClinica());
	            $this->lNegocioExamenesClinicos->borrar($verificar->getIdExamenesClinicos());
	        }else{
	            $this->lNegocioDetalleExamenesClinicos->borrar($_POST['id_detalle_examenes_clinicos']);
	        }
	        $contenido = $this->listarExamenesClinicos($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	    }else if (isset($_POST['id_detalle_examenes_clinicos']) && isset($_POST['id_historia_clinica']) && $_POST['tipoEliminar'] == 'cabecera'){
	        $examenCabecera = $this->lNegocioExamenesClinicos->buscar($_POST['id_detalle_examenes_clinicos']);
	        $this->lNegocioAdjuntosHistoriaClinica->borrar($examenCabecera->getIdAdjuntosHistoriaClinica());
	        $this->lNegocioExamenesClinicos->borrar($_POST['id_detalle_examenes_clinicos']);
	        $contenido = $this->listarExamenesClinicos($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }

	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	
	/**
	 * listar antecedentes de salud
	 */
	public function listarExamenesClinicos($idHistoriaClinica=null,$opt=1){
	    $datos=$html='';
	    if($idHistoriaClinica != null){
	        $consulta = $this->lNegocioExamenesClinicos->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
	        if($consulta->count()){
	            foreach ($consulta as $item) {
	                $tipo =	$this->lNegocioTipoProcedimientoMedico->buscar($item->id_tipo_procedimiento_medico);
	                $detalle = $this->lNegocioDetalleExamenesClinicos->buscarLista("id_examenes_clinicos =".$item->id_examenes_clinicos);
	                if($detalle->count()){
	                    foreach ($detalle as $detall) {
	                        $subtipo = $this->lNegocioSubtipoProcedimientoMedico->buscar($detall->id_subtipo_proced_medico);
        	                $datos .= '<tr>';
        	                $datos .= '<td>'.$tipo->getTipo().'</td>';
        	                $datos .= '<td>'.$subtipo->getSubtipo().'</td>';
        	                $datos .= '<td>'.$item->fecha_examen.'</td>';
        	                $datos .= '<td>'.$detall->estado_clinico.'</td>';
        	                $datos .= '<td>'.$detall->observaciones.'</td>';
        	                if($opt){
        	                    $datos .= '<td><button class="bEliminar icono" onclick="eliminarExamenesClinicos('.$detall->id_detalle_examenes_clinicos.', \'detalle\'); return false; "></button></td>';
        	                }else{
        	                    $datos .= '<td></td>';
        	                }
        	                $datos .= '<tr>';
		                }
		            }
		            else{
		            	$datos .= '<tr>';
    	                $datos .= '<td>'.$tipo->getTipo().'</td>';
    	                $datos .= '<td>'.'</td>';
    	                $datos .= '<td>'.$item->fecha_examen.'</td>';
    	                $datos .= '<td>'.'</td>';
    	                $datos .= '<td>'.$item->resultado.'</td>';
    	                if($opt){
    	                    $datos .= '<td><button class="bEliminar icono" onclick="eliminarExamenesClinicos('.$item->id_examenes_clinicos.', \'cabecera\'); return false; "></button></td>';
    	                }else{
    	                    $datos .= '<td></td>';
    	                }
    	                $datos .= '<tr>';
		            }
	            
	            $html = '
				<table style="width:100%">
					<thead><tr>
						<th>Tipo</th>
						<th>Examen</th>
						<th>Fecha</th>
                        <th>Estado</th>
                        <th>Resultado</th>
						<th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>';
	           }
	        }
	      }
	    return $html;
	}

	/**
	 * guardar archivoadjunto	 
	 * 
	 * */
	public function agregarDocumentosAdjuntos()
	{
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if(!empty($_REQUEST['id_historia_clinica']) && $_REQUEST['id_historia_clinica'] != 'null'){
    	    try {
    	        
    	        $identificador = $this->lNegocioHistoriaClinica->buscar($_REQUEST['id_historia_clinica']);
    	        $nombre_archivo = $_FILES['archivo']['name'];
    	        $tipo_archivo = $_FILES['archivo']['type'];
    	        $tamano_archivo = $_FILES['archivo']['size'];
    	        $tmpArchivo = $_FILES['archivo']['tmp_name'];
    	        $rutaCarpeta = HIST_CLI_URL."adjuntosHistoriaClinica/".$identificador->getIdentificadorPaciente();
    	        $extension = explode(".", $nombre_archivo);
    	        if ($tamano_archivo != '0' ) {
    	            if (strtoupper(end($extension)) == 'PDF' && $tipo_archivo == 'application/pdf') {
    	                if (!file_exists('../../' . $rutaCarpeta)) {
    	                    mkdir('../../' .$rutaCarpeta, 0777, true);
    	                }
    	                $secuencial = date('Ymds').mt_rand(100,999);
    	                $nuevo_nombre = 'examenes_clinicos_'.$identificador->getIdentificadorPaciente().'_'.$secuencial.'.' . end($extension);
    	                $ruta = $rutaCarpeta . '/' . $nuevo_nombre;
    	                move_uploaded_file($tmpArchivo, '../../' . $ruta);
    	                $arrayIndex = "nombre ='Laboratorio'";
    	                $procedi = $this->lNegocioProcedimientoMedico->buscarLista($arrayIndex);
    	                $arrayAdjunto = array(
    	                    'id_historia_clinica' =>$_REQUEST['id_historia_clinica'],
    	                    'id_procedimiento_medico' => $procedi->current()->id_procedimiento_medico,
    	                    'archivo_adjunto' => $ruta,
    	                    'descripcion_adjunto' => $_REQUEST['descripcion_adjunto']
    	                );
    	                $id = $this->lNegocioAdjuntosHistoriaClinica->guardar($arrayAdjunto);
    	                if($id){
    	                    $mensaje = 'Registro agregado correctamente';
    	                    $contenido = $this->listarAdjuntosHistoria($_REQUEST['id_historia_clinica']);;
    	                }else{
    	                    $estado = 'FALLO';
    	                    $mensaje = 'Error al guardar el registro..!!';
    	                    $contenido = $ruta;
    	                }
    	            } else {
    	                $estado = 'FALLO';
    	                $mensaje ='No se cargó archivo. Extención incorrecta';
    	            }
    	            
    	        }else{
    	            $estado = 'FALLO';
    	            $mensaje = 'El archivo supera el tamaño permitido';
    	        }
    	    } catch (\Exception $ex) {
    	        $estado = 'FALLO';
    	        $mensaje= 'No se cargó archivo';
    	    }
	    }else{
	        $estado = 'FALLO';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido,
	        'idAdjunto' => $id
	    ));
	}
	
	/**
	 * listar archivos adjuntos
	 */
	public function listarAdjuntosHistoria($idHistoriaClinica=null){
	    $html='';
	    if($idHistoriaClinica != null){
	        $consulta = $this->lNegocioAdjuntosHistoriaClinica->buscarLista("id_historia_clinica =".$idHistoriaClinica." and estado='Activo' and id_procedimiento_medico is not null order by 1 ");
	        if($consulta->count()){
	            $count=0;
	            foreach ($consulta as $item) {
	                $html .= '
                    <div data-linea = "'.++$count.'">
	                <label>'.$item->descripcion_adjunto.': </label>
	                <a href="'.$item->archivo_adjunto.'" target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>
		            </div><br>';
	            }
	        }
	    }
	    return $html;
	    

	}
	
  //**********************examenes paraclinicos*************************
  
	/**
	 * Buscar examenes paraclinicos
	 */
	public function buscarParaclinicos() {
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if($_POST['id_historia_clinica'] != null && $_POST['id_tipo_procedimiento_medico'] != null){
	        $verificar = $this->lNegocioExamenParaclinicos->buscarLista("id_historia_clinica =".$_POST['id_historia_clinica']." and id_tipo_procedimiento_medico=".$_POST['id_tipo_procedimiento_medico']);
	        if($verificar->count() == 0){
	            $contenido = $this->crearHtmlParaclinicos($_POST);
	        }else{
	            $estado = 'ERROR';
	            $mensaje = 'Tipo de examen ya registrado !!';
	        }
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * mostrar inputs de ingreso examenes paraclinicos
	 */
	public function crearHtmlParaclinicos(array $datos) {
	    
	    $html = '<legend>'.$datos['tipo'].'</legend>';
	    $menu ='Resultado de la imagen';
	        switch ($datos['tipo']) {
	            case 'Audiometría':
	                $menu ='Resultado';
	                $tipo = $this->lNegocioSubtipoProcedimientoMedico->buscarLista("id_tipo_procedimiento_medico = ".$datos['id_tipo_procedimiento_medico']." and estado = 'Activo' order by 1");
	                $txt='';
	                if($tipo->count()){
	                    $txt .='<tr><th colspan="'.$tipo->count().'">'.$menu.'</th></tr>';
	                    $txt .='<tr><td></td><td>Si</td><td>No</td><td>Derecho</td><td>Izquierdo</td><td>Bilateral</td></tr>';
	                    $txt .='<tr>';
	                    foreach ($tipo as $value) {
	                        $txt .='<tr>';
	                        $txt .='<td>'.$value->subtipo.'</td>';
	                        $txt .='<td align="center"><input type="checkbox" id="s-'.$datos['id_tipo_procedimiento_medico'].'-'.$value->id_subtipo_proced_medico.'" name="respuesta_check[]"  value="Si" onclick="verificarRespuestaParacli(id,'.$datos['id_tipo_procedimiento_medico'].','.$value->id_subtipo_proced_medico.');"   /> </td>';
	                        $txt .='<td align="center"><input type="checkbox" id="n-'.$datos['id_tipo_procedimiento_medico'].'-'.$value->id_subtipo_proced_medico.'" name="respuesta_check[]"  value="No" onclick="verificarRespuestaParacli(id,'.$datos['id_tipo_procedimiento_medico'].','.$value->id_subtipo_proced_medico.');"   /> </td>';
	                        $txt .='<td align="center"><input type="checkbox" id="d-'.$datos['id_tipo_procedimiento_medico'].'-'.$value->id_subtipo_proced_medico.'" name="oido_check[]"  value="Derecho" onclick="verificarOidoParaclinicos(id,'.$datos['id_tipo_procedimiento_medico'].','.$value->id_subtipo_proced_medico.');"   /> </td>';
	                        $txt .='<td align="center"><input type="checkbox" id="i-'.$datos['id_tipo_procedimiento_medico'].'-'.$value->id_subtipo_proced_medico.'" name="oido_check[]"  value="Izquierdo" onclick="verificarOidoParaclinicos(id,'.$datos['id_tipo_procedimiento_medico'].','.$value->id_subtipo_proced_medico.');"   /> </td>';
	                        $txt .='<td align="center"><input type="checkbox" id="b-'.$datos['id_tipo_procedimiento_medico'].'-'.$value->id_subtipo_proced_medico.'" name="oido_check[]"  value="Bilateral" onclick="verificarOidoParaclinicos(id,'.$datos['id_tipo_procedimiento_medico'].','.$value->id_subtipo_proced_medico.');"   /> </td>';
	                        $txt .='</tr>';
	                    }
	                    
	                    $html .= '
                			<table  style="width: 100%;">
                            <tbody id="bodyParaclinicos">'.$txt.'</tbody>
                			</table>
                            <div data-linea="3">
                    			<label for="observaciones_paraclinicos">Observaciones:</label>
                    			<input type="text" id="observaciones_paraclinicos" name="observaciones_paraclinicos" value=""
                    			placeholder="Observaciones" maxlength="128" />
                    		</div>
                            <div data-linea="4">
                        		<button class="mas" onclick="agregarParaclinicos(); return false;">Agregar</button>
                        		</div>	';
	                }
	                break;
	            case 'Espirometría':
	                $menu ='Resultado';
	            default:
	                $tipo = $this->lNegocioSubtipoProcedimientoMedico->buscarLista("id_tipo_procedimiento_medico = ".$datos['id_tipo_procedimiento_medico']." and estado = 'Activo' order by 1");
	                $txt='';
	                if($tipo->count()){
	                    $txt .='<tr><th colspan="'.$tipo->count().'">'.$menu.'</th></tr>';
	                    $txt .='<tr>';
	                    foreach ($tipo as $value) {
	                        $txt .='<td align="center"><input type="radio" id="r-'.$datos['id_tipo_procedimiento_medico'].'-'.$value->id_subtipo_proced_medico.'" name="respuesta_check[]" value="'.$value->subtipo.'"  /> '.$value->subtipo.'</td>';
	                    }
	                    $txt .='</tr>';
	                    $html .= '
                			<table  style="width: 100%;">
                            <tbody id="bodyParaclinicos">'.$txt.'</tbody>
                			</table>
                            <div data-linea="3">
                    			<label for="observaciones_paraclinicos">Observaciones:</label>
                    			<input type="text" id="observaciones_paraclinicos" name="observaciones_paraclinicos" value=""
                    			placeholder="Observaciones" maxlength="128" />
                    		</div>
                            <div data-linea="4">
                        		<button class="mas" onclick="agregarParaclinicos(); return false;">Agregar</button>
                        		</div>	';
	                }
	                break;
	        }
	        
	    return $html;
	}
	/**
	 * funcion para agregar examenes paraclinicos
	 */
	public function agregarParaclinicos() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if(isset($_POST['id_historia_clinica']) && isset($_POST['id_tipo_procedimiento_medico'])){
	        if(!empty($_POST['id_historia_clinica'])){
	            $arrayIndex = "nombre ='Examen de gabinete'";
	            $procedi = $this->lNegocioProcedimientoMedico->buscarLista($arrayIndex);
	            $_POST['id_procedimiento_medico'] = $procedi->current()->id_procedimiento_medico;
	            $resultado = $this->lNegocioExamenParaclinicos->guardarParaclinicosDetalle($_POST);
	            if($resultado){
	                $contenido = $this->listarParaclinicos($_POST['id_historia_clinica']);
	                $mensaje = 'Registro agregado correctamente';
	            }else {
	                $estado = 'ERROR';
	                $mensaje = 'Error al guardar los datos !!';
	            }
	        }else{
	            $estado = 'ERROR';
	            $mensaje = 'Debe crear la historia clínica !!';
	        }
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * funcion para eliminar examenes paraclinicos
	 */
	public function eliminarParaclinicos() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if(isset($_POST['id_examen_paraclinicos']) && isset($_POST['id_historia_clinica'])){
	        $this->lNegocioDetalleExamenParaclinicos->borrarPorParametro("id_examen_paraclinicos", $_POST['id_examen_paraclinicos']);
	        $this->lNegocioExamenParaclinicos->borrar($_POST['id_examen_paraclinicos']);
	        $contenido = $this->listarParaclinicos($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	
	/**
	 * listar examenes paraclinicos
	 */
	public function listarParaclinicos($idHistoriaClinica=null,$opt=1){
	    $datos=$html='';
	    if($idHistoriaClinica != null){
	        $consulta = $this->lNegocioExamenParaclinicos->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
	        if($consulta->count()){
	            foreach ($consulta as $item) {
	                $tipo =	$this->lNegocioTipoProcedimientoMedico->buscar($item->id_tipo_procedimiento_medico);
	                $detalle = $this->lNegocioDetalleExamenParaclinicos->buscarLista("id_examen_paraclinicos =".$item->id_examen_paraclinicos." order by 1");
	                $datos .= '<tr>';
	                $datos .= '<td>'.$tipo->getTipo().'</td>';
	                if($detalle->count()){
	                    $datos .= '<td>';
	                    foreach ($detalle as $detall) {
	                        $subtipo = $this->lNegocioSubtipoProcedimientoMedico->buscar($detall->id_subtipo_proced_medico);
	                            $datos .= $subtipo->getSubtipo();
	                            if($detall->respuesta){
	                                $datos .= ', '.$detall->respuesta;
	                            }
	                            if($detall->oido){
	                                $datos .= ', '.$detall->oido.'<br>';
	                            }else{
	                                $datos .= '<br>';
	                            }
	                    }
	                    $datos .= '</td>';
	                }
	                $datos .= '<td>'.$item->observaciones.'</td>';
	                if($opt){
	                    $datos .= '<td><button class="bEliminar icono" onclick="eliminarParaclinicos('.$item->id_examen_paraclinicos.'); return false; "></button></td>';
	                }else{
	                    $datos .= '<td></td>';
	                }
	                
	                $datos .= '<tr>';
	                
	                $html = '
				<table style="width:100%">
					<thead><tr>
						<th>Tipo</th>
						<th>Resultado</th>
                        <th>Observaciones</th>
						<th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>';
	            }
	        }
	    }
	    return $html;
	}
	
	//**********************************impresion diagnosticada**************************
	/**
	 * funcion para agregar impresiones diagnosticadas
	 */
	public function agregarDiagnostico() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if(isset($_POST['id_historia_clinica']) && isset($_POST['id_cie'])){
	        if(!empty($_POST['id_historia_clinica'])){
	            foreach ($_POST['estado_diagnostico'] as $value) {
	                $estadoDiag = $value;
	            }
	            $_POST['estado_diagnostico'] = $estadoDiag;
	            $resultado = $this->lNegocioImpresionDiagnostica->guardar($_POST);
	            if($resultado){
	                $contenido = $this->listarDiagnostico($_POST['id_historia_clinica']);
	                $mensaje = 'Registro agregado correctamente';
	            }else {
	                $estado = 'ERROR';
	                $mensaje = 'Error al guardar los datos !!';
	            }
	        }else{
	            $estado = 'ERROR';
	            $mensaje = 'Debe crear la historia clínica !!';
	        }
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Debe crear la historia clínica !!';
	    }
	    
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	/**
	 * funcion para eliminar examenes paraclinicos
	 */
	public function eliminarDiagnostico() {
	    
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
	    if(isset($_POST['id_impresion_diagnostica']) && isset($_POST['id_historia_clinica'])){
	        $this->lNegocioImpresionDiagnostica->borrar($_POST['id_impresion_diagnostica']);
	        $contenido = $this->listarDiagnostico($_POST['id_historia_clinica']);
	        $mensaje = 'Registro eliminado correctamente';
	    }else{
	        $estado = 'ERROR';
	        $mensaje = 'Error al eliminar el registro !!';
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido
	    ));
	}
	
	/**
	 * listar examenes paraclinicos
	 */
	public function listarDiagnostico($idHistoriaClinica=null,$opt=1){
	    $datos=$html='';
	    if($idHistoriaClinica != null){
	        $consulta = $this->lNegocioImpresionDiagnostica->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
	        if($consulta->count()){
	            foreach ($consulta as $item) {
	                $valor = $this->lNegocioCie->buscar($item->id_cie);
	                $datos .= '<tr>';
	                $datos .= '<td>'.$item->enfermedad.'</td>';
	                $datos .= '<td>'.$valor->getDescripcion().'</td>';
	                $datos .= '<td>'.$item->diagnostico.'</td>';
	                if($opt){
	                    $datos .= '<td><button class="bEliminar icono" onclick="eliminarDiagnostico('.$item->id_impresion_diagnostica.'); return false; "></button></td>';
	                }else{
	                    $datos .= '<td></td>';
	                }
	                $datos .= '<tr>';
	            }
	            $html = '
				<table style="width:100%">
					<thead><tr>
						<th>Enfermedad</th>
						<th>General de realización</th>
						<th>Diagnóstico</th>
						<th></th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>';
	        }
	    }
	    return $html;
	}
	
	public function filtrarInformacion(){
	    $estado = 'EXITO';
	    $mensaje = '';
	    $contenido = '';
 	    $modeloHistoriaClinica = array();
 	    if(isset($_POST['tipo'])){
	    if($_POST['tipo'] == 'ci'){
 	        $consulta = "identificador_paciente='".$_POST['identificadorFiltro']."' order by 1 ";
 	        $modeloHistoriaClinica = $this->lNegocioHistoriaClinica->buscarLista($consulta);
	    }else if($_POST['tipo'] == 'pasaporte'){
	        $consulta = "identificador_paciente='".$_POST['identificadorFiltro']."'order by 1";
	        $modeloHistoriaClinica = $this->lNegocioHistoriaClinica->buscarLista($consulta);
	    }else {
	        $arrayParametros = array('identificador_paciente' => $_POST['identificadorFiltro']);
            $modeloHistoriaClinica = $this->lNegocioHistoriaClinica->obtenerDatosPorApellido($arrayParametros);
 	    }
 	    
 	    if($modeloHistoriaClinica->count()==0){
 	        $estado = 'FALLO';
 	        $mensaje = 'No existe el paciente buscado..!!';
 	    }
	    
	    $this->tablaHtmlHistoriaClinica($modeloHistoriaClinica);
	    $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
	    }
	    echo json_encode(array(
	        'estado' => $estado,
	        'mensaje' => $mensaje,
	        'contenido' => $contenido));
	}
	//***************************************************************************************
	/**
	 * listar examenes paraclinicos
	 */
	public function listarLog($idHistoriaClinica=null){
	    $datos=$html='';
	    if($idHistoriaClinica != null){
	        $consulta = $this->lNegocioLog->buscarLista("id_historia_clinica =".$idHistoriaClinica." order by 1 ");
	        if($consulta->count()){
	            foreach ($consulta as $item) {
	                $array = array('identificador' => $item->identificador);
	                $valor = $this->lNegocioHistoriaClinica->obtenerDatosFirma($array);
	                $datos .= '<tr>';
	                $datos .= '<td>'.date('Y-m-d',strtotime($item->fecha_creacion)).'</td>';
	                $datos .= '<td>'.$valor->current()->funcionario.'</td>';
	                $datos .= '<td>'.$valor->current()->cargo.'</td>';
	                $datos .= '<tr>';
	            }
	            $html = '
				<table style="width:100%">
					<thead><tr>
						<th>Fecha de modificación</th>
						<th>Funcionario que registro el cambio</th>
                        <th>Cargo</th>
						</tr></thead>
					<tbody>'.$datos.'</tbody>
				</table>';
	        }
	    }
	    $this->historico= $html;
	}


	public function guardarFichaEmpleado(Array $datos) {
		try
		{
			$procesoIngreso = $this->modeloFichaEmpleado->getAdapter()
                ->getDriver()
                ->getConnection();
            $procesoIngreso->beginTransaction();

			//Proceso de actualizacion del los campos
            $statement = $this->modeloFichaEmpleado->getAdapter()
            ->getDriver()
            ->createStatement();
            
            $sqlActualizar = $this->modeloFichaEmpleado->actualizarSql('ficha_empleado', $this->modeloFichaEmpleado->getEsquema());
            $sqlActualizar->set($datos);
            $sqlActualizar->where(array('identificador' => $datos['identificador']));
            $sqlActualizar->prepareStatement($this->modeloFichaEmpleado->getAdapter(), $statement);
            $statement->execute();

 			$procesoIngreso->commit();
 		} catch (GuardarExcepcion $ex) {
            $procesoIngreso->rollback();
            throw new \Exception($ex->getMessage());
        }
	}

	public function guardarDatosContrato(Array $datos) {
		try
		{
			$procesoIngreso = $this->modeloDatosContrato->getAdapter()
                ->getDriver()
                ->getConnection();
            $procesoIngreso->beginTransaction();

			//Proceso de actualizacion del los campos
            $statement = $this->modeloDatosContrato->getAdapter()
            ->getDriver()
            ->createStatement();
            
            $sqlActualizar = $this->modeloDatosContrato->actualizarSql('datos_contrato', $this->modeloDatosContrato->getEsquema());
            $sqlActualizar->set($datos);
            $sqlActualizar->where(array('id_datos_contrato' => $datos['id_datos_contrato']));
            $sqlActualizar->prepareStatement($this->modeloDatosContrato->getAdapter(), $statement);
            $statement->execute();

 			$procesoIngreso->commit();
 		} catch (GuardarExcepcion $ex) {
            $procesoIngreso->rollback();
            throw new \Exception($ex->getMessage());
        }
	}

	public function comboTipoExamen($tipo=null){
		
		$cie10 = array('Papanicolaou', 'Colposcopia', 'Eco mamario', 'Mamografía', 'Antígeno prostático', 'Eco prostático');

	    $combo = '<option value="">Seleccionar....</option>';
	            foreach ($cie10 as $item) {
	                if ($tipo == $item)
	                {
	                    $combo .= '<option value="' . $item . '" selected>' . $item . '</option>';
	                } else
	                {
	                    $combo .= '<option value="' . $item . '">' . $item . '</option>';
	                }
	            }
	    return $combo;
	}

	public function comboTipoMetodoPlanificacion($tipo=null){

	    $cie10 = array('Píldoras anticonceptivas orales', 'Preservativos', 'Esterilización masculina', 'Coito interrumpido', 'Otros');
	    $combo = '<option value="">Seleccionar....</option>';
	            foreach ($cie10 as $item) {
	                if ($tipo == $item)
	                {
	                    $combo .= '<option value="' . $item . '" selected>' . $item . '</option>';
	                } else
	                {
	                    $combo .= '<option value="' . $item . '">' . $item . '</option>';
	                }
	            }
	    return $combo;
	}

	public function separarNombreCompleto($nombreCompleto) {
	     // Convertir el nombre completo a mayúsculas y quitar espacios al inicio y fin
	    $nombreCompleto = trim(strtoupper($nombreCompleto));
	    // Separar el nombre completo en palabras
	    $palabras = explode(' ', $nombreCompleto);
	    // Si el nombre completo tiene solo una palabra, se considera el primer nombre
	    if (count($palabras) === 1) {
	        $primerNombre = $palabras[0];
	        $segundoNombre = '';

	        return array(
		        'primer_nombre' => $primerNombre,
		        'segundo_nombre' => $segundoNombre
			);
	    }

		// Verificar si el último nombre es una preposición común
		$preposiciones = array('DE', 'DEL', 'LOS', 'LAS', 'Y', 'LA', 'DI', 'VAN');
		// Obtener el primer nombre
		$primerNombre1 = $palabras[0];
		$primerNombre = '';
		$segundoNombre = '';

		if (in_array($primerNombre1, $preposiciones)) 
		{
			$bandera = true;
		   foreach ($palabras as $key => $palabra) 
		   {
		   		if(in_array($palabra, $preposiciones))
		   		{
		   			$primerNombre = $primerNombre . ' ' . $palabra . ' ';
		   		}
		   		else
		   		{
		   			if($bandera)
		   			{
		   				$primerNombre = $primerNombre . ' ' . $palabra . ' ';
		   				$bandera = false;
		   			}
		   			else
		   			{
		   				$segundoNombre = $segundoNombre . ' ' . $palabra . ' ';
		   			}
		   			
		   		}		
		   }

		   return array(
		        'primer_nombre' => $primerNombre,
		        'segundo_nombre' => $segundoNombre
			);
		}
		else
		{
			// Obtener el primer nombre
		    $primerNombre = $palabras[0];
		    // Obtener el último nombre, que será el segundo nombre
		    $ultimoNombre = implode(' ', array_slice($palabras,1));
		    $segundoNombre = '';

		    if (in_array($ultimoNombre, $preposiciones)) {
		        // Si es una preposición común, se considera parte del primer nombre
		        $primerNombre .= ' ' . $ultimoNombre;
		    } else {
		        // Si no es una preposición, se considera el segundo nombre
		        $segundoNombre = $ultimoNombre;
		    }	

		    return array(
		        'primer_nombre' => $primerNombre,
		        'segundo_nombre' => $segundoNombre
			);	   
		}
	}

	public function certificadopdf()
	{
		$this->contenidoReporte  = $_POST['contenidoPDF'];
		require APP . 'HistoriasClinicas/vistas/generarReporteCertificadoPDF.php';
	}


}

class PDF extends TCPDI
{
	
	// Page header
	public function Header()
	{
		$bMargin = $this->getBreakMargin();
		$auto_page_break = $this->AutoPageBreak;
		$this->SetAutoPageBreak(false, 0);
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
	}
}