<div class="row">
   
  <div class="large-10 push-3 columns">
	  <h1>Gestion des stocks</h1>
	  <p>Depuis cette interface vous pouvez gérer les stocks de médicaments de votre pharmacie.</p>
  </div>

</div>



<div class="row">

  <div class="large-12 columns">
	  <table>
		  <thead>
			  <tr>
				  <th>Nom du médicament</th>
				  <th>Générique</th>
				  <th>Agents actifs</th>
				  <th>Indications</th>
				  <th>Nom du fournisseur</th>
				  <th width="100">Prix</th>
				  <th>Stock</th>
				  <th>Commander</th>
			  </tr>
		  </thead>
		  <tbody id="ajax-load-list-med">
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
		  <input id="id_med_field" name="id_med" style="" type="text" placeholder="ID (10 chifres)">
	  </div>
	  <div class="large-4 columns">
		  <input id="equiv_generique" name="equiv_generique" type="text" placeholder="Générique"><br>
	  </div>
	  <div class="large-4 columns">
		  <select id="id_fournisseur" name="id_fournisseur">
			  <?php
			  $sql = 'SELECT `id_fournisseur`, `nom_fournisseur` FROM fournisseur';
			  foreach ($conn->query($sql) as $row) {
				  print '<option value="' . $row['id_fournisseur'] . '">' . $row['nom_fournisseur'] . '</option>'; // Fill out all fournisseurs in a drop-down
			  }
			  ?>
		  </select>
	  </div>
</div>
<div class="row">
	<div class="large-4 columns">
		<input id="nom_med_field" name="nom_med" style="" type="text" placeholder="Nom"><br>
	</div>
	<div class="large-4 columns">
		<input id="agents_actifs" name="agents_actifs" type="text" placeholder="Agent(s) Actif"><br>
	</div>
	<div class="large-2 columns">
		<div class="row collapse">
			<div class="small-9 columns">
				<input id="prix" name="prix" type="number" size="2" placeholder="Prix">
			</div>
			<div class="small-3 columns">
				<span class="postfix">€</span>
			</div>
		</div>
	</div>
	<div class="large-2 columns">
		<input id="stock" name="stock" type="number" size="2" placeholder="Stock">
	</div>
</div>
<div class="row">
	<div class="large-4 push-4 columns">
	    <input id="maladie_traitee" name="maladie_traitee" type="text" placeholder="Indications">
	</div>
	<button type="submit" class="large-4 columns button alert radius">Ajouter</button>
</div>
		
	  
	  
	  
	  
	  
	  
	  
	  
	
<script>

$(document).ready(function(){
	
	//Clear the form
	jQuery.fn.emptyMyForm = function(){
	    return this.each(function(){

					$('#id_med_field').show().val('');
					$('#nom_med_field').show().val('');
					$('#equiv_generique, #agents_actifs, #maladie_traitee, #prix, #id_fournisseur').val('');
				
		});
	};
	$('add-to-db').emptyMyForm();

	//Grab the table of medicines by Ajax
	$('#ajax-load-list-med').hide().load('ajax/afficher-medicaments.php').fadeIn();
	$('#add-to-db').on('submit',function(){
		$.ajax({
		  url:'ajax/inserer-medicament-ajax.php',
		  data:$(this).serialize(),
		  type:'POST',
		  success:function(data){
			  $('#outcome').prepend(data).fadeIn();
			  $('#ajax-load-list-med').fadeOut().load('ajax/afficher-medicaments.php').fadeIn();
			  
		  	}
		});
		
		return false;
	});
	
	
	
});
</script>