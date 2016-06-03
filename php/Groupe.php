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
	
	public function accepte($ligne,$colonne,$distance) {
		$init=$ligne>$distance?$ligne-$distance:0;
		for($i=$init;$i<$ligne;$i++)
			if($this->_tab[$ligne][$colonne]->getNord()->ressemble($this->_tab[$i][$colonne]->getNord())
					|| $this->_tab[$ligne][$colonne]->getSud()->ressemble($this->_tab[$i][$colonne]->getSud()))
				return false;
		$init=$colonne>$distance?$colonne-$distance:0;
		for($i=$init;$i<$colonne;$i++)
			if($this->_tab[$ligne][$colonne]->getEst()->ressemble($this->_tab[$ligne][$i]->getEst())
					|| $this->_tab[$ligne][$colonne]->getOuest()->ressemble($this->_tab[$ligne][$i]->getOuest()))
				return false;
		return true;
	}
	
	public function getLigne() {return $this->_ligne;}
	public function getColonne() {return $this->_colonne;}
}
?>