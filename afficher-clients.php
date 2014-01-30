<div class="row">
   
  <div class="large-10 push-3 columns">
	  <h1>Gestion des clients</h1>
	  <p>Depuis cette interface vous pouvez gérer les différents clients.</p>
  </div>

</div>



<div class="row">

  <div class="large-12 columns">
	  <table>
		  <thead>
			  <tr>
				  <th>Client</th>
				  <th>Date de naissance</th>
				  <th>Contact</th>
				  <th>N° INSEE</th>
				  <th>Caisse obligatoire</th>
				  <th>Mutuelle</th>
			  </tr>
		  </thead>
		  <tbody id="ajax-load-list-clients">
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
  </div>
</div>
<div class="row">
  <div class="large-12 columns"><h3>Ajout rapide</h3></div>
</div>
<form id="add-to-db" method="POST">
<div class="row">
	<div class="large-4 columns">
	   <input id="no_client" name="no_client" type="text" placeholder="ID (10 caractères)">
	</div>
	<div class="large-4 columns">
		<input id="adresse" name="adresse" type="text" placeholder="Adresse">
	</div>
	<div class="large-4 columns">
		<input id="no_insee" name="no_insee" type="text" placeholder="N° INSEE">
	</div>
</div>
<div class="row">
	<div class="large-1 columns">
		<select id="civilite" name="civilite" placeholder="Civilité">
			<option value="Mr.">Mr.</option>
			<option value="Mme">Mme</option>
		</select>
	</div>
	<div class="large-1 columns">
		<input id="prenom_field" name="prenom" type="text" placeholder="Prénom">
	</div>
	<div class="large-2 columns">
		<input id="nom_field" name="nom" type="text" placeholder="Nom">
	</div>
	<div class="large-2 columns">
		<input id="code_postal" name="code_postal" type="number" placeholder="Code Postal">
	</div>
	<div class="large-2 columns">
		<input id="ville" name="ville" type="text" placeholder="Ville">
	</div>
	<div class="large-4 columns">
		<input id="caisse" name="caisse" type="text" placeholder="Caisse Obligatoire">
	</div>
</div>
<div class="row">
	<div class="large-4 columns">
		<input id="date_naissance" name="date_naissance" type="date" placeholder="Date de naissance YYYY-MM-DD">
	</div>
	<div class="large-4 columns">
		<input id="tel" name="tel" type="number" placeholder="Téléphone">
	</div>
	<div class="large-4 columns">
		<input id="mutuelle" name="mutuelle" type="text" placeholder="Mutuelle">
	</div>
</div>
<div class="row">
	<div class="large-4 push-4 columns">
		<input id="email" name="email" type="text" placeholder="E-mail">
	</div>
	<button type="submit" class="large-4 push-4 button alert tiny radius">Ajouter</button>
	
</div>
  
</form>

<script>

$(document).ready(function(){
	
	//Clear the form
	jQuery.fn.emptyMyForm = function(){
	    return this.each(function(){
			$('#no_client, #civilite, #prenom_field, #nom_field, #date_naissance, #adresse, #code_postal, #ville, #tel, #email, #no_insee, #caisse, #mutuelle').val('');
		});
	};
	$('#add-to-db').emptyMyForm();
	
	
	//Grab the table of suppliers by Ajax
	$('#ajax-load-list-clients').hide().load('ajax/afficher-clients.php').fadeIn();
	$('#add-to-db').on('submit',function(){
		$.ajax({
		  url:'ajax/inserer-client-ajax.php',
		  data:$(this).serialize(),
		  type:'POST',
		  success:function(data){
			  $('#outcome').prepend(data).fadeIn();
			  $('#ajax-load-list-clients').fadeOut().load('ajax/afficher-clients.php').fadeIn();
			  
		  	}
		});
		
		return false;
	});
});
	
	
	

</script>