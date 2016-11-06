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
	private $hora_anterior;
	private $linea_anterior;
	private $viajes;
	private $plus;
	protected $boleto_cole;
	protected $boleto_bici;
	protected $transbordo;

	public function __construct($id){
		$this->id = $id;
		$this->plus = 0;
		$this->plata = 0;
		$this->boleto_cole = 8;
		$this->boleto_bici = 12;
		$this->transbordo = (float)((int)($this->boleto_cole/3*100)/100);
	}

	public function saldo(){
		return $this->plata;
	}

	public function viajesRealizados(){
		return $this->viajes;
	}

	public function recargar($monto){
		if ($monto < 272) $this->plata = $this->plata + $monto;
		else if ($monto < 500) $this->plata = $this->plata + $monto + 48;
		else $this->plata = $this->plata + $monto + 140;

		$this->plus = 0;
	}

	public function pagar(Transporte $transporte, $fecha_y_hora){
		if ($transporte->tipo == "colectivo"){
			if ($this->plus == 2 && $this->plata < $this->boleto_cole){
				return "No tenes saldo";
			}

			if ($this->plata < $this->boleto_cole && $this->plus < 2){
				$this->plata = $this->plata - $this->boleto_cole;
				$this->plus = $this->plus + 1;
			}else if ($this->plata > $this->boleto_cole){

			if ($transporte->linea != $this->linea_anterior){
				if ($this->viajes == 0){
					$this->plata = $this->plata - $this->boleto_cole;
				}
				else{
					if (strtotime($fecha_y_hora) - strtotime($this->hora_anterior) <= 5400){

						if (strftime("%w", strtotime($fecha_y_hora)) < 5 && strftime("%H", strtotime($fecha_y_hora)) <=22 && strftime("%H", strtotime($fecha_y_hora))>=6){
							if (strtotime($fecha_y_hora) - strtotime($this->hora_anterior)) <= 3600){
								$this->plata = $this->plata - $this->transbordo;
							}
							else{
								$this->plata = $this->plata - $this->boleto_cole;
							}
						}

						if (strftime("%w", strtotime($fecha_y_hora)) == 5 && strftime("%H", strtotime($fecha_y_hora)) <=14 && strftime("%H", strtotime($fecha_y_hora))>=6){
							if (strtotime($fecha_y_hora) - strtotime($this->hora_anterior)) <= 3600){
								$this->plata = $this->plata - $this->transbordo;
							}
							else{
								$this->plata = $this->plata - $this->boleto_cole;
							}
						}

						$this->plata = $this->plata - $this->transbordo;

					}
					else{
						$this->plata = $this->plata - $this->boleto_cole;
					}
				}
			}
			else{
				$this->plata = $this->plata - $this->boleto_cole;
			}
			
			$this->linea_anterior = $transporte->linea;
			$this->hora_anterior = $fecha_y_hora;
			$this->viajes = $this->viajes + 1;
		}
	}
		else{
			if (strtotime($fecha_y_hora) - strtotime($this->hora_anterior) > 86400){
				$this->plata = $this->plata - $this->boleto_bici;
			}
			$this->viajes = $this->viajes + 1;		
		}
	}
}
