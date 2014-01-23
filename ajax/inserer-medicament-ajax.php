<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$id_med = $_POST['id_med'];
$nom_med = $_POST['nom_med'];
$equiv_generique = $_POST['equiv_generique'];
$agents_actifs = $_POST['agents_actifs'];
$maladie_traitee = $_POST['maladie_traitee'];
$id_fournisseur = $_POST['id_fournisseur'];
$prix = $_POST['prix'];
$stock = $_POST['stock'];




$sql = "INSERT INTO medicament VALUES ( :id_med , :nom_med, :equiv_generique, :agents_actifs, :prix, :stock, :fournisseur, :maladie_traitee )";

if (!$stmt = $conn->prepare($sql)) {
	echo "Statement invalid.<br>";
}else{
	echo "Statement prepared.<br>";
	if ($stmt->execute(array(
		':id_med' => $_POST['id_med'],
		':nom_med' => $_POST['nom_med'],
		':equiv_generique' => $_POST['equiv_generique'],
		':agents_actifs' => $_POST['agents_actifs'],
		':prix' => $_POST['prix'],
		':stock' => $_POST['stock'],
		':fournisseur' => $_POST['id_fournisseur'],
		':maladie_traitee' => $_POST['maladie_traitee']
	))) { echo "Execution réussie"; } else { "Execution échouée"; }
}
?>