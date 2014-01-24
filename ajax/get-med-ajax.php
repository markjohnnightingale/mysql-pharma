<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);

 $file = 'test-log.txt';
// Open the file to get existing content
 $log = file_get_contents($file);
// Append a new person to the file
 $log .= "Select:" . $_POST['id_med'] . ' ;';


$sql = "SELECT * FROM medicament WHERE `id_med` LIKE :id_med";
if (!$stmt = $conn->prepare($sql)) {
	 $log .= "Error: Update Statement invalid.";
}else{
	## $log.= "Statement prepared.";
	if ($stmt->execute(array(
		':id_med' => $_POST['id_med']
	))) { 
		## $log .= " Select réussie"; 
		$medDetails = $stmt->fetch(PDO::FETCH_ASSOC);
	} else { ## $log .= " Select échouée"; 
	}
}

## $log .= " Returned: ".$clientDetails['nom'];
## file_put_contents($file, $log."\n");;


$return = json_encode( $medDetails );
echo $return;
?>