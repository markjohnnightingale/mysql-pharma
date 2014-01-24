<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$file = 'test-log.txt';
// Open the file to get existing content
$log = file_get_contents($file);







// Append a new person to the file
$log .= "Update: " . $_POST['id_med'].' ';



$sql = "UPDATE `pharma`.`medicament` SET 
		`nom_med` = :nom_med ,
		`equiv_generique` = :equiv_generique ,
		`agents_actifs` = :agents_actifs ,
		`prix` = :prix ,
		`stock` = :stock ,
		`fournisseur` = :fournisseur ,
		`maladie_traitee` = :maladie_traitee
		
		
		WHERE `medicament`.`id_med` LIKE '".$_POST['id_med']."'";
if (!$stmt = $conn->prepare($sql)) {
	$log .= "Error: Update Statement invalid.";
}else{
	$log.= "Statement prepared.";
	if ($stmt->execute(array(
		':nom_med' => $_POST['nom_med'],
		':equiv_generique' => $_POST['equiv_generique'],
		':agents_actifs' => $_POST['agents_actifs'],
		':prix' => $_POST['prix'],
		':stock' => $_POST['stock'],
		':fournisseur' => $_POST['fournisseur'],
		':maladie_traitee' => $_POST['maladie_traitee']
	))) { $log .= "Update réussie"; 
		$returnPhp = array( 'id_med' => $_POST['id_med'] );
 } else { $log .= " Update échouée : ".print_r($stmt->errorInfo(), true); 
	 $returnPhp = null;
 
 }
}


// Write the contents back to the file
file_put_contents($file, $log."\n");

$return = json_encode( $returnPhp );
echo $return;
?>
