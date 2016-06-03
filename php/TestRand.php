<?php
	
function getSeed($phrase) {
	if(strlen($phrase)>20)
		$phrase=substr($phrase,0,20);
	$nb=0;
	for($i=0;$i<strlen($phrase);$i++)
		$nb+=ord($phrase[$i])*pow(255,strlen($phrase)-1-$i);
	return $nb;
}

	$phrase = "LH 2017";
	for($i=1;$i<strlen($phrase);$i++) {
		srand(getSeed(substr($phrase,0,$i)));
		echo $i." : ".rand()."<br />";
	}
	echo "fin";
?>