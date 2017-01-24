<?php
ini_set("max_execution_time", 0);

date_default_timezone_set("America/Santiago");

$horario = new mysqli('localhost', 'root', '', 'date_report');

$key = "mix_" . date("dmY") . "_" . date("His");

$reporte = "mix_inicio";

$date = date("d/m/Y");

$hour = date("H:i:s");

$horario->query("insert into horario values ('$key', '$reporte', '$date', '$hour')");

require_once 'calculos.php';

$roble = odbc_connect('CECEBUGD', 'USRVNP', 'USRVNP');

$mix   = new mysqli('localhost', 'root', '', 'mix_productos');

$cat   = new mysqli('localhost', 'root', '', 'catalogo');

$mant  = new mysqli('localhost', 'root', '', 'mantigua');

$ventas = new mysqli('localhost', 'root', '', 'ventas');

$mix->query("update estado set state = 0 where state = 1");

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

/*$cat->query("drop table vistatmp");

$cat->query("create table vistatmp SELECT distinct substring(item_name,1,6) as id, fecha_disp from vista_disponibilidad where fecha = $fin");

$cat->query("alter table vistatmp engine = myisam");

$cat->query("ALTER TABLE `VISTATMP` CHANGE `id` `id` INT(11) NOT NULL;");*/

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
                     EXKPF01.PRENOR, EXKPF01.CODMAR, GGREFX.$suni, EXKPF01.ORIGEN

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
        $origen   = odbc_result($result, 11);

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

        $query = "select max(first_date) as fecha_disp from sku_records where sku like '$estilo%'";

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
                                                          '$origen',
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

// ======================================== NUEVA LOGICA ===============================================================

$mix->query("delete from mix_existencia_stock where fecha = $fin");

//============================== ESTILOS TIENDA ========================================================================

$query = "select estilo, suni from vista_disp_tienda where fecha = $fin";

$res = $mix->query($query);

$estilo_tienda = array();

$i = 0;

while($row = mysqli_fetch_assoc($res)){
    $estilo = $row['estilo'];
    $estilo_tienda[$estilo][0] = 1;
    $estilo_tienda[$estilo][1] = $row['suni'];
}

//============================== FIN ESTILOS TIENDA ====================================================================

//============================== ESTILOS VISTA DISPONIBILIDAD ==========================================================

$query = "select estilo, cantidad from vista_disponibilidad where fecha = $fin and fecing >= $inicio";

$res = $cat->query($query);

$estilo_vd = array();

while($row  = mysqli_fetch_assoc($res)){
    $estilo = $row['estilo'];
    $estilo_vd[$estilo][0] = 1;
    $estilo_vd[$estilo][1] = $row['cantidad'];
}

//============================== FIN VISTA DISPONIBILIDAD ==============================================================

//================================ ESTILOS VENTA EN VERDE ==============================================================

$query = "select INVMST.INUMBR from RDBPARIS2.MMSP4LIB.INVMST INVMST where INVMST.IVATCD = 'PE'";

$res = odbc_exec($roble, $query);

$estilo_vev = array();

while(odbc_fetch_row($res)){
    $sku = odbc_result($res, 1);
    $sku = str_split($sku);
    $estilo = $sku[0] . $sku[1] . $sku[2] . $sku[3] . $sku[4] . $sku[5];

    $estilo_vev[$estilo] = 1;
}

//================================ FIN ESTILOS VENTA EN VERDE =========================================================

//================================ TIENE FOTO ==========================================================================

$query = "select max(lastmodified) as lastmodified, id from mix where LENGTH(id) = 6 group by id";

$res = $cat->query($query);

$fotos = array();

while ($row = mysqli_fetch_assoc($res)) {
    $estilo = $row['id'];
    $lastmodified = $row['lastmodified'];
    $fecha_ant = new DateTime($lastmodified);
    $fecha_act = new DateTime($fin);
    $dif = (($fecha_act->format("Y") - $fecha_ant->format("Y")) * 12 + ($fecha_act->format("m") - $fecha_ant->format("m")));

    $estado = "";

    if($dif <= 18)
        $estado = "CON FOTO";
    else
        $estado = "SIN FOTO";

    $fotos[$estilo][0] = $row['lastmodified'];
    $fotos[$estilo][1] = $estado;
}

//============================== FIN TIENE FOTO ========================================================================

$query = "select mix_productos.vista_disp_tienda.fecha,    mix_productos.vista_disp_tienda.estilo, mix_productos.vista_disp_tienda.dep,
                 mix_productos.vista_disp_tienda.estacion, mix_productos.vista_disp_tienda.fecing, mix_productos.vista_disp_tienda.tempor,
                 mix_productos.vista_disp_tienda.des,      mix_productos.vista_disp_tienda.prenor, mix_productos.vista_disp_tienda.subdep,
                 mix_productos.vista_disp_tienda.codmar,   mix_productos.vista_disp_tienda.origen

          from mix_productos.vista_disp_tienda where mix_productos.vista_disp_tienda.fecha = $fin

          union

          select catalogo.vista_disponibilidad.fecha, substring(catalogo.vista_disponibilidad.item_name, 1, 6) as estilo, catalogo.vista_disponibilidad.dep,
                 catalogo.vista_disponibilidad.estacion, catalogo.vista_disponibilidad.fecing, catalogo.vista_disponibilidad.tempor,
                 catalogo.vista_disponibilidad.des_roble as des, catalogo.vista_disponibilidad.prenor, catalogo.vista_disponibilidad.subdep,
                 catalogo.vista_disponibilidad.codmar, catalogo.vista_disponibilidad.origen

          from catalogo.vista_disponibilidad where catalogo.vista_disponibilidad.fecha = $fin and catalogo.vista_disponibilidad.fecing >= $inicio ";

$res = $cat->query($query);

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
    $origen   = $row['origen'];
    $id       = $estilo . $fecha;

    $sku_desc = str_split($des);
    $sku_desctmp = "";
    $count = count($sku_desc);
    for ($k = 0; $k < $count; $k++) {
        if ($sku_desc[$k] == "'")
            $sku_desctmp = $sku_desctmp . "'" . $sku_desc[$k];
        else
            $sku_desctmp = $sku_desctmp . $sku_desc[$k];
    }

    $des = $sku_desctmp;

    $cantidad = 0;

    $existe_tienda = 0;
    if(isset($estilo_tienda[$estilo][0])) {
        $existe_tienda = 1;
        $cantidad += $estilo_tienda[$estilo][1];
    }

    $existe_vd = 0;
    if(isset($estilo_vd[$estilo][0])) {
        $existe_vd = 1;
        $cantidad += $estilo_vd[$estilo][1];
    }

    $cantidad = round($cantidad / 2);

    $existe_vev = 0;
    if(isset($estilo_vev[$estilo]))
        $existe_vev = 1;

    $estado = "ERROR";
    if($existe_tienda == 1 && $existe_vd == 1 && $existe_vev == 1)
        $estado = "TIENDA Y PARIS.CL";

    if($existe_tienda == 1 && $existe_vd == 1 && $existe_vev == 0)
        $estado = "TIENDA Y PARIS.CL";

    if($existe_tienda == 1 && $existe_vd == 0 && $existe_vev == 1)
        $estado = "VeV EXCLUSIVO TIENDA";

    if($existe_tienda == 1 && $existe_vd == 0 && $existe_vev == 0)
        $estado = "EXCLUSIVO TIENDA";

    if($existe_tienda == 0 && $existe_vd == 1 && $existe_vev == 1)
        $estado = "EXCLUSIVO PARIS.CL";

    if($existe_tienda == 0 && $existe_vd == 1 && $existe_vev == 0)
        $estado = "EXCLUSIVO PARIS.CL";

    if($existe_tienda == 0 && $existe_vd == 0 && $existe_vev == 1)
        $estado = "EXCLUSIVO VeV";

    if($existe_tienda == 0 && $existe_vd == 0 && $existe_vev == 0)
        $estado = "ERROR";

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

    $query = "select max(first_date) as fecha_disp from sku_records where sku like '$estilo%' limit 1";

    $resultado = $cat->query($query);

    $fecha_disp = 0;

    while ($row = mysqli_fetch_assoc($resultado)) {
        if ($row['fecha_disp'] != NULL)
            $fecha_disp = $row['fecha_disp'];
    }

    $fecha_foto = 0;

    $estado_foto = "SIN FOTO";

    if(isset($fotos[$estilo][0])){
        $fecha_foto = $fotos[$estilo][0];
        $estado_foto = $fotos[$estilo][1];
    }

    $query = "insert into mix_existencia_stock values ($id,
                                                       $fecha,
                                                       $estilo,
                                                       $dep,
                                                       '$estacion',
                                                       $fecing,
                                                       '$tempor',
                                                       '$des',
                                                       $prenor,
                                                       $subdep,
                                                       '$codmar',
                                                       '$origen',
                                                       $cantidad,
                                                       $fecdig,
                                                       $fecingret,
                                                       $fecha_disp,
                                                       $existe_tienda,
                                                       $existe_vd,
                                                       $existe_vev,
                                                       '$estado',
                                                       $fecha_foto,
                                                       '$estado_foto')";

    if($mix->query($query))
        echo "Se inserto bien $estilo.\n";
    else
        echo "Error " . $mix->error . " en query $query\n";
}

//= =================================== FIN =============================================================================

$mix->query("update estado set state = 1 where state = 0");

$key = "mix_" . date("dmY") . "_" . date("His");

$reporte = "mix_fin";

$date = date("d/m/Y");

$hour = date("H:i:s");

$horario->query("insert into horario values ('$key', '$reporte', '$date', '$hour')");