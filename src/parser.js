function Cabane(x, y){
	this.x = x;
	this.y = y;
	this.coloration = "";
}

function getCabanes(){
	
	/*var array = [];
	
	array[0] = new Cabane(0,0);
	array[1] = new Cabane(2,0);
	array[2] = new Cabane(4,0);
	array[3] = new Cabane(6,0);
	array[4] = new Cabane(8,0);
	
	return array;*/
	
	return connectPhp();
	
	//return lireJSon();
	
}

function connectPhp(){
	
	$.post( "php/connexionAjax.php", { request : "crypto" })
	.done(function( data ) {
		//alert( "Data Received" );
		tabCabane=lireJSon(data);
	});
}

function lireJSon(json){

	//var json = '{"cabanes":[{"x":0,"y":0,"coloration":"coucou"},{"x":3,"y":3,"coloration":"youhou"}]}';
	console.log(json);
	var arrayCabane = jQuery.parseJSON(json).cabanes;
	//console.log(arrayCabane);
	/*o.forEach(function(v){
		console.log(v);
	});*/
	return arrayCabane;
}
