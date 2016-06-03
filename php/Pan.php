<?php
class Pan {

	private $_couleur;
	private $_taille;

	public function __construct() {
		$this->_couleur='z';
		$this->_taille=0;	
	}

	public function getCouleur() {return $this->_couleur;}
	public function setCouleur($couleur) {$this->_couleur=$couleur;}
	public function getTaille() {return $this->_taille;}
	public function setTaille($taille) {$this->_taille=$taille;}
	
	public function random() {
		$chaine="abcdefghij";
		$this->_couleur=$chaine[rand(0,9)];
		$this->_taille=rand(1,6);
	}
}
?>