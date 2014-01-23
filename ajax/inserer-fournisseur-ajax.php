<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$id_fournisseur = $_POST['id_fournisseur'];
$nom_fournisseur = $_POST['nom_fournisseur'];
$personne_contact = $_POST['personne_contact'];
$adresse = $_POST['adresse'];
$code_postal = $_POST['code_postal'];
$ville = $_POST['ville'];
$tel = $_POST['tel'];
$email = $_POST['email'];




$sql = "INSERT INTO fournisseur VALUES ( :id_fournisseur , :nom_fournisseur, :personne_contact, :adresse, :code_postal, :ville, :tel, :email )";

if (!$stmt = $conn->prepare($sql)) {
	echo "Statement invalid.<br>";
}else{
	echo "Statement prepared.<br>";
	if ($stmt->execute(array(
		':id_fournisseur' => $_POST['id_fournisseur'],
		':nom_fournisseur' => $_POST['nom_fournisseur'],
		':personne_contact' => $_POST['personne_contact'],
		':adresse' => $_POST['adresse'],
		':code_postal' => $_POST['code_postal'],
		':ville' => $_POST['ville'],
		':tel' => $_POST['tel'],
		':email' => $_POST['email']
	))) { echo "Execution réussie"; } else { "Execution échouée"; }
}
?>