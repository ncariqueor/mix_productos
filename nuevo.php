<?php

ini_set("max_execution_time", 0);

$cat = new mysqli('localhost', 'root', '', 'catalogo');

$mant = new mysqli('localhost', 'root', '', 'mantigua');

$mix     = new mysqli('localhost', 'root', '', 'mix_productos');

$ventas = new mysqli('localhost', 'root', '', 'ventas');

$roble = odbc_connect('CECEBUGD', 'USRVNP', 'USRVNP');

$inicio = date("Ym", strtotime("-3 month"));

$inicio = $inicio . '01';

$fin    = date("Ymd");

/*$mix->query("delete from mix_tiendas where fecha = $fin");

$query = "select depto1, suni from depto where suni <> '' order by depto1 asc";

$res = $ventas->query($query);

while($row = mysqli_fetch_assoc($res)){
    $depto = $row['depto1'];
    $suni  = $row['suni'];

    $query = "SELECT EXKPF01.ESTILO, EXKPF01.DEP, EXKPF01.ESTACION, GGREFX.FECING, EXKPF01.TEMPOR, GGREFX.SUBDEP, GGREFX.DES,
                     EXKPF01.PRENOR, EXKPF01.CODMAR, GGREFX.$suni

              FROM   RDBPARIS2.EXGCBUGD.EXKPF01 EXKPF01, RDBPARIS2.EXGCBUGD.GGREFX GGREFX

              WHERE  GGREFX.REF = EXKPF01.REF AND GGREFX.DEP = $depto AND GGREFX.$suni > 0 AND GGREFX.FECING >= $inicio order by EXKPF01.ESTILO ASC";

    $result = odbc_exec($roble, $query);

    while(odbc_fetch_row($result)){
        $estilo   = odbc_result($result, 1);
        $dep      = odbc_result($result, 2);
        $estacion = odbc_result($result, 3);
        $fecing   = odbc_result($result, 4);
        $tempor   = odbc_result($result, 5);
        $subdep   = odbc_result($result, 6);
        $des      = odbc_result($result, 7);
        $prenor   = odbc_Result($result, 8);
        $codmar   = odbc_result($result, 9);
        $suni     = odbc_result($result, 10);

        $sku_desc = str_split($des);
        $sku_desctmp = "";
        $count = count($sku_desc);
        for ($k = 0; $k < $count; $k++) {
            if ($sku_desc[$k] == "'")
                $sku_desctmp = $sku_desctmp . "'" . $sku_desc[$k];
            else
                $sku_desctmp = $sku_desctmp . $sku_desc[$k];
        }

        $query = "insert into mix_tiendas values ($fin, $estilo, $dep, '$estacion', $fecing, '$tempor', '$sku_desctmp', $prenor, $subdep, '$codmar', $suni)";

        $mix->query($query);
    }
}*/

$query = "select mix_productos.vista_disp_tienda.fecha,    mix_productos.vista_disp_tienda.estilo, mix_productos.vista_disp_tienda.dep,
                 mix_productos.vista_disp_tienda.estacion, mix_productos.vista_disp_tienda.fecing, mix_productos.vista_disp_tienda.tempor,
                 mix_productos.vista_disp_tienda.des,      mix_productos.vista_disp_tienda.prenor, mix_productos.vista_disp_tienda.subdep,
                 mix_productos.vista_disp_tienda.codmar

          from mix_productos.vista_disp_tienda where mix_productos.vista_disp_tienda.fecha = $fin

          union

          select catalogo.vista_disponibilidad.fecha, substring(catalogo.vista_disponibilidad.item_name, 1, 6) as estilo, catalogo.vista_disponibilidad.dep,
                 catalogo.vista_disponibilidad.estacion, catalogo.vista_disponibilidad.fecing, catalogo.vista_disponibilidad.tempor,
                 catalogo.vista_disponibilidad.des_roble as des, catalogo.vista_disponibilidad.prenor, catalogo.vista_disponibilidad.subdep,
                 catalogo.vista_disponibilidad.codmar

          from catalogo.vista_disponibilidad where catalogo.vista_disponibilidad.fecha = $fin and catalogo.vista_disponibilidad.fecing >= $inicio";

$res = $cat->query($query);

$mix->query("delete from vista_disp_tienda where fecha = $fin");

while($row = mysqli_fetch_assoc($res)){
    $fecha    = $row['fecha'];
    $estilo   = $row['estilo'];
    $dep      = $row['dep'];
    $estacion = $row['estacion'];
    $fecing   = $row['fecing'];
    $tempor   = $row['tempor'];
    $des      = $row['des'];
    $prenor   = $row['prenor'];
    $subdep   = $row['subdep'];
    $codmar   = $row['codmar'];
    $llave    = $estilo . $fecha;

    $sku_desc = str_split($des);
    $sku_desctmp = "";
    $count = count($sku_desc);
    for ($k = 0; $k < $count; $k++) {
        if ($sku_desc[$k] == "'")
            $sku_desctmp = $sku_desctmp . "'" . $sku_desc[$k];
        else
            $sku_desctmp = $sku_desctmp . $sku_desc[$k];
    }

    //VERIFICAR FOTO

    $query = "select max(lastmodified) as lastmodified from mix where id = $estilo";

    $resultado = $cat->query($query);

    $fecha_foto = 0;

    $esta = 0;

    while ($row = mysqli_fetch_assoc($resultado)) {
        if ($row['lastmodified'] != NULL) {
            $fecha_foto = $row['lastmodified'];
        }
    }

    //VERIFICAR FICHA

    $query = "select max(fecha_creacion) as fecha_creacion from creaciontmp where id = $estilo";

    $resultado = $cat->query($query);

    $fecha_creacion = 0;

    while ($row = mysqli_fetch_assoc($resultado)) {
        if ($row['fecha_creacion'] != NULL)
            $fecha_creacion = $row['fecha_creacion'];
    }

    $esta = 0;

    if ($fecha_creacion > 0 && $fecha_foto > 0)
        $esta = 1;

    $query = "select max(fecingret) as fecingret from rettmp where id = $estilo";

    $resultado = $mant->query($query);

    $fecingret = 0;

    while ($row = mysqli_fetch_assoc($resultado)) {
        if ($row['fecingret'] != NULL)
            $fecingret = $row['fecingret'];
    }

    $query = "select min(fecdig) as fecdig from trastmp where id = $estilo";

    $resultado = $cat->query($query);

    $fecdig = 0;

    while ($row = mysqli_fetch_assoc($resultado)) {
        if ($row['fecdig'] != NULL) {
            $fecdig = new DateTime('20' . $row['fecdig']);
            $fecdig = $fecdig->format("Ymd");
        }
    }

    $query = "select max(fecha_disp) as fecha_disp from vistatmp where id = $estilo";

    $resultado = $cat->query($query);

    $fecha_disp = 0;

    while ($row = mysqli_fetch_assoc($resultado)) {
        if ($row['fecha_disp'] != NULL)
            $fecha_disp = $row['fecha_disp'];
    }

    $query = "select suni from mix_tiendas where estilo = $estilo and fecha = $fecha";

    $resultado = $mix->query($query);

    $suni_mix = 0;

    while($row = mysqli_fetch_assoc($resultado)){
        $suni_mix = $row['suni'];
    }

    $query = "select sum(cantidad) as cantidad from vista_disponibilidad where estilo = $estilo and fecha = $fecha";

    $resultado = $cat->query($query);

    $cant_vd = 0;

    while($row = mysqli_fetch_assoc($resultado)){
        $cant_vd = $row['cantidad'];
    }

    $insertar = "insert into vista_disp_tienda values ($fin,
                                                           $estilo,
                                                           $dep,
                                                          '$estacion',
                                                           $fecing,
                                                          '$tempor',
                                                          '$sku_desctmp',
                                                           $prenor,
                                                           $subdep,
                                                          '$codmar',
                                                           $suni_mix,
                                                           $cant_vd,
                                                           $fecdig,
                                                           $fecingret,
                                                           $fecha_disp,
                                                           $fecha_foto,
                                                           $fecha_creacion,
                                                           $esta)";

    if ($mix->query($insertar))
        echo "Se inserto con exito $estilo\n";
}
