<?php
/**
 * Lógica del negocio de AplicacionesRegistradasModelo
 *
 * Este archivo se complementa con el archivo AplicacionesRegistradasControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-02-09
 * @uses    AplicacionesRegistradasLogicaNegocio
 * @package Programas
 * @subpackage Modelos
 */
namespace Agrodb\Programas\Modelos;

use Agrodb\Laboratorios\Modelos\LaboratoriosModelo;
use Agrodb\Usuarios\Modelos\UsuariosPerfilesLogicaNegocio;
use Agrodb\Usuarios\Modelos\PerfilesLogicaNegocio;
use Agrodb\Programas\Modelos\IModelo;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class AplicacionesRegistradasLogicaNegocio implements IModelo
{

    private $modeloAplicacionesRegistradas = null;
    

    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloAplicacionesRegistradas = new AplicacionesRegistradasModelo();
        $this->lNegocioUsuariosPerfiles = new UsuariosPerfilesLogicaNegocio();
        $this->lNegocioPerfiles = new PerfilesLogicaNegocio();
    }
    
    public function guardar(LaboratoriosModelo $tabla){
    }

    /**
     * Guarda el registro actual
     *
     * @param array $datos
     * @return int
     */
    public function guardarAplicacionesRegistradas(Array $datos)
    {
        $tablaModelo = new AplicacionesRegistradasModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdAplicacion() != null && $tablaModelo->getIdAplicacion() > 0) {
            return $this->modeloAplicacionesRegistradas->actualizar($datosBd, $tablaModelo->getIdAplicacion());
        } else {
            unset($datosBd["id_aplicacion"]);
            return $this->modeloAplicacionesRegistradas->guardar($datosBd);
        }
    }

    /**
     * Borra el registro actual
     *
     * @param
     *            string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modeloAplicacionesRegistradas->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return AplicacionesRegistradasModelo
     */
    public function buscar($id)
    {
        return $this->modeloAplicacionesRegistradas->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloAplicacionesRegistradas->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloAplicacionesRegistradas->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarAplicacionesRegistradas()
    {
        $consulta = "SELECT * FROM " . $this->modeloAplicacionesRegistradas->getEsquema() . ". aplicaciones_registradas";
        return $this->modeloAplicacionesRegistradas->ejecutarSqlNativo($consulta);
    }
    
    //Administración Aplicaciones
    /**
     * Ejecuta una consulta(SQL) personalizada .
     * Buscar registros usando filtros.
     *
     * @return array|ResultSet
     */
    public function buscarAplicacionesXUsuarioXPerfilFiltradas($arrayParametros)
    {
        $busqueda = '';
        
        if (isset($arrayParametros['id_aplicacion']) && ($arrayParametros['id_aplicacion'] != '')) {
            $busqueda .= " and ar.id_aplicacion = ".$arrayParametros['id_aplicacion'];
        }
        
        if (isset($arrayParametros['id_perfil']) && ($arrayParametros['id_perfil'] != '')) {
            $busqueda .= " and up.id_perfil = ".$arrayParametros['id_perfil'];
        }
        
        if (isset($arrayParametros['identificador']) && ($arrayParametros['identificador'] != '')) {
            $busqueda .= " and fe.identificador = '" . $arrayParametros['identificador'] . "'";
        }
        
        if (isset($arrayParametros['id_area']) && ($arrayParametros['id_area'] != '')) {
            $busqueda .= " and '".$arrayParametros['id_area']."' = ANY (p.id_area)";
        }
        
        if (isset($arrayParametros['tipo_usuario']) && ($arrayParametros['tipo_usuario'] != '')) {
                        
            if($arrayParametros['tipo_usuario']=='Interno' || $arrayParametros['tipo_usuario']=='Profesionales'){
                $busqueda .= " and '".$arrayParametros['tipo_usuario']."' = ANY (p.tipo_usuario) ";
            }else if($arrayParametros['tipo_usuario']=='InternoProfesionales'){
                $busqueda .= " and 'Interno' = ANY (p.tipo_usuario) and 'Profesionales' = ANY (p.tipo_usuario) ";
            }else if($arrayParametros['tipo_usuario']=='Externo'){
                $busqueda .= " and 'Externo' = ANY (p.tipo_usuario) ";
            }
            
        }
                
        $consulta = "  SELECT 
                        	distinct fe.identificador,
                        	fe.nombre,
                        	fe.apellido,
                        	ar.id_aplicacion,
                        	a.nombre as nombre_aplicacion,
                        	p.id_perfil,
                        	p.nombre as nombre_perfil,
                            a.id_area,
							dc.provincia,
							dc.canton,
							dc.oficina,
							dc.gestion
                        FROM
                        	g_uath.ficha_empleado fe 
                            INNER JOIN g_programas.aplicaciones_registradas ar ON fe.identificador = ar.identificador 
                            INNER JOIN g_usuario.usuarios u ON u.identificador = fe.identificador 
                            INNER JOIN g_uath.datos_contrato dc ON dc.identificador = fe.identificador 
                            INNER JOIN g_usuario.usuarios_perfiles up ON up.identificador = fe.identificador
                            INNER JOIN g_usuario.perfiles p ON p.id_perfil = up.id_perfil
                            INNER JOIN g_programas.aplicaciones a ON a.id_aplicacion = ar.id_aplicacion
                        WHERE
                            dc.estado = 1
                            and u.estado = 1
                        	".$busqueda."
                        ORDER BY
                        	id_perfil asc;";
        
        //echo $consulta;
        return $this->modeloAplicacionesRegistradas->ejecutarSqlNativo($consulta);
    }
    
    //Administración Aplicaciones
    public function validarAsignarAplicacionPerfil($datos)
    {
        $validacion = array(
            'bandera' => true,
            'estado' => "exito",
            'mensaje' => "",
            'contenido' => null
        );
        
        if (isset($datos['identificadorUsuario']) && isset($datos['idModulo']) && isset($datos['idPerfil']) && isset($datos['idArea']) && isset($datos['tipoUsuario'])) {
            
            switch ($datos['idArea']) {
                // Validación por cada Dirección o Coordinación para sus módulos específicos
                case 'DGPGE':
                    {
                        if($datos['codificacionModulo'] == 'PRG_PAPP'){
                            if($datos['areaUsuario'] != $datos['areaResponsableUsuario']){
                                $validacion['estado'] = "fallo";
                                $validacion['bandera'] = false;
                                $validacion['mensaje'] = "Para asignar el módulo solicitado el usuario debe ser responsable del área en la que se encuentra asignado: " . $datos['areaUsuario'] . ' - ' . $datos['areaResponsableUsuario'];
                            }
                        }
                                                
                        break;
                    }
                
                default:
                    {
                        break;
                    }
            }
            
            //Validar número de usuarios y perfiles asignados
            
            //Asignar la aplicación y el perfil solicitado
            if($validacion['bandera']){
                //Guardar la aplicación
                $this->asignarAplicacion($datos['identificadorUsuario'], $datos['codificacionModulo']);
                
                //Asignar el perfil
                $this->lNegocioUsuariosPerfiles->asignarPerfil($datos['identificadorUsuario'], $datos['codificacionPerfil']);
                
                $validacion['estado'] = "exito";
                $validacion['bandera'] = true;
                $validacion['mensaje'] = "Se ha asignado la aplicación y el perfil";
            }
            
            return $validacion;
        }        
    }
    
    //Administración Aplicaciones
    /**
     * Ejecuta una consulta(SQL) personalizada para obtener los datos de las
     * aplicaciones
     *
     * @return array|ResultSet
     */
    public function asignarAplicacion($identificador, $codigoModulo)
    {
        $consulta = "INSERT INTO 
                    g_programas.aplicaciones_registradas
                    ( id_aplicacion, identificador, cantidad_notificacion, mensaje_notificacion) 
                    SELECT (SELECT id_aplicacion FROM g_programas.aplicaciones WHERE codificacion_aplicacion='$codigoModulo'), '$identificador', 0, 'notificaciones' 
                    where not exists (select identificador from g_programas.aplicaciones_registradas where identificador='$identificador' 
                    and id_aplicacion=(SELECT id_aplicacion FROM g_programas.aplicaciones WHERE codificacion_aplicacion='$codigoModulo'));";
                        
        return $this->modeloAplicacionesRegistradas->ejecutarSqlNativo($consulta);
    }
    
    //Administración Aplicaciones
    /**
     * Ejecuta una consulta(SQL) personalizada para obtener los datos de las
     * aplicaciones
     *
     * @return array|ResultSet
     */
    public function eliminarAplicacionRegistrada($identificador, $idModulo)
    {
        $consulta = "DELETE FROM
                         g_programas.aplicaciones_registradas
                	 WHERE
                         identificador = '$identificador' and
                         id_aplicacion = '$idModulo';";
        
        //echo $consulta;
        return $this->modeloAplicacionesRegistradas->ejecutarSqlNativo($consulta);
    }
    
    //Administración Aplicaciones
    public function validarEliminarAplicacionPerfil($datos)
    {
        $validacion = array(
            'bandera' => true,
            'estado' => "exito",
            'mensaje' => "",
            'contenido' => null
        );
        
        if (isset($datos['identificadorUsuario']) && isset($datos['idModulo']) && isset($datos['idPerfil'])) {
            
            //Eliminar perfil de usuario
            $this->lNegocioUsuariosPerfiles->eliminarPerfil($datos['identificadorUsuario'], $datos['idPerfil']);
                        
            //Buscar los perfiles pertenecientes a la aplicación y que el usuario 
            $perfilesFaltantes = $this->lNegocioPerfiles->obtenerPerfilesFaltantesXAplicaciones($datos['idModulo'], $datos['identificadorUsuario']);
            
            //Verificar si el usuario dispone de más perfiles de la misma aplicación, caso contrario eliminar la aplicación también
            if (!empty($perfilesFaltantes->current()) != '') {
                $validacion['estado'] = "exito";
                $validacion['bandera'] = true;
                $validacion['mensaje'] = "Se ha eliminado el perfil";
            } else {//borrar la aplicación
                $this->eliminarAplicacionRegistrada($datos['identificadorUsuario'], $datos['idModulo']);
                
                $validacion['estado'] = "exito";
                $validacion['bandera'] = true;
                $validacion['mensaje'] = "Se ha eliminado la aplicación y el perfil";
            }
            
            return $validacion;
        }
    }
    
    /**
     * Ejecuta un reporte en Excel de las movilizaciones
     *
     * @return array|ResultSet
     */
    public function exportarArchivoExcelAplicacionesRegistradasUsuarios($datos)
    {
        $hoja = new Spreadsheet();
        $documento = $hoja->getActiveSheet();
        $i = 3;
        $j = 2;
        
        $documento->setCellValueByColumnAndRow(1, 1, 'Reporte de Usuarios, Aplicaciones y Perfiles registrados');
        
        $documento->setCellValueByColumnAndRow(1, $j, 'Identificador');
        $documento->setCellValueByColumnAndRow(2, $j, 'Nombre');
        $documento->setCellValueByColumnAndRow(3, $j, 'Provincia');
        $documento->setCellValueByColumnAndRow(4, $j, 'Cantón');
        $documento->setCellValueByColumnAndRow(5, $j, 'Oficina');
        $documento->setCellValueByColumnAndRow(6, $j, 'Unidad');
        $documento->setCellValueByColumnAndRow(7, $j, 'Coordinación/Dirección Módulo');
        $documento->setCellValueByColumnAndRow(8, $j, 'Módulo asignado');
        $documento->setCellValueByColumnAndRow(9, $j, 'Perfil asignado');
        
        if ($datos != '') {
            foreach ($datos as $fila) {
                $documento->setCellValueByColumnAndRow(1, $i, $fila['identificador']);
                $documento->setCellValueByColumnAndRow(2, $i, $fila['nombre'] . ' ' . $fila['apellido']);
                $documento->setCellValueByColumnAndRow(3, $i, $fila['provincia']);
                $documento->setCellValueByColumnAndRow(4, $i, $fila['canton']);
                $documento->setCellValueByColumnAndRow(5, $i, $fila['oficina']);
                $documento->setCellValueByColumnAndRow(6, $i, $fila['gestion']);
                $documento->setCellValueByColumnAndRow(7, $i, str_replace("{", "",str_replace("}", "", $fila['id_area'])));
                $documento->setCellValueByColumnAndRow(8, $i, $fila['nombre_aplicacion']);
                $documento->setCellValueByColumnAndRow(9, $i, $fila['nombre_perfil']);
                
                $i ++;
            }
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="excelAplicacionesRegistradasUsuarios.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $writer = IOFactory::createWriter($hoja, 'Xlsx');
        $writer->save('php://output');
        exit();
    }
}