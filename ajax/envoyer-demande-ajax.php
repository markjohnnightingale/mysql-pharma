<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);



$mailSuccess = 0;
foreach ($_POST['reapp'] as $med) {
    $to      = $_POST['test_email'];
    $subject = "Réapprovisionnement de la pharmacie";
    $message = 'Bonjour '.$med['personne_contact'].'<br><br>Merci d\'enregistrer notre commande de réapprovisionnement pour le médicament '.$med['nom_med'].'. <br><br>Cordialement,<br><br>Votre Nom Ici';
    $headers = 'From: our.pharmacie@pharma.fr';
    if (!mail($to, $subject, $message, $headers)) {
    	$mailSuccess = -1;
    }
}


//Grab global variables
$id_client = $_POST['id_client'];
$mode_reglement = $_POST['mode_reglement'];
$meds = $_POST['meds'];


// Initialise variable to return

$return = array('log' => '', 'status' => 0);
if (isset($_POST['id_client'])) {
	// SQL pour inserer dans la table des commandes
	$sql = "INSERT INTO commande VALUES ( '' , CURRENT_TIMESTAMP, :id_client, :mode_reglement, 'En attente des stocks' )";

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
				
		} else { $return['log'] .= "Execution de Insert echouee"; $return['status'] = -1; }
	}
	
}

$return['mail_success'] = $mailSuccess;
$returnJSON = json_encode($return);
print $returnJSON;
?>