<?php

require_once 'Pan.php';

class Face {	

	private $_gauche;
	private $_droit;

	public function __construct() {
		$this->_gauche=new Pan;
		$this->_droit=new Pan;
	}

	public function getGauche() {return $this->_gauche;}
	public function setGauche($gauche) {$this->_gauche=$gauche;}
	public function getDroit() {return $this->_droit;}
	public function setDroit($droit) {$this->_droit=$droit;}
	
	public function random() {
		$this->_gauche->random();
		$this->_droit->random();
	}
}
?>