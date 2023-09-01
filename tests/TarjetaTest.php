<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase{
    
    public function testSaldo(){
        
        $tarjeta = new Tarjeta("Owner");
        $badTarjeta = new Tarjeta("BadOwner", 6601);

        $this->assertEquals($badTarjeta->verSaldo(), 0); //se resetea a 0 si > 6600
        $this->assertEquals($tarjeta->verSaldo(), 0);

        $tarjeta->cargarSaldo(180); //carga erronea (numero invalido)
        $this->assertNotEquals($tarjeta->verSaldo(), 180);
        $tarjeta->cargarSaldo(4000);
        $this->assertEquals($tarjeta->verSaldo(), 4000); //carga valida
        $tarjeta->cargarSaldo(3000); //sobrepasa 6600
        $this->assertEquals($tarjeta->verSaldo(), 4000);
    }
}