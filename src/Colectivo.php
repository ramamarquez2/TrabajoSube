<?php
namespace TrabajoSube;
class Colectivo{

    public float $PRECIOBOLETO;
    protected int $linea; //protected
    protected float $descuento;

    public function __construct($linea){
        $this->linea = $linea;
        $this->descuento = 1;
        $this->PRECIOBOLETO = 120;
    }
    public function pagarCon(Tarjeta $tarjeta)
    {
        
        if($tarjeta instanceof FranquiciaCompleta || $tarjeta instanceof MedioBoleto){
            if($tarjeta->beneficiosRestantes > 0){
                $tarjeta->beneficiosRestantes -= 1;
                $this->descuento = $tarjeta->descuentoFraccional;
            }
        }

        if($tarjeta->saldo - ($this->PRECIOBOLETO*$this->descuento) >= (-211.84))
        {
            echo "\nsaldo previo al pago " . $tarjeta->saldo;    
            $saldoPrevio = $tarjeta->saldo ;

            $tarjeta->saldo -= ($this->PRECIOBOLETO*$this->descuento);
            
            echo "\ndescuento a aplicar en el pago " . $this->descuento;
            if($tarjeta->saldo < 0){
                $tarjeta->deuda = $tarjeta->saldo * (-1);
            }
            
            if($tarjeta->exceso > 0){
                $tarjeta->saldo += $tarjeta->exceso;
                if($tarjeta->saldo > 6600){
                    $tarjeta->exceso += ($tarjeta->saldo - 6600);
                    $tarjeta->saldo = 6600;
                }
            }

            $boleto = new Boleto($this->linea, null, $tarjeta->idTarjeta, $tarjeta->tipoDeTarjeta, $saldoPrevio, ($this->PRECIOBOLETO*$this->descuento), $tarjeta->saldo);
            $tarjeta->addBoleto($boleto);
            $this->descuento = 1;
            echo "\nsaldo post pago " . $tarjeta->saldo;
            echo "\ndescuento en el próximo pago " . $this->descuento;
            return True;
        }
        return False;


    }
    

    // tests functions
    public function getLinea(){
        return $this->linea;
    }
    public function verDescuento(){
        return $this->descuento;
    }
}
?>