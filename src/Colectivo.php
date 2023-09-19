<?php
namespace TrabajoSube;
class Colectivo{
    protected int $linea; //protected
    protected bool $beneficioActivo; //xd
    protected float $descuento;

    public function __construct($linea){
        $this->linea = $linea;
        $this->beneficioActivo = false;
        $this->descuento = 1;
    }

    public function pagarCon(Tarjeta $tarjeta){

        if(get_class($tarjeta) == "FranquiciaCompleta" || get_class($tarjeta) == "MedioBoleto" ){
            if($tarjeta->beneficioRestantes > 0){
                $tarjeta->beneficioRestantes -= 1;
                $beneficioActivo = true;
            }
        }
        
        if($beneficioActivo){
            $descuento = $tarjeta->descuentoFraccional;
            $beneficioActivo = false;
        }
        else{
            $descuento = 1;
        }

        if($tarjeta->saldo - (120*$descuento) >= (-211.84)){
            $tarjeta->saldo -= (120*$descuento);
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