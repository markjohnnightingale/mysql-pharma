<?php
require "../connect.php";


$file = 'test-log.txt';
// Open the file to get existing content
$log = file_get_contents($file);
// Append a new person to the file
$log .= "Update:" . $_POST['id_med'] . ' : ' . $_POST['stock'].' ';



$sql = "UPDATE `pharma`.`medicament` SET `stock` = :stock WHERE `medicament`.`id_med` = :id_med";
if (!$stmt = $conn->prepare($sql)) {
	$log .= "Error: Update Statement invalid.";
}else{
	$log.= "Statement prepared.";
	if ($stmt->execute(array(
		':id_med' => $_POST['id_med'],
		':stock' => $_POST['stock'],
	))) { $log .= " Update réussie"; } else { $log .= " Update échouée"; }
}


//Grab the new stock value to show
$sql = "SELECT `stock` FROM medicament WHERE `medicament`.`id_med` = :id_med";
if (!$stmt = $conn->prepare($sql)) {
	$log .= "Error: Select Statement invalid.";
}else{
	$log.= "Statement prepared.";
	if ($stmt->execute(array(
		':id_med' => $_POST['id_med']
	))) { $log .= " Select réussie";
		$newStock = $stmt->fetch(PDO::FETCH_ASSOC);
		
		 } else { $log .= " Select échouée"; }
}

// Write the contents back to the file

$log .= " Returned: ".$newStock['stock'];
file_put_contents($file, $log."\n");;

$returnPhp = array(
	'id_med' => $_POST['id_med'],
	'stock' => $newStock['stock']
);

$return = json_encode( $returnPhp );
echo $return;

?>
