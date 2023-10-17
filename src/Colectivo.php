<?php
namespace TrabajoSube;
class Colectivo{

    public float $PRECIOBOLETO;
    public int $linea; //protected
    public float $descuento;

    public function __construct($linea){
        $this->linea = $linea;
        $this->descuento = 1;
        $this->PRECIOBOLETO = 120;
    }

    public function pagarCon(Tarjeta $tarjeta)
    {   
        $horaactual = $tarjeta->fakeTime();

        if($tarjeta instanceof MedioBoleto){
            if($tarjeta->diaInRango($horaactual)){
                echo "\n-Es medio boleto";
                echo "\n" . $tarjeta->boletos[0]->whenPago;
                echo "\n" . ($tarjeta->boletos[0]->whenPago + 300);
                echo "\n" . $horaactual;

                if( ($tarjeta->boletos[0]->whenPago + 300) < $horaactual){ // 300 = 5 minutos
                    echo "\n Pasaron al menos 5 minutos";
                    if($tarjeta->beneficiosRestantes > 0){
                        echo "\n Hay al menos un beneficio restante: " . $tarjeta->beneficiosRestantes;
                        $tarjeta->beneficiosRestantes -= 1;
                        echo "\n Luego de resta: " . $tarjeta->beneficiosRestantes;
                        $this->descuento = $tarjeta->descuentoFraccional;
                        echo "\n Se setea descuento: " . $this->descuento;
                    }
                }
            }
        }
        elseif($tarjeta instanceof FranquiciaCompletaBEG){
            echo "\n-Es FranquiciaCompletaBEG";
            echo "\n" . $tarjeta->boletos[0]->whenPago;
            echo "\n" . ($tarjeta->boletos[0]->whenPago + 86400);
            echo "\n" . $horaactual;
            if($tarjeta->diaInRango($horaactual)){
                if(($tarjeta->boletos[0]->whenPago + 86400) < $horaactual ){ // 1 dia = 864000 s
                    echo "\n Paso al menos 1 dia";
                    $tarjeta->beneficiosRestantes = 2;
                    echo "\n Beneficios se pone en: " . $tarjeta->beneficiosRestantes;
                    $tarjeta->beneficiosRestantes -= 1;
                    echo "\n Beneficios se resta a: " . $tarjeta->beneficiosRestantes;
                    $this->descuento = $tarjeta->descuentoFraccional;
                    echo "\n Se setea descuento: " . $this->descuento;
                }
                else{
                    echo "\nEn el mismo dia";
                    echo "\n Beneficios restantes: " . $tarjeta->beneficiosRestantes;
                    if($tarjeta->beneficiosRestantes > 0){
                    $tarjeta->beneficiosRestantes -= 1;
                    echo "\n Beneficios se pone en: " . $tarjeta->beneficiosRestantes;
                    $this->descuento = $tarjeta->descuentoFraccional;
                   echo "\n Se setea descuento: " . $this->descuento;
                   }
                }
            }
        }
        elseif($tarjeta instanceof FranquiciaCompletaJubilado){
            echo "\n-Es FranquiciaCompletaJubilado";
            echo "\n" . $tarjeta->boletos[0]->whenPago;
            echo "\n" . $horaactual;
            if($tarjeta->diaInRango($horaactual)){
                $this->descuento = $tarjeta->descuentoFraccional;
            }
        }
        else{
            if( !$tarjeta->mismoMes($horaactual, $tarjeta->boletos[$tarjeta->primerBoletoMes]->verFecha()) ){
                    $tarjeta->primerBoletoMes = 0;
                    echo "\n Nuevo mes " . $tarjeta->primerBoletoMes;  
            }
            
            if ($tarjeta->primerBoletoMes < 29){
                echo "\n Es menor a 29 " . $tarjeta->primerBoletoMes;  
                $tarjeta->descuentoFraccional = 1; // precio total
                echo "\n Se setea descuento: " . $this->descuento;
            }
            else if ($tarjeta->primerBoletoMes < 79){
                echo "\n Es menor a 79 " . $tarjeta->primerBoletoMes;  
                $tarjeta->descuentoFraccional = 0.8; // 20% de descuento// viajes del 30 al 79  
                echo "\n Se setea descuento: " . $this->descuento;
            }
            else{
                echo "\n Mayor a 79 " . $tarjeta->primerBoletoMes;  
                $tarjeta->descuentoFraccional = 0.75; // 25% de descuento // viajes a partir del 80
                echo "\n Se setea descuento: " . $this->descuento;
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
            $tarjeta->primerBoletoMes += 1;
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

}

class ColectivoInterurbano extends Colectivo{
    public function __construct($linea){
        parent::__construct($linea);
        $this->PRECIOBOLETO = 184;
    }
        
    }

?>