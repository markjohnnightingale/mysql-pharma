<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$client = $_POST['id_client'];
$mode_reglement = $_POST['mode_reglement'];
$medicaments = $_POST['medicaments'];



$sql = "INSERT INTO `commande` (`id_commande`, `date`, `client`, `mode_reglement`) VALUES ('', CURRENT_TIMESTAMP, :id_client, :mode_reglement);";

if (!$stmt = $conn->prepare($sql)) {
	echo "Statement invalid.<br>";
}else{
	echo "Statement prepared.<br>";
	if ($stmt->execute(array(
		':id_client' => $_POST['id_client'],
		':mode_reglement' => $_POST['mode_reglement'],
	))) { echo "Execution réussie"; } else { "Execution échouée"; }
}
?>