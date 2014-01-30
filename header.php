<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MySQL Pharmacie</title>
	
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/alertify.core.css" />
    <link rel="stylesheet" href="css/alertify.bootstrap.css" />
	
	
    <script src="js/modernizr.js"></script>
	<script src="js/jquery.js"></script>
	
	<style>
	.tiny-text {
		font-size: 0.7em;
	}
	
	td {
		vertical-align: top;
	}
	
	
	/* Loading Spinner */
	#followingBallsG{
	position:relative;
	width:256px;
	height:20px;
	margin: 0 auto;
	}

	.followingBallsG{
	background-color:#000000;
	position:absolute;
	top:0;
	left:0;
	width:20px;
	height:20px;
	-moz-border-radius:10px;
	-moz-animation-name:bounce_followingBallsG;
	-moz-animation-duration:1.3s;
	-moz-animation-iteration-count:infinite;
	-moz-animation-direction:linear;
	-webkit-border-radius:10px;
	-webkit-animation-name:bounce_followingBallsG;
	-webkit-animation-duration:1.3s;
	-webkit-animation-iteration-count:infinite;
	-webkit-animation-direction:linear;
	-ms-border-radius:10px;
	-ms-animation-name:bounce_followingBallsG;
	-ms-animation-duration:1.3s;
	-ms-animation-iteration-count:infinite;
	-ms-animation-direction:linear;
	-o-border-radius:10px;
	-o-animation-name:bounce_followingBallsG;
	-o-animation-duration:1.3s;
	-o-animation-iteration-count:infinite;
	-o-animation-direction:linear;
	border-radius:10px;
	animation-name:bounce_followingBallsG;
	animation-duration:1.3s;
	animation-iteration-count:infinite;
	animation-direction:linear;
	}

	#followingBallsG_1{
	-moz-animation-delay:0s;
	}

	#followingBallsG_1{
	-webkit-animation-delay:0s;
	}

	#followingBallsG_1{
	-ms-animation-delay:0s;
	}

	#followingBallsG_1{
	-o-animation-delay:0s;
	}

	#followingBallsG_1{
	animation-delay:0s;
	}

	#followingBallsG_2{
	-moz-animation-delay:0.13s;
	-webkit-animation-delay:0.13s;
	-ms-animation-delay:0.13s;
	-o-animation-delay:0.13s;
	animation-delay:0.13s;
	}

	#followingBallsG_3{
	-moz-animation-delay:0.26s;
	-webkit-animation-delay:0.26s;
	-ms-animation-delay:0.26s;
	-o-animation-delay:0.26s;
	animation-delay:0.26s;
	}

	#followingBallsG_4{
	-moz-animation-delay:0.39s;
	-webkit-animation-delay:0.39s;
	-ms-animation-delay:0.39s;
	-o-animation-delay:0.39s;
	animation-delay:0.39s;
	}

	@-moz-keyframes bounce_followingBallsG{
	0%{
	left:0px;
	background-color:#000000;
	}

	50%{
	left:236px;
	background-color:#FFFFFF;
	}

	100%{
	left:0px;
	background-color:#000000;
	}

	}

	@-webkit-keyframes bounce_followingBallsG{
	0%{
	left:0px;
	background-color:#000000;
	}

	50%{
	left:236px;
	background-color:#FFFFFF;
	}

	100%{
	left:0px;
	background-color:#000000;
	}

	}

	@-ms-keyframes bounce_followingBallsG{
	0%{
	left:0px;
	background-color:#000000;
	}

	50%{
	left:236px;
	background-color:#FFFFFF;
	}

	100%{
	left:0px;
	background-color:#000000;
	}

	}

	@-o-keyframes bounce_followingBallsG{
	0%{
	left:0px;
	background-color:#000000;
	}

	50%{
	left:236px;
	background-color:#FFFFFF;
	}

	100%{
	left:0px;
	background-color:#000000;
	}

	}

	@keyframes bounce_followingBallsG{
	0%{
	left:0px;
	background-color:#000000;
	}

	50%{
	left:236px;
	background-color:#FFFFFF;
	}

	100%{
	left:0px;
	background-color:#000000;
	}

	}
	
	
	</style>
  </head>
  <body>
      <!-- Header and Nav -->
  <nav class="top-bar sticky" data-topbar>
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
		  <li class="has-form"> 
			  <form action="index.php?page=search" method="POST">
				  <div class=" row collapse">
					  <div class="large-8 small-9 columns"> 
						  <input type="text" name="query" placeholder="Rechercher médicament"> 
					  </div> 
					  <div class="large-4 small-3 columns"> 
						  <button type="submit" class="alert button">OK</a>
					  </div>
				  </div>
			  </form> 
			  
		  </li>
        <li class="divider"></li>
        <li class="has-dropdown">
          <a href="#">Médicaments</a>
          <ul class="dropdown">
            <li><a href="index.php?page=afficher-catalogue">Voir les stocks</a></li>
            <li><a href="index.php?page=modifier-medicament">Ajouter/modifier un médicament</a></li>
          </ul>
        </li>
        <li class="has-dropdown">
          <a href="#">Fournisseurs</a>
          <ul class="dropdown">
            <li><a href="index.php?page=afficher-fournisseurs">Voir la liste</a></li>
            <li><a href="index.php?page=modifier-fournisseur">Ajouter/modifier un fournisseur</a></li>
          </ul>
        </li>
        <li class="has-dropdown">
          <a href="#">Clients</a>
          <ul class="dropdown">
            <li><a href="index.php?page=afficher-clients">Voir la liste</a></li>
            <li><a href="index.php?page=modifier-client">Ajouter/modifier un client</a></li>
          </ul>
        </li>
        <li class="has-dropdown">
          <a href="#">Commandes</a>
          <ul class="dropdown">
            <li><a href="index.php?page=afficher-commandes">Voir les commandes</a></li>
            <li><a href="index.php?page=preparer-commande">Préparer une commande</a></li>
          </ul>
        </li>
        <li class="divider"></li>
		<li class="has-form"> <a href="index.php?page=preparer-commande" class="button">Préparer une commande client</a> </li>
      </ul>
    </section>
  </nav>


  <!-- End Header and Nav -->