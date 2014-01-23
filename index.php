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
		//case "inserer-medicament-ajax":
		//require "inserer-medicament-ajax.php";
		//break;
		case "afficher-fournisseurs":
		require "afficher-fournisseurs.php";
		break;
		case "afficher-clients":
		require "afficher-clients.php";
		break;
		default: require "404.php";
	}
} else {
	require "home.php";
}
?>










  
    
<?php require "footer.php";
require "disconnect.php"; ?>

