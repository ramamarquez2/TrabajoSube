<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase{

    public function testGetlinea(){
        $cole = new Colectivo(103);
        echo "\nSe creó colectivo\n";
        $this->assertEquals($cole->getLinea(), 103); //evalua si el colectivo creado es de la linea asignada en la creacion del objeto
        echo "\n Evalua si colectivo es 103 \n\n\n";

        $coleInter = new ColectivoInterurbano(103);
        echo "\nSe creó coleInter\n";
        $this->assertEquals($coleInter->getLinea(), 103); //evalua si el colectivo creado es de la linea asignada en la creacion del objeto
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
        $this->assertEquals($tarjeta1->verSaldo(), 100); //resvisa si la deuda se descuenta del pago
    }

    public function testFranquiciaBegMismoDia(){
        $cole = new Colectivo(103);
        echo "\nSe creó colectivo\n";

        $tarjeta1 = new FranquiciaCompletaBEG(1, -211.83); //teniendo saldo límite
        echo "\nSe creó tarjeta\n";

        $this->assertFalse($cole->pagarCon($tarjeta1)); // No puede pagar, no hay beneficio en lahora
        
        echo "\nPasan 7 horas";
        $tarjeta1->fakeTimeAgregar(25200); // pasan 7 horas

        echo "\n\n---Se pagan dos boletos gratuitos---\n"; 
        $this->assertEquals($tarjeta1->verBeneficios(),2); //beneficios 2 por ser tarjeta nueva
        $this->assertTrue($cole->pagarCon($tarjeta1)); //boleto 1
        $this->assertEquals($tarjeta1->verBeneficios(),1); //beneficios =1 
        $this->assertTrue($cole->pagarCon($tarjeta1)); //boleto 2
        $this->assertEquals($tarjeta1->verBeneficios(),0); //beneficios =0
        //paga dos boletos gratuitos
        echo "\n\nSe intenta pagar otro boleto\n"; 
        $this->assertFalse($cole->pagarCon($tarjeta1)); //no tiene mas boletos, no puede pagar, pues tiene saldo límite

        
        echo "\n\nPasa 1 día\n";
        $tarjeta1->fakeTimeAgregar(86401);

        echo "\n\n---Se pagan dos boletos gratuitos---\n"; 
        $this->assertTrue($cole->pagarCon($tarjeta1)); // se reiniciaron boletos, se puede volver a pagar boleto 1
        $this->assertEquals($tarjeta1->verBeneficios(),1); //beneficios =1 , se descontó 1 del pago
        $this->assertTrue($cole->pagarCon($tarjeta1)); //paga de nuevo
        $this->assertEquals($tarjeta1->verBeneficios(),0); //beneficios =0
        //pagó dos boletos gratuitos
        echo "\n\nPasa 1 día\n"; 
        $tarjeta1->fakeTimeAgregar(86401);
        $this->assertTrue($cole->pagarCon($tarjeta1)); //Vuelve a tener boletos
        $this->assertEquals($tarjeta1->verBeneficios(),1); //beneficios =1 
    }
    public function testFranquiciaJubMismoDia(){
        $cole = new Colectivo(103);
        echo "\nSe creó colectivo\n";

        $tarjeta1 = new FranquiciaCompletaJubilado(1, -211.83); //teniendo saldo límite
        echo "\nSe creó tarjeta\n";
        
        $this->assertFalse($cole->pagarCon($tarjeta1)); // No puede pagar, no hay beneficio en lahora
        
        echo "\nPasan 7 horas";
        $tarjeta1->fakeTimeAgregar(25200); // pasan 7 horas

        echo "\n\n---Se pagan dos boletos gratuitos---\n"; 
        $this->assertTrue($cole->pagarCon($tarjeta1)); //boleto 1
        $this->assertTrue($cole->pagarCon($tarjeta1)); //boleto 2

        echo "\n\nPasa 1 día\n";
        $tarjeta1->fakeTimeAgregar(86401);
        $this->assertTrue($cole->pagarCon($tarjeta1)); //puede seguir pagando

        echo "\n\nPasan 4 días (se hace sabado\n";
        $tarjeta1->fakeTimeAgregar(86401*4);
        $this->assertFalse($cole->pagarCon($tarjeta1)); //no puede seguir pagando

    }

    public function testMedioBoleto(){
        $cole = new Colectivo(103);
        echo "\nSe creó colectivo\n";

        $tarjeta1 = new MedioBoleto(1, 300);
        echo "\nSe creó tarjeta\n";

        $tarjeta1->verSaldo();
        
        $this->assertFalse($cole->pagarCon($tarjeta1)); // No puede pagar, no hay beneficio en lahora
        
        echo "\nPasan 7 horas";
        $tarjeta1->fakeTimeAgregar(25200); // pasan 7 horas

        echo "\n\n---Se pagan medio 1---\n"; 
        $this->assertTrue($cole->pagarCon($tarjeta1));  //medio 1
        $this->assertEquals($tarjeta1->verSaldo(), (240));//descontó mitad
        $this->assertEquals($tarjeta1->verBeneficios(),3); //beneficios =3 

        echo "\n\nSe intenta pagar instantáneamente medio 2\n"; 
        $this->assertTrue($cole->pagarCon($tarjeta1));  //intento de medio 2, se puede pagar pero sin descuento
        $this->assertEquals($tarjeta1->verSaldo(), (120)); // saldo - 120
        $this->assertEquals($tarjeta1->verBeneficios(),3); //beneficios = 3 

        echo "\n\nSe paga medio 2 con espera\n"; 
        $tarjeta1->fakeTimeAgregar(301);
        $this->assertTrue($cole->pagarCon($tarjeta1));  //medio 2 , 
        $this->assertEquals($tarjeta1->verSaldo(), (60)); // descuenta mitad
        $this->assertEquals($tarjeta1->verBeneficios(),2); //beneficios = 2

        
        echo "\n\nSe pagan medio 3 con espera\n";
        $tarjeta1->fakeTimeAgregar(301);
        $this->assertTrue($cole->pagarCon($tarjeta1));  //medio 3
        $this->assertEquals($tarjeta1->verSaldo(), (0));//descontó mitad
        $this->assertEquals($tarjeta1->verBeneficios(),1); //beneficios = 1

        echo "\n\nSe pagan medio 4 con espera\n";
        $tarjeta1->fakeTimeAgregar(301);
        $this->assertTrue($cole->pagarCon($tarjeta1));  //medio 4
        $this->assertEquals($tarjeta1->verSaldo(), (-60));//descontó mitad
        $this->assertEquals($tarjeta1->verBeneficios(),0); //beneficios = 0

        echo "\n\nNo hay beneficio, pago vuelve a ser normal\n";
        $tarjeta1->fakeTimeAgregar(301);
        $this->assertTrue($cole->pagarCon($tarjeta1));  //No hay mas beneficio, pago vuelve a normal
        $this->assertEquals($tarjeta1->verSaldo(), (-180));//pago normal
        $this->assertEquals($tarjeta1->verBeneficios(), 0); //beneficios = 0 

    }


    public function testSaldoYExceso(){
        
        $cole = new Colectivo(115);
        echo "\nSe creó colectivo\n";
        $badTarjeta = new Tarjeta(1, 6600); //tarjeta con maximo
        echo "\nSe creó tarjeta\n";
        $badTarjeta->verSaldo();
        $this->assertEquals($badTarjeta->verSaldo(), 6600);


        $badTarjeta->cargarSaldo(1000); // 6600 de saldo, 1000 de exceso
        $this->assertEquals($badTarjeta->verExcedente(), 1000); // exceso

        
        $this->assertTrue($cole->pagarCon($badTarjeta));  //pago exitoso, descuenta 120 a exceso 100 -120 = 880
        $this->assertEquals($badTarjeta->verSaldo(), 6600); //el saldo esta acotado a 6600, el exceso cubrió el pago
        $this->assertEquals($badTarjeta->verExcedente(), 880); // exceso cubrio el pago


        $badTarjeta2 = new Tarjeta(1, 6480); //tarjeta cerca del saldo maximo
        echo "\nSe creó tarjeta\n";
        $badTarjeta2->verSaldo();
        $badTarjeta2->cargarSaldo(150); // 6600 de saldo, 30 de exceso
        $this->assertEquals($badTarjeta2->verExcedente(), 30); // exceso 

        $this->assertTrue($cole->pagarCon($badTarjeta2));  //pago exitoso
        $this->assertEquals($badTarjeta2->verSaldo(), 6510); // exceso cubrió parte del pago, el resto se descontó de saldo
        $this->assertEquals($badTarjeta2->verExcedente(), 0); // exceso se vacio cubriendo el pago
         
    }
}
