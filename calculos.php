<?php

function mix_por_depto($mix, $fecha)
{
    $mix->query("delete from mix_por_depto where fecha = $fecha");

    ini_set("max_execution_time", 0);

    $query = "select distinct dep from vista_disp_tienda where fecha = $fecha order by dep asc";

    $res = $mix->query($query);

    $depto = array();

    $i = 0;

    while ($row = mysqli_fetch_assoc($res)) {
        $depto[$i] = $row['dep'];
        $i++;
    }

    foreach ($depto as $item) {
        $query = "select existe_internet as esta from vista_disp_tienda where dep = $item and fecha = $fecha";

        $res = $mix->query($query);

        $esta = 0;

        $i = 0;

        while ($row = mysqli_fetch_assoc($res)) {
            $esta += $row['esta'];
            $i++;
        }

        $mix_depto = round(($esta / $i) * 100);

        $insertar = "insert into mix_por_depto values ($fecha, $item, $i, $esta, $mix_depto)";

        if($mix->query($insertar))
            echo "Se inserto con exito por depto Tienda\n";
        else
            echo "Error " . $mix->error . "\n";
    }
}

function mix_por_depto_vev($mix, $fecha)
{
    $mix->query("delete from mix_por_depto_vev where fecha = $fecha");

    ini_set("max_execution_time", 0);

    $query = "select distinct dep from vista_disp_vev where fecha = $fecha order by dep asc";

    $res = $mix->query($query);

    $depto = array();

    $i = 0;

    while ($row = mysqli_fetch_assoc($res)) {
        $depto[$i] = $row['dep'];
        $i++;
    }

    foreach ($depto as $item) {
        $query = "select existe_internet as esta from vista_disp_vev where dep = $item and fecha = $fecha";

        $res = $mix->query($query);

        $esta = 0;

        $i = 0;

        while ($row = mysqli_fetch_assoc($res)) {
            $esta += $row['esta'];
            $i++;
        }

        $mix_depto = round(($esta / $i) * 100);

        $insertar = "insert into mix_por_depto_vev values ($fecha, $item, $i, $esta, $mix_depto)";

        if($mix->query($insertar))
            echo "Se inserto con exito por depto VeV\n";
        else
            echo "Error " . $mix->error . "\n";
    }
}


