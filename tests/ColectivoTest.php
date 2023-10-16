<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase{

    public function testGetlinea(){
        $cole = new Colectivo(103);
        echo "\nSe creó colectivo\n";
        $this->assertEquals($cole->getLinea(), 103); //evalua si el colectivo creado es de la linea asignada en la creacion del objeto
        echo "\n Evalua si colectivo es 103 \n\n\n";
    }
    

    public function testPagarcon(){
        
        $cole = new Colectivo(103);
        echo "\nSe creó colectivo\n";
        $tarjeta1 = new Tarjeta("Owner",140);
        echo "\nSe creó tarjeta Owner\n"; 
        $tarjeta1->verSaldo();

        echo "\n\nSe realiza primer pago\n"; 
        $this->assertTrue($cole->pagarCon($tarjeta1));  //pago exitoso
        $this->assertEquals($tarjeta1->verSaldo(), 20);
        
        //testea viaje plus
        echo "\n\nSe realiza segundo pago\n"; 
        $this->assertTrue($cole->pagarCon($tarjeta1)); //saldo 20 - 120 = -100 .  Se crea deuda de 100
        $this->assertEquals($tarjeta1->verSaldo(), -100); 
        $this->assertEquals($tarjeta1->verDeuda(), 100);

        echo "\n\nNo se debería realizar tercer pago\n"; 
        $this->assertFalse($cole->pagarCon($tarjeta1)); //-100 - 120 = -220 Error, no se puede realizar el pago

        echo "\n\nSe carga 200 de saldo\n";
        $tarjeta1->verSaldo(); 
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
        echo "\nSe creó colectivo\n";
        $tarjeta1 = new FranquiciaCompleta("DebtorOwner", -211.83); //teniendo saldo límite
        echo "\nSe creó tarjeta\n";
        $tarjeta1->verSaldo();

        echo "\n\nSe pagan dos boletos gratuitos\n"; 
        $this->assertTrue($cole->pagarCon($tarjeta1)); //boleto 1
        $this->assertTrue($cole->pagarCon($tarjeta1)); //boleto 2
        //paga dos boletos gratuitos
        
        echo "\n\nSe intenta pagar otro boleto\n"; 
        $this->assertFalse($cole->pagarCon($tarjeta1)); //no tiene mas boletos, no puede pagar
    }

    public function testMedioBoleto(){
        $cole = new Colectivo(103);
        echo "\nSe creó colectivo\n";
        $tarjeta1 = new MedioBoleto("Owner", 240);
        echo "\nSe creó tarjeta\n";
        $tarjeta1->verSaldo();


        echo "\n\nSe pagan medio 1\n"; 
        $this->assertTrue($cole->pagarCon($tarjeta1));  //medio 1
        $this->assertEquals($tarjeta1->verSaldo(), (180));//descontó mitad

        echo "\n\nSe pagan medio 2\n"; 
        $this->assertTrue($cole->pagarCon($tarjeta1));  //medio 2
        $this->assertEquals($tarjeta1->verSaldo(), (120));//descontó mitad

        echo "\n\nSe pagan medio 3\n";
        $this->assertTrue($cole->pagarCon($tarjeta1));  //medio 3
        $this->assertEquals($tarjeta1->verSaldo(), (60));//descontó mitad

        echo "\n\nSe pagan medio 4\n";
        $this->assertTrue($cole->pagarCon($tarjeta1));  //medio 4
        $this->assertEquals($tarjeta1->verSaldo(), (0));//descontó mitad

        echo "\n\nNo hay beneficio, pago vuelve a ser normal\n";
        $this->assertTrue($cole->pagarCon($tarjeta1));  //No hay mas beneficio, pago vuelve a normal
        $this->assertEquals($tarjeta1->verSaldo(), (-120));//pago normal

    }
}