<div class="row">
   
  <div class="large-6 push-3 columns">
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
		  </tbody>  
		  <thead>
			  <th colspan="12" class="text-center">Ajouter un nouveau fournissseur</th>
		  </thead>
		  <tr>
			  <div id="outcome" data-alert class="alert-box" style="display: none;">
				  <a href="#" class="close">&times;</a>
			  </div>
		  </tr>
		  <tr>
			  <form id="add-to-db" method="POST">
				  <td><input id="id_fournisseur_field" name="id_fournisseur" type="text" placeholder="ID (10 caractères)"></td>
				  <td><input id="nom_fournisseur_field" name="nom_fournisseur" type="text" placeholder="Nom"></td>
				  <td><input id="personne_contact" name="personne_contact" type="text" placeholder="Personne à contacter"></td>
				  <td><input id="adresse" name="adresse" type="text" placeholder="Adresse"></td>
				  <td><input id="code_postal" name="code_postal" type="number" size="5" placeholder="Code Postal"></td>
				  <td><input id="ville" name="ville" type="text" placeholder="Ville"></td>
				  <td><input id="tel" name="tel" type="number" placeholder="Téléphone"></td>
				  <td><input id="email" name="email" type="text" placeholder="E-mail"></td>
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
			if ($(this).val() != " "){
					$('#id_fournisseur_field').show().val('');
					$('#nom_fournisseur_field').show().val('');
					$('#personne_contact, #adresse, #code_postal, #ville, #tel, #email').prop('disabled', false).val('');
				
				}
	    });
	};
	$('#nom_fournisseur_menu').emptyMyForm();
	$('#nom_fournisseur_menu').change(function(){
		$(this).emptyMyForm();
	})
	
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