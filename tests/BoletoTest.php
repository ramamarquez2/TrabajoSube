<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase{
    
    public function testBoleto(){
        $tar = new Tarjeta("Owner", 120);
        $cole = new Colectivo(103);
        $cole->pagarCon($tar);
        //los valores del nuevo boleto (creados al pagarCon) son correctos?
        $this->assertEquals($tar->boletos[0]->ver(), "103, Owner, 0");
    }
}