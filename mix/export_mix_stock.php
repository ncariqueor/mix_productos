<?php

$mix = new mysqli('localhost', 'root', '', 'mix_productos');

$ventas = new mysqli('localhost', 'root', '', 'ventas');

$fecha = $_GET['fecha'];

$query = "select estilo, dep, estacion, fecing, tempor, des, prenor,
                 subdep, codmar, origen, empujado_internet, reetiquetado, fecha_disp,
                 existe_tienda, existe_vd, existe_vev, tipo_stock, fecha_foto, estado_foto

          from mix_existencia_stock mix

          where fecha = $fecha";

$res = $mix->query($query);

$name = "Base_Mix_Productos_" . $fecha . ".csv";

header('Content-Type: application/vnd.ms-excel');
header("Content-disposition: attachment; filename=" . $name);

$f = fopen("php://output", "w");

$linea = "Fecha; Estilo; Desc. Estilo; Depto.; Desc. Depto.; Estación; Fecha de Ingreso; Temporada; Precio Normal; Sub Depto.; Marca; Origen; Empujado a Internet; Re-etiquetado; Fecha Disponibilidad; Existe Tienda; Existe V.D.; Existe VeV; Tipo Stock; Tienda; Fecha Foto; Estado Foto;\n";

$linea = utf8_decode($linea);

fwrite($f, $linea);

while($row = mysqli_fetch_assoc($res)){
    $estilo        = $row['estilo'];
    $dep           = $row['dep'];
    $estacion      = $row['estacion'];
    $fecing        = $row['fecing'];
    $tempor        = $row['tempor'];
    $des           = $row['des'];
    $prenor        = $row['prenor'];
    $subdep        = $row['subdep'];
    $codmar        = $row['codmar'];
    $origen        = $row['origen'];
    $empujado      = $row['empujado_internet'];
    $ret           = $row['reetiquetado'];
    $fecha_disp    = $row['fecha_disp'];
    $existe_tienda = $row['existe_tienda'];
    $existe_vd     = $row['existe_vd'];
    $existe_vev    = $row['existe_vev'];
    $tipo_stock    = $row['tipo_stock'];
    $fecha_foto    = $row['fecha_foto'];
    $estado_foto   = $row['estado_foto'];

    $sku_desc = str_split($des);
    $destmp = "";
    $count = count($sku_desc);
    for ($l = 0; $l < $count; $l++) {
        if ($sku_desc[$l] != "'" && $sku_desc[$l] != '"')
            $destmp = $destmp . $sku_desc[$l];
    }

    $des = $destmp;

    $query = "select nomdepto from depto where depto1 = $dep";

    $result = $ventas->query($query);

    $nomdepto = "";

    while($fila = mysqli_fetch_assoc($result)){
        $nomdepto = $fila['nomdepto'];
    }

    if($existe_tienda == 1) {
        $query = "select tienda from depto where depto1 = $dep";

        $result = $ventas->query($query);

        $tienda = "";

        while ($fila = mysqli_fetch_assoc($result)) {
            $tienda = $fila['tienda'];
        }
    }

    if($fecha_foto <> 0 && $estado_foto == "SIN FOTO")
        $estado_foto = "CON FOTO ANTIGUA";

    $linea = "$fecha; $estilo; $des; $dep; $nomdepto; $estacion; $fecing; $tempor; $prenor; $subdep; $codmar; $origen; $empujado; $ret; $fecha_disp; $existe_tienda; $existe_vd; $existe_vev; $tipo_stock; $tienda; $fecha_foto; $estado_foto;\n";

    fwrite($f, $linea);
}

fclose($f);

exit;