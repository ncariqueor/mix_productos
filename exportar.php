<?php

ini_set("max_execution_time", 0);

$mix = new mysqli('localhost', 'root', '', 'mix_productos');

$fecha = $_GET['fecha'];

$query = "select estilo, dep, estacion, fecing, tempor, des, prenor, subdep, codmar, empujado_internet, reetiquetado, fecha_disp, fecha_foto, fecha_ficha, existe_internet  from vista_disp_tienda where fecha = $fecha order by fecing asc";

$res = $mix->query($query);

$name = "Base_Mix_Productos_" . $fecha . ".csv";

header('Content-Type: application/vnd.ms-excel');
header("Content-disposition: attachment; filename=" . $name);

$f = fopen("php://output", "w");

$linea = "Estilo; Departamento; Estacion; Fecha Ingreso; Temporada; Descripcion; Precio Normal; Sub Depto.; Marca; Empujado a Internet; Re-etiquetado; Fecha Disp.; Fecha Foto; Fecha Ficha; Existe Internet;\n";

fwrite($f, $linea);

while($row = mysqli_fetch_assoc($res)){
    $estilo   = $row['estilo'];
    $dep      = $row['dep'];
    $estacion = $row['estacion'];
    $fecing   = $row['fecing'];
    $tempor   = $row['tempor'];
    $des      = $row['des'];
    $prenor   = $row['prenor'];
    $subdep   = $row['subdep'];
    $codmar   = $row['codmar'];
    $empujado = $row['empujado_internet'];
    $retiquet = $row['reetiquetado'];
    $disp     = $row['fecha_disp'];
    $foto     = $row['fecha_foto'];
    $ficha    = $row['fecha_ficha'];
    $existe   = $row['existe_internet'];

    $sku_desc = str_split($des);
    $destmp = "";
    $count = count($sku_desc);
    for ($l = 0; $l < $count; $l++) {
        if ($sku_desc[$l] != "'" && $sku_desc[$l] != '"')
            $destmp = $destmp . $sku_desc[$l];
    }

    $linea = "$estilo; $dep; $estacion; $fecing; $tempor; $destmp; $prenor; $subdep; $codmar; $empujado; $retiquet; $disp; $foto; $ficha; $existe;\n";

    fwrite($f, $linea);
}

fclose($f);
exit;