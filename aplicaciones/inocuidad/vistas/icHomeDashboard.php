<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../../../clases/Conexion.php';
require_once '../../../clases/ControladorAplicaciones.php';
require_once '../controladores/ControladorDashboard.php';
require_once '../../../clases/Constantes.php';

$constg = new Constantes();

$conexion = new Conexion();
$_SESSION['_ABSPATH_']=$_SERVER['DOCUMENT_ROOT'] . '/'.$constg::RUTA_APLICACION.'/';
$controladorDashboard = new ControladorDashboard();
?>
<!DOCTYPE html>
<html>
<head>
    <script src="aplicaciones/inocuidad/js/inocuidad_root.js" type="text/javascript"/>
    <meta charset="utf-8">
    <script src="aplicaciones/inocuidad/js/gauge.min.js"/>
    <script src="aplicaciones/inocuidad/js/jquery.dataTables.min.js"/>
    <link href="aplicaciones/inocuidad/estilos/jquery.dataTables.min.css" rel="stylesheet"></link>
</head>
<body>

<header>
    <h1>Panel de Control</h1>
    <nav>

        <?php
        $ca = new ControladorAplicaciones();
        $res = $ca->obtenerAccionesPermitidas($conexion, $_POST["opcion"], $_SESSION['usuario']);
       
        while($fila = pg_fetch_assoc($res)){
            echo '<a href="#"
						id="' . $fila['estilo'] . '"
						data-destino="detalleItem"
						data-opcion="' . $fila['pagina'] . '"
						data-rutaAplicacion="' . $fila['ruta'] . '"
						>'.(($fila['estilo']=='_seleccionar')?'<div id="cantidadItemsSeleccionados">0</div>':''). $fila['descripcion'] . '</a>';

        }
        ?>
    </nav>
</header>

<div>
    <table style="width: 100%">
        <tr>
            <td style="text-align: center">
                <div id="recibidos_container">
                    <canvas id="gauge_recibidos"></canvas>
                    <div id="recibidos-textfield" style="font-size: 20px;"></div>
                </div>
            </td>
            <td style="text-align: center">
                <div id="despachados_container">
                    <canvas id="gauge_despachados"></canvas>
                    <div id="despachados-textfield" style="font-size: 20px;"></div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="font-size: 18px; text-align: center">Recibidos vs Atendidos</td>
            <td style="font-size: 18px; text-align: center">Atendidos vs Despachados</td>
        </tr>
        <tr>
            <table id="example" class="display" width="100%" data-page-length="25" data-order="[[ 1, &quot;asc&quot; ]]">
                <thead>
                <tr>
                    <th>Programa</th>
                    <th>Provincia/País</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th data-orderable="false">Estado</th>
                    <th>Usuario</th>
                    <th>Código</th>
                    <th data-orderable="false">Acciones</th>
                </tr>
                </thead>
                <tfoot>
               <tbody>
                <?php
                echo $controladorDashboard->listDashboard($_SESSION['usuario']);
                ?>

                </tbody>
            </table>
        </tr>
    </table>
</div>
<div id="dialogCancelar" title="Cancelar Registro" style="display: none">
    <p>Se dispone a cancelar el registro seleccionado</p>
    <label for="detalle_cancelacion">Detalle de la cancelación</label>
    <textarea id="detalle_cancelacion1"></textarea>
    <label for="detalle_cancelacion">Archivo respaldo:</label>
    <input type="hidden" id="ruta_archivo" class="rutaArchivo" name="rutaArchivo" value="0"/>
    <input type="file" class="archivo" accept="application/msword | application/pdf | image/*"/>
    <div class="estadoCarga">En espera de archivo... (Tamaño máximo <?php echo ini_get('upload_max_filesize'); ?>B)</div>
    <button type="button" class="subirArchivo adjunto" data-rutaCarga="aplicaciones/inocuidad/respaldo_archivo">Subir archivo</button>
</div>
<script>
    $(document).ready(function(){
        $("#listadoItems").removeClass("programas");
        $("#listadoItems").addClass("comunes");
        $("#detalleItem").html('<div class="mensajeInicial">Seleccione un elemento de la tabla para ver el detalle.</div>');

        $('#example').DataTable( {
            "pagingType": "full_numbers",
            "searchable":true,
            language: {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        } );

        //funcionq ue carga archivo adjunto asistencia
        $("button.subirArchivo").click(function (event) {
		
            nombre_archivo = "<?php echo $_SESSION['usuario'] . (md5(time())); ?>";
            
            var boton = $(this);
            var archivo = boton.parent().find(".archivo");
            var rutaArchivo = boton.parent().find(".rutaArchivo");
            var extension = archivo.val().split('.');
            var estado = boton.parent().find(".estadoCarga");

            if (extension[extension.length - 1].toUpperCase() == 'PDF') {

                subirArchivo(
                    archivo
                    , nombre_archivo
                    , boton.attr("data-rutaCarga")
                    , rutaArchivo
                    , new carga(estado, archivo, boton)
                );
            } else {
                estado.html('Formato incorrecto, solo se admite archivos en formato PDF');
                archivo.val("");
            }
        });

        function carga(estado, archivo, boton) {
                this.esperar = function (msg) {
                estado.html("Cargando el archivo...");
                archivo.addClass("amarillo");
            };

            this.exito = function (msg) {
                estado.html("El archivo ha sido cargado.");
                archivo.removeClass("amarillo");
                archivo.addClass("verde");
                boton.attr("disabled", "disabled");
                $("#nuevoDocumento :submit").removeAttr("disabled");
            };

            this.error = function (msg) {
                estado.html(msg);
                archivo.removeClass("amarillo");
                archivo.addClass("rojo");
            };
        }
    });

    <?php echo $controladorDashboard->recibidosVsDespachados()?>
</script>
<script src="aplicaciones/inocuidad/js/icHomeDashboard.js"/>

</body>
</html>