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

    public function testViajesplus(){
        $cole = new Colectivo(103);
        $tar = new Tarjeta("DebtorOwner", 110);
        $this->assertTrue($cole->pagarCon($tar)); //110 - 120 = -10
        $this->assertTrue($cole->pagarCon($tar)); // -10 - 120 = -130
        $this->assertFalse($cole->pagarCon($tar));

        $tar->cargarSaldo(150);
        $this->assertEquals($tar->verSaldo(), (20));
    }
/*
Escribir un test que valide que una tarjeta de
FranquiciaCompleta siempre puede pagar un boleto.

Escribir un test que valide que el monto del boleto pagado
con medio boleto es siempre la mitad del normal.
*/
    public function testFranquicia(){
        $cole = new Colectivo(103);
        $tar = new FranquiciaCompleta("DebtorOwner", -211.84);
        $this->assertTrue($cole->pagarCon($tar)); //boleto 1
        $this->assertTrue($cole->pagarCon($tar)); //boleto 2

        $this->assertFalse($cole->pagarCon($tar)); //no tiene mas boletos, no puede pagar
    }

    public function testMedioBoleto(){
        $cole = new Colectivo(103);
        $tar = new MedioBoleto("Owner", 240);
        $this->assertTrue($cole->pagarCon($tar));  //medio 1
        $this->assertEquals($tar->verSaldo(), (180));//descontó mitad

        $this->assertTrue($cole->pagarCon($tar));  //medio 2
        $this->assertEquals($tar->verSaldo(), (120));//descontó mitad

        $this->assertTrue($cole->pagarCon($tar));  //medio 3
        $this->assertEquals($tar->verSaldo(), (60));//descontó mitad

        $this->assertTrue($cole->pagarCon($tar));  //medio 4
        $this->assertEquals($tar->verSaldo(), (0));//descontó mitad

        $this->assertTrue($cole->pagarCon($tar));  //No hay mas beneficio, pago vuelve a normal
        $this->assertEquals($tar->verSaldo(), (-120));//pago normal

    }
}