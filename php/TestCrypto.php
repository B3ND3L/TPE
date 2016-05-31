<?php
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// generate 2048-bit RSA key
$pkGenerate = openssl_pkey_new(array(
	'private_key_bits' => 2048,
	'private_key_type' => OPENSSL_KEYTYPE_RSA
));
 
// get the private key
openssl_pkey_export($pkGenerate,$pkGeneratePrivate); // NOTE: second argument is passed by reference
 
// get the public key
$pkGenerateDetails = openssl_pkey_get_details($pkGenerate);
$pkGeneratePublic = $pkGenerateDetails['key'];
 
// free resources
openssl_pkey_free($pkGenerate);
 
// fetch/import public key from PEM formatted string
// remember $pkGeneratePrivate now is PEM formatted...
// this is an alternative method from the public retrieval in previous
$pkImport = openssl_pkey_get_private($pkGeneratePrivate); // import
$pkImportDetails = openssl_pkey_get_details($pkImport); // same as getting the public key in previous
$pkImportPublic = $pkImportDetails['key'];
openssl_pkey_free($pkImport); // clean up

$myKey=array(2345678,"jsghQHTGEDFHQSHWGDFGYUZ");
openssl_public_encrypt("cou", $e, $myKey);
echo "<br /><br />Text chiffré : ".strlen($e);
echo "<br /><br />";
for($i=0;$i<strlen($e);$i++)
	echo (ord($e[$i]) % 60).",";
openssl_private_decrypt ($e,$d,$pkGeneratePrivate);
echo "<br /><br />Text dechiffré : ".$d;

?>