<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);








// Append a new person to the file
$log = "Validate: " . $_POST['id_commande'].' ';



$sql = "UPDATE `pharma`.`commande` SET 
		`statut` = :statut
		
		
		WHERE `commande`.`id_commande` LIKE '".$_POST['id_commande']."'";
if (!$stmt = $conn->prepare($sql)) {
	$log .= "Error: Update Statement invalid.";
}else{
	$log.= "Statement prepared.";
	if ($stmt->execute(array(
		':statut' => "Validé"
	))) { $log .= "Update réussie"; 
		$returnPhp = array( 'id_commande' => $_POST['id_commande'], 'success' => 1 );
 } else { $log .= " Update échouée."; 
	 $returnPhp['statut'] = -1;
 
 }
}


// Write the contents back to the file
//file_put_contents($file, $log."\n");

$return = json_encode( $returnPhp );
echo $return;
?>
