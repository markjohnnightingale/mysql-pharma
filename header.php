<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MySQL Pharmacie</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/modernizr.js"></script>
	<script src="http://code.jquery.com/jquery-1.10.2.min.js">
	</script>
	<style>
	.tiny-text {
		font-size: 0.7em;
	}
	
	</style>
  </head>
  <body>
      <!-- Header and Nav -->
  <nav class="top-bar" data-topbar>
    <ul class="title-area">
      <!-- Title Area -->
      <li class="name">
        <h1>
          <a href="index.php?page=home">
           Projet MySQL Pharma
          </a>
        </h1>
      </li>
      <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
    </ul>

    <section class="top-bar-section">

      <!-- Right Nav Section -->
      <ul class="right">
        <li class="divider"></li>
        <li class="has-dropdown">
          <a href="#">Gestion des stocks</a>
          <ul class="dropdown">
            <li><a href="index.php?page=afficher-catalogue">Stocks</a></li>
            <li><a href="#">Fournisseurs</a></li>
	        <li class="divider"></li>
          </ul>
        </li>
        <li class="has-dropdown">
          <a href="#">Gestion des commandes</a>
          <ul class="dropdown">
            <li><a href="#">Commandes</a></li>
            <li><a href="#">Clients</a></li>
          </ul>
        </li>
        <li class="divider"></li>
		<li class="has-form"> <a href="#" class="button">Commander des stocks</a> </li>
      </ul>
    </section>
  </nav>


  <!-- End Header and Nav -->