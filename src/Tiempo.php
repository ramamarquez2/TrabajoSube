<?php

class TiempoTest{
/*
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
echo date ("H:i",10800);*/

public function diaInRango($tiempoAct){
    $diaAct = date('l',$tiempoAct);
    $tiempoAct = date('H:i:s',$tiempoAct);
    return (($diaAct != "Saturday" && $diaAct != "Sunday") && ($tiempoAct >= '06:00:00' && $tiempoAct <= '22:00:00'));
}

public $fakeTimeAgregado = 0;
public $usarTime = false;
public function fakeTimeAgregar($agregado){ //suma tiempo pasado al tiempo falso
    $this->fakeTimeAgregado += $agregado;
}

public function fakeTime(){ 
    if($this->usarTime)
        return time() + $this->fakeTimeAgregado;
    else 
        return 1697414400 + $this->fakeTimeAgregado;
}
}

$test = new TiempoTest;


echo $test->fakeTime();
echo "\n" . date('H:i:s',$test->fakeTime());
echo "\n" . date("Y/m/d",$test->fakeTime());
$test->fakeTimeAgregar(2592001);
echo "\n" . date('H:i:s',$test->fakeTime());
echo "\n" . date("Y/m/d",$test->fakeTime());
if($test->diaInRango($test->fakeTime())){
    echo "T";
}
else{
    echo "Fa";
}


?>