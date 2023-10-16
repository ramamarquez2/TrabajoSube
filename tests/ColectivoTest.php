<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase{

    public function testGetlinea(){
        $cole = new Colectivo(103);
        $this->assertEquals($cole->getLinea(), 103); //evalua si el colectivo creado es de la linea asignada en la creacion del objeto
    }
    

    public function testPagarcon(){
        
        $cole = new Colectivo(103);
        $tarjeta1 = new Tarjeta("Owner",140); 
        $tarjeta1->verSaldo();

        $this->assertTrue($cole->pagarCon($tarjeta1));  //pago exitoso
        $this->assertEquals($tarjeta1->verSaldo(), 20);
        
        //testea viaje plus
        $this->assertTrue($cole->pagarCon($tarjeta1)); //saldo 20 - 120 = -100 .  Se crea deuda de 100
        $this->assertEquals($tarjeta1->verSaldo(), -100); 
        $this->assertEquals($tarjeta1->verDeuda(), 100);

        $this->assertFalse($cole->pagarCon($tarjeta1)); //-100 - 120 = -220 Error, no se puede realizar el pago

        $tarjeta1->cargarSaldo(200);
        $this->assertEquals($tarjeta1->verSaldo(), (100)); //resvisa si la deuda se descuenta del pago
    }


/*
Escribir un test que valide que una tarjeta de
FranquiciaCompleta siempre puede pagar un boleto.

Escribir un test que valide que el monto del boleto pagado
con medio boleto es siempre la mitad del normal.
*/
    public function testFranquicia(){
        $cole = new Colectivo(103);
        $tarjeta1 = new FranquiciaCompleta("DebtorOwner", -211.84); //teniendo saldo límite

        $this->assertTrue($cole->pagarCon($tarjeta1)); //boleto 1
        $this->assertTrue($cole->pagarCon($tarjeta1)); //boleto 2
        //paga dos boletos gratuitos

        $this->assertFalse($cole->pagarCon($tarjeta1)); //no tiene mas boletos, no puede pagar
    }

    public function testMedioBoleto(){
        $cole = new Colectivo(103);
        $tarjeta1 = new MedioBoleto("Owner", 240);
        $this->assertTrue($cole->pagarCon($tarjeta1));  //medio 1
        $this->assertEquals($tarjeta1->verSaldo(), (180));//descontó mitad

        $this->assertTrue($cole->pagarCon($tarjeta1));  //medio 2
        $this->assertEquals($tarjeta1->verSaldo(), (120));//descontó mitad

        $this->assertTrue($cole->pagarCon($tarjeta1));  //medio 3
        $this->assertEquals($tarjeta1->verSaldo(), (60));//descontó mitad

        $this->assertTrue($cole->pagarCon($tarjeta1));  //medio 4
        $this->assertEquals($tarjeta1->verSaldo(), (0));//descontó mitad

        $this->assertTrue($cole->pagarCon($tarjeta1));  //No hay mas beneficio, pago vuelve a normal
        $this->assertEquals($tarjeta1->verSaldo(), (-120));//pago normal

    }
}