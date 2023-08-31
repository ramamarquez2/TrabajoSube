<?php
namespace TrabajoSube;
class Boleto{
    private int $numCole;
    private int $saldoTarjeta;

    public function __construct($num, $saldo){
        $this->numCole = $num;
        $this->saldoTarjeta = $saldo;
    }

    public function ver(){
        echo "Usted viajo en el colectivo " . $this->numCole . ". Su saldo era " . ($this->saldoTarjeta +120) . " y ahora es " . $this->saldoTarjeta . ".\n";
    }

}
?>