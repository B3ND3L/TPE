<?php

require_once 'Groupe.php';

class Calcul{
	
	// tableau de groupe
	private $_tab;

	public function __construct() {
		$this->_tab=array();
	}

	// chargement xml
	public function charge() {
		$dom = new DomDocument();
		$dom->load('PlacementCabane.xml');
		$groupes=$dom->getElementsByTagName('groupe');
		foreach($groupes as $groupe) { // pour chaque groupe
			$id=$groupe->getAttribute("id");
    		$colonne=$groupe->getElementsByTagName("taille")->item(0)->getElementsByTagName("colonne")->item(0)->nodeValue; // taille colonne
    		$ligne=$groupe->getElementsByTagName("taille")->item(0)->getElementsByTagName("ligne")->item(0)->nodeValue; // taille ligne
    		$this->_tab[$id]=new Groupe($ligne,$colonne); // construction du groupe
    		$cabanes=$groupe->getElementsByTagName("cabane");
    		$lig=0;
    		$col=0;
    		foreach($cabanes as $cabane) { // pour chaque cabane
    			$this->_tab[$id]->getCabane($lig,$col)->setX($cabane->getElementsByTagName("coordonnee")->item(0)->getElementsByTagName("colonne")->item(0)->nodeValue); // coordonnée colonne
    			$this->_tab[$id]->getCabane($lig,$col)->setY($cabane->getElementsByTagName("coordonnee")->item(0)->getElementsByTagName("ligne")->item(0)->nodeValue); // coordonnée ligne
    			$this->_tab[$id]->getCabane($lig,$col)->setOuverture($cabane->getElementsByTagName("orientation")->item(0)->nodeValue[0]); // orientation de l'ouverture
    			if($col==$colonne-1) { // si on arrive au bout de la colonne
    				$col=0;
    				$lig++;
    			}
    			else
    				$col++;
    		}
		}
	}
	
	// conversion de seed (String -> int)
	public function getSeed($phrase) {
		$nb=0;
		// conversion
		for($i=0;$i<strlen($phrase);$i++)
			$nb+=ord($phrase[$i])*pow(255,strlen($phrase)-1-$i);
		return $nb;
	}
	
	public function calculSeed() {
		$chaine="abcdefghijklmnopkrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$retour="";
		for($i=0;$i<10;$i++)
			$retour.=$chaine[rand(0,strlen($chaine)-1)];
		return $retour;
	}
	
	// aléatoire
	public function ramdom($phrase,$distance) {
		if(strlen($phrase)==0)
			$phrase=$this->calculSeed();
		// si la seed dépasse la limite
		if(strlen($phrase)>10)
			$phrase=substr($phrase,0,10);
		srand((integer)$this->getSeed($phrase));
		for($i=1;$i<=count($this->_tab);$i++) // pour chaque groupe
			for($j=0;$j<$this->_tab[$i]->getLigne();$j++) // pour chaque ligne
				for($k=0;$k<$this->_tab[$i]->getColonne();$k++) { // pour chaque colonne
    				do {
    					$this->_tab[$i]->getCabane($j,$k)->random(); // aléatoire sur la cabane
    					$this->accepte($i,$j,$k); // s'assurer que la cabane est unique
    				}while(!$this->_tab[$i]->accepte($j,$k,$distance));
    			}
		return $phrase;
	}
	
	public function accepte($id,$lig,$col) {
		for($i=1;$i<=$id;$i++) // pour chaque groupe
			for($j=0;$j<$this->_tab[$i]->getLigne();$j++) // pour chaque ligne
				for($k=0;$k<$this->_tab[$i]->getColonne();$k++) // pour chaque colonne
					if($i!=$id && $j!=$lig && $k!=$col) // si ce n'est pas la même cabane
					if($this->_tab[$id]->getCabane($lig,$col)->estEgale($this->_tab[$i]->getCabane($j,$k)->getString())) { // la cabane est elle egale à une autre
						$this->_tab[$id]->getCabane($lig,$col)->random(); // aléatoire à nouveau
						$this->accepte($id,$lig,$col); // s'assurer à nouveau que la cabane est unique
					}
	}
	
	public function getGroupe($id) {
		return $this->_tab[$id];
	}
	
	public function versClient($seed) {
		$retour="{\"cabanes\":[";
		foreach ($this->_tab as $groupe) { // pour chaque groupe
			for($i=0;$i<$groupe->getLigne();$i++) // pour chaque ligne
				for($j=0;$j<$groupe->getColonne();$j++) { // pour chaque colonne
					$retour.="{";
					$retour.="\"x\":".$groupe->getCabane($i,$j)->getX().",";
					$retour.="\"y\":".$groupe->getCabane($i,$j)->getY().",";
					$retour.="\"texture\":\"".$groupe->getCabane($i,$j)->getString()."\",";
					$retour.="\"orientation\":\"".$groupe->getCabane($i,$j)->getOuverture()."\"},";
				}
		}
		$retour=substr($retour,0,strlen($retour)-1);
		$retour .= "],\"seed\":\"".$seed."\"}";
		echo $retour;
	}
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

if(isset($_POST['seed']) && isset($_POST['distance'])){
	$test=new Calcul;
	$test->charge(); // charge xml
	$seed=$test->ramdom($_POST['seed'],$_POST['distance']); // random
	$test->versClient($seed);
}


?>
