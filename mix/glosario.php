<!DOCTYPE html>
<html>
    <head>
        <title>Glosario Mix de Productos</title>
        <link rel="stylesheet" type="text/css" href="../bootstrap-3.3.6-dist/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5 class="text-center">Glosario Mix de Productos Paris.cl con respecto a Tiendas Físicas</h5>
                    <h6 class="text-center">Fecha de actualización: 13 de enero de 2017</h6>
                </div>

                <div class="panel-body">
                    <p class="text-justify" style="width: 100%;">La forma de calcular el mix de productos de Paris Internet versus las Tiendas
                    Físicas se basa en identificar qué estilos se encuentran con disponibilidad de stock Tiendas,
                    en Paris.cl y en Venta en Verde. De esto último nacen diferentes combinatorias como se reflejan, pues
                    un estilo puede tener stock en un lugar o varios. Abajo la tabla de las diferentes combinaciones
                    existentes.</p>

                    <div class="table-responsive">
                        <table class="table table-bordered table-responsive" style="width: 50%; margin: 0 auto;">
                            <thead>
                                <tr>
                                    <th class="text-center">Estilo</th>
                                    <th class="text-center">Tienda</th>
                                    <th class="text-center">Paris.cl</th>
                                    <th class="text-center">Venta en Verde</th>
                                </tr>
                            </thead>

                            <tr>
                                <td>(A) Sólo en Tienda</td>
                                <td class="text-center">1</td>
                                <td class="text-center">0</td>
                                <td class="text-center">0</td>
                            </tr>

                            <tr>
                                <td rowspan="2" style="vertical-align: middle;">(B) Stock Tienda y Paris.cl *Venta en Verde</td>
                                <td class="text-center">1</td>
                                <td class="text-center">1</td>
                                <td class="text-center">0</td>
                            </tr>

                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">1</td>
                                <td class="text-center">1</td>
                            </tr>

                            <tr>
                                <td rowspan="2" style="vertical-align: middle;">(C) Sólo en Paris.cl *Venta en Verde</td>
                                <td class="text-center">0</td>
                                <td class="text-center">1</td>
                                <td class="text-center">0</td>
                            </tr>

                            <tr>
                                <td class="text-center">0</td>
                                <td class="text-center">1</td>
                                <td class="text-center">1</td>
                            </tr>

                            <tr>
                                <td>(D) Venta en Verde exclusivo Tienda</td>
                                <td class="text-center">1</td>
                                <td class="text-center">0</td>
                                <td class="text-center">1</td>
                            </tr>

                        </table>
                    </div>

                    <br>
                    <ul style="margin: 0 auto;">
                        <li><b>Tienda</b>: Información de Stock de Tienda se obtiene desde AS400.</li>
                        <li><b>Paris.cl</b>: Información de Stock de Paris.cl se obtiene desde la vista Disponibilidad de EOM.</li>
                        <li><b>Venta en Verde</b>: No se obtiene Stock. Solamente sabemos que el producto está configurado
                        con la capacidad de venderse como Venta en Verde desde la tabla de Inventario Master de AS400.</li>
                    </ul>
                    <br>
                    <p class="text-justify">La fórmula utilizada para mostrar el porcentaje de mix de Paris.cl versus Tienda utilizando las variables
                    de la tabla anterior tiene el siguiente formato:

                    </p>

                    <br><br>

                    <img src="../pictures/formula.png" class="img-responsive"/>

                    <br><br>

                    <img src="../pictures/formula2.png" class="img-responsive"/>

                    <br><br>

                    <p class="text-justify">
                        Para configurar el universo de productos contra el cual se quiere comparar Paris Internet, la lógica
                        que se utiliza es saber cuáles son las tiendas número uno en ventas en cada departamento. Paris Internet
                        debe tener al menos los mismos estilos en Stock para así lograr superar la venta de cada tienda número uno
                        en cada departamento. También se tiene en cuenta la lógica que hay departamentos en los cuales Paris Internet
                        no tiene hoy día foco o recursos en potenciarlos, por lo cual no se empuja ese mix de productos.
                    </p>

                    <p class="text-justify">
                        Actualmente las tiendas que son número uno en ventas según resultados 2016 en cada departamento son los siguientes:
                    </p>

                    <div class="table-responsive">
                        <table class="table table-condensed table-striped" id="data_table" style="width: 50%; margin: 0 auto; overflow-y: visible;">
                            <thead>
                                <tr>
                                    <th>Número de Departamento</th>
                                    <th>Nombre de Departamento</th>
                                    <th>Tienda</th>
                                </tr>
                            </thead>
                        <?php
                        $ventas = new mysqli('localhost', 'root', '', 'ventas');

                        $query = "select depto1, nomdepto, tienda from depto where suni <> '' and division <> 'OTROS' order by depto1 asc";

                        $res = $ventas->query($query);

                        while($row = mysqli_fetch_assoc($res)){
                            $depto    = $row['depto1'];
                            $nomdepto = $row['nomdepto'];
                            $tienda   = utf8_encode($row['tienda']);

                            echo "<tr><td>$depto</td>";
                            echo "<td>$nomdepto</td>";
                            echo "<td>$tienda</td></tr>";
                        }
                        ?>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>