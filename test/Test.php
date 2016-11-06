<?php

namespace Tarjeta;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {

  public function testTarjetas_comun() {
    $hola = new Tarjetas_comun(5);
    $hola->recargar(500);
    $this->assertEquals($hola->saldo(), 640, "La re guita papa");

    $tarjeta = new Tarjetas_comun(1);
    $tarjeta->recargar(272);
    $this->assertEquals($tarjeta->saldo(), 320, "Cargo 270 y me regalan a 320");
    
    $colectivo144Negro = new Colectivo("144 Negro", "Rosario Bus");    
    $tarjeta->pagar($colectivo144Negro, "2016/06/30 10:50");
    $this->assertEquals($tarjeta->saldo(), 312, "Saca 8pe de la carga");

    $colectivo135 = new Colectivo("135 Azul", "Rosario Bus");
    $tarjeta->pagar($colectivo135, "2016/06/30 11:10");
    $this->assertEquals($tarjeta->saldo(), 309.34, "Transbordo de bondi ");

    $colectivo135 = new Colectivo("135 Azul", "Rosario Bus");
    $tarjeta->pagar($colectivo135, "2016/06/30 23:58");  
    $this->assertEquals($tarjeta->saldo(), 301.34, "Comun casi a medianoche ;)" );

    $this->assertEquals($tarjeta->viajesRealizados(), 3, "Vivo en bondi");

    $trans = new Tarjetas_comun(78);
    $trans->recargar(272);
    $colectivo136 = new Colectivo("136 Azul", "Rosario Bus");
    $trans->pagar($colectivo136, "2016/06/25 21:00");
    $colectivo137 = new Colectivo("137 Azul", "Rosario Bus");
    $trans->pagar($colectivo135, "2016/06/25 22:25");
    $this->assertEquals($trans->saldo(), 309.34, "Me levanto un traba dominguero");


    $plus = new Tarjetas_comun(2);
    $this->assertEquals($plus->saldo(), 0, "Inicializa en 0");
    $colectivo145Negro = new Colectivo("145 Negro", "Rosario Bus");    
    $plus->pagar($colectivo145Negro, "2016/06/30 20:50");
    $this->assertEquals($plus->saldo(), -8, "Negativo");
    $plus->recargar(270);
    $this->assertEquals($plus->saldo(), 262, "Se descuenta el plus");

    $sin = new Tarjetas_comun(3);
    $colectivo167Negro = new Colectivo("167 Negro", "Rosario Bus");    
    $sin->pagar($colectivo167Negro, "2016/06/30 20:50");
    $sin->pagar($colectivo167Negro, "2016/07/30 20:50");
    $this->assertEquals($sin->pagar($colectivo167Negro, "2016/08/30 20:50"), "No tenes saldo", "Ah listo te clavo el visto y nv");

  }

  public function testMedio_boleto(){
    $tarjeta = new Medio_boleto(1);
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

  public function testPase_libre(){
    $tarjeta = new Pase_libre(1);
    $tarjeta->recargar(272);

    $colectivo144Negro = new Colectivo("144 Negro", "Rosario Bus");    
    $tarjeta->pagar($colectivo144Negro, "2016/06/30 20:50");
    $this->assertEquals($tarjeta->saldo(), 320, "Pasa sin pagar");
  }

  public function testBici(){
    $tarjeta = new Tarjetas_comun(1);
    $medio = new Medio_boleto(2);
    $tarjeta->recargar(272);
    $medio->recargar(272);
    $bici = new Bici(1234);

    $tarjeta->pagar($bici, "2016/07/02 08:10");
    $medio->pagar($bici, "2016/08/02 09:10");

    $this->assertEquals($tarjeta->saldo(), 308, "Me voy a dar una vuelta en bici papa");
    $this->assertEquals($medio->saldo(), 314, "Me voy a dar una vuelta en bici con medio");
  }

  public function testBoleto(){
    $boleto = new Boleto("2016/07/02 08:10", 0, 8, 304, "135 Azul", 2311);
    $this->assertEquals($boleto->getcosto(), 8, "Costo de nomal");
    $this->assertEquals($boleto->getfecha(), "2016/07/02 08:10", "La fechita");
    $this->assertEquals($boleto->getlinea(), "135 Azul", "El trolebus que te tomaste");
    $this->assertEquals($boleto->getid(), 2311, "23");
    $this->assertEquals($boleto->getsaldo(), 304, "Cada vez mas caro el bondi");
    $this->assertEquals($boleto->gettipo(), "Normal", "El 0 es un nro muy normal");
  }

}
