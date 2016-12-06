<?php
ini_set("max_execution_time", 0);

require_once 'calculos.php';

$roble = odbc_connect('CECEBUGD', 'USRVNP', 'USRVNP');

$mix   = new mysqli('localhost', 'root', '', 'mix_productos');

$cat   = new mysqli('localhost', 'root', '', 'catalogo');

$mant  = new mysqli('localhost', 'root', '', 'mantigua');

$ventas = new mysqli('localhost', 'root', '', 'ventas');

$inicio = date("Ym", strtotime("-3 month"));

$inicio = $inicio . '01';

$ini = date("ymd", strtotime("{$inicio}"));

$fin    = date("Ymd");

$mix->query ("delete from vista_disp_tienda where fecha = $fin");

//Verificar Ficha

$cat->query("drop table creaciontmp");

$cat->query("create table creaciontmp SELECT distinct substring(partnumber,1,6) as id, fecha_creacion from creacion_cmc");

$cat->query("alter table creaciontmp engine = myisam");

$cat->query("ALTER TABLE `CREACIONTMP` CHANGE `id` `id` INT(11) NOT NULL;");

//Para obtener Fecha Vista Disponibilidad

$cat->query("drop table vistatmp");

$cat->query("create table vistatmp SELECT distinct substring(item_name,1,6) as id, fecha_disp from vista_disponibilidad where fecha = $fin");

$cat->query("alter table vistatmp engine = myisam");

$cat->query("ALTER TABLE `VISTATMP` CHANGE `id` `id` INT(11) NOT NULL;");

//Para obtener Fecha de Empuje a Internet

$cat->query("drop table trastmp");

$cat->query("create table trastmp SELECT distinct substring(sku,1,6) as id, fecdig from traspasos where fecdig >= $ini");

$cat->query("alter table trastmp engine = myisam");

$cat->query("ALTER TABLE `TRASTMP` CHANGE `id` `id` INT(11) NOT NULL;");

//Para obtemer Fecha de Empuje a internet para Venta en Verde

$cat->query("drop table trastmpvev");

$cat->query("create table trastmpvev SELECT distinct substring(sku,1,6) as id, fecdig from traspasos");

$cat->query("alter table trastmpvev engine = myisam");

$cat->query("ALTER TABLE `TRASTMPVEV` CHANGE `id` `id` INT(11) NOT NULL;");

//Para obtener Fecha de Re-etiquetado

$mant->query("drop table rettmp");

$mant->query("create table rettmp SELECT distinct substring(sku,1,6) as id, fecingret from retiquetado where fecha = $fin");

$mant->query("alter table rettmp engine = myisam");

$mant->query("ALTER TABLE `rettmp` CHANGE `id` `id` INT(11) NOT NULL;");

echo $inicio . " - " . $fin . "\n";

$query = "select depto1, suni from depto where suni <> '' order by depto1 asc"; // Obtener Departamentos y respectivas tiendas para la siguiente query

$res = $ventas->query($query);

while($row = mysqli_fetch_assoc($res)) {
    $depto1 = $row['depto1'];
    $suni = $row['suni'];

    $query = "SELECT EXKPF01.ESTILO, EXKPF01.DEP, EXKPF01.ESTACION, GGREFX.FECING, EXKPF01.TEMPOR, GGREFX.SUBDEP, GGREFX.DES,
                     EXKPF01.PRENOR, EXKPF01.CODMAR, GGREFX.$suni

              FROM   RDBPARIS2.EXGCBUGD.EXKPF01 EXKPF01, RDBPARIS2.EXGCBUGD.GGREFX GGREFX

              WHERE  GGREFX.REF = EXKPF01.REF AND GGREFX.DEP = $depto1 AND GGREFX.$suni > 0 AND GGREFX.FECING >= $inicio order by EXKPF01.ESTILO ASC";

    $result = odbc_exec($roble, $query);

    while(odbc_fetch_row($result)){
        $estilo   = odbc_result($result, 1);
        $dep      = odbc_result($result, 2);
        $estacion = odbc_result($result, 3);
        $fecing   = odbc_result($result, 4);
        $tempor   = odbc_result($result, 5);
        $subdep   = odbc_result($result, 6);
        $des      = odbc_result($result, 7);
        $prenor   = odbc_result($result, 8);
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
                                                           $suni,
                                                           0,
                                                           $fecdig,
                                                           $fecingret,
                                                           $fecha_disp,
                                                           $fecha_foto,
                                                           $fecha_creacion,
                                                           $esta)";

        if ($mix->query($insertar))
            echo "Se inserto con exito $estilo\n";
    }
}

//================================================ MIX VENTA EN VERDE ===============================================

$mix->query("delete from vista_disp_vev where fecha = $fin");

$query = "select INVMST.INUMBR from RDBPARIS2.MMSP4LIB.INVMST INVMST where INVMST.IVATCD = 'PE'";

$res = odbc_exec($roble, $query);

while(odbc_fetch_row($res)){
    $sku = odbc_result($res, 1);
    $sku = str_split($sku);
    $sku = $sku[0] . $sku[1] . $sku[2] . $sku[3] . $sku[4] . $sku[5];

    $query = "insert into vev_temp values ($sku)";

    if($mix->query($query))
        echo "Se inserto $sku\n";
}

$query = "select item_name from vista_disponibilidad where fecha = $fin";

$res = $cat->query($query);

while($row = mysqli_fetch_assoc($res)){
    $estilo = $row['item_name'];

    $estilo = str_split($estilo);

    $estilo = $estilo[0] . $estilo[1] . $estilo[2] . $estilo[3] . $estilo[4] . $estilo[5];

    $id = $estilo . $fin;

    $query = "select estilo from vev_temp where estilo = $estilo";

    $result = $mix->query($query);

    $cant = mysqli_num_rows($result);

    if($cant > 0) {

        $consulta = "SELECT GGREFX.DEP, GGREFX.ESTACION, GGREFX.FECING, EXKPF01.TEMPOR,
                         EXKPF01.DES, GGREFX.PRENOR, GGREFX.SUBDEP, EXKPF01.CODMAR


              FROM RDBPARIS2.EXGCBUGD.EXKPF01 EXKPF01, RDBPARIS2.EXGCBUGD.GGREFX GGREFX

              WHERE EXKPF01.ESTILO = '$estilo' and EXKPF01.REF = GGREFX.REF";

        $result = odbc_exec($roble, $consulta);

        while (odbc_fetch_row($result)) {
            $dep      = odbc_result($result, 1);
            $estacion = odbc_result($result, 2);
            $fecing   = odbc_result($result, 3);
            $tempor   = odbc_result($result, 4);
            $des      = odbc_result($result, 5);
            $prenor   = odbc_result($result, 6);
            $subdep   = odbc_result($result, 7);
            $codmar   = odbc_result($result, 8);

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

            $query = "select min(fecdig) as fecdig from trastmpvev where id = $estilo";

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

            $insertar = "insert into vista_disp_vev values ('$id',
                                                             $fin,
                                                             $estilo,
                                                             $dep,
                                                            '$estacion',
                                                             $fecing,
                                                            '$tempor',
                                                            '$sku_desctmp',
                                                             $prenor,
                                                             $subdep,
                                                            '$codmar',
                                                             $fecdig,
                                                             $fecingret,
                                                             $fecha_disp,
                                                             $fecha_foto,
                                                             $fecha_creacion,
                                                             $esta)";

            if ($mix->query($insertar))
                echo "Se inserto con exito $estilo\n";

        }
    }
}

mix_por_depto($mix, $fin);

mix_por_depto_vev($mix, $fin);