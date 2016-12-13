<!DOCTYPE html>
<html>
<head>
    <title>Mix de Productos</title>
    <link rel="stylesheet" type="text/css" href="bootstrap-3.3.6-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap-select-1.9.4/dist/css/bootstrap-select.css"/>
    <link rel="stylesheet" type="text/css" href="estilo.css" />
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-88784345-1', 'auto');
        ga('send', 'pageview');

    </script>
</head>

<body onload="asignar();">
<script>
    function asignar(){
        var dia = document.getElementById("dia").value;
        var mes = document.getElementById("mes").value;
        var anio = document.getElementById("anio").value;

        var fecha = anio+mes+dia;

        document.getElementById("exportar").href = "exportar.php?fecha="+fecha;
        document.getElementById("exportar2").href = "exportar_vev.php?fecha="+fecha;
    }
</script>

<header class="container">
    <nav class="navbar navbar-default">
        <div class="btn-group-sm">
            <div class="row">
                <div class="col-md-12"><h3 class="text-center"><a href="http://10.95.17.114/paneles"><img src="paris.png" width="140px" height="100px" title="Reportes Paris"></a> Informe Mix de Productos</h3></div>
            </div><br>

            <form action="index.php" method="post" class="row">
                <div class="col-lg-4 col-md-4">
                    <label class="label label-primary">Actual</label>
                    <select name="dia" id="dia" class="selectpicker" title="Día" data-style="btn btn-default btn-sm" data-width="50px" onchange="asignar();">
                        <?php
                        date_default_timezone_set("America/Asuncion");
                        if(isset($_POST['dia'])){
                            $select = $_POST['dia'];
                            $actual = date("d");

                            $d = date("Ymd");

                            $d = new DateTime($d);

                            $d = $d->modify('last day of this month');

                            for($day = 1; $day <= 31; $day++){
                                $dia = $day;
                                if(strlen($dia) < 2)
                                    $dia = '0'.$dia;
                                if($select == $dia)
                                    echo "<option selected='selected' value='" . $dia . "'>" . $dia . "</option>";
                                else
                                    echo "<option value='" . $dia . "'>" . $dia . "</option>";
                            }
                        }else{
                            $actual = date("d");

                            $d = date("Ymd");

                            $d = new DateTime($d);

                            $d = $d->modify('last day of this month');

                            for($day = '01'; $day <= 31; $day++) {
                                $dia = $day;
                                if(strlen($dia) < 2)
                                    $dia = '0'.$dia;
                                if ($actual == $dia)
                                    echo "<option value='" . $dia . "' selected='selected'>" . $dia . "</option>";
                                else
                                    echo "<option value='" . $dia . "'>" . $dia . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <select name="mes" id="mes" class="selectpicker" title="Mes" data-style="btn btn-default btn-sm" data-width="100px" onchange="asignar();">
                        <?php
                        if(isset($_POST['mes'])){
                            $mes = $_POST['mes'];
                            if($mes == '01') {
                                echo "<option value='01' selected='selected'>Enero</option>";
                                echo "<option value='02'>Febrero</option>";
                                echo "<option value='03'>Marzo</option>";
                                echo "<option value='04'>Abril</option>";
                                echo "<option value='05'>Mayo</option>";
                                echo "<option value='06'>Junio</option>";
                                echo "<option value='07'>Julio</option>";
                                echo "<option value='08'>Agosto</option>";
                                echo "<option value='09'>Septiembre</option>";
                                echo "<option value='10'>Octubre</option>";
                                echo "<option value='11'>Noviembre</option>";
                                echo "<option value='12'>Diciembre</option>";
                            }else{
                                if($mes == '02'){
                                    echo "<option value='01'>Enero</option>";
                                    echo "<option value='02' selected='selected'>Febrero</option>";
                                    echo "<option value='03'>Marzo</option>";
                                    echo "<option value='04'>Abril</option>";
                                    echo "<option value='05'>Mayo</option>";
                                    echo "<option value='06'>Junio</option>";
                                    echo "<option value='07'>Julio</option>";
                                    echo "<option value='08'>Agosto</option>";
                                    echo "<option value='09'>Septiembre</option>";
                                    echo "<option value='10'>Octubre</option>";
                                    echo "<option value='11'>Noviembre</option>";
                                    echo "<option value='12'>Diciembre</option>";
                                } else{
                                    if($mes == '03'){
                                        echo "<option value='01'>Enero</option>";
                                        echo "<option value='02'>Febrero</option>";
                                        echo "<option value='03' selected='selected'>Marzo</option>";
                                        echo "<option value='04'>Abril</option>";
                                        echo "<option value='05'>Mayo</option>";
                                        echo "<option value='06'>Junio</option>";
                                        echo "<option value='07'>Julio</option>";
                                        echo "<option value='08'>Agosto</option>";
                                        echo "<option value='09'>Septiembre</option>";
                                        echo "<option value='10'>Octubre</option>";
                                        echo "<option value='11'>Noviembre</option>";
                                        echo "<option value='12'>Diciembre</option>";
                                    }else{
                                        if($mes == '04'){
                                            echo "<option value='01'>Enero</option>";
                                            echo "<option value='02'>Febrero</option>";
                                            echo "<option value='03'>Marzo</option>";
                                            echo "<option value='04' selected='selected'>Abril</option>";
                                            echo "<option value='05'>Mayo</option>";
                                            echo "<option value='06'>Junio</option>";
                                            echo "<option value='07'>Julio</option>";
                                            echo "<option value='08'>Agosto</option>";
                                            echo "<option value='09'>Septiembre</option>";
                                            echo "<option value='10'>Octubre</option>";
                                            echo "<option value='11'>Noviembre</option>";
                                            echo "<option value='12'>Diciembre</option>";
                                        }else{
                                            if($mes == '05'){
                                                echo "<option value='01'>Enero</option>";
                                                echo "<option value='02'>Febrero</option>";
                                                echo "<option value='03'>Marzo</option>";
                                                echo "<option value='04'>Abril</option>";
                                                echo "<option value='05' selected='selected'>Mayo</option>";
                                                echo "<option value='06'>Junio</option>";
                                                echo "<option value='07'>Julio</option>";
                                                echo "<option value='08'>Agosto</option>";
                                                echo "<option value='09'>Septiembre</option>";
                                                echo "<option value='10'>Octubre</option>";
                                                echo "<option value='11'>Noviembre</option>";
                                                echo "<option value='12'>Diciembre</option>";
                                            }else{
                                                if($mes == '06'){
                                                    echo "<option value='01'>Enero</option>";
                                                    echo "<option value='02'>Febrero</option>";
                                                    echo "<option value='03'>Marzo</option>";
                                                    echo "<option value='04'>Abril</option>";
                                                    echo "<option value='05'>Mayo</option>";
                                                    echo "<option value='06' selected='selected'>Junio</option>";
                                                    echo "<option value='07'>Julio</option>";
                                                    echo "<option value='08'>Agosto</option>";
                                                    echo "<option value='09'>Septiembre</option>";
                                                    echo "<option value='10'>Octubre</option>";
                                                    echo "<option value='11'>Noviembre</option>";
                                                    echo "<option value='12'>Diciembre</option>";
                                                }else{
                                                    if($mes == '07'){
                                                        echo "<option value='01'>Enero</option>";
                                                        echo "<option value='02'>Febrero</option>";
                                                        echo "<option value='03'>Marzo</option>";
                                                        echo "<option value='04'>Abril</option>";
                                                        echo "<option value='05'>Mayo</option>";
                                                        echo "<option value='06'>Junio</option>";
                                                        echo "<option value='07' selected='selected'>Julio</option>";
                                                        echo "<option value='08'>Agosto</option>";
                                                        echo "<option value='09'>Septiembre</option>";
                                                        echo "<option value='10'>Octubre</option>";
                                                        echo "<option value='11'>Noviembre</option>";
                                                        echo "<option value='12'>Diciembre</option>";
                                                    }else{
                                                        if($mes == '08'){
                                                            echo "<option value='01'>Enero</option>";
                                                            echo "<option value='02'>Febrero</option>";
                                                            echo "<option value='03'>Marzo</option>";
                                                            echo "<option value='04'>Abril</option>";
                                                            echo "<option value='05'>Mayo</option>";
                                                            echo "<option value='06'>Junio</option>";
                                                            echo "<option value='07'>Julio</option>";
                                                            echo "<option value='08' selected='selected'>Agosto</option>";
                                                            echo "<option value='09'>Septiembre</option>";
                                                            echo "<option value='10'>Octubre</option>";
                                                            echo "<option value='11'>Noviembre</option>";
                                                            echo "<option value='12'>Diciembre</option>";
                                                        }else{
                                                            if($mes == '09'){
                                                                echo "<option value='01'>Enero</option>";
                                                                echo "<option value='02'>Febrero</option>";
                                                                echo "<option value='03'>Marzo</option>";
                                                                echo "<option value='04'>Abril</option>";
                                                                echo "<option value='05'>Mayo</option>";
                                                                echo "<option value='06'>Junio</option>";
                                                                echo "<option value='07'>Julio</option>";
                                                                echo "<option value='08'>Agosto</option>";
                                                                echo "<option value='09' selected='selected'>Septiembre</option>";
                                                                echo "<option value='10'>Octubre</option>";
                                                                echo "<option value='11'>Noviembre</option>";
                                                                echo "<option value='12'>Diciembre</option>";
                                                            }else{
                                                                if($mes == '10'){
                                                                    echo "<option value='01'>Enero</option>";
                                                                    echo "<option value='02'>Febrero</option>";
                                                                    echo "<option value='03'>Marzo</option>";
                                                                    echo "<option value='04'>Abril</option>";
                                                                    echo "<option value='05'>Mayo</option>";
                                                                    echo "<option value='06'>Junio</option>";
                                                                    echo "<option value='07'>Julio</option>";
                                                                    echo "<option value='08'>Agosto</option>";
                                                                    echo "<option value='09'>Septiembre</option>";
                                                                    echo "<option value='10' selected='selected'>Octubre</option>";
                                                                    echo "<option value='11'>Noviembre</option>";
                                                                    echo "<option value='12'>Diciembre</option>";
                                                                }else{
                                                                    if($mes == '11'){
                                                                        echo "<option value='01'>Enero</option>";
                                                                        echo "<option value='02'>Febrero</option>";
                                                                        echo "<option value='03'>Marzo</option>";
                                                                        echo "<option value='04'>Abril</option>";
                                                                        echo "<option value='05'>Mayo</option>";
                                                                        echo "<option value='06'>Junio</option>";
                                                                        echo "<option value='07'>Julio</option>";
                                                                        echo "<option value='08'>Agosto</option>";
                                                                        echo "<option value='09'>Septiembre</option>";
                                                                        echo "<option value='10'>Octubre</option>";
                                                                        echo "<option value='11' selected='selected'>Noviembre</option>";
                                                                        echo "<option value='12'>Diciembre</option>";
                                                                    }else{
                                                                        if($mes == '12'){
                                                                            echo "<option value='01'>Enero</option>";
                                                                            echo "<option value='02'>Febrero</option>";
                                                                            echo "<option value='03'>Marzo</option>";
                                                                            echo "<option value='04'>Abril</option>";
                                                                            echo "<option value='05'>Mayo</option>";
                                                                            echo "<option value='06'>Junio</option>";
                                                                            echo "<option value='07'>Julio</option>";
                                                                            echo "<option value='08'>Agosto</option>";
                                                                            echo "<option value='09'>Septiembre</option>";
                                                                            echo "<option value='10'>Octubre</option>";
                                                                            echo "<option value='11'>Noviembre</option>";
                                                                            echo "<option value='12' selected='selected'>Diciembre</option>";
                                                                        }else{
                                                                            echo "<option value='01'>Enero</option>";
                                                                            echo "<option value='02'>Febrero</option>";
                                                                            echo "<option value='03'>Marzo</option>";
                                                                            echo "<option value='04'>Abril</option>";
                                                                            echo "<option value='05'>Mayo</option>";
                                                                            echo "<option value='06'>Junio</option>";
                                                                            echo "<option value='07'>Julio</option>";
                                                                            echo "<option value='08'>Agosto</option>";
                                                                            echo "<option value='09'>Septiembre</option>";
                                                                            echo "<option value='10'>Octubre</option>";
                                                                            echo "<option value='11'>Noviembre</option>";
                                                                            echo "<option value='12'>Diciembre</option>";
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }else{
                            if(date("m") == '01')
                                echo "<option value='01' selected='selected'>Enero</option>";
                            else
                                echo "<option value='01'>Enero</option>";

                            if(date("m") === '02')
                                echo "<option value='02' selected='selected'>Febrero</option>";
                            else
                                echo "<option value='02'>Febrero</option>";

                            if(date("m") == '03')
                                echo "<option value='03' selected='selected'>Marzo</option>";
                            else
                                echo "<option value='03'>Marzo</option>";

                            if(date("m") == '04')
                                echo "<option value='04' selected='selected'>Abril</option>";
                            else
                                echo "<option value='04'>Abril</option>";

                            if(date("m") == '05')
                                echo "<option value='05' selected='selected'>Mayo</option>";
                            else
                                echo "<option value='05'>Mayo</option>";

                            if(date("m") == '06')
                                echo "<option value='06' selected='selected'>Junio</option>";
                            else
                                echo "<option value='06'>Junio</option>";

                            if(date("m") == '07')
                                echo "<option value='07' selected='selected'>Julio</option>";
                            else
                                echo "<option value='07'>Julio</option>";

                            if(date("m") == '08')
                                echo "<option value='08' selected='selected'>Agosto</option>";
                            else
                                echo "<option value='08'>Agosto</option>";

                            if(date("m") == '09')
                                echo "<option value='09' selected='selected'>Septiembre</option>";
                            else
                                echo "<option value='09'>Septiembre</option>";

                            if(date("m") == '10')
                                echo "<option value='10' selected='selected'>Octubre</option>";
                            else
                                echo "<option value='10'>Octubre</option>";

                            if(date("m") == '11')
                                echo "<option value='11' selected='selected'>Noviembre</option>";
                            else
                                echo "<option value='11'>Noviembre</option>";

                            if(date("m") == '12')
                                echo "<option value='12' selected='selected'>Diciembre</option>";
                            else
                                echo "<option value='12'>Diciembre</option>";
                        }
                        ?>
                    </select>
                    <select name="anio" id="anio" class="selectpicker" title="Año" data-style="btn btn-default btn-sm" data-width="70px" onchange="asignar();">
                        <?php
                        if(isset($_POST['anio'])){
                            $anio = $_POST['anio'];
                            $actual = date("Y");
                            for($dia = 2015; $dia <= $actual; $dia++){
                                if($anio == $dia)
                                    echo "<option selected='selected' value='" . $dia . "'>" . $dia . "</option>";
                                else
                                    echo "<option value='" . $dia . "'>" . $dia . "</option>";
                            }
                        }else{
                            $actual = date("Y");
                            for($dia = 2015; $dia <= $actual; $dia++) {
                                if (date("Y") == $dia)
                                    echo "<option value='" . $dia . "' selected='selected'>" . $dia . "</option>";
                                else
                                    echo "<option value='" . $dia . "'>" . $dia . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-lg-1 col-md-2">
                    <button class="btn btn-primary btn-sm" style="width: 100px;">Actualizar</button>
                </div>

                <div class="col-lg-2 col-md-2">
                    <a id="exportar" class="btn btn-success btn-sm" href="#">Exportar Base Tiendas</a>
                </div>

                <div class="col-lg-1 col-md-1">
                    <a id="exportar2" class="btn btn-success btn-sm" href="#">Exportar Base VeV</a>
                </div>

                <div class="col-lg-1 col-md-1">
                    <a class="btn btn-default btn-sm" href="query.php" style="margin-left: 200px;">Query Mix de Productos <img id="txt" src="images.png"></a>
                </div>

            </form>
        </div>
    </nav>
</header>

<div style="width: 80%; margin: 0 auto;">
    <?php
    $fecha = date("Ymd");
    if(isset($_POST['dia']) && isset($_POST['mes']) && isset($_POST['anio'])) {
        $dia = $_POST['dia'];
        $mes = $_POST['mes'];
        $anio = $_POST['anio'];
        $fecha = $anio . $mes . $dia;
    }

    ini_set("max_execution_time", 0);
    $ventas = new mysqli('localhost', 'root', '', 'ventas');

    $mix_productos    = new mysqli('localhost', 'root', '', 'mix_productos');

    $query  = "select distinct division from depto where division <> '' order by length(division) desc";

    $res = $ventas->query($query);

    $division = array();

    $i = 0;

    while($row = mysqli_fetch_assoc($res)){
        $division[$i] = $row['division'];
        $i++;
    }

    echo "<table class='table table-condensed'>";
    echo "<thead style='background-color: #305496; color: white;'> <th>División</th> <th>Departamento</th> <th># Estilos Tiendas</th> <th># Estilos Paris.cl</th> <th style='border-right: 1px solid white;'>% Estilos Paris.cl v/s Tienda</th>";
    echo "<th># Estilos VeV</th> <th># Estilos Paris.cl</th> <th style='border-right: 1px solid white;'>% Estilos Paris.cl v/s VeV</th> <th>Total Estilo Tiendas</th> <th>Total Estilo Paris.cl</th> <th>% Total Estilos Paris.cl v/s Total Estilo Tiendas</th> </thead>";

    //CALCULO TIENDA

    $query = "select sum(paris) as paris, sum(internet) as internet from mix_por_depto where fecha = $fecha";

    $res = $mix_productos->query($query);

    $paris    = 0;

    $internet = 0;

    $mix      = 0;

    while($row = mysqli_fetch_assoc($res)){
        $paris    = $row['paris'];
        $internet = $row['internet'];
    }

    if($paris > 0)
        $mix = round(($internet / $paris) * 100);

    //CALCULO VeV

    $query = "select sum(paris) as paris, sum(internet) as internet from mix_por_depto_vev where fecha = $fecha";

    $res = $mix_productos->query($query);

    $vev    = 0;

    $internet_vev = 0;

    $mix_vev      = 0;

    while($row = mysqli_fetch_assoc($res)){
        $vev    = $row['paris'];
        $internet_vev = $row['internet'];
    }

    if($vev > 0)
        $mix_vev = round(($internet_vev / $vev) * 100);

    $total_tiendas = $paris;

    $total_internet = $internet + $internet_vev;

    $mix_total = 0;

    if($total_tiendas > 0)
        $mix_total = round(($total_internet / $total_tiendas) * 100);

    $color =  "#8EA9DB";

    echo "<tr><td class='text-center' style='background-color: $color; color: white;'><b>Total</b></td>";
    echo "<td style='background-color: $color'></td>";
    echo "<td class='text-center' style='background-color: $color; color: white;'><h5><b>" . number_format($paris, 0, ',', '.') . "</b></h5></td>";
    echo "<td class='text-center' style='background-color: $color; color: white;'><h5><b>" . number_format($internet, 0, ',', '.') . "</b></h5></td>";
    echo "<td class='text-center' style='background-color: $color; color: white; border-right: 1px solid white;'><h5><b>" . number_format($mix, 0, ',', '.') . " %</b></h5></td>";
    echo "<td class='text-center' style='background-color: $color; color: white;'><h5><b>" . number_format($vev, 0, ',', '.') . "</b></h5></td>";
    echo "<td class='text-center' style='background-color: $color; color: white;'><h5><b>" . number_format($internet_vev, 0, ',', '.') . "</b></h5></td>";
    echo "<td class='text-center' style='background-color: $color; color: white; border-right: 1px solid white;'><h5><b>" . number_format($mix_vev, 0, ',', '.') . " %</b></h5></td>";
    echo "<td class='text-center' style='background-color: $color; color: white;'><h5><b>" . number_format($total_tiendas, 0, ',', '.') . "</b></h5></td>";
    echo "<td class='text-center' style='background-color: $color; color: white;'><h5><b>" . number_format($total_internet, 0, ',', '.') . "</b></h5></td>";
    echo "<td class='text-center' style='background-color: $color; color: white;'><h5><b>" . number_format($mix_total, 0, ',', '.') . " %</b></h5></td></tr>";


    $color1 = "#B4C6E7";

    foreach($division as $item){
        $titulo = ucfirst(strtolower($item));

        echo '<tr><td class="text-center" style="background-color:' . $color1 . ';"><a href="#" style="font-size: 15px; text-decoration: none;" onclick="mostrar'; echo "('.$item'); return false;"; echo '"><b>' . $titulo . '</b></a></td>';
        echo "<td style='background-color: $color1;'></td>";

        $query = "select depto1 from depto where division = '$item'";

        $res = $ventas->query($query);

        $en = "(";

        $cant = mysqli_num_rows($res);

        $i = 0;

        while($row = mysqli_fetch_assoc($res)){
            $en = $en . $row['depto1'];
            if($i < $cant - 1)
                $en = $en . ",";

            $i++;
        }

        $en = $en . ")";

        $query = "select sum(paris) as paris, sum(internet) as internet from mix_por_depto where depto in $en and fecha = $fecha";

        $res = $mix_productos->query($query);

        $paris    = 0;

        $internet = 0;

        $mix      = 0;

        while($row = mysqli_fetch_assoc($res)){
            $paris    = $row['paris'];
            $internet = $row['internet'];
        }

        if($paris > 0)
            $mix = round(($internet / $paris) * 100);

        $query = "select sum(paris) as paris, sum(internet) as internet from mix_por_depto_vev where depto in $en and fecha = $fecha";

        $res = $mix_productos->query($query);

        $vev    = 0;

        $internet_vev = 0;

        $mix_vev      = 0;

        while($row = mysqli_fetch_assoc($res)){
            $vev    = $row['paris'];
            $internet_vev = $row['internet'];
        }

        if($vev > 0)
            $mix_vev = round(($internet_vev / $vev) * 100);

        $total_tiendas = $paris;
        $total_internet = $internet_vev + $internet;
        $mix_total = 0;
        if($total_tiendas > 0)
            $mix_total = round(($total_internet / $total_tiendas) * 100);

        echo "<td class='text-center' style='background-color: $color1'><h5><b>" . number_format($paris, 0, ',', '.') . "</b></h5></td>";
        echo "<td class='text-center' style='background-color: $color1'><h5><b>" . number_format($internet, 0, ',', '.') . "</b></h5></td>";
        echo "<td class='text-center' style='background-color: $color1;  border-right: 1px solid white;'><h5><b>" . number_format($mix, 0, ',', '.') . " %</b></h5></td>";
        echo "<td class='text-center' style='background-color: $color1'><h5><b>" . number_format($vev, 0, ',', '.') . "</b></h5></td>";
        echo "<td class='text-center' style='background-color: $color1'><h5><b>" . number_format($internet_vev, 0, ',', '.') . "</b></h5></td>";
        echo "<td class='text-center' style='background-color: $color1;  border-right: 1px solid white;'><h5><b>" . number_format($mix_vev, 0, ',', '.') . " %</b></h5></td>";
        echo "<td class='text-center' style='background-color: $color1'><h5><b>" . number_format($total_tiendas, 0, ',', '.') . "</b></h5></td>";
        echo "<td class='text-center' style='background-color: $color1'><h5><b>" . number_format($total_internet, 0, ',', '.') . "</b></h5></td>";
        echo "<td class='text-center' style='background-color: $color1'><h5><b>" . number_format($mix_total, 0, ',', '.') . " %</b></h5></td></tr>";

        $query = "select depto1, nomdepto from depto where division = '$item' order by depto1 asc";

        $res = $ventas->query($query);

        $color2 = "#D9E1F2";

        while($row = mysqli_fetch_assoc($res)){
            $depto    = $row['depto1'];
            $nomdepto = $row['nomdepto'];

            $query = "select paris, internet, mix from mix_por_depto where depto = $depto and fecha = $fecha";

            $res2 = $mix_productos->query($query);

            $paris    = 0;
            $internet = 0;
            $mix      = 0;

            while($row2 = mysqli_fetch_assoc($res2)){
                $paris    = $row2['paris'];
                $internet = $row2['internet'];
                $mix      = $row2['mix'];
            }

            $query = "select paris, internet, mix from mix_por_depto_vev where depto = $depto and fecha = $fecha";

            $res2 = $mix_productos->query($query);

            $vev    = 0;
            $internet_vev = 0;
            $mix_vev      = 0;

            while($row2 = mysqli_fetch_assoc($res2)){
                $vev    = $row2['paris'];
                $internet_vev = $row2['internet'];
                $mix_vev      = $row2['mix'];
            }

            $total_tiendas = $paris;
            $total_internet = $internet + $internet_vev;
            $mix_total = 0;
            if($total_tiendas > 0)
                $mix_total = round(($total_internet / $total_tiendas) * 100);

            echo "<tr><td class='$item' style='display: none; background-color: $color1; border-top: 1px solid $color1;'></td>";
            echo "<td class='$item' style='display: none; background-color: $color2; color: #868A8E;'><h5 class='text-center'><b>$depto - $nomdepto</b><h5></td>";
            echo "<td class='$item' style='display: none; background-color: $color2; color: #868A8E;'><h5 class='text-center'><b>" . number_format($paris, 0, ',', '.') . "</b></h5></td>";
            echo "<td class='$item' style='display: none; background-color: $color2; color: #868A8E;'><h5 class='text-center'><b>" . number_format($internet, 0, ',', '.') . "</b></h5></td>";
            echo "<td class='$item' style='display: none; background-color: $color2; color: #868A8E;'><h5 class='text-center'><b>" . number_format($mix, 0, ',', '.') . " %</b></h5></td>";
            echo "<td class='$item' style='display: none; background-color: $color2; color: #868A8E;'><h5 class='text-center'><b>" . number_format($vev, 0, ',', '.') . "</b></h5></td>";
            echo "<td class='$item' style='display: none; background-color: $color2; color: #868A8E;'><h5 class='text-center'><b>" . number_format($internet_vev, 0, ',', '.') . "</b></h5></td>";
            echo "<td class='$item' style='display: none; background-color: $color2; color: #868A8E;'><h5 class='text-center'><b>" . number_format($mix_vev, 0, ',', '.') . " %</b></h5></td>";
            echo "<td class='$item' style='display: none; background-color: $color2; color: #868A8E;'><h5 class='text-center'><b>" . number_format($total_tiendas, 0, ',', '.') . "</b></h5></td>";
            echo "<td class='$item' style='display: none; background-color: $color2; color: #868A8E;'><h5 class='text-center'><b>" . number_format($total_internet, 0, ',', '.') . "</b></h5></td>";
            echo "<td class='$item' style='display: none; background-color: $color2; color: #868A8E;'><h5 class='text-center'><b>" . number_format($mix_total, 0, ',', '.') . " %</b></h5></td></tr>";
        }
    }
    echo "</table>";

    ?>
</div>
<script src="jquery-1.12.0.min.js"></script>
<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="bootstrap-select-1.9.4/dist/js/bootstrap-select.min.js"></script>
<script>
    function mostrar(id){
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