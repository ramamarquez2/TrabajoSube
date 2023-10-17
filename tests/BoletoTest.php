<?php 

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase{
          /*
        verColectivo();
        verFecha();
        verId();
        verTipoTarjeta();
        verSaldoTarjeta();
        verAbonado();
        verSaldoRestante();
        verDesc();
        */
    public function testBoletoNormal(){
        $tar = new Tarjeta(1, 120);
        $cole = new Colectivo(103);
        $cole->pagarCon($tar);
        //los valores del nuevo boleto (creados al pagarCon) son correctos?
        
        $this->assertEquals($tar->boletos[0]->verFecha(),$tar->fakeTime());
        $this->assertEquals($tar->boletos[0]->verColectivo(),103);
        $this->assertEquals($tar->boletos[0]->verId(),1);
        $this->assertEquals($tar->boletos[0]->verTipoTarjeta(),"Normal");
        $this->assertEquals($tar->boletos[0]->verSaldoTarjeta(),120);
        $this->assertEquals($tar->boletos[0]->verAbonado(),120);
        $this->assertEquals($tar->boletos[0]->verSaldoRestante(),0);
        $this->assertEquals($tar->boletos[0]->verDesc(),"");
        
    }
    public function testBoletoFranquicia(){
        $tar = new FranquiciaCompleta(1, 120);
        $cole = new Colectivo(103);
        $cole->pagarCon($tar);
        //los valores del nuevo boleto (creados al pagarCon) son correctos?
        
        $this->assertEquals($tar->boletos[0]->verFecha(),$tar->fakeTime());
        $this->assertEquals($tar->boletos[0]->verColectivo(),103);
        $this->assertEquals($tar->boletos[0]->verId(),1);
        $this->assertEquals($tar->boletos[0]->verTipoTarjeta(),"FranquiciaCompleta");
        $this->assertEquals($tar->boletos[0]->verSaldoTarjeta(),120);
        $this->assertEquals($tar->boletos[0]->verAbonado(),0);
        $this->assertEquals($tar->boletos[0]->verSaldoRestante(),120);
        $this->assertEquals($tar->boletos[0]->verDesc(),"");
        
    }
    public function testBoletoMedio(){
        $tar = new MedioBoleto(1, 120);
        $cole = new Colectivo(103);
        $cole->pagarCon($tar);
        //los valores del nuevo boleto (creados al pagarCon) son correctos?
        
        $this->assertEquals($tar->boletos[0]->verFecha(),$tar->fakeTime());
        $this->assertEquals($tar->boletos[0]->verColectivo(),103);
        $this->assertEquals($tar->boletos[0]->verId(),1);
        $this->assertEquals($tar->boletos[0]->verTipoTarjeta(),"MedioBoleto");
        $this->assertEquals($tar->boletos[0]->verSaldoTarjeta(),120);
        $this->assertEquals($tar->boletos[0]->verAbonado(),60);
        $this->assertEquals($tar->boletos[0]->verSaldoRestante(),60);
        $this->assertEquals($tar->boletos[0]->verDesc(),"");
        
    }
    public function testBoletoZero(){
        $tar = new Tarjeta(1, 120);
        $this->assertEquals($tar->boletos[0]->verColectivo(),0);
        $this->assertEquals($tar->boletos[0]->verId(),1);
        $this->assertEquals($tar->boletos[0]->verTipoTarjeta(),"Normal");
        $this->assertEquals($tar->boletos[0]->verSaldoTarjeta(),0);
        $this->assertEquals($tar->boletos[0]->verAbonado(),0);
        $this->assertEquals($tar->boletos[0]->verSaldoRestante(),0);
        $this->assertEquals($tar->boletos[0]->verDesc(),"");
    }
}