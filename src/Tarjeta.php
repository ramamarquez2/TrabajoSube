<?php
namespace TrabajoSube;
class Tarjeta{
    public string $propietario;
    public int $saldo;
    public array $ifSaldo = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000];
    //agregar array con acceso a boletos    

    public function __construct($name, $s=0){
        $this->propietario = $name;
        if(!($s > 6600)){
            $this->saldo = $s;
        }
        else {
            $this->saldo = 0;
        }
    }

    public function cargarSaldo($numSaldo){
        if(in_array($numSaldo, $this->ifSaldo) && ($numSaldo + $this->saldo) <= 6600){
            $this->saldo += $numSaldo;
            echo "Usted le cargo " . $numSaldo . ".\n";
        }
        else{
            echo "El numero es incorrecto.";
        }

    }
    public function verSaldo() {
        echo "Tu saldo actual es " . $this->saldo. " .\n";
        return $this->saldo;
    }
}
?>