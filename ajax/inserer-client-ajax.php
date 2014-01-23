<?php
require "../connect.php";

$no_client = $_POST['no_client'];
$nom_field = $_POST['nom_field'];
$date_naissance = $_POST['date_naissance'];
$adresse = $_POST['adresse'];
$code_postal = $_POST['code_postal'];
$ville = $_POST['ville'];
$tel = $_POST['tel'];
$email = $_POST['email'];
$no_insee = $_POST['no_insee'];
$caisse = $_POST['caisse'];
$mutuelle = $_POST['mutuelle'];


$sql = "INSERT INTO fournisseur VALUES ( :no_client , :nom_field, :date_naissance, :adresse, :ville, :code_postal, :tel, :email, :no_insee, :caisse, :mutuelle )";

if (!$stmt = $conn->prepare($sql)) {
	echo "Statement invalid.<br>";
}else{
	echo "Statement prepared.<br>";
	if ($stmt->execute(array(
		':no_client' => $_POST['no_client'],
		':nom_field' => $_POST['nom_field'],
		':date_naissance' => $_POST['date_naissance'],
		':adresse' => $_POST['adresse'],
		':ville' => $_POST['ville'],
		':code_postal' => $_POST['code_postal'],
		':tel' => $_POST['tel'],
		':email' => $_POST['email'],
		':no_insee' => $_POST['no_insee'],
		':caisse' => $_POST['caisse'],
		':mutuelle' => $_POST['mutuelle']
	))) { echo "Execution réussie"; } else { "Execution échouée"; }
}
?>