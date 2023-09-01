<?php
namespace TrabajoSube;
class Colectivo{
    protected $linea; //protected

    public function __construct($linea){
        $this->linea = $linea;
    }

    public function pagarCon($tarjeta){
        if($tarjeta->saldo >= 120){
            $tarjeta->saldo -= 120;
            $boleto = new Boleto($this->linea, $tarjeta->saldo);
            $boleto->ver();
        }
    }
    // tests functions
    public function getLinea(){
        return $this->linea;
    }
}
?>