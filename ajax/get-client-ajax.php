<?php
require "../connect.php";


## $file = 'test-log.txt';
// Open the file to get existing content
## $log = file_get_contents($file);
// Append a new person to the file
## $log .= "Select:" . $_POST['no_client'] . ' ;';


$sql = "SELECT * FROM clients WHERE `no_client` LIKE :no_client";
if (!$stmt = $conn->prepare($sql)) {
	## $log .= "Error: Update Statement invalid.";
}else{
	## $log.= "Statement prepared.";
	if ($stmt->execute(array(
		':no_client' => $_POST['no_client']
	))) { 
		## $log .= " Select réussie"; 
		$clientDetails = $stmt->fetch(PDO::FETCH_ASSOC);
	} else { ## $log .= " Select échouée"; 
	}
}

## $log .= " Returned: ".$clientDetails['nom'];
## file_put_contents($file, $log."\n");;


$return = json_encode( $clientDetails );
echo $return;
?>