<?php 

require "header.php"; 
require "connect.php";



if (isset($_GET['page'])){
$page = $_GET['page'];
}

if (isset($_GET['page'])) {
	switch ($page){
		case "home":
		require "home.php";
		break;
		case "afficher-catalogue":
		require "afficher-catalogue.php";
		break;
		case "afficher-fournisseurs":
		require "afficher-fournisseurs.php";
		break;
		case "afficher-clients":
		require "afficher-clients.php";
		break;
		case "afficher-commandes":
		require "afficher-commandes.php";
		break;
		case "preparer-commande":
		require "prepare-commande.php";
		break;
		case "modifier-medicament":
		require "modifier-medicament.php";
		break;
		case "modifier-fournisseur":
		require "modifier-fournisseur.php";
		break;
		case "modifier-client":
		require "modifier-client.php";
		break;
		case "visualiser-commande":
		require "visualiser-commande.php";
		break;
		case "search":
		require "search.php";
		break;		
		default: require "404.php";
	}
} else {
	require "home.php";
}
?>
  
<?php require "footer.php";
require "disconnect.php"; ?>

