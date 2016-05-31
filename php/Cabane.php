<?php

require_once 'Face.php';

class Cabane {	

	private $_nord;
	private $_sud;
	private $_est;
	private $_ouest;
	private $_ouverture;
	private $_x;
	private $_y;

	// initialisation des attributs par défaut
	public function __construct() {
		$this->_nord=new Face;
		$this->_sud=new Face;
		$this->_est=new Face;
		$this->_ouest=new Face;
		$this->_ouverture='n';
		$this->_x=0.0;
		$this->_y=0.0;
	}

	public function getNord() {return $this->_nord;}
	public function setNord($nord) {$this->_nord=$nord;}
	public function getSud() {return $this->_sud;}
	public function setSud($sud) {$this->_sud=$sud;}
	public function getEst() {return $this->_est;}
	public function setEst($est) {$this->_est=$est;}
	public function getOuest() {return $this->_ouest;}
	public function setOuest($ouest) {$this->_ouest=$ouest;}
	public function getOuverture() {return $this->_ouverture;}
	public function setOuverture($ouverture) {$this->_ouverture=$ouverture;}
	public function getX() {return $this->_x;}
	public function setX($x) {$this->_x=$x;}
	public function getY() {return $this->_y;}
	public function setY($y) {$this->_y=$y;}
	
	// fonction aléatoire
	public function random() {
		do {
			$this->_nord->random();
			$this->_sud->random();
			$this->_est->random();
			$this->_ouest->random();
		}while(!$this->condition1() || !$this->condition2()); // tant que les condition ne sont pas respectées
	}
	
	// affichage simplifié
	public function getString() {
		$retour=$this->_nord->getDroit()->getCouleur().$this->_nord->getDroit()->getTaille();
		$retour.=$this->_nord->getGauche()->getCouleur().$this->_nord->getGauche()->getTaille();
		$retour.=$this->_est->getDroit()->getCouleur().$this->_est->getDroit()->getTaille();
		$retour.=$this->_est->getGauche()->getCouleur().$this->_est->getGauche()->getTaille();
		$retour.=$this->_sud->getDroit()->getCouleur().$this->_sud->getDroit()->getTaille();
		$retour.=$this->_sud->getGauche()->getCouleur().$this->_sud->getGauche()->getTaille();
		$retour.=$this->_ouest->getDroit()->getCouleur().$this->_ouest->getDroit()->getTaille();
		$retour.=$this->_ouest->getGauche()->getCouleur().$this->_ouest->getGauche()->getTaille();
		return $retour;
	}
	
	// savoir si l'objet cabane à les même attribut qu'une autre avec rotation
	public function estEgale($s1) {
		$s=$this->getString();
		for($i=0;$i<16;$i++) {
			if($s==$s1)
				return true;
			$c=$s1[0];
			$s1=substr($s1,1,15).$c;
		}
		return false;
	}
	
	// si la cabane à des couleurs différents
	public function condition1() {
		$s=$this->getString();
		for($i=0;$i<strlen($s);$i+=2) 
			for($j=$i+2;$j<strlen($s);$j+=2) 
				if($s[$i]==$s[$j]) 
					return false;
		return true;
	}
	
	// si la cabane remplit les conditions sur les largeur de bande
	public function condition2() {
		$s=$this->getString();
		$tab=array("1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0);
		for($i=1;$i<strlen($s);$i+=2)
			$tab[$s[$i]]++;
		foreach ($tab as $val)
			if($val>2 || $val==0)
				return false;
		return true;
	}
}
?>