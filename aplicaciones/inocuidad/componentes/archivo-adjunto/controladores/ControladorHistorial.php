<?php
/**
 * ccarrera
 */
session_start();
require_once $_SESSION['_ABSPATH_'].'aplicaciones/inocuidad/componentes/archivo-adjunto/servicios/ItemArchivoDAO.php';
require_once $_SESSION['_ABSPATH_'].'aplicaciones/inocuidad/componentes/archivo-adjunto/servicios/MapperDAO.php';
require_once $_SESSION['_ABSPATH_'].'/clases/Conexion.php';

class ControladorHistorial
{
    private $conexion;
    private $servicios;
    private $mapperSvr;
    /**
     * ControladorArchivoAdjunto constructor.
     */
    public function __construct()
    {
        $this->conexion= new Conexion();
        $this->servicios= new ItemArchivoDAO();
        $this->mapperSvr = new MapperDAO();
    }

    public function crearTablaArchivos($tabla,$registro){
        $tableFiles="";
        if(isset($registro)) {
            $mapper = $this->mapperSvr->mapearElemento($tabla,$this->conexion);
            if($mapper!=null && $mapper->getNombreEsquema()!=null && $mapper->getNombreTabla()!=null)
                $title = "Módulo: ".$mapper->getNombreEsquema()." - Tabla: ".$mapper->getNombreTabla()." - Registro: $registro";
            else
                $title = "Módulo: ".strtok($tabla,".")." - Tabla: ".strtok(".")." - Registro: $registro";
            $tableFiles ="<div class='adjuntos_header_title' ><label>$title</label></div>";
            $tableFiles .= " <table class='adjuntos_detalle' border='1' style='border: 1px solid >
                        <tr class='adjuntos_header'>
                        <th style='width:22%'>Fecha</th>
                        <th style='width:22%'>Acciones Realizadas</th>
                        </tr>";
            $historiales = $this->obtenerRegistrosPorTabla($tabla,$registro);
            $json = json_decode($historiales);
            // echo("holas_:"+$json);
            if($json != false){
                foreach($json as $item => $value){
                    $tableFiles .= '<tr class="adjuntos_fila">';
                    $tableFiles .= '<td><i class="fa fa-book" aria-hidden="true"></i></i>';
                    $tableFiles .= '  '.$value->fecha_creacion_registro;
                    $tableFiles .= '</td>';
                    $tableFiles .= '<td>';
                    $tableFiles .= '  '.$value->accion;
                    $tableFiles .= '</td>';
                    $tableFiles .= '</tr>';
                }
            }
            $tableFiles .= '</table>';
        }
        return $tableFiles;
    }

    public function obtenerCamposCaso($tabla,$registro){
        $idRequerimiento =$this->servicios->obtenerCamposRequerimientoPorID($tabla,$registro,$this->conexion);
        return $idRequerimiento;
    }

    public function obtenerRegistrosPorTabla($tabla,$registro){
        $res =$this->servicios->recuperarHistorialUsuario($tabla,$registro,$this->conexion);
        return $res;
    }
}