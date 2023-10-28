<?php
/**
 * Controlador Operaciones
 *
 * Este archivo controla la lógica del negocio del modelo: OperacionesModelo y Vistas
 *
 * @author AGROCALIDAD
 * @date   2020-09-18
 * @uses OperacionesControlador
 * @package AdministrarOperaciones
 * @subpackage Controladores
 */
namespace Agrodb\AdministracionAplicaciones\Controladores;

use Agrodb\Programas\Modelos\AplicacionesLogicaNegocio;
use Agrodb\Programas\Modelos\AplicacionesRegistradasLogicaNegocio;
use Agrodb\Usuarios\Modelos\PerfilesLogicaNegocio;
use Agrodb\Usuarios\Modelos\UsuariosPerfilesLogicaNegocio;
use Agrodb\Estructura\Modelos\AreaLogicaNegocio;

use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;

class AdministracionAplicacionesControlador extends BaseControlador
{
    private $area = null;
    private $tipoUsuario = null;
    
    private $accion = null;

    
    /**
     * Constructor
     */
    function __construct()
    {
        $this->lNegocioAplicaciones = new AplicacionesLogicaNegocio();
        $this->lNegocioAplicacionesRegistradas = new AplicacionesRegistradasLogicaNegocio();
        $this->lNegocioPerfiles = new PerfilesLogicaNegocio();
        $this->lNegocioUsuariosPerfiles = new UsuariosPerfilesLogicaNegocio();
        $this->lNegocioArea = new AreaLogicaNegocio();
        
        parent::__construct();

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

    }

    /**
     * Método de inicio del controlador
     */
    public function inocuidad()
    {
        $this->area = 'CGIA';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->filtroAplicaciones();

        require APP . 'AdministracionAplicaciones/vistas/listaAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevoInocuidad()
    {
        $this->area = 'CGIA';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->accion = "Nueva Aplicación y Perfil";
        require APP . 'AdministracionAplicaciones/vistas/formularioAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método de inicio del controlador
     */
    public function laboratorios()
    {
        $this->area = 'CGL';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->filtroAplicaciones();
        
        require APP . 'AdministracionAplicaciones/vistas/listaAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevoLaboratorio()
    {
        $this->area = 'CGL';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->accion = "Nueva Aplicación y Perfil";
        require APP . 'AdministracionAplicaciones/vistas/formularioAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método de inicio del controlador
     */
    public function registros()
    {
        $this->area = 'CGRIA';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->filtroAplicaciones();
        
        require APP . 'AdministracionAplicaciones/vistas/listaAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevoRegistros()
    {
        $this->area = 'CGRIA';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->accion = "Nueva Aplicación y Perfil";
        require APP . 'AdministracionAplicaciones/vistas/formularioAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método de inicio del controlador
     */
    public function animal()
    {
        $this->area = 'CGSA';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->filtroAplicaciones();
        
        require APP . 'AdministracionAplicaciones/vistas/listaAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevoAnimal()
    {
        $this->area = 'CGSA';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->accion = "Nueva Aplicación y Perfil";
        require APP . 'AdministracionAplicaciones/vistas/formularioAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método de inicio del controlador
     */
    public function vegetal()
    {
        $this->area = 'CGSV';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->filtroAplicaciones();
        
        require APP . 'AdministracionAplicaciones/vistas/listaAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevoVegetal()
    {
        $this->area = 'CGSV';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->accion = "Nueva Aplicación y Perfil";
        require APP . 'AdministracionAplicaciones/vistas/formularioAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método de inicio del controlador
     */
    public function documental()
    {
        $this->area = 'DGDA';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->filtroAplicaciones();
        
        require APP . 'AdministracionAplicaciones/vistas/listaAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevoDocumental()
    {
        $this->area = 'DGDA';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->accion = "Nueva Aplicación y Perfil";
        require APP . 'AdministracionAplicaciones/vistas/formularioAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método de inicio del controlador
     */
    public function tecnologias()
    {
        $this->area = 'DTIC';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->filtroAplicaciones();
        
        require APP . 'AdministracionAplicaciones/vistas/listaAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevoTecnologias()
    {
        $this->area = 'DTIC';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->accion = "Nueva Aplicación y Perfil";
        require APP . 'AdministracionAplicaciones/vistas/formularioAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método de inicio del controlador
     */
    public function administrativo()
    {
        $this->area = 'DAF';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->filtroAplicaciones();
        
        require APP . 'AdministracionAplicaciones/vistas/listaAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevoAdministrativo()
    {
        $this->area = 'DAF';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->accion = "Nueva Aplicación y Perfil";
        require APP . 'AdministracionAplicaciones/vistas/formularioAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método de inicio del controlador
     */
    public function talentohumano()
    {
        $this->area = 'DGATH';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->filtroAplicaciones();
        
        require APP . 'AdministracionAplicaciones/vistas/listaAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevoTalento()
    {
        $this->area = 'DGATH';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->accion = "Nueva Aplicación y Perfil";
        require APP . 'AdministracionAplicaciones/vistas/formularioAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método de inicio del controlador
     */
    public function juridico()
    {
        $this->area = 'DGAJ';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->filtroAplicaciones();
        
        require APP . 'AdministracionAplicaciones/vistas/listaAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevoJuridico()
    {
        $this->area = 'DGAJ';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->accion = "Nueva Aplicación y Perfil";
        require APP . 'AdministracionAplicaciones/vistas/formularioAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método de inicio del controlador
     */
    public function planificacion()
    {
        $this->area = 'DGPGE';
        $this->tipoUsuario = 'Interno';
        $this->filtroAplicaciones();
        
        require APP . 'AdministracionAplicaciones/vistas/listaAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevoPlanificacion()
    {
        $this->area = 'DGPGE';
        $this->tipoUsuario = 'Interno';
        $this->accion = "Nueva Aplicación y Perfil";
        require APP . 'AdministracionAplicaciones/vistas/formularioAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método de inicio del controlador
     */
    public function relacionesinternacionales()
    {
        $this->area = 'GRI';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->filtroAplicaciones();
        
        require APP . 'AdministracionAplicaciones/vistas/listaAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método para desplegar el formulario vacio
     */
    public function nuevoRelInt()
    {
        $this->area = 'GRI';
        $this->tipoUsuario = 'InternoProfesionales';
        $this->accion = "Nueva Aplicación y Perfil";
        require APP . 'AdministracionAplicaciones/vistas/formularioAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método para desplegar el formulario vacio
     */
    public function abrirEliminar()
    {
        $this->accion = "Eliminar Aplicación y Perfil";
        require APP . 'AdministracionAplicaciones/vistas/formularioEliminacionAdministracionAplicacionesVista.php';
    }

    /**
     * Método para registrar en la base de datos -Operaciones
     */
    public function guardar()
    {
        $resultado = $this->lNegocioAplicacionesRegistradas->validarAsignarAplicacionPerfil($_POST);
    
        if($resultado['bandera']){
            echo json_encode(array(
                'estado' => $resultado['estado'],
                'mensaje' => $resultado['mensaje'],
                'contenido' => $resultado['contenido']
            ));
        }else{
            Mensajes::fallo($resultado['mensaje']);
        }       
    }    
           
      
    /**
     * Método para borrar un registro en la base de datos - Operaciones
     */
    public function borrar()
    {
        $resultado = $this->lNegocioAplicacionesRegistradas->validarEliminarAplicacionPerfil($_POST);
        
        if($resultado['bandera']){
            echo json_encode(array(
                'estado' => $resultado['estado'],
                'mensaje' => $resultado['mensaje'],
                'contenido' => $resultado['contenido']
            ));
        }else{
            Mensajes::fallo($resultado['mensaje']);
        }
    }

    public function filtroAplicaciones()
    {
        $this->panelBusqueda = '<table class="filtro" style="width: 100%;">
                                            	<tbody>
	                                                <tr>
	                                                    <th colspan="3">Buscar por:</th>
	                                                </tr>
	                                                <tr  style="width: 100%;">
	                            						<td >Módulo: </td>
	                            						<td colspan="3">
	                            							<select id="moduloFiltro" name= "moduloFiltro" style="width:185px;" required>
                                                            '.$this->comboModulo($this->area, $this->tipoUsuario).'
                                                			</select>
	                            						</td>
	                            					</tr>
	                                                <tr  style="width: 100%;">
                                						<td >Perfil: </td>
                                						<td colspan="3" >
                                							<select id="perfilFiltro" name= "perfilFiltro" style="width:185px;" disabled="disabled" required>
                                                                <option value>Seleccione...</option>
                                                			</select>
                                						</td>
                                					</tr>
	                                                <tr  style="width: 100%;">
	                            						<td >Identificador:</td>
	                            						<td colspan="3">
	                            							<input id="identificadorFiltro" type="text" name="identificadorFiltro" value="" >
	                            						</td>
            
	                            					</tr>
	                                                <td colspan="3" style="text-align: end;">
                            							<button id="btnFiltrar">Buscar</button>
                            						</td>
                            					</tr>
                            				</tbody>
                            			</table>';
        
        $this->panelBusquedaReporte = '<form id="filtrar" action="aplicaciones/mvc/AdministracionAplicaciones/AdministracionAplicaciones/exportarReporteAplicacionesAsignadasExcel" target="_blank" method="post">
                                            <table class="filtro" style="width: 100%;">
                                            	<tbody>
	                                                <tr>
	                                                    <th colspan="3">Buscar por:</th>
	                                                </tr>
                                                    <tr  style="width: 100%;">
	                            						<td >Coordinación/Dirección: </td>
	                            						<td colspan="3">
	                            							<select id="unidadFiltro" name= "unidadFiltro" style="width:185px;" required>
                                                            '.$this->comboCoordinacionesDireccionesAdminApp().'
                                                			</select>
	                            						</td>
	                            					</tr>
	                                                <tr  style="width: 100%;">
	                            						<td >Módulo: </td>
	                            						<td colspan="3">
	                            							<select id="moduloFiltro" name= "moduloFiltro" style="width:185px;" required>
                                                                <option value>Seleccione...</option>
                                                			</select>
	                            						</td>
	                            					</tr>
	                                                <tr  style="width: 100%;">
                                						<td >Perfil: </td>
                                						<td colspan="3" >
                                							<select id="perfilFiltro" name= "perfilFiltro" style="width:185px;" >
                                                                <option value>Seleccione...</option>
                                                			</select>
                                						</td>
                                					</tr>
	                                                <tr  style="width: 100%;">
	                            						<td >Identificador:</td>
	                            						<td colspan="3">
	                            							<input id="identificadorFiltro" type="text" name="identificadorFiltro" value="" >
	                            						</td>
                                                                
	                            					</tr>
	                                                <td colspan="3" style="text-align: end;">
                            							<button type="submit" id="btnFiltrar">Generar reporte</button>
                            						</td>
                            					</tr>
                            				</tbody>
                            			</table>
                                    </form>';
    }
    
    public function comboCoordinacionesDireccionesAdminApp()
    {
        $combo = $this->lNegocioArea->obtenerCoordinacionesDireccionesAdminApp();
        
        $opcionesHtml = '<option value>Seleccione...</option>';
        
        foreach ($combo as $item) {
            $opcionesHtml .= '<option value="' . $item->id_area . '" >' . $item->nombre . '</option>';
        }
        
        return $opcionesHtml;
    }

    public function comboModulo($area, $tipoUsuario)
    {
        $combo = $this->lNegocioAplicaciones->obtenerAplicacionesXArea($this->area, $tipoUsuario);
        
        $opcionesHtml = '<option value>Seleccione...</option>';
        
        foreach ($combo as $item) {
            $opcionesHtml .= '<option value="' . $item->id_aplicacion . '" data-codigo="' . $item->codificacion_aplicacion . '">' . $item->nombre . '</option>';
        }
        
        return $opcionesHtml;
    }
    
    /**
     * Consulta los pérfiles de aplicaciones y construye el combo
     *
     * @param Integer $idLocalizacion
     * @return string
     */
    public function comboModuloXCoordDir(){
        
        $area = $_POST['area'];
        $tipoUsuario = $_POST['tipoUsuario'];
        
        $combo = $this->lNegocioAplicaciones->obtenerAplicacionesXArea($area, $tipoUsuario);
        
        $opcionesHtml = '<option value>Seleccione...</option>';
        
        foreach ($combo as $item) {
            $opcionesHtml .= '<option value="' . $item->id_aplicacion . '" data-codigo="' . $item->codificacion_aplicacion . '">' . $item->nombre . '</option>';
        }
        
        echo $opcionesHtml;
        exit();
    }
    
    /**
     * Consulta los pérfiles de aplicaciones y construye el combo
     *
     * @param Integer $idLocalizacion
     * @return string
     */
    public function comboPerfilesXAplicacionXTipoUsuario(){
        
        $idAplicacion = $_POST['idAplicacion'];
        $area = $_POST['area'];
        $tipoUsuario = $_POST['tipoUsuario'];
        
        $perfiles = '<option value>Seleccione...</option>';
        
        $combo = $this->lNegocioPerfiles->obtenerPerfilesXAplicacionesXTipoUsuario($area, $idAplicacion, $tipoUsuario);
        
        foreach ($combo as $item){
            $perfiles .= '<option value="' . $item->id_perfil . '" data-codigo="' . $item->codificacion_perfil . '">' . $item->nombre . '</option>';
        }
        
        echo $perfiles;
        exit();
    }
    
    /**
     * Método para listar las aplicaciones asignadas a los usuarios
     */
    public function listarUsuariosXAplicacionFiltradas()
    {
        $estado = 'EXITO';
        $mensaje = '';
        $contenido = '';
        
        $moduloFiltro = $_POST['moduloFiltro'];
        $perfilFiltro = $_POST["perfilFiltro"];
        $identificadorFiltro = $_POST['identificadorFiltro'];
        $area = $_POST['area'];
        $tipoUsuario = $_POST['tipoUsuario'];
        
        $arrayParametros = array(
            'id_aplicacion' => $moduloFiltro,
            'id_perfil' => $perfilFiltro,
            'identificador' => $identificadorFiltro,
            'id_area' => $area,
            'tipo_usuario' => $tipoUsuario
        );
        
        $solicitudes = $this->lNegocioAplicacionesRegistradas->buscarAplicacionesXUsuarioXPerfilFiltradas($arrayParametros);
        
        $this->tablaHtmlAplicaciones($solicitudes);
        
        $contenido = \Zend\Json\Json::encode($this->itemsFiltrados);
        
        echo json_encode(array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'contenido' => $contenido
        ));
    }
    
    /**
     * Construye el código HTML para desplegar la lista de - Dossier Pecuario
     */
    public function tablaHtmlAplicaciones($tabla)
    {
        $contador = 0;
        
        foreach ($tabla as $fila) {
            $this->itemsFiltrados[] = array(
                '<tr id="' . $fila['id_aplicacion'] .'-'. $fila['id_perfil'].'-'. $fila['identificador'].'" 
                    class="item">
                    <td>' . ++ $contador . '</td>
                    <td>' . $fila['identificador'] . '</td>
                    <td style="white - space:nowrap; "><b>' . $fila['nombre'] .' '. $fila['apellido'] . '</b></td>
                    <td>' . $fila['nombre_aplicacion'] . '</td>
                    <td>' . $fila['nombre_perfil'] . '</td>
                </tr>'
            );
        }
    }
    
    /**
     * Método para el nombre del usuario
     * */
    public function mostrarDatosUsuario()
    {
        $identificador = $_POST['identificador'];
        $area = $_POST['area'];
        $tipoUsuario = $_POST['tipoUsuario'];
        
        $validacion = "Fallo";
        $resultado = "El usuario no existe o no corresponde a la clasificación permitida.";
        
        //aqui hacer diferenciacion del area del administrador para cambio en planificacion
        if($area == 'DGPGE'){
            $usuario = $this->lNegocioUsuariosPerfiles->buscarUsuariosContratoPlanificacionAplicaciones($identificador);
            
            if (!empty($usuario->current()) != '') {
                $validacion = "Exito";
                $resultado = "El usuario se encuentra registrado.";
                
                echo json_encode(array(
                    'resultado' => $resultado,
                    'funcionario' => $usuario->current()->funcionario,
                    'tipo_contrato' => $usuario->current()->tipo_contrato,
                    'provincia' => $usuario->current()->provincia,
                    'canton' => $usuario->current()->canton,
                    'oficina' => $usuario->current()->oficina,
                    'gestion' => $usuario->current()->gestion,
                    'area_funcionario' => $usuario->current()->area_funcionario,
                    'nombre_area' => $usuario->current()->nombre_area,
                    'area_responsable' => $usuario->current()->area_responsable,
                    'validacion' => $validacion
                ));
            } else {//agregar validacion para servicios profesionales
                $resultado = "El usuario debe ser un funcionario interno y responsable de área para poder continuar.";
                
                echo json_encode(array(
                    'resultado' => $resultado,
                    'validacion' => $validacion
                ));
            }
        }else{
            $usuario = $this->lNegocioUsuariosPerfiles->buscarUsuariosContratoAplicaciones($identificador);
            
            if (!empty($usuario->current()) != '') {
                $validacion = "Exito";
                $resultado = "El usuario se encuentra registrado.";
                
                echo json_encode(array(
                    'resultado' => $resultado,
                    'funcionario' => $usuario->current()->funcionario,
                    'tipo_contrato' => $usuario->current()->tipo_contrato,
                    'provincia' => $usuario->current()->provincia,
                    'canton' => $usuario->current()->canton,
                    'oficina' => $usuario->current()->oficina,
                    'gestion' => $usuario->current()->gestion,
                    'validacion' => $validacion
                ));
            } else {//agregar validacion para servicios profesionales
                $resultado = "El usuario no se encuentra registrado con un contrato activo.";
                
                echo json_encode(array(
                    'resultado' => $resultado,
                    'validacion' => $validacion
                ));
            }
        }
    }
    
    /**
     * Método para el nombre del usuario, aplicación y perfil en eliminación
     * */
    public function mostrarDatosUsuarioEliminacion()
    {
        $identificador = $_POST['identificador'];
        $idModulo = $_POST['idModulo'];
        $idPerfil = $_POST['idPerfil'];
        
        $validacion = "Fallo";
        $resultado = "El usuario no existe o no tiene el módulo y perfil indicados.";
        
        $usuario = $this->lNegocioUsuariosPerfiles->buscarUsuariosEliminarAplicacion($identificador, $idModulo, $idPerfil);
        
        if (!empty($usuario->current()) != '') {
            $validacion = "Exito";
            $resultado = "El usuario se encuentra registrado con el módulo y perfil indicados.";
            
            echo json_encode(array(
                'resultado' => $resultado,
                'funcionario' => $usuario->current()->funcionario,
                'nombre_aplicacion' => $usuario->current()->nombre_aplicacion,
                'nombre_perfil' => $usuario->current()->nombre_perfil,
                'validacion' => $validacion
            ));
        } else {//agregar validacion para servicios profesionales
            $resultado = "El usuario no existe o no tiene el módulo y perfil indicados.";
            
            echo json_encode(array(
                'resultado' => $resultado,
                'validacion' => $validacion
            ));
        }
    }
    
    /**
     * Método de inicio del controlador
     */
    public function reporteAdministracionAplicaciones()
    {
        $this->tipoUsuario = 'Interno';        
        $this->filtroAplicaciones();
        
        require APP . 'AdministracionAplicaciones/vistas/listaReporteAdministracionAplicacionesVista.php';
    }
    
    /**
     * Método para generar el reporte de aplicaciones asignadas en excel
     */
    public function exportarReporteAplicacionesAsignadasExcel() {
        $idModulo = $_POST["moduloFiltro"];
        $idPerfil = $_POST["perfilFiltro"];
        $identificador = $_POST["identificadorFiltro"];
        
        $arrayParametros = array(
            'id_aplicacion' => $idModulo,
            'id_perfil' => $idPerfil,
            'identificador' => $identificador
        );
        
        $solicitudes = $this->lNegocioAplicacionesRegistradas->buscarAplicacionesXUsuarioXPerfilFiltradas($arrayParametros);
        
        $this->lNegocioAplicacionesRegistradas->exportarArchivoExcelAplicacionesRegistradasUsuarios($solicitudes);
    }
}