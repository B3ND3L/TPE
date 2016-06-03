function appelPhp(){
	
	var seedUser = $("#seed").val();
	var distUser = $("#distance").val();
	
	if(seedUser == undefined ) seedUser = "";
	if(distUser == undefined ) distUser = 2;
	
	$.post( "php/Calcul.php", { distance : distUser, seed : seedUser })
	.done(function( data ) {
		console.log(data);
		tabCabane=jQuery.parseJSON(data).cabanes;
		seed=jQuery.parseJSON(data).seed;
		$("#seed").val(seed);
	});
}
