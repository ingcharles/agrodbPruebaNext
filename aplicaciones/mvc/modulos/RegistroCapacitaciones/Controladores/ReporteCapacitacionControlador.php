<?php
 /**
 * Controlador CursosImpartidos
 *
 * Este archivo controla la lógica del negocio del modelo:  CursosImpartidosModelo y  Vistas
 *
 * @author  AGROCALIDAD
 * @date   2022-08-31
 * @uses    CursosImpartidosControlador
 * @package RegistroCapacitaciones
 * @subpackage Controladores
 */
namespace Agrodb\RegistroCapacitaciones\Controladores;


use Agrodb\Core\Constantes;
use Agrodb\Core\Mensajes;
use Agrodb\RegistroCapacitaciones\Modelos\CursosCapacitacionesLogicaNegocio;
use Agrodb\Usuarios\Modelos\UsuariosPerfilesLogicaNegocio;


class ReporteCapacitacionControlador extends BaseControlador
{
    private $lNegocioCursosCapacitaciones = null;
    private $lNegocioUsuariosPerfiles = null;
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->lNegocioCursosCapacitaciones = new CursosCapacitacionesLogicaNegocio();
        $this->lNegocioUsuariosPerfiles = new UsuariosPerfilesLogicaNegocio();
        
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
        
        $usuarioPerfil= $this->lNegocioUsuariosPerfiles->buscarUsuariosXAplicacionPerfil($_SESSION['usuario'],'PFL_TEC_CAP');

        if($usuarioPerfil->count() == 0){
            require APP . 'RegistroCapacitaciones/vistas/listaOpcionesReportes.php';
        }else{
            require APP . 'RegistroCapacitaciones/vistas/listaOpcionesReportesTecnico.php';

        }
             
      
       
    }
    
    /**
     * Método de inicio del controlador para reportes
     */
    public function listarReporteGeneral()
    {
        $this->cargarPanelReportes();        
        require APP . 'RegistroCapacitaciones/vistas/listaReporteGeneral.php';
    }
    
    /**
     * Método de inicio del controlador para reportes
     */
    public function listarReporteProvincia()
    {
        $this->cargarPanelReportes();
        require APP . 'RegistroCapacitaciones/vistas/listaReporteProvincia.php';
    }

    public function perfilUsuario($cedula,$perfil){
        return $this->lNegocioUsuariosPerfiles->buscarUsuariosXAplicacionPerfil($cedula,$perfil);
    }

   

    public function mostrarPdf()
    {
        //responsables (Administrador)
        $perfilUsuarioAdmin = $this->perfilUsuario($_SESSION['usuario'],'PFL_REP_CAP');
        $_POST['tipoUsuario'] = "Responsable";
        if(isset($perfilUsuarioAdmin) && ($perfilUsuarioAdmin->count()==1)){
            $this->controlOficinaPlantaCentral();
            $this->obtenerDatosTecnico();
            require APP . 'RegistroCapacitaciones/vistas/generarReporteCapacitacionesPDF.php';

        }

       //tecnico planta central
       $perfilUsuarioTecnico = $this->perfilUsuario($_SESSION['usuario'],'PFL_TEC_CAP');
       $_POST['tipoUsuario'] = "TecnicoPlantaCentral";
        if((isset($perfilUsuarioTecnico) && $perfilUsuarioTecnico->count()==1) && ($_SESSION['nombreProvincia'] == 'Pichincha' && $_SESSION['nombreLocalizacion'] == 'Oficina Planta Central')){
           $this->controlOficinaPlantaCentral();
           $this->obtenerDatosTecnico();
           require APP . 'RegistroCapacitaciones/vistas/generarReporteCapacitacionesPDF.php';
         }else if(($_SESSION['nombreProvincia'] == 'Pichincha' && (($_SESSION['nombreLocalizacion'] != 'Oficina Planta Central') && ($_SESSION['nombreLocalizacion'] != 'Laboratorios Tumbaco')))){
            $_POST['idArea'] = $_SESSION['idGestion'];
														
            $_POST['tipoUsuario'] = "TecnicoPichinchaCanton";
            $this->obtenerDatosTecnico();
            require APP . 'RegistroCapacitaciones/vistas/generarReporteCapacitacionesPDF.php';
        }

       //tecnico provincia
       $perfilUsuarioTecnico = $this->perfilUsuario($_SESSION['usuario'],'PFL_TEC_CAP');
       $_POST['tipoUsuario'] = "TecnicoProvincia";
      // $_POST['codProvincia'] = $_SESSION['idProvincia'];
        if((isset($perfilUsuarioTecnico) && $perfilUsuarioTecnico->count()==1) && ($_SESSION['nombreProvincia'] != 'Pichincha' && $_SESSION['nombreLocalizacion'] != 'Oficina Planta Central')){
            echo("entro");
           $this->obtenerDatosTecnico();
           require APP . 'RegistroCapacitaciones/vistas/generarReporteCapacitacionesPDF.php';
        }
   
    }

    //funcion que envia los datos para generar reporte PDF Planta central
    public function controlOficinaPlantaCentral(){
        $_POST['idArea'] = $_SESSION['idGestion'];
        $_POST['oficina'] = $_SESSION['nombreLocalizacion'];
        if(isset($_POST['id_provinciaFiltro']) && ($_POST['id_provinciaFiltro'] == 'PC')){
            $datosProvincia = $this->provinciaXNombre("Pichincha");
            if (isset($datosProvincia)){
                $_POST['id_provinciaFiltro'] = $datosProvincia->current()->id_localizacion;
                //$_POST['nombre_provincia'] = $datosProvincia->current()->nombre;
                $_POST['nombre_provincia'] = 'Planta Central';
                $_POST['codProvincia'] = 'PC';
            }
        }else{
            $_POST['codProvincia'] = '';
        }
    }

    //funcion que obtiene los datos del tecnico logueado para el reporte PDF
    public function obtenerDatosTecnico(){
        $tecnico = $this->lNegocioCursosCapacitaciones->obtenerDatosTecnico($_SESSION['usuario']);
		if (isset($tecnico)){
            $_POST['nombreTecnico'] = $_SESSION['datosUsuario'];
		    $_POST['nombreArea'] = $tecnico->current()->cargotecnico;
            $_POST['identificadorTecnico'] = $_SESSION['usuario'];
		}
    }
    
    /**
     * Construye el código HTML para desplegar panel de busqueda para los reportes
     */
    public function cargarPanelReportes()
    {
    
        $contenidoBusqueda ="";
        $usuarioPerfil = $this->perfilUsuario($_SESSION['usuario'],'PFL_TEC_CAP');

        if($usuarioPerfil->count() == 0){
            $contenidoBusqueda=' <select id="idProvinciaFiltro" name="id_provinciaFiltro" style="width: 100%;">
                                    <option value="">Seleccione....</option>
                                     <option value="PC">Oficina Planta Central</option>' .
                                    $this->comboProvinciasEc().
                                '</select>
             <input type="hidden" id="idProvincia" name="id_provincia" value="" style="width: 100%;" readonly required="required"/>
             <input type="hidden" id="nombreProvincia" name="nombre_provincia" value="" style="width: 100%;" readonly required="required"/>';

             $contenidoCoordinacion = '<select id="idCoordinacion1" name="id_coordinacion" style="width: 100%;" required>
                                            <option value="">Seleccione....</option>
                                            '.$this->cargarCoordinacionesPanel($_SESSION['idGestion'],$_SESSION['usuario']).'
                                        </select>';

             $contenidoDireccion = '<select id="idDireccion" name="id_direccion" style="width: 100%;" required>
                                        <option value="">Seleccione....</option>
                                        '.$this->cargarDireccionesPanel($_SESSION['idGestion'],$_SESSION['usuario']).'
                                    </select>';
        }else if($_SESSION['nombreProvincia'] == 'Pichincha' && $_SESSION['nombreLocalizacion'] == 'Oficina Planta Central' ){
         
            $contenidoBusqueda = ' <input type="text" name="nombre_provincia"  value="'.$_SESSION['nombreProvincia'].'" style="width: 100%;" readonly "/>
            <input type="hidden" name="id_provinciaFiltro"  value="'.$_SESSION['idProvincia'].'" style="width: 100%;" readonly "/>';

            $contenidoCoordinacion = '<select id="idCoordinacion1" name="id_coordinacion" style="width: 100%;" required>
                                        <option value="">Seleccione....</option>'
                                        .$this->cargarCoordinacionesPanel($_SESSION['idGestion'],$_SESSION['usuario']).'
                                    </select>';

            $contenidoDireccion = '<select id="idDireccion" name="id_direccion" style="width: 100%;" required>
                                        <option value="">Seleccione....</option>
                                        '.$this->cargarDireccionesPanel($_SESSION['idGestion'],$_SESSION['usuario']).'
                                   </select>';
        }else{
            $contenidoBusqueda = ' <input type="text" name="nombre_provincia"  value="'.$_SESSION['nombreProvincia'].'" style="width: 100%;" readonly "/>
                                    <input type="hidden" name="id_provinciaFiltro"  value="'.$_SESSION['idProvincia'].'" style="width: 100%;" readonly "/>';
            $contenidoCoordinacion = '<select id="idCoordinacion" name="id_coordinacion" style="width: 100%;">
                                         <option value="">Seleccione....</option>'.
                                         $this->cargarCoordinaciones().
                                    '</select>';
            $contenidoDireccion = '<select id="idDireccion" name="id_direccion" style="width: 100%;" disabled="disabled">
                                    <option value="">Seleccione....</option>
                                </select>';
        }
       
          
       
        $this->panelBusquedaReporteGeneral =
                                            '<form id="filtrarReporteGeneral" action="aplicaciones/mvc/RegistroCapacitaciones/CursosCapacitaciones/exportarCursosCapacitacionExcel" target="_blank" method="post">
                                                <table class="filtro" style="width: 450px;">
                                                    <tbody>
                                                        <tr>
                                                            <th colspan="4">Filtro para el Reporte General</th>
                                                        </tr>
                                                        <tr  style="width: 100%;">
                                                            <td ><label>*Fecha Inicio: </label> </td>
                                                            <td>
                                                                <input id="fechaInicio" type="text" name="fecha_inicio" required="required" readonly="readonly">
                                                            </td>
                                                                        
                                                            <td ><label>*Fecha Fin: </label></td>
                                                            <td>
                                                                <input id="fechaFin" type="text" name="fecha_fin" required="required" readonly="readonly">
                                                            </td>
                                                        </tr>
                                                        <tr  style="width: 100%;">                                                           
                                                            <td colspan="2"> <label>*Coordinación: </label> </td>
                                                            <td colspan="2">
                                                                <select id="idCoordinacion" name="id_coordinacion" style="width: 100%;" required="required">
                                                                <option value="">Seleccione....</option>'.
                                                                $this->cargarCoordinacionesPanel($_SESSION['idGestion'],$_SESSION['usuario']).'</select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label>*Dirección: </label> </td>
                                                            <td colspan="2">
                                                                <select id="idDireccion" name="id_direccion" style="width: 100%;" disabled="disabled" required="required">
                                                                <option value="">Seleccione....</option>'.
                                                                $this->cargarDireccionesPanel($_SESSION['idGestion'],$_SESSION['usuario']).'</select>
                                                            </td>
                                                        </tr>
                                                        <tr  style="width: 100%;">
                                                        <td colspan="2" ><label>Provincia: </label> </td>
                                                            <td colspan="2" style="width: 100%;">
                                                                '.$contenidoBusqueda.'
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label>Nombre de Capacitación: </label></td>
                                                            <td colspan="2">
                                                                <select id="idCursoCapacitacion" name="id_curso_capacitacion" style="width: 100%;" disabled="disabled">
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr style="width: 100%;">
                                                            <td colspan="3" style="text-align:left;">Los campos con * son obligatorios.</td>
                                                             <td colspan="6" > <button type="submit" id="hola">Generar Reporte</button></td>
                                                        </tr>  
                                            		</tbody>
                                            	</table>
                                            </form>';
                                                                    
         $this->panelBusquedaReporteProvincia = '
                                            <form id="generarReporteCapacitacionesPDF" data-rutaAplicacion="mvc/RegistroCapacitaciones/ReporteCapacitacion"	data-opcion="mostrarPdf" data-destino="detalleItem" method="post">
                                                <table class="filtro" style="width: 450px;">
                                                    <tbody>
                                                    <tr>
                                                        <th colspan="4">Filtro para el Reporte de Provincia</th>
                                                    </tr>
                                                    <tr  style="width: 100%;">
                                                        <td><label>*Fecha Inicio: </label></td>
                                                        <td>
                                                            <input id="fechaInicio" type="text" name="fecha_inicio" readonly="readonly">
                                                        </td>     
                                                        <td><label>*Fecha Fin: </label></td>
                                                        <td>
                                                            <input id="fechaFin" type="text" name="fecha_fin" readonly="readonly">
                                                        </td>
                                                    </tr> 
                                                    <tr  style="width: 100%;">
                                                            <td colspan="2"><label>*Provincia: </label> </td>
                                                                <td colspan="2"style="width: 100%;">
                                                                    '.$contenidoBusqueda.'
                                                            </td>
                                                     </tr>                                                           
                                                    <td colspan="2"><label>*Coordinación: </label> </td>
                                                        <td colspan="2">
                                                            '.$contenidoCoordinacion.'
                                                            <input type="hidden" id="nombre_coor" name="nombreCoor"  value="" ;/>
                                                        </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><label>*Dirección: </label> </td>
                                                        <td colspan="2">
                                                            '.$contenidoDireccion.'
                                                            <input type="hidden" id="nombre_dir" name="nombreDir"  value="" ;/>
                                                        </td>
                                                </tr>
                                                
                                                <tr style="width: 100%;">
                                                    <td colspan="3" style="text-align:left;">Los campos con * son obligatorios.</td>
                                                    <td colspan="6" > <button id="btnReportePDF" type="submit" class="guardar alineacion">Generar reporte pdf</button></td>
                                                </tr>  
                    
                                                    </tbody>
                                                </table>
                                               
                                               
                                            </form>';
    }

}