<?php

namespace Tarjeta;

class Bici extends Transporte{
	public $nombre;
	public $tipo;

	public function __construct($nom){
		$this->tipo = "bici";
		$this->nombre = $nom;
	}
}


?>