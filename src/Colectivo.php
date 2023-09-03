<?php
namespace TrabajoSube;
class Colectivo{
    protected int $linea; //protected

    public function __construct($linea){
        $this->linea = $linea;
    }

    public function pagarCon($tarjeta){
        if(($tarjeta->saldo - 120) >= (-211.84) && $tarjeta->countPlus<2){
            $tarjeta->saldo -= 120;
            if($tarjeta->saldo < 0){
                $tarjeta->countPlus ++;
                $tarjeta->deuda = $tarjeta->saldo * (-1);
            }
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