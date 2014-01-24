<div class="row">
   
  <div class="large-10 push-3 columns">
	  <h1>Gestion des fournisseurs</h1>
	  <p>Depuis cette interface vous pouvez gérer les différents fournisseurs.</p>
  </div>

</div>



<div class="row">

  <div class="large-12 columns">
	  <table>
		  <thead>
			  <tr>
				  <th>Nom du fournisseur</th>
				  <th>Personne à contacter</th>
				  <th>Adresse</th>
				  <th>Code Postal</th>
				  <th>Ville</th>
				  <th>Téléphone</th>
				  <th>E-mail</th>
				  <th>Modifier</th>
			  </tr>
		  </thead>
		  <tbody id="ajax-load-list-fournisseurs">
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
		   
		  <tr>
			  <div id="outcome" data-alert class="alert-box" style="display: none;">
				  <a href="#" class="close">&times;</a>
			  </div>
		  </tr>
		  </tbody> 
		  
	  </table>
  </div>
</div>
		  <div class="row">
			  <div class="large-12 columns"><h3>Ajout rapide</h3></div>
			</div>
			 <form id="add-to-db" method="POST">
				<div class="row">
					<div class="large-4 columns">
					   <input id="id_fournisseur_field" name="id_fournisseur" type="text" placeholder="ID (10 caractères)">
					</div>
					<div class="large-4 columns">
						<input id="adresse" name="adresse" type="text" placeholder="Adresse">
					</div>
					<div class="large-4 columns">
						<input id="tel" name="tel" type="text" placeholder="Téléphone">
					</div>
				</div>
				<div class="row">
					<div class="large-4 columns">
						<input id="nom_fournisseur_field" name="nom_fournisseur" type="text" placeholder="Nom">
					</div>
					<div class="large-1 columns">
						<input id="code_postal" name="code_postal" type="number" placeholder="Code Postal">
					</div>
					<div class="large-3 columns">
						<input id="ville" name="ville" type="text" placeholder="Ville">
					</div>
					<div class="large-4 columns">
						<input id="email" name="email" type="text" placeholder="Email">
					</div>
				</div>
				<div class="row">
					<div class="large-4 columns">
						<input id="personne_contact" name="personne_contact" type="text" placeholder="Personne à contacter">
					</div>
					<button type="submit" class="large-4 push-4 button alert tiny radius">Ajouter</a>
				</div>				  
			</form>
			
<script>

$(document).ready(function(){
	
	//Clear the form
	jQuery.fn.emptyMyForm = function(){
	    return this.each(function(){
			$('#id_fournisseur_field').show().val('');
			$('#nom_fournisseur_field').show().val('');
			$('#personne_contact, #adresse, #code_postal, #ville, #tel, #email').val('');
		});
	};
	$('#add-to-db').emptyMyForm();
	
	
	//Grab the table of suppliers by Ajax
	$('#ajax-load-list-fournisseurs').hide().load('ajax/afficher-fournisseurs.php').fadeIn();
	$('#add-to-db').on('submit',function(){
		$.ajax({
		  url:'ajax/inserer-fournisseur-ajax.php',
		  data:$(this).serialize(),
		  type:'POST',
		  success:function(data){
			  $('#outcome').prepend(data).fadeIn();
			  $('#ajax-load-list-fournisseurs').fadeOut().load('ajax/afficher-fournisseurs.php').fadeIn();
			  
		  	}
		});
		
		return false;
	});
});
	
	
	

</script>