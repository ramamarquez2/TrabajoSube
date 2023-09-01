<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase{

    public function testGetlinea(){
        $cole = new Colectivo(103);
        $this->assertEquals($cole->getLinea(), 103);
    }
    //test pagarCon
    public function testPagarcon(){
        $cole = new Colectivo(103);
        $tar = new Tarjeta("Owner", 150);
        $tar->verSaldo();
        $cole->pagarCon($tar);  //pago exitoso
        $this->assertEquals($tar->verSaldo(), 30);
        $cole->pagarCon($tar); //error saldo < 120
        $this->assertEquals($tar->verSaldo(), 30);
    }
}