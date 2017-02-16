<!DOCTYPE html>
<html>
    <head>
        <title>Mix de Productos</title>
        <link rel="stylesheet" type="text/css" href="../bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css">
    </head>

    <body onload="change_link_export()">
        <script>
            function change_link_export(){
                var date = document.getElementById("fecha").value;

                var fecha = date[11]+""+date[12]+""+date[13]+""+date[14]+""+date[8]+""+date[9]+""+date[5]+""+date[6];

                document.getElementById("export").href = "export_mix_stock.php?fecha="+fecha;
            }
        </script>

        <header class="container">
            <nav class="navbar navbar-default">
                <div class="row">
                    <div class="col-md-12"><h3 class="text-center"><a href="http://10.95.17.114/paneles"><img src="../paris.png" width="140px" height="100px" title="Reportes Paris"></a> Informe Mix de Productos</h3></div>
                </div><br>

                <form action="index.php" method="get" class="row" style="margin-left: 170px;">
                    <div class="col-lg-2">
                        <div class="text-center"><span class="label label-primary" style="font-size: 13px;">Seleccione día actual</span></div>
                        <div class="input-group date" data-provide="datepicker">
                            <input style="width: 140px;" name='fecha' id="fecha" class="form-control" onchange="change_link_export();" type="text" value="<?php
                            date_default_timezone_set("America/Santiago");

                            require_once '../fecha_es.php';

                            if(isset($_GET['fecha'])){
                                echo $_GET['fecha'];
                            }else {
                                echo obtenerDia(date("D")) . ", " . date("d/m/Y");
                            }
                            ?>" />
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2" style="margin-left: 70px;"><br>
                        <button class="btn btn-primary" style="width: 100px;">Actualizar</button>
                    </div>

                    <div class="col-lg-2 col-md-2"><br>
                        <a id="export" href="#" class="btn btn-success"><span class="glyphicon glyphicon-export"></span> Base Mix de Productos</a>
                    </div>

                    <div class="col-lg-2 col-md-2" style="margin-left: 70px;"><br>
                        <a id="export" href="glosario.php" class="btn btn-info"><span class="glyphicon glyphicon-info-sign"></span> Base Mix de Productos</a>
                    </div>
                </form>
            </nav>
        </header>

        <div style="margin: 0 auto;">
            <table class="table table-hover table-condensed table-bordered">
                <tr>
                    <th rowspan="2" style="color: white; background-color: #305496; vertical-align: middle;" class="text-center">División</th>
                    <th rowspan="2" style="color: white; background-color: #305496; vertical-align: middle;" class="text-center">Departamento</th>
                    <th colspan="6" style="color: white; background-color: #3769C6; vertical-align: middle; display: none;" class="text-center izq">Tipo Stock</th>
                    <th rowspan="2" style="color: white; background-color: #4A76C9; vertical-align: middle;" class="text-center">
                        <a class="btn btn-info btn-xs"  style="float: left;" onclick="colapsar_izq_der('.izq'); return false;">
                            <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                        </a>
                        Mix de Estilos Con Stock que existen en Paris.cl y en Tiendas
                    </th>
                    <th rowspan="2" style="color: white; background-color: #4A76C9; vertical-align: middle;" class="text-center">Mix de Estilos Con Stock que existen sólo en Paris.cl</th>
                    <th rowspan="2" style="color: white; background-color: #4A76C9; vertical-align: middle;" class="text-center">
                        <a class="btn btn-info btn-xs" style="float: right;" onclick="colapsar_izq_der('.der'); return false;">
                            <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
                        </a>
                        Mix de Estilos Con Stock Paris.cl versus Tiendas
                    </th>
                    <th rowspan="2" style="color: white; background-color: #5B81C9; vertical-align: middle; display: none;" class="text-center der">Mix de Estilos Con Stock que existen sólo en Tienda</th>
                    <th rowspan="2" style="color: white; background-color: #5B81C9; vertical-align: middle; display: none;" class="text-center der">Mix de Estilos Con Foto que debemos Reponer en Paris.cl</th>
                    <th rowspan="2" style="color: white; background-color: #5B81C9; vertical-align: middle; display: none;" class="text-center der">Mix de Estilos Con Stock Paris.cl versus Tienda luego de Reposición</th>
                </tr>

                <tr>
                    <th style="color: white; background-color: #3769C6; vertical-align: middle; display: none;" class="text-center izq"># Estilos Exclusivos Paris.cl</th>
                    <th style="color: white; background-color: #3769C6; vertical-align: middle; display: none;" class="text-center izq"># Estilos Exclusivos Tienda</th>
                    <th style="color: white; background-color: #3769C6; vertical-align: middle; display: none;" class="text-center izq"># Estilos Tienda y Paris.cl</th>
                    <th style="color: white; background-color: #3769C6; vertical-align: middle; display: none;" class="text-center izq"># Estilos VeV Exclusivo Tienda</th>
                    <th style="color: white; background-color: #3769C6; vertical-align: middle; display: none;" class="text-center izq"># Estilos Exclusivo Tienda Con Foto</th>
                    <th style="color: white; background-color: #3769C6; vertical-align: middle; display: none;" class="text-center izq"># Estilos VeV Exclusivo Tienda Con Foto</th>
                </tr>
            <?php
            require_once '../paneles.php';

            $ventas = new mysqli('localhost', 'root', '', 'mix_productos');

            if(isset($_GET['fecha'])) {
                $fecha = str_split(utf8_decode($_GET['fecha']));
                $fecha = $fecha[11] . $fecha[12] . $fecha[13] . $fecha[14] . $fecha[8] . $fecha[9] . $fecha[5] . $fecha[6];

                mix($fecha, $ventas);
            }else{
                $fecha = date("Ymd");

                mix($fecha, $ventas);
            }

            ?>
            </table>
            </div>
        <script src="../jquery-1.12.0.min.js"></script>
        <script src="../bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <script src="../bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
        <script src="../bootstrap-datepicker-master/dist/locales/bootstrap-datepicker.es.min.js"></script>
        <script>
            $('.date').datepicker({
                format: 'D, dd/mm/yyyy',
                language: 'es-ES'
            });
        </script>

        <script>
            function colapsar_hor_ver(id){
                var estado = document.querySelectorAll(id);
                var cant   = estado.length;

                for(var i = 0; i < cant; i++){
                    var vista = estado[i].style.display;
                    if(vista == 'none')
                        vista = 'table-cell';
                    else
                        vista = 'none';
                    estado[i].style.display = vista;
                }
            }
        </script>

        <script>
            function colapsar_izq_der(id){
                var estado = document.querySelectorAll(id);
                var cant   = estado.length;

                for(var i = 0; i < cant; i++){
                    var vista = estado[i].style.display;
                    if(vista == 'none')
                        vista = 'table-cell';
                    else
                        vista = 'none';
                    estado[i].style.display = vista;
                }
            }
        </script>
    </body>
</html>