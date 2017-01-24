<?php

function mix($date, $mix){

    $ventas = new mysqli('localhost','root', '', 'ventas');

    $exclusivo_paris           = querys_mix($date, $mix, "EXCLUSIVO PARIS.CL");

    $exclusivo_tienda          = querys_mix($date, $mix, "EXCLUSIVO TIENDA");

    $tienda_paris              = querys_mix($date, $mix, "TIENDA Y PARIS.CL");

    $vev                       = querys_mix($date, $mix, "VeV EXCLUSIVO TIENDA");

    $exclusivo_tienda_con_foto = querys_mix_foto($date, $mix, "EXCLUSIVO TIENDA");

    $vev_con_foto              = querys_mix_foto($date, $mix, "VeV EXCLUSIVO TIENDA");

    $depto = obtener_deptos($ventas);

    $total_exclusivo_paris  = 0;

    $total_exclusivo_tienda = 0;

    $total_tienda_paris     = 0;

    $total_vev              = 0;

    $total_exclusivo_tienda_con_foto = 0;

    $total_vev_con_foto     = 0;

    foreach($depto as $dep){
        if(isset($exclusivo_paris[$dep]))
            $total_exclusivo_paris  += $exclusivo_paris[$dep];

        if(isset($exclusivo_tienda[$dep]))
            $total_exclusivo_tienda += $exclusivo_tienda[$dep];

        if(isset($tienda_paris[$dep]))
            $total_tienda_paris     += $tienda_paris[$dep];

        if(isset($vev[$dep]))
            $total_vev              += $vev[$dep];

        if(isset($exclusivo_tienda_con_foto[$dep]))
            $total_exclusivo_tienda_con_foto += $exclusivo_tienda_con_foto[$dep];

        if(isset($vev_con_foto[$dep]))
            $total_vev_con_foto     += $vev_con_foto[$dep];
    }

    $total_mix_tienda_paris        = mix_tienda_paris($total_tienda_paris, $total_exclusivo_tienda, $total_vev);

    $total_mix_only_paris          = mix_only_paris($total_exclusivo_paris, $total_tienda_paris, $total_exclusivo_tienda, $total_vev);

    $total_mix_paris_versus_tienda = mix_paris_versus_tienda($total_exclusivo_paris, $total_tienda_paris, $total_exclusivo_tienda, $total_vev);

    $total_mix_only_tienda         = mix_only_tienda($total_tienda_paris, $total_exclusivo_tienda, $total_vev);

    $total_estilos_con_foto        = estilos_con_foto($total_exclusivo_tienda_con_foto, $total_vev_con_foto, $total_tienda_paris, $total_exclusivo_tienda, $total_vev);

    $total_mix_con_Stock_paris_vs_tienda = $total_estilos_con_foto + $total_mix_paris_versus_tienda;

    echo "<tr><td class='text-center' style='background-color: #B5C2DA;'><h5 style='color: #4A76C9;'><b>Total</b></h5></td>";
    echo "<td style='background-color: #B5C2DA'></td>";
    echo "<td style='background-color: #B5C2DA; display: none;' class='izq'><h5 class='text-center'>" . number_format($total_exclusivo_paris, 0, ',', '.') . "</h5></td>";
    echo "<td style='background-color: #B5C2DA; display: none;' class='izq'><h5 class='text-center'>" . number_format($total_exclusivo_tienda, 0, ',', '.') . "</h5></td>";
    echo "<td style='background-color: #B5C2DA; display: none;' class='izq'><h5 class='text-center'>" . number_format($total_tienda_paris, 0, ',', '.') . "</h5></td>";
    echo "<td style='background-color: #B5C2DA; display: none;' class='izq'><h5 class='text-center'>" . number_format($total_vev, 0, ',', '.') . "</h5></td>";
    echo "<td style='background-color: #B5C2DA; display: none;' class='izq'><h5 class='text-center'>" . number_format($total_exclusivo_tienda_con_foto, 0, ',', '.') . "</h5></td>";
    echo "<td style='background-color: #B5C2DA; display: none;' class='izq'><h5 class='text-center'>" . number_format($total_vev_con_foto, 0, ',', '.') . "</h5></td>";

    echo "<td style='background-color: #B5C2DA;'><h5 class='text-center'>" . number_format($total_mix_tienda_paris, 1, ',', '.') . " %</h5></td>";
    echo "<td style='background-color: #B5C2DA;'><h5 class='text-center'>" . number_format($total_mix_only_paris, 1, ',', '.') . " %</h5></td>";
    echo "<td style='background-color: #B5C2DA;'><h5 class='text-center'>" . number_format($total_mix_paris_versus_tienda, 1, ',', '.') . " %</h5></td>";

    echo "<td style='background-color: #B5C2DA; display: none;' class='der'><h5 class='text-center'>" . number_format($total_mix_only_tienda, 1, ',', '.') . " %</h5></td>";
    echo "<td style='background-color: #B5C2DA; display: none;' class='der'><h5 class='text-center'>" . number_format($total_estilos_con_foto, 1, ',', '.') . " %</h5></td>";
    echo "<td style='background-color: #B5C2DA; display: none;' class='der'><h5 class='text-center'>" . number_format($total_mix_con_Stock_paris_vs_tienda, 1, ',', '.') . " %</h5></td></tr>";

    $division = obtener_division($ventas);

    foreach($division as $area){
        $query = "select depto1 from depto where division = '$area' and suni <> '' order by depto1 asc";

        $res = $ventas->query($query);

        $total_exclusivo_paris  = 0;

        $total_exclusivo_tienda = 0;

        $total_tienda_paris     = 0;

        $total_vev              = 0;

        $total_exclusivo_tienda_con_foto = 0;

        $total_vev_con_foto     = 0;

        while($row = mysqli_fetch_assoc($res)){
            $dep = $row['depto1'];

            if(isset($exclusivo_paris[$dep]))
                $total_exclusivo_paris  += $exclusivo_paris[$dep];

            if(isset($exclusivo_tienda[$dep]))
                $total_exclusivo_tienda += $exclusivo_tienda[$dep];

            if(isset($tienda_paris[$dep]))
                $total_tienda_paris     += $tienda_paris[$dep];

            if(isset($vev[$dep]))
                $total_vev              += $vev[$dep];

            if(isset($exclusivo_tienda_con_foto[$dep]))
                $total_exclusivo_tienda_con_foto += $exclusivo_tienda_con_foto[$dep];

            if(isset($vev_con_foto[$dep]))
                $total_vev_con_foto     += $vev_con_foto[$dep];
        }

        $total_mix_tienda_paris        = mix_tienda_paris($total_tienda_paris, $total_exclusivo_tienda, $total_vev);

        $total_mix_only_paris          = mix_only_paris($total_exclusivo_paris, $total_tienda_paris, $total_exclusivo_tienda, $total_vev);

        $total_mix_paris_versus_tienda = mix_paris_versus_tienda($total_exclusivo_paris, $total_tienda_paris, $total_exclusivo_tienda, $total_vev);

        $total_mix_only_tienda         = mix_only_tienda($total_tienda_paris, $total_exclusivo_tienda, $total_vev);

        $total_estilos_con_foto        = estilos_con_foto($total_exclusivo_tienda_con_foto, $total_vev_con_foto, $total_tienda_paris, $total_exclusivo_tienda, $total_vev);

        $total_mix_con_Stock_paris_vs_tienda = $total_estilos_con_foto + $total_mix_paris_versus_tienda;

        $area_tmp = "'.$area'";

        echo "<tr><td class='text-center' style='background-color: #B5C2DA;'><h5 style='color: #4A76C9;'><b>$area</b></h5></td>";
        echo "<td style='background-color: #B5C2DA'></td>";
        echo "<td style='background-color: #B5C2DA; display: none;' class='izq'><h5 class='text-center'>" . number_format($total_exclusivo_paris, 0, ',', '.') . "</h5></td>";
        echo "<td style='background-color: #B5C2DA; display: none;' class='izq'><h5 class='text-center'>" . number_format($total_exclusivo_tienda, 0, ',', '.') . "</h5></td>";
        echo "<td style='background-color: #B5C2DA; display: none;' class='izq'><h5 class='text-center'>" . number_format($total_tienda_paris, 0, ',', '.') . "</h5></td>";
        echo "<td style='background-color: #B5C2DA; display: none;' class='izq'><h5 class='text-center'>" . number_format($total_vev, 0, ',', '.') . "</h5></td>";
        echo "<td style='background-color: #B5C2DA; display: none;' class='izq'><h5 class='text-center'>" . number_format($total_exclusivo_tienda_con_foto, 0, ',', '.') . "</h5></td>";
        echo "<td style='background-color: #B5C2DA; display: none;' class='izq'><h5 class='text-center'>" . number_format($total_vev_con_foto, 0, ',', '.') . "</h5></td>";

        echo "<td style='background-color: #B5C2DA;'><h5 class='text-center'>" . number_format($total_mix_tienda_paris, 1, ',', '.') . " %</h5></td>";
        echo "<td style='background-color: #B5C2DA;'><h5 class='text-center'>" . number_format($total_mix_only_paris, 1, ',', '.') . " %</h5></td>";
        echo "<td style='background-color: #B5C2DA;'><h5 class='text-center'>" . number_format($total_mix_paris_versus_tienda, 1, ',', '.') . " %</h5></td>";

        echo "<td style='background-color: #B5C2DA; display: none;' class='der'><h5 class='text-center'>" . number_format($total_mix_only_tienda, 1, ',', '.') . " %</h5></td>";
        echo "<td style='background-color: #B5C2DA; display: none;' class='der'><h5 class='text-center'>" . number_format($total_estilos_con_foto, 1, ',', '.') . " %</h5></td>";
        echo "<td style='background-color: #B5C2DA; display: none;' class='der'><h5 class='text-center'>" . number_format($total_mix_con_Stock_paris_vs_tienda, 1, ',', '.') . " %</h5></td></tr>";

        $res = $ventas->query($query);

        while($row = mysqli_fetch_assoc($res)){
            $item = $row['depto1'];

            $query = "select nomdepto from depto where depto1 = $item";

            $result = $ventas->query($query);

            $nomdepto = "";

            while($fila = mysqli_fetch_assoc($result)){
                $nomdepto = $fila['nomdepto'];
            }

            if(!isset($exclusivo_paris[$item]))
                $exclusivo_paris[$item] = 0;

            if(!isset($exclusivo_tienda[$item]))
                $exclusivo_tienda[$item] = 0;

            if(!isset($tienda_paris[$item]))
                $tienda_paris[$item] = 0;

            if(!isset($vev[$item]))
                $vev[$item] = 0;

            if(!isset($exclusivo_tienda_con_foto[$item]))
                $exclusivo_tienda_con_foto[$item] = 0;

            if(!isset($vev_con_foto[$item]))
                $vev_con_foto[$item] = 0;

            $mix_tienda_paris        = mix_tienda_paris($tienda_paris[$item], $exclusivo_tienda[$item], $vev[$item]);

            $mix_only_paris          = mix_only_paris($exclusivo_paris[$item], $tienda_paris[$item], $exclusivo_tienda[$item], $vev[$item]);

            $mix_paris_versus_tienda = mix_paris_versus_tienda($exclusivo_paris[$item], $tienda_paris[$item], $exclusivo_tienda[$item], $vev[$item]);

            $mix_only_tienda         = mix_only_tienda($tienda_paris[$item], $exclusivo_tienda[$item], $vev[$item]);

            $estilos_con_foto        = estilos_con_foto($exclusivo_tienda_con_foto[$item], $vev_con_foto[$item], $tienda_paris[$item], $exclusivo_tienda[$item], $vev[$item]);

            $mix_con_Stock_paris_vs_tienda = $estilos_con_foto + $mix_paris_versus_tienda;

            echo "<tr><td></td>";
            echo "<td><h6>$item - $nomdepto</h6></td>";
            echo "<td class='izq' style='display: none;'><h6 class='text-center'>" . number_format($exclusivo_paris[$item], 0, ',', '.') . "</h6></td>";
            echo "<td class='izq' style='display: none;'><h6 class='text-center'>" . number_format($exclusivo_tienda[$item], 0, ',', '.') . "</h6></td>";
            echo "<td class='izq' style='display: none;'><h6 class='text-center'>" . number_format($tienda_paris[$item], 0, ',', '.') . "</h6></td>";
            echo "<td class='izq' style='display: none;'><h6 class='text-center'>" . number_format($vev[$item], 0, ',', '.') . "</h6></td>";
            echo "<td class='izq' style='display: none;'><h6 class='text-center'>" . number_format($exclusivo_tienda_con_foto[$item], 0, ',', '.') . "</h6></td>";
            echo "<td class='izq' style='display: none;'><h6 class='text-center'>" . number_format($vev_con_foto[$item], 0, ',', '.') . "</h6></td>";

            echo "<td><h6 class='text-center'>" . number_format($mix_tienda_paris, 1, ',', '.') . " %</h6></td>";
            echo "<td><h6 class='text-center'>" . number_format($mix_only_paris, 1, ',', '.') . " %</h6></td>";
            echo "<td><h6 class='text-center'>" . number_format($mix_paris_versus_tienda, 1, ',', '.') . " %</h6></td>";

            echo "<td class='der' style='display: none;'><h6 class='text-center'>" . number_format($mix_only_tienda, 1, ',', '.') . " %</h6></td>";
            echo "<td class='der' style='display: none;'><h6 class='text-center'>" . number_format($estilos_con_foto, 1, ',', '.') . " %</h6></td>";
            echo "<td class='der' style='display: none;'><h6 class='text-center'>" . number_format($mix_con_Stock_paris_vs_tienda, 1, ',', '.') . " %</h6></td></tr>";
        }
    }
}

function querys_mix($date, $mix, $tipo_stock){
    $query = "select count(estilo) as cantidad, dep  from mix_existencia_stock where fecha = $date and tipo_stock = '$tipo_stock' group by dep order by dep asc";

    $res = $mix->query($query);

    $cantidad = array();

    while($row = mysqli_fetch_assoc($res)){
        $dep = $row['dep'];
        $cantidad[$dep] = $row['cantidad'];
    }

    return $cantidad;
}

function querys_mix_foto($date, $mix, $tipo_stock){
    $query = "select count(estilo) as cantidad, dep  from mix_existencia_stock where fecha = $date and tipo_stock = '$tipo_stock' and estado_foto = 'CON FOTO'  group by dep order by dep asc";

    $res = $mix->query($query);

    $cantidad = array();

    while($row = mysqli_fetch_assoc($res)){
        $dep = $row['dep'];
        $cantidad[$dep] = $row['cantidad'];
    }

    return $cantidad;
}

function obtener_deptos($ventas){
    $query = "select distinct depto1 from depto where suni <> '' order by depto1 asc";

    $res = $ventas->query($query);

    $depto = array();

    $i = 0;

    while($row = mysqli_fetch_assoc($res)){
        $depto[$i] = $row['depto1'];
        $i++;
    }

    return $depto;
}

function obtener_division($ventas){
    $query = "select distinct division from depto where division not in ('OTROS', '')";

    $res = $ventas->query($query);

    $division = array();

    $i = 0;

    while($row = mysqli_fetch_assoc($res)){
        $division[$i] = $row['division'];
        $i++;
    }

    return $division;
}

function mix_tienda_paris($tienda_paris, $exclusivo_tienda, $vev){
    if(($tienda_paris + $exclusivo_tienda + $vev) != 0)
        return round(($tienda_paris / ($tienda_paris + $exclusivo_tienda + $vev)) * 100, 1);
    else
        return 0;
}

function mix_only_paris($exclusivo_paris, $tienda_paris, $exclusivo_tienda, $vev){
    if(($tienda_paris + $exclusivo_tienda + $vev) != 0)
        return round(($exclusivo_paris / ($tienda_paris + $exclusivo_tienda + $vev)) * 100, 1);
    else
        return 0;
}

function mix_paris_versus_tienda($exclusivo_paris, $tienda_paris, $exclusivo_tienda, $vev){
    if(($tienda_paris + $exclusivo_tienda + $vev) != 0)
        return round((($exclusivo_paris + $tienda_paris) / ($tienda_paris + $exclusivo_tienda + $vev)) * 100, 1);
    else
        return 0;
}

function mix_only_tienda($tienda_paris, $exclusivo_tienda, $vev){
    if(($tienda_paris + $exclusivo_tienda + $vev) != 0)
        return round(($exclusivo_tienda / ($tienda_paris + $exclusivo_tienda + $vev)) * 100, 1);
    else
        return 0;
}

function estilos_con_foto($exclusivo_tienda_con_foto, $vev_con_foto, $tienda_paris, $exclusivo_tienda, $vev){
    if(($tienda_paris + $exclusivo_tienda + $vev) != 0)
        return round((($exclusivo_tienda_con_foto + $vev_con_foto) / ($tienda_paris + $exclusivo_tienda + $vev)) * 100, 1);
    else
        return 0;
}
