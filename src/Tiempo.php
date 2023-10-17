<?php

$tiempo1 = time();
sleep(5);
$tiempo2 = time();

echo "Tiempo inicial 1: $tiempo1      \n";
echo "Tiempo inicial 2: $tiempo2      \n";

$diferencia = $tiempo2 - $tiempo1;

echo "Diferencia:  $diferencia  \n";
echo date("d/m/Y H:i:s", $tiempo1)  ."\n";
echo date("d/m/Y H:i:s", $tiempo2)  ."\n";

echo "\n Empieza: \n";
echo strtotime("2023/06/30");
echo "\n";
echo strtotime("2023/10/16");
echo "\n";
echo strtotime("00:05");
echo "\n";
echo strtotime("00:00");
echo "\n";
echo "\n\nP2\n";

echo date("Y/m/d",170000000);
echo "\n";
echo date("Y/m/d",(strtotime("00:03")));
echo "\n";
echo "\n";
echo strtotime( date("Y/m/d",(strtotime("2023/06/30"))) );
echo "\n";
echo date("Y/m/d",(strtotime ( date("Y/m/d", (strtotime("2023/06/30") )) ) ) );

echo "\n\n\n";
echo date ("H:i",10800);
?>