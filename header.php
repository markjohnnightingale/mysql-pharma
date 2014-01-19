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