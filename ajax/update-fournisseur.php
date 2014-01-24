<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$file = 'test-log.txt';
// Open the file to get existing content
$log = file_get_contents($file);







// Append a new person to the file
$log .= "Update: " . $_POST['id_fournisseur'].' ';



$sql = "UPDATE `pharma`.`fournisseur` SET 
		`nom_fournisseur` = :nom_fournisseur ,
		`personne_contact` = :personne_contact ,
		`adresse` = :adresse ,
		`code_postal` = :code_postal ,
		`ville` = :ville ,
		`tel` = :tel ,
		`email` = :email
		
		
		WHERE `fournisseur`.`id_fournisseur` LIKE '".$_POST['id_fournisseur']."'";
if (!$stmt = $conn->prepare($sql)) {
	$log .= "Error: Update Statement invalid.";
}else{
	$log.= "Statement prepared.";
	if ($stmt->execute(array(
		':nom_fournisseur' => $_POST['nom_fournisseur'],
		':personne_contact' => $_POST['personne_contact'],
		':adresse' => $_POST['adresse'],
		':code_postal' => $_POST['code_postal'],
		':ville' => $_POST['ville'],
		':tel' => $_POST['tel'],
		':email' => $_POST['email']
	))) { $log .= "Update réussie"; 
		$returnPhp = array( 'id_fournisseur' => $_POST['id_fournisseur'] );
 } else { $log .= " Update échouée : ".print_r($stmt->errorInfo(), true); 
	 $returnPhp = null;
 
 }
}


// Write the contents back to the file
file_put_contents($file, $log."\n");

$return = json_encode( $returnPhp );
echo $return;
?>
