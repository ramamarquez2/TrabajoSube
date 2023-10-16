<?php
namespace TrabajoSube;
class Tarjeta{
    public string $propietario;
    public float $saldo;
    public float $deuda;
    public $tipoTarjeta;
    public float $precioBoleto;
    public array $ifSaldo = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000];
    public array $boletos = []; 

    public function __construct($name, $s=0){
        $this->propietario = $name;

        if($s <= 6600 || $s >= (-211.84)){
            $this->saldo = $s;
        }
        else {
            $this->saldo = 0;
        }

        if($s>=0){
            $this->deuda = 0;
        }
        else{
            $this->deuda = $this->saldo * (-1);
        }
    }

    public function cargarSaldo($numSaldo){
        if(in_array($numSaldo, $this->ifSaldo) && ($numSaldo + $this->saldo) <= 6600){
            echo "\nUsted le cargo " . $numSaldo . ".\n";
            if($numSaldo + $this->saldo >= 0){
                $this->saldo += $numSaldo - $this->deuda;
                echo "\nSe le desconto " . $this->deuda . ".\n";
                $this->deuda = 0;
            }
            else{
                $this->saldo += $numSaldo;
                $this->deuda = $this->saldo * (-1);
            }
        }
        else{
            echo "\nEl numero es incorrecto.";
        }

    }

    public function addBoleto(Boleto $bol){
        array_unshift($this->boletos, $bol);
    }
    public function verSaldo() {
        echo "\nTu saldo actual es " . $this->saldo. " .\n";
        return $this->saldo;
    }
    public function verDeuda() {
        echo "\nTu saldo actual es " . $this->deuda. " .\n";
        return $this->deuda;
    }
}

class FranquiciaCompleta extends Tarjeta {
    public int $beneficiosRestantes;
    public float $descuentoFraccional;

    public function __construct($name, $s=0){
        parent::__construct($name, $s);
        $this->beneficiosRestantes = 2;
        $this->descuentoFraccional = 0;
        $this->tipoTarjeta = 'FranquiciaCompleta';
    }
}
class MedioBoleto extends Tarjeta {
    public int $beneficiosRestantes;
    public float $descuentoFraccional;

    public function __construct($name, $s=0){
        parent::__construct($name, $s);
        $this->beneficiosRestantes = 4;
        $this->descuentoFraccional = 0.5;
        $this->tipoTarjeta = 'MedioBoleto';
    }
}

?>