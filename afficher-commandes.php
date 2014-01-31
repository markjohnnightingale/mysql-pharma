<div class="row">
   
  <div class="large-10 push-3 columns">
	  <h1>Gestion des commandes</h1>
	  <p>Depuis cette interface vous pouvez gérer les ordonnances qui ont déjà été préparées.</p>
  </div>

</div>



<div class="row">

  <div class="large-12 columns">
	  <table>
		  <thead>
			  <tr>
				  <th>ID Commande</th>
				  <th>Date</th>
				  <th>Client</th>
				  <th>Ordonnance</th> <!-- ici liste de médicaments commandés par le client -->
				  <th>Prix total</th>
				  <th>Mode de règlement</th>
				  <th>Statut de la commande</th>
			  </tr>
		  </thead>
		  <tbody id="ajax-load-list-commandes">
			  <tr><td colspan=12><div class="windows8">
				  <div id="followingBallsG">
				  <div id="followingBallsG_1" class="followingBallsG">
				  </div>
				  <div id="followingBallsG_2" class="followingBallsG">
				  </div>
				  <div id="followingBallsG_3" class="followingBallsG">
				  </div>
				  <div id="followingBallsG_4" class="followingBallsG">
				  </div>
				  </div></td></tr>
		</tbody> 
		</table>

<script>

$(document).ready(function(){	
	
	//Grab the table of suppliers by Ajax
	$('#ajax-load-list-commandes').hide().load('ajax/afficher-commandes.php').fadeIn();
	$('#add-to-db').on('submit',function(){
		$.ajax({
		  url:'ajax/inserer-fournisseur-ajax.php',
		  data:$(this).serialize(),
		  type:'POST',
		  success:function(data){
			  $('#outcome').prepend(data).fadeIn();
			  $('#ajax-load-list-commandes').fadeOut().load('ajax/afficher-commandes.php').fadeIn();
			  
		  	}
		});
		
		return false;
	});
});
	
	
	

</script>