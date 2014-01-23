<div class="row">
   
  <div class="large-6 push-3 columns">
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
				  <th>Adresse</th>
				  <th>Code Postal</th>
				  <th>Ville</th>
				  <th>Téléphone</th>
				  <th>E-mail</th>
				  <th>N° INSEE</th>
				  <th>CPAM</th>
				  <th>Mutuelle</th>
				  <th>Modifier</th>
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
		  <thead>
			  <th colspan="12" class="text-center">Ajouter un nouveau client</th>
		  </thead>
		  <tr>
			  <div id="outcome" data-alert class="alert-box" style="display: none;">
				  <a href="#" class="close">&times;</a>
			  </div>
		  </tr>
		  <tr>
			  <form id="add-to-db" method="POST">
				  <td><input id="no_client" name="no_client" type="text" placeholder="ID (10 caractères)"></td>
				  <td><input id="nom_field" name="nom" type="text" placeholder="Nom"></td>
				  <td><input id="prenom_field" name="prenom" type="text" placeholder="Prénom"></td>
				  <td><input id="date_naissance" name="date_naissance" type="text" placeholder="Date de naissance"></td>
				  <td><input id="adresse" name="adresse" type="text" placeholder="Adresse"></td>
				  <td><input id="code_postal" name="code_postal" type="number" placeholder="Code Postal"></td>
				  <td><input id="ville" name="ville" type="text" placeholder="Ville"></td>
				  <td><input id="tel" name="tel" type="number" placeholder="Téléphone"></td>
				  <td><input id="email" name="email" type="text" placeholder="E-mail"></td>
				  <td><input id="no_insee" name="no_insee" type="text" placeholder="N° INSEE"></td>
				  <td><input id="caisse" name="caisse" type="text" placeholder="CPAM"></td>
				  <td><input id="mutuelle" name="mutuelle" type="text" placeholder="Mutuelle"></td>
				  <td><button type="submit" class="button alert tiny radius">Ajouter</a></td>
			  </form>
		  </tr>
	  </table>
  </div>

</div>
<script>

$(document).ready(function(){
	
	//Clear the form
	jQuery.fn.emptyMyForm = function(){
	    return this.each(function(){
			$('#no_client, #nom_field, #prenom_field, #date_naissance, #adresse, #code_postal, #ville, #tel, #email, #no_insee, #caisse, #mutuelle').val('');
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