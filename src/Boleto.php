<?php
namespace TrabajoSube;
class Boleto{

    private int $lineaColec;
    private $fecha;

    //tarjeta
    private int $idTarjeta;
    private $tipoTarjetaUsada;
    private float $saldoTarjeta;
    private float $totalAbonado;
    private float $saldoRestante;
    public $whenPago;
    private string $descripcion;


    /*
    Además el boleto tiene una descripción extra indicando si se canceló el saldo negativo
    con el pago de este boleto (Ejemplo: Abona saldo 120).\n

    Escribir los tests correspondientes a los posibles tipos de boletos a obtener según el tipo de tarjeta.
    */
    public function __construct($linea, $fechaBoleto = null, $id, $tipoTarj, $saldo, $abonado, $restante, $desc = ""){
        
        if ($fechaBoleto == null) {
            $fechaBoleto = date('Y-m-d');
        }

        $this->lineaColec = $linea;
        $this->fecha = $fechaBoleto;
        $this->idTarjeta = $id;
        $this->tipoTarjetaUsada = $tipoTarj;
        $this->saldoTarjeta = $saldo;
        $this->totalAbonado = $abonado;
        $this->saldoRestante = $restante;
        $this->descripcion = $desc;
        $this->whenPago = $fechaBoleto;
    }

    public function verColectivo(){
        echo "\n Viajo en el colectivo " . $this->lineaColec . "\n";
        return $this->lineaColec;
    }

    public function verFecha(){
        echo "\n Este viaje fue pagado el día " . $this->fecha . "\n";
        return $this->fecha;
    }
    public function verId(){
        echo "\n Id del boleto" . $this->idTarjeta . "\n";
        return $this->idTarjeta;
    }
    public function verTipoTarjeta(){
        echo "\n Tipo de tarjeta usada: " . $this->tipoTarjetaUsada . "\n";
        return $this->tipoTarjetaUsada;
    }
    public function verSaldoTarjeta(){
        echo "\n Tu tarjeta tiene " . $this->saldoTarjeta . "de saldo\n";
        return $this->saldoTarjeta;
    }
    public function verAbonado(){
        echo "\n Tu tarjeta tiene " . $this->totalAbonado . "de saldo\n";
        return $this->totalAbonado;
    }
    public function verSaldoRestante(){
        echo "\n Tu tarjeteta es propiedad de " . $this->saldoRestante . "\n";
        return $this->saldoRestante;
    }
    public function verDesc(){
        echo "\n Se contradice la iteracion 3 con la 2, En la 2 dice que la deuda se descuenta en la carga, pero en la 3 se pide que el boleto devuelva si la deuda se descuenta en pago, descripción: " . $this->descripcion . "\n";
        return $this->descripcion;
    }
    /*
    public function verDesc(){
        echo "\n Tu tarjeteta es propiedad de " . $this->descripcion . "\n";
        return "" . verColectivo() . ", " . verFecha() . ", " . verId() . ", " . verTipoTarjeta() . ", " . verSaldoTarjeta() . ", " . verAbonado() . ", " . verSaldoRestante() . ", " . verDesc() . "";
    }
    */
}

?>