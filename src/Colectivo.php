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

    /* 
    Para evitar el uso de una tarjeta de tipo medio boleto en más de una persona
    en el mismo viaje se pide que: Al utilizar una tarjeta de tipo medio boleto para
    viajar, deben pasar como mínimo 5 minutos antes de realizar otro viaje. No será
    posible pagar otro viaje antes de que pasen estos 5 minutos.

Escribir un test que verifique efectivamente que no se deje marcar nuevamente al intentar
realizar otro viaje en un intervalo menor a 5 minutos con la misma tarjeta medio boleto.
Para el caso del medio boleto, se pueden realizar hasta cuatro viajes por día. El quinto viaje ya posee su valor normal.
Escribir un test que verifique que no se puedan realizar más de cuatro viajes por día con medio boleto.

Limitación en el pago de franquicias completas.
Para evitar el uso de una tarjeta de tipo boleto educativo gratuito en más de una persona
en el mismo viaje se pide que: Al utilizar una tarjeta de tipo boleto educativo gratuito se
pueden realizar hasta 2 viajes gratis por día.

Escribir un test que verifique que no se puedan realizar más de dos viajes gratuitos por día.
Escribir un test que verifique que los viajes posteriores al segundo se cobran con el precio completo.
    */
    public function pagarCon(Tarjeta $tarjeta)
    {   
        $horaactual = $tarjeta->fakeTime();

        if($tarjeta instanceof MedioBoleto){
            if( ($tarjeta->boletos[0]->whenPago + 300) < $horaactual){ // 300 = 5 minutos
                if($tarjeta->beneficiosRestantes > 0){
                    $tarjeta->beneficiosRestantes -= 1;
                    $this->descuento = $tarjeta->descuentoFraccional;
                }
            }
        }
        if($tarjeta instanceof FranquiciaCompleta){
            if(($tarjeta->boletos[0]->whenPago + 86400) < $horaactual ){ // 1 dia = 864000 s
                $tarjeta->beneficiosRestantes = 2;
                $tarjeta->beneficiosRestantes -= 1;
                $this->descuento = $tarjeta->descuentoFraccional;
            }
            else{
                if($tarjeta->beneficiosRestantes > 0){
                $tarjeta->beneficiosRestantes -= 1;
                $this->descuento = $tarjeta->descuentoFraccional;
                }
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
                $tarjeta->exceso = 0;
                if($tarjeta->saldo > 6600){
                    $tarjeta->exceso = ($tarjeta->saldo - 6600);
                    $tarjeta->saldo = 6600;
                }
            }

            $boleto = new Boleto($this->linea, $horaactual, $tarjeta->idTarjeta, $tarjeta->tipoDeTarjeta, $saldoPrevio, ($this->PRECIOBOLETO*$this->descuento), $tarjeta->saldo);
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