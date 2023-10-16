<?php
namespace TrabajoSube;

class MedioBoleto extends Tarjeta {
    public int $beneficiosRestantes;
    public float $descuentoFraccional;

    public function __construct($name, $s=0){
        parent::__construct($name, $s);
        $this->beneficiosRestantes = 4;
        $this->descuentoFraccional = 0.5;
    }
}

?>