<?php

//Cordoba

interface Tarjeta {
  public function pagar(Transporte $transporte, $fecha_y_hora);
  public function recargar($monto);
  public function saldo();
  public function viajesRealizados();
}

class Tarjetas_comun implements Tarjeta{
	private $plata;
	private $viajes;
	private $hora_anterior;
	private $linea_anterior;
	protected $boleto_cole;
	protected $boleto_bici;
	protected $transbordo;

	public function __construct(){
		$this->plata = 0;
		$this->boleto_cole = 8;
		$this->boleto_bici = 12;
		$this->transbordo = (float)((int)($this->boleto_cole/3*100)/100);
	}

	public function saldo(){
		print $this->plata . "\n";
	}

	public function viajesRealizados(){
		print "\nViajes totales en transporte publico: " . $this->viajes . "\n";
	}

	public function recargar($monto){
		if ($monto < 272) $this->plata = $this->plata + $monto;
		else if ($monto < 500) $this->plata = $this->plata + $monto + 48;
		else $this->plata = $this->plata + $monto + 140;
	}

	public function pagar(Transporte $transporte, $fecha_y_hora){
		if ($transporte->tipo == "colectivo"){
			if ($transporte->linea != $this->linea_anterior){
				if ($this->viajes == 0){
					$this->plata = $this->plata - $this->boleto_cole;
					print "\nAbordando " . $transporte->tipo . " " . $transporte->linea . "\n";
				}
				else{
					if (strtotime($fecha_y_hora) - strtotime($this->hora_anterior) <= 3600){
						$this->plata = $this->plata - $this->transbordo;
						print "\nTransbordo a " . $transporte->tipo . " " . $transporte->linea . "\n";
					}
					else{
						$this->plata = $this->plata - $this->boleto_cole;
						print "\nAbordando " . $transporte->tipo . " " . $transporte->linea . "\n";
					}
				}
			}
			else{
				$this->plata = $this->plata - $this->boleto_cole;
				print "\nAbordando nuevamente " . $transporte->tipo . " " . $transporte->linea . "\n";
			}
			
			$this->linea_anterior = $transporte->linea;
			$this->hora_anterior = $fecha_y_hora;
			$this->viajes = $this->viajes + 1;
		}
		else{
			if (strtotime($fecha_y_hora) - strtotime($this->hora_anterior) > 86400){
				$this->plata = $this->plata - $this->boleto_bici;
				print "\nAbordando " . $transporte->tipo . " " . $transporte->nombre . "\n";
			}
			$this->viajes = $this->viajes + 1;
		}
	}
}

class Medio_boleto extends Tarjetas_comun{	
	public function __construct(){
		$this->plata = 0;
		$this->boleto_cole = 4;
		$this->boleto_bici = 6;
		$this->transbordo = (float)((int)($this->boleto_cole/3*100)/100);
	}
}

abstract class Transporte{
} 

class Bici extends Transporte{
	public $nombre;
	public $tipo;

	public function __construct($nom){
		$this->tipo = "bici";
		$this->nombre = $nom;
	}
}

class Colectivo extends Transporte{
	public $linea;
	public $empresa;
	public $tipo;

	public function __construct($lin, $emp){
		$this->linea = $lin;
		$this->empresa = $emp;
		$this->tipo = "colectivo";
	}
}

$tarjeta = new Tarjetas_comun;
$tarjeta->recargar(272);
print "Saldo ";
$tarjeta->saldo(); 

$colectivo144Negro = new Colectivo("144 Negro", "Rosario Bus");
$tarjeta->pagar($colectivo144Negro, "2016/06/30 22:50");
print "Saldo ";
$tarjeta->saldo(); 

$colectivo135 = new Colectivo("135 Azul", "Rosario Bus");
$tarjeta->pagar($colectivo135, "2016/06/30 23:10");
print "Saldo ";  
$tarjeta->saldo(); 

$bici = new Bici(1234);
$tarjeta->pagar($bici, "2016/07/02 08:10");
print "Saldo ";
$tarjeta->saldo();

$tarjeta->viajesRealizados();

