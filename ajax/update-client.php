<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$file = 'test-log.txt';
// Open the file to get existing content
$log = file_get_contents($file);







// Append a new person to the file
$log .= "Update: " . $_POST['no_client'].' ';



$sql = "UPDATE `pharma`.`clients` SET
		`civilite` = :civilite ,
		`prenom` = :prenom ,
		`nom` = :nom ,
		`date_naissance` = :date_naissance ,
		`adresse` = :adresse ,
		`code_postal` = :code_postal ,
		`ville` = :ville ,
		`tel` = :tel ,
		`email` = :email,
		`no_insee` = :no_insee,
		`caisse` = :caisse,
		`mutuelle` = :mutuelle
		
		
		WHERE `clients`.`no_client` LIKE :no_client";
if (!$stmt = $conn->prepare($sql)) {
	$log .= "Error: Update Statement invalid.";
}else{
	$log.= "Statement prepared.";
	if ($stmt->execute(array(
		':no_client' => $_POST['no_client'],
		':civilite' => $_POST['civilite'],
		':prenom' => $_POST['prenom'],
		':nom' => $_POST['nom'],
		':date_naissance' => $_POST['date_naissance'],
		':adresse' => $_POST['adresse'],
		':code_postal' => $_POST['code_postal'],
		':ville' => $_POST['ville'],
		':tel' => $_POST['tel'],
		':email' => $_POST['email'],
		':no_insee' => $_POST['no_insee'],
		':caisse' => $_POST['caisse'],
		':mutuelle' => $_POST['mutuelle']
	))) { $log .= "Update réussie"; 
		$returnPhp = array( 'no_client' => $_POST['no_client'] );
 } else { $log .= " Update échouée : ".print_r($stmt->errorInfo(), true); 
	 $returnPhp = null;
 
 }
}


// Write the contents back to the file
// file_put_contents($file, $log."\n");

$return = json_encode( $returnPhp );
echo $return;
?>
