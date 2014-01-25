<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//Grab global variables
$id_client = $_POST['id_client'];
$mode_reglement = $_POST['mode_reglement'];
$meds = $_POST['id_meds'];


// SQL pour insérer dans la table des commandes
$sql = "INSERT INTO commande VALUES ( '' , CURRENT_TIMESTAMP, :id_client, :mode_reglement )";

if (!$stmt = $conn->prepare($sql)) {
	echo "Statement invalid.\n";
}else{
	echo "Statement prepared.\n";
	if ($stmt->execute(array(
		':id_client' => $id_client,
		':mode_reglement' => $mode_reglement,
		
	))) { echo "Execution réussie. Commande added:";
		
		$id_commande = $conn->lastInsertId();
		print $id_commande."\n";
		
		// SQL to insert into relational table
		$sqlInsert = "INSERT INTO commande_medicaments VALUES ( '', :id_commande, :id_med, :qte )";
		
		//SQL to update quantities
		$sqlUpdate = "UPDATE `medicament` SET `stock` = `stock`-:qte WHERE `id_med` LIKE :id_med";
		
		
		if (!$stmtInsert = $conn->prepare($sqlInsert)){
			print "Insert Meds failed to prepare.\n";
					
		} else {
			print "Insert Meds prepared.\n";
			//Insert each med	
			foreach ($meds as $med) {
				$valuesInsert = array(
					'id_commande' => $id_commande,
					'id_med' => $med['id_med'],
					'qte' => $med['qte']
				);
				
				if ($stmtInsert->execute($valuesInsert)) {
					print "Med ".$med['id_med']." added.\n";
				} else {
					print "Med ".$med['id_med']." not added.\n";
				}
			
				
			}
			
		}
		if (!$stmtUpdate = $conn->prepare($sqlUpdate)){
			print "Update to stock failed to prepare.\n";
			
		} else {
			print "Update to stock prepared.\n";
			foreach ($meds as $med){
				$valuesUpdate = array(
					'qte' => $med['qte'],
					'id_med' => $med['id_med']
				);
			}
			if ($stmtUpdate->execute($valuesUpdate)) {
				print "Med ".$med['id_med']." qte reduced by ".$med['qte'].".\n";
			} else {
				print "Med ".$med['id_med']." qt reduced.\n";
			}
		}
				
	} else { "Execution de Insert échouée"; }
}
?>