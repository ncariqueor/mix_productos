<?php

$query = "A continuación se presenta la query para obtener los estilos que han ingresado hasta hace 2 meses: <br><br>

<b>SELECT EXKPF01.ESTILO, EXKPF01.DEP, EXKPF01.ESTACION, GGREFX.FECING, EXKPF01.TEMPOR, GGREFX.SUBDEP, GGREFX.DES, EXKPF01.PRENOR, EXKPF01.CODMAR<br><br>

FROM   RDBPARIS2.EXGCBUGD.EXKPF01 EXKPF01, RDBPARIS2.EXGCBUGD.GGREFX GGREFX<br><br>

WHERE  GGREFX.REF = EXKPF01.REF AND EXKPF01.PRENOR > 3000 AND GGREFX.FECING between (fecha hace 2 meses) and (fecha actual) order by GGREFX.FECING ASC</b><br><br>


Para saber si un estilo existe en internet, este se cruza con el FTP que contiene las fotografías. (ftp://72.3.222.208/Cencosud.txt y ftp://72.3.222.208/CencosudDelta.txt)";


echo "<p style='font-family: Calibri;'>" . $query . "</p>";