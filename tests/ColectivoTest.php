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
        $tarjeta1 = new Tarjeta(1,140);
        echo "\nSe creó tarjeta 1\n"; 
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
        $tarjeta1 = new FranquiciaCompleta(1, -211.83); //teniendo saldo límite
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
        $tarjeta1 = new MedioBoleto(1, 240);
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

    public function testSaldoYExceso(){
        
        $cole = new Colectivo(115);
        echo "\nSe creó colectivo\n";
        $badTarjeta = new Tarjeta(1, 6600); //tarjeta que excede el saldo maximo
        echo "\nSe creó tarjeta\n";
        $badTarjeta->verSaldo();
        $this->assertEquals($badTarjeta->verSaldo(), 6600);
        
        $badTarjeta->cargarSaldo(1000); // 6600 de saldo, 400 de exceso
        $this->assertEquals($badTarjeta->verExcedente(), 400); // exceso

        $this->assertTrue($cole->pagarCon($badTarjeta));  //pago exitoso
        $this->assertEquals($badTarjeta->verSaldo(), 6600); //el saldo esta acotado a 6600, el exceso cubrió el pago
        $this->assertEquals($badTarjeta->verExcedente(), 280); // exceso cubrio el pago


        $badTarjeta2 = new Tarjeta(1, 6480); //tarjeta que excede el saldo maximo
        echo "\nSe creó tarjeta\n";
        $badTarjeta2->verSaldo();
        $badTarjeta2->cargarSaldo(150); // 6600 de saldo, 30 de exceso
        $this->assertEquals($badTarjeta2->verExcedente(), 30); // exceso 

        $this->assertTrue($cole->pagarCon($badTarjeta2));  //pago exitoso
        $this->assertEquals($badTarjeta2->verSaldo(), 6510); // exceso cubrió parte del pago, el resto se descontó de saldo
        $this->assertEquals($badTarjeta2->verExcedente(), 0); // exceso se vacio cubriendo el pago
         
    }
}