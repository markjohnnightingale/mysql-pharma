<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);




$meds = $_POST['meds'];



// Change status of Order
$log = "Validate: " . $_POST['id_commande'].' ';



$sql = "UPDATE `commande` SET 
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
	 $returnPhp['success'] = -1;
 
 }
}

// Update medicaments stocks
//SQL to update quantities
$sqlUpdate = "UPDATE `medicament` SET `stock` = `stock`-:qte WHERE `id_med` LIKE :id_med";
if (!$stmtUpdate = $conn->prepare($sqlUpdate)){
	$log .= "Update to stock failed to prepare. ";
	$return['success'] = -1;
	
	
} else {
	$log .= "Update to stock prepared. ";
	foreach ($meds as $med){
		$valuesUpdate = array(
			'qte' => $med['qte'],
			'id_med' => $med['id_med']
		);
	
		if ($stmtUpdate->execute($valuesUpdate)) {
			$log .= "Med ".$med['id_med']." qte reduced by ".$med['qte'].". ";
		} else {
			$log .= "Med ".$med['id_med']." qt reduced. ";
			$return['success'] = -1;
		}
	}
}

// Write the contents back to the file
//file_put_contents($file, $log."\n");

$return = json_encode( $returnPhp );
echo $return;
?>
