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

?>