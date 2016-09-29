<?php

namespace Tarjeta;

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


?>