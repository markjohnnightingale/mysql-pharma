<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$file = 'test-log.txt';
// Open the file to get existing content
$log = file_get_contents($file);


$idFournisseur = $_POST['id_fournisseur'];

// Append a new person to the file
//$date = new DateTime();
//$logDate = $date->format('U = Y-m-d H:i:s') . "\n";
$log .= "Delete: " . $_POST['id_fournisseur'].' ';



$sql = "DELETE FROM `pharma`.`fournisseur` WHERE `fournisseur`.`id_fournisseur` = '$idFournisseur'";
if (!$stmt = $conn->query($sql)) {
	$log .= "Erreur: Delete Statement invalid.";
	$returnPhp = "Erreur: Delete Statement invalid.";
}else{
	$log.= "Deleted!";
	$returnPhp = "Votre médicament a été supprimé.";
	$log .= "Returned: $returnPhp";
}


// Write the contents back to the file
file_put_contents($file, $log."\n");

echo $returnPhp;
?>
