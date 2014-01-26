<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//Grab global variables
$id_client = $_POST['id_client'];
$mode_reglement = $_POST['mode_reglement'];
$meds = $_POST['id_meds'];


// Initialise variable to return

$return = array('log' => '', 'status' => 0);

// SQL pour inserer dans la table des commandes
$sql = "INSERT INTO commande VALUES ( '' , CURRENT_TIMESTAMP, :id_client, :mode_reglement, 'Validé' )";

if (!$stmt = $conn->prepare($sql)) {
	$return['log'] .= "Statement invalid. ";
	$return['status'] = -1;
}else{
	$return['log'] .= "Statement prepared. ";
	if ($stmt->execute(array(
		':id_client' => $id_client,
		':mode_reglement' => $mode_reglement,
		
	))) { $return['log'] .= "Execution reussie. Commande added:";
		
		$id_commande = $conn->lastInsertId();
		$return['log'] .= $id_commande.". ";
		
		// SQL to insert into relational table
		$sqlInsert = "INSERT INTO commande_medicaments VALUES ( '', :id_commande, :id_med, :qte )";
		
		//SQL to update quantities
		$sqlUpdate = "UPDATE `medicament` SET `stock` = `stock`-:qte WHERE `id_med` LIKE :id_med";
		
		
		if (!$stmtInsert = $conn->prepare($sqlInsert)){
			$return['log'] .= "Insert Meds failed to prepare. ";
			$return['status'] = -1;
								
		} else {
			$return['log'] .= "Insert Meds prepared. ";
			//Insert each med	
			foreach ($meds as $med) {
				$valuesInsert = array(
					'id_commande' => $id_commande,
					'id_med' => $med['id_med'],
					'qte' => $med['qte']
				);
				
				if ($stmtInsert->execute($valuesInsert)) {
					// Total success !!!!
					
					$return['log'] .= "Med ".$med['id_med']." added. ";
					$return['status'] = 1;
					$return['id_commande'] = $id_commande;
				} else {
					$return['log'] .= "Med ".$med['id_med']." not added. ";
					$return['status'] = -1;
				}
			
				
			}
			
		}
		if (!$stmtUpdate = $conn->prepare($sqlUpdate)){
			$return['log'] .= "Update to stock failed to prepare. ";
			$return['status'] = -1;
			
			
		} else {
			$return['log'] .= "Update to stock prepared. ";
			foreach ($meds as $med){
				$valuesUpdate = array(
					'qte' => $med['qte'],
					'id_med' => $med['id_med']
				);
			
				if ($stmtUpdate->execute($valuesUpdate)) {
					$return['log'] .= "Med ".$med['id_med']." qte reduced by ".$med['qte'].". ";
					$return['status'] = 1;
				} else {
					$return['log'] .= "Med ".$med['id_med']." qt reduced. ";
					$return['status'] = -1;
				}
			}
		}
				
	} else { $return['log'] .= "Execution de Insert echouee"; $return['status'] = -1; }
}
$returnJSON = json_encode($return);
print $returnJSON;
?>