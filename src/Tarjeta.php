<?php
namespace TrabajoSube;
class Tarjeta{
    public int $idTarjeta;
    public float $saldo;
    public float $deuda;
    public float $exceso;
    

    public $tipoDeTarjeta;
    public float $precioBoleto;
    public array $ifSaldo = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000];
    public array $boletos = []; 

    public function __construct($id, $s=0){
        $this->idTarjeta = $id;
        $this->saldo = $s;
        $this->deuda = 0;
        $this->exceso = 0;
        $this->tipoDeTarjeta = 'Normal';

    }
    

    public function cargarSaldo($numSaldo){
        
        if(in_array($numSaldo, $this->ifSaldo)){
            if(($numSaldo + $this->saldo) <= 6600){
            
                echo "\nUsted le cargo " . $numSaldo . ".\n";
                if($numSaldo + $this->saldo >= 0){
                    echo "El saldo final es positivo " . $numSaldo + $this->saldo . ".\n";
                    echo "Saldo a cargar " . ($numSaldo-$this->deuda) . ".\n";

                    $this->saldo += $numSaldo;
                    echo "\nSe le desconto " . $this->deuda . ".\n";
                    $this->deuda = 0;
                }
                else{
                    $this->saldo += $numSaldo;
                    $this->deuda = $this->saldo * (-1);
                }
            }
            else{
                $this->exceso = (($this->saldo + $numSaldo) - 6600);
                $this->saldo = 6600;
            }
        }
        else
        {
            echo "No se puede realizar la carga";
        }

        /*
        Saldo de la tarjeta.
        Una tarjeta SUBE no puede almacenar más de 6600 pesos.
        Por lo tanto cuando se realiza una carga que haga que se supere este
        límite, se deberá acreditar la carga en la tarjeta hasta alcanzar el
        monto máximo permitido y el monto restante se deberá dejar pendiente de
        acreditación. Luego ese saldo pendiente se acredita a medida que se usa la tarjeta.

        Modificar la función para cargar la tarjeta añadiendo esta funcionalidad.
        */
    }

    public function addBoleto(Boleto $bol){
        array_unshift($this->boletos, $bol);
    }
    public function verSaldo() {
        echo "\nTu saldo actual es " . $this->saldo. " .\n";
        return $this->saldo;
    }
    public function verDeuda() {
        echo "\nTu deuda actual es " . $this->deuda. " .\n";
        return $this->deuda;
    }
    public function verExcedente() {
        echo "\nTu excedente actual es " . $this->exceso. " .\n";
        return $this->exceso;
    }
}

class FranquiciaCompleta extends Tarjeta {
    public int $beneficiosRestantes;
    public float $descuentoFraccional;

    public function __construct($id, $s=0){
        parent::__construct($id, $s);
        $this->beneficiosRestantes = 2;
        $this->descuentoFraccional = 0;
        $this->tipoDeTarjeta = 'FranquiciaCompleta';
    }
}
class MedioBoleto extends Tarjeta {
    public int $beneficiosRestantes;
    public float $descuentoFraccional;

    public function __construct($id, $s=0){
        parent::__construct($id, $s);
        $this->beneficiosRestantes = 4;
        $this->descuentoFraccional = 0.5;
        $this->tipoDeTarjeta = 'MedioBoleto';
    }
}

?>