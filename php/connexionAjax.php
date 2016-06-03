<?php

if(isset($_POST['seed'])){
		
	$ecartBloc = [14,34,64,72,58,33,0];
	$ecartX = [2,2,8,8,8,7.5,7.5];
	$ecartY = 1.5; 
	$posEcartY = [-1,-1,-1,9,9,10,9];
	$longueurBloc = [1,1,11,16,18,24,27];
	$nbColonne = [23,27,6,6,6,6,6];
	
	$x = 0;
	$y = 0;
	
	$retour = "{\"cabanes\":[";

	// Blocs
	for($bloc=0;$bloc<7;$bloc++){
		for ($i=0; $i < $nbColonne[$bloc]+1; $i++) {
			for ($j=0; $j<$longueurBloc[$bloc]; $j++) {
				if($j>0||$i>0||$bloc>0) $retour .= ",";
				
				$retour .= "{\"x\":" . $x . ",\"y\":" . $y . "}";
				
				$y += 2;
				if ($j == $posEcartY[$bloc]) {
					$y += $ecartY;
				}
			}
			if($i < $nbColonne[$bloc]-1)
				$x += $ecartX[$bloc];
			else
				$x += 2;
			$y = 0;
		}

		$x += $ecartBloc[$bloc];
	}
	$retour .= "]}";
	
	echo $retour;
}

?>
