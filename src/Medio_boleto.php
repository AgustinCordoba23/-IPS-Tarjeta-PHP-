<?php

namespace Tarjeta;

class Medio_boleto extends Tarjetas_comun{	
	public function __construct(){
		$this->plata = 0;
		$this->boleto_cole = 4;
		$this->boleto_bici = 6;
		$this->transbordo = (float)((int)($this->boleto_cole/3*100)/100);
	}
}


?>