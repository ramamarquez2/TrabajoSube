<?php
namespace TrabajoSube;
class Colectivo{
    protected int $linea; //protected
    protected float $descuento;

    public function __construct($linea){
        $this->linea = $linea;
        $this->descuento = 1;
    }

    public function pagarCon(Tarjeta $tarjeta){

        if($tarjeta instanceof FranquiciaCompleta || $tarjeta instanceof MedioBoleto)
        {
            if($tarjeta->beneficiosRestantes > 0)
            {
                $tarjeta->beneficiosRestantes -= 1;
                $this->descuento = $tarjeta->descuentoFraccional;
            }
        }

        if(($tarjeta->saldo - (120 * $this->descuento)) >= (-211.84)){
            echo "saldo " . $tarjeta->saldo;
            echo "descuento " . $this->descuento;
            $tarjeta->saldo -= (120 * $this->descuento);
            $this->descuento = 1;
            if($tarjeta->saldo < 0){
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