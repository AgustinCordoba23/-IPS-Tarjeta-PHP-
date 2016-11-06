<?php

namespace Tarjeta;

class Boleto{

	protected $fecha;
	protected $saldo;
	protected $tipo;
	protected $tipos = array(0 => "Normal", 1 => "Medio", 2 => "Plus", 3=>"Libre");
	protected $linea;
	protected $costo;
	protected $id;

	public function __construct($fecha, $tipo, $costo, $saldo, $linea, $id){
		$this->fecha = $fecha;
		$this->tipo = $tipo;
		$this->costo = $costo;
		$this->saldo = $saldo;
		$this->linea = $linea;
		$this->id = $id;
	}

	public function getcosto(){
		return $this->costo;
	}
	
	public function getfecha(){
		return $this->fecha;
	}
	
	public function getlinea(){
		return $this->linea;
	}
	
	public function getid(){
		return $this->id;
	}
	
	public function getsaldo(){
		return $this->saldo;
	}
	
	public function gettipo(){
		return $this->tipos[$this->tipo];
	}
}

?>