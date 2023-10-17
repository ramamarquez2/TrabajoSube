<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase{
    
    public function testSaldo(){
        
        echo "\nSe crean tarjetas\n"; 
        $tarjeta1 = new Tarjeta(1); 
        $tarjeta1->verSaldo();

        $deudaTarj = new Tarjeta(2, -160); //tarjeta cargada con saldo negativo
        $deudaTarj->verSaldo();


        //Creacion de tarjetas:
        echo "\n\n Se revisan los valores\n"; 
        $this->assertEquals($tarjeta1->verSaldo(), 0); //tarjeta con saldo cero devuelve su mismo saldo, y al ser creada sin ingresar saldo, su defecto es 0
        $this->assertEquals($tarjeta1->verDeuda(), 0); //tarjeta con saldo positivo devuelve deuda 0
        $this->assertEquals($deudaTarj->verDeuda(), 0); //tarjeta con saldo negativo su deuda es 0 pues todavia no se ha hecho operaciones.
        

        //Cargas de saldo:
        echo "\n\n Se carga saldo\n"; 
        $tarjeta1->cargarSaldo(180); //carga erronea (numero invalido)
        $this->assertNotEquals($tarjeta1->verSaldo(), 180);

        $tarjeta1->cargarSaldo(4000); //carga válida
        $this->assertEquals($tarjeta1->verSaldo(), 4000); //carga valida

        $tarjeta1->cargarSaldo(3000); // carga que sobrepasa 6600
        $this->assertEquals($tarjeta1->verSaldo(), 6600); //carga válida


        echo "\n\n Se carga saldo a tarjeta con deuda (tarjeta -120)\n"; 
        $deudaTarj->cargarSaldo(150); //carga menor a deuda
        $this->assertEquals($deudaTarj->verSaldo(), -10); //devuelve saldo negativo
        $this->assertEquals($deudaTarj->verDeuda(), 10); //devuelve deuda 

        $deudaTarj->cargarSaldo(150); //carga mayor a deuda
        $this->assertEquals($deudaTarj->verSaldo(), 140); //devuelve saldo positivo
        $this->assertEquals($deudaTarj->verDeuda(), 0); //devuelve deuda 0

    }
    /*
    $badTarjeta2 = new Tarjeta("BadOwner", -212); //tarjeta que excede el saldo minimo
    $badTarjeta2->verSaldo();  
     */
    public function testSaldoYExceso(){
        
        $badTarjeta = new Tarjeta(1, 6000); //tarjeta llena
        $badTarjeta->verSaldo();

        $badTarjeta->cargarSaldo(1000); //carga que excede limite
        $this->assertEquals($badTarjeta->verSaldo(), 6600); //el saldo esta acotado a 6600
        $this->assertEquals($badTarjeta->verExcedente(), 400);
         
    }
    /*
        Escribir un test que valide que si a una tarjeta se le carga un monto
        que supere el máximo permitido, se acredite el saldo hasta alcanzar el máximo(6600)
        y que el excedente quede almacenado y pendiente de acreditación.
        
        Escribir un test que valide que luego de realizar un viaje, verifique si hay
        saldo pendiente de acreditación y recargue la tarjeta hasta llegar al máximo nuevamente.
    */
}