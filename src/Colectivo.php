<?php
namespace TrabajoSube;
class Colectivo{
    protected int $linea; //protected

    public function __construct($linea){
        $this->linea = $linea;
    }

    public function pagarCon($tarjeta){
        if($tarjeta->saldo >= 120){
            $tarjeta->saldo -= 120;
            $boleto = new Boleto($this->linea, $tarjeta->propietario, $tarjeta->saldo);
            $tarjeta->addBoleto($boleto);
            return True;
        }
        return False;
    }
    // tests functions
    public function getLinea(){
        return $this->linea;
    }
}
?>