<?php
namespace TrabajoSube;
class Boleto{
    private string $propName;
    private int $numCole;
    private int $saldoTarjeta;

    public function __construct($num, $name,$saldo){
        $this->numCole = $num;
        $this->propName = $name;
        $this->saldoTarjeta = $saldo;
    }

    public function ver(){
        echo "" . $this->propName . "viajo en el colectivo " . $this->numCole . ". Su saldo era " . ($this->saldoTarjeta +120) . " y ahora es " . $this->saldoTarjeta . ".\n";
    }

}
?>