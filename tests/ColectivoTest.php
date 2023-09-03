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
        $tar = new Tarjeta("Owner", -20);
        $tar->verSaldo();
        $this->assertTrue($cole->pagarCon($tar));  //pago exitoso
        $this->assertEquals($tar->verSaldo(), (-140));
        $this->assertFalse($cole->pagarCon($tar)); //error (saldo - 120) < -211.84
        $this->assertEquals($tar->verSaldo(), (-140));
    }
}