<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase{
    
    public function testSaldo(){
        
        echo "\nSe crean tarjetas\n"; 
        $tarjeta1 = new Tarjeta("Owner"); 
        $tarjeta1->verSaldo();

        $deudaTarj = new Tarjeta("StrangeOwner", -120); //tarjeta cargada con saldo negativo
        $deudaTarj->verSaldo();

        $badTarjeta1 = new Tarjeta("PlentyOwner", 6600); //tarjeta que excede el saldo maximo
        $badTarjeta1->verSaldo();

        $badTarjeta2 = new Tarjeta("BadOwner", -212); //tarjeta que excede el saldo minimo
        $badTarjeta2->verSaldo();


        //Creacion de tarjetas:
        echo "\n\n Se revisan los valores\n"; 
        $this->assertEquals($badTarjeta1->verSaldo(), 6600); //
        $this->assertEquals($badTarjeta2->verSaldo(), -212); //
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
        $this->assertEquals($tarjeta1->verSaldo(), 4000); //carga invalida

        echo "\n\n Se carga saldo a tarjeta con dedua\n"; 
        $deudaTarj->cargarSaldo(100); //carga menor a deuda
        $this->assertEquals($deudaTarj->verSaldo(), -20); //devuelve saldo negativo
        $this->assertEquals($deudaTarj->verDeuda(), 20); //devuelve deuda 

        $deudaTarj->cargarSaldo(100); //carga mayor a deuda
        $this->assertEquals($deudaTarj->verSaldo(), 80); //devuelve saldo positivo
        $this->assertEquals($deudaTarj->verDeuda(), 0); //devuelve deuda 0

    }
}