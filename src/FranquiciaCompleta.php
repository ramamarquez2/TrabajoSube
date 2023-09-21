<?php
namespace TrabajoSube;

class FranquiciaCompleta extends Tarjeta {
    public int $beneficiosRestantes;
    public float $descuentoFraccional;

    public function __construct($name, $s=0){
        parent::__construct($name, $s);
        $this->beneficiosRestantes = 2;
        $this->descuentoFraccional = 0;
    }
}

?>