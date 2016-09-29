<?php

//Cordoba

namespace Tarjeta;

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
		return $this->plata;
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
