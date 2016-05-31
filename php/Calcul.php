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
		// si la seed dépasse la limite
		if(strlen($phrase)>11)
			$phrase=substr($phrase,0,11);
		$nb=0;
		// conversion
		for($i=0;$i<strlen($phrase);$i++)
			$nb+=ord($phrase[$i])*pow(255,strlen($phrase)-1-$i);
		return $nb;
	}
	
	// aléatoire
	public function ramdom($phrase) {
		srand($this->getSeed($phrase));
		for($i=1;$i<=count($this->_tab);$i++) // pour chaque groupe
			for($j=0;$j<$this->_tab[$i]->getLigne();$j++) // pour chaque ligne
				for($k=0;$k<$this->_tab[$i]->getColonne();$k++) { // pour chaque colonne
    				$this->_tab[$i]->getCabane($j,$k)->random(); // aléatoire sur la cabane
    				$this->accepte($i,$j,$k); // s'assurer que la cabane est unique
    			}
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
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

$test=new Calcul;
$test->charge(); // charge xml
echo $test->getGroupe(1)->getCabane(0,0)->getString().'<br />'; // 1ere cabane initialiser par défaut
$test->ramdom("LH 2017"); // random
echo $test->getGroupe(1)->getCabane(0,0)->getString().'<br />'; // meme cabane mais apres initialisation


?>