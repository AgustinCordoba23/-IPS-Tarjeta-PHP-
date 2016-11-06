<?php

namespace Tarjeta;

class Pase_libre extends Tarjetas_comun{	
	public function __construct($id){
		$this->id = $id;
		$this->plus = 0;
		$this->plata = 0;
		$this->boleto_cole = 0;
		$this->boleto_bici = 0;
		$this->transbordo = 0;
	}
}


?>