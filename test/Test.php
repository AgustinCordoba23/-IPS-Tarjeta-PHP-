<?php

namespace Tarjeta;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {

  public function testTarjetas_comun() {
    $tarjeta = new Tarjetas_comun;
    $tarjeta->recargar(272);
    $this->assertEquals($tarjeta->saldo(), 320, "Cargo 270 y me regalan a 320");
    
    $colectivo144Negro = new Colectivo("144 Negro", "Rosario Bus");    
    $tarjeta->pagar($colectivo144Negro, "2016/06/30 20:50");
    $this->assertEquals($tarjeta->saldo(), 312, "Saca 8pe de la carga");

    $colectivo135 = new Colectivo("135 Azul", "Rosario Bus");
    $tarjeta->pagar($colectivo135, "2016/06/30 21:10");
    $this->assertEquals($tarjeta->saldo(), 309.34, "Transbordo de bondi ");

    $colectivo135 = new Colectivo("135 Azul", "Rosario Bus");
    $tarjeta->pagar($colectivo135, "2016/06/30 23:58");  
    $this->assertEquals($tarjeta->saldo(), 301.34, "Comun casi a medianoche ;)" );
  }

  public function testMedio_boleto(){
    $tarjeta = new Medio_boleto;
    $tarjeta->recargar(272);

    $colectivo144Negro = new Colectivo("144 Negro", "Rosario Bus");    
    $tarjeta->pagar($colectivo144Negro, "2016/06/30 20:50");
    $this->assertEquals($tarjeta->saldo(), 316, "Saca 4pe de la carga");

    $colectivo135 = new Colectivo("135 Azul", "Rosario Bus");
    $tarjeta->pagar($colectivo135, "2016/06/30 21:10");
    $this->assertEquals($tarjeta->saldo(), 314.67, "Transbordo de bondi, medio ");

    $colectivo135 = new Colectivo("135 Azul", "Rosario Bus");
    $tarjeta->pagar($colectivo135, "2016/06/30 23:58");  
    $this->assertEquals($tarjeta->saldo(), 310.67, "Medio casi a medianoche ;)" );
  }

  public function testBici(){
    $tarjeta = new Tarjetas_comun;
    $medio = new Medio_boleto;
    $tarjeta->recargar(272);
    $medio->recargar(272);
    $bici = new Bici(1234);

    $tarjeta->pagar($bici, "2016/07/02 08:10");
    $medio->pagar($bici, "2016/08/02 09:10");

    $this->assertEquals($tarjeta->saldo(), 308, "Me voy a dar una vuelta en bici papa");
    $this->assertEquals($medio->saldo(), 314, "Me voy a dar una vuelta en bici con medio");
  }

}
