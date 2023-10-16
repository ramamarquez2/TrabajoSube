<?php
namespace TrabajoSube;
class Boleto{
    private string $propName;
    private int $numCole;
    private float $saldoTarjeta;

    /*
    La clase boleto tendrá nuevos métodos que permitan conocer:
    (Fecha, tipo de tarjeta, línea de colectivo, total abonado, saldo e ID de la tarjeta.
    El boleto deberá indicar además el saldo restante en la tarjeta.
    Además el boleto tiene una descripción extra indicando si se canceló el saldo negativo
    con el pago de este boleto (Ejemplo: Abona saldo 120).\n
    Escribir los tests correspondientes a los posibles tipos de boletos a obtener según el tipo de tarjeta.
    */
    public function __construct($num, $name,$saldo){
        $this->numCole = $num;
        $this->propName = $name;
        $this->saldoTarjeta = $saldo;
    }

    public function ver(){
        echo "\n" . $this->propName . "viajo en el colectivo " . $this->numCole . ". Su saldo era " . ($this->saldoTarjeta +120) . " y ahora es " . $this->saldoTarjeta . ".\n";
        return "$this->numCole, $this->propName, $this->saldoTarjeta";
    }


}
?>