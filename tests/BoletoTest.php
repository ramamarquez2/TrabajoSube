<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase{
    
    public function testBoleto(){
        $tar = new Tarjeta("Owner", 120);
        $cole = new Colectivo(103);
        //los valores del nuevo boleto (retornados por pagarCon) son correctos?
        // $this->assertEquals($cole->ultimoBoleto->ver(), "103, Owner, 0");
    }
}