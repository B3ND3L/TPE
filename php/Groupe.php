<?php

require_once 'Cabane.php';

class Groupe {	

	private $_tab; // tableau de cabane
	private $_ligne; // nombre de ligne
	private $_colonne; // nombre de colonne

	public function __construct($lig,$col) {
		$this->_tab=array(); // construction du tableau
		for($i=0;$i<$lig;$i++) { // pour chaque ligne
			$ligne=array();
			for($j=0;$j<$col;$j++) { // pour chaque colonne
				$ligne[$j]=new Cabane;
			}
			$this->_tab[$i]=$ligne; // affectation de la ligne
		}
		$this->_ligne=$lig;
		$this->_colonne=$col;
	}

	public function getCabane($ligne,$colonne) {
		if($ligne>=0 && $ligne<$this->_ligne && $colonne>=0 && $colonne<$this->_colonne)
			return $this->_tab[$ligne][$colonne];
		else
			return;
	}
	
	public function getLigne() {return $this->_ligne;}
	public function getColonne() {return $this->_colonne;}
}
?>